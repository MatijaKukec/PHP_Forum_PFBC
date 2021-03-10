/*
SQLyog Community v13.1.6 (64 bit)
MySQL - 10.4.14-MariaDB : Database - logiranje
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`logiranje` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `logiranje`;

/*Table structure for table `forum` */

DROP TABLE IF EXISTS `forum`;

CREATE TABLE `forum` (
  `forum_id` int(11) NOT NULL AUTO_INCREMENT,
  `forum_naziv` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `forum_opis` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`forum_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `forum` */

insert  into `forum`(`forum_id`,`forum_naziv`,`forum_opis`) values 
(1,'Prvi forum','Ovo je moj prvi forum');

/*Table structure for table `forum_post` */

DROP TABLE IF EXISTS `forum_post`;

CREATE TABLE `forum_post` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_naslov` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `post_autor` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `post_body` text COLLATE utf8_unicode_ci NOT NULL,
  `post_tip` enum('o','r') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'o',
  `op_id` int(11) NOT NULL,
  `forum_naziv` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `forum_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `forum_post` */

insert  into `forum_post`(`post_id`,`post_naslov`,`post_autor`,`post_body`,`post_tip`,`op_id`,`forum_naziv`,`forum_id`) values 
(2,'Prvi post','Saša','Ovo je moj prvi post','o',1,'Prvi forum',1);

/*Table structure for table `korisnici` */

DROP TABLE IF EXISTS `korisnici`;

CREATE TABLE `korisnici` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `korisnik` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lozinka` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `korisnici` */

insert  into `korisnici`(`id`,`korisnik`,`lozinka`,`avatar`) values 
(1,'Sa&scaron;a','$2y$10$jusMhLi7spJCrxzz7lHBPesLyqDfLkgocTZ/2CeTYRWZvN7LbhpI6','download.jpg'),
(2,'admin','$2y$10$gpOxirpcgB3objgbG84Zk.Eu6sFglSohloxumCyXTUjA4hMj8zGHy','124449019_3785568441475883_6085900675387424954_n.jpg');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
