<?php
require_once __DIR__ . '/includes/ijk-functions.php';
$db = getDB();

$lowongan = [];
$mitraList = [];
$tabelAda = true;

try {
    $lowongan = $db->query("SELECT b.*, m.nama AS mitra_nama, m.logo AS mitra_logo
        FROM bkk_lowongan b LEFT JOIN mitra m ON b.mitra_id = m.id
        WHERE b.status = 'Buka' AND (b.batas_akhir IS NULL OR b.batas_akhir >= CURDATE())
        ORDER BY b.batas_akhir IS NULL, b.batas_akhir ASC, b.id DESC")->fetchAll();

    $mitraList = $db->query("SELECT * FROM mitra WHERE status='Aktif' ORDER BY urutan ASC, nama ASC")->fetchAll();

} catch (PDOException $e) {
    $tabelAda = false;
}

function sisaHariBkk($tgl) {
    if (!$tgl) return null;
    return (int)floor((strtotime($tgl) - strtotime(date('Y-m-d'))) / 86400);
}

require_once __DIR__ . '/includes/ijk-header.php';
?>

<style>

/* =====================================================
   CARD BKK
   ===================================================== */

.bkk-card {
    overflow: hidden !important;
}


/* =====================================================
   BANNER GAMBAR LOWONGAN
   ===================================================== */

.bkk-banner {
    width: calc(100% + 44px) !important;
    margin: -22px -22px 20px -22px !important;

    height: 220px !important;

    overflow: hidden !important;

    background: #f4f6fb !important;

    border-radius: 14px 14px 0 0 !important;

    position: relative !important;

    display: flex !important;
    align-items: center !important;
    justify-content: center !important;

    box-sizing: border-box !important;
}


/* GAMBAR UTAMA */

.bkk-banner img {
    width: 100% !important;
    height: 100% !important;

    display: block !important;

    /*
       contain = gambar TIDAK dipotong
       dan TIDAK gepeng
    */
    object-fit: contain !important;

    object-position: center center !important;

    margin: 0 !important;
    padding: 0 !important;

    transform: none !important;

    transition: none !important;
}


/* MATIKAN ZOOM SAAT HOVER */

.bkk-card:hover .bkk-banner img {
    transform: none !important;
}


/* =====================================================
   LOGO MITRA
   ===================================================== */

.bkk-logo {
    width: 60px !important;
    height: 60px !important;

    min-width: 60px !important;
    min-height: 60px !important;

    border-radius: 12px !important;

    background: #fff !important;

    border: 1px solid var(--border);

    padding: 6px;

    flex-shrink: 0;

    display: flex;

    align-items: center;

    justify-content: center;

    overflow: hidden;
}

.bkk-logo img {
    width: 100% !important;
    height: 100% !important;

    object-fit: contain !important;

    object-position: center !important;

    background: #fff;

    padding: 0;

    margin: 0;

    display: block;
}


/* =====================================================
   TOP CARD
   ===================================================== */

.bkk-top {
    display: flex;
    align-items: center;
    gap: 14px;
}


/* =====================================================
   TAG
   ===================================================== */

.bkk-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 7px;
}


/* =====================================================
   FOOT CARD
   ===================================================== */

.bkk-foot {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    flex-wrap: wrap;
}


/* =====================================================
   RESPONSIVE TABLET
   ===================================================== */

@media (max-width: 768px) {

    .bkk-banner {
        height: 200px !important;
    }

}


/* =====================================================
   RESPONSIVE HP
   ===================================================== */

@media (max-width: 640px) {

    .bkk-banner {
        height: 180px !important;

        margin: -18px -18px 18px -18px !important;

        width: calc(100% + 36px) !important;

        border-radius: 12px 12px 0 0 !important;
    }

    .bkk-logo {
        width: 55px !important;
        height: 55px !important;

        min-width: 55px !important;
        min-height: 55px !important;
    }

    .bkk-top {
        gap: 12px;
    }

}


/* =====================================================
   HP KECIL
   ===================================================== */

@media (max-width: 400px) {

    .bkk-banner {
        height: 160px !important;
    }

}

</style>


<section class="about" style="padding-top:50px;">

  <div class="container">

    <div class="section-label">
        BKK - Bursa Kerja Khusus
    </div>

    <div class="section-title">
        Lowongan Kerja untuk Lulusan SMK Infokom
    </div>

    <p style="color:var(--gray);max-width:720px;">
        Informasi lowongan kerja dan magang dari mitra industri yang bekerja sama dengan sekolah.
    </p>


    <div class="bkk-hero-stats">

      <div class="bkk-stat">
        <b><?= count($lowongan) ?></b> Lowongan aktif
      </div>

      <div class="bkk-stat">
        <b><?= count($mitraList) ?></b> Mitra industri
      </div>

    </div>


    <?php if (!$tabelAda): ?>

      <div class="empty-state" style="margin-top:24px;">
        Fitur BKK belum aktif: tabel database belum dibuat.
      </div>

    <?php else: ?>


    <div class="bkk-grid">

      <?php foreach ($lowongan as $l):

        $sisa = sisaHariBkk($l['batas_akhir']);
        $link = urlAman($l['link_daftar'] ?? '');

      ?>


      <div class="bkk-card reveal">


        <?php if (!empty($l['gambar'])): ?>

          <div class="bkk-banner">

            <img
                src="uploads/bkk/<?= h($l['gambar']) ?>"
                alt="<?= h($l['posisi']) ?>"
                loading="lazy"
            >

          </div>

        <?php endif; ?>


        <div class="bkk-top">

          <?php if (!empty($l['mitra_logo']) || !empty($l['gambar'])): ?>

            <div class="bkk-logo">

              <?php if (!empty($l['mitra_logo'])): ?>

                <img
                    src="uploads/mitra/<?= h($l['mitra_logo']) ?>"
                    alt="<?= h($l['mitra_nama'] ?? 'Logo mitra') ?>"
                >

              <?php else: ?>

                <img
                    src="uploads/bkk/<?= h($l['gambar']) ?>"
                    alt="<?= h($l['posisi']) ?>"
                >

              <?php endif; ?>

            </div>

          <?php endif; ?>


          <div>

            <h3>
                <?= h($l['posisi']) ?>
            </h3>

            <div class="bkk-company">
                <?= h($l['mitra_nama'] ?? 'Mitra BKK') ?>
            </div>

          </div>

        </div>


        <div class="bkk-tags">

          <span class="chip">
              <?= h($l['tipe']) ?>
          </span>


          <?php if (!empty($l['lokasi'])): ?>

            <span class="chip gold">
                <i class="fa-solid fa-location-dot"></i>
                <?= h($l['lokasi']) ?>
            </span>

          <?php endif; ?>


          <?php if (!empty($l['jurusan'])): ?>

            <span class="chip green">
                <?= h($l['jurusan']) ?>
            </span>

          <?php endif; ?>

        </div>


        <?php if (!empty($l['deskripsi'])): ?>

          <p class="bkk-desc">
              <?= h($l['deskripsi']) ?>
          </p>

        <?php endif; ?>


        <?php if (!empty($l['kualifikasi'])): ?>

          <details class="bkk-detail">

            <summary>
                Lihat kualifikasi
            </summary>

            <p>
                <?= nl2br(h($l['kualifikasi'])) ?>
            </p>

          </details>

        <?php endif; ?>


        <div class="bkk-foot">

          <div class="bkk-deadline <?= ($sisa !== null && $sisa <= 3) ? 'urgent' : '' ?>">

            <?php if ($sisa === null): ?>

              Dibuka sampai pengumuman berikutnya

            <?php elseif ($sisa === 0): ?>

              Berakhir hari ini

            <?php else: ?>

              Sisa <?= $sisa ?> hari
              (s.d. <?= formatTanggal($l['batas_akhir']) ?>)

            <?php endif; ?>

          </div>


          <?php if ($link): ?>

            <a
                class="btn btn-gold"
                href="<?= h($link) ?>"
                target="_blank"
                rel="noopener noreferrer"
            >
                Lamar Sekarang
            </a>

          <?php else: ?>

            <a
                class="btn btn-gold"
                href="ijk-kontak.php"
            >
                Hubungi BKK
            </a>

          <?php endif; ?>

        </div>


      </div>


      <?php endforeach; ?>


      <?php if (empty($lowongan)): ?>

        <div class="empty-state">
            Belum ada lowongan yang dibuka. Silakan cek kembali nanti.
        </div>

      <?php endif; ?>


    </div>

    <?php endif; ?>

  </div>

</section>


<?php if (!empty($mitraList)): ?>

<section class="mitra-section" style="padding-top:20px;">

  <div class="container">

    <div class="section-label">
        Mitra Kerja Sama
    </div>

    <div class="section-title">
        Perusahaan yang Bekerja Sama dengan Kami
    </div>

    <div class="mitra-grid" style="margin-top:24px;">

      <?php foreach ($mitraList as $m): ?>

        <?= mitraLogoHtml($m, 'reveal'); ?>

      <?php endforeach; ?>

    </div>

  </div>

</section>

<?php endif; ?>


<?php require_once __DIR__ . '/includes/ijk-footer.php'; ?>
