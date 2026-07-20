import { test, expect } from '@playwright/test';

test.beforeEach(async ({ page }) => {
  page.on('console', msg => {
    if (msg.type() === 'error') console.log(`[console error] ${msg.text()}`);
  });
});

test('homepage loads, no horizontal overflow', async ({ page }) => {
  await page.goto('/');
  await expect(page).toHaveTitle(/.+/);
  const bodyWidth = await page.evaluate(() => document.body.scrollWidth);
  const viewportWidth = await page.evaluate(() => window.innerWidth);
  expect(bodyWidth).toBeLessThanOrEqual(viewportWidth + 5);
});

test('header visible', async ({ page }) => {
  await page.goto('/');
  await expect(page.locator('header')).toBeVisible();
});

test('footer visible', async ({ page }) => {
  await page.goto('/');
  await expect(page.locator('footer')).toBeVisible();
});

test('shop page renders', async ({ page }) => {
  await page.goto('/tienda/');
  await expect(page.locator('.shop-card, .shop-grid').first()).toBeVisible();
});

test('single post/page renders', async ({ page }) => {
  await page.goto('/');
  const link = page.locator('a[href*="/product/"], a[href*="/shop/"]').first();
  if (await link.count() > 0) {
    await link.click();
    await expect(page.locator('h1, .entry-title')).toBeVisible();
  }
});

test('404 renders', async ({ page }) => {
  const response = await page.goto('/pagina-no-existe-xyz/');
  expect(response?.status()).toBe(404);
  await expect(page.locator('body')).toBeVisible();
});
