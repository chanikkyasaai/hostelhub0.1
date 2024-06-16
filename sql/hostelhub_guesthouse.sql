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
-- Table structure for table `guesthouse`
--

DROP TABLE IF EXISTS `guesthouse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `guesthouse` (
  `requestid` int(11) NOT NULL AUTO_INCREMENT,
  `applicant_name` varchar(255) NOT NULL,
  `guest_name` varchar(255) NOT NULL,
  `registration_number` varchar(255) NOT NULL,
  `relation` varchar(255) NOT NULL,
  `applicant_gender` varchar(10) NOT NULL,
  `guest_gender` varchar(10) NOT NULL,
  `applicant_address` text NOT NULL,
  `guest_address` text NOT NULL,
  `mobile_number` varchar(20) NOT NULL,
  `applicant_email` varchar(255) NOT NULL,
  `guest_email` varchar(255) NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `required_from` date NOT NULL,
  `required_to` date NOT NULL,
  `check_in` time NOT NULL,
  `check_out` time NOT NULL,
  `accommodation_type` varchar(20) NOT NULL,
  `boys_count` int(11) NOT NULL,
  `girls_count` int(11) NOT NULL,
  `days_count` int(11) NOT NULL,
  `total_persons` int(11) NOT NULL,
  `food_required` varchar(255) NOT NULL,
  `rooms_required` int(11) NOT NULL,
  `status` enum('pending','completed') NOT NULL,
  PRIMARY KEY (`requestid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guesthouse`
--

LOCK TABLES `guesthouse` WRITE;
/*!40000 ALTER TABLE `guesthouse` DISABLE KEYS */;
INSERT INTO `guesthouse` VALUES (1,'kishore','chanakya','3571','father','male','male','chennai','chenna','9848893265','kishore@gmail.com','karuna@gmail.com','2','2023-03-21','2023-03-23','04:00:00','21:43:00','single',1,0,2,1,'breakfast, lunch, dinner',1,'');
/*!40000 ALTER TABLE `guesthouse` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-06-16 14:11:33
