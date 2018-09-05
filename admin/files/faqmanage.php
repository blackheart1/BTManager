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
** File faqmanage.php 2018-06-04 14:32:00 Black_Heart
**
** CHANGES
**
** 2018-06-06 - Added BBcode system to faq's
**/
if (!defined('IN_PMBT'))
{
	include_once './../../security.php';
	die ("You can't access this file directly");
}
$user->set_lang('admin/acp_faqmanager',$user->ulanguage);
$action			= request_var('action', '');
$order			= request_var('order', array(0));
$fid			= request_var('id', '');
$question		= utf8_normalize_nfc(request_var('question', '',true));
$type			= request_var('type', '');
$flag			= request_var('flag', '');
$title			= utf8_normalize_nfc(request_var('title', '',true));
$answer			= utf8_normalize_nfc(request_var('answer', '',true));
$categ			= utf8_normalize_nfc(request_var('categ', '',true));
$inid			= request_var('inid', '');
if ($action == "reorder") {
 foreach($order as $id => $position) $db->sql_query("UPDATE `".$db_prefix."_faq` SET `order`='$position' WHERE id='$id'") or sqlerr();
                                $template->assign_vars(array(
								        'S_SUCCESS'            => true,
										'S_FORWARD'			=> $siteurl."/admin.php?i=staff&op=faqmanage",
								        'TITTLE_M'          => $user->lang['SUCCESS'],
                                        'MESSAGE'            => $user->lang['EDIT_REORDER_SAVED'],
                                ));
		echo $template->fetch('message_body.html');
		close_out();
}
elseif ($action == "edit" && isset($fid)) {
		include_once('include/function_posting.php');
		include_once('include/message_parser.php');
		include_once('include/class.bbcode.php');
		generate_smilies('inline', 0);
		$sql = 'SELECT bbcode_id, bbcode_tag, bbcode_helpline
			FROM '.$db_prefix.'_bbcodes
			WHERE display_on_posting = 1
			ORDER BY bbcode_tag';
		$result = $db->sql_query($sql);
			
		$i = 0;
		$num_predefined_bbcodes = 24;
		while ($rows = $db->sql_fetchrow($result))
		{
			// If the helpline is defined within the language file, we will use the localised version, else just use the database entry...
			if (isset($user->lang[strtoupper($rows['bbcode_helpline'])]))
			{
				$rows['bbcode_helpline'] = $user->lang[strtoupper($rows['bbcode_helpline'])];
			}
	
			$template->assign_block_vars('custom_tags', array(
				'BBCODE_NAME'		=> "'[{$rows['bbcode_tag']}]', '[/" . str_replace('=', '', $rows['bbcode_tag']) . "]'",
				'BBCODE_ID'			=> $num_predefined_bbcodes + ($i * 2),
				'BBCODE_TAG'		=> str_replace('=', '', $rows['bbcode_tag']),
				'BBCODE_HELPLINE'	=> $rows['bbcode_helpline'],
				'A_BBCODE_HELPLINE'	=> str_replace(
					array('&amp;', '&quot;', "'", '&lt;', '&gt;'), 
					array('&', '"', "\'", '<', '>'), $rows['bbcode_helpline']),
			));
	
			$i++;
		}
		$db->sql_freeresult($result);
	$res1 = "SELECT * FROM `".$db_prefix."_faq` WHERE `id`='".$fid."' LIMIT 1;";
 	$res = $db->sql_query($res1);
	$db->sql_freeresult($res1);
	$u_action = "./admin.php";
	while ($arr = $db->sql_fetchrow($res)) {
		$arr['question'] = stripslashes($arr['question']);
  		$arr['answer'] = stripslashes($arr['answer']);
  		if ($arr['type'] == "item") {
	$hidden = build_hidden_fields(array(
	"id"		=> $fid,
	'action'	=> 'edititem',
	'i'			=> 'staff',
	'op'		=> 'faqmanage',
	));
   			if ($arr['flag'] == "0") $flag = 		"<select name=\"flag\" style=\"width: 110px;\"><option value=\"0\" style=\"color: #FF0000;\" selected=\"selected\">".$user->lang['F_HIDDEN']."</option><option value=\"1\" style=\"color: #000000;\">".$user->lang['F_NORMAL']."</option><option value=\"2\" style=\"color: #0000FF;\">".$user->lang['F_UPDATED']."</option><option value=\"3\" style=\"color: #008000;\">".$user->lang['F_NEW']."</option></select>";
   			elseif ($arr['flag'] == "2") $flag = 	"<select name=\"flag\" style=\"width: 110px;\"><option value=\"0\" style=\"color: #FF0000;\">".$user->lang['F_HIDDEN']."</option><option value=\"1\" style=\"color: #000000;\">".$user->lang['F_NORMAL']."</option><option value=\"2\" style=\"color: #0000FF;\" selected=\"selected\">".$user->lang['F_UPDATED']."</option><option value=\"3\" style=\"color: #008000;\">".$user->lang['F_NEW']."</option></select>";
   			elseif ($arr['flag'] == "3") $flag = 	"<select name=\"flag\" style=\"width: 110px;\"><option value=\"0\" style=\"color: #FF0000;\">".$user->lang['F_HIDDEN']."</option><option value=\"1\" style=\"color: #000000;\">".$user->lang['F_NORMAL']."</option><option value=\"2\" style=\"color: #0000FF;\">".$user->lang['F_UPDATED']."</option><option value=\"3\" style=\"color: #008000;\" selected=\"selected\">".$user->lang['F_NEW']."</option></select>";
   			else $flag = 							"<select name=\"flag\" style=\"width: 110px;\"><option value=\"0\" style=\"color: #FF0000;\">".$user->lang['F_HIDDEN']."</option><option value=\"1\" style=\"color: #000000;\" selected=\"selected\">".$user->lang['F_NORMAL']."</option><option value=\"2\" style=\"color: #0000FF;\">".$user->lang['F_UPDATED']."</option><option value=\"3\" style=\"color: #008000;\">".$user->lang['F_NEW']."</option></select>";
   			$res3 = "SELECT `id`, `question` FROM `".$db_prefix."_faq` WHERE `type`='categ' ORDER BY `order` ASC;";
			$res = $db->sql_query($res3);
			$db->sql_freeresult($res3);
   			$catsel = "<select style=\"width: 300px;\" name=\"categ\" />";
			while ($arr2 = $db->sql_fetchrow($res)) {
    			$selected = ($arr2['id'] == $arr['categ']) ? " selected=\"selected\"" : "";
    			$catsel .="<option value=\"".$arr2['id']."\"". $selected .">".$arr2['question']."</option>";
   			}
   			$catsel .="</select>";
			$bbcode = false;
		// Instantiate BBCode if need be
				$text = smiley_text($arr['answer'],true);
			if ($arr['bbcode_bitfield'])
			{
				include_once('include/bbcode.' . $phpEx);
				$message_parser = new parse_message();
				$message_parser->message = $text;
				$message_parser->decode_message($arr['bbcode_uid']);
				$text = $message_parser->message;
				//die($message_parser->message);
			}
   			$template->assign_vars(array(
						'S_SMILIES_ALLOWED'			=> ($config['allow_smilies'] && $config['auth_smilies_pm'] && checkaccess('u_pm_smilies')) ? true : false,
						'S_SHOW_SMILEY_LINK'		=> ($config['allow_smilies'] && $config['auth_smilies_pm'] && checkaccess('u_pm_smilies')) ? true : false,
						'S_BBCODE_ALLOWED'			=> ($config['allow_bbcode'] && $config['auth_bbcode_pm'] && checkaccess('u_pm_bbcode')) ? true : false,
						'T_TEMPLATE_PATH' 			=> 'themes/' . $theme . '/templates',
				'L_TITLE'            => $user->lang['F_TITLE_D'],
				'L_EXPLAIN'            => $user->lang['F_TITLE_ED_IT_EXP'],
				'ISITEM'			=> true,
   				'F_ID'				=> $arr['id'],
   				'F_Q_AREA'			=> 'question',
   				'F_QUEST'			=> $arr['question'],
   				'T_AREA'			=> 'answer',
   				'F_STATUS'			=> $flag,
   				'F_CATIGORY'		=> $catsel,
   				'S_TEXT'			=> $text,
				'HIDEN'				=> $hidden,
				'U_ACTION'			=> $u_action,
   			));
  		}
  		elseif ($arr['type'] == "categ") {
	$hidden = build_hidden_fields(array(
	"id"		=> $fid,
	'action'	=> 'editsect',
	'i'			=> 'staff',
	'op'		=> 'faqmanage',
	));
   			//if ($arr[flag] == "0") $flag = "<select name=\"flag\" style=\"width: 110px;\"><option value=\"0\" style=\"color: #FF0000;\" selected=\"selected\">".$user->lang['F_HIDDEN']."</option><option value=\"1\" style=\"color: #000000;\">".$user->lang['F_NORMAL']."</option></select>";
   			//else $flag = "<select name=\"flag\" style=\"width: 110px;\"><option value=\"0\" style=\"color: #FF0000;\">".$user->lang['F_HIDDEN']."</option><option value=\"1\" style=\"color: #000000;\" selected=\"selected\">".$user->lang['F_NORMAL']."</option></select>";
   			$template->assign_vars(array(
				'L_TITLE'            => $user->lang['F_TITLE_D'],
				'L_EXPLAIN'            => $user->lang['F_TITLE_ED_CAT_EXP'],
				'ISITEM'			=> false,
   				'F_ID'				=> $arr['id'],
   				'F_STATUS'			=> $flag,
   				'F_QUEST'			=> $arr['question'],
				'HIDEN'				=> $hidden,
				'U_ACTION'			=> $u_action,
   			));
  		}
 	}
echo $template->fetch('admin/edit_faqs.html');
close_out(); 
}
elseif ($action == "edititem" && $fid != NULL && $question != NULL && $answer != NULL && $flag != NULL && $categ != NULL) {
 	include_once('include/function_posting.php');
	include_once('include/message_parser.php');
	include_once('include/class.bbcode.php');
	$bbcode_status		= ($config['allow_bbcode'] && $config['auth_bbcode_pm'] && checkaccess('u_pm_bbcode')) ? true : false;
	$smilies_status		= ($config['allow_smilies'] && $config['auth_smilies_pm'] && checkaccess('u_pm_smilies')) ? true : false;
	$img_status			= ($config['auth_img_pm'] && checkaccess('u_pm_img')) ? true : false;
	$flash_status		= ($config['auth_flash_pm'] && checkaccess('u_pm_flash')) ? true : false;
	$url_status			= ($config['allow_post_links']) ? true : false;
	$enable_sig			= ($config['allow_sig'] && $config['allow_sig_pm'] && checkaccess('u_sig'));
	$enable_smilies		= ($config['allow_smilies'] && checkaccess('u_pm_smilies'));
	$enable_bbcode		= ($config['allow_bbcode'] && checkaccess('u_pm_bbcode'));
	$enable_urls		= ($config['enable_urls'])?true:false;
	$message_parser = new parse_message();
	$message_parser->message = $answer;
	$message_parser->parse($enable_bbcode, true, $enable_smilies, $img_status, $flash_status, true, $config['allow_post_links'],true,true,true,'shout');
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
	$sql_ary	= array(
	'`question`'			=> $question,
	'`answer`'				=> $message_parser->message,
	'`flag`'				=> $flag,
	'`categ`'				=> (int)$categ,	
	'`bbcode_bitfield`'		=> $message_parser->bbcode_bitfield,
	'`bbcode_uid`'			=> $message_parser->bbcode_uid
	);
	//die($db->sql_build_array('UPDATE', $sql_ary));
	$db->sql_query("UPDATE `".$db_prefix."_faq` SET " . $db->sql_build_array('UPDATE', $sql_ary) . " WHERE id='$fid'") or sqlerr();
	$template->assign_vars(array(
		'S_SUCCESS'            => true,
		'S_FORWARD'			=> $siteurl."/admin.php?i=staff&op=faqmanage",
		'TITTLE_M'          => $user->lang['SUCCESS'],
		'MESSAGE'            => $user->lang['EDIT_ITEM_SAVED'],
	));
	echo $template->fetch('message_body.html');
	close_out();
}
elseif ($action == "editsect" && $fid != NULL && $title != NULL)
{
	$title = $db->sql_escape(stripslashes(htmlspecialchars_decode($title)));
	$sql_ary	= array(
	'`question`'			=> $title,
	'`answer`'				=> '',
	'`flag`'				=> $flag,
	'`categ`'				=> (int)0,	
	'`bbcode_bitfield`'		=> '',
	'`bbcode_uid`'			=> ''
	);
	$db->sql_query("UPDATE `".$db_prefix."_faq` SET " . $db->sql_build_array('UPDATE', $sql_ary) . " WHERE id='$fid'") or sqlerr();
	$template->assign_vars(array(
		'S_SUCCESS'            => true,
		'S_FORWARD'			=> $siteurl."/admin.php?i=staff&op=faqmanage",
		'TITTLE_M'          => $user->lang['SUCCESS'],
		'MESSAGE'            => $user->lang['EDIT_SECTION_SAVED'],
	));
	echo $template->fetch('message_body.html');
	close_out();
}
elseif ($action == "delete" && isset($fid))
{
	$confirm_key			= request_var('confirm_key', '');
	if (confirm_box(true))
	{
		$db->sql_query("DELETE FROM `".$db_prefix."_faq` WHERE `id`='".$fid."' LIMIT 1") or sqlerr();
		add_log('admin','F_REMOVED');
		$template->assign_vars(array(
			'S_SUCCESS'            => true,
			'S_FORWARD'			=> $siteurl."/admin.php?i=staff&op=faqmanage",
			'TITTLE_M'          => $user->lang['SUCCESS'],
			'MESSAGE'            => $user->lang['F_REMOVED'],
		));
		echo $template->fetch('message_body.html');
		close_out();
	}
	else
	{
		$hidden = build_hidden_fields(array(
			"id"				=> $fid,
			"i"					=> 'staff',
			"op"				=> 'faqmanage',
			"action"			=> 'delete',
		));
		confirm_box(false, $user->lang['CONFIRM_OPERATION_DEL_FA'], $hidden,'confirm_body.html','admin.php');
	}

}
elseif ($action == "additem" && $inid)
{
		include_once('include/function_posting.php');
		include_once('include/message_parser.php');
		include_once('include/class.bbcode.php');
		generate_smilies('inline', 0);
		$sql = 'SELECT bbcode_id, bbcode_tag, bbcode_helpline
			FROM '.$db_prefix.'_bbcodes
			WHERE display_on_posting = 1
			ORDER BY bbcode_tag';
		$result = $db->sql_query($sql);
			
		$i = 0;
		$num_predefined_bbcodes = 22;
		while ($rows = $db->sql_fetchrow($result))
		{
			// If the helpline is defined within the language file, we will use the localised version, else just use the database entry...
			if (isset($user->lang[strtoupper($rows['bbcode_helpline'])]))
			{
				$rows['bbcode_helpline'] = $user->lang[strtoupper($rows['bbcode_helpline'])];
			}
	
			$template->assign_block_vars('custom_tags', array(
				'BBCODE_NAME'		=> "'[{$rows['bbcode_tag']}]', '[/" . str_replace('=', '', $rows['bbcode_tag']) . "]'",
				'BBCODE_ID'			=> $num_predefined_bbcodes + ($i * 2),
				'BBCODE_TAG'		=> str_replace('=', '', $rows['bbcode_tag']),
				'BBCODE_HELPLINE'	=> $rows['bbcode_helpline'],
				'A_BBCODE_HELPLINE'	=> str_replace(
					array('&amp;', '&quot;', "'", '&lt;', '&gt;'), 
					array('&', '"', "\'", '<', '>'), $rows['bbcode_helpline']),
			));
	
			$i++;
		}
	$hidden = build_hidden_fields(array(
		"i"					=> 'staff',
		"op"				=> 'faqmanage',
		"action"			=> 'addnewitem',
	));
	$res3 = "SELECT `id`, `question` FROM `".$db_prefix."_faq` WHERE `type`='categ' ORDER BY `order` ASC;";
	$res = $db->sql_query($res3);
	$db->sql_freeresult($res3);
	$catsel = "<select style=\"width: 300px;\" name=\"categ\" />";
	while ($arr2 = $db->sql_fetchrow($res)) {
		$selected = ($inid == $arr['categ']) ? " selected=\"selected\"" : "";
		$catsel .="<option value=\"".$arr2['id']."\"". $selected .">".$arr2['question']."</option>";
	}
	$catsel .="</select>";
	$flag = "<select name=\"flag\" style=\"width: 110px;\"><option value=\"0\" style=\"color: #FF0000;\">".$user->lang['F_HIDDEN']."</option><option value=\"1\" style=\"color: #000000;\" >".$user->lang['F_NORMAL']."</option><option value=\"2\" style=\"color: #0000FF;\">".$user->lang['F_UPDATED']."</option><option value=\"3\" style=\"color: #008000;\" selected=\"selected\">".$user->lang['F_NEW']."</option></select>";
	$u_action = 'admin.php';
	$template->assign_vars(array(
		'S_SMILIES_ALLOWED'			=> ($config['allow_smilies'] && $config['auth_smilies_pm'] && checkaccess('u_pm_smilies')) ? true : false,
		'S_SHOW_SMILEY_LINK'		=> ($config['allow_smilies'] && $config['auth_smilies_pm'] && checkaccess('u_pm_smilies')) ? true : false,
						'S_BBCODE_ALLOWED'			=> ($config['allow_bbcode'] && $config['auth_bbcode_pm'] && checkaccess('u_pm_bbcode')) ? true : false,
						'T_TEMPLATE_PATH' 			=> 'themes/' . $theme . '/templates',
		'L_TITLE'			=> $user->lang['F_TITLE_D'],
		'L_EXPLAIN'			=> $user->lang['F_TITLE_AD_IT_EXP'],
		'ISITEM'			=> true,
		'F_NEW'				=> true,
		'F_Q_AREA'			=> 'question',
		'F_QUEST'			=> '',
		'T_AREA'			=> 'answer',
		'F_STATUS'			=> $flag,
		'F_CATIGORY'		=> $catsel,
		'S_TEXT'			=> '',
		'HIDEN'				=> $hidden,
		'U_ACTION'			=> $u_action,
		'U_MORE_SMILIES'	=> 'upload.php?op=up',
	));
	echo $template->fetch('admin/edit_faqs.html');
	close_out(); 
}

// ACTION: addsection - add a new section
elseif ($action == "addsection") {
	$hidden = build_hidden_fields(array(
		"i"					=> 'staff',
		"op"				=> 'faqmanage',
		"action"			=> 'addnewsect',
	));
	$flag = "<select name=\"flag\" style=\"width: 110px;\"><option value=\"0\" style=\"color: #FF0000;\">".$user->lang['F_HIDDEN']."</option><option value=\"1\" style=\"color: #000000;\" selected=\"selected\">".$user->lang['F_NORMAL']."</option></select>";			$u_action = 'admin.php';
	$template->assign_vars(array(
		'S_SMILIES_ALLOWED'	=> true,
		'L_TITLE'            => $user->lang['F_TITLE_D'],
		'L_EXPLAIN'            => $user->lang['F_TITLE_AD_CAT_EXP'],
		'ISITEM'			=> false,
		'F_NEW'				=> true,
		'F_Q_AREA'			=> 'title',
		'F_QUEST'			=> '',
		'F_STATUS'			=> $flag,
		'HIDEN'				=> $hidden,
		'U_ACTION'			=> $u_action,
	));
	echo $template->fetch('admin/edit_faqs.html');
	close_out(); 
}

// subACTION: addnewitem - add a new item to the db
elseif ($action == "addnewitem" && $question != NULL && $answer != NULL && $flag != NULL && $categ != NULL)
{
	$question		= request_var('question', '',true);
	$answer			= request_var('answer', '',true);
	$flag			= request_var('flag', '0');
	$categ			= request_var('categ', '0');
	$res1 = "SELECT MAX(`order`) AS neworder FROM `".$db_prefix."_faq` WHERE `type`='item' AND `categ`='$categ';";
	$res = $db->sql_query($res1);
	while ($arr = $db->sql_fetchrow($res))
	{
		$order = $arr['neworder'] + 1;
	}
	$db->sql_freeresult($res);
	include_once('include/function_posting.php');
	include_once('include/message_parser.php');
	include_once('include/class.bbcode.php');
	$bbcode_status		= ($config['allow_bbcode'] && $config['auth_bbcode_pm'] && checkaccess('u_pm_bbcode')) ? true : false;
	$smilies_status		= ($config['allow_smilies'] && $config['auth_smilies_pm'] && checkaccess('u_pm_smilies')) ? true : false;
	$img_status			= ($config['auth_img_pm'] && checkaccess('u_pm_img')) ? true : false;
	$flash_status		= ($config['auth_flash_pm'] && checkaccess('u_pm_flash')) ? true : false;
	$url_status			= ($config['allow_post_links']) ? true : false;
	$enable_sig			= ($config['allow_sig'] && $config['allow_sig_pm'] && checkaccess('u_sig'));
	$enable_smilies		= ($config['allow_smilies'] && checkaccess('u_pm_smilies'));
	$enable_bbcode		= ($config['allow_bbcode'] && checkaccess('u_pm_bbcode'));
	$enable_urls		= ($config['enable_urls'])?true:false;
	$message_parser = new parse_message();
	$message_parser->message = $answer;
	$bbcode_uid = $message_parser->bbcode_uid;
	$message_parser->parse($enable_bbcode, ($config['allow_post_links']) ? $enable_urls : false, $enable_smilies, $img_status, $flash_status, true, $config['allow_post_links'],true,true,true,'shout');
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
	$sql_ary = array(
	'`type`'					=> 'item',
	'`question`'				=> $question,
	'`answer`'					=> $message_parser->message,
	'`flag`'					=> $flag,
	'`categ`'					=> (int)$categ,
	'`order`'					=> (int)$order,
	'`bbcode_bitfield`'			=> $message_parser->bbcode_bitfield,
	'`bbcode_uid`'				=> $message_parser->bbcode_uid
	);
	$db->sql_query("INSERT INTO `".$db_prefix."_faq` " . $db->sql_build_array('INSERT', $sql_ary)) or sqlerr();
                                $template->assign_vars(array(
								        'S_SUCCESS'            => true,
										'S_FORWARD'			=> $siteurl."/admin.php?i=staff&op=faqmanage",
								        'TITTLE_M'          => $user->lang['SUCCESS'],
                                        'MESSAGE'            => $user->lang['ADD_ITEM_SAVED'],
                                ));
		echo $template->fetch('message_body.html');
		close_out();
}

// subACTION: addnewsect - add a new section to the db
elseif($action == "addnewsect" && $title != NULL && $flag != NULL)
{
	$title = $db->sql_escape(stripslashes(htmlspecialchars_decode($title)));
	$res1 ="SELECT MAX(`order`) AS neworder FROM `".$db_prefix."_faq` WHERE `type`='categ';";
	$res = $db->sql_query($res1);
	$db->sql_freeresult($res1);
	while ($arr = $db->sql_fetchrow($res)) $order = $arr['neworder'] + 1;
	$db->sql_query("INSERT INTO `".$db_prefix."_faq` (`type`, `question`, `answer`, `flag`, `categ`, `order`) VALUES ('categ', '$title', '', '$flag', '0', '$order')") or sqlerr();
	$template->assign_vars(array(
		'S_SUCCESS'            => true,
		'S_FORWARD'			=> $siteurl."/admin.php?i=staff&op=faqmanage",
		'TITTLE_M'          => $user->lang['SUCCESS'],
		'MESSAGE'            => $user->lang['ADD_SECTION_SAVED'],
	));
	echo $template->fetch('message_body.html');
	close_out();
}
include_once('include/function_posting.php');
include_once('include/message_parser.php');
include_once('include/class.bbcode.php');
$template->assign_vars(array(
	'L_TITLE'            => $user->lang['F_TITLE_D'],
	'L_EXPLAIN'            => $user->lang['F_TITLE_D_EXP'],
));
$orphanc = '0';
$res1 = "SELECT `id`, `type`, `question`, `answer`, `flag`, `categ`, `order` FROM `".$db_prefix."_faq` WHERE `type`='categ' ORDER BY `order` ASC;";
$res = $db->sql_query($res1);
$c_count = $db->sql_numrows($res);
$db->sql_freeresult($res1);
while ($arr1 = $db->sql_fetchrow($res))
{
	$orphanc .= ','.$arr1['id'];
	$orderc = "<select name=\"order[". $arr1['id'] ."]\">";
	for ($n=1; $n <= $c_count; $n++) {
		$sel = ($n == $arr1['order']) ? " selected=\"selected\"" : "";
		$orderc .= "<option value=\"$n\"". $sel .">". $n ."</option>";
	}
	$orderc .= "</select>";
	unset($n);
	$status = ($arr1['flag'] == "0") ? "<font color=\"red\">".$user->lang['F_HIDDEN']."</font>" : "".$user->lang['F_NORMAL']."";
	$template->assign_block_vars('f_block1',array(
		'L_TITLE'		=> '',
		'S_SELECTED'	=> true,
		'U_TITLE'		=> '',));
	$template->assign_block_vars('f_block1.f_block2',array(
		'F_ID'			=> $arr1['id'],
		'F_TYPE'		=> $arr1['type'],
		'F_TITLE'		=> $arr1['question'],
		'F_ANSWER'		=> $arr1['answer'],
		'F_FLAG'		=> $status,
		'F_CATEG'		=> $arr1['categ'],
		'F_ORDER'		=> $orderc,
		));
	$res1 = "SELECT `id`, `type`, `question`, `answer`, `flag`, `categ`, `order`, `bbcode_bitfield`, `bbcode_uid` FROM `".$db_prefix."_faq` WHERE `type`='item' AND `categ`='".$arr1['id']."'ORDER BY `order` ASC;";
	$res3 = $db->sql_query($res1);
	$f_count = $db->sql_numrows($res3);
	$db->sql_freeresult($res1);
	while ($arr2 = $db->sql_fetchrow($res3))
	{
		$orderi = "<select name=\"order[". $arr2['id'] ."]\">";
		for ($ni=1; $ni <= $f_count; $ni++) {
		   $seli = ($ni == $arr2['order']) ? " selected=\"selected\"" : "";
		   $orderi .= "<option value=\"$ni\"". $seli .">". $ni ."</option>";
		}
		$orderi .= "</select>";
		unset($ni);
		if ($arr2['flag'] == "0") $status = "<font color=\"#FF0000\">".$user->lang['F_HIDDEN']."</font>";
		elseif ($arr2['flag'] == "2") $status = "<font color=\"#0000FF\">".$user->lang['F_UPDATED']."</font>";
		elseif ($arr2['flag'] == "3") $status = "<font color=\"#008000\">".$user->lang['F_NEW']."</font>";
		else $status = $user->lang['F_NORMAL'];
		
		$bbcode = false;
		$text = censor_text($arr2['answer']);
		// Instantiate BBCode if need be
		if ($arr2['bbcode_bitfield'])
		{
			include_once('include/bbcode.' . $phpEx);
			$bbcode = new bbcode($arr2['bbcode_bitfield']);
			$bbcode->bbcode_second_pass($text, $arr2['bbcode_uid'], $arr2['bbcode_bitfield']);
		}
		// Parse the message and subject
		$text = bbcode_nl2br($text);
		$text = smiley_text($text);
		
		
		$template->assign_block_vars('f_block1.f_block2.f_block3',array(
			'F_ID'			=> $arr2['id'],
			'F_TYPE'		=> $arr2['type'],
			'F_TITLE'		=> stripslashes($arr2['question']),
			'F_ANSWER'		=> $text,
			'F_FLAG'		=> $status,
			'F_CATEG'		=> $arr2['categ'],
			'F_ORDER'		=> $orderi,
			));
	}
}
$res1 = "SELECT `id`, `type`, `question`, `answer`, `flag`, `categ`, `order` FROM `".$db_prefix."_faq` WHERE `categ` NOT IN (".$orphanc.") ORDER BY `order` ASC;";
$res = $db->sql_query($res1);
$f_count = $db->sql_numrows($res);
$db->sql_freeresult($res1);
while ($arr1 = $db->sql_fetchrow($res))
{
	if ($arr1['flag'] == "0") $status = "<font color=\"#FF0000\">".$user->lang['F_HIDDEN']."</font>";
	elseif ($arr1['flag'] == "2") $status = "<font color=\"#0000FF\">".$user->lang['F_UPDATED']."</font>";
	elseif ($arr1['flag'] == "3") $status = "<font color=\"#008000\">".$user->lang['F_NEW']."</font>";
	else $status = $user->lang['F_NORMAL'];
	$template->assign_block_vars('orphanc',array(
		'F_ID'			=> $arr1['id'],
		'F_TYPE'		=> $arr1['type'],
		'F_TITLE'		=> stripslashes($arr1['question']),
		'F_ANSWER'		=> stripslashes($arr1['answer']),
		'F_FLAG'		=> $status,
		'F_CATEG'		=> $arr1['categ'],
		'F_ORDER'		=> $arr1['order'],
	));
}
echo $template->fetch('admin/faqmanager.html');
		close_out();
?>