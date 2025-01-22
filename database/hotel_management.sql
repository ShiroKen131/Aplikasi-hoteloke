-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 22, 2025 at 12:36 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `kamar`
--

CREATE TABLE `kamar` (
  `id` int NOT NULL,
  `nomor_kamar` varchar(10) NOT NULL,
  `tipe_kamar` varchar(50) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `status` enum('tersedia','dipesan','ditempati') DEFAULT 'tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kamar`
--

INSERT INTO `kamar` (`id`, `nomor_kamar`, `tipe_kamar`, `harga`, `status`) VALUES
(1, '101', 'Regular', 500000.00, 'tersedia'),
(2, '102', 'Regular', 500000.00, 'tersedia'),
(3, '103', 'Regular', 500000.00, 'tersedia'),
(4, '201', 'Luxury', 1000000.00, 'dipesan'),
(5, '202', 'Luxury', 1000000.00, 'dipesan'),
(6, '203', 'Luxury', 1000000.00, 'dipesan'),
(7, '301', 'President', 2000000.00, 'dipesan'),
(8, '302', 'President', 2000000.00, 'dipesan'),
(9, '104', 'Regular', 500000.00, 'tersedia'),
(10, '111', 'Regular', 500000.00, 'tersedia'),
(11, '122', 'Regular', 500000.00, 'tersedia'),
(12, '133', 'Regular', 500000.00, 'tersedia'),
(13, '211', 'Luxury', 1000000.00, 'dipesan'),
(14, '222', 'Luxury', 1000000.00, 'dipesan'),
(15, '233', 'Luxury', 1000000.00, 'dipesan'),
(16, '311', 'President', 2000000.00, 'tersedia'),
(17, '322', 'President', 2000000.00, 'tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `reservasi`
--

CREATE TABLE `reservasi` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `kamar_id` int DEFAULT NULL,
  `tanggal_check_in` date NOT NULL,
  `tanggal_check_out` date NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `status` enum('menunggu','dikonfirmasi','selesai','dibatalkan') DEFAULT 'menunggu',
  `username` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reservasi`
--

INSERT INTO `reservasi` (`id`, `user_id`, `kamar_id`, `tanggal_check_in`, `tanggal_check_out`, `total_harga`, `status`, `username`) VALUES
(2, NULL, 4, '2025-01-22', '2025-01-24', 2000000.00, 'menunggu', NULL),
(3, NULL, 4, '2025-01-22', '2025-01-24', 2000000.00, 'menunggu', NULL),
(4, NULL, 4, '2025-01-22', '2025-01-23', 1000000.00, 'menunggu', NULL),
(5, NULL, 9, '2025-01-22', '2025-01-25', 1500000.00, 'menunggu', NULL),
(6, NULL, 5, '2025-01-22', '2025-01-24', 2000000.00, 'menunggu', NULL),
(7, NULL, 6, '2025-01-22', '2025-01-24', 2000000.00, 'menunggu', NULL),
(10, NULL, 7, '2025-01-22', '2025-01-23', 2000000.00, 'menunggu', 'root'),
(11, NULL, 8, '2025-01-22', '2025-01-23', 2000000.00, 'menunggu', 'root');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','resepsionis','tamu') DEFAULT 'tamu',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Kenzie', 'yasirkenzie@gmail.com', '$2y$10$qcJrQmyxnRTSpi/cR4IPy.E2kE2/D.VFVSdMvBEye.vRNiSAHb5D6', 'tamu', '2025-01-22 05:01:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kamar`
--
ALTER TABLE `kamar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nomor_kamar` (`nomor_kamar`);

--
-- Indexes for table `reservasi`
--
ALTER TABLE `reservasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `kamar_id` (`kamar_id`),
  ADD KEY `fk_username` (`username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kamar`
--
ALTER TABLE `kamar`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `reservasi`
--
ALTER TABLE `reservasi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservasi`
--
ALTER TABLE `reservasi`
  ADD CONSTRAINT `reservasi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reservasi_ibfk_2` FOREIGN KEY (`kamar_id`) REFERENCES `kamar` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
