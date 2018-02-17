<?php
/*
*----------------------------phpMyBitTorrent V 2.0-----------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
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
*------              ©2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-----------------   Sunday, September 14, 2008 9:05 PM   ---------------------*
*/




require_once("include/configdata.php");
require_once("include/db/database.php");



//This way we protect database authentication against hacked mods


$sql = "SELECT * FROM ".$db_prefix."_admin_forum LIMIT 1;";

$configquery = $db->sql_query($sql)or btsqlerror($sql);

if (!$row = $db->sql_fetchrow($configquery)) ;
//Config parser start
$forumpx = $row["prefix"];
$cookie_name = $row['cookie_name'];
$cookie_domain = $row["cookie_domain"];
$cookie_path = $row["cookie_path"];
$logintime = $row['cookie_time'];
$forumshare = ($row["forum_share"]=="true") ? true : false;
$forumbase = $row["base_folder"];
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$phpbb2_basefile = $forumbase;
$activate_phpbb2_forum = true;
$phpbb2_folder = "./".$forumbase."/";
$phpbb_root_path = "";
$phpbb_root_path = "./";
$auto_post = $row["auto_post_forum"];
$allow_posting = ($row["auto_post"]=="true") ? true : false;
$db->sql_freeresult($configquery);

#Config Parser end
?>