import { test, expect } from '@playwright/test';
import fs from 'fs/promises';
import path from 'path';
import { loginAsAdmin, hasAppError } from './helpers';

test.describe('Pengumuman Jodit', () => {
  test('Admin can create rich pengumuman with embedded image and public page renders it', async ({ page }) => {
    test.setTimeout(120000);

    const stamp = Date.now();
    const title = `Pengumuman Jodit ${stamp}`;
    const bodyText = `Isi rich pengumuman otomatis ${stamp}`;
    const imagePath = path.resolve('public/assets/add.png');
    const imageBuffer = await fs.readFile(imagePath);

    await loginAsAdmin(page);
    await page.goto('/dashboard/pengumuman/create');
    expect(await hasAppError(page)).toBe(false);

    await page.locator('input[name="judul"]').fill(title);

    const editor = page.locator('.jodit-wysiwyg').first();
    await expect(editor).toBeVisible();
    const csrfToken = await page.locator('form input[name="_token"]').first().getAttribute('value');
    const uploadResult = await page.evaluate(async ({ token, bytes }) => {
      const formData = new FormData();
      const file = new File([new Uint8Array(bytes)], 'add.png', { type: 'image/png' });
      formData.append('file', file);

      const response = await fetch('/dashboard/pengumuman/attachment', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': token,
        },
        body: formData,
        credentials: 'same-origin',
      });

      const text = await response.text();

      return {
        ok: response.ok,
        status: response.status,
        text,
      };
    }, {
      token: csrfToken ?? '',
      bytes: Array.from(imageBuffer),
    });

    expect(uploadResult.ok).toBe(true);
    const uploadJson = JSON.parse(uploadResult.text);
    expect(uploadJson.url).toBeTruthy();

    const richHtml = `<p>${bodyText}</p><p><img src="${uploadJson.url}" alt="playwright-pengumuman-image"></p>`;
    await page.evaluate((html) => {
      const textarea = document.querySelector<HTMLTextAreaElement>('#isi');
      const wysiwyg = document.querySelector<HTMLElement>('.jodit-wysiwyg');
      const instances = (window as unknown as { Jodit?: { instances?: Record<string, { value: string }> } }).Jodit?.instances ?? {};
      const instance = Object.values(instances)[0];

      if (instance) {
        instance.value = html;
      }

      if (wysiwyg) {
        wysiwyg.innerHTML = html;
      }

      if (textarea) {
        textarea.value = html;
      }
    }, richHtml);

    await expect(editor.locator('img')).toHaveCount(1);

    await page.getByRole('button', { name: 'Simpan' }).click();
    await expect(page.locator('body')).toContainText('Pengumuman berhasil dibuat.');
    await expect(page.locator('body')).toContainText(title);

    await page.goto(`/pengumuman?search=${encodeURIComponent(title)}`);
    expect(await hasAppError(page)).toBe(false);
    await expect(page.locator('body')).toContainText(title);

    const publicLink = page.locator('a[href*="/pengumuman/"]:not([href*="/dashboard/"])').first();
    await expect(publicLink).toBeVisible();
    const href = await publicLink.getAttribute('href');
    expect(href).toBeTruthy();

    await page.goto(href!);
    expect(await hasAppError(page)).toBe(false);
    await expect(page.locator('h1')).toContainText(title);
    await expect(page.locator('.prose')).toContainText(bodyText);
    await expect(page.locator('.prose img')).toHaveCount(1);

    await loginAsAdmin(page);
    await page.goto('/dashboard/pengumuman');
    const row = page.locator('tr', { hasText: title });
    page.once('dialog', dialog => dialog.accept());
    await row.locator('button[type="submit"]').click();
    await expect(page.locator('body')).toContainText('Pengumuman berhasil dihapus.');
  });
});
