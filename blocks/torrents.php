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
*------              �2010 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*--------------------   Sunday, May 14, 2010 9:05 PM   ------------------------*
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 whos_online.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
global $db_prefix, $user, $auth, $db, $shout_config,$template,$siteurl,$language,$pmbt_cache,$minvotes;
        global $name, $search, $user, $download_level, $torrent_global_privacy, $onlysearch, 
		$autoscrape, $theme, $btback1, $btback2, $btback3, $free_dl,$page, $prev, $pages, $pager, $next;
$cat_main = array();
$cat_sub = array();
        if(! $res = $db->sql_query(
        "SELECT *
			FROM `".$db_prefix."_categories`
			ORDER BY `".$db_prefix."_categories`.`parent_id` , 
			`".$db_prefix."_categories`.`id` , 
			`".$db_prefix."_categories`.`sort_index` ASC"
        ))bterror("SELECT id, name FROM ".$db_prefix."_categories ORDER BY sort_index, id ASC");

        while ($row = $db->sql_fetchrow($res))
		{
			if($row['parent_id'] == '-1')
			{
				$cat_main[] = array(
						"ID"           => $row['id'],
						"NAME"         => $row['name'],
						"IMAGE"        => (file_exists("themes/".$theme."/pics/cat_pics/".$row["image"])) ? "<img src=\"themes/".$theme."/pics/cat_pics/".$row["image"]."\" title=\"".$row["name"]."\" border=\"0\" alt=\"".$row["name"]."\" width=\"30px\">" : "<img src=\"cat_pics/".$row["image"]."\" border=\"0\" title=\"".$row["name"]."\" alt=\"".$row["name"]."\" width=\"30px\">",
				   );
			}
			else
			{//subcount
			$cat_sub[$row['parent_id']][] = array(
						"ID"           => $row['id'],
				   );
			}
		}

$orderby = " ORDER BY ".$db_prefix."_torrents.evidence DESC, ";//
$catmain = '';
if ($user->moderator)$catmain = '1';
require_once("include/torrent_functions.php");

		foreach($cat_main as $key=>$val)
		{
			$template->assign_vars(array(
					'IND_CAT_NAME'     => $val['NAME'],
					));
					$template->assign_block_vars('index_tor',array('NAME' =>$val['NAME']));
				foreach($cat_sub[$val['ID']] as $keys => $vals)
			{
				$catwhere = " AND ".$db_prefix."_torrents.category = ".intval($vals['ID']);
				$passwhere = " AND ".$db_prefix."_torrents.password IS NULL ";
				$viswhere = "visible = 'yes' AND banned = 'no'";
				if ($user->moderator) $viswhere = "";
				if ($user->premium) $passwhere = "";
				$sql = "SELECT 
							".$db_prefix."_torrents.*, 
							IF(".$db_prefix."_torrents.numratings < '".$minvotes."', NULL, ROUND(".$db_prefix."_torrents.ratingsum / ".$db_prefix."_torrents.numratings, 1)) AS rating, 
							".$db_prefix."_categories.name AS cat_name, 
							".$db_prefix."_categories.image AS cat_pic, 
							U.username, 
							IF(U.name IS NULL, U.username, U.name) as user_name, 
							U.level as user_level, 
							U.can_do as can_do, 
							L.group_colour AS color, 
							L.group_name AS lname 
						FROM 
							".$db_prefix."_torrents 
						LEFT JOIN 
							".$db_prefix."_categories ON category = ".$db_prefix."_categories.id 
						LEFT JOIN 
							".$db_prefix."_users U ON ".$db_prefix."_torrents.owner = U.id 
						LEFT JOIN 
							".$db_prefix."_level_settings L ON L.group_id = U.can_do 
						WHERE 
							".$catmain.$viswhere.$catwhere.$passwhere.$orderby.$db_prefix."_torrents.added 
							DESC 
							LIMIT 0,5;";
				$res = $db->sql_query($sql) or mysql_error();
        if ($db->sql_numrows($res) > 0) {
		//die($sql);
                get_tor_vars($res, "",  "", "", '_ind');
				$template->assign_block_vars('index_tor.tsble',array('OUT' => $template->fetch('index_torrents.html')));
				unset($template->_tpldata['torrent_var_ind']);
				}
				$db->sql_freeresult($res);

			}
		}

	$template->assign_vars(array(
			'SHOW_ALL'     => true,
			));

echo $template->fetch('index_torrents.html');
?>