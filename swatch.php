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
** File swatch.php 2018-02-17 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
$startpagetime = microtime();
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
require_once("common.php");
require_once("include/torrent_functions.php");
$template = new Template();

$form = request_var('form', '');
$name = request_var('name', '');

// We validate form and name here, only id/class allowed
$form = (!preg_match('/^[a-z0-9_-]+$/i', $form)) ? '' : $form;
$name = (!preg_match('/^[a-z0-9_-]+$/i', $name)) ? '' : $name;

$template->assign_vars(array(
	'OPENER'		=> $form,
	'NAME'			=> $name,
	'T_IMAGES_PATH'	=> "./images/",

	'S_USER_LANG'			=> $user->lang['USER_LANG'],
	'S_CONTENT_DIRECTION'	=> $user->lang['DIRECTION'],
	'S_CONTENT_ENCODING'	=> 'UTF-8',
));

echo $template->fetch('colour_swatch.html');
?>