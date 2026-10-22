<?php
require_once __DIR__ . '/../includes/ijk-functions.php';
requireLogin();
$db = getDB();
$pageTitle = 'Prestasi';
$aksi = $_GET['aksi'] ?? 'list';
$id = $_GET['id'] ?? null;
$uploadDir = __DIR__ . '/../uploads/prestasi';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = trim($_POST['judul']);
    $kategori = trim($_POST['kategori']);
    $tingkat = $_POST['tingkat'];
    $tanggal = $_POST['tanggal'];
    $deskripsi = trim($_POST['deskripsi']);
    $gambar = uploadGambar('gambar', $uploadDir);

    if (!empty($_POST['id'])) {
        if ($gambar) {
            $stmt = $db->prepare("UPDATE prestasi SET judul=?, kategori=?, tingkat=?, tanggal=?, deskripsi=?, gambar=? WHERE id=?");
            $stmt->execute([$judul, $kategori, $tingkat, $tanggal, $deskripsi, $gambar, $_POST['id']]);
        } else {
            $stmt = $db->prepare("UPDATE prestasi SET judul=?, kategori=?, tingkat=?, tanggal=?, deskripsi=? WHERE id=?");
            $stmt->execute([$judul, $kategori, $tingkat, $tanggal, $deskripsi, $_POST['id']]);
        }
        catatLog("Mengubah prestasi: $judul");
        setFlash('success', 'Prestasi berhasil diperbarui.');
    } else {
        $stmt = $db->prepare("INSERT INTO prestasi (judul, kategori, tingkat, tanggal, deskripsi, gambar) VALUES (?,?,?,?,?,?)");
        $stmt->execute([$judul, $kategori, $tingkat, $tanggal, $deskripsi, $gambar]);
        catatLog("Menambah prestasi: $judul");
        setFlash('success', 'Prestasi berhasil ditambahkan.');
    }
    redirect('ijk-prestasi.php');
}

if ($aksi === 'hapus' && $id) {
    $db->prepare("DELETE FROM prestasi WHERE id=?")->execute([$id]);
    catatLog("Menghapus prestasi ID $id");
    setFlash('success', 'Prestasi berhasil dihapus.');
    redirect('ijk-prestasi.php');
}

$editData = null;
if ($aksi === 'edit' && $id) {
    $stmt = $db->prepare("SELECT * FROM prestasi WHERE id=?");
    $stmt->execute([$id]);
    $editData = $stmt->fetch();
}
$list = $db->query("SELECT * FROM prestasi ORDER BY tanggal DESC")->fetchAll();
$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><title>Prestasi - Admin</title>
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
        <div class="page-head"><h3 style="color:var(--navy);"><?= $aksi==='edit'?'Edit':'Tambah' ?> Prestasi</h3></div>
        <form method="POST" enctype="multipart/form-data" class="form-box">
          <input type="hidden" name="id" value="<?= h($editData['id'] ?? '') ?>">
          <label>Judul Prestasi</label>
          <input type="text" name="judul" value="<?= h($editData['judul'] ?? '') ?>" required>
          <label>Kategori</label>
          <input type="text" name="kategori" value="<?= h($editData['kategori'] ?? '') ?>">
          <label>Tingkat</label>
          <select name="tingkat">
            <?php foreach (['Sekolah','Kota','Provinsi','Nasional','Internasional'] as $t): ?>
            <option value="<?= $t ?>" <?= (($editData['tingkat'] ?? '')==$t)?'selected':'' ?>><?= $t ?></option>
            <?php endforeach; ?>
          </select>
          <label>Tanggal</label>
          <input type="date" name="tanggal" value="<?= h($editData['tanggal'] ?? date('Y-m-d')) ?>" required>
          <label>Deskripsi</label>
          <textarea name="deskripsi" rows="3"><?= h($editData['deskripsi'] ?? '') ?></textarea>
          <?php if (!empty($editData['gambar'])): ?>
          <label>Foto Saat Ini</label>
          <img src="../uploads/prestasi/<?= h($editData['gambar']) ?>" style="width:120px;border-radius:8px;margin-bottom:14px;">
          <?php endif; ?>
          <label>Foto Prestasi</label>
          <input type="file" name="gambar" accept="image/*">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <a href="ijk-prestasi.php" class="btn btn-outline">Batal</a>
        </form>
      <?php else: ?>
        <div class="page-head">
          <h3 style="color:var(--navy);">Daftar Prestasi</h3>
          <a href="ijk-prestasi.php?aksi=tambah" class="btn btn-gold"><i class="fa-solid fa-plus"></i> Tambah Prestasi</a>
        </div>
        <div class="table-wrap">
          <table>
            <tr><th>No</th><th>Foto</th><th>Judul</th><th>Tingkat</th><th>Tanggal</th><th>Aksi</th></tr>
            <?php foreach ($list as $i => $row): ?>
            <tr>
              <td><?= $i+1 ?></td>
              <td>
                <?php if (!empty($row['gambar'])): ?>
                <img src="../uploads/prestasi/<?= h($row['gambar']) ?>" style="width:44px;height:44px;object-fit:cover;border-radius:6px;">
                <?php else: ?>
                <span style="color:var(--gray);font-size:11px;">-</span>
                <?php endif; ?>
              </td>
              <td><?= h($row['judul']) ?></td>
              <td><span class="badge badge-gold"><?= h($row['tingkat']) ?></span></td>
              <td><?= formatTanggal($row['tanggal']) ?></td>
              <td class="action-icons">
                <a href="ijk-prestasi.php?aksi=edit&id=<?= $row['id'] ?>"><i class="fa-solid fa-pen"></i></a>
                <a href="ijk-prestasi.php?aksi=hapus&id=<?= $row['id'] ?>" class="danger" onclick="return confirm('Hapus data ini?')"><i class="fa-solid fa-trash"></i></a>
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
