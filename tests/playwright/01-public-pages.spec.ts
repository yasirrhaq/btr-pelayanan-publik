import { test, expect } from '@playwright/test';
import { hasAppError } from './helpers';

test.describe('Public Pages', () => {
  test('Homepage loads with content', async ({ page }) => {
    await page.goto('/');
    expect(await hasAppError(page)).toBe(false);
    await expect(page).toHaveTitle(/.+/);
    // Check for main structural elements
    const body = page.locator('body');
    await expect(body).toBeVisible();
    await expect(page.locator('body')).toContainText('Pengumuman');
  });

  test('Berita (news) list page loads', async ({ page }) => {
    await page.goto('/berita');
    expect(await hasAppError(page)).toBe(false);
    await expect(page.locator('body')).toBeVisible();
  });

  test('Pengumuman list page loads', async ({ page }) => {
    await page.goto('/pengumuman');
    expect(await hasAppError(page)).toBe(false);
    await expect(page.locator('body')).toContainText('Pengumuman');
  });

  test('Pengumuman detail page loads', async ({ page }) => {
    await page.goto('/pengumuman/1');
    expect(await hasAppError(page)).toBe(false);
    await expect(page.locator('body')).toContainText('Jadwal Pemeliharaan Sistem Layanan Online');
  });

  test('Pengumuman public attachment opens in modal', async ({ page }) => {
    await page.goto('/pengumuman/1');
    expect(await hasAppError(page)).toBe(false);
    await page.getByRole('button', { name: 'Buka Lampiran' }).click();
    await expect(page.locator('text=Buka File')).toBeVisible();
  });

  test('Visi Misi page loads', async ({ page }) => {
    await page.goto('/visi-misi');
    expect(await hasAppError(page)).toBe(false);
  });

  test('Tugas page loads', async ({ page }) => {
    await page.goto('/tugas');
    expect(await hasAppError(page)).toBe(false);
  });

  test('Sejarah page loads', async ({ page }) => {
    await page.goto('/sejarah');
    expect(await hasAppError(page)).toBe(false);
  });

  test('Karya Ilmiah list page loads', async ({ page }) => {
    await page.goto('/karya-ilmiah');
    expect(await hasAppError(page)).toBe(false);
  });

  test('Struktur Organisasi page loads', async ({ page }) => {
    await page.goto('/struktur-organisasi');
    expect(await hasAppError(page)).toBe(false);
  });

  test('Info Pegawai page loads', async ({ page }) => {
    await page.goto('/info-pegawai');
    expect(await hasAppError(page)).toBe(false);
  });

  test('Fasilitas Balai page loads', async ({ page }) => {
    await page.goto('/fasilitas-balai');
    expect(await hasAppError(page)).toBe(false);
  });

  test('Galeri Foto page loads', async ({ page }) => {
    await page.goto('/foto');
    expect(await hasAppError(page)).toBe(false);
  });

  test('Galeri Video page loads', async ({ page }) => {
    await page.goto('/video');
    expect(await hasAppError(page)).toBe(false);
  });

  test('Dokumen public page loads', async ({ page }) => {
    await page.goto('/dokumen');
    expect(await hasAppError(page)).toBe(false);
    await expect(page.locator('body')).toBeVisible();
  });

  test('PPID index page loads', async ({ page }) => {
    await page.goto('/ppid');
    expect(await hasAppError(page)).toBe(false);
    await expect(page.locator('body')).toContainText('PPID');
  });

  test('PPID detail page loads with content', async ({ page }) => {
    await page.goto('/ppid/kebijakan-ppid');
    expect(await hasAppError(page)).toBe(false);
    await expect(page.locator('body')).not.toBeEmpty();
    await expect(page.locator('body')).toContainText(/PPID|Kebijakan/i);
  });

  test('Pengujian Laboratorium service page loads', async ({ page }) => {
    await page.goto('/pengujian-laboratorium', { waitUntil: 'domcontentloaded' });
    expect(await hasAppError(page)).toBe(false);
  });

  test('Advis Teknis service page loads', async ({ page }) => {
    await page.goto('/advis-teknis');
    expect(await hasAppError(page)).toBe(false);
  });

  test('Login page renders form', async ({ page }) => {
    await page.goto('/login');
    expect(await hasAppError(page)).toBe(false);
    await expect(page.locator('input[name="email"]')).toBeVisible();
    await expect(page.locator('input[name="password"]')).toBeVisible();
    await expect(page.locator('button[type="submit"]')).toBeVisible();
  });

  test('Register page renders form', async ({ page }) => {
    await page.goto('/register');
    expect(await hasAppError(page)).toBe(false);
    await expect(page.locator('input[name="email"]')).toBeVisible();
    await expect(page.locator('input[name="password"]')).toBeVisible();
  });

  test('Unauthenticated access to dashboard redirects to login', async ({ page }) => {
    await page.goto('/dashboard');
    // Should redirect to login or home (not 500)
    expect(await hasAppError(page)).toBe(false);
    const url = page.url();
    expect(url).toMatch(/login|\/$/);
  });

  test('Unauthenticated access to pelanggan portal redirects', async ({ page }) => {
    await page.goto('/pelanggan');
    expect(await hasAppError(page)).toBe(false);
    const url = page.url();
    expect(url).toMatch(/login|verify/);
  });
});
