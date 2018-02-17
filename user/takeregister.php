<?php
/*
*-----------------------------phpMyBitTorrent V 3.0.0--------------------------*
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
*------              �2011 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*
* @package phpMyBitTorrent
* @version $Id: takeregister.php 1 2011-07-05 00:22:48Z joeroberts $
* @copyright (c) 2011 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
require_once("common.php");
$user->set_lang('profile',$user->ulanguage);
require_once("include/recaptchalib.php");
$template = new Template();
$errmsg = array();
$username												= utf8_normalize_nfc(request_var('username', '', true));
$password												= request_var('password', '');
$cpassword												= request_var('cpassword', '');
$email													= request_var('email', '');
$disclaimer												= request_var('disclaimer', '');
$gfxcheck												= request_var('gfxcheck', '');
$gfxcode												= request_var('gfxcode', '');
		$recaptcha_response_field									= request_var('recaptcha_response_field', '');
		$recaptcha_challenge_field									= request_var('recaptcha_challenge_field', '');
		$recap_pass = true;
			if ($gfx_check AND $recap_puplic_key)
			{
				$resp = recaptcha_check_answer ($recap_private_key,
					$_SERVER["REMOTE_ADDR"],
					$recaptcha_challenge_field,
					$recaptcha_response_field);
					$recap_pass = $resp->is_valid;
			}
if (!isset($username) OR $username == "")
        $errmsg[] = $user->lang['NO_USERNAME_SET'];
if (!isset($password) OR $password == "")
        $errmsg[] = $user->lang['NO_PASSWORD_SET'];
if (!isset($email) OR $email == "")
        $errmsg[] = $user->lang['NO_EMAIL_SET'];
if (count($errmsg) == 0) {
        if ($db->sql_numrows($db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE username ='".$db->sql_escape($username)."';")) != 0)
                $errmsg[] = $user->lang['ERR_USER_ACSEST'];
        if (!is_email($email))
                $errmsg[] = $user->lang['ERR_EMAIL_NOT_VALID'];
        if ($db->sql_numrows($db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE email ='".$db->sql_escape($email)."';")) != 0)
                $errmsg[] = $user->lang['ERR_EMAIL_ACSEST'];
        if ($db->sql_numrows($db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE lastip = '".sprintf("%u",ip2long(getip()))."';")) != 0)
              	$errmsg[] = "Duplicate Ip In use";
        if (strlen($password) < 5)
                $errmsg[] = $user->lang['ERR_PASS_TO_SHORT'];
        if ($password != $cpassword)
                $errmsg[] = $user->lang['ERR_PASS_NOT_MATCH'];
        if ($disclaimer_check AND $disclaimer != "yes")
                $errmsg[] = $user->lang['DISCL_NOT_ACCP'];
                #GFX Check
				if ($gfx_check AND $recap_puplic_key AND !$recap_pass)
					{
                        $errmsg[] = $user->lang['SEC_CODE_ERROR'];
					} 
				elseif ($gfx_check AND !$recap_puplic_key AND (!isset($gfxcode) OR $gfxcode == "" OR $gfxcheck != md5(strtoupper($gfxcode))))
					{
                        $errmsg[] = $user->lang['SEC_CODE_ERROR'] .$gfxcheck . ' = ' . md5(strtoupper($gfxcode));
					}
}
if (count($errmsg) != 0){
              set_site_var('- '.$user->lang['USER_CPANNEL'].' - '.$user->lang['BT_ERROR']);
                                $template->assign_vars(array(
								        'S_ERROR_HEADER'          => $user->lang['SIGN_UP_ERROR'],
                                        'S_ERROR_MESS'            => implode("<br />",$errmsg),
                                ));
echo $template->fetch('error.html');
close_out();
}
	$username_clean = utf8_strtolower($username);

$sql = 'SELECT `group_id` FROM `'.$db_prefix.'_level_settings` WHERE `group_default` = 1 LIMIT 1 '; 
$res = $db->sql_query($sql);
$default_group = $db->fetch_array($res);
if($force_passkey){
                do {
                        $passkey = ", '".RandomAlpha(32)."'";
                        //Check whether passkey already exists
                        $sql = "SELECT passkey FROM ".$db_prefix."_users WHERE passkey = '".$passkey."';";
                        $res = $db->sql_query($sql);
                        $cnt = $db->sql_numrows($sql);
                        $db->sql_freeresult($res);
                } while ($cnt > 0);
				$passkeyrow = ', passkey';
				}else{
				$passkeyrow = NULL;
				$passkey = NULL;
				}
$act_key = RandomAlpha(32);
if($conferm_email)$sql = "INSERT INTO ".$db_prefix."_users (username, clean_username, email, password, act_key, can_do, uploaded, regdate, user_type" . $passkeyrow . ") VALUES ('".$db->sql_escape($username)."', '".$db->sql_escape($username_clean)."', '".$db->sql_escape($email)."', '".md5($password)."', '".$act_key."', " . $default_group[0] . ", '".$give_sign_up_credit."', NOW(), 0 " . $passkey .");";
else
$sql = "INSERT INTO ".$db_prefix."_users (username, clean_username, email, password, act_key, can_do, uploaded, regdate, user_type" . $passkeyrow . ", active) VALUES ('".$db->sql_escape($username)."', '".$db->sql_escape($username_clean)."', '".$db->sql_escape($email)."', '".md5($password)."', '".$act_key."', " . $default_group[0] . ", '".$give_sign_up_credit."', NOW(), 0" . $passkey .", 1);";
$db->sql_query($sql) or btsqlerror($sql);
$new_id = $db->sql_nextid();
$sql = "INSERT INTO `".$db_prefix."_user_group` (`group_id`, `user_id`, `group_leader`, `user_pending`) VALUES ('" . $default_group[0] . "', '" . $new_id . "', '0', '0');";
$db->sql_query($sql) or btsqlerror($sql);
group_set_user_default($default_group[0], array($new_id), false);

if($conferm_email) 
{
			$act_key = md5($act_key);
			require_once("include/class.email.php");
			include_once('include/function_messenger.php');
			include_once("include/utf/utf_tools.php");
						$messenger = new messenger();
						$messenger->template('regester', $language);
						$messenger->to($email, $username);
						$messenger->assign_vars(array(
									'SUB_JECT'				=>	sprintf($user->lang['ACCOUNTACTIVATESUB'],$sitename),
									'REG_URL'				=>	$siteurl . '/user.php?op=confirm&username=' . $username . '&act_key=' . $act_key,
									'U_NAME'				=>	$username ,
									'U_PASS_W'				=>	$password,
									));
						$messenger->send(0);
						$messenger->save_queue();
						$message = sprintf($user->lang['REG_SUCCESS_CONFERM'],spellmail($admin_email));
}else{
				meta_refresh(2, $siteurl . "/login.php");
                $message = $user->lang['REG_SUCCESS'];
				$sql = "INSERT INTO ".$db_prefix."_shouts (user, text, posted) VALUES ('1', '/notice <!-- swelcome --><img src=\"smiles/welcome.gif\" alt=\"welcome\" title=\"welcome\"><!-- swelcome -->  our newest Member ".$db->sql_escape($username)."', NOW());";
                $db->sql_query($sql);
}
              set_site_var('- '.$user->lang['USER_CPANNEL']);
$template->assign_vars(array(
        'S_SUCCESS'          => true,
        'TITTLE_M'           => $user->lang['SUCCESS'],
        'MESSAGE'            => $message,
));
echo $template->fetch('message_body.html');
close_out();
?>