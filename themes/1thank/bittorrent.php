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
** File bittirrent.php 2018-02-18 14:32:00 joeroberts
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
global $template, $user, $mode, $action, $op, $navoption, $admin_mode, $uid;
							$template->assign_vars(array(
                                        'PRELOAD'            => true,
                                ));
if(isset($uid) && $uid != $user->id)$uid = '&amp;id=' . $uid; else $uid = '';
							$template->assign_block_vars('t_block1',array(
							'L_TITLE'		=> $user->lang['OVERVIEW'],
							'S_SELECTED'	=> (($action == 'overview')?true : false),
							'U_TITLE'		=> 'user.php?op=editprofile' . $uid . '&amp;action=overview&amp;mode=front',));
if ($action == 'overview')
{
							$template->assign_block_vars('t_block2',array(
							'L_TITLE'		=> $user->lang['FRONT_PAGE'],
							'S_SELECTED'	=> (($mode == 'front')?true : false),
							'U_TITLE'		=> 'user.php?op=editprofile' . $uid . '&amp;action=overview&amp;mode=front',));
							$template->assign_block_vars('t_block2',array(
							'L_TITLE'		=> $user->lang['MANAGE_SUBS'],
							'S_SELECTED'	=> (($mode == 'subscribed')?true : false),
							'U_TITLE'		=> 'user.php?op=editprofile' . $uid . '&amp;action=overview&amp;mode=subscribed',));
							$template->assign_block_vars('t_block2',array(
							'L_TITLE'		=> $user->lang['MANAGE_DRAFTS'],
							'S_SELECTED'	=> (($mode == 'drafts')?true : false),
							'U_TITLE'		=> 'user.php?op=editprofile' . $uid . '&amp;action=overview&amp;mode=drafts',));
							$template->assign_block_vars('t_block2',array(
							'L_TITLE'		=> $user->lang['MANAGE_ATTACHMENTS'],
							'S_SELECTED'	=> (($mode == 'attachments')?true : false),
							'U_TITLE'		=> 'user.php?op=editprofile' . $uid . '&amp;action=overview&amp;mode=attachments',));
}
							$template->assign_block_vars('t_block1',array(
							'L_TITLE'		=> $user->lang['PROFILE'],
							'S_SELECTED'	=> (($action == 'profile')?true : false),
							'U_TITLE'		=> 'user.php?op=editprofile' . $uid . '&amp;action=profile&amp;mode=profile_info',));
if ($action == 'profile')
{
							$template->assign_block_vars('t_block2',array(
							'L_TITLE'		=> $user->lang['EDIT_PROFILE'],
							'S_SELECTED'	=> (($mode == 'profile_info')?true : false),
							'U_TITLE'		=> 'user.php?op=editprofile' . $uid . '&amp;action=profile&amp;mode=profile_info',));
							$template->assign_block_vars('t_block2',array(
							'L_TITLE'		=> $user->lang['EDIT_SIGNATURE'],
							'S_SELECTED'	=> (($mode == 'signature')?true : false),
							'U_TITLE'		=> 'user.php?op=editprofile' . $uid . '&amp;action=profile&amp;mode=signature',));
							$template->assign_block_vars('t_block2',array(
							'L_TITLE'		=> $user->lang['EDIT_AVATAR'],
							'S_SELECTED'	=> (($mode == 'avatar')?true : false),
							'U_TITLE'		=> 'user.php?op=editprofile' . $uid . '&amp;action=profile&amp;mode=avatar',));
							$template->assign_block_vars('t_block2',array(
							'L_TITLE'		=> $user->lang['EDIT_SETTINGS'],
							'S_SELECTED'	=> (($mode == 'reg_details')?true : false),
							'U_TITLE'		=> 'user.php?op=editprofile' . $uid . '&amp;action=profile&amp;mode=reg_details',));
							if($admin_mode)
							{
								$template->assign_block_vars('t_block2',array(
								'L_TITLE'		=> $user->lang['EDIT_ADMIN_SETTINGS'],
								'S_SELECTED'	=> (($mode == 'admin_reg_details')?true : false),
								'U_TITLE'		=> 'user.php?op=editprofile' . $uid . '&amp;action=profile&amp;mode=admin_reg_details',));
							}
}
							$template->assign_block_vars('t_block1',array(
							'L_TITLE'		=> $user->lang['BOARD_PREFS'],
							'S_SELECTED'	=> (($action == 'preferences')?true : false),
							'U_TITLE'		=> 'user.php?op=editprofile' . $uid . '&amp;action=preferences&amp;mode=personal',));
if ($action == 'preferences')
{
							$template->assign_block_vars('t_block2',array(
							'L_TITLE'		=> $user->lang['EDIT_GLOBAL_SETTINGS'],
							'S_SELECTED'	=> (($mode == 'personal')?true : false),
							'U_TITLE'		=> 'user.php?op=editprofile' . $uid . '&amp;action=preferences&amp;mode=personal',));
}
if($uid == '')
{
							$template->assign_block_vars('t_block1',array(
							'L_TITLE'		=> $user->lang['_PRIVATE_MESSAGE'],
							'S_SELECTED'	=> $navoption,
							'U_TITLE'		=> 'pm.php?op=folder&i=0',));
if($navoption)
{
							$template->assign_block_vars('t_block2',array(
							'L_TITLE'		=> $user->lang['UCP_PM_COMPOSE'],
							'S_SELECTED'	=> (($op == 'send')?true : false),
							'U_TITLE'		=> 'pm.php?op=send',));
							$template->assign_block_vars('t_block2',array(
							'L_TITLE'		=> $user->lang['UCP_PM_DRAFTS'],
							'S_SELECTED'	=> (($op == 'drafts')?true : false),
							'U_TITLE'		=> 'pm.php?op=drafts',));
							$template->assign_block_vars('t_block2',array(
							'L_TITLE'		=> $user->lang['FOLDER_OPTIONS'],
							'S_SELECTED'	=> (($op == 'options')?true : false),
							'U_TITLE'		=> 'pm.php?op=options',));
}
}
							$template->assign_block_vars('t_block1',array(
							'L_TITLE'		=> $user->lang['FRIEND_FOE'],
							'S_SELECTED'	=> (($action == 'friends')?true : false),
							'U_TITLE'		=> 'user.php?op=editprofile' . $uid . '&amp;action=friends&mode=friends',));
if ($action == 'friends')
{
							$template->assign_block_vars('t_block2',array(
							'L_TITLE'		=> $user->lang['MANAGE_FRIENDS'],
							'S_SELECTED'	=> (($mode == 'friends')?true : false),
							'U_TITLE'		=> 'user.php?op=editprofile' . $uid . '&amp;action=friends&amp;mode=friends',));
							$template->assign_block_vars('t_block2',array(
							'L_TITLE'		=> $user->lang['MANAGE_FOES'],
							'S_SELECTED'	=> (($mode == 'foes')?true : false),
							'U_TITLE'		=> 'user.php?op=editprofile' . $uid . '&amp;action=friends&amp;mode=foes',));
}
?>