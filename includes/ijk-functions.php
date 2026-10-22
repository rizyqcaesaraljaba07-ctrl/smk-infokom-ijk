<?php
require_once __DIR__ . '/../config/ijk-database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/** Ambil satu baris pengaturan umum sekolah */
function getPengaturan() {
    static $data = null;
    if ($data === null) {
        $stmt = getDB()->query("SELECT * FROM pengaturan LIMIT 1");
        $data = $stmt->fetch();
    }
    return $data;
}

/** Bersihkan input untuk output HTML (cegah XSS) */
function h($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

/** Format tanggal Indonesia, mis: 12 Jul 2025 */
function formatTanggal($tanggal, $format = 'd M Y') {
    if (!$tanggal) return '-';
    $bulanIndo = [
        '01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'Mei','06'=>'Jun',
        '07'=>'Jul','08'=>'Agu','09'=>'Sep','10'=>'Okt','11'=>'Nov','12'=>'Des'
    ];
    $ts = strtotime($tanggal);
    $hari = date('d', $ts);
    $bulan = $bulanIndo[date('m', $ts)];
    $tahun = date('Y', $ts);
    return "$hari $bulan $tahun";
}

/** Buat slug dari string */
function buatSlug($string) {
    $string = strtolower(trim($string));
    $string = preg_replace('/[^a-z0-9]+/', '-', $string);
    return trim($string, '-');
}

/** Cek apakah admin sudah login */
function isLoggedIn() {
    return isset($_SESSION['admin_id']);
}

/** Wajib login, redirect ke halaman login jika belum */
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ijk-login.php');
        exit;
    }
}

/** Catat log aktivitas admin */
function catatLog($aktivitas) {
    $user = $_SESSION['admin_nama'] ?? 'System';
    $stmt = getDB()->prepare("INSERT INTO activity_log (user, aktivitas) VALUES (?, ?)");
    $stmt->execute([$user, $aktivitas]);
}

/** Upload file gambar sederhana, kembalikan nama file baru atau null */
function uploadGambar($fileInputName, $targetDir) {
    if (!isset($_FILES[$fileInputName]) || $_FILES[$fileInputName]['error'] !== UPLOAD_ERR_OK) {
        return null;
    }
    $file = $_FILES[$fileInputName];
    $allowed = ['jpg','jpeg','png','webp'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) return null;
    if (!is_dir($targetDir)) { @mkdir($targetDir, 0777, true); }

    $newName = uniqid('img_', true) . '.' . $ext;
    $destPath = rtrim($targetDir, '/') . '/' . $newName;
    if (move_uploaded_file($file['tmp_name'], $destPath)) {
        return $newName;
    }
    return null;
}

/** Redirect helper */
function redirect($url) {
    header("Location: $url");
    exit;
}

/** Flash message sederhana via session */
function setFlash($type, $message) {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}
function getFlash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/** Pastikan URL hanya http/https. Kembalikan null kalau tidak valid */
function urlAman($url) {
    $url = trim((string)$url);
    if ($url === '') return null;
    if (!preg_match('#^https?://#i', $url)) $url = 'https://' . $url;
    return filter_var($url, FILTER_VALIDATE_URL) ? $url : null;
}

/** HTML logo mitra (dipakai di beranda & halaman BKK) */
function mitraLogoHtml($m, $extraClass = '', $duplikat = false) {
    $web = urlAman($m['website'] ?? '');
    $isi = !empty($m['logo'])
        ? '<img src="uploads/mitra/' . h($m['logo']) . '" alt="' . h($m['nama']) . '" loading="lazy">'
        : '<span class="mitra-name">' . h($m['nama']) . '</span>';
    $attr = 'class="mitra-logo ' . h($extraClass) . '" title="' . h($m['nama']) . '"';
    if ($duplikat) $attr .= ' aria-hidden="true" tabindex="-1"';
    if ($web) {
        return '<a ' . $attr . ' href="' . h($web) . '" target="_blank" rel="noopener noreferrer">' . $isi . '</a>';
    }
    return '<div ' . $attr . '>' . $isi . '</div>';
}
