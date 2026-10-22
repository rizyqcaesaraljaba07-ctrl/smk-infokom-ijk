<?php
require_once __DIR__ . '/includes/ijk-functions.php';
$db = getDB();

$list = [];
try {
    $stmt = $db->query("SELECT * FROM pkl_info WHERE status='Aktif' ORDER BY urutan ASC, id DESC");
    $list = $stmt->fetchAll();
} catch (PDOException $e) {
    $list = [];
}

require_once __DIR__ . '/includes/ijk-header.php';
?>

<style>
.pkl-wrap { display: flex; flex-direction: column; gap: 20px; margin-top: 30px; }
.pkl-card {
    background: #fff; border: 1px solid var(--border); border-radius: 14px; padding: 24px;
    transition: transform .25s ease, box-shadow .25s ease;
}
.pkl-card:hover { transform: translateY(-3px); box-shadow: 0 10px 24px rgba(0,0,0,.06); }
.pkl-card-head { display: flex; align-items: center; gap: 14px; margin-bottom: 16px; }
.pkl-icon {
    width: 48px; height: 48px; border-radius: 10px;
    background: var(--navy); color: var(--gold);
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; flex-shrink: 0;
}
.pkl-card h3 { font-size: 18px; color: var(--navy); margin: 0; line-height: 1.3; }
.pkl-badge {
    display: inline-block; background: #eef2ff; color: #1e40af;
    font-size: 11px; font-weight: 700; padding: 3px 10px;
    border-radius: 20px; text-transform: uppercase; letter-spacing: .3px;
}
.pkl-img {
    width: 100%; max-height: 320px; object-fit: cover;
    border-radius: 10px; margin-bottom: 16px; display: block;
}
.pkl-content { color: #444; font-size: 14px; line-height: 1.75; white-space: pre-line; }
@media (max-width: 640px) {
    .pkl-card { padding: 18px; }
    .pkl-card h3 { font-size: 16px; }
}
</style>

<section class="about" style="padding-top:50px;">
    <div class="container">

        <div class="section-label">Hubungan Industri</div>
        <div class="section-title">Praktik Kerja Lapangan</div>
        <p style="color:var(--gray); max-width:720px; margin-top:10px;">
            Program Praktik Kerja Lapangan (PKL) bagi siswa SMK Infokom Kota Bogor di berbagai mitra industri.
        </p>

        <?php if (empty($list)): ?>

            <div style="margin-top:30px; padding:60px 30px; background:#fff; border-radius:14px; text-align:center; border:1px dashed var(--border);">
                <i class="fa-solid fa-briefcase" style="font-size:42px; color:var(--gold); margin-bottom:14px;"></i>
                <h3 style="color:var(--navy); margin-bottom:10px;">Informasi PKL</h3>
                <p style="color:var(--gray); max-width:520px; margin:0 auto;">
                    Halaman ini sedang dalam pengembangan.
                </p>
            </div>

        <?php else: ?>

            <div class="pkl-wrap">
                <?php foreach ($list as $row): ?>
                    <div class="pkl-card reveal">

                        <div class="pkl-card-head">
                            <div class="pkl-icon">
                                <i class="fa-solid fa-briefcase"></i>
                            </div>
                            <div>
                                <h3><?= h($row['judul']) ?></h3>
                                <?php if (!empty($row['kategori'])): ?>
                                    <span class="pkl-badge"><?= h($row['kategori']) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if (!empty($row['gambar'])): ?>
                            <img src="uploads/pkl/<?= h($row['gambar']) ?>" alt="<?= h($row['judul']) ?>" class="pkl-img">
                        <?php endif; ?>

                        <?php if (!empty($row['konten'])): ?>
                            <div class="pkl-content"><?= nl2br(h($row['konten'])) ?></div>
                        <?php endif; ?>

                    </div>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>

    </div>
</section>

<?php require_once __DIR__ . '/includes/ijk-footer.php'; ?>