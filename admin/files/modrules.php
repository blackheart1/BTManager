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
** File modrules.php 2018-02-23 14:32:00 Black_Heart
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
$user->set_lang('admin/acp_modrules',$user->ulanguage);
//DELETE RULE SECTION PAGE/FORM
$id = (int)request_var('id', '0');
$act = request_var('act', '');
if ($act == "delete")
{
	$id = (int)request_var('delete', '0');
	$sql_rule = "select `title` from ".$db_prefix."_rules where id=$id;";
	$sql = $db->sql_query($sql_rule);
	$row = $db->sql_fetchrow($sql);
	if(!isset($row['title']))
	{
		trigger_error($user->lang['NO_RULE'] . '<br /><br /><a href="javascript:history.go(-1)"  onMouseOver="self.status=document.referrer;return true">' . $user->lang['GO_BACK'] . '</a>');
	}

		if (confirm_box(true))
		{
			$sql = "DELETE FROM ".$db_prefix."_rules WHERE id = $id ";
			if (!$db->sql_query($sql)) btsqlerror($sql);
						add_log('admin','RULE_REMOVED',$row['title']);
                                $template->assign_vars(array(
								        'S_USER_NOTICE'				=> true,
										'S_FORWARD'					=> $u_action,
								        'MESSAGE_TITLE'          	=> $user->lang['SUCCESS'],
                                        'MESSAGE_TEXT'           	=> $user->lang['DELETE_SUCCESS'],
                                ));
		echo $template->fetch('admin/message_body.html');
		close_out();
		}
		else
		{
								$hidden = build_hidden_fields(array(
								"act"			=>	$act,
								"delete"		=>	$id,
								'i'				=>	'staff',
								'op'			=>	'modrules'
								));
		confirm_box(false, $user->lang['CONFIRM_DELETE_RULE'], $hidden,'admin/confirm_body.html','admin.php');
		}
				//header("Refresh: 0; url=modrules.php");
}				

//ADD NEW RULE SECTION PAGE/FORM
elseif ($act == "newsect")
{
					
					include_once('include/function_posting.php');
					include_once('include/message_parser.php');
					include_once('include/class.bbcode.php');
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
						'BBCODE_TAG'		=> str_replace('=', '', $row['bbcode_tag']),
						'BBCODE_HELPLINE'	=> $row['bbcode_helpline'],
						'A_BBCODE_HELPLINE'	=> str_replace(array('&amp;', '&quot;', "'", '&lt;', '&gt;'), array('&', '"', "\'", '<', '>'), $row['bbcode_helpline']),
					));
			
					$i++;
				}
				$db->sql_freeresult($result);
					$hidden = build_hidden_fields(array(
								"act"			=>	'addsect',
								'i'				=>	'staff',
								'op'			=>	'modrules'
								));
			$template->assign_vars(array(
					'U_ACTION'				=>	'admin.php',
					'HIDEN'				=>	$hidden,
					'POS'					=>	'newsect',
					'GROUPS_LEVEL'				=>	group_select_options_id(false),
					'S_BBCODE_QUOTE'			=> checkaccess("u_add_quote_details"),
					'S_BBCODE_IMG'				=> checkaccess("u_add_imgbbcode_details"),
					'S_LINKS_ALLOWED'			=> checkaccess("u_links_in_details"),
					'S_BBCODE_FLASH'			=> checkaccess("u_flash_in_details"),
					'S_BBCODE_ALLOWED'			=>	true,
					'S_SMILIES_ALLOWED'			=>	true,
					'S_SHOW_SMILEY_LINK'		=>	true,
					'T_TEMPLATE_PATH'			=> 'themes/' . $theme . '/templates',
					'U_MORE_SMILIES' 			=> append_sid("{$siteurl}/forum.$phpEx", 'action=posting&amp;mode=smilies'),
			));
		echo $template->fetch('admin/modrules.html');
		close_out();
}
//ADD NEW RULE SECTION TO DATABASE
elseif ($act=="addsect"){
$msg = request_var('text', '',true);
if($msg == '')
	{
					$template->assign_vars(array(
						'S_ERROR'			=> true,
						'S_FORWARD'			=> false,
						'TITTLE_M'			=> $user->lang['BT_ERROR'],
						'MESSAGE'			=> $user->lang['RULES_FEALD_BLANK'] . '<br /><br /><a href="javascript:history.go(-1)"  onMouseOver="self.status=document.referrer;return true">' . $user->lang['GO_BACK'] . '</a>',
					));
					echo $template->fetch('message_body.html');
					close_out();
	}

$title = request_var('title', '',true);
if($title == '')
	{
					$template->assign_vars(array(
						'S_ERROR'			=> true,
						'S_FORWARD'			=> false,
						'TITTLE_M'			=> $user->lang['BT_ERROR'],
						'MESSAGE'			=> $user->lang['TITLE_BLANK'] . '<br /><br /><a href="javascript:history.go(-1)"  onMouseOver="self.status=document.referrer;return true">' . $user->lang['GO_BACK'] . '</a>',
					));
					echo $template->fetch('message_body.html');
					close_out();
	}
$public = request_var('public', '');
if($public == '')
	{
					$template->assign_vars(array(
						'S_ERROR'			=> true,
						'S_FORWARD'			=> false,
						'TITTLE_M'			=> $user->lang['BT_ERROR'],
						'MESSAGE'			=> $user->lang['PUPLIC_FEALD_BLANK'] . '<br /><br /><a href="javascript:history.go(-1)"  onMouseOver="self.status=document.referrer;return true">' . $user->lang['GO_BACK'] . '</a>',
					));
					echo $template->fetch('message_body.html');
					close_out();
	}
$level = request_var('level', array(0));
if(count($level) < 1)
	{
					$template->assign_vars(array(
						'S_ERROR'			=> true,
						'S_FORWARD'			=> false,
						'TITTLE_M'			=> $user->lang['BT_ERROR'],
						'MESSAGE'			=> $user->lang['GROUP_NOT_SET'] . '<br /><br /><a href="javascript:history.go(-1)"  onMouseOver="self.status=document.referrer;return true">' . $user->lang['GO_BACK'] . '</a>',
					));
					echo $template->fetch('message_body.html');
					close_out();
	}
				
				include_once('include/function_posting.php');
				include_once('include/message_parser.php');
				include_once('include/class.bbcode.php');
				$bbcode_status		= ($config['allow_bbcode'] && $config['auth_bbcode_pm'] && checkaccess('u_add_bbcode_details')) ? true : false;
				$smilies_status		= ($config['allow_smilies'] && $config['auth_smilies_pm'] && checkaccess('u_add_smiles_to_details')) ? true : false;
				$img_status			= ($config['auth_img_pm'] && checkaccess('u_add_imgbbcode_details')) ? true : false;
				$flash_status		= ($config['auth_flash_pm'] && checkaccess('u_flash_in_details')) ? true : false;
				$url_status			= ($config['allow_post_links'] && checkaccess('u_links_in_details')) ? true : false;
				$enable_sig			= ($config['allow_sig'] && $config['allow_sig_pm'] && checkaccess('u_sig'));
				$enable_smilies		= ($config['allow_smilies'] && checkaccess('u_add_smiles_to_details'));
				$enable_bbcode		= ($config['allow_bbcode'] && checkaccess('u_add_bbcode_details'));
				$enable_urls		= ($config['enable_urls'] && checkaccess('u_links_in_details'))?true:false;
				$message_parser = new parse_message();
				$message_parser->message = $msg;
				$bbcode_uid = $message_parser->bbcode_uid;
				$message_parser->parse($enable_bbcode, ($config['allow_post_links']) ? $enable_urls : false, $enable_smilies, $img_status, $flash_status, true, $config['allow_post_links']);
				if (sizeof($message_parser->warn_msg))
				{
					$template->assign_vars(array(
						'S_ERROR'			=> true,
						'S_FORWARD'			=> false,
						'TITTLE_M'			=> $user->lang['BT_ERROR'],
						'MESSAGE'			=> implode('<br />', $message_parser->warn_msg) . '<br /><br /><a href="javascript:history.go(-1)"  onMouseOver="self.status=document.referrer;return true">' . $user->lang['GO_BACK'] . '</a>',
					));
					echo $template->fetch('message_body.html');
					close_out();
				}
				$msg = $db->sql_escape(stripslashes($message_parser->message));
				$sql = "INSERT INTO ".$db_prefix."_rules ( `id` , `title` , `text` , `bbcode_uid`, `bbcode_bitfield`, `public` , `level` )VALUES (NULL , '$title', '".$msg."', '" . $message_parser->bbcode_uid . "', '" . $message_parser->bbcode_bitfield . "', '$public', '[" . implode("],[",$level) ."]')";
				if (!$db->sql_query($sql)) btsqlerror($sql);
				//header("Refresh: 0; url=modrules.php");
							$template->assign_vars(array(
								'S_USER_NOTICE'			=> true,
								'META'				=>	meta_refresh(3,'admin.php?i=staff&op=modrules#modrules'),
								'MESSAGE_TITLE'			=> $user->lang['SUCCESS'],
								'MESSAGE_TEXT'		=> $user->lang['RULE_ADDED'] . '<br />' . back_link($siteurl . '/admin.php?i=staff&op=modrules#modrules'),
							));
					echo $template->fetch('admin/message_body.html');
					close_out();
}
//EDIT RULE
elseif ($act == "edit")
{
	$sql_rule = "select * from ".$db_prefix."_rules where id=$id;";
	$res_rule = $db->sql_query($sql_rule);
	$res = $db->sql_fetchrow($res_rule);
	$db->sql_freeresult($res_rule);
	$group_level = group_select_options_id(str_replace(array('[',']',','),array('','',';;'),$res["level"]));
	include_once('include/function_posting.php');
	include_once('include/message_parser.php');
	include_once('include/class.bbcode.php');
	$message_parser = new parse_message();
	$message_parser->message = $res["text"];
	$message_parser->decode_message($res['bbcode_uid']);
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
			'BBCODE_TAG'		=> str_replace('=', '', $row['bbcode_tag']),
			'BBCODE_HELPLINE'	=> $row['bbcode_helpline'],
			'A_BBCODE_HELPLINE'	=> str_replace(array('&amp;', '&quot;', "'", '&lt;', '&gt;'), array('&', '"', "\'", '<', '>'), $row['bbcode_helpline']),
		));

		$i++;
	}
	$db->sql_freeresult($result);
		$hidden = build_hidden_fields(array(
					"id"			=>	$res['id'],
					"act"			=>	'edited',
					'i'				=>	'staff',
					'op'			=>	'modrules'
					));
	$template->assign_vars(array(
			'R_TITLE'					=>	$res['title'],
			'R_RULES'					=>	$message_parser->message,
			'R_PUBLIC'					=>	(($res["public"] == "yes")?true:false),
			'GROUPS_LEVEL'					=>	$group_level,
			'U_ACTION'					=>	'admin.php',
			'HIDEN'						=>	$hidden,
			'POS'						=>	'newsect',
			'GROUPS'					=>	group_select_options_id('1;;2;;3'),
			'S_BBCODE_QUOTE'			=> checkaccess("u_add_quote_details"),
			'S_BBCODE_IMG'				=> checkaccess("u_add_imgbbcode_details"),
			'S_LINKS_ALLOWED'			=> checkaccess("u_links_in_details"),
			'S_BBCODE_FLASH'			=> checkaccess("u_flash_in_details"),
			'S_BBCODE_ALLOWED'			=>	true,
			'S_SMILIES_ALLOWED'			=>	true,
			'S_SHOW_SMILEY_LINK'		=>	true,
			'T_TEMPLATE_PATH'			=> 'themes/' . $theme . '/templates',
			'U_MORE_SMILIES' 			=> append_sid("{$siteurl}/posting.$phpEx", 'mode=smilies&amp;f=' . $forum_id),
	));
	echo $template->fetch('admin/modrules.html');
	close_out();
}
//DO EDIT RULE, UPDATE DB
elseif ($act=="edited")
{
	$msg = request_var('text', '',true);
	if($msg == '')
	{
		$template->assign_vars(array(
			'S_ERROR'			=> true,
			'S_FORWARD'			=> false,
			'TITTLE_M'			=> $user->lang['BT_ERROR'],
			'MESSAGE'			=> $user->lang['RULES_FEALD_BLANK'] . '<br /><br /><a href="javascript:history.go(-1)"  onMouseOver="self.status=document.referrer;return true">' . $user->lang['GO_BACK'] . '</a>',
		));
		echo $template->fetch('message_body.html');
		close_out();
	}

	$title = request_var('title', '',true);
	if($title == '')
	{
		$template->assign_vars(array(
			'S_ERROR'			=> true,
			'S_FORWARD'			=> false,
			'TITTLE_M'			=> $user->lang['BT_ERROR'],
			'MESSAGE'			=> $user->lang['TITLE_BLANK'] . '<br /><br /><a href="javascript:history.go(-1)"  onMouseOver="self.status=document.referrer;return true">' . $user->lang['GO_BACK'] . '</a>',
		));
		echo $template->fetch('message_body.html');
		close_out();
	}
$public = request_var('public', '');
if($public == '')
	{
		$template->assign_vars(array(
			'S_ERROR'			=> true,
			'S_FORWARD'			=> false,
			'TITTLE_M'			=> $user->lang['BT_ERROR'],
			'MESSAGE'			=> $user->lang['PUPLIC_FEALD_BLANK'] . '<br /><br /><a href="javascript:history.go(-1)"  onMouseOver="self.status=document.referrer;return true">' . $user->lang['GO_BACK'] . '</a>',
		));
		echo $template->fetch('message_body.html');
		close_out();
	}
$level = request_var('level', array(0));
if(count($level) < 1)
	{
		$template->assign_vars(array(
			'S_ERROR'			=> true,
			'S_FORWARD'			=> false,
			'TITTLE_M'			=> $user->lang['BT_ERROR'],
			'MESSAGE'			=> $user->lang['GROUP_NOT_SET'] . '<br /><br /><a href="javascript:history.go(-1)"  onMouseOver="self.status=document.referrer;return true">' . $user->lang['GO_BACK'] . '</a>',
		));
		echo $template->fetch('message_body.html');
		close_out();
	}
	
	include_once('include/function_posting.php');
	include_once('include/message_parser.php');
	include_once('include/class.bbcode.php');
	$bbcode_status		= ($config['allow_bbcode'] && $config['auth_bbcode_pm'] && checkaccess('u_add_bbcode_details')) ? true : false;
	$smilies_status		= ($config['allow_smilies'] && $config['auth_smilies_pm'] && checkaccess('u_add_smiles_to_details')) ? true : false;
	$img_status			= ($config['auth_img_pm'] && checkaccess('u_add_imgbbcode_details')) ? true : false;
	$flash_status		= ($config['auth_flash_pm'] && checkaccess('u_flash_in_details')) ? true : false;
	$url_status			= ($config['allow_post_links'] && checkaccess('u_links_in_details')) ? true : false;
	$enable_sig			= ($config['allow_sig'] && $config['allow_sig_pm'] && checkaccess('u_sig'));
	$enable_smilies		= ($config['allow_smilies'] && checkaccess('u_add_smiles_to_details'));
	$enable_bbcode		= ($config['allow_bbcode'] && checkaccess('u_add_bbcode_details'));
	$enable_urls		= ($config['enable_urls'] && checkaccess('u_links_in_details'))?true:false;
	$message_parser = new parse_message();
	$message_parser->message = $msg;
	$bbcode_uid = $message_parser->bbcode_uid;
	$message_parser->parse($enable_bbcode, ($config['allow_post_links']) ? $enable_urls : false, $enable_smilies, $img_status, $flash_status, true, $config['allow_post_links']);
	if (sizeof($message_parser->warn_msg))
	{
		$template->assign_vars(array(
			'S_ERROR'			=> true,
			'S_FORWARD'			=> false,
			'TITTLE_M'			=> $user->lang['BT_ERROR'],
			'MESSAGE'			=> implode('<br />', $message_parser->warn_msg) . '<br /><br /><a href="javascript:history.go(-1)"  onMouseOver="self.status=document.referrer;return true">' . $user->lang['GO_BACK'] . '</a>',
		));
		echo $template->fetch('message_body.html');
		close_out();
	}
	$msg = $db->sql_escape(stripslashes($message_parser->message));
	$sql = "UPDATE ".$db_prefix."_rules set title='$title', text = '".$msg."', public='$public', level='[" . implode("],[",$level) ."]', bbcode_uid='" . $bbcode_uid . "', bbcode_bitfield='" . $message_parser->bbcode_bitfield . "' where id='$id'";
	if (!$db->sql_query($sql)) btsqlerror($sql);
							$template->assign_vars(array(
								'S_USER_NOTICE'			=> true,
								'META'				=>	meta_refresh(3,'admin.php?i=staff&op=modrules#modrules'),
								'MESSAGE_TITLE'			=> $user->lang['SUCCESS'],
								'MESSAGE_TEXT'		=> $user->lang['RULE_UPDATED'] . '<br />' . back_link($siteurl . '/admin.php?i=staff&op=modrules#modrules'),
							));
					echo $template->fetch('admin/message_body.html');
					close_out();
}
else{
// STANDARD MENU OR HOMEPAGE ETC
$sql_rule = "select * from ".$db_prefix."_rules order by level;";
$res = $db->sql_query($sql_rule);
$db->sql_freeresult($sql_rule);
	include_once('include/function_posting.' . $phpEx);
	include_once('include/class.bbcode.php');
	
while ($arr = $db->sql_fetchrow($res))
{
	$bbcode = false;
	$rule_text = $arr['text'];
	$level_array = preg_split("/;;[\\s]*/",str_replace(array('[',']',','),array('','',';;'),$arr["level"]));
	// Instantiate BBCode if need be
	if ($arr['bbcode_bitfield'])
	{
		include_once('include/bbcode.php');
		$bbcode = new bbcode($arr['bbcode_bitfield']);
		$bbcode->bbcode_second_pass($rule_text, $arr['bbcode_uid'], $arr['bbcode_bitfield']);
	}
	// Parse the message and subject
	$rule_text = bbcode_nl2br($rule_text);
	$rule_text = parse_smiles($rule_text);
				$template->assign_block_vars('rules_var',array(
				'ID' => $arr["id"],
				'TITLE' => $arr["title"],
				'RULE' => $rule_text,
				'R_PUBLIC' =>  $arr["public"],
				));
				foreach($level_array as $rol)
				{
					$sqla = 'SELECT group_id, group_name, group_colour FROM `' . $db_prefix . '_level_settings` WHERE group_id=' . $rol[0] ;
					$result = $db->sql_query($sqla); 
					while ($row_val = $db->sql_fetchrow($result))
					{
						$template->assign_block_vars('rules_var.group',array(
						'ID' => $row_val["group_id"],
						'TITLE' => (($user->lang[$row_val["group_name"]])?$user->lang[$row_val["group_name"]] : $row_val["group_name"]),
						'COLOR' => $row_val["group_colour"],
						));
					}
				}
}
		echo $template->fetch('admin/modrules.html');
		close_out();
}
?>