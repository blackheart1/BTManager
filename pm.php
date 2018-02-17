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
if (defined('IN_PMBT'))die ("You can't include this file...");
define("IN_PMBT",true);
require_once("common.php");
$user->set_lang('pm',$user->ulanguage);
$template = new Template();
if($user->id == 0 OR !checkaccess('u_sendpm')){
              set_site_var('- '.$user->lang['USER_CPANNEL'].' - '.$user->lang['BT_ERROR']);
                                $template->assign_vars(array(
								        'S_ERROR'			=> true,
										'S_FORWARD'				=> false,
								        'TITTLE_M'			=> $user->lang['GEN_ERROR'],
                                        'MESSAGE'			=> sprintf($user->lang['GROUP_NO_ACCESS_PAGE'],getlevel($user->group)).back_link('./index.php'),
                                ));
							echo $template->fetch('message_body.html');
							close_out();
}
if (!isset($op)) {
        if (isset($mid1) AND is_numeric($mid)) $op = "readmsg";
        else $op = "inbox";
}

switch($op) {
        case "blacklist": {
                if (!isset($id) OR !is_numeric($id)) bterror($user->lang['NO_SUCH_USER'],_btpm);
                $sqlcheck = "SELECT id FROM ".$db_prefix."_users WHERE id = '".$id."';";
                $rescheck = $db->sql_query($sqlcheck);
                $n = $db->sql_numrows($rescheck);
                $db->sql_freeresult($rescheck);
                if (!$n) bterror($user->lang['NO_SUCH_USER'],_btpm);
                $sql = "INSERT INTO ".$db_prefix."_private_messages_blacklist (master, slave) VALUES ('".$user->id."','".$id."');";
                $db->sql_query($sql) or btsqlerror($sql);
                $sql = "DELETE FROM ".$db_prefix."_private_messages_bookmarks WHERE master = '".$user->id."' AND slave = '".$id."';";
                $db->sql_query($sql) or btsqlerror($sql);
                header("Location: pm.php?op=inbox");
                die();
        }
                case "removeblacklist": {
                if (!isset($id) OR !is_numeric($id)) bterror($user->lang['NO_SUCH_USER'],_btpm);
                $sqlcheck = "SELECT id FROM ".$db_prefix."_users WHERE id = '".$id."';";
                $rescheck = $db->sql_query($sqlcheck);
                $n = $db->sql_numrows($rescheck);
                $db->sql_freeresult($rescheck);
                if (!$n) bterror($user->lang['NO_SUCH_USER'],_btpm);
                $sql = "DELETE FROM ".$db_prefix."_private_messages_blacklist WHERE master = '".$user->id."' AND slave = '".$id."';";
                $db->sql_query($sql) or btsqlerror($sql);
                header("Location: pm.php?op=inbox");
                die();
        }

        case "bookmark": {
                if (!isset($id) OR !is_numeric($id)) bterror($user->lang['NO_SUCH_USER'],_btpm);
                $sqlcheck = "SELECT id FROM ".$db_prefix."_users WHERE id = '".$id."';";
                $rescheck = $db->sql_query($sqlcheck);
                $n = $db->sql_numrows($rescheck);
                $db->sql_freeresult($rescheck);
                if (!$n) bterror($user->lang['NO_SUCH_USER'],_btpm);
                $sql = "INSERT INTO ".$db_prefix."_private_messages_bookmarks (master, slave) VALUES ('".$user->id."','".$id."');";
                $db->sql_query($sql) or btsqlerror($sql);
                $sql = "DELETE FROM ".$db_prefix."_private_messages_blacklist WHERE master = '".$user->id."' AND slave = '".$id."';";
                $db->sql_query($sql) or btsqlerror($sql);
                header("Location: pm.php?op=inbox");
                die();
        }
                case "removebookmark": {
                if (!isset($id) OR !is_numeric($id)) bterror($user->lang['NO_SUCH_USER'],_btpm);
                $sqlcheck = "SELECT id FROM ".$db_prefix."_users WHERE id = '".$id."';";
                $rescheck = $db->sql_query($sqlcheck);
                $n = $db->sql_numrows($rescheck);
                $db->sql_freeresult($rescheck);
                if (!$n) bterror($user->lang['NO_SUCH_USER'],_btpm);
                $sql = "DELETE FROM ".$db_prefix."_private_messages_bookmarks WHERE master='".$user->id."' AND slave = '".$id."';";
                $db->sql_query($sql) or btsqlerror($sql);
                header("Location: pm.php?op=inbox");
                die();
        }
        case "send": {
				set_site_var($user->lang['_UCP_PM']);
                include("pm/send.php");
                break;
        }
        case "readmsg": {
				set_site_var($user->lang['_UCP_PM']);
                include("pm/readmsg.php");
                break;
        }
		case "drafts": {
					set_site_var($user->lang['_UCP_PM']);
					include("pm/drafts.php");
					break;
		}
		case "options": {
					set_site_var($user->lang['_UCP_PM']);
					include("pm/options.php");
					break;
		}
		case "folder":
		case "inbox":
		default: {
				set_site_var($user->lang['_UCP_PM']);
				$u_action = 'pm.php';
				include("pm/inbox.php");
				break;
		}
}

?> 