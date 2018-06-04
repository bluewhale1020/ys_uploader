-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: test
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.8-MariaDB

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
-- Table structure for table `file_uploads`
--

DROP TABLE IF EXISTS `file_uploads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `file_uploads` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `hash_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `mime_type` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `file_size` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file_uploads`
--

LOCK TABLES `file_uploads` WRITE;
/*!40000 ALTER TABLE `file_uploads` DISABLE KEYS */;
INSERT INTO `file_uploads` VALUES (46,'$2y$10$gEg7cUy6LMz4EDb8dHZzkO1IKtAkUwUwbsAYNOf4WnCRZmCM7ErzG','Waterfall.jpg','43ce9cdc1d72a505ede40cbcfc0304fe4ea97fca.jpg','image/jpeg','287631','2018-06-04 15:38:41','2018-06-04 15:38:41','waterfall',5),(48,NULL,'竜巻.png','d55b7c0090d0f2c468f1738e744fd4e5a0cc42ef.png','image/png','100770','2018-06-04 15:41:10','2018-06-04 15:41:10','竜巻',5);
/*!40000 ALTER TABLE `file_uploads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mime_types`
--

DROP TABLE IF EXISTS `mime_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mime_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mime_type` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ext` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ambiguous` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mime_types`
--

LOCK TABLES `mime_types` WRITE;
/*!40000 ALTER TABLE `mime_types` DISABLE KEYS */;
INSERT INTO `mime_types` VALUES (1,'image/jpeg','jpg',0),(2,'image/pjpeg','pjpeg',0),(3,'image/png','png',0),(4,'image/gif','gif',0),(5,'image/tiff','tiff',0),(6,'image/x-tiff','tiff',0),(7,'application/pdf','pdf',0),(8,'application/x-pdf','pdf',0),(9,'application/acrobat','acrobat',0),(10,'text/pdf','pdf',0),(11,'text/x-pdf','pdf',0),(12,'text/plain','txt',0),(13,'application/msword','doc',0),(14,'application/vnd.openxmlformats-officedocument.wordprocessingml.document','docx',0),(15,'application/mspowerpoint','ppt',0),(16,'application/powerpoint','ppt',0),(17,'application/vnd.ms-powerpoint','ppt',0),(18,'application/x-mspowerpoint','ppt',0),(19,'application/vnd.openxmlformats-officedocument.presentationml.presentation','pptx',0),(20,'application/x-msexcel','xls',0),(21,'application/excel','xls',0),(22,'application/x-excel','xls',0),(23,'application/vnd.ms-excel','xls',0),(24,'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','xlsx',0),(25,'application/vnd.ms-access','mdb',0),(26,'application/x-msaccess','mdb',0),(27,'application/x-compressed','zip',0),(28,'application/x-zip-compressed','zip',0),(29,'application/zip','zip',0),(30,'multipart/x-zip','zip',0),(31,'application/x-tar','tar',0),(32,'application/x-compressed','zip',0),(33,'application/x-gzip','gzip',0),(34,'application/x-gzip','gzip',0),(35,'multipart/x-gzip','gzip',0),(36,'application/vnd.ms-office',NULL,1);
/*!40000 ALTER TABLE `mime_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (4,'guest','$2y$10$qQAWrbYnGoLS7RyPoDiCMOOBJFTHJ5C.d7SI0jWCtlGcPK27VucEG','user','2018-06-01 04:16:16','2018-06-01 04:16:16'),(5,'admin','$2y$10$3p2k9WJU86IJ3tuN.688iOh4jnIN6qqLayuHK6X692rSga/Al.9bK','admin','2018-06-01 08:02:14','2018-06-01 08:02:14');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'test'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-06-04 15:42:57
