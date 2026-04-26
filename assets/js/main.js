/* Spark Fingerboards — main.js */

(function () {
  'use strict';

  // -----------------------------------------------
  // Helpers
  // -----------------------------------------------
  function lockScroll()   { document.body.style.overflow = 'hidden'; }
  function unlockScroll() { document.body.style.overflow = ''; }

  // -----------------------------------------------
  // Mobile Nav Drawer
  // -----------------------------------------------
  const navToggle   = document.querySelector('.nav-toggle');
  const navDrawer   = document.getElementById('nav-drawer');
  const navClose    = document.getElementById('nav-drawer-close');
  const navBackdrop = document.getElementById('nav-drawer-backdrop');

  function openNav() {
    navDrawer.classList.add('is-open');
    navDrawer.setAttribute('aria-hidden', 'false');
    navBackdrop.classList.add('is-visible');
    navToggle.setAttribute('aria-expanded', 'true');
    navToggle.classList.add('is-open');
    lockScroll();
  }

  function closeNav() {
    navDrawer.classList.remove('is-open');
    navDrawer.setAttribute('aria-hidden', 'true');
    navBackdrop.classList.remove('is-visible');
    navToggle.setAttribute('aria-expanded', 'false');
    navToggle.classList.remove('is-open');
    unlockScroll();
  }

  if (navToggle)   navToggle.addEventListener('click', openNav);
  if (navClose)    navClose.addEventListener('click', closeNav);
  if (navBackdrop) navBackdrop.addEventListener('click', closeNav);

  // -----------------------------------------------
  // Mini-cart Drawer
  // -----------------------------------------------
  const cartTrigger   = document.getElementById('mini-cart-trigger');
  const miniCart      = document.getElementById('mini-cart');
  const miniCartClose = document.getElementById('mini-cart-close');
  const cartBackdrop  = document.getElementById('mini-cart-backdrop');

  function openCart() {
    miniCart.classList.add('is-open');
    miniCart.setAttribute('aria-hidden', 'false');
    cartBackdrop.classList.add('is-visible');
    lockScroll();
  }

  function closeCart() {
    miniCart.classList.remove('is-open');
    miniCart.setAttribute('aria-hidden', 'true');
    cartBackdrop.classList.remove('is-visible');
    unlockScroll();
  }

  if (cartTrigger)   cartTrigger.addEventListener('click', openCart);
  if (miniCartClose) miniCartClose.addEventListener('click', closeCart);
  if (cartBackdrop)  cartBackdrop.addEventListener('click', closeCart);

  // Close drawers on Escape
  document.addEventListener('keydown', (e) => {
    if (e.key !== 'Escape') return;
    closeNav();
    closeCart();
  });

  // -----------------------------------------------
  // AJAX cart count + mini-cart refresh
  // -----------------------------------------------
  const cartCountBadge = document.getElementById('cart-count-badge');
  const miniCartBody   = document.getElementById('mini-cart-body');

  document.body.addEventListener('wc_fragments_refreshed', updateCartUI);
  document.body.addEventListener('wc_fragments_loaded',    updateCartUI);
  document.body.addEventListener('added_to_cart',  (e, fragments, hash, button) => {
    updateCartUI();
    openCart();
  });
  document.body.addEventListener('removed_from_cart', updateCartUI);

  function updateCartUI() {
    const count = parseInt(
      document.querySelector('.woocommerce-cart-form')?.dataset?.cartCount
      ?? cartCountBadge?.textContent ?? '0',
      10
    );

    if (!cartCountBadge) return;

    // WooCommerce updates fragments; just sync the badge from the updated mini-cart total
    const miniCartQtyEl = document.querySelector('.mini-cart__body .woocommerce-mini-cart-item');
    const items = document.querySelectorAll('.mini-cart__body .woocommerce-mini-cart-item');

    if (items.length > 0) {
      cartCountBadge.textContent = items.length;
      cartCountBadge.removeAttribute('hidden');
    } else {
      cartCountBadge.setAttribute('hidden', '');
    }
  }

  // -----------------------------------------------
  // Product gallery thumbnail switcher
  // -----------------------------------------------
  const mainImg = document.getElementById('sp-main-img');
  const thumbs  = document.querySelectorAll('.sp-thumb');

  thumbs.forEach((thumb) => {
    thumb.addEventListener('click', () => {
      if (!mainImg) return;
      mainImg.style.opacity = '0';
      setTimeout(() => {
        mainImg.src = thumb.dataset.full;
        mainImg.style.opacity = '1';
      }, 150);
      thumbs.forEach(t => t.classList.remove('is-active'));
      thumb.classList.add('is-active');
    });
  });

  if (thumbs.length) thumbs[0].classList.add('is-active');

  // -----------------------------------------------
  // Sticky header elevation on scroll
  // -----------------------------------------------
  const header = document.querySelector('.site-header');
  if (header) {
    const sentinel = document.createElement('div');
    sentinel.style.cssText = 'position:absolute;top:0;height:1px;width:1px;pointer-events:none;';
    document.body.prepend(sentinel);

    new IntersectionObserver(
      ([entry]) => header.classList.toggle('scrolled', !entry.isIntersecting)
    ).observe(sentinel);
  }

})();
