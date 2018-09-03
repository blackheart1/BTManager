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
** File bbcode.php 2018-02-17 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT'))
{
	include_once './../../security.php';
	die ("You can't access this file directly");
}
include_once'include/class.bbcode.php';
$user->set_lang('admin/acp_bbcode',$user->ulanguage);
	$template->assign_vars(array(
		'ICON_EDIT'					=> '<img src="themes/' . $themne . '/pics/edit.gif" alt="Edit" title="Edit" border="0">',
		'ICON_DELETE'				=> '<img src="themes/' . $themne . '/pics/drop.gif" alt="Delete" title="Delete" border="0">',
		'ACP_BBCODES'				=> 'BBCodes',
));
$bbcode  =  new acp_bbcodes();
$bbcode->u_action = $siteurl . '/admin.php?i=staff&op=bbcode';
$bbcode->main('1','edit');
echo $template->fetch('admin/acp_bbcodes.html');
?>