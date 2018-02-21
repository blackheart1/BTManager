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
** File invite.php 2018-02-17 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (defined('IN_PMBT'))
{
	die ("You can't include this file");
}
else
{
	define("IN_PMBT",true);
}
require_once("common.php");
$user->set_lang('invite',$user->ulanguage);
$user->set_lang('profile',$user->ulanguage);
$template = new Template();
include_once("include/utf/utf_tools.php");
set_site_var($user->lang['INVITES']);
$action		= request_var('action', 'new');
if (!$INVITEONLY)
{
	$template->assign_vars(array(
		'S_ERROR'			=> true,
		'S_FORWARD'			=> false,
		'TITTLE_M'			=> $user->lang['INVITES_DISSABLED'],
		'MESSAGE'			=> $user->lang['INVITES_DISSABLED_EXP'],
	));
	echo $template->fetch('message_body.html');
	close_out();
}
switch ($action)
{
		case 'new':
		{
			$sql=("SELECT COUNT(id) FROM ".$db_prefix."_users");
			$res = $db->sql_query($sql) or btsqlerror($sql);
			$arr = $db->sql_fetchrow($res);
			if ($arr[0] >= $invites1)
			{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['LIMMIT_REACHED'],
					'MESSAGE'			=> sprintf($user->lang['MAX_USERS_REACHED'],number_format($invites1)),
				));
				echo $template->fetch('message_body.html');
				close_out();
			}
			if($user->invites == 0)
			{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['NO_INVITES'],
					'MESSAGE'			=> $user->lang['NO_INVITES_EXP'],
				));
				echo $template->fetch('message_body.html');
				close_out();
			}
			$template->assign_vars(array(
				'ACTION'			=>	'new',
				));
			echo $template->fetch('invite.html');
			close_out();
		}
		case 'take_new':
		{
			$invitor = $user->name;
			$message = request_var('mess','',true);
			$email = request_var('email','');

			$sql=("SELECT COUNT(id) FROM ".$db_prefix."_users")or sql_error();
			$res = $db->sql_query($sql) or btsqlerror($sql);
			$arr = $db->sql_fetchrow($res);
			$u_action = $siteurl . '/invite.php';
			if ($arr[0] >= $invites1)
			{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['LIMMIT_REACHED'],
					'MESSAGE'			=> sprintf($user->lang['MAX_USERS_REACHED'],number_format($invites1)) . back_link($u_action),
				));
				echo $template->fetch('message_body.html');
				close_out();
			}
			if($user->invites == 0)
			{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['NO_INVITES'],
					'MESSAGE'			=> $user->lang['NO_INVITES_EXP'] . back_link($u_action),
				));
				echo $template->fetch('message_body.html');
				close_out();
			}
			if (!$message)//No Message error
			{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['NO_MESSAGE'],
					'MESSAGE'			=> $user->lang['NO_MESSAGE_EXP'] . back_link($u_action),
				));
				echo $template->fetch('message_body.html');
				close_out();
			}
			if (!checkEmail($email))//Bad E-mail Address 
			{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BAD_EMAIL'],
					'MESSAGE'			=> $user->lang['BAD_EMAIL_EXP'] . back_link($u_action),
				));
				echo $template->fetch('message_body.html');
				close_out();
			}
			// check if email addy is already in use
			$a = ($db->sql_fetchrow($db->sql_query("select count(*) from ".$db_prefix."_users where email='$email'")));
			if ($a[0] != 0)//E-mail is in use 
			{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['EMAIL_USED'],
					'MESSAGE'			=> $user->lang['EMAIL_USED_EXP'] . back_link($u_action),
				));
				echo $template->fetch('message_body.html');
				close_out();
			}
			//Get default group
			$sql = 'SELECT `group_id` FROM `'.$db_prefix.'_level_settings` WHERE `group_default` = 1 LIMIT 1 '; 
			$res = $db->sql_query($sql);
			$default_group = $db->sql_fetchrow($res);
			$group = $default_group[0];
			$secret = mksecret();
			$editsecret = mksecret();
			$username = 'invity_' . rand();
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
							$sql = "INSERT INTO ".$db_prefix."_users 
										(username, 
										password, 
										email, 
										active, 
										can_do, 
										act_key, 
										invited_by, 
										uploaded, 
										regdate, 
										invitedate 
										" . $passkeyrow . "
									) VALUES (
										'" .$username. "', 
										'". $secret ."', 
										'" .$email ."', 
										'0', 
										'" . $group . "',
										'".$act_key."', 
										'". $user->id ."', 
										'".$give_sign_up_credit."', 
										NOW(), 
										NOW() 
										" . $passkey .")";
			$ret = $db->sql_query($sql)or die(mysql_error($sql));
			$id = $db->sql_nextid();
			$id2 = $user->id;
			$invites = $user->invites -1;
			$invitees = $user->invitees;
			$invitees2 = "$id $invitees";
			$db->sql_query("UPDATE ".$db_prefix."_users SET invites='$invites', invitees='$invitees2' WHERE id = $id2");
			$username = $user->name;
			
			$psecret = md5($secret);
			
			$message = strip_tags($message);
			require_once("include/class.email.php");
			include_once('include/function_messenger.php');
			include_once("include/utf/utf_tools.php");
						$messenger = new messenger();
						$messenger->template('regester', $language);
						$messenger->to($email);
						$messenger->assign_vars(array(
									'SUB_JECT'				=>	sprintf($user->lang['INV_MAIL_SUB'],$sitename),
									'REG_URL'				=>	$siteurl . '/invite.php?id=' . $id . '&secret=' . $psecret . '&action=confirm',
									'U_NAME'				=>	$invitor ,
									'U_EMAIL'				=>	$email,
									'IV_MESSAGE'			=>	$message,
									));
						$messenger->send(0);
						$messenger->save_queue();
			header("Refresh: 0; url=user.php?op=profile&id=".$user->id."&type=invite&email=" . urlencode($email));
			break;
		}
		case 'confirm':
		{

			$id									= request_var('id', '0');
			$md5									= request_var('secret', '');
			if (!$id OR !is_numeric($id))
			{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['INVALID_ID'],
					'MESSAGE'			=> $user->lang['INVALID_ID_EXP'],
				));
				echo $template->fetch('message_body.html');
				close_out();
			}

			if ($db->sql_numrows($db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE lastip = '".sprintf("%u",ip2long(getip()))."';")) != 0)
			{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['DUPE_IP'],
					'MESSAGE'			=> $user->lang['DUPE_IP_EXP'],
				));
				echo $template->fetch('message_body.html');
				close_out();
			}

			$sql = ("SELECT COUNT(*) FROM ".$db_prefix."_users");
			$res = $db->sql_query($sql) or btsqlerror($sql);
			$arr = $db->sql_fetchrow($res);
			if ($arr[0] >= $invites1)
			{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['USE_LIM_REACHED'],
					'MESSAGE'			=> printf($user->lang['USE_LIM_REACHED_EXP'],$invites1),
				));
				echo $template->fetch('message_body.html');
				close_out();
			}

			$sql = "SELECT password, active FROM ".$db_prefix."_users WHERE id = '".$db->sql_escape($id)."'";
			$res = $db->sql_query($sql) or btsqlerror($sql);
			$row = $db->sql_fetchrow($res);

			if (!$row)
			{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['INVALID_INVITE'],
					'MESSAGE'			=> $user->lang['INVALID_INVITE_EXP'],
				));
				echo $template->fetch('message_body.html');
				close_out();
			}

			if ($row["active"] != '0') 
			{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['ACCOUNT_ACTIVE'],
					'MESSAGE'			=> $user->lang['ACCOUNT_ACTIVE_EXP'],
				));
				echo $template->fetch('message_body.html');
				close_out();
			}

			$sec = $row["password"];
			if ($md5 != md5($sec))
			{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['INVALID_ACTKEY'],
					'MESSAGE'			=> $user->lang['INVALID_ACTKEY_EXP'],
				));
				echo $template->fetch('message_body.html');
				close_out();
			}
			$secret = $sec;
			$psecret = md5($sec);
			$hide = array('action' => 'take_confirm');
			$hide['id']	=	$id;
			$hide['secret']	=	$psecret;
			if ($gfx_check) {
					$rnd_code = strtoupper(RandomAlpha(5));
					$template->assign_vars(array(
							'GFX_CODE'			=> base64_encode($rnd_code),
							'S_CAPTCHA'			=> true,
					));
					$hide['gfxcheck'] = md5($rnd_code);
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
							'U_ACTION'			=> './invite.php',
							'HIDDEN'			=> build_hidden_fields($hide),
							'ACTION'			=>	$action,
					));
			echo $template->fetch('invite.html');
			close_out();
			break;
		}
		case 'take_confirm':
		{
			$id														= (int)request_var('id', 0);
			$secret													= request_var('secret', '');
			$disclaimer												= request_var('disclaimer', '');
			$gfxcheck												= request_var('gfxcheck', '');
			$gfxcode												= request_var('gfxcode', '');
			$username												= utf8_normalize_nfc(request_var('username', '', true));
			$password												= request_var('password', '',true);
			$cpassword												= request_var('cpassword', '');
			$md5 = $secret;
							$errmsg = Array();
			if (!isset($id) OR $id == "")$errmsg[] =$user->lang[" USERNAME_NOT_SET"];
			if (count($errmsg) == 0) {
			$sql = ("SELECT COUNT(*) FROM ".$db_prefix."_users");
			$res = $db->sql_query($sql) or btsqlerror($sql);
			$arr = $db->sql_fetchrow($res);
			if ($arr[0] >= $invites1)
			$errmsg[] = $user->lang["USER_LINNET_REACHED"];
			$sql = ("SELECT password, active, can_do FROM ".$db_prefix."_users WHERE id = $id");
			$res = $db->sql_query($sql) or btsqlerror($sql);
			$row = $db->sql_fetchrow($res);
			if (!$row)$errmsg[] = $user->lang["BAD_ID"];
			if ($row["active"] != "0")$errmsg[] = $user->lang["USER_IS_ACTIVE"];
        if ($disclaimer_check AND $disclaimer != "yes")
                $errmsg[] = $user->lang["DISCL_NOT_ACCP"];
        if ($gfx_check == "true" AND $gfxcheck != md5(strtoupper($gfxcode)))
                $errmsg[] = $user->lang["SEC_CODE_ERROR"];
                  $sec = md5($row["password"]);
			 if ($md5 != $sec)$errmsg[] = $user->lang["PASS_DONT_MATCH"];
			}
			if (count($errmsg) != 0)
			{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> implode('<BR />',$errmsg),
				));
				echo $template->fetch('message_body.html');
				close_out();
			}

			if (empty($username) || empty($password)|| empty($cpassword))
			{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $user->lang['YOU_HAVE_BLANK_FEALDS'],
				));
				echo $template->fetch('message_body.html');
				close_out();
			}
			
			
			function validusername($username)
			{
			if ($username == "")
			return false;
			
			// The following characters are allowed in user names
			$allowedchars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789 _-";
			
			for ($i = 0; $i < strlen($username); ++$i)
			if (strpos($allowedchars, $username[$i]) === false)
			return false;
			
			return true;
			}
			
			if (strlen($username) > 45)
			{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $user->lang["USER_NAME_TO_LONG"],
				));
				echo $template->fetch('message_body.html');
				close_out();
			}
			
			if (strlen($password) < 6)
			{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $user->lang["PASS_TO_SHORT"],
				));
				echo $template->fetch('message_body.html');
				close_out();
			}
			if ($cpassword != $password)
			{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $user->lang["PASS_DONT_MATCH"],
				));
				echo $template->fetch('message_body.html');
				close_out();
			}
			if (!validusername($username))
			{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $user->lang["INVALID_USER_NAME"],
				));
				echo $template->fetch('message_body.html');
				close_out();
			}
			$wantpasshash = $db->sql_escape(md5($password));
			$db->sql_query("UPDATE ".$db_prefix."_users SET username='" . $db->sql_escape($username) . "', clean_username = '".$db->sql_escape(utf8_strtolower($username))."', password='$wantpasshash', active='1'WHERE id=$id")or sql_error();
			$sql = "INSERT INTO `".$db_prefix."_user_group` (`group_id`, `user_id`, `group_leader`, `user_pending`) VALUES ('" . $row["can_do"] . "', '" . $id . "', '0', '0');";
			$db->sql_query($sql) or btsqlerror($sql);
				$sql = "INSERT INTO ".$db_prefix."_shouts (user, text, posted) VALUES ('1', '/notice <!-- swelcome --><img src=\"smiles/welcome.gif\" alt=\"welcome\" title=\"welcome\"><!-- swelcome --> our newest Member ".$db->sql_escape($username)."', NOW());";
                if($shout_config['shoutnewuser'] == 'yes')$db->sql_query($sql);
				$template->assign_vars(array(
					'S_SUCCESS'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['SUCCESS'],
					'MESSAGE'			=> $user->lang['ACTIVATION_COMPLETE'],
				));
				echo $template->fetch('message_body.html');
				close_out();
		}
}
?>