-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2023 at 09:42 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_akun`
--

INSERT INTO `tb_akun` (`id_akun`, `nama`, `id_kategori_akun`, `sifat`, `created_at`, `update_at`) VALUES
('101', 'Modal', 5, 'Kredit', '2023-11-19 22:08:40', '2023-11-19 22:08:40'),
('102', 'Prive', 5, 'Debit', '2023-11-19 23:15:46', '2023-11-19 23:15:46'),
('110', 'Pendapatan Penjualan', 5, 'Kredit', '2023-11-22 00:20:05', '2023-11-22 00:20:05'),
('111', 'Penjualan', 5, 'Debet', '2023-11-22 00:19:49', '2023-11-22 00:19:49');

-- --------------------------------------------------------

--
-- Table structure for table `tb_barang`
--

CREATE TABLE `tb_barang` (
  `id` int(11) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `harga_barang_masuk` int(11) NOT NULL,
  `harga_barang_keluar` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail_jurnal`
--

CREATE TABLE `tb_detail_jurnal` (
  `id` varchar(255) NOT NULL,
  `id_jurnal` varchar(255) NOT NULL,
  `id_akun` varchar(50) NOT NULL,
  `debet` int(11) NOT NULL,
  `kredit` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail_trans_keluar`
--

CREATE TABLE `tb_detail_trans_keluar` (
  `id` varchar(255) NOT NULL,
  `id_transaksi_keluar` varchar(255) NOT NULL,
  `id_akun` varchar(50) NOT NULL,
  `debet` int(11) NOT NULL,
  `kredit` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail_trans_masuk`
--

CREATE TABLE `tb_detail_trans_masuk` (
  `id` varchar(255) NOT NULL,
  `id_transaksi_masuk` varchar(255) NOT NULL,
  `id_akun` varchar(50) NOT NULL,
  `debet` int(11) NOT NULL,
  `kredit` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_jurnal`
--

CREATE TABLE `tb_jurnal` (
  `id_jurnal` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `type_transaksi` int(11) NOT NULL,
  `tgl_jurnal` date NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_kategori_akun`
--

CREATE TABLE `tb_kategori_akun` (
  `id_kategori_akun` int(11) NOT NULL,
  `nama_kategori` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL,
  `update_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_kategori_akun`
--

INSERT INTO `tb_kategori_akun` (`id_kategori_akun`, `nama_kategori`, `created_at`, `update_at`) VALUES
(5, '-', '2023-11-07 23:14:33', '2023-11-07 23:14:33');

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi_keluar`
--

CREATE TABLE `tb_transaksi_keluar` (
  `id_transaksi_keluar` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `type_transaksi` int(11) NOT NULL,
  `tgl_trans_keluar` date NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi_masuk`
--

CREATE TABLE `tb_transaksi_masuk` (
  `id_transaksi_masuk` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `type_transaksi` int(11) NOT NULL,
  `tgl_trans_masuk` date NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `nama`, `email`, `username`, `password`, `level`, `status`, `foto`, `created_at`, `updated_at`) VALUES
(22, 'admin', 'admin@gmail.com', 'admin', '$2y$10$9pXUd0AJ/9w2OOjb9weKmuiKTBBT4/McwqKDlOAtnKHgMOU1j2flC', 1, 1, '65350c97726c4_1697975447.png', '2023-10-22', '2023-10-22'),
(24, 'Pimpinan', 'pimpinan@gmail.com', 'pimpinan', '$2y$10$37OUwkTpM9Udi8k3HuqVA.VBgX/O4xP3l6o57Yaluv6YJ4k71/A8q', 2, 1, '654dbe273937b_1699593767.jpg', '2023-11-10', '2023-11-10'),
(25, 'Akunting', 'akunting@gmail.com', 'akunting', '$2y$10$aNhKCSrv7.LW2SzAawN5SeCIz2dOWXJdWgO9aNzlV5S.n7bUz6mTq', 3, 1, '-', '2023-11-10', '2023-11-10');

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
-- Indexes for table `tb_barang`
--
ALTER TABLE `tb_barang`
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
-- AUTO_INCREMENT for table `tb_barang`
--
ALTER TABLE `tb_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_kategori_akun`
--
ALTER TABLE `tb_kategori_akun`
  MODIFY `id_kategori_akun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

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
