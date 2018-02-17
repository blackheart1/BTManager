<?php
/**
*
* warned [English]
*
* @package language
* @version $Id$
* @copyright (c) 2005 phpMyBitTorrent Group
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
	'ACP_WARNINGS'					=> 'Warned Accounts',
	'ACP_WARNINGS_EXPLAIN'			=> '',
	'USERNAME'						=> 'User Name',
	'REGISTERED'					=> 'Registered',
	'LAST_ACCESS'					=> 'Last Access',
	'CLASS_USER'					=> 'User Class',
	'DOWNLOADED'					=> 'Downloaded',
	'UPLOADED'						=> 'Uploaded',
	'U_RATIO'						=> 'Ratio',
	'MOD_COMM'						=> 'Moderator Comments',
	'SORT_USERNAME'					=> 'User Name',
	'SORT_REG_DATE'					=> 'Registerd Date',
	'SORT_UP'						=> 'Uploaded',
	'SORT_DOWN'						=> 'Down Loaded',
	'SORT_WARN_DATE'				=> 'Date Warned',
	'SORT_BY'	=> 'Sort by',
	'DISPLAY_WARNED'				=> 'Display entries from previous',
));

?>