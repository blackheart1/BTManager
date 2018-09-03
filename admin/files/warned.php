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
** File warned.php 2018-02-23 14:32:00 Black_Heart
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
include_once 'include/user.functions.php';
$user->set_lang('admin/acp_warned',$user->ulanguage);
		$deletemark = (!empty($_POST['delmarked'])) ? true : false;
		$deleteall	= (!empty($_POST['delall'])) ? true : false;
		$marked		= request_var('mark', array(0));
		$sort_days	= request_var('st', '');
		$sort_key	= request_var('sk', 't');
		$sort_dir	= request_var('sd', 'd');
		$page		= request_var('page', 0);
		$del	= request_var('del', '');
		$limit_days = array(0 => $user->lang['ALL_ENTRIES'], 1 => $user->lang['1_DAY'], 7 => $user->lang['7_DAYS'], 14 => $user->lang['2_WEEKS'], 30 => $user->lang['1_MONTH'], 90 => $user->lang['3_MONTHS'], 180 => $user->lang['6_MONTHS'], 365 => $user->lang['1_YEAR']);
		$sort_by_text = array('u' => $user->lang['SORT_USERNAME'], 't' => $user->lang['SORT_REG_DATE'], 'i' => $user->lang['SORT_UP'], 'o' => $user->lang['SORT_DOWN'], 'wd' => $user->lang['SORT_WARN_DATE']);
		$sort_by_sql = array('u' => 'username', 't' => 'regdate', 'i' => 'uploaded', 'o' => 'downloaded', 'wd' => 'warn_kapta');
		$s_limit_days = $s_sort_key = $s_sort_dir = $u_sort_param = '';
		gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sort_dir, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);
		$sql_where = (!$sort_days==0 || !$sort_days=='') ? " AND regdate > SUBDATE(SYSDATE(), INTERVAL ".$sort_days." DAY) " : '';
		$sql_sort = $sort_by_sql[$sort_key] . ' ' . (($sort_dir == 'd') ? 'DESC' : 'ASC');
	$sql = "SELECT id FROM ".$db_prefix."_users WHERE active='1' AND warned='1' " . $sql_where . " ORDER BY " . $sql_sort . "";
	$res = $db->sql_query($sql)or btsqlerror($sql);
	$num = $db->sql_numrows($res);
		$pages = ceil($num / $torrent_per_page);
		$start = ($page >=1)?(($torrent_per_page * $page) - $torrent_per_page) : 0;
	$sqla = "SELECT id FROM ".$db_prefix."_users WHERE active='1' AND warned='1' " . $sql_where . " ORDER BY " . $sql_sort . " LIMIT ".$start.",".$torrent_per_page.";";
	$resa = $db->sql_query($sqla)or btsqlerror($sqla);
		if($num > 0)
		{
			$template->assign_vars(array(
			'S_WARNED'			=> true,
			));
			for ($i = 1; $i <= $num; $i++)
			{
				$arr = $db->sql_fetchrow($resa);
				$info_user = build_user_array($arr['id']);
				$info_user['ratio_color'] = get_u_ratio($info_user['uploaded'],$info_user['downloaded']);
				$uploaded = mksize($info_user["uploaded"]);
				$downloaded = mksize($info_user["downloaded"]);
				$added = substr($info_user['reg'],0,10);
				$last_access = substr($info_user['lastlogin'],0,10);
				$info_user['mdcoment_short'] = ((strlen($info_user['mdcoment']) <= 100) ? $info_user['mdcoment']: substr($info_user['mdcoment'],0,99)."...");
						$template->assign_block_vars('warned', array(
							'USERNAME_FULL'		=> get_username_string('full', $arr['id'], (($info_user['nick'] == '')? $info_user['name'] : $info_user['nick']), $info_user['color']),
							'USERNAME'			=> get_username_string('username', $arr['id'], (($info_user['nick'] == '')? $info_user['name'] : $info_user['nick']), $info_user['color']),
							'USER_COLOR'		=> get_username_string('colour', $arr['id'], (($info_user['nick'] == '')? $info_user['name'] : $info_user['nick']), $info_user['color']),
							'U_VIEW_PROFILE'	=> get_username_string('profile', $arr['id'], (($info_user['nick'] == '')? $info_user['name'] : $info_user['nick']), $info_user['color']),
							'U_UPLOADED'		=> $info_user["uploaded"],
							'U_UPLOADED_ABV'	=> $uploaded,
							'U_DOWNLOADED'		=> $info_user["downloaded"],
							'U_DOWNLOADED_ABV'	=> $downloaded,
							'U_RATIO_COLOR'		=> $info_user['ratio_color'],
							'U_RATIO'			=> $info_user['ratio'],
							'MOD_COMENT_FULL'	=> $info_user['mdcoment'],
							'MOD_COMENT_SHORT'	=> $info_user['mdcoment_short'],
							'JOINED'			=> $added,
							'LAST_SEEN'			=> $last_access,
							'U_GROUP'			=> ($user->lang[$info_user['group']])?$user->lang[$info_user['group']] : $info_user['group'],
							'U_LEVEL'			=> $info_user['level'],
							'U_WARNED_TEL'		=> gmdate("Y-m-d H:i:s",($userrow["warn_kapta"]+$userrow["warn_hossz"]))
							)
						);
			}
		}
		$template->assign_vars(array(
			'L_TITLE'				=> $user->lang['ACP_WARNINGS'],
			'L_TITLE_EXPLAIN'		=> $user->lang['ACP_WARNINGS_EXPLAIN'],
			'U_ACTION'				=> $u_action,
			'S_ON_PAGE'				=> on_page($num, $torrent_per_page, $start),
			'PAGINATION'			=> generate_pagination($u_action . "&amp;$u_sort_param$keywords_param", $tot, $torrent_per_page, $start, true),
			'S_LIMIT_DAYS'			=> $s_limit_days,
			'S_SORT_KEY'			=> $s_sort_key,
			'S_SORT_DIR'			=> $s_sort_dir,
			)
		);
echo $template->fetch('admin/acp_warned.html');
		close_out();
?>