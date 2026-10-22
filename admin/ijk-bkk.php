<?php
require_once __DIR__ . '/../includes/ijk-functions.php';
requireLogin();
$db = getDB();
$pageTitle = 'BKK / Lowongan';
$aksi = $_GET['aksi'] ?? 'list';
$id = $_GET['id'] ?? null;
$uploadDir = __DIR__ . '/../uploads/bkk';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mitra_id   = !empty($_POST['mitra_id']) ? (int)$_POST['mitra_id'] : null;
    $posisi     = trim($_POST['posisi']);
    $lokasi     = trim($_POST['lokasi']);
    $tipe       = in_array($_POST['tipe'] ?? '', ['Full Time','Part Time','Magang','Kontrak'], true) ? $_POST['tipe'] : 'Full Time';
    $jurusan    = trim($_POST['jurusan']);
    $deskripsi  = trim($_POST['deskripsi']);
    $kualifikasi= trim($_POST['kualifikasi']);
    $link       = urlAman($_POST['link_daftar'] ?? '');
    $batas      = !empty($_POST['batas_akhir']) ? $_POST['batas_akhir'] : null;
    $status     = (($_POST['status'] ?? '') === 'Tutup') ? 'Tutup' : 'Buka';
    $gambarBaru = uploadGambar('gambar', $uploadDir);

    if (!empty($_POST['id'])) {
        if ($gambarBaru) {
            $stmt = $db->prepare("UPDATE bkk_lowongan SET mitra_id=?, posisi=?, gambar=?, lokasi=?, tipe=?, jurusan=?, deskripsi=?, kualifikasi=?, link_daftar=?, batas_akhir=?, status=? WHERE id=?");
            $stmt->execute([$mitra_id, $posisi, $gambarBaru, $lokasi, $tipe, $jurusan, $deskripsi, $kualifikasi, $link, $batas, $status, $_POST['id']]);
        } else {
            $stmt = $db->prepare("UPDATE bkk_lowongan SET mitra_id=?, posisi=?, lokasi=?, tipe=?, jurusan=?, deskripsi=?, kualifikasi=?, link_daftar=?, batas_akhir=?, status=? WHERE id=?");
            $stmt->execute([$mitra_id, $posisi, $lokasi, $tipe, $jurusan, $deskripsi, $kualifikasi, $link, $batas, $status, $_POST['id']]);
        }
        catatLog("Mengubah lowongan BKK: $posisi");
        setFlash('success', 'Lowongan berhasil diperbarui.');
    } else {
        $stmt = $db->prepare("INSERT INTO bkk_lowongan (mitra_id, posisi, gambar, lokasi, tipe, jurusan, deskripsi, kualifikasi, link_daftar, batas_akhir, status) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute([$mitra_id, $posisi, $gambarBaru, $lokasi, $tipe, $jurusan, $deskripsi, $kualifikasi, $link, $batas, $status]);
        catatLog("Menambah lowongan BKK: $posisi");
        setFlash('success', 'Lowongan berhasil ditambahkan.');
    }
    redirect('ijk-bkk.php');
}

if ($aksi === 'hapus' && $id) {
    $db->prepare("DELETE FROM bkk_lowongan WHERE id=?")->execute([$id]);
    catatLog("Menghapus lowongan BKK ID $id");
    setFlash('success', 'Lowongan berhasil dihapus.');
    redirect('ijk-bkk.php');
}

$editData = null;
if ($aksi === 'edit' && $id) {
    $stmt = $db->prepare("SELECT * FROM bkk_lowongan WHERE id=?");
    $stmt->execute([$id]);
    $editData = $stmt->fetch();
}
$mitraOpsi = $db->query("SELECT id, nama FROM mitra WHERE status='Aktif' ORDER BY nama ASC")->fetchAll();
$list = $db->query("SELECT b.*, m.nama AS mitra_nama FROM bkk_lowongan b LEFT JOIN mitra m ON b.mitra_id = m.id ORDER BY b.id DESC")->fetchAll();
$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><title>BKK - Admin</title>
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
        <div class="page-head"><h3 style="color:var(--navy);"><?= $aksi==='edit'?'Edit':'Tambah' ?> Lowongan BKK</h3></div>
        <form method="POST" enctype="multipart/form-data" class="form-box" style="max-width:700px;">
          <input type="hidden" name="id" value="<?= h($editData['id'] ?? '') ?>">

          <label>Perusahaan / Mitra</label>
          <select name="mitra_id">
            <option value="">- Tanpa mitra / lainnya -</option>
            <?php foreach ($mitraOpsi as $m): ?>
              <option value="<?= $m['id'] ?>" <?= (($editData['mitra_id'] ?? '') == $m['id'])?'selected':'' ?>><?= h($m['nama']) ?></option>
            <?php endforeach; ?>
          </select>
          <small style="color:var(--gray);font-size:12px;display:block;margin:-8px 0 12px;">Belum ada mitra? <a href="ijk-mitra.php?aksi=tambah" style="color:var(--navy);font-weight:600;">Tambah mitra baru</a></small>

          <label>Posisi</label>
          <input type="text" name="posisi" value="<?= h($editData['posisi'] ?? '') ?>" required>

          <?php if (!empty($editData['gambar'])): ?>
            <label>Gambar Banner Saat Ini</label>
            <img src="../uploads/bkk/<?= h($editData['gambar']) ?>" style="width:100%;max-width:400px;height:auto;border-radius:10px;margin-bottom:12px;display:block;border:1px solid var(--border);">
          <?php endif; ?>
          <label>Gambar Banner Lowongan (opsional, JPG/PNG/WEBP)</label>
          <input type="file" name="gambar" accept="image/*">

          <label>Lokasi</label>
          <input type="text" name="lokasi" value="<?= h($editData['lokasi'] ?? '') ?>" placeholder="Contoh: Bogor">

          <label>Tipe</label>
          <select name="tipe">
            <?php foreach (['Full Time','Part Time','Magang','Kontrak'] as $t): ?>
            <option value="<?= $t ?>" <?= (($editData['tipe'] ?? '')==$t)?'selected':'' ?>><?= $t ?></option>
            <?php endforeach; ?>
          </select>

          <label>Jurusan yang Dibutuhkan</label>
          <input type="text" name="jurusan" value="<?= h($editData['jurusan'] ?? '') ?>" placeholder="Contoh: RPL / TKJ, atau Semua jurusan">

          <label>Deskripsi Pekerjaan</label>
          <textarea name="deskripsi" rows="4"><?= h($editData['deskripsi'] ?? '') ?></textarea>

          <label>Kualifikasi</label>
          <textarea name="kualifikasi" rows="4" placeholder="Satu baris per poin"><?= h($editData['kualifikasi'] ?? '') ?></textarea>

          <label>Link Pendaftaran (opsional)</label>
          <input type="text" name="link_daftar" value="<?= h($editData['link_daftar'] ?? '') ?>" placeholder="https://...">

          <label>Batas Akhir Pendaftaran (kosongkan jika tidak ada)</label>
          <input type="date" name="batas_akhir" value="<?= h($editData['batas_akhir'] ?? '') ?>">

          <label>Status</label>
          <select name="status">
            <option value="Buka" <?= (($editData['status'] ?? '')=='Buka')?'selected':'' ?>>Buka</option>
            <option value="Tutup" <?= (($editData['status'] ?? '')=='Tutup')?'selected':'' ?>>Tutup</option>
          </select>

          <button type="submit" class="btn btn-primary">Simpan</button>
          <a href="ijk-bkk.php" class="btn btn-outline">Batal</a>
        </form>
      <?php else: ?>
        <div class="page-head">
          <h3 style="color:var(--navy);">Lowongan BKK</h3>
          <a href="ijk-bkk.php?aksi=tambah" class="btn btn-gold"><i class="fa-solid fa-plus"></i> Tambah Lowongan</a>
        </div>
        <div class="table-wrap">
          <table>
            <tr><th>No</th><th>Gambar</th><th>Posisi</th><th>Mitra</th><th>Tipe</th><th>Batas Akhir</th><th>Status</th><th>Aksi</th></tr>
            <?php foreach ($list as $i => $row):
              $kedaluwarsa = $row['batas_akhir'] && $row['batas_akhir'] < date('Y-m-d'); ?>
            <tr>
              <td><?= $i+1 ?></td>
              <td>
                <?php if (!empty($row['gambar'])): ?>
                  <img src="../uploads/bkk/<?= h($row['gambar']) ?>" style="width:60px;height:40px;object-fit:cover;border-radius:6px;">
                <?php else: ?>
                  <span style="color:var(--gray);font-size:11px;">-</span>
                <?php endif; ?>
              </td>
              <td><?= h($row['posisi']) ?></td>
              <td><?= h($row['mitra_nama'] ?? '-') ?></td>
              <td><?= h($row['tipe']) ?></td>
              <td><?= $row['batas_akhir'] ? formatTanggal($row['batas_akhir']) : '-' ?></td>
              <td>
                <?php if ($row['status']==='Buka' && $kedaluwarsa): ?>
                  <span class="badge badge-gold">Kedaluwarsa</span>
                <?php else: ?>
                  <span class="badge badge-<?= $row['status']=='Buka'?'green':'red' ?>"><?= h($row['status']) ?></span>
                <?php endif; ?>
              </td>
              <td class="action-icons">
                <a href="ijk-bkk.php?aksi=edit&id=<?= $row['id'] ?>"><i class="fa-solid fa-pen"></i></a>
                <a href="ijk-bkk.php?aksi=hapus&id=<?= $row['id'] ?>" class="danger" onclick="return confirm('Hapus lowongan ini?')"><i class="fa-solid fa-trash"></i></a>
              </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($list)): ?><tr><td colspan="8" style="text-align:center;color:var(--gray);">Belum ada lowongan.</td></tr><?php endif; ?>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
</body>
</html> 