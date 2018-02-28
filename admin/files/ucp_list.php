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
** File ucp_list.php 2018-02-23 14:32:00 Black_Heart
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
class acp_users
{
	var $u_action;

	function main($id, $mode)
	{
		global $config, $db, $db_prefix, $user, $auth, $template, $pmbt_cache, $theme, $vas, $i, $op;
		global $phpbb_root_path, $phpbb_admin_path, $phpEx, $table_prefix,$u_datetime;
		$file_uploads = (@ini_get('file_uploads') || strtolower(@ini_get('file_uploads')) == 'on') ? true : false;

		$this->tpl_name = 'acp_users_list';
		$this->page_title = 'ACP_USER_LIST_' . strtoupper($mode);
		$user->set_lang('ucp',$user->ulanguage);
	}
}
?>