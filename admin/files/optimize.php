<?php
/**
**********************
** BTManager v3.0.1 **
**********************
** http://www.btmanager.org/
** https://github.com/blackheart1/BTManager
** http://demo.btmanager.org/index.php
** Licence Info: GPL
** Copyright (C) 2018
** Formerly Known As phpMyBitTorrent
** Created By Antonio Anzivino (aka DJ Echelon)
** And Joe Robertson (aka joeroberts/Black_Heart)
** Project Leaders: Black_Heart, Thor.
** File optimize.php 2018-02-23 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT'))
{
	include_once './../../security.php';
	die ("You can't access this file directly");
}
$user->set_lang('admin/acp_optimize',$user->ulanguage);
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