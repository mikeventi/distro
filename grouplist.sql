#
# Encoding: Unicode (UTF-8)
#


CREATE TABLE `group_list` (
  `list_id` int(10) NOT NULL DEFAULT '0',
  `list_name` varchar(128) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `active` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`list_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `group_list_user` (
  `list_id` int(10) NOT NULL DEFAULT '0',
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`list_id`,`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `group_list_users` (
  `display_name` varchar(128) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `email` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `active` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;




SET FOREIGN_KEY_CHECKS = 0;


LOCK TABLES `group_list` WRITE;
INSERT INTO `group_list` (`list_id`, `list_name`, `active`) VALUES (2, 'Garage', 1);
UNLOCK TABLES;


LOCK TABLES `group_list_user` WRITE;
INSERT INTO `group_list_user` (`list_id`, `email`) VALUES (2, 'mike@wcdriving.com');
UNLOCK TABLES;


LOCK TABLES `group_list_users` WRITE;
INSERT INTO `group_list_users` (`display_name`, `email`, `active`) VALUES ('Mike Ventimiglia', 'mventimiglia@gmail.com', 1);
UNLOCK TABLES;




SET FOREIGN_KEY_CHECKS = 1;


