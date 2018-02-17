<?php
/**
*
* common [English]
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
	'FIND_USER_PM'					=>	'Find A User To PM',
	'FIND_USER_PM_EXP'				=>	'Inter the Users name that you wish to find',	
	'ERROR_FIND_USER_PM'			=>	'No User Was Found To PM',
	'ERROR_FIND_USER_PM_EXP'		=>	'No User Was Found!<br />Please If you tried a Full name try and use a partial name or defrent name.',
	'ERROR_TO_MANY_FOUND'			=>	'To Many Users Where Found',	
	'ERROR_TO_MANY_FOUND_EXP'		=>	'Your Search returned to many users!<br />Please narrow your search by adding more carectors to the search feald.',	
	'USER_NAME'						=>	'User Name:',
));
?>