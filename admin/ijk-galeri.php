<?php
require_once __DIR__ . '/../includes/ijk-functions.php';
requireLogin();
$db = getDB();
$pageTitle = 'Galeri';
$aksi = $_GET['aksi'] ?? 'list';
$id = $_GET['id'] ?? null;
$uploadDir = __DIR__ . '/../uploads/galeri';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = trim($_POST['judul']);
    $kategori = trim($_POST['kategori']);
    $tanggal = $_POST['tanggal'] ?: date('Y-m-d');
    $gambar = uploadGambar('gambar', $uploadDir);

    if (!empty($_POST['id'])) {
        if ($gambar) {
            $stmt = $db->prepare("UPDATE galeri SET judul=?, kategori=?, tanggal=?, gambar=? WHERE id=?");
            $stmt->execute([$judul, $kategori, $tanggal, $gambar, $_POST['id']]);
        } else {
            $stmt = $db->prepare("UPDATE galeri SET judul=?, kategori=?, tanggal=? WHERE id=?");
            $stmt->execute([$judul, $kategori, $tanggal, $_POST['id']]);
        }
        catatLog("Mengubah item galeri: $judul");
        setFlash('success', 'Galeri berhasil diperbarui.');
    } else {
        $stmt = $db->prepare("INSERT INTO galeri (judul, kategori, tanggal, gambar) VALUES (?,?,?,?)");
        $stmt->execute([$judul, $kategori, $tanggal, $gambar ?: 'default.jpg']);
        catatLog("Menambah item galeri: $judul");
        setFlash('success', 'Galeri berhasil ditambahkan.');
    }
    redirect('ijk-galeri.php');
}

if ($aksi === 'hapus' && $id) {
    $db->prepare("DELETE FROM galeri WHERE id=?")->execute([$id]);
    catatLog("Menghapus item galeri ID $id");
    setFlash('success', 'Galeri berhasil dihapus.');
    redirect('ijk-galeri.php');
}

$editData = null;
if ($aksi === 'edit' && $id) {
    $stmt = $db->prepare("SELECT * FROM galeri WHERE id=?");
    $stmt->execute([$id]);
    $editData = $stmt->fetch();
}
$list = $db->query("SELECT * FROM galeri ORDER BY id DESC")->fetchAll();
$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><title>Galeri - Admin</title>
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

      <?php if ($aksi==='tambah' || $aksi==='edit'): ?>
        <div class="page-head"><h3 style="color:var(--navy);"><?= $aksi==='edit'?'Edit':'Tambah' ?> Item Galeri</h3></div>
        <form method="POST" enctype="multipart/form-data" class="form-box">
          <input type="hidden" name="id" value="<?= h($editData['id'] ?? '') ?>">
          <label>Judul</label>
          <input type="text" name="judul" value="<?= h($editData['judul'] ?? '') ?>" required>
          <label>Kategori</label>
          <input type="text" name="kategori" value="<?= h($editData['kategori'] ?? 'Kegiatan') ?>">
          <label>Tanggal</label>
          <input type="date" name="tanggal" value="<?= h($editData['tanggal'] ?? date('Y-m-d')) ?>">
          <label>Foto</label>
          <input type="file" name="gambar" accept="image/*" <?= $aksi==='tambah'?'required':'' ?>>
          <button type="submit" class="btn btn-primary">Simpan</button>
          <a href="ijk-galeri.php" class="btn btn-outline">Batal</a>
        </form>
      <?php else: ?>
        <div class="page-head">
          <h3 style="color:var(--navy);">Galeri Kegiatan</h3>
          <a href="ijk-galeri.php?aksi=tambah" class="btn btn-gold"><i class="fa-solid fa-plus"></i> Tambah Galeri</a>
        </div>
        <div class="table-wrap">
          <table>
            <tr><th>No</th><th>Judul</th><th>Kategori</th><th>Tanggal</th><th>Aksi</th></tr>
            <?php foreach ($list as $i => $row): ?>
            <tr>
              <td><?= $i+1 ?></td>
              <td><?= h($row['judul']) ?></td>
              <td><?= h($row['kategori']) ?></td>
              <td><?= formatTanggal($row['tanggal']) ?></td>
              <td class="action-icons">
                <a href="ijk-galeri.php?aksi=edit&id=<?= $row['id'] ?>"><i class="fa-solid fa-pen"></i></a>
                <a href="ijk-galeri.php?aksi=hapus&id=<?= $row['id'] ?>" class="danger" onclick="return confirm('Hapus data ini?')"><i class="fa-solid fa-trash"></i></a>
              </td>
            </tr>
            <?php endforeach; ?>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
</body>
</html>
