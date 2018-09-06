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
** File edit_admin_reg_details.php 2018-02-18 14:32:00 joeroberts
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
include_once'include/function_posting.php';
$user->set_lang('ucp',$user->ulanguage);
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
$modcomment											= utf8_normalize_nfc(request_var('modcomment', '',true));
$group											= request_var('group', '');
$level											= request_var('level', '');
$warned											= request_var('warned', '');
$warnlength											= request_var('warnlength', '');
$warnpm											= request_var('warnpm', '');
$up											= request_var('up', '');
$down											= request_var('down', '');
$seed											= request_var('seed', '');
$invit											= request_var('invit', '');
$seedbox											= request_var('seedbox', '');
$helper											=  request_var('helper', '',true);
$help_able											= utf8_normalize_nfc(request_var('help_able', '',true));
$active											= request_var('active', '');
$forumban											= request_var('forumban', '');
$shoutban											= request_var('shoutban', '');
$disable											= request_var('disable', '');
$disable_res											= utf8_normalize_nfc(request_var('disable_res', '',true));
        if (!isset($forumban) OR $forumban == "false") $forumban = "no";
		else
		$forumban = "yes";
        processinput("forumbanned",$forumban);		
        if (!isset($shoutban) OR $shoutban == "false") $shoutban = "false";
		else
		$shoutban = "true";
        processinput("can_shout",$shoutban);		
        if (!isset($disable) OR $disable == "") $disable = "false";
		else
		$disable = $disable;
        processinput("disabled",$disable);		
        processinput("disabled_reason",$disable_res);		
		#make sure user has rites to edit groups
		if(checkaccess("a_edit_level")){
			if (!isset($group) OR $group == "") $group = "";
			if($userrow["can_do"] != $group)
			add_log('admin','LOG_GROUP_CHANGE',username_is($uid),$group);//log group chonge
			processinput("can_do",$group);
			$db->sql_query('DELETE FROM '.$db_prefix."_user_group WHERE user_id = ".$uid);
			$sql = "INSERT INTO `".$db_prefix."_user_group` (`group_id`, `user_id`, `group_leader`, `user_pending`) VALUES ('" . $group . "', '" . $uid . "', '0', '0');";
			$db->sql_query($sql) or btsqlerror($sql);
			group_set_user_default($group,array($uid));
		}
        if (!isset($help_able) OR $help_able == "") $help_able = "";
        processinput("help_able",$help_able);		
        if (!isset($helper) OR $helper == "") $helper = "false";
        processinput("helper",$helper);		
        if (!isset($seedbox) OR $seedbox == "") $seedbox = "0.0.0.0";
		$seedbox = sprintf("%u",ip2long($seedbox));
        processinput("seedbox",$seedbox);
		if (!isset($up) OR $up =="") $up = '0';
		processload("uploaded",$up);
		if (!isset($invit) OR $invit =="") $invit = '0';
		processload("invites",$invit);
		if (!isset($seed) OR $seed =="") $seed = '0';
		processload("seedbonus",$seed);
		if (!isset($down) OR $down =="") $down = '0';
		processload("downloaded",$down);
        if (checkaccess("a_edit_level") AND in_array($level,Array("user","premium","moderator","admin"))) {
		if($userrow["level"] != $level)add_log('admin','LOG_LEVEL_CHANGE',username_is($uid),$level);
		processinput("level",$level);
		}
		$modcommentset = "";
		if (in_array($active,Array("0","1"))) processload("active",$active);
        if ($warnlength != 0) $warned = "yes";
        if ($warn_torol == "yes") $warned = "no";
        if ($warned == "no")
        {
			processload("warned",0);
			processload("warn_kapta",'0');
			processload("warn_hossz",'0');
			$pm_mess = sprintf($user->lang['UCP_WARN_REMOVED_MES'],$user->name);
			system_pm($pm_mess,$user->lang['WARNNING'],$uid,0,true);
			$modcommentset = sprintf($user->lang['WARN_REMOVE_MOD_MESS'],gmdate("Y-m-d H:i:s", time()),$user->name) . "\n";
		}
        if ($warned == "yes")
        {
			if ($warnlength == 604800) $week = '1';
			if ($warnlength == 1209600) $week = '2';
			if ($warnlength == 2419200) $week = '4';
			if ($warnlength == 4838400) $week = '8';
			if ($warnlength > 604800) $weeks = "'s";
			else
			$weeks = "";
			processload("warned",'1');
			processload("warn_kapta",strtotime(gmdate("Y-m-d H:i:s", time())));
			processload("warn_hossz",$warnlength);
			$weekset = sprintf($user->lang['UCP_WARN_WEEK'],$week,$weeks);
			$pm_mess = sprintf($user->lang['UCP_WARNED_MES'],$user->name, $weekset, $warnpm);
			//die($pm_mess);
			system_pm($pm_mess,$user->lang['WARNNING'],$uid,0,true);
			$modcommentset =  sprintf($user->lang['WARN_MOD_MES'],gmdate("Y-m-d H:i:s", time()),$weekset,$user->name,$warnpm) . "\n";
		}
		$modcomment = $modcommentset.$modcomment;
        processinput("modcomment",$modcomment);
                $sql = "UPDATE ".$db_prefix."_users SET ";
                for ($i = 0; $i < count($sqlfields); $i++) $sql .= $sqlfields[$i] ." = ".$sqlvalues[$i].", ";
                $sql .= "act_key = ".(($admin_mode) ? "act_key" : "'".RandomAlpha(32)."'")." WHERE id = '".$uid."';"; //useless but needed to terminate SQL without a comma
                if (!$db->sql_query($sql)) btsqlerror($sql);
                if (!$admin_mode) userlogin($uname,$btuser); //SQL is executed, cookie is invalid and getusername() function returns nothing, so it must be called earlier
                                $template->assign_vars(array(
										'S_REFRESH'				=> true,
										'META' 				  	=> '<meta http-equiv="refresh" content="5;url=' . $siteurl . '/user.php?op=editprofile' . ((!$admin_mode) ? '' : "&amp;id=" .$uid  ) . '&amp;action=profile&amp;mode=admin_reg_details" />',
										'S_ERROR_HEADER'		=>$user->lang['UPDATED'],
                                        'S_ERROR_MESS'			=>($admin_mode)? $user->lang['USE_PROFILE_UPDATED'] : $user->lang['PROFILE_UPDATED'],
                                ));
				//trigger_error($message);
                echo $template->fetch('error.html');
				die();
?>