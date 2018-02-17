<?php
/*
*------------------------------phpMyBitTorrent V 3.0.0-------------------------* 
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
*--------------------   Sunday, May 14, 2010 9:05 PM   ------------------------*
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 shoutbox.php  2011-10-15 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
require_once("include/ucp/functions_privmsgs.php");
require_once("include/ucp/ucp_pm_compose.php");
require_once("include/class.bbcode.php");
require_once'include/functions_forum.php';
$action = request_var('action', 'post');
		$folder_specified = request_var('folder', '');

		if (!in_array($folder_specified, array('inbox', 'outbox', 'sentbox')))
		{
			$folder_specified = (int) $folder_specified;
		}
		else
		{
			$folder_specified = ($folder_specified == 'inbox') ? 0 : (($folder_specified == 'outbox') ? -2 : -1);
		}

		if (!$folder_specified)
		{
			$mode = (!$mode) ? request_var('mode', 'view') : $mode;
		}
		else
		{
			$mode = 'view';
		}
$template->assign_vars(array(
        'T_TEMPLATE_PATH'         => $siteurl . '/themes/' . $theme . '/templates',
        'S_PRIVMSGS'         => true,
        'ERROR_MESSAGE'         => false,
		'PMBT_LINK_BACK'		=> 'pm.php?',
        'S_UCP_ACTION'          => 'pm.php?op=inbox',
));
        $sql = "SELECT B.slave, U.username, IF (U.name IS NULL, U.username, U.name) as name, U.can_do as can_do, U.lastlogin as laslogin, U.Show_online as show_online FROM ".$db_prefix."_private_messages_bookmarks B LEFT JOIN ".$db_prefix."_users U ON B.slave = U.id WHERE B.master = '".$user->id."' ORDER BY name ASC;";
        $res = $db->sql_query($sql) or btsqlerror($sql);
        if ($n = $db->sql_numrows($res)) {
                for ($i = 1; list($uid, $username, $user_name, $can_do, $laslogin, $show_online) = $db->fetch_array($res); $i++) {
		$which = (time() - 300 < sql_timestamp_to_unix_timestamp($laslogin) && ($show_online == 'true' || $user->admin)) ? 'online' : 'offline';

		$template->assign_block_vars("friends_{$which}", array(
			'USER_ID'		=> $uid,
			'USER_COLOUR'	=> getusercolor($can_do),
			'USERNAME'		=> $username,
			'USERNAME_FULL'	=> $user_name)
		);
                }
        }
        $db->sql_freeresult($res);
				$action = request_var('action', 'post');
				get_folder($user->id);
				compose_pm($id, $mode, $action);
echo $template->fetch('pm_send.html');
close_out();
?> 