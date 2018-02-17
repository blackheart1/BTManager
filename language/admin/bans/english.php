<?php
/**
*
* avatar [English]
*
* @package language
* @version $Id$
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}
$lang = array_merge($lang, array(
'MAIN_TITLE'				=>	'User Ban',
'MAIN_TITLE_EXP'				=>	'Use this page to ban users from your tracker. You can define IP ranges to ban and manage banned IPs and users. You can also provide a reason that is presented to the banned user when he/she tries to log in.',
'BANNED_IPS'				=>	'Banned IPs',
'BANNED_IPS_EXP'				=>	'Here is a list of the currently banned IP\'s and the reason',
'START_IP'				=>	'Start IP',
'END_IP'				=>	'End IP',
'REASON'				=>	'Reason',
'BANNED_USERS'				=>	'Banned Users',
'USER_BANNED'				=>	'User Name',
'ADD_EDIT_BAN'				=>	'Add/Edit Ban',
'BAN_IP'				=>	'Ban a IP',
'BAN_IP_EXP'				=>	'Ban a single IP or an entire range',
'BAN_USER_EXP'				=>	'Ban a User By name this is Case sencetive.',
'BAN_USER'				=>	'Ban a user',
'BANNED_USERS_EXP'				=>	'Here is the list of curently banned users',
'CANCEL_MOD'				=>	'Cancel Modifications',
'NO_REASON'				=>'No reason given for ban',
'NO_USER_BANS'			=> 'There are no banned users',
'NO_IP_BANS'			=> 'There are no banned IP\'s',
	'YEAR_MONTH_DAY'	=> '(YYYY-MM-DD)',
));
?>