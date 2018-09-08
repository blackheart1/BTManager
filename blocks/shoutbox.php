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
** File shoutbox.php 2018-02-18 14:32:00 joeroberts
**
** CHANGES
**
** 04-16-2018 Added Language
**/
if (!defined('IN_PMBT'))
{
	include_once './../security.php';
    die ('Error 404 - Page Not Found');
}
global $db_prefix, $user, $db, $shout_config,$template,$btback1,$btback2, $phpEx, $config,$pmbt_cache, $auth;
if($shout_config['turn_on']=='yes')
{
		$user->set_lang('shouts',$user->ulanguage);
		include_once('include/function_posting.php');
		include_once('include/message_parser.php');
		include_once('include/class.bbcode.php');
		$shoutannounce = format_comment($shout_config['announce_ment'], false, true);
		parse_smiles($shoutannounce);
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
		$template->assign_vars(array(
						'SHOUT_WELCOME'            => $shoutannounce,
						'S_SHOUTBOX_AJAX'		   => false,
						'S_SMILIES_ALLOWED'			=> ($config['allow_smilies'] && $config['auth_smilies_pm'] && checkaccess('u_pm_smilies')) ? true : false,
						'S_SHOW_SMILEY_LINK'		=> ($config['allow_smilies'] && $config['auth_smilies_pm'] && checkaccess('u_pm_smilies')) ? true : false,
						'S_BBCODE_ALLOWED'			=> ($config['allow_bbcode'] && $config['auth_bbcode_pm'] && checkaccess('u_pm_bbcode')) ? true : false,
						'T_TEMPLATE_PATH' 			=> 'themes/' . $theme . '/templates',
						'S_BBCODE_QUOTE'			=> true,
						'MESSAGE'					=>	addslashes($shoutannounce),
						'S_BBCODE_IMG'				=> ($config['auth_img_pm'] && checkaccess('u_pm_img')) ? true : false,
						'S_LINKS_ALLOWED'			=> ($config['allow_post_links']) ? true : false,
						'S_BBCODE_FLASH'			=> ($config['auth_flash_pm'] && checkaccess('u_pm_flash')) ? true : false,
						'EDIT_SHOUT'				=>	false,
		));
		$ucs = 0;
		$i = 0;
		$utc2 = $btback1;
		$utc3 = "even";
                $sql = "SELECT S.*, U.id as uid, U.can_do as can_do, U.donator AS donator, U.warned as warned, U.level as level, IF(U.name IS NULL, U.username, U.name) as user_name, L.group_colour as coulor FROM ".$db_prefix."_shouts S LEFT JOIN ".$db_prefix."_users U ON S.user = U.id LEFT JOIN ".$db_prefix."_level_settings L ON U.can_do = L.group_id WHERE S.id_to = '0' OR S.id_to = '".$user->id."' OR (S.user = '".$user->id."' AND S.id_to  >'0')  ORDER BY  posted DESC LIMIT ".$shout_config['shouts_to_show']."";
                $shoutres = $db->sql_query($sql) or btsqlerror($sql);
                $num2s = $db->sql_numrows($shoutres);
                if ($num2s > 0) {
                        while ($shout = $db->sql_fetchrow($shoutres)) {
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
		$zone_offset = ($user->timezone) + $user->dst;
								$showusername = true;
								$shout_time = gmdate($shout_config['dateformat'], sql_timestamp_to_unix_timestamp($shout['posted'])+$zone_offset);
                                if(preg_match("/\/notice (.*)/",$text,$m)){
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
					'U_WARNED'   => ($shout["warned"] == "1") ? '<img src="images/warning.gif" title="warned" alt="warned" />' : '',
					'U_COLOR'    => '#' . $shout["coulor"],
					'BACKG'      => $utc2,
					'CLASS'      => $utc3,
					'CLASS_CH'   => $btback2,
					'CAN_ED'     => $caneditshout,
					'CAN_DEL'    => $candeleteshout,
					'CAN_QU'    => $shout_config['can_quote']
                	));
                     }
                }
				$db->sql_freeresult($shoutres);
echo $template->fetch('shout_box.html');
}				
?>