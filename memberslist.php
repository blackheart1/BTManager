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
** File memberslist.php 2018-02-17 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (defined('IN_PMBT'))
{
	die ("You can't include this file");
}
else
{
	define("IN_PMBT",true);
}
require_once("common.php");
require_once("include/torrent_functions.php");
include_once("include/utf/utf_tools.php");
$template = new Template();
$user->set_lang('memberslist',$user->ulanguage);
set_site_var($user->lang['TITLE']);

// Grab data
$mode		= request_var('mode', '');
$action		= request_var('action', '');
$user_id	= request_var('u', 0);
$username	= request_var('un', '', true);
$group_id	= request_var('g', 0);
$topic_id	= request_var('t', 0);
$config['load_search'] = true;

// Check our mode...
if (!in_array($mode, array('', 'group', 'viewprofile', 'email', 'contact', 'searchuser', 'leaders')))
{
	trigger_error('NO_MODE');
}

switch ($mode)
{
	case 'email':
	break;

	default:
		// Can this user view profiles/memberslist?
		if (!$auth->acl_gets('u_viewprofile', 'a_user', 'a_useradd', 'a_userdel'))
		{
			if ($user->id != 0)
			{
				trigger_error('NO_VIEW_USERS');
			}

			login_box('', ((isset($user->lang['LOGIN_EXPLAIN_' . strtoupper($mode)])) ? $user->lang['LOGIN_EXPLAIN_' . strtoupper($mode)] : $user->lang['LOGIN_EXPLAIN_memberslist']));
		}
	break;
}

$start	= request_var('page', 0);
$submit = (isset($_POST['submit'])) ? true : false;

$default_key = 'c';
$sort_key = request_var('sk', $default_key);
$sort_dir = request_var('sd', 'a');

// What do you want to do today? ... oops, I think that line is taken ...
switch ($mode)
{
	case 'leaders':
		// Display a listing of board admins, moderators
		include($phpbb_root_path . 'includes/functions_user.' . $phpEx);

		$page_title = $user->lang['THE_TEAM'];
		$template_html = 'memberslist_leaders.html';

		$user_ary = $auth->acl_get_list(false, array('a_', 'm_'), false);

		$admin_id_ary = $global_mod_id_ary = $mod_id_ary = $forum_id_ary = array();
		foreach ($user_ary as $forum_id => $forum_ary)
		{
			foreach ($forum_ary as $auth_option => $id_ary)
			{
				if (!$forum_id)
				{
					if ($auth_option == 'a_')
					{
						$admin_id_ary = array_merge($admin_id_ary, $id_ary);
					}
					else
					{
						$global_mod_id_ary = array_merge($global_mod_id_ary, $id_ary);
					}
					continue;
				}
				else
				{
					$mod_id_ary = array_merge($mod_id_ary, $id_ary);
				}

				if ($forum_id)
				{
					foreach ($id_ary as $id)
					{
						$forum_id_ary[$id][] = $forum_id;
					}
				}
			}
		}

		$admin_id_ary = array_unique($admin_id_ary);
		$global_mod_id_ary = array_unique($global_mod_id_ary);

		$mod_id_ary = array_merge($mod_id_ary, $global_mod_id_ary);
		$mod_id_ary = array_unique($mod_id_ary);

		// Admin group id...
		$sql = 'SELECT group_id
			FROM ' . $db_prefix . "_acl_groups
			WHERE group_name = 'ADMINISTRATORS'";
		$result = $db->sql_query($sql);
		$admin_group_id = (int) $db->sql_fetchfield('group_id');
		$db->sql_freeresult($result);

		// Get group memberships for the admin id ary...
		$admin_memberships = group_memberships($admin_group_id, $admin_id_ary);

		$admin_user_ids = array();

		if (!empty($admin_memberships))
		{
			// ok, we only need the user ids...
			foreach ($admin_memberships as $row)
			{
				$admin_user_ids[$row['user_id']] = true;
			}
		}
		unset($admin_memberships);

		$sql = 'SELECT forum_id, forum_name
			FROM ' . $db_prefix . '_forums';
		$result = $db->sql_query($sql);

		$forums = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$forums[$row['forum_id']] = $row['forum_name'];
		}
		$db->sql_freeresult($result);

		$sql = $db->sql_build_query('SELECT', array(
			'SELECT'	=> 'u.id, u.id AS user_id, u.can_do as default_group, u.username, u.clean_username, u.user_colour, u.user_rank, u.user_posts, u.user_allow_pm, g.group_id, g.group_name, g.group_colour, g.group_type, ug.user_id as ug_user_id',

			'FROM'		=> array(
				$db_prefix . '_users'		=> 'u',
				$db_prefix. '_acl_groups'	=> 'g'
			),

			'LEFT_JOIN'	=> array(
				array(
					'FROM'	=> array($db_prefix . '_user_group' => 'ug'),
					'ON'	=> 'ug.group_id = g.group_id AND ug.user_pending = 0 AND ug.user_id = ' . $user->id
				)
			),

			'WHERE'		=> $db->sql_in_set('u.id', array_unique(array_merge($admin_id_ary, $mod_id_ary)), false, true) . '
				AND u.can_do = g.group_id',

			'ORDER_BY'	=> 'g.group_name ASC, u.clean_username ASC'
		));
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$which_row = (in_array($row['user_id'], $admin_id_ary)) ? 'admin' : 'mod';

			// We sort out admins not within the 'Administrators' group.
			// Else, we will list those as admin only having the permission to view logs for example.
			if ($which_row == 'admin' && empty($admin_user_ids[$row['user_id']]))
			{
				// Remove from admin_id_ary, because the user may be a mod instead
				unset($admin_id_ary[array_search($row['user_id'], $admin_id_ary)]);

				if (!in_array($row['user_id'], $mod_id_ary) && !in_array($row['user_id'], $global_mod_id_ary))
				{
					continue;
				}
				else
				{
					$which_row = 'mod';
				}
			}

			$s_forum_select = '';
			$undisclosed_forum = false;

			if (isset($forum_id_ary[$row['user_id']]) && !in_array($row['user_id'], $global_mod_id_ary))
			{
				if ($which_row == 'mod' && sizeof(array_diff(array_keys($forums), $forum_id_ary[$row['user_id']])))
				{
					foreach ($forum_id_ary[$row['user_id']] as $forum_id)
					{
						if (isset($forums[$forum_id]))
						{
							if ($auth->acl_get('f_list', $forum_id))
							{
								$s_forum_select .= '<option value="">' . $forums[$forum_id] . '</option>';
							}
							else
							{
								$undisclosed_forum = true;
							}
						}
					}
				}
			}

			// If the mod is only moderating non-viewable forums we skip the user. There is no gain in displaying the person then...
			if (!$s_forum_select && $undisclosed_forum)
			{
//				$s_forum_select = '<option value="">' . $user->lang['FORUM_UNDISCLOSED'] . '</option>';
				continue;
			}

			// The person is moderating several "public" forums, therefore the person should be listed, but not giving the real group name if hidden.
			if ($row['group_type'] == GROUP_HIDDEN && !$auth->acl_gets('a_group', 'a_groupadd', 'a_groupdel') && $row['ug_user_id'] != $user->id)
			{
				$group_name = $user->lang['GROUP_UNDISCLOSED'];
				$u_group = '';
			}
			else
			{
				$group_name = ($row['group_type'] == GROUP_SPECIAL) ? $user->lang['G_' . $row['group_name']] : $row['group_name'];
				$u_group = append_sid("{$phpbb_root_path}memberslist.$phpEx", 'mode=group&amp;g=' . $row['group_id']);
			}

			$rank_title = $rank_img = '';
			get_user_rank($row['user_rank'], (($row['user_id'] == 0) ? false : $row['user_posts']), $rank_title, $rank_img, $rank_img_src);

			$template->assign_block_vars($which_row, array(
				'USER_ID'		=> $row['user_id'],
				'FORUMS'		=> $s_forum_select,
				'RANK_TITLE'	=> $rank_title,
				'GROUP_NAME'	=> $group_name,
				'GROUP_COLOR'	=> $row['group_colour'],

				'RANK_IMG'		=> $rank_img,
				'RANK_IMG_SRC'	=> $rank_img_src,

				'U_GROUP'			=> $u_group,
				'U_PM'				=> ($config['allow_privmsg'] && $auth->acl_get('u_sendpm') && ($row['user_allow_pm'] || $auth->acl_gets('a_', 'm_') || $auth->acl_getf_global('m_'))) ? append_sid("{$phpbb_root_path}ucp.$phpEx", 'i=pm&amp;mode=compose&amp;u=' . $row['user_id']) : '',

				'USERNAME_FULL'		=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
				'USERNAME'			=> get_username_string('username', $row['user_id'], $row['username'], $row['user_colour']),
				'USER_COLOR'		=> get_username_string('colour', $row['user_id'], $row['username'], $row['user_colour']),
				'U_VIEW_PROFILE'	=> get_username_string('profile', $row['user_id'], $row['username'], $row['user_colour']),
			));
		}
		$db->sql_freeresult($result);

		$template->assign_vars(array(
			'PM_IMG'		=> $user->img('icon_contact_pm', $user->lang['SEND_PRIVATE_MESSAGE']))
		);
	break;

	case 'contact':

		$page_title = $user->lang['IM_USER'];
		$template_html = 'memberlist_im.html';

		if (!$auth->acl_get('u_sendim'))
		{
			trigger_error('NOT_AUTHORISED');
		}

		$presence_img = '';
		switch ($action)
		{
			case 'aim':
				$lang = 'AIM';
				$sql_field = 'user_aim';
				$s_select = 'S_SEND_AIM';
				$s_action = '';
			break;

			case 'msnm':
				$lang = 'MSNM';
				$sql_field = 'msn';
				$s_select = 'S_SEND_MSNM';
				$s_action = '';
			break;

			case 'jabber':
				$lang = 'JABBER';
				$sql_field = 'jabber';
				$s_select = (@extension_loaded('xml') && $config['jab_enable']) ? 'S_SEND_JABBER' : 'S_NO_SEND_JABBER';
				$s_action = append_sid("{$phpbb_root_path}memberslist.$phpEx", "mode=contact&amp;action=$action&amp;u=$user_id");
			break;

			default:
				trigger_error('NO_MODE', E_USER_ERROR);
			break;
		}

		// Grab relevant data
		$sql = "SELECT id AS user_id, username, email AS user_email, language AS user_lang, $sql_field
			FROM " . $db_prefix . "_users
			WHERE user_id = $user_id
				AND user_type IN (" . 0 . ', ' . 3 . ')';
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		if (!$row)
		{
			trigger_error('NO_USER');
		}
		else if (empty($row[$sql_field]))
		{
			trigger_error('IM_NO_DATA');
		}

		// Post data grab actions
		switch ($action)
		{
			case 'jabber':
				add_form_key('memberlist_messaging');

				if ($submit && @extension_loaded('xml') && $config['jab_enable'])
				{
					if (check_form_key('memberlist_messaging'))
					{

						include_once($phpbb_root_path . 'includes/functions_messenger.' . $phpEx);

						$subject = sprintf($user->lang['IM_JABBER_SUBJECT'], $user->name, $config['server_name']);
						$message = utf8_normalize_nfc(request_var('message', '', true));

						if (empty($message))
						{
							trigger_error('EMPTY_MESSAGE_IM');
						}

						$messenger = new messenger(false);

						$messenger->template('profile_send_im', $row['user_lang']);
						$messenger->subject(htmlspecialchars_decode($subject));

						$messenger->replyto($user->email);
						$messenger->im($row['user_jabber'], $row['username']);

						$messenger->assign_vars(array(
							'BOARD_CONTACT'	=> $config['board_contact'],
							'FROM_USERNAME'	=> htmlspecialchars_decode($user->name),
							'TO_USERNAME'	=> htmlspecialchars_decode($row['username']),
							'MESSAGE'		=> htmlspecialchars_decode($message))
						);

						$messenger->send(NOTIFY_IM);

						$s_select = 'S_SENT_JABBER';
					}
					else
					{
						trigger_error('FORM_INVALID');
					}
				}
			break;
		}

		// Send vars to the template
		$template->assign_vars(array(
			'IM_CONTACT'	=> $row[$sql_field],
			'A_IM_CONTACT'	=> addslashes($row[$sql_field]),

			'U_AIM_CONTACT'	=> ($action == 'aim') ? 'aim:addbuddy?screenname=' . urlencode($row[$sql_field]) : '',
			'U_AIM_MESSAGE'	=> ($action == 'aim') ? 'aim:goim?screenname=' . urlencode($row[$sql_field]) . '&amp;message=' . urlencode($config['sitename']) : '',

			'USERNAME'		=> $row['username'],
			'CONTACT_NAME'	=> $row[$sql_field],
			'SITENAME'		=> $config['sitename'],

			'PRESENCE_IMG'		=> $presence_img,

			'L_SEND_IM_EXPLAIN'	=> $user->lang['IM_' . $lang],
			'L_IM_SENT_JABBER'	=> sprintf($user->lang['IM_SENT_JABBER'], $row['username']),

			$s_select			=> true,
			'S_IM_ACTION'		=> $s_action)
		);

	break;

	case 'viewprofile':
		// Display a profile
		if ($user_id == 0 && !$username)
		{
			trigger_error('NO_USER');
		}

		// Get user...
		$sql = 'SELECT *
			FROM ' . $db_prefix . '_users
			WHERE ' . (($username) ? "clean_username = '" . $db->sql_escape(utf8_clean_string($username)) . "'" : "id = $user_id");
		$result = $db->sql_query($sql);
		$member = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		if (!$member)
		{
			trigger_error('NO_USER');
		}

		// a_user admins and founder are able to view inactive users and bots to be able to manage them more easily
		// Normal users are able to see at least users having only changed their profile settings but not yet reactivated.
		if (!$auth->acl_get('a_user') && $user->user_type != 3)
		{
			if ($member['user_type'] == 2)
			{
				trigger_error('NO_USER');
			}
			else if ($member['user_type'] == 1 && $member['user_inactive_reason'] != 2)
			{
				trigger_error('NO_USER');
			}
		}

		$user_id = (int) $member['id'];

		// Get group memberships
		// Also get visiting user's groups to determine hidden group memberships if necessary.
		$auth_hidden_groups = ($user_id === (int) $user->id || $auth->acl_gets('a_group', 'a_groupadd', 'a_groupdel')) ? true : false;
		$sql_uid_ary = ($auth_hidden_groups) ? array($user_id) : array($user_id, (int) $user->id);

		// Do the SQL thang
		$sql = 'SELECT g.group_id, g.group_name, g.group_type, ug.user_id
			FROM ' . $db_prefix . '_level_settings g, ' . $db_prefix . '_user_group ug
			WHERE ' . $db->sql_in_set('ug.user_id', $sql_uid_ary) . '
				AND g.group_id = ug.group_id
				AND ug.user_pending = 0';
		$result = $db->sql_query($sql);

		// Divide data into profile data and current user data
		$profile_groups = $user_groups = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$row['user_id'] = (int) $row['user_id'];
			$row['group_id'] = (int) $row['group_id'];

			if ($row['user_id'] == $user_id)
			{
				$profile_groups[] = $row;
			}
			else
			{
				$user_groups[$row['group_id']] = $row['group_id'];
			}
		}
		$db->sql_freeresult($result);

		// Filter out hidden groups and sort groups by name
		$group_data = $group_sort = array();
		foreach ($profile_groups as $row)
		{
			if ($row['group_type'] == 3)
			{
				// Lookup group name in language dictionary
				if (isset($user->lang['G_' . $row['group_name']]))
				{
					$row['group_name'] = $user->lang['G_' . $row['group_name']];
				}
			}
			else if (!$auth_hidden_groups && $row['group_type'] == 3 && !isset($user_groups[$row['group_id']]))
			{
				// Skip over hidden groups the user cannot see
				continue;
			}

			$group_sort[$row['group_id']] = utf8_clean_string($row['group_name']);
			$group_data[$row['group_id']] = $row;
		}
		unset($profile_groups);
		unset($user_groups);
		asort($group_sort);

		$group_options = '';
		foreach ($group_sort as $group_id => $null)
		{
			$row = $group_data[$group_id];

			$group_options .= '<option value="' . $row['group_id'] . '"' . (($row['group_id'] == $member['group_id']) ? ' selected="selected"' : '') . '>' . $row['group_name'] . '</option>';
		}
		unset($group_data);
		unset($group_sort);

		// What colour is the zebra
		$sql = 'SELECT friend, foe
			FROM ' . $db_prefix . "_zebra
			WHERE zebra_id = $user_id
				AND user_id = {$user->id}";

		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		$foe = ($row['foe']) ? true : false;
		$friend = ($row['friend']) ? true : false;
		$db->sql_freeresult($result);

		if ($config['load_onlinetrack'])
		{
			$sql = 'SELECT MAX(session_time) AS session_time, MIN(session_viewonline) AS session_viewonline
				FROM ' . $db_prefix . "_sessions
				WHERE session_user_id = $user_id";
			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			$member['session_time'] = (isset($row['session_time'])) ? $row['session_time'] : 0;
			$member['session_viewonline'] = (isset($row['session_viewonline'])) ? $row['session_viewonline'] :	0;
			unset($row);
		}
		$config['load_user_activity'] = true;
		if ($config['load_user_activity'])
		{
			display_user_activity($member);
		}

		// Do the relevant calculations
		$memberdays = max(1, round((time() - $member['regdate']) / 86400));
		$posts_per_day = $member['user_posts'] / $memberdays;
		$percentage = ($config['num_posts']) ? min(100, ($member['user_posts'] / $config['num_posts']) * 100) : 0;


		if ($member['signature'])
		{
			$member['signature'] = censor_text($member['signature']);

			if ($member['sig_bbcode_bitfield'])
			{
				include_once($phpbb_root_path . 'include/class.bbcode.' . $phpEx);
				include_once($phpbb_root_path . 'include/bbcode.' . $phpEx);
				$bbcode = new bbcode();
				$bbcode->bbcode_second_pass($member['signature'], $member['sig_bbcode_uid'], $member['sig_bbcode_bitfield']);
			}

		//	$member['signature'] = bbcode_nl2br($member['signature']);
	//		$member['signature'] = smiley_text($member['signature']);
		}

		$poster_avatar = gen_avatar($member['id']);

		// We need to check if the modules 'zebra' ('friends' & 'foes' mode),  'notes' ('user_notes' mode) and  'warn' ('warn_user' mode) are accessible to decide if we can display appropriate links
		$zebra_enabled = $friends_enabled = $foes_enabled = $user_notes_enabled = $warn_user_enabled = false;

		// Only check if the user is logged in
		if ($user->user)
		{
			if (!class_exists('p_master'))
			{
				include($phpbb_root_path . 'include/modules.' . $phpEx);
			}
			$module = new p_master();

			$module->list_modules('ucp');
			$module->list_modules('mcp');

			$user_notes_enabled = ($module->loaded('notes', 'user_notes')) ? true : false;
			$warn_user_enabled = ($module->loaded('warn', 'warn_user')) ? true : false;
			$zebra_enabled = ($module->loaded('zebra')) ? true : false;
			$friends_enabled = ($module->loaded('zebra', 'friends')) ? true : false;
			$foes_enabled = ($module->loaded('zebra', 'foes')) ? true : false;

			unset($module);
		}

		$template->assign_vars(show_profile($member, $user_notes_enabled, $warn_user_enabled));

		// Custom Profile Fields
		$profile_fields = array();
		if ($config['load_cpf_viewprofile'])
		{
			include_once($phpbb_root_path . 'include/functions_profile_fields.' . $phpEx);
			$cp = new custom_profile();
			$profile_fields = $cp->generate_profile_fields_template('grab', $user_id);
			$profile_fields = (isset($profile_fields[$user_id])) ? $cp->generate_profile_fields_template('show', false, $profile_fields[$user_id]) : array();
		}

		// If the user has m_approve permission or a_user permission, then list then display unapproved posts
		if ($auth->acl_getf_global('m_approve') || $auth->acl_get('a_user'))
		{
			$sql = 'SELECT COUNT(post_id) as posts_in_queue
				FROM ' . $db_prefix . '_posts
				WHERE poster_id = ' . $user_id . '
					AND post_approved = 0';
			$result = $db->sql_query($sql);
			$member['posts_in_queue'] = (int) $db->sql_fetchfield('posts_in_queue');
			$db->sql_freeresult($result);
		}
		else
		{
			$member['posts_in_queue'] = 0;
		}

		$template->assign_vars(array(
			'L_POSTS_IN_QUEUE'	=> $user->lang('NUM_POSTS_IN_QUEUE', $member['posts_in_queue']),

			'POSTS_DAY'			=> sprintf($user->lang['POST_DAY'], $posts_per_day),
			'POSTS_PCT'			=> sprintf($user->lang['POST_PCT'], $percentage),

			'OCCUPATION'	=> (!empty($member['user_occ'])) ? censor_text($member['user_occ']) : '',
			'INTERESTS'		=> (!empty($member['user_interests'])) ? censor_text($member['user_interests']) : '',
			'SIGNATURE'		=> $member['signature'],
			'POSTS_IN_QUEUE'=> $member['posts_in_queue'],

			'AVATAR_IMG'	=> $poster_avatar,
			'PM_IMG'		=> $user->img('icon_contact_pm', $user->lang['SEND_PRIVATE_MESSAGE']),
			'EMAIL_IMG'		=> $user->img('icon_contact_email', $user->lang['EMAIL']),
			'WWW_IMG'		=> $user->img('icon_contact_www', $user->lang['WWW']),
			'ICQ_IMG'		=> $user->img('icon_contact_icq', $user->lang['ICQ']),
			'AIM_IMG'		=> $user->img('icon_contact_aim', $user->lang['AIM']),
			'MSN_IMG'		=> $user->img('icon_contact_msnm', $user->lang['MSNM']),
			'YIM_IMG'		=> $user->img('icon_contact_yahoo', $user->lang['YIM']),
			'JABBER_IMG'	=> $user->img('icon_contact_jabber', $user->lang['JABBER']),
			'SEARCH_IMG'	=> $user->img('icon_user_search', $user->lang['SEARCH']),

			'S_PROFILE_ACTION'	=> append_sid("{$phpbb_root_path}memberslist.$phpEx", 'mode=group'),
			'S_GROUP_OPTIONS'	=> $group_options,
			'S_CUSTOM_FIELDS'	=> (isset($profile_fields['row']) && sizeof($profile_fields['row'])) ? true : false,

			'U_USER_ADMIN'			=> ($auth->acl_get('a_user')) ? append_sid("{$siteurl}/admin.$phpEx", 'op=user&amp;i=userinfo&amp;mode=overview&amp;u=' . $user_id, true, $user->session_id) : '',
			'U_USER_BAN'			=> ($auth->acl_get('m_ban') && $user_id != $user->id) ? append_sid("{$siteurl}/admin.$phpEx", 'op=addban&amp;mode=user&amp;u=' . $user_id, true, $user->session_id) : '',
			'U_MCP_QUEUE'			=> ($auth->acl_getf_global('m_approve')) ? append_sid("{$phpbb_root_path}mcp.$phpEx", 'i=queue', true, $user->session_id) : '',

			//'U_SWITCH_PERMISSIONS'	=> ($auth->acl_get('a_switchperm') && $user->id != $user_id) ? append_sid("{$phpbb_root_path}ucp.$phpEx", "mode=switch_perm&amp;u={$user_id}&amp;hash=" . generate_link_hash('switchperm')) : '',

			'S_USER_NOTES'		=> ($user_notes_enabled) ? true : false,
			'S_WARN_USER'		=> ($warn_user_enabled) ? true : false,
			'S_ZEBRA'			=> ($user->id != $user_id && $user->user && $zebra_enabled) ? true : false,
			'U_ADD_FRIEND'		=> (!$friend && !$foe && $friends_enabled) ? append_sid("{$phpbb_root_path}ucp.$phpEx", 'i=zebra&amp;add=' . urlencode(htmlspecialchars_decode($member['username']))) : '',
			'U_ADD_FOE'			=> (!$friend && !$foe && $foes_enabled) ? append_sid("{$phpbb_root_path}ucp.$phpEx", 'i=zebra&amp;mode=foes&amp;add=' . urlencode(htmlspecialchars_decode($member['username']))) : '',
			'U_REMOVE_FRIEND'	=> ($friend && $friends_enabled) ? append_sid("{$phpbb_root_path}ucp.$phpEx", 'i=zebra&amp;remove=1&amp;usernames[]=' . $user_id) : '',
			'U_REMOVE_FOE'		=> ($foe && $foes_enabled) ? append_sid("{$phpbb_root_path}ucp.$phpEx", 'i=zebra&amp;remove=1&amp;mode=foes&amp;usernames[]=' . $user_id) : '',
		));

		if (!empty($profile_fields['row']))
		{
			$template->assign_vars($profile_fields['row']);
		}

		if (!empty($profile_fields['blockrow']))
		{
			foreach ($profile_fields['blockrow'] as $field_data)
			{
				$template->assign_block_vars('custom_fields', $field_data);
			}
		}

		// Inactive reason/account?
		if ($member['user_type'] == 1)
		{
			$user->add_lang('acp/common');

			$inactive_reason = $user->lang['INACTIVE_REASON_UNKNOWN'];

			switch ($member['user_inactive_reason'])
			{
				case INACTIVE_REGISTER:
					$inactive_reason = $user->lang['INACTIVE_REASON_REGISTER'];
				break;

				case INACTIVE_PROFILE:
					$inactive_reason = $user->lang['INACTIVE_REASON_PROFILE'];
				break;

				case INACTIVE_MANUAL:
					$inactive_reason = $user->lang['INACTIVE_REASON_MANUAL'];
				break;

				case INACTIVE_REMIND:
					$inactive_reason = $user->lang['INACTIVE_REASON_REMIND'];
				break;
			}

			$template->assign_vars(array(
				'S_USER_INACTIVE'		=> true,
				'USER_INACTIVE_REASON'	=> $inactive_reason)
			);
		}

		// Now generate page title
		$page_title = sprintf($user->lang['VIEWING_PROFILE'], $member['username']);
		$template_html = 'memberlist_view.html';

	break;

	case 'email':

		// Send an email
		$page_title = $user->lang['SEND_EMAIL'];
		$template_html = 'memberlist_email.html';

		add_form_key('memberlist_email');

		if (!$config['email_enable'])
		{
			trigger_error('EMAIL_DISABLED');
		}

		if (!$auth->acl_get('u_sendemail'))
		{
			trigger_error('NO_EMAIL');
		}

		// Are we trying to abuse the facility?
		/*if (time() - $user->data['user_emailtime'] < $config['flood_interval'])
		{
			trigger_error('FLOOD_EMAIL_LIMIT');
		}*/

		// Determine action...
		$user_id = request_var('u', 0);
		$topic_id = request_var('t', 0);

		// Send email to user...
		if ($user_id)
		{
			if ($user_id == ANONYMOUS || !$config['board_email_form'])
			{
				trigger_error('NO_EMAIL');
			}

			// Get the appropriate username, etc.
			$sql = 'SELECT username, email AS user_email, accept_mail AS user_allow_viewemail, language AS user_lang, jabber AS user_jabber, user_notify_type
				FROM ' . $db_prefix . "_users
				WHERE id = $user_id
					AND user_type IN (0, 3)";
			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			if (!$row)
			{
				trigger_error('NO_USER');
			}

			// Can we send email to this user?
			if (!$row['user_allow_viewemail'] && !$auth->acl_get('a_user'))
			{
				trigger_error('NO_EMAIL');
			}
		}
		else if ($topic_id)
		{
			// Send topic heads-up to email address
			$sql = 'SELECT forum_id, topic_title
				FROM ' . $db_prefix . "_topics
				WHERE topic_id = $topic_id";
			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			if (!$row)
			{
				trigger_error('NO_TOPIC');
			}

			if ($row['forum_id'])
			{
				if (!$auth->acl_get('f_read', $row['forum_id']))
				{
					trigger_error('SORRY_AUTH_READ');
				}

				if (!$auth->acl_get('f_email', $row['forum_id']))
				{
					trigger_error('NO_EMAIL');
				}
			}
			else
			{
				// If global announcement, we need to check if the user is able to at least read and email in one forum...
				if (!$auth->acl_getf_global('f_read'))
				{
					trigger_error('SORRY_AUTH_READ');
				}

				if (!$auth->acl_getf_global('f_email'))
				{
					trigger_error('NO_EMAIL');
				}
			}
		}
		else
		{
			trigger_error('NO_EMAIL');
		}

		$error = array();

		$name		= utf8_normalize_nfc(request_var('name', '', true));
		$email		= request_var('email', '');
		$email_lang = request_var('lang', $config['default_lang']);
		$subject	= utf8_normalize_nfc(request_var('subject', '', true));
		$message	= utf8_normalize_nfc(request_var('message', '', true));
		$cc			= (isset($_POST['cc_email'])) ? true : false;
		$submit		= (isset($_POST['submit'])) ? true : false;

		if ($submit)
		{
			if (!check_form_key('memberlist_email'))
			{
				$error[] = 'FORM_INVALID';
			}
			if ($user_id)
			{
				if (!$subject)
				{
					$error[] = $user->lang['EMPTY_SUBJECT_EMAIL'];
				}

				if (!$message)
				{
					$error[] = $user->lang['EMPTY_MESSAGE_EMAIL'];
				}

				$name = $row['username'];
				$email_lang = $row['user_lang'];
				$email = $row['user_email'];
			}
			else
			{
				if (!$email || !preg_match('/^' . get_preg_expression('email') . '$/i', $email))
				{
					$error[] = $user->lang['EMPTY_ADDRESS_EMAIL'];
				}

				if (!$name)
				{
					$error[] = $user->lang['EMPTY_NAME_EMAIL'];
				}
			}

			if (!sizeof($error))
			{
				$sql = 'UPDATE ' . $db_prefix . '_users
					SET user_emailtime = ' . time() . '
					WHERE user_id = ' . $user->id;
				//$result = $db->sql_query($sql);

				include_once($phpbb_root_path . 'includes/functions_messenger.' . $phpEx);
				$messenger = new messenger(false);
				$email_tpl = ($user_id) ? 'profile_send_email' : 'email_notify';

				$mail_to_users = array();

				$mail_to_users[] = array(
					'email_lang'		=> $email_lang,
					'email'				=> $email,
					'name'				=> $name,
					'username'			=> ($user_id) ? $row['username'] : '',
					'to_name'			=> $name,
					'user_jabber'		=> ($user_id) ? $row['user_jabber'] : '',
					'user_notify_type'	=> ($user_id) ? $row['user_notify_type'] : 0,
					'topic_title'		=> (!$user_id) ? $row['topic_title'] : '',
					'forum_id'			=> (!$user_id) ? $row['forum_id'] : 0,
				);

				// Ok, now the same email if CC specified, but without exposing the users email address
				if ($cc)
				{
					$mail_to_users[] = array(
						'email_lang'		=> $user->ulanguage,
						'email'				=> $user->email,
						'name'				=> $user->name,
						'username'			=> $user->name,
						'to_name'			=> $name,
						'user_jabber'		=> '',
						'user_notify_type'	=> ($user_id) ? $user->data['user_notify_type'] : 0,
						'topic_title'		=> (!$user_id) ? $row['topic_title'] : '',
						'forum_id'			=> (!$user_id) ? $row['forum_id'] : 0,
					);
				}

				foreach ($mail_to_users as $row)
				{
					$messenger->template($email_tpl, $row['email_lang']);
					$messenger->replyto($user->email);
					$messenger->to($row['email'], $row['name']);

					if ($user_id)
					{
						$messenger->subject(htmlspecialchars_decode($subject));
						$messenger->im($row['user_jabber'], $row['username']);
						$notify_type = $row['user_notify_type'];
					}
					else
					{
						$notify_type = 0;
					}

					$messenger->anti_abuse_headers($config, $user);

					$messenger->assign_vars(array(
						'BOARD_CONTACT'	=> $config['board_contact'],
						'TO_USERNAME'	=> htmlspecialchars_decode($row['to_name']),
						'FROM_USERNAME'	=> htmlspecialchars_decode($user->name),
						'MESSAGE'		=> htmlspecialchars_decode($message))
					);

					if ($topic_id)
					{
						$messenger->assign_vars(array(
							'TOPIC_NAME'	=> htmlspecialchars_decode($row['topic_title']),
							'U_TOPIC'		=> generate_board_url() . "/viewtopic.$phpEx?f=" . $row['forum_id'] . "&t=$topic_id")
						);
					}

					$messenger->send($notify_type);
				}

				meta_refresh(3, append_sid("{$phpbb_root_path}index.$phpEx"));
				$message = ($user_id) ? sprintf($user->lang['RETURN_INDEX'], '<a href="' . append_sid("{$phpbb_root_path}index.$phpEx") . '">', '</a>') : sprintf($user->lang['RETURN_TOPIC'],  '<a href="' . append_sid("{$phpbb_root_path}viewtopic.$phpEx", "f={$row['forum_id']}&amp;t=$topic_id") . '">', '</a>');
				trigger_error($user->lang['EMAIL_SENT'] . '<br /><br />' . $message);
			}
		}

		if ($user_id)
		{
			$template->assign_vars(array(
				'S_SEND_USER'	=> true,
				'USERNAME'		=> $row['username'],

				'L_EMAIL_BODY_EXPLAIN'	=> $user->lang['EMAIL_BODY_EXPLAIN'],
				'S_POST_ACTION'			=> append_sid("{$phpbb_root_path}memberslist.$phpEx", 'mode=email&amp;u=' . $user_id))
			);
		}
		else
		{
			$template->assign_vars(array(
				'EMAIL'				=> $email,
				'NAME'				=> $name,
				'S_LANG_OPTIONS'	=> language_select($email_lang),

				'L_EMAIL_BODY_EXPLAIN'	=> $user->lang['EMAIL_TOPIC_EXPLAIN'],
				'S_POST_ACTION'			=> append_sid("{$phpbb_root_path}memberslist.$phpEx", 'mode=email&amp;t=' . $topic_id))
			);
		}

		$template->assign_vars(array(
			'ERROR_MESSAGE'		=> (sizeof($error)) ? implode('<br />', $error) : '',
			'SUBJECT'			=> $subject,
			'MESSAGE'			=> $message,
			)
		);

	break;

	case 'group':
	default:
		// The basic memberlist
		$page_title = $user->lang['MEMBERLIST'];
		$template_html = 'memberslist.html';

		// Sorting
		$sort_key_text = array('a' => $user->lang['SORT_USERNAME'], 'b' => $user->lang['SORT_LOCATION'], 'c' => $user->lang['SORT_JOINED'], 'd' => $user->lang['SORT_POST_COUNT'], 'g' => $user->lang['ICQ'], 'h' => $user->lang['AIM'], 'i' => $user->lang['MSNM'], 'j' => $user->lang['YIM'], 'k' => $user->lang['JABBER']);
		$sort_key_sql = array('a' => 'u.clean_username', 'b' => 'u.user_from', 'c' => 'u.regdate', 'd' => 'u.user_posts', 'g' => 'u.icq', 'h' => 'u.aim', 'i' => 'u.msn', 'j' => 'u.yahoo', 'k' => 'u.jabber');

		if ($auth->acl_get('a_user'))
		{
			$sort_key_text['e'] = $user->lang['SORT_EMAIL'];
			$sort_key_sql['e'] = 'u.email';
		}

		if ($auth->acl_get('u_viewonline'))
		{
			$sort_key_text['l'] = $user->lang['SORT_LAST_ACTIVE'];
			$sort_key_sql['l'] = 'u.lastlogin';
		}

		$sort_key_text['m'] = $user->lang['SORT_RANK'];
		$sort_key_sql['m'] = 'u.user_rank';

		$sort_dir_text = array('a' => $user->lang['ASCENDING'], 'd' => $user->lang['DESCENDING']);

		$s_sort_key = '';
		foreach ($sort_key_text as $key => $value)
		{
			$selected = ($sort_key == $key) ? ' selected="selected"' : '';
			$s_sort_key .= '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
		}

		$s_sort_dir = '';
		foreach ($sort_dir_text as $key => $value)
		{
			$selected = ($sort_dir == $key) ? ' selected="selected"' : '';
			$s_sort_dir .= '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
		}

		// Additional sorting options for user search ... if search is enabled, if not
		// then only admins can make use of this (for ACP functionality)
		$sql_select = $sql_where_data = $sql_from = $sql_where = $order_by = '';


		$form			= request_var('form', '');
		$field			= request_var('field', '');
		$select_single 	= request_var('select_single', false);

		// Search URL parameters, if any of these are in the URL we do a search
		$search_params = array('username', 'email', 'icq', 'aim', 'yahoo', 'msn', 'jabber', 'search_group_id', 'joined_select', 'active_select', 'count_select', 'joined', 'active', 'count', 'ip');

		// We validate form and field here, only id/class allowed
		$form = (!preg_match('/^[a-z0-9_-]+$/i', $form)) ? '' : $form;
		$field = (!preg_match('/^[a-z0-9_-]+$/i', $field)) ? '' : $field;
		if (($mode == 'searchuser' || sizeof(array_intersect(array_keys($_GET), $search_params)) > 0) && ($config['load_search'] || $auth->acl_get('a_')))
		{
			$username	= request_var('username', '', true);
			$email		= strtolower(request_var('email', ''));
			$icq		= request_var('icq', '');
			$aim		= request_var('aim', '');
			$yahoo		= request_var('yahoo', '');
			$msn		= request_var('msn', '');
			$jabber		= request_var('jabber', '');
			$search_group_id	= request_var('search_group_id', 0);

			// when using these, make sure that we actually have values defined in $find_key_match
			$joined_select	= request_var('joined_select', 'lt');
			$active_select	= request_var('active_select', 'lt');
			$count_select	= request_var('count_select', 'eq');

			$joined			= explode('-', request_var('joined', ''));
			$active			= explode('-', request_var('active', ''));
			$count			= (request_var('count', '') !== '') ? request_var('count', 0) : '';
			$ipdomain		= request_var('ip', '');

			$find_key_match = array('lt' => '<', 'gt' => '>', 'eq' => '=');

			$find_count = array('lt' => $user->lang['LESS_THAN'], 'eq' => $user->lang['EQUAL_TO'], 'gt' => $user->lang['MORE_THAN']);
			$s_find_count = '';
			foreach ($find_count as $key => $value)
			{
				$selected = ($count_select == $key) ? ' selected="selected"' : '';
				$s_find_count .= '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
			}

			$find_time = array('lt' => $user->lang['BEFORE'], 'gt' => $user->lang['AFTER']);
			$s_find_join_time = '';
			foreach ($find_time as $key => $value)
			{
				$selected = ($joined_select == $key) ? ' selected="selected"' : '';
				$s_find_join_time .= '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
			}

			$s_find_active_time = '';
			foreach ($find_time as $key => $value)
			{
				$selected = ($active_select == $key) ? ' selected="selected"' : '';
				$s_find_active_time .= '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
			}

			$sql_where .= ($username) ? ' AND u.clean_username ' . $db->sql_like_expression(str_replace('*', $db->any_char, utf8_clean_string($username))) : '';
			$sql_where .= ($auth->acl_get('a_user') && $email) ? ' AND u.user_email ' . $db->sql_like_expression(str_replace('*', $db->any_char, $email)) . ' ' : '';
			$sql_where .= ($icq) ? ' AND u.user_icq ' . $db->sql_like_expression(str_replace('*', $db->any_char, $icq)) . ' ' : '';
			$sql_where .= ($aim) ? ' AND u.user_aim ' . $db->sql_like_expression(str_replace('*', $db->any_char, $aim)) . ' ' : '';
			$sql_where .= ($yahoo) ? ' AND u.yahoo ' . $db->sql_like_expression(str_replace('*', $db->any_char, $yahoo)) . ' ' : '';
			$sql_where .= ($msn) ? ' AND u.user_msnm ' . $db->sql_like_expression(str_replace('*', $db->any_char, $msn)) . ' ' : '';
			$sql_where .= ($jabber) ? ' AND u.user_jabber ' . $db->sql_like_expression(str_replace('*', $db->any_char, $jabber)) . ' ' : '';
			$sql_where .= (is_numeric($count) && isset($find_key_match[$count_select])) ? ' AND u.user_posts ' . $find_key_match[$count_select] . ' ' . (int) $count . ' ' : '';

			if (isset($find_key_match[$joined_select]) && sizeof($joined) == 3)
			{
				// Before PHP 5.1 an error value -1 can be returned instead of false.
				// Theoretically gmmktime() can also legitimately return -1 as an actual timestamp.
				// But since we do not pass the $second parameter to gmmktime(),
				// an actual unix timestamp -1 cannot be returned in this case.
				// Thus we can check whether it is -1 and treat -1 as an error.
				$joined_time = gmmktime(0, 0, 0, (int) $joined[1], (int) $joined[2], (int) $joined[0]);

				if ($joined_time !== false && $joined_time !== -1)
				{
					$sql_where .= " AND u.regdate " . $find_key_match[$joined_select] . ' ' . $joined_time;
				}
			}

			if (isset($find_key_match[$active_select]) && sizeof($active) == 3 && $auth->acl_get('u_viewonline'))
			{
				$active_time = gmmktime(0, 0, 0, (int) $active[1], (int) $active[2], (int) $active[0]);

				if ($active_time !== false && $active_time !== -1)
				{
					$sql_where .= " AND u.lastlogin " . $find_key_match[$active_select] . ' ' . $active_time;
				}
			}

			$sql_where .= ($search_group_id) ? " AND u.id = ug.user_id AND ug.group_id = $search_group_id AND ug.user_pending = 0 " : '';

			if ($search_group_id)
			{
				$sql_from = ', ' . $db_prefix . '_user_group ug ';
			}

			if ($ipdomain && $auth->acl_getf_global('m_info'))
			{
				if (strspn($ipdomain, 'abcdefghijklmnopqrstuvwxyz'))
				{
					$hostnames = gethostbynamel($ipdomain);

					if ($hostnames !== false)
					{
						$ips = "'" . implode('\', \'', array_map(array($db, 'sql_escape'), preg_replace('#([0-9]{1,3}\.[0-9]{1,3}[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})#', "\\1", gethostbynamel($ipdomain)))) . "'";
					}
					else
					{
						$ips = false;
					}
				}
				else
				{
					$ips = "'" . str_replace('*', '%', $db->sql_escape($ipdomain)) . "'";
				}
				if ($ips === false)
				{
					// A minor fudge but it does the job :D
					$sql_where .= " AND u.id = 0";
				}
				else
				{
					$ip_forums = array_keys($auth->acl_getf('m_info', true));

					$sql = 'SELECT DISTINCT poster_id
						FROM ' . $db_prefix . '_posts
						WHERE poster_ip ' . ((strpos($ips, '%') !== false) ? 'LIKE' : 'IN') . " ($ips)
							AND forum_id IN (0, " . implode(', ', $ip_forums) . ')';
					$result = $db->sql_query($sql);

					if ($row = $db->sql_fetchrow($result))
					{
						$ip_sql = array();
						do
						{
							$ip_sql[] = $row['poster_id'];
						}
						while ($row = $db->sql_fetchrow($result));

						$sql_where .= ' AND ' . $db->sql_in_set('u.id', $ip_sql);
						//die($sql_where);
					}
					else
					{
						// A minor fudge but it does the job :D
						$sql_where .= " AND u.id = 0";
					}
					unset($ip_forums);

					$db->sql_freeresult($result);
				}
			}
		}

		$first_char = request_var('first_char', '');

		if ($first_char == 'other')
		{
			for ($i = 97; $i < 123; $i++)
			{
				$sql_where .= ' AND u.clean_username NOT ' . $db->sql_like_expression(chr($i) . $db->any_char);
			}
		}
		else if ($first_char)
		{
			$sql_where .= ' AND u.clean_username ' . $db->sql_like_expression(substr($first_char, 0, 1) . $db->any_char);
		}

		// Are we looking at a usergroup? If so, fetch additional info
		// and further restrict the user info query
		if ($mode == 'group')
		{
			// We JOIN here to save a query for determining membership for hidden groups. ;)
			$sql = 'SELECT g.*, ug.user_id
				FROM ' . $db_prefix . '_level_settings g
				LEFT JOIN ' . $db_prefix . '_user_group ug ON (ug.user_pending = 0 AND ug.user_id = ' . $user->id . " AND ug.group_id = $group_id)
				WHERE g.group_id = $group_id";
			$result = $db->sql_query($sql);
			$group_row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			if (!$group_row)
			{
				trigger_error('NO_GROUP');
			}

			switch ($group_row['group_type'])
			{
				case GROUP_OPEN:
					$group_row['l_group_type'] = 'OPEN';
				break;

				case GROUP_CLOSED:
					$group_row['l_group_type'] = 'CLOSED';
				break;

				case GROUP_HIDDEN:
					$group_row['l_group_type'] = 'HIDDEN';

					// Check for membership or special permissions
					if (!$auth->acl_gets('a_group', 'a_groupadd', 'a_groupdel') && $group_row['user_id'] != $user->id)
					{
						trigger_error('NO_GROUP');
					}
				break;

				case GROUP_SPECIAL:
					$group_row['l_group_type'] = 'SPECIAL';
				break;

				case GROUP_FREE:
					$group_row['l_group_type'] = 'FREE';
				break;
			}

			// Misusing the avatar function for displaying group avatars...
			#$avatar_img = get_user_avatar($group_row['group_avatar'], $group_row['group_avatar_type'], $group_row['group_avatar_width'], $group_row['group_avatar_height'], 'GROUP_AVATAR');

			// ... same for group rank
			$rank_title = $rank_img = $rank_img_src = '';
			if ($group_row['group_rank'])
			{
				get_user_rank($group_row['group_rank'], false, $rank_title, $rank_img, $rank_img_src);

				if ($rank_img)
				{
					$rank_img .= '<br />';
				}
			}

			$template->assign_vars(array(
				'GROUP_DESC'	=> generate_text_for_display($group_row['group_desc'], $group_row['group_desc_uid'], $group_row['group_desc_bitfield'], $group_row['group_desc_options']),
				'GROUP_NAME'	=> ($group_row['group_type'] == 3) ? $user->lang['G_' . $group_row['group_name']] : $group_row['group_name'],
				'GROUP_COLOR'	=> $group_row['group_colour'],
				'GROUP_TYPE'	=> $user->lang['GROUP_IS_' . $group_row['l_group_type']],
				'GROUP_RANK'	=> $rank_title,
				'GROUP_LIST'	=> true,

				'AVATAR_IMG'	=> $avatar_img,
				'RANK_IMG'		=> $rank_img,
				'RANK_IMG_SRC'	=> $rank_img_src,

				'U_PM'			=> ($auth->acl_get('u_sendpm') && $auth->acl_get('u_masspm_group') && $group_row['group_receive_pm'] && $config['allow_privmsg'] && $config['allow_mass_pm']) ? append_sid("{$phpbb_root_path}ucp.$phpEx", 'i=pm&amp;mode=compose&amp;g=' . $group_id) : '',)
			);

			$sql_select = ', ug.group_leader';
			$sql_from = ', ' . $db_prefix . '_user_group ug ';
			$order_by = 'ug.group_leader DESC, ';

			$sql_where .= " AND ug.user_pending = 0 AND u.id = ug.user_id AND ug.group_id = $group_id";
			$sql_where_data = " AND u.id = ug.user_id AND ug.group_id = $group_id";
		}

		// Sorting and order
		if (!isset($sort_key_sql[$sort_key]))
		{
			$sort_key = $default_key;
		}

		$order_by .= $sort_key_sql[$sort_key] . ' ' . (($sort_dir == 'a') ? 'ASC' : 'DESC');

		// Unfortunately we must do this here for sorting by rank, else the sort order is applied wrongly
		if ($sort_key == 'm')
		{
			$order_by .= ', u.user_posts DESC';
		}

		// Count the users ...
		if ($sql_where)
		{
			$sql = 'SELECT COUNT(u.id) AS total_users
				FROM ' . $db_prefix . "_users u$sql_from
				WHERE u.user_type IN (" . 0 . ', ' . 3 . ")
				$sql_where";
			$result = $db->sql_query($sql);
			$total_users = (int) $db->sql_fetchfield('total_users');
			$db->sql_freeresult($result);
		}
		else
		{
			$sql = 'SELECT COUNT(u.id) AS total_users
				FROM ' . $db_prefix . "_users u
				WHERE u.user_type IN (" . 0 . ', ' . 3 . ")
				$sql_where";
			$result = $db->sql_query($sql);
			$total_users = (int) $db->sql_fetchfield('total_users');
			$db->sql_freeresult($result);
		}

		// Build a relevant pagination_url
		$params = $sort_params = array();

		// We do not use request_var() here directly to save some calls (not all variables are set)
		$check_params = array(
			'g'				=> array('g', 0),
			'sk'			=> array('sk', $default_key),
			'sd'			=> array('sd', 'a'),
			'form'			=> array('form', ''),
			'field'			=> array('field', ''),
			'select_single'	=> array('select_single', $select_single),
			'username'		=> array('username', '', true),
			'email'			=> array('email', ''),
			'icq'			=> array('icq', ''),
			'aim'			=> array('aim', ''),
			'yahoo'			=> array('yahoo', ''),
			'msn'			=> array('msn', ''),
			'jabber'		=> array('jabber', ''),
			'search_group_id'	=> array('search_group_id', 0),
			'joined_select'	=> array('joined_select', 'lt'),
			'active_select'	=> array('active_select', 'lt'),
			'count_select'	=> array('count_select', 'eq'),
			'joined'		=> array('joined', ''),
			'active'		=> array('active', ''),
			'count'			=> (request_var('count', '') !== '') ? array('count', 0) : array('count', ''),
			'ip'			=> array('ip', ''),
			'first_char'	=> array('first_char', ''),
		);

		$u_first_char_params = array();
		foreach ($check_params as $key => $call)
		{
			if (!isset($_REQUEST[$key]))
			{
				continue;
			}

			$param = call_user_func_array('request_var', $call);
			$param = urlencode($key) . '=' . ((is_string($param)) ? urlencode($param) : $param);
			$params[] = $param;

			if ($key != 'first_char')
			{
				$u_first_char_params[] = $param;
			}
			if ($key != 'sk' && $key != 'sd')
			{
				$sort_params[] = $param;
			}
		}

		$u_hide_find_member = append_sid("{$phpbb_root_path}memberslist.$phpEx", "start=$start" . (!empty($params) ? '&amp;' . implode('&amp;', $params) : ''));

		if ($mode)
		{
			$params[] = "mode=$mode";
			$u_first_char_params[] = "mode=$mode";
		}
		$sort_params[] = "mode=$mode";

		$pagination_url = append_sid("{$phpbb_root_path}memberslist.$phpEx", implode('&amp;', $params));
		$sort_url = append_sid("{$phpbb_root_path}memberslist.$phpEx", implode('&amp;', $sort_params));

		unset($search_params, $sort_params);

		$u_first_char_params = implode('&amp;', $u_first_char_params);
		$u_first_char_params .= ($u_first_char_params) ? '&amp;' : '';

		$first_characters = array();
		$first_characters[''] = $user->lang['ALL'];
		for ($i = 97; $i < 123; $i++)
		{
			$first_characters[chr($i)] = chr($i - 32);
		}
		$first_characters['other'] = $user->lang['OTHER'];

		foreach ($first_characters as $char => $desc)
		{
			$template->assign_block_vars('first_char', array(
				'DESC'			=> $desc,
				'VALUE'			=> $char,
				'S_SELECTED'	=> ($first_char == $char) ? true : false,
				'U_SORT'		=> append_sid("{$phpbb_root_path}memberslist.$phpEx", $u_first_char_params . 'first_char=' . $char) . '#memberslist',
			));
		}

		// Some search user specific data
		if ($mode == 'searchuser' && ($config['load_search'] || $auth->acl_get('a_')))
		{
			$group_selected = request_var('search_group_id', 0);
			$s_group_select = '<option value="0"' . ((!$group_selected) ? ' selected="selected"' : '') . '>&nbsp;</option>';
			$group_ids = array();

			/**
			* @todo add this to a separate function (function is responsible for returning the groups the user is able to see based on the users group membership)
			*/

			if ($auth->acl_gets('a_group', 'a_groupadd', 'a_groupdel'))
			{
				$sql = 'SELECT group_id, group_name, group_type
					FROM ' . $db_prefix . '_level_settings';

				if (!$config['coppa_enable'])
				{
					$sql .= " WHERE group_name <> 'REGISTERED_COPPA'";
				}

				$sql .= ' ORDER BY group_name ASC';
			}
			else
			{
				$sql = 'SELECT g.group_id, g.group_name, g.group_type
					FROM ' . $db_prefix . '_level_settings g
					LEFT JOIN ' . $db_prefix . '_user_group ug
						ON (
							g.group_id = ug.group_id
							AND ug.user_id = ' . $user->id . '
							AND ug.user_pending = 0
						)
					WHERE (g.group_type <> ' . 2 . ' OR ug.user_id = ' . $user->id . ')';

				if (!$config['coppa_enable'])
				{
					$sql .= " AND g.group_name <> 'REGISTERED_COPPA'";
				}

				$sql .= ' ORDER BY g.group_name ASC';
			}
			//die($sql);
			$result = $db->sql_query($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				$group_ids[] = $row['group_id'];
				$s_group_select .= '<option value="' . $row['group_id'] . '"' . (($group_selected == $row['group_id']) ? ' selected="selected"' : '') . '>' . (($row['group_type'] == 3) ? $user->lang['G_' . $row['group_name']] : $row['group_name']) . '</option>';
			}
			$db->sql_freeresult($result);

			if ($group_selected !== 0 && !in_array($group_selected, $group_ids))
			{
				trigger_error('NO_GROUP');
			}

			$template->assign_vars(array(
				'USERNAME'	=> $username,
				'EMAIL'		=> $email,
				'ICQ'		=> $icq,
				'AIM'		=> $aim,
				'YAHOO'		=> $yahoo,
				'MSNM'		=> $msn,
				'JABBER'	=> $jabber,
				'JOINED'	=> implode('-', $joined),
				'ACTIVE'	=> implode('-', $active),
				'COUNT'		=> $count,
				'IP'		=> $ipdomain,

				'S_IP_SEARCH_ALLOWED'	=> ($auth->acl_getf_global('m_info')) ? true : false,
				'S_EMAIL_SEARCH_ALLOWED'=> ($auth->acl_get('a_user')) ? true : false,
				'S_IN_SEARCH_POPUP'		=> ($form && $field) ? true : false,
				'S_SEARCH_USER'			=> true,
				'S_FORM_NAME'			=> $form,
				'S_FIELD_NAME'			=> $field,
				'S_SELECT_SINGLE'		=> $select_single,
				'S_COUNT_OPTIONS'		=> $s_find_count,
				'S_SORT_OPTIONS'		=> $s_sort_key,
				'S_JOINED_TIME_OPTIONS'	=> $s_find_join_time,
				'S_ACTIVE_TIME_OPTIONS'	=> $s_find_active_time,
				'S_GROUP_SELECT'		=> $s_group_select,
				'S_USER_SEARCH_ACTION'	=> append_sid("{$phpbb_root_path}memberslist.$phpEx", "mode=searchuser&amp;form=$form&amp;field=$field"))
			);
		}

		// Get us some users :D
		$sql = "SELECT u.id
			FROM " . $db_prefix . "_users u
				$sql_from
			WHERE u.user_type IN (0, 3)
				$sql_where
			ORDER BY $order_by";
			//die($sql . ' LIMIT ' . $start . ',5');
		$result = $db->sql_query($sql . ' LIMIT ' . $start . ',' . $torrent_per_page);

		$user_list = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$user_list[] = (int) $row['id'];
		}
		$db->sql_freeresult($result);
		$leaders_set = false;
		// So, did we get any users?
		if (sizeof($user_list))
		{
			// Session time?! Session time...
			$sql = 'SELECT session_user_id, MAX(session_time) AS session_time
				FROM ' . $db_prefix . '_sessions
				WHERE session_time >= ' . (time() - $config['session_length']) . '
					AND ' . $db->sql_in_set('session_user_id', $user_list) . '
				GROUP BY session_user_id';
			$result = $db->sql_query($sql);

			$session_times = array();
			while ($row = $db->sql_fetchrow($result))
			{
				$session_times[$row['session_user_id']] = $row['session_time'];
			}
			$db->sql_freeresult($result);

			// Do the SQL thang
			if ($mode == 'group')
			{
				$sql = "SELECT u.*
						$sql_select
					FROM " . $db_prefix . "_users u
						$sql_from
					WHERE " . $db->sql_in_set('u.id', $user_list) . "
						$sql_where_data";
			}
			else
			{
				$sql = 'SELECT *
					FROM ' . $db_prefix . '_users
					WHERE ' . $db->sql_in_set('id', $user_list);
			}
			//die($sql);
			$result = $db->sql_query($sql);

			$id_cache = array();
			while ($row = $db->sql_fetchrow($result))
			{
				$row['session_time'] = (!empty($session_times[$row['id']])) ? $session_times[$row['id']] : 0;
				$row['last_visit'] = (!empty($row['session_time'])) ? $row['session_time'] : $row['lastlogin'];

				$id_cache[$row['id']] = $row;
			}
			$db->sql_freeresult($result);

			// Load custom profile fields
			if ($config['load_cpf_memberlist'])
			{
				include_once($phpbb_root_path . 'includes/functions_profile_fields.' . $phpEx);
				$cp = new custom_profile();

				// Grab all profile fields from users in id cache for later use - similar to the poster cache
				$profile_fields_cache = $cp->generate_profile_fields_template('grab', $user_list);
			}

			// If we sort by last active date we need to adjust the id cache due to lastlogin not being the last active date...
			if ($sort_key == 'l')
			{
//				uasort($id_cache, create_function('$first, $second', "return (\$first['last_visit'] == \$second['last_visit']) ? 0 : ((\$first['last_visit'] < \$second['last_visit']) ? $lesser_than : ($lesser_than * -1));"));
				usort($user_list,  '_sort_last_active');
			}

			for ($i = 0, $end = sizeof($user_list); $i < $end; ++$i)
			{
				$user_id = $user_list[$i];
				$row =& $id_cache[$user_id];
				$is_leader = (isset($row['group_leader']) && $row['group_leader']) ? true : false;
				$leaders_set = ($leaders_set || $is_leader);

				$cp_row = array();
				if ($config['load_cpf_memberlist'])
				{
					$cp_row = (isset($profile_fields_cache[$user_id])) ? $cp->generate_profile_fields_template('show', false, $profile_fields_cache[$user_id]) : array();
				}

				$memberrow = array_merge(show_profile($row), array(
					'ROW_NUMBER'		=> $i + ($start + 1),

					'S_CUSTOM_PROFILE'	=> (isset($cp_row['row']) && sizeof($cp_row['row'])) ? true : false,
					'S_GROUP_LEADER'	=> $is_leader,

					'U_VIEW_PROFILE'	=> append_sid("{$phpbb_root_path}memberslist.$phpEx", 'mode=viewprofile&amp;u=' . $user_id))
				);

				if (isset($cp_row['row']) && sizeof($cp_row['row']))
				{
					$memberrow = array_merge($memberrow, $cp_row['row']);
				}

				$template->assign_block_vars('memberrow', $memberrow);

				if (isset($cp_row['blockrow']) && sizeof($cp_row['blockrow']))
				{
					foreach ($cp_row['blockrow'] as $field_data)
					{
						$template->assign_block_vars('memberrow.custom_fields', $field_data);
					}
				}

				unset($id_cache[$user_id]);
			}
		}

		// Generate page
		$template->assign_vars(array(
			'PAGINATION'	=> generate_pagination($pagination_url, $total_users, $torrent_per_page, $start),
			'PAGE_NUMBER'	=> on_page($total_users, $torrent_per_page, $start),
			'TOTAL_USERS'	=> ($total_users == 1) ? $user->lang['LIST_USER'] : sprintf($user->lang['LIST_USERS'], $total_users),

			'PROFILE_IMG'	=> $user->img('icon_user_profile', $user->lang['PROFILE']),
			'PM_IMG'		=> $user->img('icon_contact_pm', $user->lang['SEND_PRIVATE_MESSAGE']),
			'EMAIL_IMG'		=> $user->img('icon_contact_email', $user->lang['EMAIL']),
			'WWW_IMG'		=> $user->img('icon_contact_www', $user->lang['WWW']),
			'ICQ_IMG'		=> $user->img('icon_contact_icq', $user->lang['ICQ']),
			'AIM_IMG'		=> $user->img('icon_contact_aim', $user->lang['AIM']),
			'MSN_IMG'		=> $user->img('icon_contact_msnm', $user->lang['MSNM']),
			'YIM_IMG'		=> $user->img('icon_contact_yahoo', $user->lang['YIM']),
			'JABBER_IMG'	=> $user->img('icon_contact_jabber', $user->lang['JABBER']),
			'SEARCH_IMG'	=> $user->img('icon_user_search', $user->lang['SEARCH']),

			'U_FIND_MEMBER'			=> ($config['load_search'] || $auth->acl_get('a_')) ? append_sid("{$phpbb_root_path}memberslist.$phpEx", 'mode=searchuser' . (($start) ? "&amp;start=$start" : '') . (!empty($params) ? '&amp;' . implode('&amp;', $params) : '')) : '',
			'U_HIDE_FIND_MEMBER'	=> ($mode == 'searchuser') ? $u_hide_find_member : '',
			'U_SORT_USERNAME'		=> $sort_url . '&amp;sk=a&amp;sd=' . (($sort_key == 'a' && $sort_dir == 'a') ? 'd' : 'a'),
			'U_SORT_FROM'			=> $sort_url . '&amp;sk=b&amp;sd=' . (($sort_key == 'b' && $sort_dir == 'a') ? 'd' : 'a'),
			'U_SORT_JOINED'			=> $sort_url . '&amp;sk=c&amp;sd=' . (($sort_key == 'c' && $sort_dir == 'a') ? 'd' : 'a'),
			'U_SORT_POSTS'			=> $sort_url . '&amp;sk=d&amp;sd=' . (($sort_key == 'd' && $sort_dir == 'a') ? 'd' : 'a'),
			'U_SORT_EMAIL'			=> $sort_url . '&amp;sk=e&amp;sd=' . (($sort_key == 'e' && $sort_dir == 'a') ? 'd' : 'a'),
			'U_SORT_WEBSITE'		=> $sort_url . '&amp;sk=f&amp;sd=' . (($sort_key == 'f' && $sort_dir == 'a') ? 'd' : 'a'),
			'U_SORT_LOCATION'		=> $sort_url . '&amp;sk=b&amp;sd=' . (($sort_key == 'b' && $sort_dir == 'a') ? 'd' : 'a'),
			'U_SORT_ICQ'			=> $sort_url . '&amp;sk=g&amp;sd=' . (($sort_key == 'g' && $sort_dir == 'a') ? 'd' : 'a'),
			'U_SORT_AIM'			=> $sort_url . '&amp;sk=h&amp;sd=' . (($sort_key == 'h' && $sort_dir == 'a') ? 'd' : 'a'),
			'U_SORT_MSN'			=> $sort_url . '&amp;sk=i&amp;sd=' . (($sort_key == 'i' && $sort_dir == 'a') ? 'd' : 'a'),
			'U_SORT_YIM'			=> $sort_url . '&amp;sk=j&amp;sd=' . (($sort_key == 'j' && $sort_dir == 'a') ? 'd' : 'a'),
			'U_SORT_ACTIVE'			=> ($auth->acl_get('u_viewonline')) ? $sort_url . '&amp;sk=l&amp;sd=' . (($sort_key == 'l' && $sort_dir == 'a') ? 'd' : 'a') : '',
			'U_SORT_RANK'			=> $sort_url . '&amp;sk=m&amp;sd=' . (($sort_key == 'm' && $sort_dir == 'a') ? 'd' : 'a'),
			'U_LIST_CHAR'			=> $sort_url . '&amp;sk=a&amp;sd=' . (($sort_key == 'l' && $sort_dir == 'a') ? 'd' : 'a'),

			'S_SHOW_GROUP'		=> ($mode == 'group') ? true : false,
			'S_VIEWONLINE'		=> $auth->acl_get('u_viewonline'),
			'S_LEADERS_SET'		=> $leaders_set,
			'S_MODE_SELECT'		=> $s_sort_key,
			'S_ORDER_SELECT'	=> $s_sort_dir,
			'S_MODE_ACTION'		=> $pagination_url)
		);
}

// Output the page
//page_header($page_title, false);

//$template->set_filenames(array(
	//'body' => $template_html)
//);
//make_jumpbox(append_sid("{$phpbb_root_path}viewforum.$phpEx"));

//page_footer();
				echo $template->fetch($template_html);
				close_out();

/**
* Prepare profile data
*/
function show_profile($data, $user_notes_enabled = false, $warn_user_enabled = false)
{
	global $config, $auth, $template, $user, $phpEx, $phpbb_root_path;

	$username = $data['username'];
	$user_id = $data['id'];

	$rank_title = $rank_img = $rank_img_src = '';
	get_user_rank($data['user_rank'], (($user_id == 0) ? false : $data['user_posts']), $rank_title, $rank_img, $rank_img_src);

	if ((!empty($data['user_allow_viewemail']) && $auth->acl_get('u_sendemail')) || $auth->acl_get('a_user'))
	{
		$email = ($config['board_email_form'] && $config['email_enable']) ? append_sid("{$phpbb_root_path}memberslist.$phpEx", 'mode=email&amp;u=' . $user_id) : (($config['board_hide_emails'] && !$auth->acl_get('a_user')) ? '' : 'mailto:' . $data['email']);
	}
	else
	{
		$email = false;
	}

	if ($config['load_onlinetrack'])
	{
		$update_time = $config['load_online_time'] * 60;
		$online = (time() - $update_time < $data['session_time'] && ((isset($data['session_viewonline']) && $data['session_viewonline']) || $auth->acl_get('u_viewonline'))) ? true : false;
	}
	else
	{
		$online = false;
	}

	if ($data['user_allow_viewonline'] || $auth->acl_get('u_viewonline'))
	{
		$last_visit = (!empty($data['session_time'])) ? $data['session_time'] : $data['lastlogin'];
	}
	else
	{
		$last_visit = '';
	}

	$age = '';

	if ($config['allow_birthdays'] && $data['user_birthday'])
	{
		list($bday_day, $bday_month, $bday_year) = array_map('intval', explode('-', $data['user_birthday']));

		if ($bday_year)
		{
			$now = phpbb_gmgetdate(time() + $user->timezone + $user->dst);

			$diff = $now['mon'] - $bday_month;
			if ($diff == 0)
			{
				$diff = ($now['mday'] - $bday_day < 0) ? 1 : 0;
			}
			else
			{
				$diff = ($diff < 0) ? 1 : 0;
			}

			$age = max(0, (int) ($now['year'] - $bday_year - $diff));
		}
	}

	// Dump it out to the template
	return array(
		'AGE'			=> $age,
		'RANK_TITLE'	=> $rank_title,
		'JOINED'		=> format_date2(sql_timestamp_to_unix_timestamp($data['regdate'])),
		'VISITED'		=> (empty($last_visit)) ? ' - ' : format_date2(sql_timestamp_to_unix_timestamp($last_visit)),
		'POSTS'			=> ($data['user_posts']) ? $data['user_posts'] : 0,
		'WARNINGS'		=> isset($data['user_warnings']) ? $data['user_warnings'] : 0,

		'USERNAME_FULL'		=> get_username_string('full', $user_id, $username, $data['user_colour']),
		'USERNAME'			=> get_username_string('username', $user_id, $username, $data['user_colour']),
		'USER_COLOR'		=> get_username_string('colour', $user_id, $username, $data['user_colour']),
		'U_VIEW_PROFILE'	=> get_username_string('profile', $user_id, $username, $data['user_colour']),

		'A_USERNAME'		=> addslashes(get_username_string('username', $user_id, $username, $data['user_colour'])),

		//'AVATAR_IMG'		=> get_user_avatar($data['user_avatar'], $data['user_avatar_type'], $data['user_avatar_width'], $data['user_avatar_height']),
		'ONLINE_IMG'		=> (!$config['load_onlinetrack']) ? '' : (($online) ? $user->img('icon_user_online', 'ONLINE') : $user->img('icon_user_offline', 'OFFLINE')),
		'S_ONLINE'			=> ($config['load_onlinetrack'] && $online) ? true : false,
		'RANK_IMG'			=> $rank_img,
		'RANK_IMG_SRC'		=> $rank_img_src,
		'ICQ_STATUS_IMG'	=> (!empty($data['icq'])) ? '<img src="http://web.icq.com/whitepages/online?icq=' . $data['icq'] . '&amp;img=5" width="18" height="18" />' : '',
		'S_JABBER_ENABLED'	=> ($config['jabber']) ? true : false,

		'S_WARNINGS'	=> ($auth->acl_getf_global('m_') || $auth->acl_get('m_warn')) ? true : false,

		'U_SEARCH_USER'	=> ($auth->acl_get('u_search')) ? append_sid("{$phpbb_root_path}search.$phpEx", "author_id=$user_id&amp;sr=posts") : '',
		'U_NOTES'		=> ($user_notes_enabled && $auth->acl_getf_global('m_')) ? append_sid("{$phpbb_root_path}mcp.$phpEx", 'i=notes&amp;mode=user_notes&amp;u=' . $user_id, true, $user->session_id) : '',
		'U_WARN'		=> ($warn_user_enabled && $auth->acl_get('m_warn')) ? append_sid("{$phpbb_root_path}mcp.$phpEx", 'i=warn&amp;mode=warn_user&amp;u=' . $user_id, true, $user->session_id) : '',
		'U_PM'			=> ($config['allow_privmsg'] && $auth->acl_get('u_sendpm') && ($data['user_allow_pm'] || $auth->acl_gets('a_', 'm_') || $auth->acl_getf_global('m_'))) ? append_sid("{$siteurl}pm.$phpEx", 'op=send&amp;to=' . $user_id) : '',
		'U_EMAIL'		=> $email,
		'U_WWW'			=> (!empty($data['user_website'])) ? $data['user_website'] : '',
		'U_SHORT_WWW'			=> (!empty($data['user_website'])) ? ((strlen($data['user_website']) > 55) ? substr($data['user_website'], 0, 39) . ' ... ' . substr($data['user_website'], -10) : $data['user_website']) : false,
		'U_ICQ'			=> ($data['icq']) ? 'http://www.icq.com/people/' . urlencode($data['icq']) . '/' : '',
		'U_AIM'			=> ($data['aim'] && $auth->acl_get('u_sendim')) ? append_sid("{$phpbb_root_path}memberslist.$phpEx", 'mode=contact&amp;action=aim&amp;u=' . $user_id) : '',
		'U_YIM'			=> ($data['yahoo']) ? 'http://edit.yahoo.com/config/send_webmesg?.target=' . urlencode($data['yahoo']) . '&amp;.src=pg' : '',
		'U_MSN'			=> ($data['msn'] && $auth->acl_get('u_sendim')) ? append_sid("{$phpbb_root_path}memberslist.$phpEx", 'mode=contact&amp;action=msnm&amp;u=' . $user_id) : '',
		'U_JABBER'		=> ($data['jabber'] && $auth->acl_get('u_sendim')) ? append_sid("{$phpbb_root_path}memberslist.$phpEx", 'mode=contact&amp;action=jabber&amp;u=' . $user_id) : '',
		'LOCATION'		=> ($data['user_from']) ? $data['user_from'] : false,

		'USER_ICQ'			=> $data['user_icq'],
		'USER_AIM'			=> $data['user_aim'],
		'USER_YIM'			=> $data['yahoo'],
		'USER_MSN'			=> $data['user_msnm'],
		'USER_JABBER'		=> $data['user_jabber'],
		'USER_JABBER_IMG'	=> ($data['user_jabber']) ? $user->img('icon_contact_jabber', $data['user_jabber']) : '',

		'L_VIEWING_PROFILE'	=> sprintf($user->lang['VIEWING_PROFILE'], $username),
	);
}

function _sort_last_active($first, $second)
{
	global $id_cache, $sort_dir;

	$lesser_than = ($sort_dir === 'd') ? -1 : 1;

	if (isset($id_cache[$first]['group_leader']) && $id_cache[$first]['group_leader'] && (!isset($id_cache[$second]['group_leader']) || !$id_cache[$second]['group_leader']))
	{
		return -1;
	}
	else if (isset($id_cache[$second]['group_leader']) && (!isset($id_cache[$first]['group_leader']) || !$id_cache[$first]['group_leader']) && $id_cache[$second]['group_leader'])
	{
		return 1;
	}
	else
	{
		return $lesser_than * (int) ($id_cache[$first]['last_visit'] - $id_cache[$second]['last_visit']);
	}
}

	function get_user_rank($user_rank, $user_posts, &$rank_title, &$rank_img, &$rank_img_src)
	{
		global $ranks, $config, $phpbb_root_path;
	
		if (empty($ranks))
		{
			global $pmbt_cache;
			$ranks = $pmbt_cache->obtain_ranks();
		}
	
		if (!empty($user_rank))
		{
			$rank_title = (isset($ranks['special'][$user_rank]['rank_title'])) ? $ranks['special'][$user_rank]['rank_title'] : '';
			$rank_img = (!empty($ranks['special'][$user_rank]['rank_image'])) ? '<img src="' . $phpbb_root_path . $config['ranks_path'] . '/' . $ranks['special'][$user_rank]['rank_image'] . '" alt="' . $ranks['special'][$user_rank]['rank_title'] . '" title="' . $ranks['special'][$user_rank]['rank_title'] . '" />' : '';
			$rank_img_src = (!empty($ranks['special'][$user_rank]['rank_image'])) ? $phpbb_root_path . $config['ranks_path'] . '/' . $ranks['special'][$user_rank]['rank_image'] : '';
		}
		else if ($user_posts !== false)
		{
			if (!empty($ranks['normal']))
			{
				foreach ($ranks['normal'] as $rank)
				{
					if ($user_posts >= $rank['rank_min'])
					{
						$rank_title = $rank['rank_title'];
						$rank_img = (!empty($rank['rank_image'])) ? '<img src="' . $phpbb_root_path . $config['ranks_path'] . '/' . $rank['rank_image'] . '" alt="' . $rank['rank_title'] . '" title="' . $rank['rank_title'] . '" />' : '';
						$rank_img_src = (!empty($rank['rank_image'])) ? $phpbb_root_path . $config['ranks_path'] . '/' . $rank['rank_image'] : '';
						break;
					}
				}
			}
		}
	}

	function display_user_activity(&$userdata)
	{
		global $auth, $template, $db, $user, $db_prefix;
		global $phpbb_root_path, $phpEx;
	
		// Do not display user activity for users having more than 5000 posts...
		if ($userdata['user_posts'] > 5000)
		{
			return;
		}
	
		$forum_ary = array();
	
		// Do not include those forums the user is not having read access to...
		$forum_read_ary = $auth->acl_getf('!f_read');
	
		foreach ($forum_read_ary as $forum_id => $not_allowed)
		{
			if ($not_allowed['f_read'])
			{
				$forum_ary[] = (int) $forum_id;
			}
		}
	
		$forum_ary = array_unique($forum_ary);
		$forum_sql = (sizeof($forum_ary)) ? 'AND ' . $db->sql_in_set('forum_id', $forum_ary, true) : '';
	
		$fid_m_approve = $auth->acl_getf('m_approve', true);
		$sql_m_approve = (!empty($fid_m_approve)) ? 'OR ' . $db->sql_in_set('forum_id', array_keys($fid_m_approve)) : '';
	
		// Obtain active forum
		$sql = 'SELECT forum_id, COUNT(post_id) AS num_posts
			FROM ' . $db_prefix . '_posts
			WHERE poster_id = ' . $userdata['id'] . "
				AND post_postcount = 1
				AND (post_approved = 1
					$sql_m_approve)
				$forum_sql
			GROUP BY forum_id
			ORDER BY num_posts DESC";
		$result = $db->sql_query($sql . ' LIMIT 1');
		$active_f_row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
	
		if (!empty($active_f_row))
		{
			$sql = 'SELECT forum_name
				FROM ' . $db_prefix . '_forums
				WHERE forum_id = ' . $active_f_row['forum_id'];
			$result = $db->sql_query($sql, 3600);
			$active_f_row['forum_name'] = (string) $db->sql_fetchfield('forum_name');
			$db->sql_freeresult($result);
		}
	
		// Obtain active topic
		// We need to exclude passworded forums here so we do not leak the topic title
		//$forum_ary_topic = array_unique(array_merge($forum_ary, $user->get_passworded_forums()));
		$forum_sql_topic = (!empty($forum_ary_topic)) ? 'AND ' . $db->sql_in_set('forum_id', $forum_ary_topic, true) : '';
	
		$sql = 'SELECT topic_id, COUNT(post_id) AS num_posts
			FROM ' . $db_prefix . '_posts
			WHERE poster_id = ' . $userdata['id'] . "
				AND post_postcount = 1
				AND (post_approved = 1
					$sql_m_approve)
				$forum_sql_topic
			GROUP BY topic_id
			ORDER BY num_posts DESC";//die($sql);
		$result = $db->sql_query($sql . ' LIMIT 1');
		$active_t_row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
	
		if (!empty($active_t_row))
		{
			$sql = 'SELECT topic_title
				FROM ' . $db_prefix . '_topics
				WHERE topic_id = ' . $active_t_row['topic_id'];
			$result = $db->sql_query($sql);
			$active_t_row['topic_title'] = (string) $db->sql_fetchfield('topic_title');
			$db->sql_freeresult($result);
		}
	
		$userdata['active_t_row'] = $active_t_row;
		$userdata['active_f_row'] = $active_f_row;
	
		$active_f_name = $active_f_id = $active_f_count = $active_f_pct = '';
		if (!empty($active_f_row['num_posts']))
		{
			$active_f_name = $active_f_row['forum_name'];
			$active_f_id = $active_f_row['forum_id'];
			$active_f_count = $active_f_row['num_posts'];
			$active_f_pct = ($userdata['user_posts']) ? ($active_f_count / $userdata['user_posts']) * 100 : 0;
		}
	
		$active_t_name = $active_t_id = $active_t_count = $active_t_pct = '';
		if (!empty($active_t_row['num_posts']))
		{
			$active_t_name = $active_t_row['topic_title'];
			$active_t_id = $active_t_row['topic_id'];
			$active_t_count = $active_t_row['num_posts'];
			$active_t_pct = ($userdata['user_posts']) ? ($active_t_count / $userdata['user_posts']) * 100 : 0;
		}
	
		$l_active_pct = ($userdata['id'] != 0 && $userdata['id'] == $user->id) ? $user->lang['POST_PCT_ACTIVE_OWN'] : $user->lang['POST_PCT_ACTIVE'];
	
		$template->assign_vars(array(
			'ACTIVE_FORUM'			=> $active_f_name,
			'ACTIVE_FORUM_POSTS'	=> ($active_f_count == 1) ? sprintf($user->lang['USER_POST'], 1) : sprintf($user->lang['USER_POSTS'], $active_f_count),
			'ACTIVE_FORUM_PCT'		=> sprintf($l_active_pct, $active_f_pct),
			'ACTIVE_TOPIC'			=> censor_text($active_t_name),
			'ACTIVE_TOPIC_POSTS'	=> ($active_t_count == 1) ? sprintf($user->lang['USER_POST'], 1) : sprintf($user->lang['USER_POSTS'], $active_t_count),
			'ACTIVE_TOPIC_PCT'		=> sprintf($l_active_pct, $active_t_pct),
			'U_ACTIVE_FORUM'		=> append_sid("{$phpbb_root_path}viewforum.$phpEx", 'f=' . $active_f_id),
			'U_ACTIVE_TOPIC'		=> append_sid("{$phpbb_root_path}viewtopic.$phpEx", 't=' . $active_t_id),
			'S_SHOW_ACTIVITY'		=> true)
		);
	}
?>