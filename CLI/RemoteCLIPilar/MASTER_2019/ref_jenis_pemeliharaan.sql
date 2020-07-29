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
-- Table structure for table `ref_jenis_pemeliharaan`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_jenis_pemeliharaan` (
  `Id` tinyint(2) NOT NULL AUTO_INCREMENT,
  `jenis` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'harus unik, di penerimaan pemeliharaan foreign key',
  `menambah_aset` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1= ya, 2=tidak',
  `menambah_manfaat` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=ya 2=tidak',
  PRIMARY KEY (`Id`),
  UNIQUE KEY `jenis` (`jenis`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_jenis_pemeliharaan`
--

LOCK TABLES `ref_jenis_pemeliharaan` WRITE;
/*!40000 ALTER TABLE `ref_jenis_pemeliharaan` DISABLE KEYS */;
INSERT INTO `ref_jenis_pemeliharaan` VALUES (2,'RUTIN',2,2),(3,'RENOVASI',1,1),(9,'REHABILITASI',1,1),(10,'OVERHAUL',1,1),(11,'RESTORASI',1,1),(12,'PENINGKATAN',1,2),(13,'PELABURAN',2,2),(14,'pemeliharaan baru',1,2);
/*!40000 ALTER TABLE `ref_jenis_pemeliharaan` ENABLE KEYS */;
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
