<?php
require_once __DIR__ . '/includes/ijk-functions.php';
$db = getDB();
$galeriList = $db->query("SELECT * FROM galeri ORDER BY id DESC")->fetchAll();
require_once __DIR__ . '/includes/ijk-header.php';
?>
<section class="gallery" style="padding-top:50px;">
  <div class="container">
    <div class="section-label">Galeri Kegiatan</div>
    <div class="section-title">Dokumentasi Kegiatan Sekolah</div>
    <div class="gallery-grid" style="margin-top:24px;grid-template-columns:repeat(4,1fr);">
      <?php foreach ($galeriList as $g): ?>
      <div class="gallery-item">
        <?php if (!empty($g['gambar'])): ?>
        <img src="uploads/galeri/<?= h($g['gambar']) ?>" alt="<?= h($g['judul']) ?>">
        <?php else: ?>
        <div style="width:100%;height:100%;background:var(--light);display:flex;align-items:center;justify-content:center;color:var(--gray);"><i class="fa-solid fa-image" style="font-size:28px;"></i></div>
        <?php endif; ?>
        <div class="cap"><?= h($g['judul']) ?><br><small><?= h($g['kategori']) ?></small></div>
      </div>
      <?php endforeach; ?>
      <?php if (empty($galeriList)): ?>
      <p style="color:var(--gray);grid-column:1/-1;">Belum ada galeri.</p>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php require_once __DIR__ . '/includes/ijk-footer.php'; ?>
