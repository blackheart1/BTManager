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
** File mcp_front.php 2018-02-18 14:32:00 joeroberts
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
function mcp_front_view($id, $mode, $action)
{
	global $phpEx, $phpbb_root_path, $config;
	global $template, $db, $db_prefix, $user, $auth, $module ,$queue_loaded, $reports_loaded, $logs_loaded;

	// Latest 5 unapproved
	if ($queue_loaded)
	{
		$forum_list = array_values(array_intersect(get_forum_list('f_read'), get_forum_list('m_approve')));
		$post_list = array();
		$forum_names = array();

		$forum_id = request_var('f', 0);

		$template->assign_var('S_SHOW_UNAPPROVED', (!empty($forum_list)) ? true : false);
		
		if (!empty($forum_list))
		{
			$sql = 'SELECT COUNT(post_id) AS total
				FROM ' . $db_prefix . '_posts
				WHERE forum_id IN (0, ' . implode(', ', $forum_list) . ')
					AND post_approved = 0';
			$result = $db->sql_query($sql);
			$total = (int) $db->sql_fetchfield('total');
			$db->sql_freeresult($result);

			if ($total)
			{
				$global_id = $forum_list[0];

				$sql = 'SELECT forum_id, forum_name
					FROM ' . $db_prefix . '_forums
					WHERE ' . $db->sql_in_set('forum_id', $forum_list);
				$result = $db->sql_query($sql);

				while ($row = $db->sql_fetchrow($result))
				{
					$forum_names[$row['forum_id']] = $row['forum_name'];
				}
				$db->sql_freeresult($result);

				$sql = 'SELECT post_id
					FROM ' . $db_prefix . '_posts
					WHERE forum_id IN (0, ' . implode(', ', $forum_list) . ')
						AND post_approved = 0
					ORDER BY post_time DESC 
					LIMIT 5';
				$result = $db->sql_query($sql);

				while ($row = $db->sql_fetchrow($result))
				{
					$post_list[] = $row['post_id'];
				}
				$db->sql_freeresult($result);

				if (empty($post_list))
				{
					$total = 0;
				}
			}

			if ($total)
			{
				$sql = 'SELECT p.post_id, p.post_subject, p.post_time, p.poster_id, p.post_username, u.username, u.clean_username, u.can_do , l.group_colour AS user_colour, t.topic_id, t.topic_title, t.topic_first_post_id, p.forum_id
					FROM ' . $db_prefix . '_posts p, ' . $db_prefix . '_topics t, ' . $db_prefix . '_users u, ' . $db_prefix . '_level_settings l
					WHERE ' . $db->sql_in_set('p.post_id', $post_list) . '
						AND t.topic_id = p.topic_id
						AND p.poster_id = u.id 
						AND l.group_id = u.can_do 
					ORDER BY p.post_time DESC';
				$result = $db->sql_query($sql);

				while ($row = $db->sql_fetchrow($result))
				{
					$global_topic = ($row['forum_id']) ? false : true;
					if ($global_topic)
					{
						$row['forum_id'] = $global_id;
					}

					$template->assign_block_vars('unapproved', array(
						'U_POST_DETAILS'	=> append_sid("{$phpbb_root_path}forum.$phpEx?action_mcp=mcp", 'i=queue&amp;mode=approve_details&amp;f=' . $row['forum_id'] . '&amp;p=' . $row['post_id']),
						'U_MCP_FORUM'		=> (!$global_topic) ? append_sid("{$phpbb_root_path}forum.$phpEx?action_mcp=mcp", 'i=main&amp;mode=forum_view&amp;f=' . $row['forum_id']) : '',
						'U_MCP_TOPIC'		=> append_sid("{$phpbb_root_path}forum.$phpEx?action_mcp=mcp", 'i=main&amp;mode=topic_view&amp;f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id']),
						'U_FORUM'			=> (!$global_topic) ? append_sid("{$phpbb_root_path}forum.$phpEx?action=viewforum", 'f=' . $row['forum_id']) : '',
						'U_TOPIC'			=> append_sid("{$phpbb_root_path}forum.$phpEx?action=viewtopic", 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id']),

						'AUTHOR_FULL'		=> get_username_string('full', $row['poster_id'], $row['username'], $row['user_colour']),
						'AUTHOR'			=> get_username_string('username', $row['poster_id'], $row['username'], $row['user_colour']),
						'AUTHOR_COLOUR'		=> get_username_string('colour', $row['poster_id'], $row['username'], $row['user_colour']),
						'U_AUTHOR'			=> get_username_string('profile', $row['poster_id'], $row['username'], $row['user_colour']),

						'FORUM_NAME'	=> (!$global_topic) ? $forum_names[$row['forum_id']] : $user->lang['GLOBAL_ANNOUNCEMENT'],
						'POST_ID'		=> $row['post_id'],
						'TOPIC_TITLE'	=> $row['topic_title'],
						'SUBJECT'		=> ($row['post_subject']) ? $row['post_subject'] : $user->lang['NO_SUBJECT'],
						'POST_TIME'		=> $user->format_date($row['post_time']))
					);
				}
				$db->sql_freeresult($result);
			}

			$template->assign_vars(array(
				'S_MCP_QUEUE_ACTION'	=> append_sid("{$phpbb_root_path}forum.$phpEx?action_mcp=mcp", "i=queue"),
			));

			if ($total == 0)
			{
				$template->assign_vars(array(
					'L_UNAPPROVED_TOTAL'		=> $user->lang['UNAPPROVED_POSTS_ZERO_TOTAL'],
					'S_HAS_UNAPPROVED_POSTS'	=> false)
				);
			}
			else
			{
				$template->assign_vars(array(
					'L_UNAPPROVED_TOTAL'		=> ($total == 1) ? $user->lang['UNAPPROVED_POST_TOTAL'] : sprintf($user->lang['UNAPPROVED_POSTS_TOTAL'], $total),
					'S_HAS_UNAPPROVED_POSTS'	=> true)
				);
			}
		}
	}

	// Latest 5 reported
	if ($reports_loaded)
	{
		$forum_list = array_values(array_intersect(get_forum_list('f_read'), get_forum_list('m_report')));

		$template->assign_var('S_SHOW_REPORTS', (!empty($forum_list)) ? true : false);

		if (!empty($forum_list))
		{
			$sql = 'SELECT COUNT(r.report_id) AS total
				FROM ' . $db_prefix . '_reports r, ' . $db_prefix . '_posts p
				WHERE r.post_id = p.post_id
					AND r.report_closed = 0
					AND p.forum_id IN (0, ' . implode(', ', $forum_list) . ')';
			$result = $db->sql_query($sql);
			$total = (int) $db->sql_fetchfield('total');
			$db->sql_freeresult($result);

			if ($total)
			{
				$global_id = $forum_list[0];

				$sql = $db->sql_build_query('SELECT', array(
					'SELECT'	=> 'r.report_time, 
									p.post_id, 
									p.post_subject, 
									p.post_time, 
									u.username, 
									u.clean_username AS username_clean, 
									u.can_do , 
									l.group_colour AS user_colour, 
									u.id AS user_id, 
									u2.username as author_name, 
									u2.clean_username as author_name_clean, 
									u2.can_do AS auth_can_do , 
									l2.group_colour AS auth_user_colour, u2.id as author_id, t.topic_id, t.topic_title, f.forum_id, f.forum_name',

					'FROM'		=> array(
						$db_prefix . '_reports'				=> 'r',
						$db_prefix . '_reports_reasons'		=> 'rr',
						$db_prefix . '_topics'				=> 't',
						$db_prefix . '_users'				=> array('u', 'u2'),
						$db_prefix . '_posts'				=> 'p',
						$db_prefix . '_level_settings'		=> array('l', 'l2')
					),

					'LEFT_JOIN'	=> array(
						array(
							'FROM'	=> array($db_prefix . '_forums' => 'f'),
							'ON'	=> 'f.forum_id = p.forum_id'
						)
					),

					'WHERE'		=> 'r.post_id = p.post_id
						AND r.report_closed = 0
						AND r.reason_id = rr.reason_id
						AND p.topic_id = t.topic_id
						AND r.user_id = u.id
						AND p.poster_id = u2.id
						AND l.group_id = u.can_do
						AND l2.group_id = u2.can_do
						AND p.forum_id IN (0, ' . implode(', ', $forum_list) . ')',

					'ORDER_BY'	=> 'p.post_time DESC',
					'LIMIT'    => '5'
				));
				//die($sql);
				$result = $db->sql_query($sql . ' LIMIT 5');

				while ($row = $db->sql_fetchrow($result))
				{
					$global_topic = ($row['forum_id']) ? false : true;
					if ($global_topic)
					{
						$row['forum_id'] = $global_id;
					}

					$template->assign_block_vars('report', array(
						'U_POST_DETAILS'	=> append_sid("{$phpbb_root_path}forum.$phpEx?action_mcp=mcp", 'f=' . $row['forum_id'] . '&amp;p=' . $row['post_id'] . "&amp;i=reports&amp;mode=report_details"),
						'U_MCP_FORUM'		=> (!$global_topic) ? append_sid("{$phpbb_root_path}forum.$phpEx?action_mcp=mcp", 'f=' . $row['forum_id'] . "&amp;i=$id&amp;mode=forum_view") : '',
						'U_MCP_TOPIC'		=> append_sid("{$phpbb_root_path}forum.$phpEx?action_mcp=mcp", 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id'] . "&amp;i=$id&amp;mode=topic_view"),
						'U_FORUM'			=> (!$global_topic) ? append_sid("{$phpbb_root_path}forum.$phpEx?action=viewforum", 'f=' . $row['forum_id']) : '',
						'U_TOPIC'			=> append_sid("{$phpbb_root_path}forum.$phpEx?action=viewtopic", 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id']),

						'REPORTER_FULL'		=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
						'REPORTER'			=> get_username_string('username', $row['user_id'], $row['username'], $row['user_colour']),
						'REPORTER_COLOUR'	=> get_username_string('colour', $row['user_id'], $row['username'], $row['user_colour']),
						'U_REPORTER'		=> get_username_string('profile', $row['user_id'], $row['username'], $row['user_colour']),

						'AUTHOR_FULL'		=> get_username_string('full', $row['author_id'], $row['author_name'], $row['author_colour']),
						'AUTHOR'			=> get_username_string('username', $row['author_id'], $row['author_name'], $row['author_colour']),
						'AUTHOR_COLOUR'		=> get_username_string('colour', $row['author_id'], $row['author_name'], $row['author_colour']),
						'U_AUTHOR'			=> get_username_string('profile', $row['author_id'], $row['author_name'], $row['author_colour']),

						'FORUM_NAME'	=> (!$global_topic) ? $row['forum_name'] : $user->lang['GLOBAL_ANNOUNCEMENT'],
						'TOPIC_TITLE'	=> $row['topic_title'],
						'SUBJECT'		=> ($row['post_subject']) ? $row['post_subject'] : $user->lang['NO_SUBJECT'],
						'REPORT_TIME'	=> $user->format_date($row['report_time']),
						'POST_TIME'		=> $user->format_date($row['post_time']),
					));
				}
			}

			if ($total == 0)
			{
				$template->assign_vars(array(
					'L_REPORTS_TOTAL'	=>	$user->lang['REPORTS_ZERO_TOTAL'],
					'S_HAS_REPORTS'		=>	false)
				);
			}
			else
			{
				$template->assign_vars(array(
					'L_REPORTS_TOTAL'	=> ($total == 1) ? $user->lang['REPORT_TOTAL'] : sprintf($user->lang['REPORTS_TOTAL'], $total),
					'S_HAS_REPORTS'		=> true)
				);
			}
		}
	}

	// Latest 5 logs
	if ($logs_loaded)
	{
		$forum_list = array_values(array_intersect(get_forum_list('f_read'), get_forum_list('m_')));

		if (!empty($forum_list))
		{
			// Add forum_id 0 for global announcements
			$forum_list[] = 0;

			$log_count = 0;
			$log = array();
			view_log('mod', $log, $log_count, 5, 0, $forum_list);

			foreach ($log as $row)
			{
				$template->assign_block_vars('log', array(
					'USERNAME'		=> $row['username_full'],
					'IP'			=> $row['ip'],
					'TIME'			=> $user->format_date($row['time']),
					'ACTION'		=> $row['action'],
					'U_VIEW_TOPIC'	=> (!empty($row['viewtopic'])) ? $row['viewtopic'] : '',
					'U_VIEWLOGS'	=> (!empty($row['viewlogs'])) ? $row['viewlogs'] : '')
				);
			}
		}

		$template->assign_vars(array(
			'S_SHOW_LOGS'	=> (!empty($forum_list)) ? true : false,
			'S_HAS_LOGS'	=> (!empty($log)) ? true : false)
		);
	}

	$template->assign_var('S_MCP_ACTION', append_sid("{$phpbb_root_path}forum.$phpEx?action_mcp=mcp"));
	make_jumpbox(append_sid("{$phpbb_root_path}forum.$phpEx?action_mcp=mcp", 'i=main&amp;mode=forum_view'), 0, false, 'm_', true);
}

?>