/*
 Navicat Premium Data Transfer

 Source Server         : MYSQL
 Source Server Type    : MySQL
 Source Server Version : 90100 (9.1.0)
 Source Host           : localhost:3306
 Source Schema         : weni

 Target Server Type    : MySQL
 Target Server Version : 90100 (9.1.0)
 File Encoding         : 65001

 Date: 08/02/2025 09:14:00
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for kelas
-- ----------------------------
DROP TABLE IF EXISTS `kelas`;
CREATE TABLE `kelas` (
  `id_kelas` int NOT NULL AUTO_INCREMENT,
  `nama_kelas` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `kompetensi_keahlian` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_kelas`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of kelas
-- ----------------------------
BEGIN;
INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `kompetensi_keahlian`) VALUES (3, 'VIII-1', 'Ilmu Pengetahuan Alam');
INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `kompetensi_keahlian`) VALUES (9, 'VIII-2', 'Ilmu Pengetahuan Alam');
INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `kompetensi_keahlian`) VALUES (10, 'VII-1', 'Ilmu Pengetahuan Alam');
INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `kompetensi_keahlian`) VALUES (11, 'VII-2', 'Ilmu Pengetahuan Alam');
INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `kompetensi_keahlian`) VALUES (12, 'IX-1', 'Ilmu Pengetahuan Alam');
INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `kompetensi_keahlian`) VALUES (15, 'IX-2', 'Ilmu Pengetahuan Alam');
COMMIT;

-- ----------------------------
-- Table structure for notifikasi_pembayaran
-- ----------------------------
DROP TABLE IF EXISTS `notifikasi_pembayaran`;
CREATE TABLE `notifikasi_pembayaran` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nisn` char(10) COLLATE utf8mb4_general_ci NOT NULL,
  `id_spp` int NOT NULL,
  `bulan_dibayar` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tahun_dibayar` varchar(4) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jumlah_bayar` decimal(10,2) NOT NULL,
  `tgl_bayar` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('pending','lunas') COLLATE utf8mb4_general_ci DEFAULT 'pending',
  PRIMARY KEY (`id`),
  KEY `nisn` (`nisn`),
  KEY `id_spp` (`id_spp`),
  CONSTRAINT `notifikasi_pembayaran_ibfk_1` FOREIGN KEY (`nisn`) REFERENCES `siswa` (`nisn`),
  CONSTRAINT `notifikasi_pembayaran_ibfk_2` FOREIGN KEY (`id_spp`) REFERENCES `spp` (`id_spp`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of notifikasi_pembayaran
-- ----------------------------
BEGIN;
INSERT INTO `notifikasi_pembayaran` (`id`, `nisn`, `id_spp`, `bulan_dibayar`, `tahun_dibayar`, `jumlah_bayar`, `tgl_bayar`, `status`) VALUES (45, '0022457031', 6, 'Januari', '2025', 5000.00, '2025-02-07 16:08:10', 'pending');
INSERT INTO `notifikasi_pembayaran` (`id`, `nisn`, `id_spp`, `bulan_dibayar`, `tahun_dibayar`, `jumlah_bayar`, `tgl_bayar`, `status`) VALUES (46, '0022457031', 6, 'Januari', '2025', 5000.00, '2025-02-07 16:08:10', 'pending');
COMMIT;

-- ----------------------------
-- Table structure for pembayaran
-- ----------------------------
DROP TABLE IF EXISTS `pembayaran`;
CREATE TABLE `pembayaran` (
  `id_pembayaran` int NOT NULL AUTO_INCREMENT,
  `id_petugas` int NOT NULL,
  `nisn` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_bayar` date NOT NULL,
  `bulan_dibayar` varchar(8) COLLATE utf8mb4_general_ci NOT NULL,
  `tahun_dibayar` varchar(4) COLLATE utf8mb4_general_ci NOT NULL,
  `id_spp` int NOT NULL,
  `jumlah_bayar` int NOT NULL,
  PRIMARY KEY (`id_pembayaran`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of pembayaran
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for petugas
-- ----------------------------
DROP TABLE IF EXISTS `petugas`;
CREATE TABLE `petugas` (
  `id_petugas` int NOT NULL AUTO_INCREMENT,
  `username` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(32) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_petugas` varchar(35) COLLATE utf8mb4_general_ci NOT NULL,
  `level` enum('admin','kepala sekolah') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_petugas`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of petugas
-- ----------------------------
BEGIN;
INSERT INTO `petugas` (`id_petugas`, `username`, `password`, `nama_petugas`, `level`) VALUES (1, 'admin', 'admin01', 'administrator', 'admin');
INSERT INTO `petugas` (`id_petugas`, `username`, `password`, `nama_petugas`, `level`) VALUES (2, 'Desy Lestari, S.Pd', '12345', 'Desy Lestari, S.Pd', 'kepala sekolah');
INSERT INTO `petugas` (`id_petugas`, `username`, `password`, `nama_petugas`, `level`) VALUES (5, 'weni', '12345', 'weni rahayu', 'kepala sekolah');
COMMIT;

-- ----------------------------
-- Table structure for siswa
-- ----------------------------
DROP TABLE IF EXISTS `siswa`;
CREATE TABLE `siswa` (
  `nisn` char(10) COLLATE utf8mb4_general_ci NOT NULL,
  `nis` char(8) COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(35) COLLATE utf8mb4_general_ci NOT NULL,
  `id_kelas` int NOT NULL,
  `alamat` text COLLATE utf8mb4_general_ci NOT NULL,
  `no_telp` varchar(13) COLLATE utf8mb4_general_ci NOT NULL,
  `id_spp` int NOT NULL,
  PRIMARY KEY (`nisn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of siswa
-- ----------------------------
BEGIN;
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('0022457031', '1358', 'Hazrul Anshari Ulvi', 3, 'Jl. Binjai KM 10,8 Komplek Pardede, No.III, Sunggal, Deli Serdang', '083191795965', 6);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('101055506', '3533', 'Diki Alfian', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('101423732', '3557', 'Ravandy Afriansyah', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('101502458', '3567', 'M. Rafqi Ichsan', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('101518971', '3546', 'Keyla Aprista', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('101652326', '3564', 'Yulia', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('101979301', '3525', 'Armada Alriyantopa', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '085322334455', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('102007816', '3522', 'Ananda', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('102256327', '3559', 'Rizky Alfanda', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('102846008', '3560', 'Sabila Putri Paramita', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('103256281', '3523', 'Anggi Aulia', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 6);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('103396028', '3555', 'Perdiansyah', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('103449061', '3529', 'Citra Rahayu Kasuma', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('103498610', '3556', 'Raffi Setiawan', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('103700646', '3554', 'Prans Steven Togatora', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('104336401', '3535', 'Fahrizal Sumana Ginting', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 6);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('104443763', '3549', 'M. Azril Triyansyah', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('104723706', '3547', 'Kris Handika', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('104744511', '3532', 'Dicky Efendi', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 6);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('105555262', '3524', 'Anisa Maharani', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('105570569', '3562', 'Selvia Raiska', 12, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('105878265', '3531', 'Danu Revana', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('106606568', '3620', 'Muhammad Alfin', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('106872777', '3551', 'Mita Safina', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('107062909', '3563', 'Sintia Stevane', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('108216600', '3558', 'Rizkita Sinulingga', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('108241028', '3542', 'Junnay Arfansyah', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('108354266', '3538', 'Firmansyah', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('108563056', '3541', 'Jhohan Juhari', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('108668245', '3530', 'Citra Rasikha', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('108966248', '3567', 'Rizky Aulia', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('109379962', '3536', 'Fatimah Az-Zahra', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('109693054', '3553', 'Novita Sari', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('109918856', '3543', 'Keisha Bella Ananda', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('111176177', '3552', 'Nara Sahara Fransiska', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('111596494', '3568', 'Bima Setiawan', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('118706520', '3545', 'Keyla Andini', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('123456789', '4321', 'Weni Rahayu', 2, 'Jl. Salak No.10', '082321332133', 1);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('1234567890', '1234', 'Muhammad Prawira Nugraha', 12, 'Jl. Cendana No. 13 Medan Marelan', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('23456789', '98765', 'Aulia Arsy', 6, 'Jl. Beo No. 09', '082233445566', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('3091720357', '3544', 'Keisya Ain Fitri', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('30941132', '3521', 'Aisyah Putri', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('3101162109', '3537', 'Fauzan Abditya', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('3102625915', '3527', 'Aurel Nabila Safitri', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('3105722646', '3528', 'Cahaya Maulana Mirza', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('3107835387', '3620', 'Adzkiya Nur Syifa', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('85573586', '3539', 'Herdi Riyanto', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('876543219', '9876', 'Muhammad Prawira Nugraha', 2, 'Jl. Beo No.10', '082261616665', 1);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('91359750', '3526', 'Aulia Sapitri', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('91759522', '3570', 'Citra Oktavia', 9, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 6);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('97180479', '3534', 'Erly Wantika', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('97867983', '3540', 'Imam Satria', 3, 'Jl. S. Parman No. 6 Kwala Begumit, Kec. Binjai, Kab. Langkat, Sumatera Utara', '089677665544', 4);
INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES ('987654321', '1234', 'Nurul Hidayani', 2, 'Jl. Gagak Hitam No.10', '082122313321', 1);
COMMIT;

-- ----------------------------
-- Table structure for spp
-- ----------------------------
DROP TABLE IF EXISTS `spp`;
CREATE TABLE `spp` (
  `id_spp` int NOT NULL AUTO_INCREMENT,
  `tahun` int NOT NULL,
  `jenjang` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `nominal` int NOT NULL,
  PRIMARY KEY (`id_spp`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of spp
-- ----------------------------
BEGIN;
INSERT INTO `spp` (`id_spp`, `tahun`, `jenjang`, `nominal`) VALUES (4, 2024, 'SMA', 5000);
INSERT INTO `spp` (`id_spp`, `tahun`, `jenjang`, `nominal`) VALUES (6, 2024, 'SMK', 5000);
INSERT INTO `spp` (`id_spp`, `tahun`, `jenjang`, `nominal`) VALUES (36, 2024, 'SMP', 5000);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
