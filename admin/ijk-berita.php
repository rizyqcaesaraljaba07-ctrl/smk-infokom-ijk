<?php
require_once __DIR__ . '/../includes/ijk-functions.php';
requireLogin();
$db = getDB();
$pageTitle = 'Berita & Informasi';
$aksi = $_GET['aksi'] ?? 'list';
$id = $_GET['id'] ?? null;
$uploadDir = __DIR__ . '/../uploads/berita';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = trim($_POST['judul']);
    $slug = buatSlug($judul) . '-' . time();
    $kategori = trim($_POST['kategori']);
    $isi = trim($_POST['isi']);
    $tanggal = $_POST['tanggal'];
    $gambar = uploadGambar('gambar', $uploadDir);

    if (!empty($_POST['id'])) {
        if ($gambar) {
            $stmt = $db->prepare("UPDATE berita SET judul=?, kategori=?, isi=?, tanggal=?, gambar=? WHERE id=?");
            $stmt->execute([$judul, $kategori, $isi, $tanggal, $gambar, $_POST['id']]);
        } else {
            $stmt = $db->prepare("UPDATE berita SET judul=?, kategori=?, isi=?, tanggal=? WHERE id=?");
            $stmt->execute([$judul, $kategori, $isi, $tanggal, $_POST['id']]);
        }
        catatLog("Mengubah data berita");
        setFlash('success', 'Berita berhasil diperbarui.');
    } else {
        $stmt = $db->prepare("INSERT INTO berita (judul, slug, kategori, isi, tanggal, gambar, penulis) VALUES (?,?,?,?,?,?,?)");
        $stmt->execute([$judul, $slug, $kategori, $isi, $tanggal, $gambar, $_SESSION['admin_nama']]);
        catatLog("Menambah berita baru");
        setFlash('success', 'Berita berhasil ditambahkan.');
    }
    redirect('ijk-berita.php');
}

if ($aksi === 'hapus' && $id) {
    $db->prepare("DELETE FROM berita WHERE id=?")->execute([$id]);
    catatLog("Menghapus berita ID $id");
    setFlash('success', 'Berita berhasil dihapus.');
    redirect('ijk-berita.php');
}

$editData = null;
if ($aksi === 'edit' && $id) {
    $stmt = $db->prepare("SELECT * FROM berita WHERE id=?");
    $stmt->execute([$id]);
    $editData = $stmt->fetch();
}
$list = $db->query("SELECT * FROM berita ORDER BY tanggal DESC")->fetchAll();
$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><title>Berita - Admin</title>
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
        <div class="page-head"><h3 style="color:var(--navy);"><?= $aksi==='edit'?'Edit':'Tambah' ?> Berita</h3></div>
        <form method="POST" enctype="multipart/form-data" class="form-box">
          <input type="hidden" name="id" value="<?= h($editData['id'] ?? '') ?>">
          <label>Judul Berita</label>
          <input type="text" name="judul" value="<?= h($editData['judul'] ?? '') ?>" required>
          <label>Kategori</label>
          <input type="text" name="kategori" value="<?= h($editData['kategori'] ?? 'Umum') ?>">
          <label>Tanggal</label>
          <input type="date" name="tanggal" value="<?= h($editData['tanggal'] ?? date('Y-m-d')) ?>" required>
          <label>Gambar Sampul</label>
          <input type="file" name="gambar" accept="image/*">
          <label>Isi Berita</label>
          <textarea name="isi" rows="6" required><?= h($editData['isi'] ?? '') ?></textarea>
          <button type="submit" class="btn btn-primary">Simpan</button>
          <a href="ijk-berita.php" class="btn btn-outline">Batal</a>
        </form>
      <?php else: ?>
        <div class="page-head">
          <h3 style="color:var(--navy);">Daftar Berita</h3>
          <a href="ijk-berita.php?aksi=tambah" class="btn btn-gold"><i class="fa-solid fa-plus"></i> Tambah Berita</a>
        </div>
        <div class="table-wrap">
          <table>
            <tr><th>No</th><th>Judul</th><th>Kategori</th><th>Tanggal</th><th>Dilihat</th><th>Aksi</th></tr>
            <?php foreach ($list as $i => $row): ?>
            <tr>
              <td><?= $i+1 ?></td>
              <td><?= h($row['judul']) ?></td>
              <td><?= h($row['kategori']) ?></td>
              <td><?= formatTanggal($row['tanggal']) ?></td>
              <td><?= (int)$row['dilihat'] ?></td>
              <td class="action-icons">
                <a href="ijk-berita.php?aksi=edit&id=<?= $row['id'] ?>"><i class="fa-solid fa-pen"></i></a>
                <a href="ijk-berita.php?aksi=hapus&id=<?= $row['id'] ?>" class="danger" onclick="return confirm('Hapus data ini?')"><i class="fa-solid fa-trash"></i></a>
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
