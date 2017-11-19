/*
SQLyog Community v12.09 (64 bit)
MySQL - 5.7.14 : Database - test_geronimo
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `medias` */

CREATE TABLE `medias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref` varchar(60) DEFAULT NULL,
  `ref_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `size` int(11) NOT NULL DEFAULT '0',
  `type` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `medias` */

insert  into `medias`(`id`,`ref`,`ref_id`,`name`,`description`,`size`,`type`,`url`,`position`,`created`,`updated`,`deleted`) values (1,'PicManager',NULL,'Ma première image','Ceci est ma première image',19598,'image/jpeg','/files/uploads/medias/2017/11/19/f_5a118124545f7.jpg',0,'2017-11-19 13:03:32','2017-11-19 13:11:21',0);

/*Table structure for table `parametres` */

CREATE TABLE `parametres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `param_name` varchar(255) NOT NULL,
  `ref` varchar(255) DEFAULT NULL,
  `ref_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `parametres` */

insert  into `parametres`(`id`,`param_name`,`ref`,`ref_id`) values (1,'profil_picture','Medias',0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
