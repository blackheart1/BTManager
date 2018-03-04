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
** File bans.php 2018-02-17 14:32:00 Black_Heart
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
$user->set_lang('admin/bans',$user->ulanguage);
		$user->set_lang('ban',$user->ulanguage);
		$user->set_lang('admin/users',$user->ulanguage);
		$mode = request_var('mode', 'user');
							$template->assign_block_vars('l_block1.l_block2',array(
							'L_TITLE' => $user->lang['ACP_BAN'],
							'S_SELECTED'	=> true,
							'U_TITLE'		=> '1',));
							$template->assign_block_vars('l_block1.l_block2.l_block3',array(
							'S_SELECTED'	=> ('user' ==$mode)? true:false,
							'IMG' => '',
							'L_TITLE' => $user->lang['ACP_BAN_USERNAMES'],
							'U_TITLE' => append_sid("{$siteurl}/admin.$phpEx", 'i=userinfo&amp;op=bans&amp;mode=user'),
							));
							$template->assign_block_vars('l_block1.l_block2.l_block3',array(
							'S_SELECTED'	=> ('ip' ==$mode)? true:false,
							'IMG' => '',
							'L_TITLE' => $user->lang['ACP_BAN_IPS'],
							'U_TITLE' => append_sid("{$siteurl}/admin.$phpEx", 'i=userinfo&amp;op=bans&amp;mode=ip'),
							));
							$template->assign_block_vars('l_block1.l_block2.l_block3',array(
							'S_SELECTED'	=> ('email' ==$mode)? true:false,
							'IMG' => '',
							'L_TITLE' => $user->lang['ACP_BAN_EMAILS'],
							'U_TITLE' => append_sid("{$siteurl}/admin.$phpEx", 'i=userinfo&amp;op=bans&amp;mode=email'),
							));
		include_once('include/message_parser.php');
		include_once('include/class.bbcode.php');
		include_once($phpbb_root_path . 'include/user.functions.' . $phpEx);
		include_once($phpbb_root_path . 'include/acp/acp_ban.' . $phpEx);
	include_once($phpbb_root_path . 'include/modules.' . $phpEx);
	$module = new acp_ban();
	$module->module =  'acp_ban';
	$module->u_action =  append_sid("{$siteurl}/admin.$phpEx", 'i=userinfo&amp;op=bans&amp;mode=' . $mode);
	$module->main('',$mode);
	//die($module->tpl_name);
	echo $template->fetch('admin/' . $module->tpl_name . '.html');
	close_out();
$is_edituser = false;
$is_edit = false;
$banedit_ip = Array("ipstart"=>"","ipend"=>"","reason"=>"");
$banedit_user = Array("username" => "", "banreason" => "");
$op = request_var('op', '0');
$uid = request_var('uid', '0');
$id = request_var('id', '0');
$postback_ip = request_var('postback_ip', '');
$username = request_var('username', '');
$reason_ip = request_var('reason_ip', '',true);
$reason_user = request_var('reason_user', '',true);
$ipstart = @sprintf("%u",ip2long(request_var('startip', '')));
$ipend = @sprintf("%u",ip2long(request_var('endip', '')));
$template->assign_vars(array(
'L_TITLE'				=> $user->lang['MAIN_TITLE'],
'L_TITLE_EXPLAIN'		=> $user->lang['MAIN_TITLE_EXP'],
'U_ACTION'			=> 'admin.php',
));
if(!checkaccess("m_banusers"))
{
bterror($user->lang['GROUP_NO_ACCESS_PAGE'],$user->lang['BT_ERROR'],true);
}
switch ($op) {
        case "addban": {
                if (isset($postback_ip) AND !$postback_ip == '0') { //Ban IP
                        if ($ipstart < 0 OR $ipend < 0) { //ip2long returns < 0 if input is invalid
                                bterror(_admbaninvalidip,_admban,false);
                                break;
                        }
                        $sql = "INSERT INTO ".$db_prefix."_bans (ipstart, ipend, reason) VALUES ('".$ipstart."', '".$ipend."', '".$reason_ip."');";
                        $db->sql_query($sql) or btsqlerror($sql);
                } else { //Ban User
                        $sql = "SELECT ban FROM ".$db_prefix."_users WHERE username = '".$db->sql_escape(utf8_strtolower($username))."' LIMIT 1;";
                        $res = $db->sql_query($sql);
                        if ($db->sql_numrows($res) < 1) {
                                //echo $sql;
                                bterror(_admbanusernoexist,_admban,false);
                                break;
                        }
                        $db->sql_freeresult($res);
                        $sql = "UPDATE ".$db_prefix."_users SET ban = 1, banreason = '".strip_tags($db->sql_escape($reason_user))."' WHERE username = '".$db->sql_escape(utf8_strtolower($username))."';";
                        $db->sql_query($sql) or btsqlerror($sql);
                }
                break;
        }
        case "editban": {
//				$uid = request_var('uid', 0);
                /*
                You can 'edit' only IP ranges.
                Even if editing a user ban has sense, because you may just want to change the ban reason,
                for now you have to unban and re-ban the user manually
                */
                if (!isset($id) OR !is_numeric($id))
				{
					 if (!isset($uid) OR !is_numeric($uid))break;
				}
                if (isset($uid) AND is_numeric($uid))
				{
					if(is_founder(getlevel_name($uid)) && !is_founder($user->group))
					{
						bterror($user->lang['USER_NOT_EDIT_ABL_BYCLASS'],$user->lang['BT_ERROR'],true);
					}
						$is_edituser = true;
                        $sql = "SELECT * FROM ".$db_prefix."_users WHERE id='".$uid."' LIMIT 1;";
                        $res = $db->sql_query($sql);
                        if ($db->sql_numrows($res) < 1) $is_edituser = false;
                        else $banedit_user = $db->sql_fetchrow($res);
                        $db->sql_freeresult($res);
				}
               if (!isset($postback_ip)) {
                        $is_edit = true;
                        $sql = "SELECT * FROM ".$db_prefix."_bans WHERE ban_id='".$id."' LIMIT 1;";
                        $res = $db->sql_query($sql);
                        if ($db->sql_numrows($res) < 1) $is_edit = false;
                        else $banedit_ip = $db->sql_fetchrow($res);
                        $db->sql_freeresult($res);
						print_r($banedit_ip);
                } elseif (isset($postback_ip) AND !$postback_ip == '0') {
                        if ($ipstart < 0 OR $ipend < 0) { //ip2long returns < 0 if input is invalid
                                bterror(_admbaninvalidip,_admban,false);
                                break;
                        }
                        $sql = "UPDATE ".$db_prefix."_bans SET ipstart = '".$ipstart."', ipend = '".$ipend."', reason = '".$reason_ip."' WHERE id = '".$id."';";
                        $db->sql_query($sql) or btsqlerror($sql);
                }
                break;
        }
        case "delban": {
                if ($id) {
                        if (!is_numeric($id)) break;
                        $db->sql_query("DELETE FROM ".$db_prefix."_bans WHERE id = '".$id."';");
                } elseif ($uid) { //uid should be set then
		//die($uid);
                        if (!is_numeric($uid)) break;
                        $db->sql_query("UPDATE ".$db_prefix."_users SET ban = 0, banreason = NULL WHERE id = '".$uid."';");
                }

                break;
        }
}

$sql = "SELECT * FROM ".$db_prefix."_bans;";
$res = $db->sql_query($sql);
        while ($ban = $db->sql_fetchrow($res)) {
			$template->assign_block_vars('ipbans', array(
				'IPSTART'			=> @long2ip($ban["ipstart"]),
				'IPEND'				=> @long2ip($ban["ipend"]),
				'REASON'			=> htmlspecialchars($ban["reason"]),
				'GIVEN_REASON'		=> htmlspecialchars($ban["ban_give_reason"]),
				'ID'				=> $ban["id"],
				)
			);
        }
$db->sql_freeresult($res);
//Banned Users
$sql = "SELECT * FROM ".$db_prefix."_users WHERE ban = 1 ORDER BY id;";
$res = $db->sql_query($sql);
        while ($ban = $db->sql_fetchrow($res)) {
			$template->assign_block_vars('userbans', array(
				'USER'			=> "<a href=\"user.php?op=profile&id=".$ban["id"]."\">".$ban["username"]."</a>",
				'REASON'				=> htmlspecialchars($ban["banreason"]),
				'ID'			=> $ban["id"],
				)
			);
        }
$db->sql_freeresult($res);
if (!$is_edit OR isset($id)) {
        if ($is_edit)
		{
			$hide = array('op' => 'editban', 'id' => $id);
		}
        else
		{
        	$hide = array('op'=>"addban");
		}
								$hiddenip = build_hidden_fields($hide);
                                $template->assign_vars(array(
								'START_IPBAN'		=> @long2ip($banedit_ip["ban_ip"]),
								'END_IPBAN'			=> @long2ip($banedit_ip["ipend"]),
								'IP_BAN_REASON'		=> $banedit_ip["ban_reason"],
								'HIDEI'				=> $hiddenip,
								));
}


if ($is_edituser AND isset($uid)) {
        if ($is_edit)
		{
			$hide = array('op' => 'editban', 'uid' => $uid);
		}
        else 
		{
			$hide = array('op' => 'addban');
		}
                                $template->assign_vars(array(
								'USER_BAN_NAME'		=> $banedit_user["username"],
								'USER_BAN_REASON'	=> $banedit_user["banreason"],
								'HIDEU'				=> build_hidden_fields($hide),
								));
}
echo $template->fetch('admin/bans.html');
		close_out();
?>