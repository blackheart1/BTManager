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
* @version $Id: 3.0.0 settings.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
		include_once('include/function_posting.php');
		include_once('include/message_parser.php');
		include_once('include/class.bbcode.php');
$user->set_lang('admin/site_settings',$user->ulanguage);
$cfgquery = "SELECT * FROM ".$db_prefix."_config;";
$cfgres = $db->sql_query($cfgquery);
$cfgrow = $db->sql_fetchrow($cfgres);
if(isset($cfgrow['announce_url']))$cfgrow['announce_url'] = implode("\n",unserialize($cfgrow['announce_url']));
$db->sql_freeresult($cfgres);
		$op						= request_var('op', '');
		$action					= request_var('action', 'setting');
		$mode					= request_var('mode', $action);
		$u_action				= 'admin.php?i=siteinfo&op=settings&action=' . $action;
							$template->assign_block_vars('l_block1.l_block2',array(
							'L_TITLE'		=> $user->lang['SITE_SETTINGS'],
							'S_SELECTED'	=> true,
							'U_TITLE'		=> '1',));
							$template->assign_block_vars('l_block1.l_block2.l_block3',array(
							'S_SELECTED'	=> ('settings' ==$op)? true:false,
							'IMG' => '',
							'L_TITLE' => $user->lang['MENU_SETTINGS'],
							'U_TITLE' => append_sid("{$siteurl}/admin.$phpEx", 'i=siteinfo&amp;op=settings'),
							));
							$template->assign_block_vars('l_block1.l_block2.l_block3',array(
							'S_SELECTED'	=> ('settings_pm' ==$op)? true:false,
							'IMG' => '',
							'L_TITLE' => $user->lang['MENU_PRIVATE_MESSAGE'],
							'U_TITLE' => append_sid("{$siteurl}/admin.$phpEx", 'i=siteinfo&amp;op=settings_pm'),
							));
							$template->assign_block_vars('l_block1.l_block2.l_block3',array(
							'S_SELECTED'	=> ('settings_bbcode' ==$op)? true:false,
							'IMG' => '',
							'L_TITLE' => $user->lang['MENU_BBCODE'],
							'U_TITLE' => append_sid("{$siteurl}/admin.$phpEx", 'i=siteinfo&amp;op=settings_bbcode'),
							));
							$template->assign_block_vars('l_block1.l_block2.l_block3',array(
							'S_SELECTED'	=> ('sig_settings' ==$op)? true:false,
							'IMG' => '',
							'L_TITLE' => $user->lang['MENU_SIG_SETTINGS'],
							'U_TITLE' => append_sid("{$siteurl}/admin.$phpEx", 'i=siteinfo&amp;op=sig_settings'),
							));
							$template->assign_block_vars('l_block1.l_block2.l_block3',array(
							'S_SELECTED'	=> ('acp_email' ==$op)? true:false,
							'IMG' => '',
							'L_TITLE' => $user->lang['ACP_EMAIL_SETTINGS'],
							'U_TITLE' => append_sid("{$siteurl}/admin.$phpEx", 'i=siteinfo&amp;op=acp_email'),
							));
							$template->assign_block_vars('l_block1.l_block2.l_block3',array(
							'S_SELECTED'	=> ('attach' ==$action)? true:false,
							'IMG' => '',
							'L_TITLE' => $user->lang['ACP_ATTACHMENT_SETTINGS'],
							'U_TITLE' => append_sid($u_action, 'action=attach'),
							));
							$template->assign_block_vars('l_block1.l_block2.l_block3',array(
							'S_SELECTED'	=> ('extensions' ==$action)? true:false,
							'IMG' => '',
							'L_TITLE' => $user->lang['ACP_MANAGE_EXTENSIONS'],
							'U_TITLE' => append_sid($u_action, 'action=extensions'),
							));
							$template->assign_block_vars('l_block1.l_block2.l_block3',array(
							'S_SELECTED'	=> ('ext_groups' ==$action)? true:false,
							'IMG' => '',
							'L_TITLE' => $user->lang['ACP_EXTENSION_GROUPS'],
							'U_TITLE' => append_sid($u_action, 'action=ext_groups'),
							));
							$template->assign_block_vars('l_block1.l_block2.l_block3',array(
							'S_SELECTED'	=> ('orphan' ==$action)? true:false,
							'IMG' => '',
							'L_TITLE' => $user->lang['ACP_ORPHAN_ATTACHMENTS'],
							'U_TITLE' => append_sid($u_action, 'action=orphan'),
							));
if($op == 'acp_email')
{
	if (isset($_REQUEST['mode']) && is_array($_REQUEST['mode']))
	{
		$mode = request_var('mode', array(''));
		list($mode, ) = each($mode);
	}
	else
	{
		$mode = request_var('mode', 'email');
	}
	include 'admin/files/acp_email.php';
	include_once($phpbb_root_path . 'include/modules.' . $phpEx);
	$module = new acp_email();
	$module->module =  'acp_email';
	$module->main('',$action);
	echo $template->fetch('admin/' . $module->tpl_name . '.html');
	close_out();
}
if($op == 'settings_pm')
{
	include 'admin/files/advance_settings.php';
}
if($op == 'sig_settings')
{
	include 'admin/files/sig_settings.php';
}
if($op == 'settings_bbcode')
{
	include 'admin/files/settings_bbcode.php';
}
	switch ($action)
	{
		case 'imgmagick':
		$mode = 'attach';
		case 'edit':
		case 'add':
		$mode = 'ext_groups';
		case 'attach':
		case 'extensions':
		case 'ext_groups':
		case 'orphan':
		require_once("include/auth.php");
		require_once("admin/files/acp_attachments.php");
		include_once($phpbb_root_path . 'include/modules.' . $phpEx);
			$auth = new auth();
			$auth->acl($user);
			$admin_role = new acp_attachments();
			$admin_role->u_action = $u_action;
				$template->assign_vars(array(
					'U_ACTION'			=> '/admin.php?op=levels&i=userinfo&action=' . $action,
					'ICON_MOVE_DOWN'	=> $user->img('icon_down', 'NEW_POST'),
					'ICON_MOVE_UP'	=> $user->img('icon_up', 'NEW_POST'),
					'ICON_MOVE_UP_DISABLED'	=> $user->img('icon_up', 'NEW_POST'),
					'ICON_MOVE_DOWN_DISABLED'	=> $user->img('icon_down', 'NEW_POST'),
					'ICON_EDIT'	=> $user->img('icon_edit', 'NEW_POST'),
					'ICON_DELETE'	=> $user->img('icon_delete', 'NEW_POST'),)
				);
		$action					= request_var('action_i', $action);
			$admin_role->main('',$mode);
			echo $template->fetch('admin/' . $admin_role->tpl_name . '.html');
			close_out();
		break;
		case 'setting':
			if ($op == "savesettings")
			{
				//First I create the two SQL arrays
				$params = Array();
				$values = Array();
				$sub_sitename					= request_var('sub_sitename', '');
				$sub_siteurl					= request_var('sub_siteurl', '');
				$sub_cookiedomain				= request_var('sub_cookiedomain', '');
				$sub_time_zone					= request_var('sub_time_zone', '');
				$sub_cookiepath					= request_var('sub_cookiepath', '');
				$sub_sourcedir					= request_var('sub_sourcedir', '');
				$sub_admin_email				= request_var('sub_admin_email', '');
				$sub_language					= request_var('sub_language', '');
				$sub_theme						= request_var('sub_theme', '');
				$sub_welcome_message			= request_var('sub_welcome_message', '',true);
				$sub_off_line_mess				= request_var('sub_off_line_mess','');
				$sub_announce_text				= request_var('sub_announce_text', '');
				$sub_allow_html					= request_var('sub_allow_html', '');
				$sub_rewrite_engine				= request_var('sub_rewrite_engine', '');
				$sub_torrent_prefix				= request_var('sub_torrent_prefix', '');
				$sub_onlysearch					= request_var('sub_onlysearch', '');
				$sub_on_line					= request_var('sub_on_line', '');
				$sub_max_torrent_size			= request_var('sub_max_torrent_size', '');
				$sub_announce_interval			= request_var('sub_announce_interval', '');
				$sub_announce_interval_min		= request_var('sub_announce_interval_min', '');
				$sub_dead_torrent_interval		= request_var('sub_dead_torrent_interval', '');
				$sub_minvotes					= request_var('sub_minvotes', '');
				$sub_time_tracker_update		= request_var('sub_time_tracker_update', '');
				$sub_give_sign_up_credit		= request_var('sub_give_sign_up_credit', '');
				$sub_best_limit					= request_var('sub_best_limit', '');
				$sub_down_limit					= request_var('sub_down_limit', '');
				$sub_allow_change_email			= request_var('sub_allow_change_email', '');
				$sub_torrent_complaints			= request_var('sub_torrent_complaints', '');
				$sub_torrent_global_privacy		= request_var('sub_torrent_global_privacy', '');
				$sub_disclaimer_check			= request_var('sub_disclaimer_check', '');
				$sub_gfx_check					= request_var('sub_gfx_check', '');
				$sub_Public_Key					= request_var('sub_Public_Key', '');
				$sub_Private_Key				= request_var('sub_Private_Key', '');
				$sub_recap_https				= request_var('sub_recap_https', '');
				$sub_upload_level				= request_var('sub_upload_level', '');
				$sub_download_level				= request_var('sub_download_level', '');
				$sub_pivate_mode				= request_var('sub_pivate_mode', '');
				$sub_force_passkey				= request_var('sub_force_passkey', '');
				$sub_announce_level				= request_var('sub_announce_level', '');
				$sub_max_num_file				= request_var('sub_max_num_file', '');
				$sub_max_share_size				= request_var('sub_max_share_size', '');
				$sub_min_size_seed				= request_var('sub_min_size_seed', '');
				$sub_min_share_seed				= request_var('sub_min_share_seed', '');
				$sub_global_min_ratio			= request_var('sub_global_min_ratio', '');
				$sub_autoscrape					= request_var('sub_autoscrape', '');
				$sub_conferm_email				= request_var('sub_conferm_email', '');
				$sub_min_num_seed_e				= request_var('sub_min_num_seed_e', '');
				$sub_min_size_seed_e			= request_var('sub_min_size_seed_e', '');
				$sub_minupload_file_size		= request_var('sub_minupload_file_size', '');
				$sub_allow_multy_tracker		= request_var('sub_allow_multy_tracker', '');
				$sub_allow_backup_tracker		= request_var('sub_allow_backup_tracker', '');
				$sub_allow_external				= request_var('sub_allow_external', '');
				$sub_stealthmode				= request_var('sub_stealthmode', '');
				$sub_upload_dead				= request_var('sub_upload_dead', '');
				$sub_invites_open				= request_var('sub_invites_open', '');
				$sub_invite_only				= request_var('sub_invite_only', '');
				$sub_max_members				= request_var('sub_max_members', '');
				$sub_auto_clean					= request_var('sub_auto_clean', '');
				$sub_free_dl					= request_var('sub_free_dl', '');
				$sub_addprivate					= request_var('sub_addprivate', '');
				$sub_GIGSA						= request_var('sub_GIGSA', '');
				$sub_RATIOA						= request_var('sub_RATIOA', '');
				$sub_WAITA						= request_var('sub_WAITA', '');
				$sub_GIGSB						= request_var('sub_GIGSB', '');
				$sub_RATIOB						= request_var('sub_RATIOB', '');
				$sub_WAITB						= request_var('sub_WAITB', '');
				$sub_GIGSC						= request_var('sub_GIGSC', '');
				$sub_RATIOC						= request_var('sub_RATIOC', '');
				$sub_WAITC						= request_var('sub_WAITC', '');
				$sub_GIGSD						= request_var('sub_GIGSD', '');
				$sub_RATIOD						= request_var('sub_RATIOD', '');
				$sub_WAITD						= request_var('sub_WAITD', '');
				$sub_announce_url				= request_var('sub_announce_url', '');
				$vallad_ann = array();
				$announce_url = explode("\n", $sub_announce_url);
				foreach($announce_url as $a)
				{
					if(is_url(strtolower($a)))array_push($vallad_ann,$a);
				}
				//die(serialize($vallad_ann));
		
				//Process Request
		
				//Then I accurately check each parameter before inserting it in SQL statement
				//Some parameters that must be numeric have to be checked with an if clause because intval() function truncates to max integer
				array_push($params,"sitename"); array_push($values,esc_magic($sub_sitename));
				if ($sub_siteurl) { array_push($params,"siteurl"); array_push($values,esc_magic($sub_siteurl)); }
				array_push($params,"cookiedomain"); array_push($values,$sub_cookiedomain);
				if (preg_match('/^\/.*/', $sub_cookiepath)) { array_push($params,"cookiepath"); array_push($values,esc_magic($sub_cookiepath)); }
				array_push($params,"sourcedir"); array_push($values,$sub_sourcedir);
				if (is_email($sub_admin_email)) { array_push($params,"admin_email"); array_push($values,esc_magic($sub_admin_email)); }
				if (file_exists("language/common/".$sub_language.".php")) { array_push($params,"language"); array_push($values,$sub_language); }
				if (is_dir("themes/".$sub_theme)) { array_push($params,"theme"); array_push($values,$sub_theme); }
				if($sub_time_zone != '')
				{
					array_push($params,'time_zone'); 
					array_push($values,$sub_time_zone); 
				}else{
					array_push($params,'time_zone'); 
					array_push($values,'America/Los_Angeles'); 
				}
				array_push($params,"announce_url"); array_push($values,serialize($vallad_ann));
				array_push($params,"welcome_message"); array_push($values,esc_magic($sub_welcome_message));
				array_push($params,"announce_text"); array_push($values,esc_magic($sub_announce_text));
				if ($sub_allow_html != "true") $sub_allow_html = "false"; array_push($params,"allow_html"); array_push($values,$sub_allow_html);
				if ($sub_on_line != "true") $sub_on_line = "false"; array_push($params,"on_line"); array_push($values,$sub_on_line);
				 array_push($params,"off_line_mess"); array_push($values,esc_magic($sub_off_line_mess));
			   if ($sub_rewrite_engine != "true") $sub_rewrite_engine = "false"; array_push($params,"rewrite_engine"); array_push($values,$sub_rewrite_engine);
				array_push($params,"torrent_prefix"); array_push($values,$sub_torrent_prefix);
				array_push($params,"torrent_per_page"); array_push($values,intval($sub_torrent_per_page));
				if (!isset($sub_onlysearch) OR $sub_onlysearch != "true") $sub_onlysearch = "false"; array_push($params,"onlysearch"); array_push($values,$sub_onlysearch);
				array_push($params,"max_torrent_size"); array_push($values,intval($sub_max_torrent_size));
				array_push($params,"announce_interval"); array_push($values,intval($sub_announce_interval));
				array_push($params,"announce_interval_min"); if($sub_announce_interval_min > $sub_announce_interval) array_push($values,intval($sub_announce_interval)); else array_push($values,intval($sub_announce_interval_min));
				array_push($params,"dead_torrent_interval"); array_push($values,intval($sub_dead_torrent_interval));
				array_push($params,"minvotes"); array_push($values,intval($sub_minvotes));
				array_push($params,"time_tracker_update"); array_push($values,intval($sub_time_tracker_update));
				if (is_numeric($sub_give_sign_up_credit)) {array_push($params,"give_sign_up_credit"); array_push($values,$sub_give_sign_up_credit); }
				array_push($params,"best_limit"); array_push($values,intval($sub_best_limit));
				array_push($params,"down_limit"); array_push($values,intval($sub_down_limit));
				if (!isset($sub_allow_change_email) OR $sub_allow_change_email != "true") $sub_allow_change_email = "false"; array_push($params,"allow_change_email"); array_push($values,$sub_allow_change_email);
				if (!isset($sub_torrent_complaints) OR $sub_torrent_complaints != "true") $sub_torrent_complaints = "false"; array_push($params,"torrent_complaints"); array_push($values,$sub_torrent_complaints);
				if (!isset($sub_torrent_global_privacy) OR $sub_torrent_global_privacy != "true") $sub_torrent_global_privacy = "false"; array_push($params,"torrent_global_privacy"); array_push($values,$sub_torrent_global_privacy);
				if (!isset($sub_disclaimer_check) OR $sub_disclaimer_check != "true") $sub_disclaimer_check = "false"; array_push($params,"disclaimer_check"); array_push($values,$sub_disclaimer_check);
				if (!isset($sub_gfx_check) OR $sub_gfx_check != "true") $sub_gfx_check = "false"; array_push($params,"gfx_check"); array_push($values,$sub_gfx_check);
				if (in_array($sub_upload_level,Array("all","user","premium"))) { array_push($params,"upload_level"); array_push($values,$sub_upload_level); }
				if (in_array($sub_download_level,Array("all","user","premium"))) { array_push($params,"download_level"); array_push($values,$sub_download_level); }
				if (!isset($sub_pivate_mode) OR $sub_pivate_mode != "true") $sub_pivate_mode = "false"; array_push($params,"pivate_mode"); array_push($values,$sub_pivate_mode);
				if ($sub_recap_https != "true") $sub_recap_https = "false"; array_push($params,"recap_https"); array_push($values,$sub_recap_https);
				if (!isset($sub_force_passkey) OR $sub_force_passkey != "true") $sub_force_passkey = "false"; array_push($params,"force_passkey"); array_push($values,$sub_force_passkey);
				if ($sub_announce_level != "all") $sub_announce_level = "user"; array_push($params,"announce_level"); array_push($values,$sub_announce_level);
				array_push($params,"max_num_file"); array_push($values,intval($sub_max_num_file));
				array_push($params,"Public_Key"); array_push($values,$sub_Public_Key);
				array_push($params,"Private_Key"); array_push($values,$sub_Private_Key);
				if (is_numeric($sub_max_share_size)) { array_push($params,"max_share_size"); array_push($values,$sub_max_share_size); }
				if (is_numeric($sub_min_size_seed)) { array_push($params,"min_size_seed"); array_push($values,$sub_min_size_seed); }
				if (is_numeric($sub_min_share_seed)) { array_push($params,"min_share_seed"); array_push($values,$sub_min_share_seed); }
				array_push($params,"global_min_ratio"); array_push($values,number_format($sub_global_min_ratio,2));
				if (!isset($sub_autoscrape) OR $sub_autoscrape != "true") $sub_autoscrape = "false"; array_push($params,"autoscrape"); array_push($values,$sub_autoscrape);
				if (!isset($sub_conferm_email) OR $sub_conferm_email != "true") $sub_conferm_email = "false"; array_push($params,"conferm_email"); array_push($values,$sub_conferm_email);
				if (is_numeric($sub_min_num_seed_e)) { array_push($params,"min_num_seed_e"); array_push($values,$sub_min_num_seed_e); }
				if (is_numeric($sub_min_size_seed_e)) { array_push($params,"min_size_seed_e"); array_push($values,$sub_min_size_seed_e); }
				if (is_numeric($sub_minupload_file_size)) {array_push($params,"minupload_file_size"); array_push($values,$sub_minupload_file_size); }
				if (!isset($sub_allow_multy_tracker) OR $sub_allow_multy_tracker != "true") $sub_allow_multy_tracker = "false"; array_push($params,"allow_multy_tracker"); array_push($values,$sub_allow_multy_tracker);
				if (!isset($sub_allow_backup_tracker) OR $sub_allow_backup_tracker != "true") $sub_allow_backup_tracker = "false"; array_push($params,"allow_backup_tracker"); array_push($values,$sub_allow_backup_tracker);
				if (!isset($sub_allow_external) OR $sub_allow_external != "true") $sub_allow_external = "false"; array_push($params,"allow_external"); array_push($values,$sub_allow_external);
				if (!isset($sub_stealthmode) OR $sub_stealthmode != "true") $sub_stealthmode = "false"; array_push($params,"stealthmode"); array_push($values,$sub_stealthmode);
				if (!isset($sub_upload_dead) OR $sub_upload_dead != "true") $sub_upload_dead = "false"; array_push($params,"upload_dead"); array_push($values,$sub_upload_dead);
				if (!isset($sub_invites_open) OR $sub_invites_open != "true") $sub_invites_open = "false"; array_push($params,"invites_open"); array_push($values,$sub_invites_open);
				if (!isset($sub_invite_only) OR $sub_invite_only != "true") $sub_invite_only = "false"; array_push($params,"invite_only"); array_push($values,$sub_invite_only);
				if (is_numeric($sub_max_members)) {array_push($params,"max_members"); array_push($values,$sub_max_members); }
				if (is_numeric($sub_auto_clean)) {array_push($params,"auto_clean"); array_push($values,$sub_auto_clean); }
				if (!isset($sub_free_dl) OR $sub_free_dl != "true") $sub_free_dl = "false"; array_push($params,"free_dl"); array_push($values,$sub_free_dl);
				if (!isset($sub_addprivate) OR $sub_addprivate != "true") $sub_addprivate = "false"; array_push($params,"addprivate"); array_push($values,$sub_addprivate);
				if (is_numeric($sub_GIGSA)) {array_push($params,"GIGSA"); array_push($values,$sub_GIGSA); }
				if (is_numeric($sub_RATIOA)) {array_push($params,"RATIOA"); array_push($values,$sub_RATIOA); }
				if (is_numeric($sub_WAITA)) {array_push($params,"WAITA"); array_push($values,$sub_WAITA); }
				if (is_numeric($sub_GIGSB)) {array_push($params,"GIGSB"); array_push($values,$sub_GIGSB); }
				if (is_numeric($sub_RATIOB)) {array_push($params,"RATIOB"); array_push($values,$sub_RATIOB); }
				if (is_numeric($sub_WAITB)) {array_push($params,"WAITB"); array_push($values,$sub_WAITB); }
				if (is_numeric($sub_GIGSC)) {array_push($params,"GIGSC"); array_push($values,$sub_GIGSC); }
				if (is_numeric($sub_RATIOC)) {array_push($params,"RATIOC"); array_push($values,$sub_RATIOC); }
				if (is_numeric($sub_WAITC)) {array_push($params,"WAITC"); array_push($values,$sub_WAITC); }
				if (is_numeric($sub_GIGSD)) {array_push($params,"GIGSD"); array_push($values,$sub_GIGSD); }
				if (is_numeric($sub_RATIOD)) {array_push($params,"RATIOD"); array_push($values,$sub_RATIOD); }
				if (is_numeric($sub_WAITD)) {array_push($params,"WAITD"); array_push($values,$sub_WAITD); }
				array_push($params,"version"); array_push($values,$version);
				array_push($params,"most_on_line"); array_push($values,$most_users_online);
				array_push($params,"when_most"); array_push($values,$most_users_online_when);
				array_push($params,"start_date"); array_push($values,$start_date);
		
				//Now I save the settings
				//but first I test the insertion against SQL errors, or I lose everything in case of error
				$sql = "INSERT INTO ".$db_prefix."_config (".implode(", ",$params).") VALUES ('".implode("', '",$values)."');";
				//echo $sql;
				//die($sql);
				if (!$db->sql_query($sql)) btsqlerror($sql);
				$db->sql_query("TRUNCATE TABLE ".$db_prefix."_config;");
				$db->sql_query($sql);
				$pmbt_cache->remove_file("sql_".md5("config").".php");
				$sql = "SELECT * FROM ".$db_prefix."_config LIMIT 1;";
				$configquery = $db->sql_query($sql);
				if (!$row = $db->sql_fetchrow($configquery)) die("phpMyBitTorrent not correctly installed! Ensure you have run setup.php or config_default.sql!!");
				$pmbt_cache->set_sql("config", $row);
		
		
				//Finally, I redirect the user to configuration page
										$template->assign_vars(array(
												'S_SUCCESS'            => true,
												'S_FORWARD'			=> $siteurl."/admin.php?i=siteinfo&op=settings",
												'TITTLE_M'          => $user->lang['SUCCESS'],
												'MESSAGE'            => $user->lang['_admsaved'],
										));
				echo $template->fetch('message_body.html');
				die();
			}
			$template->assign_vars(array(
					'L_TITLE'            		=> $user->lang["_admconfigttl"],
					'L_TITLE_EXPLAIN'           => $user->lang["_admconfigttlexplain"],
					'U_ACTION'					=> "./admin.php?i=siteinfo&op=savesettings",
			));
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
					'BBCODE_TAG'		=> $rows['bbcode_tag'],
					'BBCODE_HELPLINE'	=> $rows['bbcode_helpline'],
					'A_BBCODE_HELPLINE'	=> str_replace(array('&amp;', '&quot;', "'", '&lt;', '&gt;'), array('&', '"', "\'", '<', '>'), $rows['bbcode_helpline']),
				));
		
				$i++;
			}
			$db->sql_freeresult($result);
			$template->assign_vars(array(
							'S_SMILIES_ALLOWED'			=>  true,
							'S_SHOW_SMILEY_LINK'		=> true,
							'S_BBCODE_ALLOWED'			=> true,
							'T_TEMPLATE_PATH' 			=> 'themes/' . $theme . '/templates',
							'S_BBCODE_QUOTE'			=> true,
							'S_BBCODE_IMG'				=> true,
							'S_LINKS_ALLOWED'			=> true,
							'S_BBCODE_FLASH'			=> true,
			));

			drawRow("sitename","text", false ,'Site Settings');
			drawRow("sitename","text");
			drawRow("siteurl","text");
			drawRow("cookiedomain","text");
			drawRow("cookiepath","text");
			drawRow("sourcedir","text");
			drawRow("admin_email","text");
			drawRow("time_zone","text");
			//Language handling
			{
					$languages = Array();
					$langdir = "language/common";
					$langhandle = opendir($langdir);
					while ($langfile = readdir($langhandle)) {
							if (eregi("\.php$",$langfile) AND strtolower($langfile) != "mailtexts.php")
									$languages[str_replace(".php","",$langfile)] = ucwords(str_replace(".php","",$langfile));
					}
					closedir($langhandle);
					unset($langdir,$langfile);
			}
			drawRow("language","select",$languages);
			unset($languages);
			//Theme handling
			{
					$themes = Array();
					$thememaindir = "themes";
					$themehandle = opendir($thememaindir);
					while ($themedir = readdir($themehandle)) {
							if (is_dir($thememaindir."/".$themedir) AND $themedir != "." AND $themedir != ".." AND $themedir != "CVS")
									$themes[$themedir] = $themedir;
					}
					closedir($themehandle);
					unset($thememaindir,$themedir);
			}
			drawRow("theme","select",$themes);
			unset($themes);
			drawRow("welcome_message","textarea");
			drawRow("rewrite_engine","checkbox");
			drawRow("torrent_per_page","text");
			drawRow("pivate_mode","checkbox");
			drawRow("disclaimer_check","checkbox");
			drawRow("on_line","checkbox");
			drawRow("off_line_mess","text");
			drawRow("gfx_check","checkbox");
			drawRow("Public_Key","text");
			drawRow("Private_Key","text");
			drawRow("recap_https","checkbox");
			drawRow("invites_open","checkbox");
			drawRow("invite_only","checkbox");
			drawRow("max_members","text");
			drawRow("auto_clean","text");
			drawRow("announce_text","text", false ,'Tracking Settings');
			drawRow("announce_text","text");
			drawRow("announce_url","text3");
			drawRow("allow_html","checkbox");
			drawRow("torrent_prefix","text");
			drawRow("onlysearch","checkbox");
			drawRow("time_tracker_update","text");
			drawRow("announce_level","select",$user->lang["_admpannounce_levelopt"]);
			drawRow("allow_change_email","checkbox", false ,'User Settings');
			drawRow("allow_change_email","checkbox");
			drawRow("give_sign_up_credit","text");
			drawRow("conferm_email","checkbox");
			drawRow("force_passkey","checkbox");
			drawRow("global_min_ratio","text");
			drawRow("min_num_seed_e","text");
			drawRow("min_size_seed_e","text");
			drawRow("minupload_file_size","text");
			drawRow("free_dl","checkbox");
			drawRow("wait_time","checkbox");
			drawRow("GIGSA","text");
			drawRow("RATIOA","text");
			drawRow("WAITA","text");
			drawRow("GIGSB","text");
			drawRow("RATIOB","text");
			drawRow("WAITB","text");
			drawRow("GIGSC","text");
			drawRow("RATIOC","text");
			drawRow("WAITC","text");
			drawRow("GIGSD","text");
			drawRow("RATIOD","text");
			drawRow("WAITD","text");
			drawRow("allow_multy_tracker","checkbox", false ,'Upload Settings');
			drawRow("allow_multy_tracker","checkbox");
			drawRow("max_torrent_size","text");
			drawRow("announce_interval","text");
			drawRow("announce_interval_min","text");
			drawRow("dead_torrent_interval","text");
			drawRow("minvotes","text");
			drawRow("best_limit","text");
			drawRow("down_limit","text");
			drawRow("torrent_complaints","checkbox");
			drawRow("torrent_global_privacy","checkbox");
			drawRow("upload_level","select",$user->lang["_admplevelopt"]);
			drawRow("download_level","select",$user->lang["_admplevelopt"]);
			drawRow("max_num_file","text");
			drawRow("max_share_size","text");
			drawRow("addprivate","checkbox");
			drawRow("allow_external","checkbox", false ,'External Torrent Settings');
			drawRow("allow_external","checkbox");
			drawRow("autoscrape","checkbox");
			drawRow("upload_dead","checkbox");
			drawRow("allow_backup_tracker","checkbox");
			drawRow("stealthmode","checkbox");
			echo $template->fetch(($temp)? 'admin/' . $temp . '.html' : 'admin/site_settings.html');
			close_out();
			break;
		}
?>