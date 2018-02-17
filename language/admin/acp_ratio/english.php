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
*--------------------   Sunday, May 17, 2010 1:05 AM   ------------------------*
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 image-buket/english.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}
$lang = array_merge($lang, array(
		'TITLE_INDEX'							=> 'Site Warning system',
		'TITLE_EXPLAIN_INDEX'					=> 'In this area You are able to view and edit your waring configs',
		'TITLE_CONFIG'							=> 'Warning Configs',
		'TITLE_EXPLAIN_CONFIG'					=> 'Warning Configs are the settings used by the system to determin who and when to warn a user for a low Ratio.',
		'SECTION_EXPLAIN_CONFIG'				=> 'This is used to alter and set your Warning systems controles.',
		'TITLE_WARNED'							=> 'Ratio Warn System - Warned Users',
		'TITLE_EXPLAIN_WARNED'					=> 'This is a list of users that have been Warned or banned By the system (not including user\'s warned or banned By moderator\'s.)',
		'SECTION_EXPLAIN_WARNED'				=> 'This is a list of users that have been Warned By the system (not including user\'s warned By moderator\'s.)',
		'TITLE_WATCHED'							=> 'Ratio Warn System - Watched/Warned Users',
		'TITLE_EXPLAIN_WATCHED'					=> 'This is a list of user\'s being watched by this system for holding a low ratio on the site.',
		'SECTION_EXPLAIN_WATCHED'				=> 'This is a list of user\'s being watched by this system for holding a low ratio on the site.',
		'BLOCK_TITLE'							=> 'Ratio Warning system',
		'SECTION_TITLE_CONFIG'					=> 'Ratio Warning Configs',
		'SECTION_TITLE_WARNED'					=> 'Ratio Warned Users',
		'SECTION_TITLE_WATCHED'					=> 'Ratio Watched Users',
		'NO_ERROR'								=> 'No error found',
		'SEL_YES_NO'							=> array('true'=>'Yes','false'=>'No'),
		'_admpenableexplain'					=> 'Enable Ratio Warnning System',
		'_admpenable'							=> 'Enable Ratio waning',
		'_admpratio_miniexplain'				=> 'Set the ratio amount to where you want members to be added to the watched list',
		'_admpratio_mini'						=> 'Ratio warn ammount',
		'_admpratio_warnexplain'				=> 'How long in days do you want the user to be watched before They Are WARNNED',
		'_admpratio_warn'						=> 'Warning Time',
		'_admpratio_banexplain'					=> 'How long in days do you want the user to be warnned before They Are BANNED',
		'_admpratio_ban'						=> 'Banning Time',
		'NO_ENTRIES_WARNED'						=> 'No users have been warned for maintaining poor ratios.',
		'BANNED'								=> 'Banned',
		'TIME_TO_BAN'							=> 'Time Until Ban',
		'TO_GO'									=> '%1$s days',
		'USER_STST_UPDATE'						=> 'Status for user %1$s have now been updated!<br />If the user stell has a bad ratio He/She well be added Back to the watch list But his/her warning well be removed.',
		'NO_ENTRIES'							=> 'There are no users currently being watched for poor ratios.',
		'TIME_TO_WARN'							=> 'Time Until Warning',
		'REMOVED_WATCH'							=> 'Remove From Watch',
));

?>