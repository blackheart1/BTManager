<?php
/**
*
* makepoll [English]
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
		'POLL_MANAGER'					=>	'Poll Management',
		'MAKE_POLL'						=>	'Make Poll',
		'EDIT_POLL'						=>	'Edit Poll',
		'REQ_FEALD'						=>	'Required Feald',
		'QUISTION'						=>	'Poll Quistion',
		'SORT'							=>	'Sort',
		'OPTION_A'						=>	'Option 1',
		'OPTION_B'						=>	'Option 2',
		'OPTION_C'						=>	'Option 3',
		'OPTION_D'						=>	'Option 4',
		'OPTION_E'						=>	'Option 5',
		'OPTION_F'						=>	'Option 6',
		'OPTION_G'						=>	'Option 7',
		'OPTION_H'						=>	'Option 8',
		'OPTION_I'						=>	'Option 9',
		'OPTION_J'						=>	'Option 10',
		'NEW_POLL_NOTICE'				=>	'Note: The current poll (<i>%1$s</i>) is only %2$s old.',
		'WARNING'						=>	'Warning!',
		'HOUR'							=>	'Hour',
		'HOURS'							=>	'Hours',
		'DAY'							=>	'Day',
		'DAYS'							=>	'Days',
		'POLL_EDITED'					=>	'Poll Successfuly Edited',
		'POLL_TAKEN'					=>	'New Poll Has Been Added',
		
));
?>