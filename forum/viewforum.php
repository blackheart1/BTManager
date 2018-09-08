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
** File viewforum.php 2018-02-18 14:32:00 joeroberts
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
if ($action == "viewforum") {
$forum_id = request_var('f', 0);
$start		= request_var('start', 0);

$default_sort_days	= (!empty($user->topic_show_days)) ? $user->topic_show_days : 0;
$default_sort_key	= (!empty($user->topic_sortby_type)) ? $user->topic_sortby_type : 't';
$default_sort_dir	= (!empty($user->topic_sortby_dir)) ? $user->topic_sortby_dir : 'd';

$sort_days	= request_var('st', $default_sort_days);
$sort_key	= request_var('sk', $default_sort_key);
$sort_dir	= request_var('sd', $default_sort_dir);

// Check if the user has actually sent a forum ID with his/her request
// If not give them a nice error page.
if (!$forum_id)
{
	trigger_error('NO_FORUM');
}
$page = request_var('page', '');

$sql_from = $db_prefix.'_forums f';
$lastread_select = '';

// Grab appropriate forum data
if ($config['load_db_lastread'] && $user->user)
{
	$sql_from .= ' LEFT JOIN ' . $db_prefix.'_forums_track ft ON (ft.user_id = ' . $user->id . '
		AND ft.forum_id = f.forum_id)';
	$lastread_select .= ', ft.mark_time';
}

if ($user->user)
{
	$sql_from .= ' LEFT JOIN ' . $db_prefix.'_forums_watch fw ON (fw.forum_id = f.forum_id AND fw.user_id = ' . $user->id . ')';
	$lastread_select .= ', fw.notify_status';
}

$sql = "SELECT f.* $lastread_select
	FROM $sql_from
	WHERE f.forum_id = $forum_id";
$result = $db->sql_query($sql);
$forum_data = $db->sql_fetchrow($result);
$db->sql_freeresult($result);

if (!$forum_data)
{
	trigger_error('NO_FORUM');
}


// Redirect to login upon emailed notification links
if (isset($_GET['e']) && !$user->user)
{
	$mes = '';
	$rd = '';
	if($post_id) $rd .= '&amp;p=' . $post_id;
	if($topic_id) $rd .= '&amp;t=' . $topic_id;
	if($forum_id) $rd .= '&amp;f=' . $forum_id;
	if(isset($_GET['e'])) $rd .= '&amp;e=' . $$_GET['e'];
	$redirect = append_sid("{$phpbb_root_path}forum.php?action=viewforum", $rd );
	$mes .= $user->lang['LOGIN_NOTIFY_FORUM'];
			$gfximage = '';
                if ($gfx_check) {
					if($recap_puplic_key)
					{
							   $template->assign_vars(array(
										'META'						=> "<script src='https://www.google.com/recaptcha/api.js'></script>",
										'RECAPTCHA'					=>	$recap_puplic_key,
                                ));
                        //$gfximage = recaptcha_get_html($recap_puplic_key, null, $recap_https);
					}else{
                        $rnd_code = strtoupper(RandomAlpha(5));
						$hidden ['gfxcheck'] = md5($rnd_code);
                        $gfximage = "<img src=\"gfxgen.php?code=".base64_encode($rnd_code)."\">";
					}
                }
				$hidden['op'] = 'login';
				$hidden['returnto'] = $redirect;
							   $template->assign_vars(array(
							   			'U_ACTION'					=>	'login.' . $phpEx,
							   			'S_ERROR'					=>	true,
										'S_ERROR_MESS'				=>	$mes,
										'S_GFX_CHECK'				=>	($gfx_check)? $gfximage : false,
										'HIDDEN'					=>	build_hidden_fields($hidden),
                                ));

echo $template->fetch('login.html');
close_out();
}

// Permissions check
if (!acl_gets('f_list', 'f_read', $forum_id) || ($forum_data['forum_type'] == 2 && $forum_data['forum_link'] && !$auth->acl_get('f_read', $forum_id)))
{
	login_box('', $user->lang['LOGIN_VIEWFORUM']);
	$mes = '';
	if ($user->id != 0)
	{
		$mes .= $user->lang['SORRY_AUTH_READ'] . '<br />';
	}
	$rd = '';
	if($post_id) $rd .= '&amp;p=' . $post_id;
	if($topic_id) $rd .= '&amp;t=' . $topic_id;
	if($forum_id) $rd .= '&amp;f=' . $forum_id;
	if(isset($_GET['e'])) $rd .= '&amp;e=' . $$_GET['e'];
	$redirect = append_sid("{$phpbb_root_path}forum.php?action=posting", 'mode=' . $mode . $rd );
	$mes .= $user->lang['LOGIN_VIEWFORUM'];
			$gfximage = '';
                if ($gfx_check) {
					if($recap_puplic_key)
					{
							   $template->assign_vars(array(
										'META'						=> "<script src='https://www.google.com/recaptcha/api.js'></script>",
										'RECAPTCHA'					=>	$recap_puplic_key,
                                ));
                        //$gfximage = recaptcha_get_html($recap_puplic_key, null, $recap_https);
					}else{
                        $rnd_code = strtoupper(RandomAlpha(5));
						$hidden ['gfxcheck'] = md5($rnd_code);
                        $gfximage = "<img src=\"gfxgen.php?code=".base64_encode($rnd_code)."\">";
					}
                }
				$hidden['op'] = 'login';
				$hidden['returnto'] = $redirect;
							   $template->assign_vars(array(
							   			'U_ACTION'					=>	'login.' . $phpEx,
							   			'S_ERROR'					=>	true,
										'S_ERROR_MESS'				=>	$mes,
										'S_GFX_CHECK'				=>	($gfx_check)? $gfximage : false,
										'HIDDEN'					=>	build_hidden_fields($hidden),
                                ));

echo $template->fetch('login.html');
close_out();
}

// Forum is passworded ... check whether access has been granted to this
// user this session, if not show login box
if ($forum_data['forum_password'])
{
	login_forum_box($forum_data);
}

// Is this forum a link? ... User got here either because the
// number of clicks is being tracked or they guessed the id
if ($forum_data['forum_type'] == 2 && $forum_data['forum_link'])
{
	// Does it have click tracking enabled?
	if ($forum_data['forum_flags'] & 1)
	{
		$sql = 'UPDATE ' . $db_prefix.'_forums
			SET forum_posts = forum_posts + 1
			WHERE forum_id = ' . $forum_id;
		$db->sql_query($sql);
	}
				meta_refresh(5,$forum_data['forum_link']);
				$template->assign_vars(array(
					'S_SUCCESS'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['REDIRECT'],
					'MESSAGE'			=> sprintf($user->lang['REDIRECTING'],$title),
				));
				echo $template->fetch('message_body.html');
				close_out();

}

// Build navigation links
generate_forum_nav($forum_data);

// Forum Rules
if ($auth->acl_get('f_read', $forum_id))
{
	generate_forum_rules($forum_data);
}

// Do we have subforums?
$active_forum_ary = $moderators = array();

if ($forum_data['left_id'] != $forum_data['right_id'] - 1)
{
	list($active_forum_ary, $moderators) = display_forums($forum_data, $config['load_moderators'], $config['load_moderators']);
}
else
{
	$template->assign_var('S_HAS_SUBFORUM', false);
	get_moderators($moderators, $forum_id);
}

set_site_var($user->lang['VIEW_FORUM'] . ' - ' . $forum_data['forum_name']);

make_jumpbox(append_sid("{$phpbb_root_path}forum.$phpEx",'action=viewforum'), $forum_id,false,false,true);

$template->assign_vars(array(
	'U_VIEW_FORUM'			=> append_sid("{$phpbb_root_path}forum.$phpEx", "action=viewforum&amp;f=$forum_id&amp;start=$start"),
));

// Not postable forum or showing active topics?
if (!($forum_data['forum_type'] == 1 || (($forum_data['forum_flags'] & 16) && $forum_data['forum_type'] == 0)))
{
echo $template->fetch('forum_index.html');
close_out();
}

// Ok, if someone has only list-access, we only display the forum list.
// We also make this circumstance available to the template in case we want to display a notice. ;)
if (!$auth->acl_get('f_read', $forum_id))
{
	$template->assign_vars(array(
		'S_NO_READ_ACCESS'		=> true,
		'S_AUTOLOGIN_ENABLED'	=> ($config['allow_autologin']) ? true : false,
		'S_LOGIN_ACTION'		=> append_sid("{$phpbb_root_path}login.$phpEx", 'return=' . urlencode(str_replace('&amp;', '&', build_url()))),
	));

	page_footer();
}

// Is a forum specific topic count required?
if ($forum_data['forum_topics_per_page'])
{
	$torrent_per_page = $forum_data['forum_topics_per_page'];
}

// Do the forum Prune thang - cron type job ...
if ($forum_data['prune_next'] < time() && $forum_data['enable_prune'])
{
	$template->assign_var('RUN_CRON_TASK', '<img src="' . append_sid($phpbb_root_path . 'cron.' . $phpEx, 'cron_type=prune_forum&amp;f=' . $forum_id) . '" alt="cron" width="1" height="1" />');
}

// Forum rules and subscription info
$s_watching_forum = array(
	'link'			=> '',
	'title'			=> '',
	'is_watching'	=> false,
);

if (($config['email_enable'] || $config['jab_enable']) && $config['allow_forum_notify'] && $forum_data['forum_type'] == 1 && $auth->acl_get('f_subscribe', $forum_id))
{
	$notify_status = (isset($forum_data['notify_status'])) ? $forum_data['notify_status'] : NULL;
	watch_topic_forum('forum', $s_watching_forum, $user->id, $forum_id, 0, $notify_status);
	//die(print_r($s_watching_forum));
}

$s_forum_rules = '';
gen_forum_auth_level('forum', $forum_id, $forum_data['forum_status']);

// Topic ordering options
$limit_days = array(0 => $user->lang['ALL_TOPICS'], 1 => $user->lang['1_DAY'], 7 => $user->lang['7_DAYS'], 14 => $user->lang['2_WEEKS'], 30 => $user->lang['1_MONTH'], 90 => $user->lang['3_MONTHS'], 180 => $user->lang['6_MONTHS'], 365 => $user->lang['1_YEAR']);

$sort_by_text = array('a' => $user->lang['AUTHOR'], 't' => $user->lang['POST_TIME'], 'r' => $user->lang['REPLIES'], 's' => $user->lang['SUBJECT'], 'v' => $user->lang['VIEWS']);
$sort_by_sql = array('a' => 't.topic_first_poster_name', 't' => 't.topic_last_post_time', 'r' => 't.topic_replies', 's' => 't.topic_title', 'v' => 't.topic_views');

$s_limit_days = $s_sort_key = $s_sort_dir = $u_sort_param = '';
gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sort_dir, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param, $default_sort_days, $default_sort_key, $default_sort_dir);

// Limit topics to certain time frame, obtain correct topic count
// global announcements must not be counted, normal announcements have to
// be counted, as forum_topics(_real) includes them
if ($sort_days)
{
	$min_post_time = time() - ($sort_days * 86400);

	$sql = 'SELECT COUNT(topic_id) AS num_topics
		FROM ' . $db_prefix."_topics
		WHERE forum_id = $forum_id
			AND ((topic_type <> " . 3 . " AND topic_last_post_time >= $min_post_time)
				OR topic_type = " . 2 . ")
		" . (($auth->acl_get('m_approve', $forum_id)) ? '' : 'AND topic_approved = 1');
	$result = $db->sql_query($sql);
	$topics_count = (int) $db->sql_fetchfield('num_topics');
	$db->sql_freeresult($result);

	if (isset($_POST['sort']))
	{
		$start = 0;
	}
	$sql_limit_time = "AND t.topic_last_post_time >= $min_post_time";

	// Make sure we have information about day selection ready
	$template->assign_var('S_SORT_DAYS', true);
}
else
{
	$topics_count = ($auth->acl_get('m_approve', $forum_id)) ? $forum_data['forum_topics_real'] : $forum_data['forum_topics'];
	$sql_limit_time = '';
}

// Make sure $start is set to the last page if it exceeds the amount
if ($start < 0 || $start > $topics_count)
{
	$start = ($start < 0) ? 0 : floor(($topics_count - 1) / $config['topics_per_page']) * $config['topics_per_page'];
}

// Basic pagewide vars
$post_alt = ($forum_data['forum_status'] == 1) ? $user->lang['FORUM_LOCKED'] : $user->lang['POST_NEW_TOPIC'];

// Display active topics?
$s_display_active = ($forum_data['forum_type'] == 0 && ($forum_data['forum_flags'] & 16)) ? true : false;

$template->assign_vars(array(
	'MODERATORS'	=> (!empty($moderators[$forum_id])) ? implode(', ', $moderators[$forum_id]) : '',
	'U_INDEX'					=>	$siteurl . '/index.' . $phpEx,
	'T_THEME_PATH'	=> $siteurl . '/themes/' . $theme,
	'POST_IMG'					=> ($forum_data['forum_status'] == 1) ? $user->img('button_topic_locked', $post_alt) : $user->img('button_topic_new', $post_alt),
	'NEWEST_POST_IMG'			=> $user->img('icon_topic_newest', 'VIEW_NEWEST_POST'),
	'LAST_POST_IMG'				=> $user->img('icon_topic_latest', 'VIEW_LATEST_POST'),
	'FOLDER_IMG'				=> $user->img('topic_read', 'NO_UNREAD_POSTS'),
	'FOLDER_NEW_IMG'			=> $user->img('topic_unread', 'UNREAD_POSTS'),
	'FOLDER_HOT_IMG'			=> $user->img('topic_read_hot', 'NO_UNREAD_POSTS_HOT'),
	'FOLDER_HOT_NEW_IMG'		=> $user->img('topic_unread_hot', 'UNREAD_POSTS_HOT'),
	'FOLDER_LOCKED_IMG'			=> $user->img('topic_read_locked', 'NO_UNREAD_POSTS_LOCKED'),
	'FOLDER_LOCKED_NEW_IMG'		=> $user->img('topic_unread_locked', 'UNREAD_POSTS_LOCKED'),
	'FOLDER_STICKY_IMG'			=> $user->img('sticky_read', 'POST_STICKY'),
	'FOLDER_STICKY_NEW_IMG'		=> $user->img('sticky_unread', 'POST_STICKY'),
	'FOLDER_ANNOUNCE_IMG'		=> $user->img('announce_read', 'ICON_ANNOUNCEMENT'),
	'FOLDER_ANNOUNCE_NEW_IMG'	=> $user->img('announce_unread', 'POST_ANNOUNCEMENT'),
	'FOLDER_MOVED_IMG'			=> $user->img('topic_moved', 'TOPIC_MOVED'),
	'REPORTED_IMG'				=> $user->img('icon_topic_reported', 'TOPIC_REPORTED'),
	'UNAPPROVED_IMG'			=> $user->img('icon_topic_unapproved', 'TOPIC_UNAPPROVED'),
	'GOTO_PAGE_IMG'				=> $user->img('icon_post_target', 'GOTO_PAGE'),

	'L_NO_TOPICS' 			=> ($forum_data['forum_status'] == 1) ? $user->lang['POST_FORUM_LOCKED'] : $user->lang['NO_TOPICS'],

	'S_DISPLAY_POST_INFO'	=> ($forum_data['forum_type'] == 1 && ($auth->acl_get('f_post', $forum_id) || $user->id == 0)) ? true : false,

	'S_IS_POSTABLE'			=> ($forum_data['forum_type'] == 1) ? true : false,
	'S_USER_CAN_POST'		=> ($auth->acl_get('f_post', $forum_id)) ? true : false,
	'S_DISPLAY_ACTIVE'		=> $s_display_active,
	'S_SELECT_SORT_DIR'		=> $s_sort_dir,
	'S_SELECT_SORT_KEY'		=> $s_sort_key,
	'S_SELECT_SORT_DAYS'	=> $s_limit_days,
	'S_TOPIC_ICONS'			=> ($s_display_active && sizeof($active_forum_ary)) ? max($active_forum_ary['enable_icons']) : (($forum_data['enable_icons']) ? true : false),
	'S_WATCH_FORUM_LINK'	=> $s_watching_forum['link'],
	'S_WATCH_FORUM_TITLE'	=> $s_watching_forum['title'],
	'S_WATCHING_FORUM'		=> $s_watching_forum['is_watching'],
	'S_FORUM_ACTION'		=> append_sid("{$phpbb_root_path}forum.$phpEx?action=viewforum", "f=$forum_id&amp;start=$start"),
	'S_DISPLAY_SEARCHBOX'	=> ($auth->acl_get('u_search') && $auth->acl_get('f_search', $forum_id) && $config['load_search']) ? true : false,
	'S_SEARCHBOX_ACTION'	=> append_sid("{$phpbb_root_path}forum.$phpEx?action=search", 'fid[]=' . $forum_id),
	'S_SEARCH_LOCAL_HIDDEN_FIELDS'	=> build_hidden_fields(array('action'=>'search', 'fid[]' => $forum_id)),
	'S_SINGLE_MODERATOR'	=> (!empty($moderators[$forum_id]) && sizeof($moderators[$forum_id]) > 1) ? false : true,
	'S_IS_LOCKED'			=> ($forum_data['forum_status'] == 1) ? true : false,
	'S_VIEWFORUM'			=> true,

	'U_MCP'				=> ($auth->acl_get('m_', $forum_id)) ? append_sid("{$phpbb_root_path}forum.$phpEx?action_mcp=mcp", "f=$forum_id&amp;i=main&amp;mode=forum_view", true, $user->session_id) : '',
	'U_POST_NEW_TOPIC'	=> ($auth->acl_get('f_post', $forum_id) || $user->id == 0) ? append_sid("{$phpbb_root_path}forum.$phpEx", 'action=posting&amp;mode=post&amp;f=' . $forum_id) : '',
	'U_VIEW_FORUM'		=> append_sid("{$phpbb_root_path}forum.$phpEx?action=viewforum", "f=$forum_id" . ((strlen($u_sort_param)) ? "&amp;$u_sort_param" : '') . "&amp;start=$start"),
	'U_MARK_TOPICS'		=> ($user->user) ? append_sid("{$phpbb_root_path}forum.$phpEx", "action=viewforum&amp;f=$forum_id&amp;mark=topics") : '',
));
// Grab icons
$icons = $pmbt_cache->obtain_icons();

// Grab all topic data
$rowset = $announcement_list = $topic_list = $global_announce_list = array();

$sql_array = array(
	'SELECT'	=> 't.*',
	'FROM'		=> array(
		$db_prefix."_topics"		=> 't'
	),
	'LEFT_JOIN'	=> array(),
);

$sql_approved = ($auth->acl_get('m_approve', $forum_id)) ? '' : 'AND t.topic_approved = 1';

if ($user->user)
{
		$sql_array['LEFT_JOIN'][] = array('FROM' => array($db_prefix . '_topics_posted' => 'tp'), 'ON' => 'tp.topic_id = t.topic_id AND tp.user_id = ' . $user->id);
		$sql_array['SELECT'] .= ', tp.topic_posted';
}

if ($forum_data['forum_type'] == 1)
{
	// Obtain announcements ... removed sort ordering, sort by time in all cases
	$sql = $db->sql_build_query('SELECT', array(
		'SELECT'	=> $sql_array['SELECT'],
		'FROM'		=> $sql_array['FROM'],
		'LEFT_JOIN'	=> $sql_array['LEFT_JOIN'],

		'WHERE'		=> 't.forum_id IN (' . $forum_id . ', 0)
			AND t.topic_type IN (' . 2 . ', ' . 3 . ')',

		'ORDER_BY'	=> 't.topic_time DESC',
	));
	$result = $db->sql_query($sql);

	while ($row = $db->sql_fetchrow($result))
	{
		$rowset[$row['topic_id']] = $row;
		$announcement_list[] = $row['topic_id'];

		if ($row['topic_type'] == 3)
		{
			$global_announce_list[$row['topic_id']] = true;
		}
		else
		{
			$topics_count--;
		}
	}
	$db->sql_freeresult($result);
}

// If the user is trying to reach late pages, start searching from the end
$store_reverse = false;
$sql_limit = $config['topics_per_page'];
if ($start > $topics_count / 2)
{
	$store_reverse = true;

	if ($start + $config['topics_per_page'] > $topics_count)
	{
		$sql_limit = min($config['topics_per_page'], max(1, $topics_count - $start));
	}

	// Select the sort order
	$sql_sort_order = $sort_by_sql[$sort_key] . ' ' . (($sort_dir == 'd') ? 'ASC' : 'DESC');
	$sql_start = max(0, $topics_count - $sql_limit - $start);
}
else
{
	// Select the sort order
	$sql_sort_order = $sort_by_sql[$sort_key] . ' ' . (($sort_dir == 'd') ? 'DESC' : 'ASC');
	$sql_start = $start;
}

if ($forum_data['forum_type'] == 1 || !sizeof($active_forum_ary))
{
	$sql_where = 't.forum_id = ' . $forum_id;
}
else if (empty($active_forum_ary['exclude_forum_id']))
{
	$sql_where = $db->sql_in_set('t.forum_id', $active_forum_ary['forum_id']);
}
else
{
	$get_forum_ids = array_diff($active_forum_ary['forum_id'], $active_forum_ary['exclude_forum_id']);
	$sql_where = (sizeof($get_forum_ids)) ? $db->sql_in_set('t.forum_id', $get_forum_ids) : 't.forum_id = ' . $forum_id;
}

// Grab just the sorted topic ids
$sql = 'SELECT t.topic_id
	FROM ' . $db_prefix."_topics t
	WHERE $sql_where
		AND t.topic_type IN (" . 0 . ', ' . 1 . ")
		$sql_approved
		$sql_limit_time
	ORDER BY t.topic_type " . ((!$store_reverse) ? 'DESC' : 'ASC') . ', ' . $sql_sort_order . '
	LIMIT ' . $sql_start . ' , ' . $sql_limit;
$result = $db->sql_query($sql);

while ($row = $db->sql_fetchrow($result))
{
	$topic_list[] = (int) $row['topic_id'];
}
$db->sql_freeresult($result);

// For storing shadow topics
$shadow_topic_list = array();

if (sizeof($topic_list))
{
	// SQL array for obtaining topics/stickies
	$sql_array = array(
		'SELECT'		=> $sql_array['SELECT'],
		'FROM'			=> $sql_array['FROM'],
		'LEFT_JOIN'		=> $sql_array['LEFT_JOIN'],

		'WHERE'			=> $db->sql_in_set('t.topic_id', $topic_list),
	);

	// If store_reverse, then first obtain topics, then stickies, else the other way around...
	// Funnily enough you typically save one query if going from the last page to the middle (store_reverse) because
	// the number of stickies are not known
	$sql = $db->sql_build_query('SELECT', $sql_array);
	$result = $db->sql_query($sql);

	while ($row = $db->sql_fetchrow($result))
	{
		if ($row['topic_status'] == 2)
		{
			$shadow_topic_list[$row['topic_moved_id']] = $row['topic_id'];
		}

		$rowset[$row['topic_id']] = $row;
	}
	$db->sql_freeresult($result);
}

// If we have some shadow topics, update the rowset to reflect their topic information
if (sizeof($shadow_topic_list))
{
	$sql = 'SELECT *
		FROM ' .$db_prefix.'_topics
		WHERE ' . $db->sql_in_set('topic_id', array_keys($shadow_topic_list));
	$result = $db->sql_query($sql);

	while ($row = $db->sql_fetchrow($result))
	{
		$orig_topic_id = $shadow_topic_list[$row['topic_id']];

		// If the shadow topic is already listed within the rowset (happens for active topics for example), then do not include it...
		if (isset($rowset[$row['topic_id']]))
		{
			// We need to remove any trace regarding this topic. :)
			unset($rowset[$orig_topic_id]);
			unset($topic_list[array_search($orig_topic_id, $topic_list)]);
			$topics_count--;

			continue;
		}

		// Do not include those topics the user has no permission to access
		if (!$auth->acl_get('f_read', $row['forum_id']))
		{
			// We need to remove any trace regarding this topic. :)
			unset($rowset[$orig_topic_id]);
			unset($topic_list[array_search($orig_topic_id, $topic_list)]);
			$topics_count--;

			continue;
		}

		// We want to retain some values
		$row = array_merge($row, array(
			'topic_moved_id'	=> $rowset[$orig_topic_id]['topic_moved_id'],
			'topic_status'		=> $rowset[$orig_topic_id]['topic_status'],
			'topic_type'		=> $rowset[$orig_topic_id]['topic_type'],
		));

		// Shadow topics are never reported
		$row['topic_reported'] = 0;

		$rowset[$orig_topic_id] = $row;
	}
	$db->sql_freeresult($result);
}
unset($shadow_topic_list);

// Ok, adjust topics count for active topics list
if ($s_display_active)
{
	$topics_count = 1;
}
//die($start);
$template->assign_vars(array(
	'PAGINATION'	=> forum_generate_pagination(append_sid("{$phpbb_root_path}forum.$phpEx?action=viewforum", "f=$forum_id" . ((strlen($u_sort_param)) ? "&amp;$u_sort_param" : '')), $topics_count, $torrent_per_page, $start),
	'PAGE_NUMBER'	=> on_page($topics_count, $torrent_per_page, $start),
	'TOTAL_TOPICS'	=> ($s_display_active) ? false : (($topics_count == 1) ? $user->lang['VIEW_FORUM_TOPIC'] : sprintf($user->lang['VIEW_FORUM_TOPICS'], $topics_count)))
);

$topic_list = ($store_reverse) ? array_merge($announcement_list, array_reverse($topic_list)) : array_merge($announcement_list, $topic_list);
$topic_tracking_info = $tracking_topics = array();

// Okay, lets dump out the page ...
if (sizeof($topic_list))
{
	$mark_forum_read = true;
	$mark_time_forum = 0;

	// Active topics?
	if ($s_display_active && sizeof($active_forum_ary))
	{
		// Generate topic forum list...
		$topic_forum_list = array();
		foreach ($rowset as $t_id => $row)
		{
			$topic_forum_list[$row['forum_id']]['forum_mark_time'] = ($user->user && isset($row['forum_mark_time'])) ? $row['forum_mark_time'] : 0;
			$topic_forum_list[$row['forum_id']]['topics'][] = $t_id;
		}

		if ($user->user)
		{
			foreach ($topic_forum_list as $f_id => $topic_row)
			{
				$topic_tracking_info += get_topic_tracking($f_id, $topic_row['topics'], $rowset, array($f_id => $topic_row['forum_mark_time']), false);
			}
		}

		unset($topic_forum_list);
	}
	else
	{
		if ($user->user)
		{
			$topic_tracking_info = get_topic_tracking($forum_id, $topic_list, $rowset, array($forum_id => $forum_data['mark_time']), $global_announce_list);
			$mark_time_forum = (!empty($forum_data['mark_time'])) ? $forum_data['mark_time'] : $user->data['user_lastmark'];
		}
	}

	$s_type_switch = 0;
	foreach ($topic_list as $topic_id)
	{
		$row = &$rowset[$topic_id];

		// This will allow the style designer to output a different header
		// or even separate the list of announcements from sticky and normal topics
		$s_type_switch_test = ($row['topic_type'] == 2 || $row['topic_type'] == 3) ? 1 : 0;

		// Replies
		$replies = ($auth->acl_get('m_approve', $forum_id)) ? $row['topic_replies_real'] : $row['topic_replies'];

		if ($row['topic_status'] == 2)
		{
			$topic_id = $row['topic_moved_id'];
			$unread_topic = false;
		}
		else
		{
			$unread_topic = (isset($topic_tracking_info[$topic_id]) && $row['topic_last_post_time'] > $topic_tracking_info[$topic_id]) ? true : false;
		}

		// Get folder img, topic status/type related information
		$folder_img = $folder_alt = $topic_type = '';
		topic_status($row, $replies, $unread_topic, $folder_img, $folder_alt, $topic_type);

		// Generate all the URIs ...
		$view_topic_url_params = 'f=' . (($row['forum_id']) ? $row['forum_id'] : $forum_id) . '&amp;t=' . $topic_id;
		$view_topic_url = append_sid("{$phpbb_root_path}forum.$phpEx?action=viewtopic", $view_topic_url_params);

		$topic_unapproved = (!$row['topic_approved'] && $auth->acl_get('m_approve', $forum_id)) ? true : false;
		$posts_unapproved = ($row['topic_approved'] && $row['topic_replies'] < $row['topic_replies_real'] && $auth->acl_get('m_approve', $forum_id)) ? true : false;
		$u_mcp_queue = ($topic_unapproved || $posts_unapproved) ? append_sid("{$phpbb_root_path}forum.$phpEx?action_mcp=mcp", 'i=queue&amp;mode=' . (($topic_unapproved) ? 'approve_details' : 'unapproved_posts') . "&amp;t=$topic_id", true, $user->session_id) : '';

		// Send vars to template
		$template->assign_block_vars('topicrow', array(
			'FORUM_ID'					=> $forum_id,
			'TOPIC_ID'					=> $topic_id,
			'TOPIC_AUTHOR'				=> get_username_string('username', $row['topic_poster'], $row['topic_first_poster_name'],'#' .  $row['topic_first_poster_colour']),
			'TOPIC_AUTHOR_COLOUR'		=> get_username_string('colour', $row['topic_poster'], $row['topic_first_poster_name'],'#' .  $row['topic_first_poster_colour']),
			'TOPIC_AUTHOR_FULL'			=> get_username_string('full', $row['topic_poster'], $row['topic_first_poster_name'],'#' .  $row['topic_first_poster_colour']),
			'FIRST_POST_TIME'			=> $user->format_date($row['topic_time']),
			'LAST_POST_SUBJECT'			=> censor_text($row['topic_last_post_subject']),
			'LAST_POST_TIME'			=> $user->format_date($row['topic_last_post_time']),
			'LAST_VIEW_TIME'			=> $user->format_date($row['topic_last_view_time']),
			'LAST_POST_AUTHOR'			=> get_username_string('username', $row['topic_last_poster_id'], $row['topic_last_poster_name'],'#' .  $row['topic_last_poster_colour']),
			'LAST_POST_AUTHOR_COLOUR'	=> get_username_string('colour', $row['topic_last_poster_id'], $row['topic_last_poster_name'],'#' .  $row['topic_last_poster_colour']),
			'LAST_POST_AUTHOR_FULL'		=> get_username_string('full', $row['topic_last_poster_id'], $row['topic_last_poster_name'],'#' .  $row['topic_last_poster_colour']),

			'PAGINATION'		=> topic_generate_pagination($replies, $view_topic_url),
			'REPLIES'			=> $replies,
			'VIEWS'				=> $row['topic_views'],
			'TOPIC_TITLE'		=> censor_text($row['topic_title']),
			'TOPIC_TYPE'		=> $topic_type,

			'TOPIC_FOLDER_IMG'		=> $user->img($folder_img, $folder_alt),
			'TOPIC_FOLDER_IMG_SRC'	=> $user->img($folder_img, $folder_alt, false, '', 'src'),
			'TOPIC_FOLDER_IMG_ALT'	=> $user->lang[$folder_alt],
			'TOPIC_FOLDER_IMG_WIDTH'=> $user->img($folder_img, '', false, '', 'width'),
			'TOPIC_FOLDER_IMG_HEIGHT'	=> $user->img($folder_img, '', false, '', 'height'),

			'TOPIC_ICON_IMG'		=> (!empty($icons[$row['icon_id']])) ? $siteurl . '/images/icons/' . $icons[$row['icon_id']]['img'] : '',
			'TOPIC_ICON_IMG_WIDTH'	=> (!empty($icons[$row['icon_id']])) ? $icons[$row['icon_id']]['width'] : '',
			'TOPIC_ICON_IMG_HEIGHT'	=> (!empty($icons[$row['icon_id']])) ? $icons[$row['icon_id']]['height'] : '',
			'ATTACH_ICON_IMG'		=> ($auth->acl_get('u_download') && $auth->acl_get('f_download', $forum_id) && $row['topic_attachment']) ? $user->img('icon_topic_attach', $user->lang['TOTAL_ATTACHMENTS']) : '',
			'UNAPPROVED_IMG'		=> ($topic_unapproved || $posts_unapproved) ? $user->img('icon_topic_unapproved', ($topic_unapproved) ? 'TOPIC_UNAPPROVED' : 'POSTS_UNAPPROVED') : '',

			'S_TOPIC_TYPE'			=> $row['topic_type'],
			'S_USER_POSTED'			=> (isset($row['topic_posted']) && $row['topic_posted']) ? true : false,
			'S_UNREAD_TOPIC'		=> $unread_topic,
			'S_TOPIC_REPORTED'		=> (!empty($row['topic_reported']) && $auth->acl_get('m_report', $forum_id)) ? true : false,
			'S_TOPIC_UNAPPROVED'	=> $topic_unapproved,
			'S_POSTS_UNAPPROVED'	=> $posts_unapproved,
			'S_HAS_POLL'			=> ($row['poll_start']) ? true : false,
			'S_POST_ANNOUNCE'		=> ($row['topic_type'] == 2) ? true : false,
			'S_POST_GLOBAL'			=> ($row['topic_type'] == 3) ? true : false,
			'S_POST_STICKY'			=> ($row['topic_type'] == 1) ? true : false,
			'S_TOPIC_LOCKED'		=> ($row['topic_status'] == 1) ? true : false,
			'S_TOPIC_MOVED'			=> ($row['topic_status'] == 2) ? true : false,

			'U_NEWEST_POST'			=> append_sid("{$phpbb_root_path}forum.$phpEx?action=viewtopic", $view_topic_url_params . '&amp;view=unread') . '#unread',
			'U_LAST_POST'			=> append_sid("{$phpbb_root_path}forum.$phpEx?action=viewtopic", $view_topic_url_params . '&amp;p=' . $row['topic_last_post_id']) . '#p' . $row['topic_last_post_id'],
			'U_LAST_POST_AUTHOR'	=> get_username_string('profile', $row['topic_last_poster_id'], $row['topic_last_poster_name'],'#' .  $row['topic_last_poster_colour']),
			'U_TOPIC_AUTHOR'		=> get_username_string('profile', $row['topic_poster'], $row['topic_first_poster_name'],'#' .  $row['topic_first_poster_colour']),
			'U_VIEW_TOPIC'			=> $view_topic_url,
			'U_MCP_REPORT'			=> append_sid("{$phpbb_root_path}forum.$phpEx?action_mcp=mcp", 'i=reports&amp;mode=reports&amp;f=' . $forum_id . '&amp;t=' . $topic_id, true, $user->session_id),
			'U_MCP_QUEUE'			=> $u_mcp_queue,

			'S_TOPIC_TYPE_SWITCH'	=> ($s_type_switch == $s_type_switch_test) ? -1 : $s_type_switch_test)
		);

		$s_type_switch = ($row['topic_type'] == 2 || $row['topic_type'] == 3) ? 1 : 0;

		if ($unread_topic)
		{
			$mark_forum_read = false;
		}

		unset($rowset[$topic_id]);
	}
}

// This is rather a fudge but it's the best I can think of without requiring information
// on all topics (as we do in 2.0.x). It looks for unread or new topics, if it doesn't find
// any it updates the forum last read cookie. This requires that the user visit the forum
// after reading a topic
if ($forum_data['forum_type'] == 1 && sizeof($topic_list) && $mark_forum_read)
{
	update_forum_tracking_info($forum_id, $forum_data['forum_last_post_time'], false, $mark_time_forum);
}

echo $template->fetch('viewforum_body.html');
close_out();
}
?>