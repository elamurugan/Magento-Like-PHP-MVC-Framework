
SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(512) DEFAULT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `photo` varchar(512) DEFAULT '',
  `user_type` varchar(512) NOT NULL,
  `gender` int(12) DEFAULT NULL,
  `bio` text,
  `address` text,
  `contact_no` varchar(16) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `first_contact` varchar(255) DEFAULT NULL,
  `blood_group` varchar(255) DEFAULT NULL,
  `emp_status` int(1) DEFAULT '1' COMMENT '0 - Not active, 1 - Active',
  `activkey` varchar(128) NOT NULL DEFAULT '',
  `created_time` int(10) NOT NULL DEFAULT '0',
  `last_visit` int(10) NOT NULL DEFAULT '0',
  `superuser` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `email`, `photo`, `user_type`, `gender`, `bio`, `address`, `contact_no`, `designation`, `dob`, `first_contact`, `blood_group`, `emp_status`, `activkey`, `created_time`, `last_visit`, `superuser`, `status`) VALUES
(1, 'Admin', 'admin', 'dc06698f0e2e75751545455899adccc3', 'kurinjiemediaservices@gmail.com', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '', 0, 0, 1, 1);


--
-- Table structure for table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
`id` int(12) NOT NULL,
  `path` varchar(512) NOT NULL,
  `value` varchar(1024) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`id`, `path`, `value`) VALUES
(1, 'site_title', 'Slim MVC Framework'),
(2, 'site_meta_description', 'Slim MVC Framework'),
(3, 'site_meta_keywords', 'Slim MVC Framework'),
(4, 'js_compress', '0'),
(5, 'css_compress', '0');