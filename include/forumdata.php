<?php
/**
**********************
** BTManager v3.0.1 **
**********************
** http://www.btmanager.org/
** https://github.com/blackheart1/BTManager
** http://demo.btmanager.org/index.php
** Licence Info: GPL
** Copyright (C) 2018
** Formerly Known As phpMyBitTorrent
** Created By Antonio Anzivino (aka DJ Echelon)
** And Joe Robertson (aka joeroberts/Black_Heart)
** Project Leaders: Black_Heart, Thor.
** File forumdata.php 2018-02-18 14:32:00 joeroberts
**
** CHANGES
**
** 24-02-18 depricated file
**/
if (!defined('IN_PMBT'))
{
	include_once './../security.php';
	die ();
}
require_once("../../include/configdata.php");
define('TRACKERPX',$db_prefix);
$sql = "SELECT * FROM " . TRACKERPX . "_config LIMIT 1;";

$configquery = $db->sql_query($sql);

if (!$configquery) die($sql."1phpMyBitTorrent not correctly installed! Ensure you have run setup.php or config_default.sql!!");
if (!$row = $db->sql_fetchrow($configquery)) die("2phpMyBitTorrent not correctly installed! Ensure you have run setup.php or config_default.sql!!");
$sql = "SELECT * FROM " . TRACKERPX . "_admin_forum LIMIT 1;";

$configquery = $db->sql_query($sql);

if (!$configquery) die("phpMyBitTorrent not correctly installed! Ensure you have run setup.php or config_default.sql!!");
if (!$row = $db->sql_fetchrow($configquery)) die("phpMyBitTorrent not correctly installed! Ensure you have run setup.php or config_default.sql!!");
//Config parser start
$forumpx = $row["prefix"];
$cookie_name = $row['cookie_name'];
$cookie_domain = $row["cookie_domain"];
$cookie_path = $row["cookie_path"];
$logintime = $row['cookie_time'];
$forumshare = ($row["forum_share"]=="true") ? true : false;
$forumbase = $row["base_folder"];
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$phpbb2_basefile = "phpBB.php";
$activate_phpbb2_forum = true;
$phpbb2_folder = "./";
$auto_post = $row["auto_post_forum"];
$allow_posting = ($row["auto_post"]=="true") ? true : false;
$db->sql_freeresult($configquery);
	if ($forumshare) define('ADMIN_BT_SHARE', true);
define('phpBBBASE',$forumbase);
define('FORUMPRX',$forumpx);
define('PHPBB_ROOT_PATH',$phpbb2_folder);
$phpbb_root_path = $phpbb2_folder;
#Config Parser end
?>
