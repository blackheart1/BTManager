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
** File bonus_transfer.php 2018-02-19 14:32:00 Black_Heart
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
$user->set_lang('profile',$user->ulanguage);
$template = new Template();
set_site_var($user->lang['BONUS_TRAN_TITTLE']);
if(!$user->user || $user->id==0)loginrequired("user", true);
$action	= request_var('do', '');
if($action)
{
	switch ($action)
	{
		case 'take_trans':
			$iduser=$_GET["iduser"];
			$sql="SELECT * FROM ".$db_prefix."_users WHERE id ='$iduser';";
			$res = $db->sql_query($sql)or btsqlerror($sql);
			$rowuser=$db->sql_fetchrow($res);
			$username	= request_var('username', '');
			$bonus	= 0 + request_var('bonus', '0');
			//die($username);
			$why	= request_var('why', '');
			$anonym	= request_var('anonym', '');
			$error = array();
			if($username=="")$error[] = $user->lang['NO_NAME_SET'];
			if($why=="")$error[] = $user->lang['NO_REASON_GIVEN'];
			if ($bonus <=0)$error[] = $user->lang['ERROR_NOT_NUMBER'];
			if($bonus > $user->seedbonus)$error[] = $user->lang['BONUS_TRAN_TO_MUCH'];
			if($user->name == $username || $user->nick == $username)$error[] = $user->lang['BONUS_TO_SELF'];
			$kapo2 = getuser($username);
			$kuldo = $user->id;
			if ($kapo2 <= 0)$error[] = $user->lang['NO_SUCH_USER'] . " " . $username;
			if (count($error) > 0){
				$template->assign_vars(array(
					'S_NOTICE'			=> true,
					'S_ERROR'			=> true,
					'L_MESSAGE'			=> $user->lang['BT_ERROR'],
					'S_ERROR_MESS'			=> implode("<br />",$error),
				));
			break;
			 }
			 //die($anonym);
			$db->sql_query("UPDATE ".$db_prefix."_users SET seedbonus = seedbonus + $bonus WHERE id = '$kapo2'") or sqlerr(__FILE__, __LINE__);
			$db->sql_query("UPDATE ".$db_prefix."_users SET seedbonus = seedbonus - $bonus WHERE id = '$kuldo'") or sqlerr(__FILE__, __LINE__);
			include_once('include/function_posting.php');
			if(!$why)$why=$user->lang['NO_REASON_GIVEN'];
			if ($anonym != 'anonym') {
				//pm message text here
				$from = true;
				$msg = sprintf($user->lang['BONUS_TRANSFER_PM'],$user->name,$bonus,$why);
			}else{
				$from = false;
				$msg = sprintf($user->lang['BONUS_TRANSFER_PM'],$user->lang['UNKNOWN'],$bonus,$why);
			}
			system_pm($msg,$user->lang['BONUS_TRANSFER_PM_SUB'],$kapo2,0,$from);
				$template->assign_vars(array(
					'S_NOTICE'			=> true,
					'S_ERROR'			=> false,
					'L_MESSAGE'			=> $user->lang['SUCCESS'],
					'S_ERROR_MESS'		=> sprintf($user->lang['BONUS_TRANSFERD'],$username),
				));
		break;
	}
}
				$template->assign_vars(array(
					'L_TITTLE'			=>	$user->lang['BONUS_TRAN_TITTLE'],
					'L_TITTLE_EXP'		=>	$user->lang['BONUS_TRAN_TITTLE_EXP'],
					'ACTION'			=>	'donate_bonus',
					'U_ACTION'			=>	'./bonus_transfer.' . $phpEx,
					'HIDDEN'			=>	build_hidden_fields(array('do'=>'take_trans')),
				));
			echo $template->fetch('ucp_bonus.html');
			close_out();
?>