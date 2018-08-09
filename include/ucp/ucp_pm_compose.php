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
** File ucp_pm_compose.php 2018-02-18 14:32:00 joeroberts
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
function compose_pm($id, $mode, $action)
{
	global $template, $db, $db_prefix, $auth, $user;
	global $phpEx, $config,$sitename,$siteurl;

	// Damn php and globals - i know, this is horrible
	// Needed for handle_message_list_actions()
	global $refresh, $submit, $preview, $theme, $pmbt_cache;

	include('include/function_posting.php');
	include('include/message_parser.php');
	include_once("include/utf/utf_tools.php");

	if (!$action)
	{
		$action = 'post';
	}
	add_form_key('ucp_pm_compose');

	// Grab only parameters needed here
	$to_user_id		= request_var('u', 0);
	if($to_user_id == 0)$to_user_id		= request_var('to', 0);
	$to_group_id	= request_var('g', 0);
	$msg_id			= request_var('p', '0');
	$draft_id		= request_var('d', '0');
	$lastclick		= request_var('lastclick', 0);
	$op 			= request_var('op', 0);

	// Reply to all triggered (quote/reply)
	$reply_to_all	= request_var('reply_to_all', '0');

	// Do NOT use request_var or specialchars here
	$address_list	= isset($_REQUEST['address_list']) ? $_REQUEST['address_list'] : array();

	if (!is_array($address_list))
	{
		$address_list = array();
	}
	$submit		= (isset($_POST['post'])) ? true : false;
	$preview	= (isset($_POST['preview'])) ? true : false;
	$save		= (isset($_POST['save'])) ? true : false;
	$load		= (isset($_POST['load'])) ? true : false;
	$cancel		= (isset($_POST['cancel']) && !isset($_POST['save'])) ? true : false;
	$delete		= (isset($_POST['delete'])) ? true : false;

	$remove_u	= (isset($_REQUEST['remove_u'])) ? true : false;
	$remove_g	= (isset($_REQUEST['remove_g'])) ? true : false;
	$add_to		= (isset($_REQUEST['add_to'])) ? true : false;
	$add_bcc	= (isset($_REQUEST['add_bcc'])) ? true : false;

	$refresh	= isset($_POST['add_file']) || isset($_POST['delete_file']) || $save || $load
		|| $remove_u || $remove_g || $add_to || $add_bcc;

	$action		= ($delete && !$preview && !$refresh && $submit) ? 'delete' : $action;
	$select_single = ($config['allow_mass_pm'] && checkaccess('u_masspm')) ? false : true;

	$error = array();
	$current_time = time();

	// Was cancel pressed? If so then redirect to the appropriate page
	if ($cancel || ($current_time - $lastclick < 2 && $submit))
	{
		if ($msg_id)
		{
			redirect(append_sid("{$siteurl}/pm.$phpEx?op=readmsg", 'mode=view&amp;action=view_message&amp;p=' . $msg_id));
		}
		redirect(append_sid("{$siteurl}/pm.$phpEx", 'i=pm'));
	}

	// Output PM_TO box if message composing
	if ($action != 'edit')
	{
		// Add groups to PM box
		if ($config['allow_mass_pm'] && checkaccess('u_masspm_group'))
		{
			$sql = 'SELECT g.group_id, g.group_name, g.group_type
				FROM ' . $db_prefix . '_level_settings g';

			if (!$auth->acl_gets('a_group', 'a_groupadd', 'a_groupdel'))
			{
				$sql .= ' LEFT JOIN ' . $db_prefix . '_user_group ug
					ON (
						g.group_id = ug.group_id
						AND ug.user_id = ' . $user->id . '
						AND ug.user_pending = 0
					)
					WHERE (g.group_type <> ' . 2 . ' OR ug.user_id = ' . $user->id . ')';
			}

			$sql .= ($auth->acl_gets('a_group', 'a_groupadd', 'a_groupdel')) ? ' WHERE ' : ' AND ';

			$sql .= 'g.group_receive_pm = 0  AND g.group_id <> ' . 6 . ' 
				ORDER BY g.group_name ASC';
			$result = $db->sql_query($sql)or btsqlerror($sql);

			$group_options = '';
			while ($row = $db->sql_fetchrow($result))
			{
				$group_options .= '<option' . (($row['group_type'] == 3) ? ' class="sep"' : '') . ' value="' . $row['group_id'] . '">' . (($row['group_type'] == 3) ? $user->lang['G_' . $row['group_name']] : $row['group_name']) . '</option>';
			}
			$db->sql_freeresult($result);
		}

		$template->assign_vars(array(
			'S_SHOW_PM_BOX'		=> true,
			'S_ALLOW_MASS_PM'	=> ($config['allow_mass_pm'] && checkaccess('u_masspm')) ? true : false,
			'S_GROUP_OPTIONS'	=> ($config['allow_mass_pm'] && checkaccess('u_masspm_group')) ? $group_options : '',
			'U_FIND_USERNAME'	=> append_sid("{$siteurl}/userfind_to_pm.$phpEx", "mode=searchuser&amp;form=postform&amp;field=username_list&amp;select_single=$select_single"),
		));
	}

	$sql = '';

	// What is all this following SQL for? Well, we need to know
	// some basic information in all cases before we do anything.
	switch ($action)
	{
		case 'post':
			if (!$auth->acl_get('u_sendpm'))
			{
				trigger_error('NO_AUTH_SEND_MESSAGE');
			}
		break;

		case 'reply':
		case 'quote':
		case 'forward':
		case 'quotepost':
			if (!$msg_id)
			{
				trigger_error('NO_MESSAGE');
			}

			if (!$auth->acl_get('u_sendpm'))
			{
				trigger_error('NO_AUTH_SEND_MESSAGE');
			}

			if ($action == 'quotepost')
			{
				$sql = 'SELECT p.post_id as msg_id, p.forum_id, p.post_text as message_text, p.poster_id as author_id, p.post_time as message_time, p.bbcode_bitfield, p.bbcode_uid, p.enable_sig, p.enable_smilies, p.enable_magic_url, t.topic_title as message_subject, u.username as quote_username
					FROM ' . $db_prefix . '_posts p, ' . $db_prefix . '_topics t, ' . $db_prefix . "_users u
					WHERE p.post_id = $msg_id
						AND t.topic_id = p.topic_id
						AND u.id = p.poster_id";
			}
			else
			{
				$sql = 'SELECT t.folder_id, p.*,p.id as msg_id,p.sender as author_id, u.username as quote_username
					FROM ' . $db_prefix . '_privmsgs_to t, ' . $db_prefix . '_private_messages p, ' . $db_prefix . '_users  u
					WHERE t.user_id = ' . $user->id . "
						AND p.sender = u.id
						AND t.msg_id = p.id
						AND p.id = $msg_id";
			}
		break;

		case 'edit':
			if (!$msg_id)
			{
				trigger_error('NO_MESSAGE');
			}

			// check for outbox (not read) status, we do not allow editing if one user already having the message
			$sql = 'SELECT p.*, t.folder_id
				FROM ' . $db_prefix . '_privmsgs_to t, ' . $db_prefix . '_private_messages p
				WHERE t.user_id = ' . $user->id . '
					AND t.folder_id = ' . -2 . "
					AND t.msg_id = $msg_id
					AND t.msg_id = p.id";
		break;

		case 'delete':
			if (!$auth->acl_get('u_pm_delete'))
			{
				trigger_error('NO_AUTH_DELETE_MESSAGE');
			}

			if (!$msg_id)
			{
				trigger_error('NO_MESSAGE');
			}

			$sql = 'SELECT msg_id AS id, pm_unread, pm_new, author_id AS sender, folder_id
				FROM ' . $db_prefix . '_privmsgs_to
				WHERE user_id = ' . $user->id . "
					AND msg_id = $msg_id";
		break;

		case 'smilies':
			generate_smilies('window', 0);
		break;

		default:
			trigger_error('NO_ACTION_MODE', E_USER_ERROR);
		break;
	}

	if ($action == 'forward' && (!$config['forward_pm'] || !$auth->acl_get('u_pm_forward')))
	{
		trigger_error('NO_AUTH_FORWARD_MESSAGE');
	}

	if ($action == 'edit' && !$auth->acl_get('u_pm_edit'))
	{
		trigger_error('NO_AUTH_EDIT_MESSAGE');
	}

	if ($sql)
	{
		$result = $db->sql_query($sql);
		$post = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		if (!$post)
		{
			// If editing it could be the recipient already read the message...
			if ($action == 'edit')
			{
				$sql = 'SELECT p.*, t.folder_id
					FROM ' . $db_prefix . '_privmsgs_to t, ' . $db_prefix . '_private_messages p
					WHERE t.user_id = ' . $user->id . "
						AND t.msg_id = $msg_id
						AND t.msg_id = p.id";
				$result = $db->sql_query($sql);
				$post = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				if ($post)
				{
					trigger_error('_NO_EDIT_READ_MESSAGE');
				}
			}

			trigger_error('_NO_MESSAGE');
		}

		if ($action == 'quotepost')
		{
			if (($post['forum_id'] && !$auth->acl_get('f_read', $post['forum_id'])) || (!$post['forum_id'] && !$auth->acl_getf_global('f_read')))
			{
				trigger_error('NOT_AUTHORISED');
			}

			// Passworded forum?
			if ($post['forum_id'])
			{
				$sql = 'SELECT forum_password
					FROM ' . $db_prefix . '_forums
					WHERE forum_id = ' . (int) $post['forum_id'];
				$result = $db->sql_query($sql);
				$forum_password = (string) $db->sql_fetchfield('forum_password');
				$db->sql_freeresult($result);

				if ($forum_password)
				{
					login_forum_box(array(
						'forum_id'			=> $post['forum_id'],
						'forum_password'	=> $forum_password,
					));
				}
			}
		}
//die(print_r($post));
		$msg_id			= (int) $post['id'];
		$folder_id		= (isset($post['folder_id'])) ? $post['folder_id'] : 0;
		$message_text	= (isset($post['text'])) ? $post['text'] : '';
		$post['author_id']		= $post['sender'];
		//die($post['author_id']);

		if ((!$post['author_id'] || ($post['author_id'] == 0 && $action != 'delete')) && $msg_id)
		{
			trigger_error('NO_AUTHOR');
		}

		if ($action == 'quotepost')
		{
			// Decode text for message display
			decode_message($message_text, $post['bbcode_uid']);
		}

		if ($action != 'delete')
		{
			$enable_urls = $post['enable_magic_url'];
			$enable_sig = (isset($post['enable_sig'])) ? $post['enable_sig'] : 0;

			$message_attachment = (isset($post['message_attachment'])) ? $post['message_attachment'] : 0;
			$message_subject = $post['subject'];
			$message_time = $post['message_time'];
			$bbcode_uid = $post['bbcode_uid'];

			$quote_username = (isset($post['quote_username'])) ? $post['quote_username'] : '';
			$icon_id = (isset($post['icon_id'])) ? $post['icon_id'] : 0;
//print($action);
			if (($action == 'reply' || $action == 'quote' || $action == 'quotepost') && !sizeof($address_list) && !$refresh && !$submit && !$preview)
			{
				// Add the original author as the recipient if quoting a post or only replying and not having checked "reply to all"
				if ($action == 'quotepost' || !$reply_to_all)
				{
					$address_list = array('u' => array($post['sender'] => 'to'));
				}
				else
				{
					// We try to include every previously listed member from the TO Header - Reply to all
					$address_list = rebuild_header(array('to' => $post['recipient']));

					// Add the author (if he is already listed then this is no shame (it will be overwritten))
					$address_list['u'][$post['sender']] = 'to';

					// Now, make sure the user itself is not listed. ;)
					if (isset($address_list['u'][$user->id]))
					{
						unset($address_list['u'][$user->id]);
					}
				}
			}
			else if ($action == 'edit' && !sizeof($address_list) && !$refresh && !$submit && !$preview)
			{
				// Rebuild TO and BCC Header
				$address_list = rebuild_header(array('to' => $post['recipient'], 'bcc' => $post['bcc_address']));
			}
			//die(print_r($address_list));

			if ($action == 'quotepost')
			{
				$check_value = 0;
			}
			else
			{
				$check_value = (($post['enable_bbcode']+1) << 8) + (($post['enable_smilies']+1) << 4) + (($enable_urls+1) << 2) + (($post['enable_sig']+1) << 1);
			}
		}
	}
	else
	{
		$message_attachment = 0;
		$message_text = $message_subject = '';

		if ($to_user_id && $action == 'post')
		{
			$address_list['u'][$to_user_id] = 'to';
		}
		else if ($to_group_id && $action == 'post')
		{
			$address_list['g'][$to_group_id] = 'to';
		}
		$check_value = 0;
	}

	if (($to_group_id || isset($address_list['g'])) && (!$config['allow_mass_pm'] || !checkaccess('u_masspm_group')))
	{
		trigger_error('NO_AUTH_GROUP_MESSAGE');
	}

	if ($action == 'edit' && !$refresh && !$preview && !$submit)
	{
		if (!($message_time > time() - ($config['pm_edit_time'] * 60) || !$config['pm_edit_time']))
		{
			trigger_error('CANNOT_EDIT_MESSAGE_TIME');
		}
	}

	if ($action == 'post')
	{
		$template->assign_var('S_NEW_MESSAGE', true);
	}

	if (!isset($icon_id))
	{
		$icon_id = 0;
	}

	$message_parser = new parse_message();

	$message_parser->message = ($action == 'reply') ? '' : $message_text;
	unset($message_text);

	$s_action = append_sid("{$siteurl}/pm.$phpEx", "op=send&amp;i=$id&amp;mode=$mode&amp;action=$action", true, $user->session_id);
	$s_action .= ($msg_id) ? "&amp;p=$msg_id" : '';

	// Delete triggered ?
	if ($action == 'delete')
	{
		// Folder id has been determined by the SQL Statement
		// $folder_id = request_var('f', -3);

		// Do we need to confirm ?
		if (confirm_box(true))
		{
			delete_pm($user->id, $msg_id, $folder_id);

			// jump to next message in "history"? nope, not for the moment. But able to be included later.
			$meta_info = append_sid("{$siteurl}/pm.$phpEx?op=folder", "i=$folder_id");
			$message = $user->lang['MESSAGE_DELETED'];

			meta_refresh(3, $meta_info);
			$message .= '<br /><br />' . sprintf($user->lang['RETURN_FOLDER'], '<a href="' . $meta_info . '">', '</a>');
			trigger_error($message);
		}
		else
		{
			$s_hidden_fields = array(
				'p'			=> $msg_id,
				'f'			=> $folder_id,
				'action'	=> 'delete',
				'op'        => 'send',
				'mode'      => 'compose',
			);

			confirm_box(false, 'DELETE_MESSAGE', build_hidden_fields($s_hidden_fields),'confirm_body.html',append_sid("{$siteurl}/pm.$phpEx?i=pm"));
		}

		redirect(append_sid("{$siteurl}/pm.$phpEx?op=readmsg", 'mode=view&amp;action=view_message&amp;p=' . $msg_id));
	}

	$max_recipients = '20';//(int) $db->sql_fetchfield('max_recipients');

	$max_recipients = (!$max_recipients) ? $config['pm_max_recipients'] : $max_recipients;

	// If this is a quote/reply "to all"... we may increase the max_recpients to the number of original recipients
	if (($action == 'reply' || $action == 'quote') && $max_recipients && $reply_to_all)
	{
		// We try to include every previously listed member from the TO Header
		$list = rebuild_header(array('to' => $post['recipient']));
		//die(print_r($list));

		// Can be an empty array too ;)
		$list = (!empty($list['u'])) ? $list['u'] : array();
		$list[$post['author_id']] = 'to';

		if (isset($list[$user->id]))
		{
			unset($list[$user->id]);
		}

		$max_recipients = ($max_recipients < sizeof($list)) ? sizeof($list) : $max_recipients;

		unset($list);
	}

	// Handle User/Group adding/removing
	handle_message_list_actions($address_list, $error, $remove_u, $remove_g, $add_to, $add_bcc);
	//die(print_r($address_list));

	// Check mass pm to group permission
	if ((!$config['allow_mass_pm'] || !checkaccess('u_masspm_group')) && !empty($address_list['g']))
	{
		$address_list = array();
		$error[] = $user->lang['_NO_AUTH_GROUP_MESSAGE'];
	}
	// Check mass pm to users permission
	if ((!$config['allow_mass_pm'] || !checkaccess('u_masspm')) && num_recipients($address_list) > 1)
	{
		$address_list = get_recipients($address_list, 1);
		$error[] = $user->lang['_TOO_MANY_RECIPIENTS'];
	}

	// Check for too many recipients
	if (!empty($address_list['u']) && $max_recipients && sizeof($address_list['u']) > $max_recipients)
	{
		$address_list = get_recipients($address_list, $max_recipients);
		$error[] = $user->lang['_TOO_MANY_RECIPIENTS'];
	}

	// Always check if the submitted attachment data is valid and belongs to the user.
	// Further down (especially in submit_post()) we do not check this again.
	$message_parser->get_submitted_attachment_data();

	if ($message_attachment && !$submit && !$refresh && !$preview && $action == 'edit')
	{
		// Do not change to SELECT *
		$sql = 'SELECT attach_id, is_orphan, attach_comment, real_filename
			FROM '.$db_prefix . "_attachments
			WHERE post_msg_id = $msg_id
				AND in_message = 1
				AND is_orphan = 0
			ORDER BY filetime DESC";
		$result = $db->sql_query($sql);
		$message_parser->attachment_data = array_merge($message_parser->attachment_data, $db->sql_fetchrowset($result));
		$db->sql_freeresult($result);
	}

	if (!in_array($action, array('quote', 'edit', 'delete', 'forward')))
	{
		$enable_sig		= ($config['allow_sig'] && $config['allow_sig_pm'] && checkaccess('u_sig'));
		$enable_smilies	= ($config['allow_smilies'] && checkaccess('u_pm_smilies'));
		$enable_bbcode	= ($config['allow_bbcode'] && checkaccess('u_pm_bbcode'));
		$enable_urls	= true;
	}

	$enable_magic_url = $drafts = false;

	// User own some drafts?
	if (checkaccess('u_savedrafts') && $action != 'delete')
	{
		$sql = 'SELECT draft_id
			FROM ' . $db_prefix . '_drafts
			WHERE forum_id = 0
				AND topic_id = 0
				AND user_id = ' . $user->id .
				(($draft_id) ? " AND draft_id <> $draft_id" : '') . 'LIMIT 1';
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		if ($row)
		{
			$drafts = true;
		}
	}

	if ($action == 'edit')
	{
		$message_parser->bbcode_uid = $bbcode_uid;
	}

	$bbcode_status	= ($config['allow_bbcode'] && $config['auth_bbcode_pm'] && checkaccess('u_pm_bbcode')) ? true : false;
	$smilies_status	= ($config['allow_smilies'] && $config['auth_smilies_pm'] && checkaccess('u_pm_smilies')) ? true : false;
	$img_status		= ($config['auth_img_pm'] && checkaccess('u_pm_img')) ? true : false;
	$flash_status	= ($config['auth_flash_pm'] && checkaccess('u_pm_flash')) ? true : false;
	$url_status		= ($config['allow_post_links']) ? true : false;

	// Save Draft
	if ($save && checkaccess('u_savedrafts'))
	{
		$draft_loaded = request_var('draft_loaded', '0');
		$subject = utf8_normalize_nfc(request_var('subject', '', true));
		$subject = (!$subject && $action != 'post') ? $user->lang['_NEW_MESSAGE'] : $subject;
		$message = utf8_normalize_nfc(request_var('message', '', true));

		if ($subject && $message)
		{
			if (confirm_box(true))
			{
				if($draft_loaded > '0')
				{
					$sql = 'UPDATE ' . $db_prefix . '_drafts SET  ' . $db->sql_build_array('UPDATE', array(
						'topic_id'		=> 0,
						'forum_id'		=> 0,
						'save_time'		=> $current_time,
						'draft_subject'	=> $subject,
						'draft_message'	=> $message,
						'user_to'		=> $to_user_id,
						)). ' WHERE `draft_id` = ' . $draft_loaded;
				}
				else
				{
					$sql = 'INSERT INTO ' . $db_prefix . '_drafts ' . $db->sql_build_array('INSERT', array(
						'user_id'		=> $user->id,
						'topic_id'		=> 0,
						'forum_id'		=> 0,
						'save_time'		=> $current_time,
						'draft_subject'	=> $subject,
						'draft_message'	=> $message,
						'draft_type'	=> 'pm',
						'user_to'		=> $to_user_id,
						'torrent'		=> 0
						)
					);
				}
				$db->sql_query($sql) or btsqlerror($sql);
				if($draft_loaded > '0')
				{
					$draft_id = $draft_loaded;
				}else{
					$draft_id = $db->sql_nextid();
				}
					

				$redirect_url = append_sid("{$siteurl}/pm.$phpEx", "op=send&amp;i=&amp;mode=edit&amp;d=$draft_id");

				meta_refresh(3, $redirect_url);
				$message = $user->lang['_DRAFT_SAVED'] . '<br /><br />' . sprintf($user->lang['_RETURN_UCP'], '<a href="' . $redirect_url . '">', '</a>');

				trigger_error($message);
			}
			else
			{
				$s_hidden_fields = build_hidden_fields(array(
					'op'       		=> 'send',
					'mode'			=> $mode,
					'action'		=> $action,
					'save'			=> '1',
					'subject'		=> $subject,
					'message'		=> $message,
					'u'				=> $to_user_id,
					'g'				=> $to_group_id,
					'p'				=> $msg_id,
					'draft_loaded'	=> $draft_loaded)
				);
				$s_hidden_fields .= build_address_field($address_list);


				confirm_box(false, '_SAVE_DRAFT', $s_hidden_fields);
			}
		}
		else
		{
			if ($subject === '')
			{
				$error[] = $user->lang['_EMPTY_MESSAGE_SUBJECT'];
			}

			if (utf8_clean_string($message) === '')
			{
				$error[] = $user->lang['_TOO_FEW_CHARS'];
			}
		}

		unset($subject, $message);
	}

	// Load Draft
	if ($draft_id && checkaccess('u_savedrafts'))
	{
		$sql = 'SELECT draft_subject, draft_message
			FROM ' . $db_prefix . "_drafts
			WHERE draft_id = $draft_id
				AND topic_id = 0
				AND forum_id = 0
				AND user_id = " . $user->id . ' LIMIT 1';
		$result = $db->sql_query($sql);

		if ($row = $db->sql_fetchrow($result))
		{
			$message_parser->message = $row['draft_message'];
			$message_subject = $row['draft_subject'];

			$template->assign_var('S_DRAFT_LOADED', true);
		}
		else
		{
			$draft_id = 0;
		}
		$db->sql_freeresult($result);
	}

	// Load Drafts
	if ($load && $drafts)
	{
		load_drafts(0, 0, $id, $action, $msg_id);
	}

	if ($submit || $preview || $refresh)
	{
		if (($submit || $preview) && !check_form_key('ucp_pm_compose'))
		{
			$error[] = $user->lang['_FORM_INVALID'];
		}
		$subject = request_var('subject', '', true);
		$message_parser->message = request_var('message', '', true);

		$icon_id			= request_var('icon', 0);

		$enable_bbcode 		= (!$bbcode_status || isset($_POST['disable_bbcode'])) ? false : true;
		$enable_smilies		= (!$smilies_status || isset($_POST['disable_smilies'])) ? false : true;
		$enable_urls 		= (isset($_POST['disable_magic_url'])) ? 0 : 1;
		$enable_sig			= (!$config['allow_sig'] ||!$config['allow_sig_pm']) ? false : ((isset($_POST['attach_sig'])) ? true : false);

		if ($submit)
		{
			$status_switch	= (($enable_bbcode+1) << 8) + (($enable_smilies+1) << 4) + (($enable_urls+1) << 2) + (($enable_sig+1) << 1);
			$status_switch = ($status_switch != $check_value);
		}
		else
		{
			$status_switch = 1;
		}

		// Parse Attachments - before checksum is calculated
		$message_parser->parse_attachments('fileupload', $action, 0, $submit, $preview, $refresh, true);

		if (sizeof($message_parser->warn_msg) && !($remove_u || $remove_g || $add_to || $add_bcc))
		{
			$error[] = implode('<br />', $message_parser->warn_msg);
			$message_parser->warn_msg = array();
		}

		// Parse message
		$message_parser->parse($enable_bbcode, ($config['allow_post_links']) ? $enable_urls : false, $enable_smilies, $img_status, $flash_status, true, $config['allow_post_links']);

		// On a refresh we do not care about message parsing errors
		if (sizeof($message_parser->warn_msg) && !$refresh)
		{
			$error[] = implode('<br />', $message_parser->warn_msg);
		}

		if ($action != 'edit' && !$preview && !$refresh && $config['flood_interval'] && !checkaccess('u_ignoreflood'))
		{
			// Flood check
			$last_post_time = $user->lapost;

			if ($last_post_time)
			{
				if ($last_post_time && ($current_time - $last_post_time) < intval($config['flood_interval']))
				{
					$error[] = $user->lang['_FLOOD_ERROR'];
				}
			}
		}

		// Subject defined
		if ($submit)
		{
			if ($subject === '')
			{
				$error[] = $user->lang['_EMPTY_MESSAGE_SUBJECT'];
			}

			if (!sizeof($address_list))
			{
				$error[] = $user->lang['_NO_RECIPIENT'];
			}
		}

		// Store message, sync counters
		if (!sizeof($error) && $submit)
		{
			$pm_data = array(
				'msg_id'				=> (int) $msg_id,
				'from_user_id'			=> $user->id,
				'from_user_ip'			=> getip(),
				'from_username'			=> $user->name,
				'reply_from_root_level'	=> (isset($post['root_level'])) ? (int) $post['root_level'] : 0,
				'reply_from_msg_id'		=> (int) $msg_id,
				'icon_id'				=> (int) $icon_id,
				'enable_sig'			=> (bool) $enable_sig,
				'enable_bbcode'			=> (bool) $enable_bbcode,
				'enable_smilies'		=> (bool) $enable_smilies,
				'enable_urls'			=> (bool) $enable_urls,
				'bbcode_bitfield'		=> $message_parser->bbcode_bitfield,
				'bbcode_uid'			=> $message_parser->bbcode_uid,
				'message'				=> $message_parser->message,
				'attachment_data'		=> $message_parser->attachment_data,
				'filename_data'			=> $message_parser->filename_data,
				'address_list'			=> $address_list
			);
			// ((!$message_subject) ? $subject : $message_subject)
			//die(print_r($pm_data));
			$msg_id = submit_pm($action, $subject, $pm_data);

			$return_message_url = append_sid("{$siteurl}/pm.$phpEx", 'op=readmsg&amp;i=0&amp;p=' . $msg_id);
			$return_folder_url = append_sid("{$siteurl}/pm.$phpEx", 'op=folder&amp;folder=' . -2);
			meta_refresh(3, $return_message_url);

			$message = $user->lang['_MESSAGE_STORED'] . '<br /><br />' . sprintf($user->lang['_VIEW_PRIVATE_MESSAGE'], '<a href="' . $return_message_url . '">', '</a>') . '<br /><br />' . sprintf($user->lang['_CLICK_RETURN_FOLDER'], '<a href="' . $return_folder_url . '">', '</a>', $user->lang['_PM_OUTBOX']);
				trigger_error($message);

		}

		$message_subject = $subject;
	}
	// Preview
	if (!sizeof($error) && $preview)
	{
		$preview_message = $message_parser->format_display($enable_bbcode, $enable_urls, $enable_smilies, false);

		$preview_signature = $user->sig;
		$preview_signature_uid = $user->sig_bbcode_uid;
		$preview_signature_bitfield = $user->sig_bbcode_bitfield;

		// Signature
		if ($enable_sig && $config['allow_sig'] && $preview_signature)
		{
			$parse_sig = new parse_message($preview_signature);
			$parse_sig->bbcode_uid = $preview_signature_uid;
			$parse_sig->bbcode_bitfield = $preview_signature_bitfield;

			$parse_sig->format_display($config['allow_sig_bbcode'], $config['allow_sig_links'], $config['allow_sig_smilies']);
			$preview_signature = $parse_sig->message;
			unset($parse_sig);
		}
		else
		{
			$preview_signature = '';
		}

		// Attachment Preview
		if (sizeof($message_parser->attachment_data))
		{
			$template->assign_var('S_HAS_ATTACHMENTS', true);

			$update_count = array();
			$attachment_data = $message_parser->attachment_data;

			parse_attachments(false, $preview_message, $attachment_data, $update_count, true);

			foreach ($attachment_data as $i => $attachment)
			{
				$template->assign_block_vars('attachment', array(
					'DISPLAY_ATTACHMENT'	=> $attachment)
				);
			}
			unset($attachment_data);
		}

		$preview_subject = censor_text($subject);

		if (!sizeof($error))
		{
			$template->assign_vars(array(
				'PREVIEW_SUBJECT'		=> $preview_subject,
				'PREVIEW_MESSAGE'		=> $preview_message,
				'PREVIEW_SIGNATURE'		=> $preview_signature,

				'S_DISPLAY_PREVIEW'		=> true)
			);
		}
		unset($message_text);
	}

	// Decode text for message display
	$bbcode_uid = (($action == 'quote' || $action == 'forward') && !$preview && !$refresh && (!sizeof($error) || (sizeof($error) && !$submit))) ? $bbcode_uid : $message_parser->bbcode_uid;

	$message_parser->decode_message($bbcode_uid);

	if (($action == 'quote' || $action == 'quotepost') && !$preview && !$refresh && !$submit)
	{
		if ($action == 'quotepost')
		{
			$post_id = request_var('p', 0);
			if ($config['allow_post_links'])
			{
				$message_link = "[url=" . generate_board_url() . "/forum.$phpEx?action=viewtopic?p={$post_id}#p{$post_id}]{$user->lang['_SUBJECT']}: {$message_subject}[/url]\n\n";
			}
			else
			{
				$message_link = $user->lang['_SUBJECT'] . ': ' . $message_subject . " (" . generate_board_url() . "/forum.$phpEx?action=viewtopic?p={$post_id}#p{$post_id})\n\n";
			}
		}
		else
		{
			$message_link = '';
		}
		$message_parser->message = $message_link . '[quote=&quot;' . $quote_username . '&quot;]' . censor_text(trim($message_parser->message)) . "[/quote]\n";
	}

	if (($action == 'reply' || $action == 'quote' || $action == 'quotepost') && !$preview && !$refresh)
	{
		$message_subject = ((!preg_match('/^Re:/', $message_subject)) ? 'Re: ' : '') . censor_text($message_subject);
	}

	if ($action == 'forward' && !$preview && !$refresh && !$submit)
	{
		$fwd_to_field = write_pm_addresses(array('to' => $post['recipient']), 0, true);

		if ($config['allow_post_links'])
		{
			$quote_username_text = '[url=' . generate_board_url() . "/userfind_to_pm.$phpEx?mode=viewprofile&amp;u={$post['author_id']}]{$quote_username}[/url]";
		}
		else
		{
			$quote_username_text = $quote_username . ' (' . generate_board_url() . "/userfind_to_pm.$phpEx?mode=viewprofile&amp;u={$post['author_id']})";
		}

		$forward_text = array();
		$forward_text[] = $user->lang['_FWD_ORIGINAL_MESSAGE'];
		$forward_text[] = sprintf($user->lang['_FWD_SUBJECT'], censor_text($message_subject));
		$forward_text[] = sprintf($user->lang['_FWD_DATE'], $user->format_date($message_time, false, true));
		$forward_text[] = sprintf($user->lang['_FWD_FROM'], $quote_username_text);
		$forward_text[] = sprintf($user->lang['_FWD_TO'], implode(', ', $fwd_to_field['to']));

		$message_parser->message = implode("\n", $forward_text) . "\n\n[quote=&quot;{$quote_username}&quot;]\n" . censor_text(trim($message_parser->message)) . "\n[/quote]";
		$message_subject = ((!preg_match('/^Fwd:/', $message_subject)) ? 'Fwd: ' : '') . censor_text($message_subject);
	}

	$attachment_data = $message_parser->attachment_data;
	$filename_data = $message_parser->filename_data;
	$message_text = $message_parser->message;

	// MAIN PM PAGE BEGINS HERE

	// Generate smiley listing
	generate_smilies('inline', 0,true);

	// Generate PM Icons
	$s_pm_icons = false;
	if ($config['enable_pm_icons'])
	{
		$s_pm_icons = posting_gen_topic_icons($action, $icon_id);
	}

	// Generate inline attachment select box
	posting_gen_inline_attachments($attachment_data);

	// Build address list for display
	// array('u' => array($author_id => 'to'));
	if (sizeof($address_list))
	{
		// Get Usernames and Group Names
		$result = array();
		if (!empty($address_list['u']))
		{
			$template->assign_vars(array(
					'S_U_TO'         => true,
			));
			$sql = 'SELECT U.id as id, U.username as name, L.group_colour as colour
				FROM ' . $db_prefix . '_users U, ' . $db_prefix . '_level_settings L
				WHERE ' . $db->sql_in_set('id', array_map('intval', array_keys($address_list['u']))) . ' AND L.group_id = U.can_do
				ORDER BY clean_username ASC';
			$result['u'] = $db->sql_query($sql);
		}

		if (!empty($address_list['g']))
		{
			$template->assign_vars(array(
					'S_G_TO'         => true,
			));
			$sql = 'SELECT g.group_id AS id, g.group_name AS name, g.group_colour AS colour
				FROM ' . $db_prefix . '_level_settings g';

			if (!$auth->acl_gets('a_group', 'a_groupadd', 'a_groupdel'))
			{
				$sql .= ' LEFT JOIN ' . $db_prefix . '_user_group ug
					ON (
						g.group_id = ug.group_id
						AND ug.user_id = ' . $user->id . '
						AND ug.user_pending = 0
					)
					WHERE (g.group_type <> ' . 2 . ' OR ug.user_id = ' . $user->id . ')';
			}

			$sql .= ($auth->acl_gets('a_group', 'a_groupadd', 'a_groupdel')) ? ' WHERE ' : ' AND ';

			$sql .= 'g.group_receive_pm = 0
				AND ' . $db->sql_in_set('g.group_id', array_map('intval', array_keys($address_list['g']))) . '
				ORDER BY g.group_name ASC';
				//die($sql);

			$result['g'] = $db->sql_query($sql);
		}

		$u = $g = array();
		$_types = array('u', 'g');
		foreach ($_types as $type)
		{
			if (isset($result[$type]) && $result[$type])
			{
				while ($row = $db->sql_fetchrow($result[$type]))
				{
					if ($type == 'g')
					{
						$row['name'] = $row['name'];
					}
					${$type}[$row['id']] = array('name' => $row['name'], 'colour' => str_replace('#','',$row['colour']));
				}
				$db->sql_freeresult($result[$type]);
			}
		}

		// Now Build the address list
		$plain_address_field = '';
		foreach ($address_list as $type => $adr_ary)
		{
			foreach ($adr_ary as $id => $field)
			{
				if (!isset(${$type}[$id]))
				{
					unset($address_list[$type][$id]);
					continue;
				}

				$field = ($field == 'to') ? 'to' : 'bcc';
				$type = ($type == 'u') ? 'u' : 'g';
				$id = ((is_numeric($id)) ? (int) $id : $id );

				$tpl_ary = array(
					'IS_GROUP'	=> ($type == 'g') ? true : false,
					'IS_USER'	=> ($type == 'u') ? true : false,
					'UG_ID'		=> $id,
					'NAME'		=> ${$type}[$id]['name'],
					'COLOUR'	=> (${$type}[$id]['colour']) ? '#' . ${$type}[$id]['colour'] : '',
					'TYPE'		=> $type,
				);

				if ($type == 'u')
				{
					$tpl_ary = array_merge($tpl_ary, array(
						'U_VIEW'		=> get_username_string('profile', $id, ${$type}[$id]['name'], '#' . ${$type}[$id]['colour']),
						'NAME_FULL'		=> get_username_string('full', $id, ${$type}[$id]['name'], '#' . ${$type}[$id]['colour']),
					));
				}
				else
				{
					$tpl_ary = array_merge($tpl_ary, array(
						'U_VIEW'		=> append_sid("{$siteurl}/memberslist.$phpEx", 'mode=group&amp;g=' . $id),
					));
				}

				$template->assign_block_vars($field . '_recipient', $tpl_ary);
			}
		}
	}

	// Build hidden address list
	$s_hidden_address_field = build_address_field($address_list);


	$bbcode_checked		= (isset($enable_bbcode)) ? !$enable_bbcode : (($config['allow_bbcode'] && checkaccess('u_pm_bbcode')) ? '' : 1);
	$smilies_checked	= (isset($enable_smilies)) ? !$enable_smilies : (($config['allow_smilies'] && checkaccess('u_pm_smilies')) ? '' : 1);
	$urls_checked		= (isset($enable_urls)) ? !$enable_urls : 0;
	$sig_checked		= $enable_sig;

	switch ($action)
	{
		case 'post':
			$page_title = $user->lang['_POST_NEW_PM'];
		break;

		case 'quote':
			$page_title = $user->lang['_POST_QUOTE_PM'];
		break;

		case 'quotepost':
			$page_title = $user->lang['_POST_PM_POST'];
		break;

		case 'reply':
			$page_title = $user->lang['_POST_REPLY_PM'];
		break;

		case 'edit':
			$page_title = $user->lang['_POST_EDIT_PM'];
		break;

		case 'forward':
			$page_title = $user->lang['_POST_FORWARD_PM'];
		break;

		default:
			trigger_error('NO_ACTION_MODE', E_USER_ERROR);
		break;

	}

	$s_hidden_fields = '<input type="hidden" name="lastclick" value="' . $current_time . '" />';
	$s_hidden_fields .= (isset($check_value)) ? '<input type="hidden" name="status_switch" value="' . $check_value . '" />' : '';
	$s_hidden_fields .= ($draft_id || isset($_REQUEST['draft_loaded'])) ? '<input type="hidden" name="draft_loaded" value="' . ((isset($_REQUEST['draft_loaded'])) ? intval($_REQUEST['draft_loaded']) : $draft_id) . '" />' : '';

	$form_enctype = (@ini_get('file_uploads') == '0' || strtolower(@ini_get('file_uploads')) == 'off' || !$config['allow_pm_attach'] || !checkaccess('u_pm_attach')) ? '' : ' enctype="multipart/form-data"';
//echo $s_action;
	// Start assigning vars for main posting page ...
	$template->assign_vars(array(
		'L_POST_A'					=> $page_title,
		'L_ICON'					=> $user->lang['_PM_ICON'],
		'L_MESSAGE_BODY_EXPLAIN'	=> (intval($config['max_post_chars'])) ? sprintf($user->lang['_MESSAGE_BODY_EXPLAIN'], intval($config['max_post_chars'])) : '',

		'SUBJECT'				=> ($message_subject) ? $message_subject : request_var('subject', ''),
		'MESSAGE'				=> $message_text,
		'BBCODE_STATUS'			=> ($bbcode_status) ? sprintf($user->lang['_BBCODE_IS_ON'], '<a href="' . append_sid("{$siteurl}/bbcode.$phpEx") . '">', '</a>') : sprintf($user->lang['_BBCODE_IS_OFF'], '<a href="' . append_sid("{$siteurl}/bbcode.$phpEx") . '">', '</a>'),
		'IMG_STATUS'			=> ($img_status) ? $user->lang['_IMAGES_ARE_ON'] : $user->lang['_IMAGES_ARE_OFF'],
		'FLASH_STATUS'			=> ($flash_status) ? $user->lang['_FLASH_IS_ON'] : $user->lang['_FLASH_IS_OFF'],
		'SMILIES_STATUS'		=> ($smilies_status) ? $user->lang['_SMILIES_ARE_ON'] : $user->lang['_SMILIES_ARE_OFF'],
		'URL_STATUS'			=> ($url_status) ? $user->lang['_URL_IS_ON'] : $user->lang['_URL_IS_OFF'],
		'MAX_FONT_SIZE'			=> (int) $config['max_post_font_size'],
		'MINI_POST_IMG'			=> $user->img('icon_post_target', $user->lang['_PM']),
		'ERROR'					=> (sizeof($error)) ? implode('<br />', $error) : '',
		'MAX_RECIPIENTS'		=> ($config['allow_mass_pm'] && (checkaccess('u_masspm') || checkaccess('u_masspm_group'))) ? $max_recipients : 0,

		'S_COMPOSE_PM'			=> true,
		'S_EDIT_POST'			=> ($action == 'edit'),
		'S_SHOW_PM_ICONS'		=> $s_pm_icons,
		'S_BBCODE_ALLOWED'		=> ($bbcode_status) ? 1 : 0,
		'S_BBCODE_CHECKED'		=> ($bbcode_checked) ? ' checked="checked"' : '',
		'S_SMILIES_ALLOWED'		=> $smilies_status,
		'S_SMILIES_CHECKED'		=> ($smilies_checked) ? ' checked="checked"' : '',
		'S_SIG_ALLOWED'			=> ($config['allow_sig'] && $config['allow_sig_pm'] && checkaccess('u_sig')),
		'S_SIGNATURE_CHECKED'	=> ($sig_checked) ? ' checked="checked"' : '',
		'S_LINKS_ALLOWED'		=> $url_status,
		'S_MAGIC_URL_CHECKED'	=> ($urls_checked) ? ' checked="checked"' : '',
		'S_SAVE_ALLOWED'		=> (checkaccess('u_savedrafts') && $action != 'edit') ? true : false,
		'S_HAS_DRAFTS'			=> (checkaccess('u_savedrafts') && $drafts),
		'S_FORM_ENCTYPE'		=> $form_enctype,

		'S_BBCODE_IMG'			=> $img_status,
		'S_BBCODE_FLASH'		=> $flash_status,
		'S_BBCODE_QUOTE'		=> true,
		'S_BBCODE_URL'			=> $url_status,

		'S_POST_ACTION'				=> $s_action,
		'S_HIDDEN_ADDRESS_FIELD'	=> $s_hidden_address_field,
		'S_HIDDEN_FIELDS'			=> $s_hidden_fields,

		'S_CLOSE_PROGRESS_WINDOW'	=> isset($_POST['add_file']),
		'U_PROGRESS_BAR'			=> append_sid("{$siteurl}/posting.$phpEx", 'f=0&amp;mode=popup'),
		'UA_PROGRESS_BAR'			=> addslashes(append_sid("{$siteurl}/posting.$phpEx", 'f=0&amp;mode=popup')),
	));

	// Build custom bbcodes array
	//display_custom_bbcodes();
	$num_predefined_bbcodes = 22;

	$sql = 'SELECT bbcode_id, bbcode_tag, bbcode_helpline
		FROM ' . $db_prefix . '_bbcodes
		WHERE display_on_posting = 1
		ORDER BY bbcode_tag';
	$result = $db->sql_query($sql);

	$i = 0;
	while ($row = $db->sql_fetchrow($result))
	{
		// If the helpline is defined within the language file, we will use the localised version, else just use the database entry...
		if (isset($user->lang[strtoupper($row['bbcode_helpline'])]))
		{
			$row['bbcode_helpline'] = $user->lang[strtoupper($row['bbcode_helpline'])];
		}

		$template->assign_block_vars('custom_tags', array(
			'BBCODE_NAME'		=> "'[{$row['bbcode_tag']}]', '[/" . str_replace('=', '', $row['bbcode_tag']) . "]'",
			'BBCODE_ID'			=> $num_predefined_bbcodes + ($i * 2),
			'BBCODE_TAG'		=> $row['bbcode_tag'],
			'BBCODE_HELPLINE'	=> $row['bbcode_helpline'],
			'A_BBCODE_HELPLINE'	=> str_replace(array('&amp;', '&quot;', "'", '&lt;', '&gt;'), array('&', '"', "\'", '<', '>'), $row['bbcode_helpline']),
		));

		$i++;
	}
	$db->sql_freeresult($result);

	// Show attachment box for adding attachments if true
	$allowed = (checkaccess('u_pm_attach') && $config['allow_pm_attach'] && $form_enctype);

	// Attachment entry
	posting_gen_attachment_entry($attachment_data, $filename_data, $allowed);

	// Message History
	if ($action == 'reply' || $action == 'quote' || $action == 'forward')
	{
		if (message_history($msg_id, $user->id, $post, array(), true))
		{
			$template->assign_var('S_DISPLAY_HISTORY', true);
		}
	}
}

/**
* For composing messages, handle list actions
*/
function handle_message_list_actions(&$address_list, &$error, $remove_u, $remove_g, $add_to, $add_bcc)
{
	global $auth, $db, $db_prefix, $user,$sitename,$siteurl, $pmbt_cache;

	// Delete User [TO/BCC]
	if ($remove_u && !empty($_REQUEST['remove_u']) && is_array($_REQUEST['remove_u']))
	{
		$remove_user_id = array_keys($_REQUEST['remove_u']);

		if (isset($remove_user_id[0]))
		{
			unset($address_list['u'][(int) $remove_user_id[0]]);
		}
	}

	// Delete Group [TO/BCC]
	if ($remove_g && !empty($_REQUEST['remove_g']) && is_array($_REQUEST['remove_g']))
	{
		$remove_group_id = array_keys($_REQUEST['remove_g']);

		if (isset($remove_group_id[0]))
		{
			unset($address_list['g'][(int) $remove_group_id[0]]);
		}
	}

	// Add Selected Groups
	$group_list = request_var('group_user_list', array('group_user_list'));

	// Build usernames to add
	$usernames = request_var('username', '', true);
	$usernames = (empty($usernames)) ? array() : array($usernames);

	$username_list = request_var('username_list', '', true);
	if ($username_list)
	{
		$usernames = array_merge($usernames, explode("\n", $username_list));
	}

	// If add to or add bcc not pressed, users could still have usernames listed they want to add...
	if (!$add_to && !$add_bcc && (sizeof($group_list) || sizeof($usernames)))
	{
		$add_to = true;

		global $refresh, $submit, $preview,$sitename,$siteurl,$db_prefix;

		$refresh = true;
		$submit = false;

		// Preview is only true if there was also a message entered
		if (request_var('message', ''))
		{
			$preview = true;
		}
	}

	// Add User/Group [TO]
	if ($add_to || $add_bcc)
	{
		$type = ($add_to) ? 'to' : 'bcc';

		if (sizeof($group_list))
		{
			foreach ($group_list as $group_id)
			{
				$address_list['g'][$group_id] = $type;
			}
		}

		// User ID's to add...
		$user_id_ary = array();

		// Reveal the correct user_ids
		if (sizeof($usernames))
		{
			$user_id_ary = array();
			user_get_id_name($user_id_ary, $usernames, array('user', 'admin', 'premium', 'moderator'));

			// If there are users not existing, we will at least print a notice...
			if (!sizeof($user_id_ary))
			{
				$error[] = $user->lang['_PM_NO_USERS'];
			}
		}

		// Add Friends if specified
		$friend_list = (isset($_REQUEST['add_' . $type]) && is_array($_REQUEST['add_' . $type])) ? array_map('intval', array_keys($_REQUEST['add_' . $type])) : array();
		$user_id_ary = array_merge($user_id_ary, $friend_list);

		foreach ($user_id_ary as $user_id)
		{
			if ($user_id == 0)
			{
				continue;
			}

			$address_list['u'][$user_id] = $type;
		}
	}

	// Check for disallowed recipients
	if (!empty($address_list['u']))
	{
		// We need to check their PM status (do they want to receive PM's?)
		// Only check if not a moderator or admin, since they are allowed to override this user setting
		if (!checkaccess('a_override_user_pm_block'))
		{
			$sql = 'SELECT id
				FROM ' . $db_prefix . '_users
				WHERE ' . $db->sql_in_set('id', array_keys($address_list['u'])) . '
					AND user_allow_pm = 0';
			$result = $db->sql_query($sql);

			$removed = false;
			while ($row = $db->sql_fetchrow($result))
			{
				$removed = true;
				unset($address_list['u'][$row['user_id']]);
			}
			$db->sql_freeresult($result);

			// print a notice about users not being added who do not want to receive pms
			if ($removed)
			{
				$error[] = $user->lang['_PM_USERS_REMOVED_NO_PM'];
			}
		}
	}
}

/**
* Build the hidden field for the recipients. Needed, as the variable is not read via request_var.
*/
function build_address_field($address_list)
{
	$s_hidden_address_field = '';
	foreach ($address_list as $type => $adr_ary)
	{
		foreach ($adr_ary as $id => $field)
		{
			$s_hidden_address_field .= '<input type="hidden" name="address_list[' . (($type == 'u') ? 'u' : 'g') . '][' . ((is_numeric($id))?(int) $id : $id) . ']" value="' . (($field == 'to') ? 'to' : 'bcc') . '" />';
		}
	}
	return $s_hidden_address_field;
}

/**
* Return number of private message recipients
*/
function num_recipients($address_list)
{
	$num_recipients = 0;

	foreach ($address_list as $field => $adr_ary)
	{
		$num_recipients += sizeof($adr_ary);
	}

	return $num_recipients;
}

/**
* Get number of 'num_recipients' recipients from first position
*/
function get_recipients($address_list, $num_recipients = 1)
{
	$recipient = array();

	$count = 0;
	foreach ($address_list as $field => $adr_ary)
	{
		foreach ($adr_ary as $id => $type)
		{
			if ($count >= $num_recipients)
			{
				break 2;
			}
			$recipient[$field][$id] = $type;
			$count++;
		}
	}

	return $recipient;
}

?>