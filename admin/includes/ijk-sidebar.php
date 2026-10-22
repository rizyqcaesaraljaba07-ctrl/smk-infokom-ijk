<?php
$current = basename($_SERVER['PHP_SELF']);

/* Logo sekolah diambil dari Admin > Pengaturan; kalau belum ada, tampil kotak "SI" */
$pSidebar = getPengaturan();
$logoSidebar = null;
if (!empty($pSidebar['logo']) && is_file(__DIR__ . '/../../uploads/logo/' . basename($pSidebar['logo']))) {
  $logoSidebar = BASE_URL . 'uploads/logo/' . rawurlencode(basename($pSidebar['logo']));
}
?>
<aside class="sidebar">
  <div class="sidebar-brand">
    <?php if ($logoSidebar): ?>
      <img src="<?= h($logoSidebar) ?>" alt="Logo SMK Infokom" style="width:42px;height:42px;object-fit:contain;background:#fff;border-radius:10px;padding:3px;flex-shrink:0;">
    <?php else: ?>
      <div style="width:38px;height:38px;background:#f5b400;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#0e1a3d;font-weight:800;flex-shrink:0;">SI</div>
    <?php endif; ?>
    <div><b>SMK Infokom</b><small>Kota Bogor</small></div>
  </div>
  <div class="sidebar-menu">
    <a href="ijk-dashboard.php" class="<?= $current == 'ijk-dashboard.php' ? 'active' : '' ?>"><i class="fa-solid fa-gauge"></i><span> Dashboard</span></a>
    <a href="ijk-data-siswa.php" class="<?= $current == 'ijk-data-siswa.php' ? 'active' : '' ?>"><i class="fa-solid fa-user-graduate"></i><span> Data Siswa</span></a>
    <a href="/smk-infokom-ijk/admin/ijk-fasilitas.php"
      class="<?= $current == 'ijk-fasilitas.php' ? 'active' : '' ?>">
      <i class="fa-solid fa-building"></i>
      <span>Fasilitas</span>
    </a>
    <a href="ijk-data-guru.php" class="<?= $current == 'ijk-data-guru.php' ? 'active' : '' ?>"><i class="fa-solid fa-chalkboard-user"></i><span> Data Guru</span></a>
    <a href="ijk-program-keahlian.php" class="<?= $current == 'ijk-program-keahlian.php' ? 'active' : '' ?>"><i class="fa-solid fa-graduation-cap"></i><span> Program Keahlian</span></a>
    <a href="ijk-prestasi.php" class="<?= $current == 'ijk-prestasi.php' ? 'active' : '' ?>"><i class="fa-solid fa-trophy"></i><span> Prestasi</span></a>
    <a href="ijk-ekstrakurikuler.php" class="<?= $current == 'ijk-ekstrakurikuler.php' ? 'active' : '' ?>"><i class="fa-solid fa-people-group"></i><span> Ekstrakurikuler</span></a>
    <a href="ijk-berita.php" class="<?= $current == 'ijk-berita.php' ? 'active' : '' ?>"><i class="fa-solid fa-newspaper"></i><span> Berita & Informasi</span></a>
    <a href="ijk-galeri.php" class="<?= $current == 'ijk-galeri.php' ? 'active' : '' ?>"><i class="fa-solid fa-images"></i><span> Galeri</span></a>
    <a href="ijk-mitra.php" class="<?= $current == 'ijk-mitra.php' ? 'active' : '' ?>"><i class="fa-solid fa-handshake"></i><span> Mitra Kerja Sama</span></a>
    <a href="ijk-bkk.php" class="<?= $current == 'ijk-bkk.php' ? 'active' : '' ?>"><i class="fa-solid fa-briefcase"></i><span> BKK / Lowongan</span></a>
    <a href="ijk-pkl.php"><i class="fa-solid fa-industry"></i> Info PKL</a>
    <!-- UBAH DI SINI -->
    <a href="ijk-magang-jepang.php"><i class="fa-solid fa-plane-departure"></i> Magang</a>
    <a href="ijk-ppdb.php" class="<?= $current == 'ijk-ppdb.php' ? 'active' : '' ?>"><i class="fa-solid fa-file-signature"></i><span> PPDB</span></a>
    <a href="ijk-pengaturan.php" class="<?= $current == 'ijk-pengaturan.php' ? 'active' : '' ?>"><i class="fa-solid fa-gear"></i><span> Pengaturan</span></a>
  </div>
  <div class="sidebar-logout">
    <a href="ijk-logout.php"><i class="fa-solid fa-right-from-bracket"></i><span> Logout</span></a>
  </div>
</aside>