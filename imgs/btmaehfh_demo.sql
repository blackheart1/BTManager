-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Aug 26, 2016 at 09:20 PM
-- Server version: 5.5.49-cll-lve
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `btmaehfh_demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `torrent_acl_groups`
--

CREATE TABLE IF NOT EXISTS `torrent_acl_groups` (
  `group_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `forum_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `auth_option_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `auth_role_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `auth_setting` tinyint(2) NOT NULL DEFAULT '0',
  KEY `group_id` (`group_id`),
  KEY `auth_opt_id` (`auth_option_id`),
  KEY `auth_role_id` (`auth_role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `torrent_acl_groups`
--

INSERT INTO `torrent_acl_groups` (`group_id`, `forum_id`, `auth_option_id`, `auth_role_id`, `auth_setting`) VALUES
(5, 0, 0, 5, 0),
(5, 0, 0, 10, 0),
(5, 0, 0, 4, 0),
(1, 0, 0, 5, 0),
(1, 0, 0, 10, 0),
(1, 0, 0, 4, 0),
(2, 0, 0, 5, 0),
(2, 0, 0, 10, 0),
(2, 0, 83, 0, 1),
(2, 0, 57, 0, 1),
(2, 0, 58, 0, 1),
(2, 0, 59, 0, 1),
(2, 0, 71, 0, 1),
(2, 0, 44, 0, 1),
(3, 0, 0, 5, 0),
(3, 0, 0, 13, 0),
(4, 0, 0, 6, 0),
(7, 0, 0, 8, 0),
(1, 1, 0, 14, 0),
(2, 1, 0, 21, 0),
(3, 1, 0, 21, 0),
(4, 1, 0, 15, 0),
(5, 1, 0, 14, 0),
(6, 1, 0, 21, 0),
(8, 1, 0, 21, 0),
(9, 1, 0, 15, 0),
(9, 2, 0, 15, 0),
(8, 2, 0, 21, 0),
(6, 2, 0, 21, 0),
(5, 2, 0, 14, 0),
(4, 2, 0, 15, 0),
(3, 2, 0, 21, 0),
(2, 2, 0, 21, 0),
(1, 2, 0, 14, 0);

-- --------------------------------------------------------

--
-- Table structure for table `torrent_acl_options`
--

CREATE TABLE IF NOT EXISTS `torrent_acl_options` (
  `auth_option_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `auth_option` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '',
  `is_global` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_local` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `founder_only` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`auth_option_id`),
  UNIQUE KEY `auth_option` (`auth_option`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=117 ;

--
-- Dumping data for table `torrent_acl_options`
--

INSERT INTO `torrent_acl_options` (`auth_option_id`, `auth_option`, `is_global`, `is_local`, `founder_only`) VALUES
(1, 'f_', 0, 1, 0),
(2, 'f_announce', 0, 1, 0),
(3, 'f_attach', 0, 1, 0),
(4, 'f_bbcode', 0, 1, 0),
(5, 'f_bump', 0, 1, 0),
(6, 'f_delete', 0, 1, 0),
(7, 'f_download', 0, 1, 0),
(8, 'f_edit', 0, 1, 0),
(9, 'f_email', 0, 1, 0),
(10, 'f_flash', 0, 1, 0),
(11, 'f_icons', 0, 1, 0),
(12, 'f_ignoreflood', 0, 1, 0),
(13, 'f_img', 0, 1, 0),
(14, 'f_list', 0, 1, 0),
(15, 'f_noapprove', 0, 1, 0),
(16, 'f_poll', 0, 1, 0),
(17, 'f_post', 0, 1, 0),
(18, 'f_postcount', 0, 1, 0),
(19, 'f_print', 0, 1, 0),
(20, 'f_read', 0, 1, 0),
(21, 'f_reply', 0, 1, 0),
(22, 'f_report', 0, 1, 0),
(23, 'f_search', 0, 1, 0),
(24, 'f_sigs', 0, 1, 0),
(25, 'f_smilies', 0, 1, 0),
(26, 'f_sticky', 0, 1, 0),
(27, 'f_subscribe', 0, 1, 0),
(28, 'f_user_lock', 0, 1, 0),
(29, 'f_vote', 0, 1, 0),
(30, 'f_votechg', 0, 1, 0),
(31, 'm_', 1, 1, 0),
(32, 'm_approve', 1, 1, 0),
(33, 'm_chgposter', 1, 1, 0),
(34, 'm_delete', 1, 1, 0),
(35, 'm_edit', 1, 1, 0),
(36, 'm_info', 1, 1, 0),
(37, 'm_lock', 1, 1, 0),
(38, 'm_merge', 1, 1, 0),
(39, 'm_move', 1, 1, 0),
(40, 'm_report', 1, 1, 0),
(41, 'm_split', 1, 1, 0),
(42, 'm_ban', 1, 0, 0),
(43, 'm_warn', 1, 0, 0),
(44, 'a_', 1, 0, 0),
(45, 'a_aauth', 1, 0, 0),
(46, 'a_attach', 1, 0, 0),
(47, 'a_authgroups', 1, 0, 0),
(48, 'a_authusers', 1, 0, 0),
(49, 'a_backup', 1, 0, 0),
(50, 'a_ban', 1, 0, 0),
(51, 'a_bbcode', 1, 0, 0),
(52, 'a_board', 1, 0, 0),
(53, 'a_bots', 1, 0, 0),
(54, 'a_clearlogs', 1, 0, 0),
(55, 'a_email', 1, 0, 0),
(56, 'a_fauth', 1, 0, 0),
(57, 'a_forum', 1, 0, 0),
(58, 'a_forumadd', 1, 0, 0),
(59, 'a_forumdel', 1, 0, 0),
(60, 'a_group', 1, 0, 0),
(61, 'a_groupadd', 1, 0, 0),
(62, 'a_groupdel', 1, 0, 0),
(63, 'a_icons', 1, 0, 0),
(64, 'a_jabber', 1, 0, 0),
(65, 'a_language', 1, 0, 0),
(66, 'a_mauth', 1, 0, 0),
(67, 'a_modules', 1, 0, 0),
(68, 'a_names', 1, 0, 0),
(69, 'a_phpinfo', 1, 0, 0),
(70, 'a_profile', 1, 0, 0),
(71, 'a_prune', 1, 0, 0),
(72, 'a_ranks', 1, 0, 0),
(73, 'a_reasons', 1, 0, 0),
(74, 'a_roles', 1, 0, 0),
(75, 'a_search', 1, 0, 0),
(76, 'a_server', 1, 0, 0),
(77, 'a_styles', 1, 0, 0),
(78, 'a_switchperm', 1, 0, 0),
(79, 'a_uauth', 1, 0, 0),
(80, 'a_user', 1, 0, 0),
(81, 'a_userdel', 1, 0, 0),
(82, 'a_viewauth', 1, 0, 0),
(83, 'a_viewlogs', 1, 0, 0),
(84, 'a_words', 1, 0, 0),
(85, 'u_', 1, 0, 0),
(86, 'u_attach', 1, 0, 0),
(87, 'u_chgavatar', 1, 0, 0),
(88, 'u_chgcensors', 1, 0, 0),
(89, 'u_chgemail', 1, 0, 0),
(90, 'u_chggrp', 1, 0, 0),
(91, 'u_chgname', 1, 0, 0),
(92, 'u_chgpasswd', 1, 0, 0),
(93, 'u_download', 1, 0, 0),
(94, 'u_hideonline', 1, 0, 0),
(95, 'u_ignoreflood', 1, 0, 0),
(96, 'u_masspm', 1, 0, 0),
(97, 'u_pm_attach', 1, 0, 0),
(98, 'u_pm_bbcode', 1, 0, 0),
(99, 'u_pm_delete', 1, 0, 0),
(100, 'u_pm_download', 1, 0, 0),
(101, 'u_pm_edit', 1, 0, 0),
(102, 'u_pm_emailpm', 1, 0, 0),
(103, 'u_pm_flash', 1, 0, 0),
(104, 'u_pm_forward', 1, 0, 0),
(105, 'u_pm_img', 1, 0, 0),
(106, 'u_pm_printpm', 1, 0, 0),
(107, 'u_pm_smilies', 1, 0, 0),
(108, 'u_readpm', 1, 0, 0),
(109, 'u_savedrafts', 1, 0, 0),
(110, 'u_search', 1, 0, 0),
(111, 'u_sendemail', 1, 0, 0),
(112, 'u_sendim', 1, 0, 0),
(113, 'u_sendpm', 1, 0, 0),
(114, 'u_sig', 1, 0, 0),
(115, 'u_viewonline', 1, 0, 0),
(116, 'u_viewprofile', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `torrent_acl_roles`
--

CREATE TABLE IF NOT EXISTS `torrent_acl_roles` (
  `role_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `role_description` text COLLATE utf8_bin NOT NULL,
  `role_type` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT '',
  `role_order` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`role_id`),
  KEY `role_type` (`role_type`),
  KEY `role_order` (`role_order`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=23 ;

--
-- Dumping data for table `torrent_acl_roles`
--

INSERT INTO `torrent_acl_roles` (`role_id`, `role_name`, `role_description`, `role_type`, `role_order`) VALUES
(1, 'ROLE_ADMIN_STANDARD', 'ROLE_DESCRIPTION_ADMIN_STANDARD', 'a_', 1),
(2, 'ROLE_ADMIN_FORUM', 'ROLE_DESCRIPTION_ADMIN_FORUM', 'a_', 3),
(3, 'ROLE_ADMIN_USERGROUP', 'ROLE_DESCRIPTION_ADMIN_USERGROUP', 'a_', 4),
(4, 'ROLE_ADMIN_FULL', 'ROLE_DESCRIPTION_ADMIN_FULL', 'a_', 2),
(5, 'ROLE_USER_FULL', 'ROLE_DESCRIPTION_USER_FULL', 'u_', 3),
(6, 'ROLE_USER_STANDARD', 'ROLE_DESCRIPTION_USER_STANDARD', 'u_', 1),
(7, 'ROLE_USER_LIMITED', 'ROLE_DESCRIPTION_USER_LIMITED', 'u_', 2),
(8, 'ROLE_USER_NOPM', 'ROLE_DESCRIPTION_USER_NOPM', 'u_', 4),
(9, 'ROLE_USER_NOAVATAR', 'ROLE_DESCRIPTION_USER_NOAVATAR', 'u_', 5),
(10, 'ROLE_MOD_FULL', 'ROLE_DESCRIPTION_MOD_FULL', 'm_', 3),
(11, 'ROLE_MOD_STANDARD', 'ROLE_DESCRIPTION_MOD_STANDARD', 'm_', 1),
(12, 'ROLE_MOD_SIMPLE', 'ROLE_DESCRIPTION_MOD_SIMPLE', 'm_', 2),
(13, 'ROLE_MOD_QUEUE', 'ROLE_DESCRIPTION_MOD_QUEUE', 'm_', 4),
(14, 'ROLE_FORUM_FULL', 'ROLE_DESCRIPTION_FORUM_FULL', 'f_', 7),
(15, 'ROLE_FORUM_STANDARD', 'ROLE_DESCRIPTION_FORUM_STANDARD', 'f_', 5),
(16, 'ROLE_FORUM_NOACCESS', 'ROLE_DESCRIPTION_FORUM_NOACCESS', 'f_', 1),
(17, 'ROLE_FORUM_READONLY', 'ROLE_DESCRIPTION_FORUM_READONLY', 'f_', 2),
(18, 'ROLE_FORUM_LIMITED', 'ROLE_DESCRIPTION_FORUM_LIMITED', 'f_', 3),
(19, 'ROLE_FORUM_BOT', 'ROLE_DESCRIPTION_FORUM_BOT', 'f_', 9),
(20, 'ROLE_FORUM_ONQUEUE', 'ROLE_DESCRIPTION_FORUM_ONQUEUE', 'f_', 8),
(21, 'ROLE_FORUM_POLLS', 'ROLE_DESCRIPTION_FORUM_POLLS', 'f_', 6),
(22, 'ROLE_FORUM_LIMITED_POLLS', 'ROLE_DESCRIPTION_FORUM_LIMITED_POLLS', 'f_', 4);

-- --------------------------------------------------------

--
-- Table structure for table `torrent_acl_roles_data`
--

CREATE TABLE IF NOT EXISTS `torrent_acl_roles_data` (
  `role_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `auth_option_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `auth_setting` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`role_id`,`auth_option_id`),
  KEY `ath_op_id` (`auth_option_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `torrent_acl_roles_data`
--

INSERT INTO `torrent_acl_roles_data` (`role_id`, `auth_option_id`, `auth_setting`) VALUES
(1, 44, 1),
(1, 46, 1),
(1, 47, 1),
(1, 48, 1),
(1, 50, 1),
(1, 51, 1),
(1, 52, 1),
(1, 56, 1),
(1, 57, 1),
(1, 58, 1),
(1, 59, 1),
(1, 60, 1),
(1, 61, 1),
(1, 62, 1),
(1, 63, 1),
(1, 66, 1),
(1, 68, 1),
(1, 70, 1),
(1, 71, 1),
(1, 72, 1),
(1, 73, 1),
(1, 79, 1),
(1, 80, 1),
(1, 81, 1),
(1, 82, 1),
(1, 83, 1),
(1, 84, 1),
(2, 44, 1),
(2, 47, 1),
(2, 48, 1),
(2, 56, 1),
(2, 57, 1),
(2, 58, 1),
(2, 59, 1),
(2, 66, 1),
(2, 71, 1),
(2, 79, 1),
(2, 82, 1),
(2, 83, 1),
(3, 44, 1),
(3, 47, 1),
(3, 48, 1),
(3, 50, 1),
(3, 60, 1),
(3, 61, 1),
(3, 62, 1),
(3, 72, 1),
(3, 79, 1),
(3, 80, 1),
(3, 82, 1),
(3, 83, 1),
(4, 44, 1),
(4, 45, 1),
(4, 46, 1),
(4, 47, 1),
(4, 48, 1),
(4, 49, 1),
(4, 50, 1),
(4, 51, 1),
(4, 52, 1),
(4, 53, 1),
(4, 54, 1),
(4, 55, 1),
(4, 56, 1),
(4, 57, 1),
(4, 58, 1),
(4, 59, 1),
(4, 60, 1),
(4, 61, 1),
(4, 62, 1),
(4, 63, 1),
(4, 64, 1),
(4, 65, 1),
(4, 66, 1),
(4, 67, 1),
(4, 68, 1),
(4, 69, 1),
(4, 70, 1),
(4, 71, 1),
(4, 72, 1),
(4, 73, 1),
(4, 74, 1),
(4, 75, 1),
(4, 76, 1),
(4, 77, 1),
(4, 78, 1),
(4, 79, 1),
(4, 80, 1),
(4, 81, 1),
(4, 82, 1),
(4, 83, 1),
(4, 84, 1),
(5, 85, 1),
(5, 86, 1),
(5, 87, 1),
(5, 88, 1),
(5, 89, 1),
(5, 90, 1),
(5, 91, 1),
(5, 92, 1),
(5, 93, 1),
(5, 94, 1),
(5, 95, 1),
(5, 96, 1),
(5, 97, 1),
(5, 98, 1),
(5, 99, 1),
(5, 100, 1),
(5, 101, 1),
(5, 102, 1),
(5, 103, 1),
(5, 104, 1),
(5, 105, 1),
(5, 106, 1),
(5, 107, 1),
(5, 108, 1),
(5, 109, 1),
(5, 110, 1),
(5, 111, 1),
(5, 112, 1),
(5, 113, 1),
(5, 114, 1),
(5, 115, 1),
(5, 116, 1),
(6, 85, 1),
(6, 86, 1),
(6, 87, 1),
(6, 88, 1),
(6, 89, 1),
(6, 92, 1),
(6, 93, 1),
(6, 94, 1),
(6, 96, 1),
(6, 97, 1),
(6, 98, 1),
(6, 99, 1),
(6, 100, 1),
(6, 101, 1),
(6, 102, 1),
(6, 105, 1),
(6, 106, 1),
(6, 107, 1),
(6, 108, 1),
(6, 109, 1),
(6, 110, 1),
(6, 111, 1),
(6, 112, 1),
(6, 113, 1),
(6, 114, 1),
(6, 116, 1),
(7, 85, 1),
(7, 87, 1),
(7, 88, 1),
(7, 89, 1),
(7, 92, 1),
(7, 93, 1),
(7, 94, 1),
(7, 96, 1),
(7, 98, 1),
(7, 99, 1),
(7, 100, 1),
(7, 101, 1),
(7, 104, 1),
(7, 105, 1),
(7, 106, 1),
(7, 107, 1),
(7, 108, 1),
(7, 113, 1),
(7, 114, 1),
(7, 116, 1),
(8, 85, 1),
(8, 87, 1),
(8, 88, 1),
(8, 89, 1),
(8, 92, 1),
(8, 93, 1),
(8, 94, 1),
(8, 114, 1),
(8, 116, 1),
(8, 96, 0),
(8, 108, 0),
(8, 113, 0),
(9, 85, 1),
(9, 88, 1),
(9, 89, 1),
(9, 92, 1),
(9, 93, 1),
(9, 94, 1),
(9, 96, 1),
(9, 98, 1),
(9, 99, 1),
(9, 100, 1),
(9, 101, 1),
(9, 104, 1),
(9, 105, 1),
(9, 106, 1),
(9, 107, 1),
(9, 108, 1),
(9, 113, 1),
(9, 114, 1),
(9, 116, 1),
(9, 87, 0),
(10, 31, 1),
(10, 32, 1),
(10, 42, 1),
(10, 33, 1),
(10, 34, 1),
(10, 35, 1),
(10, 36, 1),
(10, 37, 1),
(10, 38, 1),
(10, 39, 1),
(10, 40, 1),
(10, 41, 1),
(10, 43, 1),
(11, 31, 1),
(11, 32, 1),
(11, 34, 1),
(11, 35, 1),
(11, 36, 1),
(11, 37, 1),
(11, 38, 1),
(11, 39, 1),
(11, 40, 1),
(11, 41, 1),
(11, 43, 1),
(12, 31, 1),
(12, 34, 1),
(12, 35, 1),
(12, 36, 1),
(12, 40, 1),
(13, 31, 1),
(13, 32, 1),
(13, 35, 1),
(14, 1, 1),
(14, 2, 1),
(14, 3, 1),
(14, 4, 1),
(14, 5, 1),
(14, 6, 1),
(14, 7, 1),
(14, 8, 1),
(14, 9, 1),
(14, 10, 1),
(14, 11, 1),
(14, 12, 1),
(14, 13, 1),
(14, 14, 1),
(14, 15, 1),
(14, 16, 1),
(14, 17, 1),
(14, 18, 1),
(14, 19, 1),
(14, 20, 1),
(14, 21, 1),
(14, 22, 1),
(14, 23, 1),
(14, 24, 1),
(14, 25, 1),
(14, 26, 1),
(14, 27, 1),
(14, 28, 1),
(14, 29, 1),
(14, 30, 1),
(15, 1, 1),
(15, 3, 1),
(15, 4, 1),
(15, 5, 1),
(15, 6, 1),
(15, 7, 1),
(15, 8, 1),
(15, 9, 1),
(15, 10, 1),
(15, 11, 1),
(15, 13, 1),
(15, 14, 1),
(15, 15, 1),
(15, 17, 1),
(15, 18, 1),
(15, 19, 1),
(15, 20, 1),
(15, 21, 1),
(15, 22, 1),
(15, 23, 1),
(15, 24, 1),
(15, 25, 1),
(15, 27, 1),
(15, 29, 1),
(15, 30, 1),
(16, 1, 0),
(17, 1, 1),
(17, 7, 1),
(17, 14, 1),
(17, 19, 1),
(17, 20, 1),
(17, 23, 1),
(17, 27, 1),
(18, 1, 1),
(18, 4, 1),
(18, 7, 1),
(18, 8, 1),
(18, 9, 1),
(18, 13, 1),
(18, 14, 1),
(18, 15, 1),
(18, 17, 1),
(18, 18, 1),
(18, 19, 1),
(18, 20, 1),
(18, 21, 1),
(18, 22, 1),
(18, 23, 1),
(18, 24, 1),
(18, 25, 1),
(18, 27, 1),
(18, 29, 1),
(19, 1, 1),
(19, 7, 1),
(19, 14, 1),
(19, 19, 1),
(19, 20, 1),
(20, 1, 1),
(20, 3, 1),
(20, 4, 1),
(20, 7, 1),
(20, 8, 1),
(20, 9, 1),
(20, 13, 1),
(20, 14, 1),
(20, 17, 1),
(20, 18, 1),
(20, 19, 1),
(20, 20, 1),
(20, 21, 1),
(20, 22, 1),
(20, 23, 1),
(20, 24, 1),
(20, 25, 1),
(20, 27, 1),
(20, 29, 1),
(20, 15, 0),
(21, 1, 1),
(21, 3, 1),
(21, 4, 1),
(21, 5, 1),
(21, 6, 1),
(21, 7, 1),
(21, 8, 1),
(21, 9, 1),
(21, 10, 1),
(21, 11, 1),
(21, 13, 1),
(21, 14, 1),
(21, 15, 1),
(21, 16, 1),
(21, 17, 1),
(21, 18, 1),
(21, 19, 1),
(21, 20, 1),
(21, 21, 1),
(21, 22, 1),
(21, 23, 1),
(21, 24, 1),
(21, 25, 1),
(21, 27, 1),
(21, 29, 1),
(21, 30, 1),
(22, 1, 1),
(22, 4, 1),
(22, 7, 1),
(22, 8, 1),
(22, 9, 1),
(22, 13, 1),
(22, 14, 1),
(22, 15, 1),
(22, 16, 1),
(22, 17, 1),
(22, 18, 1),
(22, 19, 1),
(22, 20, 1),
(22, 21, 1),
(22, 22, 1),
(22, 23, 1),
(22, 24, 1),
(22, 25, 1),
(22, 27, 1),
(22, 29, 1);

-- --------------------------------------------------------

--
-- Table structure for table `torrent_acl_users`
--

CREATE TABLE IF NOT EXISTS `torrent_acl_users` (
  `user_id` int(12) unsigned NOT NULL DEFAULT '0',
  `forum_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `auth_option_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `auth_role_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `auth_setting` tinyint(2) NOT NULL DEFAULT '0',
  KEY `user_id` (`user_id`),
  KEY `auth_option_id` (`auth_option_id`),
  KEY `auth_role_id` (`auth_role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `torrent_acl_users`
--

INSERT INTO `torrent_acl_users` (`user_id`, `forum_id`, `auth_option_id`, `auth_role_id`, `auth_setting`) VALUES
(82, 0, 85, 0, 1),
(82, 0, 113, 0, 1),
(82, 0, 108, 0, 1),
(82, 0, 107, 0, 1),
(82, 0, 106, 0, 1),
(82, 0, 105, 0, 1),
(82, 0, 102, 0, 1),
(82, 0, 101, 0, 1),
(82, 0, 100, 0, 1),
(82, 0, 99, 0, 1),
(82, 0, 98, 0, 1),
(82, 0, 97, 0, 1),
(82, 0, 96, 0, 1),
(82, 0, 112, 0, 1),
(82, 0, 111, 0, 1),
(82, 0, 110, 0, 1),
(82, 0, 94, 0, 1),
(82, 0, 116, 0, 1),
(82, 0, 92, 0, 1),
(82, 0, 89, 0, 1),
(82, 0, 87, 0, 1),
(82, 0, 114, 0, 1),
(82, 0, 109, 0, 1),
(82, 0, 93, 0, 1),
(82, 0, 88, 0, 1),
(82, 0, 86, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `torrent_attachments`
--

CREATE TABLE IF NOT EXISTS `torrent_attachments` (
  `attach_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `post_msg_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `in_message` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `poster_id` int(20) unsigned NOT NULL DEFAULT '0',
  `is_orphan` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `physical_filename` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `real_filename` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `download_count` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `attach_comment` text COLLATE utf8_bin NOT NULL,
  `extension` varchar(100) COLLATE utf8_bin NOT NULL DEFAULT '',
  `mimetype` varchar(100) COLLATE utf8_bin NOT NULL DEFAULT '',
  `filesize` int(20) unsigned NOT NULL DEFAULT '0',
  `filetime` int(11) unsigned NOT NULL DEFAULT '0',
  `thumbnail` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`attach_id`),
  KEY `filetime` (`filetime`),
  KEY `post_msg_id` (`post_msg_id`),
  KEY `topic_id` (`topic_id`),
  KEY `poster_id` (`poster_id`),
  KEY `is_orphan` (`is_orphan`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin ;


--
-- Table structure for table `torrent_attachments_config`
--

CREATE TABLE IF NOT EXISTS `torrent_attachments_config` (
  `config_name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `config_value` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `is_dynamic` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`config_name`),
  KEY `is_dynamic` (`is_dynamic`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `torrent_attachments_config`
--

INSERT INTO `torrent_attachments_config` (`config_name`, `config_value`, `is_dynamic`) VALUES
('max_attachments_pm', '10', 0),
('max_attachments', '20', 0),
('img_create_thumbnail', '0', 0),
('img_max_width', '52428800', 0),
('img_max_height', '', 0),
('max_filesize_pm', '262144', 0),
('max_filesize', '262144', 0),
('upload_path', 'files', 0),
('attachment_quota', '52428800', 0),
('upload_dir_size', '482415', 0),
('img_max_thumb_width', '400', 0),
('img_min_thumb_filesize', '12000', 0),
('img_imagick', '0', 0),
('num_files', '2', 0),
('rand_seed_last_update', '0', 1),
('rand_seed', '0', 1),
('allow_attachments', '0', 0),
('allow_pm_attach', '0', 0),
('display_order', '0', 0),
('secure_downloads', '0', 0),
('secure_allow_deny', '0', 0),
('secure_allow_empty_referer', '0', 0),
('check_attachment_content', '0', 0),
('img_display_inlined', '1', 0),
('img_link_width', '0', 0);

-- --------------------------------------------------------

--
-- Table structure for table `torrent_avatar_config`
--

CREATE TABLE IF NOT EXISTS `torrent_avatar_config` (
  `enable_avatars` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `enable_gallery_avatars` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `enable_remote_avatars` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `enable_avatar_uploading` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `enable_remote_avatar_uploading` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `maximum_avatar_file_size` varchar(225) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `avatar_storage_path` varchar(225) COLLATE utf8_bin NOT NULL DEFAULT 'avatar/user',
  `avatar_gallery_path` varchar(225) COLLATE utf8_bin NOT NULL DEFAULT 'avatar',
  `minimum_avatar_dimensions_ht` varchar(225) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `minimum_avatar_dimensions_wt` varchar(225) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `maximum_avatar_dimensions_ht` varchar(225) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `maximum_avatar_dimensions_wt` varchar(225) COLLATE utf8_bin NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `torrent_avatar_config`
--

INSERT INTO `torrent_avatar_config` (`enable_avatars`, `enable_gallery_avatars`, `enable_remote_avatars`, `enable_avatar_uploading`, `enable_remote_avatar_uploading`, `maximum_avatar_file_size`, `avatar_storage_path`, `avatar_gallery_path`, `minimum_avatar_dimensions_ht`, `minimum_avatar_dimensions_wt`, `maximum_avatar_dimensions_ht`, `maximum_avatar_dimensions_wt`) VALUES
('true', 'true', 'true', 'true', 'true', '23344', 'avatars/user', 'avatars/smilies', '20', '20', '200', '200');

-- --------------------------------------------------------

--
-- Table structure for table `torrent_avps`
--

CREATE TABLE IF NOT EXISTS `torrent_avps` (
  `arg` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '',
  `value_s` text COLLATE utf8_bin NOT NULL,
  `value_i` int(11) NOT NULL DEFAULT '0',
  `value_u` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`arg`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `torrent_avps`
--

INSERT INTO `torrent_avps` (`arg`, `value_s`, `value_i`, `value_u`) VALUES
('lastcleantime', '', 0, 1472259134);

-- --------------------------------------------------------

--
-- Table structure for table `torrent_banlist`
--

CREATE TABLE IF NOT EXISTS `torrent_banlist` (
  `ban_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ban_userid` int(20) unsigned NOT NULL DEFAULT '0',
  `ban_ip` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '',
  `ban_email` varchar(100) COLLATE utf8_bin NOT NULL DEFAULT '',
  `ban_start` int(11) unsigned NOT NULL DEFAULT '0',
  `ban_end` int(11) unsigned NOT NULL DEFAULT '0',
  `ban_exclude` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ban_reason` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `ban_give_reason` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`ban_id`),
  KEY `ban_end` (`ban_end`),
  KEY `ban_user` (`ban_userid`,`ban_exclude`),
  KEY `ban_email` (`ban_email`,`ban_exclude`),
  KEY `ban_ip` (`ban_ip`,`ban_exclude`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Dumping data for table `torrent_banlist`
--

INSERT INTO `torrent_banlist` (`ban_id`, `ban_userid`, `ban_ip`, `ban_email`, `ban_start`, `ban_end`, `ban_exclude`, `ban_reason`, `ban_give_reason`) VALUES
(1, 0, '36885601', '', 1435442877, 0, 0, 'IP banned via user management', 'test ban');

-- --------------------------------------------------------

--
-- Table structure for table `torrent_bans`
--

CREATE TABLE IF NOT EXISTS `torrent_bans` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ban_userid` mediumint(8) NOT NULL DEFAULT '0',
  `ban_email` varchar(100) COLLATE utf8_bin NOT NULL DEFAULT '',
  `ipstart` int(10) unsigned NOT NULL DEFAULT '0',
  `ipend` int(10) unsigned NOT NULL DEFAULT '0',
  `ban_start` int(11) NOT NULL DEFAULT '0',
  `ban_end` int(11) NOT NULL DEFAULT '0',
  `ban_exclude` int(1) NOT NULL DEFAULT '0',
  `reason` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `ban_give_reason` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip_unique` (`ipstart`,`ipend`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `torrent_bbcodes`
--

CREATE TABLE IF NOT EXISTS `torrent_bbcodes` (
  `bbcode_id` tinyint(3) NOT NULL DEFAULT '0',
  `bbcode_tag` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '',
  `bbcode_helpline` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `display_on_posting` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `bbcode_match` text COLLATE utf8_bin NOT NULL,
  `bbcode_tpl` mediumtext COLLATE utf8_bin NOT NULL,
  `first_pass_match` mediumtext COLLATE utf8_bin NOT NULL,
  `first_pass_replace` mediumtext COLLATE utf8_bin NOT NULL,
  `second_pass_match` mediumtext COLLATE utf8_bin NOT NULL,
  `second_pass_replace` mediumtext COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`bbcode_id`),
  KEY `display_on_post` (`display_on_posting`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `torrent_bbcodes`
--

INSERT INTO `torrent_bbcodes` (`bbcode_id`, `bbcode_tag`, `bbcode_helpline`, `display_on_posting`, `bbcode_match`, `bbcode_tpl`, `first_pass_match`, `first_pass_replace`, `second_pass_match`, `second_pass_replace`) VALUES
(13, 'highlight=', 'highlight', 1, '[highlight={COLOR}]{TEXT}[/highlight]', '<span style="background-color: {COLOR};">{TEXT}</span>', '!\\[highlight\\=([a-z]+|#[0-9abcdef]+)\\](.*?)\\[/highlight\\]!ies', '''[highlight=${1}:$uid]''.str_replace(array("\\r\\n", ''\\"'', ''\\'''', ''('', '')''), array("\\n", ''"'', ''&#39;'', ''&#40;'', ''&#41;''), trim(''${2}'')).''[/highlight:$uid]''', '!\\[highlight\\=([a-zA-Z]+|#[0-9abcdefABCDEF]+):$uid\\](.*?)\\[/highlight:$uid\\]!s', '<span style="background-color: ${1};">${2}</span>'),
(14, 'imageshackvid', 'ImageShage Video', 1, '[imageshackvid]{TEXT}[/imageshackvid]', '<embed src="{TEXT}" width="176" height="152" allowFullScreen="true" type="application/x-shockwave-flash"/>', '!\\[imageshackvid\\](.*?)\\[/imageshackvid\\]!ies', '''[imageshackvid]''.str_replace(array("\\r\\n", ''\\"'', ''\\'''', ''('', '')''), array("\\n", ''"'', ''&#39;'', ''&#40;'', ''&#41;''), trim(''$1'')).''[/imageshackvid]''', '!\\[imageshackvid\\](.*?)\\[/imageshackvid\\]!s', '<embed src="$1" width="176" height="152" allowFullScreen="true" type="application/x-shockwave-flash"/>');

-- --------------------------------------------------------

--
-- Table structure for table `torrent_bonus`
--

CREATE TABLE IF NOT EXISTS `torrent_bonus` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `bonusname` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `points` decimal(4,1) NOT NULL DEFAULT '0.0',
  `description` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `art` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'traffic',
  `menge` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=10 ;

--
-- Dumping data for table `torrent_bonus`
--

INSERT INTO `torrent_bonus` (`id`, `bonusname`, `points`, `description`, `art`, `menge`) VALUES
(1, '1.0GB Uploaded', '75.0', 'If you reach the points for this case, you can exchange these points on the fly into traffic, we take off the points and you receive the traffic.', 'traffic', 1073741824),
(2, '2.5GB Uploaded', '150.0', 'If you reach the points for this case, you can exchange these points on the fly into traffic, we take off the points and you receive the traffic.', 'traffic', 2684354560),
(3, '5GB Uploaded', '250.0', 'If you reach the points for this case, you can exchange these points on the fly into traffic, we take off the points and you receive the traffic.', 'traffic', 5368709120),
(7, '3 Invites', '20.0', 'Trade your points in for invites to the site.', 'invite', 3),
(6, '1 Invite', '10.0', 'Trade your points in for invites to the site.', 'invite', 1),
(8, '10 Invites', '50.0', 'Trade your points in for invites to the site.', 'invite', 10),
(9, '15 Invites', '75.0', 'Trade your points in for invites to the site.', 'invite', 15),
(4, '10GB Uploaded', '400.0', 'If you reach the points for this case, you can exchange these points on the fly into traffic, we take off the points and you receive the traffic.', 'traffic', 10737418240),
(5, '25GB Uploaded', '999.9', 'If you reach the points for this case, you can exchange these points on the fly into traffic, we take off the points and you receive the traffic.', 'traffic', 26843545600);

-- --------------------------------------------------------

--
-- Table structure for table `torrent_bonus_points`
--

CREATE TABLE IF NOT EXISTS `torrent_bonus_points` (
  `active` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `upload` decimal(10,2) NOT NULL DEFAULT '0.00',
  `comment` decimal(10,2) NOT NULL DEFAULT '0.00',
  `offer` decimal(10,2) NOT NULL DEFAULT '0.00',
  `fill_request` decimal(10,2) NOT NULL DEFAULT '0.00',
  `seeding` decimal(10,2) NOT NULL DEFAULT '0.00',
  `by_torrent` int(10) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `torrent_bonus_points`
--

INSERT INTO `torrent_bonus_points` (`active`, `upload`, `comment`, `offer`, `fill_request`, `seeding`, `by_torrent`) VALUES
('true', '50.00', '10.00', '20.00', '30.00', '0.70', 0);

-- --------------------------------------------------------

--
-- Table structure for table `torrent_bookmarks`
--

CREATE TABLE IF NOT EXISTS `torrent_bookmarks` (
  `topic_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `torrent_cache_con`
--

CREATE TABLE IF NOT EXISTS `torrent_cache_con` (
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `torrent_cache_con`
--

INSERT INTO `torrent_cache_con` (`name`, `value`) VALUES
('sql_time', '200'),
('theme_time', '30'),
('cache_dir', '/home/btmaehfh/public_html/demo/cache');

-- --------------------------------------------------------

--
-- Table structure for table `torrent_categories`
--

CREATE TABLE IF NOT EXISTS `torrent_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_bin NOT NULL DEFAULT '',
  `sort_index` int(10) unsigned NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `parent_id` mediumint(5) NOT NULL DEFAULT '-1',
  `tabletype` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `subcount` varchar(225) COLLATE utf8_bin NOT NULL,
  `offensive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `sort_index` (`sort_index`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=37 ;

--
-- Dumping data for table `torrent_categories`
--

INSERT INTO `torrent_categories` (`id`, `name`, `sort_index`, `image`, `parent_id`, `tabletype`, `subcount`, `offensive`) VALUES
(1, 'Movies', 10, 'movies.png', -1, 1, '4', 0),
(12, 'DVDR Movies', 90, 'dvd.png', 1, 1, '4', 0),
(18, 'XVID', 100, 'xvid.jpg', 1, 1, '4', 0),
(22, 'Blueray', 110, 'blu-ray.jpg', 1, 1, '4', 0),
(24, 'Packs', 120, 'dvd-packs.jpg', 1, 1, '4', 0),
(6, 'TV', 20, 'tv.png', -1, 6, '4', 0),
(27, 'Episodes', 250, 'tv-episodes.jpg', 6, 1, '4', 0),
(32, 'TV-Packs', 260, 'tv-packs.jpg', 6, 1, '4', 0),
(9, 'HD-TV', 270, 'tv1.gif', 6, 1, '4', 0),
(10, 'Kids-TV', 240, 'kids.jpg', 6, 1, '4', 0),
(11, 'Sport-TV', 280, 'sports.jpg', 6, 1, '5', 0),
(2, 'PC Games', 30, 'pc1.gif', -1, 2, '5', 0),
(13, 'X360', 130, 'xbox.jpg', 2, 1, '5', 0),
(14, 'PSP-Games', 140, 'psp.gif', 2, 1, '5', 0),
(15, 'PS-2', 150, 'ps2.gif', 2, 1, '5', 0),
(16, 'PC-Games', 160, 'pc-games.jpg', 2, 1, '5', 0),
(17, 'NDS-Games', 170, 'Nintendo.gif', 2, 1, '5', 0),
(7, 'Music', 40, 'music.png', -1, 7, '3', 0),
(19, 'Flac', 300, 'flac.jpg', 7, 1, '3', 0),
(20, 'MP3', 310, 'mp3.jpg', 7, 1, '3', 0),
(21, 'Music-Vid', 320, 'music-video.jpg', 7, 1, '3', 0),
(3, 'Anime', 50, 'anime.png', -1, 3, '1', 0),
(4, 'Books', 60, 'books1.gif', -1, 4, '2', 0),
(25, 'E-book', 190, 'ebooks.jpg', 4, 1, '2', 0),
(26, 'Audio-Books', 200, 'audiobooks.jpg', 4, 1, '2', 0),
(5, 'APPS', 70, 'apps.png', -1, 5, '4', 0),
(28, 'Windows-Apps', 210, 'apps.jpg', 5, 1, '4', 0),
(30, 'Linux-Apps', 220, 'unix.jpg', 5, 1, '4', 0),
(31, 'Mac-Apps', 230, 'mac.jpg', 5, 1, '4', 0),
(8, 'Porn', 80, 'xxx.jpg', -1, 8, '2', 0),
(33, 'Porn-Packs', 330, 'xxx-packs.jpg', 8, 1, '2', 0),
(34, 'General-Porn', 340, 'xxx.jpg', 8, 1, '2', 0),
(35, 'Adult-Anime', 180, 'Anime.gif', 3, 1, '1', 0),
(36, 'HD-Sports', 290, 'hd1.gif', 6, 1, '0', 0);

-- --------------------------------------------------------

--
-- Table structure for table `torrent_client_ban`
--

CREATE TABLE IF NOT EXISTS `torrent_client_ban` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `client` varchar(60) COLLATE utf8_bin NOT NULL,
  `reason` varchar(255) COLLATE utf8_bin NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `client` (`client`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `torrent_comments`
--

CREATE TABLE IF NOT EXISTS `torrent_comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL DEFAULT '0',
  `torrent` int(10) unsigned NOT NULL DEFAULT '0',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `text` text COLLATE utf8_bin NOT NULL,
  `ori_text` text COLLATE utf8_bin,
  `news` int(10) NOT NULL DEFAULT '0',
  `nzb` int(10) NOT NULL DEFAULT '0',
  `offer` int(11) NOT NULL DEFAULT '0',
  `reqid` int(11) NOT NULL DEFAULT '0',
  `editedat` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `editedby` int(10) unsigned NOT NULL DEFAULT '0',
  `bbcode_bitfield` varchar(225) COLLATE utf8_bin NOT NULL DEFAULT '',
  `bbcode_uid` varchar(8) COLLATE utf8_bin NOT NULL DEFAULT '',
  `ori_bbcode_bitfield` varchar(225) COLLATE utf8_bin NOT NULL DEFAULT '',
  `ori_bbcode_uid` varchar(8) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `torrent` (`torrent`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=18 ;

--
-- Dumping data for table `torrent_comments`
--


-- --------------------------------------------------------

--
-- Table structure for table `torrent_comments_notify`
--

CREATE TABLE IF NOT EXISTS `torrent_comments_notify` (
  `torrent` int(11) NOT NULL DEFAULT '0',
  `user` int(11) NOT NULL DEFAULT '0',
  `status` enum('active','stopped') COLLATE utf8_bin NOT NULL DEFAULT 'active',
  PRIMARY KEY (`torrent`,`user`),
  KEY `torrent` (`torrent`,`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `torrent_comments_notify`
--


-- --------------------------------------------------------

--
-- Table structure for table `torrent_complaints`
--

CREATE TABLE IF NOT EXISTS `torrent_complaints` (
  `torrent` int(15) unsigned NOT NULL DEFAULT '0',
  `user` int(11) unsigned NOT NULL DEFAULT '0',
  `host` varchar(60) COLLATE utf8_bin NOT NULL DEFAULT '',
  `datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `score` smallint(1) unsigned zerofill NOT NULL DEFAULT '0',
  PRIMARY KEY (`torrent`,`user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `torrent_config`
--

CREATE TABLE IF NOT EXISTS `torrent_config` (
  `sitename` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `siteurl` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `cookiedomain` varchar(225) COLLATE utf8_bin NOT NULL,
  `cookiepath` varchar(60) COLLATE utf8_bin NOT NULL DEFAULT '',
  `sourcedir` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `admin_email` varchar(60) COLLATE utf8_bin NOT NULL,
  `on_line` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'true',
  `off_line_mess` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `start_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `time_zone` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT 'America/Los_Angeles',
  `language` varchar(15) COLLATE utf8_bin NOT NULL DEFAULT '',
  `theme` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `force_passkey` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `welcome_message` longtext COLLATE utf8_bin,
  `announce_ments` longtext COLLATE utf8_bin,
  `announce_text` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `allow_html` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'true',
  `rewrite_engine` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'true',
  `torrent_prefix` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `torrent_per_page` int(10) unsigned NOT NULL DEFAULT '10',
  `onlysearch` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'true',
  `max_torrent_size` int(11) unsigned NOT NULL DEFAULT '0',
  `announce_interval_min` int(10) unsigned NOT NULL DEFAULT '0',
  `announce_interval` int(10) unsigned NOT NULL DEFAULT '0',
  `dead_torrent_interval` int(10) unsigned NOT NULL DEFAULT '0',
  `minvotes` smallint(5) unsigned NOT NULL DEFAULT '0',
  `time_tracker_update` int(10) unsigned NOT NULL DEFAULT '0',
  `best_limit` smallint(5) unsigned NOT NULL DEFAULT '0',
  `down_limit` smallint(5) unsigned NOT NULL DEFAULT '0',
  `torrent_complaints` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `torrent_global_privacy` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'true',
  `disclaimer_check` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `gfx_check` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'true',
  `Public_Key` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `Private_Key` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `recap_https` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `upload_level` enum('all','user','premium') COLLATE utf8_bin NOT NULL DEFAULT 'user',
  `download_level` enum('all','user','premium') COLLATE utf8_bin NOT NULL DEFAULT 'all',
  `announce_level` enum('all','user') COLLATE utf8_bin NOT NULL DEFAULT 'all',
  `max_num_file` smallint(5) unsigned NOT NULL DEFAULT '0',
  `max_share_size` bigint(8) unsigned NOT NULL DEFAULT '0',
  `min_size_seed` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `min_share_seed` bigint(8) unsigned NOT NULL DEFAULT '0',
  `global_min_ratio` float unsigned NOT NULL DEFAULT '0',
  `autoscrape` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'true',
  `min_num_seed_e` smallint(5) unsigned NOT NULL DEFAULT '0',
  `min_size_seed_e` bigint(8) unsigned NOT NULL DEFAULT '0',
  `minupload_size_file` int(10) unsigned NOT NULL DEFAULT '0',
  `allow_backup_tracker` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `stealthmode` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'true',
  `version` varchar(5) COLLATE utf8_bin NOT NULL DEFAULT '',
  `upload_dead` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `invites_open` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `invite_only` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `max_members` int(10) unsigned NOT NULL DEFAULT '0',
  `auto_clean` int(10) unsigned NOT NULL DEFAULT '0',
  `free_dl` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `GIGSA` int(10) NOT NULL DEFAULT '0',
  `RATIOA` decimal(10,2) NOT NULL DEFAULT '0.00',
  `WAITA` int(10) NOT NULL DEFAULT '0',
  `GIGSB` int(10) NOT NULL DEFAULT '0',
  `RATIOB` decimal(10,2) NOT NULL DEFAULT '0.00',
  `WAITB` int(10) NOT NULL DEFAULT '0',
  `GIGSC` int(10) NOT NULL DEFAULT '0',
  `RATIOC` decimal(10,2) NOT NULL DEFAULT '0.00',
  `WAITC` int(10) NOT NULL DEFAULT '0',
  `GIGSD` int(10) NOT NULL DEFAULT '0',
  `RATIOD` decimal(10,2) NOT NULL DEFAULT '0.00',
  `WAITD` int(10) NOT NULL DEFAULT '0',
  `wait_time` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `addprivate` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `allow_external` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `allow_multy_tracker` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `give_sign_up_credit` bigint(20) NOT NULL DEFAULT '0',
  `search_cloud_block` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'true',
  `pivate_mode` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `conferm_email` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'true',
  `allow_change_email` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'true',
  `autodel_users` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `inactwarning_time` int(10) NOT NULL DEFAULT '0',
  `autodel_users_time` int(10) NOT NULL DEFAULT '0',
  `most_on_line` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `when_most` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `torrent_config`
--

INSERT INTO `torrent_config` (`sitename`, `siteurl`, `cookiedomain`, `cookiepath`, `sourcedir`, `admin_email`, `on_line`, `off_line_mess`, `start_date`, `time_zone`, `language`, `theme`, `force_passkey`, `welcome_message`, `announce_ments`, `announce_text`, `allow_html`, `rewrite_engine`, `torrent_prefix`, `torrent_per_page`, `onlysearch`, `max_torrent_size`, `announce_interval_min`, `announce_interval`, `dead_torrent_interval`, `minvotes`, `time_tracker_update`, `best_limit`, `down_limit`, `torrent_complaints`, `torrent_global_privacy`, `disclaimer_check`, `gfx_check`, `Public_Key`, `Private_Key`, `recap_https`, `upload_level`, `download_level`, `announce_level`, `max_num_file`, `max_share_size`, `min_size_seed`, `min_share_seed`, `global_min_ratio`, `autoscrape`, `min_num_seed_e`, `min_size_seed_e`, `minupload_size_file`, `allow_backup_tracker`, `stealthmode`, `version`, `upload_dead`, `invites_open`, `invite_only`, `max_members`, `auto_clean`, `free_dl`, `GIGSA`, `RATIOA`, `WAITA`, `GIGSB`, `RATIOB`, `WAITB`, `GIGSC`, `RATIOC`, `WAITC`, `GIGSD`, `RATIOD`, `WAITD`, `wait_time`, `addprivate`, `allow_external`, `allow_multy_tracker`, `give_sign_up_credit`, `search_cloud_block`, `pivate_mode`, `conferm_email`, `allow_change_email`, `autodel_users`, `inactwarning_time`, `autodel_users_time`, `most_on_line`, `when_most`) VALUES
('BTManager', 'http://demo.btmanager.org', 'demo.btmanager.org', '', '/home/btmaehfh/public_html/demo/', 'webmaster@demo.btmanager.org', 'true', 'test', '2014-12-28 14:56:06', 'America/New_York', 'english', 'Bitfarm', 'true', '', NULL, '', 'true', 'false', '', 10, 'false', 5000000, 2995, 3000, 1500, 0, 3600, 0, 0, 'true', 'true', 'true', 'true', '', '', 'false', 'user', 'user', 'all', 0, 0, 0, 0, 0, 'true', 0, 0, 0, 'true', 'false', '3.0.0', 'false', 'true', 'false', 50000, 600, 'false', 0, '0.00', 0, 0, '0.00', 0, 0, '0.00', 0, 0, '0.00', 0, 'false', 'false', 'false', 'false', 0, 'true', 'true', 'true', 'false', 'false', 0, 0, '3', '2014-12-30 14:38:40');

-- --------------------------------------------------------

--
-- Table structure for table `torrent_countries`
--

CREATE TABLE IF NOT EXISTS `torrent_countries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `flagpic` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `domain` char(3) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=101 ;

--
-- Dumping data for table `torrent_countries`
--

INSERT INTO `torrent_countries` (`id`, `name`, `flagpic`, `domain`) VALUES
(1, 'Sweden', 'sweden.gif', 'SE'),
(2, 'United States of America', 'usa.gif', 'US'),
(3, 'Russia', 'russia.gif', 'RU'),
(4, 'Finland', 'finland.gif', 'FI'),
(5, 'Canada', 'canada.gif', 'CA'),
(6, 'France', 'france.gif', 'FR'),
(7, 'Germany', 'germany.gif', 'DE'),
(8, 'China', 'china.gif', 'CN'),
(9, 'Italy', 'italy.gif', 'IT'),
(10, 'Denmark', 'denmark.gif', 'DK'),
(11, 'Norway', 'norway.gif', 'NO'),
(12, 'United Kingdom', 'uk.gif', 'UK'),
(13, 'Ireland', 'ireland.gif', 'IE'),
(14, 'Poland', 'poland.gif', 'PL'),
(15, 'Netherlands', 'netherlands.gif', 'NL'),
(16, 'Belgium', 'belgium.gif', 'BE'),
(17, 'Japan', 'japan.gif', 'JP'),
(18, 'Brazil', 'brazil.gif', 'BR'),
(19, 'Argentina', 'argentina.gif', 'AR'),
(20, 'Australia', 'australia.gif', 'AU'),
(21, 'New Zealand', 'newzealand.gif', 'NZ'),
(23, 'Spain', 'spain.gif', 'ES'),
(24, 'Portugal', 'portugal.gif', 'PT'),
(25, 'Mexico', 'mexico.gif', 'MX'),
(26, 'Singapore', 'singapore.gif', 'SG'),
(29, 'South Africa', 'southafrica.gif', 'ZA'),
(30, 'South Korea', 'southkorea.gif', 'KR'),
(31, 'Jamaica', 'jamaica.gif', 'JM'),
(32, 'Luxembourg', 'luxembourg.gif', 'LU'),
(33, 'Hong Kong', 'hongkong.gif', 'HK'),
(34, 'Belize', 'belize.gif', 'BZ'),
(35, 'Algeria', 'algeria.gif', 'DZ'),
(36, 'Angola', 'angola.gif', 'AO'),
(37, 'Austria', 'austria.gif', 'AT'),
(38, 'Yugoslavia', 'yugoslavia.gif', 'YU'),
(39, 'Western Samoa', 'westernsamoa.gif', 'WS'),
(40, 'Malaysia', 'malaysia.gif', 'MY'),
(41, 'Dominican Republic', 'dominicanrep.gif', 'DO'),
(42, 'Greece', 'greece.gif', 'GR'),
(43, 'Guatemala', 'guatemala.gif', 'GT'),
(44, 'Israel', 'israel.gif', 'IL'),
(45, 'Pakistan', 'pakistan.gif', 'PK'),
(46, 'Czech Republic', 'czechrep.gif', 'CZ'),
(47, 'Serbia', 'serbia.gif', 'YU'),
(48, 'Seychelles', 'seychelles.gif', 'SC'),
(49, 'Taiwan', 'taiwan.gif', 'TW'),
(50, 'Puerto Rico', 'puertorico.gif', 'PR'),
(51, 'Chile', 'chile.gif', 'CL'),
(52, 'Cuba', 'cuba.gif', 'CU'),
(53, 'Congo', 'congo.gif', 'CG'),
(54, 'Afghanistan', 'afghanistan.gif', 'AF'),
(55, 'Turkey', 'turkey.gif', 'TR'),
(56, 'Uzbekistan', 'uzbekistan.gif', 'UZ'),
(57, 'Switzerland', 'switzerland.gif', 'CH'),
(58, 'Kiribati', 'kiribati.gif', 'KI'),
(59, 'Philippines', 'philippines.gif', 'PH'),
(60, 'Burkina Faso', 'burkinafaso.gif', 'BF'),
(61, 'Nigeria', 'nigeria.gif', 'NG'),
(62, 'Iceland', 'iceland.gif', 'IS'),
(63, 'Nauru', 'nauru.gif', 'NR'),
(64, 'Slovenia', 'slovenia.gif', 'SI'),
(65, 'Albania', 'albania.gif', 'AL'),
(66, 'Turkmenistan', 'turkmenistan.gif', 'TM'),
(67, 'Bosnia Herzegovina', 'bosniaherzegovina.gif', 'BA'),
(68, 'Andorra', 'andorra.gif', 'AD'),
(69, 'Lithuania', 'lithuania.gif', 'LT'),
(70, 'India', 'india.gif', 'IN'),
(71, 'Netherlands Antilles', 'nethantilles.gif', 'AN'),
(72, 'Ukraine', 'ukraine.gif', 'UA'),
(73, 'Venezuela', 'venezuela.gif', 'VE'),
(74, 'Hungary', 'hungary.gif', 'HU'),
(75, 'Romania', 'romania.gif', 'RO'),
(76, 'Vanuatu', 'vanuatu.gif', 'VU'),
(77, 'Vietnam', 'vietnam.gif', 'VN'),
(78, 'Trinidad & Tobago', 'trinidadandtobago.gif', 'TT'),
(79, 'Honduras', 'honduras.gif', 'HN'),
(80, 'Kyrgyzstan', 'kyrgyzstan.gif', 'KG'),
(81, 'Ecuador', 'ecuador.gif', 'EC'),
(82, 'Bahamas', 'bahamas.gif', 'BS'),
(83, 'Peru', 'peru.gif', 'PE'),
(84, 'Cambodia', 'cambodia.gif', 'KH'),
(85, 'Barbados', 'barbados.gif', 'BB'),
(86, 'Bangladesh', 'bangladesh.gif', 'BD'),
(87, 'Laos', 'laos.gif', 'LA'),
(88, 'Uruguay', 'uruguay.gif', 'UY'),
(89, 'Antigua Barbuda', 'antiguabarbuda.gif', 'AG'),
(90, 'Paraguay', 'paraguay.gif', 'PY'),
(92, 'Union of Soviet Socialist Republics', 'ussr.gif', 'SU'),
(93, 'Thailand', 'thailand.gif', 'TH'),
(94, 'Senegal', 'senegal.gif', 'SN'),
(95, 'Togo', 'togo.gif', 'TG'),
(96, 'North Korea', 'northkorea.gif', 'KP'),
(97, 'Croatia', 'croatia.gif', 'HR'),
(98, 'Estonia', 'estonia.gif', 'EE'),
(99, 'Colombia', 'colombia.gif', 'CO'),
(0, 'Unknown', 'unknown.gif', 'N/A');

-- --------------------------------------------------------

--
-- Table structure for table `torrent_download_completed`
--

CREATE TABLE IF NOT EXISTS `torrent_download_completed` (
  `user` int(11) unsigned NOT NULL DEFAULT '0',
  `torrent` int(15) unsigned NOT NULL DEFAULT '0',
  `completed` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`user`,`torrent`),
  KEY `torrent` (`torrent`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `torrent_download_completed`
--


-- --------------------------------------------------------

--
-- Table structure for table `torrent_drafts`
--

CREATE TABLE IF NOT EXISTS `torrent_drafts` (
  `draft_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `user_id` int(20) NOT NULL,
  `topic_id` mediumint(8) NOT NULL,
  `forum_id` mediumint(8) NOT NULL,
  `save_time` int(11) NOT NULL,
  `draft_subject` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `draft_message` mediumtext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `draft_type` enum('forum','pm','topic','coment') NOT NULL DEFAULT 'forum',
  `torrent` mediumint(8) DEFAULT NULL,
  `user_to` mediumint(8) NOT NULL,
  PRIMARY KEY (`draft_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `torrent_extensions`
--

CREATE TABLE IF NOT EXISTS `torrent_extensions` (
  `extension_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `extension` varchar(100) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`extension_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=68 ;

--
-- Dumping data for table `torrent_extensions`
--

INSERT INTO `torrent_extensions` (`extension_id`, `group_id`, `extension`) VALUES
(1, 1, 'gif'),
(2, 1, 'png'),
(3, 1, 'jpeg'),
(4, 1, 'jpg'),
(5, 1, 'tif'),
(6, 1, 'tiff'),
(7, 1, 'tga'),
(8, 2, 'gtar'),
(9, 2, 'gz'),
(10, 2, 'tar'),
(11, 2, 'zip'),
(12, 2, 'rar'),
(13, 2, 'ace'),
(14, 2, 'torrent'),
(15, 2, 'tgz'),
(16, 2, 'bz2'),
(17, 2, '7z'),
(18, 3, 'txt'),
(19, 3, 'c'),
(20, 3, 'h'),
(21, 3, 'cpp'),
(22, 3, 'hpp'),
(23, 3, 'diz'),
(24, 3, 'csv'),
(25, 3, 'ini'),
(26, 3, 'log'),
(27, 3, 'js'),
(28, 3, 'xml'),
(29, 4, 'xls'),
(30, 4, 'xlsx'),
(31, 4, 'xlsm'),
(32, 4, 'xlsb'),
(33, 4, 'doc'),
(34, 4, 'docx'),
(35, 4, 'docm'),
(36, 4, 'dot'),
(37, 4, 'dotx'),
(38, 4, 'dotm'),
(39, 4, 'pdf'),
(40, 4, 'ai'),
(41, 4, 'ps'),
(42, 4, 'ppt'),
(43, 4, 'pptx'),
(44, 4, 'pptm'),
(45, 4, 'odg'),
(46, 4, 'odp'),
(47, 4, 'ods'),
(48, 4, 'odt'),
(49, 4, 'rtf'),
(50, 5, 'rm'),
(51, 5, 'ram'),
(52, 6, 'wma'),
(53, 6, 'wmv'),
(54, 7, 'swf'),
(55, 8, 'mov'),
(56, 8, 'm4v'),
(57, 8, 'm4a'),
(58, 8, 'mp4'),
(59, 8, '3gp'),
(60, 8, '3g2'),
(61, 8, 'qt'),
(62, 9, 'mpeg'),
(63, 9, 'mpg'),
(64, 9, 'mp3'),
(65, 9, 'ogg'),
(66, 9, 'ogm'),
(67, 9, 'php');

-- --------------------------------------------------------

--
-- Table structure for table `torrent_extension_groups`
--

CREATE TABLE IF NOT EXISTS `torrent_extension_groups` (
  `group_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `cat_id` tinyint(2) NOT NULL DEFAULT '0',
  `allow_group` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `download_mode` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `upload_icon` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `max_filesize` int(20) unsigned NOT NULL DEFAULT '0',
  `allowed_forums` text COLLATE utf8_bin NOT NULL,
  `allow_in_pm` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=10 ;

--
-- Dumping data for table `torrent_extension_groups`
--

INSERT INTO `torrent_extension_groups` (`group_id`, `group_name`, `cat_id`, `allow_group`, `download_mode`, `upload_icon`, `max_filesize`, `allowed_forums`, `allow_in_pm`) VALUES
(1, 'EXT_GROUP_IMAGES', 0, 1, 1, '', 0, '', 1),
(2, 'EXT_GROUP_ARCHIVES', 0, 0, 1, '', 0, '', 1),
(3, 'EXT_GROUP_PLAIN_TEXT', 0, 1, 1, '', 0, '', 1),
(4, 'EXT_GROUP_DOCUMENTS', 1, 1, 1, '', 0, '', 1),
(5, 'EXT_GROUP_REAL_MEDIA', 3, 0, 1, '', 0, '', 1),
(6, 'EXT_GROUP_WINDOWS_MEDIA', 2, 0, 1, '', 0, '', 1),
(7, 'EXT_GROUP_FLASH_FILES', 5, 0, 1, '', 0, '', 0),
(8, 'EXT_GROUP_QUICKTIME_MEDIA', 6, 0, 1, '', 0, '', 0),
(9, 'EXT_GROUP_DOWNLOADABLE_FILES', 0, 0, 1, '', 0, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `torrent_faq`
--

CREATE TABLE IF NOT EXISTS `torrent_faq` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` set('categ','item') COLLATE utf8_bin NOT NULL DEFAULT 'item',
  `question` text COLLATE utf8_bin NOT NULL,
  `answer` text COLLATE utf8_bin NOT NULL,
  `flag` set('0','1','2','3') COLLATE utf8_bin NOT NULL DEFAULT '1',
  `categ` int(10) NOT NULL DEFAULT '0',
  `order` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `torrent_files`
--

CREATE TABLE IF NOT EXISTS `torrent_files` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `torrent` int(15) unsigned NOT NULL DEFAULT '0',
  `filename` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `size` bigint(20) unsigned NOT NULL DEFAULT '0',
  `md5sum` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `ed2k` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `magnet` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `torrent_2` (`torrent`,`filename`),
  KEY `torrent` (`torrent`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=94 ;

--
-- Dumping data for table `torrent_files`
--


-- --------------------------------------------------------

--
-- Table structure for table `torrent_filter`
--

CREATE TABLE IF NOT EXISTS `torrent_filter` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `keyword` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '',
  `reason` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `keyword` (`keyword`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `torrent_forums`
--

CREATE TABLE IF NOT EXISTS `torrent_forums` (
  `forum_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `left_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `right_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `forum_parents` mediumtext COLLATE utf8_bin NOT NULL,
  `forum_name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `forum_desc` text COLLATE utf8_bin NOT NULL,
  `forum_desc_bitfield` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `forum_desc_options` int(11) unsigned NOT NULL DEFAULT '7',
  `forum_desc_uid` varchar(8) COLLATE utf8_bin NOT NULL DEFAULT '',
  `forum_link` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `forum_password` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '',
  `forum_style` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `forum_image` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `forum_rules` text COLLATE utf8_bin NOT NULL,
  `forum_rules_link` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `forum_rules_bitfield` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `forum_rules_options` int(11) unsigned NOT NULL DEFAULT '7',
  `forum_rules_uid` varchar(8) COLLATE utf8_bin NOT NULL DEFAULT '',
  `forum_topics_per_page` tinyint(4) NOT NULL DEFAULT '0',
  `forum_type` tinyint(4) NOT NULL DEFAULT '0',
  `forum_status` tinyint(4) NOT NULL DEFAULT '0',
  `forum_posts` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `forum_topics` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `forum_topics_real` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `forum_last_post_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `forum_last_poster_id` int(20) unsigned NOT NULL DEFAULT '0',
  `forum_last_post_subject` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `forum_last_post_time` int(11) unsigned NOT NULL DEFAULT '0',
  `forum_last_poster_name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `forum_last_poster_colour` varchar(6) COLLATE utf8_bin NOT NULL DEFAULT '',
  `forum_flags` tinyint(4) NOT NULL DEFAULT '32',
  `forum_options` int(20) unsigned NOT NULL DEFAULT '0',
  `display_subforum_list` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `display_on_index` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `enable_indexing` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `enable_icons` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `enable_prune` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `prune_next` int(11) unsigned NOT NULL DEFAULT '0',
  `prune_days` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `prune_viewed` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `prune_freq` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `acl_read` varchar(225) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `acl_write` varchar(225) COLLATE utf8_bin NOT NULL DEFAULT '0',
  PRIMARY KEY (`forum_id`),
  KEY `left_right_id` (`left_id`,`right_id`),
  KEY `forum_lastpost_id` (`forum_last_post_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin ;

--
-- Dumping data for table `torrent_forums`
--


-- --------------------------------------------------------

--
-- Table structure for table `torrent_forums_access`
--

CREATE TABLE IF NOT EXISTS `torrent_forums_access` (
  `forum_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `user_id` int(20) unsigned NOT NULL DEFAULT '0',
  `session_id` char(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`forum_id`,`user_id`,`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `torrent_forums_track`
--

CREATE TABLE IF NOT EXISTS `torrent_forums_track` (
  `user_id` int(20) unsigned NOT NULL DEFAULT '0',
  `forum_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `mark_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`forum_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `torrent_forums_track`
--


-- --------------------------------------------------------

--
-- Table structure for table `torrent_forums_watch`
--

CREATE TABLE IF NOT EXISTS `torrent_forums_watch` (
  `forum_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `user_id` int(20) unsigned NOT NULL DEFAULT '0',
  `notify_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  KEY `forum_id` (`forum_id`),
  KEY `user_id` (`user_id`),
  KEY `notify_stat` (`notify_status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `torrent_forum_config`
--

CREATE TABLE IF NOT EXISTS `torrent_forum_config` (
  `forum_open` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `board_disable_msg` text COLLATE utf8_bin NOT NULL,
  `postsper_page` int(10) NOT NULL,
  `topics_per_page` int(10) NOT NULL,
  `max_post_length` int(10) NOT NULL,
  `show_latest_topic` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `search_word_min` int(10) NOT NULL,
  `allow_bookmarks` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `shout_new_topic` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `shout_new_post` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `allow_smilies` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `allow_bbcode` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `allow_signatures` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `flood_intervals` int(10) NOT NULL DEFAULT '0',
  `bump_intervals` int(10) NOT NULL DEFAULT '0',
  `set_flood_intervals` enum('s','m') COLLATE utf8_bin NOT NULL DEFAULT 's',
  `bump_type` enum('m','h','d') COLLATE utf8_bin NOT NULL DEFAULT 'm',
  `email_enable` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `jab_enable` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `allow_topic_notify` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `allow_forum_notify` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `load_search` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `allow_attachments` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `allow_post_links` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `board_hide_emails` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `allow_birthdays` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `display_last_edited` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `load_moderators` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `edit_time` int(10) DEFAULT NULL,
  `allow_post_flash` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `enable_post_confirm` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `enable_queue_trigger` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `allow_sig_bbcode` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `allow_sig_smilies` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `max_post_font_size` int(10) DEFAULT NULL,
  `max_poll_options` int(10) NOT NULL DEFAULT '9',
  `max_post_urls` int(10) NOT NULL DEFAULT '0',
  `max_post_smilies` int(11) DEFAULT NULL,
  `max_quote_depth` int(10) NOT NULL DEFAULT '0',
  `img_link_width` int(10) NOT NULL DEFAULT '0',
  `img_link_height` int(10) NOT NULL DEFAULT '0',
  `max_filesize` int(10) NOT NULL DEFAULT '0',
  `hot_threshold` int(10) NOT NULL DEFAULT '0',
  `min_post_chars` int(10) NOT NULL DEFAULT '0',
  `max_attachments` int(10) NOT NULL DEFAULT '0',
  `enable_urls` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `queue_trigger_posts` int(10) NOT NULL DEFAULT '0',
  `img_display_inlined` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `torrent_forum_config`
--

INSERT INTO `torrent_forum_config` (`forum_open`, `board_disable_msg`, `postsper_page`, `topics_per_page`, `max_post_length`, `show_latest_topic`, `search_word_min`, `allow_bookmarks`, `shout_new_topic`, `shout_new_post`, `allow_smilies`, `allow_bbcode`, `allow_signatures`, `flood_intervals`, `bump_intervals`, `set_flood_intervals`, `bump_type`, `email_enable`, `jab_enable`, `allow_topic_notify`, `allow_forum_notify`, `load_search`, `allow_attachments`, `allow_post_links`, `board_hide_emails`, `allow_birthdays`, `display_last_edited`, `load_moderators`, `edit_time`, `allow_post_flash`, `enable_post_confirm`, `enable_queue_trigger`, `allow_sig_bbcode`, `allow_sig_smilies`, `max_post_font_size`, `max_poll_options`, `max_post_urls`, `max_post_smilies`, `max_quote_depth`, `img_link_width`, `img_link_height`, `max_filesize`, `hot_threshold`, `min_post_chars`, `max_attachments`, `enable_urls`, `queue_trigger_posts`, `img_display_inlined`) VALUES
('true', 'true', 15, 15, 50000, 'true', 0, 'true', 'true', 'true', 'true', 'true', 'true', 2, 2, 'm', 'm', 'true', 'false', 'false', 'false', 'true', 'true', 'false', 'false', 'true', 'true', 'false', 60, 'false', 'false', 'true', 'false', 'false', 7, 9, 1, 10, 5, 200, 200, 1000, 10, 5, 1, 'true', 5, 'true');

-- --------------------------------------------------------

--
-- Table structure for table `torrent_forum_permissions`
--

CREATE TABLE IF NOT EXISTS `torrent_forum_permissions` (
  `forum_id` mediumint(8) NOT NULL DEFAULT '0',
  `g_moderators` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `g_can_read` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `g_can_write` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `group_only` tinyint(1) NOT NULL DEFAULT '0',
  `group_allow` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `u_moderators` varchar(225) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `u_can_read` varchar(225) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `u_can_write` varchar(225) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `torrent_hit_n_run`
--

CREATE TABLE IF NOT EXISTS `torrent_hit_n_run` (
  `hnr_system` enum('true','false') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `demote_hnr_users` enum('true','false') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `ban_hnr_users` enum('true','false') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `demote_time` int(10) NOT NULL DEFAULT '0',
  `after_high_hnr` int(10) NOT NULL DEFAULT '0',
  `ban_time` int(10) NOT NULL DEFAULT '0',
  `seedtime` int(10) NOT NULL DEFAULT '0',
  `time_before_warn` int(10) NOT NULL DEFAULT '0',
  `maxhitrun` int(10) NOT NULL DEFAULT '0',
  `warnlength` int(10) NOT NULL DEFAULT '0',
  `demote_hnr_users_to` varchar(225) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Config for Hit and Run system';

--
-- Dumping data for table `torrent_hit_n_run`
--

INSERT INTO `torrent_hit_n_run` (`hnr_system`, `demote_hnr_users`, `ban_hnr_users`, `demote_time`, `after_high_hnr`, `ban_time`, `seedtime`, `time_before_warn`, `maxhitrun`, `warnlength`, `demote_hnr_users_to`) VALUES
('false', 'false', 'false', 0, 0, 0, 3, 0, 0, 0, 'SHIT HEAD');

-- --------------------------------------------------------

--
-- Table structure for table `torrent_icons`
--

CREATE TABLE IF NOT EXISTS `torrent_icons` (
  `icons_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `icons_url` varchar(255) NOT NULL,
  `icons_width` tinyint(4) NOT NULL DEFAULT '0',
  `icons_height` tinyint(4) NOT NULL DEFAULT '0',
  `icons_order` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `display_on_posting` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`icons_id`),
  KEY `display_on_posting` (`display_on_posting`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `torrent_icons`
--

INSERT INTO `torrent_icons` (`icons_id`, `icons_url`, `icons_width`, `icons_height`, `icons_order`, `display_on_posting`) VALUES
(1, 'misc/fire.gif', 16, 16, 1, 1),
(2, 'smile/redface.gif', 16, 16, 0, 9),
(3, 'smile/mrgreen.gif', 16, 16, 10, 1),
(4, 'misc/heart.gif', 16, 16, 4, 1),
(5, 'misc/star.gif', 16, 16, 2, 1),
(6, 'misc/radioactive.gif', 16, 16, 3, 1),
(7, 'misc/thinking.gif', 16, 16, 5, 1),
(8, 'smile/info.gif', 16, 16, 8, 1),
(9, 'smile/question.gif', 16, 16, 6, 1),
(10, 'smile/alert.gif', 16, 16, 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `torrent_img_bucket`
--

CREATE TABLE IF NOT EXISTS `torrent_img_bucket` (
  `allow` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `level` varchar(225) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `max_folder_size` varchar(60) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `max_file_size` varchar(60) COLLATE utf8_bin NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `torrent_img_bucket`
--

INSERT INTO `torrent_img_bucket` (`allow`, `level`, `max_folder_size`, `max_file_size`) VALUES
('true', 'owner;;admin;;Moderator;;VIP;;Power User;;user;;power_uploader;;uploaders', '10560000', '3510000');

-- --------------------------------------------------------

--
-- Table structure for table `torrent_levels`
--

CREATE TABLE IF NOT EXISTS `torrent_levels` (
  `level` varchar(60) COLLATE utf8_bin NOT NULL DEFAULT '',
  `name` varchar(60) COLLATE utf8_bin NOT NULL DEFAULT '',
  `group_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `group_type` tinyint(4) NOT NULL DEFAULT '1',
  `color` varchar(60) COLLATE utf8_bin NOT NULL DEFAULT '',
  `group_desc` text COLLATE utf8_bin,
  `m_see_admin_cp` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_upload` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_download` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_delete_own_torrents` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `m_delete_others_torrents` enum('true','false') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `m_banusers` enum('true','false') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `m_bann_torrents` enum('true','false') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `m_bann_trackers` enum('true','false') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `m_bann_shouts` enum('true','false') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `a_see_ip` enum('true','false') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `u_edit_own_comments` enum('true','false') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `m_edit_comments` enum('true','false') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `m_edit_user` enum('true','false') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `m_mass_upload` enum('true','false') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `u_view_nfo` enum('true','false') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `u_requests` enum('true','false') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `m_requests` enum('true','false') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `u_offers` enum('true','false') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `m_offers` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_top_torrentlist` enum('true','false') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `u_can_comment` enum('true','false') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `u_can_shout` enum('true','false') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `u_can_change_theme` enum('true','false') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `u_can_change_language` enum('true','false') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `u_can_view_profiles` enum('true','false') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `u_can_view_others_email` enum('true','false') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `u_see_member_list` enum('true','false') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `u_can_view_utube` enum('true','false') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `u_can_add_uttube` enum('true','false') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `u_hit_run` enum('true','false') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `u_hnr_demote` enum('true','false') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `u_arcade` enum('true','false') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `u_can_use_bitbucket` enum('true','false') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `u_black_jack` enum('true','false') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `u_casino` enum('true','false') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `m_can_edit_others_torrents` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `m_manage_faqs` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `m_edit_polls` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `m_modforum` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `m_del_users` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_edit_own_torrents` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `m_edit_others_shouts` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_masspm` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_masspm_group` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_pm_delete` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_pm_forward` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_pm_edit` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_pm_smilies` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_pm_bbcode` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_sig` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_savedrafts` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_pm_img` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_pm_flash` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_ignoreflood` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_sendpm` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_pm_attach` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `a_group` enum('treu','false') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `a_groupadd` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `a_groupdel` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_pm_download` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_sendim` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `group_receive_pm` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `a_clearlogs` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `a_forumadd` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `a_forumdel` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `a_fauth` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `a_authusers` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `a_authgroups` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `a_mauth` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `a_forum` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `f_list` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `f_post` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `m_approve` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `f_noapprove` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `a_warn_sys` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `a_prune` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `a_aauth` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `a_uauth` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `a_edit_level` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `a_override_user_pm_block` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `a_override_email_block` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `a_can_add_perm` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_add_poster` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_add_screen_shots` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_add_nfo` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_add_smiles_to_details` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_add_bbcode_details` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_add_quote_details` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_add_imgbbcode_details` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_links_in_details` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_flash_in_details` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_upload_notify` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_hide_torrent_owner` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_apply_ratiobuild` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_add_password_torrent` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_advance_upload_setting` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_add_sticky_upload` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_shout_upload` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_torrent_attach` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_can_add_magnet_links` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `m_view_whois` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `m_casin_users` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_games` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `m_mod_helpdesk` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_update_peers` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_delete_comments` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `m_delete_comments` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `a_mod` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `a_admin` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `m_over_ride_password` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `m_see_hidden_uploader` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_can_view_snatchlist` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_requist_reseed` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `m_down_load_private_torrents` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_attach` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_search` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `u_f_download` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `m_warn` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  UNIQUE KEY `level` (`level`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `torrent_levels`
--

INSERT INTO `torrent_levels` (`level`, `name`, `group_id`, `group_type`, `color`, `group_desc`, `m_see_admin_cp`, `u_upload`, `u_download`, `u_delete_own_torrents`, `m_delete_others_torrents`, `m_banusers`, `m_bann_torrents`, `m_bann_trackers`, `m_bann_shouts`, `a_see_ip`, `u_edit_own_comments`, `m_edit_comments`, `m_edit_user`, `m_mass_upload`, `u_view_nfo`, `u_requests`, `m_requests`, `u_offers`, `m_offers`, `u_top_torrentlist`, `u_can_comment`, `u_can_shout`, `u_can_change_theme`, `u_can_change_language`, `u_can_view_profiles`, `u_can_view_others_email`, `u_see_member_list`, `u_can_view_utube`, `u_can_add_uttube`, `u_hit_run`, `u_hnr_demote`, `u_arcade`, `u_can_use_bitbucket`, `u_black_jack`, `u_casino`, `m_can_edit_others_torrents`, `m_manage_faqs`, `m_edit_polls`, `m_modforum`, `m_del_users`, `u_edit_own_torrents`, `m_edit_others_shouts`, `u_masspm`, `u_masspm_group`, `u_pm_delete`, `u_pm_forward`, `u_pm_edit`, `u_pm_smilies`, `u_pm_bbcode`, `u_sig`, `u_savedrafts`, `u_pm_img`, `u_pm_flash`, `u_ignoreflood`, `u_sendpm`, `u_pm_attach`, `a_group`, `a_groupadd`, `a_groupdel`, `u_pm_download`, `u_sendim`, `group_receive_pm`, `a_clearlogs`, `a_forumadd`, `a_forumdel`, `a_fauth`, `a_authusers`, `a_authgroups`, `a_mauth`, `a_forum`, `f_list`, `f_post`, `m_approve`, `f_noapprove`, `a_warn_sys`, `a_prune`, `a_aauth`, `a_uauth`, `a_edit_level`, `a_override_user_pm_block`, `a_override_email_block`, `a_can_add_perm`, `u_add_poster`, `u_add_screen_shots`, `u_add_nfo`, `u_add_smiles_to_details`, `u_add_bbcode_details`, `u_add_quote_details`, `u_add_imgbbcode_details`, `u_links_in_details`, `u_flash_in_details`, `u_upload_notify`, `u_hide_torrent_owner`, `u_apply_ratiobuild`, `u_add_password_torrent`, `u_advance_upload_setting`, `u_add_sticky_upload`, `u_shout_upload`, `u_torrent_attach`, `u_can_add_magnet_links`, `m_view_whois`, `m_casin_users`, `u_games`, `m_mod_helpdesk`, `u_update_peers`, `u_delete_comments`, `m_delete_comments`, `a_mod`, `a_admin`, `m_over_ride_password`, `m_see_hidden_uploader`, `u_can_view_snatchlist`, `u_requist_reseed`, `m_down_load_private_torrents`, `u_attach`, `u_search`, `u_f_download`, `m_warn`) VALUES
('owner', 'Owner', 5, 3, '#FFFF00', 'The gods of the site, laziest too lol', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'treu', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true'),
('admin', 'Admin', 1, 3, '#7FFF00', 'High level staff - will help with any problems', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'treu', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true'),
('Moderator', 'Moderator', 2, 3, '#B0E2FF', 'moderators - will help where they can :)', 'true', 'true', 'true', 'true', 'false', 'false', 'false', 'false', 'false', 'false', 'true', 'true', 'false', 'false', 'true', 'true', 'false', 'true', 'false', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'false', 'true', 'false', 'false', 'false', 'true', 'true', 'true', 'true', 'true', 'true', 'false', 'false', 'false', 'true', 'true', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'true', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false'),
('VIP', 'VIP', 3, 3, '#D4A017', 'VIP - for donors and those who hae done something to help the site', 'false', 'true', 'true', 'true', 'false', 'false', 'false', 'false', 'false', 'false', 'true', 'false', 'false', 'false', 'true', 'true', 'false', 'true', 'false', 'true', 'true', 'true', 'true', 'true', 'false', 'false', 'true', 'true', 'false', 'false', 'false', 'true', 'true', 'true', 'true', 'false', 'false', 'false', 'false', 'false', 'true', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false'),
('Power User', 'Power User', 7, 3, '#EE9A00', 'Power users - good users who seed and leech loadsssssssss', 'false', 'true', 'true', 'true', 'false', 'false', 'false', 'false', 'false', 'false', 'true', 'false', 'false', 'false', 'true', 'true', 'false', 'true', 'false', 'true', 'true', 'true', 'true', 'true', 'false', 'false', 'false', 'true', 'false', 'false', 'false', 'true', 'true', 'true', 'true', 'false', 'false', 'false', 'false', 'false', 'true', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false'),
('SHIT HEAD', 'S.F.B', 8, 0, '#CDAA7D', 'Simple terms - h&r Shit For Brains', 'false', 'true', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'true', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false'),
('user', 'User', 4, 3, '#FF0000', 'User class - everyone has to start somewhere.......', 'false', 'true', 'true', 'true', 'false', 'false', 'false', 'false', 'false', 'false', 'true', 'false', 'false', 'false', 'false', 'true', 'false', 'true', 'false', 'true', 'true', 'true', 'true', 'true', 'true', 'false', 'false', 'true', 'false', 'true', 'true', 'true', 'true', 'true', 'true', 'false', 'false', 'false', 'false', 'false', 'true', 'false', 'false', 'false', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'false', 'false', 'true', 'false', 'false', 'false', 'false', 'true', 'false', 'true', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false'),
('power_uploader', 'Super-Uploaders', 9, 0, '#FF6347', 'This is a group of users That have Seedboxs', 'false', 'true', 'true', 'true', 'false', 'false', 'false', 'false', 'true', 'false', 'true', 'false', 'false', 'false', 'true', 'false', 'false', 'false', 'false', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'false', 'false', 'true', 'true', 'true', 'true', 'false', 'false', 'false', 'false', 'false', 'true', 'false', 'false', 'false', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'false', 'false', 'true', 'true', 'false', 'false', 'false', 'false', 'false', 'true', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false'),
('uploaders', 'Uploaders', 10, 3, '#20B2AA', 'This is a group of people that upload what they can mosly from the own PC', 'false', 'true', 'true', 'true', 'false', 'false', 'false', 'false', 'false', 'true', 'true', 'false', 'false', 'false', 'true', 'true', 'false', 'true', 'false', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'false', 'false', 'false', 'true', 'true', 'true', 'true', 'false', 'false', 'false', 'false', 'false', 'true', 'false', 'false', 'false', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'false', 'true', 'false', 'false', 'false', 'false', 'false', 'false', 'true', 'true', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false'),
('GUEST', 'GUEST', 6, 0, '', 'Default group for not logged in users', 'false', 'false', 'true', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false');

-- --------------------------------------------------------

--
-- Table structure for table `torrent_level_privlages`
--

CREATE TABLE IF NOT EXISTS `torrent_level_privlages` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `acc_point` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `descr` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `acc_point` (`acc_point`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=120 ;

--
-- Dumping data for table `torrent_level_privlages`
--

INSERT INTO `torrent_level_privlages` (`id`, `acc_point`, `descr`) VALUES
(1, 'm_see_admin_cp', NULL),
(2, 'u_upload', NULL),
(3, 'u_download', NULL),
(4, 'u_delete_own_torrents', NULL),
(5, 'm_delete_others_torrents', NULL),
(6, 'm_banusers', NULL),
(7, 'm_bann_torrents', NULL),
(8, 'm_bann_trackers', NULL),
(9, 'm_bann_shouts', NULL),
(10, 'a_see_ip', NULL),
(11, 'u_edit_own_comments', NULL),
(12, 'm_edit_comments', NULL),
(13, 'm_edit_user', NULL),
(14, 'm_mass_upload', NULL),
(15, 'u_view_nfo', NULL),
(16, 'u_requests', NULL),
(17, 'm_requests', 'Group can edit and delete Requests'),
(18, 'u_offers', NULL),
(19, 'm_offers', 'Group can edit and delete Offers'),
(20, 'u_top_torrentlist', NULL),
(21, 'u_can_comment', NULL),
(22, 'u_can_shout', NULL),
(23, 'u_can_change_theme', NULL),
(24, 'u_can_change_language', NULL),
(25, 'u_can_view_profiles', NULL),
(26, 'u_can_view_others_email', NULL),
(27, 'u_see_member_list', NULL),
(28, 'u_can_view_utube', NULL),
(29, 'u_can_add_uttube', NULL),
(30, 'u_hit_run', NULL),
(31, 'u_hnr_demote', NULL),
(32, 'u_arcade', NULL),
(33, 'u_can_use_bitbucket', NULL),
(34, 'u_black_jack', NULL),
(35, 'u_casino', NULL),
(36, 'm_can_edit_others_torrents', NULL),
(37, 'm_manage_faqs', NULL),
(38, 'm_edit_polls', NULL),
(39, 'm_modforum', NULL),
(40, 'm_del_users', NULL),
(41, 'u_edit_own_torrents', NULL),
(42, 'm_edit_others_shouts', NULL),
(43, 'u_masspm', NULL),
(44, 'u_masspm_group', NULL),
(45, 'u_pm_delete', NULL),
(46, 'u_pm_forward', NULL),
(47, 'u_pm_edit', NULL),
(48, 'u_pm_smilies', NULL),
(49, 'u_pm_bbcode', NULL),
(50, 'u_sig', NULL),
(51, 'u_savedrafts', NULL),
(52, 'u_pm_img', NULL),
(53, 'u_pm_flash', NULL),
(54, 'u_ignoreflood', NULL),
(55, 'u_sendpm', NULL),
(56, 'u_pm_attach', NULL),
(57, 'a_group', NULL),
(58, 'a_groupadd', NULL),
(59, 'a_groupdel', NULL),
(60, 'u_pm_download', NULL),
(61, 'u_sendim', NULL),
(62, 'group_receive_pm', NULL),
(63, 'a_clearlogs', NULL),
(64, 'a_forumadd', NULL),
(65, 'a_forumdel', NULL),
(66, 'a_fauth', NULL),
(67, 'a_authusers', NULL),
(68, 'a_authgroups', NULL),
(69, 'a_mauth', NULL),
(70, 'a_forum', NULL),
(71, 'f_list', NULL),
(72, 'f_post', NULL),
(73, 'm_approve', NULL),
(74, 'f_noapprove', NULL),
(75, 'a_warn_sys', NULL),
(76, 'a_prune', NULL),
(77, 'a_aauth', NULL),
(78, 'a_uauth', NULL),
(79, 'a_edit_level', NULL),
(80, 'a_override_user_pm_block', NULL),
(81, 'a_override_email_block', NULL),
(83, 'a_can_add_perm', 'Group can add new permissions to the site'),
(84, 'u_add_poster', 'Group can Add a poster in torrent details'),
(85, 'u_add_screen_shots', 'Group can add screen shots in torrent details'),
(86, 'u_add_nfo', 'Group can add a .nfo file to torrents details'),
(87, 'u_add_smiles_to_details', 'Group can add smile''s to Torrent Details'),
(88, 'u_add_bbcode_details', 'Group can Use bbcodes in Torrent Details'),
(89, 'u_add_quote_details', 'Group can use BBcode quot in Torrent Details'),
(90, 'u_add_imgbbcode_details', 'Group can use the BBcode tag img in Torrent Details'),
(91, 'u_links_in_details', 'Group can add link in Torrent Details'),
(92, 'u_flash_in_details', 'Group can use Flash code in Torrent Details'),
(93, 'u_upload_notify', 'Group can use Notify function in upload'),
(94, 'u_hide_torrent_owner', 'Group can hide Torrent owner while uploading'),
(95, 'u_apply_ratiobuild', 'Group can apply Ratio Build to torrent upload'),
(96, 'u_add_password_torrent', 'Group can add a Password to a torrent'),
(97, 'u_advance_upload_setting', 'Group can use Advanced features in upload\n''add private''\n''add dht'''),
(98, 'u_add_sticky_upload', 'Group can make new uploads Sticky'),
(99, 'u_shout_upload', 'Group can shout new Torrent uploads'),
(100, 'u_torrent_attach', 'Group can use Attachment feature for torrents'),
(101, 'u_can_add_magnet_links', 'Groups are allowed to upload/add Magnet and eD2k links'),
(102, 'm_view_whois', 'Group is able to view the Whois IP check'),
(103, 'm_casin_users', 'Group can Moderate Casino players.'),
(104, 'u_games', 'Group can play games'),
(105, 'm_mod_helpdesk', 'Group can Moderate the help desk witch includes Closing/Deleting Tickets.'),
(106, 'u_update_peers', 'Group can update Torrent peers.'),
(107, 'u_delete_comments', 'Group can delete there own comments'),
(108, 'm_delete_comments', 'Group Can delete others Comments'),
(109, 'a_mod', 'Gives Access to moderater functions in the admin pannel.'),
(110, 'a_admin', 'Gives group access to Admin sections of the Admin Pannel'),
(111, 'm_over_ride_password', 'Group Can See and down load PassWord protected Torrents.'),
(112, 'm_see_hidden_uploader', 'Group can see uploaders That have selected to Hid there upload'),
(113, 'u_can_view_snatchlist', 'Group Can View the Snatch List of a torrent Or User'),
(114, 'u_requist_reseed', 'Group can Requist Reseed on local Torrents'),
(115, 'm_down_load_private_torrents', 'Group can By pass Private setting on Torrents'),
(116, 'u_attach', 'Group Can Use forum Attachment'),
(117, 'u_search', 'Group Can use the Search feature in the Forum'),
(118, 'u_f_download', 'Group Can download forum Attachments'),
(119, 'm_warn', 'Group Can Warn Users');

-- --------------------------------------------------------

--
-- Table structure for table `torrent_level_settings`
--

CREATE TABLE IF NOT EXISTS `torrent_level_settings` (
  `group_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `group_type` tinyint(4) NOT NULL DEFAULT '1',
  `group_default` tinyint(1) NOT NULL DEFAULT '0',
  `group_founder_manage` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `group_name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `group_desc` text COLLATE utf8_bin NOT NULL,
  `group_desc_bitfield` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `group_desc_options` int(11) unsigned NOT NULL DEFAULT '7',
  `group_desc_uid` varchar(8) COLLATE utf8_bin NOT NULL DEFAULT '',
  `group_display` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `group_avatar` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `group_avatar_type` tinyint(2) NOT NULL DEFAULT '0',
  `group_avatar_width` smallint(4) unsigned NOT NULL DEFAULT '0',
  `group_avatar_height` smallint(4) unsigned NOT NULL DEFAULT '0',
  `group_rank` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `group_colour` varchar(6) COLLATE utf8_bin NOT NULL DEFAULT '',
  `group_sig_chars` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `group_receive_pm` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `group_message_limit` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `group_max_recipients` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `group_legend` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `group_skip_auth` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`group_id`),
  KEY `group_legend_name` (`group_legend`,`group_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=82 ;

--
-- Dumping data for table `torrent_level_settings`
--

INSERT INTO `torrent_level_settings` (`group_id`, `group_type`, `group_default`, `group_founder_manage`, `group_name`, `group_desc`, `group_desc_bitfield`, `group_desc_options`, `group_desc_uid`, `group_display`, `group_avatar`, `group_avatar_type`, `group_avatar_width`, `group_avatar_height`, `group_rank`, `group_colour`, `group_sig_chars`, `group_receive_pm`, `group_message_limit`, `group_max_recipients`, `group_legend`, `group_skip_auth`) VALUES
(1, 3, 0, 1, 'ADMINISTRATORS', 'High level staff - will help with any problems', '', 7, '', 0, '', 0, 0, 0, 1, '7FFF00', 0, 0, 0, 0, 1, 0),
(2, 3, 0, 0, 'MODERATOR', '', '', 7, '', 0, '', 0, 0, 0, 0, 'B0E2FF', 0, 0, 0, 0, 1, 0),
(3, 3, 0, 0, 'PREMIUM_USER', '', '', 7, '', 0, '', 0, 0, 0, 0, 'D4A017', 0, 0, 0, 0, 1, 0),
(4, 3, 1, 0, 'USER', '', '', 7, '', 0, '', 0, 0, 0, 4, 'FF0000', 0, 0, 0, 0, 1, 0),
(5, 0, 0, 1, 'Owner', '', '', 7, '', 0, '', 0, 0, 0, 0, 'FFFF00', 0, 0, 0, 0, 1, 0),
(7, 0, 0, 0, 'Power User', '', '', 7, '', 0, '', 0, 0, 0, 0, 'EE9A00', 0, 0, 0, 0, 1, 0),
(8, 0, 0, 0, 'S.F.B.', '', '', 7, '', 0, '', 0, 0, 0, 0, 'CDAA7D', 0, 0, 0, 0, 1, 0),
(9, 0, 0, 0, 'Super-Uploader', '', '', 7, '', 0, '', 0, 0, 0, 0, 'FF6347', 0, 0, 0, 0, 1, 0),
(10, 0, 0, 0, 'Uploader', 'This is a group of people that upload what they can mosly from their own PC', '', 7, '', 0, '', 0, 0, 0, 0, '20B2AA', 0, 0, 0, 0, 1, 0),
(6, 2, 0, 0, 'Guest', 'Default group for not logged in users', '', 7, '', 0, '', 0, 0, 0, 4, 'FF9999', 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `torrent_log`
--

CREATE TABLE IF NOT EXISTS `torrent_log` (
  `event` int(60) unsigned NOT NULL AUTO_INCREMENT,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `action` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `results` longtext COLLATE utf8_bin NOT NULL,
  `ip` int(10) unsigned NOT NULL DEFAULT '0',
  `host` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `userid` int(60) NOT NULL DEFAULT '0',
  `reportee_id` mediumint(8) NOT NULL DEFAULT '0',
  `forum_id` mediumint(8) NOT NULL DEFAULT '0',
  `torrent_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `log_type` tinyint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`event`),
  KEY `datetime` (`datetime`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin ;

--
-- Dumping data for table `torrent_log`
--


-- --------------------------------------------------------

--
-- Table structure for table `torrent_massupload`
--

CREATE TABLE IF NOT EXISTS `torrent_massupload` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `torrent_moderator_cache`
--

CREATE TABLE IF NOT EXISTS `torrent_moderator_cache` (
  `forum_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `user_id` int(12) unsigned NOT NULL DEFAULT '0',
  `username` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `group_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `group_name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `display_on_index` tinyint(1) unsigned NOT NULL DEFAULT '1',
  KEY `disp_idx` (`display_on_index`),
  KEY `forum_id` (`forum_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `torrent_moderator_cache`
--

INSERT INTO `torrent_moderator_cache` (`forum_id`, `user_id`, `username`, `group_id`, `group_name`, `display_on_index`) VALUES
(0, 0, '', 5, 'Owner', 1);

-- --------------------------------------------------------

--
-- Table structure for table `torrent_modules`
--

CREATE TABLE IF NOT EXISTS `torrent_modules` (
  `module_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `module_enabled` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `module_display` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `module_basename` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `module_class` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT '',
  `parent_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `left_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `right_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `module_langname` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `module_mode` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `module_auth` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`module_id`),
  KEY `left_right_id` (`left_id`,`right_id`),
  KEY `module_enabled` (`module_enabled`),
  KEY `class_left_id` (`module_class`,`left_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=190 ;

--
-- Dumping data for table `torrent_modules`
--

INSERT INTO `torrent_modules` (`module_id`, `module_enabled`, `module_display`, `module_basename`, `module_class`, `parent_id`, `left_id`, `right_id`, `module_langname`, `module_mode`, `module_auth`) VALUES
(1, 1, 1, '', 'acp', 0, 1, 60, 'ACP_CAT_GENERAL', '', ''),
(2, 1, 1, '', 'acp', 1, 4, 17, 'ACP_QUICK_ACCESS', '', ''),
(3, 1, 1, '', 'acp', 1, 18, 39, 'ACP_BOARD_CONFIGURATION', '', ''),
(4, 1, 1, '', 'acp', 1, 40, 47, 'ACP_CLIENT_COMMUNICATION', '', ''),
(5, 1, 1, '', 'acp', 1, 48, 59, 'ACP_SERVER_CONFIGURATION', '', ''),
(6, 1, 1, '', 'acp', 0, 61, 78, 'ACP_CAT_FORUMS', '', ''),
(7, 1, 1, '', 'acp', 6, 62, 67, 'ACP_MANAGE_FORUMS', '', ''),
(8, 1, 1, '', 'acp', 6, 68, 77, 'ACP_FORUM_BASED_PERMISSIONS', '', ''),
(9, 1, 1, '', 'acp', 0, 79, 102, 'ACP_CAT_POSTING', '', ''),
(10, 1, 1, '', 'acp', 9, 80, 91, 'ACP_MESSAGES', '', ''),
(11, 1, 1, '', 'acp', 9, 92, 101, 'ACP_ATTACHMENTS', '', ''),
(12, 1, 1, '', 'acp', 0, 103, 156, 'ACP_CAT_USERGROUP', '', ''),
(13, 1, 1, '', 'acp', 12, 104, 135, 'ACP_CAT_USERS', '', ''),
(14, 1, 1, '', 'acp', 12, 136, 143, 'ACP_GROUPS', '', ''),
(15, 1, 1, '', 'acp', 12, 144, 155, 'ACP_USER_SECURITY', '', ''),
(16, 1, 1, '', 'acp', 0, 157, 204, 'ACP_CAT_PERMISSIONS', '', ''),
(17, 1, 1, '', 'acp', 16, 160, 169, 'ACP_GLOBAL_PERMISSIONS', '', ''),
(18, 1, 1, '', 'acp', 16, 170, 179, 'ACP_FORUM_BASED_PERMISSIONS', '', ''),
(19, 1, 1, '', 'acp', 16, 180, 189, 'ACP_PERMISSION_ROLES', '', ''),
(20, 1, 1, '', 'acp', 16, 190, 203, 'ACP_PERMISSION_MASKS', '', ''),
(21, 1, 1, '', 'acp', 0, 205, 218, 'ACP_CAT_STYLES', '', ''),
(22, 1, 1, '', 'acp', 21, 206, 209, 'ACP_STYLE_MANAGEMENT', '', ''),
(23, 1, 1, '', 'acp', 21, 210, 217, 'ACP_STYLE_COMPONENTS', '', ''),
(24, 1, 1, '', 'acp', 0, 219, 238, 'ACP_CAT_MAINTENANCE', '', ''),
(25, 1, 1, '', 'acp', 24, 220, 229, 'ACP_FORUM_LOGS', '', ''),
(26, 1, 1, '', 'acp', 24, 230, 237, 'ACP_CAT_DATABASE', '', ''),
(27, 1, 1, '', 'acp', 0, 239, 264, 'ACP_CAT_SYSTEM', '', ''),
(28, 1, 1, '', 'acp', 27, 240, 243, 'ACP_AUTOMATION', '', ''),
(29, 1, 1, '', 'acp', 27, 244, 255, 'ACP_GENERAL_TASKS', '', ''),
(30, 1, 1, '', 'acp', 27, 256, 263, 'ACP_MODULE_MANAGEMENT', '', ''),
(31, 1, 1, '', 'acp', 0, 265, 266, 'ACP_CAT_DOT_MODS', '', ''),
(32, 1, 1, 'attachments', 'acp', 3, 19, 20, 'ACP_ATTACHMENT_SETTINGS', 'attach', 'acl_a_attach'),
(33, 1, 1, 'attachments', 'acp', 11, 93, 94, 'ACP_ATTACHMENT_SETTINGS', 'attach', 'acl_a_attach'),
(34, 1, 1, 'attachments', 'acp', 11, 95, 96, 'ACP_MANAGE_EXTENSIONS', 'extensions', 'acl_a_attach'),
(35, 1, 1, 'attachments', 'acp', 11, 97, 98, 'ACP_EXTENSION_GROUPS', 'ext_groups', 'acl_a_attach'),
(36, 1, 1, 'attachments', 'acp', 11, 99, 100, 'ACP_ORPHAN_ATTACHMENTS', 'orphan', 'acl_a_attach'),
(37, 1, 1, 'ban', 'acp', 15, 145, 146, 'ACP_BAN_EMAILS', 'email', 'acl_a_ban'),
(38, 1, 1, 'ban', 'acp', 15, 147, 148, 'ACP_BAN_IPS', 'ip', 'acl_a_ban'),
(39, 1, 1, 'ban', 'acp', 15, 149, 150, 'ACP_BAN_USERNAMES', 'user', 'acl_a_ban'),
(40, 1, 1, 'bbcodes', 'acp', 10, 81, 82, 'ACP_BBCODES', 'bbcodes', 'acl_a_bbcode'),
(41, 1, 1, 'board', 'acp', 3, 21, 22, 'ACP_BOARD_SETTINGS', 'settings', 'acl_a_board'),
(42, 1, 1, 'board', 'acp', 3, 23, 24, 'ACP_BOARD_FEATURES', 'features', 'acl_a_board'),
(43, 1, 1, 'board', 'acp', 3, 25, 26, 'ACP_AVATAR_SETTINGS', 'avatar', 'acl_a_board'),
(44, 1, 1, 'board', 'acp', 3, 27, 28, 'ACP_MESSAGE_SETTINGS', 'message', 'acl_a_board'),
(45, 1, 1, 'board', 'acp', 10, 83, 84, 'ACP_MESSAGE_SETTINGS', 'message', 'acl_a_board'),
(46, 1, 1, 'board', 'acp', 3, 29, 30, 'ACP_POST_SETTINGS', 'post', 'acl_a_board'),
(47, 1, 1, 'board', 'acp', 3, 31, 32, 'ACP_SIGNATURE_SETTINGS', 'signature', 'acl_a_board'),
(48, 1, 1, 'board', 'acp', 3, 33, 34, 'ACP_REGISTER_SETTINGS', 'registration', 'acl_a_board'),
(49, 1, 1, 'board', 'acp', 4, 41, 42, 'ACP_AUTH_SETTINGS', 'auth', 'acl_a_server'),
(50, 1, 1, 'board', 'acp', 4, 43, 44, 'ACP_EMAIL_SETTINGS', 'email', 'acl_a_server'),
(51, 1, 1, 'board', 'acp', 5, 49, 50, 'ACP_COOKIE_SETTINGS', 'cookie', 'acl_a_server'),
(52, 1, 1, 'board', 'acp', 5, 51, 52, 'ACP_SERVER_SETTINGS', 'server', 'acl_a_server'),
(53, 1, 1, 'board', 'acp', 5, 53, 54, 'ACP_SECURITY_SETTINGS', 'security', 'acl_a_server'),
(54, 1, 1, 'board', 'acp', 5, 55, 56, 'ACP_LOAD_SETTINGS', 'load', 'acl_a_server'),
(55, 1, 1, 'bots', 'acp', 29, 245, 246, 'ACP_BOTS', 'bots', 'acl_a_bots'),
(56, 1, 1, 'captcha', 'acp', 3, 35, 36, 'ACP_VC_SETTINGS', 'visual', 'acl_a_board'),
(57, 1, 0, 'captcha', 'acp', 3, 37, 38, 'ACP_VC_CAPTCHA_DISPLAY', 'img', 'acl_a_board'),
(58, 1, 1, 'database', 'acp', 26, 231, 232, 'ACP_BACKUP', 'backup', 'acl_a_backup'),
(59, 1, 1, 'database', 'acp', 26, 233, 234, 'ACP_RESTORE', 'restore', 'acl_a_backup'),
(60, 1, 1, 'disallow', 'acp', 15, 151, 152, 'ACP_DISALLOW_USERNAMES', 'usernames', 'acl_a_names'),
(61, 1, 1, 'email', 'acp', 29, 247, 248, 'ACP_MASS_EMAIL', 'email', 'acl_a_email'),
(62, 1, 1, 'forums', 'acp', 7, 63, 64, 'ACP_MANAGE_FORUMS', 'manage', 'acl_a_forum'),
(63, 1, 1, 'groups', 'acp', 14, 137, 138, 'ACP_GROUPS_MANAGE', 'manage', 'acl_a_group'),
(64, 1, 1, 'icons', 'acp', 10, 85, 86, 'ACP_ICONS', 'icons', 'acl_a_icons'),
(65, 1, 1, 'icons', 'acp', 10, 87, 88, 'ACP_SMILIES', 'smilies', 'acl_a_icons'),
(66, 1, 1, 'inactive', 'acp', 13, 107, 108, 'ACP_INACTIVE_USERS', 'list', 'acl_a_user'),
(67, 1, 1, 'jabber', 'acp', 4, 45, 46, 'ACP_JABBER_SETTINGS', 'settings', 'acl_a_jabber'),
(68, 1, 1, 'language', 'acp', 29, 249, 250, 'ACP_LANGUAGE_PACKS', 'lang_packs', 'acl_a_language'),
(69, 1, 1, 'logs', 'acp', 25, 221, 222, 'ACP_ADMIN_LOGS', 'admin', 'acl_a_viewlogs'),
(70, 1, 1, 'logs', 'acp', 25, 223, 224, 'ACP_MOD_LOGS', 'mod', 'acl_a_viewlogs'),
(71, 1, 1, 'logs', 'acp', 25, 225, 226, 'ACP_USERS_LOGS', 'users', 'acl_a_viewlogs'),
(72, 1, 1, 'logs', 'acp', 25, 227, 228, 'ACP_CRITICAL_LOGS', 'critical', 'acl_a_viewlogs'),
(73, 1, 1, 'main', 'acp', 1, 2, 3, 'ACP_INDEX', 'main', ''),
(74, 1, 1, 'modules', 'acp', 30, 257, 258, 'ACP', 'acp', 'acl_a_modules'),
(75, 1, 1, 'modules', 'acp', 30, 259, 260, 'UCP', 'ucp', 'acl_a_modules'),
(76, 1, 1, 'modules', 'acp', 30, 261, 262, 'MCP', 'mcp', 'acl_a_modules'),
(77, 1, 1, 'permission_roles', 'acp', 19, 181, 182, 'ACP_ADMIN_ROLES', 'admin_roles', 'acl_a_roles && acl_a_aauth'),
(78, 1, 1, 'permission_roles', 'acp', 19, 183, 184, 'ACP_USER_ROLES', 'user_roles', 'acl_a_roles && acl_a_uauth'),
(79, 1, 1, 'permission_roles', 'acp', 19, 185, 186, 'ACP_MOD_ROLES', 'mod_roles', 'acl_a_roles && acl_a_mauth'),
(80, 1, 1, 'permission_roles', 'acp', 19, 187, 188, 'ACP_FORUM_ROLES', 'forum_roles', 'acl_a_roles && acl_a_fauth'),
(81, 1, 1, 'permissions', 'acp', 16, 158, 159, 'ACP_PERMISSIONS', 'intro', 'acl_a_authusers || acl_a_authgroups || acl_a_viewauth'),
(82, 1, 0, 'permissions', 'acp', 20, 191, 192, 'ACP_PERMISSION_TRACE', 'trace', 'acl_a_viewauth'),
(83, 1, 1, 'permissions', 'acp', 18, 171, 172, 'ACP_FORUM_PERMISSIONS', 'setting_forum_local', 'acl_a_fauth && (acl_a_authusers || acl_a_authgroups)'),
(84, 1, 1, 'permissions', 'acp', 18, 173, 174, 'ACP_FORUM_MODERATORS', 'setting_mod_local', 'acl_a_mauth && (acl_a_authusers || acl_a_authgroups)'),
(85, 1, 1, 'permissions', 'acp', 17, 161, 162, 'ACP_USERS_PERMISSIONS', 'setting_user_global', 'acl_a_authusers && (acl_a_aauth || acl_a_mauth || acl_a_uauth)'),
(86, 1, 1, 'permissions', 'acp', 13, 109, 110, 'ACP_USERS_PERMISSIONS', 'setting_user_global', 'acl_a_authusers && (acl_a_aauth || acl_a_mauth || acl_a_uauth)'),
(87, 1, 1, 'permissions', 'acp', 18, 175, 176, 'ACP_USERS_FORUM_PERMISSIONS', 'setting_user_local', 'acl_a_authusers && (acl_a_mauth || acl_a_fauth)'),
(88, 1, 1, 'permissions', 'acp', 13, 111, 112, 'ACP_USERS_FORUM_PERMISSIONS', 'setting_user_local', 'acl_a_authusers && (acl_a_mauth || acl_a_fauth)'),
(89, 1, 1, 'permissions', 'acp', 17, 163, 164, 'ACP_GROUPS_PERMISSIONS', 'setting_group_global', 'acl_a_authgroups && (acl_a_aauth || acl_a_mauth || acl_a_uauth)'),
(90, 1, 1, 'permissions', 'acp', 14, 139, 140, 'ACP_GROUPS_PERMISSIONS', 'setting_group_global', 'acl_a_authgroups && (acl_a_aauth || acl_a_mauth || acl_a_uauth)'),
(91, 1, 1, 'permissions', 'acp', 18, 177, 178, 'ACP_GROUPS_FORUM_PERMISSIONS', 'setting_group_local', 'acl_a_authgroups && (acl_a_mauth || acl_a_fauth)'),
(92, 1, 1, 'permissions', 'acp', 14, 141, 142, 'ACP_GROUPS_FORUM_PERMISSIONS', 'setting_group_local', 'acl_a_authgroups && (acl_a_mauth || acl_a_fauth)'),
(93, 1, 1, 'permissions', 'acp', 17, 165, 166, 'ACP_ADMINISTRATORS', 'setting_admin_global', 'acl_a_aauth && (acl_a_authusers || acl_a_authgroups)'),
(94, 1, 1, 'permissions', 'acp', 17, 167, 168, 'ACP_GLOBAL_MODERATORS', 'setting_mod_global', 'acl_a_mauth && (acl_a_authusers || acl_a_authgroups)'),
(95, 1, 1, 'permissions', 'acp', 20, 193, 194, 'ACP_VIEW_ADMIN_PERMISSIONS', 'view_admin_global', 'acl_a_viewauth'),
(96, 1, 1, 'permissions', 'acp', 20, 195, 196, 'ACP_VIEW_USER_PERMISSIONS', 'view_user_global', 'acl_a_viewauth'),
(97, 1, 1, 'permissions', 'acp', 20, 197, 198, 'ACP_VIEW_GLOBAL_MOD_PERMISSIONS', 'view_mod_global', 'acl_a_viewauth'),
(98, 1, 1, 'permissions', 'acp', 20, 199, 200, 'ACP_VIEW_FORUM_MOD_PERMISSIONS', 'view_mod_local', 'acl_a_viewauth'),
(99, 1, 1, 'permissions', 'acp', 20, 201, 202, 'ACP_VIEW_FORUM_PERMISSIONS', 'view_forum_local', 'acl_a_viewauth'),
(100, 1, 1, 'php_info', 'acp', 29, 251, 252, 'ACP_PHP_INFO', 'info', 'acl_a_phpinfo'),
(101, 1, 1, 'profile', 'acp', 13, 113, 114, 'ACP_CUSTOM_PROFILE_FIELDS', 'profile', 'acl_a_profile'),
(102, 1, 1, 'prune', 'acp', 7, 65, 66, 'ACP_PRUNE_FORUMS', 'forums', 'acl_a_prune'),
(103, 1, 1, 'prune', 'acp', 15, 153, 154, 'ACP_PRUNE_USERS', 'users', 'acl_a_userdel'),
(104, 1, 1, 'ranks', 'acp', 13, 115, 116, 'ACP_MANAGE_RANKS', 'ranks', 'acl_a_ranks'),
(105, 1, 1, 'reasons', 'acp', 29, 253, 254, 'ACP_MANAGE_REASONS', 'main', 'acl_a_reasons'),
(106, 1, 1, 'search', 'acp', 5, 57, 58, 'ACP_SEARCH_SETTINGS', 'settings', 'acl_a_search'),
(107, 1, 1, 'search', 'acp', 26, 235, 236, 'ACP_SEARCH_INDEX', 'index', 'acl_a_search'),
(108, 1, 1, 'styles', 'acp', 22, 207, 208, 'ACP_STYLES', 'style', 'acl_a_styles'),
(109, 1, 1, 'styles', 'acp', 23, 211, 212, 'ACP_TEMPLATES', 'template', 'acl_a_styles'),
(110, 1, 1, 'styles', 'acp', 23, 213, 214, 'ACP_THEMES', 'theme', 'acl_a_styles'),
(111, 1, 1, 'styles', 'acp', 23, 215, 216, 'ACP_IMAGESETS', 'imageset', 'acl_a_styles'),
(112, 1, 1, 'update', 'acp', 28, 241, 242, 'ACP_VERSION_CHECK', 'version_check', 'acl_a_board'),
(113, 1, 1, 'users', 'acp', 13, 105, 106, 'ACP_MANAGE_USERS', 'overview', 'acl_a_user'),
(114, 1, 0, 'users', 'acp', 13, 117, 118, 'ACP_USER_FEEDBACK', 'feedback', 'acl_a_user'),
(115, 1, 0, 'users', 'acp', 13, 119, 120, 'ACP_USER_PROFILE', 'profile', 'acl_a_user'),
(116, 1, 0, 'users', 'acp', 13, 121, 122, 'ACP_USER_PREFS', 'prefs', 'acl_a_user'),
(117, 1, 0, 'users', 'acp', 13, 123, 124, 'ACP_USER_AVATAR', 'avatar', 'acl_a_user'),
(118, 1, 0, 'users', 'acp', 13, 125, 126, 'ACP_USER_RANK', 'rank', 'acl_a_user'),
(119, 1, 0, 'users', 'acp', 13, 127, 128, 'ACP_USER_SIG', 'sig', 'acl_a_user'),
(120, 1, 0, 'users', 'acp', 13, 129, 130, 'ACP_USER_GROUPS', 'groups', 'acl_a_user && acl_a_group'),
(121, 1, 0, 'users', 'acp', 13, 131, 132, 'ACP_USER_PERM', 'perm', 'acl_a_user && acl_a_viewauth'),
(122, 1, 0, 'users', 'acp', 13, 133, 134, 'ACP_USER_ATTACH', 'attach', 'acl_a_user'),
(123, 1, 1, 'words', 'acp', 10, 89, 90, 'ACP_WORDS', 'words', 'acl_a_words'),
(124, 1, 1, 'users', 'acp', 2, 5, 6, 'ACP_MANAGE_USERS', 'overview', 'acl_a_user'),
(125, 1, 1, 'groups', 'acp', 2, 7, 8, 'ACP_GROUPS_MANAGE', 'manage', 'acl_a_group'),
(126, 1, 1, 'forums', 'acp', 2, 9, 10, 'ACP_MANAGE_FORUMS', 'manage', 'acl_a_forum'),
(127, 1, 1, 'logs', 'acp', 2, 11, 12, 'ACP_MOD_LOGS', 'mod', 'acl_a_viewlogs'),
(128, 1, 1, 'bots', 'acp', 2, 13, 14, 'ACP_BOTS', 'bots', 'acl_a_bots'),
(129, 1, 1, 'php_info', 'acp', 2, 15, 16, 'ACP_PHP_INFO', 'info', 'acl_a_phpinfo'),
(130, 1, 1, 'permissions', 'acp', 8, 69, 70, 'ACP_FORUM_PERMISSIONS', 'setting_forum_local', 'acl_a_fauth && (acl_a_authusers || acl_a_authgroups)'),
(131, 1, 1, 'permissions', 'acp', 8, 71, 72, 'ACP_FORUM_MODERATORS', 'setting_mod_local', 'acl_a_mauth && (acl_a_authusers || acl_a_authgroups)'),
(132, 1, 1, 'permissions', 'acp', 8, 73, 74, 'ACP_USERS_FORUM_PERMISSIONS', 'setting_user_local', 'acl_a_authusers && (acl_a_mauth || acl_a_fauth)'),
(133, 1, 1, 'permissions', 'acp', 8, 75, 76, 'ACP_GROUPS_FORUM_PERMISSIONS', 'setting_group_local', 'acl_a_authgroups && (acl_a_mauth || acl_a_fauth)'),
(134, 1, 1, '', 'mcp', 0, 1, 10, 'MCP_MAIN', '', ''),
(135, 1, 1, '', 'mcp', 0, 11, 18, 'MCP_QUEUE', '', ''),
(136, 1, 1, '', 'mcp', 0, 19, 26, 'MCP_REPORTS', '', ''),
(137, 1, 1, '', 'mcp', 0, 27, 32, 'MCP_NOTES', '', ''),
(138, 1, 1, '', 'mcp', 0, 33, 42, 'MCP_WARN', '', ''),
(139, 1, 1, '', 'mcp', 0, 43, 50, 'MCP_LOGS', '', ''),
(140, 1, 1, '', 'mcp', 0, 51, 58, 'MCP_BAN', '', ''),
(141, 1, 1, 'ban', 'mcp', 140, 52, 53, 'MCP_BAN_USERNAMES', 'user', 'acl_m_ban'),
(142, 1, 1, 'ban', 'mcp', 140, 54, 55, 'MCP_BAN_IPS', 'ip', 'acl_m_ban'),
(143, 1, 1, 'ban', 'mcp', 140, 56, 57, 'MCP_BAN_EMAILS', 'email', 'acl_m_ban'),
(144, 1, 1, 'logs', 'mcp', 139, 44, 45, 'MCP_LOGS_FRONT', 'front', 'acl_m_ || aclf_m_'),
(145, 1, 1, 'logs', 'mcp', 139, 46, 47, 'MCP_LOGS_FORUM_VIEW', 'forum_logs', 'acl_m_,$id'),
(146, 1, 1, 'logs', 'mcp', 139, 48, 49, 'MCP_LOGS_TOPIC_VIEW', 'topic_logs', 'acl_m_,$id'),
(147, 1, 1, 'main', 'mcp', 134, 2, 3, 'MCP_MAIN_FRONT', 'front', ''),
(148, 1, 1, 'main', 'mcp', 134, 4, 5, 'MCP_MAIN_FORUM_VIEW', 'forum_view', 'acl_m_,$id'),
(149, 1, 1, 'main', 'mcp', 134, 6, 7, 'MCP_MAIN_TOPIC_VIEW', 'topic_view', 'acl_m_,$id'),
(150, 1, 1, 'main', 'mcp', 134, 8, 9, 'MCP_MAIN_POST_DETAILS', 'post_details', 'acl_m_,$id || (!$id && aclf_m_)'),
(151, 1, 1, 'notes', 'mcp', 137, 28, 29, 'MCP_NOTES_FRONT', 'front', ''),
(152, 1, 1, 'notes', 'mcp', 137, 30, 31, 'MCP_NOTES_USER', 'user_notes', ''),
(153, 1, 1, 'queue', 'mcp', 135, 12, 13, 'MCP_QUEUE_UNAPPROVED_TOPICS', 'unapproved_topics', 'aclf_m_approve'),
(154, 1, 1, 'queue', 'mcp', 135, 14, 15, 'MCP_QUEUE_UNAPPROVED_POSTS', 'unapproved_posts', 'aclf_m_approve'),
(155, 1, 1, 'queue', 'mcp', 135, 16, 17, 'MCP_QUEUE_APPROVE_DETAILS', 'approve_details', 'acl_m_approve,$id || (!$id && aclf_m_approve)'),
(156, 1, 1, 'reports', 'mcp', 136, 20, 21, 'MCP_REPORTS_OPEN', 'reports', 'aclf_m_report'),
(157, 1, 1, 'reports', 'mcp', 136, 22, 23, 'MCP_REPORTS_CLOSED', 'reports_closed', 'aclf_m_report'),
(158, 1, 1, 'reports', 'mcp', 136, 24, 25, 'MCP_REPORT_DETAILS', 'report_details', 'acl_m_report,$id || (!$id && aclf_m_report)'),
(159, 1, 1, 'warn', 'mcp', 138, 34, 35, 'MCP_WARN_FRONT', 'front', 'aclf_m_warn'),
(160, 1, 1, 'warn', 'mcp', 138, 36, 37, 'MCP_WARN_LIST', 'list', 'aclf_m_warn'),
(161, 1, 1, 'warn', 'mcp', 138, 38, 39, 'MCP_WARN_USER', 'warn_user', 'aclf_m_warn'),
(162, 1, 1, 'warn', 'mcp', 138, 40, 41, 'MCP_WARN_POST', 'warn_post', 'acl_m_warn && acl_f_read,$id'),
(163, 1, 1, '', 'ucp', 0, 1, 12, 'UCP_MAIN', '', ''),
(164, 1, 1, '', 'ucp', 0, 13, 22, 'UCP_PROFILE', '', ''),
(165, 1, 1, '', 'ucp', 0, 23, 30, 'UCP_PREFS', '', ''),
(166, 1, 1, '', 'ucp', 0, 31, 42, 'UCP_PM', '', ''),
(167, 1, 1, '', 'ucp', 0, 43, 48, 'UCP_USERGROUPS', '', ''),
(168, 1, 1, '', 'ucp', 0, 49, 54, 'UCP_ZEBRA', '', ''),
(169, 1, 1, 'attachments', 'ucp', 163, 10, 11, 'UCP_MAIN_ATTACHMENTS', 'attachments', 'acl_u_attach'),
(170, 1, 1, 'groups', 'ucp', 167, 44, 45, 'UCP_USERGROUPS_MEMBER', 'membership', ''),
(171, 1, 1, 'groups', 'ucp', 167, 46, 47, 'UCP_USERGROUPS_MANAGE', 'manage', ''),
(172, 1, 1, 'main', 'ucp', 163, 2, 3, 'UCP_MAIN_FRONT', 'front', ''),
(173, 1, 1, 'main', 'ucp', 163, 4, 5, 'UCP_MAIN_SUBSCRIBED', 'subscribed', ''),
(174, 1, 1, 'main', 'ucp', 163, 6, 7, 'UCP_MAIN_BOOKMARKS', 'bookmarks', 'cfg_allow_bookmarks'),
(175, 1, 1, 'main', 'ucp', 163, 8, 9, 'UCP_MAIN_DRAFTS', 'drafts', ''),
(176, 1, 0, 'pm', 'ucp', 166, 32, 33, 'UCP_PM_VIEW', 'view', 'cfg_allow_privmsg'),
(177, 1, 1, 'pm', 'ucp', 166, 34, 35, 'UCP_PM_COMPOSE', 'compose', 'cfg_allow_privmsg'),
(178, 1, 1, 'pm', 'ucp', 166, 36, 37, 'UCP_PM_DRAFTS', 'drafts', 'cfg_allow_privmsg'),
(179, 1, 1, 'pm', 'ucp', 166, 38, 39, 'UCP_PM_OPTIONS', 'options', 'cfg_allow_privmsg'),
(180, 1, 0, 'pm', 'ucp', 166, 40, 41, 'UCP_PM_POPUP_TITLE', 'popup', 'cfg_allow_privmsg'),
(181, 1, 1, 'prefs', 'ucp', 165, 24, 25, 'UCP_PREFS_PERSONAL', 'personal', ''),
(182, 1, 1, 'prefs', 'ucp', 165, 26, 27, 'UCP_PREFS_POST', 'post', ''),
(183, 1, 1, 'prefs', 'ucp', 165, 28, 29, 'UCP_PREFS_VIEW', 'view', ''),
(184, 1, 1, 'profile', 'ucp', 164, 14, 15, 'UCP_PROFILE_PROFILE_INFO', 'profile_info', ''),
(185, 1, 1, 'profile', 'ucp', 164, 16, 17, 'UCP_PROFILE_SIGNATURE', 'signature', ''),
(186, 1, 1, 'profile', 'ucp', 164, 18, 19, 'UCP_PROFILE_AVATAR', 'avatar', ''),
(187, 1, 1, 'profile', 'ucp', 164, 20, 21, 'UCP_PROFILE_REG_DETAILS', 'reg_details', ''),
(188, 1, 1, 'zebra', 'ucp', 168, 50, 51, 'UCP_ZEBRA_FRIENDS', 'friends', ''),
(189, 1, 1, 'zebra', 'ucp', 168, 52, 53, 'UCP_ZEBRA_FOES', 'foes', '');

-- --------------------------------------------------------

--
-- Table structure for table `torrent_online_users`
--

CREATE TABLE IF NOT EXISTS `torrent_online_users` (
  `id` int(60) unsigned NOT NULL DEFAULT '0',
  `page` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `logged_in` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_action` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `torrent_paypal`
--

CREATE TABLE IF NOT EXISTS `torrent_paypal` (
  `siteurl` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `paypal_email` varchar(60) COLLATE utf8_bin NOT NULL DEFAULT '',
  `sitecost` varchar(60) COLLATE utf8_bin NOT NULL DEFAULT '',
  `reseaved_donations` varchar(60) COLLATE utf8_bin NOT NULL DEFAULT '',
  `donatepage` longtext COLLATE utf8_bin NOT NULL,
  `donation_block` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'true',
  `nodonate` enum('EU','UK','US') COLLATE utf8_bin NOT NULL DEFAULT 'US'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `torrent_paypal`
--

INSERT INTO `torrent_paypal` (`siteurl`, `paypal_email`, `sitecost`, `reseaved_donations`, `donatepage`, `donation_block`, `nodonate`) VALUES
('', 'joeroberts@actfas.com', '200', '10', 'to see if $user->name well show \\"true\\" <br><form action=\\"https://www.paypal.com/cgi-bin/webscr\\" method=\\"post\\"><br><input type=\\"hidden\\" name=\\"cmd\\" value=\\"_s-xclick\\"><br><input type=\\"hidden\\" name=\\"hosted_button_id\\" value=\\"M88HHZUKBEFHA\\"><br><input type=\\"image\\" src=\\"https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif\\" border=\\"0\\" name=\\"submit\\" alt=\\"PayPal - The safer, easier way to pay online!\\"><br><img alt=\\"\\" border=\\"0\\" src=\\"https://www.paypalobjects.com/en_US/i/scr/pixel.gif\\" width=\\"1\\" height=\\"1\\"><br></form>', 'false', 'US');

-- --------------------------------------------------------

--
-- Table structure for table `torrent_peers`
--

CREATE TABLE IF NOT EXISTS `torrent_peers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL DEFAULT '0',
  `torrent` int(10) unsigned NOT NULL DEFAULT '0',
  `peer_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `unique_id` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `ip` int(10) unsigned NOT NULL DEFAULT '0',
  `port` smallint(5) unsigned NOT NULL DEFAULT '0',
  `real_ip` varchar(20) COLLATE utf8_bin NOT NULL,
  `uploaded` bigint(20) unsigned NOT NULL DEFAULT '0',
  `downloaded` bigint(20) unsigned NOT NULL DEFAULT '0',
  `download_speed` int(11) unsigned NOT NULL DEFAULT '0',
  `upload_speed` int(11) unsigned NOT NULL DEFAULT '0',
  `to_go` bigint(20) unsigned NOT NULL DEFAULT '0',
  `seeder` enum('yes','no') COLLATE utf8_bin NOT NULL DEFAULT 'no',
  `started` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_action` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `connectable` enum('yes','no') COLLATE utf8_bin NOT NULL DEFAULT 'yes',
  `client` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `version` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT '',
  `user_agent` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `torrent_peer_id` (`torrent`,`peer_id`),
  UNIQUE KEY `torrent_3` (`torrent`,`unique_id`),
  KEY `torrent` (`torrent`),
  KEY `last_action` (`last_action`),
  KEY `torrent_2` (`torrent`,`seeder`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin ;

-- --------------------------------------------------------

--
-- Table structure for table `torrent_pollanswers`
--

CREATE TABLE IF NOT EXISTS `torrent_pollanswers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pollid` int(10) unsigned NOT NULL DEFAULT '0',
  `topic_id` int(10) unsigned NOT NULL DEFAULT '0',
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `selection` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `pollid` (`pollid`),
  KEY `selection` (`selection`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `torrent_polls`
--

CREATE TABLE IF NOT EXISTS `torrent_polls` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `question` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `option0` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '',
  `option1` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '',
  `option2` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '',
  `option3` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '',
  `option4` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '',
  `option5` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '',
  `option6` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '',
  `option7` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '',
  `option8` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '',
  `option9` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '',
  `sort` enum('yes','no') COLLATE utf8_bin NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `torrent_poll_options`
--

CREATE TABLE IF NOT EXISTS `torrent_poll_options` (
  `poll_option_id` tinyint(4) NOT NULL DEFAULT '0',
  `topic_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `poll_option_text` text COLLATE utf8_bin NOT NULL,
  `poll_option_total` mediumint(8) unsigned NOT NULL DEFAULT '0',
  KEY `poll_opt_id` (`poll_option_id`),
  KEY `topic_id` (`topic_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `torrent_poll_votes`
--

CREATE TABLE IF NOT EXISTS `torrent_poll_votes` (
  `topic_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `poll_option_id` tinyint(4) NOT NULL DEFAULT '0',
  `vote_user_id` int(20) unsigned NOT NULL DEFAULT '0',
  `vote_user_ip` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '',
  KEY `topic_id` (`topic_id`),
  KEY `vote_user_id` (`vote_user_id`),
  KEY `vote_user_ip` (`vote_user_ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `torrent_posts`
--

CREATE TABLE IF NOT EXISTS `torrent_posts` (
  `post_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `forum_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `poster_id` int(20) unsigned NOT NULL DEFAULT '0',
  `icon_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `poster_ip` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '',
  `post_time` int(11) unsigned NOT NULL DEFAULT '0',
  `post_approved` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `post_reported` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `enable_bbcode` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `enable_smilies` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `enable_magic_url` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `enable_sig` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `post_username` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `post_subject` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `post_text` mediumtext COLLATE utf8_bin NOT NULL,
  `post_checksum` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `post_attachment` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `bbcode_bitfield` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `bbcode_uid` varchar(8) COLLATE utf8_bin NOT NULL DEFAULT '',
  `post_postcount` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `post_edit_time` int(11) unsigned NOT NULL DEFAULT '0',
  `post_edit_reason` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `post_edit_user` int(20) unsigned NOT NULL DEFAULT '0',
  `post_edit_count` smallint(4) unsigned NOT NULL DEFAULT '0',
  `post_edit_locked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`post_id`),
  KEY `forum_id` (`forum_id`),
  KEY `topic_id` (`topic_id`),
  KEY `poster_ip` (`poster_ip`),
  KEY `poster_id` (`poster_id`),
  KEY `post_approved` (`post_approved`),
  KEY `post_username` (`post_username`),
  KEY `tid_post_time` (`topic_id`,`post_time`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin ;

--
-- Dumping data for table `torrent_posts`
--


-- --------------------------------------------------------

--
-- Table structure for table `torrent_privacy_backup`
--

CREATE TABLE IF NOT EXISTS `torrent_privacy_backup` (
  `master` int(11) unsigned NOT NULL DEFAULT '0',
  `slave` int(11) NOT NULL DEFAULT '0',
  `torrent` int(11) NOT NULL DEFAULT '0',
  `status` enum('pending','denied','granted') COLLATE utf8_bin NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`slave`,`torrent`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `torrent_privacy_file`
--

CREATE TABLE IF NOT EXISTS `torrent_privacy_file` (
  `master` int(11) unsigned NOT NULL DEFAULT '0',
  `slave` int(11) unsigned NOT NULL DEFAULT '0',
  `torrent` int(15) unsigned NOT NULL DEFAULT '0',
  `status` enum('pending','denied','granted') COLLATE utf8_bin NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`slave`,`torrent`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `torrent_privacy_global`
--

CREATE TABLE IF NOT EXISTS `torrent_privacy_global` (
  `master` int(11) unsigned NOT NULL DEFAULT '0',
  `torrent` int(11) NOT NULL DEFAULT '0',
  `slave` int(11) unsigned NOT NULL DEFAULT '0',
  `status` enum('blacklist','whitelist') COLLATE utf8_bin NOT NULL DEFAULT 'whitelist',
  PRIMARY KEY (`master`,`slave`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `torrent_private_messages`
--

CREATE TABLE IF NOT EXISTS `torrent_private_messages` (
  `id` int(20) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `sender` int(11) unsigned NOT NULL DEFAULT '0',
  `recipient` text COLLATE utf8_bin NOT NULL,
  `subject` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `text` longtext COLLATE utf8_bin NOT NULL,
  `is_read` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `sent` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `sender_del` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `recipient_del` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `save` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `folder_id` int(11) NOT NULL DEFAULT '0',
  `bcc_address` text COLLATE utf8_bin NOT NULL,
  `root_level` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `icon_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `author_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `enable_bbcode` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `enable_smilies` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `enable_magic_url` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `enable_sig` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `message_attachment` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `bbcode_bitfield` varchar(255) COLLATE utf8_bin NOT NULL,
  `bbcode_uid` varchar(8) COLLATE utf8_bin NOT NULL,
  `message_reported` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `message_edit_reason` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `message_edit_user` int(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `from` (`sender`),
  KEY `root_level` (`root_level`,`author_ip`),
  FULLTEXT KEY `text` (`text`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin ;

--
-- Dumping data for table `torrent_private_messages`
--


-- --------------------------------------------------------

--
-- Table structure for table `torrent_private_messages_blacklist`
--

CREATE TABLE IF NOT EXISTS `torrent_private_messages_blacklist` (
  `master` int(11) unsigned NOT NULL DEFAULT '0',
  `slave` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`master`,`slave`),
  KEY `master` (`master`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `torrent_private_messages_bookmarks`
--

CREATE TABLE IF NOT EXISTS `torrent_private_messages_bookmarks` (
  `master` int(11) unsigned NOT NULL DEFAULT '0',
  `slave` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`master`,`slave`),
  KEY `master` (`master`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `torrent_private_messages_bookmarks`
--


-- --------------------------------------------------------

--
-- Table structure for table `torrent_private_messages_rules`
--

CREATE TABLE IF NOT EXISTS `torrent_private_messages_rules` (
  `rule_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `user_id` int(20) NOT NULL DEFAULT '0',
  `rule_check` mediumint(8) NOT NULL DEFAULT '0',
  `rule_connection` mediumint(8) NOT NULL DEFAULT '0',
  `rule_string` varchar(255) NOT NULL,
  `rule_user_id` int(20) NOT NULL DEFAULT '0',
  `rule_group_id` mediumint(8) NOT NULL DEFAULT '0',
  `rule_action` mediumint(8) NOT NULL DEFAULT '0',
  `rule_folder_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`rule_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `torrent_privmsgs_folder`
--

CREATE TABLE IF NOT EXISTS `torrent_privmsgs_folder` (
  `folder_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `user_id` int(20) NOT NULL DEFAULT '0',
  `folder_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `pm_count` mediumint(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`folder_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `torrent_privmsgs_to`
--

CREATE TABLE IF NOT EXISTS `torrent_privmsgs_to` (
  `msg_id` int(20) NOT NULL DEFAULT '0',
  `user_id` int(20) NOT NULL DEFAULT '0',
  `author_id` int(20) NOT NULL DEFAULT '0',
  `pm_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `pm_new` tinyint(1) NOT NULL DEFAULT '1',
  `pm_unread` tinyint(1) NOT NULL DEFAULT '1',
  `pm_replied` tinyint(1) NOT NULL DEFAULT '0',
  `pm_marked` tinyint(1) NOT NULL DEFAULT '0',
  `pm_forwarded` tinyint(1) NOT NULL DEFAULT '0',
  `folder_id` int(11) NOT NULL DEFAULT '0',
  KEY `msg_id` (`msg_id`,`user_id`,`author_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `torrent_privmsgs_to`
--


-- --------------------------------------------------------

--
-- Table structure for table `torrent_ranks`
--

CREATE TABLE IF NOT EXISTS `torrent_ranks` (
  `rank_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `rank_title` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `rank_min` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `rank_special` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `rank_image` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`rank_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

--
-- Dumping data for table `torrent_ranks`
--

INSERT INTO `torrent_ranks` (`rank_id`, `rank_title`, `rank_min`, `rank_special`, `rank_image`) VALUES
(1, 'admin', 0, 1, ''),
(2, 'moderator', 0, 1, ''),
(3, 'premium', 0, 1, ''),
(4, 'user', 0, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `torrent_ratings`
--

CREATE TABLE IF NOT EXISTS `torrent_ratings` (
  `torrent` int(10) unsigned NOT NULL DEFAULT '0',
  `user` int(10) unsigned NOT NULL DEFAULT '0',
  `rating` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`torrent`,`user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `torrent_ratings`
--


-- --------------------------------------------------------

--
-- Table structure for table `torrent_ratiowarn`
--

CREATE TABLE IF NOT EXISTS `torrent_ratiowarn` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL DEFAULT '0',
  `warned` enum('yes','no') COLLATE utf8_bin NOT NULL DEFAULT 'no',
  `banned` enum('yes','no') COLLATE utf8_bin NOT NULL DEFAULT 'no',
  `ratiodate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `warntime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `torrent_ratiowarn_config`
--

CREATE TABLE IF NOT EXISTS `torrent_ratiowarn_config` (
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `torrent_ratiowarn_config`
--

INSERT INTO `torrent_ratiowarn_config` (`name`, `value`) VALUES
('enable', 'true'),
('ratio_mini', '0.0'),
('ratio_warn', '3'),
('ratio_ban', '6');

-- --------------------------------------------------------

--
-- Table structure for table `torrent_reports`
--

CREATE TABLE IF NOT EXISTS `torrent_reports` (
  `report_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `reason_id` smallint(4) NOT NULL DEFAULT '0',
  `post_id` mediumint(8) NOT NULL DEFAULT '0',
  `pm_id` mediumint(8) NOT NULL DEFAULT '0',
  `user_id` int(20) NOT NULL DEFAULT '0',
  `user_notify` tinyint(1) NOT NULL DEFAULT '0',
  `report_closed` tinyint(1) NOT NULL DEFAULT '0',
  `report_time` int(11) NOT NULL DEFAULT '0',
  `report_text` mediumtext NOT NULL,
  PRIMARY KEY (`report_id`),
  KEY `post_id` (`post_id`,`pm_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `torrent_reports_reasons`
--

CREATE TABLE IF NOT EXISTS `torrent_reports_reasons` (
  `reason_id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `reason_title` varchar(255) NOT NULL,
  `reason_description` mediumtext NOT NULL,
  `reason_order` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`reason_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `torrent_reports_reasons`
--

INSERT INTO `torrent_reports_reasons` (`reason_id`, `reason_title`, `reason_description`, `reason_order`) VALUES
(1, 'warez', 'The reported post contains links to pirated or illegal software', 1),
(2, 'spam', 'The reported post has for only purpose to advertise for a website or another product', 2),
(3, 'off_topic', 'The reported post is off topic', 3),
(4, 'other', 'The reported post does not fit into any other category (please use the description field)', 4);

-- --------------------------------------------------------

--
-- Table structure for table `torrent_rules`
--

CREATE TABLE IF NOT EXISTS `torrent_rules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `text` longtext COLLATE utf8_bin NOT NULL,
  `bbcode_bitfield` varchar(255) COLLATE utf8_bin NOT NULL,
  `bbcode_uid` varchar(8) COLLATE utf8_bin NOT NULL,
  `public` enum('yes','no') COLLATE utf8_bin NOT NULL DEFAULT 'yes',
  `level` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `torrent_search_cloud`
--

CREATE TABLE IF NOT EXISTS `torrent_search_cloud` (
  `active` int(11) NOT NULL DEFAULT '0',
  `user_only` int(11) NOT NULL DEFAULT '0',
  `how_many` int(11) NOT NULL DEFAULT '10'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `torrent_search_cloud`
--

INSERT INTO `torrent_search_cloud` (`active`, `user_only`, `how_many`) VALUES
(0, 0, 10);

-- --------------------------------------------------------

--
-- Table structure for table `torrent_search_results`
--

CREATE TABLE IF NOT EXISTS `torrent_search_results` (
  `search_key` varbinary(32) NOT NULL DEFAULT '',
  `search_time` int(11) unsigned NOT NULL DEFAULT '0',
  `search_keywords` mediumblob NOT NULL,
  `search_authors` mediumblob NOT NULL,
  PRIMARY KEY (`search_key`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `torrent_search_text`
--

CREATE TABLE IF NOT EXISTS `torrent_search_text` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `text` varchar(25) COLLATE utf8_bin NOT NULL DEFAULT '',
  `hit` int(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `text` (`text`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `torrent_search_wordlist`
--

CREATE TABLE IF NOT EXISTS `torrent_search_wordlist` (
  `word_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `word_text` blob NOT NULL,
  `word_common` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `word_count` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`word_id`),
  UNIQUE KEY `wrd_txt` (`word_text`(255)),
  KEY `wrd_cnt` (`word_count`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `torrent_search_wordmatch`
--

CREATE TABLE IF NOT EXISTS `torrent_search_wordmatch` (
  `post_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `word_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `title_match` tinyint(1) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `unq_mtch` (`word_id`,`post_id`,`title_match`),
  KEY `word_id` (`word_id`),
  KEY `post_id` (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `torrent_seeder_notify`
--

CREATE TABLE IF NOT EXISTS `torrent_seeder_notify` (
  `torrent` int(11) NOT NULL DEFAULT '0',
  `user` int(11) NOT NULL DEFAULT '0',
  `status` enum('active','stopped') COLLATE utf8_bin NOT NULL DEFAULT 'active',
  PRIMARY KEY (`torrent`,`user`),
  KEY `contacts` (`torrent`,`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `torrent_sessions`
--

CREATE TABLE IF NOT EXISTS `torrent_sessions` (
  `session_id` char(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `session_user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `session_forum_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `session_last_visit` int(11) unsigned NOT NULL DEFAULT '0',
  `session_start` int(11) unsigned NOT NULL DEFAULT '0',
  `session_time` int(11) unsigned NOT NULL DEFAULT '0',
  `session_ip` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '',
  `session_browser` varchar(150) COLLATE utf8_bin NOT NULL DEFAULT '',
  `session_forwarded_for` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `session_page` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `session_viewonline` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `session_autologin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `session_admin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`session_id`),
  KEY `session_time` (`session_time`),
  KEY `session_user_id` (`session_user_id`),
  KEY `session_fid` (`session_forum_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `torrent_settings`
--

CREATE TABLE IF NOT EXISTS `torrent_settings` (
  `config_name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `config_value` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `is_dynamic` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`config_name`),
  KEY `is_dynamic` (`is_dynamic`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `torrent_settings`
--

INSERT INTO `torrent_settings` (`config_name`, `config_value`, `is_dynamic`) VALUES
('board_email_form', '0', 0),
('board_hide_emails', '0', 0),
('smtp_delivery_ssl', 'SSL', 0),
('smtp_authentication', '1', 0),
('smtp_debug', '0', 0),
('email_enable', '1', 0),
('email_function_name', 'mail', 0),
('email_package_size', '0', 0),
('board_contact', 'black_heart@btmanager.org', 0),
('board_email', 'black_heart@btmanager.org', 0),
('board_email_sig', 'BT.Manager Staff', 0),
('smtp_delivery', '1', 0),
('smtp_host', 'server138.web-hosting.com', 0),
('smtp_port', '465', 0),
('smtp_auth_method', 'PLAIN', 0),
('smtp_username', 'black_heart@btmanager.org', 0),
('smtp_password', 'Leslie30', 0),
('allow_privmsg', '1', 0),
('pm_max_boxes', '2', 0),
('full_folder_action', '1', 0),
('auth_bbcode_pm', '1', 0),
('auth_smilies_pm', '1', 0),
('allow_sig_pm', '1', 0),
('print_pm', '1', 0),
('forward_pm', '1', 0),
('auth_img_pm', '1', 0),
('enable_pm_icons', '1', 0),
('pm_max_msgs', '0', 0),
('pm_edit_time', '0', 0),
('allow_sig', '1', 0),
('allow_sig_bbcode', '1', 0),
('allow_sig_img', '1', 0),
('allow_sig_smilies', '1', 0),
('allow_sig_links', '1', 0),
('max_sig_chars', '225', 0),
('max_sig_font_size', '20', 0),
('max_sig_smilies', '6', 0),
('max_sig_img_width', '0', 0),
('max_sig_img_height', '0', 0),
('max_sig_urls', '2', 0),
('tpl_allow_php', '1', 0),
('load_db_lastread', '1', 0),
('cron_lock', '0', 1),
('queue_interval', '0', 0),
('last_queue_run', '0', 0),
('cache_gc', '0', 0),
('cache_last_gc', '0', 0),
('search_gc', '0', 0),
('search_last_gc', '0', 0),
('warnings_gc', '0', 0),
('warnings_last_gc', '0', 0),
('database_gc', '0', 0),
('database_last_gc', '', 0),
('allow_bbcode', '1', 0),
('allow_smilies', '1', 0),
('allow_post_links', '1', 0),
('site_url', 'http://demo.btmanager.org', 0),
('posts_per_page', '15', 0),
('allow_birthdays', '1', 0),
('display_last_edited', '1', 0),
('edit_time', '123456', 0),
('topics_per_page', '15', 0);

-- --------------------------------------------------------

--
-- Table structure for table `torrent_shouts`
--

CREATE TABLE IF NOT EXISTS `torrent_shouts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL DEFAULT '0',
  `text` longtext COLLATE utf8_bin NOT NULL,
  `bbcode_bitfield` varchar(255) COLLATE utf8_bin NOT NULL,
  `bbcode_uid` varchar(8) COLLATE utf8_bin NOT NULL,
  `posted` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `id_to` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `posted` (`posted`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Dumping data for table `torrent_shouts`
--


-- --------------------------------------------------------

--
-- Table structure for table `torrent_shout_cast`
--

CREATE TABLE IF NOT EXISTS `torrent_shout_cast` (
  `allow` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `ip` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `port` mediumint(8) NOT NULL DEFAULT '0',
  `admin_name` varchar(225) COLLATE utf8_bin NOT NULL DEFAULT '',
  `admin_pass` varchar(225) COLLATE utf8_bin NOT NULL DEFAULT '',
  `host_dj` varchar(225) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `torrent_shout_cast`
--

INSERT INTO `torrent_shout_cast` (`allow`, `ip`, `port`, `admin_name`, `admin_pass`, `host_dj`) VALUES
('false', '0', 0, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `torrent_shout_config`
--

CREATE TABLE IF NOT EXISTS `torrent_shout_config` (
  `announce_ment` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `shoutnewuser` enum('yes','no') COLLATE utf8_bin NOT NULL DEFAULT 'yes',
  `shout_new_torrent` enum('yes','no') COLLATE utf8_bin NOT NULL DEFAULT 'yes',
  `shout_new_porn` enum('yes','no') COLLATE utf8_bin NOT NULL DEFAULT 'yes',
  `turn_on` enum('yes','no') COLLATE utf8_bin NOT NULL DEFAULT 'yes',
  `refresh_time` int(10) NOT NULL DEFAULT '30',
  `idle_time` int(10) NOT NULL DEFAULT '3000',
  `shouts_to_show` int(10) NOT NULL DEFAULT '25',
  `bbcode_on` enum('yes','no') COLLATE utf8_bin NOT NULL DEFAULT 'yes',
  `allow_url` enum('yes','no') COLLATE utf8_bin NOT NULL DEFAULT 'yes',
  `autodelete_time` int(10) NOT NULL DEFAULT '30',
  `canedit_on` enum('yes','no') COLLATE utf8_bin NOT NULL DEFAULT 'yes',
  `candelete_on` enum('yes','no') COLLATE utf8_bin NOT NULL DEFAULT 'yes',
  `autodelet` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `can_quote` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `torrent_shout_config`
--

INSERT INTO `torrent_shout_config` (`announce_ment`, `shoutnewuser`, `shout_new_torrent`, `shout_new_porn`, `turn_on`, `refresh_time`, `idle_time`, `shouts_to_show`, `bbcode_on`, `allow_url`, `autodelete_time`, `canedit_on`, `candelete_on`, `autodelet`, `can_quote`) VALUES
('Welcome To BTmanager Source', 'yes', 'yes', 'yes', 'yes', 50000, 300000, 25, 'yes', 'yes', 30, 'yes', 'yes', 'false', 'false');

-- --------------------------------------------------------

--
-- Table structure for table `torrent_smiles`
--

CREATE TABLE IF NOT EXISTS `torrent_smiles` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(15) COLLATE utf8_bin NOT NULL DEFAULT '',
  `file` varchar(30) COLLATE utf8_bin NOT NULL DEFAULT '',
  `alt` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '',
  `sort_index` int(10) NOT NULL,
  `smiley_url` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=99 ;

--
-- Dumping data for table `torrent_smiles`
--

INSERT INTO `torrent_smiles` (`id`, `code`, `file`, `alt`, `sort_index`, `smiley_url`) VALUES
(1, ':thankyou:', 'thankyou.gif', 'thankyou', 100, NULL),
(93, ':bt7:', '7.png', 'bt7', 90, NULL),
(92, ':bt6:', '6.png', 'bt6', 80, NULL),
(91, ':bt5:', '5.png', 'bt5', 70, NULL),
(90, ':bt4:', '4.png', 'bt4', 60, NULL),
(89, ':bt3:', '3.png', 'bt3', 50, NULL),
(87, ':bt1:', '1.png', 'bt1', 30, NULL),
(88, ':bt2:', '2.png', 'bt2', 40, NULL),
(94, ':bt8:', '8.png', 'bt8', 110, NULL),
(97, ':welcome:', 'welcome.gif', 'welcome', 20, NULL),
(98, ':coffee:', 'coffee.jpg', 'coffee', 10, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `torrent_snatched`
--

CREATE TABLE IF NOT EXISTS `torrent_snatched` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `torrent` int(10) unsigned NOT NULL DEFAULT '0',
  `torrentid` int(10) unsigned NOT NULL DEFAULT '0',
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` bigint(20) unsigned NOT NULL DEFAULT '0',
  `torrent_name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `torrent_category` int(10) unsigned NOT NULL DEFAULT '0',
  `port` smallint(5) unsigned NOT NULL DEFAULT '0',
  `uploaded` bigint(20) unsigned NOT NULL DEFAULT '0',
  `downloaded` bigint(20) unsigned NOT NULL DEFAULT '0',
  `to_go` bigint(20) unsigned NOT NULL DEFAULT '0',
  `speedup` bigint(20) unsigned NOT NULL DEFAULT '0',
  `speeddown` bigint(20) unsigned NOT NULL DEFAULT '0',
  `seeder` enum('yes','no') COLLATE utf8_bin NOT NULL DEFAULT 'no',
  `last_action` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `startdat` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `completedat` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `connectable` enum('yes','no') COLLATE utf8_bin NOT NULL DEFAULT 'yes',
  `agent` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `finished` enum('yes','no') COLLATE utf8_bin NOT NULL DEFAULT 'no',
  `seeding_time` int(10) DEFAULT '0',
  `warned` enum('yes','no') COLLATE utf8_bin DEFAULT 'no',
  `hnr_warning` enum('yes','no') COLLATE utf8_bin DEFAULT 'no',
  `hitrun` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hitrunwarn` enum('yes','pending','no') COLLATE utf8_bin NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`),
  UNIQUE KEY `torrentid_3` (`torrentid`,`userid`),
  KEY `finished` (`finished`,`torrentid`),
  KEY `torrentid` (`userid`),
  KEY `torrentid_2` (`torrentid`),
  KEY `userid` (`userid`,`torrentid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Dumping data for table `torrent_snatched`
--


-- --------------------------------------------------------

--
-- Table structure for table `torrent_thanks`
--

CREATE TABLE IF NOT EXISTS `torrent_thanks` (
  `tid` bigint(10) NOT NULL AUTO_INCREMENT,
  `uid` bigint(10) NOT NULL DEFAULT '0',
  `torid` bigint(10) NOT NULL DEFAULT '0',
  `thank_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Dumping data for table `torrent_thanks`
--


-- --------------------------------------------------------

--
-- Table structure for table `torrent_time_offset`
--

CREATE TABLE IF NOT EXISTS `torrent_time_offset` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=721 ;

--
-- Dumping data for table `torrent_time_offset`
--

INSERT INTO `torrent_time_offset` (`id`, `name`) VALUES
(-720, '(GMT - 12:00 hours) Enitwetok, Kwajalien'),
(-660, '(GMT - 11:00 hours) Midway Island, Samoa'),
(-600, '(GMT - 10:00 hours) Hawaii'),
(-540, '(GMT - 9:00 hours) Alaska'),
(-480, '(GMT - 8:00 hours) Pacific Time (US &amp; Canada)'),
(-420, '(GMT - 7:00 hours) Mountain Time (US &amp; Canada)'),
(-360, '(GMT - 6:00 hours) Central Time (US &amp; Canada),'),
(-300, '(GMT - 5:00 hours) Eastern Time (US &amp; Canada),'),
(-240, '(GMT - 4:00 hours) Atlantic Time (Canada), Caracas'),
(-210, '(GMT - 3:30 hours) Newfoundland'),
(-180, '(GMT - 3:00 hours) Brazil, Buenos Aires, Georgetow'),
(-120, '(GMT - 2:00 hours) Mid-Atlantic, Ascention Isl., S'),
(-60, '(GMT - 1:00 hour) Azores, Cape Verde Islands'),
(1, '(GMT) Casablanca, Dublin, Edinburgh, London, Lisbo'),
(60, '(GMT + 1:00 hour) Amsterdam, Berlin, Copenhagen, M'),
(120, '(GMT + 2:00 hours) Kaliningrad, South Africa, Wars'),
(180, '(GMT + 3:00 hours) Baghdad, Riyadh, Moscow, Nairob'),
(210, '(GMT + 3:30 hours) Tehran'),
(240, '(GMT + 4:00 hours) Adu Dhabi, Baku, Muscat, Tbilis'),
(270, '(GMT + 4:30 hours) Kabul'),
(300, '(GMT + 5:00 hours) Ekaterinburg, Islamabad, Karach'),
(330, '(GMT + 5:30 hours) Bombay, Calcutta, Madras, New D'),
(360, '(GMT + 6:00 hours) Almaty, Colomba, Dhakra'),
(420, '(GMT + 7:00 hours) Bangkok, Hanoi, Jakarta'),
(480, '(GMT + 8:00 hours) Beijing, Hong Kong, Perth, Sing'),
(540, '(GMT + 9:00 hours) Osaka, Sapporo, Seoul, Tokyo, Y'),
(570, '(GMT + 9:30 hours) Adelaide, Darwin'),
(600, '(GMT + 10:00 hours) Melbourne, Papua New Guinea, S'),
(660, '(GMT + 11:00 hours) Magadan, New Caledonia, Solomo'),
(720, '(GMT + 12:00 hours) Auckland, Wellington, Fiji, Ma');

-- --------------------------------------------------------

--
-- Table structure for table `torrent_topics`
--

CREATE TABLE IF NOT EXISTS `torrent_topics` (
  `topic_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `forum_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `icon_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_attachment` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `topic_approved` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `topic_reported` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `topic_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `topic_poster` int(20) unsigned NOT NULL DEFAULT '0',
  `topic_time` int(11) unsigned NOT NULL DEFAULT '0',
  `topic_time_limit` int(11) unsigned NOT NULL DEFAULT '0',
  `topic_views` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_replies` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_replies_real` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_status` tinyint(3) NOT NULL DEFAULT '0',
  `topic_type` tinyint(3) NOT NULL DEFAULT '0',
  `topic_first_post_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_first_poster_name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `topic_first_poster_colour` varchar(6) COLLATE utf8_bin NOT NULL DEFAULT '',
  `topic_last_post_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_last_poster_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_last_poster_name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `topic_last_poster_colour` varchar(6) COLLATE utf8_bin NOT NULL DEFAULT '',
  `topic_last_post_subject` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `topic_last_post_time` int(11) unsigned NOT NULL DEFAULT '0',
  `topic_last_view_time` int(11) unsigned NOT NULL DEFAULT '0',
  `topic_moved_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_bumped` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `topic_bumper` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `poll_title` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `poll_start` int(11) unsigned NOT NULL DEFAULT '0',
  `poll_length` int(11) unsigned NOT NULL DEFAULT '0',
  `poll_max_options` tinyint(4) NOT NULL DEFAULT '1',
  `poll_last_vote` int(11) unsigned NOT NULL DEFAULT '0',
  `poll_vote_change` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`topic_id`),
  KEY `forum_id` (`forum_id`),
  KEY `forum_id_type` (`forum_id`,`topic_type`),
  KEY `last_post_time` (`topic_last_post_time`),
  KEY `topic_approved` (`topic_approved`),
  KEY `forum_appr_last` (`forum_id`,`topic_approved`,`topic_last_post_id`),
  KEY `fid_time_moved` (`forum_id`,`topic_last_post_time`,`topic_moved_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Dumping data for table `torrent_topics`
--


-- --------------------------------------------------------

--
-- Table structure for table `torrent_topics_posted`
--

CREATE TABLE IF NOT EXISTS `torrent_topics_posted` (
  `user_id` int(20) unsigned NOT NULL DEFAULT '0',
  `topic_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_posted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`topic_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `torrent_topics_posted`
--


-- --------------------------------------------------------

--
-- Table structure for table `torrent_topics_track`
--

CREATE TABLE IF NOT EXISTS `torrent_topics_track` (
  `user_id` int(20) unsigned NOT NULL DEFAULT '0',
  `topic_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `forum_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `mark_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`topic_id`),
  KEY `forum_id` (`forum_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `torrent_topics_track`
--


-- --------------------------------------------------------

--
-- Table structure for table `torrent_topics_watch`
--

CREATE TABLE IF NOT EXISTS `torrent_topics_watch` (
  `topic_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `user_id` int(20) unsigned NOT NULL DEFAULT '0',
  `notify_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  KEY `topic_id` (`topic_id`),
  KEY `user_id` (`user_id`),
  KEY `notify_stat` (`notify_status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `torrent_torrents`
--

CREATE TABLE IF NOT EXISTS `torrent_torrents` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `info_hash` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `md5sum` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `filename` varchar(255) COLLATE utf8_bin NOT NULL,
  `save_as` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `search_text` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `descr` text COLLATE utf8_bin NOT NULL,
  `bbcode_bitfield` varchar(255) COLLATE utf8_bin NOT NULL,
  `bbcode_uid` varchar(8) COLLATE utf8_bin NOT NULL,
  `post_img` text COLLATE utf8_bin,
  `screan1` text COLLATE utf8_bin,
  `screan2` text COLLATE utf8_bin,
  `screan3` text COLLATE utf8_bin,
  `screan4` text COLLATE utf8_bin,
  `plen` bigint(6) unsigned NOT NULL DEFAULT '0',
  `size` bigint(20) unsigned NOT NULL DEFAULT '0',
  `category` int(10) unsigned NOT NULL DEFAULT '0',
  `type` enum('single','multi','link') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'single',
  `numfiles` int(10) unsigned NOT NULL DEFAULT '0',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `exeem` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `dht` enum('yes','no') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `backup_tracker` enum('true','false') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  `downloaded` int(10) unsigned NOT NULL DEFAULT '0',
  `completed` int(10) unsigned NOT NULL DEFAULT '0',
  `banned` enum('yes','no') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `private` enum('true','false') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `min_ratio` float unsigned NOT NULL DEFAULT '0',
  `visible` enum('yes','no') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `evidence` tinyint(1) NOT NULL DEFAULT '0',
  `owner` int(10) unsigned NOT NULL DEFAULT '0',
  `ownertype` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `uploader_host` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `numratings` int(10) unsigned NOT NULL DEFAULT '0',
  `ratingsum` int(10) unsigned NOT NULL DEFAULT '0',
  `seeders` int(10) unsigned NOT NULL DEFAULT '0',
  `leechers` int(10) unsigned NOT NULL DEFAULT '0',
  `tot_peer` int(11) unsigned NOT NULL DEFAULT '0',
  `speed` int(10) unsigned NOT NULL DEFAULT '0',
  `comments` int(10) unsigned NOT NULL DEFAULT '0',
  `complaints` char(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0,0',
  `tracker` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `tracker_list` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `tracker_update` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_action` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nuked` enum('yes','no','unnuked') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `ratiobuild` enum('yes','no') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `nukereason` varchar(225) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `thanks` int(10) NOT NULL DEFAULT '0',
  `imdb` varchar(225) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `info_hash` (`info_hash`),
  KEY `owner` (`owner`),
  KEY `visible` (`visible`),
  KEY `added` (`added`),
  KEY `seeders` (`seeders`),
  KEY `leechers` (`leechers`),
  KEY `tot_peer` (`tot_peer`),
  KEY `banned` (`banned`),
  KEY `password` (`password`),
  KEY `tracker` (`tracker`),
  KEY `evidence` (`evidence`),
  KEY `rating` (`numratings`,`ratingsum`),
  KEY `numfiles` (`numfiles`),
  KEY `downloaded` (`downloaded`),
  KEY `category` (`category`),
  KEY `type` (`type`),
  FULLTEXT KEY `ft_search` (`search_text`),
  FULLTEXT KEY `filename` (`filename`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin PACK_KEYS=1 CHECKSUM=1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `torrent_torrents`
--


-- --------------------------------------------------------

--
-- Table structure for table `torrent_trackers`
--

CREATE TABLE IF NOT EXISTS `torrent_trackers` (
  `id` tinyint(5) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(120) COLLATE utf8_bin NOT NULL DEFAULT '',
  `support` enum('selective','global','single') COLLATE utf8_bin NOT NULL DEFAULT 'selective',
  `status` enum('active','dead','blacklisted') COLLATE utf8_bin NOT NULL DEFAULT 'active',
  `updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`),
  KEY `update` (`updated`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Dumping data for table `torrent_trackers`
--


-- --------------------------------------------------------

--
-- Table structure for table `torrent_userautodel`
--

CREATE TABLE IF NOT EXISTS `torrent_userautodel` (
  `inactwarning_time` int(10) NOT NULL DEFAULT '0',
  `autodel_users_time` int(10) NOT NULL DEFAULT '0',
  `autodel_users` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'true'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `torrent_userautodel`
--

INSERT INTO `torrent_userautodel` (`inactwarning_time`, `autodel_users_time`, `autodel_users`) VALUES
(30, 30, 'false');

-- --------------------------------------------------------

--
-- Table structure for table `torrent_users`
--

CREATE TABLE IF NOT EXISTS `torrent_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) COLLATE utf8_bin NOT NULL DEFAULT '',
  `clean_username` varchar(25) COLLATE utf8_bin NOT NULL DEFAULT '',
  `name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `regdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `password` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '',
  `theme` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `language` varchar(15) COLLATE utf8_bin DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT 'blank.gif',
  `avatar_type` bigint(32) NOT NULL DEFAULT '0',
  `avatar_ht` bigint(32) NOT NULL DEFAULT '0',
  `avatar_wt` bigint(32) NOT NULL DEFAULT '0',
  `accept_mail` enum('yes','no') COLLATE utf8_bin NOT NULL DEFAULT 'no',
  `mass_mail` enum('yes','no') COLLATE utf8_bin NOT NULL,
  `pm_notify` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'true',
  `pm_popup` enum('true','false') COLLATE utf8_bin NOT NULL,
  `aim` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `icq` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `jabber` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `msn` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `skype` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `yahoo` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `level` enum('user','premium','moderator','admin') COLLATE utf8_bin NOT NULL DEFAULT 'user',
  `can_do` varchar(225) COLLATE utf8_bin NOT NULL DEFAULT 'user',
  `user_rank` mediumint(9) NOT NULL DEFAULT '0',
  `user_type` tinyint(2) NOT NULL DEFAULT '0',
  `user_permissions` mediumtext COLLATE utf8_bin,
  `user_colour` varchar(6) COLLATE utf8_bin DEFAULT NULL,
  `user_perm_from` mediumint(8) unsigned DEFAULT NULL,
  `uploaded` bigint(32) unsigned NOT NULL DEFAULT '0',
  `downloaded` bigint(32) unsigned NOT NULL DEFAULT '0',
  `active` tinyint(1) DEFAULT '0',
  `ban` int(1) unsigned NOT NULL DEFAULT '0',
  `act_key` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `passkey` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `newpasswd` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  `newemail` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `mail_key` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `banreason` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `lastip` int(10) unsigned NOT NULL DEFAULT '0',
  `lasthost` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `lastlogin` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `rem` enum('yes','no') COLLATE utf8_bin NOT NULL DEFAULT 'no',
  `modcomment` longtext COLLATE utf8_bin,
  `warned` int(1) unsigned NOT NULL DEFAULT '0',
  `warn_kapta` int(11) NOT NULL DEFAULT '0',
  `warn_hossz` int(11) NOT NULL DEFAULT '0',
  `invited_by` int(10) NOT NULL DEFAULT '0',
  `invitees` varchar(100) COLLATE utf8_bin NOT NULL DEFAULT '',
  `country` int(10) NOT NULL DEFAULT '0',
  `seedbox` int(10) unsigned NOT NULL DEFAULT '0',
  `tzoffset` smallint(4) NOT NULL DEFAULT '0',
  `can_shout` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'true',
  `Show_online` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'true',
  `invites` smallint(5) NOT NULL DEFAULT '0',
  `invitedate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `seedbonus` decimal(10,1) NOT NULL DEFAULT '0.0',
  `donator` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `donated` decimal(10,1) unsigned NOT NULL DEFAULT '0.0',
  `dondate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `torrent_per_page` int(10) DEFAULT NULL,
  `donator_tell` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dongift` int(1) unsigned NOT NULL DEFAULT '0',
  `inactwarning` tinyint(1) NOT NULL DEFAULT '0',
  `inactive_warn_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hitruns` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `HNR_W` int(11) NOT NULL DEFAULT '0',
  `helper` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `help_able` varchar(225) COLLATE utf8_bin NOT NULL DEFAULT '',
  `signature` varchar(200) COLLATE utf8_bin NOT NULL DEFAULT '',
  `bbcode_bitfield` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `bbcode_uid` varchar(8) COLLATE utf8_bin DEFAULT NULL,
  `sig_bbcode_bitfield` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `sig_bbcode_uid` varchar(8) COLLATE utf8_bin DEFAULT NULL,
  `forumbanned` enum('yes','no') COLLATE utf8_bin NOT NULL DEFAULT 'no',
  `parked` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `disabled` enum('true','false') COLLATE utf8_bin NOT NULL DEFAULT 'false',
  `disabled_reason` text COLLATE utf8_bin,
  `birthday` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `client` varchar(225) COLLATE utf8_bin DEFAULT NULL,
  `lastpage` varchar(225) COLLATE utf8_bin DEFAULT NULL,
  `user_message_rules` int(1) unsigned NOT NULL DEFAULT '0',
  `user_full_folder` int(11) NOT NULL DEFAULT '6',
  `user_last_privmsg` int(11) unsigned NOT NULL DEFAULT '0',
  `user_unread_privmsg` int(4) unsigned NOT NULL DEFAULT '0',
  `user_new_privmsg` int(4) NOT NULL DEFAULT '0',
  `user_lastpost_time` int(11) unsigned NOT NULL DEFAULT '0',
  `user_lastmark` int(11) unsigned NOT NULL DEFAULT '0',
  `user_allow_pm` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `user_allow_viewemail` tinyint(1) NOT NULL DEFAULT '1',
  `user_allow_massemail` tinyint(1) NOT NULL DEFAULT '1',
  `user_posts` int(10) NOT NULL DEFAULT '0',
  `user_notify` int(1) NOT NULL DEFAULT '0',
  `user_topic_show_days` smallint(5) unsigned NOT NULL DEFAULT '0',
  `user_topic_sortby_type` varchar(1) COLLATE utf8_bin NOT NULL DEFAULT 't',
  `user_topic_sortby_dir` varchar(1) COLLATE utf8_bin NOT NULL DEFAULT 'd',
  `user_post_show_days` smallint(5) unsigned NOT NULL DEFAULT '0',
  `user_post_sortby_type` varchar(1) COLLATE utf8_bin NOT NULL DEFAULT 't',
  `user_post_sortby_dir` varchar(1) COLLATE utf8_bin NOT NULL DEFAULT 'a',
  `user_notify_pm` tinyint(1) NOT NULL DEFAULT '1',
  `user_notify_type` tinyint(4) NOT NULL DEFAULT '0',
  `user_warnings` tinyint(4) NOT NULL DEFAULT '0',
  `user_last_warning` int(11) NOT NULL DEFAULT '0',
  `user_options` int(11) unsigned NOT NULL DEFAULT '895',
  `user_dateformat` varchar(30) COLLATE utf8_bin NOT NULL DEFAULT 'd M Y H:i',
  `user_dst` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `passkey` (`passkey`),
  KEY `lastip` (`lastip`),
  KEY `lasthost` (`lasthost`),
  KEY `date` (`regdate`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=0 ;

--
-- Dumping data for table `torrent_users`
--

INSERT INTO `torrent_users` (`id`, `username`, `clean_username`, `name`, `email`, `regdate`, `password`, `theme`, `language`, `avatar`, `avatar_type`, `avatar_ht`, `avatar_wt`, `accept_mail`, `mass_mail`, `pm_notify`, `pm_popup`, `aim`, `icq`, `jabber`, `msn`, `skype`, `yahoo`, `level`, `can_do`, `user_rank`, `user_type`, `user_permissions`, `user_colour`, `user_perm_from`, `uploaded`, `downloaded`, `active`, `ban`, `act_key`, `passkey`, `newpasswd`, `newemail`, `mail_key`, `banreason`, `lastip`, `lasthost`, `lastlogin`, `rem`, `modcomment`, `warned`, `warn_kapta`, `warn_hossz`, `invited_by`, `invitees`, `country`, `seedbox`, `tzoffset`, `can_shout`, `Show_online`, `invites`, `invitedate`, `seedbonus`, `donator`, `donated`, `dondate`, `torrent_per_page`, `donator_tell`, `dongift`, `inactwarning`, `inactive_warn_time`, `hitruns`, `HNR_W`, `helper`, `help_able`, `signature`, `bbcode_bitfield`, `bbcode_uid`, `sig_bbcode_bitfield`, `sig_bbcode_uid`, `forumbanned`, `parked`, `disabled`, `disabled_reason`, `birthday`, `client`, `lastpage`, `user_message_rules`, `user_full_folder`, `user_last_privmsg`, `user_unread_privmsg`, `user_new_privmsg`, `user_lastpost_time`, `user_lastmark`, `user_allow_pm`, `user_allow_viewemail`, `user_allow_massemail`, `user_posts`, `user_notify`, `user_topic_show_days`, `user_topic_sortby_type`, `user_topic_sortby_dir`, `user_post_show_days`, `user_post_sortby_type`, `user_post_sortby_dir`, `user_notify_pm`, `user_notify_type`, `user_warnings`, `user_last_warning`, `user_options`, `user_dateformat`, `user_dst`) VALUES
(0, 'GUEST', 'guest', NULL, 'guest@nowhere.com', '2014-12-28 14:55:27', 'bf242c893c1fce6b666976c6a21e213c', NULL, NULL, 'blank.gif', 0, 0, 0, 'no', 'yes', 'true', 'true', NULL, NULL, NULL, NULL, NULL, NULL, 'user', '4', 4, 0, '\nqmls5y000000\nqmls5y000000', '', 0, 0, 0, 1, 0, 'gyV1IPnENNUR6mKi2qAY20cRHfojPmkv', NULL, NULL, NULL, NULL, NULL, 0, '', '0000-00-00 00:00:00', 'no', NULL, 0, 0, 0, 0, '', 0, 0, 0, 'true', 'true', 0, '0000-00-00 00:00:00', '0.0', 'false', '0.0', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00', 0, 0, '0000-00-00 00:00:00', 0, 0, 'false', '', '', '', '', '', '', 'no', 'false', 'false', '', NULL, '', 'index.php', 0, 6, 0, 0, 0, 1458699640, 0, 1, 1, 1, 0, 0, 0, 't', 'd', 0, 't', 'a', 1, 0, 0, 0, 895, 'd M Y H:i', 0);

-- --------------------------------------------------------

--
-- Table structure for table `torrent_user_group`
--

CREATE TABLE IF NOT EXISTS `torrent_user_group` (
  `group_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `user_id` int(20) unsigned NOT NULL DEFAULT '0',
  `group_leader` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `user_pending` tinyint(1) unsigned NOT NULL DEFAULT '1',
  KEY `group_id` (`group_id`),
  KEY `user_id` (`user_id`),
  KEY `group_leader` (`group_leader`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `torrent_user_group`
--


-- --------------------------------------------------------

--
-- Table structure for table `torrent_warnings`
--

CREATE TABLE IF NOT EXISTS `torrent_warnings` (
  `warning_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `post_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `log_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `warning_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`warning_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Dumping data for table `torrent_warnings`
--


-- --------------------------------------------------------

--
-- Table structure for table `torrent_zebra`
--

CREATE TABLE IF NOT EXISTS `torrent_zebra` (
  `user_id` int(20) unsigned NOT NULL DEFAULT '0',
  `zebra_id` int(20) unsigned NOT NULL DEFAULT '0',
  `friend` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `foe` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`zebra_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
