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
** File gfxgen.php 2018-02-17 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (defined('IN_PMBT'))die ("You can't include this file.");
define("IN_PMBT",true);
require_once("common.php");
			$buffer = ob_get_clean();
			if (function_exists('ob_gzhandler') && !ini_get('zlib.output_compression'))
			ob_start('ob_gzhandler');
			else
			ob_start();
			ob_implicit_flush(0);
$code					= request_var('code', '');
$code = base64_decode($code);
$image = imagecreatefromjpeg("include/code_bg.jpg");
$text_color = imagecolorallocate($image, 80, 80, 80);
header("Content-type: image/jpeg");
imagestring ($image, 5, 12, 2, $code, $text_color);
imagejpeg($image, NULL, 75);
imagedestroy($image);
die();
?>