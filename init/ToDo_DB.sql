# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.17)
# Database: ToDoApp
# Generation Time: 2018-08-11 19:52:02 +0000
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
	(6,'Customers'),
	(7,'Employee Tasks'),
	(8,'IT Jobs');

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
	(21,5,16),
	(23,5,17),
	(47,3,1),
	(55,2,17),
	(56,3,17),
	(57,2,41),
	(61,5,42),
	(65,5,43),
	(68,2,1),
	(69,5,1),
	(70,2,16);

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
	(2,'Employees'),
	(3,'Managers'),
	(5,'Interns');

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
	(1,'Incomplete','danger'),
	(2,'Pending','warning'),
	(3,'Complete','success');

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
	(252,125,1,'I have no idea how, but by some strange magic I got the delete query to work.\n\nFor reference in the future: \n\nSELECT MIN(id), task_id, content FROM (SELECT * FROM task_comments) AS all_comments GROUP BY task_id, content HAVING COUNT(content) > 1;\nSELECT task_id FROM task_comments WHERE task_id IN (SELECT task_id FROM (SELECT * FROM task_comments) AS all_comments GROUP BY task_id HAVING COUNT(content) > 1);\n\nDELETE FROM task_comments\nWHERE id NOT IN (SELECT MIN(id) FROM (SELECT * FROM task_comments) AS all_comments GROUP BY task_id, content HAVING COUNT(content) > 1) \nAND task_id IN (SELECT task_id FROM (SELECT * FROM task_comments) AS all_comments GROUP BY task_id HAVING COUNT(content) > 1)\nAND content IN (SELECT content FROM (SELECT * FROM task_comments) AS all_comments GROUP BY content HAVING COUNT(content) > 1);','2018-07-26 22:54:44'),
	(260,175,1,'Remove dat div test :)','2018-07-26 23:18:18'),
	(261,126,1,'This is the last task!','2018-07-27 19:16:21'),
	(262,126,1,'This is a new comment!','2018-07-27 19:52:23'),
	(263,126,1,'This task can be done!','2018-07-27 19:52:32'),
	(267,214,17,'Editor here!','2018-07-28 16:42:54'),
	(268,214,1,'Admin here!','2018-07-28 16:43:12'),
	(302,218,1,'Just copy-paste the comment stuff in there lol.\n\nEdit: Taking some time....','2018-08-01 15:38:01'),
	(304,258,1,'Author here!','2018-08-11 15:49:42'),
	(306,258,17,'Editor here! I\'m also a manager!','2018-08-11 15:50:24');

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
	(99,1,'QueryBuilder','Add update query',3,2,NULL,NULL,1,'2018-05-06 18:10:09',NULL,NULL),
	(100,1,'Composer','get Autoload working',3,2,NULL,NULL,1,'2018-05-06 18:10:38',NULL,NULL),
	(101,1,'Bootstrap','Style site using bootstrap for design.',3,2,NULL,NULL,1,'2018-05-06 18:11:03',NULL,NULL),
	(102,1,'AJAX','Do something with AJAX',3,2,NULL,NULL,1,'2018-05-06 18:11:16',NULL,NULL),
	(103,1,'Login','Add the login page. Sessions and accounts can be done later.',3,2,NULL,NULL,1,'2018-05-06 18:11:48',NULL,NULL),
	(105,1,'DI Container','Create your first dependency injection container.',3,2,NULL,NULL,1,'2018-05-07 13:25:06',NULL,NULL),
	(106,1,'Remove $key','Remove the $key display before each task. It is quite irrelevant',3,2,NULL,NULL,1,'2018-05-07 13:25:54',NULL,NULL),
	(107,1,'Basic Task style','Style the tasks so there is some seperation between the title, content, and status. Maybe include a color code for Statuses.',3,2,NULL,NULL,1,'2018-05-07 13:26:57',NULL,NULL),
	(108,1,'Status selection','Change the status selection to an editable drop-down so the information is consistent.',3,2,NULL,NULL,1,'2018-05-07 13:27:29',NULL,NULL),
	(109,1,'Textarea Description','		Change the description section to a textarea so there can be multiple paragraphs if necessary.\r\n\r\nTesting123.\r\n\r\nHello my fair maiden!	',3,2,NULL,NULL,1,'2018-05-07 13:27:59',NULL,NULL),
	(110,1,'Submit task page','Move the submit tasks to their own page',3,2,NULL,NULL,1,'2018-05-07 13:28:26',NULL,NULL),
	(111,1,'Archiving Deleted Tasks','Deleted tasks should simply go to an archived section where they can be retrieved if the deletion was accidental.\r\n\r\nArchived posts shouldn\'t register on the main task page.\r\nDeleting an archived post from the archive page should give a confirmation box.\r\n\r\nScrew it, no confirmation box right now I\'m lazy.',3,2,NULL,NULL,1,'2018-05-07 13:30:13',NULL,NULL),
	(122,1,'Prevent page jumps','When deleting or archiving a task the page jumps position. The page should not jump.',3,2,NULL,NULL,1,'2018-05-07 15:23:46',NULL,NULL),
	(125,1,'Comments','Add a way to comment on tasks.\r\n\r\nThis way users can submit their ideas/proposed solutions to tasks if necessary.',3,3,NULL,NULL,1,'2018-05-07 15:29:30','2018-07-27 17:00:00','2018-07-27 02:59:10'),
	(126,1,'Categorize tasks','Add a way to group tasks by category and label them.',3,1,NULL,NULL,1,'2018-05-07 15:39:38','2018-07-27 17:00:00','2018-07-28 22:10:17'),
	(129,1,'Finish PHP Practitioner','Complete all the videos in the PHP Practitioner series on www.laracasts.com',3,2,NULL,NULL,1,'2018-05-07 15:51:09',NULL,NULL),
	(130,1,'Intro to Vue JS','Learn the basics of Vue JS so it isn\'t a foreign concept in the future',3,2,NULL,NULL,1,'2018-05-07 19:01:17',NULL,'2018-07-14 04:00:34'),
	(141,1,'Fix Update query','Right now it does not handle apostrophes well lol.\r\n\r\nTest\'s are\" coming\'\"\" g\"\'.',3,2,NULL,NULL,1,'2018-05-08 02:35:11',NULL,NULL),
	(146,1,'Fix edit page','The status is always incomplete by default. It needs to be set to the proper value that the task has already been assigned.',3,2,NULL,NULL,1,'2018-05-08 13:38:59',NULL,NULL),
	(148,1,'Archive me!','Send me to the archives!',3,2,NULL,NULL,1,'2018-05-08 13:45:44',NULL,NULL),
	(149,1,'Allow for Un-Archiving tasks','This is in progress',3,2,NULL,NULL,1,'2018-05-08 13:52:33',NULL,NULL),
	(150,1,'Dynamic filter','Improve the filter for showing tasks to also remove archived posts.',3,2,NULL,NULL,1,'2018-05-08 13:53:25',NULL,NULL),
	(152,1,'Filter Tasks','Add a filter to tasks to sort by status.',3,2,NULL,NULL,1,'2018-05-08 17:49:51',NULL,NULL),
	(153,1,'Fix title list item not showing up','In the task display, for some reason the title is not used as a list item, but instead is just raw text.',3,2,NULL,NULL,1,'2018-05-08 18:05:13',NULL,NULL),
	(155,1,'Test task for messing around','<pre>Mess with html tags <i><b>maybe</b></i>?</pre>',2,2,NULL,NULL,1,'2018-05-08 21:23:32',NULL,NULL),
	(157,1,'Better forms','You can place HTML tags inside of forms and break them currently. Fix that crap!',3,2,NULL,NULL,1,'2018-05-08 23:10:15',NULL,NULL),
	(159,1,'Build NavBar Class','The class should be able to dynamically create the navbar and accept customization options.',3,2,NULL,NULL,1,'2018-05-09 00:45:43',NULL,'2018-07-14 04:33:12'),
	(160,1,'Specialized button merge','Remove rounded corners that separate the edit and archive buttons for tasks. Button grouping doesn\'t seem to work while also using row sizing for buttons.\r\n\r\n<br>\r\n\r\nAlso try to remove the left rounding on the filter button and the right rounding on the filter form in order to merge them as well.',3,2,NULL,NULL,1,'2018-05-09 02:33:44',NULL,NULL),
	(161,1,'Fix right margin on tasks','Tasks do not fill up the entire container window currently. It looks almost like they keep space for the scrollbar?',3,2,NULL,NULL,1,'2018-05-09 02:44:35',NULL,NULL),
	(163,1,'Create user table','Set up users table in database for creating and logging in to user accounts.',3,2,NULL,NULL,1,'2018-05-09 11:49:41',NULL,NULL),
	(165,1,'Improved Archives','When on archive page, the text for the archive button should be Un-Archive post or Restore. The edit button shouldn\'t show either.',3,2,NULL,NULL,1,'2018-05-09 20:40:35',NULL,NULL),
	(167,1,'Normalize Naming Conventions','Get cross site-consistency with the button names and view names either to edit-task or update-task. one word should be used for editing. There shouldn\'t be button-ids with edit-task and a redirect to update-task.',3,2,NULL,NULL,1,'2018-05-10 00:15:34',NULL,NULL),
	(171,1,'Clean up views','Remove any remaining php logic from the views themselves and put them in the controller at the very least.\r\n\r\nInclude the filter partial?',3,2,NULL,NULL,1,'2018-05-10 01:40:34',NULL,NULL),
	(172,1,'asdf','a;dsl a\r\n\r\na\r\nsdf\r\nf\r\nd<div>\'\'aj dfljakds f;jk\'\'\'\"\r\n\"&\\<div>\r\nasd\r\nal;kjd <testatgasdflkj> </div>',3,2,NULL,NULL,1,'2018-05-10 01:53:03',NULL,NULL),
	(174,1,'Timers','Tasks should have the option to set a time limit until completion. \r\n\r\nHaving a countdown until the task meet\'s it\'s deadline would be a good feature.\r\nAlso filtering options by time until completion would be cool too.',3,2,NULL,NULL,1,'2018-05-17 00:48:00','2018-07-24 05:33:00','2018-07-24 05:33:39'),
	(175,1,'Improve Archives','Have the most recently archived posts show up on top, by archive date, not task creation date.',3,3,NULL,NULL,1,'2018-05-17 00:50:10','2018-07-27 17:00:00','2018-07-29 00:04:55'),
	(176,1,'Navbar Class improvement','Allow for addition of dropdowns to be generated.',3,2,NULL,NULL,1,'2018-05-17 01:12:24','2018-07-27 17:00:00','2018-07-27 04:34:35'),
	(177,1,'Task Button Hiding','Task buttons (edit, archive, delete) shouldn\'t appear unless hovering over a task. This way the page isn\'t swamped with buttons.\r\n\r\nRemoved: Irrelevant to current website layout',1,2,NULL,NULL,1,'2018-05-17 01:43:26',NULL,NULL),
	(178,1,'Design Icons','Use icons for more intuitive looking buttons. \r\n\r\nResources:\r\n\r\nhttps://fontawesome.com/\r\n\r\nTurns out glyphicons are dropped in Bootstrap 4!\r\nhttps://www.w3schools.com/icons/bootstrap_icons_glyphicons.asp',3,2,NULL,NULL,1,'2018-05-17 01:45:23',NULL,NULL),
	(179,1,'Separation of Concerns','The button class needs to be reworked so that only one parameter needs to be passed.\r\n\r\nButtons and button groups need to be able to be generated outside of when forms are around.\r\n\r\nButton groups should all be able to post to a single form as well, instead of auto-generating one form per button.',3,2,NULL,NULL,1,'2018-05-18 00:41:52',NULL,NULL),
	(180,1,'Login Page Buttons','Increase the height so they are more clickable.',3,2,NULL,NULL,1,'2018-05-18 02:32:20',NULL,NULL),
	(181,1,'Prevent User modification of form inputs','Using chrome inspection tools, the values for form inputs can be overridden. The user login page can be modified as to login with the account type of potato if you wanted. \r\n\r\nChange the inputs to hidden values in order to prevent modification\r\n\r\nThe buttons actually need to be submit only with inputs that carry all the form data. The buttons should just be there for looks.\r\n\r\nCompleted note: users can always modify forms. The validation is handled server side now.',3,2,NULL,NULL,1,'2018-05-18 21:04:01',NULL,NULL),
	(182,1,'Task Priority','Tasks should have the option to be set to different priorities. \r\n\r\nPriorities could be a range of 1-10 or low, medium, high, etc.',3,1,NULL,NULL,1,'2018-05-18 22:59:17',NULL,'2018-07-22 20:31:30'),
	(183,1,'Font Awesome Cache Fix','The Font Awesome Icons currently do not load prior to the page render. \r\n\r\nThey don\'t appear to be cached and have to load each time the page is viewed. \r\n\r\nThis causes flashing noticeably on the nav bar.',3,2,NULL,NULL,1,'2018-05-18 23:00:38',NULL,'2018-07-24 02:58:53'),
	(186,1,'Revamp user privileges','Users (once the move to accounts is made instead of the static login page there is now) should have a list of privileges they currently have. \r\n\r\nThe admin should be able to check off which options each user has the ability to use. \r\n\r\nThe User, Editor, and Admin account types will simply change the amount of options available to the user.',3,2,NULL,NULL,1,'2018-05-22 23:17:03',NULL,NULL),
	(188,1,'Button Groups','Test if the button group class div can be used for button groups instead of the customized group currently used. \r\n\r\nIt may no longer be necessary to use the custom build with all the forms now being removed.\r\n\r\nArchive Note: Nope, unless I decide to not be lazy with the d-flex attribute, button group-justified is depreciated in BS4 so rows work for now.',1,2,NULL,NULL,1,'2018-05-25 00:12:05',NULL,NULL),
	(189,1,'Fix the edit button :(','Screw Kevin',3,2,NULL,NULL,1,'2018-05-26 20:53:22',NULL,NULL),
	(190,1,'Improved Filters','Filters should auto-update the page on application.\r\n\r\nFilters should also be saved and remain selected even after leaving the page. Store the value in a session.',3,2,NULL,NULL,1,'2018-05-30 16:45:41',NULL,NULL),
	(191,1,'Filter Class','Move the filter to a dedicated class\r\n\r\nComplete Note: Did not move the filter partial to the class because It doesn\'t seem necessary at the moment.',3,2,NULL,NULL,1,'2018-05-31 15:08:51',NULL,NULL),
	(192,1,'Button Class','Update the button class with edit/archive/delete settings so they don\'t have to be entered manually each time in pagescontroller',3,2,NULL,NULL,1,'2018-05-31 15:09:21',NULL,NULL),
	(196,1,'Finish adding account functionality','The page should submit the user account and add it to the database.\r\n\r\nWhen the user logs in after creating the account, he will be given his account type and permissions.\r\n\r\nCreate an admin account to oversee the site.',3,2,NULL,NULL,1,'2018-06-15 13:58:57',NULL,NULL),
	(197,1,'Account duplicate warning','If a user attempts to create a duplicate account (same username/email combination), the create account page should throw a warning saying that combination is already taken.',3,2,NULL,NULL,1,'2018-07-10 23:45:09',NULL,'2018-07-20 04:28:48'),
	(198,1,'Minimum password length','When creating an account, the passwords should have a minimum number of characters',3,2,NULL,NULL,1,'2018-07-10 23:46:14',NULL,'2018-07-16 01:29:48'),
	(199,1,'Tasks Page cleanup','The tasks page should simply show each task\'s title, then when clicked on bring you to a full page for that particular task.\r\n\r\nThis will make it easier to sort through tasks when scanning through with the eyes, and allow for comments to be added more easily in the future.',3,2,NULL,NULL,1,'2018-07-10 23:49:16',NULL,NULL),
	(201,1,'Author IDs','When creating a task, the author should have his ID attached to it and be allowed to edit his own articles. \r\n\r\nThis should fix allow users to edit their posts instead of only editor and higher level accounts being able to edit articles.',3,2,NULL,NULL,1,'2018-07-12 23:26:49',NULL,NULL),
	(202,17,'Test Author ID with editor account','Editor has created this task.',3,2,NULL,NULL,1,'2018-07-12 23:27:46',NULL,NULL),
	(203,1,'Fix task privileges','There can be overlap/conflicts with how task privileges are delegated. \r\n\r\nRework the privilege system so permissions are granted in a more logical/consistent way.',3,2,NULL,NULL,1,'2018-07-12 23:35:51','2018-07-27 23:11:00','2018-07-27 23:11:12'),
	(204,17,'Author Test (Editor Account)','Testing 123...',3,2,NULL,NULL,1,'2018-07-13 14:43:30',NULL,'2018-07-14 04:35:06'),
	(206,16,'Author Test (User account)','This task is a test to see if the proper task editing abilities are provided to users when creating tasks.',3,2,NULL,NULL,1,'2018-07-13 23:01:54',NULL,'2018-07-14 04:35:19'),
	(208,1,'Account Security','Properly encrypt user passwords when accounts are created.',3,2,NULL,NULL,1,'2018-07-20 00:40:51',NULL,'2018-07-20 20:50:34'),
	(214,17,'Multi-account comment test','Testing to see how mulitiple users commenting on a task will look',3,3,NULL,NULL,1,'2018-07-26 21:10:27','2018-07-27 18:00:00','2018-07-27 01:27:14'),
	(218,1,'Add ability to edit/delete categories','See title...',3,3,6,NULL,1,'2018-07-28 20:14:30','2018-07-28 17:00:00','2018-08-02 21:10:45'),
	(219,1,'Add ability to edit/delete comments','See title...',3,3,NULL,NULL,1,'2018-07-28 20:15:18','2018-07-28 18:02:00','2018-08-01 19:06:56'),
	(220,1,'(Admin) Add ability to delete users','The admin account should be able to delete users.',3,3,NULL,NULL,1,'2018-07-28 20:16:41','2018-07-28 01:00:00','2018-08-01 19:57:06'),
	(221,1,'Improved Task Delete','Comments tied to a task should be deleted when the task is deleted.',3,3,NULL,NULL,1,'2018-07-28 20:17:44','2018-08-01 17:00:00','2018-07-29 00:37:42'),
	(223,1,'Autofill DateTime','When creating a new task, the date-time should autofill to the current date and time.',3,2,7,NULL,1,'2018-08-10 01:59:24','2018-08-10 11:00:00','2018-08-10 05:59:24'),
	(229,1,'Encrypt Temporary password','The password reset function for admin accounts needs to add in the current encryption scheme or the password  is unusable.',3,3,8,NULL,1,'2018-08-01 16:00:16','2018-08-01 19:59:00','2018-08-03 02:38:50'),
	(230,1,'Normalize Database','Break things down more atomically. \r\n\r\nBrush up on database design principles for interviews.\r\n\r\nFix everything that ends up breaking when you change things.',3,3,8,NULL,1,'2018-08-02 14:20:01','2018-08-02 18:18:00','2018-08-02 21:10:24'),
	(231,1,'Category Filter','Add a filter for categories',3,3,8,NULL,1,'2018-08-03 00:25:44','2018-08-03 04:25:00','2018-08-06 03:35:58'),
	(232,1,'Priority Filter','Add a filter for priorities',3,2,6,NULL,1,'2018-08-03 00:26:11','2018-08-03 04:25:00','2018-08-06 03:36:00'),
	(233,1,'Add Groups','see title...',3,3,8,NULL,1,'2018-08-06 17:40:17','2018-08-06 21:39:00','2018-08-06 21:41:45'),
	(234,1,'Allow adding users to group.','When selecting a group, you should be brought to the group\'s page and have a button to join the group.',3,3,7,NULL,1,'2018-08-06 17:41:41','2018-08-06 21:40:00','2018-08-08 20:59:47'),
	(243,1,'Leave Group','users should be able to leave groups',3,3,6,NULL,1,'2018-08-08 17:35:37','2018-08-08 21:35:00','2018-08-08 22:35:11'),
	(244,1,'Account page','Users should be able to see their own account page and reset/change password.',3,3,7,NULL,1,'2018-08-08 18:32:12','2018-08-08 22:31:00','2018-08-09 17:45:17'),
	(245,1,'Remove Group User','Editors and Admins should be able to remove any user from a group.',3,3,8,NULL,1,'2018-08-09 01:38:20','2018-08-09 05:37:00','2018-08-09 21:49:03'),
	(250,1,'Flatpickr / Carbon time enhancements','Get flatpickr and Carbon working properly.\r\n\r\nEdit: What the heck submit fails, but update works :\\\r\nThe key to fixing the submit bug lies in the update function I guess lol.',3,3,6,NULL,1,'2018-08-10 15:01:59','2018-08-10 17:00:00','2018-08-10 19:08:28'),
	(252,1,'Task scope','Tasks should be only viewable by those users in the following:\r\n\r\n1. The group the task was posted in\r\n2. Who are the author of the task',3,3,6,5,1,'2018-08-10 15:09:52','2018-08-11 00:00:00','2018-08-11 19:48:31'),
	(253,1,'Group Filter','Add group filter',3,2,6,2,1,'2018-08-10 20:08:49','2018-08-10 23:08:40','2018-08-11 17:32:08'),
	(258,1,'Multiple people comment on me!','Testing123 for all managers!',3,3,NULL,3,0,'2018-08-11 15:49:36','2018-08-11 18:49:15',NULL);

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
	(1,'Daniel','$2y$10$VEpxeXz78.lZUP1i4vRzcecHEALhmFbCjt.rrPGvyLXv0hv7woora','explorers2010@hotmail.com',3,'2018-06-16 14:33:11'),
	(16,'user','$2y$10$fXJinuutQsbVJ.UC1Qb5mucM0vCgHQMf/AMS0w1rhbONa1T2FA//K','explorers2010@hotmail.com',1,'2018-06-16 19:22:45'),
	(17,'editor','$2y$10$i2NlZ2d4.bZtz3WOFl.lBeZFOoV4TqDioMLoseUFCan21muBYHbzO','explorers2010@hotmail.com',2,'2018-06-16 19:22:57'),
	(30,'JDeez','$2y$10$w//MbxfJfg0XVMi5LcvT.O4OAM8v.AQu8xYw4XCfMzp8/55fSy4RC','judy4books@yahoo.com',1,'2018-07-12 23:10:42'),
	(39,'admin','$2y$10$vLDzBq1CnAaARgksIahrTuxR0zPZ.BFQLHeC.Cx3Ba9I.05SGPjxW','explorers2010@hotmail.com',3,'2018-07-18 22:52:32'),
	(41,'user2','$2y$10$/Hs441ca2yruJdxib/xmne4mIJBxNCQQK1XJkl2Z7IH10qWgBqGbm','explorers2010@hotmail.com',1,'2018-08-09 20:16:51'),
	(42,'user3','$2y$10$EzVK7RceVlOk5dqcOd20IenP7hi3x8BUG9zP1PiUFff.SjOjxcwh6','explorers2010@hotmail.com',1,'2018-08-09 20:17:21'),
	(43,'user4','$2y$10$ZLZaOKxBxn3VNR33dD.5BOPfMo61cL.NmPQeVub/lbTylVF9SFLWa','explorers2010@hotmail.com',1,'2018-08-09 20:17:28');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
