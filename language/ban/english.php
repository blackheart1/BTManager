<?php
/*
*------------------------------phpMyBitTorrent V 3.0.0-------------------------* 
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
*--------            ©2013 BT.Manager Development Team                 --------*
*-----------               http://btmagaer.com                      -----------*
*------------------------------------------------------------------------------*
*--------------------   Monday, April 15, 2013 6:20 PM    ---------------------*
*
*
* ban [English]
*
* @package language
* @version $Id$
* @copyright (c) 2013 BT.Manager Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}
$lang = array_merge($lang, array(
	'1_HOUR'		=> '1 hour',
	'30_MINS'		=> '30 minutes',
	'6_HOURS'		=> '6 hours',

	'ACP_BAN_EXPLAIN'	=> 'Here you can control the banning of users by name, IP or e-mail address. These methods prevent a user reaching any part of the board. You can give a short (maximum 3000 characters) reason for the ban if you wish. This will be displayed in the admin log. The duration of a ban can also be specified. If you want the ban to end on a specific date rather than after a set time period select <span style="text-decoration: underline;">Until -&gt;</span> for the ban length and enter a date in <kbd>YYYY-MM-DD</kbd> format.',

	'BAN_EXCLUDE'			=> 'Exclude from banning',
	'BAN_LENGTH'			=> 'Length of ban',
	'BAN_REASON'			=> 'Reason for ban',
	'BAN_GIVE_REASON'		=> 'Reason shown to the banned',
	'BAN_UPDATE_SUCCESSFUL'	=> 'The banlist has been updated successfully.',

	'EMAIL_BAN'					=> 'Ban one or more e-mail addresses',
	'EMAIL_BAN_EXCLUDE_EXPLAIN'	=> 'Enable this to exclude the entered e-mail address from all current bans.',
	'EMAIL_BAN_EXPLAIN'			=> 'To specify more than one e-mail address enter each on a new line. To match partial addresses use * as the wildcard, e.g. <samp>*@hotmail.com</samp>, <samp>*@*.domain.tld</samp>, etc.',
	'EMAIL_NO_BANNED'			=> 'No banned e-mail addresses',
	'EMAIL_UNBAN'				=> 'Un-ban or un-exclude e-mails',
	'EMAIL_UNBAN_EXPLAIN'		=> 'You can unban (or un-exclude) multiple e-mail addresses in one go using the appropriate combination of mouse and keyboard for your computer and browser. Excluded e-mail addresses are emphasised.',

	'IP_BAN'					=> 'Ban one or more IPs',
	'IP_BAN_EXCLUDE_EXPLAIN'	=> 'Enable this to exclude the entered IP from all current bans.',
	'IP_BAN_EXPLAIN'			=> 'To specify several different IPs or hostnames enter each on a new line. To specify a range of IP addresses separate the start and end with a hyphen (-), to specify a wildcard use “*”.',
	'IP_HOSTNAME'				=> 'IP addresses or hostnames',
	'IP_NO_BANNED'				=> 'No banned IP addresses',
	'IP_UNBAN'					=> 'Un-ban or un-exclude IPs',
	'IP_UNBAN_EXPLAIN'			=> 'You can unban (or un-exclude) multiple IP addresses in one go using the appropriate combination of mouse and keyboard for your computer and browser. Excluded IPs are emphasised.',

	'LENGTH_BAN_INVALID'		=> 'The date has to be formatted <kbd>YYYY-MM-DD</kbd>.',

	'PERMANENT'		=> 'Permanent',
	
	'UNTIL'						=> 'Until',
	'USER_BAN'					=> 'Ban one or more usernames',
	'USER_BAN_EXCLUDE_EXPLAIN'	=> 'Enable this to exclude the entered users from all current bans.',
	'USER_BAN_EXPLAIN'			=> 'You can ban multiple users in one go by entering each name on a new line. Use the <span style="text-decoration: underline;">Find a member</span> facility to look up and add one or more users automatically.',
	'USER_NO_BANNED'			=> 'No banned usernames',
	'USER_UNBAN'				=> 'Un-ban or un-exclude usernames',
	'USER_UNBAN_EXPLAIN'		=> 'You can unban (or un-exclude) multiple users in one go using the appropriate combination of mouse and keyboard for your computer and browser. Excluded users are emphasised.',
	

));
?>