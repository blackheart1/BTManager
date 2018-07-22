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
** File ucp_list.php 2018-02-23 14:32:00 Black_Heart
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
class acp_inactive
{
	var $u_action;
	var $p_master;


	function main($id, $mode)
	{
		global $config, $db, $user, $auth, $template, $db_prefix, $language;
		global $phpEx, $table_prefix, $conferm_email;

		include_once('include/user.functions.' . $phpEx);
		include_once('include/class.bbcode.' . $phpEx);

		$user->set_lang('memberslist',$user->ulanguage);

		$action = request_var('action', '');
		$mark	= (isset($_REQUEST['mark'])) ? request_var('mark', array(0)) : array();
		$start	= request_var('start', 0);
		$submit = isset($_POST['submit']);

		// Sort keys
		$sort_days	= request_var('st', 0);
		$sort_key	= request_var('sk', 'i');
		$sort_dir	= request_var('sd', 'd');

		$form_key = 'acp_inactive';
		add_form_key($form_key);

		// We build the sort key and per page settings here, because they may be needed later

		// Number of entries to display
		$per_page = request_var('users_per_page', (int) $config['topics_per_page']);

		// Sorting
		$limit_days = array(0 => $user->lang['ALL_ENTRIES'], 1 => $user->lang['1_DAY'], 7 => $user->lang['7_DAYS'], 14 => $user->lang['2_WEEKS'], 30 => $user->lang['1_MONTH'], 90 => $user->lang['3_MONTHS'], 180 => $user->lang['6_MONTHS'], 365 => $user->lang['1_YEAR']);
		$sort_by_text = array('i' => $user->lang['SORT_INACTIVE'], 'j' => $user->lang['SORT_REG_DATE'], 'l' => $user->lang['SORT_LAST_VISIT'], 'd' => $user->lang['SORT_LAST_REMINDER'], 'r' => $user->lang['SORT_REASON'], 'u' => $user->lang['SORT_USERNAME'], 'p' => $user->lang['SORT_POSTS'], 'e' => $user->lang['SORT_REMINDER']);
		$sort_by_sql = array('i' => 'user_inactive_time', 'j' => 'user_regdate', 'l' => 'user_lastvisit', 'd' => 'user_reminded_time', 'r' => 'user_inactive_reason', 'u' => 'username_clean', 'p' => 'user_posts', 'e' => 'user_reminded');

		$s_limit_days = $s_sort_key = $s_sort_dir = $u_sort_param = '';
		gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sort_dir, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);

		if ($submit && sizeof($mark))
		{
			if ($action !== 'delete' && !check_form_key($form_key))
			{
				trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING);
			}

			switch ($action)
			{
				case 'activate':
				case 'delete':

					$sql = 'SELECT id, username
						FROM ' . $db_prefix . '_users
						WHERE ' . $db->sql_in_set('id', $mark);
					$result = $db->sql_query($sql);

					$user_affected = array();
					while ($row = $db->sql_fetchrow($result))
					{
						$user_affected[$row['id']] = $row['username'];
					}
					$db->sql_freeresult($result);

					if ($action == 'activate')
					{
						// Get those 'being activated'...
						$sql = 'SELECT id, username' . (($conferm_email) ? ', email, language' : '') . '
							FROM ' . $db_prefix . '_users
							WHERE ' . $db->sql_in_set('id', $mark) . '
								AND user_type = ' . 1;

						$result = $db->sql_query($sql);

						$inactive_users = array();
						while ($row = $db->sql_fetchrow($result))
						{
							$inactive_users[] = $row;
						}
						$db->sql_freeresult($result);

						user_active_flip('activate', $mark);

						if ($conferm_email && !empty($inactive_users))
						{
							include_once('include/function_messenger.' . $phpEx);

							$messenger = new messenger(false);

							foreach ($inactive_users as $row)
							{
								if ((!$row['language']) OR !file_exists("language/email/".$row['language']."/admin_welcome_activated.txt")) $lang_email = $language;
								else $lang_email = $row['language'];
								$messenger->template('admin_welcome_activated', $lang_email);
								$messenger->to($row['email'], $row['username']);
								$messenger->assign_vars(array(
									'USERNAME'	=> htmlspecialchars_decode($row['username']))
								);

								$messenger->send(0);
							}

							$messenger->save_queue();
						}

						if (!empty($inactive_users))
						{
							foreach ($inactive_users as $row)
							{
								add_log('admin', 'LOG_USER_ACTIVE', $row['username']);
								add_log('user', $row['user_id'], 'LOG_USER_ACTIVE_USER');
							}
						}

						// For activate we really need to redirect, else a refresh can result in users being deactivated again
						$u_action = $this->u_action . "&amp;$u_sort_param&amp;start=$start";
						$u_action .= ($per_page != $config['topics_per_page']) ? "&amp;users_per_page=$per_page" : '';

						redirect($u_action);
					}
					else if ($action == 'delete')
					{
						if (confirm_box(true))
						{
							if (!$auth->acl_get('a_userdel'))
							{
								trigger_error($user->lang['NO_AUTH_OPERATION'] . adm_back_link($this->u_action), E_USER_WARNING);
							}

							foreach ($mark as $user_id)
							{
								user_delete('retain', $user_id, $user_affected[$user_id]);
							}

							add_log('admin', 'LOG_INACTIVE_' . strtoupper($action), implode(', ', $user_affected));
						}
						else
						{
							$s_hidden_fields = array(
								'mode'			=> $mode,
								'action'		=> $action,
								'mark'			=> $mark,
								'submit'		=> 1,
								'start'			=> $start,
							);
							confirm_box(false, $user->lang['CONFIRM_OPERATION'], build_hidden_fields($s_hidden_fields));
						}
					}

				break;

				case 'remind':
					if (empty($config['email_enable']))
					{
						trigger_error($user->lang['EMAIL_DISABLED'] . adm_back_link($this->u_action), E_USER_WARNING);
					}

					$sql = 'SELECT id, username, email, language, jabber, user_notify_type, regdate, act_key
						FROM ' . $db_prefix . '_users
						WHERE ' . $db->sql_in_set('id', $mark) . '
							AND user_inactive_reason';
					$sql .= ($conferm_email) ? ' = ' . 4 : ' <> ' . 3;
					$result = $db->sql_query($sql);

					if ($row = $db->sql_fetchrow($result))
					{
							if ((!$row['language']) OR !file_exists("language/email/".$row['language']."/user_remind_inactive.txt")) $lang_email = $language;
							else $lang_email = $row['language'];
						// Send the messages
						include_once('include/function_messenger.' . $phpEx);

						$messenger = new messenger();
						$usernames = $user_ids = array();
						do
						{
							$messenger->template('user_remind_inactive', $lang_email);
							$messenger->to($row['email'], $row['username']);
							$messenger->im($row['jabber'], $row['username']);
							$messenger->assign_vars(array(
								'USERNAME'		=> htmlspecialchars_decode($row['username']),
								'REGISTER_DATE'	=> $user->format_date(sql_timestamp_to_unix_timestamp($row['user_regdate']), false, true),
								'U_ACTIVATE'	=> generate_board_url() . "/user.$phpEx?op=confirm&username=" . $row['username'] . '&act_key=' . $row['act_key'])
							);

							$messenger->send($row['user_notify_type']);
							$usernames[] = $row['username'];
							$user_ids[] = (int) $row['id'];
						}
						while ($row = $db->sql_fetchrow($result));

						$messenger->save_queue();

						// Add the remind state to the database
						$sql = 'UPDATE ' . $db_prefix . '_users
							SET user_reminded = user_reminded + 1,
								user_reminded_time = ' . time() . '
							WHERE ' . $db->sql_in_set('id', $user_ids);
						$db->sql_query($sql);

						add_log('admin', 'LOG_INACTIVE_REMIND', implode(', ', $usernames));
						unset($usernames);
					}
					$db->sql_freeresult($result);

					// For remind we really need to redirect, else a refresh can result in more than one reminder
					$u_action = $this->u_action . "&amp;$u_sort_param&amp;start=$start";
					$u_action .= ($per_page != $config['topics_per_page']) ? "&amp;users_per_page=$per_page" : '';

					redirect($u_action);

				break;
			}
		}

		// Define where and sort sql for use in displaying logs
		$sql_where = ($sort_days) ? (time() - ($sort_days * 86400)) : 0;
		$sql_sort = $sort_by_sql[$sort_key] . ' ' . (($sort_dir == 'd') ? 'DESC' : 'ASC');

		$inactive = array();
		$inactive_count = 0;

		$start = view_inactive_users($inactive, $inactive_count, $per_page, $start, $sql_where, $sql_sort);

		foreach ($inactive as $row)
		{
			$template->assign_block_vars('inactive', array(
				'INACTIVE_DATE'	=> $user->format_date($row['user_inactive_time']),
				'REMINDED_DATE'	=> $user->format_date($row['user_reminded_time']),
				'JOINED'		=> $user->format_date(sql_timestamp_to_unix_timestamp($row['regdate'])),
				'LAST_VISIT'	=> (!$row['lastlogin']) ? ' - ' : $user->format_date(sql_timestamp_to_unix_timestamp($row['lastlogin'])),

				'REASON'		=> $row['inactive_reason'],
				'USER_ID'		=> $row['id'],
				'POSTS'			=> ($row['user_posts']) ? $row['user_posts'] : 0,
				'REMINDED'		=> $row['user_reminded'],

				'REMINDED_EXPLAIN'	=> $user->lang('USER_LAST_REMINDED', (int) $row['user_reminded'], $user->format_date($row['user_reminded_time'])),

				'USERNAME_FULL'		=> get_username_string('full', $row['id'], $row['username'], '#' . $row['user_colour'], false, append_sid("./admin.$phpEx", 'op=user&amp;i=userinfo&amp;mode=overview&amp;vas=overview&amp;u=')),
				'USERNAME'			=> get_username_string('username', $row['id'], $row['username'],  '#' . $row['user_colour']),
				'USER_COLOR'		=> get_username_string('colour', $row['id'], $row['username'],  '#' . $row['user_colour']),

				'U_USER_ADMIN'	=> append_sid("admin.$phpEx", "op=user&amp;i=userinfo&amp;mode=overview&amp;vas=overview&amp;u={$row['id']}"),
				'U_SEARCH_USER'	=> ($auth->acl_get('u_search')) ? append_sid("forum.$phpEx", "action=search&amp;author_id={$row['id']}&amp;sr=posts") : '',
			));
		}

		$option_ary = array('activate' => 'ACTIVATE', 'delete' => 'DELETE');
		if ($config['email_enable'])
		{
			$option_ary += array('remind' => 'REMIND');
		}

		$template->assign_vars(array(
			'S_INACTIVE_USERS'		=> true,
			'S_INACTIVE_OPTIONS'	=> build_select($option_ary),

			'S_LIMIT_DAYS'	=> $s_limit_days,
			'S_SORT_KEY'	=> $s_sort_key,
			'S_SORT_DIR'	=> $s_sort_dir,
			'S_ON_PAGE'		=> on_page($inactive_count, $per_page, $start),
			'PAGINATION'	=> generate_pagination($this->u_action . "&amp;$u_sort_param&amp;users_per_page=$per_page", $inactive_count, $per_page, $start, true),
			'USERS_PER_PAGE'	=> $per_page,

			'U_ACTION'		=> $this->u_action . "&amp;$u_sort_param&amp;users_per_page=$per_page&amp;start=$start",
		));

		$this->tpl_name = 'acp_users_list';
		$this->page_title = 'ACP_INACTIVE_USERS';
	}
}
?>