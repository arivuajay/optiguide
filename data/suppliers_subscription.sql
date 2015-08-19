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

/*Table structure for table `suppliers_subscription` */

DROP TABLE IF EXISTS `suppliers_subscription`;

CREATE TABLE `suppliers_subscription` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ID_FOURNISSEUR` int(11) DEFAULT NULL,
  `payment_type` int(5) DEFAULT NULL,
  `subscription_type` int(5) DEFAULT NULL,
  `invoice_number` varchar(255) DEFAULT NULL,
  `txnid` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `expirydate` date DEFAULT NULL,
  `status` int(5) DEFAULT '1',
  `createddate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
