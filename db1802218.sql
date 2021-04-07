-- MariaDB dump 10.17  Distrib 10.4.14-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: db1802218
-- ------------------------------------------------------
-- Server version	10.4.14-MariaDB

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `login_id` varchar(50) NOT NULL,
  `login_name` varchar(50) DEFAULT NULL,
  `login_pass` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`login_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES ('kanri','ikeda','kanri1111');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart` (
  `user_id` mediumint(8) unsigned NOT NULL COMMENT 'ユーザID',
  `item_id` mediumint(8) unsigned NOT NULL COMMENT '商品ID',
  `item_num` smallint(5) unsigned NOT NULL DEFAULT 0 COMMENT '個数',
  PRIMARY KEY (`user_id`,`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
INSERT INTO `cart` VALUES (2,2,5),(3,1,1),(3,2,1),(4,2,2);
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `category_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'カテゴリID',
  `category_name` varchar(100) NOT NULL COMMENT 'カテゴリ名',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'菓子パン'),(2,'総菜パン'),(3,'主食パン');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `last_name` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `Pcode` varchar(20) DEFAULT NULL,
  `Saddress` varchar(300) DEFAULT NULL,
  `Pnumber` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `login_pass` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (3,'池田','朋乃楓','9218812','青森県弘前市和泉3-10','09000000000','ikeda','1111'),(4,'長山','美優','0000000','富山','09000000000','kanazawa@icloud.com','3333'),(5,'長山','美優','0000000','富山','09000000000','kanazawa@icloud.com','3333'),(6,'長山','美優','0000000','富山','09000000000','kanazawa@icloud.com','3333'),(7,'長山','美優','0000000','富山','09000000000','kanazawa@icloud.com','3333'),(8,'長山','美優','0000000','富山','09000000000','kanazawa@icloud.com','3333'),(9,'池田','朋乃楓','0368053','青森県弘前市和泉3-10','08000001111','root@ymgs-srv.ihc.kanazawa-it.ac.jp','4444');
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item` (
  `item_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品ID',
  `item_name` varchar(100) NOT NULL COMMENT '商品名',
  `item_exp` text NOT NULL COMMENT '商品説明',
  `item_price` mediumint(8) unsigned DEFAULT NULL COMMENT '商品価格',
  `item_stock` mediumint(8) unsigned NOT NULL DEFAULT 0 COMMENT '商品在庫',
  `category_id` tinyint(3) unsigned DEFAULT NULL COMMENT '商品カテゴリ',
  `flag` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item`
--

LOCK TABLES `item` WRITE;
/*!40000 ALTER TABLE `item` DISABLE KEYS */;
INSERT INTO `item` VALUES (1,'メロンパン','石川県産メロンを使用しています。',340,5,1,0),(2,'生食パン（2斤）','石川県産小麦を100%使用しています。もちもち、ふわふわ食感です。',1000,10,3,0),(3,'生食パン（1斤）','石川県産小麦を100%使用しています。もちもち、ふわふわ食感です。',450,10,3,0),(4,'トースト専用食パン（2斤）','石川県産牛乳を使用しています。小麦と牛乳の風味がおいしいパンです。',1000,10,3,0),(5,'トースト専用食パン（1斤）','石川県産牛乳を使用しています。小麦と牛乳の風味がおいしいパンです。',450,10,3,0),(6,'さつまいもパン','五郎島金時を使用しています。',320,10,1,0),(7,'さつまいもデニッシュ','五郎島金時をデニッシュと一緒に焼きました。',350,10,1,0),(8,'クロワッサン','サクサク食感がおいしいパンです。',350,10,1,0),(9,'チョココロネ','お子様に人気No1！昔ながらのチョココロネです。',280,10,1,0),(10,'クリームパン','お子様に人気No2！カスタードクリームにこだわっています。',240,10,1,0),(11,'マダムクロッシュ','石川県産卵を使用しています。',580,5,2,0),(12,'コロッケパン','石川県産のジャガイモを使用したコロッケを挟んでいます。',280,10,2,0),(13,'カレーパン','石川県でとれた野菜でこだわりカレーを作りました。',300,10,2,0),(14,'サンドイッチ（彩）','石川県産の採れたて野菜をはさみました。',400,10,2,0),(15,'サンドイッチ（白）','石川県産の生ハムとチーズを挟みました。',400,10,2,0),(16,'バケット','外はカリカリ中はふわふわのバケットです。',400,10,3,0),(17,'エピ','石川県産ベーコンを使用しています。',300,10,2,0),(18,'コッペパン','ふわふわのコッペパンです。',220,10,3,0),(19,'クイニーアマン','カリカリのクイニーアマンです。',300,10,1,0),(20,'シナモンロール','シナモンの香りに癒される！',360,10,1,0);
/*!40000 ALTER TABLE `item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '注文ID',
  `user_id` mediumint(8) unsigned NOT NULL COMMENT 'ユーザID',
  `item_id` mediumint(8) unsigned NOT NULL COMMENT '商品ID',
  `item_num` smallint(5) unsigned NOT NULL DEFAULT 0 COMMENT '個数',
  `sales_price` mediumint(8) unsigned NOT NULL COMMENT '販売価格',
  `order_date` datetime NOT NULL COMMENT '注文日',
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (5,4,2,1,1000,'2021-01-13 18:15:45'),(6,3,2,1,1000,'2021-01-13 22:01:04'),(7,3,1,1,340,'2021-01-13 22:03:08');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-01-21  9:40:47
