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
** File readmsg.php 2018-02-18 14:32:00 joeroberts
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
$folder_specified = request_var('i', 0);
$mode = 'readmsg';
$mid = request_var('p', 0);
$msg_id = $mid;
include_once('include/ucp/ucp_pm_viewmessage.php');
require_once("include/ucp/functions_privmsgs.php");
require_once("include/class.bbcode.php");
require_once("include/constants.php");
$user->set_lang('pm',$user->ulanguage);
require_once("include/ucp/functions_privmsgs.php");
require_once("include/class.bbcode.php");
if (!isset($mid)) bterror($user->lang['INVALID_ID'],$user->lang['BT_ERROR']);
$template->assign_vars(array(
        'ERROR_MESSAGE'         => false,
		'PMBT_LINK_BACK'		=> 'pm.php?',
        'S_UCP_ACTION'          => 'pm.php?op=inbox',
));
$mode = 'inbox';
$folder_specified = request_var('i', '0');
$id 	= request_var('i', '');
				//set_user_message_limit();

				if ($folder_specified)
				{
					$folder_id = $folder_specified;
					$action = 'view_folder';
				}
				else
				{
					$folder_id = request_var('f', '-3');
					$action = request_var('action', 'view_folder');
				}

				$msg_id = request_var('p', 0);
				$view	= request_var('view', '');

				// View message if specified
				if ($msg_id)
				{
					$action = 'view_message';
				}


				// Do not allow hold messages to be seen
				if ($folder_id == '-4')
				{
					trigger_error('NO_AUTH_READ_HOLD_MESSAGE');
				}


				// First Handle Mark actions and moving messages
				$submit_mark	= (isset($_POST['submit_mark'])) ? true : false;
				$move_pm		= (isset($_POST['move_pm'])) ? true : false;
				$mark_option	= request_var('mark_option', '');
				$dest_folder	= request_var('dest_folder', '-3');

				// Is moving PM triggered through mark options?
				if (!in_array($mark_option, array('mark_important', 'delete_marked')) && $submit_mark)
				{
					$move_pm = true;
					$dest_folder = (int) $mark_option;
					$submit_mark = false;
				}

				// Move PM
				if ($move_pm)
				{
					$move_msg_ids	= (isset($_POST['marked_msg_id'])) ? request_var('marked_msg_id', array(0)) : array();
					$cur_folder_id	= request_var('cur_folder_id', '-3');

					if (move_pm($user->id, $user->data['message_limit'], $move_msg_ids, $dest_folder, $cur_folder_id))
					{
						// Return to folder view if single message moved
						if ($action == 'view_message')
						{
							$msg_id		= 0;
							$folder_id	= request_var('cur_folder_id', '-3');
							$action		= 'view_folder';
						}
					}
				}

				// Message Mark Options
				if ($submit_mark)
				{
					handle_mark_actions($user->id, $mark_option);
				}

				// If new messages arrived, place them into the appropriate folder
				$num_not_moved = $num_removed = 0;
				$release = request_var('release', 0);

				if ($user->unread_pm && $action == 'view_folder')
				{
					$return = place_pm_into_folder($global_privmsgs_rules, $release);
					$num_not_moved = $return['not_moved'];
					$num_removed = $return['removed'];
				}

				if (!$msg_id && $folder_id == '-3')
				{
					$folder_id = PRIVMSGS_INBOX;
				}
				else if ($msg_id && $folder_id == '-3')
				{
					$sql = 'SELECT folder_id
						FROM ' . $db_prefix . "_privmsgs_to
						WHERE msg_id = $msg_id
							AND folder_id <> " . '-3' . '
							AND user_id = ' . $user->id;
					$result = $db->sql_query($sql);
					$row = $db->sql_fetchrow($result);
					$db->sql_freeresult($result);

					if (!$row)
					{
						trigger_error('NO_MESSAGE');
					}
					$folder_id = (int) $row['folder_id'];
				}

				$message_row = array();
				if ($action == 'view_message' && $msg_id)
				{
					// Get Message user want to see
					if ($view == 'next' || $view == 'previous')
					{
						$sql_condition = ($view == 'next') ? '>' : '<';
						$sql_ordering = ($view == 'next') ? 'ASC' : 'DESC';

						$sql = 'SELECT t.msg_id
							FROM ' . $db_prefix . '_privmsgs_to t, ' . $db_prefix . '_private_messages p, ' . $db_prefix . "_private_messages p2
							WHERE p2.id = $msg_id
								AND t.folder_id = $folder_id
								AND t.user_id = " . $user->id . "
								AND t.msg_id = p.msg_id
								AND p.sent $sql_condition p2.sent
							ORDER BY p.sent $sql_ordering LIMIT 1";
						$result = $db->sql_query($sql);
						$row = $db->sql_fetchrow($result);
						$db->sql_freeresult($result);

						if (!$row)
						{
							$message = ($view == 'next') ? 'NO_NEWER_PM' : 'NO_OLDER_PM';
							trigger_error($message);
						}
						else
						{
							$msg_id = $row['msg_id'];
						}
					}

					$sql = 'SELECT t.*, u.*, p.*
						FROM ' . $db_prefix . '_privmsgs_to t, ' . $db_prefix . '_private_messages p, ' . $db_prefix . '_users  u
						WHERE t.user_id = ' . $user->id . "
							AND p.sender = u.id
							AND t.folder_id = $folder_id
							AND t.msg_id = p.id
							AND p.id = $msg_id";
					$result = $db->sql_query($sql);
					$message_row = $db->sql_fetchrow($result);
					$db->sql_freeresult($result);

					if (!$message_row)
					{
						trigger_error('NO_MESSAGE');
					}

					//echo' Update unread status';
					update_unread_status($message_row['pm_unread'], $message_row['msg_id'], $user->id, $folder_id);
				}

				$folder = get_folder($user->id, $folder_id);

				$s_folder_options = $s_to_folder_options = '';
				foreach ($folder as $f_id => $folder_ary)
				{
					$option = '<option' . ((!in_array($f_id, array(PRIVMSGS_INBOX, '-2', '-1'))) ? ' class="sep"' : '') . ' value="' . $f_id . '"' . (($f_id == $folder_id) ? ' selected="selected"' : '') . '>' . $folder_ary['folder_name'] . (($folder_ary['unread_messages']) ? ' [' . $folder_ary['unread_messages'] . '] ' : '') . '</option>';

					$s_to_folder_options .= ($f_id != '-2' && $f_id != '-1') ? $option : '';
					$s_folder_options .= $option;
				}
				clean_sentbox($folder['-1']['num_messages']);

				// Header for message view - folder and so on
				$folder_status = get_folder_status($folder_id, $folder);

				$template->assign_vars(array(
					'CUR_FOLDER_ID'			=> $folder_id,
					'CUR_FOLDER_NAME'		=> $folder_status['folder_name'],
					'NUM_NOT_MOVED'			=> $num_not_moved,
					'NUM_REMOVED'			=> $num_removed,
					'RELEASE_MESSAGE_INFO'	=> sprintf($user->lang['_RELEASE_MESSAGES'], '<a href="' . $u_action . '&amp;folder=' . $folder_id . '&amp;release=1">', '</a>'),
					'NOT_MOVED_MESSAGES'	=> ($num_not_moved == 1) ? $user->lang['_NOT_MOVED_MESSAGE'] : sprintf($user->lang['_NOT_MOVED_MESSAGES'], $num_not_moved),
					'RULE_REMOVED_MESSAGES'	=> ($num_removed == 1) ? $user->lang['_RULE_REMOVED_MESSAGE'] : sprintf($user->lang['_RULE_REMOVED_MESSAGES'], $num_removed),

					'S_FOLDER_OPTIONS'		=> $s_folder_options,
					'S_TO_FOLDER_OPTIONS'	=> $s_to_folder_options,
					'S_FOLDER_ACTION'		=> $u_action . '&amp;action=view_folder',
					'S_PM_ACTION'			=> $u_action . '&amp;action=' . $action,

					'U_INBOX'				=> $u_action . '&amp;folder=inbox',
					'U_OUTBOX'				=> $u_action . '&amp;folder=outbox',
					'U_SENTBOX'				=> $u_action . '&amp;folder=sentbox',
					'U_CREATE_FOLDER'		=> $u_action . '&amp;mode=options',
					'U_CURRENT_FOLDER'		=> $u_action . '&amp;folder=' . $folder_id,

					'S_IN_INBOX'			=> ($folder_id == PRIVMSGS_INBOX) ? true : false,
					'S_IN_OUTBOX'			=> ($folder_id == '-2') ? true : false,
					'S_IN_SENTBOX'			=> ($folder_id == '-1') ? true : false,

					'FOLDER_STATUS'				=> $folder_status['message'],
					'FOLDER_MAX_MESSAGES'		=> $folder_status['max'],
					'FOLDER_CUR_MESSAGES'		=> $folder_status['cur'],
					'FOLDER_REMAINING_MESSAGES'	=> $folder_status['remaining'],
					'FOLDER_PERCENT'			=> $folder_status['percent'])
				);
				//die(print_r($folder_id));
				view_message($id, $mode, $folder_id, $msg_id, $folder, $message_row);
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
echo $template->fetch('ucp_pm_viewmessage.html');
close_out();
?>