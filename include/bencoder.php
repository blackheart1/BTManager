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
** File bencoder.php 2018-02-18 14:32:00 joeroberts
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT'))
{
	include_once './../security.php';
	die ();
}
/*
WINDOWS WARNING
ICONV.DLL MUST BE IN C:\WINDOWS\SYSTEM OR
EXTENSION LOADING WILL FAIL
*/
if (phpversion() < 5) {
        if (!extension_loaded("domxml") AND !defined("DOMXML_LOADED")) dl((PHP_OS=="WINNT" OR PHP_OS=="WIN32") ? "include/extensions/domxml.dll" : "include/extensions/domxml.so");
        require_once("include/bencoder/bencoder-domxml.php");
        //define("DOMXML_LOADED",1);
} else {
        require_once("include/bencoder/bencoder-domxml.php");
		require_once'include/extensions/domxml-php4-to-php5.php';
}


?>