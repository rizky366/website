-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2024 at 08:59 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parkir`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_kendaraan`
--

CREATE TABLE `tb_kendaraan` (
  `id_kendaraan` int(11) NOT NULL,
  `no_kendaraan` varchar(100) NOT NULL,
  `jenis_kendaraan` varchar(100) NOT NULL,
  `jam_masuk` varchar(100) NOT NULL,
  `jam_keluar` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `total_bayar` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_kendaraan`
--

INSERT INTO `tb_kendaraan` (`id_kendaraan`, `no_kendaraan`, `jenis_kendaraan`, `jam_masuk`, `jam_keluar`, `status`, `total_bayar`) VALUES
(11, 'B 5551 D', 'mobil', '01:28', '10:29', 'selesai', '50000'),
(12, 'testing', 'mobil', '11:15', '11:39', 'selesai', '5000'),
(13, 'tes', 'motor', '07:39', '11:40', 'selesai', '10000'),
(14, 'te2', 'motor', '10:56', '11:56', 'selesai', '2000'),
(15, 'merno', 'motor', '10:59', '11:59', 'selesai', '2000'),
(18, 'Cykablayat', 'mobil', '09:26', '16:58', 'selesai', '40000'),
(19, '12345', 'motor', '16:05', '17:05', 'selesai', '2000'),
(20, '12', 'motor', '04:08', '17:08', 'selesai', '26000'),
(21, '100', 'motor', '04:16', '17:17', 'selesai', '26000'),
(22, '200', 'motor', '03:17', '17:22', 'selesai', '28000'),
(23, '300', 'motor', '04:24', '17:24', 'selesai', '26000'),
(24, 'R 555 1', 'motor', '11:54', '', 'belum selesai', ''),
(25, 'R 555 12', 'motor', '12:54', '', 'belum selesai', '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_laporan_parkir`
--

CREATE TABLE `tb_laporan_parkir` (
  `id_laporan_parkir` int(11) NOT NULL,
  `id_kendaraan` int(10) NOT NULL,
  `id_petugas` int(10) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_laporan_parkir`
--

INSERT INTO `tb_laporan_parkir` (`id_laporan_parkir`, `id_kendaraan`, `id_petugas`, `tanggal`) VALUES
(1, 21, 4, '2024-07-26'),
(2, 22, 4, '2024-07-26'),
(3, 23, 4, '2024-07-26');

-- --------------------------------------------------------

--
-- Table structure for table `tb_petugas`
--

CREATE TABLE `tb_petugas` (
  `id_petugas` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `alamat` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_petugas`
--

INSERT INTO `tb_petugas` (`id_petugas`, `username`, `password`, `alamat`) VALUES
(1, 'admin123', 'admin123', 'cisondari'),
(2, 'admin2', 'admin2', 'cigondewah'),
(4, 'admin3', 'admin3', 'sukagalih'),
(5, 'admin5', 'admin5', 'kiaracondong'),
(6, 'admin6', 'admin6', 'karawang'),
(7, 'admin7', 'admin7', 'cigondewah'),
(9, 'admin8', 'admin8', 'sukagalih'),
(10, 'admin9', 'admin9', 'karawang');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_kendaraan`
--
ALTER TABLE `tb_kendaraan`
  ADD PRIMARY KEY (`id_kendaraan`);

--
-- Indexes for table `tb_laporan_parkir`
--
ALTER TABLE `tb_laporan_parkir`
  ADD PRIMARY KEY (`id_laporan_parkir`),
  ADD KEY `id_kendaraan` (`id_kendaraan`),
  ADD KEY `id_petugas` (`id_petugas`);

--
-- Indexes for table `tb_petugas`
--
ALTER TABLE `tb_petugas`
  ADD PRIMARY KEY (`id_petugas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_kendaraan`
--
ALTER TABLE `tb_kendaraan`
  MODIFY `id_kendaraan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tb_laporan_parkir`
--
ALTER TABLE `tb_laporan_parkir`
  MODIFY `id_laporan_parkir` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_petugas`
--
ALTER TABLE `tb_petugas`
  MODIFY `id_petugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_laporan_parkir`
--
ALTER TABLE `tb_laporan_parkir`
  ADD CONSTRAINT `tb_laporan_parkir_ibfk_1` FOREIGN KEY (`id_kendaraan`) REFERENCES `tb_kendaraan` (`id_kendaraan`),
  ADD CONSTRAINT `tb_laporan_parkir_ibfk_2` FOREIGN KEY (`id_petugas`) REFERENCES `tb_petugas` (`id_petugas`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
