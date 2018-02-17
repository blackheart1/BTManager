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
* @version $Id: 3.0.0 torrents-needseed.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
global $db_prefix, $user, $db, $shout_config,$template,$siteurl,$language,$pmbt_cache;
$sql = ("SELECT id, name, downloaded, completed, seeders, leechers, added FROM ".$db_prefix."_torrents WHERE leechers > 0 AND seeders = 0 ORDER BY leechers DESC LIMIT 10");
$res = $db->sql_query($sql) or btsqlerror($sql);
$need_seed = array();
if ($db->sql_numrows($res) > 0)
	{
	$template->assign_vars(array(
	'IS_NEED_SEEDS' => true,
	));
	$i=0;
		while ($arr = $db->sql_fetchrow($res))
			{
			$torrname = htmlspecialchars($arr['name']);
			$torrname = str_replace(array('-','_'),array(' ',' '),$torrname);
				if (strlen($torrname) > 55)
				$torrname = substr($torrname, 0, 55) . "...";
$need_seed[] = array_push($need_seed,array(
'SEED_NAME_SHORT' => $torrname,
'SEED_ID' => $arr['id'],
'SEED_NAME' => htmlspecialchars(stripslashes($arr['name'])),
'SEED_LEECH' => number_format($arr['leechers']),
'SEED_DOWN' => number_format($arr['downloaded']),
'SEED_ADDED' => $arr['added'],
'SEED_COMPL' => number_format($arr['completed'])));
}
$i++;
}
else
{
	$template->assign_vars(array(
	'IS_NEED_SEEDS' => false
	));
}
foreach($need_seed as $val){
if(is_array($val))$template->assign_block_vars('need_seeded',$val);
}
echo $template->fetch('need_seeders.html');				
?>