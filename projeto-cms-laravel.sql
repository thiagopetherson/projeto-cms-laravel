/*
SQLyog Community v13.1.2 (64 bit)
MySQL - 5.7.24 : Database - b7_laravel_cms
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`b7_laravel_cms` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `b7_laravel_cms`;

/*Table structure for table `pages` */

DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `body` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `pages` */

insert  into `pages`(`id`,`title`,`slug`,`body`) values 
(4,'Sobre mim','sobre-mim','conteúdo sobre a minha pessoa');

/*Table structure for table `settings` */

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `settings` */

insert  into `settings`(`id`,`name`,`content`) values 
(1,'title','Pizza Interessante'),
(2,'subtitle','Site muito legal'),
(3,'email','contato@site.com'),
(4,'bg-color','#ae3737'),
(5,'text-color','#1f6416');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`password`,`remember_token`,`admin`) values 
(1,'Thiago Petherson','thiago@gmail.com','$2y$10$WZSkoal7iR.kjr0P8PYuQOHx0mH93xM9HNWqYtQMc/YYKKVVgpBLO','3i3ILf0idJ4v27ml4AtdqA8yFSW0MXNmkFO9BItJssz4AcZXVx3M9LPHB8HU',1),
(3,'Andrews Ribeiro','andrews@gmail.com','$2y$10$Ui5Pq/jQcb62cUlPrL8vAOCe9rSIDsZv.xdQGBiNCv3fpA2MVCcy.',NULL,0),
(4,'Daniel Vilela','daniel@gmail.com','$2y$10$h29h/0.E1.yuL/mnWMzFAO802V3xOBgk0/Ou/d2fDSGcUQTNIKpIu',NULL,0),
(5,'Lucas Santos','lucas@gmail.com','$2y$10$OBScOYHwi8u7kQdE2FbhqejCorcVrG7EtpCB3leGciSPwTYfDJ.Ka',NULL,0),
(6,'Giselle Oliveira','giselle@gmail.com','$2y$10$wBJmhDkDrBC6ueslx5djNu5uITag27s9.6wBIf00iQi6O3jF11ggW',NULL,0);

/*Table structure for table `visitors` */

DROP TABLE IF EXISTS `visitors`;

CREATE TABLE `visitors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(100) DEFAULT NULL,
  `date_access` datetime DEFAULT NULL,
  `page` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `visitors` */

insert  into `visitors`(`id`,`ip`,`date_access`,`page`) values 
(1,'1','2020-08-13 18:06:32','/'),
(3,'1','2020-08-14 19:47:10','/'),
(4,'1','2020-08-13 19:47:26','teste'),
(5,'1','2020-07-01 18:57:24','teste'),
(6,'1','2020-07-01 18:57:46','teste'),
(7,'1','2020-08-14 18:58:09','/'),
(8,'1','2020-07-01 19:41:40','/');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
