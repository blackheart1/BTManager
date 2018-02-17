<?php
/*
*----------------------------phpMyBitTorrent V 3.0.0---------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
*-------------------   And Joe Robertson (aka joeroberts)   -------------------*
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
*------              ©2010 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*--------------------   Sunday, May 17, 2009 1:05 AM   ------------------------*
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 settings.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
include_once('include/user.functions.php');
$user->set_lang('admin/user_add',$user->ulanguage);
$saved = NULL;
        $do					= request_var('do', '');
$sql = 'SELECT `group_id`, `group_founder_manage` FROM `'.$db_prefix.'_level_settings` WHERE `group_default` = 1 LIMIT 1 '; 
$res = $db->sql_query($sql);
$default_group = $db->sql_fetchrow($res);
	if($do =="take_user_add")
	{
	        $username					= request_var('username', '');
	        $password					= request_var('password', '');
	        $cpassword					= request_var('cpassword', '');
	        $email						= request_var('email', '');
	        $name						= request_var('nick', '');
	        $upload						= request_var('upload', '0');
	        $download					= request_var('download', '0');
	        $seed						= request_var('seed', '0.0');
	        $invite						= request_var('invite', '0');
	        $active						= request_var('active', 0);
	        $group						= request_var('group', $default_group[0]);
	        $level						= request_var('level', 1);
			$lev_sel = array('user','user','premium','moderator','admin');
			if($level==4 AND !$user->admin) $level = ($level -1);
				$errmsg = Array();
		        $sqlfields = array();
		        $sqlvalues = array();
		$sql = 'SELECT `group_id`, `group_founder_manage` FROM `'.$db_prefix.'_level_settings` WHERE `group_id` = ' . $group . ' LIMIT 1 '; 
		$res = $db->sql_query($sql);
		$group_founder = $db->sql_fetchrow($res);
		if($group_founder == '1')$user_type = '3';
		else
		$user_type = '0';
		$sqlfields[] = $user_type;
		$sqlvalues[] = 'user_type';
		$sqlfields[] = $lev_sel[$level];
		$sqlvalues[] = 'level';
		if ($username == "")
		{
        	$errmsg[] = $user->lang['ERR_NO_NAME'];
		}
		else
		{
			$sqlfields[] = $db->sql_escape($username);
			$sqlvalues[] = "username";
			$sqlfields[] = $db->sql_escape(strtolower($username));
			$sqlvalues[] = "clean_username";
		}
		if ($password == "" OR $password != $cpassword)
		{
        	$errmsg[] = $user->lang['ERR_NO_PASS'];
		}
		else
		{
			$sqlfields[] = md5($password);
			$sqlvalues[] = "password";
		}
		if ($email == "")
		{
        	$errmsg[] = $user->lang['ERR_EMAIL_NOT_VALID'];
		}
		else
		{
			$sqlfields[] = $email;
			$sqlvalues[] = "email";
		}
		if (count($errmsg) == 0) 
		{
        	if ($db->sql_numrows($db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE username ='".$db->sql_escape($username)."';")) != 0)
                $errmsg[] = $user->lang['ERR_USER_ACSEST'];
        	if (!is_email($email))
                $errmsg[] = $user->lang['ERR_EMAIL_NOT_VALID'];
        	if ($db->sql_numrows($db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE email ='".$db->sql_escape($email)."';")) != 0)
                $errmsg[] = $user->lang['ERR_EMAIL_ACSEST'];
        	if (strlen($password) < 5)
                $errmsg[] = $user->lang['ERR_PASS_TO_SHORT'];
        	if ($password != $cpassword)
                $errmsg[] = $user->lang['ERR_PASS_NOT_MATCH'];
		}
		if (count($errmsg) != 0)
		{
				unset($sqlfields,$sqlvalues);
                                $template->assign_vars(array(
								        'S_USER_NOTICE'         => false,
								        'MESSAGE_TITLE'     	=> $user->lang['ERROR'],
                                        'MESSAGE_TEXT'          => $user->lang['ERR_FORM_NOT_SET'] . implode("<br />", $errmsg) . back_link($u_action),
                                ));
						echo $template->fetch('admin/message_body.html');
						close_out();
		}
		if($force_passkey){
                do {
                        $passkey = RandomAlpha(32);
                        //Check whether passkey already exists
                        $sql = "SELECT passkey FROM ".$db_prefix."_users WHERE passkey = '".$passkey."';";
                        $res = $db->sql_query($sql);
                        $cnt = $db->sql_numrows($sql);
                        $db->sql_freeresult($res);
                } while ($cnt > 0);
			$sqlfields[] = $passkey;
			$sqlvalues[] = "passkey";
		}
		$act_key = RandomAlpha(32);
			$sqlfields[] = $act_key;
			$sqlvalues[] = "act_key";
		if (!$name == "")
		{
			$sqlfields[] = $name;
			$sqlvalues[] = "name";
		}
		if (is_numeric($upload))
		{
			$sqlfields[] = $upload;
			$sqlvalues[] = "uploaded";
		}
		if (is_numeric($download))
		{
			$sqlfields[] = $download;
			$sqlvalues[] = "downloaded";
		}
			$sqlfields[] = $group;
			$sqlvalues[] = "can_do";
		if (is_numeric($seed))
		{
			$sqlfields[] = $seed;
			$sqlvalues[] = "seedbonus";
		}
		if (is_numeric($invite))
		{
			$sqlfields[] = $invite;
			$sqlvalues[] = "invites";
		}

		if ($active == "0")$active = '0';
		else
		$active = '1';
			$sqlfields[] = $active;
			$sqlvalues[] = "active";
		if ($active == '0')$activate = sprintf($user->lang['ACTIVATE_LINK'],$siteurl.'/user.php?op=confirm&username=' . $username . '&act_key=' . md5($act_key));
		else
		$activate = ' ';
		$sql = "INSERT INTO ".$db_prefix."_users (".implode(", ",$sqlvalues).", regdate) VALUES ('".implode("', '",$sqlfields)."', NOW());";
		$db->sql_query($sql) or btsqlerror($sql);
		$new_id = $db->sql_nextid();
		$sql = "INSERT INTO `".$db_prefix."_user_group` (`group_id`, `user_id`, `group_leader`, `user_pending`) VALUES ('" . $group . "', '" . $new_id . "', '0', '0');";
		$db->sql_query($sql) or btsqlerror($sql);
		group_set_user_default($group, array($new_id), false);
				logerror(sprintf($user->lang['ACTION_LOG'], $db->sql_escape($user->mame), $db->sql_escape($username)),'admin');
                                $template->assign_vars(array(
								        'S_USER_NOTICE'				=> true,
										'S_FORWARD'					=>false,
								        'MESSAGE_TITLE'				=> $user->lang['SUCCESS'],
                                        'MESSAGE_TEXT'				=> sprintf($user->lang['USER_VREATED'],$username, $activate, $db->sql_nextid()) . back_link($u_action),
                                ));
		echo $template->fetch('admin/message_body.html');
		close_out();
}

$s_hidden_fields = build_hidden_fields(array(
'do'		=> 'take_user_add',
));
$level_sel = '';
$level_sel .= '<option  class="sep" value="1">' . $user->lang["USER"] . '</option>';
$level_sel .= '<option  class="sep" value="2">' . $user->lang["PREMIUM_USER"] . '</option>';
$level_sel .= '<option  class="sep" value="3">' . $user->lang["MODERATOR"] . '</option>';
if($user->admin)$level_sel .= '<option  class="sep" value="4">' . $user->lang["ADMINISTRATOR"] . '</option>';
$template->assign_vars(array(
        'L_TITLE'					=> $user->lang["NEW_USER_CREAT"],
        'L_EXPLANE'					=> $user->lang["NEW_USER_CREAT_EXP"],
		'U_ACTION_NEW'				=> $u_action,
		'GROUPS'					=> group_select_options_id($default_group[0], false, false),
		'S_LEVELS'					=>	$level_sel,
		'ACTIVE'					=> '<option  class="sep" value="1">' . $user->lang["YES"] . '</option><option  class="sep" value="0">' . $user->lang["NO"] . '</option>',
		'HIDDEN'					=> $s_hidden_fields,
));
echo $template->fetch('admin/acp_user_add.html');
		close_out();
?>