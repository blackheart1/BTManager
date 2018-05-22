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
** File bookmarks.php 2018-02-18 14:32:00 joeroberts
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
function get_topic_title($id){
global $db, $db_prefix;
			        $sql = "SELECT `topic_title` FROM `".$db_prefix."_topics` WHERE `id`='".$id."' LIMIT 1;";
					$arr = $db->sql_query($sql);
					while ($res = $db->sql_fetchrow($arr)) {
					return $res['subject'];
					}

}
if($userrow["book"])
{
	$sql="SELECT topic_id AS book_id FROM `".$db_prefix."_bookmarks` WHERE user_id = '" . $uid . "';";
	$res = $db->sql_query($sql) OR btsqlerror($sql);
	while ($bookmarks = $db->sql_fetchrow($res))
	{
		$sql2="SELECT forum_id AS forumid FROM `".$db_prefix."_topics` WHERE  topic_id = '" . $bookmarks['book_id'] . "' LIMIT 1;";
		$res2 = $db->sql_query($sql2) OR btsqlerror($sql2);
		$post_forumid = $db->sql_fetchrow($res2);
		$sql3 = 'SELECT forum_name AS name FROM `'.$db_prefix.'_forums` WHERE forum_id = ' . $post_forumid['forumid'] . ' LIMIT 1'; 
		$res3 = $db->sql_query($sql3) OR btsqlerror($sql3);
		$book_forum = $db->sql_fetchrow($res3);
		$sql4 = 'SELECT * FROM `'.$db_prefix.'_posts` WHERE topic_id = ' . $bookmarks['book_id'] . ' ORDER BY added DESC LIMIT 1'; 
		$res4 = $db->sql_query($sql4) OR btsqlerror($sql4);
		$book_post_info = $db->sql_fetchrow($res4);
		$template->assign_block_vars('books_title',array(
			'BOOKS_LAST_POSTER_COLOR' =>getusercolor(getlevel_name($book_post_info['poster_id'])),
			'BOOKS_LAST_NAME' =>username_is($book_post_info['poster_id']),
			'BOOKS_LAST_POSTER' =>$book_post_info['poster_id'],
			'BOOKS_LAST_POST_DATE' =>$book_post_info['added'],
			'BOOKS_FORUM_TITTLE' =>$book_forum['name'],
			'BOOKS_FORUM_ID' => $post_forumid['forumid'],
			'BOOKS_TITTLE' => get_topic_title($bookmarks['book_id']),
			'BOOKS_ID' => $bookmarks['book_id'],
		));
		$books_id[] = $bookmarks['book_id'];
	}
}
?>