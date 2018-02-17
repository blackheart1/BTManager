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
* @version $Id: 3.0.0 webupdate.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
$user->set_lang('admin/webupdate',$user->ulanguage);
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