-- MariaDB dump 10.17  Distrib 10.4.11-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: hostelhub
-- ------------------------------------------------------
-- Server version	10.4.28-MariaDB

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
-- Table structure for table `laundry`
--

DROP TABLE IF EXISTS `laundry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `laundry` (
  `ticketid` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT current_timestamp(),
  `etc` datetime DEFAULT NULL,
  `delivery` datetime DEFAULT NULL,
  `cost` decimal(8,2) DEFAULT NULL,
  `status` enum('received','washing','pending','delivered') DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  PRIMARY KEY (`ticketid`),
  KEY `id` (`id`),
  CONSTRAINT `laundry_ibfk_1` FOREIGN KEY (`id`) REFERENCES `student_details` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `laundry`
--

LOCK TABLES `laundry` WRITE;
/*!40000 ALTER TABLE `laundry` DISABLE KEYS */;
INSERT INTO `laundry` VALUES (2,3583,'2023-07-15 13:44:12','2023-07-16 13:44:12','2023-07-17 20:13:27',15.75,'delivered',NULL),(4,3583,'2023-07-15 13:43:22','2023-07-16 13:43:22','2023-07-15 13:43:22',12.25,'delivered',4),(5,3583,'2023-07-15 18:29:49','2023-07-16 18:29:49','2023-07-29 13:24:59',50.00,'delivered',NULL),(6,3571,'2023-07-17 19:33:07','2023-07-18 19:33:07','2023-07-17 20:13:38',200.00,'delivered',NULL),(8,3571,'2023-07-17 20:13:06','2023-07-18 20:13:06',NULL,125.00,'washing',NULL),(9,3577,'2023-07-17 20:36:11','2023-07-18 20:36:11',NULL,20.00,'pending',NULL),(12,3571,'2023-07-19 19:11:52','2023-07-20 19:11:52','2023-07-19 19:13:37',135.00,'delivered',NULL),(13,3583,'2023-07-20 19:23:45','2023-07-21 19:23:45',NULL,135.00,'washing',NULL),(15,3571,'2023-07-21 10:39:49','2023-07-22 10:39:49','2023-07-21 10:40:44',160.00,'delivered',NULL),(17,3583,'2023-07-29 13:25:23','2023-07-30 13:25:23',NULL,400.00,'received',NULL),(19,3583,'2024-05-04 18:05:12','2024-05-05 18:05:12',NULL,300.00,'received',NULL);
/*!40000 ALTER TABLE `laundry` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER set_etc_after_insert
BEFORE INSERT ON laundry
FOR EACH ROW
BEGIN
  SET NEW.etc = DATE_ADD(NEW.date, INTERVAL 1 DAY);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER update_delivery_after_update
BEFORE UPDATE ON laundry
FOR EACH ROW
BEGIN
  IF NEW.status = 'delivered' AND OLD.status != 'delivered' THEN
    SET NEW.delivery = NOW();
  END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-06-16 14:11:35
