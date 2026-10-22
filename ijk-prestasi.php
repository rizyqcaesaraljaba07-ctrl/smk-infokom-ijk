<?php
require_once __DIR__ . '/includes/ijk-functions.php';

$db = getDB();

$prestasiList = $db
    ->query("SELECT * FROM prestasi ORDER BY tanggal DESC")
    ->fetchAll();

require_once __DIR__ . '/includes/ijk-header.php';
?>

<style>
/* ================================
   GRID PRESTASI
================================ */

.prestasi-grid {
    margin-top: 24px !important;
    display: grid !important;
    grid-template-columns: repeat(3, 1fr) !important;
    gap: 20px !important;
    align-items: stretch;
}

/* ================================
   CARD
================================ */

.prestasi-grid .info-card {
    height: 100%;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    background: #fff;
    border-radius: 10px;
    padding: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.prestasi-grid .info-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.1);
}

/* ================================
   GAMBAR
================================ */

.prestasi-image {
    width: 100%;
    height: 180px;
    background: #f5f5f5;
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 14px;

    /* Membuat isi gambar berada di tengah */
    display: flex;
    align-items: center;
    justify-content: center;
}

.prestasi-image img {
    width: 100% !important;
    height: 100% !important;

    /* GAMBAR MENGISI KOTAK & DIPOTONG RAPI */
    object-fit: cover !important;
    object-position: center;

    display: block;
}

/* ================================
   ISI CARD
================================ */

.prestasi-grid .info-card h4 {
    margin-bottom: 8px;
}

.prestasi-grid .info-card p {
    margin-bottom: 8px;
}

/* Tanggal di bagian bawah */
.prestasi-grid .info-card > p:last-child {
    margin-top: auto !important;
    padding-top: 10px;
}

/* ================================
   TABLET
================================ */

@media (max-width: 900px) {
    .prestasi-grid {
        grid-template-columns: repeat(2, 1fr) !important;
    }
}

/* ================================
   HP
================================ */

@media (max-width: 600px) {
    .prestasi-grid {
        grid-template-columns: 1fr !important;
    }

    .prestasi-image {
        height: 200px;
    }
}
</style>


<section class="about" style="padding-top:50px;">

    <div class="container">

        <div class="section-label">
            Prestasi
        </div>

        <div class="section-title">
            Prestasi dan Penghargaan
        </div>


        <div class="prestasi-grid">

            <?php foreach ($prestasiList as $pr): ?>

                <div class="info-card">

                    <?php if (!empty($pr['gambar'])): ?>

                        <div class="prestasi-image">

                            <img
                                src="uploads/prestasi/<?= h($pr['gambar']) ?>"
                                alt="<?= h($pr['judul']) ?>"
                            >

                        </div>

                    <?php endif; ?>


                    <div class="icon-badge">
                        <i class="fa-solid fa-medal"></i>
                    </div>


                    <h4>
                        <?= h($pr['judul']) ?>
                    </h4>


                    <p>
                        <?= h($pr['kategori']) ?>
                        · Tingkat
                        <?= h($pr['tingkat']) ?>
                    </p>


                    <p style="color:#333;">
                        <?= h($pr['deskripsi']) ?>
                    </p>


                    <p style="font-size:11px;color:var(--gray);margin-top:6px;">
                        <?= formatTanggal($pr['tanggal']) ?>
                    </p>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

</section>


<?php require_once __DIR__ . '/includes/ijk-footer.php'; ?>