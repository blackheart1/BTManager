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
** File attachments.php 2018-02-18 14:32:00 joeroberts
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
$user->set_lang('pm',$user->ulanguage);
		$start		= request_var('start', 0);
		$sort_key	= request_var('sk', 'a');
		$sort_dir	= request_var('sd', 'a');

		$delete		= (isset($_POST['delete'])) ? true : false;
		$confirm	= (isset($_POST['confirm'])) ? true : false;
		$delete_ids	= array_keys(request_var('attachment', array(0)));

		if ($delete && sizeof($delete_ids))
		{
			// Validate $delete_ids...
			$sql = 'SELECT attach_id
				FROM ' . $db_prefix . '_attachments
				WHERE poster_id = ' . $uid . '
					AND is_orphan = 0
					AND ' . $db->sql_in_set('attach_id', $delete_ids);
			$result = $db->sql_query($sql);

			$delete_ids = array();
			while ($row = $db->sql_fetchrow($result))
			{
				$delete_ids[] = $row['attach_id'];
			}
			$db->sql_freeresult($result);
		}

		if ($delete && sizeof($delete_ids))
		{
			$s_hidden_fields = array(
				'delete'	=> 1
			);

			foreach ($delete_ids as $attachment_id)
			{
				$s_hidden_fields['attachment'][$attachment_id] = 1;
			}
				$s_hidden_fields['op'] = "editprofile";
				$s_hidden_fields['action'] = 'overview';
				$s_hidden_fields['mode'] = 'attachments';
		
			if (confirm_box(true))
			{
				if (!function_exists('delete_attachments'))
				{
					include_once('include/function_posting.php');
				}

				delete_attachments('attach', $delete_ids);

				$message = ((sizeof($delete_ids) == 1) ? $user->lang['_ATTACHMENT_DELETED'] : $user->lang['_ATTACHMENTS_DELETED']) . '<br /><br />' . sprintf($user->lang['_RETURN_UCP'], '<a href="' . $siteurl . '/user.php?op=editprofile&action=overview&mode=attachments">', '</a>');
                                $template->assign_vars(array(
										'S_REFRESH'				=> true,
										'META' 				  	=> '<meta http-equiv="refresh" content="5;url=' . $siteurl . '/user.php?op=editprofile&amp;action=overview&amp;mode=attachments" />',
										'S_ERROR_HEADER'		=>$user->lang['ACCESS_DENIED'],
                                        'S_ERROR_MESS'			=> $message,
                                ));
				//trigger_error($message);
                echo $template->fetch('error.html');
				die();
			}
			else
			{
				confirm_box(false, ((sizeof($delete_ids) == 1) ? '_DELETE_ATTACHMENT' : '_DELETE_ATTACHMENTS'), build_hidden_fields($s_hidden_fields));
			}
		}

		// Select box eventually
		$sort_key_text = array('a' => $user->lang['NAME'], 'b' => $user->lang['DATE_ADDED'], 'c' => $user->lang['EXTENTION'], 'd' => $user->lang['SIZE'], 'e' => $user->lang['DOWNED'], 'f' => $user->lang['UPLODED'], 'g' => $user->lang['SORT_TOPIC_TITLE']);
		$sort_key_sql = array('a' => 'a.real_filename', 'b' => 'a.attach_comment', 'c' => 'a.extension', 'd' => 'a.filesize', 'e' => 'a.download_count', 'f' => 'a.filetime', 'g' => 't.topic_title');

		$sort_dir_text = array('a' =>  $user->lang['ASCENDING'], 'd' => $user->lang['DESCENDING']);

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

		if (!isset($sort_key_sql[$sort_key]))
		{
			$sort_key = 'a';
		}

		$order_by = $sort_key_sql[$sort_key] . ' ' . (($sort_dir == 'a') ? 'ASC' : 'DESC');

		$sql = 'SELECT COUNT(attach_id) as num_attachments
			FROM ' . $db_prefix . '_attachments
			WHERE poster_id = ' . $uid ."
				AND is_orphan = 0";
		$result = $db->sql_query($sql);
		$num_attachments = $db->sql_fetchfield('num_attachments');
		$db->sql_freeresult($result);

		$sql = 'SELECT a.*, t.forum_id, t.topic_title, p.subject as message_title
			FROM ' . $db_prefix . '_attachments a
				LEFT JOIN `' . $db_prefix . '_topics` t ON (a.topic_id = t.topic_id AND a.in_message = 0)
				LEFT JOIN `' . $db_prefix . '_private_messages` p ON (a.post_msg_id = p.id AND a.in_message = 1)
			WHERE a.poster_id = ' . $uid . '
				AND a.is_orphan = 0
			ORDER BY '. $order_by;
		$result = $db->sql_query($sql) or btsqlerror($sql);

		$row_count = 0;
		if ($row = $db->sql_fetchrow($result))
		{
			$template->assign_var('S_ATTACHMENT_ROWS', true);

			do
			{
				if ($row['in_message'])
				{
					$view_topic = "pm.php?op=readmsg&mode=inbox&mid=" . $row['id'];
				}
				else
				{
					$view_topic = "forum.php?action=viewtopic&f=" . $row['forum_id'] . "&t=" . $row['topic_id'] . "&p=" . $row['post_msg_id'] . "#" . $row['post_msg_id'];
				}

				$template->assign_block_vars('attachrow', array(
					'ROW_NUMBER'		=> $row_count + ($start + 1),
					'FILENAME'			=> $row['real_filename'],
					'COMMENT'			=> $row['attach_comment'],
					'EXTENSION'			=> $row['extension'],
					'SIZE'				=> mksize($row['filesize']),
					'DOWNLOAD_COUNT'	=> $row['download_count'],
					'POST_TIME'			=> $user->format_date($row['filetime']),
					'TOPIC_TITLE'		=> ($row['in_message']) ? $row['message_title'] : $row['topic_title'],

					'ATTACH_ID'			=> $row['attach_id'],
					'POST_ID'			=> $row['post_msg_id'],
					'TOPIC_ID'			=> $row['topic_id'],

					'S_IN_MESSAGE'		=> $row['in_message'],

					'U_VIEW_ATTACHMENT'	=> $siteurl . "/file.php?id=" . $row['attach_id'],
					'U_VIEW_TOPIC'		=> $view_topic)
				);

				$row_count++;
			}
			while ($row = $db->sql_fetchrow($result));
		}
		$db->sql_freeresult($result);

		$template->assign_vars(array(
			'PAGE_NUMBER'			=> on_page($num_attachments, $torrent_per_page, $start),
			'PAGINATION'			=> generate_pagination("user.php?op=editprofile&action=overview&mode=attachments&amp;sk=$sort_key&amp;sd=$sort_dir", $num_attachments, $torrent_per_page, $start),
			'TOTAL_ATTACHMENTS'		=> $num_attachments,

			'L_TITLE'				=> $user->lang['UCP_ATTACHMENTS'],

			'U_SORT_FILENAME'		=> "user.php?op=editprofile&action=overview&mode=attachments&amp;sk=a&amp;sd=" . (($sort_key == 'a' && $sort_dir == 'a') ? 'd' : 'a'),
			'U_SORT_FILE_COMMENT'	=> "user.php?op=editprofile&action=overview&mode=attachments&amp;sk=b&amp;sd=" . (($sort_key == 'b' && $sort_dir == 'a') ? 'd' : 'a'),
			'U_SORT_EXTENSION'		=> "user.php?op=editprofile&action=overview&mode=attachments&amp;sk=c&amp;sd=" . (($sort_key == 'c' && $sort_dir == 'a') ? 'd' : 'a'),
			'U_SORT_FILESIZE'		=> "user.php?op=editprofile&action=overview&mode=attachments&amp;sk=d&amp;sd=" . (($sort_key == 'd' && $sort_dir == 'a') ? 'd' : 'a'),
			'U_SORT_DOWNLOADS'		=> "user.php?op=editprofile&action=overview&mode=attachments&amp;sk=e&amp;sd=" . (($sort_key == 'e' && $sort_dir == 'a') ? 'd' : 'a'),
			'U_SORT_POST_TIME'		=> "user.php?op=editprofile&action=overview&mode=attachments&amp;sk=f&amp;sd=" . (($sort_key == 'f' && $sort_dir == 'a') ? 'd' : 'a'),
			'U_SORT_TOPIC_TITLE'	=> "user.php?op=editprofile&action=overview&mode=attachments&amp;sk=g&amp;sd=" . (($sort_key == 'f' && $sort_dir == 'a') ? 'd' : 'a'),

			'S_DISPLAY_MARK_ALL'	=> ($num_attachments) ? true : false,
			'S_DISPLAY_PAGINATION'	=> ($num_attachments) ? true : false,
			'S_UCP_ACTION'			=> 'user.php?op=editprofile&action=overview&mode=attachments',
			'S_SORT_OPTIONS' 		=> $s_sort_key,
			'S_ORDER_SELECT'		=> $s_sort_dir)
		);

?>