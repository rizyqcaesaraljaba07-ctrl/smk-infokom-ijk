<?php
require_once __DIR__ . '/../includes/ijk-functions.php';
requireLogin();
$db = getDB();
$pageTitle = 'Data Siswa';
$aksi = $_GET['aksi'] ?? 'list';
$id = $_GET['id'] ?? null;

// Simpan tambah/edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nis = trim($_POST['nis']);
    $nama = trim($_POST['nama']);
    $kelas = trim($_POST['kelas']);
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tanggal_daftar = $_POST['tanggal_daftar'];
    $status = $_POST['status'];

    if (!empty($_POST['id'])) {
        $stmt = $db->prepare("UPDATE siswa SET nis=?, nama=?, kelas=?, jenis_kelamin=?, tanggal_daftar=?, status=? WHERE id=?");
        $stmt->execute([$nis, $nama, $kelas, $jenis_kelamin, $tanggal_daftar, $status, $_POST['id']]);
        catatLog("Mengubah data siswa: $nama");
        setFlash('success', 'Data siswa berhasil diperbarui.');
    } else {
        $stmt = $db->prepare("INSERT INTO siswa (nis, nama, kelas, jenis_kelamin, tanggal_daftar, status) VALUES (?,?,?,?,?,?)");
        $stmt->execute([$nis, $nama, $kelas, $jenis_kelamin, $tanggal_daftar, $status]);
        catatLog("Menambah data siswa: $nama");
        setFlash('success', 'Data siswa berhasil ditambahkan.');
    }
    redirect('ijk-data-siswa.php');
}

// Hapus
if ($aksi === 'hapus' && $id) {
    $stmt = $db->prepare("SELECT nama FROM siswa WHERE id=?");
    $stmt->execute([$id]);
    $nama = $stmt->fetchColumn();
    $db->prepare("DELETE FROM siswa WHERE id=?")->execute([$id]);
    catatLog("Menghapus data siswa: $nama");
    setFlash('success', 'Data siswa berhasil dihapus.');
    redirect('ijk-data-siswa.php');
}

// Data untuk form edit
$editData = null;
if ($aksi === 'edit' && $id) {
    $stmt = $db->prepare("SELECT * FROM siswa WHERE id=?");
    $stmt->execute([$id]);
    $editData = $stmt->fetch();
}

$search = trim($_GET['q'] ?? '');
if ($search) {
    $stmt = $db->prepare("SELECT * FROM siswa WHERE nama LIKE ? OR nis LIKE ? OR kelas LIKE ? ORDER BY id DESC");
    $like = "%$search%";
    $stmt->execute([$like, $like, $like]);
    $siswaList = $stmt->fetchAll();
} else {
    $siswaList = $db->query("SELECT * FROM siswa ORDER BY id DESC")->fetchAll();
}
$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Siswa - Admin</title>
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

      <?php if ($flash): ?>
        <div class="alert alert-<?= $flash['type'] ?>"><?= h($flash['message']) ?></div>
      <?php endif; ?>

      <?php if ($aksi === 'tambah' || $aksi === 'edit'): ?>
        <div class="page-head"><h3 style="color:var(--navy);"><?= $aksi==='edit' ? 'Edit' : 'Tambah' ?> Data Siswa</h3></div>
        <form method="POST" class="form-box">
          <input type="hidden" name="id" value="<?= h($editData['id'] ?? '') ?>">
          <label>NIS</label>
          <input type="text" name="nis" value="<?= h($editData['nis'] ?? '') ?>" required>
          <label>Nama Lengkap</label>
          <input type="text" name="nama" value="<?= h($editData['nama'] ?? '') ?>" required>
          <label>Kelas</label>
          <input type="text" name="kelas" value="<?= h($editData['kelas'] ?? '') ?>" placeholder="Contoh: XII RPL 1" required>
          <label>Jenis Kelamin</label>
          <select name="jenis_kelamin">
            <option value="L" <?= (($editData['jenis_kelamin'] ?? '')=='L')?'selected':'' ?>>Laki-laki</option>
            <option value="P" <?= (($editData['jenis_kelamin'] ?? '')=='P')?'selected':'' ?>>Perempuan</option>
          </select>
          <label>Tanggal Daftar</label>
          <input type="date" name="tanggal_daftar" value="<?= h($editData['tanggal_daftar'] ?? date('Y-m-d')) ?>" required>
          <label>Status</label>
          <select name="status">
            <?php foreach (['Aktif','Alumni','Nonaktif'] as $st): ?>
            <option value="<?= $st ?>" <?= (($editData['status'] ?? '')==$st)?'selected':'' ?>><?= $st ?></option>
            <?php endforeach; ?>
          </select>
          <button type="submit" class="btn btn-primary">Simpan</button>
          <a href="ijk-data-siswa.php" class="btn btn-outline">Batal</a>
        </form>

      <?php else: ?>
        <div class="page-head">
          <h3 style="color:var(--navy);">Daftar Siswa</h3>
          <a href="ijk-data-siswa.php?aksi=tambah" class="btn btn-gold"><i class="fa-solid fa-plus"></i> Tambah Siswa</a>
        </div>
        <div class="table-wrap">
          <form method="GET" style="margin-bottom:16px;">
            <input type="text" name="q" placeholder="Cari nama / NIS / kelas..." value="<?= h($search) ?>" style="padding:9px 14px;border:1px solid var(--border);border-radius:8px;width:280px;">
            <button class="btn btn-outline" type="submit">Cari</button>
          </form>
          <table>
            <tr><th>No</th><th>NIS</th><th>Nama</th><th>Kelas</th><th>Tanggal Daftar</th><th>Status</th><th>Aksi</th></tr>
            <?php foreach ($siswaList as $i => $s): ?>
            <tr>
              <td><?= $i+1 ?></td>
              <td><?= h($s['nis']) ?></td>
              <td><?= h($s['nama']) ?></td>
              <td><?= h($s['kelas']) ?></td>
              <td><?= formatTanggal($s['tanggal_daftar']) ?></td>
              <td><span class="badge badge-<?= $s['status']=='Aktif'?'green':($s['status']=='Alumni'?'blue':'red') ?>"><?= h($s['status']) ?></span></td>
              <td class="action-icons">
                <a href="ijk-data-siswa.php?aksi=edit&id=<?= $s['id'] ?>" title="Edit"><i class="fa-solid fa-pen"></i></a>
                <a href="ijk-data-siswa.php?aksi=hapus&id=<?= $s['id'] ?>" class="danger" title="Hapus" onclick="return confirm('Hapus data ini?')"><i class="fa-solid fa-trash"></i></a>
              </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($siswaList)): ?>
            <tr><td colspan="7" style="text-align:center;color:var(--gray);">Belum ada data.</td></tr>
            <?php endif; ?>
          </table>
        </div>
      <?php endif; ?>

    </div>
  </div>
</div>
</body>
</html>
