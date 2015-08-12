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

/*Table structure for table `client_profiles` */

DROP TABLE IF EXISTS `client_profiles`;

CREATE TABLE `client_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client` varchar(255) DEFAULT NULL,
  `message` text,
  `meeting_date` date DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(5) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `client_profiles` */

insert  into `client_profiles`(`id`,`client`,`message`,`meeting_date`,`created`,`status`) values (1,'Arkclient1','this is test ark message.please remember ths meeting.','2015-08-24',NULL,0),(2,'Arkclient2','ths s test remember','2015-08-12',NULL,1),(3,'Arkclient3','Please ask the banner for home page.','2015-08-12',NULL,1),(4,'Arkclient4','please create client acces for the fourtuneriers.','2015-08-12',NULL,1),(5,'asda','dasdasd','2015-08-12',NULL,0),(6,'Arkclient5','hkjk hj hj hjk','2015-08-12','2015-08-12 18:30:06',0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
