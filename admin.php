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
** File admin.php 2018-02-17 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (defined('IN_PMBT'))die ("You can't include this file.");
define("IN_PMBT",true);
if (!ini_get('display_errors')) {
    ini_set('display_errors', 1);
}
require_once("include/errors.php");
$old_error_handler = set_error_handler("myErrorHandler");
require_once("include/config.php"); //if config file has not been loaded yet
date_default_timezone_set($pmbt_time_zone);
include'include/class.template.php';
require_once("include/actions.php");
require_once("admin/functions.php");
include'include/auth.php';
include_once("include/utf/utf_tools.php");
include_once('include/user.functions.php');
$user->set_lang('common',$user->ulanguage);
$template = new Template();
$admin_staff = array();
$admin_siteinfo = array();
$admin_userinfo = array();
$admin_torrentinfo = array();
$auth = new auth();
$auth->acl($user);
$convert_row = array('viewimg'=>0,'popuppm'=>1);
function phpbb_optionset($bit, $set, $data)
{
	if ($set && !($data & 1 << $bit))
	{
		$data += 1 << $bit;
	}
	else if (!$set && ($data & 1 << $bit))
	{
		$data -= 1 << $bit;
	}

	return $data;
}
function set_user_options()
{
	global $convert_row;

	// Key need to be set in row, else default value is chosen
	$keyoptions = array(
		'viewimg'		=> array('bit' => 0, 'default' => 1),
		'viewflash'		=> array('bit' => 1, 'default' => 1),
		'viewsmilies'	=> array('bit' => 2, 'default' => 1),
		'viewsigs'		=> array('bit' => 3, 'default' => 1),
		'viewavatars'	=> array('bit' => 4, 'default' => 1),
		'viewcensors'	=> array('bit' => 5, 'default' => 1),
		'attachsig'		=> array('bit' => 6, 'default' => 0),
		'bbcode'		=> array('bit' => 8, 'default' => 1),
		'smilies'		=> array('bit' => 9, 'default' => 1),
		'popuppm'		=> array('bit' => 10, 'default' => 0),
		'sig_bbcode'	=> array('bit' => 15, 'default' => 1),
		'sig_smilies'	=> array('bit' => 16, 'default' => 1),
		'sig_links'		=> array('bit' => 17, 'default' => 1),
	);

	$option_field = 0;

	foreach ($keyoptions as $key => $key_ary)
	{
		$value = (isset($convert_row[$key])) ? (int) $convert_row[$key] : $key_ary['default'];

		if ($value && !($option_field & 1 << $key_ary['bit']))
		{
			$option_field += 1 << $key_ary['bit'];
		}
	}

	return $option_field;
}
if (!$auth->acl_get('a_'))
{
	trigger_error('NO_ADMIN');
}
if (!checkaccess("m_see_admin_cp")){
	header("Location: ".$siteurl."/login.php?return=".$_SERVER["REQUEST_URI"]);
	die();
}
require_once("admin/language/".$user->ulanguage.".php");
$user->set_lang('admin/main',$user->ulanguage);
$template->assign_vars(array(
	'S_OWNER'				=> ($user->data['user_type'] == 3),
	'S_COPYRIGHT_HTML'		=> true,
));
set_site_var($user->lang['ADMINISTRATOR']);
		$acp			= request_var('i', '');
		$i 				= $acp;
		$op				= request_var('op', '');
		$acp_menu 		= 'admin_'.(($acp != '')? $acp : 'siteinfo');
$admintab = array('staff','siteinfo','userinfo','torrentinfo');
adminentry("home","home","Home","siteinfo","mod");
#Fetching operators list and displaying Admin menu
foreach($admintab as $val){
		   $template->assign_block_vars('t_block1', array(
				'S_SELECTED'	=> ($i == $val)? true : false,
				'U_TITLE'		=> "admin.php?i=$val",
				'L_TITLE'		=> str_replace('info','',$val),
		   ));
}
$u_action = './admin.php?'.((!$op=='')? 'op=' . $op . '&amp;' : '' ).((!$i=='')? 'i=' . $i :'');
$operators = Array();
$op_keys = Array();
$allowed_acc = Array();
$opdir = "admin/items";
$ophandle = opendir($opdir);
while ($opfile = readdir($ophandle)) {
        $op_keys = Array();
        if (!preg_match("/.php/i",$opfile)) continue;
        include($opdir."/".$opfile);
        foreach ($op_keys as $key) {
                $operators[$key] = $opfile;
				if($allow)
				{
					$allowed_acc[$opfile] = 1;
				}
        }
}
closedir($ophandle);
unset($opdir,$opfile,$op_keys);
							$template->assign_block_vars('l_block1',array(
					'L_TITLE'		=> '',
					'S_SELECTED'	=> true,
					'U_TITLE'		=> '',));
							$template->assign_block_vars('l_block1.l_block2',array(
					'L_TITLE'		=> str_replace('info','',$i),
					'S_SELECTED'	=> true,
					'U_TITLE'		=> '1',));
					//die(print_r($$acp_menu));
		foreach($$acp_menu as $t){
							$template->assign_block_vars('l_block1.l_block2.l_block3', $t);
		}
//The "Core"
if (isset($op) AND array_key_exists($op,$operators) AND ($allowed_acc[$operators[$op]] OR $allowed_acc[$operators[str_replace('.php','',$op)]]))
{
	require_once("admin/files/".$operators[$op]);
}
else
{

		$action = request_var('action', '');
		if ($action)
		{
			if ($action === 'admlogout')
			{
				$user->unset_admin();
				$redirect_url = append_sid("{$phpbb_root_path}index.$phpEx");
				meta_refresh(3, $redirect_url);
				trigger_error($user->lang['ADM_LOGGED_OUT'] . '<br /><br />' . sprintf($user->lang['RETURN_INDEX'], '<a href="' . $redirect_url . '">', '</a>'));
			}

			if (!confirm_box(true))
			{
				switch ($action)
				{
					case 'online':
						$confirm = true;
						$confirm_lang = 'RESET_ONLINE_CONFIRM';
					break;
					case 'stats':
						$confirm = true;
						$confirm_lang = 'RESYNC_STATS_CONFIRM';
					break;
					case 'user':
						$confirm = true;
						$confirm_lang = 'RESYNC_POSTCOUNTS_CONFIRM';
					break;
					case 'date':
						$confirm = true;
						$confirm_lang = 'RESET_DATE_CONFIRM';
					break;
					case 'db_track':
						$confirm = true;
						$confirm_lang = 'RESYNC_POST_MARKING_CONFIRM';
					break;
					case 'purge_cache':
						$confirm = true;
						$confirm_lang = 'PURGE_CACHE_CONFIRM';
					break;

					default:
						$confirm = true;
						$confirm_lang = 'CONFIRM_OPERATION';
				}
				if ($confirm)
				{
					confirm_box(false, $user->lang[$confirm_lang], build_hidden_fields(array(
						'i'			=> $id,
						'mode'		=> $mode,
						'action'	=> $action,
					)));
				}
			}
			else
			{
				switch ($action)
				{

					case 'online':
						if (!$auth->acl_get('a_board'))
						{
							trigger_error($user->lang['NO_AUTH_OPERATION'] . adm_back_link($this->u_action), E_USER_WARNING);
						}

						$db->sql_query("UPDATE ".$db_prefix."_config SET `most_on_line` = '1', `when_most` = NOW()");
						add_log('admin', 'LOG_RESET_ONLINE');
					break;

					case 'user':
						if (!$auth->acl_get('a_board'))
						{
							trigger_error($user->lang['NO_AUTH_OPERATION'] . adm_back_link($this->u_action), E_USER_WARNING);
						}

						// Resync post counts
						$start = $max_post_id = 0;

						// Find the maximum post ID, we can only stop the cycle when we've reached it
						$sql = 'SELECT MAX(forum_last_post_id) as max_post_id
							FROM ' . $db_prefix . '_forums';
						$result = $db->sql_query($sql);
						$max_post_id = (int) $db->sql_fetchfield('max_post_id');
						$db->sql_freeresult($result);

						// No maximum post id? :o
						if (!$max_post_id)
						{
							$sql = 'SELECT MAX(post_id) as max_post_id
								FROM ' . $db_prefix . '_posts';
							$result = $db->sql_query($sql);
							$max_post_id = (int) $db->sql_fetchfield('max_post_id');
							$db->sql_freeresult($result);
						}

						// Still no maximum post id? Then we are finished
						if (!$max_post_id)
						{
							add_log('admin', 'LOG_RESYNC_POSTCOUNTS');
							break;
						}

						$step = ($config['num_posts']) ? (max((int) ($config['num_posts'] / 5), 20000)) : 20000;
						$db->sql_query('UPDATE ' . $db_prefix . '_users SET user_posts = 0');

						while ($start < $max_post_id)
						{
							$sql = 'SELECT COUNT(post_id) AS num_posts, poster_id
								FROM ' . $db_prefix . '_posts
								WHERE post_id BETWEEN ' . ($start + 1) . ' AND ' . ($start + $step) . '
									AND post_postcount = 1 AND post_approved = 1
								GROUP BY poster_id';
							$result = $db->sql_query($sql);

							if ($row = $db->sql_fetchrow($result))
							{
								do
								{
									$sql = 'UPDATE ' . $db_prefix . "_users SET user_posts = user_posts + {$row['num_posts']} WHERE id = {$row['poster_id']}";
									$db->sql_query($sql);
								}
								while ($row = $db->sql_fetchrow($result));
							}
							$db->sql_freeresult($result);

							$start += $step;
						}

						add_log('admin', 'LOG_RESYNC_POSTCOUNTS');

					break;

					case 'date':
						if (!$auth->acl_get('a_board'))
						{
							trigger_error($user->lang['NO_AUTH_OPERATION'] . adm_back_link($this->u_action), E_USER_WARNING);
						}
						$start = date("Y-m-d H:i:s");
						$db->sql_query("UPDATE ".$db_prefix."_config SET `start_date ` =  '" . $start . "'");
						$pmbt_cache->remove_file("sql_".md5("config").".php");
						$sql = "SELECT * FROM ".$db_prefix."_config LIMIT 1;";
						$configquery = $db->sql_query($sql);
						if (!$row = $db->sql_fetchrow($configquery)) die("phpMyBitTorrent not correctly installed! Ensure you have run setup.php or config_default.sql!!");
						$pmbt_cache->set_sql("config", $row);
						add_log('admin', 'LOG_RESET_DATE');
					break;

					case 'db_track':
						switch ($db->sql_layer)
						{
							case 'sqlite':
							case 'firebird':
								$db->sql_query('DELETE FROM ' . $db_prefix . '_topics_posted');
							break;

							default:
								$db->sql_query('TRUNCATE TABLE ' . $db_prefix . '_topics_posted');
							break;
						}

						// This can get really nasty... therefore we only do the last six months
						$get_from_time = time() - (6 * 4 * 7 * 24 * 60 * 60);

						// Select forum ids, do not include categories
						$sql = 'SELECT forum_id
							FROM ' . $db_prefix . '_forums
							WHERE forum_type <> ' . 0;
						$result = $db->sql_query($sql);

						$forum_ids = array();
						while ($row = $db->sql_fetchrow($result))
						{
							$forum_ids[] = $row['forum_id'];
						}
						$db->sql_freeresult($result);

						// Any global announcements? ;)
						$forum_ids[] = 0;

						// Now go through the forums and get us some topics...
						foreach ($forum_ids as $forum_id)
						{
							$sql = 'SELECT p.poster_id, p.topic_id
								FROM ' . $db_prefix . '_posts p, ' . $db_prefix . '_topics t
								WHERE t.forum_id = ' . $forum_id . '
									AND t.topic_moved_id = 0
									AND t.topic_last_post_time > ' . $get_from_time . '
									AND t.topic_id = p.topic_id
									AND p.poster_id <> ' . 0 . '
								GROUP BY p.poster_id, p.topic_id';
							$result = $db->sql_query($sql);

							$posted = array();
							while ($row = $db->sql_fetchrow($result))
							{
								$posted[$row['poster_id']][] = $row['topic_id'];
							}
							$db->sql_freeresult($result);

							$sql_ary = array();
							foreach ($posted as $user_id => $topic_row)
							{
								foreach ($topic_row as $topic_id)
								{
									$sql_ary[] = array(
										'user_id'		=> (int) $user_id,
										'topic_id'		=> (int) $topic_id,
										'topic_posted'	=> 1,
									);
								}
							}
							unset($posted);

							if (sizeof($sql_ary))
							{
								$db->sql_multi_insert($db_prefix . '_topics_posted', $sql_ary);
							}
						}

						add_log('admin', 'LOG_RESYNC_POST_MARKING');
					break;

					case 'purge_cache':
						if ((int) $user->user_type !== 3)
						{
							trigger_error($user->lang['NO_AUTH_OPERATION'] . adm_back_link($this->u_action), E_USER_WARNING);
						}

						global $pmbt_cache;
						$pmbt_cache->purge();

						// Clear permissions
						$auth->acl_clear_prefetch();
						cache_moderators();

						add_log('admin', 'LOG_PURGE_CACHE');
					break;
				}

			}
		}
		if (($lversion = $pmbt_cache->get('source_version',86400)) === false)$lversion = array('LATEST_VERSION'=>'0.0.0');
		if($auth->acl_get('a_viewlogs'))
		{
			$sql = "SELECT event, action, results, ip, datetime, userid FROM `".$db_prefix."_log` ORDER BY datetime DESC LIMIT 0, 5 "; 
			$res = $db->sql_query($sql);
			while ($errors = $db->sql_fetchrow($res))
			{
				$data = array();
				$errors['ip_g'] = $errors["ip"];
				$errors = array_merge($errors, build_user_array($errors['userid']));
				$data = unserialize(stripslashes($errors['results']));
				$s_data = (isset($user->lang[strtoupper($errors['action'])])) ? $user->lang[strtoupper($errors['action'])] : '{' . ucfirst(str_replace('_', ' ', $errors['action'])) . '}';
				if ((substr_count($s_data, '%') - sizeof($data)) > 0)
				{
					$data = (!is_array($data))?array($data) : $data;
					$data = array_merge($data, array_fill(0, substr_count($s_data, '%') - sizeof($data), ''));
				}
	
				$s_data = vsprintf($s_data, $data);
				if($errors['userid'] == "0")
				{
					$by2['username'] = $user->lang['UNKNOWN'];
				}
				else
				{
				$sqler = ("SELECT username FROM ".$db_prefix."_users WHERE id='".$errors['userid']."'");
					$by = $db->sql_query($sqler);
					$by2 = $db->sql_fetchrow($by);
					$db->sql_freeresult($by);
				}
									$template->assign_block_vars('log', array(
									'USERNAME'		=> ($errors['userid'] == 0)? $user->lang['UNKNOWN'] : $errors['name'],
									'IP'		=> ($errors['userid'] == 0)? long2ip($errors["ip_g"]) : long2ip($errors["ip"]),
									'DATE'		=> $errors['datetime'],
									'ACTION'		=> $s_data,
									));
			} 
			$db->sql_freeresult($res);
		}
		$day_site_alive = sql_timestamp_to_unix_timestamp($start_date)/86400;
		//Post's
		$sql = "SELECT COUNT( post_id )
		FROM `".$db_prefix."_posts`;";
        $res = $db->sql_query($sql);
        list ($total_posts) = $db->fetch_array($res);
		//Post's perday
		$posts_per_day = ($total_posts > 0)? intval(floor($total_posts/$day_site_alive)) : 0;
		//Topic's
		$sql = "SELECT COUNT( topic_id )
		FROM `".$db_prefix."_topics`;";
        $res = $db->sql_query($sql);
        list ($total_topics) = $db->fetch_array($res);
		//Topic's perday
		$topics_per_day = ($total_topics > 0)? intval(floor($total_topics/$day_site_alive)) : 0;
        //Total Torrents and their size
        $sql = "SELECT COUNT(id), SUM(size) FROM ".$db_prefix."_torrents;";
        $res = $db->sql_query($sql);
        list ($tottorrent, $totshare) = $db->fetch_array($res);
        $db->sql_freeresult($res);
		$tottorrent_per_day = ($tottorrent > 0)? intval(floor($tottorrent/$day_site_alive)) : 0;
        //Total peers and their speed
        $sql = "SELECT COUNT(id), (SUM(upload_speed)+SUM(download_speed))/2 FROM ".$db_prefix."_peers;";
        $res = $db->sql_query($sql);
        list ($totpeers, $totspeed) = $db->fetch_array($res);
        $db->sql_freeresult($res);
        //Total seeders and total leechers
        $sql = "SELECT COUNT(id) FROM ".$db_prefix."_peers GROUP BY seeder ORDER BY seeder ASC;";
        $res = $db->sql_query($sql);
        list ($totseeders) = $db->fetch_array($res);
        list ($totleechers) = $db->fetch_array($res);
        $db->sql_freeresult($res);
        //Total users
        $sql = "SELECT COUNT(id) 
		FROM ".$db_prefix."_users;";
        $res = $db->sql_query($sql);
        list ($totuser) = $db->fetch_array($res);
        $db->sql_freeresult($res);
		$users_per_day = ($totuser > 0)? intval(floor($totuser/$day_site_alive)) : 0;
		//Attachment info
		$sql = "SELECT COUNT(`attach_id`) FROM `".$db_prefix."_attachments` GROUP BY `is_orphan` ORDER BY `is_orphan` ASC";
        $res = $db->sql_query($sql)or btsqlerror($sql);
        list ($total_non_orphan) = $db->fetch_array($res);
        list ($total_orphan) = $db->fetch_array($res);
        $db->sql_freeresult($res);
		//Uploaded avatar folder size
		$avatar_dir_size = GetFolderSize('./avatars/user');
		//Attachment folder size
		$upload_dir_size = GetFolderSize('./files');
		//Torrent folder size
		$torrent_dir_size = GetFolderSize($torrent_dir);
		$total_files = num_files('./files');
		$files_per_day = ($total_files > 0)? intval(floor($total_files/$day_site_alive)) : 0;
		if (version_compare(PHP_VERSION, '5.2.0', '<'))
		{
			$template->assign_vars(array(
				'S_PHP_VERSION_OLD'	=> true,
				'L_PHP_VERSION_OLD'	=> sprintf($user->lang['PHP_VERSION_OLD'], '<a href="http://www.phpbb.com/community/viewtopic.php?f=14&amp;t=1958605">', '</a>'),
			));
		}else{
			$template->assign_vars(array(
				'S_PHP_VERSION_OLD'	=> false,
			));
		}
		$template->assign_vars(array(
			'TOTAL_TORRENTS'				=> $tottorrent,
			'L_TITLE'						=> sprintf($user->lang['MAIN_TEXT'],$sitename),
			'TORRENTS_PER_DAY'				=> $tottorrent_per_day,
			'TOTAL_PEERS'				=> ($totpeers)? $totpeers : '0',
			'PEER_SPEED'				=> ($totspeed)? $totspeed : '0',
			'TOTAL_SEEDERS'				=> ($totseeders)? $totseeders : '0',
			'TOTAL_LEECHERS'				=> ($totleechers)? $totleechers : '0',
			'TOTAL_USERS'			=>$totuser,
			'DATABASE_INFO'			=>$db->sql_server_info(),
			'DBSIZE'				=>get_database_size(),
			'BOARD_VERSION'			=>$version,
			'S_VERSION_UP_TO_DATE'  =>(version_compare(str_replace('rc', 'RC', strtolower($version)), str_replace('rc', 'RC', strtolower($lversion['LATEST_VERSION'])), '<')) ? false : true,
			'GZIP_COMPRESSION'	=> (@extension_loaded('zlib')) ? $user->lang['YES'] :$user->lang[' NO'],
			'S_ACTION_OPTIONS'	=> ($auth->acl_get('a_board')) ? true : false,
			'TOTAL_POSTS'		=> $total_posts,
			'POSTS_PER_DAY'		=> $posts_per_day,
			'TOTAL_TOPICS'		=> $total_topics,
			'TOPICS_PER_DAY'	=> $topics_per_day,
			'USERS_PER_DAY'		=> $users_per_day,
			'TOTAL_FILES'		=> $total_files,
			'FILES_PER_DAY'		=> $files_per_day,
			'START_DATE'		=> $start_date,
			'AVATAR_DIR_SIZE'	=> mksize($avatar_dir_size),
			'UPLOAD_DIR_SIZE'	=> mksize($upload_dir_size),
			'TORRENT_DIR_SIZE'	=> mksize($torrent_dir_size),
			'TOTAL_ORPHAN'		=> $total_orphan,
			'S_TOTAL_ORPHAN'	=> ($total_orphan === false) ? false : true,
			'U_ACTION'			=> $u_action,
			'U_ADMIN_LOG'		=> append_sid("{$siteurl}/admin.$phpEx", 'i=siteinfo&amp;op=log'),
			'U_INACTIVE_USERS'	=> append_sid("{$siteurl}/admin.$phpEx", 'i=inactive&amp;mode=list'),
			'U_VERSIONCHECK'	=> append_sid("{$siteurl}/admin.$phpEx", 'i=siteinfo&op=webupdate#webupdate'),
			'U_VERSIONCHECK_FORCE'	=> append_sid("{$siteurl}/admin.$phpEx", 'i=siteinfo&op=webupdate#webupdate'),
			'U_ACTION_REST_ONLINE'	=>	append_sid("{$siteurl}/admin.$phpEx", 'i=siteinfo&action=online'),
			'U_ACTION_REST_DATE'	=>	append_sid("{$siteurl}/admin.$phpEx", 'i=siteinfo&action=date'),
			'U_ACTION_PURGE'		=>	append_sid("{$siteurl}/admin.$phpEx", 'i=siteinfo&action=purge_cache'),
		));

echo $template->fetch('admin/main.html');
		close_out();
}
?>