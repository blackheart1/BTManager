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
*------              2009 phpMyBitTorrent Development Team              ------* 
*-----------               http://phpmybittorrent.com               -----------* 
*------------------------------------------------------------------------------* 
*-----------------   Sunday, September 14, 2008 9:05 PM   ---------------------* 
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 admin_reg_details.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/ 
if (!defined('IN_PMBT')) die ("You can't access this file directly");
		if((!checkaccess('m_edit_user')) OR (is_founder(getlevel_name($id)) && !is_founder($user->group))){
              set_site_var('- '.$user->lang['USER_CPANNEL'].' - '.$user->lang['BT_ERROR']);
			  meta_refresh('5',$siteurl."/index.php");
                                $template->assign_vars(array(
								        'S_ERROR_HEADER'          =>$user->lang['ACCESS_DENIED'],
                                        'S_ERROR_MESS'            => $user->lang['NO_EDIT_PREV'],
                                ));
             echo $template->fetch('error.html');
			close_out();
	}
       				         include 'admin/functions.php';
$hiden = array(
'take_edit'				=> '1',
'action'				=> 'profile',
'op'				=> 'editprofile',
'mode'				=> 'admin_reg_details',
);
$sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.Columns where TABLE_NAME = '".$db_prefix."_levels'
AND COLUMN_NAME NOT IN ('level','name','group_id','group_type','color','group_desc')";
$result = $db->sql_query($sql);
$val = array();
	while ($row = $db->sql_fetchrow($result))
	{
$val[] = $row[0];
	}
	$db->sql_freeresult($result);
        $adminlevel = "<select name=\"level\">";
        $adminlevel .= "<option ".(($userrow["level"] == "user") ? "selected " :'' )."value=\"user\">".$user->lang['USER']."</option>";
        $adminlevel .= "<option ".(($userrow["level"] == "premium") ? "selected " :'' )."value=\"premium\">".$user->lang['G_PREMIUM_USER']."</option>";
        $adminlevel .= "<option ".(($userrow["level"] == "moderator") ? "selected " :'' )."value=\"moderator\">".$user->lang['G_MODERATOR']."</option>";
        $adminlevel .= "<option ".(($userrow["level"] == "admin") ? "selected " :'' )."value=\"admin\">".$user->lang['G_ADMINISTRATORS']."</option>";
        $adminlevel .= "</select>";
$template->assign_vars(array(
		'S_HIDDEN_FIELDS'		=> build_hidden_fields($hiden),
        'CP_MOD_COMENTS'        => $userrow["modcomment"],
		'U_SEEDBOX_IP'          => long2ip($userrow["seedbox"]),
		'U_IS_WARNED'           => ($userrow["warned"]) ? true : false,
		'U_WARNED_TELL'         => ($userrow["warned"]) ? gmdate("Y-m-d H:i:s",($userrow["warn_kapta"]+$userrow["warn_hossz"])) : '',
		'U_ACTIVATED_ACC'       => ($userrow["active"] == "1") ? true : false,
		'U_SITE_HELPER'         => ($userrow['helper'] == 'true') ? true : false,
		'U_FORUM_BANNED'        => ($userrow['forumbanned'] == 'yes') ? true : false,
		'U_SITE_HELP_WITH'      => $userrow["help_able"],
        'CP_TRUEUPLOADED'       => $userrow["uploaded"],
        'CP_TRUEDOWNLOADED'     => $userrow["downloaded"],
        'CP_INVITES'            => $userrow["invites"],
        'CP_SEED_POINTS'        => $userrow["seedbonus"],
        'CP_UUPLOADED'          => mksize($userrow["uploaded"]),
        'CP_UDOWNLOADED'        => mksize($userrow["downloaded"]),
        'CP_URATIO'             => get_u_ratio($userrow["uploaded"], $userrow["downloaded"]),
        'CP_UCOLOR'             => getusercolor($userrow["can_do"]),
		'CP_DISABLED'			=> ($userrow["disabled"] == 'true') ? true : false,
        'CP_DISABLED_REASON'	=> $userrow["disabled_reason"],
        'CP_UCANSHOUT'          => ($userrow["can_shout"] == 'true') ? true : false,
        'CP_UCAN_DO'            => $userrow["can_do"],
        'CP_UGROUP'             => getlevel($userrow["can_do"]),
		'S_GROUP_OPTIONS'	    => selectaccess($al= $userrow["can_do"]),
		'S_SHOW_ACTIVITY'		=> true,
		'A_GROUP'               => group_select_options_id($userrow["can_do"]),
		'A_LEVEL'               => $adminlevel,
));
?>