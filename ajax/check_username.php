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
** File ajax/check_username.php 2018-09-01 19:32:00 Black_Heart
**
** CHANGES
**
** 2018-08-31 - Amended Masthead
** 2018-09-01 - Set Language
**/

if (!defined('IN_PMBT'))
{
	include_once './../security.php';
	die ("You can't access this file directly");
}

include_once("include/utf/utf_tools.php");
$username = request_var('username', '',true);

if ($username == '')
{
	print("<span style=\"color: red; font-weight: bold;\">" . $user->lang['NO_NAME_SET'] . "</span>");
}
	$username_clean = utf8_strtolower($username);

// Check for that Username

$sql = "SELECT COUNT(`id`) AS num FROM `" . $db_prefix . "_users` WHERE `clean_username` = '" . $db->sql_escape($username_clean) . "'";
$res = $db->sql_query($sql);
$num = $db->sql_fetchrow($res);

if ($num['num'] != 0)
{
	print("<span style=\"color: red; font-weight: bold;\">" . $user->lang['USER_NAME_TAKEN'] . "</span>");
}
else
{
	print("<span style=\"color: #006b3c; font-weight: bold;\">" . $user->lang['USER_NAME_OPEN'] . "</span>");
}

?>