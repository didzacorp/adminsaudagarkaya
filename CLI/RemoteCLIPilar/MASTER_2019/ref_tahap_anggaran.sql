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
-- Table structure for table `ref_tahap_anggaran`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_tahap_anggaran` (
  `id_tahap` int(11) NOT NULL AUTO_INCREMENT,
  `nama_tahap` text COLLATE latin1_general_ci NOT NULL,
  `anggaran` text COLLATE latin1_general_ci NOT NULL,
  `tahun` text COLLATE latin1_general_ci NOT NULL,
  `no_urut` text COLLATE latin1_general_ci NOT NULL,
  `id_modul` text COLLATE latin1_general_ci NOT NULL,
  `jenis_form_modul` text COLLATE latin1_general_ci NOT NULL,
  `tanggal_mulai` text COLLATE latin1_general_ci NOT NULL,
  `jam_mulai` text COLLATE latin1_general_ci NOT NULL,
  `tanggal_selesai` text COLLATE latin1_general_ci NOT NULL,
  `jam_selesai` text COLLATE latin1_general_ci NOT NULL,
  `status_jadwal` text COLLATE latin1_general_ci NOT NULL,
  `status_penyusunan` text COLLATE latin1_general_ci NOT NULL,
  `tgl_update` text COLLATE latin1_general_ci NOT NULL,
  `user` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id_tahap`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_tahap_anggaran`
--

LOCK TABLES `ref_tahap_anggaran` WRITE;
/*!40000 ALTER TABLE `ref_tahap_anggaran` DISABLE KEYS */;
INSERT INTO `ref_tahap_anggaran` VALUES (1,'','MURNI','2018','1','1','PENYUSUNAN','','','','','','','',''),(2,'','MURNI','2018','2','2','PENYUSUNAN','','','','','','','',''),(3,'','MURNI','2018','3','3','PENYUSUNAN','','','','','','','',''),(4,'','MURNI','2018','4','KOREKSI PENGGUNA','KOREKSI PENGGUNA','','','','','','','',''),(5,'','MURNI','2018','5','KOREKSI PENGELOLA','KOREKSI PENGELOLA','','','','','','','',''),(6,'','MURNI','2017','1','1','PENYUSUNAN','','','','','','','',''),(7,'','MURNI','2017','2','2','PENYUSUNAN','','','','','','','',''),(8,'','MURNI','2017','3','3','PENYUSUNAN','','','','','','','',''),(9,'','MURNI','2017','4','KOREKSI PENGGUNA','KOREKSI PENGGUNA','','','','','','','',''),(10,'','MURNI','2017','5','KOREKSI PENGELOLA','KOREKSI PENGELOLA','','','','','','','',''),(11,'','MURNI','2019','1','1','PENYUSUNAN','','','','','','','',''),(12,'','MURNI','2019','2','2','PENYUSUNAN','','','','','','','',''),(13,'','MURNI','2019','3','3','PENYUSUNAN','','','','','','','',''),(14,'','MURNI','2019','4','KOREKSI PENGGUNA','KOREKSI PENGGUNA','','','','','','','',''),(15,'','MURNI','2019','5','KOREKSI PENGELOLA','KOREKSI PENGELOLA','','','','','','','',''),(16,'','MURNI','','1','1','PENYUSUNAN','','','','','','','',''),(17,'','MURNI','','2','2','PENYUSUNAN','','','','','','','',''),(18,'','MURNI','','3','3','PENYUSUNAN','','','','','','','',''),(19,'','MURNI','','4','KOREKSI PENGGUNA','KOREKSI PENGGUNA','','','','','','','',''),(20,'','MURNI','','5','KOREKSI PENGELOLA','KOREKSI PENGELOLA','','','','','','','',''),(21,'','MURNI','2018','1','1','PENYUSUNAN','','','','','','','',''),(22,'','MURNI','2018','2','2','PENYUSUNAN','','','','','','','',''),(23,'','MURNI','2018','3','3','PENYUSUNAN','','','','','','','',''),(24,'','MURNI','2018','4','KOREKSI PENGGUNA','KOREKSI PENGGUNA','','','','','','','',''),(25,'','MURNI','2018','5','KOREKSI PENGELOLA','KOREKSI PENGELOLA','','','','','','','','');
/*!40000 ALTER TABLE `ref_tahap_anggaran` ENABLE KEYS */;
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
