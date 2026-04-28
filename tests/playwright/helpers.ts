import { Page } from '@playwright/test';

export const ADMIN_USER_ID = 1;    // baltekrawa1@gmail.com — admin-master
export const PELANGGAN_USER_ID = 1; // yasir.haq98@gmail.com — pelanggan

/**
 * Login via the test-only bypass route (/test-login/{userId}).
 * This route is only registered when APP_ENV=local, bypassing captcha entirely.
 */
async function testLogin(page: Page, userId: number) {
  await page.goto(`/test-login/${userId}`);
  // The route redirects to /dashboard (admin) or /pelanggan (pelanggan)
  await page.waitForURL((url) => !url.pathname.includes('/test-login'), { timeout: 15000 }).catch(() => {});
}

/** Login as admin (is_admin=1) and land on /dashboard */
export async function loginAsAdmin(page: Page) {
  await testLogin(page, ADMIN_USER_ID);
}

/** Login as pelanggan and land on /pelanggan */
export async function loginAsPelanggan(page: Page) {
  await testLogin(page, PELANGGAN_USER_ID);
}

/** Check if current page shows a known error (500, 404, Laravel exception) */
export async function hasAppError(page: Page): Promise<boolean> {
  const title = await page.title();
  const bodyText = await page.locator('body').innerText().catch(() => '');
  return (
    title.includes('500') ||
    title.includes('404') ||
    title.includes('Whoops') ||
    bodyText.includes('Symfony\\') ||
    bodyText.includes('ErrorException') ||
    bodyText.includes('SQLSTATE')
  );
}
