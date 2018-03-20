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
** File upload.php 2018-02-17 14:32:00 Black_Heart
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
$user->set_lang('upload',$user->ulanguage);
$template = new Template();
set_site_var($user->lang['UPLOAD']);
if(!checkaccess("u_upload")){
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $user->lang['GROUP_NO_ACCESS_PAGE'],
				));
				echo $template->fetch('message_body.html');
				close_out();
}
if($user->parked)
{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $user->lang['ACCOUNT_PARKED'],
				));
				echo $template->fetch('message_body.html');
				close_out();
}
if($user->disabled)
{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> sprintf($user->lang['ACCOUNT_DISABLED'], $user->disabled_reason),
				));
				echo $template->fetch('message_body.html');
				close_out();
}
$pop = request_var('pop','');
if($pop == 'smilies')
{
			$form	= request_var('form', '');
			$area	= request_var('area', '');
				$template->assign_vars(array(
					'FORM'			=> $form,
					'AREA'			=> $area,
				));
			$sql = "SELECT * FROM ".$db_prefix."_smiles GROUP BY file ORDER BY id ASC;";
			$smile_res = $db->sql_query($sql);
			$smile_count = 0;
			while ($smile = $db->sql_fetchrow($smile_res))
			{
				$template->assign_block_vars('smilies',array(
				'ID'			=>	$smile["id"],
				'CODE'			=>	$smile["code"],
				'FILE'			=>	$smile["file"],
				'ALT'			=>	$smile["alt"],
				'S_ROW_COUNT'	=>	$smile_count++,
				));
			}
				echo $template->fetch('smilies.html');
				close_out();
}
$op	= request_var('op', ($allow_magnet == 1)? '' : 'torrent');
	$template->assign_vars(array(
		'L_TITLE'					=> $user->lang['UPLOAD'],
		'L_INTRO'					=> $user->lang['INTRO'],
		'L_INTRO_EXP'				=> $user->lang['INTRO_EXP_SEL'],
		'ALLOW_LINK'				=> ($allow_magnet == 1)? true : false,
		'S_MESSAGE'					=> false,
		'S_NOTICE'					=> false,
		'S_ACTION'					=> $op,
	));
		$postback			= request_var('postback', '');
switch ($op) {
        case "torrent": {
                include_once("upload/torrent.php");
                break;
        }
        case "link": {
               if(checkaccess('u_can_add_magnet_links')) include_once("upload/link.php");
                break;
        }
        case "taketorrent": {
                include_once("upload/taketorrent.php");
                break;
        }
        case "takelink": {
               if(checkaccess('u_can_add_magnet_links')) include_once("upload/takelink.php");
                break;
        }
}
echo $template->fetch('upload.html');
close_out();
?>