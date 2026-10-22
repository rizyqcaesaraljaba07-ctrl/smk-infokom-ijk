<?php
require_once __DIR__ . '/../includes/ijk-functions.php';
requireLogin();
$db = getDB();
$pageTitle = 'Ekstrakurikuler';
$aksi = $_GET['aksi'] ?? 'list';
$id = $_GET['id'] ?? null;
$uploadDir = __DIR__ . '/../uploads/ekstrakurikuler';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $deskripsi = trim($_POST['deskripsi']);
    $pembina = trim($_POST['pembina']);
    $foto = uploadGambar('foto', $uploadDir);

    if (!empty($_POST['id'])) {
        if ($foto) {
            $stmt = $db->prepare("UPDATE ekstrakurikuler SET nama=?, deskripsi=?, pembina=?, foto=? WHERE id=?");
            $stmt->execute([$nama, $deskripsi, $pembina, $foto, $_POST['id']]);
        } else {
            $stmt = $db->prepare("UPDATE ekstrakurikuler SET nama=?, deskripsi=?, pembina=? WHERE id=?");
            $stmt->execute([$nama, $deskripsi, $pembina, $_POST['id']]);
        }
        catatLog("Mengubah ekstrakurikuler: $nama");
        setFlash('success', 'Data berhasil diperbarui.');
    } else {
        $stmt = $db->prepare("INSERT INTO ekstrakurikuler (nama, deskripsi, pembina, foto) VALUES (?,?,?,?)");
        $stmt->execute([$nama, $deskripsi, $pembina, $foto]);
        catatLog("Menambah ekstrakurikuler: $nama");
        setFlash('success', 'Data berhasil ditambahkan.');
    }
    redirect('ijk-ekstrakurikuler.php');
}

if ($aksi === 'hapus' && $id) {
    $db->prepare("DELETE FROM ekstrakurikuler WHERE id=?")->execute([$id]);
    catatLog("Menghapus ekstrakurikuler ID $id");
    setFlash('success', 'Data berhasil dihapus.');
    redirect('ijk-ekstrakurikuler.php');
}

$editData = null;
if ($aksi === 'edit' && $id) {
    $stmt = $db->prepare("SELECT * FROM ekstrakurikuler WHERE id=?");
    $stmt->execute([$id]);
    $editData = $stmt->fetch();
}
$list = $db->query("SELECT * FROM ekstrakurikuler ORDER BY id ASC")->fetchAll();
$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><title>Ekstrakurikuler - Admin</title>
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
        <div class="page-head"><h3 style="color:var(--navy);"><?= $aksi==='edit'?'Edit':'Tambah' ?> Ekstrakurikuler</h3></div>
        <form method="POST" enctype="multipart/form-data" class="form-box">
          <input type="hidden" name="id" value="<?= h($editData['id'] ?? '') ?>">
          <label>Nama Kegiatan</label>
          <input type="text" name="nama" value="<?= h($editData['nama'] ?? '') ?>" required>
          <label>Pembina</label>
          <input type="text" name="pembina" value="<?= h($editData['pembina'] ?? '') ?>">
          <label>Deskripsi</label>
          <textarea name="deskripsi" rows="3"><?= h($editData['deskripsi'] ?? '') ?></textarea>
          <?php if (!empty($editData['foto'])): ?>
          <label>Foto Saat Ini</label>
          <img src="../uploads/ekstrakurikuler/<?= h($editData['foto']) ?>" style="width:120px;border-radius:8px;margin-bottom:14px;">
          <?php endif; ?>
          <label>Foto Kegiatan</label>
          <input type="file" name="foto" accept="image/*">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <a href="ijk-ekstrakurikuler.php" class="btn btn-outline">Batal</a>
        </form>
      <?php else: ?>
        <div class="page-head">
          <h3 style="color:var(--navy);">Daftar Ekstrakurikuler</h3>
          <a href="ijk-ekstrakurikuler.php?aksi=tambah" class="btn btn-gold"><i class="fa-solid fa-plus"></i> Tambah</a>
        </div>
        <div class="table-wrap">
          <table>
            <tr><th>No</th><th>Foto</th><th>Nama</th><th>Pembina</th><th>Aksi</th></tr>
            <?php foreach ($list as $i => $row): ?>
            <tr>
              <td><?= $i+1 ?></td>
              <td>
                <?php if (!empty($row['foto'])): ?>
                <img src="../uploads/ekstrakurikuler/<?= h($row['foto']) ?>" style="width:44px;height:44px;object-fit:cover;border-radius:6px;">
                <?php else: ?>
                <span style="color:var(--gray);font-size:11px;">-</span>
                <?php endif; ?>
              </td>
              <td><?= h($row['nama']) ?></td>
              <td><?= h($row['pembina']) ?></td>
              <td class="action-icons">
                <a href="ijk-ekstrakurikuler.php?aksi=edit&id=<?= $row['id'] ?>"><i class="fa-solid fa-pen"></i></a>
                <a href="ijk-ekstrakurikuler.php?aksi=hapus&id=<?= $row['id'] ?>" class="danger" onclick="return confirm('Hapus data ini?')"><i class="fa-solid fa-trash"></i></a>
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
