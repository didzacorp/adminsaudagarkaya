-- MySQL dump 10.13  Distrib 5.5.62, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: db_development
-- ------------------------------------------------------
-- Server version	5.5.62-0+deb8u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `t_pengaturan`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_pengaturan` (
  `Id` int(11) NOT NULL AUTO_INCREMENT COMMENT '1 = Pengadaan',
  `nama_bidang` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `nama_skpd` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `alamat` text COLLATE latin1_general_ci,
  `kota` text COLLATE latin1_general_ci,
  `titimangsa_surat` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `nama_aplikasi` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `skpd` char(1) COLLATE latin1_general_ci DEFAULT NULL COMMENT '1=LAMA, 2=BARU',
  `kode_barang` char(1) COLLATE latin1_general_ci DEFAULT NULL COMMENT '1=LAMA, 2=BARU',
  `harga_atribusi` char(1) COLLATE latin1_general_ci DEFAULT NULL COMMENT '1=YA, 0=TIDAK',
  `cara_kptls` char(1) COLLATE latin1_general_ci DEFAULT NULL COMMENT '1 = LAMA, 2=BARU',
  `msg_del_gmbr` char(1) COLLATE latin1_general_ci DEFAULT NULL COMMENT '1=Ya, 0=Tidak',
  `msg_perawatan` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_pengaturan`
--

LOCK TABLES `t_pengaturan` WRITE;
/*!40000 ALTER TABLE `t_pengaturan` DISABLE KEYS */;
INSERT INTO `t_pengaturan` VALUES (1,'Bidang Aset','BPKAD Kab Bogor','Jl. Cibinong','Kabupaten Bogor','Cibinong','ATISISBADA','1','1','0','2','0','');
/*!40000 ALTER TABLE `t_pengaturan` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-12-27 10:52:11
