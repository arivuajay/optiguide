/*
SQLyog Ultimate v8.55 
MySQL - 5.6.14 : Database - optiguide_live
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`optiguide_live` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `optiguide_live`;

/*Table structure for table `rep_subscription_types` */

DROP TABLE IF EXISTS `rep_subscription_types`;

CREATE TABLE `rep_subscription_types` (
  `rep_subscription_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `rep_subscription_name` varchar(100) NOT NULL,
  `rep_subscription_price` double NOT NULL,
  `rep_subscription_description` text,
  `rep_subscription_min` int(11) NOT NULL,
  `rep_subscription_max` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime NOT NULL,
  `rep_subscription_name_fr` varchar(100) NOT NULL,
  `rep_subscription_description_fr` text,
  PRIMARY KEY (`rep_subscription_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `rep_subscription_types` */

insert  into `rep_subscription_types`(`rep_subscription_type_id`,`rep_subscription_name`,`rep_subscription_price`,`rep_subscription_description`,`rep_subscription_min`,`rep_subscription_max`,`created_at`,`modified_at`,`rep_subscription_name_fr`,`rep_subscription_description_fr`) values (1,'Single Account',19.95,'Applicable taxes',1,1,'2015-08-24 00:00:00','2015-08-24 00:00:00','Abonnement individuel','Taxes'),(2,'2 to 5 Accounts',17.95,'Applicable taxes',2,5,'2015-08-24 00:00:00','2015-08-24 00:00:00','De 2 à 5 profils','Taxes'),(3,'6 to 10 accounts',15.95,'Applicable taxes',6,10,'2015-08-24 17:56:36','2015-08-24 00:00:00','De 6 à 10 profils','Taxes'),(4,'11 + Accounts',12.95,'Applicable taxes',11,0,'2015-08-24 17:56:39','2015-08-24 00:00:00','11 profils ou plus','Taxes');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
