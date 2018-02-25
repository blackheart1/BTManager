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
				'S_HIDDEN_FIELDS'		=> $hidden
));
	$sql = "SELECT `torrent`, `user`, `status`FROM `".$db_prefix."_comments_notify` WHERE `user` = '".$uid."' ;"; 
	$res = $db->sql_query($sql) or btsqlerror($sql);
	if ($db->sql_numrows($res) >= 1) {
				$template->assign_vars(array(
				'S_TORRENT_NOTIFY'		=> true,
				));
	while($dcont = $db->sql_fetchrow($res)){
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
						A.tracker_update, COUNT(S.status) as auths FROM ".$db_prefix."_torrents A LEFT JOIN ".$db_prefix."_categories B ON A.category = B.id LEFT JOIN ".$db_prefix."_users C ON A.owner = C.id LEFT JOIN ".$db_prefix."_privacy_file S ON S.torrent = A.id AND S.status = 'pending' WHERE A.id = '".$dcont['torrent']."' GROUP BY A.id LIMIT 1;";
						$res_t = $db->sql_query($sql_t) or btsqlerror($sql_t);
						$torrent = $db->sql_fetchrow($res_t);
						$db->sql_freeresult($res_t);
								if (can_download($user,$torrent)) {
						        $can_access = true;
								} else {
						        $can_access = false;
								}
                        if (isset($torrent["cat_pic"]) AND $torrent["cat_pic"] != "" AND is_readable("themes/".$theme."/pics/cat_pics/".$torrent["cat_pic"]))
                                $cat_pics = "<img border=\"0\" src=\"themes/" . $theme . "/pics/cat_pics/". $torrent["cat_pic"] . "\" alt=\"" . $torrent["cat_name"] . "\" >";
                                elseif (isset($torrent["cat_pic"]) AND $torrent["cat_pic"] != "" AND is_readable("cat_pics/".$torrent["cat_pic"]))
                                $cat_pics = "<img border=\"0\" src=\"cat_pics/" . $torrent["cat_pic"] . "\" alt=\"" . $torrent["cat_name"] . "\" >";
                        else
                                $cat_pics = $torrent["cat_name"];
				$template->assign_block_vars('torrentrow',array(
				'TORRENT_ID'     => $dcont['torrent'],
				'STATUS'		 => $dcont['status'],
				'CAT_IMG'		 => $cat_pics,
				'TORRENT_NAME'	 => $torrent['name'],
				'U_TORFORUM'	 => $siteurl.'/details.php?id='.$dcont['torrent'].'&hit',
				'DATE_ADDED'	 => $user->format_date(sql_timestamp_to_unix_timestamp($torrent['added'])),
				'LAST_SEEDER'    => ($torrent['tracker'] != "")? '' : $user->format_date(sql_timestamp_to_unix_timestamp($torrent['lastseed'])),
				'CAN_DOWNLOAD'	 => can_download($user, $torrent),
				'CAN_EDIT'	 	 => ($torrent["owner"] == $user->id AND checkaccess("u_edit_own_torrents"))? true : checkaccess("m_can_edit_others_torrents")? true : false,
				'CAN_DELETE'	 => ($torrent["owner"] == $user->id AND checkaccess("u_edit_own_torrents"))? true : checkaccess("m_can_edit_others_torrents")? true : false,
				'CAN_BAN'		 => checkaccess("m_bann_torrents"),
				'TRACKER'		 => ($torrent["tracker"]!= "")? $torrent["tracker"] : false
				));
	}
	}//else				$template->assign_block_vars('torrentrow',array());
				$sql = "SELECT *
				FROM `".$db_prefix."_bookmarks`
				WHERE `user_id` =".$uid.";";
	$res = $db->sql_query($sql) or btsqlerror($sql);
	$posts = $db->sql_numrows($res);
	if ($posts > 0) {
	while($top = $db->sql_fetchrow($res)){
		$topic_id = $top['topic_id'];
				$template->assign_vars(array(
				'S_TOPIC_NOTIFY'		=> true,
				));
			$sql_t = "SELECT 
						`topic_first_poster_name`,
						`topic_first_poster_colour`,
						`topic_poster` , 
						`topic_title` , 
						`forum_id` , 
						`topic_last_post_time` , 
						`topic_moved_id` , 
						`topic_type` , 
						`topic_views`, 
						`topic_last_post_id`, 
						`topic_last_poster_colour`, 
						`topic_last_poster_name`, 
						`topic_last_poster_id`, 
						`topic_replies`, 
						`topic_status`, 
						`poll_start`
						FROM `".$db_prefix."_topics`
						WHERE `topic_id` = ". $topic_id ."
						LIMIT 1";
			$res_t = $db->sql_query($sql_t) or btsqlerror($sql_t);
			list ($first_poster_name,$first_poster_colour,$topic_auth, 
			$topic_title, 
			$forum_id, 
			$last_pid, 
			$moved, 
			$topic_type, 
			$views, 
			$last_postid , 
			$last_poster_colour, 
			$topic_last_poster_name,
			$topic_last_poster_id,
			$topic_replies,
			$topic_status,
			$poll_start) = $db->fetch_array($res_t);
			$forumname = $db->sql_fetchrow($db->sql_query("SELECT `forum_name`as name FROM `".$db_prefix."_forums` WHERE `forum_id` = $forum_id"));
			$sql_p = "SELECT *
			FROM `".$db_prefix."_posts`
			WHERE `topic_id` =". $topic_id ."
			ORDER BY `".$db_prefix."_posts`.`post_time` ASC";
			$res_p = $db->sql_query($sql_p) or btsqlerror($sql_p);
			$start = $last_post = 0;
			$posts_t = $db->sql_numrows($res_p);
			while($top_p= $db->sql_fetchrow($res_p)){
			if($start == 0)$start = $top_p['post_time'];
			if($last_post < $top_p['post_time']){
			$last_post = $top_p['post_time'];
			$last_auth = $top_p['poster_id'];
			}
			}
		// Get folder img, topic status/type related information
		include_once('include/functions_forum.php');
		$folder_img = $folder_alt = $topic_type = '';
		$topic_row = array('topic_status'=>$topic_status,'topic_type'=>$topic_type,'topic_posted'=>'','poll_start'=>$poll_start);
		topic_status($topic_row, $topic_replies, false, $folder_img, $folder_alt, $topic_type);
				$template->assign_block_vars('topicrow',array(
				'PAGINATION'	=> generate_pagination('forums.php?action=viewtopic&t='.$forum_id,$posts_t,15,1,false),
				'PAGE_NUMBER'	=> $page,
				'TOTAL_TOPICS'	=> ($posts_t == 1) ? $user->lang['VIEW_FORUM_TOPIC'] : sprintf($user->lang['VIEW_FORUM_TOPICS'], $posts_t),
						'FORUM_ID'					=> $forum_id,
						'TOPIC_ID'					=> $topic_id,
						'TOPIC_AUTHOR'				=> $first_poster_name,
						'TOPIC_AUTHOR_COLOUR'		=> $first_poster_colour,
						'TOPIC_AUTHOR_FULL'			=> $first_poster_name,
						'FIRST_POST_TIME'			=> $last_postid,
						'LAST_POST_SUBJECT'			=> $topic_title,
						'LAST_POST_TIME'			=> $user->format_date($last_post),
						'LAST_VIEW_TIME'			=> $user->format_date($last_post),
						'LAST_POST_AUTHOR'			=> $topic_last_poster_name,
						'LAST_POST_AUTHOR_COLOUR'	=> $last_poster_colour,
						'LAST_POST_AUTHOR_FULL'		=> get_username_string('full', $topic_last_poster_id, $topic_last_poster_name, $last_poster_colour),
						'TOPIC_TITLE'				=> $topic_title,
						'TOPIC_TYPE'				=> $moved,

						'TOPIC_FOLDER_IMG'		=> $user->img($folder_img, $folder_alt),
						'TOPIC_FOLDER_IMG_SRC'	=> $user->img($folder_img, $folder_alt, false, '', 'src'),
						'TOPIC_FOLDER_IMG_ALT'	=> $user->lang[$folder_alt],
						'TOPIC_FOLDER_IMG_WIDTH'=> $user->img($folder_img, '', false, '', 'width'),
						'TOPIC_FOLDER_IMG_HEIGHT'	=> $user->img($folder_img, '', false, '', 'height'),
						'ATTACH_ICON_IMG'		=> '',
						'S_UNREAD_TOPIC'		=> '',
						'S_GLOBAL_TOPIC'		=> (!$forum_id) ? true : false,
						'LAST_POST_IMG'			=> '<img border="0" alt="Last" src="themes/eVo_blue/forums/icon_topic_latest.gif">',

						'S_USER_POSTED'		=> (!empty($row['topic_posted']) && $row['topic_posted']) ? true : false,
						'S_UNREAD'			=> '',

						'U_TOPIC_AUTHOR'		=> username_is($topic_auth),
						'U_LAST_POST'			=> $siteurl."/forum.php?action=viewtopic&f=$forum_id&t=$topic_id&p=$last_postid#p$last_postid",
						'U_LAST_POST_AUTHOR'	=> get_username_string('full', $topic_last_poster_id, $topic_last_poster_name, $last_poster_colour),
						'U_NEWEST_POST'			=> $siteurl."/forum.php?action=viewtopic&f=$forum_id&t=$topic_id&p=$last_postid#p$last_postid",
						'U_VIEW_TOPIC'			=> $siteurl."/forum.php?action=viewtopic&f=$forum_id&t=$topic_id",
						'U_VIEW_FORUM'			=> $siteurl."/forum.php?action=viewforum&f=$forum_id",
						'FORUM_NAME'			=> $forumname[0]
));
}
}//else				$template->assign_block_vars('topicrow',array(0));
		if ($posts)
		{
			$template->assign_vars(array(
				'PAGINATION'	=> generate_pagination($siteurl.'/user.php?op=editprofile',$posts,$torrent_per_page,0),
				'PAGE_NUMBER'	=> $page,
				'TOTAL_TOPICS'	=> ($posts == 1) ? $user->lang['VIEW_FORUM_TOPIC'] : sprintf($user->lang['VIEW_FORUM_TOPICS'], $posts),
			));
		}
		$sql = "SELECT * FROM `".$db_prefix."_forums_watch`
				WHERE `user_id` =".$uid.";";
		$res = $db->sql_query($sql) or btsqlerror($sql);
		$forum_w = $db->sql_numrows($res);
	if ($forum_w > 0) {
				$template->assign_vars(array(
				'S_FORUM_NOTIFY'		=> true,
				));
	while($for = $db->sql_fetchrow($res)){
		$forum_id = $for['forum_id'];
		$forumname = $db->sql_fetchrow($db->sql_query("SELECT f.* FROM `".$db_prefix."_forums` f WHERE `forum_id` = $forum_id"));				
		$template->assign_block_vars('forumrow',array(
							'FORUM_ID'				=> $forum_id,
							'FORUM_FOLDER_IMG'		=> '',
							'FORUM_FOLDER_IMG_SRC'	=> '',
							'FORUM_IMAGE'			=> '',
							'FORUM_IMAGE_SRC'		=> '',
							'FORUM_NAME'			=> $forumname['forum_name'],
							'LAST_POST_SUBJECT'		=> $forumname['forum_last_post_subject'],
							'LAST_POST_TIME'		=> $user->format_date($forumname['forum_last_post_time']),

							'LAST_POST_IMG'			=> '<img border="0" alt="Last" src="themes/eVo_blue/forums/icon_topic_latest.gif">',
							'LAST_POST_AUTHOR'			=> $forumname['forum_last_poster_name'],
							'LAST_POST_AUTHOR_COLOUR'	=> $forumname['forum_last_poster_colour'],
							'LAST_POST_AUTHOR_FULL'		=> "<a href=\"".$siteurl."/user.php?op=profile&id=".$forumname['forum_last_poster_id']."\" style=\"color: ".$forumname['forum_last_poster_colour'].";\" class=\"username-coloured\">".$forumname['forum_last_poster_name']."</a>",
							'U_LAST_POST_AUTHOR'		=> '',

							'U_LAST_POST'			=> $siteurl."/forums.php?action=viewtopic&f=" . $forum_id . "&t=$topic_id&p=" . $forumname['forum_last_post_id '] . "#p" . $forumname['forum_last_post_id '],
							'U_VIEWFORUM'			=> 'forums.php?action=viewforum&f=' . $forum_id . '&forumid='.$forum_id
));
}
}
?>