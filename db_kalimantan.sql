-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Des 2025 pada 05.33
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
-- Database: `db_kalimantan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `contents`
--

CREATE TABLE `contents` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tipe` varchar(50) NOT NULL,
  `informasi` text NOT NULL,
  `foto` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `contents`
--

INSERT INTO `contents` (`id`, `user_id`, `nama`, `tipe`, `informasi`, `foto`, `created_at`) VALUES
(2, 2, 'Bunga Raflesia', 'Flora', 'Bunga langka yang saat ini dilindungi keberadaannya', 'https://yiari.or.id/wp-content/uploads/2024/08/foto-1-66ceacc8377a0-1-1.webp', '2025-12-04 06:11:33'),
(3, 3, 'TRex', 'Fauna', 'salah satu predator terkuat di pulau kalimantan saat ini', 'https://ichef.bbci.co.uk/ace/standard/976/cpsprodpb/6260/production/_126048152_gettyimages-1363838708.jpg.webp', '2025-12-12 09:16:37'),
(4, 3, 'Anggrek Hitam (Coelogyne pandurata)', 'Flora', 'Maskot flora provinsi Kalimantan Timur. Tumbuhan ini unik karena memiliki lidah (labellum) berwarna hitam dengan garis-garis hijau dan berbulu. Anggrek ini tumbuh di hutan hujan tropis dan sangat dilindungi karena keberadaannya yang mulai langka.', 'https://awsimages.detik.net.id/community/media/visual/2020/11/30/anggrek-hitam-papua_169.jpeg', '2025-12-14 03:44:45'),
(5, 3, 'Bekantan (Nasalis larvatus)', 'Fauna', 'Monyet berhidung panjang yang menjadi ikon fauna Kalimantan Selatan dan maskot Dufan. Hewan ini hidup di hutan bakau (mangrove) dan hutan rawa. Bekantan adalah perenang ulung dan memiliki perut buncit karena sistem pencernaannya yang unik untuk mencerna daun-daunan.', 'https://assets-a1.kompasiana.com/items/album/2020/03/28/bekantan-1280x720-5e7f4312097f36351a2eb0f5.jpg', '2025-12-14 03:46:59'),
(6, 3, 'Soto Banjar', 'Makanan', 'Kuliner legendaris dari Kalimantan Selatan. Soto ini memiliki kuah bening yang kaya rempah (kayu manis, cengkeh, kapulaga). Biasanya disajikan dengan ketupat, suwiran ayam, perkedel kentang, telur rebus, dan taburan bawang goreng. Rasanya segar dan aromatik.', 'https://thumb.viva.id/vivapurwasuka/1265x711/2025/02/08/67a6697ae7061-soto-banjar_purwasuka.jpg', '2025-12-14 03:48:57'),
(7, 3, 'Bubur Pedas', 'Makanan', 'Makanan khas Melayu Sambas, Kalimantan Barat. Meskipun namanya \"pedas\", rasa aslinya tidak pedas (pedas di sini berarti kaya sayuran/rempah). Terbuat dari beras yang disangrai dengan kelapa, dimasak dengan berbagai macam sayuran seperti pakis, kangkung, dan daun kesum yang memberinya aroma khas.', 'https://indonesiakaya.com/wp-content/uploads/2023/04/bp_Artboard_1.jpg', '2025-12-14 03:50:29'),
(8, 3, 'Es Lidah Buaya', 'Minuman', 'Minuman andalan kota Pontianak, karena kota ini adalah pusat budidaya lidah buaya raksasa. Daging lidah buaya dipotong dadu, dicuci bersih hingga lendirnya hilang, lalu disajikan dengan sirup, es batu, dan kadang biji selasih. Sangat segar untuk cuaca panas.', 'https://asset.kompas.com/crops/ARJxbqkZhvDhQH5vMzFuYuf3wuk=/105x66:895x592/1200x800/data/photo/2023/05/23/646c4bf04b218.jpg', '2025-12-14 03:51:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `komentar`
--

CREATE TABLE `komentar` (
  `id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `isi` text NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `komentar`
--

INSERT INTO `komentar` (`id`, `content_id`, `user_id`, `isi`, `tanggal`) VALUES
(1, 2, 3, 'gambarnya bagus', '2025-12-12 09:14:28'),
(2, 2, 3, 'aku suka', '2025-12-12 09:14:34'),
(3, 3, 3, 'komen yah ges', '2025-12-12 09:16:50'),
(4, 3, 2, 'medeni jir', '2025-12-12 09:17:07'),
(5, 2, 2, 'mantap', '2025-12-12 09:17:16'),
(6, 8, 3, 'seger yahh', '2025-12-14 11:39:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(2, 'inas', '$2y$10$8c5UIFD6APN1BwgQkyLlre9ld5U/q9jLSaYpglSzNypodGlsWVJzq'),
(3, 'elang', '$2y$10$Gp2SlEqwnMBtVk0CfcnM0uJL/oX/USXG25m4/PEfaqF3Gt95elOQa');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `contents`
--
ALTER TABLE `contents`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `contents`
--
ALTER TABLE `contents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `komentar`
--
ALTER TABLE `komentar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
