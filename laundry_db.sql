-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Des 2025 pada 10.01
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
-- Database: `laundry_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `laporan_id` char(36) NOT NULL,
  `jenis_laporan` enum('harian','mingguan','bulanan','tahunan') NOT NULL,
  `periode_awal` date NOT NULL,
  `periode_akhir` date NOT NULL,
  `total_pesanan` int(11) NOT NULL DEFAULT 0,
  `total_pendapatan` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tanggal_generate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `layanan`
--

CREATE TABLE `layanan` (
  `layanan_id` bigint(20) UNSIGNED NOT NULL,
  `nama_layanan` varchar(255) NOT NULL,
  `jenis` enum('kiloan','satuan','express') NOT NULL,
  `harga_per_kg` decimal(10,2) DEFAULT NULL,
  `harga_satuan` decimal(10,2) DEFAULT NULL,
  `durasi_pengerjaan` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `status_aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `layanan`
--

INSERT INTO `layanan` (`layanan_id`, `nama_layanan`, `jenis`, `harga_per_kg`, `harga_satuan`, `durasi_pengerjaan`, `deskripsi`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 'Cuci Kering Kiloan', 'kiloan', 5000.00, NULL, 3, 'Layanan cuci dan kering pakaian per kilogram', 1, '2025-11-05 22:31:52', '2025-11-05 22:31:52'),
(2, 'Cuci Kering Setrika Kiloan', 'kiloan', 7000.00, NULL, 3, 'Layanan cuci, kering, dan setrika per kilogram', 1, '2025-11-05 22:31:52', '2025-11-05 22:31:52'),
(3, 'Cuci Setrika Express', 'express', 5000.00, NULL, 1, 'Layanan express selesai dalam 1 hari', 1, '2025-11-05 22:31:52', '2025-11-07 11:35:55'),
(4, 'Setrika Saja', 'kiloan', 3000.00, NULL, 2, 'Layanan setrika saja per kilogram', 1, '2025-11-05 22:31:52', '2025-11-05 22:31:52'),
(5, 'Cuci Sepatu', 'satuan', NULL, 25000.00, 3, 'Layanan cuci sepatu per pasang', 1, '2025-11-05 22:31:52', '2025-11-05 22:31:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_01_000009_create_notifikasi_table', 1),
(5, '2025_11_05_144201_create_layanans_table', 1),
(6, '2025_11_05_144202_create_pesanans_table', 1),
(7, '2025_11_05_144203_create_penjemputans_table', 1),
(8, '2025_11_05_144203_create_proses_table', 1),
(9, '2025_11_05_144204_create_pengantaran_table', 1),
(10, '2025_11_05_144205_create_pembayarans_table', 1),
(11, '2025_11_05_144212_create_laporans_table', 1),
(12, '2025_11_07_175404_create_pesan_table', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifikasi`
--

CREATE TABLE `notifikasi` (
  `notifikasi_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `pesan` text NOT NULL,
  `tipe` enum('info','success','warning','danger') NOT NULL DEFAULT 'info',
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `notifikasi`
--

INSERT INTO `notifikasi` (`notifikasi_id`, `user_id`, `judul`, `pesan`, `tipe`, `is_read`, `created_at`, `updated_at`) VALUES
('019a57c7-7c0d-73fd-8636-12bb9335e491', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'Pesanan Baru', 'Pesanan baru dari Siti Nurhaliza dengan kode AWN-B428A9E7', 'info', 0, '2025-11-05 23:08:02', '2025-11-05 23:08:02'),
('019a57ca-5e2d-73cb-9e53-5a0191eea864', '019a57a6-5d68-732b-9b7b-6009f5916b80', 'Status Pesanan Diperbarui', 'Status pesanan AWN-B428A9E7 menjadi: Dicuci', 'info', 0, '2025-11-05 23:11:11', '2025-11-05 23:11:11'),
('019a57ca-fc58-7285-94f5-cd654f172dc9', '019a57a6-5d68-732b-9b7b-6009f5916b80', 'Status Pesanan Diperbarui', 'Status pesanan AWN-B428A9E7 menjadi: Selesai', 'info', 0, '2025-11-05 23:11:52', '2025-11-05 23:11:52'),
('019a57e6-0d28-70de-b3a1-6972a4321dd9', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'Pesanan Baru', 'Pesanan baru dari Siti Nurhaliza dengan kode AWN-315C074A', 'info', 0, '2025-11-05 23:41:25', '2025-11-05 23:41:25'),
('019a57e6-0d29-729c-9412-9122151c91b7', '019a57cf-38ae-732d-bd5a-2e56576a1963', 'Pesanan Baru', 'Pesanan baru dari Siti Nurhaliza dengan kode AWN-315C074A', 'info', 0, '2025-11-05 23:41:25', '2025-11-05 23:41:25'),
('019a57e6-7932-73e3-92f5-05f68fa90046', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-315C074A perlu dikonfirmasi', 'info', 0, '2025-11-05 23:41:53', '2025-11-05 23:41:53'),
('019a57e6-7936-7347-b2fa-14edce3d9203', '019a57cf-38ae-732d-bd5a-2e56576a1963', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-315C074A perlu dikonfirmasi', 'info', 0, '2025-11-05 23:41:53', '2025-11-05 23:41:53'),
('019a57e7-15c1-70bd-aed8-6d6a8e9639d2', '019a57a6-5d68-732b-9b7b-6009f5916b80', 'Status Pesanan Diperbarui', 'Status pesanan AWN-315C074A menjadi: Dicuci', 'info', 0, '2025-11-05 23:42:33', '2025-11-05 23:42:33'),
('019a57e7-5537-724d-9a7e-415e0d47b151', '019a57a6-5d68-732b-9b7b-6009f5916b80', 'Status Pesanan Diperbarui', 'Status pesanan AWN-315C074A menjadi: Dikemas', 'info', 0, '2025-11-05 23:42:49', '2025-11-05 23:42:49'),
('019a57e7-736e-7183-b6d2-3ebae0413346', '019a57a6-5d68-732b-9b7b-6009f5916b80', 'Status Pesanan Diperbarui', 'Status pesanan AWN-315C074A menjadi: Selesai', 'info', 0, '2025-11-05 23:42:57', '2025-11-05 23:42:57'),
('019a57e8-3739-7131-a4a3-c92506e92295', '019a57a6-5d68-732b-9b7b-6009f5916b80', 'Kurir Dalam Perjalanan', 'Kurir sedang menuju lokasi Anda untuk menjemput cucian. Pesanan: AWN-315C074A', 'info', 0, '2025-11-05 23:43:47', '2025-11-05 23:43:47'),
('019a57e8-8a68-7132-a8ca-2507927cc386', '019a57a6-5d68-732b-9b7b-6009f5916b80', 'Cucian Berhasil Dijemput', 'Cucian Anda telah dijemput. Pesanan: AWN-315C074A', 'success', 0, '2025-11-05 23:44:08', '2025-11-05 23:44:08'),
('019a57e8-8a6b-71bf-b6e5-a80b2ac51b5e', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'Cucian Tiba', 'Cucian pesanan AWN-315C074A telah tiba. Silakan timbang.', 'info', 0, '2025-11-05 23:44:08', '2025-11-05 23:44:08'),
('019a57e8-8a6c-73b6-9873-a99a86366b74', '019a57cf-38ae-732d-bd5a-2e56576a1963', 'Cucian Tiba', 'Cucian pesanan AWN-315C074A telah tiba. Silakan timbang.', 'info', 0, '2025-11-05 23:44:08', '2025-11-05 23:44:08'),
('019a5960-c1ed-72a3-a8fa-ff386f601378', '019a57a6-5d68-732b-9b7b-6009f5916b80', 'Cucian Ditimbang', 'Cucian Anda telah ditimbang. Berat: 3 kg, Total: Rp 15.000', 'info', 0, '2025-11-06 06:35:04', '2025-11-06 06:35:04'),
('019a5961-0792-7080-9a11-35c8e2091048', '019a57a6-5d68-732b-9b7b-6009f5916b80', 'Status Pesanan Diperbarui', 'Status pesanan AWN-315C074A menjadi: Dikemas', 'info', 0, '2025-11-06 06:35:22', '2025-11-06 06:35:22'),
('019a5962-7c0e-7255-b9e0-294a74ad0efd', '019a57a6-5d68-732b-9b7b-6009f5916b80', 'Kurir Dalam Perjalanan', 'Kurir sedang menuju lokasi Anda untuk menjemput cucian. Pesanan: AWN-B428A9E7', 'info', 0, '2025-11-06 06:36:57', '2025-11-06 06:36:57'),
('019a5963-6aba-73a6-9f78-0f0a617b45e8', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'Pesanan Baru', 'Pesanan baru dari Rama dengan kode AWN-4B6EBA76', 'info', 0, '2025-11-06 06:37:58', '2025-11-06 06:37:58'),
('019a5963-6abc-73ea-af89-14594fdaa53c', '019a57cf-38ae-732d-bd5a-2e56576a1963', 'Pesanan Baru', 'Pesanan baru dari Rama dengan kode AWN-4B6EBA76', 'info', 0, '2025-11-06 06:37:58', '2025-11-06 06:37:58'),
('019a5963-f7cc-731b-9bb8-2091709c294a', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-4B6EBA76 perlu dikonfirmasi', 'info', 0, '2025-11-06 06:38:35', '2025-11-06 06:38:35'),
('019a5963-f7cd-730d-878f-31e2b6296dcb', '019a57cf-38ae-732d-bd5a-2e56576a1963', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-4B6EBA76 perlu dikonfirmasi', 'info', 0, '2025-11-06 06:38:35', '2025-11-06 06:38:35'),
('019a5964-79a7-73f8-b205-de5bc0fb24e6', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Cucian Ditimbang', 'Cucian Anda telah ditimbang. Berat: 8 kg, Total: Rp 56.000', 'info', 0, '2025-11-06 06:39:08', '2025-11-06 06:39:08'),
('019a5964-8d6a-7254-9039-f6d3520a7b6d', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Status Pesanan Diperbarui', 'Status pesanan AWN-4B6EBA76 menjadi: Siap antar', 'info', 0, '2025-11-06 06:39:13', '2025-11-06 06:39:13'),
('019a597a-c48f-736d-b16d-d98d588d9206', '019a57a6-5d68-732b-9b7b-6009f5916b80', 'Cucian Berhasil Dijemput', 'Cucian Anda telah dijemput. Pesanan: AWN-B428A9E7', 'success', 0, '2025-11-06 07:03:29', '2025-11-06 07:03:29'),
('019a597a-c490-737f-b125-dab34c9ecb7c', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'Cucian Tiba', 'Cucian pesanan AWN-B428A9E7 telah tiba. Silakan timbang.', 'info', 0, '2025-11-06 07:03:29', '2025-11-06 07:03:29'),
('019a597a-c491-7371-a6a3-5e24731d1e49', '019a57cf-38ae-732d-bd5a-2e56576a1963', 'Cucian Tiba', 'Cucian pesanan AWN-B428A9E7 telah tiba. Silakan timbang.', 'info', 0, '2025-11-06 07:03:29', '2025-11-06 07:03:29'),
('019a597a-c491-7371-a6a3-5e2473b48087', '019a5971-f9a6-70a9-9f90-50807bb4435c', 'Cucian Tiba', 'Cucian pesanan AWN-B428A9E7 telah tiba. Silakan timbang.', 'info', 0, '2025-11-06 07:03:29', '2025-11-06 07:03:29'),
('019a597e-8807-72f1-a204-a764e903bb4a', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Status Pesanan Diperbarui', 'Status pesanan AWN-4B6EBA76 menjadi: Selesai', 'info', 0, '2025-11-06 07:07:35', '2025-11-06 07:07:35'),
('019a597e-b54c-7335-8ea5-d3cdb3424528', '019a57a6-5d68-732b-9b7b-6009f5916b80', 'Status Pesanan Diperbarui', 'Status pesanan AWN-315C074A menjadi: Selesai', 'info', 0, '2025-11-06 07:07:47', '2025-11-06 07:07:47'),
('019a597e-d44b-73aa-9a0c-dc37fed5d524', '019a57a6-5d68-732b-9b7b-6009f5916b80', 'Cucian Ditimbang', 'Cucian Anda telah ditimbang. Berat: 1 kg, Total: Rp 25.000', 'info', 0, '2025-11-06 07:07:55', '2025-11-06 07:07:55'),
('019a597e-e096-70b3-9a64-90d6a3ed0306', '019a57a6-5d68-732b-9b7b-6009f5916b80', 'Status Pesanan Diperbarui', 'Status pesanan AWN-B428A9E7 menjadi: Selesai', 'info', 0, '2025-11-06 07:07:58', '2025-11-06 07:07:58'),
('019a5f66-1039-73e4-b1bb-8824c5c3e5ba', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'Pesanan Baru', 'Pesanan baru dari uuf dengan kode AWN-E9BAB1CE', 'info', 0, '2025-11-07 10:38:35', '2025-11-07 10:38:35'),
('019a5f66-103a-70ee-b97d-e0793682f097', '019a57cf-38ae-732d-bd5a-2e56576a1963', 'Pesanan Baru', 'Pesanan baru dari uuf dengan kode AWN-E9BAB1CE', 'info', 0, '2025-11-07 10:38:35', '2025-11-07 10:38:35'),
('019a5f66-103b-73e4-8e7f-3247c0c0b945', '019a5971-f9a6-70a9-9f90-50807bb4435c', 'Pesanan Baru', 'Pesanan baru dari uuf dengan kode AWN-E9BAB1CE', 'info', 0, '2025-11-07 10:38:35', '2025-11-07 10:38:35'),
('019a5f66-4ab4-7283-be54-ccde3429ca28', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-E9BAB1CE perlu dikonfirmasi', 'info', 0, '2025-11-07 10:38:50', '2025-11-07 10:38:50'),
('019a5f66-4ab4-7283-be54-ccde34830b56', '019a57cf-38ae-732d-bd5a-2e56576a1963', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-E9BAB1CE perlu dikonfirmasi', 'info', 0, '2025-11-07 10:38:50', '2025-11-07 10:38:50'),
('019a5f66-4ab5-732f-b898-317597c42e87', '019a5971-f9a6-70a9-9f90-50807bb4435c', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-E9BAB1CE perlu dikonfirmasi', 'info', 0, '2025-11-07 10:38:50', '2025-11-07 10:38:50'),
('019a5f66-dedb-71e3-8837-e65570d5a6c9', '019a57eb-ddc0-7174-9e44-e84158a2ad03', 'Cucian Ditimbang', 'Cucian Anda telah ditimbang. Berat: 2 kg, Total: Rp 10.000', 'info', 0, '2025-11-07 10:39:28', '2025-11-07 10:39:28'),
('019a5f66-f179-7348-8e81-3eb60975438e', '019a57eb-ddc0-7174-9e44-e84158a2ad03', 'Status Pesanan Diperbarui', 'Status pesanan AWN-E9BAB1CE menjadi: Dikeringkan', 'info', 0, '2025-11-07 10:39:33', '2025-11-07 10:39:33'),
('019a5f67-0d45-7185-96d4-6a6e81b1df65', '019a57eb-ddc0-7174-9e44-e84158a2ad03', 'Status Pesanan Diperbarui', 'Status pesanan AWN-E9BAB1CE menjadi: Siap antar', 'info', 0, '2025-11-07 10:39:40', '2025-11-07 10:39:40'),
('019a5f68-25a0-704f-aca5-d9bcb3b7e23e', '019a57eb-ddc0-7174-9e44-e84158a2ad03', 'Status Pesanan Diperbarui', 'Status pesanan AWN-E9BAB1CE menjadi: Selesai', 'info', 0, '2025-11-07 10:40:52', '2025-11-07 10:40:52'),
('019a5f6b-ff5b-737e-bc41-6f23ead32d01', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'Pesanan Baru', 'Pesanan baru dari uuf dengan kode AWN-02081706', 'info', 0, '2025-11-07 10:45:04', '2025-11-07 10:45:04'),
('019a5f6b-ff5c-7126-a68f-103dd90f6ff9', '019a57cf-38ae-732d-bd5a-2e56576a1963', 'Pesanan Baru', 'Pesanan baru dari uuf dengan kode AWN-02081706', 'info', 0, '2025-11-07 10:45:04', '2025-11-07 10:45:04'),
('019a5f6b-ff5c-7126-a68f-103dd97d314a', '019a5971-f9a6-70a9-9f90-50807bb4435c', 'Pesanan Baru', 'Pesanan baru dari uuf dengan kode AWN-02081706', 'info', 0, '2025-11-07 10:45:04', '2025-11-07 10:45:04'),
('019a5f6c-1d44-7282-957d-1082a80c1cf4', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-02081706 perlu dikonfirmasi', 'info', 0, '2025-11-07 10:45:12', '2025-11-07 10:45:12'),
('019a5f6c-1d45-73ce-8693-c4e1e395091a', '019a57cf-38ae-732d-bd5a-2e56576a1963', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-02081706 perlu dikonfirmasi', 'info', 0, '2025-11-07 10:45:12', '2025-11-07 10:45:12'),
('019a5f6c-1d46-71db-bc9d-6cf331e16bfd', '019a5971-f9a6-70a9-9f90-50807bb4435c', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-02081706 perlu dikonfirmasi', 'info', 0, '2025-11-07 10:45:12', '2025-11-07 10:45:12'),
('019a5f6c-a4c8-710b-a35b-16b18a565308', '019a57eb-ddc0-7174-9e44-e84158a2ad03', 'Cucian Ditimbang', 'Cucian Anda telah ditimbang. Berat: 4 kg, Total: Rp 28.000', 'info', 0, '2025-11-07 10:45:46', '2025-11-07 10:45:46'),
('019a5f6c-eb96-70ae-93be-096ccc583f28', '019a57eb-ddc0-7174-9e44-e84158a2ad03', 'Status Pesanan Diperbarui', 'Status pesanan AWN-02081706 menjadi: Dikemas', 'info', 0, '2025-11-07 10:46:05', '2025-11-07 10:46:05'),
('019a5f6c-f842-713b-85c3-ca13c5a4a40d', '019a57eb-ddc0-7174-9e44-e84158a2ad03', 'Status Pesanan Diperbarui', 'Status pesanan AWN-02081706 menjadi: Siap antar', 'info', 0, '2025-11-07 10:46:08', '2025-11-07 10:46:08'),
('019a5f80-c085-73bf-b871-08456c88ee94', '019a57eb-ddc0-7174-9e44-e84158a2ad03', 'Cucian Sedang Diantar', 'Kurir sedang mengantar cucian Anda. Pesanan: AWN-02081706', 'info', 0, '2025-11-07 11:07:44', '2025-11-07 11:07:44'),
('019a5f87-a721-704b-9517-269e603e675f', '019a57eb-ddc0-7174-9e44-e84158a2ad03', 'Pesan Baru dari Kurir', 'Anda mendapat pesan baru untuk pesanan AWN-02081706', 'info', 0, '2025-11-07 11:15:17', '2025-11-07 11:15:17'),
('019a5f88-2e3f-7021-a269-efaa5abf85f9', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'Pesan Baru dari Pelanggan', 'Anda mendapat pesan baru untuk pesanan AWN-02081706', 'info', 0, '2025-11-07 11:15:51', '2025-11-07 11:15:51'),
('019a5f88-b86b-71aa-9ac7-a75d07c908be', '019a57eb-ddc0-7174-9e44-e84158a2ad03', 'Pesanan Selesai', 'Cucian Anda telah diantar. Terima kasih telah menggunakan layanan Awan Laundry!', 'success', 0, '2025-11-07 11:16:26', '2025-11-07 11:16:26'),
('019a5f95-fb73-72cb-bc8f-f2fea64a9602', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'Pesanan Baru', 'Pesanan baru dari Rama dengan kode AWN-AE01A534', 'info', 0, '2025-11-07 11:30:56', '2025-11-07 11:30:56'),
('019a5f95-fb74-72b0-be8f-489c7fdc40d9', '019a57cf-38ae-732d-bd5a-2e56576a1963', 'Pesanan Baru', 'Pesanan baru dari Rama dengan kode AWN-AE01A534', 'info', 0, '2025-11-07 11:30:56', '2025-11-07 11:30:56'),
('019a5f95-fb74-72b0-be8f-489c8059951d', '019a5971-f9a6-70a9-9f90-50807bb4435c', 'Pesanan Baru', 'Pesanan baru dari Rama dengan kode AWN-AE01A534', 'info', 0, '2025-11-07 11:30:56', '2025-11-07 11:30:56'),
('019a5f96-2146-7254-b930-6a392e56b8b1', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-AE01A534 perlu dikonfirmasi', 'info', 0, '2025-11-07 11:31:05', '2025-11-07 11:31:05'),
('019a5f96-2146-7254-b930-6a392f24e116', '019a57cf-38ae-732d-bd5a-2e56576a1963', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-AE01A534 perlu dikonfirmasi', 'info', 0, '2025-11-07 11:31:05', '2025-11-07 11:31:05'),
('019a5f96-2147-7254-b613-d6d6571f3ac2', '019a5971-f9a6-70a9-9f90-50807bb4435c', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-AE01A534 perlu dikonfirmasi', 'info', 0, '2025-11-07 11:31:05', '2025-11-07 11:31:05'),
('019a5f96-8411-71ff-8e68-b2463c963948', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Cucian Ditimbang', 'Cucian Anda telah ditimbang. Berat: 5 kg, Total: Rp 35.000', 'info', 0, '2025-11-07 11:31:31', '2025-11-07 11:31:31'),
('019a5f96-8c79-72f7-b9da-b9226d9e8c34', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Status Pesanan Diperbarui', 'Status pesanan AWN-AE01A534 menjadi: Dicuci', 'info', 0, '2025-11-07 11:31:33', '2025-11-07 11:31:33'),
('019a5f96-f361-7039-a152-225381a4d717', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Status Pesanan Diperbarui', 'Status pesanan AWN-AE01A534 menjadi: Dikeringkan', 'info', 0, '2025-11-07 11:31:59', '2025-11-07 11:31:59'),
('019a5f97-1269-727d-b0bb-078d5ee3fdae', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Status Pesanan Diperbarui', 'Status pesanan AWN-AE01A534 menjadi: Dikemas', 'info', 0, '2025-11-07 11:32:07', '2025-11-07 11:32:07'),
('019a5f97-3201-7057-887e-1b2f8f0c4fb5', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'Pengantaran Baru', 'Pesanan AWN-AE01A534 siap untuk diantar', 'info', 0, '2025-11-07 11:32:15', '2025-11-07 11:32:15'),
('019a5f97-3202-7195-9aaa-96f77d77cdd0', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Status Pesanan Diperbarui', 'Status pesanan AWN-AE01A534 menjadi: Siap antar', 'info', 0, '2025-11-07 11:32:15', '2025-11-07 11:32:15'),
('019a5f97-dca7-7154-9ce4-4e8a151ee88a', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Cucian Sedang Diantar', 'Kurir sedang mengantar cucian Anda. Pesanan: AWN-AE01A534', 'info', 0, '2025-11-07 11:32:59', '2025-11-07 11:32:59'),
('019a5f98-30dd-7041-b7e5-dfe30f870b7d', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Pesan Baru dari Kurir', 'Anda mendapat pesan baru untuk pesanan AWN-AE01A534', 'info', 0, '2025-11-07 11:33:20', '2025-11-07 11:33:20'),
('019a5f98-b91c-7185-bb7b-48fca7506dd1', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'Pesan Baru dari Pelanggan', 'Anda mendapat pesan baru untuk pesanan AWN-AE01A534', 'info', 0, '2025-11-07 11:33:55', '2025-11-07 11:33:55'),
('019a5f99-747e-73db-8aaa-1dce90830e66', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Pesanan Selesai', 'Cucian Anda telah diantar. Terima kasih telah menggunakan layanan Awan Laundry!', 'success', 0, '2025-11-07 11:34:43', '2025-11-07 11:34:43'),
('019a624a-b5e2-70ec-8243-9f1357146045', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'Pesanan Baru', 'Pesanan baru dari Rama dengan kode AWN-C36A34D7', 'info', 0, '2025-11-08 00:07:34', '2025-11-08 00:07:34'),
('019a624a-b5e3-7286-82a2-abce8fd170e8', '019a57cf-38ae-732d-bd5a-2e56576a1963', 'Pesanan Baru', 'Pesanan baru dari Rama dengan kode AWN-C36A34D7', 'info', 0, '2025-11-08 00:07:34', '2025-11-08 00:07:34'),
('019a624a-b5e4-716a-a8d0-63977aa7f837', '019a5971-f9a6-70a9-9f90-50807bb4435c', 'Pesanan Baru', 'Pesanan baru dari Rama dengan kode AWN-C36A34D7', 'info', 0, '2025-11-08 00:07:34', '2025-11-08 00:07:34'),
('019a624a-f34c-7019-bb89-930c3561ec6d', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-C36A34D7 perlu dikonfirmasi', 'info', 0, '2025-11-08 00:07:50', '2025-11-08 00:07:50'),
('019a624a-f34e-7285-9a76-cc659c993fc8', '019a57cf-38ae-732d-bd5a-2e56576a1963', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-C36A34D7 perlu dikonfirmasi', 'info', 0, '2025-11-08 00:07:50', '2025-11-08 00:07:50'),
('019a624a-f34f-7357-b338-db83f0852488', '019a5971-f9a6-70a9-9f90-50807bb4435c', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-C36A34D7 perlu dikonfirmasi', 'info', 0, '2025-11-08 00:07:50', '2025-11-08 00:07:50'),
('019a624b-7176-735c-9dd0-dec653883811', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Cucian Ditimbang', 'Cucian Anda telah ditimbang. Berat: 3 kg, Total: Rp 21.000', 'info', 0, '2025-11-08 00:08:22', '2025-11-08 00:08:22'),
('019a624b-cdae-71de-a325-9c11a2697a57', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'Pengantaran Baru', 'Pesanan AWN-C36A34D7 siap untuk diantar', 'info', 0, '2025-11-08 00:08:46', '2025-11-08 00:08:46'),
('019a624b-cdaf-7397-b106-d1119a7f1ea6', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Status Pesanan Diperbarui', 'Status pesanan AWN-C36A34D7 menjadi: Siap antar', 'info', 0, '2025-11-08 00:08:46', '2025-11-08 00:08:46'),
('019a624e-0a2f-724f-92b1-800c42e59126', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Pesan Baru dari Kurir', 'Anda mendapat pesan baru untuk pesanan AWN-C36A34D7', 'info', 0, '2025-11-08 00:11:12', '2025-11-08 00:11:12'),
('019a624f-3603-7324-8879-9310b51a0660', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Cucian Sedang Diantar', 'Kurir sedang mengantar cucian Anda. Pesanan: AWN-C36A34D7', 'info', 0, '2025-11-08 00:12:29', '2025-11-08 00:12:29'),
('019a624f-c0a1-7109-8206-52745823e022', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'Pesan Baru dari Pelanggan', 'Anda mendapat pesan baru untuk pesanan AWN-C36A34D7', 'info', 0, '2025-11-08 00:13:05', '2025-11-08 00:13:05'),
('019a6250-6d0d-73ce-9c92-cfb1fbeaae47', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Pesanan Selesai', 'Cucian Anda telah diantar. Terima kasih telah menggunakan layanan Awan Laundry!', 'success', 0, '2025-11-08 00:13:49', '2025-11-08 00:13:49'),
('019a76ea-6380-7114-ad10-bb904d58ddbd', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'Pesanan Baru', 'Pesanan baru dari Rama dengan kode AWN-3CFA2354', 'info', 0, '2025-11-12 00:14:23', '2025-11-12 00:14:23'),
('019a76ea-6381-7210-89c1-91ba47d19fae', '019a57cf-38ae-732d-bd5a-2e56576a1963', 'Pesanan Baru', 'Pesanan baru dari Rama dengan kode AWN-3CFA2354', 'info', 0, '2025-11-12 00:14:23', '2025-11-12 00:14:23'),
('019a76ea-6382-733e-9d89-a69501267fdc', '019a5971-f9a6-70a9-9f90-50807bb4435c', 'Pesanan Baru', 'Pesanan baru dari Rama dengan kode AWN-3CFA2354', 'info', 0, '2025-11-12 00:14:23', '2025-11-12 00:14:23'),
('019a76ea-e1c7-7033-847d-7e9ca047e812', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-3CFA2354 perlu dikonfirmasi', 'info', 0, '2025-11-12 00:14:56', '2025-11-12 00:14:56'),
('019a76ea-e1cb-7085-ba78-67460bb569f1', '019a57cf-38ae-732d-bd5a-2e56576a1963', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-3CFA2354 perlu dikonfirmasi', 'info', 0, '2025-11-12 00:14:56', '2025-11-12 00:14:56'),
('019a76ea-e1cc-710a-bd00-09ea62966f35', '019a5971-f9a6-70a9-9f90-50807bb4435c', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-3CFA2354 perlu dikonfirmasi', 'info', 0, '2025-11-12 00:14:56', '2025-11-12 00:14:56'),
('019a76ed-a63f-73ad-be6e-b12d5f434757', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Cucian Ditimbang', 'Cucian Anda telah ditimbang. Berat: 7 kg, Total: Rp 49.000', 'info', 0, '2025-11-12 00:17:57', '2025-11-12 00:17:57'),
('019a76ef-0a49-70b5-8a26-38170a4183c2', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'Pengantaran Baru', 'Pesanan AWN-3CFA2354 siap untuk diantar', 'info', 0, '2025-11-12 00:19:28', '2025-11-12 00:19:28'),
('019a76ef-0a49-70b5-8a26-38170a670b02', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Status Pesanan Diperbarui', 'Status pesanan AWN-3CFA2354 menjadi: Siap antar', 'info', 0, '2025-11-12 00:19:28', '2025-11-12 00:19:28'),
('019a76ef-fd06-7061-ac02-bd9d86d9183b', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Pesan Baru dari Kurir', 'Anda mendapat pesan baru untuk pesanan AWN-3CFA2354', 'info', 0, '2025-11-12 00:20:30', '2025-11-12 00:20:30'),
('019a76f0-52cf-711f-afb3-0ff8ad8a1d22', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Cucian Sedang Diantar', 'Kurir sedang mengantar cucian Anda. Pesanan: AWN-3CFA2354', 'info', 0, '2025-11-12 00:20:52', '2025-11-12 00:20:52'),
('019a76f0-8d24-7290-8bb6-e1b8fd034a14', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'Pesan Baru dari Pelanggan', 'Anda mendapat pesan baru untuk pesanan AWN-3CFA2354', 'info', 0, '2025-11-12 00:21:07', '2025-11-12 00:21:07'),
('019a76f0-cd05-7004-93eb-59b8af53c609', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Pesanan Selesai', 'Cucian Anda telah diantar. Terima kasih telah menggunakan layanan Awan Laundry!', 'success', 0, '2025-11-12 00:21:23', '2025-11-12 00:21:23'),
('019a7713-f107-7256-9ce9-409ef89d791e', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'Pesanan Baru', 'Pesanan baru dari Rama dengan kode AWN-E72DC004', 'info', 0, '2025-11-12 00:59:46', '2025-11-12 00:59:46'),
('019a7713-f107-7256-9ce9-409ef94d8c34', '019a57cf-38ae-732d-bd5a-2e56576a1963', 'Pesanan Baru', 'Pesanan baru dari Rama dengan kode AWN-E72DC004', 'info', 0, '2025-11-12 00:59:46', '2025-11-12 00:59:46'),
('019a7713-f108-7263-a7a2-58ff143aafa6', '019a5971-f9a6-70a9-9f90-50807bb4435c', 'Pesanan Baru', 'Pesanan baru dari Rama dengan kode AWN-E72DC004', 'info', 0, '2025-11-12 00:59:46', '2025-11-12 00:59:46'),
('019a7714-4221-732a-a2c8-a5c31e474ff2', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-E72DC004 perlu dikonfirmasi', 'info', 0, '2025-11-12 01:00:07', '2025-11-12 01:00:07'),
('019a7714-4222-700e-96c7-fd04b6041521', '019a57cf-38ae-732d-bd5a-2e56576a1963', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-E72DC004 perlu dikonfirmasi', 'info', 0, '2025-11-12 01:00:07', '2025-11-12 01:00:07'),
('019a7714-4223-728a-9893-ea9451a00a4c', '019a5971-f9a6-70a9-9f90-50807bb4435c', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-E72DC004 perlu dikonfirmasi', 'info', 0, '2025-11-12 01:00:07', '2025-11-12 01:00:07'),
('019a7715-3d9e-715f-96bb-2db1fc35faf6', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Kurir Dalam Perjalanan', 'Kurir sedang menuju lokasi Anda untuk menjemput cucian. Pesanan: AWN-E72DC004', 'info', 0, '2025-11-12 01:01:12', '2025-11-12 01:01:12'),
('019a7716-5334-712b-a6a9-64dad8759add', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Cucian Berhasil Dijemput', 'Cucian Anda telah dijemput. Pesanan: AWN-E72DC004', 'success', 0, '2025-11-12 01:02:23', '2025-11-12 01:02:23'),
('019a7716-5335-73bd-9ad6-9bf6a7745970', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'Cucian Tiba', 'Cucian pesanan AWN-E72DC004 telah tiba. Silakan timbang.', 'info', 0, '2025-11-12 01:02:23', '2025-11-12 01:02:23'),
('019a7716-5335-73bd-9ad6-9bf6a79a37b7', '019a57cf-38ae-732d-bd5a-2e56576a1963', 'Cucian Tiba', 'Cucian pesanan AWN-E72DC004 telah tiba. Silakan timbang.', 'info', 0, '2025-11-12 01:02:23', '2025-11-12 01:02:23'),
('019a7716-5336-7181-b238-7510232e5b1f', '019a5971-f9a6-70a9-9f90-50807bb4435c', 'Cucian Tiba', 'Cucian pesanan AWN-E72DC004 telah tiba. Silakan timbang.', 'info', 0, '2025-11-12 01:02:23', '2025-11-12 01:02:23'),
('019a7716-cc47-7392-9364-f0073382ae37', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Cucian Ditimbang', 'Cucian Anda telah ditimbang. Berat: 3 kg, Total: Rp 15.000', 'info', 0, '2025-11-12 01:02:54', '2025-11-12 01:02:54'),
('019a7717-ca66-716f-a0dd-2f014e522bf5', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'Pengantaran Baru', 'Pesanan AWN-E72DC004 siap untuk diantar', 'info', 0, '2025-11-12 01:03:59', '2025-11-12 01:03:59'),
('019a7717-ca67-72fb-9fe1-4d5d3e1069b7', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Status Pesanan Diperbarui', 'Status pesanan AWN-E72DC004 menjadi: Siap antar', 'info', 0, '2025-11-12 01:03:59', '2025-11-12 01:03:59'),
('019a7718-2c40-736d-8280-4e1930eae88e', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Cucian Sedang Diantar', 'Kurir sedang mengantar cucian Anda. Pesanan: AWN-E72DC004', 'info', 0, '2025-11-12 01:04:24', '2025-11-12 01:04:24'),
('019a7718-5905-723b-b3bd-b309e5e1d9e3', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Pesan Baru dari Kurir', 'Anda mendapat pesan baru untuk pesanan AWN-E72DC004', 'info', 0, '2025-11-12 01:04:35', '2025-11-12 01:04:35'),
('019a7718-e303-714e-b9fb-0751066e6a0f', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'Pesan Baru dari Pelanggan', 'Anda mendapat pesan baru untuk pesanan AWN-E72DC004', 'info', 0, '2025-11-12 01:05:11', '2025-11-12 01:05:11'),
('019a7719-240c-70cb-9f33-1fd8ea169ad5', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Pesanan Selesai', 'Cucian Anda telah diantar. Terima kasih telah menggunakan layanan Awan Laundry!', 'success', 0, '2025-11-12 01:05:27', '2025-11-12 01:05:27'),
('019a7720-9d15-7070-b6b4-f8a00eae5dbc', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'Pesanan Baru', 'Pesanan baru dari Rama dengan kode AWN-1B1665B0', 'info', 0, '2025-11-12 01:13:37', '2025-11-12 01:13:37'),
('019a7720-9d17-72d7-a468-255f0f743941', '019a57cf-38ae-732d-bd5a-2e56576a1963', 'Pesanan Baru', 'Pesanan baru dari Rama dengan kode AWN-1B1665B0', 'info', 0, '2025-11-12 01:13:37', '2025-11-12 01:13:37'),
('019a7720-9d18-72af-8898-5b4622253b4c', '019a5971-f9a6-70a9-9f90-50807bb4435c', 'Pesanan Baru', 'Pesanan baru dari Rama dengan kode AWN-1B1665B0', 'info', 0, '2025-11-12 01:13:37', '2025-11-12 01:13:37'),
('019a7721-2232-704f-bbf8-6fe8be768852', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-1B1665B0 perlu dikonfirmasi', 'info', 0, '2025-11-12 01:14:11', '2025-11-12 01:14:11'),
('019a7721-2234-7065-9290-a0c65ef7b07d', '019a57cf-38ae-732d-bd5a-2e56576a1963', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-1B1665B0 perlu dikonfirmasi', 'info', 0, '2025-11-12 01:14:11', '2025-11-12 01:14:11'),
('019a7721-2235-72c9-8635-7e8c1e3b68ec', '019a5971-f9a6-70a9-9f90-50807bb4435c', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-1B1665B0 perlu dikonfirmasi', 'info', 0, '2025-11-12 01:14:11', '2025-11-12 01:14:11'),
('019a7721-d989-7061-a593-4af2cee6ddca', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Cucian Ditimbang', 'Cucian Anda telah ditimbang. Berat: 3 kg, Total: Rp 75.000', 'info', 0, '2025-11-12 01:14:58', '2025-11-12 01:14:58'),
('019a7722-cb41-73d5-ba5c-10439b91de6c', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'Pengantaran Baru', 'Pesanan AWN-1B1665B0 siap untuk diantar', 'info', 0, '2025-11-12 01:16:00', '2025-11-12 01:16:00'),
('019a7722-cb42-73d3-ba9f-84622775ffa9', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Status Pesanan Diperbarui', 'Status pesanan AWN-1B1665B0 menjadi: Siap antar', 'info', 0, '2025-11-12 01:16:00', '2025-11-12 01:16:00'),
('019a7723-5cdd-72e4-a4db-a1e75470042a', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Cucian Sedang Diantar', 'Kurir sedang mengantar cucian Anda. Pesanan: AWN-1B1665B0', 'info', 0, '2025-11-12 01:16:37', '2025-11-12 01:16:37'),
('019a7723-6363-7094-8c92-76abbd1862bd', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Pesanan Selesai', 'Cucian Anda telah diantar. Terima kasih telah menggunakan layanan Awan Laundry!', 'success', 0, '2025-11-12 01:16:39', '2025-11-12 01:16:39'),
('019a8ceb-1760-7116-9395-bebc9fb96f56', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'Pesanan Baru', 'Pesanan baru dari Rama dengan kode AWN-5C878B5C', 'info', 0, '2025-11-16 06:46:48', '2025-11-16 06:46:48'),
('019a8ceb-1761-71cb-85d8-866d121a573a', '019a57cf-38ae-732d-bd5a-2e56576a1963', 'Pesanan Baru', 'Pesanan baru dari Rama dengan kode AWN-5C878B5C', 'info', 0, '2025-11-16 06:46:48', '2025-11-16 06:46:48'),
('019a8ceb-1761-71cb-85d8-866d12ac1256', '019a5971-f9a6-70a9-9f90-50807bb4435c', 'Pesanan Baru', 'Pesanan baru dari Rama dengan kode AWN-5C878B5C', 'info', 0, '2025-11-16 06:46:48', '2025-11-16 06:46:48'),
('019a8ceb-42c9-72d8-8faa-d639bda604e6', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-5C878B5C perlu dikonfirmasi', 'info', 0, '2025-11-16 06:46:59', '2025-11-16 06:46:59'),
('019a8ceb-42ca-7220-8d1c-2bf237f0c283', '019a57cf-38ae-732d-bd5a-2e56576a1963', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-5C878B5C perlu dikonfirmasi', 'info', 0, '2025-11-16 06:46:59', '2025-11-16 06:46:59'),
('019a8ceb-42ca-7220-8d1c-2bf2382392d2', '019a5971-f9a6-70a9-9f90-50807bb4435c', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-5C878B5C perlu dikonfirmasi', 'info', 0, '2025-11-16 06:46:59', '2025-11-16 06:46:59'),
('019a8ceb-c3b8-7280-94a3-41431df5d4b2', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Cucian Ditimbang', 'Cucian Anda telah ditimbang. Berat: 7 kg, Total: Rp 49.000', 'info', 0, '2025-11-16 06:47:32', '2025-11-16 06:47:32'),
('019a947c-43ca-7117-8d1f-0fd4fb11b853', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'Pesanan Baru', 'Pesanan baru dari ufti dengan kode AWN-5B2F28A5', 'info', 0, '2025-11-17 18:02:43', '2025-11-17 18:02:43'),
('019a947c-43cb-71ad-9972-dec1d12cb879', '019a57cf-38ae-732d-bd5a-2e56576a1963', 'Pesanan Baru', 'Pesanan baru dari ufti dengan kode AWN-5B2F28A5', 'info', 0, '2025-11-17 18:02:43', '2025-11-17 18:02:43'),
('019a947c-43cc-73fc-b361-e7c9432cf4dd', '019a5971-f9a6-70a9-9f90-50807bb4435c', 'Pesanan Baru', 'Pesanan baru dari ufti dengan kode AWN-5B2F28A5', 'info', 0, '2025-11-17 18:02:43', '2025-11-17 18:02:43'),
('019a9480-9a93-71a5-9f5d-4c97f5adde44', '019a57eb-ddc0-7174-9e44-e84158a2ad03', 'Pesan Baru dari Kurir', 'Anda mendapat pesan baru untuk pesanan AWN-02081706', 'info', 0, '2025-11-17 18:07:27', '2025-11-17 18:07:27'),
('019a9484-09e6-7259-9a29-7cc53787de11', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'Pesanan Baru', 'Pesanan baru dari ufti dengan kode AWN-7B093AD1', 'info', 0, '2025-11-17 18:11:12', '2025-11-17 18:11:12'),
('019a9484-09e7-7100-934a-ec280a2d7bd0', '019a57cf-38ae-732d-bd5a-2e56576a1963', 'Pesanan Baru', 'Pesanan baru dari ufti dengan kode AWN-7B093AD1', 'info', 0, '2025-11-17 18:11:12', '2025-11-17 18:11:12'),
('019a9484-09e8-730a-8e14-819d7dc2fd4d', '019a5971-f9a6-70a9-9f90-50807bb4435c', 'Pesanan Baru', 'Pesanan baru dari ufti dengan kode AWN-7B093AD1', 'info', 0, '2025-11-17 18:11:12', '2025-11-17 18:11:12'),
('019a9484-292d-7065-b444-d5b83ec99849', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-7B093AD1 perlu dikonfirmasi', 'info', 0, '2025-11-17 18:11:20', '2025-11-17 18:11:20'),
('019a9484-292e-705e-bac5-4d1194f97158', '019a57cf-38ae-732d-bd5a-2e56576a1963', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-7B093AD1 perlu dikonfirmasi', 'info', 0, '2025-11-17 18:11:20', '2025-11-17 18:11:20'),
('019a9484-292f-70d1-82b1-66e99d8964e9', '019a5971-f9a6-70a9-9f90-50807bb4435c', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-7B093AD1 perlu dikonfirmasi', 'info', 0, '2025-11-17 18:11:20', '2025-11-17 18:11:20'),
('019a9484-9bca-7332-8a37-175b5b353545', '019a947a-e11c-72a2-94e9-89e093cb4da7', 'Kurir Dalam Perjalanan', 'Kurir sedang menuju lokasi Anda untuk menjemput cucian. Pesanan: AWN-7B093AD1', 'info', 0, '2025-11-17 18:11:49', '2025-11-17 18:11:49'),
('019a9484-e6ad-72a7-92f6-f0a02f6169ab', '019a947a-e11c-72a2-94e9-89e093cb4da7', 'Cucian Berhasil Dijemput', 'Cucian Anda telah dijemput. Pesanan: AWN-7B093AD1', 'success', 0, '2025-11-17 18:12:09', '2025-11-17 18:12:09'),
('019a9484-e6af-7343-a08d-5e0bf4131379', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'Cucian Tiba', 'Cucian pesanan AWN-7B093AD1 telah tiba. Silakan timbang.', 'info', 0, '2025-11-17 18:12:09', '2025-11-17 18:12:09'),
('019a9484-e6b0-70d2-ba31-8108d1a33fde', '019a57cf-38ae-732d-bd5a-2e56576a1963', 'Cucian Tiba', 'Cucian pesanan AWN-7B093AD1 telah tiba. Silakan timbang.', 'info', 0, '2025-11-17 18:12:09', '2025-11-17 18:12:09'),
('019a9484-e6b1-731e-acf8-50bd704a2765', '019a5971-f9a6-70a9-9f90-50807bb4435c', 'Cucian Tiba', 'Cucian pesanan AWN-7B093AD1 telah tiba. Silakan timbang.', 'info', 0, '2025-11-17 18:12:09', '2025-11-17 18:12:09'),
('019a9486-8d20-7320-bad5-1224f059c691', '019a947a-e11c-72a2-94e9-89e093cb4da7', 'Status Pesanan Diperbarui', 'Status pesanan AWN-7B093AD1 menjadi: Dicuci', 'info', 0, '2025-11-17 18:13:57', '2025-11-17 18:13:57'),
('019a99dc-9a6c-72d7-8450-5130a484dbb1', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'Pesanan Baru', 'Pesanan baru dari Rama dengan kode AWN-60AC1534', 'info', 0, '2025-11-18 19:06:02', '2025-11-18 19:06:02'),
('019a99dc-9a6d-7112-9aaa-9791e68a84f4', '019a57cf-38ae-732d-bd5a-2e56576a1963', 'Pesanan Baru', 'Pesanan baru dari Rama dengan kode AWN-60AC1534', 'info', 0, '2025-11-18 19:06:02', '2025-11-18 19:06:02'),
('019a99dc-9a6e-7188-8218-d3c1e28f454d', '019a5971-f9a6-70a9-9f90-50807bb4435c', 'Pesanan Baru', 'Pesanan baru dari Rama dengan kode AWN-60AC1534', 'info', 0, '2025-11-18 19:06:02', '2025-11-18 19:06:02'),
('019a99dc-d4c8-7187-b177-4fe483f335cc', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-60AC1534 perlu dikonfirmasi', 'info', 0, '2025-11-18 19:06:17', '2025-11-18 19:06:17'),
('019a99dc-d4c9-7137-855d-3f381504d47d', '019a57cf-38ae-732d-bd5a-2e56576a1963', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-60AC1534 perlu dikonfirmasi', 'info', 0, '2025-11-18 19:06:17', '2025-11-18 19:06:17'),
('019a99dc-d4c9-7137-855d-3f38156f0b27', '019a5971-f9a6-70a9-9f90-50807bb4435c', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-60AC1534 perlu dikonfirmasi', 'info', 0, '2025-11-18 19:06:17', '2025-11-18 19:06:17'),
('019a99dd-5cdc-72b6-ad16-d7fbba14a759', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Cucian Ditimbang', 'Cucian Anda telah ditimbang. Berat: 4 kg, Total: Rp 20.000', 'info', 0, '2025-11-18 19:06:52', '2025-11-18 19:06:52'),
('019a99df-6196-72a5-b5f1-b867d296aaf3', '019a947a-e11c-72a2-94e9-89e093cb4da7', 'Status Pesanan Diperbarui', 'Status pesanan AWN-5B2F28A5 menjadi: Dikemas', 'info', 0, '2025-11-18 19:09:04', '2025-11-18 19:09:04'),
('019a99e0-b91c-7240-a762-3b0c51430a6e', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'Pengantaran Baru', 'Pesanan AWN-60AC1534 siap untuk diantar', 'info', 0, '2025-11-18 19:10:32', '2025-11-18 19:10:32'),
('019a99e0-b91d-7270-ba24-fdb04bc0b730', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Status Pesanan Diperbarui', 'Status pesanan AWN-60AC1534 menjadi: Siap antar', 'info', 0, '2025-11-18 19:10:32', '2025-11-18 19:10:32'),
('019a99e1-2d04-72ec-8a30-6cb4ab6ba2df', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Cucian Sedang Diantar', 'Kurir sedang mengantar cucian Anda. Pesanan: AWN-60AC1534', 'info', 0, '2025-11-18 19:11:02', '2025-11-18 19:11:02'),
('019a99e1-56ac-70d5-9df3-2ba153a6b68d', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Pesan Baru dari Kurir', 'Anda mendapat pesan baru untuk pesanan AWN-60AC1534', 'info', 0, '2025-11-18 19:11:13', '2025-11-18 19:11:13'),
('019a99e1-f7ff-71ce-bc10-bd368bd3ded9', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'Pesan Baru dari Pelanggan', 'Anda mendapat pesan baru untuk pesanan AWN-60AC1534', 'info', 0, '2025-11-18 19:11:54', '2025-11-18 19:11:54'),
('019a99e2-3cec-7395-a421-31e610989e9b', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Pesanan Selesai', 'Cucian Anda telah diantar. Terima kasih telah menggunakan layanan Awan Laundry!', 'success', 0, '2025-11-18 19:12:12', '2025-11-18 19:12:12'),
('019abda5-991f-71fa-a365-5daf890c41d1', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'Pesanan Baru', 'Pesanan baru dari Rama dengan kode AWN-F41B7429', 'info', 0, '2025-11-25 17:52:17', '2025-11-25 17:52:17'),
('019abda5-991f-71fa-a365-5daf899875b1', '019a57cf-38ae-732d-bd5a-2e56576a1963', 'Pesanan Baru', 'Pesanan baru dari Rama dengan kode AWN-F41B7429', 'info', 0, '2025-11-25 17:52:17', '2025-11-25 17:52:17'),
('019abda5-9920-71ee-a663-c9b2f6d042a0', '019a5971-f9a6-70a9-9f90-50807bb4435c', 'Pesanan Baru', 'Pesanan baru dari Rama dengan kode AWN-F41B7429', 'info', 0, '2025-11-25 17:52:17', '2025-11-25 17:52:17'),
('019abda6-3dae-705c-b8c8-25bf5c51e47d', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-F41B7429 perlu dikonfirmasi', 'info', 0, '2025-11-25 17:52:59', '2025-11-25 17:52:59'),
('019abda6-3daf-720c-bf74-a72f6feb7cfa', '019a57cf-38ae-732d-bd5a-2e56576a1963', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-F41B7429 perlu dikonfirmasi', 'info', 0, '2025-11-25 17:52:59', '2025-11-25 17:52:59'),
('019abda6-3db0-734c-a3af-e031d0111b94', '019a5971-f9a6-70a9-9f90-50807bb4435c', 'Pembayaran Baru', 'Pembayaran untuk pesanan AWN-F41B7429 perlu dikonfirmasi', 'info', 0, '2025-11-25 17:52:59', '2025-11-25 17:52:59'),
('019abda7-93ee-7300-88de-593739f16d49', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'Pengantaran Baru', 'Pesanan AWN-F41B7429 siap untuk diantar', 'info', 0, '2025-11-25 17:54:27', '2025-11-25 17:54:27'),
('019abda7-93ef-7177-8295-a366a8871b9b', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Status Pesanan Diperbarui', 'Status pesanan AWN-F41B7429 menjadi: Siap antar', 'info', 0, '2025-11-25 17:54:27', '2025-11-25 17:54:27'),
('019abdaa-3104-73cf-b574-7e5a5a8ad6b7', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Kurir Dalam Perjalanan', 'Kurir sedang menuju lokasi Anda untuk menjemput cucian. Pesanan: AWN-F41B7429', 'info', 0, '2025-11-25 17:57:18', '2025-11-25 17:57:18'),
('019abdaa-7ab2-7001-8c40-ea80886f2ae7', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Status Pesanan Diperbarui', 'Status pesanan AWN-F41B7429 menjadi: Siap antar', 'info', 0, '2025-11-25 17:57:37', '2025-11-25 17:57:37'),
('019abdaa-bd9e-731c-9e2f-1367cb627f59', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Cucian Sedang Diantar', 'Kurir sedang mengantar cucian Anda. Pesanan: AWN-F41B7429', 'info', 0, '2025-11-25 17:57:54', '2025-11-25 17:57:54'),
('019abdab-4bb7-71ae-ac23-202e15dead12', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'Pesan Baru dari Pelanggan', 'Anda mendapat pesan baru untuk pesanan AWN-F41B7429', 'info', 0, '2025-11-25 17:58:31', '2025-11-25 17:58:31'),
('019abdab-6bca-7380-badc-0df7843550ad', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Pesan Baru dari Kurir', 'Anda mendapat pesan baru untuk pesanan AWN-F41B7429', 'info', 0, '2025-11-25 17:58:39', '2025-11-25 17:58:39'),
('019abdab-b2bc-71f9-90d3-d508b39ac9fd', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Cucian Berhasil Dijemput', 'Cucian Anda telah dijemput. Pesanan: AWN-F41B7429', 'success', 0, '2025-11-25 17:58:57', '2025-11-25 17:58:57'),
('019abdab-b2be-72d2-a536-b792cb5f25cf', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'Cucian Tiba', 'Cucian pesanan AWN-F41B7429 telah tiba. Silakan timbang.', 'info', 0, '2025-11-25 17:58:57', '2025-11-25 17:58:57'),
('019abdab-b2bf-73a1-982a-d131f277930a', '019a57cf-38ae-732d-bd5a-2e56576a1963', 'Cucian Tiba', 'Cucian pesanan AWN-F41B7429 telah tiba. Silakan timbang.', 'info', 0, '2025-11-25 17:58:57', '2025-11-25 17:58:57'),
('019abdab-b2c0-717a-8a3b-406b0683e242', '019a5971-f9a6-70a9-9f90-50807bb4435c', 'Cucian Tiba', 'Cucian pesanan AWN-F41B7429 telah tiba. Silakan timbang.', 'info', 0, '2025-11-25 17:58:57', '2025-11-25 17:58:57'),
('019abdac-2daf-7004-a3fa-7e32d55397c4', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Pesanan Selesai', 'Cucian Anda telah diantar. Terima kasih telah menggunakan layanan Awan Laundry!', 'success', 0, '2025-11-25 17:59:29', '2025-11-25 17:59:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('pemilik@awanlaundry.com', '$2y$12$gnQZGTK9Lv19eKyQ7msyhuCOc/Zhi9z5A3EcPbaRTLWApBqy76ZjK', '2025-11-06 06:44:56'),
('rama@gmail.com', '$2y$12$2ZeeH0A03xw6/P2DgyGVSeUx7.izV76xYRPshduRGlxBRwZr4ZdD6', '2025-11-06 06:47:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `pembayaran_id` char(36) NOT NULL,
  `pesanan_id` char(36) NOT NULL,
  `metode_pembayaran` enum('transfer','tunai','ewallet','qris') NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `status` enum('menunggu','berhasil','gagal') NOT NULL DEFAULT 'menunggu',
  `bukti_transfer` varchar(255) DEFAULT NULL,
  `tanggal_bayar` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`pembayaran_id`, `pesanan_id`, `metode_pembayaran`, `jumlah`, `status`, `bukti_transfer`, `tanggal_bayar`, `created_at`, `updated_at`) VALUES
('019a57e6-792e-72c1-8bf0-7497b96d1e70', '019a57e6-0d1b-7145-8c24-fb91972415ab', 'qris', 25000.00, 'menunggu', 'bukti-pembayaran/59cZ6SalYlkvXfjirk7mh4jfiCrpu8FbuweyJbZC.png', '2025-11-05 23:41:53', '2025-11-05 23:41:53', '2025-11-05 23:41:53'),
('019a5963-f7c8-7292-9508-893abe5f6c97', '019a5963-6ab4-737a-bd08-154c9948e04c', 'tunai', 56000.00, 'menunggu', 'bukti-pembayaran/tWztzofbn7Cxucu4VPERLoZAQob5T7N2vYy0lhWC.png', '2025-11-06 06:38:35', '2025-11-06 06:38:35', '2025-11-06 06:38:35'),
('019a5f66-4ab1-70c8-9a61-e15749b76e32', '019a5f66-1034-70fd-b3de-3b6eaf06ffc0', 'tunai', 10000.00, 'menunggu', NULL, '2025-11-07 10:38:50', '2025-11-07 10:38:50', '2025-11-07 10:38:50'),
('019a5f6c-1d42-70eb-9c61-367ded5a250a', '019a5f6b-ff10-71b1-9308-67e9bf810ca7', 'tunai', 28000.00, 'menunggu', NULL, '2025-11-07 10:45:12', '2025-11-07 10:45:12', '2025-11-07 10:45:12'),
('019a5f96-2144-70d2-86c0-3cefb20eec09', '019a5f95-fb6b-708a-9640-98d6c06976e5', 'tunai', 35000.00, 'menunggu', NULL, '2025-11-07 11:31:05', '2025-11-07 11:31:05', '2025-11-07 11:31:05'),
('019a624a-f344-72f3-b896-529e2de2985d', '019a624a-b53b-7187-8529-dd53f80019d3', 'tunai', 21000.00, 'menunggu', NULL, '2025-11-08 00:07:50', '2025-11-08 00:07:50', '2025-11-08 00:07:50'),
('019a76ea-e1ba-73ae-9614-09160426c8b3', '019a76ea-62e6-7378-9fe3-11496037c1d1', 'tunai', 49000.00, 'menunggu', NULL, '2025-11-12 00:14:56', '2025-11-12 00:14:56', '2025-11-12 00:14:56'),
('019a7714-4216-73d8-8f32-3abd207c58a9', '019a7713-f0a7-715a-bc7b-5ef70334834c', 'tunai', 15000.00, 'menunggu', NULL, '2025-11-12 01:00:07', '2025-11-12 01:00:07', '2025-11-12 01:00:07'),
('019a7721-222c-728d-86d8-d655095b527f', '019a7720-9d0a-717f-a2a4-3581a955586a', 'transfer', 100000.00, 'menunggu', 'bukti-pembayaran/hUboVD3eQVY1rVT1DpYdMmgEWI6jnQWuyHY2rzTp.png', '2025-11-12 01:14:11', '2025-11-12 01:14:11', '2025-11-12 01:14:11'),
('019a8ceb-42c8-73cb-ab11-7d8cdcf18288', '019a8ceb-16fd-7266-ba7d-e8ecaed73988', 'tunai', 49000.00, 'menunggu', NULL, '2025-11-16 06:46:59', '2025-11-16 06:46:59', '2025-11-16 06:46:59'),
('019a9484-2929-70b4-a736-9aa82cb5cc34', '019a9484-09dc-7167-9cf5-159496c21eaf', 'tunai', 125000.00, 'menunggu', NULL, '2025-11-17 18:11:20', '2025-11-17 18:11:20', '2025-11-17 18:11:20'),
('019a99dc-d4bb-7038-9209-04a5c1591c65', '019a99dc-99d8-7352-9c43-0604d69c2a63', 'tunai', 20000.00, 'menunggu', NULL, '2025-11-18 19:06:17', '2025-11-18 19:06:17', '2025-11-18 19:06:17'),
('019abda6-3da8-71f3-a547-a0c20bb8ce42', '019abda5-9891-72e5-89e2-aea27407efaa', 'ewallet', 30000.00, 'menunggu', 'bukti-pembayaran/CU57SLFHZgaLXeRzOp8XyTS7FWlKvq0jOn6FnMZv.png', '2025-11-25 17:52:59', '2025-11-25 17:52:59', '2025-11-25 17:52:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengantaran`
--

CREATE TABLE `pengantaran` (
  `pengantaran_id` char(36) NOT NULL,
  `pesanan_id` char(36) NOT NULL,
  `kurir_id` char(36) DEFAULT NULL,
  `alamat` text NOT NULL,
  `tanggal_antar` timestamp NULL DEFAULT NULL,
  `status` enum('dijadwalkan','dalam_perjalanan','selesai','gagal') NOT NULL DEFAULT 'dijadwalkan',
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pengantaran`
--

INSERT INTO `pengantaran` (`pengantaran_id`, `pesanan_id`, `kurir_id`, `alamat`, `tanggal_antar`, `status`, `latitude`, `longitude`, `catatan`, `created_at`, `updated_at`) VALUES
('019a5f7f-ea94-72cf-9c1a-d55cfe6fb0d3', '019a5f6b-ff10-71b1-9308-67e9bf810ca7', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'indramayu', '2025-11-07 11:07:44', 'selesai', NULL, NULL, NULL, '2025-11-07 11:06:50', '2025-11-07 11:16:26'),
('019a5f97-31fe-73f1-9256-79ae5c3dab73', '019a5f95-fb6b-708a-9640-98d6c06976e5', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'cirebon', '2025-11-07 11:32:59', 'selesai', NULL, NULL, NULL, '2025-11-07 11:32:15', '2025-11-07 11:34:43'),
('019a624b-cdaa-7180-ad95-c7c9b6fcead4', '019a624a-b53b-7187-8529-dd53f80019d3', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'cirebon', '2025-11-08 00:12:29', 'selesai', NULL, NULL, NULL, '2025-11-08 00:08:46', '2025-11-08 00:13:49'),
('019a76ef-0a47-711d-9bf9-ab7f6681d533', '019a76ea-62e6-7378-9fe3-11496037c1d1', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'cirebon', '2025-11-12 00:20:52', 'selesai', NULL, NULL, NULL, '2025-11-12 00:19:28', '2025-11-12 00:21:23'),
('019a7717-ca63-7198-8dbe-a11e8e09086c', '019a7713-f0a7-715a-bc7b-5ef70334834c', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'Lohbener, indramayu', '2025-11-12 01:04:24', 'selesai', NULL, NULL, NULL, '2025-11-12 01:03:59', '2025-11-12 01:05:27'),
('019a7722-cb3c-73ff-887a-3aeb8a99acde', '019a7720-9d0a-717f-a2a4-3581a955586a', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'cirebon', '2025-11-12 01:16:37', 'selesai', NULL, NULL, NULL, '2025-11-12 01:16:00', '2025-11-12 01:16:39'),
('019a99e0-b918-7229-9e4f-f4f387e08c8c', '019a99dc-99d8-7352-9c43-0604d69c2a63', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'cirebon', '2025-11-18 19:11:02', 'selesai', NULL, NULL, NULL, '2025-11-18 19:10:32', '2025-11-18 19:12:12'),
('019abda7-93ea-7184-816d-0afeb57201c2', '019abda5-9891-72e5-89e2-aea27407efaa', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'Indramayu', '2025-11-25 17:57:54', 'selesai', NULL, NULL, NULL, '2025-11-25 17:54:27', '2025-11-25 17:59:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjemputan`
--

CREATE TABLE `penjemputan` (
  `penjemputan_id` char(36) NOT NULL,
  `pesanan_id` char(36) NOT NULL,
  `kurir_id` char(36) DEFAULT NULL,
  `alamat` text NOT NULL,
  `tanggal_jemput` timestamp NULL DEFAULT NULL,
  `status` enum('dijadwalkan','dalam_perjalanan','selesai','gagal') NOT NULL DEFAULT 'dijadwalkan',
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `penjemputan`
--

INSERT INTO `penjemputan` (`penjemputan_id`, `pesanan_id`, `kurir_id`, `alamat`, `tanggal_jemput`, `status`, `latitude`, `longitude`, `catatan`, `created_at`, `updated_at`) VALUES
('019a57c7-7c0a-729a-9903-4fa21c924172', '019a57c7-7c06-72cc-8267-77ada7688dd4', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'Jl. Merdeka No. 123, Indramayu', '2025-11-06 06:36:57', 'selesai', NULL, NULL, NULL, '2025-11-05 23:08:02', '2025-11-06 07:03:29'),
('019a57e6-0d20-73ed-99d7-a392a84ea207', '019a57e6-0d1b-7145-8c24-fb91972415ab', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'Jl. Merdeka No. 123, Indramayu', '2025-11-05 23:43:47', 'selesai', NULL, NULL, 'otw ya', '2025-11-05 23:41:25', '2025-11-05 23:44:08'),
('019a7713-f104-7378-96f1-053af4c30505', '019a7713-f0a7-715a-bc7b-5ef70334834c', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'Lohbener, indramayu', '2025-11-12 01:01:12', 'selesai', NULL, NULL, NULL, '2025-11-12 00:59:46', '2025-11-12 01:02:23'),
('019a9484-09e1-71d0-8d7a-f455224a07f0', '019a9484-09dc-7167-9cf5-159496c21eaf', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'arahan', '2025-11-17 18:11:49', 'selesai', NULL, NULL, NULL, '2025-11-17 18:11:12', '2025-11-17 18:12:09'),
('019abda5-991b-718b-af6a-1ce71f403d99', '019abda5-9891-72e5-89e2-aea27407efaa', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'Indramayu', '2025-11-25 17:57:18', 'selesai', NULL, NULL, NULL, '2025-11-25 17:52:17', '2025-11-25 17:58:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesan`
--

CREATE TABLE `pesan` (
  `pesan_id` char(36) NOT NULL,
  `pesanan_id` char(36) NOT NULL,
  `pengirim_id` char(36) NOT NULL,
  `penerima_id` char(36) NOT NULL,
  `isi_pesan` text NOT NULL,
  `dibaca` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pesan`
--

INSERT INTO `pesan` (`pesan_id`, `pesanan_id`, `pengirim_id`, `penerima_id`, `isi_pesan`, `dibaca`, `created_at`, `updated_at`) VALUES
('019a5f87-a71d-714f-8ac5-8cdbf3a3b053', '019a5f6b-ff10-71b1-9308-67e9bf810ca7', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', '019a57eb-ddc0-7174-9e44-e84158a2ad03', 'mba saya otw ya', 1, '2025-11-07 11:15:17', '2025-11-07 11:15:44'),
('019a5f88-2e3c-722a-b142-e8a1d437706f', '019a5f6b-ff10-71b1-9308-67e9bf810ca7', '019a57eb-ddc0-7174-9e44-e84158a2ad03', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'oh iya mas di tunggu', 1, '2025-11-07 11:15:51', '2025-11-17 18:07:16'),
('019a5f98-30da-718a-bcaf-20d490677de6', '019a5f95-fb6b-708a-9640-98d6c06976e5', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'mas tunggu ya saya otw mau nganterin pesanan', 1, '2025-11-07 11:33:20', '2025-11-07 11:33:42'),
('019a5f98-b914-70bb-972c-9d41438e46fd', '019a5f95-fb6b-708a-9640-98d6c06976e5', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'oh iya mas ditunggu ya', 1, '2025-11-07 11:33:55', '2025-11-07 11:34:30'),
('019a624e-0a2a-70e0-ab5e-45890cc150a7', '019a624a-b53b-7187-8529-dd53f80019d3', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'woi mau gw anterin', 1, '2025-11-08 00:11:12', '2025-11-08 00:12:58'),
('019a624f-c096-7020-ad81-d67b646a243c', '019a624a-b53b-7187-8529-dd53f80019d3', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'iya jing gw tunggu', 0, '2025-11-08 00:13:05', '2025-11-08 00:13:05'),
('019a76ef-fce4-734d-8f76-1e9af906c0c4', '019a76ea-62e6-7378-9fe3-11496037c1d1', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'baju anda akan segera di antar', 1, '2025-11-12 00:20:30', '2025-11-12 00:21:00'),
('019a76f0-8d22-704f-8f9d-edca12d6e1f0', '019a76ea-62e6-7378-9fe3-11496037c1d1', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'baik ditunggu', 0, '2025-11-12 00:21:07', '2025-11-12 00:21:07'),
('019a7718-5902-728b-84f3-cc18f0550a4d', '019a7713-f0a7-715a-bc7b-5ef70334834c', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'bang dah kelar mo gw anter', 1, '2025-11-12 01:04:35', '2025-11-12 01:05:04'),
('019a7718-e2fe-72d7-ad2c-f7abccd5a245', '019a7713-f0a7-715a-bc7b-5ef70334834c', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'oke bang di tunggu ya', 1, '2025-11-12 01:05:11', '2025-11-12 01:05:12'),
('019a9480-9a8e-71ad-9938-39b6152b044c', '019a5f6b-ff10-71b1-9308-67e9bf810ca7', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', '019a57eb-ddc0-7174-9e44-e84158a2ad03', 'ini pesanannya', 0, '2025-11-17 18:07:27', '2025-11-17 18:07:27'),
('019a99e1-56a8-7317-b1b8-19f4b69248e6', '019a99dc-99d8-7352-9c43-0604d69c2a63', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'pesanan anda akan segera di antar', 1, '2025-11-18 19:11:13', '2025-11-18 19:11:41'),
('019a99e1-f7fc-739b-9e6e-29c4822cc1aa', '019a99dc-99d8-7352-9c43-0604d69c2a63', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'baik di tunggu', 0, '2025-11-18 19:11:54', '2025-11-18 19:11:54'),
('019abdab-4bb2-73e3-9151-f8c0598e1a14', '019abda5-9891-72e5-89e2-aea27407efaa', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'bang kirim yang cepet ya', 1, '2025-11-25 17:58:31', '2025-11-25 17:58:35'),
('019abdab-6bc6-734a-bb95-8d7dadb899a1', '019abda5-9891-72e5-89e2-aea27407efaa', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'iyahh', 1, '2025-11-25 17:58:39', '2025-11-25 17:58:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `pesanan_id` char(36) NOT NULL,
  `pelanggan_id` char(36) NOT NULL,
  `kode_booking` varchar(20) NOT NULL,
  `layanan_id` bigint(20) UNSIGNED NOT NULL,
  `estimasi_berat` decimal(8,2) DEFAULT NULL,
  `berat_aktual` decimal(8,2) DEFAULT NULL,
  `metode_antar` enum('antar_sendiri','dijemput') NOT NULL,
  `alamat_jemput` text DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `estimasi_harga` decimal(10,2) NOT NULL,
  `harga_final` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','menunggu_penjemputan','dijemput','ditimbang','dicuci','dikeringkan','disetrika','dikemas','siap_antar','diantar','selesai','dibatalkan') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`pesanan_id`, `pelanggan_id`, `kode_booking`, `layanan_id`, `estimasi_berat`, `berat_aktual`, `metode_antar`, `alamat_jemput`, `catatan`, `estimasi_harga`, `harga_final`, `status`, `created_at`, `updated_at`) VALUES
('019a57c7-7c06-72cc-8267-77ada7688dd4', '019a57a6-5d68-732b-9b7b-6009f5916b80', 'AWN-B428A9E7', 5, 1.00, 1.00, 'dijemput', 'Jl. Merdeka No. 123, Indramayu', 'jangan luntur ya bang', 25000.00, 25000.00, 'selesai', '2025-11-05 23:08:02', '2025-11-06 07:07:58'),
('019a57e6-0d1b-7145-8c24-fb91972415ab', '019a57a6-5d68-732b-9b7b-6009f5916b80', 'AWN-315C074A', 1, 5.00, 3.00, 'dijemput', 'Jl. Merdeka No. 123, Indramayu', 'pisahin bang baju putihnya', 25000.00, 15000.00, 'selesai', '2025-11-05 23:41:25', '2025-11-06 07:07:47'),
('019a5963-6ab4-737a-bd08-154c9948e04c', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'AWN-4B6EBA76', 2, 8.00, 8.00, 'antar_sendiri', 'cirebon', 'baju yang berwarna di pisah ya bang', 56000.00, 56000.00, 'selesai', '2025-11-06 06:37:58', '2025-11-06 07:07:35'),
('019a5f66-1034-70fd-b3de-3b6eaf06ffc0', '019a57eb-ddc0-7174-9e44-e84158a2ad03', 'AWN-E9BAB1CE', 1, 2.00, 2.00, 'antar_sendiri', 'indramayu', 'tolong di pisahkan baju berwarnanya ya', 10000.00, 10000.00, 'selesai', '2025-11-07 10:38:35', '2025-11-07 10:40:52'),
('019a5f6b-ff10-71b1-9308-67e9bf810ca7', '019a57eb-ddc0-7174-9e44-e84158a2ad03', 'AWN-02081706', 2, 4.00, 4.00, 'antar_sendiri', 'indramayu', NULL, 28000.00, 28000.00, 'selesai', '2025-11-07 10:45:04', '2025-11-07 11:16:26'),
('019a5f95-fb6b-708a-9640-98d6c06976e5', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'AWN-AE01A534', 2, 5.00, 5.00, 'antar_sendiri', 'cirebon', 'pisahin bang yang bajunya berwarna', 35000.00, 35000.00, 'selesai', '2025-11-07 11:30:56', '2025-11-07 11:34:43'),
('019a624a-b53b-7187-8529-dd53f80019d3', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'AWN-C36A34D7', 2, 3.00, 3.00, 'antar_sendiri', 'cirebon', 'bang pisahin bang', 21000.00, 21000.00, 'selesai', '2025-11-08 00:07:34', '2025-11-08 00:13:49'),
('019a76ea-62e6-7378-9fe3-11496037c1d1', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'AWN-3CFA2354', 2, 7.00, 7.00, 'antar_sendiri', 'cirebon', 'tolong pisahkan baju berwarna dan putih', 49000.00, 49000.00, 'selesai', '2025-11-12 00:14:23', '2025-11-12 00:21:23'),
('019a7713-f0a7-715a-bc7b-5ef70334834c', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'AWN-E72DC004', 1, 3.00, 3.00, 'dijemput', 'Lohbener, indramayu', 'bang pisahin napa baju warna ama sempak gw', 15000.00, 15000.00, 'selesai', '2025-11-12 00:59:46', '2025-11-12 01:05:27'),
('019a7720-9d0a-717f-a2a4-3581a955586a', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'AWN-1B1665B0', 5, 4.00, 3.00, 'antar_sendiri', 'cirebon', 'bang itu jordan gw yang bershininnya', 100000.00, 75000.00, 'selesai', '2025-11-12 01:13:37', '2025-11-12 01:16:39'),
('019a8ceb-16fd-7266-ba7d-e8ecaed73988', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'AWN-5C878B5C', 2, 7.00, 7.00, 'antar_sendiri', 'cirebon', NULL, 49000.00, 49000.00, 'ditimbang', '2025-11-16 06:46:48', '2025-11-16 06:47:32'),
('019a947c-4331-70bb-9225-a6b293ac6ed7', '019a947a-e11c-72a2-94e9-89e093cb4da7', 'AWN-5B2F28A5', 2, 6.00, NULL, 'antar_sendiri', 'arahan', NULL, 42000.00, NULL, 'dikemas', '2025-11-17 18:02:42', '2025-11-18 19:09:04'),
('019a9484-09dc-7167-9cf5-159496c21eaf', '019a947a-e11c-72a2-94e9-89e093cb4da7', 'AWN-7B093AD1', 5, 5.00, NULL, 'dijemput', 'arahan', NULL, 125000.00, NULL, 'dicuci', '2025-11-17 18:11:12', '2025-11-17 18:13:57'),
('019a99dc-99d8-7352-9c43-0604d69c2a63', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'AWN-60AC1534', 1, 4.00, 4.00, 'antar_sendiri', 'cirebon', 'tolong pisahkan baju berwarna', 20000.00, 20000.00, 'selesai', '2025-11-18 19:06:02', '2025-11-18 19:12:12'),
('019abda5-9891-72e5-89e2-aea27407efaa', '019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'AWN-F41B7429', 1, 6.00, NULL, 'dijemput', 'Indramayu', 'Pisahkan baju berwarna dengan baju berwarna putih', 30000.00, NULL, 'selesai', '2025-11-25 17:52:17', '2025-11-25 17:59:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `proses`
--

CREATE TABLE `proses` (
  `proses_id` char(36) NOT NULL,
  `pesanan_id` char(36) NOT NULL,
  `karyawan_id` char(36) DEFAULT NULL,
  `tahapan` enum('pencucian','pengeringan','penyetrikaan','pengemasan') NOT NULL,
  `status_checklist` tinyint(1) NOT NULL DEFAULT 0,
  `waktu_mulai` timestamp NULL DEFAULT NULL,
  `waktu_selesai` timestamp NULL DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `proses`
--

INSERT INTO `proses` (`proses_id`, `pesanan_id`, `karyawan_id`, `tahapan`, `status_checklist`, `waktu_mulai`, `waktu_selesai`, `catatan`, `created_at`, `updated_at`) VALUES
('019a5960-c1ba-710b-811e-a5fce525c320', '019a57e6-0d1b-7145-8c24-fb91972415ab', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'pencucian', 0, NULL, NULL, NULL, '2025-11-06 06:35:04', '2025-11-06 06:35:04'),
('019a5960-c1ea-73d6-a0ef-0acf4ee05467', '019a57e6-0d1b-7145-8c24-fb91972415ab', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'pengeringan', 0, NULL, NULL, NULL, '2025-11-06 06:35:04', '2025-11-06 06:35:04'),
('019a5960-c1eb-7134-8286-f2e58fe82c54', '019a57e6-0d1b-7145-8c24-fb91972415ab', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'penyetrikaan', 0, NULL, NULL, NULL, '2025-11-06 06:35:04', '2025-11-06 06:35:04'),
('019a5960-c1ec-71f7-b195-d5999ad2e009', '019a57e6-0d1b-7145-8c24-fb91972415ab', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'pengemasan', 0, NULL, NULL, NULL, '2025-11-06 06:35:04', '2025-11-06 06:35:04'),
('019a5964-79a3-70d5-85ce-046425d54366', '019a5963-6ab4-737a-bd08-154c9948e04c', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'pencucian', 0, NULL, NULL, NULL, '2025-11-06 06:39:08', '2025-11-06 06:39:08'),
('019a5964-79a4-73d3-8406-7c695804a62d', '019a5963-6ab4-737a-bd08-154c9948e04c', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'pengeringan', 0, NULL, NULL, NULL, '2025-11-06 06:39:08', '2025-11-06 06:39:08'),
('019a5964-79a5-7019-a798-9aeb1e3683cb', '019a5963-6ab4-737a-bd08-154c9948e04c', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'penyetrikaan', 0, NULL, NULL, NULL, '2025-11-06 06:39:08', '2025-11-06 06:39:08'),
('019a5964-79a6-727a-8205-e80edf0cc45b', '019a5963-6ab4-737a-bd08-154c9948e04c', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'pengemasan', 0, NULL, NULL, NULL, '2025-11-06 06:39:08', '2025-11-06 06:39:08'),
('019a597e-d448-70a4-bc72-c2599c18b894', '019a57c7-7c06-72cc-8267-77ada7688dd4', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'pencucian', 0, NULL, NULL, NULL, '2025-11-06 07:07:55', '2025-11-06 07:07:55'),
('019a597e-d449-718d-ad4e-fa931cc1b540', '019a57c7-7c06-72cc-8267-77ada7688dd4', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'pengeringan', 0, NULL, NULL, NULL, '2025-11-06 07:07:55', '2025-11-06 07:07:55'),
('019a597e-d449-718d-ad4e-fa931cc6aa56', '019a57c7-7c06-72cc-8267-77ada7688dd4', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'penyetrikaan', 0, NULL, NULL, NULL, '2025-11-06 07:07:55', '2025-11-06 07:07:55'),
('019a597e-d44a-7228-8c5c-9d2546c3336b', '019a57c7-7c06-72cc-8267-77ada7688dd4', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'pengemasan', 0, NULL, NULL, NULL, '2025-11-06 07:07:55', '2025-11-06 07:07:55'),
('019a5f66-ded3-706f-9511-b74692d92a85', '019a5f66-1034-70fd-b3de-3b6eaf06ffc0', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'pencucian', 0, NULL, NULL, NULL, '2025-11-07 10:39:28', '2025-11-07 10:39:28'),
('019a5f66-ded6-71ea-aad3-7f1d7e0e4d3f', '019a5f66-1034-70fd-b3de-3b6eaf06ffc0', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'pengeringan', 0, NULL, NULL, NULL, '2025-11-07 10:39:28', '2025-11-07 10:39:28'),
('019a5f66-ded7-706b-b8ba-109c1a8e2246', '019a5f66-1034-70fd-b3de-3b6eaf06ffc0', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'penyetrikaan', 0, NULL, NULL, NULL, '2025-11-07 10:39:28', '2025-11-07 10:39:28'),
('019a5f66-ded7-706b-b8ba-109c1b47212f', '019a5f66-1034-70fd-b3de-3b6eaf06ffc0', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'pengemasan', 0, NULL, NULL, NULL, '2025-11-07 10:39:28', '2025-11-07 10:39:28'),
('019a5f6c-a4c2-7285-9239-41d7b8f90374', '019a5f6b-ff10-71b1-9308-67e9bf810ca7', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'pencucian', 0, NULL, NULL, NULL, '2025-11-07 10:45:46', '2025-11-07 10:45:46'),
('019a5f6c-a4c4-7058-8510-42d71f6a68a3', '019a5f6b-ff10-71b1-9308-67e9bf810ca7', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'pengeringan', 0, NULL, NULL, NULL, '2025-11-07 10:45:46', '2025-11-07 10:45:46'),
('019a5f6c-a4c4-7058-8510-42d71fd6b9f4', '019a5f6b-ff10-71b1-9308-67e9bf810ca7', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'penyetrikaan', 0, NULL, NULL, NULL, '2025-11-07 10:45:46', '2025-11-07 10:45:46'),
('019a5f6c-a4c7-713c-8d3c-a09317b16181', '019a5f6b-ff10-71b1-9308-67e9bf810ca7', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'pengemasan', 0, NULL, NULL, NULL, '2025-11-07 10:45:46', '2025-11-07 10:45:46'),
('019a5f96-840c-727e-805a-670ace1d65b9', '019a5f95-fb6b-708a-9640-98d6c06976e5', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'pencucian', 0, NULL, NULL, NULL, '2025-11-07 11:31:31', '2025-11-07 11:31:31'),
('019a5f96-840e-7161-9337-4b7adbe2094d', '019a5f95-fb6b-708a-9640-98d6c06976e5', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'pengeringan', 0, NULL, NULL, NULL, '2025-11-07 11:31:31', '2025-11-07 11:31:31'),
('019a5f96-840f-7158-82ec-86c91b4ebbcf', '019a5f95-fb6b-708a-9640-98d6c06976e5', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'penyetrikaan', 0, NULL, NULL, NULL, '2025-11-07 11:31:31', '2025-11-07 11:31:31'),
('019a5f96-8410-70c2-82dd-e9193058b744', '019a5f95-fb6b-708a-9640-98d6c06976e5', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'pengemasan', 0, NULL, NULL, NULL, '2025-11-07 11:31:31', '2025-11-07 11:31:31'),
('019a624b-7170-70cc-a743-2251e0cf5030', '019a624a-b53b-7187-8529-dd53f80019d3', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'pencucian', 0, NULL, NULL, NULL, '2025-11-08 00:08:22', '2025-11-08 00:08:22'),
('019a624b-7172-73fc-bd11-c24867542db8', '019a624a-b53b-7187-8529-dd53f80019d3', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'pengeringan', 0, NULL, NULL, NULL, '2025-11-08 00:08:22', '2025-11-08 00:08:22'),
('019a624b-7173-718f-ac9a-a5de0f97a811', '019a624a-b53b-7187-8529-dd53f80019d3', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'penyetrikaan', 0, NULL, NULL, NULL, '2025-11-08 00:08:22', '2025-11-08 00:08:22'),
('019a624b-7174-737d-af19-568af25c181a', '019a624a-b53b-7187-8529-dd53f80019d3', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'pengemasan', 0, NULL, NULL, NULL, '2025-11-08 00:08:22', '2025-11-08 00:08:22'),
('019a76ed-a63c-7117-815a-abc90af51bab', '019a76ea-62e6-7378-9fe3-11496037c1d1', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'pencucian', 1, NULL, '2025-11-12 00:18:31', NULL, '2025-11-12 00:17:57', '2025-11-12 00:18:31'),
('019a76ed-a63d-7180-bd1d-74a031f884ad', '019a76ea-62e6-7378-9fe3-11496037c1d1', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'pengeringan', 1, NULL, '2025-11-12 00:19:17', NULL, '2025-11-12 00:17:57', '2025-11-12 00:19:17'),
('019a76ed-a63e-70d3-8b2a-c9b5d26df7aa', '019a76ea-62e6-7378-9fe3-11496037c1d1', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'penyetrikaan', 1, NULL, '2025-11-12 00:19:19', NULL, '2025-11-12 00:17:57', '2025-11-12 00:19:19'),
('019a76ed-a63e-70d3-8b2a-c9b5d2db46b5', '019a76ea-62e6-7378-9fe3-11496037c1d1', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'pengemasan', 1, NULL, '2025-11-12 00:19:04', NULL, '2025-11-12 00:17:57', '2025-11-12 00:19:04'),
('019a7716-cc41-7380-88a3-68ef19bf375e', '019a7713-f0a7-715a-bc7b-5ef70334834c', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'pencucian', 1, NULL, '2025-11-12 01:03:11', NULL, '2025-11-12 01:02:54', '2025-11-12 01:03:11'),
('019a7716-cc44-730a-bb2f-ce2f9a86d2be', '019a7713-f0a7-715a-bc7b-5ef70334834c', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'pengeringan', 1, NULL, '2025-11-12 01:03:16', NULL, '2025-11-12 01:02:54', '2025-11-12 01:03:16'),
('019a7716-cc45-7225-bbdf-7847783abff1', '019a7713-f0a7-715a-bc7b-5ef70334834c', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'penyetrikaan', 1, NULL, '2025-11-12 01:03:19', NULL, '2025-11-12 01:02:54', '2025-11-12 01:03:19'),
('019a7716-cc46-70a1-883a-b84b01058842', '019a7713-f0a7-715a-bc7b-5ef70334834c', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'pengemasan', 1, NULL, '2025-11-12 01:03:39', NULL, '2025-11-12 01:02:54', '2025-11-12 01:03:39'),
('019a7721-d980-73b9-896e-23ef54aaaec6', '019a7720-9d0a-717f-a2a4-3581a955586a', NULL, 'pencucian', 1, NULL, '2025-11-12 01:15:13', NULL, '2025-11-12 01:14:58', '2025-11-12 01:15:13'),
('019a7721-d983-7094-a8c9-9363ee469266', '019a7720-9d0a-717f-a2a4-3581a955586a', NULL, 'pengeringan', 1, NULL, '2025-11-12 01:15:22', NULL, '2025-11-12 01:14:58', '2025-11-12 01:15:22'),
('019a7721-d986-70c2-8d66-c8bec27eb8c9', '019a7720-9d0a-717f-a2a4-3581a955586a', NULL, 'penyetrikaan', 1, NULL, '2025-11-12 01:15:26', NULL, '2025-11-12 01:14:58', '2025-11-12 01:15:26'),
('019a7721-d987-701c-b287-cf1a11a19350', '019a7720-9d0a-717f-a2a4-3581a955586a', NULL, 'pengemasan', 1, NULL, '2025-11-12 01:15:37', NULL, '2025-11-12 01:14:58', '2025-11-12 01:15:37'),
('019a8ceb-c3b4-7174-a1f5-682c78c17444', '019a8ceb-16fd-7266-ba7d-e8ecaed73988', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'pencucian', 0, NULL, NULL, NULL, '2025-11-16 06:47:32', '2025-11-16 06:47:32'),
('019a8ceb-c3b6-7196-9bc7-105b423db530', '019a8ceb-16fd-7266-ba7d-e8ecaed73988', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'pengeringan', 0, NULL, NULL, NULL, '2025-11-16 06:47:32', '2025-11-16 06:47:32'),
('019a8ceb-c3b7-73cd-9235-bdc133b33608', '019a8ceb-16fd-7266-ba7d-e8ecaed73988', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'penyetrikaan', 0, NULL, NULL, NULL, '2025-11-16 06:47:32', '2025-11-16 06:47:32'),
('019a8ceb-c3b7-73cd-9235-bdc133d93c29', '019a8ceb-16fd-7266-ba7d-e8ecaed73988', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'pengemasan', 0, NULL, NULL, NULL, '2025-11-16 06:47:32', '2025-11-16 06:47:32'),
('019a99dd-5cd5-739d-812c-64b75a47ed2c', '019a99dc-99d8-7352-9c43-0604d69c2a63', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'pencucian', 0, NULL, NULL, NULL, '2025-11-18 19:06:52', '2025-11-18 19:06:52'),
('019a99dd-5cd8-71e0-b29f-6ec3316bc57b', '019a99dc-99d8-7352-9c43-0604d69c2a63', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'pengeringan', 0, NULL, NULL, NULL, '2025-11-18 19:06:52', '2025-11-18 19:06:52'),
('019a99dd-5cd9-732a-8120-330e4cd07453', '019a99dc-99d8-7352-9c43-0604d69c2a63', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'penyetrikaan', 0, NULL, NULL, NULL, '2025-11-18 19:06:52', '2025-11-18 19:06:52'),
('019a99dd-5cda-7293-9094-190283069ff5', '019a99dc-99d8-7352-9c43-0604d69c2a63', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'pengemasan', 0, NULL, NULL, NULL, '2025-11-18 19:06:52', '2025-11-18 19:06:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` char(36) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1mPRHa4PUe5ZL8pzTEZ92aK8VtCos2KwRjnB6f2m', '019a5971-f9a6-70a9-9f90-50807bb4435c', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRGo1Z1doSTF3cG10VnhCS0xnZHBwTnhtWDJsVWhYQUFCWENjU1FUUyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZW1pbGlrL2Rhc2hib2FyZCI7czo1OiJyb3V0ZSI7czoxNzoicGVtaWxpay5kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7czozNjoiMDE5YTU5NzEtZjlhNi03MGE5LTlmOTAtNTA4MDdiYjQ0MzVjIjt9', 1764118842),
('KqPs9PY44RreLvwgL75GR9fyWWtyOX3ruLsDsubD', '019a57a6-5c9c-73d8-8d2f-274d63f1796c', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVnBYeUw1WEZodGp4VERvMUI3TzBUZFBqN01hWUxkY1pjb09VVDBaMSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMi9rdXJpci9wZW5nYW50YXJhbiI7czo1OiJyb3V0ZSI7czoyMzoia3VyaXIucGVuZ2FudGFyYW4uaW5kZXgiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7czozNjoiMDE5YTU3YTYtNWM5Yy03M2Q4LThkMmYtMjc0ZDYzZjE3OTZjIjt9', 1764118769),
('lPo7lKYw0x7kChC7WLYc99giVHihcuChbxQJozmc', '019a57a6-5bd0-7089-8c53-45d9aa6f41ec', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZlhGVVhtOHFmOGpKT1FENHR3QU1rQWNvdjlxYUxybGZQaHJVRDFnMyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMS9rYXJ5YXdhbi9wZXNhbmFuLzAxOWFiZGE1LTk4OTEtNzJlNS04OWUyLWFlYTI3NDA3ZWZhYSI7czo1OiJyb3V0ZSI7czoyMToia2FyeWF3YW4ucGVzYW5hbi5zaG93Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO3M6MzY6IjAxOWE1N2E2LTViZDAtNzA4OS04YzUzLTQ1ZDlhYTZmNDFlYyI7fQ==', 1764118657);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` char(36) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `alamat` text DEFAULT NULL,
  `role` enum('pelanggan','karyawan','kurir','pemilik') NOT NULL DEFAULT 'pelanggan',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `no_hp`, `alamat`, `role`, `is_active`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
('019a57a6-5bd0-7089-8c53-45d9aa6f41ec', 'Budi Santoso', 'karyawan@awanlaundry.com', '$2y$12$5p5q2ndlZ7.KaUt/.vGxPeMuhxvQAsXmitsNX6pGLk.Q1z7Z8lSFm', '081234567891', 'Indramayu', 'karyawan', 1, NULL, NULL, '2025-11-05 22:31:51', '2025-11-05 22:31:51'),
('019a57a6-5c9c-73d8-8d2f-274d63f1796c', 'Andi Kurniawan', 'kurir@awanlaundry.com', '$2y$12$ejy50shT3fKM.VESII3zGu6ZnhR3IMjw98R8ydFG5DX0bPcYn7c5a', '081234567892', 'Indramayu', 'kurir', 1, NULL, NULL, '2025-11-05 22:31:51', '2025-11-05 22:31:51'),
('019a57a6-5d68-732b-9b7b-6009f5916b80', 'Siti Nurhaliza', 'pelanggan@example.com', '$2y$12$YJyPZLhk2b89KX/n8fjTbeUXHsUrGoks3TDiRtNHMjKoS4MfK.UPW', '081234567893', 'Jl. Merdeka No. 123, Indramayu', 'pelanggan', 1, NULL, NULL, '2025-11-05 22:31:52', '2025-11-05 22:31:52'),
('019a57a7-eb4f-7361-a08d-a96946dcdfb0', 'Rama', 'ramaaditya24434@gmail.com', '$2y$12$HnBPjX6kVVtLDz2R2e/CI.6ziZGUTt34CgyhOSz8P1OgZaiPcg6G2', '087729860204', 'cirebon', 'pelanggan', 1, NULL, NULL, '2025-11-05 22:33:33', '2025-11-05 22:33:33'),
('019a57cf-38ae-732d-bd5a-2e56576a1963', 'rama', 'rama@gmail.com', '$2y$12$UxhhwrYykavPLpM5by05U./lm7qIu6z/arpCZZStLBx92BdexQlNe', '087729860202', 'lohbener', 'pemilik', 1, NULL, NULL, '2025-11-05 23:16:29', '2025-11-05 23:16:29'),
('019a57eb-ddc0-7174-9e44-e84158a2ad03', 'uuf', 'uuf@gmail.com', '$2y$12$NgjJFKUqerjcRfZFM077zedP9nZhM4Zmxq1rPPWjFvGa5CDbXOBhK', '0998772727', 'indramayu', 'pelanggan', 1, NULL, NULL, '2025-11-05 23:47:46', '2025-11-05 23:47:46'),
('019a5971-f9a6-70a9-9f90-50807bb4435c', 'Pemilik', 'pemilik@awanlaundry.com', '$2y$12$ZMM3BpfAk3T6EjaVjwvsiezuh9NcYloCLGzJF.bqBxOyqjoT5595S', '0877298125844', 'lohbener', 'pemilik', 1, NULL, NULL, '2025-11-06 06:53:53', '2025-11-06 06:53:53'),
('019a5f64-9f69-7149-83b6-e503a70cc5c7', 'levi', 'levi@gmail.com', '$2y$12$o4.vKat.ZbHeXnDkJfH1f.fRPxvKdPV6ptq.9xNDohxL9QSYhXjJG', '08127232732788', 'indramayu', 'pelanggan', 1, NULL, NULL, '2025-11-07 10:37:01', '2025-11-07 10:37:01'),
('019a87ce-b2eb-717c-8667-968912053487', 'Warnadi', 'warnadi@gmail.com', '$2y$12$aLfq5ELBKP0Xdz/lqi3jMuEVOebLl2FhY63seqVGWA2jQehmGvBl.', '0881023926516', 'Gebang', 'pelanggan', 1, NULL, NULL, '2025-11-15 06:57:41', '2025-11-15 06:57:41'),
('019a947a-e11c-72a2-94e9-89e093cb4da7', 'ufti', 'ufti@gamil.com', '$2y$12$00D.CjTUm.463sOOEV4iZeRZfswV3NgOT2OLH2xUDu3kfLC/ktURy', '082118276873', 'arahan', 'pelanggan', 1, NULL, NULL, '2025-11-17 18:01:12', '2025-11-17 18:01:12');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`laporan_id`);

--
-- Indeks untuk tabel `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`layanan_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`notifikasi_id`),
  ADD KEY `notifikasi_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`pembayaran_id`),
  ADD KEY `pembayaran_pesanan_id_foreign` (`pesanan_id`);

--
-- Indeks untuk tabel `pengantaran`
--
ALTER TABLE `pengantaran`
  ADD PRIMARY KEY (`pengantaran_id`),
  ADD KEY `pengantaran_pesanan_id_foreign` (`pesanan_id`),
  ADD KEY `pengantaran_kurir_id_foreign` (`kurir_id`);

--
-- Indeks untuk tabel `penjemputan`
--
ALTER TABLE `penjemputan`
  ADD PRIMARY KEY (`penjemputan_id`),
  ADD KEY `penjemputan_pesanan_id_foreign` (`pesanan_id`),
  ADD KEY `penjemputan_kurir_id_foreign` (`kurir_id`);

--
-- Indeks untuk tabel `pesan`
--
ALTER TABLE `pesan`
  ADD PRIMARY KEY (`pesan_id`),
  ADD KEY `pesan_pesanan_id_foreign` (`pesanan_id`),
  ADD KEY `pesan_pengirim_id_foreign` (`pengirim_id`),
  ADD KEY `pesan_penerima_id_foreign` (`penerima_id`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`pesanan_id`),
  ADD UNIQUE KEY `pesanan_kode_booking_unique` (`kode_booking`),
  ADD KEY `pesanan_pelanggan_id_foreign` (`pelanggan_id`),
  ADD KEY `pesanan_layanan_id_foreign` (`layanan_id`);

--
-- Indeks untuk tabel `proses`
--
ALTER TABLE `proses`
  ADD PRIMARY KEY (`proses_id`),
  ADD KEY `proses_pesanan_id_foreign` (`pesanan_id`),
  ADD KEY `proses_karyawan_id_foreign` (`karyawan_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `layanan`
--
ALTER TABLE `layanan`
  MODIFY `layanan_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_pesanan_id_foreign` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`pesanan_id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengantaran`
--
ALTER TABLE `pengantaran`
  ADD CONSTRAINT `pengantaran_kurir_id_foreign` FOREIGN KEY (`kurir_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pengantaran_pesanan_id_foreign` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`pesanan_id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penjemputan`
--
ALTER TABLE `penjemputan`
  ADD CONSTRAINT `penjemputan_kurir_id_foreign` FOREIGN KEY (`kurir_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `penjemputan_pesanan_id_foreign` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`pesanan_id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pesan`
--
ALTER TABLE `pesan`
  ADD CONSTRAINT `pesan_penerima_id_foreign` FOREIGN KEY (`penerima_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pesan_pengirim_id_foreign` FOREIGN KEY (`pengirim_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pesan_pesanan_id_foreign` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`pesanan_id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_layanan_id_foreign` FOREIGN KEY (`layanan_id`) REFERENCES `layanan` (`layanan_id`),
  ADD CONSTRAINT `pesanan_pelanggan_id_foreign` FOREIGN KEY (`pelanggan_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `proses`
--
ALTER TABLE `proses`
  ADD CONSTRAINT `proses_karyawan_id_foreign` FOREIGN KEY (`karyawan_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `proses_pesanan_id_foreign` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`pesanan_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
