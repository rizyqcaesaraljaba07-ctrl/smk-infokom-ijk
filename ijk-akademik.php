<?php
require_once __DIR__ . '/includes/ijk-functions.php';
require_once __DIR__ . '/includes/ijk-header.php';
?>
<section class="academic-page">
  <div class="container">
    <div class="section-label">Akademik</div>
    <div class="section-title">Informasi Akademik Sekolah</div>
    <p class="academic-intro">Pilih informasi akademik yang ingin dilihat. Setiap menu sekarang memiliki halaman sendiri agar lebih mudah diakses dan tidak lagi bergantung pada scroll di satu halaman.</p>

    <div class="academic-menu-grid">
      <a class="academic-menu-card" href="ijk-ekstrakurikuler.php">
        <div class="academic-menu-icon"><i class="fa-solid fa-people-group"></i></div>
        <h3>Ekstrakurikuler</h3>
        <p>Daftar kegiatan pengembangan minat dan bakat siswa.</p>
      </a>
            <a class="academic-menu-card" href="ijk-program-keahlian.php">
        <div class="academic-menu-icon"><i class="fa-solid fa-people-group"></i></div>
        <h3>Program Keahlan</h3>
        <p>Daftar Program Keahlian Sekolah.</p>
      </a>
            <a class="academic-menu-card" href="ijk-prestasi.php">
        <div class="academic-menu-icon"><i class="fa-solid fa-people-group"></i></div>
        <h3>Prestasi</h3>
        <p>Daftar Prestasi Siswa Infokom.</p>
      </a>
    </div>
  </div>
</section>
<?php require_once __DIR__ . '/includes/ijk-footer.php'; ?>
