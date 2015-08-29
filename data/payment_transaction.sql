/*
SQLyog Ultimate v8.55 
MySQL - 5.5.42-37.1 : Database - rajencba_optiguide
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`rajencba_optiguide` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `rajencba_optiguide`;

/*Table structure for table `payment_transaction` */

DROP TABLE IF EXISTS `payment_transaction`;

CREATE TABLE `payment_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `total_price` varchar(256) DEFAULT NULL,
  `tax` float DEFAULT '0',
  `subscription_price` float DEFAULT NULL,
  `payment_status` varchar(256) DEFAULT NULL,
  `payer_email` varchar(256) DEFAULT NULL,
  `verify_sign` varchar(256) DEFAULT NULL,
  `txn_id` varchar(256) DEFAULT NULL,
  `payment_type` varchar(256) DEFAULT NULL,
  `receiver_email` varchar(256) DEFAULT NULL,
  `txn_type` varchar(256) DEFAULT NULL,
  `item_name` varchar(256) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `NOMTABLE` varchar(255) DEFAULT NULL,
  `expirydate` date DEFAULT NULL,
  `invoice_number` varchar(255) DEFAULT NULL,
  `pay_type` int(5) DEFAULT NULL,
  `subscription_type` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

/*Data for the table `payment_transaction` */

insert  into `payment_transaction`(`id`,`user_id`,`total_price`,`tax`,`subscription_price`,`payment_status`,`payer_email`,`verify_sign`,`txn_id`,`payment_type`,`receiver_email`,`txn_type`,`item_name`,`created_at`,`updated_at`,`NOMTABLE`,`expirydate`,`invoice_number`,`pay_type`,`subscription_type`) values (7,569,'100.00',0,100,'Pending','vasabuyer@gmail.com','AZGt1UPXQ4JGBYYNofwQC.rNE7UMAn8x5DTrkDjd5ldqhZ56VBt8wupk','0KS20038SA118332R','instant','vasanth@arkinfotec.com','web_accept','Suppliers Subscription','2015-08-25 03:23:13','0000-00-00 00:00:00','suppliers','2016-08-25','1503956337',NULL,NULL),(8,570,'100.00',0,100,'Pending','vasabuyer@gmail.com','ABlYq.7R2IHqQTc1kx9HVB4oCrebA.5kGXrBZa4kb9b1DLXKj.d7gohW','1M890758XK265410R','instant','vasanth@arkinfotec.com','web_accept','Suppliers Subscription','2015-08-25 04:39:37','0000-00-00 00:00:00','suppliers','2016-08-25','1072561230',1,1),(9,571,'100.00',0,100,'Completed','vasabuyer@gmail.com','AdNKSoZoL6oXGwWfgseOqs1YJ3rqA8Ov8JluXAYGETNIs9HTtcpc6eXq','2JJ90604T0724032K','instant','vasanth@arkinfotec.com','web_accept','Suppliers Subscription','2015-08-25 06:10:29','0000-00-00 00:00:00','suppliers','2016-08-25','2070077127',1,1),(10,572,'125.00',0,125,'Pending','vasabuyer@gmail.com','Ama2VkZWHBN5P8JFn7fza.xkTMiVAzsUnWRl3XFsCrngCcSpYmKHww3P','2EM602409K144814F','instant','vasanth@arkinfotec.com','web_accept','Suppliers Subscription','2015-08-26 00:55:03','0000-00-00 00:00:00','suppliers','2016-08-26','551155807',1,2),(11,573,'101.00',0,101,'Completed','vasabuyer@gmail.com','AwyH5AZJdK3gxXvS8Wep62rWjoNUAikd-3FWM8fX1hz1PUPi69QD2jZY','3L227660MY9308024','instant','vasanth@arkinfotec.com','web_accept','Suppliers Subscription - Profile only','2015-08-26 02:36:43','0000-00-00 00:00:00','suppliers','2016-08-26','1116791510',1,1),(12,574,'101.00',0,101,'Pending','vasabuyer@gmail.com','AiKZhEEPLJjSIccz.2M.tbyW5YFwA8eTe22o0tGWNWj7WpiDU7yKxjbG','7T979692RA948974G','instant','vasanth@arkinfotec.com','web_accept','Suppliers Subscription - Profile only','2015-08-26 03:08:09','0000-00-00 00:00:00','suppliers','2016-08-26','1787093799',1,1),(13,575,'101.00',0,101,'Pending','vasabuyer@gmail.com','ApKghSivOFtm6Gk7Iqy6QZvljWTIAqFT-E2dV0gefd.nj1CzX.NMAK.4','8BS60794PS628972P','instant','vasanth@arkinfotec.com','web_accept','Suppliers Subscription - Profile only','2015-08-26 05:49:06','0000-00-00 00:00:00','suppliers','2016-08-26','1403151837',1,1),(14,576,'101.00',0,101,'Pending','vasabuyer@gmail.com','Afih64Wxr8PyEEerjkdadb.kw0ijAIPKFQc31olYj-ZeTq1mPikvdsE9','1F150614ME1224643','instant','vasanth@arkinfotec.com','web_accept','Suppliers Subscription - Profile only','2015-08-26 05:58:03','0000-00-00 00:00:00','suppliers','2016-08-26','1007539177',1,1),(15,577,'121.00',0,121,'Pending','vasabuyer@gmail.com','ATOwmFugiV5w7zYaJ0M7DizFlZzMAksdbe57KSWM6Fkqw1JSGDvX1vJc','5U983792BY071230F','instant','vasanth@arkinfotec.com','web_accept','Suppliers Subscription - Profile & logo','2015-08-28 23:58:49','0000-00-00 00:00:00','suppliers','2016-08-29','164259725',1,2);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
