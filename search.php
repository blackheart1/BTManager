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
* @version $Id: 3.0.0 search.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
require_once("common.php");
include_once 'include/function_posting.php';
include_once 'include/class.bbcode.php';
require_once("include/torrent_functions.php");
$template = new Template();
$user->set_lang('torrent',$user->ulanguage);
				$search		= utf8_normalize_nfc(request_var('search', '',true));
				$orderby	= request_var('sort', '0');
				$ordertype	= request_var('type', '');
				$dead		= request_var('incldead', '');
				$page		= request_var('page', '1');
				$cat		= request_var('cats',  array(''));
				$catmain	= request_var('catmain', array());
set_site_var($user->lang['SEARCH'] . '-' . $search);
$cats2 = genrelist2();
$wherecatina = array();
$catmain = '1';
$catmid = false;
$catval ='';
foreach($cats2 as $cat3)
{
	$cat_var	=	request_var('cats' . $cat3['id'],  array('0'));
	if(isset($cat_var))
	{
		foreach($cat_var as $v)
		{
			$catval .= '&cats' . $cat3['id'] . '[]=' .$v ;
			array_push($wherecatina,$v);
		}
		$catmid = true;
	}
}
include('actb.php');
pmbt_include_templ('blocks/search_block.php', 'cats_var');
#VARIABLE PARSING
$cat = (isset($cat)) ? intval($cat) : 0;
$orderby = (isset($orderby)) ? intval($orderby) : -1;
if (!isset($ordertype) OR $ordertype != "ASC") $ordertype = "DESC";
if(!isset($dead))$dead = false;
if (!isset($page) OR !is_numeric($page) OR $page < 1) $page = 1;
$from = ($page - 1) * $torrent_per_page;
//die(print_r($wherecatina));
$search = $db->sql_escape(unesc($search));
$catmain = implode("', '",$wherecatina);
$banwhere = "".$db_prefix."_torrents.banned = 'no' ";
$passwhere = "AND ".$db_prefix."_torrents.password IS NULL ";
if ($user->moderator) $banwhere = "".$db_prefix."_torrents.banned IN ('no','yes') ";
if ($user->premium) $passwhere = "";

$totsql = "SELECT COUNT(*) as tot FROM ".$db_prefix."_torrents WHERE ".$banwhere.$passwhere." ";
$sql = "SELECT 
			".$db_prefix."_torrents.*, 
			IF(".$db_prefix."_torrents.numratings < '$minvotes', NULL, ROUND(".$db_prefix."_torrents.ratingsum / ".$db_prefix."_torrents.numratings, 1)) AS rating, 
			".$db_prefix."_categories.name AS cat_name, 
			".$db_prefix."_categories.image AS cat_pic, 
			".$db_prefix."_categories.parent_id AS parent_id, 
					U.username, 
			U.username,IF(U.name IS NULL, U.username, U.name) as user_name, 
					U.level as user_level, 
					U.can_do as can_do, 
					L.group_colour AS color, 
					L.group_name AS lname 
			FROM ".$db_prefix."_torrents 
			LEFT JOIN ".$db_prefix."_categories ON category = ".$db_prefix."_categories.id 
			LEFT JOIN ".$db_prefix."_users U ON ".$db_prefix."_torrents.owner = U.id 
				LEFT JOIN 
					".$db_prefix."_level_settings L ON L.group_id = U.can_do 
			WHERE ".$banwhere.$passwhere." ";
if (!empty($search) AND $search != '') {
$search1 = $db->sql_escape(str_replace(" ",".",$search));
$search2 = $db->sql_escape(str_replace(" ","-",$search));
$search3 =$db->sql_escape( str_replace(" ","_",$search));
        $totsql .= 'AND  (search_text LIKE "%'.$db->sql_escape($search).'%" 
		OR search_text LIKE "%'.$search1.'%" 
		OR search_text LIKE "%'.$search2.'%" 
		OR search_text LIKE "%'.$search3.'%" 
		OR '.$db_prefix.'_torrents.name LIKE "%'.$db->sql_escape($search).'%" 
		OR '.$db_prefix.'_torrents.name LIKE "%'.$search1.'%" 
		OR '.$db_prefix.'_torrents.name LIKE "%'.$search2.'%" 
		OR '.$db_prefix.'_torrents.name LIKE "%'.$search3.'%" 
		OR '.$db_prefix.'_torrents.descr LIKE "%'.$db->sql_escape($search).'%" 
		OR '.$db_prefix.'_torrents.descr LIKE "%'.$search1.'%" 
		OR '.$db_prefix.'_torrents.descr LIKE "%'.$search2.'%" 
		OR '.$db_prefix.'_torrents.descr LIKE "%'.$search3.'%" 
		OR '.$db_prefix.'_torrents.filename LIKE "%'.$db->sql_escape($search).'%" 
		OR '.$db_prefix.'_torrents.filename LIKE "%'.$search1.'%" 
		OR '.$db_prefix.'_torrents.filename LIKE "%'.$search2.'%" 
		OR '.$db_prefix.'_torrents.filename LIKE "%'.$search3.'%") 
		';
        $sql .= ' AND (search_text LIKE "%'.$db->sql_escape($search).'%" 
		OR search_text LIKE "%'.$search1.'%" 
		OR search_text LIKE "%'.$search2.'%" 
		OR search_text LIKE "%'.$search3.'%" 
		OR '.$db_prefix.'_torrents.name LIKE "%'.$db->sql_escape($search).'%" 
		OR '.$db_prefix.'_torrents.name LIKE "%'.$search1.'%" 
		OR '.$db_prefix.'_torrents.name LIKE "%'.$search2.'%" 
		OR '.$db_prefix.'_torrents.name LIKE "%'.$search3.'%" 
		OR '.$db_prefix.'_torrents.descr LIKE "%'.$db->sql_escape($search).'%" 
		OR '.$db_prefix.'_torrents.descr LIKE "%'.$search1.'%" 
		OR '.$db_prefix.'_torrents.descr LIKE "%'.$search2.'%" 
		OR '.$db_prefix.'_torrents.descr LIKE "%'.$search3.'%" 
		OR '.$db_prefix.'_torrents.filename LIKE "%'.$db->sql_escape($search).'%" 
		OR '.$db_prefix.'_torrents.filename LIKE "%'.$search1.'%" 
		OR '.$db_prefix.'_torrents.filename LIKE "%'.$search2.'%" 
		OR '.$db_prefix.'_torrents.filename LIKE "%'.$search3.'%") 
		';
}
if (!$dead == 'true') {
        $sql .= "AND visible = 'yes' ";
        $totsql .= "AND visible = 'yes' ";
}
if ($cat > 0){
        $sql .= "AND ".$db_prefix."_torrents.category = '".$cat."' ";
        $totsql .= "AND ".$db_prefix."_torrents.category = '".$cat."' ";
}
if($catmain){
$sql .= "AND ".$db_prefix."_torrents.category IN ('".$catmain."') ";
$totsql .= "AND ".$db_prefix."_torrents.category IN ('".$catmain."') ";
}

switch ($orderby) {
        case 0: {
                $sql .= "ORDER BY ".$db_prefix."_torrents.added ".$ordertype;
                break;
        }
	case 1: {
                $sql .= "ORDER BY ".$db_prefix."_torrents.seeders ".$ordertype;
                break;
        }
        case 2: {
                $sql .= "ORDER BY ".$db_prefix."_torrents.leechers ".$ordertype;
                break;
        }
        case 3: {
                $sql .= "ORDER BY ".$db_prefix."_torrents.tot_peer ".$ordertype;
                break;
        }
	case 4: {
                $sql .= "ORDER BY ".$db_prefix."_torrents.downloaded ".$ordertype;
                break;
        }
        
        case 5: {
                $sql .= "ORDER BY ".$db_prefix."_torrents.ratingsum ".$ordertype;
                break;
        }
	case 6: {
                $sql .= "ORDER BY ".$db_prefix."_torrents.name ".$ordertype;
                break;
        }
        case 7: {
                $sql .= "ORDER BY ".$db_prefix."_torrents.size ".$ordertype;
                break;
        }
        case 8: {
                $sql .= "ORDER BY ".$db_prefix."_torrents.numfiles ".$ordertype;

                break;
        }
        default: {
                $sql .= "ORDER BY ".$db_prefix."_torrents.id ".$ordertype;
        }
}

$sql .= " LIMIT ".intval($from).", ".intval($torrent_per_page).";";
//die($sql);

$res = $db->sql_query($sql) or btsqlerror($sql);
$totres = $db->sql_query($totsql)or btsqlerror($totsql);
if (isset($orderby))

{

$sort1= "&orderby=".$orderby."&ordertype=".$ordertype;

$sort2= "?orderby=".$orderby."&ordertype=".$ordertype;

}

else

{

$sort1="";

$sort2="";

}
$t_sort = array('i','a','b','c','d','e','f','g','h');
$t_type = array('asc'=>'desc','desc'=>'asc','DESC'=>'asc');

        list ($tot) = $db->fetch_array($totres);
        $db->sql_freeresult($totres);

        if ($db->sql_numrows($res) > 0) {
				$page_link = $sort1;
				if($search) $page_link = '&amp;search=' . $search;
                $template->assign_vars(array(
						'PAGE_LINK'				=>	$page_link,
                        'S_TORRENTS'            => true,
						'T_SORT'				=>	$t_sort[$orderby],
						'T_SHORT'				=>	$t_type[$ordertype],
						'T_SEARCH'				=>	stripslashes($search),
						'TINCDEAD'				=>	($dead == 'true')? true : false,
                ));
                $pages = ceil($tot / $torrent_per_page);
                generate_torrentpager('search.php?search=' . $search . '&amp;page=', $page, $pages, $catval , $sort1 , $sort2 );
                get_tor_vars($res);
        }
		else
		{
		                $template->assign_vars(array(
                        'S_TORRENTS'            => false,
                ));
		}
$template->assign_vars(array(
		'HIT_COUNT'            => ($user->admin) ? false : true,
));
echo $template->fetch('torrents_body.html');
	close_out();
?>