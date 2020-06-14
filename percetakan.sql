-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2020 at 06:42 PM
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
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id_customer` int(11) NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `address_1` varchar(200) NOT NULL,
  `address_2` varchar(200) NOT NULL,
  `phone_1` varchar(20) NOT NULL,
  `phone_2` varchar(20) NOT NULL,
  `status` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_date` date NOT NULL,
  `updated_by` int(11) NOT NULL,
  `email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id_customer`, `first_name`, `last_name`, `address_1`, `address_2`, `phone_1`, `phone_2`, `status`, `created_date`, `created_by`, `updated_date`, `updated_by`, `email`) VALUES
(3, 'Abdul', 'Azis2', 'taman kodok\r\nmaju mundur', 'jakarta barat', '08999110799', '021-5550900', 1, '2020-06-07', 5, '2020-06-14', 5, 'a@yahoo.com'),
(4, 'Abdul', 'Azis1', '', '', '', '', 1, '2020-06-07', 5, '2020-06-14', 5, '');

-- --------------------------------------------------------

--
-- Table structure for table `header_pengeluaran`
--

CREATE TABLE `header_pengeluaran` (
  `id_header_pengeluaran` bigint(20) NOT NULL,
  `tgl_pengeluaran` date NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_date` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `keterangan_delete` varchar(200) NOT NULL,
  `total` int(11) NOT NULL,
  `status_delete` int(11) NOT NULL,
  `deleted_date` date NOT NULL,
  `deleted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `header_pengeluaran`
--

INSERT INTO `header_pengeluaran` (`id_header_pengeluaran`, `tgl_pengeluaran`, `created_by`, `created_date`, `updated_by`, `updated_date`, `status`, `keterangan_delete`, `total`, `status_delete`, `deleted_date`, `deleted_by`) VALUES
(1, '2020-06-14', 5, '2020-06-14 23:10:00', 0, '0000-00-00 00:00:00', 0, '', 10000, 0, '0000-00-00', 0);

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
  `status` int(11) NOT NULL,
  `createdBy` bigint(20) NOT NULL,
  `createdDate` datetime NOT NULL,
  `updatedBy` bigint(20) NOT NULL,
  `updatedDate` datetime NOT NULL,
  `nomor_penjualan` varchar(500) NOT NULL,
  `status_delete` int(11) NOT NULL,
  `keterangan_delete` varchar(200) NOT NULL,
  `deleted_by` int(11) NOT NULL,
  `deleted_date` date NOT NULL,
  `status_pembayaran` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `header_penjualan`
--

INSERT INTO `header_penjualan` (`id_header_penjualan`, `tgl_penjualan`, `total`, `discount`, `dp1`, `dp2`, `grandtotal`, `metode_pembayaran`, `sisa_pembayaran`, `status`, `createdBy`, `createdDate`, `updatedBy`, `updatedDate`, `nomor_penjualan`, `status_delete`, `keterangan_delete`, `deleted_by`, `deleted_date`, `status_pembayaran`, `id_customer`) VALUES
(1, '2020-06-14', 15000, 0, 0, 0, 15000, 1, 0, 1, 5, '2020-06-14 22:54:16', 5, '2020-06-14 22:55:08', '03/INV/20/06/0001', 0, '', 0, '0000-00-00', 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `history_price`
--

CREATE TABLE `history_price` (
  `id_history` bigint(20) NOT NULL,
  `harga` int(11) NOT NULL,
  `id_item` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(6, 1, 5000, 0, 'Jasa print black', 0),
(7, 2, 3000, 0, 'Jasa print warna', 1),
(8, 1, 50000, 0, 'Jasa Desain 1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id_location` bigint(20) NOT NULL,
  `nama_location` varchar(200) NOT NULL,
  `alamat_location` varchar(500) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id_location`, `nama_location`, `alamat_location`, `status`) VALUES
(2, 'test', 'test', 1),
(3, 'test2', 'test', 1);

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
  `id_header_pengeluaran` bigint(20) NOT NULL,
  `status_delete` int(11) NOT NULL DEFAULT '0',
  `deleted_date` date NOT NULL,
  `deleted_by` int(11) NOT NULL,
  `keterangan_delete` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengeluaran`
--

INSERT INTO `pengeluaran` (`id_pengeluaran`, `item`, `price`, `keterangan`, `created_date`, `created_by`, `updated_date`, `updated_by`, `status`, `id_header_pengeluaran`, `status_delete`, `deleted_date`, `deleted_by`, `keterangan_delete`) VALUES
(3, 'Bensin', 10000, '', '2020-06-14', 5, '0000-00-00', 0, 0, 1, 0, '0000-00-00', 0, ''),
(4, 'Gula', 10000, '', '2020-06-14', 5, '0000-00-00', 0, 0, 1, 1, '2020-06-14', 5, 'coba saja'),
(5, 'Gula', 13000, '', '2020-06-14', 5, '0000-00-00', 0, 0, 1, 1, '2020-06-14', 5, 'res');

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
  `line_item` varchar(200) DEFAULT NULL,
  `keterangan` varchar(250) DEFAULT NULL,
  `status_delete` int(11) NOT NULL,
  `keterangan_delete` varchar(200) NOT NULL,
  `deleted_by` int(11) NOT NULL,
  `deleted_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `id_item`, `qty`, `id_satuan`, `harga_satuan`, `total_harga`, `id_user`, `created_date`, `created_by`, `updated_date`, `updated_by`, `id_header_penjualan`, `status`, `line_item`, `keterangan`, `status_delete`, `keterangan_delete`, `deleted_by`, `deleted_date`) VALUES
(27, 6, 1, 1, 5000, 5000, 5, '2020-06-14', 5, '0000-00-00', 0, 1, 1, NULL, '', 0, '', 0, '0000-00-00'),
(28, 6, 2, 1, 5000, 10000, 5, '2020-06-14', 5, '0000-00-00', 0, 1, 1, NULL, '', 0, '', 0, '0000-00-00');

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
  `nama` varchar(200) NOT NULL,
  `id_location` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `role`, `nama`, `id_location`) VALUES
(4, 'test1', '827ccb0eea8a706c4c34a16891f84e7b', 2, 'test', 0),
(5, 'administrator', '827ccb0eea8a706c4c34a16891f84e7b', 1, 'administrator1', 3),
(6, 'operator', '827ccb0eea8a706c4c34a16891f84e7b', 3, 'operator', 0),
(8, 'test', '827ccb0eea8a706c4c34a16891f84e7b', 2, 'test2', 2),
(9, 'administrator2', '827ccb0eea8a706c4c34a16891f84e7b', 1, 'administrator2', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id_customer`);

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
-- Indexes for table `history_price`
--
ALTER TABLE `history_price`
  ADD PRIMARY KEY (`id_history`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id_item`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id_location`);

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
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id_customer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- AUTO_INCREMENT for table `history_price`
--
ALTER TABLE `history_price`
  MODIFY `id_history` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id_item` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id_location` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id_pengeluaran` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id_satuan` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
