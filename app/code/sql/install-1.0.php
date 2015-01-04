<?php
$installer = $this;
try {
    $tablePrefix = '';
    $sql = <<<SQLTEXT
CREATE TABLE IF NOT EXISTS `{{$tablePrefix}}config` (
`id` int(12) NOT NULL,
  `path` varchar(512) NOT NULL,
  `value` varchar(1024) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `{{$tablePrefix}}users` (
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



CREATE TABLE IF NOT EXISTS `{{$tablePrefix}}cms_pages` (
  `page_id` smallint(6) NOT NULL AUTO_INCREMENT COMMENT 'Page ID',
  `title` varchar(255) DEFAULT NULL COMMENT 'Page Title',
  `root_template` varchar(255) DEFAULT NULL COMMENT 'Page Template',
  `meta_keywords` text COMMENT 'Page Meta Keywords',
  `meta_description` text COMMENT 'Page Meta Description',
  `identifier` varchar(100) DEFAULT NULL COMMENT 'Page String Identifier',
  `content_heading` varchar(255) DEFAULT NULL COMMENT 'Page Content Heading',
  `content` mediumtext COMMENT 'Page Content',
  `creation_time` timestamp NULL DEFAULT NULL COMMENT 'Page Creation Time',
  `update_time` timestamp NULL DEFAULT NULL COMMENT 'Page Modification Time',
  `is_active` smallint(6) NOT NULL DEFAULT '1' COMMENT 'Is Page Active',
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='CMS Page Table' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `{{$tablePrefix}}url_rewrites` (
  `url_rewrite_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Rewrite Id',
  `request_path` varchar(255) DEFAULT NULL COMMENT 'Request Path',
  `target_path` varchar(255) DEFAULT NULL COMMENT 'Target Path',
  `description` varchar(255) DEFAULT NULL COMMENT 'Deascription',
  PRIMARY KEY (`url_rewrite_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Url Rewrites' AUTO_INCREMENT=1 ;

SQLTEXT;

    $installer->run($sql);
} catch (Exception $e) {
    $installer->log($e->getMessage());
}

