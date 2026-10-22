<?php
require_once __DIR__ . '/includes/ijk-functions.php';
require_once __DIR__ . '/includes/ijk-header.php';
?>

<style>
/* =========================
   BERANDA SMK INFOKOM
========================= */
.home-modern {
    --hm-navy: #0b1533;
    --hm-blue: #1746a2;
    --hm-yellow: #ffbd00;
    --hm-gray: #64748b;
    overflow: hidden;
    background: #fff;
}

.home-modern * {
    box-sizing: border-box;
}

.home-modern .container {
    width: min(1160px, calc(100% - 40px));
    margin-inline: auto;
}

.home-modern a {
    -webkit-tap-highlight-color: transparent;
}

/* ANIMASI */
@keyframes hmFadeUp {
    from {
        opacity: 0;
        transform: translateY(28px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes hmFloat {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

@keyframes hmPulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(255,189,0,.25); }
    50% { box-shadow: 0 0 0 12px rgba(255,189,0,0); }
}

@keyframes hmShine {
    from { background-position: 200% center; }
    to { background-position: -200% center; }
}

/* HERO */
.home-modern .hm-hero {
    position: relative;
    isolation: isolate;
    padding: 76px 0 92px;
    color: #fff;
    background:
        radial-gradient(ellipse at 90% 10%, rgba(43,94,190,.32), transparent 38%),
        radial-gradient(ellipse at 10% 90%, rgba(255,189,0,.08), transparent 35%),
        linear-gradient(135deg, #09112b, #101f49 60%, #0b1533);
}

.home-modern .hm-hero::before,
.home-modern .hm-hero::after {
    content: "";
    position: absolute;
    z-index: -1;
    border: 1px solid rgba(255,255,255,.09);
    border-radius: 50%;
    pointer-events: none;
}

.home-modern .hm-hero::before {
    width: 390px;
    height: 390px;
    top: -210px;
    right: -80px;
}

.home-modern .hm-hero::after {
    width: 270px;
    height: 270px;
    bottom: -180px;
    left: 35%;
}

.home-modern .hm-hero-grid {
    display: grid;
    grid-template-columns: 1fr 1.05fr;
    align-items: center;
    gap: 58px;
}

.home-modern .hm-copy {
    animation: hmFadeUp .8s ease both;
}

.home-modern .hm-label {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 19px;
    color: var(--hm-yellow);
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 1.5px;
}

.home-modern .hm-label::before {
    content: "";
    width: 29px;
    height: 3px;
    background: var(--hm-yellow);
    border-radius: 4px;
}

.home-modern .hm-copy h1 {
    margin: 0 0 21px;
    color: #fff;
    font-size: clamp(34px, 4vw, 51px);
    font-weight: 850;
    line-height: 1.16;
    letter-spacing: -1.4px;
}

.home-modern .hm-copy h1 span {
    color: var(--hm-yellow);
    background: linear-gradient(90deg, #ffbd00, #ffe58a, #ffbd00);
    background-size: 200% auto;
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: hmShine 5s linear infinite;
}

.home-modern .hm-description {
    max-width: 490px;
    margin: 0;
    color: #c8d2e8;
    font-size: 15px;
    line-height: 1.9;
}

.home-modern .hm-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 13px;
    margin-top: 30px;
}

.home-modern .hm-btn {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    gap: 9px;
    min-height: 47px;
    padding: 13px 21px;
    border: 1px solid transparent;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 800;
    text-decoration: none;
    transition: transform .25s ease, box-shadow .25s ease,
                background .25s ease, color .25s ease;
}

.home-modern .hm-btn-primary {
    color: var(--hm-navy);
    background: var(--hm-yellow);
    animation: hmPulse 3s infinite;
}

.home-modern .hm-btn-primary:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px rgba(255,189,0,.28);
    background: #ffd04a;
}

.home-modern .hm-btn-secondary {
    color: #fff;
    background: rgba(255,255,255,.07);
    border-color: rgba(255,255,255,.27);
}

.home-modern .hm-btn-secondary:hover {
    color: var(--hm-navy);
    background: #fff;
    transform: translateY(-4px);
}

.home-modern .hm-photo-wrap {
    position: relative;
    padding: 0 12px 13px 0;
    animation: hmFadeUp .9s .15s ease both;
}

.home-modern .hm-photo-wrap::before {
    content: "";
    position: absolute;
    z-index: -1;
    top: 20px;
    right: 0;
    bottom: 0;
    left: 25px;
    border: 2px solid rgba(255,189,0,.8);
    border-radius: 25px;
    transform: rotate(3deg);
}

.home-modern .hm-photo {
    position: relative;
    overflow: hidden;
    border: 5px solid rgba(255,255,255,.12);
    border-radius: 23px;
    background: #17294e;
    box-shadow: 0 24px 60px rgba(0,0,0,.28);
}

.home-modern .hm-photo img {
    display: block;
    width: 100%;
    aspect-ratio: 1.3 / 1;
    object-fit: cover;
    transition: transform .65s ease;
}

.home-modern .hm-photo:hover img {
    transform: scale(1.055);
}

.home-modern .hm-photo-caption {
    position: absolute;
    right: 15px;
    bottom: 15px;
    left: 15px;
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    border: 1px solid rgba(255,255,255,.23);
    border-radius: 14px;
    background: rgba(8,19,48,.83);
    backdrop-filter: blur(12px);
}

.home-modern .hm-caption-icon {
    display: grid;
    flex-shrink: 0;
    width: 42px;
    height: 42px;
    place-items: center;
    border-radius: 12px;
    color: var(--hm-navy);
    background: var(--hm-yellow);
    font-size: 20px;
}

.home-modern .hm-photo-caption strong {
    display: block;
    color: #fff;
    font-size: 13px;
}

.home-modern .hm-photo-caption small {
    display: block;
    margin-top: 4px;
    color: #d0d8e9;
    font-size: 11px;
}

/* STRIP INFORMASI */
.home-modern .hm-strip {
    position: relative;
    z-index: 2;
    margin-top: -29px;
}

.home-modern .hm-strip-inner {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    overflow: hidden;
    border: 1px solid #e8edf5;
    border-radius: 19px;
    background: #fff;
    box-shadow: 0 15px 42px rgba(11,21,51,.09);
}

.home-modern .hm-strip-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 22px;
}

.home-modern .hm-strip-item + .hm-strip-item {
    border-left: 1px solid #edf0f5;
}

.home-modern .hm-strip-icon {
    display: grid;
    flex-shrink: 0;
    width: 48px;
    height: 48px;
    place-items: center;
    border-radius: 15px;
    color: #1746a2;
    background: #edf3ff;
    font-size: 22px;
    transition: .3s ease;
}

.home-modern .hm-strip-item:hover .hm-strip-icon {
    color: #0b1533;
    background: var(--hm-yellow);
    transform: rotate(-7deg) scale(1.07);
}

.home-modern .hm-strip-item strong {
    display: block;
    color: var(--hm-navy);
    font-size: 13px;
}

.home-modern .hm-strip-item span {
    display: block;
    margin-top: 5px;
    color: var(--hm-gray);
    font-size: 11px;
    line-height: 1.6;
}

/* INFORMASI UTAMA */
.home-modern .hm-information {
    padding: 82px 0 88px;
    background:
        radial-gradient(ellipse at 0% 100%, #f1f6ff, transparent 42%),
        #fff;
}

.home-modern .hm-heading {
    display: flex;
    align-items: end;
    justify-content: space-between;
    gap: 24px;
    margin-bottom: 32px;
}

.home-modern .hm-heading h2 {
    margin: 10px 0 12px;
    color: var(--hm-navy);
    font-size: clamp(25px, 3vw, 34px);
    line-height: 1.25;
    letter-spacing: -.7px;
}

.home-modern .hm-heading p {
    max-width: 650px;
    margin: 0;
    color: var(--hm-gray);
    font-size: 14px;
    line-height: 1.8;
}

.home-modern .hm-heading-mark {
    flex-shrink: 0;
    padding: 10px 14px;
    border: 1px solid #e5eaf3;
    border-radius: 12px;
    color: #1746a2;
    background: #fff;
    font-size: 12px;
    font-weight: 800;
}

.home-modern .hm-cards {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 22px;
}

.home-modern .hm-card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-height: 260px;
    padding: 27px;
    overflow: hidden;
    border: 1px solid #e4eaf3;
    border-radius: 19px;
    color: inherit;
    background: #fff;
    text-decoration: none;
    box-shadow: 0 5px 17px rgba(11,21,51,.025);
    transition: transform .3s ease, box-shadow .3s ease,
                border-color .3s ease;
    animation: hmFadeUp .65s ease both;
}

.home-modern .hm-card:nth-child(2) {
    animation-delay: .12s;
}

.home-modern .hm-card:nth-child(3) {
    animation-delay: .24s;
}

.home-modern .hm-card::after {
    content: "";
    position: absolute;
    right: -40px;
    bottom: -65px;
    width: 155px;
    height: 155px;
    border-radius: 50%;
    background: #f2f6ff;
    transition: transform .4s ease;
}

.home-modern .hm-card:hover {
    transform: translateY(-9px);
    border-color: #c4d5fa;
    box-shadow: 0 20px 40px rgba(11,21,51,.10);
}

.home-modern .hm-card:hover::after {
    transform: scale(1.45);
}

.home-modern .hm-card-icon {
    position: relative;
    z-index: 1;
    display: grid;
    width: 57px;
    height: 57px;
    place-items: center;
    margin-bottom: 22px;
    border-radius: 17px;
    color: #1746a2;
    background: #edf3ff;
    font-size: 25px;
    transition: .3s ease;
}

.home-modern .hm-card:nth-child(2) .hm-card-icon {
    color: #9b6900;
    background: #fff5d8;
}

.home-modern .hm-card:nth-child(3) .hm-card-icon {
    color: #087c65;
    background: #e4faf3;
}

.home-modern .hm-card:hover .hm-card-icon {
    transform: translateY(-3px) rotate(-5deg);
}

.home-modern .hm-card h3 {
    position: relative;
    z-index: 1;
    margin: 0 0 11px;
    color: var(--hm-navy);
    font-size: 19px;
}

.home-modern .hm-card p {
    position: relative;
    z-index: 1;
    margin: 0;
    color: var(--hm-gray);
    font-size: 13px;
    line-height: 1.85;
}

.home-modern .hm-card-link {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-top: auto;
    padding-top: 25px;
    color: #1746a2;
    font-size: 12px;
    font-weight: 800;
}

.home-modern .hm-card-link span:last-child {
    display: grid;
    width: 31px;
    height: 31px;
    place-items: center;
    border-radius: 50%;
    background: #edf3ff;
    transition: .25s ease;
}

.home-modern .hm-card:hover .hm-card-link span:last-child {
    color: #0b1533;
    background: var(--hm-yellow);
    transform: translateX(3px);
}

/* CTA */
.home-modern .hm-cta {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 25px;
    margin-top: 34px;
    padding: 28px 32px;
    overflow: hidden;
    border-radius: 19px;
    color: #fff;
    background: linear-gradient(115deg, #123576, #0b1533);
}

.home-modern .hm-cta::after {
    content: "";
    position: absolute;
    top: -90px;
    right: 12%;
    width: 200px;
    height: 200px;
    border: 1px solid rgba(255,255,255,.13);
    border-radius: 50%;
}

.home-modern .hm-cta h3 {
    margin: 0 0 8px;
    font-size: 19px;
}

.home-modern .hm-cta p {
    margin: 0;
    color: #d2dced;
    font-size: 13px;
    line-height: 1.8;
}

.home-modern .hm-cta .hm-btn {
    position: relative;
    z-index: 1;
    flex-shrink: 0;
}

/* RESPONSIVE */
@media (max-width: 900px) {
    .home-modern .hm-hero-grid {
        grid-template-columns: 1fr 1fr;
        gap: 30px;
    }

    .home-modern .hm-copy h1 {
        font-size: 37px;
    }

    .home-modern .hm-strip-item {
        padding: 17px 13px;
        gap: 10px;
    }

    .home-modern .hm-cards {
        gap: 15px;
    }

    .home-modern .hm-card {
        padding: 21px;
    }
}

@media (max-width: 650px) {
    .home-modern .container {
        width: min(100% - 30px, 480px);
    }

    .home-modern .hm-hero {
        padding: 49px 0 62px;
    }

    .home-modern .hm-hero-grid {
        grid-template-columns: 1fr;
        gap: 34px;
    }

    .home-modern .hm-copy h1 {
        font-size: clamp(33px, 9vw, 43px);
        letter-spacing: -.8px;
    }

    .home-modern .hm-description {
        font-size: 14px;
    }

    .home-modern .hm-photo-wrap {
        margin: 0 5px;
    }

    .home-modern .hm-photo img {
        aspect-ratio: 1.15 / 1;
    }

    .home-modern .hm-strip {
        margin-top: -18px;
    }

    .home-modern .hm-strip-inner {
        grid-template-columns: 1fr;
    }

    .home-modern .hm-strip-item {
        padding: 16px 19px;
    }

    .home-modern .hm-strip-item + .hm-strip-item {
        border-top: 1px solid #edf0f5;
        border-left: 0;
    }

    .home-modern .hm-information {
        padding: 59px 0;
    }

    .home-modern .hm-heading {
        display: block;
        margin-bottom: 25px;
    }

    .home-modern .hm-heading-mark {
        display: inline-block;
        margin-top: 18px;
    }

    .home-modern .hm-cards {
        grid-template-columns: 1fr;
        gap: 15px;
    }

    .home-modern .hm-card {
        min-height: 230px;
    }

    .home-modern .hm-cta {
        align-items: flex-start;
        flex-direction: column;
        padding: 25px 22px;
    }
}

/* HORMATI PENGATURAN REDUKSI ANIMASI */
@media (prefers-reduced-motion: reduce) {
    .home-modern *,
    .home-modern *::before,
    .home-modern *::after {
        animation-duration: .01ms !important;
        animation-iteration-count: 1 !important;
        scroll-behavior: auto !important;
        transition-duration: .01ms !important;
    }
}
</style>

<main class="home-modern">

    <!-- HERO UTAMA -->
    <section class="hm-hero">
        <div class="container">
            <div class="hm-hero-grid">

                <div class="hm-copy">
                    <div class="hm-label">SMK INFOKOM KOTA BOGOR</div>

                    <h1>
                        Membangun Generasi
                        <span>Kompeten</span> dan Berkarakter
                    </h1>

                    <p class="hm-description">
                        Selamat datang di website resmi SMK Infokom Kota Bogor.
                        Temukan informasi akademik, program keahlian, prestasi,
                        kegiatan sekolah, dan peluang karier untuk masa depan.
                    </p>

                    <div class="hm-buttons">
                        <a href="<?= BASE_URL ?>ijk-profil.php"
                           class="hm-btn hm-btn-primary">
                            Jelajahi Profil
                            <span aria-hidden="true">&rarr;</span>
                        </a>

                        <a href="<?= BASE_URL ?>ijk-program-keahlian.php"
                           class="hm-btn hm-btn-secondary">
                            Program Keahlian
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                </div>

                <div class="hm-photo-wrap">
                    <div class="hm-photo">
                        <img
                            src="<?= BASE_URL ?>assets/img/GEDUNG-DEPAN.png"
                            alt="Gedung SMK Infokom Kota Bogor"
                            fetchpriority="high"
                        >

                        <!-- KOTAK MELAYANG DENGAN LOGO ASLI -->
                        <div class="hm-photo-caption">
                            
                            <?php if (!empty($p['logo'])): ?>
                                <img src="<?= BASE_URL ?>uploads/logo/<?= h($p['logo']) ?>" style="width: 42px; height: 42px; object-fit: contain; background: #fff; padding: 4px; border-radius: 8px; flex-shrink: 0;">
                            <?php else: ?>
                                <div class="hm-caption-icon" aria-hidden="true">&#127891;</div>
                            <?php endif; ?>
                            
                            <div>
                                <strong><?= h($p['nama_sekolah'] ?? 'SMK Infokom Kota Bogor') ?></strong>
                                <small>Membangun kompetensi, meraih prestasi</small>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- INFORMASI SINGKAT -->
    <section class="hm-strip" aria-label="Informasi sekolah">
        <div class="container">
            <div class="hm-strip-inner">

                <div class="hm-strip-item">
                    <div class="hm-strip-icon" aria-hidden="true">
                        &#128218;
                    </div>
                    <div>
                        <strong>Informasi Akademik</strong>
                        <span>Informasi pembelajaran dan kegiatan siswa</span>
                    </div>
                </div>

                <div class="hm-strip-item">
                    <div class="hm-strip-icon" aria-hidden="true">
                        &#128187;
                    </div>
                    <div>
                        <strong>Program Keahlian</strong>
                        <span>Kembangkan keterampilan dan kreativitas</span>
                    </div>
                </div>

                <div class="hm-strip-item">
                    <div class="hm-strip-icon" aria-hidden="true">
                        &#128202;
                    </div>
                    <div>
                        <strong>Informasi Sekolah</strong>
                        <span>Berita dan kegiatan terbaru sekolah</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- KARTU INFORMASI -->
    <section class="hm-information">
        <div class="container">

            <div class="hm-heading">
                <div>
                    <div class="hm-label">INFORMASI SEKOLAH</div>
                    <h2>Jelajahi Dunia SMK Infokom</h2>
                    <p>
                        Temukan informasi sekolah dalam satu tempat.
                        Kenali program keahlian, kegiatan akademik, dan
                        berbagai informasi terbaru SMK Infokom Kota Bogor.
                    </p>
                </div>

                <div class="hm-heading-mark">
                    &#10022; Satu Website, Banyak Informasi
                </div>
            </div>

            <div class="hm-cards">

                <a href="<?= BASE_URL ?>ijk-akademik.php"
                   class="hm-card">
                    <div class="hm-card-icon" aria-hidden="true">
                        &#128197;
                    </div>
                    <h3>Akademik</h3>
                    <p>
                        Temukan informasi kalender akademik, jadwal,
                        kurikulum, dan kegiatan ekstrakurikuler sekolah.
                    </p>
                    <div class="hm-card-link">
                        <span>Jelajahi Akademik</span>
                        <span aria-hidden="true">&rarr;</span>
                    </div>
                </a>

                <a href="<?= BASE_URL ?>ijk-program-keahlian.php"
                   class="hm-card">
                    <div class="hm-card-icon" aria-hidden="true">
                        &#128187;
                    </div>
                    <h3>Program Keahlian</h3>
                    <p>
                        Kenali kompetensi keahlian, keterampilan,
                        dan peluang masa depan sesuai minatmu.
                    </p>
                    <div class="hm-card-link">
                        <span>Lihat Program Keahlian</span>
                        <span aria-hidden="true">&rarr;</span>
                    </div>
                </a>

                <a href="<?= BASE_URL ?>ijk-berita.php"
                   class="hm-card">
                    <div class="hm-card-icon" aria-hidden="true">
                        &#128240;
                    </div>
                    <h3>Berita dan Informasi</h3>
                    <p>
                        Ikuti berita, pengumuman, prestasi, dan
                        berbagai kegiatan terbaru dari sekolah.
                    </p>
                    <div class="hm-card-link">
                        <span>Baca Informasi</span>
                        <span aria-hidden="true">&rarr;</span>
                    </div>
                </a>

            </div>

            <!-- AJAKAN DI BAGIAN BAWAH -->
            <div class="hm-cta">
                <div>
                    <h3>Siap Mengenal SMK Infokom Lebih Dekat?</h3>
                    <p>
                        Jelajahi profil sekolah dan temukan informasi
                        yang kamu butuhkan.
                    </p>
                </div>

                <a href="<?= BASE_URL ?>ijk-profil.php"
                   class="hm-btn hm-btn-primary">
                    Tentang Sekolah
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </div>

        </div>
    </section>

</main>

<?php require_once __DIR__ . '/includes/ijk-footer.php'; ?>