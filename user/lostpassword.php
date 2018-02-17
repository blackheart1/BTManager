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
*------              �2010 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*--------------------   Sunday, May 17, 2009 1:05 AM   ------------------------*
*------------------------------------------------------------------------------*
*------------------------ Mod By Nightcrawler ---------------------------------*
*------------------------------------------------------------------------------*
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 register.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
require_once("common.php");
require_once("include/recaptchalib.php");
include_once("include/utf/utf_tools.php");
			require_once("include/class.email.php");
			include_once('include/function_messenger.php');
$user->set_lang('profile',$user->ulanguage);
$template = new Template();
set_site_var($user->lang['LOST_PASSWORD']);

if ($user->user) bterror("");

$postback												= request_var('postback', '');
$subd												= request_var('subd', 0);

if (!$subd) {
        //When button is NOT clicked yet
		$hidden = array('op'=>'lostpassword','subd'=>'1');
                        $rnd_code = strtoupper(RandomAlpha(5));
        if ($gfx_check) {
					if($recap_puplic_key)
					{
                        $gfximage = recaptcha_get_html($recap_puplic_key, null, $recap_https);
					}else{
						$hidden ['gfxcheck'] = md5($rnd_code);
                        $gfximage = "<img src=\"gfxgen.php?code=".base64_encode($rnd_code)."\">";
					}
        }
			$template->assign_vars(array(
					'HIDDEN'					=>	build_hidden_fields($hidden),
					'S_GFX_CHECK'				=>	($gfx_check)? $gfximage : false,
					'RECAPTCHA'					=>	$recap_puplic_key,
					'S_LOSTPASS'				=> true,
					'U_ACTION'					=>	'user.php',
			));
	echo $template->fetch('ucp_signup.html');
	close_out();
}
else
{
        //After clicking
		$username				= utf8_normalize_nfc(request_var('username', '', true));
		$npasswd				= request_var('npasswd', '');
		$cpasswd				= request_var('cpasswd', '');
		$gfxcode				= request_var('gfxcode', '');
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
      $errmsg = Array();
        if (!isset($username) OR $username == "")
                $errmsg[] = $user->lang['NO_USERNAME_SET'];

        if (!isset($npasswd) OR $npasswd == "")
                $errmsg[] = $user->lang['NO_PASSWORD_SET'];
        if (count($errmsg) == 0) {
                $sql = "SELECT username, id, email, language FROM ".$db_prefix."_users WHERE clean_username = '".$db->sql_escape(utf8_strtolower($username))."' AND ban = 0 ;";
                $res = $db->sql_query($sql);
                if ($db->sql_numrows($res) == 0)
                        $errmsg[] = $user->lang['NO_SUCH_USER'];
                else
                        list ($r_username, $uid, $email_to, $ulanguage) = $db->fetch_array($res);
                $db->sql_freeresult($res);
                if (strlen($npasswd) < 5)
                        $errmsg[] = $user->lang['ERR_PASS_TO_SHORT'];
                if ($npasswd != $cpasswd)
                        $errmsg[] = $user->lang['ERR_PASS_NOT_MATCH'];

                #GFX Check
				if ($gfx_check AND $recap_puplic_key AND !$recap_pass)
					{
                        $errmsg[] = $user->lang['SEC_CODE_ERROR'] . '<br>' . $resp->error;
					} 
				elseif ($gfx_check AND !$recap_puplic_key AND (!isset($gfxcode) OR $gfxcode == "" OR $gfxcheck != md5(strtoupper($gfxcode))))
					{
                        $errmsg[] = $user->lang['SEC_CODE_ERROR'];
					}
        }
        if (count($errmsg) != 0)
		{
                                $template->assign_vars(array(
										'S_ERROR'			=> true,
										'S_FORWARD'			=> false,
								        'TITTLE_M'			=> $user->lang['BT_ERROR'],
                                        'MESSAGE'			=> implode("<br />",$errmsg) . '<br/><center><a href="javascript: history.go(-1);">'.$user->lang['BACK'].'</a></center><br />',
                                ));
			echo $template->fetch('message_body.html');
			close_out();
		}

        $act_key = RandomAlpha(32);
        $sql = "UPDATE ".$db_prefix."_users SET newpasswd = '".md5($npasswd)."', act_key = '".$act_key."' WHERE clean_username = '".$db->sql_escape(utf8_strtolower($username))."';";
        $db->sql_query($sql) or btsqlerror($sql);
		$act_key = md5($act_key);
                        if (!$ulanguage OR !file_exists("language/email/".$ulanguage."/recover.txt")) $lang_email = $language;
                        else $lang_email = $ulanguage;
						$messenger = new messenger();
						$messenger->template('recover', $lang_email);
						$messenger->to($email_to, $r_username);
						$messenger->assign_vars(array(
									'SUB_JECT'				=>	sprintf($user->lang['LOST_PASSWORD_SUB'],$sitename),
									'USER_NAME'				=>	$r_username,
									'REG_PASS'				=>	$npasswd,
									'REG_URL'				=>	$siteurl . '/user.php?op=lostpasswordconfirm&uid=' . $uid . '&code=' . $act_key ,
									));
						$messenger->send(0);
						$messenger->save_queue();
						meta_refresh(5, $siteurl . '/login.php');
						$template->assign_vars(array(
								'S_SUCCESS'				=> true,
								'S_FORWARD'				=> false,
								'TITTLE_M'				=> $user->lang['SUCCESS'],
								'MESSAGE'				=> $user->lang['LOST_PASSWORD_SENT'],
						));
					echo $template->fetch('message_body.html');
					close_out();
}
?>