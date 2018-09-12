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
** File user.php 2018-02-28 14:32:00 Black_Heart
**
** CHANGES
**
** 2018-02-28 Fix links
**/
if (!defined('IN_PMBT'))
{
	include_once './../../security.php';
	die ("You can't access this file directly");
}
$user->set_lang('admin/acp_users',$user->ulanguage);
include_once 'include/user.functions.php';
		$usearch	= request_var('usearch', '');
		$umailsearch	= request_var('umailsearch', '');
		$uipsearch	= request_var('uipsearch', '');
		$uhostsearch	= request_var('uhostsearch', '');
		$dupeaccounts	= request_var('dupeaccounts', '');
		$sort_days	= request_var('st', '');
		$sort_key	= request_var('sk', 't');
		$sort_dir	= request_var('sd', 'd');
		$action		= request_var('action', '');
		$vas		= request_var('vas', 'overview');
		$mode		= request_var('mode', 'overview');
		$page		= request_var('page', 0);
		//die($mode);
							$template->assign_block_vars('l_block1.l_block2',array(
							'L_TITLE'		=> 'Users',
							'S_SELECTED'	=> true,
							'U_TITLE'		=> '1',));
							$template->assign_block_vars('l_block1.l_block2.l_block3',array(
							'S_SELECTED'	=> ('overview' ==$vas)? true:false,
							'IMG' => '',
							'L_TITLE' => $user->lang['MANAGE_USERS'],
							'U_TITLE' => "admin.php?i=" . $i . "&amp;op=user&amp;vas=overview",
							));
							$template->assign_block_vars('l_block1.l_block2.l_block3',array(
							'S_SELECTED'	=> ('list' ==$vas && !$action)? true:false,
							'IMG' => '',
							'L_TITLE' => $user->lang['INACTIVE_USERS'],
							'U_TITLE' => "admin.php?i=" . $i . "&amp;op=user&amp;vas=list&amp;mode=list",
							));
							$template->assign_block_vars('l_block1.l_block2.l_block3',array(
							'S_SELECTED'	=> ('setting_user_local' ==$vas && !$action)? true:false,
							'IMG' => '',
							'L_TITLE' => $user->lang['ACP_USERS_FORUM_PERMISSIONS'],
							'U_TITLE' => "admin.php?i=" . $i . "&amp;op=user&amp;vas=setting_user_local&amp;mode=setting_user_local",
							));
							$template->assign_block_vars('l_block1.l_block2.l_block3',array(
							'S_SELECTED'	=> ('setting_user_global' ==$vas && !$action)? true:false,
							'IMG' => '',
							'L_TITLE' => $user->lang['ACP_USERS_PERMISSIONS'],
							'U_TITLE' => "admin.php?i=" . $i . "&amp;op=user&amp;vas=setting_user_global&amp;mode=setting_user_global",
							));
		switch ($vas)
		{
			case 'setting_user_local':
			case 'setting_user_global':
				require_once("include/auth.php");
				require_once("include/class.bbcode.php");
				require_once("include/functions_forum.php");
				require_once("admin/files/acp_permissions.php");
				$auth = new auth();
				$auth->acl($user);
				$admin_role = new acp_permissions();
				$admin_role->u_action = '/admin.php?op=' . $op.'&amp;i=userinfo' . (($mode)? '&amp;mode=' . $mode : '') . '&amp;vas=' . $vas;
				$admin_role->main('',$mode);
				$temp = $admin_role->tpl_name;
				break;
			case 'overview':
			case 'profile':
			case 'attach':
				require_once("admin/files/acp_users.php");
				require_once("include/auth.php");
				require_once("include/utf/utf_tools.php");
				require_once("include/class.bbcode.php");
				$sql = 'SELECT bbcode_id, bbcode_tag, bbcode_helpline
					FROM '.$db_prefix.'_bbcodes
					WHERE display_on_posting = 1
					ORDER BY bbcode_tag';
				$result = $db->sql_query($sql);
			
				$i = 0;
				$num_predefined_bbcodes = 22;
				while ($rows = $db->sql_fetchrow($result))
				{
					// If the helpline is defined within the language file, we will use the localised version, else just use the database entry...
					if (isset($user->lang[strtoupper($rows['bbcode_helpline'])]))
					{
						$rows['bbcode_helpline'] = $user->lang[strtoupper($rows['bbcode_helpline'])];
					}
			
					$template->assign_block_vars('custom_tags', array(
						'BBCODE_NAME'		=> "'[{$rows['bbcode_tag']}]', '[/" . str_replace('=', '', $rows['bbcode_tag']) . "]'",
						'BBCODE_ID'			=> $num_predefined_bbcodes + ($i * 2),
						'BBCODE_TAG'		=> str_replace('=', '', $rows['bbcode_tag']),
						'BBCODE_HELPLINE'	=> $rows['bbcode_helpline'],
						'A_BBCODE_HELPLINE'	=> str_replace(array('&amp;', '&quot;', "'", '&lt;', '&gt;'), array('&', '"', "\'", '<', '>'), $rows['bbcode_helpline']),
					));
			
					$i++;
				}
				$db->sql_freeresult($result);
				$user->set_lang('admin/acp_permissions',$user->ulanguage);
				$auth = new auth();
				$auth->acl($user);
				$admin_role = new acp_users();
				$admin_role->u_action = '/admin.php?op=' . $op.'&amp;i=userinfo' . (($mode)? '&amp;mode=' . $mode : '') . '&amp;vas=' . $vas;
				$temp = $admin_role->tpl_name;
				$admin_role->main('',$mode);
				break;
			case 'list':
				require_once("admin/files/ucp_list.php");
				require_once("include/auth.php");
				require_once("include/utf/utf_tools.php");
				$auth = new auth();
				$auth->acl($user);
				$admin_role = new acp_inactive();
				$admin_role->u_action = '/admin.php?op=' . $op.'&amp;i=userinfo' . (($mode)? '&amp;mode=' . $mode : '') . '&amp;vas=' . $vas;
				$admin_role->main('',$mode);
				$temp = $admin_role->tpl_name;
				break;
		}
		$limit_days = array(0 => $user->lang['ALL_ENTRIES'], 1 => $user->lang['1_DAY'], 7 => $user->lang['7_DAYS'], 14 => $user->lang['2_WEEKS'], 30 => $user->lang['1_MONTH'], 90 => $user->lang['3_MONTHS'], 180 => $user->lang['6_MONTHS'], 365 => $user->lang['1_YEAR']);
		$sort_by_text = array('u' => $user->lang['SORT_USERNAME'], 't' => $user->lang['SORT_DATE'], 'i' => $user->lang['SORT_IP'], 'o' => $user->lang['SORT_ACTION']);
		$sort_by_sql = array('u' => 'username', 't' => 'regdate', 'i' => 'lastip', 'o' => 'lastlogin');
		$s_limit_days = $s_sort_key = $s_sort_dir = $u_sort_param = '';
		gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sort_dir, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);
		$sql_where = (!$sort_days==0 || !$sort_days=='') ? "WHERE lastlogin > SUBDATE(SYSDATE(), INTERVAL ".$sort_days." DAY) " : '';
		$sql_sort = $sort_by_sql[$sort_key] . ' ' . (($sort_dir == 'd') ? 'DESC' : 'ASC');
		$from = ($page >=1)?(($torrent_per_page * $page) - $torrent_per_page) : 0;


		echo $template->fetch(($temp)? 'admin/' . $temp . '.html' : 'admin/acp_users.html');
		close_out();
?>