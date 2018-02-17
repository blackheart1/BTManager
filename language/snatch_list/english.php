<?php
/**
*
* edit [English]
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
	'SNATCH_DETAILS'							=>	'Snatch Detailles',
	'FIRST_LIST_EXP'							=>	'The Users at the top finished the download most recently',
	'USER_INFO'									=>	'User Info',
	'GLOBAL_STATS'								=>	'Global Stats',
	'DOWN_LOAD_STATS'							=>	'Download Stats',
));
?>