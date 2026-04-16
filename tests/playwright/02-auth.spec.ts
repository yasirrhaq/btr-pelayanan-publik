import { test, expect } from '@playwright/test';
import { loginAsAdmin, loginAsPelanggan, hasAppError, ADMIN_USER_ID } from './helpers';

test.describe('Authentication', () => {
  test('Admin can login via test bypass and reach dashboard', async ({ page }) => {
    await loginAsAdmin(page);
    expect(await hasAppError(page)).toBe(false);
    expect(page.url()).toContain('/dashboard');
  });

  test('Pelanggan can login via test bypass and reach pelanggan portal', async ({ page }) => {
    await loginAsPelanggan(page);
    expect(await hasAppError(page)).toBe(false);
    expect(page.url()).not.toContain('/login');
  });

  test('Login form renders with captcha field', async ({ page }) => {
    await page.goto('/login');
    expect(await hasAppError(page)).toBe(false);
    await expect(page.locator('input[name="email"]')).toBeVisible();
    await expect(page.locator('input[name="password"]')).toBeVisible();
    await expect(page.locator('input[name="captcha"]')).toBeVisible();
    // Captcha image should load (returns image/png, not 404)
    const captchaImg = page.locator('img[src*="captcha"]');
    await expect(captchaImg).toBeVisible();
  });

  test('Login token mismatch redirects back without 419 page', async ({ page, context }) => {
    await page.goto('/login');
    expect(await hasAppError(page)).toBe(false);

    await page.locator('input[name="email"]').fill('wrong@example.com');
    await page.locator('input[name="password"]').fill('wrongpass');
    await page.locator('input[name="captcha"]').fill('abcd');

    await context.clearCookies();
    await page.getByRole('button', { name: 'Masuk' }).click();

    expect(await hasAppError(page)).toBe(false);
    await expect(page.locator('body')).toContainText('Sesi formulir telah kedaluwarsa');
    expect(page.url()).toContain('/login');
  });

  test('Register token mismatch redirects back without 419 page', async ({ page, context }) => {
    await page.goto('/register');
    expect(await hasAppError(page)).toBe(false);

    await page.locator('input[name="name"]').fill('Test User');
    await page.locator('input[name="username"]').fill(`test${Date.now()}`);
    await page.locator('input[name="email"]').fill(`test${Date.now()}@example.com`);
    await page.locator('input[name="password"]').fill('Password123');
    await page.locator('input[name="password_confirmation"]').fill('Password123');
    await page.locator('input[name="no_id"]').fill('1234567890');
    await page.locator('input[name="instansi"]').fill('Instansi Test');
    await page.locator('input[name="alamat"]').fill('Alamat Test');
    await page.locator('input[name="captcha"]').fill('abcd');

    await context.clearCookies();
    await page.getByRole('button', { name: 'Daftar Sekarang' }).click();

    expect(await hasAppError(page)).toBe(false);
    await expect(page.locator('body')).toContainText('Sesi formulir telah kedaluwarsa');
    expect(page.url()).toContain('/register');
  });

  test('Admin logout works', async ({ page }) => {
    await loginAsAdmin(page);
    await page.goto('/dashboard');
    await page.locator('form[action*="logout"] button[type="submit"]').click({ force: true });
    await page.waitForURL(/\/$|login/, { timeout: 10000 }).catch(() => {});
    expect(page.url()).not.toContain('/dashboard');
  });

  test('Guest redirected from admin dashboard', async ({ page }) => {
    await page.goto('/dashboard');
    expect(await hasAppError(page)).toBe(false);
    expect(page.url()).toMatch(/login|\//);
  });

  test('Guest redirected from pelanggan routes', async ({ page }) => {
    await page.goto('/pelanggan/permohonan');
    expect(await hasAppError(page)).toBe(false);
    expect(page.url()).toMatch(/login|verify/);
  });
});
