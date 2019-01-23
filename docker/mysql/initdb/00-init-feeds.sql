
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
-- Table structure for table `feed_list`
--

DROP TABLE IF EXISTS `feed_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feed_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uri` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` int(11) NOT NULL,
  `more_link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feed_list`
--

LOCK TABLES `feed_list` WRITE;
/*!40000 ALTER TABLE `feed_list` DISABLE KEYS */;
INSERT INTO `feed_list` VALUES (1,'London','https://content-api.hiltonapps.com/v1/places/top-places/uk-london-fsq?access_token=jobs383-UgWfVvxQXNhDQLw4v','Foursquare',1,'https://foursquare.com/explore?mode=url&near=London%2C+UK','40.7449','-73.9915'),(2,'London','https://content-api.hiltonapps.com/v1/places/top-places/uk-london-via?access_token=jobs383-UgWfVvxQXNhDQLw4v','Viator',1,'https://www.viator.com/London/d737-ttd?eap=brand-subbrand-23431&aid=vba23431en','40.7449','-73.9915'),(3,'London','https://content-api.hiltonapps.com/v1/places/top-places/london-uk-timeout?access_token=jobs383-UgWfVvxQXNhDQLw4v','TimeOut',1,'http://www.timeout.com/london','40.7449','-73.9915'),(4,'New York, NY','https://content-api.hiltonapps.com/v1/places/top-places/usa-nycny-fsq?access_token=jobs383-Ug\nWfVvxQXNhDQLw4v','Foursquare',1,'https://foursquare.com/explore?mode=url&near=New+York%2C+NY','51.5074','	-0.1278'),(5,'New York, NY','https://content-api.hiltonapps.com/v1/places/top-places/usa-nycny-via?access_token=jobs383-UgWfVvxQXNhDQLw4v','Viator',1,'https://www.viator.com/New-York-City/d687-ttd?eap=brand-subbrand-23431&aid=vba23431en','51.5074','	-0.1278'),(6,'New York, NY','https://content-api.hiltonapps.com/v1/places/top-places/new-york-ny-usa-timeout?access_token=jobs383-UgWfVvxQXNhDQLw4v','TimeOut',1,'http://www.timeout.com/newyork','51.5074','	-0.1278');
/*!40000 ALTER TABLE `feed_list` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-01-22 23:55:42