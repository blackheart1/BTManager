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
* @version $Id: 3.0.0 admin_log.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
include_once('include/user.functions.php');
$user->set_lang('admin/logs',$user->ulanguage);
		$deletemark = (!empty($_POST['delmarked'])) ? true : false;
		$deleteall	= (!empty($_POST['delall'])) ? true : false;
		$marked		= request_var('mark', array(0));
		$sort_days	= request_var('st', '');
		$sort_key	= request_var('sk', 't');
		$sort_dir	= request_var('sd', 'd');
		$del	= request_var('del', '');
if($deleteall)
{
		if (confirm_box(true))
		{
		$db->sql_query("TRUNCATE `".$db_prefix."_log`;");
						logerror($user->lang['LOG_CLEAR_ADMIN'],'LOG_CLEAR_CRITICAL');
                                $template->assign_vars(array(
								        'S_USER_NOTICE'				=> true,
										'S_FORWARD'					=> $u_action,
								        'MESSAGE_TITLE'          	=> $user->lang['SUCCESS'],
                                        'MESSAGE_TEXT'           	=> $user->lang['PRUNE_SUCCESS'],
                                ));
		echo $template->fetch('admin/message_body.html');
		close_out();
		}
		else
		{
								$hidden = build_hidden_fields(array(
								"st"			=> $sort_days,
								"sk"		=> $sort_key,
								"sd" 		=> $sort_dir,
								"delall" 		=> $deleteall,
								"i"			=> 'siteinfo',
								"op"		=> 'log',
								));
		confirm_box(false, $user->lang['CONFIRM_OPERATION'], $hidden,'admin/confirm_body.html','admin.php',true);
		}
}
if(isset($delmarked))
{
		if (confirm_box(true))
		{
                        $sql = "DELETE FROM ".$db_prefix."_log WHERE event IN (".$del.");";
                        $db->sql_query($sql) or btsqlerror($sql);
						logerror($user->lang['A_CLEAR_LOG'],'CLEAR_CRITICAL');//log group chonge
                                $template->assign_vars(array(
								        'S_USER_NOTICE'            => true,
										'S_FORWARD'			=> $u_action,
								        'MESSAGE_TITLE'          => $user->lang['SUCCESS'],
                                        'MESSAGE_TEXT'            => $user->lang['PRUNE_SEL_SUCCESS'],
                                ));
		echo $template->fetch('admin/message_body.html');
		close_out();
		}
		else
		{
		if(!checkaccess('a_clearlogs')){
		$template->assign_vars(array(
	        'S_ERROR'            => true,
	        'TITTLE_M'           => $user->lang['BT_ERROR'],
	        'MESSAGE'            => $user->lang['AUTH_CLEAR_LOGS_FAIL'],
		));
		echo $template->fetch('message_body.html');
		close_out();
		}
						$marks = Array();
						foreach ($marked as $key=>$val) {
						$marks[]=$val;
						}
								$hidden = build_hidden_fields(array(
								"st"			=> $sort_days,
								"sk"		=> $sort_key,
								"sd" 		=> $sort_dir,
								"delmarked" 		=> $deletemark,
								"i"			=> 'siteinfo',
								"op"		=> 'log',
								"del"		=> implode(",",$marks),
								));
		confirm_box(false, $user->lang['CONFIRM_OPERATION'], $hidden,'admin/confirm_body.html','admin.php');
		}
}
		$action		= request_var('action', '');
		$page		= request_var('page', 0);
		$u_action = './admin.php?i=siteinfo&amp;op=log';
		$limit_days = array(0 => $user->lang['ALL_ENTRIES'], 1 => $user->lang['1_DAY'], 7 => $user->lang['7_DAYS'], 14 => $user->lang['2_WEEKS'], 30 => $user->lang['1_MONTH'], 90 => $user->lang['3_MONTHS'], 180 => $user->lang['6_MONTHS'], 365 => $user->lang['1_YEAR']);
		$sort_by_text = array('u' => $user->lang['SORT_USERNAME'], 't' => $user->lang['SORT_DATE'], 'i' => $user->lang['SORT_IP'], 'o' => $user->lang['SORT_ACTION']);
		$sort_by_sql = array('u' => 'userid', 't' => 'datetime', 'i' => 'ip', 'o' => 'event');
		$s_limit_days = $s_sort_key = $s_sort_dir = $u_sort_param = '';
		gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sort_dir, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);
		// Define where and sort sql for use in displaying logs
		$sql_where = (!$sort_days==0 || !$sort_days=='') ? " WHERE datetime > SUBDATE(SYSDATE(), INTERVAL ".$sort_days." DAY) " : '';
		$sql_sort = $sort_by_sql[$sort_key] . ' ' . (($sort_dir == 'd') ? 'DESC' : 'ASC');
		$from = ($page) * $torrent_per_page;
		$totsql = "SELECT COUNT(*) as tot FROM ".$db_prefix."_log " . $sql_where . "ORDER BY " . $sql_sort . ";";
		$totres = $db->sql_query($totsql)or btsqlerror($totsql);
		list ($tot) = $db->fetch_array($totres);
		$db->sql_freeresult($totres);
		$pages = ceil($tot / $torrent_per_page);
		$start = ($page >=1)?(($torrent_per_page * $page) - $torrent_per_page) : 0;
		$sql = "SELECT 
					l.*
				FROM 
					`".$db_prefix."_log` l
					" . $sql_where . "
				ORDER BY " . $sql_sort . " 
				LIMIT " . $start . ", " . $torrent_per_page . "; ";
		$res = $db->sql_query($sql)or btsqlerror($sql);
		$template->assign_vars(array(
			'L_TITLE'		=> $user->lang['ACP_ADMIN_LOGS'],
			'L_EXPLAIN'		=> $user->lang['ACP_ADMIN_LOGS_EXPLAIN'],
			'U_ACTION'		=> $u_action,
			'S_ON_PAGE'		=> on_page($tot, $torrent_per_page, $start),
			'PAGINATION'	=> generate_pagination($u_action . "&amp;$u_sort_param$keywords_param", $tot, $torrent_per_page, $start, true),
			'S_LIMIT_DAYS'	=> $s_limit_days,
			'S_SORT_KEY'	=> $s_sort_key,
			'S_SORT_DIR'	=> $s_sort_dir,
			'S_CLEARLOGS'	=> checkaccess('a_clearlogs'),
			'S_KEYWORDS'	=> $keywords,
			)
		);
        while ($errors = $db->sql_fetchrow($res)) {
		$data = array();
		$errors['ip_g'] = $errors["ip"];
		$errors = array_merge($errors, build_user_array($errors['userid']));
		$data = unserialize(stripslashes($errors['results']));
				$s_data = (isset($user->lang[strtoupper($errors['action'])])) ? $user->lang[strtoupper($errors['action'])] : '{' . ucfirst(str_replace('_', ' ', $errors['action'])) . '}';
				//echo substr_count($s_data, '%') . '<br>';
				if ((substr_count($s_data, '%') - sizeof($data)) > 0)
				{
					$data = (!is_array($data))?array($data) : $data;
					//print_r( $data);
					$data = array_merge($data, array_fill(0, substr_count($s_data, '%') - sizeof($data), ''));
				}

				$s_data = vsprintf($s_data, $data);
			$template->assign_block_vars('log', array(
				'USERNAME'			=> ($errors['userid'] == 0)? $user->lang['UNKNOWN'] : $errors['name'],
				'USER_ID'			=>	$errors['userid'],
				'USER_COLOR'		=>	$errors['color'],
				'IP'				=> ($errors['userid'] == 0)? long2ip($errors["ip_g"]) : long2ip($errors["ip"]),
				'DATE'				=> $errors['datetime'],
				'ACTION'			=> $s_data,//$errors['action'],
				'DATA'				=> (is_array($data))? '' : nl2br(stripslashes($data)),
				'ID'				=> $errors['event'],
				)
			);
        } 
		$db->sql_freeresult($res);
echo $template->fetch('admin/log.html');
		close_out();
?>