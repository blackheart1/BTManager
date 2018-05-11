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
** File login.php 2018-02-17 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
require_once("common.php");
require_once("include/recaptchalib.php");
include_once("include/utf/utf_tools.php");
$user->set_lang('profile',$user->ulanguage);
$template = new Template();
set_site_var($user->lang['LOGIN']);
$hidden = array();
$returnto = '';
							   $template->assign_vars(array(
                                        'S_ERROR'            => false,
										'PAGE_TITLE'		=>	$user->lang['LOGIN'],
                                ));
								$login_complete = false;
while (list($var,$val) = each($_GET))
{
$hidden[$var] = $val;
}
$i = strpos($returnto, "&return=");
if ($i !== false)
{
	$returnto = substr($returnto, $i + 8);
}
if($returnto == '')$returnto = 'index.php';
		$op									= request_var('op', '');
switch($op)
{
		case 'login':
		{
			$username									= request_var('username', '',true);
			$password									= request_var('password', '');
			$gfxcode									= request_var('gfxcode', '');
			$returnto									= request_var('returnto', '');
			$remember									= request_var('remember', '');
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
               if ($username == "" OR $password == "") {
                                $template->assign_vars(array(
                                        'S_ERROR'            => true,
                                        'S_ERROR_MESS'            => $user->lang['LOGIN_ERROR_NP'],
                                ));
								break;
                }
				elseif ($gfx_check AND $recap_puplic_key AND !$recap_pass)
				{
										$template->assign_vars(array(
                                        'S_ERROR'            => true,
                                        'S_ERROR_MESS'            => $user->lang['SEC_CODE_ERROR'],
                                		));
										//die;
									break;
				} elseif ($gfx_check AND !$recap_puplic_key AND (!isset($gfxcode) OR $gfxcode == "" OR $gfxcheck != md5(strtoupper($gfxcode)))) {
									$template->assign_vars(array(
											'S_ERROR'            => true,
											'S_ERROR_MESS'            => $user->lang['SEC_CODE_ERROR'],
									));
									//die;
									break;
                } 
				else 
				{
                        $result = $db->sql_query("SELECT active FROM ".$db_prefix."_users WHERE clean_username = '".$db->sql_escape(utf8_strtolower($username))."' AND password = '".md5($password)."'");
                        if ($db->sql_numrows($result) == 1) 
						{
                                $active = $db->sql_fetchrow($result);
                                if ($active['active'] == 1) {
								$ip = getip();
						        $sql = "UPDATE ".$db_prefix."_users SET 
										lastip = '".sprintf("%u",ip2long($ip))."', 
										lasthost = '".gethostbyaddr($ip)."', 
										lastlogin = NOW() WHERE 
										clean_username = '".$db->sql_escape(utf8_strtolower($username))."';";
						        $db->sql_query($sql);

								if (isset($remember) AND $remember == "yes")
								{
								 	$db->sql_query("UPDATE ".$db_prefix."_users SET rem = 'yes' WHERE clean_username = '".$db->sql_escape(utf8_strtolower($username))."';");
								 }
                                        //ob_end_clean();
										while (list($var,$val) = each($_POST))
										{
										if($var != 'username' AND $var != 'page' AND $var != 'op' AND $var != 'password' AND $var != 'gfxcode' AND $var != 'g-recaptcha-response' AND $var != 'recaptcha_challenge_field')$hidden[$var] = $var . '=' .$val;
										if($var == 'page') $page = $val;
										}

                                       // unset($btuser);
									   //die('prelogin');
									   
                                        userlogin($username, $btuser);
										$login_complete = true;
										if(!$hidden)
										{
											set_site_var($user->lang['SUCCESS']);
											meta_refresh(2, $siteurl . "/index.php");
										//die('no hidden');
											$template->assign_vars(array(
											'LOGIN_SUCCESS'			=> true,
											'TITTLE_M'          => $user->lang['SUCCESS'],
											'MESSAGE'           => $user->lang['LOGIN_SUCCESS'],
											));
											break;
										}
										else
										{
										
											$i=0;
											$return = $page;
											if($return == '')$return = 'index.php';
											foreach($hidden as $value)
											{
												$return .= (($i == 0)? '?' : '&') . $value;
												$i++;
											}
										//die($return);
											set_site_var($user->lang['SUCCESS']);
											meta_refresh(2, $return);
											$template->assign_vars(array(
											'LOGIN_SUCCESS'			=> true,
											'TITTLE_M'          => $user->lang['SUCCESS'],
											'MESSAGE'           => $user->lang['LOGIN_SUCCESS'],
											));
											break;
										}
                                }
                                else 
								{
                                        //user not active
                                	$template->assign_vars(array(
                                        'S_ERROR'            => true,
                                        'S_ERROR_MESS'            => $user->lang['LOGIN_ERROR_NOT_ACTIVE'],
                                ));
                                }
                        } 
						else 
						{
                                //bad data
								$username = $db->sql_escape($username);
								$error = serialize(array($username));
								logerror($error, 'FAILED_LOGIN');
                                $template->assign_vars(array(
                                        'S_ERROR'            => true,
                                        'S_ERROR_MESS'            => $user->lang['LOGIN_ERROR_NP_WRONG'],
                                ));
                        }
                }
		}
}
			$gfximage = '';
                if ($gfx_check AND !$login_complete) {
					if($recap_puplic_key)
					{
							   $template->assign_vars(array(
										'META'						=> "<script src='https://www.google.com/recaptcha/api.js'></script>",
										'RECAPTCHA'					=>	$recap_puplic_key,
                                ));
                        $gfximage = true;
					}else{
                        $rnd_code = strtoupper(RandomAlpha(5));
						$hidden ['gfxcheck'] = md5($rnd_code);
                        $gfximage = "<img src=\"gfxgen.php?code=".base64_encode($rnd_code)."\">";
					}
                }
				$hidden['op'] = 'login';
							   $template->assign_vars(array(
										'LOGIN_SUCCESS'				=> $login_complete,
										'S_GFX_CHECK'				=>	($gfx_check)? $gfximage : false,
										'HIDDEN'					=>	build_hidden_fields($hidden),
										'U_ACTION'					=>	'login.php',
                                ));

echo $template->fetch('login.html');
	close_out();
?>