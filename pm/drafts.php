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
	include_once './../security.php';
	die ();
}
$user->set_lang('pm',$user->ulanguage);
require_once("include/ucp/functions_privmsgs.php");
require_once("include/functions_forum.php");
require_once("include/class.bbcode.php");
include_once("include/utf/utf_tools.php");
				$pm_drafts = true;
				$u_action = "pm.php?op=drafts";
	generate_smilies('inline', 0);
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
add_form_key('ucp');
$template->assign_vars(array(
        'T_TEMPLATE_PATH'         => $siteurl . '/themes/' . $theme . '/templates',
        'S_PRIVMSGS'         => true,
        'ERROR_MESSAGE'         => false,
		'PMBT_LINK_BACK'		=> 'pm.php?',
        'S_UCP_ACTION'          => 'pm.php?op=drafts',
		'S_BBCODE_ALLOWED'=> true,
		'S_BBCODE_QUOTE'=> true,
		'S_BBCODE_IMG'=> true,
		'S_LINKS_ALLOWED'=> true,
		'S_BBCODE_FLASH'=> true,
		'S_SMILIES_ALLOWED'		=> true,
		'S_POST_ACTION'		=> $u_action,
));
				$template->assign_var('S_SHOW_DRAFTS', true);

				//$user->add_lang('posting');

				$edit		= (isset($_REQUEST['edit'])) ? true : false;
				$submit		= (isset($_POST['submit'])) ? true : false;
				$draft_id	= ($edit) ? intval($_REQUEST['edit']) : 0;
				$delete		= (isset($_POST['delete'])) ? true : false;

				$s_hidden_fields = ($edit) ? build_hidden_fields(array('edit'=>$draft_id, 'draft_id'=>$draft_id)) : '';
				$draft_subject = $draft_message = '';
				add_form_key('ucp');
				if ($delete)
				{
					if (confirm_box(true))
					{
						$drafts = array_keys(request_var('d', array(0 => 0)));

						if (sizeof($drafts))
						{
							$sql = 'DELETE FROM ' . $db_prefix . '_drafts
								WHERE ' . $db->sql_in_set('draft_id', $drafts) . '
									AND user_id = ' . $user->id;
							$db->sql_query($sql);
						}
						$msg = $user->lang['_DRAFTS_DELETED'];
						unset($drafts);
					}
					else
					{
						$drafts = array_keys(request_var('d', array(0 => 0)));
						foreach($drafts as $a)$did[$a] = $a;
						$hidden = build_hidden_fields(array(
						'd'	=>	$did,
									'delete'	=>	1,
						));
						confirm_box(false, $user->lang['_DELETE_MESSAGE_CONFIRM'], $hidden,'confirm_body.html',$u_action,$gfx_check);
					}
					$message = $msg . '<br /><br />' . sprintf($user->lang['_RETURN_UCP'], '<a href="' . $u_action . '">', '</a>');
					meta_refresh(3, $u_action);
					$template->assign_vars(array(
						'S_SUCCESS'			=> true,
						'S_FORWARD'			=> $u_action,
						'TITTLE_M'			=> $user->lang['SUCCESS'],
						'MESSAGE'			=> $message,
					));
					echo $template->fetch('message_body.html');
					close_out();
					trigger_error($message);
				}

				if ($submit && $edit)
				{
					$draft_subject = utf8_normalize_nfc(request_var('subject', '', true));
					$draft_message = utf8_normalize_nfc(request_var('message', '', true));
					if (check_form_key('ucp'))
					{
						if ($draft_message && $draft_subject)
						{
							$draft_row = array(
								'draft_subject' => $draft_subject,
								'draft_message' => $draft_message
							);

							$sql = 'UPDATE ' . $db_prefix . '_drafts
								SET ' . $db->sql_build_array('UPDATE', $draft_row) . "
								WHERE draft_id = $draft_id
									AND user_id = " . $user->id;
							$db->sql_query($sql);

							$message = $user->lang['DRAFT_UPDATED'] . '<br /><br />' . sprintf($user->lang['_RETURN_UCP'], '<a href="' . $u_action . '">', '</a>');

							meta_refresh(3, $u_action);
							trigger_error($message);
						}
						else
						{
							$template->assign_var('ERROR', ($draft_message == '') ? $user->lang['EMPTY_DRAFT'] : (($draft_subject == '') ? $user->lang['EMPTY_DRAFT_TITLE'] : ''));
						}
					}
					else
					{
						$template->assign_var('ERROR', $user->lang['FORM_INVALID']);
					}
				}

				if (!$pm_drafts)
				{
					$sql = 'SELECT d.*, f.forum_name
						FROM ' . $db_prefix . '_drafts d, ' . $db_prefix . '_forums f
						WHERE d.user_id = ' . $user->id . ' ' .
							(($edit) ? "AND d.draft_id = $draft_id" : '') . '
							AND f.forum_id = d.forum_id
						ORDER BY d.save_time DESC';
				}
				else
				{
					$sql = 'SELECT * FROM ' . $db_prefix . '_drafts
						WHERE user_id = ' . $user->id . ' ' .
							(($edit) ? "AND draft_id = $draft_id" : '') . '
							AND forum_id = 0
							AND topic_id = 0
						ORDER BY save_time DESC';
				}
				$result = $db->sql_query($sql);

				$draftrows = $topic_ids = array();

				while ($row = $db->sql_fetchrow($result))
				{
					if ($row['topic_id'])
					{
						$topic_ids[] = (int) $row['topic_id'];
					}
					$draftrows[] = $row;
				}
				$db->sql_freeresult($result);

				if (sizeof($topic_ids))
				{
					$sql = 'SELECT topic_id, forum_id, topic_title
						FROM ' . $db_prefix . '_topics
						WHERE ' . $db->sql_in_set('topic_id', array_unique($topic_ids));
					$result = $db->sql_query($sql);

					while ($row = $db->sql_fetchrow($result))
					{
						$topic_rows[$row['topic_id']] = $row;
					}
					$db->sql_freeresult($result);
				}
				unset($topic_ids);

				$template->assign_var('S_EDIT_DRAFT', $edit);

				$row_count = 0;
				foreach ($draftrows as $draft)
				{
					$link_topic = $link_forum = $link_pm = false;
					$insert_url = $view_url = $title = '';

					if (isset($topic_rows[$draft['topic_id']]) && acl_get('f_read', $topic_rows[$draft['topic_id']]['forum_id']))
					{
						$link_topic = true;
						$view_url = append_sid("{$phpbb_root_path}forum.$phpEx", 'action=viewtopic&amp;f=' . $topic_rows[$draft['topic_id']]['forum_id'] . '&amp;t=' . $draft['topic_id']);
						$title = $topic_rows[$draft['topic_id']]['topic_title'];

						$insert_url = append_sid("{$phpbb_root_path}forum.$phpEx", 'action=posting&amp;f=' . $topic_rows[$draft['topic_id']]['forum_id'] . '&amp;t=' . $draft['topic_id'] . '&amp;mode=reply&amp;d=' . $draft['draft_id']);
					}
					else if (!$pm_drafts AND acl_get('f_read', $draft['forum_id']))
					{
						$link_forum = true;
						$view_url = append_sid("{$phpbb_root_path}forum.$phpEx", 'action=viewforum&amp;f=' . $draft['forum_id']);
						$title = $draft['forum_name'];

						$insert_url = append_sid("{$phpbb_root_path}forum.$phpEx", 'action=posting&amp;f=' . $draft['forum_id'] . '&amp;mode=post&amp;d=' . $draft['draft_id']);
					}
					else if ($pm_drafts)
					{
						$link_pm = true;
						$insert_url = append_sid("{$siteurl}/pm.$phpEx", "op=send&amp;i=$id&amp;mode=edit&amp;d=" . $draft['draft_id']);
					}

					$template_row = array(
						'DATE'			=> $user->format_date($draft['save_time']),
						'DRAFT_MESSAGE'	=> ($submit) ? $draft_message : $draft['draft_message'],
						'DRAFT_SUBJECT'	=> ($submit) ? $draft_subject : $draft['draft_subject'],
						'TITLE'			=> $title,

						'DRAFT_ID'	=> $draft['draft_id'],
						'FORUM_ID'	=> $draft['forum_id'],
						'TOPIC_ID'	=> $draft['topic_id'],

						'U_VIEW'		=> $view_url,
						'U_VIEW_EDIT'	=> $u_action . '&amp;edit=' . $draft['draft_id'],
						'U_INSERT'		=> $insert_url,

						'S_LINK_TOPIC'		=> $link_topic,
						'S_LINK_FORUM'		=> $link_forum,
						'S_LINK_PM'			=> $link_pm,
						'S_HIDDEN_FIELDS'	=> $s_hidden_fields
					);
					$row_count++;

					($edit) ? $template->assign_vars($template_row) : $template->assign_block_vars('draftrow', $template_row);
				}

				if (!$edit)
				{
					$template->assign_var('S_DRAFT_ROWS', $row_count);
				}
        $sql = "SELECT B.slave, U.username, IF (U.name IS NULL, U.username, U.name) as name, U.can_do as can_do, U.lastlogin as laslogin, U.Show_online as show_online FROM ".$db_prefix."_private_messages_bookmarks B LEFT JOIN ".$db_prefix."_users U ON B.slave = U.id WHERE B.master = '".$user->id."' ORDER BY name ASC;";
        $res = $db->sql_query($sql) or btsqlerror($sql);
        if ($n = $db->sql_numrows($res)) {
                for ($i = 1; list($uid, $username, $user_name, $can_do, $laslogin, $show_online) = $db->fetch_array($res); $i++) {
		$which = (time() - 300 < sql_timestamp_to_unix_timestamp($laslogin) && ($show_online == 'true' || $user->admin)) ? 'online' : 'offline';

		$template->assign_block_vars("friends_{$which}", array(
			'USER_ID'		=> $uid,
			'USER_COLOUR'	=> getusercolor($can_do),
			'USERNAME'		=> $username,
			'USERNAME_FULL'	=> $user_name)
		);
                }
        }
        $db->sql_freeresult($res);
				get_folder($user->id);
echo $template->fetch('pm_drafts.html');
close_out();
?>