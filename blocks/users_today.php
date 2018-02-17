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
*--------------------   Monday, May 30, 2011 1:05 AM   ------------------------*
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 users_today.php  2011-05-30 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
global $db_prefix, $user, $db, $pmbt_cache,$template;
if(!$pmbt_cache->get_sql("today_online")){
		unset($rowsets);
		$rowsets = array();
        $sql = "SELECT U.id as id, IF(U.name IS NULL, U.username, U.name) as name, U.donator as donator, U.warned as warned, (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(lastlogin)) as def, U.can_do as can_do, U.level as level, UNIX_TIMESTAMP(U.lastlogin) as lastlogin, L.group_colour as color
			FROM ".$db_prefix."_users U , ".$db_prefix."_level_settings L 
		WHERE U.active = 1 
		AND UNIX_TIMESTAMP(U.lastlogin) > UNIX_TIMESTAMP(NOW()) - 86400 
		AND L.group_id = U.can_do
		ORDER BY username  ASC;";
        $res = $db->sql_query($sql);
	while ($rowset = $db->sql_fetchrow($res) ) {
        $rowsets[] = $rowset;
    }
        $db->sql_freeresult($res);
$pmbt_cache->set_sql("today_online", $rowsets);
}else{
$rowsets = $pmbt_cache->get_sql("today_online");
}
if (sizeof($rowsets)){
        foreach ($rowsets  as $id=>$row) {
   			$template->assign_block_vars('user_today', array(
			"USERNAME"          => htmlspecialchars($row["name"]),
			"DONER"             => ($row["donator"] == 'true') ? true : false,
			"WARNED"            => ($row["warned"] == '1') ? true : false,
			"ID"                =>  $row['id'],
			"COLOR"             => $row["color"],
			"LEVEL_ICON"        => ($row["level"] == "admin") ? pic("icon_admin.gif",'','admin') : (($row["level"] == "moderator") ? pic("icon_moderator.gif",'','moderator') : (($row["level"] == "premium") ?  pic("icon_premium.gif",'','premium') : '')),
			'LAST_CLICK'        =>  get_formatted_timediff($row["lastlogin"])
  		 ));
		}
}
echo $template->fetch('users_today.html');				
?>