-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2025 at 08:31 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `foodai`
--

-- --------------------------------------------------------

--
-- Table structure for table `bahan_pengguna`
--

CREATE TABLE `bahan_pengguna` (
  `ID_Bahan` bigint(20) UNSIGNED NOT NULL,
  `ID_Pengguna` bigint(20) UNSIGNED NOT NULL,
  `Nama_Bahan` varchar(255) NOT NULL,
  `Kategori_Bahan` enum('Vegetable','Fruit','Meat','Dairy') NOT NULL,
  `Jumlah_Bahan` bigint(20) NOT NULL,
  `Satuan_Bahan` float(8,2) NOT NULL,
  `Tipe_Satuan` enum('kg','g','liters') NOT NULL,
  `Tgl_Kadaluarsa` date NOT NULL,
  `Tipe_Penyimpanan` enum('Fridge','Freezer','Pantry') NOT NULL,
  `Tgl_Pembuatan` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bahan_resep`
--

CREATE TABLE `bahan_resep` (
  `ID_Bahan` bigint(20) UNSIGNED NOT NULL,
  `ID_Resep` bigint(20) UNSIGNED NOT NULL,
  `Nama_Bahan` varchar(255) NOT NULL,
  `Jumlah_Bahan` bigint(20) NOT NULL,
  `Satuan_Bahan` float(8,2) NOT NULL,
  `Tipe_Satuan` enum('kg','g','liters') NOT NULL,
  `Kalori` bigint(20) NOT NULL,
  `Image_Bahan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_05_07_181711_create_sessions_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `ID_Notifikasi` bigint(20) UNSIGNED NOT NULL,
  `ID_Pengguna` bigint(20) UNSIGNED NOT NULL,
  `Isi_Notifikasi` text NOT NULL,
  `Status_Notifikasi` enum('Unread','Read') NOT NULL,
  `Tgl_Pembuatan` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `ID_Pengguna` bigint(20) UNSIGNED NOT NULL,
  `Nama_Pengguna` varchar(255) NOT NULL,
  `Email_Pengguna` varchar(255) NOT NULL,
  `Password_Pengguna` varchar(255) NOT NULL,
  `Role_Pengguna` enum('Admin','User') NOT NULL,
  `Tgl_Pembuatan` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`ID_Pengguna`, `Nama_Pengguna`, `Email_Pengguna`, `Password_Pengguna`, `Role_Pengguna`, `Tgl_Pembuatan`) VALUES
(1, 'TestUser', 'testuser@example.com', '$2y$10$eImiTXuWVxfM37uY4JANjQe5C6f9s3Wl4bU2z5i1y1k1k1k1k1k1k', 'User', '2025-05-08 01:27:08');

-- --------------------------------------------------------

--
-- Table structure for table `resep`
--

CREATE TABLE `resep` (
  `ID_Resep` bigint(20) UNSIGNED NOT NULL,
  `ID_Pengguna` bigint(20) UNSIGNED NOT NULL,
  `Nama_Resep` varchar(255) NOT NULL,
  `Kalori` bigint(20) NOT NULL,
  `Langkah_Langkah` text NOT NULL,
  `Image_Resep` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('wQVACjWDUTswtLa9ylQaOTrirm4JNB3VppIWlh7G', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYlJueW44WG9kN0FnTU9FdTJBalM1ZTFDeUZjbTZ0bGhsYTQ1MEwxQiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zaWduaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1746642448);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bahan_pengguna`
--
ALTER TABLE `bahan_pengguna`
  ADD PRIMARY KEY (`ID_Bahan`),
  ADD KEY `ID_Pengguna` (`ID_Pengguna`);

--
-- Indexes for table `bahan_resep`
--
ALTER TABLE `bahan_resep`
  ADD PRIMARY KEY (`ID_Bahan`),
  ADD KEY `ID_Resep` (`ID_Resep`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`ID_Notifikasi`),
  ADD KEY `ID_Pengguna` (`ID_Pengguna`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`ID_Pengguna`);

--
-- Indexes for table `resep`
--
ALTER TABLE `resep`
  ADD PRIMARY KEY (`ID_Resep`),
  ADD KEY `ID_Pengguna` (`ID_Pengguna`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bahan_pengguna`
--
ALTER TABLE `bahan_pengguna`
  MODIFY `ID_Bahan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bahan_resep`
--
ALTER TABLE `bahan_resep`
  MODIFY `ID_Bahan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `ID_Notifikasi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `ID_Pengguna` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `resep`
--
ALTER TABLE `resep`
  MODIFY `ID_Resep` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bahan_pengguna`
--
ALTER TABLE `bahan_pengguna`
  ADD CONSTRAINT `bahan_pengguna_ibfk_1` FOREIGN KEY (`ID_Pengguna`) REFERENCES `pengguna` (`ID_Pengguna`) ON DELETE CASCADE;

--
-- Constraints for table `bahan_resep`
--
ALTER TABLE `bahan_resep`
  ADD CONSTRAINT `bahan_resep_ibfk_1` FOREIGN KEY (`ID_Resep`) REFERENCES `resep` (`ID_Resep`) ON DELETE CASCADE;

--
-- Constraints for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_ibfk_1` FOREIGN KEY (`ID_Pengguna`) REFERENCES `pengguna` (`ID_Pengguna`) ON DELETE CASCADE;

--
-- Constraints for table `resep`
--
ALTER TABLE `resep`
  ADD CONSTRAINT `resep_ibfk_1` FOREIGN KEY (`ID_Pengguna`) REFERENCES `pengguna` (`ID_Pengguna`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
