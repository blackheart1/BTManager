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
** File register.php 2018-02-18 14:32:00 joeroberts
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
$user->set_lang('profile',$user->ulanguage);
$template = new Template();
set_site_var($user->lang['REGISTOR']);
$sql=("SELECT COUNT(*) FROM ".$db_prefix."_users");
$res = $db->sql_query($sql) or btsqlerror($sql);
$arr = $db->sql_fetchrow($res);
if ($arr[0] >= $invites1)
{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['ERROR_LIMMET_REACHED'],
					'MESSAGE'			=> sprintf($user->lang['SIGNUP_LIMMET_REACHED'],$invites1),
				));
				echo $template->fetch('message_body.html');
				close_out();
}

if($singup_open)
{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $user->lang['SIGNUPS_CLOSED'],
				));
				echo $template->fetch('message_body.html');
				close_out();
}
$hide = array('op' => 'takeregister');
if ($gfx_check) {
					if($recap_puplic_key)
					{
							   $template->assign_vars(array(
										'META'						=> "<script src='https://www.google.com/recaptcha/api.js'></script>",
										'RECAPTCHA'					=>	$recap_puplic_key,
                                ));
                        $gfximage = recaptcha_get_html($recap_puplic_key, null, $recap_https);
					}else{
                        $rnd_code = strtoupper(RandomAlpha(5));
						$hide ['gfxcheck'] = md5($rnd_code);
                        $gfximage = "<img src=\"gfxgen.php?code=".base64_encode($rnd_code)."\">";
					}
		$template->assign_vars(array(
				'GFX_CODE'			=> $gfximage,
				'S_CAPTCHA'			=> true,
		));
}
if ($disclaimer_check) {
        $disclaimer = "";
        if (is_readable("disclaimer/".$language.".txt")) {
                $fp = fopen("disclaimer/".$language.".txt","r");
                while (!feof($fp)) $disclaimer.= fread($fp,1000);
        } else {
                $fp = fopen("disclaimer/english.txt","r");
                while (!feof($fp)) $disclaimer.= fread($fp,1000);
        }
        fclose($fp);
        $search = Array("*MYBT*","*URL*","*EMAIL*");
        $replace = Array($sitename,$siteurl,spellmail($admin_email));
		$template->assign_vars(array(
				'U_DISCLAIMER'			=> str_replace($search,$replace,$disclaimer),
				'S_DISCLAIMER'			=> true,
		));
}
		$template->assign_vars(array(
				'U_ACTION'			=> './user.php',
				'HIDDEN'			=> build_hidden_fields($hide),
		));
echo $template->fetch('ucp_signup.html');
close_out();
?>