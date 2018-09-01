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
** File admin_reg_details.php 2018-02-18 14:32:00 joeroberts
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
if((!checkaccess('m_edit_user')) OR (is_founder($id) && !$user->user_type==3)){
	set_site_var('- '.$user->lang['USER_CPANNEL'].' - '.$user->lang['BT_ERROR']);
	meta_refresh('5',$siteurl."/index.php");
			$template->assign_vars(array(
					'S_ERROR_HEADER'          =>$user->lang['ACCESS_DENIED'],
					'S_ERROR_MESS'            => $user->lang['NO_EDIT_PREV'],
			));
	echo $template->fetch('error.html');
	close_out();
}
include 'admin/functions.php';
$hiden = array(
'take_edit'				=> '1',
'action'				=> 'profile',
'op'				=> 'editprofile',
'mode'				=> 'admin_reg_details',
);
$sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.Columns where TABLE_NAME = '".$db_prefix."_levels'
AND COLUMN_NAME NOT IN ('level','name','group_id','group_type','color','group_desc')";
$result = $db->sql_query($sql);
$val = array();
while ($row = $db->sql_fetchrow($result))
{
	$val[] = $row[0];
}
$db->sql_freeresult($result);
$adminlevel = "<select name=\"level\">";
$adminlevel .= "<option ".(($userrow["level"] == "user") ? "selected " :'' )."value=\"user\">".$user->lang['USER']."</option>";
$adminlevel .= "<option ".(($userrow["level"] == "premium") ? "selected " :'' )."value=\"premium\">".$user->lang['G_PREMIUM_USER']."</option>";
$adminlevel .= "<option ".(($userrow["level"] == "moderator") ? "selected " :'' )."value=\"moderator\">".$user->lang['G_MODERATOR']."</option>";
$adminlevel .= "<option ".(($userrow["level"] == "admin") ? "selected " :'' )."value=\"admin\">".$user->lang['G_ADMINISTRATORS']."</option>";
$adminlevel .= "</select>";
$template->assign_vars(array(
		'S_HIDDEN_FIELDS'		=> build_hidden_fields($hiden),
        'CP_MOD_COMENTS'        => $userrow["modcomment"],
		'U_SEEDBOX_IP'          => long2ip($userrow["seedbox"]),
		'U_IS_WARNED'           => ($userrow["warned"]) ? true : false,
		'U_WARNED_TELL'         => ($userrow["warned"]) ? gmdate("Y-m-d H:i:s",($userrow["warn_kapta"]+$userrow["warn_hossz"])) : '',
		'U_ACTIVATED_ACC'       => ($userrow["active"] == "1") ? true : false,
		'U_SITE_HELPER'         => ($userrow['helper'] == 'true') ? true : false,
		'U_FORUM_BANNED'        => ($userrow['forumbanned'] == 'yes') ? true : false,
		'U_SITE_HELP_WITH'      => $userrow["help_able"],
        'CP_TRUEUPLOADED'       => $userrow["uploaded"],
        'CP_TRUEDOWNLOADED'     => $userrow["downloaded"],
        'CP_INVITES'            => $userrow["invites"],
        'CP_SEED_POINTS'        => $userrow["seedbonus"],
        'CP_UUPLOADED'          => mksize($userrow["uploaded"]),
        'CP_UDOWNLOADED'        => mksize($userrow["downloaded"]),
        'CP_URATIO'             => get_u_ratio($userrow["uploaded"], $userrow["downloaded"]),
        'CP_UCOLOR'             => getusercolor($userrow["can_do"]),
		'CP_DISABLED'			=> ($userrow["disabled"] == 'true') ? true : false,
        'CP_DISABLED_REASON'	=> $userrow["disabled_reason"],
        'CP_UCANSHOUT'          => ($userrow["can_shout"] == 'true') ? true : false,
        'CP_UCAN_DO'            => $userrow["can_do"],
        'CP_UGROUP'             => getlevel($userrow["can_do"]),
		'S_GROUP_OPTIONS'	    => selectaccess($al= $userrow["can_do"]),
		'S_SHOW_ACTIVITY'		=> true,
		'A_GROUP'               => group_select_options_id($userrow["can_do"]),
		'A_LEVEL'               => $adminlevel,
));
?>