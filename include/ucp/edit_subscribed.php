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
** File edit_subscribed.php 2018-02-18 14:32:00 joeroberts
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
	$to                                    = request_var('to', array(0));
	$f                                     = request_var('f', array(0));
	$t                                     = request_var('t', array(0));
	$hidden = '';
	if(isset($to) && count($to) >=1){
		foreach($to as $key => $value)
		$hidden .= build_hidden_fields(array("to[".$key."]" 	=> 1));
	}
	if(isset($f) && count($f) >=1){
		foreach($f as $key => $value)
		$hidden .= build_hidden_fields(array("f[".$key."]" 	=> 1));
	}
	if(isset($t) && count($t) >=1){
		foreach($t as $key => $value)
		$hidden .= build_hidden_fields(array("t[".$key."]" 	=> 1));
	}
	$hidden .= build_hidden_fields(array(
	"op"		=> "editprofile",
	"take_edit"		=> "1",
	"check" 		=> 1,
	"action" 		=> 'overview',
	"delete"		=> 1,
	"mode"			=> 'subscribed'
	));
if(isset($check))$check=true;
else
$check = false;
			confirm_box($check, 'bt_fm_del_subs', $hidden,'confirm_body.html','');
    if((!isset($to) OR !count($to) >=1) AND (!isset($t) OR !count($t) >=1) AND (!isset($f) OR !count($f) >=1))
	{
              set_site_var('- '.$user->lang['USER_CPANNEL'].' - '.$user->lang['BT_ERROR']);
                                $template->assign_vars(array(
								        'S_ERROR_HEADER'          =>$user->lang['DELETE_DRAFTS'],
                                        'S_ERROR_MESS'            => $user->lang['NO_DRAFTS_SET'],
                                ));
             echo $template->fetch('error.html');
             @include_once("include/cleanup.php");
             ob_end_flush();
             die();
     }
	 if(isset($to) AND count($to) >=1){
	    	foreach($to as $sub=> $value){
				if(!is_numeric($value)){
              		set_site_var('- '.$user->lang['USER_CPANNEL'].' - '.$user->lang['BT_ERROR']);
                                $template->assign_vars(array(
								        'S_ERROR_HEADER'          => $user->lang['BT_ERROR'],
                                        'S_ERROR_MESS'            => $user->lang['ERROR_SUBJECT_NUBER'],
                                ));
             		echo $template->fetch('error.html');
             		@include_once("include/cleanup.php");
             		ob_end_flush();
             		die();
				}
				$db->sql_query("DELETE FROM `".$db_prefix."_comments_notify` WHERE `torrent` = $sub AND `user` = $uid LIMIT 1");
            }
	 }
	 if(isset($t) AND count($t) >=1){
	    	foreach($t as $sub=> $value){
				if(!is_numeric($value)){
              		set_site_var('- '.$user->lang['USER_CPANNEL'].' - '.$user->lang['BT_ERROR']);
                                $template->assign_vars(array(
								        'S_ERROR_HEADER'          => $user->lang['BT_ERROR'],
                                        'S_ERROR_MESS'            => $user->lang['ERROR_SUBJECT_NUBER'],
                                ));
             		echo $template->fetch('error.html');
             		@include_once("include/cleanup.php");
             		ob_end_flush();
             		die();
				}
				$db->sql_query("DELETE FROM `".$db_prefix."_bookmarks` WHERE `topic_id` = $sub AND `user_id` = $uid LIMIT 1");
            }
	 }
	 if(isset($f) AND count($f) >=1){
	    	foreach($f as $sub=> $value){
				if(!is_numeric($value)){
              		set_site_var('- '.$user->lang['USER_CPANNEL'].' - '.$user->lang['BT_ERROR']);
                                $template->assign_vars(array(
								        'S_ERROR_HEADER'          => $user->lang['BT_ERROR'],
                                        'S_ERROR_MESS'            => $user->lang['ERROR_SUBJECT_NUBER'],
                                ));
             		echo $template->fetch('error.html');
             		@include_once("include/cleanup.php");
             		ob_end_flush();
             		die();
				}
				$db->sql_query("DELETE FROM `".$db_prefix."_forums_watch` WHERE `forum_id` = $sub AND `user_id` = $uid LIMIT 1");
            }
	 }
?>