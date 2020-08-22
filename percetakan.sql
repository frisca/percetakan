-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 22 Agu 2020 pada 13.03
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
(1, 'Abdul', 'Azis', 'test', '', '08232332', '', 1, '2020-08-12', 5, '0000-00-00', 0, 'abdul@gmail.com'),
(2, 'sas', 'sa', 'asd', 'sad', 'da', 'sad', 0, '2020-08-21', 5, '0000-00-00', 0, 'da');

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
  `deleted_by` int(11) NOT NULL,
  `nomor_pengeluaran` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `header_pengeluaran`
--

INSERT INTO `header_pengeluaran` (`id_header_pengeluaran`, `tgl_pengeluaran`, `created_by`, `created_date`, `updated_by`, `updated_date`, `status`, `keterangan_delete`, `total`, `status_delete`, `deleted_date`, `deleted_by`, `nomor_pengeluaran`) VALUES
(1, '2020-08-22', 6, '2020-08-22 17:00:09', 13, '2020-08-22 00:00:00', 1, '', 12000, 0, '0000-00-00', 0, '05/OUT/20/08/0002');

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

--
-- Dumping data untuk tabel `header_penjualan`
--

INSERT INTO `header_penjualan` (`id_header_penjualan`, `tgl_penjualan`, `total`, `discount`, `dp1`, `dp2`, `grandtotal`, `metode_pembayaran`, `sisa_pembayaran`, `status`, `createdBy`, `createdDate`, `updatedBy`, `updatedDate`, `nomor_penjualan`, `status_delete`, `keterangan_delete`, `deleted_by`, `deleted_date`, `status_pembayaran`, `id_customer`, `counter_dp1`, `counter_dp2`, `counter_lunas`) VALUES
(1, '2020-08-20', 15000, 0, 0, 0, 15000, 1, 0, 1, 6, '2020-08-20 17:15:23', 6, '2020-08-20 17:24:34', '02/INV/20/08/0001', 0, '', 0, '0000-00-00', 1, 1, 0, 0, 0),
(2, '2020-08-20', 20000, 0, 5000, 0, 20000, 2, 15000, 1, 6, '2020-08-20 17:29:00', 6, '2020-08-20 17:36:49', '02/INV/20/08/0002', 0, '', 0, '0000-00-00', 2, 1, 1, 0, 0),
(3, '2020-08-20', 45000, 0, 5000, 0, 45000, 2, 40000, 1, 12, '2020-08-20 17:38:52', 12, '2020-08-20 17:45:44', '04/INV/20/08/0001', 0, '', 0, '0000-00-00', 2, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `history_price`
--

CREATE TABLE `history_price` (
  `id_history` bigint(20) NOT NULL,
  `harga` int(11) NOT NULL,
  `id_item` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(6, 1, 5000, 0, 'Jasa print black', 0),
(7, 2, 3000, 0, 'Jasa print warna', 1),
(8, 1, 50000, 0, 'Jasa Desain 1', 1),
(9, 1, 50000, 0, 'Cetak Banner', 0),
(10, 1, 100000, 0, 'Cetak Kartu Nama', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `location`
--

CREATE TABLE `location` (
  `id_location` bigint(20) NOT NULL,
  `nama_location` varchar(200) NOT NULL,
  `alamat_location` varchar(500) NOT NULL,
  `status` int(11) NOT NULL,
  `kecamatan` varchar(100) NOT NULL,
  `kota` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `tlp` varchar(100) NOT NULL,
  `ig` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `location`
--

INSERT INTO `location` (`id_location`, `nama_location`, `alamat_location`, `status`, `kecamatan`, `kota`, `email`, `tlp`, `ig`) VALUES
(4, 'kapuk', 'kapuk', 1, 'kapuk', 'kapuk', 'i@gmail.com', '09121', 'kapuk'),
(5, 'balige', 'balige', 1, 'balige', 'balige', 'info@indomilk.com', '02323', 'info');

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
(5, 'bensin', 12000, '', '2020-08-22', 6, '2020-08-22', 13, 1, 1, 0, '0000-00-00', 0, '');

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
(36, 6, 3, 1, 5000, 15000, 6, '2020-08-20', 6, '0000-00-00', 0, 1, 1, NULL, '', 0, '', 0, '0000-00-00'),
(38, 6, 4, 1, 5000, 20000, 6, '2020-08-20', 6, '0000-00-00', 0, 2, 1, NULL, '', 0, '', 0, '0000-00-00'),
(40, 6, 9, 1, 5000, 45000, 12, '2020-08-20', 12, '0000-00-00', 0, 3, 1, NULL, '', 0, '', 0, '0000-00-00');

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
(5, 'administrator', '827ccb0eea8a706c4c34a16891f84e7b', 1, 'administrator1', 3),
(6, 'operator', '827ccb0eea8a706c4c34a16891f84e7b', 3, 'operator123', 5),
(8, 'test', '827ccb0eea8a706c4c34a16891f84e7b', 2, 'test2', 2),
(9, 'administrator2', '827ccb0eea8a706c4c34a16891f84e7b', 1, 'administrator2', 2),
(10, 'test2', 'e10adc3949ba59abbe56e057f20f883e', 2, 'test1', 2),
(11, 'test43', '827ccb0eea8a706c4c34a16891f84e7b', 2, 'test43', 2),
(12, 'operator2', '827ccb0eea8a706c4c34a16891f84e7b', 3, 'operator2', 4),
(13, 'operator1234', '827ccb0eea8a706c4c34a16891f84e7b', 3, 'operator1234', 5);

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
  MODIFY `id_header_pengeluaran` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `header_penjualan`
--
ALTER TABLE `header_penjualan`
  MODIFY `id_header_penjualan` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `history_price`
--
ALTER TABLE `history_price`
  MODIFY `id_history` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `item`
--
ALTER TABLE `item`
  MODIFY `id_item` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `location`
--
ALTER TABLE `location`
  MODIFY `id_location` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id_pengeluaran` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id_satuan` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
