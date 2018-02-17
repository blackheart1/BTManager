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
*--------------------   Saturday, Oct 08, 2011 9:09 PM   ------------------------*
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 torrent.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
require_once("include/user.functions.php");
		$user->set_lang('admin/acp_torrents',$user->ulanguage);
		$deletemark = (!empty($_POST['delmarked'])) ? true : false;
		$deleteall	= (!empty($_POST['delall'])) ? true : false;
		$marked		= request_var('mark', array(0));
		$sort_days	= request_var('st', '');
		$sort_key	= request_var('sk', 't');
		$sort_dir	= request_var('sd', 'd');
		$del		= request_var('del', '');
		$action		= request_var('action', '');
		$page		= request_var('page', 0);
		$limit_days = array(0 => $user->lang['ALL_ENTRIES'], 1 => $user->lang['1_DAY'], 7 => $user->lang['7_DAYS'], 14 => $user->lang['2_WEEKS'], 30 => $user->lang['1_MONTH'], 90 => $user->lang['3_MONTHS'], 180 => $user->lang['6_MONTHS'], 365 => $user->lang['1_YEAR']);
		$sort_by_text = array('d' => 'visible', 'f' => 'uploader', 'u' => 'torrent name', 't' => 'tracker', 'i' => 'seeders', 'o' => 'leechers');
		$sort_by_sql = array('d' => 'visible', 'f' => 'owner', 'u' => 'name', 't' => 'tracker', 'i' => 'seeders', 'o' => 'leechers');
		$s_limit_days = $s_sort_key = $s_sort_dir = $u_sort_param = '';
		gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sort_dir, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);
		$sql_where = (!$sort_days==0 || !$sort_days=='') ? "WHERE added > SUBDATE(SYSDATE(), INTERVAL ".$sort_days." DAY) " : '';
		$sql_sort = $sort_by_sql[$sort_key] . ' ' . (($sort_dir == 'd') ? 'DESC' : 'ASC');
		$from = ($page) * $torrent_per_page;
		$totsql = "SELECT COUNT(*)  as tot FROM ".$db_prefix."_torrents " . $sql_where . "ORDER BY " . $sql_sort . ";";
		$totres = $db->sql_query($totsql);
		list ($tot) = $db->fetch_array($totres);
		$db->sql_freeresult($totres);
		$pages = ceil($tot / $torrent_per_page);
		$start = ($page >=1)?(($torrent_per_page * $page) - $torrent_per_page) : 0;

		$rqq = "SELECT * FROM ".$db_prefix."_torrents " . $sql_where . "ORDER BY ".$sql_sort . " LIMIT ".$start.",".$torrent_per_page."; ";
		$resqq = $db->sql_query($rqq) or btsqlerror($rqq);
		$hidden = build_hidden_fields(array(
					'op'			=> 'admin_delete',
					'return'		=> $u_action,
					));
		$template->assign_vars(array(
			'L_TITLE'		=> $user->lang['INTRO'],
			'L_EXPLAIN'		=> $user->lang['INTRO_EXP'],
			'U_ACTION'		=> $siteurl . '/edit.php',
			'U_ACTIONB'		=> $u_action,
			'S_ON_PAGE'		=> on_page($tot, $torrent_per_page, $start),
			'PAGINATION'	=> generate_pagination($u_action . "&amp;$u_sort_param$keywords_param", $tot, $torrent_per_page, $start, true),
			'S_LIMIT_DAYS'	=> $s_limit_days,
			'S_SORT_KEY'	=> $s_sort_key,
			'S_SORT_DIR'	=> $s_sort_dir,
			'S_KEYWORDS'	=> $keywords,
			'HIDDEN'		=> $hidden,
			)
		);
	while ($row = $db->sql_fetchrow($resqq))
	{
		extract ($row);
		$owner = build_user_array($row['owner']);
		if($row['tracker'] == '')$external = "NO";
		else
		$external = "YES";
			$template->assign_block_vars('torrent', array(
				'TOR_FULL_NAME'			=> $row["name"],
				'TOR_SHOR_NAME'			=> (strlen($row["name"]) <= 31) ? $row["name"] : substr($row["name"],0,30)."...",
				'TRACKER'				=> ($row["tracker"] == '') ? $announce_url : ((strlen($row["tracker"]) <= 31) ? $row["tracker"] : substr($row["tracker"],0,30)."..."),
				'VISIBLE'				=> $row['visible'],
				'BANNED'				=> $row['banned'],
				'SEEDER'				=> $row['seeders'],
				'LEECHER'				=> $row['leechers'],
				'OWNER'					=> $owner['name'],
				'OWNER_COLOR'			=> $owner['color'],
				'OWNER_ID'				=> $row['owner'],
				'LASTACTION'			=> get_formatted_timediff(sql_timestamp_to_unix_timestamp($row["last_action"])),
				'LINK'					=> ($row["type"]=="link") ? $user->lang['YES'] : $user->lang['NO'],
				'ID'					=> $row["id"],
				)
			);
		}
		$db->sql_freeresult($reso);
		echo $template->fetch('admin/acp_torrents.html');
		close_out();
?>