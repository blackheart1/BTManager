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
* @version $Id: 3.0.0 donation_block.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
global $torrent_var, $db, $db_prefix,$id;

$previd = ("SELECT id, name FROM ".$db_prefix."_torrents WHERE id < $id ORDER BY id DESC LIMIT 1");
$prev = $db->sql_fetchrow($db->sql_query($previd));
$previds = $prev['id'];
$prevname = htmlspecialchars($prev['name']);

$nextid = ("SELECT id, name FROM ".$db_prefix."_torrents WHERE id > $id ORDER BY id ASC LIMIT 1");
$next = $db->sql_fetchrow($db->sql_query($nextid));
$nextid = $next['id'];
$nextname = htmlspecialchars($next['name']);

echo"
<table border=\"0\" width=\"100%\"><tr>
<td align=\"center\"><a href=\"/details.php?id=$previds\">Click To View Previous Torrent </a><BR><u>$prevname</font></u></td>
<td align=\"right\"><a href=\"/details.php?id=$nextid\">Click To View Next Torrent</a><BR><u>$nextname</font></u></td><BR>
</tr></table>";
?>