<?php $p = getPengaturan(); ?>
<footer>
  <div class="container">
    <div class="footer-grid">
      <div>
        <div class="brand" style="color:#fff;margin-bottom:14px; display: flex; align-items: center; gap: 10px;">
          
          <!-- LOGO SEKOLAH DARI DATABASE -->
          <?php if (!empty($p['logo'])): ?>
            <img src="<?= BASE_URL ?>uploads/logo/<?= h($p['logo']) ?>" alt="Logo <?= h($p['nama_sekolah']) ?>" style="width: 45px; height: 45px; object-fit: contain;">
          <?php else: ?>
            <div style="width:40px;height:40px;background:#f5b400;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#0b1533;font-weight:800;">SI</div>
          <?php endif; ?>
          
          <div>
            <?= h($p['nama_sekolah']) ?>
            <small style="color:#a7aed0; display: block; font-weight: 500;">Berkarakter · Kompeten · Berdaya Saing</small>
          </div>
          
        </div>
        <p><?= h($p['alamat']) ?></p>
      </div>
      <div>
        <h4>Link Cepat</h4>
        <ul>
          <li><a href="<?= BASE_URL ?>ijk-index.php">Beranda</a></li>
          <li><a href="<?= BASE_URL ?>ijk-profil.php">Profil</a></li>
          <li><a href="<?= BASE_URL ?>ijk-akademik.php">Akademik</a></li>
          <li><a href="<?= BASE_URL ?>ijk-program-keahlian.php">Program Keahlian</a></li>
        </ul>
      </div>
      <div>
        <h4>Kontak Kami</h4>
        <ul>
          <li><i class="fa-solid fa-location-dot"></i> <?= h($p['alamat']) ?></li>
          <li><i class="fa-solid fa-phone"></i> <?= h($p['telepon']) ?></li>
          <li><i class="fa-solid fa-envelope"></i> <?= h($p['email']) ?></li>
        </ul>
        <div class="footer-social">
          <a href="<?= h($p['instagram']) ?>"><i class="fa-brands fa-instagram"></i></a>
          <a href="<?= h($p['youtube']) ?>"><i class="fa-brands fa-youtube"></i></a>
          <a href="<?= h($p['tiktok']) ?>"><i class="fa-brands fa-tiktok"></i></a>
          <a href="<?= h($p['facebook']) ?>"><i class="fa-brands fa-facebook"></i></a>
        </div>
      </div>
      <div>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    &copy; <?= date('Y') ?> <?= h($p['nama_sekolah']) ?>. All rights reserved.
  </div>
</footer>
<script src="<?= BASE_URL ?>assets/js/ijk-main.js?v=<?= @filemtime(__DIR__ . '/../assets/js/ijk-main.js') ?>"></script>
</body>
</html>