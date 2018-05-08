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
** File torrent.php 2018-02-18 14:32:00 joeroberts
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
				$s = "<select name=\"torrent_category\"><option value=\"0\">(".$user->lang['CHOOSE'].")</option>\n";
				$cats = genrelist2();
				foreach ($cats as $cat)
				{
				 $s .= "<optgroup label=\"" . htmlspecialchars($cat["name"]) . "\">";
				 $subcats = $cat['subcategory'];
				
				 if (count($subcats) > 0)
				 {
				 foreach ($subcats as $subcat)
				 {
				 $s .= "<option value=\"" . $subcat["id"] . "\">" . htmlspecialchars($subcat["name"]) . "</option>\n";
				
				 }
				 }
				 $s .= "</optgroup>\n";
				
				}  
				$s .= "</select>\n";
	$template->assign_vars(array(
		'L_TITLE_TABLE'				=> $user->lang['UPLOAD_TABLE'],
		'L_INTRO_TORRENT'			=> $user->lang['INTRO_TORRENT'],
		'L_INTRO_TORRENT_EXP'		=> sprintf($user->lang['INTRO_TORRENT_EXP'], '<br>' . implode('<br>', $site_announce)),
		'ALOW_POSTER'				=> checkaccess("u_add_poster"),
		'ALOW_SCREEN_SHOT'			=> checkaccess("u_add_screen_shots"),
		'ALOW_NFO'					=> checkaccess("u_add_nfo"),
		'S_SMILIES_ALLOWED'			=> checkaccess("u_add_smiles_to_details"),
		'S_MESSAGE'					=> false,
		'S_CAT_SELECT'				=>	$s,
		'S_SHOW_SMILEY_LINK'		=> checkaccess("u_add_smiles_to_details"),
		'S_BBCODE_ALLOWED'			=> checkaccess("u_add_bbcode_details"),
		'T_TEMPLATE_PATH' 			=> 'themes/' . $theme . '/templates',
		'S_BBCODE_QUOTE'			=> checkaccess("u_add_quote_details"),
		'S_BBCODE_IMG'				=> checkaccess("u_add_imgbbcode_details"),
		'S_LINKS_ALLOWED'			=> checkaccess("u_links_in_details"),
		'S_BBCODE_FLASH'			=> checkaccess("u_flash_in_details"),
		'ALOW_NOTIFY'				=> checkaccess("u_upload_notify"),
		'ALOW_HIDE_OWNER'			=> checkaccess("u_hide_torrent_owner"),
		'ALOW_PASSWORD'				=> checkaccess("u_add_password_torrent"),
		'ALOW_ADVANCED'				=> checkaccess("u_advance_upload_setting"),
		'ALOW_RATIO_BUILD'			=> checkaccess("u_apply_ratiobuild"),
		'ALOW_STICKY'				=> checkaccess("u_add_sticky_upload"),
		'ALOW_SHOUT_NEW'			=> checkaccess("u_shout_upload"),
		'ALOW_ATTACHMENTS'			=> checkaccess("u_torrent_attach"),
	));
?>