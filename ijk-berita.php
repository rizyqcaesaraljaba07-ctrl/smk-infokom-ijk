<?php
require_once __DIR__ . '/includes/ijk-functions.php';
$db = getDB();

if (isset($_GET['slug'])) {
    $stmt = $db->prepare("SELECT * FROM berita WHERE slug = ?");
    $stmt->execute([$_GET['slug']]);
    $detail = $stmt->fetch();
    if ($detail) {
        $db->prepare("UPDATE berita SET dilihat = dilihat + 1 WHERE id = ?")->execute([$detail['id']]);
    }
}
$beritaList = $db->query("SELECT * FROM berita ORDER BY tanggal DESC")->fetchAll();

require_once __DIR__ . '/includes/ijk-header.php';
?>

<section class="about" style="padding-top:50px;">
  <div class="container">
    <?php if (isset($detail) && $detail): ?>
      <div class="section-label"><?= h($detail['kategori']) ?></div>
      <div class="section-title"><?= h($detail['judul']) ?></div>
      <p style="color:var(--gray);font-size:13px;margin-bottom:20px;">
        <?= formatTanggal($detail['tanggal']) ?> · Oleh <?= h($detail['penulis']) ?> · <?= (int)$detail['dilihat'] ?> dilihat
      </p>
      <?php if (!empty($detail['gambar'])): ?>
      <img src="uploads/berita/<?= h($detail['gambar']) ?>" alt="<?= h($detail['judul']) ?>" style="width:100%;max-width:700px;border-radius:12px;margin-bottom:20px;">
      <?php endif; ?>
      <p style="max-width:800px;line-height:1.8;"><?= nl2br(h($detail['isi'])) ?></p>
      <a href="ijk-berita.php" class="btn btn-gold" style="margin-top:24px;">Kembali ke Daftar Berita</a>
    <?php else: ?>
      <div class="section-label">Informasi</div>
      <div class="section-title">Berita & Informasi Sekolah</div>
      <div class="info-grid" style="margin-top:24px;grid-template-columns:repeat(3,1fr);">
        <?php foreach ($beritaList as $b): ?>
        <div class="info-card">
          <?php if (!empty($b['gambar'])): ?>
          <img src="uploads/berita/<?= h($b['gambar']) ?>" alt="<?= h($b['judul']) ?>" style="width:100%;height:130px;object-fit:cover;border-radius:8px;margin-bottom:14px;">
          <?php else: ?>
          <div class="icon-badge"><i class="fa-solid fa-newspaper"></i></div>
          <?php endif; ?>
          <h4><a href="ijk-berita.php?slug=<?= h($b['slug']) ?>"><?= h($b['judul']) ?></a></h4>
          <p><?= h($b['kategori']) ?> · <?= formatTanggal($b['tanggal']) ?></p>
          <a class="more" href="ijk-berita.php?slug=<?= h($b['slug']) ?>">Baca Selengkapnya <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php require_once __DIR__ . '/includes/ijk-footer.php'; ?>
