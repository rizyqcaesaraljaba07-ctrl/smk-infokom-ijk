<?php
require_once __DIR__ . '/../includes/ijk-functions.php';
requireLogin();
$db = getDB();
$pageTitle = 'Program Keahlian';
$aksi = $_GET['aksi'] ?? 'list';
$id = $_GET['id'] ?? null;
$uploadDir = __DIR__ . '/../uploads/program';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode = trim($_POST['kode']);
    $nama = trim($_POST['nama']);
    $slug = buatSlug($_POST['nama']);
    $deskripsi = trim($_POST['deskripsi']);
    $icon = trim($_POST['icon']);
    $foto = uploadGambar('foto', $uploadDir);

    if (!empty($_POST['id'])) {
        if ($foto) {
            $stmt = $db->prepare("UPDATE program_keahlian SET kode=?, nama=?, slug=?, deskripsi=?, icon=?, foto=? WHERE id=?");
            $stmt->execute([$kode, $nama, $slug, $deskripsi, $icon, $foto, $_POST['id']]);
        } else {
            $stmt = $db->prepare("UPDATE program_keahlian SET kode=?, nama=?, slug=?, deskripsi=?, icon=? WHERE id=?");
            $stmt->execute([$kode, $nama, $slug, $deskripsi, $icon, $_POST['id']]);
        }
        catatLog("Mengubah program keahlian: $nama");
        setFlash('success', 'Program keahlian berhasil diperbarui.');
    } else {
        $stmt = $db->prepare("INSERT INTO program_keahlian (kode, nama, slug, deskripsi, icon, foto) VALUES (?,?,?,?,?,?)");
        $stmt->execute([$kode, $nama, $slug, $deskripsi, $icon, $foto]);
        catatLog("Menambah program keahlian: $nama");
        setFlash('success', 'Program keahlian berhasil ditambahkan.');
    }
    redirect('ijk-program-keahlian.php');
}

if ($aksi === 'hapus' && $id) {
    $db->prepare("DELETE FROM program_keahlian WHERE id=?")->execute([$id]);
    catatLog("Menghapus program keahlian ID $id");
    setFlash('success', 'Program keahlian berhasil dihapus.');
    redirect('ijk-program-keahlian.php');
}

$editData = null;
if ($aksi === 'edit' && $id) {
    $stmt = $db->prepare("SELECT * FROM program_keahlian WHERE id=?");
    $stmt->execute([$id]);
    $editData = $stmt->fetch();
}
$list = $db->query("SELECT * FROM program_keahlian ORDER BY urutan ASC")->fetchAll();
$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><title>Program Keahlian - Admin</title>
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
        <div class="page-head"><h3 style="color:var(--navy);"><?= $aksi==='edit'?'Edit':'Tambah' ?> Program Keahlian</h3></div>
        <form method="POST" enctype="multipart/form-data" class="form-box">
          <input type="hidden" name="id" value="<?= h($editData['id'] ?? '') ?>">
          <label>Kode</label>
          <input type="text" name="kode" value="<?= h($editData['kode'] ?? '') ?>" placeholder="RPL" required>
          <label>Nama Program</label>
          <input type="text" name="nama" value="<?= h($editData['nama'] ?? '') ?>" required>
          <label>Deskripsi</label>
          <textarea name="deskripsi" rows="3"><?= h($editData['deskripsi'] ?? '') ?></textarea>
          <label>Icon (nama Font Awesome, contoh: code, network, cart, image)</label>
          <input type="text" name="icon" value="<?= h($editData['icon'] ?? 'code') ?>">
          <?php if (!empty($editData['foto'])): ?>
          <label>Foto Saat Ini</label>
          <img src="../uploads/program/<?= h($editData['foto']) ?>" style="width:120px;border-radius:8px;margin-bottom:14px;">
          <?php endif; ?>
          <label>Foto Program</label>
          <input type="file" name="foto" accept="image/*">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <a href="ijk-program-keahlian.php" class="btn btn-outline">Batal</a>
        </form>
      <?php else: ?>
        <div class="page-head">
          <h3 style="color:var(--navy);">Program Keahlian</h3>
          <a href="ijk-program-keahlian.php?aksi=tambah" class="btn btn-gold"><i class="fa-solid fa-plus"></i> Tambah Program</a>
        </div>
        <div class="table-wrap">
          <table>
            <tr><th>No</th><th>Foto</th><th>Kode</th><th>Nama</th><th>Deskripsi</th><th>Aksi</th></tr>
            <?php foreach ($list as $i => $row): ?>
            <tr>
              <td><?= $i+1 ?></td>
              <td>
                <?php if (!empty($row['foto'])): ?>
                <img src="../uploads/program/<?= h($row['foto']) ?>" style="width:44px;height:44px;object-fit:cover;border-radius:6px;">
                <?php else: ?>
                <span style="color:var(--gray);font-size:11px;">-</span>
                <?php endif; ?>
              </td>
              <td><?= h($row['kode']) ?></td>
              <td><?= h($row['nama']) ?></td>
              <td><?= h($row['deskripsi']) ?></td>
              <td class="action-icons">
                <a href="ijk-program-keahlian.php?aksi=edit&id=<?= $row['id'] ?>"><i class="fa-solid fa-pen"></i></a>
                <a href="ijk-program-keahlian.php?aksi=hapus&id=<?= $row['id'] ?>" class="danger" onclick="return confirm('Hapus data ini?')"><i class="fa-solid fa-trash"></i></a>
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
