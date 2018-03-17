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
** File ucp_pms.php 2018-02-23 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT'))
{
	include_once './../../security.php';
	die ("You can't access this file directly");
}
$user->set_lang('admin/ucp_pms',$user->ulanguage);
include("admin/ucp_pm_functions.php");
$do				= request_var('do', '');
		switch ($do)
		{
			case	'havepms':
			{
				$totalpms				= request_var('totalpms', 0);
				// grab list of users that have PMs
				$havepms = rpm_get_pm_users($totalpms);
			
				// if there are no PMs
				if (!$db->sql_numrows($havepms))
				{
					$template->assign_vars(array(
						'S_USER_NOTICE'			=> false,
						'S_FORWARD'				=> false,
						'MESSAGE_TITLE'			=> $user->lang['ERROR'],
						'MESSAGE_TEXT'			=> $user->lang['ERROR_NO_PMS'],
					));
					echo $template->fetch('admin/message_body.html');
					close_out();
					die();
				}
			
				while($pms = $db->sql_fetchrow($havepms))
				{
					$template->assign_block_vars('listrow', array(
					'USERNAME'					=>	$pms['username'],
					'USER_ID'				=>	$pms['userid'],
					));
				}
				$template->assign_vars(array(
				'L_HAVE_PMS_HEADER'		=>	$user->lang['HAVE_PMS_HEADER'],
				'PM_COUNT'				=>	$totalpms,
				'ACTION'				=>	$do,
				));
				break;
			}
			case	'list':
			{
				$userid				= request_var('userid', '');
				// if no userid or username entered
				if (empty($userid))
				{
					$template->assign_vars(array(
						'S_USER_NOTICE'			=> false,
						'S_FORWARD'				=> false,
						'MESSAGE_TITLE'			=> $user->lang['ERROR'],
						'MESSAGE_TEXT'			=> $user->lang['ERROR_EMPTY_FEALD'],
					));
					echo $template->fetch('admin/message_body.html');
					close_out();
				}
				
				// if it is a username
				if (!is_numeric($userid))
				{
					// check the username exists and assign it
					$userid = rpm_username_exists($userid);
					
					// if username does not exist
					if (empty($userid))
					{
					$template->assign_vars(array(
						'S_USER_NOTICE'			=> false,
						'S_FORWARD'				=> false,
						'MESSAGE_TITLE'			=> $user->lang['ERROR'],
						'MESSAGE_TEXT'			=> sprintf($user->lang['ERROR_NO_SUCH_USER_NAME'],request_var('userid', '')),
					));
					echo $template->fetch('admin/message_body.html');
					close_out();
					}
				}
				else // if userid
				{
					// if userid does not exist
					if (!rpm_user_exists($userid))
					{
					$template->assign_vars(array(
						'S_USER_NOTICE'			=> false,
						'S_FORWARD'				=> false,
						'MESSAGE_TITLE'			=> $user->lang['ERROR'],
						'MESSAGE_TEXT'			=> sprintf($user->lang['ERROR_NO_SUCH_USER_ID'],$userid),
					));
					echo $template->fetch('admin/message_body.html');
					close_out();
					}
					
				}
				
				// get all PMs for the user
				$pms = rpm_get_pms($userid);
				
				// if there are no PMs
				if (empty($pms))
				{
					$template->assign_vars(array(
						'S_USER_NOTICE'			=> false,
						'S_FORWARD'				=> false,
						'MESSAGE_TITLE'			=> $user->lang['ERROR'],
						'MESSAGE_TEXT'			=> $user->lang['ERROR_NO_PMS'],
					));
					echo $template->fetch('admin/message_body.html');
					close_out();
				}
				
				// get the username
				$name = rpm_get_name($userid);
				
				// seperate sent and recieved PMs
				$sent = array();
				$received = array();
				foreach ($pms AS $pm)
				{
					// seperate sent and recieved PMs (also takes into account user sending to self via to or bcc)
					if ($pm['sender'] == $userid)
					{
						$sent[] = $pm;
					}
					else
					{
						$received[] = $pm;
					}
				}
				
				// display list of sent PMs
					foreach ($sent AS $pm)
					{
								$template->assign_block_vars('sent', array(
										'PM_ID'					=>	(int)$pm['id'],
										'RECP'					=>	rpm_get_name(str_replace('u_','',$pm['recipient'])),
										'DATE_SENT'				=>	$user->format_date(sql_timestamp_to_unix_timestamp($pm['sent'])),
										'SUBJECT'				=>	$pm['subject'],
								));
					}
				// display list of recieved PMs
					foreach ($received AS $pm)
					{
								$template->assign_block_vars('received', array(
										'PM_ID'					=>	(int)$pm['id'],
										'FROM'					=>	rpm_get_name($pm['sender']),
										'DATE_SENT'				=>	$user->format_date(sql_timestamp_to_unix_timestamp($pm['sent'])),
										'SUBJECT'				=>	$pm['subject'],
								));
					}
				$template->assign_vars(array(
					'USERNAME'					=>	$name,
					'USERID'					=>	$userid,
					'L_HEADER_RESEAVED_PMS'		=>	sprintf($user->lang['HEADER_RESEAVED_PMS'],count($received),$name),
					'L_HEADER_SENT_PMS'			=>	sprintf($user->lang['HEADER_SENT_PMS'],count($sent),$name),
					'ACTION'					=>	$do,
				));
				break;
			}
			case	'allusershavepms':
			{
				// get array of PM counts
				$pmcounts = rpm_get_all_pm_users();
				// assign the counts
				$pmtotals = array();
				while ($currentpmcount = $db->sql_fetchrow($pmcounts))
				{
					if($currentpmcount['recipient'] AND !preg_match('/\:u_/', $currentpmcount['recipient'], $matches))$pmtotals[$currentpmcount['total']]++;
				}
				// construct & display the rows
				foreach ($pmtotals AS $pmtotal => $totalusers)
				{
					$template->assign_block_vars('listrow', array(
					'TOTTAL_USERS'					=>	sprintf($user->lang['LIST_ROW_COUNT'],$totalusers,$pmtotal),
					'TOTTAL_PMS'					=>	$pmtotal,
					));
				}
				// seperate sent and recieved PMs
				$template->assign_vars(array(
				'ACTION'		=>	$do,
				));
				break;
			}
			case	'read':
			{
				$pmtextid				= request_var('pmtextid', 0);
				// no pmtextid
				if (!$pmtextid)
				{
					$template->assign_vars(array(
						'S_USER_NOTICE'			=> false,
						'S_FORWARD'				=> false,
						'MESSAGE_TITLE'			=> $user->lang['ERROR'],
						'MESSAGE_TEXT'			=> $user->lang['INVALID_ID'],
					));
					echo $template->fetch('admin/message_body.html');
					close_out();
				}
				
				
				// get the requested PM
				$pm = rpm_get_pm($pmtextid);
				
				// PM does not exist
				if (empty($pm))
				{
					$template->assign_vars(array(
						'S_USER_NOTICE'			=> false,
						'S_FORWARD'				=> false,
						'MESSAGE_TITLE'			=> $user->lang['ERROR'],
						'MESSAGE_TEXT'			=> sprintf($user->lang['ERROR_NO_SUCH_USER_ID'],$pmtextid),
					));
					echo $template->fetch('admin/message_body.html');
					close_out();
				}
				
				// get all userids for the users that still have the PM with pmtextid
				$userids = $db->sql_fetchrow($db->sql_query("
					SELECT DISTINCT `sender`
					FROM `".$db_prefix."_private_messages`
					WHERE `id` = " . $pmtextid . "
				"));
				
				// If there are no userids then the PM does not exist (this handles the last x PMs)
				if (empty($userids))
				{
					$template->assign_vars(array(
						'S_USER_NOTICE'			=> false,
						'S_FORWARD'				=> false,
						'MESSAGE_TITLE'			=> $user->lang['ERROR'],
						'MESSAGE_TEXT'			=> sprintf($user->lang['ERROR_NO_SUCH_USER_ID'],$pmtextid),
					));
					echo $template->fetch('admin/message_body.html');
					close_out();
				}
							
				// convert date to readable format
				$date = $pm['sent'];
				
				// Instantiate BBCode if need be
				include_once('include/function_posting.' . $phpEx);
				include_once('include/functions_forum.' . $phpEx);
				include_once('include/user.functions.' . $phpEx);
				require_once("include/class.bbcode.php");
				if ($pm['bbcode_bitfield'])
				{
					include_once('include/bbcode.' . $phpEx);
					$bbcode = new bbcode($pm['bbcode_bitfield']);
				}
				$message = censor_text($pm['text']);
			
				// Second parse bbcode here
				if ($pm['bbcode_bitfield'])
				{
					$bbcode->bbcode_second_pass($message, $pm['bbcode_uid'], $pm['bbcode_bitfield']);
				}
				if ($pm['message_attachment'])
				{
					if (checkaccess('u_pm_download'))
					{
						$sql = 'SELECT *
							FROM ' . $db_prefix . "_attachments
							WHERE post_msg_id = $pmtextid
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
								WHERE msg_id = $pmtextid";
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
			//die($pm['autgroup_name']);
				$template->assign_vars(array(
				'DATE_SENT'					=>	$user->format_date(sql_timestamp_to_unix_timestamp($pm['sent'])),
				'FROM'						=>	$pm['autusername'],
				'SUBJECT'					=>	$pm['subject'],
				'MESSAGE_AUTHOR_FULL'		=> get_username_string('full', $pm['sender'], $pm['autusername'], '#'.$pm['aut_colour'], $pm['autusername']),//$user_info['username'],
				'MESSAGE_AUTHOR_COLOUR'		=> get_username_string('colour', $pm['sender'], $pm['autusername'], '#'.$pm['aut_colour'], $pm['autusername']),//getusercolor($user_info['can_do']),
				'MESSAGE_AUTHOR'			=> get_username_string('username', $pm['sender'], $pm['autusername'], '#'.$pm['aut_colour'], $pm['autusername']),//$user_info['username'],
				'U_MESSAGE_AUTHOR'			=> get_username_string('profile', $pm['sender'], $pm['autusername'], '#'.$pm['aut_colour'], $pm['autusername']),//$user_info['username'],
				'MESSAGE_RESIP_FULL'		=> get_username_string('full', $pm['recipient'], $pm['recusername'], '#'.$pm['rec_colour'], $pm['recusername']),//$user_info['username'],
				'MESSAGE_RESIP_COLOUR'		=> get_username_string('colour', $pm['recipient'], $pm['recusername'], '#'.$pm['rec_colour'], $pm['recusername']),//getusercolor($user_info['can_do']),
				'MESSAGE_RESIP'				=> get_username_string('username', $pm['recipient'], $pm['recusername'], '#'.$pm['rec_colour'], $pm['recusername']),//$user_info['username'],
				'U_MESSAGE_RESIP'			=> get_username_string('profile', $pm['recipient'], $pm['recusername'], '#'.$pm['rec_colour'], $pm['recusername']),//$user_info['username'],
				'TEXT'						=>	$message,
				'ACTION'					=>	$do,
				));
				break;
			}
			case	'search':
			{
				$search				= request_var('search', '');
				include_once('include/user.functions.' . $phpEx);
				// if no search terms have been entered
				if (empty($search))
				{
		                                $template->assign_vars(array(
										'S_ERROR'					=> true,
								        'S_USER_NOTICE'				=> false,
								        'MESSAGE_TITLE'				=> $user->lang['BT_ERROR'],
                                        'MESSAGE_TEXT'  			=> $user->lang['ERROR_MUST_ONE_WORD'].back_link($siteurl . '/admin.php?i=userinfo&op=ucp_pms#ucp_pms'),
                                ));
					echo $template->fetch('admin/message_body.html');
					close_out();
				}
				// assign and make search terms safe
				$search_for = $search;
				
				// see if any of the search terms is lower than the minimum length 
				$words = explode(" ", $search_for);
				foreach ($words as $current)
				{
					if (strlen($current) < 4)
					{
		                                $template->assign_vars(array(
										'S_ERROR'					=> true,
								        'S_USER_NOTICE'				=> false,
								        'MESSAGE_TITLE'				=> $user->lang['BT_ERROR'],
                                        'MESSAGE_TEXT'  			=> $user->lang['ERROR_MUST_FOUR_LETTERS'] . back_link($siteurl . '/admin.php?i=userinfo&op=ucp_pms#ucp_pms'),
                                ));
					echo $template->fetch('admin/message_body.html');
					close_out();
					}
				}
				
				// assign the type of match
				$match = request_var('match', '');
				
				// conduct the search
				$pms = rpm_search_pms($search_for, $match);
				
				// format search words for display purposes
				switch ($match)
				{
					case 'exact':
						$search_words = str_replace(" ", " + ", $search_for);
						$search_wording = 'the exact text';
						break;
			
					case 'all':
						$search_words = str_replace(" ", " and ", $search_for);
						$search_wording = 'all of the following words';
						break;
			
					case 'atleastone':
						$search_words = str_replace(" ", " or ", $search_for);
						$search_wording = 'at least one of the following words';
						break;
				}
			
				// display list of PMs found
					foreach ($pms AS $pm)
					{
								$template->assign_block_vars('search', array(
										'PM_ID'						=>	(int)$pm['id'],
										'FROM'						=>	$pm['autusername'],
										'TO'						=>	$pm['recusername'],
										'MESSAGE_AUTHOR_FULL'		=> get_username_string('full', $pm['sender'], $pm['autusername'], '#'.$pm['aut_colour'], $pm['autusername']),//$user_info['username'],
										'MESSAGE_AUTHOR_COLOUR'		=> get_username_string('colour', $pm['sender'], $pm['autusername'], '#'.$pm['aut_colour'], $pm['autusername']),//getusercolor($user_info['can_do']),
										'MESSAGE_AUTHOR'			=> get_username_string('username', $pm['sender'], $pm['autusername'], '#'.$pm['aut_colour'], $pm['autusername']),//$user_info['username'],
										'U_MESSAGE_AUTHOR'			=> get_username_string('profile', $pm['sender'], $pm['autusername'], '#'.$pm['aut_colour'], $pm['autusername']),//$user_info['username'],
										'MESSAGE_RESIP_FULL'		=> get_username_string('full', $pm['recipient'], $pm['recusername'], '#'.$pm['rec_colour'], $pm['recusername']),//$user_info['username'],
										'MESSAGE_RESIP_COLOUR'		=> get_username_string('colour', $pm['recipient'], $pm['recusername'], '#'.$pm['rec_colour'], $pm['recusername']),//getusercolor($user_info['can_do']),
										'MESSAGE_RESIP'				=> get_username_string('username', $pm['recipient'], $pm['recusername'], '#'.$pm['rec_colour'], $pm['recusername']),//$user_info['username'],
										'U_MESSAGE_RESIP'			=> get_username_string('profile', $pm['recipient'], $pm['recusername'], '#'.$pm['rec_colour'], $pm['recusername']),//$user_info['username'],
										'DATE_SENT'					=>	$user->format_date(sql_timestamp_to_unix_timestamp($pm['sent'])),
										'SUBJECT'					=>	$pm['subject'],
								));
					}
				$template->assign_vars(array(
				'SEARCH_WORD'			=>	$search_words,
				'SEARCH_MATCH'			=>	$search_wording,
				'ACTION'				=>	$do,
				));
				break;
				
			}
			case	'latest':
			{
				include_once('include/user.functions.' . $phpEx);
				$showlatest = request_var('showlatest', 0);
				// if nothing entered or zero entered
				if (!$showlatest)
				{
					$template->assign_vars(array(
						'S_USER_NOTICE'			=> false,
						'S_FORWARD'				=> false,
						'MESSAGE_TITLE'			=> $user->lang['ERROR'],
						'MESSAGE_TEXT'			=> $user->lang['ERROR_LATEST_NUM'],
					));
					echo $template->fetch('admin/message_body.html');
					close_out();
				}
				
				// get the PM list
				$pms = rpm_get_latest_pms($showlatest);
				// if no PMs
				if (empty($pms))
				{
					$template->assign_vars(array(
						'S_USER_NOTICE'			=> false,
						'S_FORWARD'				=> false,
						'MESSAGE_TITLE'			=> $user->lang['ERROR'],
						'MESSAGE_TEXT'			=> $user->lang['ERROR_NO_PMS'],
					));
					echo $template->fetch('admin/message_body.html');
					close_out();
				}
				
				foreach ($pms AS $pm)
				{
											$template->assign_block_vars('search', array(
													'PM_ID'						=>	(int)$pm['id'],
													'FROM'						=>	$pm['autusername'],
													'TO'						=>	$pm['recusername'],
													'MESSAGE_AUTHOR_FULL'		=> get_username_string('full', $pm['sender'], $pm['autusername'], '#'.$pm['aut_colour'], $pm['autusername']),//$user_info['username'],
													'MESSAGE_AUTHOR_COLOUR'		=> get_username_string('colour', $pm['sender'], $pm['autusername'], '#'.$pm['aut_colour'], $pm['autusername']),//getusercolor($user_info['can_do']),
													'MESSAGE_AUTHOR'			=> get_username_string('username', $pm['sender'], $pm['autusername'], '#'.$pm['aut_colour'], $pm['autusername']),//$user_info['username'],
													'U_MESSAGE_AUTHOR'			=> get_username_string('profile', $pm['sender'], $pm['autusername'], '#'.$pm['aut_colour'], $pm['autusername']),//$user_info['username'],
													'MESSAGE_RESIP_FULL'		=> get_username_string('full', $pm['recipient'], $pm['recusername'], '#'.$pm['rec_colour'], $pm['recusername']),//$user_info['username'],
													'MESSAGE_RESIP_COLOUR'		=> get_username_string('colour', $pm['recipient'], $pm['recusername'], '#'.$pm['rec_colour'], $pm['recusername']),//getusercolor($user_info['can_do']),
													'MESSAGE_RESIP'				=> get_username_string('username', $pm['recipient'], $pm['recusername'], '#'.$pm['rec_colour'], $pm['recusername']),//$user_info['username'],
													'U_MESSAGE_RESIP'			=> get_username_string('profile', $pm['recipient'], $pm['recusername'], '#'.$pm['rec_colour'], $pm['recusername']),//$user_info['username'],
													'DATE_SENT'					=>	$user->format_date(sql_timestamp_to_unix_timestamp($pm['sent'])),
													'SUBJECT'					=>	$pm['subject'],
											));
				}
				$template->assign_vars(array(
				'HEADER'		=>	sprintf($user->lang['LATEST_HEADER'],$showlatest),
				'ACTION'		=>	$do,
				));
				break;
			}
        	default:
			{
				$template->assign_vars(array(
				'ACTION'		=>	'front',
				));
				break;
			}
		}
echo $template->fetch('admin/ucp_pms.html');
		close_out();
?>