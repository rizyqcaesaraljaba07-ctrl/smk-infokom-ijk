<?php
require_once __DIR__ . '/includes/ijk-functions.php';

$db = getDB();
$programs = $db->query("SELECT * FROM program_keahlian ORDER BY urutan ASC")->fetchAll();

require_once __DIR__ . '/includes/ijk-header.php';
?>

<section class="programs" style="padding-top:50px;">
  <div class="container">

    <div class="section-label">Program Keahlian</div>
    <div class="section-title">Kompetensi Unggulan untuk Masa Depan</div>

    <div class="program-grid" style="margin-top:24px;">

      <?php foreach ($programs as $prog): ?>

        <div class="program-card">

          <?php if (!empty($prog['foto'])): ?>
            <div style="
              width:100%;
              height:180px;
              display:flex;
              align-items:center;
              justify-content:center;
              background:#ffffff;
              border-radius:8px;
              margin-bottom:14px;
              overflow:hidden;
            ">
              <img
                src="uploads/program/<?= h($prog['foto']) ?>"
                alt="<?= h($prog['nama']) ?>"
                style="
                  width:100%;
                  height:100%;
                  object-fit:contain;
                  display:block;
                "
              >
            </div>
          <?php endif; ?>

          <div class="program-icon">
            <i class="fa-solid fa-<?= h($prog['icon']) ?>"></i>
          </div>

          <h3><?= h($prog['nama']) ?></h3>

          <p><?= h($prog['deskripsi']) ?></p>

        </div>

      <?php endforeach; ?>

    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/ijk-footer.php'; ?>