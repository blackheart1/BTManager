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
** File ucp_pm_viewmessage.php 2018-02-18 14:32:00 joeroberts
**
** CHANGES
**
** 2018-04-15 - Fix signature in view PM
**/
if (!defined('IN_PMBT'))
{
	include_once './../../security.php';
	die ();
}
require_once("include/constants.php");
function view_message($id, $mode, $folder_id, $msg_id, $folder, $message_row)
{
	global $user, $db_prefix, $template, $auth, $db, $pmbt_cache;
	global $siteurl, $phpEx, $config;

		include_once('include/function_posting.' . $phpEx);
		include_once('include/functions_forum.' . $phpEx);

	$msg_id		= (int) $msg_id;
	$folder_id	= (int) $folder_id;
	$author_id	= (int) $message_row['author_id'];
	$view		= request_var('view', '');

	// Not able to view message, it was deleted by the sender
	if ($message_row['pm_deleted'])
	{
		$meta_info = append_sid("{$siteurl}/pm.$phpEx", "i=pm&amp;folder=$folder_id");
		$message = $user->lang['NO_AUTH_READ_REMOVED_MESSAGE'];

		$message .= '<br /><br />' . sprintf($user->lang['RETURN_FOLDER'], '<a href="' . $meta_info . '">', '</a>');
		trigger_error($message);
	}

	// Do not allow hold messages to be seen
	if ($folder_id == PRIVMSGS_HOLD_BOX)
	{
		trigger_error('NO_AUTH_READ_HOLD_MESSAGE');
	}

	// Grab icons
	$icons = $pmbt_cache->obtain_icons();

	$bbcode = false;

	// Instantiate BBCode if need be
	if ($message_row['bbcode_bitfield'])
	{
		include_once('include/bbcode.' . $phpEx);
		$bbcode = new bbcode($message_row['bbcode_bitfield']);
	}

	// Assign TO/BCC Addresses to template
	write_pm_addresses(array('to' => (($message_row['recipient'])?'u_'.$message_row['recipient']:''), 'bcc' => (($message_row['bcc_address'])?'g_'.$message_row['bcc_address']:'')), $author_id);

	$user_info = get_user_information($author_id, $message_row);
	//die(print_r($user_info));

	// Parse the message and subject
	$message = censor_text($message_row['text']);
	//die(print_r($message_row));

	// Second parse bbcode here
	if ($message_row['bbcode_bitfield'])
	{
		$bbcode->bbcode_second_pass($message, $message_row['bbcode_uid'], $message_row['bbcode_bitfield']);
	}
	// Parse the message and subject
		$message = bbcode_nl2br($message);
		$message = parse_smiles($message);

	// Replace naughty words such as farty pants
	$message_row['subject'] = censor_text($message_row['subject']);

	// Editing information
	if ($message_row['message_edit_count'] && $config['display_last_edited'])
	{
		$l_edit_time_total = ($message_row['message_edit_count'] == 1) ? $user->lang['EDITED_TIME_TOTAL'] : $user->lang['EDITED_TIMES_TOTAL'];
		$l_edited_by = '<br /><br />' . sprintf($l_edit_time_total, (!$message_row['message_edit_user']) ? $message_row['username'] : $message_row['message_edit_user'], $user->format_date($message_row['message_edit_time'], false, true), $message_row['message_edit_count']);
	}
	else
	{
		$l_edited_by = '';
	}

	// Pull attachment data
	$display_notice = false;
	$attachments = array();

	if ($message_row['message_attachment'] && $config['allow_pm_attach'])
	{
		if (checkaccess('u_pm_download'))
		{
			$sql = 'SELECT *
				FROM ' . $db_prefix . "_attachments
				WHERE post_msg_id = $msg_id
					AND in_message = 1
				ORDER BY filetime DESC, post_msg_id ASC";
			$result = $db->sql_query($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				$attachments[] = $row;
			}
			$db->sql_freeresult($result);

			// No attachments exist, but message table thinks they do so go ahead and reset attach flags
			if (!sizeof($attachments))
			{
				$sql = 'UPDATE ' . $db_prefix . "_private_messages
					SET message_attachment = 0
					WHERE msg_id = $msg_id";
				$db->sql_query($sql);
			}
		}
		else
		{
			$display_notice = true;
		}
	}

	// Assign inline attachments
	if (!empty($attachments))
	{
		$update_count = array();
		parse_attachments(false, $message, $attachments, $update_count);

		// Update the attachment download counts
		if (sizeof($update_count))
		{
			$sql = 'UPDATE ' . $db_prefix . '_attachments
				SET download_count = download_count + 1
				WHERE ' . $db->sql_in_set('attach_id', array_unique($update_count));
			$db->sql_query($sql);
		}
	}

	$user_info['sig'] = '';

	$signature = $user_info['signature'];

	// End signature parsing, only if needed
	if ($signature)
	{
			if ($user_info['sig_bbcode_bitfield'])
			{
				include_once($phpbb_root_path . 'include/class.bbcode.' . $phpEx);
				include_once($phpbb_root_path . 'include/bbcode.' . $phpEx);
				$bbcode = new bbcode();
				$bbcode->bbcode_second_pass($signature, $user_info['sig_bbcode_uid'], $user_info['sig_bbcode_bitfield']);
			}
		$signature = censor_text($signature);
		//$signature = format_comment($signature);
		parse_smiles($signature);
	}

	$url = append_sid("pm.$phpEx", 'i=pm');

	// Number of "to" recipients
	$num_recipients = (int) preg_match_all('/:?(u|g)_([0-9]+):?/', $message_row['to_address'], $match);

	$template->assign_vars(array(
		'MESSAGE_AUTHOR_FULL'		=> get_username_string('full', $author_id, $user_info['username'], getusercolor($user_info['can_do']), $user_info['username']),//$user_info['username'],
		'MESSAGE_AUTHOR_COLOUR'		=> get_username_string('colour', $author_id, $user_info['username'], getusercolor($user_info['can_do']), $user_info['username']),//getusercolor($user_info['can_do']),
		'MESSAGE_AUTHOR'			=> get_username_string('username', $author_id, $user_info['username'], getusercolor($user_info['can_do']), $user_info['username']),//$user_info['username'],
		'U_MESSAGE_AUTHOR'			=> get_username_string('profile', $author_id, $user_info['username'], getusercolor($user_info['can_do']), $user_info['username']),//$user_info['username'],

		'RANK_TITLE'		=> $user_info['rank_title'],
		'RANK_IMG'			=> $user_info['rank_image'],
		'AUTHOR_AVATAR'		=> (isset($user_info['avatar'])) ? $user_info['avatar'] : '',
		'AUTHOR_JOINED'		=> $user_info['regdate'],
		'AUTHOR_POSTS'		=> (int) $user_info['user_posts'],
		'AUTHOR_FROM'		=> (!empty($user_info['user_from'])) ? $user_info['user_from'] : '',

		'ONLINE_IMG'		=> (!$config['load_onlinetrack']) ? '' : ((isset($user_info['online']) && $user_info['online']) ? $user->img('icon_user_online', $user->lang['_ONLINE']) : $user->img('icon_user_offline', $user->lang['_OFFLINE'])),
		'S_ONLINE'			=> (!$config['load_onlinetrack']) ? false : ((isset($user_info['online']) && $user_info['online']) ? true : false),
		'DELETE_IMG'		=> $user->img('icon_post_delete', $user->lang['_DELETE_MESSAGE']),
		'INFO_IMG'			=> $user->img('icon_post_info', $user->lang['_VIEW_PM_INFO']),
		'PROFILE_IMG'		=> $user->img('icon_user_profile', $user->lang['_READ_PROFILE']),
		'EMAIL_IMG'			=> $user->img('icon_contact_email', $user->lang['_SEND_EMAIL']),
		'QUOTE_IMG'			=> $user->img('icon_post_quote', $user->lang['_POST_QUOTE_PM']),
		'REPLY_IMG'			=> $user->img('button_pm_reply', $user->lang['_POST_REPLY_PM']),
		'REPORT_IMG'		=> $user->img('icon_post_report', $user->lang['_REPORT_PM']),
		'EDIT_IMG'			=> $user->img('icon_post_edit', $user->lang['_POST_EDIT_PM']),
		'MINI_POST_IMG'		=> $user->img('icon_post_target', $user->lang['_PM']),

		'SENT_DATE'			=> $user->format_date(sql_timestamp_to_unix_timestamp($message_row['sent'])),
		'SUBJECT'			=> $message_row['subject'],
		'MESSAGE'			=> $message,
		'SIGNATURE'			=> $signature ,
		'EDITED_MESSAGE'	=> $l_edited_by,
		'MESSAGE_ID'		=> $message_row['msg_id'],

		'U_PM'			=> ($config['allow_privmsg'] && checkaccess('u_sendpm') && ($user_info['user_allow_pm'] || $auth->acl_gets('a_', 'm_') || $auth->acl_getf_global('m_'))) ? append_sid("{$siteurl}pm.$phpEx", 'op=send&amp;i=pm&amp;mode=compose&amp;u=' . $author_id) : '',
		'U_WWW'			=> (!empty($user_info['user_website'])) ? $user_info['user_website'] : '',
		'U_ICQ'			=> ($user_info['user_icq']) ? 'http://www.icq.com/people/webmsg.php?to=' . urlencode($user_info['user_icq']) : '',
		'U_AIM'			=> ($user_info['user_aim'] && checkaccess('u_sendim')) ? append_sid("{$siteurl}/userfind_to_pm.$phpEx", 'mode=contact&amp;action=aim&amp;u=' . $author_id) : '',
		'U_YIM'			=> ($user_info['user_yim']) ? 'http://edit.yahoo.com/config/send_webmesg?.target=' . urlencode($user_info['user_yim']) . '&amp;.src=pg' : '',
		'U_MSN'			=> ($user_info['user_msnm'] && checkaccess('u_sendim')) ? append_sid("{$siteurl}/userfind_to_pm.$phpEx", 'mode=contact&amp;action=msnm&amp;u=' . $author_id) : '',
		'U_JABBER'		=> ($user_info['user_jabber'] && checkaccess('u_sendim')) ? append_sid("{$siteurl}/userfind_to_pm.$phpEx", 'mode=contact&amp;action=jabber&amp;u=' . $author_id) : '',

		'U_DELETE'			=> (checkaccess('u_pm_delete')) ? "$url&amp;op=send&amp;mode=compose&amp;action=delete&amp;f=$folder_id&amp;p=" . $message_row['msg_id'] : '',
		'U_EMAIL'			=> $user_info['email'],
		'U_REPORT'			=> ($config['allow_pm_report']) ? append_sid("{$siteurl}/report.$phpEx", "pm=" . $message_row['msg_id']) : '',
		'U_QUOTE'			=> ($author_id != 0) ? "$url&amp;op=send&amp;mode=compose&amp;action=quote&amp;f=$folder_id&amp;p=" . $message_row['msg_id'] : '',
		'U_EDIT'			=> (($message_row['message_time'] > time() - ($config['pm_edit_time'] * 60) || !$config['pm_edit_time']) && $folder_id == PRIVMSGS_OUTBOX && $auth->acl_get('u_pm_edit')) ? "$url&amp;mode=compose&amp;action=edit&amp;f=$folder_id&amp;p=" . $message_row['msg_id'] : '',
		'U_POST_REPLY_PM'	=> ($author_id != 0) ? "$url&amp;op=send&amp;mode=compose&amp;action=reply&amp;f=$folder_id&amp;p=" . $message_row['msg_id'] : '',
		'U_POST_REPLY_ALL'	=> ($author_id != 0) ? "$url&amp;op=send&amp;mode=compose&amp;action=reply&amp;f=$folder_id&amp;reply_to_all=1&amp;p=" . $message_row['msg_id'] : '',
		'U_PREVIOUS_PM'		=> "$url&amp;f=$folder_id&amp;p=" . $message_row['msg_id'] . "&amp;view=previous",
		'U_NEXT_PM'			=> "$url&amp;f=$folder_id&amp;p=" . $message_row['msg_id'] . "&amp;view=next",

		'U_PM_ACTION'		=> $url . '&amp;mode=compose&amp;f=' . $folder_id . '&amp;p=' . $message_row['msg_id'],

		'S_HAS_ATTACHMENTS'	=> (sizeof($attachments)) ? true : false,
		'S_DISPLAY_NOTICE'	=> $display_notice && $message_row['message_attachment'],
		'S_AUTHOR_DELETED'	=> ($author_id == ANONYMOUS) ? true : false,
		'S_SPECIAL_FOLDER'	=> in_array($folder_id, array(PRIVMSGS_NO_BOX, PRIVMSGS_OUTBOX)),
		'S_PM_RECIPIENTS'	=> $num_recipients,

		'U_PRINT_PM'		=> ($config['print_pm'] && checkaccess('u_pm_printpm')) ? "$url&amp;f=$folder_id&amp;p=" . $message_row['msg_id'] . "&amp;view=print" : '',
		'U_FORWARD_PM'		=> ($config['forward_pm'] && checkaccess('u_sendpm') && checkaccess('u_pm_forward')) ? "$url&amp;mode=compose&amp;action=forward&amp;f=$folder_id&amp;p=" . $message_row['msg_id'] : '')
	);

	// Display not already displayed Attachments for this post, we already parsed them. ;)
	if (isset($attachments) && sizeof($attachments))
	{
		foreach ($attachments as $attachment)
		{
			$template->assign_block_vars('attachment', array(
				'DISPLAY_ATTACHMENT'	=> $attachment)
			);
		}
	}

	if (!isset($_REQUEST['view']) || $_REQUEST['view'] != 'print')
	{
		// Message History
		if (message_history($msg_id, $user->id, $message_row, $folder))
		{
			$template->assign_var('S_DISPLAY_HISTORY', true);
		}
	}
}

/**
* Get user information (only for message display)
*/
function get_user_information($user_id, $user_row)
{
	global $db, $db_prefix, $user;

	if (!$user_id)
	{
		return array();
	}

	if (empty($user_row))
	{
		$sql = 'SELECT *
			FROM ' . $db_prefix . '_users
			WHERE id = ' . (int) $user_id;
		$result = $db->sql_query($sql);
		$user_row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
	}

	// Some standard values
	$user_row['online'] = false;
	$user_row['rank_title'] = $user_row['rank_image'] = $user_row['rank_image_src'] = $user_row['email'] = '';

	// Generate online information for user
	$user_row['avatar'] = gen_avatar($user_id);
	$user_row['rank_title'] = getlevel($user_row['can_do']);

	return $user_row;
}

?>