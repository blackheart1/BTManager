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
*------              ©2010 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*--------------------   Sunday, May 17, 2009 1:05 AM   ------------------------*
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 irc.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
$user->set_lang('admin/irc',$user->ulanguage);
		$postback	= request_var('postback', '');
		$u_action	= 'admin.php';

$linebreak = (PHP_OS == "WIN") ? "\r\n" : "\n";
if ($postback) {
		$edit		= request_var('edit', '');
		$server		= request_var('server', '');
		$channel	= request_var('channel', '');
		$advanced	= request_var('advanced', '');
		$delete		= request_var('delete', '');
        if ($edit) {
                $errmsg = Array();
                if (!preg_match("/^[a-z][a-z0-9._-]*$/",$server) AND !preg_match("/^(\d{1,3}\.){3}\d{1,3}$/",$server)) $errmsg[] = $user->lang['IRC_INVALID_HOST'];
                if (!preg_match("/#[a-z0-9_]*$/",$channel)) $errmsg[] = $user->lang['IRC_INVALID_CHANNEL'];
                if (!empty($advanced) AND !preg_match("/^[a-z0-9:_]* = [^\"\\t\\r\\n]*$/im", $advanced)) $errmsg[] = $user->lang['IRC_INVALID_SYNTAX'];

                if (count($errmsg) > 0)
				{
		$report = '<ul>';
                foreach ($errors as $msg) {
                        $report .= sprintf($user->lang['ERR_ARRAY_MESS'], $msg);
                }
		$report .= '</ul>';
		$template->assign_vars(array(
		'S_ERROR_HEADER'		=> $user->lang['ERROR'],
		'S_ERROR_MESS'		=> $report,
		));
		echo $template->fetch('error.html');
		close_out();
				}

                $buffer = "server = ".$server.$linebreak."channel = ".$channel.$linebreak.$advanced;
                @unlink("include/irc.ini");
                @$fp = fopen("include/irc.ini","w");
                if ($fp) {
                        @fputs($fp,$buffer);
                        @fclose($fp);
                } else {
		$template->assign_vars(array(
		'S_ERROR_HEADER'		=> $user->lang['ERROR'],
		'S_ERROR_MESS'		=> sprintf($user->lang['IRC_WRIET_PROT_SAVE'],nl2br($buffer)),
		));
		echo $template->fetch('error.html');
		close_out();
                }
        }
        elseif ($delete AND file_exists("include/irc.ini")) {
                if (!@unlink("include/irc.ini"))
				{
					$template->assign_vars(array(
					'S_ERROR_HEADER'		=> $user->lang['ERROR'],
					'S_ERROR_MESS'		=> $user->lang['IRC_WRIET_PROT'],
					));
					echo $template->fetch('error.html');
					close_out();
				} 
        }
                                $template->assign_vars(array(
								        'S_SUCCESS'            => true,
										'S_FORWARD'			=> $siteurl."/admin.php?i=siteinfo&op=irc",
								        'TITTLE_M'          => $user->lang['IRC_INTRO'],
                                        'MESSAGE'            => $user->lang['SAVED_SET'],
                                ));
		echo $template->fetch('message_body.html');
		close_out();
}

if (file_exists("include/irc.ini")) {
        $irc_enabled = true;
        $ircconfig = parse_ini_file("include/irc.ini");
} else {
        $irc_enabled = false;
        $ircconfig = Array("server" => "", "channel" => "#");
}

$advsettings = "";
foreach ($ircconfig as $key => $val) {
        if ($key == "server" OR $key == "channel") continue;

        $advsettings .= $key." = ".$val.$linebreak;
}
	$hidden = build_hidden_fields(array(
	'postback'	=> '1',
	"i"			=> 'siteinfo',
	"op"		=> 'irc',
	));
	$template->assign_vars(array(
	'U_ACTION'				=> $u_action,
	'HIDEN'					=> $hidden,
	'S_SERVER'				=> $ircconfig["server"],
	'S_CHANNEL'				=> $ircconfig["channel"],
	'S_ADVANCED'			=> $advsettings,
	'ENABL_APLY'			=> ((!$irc_enabled) ? $user->lang['IRC_ENABLE'] : $user->lang['APPLY_SETTINGS'] ),
	'IRCENABLED'			=> $irc_enabled,
	));
echo $template->fetch('admin/acp_irc.html');
		close_out();
?>