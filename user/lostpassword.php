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
** File lostpassword.php 2018-02-18 14:32:00 joeroberts
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
require_once("common.php");
require_once("include/recaptchalib.php");
include_once("include/utf/utf_tools.php");
			require_once("include/class.email.php");
			include_once('include/function_messenger.php');
$user->set_lang('profile',$user->ulanguage);
$template = new Template();
set_site_var($user->lang['LOST_PASSWORD']);

if ($user->user) bterror("LOGGED_IN_USE_PRO_EDIT");

$postback												= request_var('postback', '');
$subd												= request_var('subd', 0);

if (!$subd) {
        //When button is NOT clicked yet
		$hidden = array('op'=>'lostpassword','subd'=>'1');
                        $rnd_code = strtoupper(RandomAlpha(5));
        if ($gfx_check) {
					if($recap_puplic_key)
					{
 							   $template->assign_vars(array(
										'META'						=> "<script src='https://www.google.com/recaptcha/api.js'></script>",
                                ));
                       $gfximage = true;
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
		$recaptcha_response_field									= request_var('g-recaptcha-response', '');
		$recaptcha_challenge_field									= request_var('recaptcha_challenge_field', '');
		$recap_pass = true;
			if ($gfx_check AND $recap_puplic_key)
			{
				$ip = $_SERVER['REMOTE_ADDR'];
				$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$recap_private_key."&response=".$recaptcha_response_field."&remoteip=".$ip);
				$responseKeys = json_decode($response,true);	     
				$recap_pass = intval($responseKeys["success"]) !== 1 ? false : true;
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