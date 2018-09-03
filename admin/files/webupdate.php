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
** File webupdate.php 2018-02-23 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT'))
{
	include_once './../../security.php';
	die ("You can't access this file directly");
}
$user->set_lang('admin/acp_webupdate',$user->ulanguage);
$serverurl = "http://btmanager.org";
$u_action = 'admin.php?i=siteinfo&op=webupdate';

do {
        if (! $ver = @file_get_contents($serverurl."/version")) {
			$template->assign_vars(array(
			'S_VERSION_CHECK'	=> false,
			));
                break;
        }
		$announcement = @file_get_contents($serverurl."/admmessage");
		//echo $announcement;
		$announcement = explode("\n", $announcement);
		$latest_version = trim($ver);
		$announcement_url = trim($announcement[1]);
		$announcement_url = (strpos($siteurl.'/', '&amp;') === false) ? str_replace('&', '&amp;', $announcement_url) : $announcement_url;
		$update_link = append_sid($siteurl.'/setup/index.' . $phpEx, 'mode=update');
		$next_feature_version = $next_feature_announcement_url = false;
		$up_to_date_automatic = (version_compare(str_replace('rc', 'RC', strtolower($version)), str_replace('rc', 'RC', strtolower($latest_version)), '<')) ? false : true;
		$up_to_date = (version_compare(str_replace('rc', 'RC', strtolower($version)), str_replace('rc', 'RC', strtolower($latest_version)), '<')) ? false : true;
		if (isset($announcement[0]) && trim($announcement[0]) !== '')
		{
			$next_feature_version = trim($announcement[0]);
			$next_feature_announcement_url = trim($announcement[1]);
		}
			$template->assign_vars(array(
			'S_UP_TO_DATE'		=> $up_to_date,
			'S_UP_TO_DATE_AUTO'	=> $up_to_date_automatic,
			'S_VERSION_CHECK'	=> true,
			'U_ACTION'			=> $u_action,
			'U_VERSIONCHECK_FORCE' => append_sid($u_action . '&amp;versioncheck_force=1'),

			'LATEST_VERSION'	=> $latest_version,
			'CURRENT_VERSION'	=> $version,
			'AUTO_VERSION'		=> $version_update_from,
			'NEXT_FEATURE_VERSION'	=> $next_feature_version,

			'UPDATE_INSTRUCTIONS'	=> sprintf($user->lang['UPDATE_INSTRUCTIONS'], $announcement_url, $update_link),
			'UPGRADE_INSTRUCTIONS'	=> $next_feature_version ? $user->lang('UPGRADE_INSTRUCTIONS', $next_feature_version, $next_feature_announcement_url) : false,
			));

} while (false);
$pmbt_cache->put('source_version',array('LATEST_VERSION'=>$latest_version));
echo $template->fetch('admin/webupdate.html');
		close_out();
?>