/*
SQLyog Ultimate v8.55 
MySQL - 5.6.14 : Database - optiguide_final
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`optiguide_final` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `optiguide_final`;

/*Table structure for table `client_profiles` */

DROP TABLE IF EXISTS `client_profiles`;

CREATE TABLE `client_profiles` (
  `client_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `job_title` varchar(255) DEFAULT NULL,
  `member_type` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `local_number` varchar(255) DEFAULT NULL,
  `country` varchar(55) DEFAULT NULL,
  `region` varchar(55) DEFAULT NULL,
  `ville` varchar(55) DEFAULT NULL,
  `phonenumber1` varchar(55) DEFAULT NULL,
  `phonenumber2` varchar(55) DEFAULT NULL,
  `mobile_number` varchar(55) DEFAULT NULL,
  `tollfree_number` varchar(55) DEFAULT NULL,
  `fax` varchar(55) DEFAULT NULL,
  `email` varchar(55) DEFAULT NULL,
  `site_address` varchar(55) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `Optipromo` tinyint(5) DEFAULT '0',
  `Optinews` tinyint(5) DEFAULT '0',
  `Envision_print` tinyint(5) DEFAULT '0',
  `Envision_digital` tinyint(5) DEFAULT '0',
  `Envue_print` tinyint(5) DEFAULT '0',
  `Envue_digital` tinyint(5) DEFAULT '0',
  `ID_CLIENT` int(11) DEFAULT '0',
  `sex` varchar(4) DEFAULT NULL,
  `CodePostal` varchar(255) DEFAULT NULL,
  `Poste1` varchar(255) DEFAULT NULL,
  `Poste2` varchar(255) DEFAULT NULL,
  `phonenumber3` varchar(255) DEFAULT NULL,
  `Europe` varchar(255) DEFAULT NULL,
  `feurope` varchar(255) DEFAULT NULL,
  `Website2` varchar(255) DEFAULT NULL,
  `Rep` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `client_profiles` */

insert  into `client_profiles`(`client_id`,`name`,`company`,`job_title`,`member_type`,`address`,`local_number`,`country`,`region`,`ville`,`phonenumber1`,`phonenumber2`,`mobile_number`,`tollfree_number`,`fax`,`email`,`site_address`,`created_date`,`modified_date`,`Optipromo`,`Optinews`,`Envision_print`,`Envision_digital`,`Envue_print`,`Envue_digital`,`ID_CLIENT`,`sex`,`CodePostal`,`Poste1`,`Poste2`,`phonenumber3`,`Europe`,`feurope`,`Website2`,`Rep`) values (1,'testclinet','testclinet Enterprice','testclinet functin','free_member','123 wallet street,','','1','4','113','123123','333444555','928476239365','(928) 111222222','(928) 476239365','testclinet@gmail.com','http://www.monsite1.com','2015-12-21 00:00:00','2015-12-21 00:00:00',0,1,0,1,0,0,0,NULL,'123123','(33)','(44)','666777888','67876-768678-6786786','435345-4353-43535','http://www.monsite2.com','ABT'),(2,'testclinet2','testclinet2 Enterprice','testclinet2 functin','free_member','123 wallet street','123-123-123123','10','75','834','054350234','0234852034','928476239365','(928) 111222222','(928) 476239365','testclinet2@gmail.com','http://www.monsite1.com','2015-12-21 00:00:00','2015-12-21 00:00:00',0,1,0,1,0,0,54772607,'male','EDSAR','(33)','(44)','00456823455','67876-768678-6786786','435345-4353-43535','http://www.monsite2.com','ABT');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
