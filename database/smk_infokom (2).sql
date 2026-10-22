-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Okt 2026 pada 09.10
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smk_infokom`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('Hadir','Sakit','Izin','Alpa') DEFAULT 'Hadir',
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int(11) NOT NULL,
  `user` varchar(100) NOT NULL,
  `aktivitas` varchar(255) NOT NULL,
  `waktu` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `activity_log`
--

INSERT INTO `activity_log` (`id`, `user`, `aktivitas`, `waktu`) VALUES
(1, 'Administrator', 'Login ke sistem', '2026-09-29 11:37:23'),
(2, 'Administrator', 'Menambah data siswa: Rizyq Caesar Al Jabar', '2026-09-29 11:38:31'),
(3, 'Administrator', 'Menambah data siswa: M Raihan Ramadhan', '2026-09-29 11:39:26'),
(4, 'Administrator', 'Menambah data siswa: Naufal M Nafis', '2026-09-29 11:39:57'),
(5, 'Administrator', 'Menambah data siswa: M Rangga Revano', '2026-09-29 11:40:29'),
(6, 'Administrator', 'Menambah data siswa: Vigoza Rinova', '2026-09-29 11:41:22'),
(7, 'Administrator', 'Menambah data guru: Ir. Hj. Liliek Rahmaningsih, M.M.Pd.', '2026-09-29 11:43:50'),
(8, 'Administrator', 'Menambah data guru: Mila Yaelasari, M.Pd.', '2026-09-29 11:45:11'),
(9, 'Administrator', 'Menambah data guru: Dea Rijalul Fikri, S.Kom.,Gr.', '2026-09-29 11:46:10'),
(10, 'Administrator', 'Menambah data guru: R. Radiani Srirestuti Dewi, SS.,Gr.', '2026-09-29 11:47:13'),
(11, 'Administrator', 'Menambah data guru: Heny Handayani, S.Pd.', '2026-09-29 11:51:30'),
(12, 'Administrator', 'Menambah data guru: Agus Tiyono, M.Pd.', '2026-09-29 11:53:26'),
(13, 'Administrator', 'Mengubah program keahlian: Rekayasa Perangkat Lunak (RPL)', '2026-09-29 12:01:20'),
(14, 'Administrator', 'Mengubah program keahlian: Rekayasa Perangkat Lunak (RPL)', '2026-09-29 12:05:35'),
(15, 'Administrator', 'Mengubah program keahlian: Rekayasa Perangkat Lunak (RPL)', '2026-09-29 12:09:13'),
(16, 'Administrator', 'Mengubah program keahlian: Teknik Komputer dan Jaringan (TKJ)', '2026-09-29 12:09:25'),
(17, 'Administrator', 'Mengubah program keahlian: Produksi dan Siaran Program Televisi (PSPT)', '2026-09-29 12:10:59'),
(18, 'Administrator', 'Mengubah program keahlian: Desain Komunikasi Visual (DKV)', '2026-09-29 12:11:38'),
(19, 'Administrator', 'Login ke sistem', '2026-09-29 18:21:13'),
(20, 'Administrator', 'Login ke sistem', '2026-09-29 20:00:57'),
(21, 'Administrator', 'Memperbarui pengaturan umum sekolah', '2026-09-29 20:04:58'),
(22, 'Administrator', 'Mengubah data berita', '2026-09-29 20:09:23'),
(23, 'Administrator', 'Mengubah data berita', '2026-09-29 20:12:13'),
(24, 'Administrator', 'Mengubah data berita', '2026-09-29 20:13:27'),
(25, 'Administrator', 'Mengubah data berita', '2026-09-29 20:14:44'),
(26, 'Administrator', 'Mengubah ekstrakurikuler: Pramuka', '2026-09-29 20:27:37'),
(27, 'Administrator', 'Mengubah ekstrakurikuler: Pramuka', '2026-09-29 20:28:13'),
(28, 'Administrator', 'Mengubah ekstrakurikuler: OSIS', '2026-09-29 20:28:59'),
(29, 'Administrator', 'Mengubah ekstrakurikuler: Futsal', '2026-09-29 20:29:32'),
(30, 'Administrator', 'Mengubah ekstrakurikuler: Basket', '2026-09-29 20:30:03'),
(31, 'Administrator', 'Mengubah ekstrakurikuler: Rohis', '2026-09-29 20:30:33'),
(32, 'Administrator', 'Mengubah ekstrakurikuler: Paskibra', '2026-09-29 20:31:17'),
(33, 'Administrator', 'Mengubah prestasi: Juara 1 LKS SMK Tingkat Kota Bogor', '2026-09-29 20:44:35'),
(34, 'Administrator', 'Mengubah prestasi: Juara 2 Web Design Competition', '2026-09-29 20:45:43'),
(35, 'Administrator', 'Mengubah prestasi: Juara 1 Jaringan Kompetisi Kota', '2026-09-29 20:46:38'),
(36, 'Administrator', 'Mengubah prestasi: Best Project Multimedia', '2026-09-29 20:47:49'),
(37, 'Administrator', 'Mengubah prestasi: Penghargaan Sekolah Adiwiyata', '2026-09-29 20:48:37'),
(38, 'Administrator', 'Login ke sistem', '2026-09-30 07:09:41'),
(39, 'Administrator', 'Mengubah data berita', '2026-09-30 07:12:50'),
(40, 'Administrator', 'Mengubah data berita', '2026-09-30 07:12:58'),
(41, 'Administrator', 'Mengubah data berita', '2026-09-30 07:13:12'),
(42, 'Administrator', 'Mengubah data berita', '2026-09-30 07:13:20'),
(43, 'Administrator', 'Mengubah item galeri: Kegiatan Ekstrakurikuler', '2026-09-30 07:15:24'),
(44, 'Administrator', 'Mengubah item galeri: Lomba Kompetensi Siswa', '2026-09-30 07:16:00'),
(45, 'Administrator', 'Mengubah item galeri: Kegiatan Praktik RPL', '2026-09-30 07:17:05'),
(46, 'Administrator', 'Mengubah item galeri: Upacara Bendera', '2026-09-30 07:18:26'),
(47, 'Administrator', 'Mengubah item galeri: Kunjungan Industri', '2026-09-30 07:19:08'),
(48, 'Administrator', 'Menambah lowongan BKK: Manager', '2026-09-30 08:12:22'),
(49, 'Administrator', 'Mengubah lowongan BKK: PT MEKAR JAYA', '2026-09-30 08:20:42'),
(50, 'Administrator', 'Mengubah lowongan BKK: PT MEKAR JAYA', '2026-09-30 08:24:55'),
(51, 'Administrator', 'Menambah lowongan BKK: PT TAMBANG EMAS', '2026-09-30 08:28:50'),
(52, 'Administrator', 'Mengubah lowongan BKK: PT MEKAR JAYA', '2026-09-30 08:31:01'),
(53, 'Administrator', 'Menambah mitra: PT. Guna Senaputra Sejahtera', '2026-09-30 08:35:49'),
(54, 'Administrator', 'Menambah mitra: Raja Promo Advertising', '2026-09-30 08:41:02'),
(55, 'Administrator', 'Memperbarui pengaturan umum sekolah', '2026-09-30 08:49:00'),
(56, 'Administrator', 'Memperbarui pengaturan umum sekolah', '2026-09-30 08:49:45'),
(57, 'Administrator', 'Mengubah mitra: PT. Guna Senaputra Sejahtera', '2026-09-30 08:52:07'),
(58, 'Administrator', 'Memperbarui pengaturan umum sekolah', '2026-09-30 09:43:34'),
(59, 'Administrator', 'Login ke sistem', '2026-09-30 16:05:33'),
(60, 'Administrator', 'Menambah prestasi: Juara 3 Futsal Piala Kemerdekaan', '2026-09-30 16:14:26'),
(61, 'Administrator', 'Menghapus ekstrakurikuler ID 2', '2026-09-30 16:15:15'),
(62, 'Administrator', 'Menghapus ekstrakurikuler ID 6', '2026-09-30 16:15:22'),
(63, 'Administrator', 'Menghapus item galeri ID 1', '2026-09-30 16:21:59'),
(64, 'Administrator', 'Mengubah item galeri: Kegiatan Praktik RPL', '2026-09-30 16:22:27'),
(65, 'Administrator', 'Mengubah data berita', '2026-09-30 16:23:10'),
(66, 'Administrator', 'Menambah info PKL: Praktik Kerja Lapangan (PKL)', '2026-09-30 16:27:08'),
(67, 'Administrator', 'Mengubah lowongan BKK: Bursa Lowongan Kerja', '2026-09-30 16:37:24'),
(68, 'Administrator', 'Mengubah lowongan BKK: Bursa Lowongan Kerja', '2026-09-30 16:53:10'),
(69, 'Administrator', 'Mengubah info PKL: Syarat PKL', '2026-09-30 16:56:54'),
(70, 'Administrator', 'Mengubah program keahlian: Rekayasa Perangkat Lunak (RPL)', '2026-10-20 07:36:42'),
(71, 'Administrator', 'Mengubah program keahlian: Teknik Komputer dan Jaringan (TKJ)', '2026-10-20 07:36:56'),
(72, 'Administrator', 'Mengubah program keahlian: Produksi dan Siaran Program Televisi (PSPT)', '2026-10-20 07:37:18'),
(73, 'Administrator', 'Mengubah program keahlian: Desain Komunikasi Visual (DKV)', '2026-10-20 07:37:24'),
(74, 'Administrator', 'Mengubah item galeri: Kegiatan Upacara Bendera', '2026-10-20 07:43:10'),
(75, 'Administrator', 'Mengubah item galeri: Kegiatan Upacara Bendera', '2026-10-20 07:46:51'),
(76, 'Administrator', 'Mengubah mitra: by.U', '2026-10-20 08:01:13'),
(77, 'Administrator', 'Mengubah mitra: by.U', '2026-10-20 08:06:45'),
(78, 'Administrator', 'Mengubah mitra: BONET | IT Solution Partner', '2026-10-20 08:13:44'),
(79, 'Administrator', 'Menambah mitra: PT Bank Syariah Indonesia (Persero) Tbk (BSI)', '2026-10-20 08:18:57'),
(80, 'Administrator', 'Menambah mitra: IPB University (Institut Pertanian Bogor)', '2026-10-20 08:24:30'),
(81, 'Administrator', 'Mengubah mitra: by.U', '2026-10-20 08:24:59'),
(82, 'Administrator', 'Mengubah mitra: BONET | IT Solution Partner', '2026-10-20 08:25:10'),
(83, 'Administrator', 'Mengubah mitra: PT Bank Syariah Indonesia (Persero) Tbk (BSI)', '2026-10-20 08:25:23'),
(84, 'Administrator', 'Menambah mitra: Jawa Pos', '2026-10-20 08:29:29'),
(85, 'Administrator', 'Mengubah mitra: BONET | IT Solution Partner', '2026-10-20 08:30:07'),
(86, 'Administrator', 'Mengubah mitra: IPB University (Institut Pertanian Bogor)', '2026-10-20 08:30:20'),
(87, 'Administrator', 'Menambah mitra: Universitas Ibn Khaldun (UIKA) Bogor', '2026-10-20 08:34:25'),
(88, 'Administrator', 'Menambah mitra: Universitas Djuanda (UNIDA)', '2026-10-20 08:39:08'),
(89, 'Administrator', 'Menambah mitra: Universitas Pakuan (Unpak)', '2026-10-20 08:42:15'),
(90, 'Administrator', 'Mengubah item galeri: Sholat Duha', '2026-10-20 08:48:22'),
(91, 'Administrator', 'Mengubah item galeri: Apel Pramuka', '2026-10-20 08:52:15'),
(92, 'Administrator', 'Mengubah item galeri: Kegiatan Robotik', '2026-10-20 08:56:12'),
(93, 'Administrator', 'Mengubah ekstrakurikuler: Basket', '2026-10-20 08:56:42'),
(94, 'Administrator', 'Mengubah ekstrakurikuler: Paskibra', '2026-10-20 08:56:52'),
(95, 'Administrator', 'Mengubah ekstrakurikuler: Pramuka', '2026-10-20 08:57:13'),
(96, 'Administrator', 'Mengubah ekstrakurikuler: Pramuka', '2026-10-20 09:00:18'),
(97, 'Administrator', 'Mengubah prestasi: Juara 3 Futsal Piala Kemerdekaan', '2026-10-20 09:11:29'),
(98, 'Administrator', 'Login ke sistem', '2026-10-20 14:09:32'),
(99, 'Administrator', 'Menghapus data guru: Ir. Hj. Liliek Rahmaningsih, M.M.Pd.', '2026-10-20 15:00:28'),
(100, 'Administrator', 'Login ke sistem', '2026-10-20 15:37:04'),
(101, 'Administrator', 'Menghapus prestasi ID 1', '2026-10-20 15:54:07'),
(102, 'Administrator', 'Menghapus prestasi ID 2', '2026-10-20 15:54:13'),
(103, 'Administrator', 'Menghapus prestasi ID 3', '2026-10-20 15:54:18'),
(104, 'Administrator', 'Menghapus prestasi ID 4', '2026-10-20 15:54:23'),
(105, 'Administrator', 'Menghapus prestasi ID 5', '2026-10-20 15:54:27'),
(106, 'Administrator', 'Mengubah prestasi: Juara 3 Futsal Piala Kemerdekaan', '2026-10-20 15:55:08'),
(107, 'Administrator', 'Mengubah prestasi: Juara 3 Futsal Piala Kemerdekaan', '2026-10-20 15:57:15'),
(108, 'Administrator', 'Menambah prestasi: Juara 1 E-Sport  KBOF 2026', '2026-10-20 16:00:34'),
(109, 'Administrator', 'Menambah prestasi: Juara 1 FDW 2026 Renascora', '2026-10-20 16:01:59'),
(110, 'Administrator', 'Menambah ekstrakurikuler: Badminton', '2026-10-20 16:06:08'),
(111, 'Administrator', 'Menambah ekstrakurikuler: Ekstrakurikuler Palang Merah Remaja (PMR)', '2026-10-20 16:11:27'),
(112, 'Administrator', 'Mengubah data berita', '2026-10-20 16:15:45'),
(113, 'Administrator', 'Mengubah data berita', '2026-10-20 16:18:17'),
(114, 'Administrator', 'Mengubah data berita', '2026-10-20 16:18:57'),
(115, 'Administrator', 'Mengubah info PKL: Syarat PKL', '2026-10-20 16:20:44'),
(116, 'Administrator', 'Menghapus info PKL ID 2', '2026-10-20 16:21:56'),
(117, 'Administrator', 'Menghapus info PKL ID 4', '2026-10-20 16:22:07'),
(118, 'Administrator', 'Menghapus info PKL ID 5', '2026-10-20 16:22:25'),
(119, 'Administrator', 'Menambah info PKL: Alur Pendaftaran PKL', '2026-10-20 16:22:49'),
(120, 'Administrator', 'Mengubah info PKL: Alur Pendaftaran PKL', '2026-10-20 16:25:31'),
(121, 'Administrator', 'Mengubah info PKL: Alur Pendaftaran PKL', '2026-10-20 16:25:48'),
(122, 'Administrator', 'Mengubah info PKL: Apa itu PKL?', '2026-10-20 16:26:25'),
(123, 'Administrator', 'Menghapus info PKL ID 7', '2026-10-20 16:29:40'),
(124, 'Administrator', 'Menambah info PKL: Praktik Kerja Lapangan (PKL)', '2026-10-20 16:30:35'),
(125, 'Administrator', 'Menghapus info PKL ID 3', '2026-10-20 16:31:00'),
(126, 'Administrator', 'Menambah info PKL: Syarat PKL', '2026-10-20 16:33:09'),
(127, 'Administrator', 'Menghapus info PKL ID 6', '2026-10-20 16:33:54'),
(128, 'Administrator', 'Mengubah info PKL: Syarat Mengikuti PKL', '2026-10-20 16:34:16'),
(129, 'Administrator', 'Mengubah info PKL: Alur Pendaftaran PKL', '2026-10-20 16:34:28'),
(130, 'Administrator', 'Login ke sistem', '2026-10-20 17:54:38'),
(131, 'Administrator', 'Mengubah data guru: Agus Tiyono, M.Pd.', '2026-10-20 17:55:50'),
(132, 'Administrator', 'Mengubah data guru: Dea Rijalul Fikri, S.Kom., Gr.', '2026-10-20 17:56:04'),
(133, 'Administrator', 'Mengubah data guru: Heny Handayani, S.Pd.', '2026-10-20 17:56:39'),
(134, 'Administrator', 'Mengubah data guru: Ir. Hj. Liliek Rahmaningsih, M.M.Pd.', '2026-10-20 17:56:55'),
(135, 'Administrator', 'Mengubah data guru: Mila Yaelasari, M.Pd.', '2026-10-20 17:57:16'),
(136, 'Administrator', 'Mengubah data guru: R. Radiani Srirestuti Dewi, SS., Gr.', '2026-10-20 17:57:36'),
(137, 'Administrator', 'Mengubah data guru: Aditya Nugraha, ST.', '2026-10-20 17:57:50'),
(138, 'Administrator', 'Mengubah data guru: Erli Suherli, A.Md.Kom.', '2026-10-20 17:58:09'),
(139, 'Administrator', 'Mengubah data guru: Muhammad Ibnu Arif, S.IKom.', '2026-10-20 17:58:27'),
(140, 'Administrator', 'Mengubah data guru: Ridwan Hala, S.Kom., Gr.', '2026-10-20 17:58:47'),
(141, 'Administrator', 'Mengubah data guru: Abdul Azis, M.Pd.', '2026-10-20 17:59:03'),
(142, 'Administrator', 'Mengubah data guru: Aditya Nugraha, ST.', '2026-10-20 17:59:18'),
(143, 'Administrator', 'Mengubah data guru: Ahmad Hotib, S.Pd.I', '2026-10-20 17:59:34'),
(144, 'Administrator', 'Mengubah data guru: Cahyadi Rozi, ST.', '2026-10-20 17:59:48'),
(145, 'Administrator', 'Mengubah data guru: Dara Purwanita, S.Pd., Gr.', '2026-10-20 18:00:07'),
(146, 'Administrator', 'Mengubah data guru: Dian Hardianti, S.Kom., Gr.', '2026-10-20 18:00:22'),
(147, 'Administrator', 'Mengubah data guru: Dra. Diana Octaria', '2026-10-20 18:00:54'),
(148, 'Administrator', 'Mengubah data guru: Dra. Popon Puspitasari', '2026-10-20 18:01:11'),
(149, 'Administrator', 'Mengubah data guru: Drs. Puji Marhaen Waluyo', '2026-10-20 18:01:28'),
(150, 'Administrator', 'Mengubah data guru: Erwin Hasiholan Gultom, S.Kom.', '2026-10-20 18:01:44'),
(151, 'Administrator', 'Mengubah data guru: Eva Farida Rahayu, S.Pd., Gr.', '2026-10-20 18:01:59'),
(152, 'Administrator', 'Mengubah data guru: Jayadi, S.Pd., Gr.', '2026-10-20 18:02:12'),
(153, 'Administrator', 'Mengubah data guru: M. Fauzan Arifin, S.IKom., Gr.', '2026-10-20 18:02:25'),
(154, 'Administrator', 'Mengubah data guru: Nabila Ahmadia Pratama, S.Pd.', '2026-10-20 18:02:41'),
(155, 'Administrator', 'Mengubah data guru: Putri Riandini, S.Hut., M.Pd., Gr.', '2026-10-20 18:03:00'),
(156, 'Administrator', 'Mengubah data guru: Reza Prafitriansyah, S.Kom., Gr.', '2026-10-20 18:03:21'),
(157, 'Administrator', 'Mengubah data guru: Richo Santana, S.Kom.', '2026-10-20 18:03:38'),
(158, 'Administrator', 'Mengubah data guru: Rita Widyastuti', '2026-10-20 18:04:00'),
(159, 'Administrator', 'Mengubah data guru: Siti Nuraeni', '2026-10-20 18:04:16'),
(160, 'Administrator', 'Mengubah data guru: Vera Yuni Astuti, SP., M.IKom., Gr.', '2026-10-20 18:04:31'),
(161, 'Administrator', 'Mengubah data guru: Widyatama Nuranisa, SM.', '2026-10-20 18:04:45'),
(162, 'Administrator', 'Mengubah data guru: Yadi Setiadi, S.Sos., Gr.', '2026-10-20 18:04:58'),
(163, 'Administrator', 'Mengubah data guru: Yeni Yuliawati, S.Pd., Gr.', '2026-10-20 18:05:11'),
(164, 'Administrator', 'Memperbarui pengaturan umum sekolah', '2026-10-20 18:49:15'),
(165, 'Administrator', 'Memperbarui pengaturan umum sekolah', '2026-10-20 18:49:25'),
(166, 'Administrator', 'Memperbarui pengaturan umum sekolah', '2026-10-20 18:52:48'),
(167, 'Administrator', 'Login ke sistem', '2026-10-21 15:31:32'),
(168, 'Administrator', 'Login ke sistem', '2026-10-21 15:38:38'),
(169, 'Administrator', 'Mengubah mitra: Universitas Ibn Khaldun (UIKA) Bogor', '2026-10-21 15:52:55'),
(170, 'Administrator', 'Menambah berita baru', '2026-10-21 15:59:35'),
(171, 'Administrator', 'Menghapus info Magang ID 4', '2026-10-21 16:00:52'),
(172, 'Administrator', 'Menghapus info Magang ID 6', '2026-10-21 16:00:57'),
(173, 'Administrator', 'Menghapus info Magang ID 5', '2026-10-21 16:01:04'),
(174, 'Administrator', 'Mengubah info Magang: Timeline & Tahapan', '2026-10-21 16:02:42'),
(175, 'Administrator', 'Mengubah info Magang: Program Magang ke Jepang', '2026-10-21 16:03:29'),
(176, 'Administrator', 'Mengubah info Magang: Syarat & Ketentuan', '2026-10-21 16:04:25'),
(177, 'Administrator', 'Login ke sistem', '2026-10-22 13:05:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `role` enum('Admin','Operator') DEFAULT 'Admin',
  `foto` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `nama`, `role`, `foto`, `created_at`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'Admin', NULL, '2026-09-29 11:33:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `berita`
--

CREATE TABLE `berita` (
  `id` int(11) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `slug` varchar(220) NOT NULL,
  `kategori` varchar(100) DEFAULT 'Umum',
  `isi` text NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `penulis` varchar(100) DEFAULT 'Admin',
  `tanggal` date NOT NULL,
  `dilihat` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `berita`
--

INSERT INTO `berita` (`id`, `judul`, `slug`, `kategori`, `isi`, `gambar`, `penulis`, `tanggal`, `dilihat`, `created_at`) VALUES
(1, 'PPDB Tahun Ajaran 2025/2026', 'mpls-tahun-ajaran-2025-2026', 'Kegiatan', 'Masa Pengenalan Lingkungan Sekolah bagi siswa baru tahun ajaran 2025/2026 berlangsung meriah.', 'img_6abcd4fee31b77.02371478.jpeg', 'Admin', '2025-07-12', 2, '2026-09-29 11:33:23'),
(2, 'Open Recruitment PMR SMK INFOKOM', 'workshop-pemrograman-web-laravel', 'Ekstrakulikuler', 'Open Recruitment PMR SMK INFOKOM, Let\'s Join & Be The Part Of Us!!!', 'img_6ad73141211251.33175715.jpeg', 'Admin', '2025-07-05', 2, '2026-09-29 11:33:23'),
(3, 'LDKS Gabungan', 'juara-1-lks-kota-bogor', 'Ekstrakulikuler', 'LDKS Gabungan Bersama SMK INFOKOM.', 'img_6ad731d9de3589.72277583.jpeg', 'Admin', '2025-06-28', 0, '2026-09-29 11:33:23'),
(4, 'Kunjungan Industri', 'kunjungan-industri', 'Kegiatan', 'Siswa kelas XII melaksanakan kunjungan industri ke perusahaan teknologi.', 'img_6abc5420be94d7.03595900.jpg', 'Admin', '2025-06-20', 1, '2026-09-29 11:33:23'),
(5, 'Magang Ke Jepang', 'magang-ke-jepang-1792573175', 'Umum', 'Berawal dari ketertarikan pada manga (Komik) Jepang, siapa sangka sekarang Nazib Sofian bisa menjalani kehidupan dan magang langsung di Jepang.', 'img_6ad87ef7b7c655.63351269.jpeg', 'Administrator', '2026-10-21', 3, '2026-10-21 15:59:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bkk_lowongan`
--

CREATE TABLE `bkk_lowongan` (
  `id` int(11) NOT NULL,
  `mitra_id` int(11) DEFAULT NULL,
  `posisi` varchar(150) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `lokasi` varchar(150) DEFAULT NULL,
  `tipe` enum('Full Time','Part Time','Magang','Kontrak') DEFAULT 'Full Time',
  `jurusan` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `kualifikasi` text DEFAULT NULL,
  `link_daftar` varchar(255) DEFAULT NULL,
  `batas_akhir` date DEFAULT NULL,
  `status` enum('Buka','Tutup') DEFAULT 'Buka',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bkk_lowongan`
--

INSERT INTO `bkk_lowongan` (`id`, `mitra_id`, `posisi`, `gambar`, `lokasi`, `tipe`, `jurusan`, `deskripsi`, `kualifikasi`, `link_daftar`, `batas_akhir`, `status`, `created_at`) VALUES
(1, NULL, 'Bursa Lowongan Kerja', 'img_6abcdc0653d319.95036074.jpeg', 'Mall BTM Bogor, Lantai LG', 'Full Time', 'SMA/SMK/Sederajat / D3 & S1 Semua Jurusan', '•  Mencari, mencatat, dan menyebarkan informasi lowongan kerja kepada siswa dan alumni\r\n.\r\n• Penyaluran dan Penempatan: Menghubungkan pencari kerja dengan dunia usaha atau dunia industri (DUDI) yang membutuhkan tenaga kerja.\r\n\r\n• Bimbingan Karier: Memberikan penyuluhan jabatan, bimbingan penulisan CV, serta pelatihan keterampilan kerja dan wirausaha.\r\n\r\n• Pendataan (Tracer Study): Mendata keterserapan lulusan serta memperbarui database alumni secara berkala.', 'Diikuti oleh lebih dari 18 Perusahaan\r\n\r\nTerbuka untuk Lulusan SMK INFOKOM\r\n\r\nTERBUKA UNTUK UMUM (BEBAS DOMISILI & GRATIS REGISTRASI)\r\n\r\nSMA/SMK/Sederajat\r\n\r\nD3 & S1 Semua Jurusan', 'https://bit.ly/BursaLoker_SMK_Infokom2024', NULL, 'Buka', '2026-09-30 08:12:22'),
(2, NULL, 'Bursa Lowongan Kerja', 'img_6abcd8543859e7.46412908.jpeg', 'Mall BTM Bogor, Lantai LG', 'Full Time', 'SMA/SMK/Sederajat / D3 & S1 Semua Jurusan', '• Informasi Pasar Kerja (IPK): Mencari, mencatat, dan menyebarkan informasi lowongan kerja kepada siswa dan alumni.\r\n\r\n• Penyaluran dan Penempatan: Menghubungkan pencari kerja dengan dunia usaha atau dunia industri (DUDI) yang membutuhkan tenaga kerja.\r\n\r\n• Bimbingan Karier: Memberikan penyuluhan jabatan, bimbingan penulisan CV, serta pelatihan keterampilan kerja dan wirausaha.\r\n\r\n• Pendataan (Tracer Study): Mendata keterserapan lulusan serta memperbarui database alumni secara berkala.', 'Diikuti oleh lebih dari 18 Perusahaan\r\n\r\nTerbuka untuk Lulusan SMK INFOKOM\r\n\r\nTERBUKA UNTUK UMUM (BEBAS DOMISILI & GRATIS REGISTRASI)\r\n\r\nSMA/SMK/Sederajat\r\n\r\nD3 & S1 Semua Jurusan', 'https://bit.ly/BursaLoker_SMK_Infokom2024', NULL, 'Buka', '2026-09-30 08:28:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ekstrakurikuler`
--

CREATE TABLE `ekstrakurikuler` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `pembina` varchar(100) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `ekstrakurikuler`
--

INSERT INTO `ekstrakurikuler` (`id`, `nama`, `deskripsi`, `pembina`, `foto`) VALUES
(1, 'Pramuka', 'Ekstrakurikuler (ekskul) Pramuka adalah kegiatan pendidikan non-formal di sekolah yang wajib diikuti oleh peserta didik untuk membentuk karakter, disiplin, dan kemandirian.', '', 'img_6ad6cb3244dc31.72288864.jpeg'),
(3, 'Futsal', 'Ekstrakurikuler futsal adalah kegiatan di luar jam pelajaran sekolah yang mewadahi siswa untuk melatih keterampilan olahraga, membangun kerja sama tim, dan menjaga kebugaran fisik.', '', 'img_6abbbd3c71d9e2.02312136.jpg'),
(4, 'Basket', 'Ekstrakurikuler basket adalah kegiatan di luar jam pelajaran sekolah yang melatih keterampilan bermain bola basket, kebugaran fisik, serta kerja sama tim.', '', 'img_6ad6ca5aacf140.52443153.jpg'),
(5, 'Paskibra', 'Ekstrakurikuler Paskibra (Pasukan Pengibar Bendera) adalah kegiatan sekolah yang melatih siswa dalam baris-berbaris dan tata cara pengibaran bendera', '', 'img_6ad6ca64158051.00706473.jpg'),
(7, 'Badminton', 'Ekstrakurikuler (ekskul) badminton atau bulu tangkis adalah kegiatan di luar jam pelajaran sekolah yang mewadahi siswa untuk mengembangkan bakat, minat, dan keterampilan olahraga bulu tangkis.', '', 'img_6ad72f00b4a285.58298130.jpg'),
(8, 'Ekstrakurikuler Palang Merah Remaja (PMR)', 'Ekstrakurikuler Palang Merah Remaja (PMR) adalah kegiatan wadah pembinaan generasi muda dari Palang Merah Indonesia (PMI) di sekolah untuk mengembangkan nilai-nilai kemanusiaan dan keterampilan hidup sehat.', '', 'img_6ad7303f7a7f47.49226170.jpeg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `fasilitas`
--

CREATE TABLE `fasilitas` (
  `id` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `icon` varchar(50) DEFAULT 'building',
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `fasilitas`
--

INSERT INTO `fasilitas` (`id`, `nama`, `icon`, `deskripsi`, `gambar`) VALUES
(2, 'Musholla', '', NULL, '8e531d1887cfd06eafb29b2ee41794ec.jpg'),
(3, 'Perpustakaan', '', NULL, '37943e12901e4bb33cd759bb95eb4e9a.jpg'),
(4, 'Taman', '', NULL, 'a3022470dae94fd33fcc00cbefa26c00.jpg'),
(5, 'Ruang Kelas', '', NULL, 'af2a41b94d32a9b072d496999a355d77.jpg'),
(8, 'Laboratorium Komputer', '', NULL, '9fd0aa43b333af9c816ed2a220b04488.jpg'),
(9, 'Kantin', '', NULL, '426bf3a808e5f3a111587d4654cdd66e.jpg'),
(10, 'Ruang Guru', '', NULL, 'a466607fd0ae09526e7fb5de2c6ff108.jpg'),
(11, 'Ruang TU', '', NULL, '5b4157e6def5b717d1c8baefd85d408a.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `galeri`
--

CREATE TABLE `galeri` (
  `id` int(11) NOT NULL,
  `judul` varchar(150) NOT NULL,
  `kategori` varchar(100) DEFAULT 'Kegiatan',
  `gambar` varchar(255) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `galeri`
--

INSERT INTO `galeri` (`id`, `judul`, `kategori`, `gambar`, `tanggal`, `created_at`) VALUES
(2, 'Kegiatan Robotik', 'Akademik', 'img_6ad6ca3cc64848.81867124.jpg', '2026-09-30', '2026-09-29 11:33:23'),
(3, 'Apel Pramuka', 'Kegiatan', 'img_6ad6c94f198aa0.39430610.jpeg', '2026-09-30', '2026-09-29 11:33:23'),
(4, 'Sholat Duha', 'Kegiatan', 'img_6ad6c8663fc768.33433923.jpeg', '2026-09-30', '2026-09-29 11:33:23'),
(5, 'Kegiatan Upacara Bendera', 'Kegiatan', 'img_6ad6b9fbce2360.23005486.jpg', '2026-09-30', '2026-09-29 11:33:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru`
--

CREATE TABLE `guru` (
  `id` int(11) NOT NULL,
  `nip` varchar(30) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `mapel` varchar(100) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT 'Guru',
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('Aktif','Nonaktif') DEFAULT 'Aktif',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `guru`
--

INSERT INTO `guru` (`id`, `nip`, `nama`, `mapel`, `jabatan`, `foto`, `status`, `created_at`) VALUES
(1, 'G001', 'Ir. Hj. Liliek Rahmaningsih, M.M.Pd.', '', 'Kepala Sekolah', 'img_6ad748f770bee7.35176819.png', 'Aktif', '2026-10-20 17:07:58'),
(2, 'G002', 'Mila Yaelasari, M.Pd.', '', 'Wakil Kepala Sekolah Bidang Kurikulum', 'img_6ad7490c01f336.67059402.png', 'Aktif', '2026-10-20 17:07:58'),
(3, 'G003', 'Dea Rijalul Fikri, S.Kom., Gr.', '', 'Wakil Kepala Sekolah Bidang Kesiswaan', 'img_6ad748c445a534.80613117.png', 'Aktif', '2026-10-20 17:07:58'),
(4, 'G004', 'R. Radiani Srirestuti Dewi, SS., Gr.', '', 'Wakil Kepala Sekolah Bidang Hubungan Industri dan Masyarakat', 'img_6ad74920210092.36575933.png', 'Aktif', '2026-10-20 17:07:58'),
(5, 'G005', 'Heny Handayani, S.Pd.', '', 'Wakil Kepala Sekolah Bidang Pengembangan Sumber Daya Manusia', 'img_6ad748e72f38f7.39102994.png', 'Aktif', '2026-10-20 17:07:58'),
(6, 'G006', 'Agus Tiyono, M.Pd.', '', 'Wakil Kepala Sekolah Bidang Sarana dan Prasarana', 'img_6ad748b6e17076.84398112.png', 'Aktif', '2026-10-20 17:07:58'),
(7, 'G007', 'Aditya Nugraha, ST.', '', 'Kepala Program Keahlian Jurusan TKJ', 'img_6ad7492e8082d2.74417767.png', 'Aktif', '2026-10-20 17:07:58'),
(8, 'G008', 'Ridwan Hala, S.Kom., Gr.', '', 'Kepala Program Keahlian RPL', 'img_6ad74967309f11.01070703.png', 'Aktif', '2026-10-20 17:07:58'),
(9, 'G009', 'Muhammad Ibnu Arif, S.IKom.', '', 'Kepala Program Keahlian DKV', 'img_6ad7495331b5a3.68298906.png', 'Aktif', '2026-10-20 17:07:58'),
(10, 'G010', 'Erli Suherli, A.Md.Kom.', '', 'Kepala Program Keahlian PSPT', 'img_6ad74941c36849.61822025.png', 'Aktif', '2026-10-20 17:07:58'),
(11, 'G011', 'Aditya Nugraha, ST.', '', 'Ketua Manajemen Mutu', 'img_6ad749862682c3.23062374.png', 'Aktif', '2026-10-20 17:07:58'),
(12, 'G012', 'Cahyadi Rozi, ST.', '', 'Kepala Tata Usaha', 'img_6ad749a4bd28e0.17390431.png', 'Aktif', '2026-10-20 17:07:58'),
(13, 'G013', 'Drs. Puji Marhaen Waluyo', '', 'Kepala Perpustakaan', 'img_6ad74a086387f1.72729298.png', 'Aktif', '2026-10-20 17:07:58'),
(14, 'G014', 'Putri Riandini, S.Hut., M.Pd., Gr.', '', 'Kepala Bendahara', 'img_6ad74a64d209a6.87391774.png', 'Aktif', '2026-10-20 17:07:58'),
(15, 'G015', 'Ahmad Hotib, S.Pd.I', '', 'Pembina OSIS', 'img_6ad749969bad54.99517210.png', 'Aktif', '2026-10-20 17:07:58'),
(16, 'G016', 'Abdul Azis, M.Pd.', '', 'Pembina OSIS', 'img_6ad749778cc7a8.88880507.png', 'Aktif', '2026-10-20 17:07:58'),
(17, 'G017', 'Vera Yuni Astuti, SP., M.IKom., Gr.', '', 'Staf Kurikulum', 'img_6ad74abf7c8989.20785631.png', 'Aktif', '2026-10-20 17:07:58'),
(18, 'G018', 'M. Fauzan Arifin, S.IKom., Gr.', '', 'Staf Kurikulum', 'img_6ad74a41884cf8.43555558.png', 'Aktif', '2026-10-20 17:07:58'),
(19, 'G019', 'Dra. Popon Puspitasari', '', 'Guru Bimbingan & Konseling', 'img_6ad749f71ba826.98546107.png', 'Aktif', '2026-10-20 17:07:58'),
(20, 'G020', 'Richo Santana, S.Kom.', '', 'Guru Bimbingan & Konseling', 'img_6ad74a8a838f60.24155759.png', 'Aktif', '2026-10-20 17:07:58'),
(21, 'G021', 'Dian Hardianti, S.Kom., Gr.', '', 'Guru Bimbingan & Konseling', 'img_6ad749c69eb571.14870844.png', 'Aktif', '2026-10-20 17:07:58'),
(22, 'G022', 'Yeni Yuliawati, S.Pd., Gr.', '', 'Staf Teller (Bendahara)', 'img_6ad74ae7e3f433.39113575.png', 'Aktif', '2026-10-20 17:07:58'),
(23, 'G023', 'Rita Widyastuti', '', 'Staf Teller (Bendahara)', 'img_6ad74aa0330fe8.66690463.png', 'Aktif', '2026-10-20 17:07:58'),
(24, 'G024', 'Eva Farida Rahayu, S.Pd., Gr.', '', 'Staf Teller (Bendahara)', 'img_6ad74a27488923.11818464.png', 'Aktif', '2026-10-20 17:07:58'),
(25, 'G025', 'Jayadi, S.Pd., Gr.', '', 'Staf Tata Usaha', 'img_6ad74a348db323.93208126.png', 'Aktif', '2026-10-20 17:07:58'),
(26, 'G026', 'Yadi Setiadi, S.Sos., Gr.', '', 'Staf Tata Usaha', 'img_6ad74ada771841.78920714.png', 'Aktif', '2026-10-20 17:07:58'),
(27, 'G027', 'Siti Nuraeni', '', 'Staf Tata Usaha', 'img_6ad74ab03e6d54.86584157.png', 'Aktif', '2026-10-20 17:07:58'),
(28, 'G028', 'Reza Prafitriansyah, S.Kom., Gr.', '', 'Staf Perpustakaan', 'img_6ad74a79b9be83.72817820.png', 'Aktif', '2026-10-20 17:07:58'),
(29, 'G029', 'Dra. Diana Octaria', '', 'Guru', 'img_6ad749e6caf6d5.64706698.png', 'Aktif', '2026-10-20 17:07:58'),
(30, 'G030', 'Nabila Ahmadia Pratama, S.Pd.', '', 'Guru', 'img_6ad74a5118d630.24015943.png', 'Aktif', '2026-10-20 17:07:58'),
(31, 'G031', 'Erwin Hasiholan Gultom, S.Kom.', '', 'Guru', 'img_6ad74a1841ec60.58417949.png', 'Aktif', '2026-10-20 17:07:58'),
(32, 'G032', 'Widyatama Nuranisa, SM.', '', 'Guru', 'img_6ad74acd1a0fd1.75015668.png', 'Aktif', '2026-10-20 17:07:58'),
(33, 'G033', 'Dara Purwanita, S.Pd., Gr.', '', 'Guru', 'img_6ad749b72707b6.87574537.png', 'Aktif', '2026-10-20 17:07:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `magang_jepang`
--

CREATE TABLE `magang_jepang` (
  `id` int(11) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `konten` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT 'Umum',
  `urutan` int(11) DEFAULT 0,
  `status` enum('Aktif','Nonaktif') DEFAULT 'Aktif',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `magang_jepang`
--

INSERT INTO `magang_jepang` (`id`, `judul`, `konten`, `gambar`, `kategori`, `urutan`, `status`, `created_at`) VALUES
(1, 'Program Magang ke Jepang', 'Program magang ke Jepang di SMK Infokom Bogor (Yayasan Telekomunikasi Nasional) secara rutin memberangkatkan alumni (seperti Angkatan XVII dan XVIII) melalui kerja sama Bursa Kerja Khusus (BKK Infokom) dengan lembaga pelatihan kerja (LPK) mitra untuk meniti karier di dunia kerja global.', NULL, 'Umum', 2, 'Aktif', '2026-09-30 08:01:16'),
(2, 'Syarat & Ketentuan', '• Sosialisasi & Pendaftaran: Mengikuti informasi pembukaan rekrutmen melalui akun resmi SMK Infokom Kota Bogor atau BKK Infokom.\r\n• Pelatihan Bahasa & Budaya: Mengikuti pembelajaran bahasa Jepang serta persiapan fisik, mental, dan etos kerja.\r\n• Seleksi & Wawancara: Proses interview serta uji kompetensi dari pihak LPK atau perusahaan penerima dari Jepang.\r\n• Pemberangkatan: Setelah dinyatakan lulus seleksi dan dokumen visa magang terbit, peserta diberangkatkan ke Jepang.', NULL, 'Syarat', 3, 'Aktif', '2026-09-30 08:01:16'),
(3, 'Timeline & Tahapan', 'Tahapan Umum Program Magang Nasional\r\n\r\n1. Pendaftaran Mitra Penyelenggara & Lowongan: Perusahaan atau instansi mendaftarkan diri dan mengunggah posisi magang yang tersedia.\r\n2. Verifikasi & Penayangan Lowongan: Pihak penyelenggara (seperti Kemnaker) memeriksa kelayakan lowongan sebelum dipublikasikan ke publik.\r\n3. Pendaftaran Peserta: Calon peserta membuat akun, melengkapi profil (CV, portofolio), dan melamar ke lowongan yang diminati.\r\n4. Rekrutmen & Seleksi Internal Perusahaan: Perusahaan melakukan screening berkas, wawancara (interview), atau tes tertulis sesuai kebijakan masing-masing.\r\n5. Seleksi Akhir & Penetapan: Nama-nama peserta yang lolos rekrutmen diusulkan ke pusat untuk diverifikasi dan ditetapkan secara resmi.\r\n6. Pengumuman Kelolosan: Pengumuman resmi peserta yang diterima dan dapat diakses melalui portal resmi magang.\r\n7. Pelaksanaan Magang (Hari Pertama): Peserta mulai masuk kerja, menjalani orientasi, dan memulai masa magang (biasanya selama 6 bulan).', NULL, 'Timeline', 1, 'Aktif', '2026-09-30 08:01:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `magang_jepang_mitra`
--

CREATE TABLE `magang_jepang_mitra` (
  `id` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `bidang` varchar(150) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `urutan` int(11) DEFAULT 0,
  `status` enum('Aktif','Nonaktif') DEFAULT 'Aktif',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mitra`
--

CREATE TABLE `mitra` (
  `id` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `bidang` varchar(100) DEFAULT NULL,
  `jenis` varchar(50) DEFAULT 'PT',
  `kategori` varchar(50) DEFAULT 'Industri/DUDI',
  `deskripsi` text DEFAULT NULL,
  `lingkup` varchar(50) DEFAULT 'Dalam Negeri',
  `kerjasama` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `urutan` int(11) DEFAULT 0,
  `status` enum('Aktif','Nonaktif') DEFAULT 'Aktif',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `mitra`
--

INSERT INTO `mitra` (`id`, `nama`, `bidang`, `jenis`, `kategori`, `deskripsi`, `lingkup`, `kerjasama`, `website`, `logo`, `urutan`, `status`, `created_at`) VALUES
(1, 'by.U', 'by.U bergerak di bidang usaha telekomunikasi seluler prabayar digital. Layanan ini merupakan sebuah', 'PT', 'Industri/DUDI', 'by.U adalah merek layanan operator jaringan seluler prabayar digital pertama di Indonesia yang diluncurkan oleh PT Telekomunikasi Selular (Telkomsel) pada 10 Oktober 2019.', 'Dalam Negeri', 'Sekolah Unggul Bersama by.U atau gerakan SKULL.ID.', 'https://www.byu.id/', 'img_6ad6bd59b8ae24.01381669.jpg', 1, 'Aktif', '2026-09-30 08:35:49'),
(2, 'BONET | IT Solution Partner', 'Teknologi Informasi dan Komunikasi (ICT) serta penyedia solusi IT (IT Solution Partner).', 'PT', 'Industri/DUDI', 'PT Bonet Utama (BONET) adalah perusahaan penyedia solusi teknologi informasi dan komunikasi (ICT) serta layanan internet (Internet Service Provider / ISP) yang berbasis di Bogor, Jawa Barat.', 'Dalam Negeri', 'Pengembangan kompetensi vokasi dan dunia digital, seperti praktik kerja industri (prakerin/magang) bagi siswa.', 'https://bonet.co.id/', 'img_6ad6c048366cc0.90734424.jpg', 2, 'Aktif', '2026-09-30 08:41:02'),
(3, 'PT Bank Syariah Indonesia (Persero) Tbk (BSI)', 'Bank Umum Syariah', 'PT', 'Industri/DUDI', 'PT Bank Syariah Indonesia (Persero) Tbk (BSI) adalah bank syariah terbesar di Indonesia yang merupakan bagian dari Badan Usaha Milik Negara (BUMN).', 'Dalam Negeri', 'Digitalisasi Manajemen & Transaksi Keuangan Sekolah', 'https://www.bankbsi.co.id/', 'img_6ad6c181c6c985.87351925.jpg', 3, 'Aktif', '2026-10-20 08:18:57'),
(4, 'IPB University (Institut Pertanian Bogor)', 'PT Bogor Life Sciences and Technology (BLST) – Holding Company', 'Perguruan Tinggi', 'Perguruan Tinggi', 'IPB University (Institut Pertanian Bogor) adalah salah satu perguruan tinggi negeri (PTN) terkemuka di Indonesia yang berpusat di Kabupaten Bogor, Jawa Barat.', 'Dalam Negeri', 'Praktik Kerja Lapangan (PKL) / Magang Siswa', 'https://www.ipb.ac.id/', 'img_6ad6c2ce8b3967.18533070.png', 5, 'Aktif', '2026-10-20 08:24:30'),
(5, 'Jawa Pos', 'Media Cetak & Digital', 'PT', 'Industri/DUDI', 'Jawa Pos adalah salah satu perusahaan media massa dan konglomerasi media terbesar di Indonesia.', 'Dalam Negeri', 'Praktik Kerja Lapangan (PKL) / Magang Siswa', 'https://www.jawapos.com/page/about-us', 'img_6ad6c3f954f993.68468055.jpg', 4, 'Aktif', '2026-10-20 08:29:29'),
(6, 'Universitas Ibn Khaldun (UIKA) Bogor', 'Program Studi Terkait Bidang Usaha & Bisnis', 'PT', 'Perguruan Tinggi', 'Universitas Ibn Khaldun (UIKA) Bogor adalah salah satu perguruan tinggi Islam swasta tertua dan terbesar di Kota Bogor, Jawa Barat.', 'Dalam Negeri', 'Praktik Kerja Lapangan (PKL) / Magang Siswa', 'https://uika-bogor.ac.id/', 'img_6ad6c521952844.05811631.png', 6, 'Aktif', '2026-10-20 08:34:25'),
(7, 'Universitas Djuanda (UNIDA)', 'Bidang Kecantikan & Kesehatan (Wellness)', 'Perguruan Tinggi', 'Perguruan Tinggi', 'Universitas Djuanda (UNIDA) adalah perguruan tinggi swasta yang terletak di Ciawi, Kabupaten Bogor, Jawa Barat. Kampus ini dikenal dengan sebutan Kampus Bertauhid karena mengintegrasikan nilai-nilai keislaman dalam setiap aspek akademisnya.', 'Dalam Negeri', 'Kemitraan dengan Dunia Usaha dan Dunia Industri (DUDI)', 'https://www.unida.ac.id/', 'img_6ad6c63cbed992.00455017.png', 7, 'Aktif', '2026-10-20 08:39:08'),
(8, 'Universitas Pakuan (Unpak)', 'Pengembangan Kompetensi TI & Pengabdian Masyarakat', 'Perguruan Tinggi', 'Perguruan Tinggi', 'Universitas Pakuan (Unpak) adalah salah satu Perguruan Tinggi Swasta (PTS) ternama yang berlokasi di Kota Bogor, Jawa Barat. Kampus ini mengusung motto \"Unggul, Mandiri,', 'Dalam Negeri', 'Fasilitas Praktek Kerja Lapangan (PKL)', 'https://www.unpak.ac.id/', 'img_6ad6c6f7160513.82985118.png', 10, 'Aktif', '2026-10-20 08:42:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai`
--

CREATE TABLE `nilai` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `mapel` varchar(100) NOT NULL,
  `nilai` decimal(5,2) NOT NULL,
  `semester` varchar(20) NOT NULL,
  `tahun_ajaran` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id` int(11) NOT NULL,
  `nama_sekolah` varchar(150) DEFAULT 'SMK Infokom Kota Bogor',
  `alamat` varchar(255) DEFAULT 'Jl. Raya Pajajaran No. 120, Bogor',
  `telepon` varchar(50) DEFAULT '(0251) 837 6687',
  `email` varchar(100) DEFAULT 'info@smkinfokom.ach.id',
  `instagram` varchar(150) DEFAULT '#',
  `youtube` varchar(150) DEFAULT '#',
  `tiktok` varchar(150) DEFAULT '#',
  `facebook` varchar(150) DEFAULT '#',
  `maps_embed` text DEFAULT NULL,
  `jumlah_alumni` varchar(20) DEFAULT '1.250+',
  `logo` varchar(255) DEFAULT NULL,
  `hero_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pengaturan`
--

INSERT INTO `pengaturan` (`id`, `nama_sekolah`, `alamat`, `telepon`, `email`, `instagram`, `youtube`, `tiktok`, `facebook`, `maps_embed`, `jumlah_alumni`, `logo`, `hero_image`) VALUES
(1, 'SMK Infokom Kota Bogor', 'Jl. Letjen Ibrahim Adjie No.178, Kota Bogor', '(0251) 837 6687', 'info@smkinfokom.ach.id', '#', '#', '#', '#', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.5319096180706!2d106.76465207403044!3d-6.580599264326663!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c4f906e40827%3A0x6b93a4462670547c!2sSMK%20Infokom%20Kota%20Bogor!5e0!3m2!1sid!2sid!4v1790687087739!5m2!1sid!2sid\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"strict-origin-when-cross-origin\"></iframe>', '1.250+', 'img_6ad75610189838.06116437.png', 'img_6ad7553b050af6.98763516.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pkl_info`
--

CREATE TABLE `pkl_info` (
  `id` int(11) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `konten` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT 'Umum',
  `urutan` int(11) DEFAULT 0,
  `status` enum('Aktif','Nonaktif') DEFAULT 'Aktif',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pkl_info`
--

INSERT INTO `pkl_info` (`id`, `judul`, `konten`, `gambar`, `kategori`, `urutan`, `status`, `created_at`) VALUES
(1, 'Apa itu PKL?', 'PKL adalah singkatan dari Praktik Kerja Lapangan, yaitu suatu bentuk kegiatan pendidikan, pelatihan, dan pembelajaran yang dilakukan oleh siswa (terutama SMK) atau mahasiswa secara langsung di dunia kerja atau industri yang relevan.', NULL, 'Umum', 1, 'Aktif', '2026-09-30 08:01:16'),
(8, 'Alur Pendaftaran PKL', '1. Persiapan Berkas Administrasi.\r\n2. Kontak Awal / Pengajuan ke Instansi.\r\n3. Proses Seleksi atau Verifikasi.\r\n4. Konfirmasi dan Penerbitan Surat Balasan.\r\n5. Pelaksanaan PKL', NULL, 'Alur', 5, 'Aktif', '2026-10-20 16:22:49'),
(9, 'Praktik Kerja Lapangan (PKL)', '• Jurusan / Kompetensi Keahlian:\r\n	• Teknik Komputer dan Jaringan (TKJ)\r\n	• Rekayasa Perangkat Lunak (RPL)\r\n	• Desain Komunikasi Visual (DKV)\r\n	• Produksi dan Siaran Program Televisi (PSPT / Broadcasting)', NULL, 'Pengumuman', 2, 'Aktif', '2026-10-20 16:30:35'),
(10, 'Syarat Mengikuti PKL', '• Siswa Aktif Kelas XII (duabelas).\r\n• Lunas administrasi sekolah sesuai ketentuan berjalan.\r\n• Mendapat surat pengantar resmi dari pihak Hubinmas/sekolah.\r\n• Memilih tempat PKL yang relevan dengan jurusan (TKJ, RPL, DKV, atau Broadcasting).\r\n• Mentaati aturan tempat PKL serta menyusun Laporan PKL setelah selesai.', NULL, 'Syarat', 3, 'Aktif', '2026-10-20 16:33:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ppdb`
--

CREATE TABLE `ppdb` (
  `id` int(11) NOT NULL,
  `nama_lengkap` varchar(150) NOT NULL,
  `nisn` varchar(30) DEFAULT NULL,
  `asal_sekolah` varchar(150) DEFAULT NULL,
  `jurusan_pilihan` int(11) DEFAULT NULL,
  `no_hp` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status` enum('Menunggu','Diterima','Ditolak') DEFAULT 'Menunggu',
  `tanggal_daftar` datetime DEFAULT current_timestamp(),
  `no_pendaftaran` varchar(30) DEFAULT NULL,
  `token` varchar(64) DEFAULT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(20) DEFAULT NULL,
  `agama` varchar(30) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `kelurahan` varchar(100) DEFAULT NULL,
  `kecamatan` varchar(100) DEFAULT NULL,
  `kota` varchar(100) DEFAULT NULL,
  `kode_pos` varchar(10) DEFAULT NULL,
  `tahun_lulus` varchar(4) DEFAULT NULL,
  `nama_ayah` varchar(150) DEFAULT NULL,
  `pekerjaan_ayah` varchar(100) DEFAULT NULL,
  `nama_ibu` varchar(150) DEFAULT NULL,
  `pekerjaan_ibu` varchar(100) DEFAULT NULL,
  `no_hp_ortu` varchar(20) DEFAULT NULL,
  `jurusan_pilihan_2` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `ppdb`
--

INSERT INTO `ppdb` (`id`, `nama_lengkap`, `nisn`, `asal_sekolah`, `jurusan_pilihan`, `no_hp`, `email`, `status`, `tanggal_daftar`, `no_pendaftaran`, `token`, `nik`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `agama`, `alamat`, `kelurahan`, `kecamatan`, `kota`, `kode_pos`, `tahun_lulus`, `nama_ayah`, `pekerjaan_ayah`, `nama_ibu`, `pekerjaan_ibu`, `no_hp_ortu`, `jurusan_pilihan_2`) VALUES
(1, 'Rizyq Caesar Al Jabar', '0098765432', 'SMP PGRI 3 Bogor', 1, '082342798635', 'rizyqcaesaraljaba07@gmail.com', 'Menunggu', '2026-10-20 18:35:41', 'PPDB-2026-0001', 'ea4c64c2b7fdbeae0a83b38f64e0e354', '0098765432123456', 'Bogor', '2009-10-07', 'Laki-laki', 'Islam', 'Gunung Batu Jl Rante RT04/RW14 No Rumah 412', 'Gunung Batu', 'Bogor Barat', 'Kota Bogor', '16118', '2024', 'R. Kiki S', 'Buruh', 'Ria S', 'Ibu Rumah Tangga', '088213038680', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `prestasi`
--

CREATE TABLE `prestasi` (
  `id` int(11) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `tingkat` enum('Sekolah','Kota','Provinsi','Nasional','Internasional') DEFAULT 'Kota',
  `tanggal` date NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `prestasi`
--

INSERT INTO `prestasi` (`id`, `judul`, `kategori`, `tingkat`, `tanggal`, `deskripsi`, `gambar`, `created_at`) VALUES
(6, 'Juara 3 Futsal Piala Kemerdekaan', 'Prestasi', 'Sekolah', '2026-09-30', 'Juara 3 Futsal Piala Kemerdekaan', 'img_6ad72ceb441c86.92936319.jpeg', '2026-09-30 16:14:26'),
(7, 'Juara 1 E-Sport  KBOF 2026', 'Prestasi', 'Nasional', '2026-10-20', 'Juara 1 E-Sport  SMA/SMK TINGKAT NASIONAL KBOF 2026', 'img_6ad72db24b36e2.48403417.jpeg', '2026-10-20 16:00:34'),
(8, 'Juara 1 FDW 2026 Renascora', 'Prestasi', 'Sekolah', '2026-10-20', 'Juara 1 FDW 2026 Renascora', 'img_6ad72e07a0ce83.58721686.jpeg', '2026-10-20 16:01:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `program_keahlian`
--

CREATE TABLE `program_keahlian` (
  `id` int(11) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `icon` varchar(50) DEFAULT 'code',
  `foto` varchar(255) DEFAULT NULL,
  `urutan` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `program_keahlian`
--

INSERT INTO `program_keahlian` (`id`, `kode`, `nama`, `slug`, `deskripsi`, `icon`, `foto`, `urutan`) VALUES
(1, 'RPL', 'Rekayasa Perangkat Lunak (RPL)', 'rekayasa-perangkat-lunak-rpl', 'Mengembangkan aplikasi digital dan solusi perangkat lunak.', 'code', 'img_6abb47f916cf82.92336783.jpeg', 1),
(2, 'TKJ', 'Teknik Komputer dan Jaringan (TKJ)', 'teknik-komputer-dan-jaringan-tkj', 'Menguasai jaringan dan sistem komputer.', 'code', 'img_6abb4805a49841.82783438.jpeg', 2),
(3, 'PSPT', 'Produksi dan Siaran Program Televisi (PSPT)', 'produksi-dan-siaran-program-televisi-pspt', 'Belajar merancang dan membuat naskah, acara talk show, film pendek, dokumenter, hingga klip video.', 'image', 'img_6abb4863897ca9.85434064.jpeg', 3),
(4, 'DKV', 'Desain Komunikasi Visual (DKV)', 'desain-komunikasi-visual-dkv', 'Kreatif dalam desain, video, dan animasi.', 'image', 'img_6abb488a896dd2.65852713.jpeg', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas` varchar(20) NOT NULL,
  `jurusan_id` int(11) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT 'L',
  `tanggal_daftar` date NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('Aktif','Alumni','Nonaktif') DEFAULT 'Aktif',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id`, `nis`, `nama`, `kelas`, `jurusan_id`, `jenis_kelamin`, `tanggal_daftar`, `foto`, `status`, `created_at`) VALUES
(1, '231001', 'Ahmad Fauzi', 'XII RPL 1', NULL, 'L', '2025-07-12', NULL, 'Aktif', '2026-09-29 11:33:23'),
(2, '231002', 'Siti Nurhaliza', 'XII TKJ 2', NULL, 'L', '2025-07-05', NULL, 'Aktif', '2026-09-29 11:33:23'),
(3, '231003', 'Budi Santoso', 'XI MM 1', NULL, 'L', '2025-07-11', NULL, 'Aktif', '2026-09-29 11:33:23'),
(4, '231004', 'Rina Aprilia', 'XI TBD 1', NULL, 'L', '2025-07-11', NULL, 'Aktif', '2026-09-29 11:33:23'),
(5, '231005', 'Dika Pratama', 'X RPL 2', NULL, 'L', '2025-07-10', NULL, 'Aktif', '2026-09-29 11:33:23'),
(6, '497546547637', 'Rizyq Caesar Al Jabar', 'XII RPL 3', NULL, 'L', '2026-09-29', NULL, 'Aktif', '2026-09-29 11:38:31'),
(7, '988665454', 'M Raihan Ramadhan', 'XII RPL 3', NULL, 'L', '2026-09-29', NULL, 'Aktif', '2026-09-29 11:39:26'),
(8, '643768374862', 'Naufal M Nafis', 'XII RPL 3', NULL, 'L', '2026-09-29', NULL, 'Aktif', '2026-09-29 11:39:57'),
(9, '984857384387', 'M Rangga Revano', 'XII RPL 3', NULL, 'L', '2026-09-29', NULL, 'Aktif', '2026-09-29 11:40:29'),
(10, '2345678984', 'Vigoza Rinova', 'XII RPL 3', NULL, 'L', '2026-09-29', NULL, 'Aktif', '2026-09-29 11:41:22');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siswa_id` (`siswa_id`);

--
-- Indeks untuk tabel `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indeks untuk tabel `bkk_lowongan`
--
ALTER TABLE `bkk_lowongan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mitra_id` (`mitra_id`);

--
-- Indeks untuk tabel `ekstrakurikuler`
--
ALTER TABLE `ekstrakurikuler`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `fasilitas`
--
ALTER TABLE `fasilitas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`);

--
-- Indeks untuk tabel `magang_jepang`
--
ALTER TABLE `magang_jepang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `magang_jepang_mitra`
--
ALTER TABLE `magang_jepang_mitra`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mitra`
--
ALTER TABLE `mitra`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siswa_id` (`siswa_id`);

--
-- Indeks untuk tabel `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pkl_info`
--
ALTER TABLE `pkl_info`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ppdb`
--
ALTER TABLE `ppdb`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_ppdb_token` (`token`),
  ADD KEY `jurusan_pilihan` (`jurusan_pilihan`);

--
-- Indeks untuk tabel `prestasi`
--
ALTER TABLE `prestasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `program_keahlian`
--
ALTER TABLE `program_keahlian`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nis` (`nis`),
  ADD KEY `jurusan_id` (`jurusan_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `berita`
--
ALTER TABLE `berita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `bkk_lowongan`
--
ALTER TABLE `bkk_lowongan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `ekstrakurikuler`
--
ALTER TABLE `ekstrakurikuler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `fasilitas`
--
ALTER TABLE `fasilitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `guru`
--
ALTER TABLE `guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `magang_jepang`
--
ALTER TABLE `magang_jepang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `magang_jepang_mitra`
--
ALTER TABLE `magang_jepang_mitra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `mitra`
--
ALTER TABLE `mitra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengaturan`
--
ALTER TABLE `pengaturan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pkl_info`
--
ALTER TABLE `pkl_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `ppdb`
--
ALTER TABLE `ppdb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `prestasi`
--
ALTER TABLE `prestasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `program_keahlian`
--
ALTER TABLE `program_keahlian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `bkk_lowongan`
--
ALTER TABLE `bkk_lowongan`
  ADD CONSTRAINT `bkk_lowongan_ibfk_1` FOREIGN KEY (`mitra_id`) REFERENCES `mitra` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `nilai_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ppdb`
--
ALTER TABLE `ppdb`
  ADD CONSTRAINT `ppdb_ibfk_1` FOREIGN KEY (`jurusan_pilihan`) REFERENCES `program_keahlian` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`jurusan_id`) REFERENCES `program_keahlian` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
