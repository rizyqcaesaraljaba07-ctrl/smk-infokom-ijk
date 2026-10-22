<?php
require_once __DIR__ . '/../includes/ijk-functions.php';
requireLogin();
$db = getDB();
$pageTitle = 'Pengaturan';
$uploadDirHero = __DIR__ . '/../uploads/pengaturan';
$uploadDirLogo = __DIR__ . '/../uploads/logo';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $heroImage = uploadGambar('hero_image', $uploadDirHero);
    $logoImage = uploadGambar('logo', $uploadDirLogo);

    $fields = [
        'nama_sekolah'  => trim($_POST['nama_sekolah']),
        'alamat'        => trim($_POST['alamat']),
        'telepon'       => trim($_POST['telepon']),
        'email'         => trim($_POST['email']),
        'instagram'     => trim($_POST['instagram']),
        'youtube'       => trim($_POST['youtube']),
        'tiktok'        => trim($_POST['tiktok']),
        'facebook'      => trim($_POST['facebook']),
        'maps_embed'    => trim($_POST['maps_embed']),
        'jumlah_alumni' => trim($_POST['jumlah_alumni']),
    ];

    $setParts = [];
    $params   = [];
    foreach ($fields as $k => $v) {
        $setParts[] = "$k=?";
        $params[]   = $v;
    }
    if ($heroImage) {
        $setParts[] = "hero_image=?";
        $params[]   = $heroImage;
    }
    if ($logoImage) {
        $setParts[] = "logo=?";
        $params[]   = $logoImage;
    }

    $sql = "UPDATE pengaturan SET " . implode(', ', $setParts) . " WHERE id=1";
    $db->prepare($sql)->execute($params);

    catatLog('Memperbarui pengaturan umum sekolah');
    setFlash('success', 'Pengaturan berhasil disimpan.');
    redirect('ijk-pengaturan.php');
}

$p = getPengaturan();
$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><title>Pengaturan - Admin</title>
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

      <div class="page-head"><h3 style="color:var(--navy);">Pengaturan Umum Sekolah</h3></div>

      <form method="POST" enctype="multipart/form-data" class="form-box" style="max-width:700px;">

        <!-- ===== LOGO SEKOLAH ===== -->
        <h4 style="color:var(--navy);margin-bottom:12px;border-bottom:1px solid var(--border);padding-bottom:8px;">
          <i class="fa-solid fa-image"></i> Logo Sekolah
        </h4>

        <?php if (!empty($p['logo'])): ?>
          <label>Logo Saat Ini</label>
          <img src="../uploads/logo/<?= h($p['logo']) ?>" style="width:80px;height:80px;object-fit:contain;background:#f4f6fb;padding:8px;border-radius:10px;margin-bottom:14px;display:block;">
        <?php endif; ?>

        <label>Upload Logo Sekolah (PNG transparan disarankan)</label>
        <input type="file" name="logo" accept="image/*">
        <small style="color:var(--gray);font-size:12px;display:block;margin-bottom:20px;">
          Logo akan tampil di navbar kiri atas.
        </small>

        <!-- ===== FOTO HERO ===== -->
        <h4 style="color:var(--navy);margin-bottom:12px;border-bottom:1px solid var(--border);padding-bottom:8px;">
          <i class="fa-solid fa-panorama"></i> Foto Hero Beranda
        </h4>

        <?php if (!empty($p['hero_image'])): ?>
          <label>Foto Hero Saat Ini</label>
          <img src="../uploads/pengaturan/<?= h($p['hero_image']) ?>" style="width:100%;max-width:300px;border-radius:8px;margin-bottom:14px;display:block;">
        <?php endif; ?>

        <label>Ganti Foto Hero / Gedung Sekolah</label>
        <input type="file" name="hero_image" accept="image/*">
        <small style="color:var(--gray);font-size:12px;display:block;margin-bottom:20px;">
          Foto ini tampil di banner beranda.
        </small>

        <!-- ===== INFO SEKOLAH ===== -->
        <h4 style="color:var(--navy);margin-bottom:12px;border-bottom:1px solid var(--border);padding-bottom:8px;">
          <i class="fa-solid fa-school"></i> Informasi Sekolah
        </h4>

        <label>Nama Sekolah</label>
        <input type="text" name="nama_sekolah" value="<?= h($p['nama_sekolah']) ?>" required>

        <label>Alamat</label>
        <input type="text" name="alamat" value="<?= h($p['alamat']) ?>" required>

        <label>Telepon</label>
        <input type="text" name="telepon" value="<?= h($p['telepon']) ?>">

        <label>Email</label>
        <input type="email" name="email" value="<?= h($p['email']) ?>">

        <label>Jumlah Alumni (teks, contoh: 1.250+)</label>
        <input type="text" name="jumlah_alumni" value="<?= h($p['jumlah_alumni']) ?>">

        <!-- ===== SOSIAL MEDIA ===== -->
        <h4 style="color:var(--navy);margin:20px 0 12px;border-bottom:1px solid var(--border);padding-bottom:8px;">
          <i class="fa-solid fa-share-nodes"></i> Sosial Media
        </h4>

        <label>Instagram URL</label>
        <input type="text" name="instagram" value="<?= h($p['instagram']) ?>">

        <label>YouTube URL</label>
        <input type="text" name="youtube" value="<?= h($p['youtube']) ?>">

        <label>TikTok URL</label>
        <input type="text" name="tiktok" value="<?= h($p['tiktok']) ?>">

        <label>Facebook URL</label>
        <input type="text" name="facebook" value="<?= h($p['facebook']) ?>">

        <!-- ===== MAPS ===== -->
        <h4 style="color:var(--navy);margin:20px 0 12px;border-bottom:1px solid var(--border);padding-bottom:8px;">
          <i class="fa-solid fa-map-location-dot"></i> Lokasi Google Maps
        </h4>

        <label>Kode Embed Google Maps (tag &lt;iframe&gt;)</label>
        <textarea name="maps_embed" rows="4"><?= h($p['maps_embed']) ?></textarea>
        <p style="font-size:12px;color:var(--gray);margin-bottom:16px;">
          Dapatkan kode embed dari Google Maps: buka maps.google.com &rarr; cari lokasi &rarr; Bagikan &rarr; Sematkan peta &rarr; salin kode &lt;iframe&gt;.
        </p>

        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan Pengaturan</button>
      </form>

      <div class="panel" style="margin-top:24px;max-width:700px;">
        <h3>Pratinjau Peta di Footer</h3>
        <div style="border-radius:10px;overflow:hidden;">
          <?= $p['maps_embed'] ?: '<p>Belum ada peta.</p>' ?>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>