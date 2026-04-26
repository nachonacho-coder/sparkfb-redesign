/* Spark Fingerboards — main.js */

// Mobile nav toggle
(function () {
  const header = document.querySelector('.site-header');
  if (!header) return;

  // Add hamburger button for mobile
  const btn = document.createElement('button');
  btn.className = 'nav-toggle';
  btn.setAttribute('aria-label', 'Toggle menu');
  btn.innerHTML = `<span></span><span></span><span></span>`;
  header.querySelector('.header-inner').appendChild(btn);

  const nav = document.querySelector('.site-nav');
  btn.addEventListener('click', () => {
    const open = nav.classList.toggle('is-open');
    btn.setAttribute('aria-expanded', open);
  });
})();

// Sticky header shadow on scroll
(function () {
  const header = document.querySelector('.site-header');
  if (!header) return;

  const observer = new IntersectionObserver(
    ([entry]) => header.classList.toggle('scrolled', !entry.isIntersecting),
    { rootMargin: '-1px 0px 0px 0px', threshold: 0 }
  );

  const sentinel = document.createElement('div');
  document.body.prepend(sentinel);
  observer.observe(sentinel);
})();
