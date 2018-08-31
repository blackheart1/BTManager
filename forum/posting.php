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
** File posting.php 2018-02-18 14:32:00 joeroberts
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT'))
{
	include_once './../security.php';
	die ();
}
include_once 'include/message_parser.php';
include_once 'include/function_posting.php';
include_once 'include/class.bbcode.php';
$post_id	= request_var('p', 0);
$topic_id	= request_var('t', 0);
$forum_id	= request_var('f', 0);
$draft_id	= request_var('d', 0);
$lastclick	= request_var('lastclick', 0);

$submit		= (isset($_POST['post'])) ? true : false;
$preview	= (isset($_POST['preview'])) ? true : false;
$save		= (isset($_POST['save'])) ? true : false;
$load		= (isset($_POST['load'])) ? true : false;
$delete		= (isset($_POST['delete'])) ? true : false;
$cancel		= (isset($_POST['cancel']) && !isset($_POST['save'])) ? true : false;

$refresh	= (isset($_POST['add_file']) || isset($_POST['delete_file']) || isset($_POST['cancel_unglobalise']) || $save || $load) ? true : false;
$mode		= ($delete && !$preview && !$refresh && $submit) ? 'delete' : request_var('mode', '');

$error = $post_data = array();
$current_time = time();


// Was cancel pressed? If so then redirect to the appropriate page
if ($cancel || ($current_time - $lastclick < 2 && $submit))
{
	$f = ($forum_id) ? 'f=' . $forum_id . '&amp;' : '';
	$redirect = ($post_id) ? append_sid("{$phpbb_root_path}forum.$phpEx", 'action=viewtopic&amp;' . $f . 'p=' . $post_id) . '#p' . $post_id : (($topic_id) ? append_sid("{$phpbb_root_path}forum.$phpEx", 'action=viewtopic&amp;' . $f . 't=' . $topic_id) : (($forum_id) ? append_sid("{$phpbb_root_path}forum.$phpEx", 'action=viewforum&amp;f=' . $forum_id) : append_sid("{$phpbb_root_path}forum.$phpEx")));
	redirect($redirect);
}

if (in_array($mode, array('post', 'reply', 'quote', 'edit', 'delete')) && !$forum_id)
{
	trigger_error('NO_FORUM');
}

// We need to know some basic information in all cases before we do anything.
switch ($mode)
{
	case 'post':
		$sql = 'SELECT *
			FROM ' . $db_prefix . "_forums
			WHERE forum_id = $forum_id";
	break;

	case 'bump':
	case 'reply':
		if (!$topic_id)
		{
			trigger_error('NO_TOPIC');
		}

		// Force forum id
		$sql = 'SELECT forum_id
			FROM ' .$db_prefix . '_topics
			WHERE topic_id = ' . $topic_id;
		$result = $db->sql_query($sql);
		$f_id = (int) $db->sql_fetchfield('forum_id');
		$db->sql_freeresult($result);

		$forum_id = (!$f_id) ? $forum_id : $f_id;

		$sql = 'SELECT f.*, t.*
			FROM ' . $db_prefix . '_topics t, ' . $db_prefix . "_forums f
			WHERE t.topic_id = $topic_id
				AND (f.forum_id = t.forum_id
					OR f.forum_id = $forum_id)";
	break;

	case 'quote':
	case 'edit':
	case 'delete':
		if (!$post_id)
		{
			//$user->setup('posting');
			trigger_error('NO_POST');
		}

		// Force forum id
		$sql = 'SELECT forum_id
			FROM ' . $db_prefix . '_posts
			WHERE post_id = ' . $post_id;
		$result = $db->sql_query($sql);
		$f_id = (int) $db->sql_fetchfield('forum_id');
		$db->sql_freeresult($result);

		$forum_id = (!$f_id) ? $forum_id : $f_id;

		$sql = 'SELECT f.*, t.*, p.*, u.username, u.clean_username AS username_clean, u.signature AS user_sig, u.sig_bbcode_uid AS user_sig_bbcode_uid, u.sig_bbcode_bitfield AS user_sig_bbcode_bitfield
			FROM ' . $db_prefix . '_posts p, ' . $db_prefix . '_topics t, ' . $db_prefix . '_forums f, ' . $db_prefix . "_users u
			WHERE p.post_id = $post_id
				AND t.topic_id = p.topic_id
				AND u.id = p.poster_id
				AND (f.forum_id = t.forum_id
					OR f.forum_id = $forum_id)" .
				(($auth->acl_get('m_approve', $forum_id)) ? '' : 'AND p.post_approved = 1');
	break;

	case 'smilies':
			$form	= request_var('form', '');
			$area	= request_var('area', '');
				$template->assign_vars(array(
					'FORM'			=> $form,
					'AREA'			=> $area,
				));
			$sql = "SELECT * FROM ".$db_prefix."_smiles ORDER BY id ASC;";
			$smile_res = $db->sql_query($sql);
			$smile_count = 0;
			while ($smile = $db->sql_fetchrow($smile_res))
			{
				$template->assign_block_vars('smilies',array(
				'ID'			=>	$smile["id"],
				'CODE'			=>	$smile["code"],
				'FILE'			=>	$smile["file"],
				'ALT'			=>	$smile["alt"],
				'S_ROW_COUNT'	=>	$smile_count++,
				));
			}
				echo $template->fetch('smilies.html');
				close_out();
	break;

	case 'popup':
		if ($forum_id)
		{
			$sql = 'SELECT forum_style
				FROM ' . $db_prefix . '_forums
				WHERE forum_id = ' . $forum_id;
		}
		else
		{
			upload_popup();
			return;
		}
	break;

	default:
		$sql = '';
	break;
}

if (!$sql)
{
	//$user->setup('posting');
	trigger_error('NO_POST_MODE');
}

$result = $db->sql_query($sql);
$post_data = $db->sql_fetchrow($result);
$db->sql_freeresult($result);

if (!$post_data)
{
	if (!($mode == 'post' || $mode == 'bump' || $mode == 'reply'))
	{
		//$user->setup('posting');
	}
	trigger_error(($mode == 'post' || $mode == 'bump' || $mode == 'reply') ? 'NO_TOPIC' : 'NO_POST');
}

if ($mode == 'popup')
{
	upload_popup($post_data['forum_style']);
	return;
}

//$user->setup(array('posting', 'mcp', 'viewtopic'), $post_data['forum_style']);

// Use post_row values in favor of submitted ones...
$forum_id	= (!empty($post_data['forum_id'])) ? (int) $post_data['forum_id'] : (int) $forum_id;
$topic_id	= (!empty($post_data['topic_id'])) ? (int) $post_data['topic_id'] : (int) $topic_id;
$post_id	= (!empty($post_data['post_id'])) ? (int) $post_data['post_id'] : (int) $post_id;

// Need to login to passworded forum first?
if ($post_data['forum_password'])
{
	login_forum_box(array(
		'forum_id'			=> $forum_id,
		'forum_password'	=> $post_data['forum_password'])
	);
}

// Check permissions
if ($user->data['is_bot'])
{
	redirect(append_sid("{$phpbb_root_path}forum.$phpEx"));
}
// Is the user able to read within this forum?
if (!$auth->acl_get('f_read', $forum_id))
{
	$mes = '';
	if ($user->id != 0)
	{
		$mes .= $user->lang['USER_CANNOT_READ'] . '<br />';
	}
	$rd = '';
	if($post_id) $rd .= '&amp;p=' . $post_id;
	if($topic_id) $rd .= '&amp;t=' . $topic_id;
	if($forum_id) $rd .= '&amp;f=' . $forum_id;
	if($draft_id) $rd .= '&amp;d=' . $draft_id;
	$redirect = append_sid("{$phpbb_root_path}forum.php?action=posting", 'mode=' . $mode . $rd );
	$mes .= $user->lang['LOGIN_EXPLAIN_POST'];
			$gfximage = '';
                if ($gfx_check) {
                        $rnd_code = strtoupper(RandomAlpha(5));
						$hidden ['gfxcheck'] = md5($rnd_code);
                        $gfximage = "<img src=\"gfxgen.php?code=".base64_encode($rnd_code)."\">";
                }
				$hidden['op'] = 'login';
				$hidden['returnto'] = $rd;
							   $template->assign_vars(array(
							   			'U_ACTION'					=>	'user' . $phpEx,
							   			'S_ERROR'					=>	true,
										'S_ERROR_MESS'				=>	$mes,
										'S_GFX_CHECK'				=>	($gfx_check)? $gfximage : false,
										'HIDDEN'					=>	build_hidden_fields($hidden),
                                ));

echo $template->fetch('login.html');
close_out();
}

// Permission to do the action asked?
$is_authed = false;

switch ($mode)
{
	case 'post':
		if ($auth->acl_get('f_post', $forum_id))
		{
			$is_authed = true;
		}
	break;

	case 'bump':
		if ($auth->acl_get('f_bump', $forum_id))
		{
			$is_authed = true;
		}
	break;

	case 'quote':

		$post_data['post_edit_locked'] = 0;

	// no break;

	case 'reply':
		if ($auth->acl_get('f_reply', $forum_id))
		{
			$is_authed = true;
		}
	break;

	case 'edit':
		if ($user->user && $auth->acl_gets('f_edit', 'm_edit', $forum_id))
		{
			$is_authed = true;
		}
	break;

	case 'delete':
		if ($user->user && $auth->acl_gets('f_delete', 'm_delete', $forum_id))
		{
			$is_authed = true;
		}
	break;
}

if (!$is_authed)
{
	$check_auth = ($mode == 'quote') ? 'reply' : $mode;
$mes = '';
	if ($user->user)
	{
		$mes .= $user->lang['USER_CANNOT_' . strtoupper($check_auth)] . '<br />';
	}

	$mes .= $user->lang['LOGIN_EXPLAIN_' . strtoupper($mode)];
	$rd = '';
	if($post_id) $rd .= '&amp;p=' . $post_id;
	if($topic_id) $rd .= '&amp;t=' . $topic_id;
	if($forum_id) $rd .= '&amp;f=' . $forum_id;
	if($draft_id) $rd .= '&amp;d=' . $draft_id;
	$redirect = append_sid("{$phpbb_root_path}forum.php?action=posting", 'mode=' . $mode . $rd );
			$gfximage = '';
                if ($gfx_check) {
                        $rnd_code = strtoupper(RandomAlpha(5));
						$hidden ['gfxcheck'] = md5($rnd_code);
                        $gfximage = "<img src=\"gfxgen.php?code=".base64_encode($rnd_code)."\">";
                }
				$hidden['op'] = 'login';
				$hidden['returnto'] = $rd;
							   $template->assign_vars(array(
							   			'U_ACTION'					=>	'user' . $phpEx,
							   			'S_ERROR'					=>	true,
										'S_ERROR_MESS'				=>	$mes,
										'S_GFX_CHECK'				=>	($gfx_check)? $gfximage : false,
										'HIDDEN'					=>	build_hidden_fields($hidden),
                                ));

echo $template->fetch('login.html');
close_out();
}

// Is the user able to post within this forum?
if ($post_data['forum_type'] != 1 && in_array($mode, array('post', 'bump', 'quote', 'reply')))
{
	trigger_error('USER_CANNOT_FORUM_POST');
}

// Forum/Topic locked?
if (($post_data['forum_status'] == 1 || (isset($post_data['topic_status']) && $post_data['topic_status'] == 1)) && !$auth->acl_get('m_edit', $forum_id))
{
	trigger_error(($post_data['forum_status'] == 1) ? 'FORUM_LOCKED' : 'TOPIC_LOCKED');
}

// Can we edit this post ... if we're a moderator with rights then always yes
// else it depends on editing times, lock status and if we're the correct user
if ($mode == 'edit' && !$auth->acl_get('m_edit', $forum_id))
{
	if ($user->id != $post_data['poster_id'])
	{
		trigger_error('USER_CANNOT_EDIT');
	}

	if (!($post_data['post_time'] > time() - ($config['edit_time'] * 60) || !$config['edit_time']))
	{
		trigger_error('CANNOT_EDIT_TIME');
	}

	if ($post_data['post_edit_locked'])
	{
		trigger_error('CANNOT_EDIT_POST_LOCKED');
	}
}

// Handle delete mode...
if ($mode == 'delete')
{
	handle_post_delete($forum_id, $topic_id, $post_id, $post_data);
	return;
}

// Handle bump mode...
if ($mode == 'bump')
{
	if ($bump_time = bump_topic_allowed($forum_id, $post_data['topic_bumped'], $post_data['topic_last_post_time'], $post_data['topic_poster'], $post_data['topic_last_poster_id'])
	   && check_link_hash(request_var('hash', ''), "topic_{$post_data['topic_id']}"))
	{
		$db->sql_transaction('begin');

		$sql = 'UPDATE ' . $db_prefix . "_posts
			SET post_time = $current_time
			WHERE post_id = {$post_data['topic_last_post_id']}
				AND topic_id = $topic_id";
		$db->sql_query($sql);

		$sql = 'UPDATE ' . $db_prefix."_topics
			SET topic_last_post_time = $current_time,
				topic_bumped = 1,
				topic_bumper = " . $user->id . "
			WHERE topic_id = $topic_id";
		$db->sql_query($sql);

		update_post_information('forum', $forum_id);

		$sql = 'UPDATE ' . $db_prefix . "_users
			SET user_lastpost_time = $current_time
			WHERE id = " . $user->id;
		$db->sql_query($sql);

		$db->sql_transaction('commit');

		markread('post', $forum_id, $topic_id, $current_time);

		add_log('mod', $forum_id, $topic_id, 'LOG_BUMP_TOPIC', $post_data['topic_title']);

		$meta_url = append_sid("{$phpbb_root_path}forum.$phpEx", "action=viewtopic&amp;f=$forum_id&amp;t=$topic_id&amp;p={$post_data['topic_last_post_id']}") . "#p{$post_data['topic_last_post_id']}";
		meta_refresh(3, $meta_url);

		$message = $user->lang['TOPIC_BUMPED'] . '<br /><br />' . sprintf($user->lang['VIEW_MESSAGE'], '<a href="' . $meta_url . '">', '</a>');
		$message .= '<br /><br />' . sprintf($user->lang['RETURN_FORUM'], '<a href="' . append_sid("{$phpbb_root_path}forum.$phpEx", 'action=viewforum&amp;f=' . $forum_id) . '">', '</a>');

		trigger_error($message);
	}

	trigger_error('BUMP_ERROR');
}

// Subject length limiting to 60 characters if first post...
if ($mode == 'post' || ($mode == 'edit' && $post_data['topic_first_post_id'] == $post_data['post_id']))
{
	$template->assign_var('S_NEW_MESSAGE', true);
}

// Determine some vars
if (isset($post_data['poster_id']) && $post_data['poster_id'] == 0)
{
	$post_data['quote_username'] = (!empty($post_data['post_username'])) ? $post_data['post_username'] : $user->lang['GUEST'];
}
else
{
	$post_data['quote_username'] = isset($post_data['username']) ? $post_data['username'] : '';
}

$post_data['post_edit_locked']	= (isset($post_data['post_edit_locked'])) ? (int) $post_data['post_edit_locked'] : 0;
$post_data['post_subject']		= (in_array($mode, array('quote', 'edit'))) ? $post_data['post_subject'] : ((isset($post_data['topic_title'])) ? $post_data['topic_title'] : '');
$post_data['topic_time_limit']	= (isset($post_data['topic_time_limit'])) ? (($post_data['topic_time_limit']) ? (int) $post_data['topic_time_limit'] / 86400 : (int) $post_data['topic_time_limit']) : 0;
$post_data['poll_length']		= (!empty($post_data['poll_length'])) ? (int) $post_data['poll_length'] / 86400 : 0;
$post_data['poll_start']		= (!empty($post_data['poll_start'])) ? (int) $post_data['poll_start'] : 0;
$post_data['icon_id']			= (!isset($post_data['icon_id']) || in_array($mode, array('quote', 'reply'))) ? 0 : (int) $post_data['icon_id'];
$post_data['poll_options']		= array();

// Get Poll Data
if ($post_data['poll_start'])
{
	$sql = 'SELECT poll_option_text
		FROM ' . $db_prefix."_poll_options
		WHERE topic_id = $topic_id
		ORDER BY poll_option_id";
	$result = $db->sql_query($sql);

	while ($row = $db->sql_fetchrow($result))
	{
		$post_data['poll_options'][] = trim($row['poll_option_text']);
	}
	$db->sql_freeresult($result);
}

$orig_poll_options_size = sizeof($post_data['poll_options']);

$message_parser = new parse_message();

if (isset($post_data['post_text']))
{
	$post_data["post_text"] = smiley_text($post_data["post_text"],true);
	$message_parser->message = &$post_data['post_text'];
	unset($post_data['post_text']);
}

// Set some default variables
$uninit = array('post_attachment' => 0, 'poster_id' => $user->id, 'enable_magic_url' => 0, 'topic_status' => 0, 'topic_type' => 0, 'post_subject' => '', 'topic_title' => '', 'post_time' => 0, 'post_edit_reason' => '', 'notify_set' => 0);

foreach ($uninit as $var_name => $default_value)
{
	if (!isset($post_data[$var_name]))
	{
		$post_data[$var_name] = $default_value;
	}
}
unset($uninit);

// Always check if the submitted attachment data is valid and belongs to the user.
// Further down (especially in submit_post()) we do not check this again.
$message_parser->get_submitted_attachment_data($post_data['poster_id']);

if ($post_data['post_attachment'] && !$submit && !$refresh && !$preview && $mode == 'edit')
{
	// Do not change to SELECT *
	$sql = 'SELECT attach_id, is_orphan, attach_comment, real_filename
		FROM ' . $db_prefix."_attachments
		WHERE post_msg_id = $post_id
			AND in_message = 0
			AND is_orphan = 0
		ORDER BY filetime DESC";
		//die($sql);
	$result = $db->sql_query($sql);
	$message_parser->attachment_data = array_merge($message_parser->attachment_data, $db->sql_fetchrowset($result));
	$db->sql_freeresult($result);
}

if ($post_data['poster_id'] == 0)
{
	$post_data['username'] = ($mode == 'quote' || $mode == 'edit') ? trim($post_data['post_username']) : '';
}
else
{
	$post_data['username'] = ($mode == 'quote' || $mode == 'edit') ? trim($post_data['username']) : '';
}

$post_data['enable_urls'] = $post_data['enable_magic_url'];

if ($mode != 'edit')
{
	$post_data['enable_sig']		= ($config['allow_sig'] && $user->optionget('attachsig')) ? true: false;
	$post_data['enable_smilies']	= ($config['allow_smilies'] && $user->optionget('smilies')) ? true : false;
	$post_data['enable_bbcode']		= ($config['allow_bbcode'] && $user->optionget('bbcode')) ? true : false;
	$post_data['enable_urls']		= true;
}

$post_data['enable_magic_url'] = $post_data['drafts'] = false;

// User own some drafts?
if ($user->user && $auth->acl_get('u_savedrafts') && ($mode == 'reply' || $mode == 'post' || $mode == 'quote'))
{
	$sql = 'SELECT draft_id
		FROM ' . $db_prefix . '_drafts
		WHERE user_id = ' . $user->id .
			(($forum_id) ? ' AND forum_id = ' . (int) $forum_id : '') .
			(($topic_id) ? ' AND topic_id = ' . (int) $topic_id : '') .
			(($draft_id) ? " AND draft_id <> $draft_id" : '').
			'LIMIT 1';
	$result = $db->sql_query($sql);

	if ($db->sql_fetchrow($result))
	{
		$post_data['drafts'] = true;
	}
	$db->sql_freeresult($result);
}

$check_value = (($post_data['enable_bbcode']+1) << 8) + (($post_data['enable_smilies']+1) << 4) + (($post_data['enable_urls']+1) << 2) + (($post_data['enable_sig']+1) << 1);

// Check if user is watching this topic
if ($mode != 'post' && $config['allow_topic_notify'] && $user->user)
{
	$sql = 'SELECT topic_id
		FROM ' . $db_prefix . '_topics_watch
		WHERE topic_id = ' . $topic_id . '
			AND user_id = ' . $user->id;
	$result = $db->sql_query($sql);
	$post_data['notify_set'] = (int) $db->sql_fetchfield('topic_id');
	$db->sql_freeresult($result);
}

// Do we want to edit our post ?
if ($mode == 'edit' && $post_data['bbcode_uid'])
{
	$message_parser->bbcode_uid = $post_data['bbcode_uid'];
}

// HTML, BBCode, Smilies, Images and Flash status
$bbcode_status	= ($config['allow_bbcode'] && $auth->acl_get('f_bbcode', $forum_id)) ? true : false;
$smilies_status	= ($bbcode_status && $config['allow_smilies'] && $auth->acl_get('f_smilies', $forum_id)) ? true : false;
$img_status		= ($bbcode_status && $auth->acl_get('f_img', $forum_id)) ? true : false;
$url_status		= ($config['allow_post_links']) ? true : false;
$flash_status	= ($bbcode_status && $auth->acl_get('f_flash', $forum_id) && $config['allow_post_flash']) ? true : false;
$quote_status	= ($auth->acl_get('f_reply', $forum_id)) ? true : false;

// Save Draft
if ($save && $user->user && $auth->acl_get('u_savedrafts') && ($mode == 'reply' || $mode == 'post' || $mode == 'quote'))
{
	$subject = utf8_normalize_nfc(request_var('subject', '', true));
	$subject = (!$subject && $mode != 'post') ? $post_data['topic_title'] : $subject;
	$message = utf8_normalize_nfc(request_var('message', '', true));

	if ($subject && $message)
	{
		if (confirm_box(true))
		{
			$sql = 'INSERT INTO ' . $db_prefix . '_drafts ' . $db->sql_build_array('INSERT', array(
				'user_id'		=> (int) $user->id,
				'topic_id'		=> (int) $topic_id,
				'forum_id'		=> (int) $forum_id,
				'save_time'		=> (int) $current_time,
				'draft_subject'	=> (string) $subject,
				'draft_message'	=> (string) $message)
			);
			//die($sql);
			$db->sql_query($sql) or die(print_r($db->sql_error()));

			$meta_info = ($mode == 'post') ? append_sid("{$phpbb_root_path}forum.$phpEx", 'action=viewforum&amp;f=' . $forum_id) : append_sid("{$phpbb_root_path}forum.$phpEx", "action=viewtopic&amp;f=$forum_id&amp;t=$topic_id");

			meta_refresh(3, $meta_info);

			$message = $user->lang['DRAFT_SAVED'] . '<br /><br />';
			$message .= ($mode != 'post') ? sprintf($user->lang['RETURN_TOPIC'], '<a href="' . $meta_info . '">', '</a>') . '<br /><br />' : '';
			$message .= sprintf($user->lang['RETURN_FORUM'], '<a href="' . append_sid("{$phpbb_root_path}forum.$phpEx", 'action=viewforum&amp;f=' . $forum_id) . '">', '</a>');

			trigger_error($message);
		}
		else
		{
			$s_hidden_fields = build_hidden_fields(array(
				'mode'		=> $mode,
				'save'		=> true,
				'f'			=> $forum_id,
				't'			=> $topic_id,
				'subject'	=> $subject,
				'message'	=> $message,
				'attachment_data' => $message_parser->attachment_data,
				)
			);

			confirm_box(false, 'SAVE_DRAFT', $s_hidden_fields,'confirm_body.html','forum.php',$gfx_check);
		}
	}
	else
	{
		if (utf8_clean_string($subject) === '')
		{
			$error[] = $user->lang['EMPTY_SUBJECT'];
		}

		if (utf8_clean_string($message) === '')
		{
			$error[] = $user->lang['TOO_FEW_CHARS'];
		}
	}
	unset($subject, $message);
}

// Load requested Draft
if ($draft_id && ($mode == 'reply' || $mode == 'quote' || $mode == 'post') && $user->user && $auth->acl_get('u_savedrafts'))
{
	$sql = 'SELECT draft_subject, draft_message
		FROM ' . $db_prefix . "_drafts
		WHERE draft_id = $draft_id
			AND user_id = " . $user->id . ' LIMIT 1';
	$result = $db->sql_query($sql);
	$row = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);

	if ($row)
	{
		$post_data['post_subject'] = $row['draft_subject'];
		$message_parser->message = $row['draft_message'];

		$template->assign_var('S_DRAFT_LOADED', true);
	}
	else
	{
		$draft_id = 0;
	}
}

// Load draft overview
if ($load && ($mode == 'reply' || $mode == 'quote' || $mode == 'post') && $post_data['drafts'])
{
	load_drafts($topic_id, $forum_id);
}

$solved_captcha = false;

if ($submit || $preview || $refresh)
{
	$post_data['topic_cur_post_id']	= request_var('topic_cur_post_id', 0);
	$post_data['post_subject']		= utf8_normalize_nfc(request_var('subject', '', true));
	$message_parser->message		= utf8_normalize_nfc(request_var('message', '', true));

	$post_data['username']			= utf8_normalize_nfc(request_var('username', $post_data['username'], true));
	$post_data['post_edit_reason']	= (!empty($_POST['edit_reason']) && $mode == 'edit' && $auth->acl_get('m_edit', $forum_id)) ? utf8_normalize_nfc(request_var('edit_reason', '', true)) : '';

	$post_data['orig_topic_type']	= $post_data['topic_type'];
	$post_data['topic_type']		= request_var('topic_type', (($mode != 'post') ? (int) $post_data['topic_type'] : 0));
	$post_data['topic_time_limit']	= request_var('topic_time_limit', (($mode != 'post') ? (int) $post_data['topic_time_limit'] : 0));
	$post_data['icon_id']			= request_var('icon', 0);

	$post_data['enable_bbcode']		= (!$bbcode_status || isset($_POST['disable_bbcode'])) ? false : true;
	$post_data['enable_smilies']	= (!$smilies_status || isset($_POST['disable_smilies'])) ? false : true;
	$post_data['enable_urls']		= (isset($_POST['disable_magic_url'])) ? 0 : 1;
	$post_data['enable_sig']		= (!$config['allow_sig'] || !$auth->acl_get('f_sigs', $forum_id) || !$auth->acl_get('u_sig')) ? false : ((isset($_POST['attach_sig']) && $user->user) ? true : false);

	if ($config['allow_topic_notify'] && $user->user)
	{
		$notify = (isset($_POST['notify'])) ? true : false;
	}
	else
	{
		$notify = false;
	}

	$topic_lock			= (isset($_POST['lock_topic'])) ? true : false;
	$post_lock			= (isset($_POST['lock_post'])) ? true : false;
	$poll_delete		= (isset($_POST['poll_delete'])) ? true : false;

	if ($submit)
	{
		$status_switch = (($post_data['enable_bbcode']+1) << 8) + (($post_data['enable_smilies']+1) << 4) + (($post_data['enable_urls']+1) << 2) + (($post_data['enable_sig']+1) << 1);
		$status_switch = ($status_switch != $check_value);
	}
	else
	{
		$status_switch = 1;
	}

	// Delete Poll
	if ($poll_delete && $mode == 'edit' && sizeof($post_data['poll_options']) &&
		((!$post_data['poll_last_vote'] && $post_data['poster_id'] == $user->id && $auth->acl_get('f_delete', $forum_id)) || $auth->acl_get('m_delete', $forum_id)))
	{
		if ($submit && check_form_key('posting'))
		{
			$sql = 'DELETE FROM ' . $db_prefix . "_poll_options
				WHERE topic_id = $topic_id";
			$db->sql_query($sql);

			$sql = 'DELETE FROM ' . $db_prefix . "_poll_votes
				WHERE topic_id = $topic_id";
			$db->sql_query($sql);

			$topic_sql = array(
				'poll_title'		=> '',
				'poll_start' 		=> 0,
				'poll_length'		=> 0,
				'poll_last_vote'	=> 0,
				'poll_max_options'	=> 0,
				'poll_vote_change'	=> 0
			);

			$sql = 'UPDATE ' . $db_prefix.'_topics
				SET ' . $db->sql_build_array('UPDATE', $topic_sql) . "
				WHERE topic_id = $topic_id";
			$db->sql_query($sql);
		}

		$post_data['poll_title'] = $post_data['poll_option_text'] = '';
		$post_data['poll_vote_change'] = $post_data['poll_max_options'] = $post_data['poll_length'] = 0;
	}
	else
	{
		$post_data['poll_title']		= utf8_normalize_nfc(request_var('poll_title', '', true));
		$post_data['poll_length']		= request_var('poll_length', 0);
		$post_data['poll_option_text']	= utf8_normalize_nfc(request_var('poll_option_text', '', true));
		$post_data['poll_max_options']	= request_var('poll_max_options', 1);
		$post_data['poll_vote_change']	= ($auth->acl_get('f_votechg', $forum_id) && $auth->acl_get('f_vote', $forum_id) && isset($_POST['poll_vote_change'])) ? 1 : 0;
	}

	// If replying/quoting and last post id has changed
	// give user option to continue submit or return to post
	// notify and show user the post made between his request and the final submit
	if (($mode == 'reply' || $mode == 'quote') && $post_data['topic_cur_post_id'] && $post_data['topic_cur_post_id'] != $post_data['topic_last_post_id'])
	{
		// Only do so if it is allowed forum-wide
		if ($post_data['forum_flags'] & 32)
		{
			if (topic_review($topic_id, $forum_id, 'post_review', $post_data['topic_cur_post_id']))
			{
				$template->assign_var('S_POST_REVIEW', true);
			}

			$submit = false;
			$refresh = true;
		}
	}

	// Parse Attachments - before checksum is calculated
	$message_parser->parse_attachments('fileupload', $mode, $forum_id, $submit, $preview, $refresh);

	// Grab md5 'checksum' of new message
	$message_md5 = md5($message_parser->message);

	// Check checksum ... don't re-parse message if the same
	$update_message = ($mode != 'edit' || $message_md5 != $post_data['post_checksum'] || $status_switch || strlen($post_data['bbcode_uid']) < 8) ? true : false;

	// Parse message
	if ($update_message)
	{
		if (sizeof($message_parser->warn_msg))
		{
			$error[] = implode('<br />', $message_parser->warn_msg);
			$message_parser->warn_msg = array();
		}

		$message_parser->parse($post_data['enable_bbcode'], ($config['allow_post_links']) ? $post_data['enable_urls'] : false, $post_data['enable_smilies'], $img_status, $flash_status, $quote_status, $config['allow_post_links']);

		// On a refresh we do not care about message parsing errors
		if (sizeof($message_parser->warn_msg) && $refresh)
		{
			$message_parser->warn_msg = array();
		}
	}
	else
	{
		$message_parser->bbcode_bitfield = $post_data['bbcode_bitfield'];
	}

	if ($mode != 'edit' && !$preview && !$refresh && $config['flood_interval'] && !$auth->acl_get('f_ignoreflood', $forum_id))
	{
		// Flood check
		$last_post_time = 0;

		if ($user->user)
		{
			$last_post_time = $user->lastpost;
		}
		else
		{
			$sql = 'SELECT post_time AS last_post_time
				FROM ' . $db_prefix . "_posts
				WHERE poster_ip = '" . $user->ip . "'
					AND post_time > " . ($current_time - $config['flood_interval']);
			$result = $db->sql_query($sql . " LIMIT 1");
			if ($row = $db->sql_fetchrow($result))
			{
				$last_post_time = $row['last_post_time'];
			}
			$db->sql_freeresult($result);
		}

		if ($last_post_time && ($current_time - $last_post_time) < intval($config['flood_interval']))
		{
			$error[] = $user->lang['FLOOD_ERROR'];
		}
	}

	// Validate username
	if (($post_data['username'] && !$user->user) || ($mode == 'edit' && $post_data['poster_id'] == 0 && $post_data['username'] && $post_data['post_username'] && $post_data['post_username'] != $post_data['username']))
	{
		include($phpbb_root_path . 'includes/functions_user.' . $phpEx);

		if (($result = validate_username($post_data['username'], (!empty($post_data['post_username'])) ? $post_data['post_username'] : '')) !== false)
		{
			$user->add_lang('ucp');
			$error[] = $user->lang[$result . '_USERNAME'];
		}
	}

	if ($config['enable_post_confirm'] && !$user->user && in_array($mode, array('quote', 'post', 'reply')))
	{
		$confirm_id = request_var('confirm_id', '');
		$confirm_code = request_var('confirm_code', '');

		$sql = 'SELECT code
			FROM ' . $db_prefix . "_confirm
			WHERE confirm_id = '" . $db->sql_escape($confirm_id) . "'
				AND session_id = '" . $db->sql_escape($user->session_id) . "'
				AND confirm_type = " . 3;
		$result = $db->sql_query($sql);
		$confirm_row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		if (empty($confirm_row['code']) || strcasecmp($confirm_row['code'], $confirm_code) !== 0)
		{
			$error[] = $user->lang['CONFIRM_CODE_WRONG'];
		}
		else
		{
			$solved_captcha = true;
		}
	}

	// check form
	if (($submit || $preview) && !check_form_key('posting'))
	{
		$error[] = $user->lang['FORM_INVALID'];
	}

	// Parse subject
	if (!$preview && !$refresh && utf8_clean_string($post_data['post_subject']) === '' && ($mode == 'post' || ($mode == 'edit' && $post_data['topic_first_post_id'] == $post_id)))
	{
		$error[] = $user->lang['EMPTY_SUBJECT'];
	}

	$post_data['poll_last_vote'] = (isset($post_data['poll_last_vote'])) ? $post_data['poll_last_vote'] : 0;

	if ($post_data['poll_option_text'] &&
		($mode == 'post' || ($mode == 'edit' && $post_id == $post_data['topic_first_post_id']/* && (!$post_data['poll_last_vote'] || $auth->acl_get('m_edit', $forum_id))*/))
		&& $auth->acl_get('f_poll', $forum_id))
	{
		$poll = array(
			'poll_title'		=> $post_data['poll_title'],

			'poll_length'		=> $post_data['poll_length'],
			'poll_max_options'	=> $post_data['poll_max_options'],
			'poll_option_text'	=> $post_data['poll_option_text'],
			'poll_start'		=> $post_data['poll_start'],
			'poll_last_vote'	=> $post_data['poll_last_vote'],
			'poll_vote_change'	=> $post_data['poll_vote_change'],
			'enable_bbcode'		=> $post_data['enable_bbcode'],
			'enable_urls'		=> $post_data['enable_urls'],
			'enable_smilies'	=> $post_data['enable_smilies'],
			'img_status'		=> $img_status
		);

		$message_parser->parse_poll($poll);

		$post_data['poll_options'] = (isset($poll['poll_options'])) ? $poll['poll_options'] : '';
		$post_data['poll_title'] = (isset($poll['poll_title'])) ? $poll['poll_title'] : '';

		/* We reset votes, therefore also allow removing options
		if ($post_data['poll_last_vote'] && ($poll['poll_options_size'] < $orig_poll_options_size))
		{
			$message_parser->warn_msg[] = $user->lang['NO_DELETE_POLL_OPTIONS'];
		}*/
	}
	else
	{
		$poll = array();
	}

	// Check topic type
	if ($post_data['topic_type'] != 0 && ($mode == 'post' || ($mode == 'edit' && $post_data['topic_first_post_id'] == $post_id)))
	{
		switch ($post_data['topic_type'])
		{
			case 3:
			case 2:
				$auth_option = 'f_announce';
			break;

			case 1:
				$auth_option = 'f_sticky';
			break;

			default:
				$auth_option = '';
			break;
		}

		if (!$auth->acl_get($auth_option, $forum_id))
		{
			// There is a special case where a user edits his post whereby the topic type got changed by an admin/mod.
			// Another case would be a mod not having sticky permissions for example but edit permissions.
			if ($mode == 'edit')
			{
				// To prevent non-authed users messing around with the topic type we reset it to the original one.
				$post_data['topic_type'] = $post_data['orig_topic_type'];
			}
			else
			{
				$error[] = $user->lang['CANNOT_POST_' . str_replace('F_', '', strtoupper($auth_option))];
			}
		}
	}

	if (sizeof($message_parser->warn_msg))
	{
		$error[] = implode('<br />', $message_parser->warn_msg);
	}

	// DNSBL check
	if ($config['check_dnsbl'] && !$refresh)
	{
		if (($dnsbl = $user->check_dnsbl('post')) !== false)
		{
			$error[] = sprintf($user->lang['IP_BLACKLISTED'], $user->ip, $dnsbl[1]);
		}
	}

	// Store message, sync counters
	if (!sizeof($error) && $submit)
	{
		// Check if we want to de-globalize the topic... and ask for new forum
		if ($post_data['topic_type'] != 3)
		{
			$sql = 'SELECT topic_type, forum_id
				FROM ' . $db_prefix."_topics
				WHERE topic_id = $topic_id";
			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			if ($row && !$row['forum_id'] && $row['topic_type'] == 3)
			{
				$to_forum_id = request_var('to_forum_id', 0);

				if ($to_forum_id)
				{
					$sql = 'SELECT forum_type
						FROM ' . $db_prefix . '_forums
						WHERE forum_id = ' . $to_forum_id;
					$result = $db->sql_query($sql);
					$forum_type = (int) $db->sql_fetchfield('forum_type');
					$db->sql_freeresult($result);

					if ($forum_type != 1 || !$auth->acl_get('f_post', $to_forum_id))
					{
						$to_forum_id = 0;
					}
				}

				if (!$to_forum_id)
				{
					include_once($phpbb_root_path . 'includes/functions_admin.' . $phpEx);

					$template->assign_vars(array(
						'S_FORUM_SELECT'	=> make_forum_select(false, false, false, true, true, true),
						'S_UNGLOBALISE'		=> true)
					);

					$submit = false;
					$refresh = true;
				}
				else
				{
					if (!$auth->acl_get('f_post', $to_forum_id))
					{
						// This will only be triggered if the user tried to trick the forum.
						trigger_error('NOT_AUTHORISED');
					}

					$forum_id = $to_forum_id;
				}
			}
		}

		if ($submit)
		{
			// Lock/Unlock Topic
			$change_topic_status = $post_data['topic_status'];
			$perm_lock_unlock = ($auth->acl_get('m_lock', $forum_id) || ($auth->acl_get('f_user_lock', $forum_id) && $user->user && !empty($post_data['topic_poster']) && $user->id == $post_data['topic_poster'] && $post_data['topic_status'] == 0)) ? true : false;

			if ($post_data['topic_status'] == 1 && !$topic_lock && $perm_lock_unlock)
			{
				$change_topic_status = 0;
			}
			else if ($post_data['topic_status'] == 0 && $topic_lock && $perm_lock_unlock)
			{
				$change_topic_status = 1;
			}

			if ($change_topic_status != $post_data['topic_status'])
			{
				$sql = 'UPDATE ' . $db_prefix."_topics
					SET topic_status = $change_topic_status
					WHERE topic_id = $topic_id
						AND topic_moved_id = 0";
				$db->sql_query($sql);

				$user_lock = ($auth->acl_get('f_user_lock', $forum_id) && $user->user && $user->id == $post_data['topic_poster']) ? 'USER_' : '';

				add_log('mod', $forum_id, $topic_id, 'LOG_' . $user_lock . (($change_topic_status == 1) ? 'LOCK' : 'UNLOCK'), $post_data['topic_title']);
			}

			// Lock/Unlock Post Edit
			if ($mode == 'edit' && $post_data['post_edit_locked'] == 1 && !$post_lock && $auth->acl_get('m_edit', $forum_id))
			{
				$post_data['post_edit_locked'] = 0;
			}
			else if ($mode == 'edit' && $post_data['post_edit_locked'] == 0 && $post_lock && $auth->acl_get('m_edit', $forum_id))
			{
				$post_data['post_edit_locked'] = 1;
			}

			$data = array(
				'topic_title'			=> (empty($post_data['topic_title'])) ? $post_data['post_subject'] : $post_data['topic_title'],
				'topic_first_post_id'	=> (isset($post_data['topic_first_post_id'])) ? (int) $post_data['topic_first_post_id'] : 0,
				'topic_last_post_id'	=> (isset($post_data['topic_last_post_id'])) ? (int) $post_data['topic_last_post_id'] : 0,
				'topic_time_limit'		=> (int) $post_data['topic_time_limit'],
				'topic_attachment'		=> (isset($post_data['topic_attachment'])) ? (int) $post_data['topic_attachment'] : 0,
				'post_id'				=> (int) $post_id,
				'topic_id'				=> (int) $topic_id,
				'forum_id'				=> (int) $forum_id,
				'icon_id'				=> (int) $post_data['icon_id'],
				'poster_id'				=> (int) $post_data['poster_id'],
				'enable_sig'			=> (bool) $post_data['enable_sig'],
				'enable_bbcode'			=> (bool) $post_data['enable_bbcode'],
				'enable_smilies'		=> (bool) $post_data['enable_smilies'],
				'enable_urls'			=> (bool) $post_data['enable_urls'],
				'enable_indexing'		=> (bool) $post_data['enable_indexing'],
				'message_md5'			=> (string) $message_md5,
				'post_time'				=> (isset($post_data['post_time'])) ? (int) $post_data['post_time'] : $current_time,
				'post_checksum'			=> (isset($post_data['post_checksum'])) ? (string) $post_data['post_checksum'] : '',
				'post_edit_reason'		=> $post_data['post_edit_reason'],
				'post_edit_user'		=> ($mode == 'edit') ? $user->id : ((isset($post_data['post_edit_user'])) ? (int) $post_data['post_edit_user'] : 0),
				'forum_parents'			=> $post_data['forum_parents'],
				'forum_name'			=> $post_data['forum_name'],
				'notify'				=> $notify,
				'notify_set'			=> $post_data['notify_set'],
				'poster_ip'				=> (isset($post_data['poster_ip'])) ? $post_data['poster_ip'] : $user->ip,
				'post_edit_locked'		=> (int) $post_data['post_edit_locked'],
				'bbcode_bitfield'		=> $message_parser->bbcode_bitfield,
				'bbcode_uid'			=> $message_parser->bbcode_uid,
				'message'				=> $message_parser->message,
				'attachment_data'		=> $message_parser->attachment_data,
				'filename_data'			=> $message_parser->filename_data,

				'topic_approved'		=> (isset($post_data['topic_approved'])) ? $post_data['topic_approved'] : false,
				'post_approved'			=> (isset($post_data['post_approved'])) ? $post_data['post_approved'] : false,
			);

			if ($mode == 'edit')
			{
				$data['topic_replies_real'] = $post_data['topic_replies_real'];
				$data['topic_replies'] = $post_data['topic_replies'];
			}

			$redirect_url = submit_post($mode, $post_data['post_subject'], $post_data['username'], $post_data['topic_type'], $poll, $data, $update_message);

			// Check the permissions for post approval, as well as the queue trigger where users are put on approval with a post count lower than specified. Moderators are not affected.
			if ((($config['enable_queue_trigger'] && $user->posts < $config['queue_trigger_posts']) || !$auth->acl_get('f_noapprove', $data['forum_id'])) && !$auth->acl_get('m_approve', $data['forum_id']))
			{
				meta_refresh(10, urldecode($redirect_url));
				$message = ($mode == 'edit') ? $user->lang['POST_EDITED_MOD'] : $user->lang['POST_STORED_MOD'];
				$message .= (($user->id == 0) ? '' : ' '. $user->lang['POST_APPROVAL_NOTIFY']);
			}
			else
			{
				meta_refresh(3, rawurldecode($redirect_url));

				$message = ($mode == 'edit') ? 'POST_EDITED' : 'POST_STORED';
				$message = $user->lang[$message] . '<br /><br />' . sprintf($user->lang['VIEW_MESSAGE'], '<a href="' . $redirect_url . '">', '</a>');
			}

			$message .= '<br /><br />' . sprintf($user->lang['RETURN_FORUM'], '<a href="' . append_sid("{$phpbb_root_path}forum.$phpEx", 'action=viewforum&amp;f=' . $data['forum_id']) . '">', '</a>');
			trigger_error($message);
		}
	}
}

// Preview
if (!sizeof($error) && $preview)
{
	$post_data['post_time'] = ($mode == 'edit') ? $post_data['post_time'] : $current_time;

	$preview_message = $message_parser->format_display($post_data['enable_bbcode'], $post_data['enable_urls'], $post_data['enable_smilies'], false);

	$preview_signature = ($mode == 'edit') ? $post_data['sig'] : $user->sig;
	$preview_signature_uid = ($mode == 'edit') ? $post_data['sig_bbcode_uid'] : $user->sig_bbcode_uid;
	$preview_signature_bitfield = ($mode == 'edit') ? $post_data['sig_bbcode_bitfield'] : $user->sig_bbcode_bitfield;

	// Signature
	if ($post_data['enable_sig'] && $config['allow_sig'] && $preview_signature && $auth->acl_get('f_sigs', $forum_id))
	{
		$parse_sig = new parse_message($preview_signature);
		$parse_sig->bbcode_uid = $preview_signature_uid;
		$parse_sig->bbcode_bitfield = $preview_signature_bitfield;

		// Not sure about parameters for bbcode/smilies/urls... in signatures
		$parse_sig->format_display($config['allow_sig_bbcode'], true, $config['allow_sig_smilies']);
		$preview_signature = $parse_sig->message;
		unset($parse_sig);
	}
	else
	{
		$preview_signature = '';
	}

	$preview_subject = censor_text($post_data['post_subject']);

	// Poll Preview
	if (!$poll_delete && ($mode == 'post' || ($mode == 'edit' && $post_id == $post_data['topic_first_post_id']/* && (!$post_data['poll_last_vote'] || $auth->acl_get('m_edit', $forum_id))*/))
	&& $auth->acl_get('f_poll', $forum_id))
	{
		$parse_poll = new parse_message($post_data['poll_title']);
		$parse_poll->bbcode_uid = $message_parser->bbcode_uid;
		$parse_poll->bbcode_bitfield = $message_parser->bbcode_bitfield;

		$parse_poll->format_display($post_data['enable_bbcode'], $post_data['enable_urls'], $post_data['enable_smilies']);

		if ($post_data['poll_length'])
		{
			$poll_end = ($post_data['poll_length'] * 86400) + (($post_data['poll_start']) ? $post_data['poll_start'] : time());
		}

		$template->assign_vars(array(
			'S_HAS_POLL_OPTIONS'	=> (sizeof($post_data['poll_options'])),
			'S_IS_MULTI_CHOICE'		=> ($post_data['poll_max_options'] > 1) ? true : false,

			'POLL_QUESTION'		=> $parse_poll->message,

			'L_POLL_LENGTH'		=> ($post_data['poll_length']) ? sprintf($user->lang['POLL_RUN_TILL'], $user->format_date($poll_end)) : '',
			'L_MAX_VOTES'		=> ($post_data['poll_max_options'] == 1) ? $user->lang['MAX_OPTION_SELECT'] : sprintf($user->lang['MAX_OPTIONS_SELECT'], $post_data['poll_max_options']))
		);

		$parse_poll->message = implode("\n", $post_data['poll_options']);
		$parse_poll->format_display($post_data['enable_bbcode'], $post_data['enable_urls'], $post_data['enable_smilies']);
		$preview_poll_options = explode('<br />', $parse_poll->message);
		unset($parse_poll);

		foreach ($preview_poll_options as $key => $option)
		{
			$template->assign_block_vars('poll_option', array(
				'POLL_OPTION_CAPTION'	=> $option,
				'POLL_OPTION_ID'		=> $key + 1)
			);
		}
		unset($preview_poll_options);
	}

	// Attachment Preview
	if (sizeof($message_parser->attachment_data))
	{
		$template->assign_var('S_HAS_ATTACHMENTS', true);

		$update_count = array();
		$attachment_data = $message_parser->attachment_data;

		parse_attachments($forum_id, $preview_message, $attachment_data, $update_count, true);

		foreach ($attachment_data as $i => $attachment)
		{
			$template->assign_block_vars('attachment', array(
				'DISPLAY_ATTACHMENT'	=> $attachment)
			);
		}
		unset($attachment_data);
	}

	if (!sizeof($error))
	{
		$template->assign_vars(array(
			'PREVIEW_SUBJECT'		=> $preview_subject,
			'PREVIEW_MESSAGE'		=> $preview_message,
			'PREVIEW_SIGNATURE'		=> $preview_signature,

			'S_DISPLAY_PREVIEW'		=> true)
		);
	}
}

// Decode text for message display
$post_data['bbcode_uid'] = ($mode == 'quote' && !$preview && !$refresh && !sizeof($error)) ? $post_data['bbcode_uid'] : $message_parser->bbcode_uid;
$message_parser->decode_message($post_data['bbcode_uid']);

if ($mode == 'quote' && !$submit && !$preview && !$refresh)
{
	$message_parser->message = '[quote=&quot;' . $post_data['quote_username'] . '&quot;]' . censor_text(trim($message_parser->message)) . "[/quote]\n";
}

if (($mode == 'reply' || $mode == 'quote') && !$submit && !$preview && !$refresh)
{
	$post_data['post_subject'] = ((strpos($post_data['post_subject'], 'Re: ') !== 0) ? 'Re: ' : '') . censor_text($post_data['post_subject']);
}

$attachment_data = $message_parser->attachment_data;
$filename_data = $message_parser->filename_data;
$post_data['post_text'] = $message_parser->message;

if (sizeof($post_data['poll_options']) && $post_data['poll_title'])
{
	$message_parser->message = $post_data['poll_title'];
	$message_parser->bbcode_uid = $post_data['bbcode_uid'];

	$message_parser->decode_message();
	$post_data['poll_title'] = $message_parser->message;

	$message_parser->message = implode("\n", $post_data['poll_options']);
	$message_parser->decode_message();
	$post_data['poll_options'] = explode("\n", $message_parser->message);
}

// MAIN POSTING PAGE BEGINS HERE

// Forum moderators?
$moderators = array();
get_moderators($moderators, $forum_id);

// Generate smiley listing
generate_smilies('inline', $forum_id,true);

// Generate inline attachment select box
posting_gen_inline_attachments($attachment_data);

// Do show topic type selection only in first post.
$topic_type_toggle = false;

if ($mode == 'post' || ($mode == 'edit' && $post_id == $post_data['topic_first_post_id']))
{
	$topic_type_toggle = posting_gen_topic_types($forum_id, $post_data['topic_type']);
}

$s_topic_icons = false;
if ($post_data['enable_icons'] && $auth->acl_get('f_icons', $forum_id))
{
	$s_topic_icons = posting_gen_topic_icons($mode, $post_data['icon_id']);
}

$bbcode_checked		= (isset($post_data['enable_bbcode'])) ? !$post_data['enable_bbcode'] : (($config['allow_bbcode']) ? !$user->optionget('bbcode') : 1);
$smilies_checked	= (isset($post_data['enable_smilies'])) ? !$post_data['enable_smilies'] : (($config['allow_smilies']) ? !$user->optionget('smilies') : 1);
$urls_checked		= (isset($post_data['enable_urls'])) ? !$post_data['enable_urls'] : 0;
$sig_checked		= $post_data['enable_sig'];
$lock_topic_checked	= (isset($topic_lock) && $topic_lock) ? $topic_lock : (($post_data['topic_status'] == 1) ? 1 : 0);
$lock_post_checked	= (isset($post_lock)) ? $post_lock : $post_data['post_edit_locked'];

// If the user is replying or posting and not already watching this topic but set to always being notified we need to overwrite this setting
$notify_set			= ($mode != 'edit' && $config['allow_topic_notify'] && $user->user && !$post_data['notify_set']) ? $user->user_notify : $post_data['notify_set'];
$notify_checked		= (isset($notify)) ? $notify : (($mode == 'post') ? $user->user_notify : $notify_set);

// Page title & action URL, include session_id for security purpose
$s_action = append_sid("{$phpbb_root_path}forum.$phpEx", "action=posting&amp;mode=$mode&amp;f=$forum_id", true, $user->session_id);
$s_action .= ($topic_id) ? "&amp;t=$topic_id" : '';
$s_action .= ($post_id) ? "&amp;p=$post_id" : '';

switch ($mode)
{
	case 'post':
		$page_title = $user->lang['POST_TOPIC'];
	break;

	case 'quote':
	case 'reply':
		$page_title = $user->lang['POST_REPLY'];
	break;

	case 'delete':
	case 'edit':
		$page_title = $user->lang['EDIT_POST'];
	break;
}

// Build Navigation Links
generate_forum_nav($post_data);

// Build Forum Rules
generate_forum_rules($post_data);

if ($config['enable_post_confirm'] && !$user->user && $solved_captcha === false && ($mode == 'post' || $mode == 'reply' || $mode == 'quote'))
{
	// Show confirm image
	$sql = 'DELETE FROM ' . $db_prefix . "_confirm
		WHERE session_id = '" . $db->sql_escape($user->session_id) . "'
			AND confirm_type = " . 3;
	$db->sql_query($sql);

	// Generate code
	$code = gen_rand_string(mt_rand(4, 7));
	$confirm_id = md5(unique_id($user->ip));
	$seed = hexdec(substr(unique_id(), 4, 10));

	// compute $seed % 0x7fffffff
	$seed -= 0x7fffffff * floor($seed / 0x7fffffff);

	$sql = 'INSERT INTO ' . $db_prefix . '_confirm ' . $db->sql_build_array('INSERT', array(
		'confirm_id'	=> (string) $confirm_id,
		'session_id'	=> (string) $user->session_id,
		'confirm_type'	=> (int) 3,
		'code'			=> (string) $code,
		'seed'			=> (int) $seed)
	);
	$db->sql_query($sql);

	$template->assign_vars(array(
		'S_CONFIRM_CODE'			=> true,
		'CONFIRM_ID'				=> $confirm_id,
		'CONFIRM_IMAGE'				=> '<img src="' . append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=confirm&amp;id=' . $confirm_id . '&amp;type=' . 3) . '" alt="" title="" />',
		'L_POST_CONFIRM_EXPLAIN'	=> sprintf($user->lang['POST_CONFIRM_EXPLAIN'], '<a href="mailto:' . htmlspecialchars($config['board_contact']) . '">', '</a>'),
	));
}

$s_hidden_fields = ($mode == 'reply' || $mode == 'quote') ? '<input type="hidden" name="topic_cur_post_id" value="' . $post_data['topic_last_post_id'] . '" />' : '';
$s_hidden_fields .= '<input type="hidden" name="lastclick" value="' . $current_time . '" />';
$s_hidden_fields .= ($draft_id || isset($_REQUEST['draft_loaded'])) ? '<input type="hidden" name="draft_loaded" value="' . request_var('draft_loaded', $draft_id) . '" />' : '';

// Add the confirm id/code pair to the hidden fields, else an error is displayed on next submit/preview
if ($solved_captcha !== false)
{
	$s_hidden_fields .= build_hidden_fields(array(
		'confirm_id'		=> request_var('confirm_id', ''),
		'confirm_code'		=> request_var('confirm_code', ''))
	);
}

$form_enctype = (@ini_get('file_uploads') == '0' || strtolower(@ini_get('file_uploads')) == 'off' || !$config['allow_attachments'] || !$auth->acl_get('u_attach') || !$auth->acl_get('f_attach', $forum_id)) ? '' : ' enctype="multipart/form-data"';
add_form_key('posting');


// Start assigning vars for main posting page ...
$template->assign_vars(array(
	'L_POST_A'					=> $page_title,
	'L_ICON'					=> ($mode == 'reply' || $mode == 'quote' || ($mode == 'edit' && $post_id != $post_data['topic_first_post_id'])) ? $user->lang['POST_ICON'] : $user->lang['TOPIC_ICON'],
	'L_MESSAGE_BODY_EXPLAIN'	=> (intval($config['max_post_chars'])) ? sprintf($user->lang['MESSAGE_BODY_EXPLAIN'], intval($config['max_post_chars'])) : '',
	'T_TEMPLATE_PATH'			=>	$siteurl . '/themes/' . $theme . '/templates',
	'FORUM_NAME'			=> $post_data['forum_name'],
	'FORUM_DESC'			=> ($post_data['forum_desc']) ? generate_text_for_display($post_data['forum_desc'], $post_data['forum_desc_uid'], $post_data['forum_desc_bitfield'], $post_data['forum_desc_options']) : '',
	'TOPIC_TITLE'			=> censor_text($post_data['topic_title']),
	'MODERATORS'			=> (sizeof($moderators)) ? implode(', ', $moderators[$forum_id]) : '',
	'USERNAME'				=> ((!$preview && $mode != 'quote') || $preview) ? $post_data['username'] : '',
	'SUBJECT'				=> $post_data['post_subject'],
	'MESSAGE'				=> $post_data['post_text'],
	'BBCODE_STATUS'			=> ($bbcode_status) ? sprintf($user->lang['BBCODE_IS_ON'], '<a href="' . append_sid("{$phpbb_root_path}bbcode.$phpEx") . '">', '</a>') : sprintf($user->lang['BBCODE_IS_OFF'], '<a href="' . append_sid("{$phpbb_root_path}faq.$phpEx", 'mode=bbcode') . '">', '</a>'),
	'IMG_STATUS'			=> ($img_status) ? $user->lang['IMAGES_ARE_ON'] : $user->lang['IMAGES_ARE_OFF'],
	'FLASH_STATUS'			=> ($flash_status) ? $user->lang['FLASH_IS_ON'] : $user->lang['FLASH_IS_OFF'],
	'SMILIES_STATUS'		=> ($smilies_status) ? $user->lang['SMILIES_ARE_ON'] : $user->lang['SMILIES_ARE_OFF'],
	'URL_STATUS'			=> ($bbcode_status && $url_status) ? $user->lang['URL_IS_ON'] : $user->lang['URL_IS_OFF'],
	'MAX_FONT_SIZE'			=> (int) $config['max_post_font_size'],
	'MINI_POST_IMG'			=> $user->img('icon_post_target', $user->lang['POST']),
	'POST_DATE'				=> ($post_data['post_time']) ? $user->format_date($post_data['post_time']) : '',
	'ERROR'					=> (sizeof($error)) ? implode('<br />', $error) : '',
	'TOPIC_TIME_LIMIT'		=> (int) $post_data['topic_time_limit'],
	'EDIT_REASON'			=> $post_data['post_edit_reason'],
	'U_VIEW_FORUM'			=> append_sid("{$phpbb_root_path}forum.$phpEx", "action=viewforum&amp;f=$forum_id"),
	'U_VIEW_TOPIC'			=> ($mode != 'post') ? append_sid("{$phpbb_root_path}forum.$phpEx", "action=viewtopic&amp;f=$forum_id&amp;t=$topic_id") : '',
	'U_PROGRESS_BAR'		=> append_sid("{$phpbb_root_path}forum.$phpEx", "action=posting&amp;f=$forum_id&amp;mode=popup"),
	'UA_PROGRESS_BAR'		=> addslashes(append_sid("{$phpbb_root_path}forum.$phpEx", "action=posting&amp;f=$forum_id&amp;mode=popup")),

	'S_PRIVMSGS'				=> false,
	'S_CLOSE_PROGRESS_WINDOW'	=> (isset($_POST['add_file'])) ? true : false,
	'S_EDIT_POST'				=> ($mode == 'edit') ? true : false,
	'S_EDIT_REASON'				=> ($mode == 'edit' && $auth->acl_get('m_edit', $forum_id)) ? true : false,
	'S_DISPLAY_USERNAME'		=> (!$user->user || ($mode == 'edit' && $post_data['poster_id'] == 0)) ? true : false,
	'S_SHOW_TOPIC_ICONS'		=> $s_topic_icons,
	'S_DELETE_ALLOWED'			=> ($mode == 'edit' && (($post_id == $post_data['topic_last_post_id'] && $post_data['poster_id'] == $user->id && $auth->acl_get('f_delete', $forum_id) && !$post_data['post_edit_locked'] && ($post_data['post_time'] > time() - ($config['edit_time'] * 60) || !$config['edit_time'])) || $auth->acl_get('m_delete', $forum_id))) ? true : false,
	'S_BBCODE_ALLOWED'			=> $bbcode_status,
	'S_BBCODE_CHECKED'			=> ($bbcode_checked) ? ' checked="checked"' : '',
	'S_SMILIES_ALLOWED'			=> $smilies_status,
	'S_SMILIES_CHECKED'			=> ($smilies_checked) ? ' checked="checked"' : '',
	'S_SIG_ALLOWED'				=> ($auth->acl_get('f_sigs', $forum_id) && $config['allow_sig'] && $user->user) ? true : false,
	'S_SIGNATURE_CHECKED'		=> ($sig_checked) ? ' checked="checked"' : '',
	'S_NOTIFY_ALLOWED'			=> (!$user->user || ($mode == 'edit' && $user->id != $post_data['poster_id']) || !$config['allow_topic_notify'] || !$config['email_enable']) ? false : true,
	'S_NOTIFY_CHECKED'			=> ($notify_checked) ? ' checked="checked"' : '',
	'S_LOCK_TOPIC_ALLOWED'		=> (($mode == 'edit' || $mode == 'reply' || $mode == 'quote') && ($auth->acl_get('m_lock', $forum_id) || ($auth->acl_get('f_user_lock', $forum_id) && $user->user && !empty($post_data['topic_poster']) && $user->id == $post_data['topic_poster'] && $post_data['topic_status'] == 0))) ? true : false,
	'S_LOCK_TOPIC_CHECKED'		=> ($lock_topic_checked) ? ' checked="checked"' : '',
	'S_LOCK_POST_ALLOWED'		=> ($mode == 'edit' && $auth->acl_get('m_edit', $forum_id)) ? true : false,
	'S_LOCK_POST_CHECKED'		=> ($lock_post_checked) ? ' checked="checked"' : '',
	'S_LINKS_ALLOWED'			=> $url_status,
	'S_MAGIC_URL_CHECKED'		=> ($urls_checked) ? ' checked="checked"' : '',
	'S_TYPE_TOGGLE'				=> $topic_type_toggle,
	'S_SAVE_ALLOWED'			=> ($auth->acl_get('u_savedrafts') && $user->user && $mode != 'edit') ? true : false,
	'S_HAS_DRAFTS'				=> ($auth->acl_get('u_savedrafts') && $user->user && $post_data['drafts']) ? true : false,
	'S_FORM_ENCTYPE'			=> $form_enctype,

	'S_BBCODE_IMG'			=> $img_status,
	'S_BBCODE_URL'			=> $url_status,
	'S_BBCODE_FLASH'		=> $flash_status,
	'S_BBCODE_QUOTE'		=> $quote_status,

	'S_POST_ACTION'			=> $s_action,
	'S_HIDDEN_FIELDS'		=> $s_hidden_fields)
);

// Build custom bbcodes array
display_custom_bbcodes();

// Poll entry
if (($mode == 'post' || ($mode == 'edit' && $post_id == $post_data['topic_first_post_id']/* && (!$post_data['poll_last_vote'] || $auth->acl_get('m_edit', $forum_id))*/))
	&& $auth->acl_get('f_poll', $forum_id))
{
	$template->assign_vars(array(
		'S_SHOW_POLL_BOX'		=> true,
		'S_POLL_VOTE_CHANGE'	=> ($auth->acl_get('f_votechg', $forum_id) && $auth->acl_get('f_vote', $forum_id)),
		'S_POLL_DELETE'			=> ($mode == 'edit' && sizeof($post_data['poll_options']) && ((!$post_data['poll_last_vote'] && $post_data['poster_id'] == $user->id && $auth->acl_get('f_delete', $forum_id)) || $auth->acl_get('m_delete', $forum_id))),
		'S_POLL_DELETE_CHECKED'	=> (!empty($poll_delete)) ? true : false,

		'L_POLL_OPTIONS_EXPLAIN'	=> sprintf($user->lang['POLL_OPTIONS_' . (($mode == 'edit') ? 'EDIT_' : '') . 'EXPLAIN'], $config['max_poll_options']),

		'VOTE_CHANGE_CHECKED'	=> (!empty($post_data['poll_vote_change'])) ? ' checked="checked"' : '',
		'POLL_TITLE'			=> (isset($post_data['poll_title'])) ? $post_data['poll_title'] : '',
		'POLL_OPTIONS'			=> (!empty($post_data['poll_options'])) ? implode("\n", $post_data['poll_options']) : '',
		'POLL_MAX_OPTIONS'		=> (isset($post_data['poll_max_options'])) ? (int) $post_data['poll_max_options'] : 1,
		'POLL_LENGTH'			=> $post_data['poll_length'])
	);
}

// Show attachment box for adding attachments if true
$allowed = ($auth->acl_get('f_attach', $forum_id) && $auth->acl_get('u_attach') && $config['allow_attachments'] && $form_enctype);

// Attachment entry
posting_gen_attachment_entry($attachment_data, $filename_data, $allowed);

// Output page ...
//page_header($page_title);
set_site_var($page_title);

/*$template->set_filenames(array(
	'body' => 'posting_body.html')
);*/

make_jumpbox(append_sid("{$phpbb_root_path}forum.$phpEx",'action=viewforum'), $forum_id,false,false,true);

// Topic review
if ($mode == 'reply' || $mode == 'quote')
{
	if (topic_review($topic_id, $forum_id))
	{
		$template->assign_var('S_DISPLAY_REVIEW', true);
	}
}

echo $template->fetch('posting_body.html');
close_out();
?>