<?php
require_once __DIR__ . '/../../includes/ijk-functions.php';
$p = getPengaturan();
?>
<?php if (!empty($p['logo'])): ?>
    <link rel="icon" type="image/png" href="../uploads/logo/<?= h($p['logo']) ?>">
<?php endif; ?>