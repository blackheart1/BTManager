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
** File acp_arcade.php 2018-02-23 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT'))
{
	include_once './../security.php';
	die ("You can't access this file directly");
}
				//if (!$user->user) loginrequired("user",true);
				$username = request_var('username', '');
				if( !isset( $username ) || empty( $username ) )
					{
						print("No username specified!");
					}
				// check for that username
				$sql = "SELECT COUNT(`id`) AS num FROM `".$db_prefix."_users` WHERE `username` = '".$db->sql_escape($username)."'";
				$res = $db->sql_query($sql);
				$num = $db->sql_fetchrow($res);
				if( $num['num'] != 0 )
				{
					print("<span style=\"color: red; font-weight: bold;\">Username Taken!</span>");
				}
				else
				{
					print("<span style=\"color: #006b3c; font-weight: bold;\">Username Open!</span>");
				}
?>