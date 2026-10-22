<?php
require_once __DIR__ . '/../includes/ijk-functions.php';
requireLogin();
$db = getDB();
$pageTitle = 'PPDB';
$aksi = $_GET['aksi'] ?? 'list';
$id = $_GET['id'] ?? null;

if ($aksi === 'status' && $id && isset($_GET['nilai'])) {
    $stmt = $db->prepare("UPDATE ppdb SET status=? WHERE id=?");
    $stmt->execute([$_GET['nilai'], $id]);
    catatLog("Mengubah status pendaftar PPDB ID $id menjadi " . $_GET['nilai']);
    setFlash('success', 'Status pendaftar berhasil diperbarui.');
    redirect('ijk-ppdb.php');
}

if ($aksi === 'hapus' && $id) {
    $db->prepare("DELETE FROM ppdb WHERE id=?")->execute([$id]);
    catatLog("Menghapus data pendaftar PPDB ID $id");
    setFlash('success', 'Data pendaftar berhasil dihapus.');
    redirect('ijk-ppdb.php');
}

$list = $db->query("SELECT p.*, pk.nama AS jurusan_nama FROM ppdb p LEFT JOIN program_keahlian pk ON p.jurusan_pilihan = pk.id ORDER BY p.tanggal_daftar DESC")->fetchAll();
$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><title>PPDB - Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../assets/css/ijk-admin.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<div class="admin-wrap">
  <?php include 'includes/ijk-sidebar.php'; ?>
  <div class="main">
    <?php include 'includes/ijk-topbar.php'; ?>
    <div class="content">
      <?php if ($flash): ?><div class="alert alert-<?= $flash['type'] ?>"><?= h($flash['message']) ?></div><?php endif; ?>
      <div class="page-head"><h3 style="color:var(--navy);">Pendaftar PPDB</h3></div>
      <div class="table-wrap">
        <table>
          <tr><th>No</th><th>No. Pendaftaran</th><th>Nama</th><th>NISN</th><th>Asal Sekolah</th><th>Jurusan</th><th>No HP</th><th>Tanggal</th><th>Status</th><th>Aksi</th></tr>
          <?php foreach ($list as $i => $row): ?>
          <tr>
            <td><?= $i+1 ?></td>
            <td><?= h($row['no_pendaftaran'] ?? '-') ?></td>
            <td><?= h($row['nama_lengkap']) ?></td>
            <td><?= h($row['nisn']) ?></td>
            <td><?= h($row['asal_sekolah']) ?></td>
            <td><?= h($row['jurusan_nama'] ?? '-') ?></td>
            <td><?= h($row['no_hp']) ?></td>
            <td><?= !empty($row['tanggal_daftar']) ? date('d/m/Y', strtotime($row['tanggal_daftar'])) : '-' ?></td>
            <td>
              <span class="badge badge-<?= $row['status']=='Diterima'?'green':($row['status']=='Ditolak'?'red':'gold') ?>"><?= h($row['status']) ?></span>
            </td>
            <td class="action-icons">
              <a href="ijk-ppdb-cetak.php?id=<?= $row['id'] ?>" target="_blank" title="Lihat detail / Unduh PDF"><i class="fa-solid fa-file-pdf" style="color:#2563eb;"></i></a>
              <a href="ijk-ppdb.php?aksi=status&id=<?= $row['id'] ?>&nilai=Diterima" title="Terima"><i class="fa-solid fa-check" style="color:#16a34a;"></i></a>
              <a href="ijk-ppdb.php?aksi=status&id=<?= $row['id'] ?>&nilai=Ditolak" title="Tolak"><i class="fa-solid fa-xmark" style="color:#dc2626;"></i></a>
              <a href="ijk-ppdb.php?aksi=hapus&id=<?= $row['id'] ?>" class="danger" onclick="return confirm('Hapus data ini?')"><i class="fa-solid fa-trash"></i></a>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php if (empty($list)): ?><tr><td colspan="10" style="text-align:center;color:var(--gray);">Belum ada pendaftar.</td></tr><?php endif; ?>
        </table>
      </div>
    </div>
  </div>
</div>
</body>
</html>