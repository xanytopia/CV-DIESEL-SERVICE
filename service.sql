/*
 Navicat Premium Data Transfer

 Source Server         : Darren
 Source Server Type    : MySQL
 Source Server Version : 100424 (10.4.24-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : service

 Target Server Type    : MySQL
 Target Server Version : 100424 (10.4.24-MariaDB)
 File Encoding         : 65001

 Date: 13/08/2024 16:20:59
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for log
-- ----------------------------
DROP TABLE IF EXISTS `log`;
CREATE TABLE `log`  (
  `id_log` int NOT NULL AUTO_INCREMENT,
  `id_user` int NULL DEFAULT NULL,
  `activity` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `time` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id_log`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of log
-- ----------------------------
INSERT INTO `log` VALUES (7, 3, 'Logout', '2024-08-12 00:07:32');
INSERT INTO `log` VALUES (8, 3, 'Login', '2024-08-12 00:07:39');
INSERT INTO `log` VALUES (9, 3, 'Input Pesanan', '2024-08-12 00:20:39');
INSERT INTO `log` VALUES (10, 3, 'Tambah Teknisi', '2024-08-12 00:51:37');
INSERT INTO `log` VALUES (11, 3, 'Edit Teknisi', '2024-08-12 00:51:50');
INSERT INTO `log` VALUES (12, 3, 'Login', '2024-08-12 07:42:14');
INSERT INTO `log` VALUES (13, 3, 'Logout', '2024-08-12 07:42:19');
INSERT INTO `log` VALUES (14, 3, 'Login', '2024-08-12 08:09:23');
INSERT INTO `log` VALUES (15, 3, 'Login', '2024-08-12 08:28:42');
INSERT INTO `log` VALUES (16, 3, 'Login', '2024-08-12 08:28:57');
INSERT INTO `log` VALUES (17, 3, 'Login', '2024-08-12 08:29:32');
INSERT INTO `log` VALUES (18, 3, 'Login', '2024-08-12 23:12:19');
INSERT INTO `log` VALUES (19, 3, 'Logout', '2024-08-12 23:41:09');
INSERT INTO `log` VALUES (20, 3, 'Login', '2024-08-12 23:41:45');
INSERT INTO `log` VALUES (21, 3, 'Print Windows    ', '2024-08-13 00:41:01');
INSERT INTO `log` VALUES (22, 3, 'Print Windows    ', '2024-08-13 00:43:04');
INSERT INTO `log` VALUES (23, 3, 'Print Windows    ', '2024-08-13 00:43:15');
INSERT INTO `log` VALUES (24, 3, 'Print PDF', '2024-08-13 00:43:32');
INSERT INTO `log` VALUES (25, 3, 'Login', '2024-08-13 04:11:23');

-- ----------------------------
-- Table structure for pesanan
-- ----------------------------
DROP TABLE IF EXISTS `pesanan`;
CREATE TABLE `pesanan`  (
  `id_pesanan` int NOT NULL AUTO_INCREMENT,
  `nama_pemilik` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_telp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `merk_genset` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `merk_mesin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `kapasitas_genset` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `deskripsi_masalah` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `sistem_pesanan` enum('Pick Up','Langsung','-') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Pick Up',
  `status` enum('Pending','On-Going','Done','Waiting') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_teknisi` int NULL DEFAULT NULL,
  `id_user` int NULL DEFAULT NULL,
  `estimasi_waktu` datetime NULL DEFAULT NULL,
  `tanggal_permintaan` date NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `created_by` int NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  `deleted_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id_pesanan`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 55 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pesanan
-- ----------------------------
INSERT INTO `pesanan` VALUES (40, 'morgen taw', '08666666', 'royal grande', 'Lenovo', 'logitech', '2400', 'tidak ada masalah', 'Pick Up', 'On-Going', 3, NULL, '2024-08-09 21:52:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `pesanan` VALUES (54, 'tinardo', '082280297788', 'baloi', 'liberty', 'amc', '200', 'amc tidak berfungsi', '-', 'Pending', NULL, NULL, NULL, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for setting
-- ----------------------------
DROP TABLE IF EXISTS `setting`;
CREATE TABLE `setting`  (
  `id_setting` int NOT NULL AUTO_INCREMENT,
  `nama_website` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `icon_logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `logo_dashboard` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `logo_login` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_setting`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of setting
-- ----------------------------
INSERT INTO `setting` VALUES (1, 'CV Diesel Service', 'cv_diesel_tp_1.png', 'cv_diesel_tp.png', 'cv_diesel_tp.png');

-- ----------------------------
-- Table structure for teknisi
-- ----------------------------
DROP TABLE IF EXISTS `teknisi`;
CREATE TABLE `teknisi`  (
  `id_teknisi` int NOT NULL AUTO_INCREMENT,
  `nama_teknisi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_telp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status` enum('Aktif','Tidak Aktif') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_teknisi`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of teknisi
-- ----------------------------
INSERT INTO `teknisi` VALUES (1, 'Erwin Lie', '0891212311', 'erwinlie@gmail.com', 'Aktif');
INSERT INTO `teknisi` VALUES (2, 'Yoga Gautama', '089192912912', 'yogachua@gmail.com', 'Tidak Aktif');
INSERT INTO `teknisi` VALUES (3, 'Elvan Chua', '354534134', 'elvan111@gmail.com', 'Aktif');
INSERT INTO `teknisi` VALUES (6, 'Leonardo', '12342413', 'Email@gmail.com', 'Aktif');
INSERT INTO `teknisi` VALUES (7, 'morgen', '089512121212', 'Email@gmail.com', 'Tidak Aktif');
INSERT INTO `teknisi` VALUES (8, 'darren van', '08666666', 'darrenvan@gmail.com', 'Aktif');

-- ----------------------------
-- Table structure for transaksi
-- ----------------------------
DROP TABLE IF EXISTS `transaksi`;
CREATE TABLE `transaksi`  (
  `id_transaksi` int NOT NULL AUTO_INCREMENT,
  `no_transaksi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tanggal` date NULL DEFAULT NULL,
  `nama_pemilik` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `jenis_service` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `harga` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status` enum('Sudah Bayar','Belum Bayar') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `bayaran` int NULL DEFAULT NULL,
  `kembalian` int NULL DEFAULT NULL,
  `id_teknisi` int NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `created_by` int NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  `deleted` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id_transaksi`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of transaksi
-- ----------------------------
INSERT INTO `transaksi` VALUES (16, '100240806013', '2024-08-06', 'taufik ng', 'Maintenance', '50000', 'Sudah Bayar', 100000, 50000, 1, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `transaksi` VALUES (17, '100240806014', '2024-08-06', 'Elvan Chua', 'Maintenance', '450000', 'Sudah Bayar', 500000, 50000, 1, NULL, NULL, NULL, NULL, '2024-08-13 12:47:40');
INSERT INTO `transaksi` VALUES (18, '100240806015', '2024-08-06', 'Deren', 'Maintenance', '100000', 'Sudah Bayar', 150000, 50000, 3, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `transaksi` VALUES (19, '100240807100', '2024-08-07', 'Yuro Stoner', 'perbaiki mesin', '150000', 'Sudah Bayar', 200000, 50000, 1, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `transaksi` VALUES (20, '100240807101', '2024-08-07', 'Robin', 'Service Ringan', '35000', 'Sudah Bayar', 100000, 65000, 3, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `transaksi` VALUES (21, '100240807102', '2024-08-07', 'tinardo23', 'Service Ringan', '100000', 'Sudah Bayar', 400000, 300000, 6, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `transaksi` VALUES (22, '100240807103', '2024-08-07', 'aldrian', 'Service Ringan', '1250000', 'Sudah Bayar', 1500000, 250000, 1, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `transaksi` VALUES (23, '100240807104', '2024-08-07', 'inzaghi', 'Ganti Oli', '50000', 'Sudah Bayar', 100000, 50000, 6, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `level` enum('Admin','Pelanggan') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_user`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (3, 'testing', 'testing', 'test', 'Admin');
INSERT INTO `user` VALUES (5, '2', '2', '2', 'Admin');

SET FOREIGN_KEY_CHECKS = 1;
