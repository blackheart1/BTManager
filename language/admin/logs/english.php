<?php
/**
*
* ucp [English]
*
* @package language
* @version $Id$
* @copyright (c) 2005 phpBB Group
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
	'ADMIN'						=> 'Admin',
	'_ASCENDING'						=> 'Ascending',
	'_DESCENDING'						=> 'Descending',
	'ACP_ADMIN_LOGS'					=> 'Admin log',
	'ACP_ADMIN_LOGS_EXPLAIN'			=> 'This lists all the actions carried out by board administrators. You can sort by username, date, IP or action. If you have appropriate permissions you can also clear individual operations or the log as a whole.',
	'ACP_CRITICAL_LOGS_EXPLAIN'			=> 'This lists the actions carried out by the board itself. This log provides you with information you are able to use for solving specific problems, for example non-delivery of e-mails. You can sort by username, date, IP or action. If you have appropriate permissions you can also clear individual operations or the log as a whole.',
	'ACP_MOD_LOGS_EXPLAIN'				=> 'This lists all actions done on forums, topics and posts as well as actions carried out on users by moderators, including banning. You can sort by username, date, IP or action. If you have appropriate permissions you can also clear individual operations or the log as a whole.',
	'ACP_USERS_LOGS_EXPLAIN'			=> 'This lists all actions carried out by users or on users (reports, warnings and user notes).',
	'SORT_USERNAME'						=> 'Username',
	'SORT_DATE'							=> 'Date',
	'NO_AUTH_ACC'						=>	'You DO NOT have Permissions to Access Logs',
	'AUTH_CLEAR_LOGS_FAIL'				=>	'You are not Autherized to clear the Logs',
	'SORT_IP'							=> 'IP address',
	'SORT_ACTION'						=> 'Log action',
	'NO_ENTRIES'						=> 'No log entries for this period.',
	'SORT_IP'							=> 'IP address',
	'SORT_DATE'							=> 'Date',
	'SORT_ACTION'						=> 'Log action',
	'SEARCH_KEYWORDS'					=> 'Search for keywords',
	'IP'								=> 'Users IP',
	'TIME'								=> 'Time/Date',
	'CONFIRM_OPERATION'					=> 'Are you sure you wish to carry out this operation?',
	'PRUNE_SUCCESS'						=> 'Pruning of logs was successful.',
	'PRUNE_SEL_SUCCESS'					=> 'Pruning of Sellected logs was successful.',
	'A_CLEAR_LOG'						=> 'Cleared admin log',
	'EXT_GROUP_ARCHIVES'			=> 'Archives',
	'EXT_GROUP_DOCUMENTS'			=> 'Documents',
	'EXT_GROUP_DOWNLOADABLE_FILES'	=> 'Downloadable Files',
	'EXT_GROUP_FLASH_FILES'			=> 'Flash Files',
	'EXT_GROUP_IMAGES'				=> 'Images',
	'EXT_GROUP_PLAIN_TEXT'			=> 'Plain Text',
	'EXT_GROUP_QUICKTIME_MEDIA'		=> 'Quicktime Media',
	'EXT_GROUP_REAL_MEDIA'			=> 'Real Media',
	'EXT_GROUP_WINDOWS_MEDIA'		=> 'Windows Media',
));
?>