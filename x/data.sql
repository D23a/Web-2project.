-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: computer_sales
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (10,7,1,4),(11,7,2,3),(12,8,1,6),(13,8,2,1),(14,9,1,1),(15,10,1,4);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,2,'2025-05-23 10:00:00'),(2,3,'2025-05-23 11:30:00'),(3,4,'2025-05-24 07:30:37'),(4,9,'2025-05-24 08:56:59'),(5,9,'2025-05-24 08:59:42'),(6,9,'2025-05-24 09:40:27'),(7,12,'2025-05-25 10:29:21'),(8,9,'2025-05-25 10:33:48'),(9,9,'2025-05-26 09:04:59'),(10,14,'2025-05-30 06:30:34');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Lenovo ThinkPad','14” business laptop, 8GB RAM, 256GB SSD',2700000.00,3,'prod_68340052589e24.97474410.jpeg'),(2,'HP Pavilion','15” student laptop, 16GB RAM, 512GB SSD',1800000.00,0,'prod_6834005a18a492.72796599.webp'),(8,'Wireless Mouse','Ergonomic USB wireless mouse, 1600 DPI.',45000.00,40,'prod_68340299b38883.02629097.jpg'),(9,'Gaming Keyboard','RGB backlit mechanical gaming keyboard.',155000.00,25,'prod_6834008d5c59d0.43698412.jpeg'),(10,'USB-C Charger','Fast-charging USB-C wall adapter, 30W.',38000.00,50,'prod_683400a06ba2e7.83237360.png'),(11,'Bluetooth Speaker','Portable waterproof Bluetooth speaker.',100000.00,35,'prod_683400b663a769.80061820.jpeg'),(12,'Webcam HD','1080p USB webcam with built-in microphone.',175000.00,20,'prod_683400c170f9c8.42310138.jpeg'),(13,'External Hard Drive 1TB','1TB portable USB 3.0 external hard drive.',240000.00,18,'prod_683400d018c868.30843484.jpeg'),(14,'Laptop Stand','Adjustable aluminum laptop stand.',53000.00,25,'prod_683400dd0aae13.46975955.jpeg'),(16,'Wireless Earbuds','Noise-cancelling wireless earbuds.',80000.00,45,'prod_68340106723487.09632066.jpeg'),(17,'HDMI Cable','2-meter high-speed HDMI cable.',42000.00,60,'prod_68340112f18d46.20455990.jpeg'),(18,'Power Bank 10000mAh','Slim portable power bank for phones.',70000.00,27,'prod_683401216b4ba4.79496362.jpeg'),(21,'Desk Lamp','LED adjustable desk lamp with USB port.',55000.00,28,'prod_68340139b6e380.97052016.jpeg'),(22,'Wireless Router','Dual-band Wi-Fi router, up to 1200Mbps.',180000.00,16,'prod_6834014982ce47.45384380.jpeg'),(23,'Graphic Tablet','Drawing tablet for digital artists.',440000.00,10,'prod_6834015fcf95e3.13326359.jpeg'),(24,'Portable Projector','Mini projector with HDMI/USB input.',270000.00,8,'prod_683401e8549147.41149337.jpeg'),(25,'Noise Cancelling Headphones','Over-ear headphones with ANC.',110000.00,13,'prod_68340188c5e265.18711868.png'),(27,'Fitness Tracker','Sports wristband with step counter.',73000.00,40,'prod_6834017a9add27.67910388.jpeg');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'alice','$2y$10$wH9QkT9tYz/8lQjGQ1TnIuLJ3Q0Q9Q9K1lJ3LJ3Q0Q9K1lJ3Q0Q9K',0,NULL),(3,'bob','$2y$10$wH9QkT9tYz/8lQjGQ1TnIuLJ3Q0Q9Q9K1lJ3LJ3Q0Q9K1lJ3Q0Q9K',0,NULL),(4,'simon','simon',1,'2025-05-24 10:50:05'),(9,'arthur','arthur',0,'2025-05-31 11:55:30'),(11,'dan','dan',0,'2025-05-24 10:45:15'),(12,'user','user',0,'2025-05-25 10:29:10'),(13,'tumukunde','tumukunde',0,'2025-05-26 19:07:00'),(14,'data','data',0,'2025-05-30 06:30:27');
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

-- Dump completed on 2025-06-02 14:50:53
