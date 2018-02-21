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
** File redirect.php 2018-02-17 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
require_once("common.php");
include_once('include/function_posting.php');
$template = new Template();
  $url = '';
  while (list($var,$val) = each($_GET))
    $url .= "&$var=$val";
$i = strpos($url, "&url=");
if ($i !== false)
	$url = substr($url, $i + 5);
	$title = getMetaTitle($url);
								set_site_var($user->lang['SUCCESS']);
				meta_refresh(5,strip_tags($url) );
				$template->assign_vars(array(
					'S_SUCCESS'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['REDIRECT'],
					'MESSAGE'			=> sprintf($user->lang['SUCCESS'],$title),
				));
				echo $template->fetch('message_body.html');
				close_out();
?>