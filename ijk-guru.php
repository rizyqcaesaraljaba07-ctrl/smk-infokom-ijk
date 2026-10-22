<?php
require_once __DIR__ . '/includes/ijk-functions.php';

$db = getDB();
$guru = $db->query("SELECT * FROM guru WHERE status = 'Aktif' ORDER BY id ASC")->fetchAll();

// Kelompokkan berdasarkan jabatan
$kepsek = [];
$waka = [];
$kaprog = [];
$staf = [];

foreach ($guru as $g) {
    $jab = strtolower($g['jabatan'] ?? '');
    if ((strpos($jab, 'kepala sekolah') !== false && strpos($jab, 'wakil') === false) || $jab === 'kepsek') {
        $kepsek[] = $g;
    } elseif (strpos($jab, 'wakil') !== false || strpos($jab, 'waka') !== false) {
        $waka[] = $g;
    } elseif (strpos($jab, 'kepala program') !== false || strpos($jab, 'kaprog') !== false || strpos($jab, 'ketua program') !== false) {
        $kaprog[] = $g;
    } else {
        $staf[] = $g;
    }
}

require_once __DIR__ . '/includes/ijk-header.php';
?>

<style>
/* =========================================
   STRUKTUR ORGANISASI (TREE CSS YANG LEBIH STABIL)
   ========================================= */
.org-wrapper { 
    padding: 50px 0; 
    background: #f8f9fc; 
    overflow-x: auto; 
}
.org-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 1000px; /* Memaksa lebar agar berjejer ke samping */
    padding-bottom: 50px;
}

/* Kotak Guru */
.org-card {
    background: #fff; 
    border: 1px solid #e5e7eb; 
    border-radius: 12px;
    padding: 20px 15px; 
    width: 200px; 
    text-align: center; 
    box-shadow: 0 4px 15px rgba(0,0,0,.05); 
    transition: all .3s ease;
    display: flex; 
    flex-direction: column; 
    align-items: center;
    position: relative;
}
.org-card:hover { 
    transform: translateY(-5px); 
    box-shadow: 0 10px 25px rgba(11,21,51,.15); 
    z-index: 10; 
}
.org-card img {
    width: 80px; height: 80px; object-fit: cover; object-position: top center;
    border-radius: 50%; margin-bottom: 15px; border: 3px solid var(--gold); display: block;
}
.org-card .placeholder {
    width: 80px; height: 80px; border-radius: 50%; margin-bottom: 15px;
    background: #e5e7eb; display: flex; align-items: center; justify-content: center; color: #9ca3af; font-size: 30px;
}
.org-card h4 { font-size: 14px; color: var(--navy); margin-bottom: 6px; font-weight: 800; line-height: 1.4; }
.org-card p { font-size: 11px; color: var(--gray); margin: 0; line-height: 1.4; }

/* Kepala Sekolah */
.org-card.kepsek { width: 260px; background: var(--navy); border-color: var(--navy); padding: 25px 20px; z-index: 2;}
.org-card.kepsek h4 { color: #fff; font-size: 16px; }
.org-card.kepsek p { color: var(--gold); font-size: 13px; font-weight: 600; }
.org-card.kepsek img, .org-card.kepsek .placeholder { border-color: #fff; width: 100px; height: 100px; }
.org-card.kepsek .placeholder { background: rgba(255,255,255,0.1); color: #fff; }

/* Garis Penghubung Utama */
.org-line-vertical {
    width: 2px; height: 30px; background: var(--navy); margin: 0 auto;
}

/* Baris Wakil & Kaprog */
.org-level {
    display: flex; justify-content: center; gap: 20px; position: relative; width: 100%;
}

/* Garis Horizontal Penghubung Antar Kotak */
.org-level.has-children::before {
    content: ''; position: absolute; top: 0; left: 50%; transform: translateX(-50%);
    width: 80%; /* Panjang garis horizontal */
    height: 2px; background: var(--navy);
}
/* Garis Vertikal Turun ke Setiap Kotak */
.org-level.has-children .org-card::before {
    content: ''; position: absolute; top: -30px; left: 50%; transform: translateX(-50%);
    width: 2px; height: 30px; background: var(--navy);
}

/* Kotak Staf Bawah (Grid 4 Kolom) */
.org-staf-grid { 
    display: grid; 
    grid-template-columns: repeat(4, 1fr); 
    gap: 20px; 
    margin-top: 40px; 
    border-top: 2px dashed #cbd5e1; 
    padding-top: 40px; 
    width: 100%; 
    max-width: 1000px; 
}
.org-staf-grid .org-card { width: 100%; }

/* Penyesuaian Garis jika Kotak Cuma 1 */
.org-level.has-children:has(.org-card:only-child)::before { display: none; }
</style>

<section class="org-wrapper">
  <div class="container" style="display:flex; justify-content:center;">
    <div class="org-container">
      
      <!-- LEVEL 1: KEPALA SEKOLAH -->
      <?php if (!empty($kepsek)): ?>
        <div class="org-level">
          <?php foreach ($kepsek as $k): ?>
            <div class="org-card kepsek reveal">
              <?php if (!empty($k['foto'])): ?>
                <img src="<?= BASE_URL ?>uploads/guru/<?= h($k['foto']) ?>" alt="<?= h($k['nama']) ?>">
              <?php else: ?>
                <div class="placeholder"><i class="fa-solid fa-user-tie"></i></div>
              <?php endif; ?>
              <h4><?= h($k['nama']) ?></h4>
              <p><?= h($k['jabatan'] ?: 'Kepala Sekolah') ?></p>
            </div>
          <?php endforeach; ?>
        </div>
        <!-- Garis Turun dari Kepsek -->
        <div class="org-line-vertical"></div>
      <?php endif; ?>

      <!-- LEVEL 2: WAKIL KEPALA SEKOLAH -->
      <?php if (!empty($waka)): ?>
        <div class="org-level has-children" style="padding-top: 30px;">
          <?php foreach ($waka as $w): ?>
            <div class="org-card reveal">
              <?php if (!empty($w['foto'])): ?>
                <img src="<?= BASE_URL ?>uploads/guru/<?= h($w['foto']) ?>" alt="<?= h($w['nama']) ?>">
              <?php else: ?>
                <div class="placeholder"><i class="fa-solid fa-user"></i></div>
              <?php endif; ?>
              <h4><?= h($w['nama']) ?></h4>
              <p><?= h($w['jabatan']) ?></p>
            </div>
          <?php endforeach; ?>
        </div>
        <!-- Garis Turun dari Waka -->
        <div class="org-line-vertical" style="height: 30px;"></div>
      <?php endif; ?>

      <!-- LEVEL 3: KEPALA PROGRAM KEAHLIAN -->
      <?php if (!empty($kaprog)): ?>
        <div class="org-level has-children" style="padding-top: 30px;">
          <?php foreach ($kaprog as $kp): ?>
            <div class="org-card reveal">
              <?php if (!empty($kp['foto'])): ?>
                <img src="<?= BASE_URL ?>uploads/guru/<?= h($kp['foto']) ?>" alt="<?= h($kp['nama']) ?>">
              <?php else: ?>
                <div class="placeholder"><i class="fa-solid fa-user"></i></div>
              <?php endif; ?>
              <h4><?= h($kp['nama']) ?></h4>
              <p><?= h($kp['jabatan']) ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <!-- LEVEL 4: GURU & STAF LAINNYA -->
      <?php if (!empty($staf)): ?>
        <div class="org-staf-grid">
          <?php foreach ($staf as $s): ?>
            <div class="org-card reveal">
              <?php if (!empty($s['foto'])): ?>
                <img src="<?= BASE_URL ?>uploads/guru/<?= h($s['foto']) ?>" alt="<?= h($s['nama']) ?>">
              <?php else: ?>
                <div class="placeholder"><i class="fa-solid fa-user"></i></div>
              <?php endif; ?>
              <h4><?= h($s['nama']) ?></h4>
              <p><?= h($s['jabatan'] ?: 'Guru / Staf') ?></p>
              <?php if (!empty($s['mapel'])): ?>
                <p style="font-size:10px; margin-top:4px; color:#9ca3af; font-style:italic;"><?= h($s['mapel']) ?></p>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/ijk-footer.php'; ?>