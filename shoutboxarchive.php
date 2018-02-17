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
* @version $Id: 3.0.0 shoutboxarcive.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/
if (defined('IN_PMBT'))
{
	die ("You can't include this file");
}
else
{
	define("IN_PMBT",true);
}
$startpagetime = microtime();
require_once("common.php");
include_once('include/function_posting.' . $phpEx);
include_once('include/class.bbcode.php');
include_once("include/utf/utf_tools.php");

$template = new Template();
$user->set_lang('shouts',$user->ulanguage);
set_site_var($user->lang['SHOUTBOX_ARCHIVE']);
$page		= request_var('page', '1');
$search		= request_var('search', array('a'=>''),true);
//print_r($search);
$from = ($page - 1) * 10;

$lookfor = "";
if(!$search['time'] == "")
{
	$search['time'] = intval($search['time']);
}
if($search['phrase'] == "")
{
$searchword ="";
$searchwordpage = "";
$search_word = '';
}else{
$searchword = " AND text LIKE ('%".$db->sql_escape(searchfield($search['phrase']))."%')";
$searchwordpage = "&amp;search[phrase]=".$search['phrase'];
$search_word = $search['phrase'];
}
$uidsearch = "";
$uidsearchpage = "";
$uid_search = '';
if(!$search['username'] == "")
{
        $uid_search = $search['username'];
		$sql = "SELECT id FROM ".$db_prefix."_users WHERE clean_username LIKE '%".$db->sql_escape(utf8_strtolower($search['username']))."%';";
        $res = $db->sql_query($sql);
		$useridaray = array();
		while ($useid=$db->sql_fetchrow($res)) {
		
		$useridaray[] = $useid['id'];
		
		}
        $db->sql_freeresult($res);
		//print_r($useridaray);
		$uidsearch ="AND user IN ( '".implode("','",$useridaray)."')";
		$uidsearchpage = "&amp;search[username]=".$search['username'];

}
if(!$search['time'] == "") 
{
$search_time = $search['time'];
$searchtime = "AND UNIX_TIMESTAMP(posted) > UNIX_TIMESTAMP(NOW()) - (" . $search['time'] . " * 60 * 60)";
$searchtimepage = "&amp;search[time]=".$search['time'];
}else{
$search_time = 10;
$searchtime = "";
$searchtimepage = "";
}
//echo $searchtime;
if($search['sort'] == "")$sort = "DESC";
elseif($search['sort'] == "new")$sort = " DESC";
elseif($search['sort'] == "old")$sort = " ASC";
if(count($search) >=1)
{
	$lookforpage = '?i=0' . $searchtimepage.$searchwordpage.$uidsearchpage;
	$lookfor = $searchtime.$searchword.$uidsearch;
	$lookforcount = $searchtime.$searchword.$uidsearch;
}
                $totsql = "SELECT COUNT(*) as tot FROM ".$db_prefix."_shouts WHERE (id_to = '0' OR id_to = '".$user->id."')".$lookforcount.";";
				        $totres = $db->sql_query($totsql)or btsqlerror($totsql);;
				        list ($tot) = $db->fetch_array($totres);
                        $db->sql_freeresult($totres);
$pages = ceil($tot / $torrent_per_page);
$start = ($page >=1)?(($torrent_per_page * $page) - $torrent_per_page) : 0;
//$i = 0;
                $totsql1 = "SELECT COUNT(*) as tot1 FROM ".$db_prefix."_shouts WHERE UNIX_TIMESTAMP(posted) > UNIX_TIMESTAMP(NOW()) - 86400;";
				        $totres1 = $db->sql_query($totsql1);
				        list ($tot1) = $db->fetch_array($totres1);
                        $db->sql_freeresult($totres1);
                $totsql2 = "SELECT COUNT(*) as tot2 FROM ".$db_prefix."_shouts WHERE user = '".$user->id."';";
				        $totres2 = $db->sql_query($totsql2);
				        list ($tot2) = $db->fetch_array($totres2);
                        $db->sql_freeresult($totres2);
               $sql = "SELECT S.*, 
			   				U.id as uid, 
							U.level as level,
							U.bbcode_bitfield, 
							U.bbcode_uid, 
							IF(U.name IS NULL, U.username, U.name) as user_name, 
							U.can_do as can_do, 
							U.donator AS donator,
							U.ban as ban, 
							U.warned, 
							L.group_colour AS color, 
							L.group_name AS co_name, 
							C.name AS lname, 
							C.flagpic AS flagpic 
						FROM 
							".$db_prefix."_shouts S 
						LEFT JOIN 
							".$db_prefix."_users U ON S.user = U.id 
						LEFT JOIN 
							".$db_prefix."_level_settings L ON L.group_id = U.can_do 
						LEFT JOIN 
							".$db_prefix."_countries C ON C.id = U.country 
						WHERE 
							(id_to = '0' OR id_to = '".$user->id."')
							".$lookfor." 
							ORDER BY 
							posted ".$sort." LIMIT ".$from.",10;";
                $shoutres = $db->sql_query($sql) or btsqlerror($sql);
				$num2s = $db->sql_numrows($shoutres);
				if($sort == " DESC")$search_sort = "new";
				else
				$search_sort = "old";
		$template->assign_vars(array(
			'S_ON_PAGE'		=>	on_page($tot, $torrent_per_page, $start),
			'PAGINATION'	=>	generate_pagination("shoutboxarchive.php" . $lookforpage, $tot, $torrent_per_page, $start, true),
			'SHOUTS_TODAY'	=>	$tot1,
			'YOUR_SHOUTS'	=>	$tot2,
			'TOTAL_SHOUTS'	=>	$tot,
			'SEARCH_TIME'	=>	$search_time,
			'SEARCH_WORD'	=>	$search_word,
			'SEARCH_USER'	=>	$uid_search,
			'SEARCH_SORT'	=>	$search_sort,
			)
		);
	while ($shout = $db->sql_fetchrow($shoutres))
	{
		$caneditshout = false;
		if (checkaccess("m_edit_others_shouts")) $caneditshout = $candeleteshout = true;
		if ($user->id == $shout['uid'] AND $shout_config['canedit_on'] =="yes") $caneditshout = true;
		if ($user->id == $shout['uid'] AND $shout_config['candelete_on'] =="yes") $candeleteshout = true;
				$bbcode = false;
				$shout_txt = censor_text($shout["text"]);
				if ($shout['bbcode_bitfield'])
				{
					include_once('include/bbcode.' . $phpEx);
					$bbcode = new bbcode($shout['bbcode_bitfield']);
					$bbcode->bbcode_second_pass($shout_txt, $shout['bbcode_uid'], $shout['bbcode_bitfield']);
				}
				// Parse the message and subject
				$shout_txt = bbcode_nl2br($shout_txt);
				$shout_time = gmdate("Y-m-d H:i:s", sql_timestamp_to_unix_timestamp($shout['posted'])+(60 * get_user_timezone($user->id)));
				$template->assign_block_vars('shoutbox_archive_shout', array(
								    'SHOUTID'      => $shout["id"],
								    'QUOTE'      => '[quote]'.addslashes($shout["text"]).'[/quote]',
								    'SHOUT'      => $shout_txt,
								    'SHOW_USER'  => $showusername,
								    'TIME'       => $shout_time,
								    'UID'        => $shout['uid'],
								    'U_NAME'     => htmlspecialchars($shout["user_name"]),
								    'U_PRVATE_S' => (!$shout['id_to'] =='0') ? $user->lang['PM'] : false ,
									'U_BANNED'	=>	($shout['ban'] == '1') ? true : false,
								    'U_DONER'    => ($shout['donator'] == 'true') ? true : false,
								    'U_WARNED'   => ($shout["warned"] == "1") ? true : false,
								    'U_COLOR'    => $shout["color"],
								    'CAN_ED'     => $caneditshout,
								    'CAN_DEL'    => $candeleteshout,
									'CAN_QU'    => $shout_config['can_quote'],
							   ));
	}
                $db->sql_freeresult($shoutres);

                $topsql = "SELECT 
								S.user, 
								COUNT(S.text) as topshout, 
								IF(U.name IS NULL, U.username, U.name) as user_name, 
								U.can_do as can_do, 
								U.donator AS donator,
								U.ban as ban, 
								U.warned, 
								L.group_colour AS color, 
								L.group_name AS co_name, 
								C.name AS lname, 
								C.flagpic AS flagpic 
							FROM 
								".$db_prefix."_shouts S 
							LEFT JOIN 
								".$db_prefix."_users U ON S.user = U.id 
							LEFT JOIN 
								".$db_prefix."_level_settings L ON L.group_id = U.can_do 
							LEFT JOIN 
								".$db_prefix."_countries C ON C.id = U.country 
								GROUP BY user ORDER BY topshout DESC LIMIT 15;";
				        $topres = $db->sql_query($topsql);
						$topshout = 0;
						    while ($topshouter = $db->sql_fetchrow($topres)){
							++$topshout;
				$template->assign_block_vars('shoutbox_archive_topshouter', array(
								    'UID'        => $topshouter['uid'],
								    'U_NAME'     => htmlspecialchars($topshouter["user_name"]),
									'U_BANNED'	=>	($topshouter['ban'] == '1') ? true : false,
								    'U_DONER'    => ($topshouter['donator'] == 'true') ? true : false,
								    'U_WARNED'   => ($topshouter["warned"] == "1") ? true : false,
								    'U_COLOR'    => $topshouter["color"],
									'SHOUTS'	=>	$topshouter['topshout'],
							   ));

}
$db->sql_freeresult($topres);
echo $template->fetch('shoutboxarchive.html');				
close_out();
?>