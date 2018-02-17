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
                        $gfximage = recaptcha_get_html($recap_puplic_key, null, $recap_https);
					}else{
                        $rnd_code = strtoupper(RandomAlpha(5));
						$hide ['gfxcheck'] = md5($rnd_code);
                        $gfximage = "<img src=\"gfxgen.php?code=".base64_encode($rnd_code)."\">";
					}
		$template->assign_vars(array(
				'GFX_CODE'			=> $gfximage,
				'S_CAPTCHA'			=> true,
				'RECAPTCHA'					=>	$recap_puplic_key,
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