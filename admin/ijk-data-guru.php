<?php
require_once __DIR__ . '/../includes/ijk-functions.php';
requireLogin();
$db = getDB();
$pageTitle = 'Data Guru';
$aksi = $_GET['aksi'] ?? 'list';
$id = $_GET['id'] ?? null;
$uploadDir = __DIR__ . '/../uploads/guru';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $mapel = trim($_POST['mapel']);
    $jabatan = trim($_POST['jabatan']);
    $status = $_POST['status'];
    $foto = uploadGambar('foto', $uploadDir);

    if (!empty($_POST['id'])) {
        if ($foto) {
            $stmt = $db->prepare("UPDATE guru SET nama=?, mapel=?, jabatan=?, status=?, foto=? WHERE id=?");
            $stmt->execute([$nama, $mapel, $jabatan, $status, $foto, $_POST['id']]);
        } else {
            $stmt = $db->prepare("UPDATE guru SET nama=?, mapel=?, jabatan=?, status=? WHERE id=?");
            $stmt->execute([$nama, $mapel, $jabatan, $status, $_POST['id']]);
        }
        catatLog("Mengubah data guru: $nama");
        setFlash('success', 'Data guru berhasil diperbarui.');
    } else {
        $stmt = $db->prepare("INSERT INTO guru (nip, nama, mapel, jabatan, status, foto) VALUES (?,?,?,?,?,?)");
        $stmt->execute([uniqid('G'), $nama, $mapel, $jabatan, $status, $foto]);
        catatLog("Menambah data guru: $nama");
        setFlash('success', 'Data guru berhasil ditambahkan.');
    }
    redirect('ijk-data-guru.php');
}

if ($aksi === 'hapus' && $id) {
    $stmt = $db->prepare("SELECT nama FROM guru WHERE id=?");
    $stmt->execute([$id]);
    $nama = $stmt->fetchColumn();
    $db->prepare("DELETE FROM guru WHERE id=?")->execute([$id]);
    catatLog("Menghapus data guru: $nama");
    setFlash('success', 'Data guru berhasil dihapus.');
    redirect('ijk-data-guru.php');
}

$editData = null;
if ($aksi === 'edit' && $id) {
    $stmt = $db->prepare("SELECT * FROM guru WHERE id=?");
    $stmt->execute([$id]);
    $editData = $stmt->fetch();
}

// URUTKAN BERDASARKAN PANGKAT/JABATAN AGAR RAPI DI TABEL
$guruList = $db->query("
    SELECT * FROM guru 
    ORDER BY 
        CASE 
            WHEN LOWER(jabatan) LIKE '%kepala sekolah%' THEN 1
            WHEN LOWER(jabatan) LIKE '%wakil%' THEN 2
            WHEN LOWER(jabatan) LIKE '%kepala program%' THEN 3
            ELSE 4
        END ASC, 
        nama ASC
")->fetchAll();

$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Guru - Admin</title>
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

      <?php if ($aksi === 'tambah' || $aksi === 'edit'): ?>
        <div class="page-head"><h3 style="color:var(--navy);"><?= $aksi==='edit'?'Edit':'Tambah' ?> Data Guru</h3></div>
        <form method="POST" enctype="multipart/form-data" class="form-box">
          <input type="hidden" name="id" value="<?= h($editData['id'] ?? '') ?>">
          <label>Nama Lengkap & Gelar</label>
          <input type="text" name="nama" value="<?= h($editData['nama'] ?? '') ?>" required placeholder="Contoh: Ir. Hj. Liliek Rahmaningsih, M.M.Pd.">
          
          <label>Mata Pelajaran</label>
          <input type="text" name="mapel" value="<?= h($editData['mapel'] ?? '') ?>">
          
          <label>Jabatan</label>
          <input type="text" name="jabatan" value="<?= h($editData['jabatan'] ?? 'Guru') ?>" placeholder="Contoh: Wakil Kepala Sekolah Bidang Kurikulum">
          
          <label>Status</label>
          <select name="status">
            <option value="Aktif" <?= (($editData['status'] ?? '')=='Aktif')?'selected':'' ?>>Aktif</option>
            <option value="Nonaktif" <?= (($editData['status'] ?? '')=='Nonaktif')?'selected':'' ?>>Nonaktif</option>
          </select>
          <?php if (!empty($editData['foto'])): ?>
          <label>Foto Saat Ini</label>
          <img src="../uploads/guru/<?= h($editData['foto']) ?>" style="width:100px;height:100px;object-fit:cover;object-position:top center;border-radius:50%;margin-bottom:14px;display:block;">
          <?php endif; ?>
          <label>Foto Guru</label>
          <input type="file" name="foto" accept="image/*">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <a href="ijk-data-guru.php" class="btn btn-outline">Batal</a>
        </form>
      <?php else: ?>
        <div class="page-head">
          <h3 style="color:var(--navy);">Daftar Guru & Staff</h3>
          <a href="ijk-data-guru.php?aksi=tambah" class="btn btn-gold"><i class="fa-solid fa-plus"></i> Tambah Guru</a>
        </div>
        <div class="table-wrap">
          <table>
            <tr><th>No</th><th>Foto</th><th>Nama Lengkap</th><th>Mapel</th><th>Jabatan</th><th>Status</th><th>Aksi</th></tr>
            <?php foreach ($guruList as $i => $g): ?>
            <tr>
              <td><?= $i+1 ?></td>
              <td>
                <?php if (!empty($g['foto'])): ?>
                <img src="../uploads/guru/<?= h($g['foto']) ?>" style="width:40px;height:40px;object-fit:cover;object-position:top center;border-radius:50%;">
                <?php else: ?>
                <span style="color:var(--gray);font-size:11px;">-</span>
                <?php endif; ?>
              </td>
              <td><?= h($g['nama']) ?></td>
              <td><?= h($g['mapel']) ?></td>
              <td><?= h($g['jabatan']) ?></td>
              <td><span class="badge badge-<?= $g['status']=='Aktif'?'green':'red' ?>"><?= h($g['status']) ?></span></td>
              <td class="action-icons">
                <a href="ijk-data-guru.php?aksi=edit&id=<?= $g['id'] ?>"><i class="fa-solid fa-pen"></i></a>
                <a href="ijk-data-guru.php?aksi=hapus&id=<?= $g['id'] ?>" class="danger" onclick="return confirm('Hapus data ini?')"><i class="fa-solid fa-trash"></i></a>
              </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($guruList)): ?><tr><td colspan="7" style="text-align:center;color:var(--gray);">Belum ada data.</td></tr><?php endif; ?>
          </table>
        </div>
      <?php endif; ?>

    </div>
  </div>
</div>
</body>
</html>