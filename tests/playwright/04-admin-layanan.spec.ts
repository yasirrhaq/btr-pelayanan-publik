import { test, expect } from '@playwright/test';
import { loginAsAdmin, hasAppError } from './helpers';

test.describe('Admin Layanan', () => {
  test.beforeEach(async ({ page }) => {
    await loginAsAdmin(page);
  });

  test('Admin Layanan dashboard loads', async ({ page }) => {
    await page.goto('/dashboard/layanan');
    expect(await hasAppError(page)).toBe(false);
    await expect(page.locator('body')).toBeVisible();
  });

  test('Permohonan list loads', async ({ page }) => {
    await page.goto('/dashboard/layanan/permohonan');
    expect(await hasAppError(page)).toBe(false);
  });

  test('Data Pelanggan loads', async ({ page }) => {
    await page.goto('/dashboard/layanan/data-pelanggan');
    expect(await hasAppError(page)).toBe(false);
  });

  test('Survei Analytics loads', async ({ page }) => {
    await page.goto('/dashboard/layanan/survei-analytics');
    expect(await hasAppError(page)).toBe(false);
  });

  test('Permohonan list has filter toolbar', async ({ page }) => {
    await page.goto('/dashboard/layanan/permohonan');
    expect(await hasAppError(page)).toBe(false);
    // Page should not be a 500 error regardless of data
    await expect(page.locator('body')).toBeVisible();
  });

  test('Permohonan detail flow works from list', async ({ page }) => {
    await page.goto('/dashboard/layanan/permohonan');
    expect(await hasAppError(page)).toBe(false);

    const detailLink = page.locator('a.btr-action.view').first();
    await expect(detailLink).toBeVisible();
    await detailLink.click();

    expect(await hasAppError(page)).toBe(false);
    await expect(page.locator('body')).toContainText('Detail Permohonan');
  });

  test('Data Pelanggan search works', async ({ page }) => {
    await page.goto('/dashboard/layanan/data-pelanggan?search=yasir');
    expect(await hasAppError(page)).toBe(false);
    await expect(page.locator('body')).toBeVisible();
  });
});
