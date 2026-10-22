<?php
// Ambil pengaturan langsung di topbar agar favicon bisa dipanggil otomatis
require_once __DIR__ . '/../../includes/ijk-functions.php';
$p = getPengaturan();
?>

<!-- Script otomatis memasang favicon di tab browser Admin -->
<?php if (!empty($p['logo'])): ?>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      let link = document.querySelector("link[rel~='icon']");
      if (!link) {
        link = document.createElement('link');
        link.rel = 'icon';
        document.head.appendChild(link);
      }
      link.href = '../uploads/logo/<?= h($p['logo']) ?>';
    });
  </script>
<?php endif; ?>

<div class="topbar-admin">
  <h2><?= h($pageTitle ?? 'Dashboard') ?></h2>
  <div class="admin-user">
    <div class="avatar"><?= strtoupper(substr($_SESSION['admin_nama'] ?? 'A', 0, 1)) ?></div>
    <span><?= h($_SESSION['admin_nama'] ?? 'Admin') ?></span>
    <i class="fa-solid fa-chevron-down" style="font-size:11px;color:var(--gray);"></i>
  </div>
</div>