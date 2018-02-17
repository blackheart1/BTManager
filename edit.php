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
*------              �2010 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*--------------------   Sunday, May 17, 2009 1:05 AM   ------------------------*
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 edit.php  2010-02-02 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
require_once("common.php");
include_once('include/function_posting.php');
$user->set_lang('edit',$user->ulanguage);
//die(print_r(request_var('torrent_id', array(0))));
if(!request_var('torrent_id', array(0)))
{
	$id				= request_var('id', 0);
}
else
{
	$id				= request_var('torrent_id', array(0));
}
$template = new Template();
set_site_var($user->lang['T_TITTLE_EDIT']);
if (!$user->user) loginrequired("user");
if (is_array($id))
{
	foreach($id as $item)
	{
		$sql = "SELECT owner,name FROM ".$db_prefix."_torrents WHERE id = '".$item."';";
		$res = $db->sql_query($sql) or btsqlerror($sql);
		if ($db->sql_numrows($res) < 1)
		{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $user->lang['MISSING_FILE'].$item,
				));
				echo $template->fetch('message_body.html');
				close_out();
		}
		list ($owner, $tname) = $db->fetch_array($res);
		$db->sql_freeresult($res);
	}
}
else
{
	$id = intval($id);
	$sql = "SELECT owner,name FROM ".$db_prefix."_torrents WHERE id = '".$id."';";
	$res = $db->sql_query($sql) or btsqlerror($sql);
	if ($db->sql_numrows($res) < 1)
	{
		{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $user->lang['MISSING_FILE'],
				));
				echo $template->fetch('message_body.html');
				close_out();
		}
	}
	list ($owner, $tname) = $db->fetch_array($res);
	$db->sql_freeresult($res);
}
$op				= request_var('op', 'edit');
$banned			= request_var('banned', 'no');
if ($op == "edit" AND $owner == $user->id AND !checkaccess("u_edit_own_torrents"))
{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $user->lang['ERROR_NOT_U_AUTH_EDIT'],
				));
				echo $template->fetch('message_body.html');
				close_out();
} 
if ($op == "delete" AND $owner == $user->id AND !checkaccess("u_delete_own_torrents"))
{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $user->lang['ERROR_NOT_U_AUTH_DELETE'],
				));
				echo $template->fetch('message_body.html');
				close_out();
} 
if ($op == "delete" AND $owner != $user->id AND !checkaccess("m_delete_others_torrents"))
{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $user->lang['ERROR_NOT_M_AUTH_DELETE'],
				));
				echo $template->fetch('message_body.html');
				close_out();
} 
if ($op == "edit" AND $owner != $user->id AND !checkaccess("m_can_edit_others_torrents"))
{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $user->lang['ERROR_NOT_M_AUTH_EDIT'],
				));
				echo $template->fetch('message_body.html');
				close_out();
} 
switch($op) {
        case "admin_delete":
		{
			if (!checkaccess("m_can_edit_others_torrents")) loginrequired("admin");
			if (confirm_box(true))
			{
				foreach ($id as $item)
				{
					$sql = Array();
					$sql[] = "DELETE FROM ".$db_prefix."_snatched WHERE torrent = '".$item."' ;";
					$sql[] = "DELETE FROM ".$db_prefix."_torrents WHERE id = '".$item."' LIMIT 1;";
					$sql[] = "DELETE FROM ".$db_prefix."_files WHERE torrent = '".$item."';";
					$sql[] = "DELETE FROM ".$db_prefix."_peers WHERE torrent = '".$item."';";
					$sql[] = "DELETE FROM ".$db_prefix."_privacy_file WHERE torrent = '".$item."';";
					$sql[] = "DELETE FROM ".$db_prefix."_privacy_backup WHERE torrent = '".$item."';";
					$sql[] = "DELETE FROM ".$db_prefix."_comments WHERE torrent = '".$item."';";
					$sql[] = "DELETE FROM ".$db_prefix."_comments_notify WHERE torrent = '".$item."';";
					$sql[] = "DELETE FROM ".$db_prefix."_seeder_notify WHERE torrent = '".$item."';";
					$sql[] = "DELETE FROM ".$db_prefix."_ratings WHERE torrent = '".$item."';";
					$sql[] = "DELETE FROM ".$db_prefix."_download_completed WHERE torrent = '".$item."';";
					//Are there still Torrent associated to that tracker?
					$tracker_sql = "SELECT tracker FROM ".$db_prefix."_torrents WHERE id = '".$item."';";
					$tracker_res = $db->sql_query($tracker_sql);
					list ($tracker) = $db->fetch_array($tracker_res);
					if ($tracker != "" AND $db->sql_numrows($db->sql_query("SELECT id FROM ".$db_prefix."_torrents WHERE tracker = '".$tracker."';")) <= 1) $sql[] = "DELETE FROM ".$db_prefix."_trackers WHERE url = '".$tracker."';";
					$db->sql_freeresult($tracker_res);
					foreach ($sql as $query) {
						$db->sql_query($query) or btsqlerror($query);
					}
	
					if (file_exists("torrent/".$item.".torrent")) @unlink("torrent/".$item.".torrent");
					if (file_exists("torrent/".$item.".nfo")) @unlink("torrent/".$item.".nfo");
				}
				$template->assign_vars(array(
					'S_SUCCESS'			=> true,
					'S_FORWARD'			=> './admin.php?op=torrent',
					'TITTLE_M'			=> $user->lang['SUCCESS'],
					'MESSAGE'			=> $user->lang['SUCCES_ADMIN_DELETE'],
				));
				echo $template->fetch('message_body.html');
				close_out();
			}
			else
			{
				$hidden = build_hidden_fields(array(
							'op'	=>	$op,
							'torrent_id'	=>	$id,
				));
				confirm_box(false, $user->lang['CONFIRM_OPERATION'], $hidden,'confirm_body.html','edit.php',$gfx_check);
			}
			break;
		}
        case "takeedit":
		{
                $errmsg = Array();
                $post_img = request_var('post_img','',true);
				if($post_img != '')
				{
					if (!preg_match('#^(https?://).*?\.(gif|jpg|jpeg|png)$#i', $post_img, $match))
					{
						 $errmsg[] = $user->lang['ERROR_POSTER_A'];
					}
					elseif (empty($match[2]))
					{
						 $errmsg[] = $user->lang['ERROR_POSTER_B'];
					}
					else
					{
						$post_img = "'" . $db->sql_escape($post_img) . "'";
					}
				}
				else
				{
					$post_img = "NULL";
				}
                $screen1 = request_var('screen1','',true);
				if($screen1 != '')
				{
					if (!preg_match('#^(https?://).*?\.(gif|jpg|jpeg|png)$#i', $screen1, $match))
					{
						 $errmsg[] = $user->lang['ERROR_IMAGEA_A'];
					}
					elseif (empty($match[2]))
					{
						 $errmsg[] = $user->lang['ERROR_IMAGEA_B'];
					}
					else
					{
						$screen1 = "'" . $db->sql_escape($screen1) . "'";
					}
				}
				else
				{
					$screen1 = "NULL";
				}
                $screen2 = request_var('screen2','',true);
				if($screen2 != '')
				{
					if (!preg_match('#^(https?://).*?\.(gif|jpg|jpeg|png)$#i', $screen2, $match))
					{
						 $errmsg[] = $user->lang['ERROR_IMAGEB_A'];
					}
					elseif (empty($match[2]))
					{
						 $errmsg[] = $user->lang['ERROR_IMAGEB_B'];
					}
					else
					{
						$screen2 = "'" . $db->sql_escape($screen2) . "'";
					}
				}
				else
				{
					$screen2 = "NULL";
				}
                $screen3 = request_var('screen3','',true);
				if($screen3 != '')
				{
					if (!preg_match('#^(https?://).*?\.(gif|jpg|jpeg|png)$#i', $screen3, $match))
					{
						 $errmsg[] = $user->lang['ERROR_IMAGEC_A'];
					}
					elseif (empty($match[2]))
					{
						 $errmsg[] = $user->lang['ERROR_IMAGEC_B'];
					}
					else
					{
						$screen3 = "'" . $db->sql_escape($screen3) . "'";
					}
				}
				else
				{
					$screen3 = "NULL";
				}
                $screen4 = request_var('screen4','',true);
				if($screen4 != '')
				{
					if (!preg_match('#^(https?://).*?\.(gif|jpg|jpeg|png)$#i', $screen4, $match))
					{
						 $errmsg[] = $user->lang['ERROR_IMAGED_A'];
					}
					elseif (empty($match[2]))
					{
						 $errmsg[] = $user->lang['ERROR_IMAGED_B'];
					}
					else
					{
						$screen4 = "'" . $db->sql_escape($screen4) . "'";
					}
				}
				else
				{
					$screen4 = "NULL";
				}
				if (count($errmsg) > 0){
					$template->assign_vars(array(
						'S_FORWARD'			=> false,
						'S_ERROR'			=> true,
						'TITTLE_M'			=> $user->lang['BT_ERROR'],
						'MESSAGE'			=> $user->lang['ERROR_EDIT_NOT_SAVED'] . '<br />' . implode("<br />",$errmsg) . '<br/><center><a href="javascript: history.go(-1);">'.$user->lang['BACK'].'</a></center><br />',
					));
					echo $template->fetch('message_body.html');
					close_out();
				 }
                $sql = "SELECT info_hash, owner,save_as FROM ".$db_prefix."_torrents WHERE id = '".$id."';";
                $res = $db->sql_query($sql);
                list ($info_hash, $original_owner,$save_as) = $db->fetch_array($res);
                $infohash_hex = preg_replace_callback('/./s', "hex_esc", str_pad($torrent["info_hash"],20));
                $db->sql_freeresult($res);
                $category = intval($torrent_category);
                if ($category < 1) $errmsg[] = $user->lang['ERROR_NO_CAT_SELECTED'];
                $nf = $_FILES["nfox"];
                $nfname = unesc($nf["name"]);
                if ($nfname != "")
				{
					if (!is_filename($nfname)) $errmsg[] = $user->lang['ERROR_INVALID_NFO_NAME'];
					if (!preg_match('/^(.+)\.nfo$/si', $nfname)) $errmsg[] = $user->lang['ERROR_NOT_NFO'];
					if (!is_uploaded_file($nf["tmp_name"])) $errmsg[] = $user->lang['ERROR_UPLOADING_NFO'];
					if ($nf["size"] <= 0) $errmsg[] = $user->lang['ERROR_EMPTY_NFO'];
                }
                $cats = catlist();
                $in_cat = false;
                while ($cat = each($cats) AND !$in_cat) {
                        if ($category == $cat[1]["id"]) $in_cat = true;
                }
                if (!$in_cat) $errmsg[] = $user->lang['ERROR_INVALID_CAT'];
                $descr = request_var('descr','',true);
				if($descr == '')
				{
					$errmsg[] = $user->lang['ERROR_DECRP_IS_BLANK'];
				}
				if (count($errmsg) > 0){
					$template->assign_vars(array(
						'S_FORWARD'			=> false,
						'S_ERROR'			=> true,
						'TITTLE_M'			=> $user->lang['BT_ERROR'],
						'MESSAGE'			=> $user->lang['ERROR_EDIT_NOT_SAVED'] . '<br />' . implode("<br />",$errmsg) . '<br/><center><a href="javascript: history.go(-1);">'.$user->lang['BACK'].'</a></center><br />',
					));
					echo $template->fetch('message_body.html');
					close_out();
				 }
                $nfopath = $torrent_dir."/".$id.".nfo";
                if (!empty($nfname))
				{
					@unlink($nfopath);
					move_uploaded_file($nf["tmp_name"],$nfopath);
                }
				if($evidence == "") $evidence = 'no';
				else $evidence = 'yes';
				$password = htmlspecialchars(request_var('password','',true));
                if ($password == "") $password = "NULL";
				else
				$password = "'" . $db->sql_escape($password) . "'";
				$namex = utf8_normalize_nfc(request_var('namex','',true));
				if ($namex == ""){
					$namex = $save_as;
				}
				else
				{
					$namex = $db->sql_escape($namex);
				}
                $ownertype = intval($ownertype);
                if ($ownertype == 2) {
                        $owner = 0;
                        $sql = "DELETE FROM ".$db_prefix."_privacy_global WHERE torrent = '".$id."';";
                        $db->sql_query($sql) or btsqlerror($sql);
                        $sql = "DELETE FROM ".$db_prefix."_privacy_file WHERE torrent = '".$id."';";
                        $db->sql_query($sql) or btsqlerror($sql);
                        $sql = "DELETE FROM ".$db_prefix."_privacy_backup WHERE torrent = '".$id."';";
                        $db->sql_query($sql) or btsqlerror($sql);

                }
                else $owner = $original_owner;
                $banned = request_var('banned','no');
                $nuked = request_var('nuked','no');
                $nukereason = utf8_normalize_nfc(request_var('nukereason','',true));
                $nukereason = $db->sql_escape($nukereason);
                $evidence = request_var('evidence','no');
				if($evidence == 'yes')$evidence = 1;
				else
				$evidence = 0;
                $imdblink = request_var('imdblink','');
				
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
				$message_parser->message = $descr;
				$bbcode_uid = $message_parser->bbcode_uid;
				$message_parser->parse($enable_bbcode, ($config['allow_post_links']) ? $enable_urls : false, $enable_smilies, $img_status, $flash_status, true, $config['allow_post_links']);

               #Build data base changes
			   $sql = "UPDATE ".$db_prefix."_torrents 
			   			SET 
							name = '".$namex."', 
							descr = '".$db->sql_escape($message_parser->message)."', 
							bbcode_bitfield = '".$message_parser->bbcode_bitfield."', 
							bbcode_uid = '".$message_parser->bbcode_uid."', 
							category = '".$torrent_category."', 
							ownertype = '".$ownertype."', 
							owner = '".$owner."', 
							password = ".$password.", 
							banned = '".$banned."', 
							nuked = '".$nuked."', 
							ratiobuild = '".$build."', 
							nukereason ='".$nukereason."', 
							evidence = '".$evidence."', 
							imdb = '".$imdblink."', 
							post_img = ".$post_img.", 
							screan1 = ".$screen1.", 
							screan2 = ".$screen2.", 
							screan3 = ".$screen3.", 
							screan4 = ".$screen4." 
						WHERE 
							id = '".$id."';";
					#Apply changes to the data base
					//die($sql);
                $db->sql_query($sql) or btsqlerror($sql);
						meta_refresh(5, $siteurl . '/details.php?id=' . $id);
						$template->assign_vars(array(
								'S_SUCCESS'				=> true,
								'S_FORWARD'				=> false,
								'TITTLE_M'				=> $user->lang['EDITED'],
								'MESSAGE'				=> $user->lang['EDITED_EXP'].back_link('./details.php?id=' . $id),
						));
					echo $template->fetch('message_body.html');
					close_out();
                break;
        }
        case "edit": {
					
					include_once('include/function_posting.php');
					include_once('include/message_parser.php');
					include_once('include/class.bbcode.php');
                $sql = "SELECT * FROM ".$db_prefix."_torrents WHERE id = '".$id."';";
                $res = $db->sql_query($sql);
                $row = $db->sql_fetchrow($res);
                $db->sql_freeresult($res);
					$message_parser = new parse_message();
					$row["descr"] = smiley_text($row["descr"],true);
					$message_parser->message = $row["descr"];
					$message_parser->decode_message($row['bbcode_uid']);
					generate_smilies('inline', 0);
					$num_predefined_bbcodes = 22;
					$s_pm_icons = false;
				$sql = 'SELECT bbcode_id, bbcode_tag, bbcode_helpline
					FROM '.$db_prefix.'_bbcodes
					WHERE display_on_posting = 1
					ORDER BY bbcode_tag';
				$result = $db->sql_query($sql);
			
				$i = 0;
				while ($rows = $db->sql_fetchrow($result))
				{
					// If the helpline is defined within the language file, we will use the localised version, else just use the database entry...
					if (isset($user->lang[strtoupper($rows['bbcode_helpline'])]))
					{
						$rows['bbcode_helpline'] = $user->lang[strtoupper($rows['bbcode_helpline'])];
					}
			
					$template->assign_block_vars('custom_tags', array(
						'BBCODE_NAME'		=> "'[" . $rows['bbcode_tag'] . "]', '[/" . str_replace('=', '', $rows['bbcode_tag']) . "]'",
						'BBCODE_ID'			=> $num_predefined_bbcodes + ($i * 2),
						'BBCODE_TAG'		=> $rows['bbcode_tag'],
						'BBCODE_HELPLINE'	=> $rows['bbcode_helpline'],
						'A_BBCODE_HELPLINE'	=> str_replace(array('&amp;', '&quot;', "'", '&lt;', '&gt;'), array('&', '"', "\'", '<', '>'), $rows['bbcode_helpline']),
					));
			
					$i++;
				}
				$db->sql_freeresult($result);
				$tname = $row["name"];
				$tname =str_replace('"', "'", $tname);
				$hide = array('op'=>'takeedit','id'=>$id); 
                $ownertype = "<select name=\"ownertype\">\n";
                $ownertype .= "<option value=\"0\" " . (($row["ownertype"] == 0)?"checked=\"checked\"":'') . ">".$user->lang['SHOW_USER']."</option>\n";
                $ownertype .= "<option value=\"1\" " . (($row["ownertype"] == 1)?"checked=\"checked\"":'') . ">".$user->lang['PRIVACY_MODE']."</option>\n";
                $ownertype .= "<option value=\"2\" >".$user->lang['STEALTH_MODE']."</option>\n";
                $ownertype .= "</select>\n";
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
							$s .= "<option value=\"" . $subcat["id"] . "\" ";
										if ($subcat["id"] == $row["category"]) $s .= "selected";
										$s .= ">" . htmlspecialchars($subcat["name"]) . "</option>\n";
						}
					}
					$s .= "</optgroup>\n";
				}  
				$s .= "</select>\n";
				$template->assign_vars(array(
						'U_ACTION'					=>	'./edit.php',
						'ACTION'					=>	'torrent',
						'MODMODE'					=>	checkaccess("m_can_edit_others_torrents"),
						'S_SHOW_PM_ICONS'			=> false,
						'S_SMILIES_ALLOWED'			=> ($config['allow_smilies'] && $config['auth_smilies_pm'] && checkaccess('u_pm_smilies')) ? true : false,
						'S_SHOW_SMILEY_LINK'		=> ($config['allow_smilies'] && $config['auth_smilies_pm'] && checkaccess('u_pm_smilies')) ? true : false,
						'S_BBCODE_ALLOWED'			=> ($config['allow_bbcode'] && $config['auth_bbcode_pm'] && checkaccess('u_pm_bbcode')) ? true : false,
						'T_TEMPLATE_PATH' 			=> 'themes/' . $theme . '/templates',
						'S_BBCODE_QUOTE'			=> true,
						'S_BBCODE_IMG'				=> ($config['auth_img_pm'] && checkaccess('u_pm_img')) ? true : false,
						'S_LINKS_ALLOWED'			=> ($config['allow_post_links']) ? true : false,
						'S_BBCODE_FLASH'			=> ($config['auth_flash_pm'] && checkaccess('u_pm_flash')) ? true : false,
						'HIDDEN'					=>	build_hidden_fields($hide),
						'E_NAME'					=>	$tname,
						'E_IMDB'					=>	$row["imdb"],
						'E_POSTER'					=>	$row["post_img"],
						'E_SCRA'					=>	$row["screan1"],
						'E_SCRB'					=>	$row["screan2"],
						'E_SCRC'					=>	$row["screan3"],
						'E_SCRD'					=>	$row["screan4"],
						'BANNED'					=>	($row["banned"] == "yes")?true:false,
						'BUILD'						=>	($row["ratiobuild"] == "yes")?true:false,
						'NUKED'						=>	($row["nuked"] == "yes")?true:false,
						'E_DISC'					=>	$message_parser->message,
						'O_CAT_SELECT'				=>	$s,
						'EVIDENT'					=>	($row["evidence"] == 1)?true:false,
						'PRIVATE_SEL'				=>	$ownertype,
						'E_PASS'					=>	$row["password"],
						'E_NUKE_REASON'				=>	$row["nukereason"],
				));
				echo $template->fetch('edit_body.html');
				close_out();
                break;
        }

	case "ban": {
		if (!checkaccess('m_bann_torrents'))
		{
					$template->assign_vars(array(
						'S_FORWARD'			=> false,
						'S_ERROR'			=> true,
						'TITTLE_M'			=> $user->lang['BT_ERROR'],
						'MESSAGE'			=> $user->lang['ERROR_NOT_M_AUTHE_BAN'],
					));
					echo $template->fetch('message_body.html');
					close_out();
		}
		if (confirm_box(true))
		{
			if (!is_numeric($id)) bterror($user->lang['ERROR_EDIT_NOT_SAVED'],$user->lang['BT_ERROR']);
			$sql = "UPDATE ".$db_prefix."_torrents SET banned = 'yes' WHERE id = '".$id."';";
			$db->sql_query($sql) or btsqlerror($sql);
			meta_refresh(5, $siteurl . '/index.php');
					$template->assign_vars(array(
						'S_FORWARD'			=> false,
						'S_SUCCESS'			=> true,
						'TITTLE_M'			=> $user->lang['SUCCESS'],
						'MESSAGE'			=> $user->lang['TORRENT_BANNED'],
					));
					echo $template->fetch('message_body.html');
					close_out();
		}
		else
		{
			$hidden = build_hidden_fields(array(
						'op'	=>	$op,
						'id'	=>	$id,
			));
			confirm_box(false, $user->lang['CONFERM_BAN'], $hidden,'confirm_body.html','edit.php',$gfx_check);
		}
			meta_refresh(5, $siteurl . '/index.php');
					$template->assign_vars(array(
						'S_FORWARD'			=> false,
						'S_SUCCESS'			=> true,
						'TITTLE_M'			=> $user->lang['SUCCESS'],
						'MESSAGE'			=> $user->lang['TORRENT_BANNED_CANCEL'],
					));
					echo $template->fetch('message_body.html');
					close_out();
		break;        
	}

        case "delete": {
				if (confirm_box(true))
				{
                        $sql = Array();
                        $sql[] = "DELETE FROM ".$db_prefix."_snatched WHERE torrent = '".$id."' ;";
                        $sql[] = "DELETE FROM ".$db_prefix."_torrents WHERE id = '".$id."' LIMIT 1;";
                        $sql[] = "DELETE FROM ".$db_prefix."_files WHERE torrent = '".$id."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_peers WHERE torrent = '".$id."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_privacy_file WHERE torrent = '".$id."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_privacy_backup WHERE torrent = '".$id."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_comments WHERE torrent = '".$id."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_comments_notify WHERE torrent = '".$id."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_seeder_notify WHERE torrent = '".$id."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_ratings WHERE torrent = '".$id."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_download_completed WHERE torrent = '".$id."';";

                        //Are there still Torrent associated to that tracker?
                        $tracker_sql = "SELECT tracker FROM ".$db_prefix."_torrents WHERE id = '".$id."';";
                        $tracker_res = $db->sql_query($tracker_sql);
                        list ($tracker) = $db->fetch_array($tracker_res);
                        if ($tracker != "" AND $db->sql_numrows($db->sql_query("SELECT id FROM ".$db_prefix."_torrents WHERE tracker = '".$tracker."';")) <= 1) $sql[] = "DELETE FROM ".$db_prefix."_trackers WHERE url = '".$tracker."';";
                        $db->sql_freeresult($tracker_res);
                        foreach ($sql as $query) {
                                $db->sql_query($query) or btsqlerror($query);
                        }

                        if (file_exists("torrent/".$id.".torrent")) @unlink("torrent/".$id.".torrent");
                        if (file_exists("torrent/".$id.".nfo")) @unlink("torrent/".$id.".nfo");
					$template->assign_vars(array(
						'S_FORWARD'			=> false,
						'S_SUCCESS'			=> true,
						'TITTLE_M'			=> $user->lang['SUCCESS'],
						'MESSAGE'			=> $user->lang['TORRENT_DELETE'],
					));
					echo $template->fetch('message_body.html');
					close_out();
				}
				else
				{
					$hidden = build_hidden_fields(array(
								'op'	=>	$op,
								'id'	=>	$id,
					));
					confirm_box(false, $user->lang['CONFERM_DELETE'], $hidden,'confirm_body.html','edit.php',$gfx_check);
				}
				meta_refresh(5, $siteurl . '/index.php');
					$template->assign_vars(array(
						'S_FORWARD'			=> false,
						'S_SUCCESS'			=> true,
						'TITTLE_M'			=> $user->lang['SUCCESS'],
						'MESSAGE'			=> $user->lang['TORRENT_DELETE_CANCEL'],
					));
					echo $template->fetch('message_body.html');
					close_out();
        }
}
?>