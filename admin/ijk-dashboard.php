<?php
require_once __DIR__ . '/../includes/ijk-functions.php';
requireLogin();
$db = getDB();
$pageTitle = 'Dashboard';

$totalSiswa = $db->query("SELECT COUNT(*) c FROM siswa WHERE status='Aktif'")->fetch()['c'];
$totalGuru  = $db->query("SELECT COUNT(*) c FROM guru WHERE status='Aktif'")->fetch()['c'];
$totalPrestasi = $db->query("SELECT COUNT(*) c FROM prestasi")->fetch()['c'];
$totalBerita = $db->query("SELECT COUNT(*) c FROM berita")->fetch()['c'];

$siswaTerbaru = $db->query("SELECT * FROM siswa ORDER BY id DESC LIMIT 5")->fetchAll();
$beritaTerbaru = $db->query("SELECT * FROM berita ORDER BY tanggal DESC LIMIT 4")->fetchAll();
$logAktivitas = $db->query("SELECT * FROM activity_log ORDER BY id DESC LIMIT 6")->fetchAll();

// Grafik jumlah siswa per tahun (dari tanggal_daftar)
$grafik = $db->query("SELECT YEAR(tanggal_daftar) th, COUNT(*) jml FROM siswa GROUP BY YEAR(tanggal_daftar) ORDER BY th ASC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard - Admin SMK Infokom</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../assets/css/ijk-admin.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
</head>
<body>
<div class="admin-wrap">
  <?php include 'includes/ijk-sidebar.php'; ?>
  <div class="main">
    <?php include 'includes/ijk-topbar.php'; ?>
    <div class="content">

      <div class="stat-cards">
        <div class="stat-card">
          <div><div class="label">Total Siswa</div><div class="num"><?= (int)$totalSiswa ?></div></div>
          <div class="ic" style="background:#2563eb;"><i class="fa-solid fa-user-graduate"></i></div>
        </div>
        <div class="stat-card">
          <div><div class="label">Total Guru & Staff</div><div class="num"><?= (int)$totalGuru ?></div></div>
          <div class="ic" style="background:#0e1a3d;"><i class="fa-solid fa-chalkboard-user"></i></div>
        </div>
        <div class="stat-card">
          <div><div class="label">Prestasi</div><div class="num"><?= (int)$totalPrestasi ?></div></div>
          <div class="ic" style="background:#f5b400;"><i class="fa-solid fa-trophy"></i></div>
        </div>
        <div class="stat-card">
          <div><div class="label">Berita</div><div class="num"><?= (int)$totalBerita ?></div></div>
          <div class="ic" style="background:#dc2626;"><i class="fa-solid fa-newspaper"></i></div>
        </div>
      </div>

      <div class="panel" style="margin-bottom:24px;">
        <h3>Grafik Jumlah Siswa per Tahun</h3>
        <canvas id="chartSiswa" height="80"></canvas>
      </div>

      <div class="grid-2">
        <div class="panel">
          <h3>Data Terbaru <a href="ijk-data-siswa.php" class="view-all">Lihat Semua Data Siswa</a></h3>
          <table>
            <tr><th>No</th><th>Nama</th><th>Kelas</th><th>Tanggal Daftar</th></tr>
            <?php foreach ($siswaTerbaru as $i => $s): ?>
            <tr>
              <td><?= $i+1 ?></td>
              <td><?= h($s['nama']) ?></td>
              <td><?= h($s['kelas']) ?></td>
              <td><?= formatTanggal($s['tanggal_daftar']) ?></td>
            </tr>
            <?php endforeach; ?>
          </table>
        </div>
        <div class="panel">
          <h3>Berita Terbaru <a href="ijk-berita.php" class="view-all">Lihat Semua Berita</a></h3>
          <?php foreach ($beritaTerbaru as $b): ?>
          <div style="display:flex;gap:10px;padding:10px 0;border-bottom:1px solid var(--border);">
            <div style="width:40px;height:40px;background:var(--light);border-radius:8px;flex-shrink:0;display:flex;align-items:center;justify-content:center;color:var(--navy);"><i class="fa-solid fa-newspaper"></i></div>
            <div>
              <div style="font-size:13px;font-weight:600;"><?= h($b['judul']) ?></div>
              <div style="font-size:11px;color:var(--gray);"><?= formatTanggal($b['tanggal']) ?></div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="page-head"><h3 style="color:var(--navy);">Kelola Konten</h3></div>
      <div class="action-grid">
        <a href="ijk-berita.php?aksi=tambah" class="action-card"><div class="ic"><i class="fa-solid fa-newspaper"></i></div><div><b>Tambah Berita</b><span>Buat berita baru</span></div></a>
        <a href="ijk-galeri.php?aksi=tambah" class="action-card"><div class="ic"><i class="fa-solid fa-images"></i></div><div><b>Tambah Galeri</b><span>Unggah foto / video</span></div></a>
        <a href="ijk-prestasi.php?aksi=tambah" class="action-card"><div class="ic"><i class="fa-solid fa-trophy"></i></div><div><b>Kelola Prestasi</b><span>Tambah prestasi</span></div></a>
        <a href="ijk-ekstrakurikuler.php?aksi=tambah" class="action-card"><div class="ic"><i class="fa-solid fa-people-group"></i></div><div><b>Kelola Ekstrakurikuler</b><span>Atur kegiatan ekskul</span></div></a>
      </div>

      <div class="panel">
        <h3>Log Aktivitas</h3>
        <table>
          <tr><th>Waktu</th><th>User</th><th>Aktivitas</th></tr>
          <?php foreach ($logAktivitas as $log): ?>
          <tr>
            <td><?= date('H:i', strtotime($log['waktu'])) ?></td>
            <td><?= h($log['user']) ?></td>
            <td><?= h($log['aktivitas']) ?></td>
          </tr>
          <?php endforeach; ?>
        </table>
      </div>

    </div>
  </div>
</div>

<script>
const ctx = document.getElementById('chartSiswa');
new Chart(ctx, {
  type: 'line',
  data: {
    labels: <?= json_encode(array_column($grafik, 'th')) ?>,
    datasets: [{
      label: 'Jumlah Siswa',
      data: <?= json_encode(array_column($grafik, 'jml')) ?>,
      borderColor: '#2563eb',
      backgroundColor: 'rgba(37,99,235,.1)',
      fill: true,
      tension: .3
    }]
  },
  options: { plugins: { legend: { display: false } } }
});
</script>
</body>
</html>
