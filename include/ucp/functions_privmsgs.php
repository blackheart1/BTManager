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
** File functions_privmsgs.php 2018-02-18 14:32:00 joeroberts
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
require_once("include/constants.php");
$global_privmsgs_rules = array(
	CHECK_SUBJECT	=> array(
		RULE_IS_LIKE		=> array('check0' => 'message_subject', 'function' => 'preg_match("/" . preg_quote({STRING}, "/") . "/i", {CHECK0})'),
		RULE_IS_NOT_LIKE	=> array('check0' => 'message_subject', 'function' => '!(preg_match("/" . preg_quote({STRING}, "/") . "/i", {CHECK0}))'),
		RULE_IS				=> array('check0' => 'message_subject', 'function' => '{CHECK0} == {STRING}'),
		RULE_IS_NOT			=> array('check0' => 'message_subject', 'function' => '{CHECK0} != {STRING}'),
		RULE_BEGINS_WITH	=> array('check0' => 'message_subject', 'function' => 'preg_match("/^" . preg_quote({STRING}, "/") . "/i", {CHECK0})'),
		RULE_ENDS_WITH		=> array('check0' => 'message_subject', 'function' => 'preg_match("/" . preg_quote({STRING}, "/") . "$/i", {CHECK0})'),
	),

	CHECK_SENDER	=> array(
		RULE_IS_LIKE		=> array('check0' => 'username', 'function' => 'preg_match("/" . preg_quote({STRING}, "/") . "/i", {CHECK0})'),
		RULE_IS_NOT_LIKE	=> array('check0' => 'username', 'function' => '!(preg_match("/" . preg_quote({STRING}, "/") . "/i", {CHECK0}))'),
		RULE_IS				=> array('check0' => 'username', 'function' => '{CHECK0} == {STRING}'),
		RULE_IS_NOT			=> array('check0' => 'username', 'function' => '{CHECK0} != {STRING}'),
		RULE_BEGINS_WITH	=> array('check0' => 'username', 'function' => 'preg_match("/^" . preg_quote({STRING}, "/") . "/i", {CHECK0})'),
		RULE_ENDS_WITH		=> array('check0' => 'username', 'function' => 'preg_match("/" . preg_quote({STRING}, "/") . "$/i", {CHECK0})'),
		RULE_IS_FRIEND		=> array('check0' => 'friend', 'function' => '{CHECK0} == 1'),
		RULE_IS_FOE			=> array('check0' => 'foe', 'function' => '{CHECK0} == 1'),
		RULE_IS_USER		=> array('check0' => 'author_id', 'function' => '{CHECK0} == {USER_ID}'),
		RULE_IS_GROUP		=> array('check0' => 'author_in_group', 'function' => 'in_array({GROUP_ID}, {CHECK0})'),
	),

	CHECK_MESSAGE	=> array(
		RULE_IS_LIKE		=> array('check0' => 'message_text', 'function' => 'preg_match("/" . preg_quote({STRING}, "/") . "/i", {CHECK0})'),
		RULE_IS_NOT_LIKE	=> array('check0' => 'message_text', 'function' => '!(preg_match("/" . preg_quote({STRING}, "/") . "/i", {CHECK0}))'),
		RULE_IS				=> array('check0' => 'message_text', 'function' => '{CHECK0} == {STRING}'),
		RULE_IS_NOT			=> array('check0' => 'message_text', 'function' => '{CHECK0} != {STRING}'),
	),

	CHECK_STATUS	=> array(
		RULE_ANSWERED		=> array('check0' => 'pm_replied', 'function' => '{CHECK0} == 1'),
		RULE_FORWARDED		=> array('check0' => 'pm_forwarded', 'function' => '{CHECK0} == 1'),
	),

	CHECK_TO		=> array(
		RULE_TO_GROUP		=> array('check0' => 'to', 'check1' => 'bcc', 'check2' => 'user_in_group', 'function' => 'in_array("g_" . {CHECK2}, {CHECK0}) || in_array("g_" . {CHECK2}, {CHECK1})'),
		RULE_TO_ME			=> array('check0' => 'to', 'check1' => 'bcc', 'function' => 'in_array("u_" . $user_id, {CHECK0}) || in_array("u_" . $user_id, {CHECK1})'),
	)
);

/**
* This is for defining which condition fields to show for which Rule
*/
$global_rule_conditions = array(
	RULE_IS_LIKE		=> 'text',
	RULE_IS_NOT_LIKE	=> 'text',
	RULE_IS				=> 'text',
	RULE_IS_NOT			=> 'text',
	RULE_BEGINS_WITH	=> 'text',
	RULE_ENDS_WITH		=> 'text',
	RULE_IS_USER		=> 'user',
	RULE_IS_GROUP		=> 'group'
);
function move_pm($user_id, $message_limit, $move_msg_ids, $dest_folder, $cur_folder_id)
{
	global $db, $user,$db_prefix;
	global $sitename,$siteurl, $phpEx;
	//die($move_msg_ids);

	$num_moved = 0;

	if (!is_array($move_msg_ids))
	{
		$move_msg_ids = array($move_msg_ids);
	}

	if (sizeof($move_msg_ids) && !in_array($dest_folder, array(-3, -2, -1)) &&
		!in_array($cur_folder_id, array(-3, -2)) && $cur_folder_id != $dest_folder)
	{
		// We have to check the destination folder ;)
		if ($dest_folder != 0)
		{
			$sql = 'SELECT folder_id, folder_name, pm_count
				FROM ' . $db_prefix . "_privmsgs_folder
				WHERE folder_id = $dest_folder
					AND user_id = $user_id";
			$result = $db->sql_query($sql)or btsqlerror($sql);
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			if (!$row)
			{
				pmbt_trigger_error('NOT_AUTHORISED');
			}

			if ($message_limit && $row['pm_count'] + sizeof($move_msg_ids) > $message_limit)
			{
				$message = sprintf($user->lang['_NOT_ENOUGH_SPACE_FOLDER'], $row['folder_name']) . '<br /><br />';
				$message .= sprintf($user->lang['_CLICK_RETURN_FOLDER'], '<a href="' . append_sid("{$siteurl}/pm.$phpEx", 'i=pm&amp;folder=' . $row['folder_id']) . '">', '</a>', $row['folder_name']);
				pmbt_trigger_error($message);
			}
		}
		else
		{
			$sql = 'SELECT COUNT(msg_id) as num_messages
				FROM ' . $db_prefix . '_privmsgs_to
				WHERE folder_id = ' . 0 . "
					AND user_id = $user_id";
			$result = $db->sql_query($sql)or btsqlerror($sql);
			$num_messages = (int) $db->sql_fetchfield('num_messages');
			$db->sql_freeresult($result);

			if ($message_limit && $num_messages + sizeof($move_msg_ids) > $message_limit)
			{
				$message = sprintf($user->lang['_NOT_ENOUGH_SPACE_FOLDER'], $user->lang['_PM_INBOX']) . '<br /><br />';
				$message .= sprintf($user->lang['_CLICK_RETURN_FOLDER'], '<a href="' . append_sid("{$siteurl}/pm.$phpEx", 'i=pm&amp;folder=inbox') . '">', '</a>', $user->lang['_PM_INBOX']);
				pmbt_trigger_error($message);
			}
		}

		$sql = 'UPDATE ' . $db_prefix . "_privmsgs_to
			SET folder_id = $dest_folder
			WHERE folder_id = $cur_folder_id
				AND user_id = $user_id
				AND " . $db->sql_in_set('msg_id',$move_msg_ids);
		$db->sql_query($sql)or btsqlerror($sql);
		$num_moved = $db->sql_affectedrows();

		// Update pm counts
		if ($num_moved)
		{
			if (!in_array($cur_folder_id, array(0, -2, -1)))
			{
				$sql = 'UPDATE ' . $db_prefix . "_privmsgs_folder
					SET pm_count = pm_count - $num_moved
					WHERE folder_id = $cur_folder_id
						AND user_id = $user_id";
				$db->sql_query($sql)or btsqlerror($sql);
			}

			if ($dest_folder != 0)
			{
				$sql = 'UPDATE ' . $db_prefix . "_privmsgs_folder
					SET pm_count = pm_count + $num_moved
					WHERE folder_id = $dest_folder
						AND user_id = $user_id";
				$db->sql_query($sql)or btsqlerror($sql);
			}
		}
	}
	else if (in_array($cur_folder_id, array(-3, -2)))
	{
		pmbt_trigger_error('CANNOT_MOVE_SPECIAL');
	}

	return $num_moved;
}
function view_folder($id, $mode, $folder_id, $folder)
{
	global $user, $template, $auth, $db, $pmbt_cache,$db_prefix;
	global $sitename,$siteurl, $config, $phpEx, $torrent_per_page;

	$submit_export = (isset($_POST['submit_export'])) ? true : false;

	$folder_info = get_pm_from($folder_id, $folder, $user->id);
	//die(print_r($folder_info));

	if (!$submit_export)
	{
		// Grab icons
		$icons = $pmbt_cache->obtain_icons();
		$color_rows = array('marked', 'replied');

		$zebra_enabled = true;

		if ($zebra_enabled)
		{
			$color_rows = array_merge($color_rows, array('friend', 'foe'));
		}

		foreach ($color_rows as $var)
		{
			$template->assign_block_vars('pm_colour_info', array(
				'IMG'	=> $user->img("pm_{$var}", ''),
				'CLASS'	=> "pm_{$var}_colour",
				'LANG'	=> $user->lang['_' . strtoupper($var) . '_MESSAGE'])
			);
		}

		$mark_options = array('mark_important', 'delete_marked');

		// Minimise edits
		if (!checkaccess('u_pm_delete') && $key = array_search('delete_marked', $mark_options))
		{
			unset($mark_options[$key]);
		}

		$s_mark_options = '';
		foreach ($mark_options as $mark_option)
		{
			$s_mark_options .= '<option value="' . $mark_option . '">' . $user->lang['_'.strtoupper($mark_option)] . '</option>';
		}

		// We do the folder moving options here too, for template authors to use...
		$s_folder_move_options = '';
		if ($folder_id != -3 && $folder_id != -2)
		{
			foreach ($folder as $f_id => $folder_ary)
			{
				if ($f_id == -2 || $f_id == -1 || $f_id == $folder_id)
				{
					continue;
				}
				$s_folder_move_options .= '<option' . (($f_id != 0) ? ' class="sep"' : '') . ' value="' . $f_id . '">';
				$s_folder_move_options .= sprintf($user->lang['_MOVE_MARKED_TO_FOLDER'], $folder_ary['folder_name']);
				$s_folder_move_options .= (($folder_ary['unread_messages']) ? ' [' . $folder_ary['unread_messages'] . '] ' : '') . '</option>';
			}
		}
		$friend = $foe = array();

		// Get friends and foes
		$sql_frend = 'SELECT slave FROM `' . $db_prefix . '_private_messages_bookmarks` WHERE master = ' . $user->id;
		$sql_foe = 'SELECT slave FROM `' . $db_prefix . '_private_messages_blacklist` WHERE master = ' . $user->id;
		$result_frend = $db->sql_query($sql_frend);
		$result_foe = $db->sql_query($sql_foe);

		while ($rowa = $db->sql_fetchrow($result_frend))
		{
			$friend[$rowa['slave']] = $rowa['slave'];
		}
		$db->sql_freeresult($result_frend);
		while ($rowb = $db->sql_fetchrow($result_foe))
		{
			$foe[$rowb['slave']] = $rowb['slave'];
		}
		$db->sql_freeresult($result_foe);

		$template->assign_vars(array(
			'S_MARK_OPTIONS'		=> $s_mark_options,
			'S_MOVE_MARKED_OPTIONS'	=> $s_folder_move_options)
		);

		// Okay, lets dump out the page ...
		if (sizeof($folder_info['pm_list']))
		{
			$address_list = array();

			// Build Recipient List if in outbox/sentbox - max two additional queries
			if ($folder_id == -2 || $folder_id == -1)
			{
				$address_list = get_recipient_strings($folder_info['rowset']);
			}
			//die(print_r($address_list));

			foreach ($folder_info['pm_list'] as $message_id)
			{
				$row = &$folder_info['rowset'][$message_id];

				$folder_img = ($row['pm_unread']) ? 'pm_unread' : 'pm_read';
				$folder_alt = ($row['pm_unread']) ? 'NEW_MESSAGES' : 'NO_NEW_MESSAGES';

				// Generate all URIs ...
				$view_message_url = append_sid("pm.$phpEx", "i=$id&amp;op=readmsg&amp;f=$folder_id&amp;p=$message_id");
				$remove_message_url = append_sid("{$siteurl}/pm.$phpEx", "op=send&amp;i=$id&amp;mode=compose&amp;action=delete&amp;p=$message_id");

				$row_indicator = '';
				foreach ($color_rows as $var)
				{
					if (($var != 'friend' && $var != 'foe' && $row['pm_' . $var])
						||
						(($var == 'friend' || $var == 'foe') && isset(${$var}[$row['author_id']]) && ${$var}[$row['author_id']]))
					{
						$row_indicator = $var;
						break;
					}
				}

				// Send vars to template
				$template->assign_block_vars('messagerow', array(
					'PM_CLASS'			=> ($row_indicator) ? 'pm_' . $row_indicator . '_colour' : '',

					'MESSAGE_AUTHOR_FULL'		=> get_username_string('full', $row['author_id'], $row['username'], str_replace('#','',getusercolor($row['can_do'])), $row['username']),
					'MESSAGE_AUTHOR_COLOUR'		=> get_username_string('colour', $row['author_id'], $row['username'], str_replace('#','',getusercolor($row['can_do'])), $row['username']),
					'MESSAGE_AUTHOR'			=> get_username_string('username', $row['author_id'], $row['username'], str_replace('#','',getusercolor($row['can_do'])), $row['username']),
					'U_MESSAGE_AUTHOR'			=> get_username_string('profile', $row['author_id'], $row['username'], str_replace('#','',getusercolor($row['can_do'])), $row['username']),

					'FOLDER_ID'			=> $folder_id,
					'MESSAGE_ID'		=> $message_id,
					'SENT_TIME'			=> $row['sent'],
					'SUBJECT'			=> $row['subject'],
					'FOLDER'			=> (isset($folder[$row['folder_id']])) ? $folder[$row['folder_id']]['folder_name'] : '',
					'U_FOLDER'			=> (isset($folder[$row['folder_id']])) ? append_sid("{$siteurl}/pm.$phpEx", 'folder=' . $row['folder_id']) : '',
					'PM_ICON_IMG'		=> (!empty($icons[$row['icon_id']])) ? '<img src="./images/icons/' . $icons[$row['icon_id']]['img'] . '" width="' . $icons[$row['icon_id']]['width'] . '" height="' . $icons[$row['icon_id']]['height'] . '" alt="" title="" />' : '',
					'PM_ICON_URL'		=> (!empty($icons[$row['icon_id']])) ? $siteurl . '/images/icons/' . $icons[$row['icon_id']]['img'] : '',
					'FOLDER_IMG'		=> $user->img($folder_img, $folder_alt),
					'FOLDER_IMG_SRC'	=> $user->img($folder_img, $folder_alt, false, '', 'src'),
					'PM_IMG'			=> ($row_indicator) ? $user->img('pm_' . $row_indicator, '') : '',
					'ATTACH_ICON_IMG'	=> ($row['message_attachment'] && $config['allow_pm_attach']) ? $user->img('icon_topic_attach', $user->lang['_TOTAL_ATTACHMENTS']) : '',

					'S_PM_DELETED'		=> ($row['pm_deleted']) ? true : false,
					'S_PM_REPORTED'		=> (isset($row['report_id'])) ? true : false,
					'S_AUTHOR_DELETED'	=> ($row['author_id'] == 0) ? true : false,

					'U_VIEW_PM'			=> ($row['pm_deleted']) ? '' : $view_message_url,
					'U_REMOVE_PM'		=> ($row['pm_deleted']) ? $remove_message_url : '',
					'U_MCP_REPORT'		=> (isset($row['report_id'])) ? append_sid("{$phpbb_root_path}forum.$phpEx?action_mcp=mcp", 'i=pm_reports&amp;mode=pm_report_details&amp;r=' . $row['report_id']) : '',
					'RECIPIENTS'		=> ($folder_id == -2 || $folder_id == -1) ? implode(', ', $address_list[$message_id]) : '')
				);
			}
//print_r($row);			unset($folder_info['rowset']);

			$template->assign_vars(array(
				'S_SHOW_RECIPIENTS'		=> ($folder_id == -2 || $folder_id == -1) ? true : false,
				'S_SHOW_COLOUR_LEGEND'	=> true,

				'REPORTED_IMG'			=> $user->img('icon_topic_reported', 'PM_REPORTED'),
				'S_PM_ICONS'			=> ($config['enable_pm_icons']) ? true : false)
			);
		}
	}
	else
	{
		$export_type = request_var('export_option', '');
		$enclosure = request_var('enclosure', '');
		$delimiter = request_var('delimiter', '');

		if ($export_type == 'CSV' && ($delimiter === '' || $enclosure === ''))
		{
			$template->assign_var('PROMPT', true);
		}
		else
		{
			// Build Recipient List if in outbox/sentbox

			$address_temp = $address = $data = array();

			if ($folder_id == -2 || $folder_id == -1)
			{
				foreach ($folder_info['rowset'] as $message_id => $row)
				{
					$address_temp[$message_id] = rebuild_header(array('to' => (($row['recipient'])?'u_'.$row['recipient']:''), 'bcc' => (($row['bcc_address'])?'g_'.$row['bcc_address']:'')));
					$address[$message_id] = array();
				}
			}

			foreach ($folder_info['pm_list'] as $message_id)
			{
				$row = &$folder_info['rowset'][$message_id];

				include_once('include/function_posting.' . $phpEx);

				$sql = 'SELECT p.text, p.sent, p.bbcode_uid
					FROM ' . $db_prefix . '_privmsgs_to t, ' . $db_prefix . '_private_messages p, ' . $db_prefix . '_users  u
					WHERE t.user_id = ' . $user->id . "
						AND p.sender = u.id
						AND t.folder_id = $folder_id
						AND t.msg_id = p.id
						AND p.id = $message_id LIMIT 1";
				$result = $db->sql_query($sql)or btsqlerror($sql);
				$message_row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				$_types = array('u', 'g');
				foreach ($_types as $ug_type)
				{
					if (isset($address_temp[$message_id][$ug_type]) && sizeof($address_temp[$message_id][$ug_type]))
					{
						if (!isset($address[$message_id][$ug_type]))
						{
							$address[$message_id][$ug_type] = array();
						}
						if ($ug_type == 'u')
						{
							$sql = 'SELECT id as id, username as name
								FROM ' . $db_prefix . '_users 
								WHERE ';
						}
						else
						{
							$sql = 'SELECT group_id as id, group_name as name
								FROM ' . GROUPS_TABLE . '
								WHERE ';
						}
						$sql .= $db->sql_in_set(($ug_type == 'u') ? 'id' : 'group_id', array_map('intval', array_keys($address_temp[$message_id][$ug_type])));

						$result = $db->sql_query($sql)or btsqlerror($sql);

						while ($info_row = $db->sql_fetchrow($result))
						{
							$address[$message_id][$ug_type][$address_temp[$message_id][$ug_type][$info_row['id']]][] = $info_row['name'];
							unset($address_temp[$message_id][$ug_type][$info_row['id']]);
						}
						$db->sql_freeresult($result);
					}
				}

				// There is the chance that all recipients of the message got deleted. To avoid creating 
				// exports without recipients, we add a bogus "undisclosed recipient".
				if (!(isset($address[$message_id]['g']) && sizeof($address[$message_id]['g'])) && 
				    !(isset($address[$message_id]['u']) && sizeof($address[$message_id]['u'])))
				{
					$address[$message_id]['u'] = array();
					$address[$message_id]['u']['to'] = array();
					$address[$message_id]['u']['to'][] = $user->lang['_UNDISCLOSED_RECIPIENT'];
				}

				decode_message($message_row['text'], $message_row['bbcode_uid']);
				
				$data[] = array(
					'subject'	=> censor_text($row['subject']),
					'sender'	=> $row['username'],
					'date'		=> $user->format_date(sql_timestamp_to_unix_timestamp($row['sent'])),
					'to'		=> ($folder_id == -2 || $folder_id == -1) ? $address[$message_id] : '',
					'message'	=> $message_row['text']
				);
			}

			switch ($export_type)
			{
				case 'CSV':
				case 'CSV_EXCEL':
					$mimetype = 'text/csv';
					$filetype = 'csv';

					if ($export_type == 'CSV_EXCEL')
					{
						$enclosure = '"';
						$delimiter = ',';
						$newline = "\r\n";
					}
					else
					{
						$newline = "\n";
					}

					$string = '';
					foreach ($data as $value)
					{
						$recipients = $value['to'];
						$value['to'] = $value['bcc'] = '';

						if (is_array($recipients))
						{
							foreach ($recipients as $values)
							{
								$value['bcc'] .= (isset($values['bcc']) && is_array($values['bcc'])) ? ',' . implode(',', $values['bcc']) : '';
								$value['to'] .= (isset($values['to']) && is_array($values['to'])) ? ',' . implode(',', $values['to']) : '';
							}

							// Remove the commas which will appear before the first entry.
							$value['to'] = substr($value['to'], 1);
							$value['bcc'] = substr($value['bcc'], 1);
						}

						foreach ($value as $tag => $text)
						{
							$cell = str_replace($enclosure, $enclosure . $enclosure, $text);

							if (strpos($cell, $enclosure) !== false || strpos($cell, $delimiter) !== false || strpos($cell, $newline) !== false)
							{
								$string .= $enclosure . $text . $enclosure . $delimiter;
							}
							else
							{
								$string .= $cell . $delimiter;
							}
						}
						$string = substr($string, 0, -1) . $newline;
					}
				break;

				case 'XML':
					$mimetype = 'application/xml';
					$filetype = 'xml';
					$string = '<?xml version="1.0"?>' . "\n";
					$string .= "<pmbt>\n";

					foreach ($data as $value)
					{
						$string .= "\t<privmsg>\n";

						if (is_array($value['to']))
						{
							foreach ($value['to'] as $key => $values)
							{
								foreach ($values as $type => $types)
								{
									foreach ($types as $name)
									{
										$string .= "\t\t<recipient type=\"$type\" status=\"$key\">$name</recipient>\n";
									}
								}
							}
						}

						unset($value['to']);

						foreach ($value as $tag => $text)
						{
							$string .= "\t\t<$tag>$text</$tag>\n";
						}

						$string .= "\t</privmsg>\n";
					}
					$string .= '</pmbt>';
				break;
			}

			header('Pragma: no-cache');
			header("Content-Type: $mimetype; name=\"data.$filetype\"");
			header("Content-disposition: attachment; filename=data.$filetype");
			echo $string;
			exit;
		}
	}
}

/**
* Get Messages from folder/user
*/
function get_pm_from($folder_id, $folder, $user_id)
{
	global $user, $db,$db_prefix, $template, $config, $auth,$sitename,$siteurl, $phpEx, $torrent_per_page;
	//die(print_r($folder[$folder_id]));

	$start = request_var('page', 0);
	if($start > 0)$start = ($start - 1) * $torrent_per_page;

	// Additional vars later, pm ordering is mostly different from post ordering. :/
	$sort_days	= request_var('st', 0);
	$sort_key	= request_var('sk', 't');
	$sort_dir	= request_var('sd', 'd');

	// PM ordering options
	$limit_days = array(0 => $user->lang['ALL_MESSAGES'], 1 => $user->lang['1_DAY'], 7 => $user->lang['7_DAYS'], 14 => $user->lang['2_WEEKS'], 30 => $user->lang['1_MONTH'], 90 => $user->lang['3_MONTHS'], 180 => $user->lang['6_MONTHS'], 365 => $user->lang['1_YEAR']);

	// No sort by Author for sentbox/outbox (already only author available)
	// Also, sort by msg_id for the time - private messages are not as prone to errors as posts are.
	if ($folder_id == -2 || $folder_id == -1)
	{
		$sort_by_text = array('t' => $user->lang['_POST_TIME'], 's' => $user->lang['_SUBJECT']);
		$sort_by_sql = array('t' => 'p.sent', 's' => array('p.subject', 'p.sent'));
	}
	else
	{
		$sort_by_text = array('a' => $user->lang['_AUTHOR'], 't' => $user->lang['_POST_TIME'], 's' => $user->lang['_SUBJECT']);
		$sort_by_sql = array('a' => array('u.clean_username', 'p.sent'), 't' => 'p.sent', 's' => array('p.subject', 'p.sent'));
	}

	$s_limit_days = $s_sort_key = $s_sort_dir = $u_sort_param = '';
	gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sort_dir, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);

	$folder_sql = 't.folder_id = ' . (int) $folder_id;
	

	// Limit pms to certain time frame, obtain correct pm count
	if ($sort_days)
	{
		$min_post_time = time() - ($sort_days * 86400);

		if (isset($_POST['sort']))
		{
			$start = 0;
		}

		$sql = 'SELECT COUNT(t.msg_id) AS pm_count
			FROM ' . $db_prefix . '_privmsgs_to t, ' . $db_prefix . "_private_messages p
			WHERE $folder_sql
				AND t.user_id = $user_id
				AND t.msg_id = p.id  LIMIT 1";
		$result = $db->sql_query($sql)or btsqlerror($sql);
		$pm_count = (int) $db->sql_fetchfield('pm_count');
		$db->sql_freeresult($result);

		$sql_limit_time = "AND UNIX_TIMESTAMP(p.sent) >= $min_post_time";
	}
	else
	{
		$pm_count = (!empty($folder[$folder_id]['num_messages'])) ? $folder[$folder_id]['num_messages'] : 0;
		$sql_limit_time = '';
	}
//die($s_sort_dir);
	$template->assign_vars(array(
		'PAGINATION'		=> generate_pagination(append_sid("{$siteurl}/pm.$phpEx", "i=pm&amp;mode=view&amp;action=view_folder&amp;f=$folder_id&amp;$u_sort_param"), $pm_count, $torrent_per_page, $start),
		'PAGE_NUMBER'		=> on_page($pm_count, $torrent_per_page, $start),
		'TOTAL_MESSAGES'	=> (($pm_count == 1) ? $user->lang['_VIEW_PM_MESSAGE'] : sprintf($user->lang['_VIEW_PM_MESSAGES'], $pm_count)),

		'POST_IMG'		=> "pic",//$user->img('button_pm_new', 'POST_NEW_PM'),

		'S_NO_AUTH_SEND_MESSAGE'	=> false,

		'S_SELECT_SORT_DIR'		=> $s_sort_dir,
		'S_SELECT_SORT_KEY'		=> $s_sort_key,
		'S_SELECT_SORT_DAYS'	=> $s_limit_days,
		'S_TOPIC_ICONS'			=> ($config['enable_pm_icons']) ? true : false,

		'U_POST_NEW_TOPIC'	=> append_sid("{$siteurl}/pm.$phpEx", 'op=send&amp;i=pm&amp;mode=compose'),
		'S_PM_ACTION'		=> append_sid("{$siteurl}/pm.$phpEx", "op=folder&amp;i=pm&amp;mode=view&amp;action=view_folder&amp;f=$folder_id" . (($start !== 0) ? "&amp;start=$start" : '')),
	));

	// Grab all pm data
	$rowset = $pm_list = array();

	// If the user is trying to reach late pages, start searching from the end
	$store_reverse = false;
	$sql_limit = $torrent_per_page;
	if ($start > $pm_count / 2)
	{
		$store_reverse = true;

		if ($start + $torrent_per_page > $pm_count)
		{
			$sql_limit = min($torrent_per_page, max(1, $pm_count - $start));
		}

		// Select the sort order
		$direction = ($sort_dir == 'd') ? 'ASC' : 'DESC';
		$sql_start = max(0, $pm_count - $sql_limit - $start);
	}
	else
	{
		// Select the sort order
		$direction = ($sort_dir == 'd') ? 'DESC' : 'ASC';
		$sql_start = $start;
	}

	// Sql sort order
	if (is_array($sort_by_sql[$sort_key]))
	{
		$sql_sort_order = implode(' ' . $direction . ', ', $sort_by_sql[$sort_key]) . ' ' . $direction;
	}
	else
	{
		$sql_sort_order = $sort_by_sql[$sort_key] . ' ' . $direction;
	}

	$sql = 'SELECT t.*,
	 p.root_level, p.bcc_address, p.sent, p.subject, p.recipient, p.icon_id, p.message_attachment,
	 u.username, u.clean_username, u.can_do
		FROM ' . $db_prefix . '_privmsgs_to t, ' . $db_prefix . '_private_messages p, ' . $db_prefix . "_users u
		WHERE t.user_id = $user_id
			AND p.sender = u.id
			AND $folder_sql
			AND t.msg_id = p.id
		ORDER BY $sql_sort_order LIMIT  $sql_start,$sql_limit";
	$result = $db->sql_query($sql)or btsqlerror($sql);
	$pm_reported = array();
	while ($row = $db->sql_fetchrow($result))
	{
	//die( print_r($row));
		$rowset[$row['msg_id']] = $row;
		$pm_list[] = $row['msg_id'];
		if (isset($row['message_reported']))
		{
			$pm_reported[] = $row['msg_id'];
		}
	}
	$db->sql_freeresult($result);

	// Fetch the report_ids, if there are any reported pms.
	if (!empty($pm_reported))
	{
		$sql = 'SELECT pm_id, report_id
			FROM ' . $db_prefix . '_reports
			WHERE report_closed = 0
				AND ' . $db->sql_in_set('pm_id', $pm_reported);
		$result = $db->sql_query($sql)or btsqlerror($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$rowset[$row['pm_id']]['report_id'] = $row['report_id'];
		}
		$db->sql_freeresult($result);
	}

	$pm_list = ($store_reverse) ? array_reverse($pm_list) : $pm_list;

	return array(
		'pm_count'	=> $pm_count,
		'pm_list'	=> $pm_list,
		'rowset'	=> $rowset
	);
}
if (!function_exists("gen_sort_selects")){ 
function gen_sort_selects(&$limit_days, &$sort_by_text, &$sort_days, &$sort_key, &$sort_dir, &$s_limit_days, &$s_sort_key, &$s_sort_dir, &$u_sort_param, $def_st = false, $def_sk = false, $def_sd = false)
{
	global $user,$db_prefix;

	$sort_dir_text = array('a' => $user->lang['_ASCENDING'], 'd' => $user->lang['_DESCENDING']);

	$sorts = array(
		'st'	=> array(
			'key'		=> 'sort_days',
			'default'	=> $def_st,
			'options'	=> $limit_days,
			'output'	=> &$s_limit_days,
		),

		'sk'	=> array(
			'key'		=> 'sort_key',
			'default'	=> $def_sk,
			'options'	=> $sort_by_text,
			'output'	=> &$s_sort_key,
		),

		'sd'	=> array(
			'key'		=> 'sort_dir',
			'default'	=> $def_sd,
			'options'	=> $sort_dir_text,
			'output'	=> &$s_sort_dir,
		),
	);
	$u_sort_param  = '';

	foreach ($sorts as $name => $sort_ary)
	{
		$key = $sort_ary['key'];
		$selected = ${$sort_ary['key']};

		// Check if the key is selectable. If not, we reset to the default or first key found.
		// This ensures the values are always valid. We also set $sort_dir/sort_key/etc. to the
		// correct value, else the protection is void. ;)
		if (!isset($sort_ary['options'][$selected]))
		{
			if ($sort_ary['default'] !== false)
			{
				$selected = $$key = $sort_ary['default'];
			}
			else
			{
				@reset($sort_ary['options']);
				$selected = $$key = key($sort_ary['options']);
			}
		}

		$sort_ary['output'] = '<select name="' . $name . '" id="' . $name . '">';
		foreach ($sort_ary['options'] as $option => $text)
		{
			$sort_ary['output'] .= '<option value="' . $option . '"' . (($selected == $option) ? ' selected="selected"' : '') . '>' . $text . '</option>';
		}
		$sort_ary['output'] .= '</select>';

		$u_sort_param .= ($selected !== $sort_ary['default']) ? ((strlen($u_sort_param)) ? '&amp;' : '') . "{$name}={$selected}" : '';
	}

	return;
}
}
function get_recipient_strings($pm_by_id)
{
	global $db,$sitename,$siteurl, $phpEx, $user, $db_prefix;

	$address_list = $recipient_list = $address = array();

	$_types = array('u', 'g');
//die(print_r($pm_by_id));
	foreach ($pm_by_id as $message_id => $row)
	{
		$address[$message_id] = rebuild_header(array('to' => (($row['recipient'])?'u_'.$row['recipient']:''), 'bcc' => (($row['bcc_address'])?'g_'.$row['bcc_address']:'')));

		foreach ($_types as $ug_type)
		{
			if (isset($address[$message_id][$ug_type]) && sizeof($address[$message_id][$ug_type]))
			{
				foreach ($address[$message_id][$ug_type] as $ug_id => $in_to)
				{
					$recipient_list[$ug_type][$ug_id] = array('name' => $user->lang['_NA'], 'colour' => '');
				}
			}
		}
	}
	foreach ($_types as $ug_type)
	{
		if (!empty($recipient_list[$ug_type]))
		{
			if ($ug_type == 'u')
			{
				$sql = 'SELECT t.id as id, t.username as name, t.can_do as can_do, l.group_colour as colour
					FROM ' . $db_prefix . '_users  t, ' . $db_prefix . '_level_settings l
					WHERE 
					l.group_id = t.can_do AND ';
			}
			else
			{
				$sql = 'SELECT group_id as id, group_name as name, group_colour as colour, group_type
					FROM ' . $db_prefix . '_level_settings
					WHERE ';
			}
			$sql .= $db->sql_in_set(($ug_type == 'u') ? 'id' : 'group_id', array_map('intval', array_keys($recipient_list[$ug_type])));

			$result = $db->sql_query($sql)or btsqlerror($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				if ($ug_type == 'g')
				{
					$row['name'] = ($row['group_type'] == 3) ? $user->lang['G_' . $row['name']] : $row['name'];
				}

				$recipient_list[$ug_type][$row['id']] = array('name' => $row['name'], 'colour' => str_replace('#','',$row['colour']));
			}
			$db->sql_freeresult($result);
		}
	}

	foreach ($address as $message_id => $adr_ary)
	{
		foreach ($adr_ary as $type => $id_ary)
		{
			foreach ($id_ary as $ug_id => $_id)
			{
				if ($type == 'u')
				{
					$address_list[$message_id][] = $recipient_list[$type][$ug_id]['name'];
				}
				else
				{
					$user_colour = ($recipient_list[$type][$ug_id]['colour']) ? ' style="font-weight: bold; color:#' . $recipient_list[$type][$ug_id]['colour'] . '"' : '';
					$link = '<a href="' . append_sid("{$phpbb_root_path}memberslist.$phpEx", 'mode=group&amp;g=' . $ug_id) . '"' . $user_colour . '>';
					$address_list[$message_id][] = $link . $recipient_list[$type][$ug_id]['name'] . (($link) ? '</a>' : '');
				}
			}
		}
	}

	return $address_list;
}
function rebuild_header($check_ary)
{
	global $db,$db_prefix;

	$address = array();

	foreach ($check_ary as $check_type => $address_field)
	{
		// Split Addresses into users and groups
		preg_match_all('/:?(u|g)_([0-9]+):?/', $address_field, $match);

		$u = $g = array();
		foreach ($match[1] as $id => $type)
		{
			${$type}[] = (int) $match[2][$id];
		}

		$_types = array('u', 'g');
		foreach ($_types as $type)
		{
			if (sizeof($$type))
			{
				foreach ($$type as $id)
				{
					$address[$type][$id] = $check_type;
				}
			}
		}
	}

	return $address;
}
function clean_sentbox($num_sentbox_messages)
{
	global $db, $user, $config,$db_prefix;
//return;
	// Check Message Limit
	if ($user->data['message_limit'] && $num_sentbox_messages > $user->data['message_limit'])
	{
		// Delete old messages
		$sql = 'SELECT t.msg_id
			FROM ' . $db_prefix . '_privmsgs_to t, ' . $db_prefix . '_private_messages p
			WHERE t.msg_id = p.id
				AND t.user_id = ' . $user->id . '
				AND t.folder_id = ' . -1 . '
			ORDER BY p.sent ASC';
		$result = $db->sql_query($sql . ' LIMIT  ' . ($num_sentbox_messages - $user->data['message_limit']));

		$delete_ids = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$delete_ids[] = $row['msg_id'];
		}
		$db->sql_freeresult($result);
		delete_pm($user->id, $delete_ids, -1);
	}
}
function submit_pm($mode, $subject, &$data, $put_in_outbox = true)
{
	global $db, $db_prefix, $config, $phpEx, $template, $user, $sitename,$siteurl;
	// We do not handle erasing pms here
	if ($mode == 'delete')
	{
		return false;
	}

	$current_time = time();

	// Collect some basic information about which tables and which rows to update/insert
	$sql_data = array();
	$root_level = 0;

	// Recipient Information
	$recipients = $to = $bcc = array();

	if ($mode != 'edit')
	{
		// Build Recipient List
		// u|g => array($user_id => 'to'|'bcc')
		$_types = array('u', 'g');
		foreach ($_types as $ug_type)
		{
			if (isset($data['address_list'][$ug_type]) && sizeof($data['address_list'][$ug_type]))
			{
				foreach ($data['address_list'][$ug_type] as $id => $field)
				{
					$id = (is_numeric($id))? (int) $id : $id;

					// Do not rely on the address list being "valid"
					if (!$id || ($ug_type == 'u' && $id == 0))
					{
						continue;
					}

					$field = ($field == 'to') ? 'to' : 'bcc';
					if ($ug_type == 'u')
					{
						$recipients[$id] = $field;
					}
					${$field}[] = $ug_type . '_' . $id;
				}
			}
		}

		if (isset($data['address_list']['g']) && sizeof($data['address_list']['g']))
		{
			// We need to check the PM status of group members (do they want to receive PM's?)
			// Only check if not a moderator or admin, since they are allowed to override this user setting
			$sql_allow_pm = (!checkaccess('a_override_user_pm_block')) ? ' AND u.user_allow_pm = 1' : '';

			$sql = 'SELECT u.can_do, ug.group_id, u.id
				FROM ' . $db_prefix . '_users u, ' . $db_prefix . '_level_settings ug
				WHERE ' . $db->sql_in_set('u.can_do', array_keys($data['address_list']['g'])) . '
					AND u.active = 1' .
					$sql_allow_pm;
			$result = $db->sql_query($sql)or btsqlerror($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				// Additionally, do not include the sender if he is in the group he wants to send to. ;)
				if ($row['id'] === $user->id)
				{
					continue;
				}

				$field = ($data['address_list']['g'][$row['group_id']] == 'to') ? 'to' : 'bcc';
				$recipients[$row['id']] = $field;
			}
			$db->sql_freeresult($result);
		}
		if (!sizeof($recipients))
		{
			die('NO_RECIPIENT');
		}
	}

	// First of all make sure the subject are having the correct length.
	$subject = $subject;

	$sql = '';

	switch ($mode)
	{
		case 'reply':
		case 'quote':
			$root_level = ($data['reply_from_root_level']) ? $data['reply_from_root_level'] : $data['reply_from_msg_id'];

			// Set message_replied switch for this user
			$sql = 'UPDATE ' . $db_prefix . '_privmsgs_to
				SET pm_replied = 1
				WHERE user_id = ' . $data['from_user_id'] . '
					AND msg_id = ' . $data['reply_from_msg_id'];

		// no break

		case 'forward':
		case 'post':
		case 'quotepost':
			$sql_data = array(
				'root_level'		=> $root_level,
				'sender'			=> $data['from_user_id'],
				'icon_id'			=> $data['icon_id'],
				'author_ip'			=> $data['from_user_ip'],
				'sent'				=> get_date_time(),
				'enable_bbcode'		=> $data['enable_bbcode'],
				'enable_smilies'	=> $data['enable_smilies'],
				'enable_magic_url'	=> $data['enable_urls'],
				'enable_sig'		=> $data['enable_sig'],
				'subject'	=> $subject,
				'text'		=> $data['message'],
				'message_attachment'=> (!empty($data['attachment_data'])) ? 1 : 0,
				'bbcode_bitfield'	=> $data['bbcode_bitfield'],
				'bbcode_uid'		=> $data['bbcode_uid'],
				'recipient'		=> implode(':', $to),
				'bcc_address'		=> implode(':', $bcc),
				'message_reported'	=> 0,
			);
		break;

		case 'edit':
			$sql_data = array(
				'icon_id'			=> $data['icon_id'],
				'enable_bbcode'		=> $data['enable_bbcode'],
				'enable_smilies'	=> $data['enable_smilies'],
				'enable_magic_url'	=> $data['enable_urls'],
				'enable_sig'		=> $data['enable_sig'],
				'subject'	=> $subject,
				'text'		=> $data['message'],
				'message_attachment'=> (!empty($data['attachment_data'])) ? 1 : 0,
				'bbcode_bitfield'	=> $data['bbcode_bitfield'],
				'bbcode_uid'		=> $data['bbcode_uid']
			);
		break;
	}


	if (sizeof($sql_data))
	{
		$query = '';
		if ($mode == 'post' || $mode == 'reply' || $mode == 'quote' || $mode == 'quotepost' || $mode == 'forward')
		{
			$sql_pm = 'INSERT INTO ' . $db_prefix . '_private_messages ' . $db->sql_build_array('INSERT', $sql_data);
			//echo $sql_pm;
			$db->sql_query($sql_pm)or btsqlerror($db->sql_build_array('INSERT', $sql_data));
			$data['msg_id'] = $db->sql_nextid();
		}
		else if ($mode == 'edit')
		{
			$sql = 'UPDATE ' . $db_prefix . '_private_messages
				SET ' . $db->sql_build_array('UPDATE', $sql_data) . '
				WHERE id = ' . $data['msg_id'];
			$db->sql_query($sql);
		}
	}

	if ($mode != 'edit')
	{
		if ($sql)
		{
			$db->sql_query($sql);
		}
		unset($sql);

		$sql_ary = array();
		foreach ($recipients as $user_id => $type)
		{
			$sql_ary[] = array(
				'msg_id'		=> (int) $data['msg_id'],
				'user_id'		=> (int) $user_id,
				'author_id'		=> (int) $data['from_user_id'],
				'folder_id'		=> '-3',
				'pm_new'		=> 1,
				'pm_unread'		=> 1,
				'pm_forwarded'	=> ($mode == 'forward') ? 1 : 0
			);
		}
		foreach($sql_ary as $val)
		{
		$sql_pm = 'INSERT INTO ' . $db_prefix . '_privmsgs_to ' . $db->sql_build_array('INSERT',$val);
		//echo $sql_pm;
		$db->sql_query($sql_pm);
		}

		$sql = 'UPDATE ' . $db_prefix . '_users
			SET user_new_privmsg = user_new_privmsg + 1, user_unread_privmsg = user_unread_privmsg + 1, user_last_privmsg = ' . time() . '
			WHERE ' . $db->sql_in_set('id', array_keys($recipients));
		$db->sql_query($sql);

		// Put PM into outbox
		if ($put_in_outbox)
		{
			$db->sql_query('INSERT INTO ' . $db_prefix . '_privmsgs_to ' . $db->sql_build_array('INSERT', array(
				'msg_id'		=> (int) $data['msg_id'],
				'user_id'		=> (int) $data['from_user_id'],
				'author_id'		=> (int) $data['from_user_id'],
				'folder_id'		=> '-2',
				'pm_new'		=> 0,
				'pm_unread'		=> 0,
				'pm_forwarded'	=> ($mode == 'forward') ? 1 : 0))
			);
		}
	}

	// Set user last post time
	if ($mode == 'reply' || $mode == 'quote' || $mode == 'quotepost' || $mode == 'forward' || $mode == 'post')
	{
		$sql = 'UPDATE ' . $db_prefix . "_users
			SET user_lastpost_time = $current_time
			WHERE id = " . $data['from_user_id'];
		$db->sql_query($sql);
	}

	// Submit Attachments
	if (!empty($data['attachment_data']) && $data['msg_id'] && in_array($mode, array('post', 'reply', 'quote', 'quotepost', 'edit', 'forward')))
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
					AND in_message = 1
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
				continue;
			}

			if (!$attach_row['is_orphan'])
			{
				// update entry in db if attachment already stored in db and filespace
				$sql = 'UPDATE ' . $db_prefix . "_attachments
					SET attach_comment = '" . $db->sql_escape($attach_row['attach_comment']) . "'
					WHERE attach_id = " . (int) $attach_row['attach_id'] . '
						AND is_orphan = 0';
				$db->sql_query($sql);
			}
			else
			{
				// insert attachment into db
				if (!@file_exists('./' . $config['upload_path'] . '/' . $orphan_rows[$attach_row['attach_id']]['physical_filename']))
				{
					continue;
				}

				$space_taken += $orphan_rows[$attach_row['attach_id']]['filesize'];
				$files_added++;

				$attach_sql = array(
					'post_msg_id'		=> $data['msg_id'],
					'topic_id'			=> 0,
					'is_orphan'			=> 0,
					'poster_id'			=> $data['from_user_id'],
					'attach_comment'	=> $attach_row['attach_comment'],
				);

				$sql = 'UPDATE ' . $db_prefix . '_attachments SET ' . $db->sql_build_array('UPDATE', $attach_sql) . '
					WHERE attach_id = ' . $attach_row['attach_id'] . '
						AND is_orphan = 1
						AND poster_id = ' . $user->id;
				$db->sql_query($sql);
			}
		}

		if ($space_taken && $files_added)
		{
			//set_att_config_count('upload_dir_size', $space_taken, true);
			//set_att_config_count('num_files', $files_added, true);
		}
	}
	// Delete draft if post was loaded...
	$draft_id = request_var('draft_loaded', 0);
	if ($draft_id)
	{
		$sql = 'DELETE FROM ' . $db_prefix . "_drafts
			WHERE draft_id = $draft_id
				AND user_id = " . $data['from_user_id'];
		$db->sql_query($sql);
	}


	// Send Notifications
	if ($mode != 'edit')
	{
		pm_notification($mode, $data['from_username'], $recipients, $subject, $data['message'], $data['msg_id']);
	}

	return $data['msg_id'];
}
function pm_notification($mode, $author, $recipients, $subject, $message, $mid)
{
	global $db, $db_prefix, $user, $config,$sitename,$siteurl, $phpEx, $auth,$language;

	$subject = censor_text($subject);

	unset($recipients[0], $recipients[$user->id]);

	if (!sizeof($recipients))
	{
		return;
	}

	// Get banned User ID's
	$sql = 'SELECT id AS ban_userid
		FROM ' . $db_prefix . '_users
		WHERE ' . $db->sql_in_set('id', array_map('intval', array_keys($recipients))) . '
			AND ban = 1';
	$result = $db->sql_query($sql);

	while ($row = $db->sql_fetchrow($result))
	{
		unset($recipients[$row['ban_userid']]);
	}
	$db->sql_freeresult($result);

	if (!sizeof($recipients))
	{
		return;
	}

	$sql = 'SELECT id, username, email, language, pm_notify, jabber, user_notify_type
		FROM ' . $db_prefix . '_users
		WHERE ' . $db->sql_in_set('id', array_map('intval', array_keys($recipients)));
	$result = $db->sql_query($sql);

	$msg_list_ary = array();
	while ($row = $db->sql_fetchrow($result))
	{
		if ($row['pm_notify'] == 'true' && trim($row['email']))
		{
			$msg_list_ary[] = array(
				'method'	=> $row['user_notify_type'],
				'email'		=> $row['email'],
				'jabber'	=> $row['jabber'],
				'name'		=> $row['username'],
				'lang'		=> $row['language']
			);
		}
	}
	$db->sql_freeresult($result);

	if (!sizeof($msg_list_ary))
	{
		return;
	}

	include_once('include/class.email.php');
	include_once("include/utf/utf_tools.php");
	include_once('include/function_messenger.php');
	$messenger = new messenger();
	foreach ($msg_list_ary as $pos => $addr)
	{
							if ((!$addr['lang']) OR !file_exists("language/email/".$addr['lang']."/privmsg_notify.txt")) $lang_email = $language;
							else $lang_email = $addr['lang'];
		$messenger->template('privmsg_notify', $lang_email);
		$messenger->to($addr['email'], $addr['name']);
		$messenger->im($addr['jabber'], $addr['name']);
		$messenger->assign_vars(array(
			'SUBJECT'		=> htmlspecialchars_decode($subject),
			'AUTHOR_NAME'	=> htmlspecialchars_decode($author),
			'USERNAME'		=> htmlspecialchars_decode($addr['name']),
			'U_INBOX'			=> $siteurl . "/pm.$phpEx",
			'U_VIEW_MESSAGE'	=> $siteurl . "/pm.$phpEx??i=0&op=readmsg&f=0&p=$mid",
		));
		$messenger->send($addr['method']);
	}
	unset($msg_list_ary);
	$messenger->save_queue();
	unset($messenger);
}
function message_history($msg_id, $user_id, $message_row, $folder, $in_post_mode = false)
{
	global $db, $db_prefix, $user, $config, $template,$sitename,$siteurl, $phpEx, $auth, $bbcode;

	// Select all receipts and the author from the pm we currently view, to only display their pm-history
	$sql = 'SELECT author_id, user_id
		FROM ' . $db_prefix . "_privmsgs_to
		WHERE msg_id = $msg_id
			AND folder_id <> " . -4;
	$result = $db->sql_query($sql);

	$recipients = array();
	while ($row = $db->sql_fetchrow($result))
	{
		$recipients[] = (int) $row['user_id'];
		$recipients[] = (int) $row['author_id'];
	}
	$db->sql_freeresult($result);
	$recipients = array_unique($recipients);

	// Get History Messages (could be newer)
	$sql = 'SELECT u.*, p.*, t.*
		FROM ' . $db_prefix . '_private_messages p, ' . $db_prefix . '_privmsgs_to t, ' . $db_prefix . '_users  u
		WHERE t.msg_id = p.id
			AND p.sender = u.id
			AND t.folder_id NOT IN (' . -3 . ', ' . -4 . ')
			AND ' . $db->sql_in_set('t.author_id', $recipients, false, true) . "
			AND t.user_id = $user_id";

	// We no longer need those.
	unset($recipients);

	if (!$message_row['root_level'])
	{
		$sql .= " AND (p.root_level = $msg_id OR (p.root_level = 0 AND p.id = $msg_id))";
	}
	else
	{
		$sql .= " AND (p.root_level = " . $message_row['root_level'] . ' OR p.id = ' . $message_row['root_level'] . ')';
	}
	$sql .= ' ORDER BY p.sent DESC';

	$result = $db->sql_query($sql);
	$row = $db->sql_fetchrow($result);

	if (!$row)
	{
		$db->sql_freeresult($result);
		return false;
	}

	$title = $row['subject'];

	$rowset = array();
	$bbcode_bitfield = '';
	$folder_url = append_sid("{$siteurl}/pm.$phpEx", 'i=pm') . '&amp;folder=';

	do
	{
		$folder_id = (int) $row['folder_id'];

		$row['folder'][] = (isset($folder[$folder_id])) ? '<a href="' . $folder_url . $folder_id . '">' . $folder[$folder_id]['folder_name'] . '</a>' : $user->lang['UNKNOWN_FOLDER'];

		if (isset($rowset[$row['msg_id']]))
		{
			$rowset[$row['msg_id']]['folder'][] = (isset($folder[$folder_id])) ? '<a href="' . $folder_url . $folder_id . '">' . $folder[$folder_id]['folder_name'] . '</a>' : $user->lang['UNKNOWN_FOLDER'];
		}
		else
		{
			$rowset[$row['msg_id']] = $row;
			$bbcode_bitfield = $bbcode_bitfield | base64_decode($row['bbcode_bitfield']);
		}
	}
	while ($row = $db->sql_fetchrow($result));
	//$db->sql_freeresult($result);
	//die(print_r($row));

	if (sizeof($rowset) == 1 && !$in_post_mode)
	{
		return false;
	}

	// Instantiate BBCode class
	if ((empty($bbcode) || $bbcode === false) && $bbcode_bitfield !== '')
	{
		if (!class_exists('bbcode'))
		{
			include('include/bbcode.' . $phpEx);
		}
		$bbcode = new bbcode(base64_encode($bbcode_bitfield));
	}

	$title = censor_text($title);

	$url = append_sid("{$siteurl}/pm.$phpEx", 'op=readmsg');
	$next_history_pm = $previous_history_pm = $prev_id = 0;

	// Re-order rowset to be able to get the next/prev message rows...
	$rowset = array_values($rowset);

	for ($i = 0, $size = sizeof($rowset); $i < $size; $i++)
	{
		$row = &$rowset[$i];
		$id = (int) $row['id'];

		$author_id	= $row['sender'];
		$folder_id	= (int) $row['folder_id'];

		$subject	= $row['subject'];
		$message	= $row['text'];

		$message = censor_text($message);

		$decoded_message = false;

		if ($in_post_mode && checkaccess('u_sendpm') && $author_id != 0)
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
		$message = parse_smiles($message, !$row['enable_smilies']);

		$subject = censor_text($subject);

		if ($id == $msg_id)
		{
			$next_history_pm = (isset($rowset[$i + 1])) ? (int) $rowset[$i + 1]['msg_id'] : 0;
			$previous_history_pm = $prev_id;
		}
					if(!$row["country"]){
						$usercountry = "unknown";
					}else{
						$res4 = $db->sql_query("SELECT name,flagpic FROM ".$db_prefix."_countries WHERE id=$row[country] LIMIT 1");
						$arr4 = $db->sql_fetchrow($res4);
						$usercountry = $arr4["name"];
					}

		$template->assign_block_vars('history_row', array(
			'MESSAGE_AUTHOR_QUOTE'		=> (($decoded_message) ? addslashes(get_username_string('username', $author_id, $row['username'], str_replace('#','',getusercolor($row['can_do'])), $row['username'])) : ''),
			'MESSAGE_AUTHOR_FULL'		=> get_username_string('full', $author_id, $row['username'], str_replace('#','',getusercolor($row['can_do'])), $row['username']),
			'MESSAGE_AUTHOR_COLOUR'		=> get_username_string('colour', $author_id, $row['username'], str_replace('#','',getusercolor($row['can_do'])), $row['username']),
			'MESSAGE_AUTHOR'			=> get_username_string('username', $author_id, $row['username'], str_replace('#','',getusercolor($row['can_do'])), $row['username']),
			'U_MESSAGE_AUTHOR'			=> get_username_string('profile', $author_id, $row['username'], str_replace('#','',getusercolor($row['can_do'])), $row['username']),
			'MESSAGE_AUTHOR_UPLOAD'		=> mksize($row["uploaded"]),
			'MESSAGE_AUTHOR_DOWNLOAD'	=> mksize($row["downloaded"]),
			'MESSAGE_AUTHOR_RATIO'		=> get_u_ratio($row["uploaded"], $row["downloaded"]),
			'MESSAGE_AUTHOR_AVATAR'		=> gen_avatar($author_id),
			'MESSAGE_AUTHOR_LOCATION'	=> $usercountry,

			'SUBJECT'			=> $subject,
			'SENT_DATE'			=> $user->format_date(sql_timestamp_to_unix_timestamp($row['sent'])),
			'MESSAGE'			=> $message,
			'FOLDER'			=> implode(', ', $row['folder']),
			'DECODED_MESSAGE'	=> $decoded_message,

			'S_CURRENT_MSG'		=> ($row['msg_id'] == $msg_id),
			'S_AUTHOR_DELETED'	=> ($author_id == 0) ? true : false,
			'S_IN_POST_MODE'	=> $in_post_mode,

			'MSG_ID'			=> $row['msg_id'],
			'U_VIEW_MESSAGE'	=> "$url&amp;i=0&amp;f=$folder_id&amp;p=" . $row['msg_id'],
			'U_QUOTE'			=> (!$in_post_mode && checkaccess('u_sendpm') && $author_id != 0) ? append_sid("{$siteurl}/pm.$phpEx", "op=send&amp;mode=compose&amp;action=quote&amp;f=" . $folder_id . "&amp;p=" . $row['msg_id']) : '',
			'U_POST_REPLY_PM'	=> ($author_id != $user->id && $author_id != 0 && checkaccess('u_sendpm')) ? append_sid("{$siteurl}/pm.$phpEx", "op=send&amp;mode=compose&amp;action=reply&amp;f=$folder_id&amp;p=" . $row['msg_id']) : '')
		);
		unset($rowset[$i]);
		$prev_id = $id;
	}

	$template->assign_vars(array(
		'QUOTE_IMG'			=> $user->img('icon_post_quote', $user->lang['REPLY_WITH_QUOTE']),
		'HISTORY_TITLE'		=> $title,

		'U_VIEW_NEXT_HISTORY'		=> ($next_history_pm) ? "$url&amp;p=" . $next_history_pm : '',
		'U_VIEW_PREVIOUS_HISTORY'	=> ($previous_history_pm) ? "$url&amp;p=" . $previous_history_pm : '',
	));

	return true;
}
function set_user_message_limit()
{
	global $user, $db, $config,$sitename,$siteurl,$db_prefix;

	// Get maximum about from user memberships - if it is 0, there is no limit set and we use the maximum value within the config.
	$sql = 'SELECT MAX(g.group_message_limit) as max_message_limit
		FROM ' . $db_prefix . '_level_settings g, ' . $db_prefix . '_user_group ug
		WHERE ug.user_id = ' . $user->id . '
			AND ug.user_pending = 0
			AND ug.group_id = g.group_id';
	$result = $db->sql_query($sql);
	$message_limit = (int) $db->sql_fetchfield('max_message_limit');
	$db->sql_freeresult($result);

	$user->data['message_limit'] = (!$message_limit) ? $config['pm_max_msgs'] : $message_limit;
}

function get_folder_status($folder_id, $folder)
{
	global $db, $user, $config,$sitename,$siteurl,$db_prefix;

	if (isset($folder[$folder_id]))
	{
		$folder = $folder[$folder_id];
	}
	else
	{
		return false;
	}

	$return = array(
		'folder_name'	=> $folder['folder_name'],
		'cur'			=> $folder['num_messages'],
		'remaining'		=> ($user->data['message_limit']) ? $user->data['message_limit'] - $folder['num_messages'] : 0,
		'max'			=> $user->data['message_limit'],
		'percent'		=> ($user->data['message_limit']) ? (($user->data['message_limit'] > 0) ? round(($folder['num_messages'] / $user->data['message_limit']) * 100) : 100) : 0,
	);

	$return['message']	= sprintf($user->lang['_FOLDER_STATUS_MSG'], $return['percent'], $return['cur'], $return['max']);

	return $return;
}
function handle_mark_actions($user_id, $mark_action)
{
	global $db, $user,$sitename,$siteurl, $phpEx,$db_prefix, $template;
	$msg_ids		= request_var('marked_msg_id', array(0));
	$cur_folder_id	= request_var('cur_folder_id', -3);
	$confirm		= (isset($_POST['confirm'])) ? true : false;
	if (!sizeof($msg_ids))
	{
		return false;
	}
//die(print_r($mark_action));

	switch ($mark_action)
	{
		case 'mark_important':

			$sql = 'UPDATE ' . $db_prefix . "_privmsgs_to
				SET pm_marked = 1 - pm_marked
				WHERE folder_id = $cur_folder_id
					AND user_id = $user_id
					AND " . $db->sql_in_set('msg_id', $msg_ids);
			$db->sql_query($sql);

		break;

		case 'delete_marked':

			global $auth,$db_prefix,$siteurl;

			if (!checkaccess('u_pm_delete'))
			{
				trigger_error('NO_AUTH_DELETE_MESSAGE');
			}

			if (confirm_box(true))
			{
				delete_pm($user_id, $msg_ids, $cur_folder_id);

				$success_msg = (sizeof($msg_ids) == 1) ? 'MESSAGE_DELETED' : 'MESSAGES_DELETED';
				$redirect = append_sid("{$siteurl}/pm.$phpEx", 'i=pm&amp;folder=' . $cur_folder_id);

				meta_refresh(3, $redirect);
								$template->assign_vars(array(
					'S_SUCCESS'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['REDIRECT'],
					'MESSAGE'			=> $user->lang[$success_msg] . '<br /><br />' . sprintf($user->lang['RETURN_FOLDER'], '<a href="' . $redirect . '">', '</a>'),
				));
				echo $template->fetch('message_body.html');
				close_out();

				//trigger_error($user->lang[$success_msg] . '<br /><br />' . sprintf($user->lang['RETURN_FOLDER'], '<a href="' . $redirect . '">', '</a>'));
			}
			else
			{
				$s_hidden_fields = array(
					'action'	=> 'view_folder',
					'mode'	=> 'view',
					'i'	=> 'pm',
					'op'	=> 'folder',
					'cur_folder_id'	=> $cur_folder_id,
					'mark_option'	=> 'delete_marked',
					'submit_mark'	=> true,
					'marked_msg_id'	=> $msg_ids
				);

				confirm_box(false, $user->lang['DELETE_MARKED_PM'], build_hidden_fields($s_hidden_fields),'confirm_body.html','pm.php');
			}

		break;

		default:
			return false;
	}

	return true;
}
function delete_pm($user_id, $msg_ids, $folder_id)
{
	global $db, $user,$sitename,$siteurl, $phpEx,$db_prefix;

	$user_id	= (int) $user_id;
	$folder_id	= (int) $folder_id;

	if (!$user_id)
	{
		return false;
	}

	if (!is_array($msg_ids))
	{
		if (!$msg_ids)
		{
			return false;
		}
		$msg_ids = array($msg_ids);
	}

	if (!sizeof($msg_ids))
	{
		return false;
	}

	// Get PM Information for later deleting
	$sql = 'SELECT msg_id, pm_unread, pm_new
		FROM ' . $db_prefix . '_privmsgs_to
		WHERE ' . $db->sql_in_set('msg_id', array_map('intval', $msg_ids)) . "
			AND folder_id = $folder_id
			AND user_id = $user_id";
	$result = $db->sql_query($sql);

	$delete_rows = array();
	$num_unread = $num_new = $num_deleted = 0;
	while ($row = $db->sql_fetchrow($result))
	{
		$num_unread += (int) $row['pm_unread'];
		$num_new += (int) $row['pm_new'];

		$delete_rows[$row['msg_id']] = 1;
	}
	$db->sql_freeresult($result);
	unset($msg_ids);

	if (!sizeof($delete_rows))
	{
		return false;
	}

	//$db->sql_transaction('begin');

	// if no one has read the message yet (meaning it is in users outbox)
	// then mark the message as deleted...
	if ($folder_id == -2)
	{
		// Remove PM from Outbox
		$sql = 'DELETE FROM ' . $db_prefix . "_privmsgs_to
			WHERE user_id = $user_id AND folder_id = " . -2 . '
				AND ' . $db->sql_in_set('msg_id', array_keys($delete_rows));
		$db->sql_query($sql);

		// Update PM Information for safety
		$sql = 'UPDATE ' . $db_prefix . "_private_messages SET text = ''
			WHERE " . $db->sql_in_set('id', array_keys($delete_rows));
		$db->sql_query($sql);

		// Set delete flag for those intended to receive the PM
		// We do not remove the message actually, to retain some basic information (sent time for example)
		$sql = 'UPDATE ' . $db_prefix . '_privmsgs_to
			SET pm_deleted = 1
			WHERE ' . $db->sql_in_set('msg_id', array_keys($delete_rows));
		$db->sql_query($sql);

		$num_deleted = $db->sql_affectedrows();
	}
	else
	{
		// Delete private message data
		$sql = 'DELETE FROM ' . $db_prefix . "_privmsgs_to
			WHERE user_id = $user_id
				AND folder_id = $folder_id
				AND " . $db->sql_in_set('msg_id', array_keys($delete_rows));
		$db->sql_query($sql);
		$num_deleted = $db->sql_affectedrows();
	}

	// if folder id is user defined folder then decrease pm_count
	if (!in_array($folder_id, array(0, -2, -1, -3)))
	{
		$sql = 'UPDATE ' . $db_prefix . "_privmsgs_folder
			SET pm_count = pm_count - $num_deleted
			WHERE folder_id = $folder_id";
		$db->sql_query($sql);
	}

	// Update unread and new status field
	if ($num_unread || $num_new)
	{
		$set_sql = ($num_unread) ? 'user_unread_privmsg = user_unread_privmsg - ' . $num_unread : '';

		if ($num_new)
		{
			$set_sql .= ($set_sql != '') ? ', ' : '';
			$set_sql .= 'user_new_privmsg = user_new_privmsg - ' . $num_new;
		}

		$db->sql_query('UPDATE ' . $db_prefix . "_users SET $set_sql WHERE id = $user_id");

		$user->new_pm -= $num_new;
		$user->unread_pm -= $num_unread;
	}

	// Now we have to check which messages we can delete completely
	$sql = 'SELECT msg_id
		FROM ' . $db_prefix . '_privmsgs_to
		WHERE ' . $db->sql_in_set('msg_id', array_keys($delete_rows));
	$result = $db->sql_query($sql);

	while ($row = $db->sql_fetchrow($result))
	{
		unset($delete_rows[$row['msg_id']]);
	}
	$db->sql_freeresult($result);

	$delete_ids = array_keys($delete_rows);

	if (sizeof($delete_ids))
	{
		// Check if there are any attachments we need to remove
		if (!function_exists('delete_attachments'))
		{
			include('include/function_posting.' . $phpEx);
		}

		delete_attachments('message', $delete_ids, false);

		$sql = 'DELETE FROM ' . $db_prefix . '_private_messages
			WHERE ' . $db->sql_in_set('id', $delete_ids);
		$db->sql_query($sql);
	}

	//$db->sql_transaction('commit');

	return true;
}
function update_unread_status($unread, $msg_id, $user_id, $folder_id)
{
	if (!$unread)
	{
		return;
	}

	global $db, $user,$sitename,$siteurl,$db_prefix;

	$sql = 'UPDATE ' . $db_prefix . "_privmsgs_to
		SET pm_unread = 0
		WHERE msg_id = $msg_id
			AND user_id = $user_id
			AND folder_id = $folder_id";
	$db->sql_query($sql);

	$sql = 'UPDATE ' . $db_prefix . "_users
		SET user_unread_privmsg = user_unread_privmsg - 1
		WHERE id = $user_id";
	$db->sql_query($sql);

	if ($user->id == $user_id)
	{
		$user->unread_pm--;

		// Try to cope with previous wrong conversions...
		if ($user->unread_pm < 0)
		{
			$sql = 'UPDATE ' . $db_prefix . "_users
				SET user_unread_privmsg = 0
				WHERE id = $user_id";
			$db->sql_query($sql);

			$user->unread_pm = 0;
		}
	}
}
function place_pm_into_folder(&$global_privmsgs_rules, $release = false)
{
	global $db, $user, $config,$sitename,$siteurl,$db_prefix;
	//return array('not_moved' => 0, 'removed' => 0);


	if (!$user->new_pm)
	{

		return array('not_moved' => 0, 'removed' => 0);
	}
	$user_message_rules = (int) $user->pm_rule;
	$user_id = (int) $user->id;

	$action_ary = $move_into_folder = array();
	$num_removed = 0;

	// Newly processing on-hold messages
	if ($release)
	{
		$sql = 'UPDATE ' . $db_prefix . '_privmsgs_to
			SET folder_id = ' . -3 . '
			WHERE folder_id = ' . -4 . "
				AND user_id = $user_id";
		$db->sql_query($sql);
	}

	// Get those messages not yet placed into any box
	$retrieve_sql = 'SELECT t.*, p.id as msg_id, p.text as message_text, p.subject as message_subject, p.*, u.username, u.id, u.can_do as group_id
		FROM ' . $db_prefix . '_privmsgs_to t, ' . $db_prefix . '_private_messages p, ' . $db_prefix . "_users u
		WHERE t.user_id = $user_id
			AND p.sender = u.id
			AND t.folder_id = " . -3 . '
			AND t.msg_id = p.id';
	// Just place into the appropriate arrays if no rules need to be checked
	if (!$user_message_rules)
	{
		$result = $db->sql_query($retrieve_sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$action_ary[$row['msg_id']][] = array('action' => false);
		}
		$db->sql_freeresult($result);

	}
	else
	{
		$user_rules = $zebra = $check_rows = array();
		$user_ids = $memberships = array();

		// First of all, grab all rules and retrieve friends/foes
		$sql = 'SELECT *
			FROM ' . $db_prefix . "_private_messages_rules
			WHERE user_id = $user_id";
		$result = $db->sql_query($sql);
		$user_rules = $db->sql_fetchrowset($result);
		$db->sql_freeresult($result);

		if (sizeof($user_rules))
		{
		$sql = 'SELECT zebra_id, friend, foe
				FROM ' . $db_prefix . "_zebra
				WHERE user_id = $user_id";
			$result = $db->sql_query($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				$zebra[$row['zebra_id']] = $row;
			}
			$db->sql_freeresult($result);
		}
		// Now build a bare-bone check_row array
		$result = $db->sql_query($retrieve_sql);

		while ($row = $db->sql_fetchrow($result))
		{
		//print_r($row);
			$check_rows[] = array_merge($row, array(
				'to'				=> explode(':', $row['recipient']),
				'bcc'				=> explode(':', $row['bcc_address']),
				'friend'			=> (checkfriend($row['sender'])) ? '1' : 0,
				'foe'				=> (checkfoe($row['sender'])) ? '1' : 0,
				'user_in_group'		=> array($user->group),
				'author_in_group'	=> array())
			);
			$user_ids[] = $row['user_id'];
			$memberships[$row['user_id']][] = $row['group_id'];
		}
		$db->sql_freeresult($result);

		// Retrieve user memberships
		if (sizeof($user_ids))
		{
			$sql = 'SELECT *
				FROM ' . $db_prefix . '_users 
				WHERE ' . $db->sql_in_set('id', $user_ids) . '
					AND active = 1';
			$result = $db->sql_query($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				$memberships[$row['id']][] = $row['can_do'];
			}
			$db->sql_freeresult($result);
		}

		// Now place into the appropriate folder
		foreach ($check_rows as $row)
		{
			// Add membership if set
			if (isset($memberships[$row['sender']]))
			{
				$row['author_in_group'] = $memberships[$row['id']];
			}
			// Check Rule - this should be very quick since we have all information we need
			$is_match = false;
		if (!sizeof($user_rules))
		{
		$user_rules = array();
		}
			foreach ($user_rules as $rule_row)
			{
				if (($action = check_rule($global_privmsgs_rules, $rule_row, $row, $user_id)) !== false)
				{
					$is_match = true;
					$action_ary[$row['msg_id']][] = $action;
				}
			}

			if (!$is_match)
			{
				$action_ary[$row['msg_id']][] = array('action' => false);
			}
		}

		unset($user_rules, $zebra, $check_rows, $user_ids, $memberships);
	}

	// We place actions into arrays, to save queries.
	$sql = $unread_ids = $delete_ids = $important_ids = array();

	foreach ($action_ary as $msg_id => $msg_ary)
	{
		// It is allowed to execute actions more than once, except placing messages into folder
		$folder_action = $message_removed = false;

		foreach ($msg_ary as $pos => $rule_ary)
		{
			if ($folder_action && $rule_ary['action'] == ACTION_PLACE_INTO_FOLDER)
			{
				continue;
			}
//echo 'test';
			switch ($rule_ary['action'])
			{
				case ACTION_PLACE_INTO_FOLDER:
					// Folder actions have precedence, so we will remove any other ones
					$folder_action = true;
					$move_into_folder[(int) $rule_ary['folder_id']][] = $msg_id;
				break;

				case ACTION_MARK_AS_READ:
					if ($rule_ary['pm_unread'])
					{
						$unread_ids[] = $msg_id;
					}
				break;

				case ACTION_DELETE_MESSAGE:
					$delete_ids[] = $msg_id;
					$message_removed = true;
				break;

				case ACTION_MARK_AS_IMPORTANT:
					if (!$rule_ary['pm_marked'])
					{
						$important_ids[] = $msg_id;
					}
				break;
			}
		}
		// We place this here because it could happen that the messages are doubled if a rule marks a message and then moves it into a specific
		// folder. Here we simply move the message into the INBOX if it gets not removed and also not put into a custom folder.
		if (!$folder_action && !$message_removed)
		{
			$move_into_folder[0][] = $msg_id;
		}
	}

	// Do not change the order of processing
	// The number of queries needed to be executed here highly depends on the defined rules and are
	// only gone through if new messages arrive.

	// Delete messages
	if (sizeof($delete_ids))
	{
		$num_removed += sizeof($delete_ids);
		delete_pm($user_id, $delete_ids, -3);
	}

	// Set messages to Unread
	if (sizeof($unread_ids))
	{
		$sql = 'UPDATE ' . $db_prefix . '_privmsgs_to
			SET pm_unread = 0
			WHERE ' . $db->sql_in_set('msg_id', $unread_ids) . "
				AND user_id = $user_id
				AND folder_id = " . -3;
		$db->sql_query($sql);
	}

	// mark messages as important
	if (sizeof($important_ids))
	{
		$sql = 'UPDATE ' . $db_prefix . '_privmsgs_to
			SET pm_marked = 1 - pm_marked
			WHERE folder_id = ' . -3 . "
				AND user_id = $user_id
				AND " . $db->sql_in_set('msg_id', $important_ids);
		$db->sql_query($sql);
	}

	// Move into folder
	$folder = array();

	if (sizeof($move_into_folder))
	{
		// Determine Full Folder Action - we need the move to folder id later eventually
		$full_folder_action = ($user->data['user_full_folder'] == -3) ? ($config['full_folder_action'] - (-3*(-1))) : $user->data['user_full_folder'];

		$sql_folder = array_keys($move_into_folder);
		if ($full_folder_action >= 0)
		{
			$sql_folder[] = $full_folder_action;
		}

		$sql = 'SELECT folder_id, pm_count
			FROM ' . $db_prefix . '_privmsgs_folder
			WHERE ' . $db->sql_in_set('folder_id', $sql_folder) . "
				AND user_id = $user_id";
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$folder[(int) $row['folder_id']] = (int) $row['pm_count'];
		}
		$db->sql_freeresult($result);

		unset($sql_folder);

		if (isset($move_into_folder[0]))
		{
			$sql = 'SELECT COUNT(msg_id) as num_messages
				FROM ' . $db_prefix . "_privmsgs_to
				WHERE user_id = $user_id
					AND folder_id = " . 0;
			$result = $db->sql_query($sql);
			$folder[0] = (int) $db->sql_fetchfield('num_messages');
			$db->sql_freeresult($result);
		}
	}

	// Here we have ideally only one folder to move into
	foreach ($move_into_folder as $folder_id => $msg_ary)
	{
	$dest_folder = $full_folder_action = '';
		$dest_folder = $folder_id;
		$full_folder_action = -3;

		// Check Message Limit - we calculate with the complete array, most of the time it is one message
		// But we are making sure that the other way around works too (more messages in queue than allowed to be stored)
		if ($user->data['message_limit'] && $folder[$folder_id] && ($folder[$folder_id] + sizeof($msg_ary)) > $user->data['message_limit'])
		{
			$full_folder_action = ($user->data['user_full_folder'] == -3) ? ($config['full_folder_action'] - (-3*(-1))) : $user->data['user_full_folder'];

			// If destination folder itself is full...
			if ($full_folder_action >= 0 && ($folder[$full_folder_action] + sizeof($msg_ary)) > $user->data['message_limit'])
			{
				$full_folder_action = $config['full_folder_action'] - (-3*(-1));
			}

			// If Full Folder Action is to move to another folder, we simply adjust the destination folder
			if ($full_folder_action >= 0)
			{
				$dest_folder = $full_folder_action;
			}
			else if ($full_folder_action == -2)
			{
				// Delete some messages. NOTE: Ordered by msg_id here instead of message_time!
				$sql = 'SELECT msg_id
					FROM ' . $db_prefix . "_privmsgs_to
					WHERE user_id = $user_id
						AND folder_id = $dest_folder
					ORDER BY msg_id ASC";
				$result = $db->sql_query($sql . ' LIMIT ' . (($folder[$dest_folder] + sizeof($msg_ary)) - $user->data['message_limit']));

				$delete_ids = array();
				while ($row = $db->sql_fetchrow($result))
				{
					$delete_ids[] = $row['msg_id'];
				}
				$db->sql_freeresult($result);

				$num_removed += sizeof($delete_ids);
				delete_pm($user_id, $delete_ids, $dest_folder);
			}
		}

		//
		if ($full_folder_action == -1)
		{
			$sql = 'UPDATE ' . $db_prefix . '_privmsgs_to
				SET folder_id = ' . -4 . '
				WHERE folder_id = ' . -3 . "
					AND user_id = $user_id
					AND " . $db->sql_in_set('msg_id', $msg_ary);
			$db->sql_query($sql);
		}
		else
		{
			$sql = 'UPDATE ' . $db_prefix . "_privmsgs_to
				SET folder_id = $dest_folder, pm_new = 0
				WHERE folder_id = " . -3 . "
					AND user_id = $user_id
					AND pm_new = 1
					AND " . $db->sql_in_set('msg_id', $msg_ary);
			$db->sql_query($sql);

			if ($dest_folder != 0)
			{
				$sql = 'UPDATE ' . $db_prefix . '_privmsgs_folder
					SET pm_count = pm_count + ' . (int) $db->sql_affectedrows() . "
					WHERE folder_id = $dest_folder
						AND user_id = $user_id";
				$db->sql_query($sql);
			}
		}
	}

	if (sizeof($action_ary))
	{
		// Move from OUTBOX to SENTBOX
		// We are not checking any full folder status here... SENTBOX is a special treatment (old messages get deleted)
		$sql = 'UPDATE ' . $db_prefix . '_privmsgs_to
			SET folder_id = ' . -1 . '
			WHERE folder_id = ' . -2 . '
				AND ' . $db->sql_in_set('msg_id', array_keys($action_ary));
		$db->sql_query($sql);
	}

	// Update new/unread count
	update_pm_counts();

	// Now check how many messages got not moved...
	$sql = 'SELECT COUNT(msg_id) as num_messages
		FROM ' . $db_prefix . "_privmsgs_to
		WHERE user_id = $user_id
			AND folder_id = " . -4;
	$result = $db->sql_query($sql);
	$num_not_moved = (int) $db->sql_fetchfield('num_messages');
	$db->sql_freeresult($result);

	return array('not_moved' => $num_not_moved, 'removed' => $num_removed);
}
function check_rule(&$rules, &$rule_row, &$message_row, $user_id)
{
	global $user, $config,$sitename,$siteurl,$db_prefix;

	if (!isset($rules[$rule_row['rule_check']][$rule_row['rule_connection']]))
	{
		return false;
	}

	$check_ary = $rules[$rule_row['rule_check']][$rule_row['rule_connection']];

	// Replace Check Literals
	$evaluate = $check_ary['function'];
	$evaluate = preg_replace('/{(CHECK[0-9])}/', '$message_row[$check_ary[strtolower("\1")]]', $evaluate);

	// Replace Rule Literals
	$evaluate = preg_replace('/{(STRING|USER_ID|GROUP_ID)}/', '$rule_row["rule_" . strtolower("\1")]', $evaluate);

	// Evil Statement
	$result = false;
	eval('$result = (' . $evaluate . ') ? true : false;');

	if (!$result)
	{
		return false;
	}
	//echo '|'.$rule_row['rule_folder_id'].'|';

	switch ($rule_row['rule_action'])
	{
		case ACTION_PLACE_INTO_FOLDER:
			return array('action' => $rule_row['rule_action'], 'folder_id' => $rule_row['rule_folder_id']);
		break;

		case ACTION_MARK_AS_READ:
		case ACTION_MARK_AS_IMPORTANT:
			return array('action' => $rule_row['rule_action'], 'pm_unread' => $message_row['pm_unread'], 'pm_marked' => $message_row['pm_marked']);
		break;

		case ACTION_DELETE_MESSAGE:
			global $db, $auth,$db_prefix;

			// Check for admins/mods - users are not allowed to remove those messages...
			// We do the check here to make sure the data we use is consistent
			$sql = 'SELECT id, user_type, user_permissions
				FROM ' . $db_prefix . '_users 
				WHERE id = ' . (int) $message_row['author_id'];
			$result = $db->sql_query($sql);
			$userdata = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			$auth2 = new auth();
			$auth2->acl($userdata);

			if (!$auth2->acl_get('a_') && !$auth2->acl_get('m_') && !$auth2->acl_getf_global('m_'))
			{
				return array('action' => $rule_row['rule_action'], 'pm_unread' => $message_row['pm_unread'], 'pm_marked' => $message_row['pm_marked']);
			}

			return false;
		break;

		default:
			return false;
	}

	return false;
}
function update_pm_counts()
{
	global $user, $db,$db_prefix;

	// Update unread count
	$sql = 'SELECT COUNT(msg_id) as num_messages
		FROM ' . $db_prefix . '_privmsgs_to
		WHERE pm_unread = 1
			AND folder_id <> ' . -2 . '
			AND user_id = ' . $user->id;
	$result = $db->sql_query($sql);
	$user->unread_pm = (int) $db->sql_fetchfield('num_messages');
	$db->sql_freeresult($result);

	// Update new pm count
	$sql = 'SELECT COUNT(msg_id) as num_messages
		FROM ' . $db_prefix . '_privmsgs_to
		WHERE pm_new = 1
			AND folder_id IN (' . -3 . ', ' . -4 . ')
			AND user_id = ' . $user->id;
	$result = $db->sql_query($sql);
	$user->new_pm = (int) $db->sql_fetchfield('num_messages');
	$db->sql_freeresult($result);

	$db->sql_query('UPDATE ' . $db_prefix . '_users  SET ' . $db->sql_build_array('UPDATE', array(
		'user_unread_privmsg'	=> (int) $user->unread_pm,
		'user_new_privmsg'		=> (int) $user->new_pm,
	)) . ' WHERE id = ' . $user->id);

	// Ok, here we need to repair something, other boxes than privmsgs_no_box and privmsgs_hold_box should not carry the pm_new flag.
	if (!$user->new_pm)
	{
		$sql = 'UPDATE ' . $db_prefix . '_privmsgs_to
			SET pm_new = 0
			WHERE pm_new = 1
				AND folder_id NOT IN (' . -3 . ', ' . -4 . ')
				AND user_id = ' . $user->id;
		$db->sql_query($sql);
	}
}
function write_pm_addresses($check_ary, $author_id, $plaintext = false)
{
	global $db, $user, $db_prefix, $template,$sitename,$siteurl, $phpEx;

	$addresses = array();

	foreach ($check_ary as $check_type => $address_field)
	{
		if (!is_array($address_field))
		{
			// Split Addresses into users and groups
			preg_match_all('/:?(u|g)_([0-9]+):?/', $address_field, $match);

			$u = $g = array();
			foreach ($match[1] as $id => $type)
			{
				${$type}[] = (int) $match[2][$id];
			}
		}
		else
		{
			$u = $address_field['u'];
			$g = $address_field['g'];
		}

		$address = array();
		if (sizeof($u))
		{
			$sql = 'SELECT id, username
				FROM ' . $db_prefix . '_users 
				WHERE ' . $db->sql_in_set('id', $u);
			$result = $db->sql_query($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				if ($check_type == 'to' || $author_id == $user->id || $row['user_id'] == $user->id)
				{
					if ($plaintext)
					{
						$address[] = $row['username'];
					}
					else
					{
						$address['user'][$row['id']] = array('name' => $row['username'], 'colour' => getusercolor(getlevel_name($row['id'])));
					}
				}
			}
			$db->sql_freeresult($result);
		}

		if (sizeof($g))
		{
			if ($plaintext)
			{
				$sql = 'SELECT group_name, group_type
					FROM ' . GROUPS_TABLE . '
						WHERE ' . $db->sql_in_set('group_id', $g);
				$result = $db->sql_query($sql);

				while ($row = $db->sql_fetchrow($result))
				{
					if ($check_type == 'to' || $author_id == $user->id || $row['user_id'] == $user->id)
					{
						$address[] = ($row['group_type'] == 3) ? $user->lang['G_' . $row['group_name']] : $row['group_name'];
					}
				}
				$db->sql_freeresult($result);
			}
			else
			{
				$sql = 'SELECT g.group_id, g.group_name, g.group_colour, g.group_type, ug.user_id
					FROM ' . GROUPS_TABLE . ' g, ' . $db_prefix . '_user_group ug
						WHERE ' . $db->sql_in_set('g.group_id', $g) . '
						AND g.group_id = ug.group_id
						AND ug.user_pending = 0';
				$result = $db->sql_query($sql);

				while ($row = $db->sql_fetchrow($result))
				{
					if (!isset($address['group'][$row['group_id']]))
					{
						if ($check_type == 'to' || $author_id == $user->id || $row['user_id'] == $user->id)
						{
							$row['group_name'] = ($row['group_type'] == 3) ? $user->lang['G_' . $row['group_name']] : $row['group_name'];
							$address['group'][$row['group_id']] = array('name' => $row['group_name'], 'colour' => $row['group_colour']);
						}
					}

					if (isset($address['user'][$row['user_id']]))
					{
						$address['user'][$row['user_id']]['in_group'] = $row['group_id'];
					}
				}
				$db->sql_freeresult($result);
			}
		}

		if (sizeof($address) && !$plaintext)
		{
			$template->assign_var('S_' . strtoupper($check_type) . '_RECIPIENT', true);

			foreach ($address as $type => $adr_ary)
			{
				foreach ($adr_ary as $id => $row)
				{
					$tpl_ary = array(
						'IS_GROUP'	=> ($type == 'group') ? true : false,
						'IS_USER'	=> ($type == 'user') ? true : false,
						'UG_ID'		=> $id,
						'NAME'		=> $row['name'],
						'COLOUR'	=> ($row['colour']) ? '#' . $row['colour'] : '',
						'TYPE'		=> $type,
					);

					if ($type == 'user')
					{
						$tpl_ary = array_merge($tpl_ary, array(
							'U_VIEW'		=> get_username_string('profile', $id, $row['name'], getusercolor(getlevel_name($id))),
							'NAME_FULL'		=> get_username_string('full', $id, $row['name'], getusercolor(getlevel_name($id))),
						));
					}
					else
					{
						$tpl_ary = array_merge($tpl_ary, array(
							'U_VIEW'		=> append_sid("{$phpbb_root_path}memberslist.$phpEx", 'mode=group&amp;g=' . $id),
						));
					}

					$template->assign_block_vars($check_type . '_recipient', $tpl_ary);
				}
			}
		}

		$addresses[$check_type] = $address;
	}

	return $addresses;
}

?>