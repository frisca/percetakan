-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 05 Jun 2020 pada 17.00
-- Versi server: 10.1.37-MariaDB
-- Versi PHP: 5.6.39

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
  `email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `customer`
--

INSERT INTO `customer` (`id_customer`, `first_name`, `last_name`, `address_1`, `address_2`, `phone_1`, `phone_2`, `status`, `created_date`, `created_by`, `updated_date`, `updated_by`, `email`) VALUES
(1, 'testt', 'test', 'tes', '', '0432', '', 1, '0000-00-00', 5, '0000-00-00', 0, 'test@gmail.com'),
(2, 'test', 'testing', '123', '', '01212', '', 1, '2020-06-05', 5, '0000-00-00', 0, 'test@gmail.com');

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
  `status` int(11) NOT NULL DEFAULT '1',
  `keterangan_delete` varchar(200) NOT NULL,
  `total` int(11) NOT NULL,
  `status_delete` int(11) NOT NULL,
  `deleted_date` date NOT NULL,
  `deleted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `header_pengeluaran`
--

INSERT INTO `header_pengeluaran` (`id_header_pengeluaran`, `tgl_pengeluaran`, `created_by`, `created_date`, `updated_by`, `updated_date`, `status`, `keterangan_delete`, `total`, `status_delete`, `deleted_date`, `deleted_by`) VALUES
(1, '2020-06-05', 5, '2020-06-05 20:00:45', 5, '2020-06-05 00:00:00', 0, '', 3000, 0, '0000-00-00', 0);

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
  `id_customer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `header_penjualan`
--

INSERT INTO `header_penjualan` (`id_header_penjualan`, `tgl_penjualan`, `total`, `discount`, `dp1`, `dp2`, `grandtotal`, `metode_pembayaran`, `sisa_pembayaran`, `status`, `createdBy`, `createdDate`, `updatedBy`, `updatedDate`, `nomor_penjualan`, `status_delete`, `keterangan_delete`, `deleted_by`, `deleted_date`, `status_pembayaran`, `id_customer`) VALUES
(1, '2020-06-05', 40000, 0, 0, 0, 40000, 0, 0, 0, 5, '2020-06-05 19:22:13', 5, '1970-01-01 01:00:00', '', 1, '0', 5, '2020-06-05', 0, 0),
(2, '2020-06-05', 20000, 0, 0, 0, 20000, 0, 0, 0, 5, '2020-06-05 19:22:33', 5, '1970-01-01 01:00:00', '', 1, '0', 5, '2020-06-05', 0, 0),
(3, '2020-06-05', 50000, 1000, 10000, 39000, 49000, 2, 0, 1, 5, '2020-06-05 19:23:13', 5, '2020-06-05 19:34:42', 'INV/20/06/0003', 0, '', 0, '0000-00-00', 1, 0),
(4, '2020-06-05', 40000, 0, 0, 0, 40000, 0, 0, 0, 5, '2020-06-05 19:35:02', 5, '1970-01-01 01:00:00', '', 0, '', 0, '0000-00-00', 0, 0),
(5, '2020-06-05', 0, 0, 0, 0, 0, 0, 0, 0, 5, '2020-06-05 21:43:57', 0, '0000-00-00 00:00:00', '', 0, '', 0, '0000-00-00', 0, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `history_price`
--

CREATE TABLE `history_price` (
  `id_history` bigint(20) NOT NULL,
  `harga` int(11) NOT NULL,
  `id_item` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `history_price`
--

INSERT INTO `history_price` (`id_history`, `harga`, `id_item`) VALUES
(1, 20000, 7);

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
  `is_design` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `item`
--

INSERT INTO `item` (`id_item`, `id_satuan`, `harga`, `discount`, `nama`, `is_design`) VALUES
(3, 1, 10000, 0, 'Pulpen', 0),
(6, 1, 10000, 0, 'test', 1),
(7, 1, 10000, 0, 'Buku', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `location`
--

CREATE TABLE `location` (
  `id_location` bigint(20) NOT NULL,
  `nama_location` varchar(200) NOT NULL,
  `alamat_location` varchar(500) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `location`
--

INSERT INTO `location` (`id_location`, `nama_location`, `alamat_location`, `status`) VALUES
(2, 'test', 'test', 1),
(3, 'test2', 'test', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengeluaran`
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
-- Dumping data untuk tabel `pengeluaran`
--

INSERT INTO `pengeluaran` (`id_pengeluaran`, `item`, `price`, `keterangan`, `created_date`, `created_by`, `updated_date`, `updated_by`, `status`, `id_header_pengeluaran`, `status_delete`, `deleted_date`, `deleted_by`, `keterangan_delete`) VALUES
(11, 'bensin', 1000, '', '2020-06-05', 5, '2020-06-05', 5, 0, 1, 0, '0000-00-00', 0, ''),
(12, 'rokok', 2000, '', '2020-06-05', 5, '0000-00-00', 0, 0, 1, 0, '0000-00-00', 0, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
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
-- Dumping data untuk tabel `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `id_item`, `qty`, `id_satuan`, `harga_satuan`, `total_harga`, `id_user`, `created_date`, `created_by`, `updated_date`, `updated_by`, `id_header_penjualan`, `status`, `line_item`, `keterangan`, `status_delete`, `keterangan_delete`, `deleted_by`, `deleted_date`) VALUES
(80, 3, 4, 1, 10000, 40000, 5, '2020-06-05', 5, '0000-00-00', 0, 1, 0, NULL, '', 0, '', 0, '0000-00-00'),
(81, 6, 2, 1, 10000, 20000, 5, '2020-06-05', 5, '0000-00-00', 0, 2, 0, NULL, '', 0, '', 0, '0000-00-00'),
(82, 3, 1, 1, 10000, 10000, 5, '2020-06-05', 5, '0000-00-00', 0, 3, 1, NULL, '', 0, '', 0, '0000-00-00'),
(83, 3, 3, 1, 10000, 30000, 5, '2020-06-05', 5, '0000-00-00', 0, 3, 1, NULL, '', 0, '', 0, '0000-00-00'),
(84, 3, 1, 1, 10000, 10000, 5, '2020-06-05', 5, '0000-00-00', 0, 3, 1, NULL, '', 0, '', 0, '0000-00-00'),
(85, 6, 4, 1, 10000, 40000, 5, '2020-06-05', 5, '2020-06-05', 5, 4, 0, '1591361940example.png', '', 0, '', 0, '0000-00-00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `satuan`
--

CREATE TABLE `satuan` (
  `satuan` varchar(200) NOT NULL,
  `id_satuan` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `satuan`
--

INSERT INTO `satuan` (`satuan`, `id_satuan`) VALUES
('unit', 1),
('buah', 2);

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
  `id_location` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `role`, `nama`, `id_location`) VALUES
(4, 'test1', '827ccb0eea8a706c4c34a16891f84e7b', 2, 'test', 0),
(5, 'administrator', '827ccb0eea8a706c4c34a16891f84e7b', 1, 'administrator1', 0),
(6, 'operator', '827ccb0eea8a706c4c34a16891f84e7b', 3, 'operator', 0),
(8, 'test', '827ccb0eea8a706c4c34a16891f84e7b', 2, 'test2', 2),
(9, 'administrator2', '827ccb0eea8a706c4c34a16891f84e7b', 1, 'administrator2', 2);

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
  MODIFY `id_header_penjualan` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `history_price`
--
ALTER TABLE `history_price`
  MODIFY `id_history` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `item`
--
ALTER TABLE `item`
  MODIFY `id_item` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `location`
--
ALTER TABLE `location`
  MODIFY `id_location` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id_pengeluaran` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT untuk tabel `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id_satuan` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
