<?php
/*
*-------------------------------phpMyBitTorrent--------------------------------*
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
*------              ?2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*/
if (defined('IN_PMBT'))
{
	die ("You can't include this file");
}
else
{
	define("IN_PMBT",true);
}
require_once("common.php");
$user->set_lang('backend',$user->ulanguage);
//Last Torrents
$op = request_var('op', '');
$sql = "SELECT 
		T.id, 
		T.name, 
		T.descr, 
		T.seeders, 
		T.leechers, 
		T.category, 
		T.added, 
		T.bbcode_bitfield as tbbcode_bitfield,
		T.bbcode_uid as tbbcode_uid,
		UNIX_TIMESTAMP(T.added) AS pubDate, 
		T.size, 
		C.name as cat_name
		FROM ".$db_prefix."_torrents T, 
		".$db_prefix."_categories C ";
                $descra = "";
                $descrb = "";
switch($op) {
        case "category": {
				$cat	= (int)request_var('cat', 0);
                $sql .= "WHERE 
				T.banned = 'no' 
				AND T.visible = 'yes' 
				AND T.category = '".$cat."' 
				AND C.id = '".$cat."' 
				AND password IS NULL 
				ORDER BY 
				T.tot_peer, 
				T.seeders, 
				T.completed, 
				T.added 
				DESC LIMIT 10;";
                $descr = "RSS_BY_CAT";
                $descra = "";
                $descrb = $sitename;
                break;
        }
        case "best": {
                $sql .= "WHERE 
				banned = 'no' 
				AND T.visible = 'yes' 
				AND T.password IS NULL 
				AND C.id = T.category 
				ORDER BY T.tot_peer, T.seeders, T.completed, T.added DESC LIMIT 10;";
                $descr = "RSS_BY_BEST";
                $descra = $sitename;
                $descrb = "";
                break;
        }
        case "search": {
				$dead	= request_var('dead', '');
		        if(!isset($dead))
				$rssdead ="AND T.visible = 'yes' ";
				else
				$rssdead = "";
				$search	= request_var('search', '');
				$cat	= (int)request_var('cat', 0);
				$orderby	= request_var('orderby', '');
				$ordertype	= request_var('ordertype', '');
				$incldead	= request_var('incldead', '');
                $cat = (isset($cat)) ? intval($cat) : 0;
                $orderby = (isset($orderby)) ? intval($orderby) : -1;
                $sql .= "WHERE 
				T.banned = 'no' 
				".$rssdead." 
				AND C.id = T.category 
				AND T.password IS NULL ";
                if (!empty($search)) $sql .= " AND T.search_text LIKE ('%".$db->sql_escape(searchfield($search))."%') ";
                if (!isset($ordertype) OR $ordertype != "ASC") $ordertype = "DESC";
                if (isset($incldead) AND $incldead != "true") $sql .= "AND T.visible = 'yes' ";
                if ($cat > 0) $sql .= " AND T.category = '".$cat."' ";
				switch ($orderby) {
					case 0: {
							$sql .= "ORDER BY T.added ".$ordertype;
							break;
					}
					case 1: {
							$sql .= "ORDER BY T.seeders ".$ordertype;
							break;
					}
					case 2: {
							$sql .= "ORDER BY T.leechers ".$ordertype;
							break;
					}
					case 3: {
							$sql .= "ORDER BY T.tot_peer ".$ordertype;
							break;
					}
					case 4: {
							$sql .= "ORDER BY T.downloaded ".$ordertype;
							break;
					}
					
					case 5: {
							$sql .= "ORDER BY T.ratingsum ".$ordertype;
							break;
					}
					case 6: {
							$sql .= "ORDER BY T.name ".$ordertype;
							break;
					}
					case 7: {
							$sql .= "ORDER BY T.size ".$ordertype;
							break;
					}
					case 8: {
							$sql .= "ORDER BY T.numfiles ".$ordertype;
							break;
					}
					default: {
							$sql .= "ORDER BY T.id ".$ordertype;
					}
				}
				$sql .= " LIMIT 10;";
				$descr = "RSS_BY_SEARCH";
                $descrb = $sitename;
				$descra = $search;
				break;
		}
        case "last":
        default: {
                $sql .= "WHERE 
				T.banned = 'no'  
				AND C.id = T.category 
				AND T.password IS NULL 
				ORDER BY added DESC LIMIT 10;";
                $descr = "RSS_BY_LAST";
                $descra = $sitename;
                $descrb = "";
        }
}

$res = $db->sql_query($sql);
$ids = Array();
$names = Array();
$category = Array();
$descrs = Array();
$seeds = Array();
$leeches = Array();
$pubd = Array();
$sizet = Array();
	include_once('include/function_posting.' . $phpEx);
	include_once('include/class.bbcode.php');
	
	// Grab icons
	$icons = $pmbt_cache->obtain_icons();
	$bbcode = false;
while ($row = $db->sql_fetchrow($res)) {
		$descript = censor_text($row['descr']);
		// Instantiate BBCode if need be
		if ($row['tbbcode_bitfield'])
		{
			include_once('include/bbcode.' . $phpEx);
			$bbcode = new bbcode($row['tbbcode_bitfield']);
			$bbcode->bbcode_second_pass($descript, $row['tbbcode_uid'], $row['tbbcode_bitfield']);
		}
		// Parse the message and subject
		$descript = bbcode_nl2br($descript);
		$descript = parse_smiles($descript);
		$pubd[] = date(DATE_RFC2822, $row['pubDate']);
		$category[] = $row["cat_name"];
		if($op == 'category')$descra = $row["cat_name"];
        $ids[] = $row["id"];
		$sizet[] = $row["size"];
        $names[] = $row["name"];
        $descrs[] = "<font size=\"3\">
						<b>" . $user->lang['CATEGORY'] . ":</b>
					</font> ".$row["cat_name"]."<br />
					<font size=\"3\">
						<b>" . $user->lang['DESCRIPTION'] . ":</b>
					<br /></font> ".$descript."<br /> 
					<font size=\"3\"><b>" . $user->lang['SEEDERS'] . ": </b></font>".$row["seeders"]."<br /> 
					<font size=\"3\"><b>" . $user->lang['LEECHERS'] . ": </b></font>".$row["leechers"];
        $seeds[] = $row["seeders"];
        $leeches[] = $row["leechers"];
}
$db->sql_freeresult($res);
if (!$persistency) $db->sql_close();
if (phpversion() < '5') {
	require("include/rss/backend-php4.php");
}else{
	require("include/rss/backend-php5.php");
}
die();
?>