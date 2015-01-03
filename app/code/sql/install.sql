
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(512) DEFAULT NULL,
  `username` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL, 
  `user_type` varchar(512)  DEFAULT 'USER' NOT NULL 'ADMIN - Root Admin, USER - Default frontend user',
  `gender` int(12) DEFAULT NULL,
  `user_bio` text,
  `address` text,
  `contact_no` varchar(16) DEFAULT NULL,
  `photo` varchar(512) DEFAULT '',
  `dob` date DEFAULT NULL,
  `is_active` int(1) DEFAULT '1' COMMENT '0 - Not active, 1 - Active',
  `created_time` int(10) NOT NULL DEFAULT '0',
  `last_visit` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


CREATE TABLE IF NOT EXISTS `config` (
`id` int(12) NOT NULL,
  `path` varchar(512) NOT NULL,
  `value` varchar(1024) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

