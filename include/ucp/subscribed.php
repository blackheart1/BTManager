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
** File subscribed.php 2018-02-18 14:32:00 joeroberts
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
$user->set_lang('forum',$user->ulanguage);
        if (!isset($page) OR !is_numeric($page) OR $page < 1) $page = 1;
	$hidden = build_hidden_fields(array(
	"op"		=> "editprofile",
	"take_edit"		=> "1",
	"action" 		=> 'overview',
	"mode"			=> 'subscribed'
	));
				$template->assign_vars(array(
				'topicrow' => false,
				'L_TITLE'     => 'Watched forums',
				'S_TORRENT_NOTIFY'		=> true,
				'S_FORUM_NOTIFY'		=> true,
				'S_TOPIC_NOTIFY'		=> true,
				'S_HIDDEN_FIELDS'		=> $hidden,
			'LAST_POST_IMG'			=> $user->img('icon_topic_latest', 'VIEW_LATEST_POST'),
			'NEWEST_POST_IMG'		=> $user->img('icon_topic_newest', 'VIEW_NEWEST_POST'),
));
		$starttop = request_var('starttop', 0);

	$sql = "SELECT `torrent`, `user`, `status`FROM `".$db_prefix."_comments_notify` WHERE `user` = '".$uid."' ;"; 
	$res = $db->sql_query($sql) or btsqlerror($sql);
	if ($db->sql_numrows($res) >= 1) {
				$template->assign_vars(array(
				'S_TORRENT_NOTIFY'		=> true,
				));
		$userrow = array();
	while($dcont = $db->sql_fetchrow($res)){
		$sql = "SELECT * FROM `" . $db_prefix . "_comments` WHERE `torrent` = " . $dcont['torrent'] . " ORDER BY `added` DESC LIMIT 1";
		$rescom = $db->sql_query($sql);
		$rowcom = $db->sql_fetchrow($rescom);
		if ($rowcom['user'] == 0)
		{
				if(!isset($userrow[$rowcom['user']]))$userrow[$rowcom['user']] == array(
				'joined'		=> '',
				'posts'			=> '',
				'from'			=> 'unknown.gif',
				'from_key'		=>	'N/A',
				'upl'			=> '0',
				'dnl'			=> '0',
				'ratio'			=> '--',

				'sig'					=> '',
				'sig_bbcode_uid'		=> '',
				'sig_bbcode_bitfield'	=> '',

				'online'			=> false,
				'avatar'			=> '',
				'rank_title'		=> '',
				'rank_image'		=> '',
				'rank_image_src'	=> '',
				'sig'				=> '',
				'profile'			=> '',
				'pm'				=> '',

				'email'				=> '',
				'www'				=> '',
				'icq_status_img'	=> '',
				'icq'				=> '',
				'aim'				=> '',
				'msn'				=> '',
				'yim'				=> '',
				'jabber'			=> '',
				'search'			=> '',
				'age'				=> '',

				'username'			=> $user->lang['GUEST'],
				'user_colour'		=> getusercolor('6'),

				'warnings'			=> 0,
				'allow_pm'			=> 0,
			);		
		}
		else
		{
			if(!isset($userrow[$rowcom['user']]))$userrow[$rowcom['user']] = build_user_array($rowcom['user']);
		}
		//die(print_r($userrow));
				$torrent = '';
						$sql_t = "SELECT A.id as id, A.exeem, A.seeders, A.leechers, A.tot_peer, 
						A.speed, A.info_hash, A.filename, A.banned, A.nuked, A.nukereason, 
						A.password, A.imdb, UNIX_TIMESTAMP() - UNIX_TIMESTAMP(A.last_action) AS lastseed, 
						A.numratings, A.name, 
						IF(A.numratings < '".$minvotes."', NULL, ROUND(A.ratingsum / A.numratings, 1)) AS rating, 
						A.save_as, A.descr, A.visible, A.size, A.plen, A.added, A.views, A.downloaded, A.completed, 
						A.type, A.private, A.min_ratio, A.numfiles, A.owner, A.ownertype, A.complaints, A.evidence, 
						A.tracker, A.tracker_list, A.dht as dht, A.md5sum as md5sum, A.uploader_host as user_host, 
						B.name AS cat_name, B.image AS cat_pic, IF(C.name IS NULL, C.username, C.name) as ownername, 
						A.tracker_update, COUNT(S.status) as auths FROM ".$db_prefix."_torrents A LEFT JOIN ".$db_prefix."_categories B ON A.category = B.id LEFT JOIN ".$db_prefix."_users C ON A.owner = C.id LEFT JOIN ".$db_prefix."_privacy_file S ON S.torrent = A.id AND S.status = 'pending' WHERE A.id = '".$dcont['torrent']."' LIMIT 1;";
						$res_t = $db->sql_query($sql_t) or btsqlerror($sql_t);
						$torrent = $db->sql_fetchrow($res_t);
						$db->sql_freeresult($res_t);
								if (can_download($user,$torrent)) {
						        $can_access = true;
								} else {
						        $can_access = false;
								}
                        if (isset($torrent["cat_pic"]) AND $torrent["cat_pic"] != "" AND is_readable("themes/".$theme."/pics/cat_pics/".$torrent["cat_pic"]))
						{
                                $catimg = "themes/".$theme."/pics/cat_pics/".$torrent["cat_pic"];
								$cat_pics = "<img border=\"0\" src=\"themes/" . $theme . "/pics/cat_pics/". $torrent["cat_pic"] . "\" alt=\"" . $torrent["cat_name"] . "\" >";
						}
                        elseif (isset($torrent["cat_pic"]) AND $torrent["cat_pic"] != "" AND is_readable("cat_pics/".$torrent["cat_pic"]))
						{
                                $catimg = "cat_pics/".$torrent["cat_pic"];
                                $cat_pics = "<img border=\"0\" src=\"cat_pics/" . $torrent["cat_pic"] . "\" alt=\"" . $torrent["cat_name"] . "\" >";
						}
                        else
                                $cat_pics = $torrent["cat_name"];
								//die($torrent['lastseed']);
				$template->assign_block_vars('torrentrow',array(
				'TORRENT_ID'     		=> $dcont['torrent'],
				'STATUS'		 		=> $dcont['status'],
				'CAT_IMG'		 		=> $cat_pics,
				'CAT_PIC'		 		=> $catimg,
				'TORRENT_NAME'	 		=> $torrent['name'],
				'U_TORFORUM'	 		=> $siteurl.'/details.php?id='.$dcont['torrent'].'&hit',
				'DATE_ADDED'	 		=> $user->format_date(sql_timestamp_to_unix_timestamp($torrent['added'])),
				'LAST_SEEDER'    		=> ($torrent['tracker'] != "")? '' : $user->format_date(sql_timestamp_to_unix_timestamp($rowcom['added'])),
				'CAN_DOWNLOAD'	 		=> can_download($user, $torrent),
				'CAN_EDIT'	 	 		=> ($torrent["owner"] == $user->id AND checkaccess("u_edit_own_torrents"))? true : checkaccess("m_can_edit_others_torrents")? true : false,
				'CAN_DELETE'	 		=> ($torrent["owner"] == $user->id AND checkaccess("u_edit_own_torrents"))? true : checkaccess("m_can_edit_others_torrents")? true : false,
				'CAN_BAN'		 		=> checkaccess("m_bann_torrents"),
				'TRACKER'		 		=> ($torrent["tracker"]!= "")? $torrent["tracker"] : false,
				'LAST_POST_AUTHOR'		=> get_username_string('full', $rowcom['user'], username_is($rowcom['user']),  '#' . $userrow[$rowcom['user']]['color']),
				'LAST_POST_ADDED'	 	=> $user->format_date(sql_timestamp_to_unix_timestamp($rowcom['added'])),
				'U_LAST_POST'			=> append_sid("details.php","id=" . $dcont['torrent'] . "&hit=1&comm=startcomments"),
				));
	}
	}
					if (empty($forbidden_forums))
					{
						$forbidden_forums = $auth->acl_getf('!f_read', true);
						$forbidden_forums = array_unique(array_keys($forbidden_forums));
					}
			$sql_array = array(
				'SELECT'	=> 't.*, f.forum_name, b.topic_id as b_topic_id',

				'FROM'		=> array(
					$db_prefix . '_bookmarks'		=> 'b',
				),

				'WHERE'		=> 'b.user_id = ' . $user->id . '
					AND ' . $db->sql_in_set('f.forum_id', $forbidden_forums, true, true),

				'ORDER_BY'	=> 't.topic_last_post_time DESC'
			);

			$sql_array['LEFT_JOIN'] = array();
			$sql_array['LEFT_JOIN'][] = array('FROM' => array($db_prefix . '_topics' => 't'), 'ON' => 'b.topic_id = t.topic_id');

		$sql_array['LEFT_JOIN'][] = array('FROM' => array($db_prefix . '_forums' => 'f'), 'ON' => 't.forum_id = f.forum_id');

		if ($config['load_db_lastread'])
		{
			$sql_array['LEFT_JOIN'][] = array('FROM' => array($db_prefix . '_forums_track' => 'ft'), 'ON' => 'ft.forum_id = t.forum_id AND ft.user_id = ' . $user->id);
			$sql_array['LEFT_JOIN'][] = array('FROM' => array($db_prefix . '_topics_track' => 'tt'), 'ON' => 'tt.topic_id = t.topic_id AND tt.user_id = ' . $user->id);
			$sql_array['SELECT'] .= ', tt.mark_time, ft.mark_time AS forum_mark_time';
		}

		if ($config['load_db_track'])
		{
			$sql_array['LEFT_JOIN'][] = array('FROM' => array($db_prefix . '_topics_posted' => 'tp'), 'ON' => 'tp.topic_id = t.topic_id AND tp.user_id = ' . $user->id);
			$sql_array['SELECT'] .= ', tp.topic_posted';
		}

		$sql = $db->sql_build_query('SELECT', $sql_array);
		$result = $db->sql_query($sql . ' LIMIT ' . $starttop . ', ' .$config['topics_per_page']);
		// Get folder img, topic status/type related information
		include_once('include/functions_forum.php');
		$topic_list = $topic_forum_list = $global_announce_list = $rowset = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$topic_id = (isset($row['b_topic_id'])) ? $row['b_topic_id'] : $row['topic_id'];

			$topic_list[] = $topic_id;
			$rowset[$topic_id] = $row;

			$topic_forum_list[$row['forum_id']]['forum_mark_time'] = ($config['load_db_lastread']) ? $row['forum_mark_time'] : 0;
			$topic_forum_list[$row['forum_id']]['topics'][] = $topic_id;

			if ($row['topic_type'] == 3)
			{
				$global_announce_list[] = $topic_id;
			}
		}
		$db->sql_freeresult($result);

		$topic_tracking_info = array();
		if ($config['load_db_lastread'])
		{
			foreach ($topic_forum_list as $f_id => $topic_row)
			{
				$topic_tracking_info += get_topic_tracking($f_id, $topic_row['topics'], $rowset, array($f_id => $topic_row['forum_mark_time']), ($f_id == 0) ? $global_announce_list : false);
			}
		}
		else
		{
			foreach ($topic_forum_list as $f_id => $topic_row)
			{
				$topic_tracking_info += get_complete_topic_tracking($f_id, $topic_row['topics'], $global_announce_list);
			}
		}

		foreach ($topic_list as $topic_id)
		{
			$row = &$rowset[$topic_id];

			$forum_id = $row['forum_id'];
			$topic_id = (isset($row['b_topic_id'])) ? $row['b_topic_id'] : $row['topic_id'];

			$unread_topic = (isset($topic_tracking_info[$topic_id]) && $row['topic_last_post_time'] > $topic_tracking_info[$topic_id]) ? true : false;

			// Replies
			$replies = ($auth->acl_get('m_approve', $forum_id)) ? $row['topic_replies_real'] : $row['topic_replies'];

			if ($row['topic_status'] == 2 && !empty($row['topic_moved_id']))
			{
				$topic_id = $row['topic_moved_id'];
			}

			// Get folder img, topic status/type related information
			$folder_img = $folder_alt = $topic_type = '';
			topic_status($row, $replies, $unread_topic, $folder_img, $folder_alt, $topic_type);

			$view_topic_url_params = "f=$forum_id&amp;t=$topic_id";
			$view_topic_url = append_sid("{$phpbb_root_path}forum.$phpEx", 'action=viewtopic&amp;' . $view_topic_url_params);

			// Send vars to template
			$template->assign_block_vars('topicrow', array(
				'FORUM_ID'					=> $forum_id,
				'TOPIC_ID'					=> $topic_id,
				'FIRST_POST_TIME'			=> $user->format_date($row['topic_time']),
				'LAST_POST_SUBJECT'			=> $row['topic_last_post_subject'],
				'LAST_POST_TIME'			=> $user->format_date($row['topic_last_post_time']),
				'LAST_VIEW_TIME'			=> $user->format_date($row['topic_last_view_time']),

				'TOPIC_AUTHOR'				=> get_username_string('username', $row['topic_poster'], $row['topic_first_poster_name'], '#' . $row['topic_first_poster_colour']),
				'TOPIC_AUTHOR_COLOUR'		=> get_username_string('colour', $row['topic_poster'], $row['topic_first_poster_name'],  '#' . $row['topic_first_poster_colour']),
				'TOPIC_AUTHOR_FULL'			=> get_username_string('full', $row['topic_poster'], $row['topic_first_poster_name'],  '#' . $row['topic_first_poster_colour']),
				'U_TOPIC_AUTHOR'			=> get_username_string('profile', $row['topic_poster'], $row['topic_first_poster_name'],  '#' . $row['topic_first_poster_colour']),

				'LAST_POST_AUTHOR'			=> get_username_string('username', $row['topic_last_poster_id'], $row['topic_last_poster_name'],  '#' . $row['topic_last_poster_colour']),
				'LAST_POST_AUTHOR_COLOUR'	=> get_username_string('colour', $row['topic_last_poster_id'], $row['topic_last_poster_name'],  '#' . $row['topic_last_poster_colour']),
				'LAST_POST_AUTHOR_FULL'		=> get_username_string('full', $row['topic_last_poster_id'], $row['topic_last_poster_name'],  '#' . $row['topic_last_poster_colour']),
				'U_LAST_POST_AUTHOR'		=> get_username_string('profile', $row['topic_last_poster_id'], $row['topic_last_poster_name'],  '#' . $row['topic_last_poster_colour']),
				'S_TOPIC_REPORTED'			=> (!empty($row['topic_reported']) && empty($row['topic_moved_id']) && $auth->acl_get('m_report', $row['forum_id'])) ? true : false,

				'S_DELETED_TOPIC'	=> (!$row['topic_id']) ? true : false,
				'S_GLOBAL_TOPIC'	=> (!$forum_id) ? true : false,

				'PAGINATION'		=> topic_generate_pagination($replies, append_sid("{$phpbb_root_path}forum.$phpEx", 'action=viewtopic&amp;f=' . (($row['forum_id']) ? $row['forum_id'] : $forum_id) . "&amp;t=$topic_id")),
				'REPLIES'			=> $replies,
				'VIEWS'				=> $row['topic_views'],
				'TOPIC_TITLE'		=> censor_text($row['topic_title']),
				'TOPIC_TYPE'		=> $topic_type,
				'FORUM_NAME'		=> $row['forum_name'],

				'TOPIC_FOLDER_IMG'		=> $user->img($folder_img, $folder_alt),
				'TOPIC_FOLDER_IMG_SRC'	=> $user->img($folder_img, $folder_alt, false, '', 'src'),
				'TOPIC_FOLDER_IMG_ALT'	=> $user->lang[$folder_alt],
				'TOPIC_ICON_IMG'		=> (!empty($icons[$row['icon_id']])) ? $icons[$row['icon_id']]['img'] : '',
				'TOPIC_ICON_IMG_WIDTH'	=> (!empty($icons[$row['icon_id']])) ? $icons[$row['icon_id']]['width'] : '',
				'TOPIC_ICON_IMG_HEIGHT'	=> (!empty($icons[$row['icon_id']])) ? $icons[$row['icon_id']]['height'] : '',
				'ATTACH_ICON_IMG'		=> ($auth->acl_get('u_download') && $auth->acl_get('f_download', $forum_id) && $row['topic_attachment']) ? $user->img('icon_topic_attach', $user->lang['TOTAL_ATTACHMENTS']) : '',

				'S_TOPIC_TYPE'			=> $row['topic_type'],
				'S_USER_POSTED'			=> (!empty($row['topic_posted'])) ? true : false,
				'S_UNREAD_TOPIC'		=> $unread_topic,

				'U_NEWEST_POST'			=> append_sid("{$phpbb_root_path}forum.$phpEx", 'action=viewtopic&amp;' . $view_topic_url_params . '&amp;view=unread') . '#unread',
				'U_LAST_POST'			=> append_sid("{$phpbb_root_path}forum.$phpEx", 'action=viewtopic&amp;' . $view_topic_url_params . '&amp;p=' . $row['topic_last_post_id']) . '#p' . $row['topic_last_post_id'],
				'U_VIEW_TOPIC'			=> $view_topic_url,
				'U_VIEW_FORUM'			=> append_sid("{$phpbb_root_path}forum.$phpEx?action=viewforum", 'f=' . $forum_id),
			));
		}
		if ($posts)
		{
			$template->assign_vars(array(
				'PAGINATION'	=> generate_pagination($siteurl.'/user.php?op=editprofile',$posts,$torrent_per_page,0),
				'PAGE_NUMBER'	=> $page,
				'TOTAL_TOPICS'	=> ($posts == 1) ? $user->lang['VIEW_FORUM_TOPIC'] : sprintf($user->lang['VIEW_FORUM_TOPICS'], $posts),
			));
		}
// Buildin watched forums
						$forbidden_forums = $auth->acl_getf('!f_read', true);
						$forbidden_forums = array_unique(array_keys($forbidden_forums));
			$sql_array = array(
				'SELECT'	=> 't.*, f.forum_name',

				'FROM'		=> array(
					$db_prefix . "_forums_watch"	=> 'tw',
					$db_prefix . '_topics'		=> 't'
				),

				'WHERE'		=> 'tw.user_id = ' . $user->id . '
					AND t.topic_id = tw.forum_id
					AND ' . $db->sql_in_set('t.forum_id', $forbidden_forums, true, true),


				'ORDER_BY'	=> 't.topic_last_post_time DESC'
			);

			$sql_array['LEFT_JOIN'] = array();
		$sql_array['LEFT_JOIN'][] = array('FROM' => array($db_prefix . '_forums' => 'f'), 'ON' => 't.forum_id = f.forum_id');

		if ($config['load_db_lastread'])
		{
			$sql_array['LEFT_JOIN'][] = array('FROM' => array($db_prefix . '_forums_track' => 'ft'), 'ON' => 'ft.forum_id = t.forum_id AND ft.user_id = ' . $user->id);
			$sql_array['LEFT_JOIN'][] = array('FROM' => array($db_prefix . '_topics_track' => 'tt'), 'ON' => 'tt.topic_id = t.topic_id AND tt.user_id = ' . $user->id);
			$sql_array['SELECT'] .= ', tt.mark_time, ft.mark_time AS forum_mark_time';
		}

		if ($config['load_db_track'])
		{
			$sql_array['LEFT_JOIN'][] = array('FROM' => array($db_prefix . '_topics_posted' => 'tp'), 'ON' => 'tp.topic_id = t.topic_id AND tp.user_id = ' . $user->id);
			$sql_array['SELECT'] .= ', tp.topic_posted';
		}

		$sql = $db->sql_build_query('SELECT', $sql_array);
		//die($sql);
		$result = $db->sql_query($sql . ' LIMIT ' . $starttop . ', ' .$config['topics_per_page']);
		$topic_list = $topic_forum_list = $global_announce_list = $rowset = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$topic_id = (isset($row['b_topic_id'])) ? $row['b_topic_id'] : $row['topic_id'];

			$topic_list[] = $topic_id;
			$rowset[$topic_id] = $row;

			$topic_forum_list[$row['forum_id']]['forum_mark_time'] = ($config['load_db_lastread']) ? $row['forum_mark_time'] : 0;
			$topic_forum_list[$row['forum_id']]['topics'][] = $topic_id;

			if ($row['topic_type'] == 3)
			{
				$global_announce_list[] = $topic_id;
			}
		}
		$db->sql_freeresult($result);

		$topic_tracking_info = array();
		if ($config['load_db_lastread'])
		{
			foreach ($topic_forum_list as $f_id => $topic_row)
			{
				$topic_tracking_info += get_topic_tracking($f_id, $topic_row['topics'], $rowset, array($f_id => $topic_row['forum_mark_time']), ($f_id == 0) ? $global_announce_list : false);
			}
		}
		else
		{
			foreach ($topic_forum_list as $f_id => $topic_row)
			{
				$topic_tracking_info += get_complete_topic_tracking($f_id, $topic_row['topics'], $global_announce_list);
			}
		}

		foreach ($topic_list as $topic_id)
		{
			$row = &$rowset[$topic_id];

			$forum_id = $row['forum_id'];
			$topic_id = (isset($row['b_topic_id'])) ? $row['b_topic_id'] : $row['topic_id'];

			$unread_topic = (isset($topic_tracking_info[$topic_id]) && $row['topic_last_post_time'] > $topic_tracking_info[$topic_id]) ? true : false;

			// Replies
			$replies = ($auth->acl_get('m_approve', $forum_id)) ? $row['topic_replies_real'] : $row['topic_replies'];

			if ($row['topic_status'] == 2 && !empty($row['topic_moved_id']))
			{
				$topic_id = $row['topic_moved_id'];
			}

			// Get folder img, topic status/type related information
			$folder_img = $folder_alt = $topic_type = '';
			topic_status($row, $replies, $unread_topic, $folder_img, $folder_alt, $topic_type);

			$view_topic_url_params = "f=$forum_id&amp;t=$topic_id";
			$view_topic_url = append_sid("{$phpbb_root_path}forum.php?action=viewtopic", $view_topic_url_params);

			// Send vars to template
			$template->assign_block_vars('forumrow', array(
				'FORUM_ID'					=> $forum_id,
				'TOPIC_ID'					=> $topic_id,
				'FIRST_POST_TIME'			=> $user->format_date($row['topic_time']),
				'LAST_POST_SUBJECT'			=> $row['topic_last_post_subject'],
				'LAST_POST_TIME'			=> $user->format_date($row['topic_last_post_time']),
				'LAST_VIEW_TIME'			=> $user->format_date($row['topic_last_view_time']),

				'TOPIC_AUTHOR'				=> get_username_string('username', $row['topic_poster'], $row['topic_first_poster_name'], '#' . $row['topic_first_poster_colour']),
				'TOPIC_AUTHOR_COLOUR'		=> get_username_string('colour', $row['topic_poster'], $row['topic_first_poster_name'],  '#' . $row['topic_first_poster_colour']),
				'TOPIC_AUTHOR_FULL'			=> get_username_string('full', $row['topic_poster'], $row['topic_first_poster_name'],  '#' . $row['topic_first_poster_colour']),
				'U_TOPIC_AUTHOR'			=> get_username_string('profile', $row['topic_poster'], $row['topic_first_poster_name'],  '#' . $row['topic_first_poster_colour']),

				'LAST_POST_AUTHOR'			=> get_username_string('username', $row['topic_last_poster_id'], $row['topic_last_poster_name'],  '#' . $row['topic_last_poster_colour']),
				'LAST_POST_AUTHOR_COLOUR'	=> get_username_string('colour', $row['topic_last_poster_id'], $row['topic_last_poster_name'],  '#' . $row['topic_last_poster_colour']),
				'LAST_POST_AUTHOR_FULL'		=> get_username_string('full', $row['topic_last_poster_id'], $row['topic_last_poster_name'],  '#' . $row['topic_last_poster_colour']),
				'U_LAST_POST_AUTHOR'		=> get_username_string('profile', $row['topic_last_poster_id'], $row['topic_last_poster_name'],  '#' . $row['topic_last_poster_colour']),
				'S_TOPIC_REPORTED'			=> (!empty($row['topic_reported']) && empty($row['topic_moved_id']) && $auth->acl_get('m_report', $row['forum_id'])) ? true : false,

				'S_DELETED_TOPIC'	=> (!$row['topic_id']) ? true : false,
				'S_GLOBAL_TOPIC'	=> (!$forum_id) ? true : false,

				'PAGINATION'		=> topic_generate_pagination($replies, append_sid("{$phpbb_root_path}forum.$phpEx?action=viewtopic", 'f=' . (($row['forum_id']) ? $row['forum_id'] : $forum_id) . "&amp;t=$topic_id")),
				'REPLIES'			=> $replies,
				'VIEWS'				=> $row['topic_views'],
				'TOPIC_TITLE'		=> censor_text($row['topic_title']),
				'TOPIC_TYPE'		=> $topic_type,
				'FORUM_NAME'		=> $row['forum_name'],

				'TOPIC_FOLDER_IMG'		=> $user->img($folder_img, $folder_alt),
				'TOPIC_FOLDER_IMG_SRC'	=> $user->img($folder_img, $folder_alt, false, '', 'src'),
				'TOPIC_FOLDER_IMG_ALT'	=> $user->lang[$folder_alt],
				'TOPIC_ICON_IMG'		=> (!empty($icons[$row['icon_id']])) ? $icons[$row['icon_id']]['img'] : '',
				'TOPIC_ICON_IMG_WIDTH'	=> (!empty($icons[$row['icon_id']])) ? $icons[$row['icon_id']]['width'] : '',
				'TOPIC_ICON_IMG_HEIGHT'	=> (!empty($icons[$row['icon_id']])) ? $icons[$row['icon_id']]['height'] : '',
				'ATTACH_ICON_IMG'		=> ($auth->acl_get('u_download') && $auth->acl_get('f_download', $forum_id) && $row['topic_attachment']) ? $user->img('icon_topic_attach', $user->lang['TOTAL_ATTACHMENTS']) : '',

				'S_TOPIC_TYPE'			=> $row['topic_type'],
				'S_USER_POSTED'			=> (!empty($row['topic_posted'])) ? true : false,
				'S_UNREAD_TOPIC'		=> $unread_topic,

				'U_NEWEST_POST'			=> append_sid("{$phpbb_root_path}forum.$phpEx?action=viewtopic", $view_topic_url_params . '&amp;view=unread') . '#unread',
				'U_LAST_POST'			=> append_sid("{$phpbb_root_path}forum.$phpEx?action=viewtopic", $view_topic_url_params . '&amp;p=' . $row['topic_last_post_id']) . '#p' . $row['topic_last_post_id'],
				'U_VIEW_TOPIC'			=> $view_topic_url,
				'U_VIEW_FORUM'			=> append_sid("{$phpbb_root_path}forum.$phpEx?action=viewforum", 'f=' . $forum_id),
			));
		}
		if ($posts)
		{
			$template->assign_vars(array(
				'PAGINATION'	=> generate_pagination($siteurl.'/user.php?op=editprofile',$posts,$torrent_per_page,0),
				'PAGE_NUMBER'	=> $page,
				'TOTAL_TOPICS'	=> ($posts == 1) ? $user->lang['VIEW_FORUM_TOPIC'] : sprintf($user->lang['VIEW_FORUM_TOPICS'], $posts),
			));
		}

?>