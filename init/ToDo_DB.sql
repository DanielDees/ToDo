# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.17)
# Database: ToDoApp_Github
# Generation Time: 2018-08-18 05:48:19 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;

INSERT INTO `categories` (`id`, `title`)
VALUES
	(9,'IT Jobs'),
	(10,'Client Requests'),
	(11,'Manager Orders');

/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table group_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `group_users`;

CREATE TABLE `group_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `group_users` WRITE;
/*!40000 ALTER TABLE `group_users` DISABLE KEYS */;

INSERT INTO `group_users` (`id`, `group_id`, `user_id`)
VALUES
	(13,6,41),
	(14,7,41),
	(15,8,41),
	(16,6,43),
	(17,7,43),
	(18,6,42);

/*!40000 ALTER TABLE `group_users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;

INSERT INTO `groups` (`id`, `title`)
VALUES
	(6,'Work Team A'),
	(7,'Work Team B'),
	(8,'Work Team C');

/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table priorities
# ------------------------------------------------------------

DROP TABLE IF EXISTS `priorities`;

CREATE TABLE `priorities` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `priorities` WRITE;
/*!40000 ALTER TABLE `priorities` DISABLE KEYS */;

INSERT INTO `priorities` (`id`, `title`)
VALUES
	(1,'Low'),
	(2,'Medium'),
	(3,'High');

/*!40000 ALTER TABLE `priorities` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table roles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL DEFAULT '',
  `style` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;

INSERT INTO `roles` (`id`, `title`, `style`)
VALUES
	(1,'User','success'),
	(2,'Editor','warning'),
	(3,'Admin','danger');

/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table statuses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `statuses`;

CREATE TABLE `statuses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(30) DEFAULT NULL,
  `style` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `statuses` WRITE;
/*!40000 ALTER TABLE `statuses` DISABLE KEYS */;

INSERT INTO `statuses` (`id`, `title`, `style`)
VALUES
	(4,'Incomplete','danger'),
	(5,'Pending','warning'),
	(6,'Complete','success');

/*!40000 ALTER TABLE `statuses` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table task_comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `task_comments`;

CREATE TABLE `task_comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `content` text,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `task_comments` WRITE;
/*!40000 ALTER TABLE `task_comments` DISABLE KEYS */;

INSERT INTO `task_comments` (`id`, `task_id`, `author_id`, `content`, `date`)
VALUES
	(304,249,41,'All the team A people are weird.','2018-08-18 01:32:56'),
	(305,250,41,'All the team A people are weird.','2018-08-18 01:33:25'),
	(306,248,41,'I wonder if the people in work teams B and C think we are weird?','2018-08-18 01:33:43');

/*!40000 ALTER TABLE `task_comments` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tasks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tasks`;

CREATE TABLE `tasks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `author_id` bigint(20) NOT NULL,
  `title` varchar(60) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `status_id` int(11) NOT NULL DEFAULT '1',
  `priority_id` int(11) NOT NULL DEFAULT '2',
  `category_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `archived` tinyint(1) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deadline` timestamp NULL DEFAULT NULL,
  `archive_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;

INSERT INTO `tasks` (`id`, `author_id`, `title`, `content`, `status_id`, `priority_id`, `category_id`, `group_id`, `archived`, `date`, `deadline`, `archive_date`)
VALUES
	(244,41,'Incomplete Task','Do something fun...',4,2,NULL,NULL,0,'2018-08-18 01:26:30','2018-08-18 04:26:07',NULL),
	(245,41,'Pending Task...','In progress!',5,2,NULL,NULL,0,'2018-08-18 01:26:51','2018-08-18 04:26:32',NULL),
	(246,41,'Complete Task','Done!',6,2,NULL,NULL,0,'2018-08-18 01:27:03','2018-08-18 04:26:53',NULL),
	(247,41,'Archived Task','I have been hidden from regular old users!\r\n\r\nAdmin/Editors only!',6,3,NULL,NULL,1,'2018-08-18 01:27:34','2018-08-18 04:27:09','2018-08-18 05:27:37'),
	(248,41,'Work Team A Task','Only users in Work Team A can view this task.',6,5,NULL,6,0,'2018-08-18 01:31:45','2018-08-18 04:31:03',NULL),
	(249,41,'Work Team B Task','Only users in Work Team B can view this task.',5,2,NULL,7,0,'2018-08-18 01:32:05','2018-08-18 04:31:47',NULL),
	(250,41,'Work Team C Task','Only users in Work Team C can view this task.',4,2,NULL,8,0,'2018-08-18 01:32:28','2018-08-18 04:32:10',NULL),
	(252,41,'Client asked for this...','Testing123',5,2,10,NULL,0,'2018-08-18 01:41:04','2018-08-18 04:40:46',NULL),
	(253,41,'IT Job','This is in the IT Jobs category.',4,2,9,NULL,0,'2018-08-18 01:41:30','2018-08-18 04:41:18',NULL),
	(254,41,'Manager orders...','This is in the manager orders category...',6,1,11,NULL,0,'2018-08-18 01:43:10','2018-08-18 04:42:45',NULL);

/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT '1',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role_id`, `date`)
VALUES
	(41,'admin','$2y$10$z9O03PmtZmMf1dU3xxo7kO3Anwc.lQq17wOtzyK.n0OYiB1Xx6VBy','admin@todo.com',3,'2018-08-18 01:19:50'),
	(42,'user','$2y$10$5Cs4wKdjocc6l7fZQILTyOvjpyUA4afb/79xg1yebaBo3cQb2tjIS','user@todo.com',1,'2018-08-18 01:20:03'),
	(43,'editor','$2y$10$rHbZ7G6zZJaUhscbY8yrEeD5EcMEIbaC.Bnd7DsznllWTMd3TpE22','editor@todo.com',2,'2018-08-18 01:24:53');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
