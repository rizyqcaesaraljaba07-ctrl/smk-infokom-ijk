<?php
require_once __DIR__ . '/includes/ijk-functions.php';

$db = getDB();

require_once __DIR__ . '/includes/ijk-header.php';
?>

<style>
/* =========================================
   PROFIL SEKOLAH - SMK INFOKOM KOTA BOGOR
   Tema: Navy, Putih, Kuning
========================================= */

.profile-modern {
    --pm-navy: #0b1533;
    --pm-blue: #1746a2;
    --pm-gold: #ffbd00;
    --pm-gray: #64748b;
    overflow: hidden;
    background: #fff;
    color: var(--pm-navy);
}

.profile-modern * {
    box-sizing: border-box;
}

.profile-modern .container {
    width: min(1160px, calc(100% - 40px));
    margin-inline: auto;
}

@keyframes pmFadeUp {
    from { opacity: 0; transform: translateY(22px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes pmGlow {
    0%, 100% { opacity: .35; }
    50% { opacity: .8; }
}

.profile-modern .pm-animate {
    animation: pmFadeUp .7s ease both;
}

/* HERO */
.profile-modern .pm-hero {
    position: relative;
    isolation: isolate;
    overflow: hidden;
    padding: 55px 0 65px;
    color: #fff;
    background:
        radial-gradient(ellipse at 90% 0%, rgba(53,105,211,.32), transparent 40%),
        linear-gradient(125deg, #09112b, #132b5b);
}

.profile-modern .pm-hero::before {
    content: "";
    position: absolute;
    z-index: -1;
    top: -150px;
    right: -50px;
    width: 350px;
    height: 350px;
    border: 1px solid rgba(255,255,255,.13);
    border-radius: 50%;
    box-shadow:
        0 0 0 30px rgba(255,255,255,.025),
        0 0 0 65px rgba(255,255,255,.02);
    animation: pmGlow 7s ease-in-out infinite;
}

.profile-modern .pm-hero::after {
    content: "";
    position: absolute;
    z-index: -1;
    right: 12%;
    bottom: -190px;
    width: 300px;
    height: 300px;
    border: 1px solid rgba(255,189,0,.3);
    border-radius: 50%;
}

.profile-modern .pm-hero-grid {
    display: grid;
    grid-template-columns: 1fr;
    align-items: center;
}

.profile-modern .pm-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    color: var(--pm-gold);
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 1.5px;
    text-transform: uppercase;
}

.profile-modern .pm-eyebrow::before {
    content: "";
    width: 25px;
    height: 3px;
    border-radius: 5px;
    background: var(--pm-gold);
}

.profile-modern .pm-hero h1 {
    max-width: 850px;
    margin: 17px 0;
    color: #fff;
    font-size: clamp(30px, 4vw, 44px);
    font-weight: 850;
    line-height: 1.2;
    letter-spacing: -.8px;
    animation: pmFadeUp .65s ease both;
}

.profile-modern .pm-hero h1 span {
    color: var(--pm-gold);
}

.profile-modern .pm-hero-description {
    max-width: 680px;
    margin: 0;
    color: #d0d9eb;
    font-size: 14px;
    line-height: 1.95;
    animation: pmFadeUp .8s ease both;
}

.profile-modern .pm-hero-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 25px;
    animation: pmFadeUp .9s ease both;
}

.profile-modern .pm-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 19px;
    border: 1px solid transparent;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 800;
    text-decoration: none;
    transition: transform .25s ease, box-shadow .25s ease, background .25s ease;
}

.profile-modern .pm-button-gold {
    color: #0b1533;
    background: var(--pm-gold);
}

.profile-modern .pm-button-outline {
    color: #fff;
    border-color: rgba(255,255,255,.3);
    background: rgba(255,255,255,.06);
}

.profile-modern .pm-button:hover {
    transform: translateY(-3px);
    box-shadow: 0 9px 22px rgba(0,0,0,.15);
}

/* KONTEN */
.profile-modern .pm-content {
    padding: 60px 0 75px;
    background:
        radial-gradient(ellipse at 0% 100%, #f0f5ff, transparent 40%),
        #fff;
}

.profile-modern .pm-section-heading {
    margin-bottom: 25px;
}

.profile-modern .pm-section-heading h2 {
    margin: 12px 0;
    color: var(--pm-navy);
    font-size: clamp(24px, 3vw, 31px);
    font-weight: 850;
    letter-spacing: -.5px;
}

.profile-modern .pm-section-heading p {
    max-width: 820px;
    margin: 0;
    color: var(--pm-gray);
    font-size: 14px;
    line-height: 1.95;
}

/* SAMBUTAN KEPALA SEKOLAH */
.profile-modern .pm-principal {
    display: grid;
    grid-template-columns: 250px minmax(0, 1fr);
    align-items: center;
    gap: 35px;
    margin-top: 42px;
    padding: 28px;
    border: 1px solid #e5eaf3;
    border-radius: 20px;
    background: #fff;
    box-shadow: 0 8px 28px rgba(11,21,51,.045);
    transition: box-shadow .3s ease, transform .3s ease;
}

.profile-modern .pm-principal:hover {
    box-shadow: 0 15px 35px rgba(11,21,51,.09);
}

.profile-modern .pm-principal-photo-wrap {
    position: relative;
    width: 100%;
    max-width: 250px;
    margin: auto;
}

.profile-modern .pm-principal-photo-wrap::before {
    content: "";
    position: absolute;
    inset: 12px -8px -8px 12px;
    border-radius: 17px;
    background: var(--pm-gold);
}

.profile-modern .pm-principal-photo {
    position: relative;
    display: block;
    width: 100%;
    aspect-ratio: 4 / 5;
    object-fit: cover;
    object-position: center top;
    border: 4px solid #fff;
    border-radius: 17px;
    background: #edf3ff;
    box-shadow: 0 8px 22px rgba(11,21,51,.12);
    transition: transform .3s ease;
}

.profile-modern .pm-principal-photo-wrap:hover .pm-principal-photo {
    transform: translate(-3px, -3px);
}

.profile-modern .pm-principal-label {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    color: #b88400;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1.4px;
    text-transform: uppercase;
}

.profile-modern .pm-principal-label::before {
    content: "";
    width: 23px;
    height: 3px;
    border-radius: 5px;
    background: var(--pm-gold);
}

.profile-modern .pm-principal h2 {
    margin: 12px 0 8px;
    color: var(--pm-navy);
    font-size: clamp(23px, 3vw, 30px);
    line-height: 1.3;
    font-weight: 850;
}

.profile-modern .pm-principal-role {
    margin: 0 0 18px;
    color: var(--pm-blue);
    font-size: 13px;
    font-weight: 750;
}

.profile-modern .pm-principal blockquote {
    margin: 0;
    padding-left: 17px;
    border-left: 3px solid var(--pm-gold);
    color: #52627b;
    font-size: 13px;
    line-height: 1.95;
}

.profile-modern .pm-principal-signoff {
    margin: 17px 0 0;
    color: var(--pm-navy);
    font-size: 13px;
    font-weight: 800;
}

/* VISI DAN MISI */
.profile-modern .pm-vm-grid {
    display: grid;
    grid-template-columns: .9fr 1.1fr;
    gap: 22px;
    margin-top: 52px;
}

.profile-modern .pm-vm-card {
    position: relative;
    padding: 27px;
    overflow: hidden;
    border: 1px solid #e5eaf3;
    border-radius: 19px;
    background: #fff;
    box-shadow: 0 6px 22px rgba(11,21,51,.03);
    transition: transform .28s ease, box-shadow .28s ease;
}

.profile-modern .pm-vm-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 14px 30px rgba(11,21,51,.08);
}

.profile-modern .pm-vm-card.pm-vision {
    border-color: transparent;
    background: linear-gradient(145deg, #1746a2, #0b1533);
}

.profile-modern .pm-vm-icon {
    display: grid;
    width: 45px;
    height: 45px;
    margin-bottom: 17px;
    place-items: center;
    border-radius: 13px;
    color: var(--pm-navy);
    background: var(--pm-gold);
    font-size: 20px;
}

.profile-modern .pm-vm-card h3 {
    margin: 0 0 13px;
    color: var(--pm-navy);
    font-size: 20px;
}

.profile-modern .pm-vm-card.pm-vision h3 {
    color: #fff;
}

.profile-modern .pm-vm-card p {
    margin: 0;
    color: var(--pm-gray);
    font-size: 13px;
    line-height: 1.9;
}

.profile-modern .pm-vm-card.pm-vision p {
    color: #dce6f8;
}

.profile-modern .pm-mission-list {
    display: grid;
    gap: 13px;
    margin: 0;
    padding: 0;
    list-style: none;
}

.profile-modern .pm-mission-list li {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    color: var(--pm-gray);
    font-size: 13px;
    line-height: 1.8;
}

.profile-modern .pm-check {
    display: grid;
    flex-shrink: 0;
    width: 22px;
    height: 22px;
    place-items: center;
    margin-top: 2px;
    border-radius: 50%;
    color: var(--pm-blue);
    background: #edf3ff;
    font-size: 12px;
    font-weight: 900;
}

/* CTA */
.profile-modern .pm-cta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    margin-top: 27px;
    padding: 26px;
    border: 1px solid #e5eaf3;
    border-radius: 17px;
    background: #f7f9fd;
}

.profile-modern .pm-cta h3 {
    margin: 0 0 8px;
    color: var(--pm-navy);
    font-size: 18px;
}

.profile-modern .pm-cta p {
    margin: 0;
    color: var(--pm-gray);
    font-size: 13px;
    line-height: 1.8;
}

.profile-modern .pm-cta a {
    display: inline-flex;
    flex-shrink: 0;
    align-items: center;
    gap: 9px;
    padding: 13px 19px;
    border-radius: 999px;
    color: #0b1533;
    background: var(--pm-gold);
    font-size: 12px;
    font-weight: 800;
    text-decoration: none;
    transition: transform .25s ease, box-shadow .25s ease;
}

.profile-modern .pm-cta a:hover {
    transform: translateY(-3px);
    box-shadow: 0 9px 20px rgba(255,189,0,.28);
}

/* RESPONSIVE */
@media (max-width: 850px) {
    .profile-modern .pm-principal {
        grid-template-columns: 210px minmax(0, 1fr);
        gap: 25px;
        padding: 23px;
    }
}

@media (max-width: 600px) {
    .profile-modern .container {
        width: calc(100% - 30px);
    }

    .profile-modern .pm-hero {
        padding: 42px 0;
    }

    .profile-modern .pm-hero h1 {
        font-size: 32px;
    }

    .profile-modern .pm-hero-buttons {
        align-items: flex-start;
        flex-direction: column;
    }

    .profile-modern .pm-content {
        padding: 42px 0 55px;
    }

    .profile-modern .pm-principal {
        grid-template-columns: 1fr;
        gap: 27px;
        padding: 20px;
    }

    .profile-modern .pm-principal-photo-wrap {
        max-width: 230px;
    }

    .profile-modern .pm-principal-photo {
        aspect-ratio: 4 / 3;
    }

    .profile-modern .pm-vm-grid {
        grid-template-columns: 1fr;
    }

    .profile-modern .pm-cta {
        align-items: flex-start;
        flex-direction: column;
    }
}

@media (prefers-reduced-motion: reduce) {
    .profile-modern *,
    .profile-modern *::before,
    .profile-modern *::after {
        animation: none !important;
        transition: none !important;
    }
}
</style>

<main class="profile-modern">

    <!-- HERO PROFIL -->
    <section class="pm-hero">
        <div class="container">
            <div class="pm-hero-grid">
                <div class="pm-animate">
                    <div class="pm-eyebrow">Profil Sekolah</div>

                    <h1>
                        Mengenal Lebih Dekat
                        <span>SMK Infokom</span>
                        Kota Bogor
                    </h1>

                    <p class="pm-hero-description">
                        SMK Infokom Kota Bogor berkomitmen mencetak lulusan
                        yang kompeten, berkarakter, kreatif, serta siap
                        menghadapi tantangan dunia kerja maupun melanjutkan
                        pendidikan ke jenjang yang lebih tinggi.
                    </p>

                    <div class="pm-hero-buttons">
                        <a href="#sambutan" class="pm-button pm-button-gold">
                            Sambutan Kepala Sekolah &rarr;
                        </a>

                        <a href="<?= BASE_URL ?>ijk-fasilitas.php" class="pm-button pm-button-outline">
                            Lihat Fasilitas
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- KONTEN PROFIL -->
    <section class="pm-content">
        <div class="container">

            <!-- TENTANG KAMI -->
            <div class="pm-section-heading">
                <div class="pm-eyebrow">Tentang Kami</div>

                <h2>Sekolah untuk Masa Depan</h2>

                <p>
                    Kami mendukung peserta didik untuk mengembangkan
                    pengetahuan, keterampilan teknologi, kreativitas,
                    kedisiplinan, serta karakter yang baik. Melalui
                    pembelajaran dan kerja sama dengan dunia industri,
                    siswa dipersiapkan menghadapi kebutuhan masa depan
                    dengan kompetensi yang sesuai perkembangan zaman.
                </p>
            </div>

            <!-- SAMBUTAN KEPALA SEKOLAH -->
            <section class="pm-principal" id="sambutan">
                <div class="pm-principal-photo-wrap">
                    <img
                        src="<?= BASE_URL ?>assets/img/kepala-sekolah.png"
                        alt="Foto Kepala Sekolah SMK Infokom Kota Bogor"
                        class="pm-principal-photo"
                        loading="lazy"
                        onerror="this.style.display='none';this.nextElementSibling.style.display='grid';"
                    >

                    <div
                        class="pm-principal-photo"
                        style="display:none;place-items:center;text-align:center;padding:20px;color:#1746a2;font-size:13px;font-weight:700;"
                    >
                        <div>
                            <i class="fa-solid fa-user-tie"
                               style="font-size:45px;margin-bottom:12px;"></i>
                            <br>
                            Foto Kepala Sekolah
                            <br>
                            <small>assets/img/kepala-sekolah.png</small>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="pm-principal-label">
                        Sambutan Kepala Sekolah
                    </div>

                    <h2>Selamat Datang di SMK Infokom Kota Bogor</h2>

                    <p class="pm-principal-role">
                        Kepala Sekolah SMK Infokom Kota Bogor
                    </p>

                    <blockquote>
                        Assalamu’alaikum warahmatullahi wabarakatuh.

                        Selamat datang di website SMK Infokom Kota Bogor.
                        Kami percaya bahwa setiap peserta didik memiliki
                        potensi untuk berkembang menjadi pribadi yang
                        kompeten, kreatif, dan berkarakter. Melalui
                        pembelajaran yang mengikuti perkembangan teknologi,
                        pembentukan karakter, serta kerja sama dengan dunia
                        industri, kami berupaya mempersiapkan generasi muda
                        agar siap menghadapi tantangan masa depan.

                        Semoga website ini menjadi sumber informasi yang
                        bermanfaat bagi siswa, orang tua, alumni, mitra
                        industri, dan seluruh masyarakat. Mari bersama-sama
                        mendukung pendidikan yang berkualitas demi lahirnya
                        generasi yang berintegritas dan siap berkarya.

                        Wassalamu’alaikum warahmatullahi wabarakatuh.
                    </blockquote>

                    <p class="pm-principal-signoff">
                        Salam hangat dan salam pendidikan.
                    </p>
                </div>
            </section>

            <!-- VISI DAN MISI SEKOLAH -->
            <section class="pm-vm-grid" id="visi-misi">

                <article class="pm-vm-card pm-vision">
                    <div class="pm-vm-icon">
                        <i class="fa-solid fa-eye" aria-hidden="true"></i>
                    </div>

                    <h3>Visi Sekolah</h3>

                    <p>
                        Terwujudnya SMK Infokom Bogor sebagai SMK yang peduli
                        dan berbudaya lingkungan hidup dengan tamatan yang
                        kompeten dan mampu bersaing di tingkat Nasional,
                        maupun Internasional.
                    </p>
                </article>

                <article class="pm-vm-card">
                    <div class="pm-vm-icon">
                        <i class="fa-solid fa-bullseye" aria-hidden="true"></i>
                    </div>

                    <h3>Misi Sekolah</h3>

                    <ul class="pm-mission-list">
                        <li>
                            <span class="pm-check">&#10003;</span>
                            <span>
                                Membentuk karakter peserta didik yang
                                beriman dan bertakwa.
                            </span>
                        </li>

                        <li>
                            <span class="pm-check">&#10003;</span>
                            <span>
                                Mengembangkan kurikulum nasional yang
                                mendukung proses pendidikan kejuruan.
                            </span>
                        </li>

                        <li>
                            <span class="pm-check">&#10003;</span>
                            <span>
                                Meningkatkan kualitas lulusan agar kompeten,
                                siap kerja, dan mampu bersaing.
                            </span>
                        </li>

                        <li>
                            <span class="pm-check">&#10003;</span>
                            <span>
                                Mendorong lulusan agar mandiri dan mampu
                                mengembangkan usaha sebagai wirausahawan.
                            </span>
                        </li>

                        <li>
                            <span class="pm-check">&#10003;</span>
                            <span>
                                Menumbuhkan etos kerja yang kompetitif
                                melalui kemitraan dan pelayanan prima.
                            </span>
                        </li>
                    </ul>
                </article>

            </section>

            <!-- AJAKAN PROGRAM KEAHLIAN -->
            <section class="pm-cta">
                <div>
                    <h3>Kenali Program Keahlian Kami</h3>

                    <p>
                        Temukan bidang keahlian yang mendukung minat,
                        bakat, dan rencana masa depanmu.
                    </p>
                </div>

                <a href="<?= BASE_URL ?>ijk-program-keahlian.php">
                    Lihat Program Keahlian &rarr;
                </a>
            </section>

        </div>
    </section>

</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const items = document.querySelectorAll(
        '.profile-modern .pm-section-heading, ' +
        '.profile-modern .pm-principal, ' +
        '.profile-modern .pm-vm-card, ' +
        '.profile-modern .pm-cta'
    );

    if (!('IntersectionObserver' in window)) {
        items.forEach(function (item) {
            item.style.opacity = '1';
        });
        return;
    }

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('pm-animate');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.12
    });

    items.forEach(function (item) {
        observer.observe(item);
    });
});
</script>

<?php require_once __DIR__ . '/includes/ijk-footer.php'; ?>