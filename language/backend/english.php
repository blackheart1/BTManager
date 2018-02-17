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
		'RSS_BY_CAT'				=>	'Best 10 Torrents for Category %1$s on %2$s\' (files feed)',
		'RSS_BY_BEST'				=>	'Best 10 Torrents on %1$s\' (files feed)',
		'RSS_BY_SEARCH'				=>	'Results for search term %1$s on %2$s\' (files feed)',
		'RSS_BY_LAST'				=>	'The Latest 10 Torrents on %1$s (files feed)',
));
?>