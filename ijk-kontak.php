<?php
require_once __DIR__ . '/includes/ijk-functions.php';
$p = getPengaturan();
require_once __DIR__ . '/includes/ijk-header.php';
?>
<section class="about" style="padding-top:50px;">
  <div class="container about-grid">
    <div>
      <div class="section-label">Kontak</div>
      <div class="section-title">Hubungi Kami</div>
      <p><i class="fa-solid fa-location-dot" style="color:var(--gold);"></i> <?= h($p['alamat']) ?></p>
      <p><i class="fa-solid fa-phone" style="color:var(--gold);"></i> <?= h($p['telepon']) ?></p>
      <p><i class="fa-solid fa-envelope" style="color:var(--gold);"></i> <?= h($p['email']) ?></p>
      <div class="footer-map" style="margin-top:20px;">
        <?= $p['maps_embed'] ?>
      </div>
    </div>
    <div>
      <div class="section-label">Kirim Pesan</div>
      <form style="display:grid;gap:14px;margin-top:10px;">
        <input type="text" placeholder="Nama Lengkap" style="padding:12px;border:1px solid var(--border);border-radius:8px;">
        <input type="email" placeholder="Email" style="padding:12px;border:1px solid var(--border);border-radius:8px;">
        <textarea placeholder="Pesan" rows="5" style="padding:12px;border:1px solid var(--border);border-radius:8px;"></textarea>
        <button type="submit" class="btn btn-gold" style="color:#0b1533;">Kirim Pesan</button>
      </form>
    </div>
  </div>
</section>
<?php require_once __DIR__ . '/includes/ijk-footer.php'; ?>
