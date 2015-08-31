/*
SQLyog Ultimate v8.55 
MySQL - 5.6.14 : Database - optiguide
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`optiguide` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `optiguide`;

/*Table structure for table `mapping_retailers` */

DROP TABLE IF EXISTS `mapping_retailers`;

CREATE TABLE `mapping_retailers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ID_SPECIALISTE` int(11) DEFAULT NULL,
  `ID_RETAILER` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

/*Data for the table `mapping_retailers` */

insert  into `mapping_retailers`(`id`,`ID_SPECIALISTE`,`ID_RETAILER`) values (3,14865,5308),(14,14865,2778),(16,14865,3064),(17,14865,4555);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
