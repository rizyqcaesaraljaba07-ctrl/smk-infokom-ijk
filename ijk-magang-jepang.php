<?php
require_once __DIR__ . '/includes/ijk-functions.php';
$db = getDB();

// Ambil data dari database
$list = [];
try {
    $stmt = $db->query("SELECT * FROM magang_jepang WHERE status='Aktif' ORDER BY urutan ASC, id DESC");
    $list = $stmt->fetchAll();
} catch (PDOException $e) {
    $list = [];
}

require_once __DIR__ . '/includes/ijk-header.php';
?>

<style>
/* Desain Card Magang */
.mj-wrap { display: flex; flex-direction: column; gap: 20px; margin-top: 30px; }
.mj-card {
    background: #fff; border: 1px solid var(--border); border-radius: 14px; padding: 24px;
    transition: transform .25s ease, box-shadow .25s ease;
}
.mj-card:hover { transform: translateY(-3px); box-shadow: 0 10px 24px rgba(0,0,0,.06); }
.mj-card-head { display: flex; align-items: center; gap: 14px; margin-bottom: 16px; }
.mj-icon {
    width: 48px; height: 48px; border-radius: 10px;
    background: var(--navy); color: var(--gold);
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; flex-shrink: 0;
}
.mj-card h3 { font-size: 18px; color: var(--navy); margin: 0; line-height: 1.3; }
.mj-badge {
    display: inline-block; background: #fef3c7; color: #92400e;
    font-size: 11px; font-weight: 700; padding: 3px 10px;
    border-radius: 20px; text-transform: uppercase; letter-spacing: .3px;
}
.mj-img { width: 100%; max-height: 320px; object-fit: cover; border-radius: 10px; margin-bottom: 16px; display: block; }
.mj-content { color: #444; font-size: 14px; line-height: 1.75; white-space: pre-line; }
.mj-content ul, .mj-content ol { padding-left: 22px; list-style: disc; margin: 8px 0; }
.mj-content li { margin-bottom: 4px; }

@media (max-width: 640px) {
    .mj-card { padding: 18px; }
    .mj-card h3 { font-size: 16px; }
}
</style>

<section class="about" style="padding-top:50px;">
    <div class="container">

        <div class="section-label">Hubungan Industri</div>
        <div class="section-title">Magang</div>
        <p style="color:var(--gray); max-width:720px; margin-top:10px;">
            Program pemagangan siswa SMK Infokom Kota Bogor bekerja sama dengan LPK dan perusahaan mitra.
        </p>

        <?php if (empty($list)): ?>

            <!-- Tampilan jika data masih kosong -->
            <div style="margin-top:30px; padding:60px 30px; background:#fff; border-radius:14px; text-align:center; border:1px dashed var(--border);">
                <i class="fa-solid fa-plane-departure" style="font-size:42px; color:var(--gold); margin-bottom:14px;"></i>
                <h3 style="color:var(--navy); margin-bottom:10px;">Program Magang</h3>
                <p style="color:var(--gray); max-width:520px; margin:0 auto;">
                    Halaman ini sedang dalam pengembangan. Informasi lengkap akan segera tersedia.
                </p>
            </div>

        <?php else: ?>

            <!-- Tampilan Data dari Database -->
            <div class="mj-wrap">
                <?php foreach ($list as $row): ?>
                    <div class="mj-card reveal">

                        <div class="mj-card-head">
                            <div class="mj-icon">
                                <i class="fa-solid fa-plane-departure"></i>
                            </div>
                            <div>
                                <h3><?= h($row['judul']) ?></h3>
                                <?php if (!empty($row['kategori'])): ?>
                                    <span class="mj-badge"><?= h($row['kategori']) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if (!empty($row['gambar'])): ?>
                            <img src="uploads/magang-jepang/<?= h($row['gambar']) ?>" alt="<?= h($row['judul']) ?>" class="mj-img">
                        <?php endif; ?>

                        <?php if (!empty($row['konten'])): ?>
                            <div class="mj-content"><?= nl2br(h($row['konten'])) ?></div>
                        <?php endif; ?>

                    </div>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>

    </div>
</section>

<?php require_once __DIR__ . '/includes/ijk-footer.php'; ?>