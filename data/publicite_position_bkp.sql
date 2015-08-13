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

/*Table structure for table `publicite_position` */

DROP TABLE IF EXISTS `publicite_position`;

CREATE TABLE `publicite_position` (
  `iId_position` int(11) NOT NULL,
  `sPosition` varchar(50) NOT NULL,
  `sFormat` varchar(20) NOT NULL,
  `bActive` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `publicite_position` */

insert  into `publicite_position`(`iId_position`,`sPosition`,`sFormat`,`bActive`) values (1,'Haut de la page','728x90',1),(2,'Bas de la page','728x90',1),(3,'Haut de la colonne de gauche','180x60',1),(4,'Bas de la colonne de gauche','180x150',1),(5,'Haut de la colonne de droite','160x600',1),(6,'Bas de la colonne de droite','160x90',1),(0,'ANCIEN SITE (haut de la page)','468x60',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
