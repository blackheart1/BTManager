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
** File mybonus.php 2018-02-17 14:32:00 Black_Heart
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
$user->set_lang('bonous',$user->ulanguage);
$template = new Template();
set_site_var($user->lang['BONUS_TRAN_TITTLE']);
$action				= request_var('action', '');
if(!$user->user || $user->id==0)loginrequired("user", true);
                        $bon = "SELECT active, upload, comment, offer, fill_request, seeding, by_torrent FROM ".$db_prefix."_bonus_points ;";
                        $bonset = $db->sql_query($bon);
                        list ($active, $upload, $comment, $offer, $fill_request, $seeding, $by_torrent) = $db->fetch_array($bonset);
                        $db->sql_freeresult($bonset);
if($by_torrent == 1) $by_torrent = 'POINTS_EACH_TOR';
else
$by_torrent = 'POINTS_TOTAL';
$bonus = $user->seedbonus;
$userid = $user->id;
if($active =='false')
{
	$template->assign_vars(array(
		'S_ERROR'			=> true,
		'S_FORWARD'			=> false,
		'TITTLE_M'			=> $user->lang['BONUS_SYSTEM_CLOSED'],
		'MESSAGE'			=> $user->lang['BONUS_SYSTEM_CLOSED_EXP'],
	));
	echo $template->fetch('message_body.html');
	close_out();
}


$sql = ("SELECT * FROM ".$db_prefix."_bonus order by id");
$res = $db->sql_query($sql);
while ($gets = $db->sql_fetchrow($res))
{
	$template->assign_block_vars('bonus_options',array(
			'ID'				=>	$gets["id"],
			'NAME'				=>	htmlspecialchars($gets["bonusname"]),
			'DESCR'				=>	$gets["description"],
			'POINTS'			=>	$gets["points"],
			'ACTIVE'			=>	(($user->seedbonus >= $gets["points"])? true : false),
			'ART'				=>	$gets['art'],
	));
}

foreach($user->lang['POINTS_OPTION_VAR'] as $var=>$val)
{
	$valid = false;
	$point_for = array();
	if($var == 'A')
	{
		$valid = true;
		$point_for['POINT_FOR'] = sprintf($val,$seeding,$user->lang[$by_torrent]);
	}
	if($var == 'B' AND $upload > 0 )
	{
		$valid = true;
		$point_for['POINT_FOR'] = sprintf($val,$upload);
	}
	if($var == 'C' AND $comment > 0 )
	{
		$valid = true;
		$point_for['POINT_FOR'] = sprintf($val,$comment);
	}
	if($var == 'D' AND $fill_request > 0 )
	{
		$valid = true;
		$point_for['POINT_FOR'] = sprintf($val,$fill_request);
	}
	if($var == 'E' AND $offer > 0 )
	{
		$valid = true;
		$point_for['POINT_FOR'] = sprintf($val,$offer);
	}
	if($valid)
	{
		$template->assign_block_vars('earnby',array('POINT' => $point_for['POINT_FOR'],));
	}
}
/*
echo "<blockquote><p align=left><b>"._btbonus_how_get."</b><br>";
if($seeding > 0)echo str_replace(array("{1}","{2}"),array($seeding,$by_torrent),_btbonus_how1);
if($upload > 0)echo str_replace("{1}",$upload,_btbonus_how2);
if($comment > 0)echo str_replace("{1}",$comment,_btbonus_how3);
if($offer > 0)echo str_replace("{1}",$offer,_btbonus_how4);
if($fill_request > 0)echo str_replace("{1}",$fill_request,_btbonus_how5);
echo "</p></blockquote>";
echo "</td></tr>";
echo "<tr><td><a href=user.php?op=profile&id=$userid>"._btbonus_btp."</a></td></tr>";
echo "</table>";

*/


if ($action == "exchange") {
	$userid				= request_var('userid', 0);
	$option				= request_var('option', '0');
	$points				= request_var('points', 0);
	$bonus				= request_var('bonus', 0);
	$art				= request_var('art', '');
	$seedbonus2=$user->seedbonus-$points;
	$modcomment = $user->modcomment;
	$upload = $user->uploaded;
	$bpoints = $user->seedbonus;
	$sql = ("SELECT * FROM ".$db_prefix."_bonus WHERE id='$option'");
	$res = $db->sql_query($sql);
	$bytes = $db->sql_fetchrow($res);
	$up = $user->uploaded+$bytes['menge'];
	$invites = $user->invites;
	$inv = $invites+$bytes['menge'];
	if($user->seedbonus >= $points) {

    if($art == "traffic") {
          $modcomment = gmdate("Y-m-d") . sprintf($user->lang['POINT_TRADE_MOD_COM']['TRAFIC'],$points,$bytes['menge']) . $modcomment;
           $trupl ="UPDATE ".$db_prefix."_users SET uploaded = '".$up."', seedbonus = '$seedbonus2', modcomment = '" . $db->sql_escape($modcomment) . "' WHERE id = '" . $user->id . "'";
		  $db->sql_query($trupl)or sqlerr($trupl);
				$template->assign_vars(array(
					'S_NOTICE'			=>	true,
					'S_ERROR_MESS'			=>	sprintf($user->lang['EXCHANGE_SUC']['TRAFIC'],$points,$bytes['menge']),
				));
	} elseif($art == "invite") {
          $modcomment = gmdate("Y-m-d") . sprintf($user->lang['POINT_TRADE_MOD_COM']['INVITE'],$points,$bytes['menge']) . $modcomment;
         $complete = $db->sql_query("UPDATE ".$db_prefix."_users SET invites = '".$inv."', seedbonus = '$seedbonus2', modcomment = '" . $db->sql_escape($modcomment) . "' WHERE id = '" . $user->id . "'") or sqlerr(__FILE__, __LINE__);
				$template->assign_vars(array(
					'S_NOTICE'			=>	true,
					'S_ERROR_MESS'			=>	sprintf($user->lang['EXCHANGE_SUC']['INVITE'],$points,$bytes['menge']),
				));
    }
        else {
	$template->assign_vars(array(
		'S_ERROR'			=> true,
		'S_FORWARD'			=> false,
		'TITTLE_M'			=> $user->lang['BT_ERROR'],
		'MESSAGE'			=> $user->lang['NO_VALID_ACTION'],
	));
	echo $template->fetch('message_body.html');
	close_out();
        //echo $user->lang['NO_VALID_ACTION'];
    }

} else {
	$template->assign_vars(array(
		'S_ERROR'			=> true,
		'S_FORWARD'			=> false,
		'TITTLE_M'			=> $user->lang['BT_ERROR'],
		'MESSAGE'			=> $user->lang['NOT_ENOUPH_POINTS'],
	));
	echo $template->fetch('message_body.html');
	close_out();
     // echo $user->lang['NOT_ENOUPH_POINTS'];
      }
}

				$template->assign_vars(array(
					'L_TITTLE'			=>	$user->lang['BONUS_TRAN_TITTLE'],
					'L_TITTLE_EXP'		=>	sprintf($user->lang['BONUS_SYS_EXP'],$user->seedbonus),
					'ACTION'			=>	'use_bon',
					'U_ACTION'			=>	'./bonus_transfer.' . $phpEx,
					'HIDDEN'			=>	build_hidden_fields(array('do'=>'take_trans')),
				));
			echo $template->fetch('ucp_bonus.html');
			close_out();
?>