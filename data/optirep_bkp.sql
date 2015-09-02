/*
SQLyog Ultimate v8.55 
MySQL - 5.6.14 : Database - optiguide
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
USE `optiguide`;

/*Table structure for table `rep_admin_subscriptions` */

DROP TABLE IF EXISTS `rep_admin_subscriptions`;

CREATE TABLE `rep_admin_subscriptions` (
  `rep_admin_subscription_id` int(11) NOT NULL AUTO_INCREMENT,
  `rep_credential_id` int(11) NOT NULL,
  `rep_subscription_type_id` int(11) NOT NULL,
  `no_of_accounts_purchased` int(11) NOT NULL,
  `rep_admin_per_account_price` double NOT NULL,
  `rep_admin_total_price` double NOT NULL,
  `rep_admin_tax` double NOT NULL,
  `rep_admin_grand_total` double NOT NULL,
  `rep_admin_subscription_start` datetime NOT NULL,
  `rep_admin_subscription_end` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime NOT NULL,
  PRIMARY KEY (`rep_admin_subscription_id`),
  KEY `FK_rep_admin_subscriptions_credential` (`rep_credential_id`),
  KEY `FK_rep_admin_subscriptions_type` (`rep_subscription_type_id`),
  CONSTRAINT `FK_rep_admin_subscriptions_credential` FOREIGN KEY (`rep_credential_id`) REFERENCES `rep_credentials` (`rep_credential_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_rep_admin_subscriptions_type` FOREIGN KEY (`rep_subscription_type_id`) REFERENCES `rep_subscription_types` (`rep_subscription_type_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `rep_admin_subscriptions` */

insert  into `rep_admin_subscriptions`(`rep_admin_subscription_id`,`rep_credential_id`,`rep_subscription_type_id`,`no_of_accounts_purchased`,`rep_admin_per_account_price`,`rep_admin_total_price`,`rep_admin_tax`,`rep_admin_grand_total`,`rep_admin_subscription_start`,`rep_admin_subscription_end`,`created_at`,`modified_at`) values (1,6,3,6,15.95,95.7,5,100.7,'2015-08-31 00:00:00','2015-10-01 00:00:00','2015-08-31 23:13:05','2015-08-31 23:13:05'),(2,8,3,8,15.95,127.6,5,132.6,'2015-08-31 00:00:00','2015-10-01 00:00:00','2015-08-31 23:18:38','2015-08-31 23:18:38'),(3,9,2,2,17.95,35.9,5,40.9,'2015-09-01 00:00:00','2015-10-01 00:00:00','2015-09-01 15:18:29','2015-09-01 15:18:29');

/*Table structure for table `rep_credential_profiles` */

DROP TABLE IF EXISTS `rep_credential_profiles`;

CREATE TABLE `rep_credential_profiles` (
  `rep_profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `rep_credential_id` int(11) NOT NULL,
  `rep_profile_firstname` varchar(255) NOT NULL,
  `rep_profile_lastname` varchar(100) DEFAULT NULL,
  `rep_profile_email` varchar(255) NOT NULL,
  `rep_profile_phone` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime NOT NULL,
  PRIMARY KEY (`rep_profile_id`),
  KEY `FK_rep_credential_profiles` (`rep_credential_id`),
  CONSTRAINT `FK_rep_credential_profiles` FOREIGN KEY (`rep_credential_id`) REFERENCES `rep_credentials` (`rep_credential_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `rep_credential_profiles` */

insert  into `rep_credential_profiles`(`rep_profile_id`,`rep_credential_id`,`rep_profile_firstname`,`rep_profile_lastname`,`rep_profile_email`,`rep_profile_phone`,`created_at`,`modified_at`) values (1,6,'Nadesh','S','test@gmail.com','12345','2015-08-31 23:13:05','2015-08-31 23:13:05'),(2,7,'Nadesh','S','single1@gmail.com','123456','2015-08-31 23:16:21','2015-08-31 23:16:21'),(3,8,'Nadesh','S','admin2@gmail.com','1234','2015-08-31 23:18:38','2015-08-31 23:18:38'),(4,9,'test','test','test@gmail.com','','2015-09-01 15:18:29','2015-09-01 15:18:29');

/*Table structure for table `rep_credentials` */

DROP TABLE IF EXISTS `rep_credentials`;

CREATE TABLE `rep_credentials` (
  `rep_credential_id` int(11) NOT NULL AUTO_INCREMENT,
  `rep_username` varchar(255) NOT NULL,
  `rep_password` varchar(255) NOT NULL,
  `rep_role` enum('single','admin') NOT NULL DEFAULT 'single',
  `rep_parent_id` int(11) NOT NULL DEFAULT '0',
  `rep_status` enum('0','1') NOT NULL DEFAULT '1',
  `rep_expiry_date` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime NOT NULL,
  PRIMARY KEY (`rep_credential_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `rep_credentials` */

insert  into `rep_credentials`(`rep_credential_id`,`rep_username`,`rep_password`,`rep_role`,`rep_parent_id`,`rep_status`,`rep_expiry_date`,`created_at`,`modified_at`) values (6,'admin1','c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec','admin',0,'1','0000-00-00 00:00:00','2015-08-31 23:13:05','2015-08-31 23:13:05'),(7,'single1','c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec','single',0,'1','2015-10-01 00:00:00','2015-08-31 23:16:21','2015-09-01 15:51:08'),(8,'admin2','c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec','admin',0,'1','0000-00-00 00:00:00','2015-08-31 23:18:38','2015-08-31 23:18:38'),(9,'test','66c41adb7b62b2e984b3a0b3a616d25044d97dec82b2b21d0b9b78f318dade7bbc07c82e772f0e36ec23fba5b4b5af8b8d22aaea8cb3c40c8af39eece6ec67ac','admin',0,'1','0000-00-00 00:00:00','2015-09-01 15:18:28','2015-09-01 15:18:28');

/*Table structure for table `rep_single_subscriptions` */

DROP TABLE IF EXISTS `rep_single_subscriptions`;

CREATE TABLE `rep_single_subscriptions` (
  `rep_single_subscription_id` int(11) NOT NULL AUTO_INCREMENT,
  `rep_credential_id` int(11) NOT NULL,
  `rep_admin_subscription_id` int(11) NOT NULL,
  `rep_subscription_type_id` int(11) NOT NULL,
  `rep_single_price` double NOT NULL,
  `rep_single_tax` double NOT NULL,
  `rep_single_total` double NOT NULL,
  `rep_single_subscription_start` datetime NOT NULL,
  `rep_single_subscription_end` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime NOT NULL,
  PRIMARY KEY (`rep_single_subscription_id`),
  KEY `FK_rep_single_subscription_type` (`rep_subscription_type_id`),
  KEY `FK_rep_single_subscriptions_credential` (`rep_credential_id`),
  CONSTRAINT `FK_rep_single_subscriptions_credential` FOREIGN KEY (`rep_credential_id`) REFERENCES `rep_credentials` (`rep_credential_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_rep_single_subscription_type` FOREIGN KEY (`rep_subscription_type_id`) REFERENCES `rep_subscription_types` (`rep_subscription_type_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `rep_single_subscriptions` */

insert  into `rep_single_subscriptions`(`rep_single_subscription_id`,`rep_credential_id`,`rep_admin_subscription_id`,`rep_subscription_type_id`,`rep_single_price`,`rep_single_tax`,`rep_single_total`,`rep_single_subscription_start`,`rep_single_subscription_end`,`created_at`,`modified_at`) values (1,7,0,1,19.95,5,24.95,'2015-08-31 00:00:00','2015-10-01 00:00:00','2015-08-31 23:16:21','2015-08-31 23:16:21');

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
  PRIMARY KEY (`rep_subscription_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `rep_subscription_types` */

insert  into `rep_subscription_types`(`rep_subscription_type_id`,`rep_subscription_name`,`rep_subscription_price`,`rep_subscription_description`,`rep_subscription_min`,`rep_subscription_max`,`created_at`,`modified_at`) values (1,'Single Account',19.95,'applicable taxes in accordance with the province',1,1,'2015-08-24 00:00:00','2015-08-24 00:00:00'),(2,'2 to 5 Accounts',17.95,'applicable taxes in accordance with the province',2,5,'2015-08-24 00:00:00','2015-08-24 00:00:00'),(3,'6 to 10 accounts',15.95,'applicable taxes in accordance with the province',6,10,'2015-08-24 17:56:36','2015-08-24 00:00:00'),(4,'11 + Accounts',12.95,'applicable taxes in accordance with the province',11,0,'2015-08-24 17:56:39','2015-08-24 00:00:00');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
