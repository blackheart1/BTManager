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
** File drafts.php 2018-02-18 14:32:00 joeroberts
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
	$error = false;
	$edit = (isset($_REQUEST['edit'])) ? true : false;
	$template->assign_block_vars('custom_tags', array('BBCODE_TAG' => '','BBCODE_HELPLINE' => '', 'BBCODE_ID' => ''));
	if($edit){
	$edit_hidden = build_hidden_fields(array(
	"take_edit"		=> "1",
	"edit_id"		=> $_REQUEST['edit'],
	"do"			=> "edit_take"
	));
	}
		$template->assign_vars(array(
		//'ERROR'=> '',
		'S_EDIT_DRAFT'=> $edit,
		'S_BBCODE_ALLOWED'=> true,
		'S_BBCODE_QUOTE'=> true,
		'S_BBCODE_IMG'=> true,
		'S_LINKS_ALLOWED'=> true,
		'S_BBCODE_FLASH'=> true,
		'S_SMILIES_ALLOWED'		=> true,
		'T_TEMPLATE_PATH'=> $siteurl . "/themes/" . $theme . "/templates",
		'S_HIDDEN_FIELDS'=> ($edit)? $edit_hidden : '<input name="do" value="edit_delete" type="hidden">',
		'S_UCP_ACTION' => $siteurl.'/user.php?op=editprofile&action=overview&mode=drafts'
		));
		if ($edit) $where = "draft_id = '" . $_REQUEST['edit'] ."'";
		else
		$where = "user_id = '" . $userrow["id"] ."'";
		$sql = "SELECT * FROM ".$db_prefix."_drafts WHERE ".$where;
		$res = $db->sql_query($sql) or btsqlerror($sql);
		$dcont = $db->sql_numrows($res);
				if (!$edit)
				{
					$template->assign_var('S_DRAFT_ROWS', $dcont);
				}
				$row_count = 0;
        while($row = $db->sql_fetchrow($res)){
		$link_topic = $link_forum = $link_pm = $link_torrent = false;
		$insert_url = $view_url = $title = '';
		if($row['draft_type'] == 'coment'){
		$link_torrent = true;
		$insert_url = 'details.php?id=' . $row['torrent'] . '&comm=startcomments&d='.$row['draft_id'];
		$view_url = 'details.php?id=' . $row['torrent'];
		}
		if($row['draft_type'] == 'pm'){
		$link_pm = true;
		$tittle = username_is($row['user_to']);
		$insert_url = 'pm.php?op=send&to='.$row['user_to']. '&draft='.$row['draft_id'];
		$view_url = 'user.php?op=editprofile&amp;action=overview&mode=drafts&edit=' . $row['draft_id'];
		}
		if($row['draft_type'] == 'topic'){
		$tittle = get_topic_title($row['topic_id']);
		$link_topic = true;
		$insert_url = 'forums.php?action=viewtopic&topicid=' . $row['topic_id'] . '&d='.$row['draft_id'] . '#bottom';
		$view_url = 'forums.php?action=viewtopic&topicid=' . $row['topic_id'];
		}
		if($row['draft_type'] == 'forum'){
		$link_forum = true;
		$sql_f = "SELECT forum_name AS name FROM `".$db_prefix."_forums` WHERE `forum_id` = '".$row['forum_id']."'";
		$res_f = $db->sql_query($sql_f) or btsqlerror($sql_f);
		$row_f = $db->sql_fetchrow($res_f);
		$tittle = $row_f['name'];
		$insert_url = 'forum.php?action=posting&mode=post&f=' . $row['forum_id'] . '&d='.$row['draft_id'];
		$view_url = 'user.php?op=editprofile&amp;action=overview&mode=drafts&edit=' . $row['draft_id'];
		}
$template_row = array(
'DATE' =>$user->format_date($row['save_time']),
'DRAFT_SUBJECT' => $row['draft_subject'],
'DRAFT_MESSAGE'	=> $row['draft_message'],
'S_LINK_TOPIC' => $link_topic,
'S_LINK_FORUM' => $link_forum,
'S_LINK_PM' => $link_pm,
'S_LINK_TORRENT' => $link_torrent,
'TITLE' => $tittle,
'U_INSERT' => $insert_url,
'DRAFT_ID'	=> $row['draft_id'],
'U_VIEW_EDIT'	=> $view_url,
'U_VIEW'		=> $insert_url
);
					$row_count++;
($edit) ? $template->assign_vars($template_row) : $template->assign_block_vars('draftrow', $template_row);
}
?>