
<?php
require_once __DIR__ . '/../includes/ijk-functions.php';
requireLogin();

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$db = getDB();
$pageTitle = 'Kelola Fasilitas';

$uploadDir = __DIR__ . '/../uploads/';
$uploadUrl = '../uploads/';

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if (empty($_SESSION['csrf_fasilitas'])) {
    $_SESSION['csrf_fasilitas'] = bin2hex(random_bytes(32));
}

$pesan = '';
$error = '';
$editData = null;

function hapusGambarFasilitas($namaFile, $uploadDir)
{
    if (!$namaFile || basename($namaFile) !== $namaFile) {
        return;
    }

    $path = $uploadDir . $namaFile;

    if (is_file($path)) {
        unlink($path);
    }
}

function uploadGambarFasilitas($field, $uploadDir)
{
    if (
        !isset($_FILES[$field]) ||
        $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE
    ) {
        return null;
    }

    $file = $_FILES[$field];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Upload gambar gagal. Silakan coba lagi.');
    }

    if ($file['size'] > 5 * 1024 * 1024) {
        throw new RuntimeException('Ukuran gambar maksimal 5 MB.');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);

    $jenisFile = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
    ];

    if (!isset($jenisFile[$mime])) {
        throw new RuntimeException(
            'Format gambar harus JPG, PNG, atau WEBP.'
        );
    }

    $namaFile = bin2hex(random_bytes(16))
        . '.' . $jenisFile[$mime];

    if (!move_uploaded_file(
        $file['tmp_name'],
        $uploadDir . $namaFile
    )) {
        throw new RuntimeException(
            'Gambar tidak berhasil disimpan ke folder uploads.'
        );
    }

    return $namaFile;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';

    if (!hash_equals($_SESSION['csrf_fasilitas'], $token)) {
        $error = 'Permintaan tidak valid. Silakan muat ulang halaman.';
    } else {
        $aksi = $_POST['aksi'] ?? '';

        try {
            if ($aksi === 'tambah' || $aksi === 'edit') {
                $nama = trim($_POST['nama'] ?? '');
                $icon = trim($_POST['icon'] ?? '');

                if ($nama === '') {
                    throw new RuntimeException(
                        'Nama fasilitas wajib diisi.'
                    );
                }

                if (strlen($nama) > 150) {
                    throw new RuntimeException(
                        'Nama fasilitas maksimal 150 karakter.'
                    );
                }

                if (strlen($icon) > 100) {
                    throw new RuntimeException(
                        'Ikon maksimal 100 karakter.'
                    );
                }

                $id = (int)($_POST['id'] ?? 0);
                $gambarBaru = null;

                if ($aksi === 'edit') {
                    $stmt = $db->prepare(
                        'SELECT gambar FROM fasilitas WHERE id = ?'
                    );
                    $stmt->execute([$id]);
                    $dataLama = $stmt->fetch();

                    if (!$dataLama) {
                        throw new RuntimeException(
                            'Data fasilitas tidak ditemukan.'
                        );
                    }
                }

                $gambarBaru = uploadGambarFasilitas(
                    'gambar',
                    $uploadDir
                );

                if ($aksi === 'tambah') {
                    $stmt = $db->prepare(
                        'INSERT INTO fasilitas (nama, icon, gambar)
                         VALUES (?, ?, ?)'
                    );

                    $stmt->execute([
                        $nama,
                        $icon,
                        $gambarBaru
                    ]);

                    $pesan = 'Fasilitas berhasil ditambahkan.';
                } else {
                    if ($gambarBaru !== null) {
                        $stmt = $db->prepare(
                            'UPDATE fasilitas
                             SET nama = ?, icon = ?, gambar = ?
                             WHERE id = ?'
                        );

                        $stmt->execute([
                            $nama,
                            $icon,
                            $gambarBaru,
                            $id
                        ]);

                        hapusGambarFasilitas(
                            $dataLama['gambar'] ?? '',
                            $uploadDir
                        );
                    } else {
                        $stmt = $db->prepare(
                            'UPDATE fasilitas
                             SET nama = ?, icon = ?
                             WHERE id = ?'
                        );

                        $stmt->execute([
                            $nama,
                            $icon,
                            $id
                        ]);
                    }

                    $pesan = 'Fasilitas berhasil diperbarui.';
                }
            } elseif ($aksi === 'hapus') {
                $id = (int)($_POST['id'] ?? 0);

                $stmt = $db->prepare(
                    'SELECT gambar FROM fasilitas WHERE id = ?'
                );
                $stmt->execute([$id]);
                $dataHapus = $stmt->fetch();

                if (!$dataHapus) {
                    throw new RuntimeException(
                        'Data fasilitas tidak ditemukan.'
                    );
                }

                $stmt = $db->prepare(
                    'DELETE FROM fasilitas WHERE id = ?'
                );
                $stmt->execute([$id]);

                hapusGambarFasilitas(
                    $dataHapus['gambar'] ?? '',
                    $uploadDir
                );

                $pesan = 'Fasilitas berhasil dihapus.';
            }
        } catch (Throwable $e) {
            $error = $e instanceof RuntimeException
                ? $e->getMessage()
                : 'Terjadi kesalahan saat menyimpan data fasilitas.';
        }
    }
}

if (isset($_GET['edit'])) {
    $stmt = $db->prepare(
        'SELECT id, nama, icon, gambar
         FROM fasilitas WHERE id = ?'
    );
    $stmt->execute([(int)$_GET['edit']]);
    $editData = $stmt->fetch();

    if (!$editData) {
        $error = 'Data fasilitas tidak ditemukan.';
    }
}

$fasilitas = $db->query(
    'SELECT id, nama, icon, gambar
     FROM fasilitas ORDER BY id DESC'
)->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= h($pageTitle) ?> - Admin SMK Infokom</title>

    <link rel="stylesheet" href="../assets/css/ijk-admin.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        .fasilitas-form {
            display: grid;
            gap: 15px;
            max-width: 650px;
        }

        .fasilitas-form label {
            display: block;
            font-weight: 600;
            margin-bottom: 7px;
        }

        .fasilitas-form input {
            width: 100%;
            box-sizing: border-box;
            padding: 11px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
        }

        .fasilitas-form input[type="file"] {
            background: #fff;
        }

        .fasilitas-btn {
            display: inline-block;
            border: 0;
            border-radius: 7px;
            padding: 9px 13px;
            text-decoration: none;
            cursor: pointer;
            font-weight: 600;
        }

        .fasilitas-btn-primary {
            background: #f5b400;
            color: #0e1a3d;
        }

        .fasilitas-btn-edit {
            background: #2563eb;
            color: #fff;
        }

        .fasilitas-btn-delete {
            background: #dc2626;
            color: #fff;
        }

        .fasilitas-alert {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 18px;
        }

        .fasilitas-success {
            background: #dcfce7;
            color: #166534;
        }

        .fasilitas-error {
            background: #fee2e2;
            color: #991b1b;
        }

        .fasilitas-actions {
            display: flex;
            gap: 7px;
            flex-wrap: wrap;
        }

        .fasilitas-preview {
            width: 180px;
            max-width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 9px;
            border: 1px solid #e5e7eb;
            display: block;
            margin-top: 10px;
        }

        .fasilitas-thumb {
            width: 85px;
            height: 60px;
            object-fit: cover;
            border-radius: 7px;
        }

        .fasilitas-no-image {
            color: #64748b;
            font-size: 12px;
        }
    </style>
</head>
<body>
<div class="admin-wrap">
    <?php include __DIR__ . '/includes/ijk-sidebar.php'; ?>

    <div class="main">
        <?php include __DIR__ . '/includes/ijk-topbar.php'; ?>

        <div class="content">
            <div class="page-head">
                <h3 style="color:var(--navy);">
                    Kelola Fasilitas Sekolah
                </h3>
            </div>

            <?php if ($pesan !== ''): ?>
                <div class="fasilitas-alert fasilitas-success">
                    <?= h($pesan) ?>
                </div>
            <?php endif; ?>

            <?php if ($error !== ''): ?>
                <div class="fasilitas-alert fasilitas-error">
                    <?= h($error) ?>
                </div>
            <?php endif; ?>

            <div class="panel" style="margin-bottom:24px;">
                <h3>
                    <?= $editData ? 'Edit Fasilitas' : 'Tambah Fasilitas' ?>
                </h3>

                <form method="post"
                      enctype="multipart/form-data"
                      class="fasilitas-form">

                    <input type="hidden" name="csrf_token"
                           value="<?= h($_SESSION['csrf_fasilitas']) ?>">

                    <input type="hidden" name="aksi"
                           value="<?= $editData ? 'edit' : 'tambah' ?>">

                    <?php if ($editData): ?>
                        <input type="hidden" name="id"
                               value="<?= (int)$editData['id'] ?>">
                    <?php endif; ?>

                    <div>
                        <label for="nama">Nama Fasilitas</label>
                        <input type="text" id="nama" name="nama"
                               maxlength="150" required
                               placeholder="Contoh: Laboratorium Komputer"
                               value="<?= h($editData['nama'] ?? '') ?>">
                    </div>

                    <div>
                        <label for="icon">Ikon (opsional)</label>
                        <input type="text" id="icon" name="icon"
                               maxlength="100"
                               placeholder="Contoh: fa-computer"
                               value="<?= h($editData['icon'] ?? '') ?>">
                        <small>
                            Contoh ikon Font Awesome: fa-computer,
                            fa-book, atau fa-building.
                        </small>
                    </div>

                    <div>
                        <label for="gambar">Foto Fasilitas (opsional)</label>

                        <input type="hidden" name="MAX_FILE_SIZE"
                               value="5242880">

                        <input type="file" id="gambar" name="gambar"
                               accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">

                        <small>
                            Format JPG, PNG, atau WEBP. Maksimal 5 MB.
                            Saat edit, kosongkan jika tidak ingin mengganti foto.
                        </small>

                        <?php if (
                            $editData &&
                            !empty($editData['gambar']) &&
                            basename($editData['gambar']) === $editData['gambar'] &&
                            is_file($uploadDir . $editData['gambar'])
                        ): ?>
                            <p>Foto saat ini:</p>
                            <img
                                class="fasilitas-preview"
                                src="<?= h($uploadUrl . $editData['gambar']) ?>"
                                alt="Foto fasilitas saat ini"
                            >
                        <?php endif; ?>

                        <img id="previewGambar"
                             class="fasilitas-preview"
                             alt="Preview foto baru"
                             style="display:none;">
                    </div>

                    <div class="fasilitas-actions">
                        <button type="submit"
                                class="fasilitas-btn fasilitas-btn-primary">
                            <?= $editData ? 'Simpan Perubahan' : 'Tambah Fasilitas' ?>
                        </button>

                        <?php if ($editData): ?>
                            <a href="ijk-fasilitas.php"
                               class="fasilitas-btn fasilitas-btn-edit">
                                Batal Edit
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <div class="panel">
                <h3>Daftar Fasilitas (<?= count($fasilitas) ?>)</h3>

                <div style="overflow-x:auto;">
                    <table>
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Foto</th>
                            <th>Nama Fasilitas</th>
                            <th>Ikon</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php if (empty($fasilitas)): ?>
                            <tr>
                                <td colspan="5" style="text-align:center;">
                                    Belum ada fasilitas. Tambahkan melalui form di atas.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($fasilitas as $i => $f): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>

                                    <td>
                                        <?php if (
                                            !empty($f['gambar']) &&
                                            basename($f['gambar']) === $f['gambar'] &&
                                            is_file($uploadDir . $f['gambar'])
                                        ): ?>
                                            <img
                                                class="fasilitas-thumb"
                                                src="<?= h($uploadUrl . $f['gambar']) ?>"
                                                alt="<?= h($f['nama']) ?>"
                                            >
                                        <?php else: ?>
                                            <span class="fasilitas-no-image">
                                                Belum ada foto
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td><?= h($f['nama']) ?></td>
                                    <td><?= h($f['icon'] ?? '') ?></td>

                                    <td>
                                        <div class="fasilitas-actions">
                                            <a
                                                class="fasilitas-btn fasilitas-btn-edit"
                                                href="ijk-fasilitas.php?edit=<?= (int)$f['id'] ?>">
                                                Edit
                                            </a>

                                            <form method="post"
                                                  action="ijk-fasilitas.php"
                                                  onsubmit="return confirm('Yakin ingin menghapus fasilitas ini beserta fotonya?');">

                                                <input type="hidden"
                                                       name="csrf_token"
                                                       value="<?= h($_SESSION['csrf_fasilitas']) ?>">

                                                <input type="hidden"
                                                       name="aksi"
                                                       value="hapus">

                                                <input type="hidden"
                                                       name="id"
                                                       value="<?= (int)$f['id'] ?>">

                                                <button type="submit"
                                                        class="fasilitas-btn fasilitas-btn-delete">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const inputGambar = document.getElementById('gambar');
const previewGambar = document.getElementById('previewGambar');

inputGambar.addEventListener('change', function () {
    const file = this.files[0];

    if (!file) {
        previewGambar.src = '';
        previewGambar.style.display = 'none';
        return;
    }

    const tipeDiizinkan = [
        'image/jpeg',
        'image/png',
        'image/webp'
    ];

    if (!tipeDiizinkan.includes(file.type)) {
        alert('Pilih gambar JPG, PNG, atau WEBP.');
        this.value = '';
        previewGambar.style.display = 'none';
        return;
    }

    if (file.size > 5 * 1024 * 1024) {
        alert('Ukuran gambar maksimal 5 MB.');
        this.value = '';
        previewGambar.style.display = 'none';
        return;
    }

    previewGambar.src = URL.createObjectURL(file);
    previewGambar.style.display = 'block';
});
</script>
</body>
</html>
