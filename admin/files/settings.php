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
** File settings.php 2018-02-23 14:32:00 Black_Heart
**
** CHANGES
**
** 04-11-2018 added announcement 
** 04-14-2018 changed how setting sql is built 
**/
if (!defined('IN_PMBT'))
{
	include_once './../../security.php';
	die ("You can't access this file directly");
}
		include_once('include/function_posting.php');
		include_once('include/message_parser.php');
		include_once('include/class.bbcode.php');
$user->set_lang('admin/acp_site_settings',$user->ulanguage);
$user->set_lang('forum',$user->ulanguage);
$cfgquery = "SELECT * FROM ".$db_prefix."_config;";
$cfgres = $db->sql_query($cfgquery);
$cfgrow = $db->sql_fetchrow($cfgres);
if(isset($cfgrow['announce_url']))$cfgrow['announce_url'] = @implode("\n",unserialize($cfgrow['announce_url']));
$db->sql_freeresult($cfgres);
		$op						= request_var('op', '');
		$action					= request_var('action', 'setting');
		$mode					= request_var('mode', $action);
		$u_action				= 'admin.php?i=siteinfo&op=settings&action=' . $action;
							$template->assign_block_vars('l_block1.l_block2',array(
							'L_TITLE'		=> $user->lang['SITE_SETTINGS'],
							'S_SELECTED'	=> true,
							'U_TITLE'		=> '1',));
							if($auth->acl_get('a_server'))
							{
								$template->assign_block_vars('l_block1.l_block2.l_block3',array(
								'S_SELECTED'	=> ('settings' ==$op)? true:false,
								'IMG' => '',
								'L_TITLE' => $user->lang['MENU_SETTINGS'],
								'U_TITLE' => append_sid("{$siteurl}/admin.$phpEx", 'i=siteinfo&amp;op=settings'),
								));
							}
							if($auth->acl_get('a_server'))
							{
								$template->assign_block_vars('l_block1.l_block2.l_block3',array(
								'S_SELECTED'	=> ('settings_pm' ==$op)? true:false,
								'IMG' => '',
								'L_TITLE' => $user->lang['MENU_PRIVATE_MESSAGE'],
								'U_TITLE' => append_sid("{$siteurl}/admin.$phpEx", 'i=siteinfo&amp;op=settings_pm'),
								));
							}
							if($auth->acl_get('a_board'))
							{
								$template->assign_block_vars('l_block1.l_block2.l_block3',array(
								'S_SELECTED'	=> ('sig_settings' ==$op)? true:false,
								'IMG' => '',
								'L_TITLE' => $user->lang['MENU_SIG_SETTINGS'],
								'U_TITLE' => append_sid("{$siteurl}/admin.$phpEx", 'i=siteinfo&amp;op=sig_settings'),
								));
							}
							if($auth->acl_get('a_server'))
							{
								$template->assign_block_vars('l_block1.l_block2.l_block3',array(
								'S_SELECTED'	=> ('acp_email' ==$op)? true:false,
								'IMG' => '',
								'L_TITLE' => $user->lang['ACP_EMAIL_SETTINGS'],
								'U_TITLE' => append_sid("{$siteurl}/admin.$phpEx", 'i=siteinfo&amp;op=acp_email'),
								));
							}
							if($auth->acl_get('a_attach'))
							{
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
							}
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
					'ICON_MOVE_DOWN'          => $user->img('icon_down', 'MOVE_DOWN'),
					'ICON_MOVE_UP'            => $user->img('icon_up', 'MOVE_UP'),
					'ICON_MOVE_UP_DISABLED'   => $user->img('icon_up_disabled', 'MOVE_UP_DISABLED'),
					'ICON_MOVE_DOWN_DISABLED' => $user->img('icon_down_disabled', 'MOVE_DOWN_DISABLED'),
					'ICON_EDIT'               => $user->img('icon_edit', 'EDIT'),
					'ICON_DELETE'             => $user->img('icon_delete', 'DELETE'),)
				);
		$action					= request_var('action_i', $action);
			$admin_role->main('',$mode);
			echo $template->fetch('admin/' . $admin_role->tpl_name . '.html');
			close_out();
		break;
		case 'setting':
			if ($op == "savesettings")
			{
				//Process Request
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
				$sub_welcome_message			= utf8_normalize_nfc(request_var('sub_welcome_message', '',true));
				$announce_ments					= utf8_normalize_nfc(request_var('sub_announce_ments', '',true));
				$sub_off_line_mess				= utf8_normalize_nfc(request_var('sub_off_line_mess','',true));
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
				$sub_minupload_size_file		= request_var('sub_minupload_size_file', '');
				$sub_allow_multy_tracker		= request_var('sub_allow_multy_tracker', '');
				$sub_allow_backup_tracker		= request_var('sub_allow_backup_tracker', '');
				$sub_allow_external				= request_var('sub_allow_external', '');
				$sub_stealthmode				= request_var('sub_stealthmode', '');
				$sub_upload_dead				= request_var('sub_upload_dead', '');
				$sub_allow_magnet				= request_var('sub_allow_magnet', '');
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
		
		
				//First I create the SQL arrays
				//Then I accurately check each parameter before inserting it in SQL statement
				//Some parameters that must be numeric have to be checked with an if clause because intval() function truncates to max integer
				$sql_ary = array(
					'sitename'				=> $sub_sitename,
					'siteurl'				=> $sub_siteurl,
					'cookiedomain'			=> $sub_cookiedomain,
					'cookiepath'			=> $sub_cookiepath,
					'sourcedir'				=> $sub_sourcedir,
					'admin_email'			=> $sub_admin_email,
					'language'				=> (file_exists("language/common/".$sub_language.".php"))? $sub_language : 'english',
					'theme'					=> (is_dir("themes/".$sub_theme))? $sub_theme : 'Bitfarm',
					'time_zone'				=> ($sub_time_zone != '')? $sub_time_zone : 'America/Los_Angeles',
					'announce_url'			=> serialize($vallad_ann),
					'welcome_message'		=> ($sub_welcome_message == '')? NULL : $sub_welcome_message,
					'announce_ments'		=> ($announce_ments == '')? NULL : $announce_ments,
					'announce_text'			=> ($sub_announce_text == '')? NULL : $sub_announce_text,
					'allow_html'			=> ($sub_allow_html != "true")? 'false' : 'true',
					'on_line'				=> ($sub_on_line != "true")? 'false' : 'true',
					'off_line_mess'			=> ($sub_off_line_mess == '')? NULL : $sub_off_line_mess,
					'rewrite_engine'		=>	($sub_rewrite_engine != "true")? 'false' : 'true',
					'torrent_prefix'		=>	($sub_torrent_prefix != '')? $sub_torrent_prefix : NULL,
					'torrent_per_page'		=>	(int) $sub_torrent_per_page,
					'onlysearch'			=> (!isset($sub_onlysearch) OR $sub_onlysearch != "true")? 'false' : 'true',
					'max_torrent_size'		=> (int) $sub_max_torrent_size,
					'announce_interval'		=> (int) $sub_announce_interval,
					'announce_interval_min'	=> ($sub_announce_interval_min > $sub_announce_interval)? (int)$sub_announce_interval : (int)$sub_announce_interval_min,
					'dead_torrent_interval'	=> (int) $sub_dead_torrent_interval,
					'minvotes'				=> (int) $sub_minvotes,
					'time_tracker_update'	=> (int) $sub_time_tracker_update,
					'give_sign_up_credit'	=> (is_numeric($sub_give_sign_up_credit))? (int) $sub_give_sign_up_credit : (int) '0',
					'best_limit'			=> (int) $sub_best_limit,
					'down_limit'			=> (int) $sub_down_limit,
					'allow_change_email'	=> (!isset($sub_allow_change_email) OR $sub_allow_change_email != "true")? 'false' : 'true',
					'torrent_complaints'	=> (!isset($sub_torrent_complaints) OR $sub_torrent_complaints != "true")? 'false' : 'true',
					'torrent_global_privacy'=> (!isset($sub_torrent_global_privacy) OR $sub_torrent_global_privacy != "true")? 'false' : 'true',
					'disclaimer_check'		=> (!isset($sub_disclaimer_check) OR $sub_disclaimer_check != "true")? 'false' : 'true',
					'gfx_check'				=> (!isset($sub_gfx_check) OR $sub_gfx_check != "true")? 'false' : 'true',
					'upload_level'			=> (in_array($sub_upload_level,Array("all","user","premium")))? $sub_upload_level : 'all',
					'download_level'		=> (in_array($sub_download_level,Array("all","user","premium")))? $sub_download_level : 'all',
					'pivate_mode'			=> (!isset($sub_pivate_mode) OR $sub_pivate_mode != "true")? 'false' : 'true',
					'recap_https'			=> ($sub_recap_https != "true")? 'false' : 'true',
					'force_passkey'			=> (!isset($sub_force_passkey) OR $sub_force_passkey != "true")? 'false' : 'true',
					'announce_level'		=> ($sub_announce_level != "all")? 'user' : 'all',
					'max_num_file'			=> (int) $sub_max_num_file,
					'Public_Key'			=> ($sub_Public_Key == '')? NULL : $sub_Public_Key,
					'Private_Key'			=> ($sub_Private_Key == '')? NULL : $sub_Private_Key,
					'max_share_size'		=> (is_numeric($sub_max_share_size))? (int) $sub_max_share_size : (int) $max_share_size,
					'min_size_seed'			=> (is_numeric($sub_min_size_seed))? (int) $sub_min_size_seed : (int) $min_size_seed,
					'min_share_seed'		=> (is_numeric($sub_min_share_seed))? (int) $sub_min_share_seed : (int) $min_share_seed,
					'global_min_ratio'		=> number_format($sub_global_min_ratio,2),
					'autoscrape'			=> (!isset($sub_autoscrape) OR $sub_autoscrape != "true")? 'false' : 'true',
					'conferm_email'			=> (!isset($sub_conferm_email) OR $sub_conferm_email != "true")? 'false' : 'true',
					'min_num_seed_e'		=> (is_numeric($sub_min_num_seed_e))? (int) $sub_min_num_seed_e : (int) '0',
					'min_size_seed_e'		=> (is_numeric($sub_min_size_seed_e))? (int) $sub_min_size_seed_e : (int) '0',
					'minupload_size_file'	=> (is_numeric($sub_minupload_size_file))? (int) $sub_minupload_size_file : (int) '0',
					'allow_multy_tracker'	=> (!isset($sub_allow_external) OR $sub_allow_external != "true")? 'false' : 'true',
					'allow_backup_tracker'	=> (!isset($sub_allow_backup_tracker) OR $sub_allow_backup_tracker != "true")? 'false' : 'true',
					'allow_external'		=> (!isset($sub_allow_external) OR $sub_allow_external != "true")? 'false' : 'true',
					'allow_magnet'			=> ($sub_allow_magnet != "1")? '0' : '1',
					'stealthmode'			=> (!isset($sub_stealthmode) OR $sub_stealthmode != "true")? 'false' : 'true',
					'upload_dead'			=> (!isset($sub_upload_dead) OR $sub_upload_dead != "true")? 'false' : 'true',
					'invites_open'			=> (!isset($sub_invites_open) OR $sub_invites_open != "true")? 'false' : 'true',
					'invite_only'			=> (!isset($sub_invite_only) OR $sub_invite_only != "true")? 'false' : 'true',
					'max_members'			=> (is_numeric($sub_max_members))? (int) $sub_max_members : (int) '0',
					'auto_clean'			=> (is_numeric($sub_auto_clean))? (int) $sub_auto_clean : (int) '0',
					'free_dl'				=> (!isset($sub_free_dl) OR $sub_free_dl != "true")? 'false' : 'true',
					'addprivate'			=> (!isset($sub_addprivate) OR $sub_addprivate != "true")? 'false' : 'true',
					'GIGSA'					=> (is_numeric($sub_GIGSA))? (int) $sub_GIGSA : (int) '0',
					'RATIOA'				=> (is_numeric($sub_RATIOA))? number_format($sub_RATIOA,2) : '0',
					'WAITA'					=> (is_numeric($sub_WAITA))? (int) $sub_WAITA : (int) '0',
					'GIGSB'					=> (is_numeric($sub_GIGSB))? (int) $sub_GIGSB : (int) '0',
					'RATIOB'				=> (is_numeric($sub_RATIOB))? number_format($sub_RATIOB,2) : '0',
					'WAITB'					=> (is_numeric($sub_WAITB))? (int) $sub_WAITB : (int) '0',
					'GIGSC'					=> (is_numeric($sub_GIGSC))? (int) $sub_GIGSC : (int) '0',
					'RATIOC'				=> (is_numeric($sub_RATIOC))? number_format($sub_RATIOC,2) : '0',
					'WAITC'					=> (is_numeric($sub_WAITC))? (int) $sub_WAITC : (int) '0',
					'GIGSD'					=> (is_numeric($sub_GIGSD))? (int) $sub_GIGSD : (int) '0',
					'RATIOD'				=> (is_numeric($sub_RATIOD))? number_format($sub_RATIOD,2) : '0',
					'WAITD'					=> (is_numeric($sub_WAITD))? (int) $sub_WAITD : (int) '0',
					'version'				=> $version,
					'most_on_line'			=> $most_users_online,
					'when_most'				=> $most_users_online_when,
					'start_date'			=> $start_date,
				);
				//Now I save the settings
				//but first I test the insertion against SQL errors, or I lose everything in case of error
				$sql = "INSERT INTO ".$db_prefix."_config " . $db->sql_build_array('INSERT', $sql_ary) . ";";
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

			drawRow("sitename","text", false ,$user->lang['SITE_SETTINGS']);
			drawRow("on_line","checkbox");
			drawRow("off_line_mess","text");
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
							if (preg_match("/.php/",$langfile) AND strtolower($langfile) != "mailtexts.php")
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
			drawRow("announce_ments","text");
			drawRow("rewrite_engine","checkbox");
			drawRow("torrent_per_page","text");
			drawRow("pivate_mode","checkbox");
			drawRow("gfx_check","checkbox");
			drawRow("Public_Key","text");
			drawRow("Private_Key","text");
			drawRow("recap_https","checkbox");
			drawRow("invites_open","checkbox");
			drawRow("invite_only","checkbox");
			drawRow("max_members","text");
			drawRow("auto_clean","text");
			drawRow("announce_text","text", false ,$user->lang['TRACKER_SETTINGS']);
			drawRow("disclaimer_check","checkbox");
			drawRow("announce_text","text");
			drawRow("announce_url","text3");
			drawRow("allow_html","checkbox");
			drawRow("allow_magnet","select",$user->lang["YES_NO_NUM"]);
			drawRow("torrent_prefix","text");
			drawRow("onlysearch","checkbox");
			drawRow("time_tracker_update","text");
			drawRow("announce_level","select",$user->lang["_admpannounce_levelopt"]);
			drawRow("allow_change_email","checkbox", false ,$user->lang['USER_SETTINGS']);
			drawRow("allow_change_email","checkbox");
			drawRow("give_sign_up_credit","text");
			drawRow("conferm_email","checkbox");
			drawRow("force_passkey","checkbox");
			drawRow("global_min_ratio","text");
			drawRow("min_num_seed_e","text");
			drawRow("min_size_seed_e","text");
			drawRow("minupload_size_file","text");
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
			drawRow("allow_multy_tracker","checkbox", false ,$user->lang['UPLOAD_SETTINGS']);
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
			drawRow("allow_external","checkbox", false ,$user->lang['EXT_TORRENT_SETTINGS']);
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