<?php
/*
*--------------------------------BT,Manager V 3.0.0----------------------------* 
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
*-------------------   And Joe Robertson (aka joeroberts)   -------------------*
*-------------               http://www.p2pmania.it               -------------*
*------------ Based on the Bit Torrent Protocol made by Bram Cohen ------------*
*-------------              http://www.bittorrent.com             -------------*
*------------------------------------------------------------------------------*
*------------------------------------------------------------------------------*
*---------              �2014 BT,Manager Development Team              --------*
*--------------               http://BT,Manager.com               -------------*
*------------------------------------------------------------------------------*
*-------------------   Wendsday, May 14, 2014 9:05 PM   -----------------------*
*
* @package BT,Manager
* @version $Id: 3.0.0 forum.php  2014-05-14 00:22:48 joeroberts $
* @copyright (c) 2014 BT,Manager Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
require_once("common.php");
include_once("include/forum_config.php");
include'include/functions_forum.php';
$template = new Template();
$user->set_lang('forum',$user->ulanguage);
set_site_var($user->lang['FORUM']);
$themedir = "" . $siteurl . "/themes/" . $theme . "/forums/";
if ($user->forumbanned){
						$template->assign_vars(array(
							'S_ERROR'			=> true,
							'S_FORWARD'			=> false,
							'TITTLE_M'			=> $user->lang['BT_ERROR'],
							'MESSAGE'			=> $user->lang['FORUM_BANNED'],
						));
						echo $template->fetch('message_body.html');
						close_out();
}
else
{
	if ($FORUMS || $user->admin)
	{
		//define the clickable smilies
		$submit		= (isset($_POST['post'])) ? true : false;
		$preview	= (isset($_POST['preview'])) ? true : false;
		$save		= (isset($_POST['save'])) ? true : false;
		$load		= (isset($_POST['load'])) ? true : false;
		$delete		= (isset($_POST['delete'])) ? true : false;
		$cancel		= (isset($_POST['cancel']) && !isset($_POST['save'])) ? true : false;
		$refresh	= (isset($_POST['add_file']) || isset($_POST['delete_file']) || isset($_POST['cancel_unglobalise']) || $save || $load) ? true : false;
		$action		= ($delete && !$preview && !$refresh && $submit) ? 'reply' : request_var('action', '');
		$action_mcp = request_var('action_mcp', '');
		if($refresh)$action = 'reply';
		//if($save)echo ' save';
		//die($action);
		switch ($action_mcp)
		{
			case "mcp":
				{
					require_once("forum/mcp.php");
					ob_end_flush();
					$db->sql_close();
					die();
				}
		}
		switch ($action)
		{
			case "renametopic":
			case "editpost":
			case "reply":
			case "posting":
			case "newtopic":
				{
					require_once("forum/posting.php");
					ob_end_flush();
					$db->sql_close();
					die();
				}
			case "viewtopic":
				{
					require_once("forum/viewtopic.php");
					ob_end_flush();
					$db->sql_close();
					die();
				}
			case "viewforum":
				{
					require_once("forum/viewforum.php");
					ob_end_flush();
					$db->sql_close();
					die();
				}
			case "unsetsticky":
			case "setsticky":
			case "unlocktopic":
			case "deletetopic":
			case "movetopic":
			case "movetopic":
			case "mcp":
				{
					require_once("forum/mcp.php");
					ob_end_flush();
					$db->sql_close();
					die();
				}
			case "viewunread":
			case "watchforum":
			case "deletepost":
				{
					require_once("forum/ucp.php");
					ob_end_flush();
					$db->sql_close();
					die();
				}
			case "search":
				{
					require_once("forum/search.php");
					ob_end_flush();
					$db->sql_close();
					die();
				}
		}
		
		/////////////////////////////////////////////////////////Action: Remove bookmark
		if (isset($do) AND $do == "removebook")
		{
					require_once("forum/ucp.php");
					ob_end_flush();
					$db->sql_close();
					die();
		}
		
		///////////////////////////////////////////////////////// Action: DEFAULT ACTION (VIEW FORUMS)
		if (isset($_GET["catchup"]))
			catch_up();
		
		///////////////////////////////////////////////////////// Action: SHOW MAIN FORUM INDEX
// Set some stats, get posts count from forums data if we... hum... retrieve all forums data
		$sql = "SELECT COUNT( post_id )
		FROM `".$db_prefix."_posts`;";
        $res = $db->sql_query($sql);
        list ($total_posts) = $db->fetch_array($res);
        $db->sql_freeresult($res);
		$sql = "SELECT COUNT(topic_id )
		FROM `".$db_prefix."_topics`;";
        $res = $db->sql_query($sql);
        list ($total_topics) = $db->fetch_array($res);
        $db->sql_freeresult($res);
        $sql = "SELECT COUNT(id) 
		FROM ".$db_prefix."_users;";
        $res = $db->sql_query($sql);
        list ($total_users) = $db->fetch_array($res);
        $db->sql_freeresult($res);

		$l_total_user_s = ($total_users == 0) ? 'TOTAL_USERS_ZERO' : 'TOTAL_USERS_OTHER';
		$l_total_post_s = ($total_posts == 0) ? 'TOTAL_POSTS_ZERO' : 'TOTAL_POSTS_OTHER';
		$l_total_topic_s = ($total_topics == 0) ? 'TOTAL_TOPICS_ZERO' : 'TOTAL_TOPICS_OTHER';

		$template->assign_vars(array(
			'FOLDER_IMG'				=> $user->img('topic_read', 'NO_NEW_POSTS'),
			'FOLDER_NEW_IMG'			=> $user->img('topic_unread', 'NEW_POSTS'),
			'FOLDER_HOT_IMG'			=> $user->img('topic_read_hot', 'NO_NEW_POSTS_HOT'),
			'FOLDER_HOT_NEW_IMG'		=> $user->img('topic_unread_hot', 'NEW_POSTS_HOT'),
			'FOLDER_LOCKED_IMG'			=> $user->img('topic_read_locked', 'NO_NEW_POSTS_LOCKED'),
			'FOLDER_LOCKED_NEW_IMG'		=> $user->img('topic_unread_locked', 'NEW_POSTS_LOCKED'),
			'FOLDER_STICKY_IMG'			=> $user->img('sticky_read', 'POST_STICKY'),
			'FOLDER_STICKY_NEW_IMG'		=> $user->img('sticky_unread', 'POST_STICKY'),
			'FOLDER_ANNOUNCE_IMG'		=> $user->img('announce_read', 'POST_ANNOUNCEMENT'),
			'FOLDER_ANNOUNCE_NEW_IMG'	=> $user->img('announce_unread', 'POST_ANNOUNCEMENT'),
			'FOLDER_MOVED_IMG'			=> $user->img('topic_moved', 'TOPIC_MOVED'),
			'TOTAL_POSTS'	=> sprintf($user->lang[$l_total_post_s], $total_posts),
			'TOTAL_TOPICS'	=> sprintf($user->lang[$l_total_topic_s], $total_topics),
			'TOTAL_USERS'	=> sprintf($user->lang[$l_total_user_s], $total_users),
			'BIRTHDAY_LIST'	=> $birthday_list,
			'FORUM_IMG'				=> $user->img('forum_read', 'NO_NEW_POSTS'),
			'FORUM_NEW_IMG'			=> $user->img('forum_unread', 'NEW_POSTS'),
			'FORUM_LOCKED_IMG'		=> $user->img('forum_read_locked', 'NO_NEW_POSTS_LOCKED'),
			'FORUM_NEW_LOCKED_IMG'	=> $user->img('forum_unread_locked', 'NO_NEW_POSTS_LOCKED'),
			'S_DISPLAY_BIRTHDAY_LIST'	=> ($config['load_birthdays']) ? true : false,
		
			'U_MARK_FORUMS'		=> ($user->user) ? append_sid("{$phpbb_root_path}index.$phpEx", 'hash=' . generate_link_hash('global') . '&amp;mark=forums') : '',
			'U_MCP'				=> ($auth->acl_get('m_') || $auth->acl_getf_global('m_')) ? append_sid("{$phpbb_root_path}forum.$phpEx?action_mcp=mcp", 'i=main&amp;mode=front', true, $user->session_id) : '',
		));
		display_forums();
		echo $template->fetch('forum_index.html');
		close_out();
	}
}
?>