import { test, expect } from '@playwright/test';
import { loginAsAdmin, hasAppError } from './helpers';

test.describe('Admin Web (CMS)', () => {
  test.beforeEach(async ({ page }) => {
    await loginAsAdmin(page);
  });

  test('Admin dashboard loads', async ({ page }) => {
    await page.goto('/dashboard');
    expect(await hasAppError(page)).toBe(false);
    await expect(page.locator('body')).toBeVisible();
  });

  test('Berita (posts) list loads', async ({ page }) => {
    await page.goto('/dashboard/posts');
    expect(await hasAppError(page)).toBe(false);
  });

  test('Create berita form loads', async ({ page }) => {
    await page.goto('/dashboard/posts/create');
    expect(await hasAppError(page)).toBe(false);
    await expect(page.locator('input[name="title"]')).toBeVisible();
  });

  test('Categories list loads', async ({ page }) => {
    await page.goto('/dashboard/categories');
    expect(await hasAppError(page)).toBe(false);
  });

  test('Galeri foto-video list loads', async ({ page }) => {
    await page.goto('/dashboard/galeri/foto-video');
    expect(await hasAppError(page)).toBe(false);
  });

  test('Create galeri form loads', async ({ page }) => {
    await page.goto('/dashboard/galeri/foto-video/create');
    expect(await hasAppError(page)).toBe(false);
  });

  test('Galeri video supports YouTube source and managed embed route', async ({ page }) => {
    const stamp = Date.now();
    const title = `Video Playwright ${stamp}`;
    const youtubeUrl = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ';

    await page.goto('/dashboard/galeri/foto-video/create?tab=video');
    expect(await hasAppError(page)).toBe(false);

    await page.locator('input[name="title"]').fill(title);
    await page.locator('select[name="category"]').selectOption('Publikasi');
    await page.locator('select[name="source_type"]').selectOption('youtube');
    await page.locator('input[name="source_url"]').fill(youtubeUrl);
    await page.getByRole('button', { name: 'Simpan' }).click();

    await expect(page.locator('body')).toContainText('Berhasil menambahkan Data');
    const card = page.locator('.btr-gallery-card', { hasText: title }).first();
    await expect(card).toBeVisible();
    await expect(card).toContainText('Publikasi');
    await expect(card).toContainText('YouTube');

    await card.locator('a[title="Lihat"]').click();
    await expect(page.locator('body')).toContainText('Copy Embed');

    const embedRoute = await page.locator('text=/\\/video\\/embed\\//').first().textContent();
    expect(embedRoute).toBeTruthy();

    await page.goto('/video?search=' + encodeURIComponent(title));
    expect(await hasAppError(page)).toBe(false);
    await expect(page.locator('body')).toContainText(title);

    await page.goto((embedRoute || '').trim());
    expect(await hasAppError(page)).toBe(false);
    await expect(page.locator('iframe, video')).toBeVisible();

    await page.goto('/dashboard/galeri/foto-video?tab=video&search=' + encodeURIComponent(title));
    const deleteCard = page.locator('.btr-gallery-card', { hasText: title }).first();
    page.once('dialog', dialog => dialog.accept());
    await deleteCard.locator('button[title="Hapus"]').click();
    await expect(page.locator('body')).toContainText('Data berhasil dihapus!');
  });

  test('Karya Ilmiah (Renstra) list loads', async ({ page }) => {
    await page.goto('/dashboard/karya-ilmiah');
    expect(await hasAppError(page)).toBe(false);
  });

  test('Info Pegawai list loads', async ({ page }) => {
    await page.goto('/dashboard/info-pegawai');
    expect(await hasAppError(page)).toBe(false);
  });

  test('Fasilitas Balai list loads', async ({ page }) => {
    await page.goto('/dashboard/fasilitas-balai');
    expect(await hasAppError(page)).toBe(false);
  });

  test('Struktur Organisasi list loads', async ({ page }) => {
    await page.goto('/dashboard/struktur-organisasi');
    expect(await hasAppError(page)).toBe(false);
  });

  test('Profil Singkat edit loads', async ({ page }) => {
    await page.goto('/dashboard/profil-singkat');
    expect(await hasAppError(page)).toBe(false);
  });

  test('Footer Setting loads', async ({ page }) => {
    await page.goto('/dashboard/footer-setting');
    expect(await hasAppError(page)).toBe(false);
  });

  test('Landing Page list loads', async ({ page }) => {
    await page.goto('/dashboard/landing-page');
    expect(await hasAppError(page)).toBe(false);
  });

  test('Foto Home management loads', async ({ page }) => {
    await page.goto('/dashboard/foto-home');
    expect(await hasAppError(page)).toBe(false);
  });

  test('URL Layanan list loads', async ({ page }) => {
    await page.goto('/dashboard/url-layanan');
    expect(await hasAppError(page)).toBe(false);
  });

  test('Situs Terkait list loads', async ({ page }) => {
    await page.goto('/dashboard/situs-terkait');
    expect(await hasAppError(page)).toBe(false);
  });

  test('PPID admin page loads', async ({ page }) => {
    await page.goto('/dashboard/ppid');
    expect(await hasAppError(page)).toBe(false);
    await expect(page.getByRole('heading', { name: /Publikasi - PPID/i })).toBeVisible();
    await expect(page.locator('input[name="title"]').first()).toBeVisible();
    await expect(page.locator('.jodit-container').first()).toBeVisible();
  });

  test('Pengumuman list loads', async ({ page }) => {
    await page.goto('/dashboard/pengumuman');
    expect(await hasAppError(page)).toBe(false);
  });

  test('Pengumuman admin attachment opens in modal', async ({ page }) => {
    await page.goto('/dashboard/pengumuman');
    expect(await hasAppError(page)).toBe(false);

    const previewButton = page.getByRole('button', { name: 'Lihat' }).first();
    await expect(previewButton).toBeVisible();
    await previewButton.click();

    await expect(page.locator('#pengumuman-preview-modal')).toBeVisible();
    await expect(page.locator('text=Buka File')).toBeVisible();
  });

  test('Create Pengumuman form loads', async ({ page }) => {
    await page.goto('/dashboard/pengumuman/create');
    expect(await hasAppError(page)).toBe(false);
    await expect(page.locator('input[name="judul"]')).toBeVisible();
    await expect(page.locator('.jodit-wysiwyg').first()).toBeVisible();
  });

  test('Pengumuman create and delete flow works', async ({ page }) => {
    const stamp = Date.now();
    const title = `Pengumuman Playwright ${stamp}`;

    await page.goto('/dashboard/pengumuman/create');
    expect(await hasAppError(page)).toBe(false);

    await page.locator('input[name="judul"]').fill(title);
    await page.evaluate((html) => {
      const textarea = document.querySelector('#isi') as HTMLTextAreaElement | null;
      const wysiwyg = document.querySelector('.jodit-wysiwyg') as HTMLElement | null;
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
    }, '<p>Pengumuman uji otomatis untuk verifikasi CRUD.</p>');
    await page.getByRole('button', { name: 'Simpan' }).click();

    await expect(page.locator('body')).toContainText('Pengumuman berhasil dibuat.');
    await expect(page.locator('body')).toContainText(title);

    page.once('dialog', dialog => dialog.accept());
    await page.locator('tr', { hasText: title }).locator('button[type="submit"]').click();

    await expect(page.locator('body')).toContainText('Pengumuman berhasil dihapus.');
    await expect(page.locator('body')).not.toContainText(title);
  });

  test('Hak Akses (RBAC) page loads', async ({ page }) => {
    await page.goto('/dashboard/hak-akses');
    expect(await hasAppError(page)).toBe(false);
  });

  test('Master Tim list loads', async ({ page }) => {
    await page.goto('/dashboard/master-tim');
    expect(await hasAppError(page)).toBe(false);
  });

  test('Create Master Tim form loads', async ({ page }) => {
    await page.goto('/dashboard/master-tim/create');
    expect(await hasAppError(page)).toBe(false);
  });

  test('Master Survei page loads with inline form', async ({ page }) => {
    await page.goto('/dashboard/master-survei');
    expect(await hasAppError(page)).toBe(false);
  });

  test('Master Survei create and delete flow works', async ({ page }) => {
    const stamp = Date.now();
    const unsur = `Unsur Uji ${stamp}`;
    const question = `Pertanyaan survei otomatis ${stamp}?`;

    await page.goto('/dashboard/master-survei');
    expect(await hasAppError(page)).toBe(false);

    const createForm = page.locator('form').filter({ has: page.locator('input[name="unsur"][type="text"]') }).first();

    await createForm.locator('input[name="unsur"][type="text"]').fill(unsur);
    await createForm.locator('input[name="pertanyaan"]').fill(question);
    await createForm.locator('input[name="urutan"]').fill('99');
    await page.getByRole('button', { name: 'Tambah' }).click();

    await expect(page.locator('body')).toContainText('Pertanyaan survei berhasil ditambahkan.');
    await expect(page.locator('body')).toContainText(question);

    const row = page.locator('tr', { hasText: question });
    page.once('dialog', dialog => dialog.accept());
    await row.locator('button[type="submit"]').last().click();

    await expect(page.locator('body')).toContainText('Pertanyaan survei berhasil dihapus.');
  });

  test('Settings page loads', async ({ page }) => {
    await page.goto('/dashboard/settings');
    expect(await hasAppError(page)).toBe(false);
  });
});
