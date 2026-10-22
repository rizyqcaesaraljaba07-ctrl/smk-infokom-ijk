<?php
require_once __DIR__ . '/../includes/ijk-functions.php';
requireLogin();
$db = getDB();
$pageTitle = 'Mitra Kerja Sama';
$aksi = $_GET['aksi'] ?? 'list';
$id = $_GET['id'] ?? null;
$uploadDir = __DIR__ . '/../uploads/mitra';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama      = trim($_POST['nama']);
    $bidang    = trim($_POST['bidang']);
    $website   = urlAman($_POST['website'] ?? '');
    $urutan    = (int)($_POST['urutan'] ?? 0);
    $status    = (($_POST['status'] ?? '') === 'Nonaktif') ? 'Nonaktif' : 'Aktif';
    $jenis     = trim($_POST['jenis'] ?? 'PT');
    $lingkup   = trim($_POST['lingkup'] ?? 'Dalam Negeri');
    $kerjasama = trim($_POST['kerjasama'] ?? '');
    $kategori  = trim($_POST['kategori'] ?? 'Industri/DUDI');
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    $logo      = uploadGambar('logo', $uploadDir);

    if (!empty($_POST['id'])) {
        if ($logo) {
            $stmt = $db->prepare("UPDATE mitra SET nama=?, bidang=?, website=?, urutan=?, status=?, jenis=?, lingkup=?, kerjasama=?, kategori=?, deskripsi=?, logo=? WHERE id=?");
            $stmt->execute([$nama, $bidang, $website, $urutan, $status, $jenis, $lingkup, $kerjasama, $kategori, $deskripsi, $logo, $_POST['id']]);
        } else {
            $stmt = $db->prepare("UPDATE mitra SET nama=?, bidang=?, website=?, urutan=?, status=?, jenis=?, lingkup=?, kerjasama=?, kategori=?, deskripsi=? WHERE id=?");
            $stmt->execute([$nama, $bidang, $website, $urutan, $status, $jenis, $lingkup, $kerjasama, $kategori, $deskripsi, $_POST['id']]);
        }
        catatLog("Mengubah mitra: $nama");
        setFlash('success', 'Data mitra berhasil diperbarui.');
    } else {
        $stmt = $db->prepare("INSERT INTO mitra (nama, bidang, website, urutan, status, jenis, lingkup, kerjasama, kategori, deskripsi, logo) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute([$nama, $bidang, $website, $urutan, $status, $jenis, $lingkup, $kerjasama, $kategori, $deskripsi, $logo]);
        catatLog("Menambah mitra: $nama");
        setFlash('success', 'Mitra berhasil ditambahkan.');
    }
    redirect('ijk-mitra.php');
}

if ($aksi === 'hapus' && $id) {
    $db->prepare("DELETE FROM mitra WHERE id=?")->execute([$id]);
    catatLog("Menghapus mitra ID $id");
    setFlash('success', 'Mitra berhasil dihapus.');
    redirect('ijk-mitra.php');
}

$editData = null;
if ($aksi === 'edit' && $id) {
    $stmt = $db->prepare("SELECT * FROM mitra WHERE id=?");
    $stmt->execute([$id]);
    $editData = $stmt->fetch();
}
$list = $db->query("SELECT * FROM mitra ORDER BY urutan ASC, nama ASC")->fetchAll();
$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><title>Mitra Kerja Sama - Admin</title>
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
        <div class="page-head"><h3 style="color:var(--navy);"><?= $aksi==='edit'?'Edit':'Tambah' ?> Mitra</h3></div>
        <form method="POST" enctype="multipart/form-data" class="form-box">
          <input type="hidden" name="id" value="<?= h($editData['id'] ?? '') ?>">
          
          <label>Nama Perusahaan / Instansi</label>
          <input type="text" name="nama" value="<?= h($editData['nama'] ?? '') ?>" required>
          
          <label>Bidang Usaha</label>
          <input type="text" name="bidang" value="<?= h($editData['bidang'] ?? '') ?>" placeholder="Contoh: Telekomunikasi & Jaringan">
          
          <label>Jenis Instansi</label>
          <select name="jenis">
            <?php foreach (['PT','CV','Instansi','UMKM','Lembaga Pelatihan','Perguruan Tinggi'] as $j): ?>
              <option value="<?= $j ?>" <?= (($editData['jenis'] ?? 'PT')==$j)?'selected':'' ?>><?= $j ?></option>
            <?php endforeach; ?>
          </select>
          
          <label>Lingkup</label>
          <select name="lingkup">
            <?php foreach (['Dalam Negeri','Luar Negeri'] as $l): ?>
              <option value="<?= $l ?>" <?= (($editData['lingkup'] ?? 'Dalam Negeri')==$l)?'selected':'' ?>><?= $l ?></option>
            <?php endforeach; ?>
          </select>
          
          <label>Kategori (untuk filter)</label>
          <select name="kategori">
            <?php foreach (['Industri/DUDI','Lembaga Pelatihan','Perguruan Tinggi'] as $k): ?>
              <option value="<?= $k ?>" <?= (($editData['kategori'] ?? 'Industri/DUDI')==$k)?'selected':'' ?>><?= $k ?></option>
            <?php endforeach; ?>
          </select>
          
          <label>Bentuk Kerja Sama</label>
          <input type="text" name="kerjasama" value="<?= h($editData['kerjasama'] ?? '') ?>" placeholder="Contoh: PKL Jurusan TKJ, Instalasi FTTH">
          
          <label>Deskripsi (opsional, untuk halaman detail)</label>
          <textarea name="deskripsi" rows="4" style="width:100%;padding:10px;border:1px solid var(--border);border-radius:8px;font-family:inherit;"><?= h($editData['deskripsi'] ?? '') ?></textarea>
          
          <label>Website (opsional)</label>
          <input type="text" name="website" value="<?= h($editData['website'] ?? '') ?>" placeholder="https://contoh.co.id">
          
          <label>Urutan Tampil (angka kecil tampil duluan)</label>
          <input type="number" name="urutan" value="<?= h($editData['urutan'] ?? 0) ?>">
          
          <label>Status</label>
          <select name="status">
            <option value="Aktif" <?= (($editData['status'] ?? '')=='Aktif')?'selected':'' ?>>Aktif</option>
            <option value="Nonaktif" <?= (($editData['status'] ?? '')=='Nonaktif')?'selected':'' ?>>Nonaktif</option>
          </select>
          
          <?php if (!empty($editData['logo'])): ?>
          <label>Logo Saat Ini</label>
          <img src="../uploads/mitra/<?= h($editData['logo']) ?>" style="width:140px;height:70px;object-fit:contain;background:#f4f6fb;padding:6px;border-radius:8px;margin-bottom:14px;display:block;">
          <?php endif; ?>
          
          <label>Logo (JPG / PNG / WEBP)</label>
          <input type="file" name="logo" accept="image/*">
          
          <button type="submit" class="btn btn-primary">Simpan</button>
          <a href="ijk-mitra.php" class="btn btn-outline">Batal</a>
        </form>
      <?php else: ?>
        <div class="page-head">
          <h3 style="color:var(--navy);">Mitra Kerja Sama</h3>
          <a href="ijk-mitra.php?aksi=tambah" class="btn btn-gold"><i class="fa-solid fa-plus"></i> Tambah Mitra</a>
        </div>
        <div class="table-wrap">
          <table>
            <tr><th>No</th><th>Logo</th><th>Nama</th><th>Bidang</th><th>Kategori</th><th>Urutan</th><th>Status</th><th>Aksi</th></tr>
            <?php foreach ($list as $i => $row): ?>
            <tr>
              <td><?= $i+1 ?></td>
              <td>
                <?php if (!empty($row['logo'])): ?>
                <img src="../uploads/mitra/<?= h($row['logo']) ?>" style="width:60px;height:36px;object-fit:contain;background:#f4f6fb;border-radius:6px;padding:3px;">
                <?php else: ?>
                <span style="color:var(--gray);font-size:11px;">-</span>
                <?php endif; ?>
              </td>
              <td><?= h($row['nama']) ?></td>
              <td><?= h($row['bidang']) ?></td>
              <td><span class="badge badge-green" style="font-size:10px;"><?= h($row['kategori'] ?? '-') ?></span></td>
              <td><?= (int)$row['urutan'] ?></td>
              <td><span class="badge badge-<?= $row['status']=='Aktif'?'green':'red' ?>"><?= h($row['status']) ?></span></td>
              <td class="action-icons">
                <a href="ijk-mitra.php?aksi=edit&id=<?= $row['id'] ?>"><i class="fa-solid fa-pen"></i></a>
                <a href="ijk-mitra.php?aksi=hapus&id=<?= $row['id'] ?>" class="danger" onclick="return confirm('Hapus mitra ini?')"><i class="fa-solid fa-trash"></i></a>
              </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($list)): ?><tr><td colspan="8" style="text-align:center;color:var(--gray);">Belum ada mitra.</td></tr><?php endif; ?>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
</body>
</html>