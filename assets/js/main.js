/* Spark Fingerboards — main.js */

(function () {
  'use strict';

  // -----------------------------------------------
  // Loader (solo en la primera visita de la sesión)
  // -----------------------------------------------
  const loader = document.getElementById('spark-loader');
  if (loader) {
    if (sessionStorage.getItem('sparkfb_loaded')) {
      loader.remove();
    } else {
      var startTime = Date.now();
      window.addEventListener('load', function () {
        var delay = Math.max(0, 1000 - (Date.now() - startTime));
        setTimeout(function () {
          loader.classList.add('done');
          setTimeout(function () { loader.remove(); }, 500);
        }, delay);
      });
      sessionStorage.setItem('sparkfb_loaded', '1');
    }
  }

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

  // Mobile nav drawer: category accordion (only one submenu open at a time)
  if (navDrawer) {
    navDrawer.querySelectorAll('.nav-drawer__cat-toggle').forEach(function (toggle) {
      toggle.addEventListener('click', function () {
        var item = toggle.closest('.nav-drawer__cat');
        var isOpen = item.classList.contains('is-open');

        navDrawer.querySelectorAll('.nav-drawer__cat.is-open').forEach(function (openItem) {
          if (openItem !== item) {
            openItem.classList.remove('is-open');
            openItem.querySelector('.nav-drawer__cat-toggle').setAttribute('aria-expanded', 'false');
          }
        });

        item.classList.toggle('is-open', !isOpen);
        toggle.setAttribute('aria-expanded', String(!isOpen));
      });
    });
  }

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

  // -----------------------------------------------
  // Location dropdown
  // -----------------------------------------------
  const locToggle = document.getElementById('loc-toggle');
  const locMenu   = document.getElementById('loc-menu');

  if (locToggle && locMenu) {
    locToggle.addEventListener('click', (e) => {
      e.stopPropagation();
      const open = !locMenu.hidden;
      locMenu.hidden = open;
      locToggle.setAttribute('aria-expanded', String(!open));
    });
  }

  // -----------------------------------------------
  // Live Search
  // -----------------------------------------------
  const searchTrigger  = document.getElementById('search-trigger');
  const searchDropdown = document.getElementById('search-dropdown');
  const searchLiveInput = document.getElementById('search-live-input');
  const searchResults  = document.getElementById('search-results');

  let searchTimer = null;

  function openSearch() {
    if (!searchDropdown) return;
    searchDropdown.hidden = false;
    searchTrigger?.setAttribute('aria-expanded', 'true');
    setTimeout(() => searchLiveInput?.focus(), 30);
  }

  function closeSearch() {
    if (!searchDropdown) return;
    searchDropdown.hidden = true;
    searchTrigger?.setAttribute('aria-expanded', 'false');
    if (searchLiveInput) searchLiveInput.value = '';
    if (searchResults)   searchResults.innerHTML = '';
  }

  function renderResults(results) {
    if (!searchResults) return;
    if (!results.length) {
      searchResults.innerHTML = '<p class="search-no-results">Sin resultados</p>';
      return;
    }
    searchResults.innerHTML = results.map(r => `
      <a href="${r.url}" class="search-result">
        <img src="${r.img}" alt="${r.name}" class="search-result__img" loading="lazy">
        <div>
          <span class="search-result__name">${r.name}</span>
          <span class="search-result__price">${r.price}</span>
        </div>
      </a>
    `).join('');
  }

  if (searchLiveInput) {
    searchLiveInput.addEventListener('input', () => {
      clearTimeout(searchTimer);
      const q = searchLiveInput.value.trim();
      if (q.length < 2) { if (searchResults) searchResults.innerHTML = ''; return; }
      searchTimer = setTimeout(() => {
        const url = (window.sparkfbData?.ajaxUrl || '/wp-admin/admin-ajax.php')
          + '?action=sparkfb_search&q=' + encodeURIComponent(q);
        fetch(url).then(r => r.json()).then(renderResults).catch(() => {});
      }, 300);
    });
  }

  if (searchTrigger) searchTrigger.addEventListener('click', (e) => {
    e.stopPropagation();
    searchDropdown?.hidden ? openSearch() : closeSearch();
  });

  // Click fuera cierra ambos dropdowns
  document.addEventListener('click', (e) => {
    if (locMenu && !locMenu.hidden && !locToggle?.contains(e.target)) {
      locMenu.hidden = true;
      locToggle?.setAttribute('aria-expanded', 'false');
    }
    if (searchDropdown && !searchDropdown.hidden &&
        !searchTrigger?.contains(e.target) && !searchDropdown.contains(e.target)) {
      closeSearch();
    }
  });

  // Close drawers on Escape
  document.addEventListener('keydown', (e) => {
    if (e.key !== 'Escape') return;
    closeNav();
    closeCart();
    closeSearch();
    if (locMenu) { locMenu.hidden = true; locToggle?.setAttribute('aria-expanded', 'false'); }
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
    if (!cartCountBadge) return;

    // WooCommerce updates fragments; sync badge from updated mini-cart
    const items = document.querySelectorAll('.mini-cart__body .woocommerce-mini-cart-item');

    if (items.length > 0) {
      cartCountBadge.textContent = items.length;
      cartCountBadge.removeAttribute('hidden');
    } else {
      cartCountBadge.setAttribute('hidden', '');
    }
  }

  // -----------------------------------------------
  // Product gallery slideshow
  // -----------------------------------------------
  const galleryMain = document.getElementById('sp-gallery-main');
  const mainImg     = document.getElementById('sp-main-img');

  if (galleryMain && mainImg) {
    const imgsAttr = galleryMain.dataset.imgs;
    const imgs = imgsAttr ? JSON.parse(imgsAttr) : [];

    if (imgs.length > 1) {
      let current = 0;
      let timer;

      function showImg(idx) {
        current = (idx + imgs.length) % imgs.length;
        if (!imgs[current]) return;
        mainImg.style.opacity = '0';
        setTimeout(function () {
          mainImg.src = imgs[current];
          mainImg.style.opacity = '1';
        }, 150);
      }

      function startTimer() {
        clearInterval(timer);
        timer = setInterval(function () { showImg(current + 1); }, 4000);
      }

      var prevBtn = galleryMain.querySelector('.sp-gallery-btn--prev');
      var nextBtn = galleryMain.querySelector('.sp-gallery-btn--next');

      if (prevBtn) prevBtn.addEventListener('click', function () { showImg(current - 1); startTimer(); });
      if (nextBtn) nextBtn.addEventListener('click', function () { showImg(current + 1); startTimer(); });

      startTimer();
    }
  }

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

function sparkCarousel(id, dir) {
  var el = document.getElementById(id);
  if (!el) return;
  el.scrollBy({ left: dir * el.offsetWidth, behavior: 'smooth' });
}
