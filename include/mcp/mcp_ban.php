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
** File mcp_ban.php 2018-02-18 14:32:00 joeroberts
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
class mcp_ban
{
	var $u_action;

	function main($id, $mode)
	{
		global $config, $db, $db_prefix , $user, $auth, $template, $pmbt_cache;
		global $phpbb_root_path, $phpEx;

		include_once($phpbb_root_path . 'include/user.functions.' . $phpEx);

		// Include the admin banning interface...
		include_once($phpbb_root_path . 'include/acp/acp_ban.' . $phpEx);

		$bansubmit		= (isset($_POST['bansubmit'])) ? true : false;
		$unbansubmit	= (isset($_POST['unbansubmit'])) ? true : false;
		$current_time	= time();

		$user->set_lang('admin/acp_bans',$user->ulanguage);
		$user->set_lang('admin/acp_users',$user->ulanguage);
		$this->tpl_name = 'mcp_ban';

		// Ban submitted?
		if ($bansubmit)
		{
			// Grab the list of entries
			$ban				= request_var('ban', '', ($mode === 'user') ? true : false);

			if ($mode === 'user')
			{
				$ban = utf8_normalize_nfc($ban);
			}

			$ban_len			= request_var('banlength', 0);
			$ban_len_other		= request_var('banlengthother', '');
			$ban_exclude		= request_var('banexclude', 0);
			$ban_reason			= utf8_normalize_nfc(request_var('banreason', '', true));
			$ban_give_reason	= utf8_normalize_nfc(request_var('bangivereason', '', true));

			if ($ban)
			{
				if (confirm_box(true))
				{
					user_ban($mode, $ban, $ban_len, $ban_len_other, $ban_exclude, $ban_reason, $ban_give_reason);

					trigger_error($user->lang['BAN_UPDATE_SUCCESSFUL'] . '<br /><br /><a href="' . $this->u_action . '">&laquo; ' . $user->lang['BACK_TO_PREV'] . '</a>');
				}
				else
				{
					confirm_box(false, $user->lang['CONFIRM_OPERATION'], build_hidden_fields(array(
						'mode'				=> $mode,
						'action_mcp'		=>	'mcp',
						'i'					=> $id,
						'ban'				=> $ban,
						'bansubmit'			=> true,
						'banlength'			=> $ban_len,
						'banlengthother'	=> $ban_len_other,
						'banexclude'		=> $ban_exclude,
						'banreason'			=> $ban_reason,
						'bangivereason'		=> $ban_give_reason)), 'confirm_body.html', append_sid("{$phpbb_root_path}forum.$phpEx?action_mcp=mcp"));
				}
			}
		}
		else if ($unbansubmit)
		{
			$ban = request_var('unban', array(''));

			if ($ban)
			{
				if (confirm_box(true))
				{
					user_unban($mode, $ban);

					trigger_error($user->lang['BAN_UPDATE_SUCCESSFUL'] . '<br /><br /><a href="' . $this->u_action . '">&laquo; ' . $user->lang['BACK_TO_PREV'] . '</a>');
				}
				else
				{
					confirm_box(false, $user->lang['CONFIRM_OPERATION'], build_hidden_fields(array(
						'mode'			=> $mode,
						'unbansubmit'	=> true,
						'unban'			=> $ban,
						'action_mcp'	=> 'mcp',
						'i'				=> 'ban')),'confirm_body.html','forum.php');
				}
			}
		}

		// Ban length options
		$ban_end_text = array(0 => $user->lang['PERMANENT'], 30 => $user->lang['30_MINS'], 60 => $user->lang['1_HOUR'], 360 => $user->lang['6_HOURS'], 1440 => $user->lang['1_DAY'], 10080 => $user->lang['7_DAYS'], 20160 => $user->lang['2_WEEKS'], 40320 => $user->lang['1_MONTH'], -1 => $user->lang['UNTIL'] . ' -&gt; ');

		$ban_end_options = '';
		foreach ($ban_end_text as $length => $text)
		{
			$ban_end_options .= '<option value="' . $length . '">' . $text . '</option>';
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
				$l_ban_cell = $user->lang['EMAIL_ADDRESS'];
			break;
		}

		(new acp_ban)->display_ban_options($mode);

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
			'U_FIND_USERNAME'	=> append_sid("{$phpbb_root_path}userfind_to_pm.$phpEx", 'mode=searchuser&amp;form=mcp_ban&amp;field=ban'),
		));

		if ($mode === 'email' && !$auth->acl_get('a_user'))
		{
			return;
		}

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
					$pre_fill = (string) $db->sql_fetchfield('user_ip');
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
}

?>