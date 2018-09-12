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
** File staffmess.php 2018-02-23 14:32:00 Black_Heart
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
$user->set_lang('admin/acp_staffmess',$user->ulanguage);
		$page			= request_var('page', 'index');
		$action		= request_var('action', 'main');
							$template->assign_block_vars('l_block1.l_block2',array(
							'L_TITLE'		=> $user->lang['BLOCK_TITLE'],
							'S_SELECTED'	=> true,
							'U_TITLE'		=> $u_action,));
							$template->assign_block_vars('l_block1.l_block2.l_block3',array(
							'S_SELECTED'	=> ('sendpm' ==$page)? true:false,
							'IMG' => '',
							'L_TITLE' => $user->lang['SECTION_TITLE_SENPM'],
							'U_TITLE' => append_sid($u_action,'page=sendpm'),
							));
							$template->assign_block_vars('l_block1.l_block2.l_block3',array(
							'S_SELECTED'	=> ('sendmail' ==$page)? true:false,
							'IMG' => '',
							'L_TITLE' => $user->lang['SECTION_TITLE_SENEMAIL'],
							'U_TITLE' => append_sid($u_action,'page=sendmail'),
							));
if($page=="pm"){
		include_once('include/function_posting.php');
		include_once('include/message_parser.php');
		include_once('include/class.bbcode.php');
		include_once('include/ucp/functions_privmsgs.php');
		require_once("include/constants.php");
		$subject			= request_var('subject', '',true);
		$sender				= request_var('sender', '');
		$message			= request_var('message', '', true);
		$level				= request_var('level', array('a'));
		$group				= request_var('group', array('0'));
		$icon_id			= request_var('icon', 0);
		$errmsg 			= array();
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
		if (!isset($message_parser->message) OR empty($message_parser->message)) $errmsg[] = $user->lang['ERR_NO_BODY'];
		if (!isset($subject) OR empty($subject)) $errmsg[] = $user->lang['ERR_NO_SUB'];
		if(sizeof($group))$groupuser = "WHERE can_do IN ('".implode( "', '",$group)."') " . ((sizeof($level))? 'AND ' : "");
		else
		$groupuser = "WHERE ";
		if(sizeof($level))$leveluser = $groupuser . "level IN ('".implode( "', '",$level)."') ";
		else
		$leveluser = $groupuser . "";
		$message_attachment = 0;
		if(!sizeof($group) AND !sizeof($level)) $leveluser = '';

		$sql="SELECT id FROM ".$db_prefix."_users ".$leveluser.";";
		$res = $db->sql_query($sql) or btsqlerror($sql);
		while ($result = $db->sql_fetchrow($res)) {
			$address_list['u'][$result['id']] = 'to';

		}
		if($preview)
		{
			$text = $message_parser->message;
					if ($message_parser->bbcode_bitfield)
					{
						include_once('include/bbcode.' . $phpEx);
						$bbcode = new bbcode($message_parser->bbcode_bitfield);
						$bbcode->bbcode_second_pass($text, $message_parser->bbcode_uid, $message_parser->bbcode_bitfield);
					}
					// Parse the message and subject
					$text = bbcode_nl2br($text);
			
				$template->assign_vars(array(
					'S_USER_NOTICE'			=> true,
					'S_FORWARD'				=> false,
					'MESSAGE_TITLE'			=> $subject,
					'MESSAGE_TEXT'			=> $text . '<br /><a href="#" onclick="history.go(-1);return false;">[' . $user->lang['GO_BACK'] . ']</a>',
				));
				echo $template->fetch('admin/message_body.html');
				close_out();
		}
		if ($submit)
		{
			if ($subject === '')
			{
				$errmsg[] = $user->lang['ERR_NO_SUB'];
			}

			if (!sizeof($address_list))
			{
				$errmsg[] = $user->lang['ERR_NO_RECIP'];
			}
		}
		if (count($errmsg) > 0){
				$template->assign_vars(array(
					'S_USER_NOTICE'			=> false,
					'S_FORWARD'				=> false,
					'MESSAGE_TITLE'			=> $user->lang['GEN_ERROR'],
					'MESSAGE_TEXT'			=> $user->lang['MESS_NOT_SENT'] . '<br />' . implode("<br />",$errmsg).'<br /><a href="#" onclick="history.go(-1);return false;">[' . $user->lang['GO_BACK'] . ']</a>',
				));
				echo $template->fetch('admin/message_body.html');
				close_out();
		 }
			$pm_data = array(
				'msg_id'				=> (int) $msg_id,
				'from_user_id'			=> 0,
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
			submit_pm('post', $subject, $pm_data);
				$template->assign_vars(array(
					'S_USER_NOTICE'			=> true,
					'S_FORWARD'				=> false,
					'MESSAGE_TITLE'			=> $user->lang['SUCCESS'],
					'MESSAGE_TEXT'			=> $user->lang['MESS_SENT'] . '<br /><a href="#" onclick="history.go(-1);return false;">[' . $user->lang['GO_BACK'] . ']</a>' . back_link(append_sid($u_action,'page=sendpm')),
				));
				add_log('admin','LOG_MASS_PM',$user->name);
				echo $template->fetch('admin/message_body.html');
				close_out();

}
if ($page == "mail")
{
		$group				= request_var('group', array('a'));
		$level				= request_var('level', array('a'));
		$test				= request_var('test', '');
		$bypass				= request_var('bypass', '');
		$subject			= request_var('subject', '',true);
		$message			= request_var('message', '',true);
		$errmsg = array();
	if(sizeof($group))$groupuser = "can_do IN ('".implode( "', '",$group)."') AND ";
	else
	$groupuser = "";
	if(sizeof($level))$leveluser = "level IN ('".implode( "', '",$level)."') AND ";
	else
	$leveluser = "";
	if($bypass != '1')$massscip = "AND mass_mail = 'yes'";
	else
	$massscip = "";
	$res = "SELECT id, username, email, language, mass_mail, jabber, user_notify_type FROM ".$db_prefix."_users WHERE " . $groupuser . "" . $leveluser . "ban = 0 AND active = 1 " . $massscip . " ;" or btsqlerror($res);
	//die($res);
	$e_mail = $db->sql_query($res)or btsqlerror($res);
	$from_email = $admin_email; //site email
	if ($subject == "") $subject = $sitename;
		include_once($phpbb_root_path . 'include/function_messenger.php');
	$subject = substr(trim($subject), 0, 80);
	if (!isset($message) OR empty($message)) $errmsg[] = $user->lang['ERR_NO_BODY'];
	if (count($errmsg) > 0)
	{
				$template->assign_vars(array(
					'S_USER_NOTICE'			=> false,
					'S_FORWARD'				=> false,
					'MESSAGE_TITLE'			=> $user->lang['GEN_ERROR'],
					'MESSAGE_TEXT'			=> $user->lang['MESS_NOT_SENT'] . '<br />' . implode("<br />",$errmsg).'<br /><a href="#" onclick="history.go(-1);return false;">[' . $user->lang['GO_BACK'] . ']</a>',
				));
				echo $template->fetch('admin/message_body.html');
				close_out();
	}
	$usermissed = false;
	while($arr=$db->sql_fetchrow($e_mail))
	{
		$messenger = new messenger();
		$messenger->template('staffmess', $user->ulanguage);
		$messenger->to($arr['email'], $arr['username']);
		$messenger->im($arr['jabber'], $arr['username']);
		$messenger->assign_vars(array(
			'SENDER'				=>	$sitename,
			'SEND_DATE'				=>	gmdate("Y-m-d H:i:s"),
			'STAFF_MESSAGE'			=>	$message,
			'SUB_JECT'				=>	$subject,
		));
		$messenger->send(0);
	}
	$messenger->save_queue();


if (!$usermissed){
				$template->assign_vars(array(
					'S_USER_NOTICE'			=> true,
					'S_FORWARD'				=> false,
					'MESSAGE_TITLE'			=> $user->lang['SUCCESS'],
					'MESSAGE_TEXT'			=> $user->lang['MESS_SENT'] . '<br /><a href="#" onclick="history.go(-1);return false;">[' . $user->lang['GO_BACK'] . ']</a>' . back_link(append_sid($u_action,'page=sendmail')),
				));
				add_log('admin','LOG_MASS_EMAIL',$user->name);
				echo $template->fetch('admin/message_body.html');
				close_out();
}else{
				$template->assign_vars(array(
					'S_USER_NOTICE'			=> false,
					'S_FORWARD'				=> false,
					'MESSAGE_TITLE'			=> $user->lang['GEN_ERROR'],
					'MESSAGE_TEXT'			=> $user->lang['MESS_NOT_SENT'].'<br /><a href="#" onclick="history.go(-1);return false;">[' . $user->lang['GO_BACK'] . ']</a>',
				));
				echo $template->fetch('admin/message_body.html');
				close_out();
}
}

if($page=="sendpm"){
require_once("include/class.bbcode.php");
		include_once('include/function_posting.php');
	generate_smilies('inline', 0);
	$num_predefined_bbcodes = 22;
	$s_pm_icons = false;
	if (!isset($icon_id))
	{
		$icon_id = false;
	}
	if ($config['enable_pm_icons'])
	{
		$s_pm_icons = posting_gen_topic_icons('post', $icon_id);
	}

	$sql = 'SELECT bbcode_id, bbcode_tag, bbcode_helpline
		FROM '.$db_prefix.'_bbcodes
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
	$sql = 'SELECT level, name,group_id FROM `' . $db_prefix . '_levels` WHERE `group_id` <> 6 ';
	$result = $db->sql_query($sql); 
	$s_group_options = '';
	while ($row = $db->sql_fetchrow($result))
	{
		$template->assign_block_vars('groups', array(
		'OPTION'				=> $row['level'],
		'VAL'					=> $row['name'],
		'ID'					=> $row['group_id'],
		));
		$s_group_options .= '<input tabindex="1" name="group[]" id="group[]_' . $row['level'] . '" value="' . $row['level'] . '" type="checkbox">' . $row['name'] . "\n";
	}
	$db->sql_freeresult($result);
                                $template->assign_vars(array(
									'L_TITLE'					=> $user->lang['MASS_PM_SYS'],
									'L_TITLE_EXPLAIN'			=> $user->lang['MASS_PM_SYS_EXP'],
									'S_ADD_GROUP_OPTIONS'		=> $s_group_options,
									'L_MESSAGE_BODY_EXPLAIN'	=> (intval($config['max_post_chars'])) ? sprintf($user->lang['MESSAGE_BODY_EXPLAIN'], intval($config['max_post_chars'])) : '',
									'ACTION'					=> 'pm',
									'S_POST_ACTION'				=> append_sid($u_action,'page=pm'),
									'S_SHOW_PM_ICONS'			=> true,
									'icon_id'					=> (int) $icon_id,
									'S_SMILIES_ALLOWED'			=> true,
									'S_SHOW_SMILEY_LINK'		=> true,
									'S_BBCODE_ALLOWED'			=> true,
									'T_TEMPLATE_PATH' 			=> 'themes/' . $theme . '/templates',
									'S_BBCODE_QUOTE'			=> true,
									'S_BBCODE_IMG'				=> true,
									'S_LINKS_ALLOWED'				=> true,
									'S_BBCODE_FLASH'				=> true,
									'S_BBCODE_IMG'				=> true,
								));
	echo $template->fetch('admin/staffmess.html');
	close_out();
}

if($page=="sendmail"){
	$sql = 'SELECT name, group_id FROM `' . $db_prefix . '_levels` WHERE `group_id` <> 6 ';
	$result = $db->sql_query($sql); 
	$s_group_options = '';
	while ($row = $db->sql_fetchrow($result))
	{
		$template->assign_block_vars('groups', array(
		'OPTION'				=> $row['group_id'],
		'VAL'					=> $row['name'],
		));
		$s_group_options .= '<input tabindex="1" name="user[usergroupid][]" id="user[usergroupid]7_7" value="' . $row['level'] . '" type="checkbox">' . $row['name'] . "\n";
	}
	$db->sql_freeresult($result);
                                $template->assign_vars(array(
									'L_TITLE'					=> $user->lang['MASS_MAIL'],
									'L_TITLE_EXPLAIN'			=> $user->lang['MASS_MAIL_EXP'],
									'S_ADD_GROUP_OPTIONS'		=> $s_group_options,
									'ACTION'					=> 'email',
									'U_ACTION'					=> append_sid($u_action,'page=mail'),
								));

}
                                $template->assign_vars(array(
									'L_TITLE'					=> $user->lang['MAIN_TEXT'],
									'L_TITLE_EXPLAIN'			=> $user->lang['MAIN_INTRO_EXP'],
									'U_LINK_MAIL'				=> append_sid($u_action,'page=sendmail'),
									'U_LINK_PM'					=> append_sid($u_action,'page=sendpm'),
								));
	echo $template->fetch('admin/staffmess.html');
	close_out();
?>