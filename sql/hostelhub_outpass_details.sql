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
-- Table structure for table `outpass_details`
--

DROP TABLE IF EXISTS `outpass_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `outpass_details` (
  `or_id` int(11) NOT NULL AUTO_INCREMENT,
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `block_name` varchar(255) NOT NULL,
  `room_no` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `place_of_visit` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `no_of_days_proposed` int(11) NOT NULL,
  `time_out` time NOT NULL,
  `return_date_time` datetime NOT NULL,
  `contact_phone` varchar(255) NOT NULL,
  `parent_phone` varchar(255) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL,
  PRIMARY KEY (`or_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `outpass_details`
--

LOCK TABLES `outpass_details` WRITE;
/*!40000 ALTER TABLE `outpass_details` DISABLE KEYS */;
INSERT INTO `outpass_details` VALUES (1,'3583','Nelapatla Chanikya Sai','3583','Bhavani','5208','2023-07-12','Khammam, Telangana','Khammam ',8,'18:40:00','2023-07-29 05:43:00','9848893265','9390377945','rejected'),(2,'3571','kishore','3571','Thamirabharani','6304','2023-07-19','coimbattore','house',3,'18:14:00','2023-07-22 18:13:00','9465356243','8793541342','approved'),(3,'3583','Nelapatla Chanikya Sai','3583','Bhavani','5208','2023-07-20','coimbattore','khammam',4,'20:34:00','2023-07-28 17:31:00','9848893265','9390377945','approved'),(4,'3583','Nelapatla Chanikya Sai','3583','Bhavani','5208','2023-08-03','tirunalveli','sami koyila',1,'15:32:00','2023-08-04 19:28:00','9465356243','8793541342','approved'),(5,'3583','Nelapatla Chanikya Sai','3583','Bhavani','5208','2023-07-21','Bangalore','Whitefield',3,'21:42:00','2023-07-23 21:42:00','9452319823','9653125642','approved');
/*!40000 ALTER TABLE `outpass_details` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-06-16 14:11:34
