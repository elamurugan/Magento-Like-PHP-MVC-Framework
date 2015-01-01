-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 28, 2014 at 11:24 PM
-- Server version: 5.1.66
-- PHP Version: 5.3.3

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `sample_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int(12) NOT NULL AUTO_INCREMENT,
  `task_id` int(12) NOT NULL,
  `emp_id` int(12) NOT NULL,
  `comment_text` text NOT NULL,
  `comment_attachement` text NOT NULL,
  `attachment_type` varchar(255) DEFAULT NULL,
  `worked_hours` decimal(2,2) DEFAULT NULL,
  `row_inserted_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'the time that the comment was inserted',
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(12) DEFAULT NULL,
  `project_name` varchar(255) NOT NULL,
  `description` text COMMENT 'About the work',
  `assigned_to` varchar(255) DEFAULT NULL COMMENT 'Insert , separated user ids',
  `wiki` text COMMENT 'How to''s',
  `project_start_date` datetime NOT NULL,
  `project_due_date` datetime NOT NULL,
  `project_end_date` datetime NOT NULL,
  `project_description` varchar(512) NOT NULL,
  `project_url` varchar(512) NOT NULL,
  `project_status` enum('0','1','2','3','4','5') DEFAULT NULL COMMENT '0-not started, 1- In discussion, 2- On hold,3-in development, 4-testing, 5- completed',
  `row_inserted_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'the time the project inserted',
  PRIMARY KEY (`project_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `status_report`
--

CREATE TABLE IF NOT EXISTS `status_report` (
  `report_id` int(11) NOT NULL AUTO_INCREMENT,
  `short_line` varchar(256) DEFAULT NULL COMMENT 'ADD ADD OF THESE WITH , SEPARATED: PHP,JS,JQUERY,TRAINING,WORK,PHP FRAMEWORK,etc',
  `description` varchar(255) NOT NULL,
  `report_type` int(1) DEFAULT NULL COMMENT '1 - Work, 2- Training, 3 - Gave Training, 4 - Discussion',
  `user_id` int(12) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL,
  `bill_hour` varchar(11) NOT NULL,
  `actual_hour` varchar(11) NOT NULL,
  `date` date NOT NULL,
  `row_inserted_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`report_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `task_id` int(12) NOT NULL AUTO_INCREMENT,
  `task_name` varchar(512) NOT NULL,
  `project_id` int(12) NOT NULL,
  `assigned_to` int(12) DEFAULT NULL,
  `created_emp_id` int(12) NOT NULL,
  `task_description` varchar(512) NOT NULL,
  `task_start_date` datetime NOT NULL,
  `task_due_date` datetime NOT NULL,
  `task_end_date` datetime NOT NULL,
  `estimated_time` int(12) DEFAULT NULL COMMENT 'In hours',
  `task_status` enum('0','1','2','3','4','5') DEFAULT '0' COMMENT '0-not started, 1- waiting for client reply, 2- need clarification ,3-in development, 4-testing, 5- completed',
  `task_priority` enum('1','2','3','4','5') NOT NULL COMMENT '1-highest,2-high,3-normal,4-low,5-lowest',
  `row_inserted_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`task_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

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

-- --------------------------------------------------------

--
-- Table structure for table `wpr`
--

CREATE TABLE IF NOT EXISTS `wpr` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `user_id` int(12) NOT NULL,
  `time_in` datetime NOT NULL,
  `time_out` datetime NOT NULL,
  `date` date NOT NULL,
  `wpr_type` enum('0','1','2','3','4') NOT NULL COMMENT '0 - absent, 1 - present, 2  - extra working day, 3  - holiday,4 - On leave',
  `description` text,
  `comment` text,
  `row_inserted_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
SET FOREIGN_KEY_CHECKS=1;
