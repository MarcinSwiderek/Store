-- MySQL dump 10.13  Distrib 5.5.41, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: Store
-- ------------------------------------------------------
-- Server version	5.5.41-0ubuntu0.14.04.1

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
-- Table structure for table `Categories`
--

DROP TABLE IF EXISTS `Categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Categories`
--

LOCK TABLES `Categories` WRITE;
/*!40000 ALTER TABLE `Categories` DISABLE KEYS */;
INSERT INTO `Categories` VALUES (1,'test'),(7,'testowakaaaat'),(8,'tessst'),(9,'other');
/*!40000 ALTER TABLE `Categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Items`
--

DROP TABLE IF EXISTS `Items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) DEFAULT NULL,
  `item_price` float(9,2) DEFAULT NULL,
  `item_description` text,
  `item_category_id` int(11) NOT NULL,
  PRIMARY KEY (`item_id`),
  KEY `item_category_id` (`item_category_id`),
  CONSTRAINT `Items_ibfk_1` FOREIGN KEY (`item_category_id`) REFERENCES `Categories` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Items`
--

LOCK TABLES `Items` WRITE;
/*!40000 ALTER TABLE `Items` DISABLE KEYS */;
INSERT INTO `Items` VALUES (1,'ogorek',2.99,'ot takie warzywo',1),(2,'cebula',0.99,'polskie warzywo',1),(7,'gruszka',1.99,'owoc ',1),(8,'gruszka1',1.99,'owoc ',1),(9,'pomidor',2.39,'warz',1),(10,'pomidor',2.39,'warz',1),(11,'wisnia',1.50,'wisniaaa',9);
/*!40000 ALTER TABLE `Items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Orders`
--

DROP TABLE IF EXISTS `Orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_status` tinyint(1) DEFAULT NULL,
  `order_user_id` int(11) NOT NULL,
  `order_date` date DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `order_user_id` (`order_user_id`),
  CONSTRAINT `Orders_ibfk_1` FOREIGN KEY (`order_user_id`) REFERENCES `Users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Orders`
--

LOCK TABLES `Orders` WRITE;
/*!40000 ALTER TABLE `Orders` DISABLE KEYS */;
INSERT INTO `Orders` VALUES (1,0,1,'0000-00-00');
/*!40000 ALTER TABLE `Orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Orders_items`
--

DROP TABLE IF EXISTS `Orders_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Orders_items` (
  `order_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_item_order_id` int(11) NOT NULL,
  `order_item_item_id` int(11) NOT NULL,
  `order_item_quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`order_item_id`),
  KEY `order_item_order_id` (`order_item_order_id`),
  KEY `order_item_item_id` (`order_item_item_id`),
  CONSTRAINT `Orders_items_ibfk_1` FOREIGN KEY (`order_item_order_id`) REFERENCES `Orders` (`order_id`) ON DELETE CASCADE,
  CONSTRAINT `Orders_items_ibfk_2` FOREIGN KEY (`order_item_item_id`) REFERENCES `Items` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Orders_items`
--

LOCK TABLES `Orders_items` WRITE;
/*!40000 ALTER TABLE `Orders_items` DISABLE KEYS */;
INSERT INTO `Orders_items` VALUES (1,1,1,1);
/*!40000 ALTER TABLE `Orders_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Pictures`
--

DROP TABLE IF EXISTS `Pictures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Pictures` (
  `picture_id` int(11) NOT NULL AUTO_INCREMENT,
  `picture_path` varchar(255) DEFAULT NULL,
  `picture_item_id` int(11) NOT NULL,
  PRIMARY KEY (`picture_id`),
  KEY `picture_item_id` (`picture_item_id`),
  CONSTRAINT `Pictures_ibfk_1` FOREIGN KEY (`picture_item_id`) REFERENCES `Items` (`item_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Pictures`
--

LOCK TABLES `Pictures` WRITE;
/*!40000 ALTER TABLE `Pictures` DISABLE KEYS */;
/*!40000 ALTER TABLE `Pictures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_password` varchar(60) DEFAULT NULL,
  `user_name` varchar(60) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `user_adres` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES (1,'haslo','Marian Test','a@b.com','Testowa 12');
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-04-17 16:53:35
