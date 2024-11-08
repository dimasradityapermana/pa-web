-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Waktu pembuatan: 07 Nov 2024 pada 15.44
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbstationery`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `history`
--

CREATE TABLE `history` (
  `id_transaksi` int(11) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `tanggal` datetime NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `metode_pembayaran` varchar(30) NOT NULL,
  `status_pembayaran` enum('pending','paid','failed') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `history`
--

INSERT INTO `history` (`id_transaksi`, `user_id`, `tanggal`, `total_harga`, `metode_pembayaran`, `status_pembayaran`) VALUES
(24, 'qwe', '2024-11-07 21:37:27', 62000.00, 'Dana', 'paid');

-- --------------------------------------------------------

--
-- Struktur dari tabel `stationery`
--

CREATE TABLE `stationery` (
  `id_stationery` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `merk` varchar(20) NOT NULL,
  `price` int(10) NOT NULL,
  `stock` int(10) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `kategori` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `stationery`
--

INSERT INTO `stationery` (`id_stationery`, `name`, `merk`, `price`, `stock`, `photo`, `kategori`) VALUES
(39, 'Kokoro', 'Zebra', 10000, 20, '2024-11-07 21.17.03.jpg', 'Alat Tulis'),
(40, 'Binder B5', 'Bantex', 50000, 19, '2024-11-07 21.21.26.jpg', 'Kertas & B'),
(41, 'Kokoro Sweet Gel', 'Zebra', 12000, 19, '2024-11-07 21.24.46.jpg', 'Alat Tulis'),
(42, 'Sarasa', 'Zebra', 20000, 20, '2024-11-07 21.25.38.jpg', 'Alat Tulis');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `tanggal` datetime NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `metode_pembayaran` varchar(30) NOT NULL,
  `status_pembayaran` enum('pending','paid','failed') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `id_transaksi_detail` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `id_stationery` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`username`, `password`, `role`) VALUES
('123', '$2y$10$XNxI6IoYYx.PVfQVqhtZ0O2kbWHIMB.E.C.f0WSTkixcNYGG9LYL.', 'user'),
('a', '$2y$10$w6KJ7ZExWjuhbgdVbYp7kOJE22EwIYc/SQOugvdEGEyX3V.BZqE92', NULL),
('admin123', '$2y$10$zFO2JS9hQkvR/5w8JKcK0ejUDULNgTxwyw1AnNR00rDHysOQcSe.e', 'admin'),
('qwe', '$2y$10$zFO2JS9hQkvR/5w8JKcK0ejUDULNgTxwyw1AnNR00rDHysOQcSe.e', 'user');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indeks untuk tabel `stationery`
--
ALTER TABLE `stationery`
  ADD PRIMARY KEY (`id_stationery`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD PRIMARY KEY (`id_transaksi_detail`),
  ADD KEY `id_stationery` (`id_stationery`),
  ADD KEY `transaksi_detail_ibfk_1` (`id_transaksi`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `history`
--
ALTER TABLE `history`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `stationery`
--
ALTER TABLE `stationery`
  MODIFY `id_stationery` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  MODIFY `id_transaksi_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`username`);

--
-- Ketidakleluasaan untuk tabel `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD CONSTRAINT `transaksi_detail_ibfk_1` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaksi_detail_ibfk_2` FOREIGN KEY (`id_stationery`) REFERENCES `stationery` (`id_stationery`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
