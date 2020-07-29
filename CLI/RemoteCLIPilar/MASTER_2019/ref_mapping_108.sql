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
-- Table structure for table `ref_mapping_108`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_mapping_108` (
  `f1` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `f2` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `f` char(2) COLLATE latin1_general_ci NOT NULL DEFAULT '00',
  `g` char(2) COLLATE latin1_general_ci NOT NULL DEFAULT '00',
  `h` char(2) COLLATE latin1_general_ci NOT NULL DEFAULT '00',
  `i` char(2) COLLATE latin1_general_ci NOT NULL DEFAULT '00',
  `f1_108` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `f2_108` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `f_108` char(2) COLLATE latin1_general_ci NOT NULL DEFAULT '00',
  `g_108` char(2) COLLATE latin1_general_ci NOT NULL DEFAULT '00',
  `h_108` char(2) COLLATE latin1_general_ci NOT NULL DEFAULT '00',
  `i_108` char(2) COLLATE latin1_general_ci NOT NULL DEFAULT '00',
  PRIMARY KEY (`f1`,`f2`,`f`,`g`,`h`,`i`,`f1_108`,`f2_108`,`f_108`,`g_108`,`h_108`,`i_108`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_mapping_108`
--

LOCK TABLES `ref_mapping_108` WRITE;
/*!40000 ALTER TABLE `ref_mapping_108` DISABLE KEYS */;
INSERT INTO `ref_mapping_108` VALUES (0,0,'01','00','00','00',1,3,'1','00','00','00'),(0,0,'01','01','01','00',1,3,'1','01','03','12'),(0,0,'01','01','01','00',1,3,'1','01','03','17'),(0,0,'01','01','01','00',1,3,'1','01','03','18'),(0,0,'01','01','02','00',1,3,'1','01','02','07'),(0,0,'01','01','03','00',1,3,'1','01','02','03'),(0,0,'01','01','04','00',1,3,'1','01','02','09'),(0,0,'01','01','05','00',1,3,'1','01','02','04'),(0,0,'01','01','06','00',1,3,'1','01','02','01'),(0,0,'01','01','07','00',1,3,'1','01','02','01'),(0,0,'01','01','08','00',1,3,'1','01','02','05'),(0,0,'01','01','09','00',1,3,'1','01','02','06'),(0,0,'01','01','10','00',1,3,'1','01','02','09'),(0,0,'01','01','11','00',1,3,'1','01','01','01'),(0,0,'01','01','11','00',1,3,'1','01','01','02'),(0,0,'01','01','11','00',1,3,'1','01','01','03'),(0,0,'01','01','11','00',1,3,'1','01','01','04'),(0,0,'01','01','12','00',1,3,'1','01','02','08'),(0,0,'01','01','13','00',1,3,'1','01','01','05'),(0,0,'01','01','13','00',1,3,'1','01','01','06'),(0,0,'01','01','13','00',1,3,'1','01','03','01'),(0,0,'01','01','13','00',1,3,'1','01','03','02'),(0,0,'01','01','13','00',1,3,'1','01','03','03'),(0,0,'01','01','13','00',1,3,'1','01','03','04'),(0,0,'01','01','13','00',1,3,'1','01','03','05'),(0,0,'01','01','13','00',1,3,'1','01','03','06'),(0,0,'01','01','13','00',1,3,'1','01','03','07'),(0,0,'01','01','13','00',1,3,'1','01','03','08'),(0,0,'01','01','13','00',1,3,'1','01','03','09'),(0,0,'01','01','13','00',1,3,'1','01','03','10'),(0,0,'01','01','13','00',1,3,'1','01','03','11'),(0,0,'02','02','01','00',1,3,'2','01','00','00'),(0,0,'02','02','02','00',1,3,'2','01','02','00'),(0,0,'02','02','03','00',1,3,'2','01','03','00'),(0,0,'02','03','00','00',1,3,'2','02','00','00'),(0,0,'02','03','01','00',1,3,'2','02','01','00'),(0,0,'02','03','02','00',1,3,'2','02','02','00'),(0,0,'02','03','03','00',1,3,'2','02','03','00'),(0,0,'02','03','04','00',1,3,'2','02','04','00'),(0,0,'02','03','05','00',1,3,'2','02','05','00'),(0,0,'02','04','00','00',1,3,'2','03','00','00'),(0,0,'02','04','01','00',1,3,'2','03','01','00'),(0,0,'02','04','02','00',1,3,'2','03','02','00'),(0,0,'02','04','03','00',1,3,'2','03','03','00'),(0,0,'02','05','00','00',1,3,'2','04','00','00'),(0,0,'02','05','01','00',1,3,'2','04','01','00'),(0,0,'02','05','02','00',1,3,'2','04','01','00'),(0,0,'02','06','00','00',1,3,'2','05','00','00'),(0,0,'02','06','01','00',1,3,'2','05','01','00'),(0,0,'02','06','02','00',1,3,'2','05','02','00'),(0,0,'02','06','03','00',1,3,'2','10','00','00'),(0,0,'02','06','04','00',1,3,'2','05','03','00'),(0,0,'02','07','00','00',1,3,'2','06','00','00'),(0,0,'02','07','01','00',1,3,'2','06','01','00'),(0,0,'02','07','02','00',1,3,'2','06','02','00'),(0,0,'02','07','03','00',1,3,'2','06','03','00'),(0,0,'02','08','00','00',1,3,'2','07','00','00'),(0,0,'02','08','01','00',1,3,'2','07','01','00'),(0,0,'02','08','02','00',1,3,'2','07','02','00'),(0,0,'02','09','00','00',1,3,'2','08','00','00'),(0,0,'02','09','01','00',1,3,'2','08','01','00'),(0,0,'02','09','02','00',1,3,'2','08','03','00'),(0,0,'02','09','03','00',1,3,'2','08','02','00'),(0,0,'02','09','04','00',1,3,'2','08','04','00'),(0,0,'02','09','05','00',1,3,'2','08','05','00'),(0,0,'02','09','06','00',1,3,'2','08','06','00'),(0,0,'02','09','07','00',1,3,'2','08','07','00'),(0,0,'02','09','08','00',1,3,'2','08','08','00'),(0,0,'02','10','00','00',1,3,'2','09','00','00'),(0,0,'02','10','01','00',1,3,'2','09','01','00'),(0,0,'02','10','02','00',1,3,'2','09','02','00'),(0,0,'02','10','03','00',1,1,'7','01','01','00'),(0,0,'02','10','04','00',1,3,'2','09','03','00'),(0,0,'03','11','00','00',1,3,'3','01','00','00'),(0,0,'03','11','01','00',1,3,'3','01','01','00'),(0,0,'03','11','02','00',1,3,'3','01','02','00'),(0,0,'03','11','03','00',1,3,'3','03','00','00'),(0,0,'03','12','00','00',1,3,'3','02','00','00'),(0,0,'03','12','01','00',1,3,'3','02','01','00'),(0,0,'03','12','02','00',1,3,'3','02','01','00'),(0,0,'03','12','03','00',1,3,'3','02','01','00'),(0,0,'03','12','04','00',1,3,'3','02','00','00'),(0,0,'03','12','05','00',1,3,'3','02','01','00'),(0,0,'03','12','06','00',1,3,'3','04','00','00'),(0,0,'03','12','07','00',1,3,'2','18','00','00'),(0,0,'03','12','08','00',1,3,'2','18','02','00'),(0,0,'04','13','00','00',1,3,'4','01','00','00'),(0,0,'04','13','01','00',1,3,'4','01','01','00'),(0,0,'04','13','02','00',1,3,'4','01','02','00'),(0,0,'04','14','00','00',1,3,'4','02','00','00'),(0,0,'04','14','01','00',1,3,'4','02','01','00'),(0,0,'04','14','02','00',1,3,'4','02','02','00'),(0,0,'04','14','03','00',1,3,'4','02','03','00'),(0,0,'04','14','04','00',1,3,'4','02','04','00'),(0,0,'04','14','05','00',1,3,'4','02','05','00'),(0,0,'04','14','06','00',1,3,'4','02','06','00'),(0,0,'04','14','07','00',1,3,'4','02','07','00'),(0,0,'04','14','08','00',1,3,'4','02','00','00'),(0,0,'04','15','00','00',1,3,'4','03','00','00'),(0,0,'04','15','01','00',1,3,'4','03','01','00'),(0,0,'04','15','02','00',1,3,'4','03','02','00'),(0,0,'04','15','03','00',1,3,'4','03','03','00'),(0,0,'04','15','04','00',1,3,'4','03','04','00'),(0,0,'04','15','05','00',1,3,'4','03','05','00'),(0,0,'04','15','06','00',1,3,'4','03','06','00'),(0,0,'04','15','07','00',1,3,'4','03','07','00'),(0,0,'04','15','08','00',1,3,'4','03','08','00'),(0,0,'04','15','09','00',1,3,'4','03','09','00'),(0,0,'04','16','00','00',1,3,'4','04','00','00'),(0,0,'04','16','01','00',1,3,'4','04','01','00'),(0,0,'04','16','02','00',1,3,'4','04','02','00'),(0,0,'04','16','03','00',1,3,'4','04','03','00'),(0,0,'04','16','04','00',1,3,'4','04','04','00'),(0,0,'05','17','01','01',1,3,'5','01','01','00'),(0,0,'05','17','01','02',1,3,'5','01','01','00'),(0,0,'05','17','01','03',1,3,'5','01','01','00'),(0,0,'05','17','01','04',1,3,'5','01','01','00'),(0,0,'05','17','01','05',1,3,'5','01','01','00'),(0,0,'05','17','01','06',1,3,'5','01','01','00'),(0,0,'05','17','01','07',1,3,'5','01','01','00'),(0,0,'05','17','01','08',1,3,'5','01','01','00'),(0,0,'05','17','01','09',1,3,'5','01','01','00'),(0,0,'05','17','02','01',1,3,'5','01','01','00'),(0,0,'05','17','02','02',1,3,'5','01','01','00'),(0,0,'05','17','03','01',1,3,'5','01','03','00'),(0,0,'05','17','03','02',1,3,'5','01','03','00'),(0,0,'05','17','03','03',1,3,'5','01','04','00'),(0,0,'05','17','03','04',1,3,'5','01','05','00'),(0,0,'05','17','03','05',1,3,'5','01','06','00'),(0,0,'05','17','03','06',1,3,'5','01','02','00'),(0,0,'05','17','03','07',1,3,'5','01','02','00'),(0,0,'05','17','03','08',1,3,'5','01','02','00'),(0,0,'05','17','03','09',1,3,'5','01','02','00'),(0,0,'05','17','03','10',1,3,'5','01','07','00'),(0,0,'05','18','01','01',1,3,'5','02','02','00'),(0,0,'05','18','01','02',1,3,'5','02','02','00'),(0,0,'05','18','01','03',1,3,'5','02','01','00'),(0,0,'05','18','01','04',1,3,'2','00','00','00'),(0,0,'05','18','01','05',1,3,'5','02','03','00'),(0,0,'05','18','01','06',1,3,'5','02','02','00'),(0,0,'05','18','01','07',1,3,'5','02','02','00'),(0,0,'05','18','01','08',1,3,'5','02','02','00'),(0,0,'05','18','02','00',1,3,'2','00','00','00'),(0,0,'05','18','02','01',1,3,'2','00','00','00'),(0,0,'05','18','02','02',1,3,'2','00','00','00'),(0,0,'05','18','02','03',1,3,'2','00','00','00'),(0,0,'05','18','02','04',1,3,'2','00','00','00'),(0,0,'05','19','01','00',1,3,'5','03','00','00'),(0,0,'05','19','01','01',1,3,'5','03','02','00'),(0,0,'05','19','01','02',1,3,'5','03','02','00'),(0,0,'05','19','01','03',1,3,'5','04','06','00'),(0,0,'05','19','01','04',1,3,'5','04','00','00'),(0,0,'05','19','01','05',1,3,'5','03','03','00'),(0,0,'05','19','01','06',1,3,'5','03','01','00'),(0,0,'05','19','02','00',1,3,'5','05','01','00'),(0,0,'05','19','02','01',1,3,'5','05','01','00'),(0,0,'05','19','02','02',1,3,'5','05','01','00');
/*!40000 ALTER TABLE `ref_mapping_108` ENABLE KEYS */;
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