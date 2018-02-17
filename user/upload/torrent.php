<?php
/*
*----------------------------phpMyBitTorrent V 3.0.0---------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
*-------------------   And Joe Robertson (aka joeroberts)   -------------------*
*-------------               http://www.p2pmania.it               -------------*
*------------ Based on the Bit Torrent Protocol made by Bram Cohen ------------*
*-------------              http://www.bittorrent.com             -------------*
*------------------------------------------------------------------------------*
*------------------------------------------------------------------------------*
*--   This program is free software; you can redistribute it and/or modify   --*
*--   it under the terms of the GNU General Public License as published by   --*
*--   the Free Software Foundation; either version 2 of the License, or      --*
*--   (at your option) any later version.                                    --*
*--                                                                          --*
*--   This program is distributed in the hope that it will be useful,        --*
*--   but WITHOUT ANY WARRANTY; without even the implied warranty of         --*
*--   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the          --*
*--   GNU General Public License for more details.                           --*
*--                                                                          --*
*--   You should have received a copy of the GNU General Public License      --*
*--   along with this program; if not, write to the Free Software            --*
*-- Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA --*
*--                                                                          --*
*------------------------------------------------------------------------------*
*------              ©2010 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*--------------------   Sunday, May 17, 2009 1:05 AM   ------------------------*
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 upload/torrent.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
					
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
						'BBCODE_TAG'		=> $row['bbcode_tag'],
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
		'L_INTRO_TORRENT_EXP'		=> sprintf($user->lang['INTRO_TORRENT_EXP'],$announce_url),
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