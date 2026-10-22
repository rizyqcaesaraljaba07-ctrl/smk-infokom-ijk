<?php
/**
 * Konfigurasi Koneksi Database
 * Sesuaikan DB_HOST, DB_NAME, DB_USER, DB_PASS dengan environment Anda
 */

define('DB_HOST', 'localhost');
define('DB_NAME', 'smk_infokom');
define('DB_USER', 'root');
define('DB_PASS', '');

define('BASE_URL', '/smk-infokom-ijk/');
function getDB() {
    static $pdo = null;
    if ($pdo === null) {
        try {
            $pdo = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $e) {
            die('Koneksi database gagal: ' . $e->getMessage());
        }
    }
    return $pdo;
}
