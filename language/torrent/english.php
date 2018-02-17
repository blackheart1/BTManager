<?php
/**
*
* torrent [English]
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
		'ORDER_BY'						=>	'Order By',
		'SEEDS'							=>	'Seeds',
		'INCLUDE_DEAD'					=>	'Include Dead Torrents',
		'ANONUMUS'						=>	'Anonymous',
		'DISPLAY_BY'					=>	'Display Torrents By',
		'SORT_CAT'						=>	'Sort by Type',
		'SORT_NAME'						=>	'Sort by Name',
		'SORT_NUM_FILES'				=>	'Sort by Number of files',
		'SORT_SEED'						=>	'Sort by Seeds',
		'SORT_LEECH'					=>	'Sort by Leechers',
		'SORT_SIZE'						=>	'Sort by size of file',
		'SORT_COMP'						=>	'Sort by times completed',
		'SORT_COMMENTS'					=>	'Sort by number of comments',
		'UPLOADED_BY'					=>	'Uploaded by',
		'AVERAGE_SPEED'					=>	'Average Speed',
		'NUKED_TORRENT'					=>	'Nuked Torrent',
		'FREE_TORRENT'					=>	'Free Torrent',
		'DHT_SUPPORT_EXP'				=>	'This torrent supports DHT. With a state-of-the-art client, you\\\'ll be able to download this torrent even if a central tracker goes down.',
		'STATS_UPTO_DATE'				=>	'Stats Updated less than 30min ago',
		'TORRENT_DETAILS'				=>	'Torrent Details',
		'REFRESHPEER_DATA'				=>	'Refresh Peer Data',
		'BANNED_TORRENT'				=>	'Banned torrent',
		'BANN_TORRENT'					=>	'Bann Torrent',
));
?>