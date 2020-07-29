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
-- Table structure for table `settingperencanaan`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settingperencanaan` (
  `wajib_validasi` text NOT NULL,
  `bypass_jadwal` text NOT NULL,
  `tahun` text NOT NULL,
  `jenis_anggaran` text NOT NULL,
  `provinsi` text NOT NULL,
  `kota` text NOT NULL,
  `pejabat` text NOT NULL,
  `pengelola` text NOT NULL,
  `pengurus` text NOT NULL,
  `logo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settingperencanaan`
--

LOCK TABLES `settingperencanaan` WRITE;
/*!40000 ALTER TABLE `settingperencanaan` DISABLE KEYS */;
INSERT INTO `settingperencanaan` VALUES ('0','1','2018','MURNI','Jawa Barat','Bandung','10','12','11','Media/80cb8bae3b3846a4e3fcccc28c8388d85214951b2a1ec530e5edc954ccb2ea0a'),('0','1','2018','MURNI','Jawa Barat','Bandung','10','12','11','Media/4119fe5438d1533e8f16b68c6d5e440114f0f4cacf56b5319df3ebc7ec1565b7'),('0','1','2017','MURNI','Jawa Barat','Bandung','10','12','11','Media/87d0901e8dd2ea7037e55bf83e2346cb.png'),('0','1','2017','MURNI','Jawa Barat','Bandung','10','12','11','Media/87d0901e8dd2ea7037e55bf83e2346cb.png'),('0','1','2018','MURNI','Jawa Barat','Bandung','10','12','11','Media/fb35c241ea8a97853a10f49e3da1e7ff.png'),('0','1','2018','MURNI','Jawa Barat','Bandung','10','12','11','Media/fb35c241ea8a97853a10f49e3da1e7ff.png'),('0','1','2018','MURNI','Jawa Barat','Bandung','10','12','11','Media/fb35c241ea8a97853a10f49e3da1e7ff.png'),('0','1','2018','MURNI','Jawa Barat','Bandung','10','12','11','Media/fb35c241ea8a97853a10f49e3da1e7ff.png'),('0','1','2018','MURNI','Jawa Barat','Bandung','10','12','11','Media/1443b23802e83bb311e5a36af7bd4f3a075704fd62c1f159716eb49d5f8bcf05'),('0','1','2018','MURNI','Jawa Barat','Bandung','10','12','11','Media/83efb4eba6d1765110c5dba44eaba928.png'),('0','1','2018','MURNI','Jawa Barat','Bandung','10','12','11','Media/80cb8bae3b3846a4e3fcccc28c8388d85214951b2a1ec530e5edc954ccb2ea0a'),('0','1','2018','MURNI','Jawa Barat','Bandung','10','12','11','Media/4119fe5438d1533e8f16b68c6d5e440114f0f4cacf56b5319df3ebc7ec1565b7'),('0','1','2017','MURNI','Jawa Barat','Bandung','10','12','11','Media/87d0901e8dd2ea7037e55bf83e2346cb.png'),('0','1','2017','MURNI','Jawa Barat','Bandung','10','12','11','Media/87d0901e8dd2ea7037e55bf83e2346cb.png'),('0','1','2018','MURNI','Jawa Barat','Bandung','10','12','11','Media/fb35c241ea8a97853a10f49e3da1e7ff.png'),('0','1','2018','MURNI','Jawa Barat','Bandung','10','12','11','Media/fb35c241ea8a97853a10f49e3da1e7ff.png'),('0','1','2018','MURNI','Jawa Barat','Bandung','10','12','11','Media/fb35c241ea8a97853a10f49e3da1e7ff.png'),('0','1','2018','MURNI','Jawa Barat','Bandung','10','12','11','Media/fb35c241ea8a97853a10f49e3da1e7ff.png'),('0','1','2018','MURNI','Jawa Barat','Bandung','10','12','11','Media/1443b23802e83bb311e5a36af7bd4f3a075704fd62c1f159716eb49d5f8bcf05'),('0','1','2018','MURNI','Jawa Barat','Bandung','10','12','11','Media/83efb4eba6d1765110c5dba44eaba928.png'),('0','1','2018','MURNI','Jawa Barat','Bandung','10','12','11','Media/83efb4eba6d1765110c5dba44eaba928.png'),('0','1','2018','MURNI','Jawa Barat','Bandung','10','12','11','Media/83efb4eba6d1765110c5dba44eaba928.png'),('0','1','2018','MURNI','Jawa Barat','Bandung','10','12','11','Media/83efb4eba6d1765110c5dba44eaba928.png'),('0','1','2018','MURNI','Jawa Barat','Bandung','10','12','11','Media/83efb4eba6d1765110c5dba44eaba928.png'),('0','1','2018','MURNI','Jawa Barat','Bandung','10','12','11','Media/80cb8bae3b3846a4e3fcccc28c8388d85214951b2a1ec530e5edc954ccb2ea0a'),('0','1','2018','MURNI','Jawa Barat','Bandung','10','12','11','Media/4119fe5438d1533e8f16b68c6d5e440114f0f4cacf56b5319df3ebc7ec1565b7'),('0','1','2017','MURNI','Jawa Barat','Bandung','10','12','11','Media/87d0901e8dd2ea7037e55bf83e2346cb.png'),('0','1','2017','MURNI','Jawa Barat','Bandung','10','12','11','Media/87d0901e8dd2ea7037e55bf83e2346cb.png'),('0','1','2018','MURNI','Jawa Barat','Bandung','10','12','11','Media/fb35c241ea8a97853a10f49e3da1e7ff.png'),('0','1','2018','MURNI','Jawa Barat','Bandung','10','12','11','Media/fb35c241ea8a97853a10f49e3da1e7ff.png'),('0','1','2018','MURNI','Jawa Barat','Bandung','10','12','11','Media/fb35c241ea8a97853a10f49e3da1e7ff.png'),('0','1','2018','MURNI','Jawa Barat','Bandung','10','12','11','Media/fb35c241ea8a97853a10f49e3da1e7ff.png'),('0','1','2018','MURNI','Jawa Barat','Bandung','10','12','11','Media/1443b23802e83bb311e5a36af7bd4f3a075704fd62c1f159716eb49d5f8bcf05'),('0','1','2018','MURNI','Jawa Barat','Bandung','10','12','11','Media/83efb4eba6d1765110c5dba44eaba928.png');
/*!40000 ALTER TABLE `settingperencanaan` ENABLE KEYS */;
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
