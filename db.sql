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
) ENGINE=InnoDB AUTO_INCREMENT=179 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (38,1,'2022-09-22 16:00:00','2022-09-22 20:00:00','Jornada de trabajo',0,'2022-08-10 14:17:35','2022-09-27 16:50:04'),(65,3,'2022-08-29 09:00:00',NULL,'Jornada de trabajo',1,'2022-08-29 08:36:08','2022-08-29 08:36:08'),(68,1,'2022-09-06 16:00:00','2022-09-06 19:05:17','Jornada de trabajo',0,'2022-09-06 14:06:57','2022-09-27 16:50:44'),(69,1,'2022-09-08 16:00:00','2022-09-08 19:11:26','Jornada de trabajo',0,'2022-09-08 14:54:14','2022-09-27 16:50:19'),(70,1,'2022-09-09 09:00:00','2022-09-09 14:00:00','Jornada de trabajo',0,'2022-09-09 07:02:20','2022-09-27 16:50:21'),(71,1,'2022-09-07 09:00:00','2022-09-07 14:00:00','Jornada de trabajo',0,'2022-09-09 07:02:45','2022-09-27 16:50:47'),(72,1,'2022-09-07 16:00:00','2022-09-07 19:15:00','Jornada de trabajo',0,'2022-09-09 07:03:22','2022-09-27 16:50:49'),(73,1,'2022-09-12 09:00:05','2022-09-12 14:21:23','Jornada de trabajo',0,'2022-09-12 12:21:07','2022-09-27 16:50:25'),(74,1,'2022-09-12 16:05:47','2022-09-12 19:11:00','Jornada de trabajo',0,'2022-09-12 14:14:02','2022-09-27 16:50:27'),(75,1,'2022-09-13 16:02:23','2022-09-13 19:15:00','Jornada de trabajo',0,'2022-09-13 14:11:58','2022-09-27 16:50:30'),(76,1,'2022-09-14 09:01:59','2022-09-14 14:05:43','Jornada de trabajo',0,'2022-09-14 10:58:28','2022-09-27 16:50:33'),(80,1,'2022-09-14 16:00:00','2022-09-14 19:05:00','Jornada de trabajo',0,'2022-09-14 15:21:31','2022-09-27 16:50:36'),(81,1,'2022-09-15 16:00:40','2022-09-15 19:12:00','Jornada de trabajo',0,'2022-09-15 17:00:51','2022-09-27 16:50:38'),(82,1,'2022-09-16 09:00:09','2022-09-16 14:11:57','Jornada de trabajo',0,'2022-09-16 07:56:20','2022-09-27 16:50:40'),(83,1,'2022-09-16 16:00:17','2022-09-16 20:08:00','Jornada de trabajo',0,'2022-09-16 14:06:35','2022-09-26 15:06:43'),(85,1,'2022-09-19 09:00:00','2022-09-19 14:51:00','Jornada de trabajo',0,'2022-09-19 19:48:04','2022-09-27 16:49:47'),(86,1,'2022-09-19 16:00:00','2022-09-19 20:05:00','Jornada de trabajo',0,'2022-09-19 19:51:50','2022-09-27 16:49:51'),(147,1,'2022-09-21 08:58:23','2022-09-21 14:10:00','Workday',0,'2022-09-21 15:01:37','2022-09-27 16:49:58'),(149,1,'2022-09-21 16:00:00','2022-09-21 20:00:00','Workday',0,'2022-09-26 11:58:12','2022-09-27 16:50:02'),(150,1,'2022-09-23 09:00:00','2022-09-23 14:10:00','Workday',0,'2022-09-26 14:31:19','2022-09-27 16:50:08'),(151,1,'2022-09-20 16:00:00','2022-09-20 20:00:00','Workday',0,'2022-09-26 14:31:52','2022-09-27 16:49:55'),(152,1,'2022-09-26 09:00:00','2022-09-26 14:05:00','Workday',0,'2022-09-26 14:42:38','2022-09-27 16:50:11'),(153,1,'2022-09-26 16:00:00','2022-09-26 20:15:00','Workday',0,'2022-09-26 14:49:43','2022-09-27 16:51:02'),(154,1,'2022-09-27 16:00:00','2022-09-27 20:05:00','Workday',0,'2022-09-27 16:49:41','2022-09-27 17:54:38'),(155,1,'2022-09-28 09:00:00','2022-09-28 14:00:00','Workday',0,'2022-09-28 09:08:49','2022-09-28 17:49:56'),(156,1,'2022-09-28 15:58:45','2022-09-28 20:06:21','Workday',0,'2022-09-28 17:50:06','2022-09-28 18:09:00'),(157,1,'2022-09-29 15:55:00','2022-09-29 20:18:00','Workday',0,'2022-09-30 07:18:35','2022-09-30 07:38:36'),(158,4,'2022-09-30 12:51:22','2022-09-30 13:17:26','Pausa',0,'2022-09-30 10:51:26','2022-09-30 14:25:53'),(160,1,'2022-09-30 08:59:30','2022-09-30 14:05:00','Workday',0,'2022-09-30 11:36:53','2022-09-30 12:00:17'),(162,1,'2022-09-30 16:00:00','2022-09-30 20:06:00','Workday',0,'2022-09-30 14:25:42','2022-10-09 10:28:41'),(163,4,'2022-10-03 13:58:39','2022-10-03 13:59:25','Workday',0,'2022-10-03 13:58:49','2022-10-03 13:59:33'),(165,5,'2022-10-05 08:00:00','2022-10-05 15:00:00','Workday',0,'2022-10-05 14:01:00','2022-10-06 14:28:54'),(167,1,'2022-10-04 16:00:28','2022-10-04 20:07:00','Workday',0,'2022-10-05 14:07:13','2022-10-09 10:27:53'),(168,4,'2022-10-06 09:00:00','2022-10-06 14:00:01','Workday',0,'2022-10-06 07:59:29','2022-10-10 12:09:05'),(169,4,'2022-10-05 09:00:00','2022-10-05 14:25:53','Workday',0,'2022-10-06 08:35:05','2022-10-09 10:27:23'),(170,5,'2022-10-06 08:00:00','2022-10-06 15:00:00','Workday',0,'2022-10-06 14:29:40','2022-10-06 14:30:19'),(172,4,'2022-10-10 09:00:00','2022-10-10 14:00:00','Workday',0,'2022-10-10 12:08:01','2022-10-10 19:24:02'),(173,4,'2022-10-10 16:00:00','2022-10-10 20:02:46','Workday',0,'2022-10-10 19:24:07','2022-10-10 20:08:00'),(175,4,'2022-10-11 15:58:44','2022-10-11 20:22:00','Workday',0,'2022-10-11 19:02:02','2022-10-11 19:57:48'),(176,5,'2022-10-13 08:00:39','2022-10-13 15:00:00','Workday',0,'2022-10-13 09:23:09','2022-10-13 09:24:28'),(177,4,'2022-10-13 15:58:13','2022-10-13 20:04:58','Workday',0,'2022-10-13 18:31:32','2022-10-13 20:05:06');
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
INSERT INTO `sessions` VALUES ('6WfIhX6iVlKyA1kcMyMINcn79lz7isLeFzIIYfaz',NULL,'192.168.10.15','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUmFTdFBkbjNIR1dPT005TkhSaWQ2MlZHWElEMVhtNHJWbEpPMEY5RiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xOTIuMTY4LjEwLjEwNDo4MDAwIjt9fQ==',1665684348);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team_user`
--

LOCK TABLES `team_user` WRITE;
/*!40000 ALTER TABLE `team_user` DISABLE KEYS */;
INSERT INTO `team_user` VALUES (1,1,3,'user','2022-09-30 09:41:12','2022-09-30 09:41:12'),(2,1,4,'user','2022-09-30 09:42:38','2022-09-30 09:42:38'),(3,1,5,'user','2022-10-05 13:59:51','2022-10-05 13:59:51');
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
INSERT INTO `teams` VALUES (1,1,'Ayuntamiento de Zafarraya',1,'2022-06-27 07:02:48','2022-08-13 09:54:30'),(2,2,'Siente\'s Team',1,'2022-08-10 15:27:47','2022-08-10 15:27:47'),(3,3,'Siente\'s Team',1,'2022-08-29 08:35:51','2022-08-29 08:35:51'),(4,4,'Guadalinfo\'s Team',1,'2022-09-16 16:28:35','2022-09-16 16:28:35'),(5,5,'José\'s Team',1,'2022-10-05 13:54:56','2022-10-05 13:54:56');
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,958368934,'Administrador','del Control Horario','','informatica@zafarraya.es','2022-06-27 07:02:48','$2y$10$Sxg6hNPIi6un56Al5udVr.vqYuN.PSwdIdiTMk7R4Gwc9qzgdRXJ6',NULL,NULL,NULL,'MxPy4C1hZnL5CAQjMtECJ9cllYVCxQwZP8ieSmee0LpJ8GnDuh2Rgq8B2up2',1,'profile-photos/PYEFQ45wTl4cNTVIPj4ktaeNTolstvcyFZNW7UL2.png','2022-06-27 07:02:48','2022-10-13 18:48:18'),(3,21345678,'Siente','Soluciones','Informáticas','siente@zafarraya.net',NULL,'$2y$10$uKwEz5ejvJ3hWz.UEEMmXuakEUCWu3TD7zHbj.zT/Db8WUPwyEZQe',NULL,NULL,NULL,NULL,3,NULL,'2022-08-29 08:35:51','2022-08-29 08:35:51'),(4,1232222,'***REMOVED***','***REMOVED***','***REMOVED***','guadalinfo.zafarraya@guadalinfo.es',NULL,'$2y$10$Sxg6hNPIi6un56Al5udVr.vqYuN.PSwdIdiTMk7R4Gwc9qzgdRXJ6',NULL,NULL,NULL,NULL,1,'profile-photos/dXeatdGuqJIsd90b7BxknVfQxTZ2ThQxgKwYyHJ4.jpg','2022-09-16 16:28:35','2022-10-13 19:36:26'),(5,95831505,'José Antonio','Sorlózano','Delgado','secretaria@zafarraya.es',NULL,'$2y$10$SUpx5pbB5I7xMXXP8fO1SuowDI6nY4KRyAZC3W9V/I1T3pgOG2f8q',NULL,NULL,NULL,NULL,1,NULL,'2022-10-05 13:54:56','2022-10-05 14:00:12');
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

-- Dump completed on 2022-10-13 18:07:03
