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
** File donate.php 2018-02-17 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (defined('IN_PMBT'))
{
	die ("You can't include this file");
}
else
{
	define("IN_PMBT",true);
}
require_once("common.php");
$user->set_lang('donate',$user->ulanguage);
$template = new Template();
set_site_var($user->lang['DONATIONS']);
	if($nodonate == "US")$type = "$";
	elseif($nodonate == "EU")$type = "&euro;";
	elseif($nodonate == "UK")$type = "&pound;";
 eval('$page = "' . html_entity_decode($donatepagecontents) . '";');
	$template->assign_vars(array(
					'CURENTSY'			=>	$type,
					'ASKING'			=>	$donateasked,
					'RECEAVED'			=>	$donatein,
					'CONTENT'			=>	$page,
				));
echo $template->fetch('donate.html');
close_out();
?>