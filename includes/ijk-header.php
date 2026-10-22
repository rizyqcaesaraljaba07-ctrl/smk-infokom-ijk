<?php
require_once __DIR__ . '/ijk-functions.php';
$p = getPengaturan();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= h($p['nama_sekolah'] ?? 'SMK Infokom Kota Bogor') ?></title>

    <!-- FAVICON DINAMIS -->
    <?php if (!empty($p['logo'])): ?>
        <link rel="icon" type="image/png" href="<?= BASE_URL ?>uploads/logo/<?= h($p['logo']) ?>">
    <?php endif; ?>

    <script>
        document.documentElement.className += ' js';
    </script>

    <link rel="stylesheet"
        href="<?= BASE_URL ?>assets/css/ijk-style.css?v=<?= @filemtime(__DIR__ . '/../assets/css/ijk-style.css') ?>">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

    <!-- TOPBAR -->
    <div class="topbar">
        <div class="container">
            <div class="topbar-info">
                <span>
                    <i class="fa-solid fa-location-dot"></i>
                    <?= h($p['alamat'] ?? '') ?>
                </span>
                <span>
                    <i class="fa-solid fa-envelope"></i>
                    <?= h($p['email'] ?? '') ?>
                </span>
            </div>

            <div class="topbar-social">
                <a href="<?= h($p['instagram'] ?? '#') ?>" aria-label="Instagram">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="<?= h($p['youtube'] ?? '#') ?>" aria-label="YouTube">
                    <i class="fa-brands fa-youtube"></i>
                </a>
                <a href="<?= h($p['tiktok'] ?? '#') ?>" aria-label="TikTok">
                    <i class="fa-brands fa-tiktok"></i>
                </a>
                <a href="<?= h($p['facebook'] ?? '#') ?>" aria-label="Facebook">
                    <i class="fa-brands fa-facebook"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- NAVIGASI UTAMA -->
    <nav class="navbar">
        <div class="container">

            <!-- LOGO DAN NAMA SEKOLAH -->
            <a href="<?= BASE_URL ?>ijk-index.php" class="brand">
                <?php if (!empty($p['logo'])): ?>
                    <img
                        src="<?= BASE_URL ?>uploads/logo/<?= h($p['logo']) ?>"
                        alt="Logo <?= h($p['nama_sekolah'] ?? 'SMK Infokom') ?>"
                        style="width:42px;height:42px;object-fit:contain;">
                <?php else: ?>
                    <div style="
                    width:42px;
                    height:42px;
                    background:#0b1533;
                    border-radius:8px;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    color:#f5b400;
                    font-weight:800;
                ">SI</div>
                <?php endif; ?>

                <div>
                    <?= h($p['nama_sekolah'] ?? 'SMK Infokom Kota Bogor') ?>
                    <small>Kota Bogor</small>
                </div>
            </a>

            <!-- MENU -->
            <ul class="nav-menu">
                <li>
                    <a href="<?= BASE_URL ?>ijk-index.php">Beranda</a>
                </li>

                <li>
                    <a href="<?= BASE_URL ?>ijk-profil.php">Profil</a>
                </li>

                <li>
                    <a href="<?= BASE_URL ?>ijk-fasilitas.php">Fasilitas</a>
                </li>

                <li>
                    <a href="<?= BASE_URL ?>ijk-guru.php">Guru</a>
                </li>

                <!-- AKADEMIK -->
                <li class="nav-dropdown">
                    <a href="<?= BASE_URL ?>ijk-akademik.php">
                        Akademik
                        <i class="fa-solid fa-chevron-down nav-chevron"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?= BASE_URL ?>ijk-program-keahlian.php">Program Keahlian</a>
                        </li>
                        <li>
                            <a href="<?= BASE_URL ?>ijk-prestasi.php">Prestasi</a>
                        </li>
                        <li>
                            <a href="<?= BASE_URL ?>ijk-ekstrakurikuler.php">Ekstrakurikuler</a>
                        </li>
                    </ul>
                </li>

                <!-- GALERI -->
                <li>
                    <a href="<?= BASE_URL ?>ijk-galeri.php">Galeri</a>
                </li>

                <!-- HUBUNGAN INDUSTRI -->
                <li class="nav-dropdown">
                    <a href="<?= BASE_URL ?>ijk-bkk.php">
                        Hubungan Industri
                        <i class="fa-solid fa-chevron-down nav-chevron"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?= BASE_URL ?>ijk-bkk.php">Bursa Kerja Khusus</a>
                        </li>
                        <li>
                            <a href="<?= BASE_URL ?>ijk-pkl.php">Praktik Kerja Lapangan</a>
                        </li>
                        <li>
                            <a href="<?= BASE_URL ?>ijk-magang-jepang.php">Magang</a>
                        </li>
                        <li>
                            <a href="<?= BASE_URL ?>ijk-mitra-kerja-sama.php">Mitra Kerja Sama</a>
                        </li>
                    </ul>
                </li>

                <!-- INFORMASI -->
                <li class="nav-dropdown">
                    <a href="<?= BASE_URL ?>ijk-berita.php">
                        Informasi
                        <i class="fa-solid fa-chevron-down nav-chevron"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li>
                            <a href="<?= BASE_URL ?>ijk-berita.php">Berita &amp; Informasi</a>
                        </li>
                        <li>
                            <a href="<?= BASE_URL ?>ijk-kontak.php">Kontak</a>
                        </li>
                    </ul>
                </li>
            </ul>

            <!-- TOMBOL PPDB -->
            <div class="nav-actions">
                <a href="<?= BASE_URL ?>ijk-ppdb.php" class="ppdb-btn">
                    PPDB
                </a>
            </div>

        </div>
    </nav>
</body>

</html>