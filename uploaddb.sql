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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_default` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'一般','一般カテゴリ。カテゴリの無いものもここに入る。',1),(2,'青葉','青葉業務関連カテゴリ',NULL);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

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
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file_uploads`
--

LOCK TABLES `file_uploads` WRITE;
/*!40000 ALTER TABLE `file_uploads` DISABLE KEYS */;
INSERT INTO `file_uploads` VALUES (46,'$2y$10$gEg7cUy6LMz4EDb8dHZzkO1IKtAkUwUwbsAYNOf4WnCRZmCM7ErzG','Waterfall.jpg','43ce9cdc1d72a505ede40cbcfc0304fe4ea97fca.jpg','image/jpeg','287631','2018-06-04 15:38:41','2018-06-04 15:38:41','waterfall',5,NULL),(48,NULL,'竜巻.png','d55b7c0090d0f2c468f1738e744fd4e5a0cc42ef.png','image/png','100770','2018-06-04 15:41:10','2018-06-04 15:41:10','竜巻',5,NULL),(51,'$2y$10$jsgh5d.hgkDpBIguK7/yoOPJQX65Naal8JVuV5Mc73ksciplziBue','日計表レポート.jpg','8a34d27036e693e063d9ca2e2470473c4b8fddb6.jpg','image/jpeg','58290','2018-06-05 17:10:40','2018-06-05 17:10:40','レポート',5,2),(52,'$2y$10$.Zh17DS2NX7ttxz1N.E1JOyrcblbq5vN4u8gpDzLew7LBNxBxjJK6','住所検索ボタン.jpg','de28984850011aeb109271273f8017f326d6fc50.jpg','image/jpeg','6240','2018-06-06 08:26:25','2018-06-06 08:26:25','住所検索',5,2),(61,NULL,'gitignore_global.txt','9420e4415ea71c626bbe080e70189aeb8e2e1361.txt','text/plain','236','2018-06-11 15:49:14','2018-06-11 15:49:14','gitignore',5,1),(64,NULL,'MsTest使用方法.txt','e1b12b87dbd692d3d5642edf4f0b806ccb45a92c.txt','text/plain','2513','2018-06-12 14:06:12','2018-06-12 14:06:12','mstest使用方法',5,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mime_types`
--

LOCK TABLES `mime_types` WRITE;
/*!40000 ALTER TABLE `mime_types` DISABLE KEYS */;
INSERT INTO `mime_types` VALUES (1,'image/jpeg','jpg',0),(2,'image/pjpeg','pjpeg',0),(3,'image/png','png',0),(4,'image/gif','gif',0),(5,'image/tiff','tiff',0),(6,'image/x-tiff','tiff',0),(7,'application/pdf','pdf',0),(8,'application/x-pdf','pdf',0),(9,'application/acrobat','acrobat',0),(10,'text/pdf','pdf',0),(11,'text/x-pdf','pdf',0),(12,'text/plain','txt',0),(13,'application/msword','doc',0),(14,'application/vnd.openxmlformats-officedocument.wordprocessingml.document','docx',0),(15,'application/mspowerpoint','ppt',0),(16,'application/powerpoint','ppt',0),(17,'application/vnd.ms-powerpoint','ppt',0),(18,'application/x-mspowerpoint','ppt',0),(19,'application/vnd.openxmlformats-officedocument.presentationml.presentation','pptx',0),(20,'application/x-msexcel','xls',0),(21,'application/excel','xls',0),(22,'application/x-excel','xls',0),(23,'application/vnd.ms-excel','xls',0),(24,'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','xlsx',0),(25,'application/vnd.ms-access','mdb',0),(26,'application/x-msaccess','mdb',0),(27,'application/x-compressed','zip',0),(28,'application/x-zip-compressed','zip',0),(29,'application/zip','zip',0),(30,'multipart/x-zip','zip',0),(31,'application/x-tar','tar',0),(32,'application/x-compressed','zip',0),(33,'application/x-gzip','gzip',0),(34,'application/x-gzip','gzip',0),(35,'multipart/x-gzip','gzip',0),(36,'application/vnd.ms-office',NULL,1),(37,'text/csv','csv',0);
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

-- Dump completed on 2018-06-12 16:48:57
