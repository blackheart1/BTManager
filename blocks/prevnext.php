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
** File prevnext.php 2018-02-18 14:32:00 joeroberts
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT'))
{
	include_once './../security.php';
	die ();
}
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