<?php
require_once __DIR__ . '/../includes/ijk-functions.php';
requireLogin();
$db = getDB();
$pageTitle = 'Magang'; // <-- UBAH
$aksi = $_GET['aksi'] ?? 'list';
$id = $_GET['id'] ?? null;
$uploadDir = __DIR__ . '/../uploads/magang-jepang';

if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul    = trim($_POST['judul']);
    $konten   = trim($_POST['konten']);
    $kategori = trim($_POST['kategori'] ?? 'Umum');
    $urutan   = (int)($_POST['urutan'] ?? 0);
    $status   = (($_POST['status'] ?? '') === 'Nonaktif') ? 'Nonaktif' : 'Aktif';
    $gambar   = uploadGambar('gambar', $uploadDir);

    if (!empty($_POST['id'])) {
        if ($gambar) {
            $stmt = $db->prepare("UPDATE magang_jepang SET judul=?, konten=?, kategori=?, urutan=?, status=?, gambar=? WHERE id=?");
            $stmt->execute([$judul, $konten, $kategori, $urutan, $status, $gambar, $_POST['id']]);
        } else {
            $stmt = $db->prepare("UPDATE magang_jepang SET judul=?, konten=?, kategori=?, urutan=?, status=? WHERE id=?");
            $stmt->execute([$judul, $konten, $kategori, $urutan, $status, $_POST['id']]);
        }
        catatLog("Mengubah info Magang: $judul"); // <-- UBAH
        setFlash('success', 'Info Magang berhasil diperbarui.'); // <-- UBAH
    } else {
        $stmt = $db->prepare("INSERT INTO magang_jepang (judul, konten, kategori, urutan, status, gambar) VALUES (?,?,?,?,?,?)");
        $stmt->execute([$judul, $konten, $kategori, $urutan, $status, $gambar]);
        catatLog("Menambah info Magang: $judul"); // <-- UBAH
        setFlash('success', 'Info Magang berhasil ditambahkan.'); // <-- UBAH
    }
    redirect('ijk-magang-jepang.php');
}

if ($aksi === 'hapus' && $id) {
    $db->prepare("DELETE FROM magang_jepang WHERE id=?")->execute([$id]);
    catatLog("Menghapus info Magang ID $id"); // <-- UBAH
    setFlash('success', 'Info Magang berhasil dihapus.'); // <-- UBAH
    redirect('ijk-magang-jepang.php');
}

$editData = null;
if ($aksi === 'edit' && $id) {
    $stmt = $db->prepare("SELECT * FROM magang_jepang WHERE id=?");
    $stmt->execute([$id]);
    $editData = $stmt->fetch();
}
$list = $db->query("SELECT * FROM magang_jepang ORDER BY urutan ASC, id DESC")->fetchAll();
$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><title>Magang - Admin</title> <!-- <-- UBAH -->
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
        <!-- UBAH DI SINI -->
        <div class="page-head"><h3 style="color:var(--navy);"><?= $aksi==='edit'?'Edit':'Tambah' ?> Info Magang</h3></div>
        <form method="POST" enctype="multipart/form-data" class="form-box" style="max-width:700px;">
          <input type="hidden" name="id" value="<?= h($editData['id'] ?? '') ?>">

          <label>Judul</label>
          <input type="text" name="judul" value="<?= h($editData['judul'] ?? '') ?>" required>

          <label>Kategori</label>
          <select name="kategori">
            <?php foreach (['Umum','Syarat','Timeline','Pengumuman','Testimoni'] as $k): ?>
              <option value="<?= $k ?>" <?= (($editData['kategori'] ?? 'Umum')==$k)?'selected':'' ?>><?= $k ?></option>
            <?php endforeach; ?>
          </select>

          <label>Konten</label>
          <textarea name="konten" rows="10"><?= h($editData['konten'] ?? '') ?></textarea>

          <?php if (!empty($editData['gambar'])): ?>
            <label>Gambar Saat Ini</label>
            <img src="../uploads/magang-jepang/<?= h($editData['gambar']) ?>" style="width:200px;border-radius:8px;margin-bottom:12px;display:block;">
          <?php endif; ?>
          <label>Gambar (opsional)</label>
          <input type="file" name="gambar" accept="image/*">

          <label>Urutan Tampil</label>
          <input type="number" name="urutan" value="<?= h($editData['urutan'] ?? 0) ?>">

          <label>Status</label>
          <select name="status">
            <option value="Aktif" <?= (($editData['status'] ?? '')=='Aktif')?'selected':'' ?>>Aktif</option>
            <option value="Nonaktif" <?= (($editData['status'] ?? '')=='Nonaktif')?'selected':'' ?>>Nonaktif</option>
          </select>

          <button type="submit" class="btn btn-primary">Simpan</button>
          <a href="ijk-magang-jepang.php" class="btn btn-outline">Batal</a>
        </form>
      <?php else: ?>
        <div class="page-head">
          <!-- UBAH DI SINI -->
          <h3 style="color:var(--navy);">Info Magang</h3>
          <a href="ijk-magang-jepang.php?aksi=tambah" class="btn btn-gold"><i class="fa-solid fa-plus"></i> Tambah Info</a>
        </div>
        <div class="table-wrap">
          <table>
            <tr><th>No</th><th>Judul</th><th>Kategori</th><th>Urutan</th><th>Status</th><th>Aksi</th></tr>
            <?php foreach ($list as $i => $row): ?>
            <tr>
              <td><?= $i+1 ?></td>
              <td><?= h($row['judul']) ?></td>
              <td><span class="badge badge-green" style="font-size:11px;"><?= h($row['kategori']) ?></span></td>
              <td><?= (int)$row['urutan'] ?></td>
              <td><span class="badge badge-<?= $row['status']=='Aktif'?'green':'red' ?>"><?= h($row['status']) ?></span></td>
              <td class="action-icons">
                <a href="ijk-magang-jepang.php?aksi=edit&id=<?= $row['id'] ?>"><i class="fa-solid fa-pen"></i></a>
                <a href="ijk-magang-jepang.php?aksi=hapus&id=<?= $row['id'] ?>" class="danger" onclick="return confirm('Hapus info ini?')"><i class="fa-solid fa-trash"></i></a>
              </td>
            </tr>
            <?php endforeach; ?>
            <!-- UBAH DI SINI -->
            <?php if (empty($list)): ?><tr><td colspan="6" style="text-align:center;color:var(--gray);">Belum ada info Magang.</td></tr><?php endif; ?>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
</body>
</html>