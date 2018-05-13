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
** File acp_ban.php 2018-02-18 14:32:00 joeroberts
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT'))
{
	include_once './../security.php';
	die ();
}
class acp_ban
{
	var $p_master;
	var $u_action;

	function mcp_reports(&$p_master)
	{
		$this->p_master = &$p_master;
	}

	function main($id, $mode)
	{
		global $config, $db, $db_prefix, $user, $auth, $template, $cache;
		global $phpbb_root_path, $phpbb_admin_path, $phpEx, $table_prefix;

		//include_once('includes/user.functions.' . $phpEx);

		$bansubmit	= (isset($_POST['bansubmit'])) ? true : false;
		$unbansubmit = (isset($_POST['unbansubmit'])) ? true : false;
		$current_time = time();

		$this->tpl_name = 'acp_ban';
		$form_key = 'acp_ban';
		add_form_key($form_key);

		if (($bansubmit || $unbansubmit) && !check_form_key($form_key))
		{
			trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING);
		}

		// Ban submitted?
		if ($bansubmit)
		{
			// Grab the list of entries
			$ban				= utf8_normalize_nfc(request_var('ban', '', true));
			$ban_len			= request_var('banlength', 0);
			$ban_len_other		= request_var('banlengthother', '');
			$ban_exclude		= request_var('banexclude', 0);
			$ban_reason			= utf8_normalize_nfc(request_var('banreason', '', true));
			$ban_give_reason	= utf8_normalize_nfc(request_var('bangivereason', '', true));

			if ($ban)
			{
				user_ban($mode, $ban, $ban_len, $ban_len_other, $ban_exclude, $ban_reason, $ban_give_reason);

				trigger_error($user->lang['BAN_UPDATE_SUCCESSFUL'] . adm_back_link($this->u_action));
			}
		}
		else if ($unbansubmit)
		{
			$ban = request_var('unban', array(''));

			if ($ban)
			{
				user_unban($mode, $ban);

				trigger_error($user->lang['BAN_UPDATE_SUCCESSFUL'] . adm_back_link($this->u_action));
			}
		}

		// Define language vars
		$this->page_title = $user->lang[strtoupper($mode) . '_BAN'];

		$l_ban_explain = $user->lang[strtoupper($mode) . '_BAN_EXPLAIN'];
		$l_ban_exclude_explain = $user->lang[strtoupper($mode) . '_BAN_EXCLUDE_EXPLAIN'];
		$l_unban_title = $user->lang[strtoupper($mode) . '_UNBAN'];
		$l_unban_explain = $user->lang[strtoupper($mode) . '_UNBAN_EXPLAIN'];
		$l_no_ban_cell = $user->lang[strtoupper($mode) . '_NO_BANNED'];

		switch ($mode)
		{
			case 'user':
				$l_ban_cell = $user->lang['USERNAME'];
			break;

			case 'ip':
				$l_ban_cell = $user->lang['IP_HOSTNAME'];
			break;

			case 'email':
				$l_ban_cell = $user->lang['EMAIL'];
			break;
		}

		$this->display_ban_options($mode);

		$template->assign_vars(array(
			'L_TITLE'				=> $this->page_title,
			'L_EXPLAIN'				=> $l_ban_explain,
			'L_UNBAN_TITLE'			=> $l_unban_title,
			'L_UNBAN_EXPLAIN'		=> $l_unban_explain,
			'L_BAN_CELL'			=> $l_ban_cell,
			'L_BAN_EXCLUDE_EXPLAIN'	=> $l_ban_exclude_explain,
			'L_NO_BAN_CELL'			=> $l_no_ban_cell,

			'S_USERNAME_BAN'	=> ($mode == 'user') ? true : false,
			
			'U_ACTION'			=> $this->u_action,
			'U_FIND_USERNAME'	=> append_sid("{$phpbb_root_path}userfind_to_pm.$phpEx", 'mode=searchuser&amp;form=acp_ban&amp;field=ban'),
		));
				// As a "service" we will check if any post id is specified and populate the username of the poster id if given
		$post_id = request_var('p', 0);
		$user_id = request_var('u', 0);
		$username = $pre_fill = false;

		if ($user_id && $user_id <> 0)
		{
			$sql = 'SELECT username, email, lastip AS user_ip
				FROM ' . $db_prefix . '_users
				WHERE id = ' . $user_id;
			$result = $db->sql_query($sql);
			switch ($mode)
			{
				case 'user':
					$pre_fill = (string) $db->sql_fetchfield('username');
				break;
				
				case 'ip':
					$pre_fill = (string) long2ip($db->sql_fetchfield('user_ip'));
				break;

				case 'email':
					$pre_fill = (string) $db->sql_fetchfield('email');
				break;
			}
			$db->sql_freeresult($result);
		}
		else if ($post_id)
		{
			$post_info = get_post_data($post_id, 'm_ban');

			if (sizeof($post_info) && !empty($post_info[$post_id]))
			{
				switch ($mode)
				{
					case 'user':
						$pre_fill = $post_info[$post_id]['username'];
					break;

					case 'ip':
						$pre_fill = $post_info[$post_id]['poster_ip'];
					break;

					case 'email':
						$pre_fill = $post_info[$post_id]['user_email'];
					break;
				}

			}
		}

		if ($pre_fill)
		{
			// left for legacy template compatibility
			$template->assign_var('USERNAMES', $pre_fill);
			$template->assign_var('BAN_QUANTIFIER', $pre_fill);
		}

	}

	/**
	* Display ban options
	*/
	function display_ban_options($mode)
	{
		global $user, $db, $db_prefix, $template;

		// Ban length options
		$ban_end_text = array(0 => $user->lang['PERMANENT'], 30 => $user->lang['30_MINS'], 60 => $user->lang['1_HOUR'], 360 => $user->lang['6_HOURS'], 1440 => $user->lang['1_DAY'], 10080 => $user->lang['7_DAYS'], 20160 => $user->lang['2_WEEKS'], 40320 => $user->lang['1_MONTH'], -1 => $user->lang['UNTIL'] . ' -&gt; ');

		$ban_end_options = '';
		foreach ($ban_end_text as $length => $text)
		{
			$ban_end_options .= '<option value="' . $length . '">' . $text . '</option>';
		}

		switch ($mode)
		{
			case 'user':

				$field = 'username';
				$l_ban_cell = $user->lang['USERNAME'];

				$sql = 'SELECT b.*, u.id AS user_id, u.username, u.clean_username AS username_clean
					FROM ' . $db_prefix . '_bans b, ' . $db_prefix . '_users u
					WHERE (b.ban_end >= ' . time() . '
							OR b.ban_end = 0)
						AND u.id = b.ban_userid
						AND u.id > 0
					ORDER BY u.clean_username ASC';
			break;

			case 'ip':

				$field = 'ipstart';
				$l_ban_cell = $user->lang['IP_HOSTNAME'];

				$sql = 'SELECT *
					FROM ' . $db_prefix . '_bans
					WHERE (ban_end >= ' . time() . "
							OR ban_end = 0)
						AND ipstart <> ''";
			break;

			case 'email':

				$field = 'ban_email';
				$l_ban_cell = $user->lang['EMAIL'];

				$sql = 'SELECT *
					FROM ' . $db_prefix . '_bans
					WHERE (ban_end >= ' . time() . "
							OR ban_end = 0)
						AND ban_email <> ''";
			break;
		}
		$result = $db->sql_query($sql);

		$banned_options = '';
		$ban_length = $ban_reasons = $ban_give_reasons = array();

		while ($row = $db->sql_fetchrow($result))
		{
			$banned_options .= '<option' . (($row['ban_exclude']) ? ' class="sepop"' : '') . ' value="' . $row['id'] . '">' . $row[$field] . '</option>';

			$time_length = ($row['ban_end']) ? ($row['ban_end'] - $row['ban_start']) / 60 : 0;
			$ban_length[$row['id']] = (isset($ban_end_text[$time_length])) ? $ban_end_text[$time_length] : $user->lang['UNTIL'] . ' -> ' . $user->format_date($row['ban_end']);

			$ban_reasons[$row['id']] = $row['reason'];
			$ban_give_reasons[$row['id']] = $row['ban_give_reason'];
		}
		$db->sql_freeresult($result);
		#die(print_r($ban_reasons));

		if (sizeof($ban_length))
		{
			foreach ($ban_length as $ban_id => $length)
			{
				$template->assign_block_vars('ban_length', array(
					'BAN_ID'	=> (int) $ban_id,
					'LENGTH'	=> $length,
					'A_LENGTH'	=> addslashes($length),
				));
			}
		}

		if (sizeof($ban_reasons))
		{
			foreach ($ban_reasons as $ban_id => $reason)
			{
				$template->assign_block_vars('ban_reason', array(
					'BAN_ID'	=> $ban_id,
					'REASON'	=> $reason,
					'A_REASON'	=> addslashes(htmlspecialchars_decode($reason)),
				));
			}
		}

		if (sizeof($ban_give_reasons))
		{
			foreach ($ban_give_reasons as $ban_id => $reason)
			{
				$template->assign_block_vars('ban_give_reason', array(
					'BAN_ID'	=> $ban_id,
					'REASON'	=> $reason,
					'A_REASON'	=> addslashes(htmlspecialchars_decode($reason)),
				));
			}
		}

		$template->assign_vars(array(
			'S_BAN_END_OPTIONS'	=> $ban_end_options,
			'S_BANNED_OPTIONS'	=> ($banned_options) ? true : false,
			'BANNED_OPTIONS'	=> $banned_options)
		);
	}
}

?>