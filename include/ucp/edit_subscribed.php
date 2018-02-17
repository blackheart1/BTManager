<?php
/*
*-----------------------------phpMyBitTorrent V 2.0.5--------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
*-------------               http://www.p2pmania.it               -------------*
*------------ Based on the Bit Torrent Protocol made by Bram Cohen ------------*
*-------------              http://www.bittorrent.com             -------------*
*------------------------------------------------------------------------------*
*------------------------------------------------------------------------------*
*--   This program is free software; you can redistribute it and/or modify   --*
*--   it under the terms of the GNU General Public License as published by   --*
*--   the Free Software Foundation; either version 2 of the License, or      --*
*--   (at your option) any later version.                                    --*
*--                                                                          --*
*--   This program is distributed in the hope that it will be useful,        --*
*--   but WITHOUT ANY WARRANTY; without even the implied warranty of         --*
*--   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the          --*
*--   GNU General Public License for more details.                           --*
*--                                                                          --*
*--   You should have received a copy of the GNU General Public License      --*
*--   along with this program; if not, write to the Free Software            --*
*-- Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA --*
*--                                                                          --*
*------------------------------------------------------------------------------*
*------              ©2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-----------------  Thursday, November 04, 2010 9:05 PM   ---------------------*
*/
/**
*
* @package phpMyBitTorrent
* @version $Id: edit_subscribed.php 1 2010-11-04 00:22:48Z joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
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
								        'S_ERROR_HEADER'          =>bterror_sub,
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
								        'S_ERROR_HEADER'          =>bterror_sub,
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
								        'S_ERROR_HEADER'          =>bterror_sub,
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