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
*------              �2011 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*--------------------   Sunday, Dec 20, 2009 1:05 AM   ------------------------*
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 addoffer.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
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
//die(print_r($hidden));
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
										if($var != 'username' AND $var != 'page' AND $var != 'op' AND $var != 'password' AND $var != 'gfxcode' AND $var != 'recaptcha_challenge_field' AND $var != 'recaptcha_response_field')$hidden[$var] = $var . '=' .$val;
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
								$password = stripslashes($password);
								$password = $db->sql_escape($password);
								$username = $db->sql_escape($username);
								$error = serialize('User login failed for '.$username . ' using '. $password);
								logerror($error, 'FAILED_LOGIN');
                                $template->assign_vars(array(
                                        'S_ERROR'            => true,
                                        'S_ERROR_MESS'            => $user->lang['LOGIN_ERROR_NP_WRONG'],
                                ));
                        }
                }
		}
}
			//$hidden = array();
			$gfximage = '';
                if ($gfx_check) {
					if($recap_puplic_key)
					{
                        $gfximage = recaptcha_get_html($recap_puplic_key, null, $recap_https);
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
										'RECAPTCHA'					=>	$recap_puplic_key,
                                ));

echo $template->fetch('login.html');
	close_out();
?>