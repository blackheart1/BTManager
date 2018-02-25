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
** File signature.php 2018-02-18 14:32:00 joeroberts
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT'))
{
	include_once './../../security.php';
	die ();
}
				include_once('include/function_posting.php');
				include_once('include/message_parser.php');
				include_once('include/class.bbcode.php');
				$signature_parser = new parse_message();
				$signature_parser->message = $userrow["signature"];
				$signature_parser->decode_message($userrow['sig_bbcode_uid']);
$template->assign_vars(array(
		'SIGNATURE'             => $signature_parser->message,
));
?>