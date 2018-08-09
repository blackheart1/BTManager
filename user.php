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
** File user.php 2018-02-17 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
require_once("common.php");
include_once("include/utf/utf_tools.php");
$op = request_var('op', '');
$user->set_lang('ucp',$user->ulanguage);
$id = request_var('id', 0);
$returnto												= strip_tags(request_var('returnto', ''));
$hidden = array();
switch ($op) {
        case "loginform": {
				$template = new Template();
				$gfximage = '';
                if ($gfx_check) {
					if($recap_puplic_key)
					{
							   $template->assign_vars(array(
										'META'						=> "<script src='https://www.google.com/recaptcha/api.js'></script>",
										'RECAPTCHA'					=>	$recap_puplic_key,
                                ));
                        //$gfximage = recaptcha_get_html($recap_puplic_key, null, $recap_https);
					}else{
                        $rnd_code = strtoupper(RandomAlpha(5));
						$hidden ['gfxcheck'] = md5($rnd_code);
                        $gfximage = "<img src=\"gfxgen.php?code=".base64_encode($rnd_code)."\">";
					}
                }
				$hidden['op'] = 'login';
							   $template->assign_vars(array(
										'S_GFX_CHECK'				=>	($gfx_check)? $gfximage : false,
										'HIDDEN'					=>	build_hidden_fields($hidden),
										'U_ACTION'					=>	'login.php',
                                ));

				echo $template->fetch('login.html');
				close_out();
        }
        case "logout": {
                setcookie("btuser","",time()-3600,$cookiepath,$cookiedomain,0);
                setcookie("btlanguage","",time()-3600,$cookiepath,$cookiedomain,0);
                setcookie("bttheme","",time()-3600,$cookiepath,$cookiedomain,0);
                $db->sql_query("UPDATE ".$db_prefix."_users SET act_key ='".RandomAlpha(32)."' WHERE id = '".$user->id."';");
                $db->sql_query("DELETE FROM ".$db_prefix."_online_users WHERE id = '".$user->id."';"); 
				$template = new Template();
				set_site_var($user->lang['SUCCESS']);
				meta_refresh(2, $siteurl . "/index.php");
				$template->assign_vars(array(
					'S_SUCCESS'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'          => $user->lang['SUCCESS'],
					'MESSAGE'           => $user->lang['LOGOUT_SUCCESS'],
				));
				echo $template->fetch('message_body.html');
				close_out();
        }
        case "banchat": 
		{
				if(!checkaccess("m_bann_shouts") OR (is_founder($id) AND !$user->user_type==3)){
					bterror('NO_AUTHBAN_SHOUTS','ACCESS_DENIED');
					break;
				}
				if($user->id == $id)
				{
					$template->assign_vars(array(
						'S_ERROR'			=> true,
						'S_FORWARD'			=> false,
						'TITTLE_M'          => $user->lang['BT_ERROR'],
						'MESSAGE'           => $user->lang['YOU_CANT_BAN_YOURSELF'],
					));
					echo $template->fetch('message_body.html');
					close_out();
				}
				
                $sql = "UPDATE ".$db_prefix."_users SET can_shout = 'false' WHERE id = '".$id."';";
                if (!$db->sql_query($sql)) btsqlerror($sql);
				$template = new Template();
				set_site_var($user->lang['SUCCESS']);
				$template->assign_vars(array(
					'S_SUCCESS'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'          => $user->lang['SUCCESS'],
					'MESSAGE'           => $user->lang['SHOUTS_BANNED'],
				));
				echo $template->fetch('message_body.html');
				close_out();
        }
        case "unbanchat": 
		{
				if(!checkaccess("m_bann_shouts") OR (is_founder($id) AND !$user->user_type==3)){
					bterror('NO_AUTHBAN_SHOUTS','ACCESS_DENIED');
				break;
				}
                $sql = "UPDATE ".$db_prefix."_users SET can_shout = 'true' WHERE id = '".$id."';";
                if (!$db->sql_query($sql)) btsqlerror($sql);
				$template = new Template();
				set_site_var($user->lang['SUCCESS']);
				$template->assign_vars(array(
					'S_SUCCESS'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'          => $user->lang['SUCCESS'],
					'MESSAGE'           => $user->lang['SHOUTS_UN_BANNED'],
				));
				echo $template->fetch('message_body.html');
				close_out();
        }
        case "confirm": {
                //if ($user->user) die();
				$username			                                = utf8_normalize_nfc(request_var('username', '',true));
				$act_key			                                = request_var('act_key', '');
                $errmsg = Array();
                if (!isset($username) OR $username == "")
                        $errmsg[] = 'NO_NAME_SET';
                if (!isset($act_key) OR $act_key == "")
                        $errmsg[] = 'NO_ACTIVATION_KEY_SET';
                if (count($errmsg) == 0) {
                        if ($db->sql_numrows($db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE username ='".$db->sql_escape($username)."';")) == 0)
                                $errmsg[] = 'NO_SUCH_USER';
                        if ($db->sql_numrows($db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE username ='".$db->sql_escape($username)."' AND active = 1;")) != 0)
                                $errmsg[] = 'USER_ALREADY_ACTIVATED';
                        if ($db->sql_numrows($db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE username ='".$db->sql_escape($username)."' AND md5(act_key) = '".$db->sql_escape($act_key)."';")) == 0)
                                $errmsg[] = 'NO_ACTIVATION_KEY_SET';
                }
                if (count($errmsg) != 0) bterror($errmsg,'ACTIVATION_ERROR');
					$sql_ary = array(
						'user_type'		=> '0',
						'active'		=> '1'
					);
                $sql = "UPDATE ".$db_prefix."_users SET " . $db->sql_build_array('UPDATE', $sql_ary) . " WHERE username = '".$db->sql_escape($username)."';";
                if (!$db->sql_query($sql)) btsqlerror($sql);
				$sql = "INSERT INTO ".$db_prefix."_shouts (user, text, bbcode_bitfield, bbcode_uid, posted) VALUES ('1', '/notice <!-- swelcome --><img src=\"smiles/welcome.gif\" alt=\"welcome\" title=\"welcome\"><!-- swelcome --> our newest Member ".$db->sql_escape($username)."','','mbicwem5', NOW());";
                if($shout_config['shoutnewuser'] == 'yes')$db->sql_query($sql);
				$template = new Template();
				set_site_var($user->lang['SUCCESS']);
				meta_refresh(2, $siteurl . "/login.php");
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'          => $user->lang['SUCCESS'],
					'MESSAGE'           => $user->lang['ACC_NOW_ACTIVATED'],
				));
				echo $template->fetch('message_body.html');
				close_out();
        }
        case "loginfailure": {
                switch (intval($errcode)) {
                        case 1: {
                                bterror('LOGIN_ERROR_NP','BT_ERROR');
                                break;
                        }
                        case 2: {
                                bterror('LOGIN_ERROR_NP_WRONG','BT_ERROR');
                                break;
                        }
                        case 3: {
                                bterror('LOGIN_ERROR_NOT_ACTIVE','BT_ERROR');
                                break;
                        }
                        case 4: {
                                bterror('LOGIN_ERROR_NOT_ACTIVE','BT_ERROR');
                                break;
                        }
                }
                break;
        }
        case "takeregister": 
		{
                if ($user->user) die();
                include("user/takeregister.php");
                break;
        }
        case "register": 
		{
                include_once("user/register.php");
                break;
        }
        case "profile": 
		{
                include("user/profile.php");
                break;
        }
        case "editprofile": 
		{
                include("user/editprofile.php");
                break;
        }
        case "lostpassword": 
		{
                include("user/lostpassword.php");
                break;
        }
		case "confirmemail": {
				$uid = request_var('user', 0);
				$code = request_var('mail_key', '');
                if (!isset($uid) OR !isset($code)) bterror($user->lang['EMAIL_CHANGE_INV'],$user->lang['BT_ERROR']);
				$npas = "SELECT newemail AS newemail FROM ".$db_prefix."_users WHERE id ='".intval($uid)."' AND mail_key = '".$db->sql_escape($code)."';";
				$snpa =  $db->sql_query($npas);
				$fnpa = $db->sql_fetchrow($snpa);
				if($fnpa[0] === '' OR $fnpa[0] === 0)
				{
					bterror('EMAIL_CHANGE_NOT_SET');
				}
                 $sql = "UPDATE ".$db_prefix."_users SET email = '".$fnpa['newemail']."', mail_key = NULL, newemail = NULL WHERE id = '".intval($uid)."' ;";
                if ($db->sql_query($sql)) 
				{
					$template = new Template();
					set_site_var($user->lang['SUCCESS']);
					$template->assign_vars(array(
						'S_ERROR'			=> true,
						'S_FORWARD'			=> false,
						'TITTLE_M'          => $user->lang['SUCCESS'],
						'MESSAGE'           => $user->lang["EMAIL_CHANGED"],
					));
					echo $template->fetch('message_body.html');
					close_out();
                }
				else
					bterror('EMAIL_CHANGE_INV','EMAIL_CHANGE');
		break;
		}
        case "lostpasswordconfirm": {
                if ($user->user) break;
				$uid = request_var('uid', 0);
				$code = request_var('code', '');
                if (!isset($uid) OR !isset($code)) bterror($user->lang['EMAIL_CHANGE_INV'],$user->lang['BT_ERROR']);
				$npas = "SELECT newpasswd AS newpasswd FROM ".$db_prefix."_users WHERE id ='".$uid."' AND md5(act_key) = '".$db->sql_escape($code)."';";
				$snpa =  $db->sql_query($npas);
				$fnpa = $db->sql_fetchrow($snpa);
				if($fnpa[0] === '' OR $fnpa[0] === 0)
				{
					bterror('PASS_RECOVER_NOT_SET');
				}
                 $sql = "UPDATE ".$db_prefix."_users SET password = '".$fnpa['newpasswd']."', newpasswd = NULL WHERE id = '".$uid."' ;";
                if ($db->sql_query($sql))
				{
					$template = new Template();
					set_site_var($user->lang['PASS_RECOVER']);
					$template->assign_vars(array(
						'S_ERROR'			=> true,
						'S_FORWARD'			=> false,
						'TITTLE_M'          => $user->lang['SUCCESS'],
						'MESSAGE'           => $user->lang["PASS_RECOVER_COMPLETE"],
					));
					echo $template->fetch('message_body.html');
					close_out();
                } else bterror('PASS_RECOVER_INV','PASS_RECOVER');
                break;
        }
        case "delete": 
		{
                if (!$user->user)
					loginrequired("user");
                if (isset($id)) 
				{
                        //if (!$user->admin) loginrequired("admin");
						if (!checkaccess('m_del_users') OR (is_founder($id) AND !$user->user_type==3)) {
							bterror("INV_LEVEL_TO_EDIT");
						}
                        else $uid = $id;
                        $sql = "SELECT username, ban, can_do FROM ".$db_prefix."_users WHERE id = '".$uid."';";
                        $res = $db->sql_query($sql);
                        list ($username, $ban, $can_do) = $db->fetch_array($res);
                        $db->sql_freeresult($res);
						if($ban == 1) bterror("USER_BAN_NO_DEL",'BT_ERROR');
                        if (empty($username)) bterror('NO_SUCH_USER','BT_ERROR');
                } 
				else 
					$uid = $user->id;
				if(is_founder($uid) && !$user->user_type==3)
				{
					bterror("INV_LEVEL_TO_EDIT");
					break;
				}

				if (confirm_box(true))
				{
						removedinactive($uid, 'retain', $post_username = false);
						$template = new Template();
						set_site_var($user->lang['SUCCESS']);
						meta_refresh(2, $siteurl . "/index.php");
						$template->assign_vars(array(
							'S_ERROR'			=> true,
							'S_FORWARD'			=> false,
							'TITTLE_M'          => $user->lang['SUCCESS'],
							'MESSAGE'           => $user->lang['LOGOUT_SUCCESS'],
						));
						echo $template->fetch('message_body.html');
						close_out();
				}
				else
				{
					$hidden = build_hidden_fields(array(
								'op'			=>	'delete',
								'id'			=>	$id,
					));
					confirm_box(false, sprintf($user->lang['CONFERM_DELETE_USER'],htmlspecialchars($username)), $hidden,'confirm_body.html','user.php');
				}

                break;
        }
        default: bterror("INVALID_OPTION");
}

?>