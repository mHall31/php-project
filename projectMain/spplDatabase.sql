-- MySQL dump 10.13  Distrib 5.5.57, for debian-linux-gnu (x86_64)
--
-- Host: 0.0.0.0    Database: spplDatabase
-- ------------------------------------------------------
-- Server version	5.5.57-0ubuntu0.14.04.1

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
-- Table structure for table `patronProgramAttendance`
--

DROP TABLE IF EXISTS `patronProgramAttendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patronProgramAttendance` (
  `programId` int(11) DEFAULT NULL,
  `patronId` int(11) DEFAULT NULL,
  `attended` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patronProgramAttendance`
--

LOCK TABLES `patronProgramAttendance` WRITE;
/*!40000 ALTER TABLE `patronProgramAttendance` DISABLE KEYS */;
INSERT INTO `patronProgramAttendance` VALUES (2,3,''),(1,5,''),(2,6,''),(1,2,''),(2,7,''),(2,10,''),(3,2,''),(3,3,''),(3,5,''),(2,10,'');
/*!40000 ALTER TABLE `patronProgramAttendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `programTypes`
--

DROP TABLE IF EXISTS `programTypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programTypes` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(30) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programTypes`
--

LOCK TABLES `programTypes` WRITE;
/*!40000 ALTER TABLE `programTypes` DISABLE KEYS */;
/*!40000 ALTER TABLE `programTypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `spplPatrons`
--

DROP TABLE IF EXISTS `spplPatrons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `spplPatrons` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(20) DEFAULT NULL,
  `lastName` varchar(25) DEFAULT NULL,
  `sex` char(1) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `schoolAttending` varchar(5) DEFAULT NULL,
  `grade` int(11) DEFAULT NULL,
  `city` varchar(5) DEFAULT NULL,
  `phoneNumber` varchar(15) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `spplPatrons`
--

LOCK TABLES `spplPatrons` WRITE;
/*!40000 ALTER TABLE `spplPatrons` DISABLE KEYS */;
INSERT INTO `spplPatrons` VALUES (2,'Alex','Webber','F','2018-12-05','WS',8,'SUN','608-111-1111',''),(3,'Alex','O\'brien','F','1993-10-12','WS',2,'SUN','608-111-1111',''),(6,'Person','Dude','M','2007-10-31','RO',3,'SUN','608-111-1112',''),(7,'Captain Jack','Sparrow','M','1980-05-08','CRE',16,'Other','800-555-4444',''),(8,'Marth','Kaga','M','2010-04-17','NS',4,'DEF','608-333-2222',''),(9,'Lucas','McCoy','M','2003-03-13','BIRD',8,'SUN','333-333-4444','EmailWorks@place.com'),(10,'Daisy','Ridley','F','1999-10-12','Other',16,'MAD','333-333-4444','emailStillWorks@place.com');
/*!40000 ALTER TABLE `spplPatrons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `spplPrograms`
--

DROP TABLE IF EXISTS `spplPrograms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `spplPrograms` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `startDate` date DEFAULT NULL,
  `maxCapacity` int(11) DEFAULT NULL,
  `typeID` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `spplPrograms`
--

LOCK TABLES `spplPrograms` WRITE;
/*!40000 ALTER TABLE `spplPrograms` DISABLE KEYS */;
INSERT INTO `spplPrograms` VALUES (1,'Lego Club','2018-12-13',30,0),(2,'Teen late night','0000-00-00',60,0),(3,'Flicks and Bricks','2018-12-20',120,0),(4,'Smash Bros Ultimate Tourney','2018-12-19',32,0);
/*!40000 ALTER TABLE `spplPrograms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `spplUsers`
--

DROP TABLE IF EXISTS `spplUsers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `spplUsers` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `adminPriv` char(1) DEFAULT NULL,
  `firstName` varchar(20) DEFAULT NULL,
  `lastName` varchar(25) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `spplUsers`
--

LOCK TABLES `spplUsers` WRITE;
/*!40000 ALTER TABLE `spplUsers` DISABLE KEYS */;
INSERT INTO `spplUsers` VALUES (1,'mhall','084db17841f4cd18931ab6d919af88a281e90a85','T','Michael','Hall',''),(4,'normalUser','084db17841f4cd18931ab6d919af88a281e90a85','F','pen','pal','');
/*!40000 ALTER TABLE `spplUsers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-12-11 20:08:41
