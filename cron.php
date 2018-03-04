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
** File cron.php 2018-02-19 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
#Turn off error reporting because it well not be seen
error_reporting(E_ALL);
#Attempt to expand run time to allow for long scrape times
if( !ini_get('safe_mode') ){
	set_time_limit(40);
}
require_once("common.php");
require_once("include/bdecoder.php");
require_once("include/bencoder.php");
require_once("include/torrent_functions.php");
require_once("admin/functions.php");
include_once("include/utf/utf_tools.php");
if (!isset($config['cron_lock']))
{
	set_config('cron_lock', '0', true);
}
	      #$OUTPUT = $cron_type . '123';
          #$fp = fopen($sourcedir."log_file.txt","w");
          #fputs($fp, $OUTPUT);
          #fclose($fp);
		  #@chmod($sourcedir."log_file.txt", 0755);

if ($config['cron_lock'])
{
	// if the other process is running more than an hour already we have to assume it
	// aborted without cleaning the lock
	$time = explode(' ', $config['cron_lock']);
	$time = $time[0];

	if ($time + 3600 >= time())
	{
		exit;
		
	}
}

define('CRON_ID', time() . ' ' . RandomAlpha(32));
		$time_now = time();
		$cron_type = 'queue';

		if ($time_now - $config['queue_interval'] > $config['last_queue_run'] && !defined('IN_ADMIN') && file_exists($phpbb_root_path . 'cache/queue.' . $phpEx))
		{
			// Process email queue
			$cron_type = 'queue';
		}
		else if (method_exists($pmbt_cache, 'tidy') && $time_now - $config['cache_gc'] > $config['cache_last_gc'])
		{
			// Tidy the cache
			$cron_type = 'tidy_cache';
		}
		else if ($config['warnings_expire_days'] && ($time_now - $config['warnings_gc'] > $config['warnings_last_gc']))
		{
			$cron_type = 'tidy_warnings';
		}
		else if ($time_now - $config['database_gc'] > $config['database_last_gc'])
		{
			// Tidy the database
			$cron_type = 'tidy_database';
		}
		else if ($time_now - $config['search_gc'] > $config['search_last_gc'])
		{
			// Tidy the search
			$cron_type = 'tidy_search';
		}
		else if ($time_now - $config['session_gc'] > $config['session_last_gc'])
		{
			$cron_type = 'tidy_sessions';
		}
//logerror($cron_type,'ERROR');
$sql = 'UPDATE ' . $db_prefix."_settings
	SET config_value = '" . $db->sql_escape(CRON_ID) . "'
	WHERE config_name = 'cron_lock' AND config_value = '" . $db->sql_escape($config['cron_lock']) . "'";
$db->sql_query($sql);
// another cron process altered the table between script start and UPDATE query so exit
if ($db->sql_affectedrows() != 1)
{
	exit;
}
switch ($cron_type)
{
	case 'queue':
		if (time() - $config['queue_interval'] <= $config['last_queue_run'] || !file_exists($phpbb_root_path . 'cache/queue.' . $phpEx))
		{
			break;
		}

		include_once($phpbb_root_path . 'include/function_messenger.' . $phpEx);
		$queue = new queue();

		$queue->process();

	break;

	case 'tidy_cache':

		if (time() - $config['cache_gc'] <= $config['cache_last_gc'] || !method_exists($pmbt_cache, 'tidy'))
		{
			break;
		}

		$pmbt_cache->tidy();

	break;

	case 'tidy_search':
		
		// Select the search method
		$search_type = basename($config['search_type']);

		if (time() - $config['search_gc'] <= $config['search_last_gc'] || !file_exists($phpbb_root_path . 'includes/search/' . $search_type . '.' . $phpEx))
		{
			break;
		}

		include_once("{$phpbb_root_path}includes/search/$search_type.$phpEx");

		// We do some additional checks in the module to ensure it can actually be utilised
		$error = false;
		$search = new $search_type($error);

		if ($error)
		{
			break;
		}

		$search->tidy();

	break;

	case 'tidy_warnings':

		if (time() - $config['warnings_gc'] <= $config['warnings_last_gc'])
		{
			break;
		}

		include_once('admin/functions.php');

		tidy_warnings();

	break;

	case 'tidy_database':

		if (time() - $config['database_gc'] <= $config['database_last_gc'])
		{
			break;
		}

		include_once('admin/functions.php');

		tidy_database();

	break;

	case 'tidy_sessions':

		if (time() - $config['session_gc'] <= $config['session_last_gc'])
		{
			break;
		}

		$user->session_gc();

	break;

	case 'prune_forum':

		$forum_id = request_var('f', 0);

		$sql = 'SELECT forum_id, prune_next, enable_prune, prune_days, prune_viewed, forum_flags, prune_freq
			FROM ' . $db_prefix . "_forums
			WHERE forum_id = $forum_id";
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		if (!$row)
		{
			break;
		}

		// Do the forum Prune thang
		if ($row['prune_next'] < time() && $row['enable_prune'])
		{
			include_once($phpbb_root_path . 'includes/functions_admin.' . $phpEx);

			if ($row['prune_days'])
			{
				auto_prune($row['forum_id'], 'posted', $row['forum_flags'], $row['prune_days'], $row['prune_freq']);
			}

			if ($row['prune_viewed'])
			{
				auto_prune($row['forum_id'], 'viewed', $row['forum_flags'], $row['prune_viewed'], $row['prune_freq']);
			}
		}

	break;
}
unlock_cron();
function unlock_cron()
{
	global $db, $db_prefix;

	$sql = 'UPDATE '.$db_prefix."_settings
		SET config_value = '0'
		WHERE config_name = 'cron_lock' AND config_value = '" . $db->sql_escape(CRON_ID) . "'";
	$db->sql_query($sql);
}

if ($autoscrape) multiscrape();
exit();
?>