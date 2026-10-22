<?php
require_once __DIR__ . '/../includes/ijk-functions.php';
requireLogin();
$db = getDB();

$id = (int)($_GET['id'] ?? 0);
$stmt = $db->prepare("SELECT p.*, pk.nama AS jurusan_nama, pk2.nama AS jurusan2_nama
    FROM ppdb p
    LEFT JOIN program_keahlian pk  ON p.jurusan_pilihan   = pk.id
    LEFT JOIN program_keahlian pk2 ON p.jurusan_pilihan_2 = pk2.id
    WHERE p.id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch();

if (!$row) {
    http_response_code(404);
    echo 'Data pendaftar tidak ditemukan.';
    exit;
}

$backUrl = 'ijk-ppdb.php';
include __DIR__ . '/../includes/ijk-ppdb-bukti.php';