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
** File function_posting.php 2018-02-18 14:32:00 joeroberts
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
include_once 'include/utf/utf_tools.php';
function add_attach($form_name, $forum_id, $local = false, $local_storage = '', $is_message = false, $local_filedata = false)
{
	global $db_prefix, $user, $db, $siteurl, $config;
	$user->set_lang('pm',$user->ulanguage);
	include_once('include/function_attach.php');
	$filedata = array(
		'error'	=> array()
	);
	$upload = new fileupload();
	if (!$local)
	{
		$filedata['post_attach'] = ($upload->is_valid($form_name)) ? true : false;
	}
	else
	{
		$filedata['post_attach'] = true;
	}
	if (!$filedata['post_attach'])
	{
		$filedata['error'][] = 'NO_UPLOAD_FORM_FOUND';
		return $filedata;
	}
	$extensions = array();
$sql = 'SELECT `extension` as extension FROM `' . $db_prefix . '_extensions`';
$res = $db->sql_query($sql) OR btsqlerror($sql);
while ($ct_a = $db->sql_fetchrow($res))$extensions[] = $ct_a['extension'];
$upload->set_allowed_extensions($extensions);
	$file = ($local) ? $upload->local_upload($local_storage, $local_filedata) : $upload->form_upload($form_name);

	if ($file->init_error)
	{
		$filedata['post_attach'] = false;
		return $filedata;
	}
	$cat_id = (isset($extensions[$file->get('extension')]['display_cat'])) ? $extensions[$file->get('extension')]['display_cat'] == 1 : false;
	if ($cat_id == 1 && !$file->is_image())
	{
		$file->remove();
		bterror('BT_ERROR', 'ATTACHED_IMAGE_NOT_IMAGE');
	}
	$filedata['thumbnail'] = ($file->is_image() && $config['img_create_thumbnail']) ? 1 : 0;

	//die(print($filedata['thumbnail']));
	if (!$user->admin && $cat_id == 1)
	{
		$file->upload->set_allowed_dimensions(0, 0, $config['img_max_width'], $config['img_max_height']);
	}

	if ($user->admin)
	{
		if (!empty($extensions[$file->get('extension')]['max_filesize']))
		{
			$allowed_filesize = $extensions[$file->get('extension')]['max_filesize'];
		}
		else
		{
			$allowed_filesize = ($is_message) ? $config['max_filesize_pm'] : $config['max_filesize'];
		}

		$file->upload->set_max_filesize($allowed_filesize);
	}

	$file->clean_filename('unique', $user->id . '_');

	$no_image = ($cat_id == 1) ? false : true;

	$file->move_file($config['upload_path'], false, $no_image);

	if (sizeof($file->error))
	{
		$file->remove();
		$filedata['error'] = array_merge($filedata['error'], $file->error);
		$filedata['post_attach'] = false;

		return $filedata;
	}
	$filedata['filesize'] = $file->get('filesize');
	$filedata['mimetype'] = $file->get('mimetype');
	$filedata['extension'] = $file->get('extension');
	$filedata['physical_filename'] = $file->get('realname');
	$filedata['real_filename'] = $file->get('uploadname');
	$filedata['filetime'] = time();

	if ($config['attachment_quota'])
	{
		if ($config['upload_dir_size'] + $file->get('filesize') > $config['attachment_quota'])
		{
			$filedata['error'][] = 'ATTACH_QUOTA_REACHED';
			$filedata['post_attach'] = false;

			$file->remove();

			return $filedata;
		}
	}
	if ($free_space = @disk_free_space("/" . $config['upload_path']))
	{
		if ($free_space <= $file->get('filesize'))
		{
			$filedata['error'][] = 'ATTACH_QUOTA_REACHED';
			$filedata['post_attach'] = false;

			$file->remove();

			return $filedata;
		}
	}
		// Create Thumbnail
	/**
	 * Create thumbnail for file if necessary
	 *
	 * @return array Updated $filedata
	 */
		if ($filedata['thumbnail'])
		{
			$source = $file->get('destination_file');
			$destination = $file->get('destination_path') . '/thumb_' . $file->get('realname');

			if (!create_thumbnail($source, $destination, $file->get('mimetype')))
			{
				$filedata['thumbnail'] = 0;
			}
		}

	return $filedata;
}
function display_custom_bbcodes()
{
	global $db, $template, $user, $db_prefix;


	$sql = 'SELECT bbcode_id, bbcode_tag, bbcode_helpline
		FROM ' . $db_prefix . '_bbcodes
		WHERE display_on_posting = 1
		ORDER BY bbcode_tag';
	$result = $db->sql_query($sql);

	$i = 0;
	// Start counting from 22 for the bbcode ids (every bbcode takes two ids - opening/closing)
	$num_predefined_bbcodes = 22;
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
			'BBCODE_TAG'		=> str_replace('=', '', $row['bbcode_tag']),
			'BBCODE_HELPLINE'	=> $row['bbcode_helpline'],
			'A_BBCODE_HELPLINE'	=> str_replace(array('&amp;', '&quot;', "'", '&lt;', '&gt;'), array('&', '"', "\'", '<', '>'), $row['bbcode_helpline']),
		));
	//echo ($num_predefined_bbcodes + ($i * 2)) . ' | ';

		$i++;
	}
	$db->sql_freeresult($result);
		//die('test');
}
function posting_gen_topic_types($forum_id, $cur_topic_type = 0)
{
	global $auth, $user, $template, $topic_type;

	$toggle = false;

	$topic_types = array(
		'sticky'	=> array('const' => 1, 'lang' => 'POST_STICKY'),
		'announce'	=> array('const' => 2, 'lang' => 'POST_ANNOUNCEMENT'),
		'global'	=> array('const' => 3, 'lang' => 'POST_GLOBAL')
	);

	$topic_type_array = array();

	foreach ($topic_types as $auth_key => $topic_value)
	{
		// We do not have a special post global announcement permission
		$auth_key = ($auth_key == 'global') ? 'announce' : $auth_key;

		if ($auth->acl_get('f_' . $auth_key, $forum_id))
		{
			$toggle = true;

			$topic_type_array[] = array(
				'VALUE'			=> $topic_value['const'],
				'S_CHECKED'		=> ($cur_topic_type == $topic_value['const'] || ($forum_id == 0 && $topic_value['const'] == 3)) ? ' checked="checked"' : '',
				'L_TOPIC_TYPE'	=> $user->lang[$topic_value['lang']]
			);
		}
	}

	if ($toggle)
	{
		$topic_type_array = array_merge(array(0 => array(
			'VALUE'			=> 0,
			'S_CHECKED'		=> ($topic_type == 0) ? ' checked="checked"' : '',
			'L_TOPIC_TYPE'	=> $user->lang['POST_NORMAL'])),

			$topic_type_array
		);

		foreach ($topic_type_array as $array)
		{
			$template->assign_block_vars('topic_type', $array);
		}

		$template->assign_vars(array(
			'S_TOPIC_TYPE_STICKY'	=> ($auth->acl_get('f_sticky', $forum_id)),
			'S_TOPIC_TYPE_ANNOUNCE'	=> ($auth->acl_get('f_announce', $forum_id)))
		);
	}

	return $toggle;
}
function posting_gen_topic_icons($mode, $icon_id)
{
	global $siteurl, $config, $db, $db_prefix, $template, $pmbt_cache;

	// Grab icons
	$icons = $pmbt_cache->obtain_icons();

	if (!$icon_id)
	{
		$template->assign_var('S_NO_ICON_CHECKED', ' checked="checked"');
	}

	if (sizeof($icons))
	{
		foreach ($icons as $id => $data)
		{
			if ($data['display'])
			{
				$template->assign_block_vars('topic_icon', array(
					'ICON_ID'		=> $id,
					'ICON_IMG'		=> $siteurl . '/images/icons/' . $data['img'],
					'ICON_WIDTH'	=> $data['width'],
					'ICON_HEIGHT'	=> $data['height'],

					'S_CHECKED'			=> ($id == $icon_id) ? true : false,
					'S_ICON_CHECKED'	=> ($id == $icon_id) ? ' checked="checked"' : '')
				);
			}
		}

		return true;
	}

	return false;
}
function delete_attachments($mode, $ids, $resync = true)
{
	global $db, $config, $db_prefix;
	if (is_array($ids) && sizeof($ids))
	{
		$ids = array_unique($ids);
		$ids = array_map('intval', $ids);
	}
	else
	{
		$ids = array((int) $ids);
	}

	if (!sizeof($ids))
	{
		return false;
	}

	$sql_id = ($mode == 'user') ? 'poster_id' : (($mode == 'post') ? 'post_msg_id' : (($mode == 'topic') ? 'topic_id' : 'attach_id'));

	$post_ids = $topic_ids = $physical = array();

	// Collect post and topics ids for later use
	if ($mode == 'attach' || $mode == 'user' || ($mode == 'topic' && $resync))
	{
		$sql = 'SELECT post_msg_id as post_id, topic_id, physical_filename, thumbnail, filesize
			FROM ' . $db_prefix . '_attachments
			WHERE ' . $db->sql_in_set($sql_id, $ids);
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$post_ids[] = $row['post_id'];
			$topic_ids[] = $row['topic_id'];
			$physical[] = array('filename' => $row['physical_filename'], 'thumbnail' => $row['thumbnail'], 'filesize' => $row['filesize']);
		}
		$db->sql_freeresult($result);
	}

	if ($mode == 'post')
	{
		$sql = 'SELECT topic_id, physical_filename, thumbnail, filesize
			FROM ' . $db_prefix . '_attachments
			WHERE ' . $db->sql_in_set('post_msg_id', $ids) . '
				AND in_message = 0';
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$topic_ids[] = $row['topic_id'];
			$physical[] = array('filename' => $row['physical_filename'], 'thumbnail' => $row['thumbnail'], 'filesize' => $row['filesize']);
		}
		$db->sql_freeresult($result);
	}

	// Delete attachments
	$sql = 'DELETE FROM ' . $db_prefix . '_attachments
		WHERE ' . $db->sql_in_set($sql_id, $ids);
	$db->sql_query($sql);
	$num_deleted = $db->sql_affectedrows();

	if (!$num_deleted)
	{
		return 0;
	}

	// Delete attachments from filesystem
	$space_removed = $files_removed = 0;
	foreach ($physical as $file_ary)
	{
		if (_unlink($file_ary['filename'], 'file', true))
		{
			$space_removed += $file_ary['filesize'];
			$files_removed++;
		}

		if ($file_ary['thumbnail'])
		{
			_unlink($file_ary['filename'], 'thumbnail', true);
		}
	}

	if ($mode == 'topic' && !$resync)
	{
		return $num_deleted;
	}

	if ($mode == 'post')
	{
		$post_ids = $ids;
	}
	unset($ids);

	$post_ids = array_unique($post_ids);
	$topic_ids = array_unique($topic_ids);

	// Update post indicators
	if (sizeof($post_ids))
	{
		if ($mode == 'post' || $mode == 'topic')
		{
			$sql = 'UPDATE ' . $db_prefix . '_posts
				SET post_attachment = 0
				WHERE ' . $db->sql_in_set('id', $post_ids);
			$db->sql_query($sql);
		}

		if ($mode == 'user' || $mode == 'attach')
		{
			$remaining = array();

			$sql = 'SELECT post_msg_id
				FROM ' . $db_prefix . '_attachments
				WHERE ' . $db->sql_in_set('post_msg_id', $post_ids) . '
					AND in_message = 0';
			$result = $db->sql_query($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				$remaining[] = $row['post_msg_id'];
			}
			$db->sql_freeresult($result);

			$unset_ids = array_diff($post_ids, $remaining);

			if (sizeof($unset_ids))
			{
				$sql = 'UPDATE ' . $db_prefix . '_posts
					SET post_attachment = 0
					WHERE ' . $db->sql_in_set('id', $unset_ids);
				$db->sql_query($sql);
			}

			$remaining = array();

			$sql = 'SELECT post_msg_id
				FROM ' . $db_prefix . '_attachments
				WHERE ' . $db->sql_in_set('post_msg_id', $post_ids) . '
					AND in_message = 1';
			$result = $db->sql_query($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				$remaining[] = $row['post_msg_id'];
			}
			$db->sql_freeresult($result);

			$unset_ids = array_diff($post_ids, $remaining);

			if (sizeof($unset_ids))
			{
				$sql = 'UPDATE ' . $db_prefix . '_private_messages
					SET message_attachment = 0
					WHERE ' . $db->sql_in_set('id', $unset_ids);
				$db->sql_query($sql);
			}
		}
	}

	if (sizeof($topic_ids))
	{
		// Update topic indicator
		if ($mode == 'topic')
		{
			$sql = 'UPDATE ' . $db_prefix . '_topics
				SET topic_attachment = 0
				WHERE ' . $db->sql_in_set('id', $topic_ids);
			$db->sql_query($sql);
		}

		if ($mode == 'post' || $mode == 'user' || $mode == 'attach')
		{
			$remaining = array();

			$sql = 'SELECT topic_id
				FROM ' . $db_prefix . '_attachments
				WHERE ' . $db->sql_in_set('topic_id', $topic_ids);
			$result = $db->sql_query($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				$remaining[] = $row['topic_id'];
			}
			$db->sql_freeresult($result);

			$unset_ids = array_diff($topic_ids, $remaining);

			if (sizeof($unset_ids))
			{
				$sql = 'UPDATE ' . $db_prefix . '_topics
					SET topic_attachment = 0
					WHERE ' . $db->sql_in_set('id', $unset_ids);
				$db->sql_query($sql);
			}
		}
	}

	return $num_deleted;
}
function _unlink($filename, $mode = 'file', $entry_removed = false)
{
	global $db, $db_prefix, $config;

	// Because of copying topics or modifications a physical filename could be assigned more than once. If so, do not remove the file itself.
	$sql = 'SELECT COUNT(attach_id) AS num_entries
		FROM ' . $db_prefix . "_attachments
		WHERE physical_filename = '" . $db->sql_escape(basename($filename)) . "'";
	$result = $db->sql_query($sql);
	$num_entries = (int) $db->sql_fetchfield('num_entries');
	$db->sql_freeresult($result);

	// Do not remove file if at least one additional entry with the same name exist.
	if (($entry_removed && $num_entries > 0) || (!$entry_removed && $num_entries > 1))
	{
		return false;
	}

	$filename = ($mode == 'thumbnail') ? 'thumb_' . basename($filename) : basename($filename);
	return @unlink($config['upload_path'] . '/' . $filename);
}
function truncate_string($string, $max_length = 60, $max_store_length = 255, $allow_reply = false, $append = '')
{
	$chars = array();

	$strip_reply = false;
	$stripped = false;
	if ($allow_reply && strpos($string, $user->lang['REPLY_PM_RE']) === 0)
	{
		$strip_reply = true;
		$string = substr($string, 4);
	}

	$_chars = utf8_str_split(htmlspecialchars_decode($string));
	$chars = array_map('utf8_htmlspecialchars', $_chars);

	// Now check the length ;)
	if (sizeof($chars) > $max_length)
	{
		// Cut off the last elements from the array
		$string = implode('', array_slice($chars, 0, $max_length - utf8_strlen($append)));
		$stripped = true;
	}

	// Due to specialchars, we may not be able to store the string...
	if (strlen($string) > $max_store_length)
	{
		// let's split again, we do not want half-baked strings where entities are split
		$_chars = utf8_str_split(htmlspecialchars_decode($string));
		$chars = array_map('utf8_htmlspecialchars', $_chars);

		do
		{
			array_pop($chars);
			$string = implode('', $chars);
		}
		while (!empty($chars) && strlen($string) > $max_store_length);
	}

	if ($strip_reply)
	{
		$string = $user->lang['REPLY_PM_RE'] . $string;
	}

	if ($append != '' && $stripped)
	{
		$string = $string . $append;
	}

	return $string;
}
function set_att_config_count($config_name, $increment, $is_dynamic = false)
{
	global $db, $pmbt_cache, $db_prefix;

	switch ($db->sql_layer)
	{
		case 'firebird':
		case 'postgres':
			$sql_update = 'CAST(CAST(config_value as DECIMAL(255, 0)) + ' . (int) $increment . ' as VARCHAR(255))';
		break;

		// MySQL, SQlite, mssql, mssql_odbc, oracle
		default:
			$sql_update = 'config_value + ' . (int) $increment;
		break;
	}

	$db->sql_query('UPDATE '. $db_prefix . '_attachments_config SET config_value = ' . $sql_update . " WHERE config_name = '" . $db->sql_escape($config_name) . "'");

	if (!$is_dynamic)
	{
		$pmbt_cache->remove_file("sql_".md5('attachmet_con').".php");
	}
}
function bbcode_nl2br($text)
{
	// custom BBCodes might contain carriage returns so they
	// are not converted into <br /> so now revert that
	$text = str_replace(array("\n", "\r"), array('<br />', "\n"), $text);
	return $text;
}
function utf8_basename($filename)
{
	// We always check for forward slash AND backward slash
	// because they could be mixed or "sneaked" in. ;)
	// You know, never trust user input...
	if (strpos($filename, '/') !== false)
	{
		$filename = utf8_substr($filename, utf8_strrpos($filename, '/') + 1);
	}

	if (strpos($filename, '\\') !== false)
	{
		$filename = utf8_substr($filename, utf8_strrpos($filename, '\\') + 1);
	}

	return $filename;
}
function attach_unlink($filename, $mode = 'file', $entry_removed = false)
{
	global $db, $db_prefix, $siteurl, $config;

	// Because of copying topics or modifications a physical filename could be assigned more than once. If so, do not remove the file itself.
	$sql = 'SELECT COUNT(attach_id) AS num_entries
		FROM ' . $db_prefix . "_attachments
		WHERE physical_filename = '" . $db->sql_escape(utf8_basename($filename)) . "'";
	$result = $db->sql_query($sql);
	$num_entries = (int) $db->sql_fetchfield('num_entries');
	$db->sql_freeresult($result);

	// Do not remove file if at least one additional entry with the same name exist.
	if (($entry_removed && $num_entries > 0) || (!$entry_removed && $num_entries > 1))
	{
		return false;
	}

	$filename = ($mode == 'thumbnail') ? 'thumb_' . utf8_basename($filename) : utf8_basename($filename);
	return @unlink('./' . $config['upload_path'] . '/' . $filename);
}
function system_pm($msg,$sub,$to,$icon,$send_from = false)
{
	global $config, $db, $db_prefix, $user, $phpEx, $template, $sitename,$siteurl, $config;
		include_once('include/message_parser.php');
		include_once('include/class.bbcode.php');
		include_once('include/ucp/functions_privmsgs.php');
		$address_list = array();
		$address_list['u'][$to] = 'to';
		$subject			= $sub;
		if($send_from)
		{
			$sender				=	$user->id;
			$sender_name		=	$user->name;
		}
		else
		{
			$sender				=	'0';
			$sender_name		=	$user->lang['UNKNOWN'];
		}
		$message			= $msg;
		$icon_id			= $icon;
		$bbcode_status		= ($config['allow_bbcode'] && $config['auth_bbcode_pm'] && checkaccess('u_pm_bbcode')) ? true : false;
		$smilies_status		= ($config['allow_smilies'] && $config['auth_smilies_pm'] && checkaccess('u_pm_smilies')) ? true : false;
		$img_status			= ($config['auth_img_pm'] && checkaccess('u_pm_img')) ? true : false;
		$flash_status		= ($config['auth_flash_pm'] && checkaccess('u_pm_flash')) ? true : false;
		$url_status			= ($config['allow_post_links']) ? true : false;
		$enable_sig			= ($config['allow_sig'] && $config['allow_sig_pm'] && checkaccess('u_sig'));
		$enable_smilies		= ($config['allow_smilies'] && checkaccess('u_pm_smilies'));
		$enable_bbcode		= ($config['allow_bbcode'] && checkaccess('u_pm_bbcode'));
		$enable_urls		= true;
		$status_switch		= (($enable_bbcode+1) << 8) + (($enable_smilies+1) << 4) + (($enable_urls+1) << 2) + (($enable_sig+1) << 1);
		$status_switch 		= ($status_switch != $check_value);
		$message_parser = new parse_message();
		$message_parser->message = $message;
		$bbcode_uid = $message_parser->bbcode_uid;
		unset($message);
		$message_parser->parse($enable_bbcode, ($config['allow_post_links']) ? $enable_urls : false, $enable_smilies, $img_status, $flash_status, true, $config['allow_post_links']);
			$pm_data = array(
				'msg_id'				=> (int) $msg_id,
				'from_user_id'			=> $sender,
				'from_user_ip'			=> getip(),
				'from_username'			=> $sender_name,
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
			submit_pm('post', $subject, $pm_data, false);
}
function commenttable($rows, $what = 'forum', $reply, $action_edit = false, $action_dele = false)
{
	global $db, $db_prefix, $theme, $template, $user, $phpEx;
	$count = 0;
				$template->assign_vars(array(
						'EDIT_IMG' 		=> $user->img('icon_post_edit', 'EDIT_POST'),
						'DELETE_IMG' 	=> $user->img('icon_post_delete', 'DELETE_POST'),
						'VIEW_ORIF' 	=> $user->img('icon_view_orig', 'ORIGENAL_POST'),
						'IMG_QUOTE' 	=> $user->img('icon_post_quote', 'REPLY_QUOTE'),
					));
	foreach ($rows as $row)
	{
		$pic = "";
		$var = array();
		$postername = htmlspecialchars($row["username"]);
		if ($postername == "")
		{
			$postername = $user->lang['DEL_USER'];
			$title = $user->lang['DELETED_ACCOUNT'];
			$privacylevel = "no";
			$avatar = gen_avatar(0);
			$usersignature = "";
			$userdownloaded = "0";
			$useruploaded = "0";
			$commentposts = '0';
			$validuser = false;
		}
		else
		{
			$validuser = true;
			$res44 = $db->sql_query("SELECT COUNT(*) FROM ".$db_prefix."_comments WHERE user=" . $row["user"] . "") ;
			$arr333 = $db->sql_fetchrow($res44);
			$commentposts = $arr333[0];
			$commentid = $row["id"];
			$avatar = gen_avatar($row["user"]);
			$userdownloaded = mksize($row["downloaded"]);
			$useruploaded = mksize($row["uploaded"]);
			$title =  htmlspecialchars($row["name"]);
			$privacylevel = $row["accept_mail"];
			if ($row["level"] == "premium")
				$pic = pic("icon_premium.gif");
			elseif ($row["level"] == "moderator")
				$pic = pic("icon_moderator.gif");
			elseif ($row["level"] == "admin")
				$pic = pic("icon_admin.gif");
		}
			$userratio = ($validuser)?get_u_ratio($row["uploaded"],$row["downloaded"]) : '---';
			$message = censor_text($row["text"]);
			$addedit = false;
					if($row['editedby'] > '0')
					{
					$addedit = sprintf($user->lang['LAST_EDIT_BY'],$row['editedby'],username_is($row['editedby']),$user->format_date(sql_timestamp_to_unix_timestamp($row['editedat'])));
					}
			$can_edit=$can_delete=false;
			if($user->id == $row["user"] || checkaccess("m_".$what))
			{
			$can_edit=$can_delete=true;
			}

						if ($row['bbcode_bitfield'])
						{
							include_once('include/bbcode.' . $phpEx);
							$bbcode = new bbcode($row['bbcode_bitfield']);
							$bbcode->bbcode_second_pass($message, $row['bbcode_uid'], $row['bbcode_bitfield']);
						}


					$message = bbcode_nl2br($message);
					$message = parse_smiles($message);
			$template->assign_block_vars('commentlist', array(
										'ID'						=>	$row['id'],
										'P_ADDED'					=>	$user->format_date(sql_timestamp_to_unix_timestamp($row['added'])),
										'P_CANEDIT'					=>	$can_edit,
										'P_CANDELETE'				=>	$can_delete,
										'P_EDIT'					=>	$action_edit,
										'P_DELET'					=>	$action_dele,
										'P_REPLY'					=>	$reply,
										'P_EDITED'					=>	($row['editedby'] > '0')? true : false,
										'P_EDITED_BY'				=>	$addedit,
										'P_FORUM'					=>	$row['forum_id'],
										'P_USERNAME'				=>	$postername,
										'P_GROUP'					=>	$title,
										'P_UPLOADED'				=>	$useruploaded,
										'P_DOWNLOADED'				=>	$userdownloaded,
										'P_RATIO'					=>	$userratio,
										'P_COMMENT_COUNT'			=>	$commentposts,
										'P_COMMENT'					=>	$message,
										'P_AVATAR'					=>	$avatar,
				)
			);

	}
	return $template->fetch('post.html');
}
function smiley_text($text, $force_option = false)
{
	global $config, $user, $siteurl;

	if ($force_option || !$config['allow_smilies'] || !$user->optionget('viewsmilies'))
	{
		return preg_replace('#<!\-\- s(.*?) \-\-><img src="smiles\/.*? \/><!\-\- s\1 \-\->#', '\1', $text);
	}
	else
	{
		return preg_replace('#<!\-\- s(.*?) \-\-><img src="smiles\/(.*?) \/><!\-\- s\1 \-\->#', '<img src="' . $siteurl . '/smiles/\2 />', $text);
	}
}
function submit_post($mode, $subject, $username, $topic_type, &$poll, &$data, $update_message = true)
{
	global $db, $auth, $user, $config, $phpEx, $template, $phpbb_root_path, $db_prefix;

	// We do not handle erasing posts here
	if ($mode == 'delete')
	{
		return false;
	}

	$current_time = time();

	if ($mode == 'post')
	{
		$post_mode = 'post';
		$update_message = true;
	}
	else if ($mode != 'edit')
	{
		$post_mode = 'reply';
		$update_message = true;
	}
	else if ($mode == 'edit')
	{
		$post_mode = ($data['topic_replies_real'] == 0) ? 'edit_topic' : (($data['topic_first_post_id'] == $data['post_id']) ? 'edit_first_post' : (($data['topic_last_post_id'] == $data['post_id']) ? 'edit_last_post' : 'edit'));
	}

	// First of all make sure the subject and topic title are having the correct length.
	// To achieve this without cutting off between special chars we convert to an array and then count the elements.
	$subject = truncate_string($subject);
	$data['topic_title'] = truncate_string($data['topic_title']);

	// Collect some basic information about which tables and which rows to update/insert
	$sql_data = $topic_row = array();
	$poster_id = ($mode == 'edit') ? $data['poster_id'] : $user->id;

	// Retrieve some additional information if not present
	if ($mode == 'edit' && (!isset($data['post_approved']) || !isset($data['topic_approved']) || $data['post_approved'] === false || $data['topic_approved'] === false))
	{
		$sql = 'SELECT p.post_approved, t.topic_type, t.topic_replies, t.topic_replies_real, t.topic_approved
			FROM ' . $db_prefix . '_topics t, ' . $db_prefix . '_posts p
			WHERE t.topic_id = p.topic_id
				AND p.post_id = ' . $data['post_id'];
		$result = $db->sql_query($sql);
		$topic_row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		$data['topic_approved'] = $topic_row['topic_approved'];
		$data['post_approved'] = $topic_row['post_approved'];
	}

	// This variable indicates if the user is able to post or put into the queue - it is used later for all code decisions regarding approval
	$post_approval = 1;

	// Check the permissions for post approval, as well as the queue trigger where users are put on approval with a post count lower than specified. Moderators are not affected.
	if ((($config['enable_queue_trigger'] && $user->posts < $config['queue_trigger_posts']) || !$auth->acl_get('f_noapprove', $data['forum_id'])) && !$auth->acl_get('m_approve', $data['forum_id']))
	{
		$post_approval = 0;
	}

	// Start the transaction here
	//$db->sql_transaction('begin');

	// Collect Information
	switch ($post_mode)
	{
		case 'post':
		case 'reply':
			$sql_data[$db_prefix . "_posts"]['sql'] = array(
				'forum_id'			=> ($topic_type == 3) ? 0 : $data['forum_id'],
				'poster_id'			=> (int) $user->id,
				'icon_id'			=> $data['icon_id'],
				'poster_ip'			=> $user->ip,
				'post_time'			=> $current_time,
				'post_approved'		=> $post_approval,
				'enable_bbcode'		=> $data['enable_bbcode'],
				'enable_smilies'	=> $data['enable_smilies'],
				'enable_magic_url'	=> $data['enable_urls'],
				'enable_sig'		=> $data['enable_sig'],
				'post_username'		=> (!$user->user) ? $username : '',
				'post_subject'		=> $subject,
				'post_text'			=> $data['message'],
				'post_checksum'		=> $data['message_md5'],
				'post_attachment'	=> (!empty($data['attachment_data'])) ? 1 : 0,
				'bbcode_bitfield'	=> $data['bbcode_bitfield'],
				'bbcode_uid'		=> $data['bbcode_uid'],
				'post_postcount'	=> ($auth->acl_get('f_postcount', $data['forum_id'])) ? 1 : 0,
				'post_edit_locked'	=> $data['post_edit_locked']
			);
		break;

		case 'edit_first_post':
		case 'edit':

		case 'edit_last_post':
		case 'edit_topic':

			// If edit reason is given always display edit info

			// If editing last post then display no edit info
			// If m_edit permission then display no edit info
			// If normal edit display edit info

			// Display edit info if edit reason given or user is editing his post, which is not the last within the topic.
			if ($data['post_edit_reason'] || (!$auth->acl_get('m_edit', $data['forum_id']) && ($post_mode == 'edit' || $post_mode == 'edit_first_post')))
			{
				$data['post_edit_reason']		= truncate_string($data['post_edit_reason'], 255, 255, false);

				$sql_data[$db_prefix . '_posts']['sql']	= array(
					'post_edit_time'	=> $current_time,
					'post_edit_reason'	=> $data['post_edit_reason'],
					'post_edit_user'	=> (int) $data['post_edit_user'],
				);

				$sql_data[$db_prefix . '_posts']['stat'][] = 'post_edit_count = post_edit_count + 1';
			}
			else if (!$data['post_edit_reason'] && $mode == 'edit' && $auth->acl_get('m_edit', $data['forum_id']))
			{
				$sql_data[$db_prefix . '_posts']['sql'] = array(
					'post_edit_reason'	=> '',
				);
			}

			// If the person editing this post is different to the one having posted then we will add a log entry stating the edit
			// Could be simplified by only adding to the log if the edit is not tracked - but this may confuse admins/mods
			if ($user->id != $poster_id)
			{
				$log_subject = ($subject) ? $subject : $data['topic_title'];
				add_log('mod', $data['forum_id'], $data['topic_id'], 'LOG_POST_EDITED', $log_subject, (!empty($username)) ? $username : $user->lang['GUEST']);
			}

			if (!isset($sql_data[$db_prefix . '_posts']['sql']))
			{
				$sql_data[$db_prefix . "_posts"]['sql'] = array();
			}

			$sql_data[$db_prefix . '_posts']['sql'] = array_merge($sql_data[$db_prefix . '_posts']['sql'], array(
				'forum_id'			=> ($topic_type == 3) ? 0 : $data['forum_id'],
				'poster_id'			=> $data['poster_id'],
				'icon_id'			=> $data['icon_id'],
				'post_approved'		=> (!$post_approval) ? 0 : $data['post_approved'],
				'enable_bbcode'		=> $data['enable_bbcode'],
				'enable_smilies'	=> $data['enable_smilies'],
				'enable_magic_url'	=> $data['enable_urls'],
				'enable_sig'		=> $data['enable_sig'],
				'post_username'		=> ($username && $data['poster_id'] == 0) ? $username : '',
				'post_subject'		=> $subject,
				'post_checksum'		=> $data['message_md5'],
				'post_attachment'	=> (!empty($data['attachment_data'])) ? 1 : 0,
				'bbcode_bitfield'	=> $data['bbcode_bitfield'],
				'bbcode_uid'		=> $data['bbcode_uid'],
				'post_edit_locked'	=> $data['post_edit_locked'])
			);

			if ($update_message)
			{
				$sql_data[$db_prefix . '_posts']['sql']['post_text'] = $data['message'];
			}

		break;
	}

	$post_approved = $sql_data[$db_prefix . '_posts']['sql']['post_approved'];
	$topic_row = array();

	// And the topic ladies and gentlemen
	switch ($post_mode)
	{
		case 'post':
			$sql_data[$db_prefix . '_topics']['sql'] = array(
				'topic_poster'				=> (int) $user->id,
				'topic_time'				=> $current_time,
				'topic_last_view_time'		=> $current_time,
				'forum_id'					=> ($topic_type == 3) ? 0 : $data['forum_id'],
				'icon_id'					=> $data['icon_id'],
				'topic_approved'			=> $post_approval,
				'topic_title'				=> $subject,
				'topic_first_poster_name'	=> (!$user->user && $username) ? $username : (($user->id != 0) ? $user->name : ''),
				'topic_first_poster_colour'	=> $user->color,
				'topic_type'				=> $topic_type,
				'topic_time_limit'			=> ($topic_type == 1 || $topic_type == 2) ? ($data['topic_time_limit'] * 86400) : 0,
				'topic_attachment'			=> (!empty($data['attachment_data'])) ? 1 : 0,
			);

			if (isset($poll['poll_options']) && !empty($poll['poll_options']))
			{
				$poll_start = ($poll['poll_start']) ? $poll['poll_start'] : $current_time;
				$poll_length = $poll['poll_length'] * 86400;
				if ($poll_length < 0)
				{
					$poll_start = $poll_start + $poll_length;
					if ($poll_start < 0)
					{
						$poll_start = 0;
					}
					$poll_length = 1;
				}

				$sql_data[$db_prefix . '_topics']['sql'] = array_merge($sql_data[$db_prefix . '_topics']['sql'], array(
					'poll_title'		=> $poll['poll_title'],
					'poll_start'		=> $poll_start,
					'poll_max_options'	=> $poll['poll_max_options'],
					'poll_length'		=> $poll_length,
					'poll_vote_change'	=> $poll['poll_vote_change'])
				);
			}

			$sql_data[$db_prefix . '_users']['stat'][] = "user_lastpost_time = $current_time" . (($auth->acl_get('f_postcount', $data['forum_id']) && $post_approval) ? ', user_posts = user_posts + 1' : '');

			if ($topic_type != 3)
			{
				if ($post_approval)
				{
					$sql_data[$db_prefix . '_forums']['stat'][] = 'forum_posts = forum_posts + 1';
				}
				$sql_data[$db_prefix . '_forums']['stat'][] = 'forum_topics_real = forum_topics_real + 1' . (($post_approval) ? ', forum_topics = forum_topics + 1' : '');
			}
		break;

		case 'reply':
			$sql_data[$db_prefix . '_topics']['stat'][] = 'topic_last_view_time = ' . $current_time . ',
				topic_replies_real = topic_replies_real + 1,
				topic_bumped = 0,
				topic_bumper = 0' .
				(($post_approval) ? ', topic_replies = topic_replies + 1' : '') .
				((!empty($data['attachment_data']) || (isset($data['topic_attachment']) && $data['topic_attachment'])) ? ', topic_attachment = 1' : '');

			$sql_data[$db_prefix . '_users']['stat'][] = "user_lastpost_time = $current_time" . (($auth->acl_get('f_postcount', $data['forum_id']) && $post_approval) ? ', user_posts = user_posts + 1' : '');

			if ($post_approval && $topic_type != 3)
			{
				$sql_data[$db_prefix . "_forums"]['stat'][] = 'forum_posts = forum_posts + 1';
			}
		break;

		case 'edit_topic':
		case 'edit_first_post':
			if (isset($poll['poll_options']) && !empty($poll['poll_options']))
			{
				$poll_start = ($poll['poll_start']) ? $poll['poll_start'] : $current_time;
				$poll_length = $poll['poll_length'] * 86400;
				if ($poll_length < 0)
				{
					$poll_start = $poll_start + $poll_length;
					if ($poll_start < 0)
					{
						$poll_start = 0;
					}
					$poll_length = 1;
				}
			}

			$sql_data[$db_prefix . "_topics"]['sql'] = array(
				'forum_id'					=> ($topic_type == 3) ? 0 : $data['forum_id'],
				'icon_id'					=> $data['icon_id'],
				'topic_approved'			=> (!$post_approval) ? 0 : $data['topic_approved'],
				'topic_title'				=> $subject,
				'topic_first_poster_name'	=> $username,
				'topic_type'				=> $topic_type,
				'topic_time_limit'			=> ($topic_type == 1 || $topic_type == 2) ? ($data['topic_time_limit'] * 86400) : 0,
				'poll_title'				=> (isset($poll['poll_options'])) ? $poll['poll_title'] : '',
				'poll_start'				=> (isset($poll['poll_options'])) ? $poll_start : 0,
				'poll_max_options'			=> (isset($poll['poll_options'])) ? $poll['poll_max_options'] : 1,
				'poll_length'				=> (isset($poll['poll_options'])) ? $poll_length : 0,
				'poll_vote_change'			=> (isset($poll['poll_vote_change'])) ? $poll['poll_vote_change'] : 0,
				'topic_last_view_time'		=> $current_time,

				'topic_attachment'			=> (!empty($data['attachment_data'])) ? 1 : (isset($data['topic_attachment']) ? $data['topic_attachment'] : 0),
			);

			// Correctly set back the topic replies and forum posts... only if the topic was approved before and now gets disapproved
			if (!$post_approval && $data['topic_approved'])
			{
				// Do we need to grab some topic informations?
				if (!sizeof($topic_row))
				{
					$sql = 'SELECT topic_type, topic_replies, topic_replies_real, topic_approved
						FROM ' . $db_prefix . '_topics
						WHERE topic_id = ' . $data['topic_id'];
					$result = $db->sql_query($sql);
					$topic_row = $db->sql_fetchrow($result);
					$db->sql_freeresult($result);
				}

				// If this is the only post remaining we do not need to decrement topic_replies.
				// Also do not decrement if first post - then the topic_replies will not be adjusted if approving the topic again.

				// If this is an edited topic or the first post the topic gets completely disapproved later on...
				$sql_data[$db_prefix . "_forums"]['stat'][] = 'forum_topics = forum_topics - 1';
				$sql_data[$db_prefix . "_forums"]['stat'][] = 'forum_posts = forum_posts - ' . ($topic_row['topic_replies'] + 1);

				set_config_count('num_topics', -1, true);
				set_config_count('num_posts', ($topic_row['topic_replies'] + 1) * (-1), true);

				// Only decrement this post, since this is the one non-approved now
				if ($auth->acl_get('f_postcount', $data['forum_id']))
				{
					$sql_data[$db_prefix . '_users']['stat'][] = 'user_posts = user_posts - 1';
				}
			}

		break;

		case 'edit':
		case 'edit_last_post':

			// Correctly set back the topic replies and forum posts... but only if the post was approved before.
			if (!$post_approval && $data['post_approved'])
			{
				$sql_data[$db_prefix . "_topics"]['stat'][] = 'topic_replies = topic_replies - 1, topic_last_view_time = ' . $current_time;
				$sql_data[$db_prefix . "_forums"]['stat'][] = 'forum_posts = forum_posts - 1';

				set_config_count('num_posts', -1, true);

				if ($auth->acl_get('f_postcount', $data['forum_id']))
				{
					$sql_data[$db_prefix . '_users']['stat'][] = 'user_posts = user_posts - 1';
				}
			}

		break;
	}

	// Submit new topic
	if ($post_mode == 'post')
	{
		$sql = 'INSERT INTO ' . $db_prefix . '_topics ' .
			$db->sql_build_array('INSERT', $sql_data[$db_prefix . "_topics"]['sql']);
		$db->sql_query($sql);

		$data['topic_id'] = $db->sql_nextid();

		$sql_data[$db_prefix . "_posts"]['sql'] = array_merge($sql_data[$db_prefix . "_posts"]['sql'], array(
			'topic_id' => $data['topic_id'])
		);
		unset($sql_data[$db_prefix . "_topics"]['sql']);
	}

	// Submit new post
	if ($post_mode == 'post' || $post_mode == 'reply')
	{
		if ($post_mode == 'reply')
		{
			$sql_data[$db_prefix . "_posts"]['sql'] = array_merge($sql_data[$db_prefix . "_posts"]['sql'], array(
				'topic_id' => $data['topic_id'])
			);
		}

		$sql = 'INSERT INTO ' . $db_prefix . '_posts ' . $db->sql_build_array('INSERT', $sql_data[$db_prefix . "_posts"]['sql']);
		$db->sql_query($sql);
		$data['post_id'] = $db->sql_nextid();

		if ($post_mode == 'post')
		{
			$sql_data[$db_prefix . "_topics"]['sql'] = array(
				'topic_first_post_id'		=> $data['post_id'],
				'topic_last_post_id'		=> $data['post_id'],
				'topic_last_post_time'		=> $current_time,
				'topic_last_poster_id'		=> (int) $user->id,
				'topic_last_poster_name'	=> (!$user->user && $username) ? $username : (($user->id != 0) ? $user->name : ''),
				'topic_last_poster_colour'	=> $user->color,
				'topic_last_post_subject'	=> (string) $subject,
			);
		}

		unset($sql_data[$db_prefix . "_posts"]['sql']);
	}

	$make_global = false;

	// Are we globalising or unglobalising?
	if ($post_mode == 'edit_first_post' || $post_mode == 'edit_topic')
	{
		if (!sizeof($topic_row))
		{
			$sql = 'SELECT topic_type, topic_replies, topic_replies_real, topic_approved, topic_last_post_id
				FROM ' . $db_prefix . '_topics
				WHERE topic_id = ' . $data['topic_id'];
			$result = $db->sql_query($sql);
			$topic_row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);
		}

		// globalise/unglobalise?
		if (($topic_row['topic_type'] != 3 && $topic_type == 3) || ($topic_row['topic_type'] == 3 && $topic_type != 3))
		{
			if (!empty($sql_data[$db_prefix . "_forums"]['stat']) && implode('', $sql_data[$db_prefix . "_forums"]['stat']))
			{
				$db->sql_query('UPDATE ' . $db_prefix . '_forums SET ' . implode(', ', $sql_data[$db_prefix . "_forums"]['stat']) . ' WHERE forum_id = ' . $data['forum_id']);
			}

			$make_global = true;
			$sql_data[$db_prefix . "_forums"]['stat'] = array();
		}

		// globalise
		if ($topic_row['topic_type'] != 3 && $topic_type == 3)
		{
			// Decrement topic/post count
			$sql_data[$db_prefix . "_forums"]['stat'][] = 'forum_posts = forum_posts - ' . ($topic_row['topic_replies_real'] + 1);
			$sql_data[$db_prefix . "_forums"]['stat'][] = 'forum_topics_real = forum_topics_real - 1' . (($topic_row['topic_approved']) ? ', forum_topics = forum_topics - 1' : '');

			// Update forum_ids for all posts
			$sql = 'UPDATE ' . $db_prefix . '_posts
				SET forum_id = 0
				WHERE topic_id = ' . $data['topic_id'];
			$db->sql_query($sql);
		}
		// unglobalise
		else if ($topic_row['topic_type'] == 3 && $topic_type != 3)
		{
			// Increment topic/post count
			$sql_data[$db_prefix . "_forums"]['stat'][] = 'forum_posts = forum_posts + ' . ($topic_row['topic_replies_real'] + 1);
			$sql_data[$db_prefix . "_forums"]['stat'][] = 'forum_topics_real = forum_topics_real + 1' . (($topic_row['topic_approved']) ? ', forum_topics = forum_topics + 1' : '');

			// Update forum_ids for all posts
			$sql = 'UPDATE ' . $db_prefix . '_posts
				SET forum_id = ' . $data['forum_id'] . '
				WHERE topic_id = ' . $data['topic_id'];
			$db->sql_query($sql);
		}
	}

	// Update the topics table
	if (isset($sql_data[$db_prefix . "_topics"]['sql']))
	{
		$sql = 'UPDATE ' . $db_prefix . '_topics
			SET ' . $db->sql_build_array('UPDATE', $sql_data[$db_prefix . "_topics"]['sql']) . '
			WHERE topic_id = ' . $data['topic_id'];
		$db->sql_query($sql);
	}

	// Update the posts table
	if (isset($sql_data[$db_prefix . "_posts"]['sql']))
	{
		$sql = 'UPDATE ' . $db_prefix . '_posts
			SET ' . $db->sql_build_array('UPDATE', $sql_data[$db_prefix . "_posts"]['sql']) . '
			WHERE post_id = ' . $data['post_id'];
		$db->sql_query($sql);
	}

	// Update Poll Tables
	if (isset($poll['poll_options']) && !empty($poll['poll_options']))
	{
		$cur_poll_options = array();

		if ($poll['poll_start'] && $mode == 'edit')
		{
			$sql = 'SELECT *
				FROM ' . $db_prefix . '_poll_options
				WHERE topic_id = ' . $data['topic_id'] . '
				ORDER BY poll_option_id';
			$result = $db->sql_query($sql);

			$cur_poll_options = array();
			while ($row = $db->sql_fetchrow($result))
			{
				$cur_poll_options[] = $row;
			}
			$db->sql_freeresult($result);
		}

		$sql_insert_ary = array();

		for ($i = 0, $size = sizeof($poll['poll_options']); $i < $size; $i++)
		{
			if (strlen(trim($poll['poll_options'][$i])))
			{
				if (empty($cur_poll_options[$i]))
				{
					// If we add options we need to put them to the end to be able to preserve votes...
					$sql_insert_ary[] = array(
						'poll_option_id'	=> (int) sizeof($cur_poll_options) + 1 + sizeof($sql_insert_ary),
						'topic_id'			=> (int) $data['topic_id'],
						'poll_option_text'	=> (string) $poll['poll_options'][$i]
					);
				}
				else if ($poll['poll_options'][$i] != $cur_poll_options[$i])
				{
					$sql = 'UPDATE ' . $db_prefix . "_poll_options
						SET poll_option_text = '" . $db->sql_escape($poll['poll_options'][$i]) . "'
						WHERE poll_option_id = " . $cur_poll_options[$i]['poll_option_id'] . '
							AND topic_id = ' . $data['topic_id'];
					$db->sql_query($sql);
				}
			}
		}

		$db->sql_multi_insert($db_prefix . '_poll_options', $sql_insert_ary);

		if (sizeof($poll['poll_options']) < sizeof($cur_poll_options))
		{
			$sql = 'DELETE FROM ' . $db_prefix . '_poll_options
				WHERE poll_option_id > ' . sizeof($poll['poll_options']) . '
					AND topic_id = ' . $data['topic_id'];
			$db->sql_query($sql);
		}

		// If edited, we would need to reset votes (since options can be re-ordered above, you can't be sure if the change is for changing the text or adding an option
		if ($mode == 'edit' && sizeof($poll['poll_options']) != sizeof($cur_poll_options))
		{
			$db->sql_query('DELETE FROM ' . $db_prefix . '_poll_votes WHERE topic_id = ' . $data['topic_id']);
			$db->sql_query('UPDATE ' . $db_prefix . '_poll_options SET poll_option_total = 0 WHERE topic_id = ' . $data['topic_id']);
		}
	}

	// Submit Attachments
	if (!empty($data['attachment_data']) && $data['post_id'] && in_array($mode, array('post', 'reply', 'quote', 'edit')))
	{
		$space_taken = $files_added = 0;
		$orphan_rows = array();

		foreach ($data['attachment_data'] as $pos => $attach_row)
		{
			$orphan_rows[(int) $attach_row['attach_id']] = array();
		}

		if (sizeof($orphan_rows))
		{
			$sql = 'SELECT attach_id, filesize, physical_filename
				FROM ' . $db_prefix . '_attachments
				WHERE ' . $db->sql_in_set('attach_id', array_keys($orphan_rows)) . '
					AND is_orphan = 1
					AND poster_id = ' . $user->id;
			$result = $db->sql_query($sql);

			$orphan_rows = array();
			while ($row = $db->sql_fetchrow($result))
			{
				$orphan_rows[$row['attach_id']] = $row;
			}
			$db->sql_freeresult($result);
		}
		foreach ($data['attachment_data'] as $pos => $attach_row)
		{
			if ($attach_row['is_orphan'] && !isset($orphan_rows[$attach_row['attach_id']]))
			{
//die(print_r($orphan_rows));
				continue;
			}

			if (!$attach_row['is_orphan'])
			{
				// update entry in db if attachment already stored in db and filespace
				$sql = 'UPDATE ' . $db_prefix . "_attachments
					SET attach_comment = '" . $db->sql_escape($attach_row['attach_comment']) . "'
					WHERE attach_id = " . (int) $attach_row['attach_id'] . '
						AND is_orphan = 0';
						//die($sql);
				$db->sql_query($sql);
			}
			else
			{
				// insert attachment into db
				if (!@file_exists($config['upload_path'] . '/' . basename($orphan_rows[$attach_row['attach_id']]['physical_filename'])))
				{
					//die('hold up');
					continue;
				}

				$space_taken += $orphan_rows[$attach_row['attach_id']]['filesize'];
				$files_added++;

				$attach_sql = array(
					'post_msg_id'		=> $data['post_id'],
					'topic_id'			=> $data['topic_id'],
					'is_orphan'			=> 0,
					'poster_id'			=> $poster_id,
					'attach_comment'	=> $attach_row['attach_comment'],
				);

				$sql = 'UPDATE ' . $db_prefix . '_attachments SET ' . $db->sql_build_array('UPDATE', $attach_sql) . '
					WHERE attach_id = ' . $attach_row['attach_id'] . '
						AND is_orphan = 1
						AND poster_id = ' . $user->id;
						//die($sql);
				$db->sql_query($sql);
			}
		}

		if ($space_taken && $files_added)
		{
			//set_config_count('upload_dir_size', $space_taken, true);
			//set_config_count('num_files', $files_added, true);
		}
	}

	// we need to update the last forum information
	// only applicable if the topic is not global and it is approved
	// we also check to make sure we are not dealing with globaling the latest topic (pretty rare but still needs to be checked)
	if ($topic_type != 3 && !$make_global && ($post_approved || !$data['post_approved']))
	{
		// the last post makes us update the forum table. This can happen if...
		// We make a new topic
		// We reply to a topic
		// We edit the last post in a topic and this post is the latest in the forum (maybe)
		// We edit the only post in the topic
		// We edit the first post in the topic and all the other posts are not approved
		if (($post_mode == 'post' || $post_mode == 'reply') && $post_approved)
		{
			$sql_data[$db_prefix . "_forums"]['stat'][] = 'forum_last_post_id = ' . $data['post_id'];
			$sql_data[$db_prefix . "_forums"]['stat'][] = "forum_last_post_subject = '" . $db->sql_escape($subject) . "'";
			$sql_data[$db_prefix . "_forums"]['stat'][] = 'forum_last_post_time = ' . $current_time;
			$sql_data[$db_prefix . "_forums"]['stat'][] = 'forum_last_poster_id = ' . $user->id;
			$sql_data[$db_prefix . "_forums"]['stat'][] = "forum_last_poster_name = '" . $db->sql_escape((!$user->user && $username) ? $username : (($user->id != 0) ? $user->name : '')) . "'";
			$sql_data[$db_prefix . "_forums"]['stat'][] = "forum_last_poster_colour = '" . $db->sql_escape($user->color) . "'";
		}
		else if ($post_mode == 'edit_last_post' || $post_mode == 'edit_topic' || ($post_mode == 'edit_first_post' && !$data['topic_replies']))
		{
			// this does not _necessarily_ mean that we must update the info again,
			// it just means that we might have to
			$sql = 'SELECT forum_last_post_id, forum_last_post_subject
				FROM ' . $db_prefix . '_forums
				WHERE forum_id = ' . (int) $data['forum_id'];
			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			// this post is the latest post in the forum, better update
			if ($row['forum_last_post_id'] == $data['post_id'])
			{
				// If post approved and subject changed, or poster is anonymous, we need to update the forum_last* rows
				if ($post_approved && ($row['forum_last_post_subject'] !== $subject || $data['poster_id'] == 0))
				{
					// the post's subject changed
					if ($row['forum_last_post_subject'] !== $subject)
					{
						$sql_data[$db_prefix . "_forums"]['stat'][] = 'forum_last_post_subject = \'' . $db->sql_escape($subject) . '\'';
					}

					// Update the user name if poster is anonymous... just in case an admin changed it
					if ($data['poster_id'] == 0)
					{
						$sql_data[$db_prefix . "_forums"]['stat'][] = "forum_last_poster_name = '" . $db->sql_escape($username) . "'";
					}
				}
				else if ($data['post_approved'] !== $post_approved)
				{
					// we need a fresh change of socks, everything has become invalidated
					$sql = 'SELECT MAX(topic_last_post_id) as last_post_id
						FROM ' . $db_prefix . '_topics
						WHERE forum_id = ' . (int) $data['forum_id'] . '
							AND topic_approved = 1';
					$result = $db->sql_query($sql);
					$row = $db->sql_fetchrow($result);
					$db->sql_freeresult($result);

					// any posts left in this forum?
					if (!empty($row['last_post_id']))
					{
						$sql = 'SELECT p.post_id, p.post_subject, p.post_time, p.poster_id, p.post_username, u.id, u.username, u.can_do, L.group_colour AS user_colour
							FROM ' . $db_prefix . '_posts p, ' . $db_prefix . '_users u, '.$db_prefix.'_level_settings L
							WHERE p.poster_id = u.id
								AND p.post_id = ' . (int) $row['last_post_id'] .
								' AND L.group_id = u.can_do';
						$result = $db->sql_query($sql);
						$row = $db->sql_fetchrow($result);
						$db->sql_freeresult($result);

						// salvation, a post is found! jam it into the forums table
						$sql_data[$db_prefix . "_forums"]['stat'][] = 'forum_last_post_id = ' . (int) $row['post_id'];
						$sql_data[$db_prefix . "_forums"]['stat'][] = "forum_last_post_subject = '" . $db->sql_escape($row['post_subject']) . "'";
						$sql_data[$db_prefix . "_forums"]['stat'][] = 'forum_last_post_time = ' . (int) $row['post_time'];
						$sql_data[$db_prefix . "_forums"]['stat'][] = 'forum_last_poster_id = ' . (int) $row['poster_id'];
						$sql_data[$db_prefix . "_forums"]['stat'][] = "forum_last_poster_name = '" . $db->sql_escape(($row['poster_id'] == 0) ? $row['post_username'] : $row['username']) . "'";
						$sql_data[$db_prefix . "_forums"]['stat'][] = "forum_last_poster_colour = '" . $db->sql_escape($row['user_colour']) . "'";
					}
					else
					{
						// just our luck, the last topic in the forum has just been turned unapproved...
						$sql_data[$db_prefix . "_forums"]['stat'][] = 'forum_last_post_id = 0';
						$sql_data[$db_prefix . "_forums"]['stat'][] = "forum_last_post_subject = ''";
						$sql_data[$db_prefix . "_forums"]['stat'][] = 'forum_last_post_time = 0';
						$sql_data[$db_prefix . "_forums"]['stat'][] = 'forum_last_poster_id = 0';
						$sql_data[$db_prefix . "_forums"]['stat'][] = "forum_last_poster_name = ''";
						$sql_data[$db_prefix . "_forums"]['stat'][] = "forum_last_poster_colour = ''";
					}
				}
			}
		}
	}
	else if ($make_global)
	{
		// somebody decided to be a party pooper, we must recalculate the whole shebang (maybe)
		$sql = 'SELECT forum_last_post_id
			FROM ' . $db_prefix . '_forums
			WHERE forum_id = ' . (int) $data['forum_id'];
		$result = $db->sql_query($sql);
		$forum_row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		// we made a topic global, go get new data
		if ($topic_row['topic_type'] != 3 && $topic_type == 3 && $forum_row['forum_last_post_id'] == $topic_row['topic_last_post_id'])
		{
			// we need a fresh change of socks, everything has become invalidated
			$sql = 'SELECT MAX(topic_last_post_id) as last_post_id
				FROM ' . $db_prefix . '_topics
				WHERE forum_id = ' . (int) $data['forum_id'] . '
					AND topic_approved = 1';
			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			// any posts left in this forum?
			if (!empty($row['last_post_id']))
			{
				$sql = 'SELECT p.post_id, p.post_subject, p.post_time, p.poster_id, p.post_username, u.can_do, u.id, u.username, L.group_colour AS user_colour
					FROM ' . $db_prefix . '_posts p, ' . $db_prefix . '_users u, ' . $db_prefix . '_level_settings L
					WHERE p.poster_id = u.id
						AND p.post_id = ' . (int) $row['last_post_id'] .
						' AND L.group_id = u.can_do';
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				// salvation, a post is found! jam it into the forums table
				$sql_data[$db_prefix . "_forums"]['stat'][] = 'forum_last_post_id = ' . (int) $row['post_id'];
				$sql_data[$db_prefix . "_forums"]['stat'][] = "forum_last_post_subject = '" . $db->sql_escape($row['post_subject']) . "'";
				$sql_data[$db_prefix . "_forums"]['stat'][] = 'forum_last_post_time = ' . (int) $row['post_time'];
				$sql_data[$db_prefix . "_forums"]['stat'][] = 'forum_last_poster_id = ' . (int) $row['poster_id'];
				$sql_data[$db_prefix . "_forums"]['stat'][] = "forum_last_poster_name = '" . $db->sql_escape(($row['poster_id'] == 0) ? $row['post_username'] : $row['username']) . "'";
				$sql_data[$db_prefix . "_forums"]['stat'][] = "forum_last_poster_colour = '" . $db->sql_escape($row['user_colour']) . "'";
			}
			else
			{
				// just our luck, the last topic in the forum has just been globalized...
				$sql_data[$db_prefix . "_forums"]['stat'][] = 'forum_last_post_id = 0';
				$sql_data[$db_prefix . "_forums"]['stat'][] = "forum_last_post_subject = ''";
				$sql_data[$db_prefix . "_forums"]['stat'][] = 'forum_last_post_time = 0';
				$sql_data[$db_prefix . "_forums"]['stat'][] = 'forum_last_poster_id = 0';
				$sql_data[$db_prefix . "_forums"]['stat'][] = "forum_last_poster_name = ''";
				$sql_data[$db_prefix . "_forums"]['stat'][] = "forum_last_poster_colour = ''";
			}
		}
		else if ($topic_row['topic_type'] == 3 && $topic_type != 3 && $forum_row['forum_last_post_id'] < $topic_row['topic_last_post_id'])
		{
			// this post has a higher id, it is newer
			$sql = 'SELECT p.post_id, p.post_subject, p.post_time, p.poster_id, p.post_username, u.id, u.username, u.can_do, L.group_colour AS user_colour
				FROM ' . $db_prefix . '_posts p, ' . $db_prefix . '_users u, '.$db_prefix.'_level_settings L
				WHERE p.poster_id = u.id
					AND p.post_id = ' . (int) $topic_row['topic_last_post_id'] .
								' AND L.group_id = u.can_do';
			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			// salvation, a post is found! jam it into the forums table
			$sql_data[$db_prefix . "_forums"]['stat'][] = 'forum_last_post_id = ' . (int) $row['post_id'];
			$sql_data[$db_prefix . "_forums"]['stat'][] = "forum_last_post_subject = '" . $db->sql_escape($row['post_subject']) . "'";
			$sql_data[$db_prefix . "_forums"]['stat'][] = 'forum_last_post_time = ' . (int) $row['post_time'];
			$sql_data[$db_prefix . "_forums"]['stat'][] = 'forum_last_poster_id = ' . (int) $row['poster_id'];
			$sql_data[$db_prefix . "_forums"]['stat'][] = "forum_last_poster_name = '" . $db->sql_escape(($row['poster_id'] == 0) ? $row['post_username'] : $row['username']) . "'";
			$sql_data[$db_prefix . "_forums"]['stat'][] = "forum_last_poster_colour = '" . $db->sql_escape($row['user_colour']) . "'";
		}
	}

	// topic sync time!
	// simply, we update if it is a reply or the last post is edited
	if ($post_approved)
	{
		// reply requires the whole thing
		if ($post_mode == 'reply')
		{
			$sql_data[$db_prefix . "_topics"]['stat'][] = 'topic_last_post_id = ' . (int) $data['post_id'];
			$sql_data[$db_prefix . "_topics"]['stat'][] = 'topic_last_poster_id = ' . (int) $user->id;
			$sql_data[$db_prefix . "_topics"]['stat'][] = "topic_last_poster_name = '" . $db->sql_escape((!$user->user && $username) ? $username : (($user->id != 0) ? $user->name : '')) . "'";
			$sql_data[$db_prefix . "_topics"]['stat'][] = "topic_last_poster_colour = '" . (($user->id != 0) ? $db->sql_escape($user->color) : '') . "'";
			$sql_data[$db_prefix . "_topics"]['stat'][] = "topic_last_post_subject = '" . $db->sql_escape($subject) . "'";
			$sql_data[$db_prefix . "_topics"]['stat'][] = 'topic_last_post_time = ' . (int) $current_time;
		}
		else if ($post_mode == 'edit_last_post' || $post_mode == 'edit_topic' || ($post_mode == 'edit_first_post' && !$data['topic_replies']))
		{
			// only the subject can be changed from edit
			$sql_data[$db_prefix . "_topics"]['stat'][] = "topic_last_post_subject = '" . $db->sql_escape($subject) . "'";

			// Maybe not only the subject, but also changing anonymous usernames. ;)
			if ($data['poster_id'] == 0)
			{
				$sql_data[$db_prefix . "_topics"]['stat'][] = "topic_last_poster_name = '" . $db->sql_escape($username) . "'";
			}
		}
	}
	else if (!$data['post_approved'] && ($post_mode == 'edit_last_post' || $post_mode == 'edit_topic' || ($post_mode == 'edit_first_post' && !$data['topic_replies'])))
	{
		// like having the rug pulled from under us
		$sql = 'SELECT MAX(post_id) as last_post_id
			FROM ' . $db_prefix . '_posts
			WHERE topic_id = ' . (int) $data['topic_id'] . '
				AND post_approved = 1';
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		// any posts left in this forum?
		if (!empty($row['last_post_id']))
		{
			$sql = 'SELECT p.post_id, p.post_subject, p.post_time, p.poster_id, p.post_username, u.id, u.username, u.can_do, L.group_colour AS user_colour
				FROM ' . $db_prefix . '_posts p, ' . $db_prefix . '_users u, '.$db_prefix.'_level_settings L
				WHERE p.poster_id = u.id
					AND p.post_id = ' . (int) $row['last_post_id'] .
								' AND L.group_id = u.can_do';
			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			// salvation, a post is found! jam it into the topics table
			$sql_data[$db_prefix . "_topics"]['stat'][] = 'topic_last_post_id = ' . (int) $row['post_id'];
			$sql_data[$db_prefix . "_topics"]['stat'][] = "topic_last_post_subject = '" . $db->sql_escape($row['post_subject']) . "'";
			$sql_data[$db_prefix . "_topics"]['stat'][] = 'topic_last_post_time = ' . (int) $row['post_time'];
			$sql_data[$db_prefix . "_topics"]['stat'][] = 'topic_last_poster_id = ' . (int) $row['poster_id'];
			$sql_data[$db_prefix . "_topics"]['stat'][] = "topic_last_poster_name = '" . $db->sql_escape(($row['poster_id'] == 0) ? $row['post_username'] : $row['username']) . "'";
			$sql_data[$db_prefix . "_topics"]['stat'][] = "topic_last_poster_colour = '" . $db->sql_escape($row['user_colour']) . "'";
		}
	}

	// Update total post count, do not consider moderated posts/topics
	if ($post_approval)
	{
		if ($post_mode == 'post')
		{
			//set_config_count('num_topics', 1, true);
			//set_config_count('num_posts', 1, true);
		}

		if ($post_mode == 'reply')
		{
			//set_config_count('num_posts', 1, true);
		}
	}

	// Update forum stats
	$where_sql = array($db_prefix . "_posts" => 'post_id = ' . $data['post_id'], $db_prefix . "_topics" => 'topic_id = ' . $data['topic_id'], $db_prefix . "_forums" => 'forum_id = ' . $data['forum_id'], $db_prefix . '_users' => 'id = ' . $poster_id);

	foreach ($sql_data as $table => $update_ary)
	{
		if (isset($update_ary['stat']) && implode('', $update_ary['stat']))
		{
			$sql = "UPDATE $table SET " . implode(', ', $update_ary['stat']) . ' WHERE ' . $where_sql[$table];
			$db->sql_query($sql);
		}
	}

	// Delete topic shadows (if any exist). We do not need a shadow topic for an global announcement
	if ($make_global)
	{
		$sql = 'DELETE FROM ' . $db_prefix . '_topics
			WHERE topic_moved_id = ' . $data['topic_id'];
		$db->sql_query($sql);
	}

	// Committing the transaction before updating search index
	//$db->sql_transaction('commit');

	// Delete draft if post was loaded...
	$draft_id = request_var('draft_loaded', 0);
	if ($draft_id)
	{
		$sql = 'DELETE FROM ' . $db_prefix . "_drafts
			WHERE draft_id = $draft_id
				AND user_id = {$user->id}";
		$db->sql_query($sql);
	}

	// Index message contents
	if ($update_search_index && $data['enable_indexing'])
	{
		// Select the search method and do some additional checks to ensure it can actually be utilised
		$search_type = basename($config['search_type']);

		if (!file_exists($phpbb_root_path . 'includes/search/' . $search_type . '.' . $phpEx))
		{
			trigger_error('NO_SUCH_SEARCH_MODULE');
		}

		if (!class_exists($search_type))
		{
			include("{$phpbb_root_path}includes/search/$search_type.$phpEx");
		}

		$error = false;
		$search = new $search_type($error);

		if ($error)
		{
			trigger_error($error);
		}

		$search->index($mode, $data['post_id'], $data['message'], $subject, $poster_id, ($topic_type == POST_GLOBAL) ? 0 : $data['forum_id']);
	}
	// Topic Notification, do not change if moderator is changing other users posts...
	if ($user->id == $poster_id)
	{
		if (!$data['notify_set'] && $data['notify'])
		{
			$sql = 'INSERT INTO ' . $db_prefix . '_topics_watch (user_id, topic_id)
				VALUES (' . $user->id . ', ' . $data['topic_id'] . ')';
			$db->sql_query($sql);
		}
		else if ($data['notify_set'] && !$data['notify'])
		{
			$sql = 'DELETE FROM ' . $db_prefix . '_topics_watch
				WHERE user_id = ' . $user->id . '
					AND topic_id = ' . $data['topic_id'];
			$db->sql_query($sql);
		}
	}

	if ($mode == 'post' || $mode == 'reply' || $mode == 'quote')
	{
		// Mark this topic as posted to
		markread('post', $data['forum_id'], $data['topic_id'], $data['post_time']);
	}

	// Mark this topic as read
	// We do not use post_time here, this is intended (post_time can have a date in the past if editing a message)
	markread('topic', $data['forum_id'], $data['topic_id'], time());

	//
	if ($user->user)
	{
		$sql = 'SELECT mark_time
			FROM ' . $db_prefix.'_forums_watch
			WHERE user_id = ' . $user->id . '
				AND forum_id = ' . $data['forum_id'];
		$result = $db->sql_query($sql);
		$f_mark_time = (int) $db->sql_fetchfield('mark_time');
		$db->sql_freeresult($result);
	}

	if ($user->user)
	{
		// Update forum info
		$sql = 'SELECT forum_last_post_time
			FROM ' . $db_prefix . '_forums
			WHERE forum_id = ' . $data['forum_id'];
		$result = $db->sql_query($sql);
		$forum_last_post_time = (int) $db->sql_fetchfield('forum_last_post_time');
		$db->sql_freeresult($result);

		update_forum_tracking_info($data['forum_id'], $forum_last_post_time, $f_mark_time, false);
	}


	$params = $add_anchor = '';

	if ($post_approval)
	{
		$params .= '&t=' . $data['topic_id'];

		if ($mode != 'post')
		{
			$params .= '&p=' . $data['post_id'];
			$add_anchor = '#p' . $data['post_id'];
		}
	}
	else if ($mode != 'post' && $post_mode != 'edit_first_post' && $post_mode != 'edit_topic')
	{
		$params .= '&t=' . $data['topic_id'];
	}
	
	if(!$params)
	{
		$url = "{$phpbb_root_path}forum.$phpEx?action=viewforum&f=" . $data['forum_id'] . $add_anchor;
	}
	else
	{
		$url = "{$phpbb_root_path}forum.$phpEx?action=viewtopic&f=" . $data['forum_id'] . $params . $add_anchor;
	}
	// Send Notifications
	if ($mode != 'edit' && $mode != 'delete' && $post_approval)
	{
		user_notification($mode, $subject, $data['topic_title'], $data['forum_name'], $data['forum_id'], $data['topic_id'], $data['post_id']);
		global $shout_config;
		if($shout_config['turn_on']=='yes')
		{
			if(($mode == 'reply' || $mode == 'quote') AND $config['shout_new_post'])
			{
				$text = sprintf($user->lang['SHOUT_REPLY'], $url, $data['topic_title']);
				bt_shout($user->id, $text, 0, $data['forum_id']);
			}
			elseif($mode == 'post' AND $config['shout_new_topic'])
			{
				$text = sprintf($user->lang['SHOUT_POST'], $url, $data['forum_name']);
				bt_shout($user->id, $text, 0, $data['forum_id']);
			}
		}
	}


	return $url;
}
/**
* User Notification
*/
function user_notification($mode, $subject, $topic_title, $forum_name, $forum_id, $topic_id, $post_id, $author_name = '')
{
	global $db, $user, $config, $phpbb_root_path, $phpEx, $auth, $db_prefix;

	$topic_notification = ($mode == 'reply' || $mode == 'quote') ? true : false;
	$forum_notification = ($mode == 'post') ? true : false;

	if (!$topic_notification && !$forum_notification)
	{
		trigger_error('NO_MODE');
	}
	if (($topic_notification && !$config['allow_topic_notify']) || ($forum_notification && !$config['allow_forum_notify']))
	{
		return;
	}

	$topic_title = ($topic_notification) ? $topic_title : $subject;
	$topic_title = censor_text($topic_title);

	// Exclude guests, current user and banned users from notifications
	$sql = "SELECT id FROM ".$db_prefix."_users WHERE ban = 1;";
	$res = $db->sql_query($sql);
	$sql_ignore_users = array();
	while ($ban = $db->sql_fetchrow($res)) {
		$user_id = (int) $ban['id'];
		$sql_ignore_users[$user_id] = $user_id;
	}
	$db->sql_freeresult($res);
	$sql_ignore_users[0] = 0;
	$sql_ignore_users[$user->id] = $user->id;

	$notify_rows = array();

	// -- get forum_userids	|| topic_userids
	$sql = 'SELECT u.id AS user_id, u.username, u.email AS user_email, u.language AS user_lang, u.user_notify_type, u.jabber AS user_jabber
		FROM ' . (($topic_notification) ? $db_prefix . '_topics_watch' : $db_prefix . '_forums_watch') . ' w, ' . $db_prefix . '_users u
		WHERE w.' . (($topic_notification) ? 'topic_id' : 'forum_id') . ' = ' . (($topic_notification) ? $topic_id : $forum_id) . '
			AND ' . $db->sql_in_set('w.user_id', $sql_ignore_users, true) . '
			AND w.notify_status = 0
			AND u.user_type IN (0, 3)
			AND u.id = w.user_id';
	$result = $db->sql_query($sql);

	while ($row = $db->sql_fetchrow($result))
	{
		$notify_user_id = (int) $row['user_id'];
		$notify_rows[$notify_user_id] = array(
			'user_id'		=> $notify_user_id,
			'username'		=> $row['username'],
			'user_email'	=> $row['user_email'],
			'user_jabber'	=> $row['user_jabber'],
			'user_lang'		=> $row['user_lang'],
			'notify_type'	=> ($topic_notification) ? 'topic' : 'forum',
			'template'		=> ($topic_notification) ? 'topic_notify' : 'newtopic_notify',
			'method'		=> $row['user_notify_type'],
			'allowed'		=> false
		);

		// Add users who have been already notified to ignore list
		$sql_ignore_users[$notify_user_id] = $notify_user_id;
	}
	$db->sql_freeresult($result);

	// forum notification is sent to those not already receiving topic notifications
	if ($topic_notification)
	{
		$sql = 'SELECT u.id AS user_id, u.username, u.email AS user_email, u.language AS user_lang, u.user_notify_type, u.jabber AS user_jabber
			FROM ' . $db_prefix . '_forums_watch fw, ' . $db_prefix . "_users u
			WHERE fw.forum_id = $forum_id
				AND " . $db->sql_in_set('fw.user_id', $sql_ignore_users, true) . '
				AND fw.notify_status = 0
				AND u.user_type IN (0, 3)
				AND u.id = fw.user_id';
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$notify_user_id = (int) $row['user_id'];
			$notify_rows[$notify_user_id] = array(
				'user_id'		=> $notify_user_id,
				'username'		=> $row['username'],
				'user_email'	=> $row['user_email'],
				'user_jabber'	=> $row['user_jabber'],
				'user_lang'		=> $row['user_lang'],
				'notify_type'	=> 'forum',
				'template'		=> 'forum_notify',
				'method'		=> $row['user_notify_type'],
				'allowed'		=> false
			);
		}
		$db->sql_freeresult($result);
	}

	if (!sizeof($notify_rows))
	{
		return;
	}

	// Make sure users are allowed to read the forum
	foreach ($auth->acl_get_list(array_keys($notify_rows), 'f_read', $forum_id) as $forum_id => $forum_ary)
	{
		foreach ($forum_ary as $auth_option => $user_ary)
		{
			foreach ($user_ary as $user_id)
			{
				$notify_rows[$user_id]['allowed'] = true;
			}
		}
	}

	// Now, we have to do a little step before really sending, we need to distinguish our users a little bit. ;)
	$msg_users = $delete_ids = $update_notification = array();
	foreach ($notify_rows as $user_id => $row)
	{
		if (!$row['allowed'] || !trim($row['user_email']))
		{
			$delete_ids[$row['notify_type']][] = $row['user_id'];
		}
		else
		{
			$msg_users[] = $row;
			$update_notification[$row['notify_type']][] = $row['user_id'];

			/*
			* We also update the forums watch table for this user when we are
			* sending out a topic notification to prevent sending out another
			* notification in case this user is also subscribed to the forum
			* this topic was posted in.
			* Since an UPDATE query is used, this has no effect on users only
			* subscribed to the topic (i.e. no row is created) and should not
			* be a performance issue.
			*/
			if ($row['notify_type'] === 'topic')
			{
				$update_notification['forum'][] = $row['user_id'];
			}
		}
	}
//die(print_r($notify_rows));
	unset($notify_rows);//die(print_r($msg_users));

	// Now, we are able to really send out notifications
	if (sizeof($msg_users))
	{
		include_once('include/function_messenger.php');

		$msg_list_ary = array();
		foreach ($msg_users as $row)
		{
			$pos = (!isset($msg_list_ary[$row['template']])) ? 0 : sizeof($msg_list_ary[$row['template']]);

			$msg_list_ary[$row['template']][$pos]['method']	= $row['method'];
			$msg_list_ary[$row['template']][$pos]['email']	= $row['user_email'];
			$msg_list_ary[$row['template']][$pos]['jabber']	= $row['user_jabber'];
			$msg_list_ary[$row['template']][$pos]['name']	= $row['username'];
			$msg_list_ary[$row['template']][$pos]['lang']	= $row['user_lang'];
			$msg_list_ary[$row['template']][$pos]['user_id']= $row['user_id'];
		}
		unset($msg_users);

		foreach ($msg_list_ary as $email_template => $email_list)
		{
			//die(print_r($email_template));
			foreach ($email_list as $addr)
			{
		$messenger = new messenger();
				$messenger->template($email_template, $addr['lang']);

				$messenger->to($addr['email'], $addr['name']);
				$messenger->im($addr['jabber'], $addr['name']);

				$messenger->assign_vars(array(
					'USERNAME'		=> htmlspecialchars_decode($addr['name']),
					'TOPIC_TITLE'	=> htmlspecialchars_decode($topic_title),
					'FORUM_NAME'	=> htmlspecialchars_decode($forum_name),
					'AUTHOR_NAME'	=> htmlspecialchars_decode($author_name),

					'U_FORUM'				=> generate_board_url() . "/forum.php?action=viewforum&f=$forum_id",
					'U_TOPIC'				=> generate_board_url() . "/forum.php?action=viewtopic&f=$forum_id&t=$topic_id",
					'U_NEWEST_POST'			=> generate_board_url() . "/forum.php?action=viewtopic&f=$forum_id&t=$topic_id&p=$post_id&e=$post_id",
					'U_STOP_WATCHING_TOPIC'	=> generate_board_url() . "/forum.php?action=viewtopic&uid={$addr['user_id']}&f=$forum_id&t=$topic_id&unwatch=topic",
					'U_STOP_WATCHING_FORUM'	=> generate_board_url() . "/forum.php?action=viewforum&uid={$addr['user_id']}&f=$forum_id&unwatch=forum",
				));

				$messenger->send(0);
				$messenger->save_queue();
			}
		}
		unset($msg_list_ary);

	}

	// Handle the DB updates

	if (!empty($update_notification['topic']))
	{
		$sql = 'UPDATE ' . $db_prefix . '_topics_watch
			SET notify_status = ' . 1 . "
			WHERE topic_id = $topic_id
				AND " . $db->sql_in_set('user_id', $update_notification['topic']);
		$db->sql_query($sql);
	}

	if (!empty($update_notification['forum']))
	{
		$sql = 'UPDATE ' . $db_prefix . '_forums_watch
			SET notify_status = ' . 1 . "
			WHERE forum_id = $forum_id
				AND " . $db->sql_in_set('user_id', $update_notification['forum']);
		$db->sql_query($sql);
	}

	// Now delete the user_ids not authorised to receive notifications on this topic/forum
	if (!empty($delete_ids['topic']))
	{
		$sql = 'DELETE FROM ' . $db_prefix . "_topics_watch
			WHERE topic_id = $topic_id
				AND " . $db->sql_in_set('user_id', $delete_ids['topic']);
		$db->sql_query($sql);
	}

	if (!empty($delete_ids['forum']))
	{
		$sql = 'DELETE FROM ' . $db_prefix . "_forums_watch
			WHERE forum_id = $forum_id
				AND " . $db->sql_in_set('user_id', $delete_ids['forum']);
		$db->sql_query($sql);
	}

}
function topic_review($topic_id, $forum_id, $mode = 'topic_review', $cur_post_id = 0, $show_quote_button = true)
{
	global $user, $auth, $db, $template, $bbcode, $pmbt_cache;
	global $config, $phpbb_root_path, $phpEx, $db_prefix;

	// Go ahead and pull all data for this topic
	$sql = 'SELECT p.post_id
		FROM ' . $db_prefix . '_posts p' . "
		WHERE p.topic_id = $topic_id
			" . ((!$auth->acl_get('m_approve', $forum_id)) ? 'AND p.post_approved = 1' : '') . '
			' . (($mode == 'post_review') ? " AND p.post_id > $cur_post_id" : '') . '
		ORDER BY p.post_time ';
	$sql .= ($mode == 'post_review') ? 'ASC' : 'DESC';
	$sql .= 'LIMIT ' . $torrent_per_page;
	$result = $db->sql_query($sql);

	$post_list = array();

	while ($row = $db->sql_fetchrow($result))
	{
		$post_list[] = $row['post_id'];
	}

	$db->sql_freeresult($result);

	if (!sizeof($post_list))
	{
		return false;
	}

	$sql = $db->sql_build_query('SELECT', array(
	'SELECT'	=> 'u.*, z.friend, z.foe, p.*, L.group_colour AS user_colour',

	'FROM'		=> array(
		$db_prefix . '_users'		=> 'u',
		$db_prefix . '_posts'		=> 'p',
		$db_prefix."_level_settings"=> 'L',
	),

	'LEFT_JOIN'	=> array(
		array(
			'FROM'	=> array($db_prefix . '_zebra' => 'z'),
			'ON'	=> 'z.user_id = ' . $user->id . ' AND z.zebra_id = p.poster_id AND L.group_id = u.can_do'
		)
	),

	'WHERE'		=> $db->sql_in_set('p.post_id', $post_list) . '
		AND u.id = p.poster_id'
	));

	$result = $db->sql_query($sql);

	$bbcode_bitfield = '';
	$rowset = array();
	$has_attachments = false;
	while ($row = $db->sql_fetchrow($result))
	{
		$rowset[$row['post_id']] = $row;
		$bbcode_bitfield = $bbcode_bitfield | base64_decode($row['bbcode_bitfield']);

		if ($row['post_attachment'])
		{
			$has_attachments = true;
		}
	}
	$db->sql_freeresult($result);

	// Instantiate BBCode class
	if (!isset($bbcode) && $bbcode_bitfield !== '')
	{
		include_once($phpbb_root_path . 'include/bbcode.' . $phpEx);
		$bbcode = new bbcode(base64_encode($bbcode_bitfield));
	}

	// Grab extensions
	$extensions = $attachments = array();
	if ($has_attachments && $auth->acl_get('u_download') && $auth->acl_get('f_download', $forum_id))
	{
		$extensions = $pmbt_cache->obtain_attach_extensions($forum_id);

		// Get attachments...
		$sql = 'SELECT *
			FROM ' . $db_prefix . '_attachments
			WHERE ' . $db->sql_in_set('post_msg_id', $post_list) . '
				AND in_message = 0
			ORDER BY filetime DESC, post_msg_id ASC';
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$attachments[$row['post_msg_id']][] = $row;
		}
		$db->sql_freeresult($result);
	}

	for ($i = 0, $end = sizeof($post_list); $i < $end; ++$i)
	{
		// A non-existing rowset only happens if there was no user present for the entered poster_id
		// This could be a broken posts table.
		if (!isset($rowset[$post_list[$i]]))
		{
			continue;
		}

		$row =& $rowset[$post_list[$i]];

		$poster_id		= $row['user_id'];
		$post_subject	= $row['post_subject'];
		$message		= censor_text($row['post_text']);

		$decoded_message = false;

		if ($show_quote_button && $auth->acl_get('f_reply', $forum_id))
		{
			$decoded_message = $message;
			decode_message($decoded_message, $row['bbcode_uid']);

			$decoded_message = bbcode_nl2br($decoded_message);
		}

		if ($row['bbcode_bitfield'])
		{
			$bbcode->bbcode_second_pass($message, $row['bbcode_uid'], $row['bbcode_bitfield']);
		}

		$message = bbcode_nl2br($message);
		$message = smiley_text($message, !$row['enable_smilies']);

		if (!empty($attachments[$row['post_id']]))
		{
			$update_count = array();
			parse_attachments($forum_id, $message, $attachments[$row['post_id']], $update_count);
		}

		$post_subject = censor_text($post_subject);

		$post_anchor = ($mode == 'post_review') ? 'ppr' . $row['post_id'] : 'pr' . $row['post_id'];
		$u_show_post = append_sid($phpbb_root_path . 'viewtopic.' . $phpEx, "f=$forum_id&amp;t=$topic_id&amp;p={$row['post_id']}&amp;view=show#p{$row['post_id']}");

		$template->assign_block_vars($mode . '_row', array(
			'POST_AUTHOR_FULL'		=> get_username_string('full', $poster_id, $row['username'], $row['user_colour'], $row['post_username']),
			'POST_AUTHOR_COLOUR'	=> get_username_string('colour', $poster_id, $row['username'], $row['user_colour'], $row['post_username']),
			'POST_AUTHOR'			=> get_username_string('username', $poster_id, $row['username'], $row['user_colour'], $row['post_username']),
			'U_POST_AUTHOR'			=> get_username_string('profile', $poster_id, $row['username'], $row['user_colour'], $row['post_username']),

			'S_HAS_ATTACHMENTS'	=> (!empty($attachments[$row['post_id']])) ? true : false,
			'S_FRIEND'			=> ($row['friend']) ? true : false,
			'S_IGNORE_POST'		=> ($row['foe']) ? true : false,
			'L_IGNORE_POST'		=> ($row['foe']) ? sprintf($user->lang['POST_BY_FOE'], get_username_string('full', $poster_id, $row['username'], $row['user_colour'], $row['post_username']), "<a href=\"{$u_show_post}\" onclick=\"dE('{$post_anchor}', 1); return false;\">", '</a>') : '',

			'POST_SUBJECT'		=> $post_subject,
			'MINI_POST_IMG'		=> $user->img('icon_post_target', $user->lang['POST']),
			'POST_DATE'			=> $user->format_date($row['post_time']),
			'MESSAGE'			=> $message,
			'DECODED_MESSAGE'	=> $decoded_message,
			'POST_ID'			=> $row['post_id'],
			'U_MINI_POST'		=> append_sid("{$phpbb_root_path}forum.$phpEx?action=viewtopic", 'p=' . $row['post_id']) . '#p' . $row['post_id'],
			'U_MCP_DETAILS'		=> ($auth->acl_get('m_info', $forum_id)) ? append_sid("{$phpbb_root_path}forum.$phpEx?action_mcp=mcp", 'i=main&amp;mode=post_details&amp;f=' . $forum_id . '&amp;p=' . $row['post_id'], true, $user->session_id) : '',
			'POSTER_QUOTE'		=> ($show_quote_button && $auth->acl_get('f_reply', $forum_id)) ? addslashes(get_username_string('username', $poster_id, $row['username'], $row['user_colour'], $row['post_username'])) : '')
		);

		// Display not already displayed Attachments for this post, we already parsed them. ;)
		if (!empty($attachments[$row['post_id']]))
		{
			foreach ($attachments[$row['post_id']] as $attachment)
			{
				$template->assign_block_vars($mode . '_row.attachment', array(
					'DISPLAY_ATTACHMENT'	=> $attachment)
				);
			}
		}

		unset($rowset[$i]);
	}

	if ($mode == 'topic_review')
	{
		$template->assign_var('QUOTE_IMG', $user->img('icon_post_quote', $user->lang['REPLY_WITH_QUOTE']));
	}

	return true;
}
function upload_popup($forum_style = 0)
{
	global $template, $user;

	($forum_style) ? $user->setup('posting', $forum_style) : $user->setup('posting');

	page_header($user->lang['PROGRESS_BAR']);

	$template->set_filenames(array(
		'popup'	=> 'posting_progress_bar.html')
	);

	$template->assign_vars(array(
		'PROGRESS_BAR'	=> $user->img('upload_bar', $user->lang['UPLOAD_IN_PROGRESS']))
	);

	$template->display('popup');

	garbage_collection();
	exit_handler();
}

/**
* Do the various checks required for removing posts as well as removing it
*/
function handle_post_delete($forum_id, $topic_id, $post_id, &$post_data)
{
	global $user, $db, $auth, $config, $db_prefix;
	global $phpbb_root_path, $phpEx;

	// If moderator removing post or user itself removing post, present a confirmation screen
	if ($auth->acl_get('m_delete', $forum_id) || ($post_data['poster_id'] == $user->id && $user->user && $auth->acl_get('f_delete', $forum_id) && $post_id == $post_data['topic_last_post_id'] && !$post_data['post_edit_locked'] && ($post_data['post_time'] > time() - ($config['edit_time'] * 60) || !$config['edit_time'])))
	{
		$s_hidden_fields = build_hidden_fields(array(
			'p'		=> $post_id,
			'f'		=> $forum_id,
			'action'=> 'posting',
			'mode'	=> 'delete')
		);

		if (confirm_box(true))
		{
			$data = array(
				'topic_first_post_id'	=> $post_data['topic_first_post_id'],
				'topic_last_post_id'	=> $post_data['topic_last_post_id'],
				'topic_replies_real'	=> $post_data['topic_replies_real'],
				'topic_approved'		=> $post_data['topic_approved'],
				'topic_type'			=> $post_data['topic_type'],
				'post_approved'			=> $post_data['post_approved'],
				'post_reported'			=> $post_data['post_reported'],
				'post_time'				=> $post_data['post_time'],
				'poster_id'				=> $post_data['poster_id'],
				'post_postcount'		=> $post_data['post_postcount']
			);

			$next_post_id = delete_post($forum_id, $topic_id, $post_id, $data);

			if ($next_post_id === false)
			{
				add_log('mod','LOG_DELETE_TOPIC', $post_data['topic_title']);

				$meta_info = append_sid("{$phpbb_root_path}forum.$phpEx?action=viewforum", "f=$forum_id");
				$message = $user->lang['POST_DELETED'];
			}
			else
			{

				add_log('mod',$forum,$topic_id, 'LOG_DELETE_POST',$post_data['post_subject']);
				$meta_info = append_sid("{$phpbb_root_path}forum.$phpEx?action=viewtopic", "f=$forum_id&amp;t=$topic_id&amp;p=$next_post_id") . "#p$next_post_id";
				$message = $user->lang['POST_DELETED'] . '<br /><br />' . sprintf($user->lang['RETURN_TOPIC'], '<a href="' . $meta_info . '">', '</a>');
			}

			meta_refresh(3, $meta_info);
			$message .= '<br /><br />' . sprintf($user->lang['RETURN_FORUM'], '<a href="' . append_sid("{$phpbb_root_path}forum.$phpEx?action=viewforum", 'f=' . $forum_id) . '">', '</a>');
			trigger_error($message);
			die();
		}
		else
		{
			confirm_box(false, 'DELETE_POST', $s_hidden_fields,'confirm_body.html',append_sid("{$phpbb_root_path}forum.$phpEx"));
		}
	}

	// If we are here the user is not able to delete - present the correct error message
	if ($post_data['poster_id'] != $user->id && $auth->acl_get('f_delete', $forum_id))
	{
		trigger_error('DELETE_OWN_POSTS');
	}

	if ($post_data['poster_id'] == $user->id && $auth->acl_get('f_delete', $forum_id) && $post_id != $post_data['topic_last_post_id'])
	{
		trigger_error('CANNOT_DELETE_REPLIED');
	}

	trigger_error('USER_CANNOT_DELETE');
}

function delete_post($forum_id, $topic_id, $post_id, &$data)
{
	global $db, $user, $auth, $db_prefix;
	global $config, $phpEx, $phpbb_root_path;

	// Specify our post mode
	$post_mode = 'delete';
	if (($data['topic_first_post_id'] === $data['topic_last_post_id']) && $data['topic_replies_real'] == 0)
	{
		$post_mode = 'delete_topic';
	}
	else if ($data['topic_first_post_id'] == $post_id)
	{
		$post_mode = 'delete_first_post';
	}
	else if ($data['topic_last_post_id'] == $post_id)
	{
		$post_mode = 'delete_last_post';
	}
	$sql_data = array();
	$next_post_id = false;

	include_once($phpbb_root_path . 'admin/functions.' . $phpEx);



	// we must make sure to update forums that contain the shadow'd topic
	if ($post_mode == 'delete_topic')
	{
		$shadow_forum_ids = array();

		$sql = 'SELECT forum_id
			FROM ' . $db_prefix . '_topics
			WHERE ' . $db->sql_in_set('topic_moved_id', $topic_id);
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			if (!isset($shadow_forum_ids[(int) $row['forum_id']]))
			{
				$shadow_forum_ids[(int) $row['forum_id']] = 1;
			}
			else
			{
				$shadow_forum_ids[(int) $row['forum_id']]++;
			}
		}
		$db->sql_freeresult($result);
	}

	if (!delete_posts('post_id', array($post_id), false, false))
	{
		// Try to delete topic, we may had an previous error causing inconsistency
		if ($post_mode == 'delete_topic')
		{
			delete_topics('topic_id', array($topic_id), false);
		}
		trigger_error('ALREADY_DELETED');
	}

	//$db->sql_transaction('commit');

	// Collect the necessary information for updating the tables
	$sql_data[$db_prefix . '_forums'] = '';
	switch ($post_mode)
	{
		case 'delete_topic':

			foreach ($shadow_forum_ids as $updated_forum => $topic_count)
			{
				// counting is fun! we only have to do sizeof($forum_ids) number of queries,
				// even if the topic is moved back to where its shadow lives (we count how many times it is in a forum)
				$db->sql_query('UPDATE ' . $db_prefix . '_forums SET forum_topics_real = forum_topics_real - ' . $topic_count . ', forum_topics = forum_topics - ' . $topic_count . ' WHERE forum_id = ' . $updated_forum);
				update_post_information('forum', $updated_forum);
			}

			delete_topics('topic_id', array($topic_id), false);

			if ($data['topic_type'] != 3)
			{
				$sql_data[$db_prefix . '_forums'] .= 'forum_topics_real = forum_topics_real - 1';
				$sql_data[$db_prefix . '_forums'] .= ($data['topic_approved']) ? ', forum_posts = forum_posts - 1, forum_topics = forum_topics - 1' : '';
			}

			$update_sql = update_post_information('forum', $forum_id, true);
			if (sizeof($update_sql))
			{
				$sql_data[$db_prefix . '_forums'] .= ($sql_data[$db_prefix . '_forums']) ? ', ' : '';
				$sql_data[$db_prefix . '_forums'] .= implode(', ', $update_sql[$forum_id]);
			}
		break;

		case 'delete_first_post':
			$sql = 'SELECT p.post_id, p.poster_id, p.post_username, u.username, u.can_do , l.group_colour AS user_colour
				FROM ' . $db_prefix . '_posts p, ' . $db_prefix . '_users u, ' . $db_prefix . "_level_settings l
				WHERE p.topic_id = $topic_id
					AND p.poster_id = u.id
					AND l.group_id = u.can_do
				ORDER BY p.post_time ASC LIMIT 1";
			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			if ($data['topic_type'] != 3)
			{
				$sql_data[$db_prefix . '_forums'] = ($data['post_approved']) ? 'forum_posts = forum_posts - 1' : '';
			}

			$sql_data[$db_prefix . "_topics"] = 'topic_poster = ' . intval($row['poster_id']) . ', topic_first_post_id = ' . intval($row['post_id']) . ", topic_first_poster_colour = '" . $db->sql_escape($row['user_colour']) . "', topic_first_poster_name = '" . (($row['poster_id'] == 0) ? $db->sql_escape($row['post_username']) : $db->sql_escape($row['username'])) . "'";

			// Decrementing topic_replies here is fine because this case only happens if there is more than one post within the topic - basically removing one "reply"
			$sql_data[$db_prefix . "_topics"] .= ', topic_replies_real = topic_replies_real - 1' . (($data['post_approved']) ? ', topic_replies = topic_replies - 1' : '');

			$next_post_id = (int) $row['post_id'];
		break;

		case 'delete_last_post':
			if ($data['topic_type'] != 3)
			{
				$sql_data[$db_prefix . '_forums'] = ($data['post_approved']) ? 'forum_posts = forum_posts - 1' : '';
			}

			$update_sql = update_post_information('forum', $forum_id, true);
			if (sizeof($update_sql))
			{
				$sql_data[$db_prefix . '_forums'] .= ($sql_data[$db_prefix . '_forums']) ? ', ' : '';
				$sql_data[$db_prefix . '_forums'] .= implode(', ', $update_sql[$forum_id]);
			}

			$sql_data[$db_prefix . "_topics"] = 'topic_bumped = 0, topic_bumper = 0, topic_replies_real = topic_replies_real - 1' . (($data['post_approved']) ? ', topic_replies = topic_replies - 1' : '');

			$update_sql = update_post_information('topic', $topic_id, true);
			if (sizeof($update_sql))
			{
				$sql_data[$db_prefix . "_topics"] .= ', ' . implode(', ', $update_sql[$topic_id]);
				$next_post_id = (int) str_replace('topic_last_post_id = ', '', $update_sql[$topic_id][0]);
			}
			else
			{
				$sql = 'SELECT MAX(post_id) as last_post_id
					FROM ' . $db_prefix . "_posts
					WHERE topic_id = $topic_id " .
						((!$auth->acl_get('m_approve', $forum_id)) ? 'AND post_approved = 1' : '');
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				$next_post_id = (int) $row['last_post_id'];
			}
		break;

		case 'delete':
			$sql = 'SELECT post_id
				FROM ' . $db_prefix . "_posts
				WHERE topic_id = $topic_id " .
					((!$auth->acl_get('m_approve', $forum_id)) ? 'AND post_approved = 1' : '') . '
					AND post_time > ' . $data['post_time'] . '
				ORDER BY post_time ASC LIMIT 1';
			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			if ($data['topic_type'] != 3)
			{
				$sql_data[$db_prefix . '_forums'] = ($data['post_approved']) ? 'forum_posts = forum_posts - 1' : '';
			}

			$sql_data[$db_prefix . "_topics"] = 'topic_replies_real = topic_replies_real - 1' . (($data['post_approved']) ? ', topic_replies = topic_replies - 1' : '');
			$next_post_id = (int) $row['post_id'];
		break;
	}

	$sql_data[$db_prefix . "_users"] = ($data['post_postcount']) ? 'user_posts = user_posts - 1' : '';

	$where_sql = array(
		$db_prefix . '_forums'	=> "forum_id = $forum_id",
		$db_prefix . "_topics"	=> "topic_id = $topic_id",
		$db_prefix . '_users'		=> 'id = ' . $data['poster_id']
	);

	foreach ($sql_data as $table => $update_sql)
	{
		if ($update_sql)
		{
			$db->sql_query("UPDATE $table SET $update_sql WHERE " . $where_sql[$table]);
		}
	}

	// Adjust posted info for this user by looking for a post by him/her within this topic...
	if ($post_mode != 'delete_topic' && $config['load_db_track'] && $data['poster_id'] != 0)
	{
		$sql = 'SELECT poster_id
			FROM ' . $db_prefix . '_posts
			WHERE topic_id = ' . $topic_id . '
				AND poster_id = ' . $data['poster_id'] . ' LIMIT 1';
		$result = $db->sql_query($sql);
		$poster_id = (int) $db->sql_fetchfield('poster_id');
		$db->sql_freeresult($result);

		// The user is not having any more posts within this topic
		if (!$poster_id)
		{
			$sql = 'DELETE FROM ' . $db_prefix . '_topics_posts
				WHERE topic_id = ' . $topic_id . '
					AND user_id = ' . $data['poster_id'];
			$db->sql_query($sql);
		}
	}


	if ($data['post_reported'] && ($post_mode != 'delete_topic'))
	{
		sync('topic_reported', 'topic_id', array($topic_id));
	}

	return $next_post_id;
}
function update_post_information($type, $ids, $return_update_sql = false)
{
	global $db, $db_prefix;

	if (empty($ids))
	{
		return;
	}
	if (!is_array($ids))
	{
		$ids = array($ids);
	}


	$update_sql = $empty_forums = $not_empty_forums = array();

	if ($type != 'topic')
	{
		$topic_join = ', ' . $db_prefix.'_topics t';
		$topic_condition = 'AND t.topic_id = p.topic_id AND t.topic_approved = 1';
	}
	else
	{
		$topic_join = '';
		$topic_condition = '';
	}

	if (sizeof($ids) == 1)
	{
		$sql = 'SELECT MAX(p.post_id) as last_post_id
			FROM ' . $db_prefix."_posts p $topic_join
			WHERE " . $db->sql_in_set('p.' . $type . '_id', $ids) . "
				$topic_condition
				AND p.post_approved = 1";
	}
	else
	{
		$sql = 'SELECT p.' . $type . '_id, MAX(p.post_id) as last_post_id
			FROM ' . $db_prefix."_posts p $topic_join
			WHERE " . $db->sql_in_set('p.' . $type . '_id', $ids) . "
				$topic_condition
				AND p.post_approved = 1
			GROUP BY p.{$type}_id";
	}
	$result = $db->sql_query($sql);

	$last_post_ids = array();
	while ($row = $db->sql_fetchrow($result))
	{
		if (sizeof($ids) == 1)
		{
			$row[$type . '_id'] = $ids[0];
		}

		if ($type == 'forum')
		{
			$not_empty_forums[] = $row['forum_id'];

			if (empty($row['last_post_id']))
			{
				$empty_forums[] = $row['forum_id'];
			}
		}

		$last_post_ids[] = $row['last_post_id'];
	}
	$db->sql_freeresult($result);

	if ($type == 'forum')
	{
		$empty_forums = array_merge($empty_forums, array_diff($ids, $not_empty_forums));

		foreach ($empty_forums as $void => $forum_id)
		{
			$update_sql[$forum_id][] = 'forum_last_post_id = 0';
			$update_sql[$forum_id][] = "forum_last_post_subject = ''";
			$update_sql[$forum_id][] = 'forum_last_post_time = 0';
			$update_sql[$forum_id][] = 'forum_last_poster_id = 0';
			$update_sql[$forum_id][] = "forum_last_poster_name = ''";
			$update_sql[$forum_id][] = "forum_last_poster_colour = ''";
		}
	}

	if (sizeof($last_post_ids))
	{
		$sql = 'SELECT p.' . $type . '_id, p.post_id, p.post_subject, p.post_time, p.poster_id, p.post_username, u.id, u.username, u.can_do , l.group_colour AS user_colour
			FROM ' . $db_prefix.'_posts p, ' . $db_prefix.'_users u, ' . $db_prefix . '_level_settings l
			WHERE p.poster_id = u.id
				AND l.group_id = u.can_do
				AND ' . $db->sql_in_set('p.post_id', $last_post_ids);
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$update_sql[$row["{$type}_id"]][] = $type . '_last_post_id = ' . (int) $row['post_id'];
			$update_sql[$row["{$type}_id"]][] = "{$type}_last_post_subject = '" . $db->sql_escape($row['post_subject']) . "'";
			$update_sql[$row["{$type}_id"]][] = $type . '_last_post_time = ' . (int) $row['post_time'];
			$update_sql[$row["{$type}_id"]][] = $type . '_last_poster_id = ' . (int) $row['poster_id'];
			$update_sql[$row["{$type}_id"]][] = "{$type}_last_poster_colour = '" . $db->sql_escape($row['user_colour']) . "'";
			$update_sql[$row["{$type}_id"]][] = "{$type}_last_poster_name = '" . (($row['poster_id'] == 0) ? $db->sql_escape($row['post_username']) : $db->sql_escape($row['username'])) . "'";
		}
		$db->sql_freeresult($result);
	}
	unset($empty_forums, $ids, $last_post_ids);

	if ($return_update_sql || !sizeof($update_sql))
	{
		return $update_sql;
	}

	$table = ($type == 'forum') ? $db_prefix . '_forums' : $db_prefix . '_topics';

	foreach ($update_sql as $update_id => $update_sql_ary)
	{
		$sql = "UPDATE $table
			SET " . implode(', ', $update_sql_ary) . "
			WHERE {$type}_id = $update_id";
		$db->sql_query($sql);
	}

	return;
}
/**
* Return supported image types
*/
if (!function_exists("get_supported_image_types"))
{
function get_supported_image_types($type = false)
{
	if (@extension_loaded('gd'))
	{
		$format = imagetypes();
		$new_type = 0;

		if ($type !== false)
		{
			// Type is one of the IMAGETYPE constants - it is fetched from getimagesize()
			switch ($type)
			{
				// GIF
				case IMAGETYPE_GIF:
					$new_type = ($format & IMG_GIF) ? IMG_GIF : false;
				break;

				// JPG, JPC, JP2
				case IMAGETYPE_JPEG:
				case IMAGETYPE_JPC:
				case IMAGETYPE_JPEG2000:
				case IMAGETYPE_JP2:
				case IMAGETYPE_JPX:
				case IMAGETYPE_JB2:
					$new_type = ($format & IMG_JPG) ? IMG_JPG : false;
				break;

				// PNG
				case IMAGETYPE_PNG:
					$new_type = ($format & IMG_PNG) ? IMG_PNG : false;
				break;

				// WBMP
				case IMAGETYPE_WBMP:
					$new_type = ($format & IMG_WBMP) ? IMG_WBMP : false;
				break;
			}
		}
		else
		{
			$new_type = array();
			$go_through_types = array(IMG_GIF, IMG_JPG, IMG_PNG, IMG_WBMP);

			foreach ($go_through_types as $check_type)
			{
				if ($format & $check_type)
				{
					$new_type[] = $check_type;
				}
			}
		}

		return array(
			'gd'		=> ($new_type) ? true : false,
			'format'	=> $new_type,
			'version'	=> (function_exists('imagecreatetruecolor')) ? 2 : 1
		);
	}

	return array('gd' => false);
}
}

/**
* Create Thumbnail
*/
function create_thumbnail($source, $destination, $mimetype)
{
	global $config, $phpbb_filesystem;

	$min_filesize = (int) $config['img_min_thumb_filesize'];
	$img_filesize = (file_exists($source)) ? @filesize($source) : false;

	if (!$img_filesize || $img_filesize <= $min_filesize)
	{
		return false;
	}

	$dimension = @getimagesize($source);

	if ($dimension === false)
	{
		return false;
	}

	list($width, $height, $type, ) = $dimension;

	if (empty($width) || empty($height))
	{
		return false;
	}

	list($new_width, $new_height) = get_img_size_formats($width, $height);

	// Do not create a thumbnail if the resulting width/height is bigger than the original one
	if ($new_width >= $width && $new_height >= $height)
	{
		return false;
	}

	$used_imagick = false;

	// Only use ImageMagick if defined and the passthru function not disabled
	if ($config['img_imagick'] && function_exists('passthru'))
	{
		if (substr($config['img_imagick'], -1) !== '/')
		{
			$config['img_imagick'] .= '/';
		}

		@passthru(escapeshellcmd($config['img_imagick']) . 'convert' . ((defined('PHP_OS') && preg_match('#^win#i', PHP_OS)) ? '.exe' : '') . ' -quality 85 -geometry ' . $new_width . 'x' . $new_height . ' "' . str_replace('\\', '/', $source) . '" "' . str_replace('\\', '/', $destination) . '"');

		if (file_exists($destination))
		{
			$used_imagick = true;
		}
	}

	if (!$used_imagick)
	{
		$type = get_supported_image_types($type);

		if ($type['gd'])
		{
			// If the type is not supported, we are not able to create a thumbnail
			if ($type['format'] === false)
			{
				return false;
			}

			switch ($type['format'])
			{
				case IMG_GIF:
					$image = @imagecreatefromgif($source);
				break;

				case IMG_JPG:
					@ini_set('gd.jpeg_ignore_warning', 1);
					$image = @imagecreatefromjpeg($source);
				break;

				case IMG_PNG:
					$image = @imagecreatefrompng($source);
				break;

				case IMG_WBMP:
					$image = @imagecreatefromwbmp($source);
				break;
			}

			if (empty($image))
			{
				return false;
			}

			if ($type['version'] == 1)
			{
				$new_image = imagecreate($new_width, $new_height);

				if ($new_image === false)
				{
					return false;
				}

				imagecopyresized($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
			}
			else
			{
				$new_image = imagecreatetruecolor($new_width, $new_height);

				if ($new_image === false)
				{
					return false;
				}

				// Preserve alpha transparency (png for example)
				@imagealphablending($new_image, false);
				@imagesavealpha($new_image, true);

				imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
			}

			// If we are in safe mode create the destination file prior to using the gd functions to circumvent a PHP bug
			if (@ini_get('safe_mode') || @strtolower(ini_get('safe_mode')) == 'on')
			{
				@touch($destination);
			}

			switch ($type['format'])
			{
				case IMG_GIF:
					imagegif($new_image, $destination);
				break;

				case IMG_JPG:
					imagejpeg($new_image, $destination, 90);
				break;

				case IMG_PNG:
					imagepng($new_image, $destination);
				break;

				case IMG_WBMP:
					imagewbmp($new_image, $destination);
				break;
			}

			imagedestroy($new_image);
		}
		else
		{
			return false;
		}
	}

	if (!file_exists($destination))
	{
		return false;
	}


	return true;
}
function get_img_size_formats($width, $height)
{
	global $config;

	// Maximum Width the Image can take
	$max_width = ($config['img_max_thumb_width']) ? $config['img_max_thumb_width'] : 400;

	if ($width > $height)
	{
		return array(
			round($width * ($max_width / $width)),
			round($height * ($max_width / $width))
		);
	}
	else
	{
		return array(
			round($width * ($max_width / $height)),
			round($height * ($max_width / $height))
		);
	}
}
?>