<?php
require_once __DIR__ . '/includes/ijk-functions.php';
$db = getDB();
$ekskul = $db->query("SELECT * FROM ekstrakurikuler ORDER BY id ASC")->fetchAll();
require_once __DIR__ . '/includes/ijk-header.php';
?>
<section class="academic-content">
  <div class="container">
    <div class="section-label">Akademik</div>
    <div class="section-title">Ekstrakurikuler</div>
    <p class="academic-intro">Kegiatan ekstrakurikuler untuk mendukung pengembangan minat, bakat, karakter, dan keterampilan siswa.</p>
    <div class="program-grid">
      <?php foreach ($ekskul as $item): ?>
        <div class="program-card reveal">
         <?php if (!empty($item['foto'])): ?>
  <img
    src="uploads/ekstrakurikuler/<?= h($item['foto']) ?>"
    alt="<?= h($item['nama']) ?>"
    style="width: 100%; height: 180px; object-fit: cover; border-radius: 12px; margin-bottom: 15px;"
  >
<?php else: ?>
  <div class="program-icon">
    <i class="fa-solid fa-people-group"></i>
  </div>
<?php endif; ?>
          <h3><?= h($item['nama']) ?></h3>
          <?php if (!empty($item['deskripsi'])): ?><p><?= h($item['deskripsi']) ?></p><?php else: ?><p>Informasi kegiatan akan diperbarui oleh sekolah.</p><?php endif; ?>
          <?php if (!empty($item['pembina'])): ?><p><strong>Pembina:</strong> <?= h($item['pembina']) ?></p><?php endif; ?>
        </div>
      <?php endforeach; ?>
      <?php if (empty($ekskul)): ?>
        <div class="academic-empty" style="grid-column:1/-1;">Belum ada data ekstrakurikuler.</div>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php require_once __DIR__ . '/includes/ijk-footer.php'; ?>
