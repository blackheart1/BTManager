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
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 optimize.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
$user->set_lang('admin/optimize',$user->ulanguage);
		$template->assign_vars(array(
			'L_TITLE'		=> $user->lang['_admstatus'],
			'L_TITLE_EXPLAIN'		=> $user->lang['_admoptimizedbexplain'],
			));
$tot_data = 0;
$tot_idx = 0;
$tot_all = 0;
$local_query = "SHOW TABLE STATUS LIKE '".$db_prefix."_%';";
$result = $db->sql_query($local_query) or btsqlerror($local_query);
if ($db->sql_numrows($result) > 0) {
        while ($row = $db->sql_fetchrow($result)) {
                $tot_data = $row["Data_length"];
                $tot_idx  = $row["Index_length"];
                $total = $tot_data + $tot_idx;
                $gain= $row["Data_free"];
                $local_query = "REPAIR TABLE ".$row['Name'];
                $db->sql_query($local_query) or btsqlerror($local_query);
                $local_query = "OPTIMIZE TABLE ".$row['Name'];
                $resultat  = $db->sql_query($local_query) or btsqlerror($local_query);
                if ($gain == 0) {
			$template->assign_block_vars('log', array(
				'TABLE'			=> htmlspecialchars($row['Name']),
				'SIZE'				=> mksize($total),
				'STATUS'				=> $user->lang["_admaoptimized"],
				'SPACE'			=> mksize(0),
				));
                } else {
			$template->assign_block_vars('log', array(
				'TABLE'			=> htmlspecialchars($row['Name']),
				'SIZE'				=> mksize($total),
				'STATUS'				=> $user->lang["_admoptimized"],
				'SPACE'			=> mksize($gain),
				));
                }
                $db->sql_freeresult($resultat);
        }
}
$db->sql_freeresult($result);
$db->sql_query("UPDATE ".$db_prefix."_torrents SET seeders = 0, leechers = 0, tot_peer = 0, speed = 0 WHERE tracker IS NULL;");

$sql = "DELETE FROM ".$db_prefix."_peers WHERE UNIX_TIMESTAMP(last_action) < UNIX_TIMESTAMP(NOW()) - ".intval($announce_interval).";";
$res = $db->sql_query($sql) or btsqlerror($sql);
$sql = "SELECT count(*) as tot, torrent, seeder, (SUM(download_speed)+SUM(upload_speed))/2 as speed FROM ".$db_prefix."_peers GROUP BY torrent, seeder;";
$res = $db->sql_query($sql) or btsqlerror($sql);
while($row = $db->sql_fetchrow($res)) {
        if ($row["seeder"]=="yes") $sql = "UPDATE ".$db_prefix."_torrents SET seeders= '".$row["tot"]."', speed = speed + '".intval($row["speed"])."' WHERE id='".$row["torrent"]."'; ";
        else $sql = "UPDATE ".$db_prefix."_torrents SET leechers='".$row["tot"]."', speed = speed + '".intval($row["speed"])."' WHERE id='".$row["torrent"]."'; ";
        $db->sql_query($sql);
}

$db->sql_query("UPDATE ".$db_prefix."_torrents SET tot_peer = seeders + leechers;");
$db->sql_query("UPDATE ".$db_prefix."_snatched SET seeder = 'no';");
$sql = "SELECT uid, torrent FROM ".$db_prefix."_peers WHERE seeder = 'yes';";
$res = $db->sql_query($sql) or btsqlerror($sql);
while($row = $db->sql_fetchrow($res)) {
$db->sql_query("UPDATE ".$db_prefix."_snatched SET seeder = 'yes' WHERE userid = '".$row["uid"]."' AND torrentid = '".$row["torrent"]."';");
}
echo $template->fetch('admin/optimize.html');
		close_out();
?>