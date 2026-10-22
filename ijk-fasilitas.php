<?php
require_once __DIR__ . '/includes/ijk-functions.php';
$db = getDB();

try {
    $fasilitas = $db->query("SELECT id, nama, icon, gambar FROM fasilitas ORDER BY id DESC")->fetchAll();
} catch (PDOException $e) {
    $fasilitas = [];
}

/* Foto fasilitas disimpan admin langsung di folder uploads/ (bukan subfolder) */
function fasFoto($nama) {
    $nama = (string)$nama;
    if ($nama === '' || basename($nama) !== $nama) return null;
    if (!is_file(__DIR__ . '/uploads/' . $nama)) return null;
    return BASE_URL . 'uploads/' . rawurlencode($nama);
}

/* Ikon boleh ditulis "fa-computer", "computer", atau "fa-solid fa-computer" */
function fasIkon($raw) {
    $ic = trim((string)$raw);
    $ic = preg_replace('/^(fa-solid|fas|fa)\s+/i', '', $ic);
    $ic = preg_replace('/^fa-/i', '', $ic);
    if ($ic === '' || !preg_match('/^[a-z0-9-]+$/i', $ic)) return 'building';
    return $ic;
}

require_once __DIR__ . '/includes/ijk-header.php';
?>
<style>
.fas-section{padding:56px 0 80px;}
.fas-intro{color:var(--gray);max-width:720px;line-height:1.8;margin:6px 0 32px;}
.fas-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:22px;}
.fas-empty{padding:40px 20px;text-align:center;color:var(--gray);background:var(--light);border-radius:16px;}

.js .fas-card:not(.is-in){opacity:0;}
.js .fas-card.is-in{animation:fasUp .7s cubic-bezier(.2,.7,.2,1) backwards;animation-delay:var(--d,0s);}
@keyframes fasUp{from{opacity:0;transform:translateY(26px);}to{opacity:1;transform:none;}}

.fas-card{background:#fff;border:1px solid var(--border);border-radius:18px;overflow:hidden;transition:transform .25s ease,box-shadow .3s ease,border-color .3s ease;-webkit-tap-highlight-color:transparent;}
@media (hover:hover){.fas-card:hover{transform:translateY(-6px);box-shadow:0 22px 44px -16px rgba(11,21,51,.28);border-color:transparent;}}
.fas-card:active{transform:scale(.97);}

.fas-media{position:relative;height:180px;background:linear-gradient(135deg,#0b1533,#1c3270);}
.fas-photo{display:block;width:100%;height:100%;padding:0;border:0;cursor:zoom-in;background:none;position:relative;overflow:hidden;}
.fas-photo img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .6s ease;}
@media (hover:hover){.fas-card:hover .fas-photo img{transform:scale(1.08);}}
.fas-zoom{position:absolute;right:12px;top:12px;width:36px;height:36px;border-radius:50%;background:rgba(255,255,255,.92);color:var(--navy);display:flex;align-items:center;justify-content:center;font-size:14px;opacity:0;transform:scale(.8);transition:opacity .25s ease,transform .25s ease;}
@media (hover:hover){.fas-card:hover .fas-zoom{opacity:1;transform:none;}}
@media (hover:none){.fas-zoom{opacity:1;transform:none;}}
.fas-noimg{height:100%;display:flex;align-items:center;justify-content:center;color:var(--gold);font-size:46px;}

.fas-icon{position:absolute;left:18px;bottom:-22px;width:46px;height:46px;border-radius:14px;background:var(--gold);color:var(--navy);display:flex;align-items:center;justify-content:center;font-size:18px;box-shadow:0 10px 20px -8px rgba(245,180,0,.8);z-index:2;transition:transform .3s ease;}
@media (hover:hover){.fas-card:hover .fas-icon{transform:rotate(-8deg) scale(1.1);}}
.fas-body{padding:34px 20px 20px;}
.fas-card.no-photo .fas-body{padding-top:18px;}
.fas-body h3{font-size:17px;color:var(--navy);line-height:1.35;}

.fas-lightbox{position:fixed;inset:0;z-index:500;background:rgba(7,12,28,.9);display:flex;flex-direction:column;align-items:center;justify-content:center;padding:24px;}
.fas-lightbox[hidden]{display:none;}
.fas-lightbox img{max-width:92vw;max-height:76vh;border-radius:14px;box-shadow:0 30px 80px rgba(0,0,0,.6);animation:fasUp .35s ease;}
.fas-cap{color:#fff;font-weight:700;margin-top:16px;text-align:center;}
.fas-close{position:absolute;top:18px;right:22px;width:44px;height:44px;border-radius:50%;border:0;background:#fff;color:var(--navy);font-size:18px;cursor:pointer;}
.fas-close:active{transform:scale(.92);}

@media (max-width:520px){.fas-grid{grid-template-columns:1fr;}}
@media (prefers-reduced-motion:reduce){.js .fas-card.is-in{animation:none;}.js .fas-card:not(.is-in){opacity:1;}}
</style>

<section class="fas-section">
  <div class="container">
    <div class="section-label">Akademik</div>
    <div class="section-title">Fasilitas Sekolah</div>
    <p class="fas-intro">Berbagai fasilitas pendukung kegiatan belajar mengajar di SMK Infokom.</p>

    <?php if (empty($fasilitas)): ?>
    <div class="fas-empty">Belum ada data fasilitas.</div>
    <?php else: ?>
    <div class="fas-grid">
      <?php foreach ($fasilitas as $f): $foto = fasFoto($f['gambar'] ?? ''); $ikon = fasIkon($f['icon'] ?? ''); ?>
      <div class="fas-card<?= $foto ? '' : ' no-photo' ?>">
        <div class="fas-media">
          <?php if ($foto): ?>
          <button type="button" class="fas-photo" data-full="<?= h($foto) ?>" data-title="<?= h($f['nama']) ?>" aria-label="Perbesar foto <?= h($f['nama']) ?>">
            <img src="<?= h($foto) ?>" alt="<?= h($f['nama']) ?>" loading="lazy">
            <span class="fas-zoom"><i class="fa-solid fa-magnifying-glass-plus"></i></span>
          </button>
          <span class="fas-icon"><i class="fa-solid fa-<?= h($ikon) ?>"></i></span>
          <?php else: ?>
          <div class="fas-noimg"><i class="fa-solid fa-<?= h($ikon) ?>"></i></div>
          <?php endif; ?>
        </div>
        <div class="fas-body">
          <h3><?= h($f['nama']) ?></h3>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</section>

<div class="fas-lightbox" id="fasLightbox" hidden>
  <button type="button" class="fas-close" data-close aria-label="Tutup"><i class="fa-solid fa-xmark"></i></button>
  <img src="" alt="">
  <div class="fas-cap"></div>
</div>

<script>
(function () {
  'use strict';
  var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* kartu muncul berurutan saat di-scroll */
  var cards = [].slice.call(document.querySelectorAll('.fas-card'));
  if (!('IntersectionObserver' in window) || reduce) {
    cards.forEach(function (c) { c.classList.add('is-in'); });
  } else {
    cards.forEach(function (c, i) { c.style.setProperty('--d', (i % 4) * 0.08 + 's'); });
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (en.isIntersecting) { en.target.classList.add('is-in'); io.unobserve(en.target); }
      });
    }, { threshold: 0.12 });
    cards.forEach(function (c) { io.observe(c); });
  }

  /* klik foto -> tampil besar */
  var box = document.getElementById('fasLightbox');
  if (!box) return;
  var img = box.querySelector('img');
  var cap = box.querySelector('.fas-cap');
  function buka(src, judul) {
    img.src = src; img.alt = judul; cap.textContent = judul;
    box.hidden = false;
    document.body.style.overflow = 'hidden';
  }
  function tutup() {
    box.hidden = true; img.removeAttribute('src');
    document.body.style.overflow = '';
  }
  document.addEventListener('click', function (e) {
    var b = e.target.closest ? e.target.closest('.fas-photo') : null;
    if (b) { buka(b.getAttribute('data-full'), b.getAttribute('data-title') || ''); return; }
    if (!box.hidden && (e.target === box || (e.target.closest && e.target.closest('[data-close]')))) tutup();
  });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && !box.hidden) tutup();
  });
})();
</script>
<?php require_once __DIR__ . '/includes/ijk-footer.php'; ?>