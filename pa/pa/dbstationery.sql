-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Waktu pembuatan: 03 Nov 2024 pada 13.34
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
-- Struktur dari tabel `item_order`
--

CREATE TABLE `item_order` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `id_stationery` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `order`
--

CREATE TABLE `order` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_belanja` decimal(10,2) NOT NULL,
  `status` enum('pending','paid','shipped','completed','canceled') NOT NULL,
  `dibuat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `stationery`
--

INSERT INTO `stationery` (`id_stationery`, `name`, `merk`, `price`, `stock`, `photo`) VALUES
(31, 'Kokoro', 'Zebra', 4000, 10, '2024-10-15 14.40.06.jpg'),
(32, 'Kokoro Sweet Gel', 'Zebra', 6000, 12, '2024-10-15 14.40.36.jpg'),
(33, 'Sarasa Vintage', 'Zebra', 12000, 8, '2024-10-15 14.41.19.jpg'),
(34, 'Binder B5 Multiring', 'Bantex', 65000, 3, '2024-10-16 05.36.05.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`username`, `password`) VALUES
('a', '$2y$10$w6KJ7ZExWjuhbgdVbYp7kOJE22EwIYc/SQOugvdEGEyX3V.BZqE92');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `item_order`
--
ALTER TABLE `item_order`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `id_stationery` (`id_stationery`);

--
-- Indeks untuk tabel `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indeks untuk tabel `stationery`
--
ALTER TABLE `stationery`
  ADD PRIMARY KEY (`id_stationery`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `item_order`
--
ALTER TABLE `item_order`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `stationery`
--
ALTER TABLE `stationery`
  MODIFY `id_stationery` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `item_order`
--
ALTER TABLE `item_order`
  ADD CONSTRAINT `item_order_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `item_order_ibfk_2` FOREIGN KEY (`id_stationery`) REFERENCES `stationery` (`id_stationery`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
