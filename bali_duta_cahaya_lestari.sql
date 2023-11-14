-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2023 at 12:08 AM
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
('101', 'Kas', 5, 'Debet', '2023-11-07 23:15:01', '2023-11-07 23:15:01'),
('103', 'Piutang Dagang', 5, 'Debet', '2023-11-07 23:15:32', '2023-11-07 23:15:32'),
('104', 'Persediaan Barang Dagang', 5, 'Debet', '2023-11-07 23:16:02', '2023-11-07 23:16:02'),
('203', 'Hutang Dagang', 5, 'Kredit', '2023-11-07 23:16:24', '2023-11-07 23:16:24'),
('222', 'Modal PT', 5, 'Kredit', '2023-11-07 23:16:53', '2023-11-07 23:16:53'),
('324', 'Prive PT', 5, 'Debet', '2023-11-07 23:17:17', '2023-11-07 23:17:17'),
('401', 'Penjualan', 5, 'Kredit', '2023-11-07 23:17:37', '2023-11-07 23:17:37'),
('402', 'Return Penjualan', 5, 'Debet', '2023-11-07 23:18:02', '2023-11-07 23:18:02'),
('404', 'Potongan Penjualan', 5, 'Debet', '2023-11-07 23:18:29', '2023-11-07 23:18:29');

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

--
-- Dumping data for table `tb_detail_jurnal`
--

INSERT INTO `tb_detail_jurnal` (`id`, `id_jurnal`, `id_akun`, `debet`, `kredit`, `created_at`, `update_at`) VALUES
(10, 'JRL-202311111946160001', '101', 500000000, 0, '2023-11-12 02:46:20', '2023-11-12 02:46:20'),
(11, 'JRL-202311111948370001', '222', 0, 500000000, '2023-11-12 02:48:56', '2023-11-12 02:48:56'),
(12, 'JRL-202311111949520001', '103', 0, 10000000, '2023-11-12 02:50:16', '2023-11-12 02:50:16'),
(13, 'JRL-202311111951110001', '203', 10000000, 0, '2023-11-12 02:51:21', '2023-11-12 02:51:21');

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
(5, 'TRX-202311121739480001', '101', 0, 1000000, '2023-11-13 00:43:00', '2023-11-13 00:43:00');

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
(33, 'TRX-202311071642190001', '101', 2000000, 10000, '2023-11-07 23:44:07', '2023-11-07 23:44:07'),
(34, 'TRX-202311121739270001', '101', 0, 1000000, '2023-11-13 00:39:37', '2023-11-13 00:39:37');

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

--
-- Dumping data for table `tb_jurnal`
--

INSERT INTO `tb_jurnal` (`id_jurnal`, `id_keterangan`, `tgl_jurnal`, `created_at`, `update_at`) VALUES
('JRL-202311111946160001', 7, '2023-11-05', '2023-11-12 02:48:29', '2023-11-12 02:48:29'),
('JRL-202311111948370001', 7, '2023-11-05', '2023-11-12 02:49:09', '2023-11-12 02:49:09'),
('JRL-202311111949520001', 7, '2023-11-12', '2023-11-12 02:50:27', '2023-11-12 02:50:27'),
('JRL-202311111951110001', 7, '2023-11-12', '2023-11-12 02:51:27', '2023-11-12 02:51:27');

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
(5, '-', '2023-11-07 23:14:33', '2023-11-07 23:14:33');

-- --------------------------------------------------------

--
-- Table structure for table `tb_keterangan`
--

CREATE TABLE `tb_keterangan` (
  `id` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `type_keterangan` int(11) NOT NULL,
  `type_transaksi` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_keterangan`
--

INSERT INTO `tb_keterangan` (`id`, `keterangan`, `type_keterangan`, `type_transaksi`, `created_at`, `update_at`) VALUES
(2, 'Pembelian Buku', 1, 2, '2023-10-22 23:15:51', '2023-10-22 23:15:51'),
(3, 'Penjualan Buku', 1, 1, '2023-10-22 23:16:26', '2023-10-22 23:16:26'),
(7, 'Tidak Ada Keterangan', 0, 3, '2023-11-12 02:46:11', '2023-11-12 02:46:11');

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

--
-- Dumping data for table `tb_transaksi_keluar`
--

INSERT INTO `tb_transaksi_keluar` (`id_transaksi_keluar`, `id_keterangan`, `tgl_trans_keluar`, `created_at`, `update_at`) VALUES
('TRX-202311121739480001', 2, '2023-11-13', '2023-11-13 00:43:08', '2023-11-13 00:43:08');

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

--
-- Dumping data for table `tb_transaksi_masuk`
--

INSERT INTO `tb_transaksi_masuk` (`id_transaksi_masuk`, `id_keterangan`, `tgl_trans_masuk`, `created_at`, `update_at`) VALUES
('TRX-202311071642190001', 3, '2023-11-07', '2023-11-07 23:44:40', '2023-11-07 23:44:40'),
('TRX-202311121739270001', 3, '2023-11-13', '2023-11-13 00:39:44', '2023-11-13 00:39:44');

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
(22, 'admin', 'admin@gmail.com', 'admin', '$2y$10$9pXUd0AJ/9w2OOjb9weKmuiKTBBT4/McwqKDlOAtnKHgMOU1j2flC', 1, 1, '65350c97726c4_1697975447.png', '2023-10-22', '2023-10-22'),
(24, 'Pimpinan', 'pimpinan@gmail.com', 'pimpinan', '$2y$10$37OUwkTpM9Udi8k3HuqVA.VBgX/O4xP3l6o57Yaluv6YJ4k71/A8q', 2, 1, '654dbe273937b_1699593767.jpg', '2023-11-10', '2023-11-10'),
(25, 'Akunting', 'akunting@gmail.com', 'akunting', '$2y$10$aNhKCSrv7.LW2SzAawN5SeCIz2dOWXJdWgO9aNzlV5S.n7bUz6mTq', 3, 1, '654dbe60e32d2_1699593824.jpg', '2023-11-10', '2023-11-10');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tb_detail_trans_keluar`
--
ALTER TABLE `tb_detail_trans_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_detail_trans_masuk`
--
ALTER TABLE `tb_detail_trans_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tb_kategori_akun`
--
ALTER TABLE `tb_kategori_akun`
  MODIFY `id_kategori_akun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_keterangan`
--
ALTER TABLE `tb_keterangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
