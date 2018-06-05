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
** File ucp_front.php 2018-02-18 14:32:00 joeroberts
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
$sql_profile = "SELECT U.* , count(F.post_id)AS forumposts, F.post_time as fadded FROM ".$db_prefix."_users U LEFT JOIN ".$db_prefix."_posts F ON U.id = F.poster_id where U.id ='".$uid."' GROUP BY U.id LIMIT 1;";
$res_profile = $db->sql_query($sql_profile)OR btsqlerror($sql_profile);
$userrow = $db->sql_fetchrow($res_profile);
$db->sql_freeresult($res_profile);
$post_count = 0;
$active_f_name = $most_in = $active_t_name = $most_in_f = array();
if($userrow["forumposts"] > 0){
$sql="SELECT count(post_id)as num FROM `".$db_prefix."_posts`;";
$res = $db->sql_query($sql) OR btsqlerror($sql);
$post_count = $db->sql_fetchrow($res);
$sql = " SELECT count(`".$db_prefix."_posts`.`topic_id`)as posts, `".$db_prefix."_posts`.`topic_id` as id FROM `".$db_prefix."_posts` WHERE `".$db_prefix."_posts`.`poster_id` = " . $userrow["id"] . " GROUP BY `".$db_prefix."_posts`.`topic_id` ORDER BY posts  DESC LIMIT 1;";
$res = $db->sql_query($sql) OR btsqlerror($sql);
$most_in = $db->sql_fetchrow($res);
$sql = "SELECT `topic_title`, `forum_id` FROM `".$db_prefix."_topics` WHERE `topic_id` = '" . $most_in['id'] . "';";
$res = $db->sql_query($sql) OR btsqlerror($sql);
$active_t_name = $db->sql_fetchrow($res);
$sql = "SELECT `forum_name`, `forum_id` FROM `".$db_prefix."_forums` WHERE `forum_id` = '" . $active_t_name['forum_id'] . "';";
$res = $db->sql_query($sql) OR btsqlerror($sql);
$active_f_name = $db->sql_fetchrow($res);
$t_post_in = array();
$sql = "SELECT `topic_id` FROM `".$db_prefix."_topics` WHERE `forum_id` = '" . $active_f_name['forum_id'] . "';";
$res = $db->sql_query($sql) OR btsqlerror($sql);
while($row = $db->sql_fetchrow($res))
$t_post_in[] = $row['topic_id'];

$sql = " SELECT count(`p`.`post_id`)as posts FROM `".$db_prefix."_posts` p WHERE `p`.`topic_id` IN ('".implode("', '",$t_post_in)."') AND `p`.`poster_id` = " . $userrow["id"] . ";";
$res = $db->sql_query($sql) OR btsqlerror($sql);
$most_in_f = $db->sql_fetchrow($res);
}
		$memberdays = max(1, round((time() - sql_timestamp_to_unix_timestamp($userrow["regdate"])) / 86400));
		$posts_per_day = $userrow["forumposts"] / $memberdays;
		$percentage = ($post_count['num']) ? min(100, ($userrow["forumposts"] / $post_count['num']) * 100) : 0;
$dt1 = strtotime(gmdate("Y-m-d H:i:s", time())) - 600;
$dt = date("Y-m-d H:i:s", $dt1);
$active_f_count = ($userrow["forumposts"]) ? $userrow["forumposts"] : '0';
$l_active_pct = ($user->user && $userrow["id"] == $user->id) ? '%.2f%% of your posts' : '%.2f%% of user’s posts';
$active_t_pct = ($userrow["forumposts"]) ? ($most_in['posts'] / $userrow["forumposts"]) * 100 : 0;
$active_f_pct = ($userrow["forumposts"]) ? ($most_in_f['posts'] / $userrow["forumposts"]) * 100 : 0;
$now = getdate(time() - date('Z'));
$template->assign_vars(array(
        'CP_UID'				=> $uid,
		'U_SEARCH_USER'			=> 'forum.php?action=search&amp;author_id=' . $uid . '&amp;sr=posts',
		'CP_UREGDATE'           => formatTimeStamp($userrow["regdate"]),
        'CP_ULASTSEEN'          => formatTimeStamp($userrow["lastlogin"]),
		'CP_POST_COUNT'         => $userrow["forumposts"],
		'POSTS_DAY'             => sprintf('%.2f posts per day', $posts_per_day),
		'POSTS_PCT'             => sprintf('%.2f%% of all posts', $percentage),
		'ACTIVE_FORUM'			=> (isset($active_f_name['forum_name'])) ? $active_f_name['forum_name'] : '',
		'ACTIVE_FORUM_POSTS'	=> ($active_f_count == 0) ? sprintf('%d Post', 0) :($active_f_count == 1) ? sprintf('%d Post', 1) : sprintf('%d Posts', $most_in_f['posts']),
		'ACTIVE_FORUM_PCT'		=> sprintf($l_active_pct, $active_f_pct),
		'ACTIVE_TOPIC'			=> (isset($active_t_name['topic_title'])) ? $active_t_name['topic_title'] : '',
		'ACTIVE_TOPIC_POSTS'	=> (isset($most_in['posts'])) ? ($most_in['posts'] == 1) ? sprintf('%d Post', 1) : sprintf('%d Posts', $most_in['posts']) : '',
		'ACTIVE_TOPIC_PCT'		=> sprintf($l_active_pct, $active_t_pct),
		'U_ACTIVE_FORUM'		=> (isset($active_t_name['forum_id'])) ? './forum.php?action=viewforum&f='.$active_t_name['forum_id'] : '',
		'U_ACTIVE_TOPIC'		=> (isset($most_in['id'])) ? './forum.php?action=viewtopic&f=' . $active_t_name['forum_id'] . '&t='.$most_in['id'] : '',
		));
?>