-- MySQL dump 10.19  Distrib 10.3.34-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: 192.168.160.2    Database: cth
-- ------------------------------------------------------
-- Server version	10.6.10-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_open` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `events_user_id_foreign` (`user_id`),
  CONSTRAINT `events_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=216 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (38,1,'2022-09-22 16:00:00','2022-09-22 20:00:00','Workday',0,'2022-08-10 14:17:35','2022-09-27 16:50:04'),(65,3,'2022-08-29 09:00:00',NULL,'Workday',1,'2022-08-29 08:36:08','2022-08-29 08:36:08'),(68,1,'2022-09-06 16:00:00','2022-09-06 19:05:17','Workday',0,'2022-09-06 14:06:57','2022-09-27 16:50:44'),(69,1,'2022-09-08 16:00:00','2022-09-08 19:11:26','Workday',0,'2022-09-08 14:54:14','2022-09-27 16:50:19'),(70,1,'2022-09-09 09:00:00','2022-09-09 14:00:00','Workday',0,'2022-09-09 07:02:20','2022-09-27 16:50:21'),(71,1,'2022-09-07 09:00:00','2022-09-07 14:00:00','Workday',0,'2022-09-09 07:02:45','2022-09-27 16:50:47'),(72,1,'2022-09-07 16:00:00','2022-09-07 19:15:00','Workday',0,'2022-09-09 07:03:22','2022-09-27 16:50:49'),(73,1,'2022-09-12 09:00:05','2022-09-12 14:21:23','Workday',0,'2022-09-12 12:21:07','2022-09-27 16:50:25'),(74,1,'2022-09-12 16:05:47','2022-09-12 19:11:00','Workday',0,'2022-09-12 14:14:02','2022-09-27 16:50:27'),(75,1,'2022-09-13 16:02:23','2022-09-13 19:15:00','Workday',0,'2022-09-13 14:11:58','2022-09-27 16:50:30'),(76,1,'2022-09-14 09:01:59','2022-09-14 14:05:43','Workday',0,'2022-09-14 10:58:28','2022-09-27 16:50:33'),(80,1,'2022-09-14 16:00:00','2022-09-14 19:05:00','Workday',0,'2022-09-14 15:21:31','2022-09-27 16:50:36'),(81,1,'2022-09-15 16:00:40','2022-09-15 19:12:00','Workday',0,'2022-09-15 17:00:51','2022-09-27 16:50:38'),(82,1,'2022-09-16 09:00:09','2022-09-16 14:11:57','Workday',0,'2022-09-16 07:56:20','2022-09-27 16:50:40'),(83,1,'2022-09-16 16:00:17','2022-09-16 20:08:00','Workday',0,'2022-09-16 14:06:35','2022-09-26 15:06:43'),(85,1,'2022-09-19 09:00:00','2022-09-19 14:51:00','Workday',0,'2022-09-19 19:48:04','2022-09-27 16:49:47'),(86,1,'2022-09-19 16:00:00','2022-09-19 20:05:00','Workday',0,'2022-09-19 19:51:50','2022-09-27 16:49:51'),(147,1,'2022-09-21 08:58:23','2022-09-21 14:10:00','Workday',0,'2022-09-21 15:01:37','2022-09-27 16:49:58'),(149,1,'2022-09-21 16:00:00','2022-09-21 20:00:00','Workday',0,'2022-09-26 11:58:12','2022-09-27 16:50:02'),(150,1,'2022-09-23 09:00:00','2022-09-23 14:10:00','Workday',0,'2022-09-26 14:31:19','2022-09-27 16:50:08'),(151,1,'2022-09-20 16:00:00','2022-09-20 20:00:00','Workday',0,'2022-09-26 14:31:52','2022-09-27 16:49:55'),(152,1,'2022-09-26 09:00:00','2022-09-26 14:05:00','Workday',0,'2022-09-26 14:42:38','2022-09-27 16:50:11'),(153,1,'2022-09-26 16:00:00','2022-09-26 20:15:00','Workday',0,'2022-09-26 14:49:43','2022-09-27 16:51:02'),(154,1,'2022-09-27 16:00:00','2022-09-27 20:05:00','Workday',0,'2022-09-27 16:49:41','2022-09-27 17:54:38'),(155,1,'2022-09-28 09:00:00','2022-09-28 14:00:00','Workday',0,'2022-09-28 09:08:49','2022-09-28 17:49:56'),(156,1,'2022-09-28 15:58:45','2022-09-28 20:06:21','Workday',0,'2022-09-28 17:50:06','2022-09-28 18:09:00'),(157,1,'2022-09-29 15:55:00','2022-09-29 20:18:00','Workday',0,'2022-09-30 07:18:35','2022-09-30 07:38:36'),(158,4,'2022-09-30 12:51:22','2022-09-30 13:17:26','Pausa',0,'2022-09-30 10:51:26','2022-09-30 14:25:53'),(160,1,'2022-09-30 08:59:30','2022-09-30 14:05:00','Workday',0,'2022-09-30 11:36:53','2022-09-30 12:00:17'),(162,1,'2022-09-30 16:00:00','2022-09-30 20:06:00','Workday',0,'2022-09-30 14:25:42','2022-10-09 10:28:41'),(163,4,'2022-10-03 13:58:39','2022-10-03 13:59:25','Workday',0,'2022-10-03 13:58:49','2022-10-03 13:59:33'),(165,5,'2022-10-05 08:00:00','2022-10-05 15:00:00','Workday',0,'2022-10-05 14:01:00','2022-10-06 14:28:54'),(167,1,'2022-10-04 16:00:28','2022-10-04 20:07:00','Workday',0,'2022-10-05 14:07:13','2022-10-09 10:27:53'),(168,4,'2022-10-06 09:00:00','2022-10-06 14:00:01','Workday',0,'2022-10-06 07:59:29','2022-10-10 12:09:05'),(169,4,'2022-10-05 09:00:00','2022-10-05 14:25:53','Workday',0,'2022-10-06 08:35:05','2022-10-09 10:27:23'),(170,5,'2022-10-06 08:00:00','2022-10-06 15:00:00','Workday',0,'2022-10-06 14:29:40','2022-10-06 14:30:19'),(172,4,'2022-10-10 09:00:00','2022-10-10 14:00:00','Workday',0,'2022-10-10 12:08:01','2022-10-10 19:24:02'),(173,4,'2022-10-10 16:00:00','2022-10-10 20:02:46','Workday',0,'2022-10-10 19:24:07','2022-10-10 20:08:00'),(175,4,'2022-10-11 15:58:44','2022-10-11 20:22:00','Workday',0,'2022-10-11 19:02:02','2022-10-11 19:57:48'),(176,5,'2022-10-13 08:00:39','2022-10-13 15:00:00','Workday',0,'2022-10-13 09:23:09','2022-10-13 09:24:28'),(177,4,'2022-10-13 15:58:13','2022-10-13 20:04:58','Workday',0,'2022-10-13 18:31:32','2022-10-13 20:05:06'),(180,4,'2022-10-14 09:00:00','2022-10-14 14:15:00','Workday',0,'2022-10-13 22:59:28','2022-10-14 15:42:43'),(184,4,'2022-10-14 10:33:51','2022-10-14 10:48:00','Pausa',0,'2022-10-14 10:34:20','2022-10-14 13:29:01'),(185,5,'2022-10-14 08:00:02','2022-10-14 15:00:00','Workday',0,'2022-10-14 14:43:23','2022-10-14 14:44:31'),(186,4,'2022-10-14 15:58:47','2022-10-14 20:26:00','Workday',0,'2022-10-14 18:46:04','2022-10-17 14:03:45'),(187,4,'2022-10-17 09:00:08','2022-10-17 14:03:38','Workday',0,'2022-10-17 14:03:37','2022-10-17 14:03:49'),(188,4,'2022-10-17 08:00:00','2022-10-17 15:00:11','Workday',0,'2022-10-17 17:00:39','2022-10-18 09:37:34'),(189,5,'2022-10-18 09:00:00','2022-10-18 14:07:00','Workday',0,'2022-10-18 09:38:12','2022-10-18 23:54:38'),(190,4,'2022-10-18 15:52:25','2022-10-18 20:29:00','Workday',0,'2022-10-18 23:54:00','2022-10-18 23:54:41'),(191,5,'2022-10-19 08:00:11','2022-10-19 15:00:21','Workday',0,'2022-10-19 09:25:57','2022-10-20 21:57:31'),(192,4,'2022-10-19 08:59:42','2022-10-19 14:06:20','Workday',0,'2022-10-19 10:52:52','2022-10-19 14:03:29'),(193,6,'2022-10-19 08:00:43','2022-10-19 15:00:00','Workday',0,'2022-10-19 11:58:02','2022-10-19 11:59:19'),(194,7,'2022-10-19 08:00:00','2022-10-19 15:07:00','Workday',0,'2022-10-19 12:06:27','2022-10-19 12:07:46'),(195,8,'2022-10-19 07:55:00','2022-10-19 15:07:49','Workday',0,'2022-10-19 12:16:39','2022-10-19 12:19:39'),(196,9,'2022-10-19 09:00:00','2022-10-19 20:00:00','Workday',0,'2022-10-19 13:06:49','2022-10-19 13:09:12'),(198,9,'2022-10-19 10:30:00','2022-10-20 14:00:00','Workday',0,'2022-10-19 16:46:13','2022-10-20 21:52:56'),(199,4,'2022-10-19 16:00:00','2022-10-19 21:04:00','Workday',0,'2022-10-19 19:48:29','2022-10-19 19:49:06'),(200,8,'2022-10-20 07:59:32','2022-10-20 15:10:10','Workday',0,'2022-10-20 08:00:04','2022-10-20 15:10:16'),(201,6,'2022-10-20 08:00:00','2022-10-20 15:00:00','Workday',0,'2022-10-20 08:06:05','2022-10-20 21:56:27'),(202,7,'2022-10-20 08:09:22','2022-10-20 14:54:38','Workday',0,'2022-10-20 08:10:36','2022-10-20 14:54:47'),(203,5,'2022-10-20 08:00:33','2022-10-20 15:07:10','Workday',0,'2022-10-20 08:33:06','2022-10-20 21:56:35'),(204,9,'2022-10-20 10:20:00','2022-10-20 14:00:00','Workday',0,'2022-10-20 11:39:13','2022-10-20 21:50:27'),(205,9,'2022-10-20 14:00:00','2022-10-20 15:00:00','Pausa',0,'2022-10-20 21:49:10','2022-10-20 21:50:32'),(206,9,'2022-10-20 15:00:00','2022-10-20 19:40:00','Jornada de trabajo',0,'2022-10-20 21:49:27','2022-10-20 21:50:36'),(207,9,'2022-10-19 14:00:00','2022-10-20 16:00:00','Pausa',0,'2022-10-20 21:51:31','2022-10-20 21:53:02'),(208,9,'2022-10-19 15:00:00','2022-10-20 20:00:00','Jornada de trabajo',0,'2022-10-20 21:52:24','2022-10-20 21:53:22'),(209,4,'2022-10-20 16:00:00','2022-10-20 20:07:00','Workday',0,'2022-10-20 21:54:34','2022-10-20 21:55:16'),(210,8,'2022-10-21 07:58:12',NULL,'Workday',1,'2022-10-21 07:59:19','2022-10-21 07:59:19'),(211,6,'2022-10-21 08:00:00',NULL,'Workday',1,'2022-10-21 08:12:41','2022-10-21 08:12:41'),(213,7,'2022-10-21 08:12:56',NULL,'Workday',1,'2022-10-21 08:15:02','2022-10-21 08:15:02'),(214,5,'2022-10-21 08:02:13','2022-10-21 15:16:58','Workday',0,'2022-10-21 08:16:50','2022-10-21 08:17:25'),(215,4,'2022-10-21 09:00:00',NULL,'Workday',1,'2022-10-21 09:05:38','2022-10-21 09:05:38');
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2014_10_12_200000_add_two_factor_columns_to_users_table',1),(4,'2019_08_19_000000_create_failed_jobs_table',1),(5,'2019_12_14_000001_create_personal_access_tokens_table',1),(6,'2020_05_21_100000_create_teams_table',1),(7,'2020_05_21_200000_create_team_user_table',1),(8,'2020_05_21_300000_create_team_invitations_table',1),(9,'2022_04_28_180745_create_sessions_table',1),(10,'2022_05_17_180450_create_events_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('5idoyBYgpNMBCVaPEhGVsrldc9mgh4QUO8S1SMjT',NULL,'167.94.138.119','Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiU2E2RlVsU2tYRG1rVVVmbGc0MHliajNuUnR2OFZFaFp6dUg2WVk4TCI7czoxNjoibGFzdEFjdGl2aXR5VGltZSI7aToxNjY2MzEwNDAwO3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI1OiJodHRwOi8vMi4xMzkuMjQ4LjIxMTo4MDAwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1666310400),('6QmhBv4OpvbXaaihKPQKxSxhSVZCVvhPAPLJug5e',7,'2.139.248.211','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36','YTo2OntzOjY6Il90b2tlbiI7czo0MDoiUmRySkQzQnFHcWdrbVFrOTJwbDR3M3Nxb1Y4aFVGdk00MGdZSkpEaSI7czoxNjoibGFzdEFjdGl2aXR5VGltZSI7aToxNjY2MzMyOTAyO3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQyOiJodHRwOi8vc2F0dXJuby56YWZhcnJheWEuZXM6ODAwMC9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo3O3M6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEwJDh1Q2pvNVB5dkQzRkYzWU5nSnBFWk93WmhPNWVuUy5odG9XeHg2ZmZpQmRRMEh5ai4uYmMuIjt9',1666332902),('Cq9pfJuu4mddFHdrAmVnM9H4owjHZLmJycTLp2wd',NULL,'90.167.31.81','Mozilla/5.0 (Linux; Android 11; Redmi Note 8 Pro) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.5249.126 Mobile Safari/537.36 OPR/72.0.3767.68191','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVkRLQzZjaGNoVElXUkY3bzgzcjBhM3dlcEJ6RDJjWWw1MUZEZldVOCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czoxNjoibGFzdEFjdGl2aXR5VGltZSI7aToxNjY2MzM1OTg0O3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vc2F0dXJuby56YWZhcnJheWEuZXM6ODAwMCI7fX0=',1666335984),('damNwdWZOzechGGpycYDthiWB5QzvV9ecTh7adPU',NULL,'151.106.41.69','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:55.0) Gecko/20100101 Firefox/55.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSjRIZVhqRmNKbXNSRTh3dWNEaTR1ZmVNWFRpb2piUGdraDRUVE4zaiI7czoxNjoibGFzdEFjdGl2aXR5VGltZSI7aToxNjY2MzE4NzI0O3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI1OiJodHRwOi8vMi4xMzkuMjQ4LjIxMTo4MDAwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1666318725),('fSKRBonA2sy9sHkrbdNJaZabFMRDUWcpY9s6YBSQ',NULL,'128.14.133.58','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36 ','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTDl2OEw0WFN1TVVldkxoNG8yZGtTcUdkRFlSdzBpRzVUNFRlOXNDRiI7czoxNjoibGFzdEFjdGl2aXR5VGltZSI7aToxNjY2MzE4NDU1O3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI1OiJodHRwOi8vMi4xMzkuMjQ4LjIxMTo4MDAwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1666318455),('G2xhjDxlrnJFZYxzRMPPFlj0DEZ8oTyWw4zzNpou',NULL,'92.176.225.236','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.67 Safari/537.36 OPR/87.0.4390.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiV0JCRHRpeWMycFRRMWl0bXZJTkFROGc4Y0VxUThURUl3WTBNQlpubCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czoxNjoibGFzdEFjdGl2aXR5VGltZSI7aToxNjY2Mjk1OTAzO3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vc2F0dXJuby56YWZhcnJheWEuZXM6ODAwMCI7fX0=',1666295903),('Ht4qJDjqz5vfaqJfgmUZvOal6BOYQ2fwsuoNL1GF',NULL,'185.180.143.145','Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.117 Safari/537.36 ','YTo0OntzOjY6Il90b2tlbiI7czo0MDoidmRGY2VCV3NuOVpXQkQ2bjgwRnZtaDVhdXpicFhvek9rU1lLMzFtQyI7czoxNjoibGFzdEFjdGl2aXR5VGltZSI7aToxNjY2MzMyNTMwO3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI1OiJodHRwOi8vMi4xMzkuMjQ4LjIxMTo4MDAwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1666332530),('kSi9JvNWcj47JOVWdGuTXJz3bK6t0ekSrzCFBFEY',NULL,'2.139.248.211','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWXlzcHRja21YcmpHRXZ2UmcwQ1doRnNROGtjYjBSdnRJRXZOdE96VSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czoxNjoibGFzdEFjdGl2aXR5VGltZSI7aToxNjY2MzMyNzc2O3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vc2F0dXJuby56YWZhcnJheWEuZXM6ODAwMCI7fX0=',1666332776),('Le7zxBm0Y52mlGh7IVUx8e6KYXdBXMy6KXBIjf0Y',NULL,'192.168.10.10','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoicTNTTWhsQ1VsRmkxUVZuZlRKYTJmbFhnZ2NuS3o4VFB2VHlOUzRnUiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czoxNjoibGFzdEFjdGl2aXR5VGltZSI7aToxNjY2MzMzMDUxO3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI2OiJodHRwOi8vMTkyLjE2OC4xMC4xMDQ6ODAwMCI7fX0=',1666333051),('ptdHgun8YckX1NX8ZfEu2YXW1in0FUxh5ks3mFX7',8,'46.6.133.253','Mozilla/5.0 (iPhone; CPU iPhone OS 15_6_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.6.1 Mobile/15E148 Safari/604.1','YTo2OntzOjY6Il90b2tlbiI7czo0MDoiSWh4RFFnbDNZaHVKT2d3aDZySGxJOW9NWHpFOUI1dHNPdDRnTGszWiI7czoxNjoibGFzdEFjdGl2aXR5VGltZSI7aToxNjY2MzMyMDg5O3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQyOiJodHRwOi8vc2F0dXJuby56YWZhcnJheWEuZXM6ODAwMC9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo4O3M6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEwJGpKQnVTUmh5SFJUWDYwZXByenQ1dC5MRERKUFNhTC90VDBwQ21ZMnVrL3pRMVI4M243MnphIjt9',1666332089),('pYs8kjSrdyJbgaxpAHb9vtfa9oNiw2NJB4aMTJCU',NULL,'192.241.217.152','Mozilla/5.0 zgrab/0.x','YTo0OntzOjY6Il90b2tlbiI7czo0MDoicHFrUHpaOHFaM0ZhZjFCSEJJY1NHdXd0a1BONHFzMlM0bnRMVWtpeCI7czoxNjoibGFzdEFjdGl2aXR5VGltZSI7aToxNjY2MzA1NDYwO3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI1OiJodHRwOi8vMi4xMzkuMjQ4LjIxMTo4MDAwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1666305460),('s46W9v0pSDd2vcTbYB5Wz91yKV0RHgFUSdQGgLrj',9,'81.38.166.76','Mozilla/5.0 (Linux; Android 12; SM-G973F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Mobile Safari/537.36','YTo2OntzOjY6Il90b2tlbiI7czo0MDoiOGFFcFNXOWVBTjZNcU41QTc5akt3dkRSNkxYU3l2enBFb1A1NTJLdCI7czoxNjoibGFzdEFjdGl2aXR5VGltZSI7aToxNjY2Mjk1NjAxO3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQyOiJodHRwOi8vc2F0dXJuby56YWZhcnJheWEuZXM6ODAwMC9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo5O3M6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEwJHB2Mmx2Q0tFbXhjV0dCVzg4MnpQbS43bTJzM0FEUGZINzFNZGx6bS5VZzRIbVhjbURrRTZPIjt9',1666295602),('wz8MEqI5zCtF2uQvORRuwxh9WN0G80ZKNUB1UAjy',NULL,'111.7.96.150','curl/7.64.1','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZnA5aFRUTTUwSU14U1RPU1Z2TUZsajJwQlZTTGhIbXBDYWFtTlpMWCI7czoxNjoibGFzdEFjdGl2aXR5VGltZSI7aToxNjY2MzAzMDc5O3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI1OiJodHRwOi8vMi4xMzkuMjQ4LjIxMTo4MDAwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1666303079),('XLBcyL34YOF9YPlryX0Dn4lWSQuesW6auQoX8QEG',NULL,'167.94.138.119','','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWnRJYWdDV256TlNETVA5UmozWjZ4UW5OSzFSOFVsMkNOdUdxUnJYOSI7czoxNjoibGFzdEFjdGl2aXR5VGltZSI7aToxNjY2MzEwMzk5O3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI1OiJodHRwOi8vMi4xMzkuMjQ4LjIxMTo4MDAwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1666310399),('ZmDtEhCxe59DPn9XL6gRoOsjECsMipfl0HvQ44XB',NULL,'64.62.197.84','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiR1lRZ1ZoNXVHUk1PZnZCNThHMk1qTWRQaEc5Y1Nra2ZpY25PZmZENiI7czoxNjoibGFzdEFjdGl2aXR5VGltZSI7aToxNjY2MzM1MzIwO3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI1OiJodHRwOi8vMi4xMzkuMjQ4LjIxMTo4MDAwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1666335320);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team_invitations`
--

DROP TABLE IF EXISTS `team_invitations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `team_invitations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `team_id` bigint(20) unsigned NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `team_invitations_team_id_email_unique` (`team_id`,`email`),
  CONSTRAINT `team_invitations_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team_invitations`
--

LOCK TABLES `team_invitations` WRITE;
/*!40000 ALTER TABLE `team_invitations` DISABLE KEYS */;
/*!40000 ALTER TABLE `team_invitations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team_user`
--

DROP TABLE IF EXISTS `team_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `team_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `team_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `team_user_team_id_user_id_unique` (`team_id`,`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team_user`
--

LOCK TABLES `team_user` WRITE;
/*!40000 ALTER TABLE `team_user` DISABLE KEYS */;
INSERT INTO `team_user` VALUES (1,1,3,'user','2022-09-30 09:41:12','2022-09-30 09:41:12'),(2,1,4,'user','2022-09-30 09:42:38','2022-09-30 09:42:38'),(3,1,5,'user','2022-10-05 13:59:51','2022-10-05 13:59:51'),(4,1,6,'user','2022-10-19 11:57:12','2022-10-19 11:57:12'),(5,1,7,'user','2022-10-19 12:05:13','2022-10-19 12:05:13'),(6,1,8,'user','2022-10-19 12:14:47','2022-10-19 12:14:47'),(7,1,9,'user','2022-10-19 13:05:53','2022-10-19 13:05:53');
/*!40000 ALTER TABLE `team_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teams` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_team` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `teams_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
INSERT INTO `teams` VALUES (1,1,'Ayuntamiento de Zafarraya',1,'2022-06-27 07:02:48','2022-08-13 09:54:30'),(2,2,'Siente\'s Team',1,'2022-08-10 15:27:47','2022-08-10 15:27:47'),(3,3,'Siente\'s Team',1,'2022-08-29 08:35:51','2022-08-29 08:35:51'),(4,4,'Guadalinfo\'s Team',1,'2022-09-16 16:28:35','2022-09-16 16:28:35'),(5,5,'José\'s Team',1,'2022-10-05 13:54:56','2022-10-05 13:54:56'),(6,6,'Paola\'s Team',1,'2022-10-19 11:54:35','2022-10-19 11:54:35'),(7,7,'Isabel\'s Team',1,'2022-10-19 12:03:53','2022-10-19 12:03:53'),(8,8,'monica\'s Team',1,'2022-10-19 12:13:41','2022-10-19 12:13:41'),(9,9,'Esther\'s Team',1,'2022-10-19 13:04:17','2022-10-19 13:04:17');
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_code` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `family_name1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `family_name2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint(20) unsigned DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,958368934,'Administrador','del Control Horario','','informatica@zafarraya.es','2022-06-27 07:02:48','$2y$10$Sxg6hNPIi6un56Al5udVr.vqYuN.PSwdIdiTMk7R4Gwc9qzgdRXJ6',NULL,NULL,NULL,'dHKnZkDApd13oxjq4V6gZv1H55GwVZPTpLrYKpaIoXLWC79cmkzIxSzlS6Fo',1,'profile-photos/PYEFQ45wTl4cNTVIPj4ktaeNTolstvcyFZNW7UL2.png','2022-06-27 07:02:48','2022-10-13 18:48:18'),(3,21345678,'Siente','Soluciones','Informáticas','siente@zafarraya.net',NULL,'$2y$10$uKwEz5ejvJ3hWz.UEEMmXuakEUCWu3TD7zHbj.zT/Db8WUPwyEZQe',NULL,NULL,NULL,NULL,3,NULL,'2022-08-29 08:35:51','2022-08-29 08:35:51'),(4,1232222,'***REMOVED***','***REMOVED***','***REMOVED***','guadalinfo.zafarraya@guadalinfo.es',NULL,'$2y$10$Sxg6hNPIi6un56Al5udVr.vqYuN.PSwdIdiTMk7R4Gwc9qzgdRXJ6',NULL,NULL,NULL,NULL,1,'profile-photos/dXeatdGuqJIsd90b7BxknVfQxTZ2ThQxgKwYyHJ4.jpg','2022-09-16 16:28:35','2022-10-13 19:36:26'),(5,95831505,'José Antonio','Sorlózano','Delgado','secretaria@zafarraya.es',NULL,'$2y$10$SUpx5pbB5I7xMXXP8fO1SuowDI6nY4KRyAZC3W9V/I1T3pgOG2f8q',NULL,NULL,NULL,NULL,1,NULL,'2022-10-05 13:54:56','2022-10-05 14:00:12'),(6,25061993,'Paola','Bautista','Molina','jovenahora@zafarraya.es',NULL,'$2y$10$6JLAtNDFbmpNlOYrImQpiexgc3tOHuy2mcjXX79QJo/7gShekdOx6',NULL,NULL,NULL,NULL,1,NULL,'2022-10-19 11:54:35','2022-10-19 11:58:09'),(7,10105918,'Isabel','López','Jiménez','registro@zafarraya.es',NULL,'$2y$10$8uCjo5PyvD3FF3YNgJpEZOwZhO5enS.htoWxx6ffiBdQ0Hyj..bc.',NULL,NULL,NULL,NULL,1,NULL,'2022-10-19 12:03:53','2022-10-19 12:05:28'),(8,12345678,'monica','olmedo','trinidad','urbanismo@zafarraya.es',NULL,'$2y$10$jJBuSRhyHRTX60eprzt5t.LDDJPSaL/tT0pCmY2uk/zQ1R83n72za',NULL,NULL,NULL,NULL,1,NULL,'2022-10-19 12:13:41','2022-10-19 12:21:53'),(9,617976373,'Esther','López','Navarro','biblioteca@zafarraya.es',NULL,'$2y$10$pv2lvCKEmxcWGBW882zPm.7m2s3ADPfH71Mdlzm.Ug4HmXcmDkE6O',NULL,NULL,NULL,NULL,1,NULL,'2022-10-19 13:04:17','2022-10-19 13:10:26');
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

-- Dump completed on 2022-10-21  8:29:05
