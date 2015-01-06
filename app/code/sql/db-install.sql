CREATE TABLE IF NOT EXISTS `config` (
  `id`    INT(12)      NOT NULL,
  `path`  VARCHAR(512) NOT NULL,
  `value` VARCHAR(1024) DEFAULT NULL
)
  ENGINE =InnoDB
  AUTO_INCREMENT =1
  DEFAULT CHARSET =latin1;

CREATE TABLE IF NOT EXISTS `users` (
  `id`           INT(11)                     NOT NULL AUTO_INCREMENT,
  `name`         VARCHAR(512)                         DEFAULT NULL,
  `username`     VARCHAR(128)                NOT NULL,
  `email`        VARCHAR(128)                NOT NULL,
  `password`     VARCHAR(128)                NOT NULL,
  `user_type`    VARCHAR(512) DEFAULT 'USER' NOT NULL
  COMMENT 'ADMIN - Root Admin, USER - Default frontend user',
  `gender`       INT(12)                              DEFAULT NULL,
  `user_bio`     TEXT,
  `address`      TEXT,
  `contact_no`   VARCHAR(16)                          DEFAULT NULL,
  `photo`        VARCHAR(512)                         DEFAULT '',
  `dob`          DATE                                 DEFAULT NULL,
  `is_active`    INT(1)                               DEFAULT '1'
  COMMENT '0 - Not active, 1 - Active',
  `created_time` DATETIME()                     DEFAULT NULL,
  `last_visit`   DATETIME()                     DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8
  AUTO_INCREMENT =1;


CREATE TABLE IF NOT EXISTS `cms_pages` (
  `page_id`          SMALLINT(6) NOT NULL AUTO_INCREMENT COMMENT 'Page ID',
  `title`            VARCHAR(255)         DEFAULT NULL
  COMMENT 'Page Title',
  `root_template`    VARCHAR(255)         DEFAULT NULL
  COMMENT 'Page Template',
  `meta_keywords`    TEXT COMMENT 'Page Meta Keywords',
  `meta_description` TEXT COMMENT 'Page Meta Description',
  `identifier`       VARCHAR(100)         DEFAULT NULL
  COMMENT 'Page String Identifier',
  `content_heading`  VARCHAR(255)         DEFAULT NULL
  COMMENT 'Page Content Heading',
  `content`          MEDIUMTEXT COMMENT 'Page Content',
  `creation_time`    TIMESTAMP   NULL     DEFAULT NULL
  COMMENT 'Page Creation Time',
  `update_time`      TIMESTAMP   NULL     DEFAULT NULL
  COMMENT 'Page Modification Time',
  `is_active`        SMALLINT(6) NOT NULL DEFAULT '1'
  COMMENT 'Is Page Active',
  PRIMARY KEY (`page_id`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8
  COMMENT ='CMS Page Table'
  AUTO_INCREMENT =1;

CREATE TABLE IF NOT EXISTS `url_rewrites` (
  `url_rewrite_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Rewrite Id',
  `request_path`   VARCHAR(255) DEFAULT NULL
  COMMENT 'Request Path',
  `target_path`    VARCHAR(255) DEFAULT NULL
  COMMENT 'Target Path',
  `description`    VARCHAR(255) DEFAULT NULL
  COMMENT 'Deascription',
  PRIMARY KEY (`url_rewrite_id`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8
  COMMENT ='Url Rewrites'
  AUTO_INCREMENT =1;

INSERT INTO `config` (`id`, `path`, `value`) VALUES
  (1, 'site_title', 'Slim MVC Framework'),
  (2, 'site_meta_description', 'Slim MVC Framework'),
  (3, 'site_meta_keywords', 'Slim MVC Framework'),
  (4, 'js_compress', '1'),
  (5, 'css_compress', '1');

INSERT INTO `cms_pages` (`page_id`, `title`, `root_template`, `meta_keywords`, `meta_description`, `identifier`, `content_heading`, `content`, `creation_time`, `update_time`, `is_active`)
VALUES
  (2, 'About Us', '2column-left.phtml', 'About Us', 'About Us', 'about-us', 'About Us',
   '<div class="page_width">\r\n    <div class=''row''>\r\n        <p>About Us</p>\r\n    </div>\r\n</div>\r\n',
   '0000-00-00 00:00:00', NULL, 1);

INSERT INTO `url_rewrites` (`url_rewrite_id`, `request_path`, `target_path`, `description`) VALUES
  (1, 'contact-us', 'page/contact', NULL),
  (2, 'about-us', 'page/view/id/2', NULL);

ALTER TABLE `users` ADD `is_root_admin` INT(10) NULL DEFAULT '0' COMMENT '0 - No, 1 -Yes' ;