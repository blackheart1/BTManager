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
** File acp_arcade.php 2018-02-23 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT'))
{
	include_once './../security.php';
	die ("You can't access this file directly");
}
if ($user->user AND(
     $op =="private__chat" ||
	 $op =="getactive" ||
	 $op =="activeusers" ||
	 $op =="more_smiles" ||
	 $op =="view_shout" ||
	 $op =="take_edit_shout_cancel" ||
	 $op =="take_shout" ||
	 $op =="edit_shout" ||
	 $op =="take_delete_shout")) {
        //Update online user list
        $pagename = 'index.php';
        $sqlupdate = "UPDATE ".$db_prefix."_online_users SET last_action = NOW() WHERE id = ".$user->id.";";
        $sqlinsert = "INSERT INTO ".$db_prefix."_online_users VALUES ('".$user->id."','".addslashes($pagename)."', NOW(), NOW())";
        $res = $db->sql_query($sqlupdate);
        if (!$db->sql_affectedrows($res)) $db->sql_query($sqlinsert);
}
function build_shouts($shotuser)
{
global $db_prefix, $user, $db, $shout_config, $template, $btback1, $btback2, $phpEx, $shoutannounce, $config, $theme, $auth;
		include_once('include/function_posting.php');
		include_once('include/message_parser.php');
		include_once('include/class.bbcode.php');
		$shoutannounce = format_comment($shout_config['announce_ment'], false, true);
		parse_smiles($shoutannounce);
		$template->assign_vars(array(
				'SHOUT_WELCOME'				=> $shoutannounce,
				'S_SHOUTBOX_AJAX'			=> true,
				'S_SMILIES_ALLOWED'			=> ($config['allow_smilies'] && $config['auth_smilies_pm'] && checkaccess('u_pm_smilies')) ? true : false,
				'S_SHOW_SMILEY_LINK'		=> ($config['allow_smilies'] && $config['auth_smilies_pm'] && checkaccess('u_pm_smilies')) ? true : false,
				'S_BBCODE_ALLOWED'			=> ($config['allow_bbcode'] && $config['auth_bbcode_pm'] && checkaccess('u_pm_bbcode')) ? true : false,
				'T_TEMPLATE_PATH' 			=> 'themes/' . $theme . '/templates',
				'S_BBCODE_QUOTE'			=> true,
				'MESSAGE'					=>	'[quote]'.addslashes($shoutannounce).'[/quote]',
				'S_BBCODE_IMG'				=> ($config['auth_img_pm'] && checkaccess('u_pm_img')) ? true : false,
				'S_LINKS_ALLOWED'			=> ($config['allow_post_links']) ? true : false,
				'S_BBCODE_FLASH'			=> ($config['auth_flash_pm'] && checkaccess('u_pm_flash')) ? true : false,
				'EDIT_SHOUT'				=>	false,
		));
	$ucs = 0;
	$i = 0;
	$utc2 = $btback1;
	$utc3 = "even";
		if($shotuser > 0){
		$privateonly = "WHERE S.id_to ='".$shotuser."' AND S.user = '".$user->id."' OR  S.id_to ='".$user->id."' AND S.user = '".$shotuser."'";
		}else{
		$privateonly = "WHERE S.id_to ='0' OR S.id_to = '".$user->id."' OR (S.user = '".$user->id."' AND S.id_to  >'0')";
		}
	$sql = "SELECT S.*,
				U.id as uid,
				U.can_do as can_do,
				U.donator AS donator,
				U.warned as warned,
				U.level as level,
				IF(U.name IS NULL, U.username, U.name) as user_name
				FROM ".$db_prefix."_shouts S
				LEFT JOIN ".$db_prefix."_users U
				ON S.user = U.id
				" . $privateonly . "
				ORDER BY  posted
				DESC LIMIT ".$shout_config['shouts_to_show']."";
	$shoutres = $db->sql_query($sql) or btsqlerror($sql);
	$num2s = $db->sql_numrows($shoutres);
		if ($num2s > 0)
				{
					while ($shout = $db->sql_fetchrow($shoutres))
					{
		if ($shout['f'] && !$auth->acl_get('f_read', $shout['f']))
		{
			continue;
		}
						if ($num2s > 1)
						{
						  $ucs++;
						}
						if($ucs%2 == 0)
						{
						  $utc3 = "od";
						  $utc2 = $btback1;
						}
						else
						{
						  $utc3 = "even";
						  $utc2 = $btback2;
						}
						$i++;
						$caneditshout = $candeleteshout = false;
						if ($user->moderator) $caneditshout = $candeleteshout = true;
						if ($user->id == $shout['uid'] AND $shout_config['canedit_on'] =="yes") $caneditshout = true;
						if ($user->id == $shout['uid'] AND $shout_config['candelete_on'] =="yes") $candeleteshout = true;
						//$text = format_comment($shout["text"], false, true, false);
						//parse_smiles($text);
						$bbcode = false;
						$text = censor_text($shout['text']);
						// Instantiate BBCode if need be
						if ($shout['bbcode_bitfield'])
						{
							include_once('include/bbcode.' . $phpEx);
							$bbcode = new bbcode($shout['bbcode_bitfield']);
							$bbcode->bbcode_second_pass($text, $shout['bbcode_uid'], $shout['bbcode_bitfield']);
						}
						// Parse the message and subject
						$text = bbcode_nl2br($text);
						$text = smiley_text($text);
						$quote = preg_replace('/<!-- s(.*?) -->(.*?)<!-- s(.*?) -->/i', ' \\1 ', $shout["text"]);
						$quote = preg_replace('/<!-- m -->(.*?)<!-- m -->/i', ' \\1 ', $quote);
						$zone_offset = $user->timezone + $user->dst;
								$showusername = true;
								$shout_time = gmdate($shout_config['dateformat'], sql_timestamp_to_unix_timestamp($shout['posted'])+$zone_offset);
						if(preg_match("/\/notice (.*)/",$text,$m))
						{
							$text = preg_replace('/\/notice/','',$text);
							$showusername = false;
						}
						if(preg_match("/\/me (.*)/",$text,$m)){
							$text = "<b><font color=\"".getusercolor($shout["can_do"])."\">".htmlspecialchars($shout["user_name"])."</font></b> ".preg_replace('/\/me/','',$text);
							$showusername = false;
						}
						$template->assign_block_vars('shout_var', array(
						'SHOUTID'      => $shout["id"],
						'QUOTE'      => '[quote]'.addslashes(htmlspecialchars(str_replace(':' . $shout['bbcode_uid'],'',$quote))).'[/quote]',
						'SHOUT'      => $text,
						'SHOW_USER'  => $showusername,
						'TIME'       => $shout_time,
						'UID'        => $shout['uid'],
						'U_NAME'     => htmlspecialchars($shout["user_name"]),
						'U_PRVATE_S' => (!$shout['id_to'] =='0') ? $user->lang['PRIVATE_PM'] : '' ,
						'U_DONER'    => ($shout['donator'] == 'true') ? true : false,
						'U_WARNED'   => ($shout["warned"] == "1") ? '<img src="images/warning.gif" title="' . $user->lang['WARNED'] . '" alt="' . $user->lang['WARNED'] . '" />' : '',
						'U_COLOR'    => getusercolor($shout["can_do"]),
						'BACKG'      => $utc2,
						'CLASS'      => $utc3,

						'CLASS_CH'   => $btback2,
						'CAN_ED'     => $caneditshout,
						'CAN_DEL'    => $candeleteshout,
						'CAN_QU'    => $shout_config['can_quote']
						));
                     }
				}
	echo $template->fetch('shout_box.html');
}
if($op == 'getactive')
	{
		$usql = "SELECT id FROM ".$db_prefix."_online_users WHERE page='index.php' AND UNIX_TIMESTAMP( NOW( ) ) - UNIX_TIMESTAMP( last_action )  < 1800";
		$ures = $db->sql_query($usql);
		$utot = $db->sql_numrows($ures);
		print($utot);
	}
if($op == 'view_shout')
	{
		$shotuser			= request_var('shotuser', 0);
		build_shouts($shotuser);
		$db->sql_close();
		die();
	}
if($op == 'edit_shout' OR $op == 'edit_archive_shout')
	{
		$shout_id			= request_var('shout', 0);
		if( !isset( $shout_id ) || !is_numeric($shout_id) )
			{
				error("Invalid torrent!" );
			}
		$sql = "SELECT `text`, `user`, `bbcode_uid` FROM `".$db_prefix."_shouts` WHERE `id` = '".$shout_id."'";
		$res = $db->sql_query($sql) or btsqlerror($sql);
		$shout = $db->sql_fetchrow( $res );
        if ($shout['user'] != $user->id AND !checkaccess("m_edit_others_shouts"))
			{
				error("Invalid permissions!");
			}
					include_once('include/function_posting.php');
					include_once('include/message_parser.php');
					include_once('include/class.bbcode.php');
				$message_parser = new parse_message();
				$shout["text"] = smiley_text($shout["text"],true);
				$message_parser->message = $shout["text"];
				$message_parser->decode_message($shout['bbcode_uid']);
$template->assign_vars(array(
			'EDIT_SHOUT'			=> true,
			'EDIT_TEXT'				=> $message_parser->message,
			'EDIT_ID'				=> $shout_id,
			));
	echo $template->fetch('shout_box.html');
	}
if($op == 'take_delete_shout' || $op =='take_delete_archive_shout')
	{
$shout_id			= (int)request_var('shout', 0);
		if( !isset( $shout_id ) || !is_numeric($shout_id) )
			{
				error("Invalid Shout!" );
			}
		$sql = "SELECT `text`, `user` FROM `".$db_prefix."_shouts` WHERE `id` = '".$shout_id."'";
		$res = $db->sql_query($sql) or btsqlerror($sql);
		$shout = $db->sql_fetchrow( $res );
        if ($shout['user'] != $user->id AND !checkaccess("m_edit_others_shouts")){
			error("Invalid permissions!");
		}
		$db->sql_query("DELETE FROM `".$db_prefix."_shouts` WHERE `".$db_prefix."_shouts`.`id`='".$shout_id."' LIMIT 1");
	}
if($op == 'take_edit_shout')
	{
		$shout_id			= (int)request_var('shout', 0);
		if( !isset( $shout_id ) || !is_numeric($shout_id) )
			{
				error("Invalid torrent!" );
			}
		$shout			= request_var('shout_text', '',true);
		 //$shout = str_replace("op=take_edit_shout&shout=".$shout_id."&shout_text=","",$_SERVER['QUERY_STRING']);
		 $shout = str_replace(array("/amp2/","/amp3/"),array("&","#"),$shout);
				if($shout_config['allow_url'] == "no")$shout = str_links($shout);
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
				$message_parser->message = $shout;
				$bbcode_uid = $message_parser->bbcode_uid;
				$message_parser->parse($enable_bbcode, ($config['allow_post_links']) ? $enable_urls : false, $enable_smilies, $img_status, $flash_status, true, $config['allow_post_links'],true,true,true,'shout');
				$shout = $db->sql_escape(stripslashes($message_parser->message));
		$sql = "SELECT `text`, `user` FROM `".$db_prefix."_shouts` WHERE `id` = '".$shout_id."'";
		$res = $db->sql_query($sql) or btsqlerror($sql);
		$shout2 = $db->sql_fetchrow( $res );
        if ($shout2['user'] != $user->id AND !checkaccess("m_edit_others_shouts")){
		error("Invalid permissions!");
		}
		$upd_sql = "UPDATE `".$db_prefix."_shouts` SET `text` = '".$shout."', bbcode_bitfield = '" . $message_parser->bbcode_bitfield . "', bbcode_uid = '" . $message_parser->bbcode_uid . "' WHERE `id` = '".$shout_id."'";
		$db->sql_query($upd_sql) or btsqlerror($upd_sql);
	}
if($op == 'take_edit_archive_shout')
	{
		$shout_id			= request_var('shout', 0);
		if( !isset( $shout_id ) || !is_numeric($shout_id) )
			{
				error("Invalid torrent!" );
			}
		$shout			= request_var('shout_text', '',true);
		 //$shout = str_replace("op=take_edit_archive_shout&shout=".$_GET['shout']."&shout_text=","",$_SERVER['QUERY_STRING']);
		 $shout = str_replace(array("/amp2/","/amp3/"),array("&","#"),$shout);
					include_once('include/function_posting.php');
					include_once('include/message_parser.php');
					include_once('include/class.bbcode.php');
					include_once('include/bbcode.php');
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
				$message_parser->message = $shout;
				$bbcode_uid = $message_parser->bbcode_uid;
				$message_parser->parse($enable_bbcode, ($config['allow_post_links']) ? $enable_urls : false, $enable_smilies, $img_status, $flash_status, true, $config['allow_post_links']);
				$shout = $db->sql_escape(stripslashes($message_parser->message));
								$shout3 = $shout;
                                parse_smiles($shout3);
			$bbcode3 = new bbcode($message_parser->bbcode_bitfield);
			$bbcode3->bbcode_second_pass($shout3, $message_parser->bbcode_uid, $message_parser->bbcode_bitfield);
		$sql = "SELECT `text`, `user` FROM `".$db_prefix."_shouts` WHERE `id` = '".$shout_id."'";
		$res = $db->sql_query($sql) or btsqlerror($sql);
		$shout2 = $db->sql_fetchrow( $res );
        if ($shout2['user'] != $user->id AND !checkaccess("m_edit_others_shouts")){
		error("Invalid permissions!");
		}
		$upd_sql = "UPDATE `".$db_prefix."_shouts` SET `text` = '".$shout."', bbcode_bitfield = '" . $message_parser->bbcode_bitfield . "', bbcode_uid = '" . $message_parser->bbcode_uid . "' WHERE `id` = '".$shout_id."'";
		$db->sql_query($upd_sql) or btsqlerror($upd_sql);
		echo"	<td class=\"alt1\" id=\"shout_shell_".$shout_id."\" width=\"1%\" align=\"left\">
		
				<div id=\"shout_".$shout_id."\">
				".$shout3."
				</div>
				<div id=\"shout_archive_edit_".$shout_id."\">
				</div>
		
			</td>
		";
	}
if($op == 'take_edit_shout_cancel')
	{
		echo "";
	}
if($op == 'take_shout')
	{
		if($user->can_shout == 'false'){
			echo "YouR shout rights have been banned";
			ob_end_flush();
			$db->sql_close();
			die();
		}
		if (!$user->user) loginrequired("user",true);
		$sendto = request_var('sendto', 0);
		$shout = request_var('text', '',true);
		if (strlen($shout) < 1) return;
		if(isset($sendto)){
			$resend = "sendto=".$sendto."&";
			$sendtable = ", id_to";
			$sendtorow = ", '".$sendto."'";
		}
		else
		{
			$resend = '';
			$sendtable = '';
			$sendtorow = '';
		}
		$shout = str_replace("/amp2/","&",$shout);
		$shout = str_replace("/amp3/","#",$shout);
		$shout = urldecode($shout);
		if ($shout == "/empty" && $user->admin) {
			$db->sql_query("TRUNCATE TABLE ".$db_prefix."_shouts");

			$shout = '/notice The modshout has been truncated by '.$user->name;
		}
		if ($shout == "/prune" && $user->admin) {
			$db->sql_query("TRUNCATE TABLE ".$db_prefix."_shouts");
			$shout = '/notice The modshout has been truncated by '.$user->name;
		}
		if ($shout == "/pruneshout" && $user->admin) {
			$db->sql_query("TRUNCATE TABLE ".$db_prefix."_shouts");
			$shout = '/notice The modshout has been truncated by '.$user->name;
		}
		if(preg_match("/\/deletenotice/",$shout,$matches) && $user->admin) {
			$db->sql_query("DELETE FROM ".$db_prefix."_shouts WHERE text LIKE '%/notice%'");
		}
		if(preg_match("/\/unwarn (.*)/",$shout,$m) && $user->admin)
		{
			$res = $db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE username ='".$db->sql_escape($m[1])."' OR name = '".$db->sql_escape($m[1])."' OR clean_username = '".$db->sql_escape(strtolower($m[1]))."';");
			if (!$res) echo "No Such user found";
			$row = $db->sql_fetchrow($res);
			if($row[id]==0 || $row[id] == "")echo "No Such user found";
			if($row[id] == $user->id)
			{
				echo "You can not unWarn your self";
			}
			else{
				$modcomment = "[ " . gmdate("Y-m-d H:i:s", time()) . " - WARN deleted by " . getusername($user) . " ]\n" . $row['modcomment'];
				$added3 = gmdate("Y-m-d H:i:s", time());
				$msg3 = "Your WARNNING was deleted by " . $user->name . "!";
				$db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES('". $user->id ."', '".$row[id]."', 'WARNNING',  '" . $msg3 . "', NOW())") or btsqlerror();
				$db->sql_query("UPDATE ".$db_prefix."_users SET  modcomment='".$modcomment."', warned='0', warn_kapta='0', warn_hossz='0' WHERE id='".$row[id]."'") or die(mysql_error()); 
				$shout = "/notice $m[1]'s warnning has been removed";
			}
		}
		if(preg_match("/\/warn (.*)/",$shout,$m) && $user->admin)
		{
			$res = $db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE username ='".$db->sql_escape($m[1])."' OR name = '".$db->sql_escape($m[1])."' OR clean_username = '".$db->sql_escape(strtolower($m[1]))."';");
			if (!$res) echo "No Such user found";
			$row = $db->sql_fetchrow($res);
			if($row[id]==0 || $row['id'] == "")echo "No Such user found";
			if($row[id] == $user->id)
			{
			echo "You can not Warn your self";
			}
			if($row['level'] == 'admin')
			{
				echo "This level is expempt You Ars";
			}else{
				$weeks = "unlimited time";
				$warnlength = -1;
				$added2 = (gmdate("Y-m-d H:i:s", time()));
				$modcomment =  "" . gmdate("Y-m-d H:i:s", time()) . " - WARNed for " . $weeks . "  by " . getusername($user) . " - Reason: Shoutbox Warned " . $row['modcomment']."";
				$msg2 = ("You have been WARNNED by " . getusername($user) . " for  " . $weeks . "  with reason: Shoutbox Warned.");
				$db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES('". $user->id ."', '".$row[id]."', 'WARNNING',  '" . $msg2 . "', NOW())") or die(mysql_error());
				$db->sql_query("UPDATE ".$db_prefix."_users SET  modcomment='".$modcomment."', warned='1', warn_kapta='" . strtotime(gmdate("Y-m-d H:i:s", time())) . "', warn_hossz='".$warnlength."' WHERE id= '".$row[id]."'") or die(mysql_error());
				$shout = "/notice $m[1] has been Warned!!";
			}
		}
		if(preg_match("/\/ban (.*) : (.*)/",$shout,$m) && $user->admin) {
			//die($m[1] ." and ".$m[2]);
			if($m[2] == "" || !isset($m[2]))die("no reason given");
			$res = $db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE username ='".$db->sql_escape($m[1])."' OR name = '".$db->sql_escape($m[1])."' OR clean_username = '".$db->sql_escape(strtolower($m[1]))."';");
			if (!$res) echo "No Such user found";
			$row = $db->sql_fetchrow($res);
			if($row[id]==0 || $row[id] == "")echo "No Such user found";
			if($row[id] == $user->id)
			{
				echo "You can not Ban your self";
			}else{
				$sql = "UPDATE ".$db_prefix."_users SET ban = 1, banreason = '".strip_tags($m[2])."' WHERE username = '".$row['username']." AND id NOT IN (1,2,3,4,5)';";
				$db->sql_query($sql) or btsqlerror($sql);
				if($forumshare)forum_ban ($$row['username'], strip_tags($reason_user)); 
				echo "banned ".$m[1]." test";
				$shout = "";
			}
		}
	if(preg_match("/\/unban (.*)/",$shout,$m) && $user->admin) {
		$res = $db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE username ='".$db->sql_escape($m[1])."' OR name = '".$db->sql_escape($m[1])."' OR clean_username = '".$db->sql_escape(strtolower($m[1]))."';");
		if (!$res) echo "No Such user found";
		$row = $db->sql_fetchrow($res);
		if($row[id]==0 || $row[id] == "")echo "No Such user found";
		if($row[id] == $user->id)
		{
			echo "You can not Warn your self";
		}else{
			$db->sql_query("UPDATE ".$db_prefix."_users SET ban = 0, banreason = NULL WHERE id = '".$row['id']."';");
			if($forumshare)forum_unban ($row['id']); 
			echo "unbanned ".$m[1]." test";
			$shout = "";
		}
	}
	if(preg_match("/\/banshout (.*)/",$shout,$m) && $user->admin)
	{
		$res = $db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE username ='".$db->sql_escape($m[1])."' OR name = '".$db->sql_escape($m[1])."' OR clean_username = '".$db->sql_escape(strtolower($m[1]))."';");
		if (!$res) echo "No Such user found";
		$row = $db->sql_fetchrow($res);
		if($row[id]==0 || $row[id] == "")echo "No Such user found";
		if($row[id] == $user->id)
		{
			echo "You can not Warn your self";
		}
		else
		{
						$sql = "UPDATE ".$db_prefix."_users SET can_shout = 'false' WHERE id = '".$row['id']."';";
						if (!$db->sql_query($sql)) btsqlerror($sql);
		}
	}
	if(preg_match("/\/unbanshout (.*)/",$shout,$m) && $user->admin)
	{
		$res = $db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE username ='".$db->sql_escape($m[1])."' OR name = '".$db->sql_escape($m[1])."' OR clean_username = '".$db->sql_escape(strtolower($m[1]))."';");
		if (!$res) echo "No Such user found";
		$row = $db->sql_fetchrow($res);
		if($row[id]==0 || $row[id] == "")echo "No Such user found";
		if($row[id] == $user->id)
		{
		echo "You can not Warn your self";
		}else{
						$sql = "UPDATE ".$db_prefix."_users SET can_shout = 'true' WHERE id = '".$row['id']."';";
						if (!$db->sql_query($sql)) btsqlerror($sql);
		$shout = "/notice $m[1] has been Warned!!";
		}
	}
	if(preg_match("/^\/slapuser (.*)/",$shout,$m)) {
		$shout = "/me Slaps $m[1] ";
	}
	if(preg_match("/^\/pmuser (.*);(.*)/",$shout,$m)) {
		if(!is_numeric($m[1])) $m[1] = getuser($m[1]);
		include_once('include/function_posting.php');
				system_pm($db->sql_escape($m[2]),'Quick Pm From shouts',$m[1],0);
		$shout = '';
	}
	$shout = preg_replace("/^\/warn (.*)/","",$shout);
	$shout = preg_replace("/^\/empty/",'',$shout);
	$shout = preg_replace("/^\/ban (.*)/",'',$shout);
	$shout = preg_replace("/^\/unban (.*)/",'',$shout);
	$shout = preg_replace("/^\/unwarn (.*)/",'',$shout);
	$shout = preg_replace("/^\/prune/",'',$shout);
	$shout = preg_replace("/^\/pruneshout/",'',$shout);
	$shout = preg_replace("/^\/deletenotice/",'',$shout);
	if ($shout == '/help') {
		if($user->admin){
			$shout_config['announce_ment'] .= $user->lang['SHOUT_COMAND_HELP_ADMIN'];
		}else{
			$shout_config['announce_ment'] .= $user->lang['SHOUT_COMAND_HELP_USER'];
		}
		$shout = "";
	}
	if(!$user->admin)
	$shout = preg_replace("/^\/notice/",'',$shout); 

				if($shout_config['allow_url'] == "no")$shout = str_links($shout);
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
					$enable_urls		= ($shout_config['allow_url'] != "no")?true:false;
				$message_parser = new parse_message();
				$message_parser->message = $shout;
				$bbcode_uid = $message_parser->bbcode_uid;
				$message_parser->parse($enable_bbcode, ($config['allow_post_links']) ? $enable_urls : false, $enable_smilies, $img_status, $flash_status, true, $config['allow_post_links'],true,true,true,'shout');
				$shout = $db->sql_escape(stripslashes($message_parser->message));
                if ($shout != "") {
                        $sql = "INSERT INTO ".$db_prefix."_shouts (user, text, bbcode_bitfield, bbcode_uid, posted".$sendtable.") VALUES ('".$user->id."', '".$shout."', '" . $message_parser->bbcode_bitfield . "', '" . $message_parser->bbcode_uid . "', NOW()".$sendtorow.");";
                        $db->sql_query($sql)or btsqlerror($sql);
                }
		build_shouts($sendto);
		$db->sql_close();
		die();
	}
if($op == 'archivedeleteshout')
	{
		$shout_id			= request_var('shout', 0);
		if( !isset( $shout_id ) || !is_numeric($shout_id) )
			{
				error("Invalid torrent!" );
			}
		$sql = "SELECT `text`, `user` FROM `".$db_prefix."_shouts` WHERE `id` = '".$shout_id."'";
		$res = $db->sql_query($sql) or btsqlerror($sql);
		$shout = $db->sql_fetchrow( $res );
		// make sure user is owner of torrent
        if ($shout['user'] != $user->id AND !$user->moderator){
		error("Invalid permissions!");
		}

		$db->sql_query("DELETE FROM `".$db_prefix."_shouts` WHERE `".$db_prefix."_shouts`.`id`='".$shout_id."' LIMIT 1");
		echo "";
}
if($op == 'more_smiles')
	{
		if (!$user->user) loginrequired("user",true);
		        $sql = "SELECT * FROM ".$db_prefix."_smiles ORDER BY id ASC;";
        $smile_res = $db->sql_query($sql);
        if ($db->sql_numrows($smile_res) > 0) {
                $smile_rows = $db->sql_fetchrowset($smile_res);
                echo "<p>";
                foreach ($smile_rows as $smile) {
                        echo " <img src=\"smiles/".$smile["file"]."\" onclick=\"comment_smile('".$smile["code"]."',Shoutform.text);\" border=\"0\" alt=\"".$smile["alt"]."\">\n";
                }
				echo "</p>";
        }
        $db->sql_freeresult($smile_res);
	}
if($op == 'private__chat')
	{
				$shoutannounce = format_comment($shout_config['announce_ment'], false, true);
				parse_smiles($shoutannounce);
				$to					= (int)request_var('to', '0');
				echo "<div class=\"".$utc3."\" onMouseOver=\"this.className='over';\" onMouseOut=\"this.className='$utc3';\"><p class=\"shout\" bgcolor=\"#53B54F\">".$shoutannounce."</p></div>";
				$utc2 = $btback1;
				$sql = "SELECT S.*, U.id as uid, U.can_do as can_do, U.donator AS donator, U.warned as warned, U.level as level, IF(U.name IS NULL, U.username, U.name) as user_name FROM ".$db_prefix."_shouts S LEFT JOIN ".$db_prefix."_users U ON S.user = U.id WHERE S.id_to ='".$to."' AND S.user = '".$user->id."' OR S.user='".$to."' AND S.id_to ='".$user->id."' ORDER BY posted DESC LIMIT ".$shout_config['shouts_to_show'].";";
				$shoutres = $db->sql_query($sql) or btsqlerror($sql);
				$num2s = $db->sql_numrows($shoutres);
				if ($num2s > 0)
					{
						while ($shout = $db->sql_fetchrow($shoutres))
							{
								$donator ='';
								if($shout['donator'] == 'true')$donator ='<img src="images/donator.gif" height="16" width="16" title="donator" alt="donator" />';
								if ($num2s > 1)
									{
										$ucs++;
									}
								if($ucs%2 == 0)
									{
										$utc3 = "od";
										$utc2 = $btback1;
									}
								else
									{
										$utc3 = "even";
										$utc2 = $btback2;
									}
								$i++;
								$caneditshout = false;
								$candeleteshout = false;
								if ($user->moderator) $caneditshout = true;
								if ($user->moderator) $candeleteshout = true;
								if ($user->id == $shout['uid'] AND $shout_config['canedit_on'] =="yes") $caneditshout = true;
								if ($user->id == $shout['uid'] AND $shout_config['candelete_on'] =="yes") $candeleteshout = true;
                                echo "<p>";
								$warn = "";
								$quote = addslashes($shout["text"]);
								$text = format_comment($shout["text"], false, true);
                                parse_smiles($text);
								if($shout["warned"] == "1") $warn = '<img src="images/warning.gif" alt="warned" />';
								$showusername = true;
								$zone_offset = ($user->timezone) + $user->dst;
								$shout_time = gmdate($shout_config['dateformat'], sql_timestamp_to_unix_timestamp($shout['posted'])+$zone_offset);
                                echo "<div class=\"".$utc3."\" onMouseOver=\"this.className='over';\" onMouseOut=\"this.className='$utc3';\"><p class=\"shout\" bgcolor=\"#53B54F\">";
                                if(preg_match("/\/notice (.*)/",$text,$m)){
								$text = preg_replace('/\/notice/','',$text);
								}elseif(preg_match("/\/me (.*)/",$text,$m)){
								$text = preg_replace('/\/me/','',$text);
								echo"<b><span class=\"".$shout['level']."\" ondblclick=\"sndReq('op=private__chat&to=".$shout['uid']."', 'shout_out'); toggleprivate('shout_send','".$shout['uid']."');\"><font color=\"".getusercolor($shout["can_do"])."\">".htmlspecialchars($shout["user_name"])."</font></span></b>:";
								}else{
								echo ($candeleteshout ? "<a ondblclick=\"if(confirm('Delete Shout?')==true)sndReq('op=take_delete_shout&shout=".$shout['id']."', 'shoutTD')\">" . pic("drop.gif","",$user->lang['EDIT']) ."</a>" : "").($caneditshout  ? "<a ondblclick=\"sndReq('op=edit_shout&shout=".$shout['id']."', 'shoutTD')\">" . pic("edit.gif","",$user->lang['EDIT']) ."</a>" : "").($shout_config['bbcode_on'] =="yes" ? "<a onclick=\"comment_smile('[quote=".htmlspecialchars($shout["user_name"])."]".$quote."[/quote]',Shoutform.text);\"><img src=\"images/bbcode/bbcode_quote.gif\" border=\"0\" alt=\"quote\"></a>":"")."[<span class=\"shout_time\">".$shout_time."</span>] <b><span class=\"".$shout['level']."\" ondblclick=\"sndReq('op=private__chat&to=".$shout['uid']."', 'shout_out'); toggleprivate('shout_send','".$shout['uid']."');\"><font color=\"".getusercolor($shout["can_do"])."\">".htmlspecialchars($shout["user_name"])."</font></span></b>".$warn.$donator.": ";
                                }
                                echo str_replace("\n","<br />",$text);
                                echo "</p>";
                                echo "<hr></div></p>\n";
                        }
                }
                $db->sql_freeresult($shoutres);
	}
if($op == 'activeusers')
	{
				$sql = "SELECT O.id AS id, O.page AS page, UNIX_TIMESTAMP(O.logged_in) AS logged_in, IF(U.name IS NULL, U.username, U.name) as name, U.warned AS warned, U.can_do as can_do, U.level AS level, U.Show_online AS Show_online, U.uploaded as uploaded, U.downloaded AS downloaded FROM ".$db_prefix."_online_users O LEFT JOIN ".$db_prefix."_users U ON O.id = U.id WHERE  O.page='index.php' AND UNIX_TIMESTAMP( NOW( ) ) - UNIX_TIMESTAMP( U.lastlogin )  < 1800 ;";
				$res = $db->sql_query($sql);
				$tot = $db->sql_numrows($res);
				$i = 1;
				$simple = "\n<p>";
				$advanced = "<table border=\"1\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">\n";
				$advanced .= "<thead><tr><td><p align=\"center\"><b>".$user->lang['USER_NAME']."</b></p></td><td><p align=\"center\"><b>".$user->lang['RATIO']."</b></p></td><td><p align=\"center\"><b>".$user->lang['CURENT_BROWS']."</b></p></td><td><p align=\"center\"><b>".$user->lang['LOGEDIN_FOR']."</b></p></td></tr></thead>\n<tbody>\n";
				if ($db->sql_numrows($res) == 0) $simple .= $user->lang['NO_USERS_ONLINE'];
				else 
					{
						while ($row = $db->sql_fetchrow($res))
							{
								if($row['Show_online'] !== 'true' AND !$user->admin)continue;
								$simple .= "<a href=\"user.php?op=profile&id=".$row["id"]."\"><font color=\"".getusercolor($row["can_do"])."\">";
								$simple .= htmlspecialchars($row["name"])."</font></a>";
								if ($row["level"] == "premium") $simple .= pic("icon_premium.gif",'','Premium');
								elseif ($row["level"] == "uploader") $simple .= pic("icon_uploader.gif",'','Uploader');
								elseif ($row["level"] == "moderator") $simple .= pic("icon_moderator.gif",'','Moderator');
								elseif ($row["level"] == "admin") $simple .= pic("icon_admin.gif",'','Admin');
								if($row["warned"] == "1") $simple .= '<img src="images/warning.gif" alt="warned" />';
								if ($i < $tot) $simple .= ", ";
								$i++;
								$advanced .= "<tr>";
								$advanced .= "<td><p><a href=\"user.php?op=profile&id=".$row["id"]."\"><font color=\"".getusercolor($row["can_do"])."\">";
								$advanced .= htmlspecialchars($row["name"])."</font></a>";
								if ($row["level"] == "premium") $advanced .= pic("icon_premium.gif",'','holder');
								elseif ($row["level"] == "moderator") $advanced .= pic("icon_moderator.gif",'','holder');
								elseif ($row["level"] == "admin") $advanced .= pic("icon_admin.gif",'','holder');
								if($row["warned"] == "1") $advanced .= '<img src="images/warning.gif" alt="warned" />';
								$advanced .= "</p></td>";
								if ($row["uploaded"] == 0 AND $row["downloaded"] == 0) $ratio = "---";
								elseif ($row["downloaded"] == 0) $ratio = "&infin;";
								else {
										$ratio = $row["uploaded"]/$row["downloaded"];
				
										if ($ratio < 0.1) $ratio = "<font color=\"#ff0000\">" . number_format($ratio, 2) . "</font>";
										elseif ($ratio < 0.2) $ratio = "<font color=\"#ee0000\">" . number_format($ratio, 2) . "</font>";
										elseif ($ratio < 0.3) $ratio = "<font color=\"#dd0000\">" . number_format($ratio, 2) . "</font>";
										elseif ($ratio < 0.4) $ratio = "<font color=\"#cc0000\">" . number_format($ratio, 2) . "</font>";
										elseif ($ratio < 0.5) $ratio = "<font color=\"#bb0000\">" . number_format($ratio, 2) . "</font>";
										elseif ($ratio < 0.6) $ratio = "<font color=\"#aa0000\">" . number_format($ratio, 2) . "</font>";
										elseif ($ratio < 0.7) $ratio = "<font color=\"#990000\">" . number_format($ratio, 2) . "</font>";
										elseif ($ratio < 0.8) $ratio = "<font color=\"#880000\">" . number_format($ratio, 2) . "</font>";
										elseif ($ratio < 0.9) $ratio = "<font color=\"#770000\">" . number_format($ratio, 2) . "</font>";
										elseif ($ratio < 1)   $ratio = "<font color=\"#660000\">" . number_format($ratio, 2) . "</font>";
										else $ratio = "<font color=\"#00FF00\">".  number_format($ratio, 2) . "</font>";
								}
								$advanced .= "<td><p>".$ratio."</p></td>";
								$advanced .= "<td><p>";
								if (defined("_btpage_".$row["page"])) $advanced .= constant("_btpage_".$row["page"]);
								$advanced .= "</p></td>";
								$advanced .= "<td><p>".mkprettytime(time()-$row["logged_in"])."</p></td>";
								$advanced .= "</tr>\n";	
						}
					$simple .="<br><br><p>Legend: Admin <img src=\"themes/".$theme."/pics/icon_admin.gif\" alt=\"holder\">, Moderator<img src=\"themes/".$theme."/pics/icon_moderator.gif\" alt=\"holder\">, Premium<img src=\"themes/".$theme."/pics/icon_premium.gif\" alt=\"holder\"> </p><div style='font-size: 8pt;' align=\"center\"><a href=\"javascript:advanced();\">".$user->lang['ADV_ONLINE_MO']."</a></div>";
						$simple .= "";
				}
			$advanced .= "</tbody></table>\n";
			$db->sql_freeresult($res);

			//Simple mode
			echo "<div id=\"users_simple\" class=\"show\">";
			echo $simple;
			echo "</div>";
			
			//Advanced mode
			echo "<div id=\"users_advanced\" class=\"hide\">";
			echo $advanced;
			echo "<br><p>Legend: Admin <img src=\"themes/".$theme."/pics/icon_admin.gif\" alt=\"holder\">, Moderator<img src=\"themes/".$theme."/pics/icon_moderator.gif\" alt=\"holder\">, Premium<img src=\"themes/".$theme."/pics/icon_premium.gif\" alt=\"holder\"> </p><div style='font-size: 8pt;' align=\"center\"><a href=\"javascript:simple();\">".$user->lang['SEMP_ONLINE_MOD']."</a></div>";
			echo "</div>";
	}
?>