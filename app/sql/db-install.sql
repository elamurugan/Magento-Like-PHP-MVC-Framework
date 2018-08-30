-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               10.1.34-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table mvc.cms_pages
CREATE TABLE IF NOT EXISTS `cms_pages` (
  `page_id` smallint(6) NOT NULL COMMENT 'Page ID',
  `title` varchar(255) DEFAULT NULL COMMENT 'Page Title',
  `root_template` varchar(255) DEFAULT NULL COMMENT 'Page Template',
  `meta_keywords` text COMMENT 'Page Meta Keywords',
  `meta_description` text COMMENT 'Page Meta Description',
  `identifier` varchar(100) DEFAULT NULL COMMENT 'Page String Identifier',
  `content_heading` varchar(255) DEFAULT NULL COMMENT 'Page Content Heading',
  `content` mediumtext COMMENT 'Page Content',
  `creation_time` timestamp NULL DEFAULT NULL COMMENT 'Page Creation Time',
  `update_time` timestamp NULL DEFAULT NULL COMMENT 'Page Modification Time',
  `is_active` smallint(6) NOT NULL DEFAULT '1' COMMENT 'Is Page Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='CMS Page Table';

-- Dumping data for table mvc.cms_pages: ~4 rows (approximately)
DELETE FROM `cms_pages`;
/*!40000 ALTER TABLE `cms_pages` DISABLE KEYS */;
INSERT INTO `cms_pages` (`page_id`, `title`, `root_template`, `meta_keywords`, `meta_description`, `identifier`, `content_heading`, `content`, `creation_time`, `update_time`, `is_active`) VALUES
	(2, 'About Us Updated', '2column-left.phtml', 'About Us', 'About Us', 'about-us', 'About Us', '<pre>About Us cms content from Db that can be managed from admin.</pre><br>{{block type="block/template"  template="page/cms_dyanamic.phtml" name="cms_dyanamic"}}<br><br>Welcome to <b> {{var site_title}}<br><br><pre>Another dynamic block</pre><br>{{block type="block/template"  template="page/cms_dyanamic.phtml" name="cms_dyanamic"}}<br><br>Another dynamic variable <b>{{var page_title}}</b></b>', '0000-00-00 00:00:00', '2015-01-11 07:12:41', 1),
	(3, 'Services', '2column-left.phtml', 'Services', 'Services', 'services', 'Services', '\r\n    \r\n        Services\r\n    \r\n', '2015-01-07 01:38:16', '2015-01-07 15:06:27', 1),
	(4, 'Test', '1column.phtml', 'Test', 'Test', 'Test', 'Test', 'Test', '2015-01-07 15:04:09', '2015-01-07 15:04:09', 1),
	(5, 'How to', '2column-left.phtml', 'Test', 'Test', 'Test44', 'Test', 'Test', '2015-01-07 15:04:42', '2015-01-07 15:06:52', 1);
/*!40000 ALTER TABLE `cms_pages` ENABLE KEYS */;

-- Dumping structure for table mvc.config
CREATE TABLE IF NOT EXISTS `config` (
  `id` int(10) unsigned NOT NULL,
  `path` varchar(512) NOT NULL,
  `value` varchar(1024) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table mvc.config: ~9 rows (approximately)
DELETE FROM `config`;
/*!40000 ALTER TABLE `config` DISABLE KEYS */;
INSERT INTO `config` (`id`, `path`, `value`) VALUES
	(1, 'site_title', 'PHP7MVC'),
	(2, 'site_meta_description', 'PHP7MVC'),
	(3, 'site_meta_keywords', 'PHP7MVC'),
	(4, 'js_compress', '0'),
	(5, 'css_compress', '0'),
	(6, 'enable_email', '1'),
	(7, 'print_execution_order', '0'),
	(9, 'contact_email', 'admin@example.com'),
	(10, 'contact_name', 'Administrator');
/*!40000 ALTER TABLE `config` ENABLE KEYS */;

-- Dumping structure for table mvc.url_rewrites
CREATE TABLE IF NOT EXISTS `url_rewrites` (
  `url_rewrite_id` int(10) unsigned NOT NULL COMMENT 'Rewrite Id',
  `request_path` varchar(255) DEFAULT NULL COMMENT 'Request Path',
  `target_path` varchar(255) DEFAULT NULL COMMENT 'Target Path',
  `description` varchar(255) DEFAULT NULL COMMENT 'Deascription'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Url Rewrites';

-- Dumping data for table mvc.url_rewrites: ~2 rows (approximately)
DELETE FROM `url_rewrites`;
/*!40000 ALTER TABLE `url_rewrites` DISABLE KEYS */;
INSERT INTO `url_rewrites` (`url_rewrite_id`, `request_path`, `target_path`, `description`) VALUES
	(1, 'contact-us', 'page/contact', NULL),
	(2, 'about-us', 'page/view/id/2', NULL);
/*!40000 ALTER TABLE `url_rewrites` ENABLE KEYS */;

-- Dumping structure for table mvc.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `name` varchar(512) DEFAULT NULL,
  `username` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `user_type` varchar(512) NOT NULL DEFAULT 'USER' COMMENT 'ADMIN - Root Admin, USER - Default frontend user',
  `gender` int(12) DEFAULT NULL,
  `user_bio` text,
  `address` text,
  `contact_no` varchar(16) DEFAULT NULL,
  `photo` varchar(512) DEFAULT '',
  `dob` date DEFAULT NULL,
  `is_active` int(1) DEFAULT '1' COMMENT '0 - Not active, 1 - Active',
  `created_time` datetime NOT NULL,
  `last_visit` datetime NOT NULL,
  `is_root_admin` int(10) DEFAULT '0' COMMENT '0 - No, 1 -Yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table mvc.users: ~2 rows (approximately)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `user_type`, `gender`, `user_bio`, `address`, `contact_no`, `photo`, `dob`, `is_active`, `created_time`, `last_visit`, `is_root_admin`) VALUES
	(1, 'Admin', 'admin', 'admin@admin.com', 'dc06698f0e2e75751545455899adccc3', 'ADMIN', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2015-01-05 01:06:09', '2015-01-05 01:06:09', 1),
	(2, 'Ela', 'ela', 'ela@ela.com', 'dc06698f0e2e75751545455899adccc3', 'USER', 0, '', '', '', '', '0000-00-00', 1, '2015-01-05 20:21:31', '2015-01-05 20:21:31', 0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
