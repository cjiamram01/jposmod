/*
SQLyog Ultimate v8.82 
MySQL - 5.5.34 : Database - db_jpos
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_jpos` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `db_jpos`;

/*Table structure for table `tbl_shiping` */

DROP TABLE IF EXISTS `tbl_shiping`;

CREATE TABLE `tbl_shiping` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `customer` varchar(400) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shiping_date` datetime DEFAULT NULL,
  `detail` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  `car_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `picture` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bill_no` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tbl_shiping` */

LOCK TABLES `tbl_shiping` WRITE;

insert  into `tbl_shiping`(`id`,`customer`,`shiping_date`,`detail`,`user_id`,`status`,`car_code`,`picture`,`bill_no`) values (16,'ร้านตุ่ม-ตุ้ย ผลไม้ (แม่ถวิล)','2014-08-29 00:00:00','1234','2',NULL,'1234/123','','1234'),(17,'ร้านบังลอย','2014-08-29 00:00:00','','2',NULL,'1234/234','','12345'),(18,'ร้านน้าน้อย เบอร์5','2014-08-29 00:00:00','','2',0,'12345/1234','','12345');

UNLOCK TABLES;

/*Table structure for table `tbl_shipingdetail` */

DROP TABLE IF EXISTS `tbl_shipingdetail`;

CREATE TABLE `tbl_shipingdetail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `item_id` bigint(20) DEFAULT NULL,
  `qty` decimal(18,2) DEFAULT NULL,
  `price` decimal(18,2) DEFAULT NULL,
  `shiping_id` bigint(20) DEFAULT NULL,
  `picture` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order_qty` decimal(18,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tbl_shipingdetail` */

LOCK TABLES `tbl_shipingdetail` WRITE;

insert  into `tbl_shipingdetail`(`id`,`item_id`,`qty`,`price`,`shiping_id`,`picture`,`order_qty`) values (2,654,'1.00','600.00',16,NULL,NULL),(3,0,'1.00','600.00',18,NULL,NULL),(4,648,'5.00','239.00',18,NULL,NULL);

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
