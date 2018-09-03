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
** File mcp_notes.php 2018-02-18 14:32:00 joeroberts
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT'))
{
	include_once './../../security.php';
	die ();
}
class mcp_notes
{
	var $p_master;
	var $u_action;

	function __construct(&$p_master)
	{
		$this->p_master = &$p_master;
	}
	/*To not break everyone using your library, you have to keep backwards compatibility: 
	Add the PHP5-style constructor, but keep the PHP4-style one. */
	function mcp_notes(&$p_master)
	{
		$this->__construct($p_master);
	}


	function main($id, $mode)
	{
		global $auth, $db, $db_prefix, $user, $template;
		global $config, $phpbb_root_path, $phpEx;

		$action = request_var('action', array('' => ''));

		if (is_array($action))
		{
			foreach($action as $var=>$val){$action = $var;}
			//list($action, ) = each($action);
		}

		$this->page_title = 'MCP_NOTES';

		switch ($mode)
		{
			case 'front':
				$template->assign_vars(array(
					'U_FIND_USERNAME'	=> append_sid("{$phpbb_root_path}userfind_to_pm.$phpEx", 'mode=searchuser&amp;form=mcp&amp;field=username&amp;select_single=true'),
					'U_POST_ACTION'		=> append_sid("{$phpbb_root_path}forum.$phpEx?action_mcp=mcp", 'i=notes&amp;mode=user_notes'),

					'L_TITLE'			=> $user->lang['MCP_NOTES'],
				));

				$this->tpl_name = 'mcp_notes_front';
			break;

			case 'user_notes':
				$user->set_lang('admin/acp_main',$user->ulanguage);

				$this->mcp_notes_user_view($action);
				$this->tpl_name = 'mcp_notes_user';
			break;
		}
	}

	/**
	* Display user notes
	*/
	function mcp_notes_user_view($action)
	{
		global $phpEx, $phpbb_root_path, $config;
		global $template, $db, $db_prefix, $user, $auth;

		$user_id = request_var('u', 0);
		$username = request_var('username', '', true);
		$start = request_var('start', 0);
		$st	= request_var('st', 0);
		$sk	= request_var('sk', 'b');
		$sd	= request_var('sd', 'd');

		add_form_key('mcp_notes');

		$sql_where = ($user_id) ? "id = $user_id" : "clean_username = '" . $db->sql_escape(utf8_clean_string($username)) . "'";

		$sql = 'SELECT *
			FROM ' . $db_prefix . "_users
			WHERE $sql_where";
		$result = $db->sql_query($sql);
		$userrow = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		//die($sql);

		if (!$userrow)
		{
			trigger_error('NO_USER');
		}

		$user_id = $userrow['id'];

		// Populate user id to the currently active module (this module)
		// The following method is another way of adjusting module urls. It is the easy variant if we want
		// to directly adjust the current module url based on data retrieved within the same module.
		if (strpos($this->u_action, "&amp;u=$user_id") === false)
		{
			$this->p_master->adjust_url('&amp;u=' . $user_id);
			$this->u_action .= "&amp;u=$user_id";
		}

		$deletemark = ($action == 'del_marked') ? true : false;
		$deleteall	= ($action == 'del_all') ? true : false;
		$marked		= request_var('marknote', array(0));
		$usernote	= utf8_normalize_nfc(request_var('usernote', '', true));

		// Handle any actions
		if (($deletemark || $deleteall) && $auth->acl_get('a_clearlogs'))
		{
			$where_sql = '';
			if ($deletemark && $marked)
			{
				$sql_in = array();
				foreach ($marked as $mark)
				{
					$sql_in[] = $mark;
				}
				$where_sql = ' AND ' . $db->sql_in_set('event', $sql_in);
				unset($sql_in);
			}

			if ($where_sql || $deleteall)
			{
				if (check_form_key('mcp_notes'))
				{
					$sql = 'DELETE FROM ' . $db_prefix . '_log
						WHERE log_type = ' . 3 . "
							AND reportee_id = $user_id
							$where_sql";
							//die($sql);
					$db->sql_query($sql) or die(print_r($db->sql_error()));

					add_log('admin', 'LOG_CLEAR_USER', $userrow['username']);

					$msg = ($deletemark) ? 'MARKED_NOTES_DELETED' : 'ALL_NOTES_DELETED';
				}
				else
				{
					$msg = 'FORM_INVALID';
				}
				$redirect = $this->u_action . '&amp;u=' . $user_id;
				meta_refresh(3, $redirect);
				trigger_error($user->lang[$msg] . '<br /><br />' . sprintf('<a href="' . $redirect . '">%1$s</a>',$user->lang['RETURN_PAGE'] ));
			}
		}

		if ($usernote && $action == 'add_feedback')
		{
			if (check_form_key('mcp_notes'))
			{
				add_log('admin', 'LOG_USER_FEEDBACK', $userrow['username']);
				add_log('mod', 0, 0, 'LOG_USER_FEEDBACK', $userrow['username']);

				add_log('user', $user_id, 'LOG_USER_GENERAL', $usernote);
				$msg = $user->lang['USER_FEEDBACK_ADDED'];
			}
			else
			{
				$msg = $user->lang['FORM_INVALID'];
			}
			$redirect = $this->u_action;
			meta_refresh(3, $redirect);

			trigger_error($msg . '<br /><br />' . sprintf('<a href="' . $redirect . '">%1$s</a>',$user->lang['RETURN_PAGE'] ));
		}

		// Generate the appropriate user information for the user we are looking at
		if (!function_exists('get_user_avatar'))
		{
			include($phpbb_root_path . 'includes/functions_display.' . $phpEx);
		}

		$rank_title = $rank_img = '';
		$avatar_img = get_user_avatar($userrow['user_avatar'], $userrow['user_avatar_type'], $userrow['user_avatar_width'], $userrow['user_avatar_height']);

		$limit_days = array(0 => $user->lang['ALL_ENTRIES'], 1 => $user->lang['1_DAY'], 7 => $user->lang['7_DAYS'], 14 => $user->lang['2_WEEKS'], 30 => $user->lang['1_MONTH'], 90 => $user->lang['3_MONTHS'], 180 => $user->lang['6_MONTHS'], 365 => $user->lang['1_YEAR']);
		$sort_by_text = array('a' => $user->lang['SORT_USERNAME'], 'b' => $user->lang['SORT_DATE'], 'c' => $user->lang['SORT_IP'], 'd' => $user->lang['SORT_ACTION']);
		$sort_by_sql = array('a' => 'u.clean_username', 'b' => 'l.datetime', 'c' => 'l.ip', 'd' => 'l.action');

		$s_limit_days = $s_sort_key = $s_sort_dir = $u_sort_param = '';
		gen_sort_selects($limit_days, $sort_by_text, $st, $sk, $sd, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);

		// Define where and sort sql for use in displaying logs
		$sql_where = ($st) ? (time() - ($st * 86400)) : 0;
		$sql_sort = $sort_by_sql[$sk] . ' ' . (($sd == 'd') ? 'DESC' : 'ASC');

		$log_data = array();
		$log_count = 0;
		view_log('user', $log_data, $log_count, '10', $start, 0, 0, $user_id, $sql_where, $sql_sort);

		if ($log_count)
		{
			$template->assign_var('S_USER_NOTES', true);

			foreach ($log_data as $row)
			{
				$template->assign_block_vars('usernotes', array(
					'REPORT_BY'		=> $row['username_full'],
					'REPORT_AT'		=> $user->format_date($row['time']),
					'ACTION'		=> $row['action'],
					'IP'			=> $row['ip'],
					'ID'			=> $row['id'])
				);
			}
		}
		$template->assign_vars(array(
			'U_POST_ACTION'			=> $this->u_action,
			'S_CLEAR_ALLOWED'		=> ($auth->acl_get('a_clearlogs')) ? true : false,
			'S_SELECT_SORT_DIR'		=> $s_sort_dir,
			'S_SELECT_SORT_KEY'		=> $s_sort_key,
			'S_SELECT_SORT_DAYS'	=> $s_limit_days,

			'L_TITLE'			=> $user->lang['MCP_NOTES_USER'],

			'PAGE_NUMBER'		=> on_page($log_count, $config['posts_per_page'], $start),
			'PAGINATION'		=> generate_pagination($this->u_action . "&amp;st=$st&amp;sk=$sk&amp;sd=$sd", $log_count, $config['posts_per_page'], $start),
			'TOTAL_REPORTS'		=> ($log_count == 1) ? $user->lang['LIST_REPORT'] : sprintf($user->lang['LIST_REPORTS'], $log_count),

			'RANK_TITLE'		=> $rank_title,
			'JOINED'			=> $user->format_date($userrow['regdate']),
			'POSTS'				=> ($userrow['user_posts']) ? $userrow['user_posts'] : 0,
			'WARNINGS'			=> ($userrow['user_warnings']) ? $userrow['user_warnings'] : 0,

			'USERNAME_FULL'		=> get_username_string('full', $userrow['id'], $userrow['username'], $userrow['user_colour']),
			'USERNAME_COLOUR'	=> get_username_string('colour', $userrow['id'], $userrow['username'], $userrow['user_colour']),
			'USERNAME'			=> get_username_string('username', $userrow['id'], $userrow['username'], $userrow['user_colour']),
			'U_PROFILE'			=> get_username_string('profile', $userrow['id'], $userrow['username'], $userrow['user_colour']),

			'AVATAR_IMG'		=> $avatar_img,
			'RANK_IMG'			=> $rank_img,
			)
		);
	}

}

?>