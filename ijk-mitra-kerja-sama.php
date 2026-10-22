<?php
require_once __DIR__ . '/includes/ijk-functions.php';
$db = getDB();

$kategori_filter = $_GET['kategori'] ?? '';
$search = trim($_GET['q'] ?? '');

$sql = "SELECT * FROM mitra WHERE status='Aktif'";
$params = [];

if ($kategori_filter !== '') {
    $sql .= " AND kategori = ?";
    $params[] = $kategori_filter;
}
if ($search !== '') {
    $sql .= " AND (nama LIKE ? OR bidang LIKE ? OR kerjasama LIKE ?)";
    $like = "%$search%";
    $params[] = $like; $params[] = $like; $params[] = $like;
}
$sql .= " ORDER BY urutan ASC, nama ASC";

$stmt = $db->prepare($sql);
$stmt->execute($params);
$mitraList = $stmt->fetchAll();

// Ambil kategori unik untuk filter
$kategoriList = $db->query("SELECT DISTINCT kategori FROM mitra WHERE status='Aktif' AND kategori IS NOT NULL ORDER BY kategori ASC")->fetchAll(PDO::FETCH_COLUMN);

require_once __DIR__ . '/includes/ijk-header.php';
?>

<style>
/* Filter chips */
.mitra-filter-wrap { display:flex; gap:10px; flex-wrap:wrap; margin:20px 0 24px; }
.mitra-chip {
    padding: 8px 18px; border-radius: 24px; background:#fff; border:1px solid var(--border);
    font-size:13px; font-weight:600; color:#333; transition:all .2s ease; cursor:pointer;
}
.mitra-chip:hover { border-color: var(--gold); color: var(--navy); }
.mitra-chip.active { background: var(--navy); color:#fff; border-color: var(--navy); }

/* Search box */
.mitra-search {
    display:flex; align-items:center; gap:10px; background:#fff; border:1px solid var(--border);
    border-radius:10px; padding:10px 16px; max-width:420px; margin-bottom:24px;
}
.mitra-search i { color: var(--gray); }
.mitra-search input { border:none; outline:none; flex:1; font-size:14px; font-family:inherit; background:transparent; }

/* Grid card mitra */
.mitra-page-grid {
    display:grid; grid-template-columns: repeat(4, 1fr); gap:20px;
}
.mitra-page-card {
    background:#fff; border:1px solid var(--border); border-radius:14px; padding:22px;
    display:flex; flex-direction:column; gap:10px; position:relative; overflow:hidden;
    transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
}
.mitra-page-card:hover { transform:translateY(-4px); box-shadow:0 12px 30px rgba(0,0,0,.08); border-color:#d8dce6; }
.mitra-page-card:hover::after {
    content:""; position:absolute; inset:0; pointer-events:none; opacity:1;
    background: radial-gradient(180px circle at var(--mx,50%) var(--my,50%), rgba(245,180,0,.14), transparent 70%);
}

.mitra-page-logo {
    width:70px; height:70px; border-radius:12px; background:#f4f6fb;
    display:flex; align-items:center; justify-content:center; overflow:hidden; margin-bottom:4px;
}
.mitra-page-logo img { max-width:85%; max-height:85%; object-fit:contain; }
.mitra-page-logo span { font-size:26px; font-weight:800; color:var(--navy); }

.mitra-badges { display:flex; flex-wrap:wrap; gap:6px; }
.mitra-badge {
    display:inline-block; padding:3px 10px; border-radius:20px;
    font-size:10.5px; font-weight:700; letter-spacing:.3px; text-transform:uppercase;
}
.mitra-badge.jenis { background:#e6ecff; color:#1e40af; }
.mitra-badge.lingkup { background:#e6f7ee; color:#047857; }

.mitra-page-card h3 { font-size:16px; color:var(--navy); line-height:1.3; margin:0; }
.mitra-page-bidang { font-size:13px; color:var(--gray); margin:0; line-height:1.5; }
.mitra-page-kerjasama {
    font-size:12px; color:#374151; margin:0; padding-top:10px;
    border-top:1px dashed var(--border); line-height:1.5;
}
.mitra-page-kerjasama i { color:var(--gold); margin-right:5px; }
.mitra-page-website {
    font-size:12px; color:#1e40af; text-decoration:none;
    display:inline-flex; align-items:center; gap:5px; margin-top:auto; font-weight:600;
}
.mitra-page-website:hover { text-decoration:underline; }

@media(max-width:1024px){
    .mitra-page-grid { grid-template-columns:repeat(2,1fr); }
}
@media(max-width:560px){
    .mitra-page-grid { grid-template-columns:1fr; }
}
</style>

<section class="about" style="padding-top:50px;">
    <div class="container">

        <div class="section-label">Hubungan Industri</div>
        <div class="section-title">Mitra Kerja Sama</div>
        <p style="color:var(--gray); max-width:720px; margin-top:10px;">
            Perusahaan dan instansi yang bekerja sama dengan SMK Infokom Kota Bogor
            dalam program praktik kerja lapangan, rekrutmen lulusan, dan pengembangan kompetensi siswa.
        </p>

        <!-- Filter Chips -->
        <?php if (!empty($kategoriList)): ?>
        <div class="mitra-filter-wrap">
            <a href="?" class="mitra-chip <?= $kategori_filter===''?'active':'' ?>">Semua</a>
            <?php foreach ($kategoriList as $kat): ?>
                <a href="?kategori=<?= urlencode($kat) ?>" class="mitra-chip <?= $kategori_filter===$kat?'active':'' ?>">
                    <?= h($kat) ?>
                </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Search -->
        <form method="GET" class="mitra-search">
            <?php if ($kategori_filter): ?><input type="hidden" name="kategori" value="<?= h($kategori_filter) ?>"><?php endif; ?>
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="q" value="<?= h($search) ?>" placeholder="Cari mitra industri...">
        </form>

        <?php if (empty($mitraList)): ?>

            <div class="empty-state" style="padding:40px 20px;">
                <i class="fa-solid fa-handshake" style="font-size:36px; color:#cbd5e1; margin-bottom:12px;"></i>
                <p>Belum ada mitra yang cocok dengan pencarian Anda.</p>
            </div>

        <?php else: ?>

            <div class="mitra-page-grid">
                <?php foreach ($mitraList as $m):
                    $inisial = mb_strtoupper(mb_substr($m['nama'], 0, 1));
                ?>
                    <div class="mitra-page-card reveal">
                        <div class="mitra-page-logo">
                            <?php if (!empty($m['logo'])): ?>
                                <img src="uploads/mitra/<?= h($m['logo']) ?>" alt="<?= h($m['nama']) ?>">
                            <?php else: ?>
                                <span><?= h($inisial) ?></span>
                            <?php endif; ?>
                        </div>

                        <?php if (!empty($m['jenis']) || !empty($m['lingkup'])): ?>
                        <div class="mitra-badges">
                            <?php if (!empty($m['jenis'])): ?>
                                <span class="mitra-badge jenis"><?= h($m['jenis']) ?></span>
                            <?php endif; ?>
                            <?php if (!empty($m['lingkup'])): ?>
                                <span class="mitra-badge lingkup"><?= h($m['lingkup']) ?></span>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>

                        <h3><?= h($m['nama']) ?></h3>

                        <?php if (!empty($m['bidang'])): ?>
                            <p class="mitra-page-bidang"><?= h($m['bidang']) ?></p>
                        <?php endif; ?>

                        <?php if (!empty($m['kerjasama'])): ?>
                            <p class="mitra-page-kerjasama">
                                <i class="fa-solid fa-briefcase"></i>
                                <?= h($m['kerjasama']) ?>
                            </p>
                        <?php endif; ?>

                        <?php if (!empty($m['website'])): ?>
                            <a href="<?= h($m['website']) ?>" target="_blank" rel="noopener noreferrer" class="mitra-page-website">
                                <i class="fa-solid fa-globe"></i> Kunjungi Website
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>

    </div>
</section>

<?php require_once __DIR__ . '/includes/ijk-footer.php'; ?>