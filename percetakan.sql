-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 05 Des 2020 pada 15.35
-- Versi server: 10.4.14-MariaDB
-- Versi PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Struktur dari tabel `customer`
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
  `email` varchar(200) NOT NULL,
  `is_deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `customer`
--

INSERT INTO `customer` (`id_customer`, `first_name`, `last_name`, `address_1`, `address_2`, `phone_1`, `phone_2`, `status`, `created_date`, `created_by`, `updated_date`, `updated_by`, `email`, `is_deleted`) VALUES
(1, 'Abdul', 'Azis', 'test', '', '08232332', '', 1, '2020-08-12', 5, '0000-00-00', 0, 'abdul@gmail.com', 0),
(2, 'sas', 'sa', 'asd', 'sad', 'da', 'sad', 0, '2020-08-21', 5, '0000-00-00', 0, 'da', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `header_pengeluaran`
--

CREATE TABLE `header_pengeluaran` (
  `id_header_pengeluaran` bigint(20) NOT NULL,
  `tgl_pengeluaran` date NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_date` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `keterangan_delete` varchar(200) NOT NULL,
  `total` int(11) NOT NULL,
  `status_delete` int(11) NOT NULL,
  `deleted_date` date NOT NULL,
  `deleted_by` int(11) NOT NULL,
  `nomor_pengeluaran` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `header_penjualan`
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
  `id_customer` int(11) NOT NULL,
  `counter_dp1` int(11) NOT NULL,
  `counter_dp2` int(11) NOT NULL,
  `counter_lunas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `history_price`
--

CREATE TABLE `history_price` (
  `id_history` bigint(20) NOT NULL,
  `harga` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `history_price`
--

INSERT INTO `history_price` (`id_history`, `harga`, `id_item`, `updated_by`, `updated_date`) VALUES
(1, 10000, 13, 5, '2020-12-05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `item`
--

CREATE TABLE `item` (
  `id_item` bigint(20) NOT NULL,
  `id_satuan` bigint(20) NOT NULL,
  `harga` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `is_design` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `item`
--

INSERT INTO `item` (`id_item`, `id_satuan`, `harga`, `discount`, `nama`, `is_design`, `is_deleted`, `status`) VALUES
(12, 1, 10000, 0, 'banner', 1, 0, 0),
(13, 1, 15000, 0, 'pensil', 0, 0, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `location`
--

CREATE TABLE `location` (
  `id_location` bigint(20) NOT NULL,
  `name_location` varchar(200) NOT NULL,
  `address_location` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `tlp` varchar(100) NOT NULL,
  `ig` varchar(100) NOT NULL,
  `is_deleted` int(11) DEFAULT NULL,
  `bank_account` varchar(100) NOT NULL,
  `bank_account_name` varchar(150) NOT NULL,
  `bank_no` varchar(20) NOT NULL,
  `code_location` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `location`
--

INSERT INTO `location` (`id_location`, `name_location`, `address_location`, `status`, `email`, `tlp`, `ig`, `is_deleted`, `bank_account`, `bank_account_name`, `bank_no`, `code_location`) VALUES
(4, 'kapuk', '<p>kapuk</p>\n', 1, 'i@gmail.com', '09121', 'kapuk', 0, 'test', 'test', '123', '04'),
(5, 'balige', '<p>balige</p>\r\n', 1, 'info@indomilk.com', '02323', 'info', 1, 'BRI', 'test23', '3424', '01'),
(8, 'test', '<p>rer</p>\r\n', 1, 'd', '3', 'r', 0, 'g', 'r', '5', '05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `id_pengeluaran` bigint(20) NOT NULL,
  `item` varchar(200) NOT NULL,
  `price` int(11) NOT NULL,
  `keterangan` varchar(200) DEFAULT NULL,
  `created_date` date NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `updated_date` date DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `id_header_pengeluaran` bigint(20) NOT NULL,
  `status_delete` int(11) NOT NULL DEFAULT 0,
  `deleted_date` date DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `keterangan_delete` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` bigint(20) NOT NULL,
  `id_item` bigint(20) NOT NULL,
  `qty` float NOT NULL,
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

-- --------------------------------------------------------

--
-- Struktur dari tabel `satuan`
--

CREATE TABLE `satuan` (
  `satuan` varchar(200) NOT NULL,
  `id_satuan` bigint(20) NOT NULL,
  `status` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `satuan`
--

INSERT INTO `satuan` (`satuan`, `id_satuan`, `status`, `is_deleted`) VALUES
('unit', 1, 1, 0),
('buah', 2, 1, 0),
('pcs', 3, 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` bigint(20) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `id_location` bigint(20) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `role`, `nama`, `id_location`, `is_deleted`, `status`) VALUES
(5, 'administrator', '827ccb0eea8a706c4c34a16891f84e7b', 1, 'administrator1', 4, 0, 1),
(6, 'operator', '827ccb0eea8a706c4c34a16891f84e7b', 3, 'operator123', 5, 0, 1),
(8, 'test', '827ccb0eea8a706c4c34a16891f84e7b', 2, 'test2', 4, 0, 1),
(9, 'administrator2', '827ccb0eea8a706c4c34a16891f84e7b', 1, 'administrator2', 4, 0, 1),
(10, 'test2', '827ccb0eea8a706c4c34a16891f84e7b', 2, 'test1', 8, 0, 1),
(11, 'test43', '827ccb0eea8a706c4c34a16891f84e7b', 2, 'test43', 5, 1, 1),
(12, 'operator2', '827ccb0eea8a706c4c34a16891f84e7b', 3, 'operator2', 4, 0, 1),
(13, 'operator1234', '827ccb0eea8a706c4c34a16891f84e7b', 3, 'operator1234', 5, 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id_customer`);

--
-- Indeks untuk tabel `header_pengeluaran`
--
ALTER TABLE `header_pengeluaran`
  ADD PRIMARY KEY (`id_header_pengeluaran`);

--
-- Indeks untuk tabel `header_penjualan`
--
ALTER TABLE `header_penjualan`
  ADD PRIMARY KEY (`id_header_penjualan`);

--
-- Indeks untuk tabel `history_price`
--
ALTER TABLE `history_price`
  ADD PRIMARY KEY (`id_history`);

--
-- Indeks untuk tabel `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id_item`);

--
-- Indeks untuk tabel `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id_location`);

--
-- Indeks untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id_pengeluaran`);

--
-- Indeks untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indeks untuk tabel `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `customer`
--
ALTER TABLE `customer`
  MODIFY `id_customer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `header_pengeluaran`
--
ALTER TABLE `header_pengeluaran`
  MODIFY `id_header_pengeluaran` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `header_penjualan`
--
ALTER TABLE `header_penjualan`
  MODIFY `id_header_penjualan` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `history_price`
--
ALTER TABLE `history_price`
  MODIFY `id_history` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `item`
--
ALTER TABLE `item`
  MODIFY `id_item` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `location`
--
ALTER TABLE `location`
  MODIFY `id_location` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id_pengeluaran` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT untuk tabel `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id_satuan` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
