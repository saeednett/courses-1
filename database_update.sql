-- MySQL dump 10.13  Distrib 8.0.15, for macos10.14 (x86_64)
--
-- Host: localhost    Database: courses
-- ------------------------------------------------------
-- Server version	8.0.15

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8mb4 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `administrators`
--

DROP TABLE IF EXISTS `administrators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `administrators` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrators`
--

LOCK TABLES `administrators` WRITE;
/*!40000 ALTER TABLE `administrators` DISABLE KEYS */;
INSERT INTO `administrators` VALUES (1,1,'حامد المالكي','default.jpg','2019-05-24 23:24:52',NULL);
/*!40000 ALTER TABLE `administrators` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `center_id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_user_id_unique` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,5,'Bakur Mohammed Aymeen1',1,'Ht1aU5fiz0xClIyLnc9pdxdtBf4xOCkjlhqyTBvx.png','2019-05-25 04:08:50','2019-05-25 20:57:26');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `advertising_banners`
--

DROP TABLE IF EXISTS `advertising_banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `advertising_banners` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `banner` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `advertising_banners`
--

LOCK TABLES `advertising_banners` WRITE;
/*!40000 ALTER TABLE `advertising_banners` DISABLE KEYS */;
INSERT INTO `advertising_banners` VALUES (1,'wtHH2URV2OCKtfueTZv0pL9ki6JEfYOxslOTC3lr.jpeg','Just Title','https://www.google.com',1,'Just Click Here','2019-05-25 21:06:42','2019-05-25 21:06:42');
/*!40000 ALTER TABLE `advertising_banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attendances`
--

DROP TABLE IF EXISTS `attendances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `attendances` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendances`
--

LOCK TABLES `attendances` WRITE;
/*!40000 ALTER TABLE `attendances` DISABLE KEYS */;
/*!40000 ALTER TABLE `attendances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banks`
--

DROP TABLE IF EXISTS `banks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `banks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banks`
--

LOCK TABLES `banks` WRITE;
/*!40000 ALTER TABLE `banks` DISABLE KEYS */;
INSERT INTO `banks` VALUES (1,'البنك الأهلي التجاري','img/main/','2019-05-24 23:24:51',NULL),(2,'البنك السعودي البريطاني','img/main/','2019-05-24 23:24:51',NULL),(3,'البنك السعودي الفرنسي','img/main/','2019-05-24 23:24:51',NULL),(4,'البنك الأول','img/main/','2019-05-24 23:24:51',NULL),(5,'البنك السعودي للاستثمار','img/main/','2019-05-24 23:24:51',NULL),(6,'البنك العربي الوطني','img/main/','2019-05-24 23:24:51',NULL),(7,'بنك البلاد','img/main/','2019-05-24 23:24:51',NULL),(8,'بنك الجزيرة','img/main/','2019-05-24 23:24:51',NULL),(9,'بنك الرياض','img/main/','2019-05-24 23:24:51',NULL),(10,'مجموعة سامبا المالية (سامبا)','img/main/','2019-05-24 23:24:51',NULL),(11,'مصرف الراجحي','img/main/','2019-05-24 23:24:51',NULL),(12,'مصرف الإنماء','img/main/','2019-05-24 23:24:51',NULL);
/*!40000 ALTER TABLE `banks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'تدريب المدربين','2019-05-24 23:24:51',NULL),(2,'الإدارة','2019-05-24 23:24:51',NULL),(3,'المالية والمحاسبة','2019-05-24 23:24:52',NULL),(4,'بنوك وتأمين','2019-05-24 23:24:52',NULL),(5,'الحاسب وتقنية المعلومات','2019-05-24 23:24:52',NULL),(6,'لغات وترجمة','2019-05-24 23:24:52',NULL),(7,'تطوير ذات','2019-05-24 23:24:52',NULL),(8,'رسم وفنون وتصميم','2019-05-24 23:24:52',NULL),(9,'القيادة','2019-05-24 23:24:52',NULL),(10,'الأسرة والطفل','2019-05-24 23:24:52',NULL),(11,'قانون','2019-05-24 23:24:52',NULL),(12,'طب و أسعافات الأولية','2019-05-24 23:24:52',NULL),(13,'امن وسلامة','2019-05-24 23:24:52',NULL),(14,'رياضة ولياقة','2019-05-24 23:24:52',NULL),(15,'نظام العمل','2019-05-24 23:24:52',NULL),(16,'علاقات دوليه ودبلوماسية','2019-05-24 23:24:52',NULL),(17,'رحلات تدريبية','2019-05-24 23:24:52',NULL),(18,'تعليم وتربية','2019-05-24 23:24:52',NULL),(19,'ريادة أعمال','2019-05-24 23:24:52',NULL),(20,'سكرتارية','2019-05-24 23:24:52',NULL),(21,'تصميم حقائب تدريب','2019-05-24 23:24:52',NULL),(22,'العلاقات العامة والاعلام','2019-05-24 23:24:52',NULL),(23,'الجودة','2019-05-24 23:24:52',NULL),(24,'صيانة الجوالات','2019-05-24 23:24:52',NULL),(25,'اللوجستيات وسلاسل الإمداد','2019-05-24 23:24:52',NULL),(26,'إدارة مشاريع','2019-05-24 23:24:52',NULL),(27,'مكياج','2019-05-24 23:24:52',NULL),(28,'تسويق ومبيعات','2019-05-24 23:24:52',NULL),(29,'التدريب الشخصي الكوتشينج','2019-05-24 23:24:52',NULL),(30,'تصميم هندسي','2019-05-24 23:24:52',NULL),(31,'التخطيط الأستراتيجي','2019-05-24 23:24:52',NULL),(32,'التصوير والإخراج','2019-05-24 23:24:52',NULL),(33,'معرض عالم التطبيقات','2019-05-24 23:24:52',NULL),(34,'العرض والإلقاء','2019-05-24 23:24:52',NULL),(35,'إدارة الفعاليات والمؤتمرات','2019-05-24 23:24:52',NULL),(36,'العروض الخاصة','2019-05-24 23:24:52',NULL),(37,'الخلطات والعطور','2019-05-24 23:24:52',NULL),(38,'معرض سعودي موبايل شو','2019-05-24 23:24:52',NULL),(39,'الموارد البشرية','2019-05-24 23:24:52',NULL),(40,'دورات الشرعية','2019-05-24 23:24:52',NULL);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `center_accounts`
--

DROP TABLE IF EXISTS `center_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `center_accounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `center_id` int(11) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `account_owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_number` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `center_accounts`
--

LOCK TABLES `center_accounts` WRITE;
/*!40000 ALTER TABLE `center_accounts` DISABLE KEYS */;
INSERT INTO `center_accounts` VALUES (1,1,1,'جمعية وقف الخيرات','92437657828645787687','2019-05-25 02:28:15','2019-05-25 02:28:15'),(2,1,4,'جمعية وقف الخيرات','7658970798654869709896854','2019-05-25 04:18:40','2019-05-25 04:18:40');
/*!40000 ALTER TABLE `center_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `center_social_media`
--

DROP TABLE IF EXISTS `center_social_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `center_social_media` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `center_id` int(11) NOT NULL,
  `social_media_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `center_social_media`
--

LOCK TABLES `center_social_media` WRITE;
/*!40000 ALTER TABLE `center_social_media` DISABLE KEYS */;
INSERT INTO `center_social_media` VALUES (1,'khirat',1,1,1,'2019-05-25 04:18:57','2019-05-25 04:18:57');
/*!40000 ALTER TABLE `center_social_media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `centers`
--

DROP TABLE IF EXISTS `centers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `centers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `about` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verification_code` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verification_authority` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `centers_user_id_unique` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `centers`
--

LOCK TABLES `centers` WRITE;
/*!40000 ALTER TABLE `centers` DISABLE KEYS */;
INSERT INTO `centers` VALUES (1,3,'وقف الخيرات',4,1,'جمعية خيرية تهدف لتنمية المجتمع وتقديم الدعم المادي','upZsX2jqfDzsJiCOcrbfNwZCQ62XNY0dQFqC8zJB.png',NULL,'7936457246','الهيئة العامة للأوقاف','2019-05-25 02:28:15','2019-05-25 02:28:15');
/*!40000 ALTER TABLE `centers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `certificates`
--

DROP TABLE IF EXISTS `certificates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `certificates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `viewed` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `certificates`
--

LOCK TABLES `certificates` WRITE;
/*!40000 ALTER TABLE `certificates` DISABLE KEYS */;
INSERT INTO `certificates` VALUES (1,'2019-05-25',1,1,0,1,1,'2019-05-25 20:22:45','2019-05-25 20:22:52');
/*!40000 ALTER TABLE `certificates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `cities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cities`
--

LOCK TABLES `cities` WRITE;
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (1,1,'تبوك','2019-05-24 23:24:51',NULL),(2,1,'الرياض','2019-05-24 23:24:51',NULL),(3,1,'الطائف','2019-05-24 23:24:51',NULL),(4,1,'مكة المكرمة','2019-05-24 23:24:51',NULL),(5,1,'حائل','2019-05-24 23:24:51',NULL),(6,1,'بريدة','2019-05-24 23:24:51',NULL),(7,1,'الهفوف','2019-05-24 23:24:51',NULL),(8,1,'الدمام','2019-05-24 23:24:51',NULL),(9,1,'المدينة المنورة','2019-05-24 23:24:51',NULL),(10,1,'ابها','2019-05-24 23:24:51',NULL),(11,1,'جازان','2019-05-24 23:24:51',NULL),(12,1,'جدة','2019-05-24 23:24:51',NULL),(13,1,'المجمعة','2019-05-24 23:24:51',NULL),(14,1,'الخبر','2019-05-24 23:24:51',NULL),(15,1,'حفر الباطن','2019-05-24 23:24:51',NULL),(16,1,'خميس مشيط','2019-05-24 23:24:51',NULL),(17,1,'احد رفيده','2019-05-24 23:24:51',NULL),(18,1,'القطيف','2019-05-24 23:24:51',NULL),(19,1,'عنيزة','2019-05-24 23:24:51',NULL),(20,1,'قرية العليا','2019-05-24 23:24:51',NULL),(21,1,'الجبيل','2019-05-24 23:24:51',NULL),(22,1,'النعيرية','2019-05-24 23:24:51',NULL),(23,1,'الظهران','2019-05-24 23:24:51',NULL),(24,1,'الوجه','2019-05-24 23:24:51',NULL),(25,1,'بقيق','2019-05-24 23:24:51',NULL),(26,1,'الزلفي','2019-05-24 23:24:51',NULL),(27,1,'خيبر','2019-05-24 23:24:51',NULL),(28,1,'الغاط','2019-05-24 23:24:51',NULL),(29,1,'املج','2019-05-24 23:24:51',NULL),(30,1,'رابغ','2019-05-24 23:24:51',NULL),(31,1,'عفيف','2019-05-24 23:24:51',NULL),(32,1,'ثادق','2019-05-24 23:24:51',NULL),(33,1,'سيهات','2019-05-24 23:24:51',NULL),(34,1,'تاروت','2019-05-24 23:24:51',NULL),(35,1,'ينبع','2019-05-24 23:24:51',NULL),(36,1,'شقراء','2019-05-24 23:24:51',NULL),(37,1,'الدوادمي','2019-05-24 23:24:51',NULL),(38,1,'الدرعية','2019-05-24 23:24:51',NULL),(39,1,'القويعية','2019-05-24 23:24:51',NULL),(40,1,'المزاحمية','2019-05-24 23:24:51',NULL),(41,1,'بدر','2019-05-24 23:24:51',NULL),(42,1,'الخرج','2019-05-24 23:24:51',NULL),(43,1,'الدلم','2019-05-24 23:24:51',NULL),(44,1,'الشنان','2019-05-24 23:24:51',NULL),(45,1,'الخرمة','2019-05-24 23:24:51',NULL),(46,1,'الجموم','2019-05-24 23:24:51',NULL),(47,1,'المجاردة','2019-05-24 23:24:51',NULL),(48,1,'السليل','2019-05-24 23:24:51',NULL),(49,1,'تثليث','2019-05-24 23:24:51',NULL),(50,1,'بيشة','2019-05-24 23:24:51',NULL),(51,1,'الباحة','2019-05-24 23:24:51',NULL),(52,1,'القنفذة','2019-05-24 23:24:51',NULL),(53,1,'محايل','2019-05-24 23:24:51',NULL),(54,1,'ثول','2019-05-24 23:24:51',NULL),(55,1,'ضبا','2019-05-24 23:24:51',NULL),(56,1,'تربه','2019-05-24 23:24:51',NULL),(57,1,'صفوى','2019-05-24 23:24:51',NULL),(58,1,'عنك','2019-05-24 23:24:51',NULL),(59,1,'طريف','2019-05-24 23:24:51',NULL),(60,1,'عرعر','2019-05-24 23:24:51',NULL),(61,1,'القريات','2019-05-24 23:24:51',NULL),(62,1,'سكاكا','2019-05-24 23:24:51',NULL),(63,1,'رفحاء','2019-05-24 23:24:51',NULL),(64,1,'دومة الجندل','2019-05-24 23:24:51',NULL),(65,1,'الرس','2019-05-24 23:24:51',NULL),(66,1,'المذنب','2019-05-24 23:24:51',NULL),(67,1,'الخفجي','2019-05-24 23:24:51',NULL),(68,1,'رياض الخبراء','2019-05-24 23:24:51',NULL),(69,1,'البدائع','2019-05-24 23:24:51',NULL),(70,1,'رأس تنورة','2019-05-24 23:24:51',NULL),(71,1,'البكيرية','2019-05-24 23:24:51',NULL),(72,1,'الشماسية','2019-05-24 23:24:51',NULL),(73,1,'الحريق','2019-05-24 23:24:51',NULL),(74,1,'حوطة بني تميم','2019-05-24 23:24:51',NULL),(75,1,'ليلى','2019-05-24 23:24:51',NULL),(76,1,'بللسمر','2019-05-24 23:24:51',NULL),(77,1,'شرورة','2019-05-24 23:24:51',NULL),(78,1,'نجران','2019-05-24 23:24:51',NULL),(79,1,'صبيا','2019-05-24 23:24:51',NULL),(80,1,'ابو عريش','2019-05-24 23:24:51',NULL),(81,1,'صامطة','2019-05-24 23:24:51',NULL),(82,1,'احد المسارحة','2019-05-24 23:24:51',NULL),(83,1,'مدينة الملك عبدالله الاقتصادية','2019-05-24 23:24:51',NULL);
/*!40000 ALTER TABLE `cities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_us`
--

DROP TABLE IF EXISTS `contact_us`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `contact_us` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subject` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registered` int(11) NOT NULL DEFAULT '0',
  `account_id` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_us`
--

LOCK TABLES `contact_us` WRITE;
/*!40000 ALTER TABLE `contact_us` DISABLE KEYS */;
INSERT INTO `contact_us` VALUES (1,'test message','محمد بكر','058746539876','junkmail@junkmail.com','I just want to test your website to see how secure it is',1,2,'2019-05-25 21:04:48','2019-05-25 21:04:48');
/*!40000 ALTER TABLE `contact_us` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `countries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES (1,'المملكة العربية السعودية','2019-05-24 23:24:51',NULL);
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `coupons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupons`
--

LOCK TABLES `coupons` WRITE;
/*!40000 ALTER TABLE `coupons` DISABLE KEYS */;
INSERT INTO `coupons` VALUES (1,'laravel-20',20,1,'2019-05-25 04:14:03','2019-05-25 04:14:03'),(2,'laravel-50',50,1,'2019-05-25 04:14:03','2019-05-25 04:14:03');
/*!40000 ALTER TABLE `coupons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_admins`
--

DROP TABLE IF EXISTS `course_admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `course_admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_admins`
--

LOCK TABLES `course_admins` WRITE;
/*!40000 ALTER TABLE `course_admins` DISABLE KEYS */;
INSERT INTO `course_admins` VALUES (1,1,1,1,'2019-05-25 04:17:49','2019-05-25 04:17:49');
/*!40000 ALTER TABLE `course_admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_trainers`
--

DROP TABLE IF EXISTS `course_trainers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `course_trainers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `trainer_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_trainers`
--

LOCK TABLES `course_trainers` WRITE;
/*!40000 ALTER TABLE `course_trainers` DISABLE KEYS */;
INSERT INTO `course_trainers` VALUES (1,1,1,'2019-05-25 04:14:03','2019-05-25 04:14:03');
/*!40000 ALTER TABLE `course_trainers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `courses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `identifier` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `start_time` time NOT NULL,
  `hours` int(11) NOT NULL,
  `end_reservation` date NOT NULL,
  `attendance` int(11) NOT NULL,
  `gender` int(11) NOT NULL,
  `men` int(11) NOT NULL,
  `women` int(11) NOT NULL,
  `coupon` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `center_id` int(11) NOT NULL,
  `visible` int(11) NOT NULL DEFAULT '1',
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `validation` int(11) NOT NULL DEFAULT '0',
  `activation` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `courses_identifier_unique` (`identifier`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES (1,'laravel programming','A1GUGQwMv3','الشوقية - خلف البيك','https://www.google.com',300,'payed','2019-05-31','2019-06-30','18:30:00',20,'2019-05-31',100,3,50,50,1,5,4,1,1,1,'!!You will how to learn program a websites using php and laravel freawork',1,1,'2019-05-25 04:14:03','2019-05-25 20:38:35');
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deadlines`
--

DROP TABLE IF EXISTS `deadlines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `deadlines` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deadlines`
--

LOCK TABLES `deadlines` WRITE;
/*!40000 ALTER TABLE `deadlines` DISABLE KEYS */;
/*!40000 ALTER TABLE `deadlines` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `genders`
--

DROP TABLE IF EXISTS `genders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `genders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genders`
--

LOCK TABLES `genders` WRITE;
/*!40000 ALTER TABLE `genders` DISABLE KEYS */;
INSERT INTO `genders` VALUES (1,'ذكز','2019-05-24 23:24:51',NULL),(2,'أثنى','2019-05-24 23:24:51',NULL);
/*!40000 ALTER TABLE `genders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `halalahs`
--

DROP TABLE IF EXISTS `halalahs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `halalahs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `center_id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default.jpg',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `halalahs`
--

LOCK TABLES `halalahs` WRITE;
/*!40000 ALTER TABLE `halalahs` DISABLE KEYS */;
INSERT INTO `halalahs` VALUES (1,1,'nCPW0HVDJpIxo7sM5Mx1ywjF4448wJ01ucFT6sjv.jpeg','جمعية وقف الخيرات',1,'2019-05-25 04:29:03','2019-05-25 04:29:03');
/*!40000 ALTER TABLE `halalahs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES (1,'yeEcdX5y2v1RGm4gFUiqJ05I5FYQfJEBWmJWh4Me.jpeg','CZbsKTznwHaadYvsjyOzNLlbU42pN7ZErzGh2Fqw.jpeg',1,'2019-05-25 04:14:03','2019-05-25 04:14:03');
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_01_12_194802_create_students_table',1),(4,'2019_01_12_195730_create_reservations_table',1),(5,'2019_01_12_200322_create_attendances_table',1),(6,'2019_01_12_201354_create_certificates_table',1),(7,'2019_01_12_201648_create_images_table',1),(8,'2019_01_12_201937_create_centers_table',1),(9,'2019_01_12_202230_create_countries_table',1),(10,'2019_01_12_202419_create_cities_table',1),(11,'2019_01_12_202847_create_categories_table',1),(12,'2019_01_12_203014_create_banks_table',1),(13,'2019_01_12_203225_create_admins_table',1),(14,'2019_01_12_203446_create_coupons_table',1),(15,'2019_01_12_203935_create_templates_table',1),(16,'2019_01_12_204153_create_trainers_table',1),(17,'2019_01_12_204412_create_deadlines_table',1),(18,'2019_01_12_204552_create_courses_table',1),(19,'2019_01_13_131901_create_genders_table',1),(20,'2019_01_23_155510_create_nationalities_table',1),(21,'2019_01_23_160020_create_titles_table',1),(22,'2019_01_26_092026_create_course_trainers_table',1),(23,'2019_02_09_132714_create_center_accounts_table',1),(24,'2019_02_12_145859_create_payment_confirmations_table',1),(25,'2019_02_13_170139_create_course_admins_table',1),(26,'2019_02_27_141830_create_roles_table',1),(27,'2019_03_03_140528_create_advertising_banners_table',1),(28,'2019_03_14_234137_create_social_media_table',1),(29,'2019_03_14_234240_create_center_social_media_table',1),(30,'2019_03_21_221414_create_halalahs_table',1),(31,'2019_03_22_132852_create_contact_uses_table',1),(32,'2019_04_01_172440_create_administrators_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nationalities`
--

DROP TABLE IF EXISTS `nationalities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `nationalities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nationalities`
--

LOCK TABLES `nationalities` WRITE;
/*!40000 ALTER TABLE `nationalities` DISABLE KEYS */;
INSERT INTO `nationalities` VALUES (1,'أردني','2019-05-24 23:24:51',NULL),(2,'إماراتي','2019-05-24 23:24:51',NULL),(3,'بحريني','2019-05-24 23:24:51',NULL),(4,'جزائري','2019-05-24 23:24:51',NULL),(5,'سوداني','2019-05-24 23:24:51',NULL),(6,'صومالي','2019-05-24 23:24:51',NULL),(7,'صيني','2019-05-24 23:24:51',NULL),(8,'عراقي','2019-05-24 23:24:51',NULL),(9,'كويتي','2019-05-24 23:24:51',NULL),(10,'مغربي','2019-05-24 23:24:51',NULL),(11,'سعودي','2019-05-24 23:24:51',NULL),(12,'يمني','2019-05-24 23:24:51',NULL),(13,'تركي','2019-05-24 23:24:51',NULL),(14,'تشادي','2019-05-24 23:24:51',NULL),(15,'تونسي','2019-05-24 23:24:51',NULL),(16,'سوري','2019-05-24 23:24:51',NULL),(17,'عماني','2019-05-24 23:24:51',NULL),(18,'فلسطيني','2019-05-24 23:24:51',NULL),(19,'قطري','2019-05-24 23:24:51',NULL),(20,'لبناني','2019-05-24 23:24:51',NULL),(21,'مالي','2019-05-24 23:24:51',NULL),(22,'ماليزي','2019-05-24 23:24:51',NULL),(23,'مصري','2019-05-24 23:24:51',NULL),(24,'نيجيري','2019-05-24 23:24:51',NULL);
/*!40000 ALTER TABLE `nationalities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `password_resets` (
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments_confirmation`
--

DROP TABLE IF EXISTS `payments_confirmation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `payments_confirmation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments_confirmation`
--

LOCK TABLES `payments_confirmation` WRITE;
/*!40000 ALTER TABLE `payments_confirmation` DISABLE KEYS */;
INSERT INTO `payments_confirmation` VALUES (1,'سعود سعيد حمزة','89764237652278645927','WHmhj1iA8iJtrmeUejrNujqLvexj53gruOuW3eBD.jpeg',1,1,'2019-05-25 20:21:59','2019-05-25 20:21:59');
/*!40000 ALTER TABLE `payments_confirmation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `reservations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL DEFAULT '0',
  `identifier` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `confirmation` int(11) NOT NULL DEFAULT '0',
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reservations_identifier_unique` (`identifier`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservations`
--

LOCK TABLES `reservations` WRITE;
/*!40000 ALTER TABLE `reservations` DISABLE KEYS */;
INSERT INTO `reservations` VALUES (1,1,1,0,'q2ci89D3AV',1,'A1GUGQwMv3q2ci89D3AVQTfrXTbBwR','2019-05-25 20:14:54','2019-05-25 20:21:16');
/*!40000 ALTER TABLE `reservations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'administrator','2019-05-24 23:24:51',NULL),(2,'center','2019-05-24 23:24:51',NULL),(3,'admin','2019-05-24 23:24:51',NULL),(4,'trainer','2019-05-24 23:24:51',NULL),(5,'student','2019-05-24 23:24:51',NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `social_media`
--

DROP TABLE IF EXISTS `social_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `social_media` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_media`
--

LOCK TABLES `social_media` WRITE;
/*!40000 ALTER TABLE `social_media` DISABLE KEYS */;
INSERT INTO `social_media` VALUES (1,'Twitter','https://www.twitter.com/','social-twitter','img/main/twitter.png','2019-05-24 23:24:51',NULL),(2,'Facebook','https://www.facebook.com/','social-facebook','img/main/facebook.png','2019-05-24 23:24:51',NULL),(3,'Snapchat','https://www.snapchat.com/add/','social-snapchat','img/main/snapchat.png','2019-05-24 23:24:51',NULL),(4,'Instagram','https://www.instagram.com/','social-instagram','img/main/instagram.png','2019-05-24 23:24:51',NULL);
/*!40000 ALTER TABLE `social_media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `students` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `second_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `third_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0000',
  `month` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '00',
  `day` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '00',
  `gender_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `image` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default.png',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `students_user_id_unique` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (1,2,'سعود','سعيد',NULL,NULL,'0','0','0',1,4,'default.jpg','2019-05-24 23:26:10','2019-05-24 23:26:10');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `templates`
--

DROP TABLE IF EXISTS `templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `templates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `templates`
--

LOCK TABLES `templates` WRITE;
/*!40000 ALTER TABLE `templates` DISABLE KEYS */;
INSERT INTO `templates` VALUES (1,'القالب الأول','2019-05-24 23:24:51',NULL),(2,'القالب الثانية','2019-05-24 23:24:51',NULL),(3,'القالب الثالثة','2019-05-24 23:24:51',NULL);
/*!40000 ALTER TABLE `templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `titles`
--

DROP TABLE IF EXISTS `titles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `titles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `titles`
--

LOCK TABLES `titles` WRITE;
/*!40000 ALTER TABLE `titles` DISABLE KEYS */;
INSERT INTO `titles` VALUES (1,' السيد/ة','2019-05-24 23:24:51',NULL),(2,' الأستاذ/ة','2019-05-24 23:24:51',NULL),(3,' الدكتور/ة','2019-05-24 23:24:51',NULL),(4,' المهندس/ة','2019-05-24 23:24:51',NULL),(5,' الفنان/ة','2019-05-24 23:24:51',NULL),(6,' المستشار/ة','2019-05-24 23:24:51',NULL),(7,' معالي الشيخ/ة','2019-05-24 23:24:51',NULL);
/*!40000 ALTER TABLE `titles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trainers`
--

DROP TABLE IF EXISTS `trainers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `trainers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `center_id` int(11) NOT NULL,
  `title_id` int(11) NOT NULL,
  `nationality_id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `trainers_user_id_unique` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trainers`
--

LOCK TABLES `trainers` WRITE;
/*!40000 ALTER TABLE `trainers` DISABLE KEYS */;
INSERT INTO `trainers` VALUES (1,4,'Mohammed Ahmed Ali',1,3,5,'F5ZgcxaoUASazrws4s7mdz4Ssvg5X71Ocj7vuUxw.png','2019-05-25 04:06:09','2019-05-25 04:06:09');
/*!40000 ALTER TABLE `trainers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_phone_unique` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'administrator','administrator@gmail.com','590000000','$2y$10$gBXQ6lXPYBHkBylM/RwAxejevyi8QDSql8wqipC.KXwjlr6prBvWu',1,1,NULL,'dHrxN7anVRELZc3vCXdlOf7TT6BjxZfsuIuVB3dm2QbhtvAeM7iEmpKm0T4d','2019-05-24 23:24:52',NULL),(2,'soao_d','soao_d@hotmail.com','+966592970476','$2y$10$aOPjHDrDJMfziLKLCY5x3OsCbb3raM4DVpCxBOkWHkm3Cch77mXgS',5,1,NULL,'xU0oXmgfin2imVLH4j2qcL2mQ1zTmEdMYKK6C50KUZbvlNJbP3QZ3Vff0qEm','2019-05-24 23:26:10','2019-05-24 23:26:10'),(3,'khirat','khirat@hotmail.com','0537869018','$2y$10$z06jWPvxURb96E9W9qBHNOchQc2DHKEu1wX38nOK4EqwdF4kJDX12',2,1,NULL,'4dglv9hzu1D4SZ8wwlhQcXLVHpEU7e1FcZf8QLFvwLivh2d1spiIlkcDcbkL','2019-05-25 02:28:15','2019-05-25 02:28:15'),(4,'memo_2019','memo@hotmail.com','542847527','$2y$10$saE4sIcCdlBACO.S14J5WOcBDZqutFABN/cZ0qhgxRFdiTgII5Dfu',4,1,NULL,'v6Qx2gmANDLLEQ5kO7ttylhQ9XUGip9V6yA2m0dq5g7zATnouBScaBiwfl1j','2019-05-25 04:06:09','2019-05-25 04:06:09'),(5,'baby_2019','baby_2019@gmail.com','518497601','$2y$10$0q6IUkStIkXPVnZMRcnRjecHsceFpInsb9LLLDcve.6PquNp1p/m2',3,1,NULL,'6FlYvqH0Xk9D5QZvOWe7gY8l2kmKSRPSTLiuHwnI79fUDunxZIy8oXrOu1fk','2019-05-25 04:08:50','2019-05-25 04:08:50');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-06-05  7:19:33
