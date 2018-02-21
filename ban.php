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
** File ban.php 2018-02-19 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
                header("HTTP/1.0 401 Access Denied");
require_once("common.php");
$template = new Template();
set_site_var($user->lang['BANNED']);
$reson	= request_var('reson', '');
if($reson == '')$reson = $user->lang['UNKNOWN'];
$template->assign_vars(array(
        'S_FOR'            => sprintf($user->lang['BANNED_FOR'],strip_tags($reson)),
));
echo $template->fetch('banned.html');
$db->sql_close();
?>