(function () {
  'use strict';

  var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  document.addEventListener('DOMContentLoaded', function () {

    /* 1. SCROLL REVEAL (otomatis, tidak perlu tambah class di HTML) */
    var auto = document.querySelectorAll(
      '.program-card, .info-card, .gallery-item, .stat-item, .feature-item, .fac-list, .fac-cta, .cta-band, .section-title'
    );
    auto.forEach(function (el) {
      if (el.getBoundingClientRect().top < window.innerHeight - 40) return;
      el.classList.add('reveal');
    });

    var items = document.querySelectorAll('.reveal');
    if (!('IntersectionObserver' in window) || reduceMotion) {
      items.forEach(function (el) { el.classList.add('visible'); });
    } else {
      var groups = new Map();
      items.forEach(function (el) {
        var n = groups.get(el.parentElement) || 0;
        el.style.setProperty('--d', (n % 4) * 0.08 + 's');
        groups.set(el.parentElement, n + 1);
      });
      var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            io.unobserve(entry.target);
          }
        });
      }, { threshold: 0.12 });
      items.forEach(function (el) { io.observe(el); });
    }

    /* 2. HITUNG NAIK ANGKA STATISTIK */
    if (!reduceMotion && 'IntersectionObserver' in window) {
      var nums = document.querySelectorAll('.stat-num');
      var ioNum = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) return;
          var el = entry.target;
          ioNum.unobserve(el);
          var target = parseInt(el.getAttribute('data-target'), 10);
          var start = null;
          function step(ts) {
            if (start === null) start = ts;
            var p = Math.min((ts - start) / 1000, 1);
            var eased = 1 - Math.pow(1 - p, 3);
            el.textContent = Math.round(target * eased);
            if (p < 1) requestAnimationFrame(step);
          }
          requestAnimationFrame(step);
        });
      }, { threshold: 0.6 });
      nums.forEach(function (el) {
        var txt = el.textContent.trim();
        if (!/^\d+$/.test(txt)) return;
        el.setAttribute('data-target', txt);
        ioNum.observe(el);
      });
    }
  });

  /* 3. RIPPLE: riak air saat tombol disentuh / diklik */
  document.addEventListener('pointerdown', function (e) {
    if (reduceMotion) return;
    var btn = e.target.closest('.btn, .ppdb-btn');
    if (!btn) return;
    var r = btn.getBoundingClientRect();
    var size = Math.max(r.width, r.height) * 2;
    var s = document.createElement('span');
    s.className = 'ripple';
    s.style.width = s.style.height = size + 'px';
    s.style.left = (e.clientX - r.left - size / 2) + 'px';
    s.style.top = (e.clientY - r.top - size / 2) + 'px';
    btn.appendChild(s);
    setTimeout(function () { if (s.parentNode) s.parentNode.removeChild(s); }, 650);
  }, { passive: true });

  /* 4. CAHAYA MENGIKUTI JARI / KURSOR pada kartu */
  var glowSel = '.program-card, .info-card, .mitra-logo, .bkk-card';
  function setGlow(el, e) {
    var r = el.getBoundingClientRect();
    el.style.setProperty('--mx', (e.clientX - r.left) + 'px');
    el.style.setProperty('--my', (e.clientY - r.top) + 'px');
  }
  document.addEventListener('pointermove', function (e) {
    var el = e.target.closest(glowSel);
    if (el) setGlow(el, e);
  }, { passive: true });
  document.addEventListener('pointerdown', function (e) {
    var el = e.target.closest(glowSel);
    if (el) { setGlow(el, e); el.classList.add('touching'); }
    var mq = e.target.closest('.marquee');
    if (mq) mq.classList.add('paused');
  }, { passive: true });
  function lepas() {
    setTimeout(function () {
      document.querySelectorAll('.touching').forEach(function (el) { el.classList.remove('touching'); });
      document.querySelectorAll('.marquee.paused').forEach(function (el) { el.classList.remove('paused'); });
    }, 350);
  }
  document.addEventListener('pointerup', lepas, { passive: true });
  document.addEventListener('pointercancel', lepas, { passive: true });
})();
