-- Adminer 4.6.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `ref_projek`;
CREATE TABLE `ref_projek` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tahun` text COLLATE latin1_general_ci NOT NULL,
  `nama_projek` text COLLATE latin1_general_ci NOT NULL,
  `nama_pemda` text COLLATE latin1_general_ci NOT NULL,
  `nomor_kontrak` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `tanggal_kontrak` date NOT NULL,
  `nilai_kontrak` decimal(18,2) NOT NULL,
  `status` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `ref_projek` (`id`, `tahun`, `nama_projek`, `nama_pemda`, `nomor_kontrak`, `tanggal_kontrak`, `nilai_kontrak`, `status`) VALUES
(1,	'2018',	'Pengembangan Atisisbada',	'1',	'',	'0000-00-00',	0.00,	'1'),
(2,	'2018',	'Pengembangan ATISISBADA',	'12',	'',	'0000-00-00',	0.00,	'1'),
(3,	'2018',	'Pengembangan ATISISBADA',	'15',	'',	'0000-00-00',	0.00,	'1'),
(4,	'2018',	'Buku BI',	'11',	'',	'0000-00-00',	0.00,	'1'),
(5,	'2019',	'Sewa Collocation Kab serang',	'3',	'',	'0000-00-00',	0.00,	'1'),
(6,	'2019',	'Label Barcode',	'11',	'',	'0000-00-00',	0.00,	'1'),
(7,	'2019',	'Software Absensi',	'20',	'',	'0000-00-00',	0.00,	'1'),
(8,	'2019',	'Pengembangan Atisisbada',	'17',	'',	'0000-00-00',	0.00,	'1'),
(9,	'2019',	'Sewa Coollocation Server Kab. Bogor',	'11',	'',	'0000-00-00',	0.00,	'1'),
(10,	'2019',	'Sewa Collocation Kabupaten Garut',	'10',	'',	'0000-00-00',	0.00,	'1'),
(11,	'2019',	'Sewa Collocation KBB',	'1',	'',	'0000-00-00',	0.00,	'1'),
(12,	'2019',	'Sewa Collocation Kab. Karawang',	'6',	'',	'0000-00-00',	0.00,	'1'),
(13,	'2019',	'Sewa Collocation kab. Lebak',	'17',	'',	'0000-00-00',	0.00,	'1'),
(14,	'2019',	'Sewa Collocation Kota Sukabumi',	'14',	'',	'0000-00-00',	0.00,	'1'),
(15,	'2019',	'Pengembangan ATISISBADA',	'16',	'',	'0000-00-00',	0.00,	'1'),
(16,	'2019',	'Pengembangan ATISISBADA',	'18',	'',	'0000-00-00',	0.00,	'1'),
(17,	'2019',	'Pengembangan ATISISBADA',	'19',	'',	'0000-00-00',	0.00,	'1'),
(18,	'2019',	'Kaos Linmas Satpol PP',	'3',	'',	'0000-00-00',	0.00,	'1'),
(19,	'2019',	'Kertas Kerja',	'6',	'',	'0000-00-00',	0.00,	'1'),
(20,	'2020',	'Test',	'1',	'',	'2020-01-02',	0.00,	'1'),
(21,	'2020',	'tqweqwe',	'1',	'',	'2020-01-11',	0.00,	'1'),
(22,	'2020',	'test',	'3',	'N/sadsa/qw3e12',	'2020-01-11',	300000.00,	'1');

-- 2020-01-11 14:42:03