<?php
/*
*----------------------------phpMyBitTorrent V 2.0.4---------------------------*
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

if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
require_once("common.php");
$template = new Template();
set_site_var('');
  $error = "OK";
  $sql = "SELECT msg_id FROM ".$db_prefix."_privmsgs_to WHERE user_id = ".$user->id." AND pm_unread = 1  LIMIT 1;";
  $res = $db->sql_query($sql) or $error = "sql: ".$sql;
  $has_newpm = ($db->sql_numrows($res) > 0) ? true : false;
  $db->sql_freeresult($res);
  
  if ($has_newpm AND $user->pm_popup) $pmout = $user->lang['NEW_MESAGE'];
  else $pmout = "false";
  if ($pmout != "false") $confirmtext = "<confirm>".$user->lang['JAVA_NEW_PM']."</confirm>";
  else $confirmtext = "";
  
  $xmldata = "<response><status>".$error."</status><pm>".$pmout."</pm>".$confirmtext."</response>";
  header('Content-Type: text/xml');
  echo "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\" ?>\n";
  echo $xmldata;  
$db->sql_close();
exit();
?>