-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2025 at 04:46 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_spp`
--

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(10) NOT NULL,
  `kompetensi_keahlian` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `kompetensi_keahlian`) VALUES
(3, 'VIII-1', 'Ilmu Pengetahuan Alam'),
(9, 'VIII-2', 'Ilmu Pengetahuan Alam'),
(10, 'VII-1', 'Ilmu Pengetahuan Alam'),
(11, 'VII-2', 'Ilmu Pengetahuan Alam'),
(12, 'IX-1', 'Ilmu Pengetahuan Alam'),
(15, 'IX-2', 'Ilmu Pengetahuan Alam');

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi_pembayaran`
--

CREATE TABLE `notifikasi_pembayaran` (
  `id` int(11) NOT NULL,
  `nisn` char(10) NOT NULL,
  `id_spp` int(11) NOT NULL,
  `bulan_dibayar` varchar(20) DEFAULT NULL,
  `tahun_dibayar` varchar(4) DEFAULT NULL,
  `jumlah_bayar` decimal(10,2) NOT NULL,
  `tgl_bayar` datetime DEFAULT current_timestamp(),
  `status` enum('pending','lunas') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifikasi_pembayaran`
--

INSERT INTO `notifikasi_pembayaran` (`id`, `nisn`, `id_spp`, `bulan_dibayar`, `tahun_dibayar`, `jumlah_bayar`, `tgl_bayar`, `status`) VALUES
(4, '102007816', 4, 'Februari', '2024', '20000.00', '2024-11-25 11:26:34', 'lunas'),
(5, '102007816', 4, 'Maret', '2024', '20000.00', '2024-11-25 11:42:39', 'lunas'),
(6, '103256281', 6, 'Januari', '2024', '20000.00', '2024-11-25 13:07:39', 'lunas'),
(7, '0022457031', 6, 'Januari', '2024', '20000.00', '2024-11-26 18:01:05', 'lunas'),
(8, '0022457031', 6, 'Februari', '2024', '20000.00', '2024-11-26 18:01:15', 'lunas'),
(9, '30941132', 4, 'Maret', '2024', '20000.00', '2024-12-05 02:24:16', 'lunas'),
(10, '102007816', 4, 'April', '2024', '20000.00', '2024-12-05 12:05:23', 'lunas'),
(11, '102007816', 4, 'April', '2024', '20000.00', '2024-12-05 23:28:01', 'lunas'),
(12, '1234567890', 4, 'Januari', '2024', '20000.00', '2024-12-12 02:26:55', 'lunas'),
(13, '1234567890', 4, 'Februari', '2024', '20000.00', '2024-12-17 14:00:53', 'lunas'),
(14, '1234567890', 4, 'Mei', '2024', '20000.00', '2024-12-21 15:02:56', 'lunas'),
(15, '1234567890', 4, 'Juni', '2025', '20000.00', '2025-01-01 16:58:23', 'lunas'),
(16, '1234567890', 4, 'Maret', '2025', '20000.00', '2025-01-14 11:31:44', 'lunas'),
(17, '1234567890', 4, 'Maret', '2025', '20000.00', '2025-01-14 11:35:52', 'lunas'),
(18, '1234567890', 4, 'Januari', '2025', '20000.00', '2025-01-14 11:43:39', 'lunas');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_petugas` int(11) NOT NULL,
  `nisn` varchar(10) NOT NULL,
  `tgl_bayar` date NOT NULL,
  `bulan_dibayar` varchar(8) NOT NULL,
  `tahun_dibayar` varchar(4) NOT NULL,
  `id_spp` int(11) NOT NULL,
  `jumlah_bayar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_petugas`, `nisn`, `tgl_bayar`, `bulan_dibayar`, `tahun_dibayar`, `id_spp`, `jumlah_bayar`) VALUES
(2, 1, '876543219', '2024-01-23', '', '2023', 1, 100000),
(5, 2, '12345', '2024-01-25', 'Januari', '2024', 1, 300000),
(6, 2, '876543219', '2024-01-25', 'Januari', '2024', 1, 200000),
(7, 2, '987654321', '2024-01-25', 'Januari', '2024', 1, 300000),
(9, 1, '1914370527', '2024-01-30', 'Januari', '2024', 3, 350000),
(10, 0, '123456789', '2024-01-30', 'November', '2024', 1, 150000),
(11, 1, '23456789', '2024-02-17', 'Februari', '2024', 4, 20000),
(12, 0, '3107835387', '2024-03-05', 'Maret', '2024', 4, 20000),
(13, 1, '30941132', '2024-03-05', 'Maret', '2024', 4, 20000),
(14, 1, '102007816', '2024-03-05', 'Maret', '2024', 4, 20000),
(15, 1, '103256281', '2024-03-09', 'Maret', '2024', 6, 20000),
(16, 1, '1234567890', '2024-03-09', 'Maret', '2024', 4, 20000),
(17, 1, '105555262', '2024-03-18', 'Maret', '2024', 4, 20000),
(18, 1, '101979301', '2024-04-29', 'April', '2024', 4, 20000),
(19, 1, '91359750', '2024-10-02', 'Oktober', '2024', 4, 20000),
(20, 0, '3107835387', '2024-01-02', 'Januari', '2024', 4, 20000),
(21, 1, '102007816', '2024-11-25', 'Februari', '2024', 4, 20000),
(22, 1, '102007816', '2024-11-25', 'Maret', '2024', 4, 20000),
(23, 1, '103256281', '2024-11-25', 'Januari', '2024', 6, 20000),
(24, 1, '0022457031', '2024-11-26', 'Februari', '2024', 6, 20000),
(25, 1, '0022457031', '2024-11-26', 'Januari', '2024', 6, 20000),
(26, 1, '30941132', '2024-12-05', 'Maret', '2024', 4, 20000),
(27, 1, '102007816', '2024-12-05', 'April', '2024', 4, 20000),
(28, 1, '102007816', '2024-12-05', 'April', '2024', 4, 20000),
(29, 1, '1234567890', '2024-12-15', 'Januari', '2024', 4, 20000),
(30, 1, '1234567890', '2024-12-31', 'Mei', '2024', 4, 20000),
(31, 1, '1234567890', '2024-12-31', 'Februari', '2024', 4, 20000),
(32, 1, '1234567890', '2025-01-14', 'Juni', '2025', 4, 20000),
(33, 0, '3107835387', '2025-01-14', 'Septembe', '2025', 4, 20000),
(34, 1, '1234567890', '2025-01-14', 'Maret', '2025', 4, 20000),
(35, 1, '1234567890', '2025-01-14', 'Maret', '2025', 4, 20000),
(36, 1, '1234567890', '2025-01-14', 'Januari', '2025', 4, 20000);

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nama_petugas` varchar(35) NOT NULL,
  `level` enum('admin','petugas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `username`, `password`, `nama_petugas`, `level`) VALUES
(1, 'admin', 'admin01', 'administrator', 'admin'),
(2, 'Desy Lestari, S.Pd', '12345', 'Desy Lestari, S.Pd', 'petugas'),
(5, 'weni', '12345', 'weni rahayu', 'petugas');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `nisn` char(10) NOT NULL,
  `nis` char(8) NOT NULL,
  `nama` varchar(35) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `alamat` text NOT NULL,
  `no_telp` varchar(13) NOT NULL,
  `id_spp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES
('0022457031', '1358', 'Hazrul Anshari Ulvi', 3, 'Jl. Binjai KM 10,8 Komplek Pardede, No.III, Sunggal, Deli Serdang', '083191795965', 6),
('101055506', '3533', 'Diki Alfian', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('101423732', '3557', 'Ravandy Afriansyah', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('101502458', '3567', 'M. Rafqi Ichsan', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('101518971', '3546', 'Keyla Aprista', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('101652326', '3564', 'Yulia', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('101979301', '3525', 'Armada Alriyantopa', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '085322334455', 4),
('102007816', '3522', 'Ananda', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('102256327', '3559', 'Rizky Alfanda', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('102846008', '3560', 'Sabila Putri Paramita', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('103256281', '3523', 'Anggi Aulia', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 6),
('103396028', '3555', 'Perdiansyah', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('103449061', '3529', 'Citra Rahayu Kasuma', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('103498610', '3556', 'Raffi Setiawan', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('103700646', '3554', 'Prans Steven Togatora', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('104336401', '3535', 'Fahrizal Sumana Ginting', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 6),
('104443763', '3549', 'M. Azril Triyansyah', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('104723706', '3547', 'Kris Handika', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('104744511', '3532', 'Dicky Efendi', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 6),
('105555262', '3524', 'Anisa Maharani', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('105570569', '3562', 'Selvia Raiska', 12, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('105878265', '3531', 'Danu Revana', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('106606568', '3620', 'Muhammad Alfin', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('106872777', '3551', 'Mita Safina', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('107062909', '3563', 'Sintia Stevane', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('108216600', '3558', 'Rizkita Sinulingga', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('108241028', '3542', 'Junnay Arfansyah', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('108354266', '3538', 'Firmansyah', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('108563056', '3541', 'Jhohan Juhari', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('108668245', '3530', 'Citra Rasikha', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('108966248', '3567', 'Rizky Aulia', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('109379962', '3536', 'Fatimah Az-Zahra', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('109693054', '3553', 'Novita Sari', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('109918856', '3543', 'Keisha Bella Ananda', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('111176177', '3552', 'Nara Sahara Fransiska', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('111596494', '3568', 'Bima Setiawan', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('118706520', '3545', 'Keyla Andini', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('123456789', '4321', 'Weni Rahayu', 2, 'Jl. Salak No.10', '082321332133', 1),
('1234567890', '1234', 'Muhammad Prawira Nugraha', 12, 'Jl. Cendana No. 13 Medan Marelan', '089677665544', 4),
('23456789', '98765', 'Aulia Arsy', 6, 'Jl. Beo No. 09', '082233445566', 4),
('3091720357', '3544', 'Keisya Ain Fitri', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('30941132', '3521', 'Aisyah Putri', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('3101162109', '3537', 'Fauzan Abditya', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('3102625915', '3527', 'Aurel Nabila Safitri', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('3105722646', '3528', 'Cahaya Maulana Mirza', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('3107835387', '3620', 'Adzkiya Nur Syifa', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '', 4),
('85573586', '3539', 'Herdi Riyanto', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('876543219', '9876', 'Muhammad Prawira Nugraha', 2, 'Jl. Beo No.10', '082261616665', 1),
('91359750', '3526', 'Aulia Sapitri', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('91759522', '3570', 'Citra Oktavia', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 6),
('97180479', '3534', 'Erly Wantika', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('97867983', '3540', 'Imam Satria', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4),
('987654321', '1234', 'Nurul Hidayani', 2, 'Jl. Gagak Hitam No.10', '082122313321', 1);

-- --------------------------------------------------------

--
-- Table structure for table `spp`
--

CREATE TABLE `spp` (
  `id_spp` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `jenjang` varchar(10) NOT NULL,
  `nominal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `spp`
--

INSERT INTO `spp` (`id_spp`, `tahun`, `jenjang`, `nominal`) VALUES
(4, 2024, 'SMA', 20000),
(6, 2024, 'SMK', 20000),
(36, 2024, 'SMP', 20000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `notifikasi_pembayaran`
--
ALTER TABLE `notifikasi_pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nisn` (`nisn`),
  ADD KEY `id_spp` (`id_spp`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`nisn`);

--
-- Indexes for table `spp`
--
ALTER TABLE `spp`
  ADD PRIMARY KEY (`id_spp`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `notifikasi_pembayaran`
--
ALTER TABLE `notifikasi_pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id_petugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `spp`
--
ALTER TABLE `spp`
  MODIFY `id_spp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notifikasi_pembayaran`
--
ALTER TABLE `notifikasi_pembayaran`
  ADD CONSTRAINT `notifikasi_pembayaran_ibfk_1` FOREIGN KEY (`nisn`) REFERENCES `siswa` (`nisn`),
  ADD CONSTRAINT `notifikasi_pembayaran_ibfk_2` FOREIGN KEY (`id_spp`) REFERENCES `spp` (`id_spp`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
