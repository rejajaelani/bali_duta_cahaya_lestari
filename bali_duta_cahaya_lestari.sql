-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2023 at 12:19 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bali_duta_cahaya_lestari`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_akun`
--

CREATE TABLE `tb_akun` (
  `id_akun` varchar(50) NOT NULL,
  `nama` varchar(250) NOT NULL,
  `id_kategori_akun` int(11) NOT NULL,
  `sifat` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `update_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_akun`
--

INSERT INTO `tb_akun` (`id_akun`, `nama`, `id_kategori_akun`, `sifat`, `created_at`, `update_at`) VALUES
('BFS11', 'Pembayaran BPJS', 1, 'Debit', '2023-10-23 09:04:39', '2023-10-23 09:04:39'),
('BFS12', 'Pembayaran Kas', 1, 'Debit', '2023-10-24 22:59:49', '2023-10-24 22:59:49'),
('BFS15', 'Pembayaran Gaji', 2, 'Kredit', '2023-10-24 23:00:55', '2023-10-24 23:00:55');

-- --------------------------------------------------------

--
-- Table structure for table `tb_alat`
--

CREATE TABLE `tb_alat` (
  `id` int(11) NOT NULL,
  `kode` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_alat`
--

INSERT INTO `tb_alat` (`id`, `kode`, `nama`, `created_at`, `update_at`) VALUES
(3, 'TEST-001', 'Sapu', '2023-10-22 19:18:59', '2023-10-22 19:31:16'),
(4, 'TEST-002', 'Tong Sampah', '2023-10-22 19:31:32', '2023-10-22 19:31:32');

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail_jurnal`
--

CREATE TABLE `tb_detail_jurnal` (
  `id` int(11) NOT NULL,
  `id_jurnal` varchar(255) NOT NULL,
  `id_akun` varchar(50) NOT NULL,
  `debet` int(11) NOT NULL,
  `kredit` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail_trans_keluar`
--

CREATE TABLE `tb_detail_trans_keluar` (
  `id` int(11) NOT NULL,
  `id_transaksi_keluar` varchar(255) NOT NULL,
  `id_akun` varchar(50) NOT NULL,
  `debet` int(11) NOT NULL,
  `kredit` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_detail_trans_keluar`
--

INSERT INTO `tb_detail_trans_keluar` (`id`, `id_transaksi_keluar`, `id_akun`, `debet`, `kredit`, `created_at`, `update_at`) VALUES
(3, 'TRX-202310241200560001', 'BFS11', 100, 0, '2023-10-24 18:01:16', '2023-10-24 18:01:16');

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail_trans_masuk`
--

CREATE TABLE `tb_detail_trans_masuk` (
  `id` int(11) NOT NULL,
  `id_transaksi_masuk` varchar(255) NOT NULL,
  `id_akun` varchar(50) NOT NULL,
  `debet` int(11) NOT NULL,
  `kredit` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_detail_trans_masuk`
--

INSERT INTO `tb_detail_trans_masuk` (`id`, `id_transaksi_masuk`, `id_akun`, `debet`, `kredit`, `created_at`, `update_at`) VALUES
(24, 'TRX-202310241158000001', 'BFS11', 100, 100000000, '2023-10-24 17:58:08', '2023-10-24 17:58:08');

-- --------------------------------------------------------

--
-- Table structure for table `tb_jurnal`
--

CREATE TABLE `tb_jurnal` (
  `id_jurnal` varchar(255) NOT NULL,
  `id_keterangan` int(11) NOT NULL,
  `tgl_jurnal` date NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_kategori_akun`
--

CREATE TABLE `tb_kategori_akun` (
  `id_kategori_akun` int(11) NOT NULL,
  `nama_kategori` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL,
  `update_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_kategori_akun`
--

INSERT INTO `tb_kategori_akun` (`id_kategori_akun`, `nama_kategori`, `created_at`, `update_at`) VALUES
(1, 'Diskon', '2023-10-15 01:12:16', '2023-10-15 01:12:16'),
(2, 'test', '2023-10-15 01:21:06', '2023-10-15 01:21:06'),
(3, 'test1', '2023-10-15 01:22:47', '2023-10-15 01:22:47'),
(4, 'test22', '2023-10-15 01:32:20', '2023-10-15 01:32:20');

-- --------------------------------------------------------

--
-- Table structure for table `tb_keterangan`
--

CREATE TABLE `tb_keterangan` (
  `id` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `type_transaksi` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_keterangan`
--

INSERT INTO `tb_keterangan` (`id`, `keterangan`, `type_transaksi`, `created_at`, `update_at`) VALUES
(2, 'Pembelian Buku', 2, '2023-10-22 23:15:51', '2023-10-22 23:15:51'),
(3, 'Penjualan Buku', 1, '2023-10-22 23:16:26', '2023-10-22 23:16:26');

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi_keluar`
--

CREATE TABLE `tb_transaksi_keluar` (
  `id_transaksi_keluar` varchar(255) NOT NULL,
  `id_keterangan` int(11) NOT NULL,
  `tgl_trans_keluar` date NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi_masuk`
--

CREATE TABLE `tb_transaksi_masuk` (
  `id_transaksi_masuk` varchar(255) NOT NULL,
  `id_keterangan` int(11) NOT NULL,
  `tgl_trans_masuk` date NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(250) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `foto` text DEFAULT NULL,
  `created_at` date DEFAULT current_timestamp(),
  `updated_at` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `nama`, `email`, `username`, `password`, `level`, `status`, `foto`, `created_at`, `updated_at`) VALUES
(1, 'test1', 'test1@gmail.com', 'test1', '$2y$10$tO.R8PkxCWbOrrusHxZpjeZcPY7APjsQ394s/LWCyRH38.so0k9BG', 3, 0, '65204dd137793_1696615889.jpeg', '2023-10-05', '2023-10-05'),
(22, 'admin', 'admin@gmail.com', 'admin', '$2y$10$9pXUd0AJ/9w2OOjb9weKmuiKTBBT4/McwqKDlOAtnKHgMOU1j2flC', 1, 1, '65350c97726c4_1697975447.png', '2023-10-22', '2023-10-22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_akun`
--
ALTER TABLE `tb_akun`
  ADD PRIMARY KEY (`id_akun`),
  ADD KEY `fk_tb_akun_tb_kategori_akun` (`id_kategori_akun`);

--
-- Indexes for table `tb_alat`
--
ALTER TABLE `tb_alat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_detail_jurnal`
--
ALTER TABLE `tb_detail_jurnal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_detail_trans_keluar`
--
ALTER TABLE `tb_detail_trans_keluar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_detail_trans_masuk`
--
ALTER TABLE `tb_detail_trans_masuk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_jurnal`
--
ALTER TABLE `tb_jurnal`
  ADD PRIMARY KEY (`id_jurnal`);

--
-- Indexes for table `tb_kategori_akun`
--
ALTER TABLE `tb_kategori_akun`
  ADD PRIMARY KEY (`id_kategori_akun`);

--
-- Indexes for table `tb_keterangan`
--
ALTER TABLE `tb_keterangan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_transaksi_keluar`
--
ALTER TABLE `tb_transaksi_keluar`
  ADD PRIMARY KEY (`id_transaksi_keluar`);

--
-- Indexes for table `tb_transaksi_masuk`
--
ALTER TABLE `tb_transaksi_masuk`
  ADD PRIMARY KEY (`id_transaksi_masuk`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_alat`
--
ALTER TABLE `tb_alat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_detail_jurnal`
--
ALTER TABLE `tb_detail_jurnal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_detail_trans_keluar`
--
ALTER TABLE `tb_detail_trans_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_detail_trans_masuk`
--
ALTER TABLE `tb_detail_trans_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tb_kategori_akun`
--
ALTER TABLE `tb_kategori_akun`
  MODIFY `id_kategori_akun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_keterangan`
--
ALTER TABLE `tb_keterangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_akun`
--
ALTER TABLE `tb_akun`
  ADD CONSTRAINT `fk_tb_akun_tb_kategori` FOREIGN KEY (`id_kategori_akun`) REFERENCES `tb_kategori_akun` (`id_kategori_akun`),
  ADD CONSTRAINT `fk_tb_akun_tb_kategori_akun` FOREIGN KEY (`id_kategori_akun`) REFERENCES `tb_kategori_akun` (`id_kategori_akun`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
