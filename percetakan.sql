-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2020 at 09:20 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `percetakan`
--

-- --------------------------------------------------------

--
-- Table structure for table `header_pengeluaran`
--

CREATE TABLE `header_pengeluaran` (
  `id_header_pengeluaran` bigint(20) NOT NULL,
  `tgl_pengeluaran` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `header_pengeluaran`
--

INSERT INTO `header_pengeluaran` (`id_header_pengeluaran`, `tgl_pengeluaran`) VALUES
(1, '2020-04-07');

-- --------------------------------------------------------

--
-- Table structure for table `header_penjualan`
--

CREATE TABLE `header_penjualan` (
  `id_header_penjualan` bigint(20) NOT NULL,
  `tgl_penjualan` date NOT NULL,
  `total` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `dp1` int(11) NOT NULL,
  `dp2` int(11) NOT NULL,
  `grandtotal` int(11) NOT NULL,
  `metode_pembayaran` int(11) NOT NULL,
  `sisa_pembayaran` bigint(20) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `header_penjualan`
--

INSERT INTO `header_penjualan` (`id_header_penjualan`, `tgl_penjualan`, `total`, `discount`, `dp1`, `dp2`, `grandtotal`, `metode_pembayaran`, `sisa_pembayaran`, `status`) VALUES
(1, '2020-04-14', 20000, 1000, 13000, 6000, 19000, 2, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `id_item` bigint(20) NOT NULL,
  `id_satuan` bigint(20) NOT NULL,
  `harga` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `is_design` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id_item`, `id_satuan`, `harga`, `discount`, `nama`, `is_design`) VALUES
(3, 2, 10000, 0, 'Pulpen', 0),
(4, 2, 10000, 0, 'desain1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `id_pengeluaran` bigint(20) NOT NULL,
  `item` varchar(200) NOT NULL,
  `price` int(11) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `created_date` date NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `updated_date` date NOT NULL,
  `updated_by` bigint(20) NOT NULL,
  `status` int(11) NOT NULL,
  `id_header_pengeluaran` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` bigint(20) NOT NULL,
  `id_item` bigint(20) NOT NULL,
  `qty` bigint(20) NOT NULL,
  `id_satuan` bigint(20) NOT NULL,
  `harga_satuan` bigint(20) NOT NULL,
  `total_harga` bigint(20) NOT NULL,
  `id_user` bigint(20) NOT NULL,
  `created_date` date NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `updated_date` date NOT NULL,
  `updated_by` bigint(20) NOT NULL,
  `id_header_penjualan` bigint(20) NOT NULL,
  `status` int(11) NOT NULL,
  `line_item` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `id_item`, `qty`, `id_satuan`, `harga_satuan`, `total_harga`, `id_user`, `created_date`, `created_by`, `updated_date`, `updated_by`, `id_header_penjualan`, `status`, `line_item`) VALUES
(36, 3, 2, 2, 10000, 20000, 1, '2020-04-14', 1, '0000-00-00', 0, 1, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `satuan` varchar(200) NOT NULL,
  `id_satuan` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`satuan`, `id_satuan`) VALUES
('unit', 1),
('buah', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` bigint(20) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `role`, `nama`) VALUES
(1, 'administrator', '827ccb0eea8a706c4c34a16891f84e7b', 1, 'Administrator'),
(4, 'test1', '827ccb0eea8a706c4c34a16891f84e7b', 2, 'test'),
(5, 'administrator1', '827ccb0eea8a706c4c34a16891f84e7b', 1, 'administrator1'),
(6, 'operator', '827ccb0eea8a706c4c34a16891f84e7b', 3, 'operator');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `header_pengeluaran`
--
ALTER TABLE `header_pengeluaran`
  ADD PRIMARY KEY (`id_header_pengeluaran`);

--
-- Indexes for table `header_penjualan`
--
ALTER TABLE `header_penjualan`
  ADD PRIMARY KEY (`id_header_penjualan`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id_item`);

--
-- Indexes for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id_pengeluaran`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `header_pengeluaran`
--
ALTER TABLE `header_pengeluaran`
  MODIFY `id_header_pengeluaran` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `header_penjualan`
--
ALTER TABLE `header_penjualan`
  MODIFY `id_header_penjualan` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id_item` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id_pengeluaran` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id_satuan` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
