CREATE DATABASE  IF NOT EXISTS `helpdesk` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `helpdesk`;
-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: localhost    Database: helpdesk
-- ------------------------------------------------------
-- Server version	8.0.36

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
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias` (
  `c_id` int NOT NULL AUTO_INCREMENT,
  `c_name` varchar(8) COLLATE utf8mb3_spanish_ci NOT NULL,
  `c_desc` varchar(250) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `c_stat` int NOT NULL,
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci COMMENT='Tabla de Categorías';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (1,'Hardware','Categoría para englobar cualquier problema reportado relacionado a componentes de Hardware',1),(2,'Software','Categoría para englobar cualquier problema reportado relacionado a sistemas y componentes de Software',1),(3,'Otros','Categoría para englobar cualquier problema no relacionado a Hardware of Software',1);
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empleados`
--

DROP TABLE IF EXISTS `empleados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empleados` (
  `e_id` int NOT NULL AUTO_INCREMENT,
  `e_name` varchar(200) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `e_last` varchar(200) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `e_mail` varchar(200) COLLATE utf8mb3_spanish_ci NOT NULL,
  `e_pass` varchar(64) COLLATE utf8mb3_spanish_ci NOT NULL,
  `e_creat` datetime DEFAULT NULL,
  `e_mod` datetime DEFAULT NULL,
  `e_del` datetime DEFAULT NULL,
  `stat` int NOT NULL,
  PRIMARY KEY (`e_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci COMMENT='Tabla de empleados';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empleados`
--

LOCK TABLES `empleados` WRITE;
/*!40000 ALTER TABLE `empleados` DISABLE KEYS */;
INSERT INTO `empleados` VALUES (1,'Administrador',NULL,'admin@laughingmantech.com','123456','2025-03-26 20:00:00',NULL,NULL,1),(2,'Alejandro','Villaseñor','a.villasenor@laughingmantech.com','123456','2025-03-26 20:00:00',NULL,NULL,1);
/*!40000 ALTER TABLE `empleados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subcategorias`
--

DROP TABLE IF EXISTS `subcategorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subcategorias` (
  `s_id` int NOT NULL AUTO_INCREMENT,
  `cat_id` int NOT NULL,
  `s_name` varchar(50) COLLATE utf8mb3_spanish_ci NOT NULL,
  `s_desc` varchar(250) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `s_stat` int NOT NULL,
  PRIMARY KEY (`s_id`),
  KEY `cat_id` (`cat_id`),
  CONSTRAINT `subcategorias_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categorias` (`c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci COMMENT='Tabla de Subcategorías';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subcategorias`
--

LOCK TABLES `subcategorias` WRITE;
/*!40000 ALTER TABLE `subcategorias` DISABLE KEYS */;
INSERT INTO `subcategorias` VALUES (1,1,'PC - Teclado','Fallas relacionadas al teclado del PC',1),(2,1,'PC - Mouse','Fallas relacionadas al mouse del PC',1),(3,1,'PC - Monitor','Fallas relacionadas al monitor del PC',1),(4,2,'Windows - No Responde','Fallas relacionadas Windows donde algún componente no responde',1),(5,2,'Windows - Mensaje de Error','Fallas relacionadas a mensajes de error en Windows',1),(6,2,'Windows - Problemas de Inicio de Sesión','Fallas relacionadas al inicio de sesión en Windows',1);
/*!40000 ALTER TABLE `subcategorias` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-09  6:45:20
