-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 18 Feb 2020 pada 11.50
-- Versi server: 10.4.6-MariaDB
-- Versi PHP: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pegangkali`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `catalog_image`
--

CREATE TABLE `catalog_image` (
  `id_image` bigint(20) NOT NULL,
  `id_catalog` bigint(20) NOT NULL,
  `gambar` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `catalog_pedagang`
--

CREATE TABLE `catalog_pedagang` (
  `id_catalog` bigint(20) NOT NULL,
  `id_pedagang` bigint(20) NOT NULL,
  `nama_jualan` varchar(50) NOT NULL,
  `harga_jualan` double NOT NULL,
  `deskripsi_jualan` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `catalog_pedagang`
--

INSERT INTO `catalog_pedagang` (`id_catalog`, `id_pedagang`, `nama_jualan`, `harga_jualan`, `deskripsi_jualan`, `created`) VALUES
(58, 58, 'Nasi gorengs', 10000, 'Nasi goreng super duper lezat', '2020-02-10 02:51:38'),
(64, 5, 'Nasi goreng', 10000, 'Nasi goreng super duper lezat', '2020-02-10 04:44:38'),
(65, 5, 'Nasi goreng', 10000, 'Nasi goreng super duper lezat', '2020-02-11 03:01:30'),
(66, 6, 'Nasi goreng', 10000, 'Nasi goreng super duper lezat', '2020-02-11 03:02:05'),
(67, 6, 'Nasi goreng', 10000, 'Nasi goreng super duper lezat', '2020-02-11 03:14:07'),
(68, 6, 'Nasi goreng', 10000, 'Nasi goreng super duper lezat', '2020-02-11 03:14:29'),
(69, 6, 'Nasi goreng', 10000, 'Nasi goreng super duper lezat', '2020-02-11 03:14:57'),
(70, 6, 'Nasi goreng', 10000, 'Nasi goreng super duper lezat', '2020-02-11 03:15:12'),
(71, 6, 'Nasi goreng', 10000, 'Nasi goreng super duper lezat', '2020-02-11 03:15:25'),
(72, 4, 'Nasi goreng', 10000, 'Nasi goreng super duper lezat', '2020-02-11 03:19:14'),
(73, 4, 'Nasi goreng', 10000, 'Nasi goreng super duper lezat', '2020-02-11 03:20:27'),
(74, 3, 'Nasi goreng', 10000, 'Nasi goreng super duper lezat', '2020-02-11 03:20:45'),
(75, 3, 'Nasi goreng', 10000, 'Nasi goreng super duper lezat', '2020-02-11 03:39:39'),
(76, 3, 'Nasi goreng', 10000, 'Nasi goreng super duper lezat', '2020-02-11 03:42:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `id_detail` bigint(20) NOT NULL,
  `nofaktur` varchar(100) NOT NULL,
  `id_jualan_pedagang` bigint(20) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `keys`
--

CREATE TABLE `keys` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `key` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT 0,
  `is_private_key` tinyint(1) NOT NULL DEFAULT 0,
  `ip_addresses` text DEFAULT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `resize`
--

CREATE TABLE `resize` (
  `id` int(11) NOT NULL,
  `gambar1` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `resize`
--

INSERT INTO `resize` (`id`, `gambar1`) VALUES
(13, 'IMG_20191221_1020161.jpg'),
(14, 'IMG_20191231_0944091.jpg'),
(15, 'IMG_20191231_094409.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pedagang`
--

CREATE TABLE `tbl_pedagang` (
  `id_pedagang` bigint(20) NOT NULL,
  `email_pedagang` varchar(30) NOT NULL,
  `nama_pedagang` varchar(50) NOT NULL,
  `foto` varchar(200) NOT NULL,
  `nohp_pedagang` varchar(15) NOT NULL,
  `password` varchar(300) NOT NULL,
  `otp` varchar(8) NOT NULL,
  `token_fcm` text NOT NULL,
  `aktif` tinyint(1) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_pedagang`
--

INSERT INTO `tbl_pedagang` (`id_pedagang`, `email_pedagang`, `nama_pedagang`, `foto`, `nohp_pedagang`, `password`, `otp`, `token_fcm`, `aktif`, `created`) VALUES
(3, 'razitulis@gmail.com', '', '', '082169146905', '$2y$10$TQdjoWoRKgQdaZSr0R1P4./zyh2lKPl4rFxjhdfgWKKQHVp8s.RCi', '112233', 'newtokena', 1, '2020-02-11 03:20:07'),
(4, 'razituli@gmail.com', '', '', '082169146903', '$2y$10$0IFb.vPYhBx0DA6gYKs1wuqTFHQxsNQANlnyWQGYbeYIMDCHIiK0W', '041197', 'newtokena', 1, '2020-02-07 04:25:00'),
(5, 'razitulia@gmail.com', '', '', '082169146902', '$2y$10$gtjEcuKlPBVc0.kk2AfUFu.xa.Gh0tbWynsow7NV3vVlsGTBFFKG.', '', 'asdasdasweawdq', 0, '2020-02-07 02:23:29'),
(7, 'razit@gmail.com', '', '', '082169146904', '$2y$10$fjg9hKMITpQSEp.yic.NF./PHBDy.Qb6dBqJ6Jso.WL1pYnjQ6xba', '', '', 0, '2020-02-07 04:29:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_penjualan`
--

CREATE TABLE `tbl_penjualan` (
  `nofaktur_penjualan` varchar(1000) NOT NULL,
  `id_pedagang` bigint(20) NOT NULL,
  `id_user` bigint(20) NOT NULL,
  `total_harga` double NOT NULL,
  `dibayar` double NOT NULL,
  `kembalian` double NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` bigint(20) NOT NULL,
  `nama_user` varchar(50) NOT NULL,
  `foto` varchar(200) NOT NULL,
  `email_user` varchar(30) NOT NULL,
  `password_user` varchar(300) NOT NULL,
  `nohp` varchar(15) NOT NULL,
  `alamat` text NOT NULL,
  `otp` varchar(8) NOT NULL,
  `token` text NOT NULL,
  `aktif` tinyint(1) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `catalog_image`
--
ALTER TABLE `catalog_image`
  ADD PRIMARY KEY (`id_image`);

--
-- Indeks untuk tabel `catalog_pedagang`
--
ALTER TABLE `catalog_pedagang`
  ADD PRIMARY KEY (`id_catalog`);

--
-- Indeks untuk tabel `keys`
--
ALTER TABLE `keys`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `resize`
--
ALTER TABLE `resize`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_pedagang`
--
ALTER TABLE `tbl_pedagang`
  ADD PRIMARY KEY (`id_pedagang`);

--
-- Indeks untuk tabel `tbl_penjualan`
--
ALTER TABLE `tbl_penjualan`
  ADD PRIMARY KEY (`nofaktur_penjualan`);

--
-- Indeks untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `catalog_image`
--
ALTER TABLE `catalog_image`
  MODIFY `id_image` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT untuk tabel `catalog_pedagang`
--
ALTER TABLE `catalog_pedagang`
  MODIFY `id_catalog` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT untuk tabel `keys`
--
ALTER TABLE `keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `resize`
--
ALTER TABLE `resize`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `tbl_pedagang`
--
ALTER TABLE `tbl_pedagang`
  MODIFY `id_pedagang` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
