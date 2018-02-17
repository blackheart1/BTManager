<?php
/**
*
* client_bans [English]
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
	'INTRO'					=>	'External Trackers',
	'TRACKER_ACTIVE'		=>	'Tracker is active',
	'TRACKER_OFF_LINE'		=>	'Tracker is Off line',
	'TRACKER_BLACK_LISTED'	=>	'Tracker is <strong>Black Listed</strong>',
	'BLACK_LIST'			=>	'Black list',
	'UNBLACK_LIST'			=>	'UnBlack list',
	'INTRO_EXP'				=>	'With this panel you can monitor the status of External Tracker associated to Torrents. You can set a filter that prevents uploading Torrents from certain Trackers or you can force Tracker update viewing debug information.',
	'NO_ENTRIES'			=>	'No Torrent entries for this period.',
	'TOR_NAME'				=>	'Torrent Name',
	'ANNOUNCE_URL'			=>	'Announce URL',
	'BLACK_LISTED'			=>	'Blacklisted',
	'VIEW_LIST'				=>	'View Torrents',
	'UPDATE_TOR_NOW'		=>	'Update Torrent Now',
	'BANNED_ANNOUNCE'		=>	'Blacklist a Tracker',
	'BANNED_ANNOUNCE_EXP'	=>	'Insert the Announce URL of the Tracker you want to blacklist. All Torrents associated to it will be refused during upload.',
	'CANCEL_MOD'			=>	'Cancel Modifications',
	'INVALID_INCODING'		=>	'Cannot decode Tracker response. Invalid encoding!',
	'TRKRAWDATA'			=>	'Tracker reached. Here is the encoded response.',
	'TRACKER_OFFLINE'		=>	'Cannot contact Tracker. Tracker will be set to \'Off Line\'',
	'UPDATING'				=>	'Updating',
	'DECODED_DATA'			=>	'Decoding completed. Here is all the Scrape data obtained.',
	'NOTOR_ERR'				=>	'There was an error',
	'INFO_HASH'				=>	'Info Hash',
	'INVALID_ANNOUNCE'		=>	'Invalid Announce URL. <br /><strong>“%1$s”</strong>',
	'NO_TORRENTS_LISTED'	=>	'“%1$s” Has no Torrents OR has Been Blacklisted (If not Blacklisted It has been removed From the data base.)',
	'PEER_SUMERY'			=>	'Found <b>“%1$s”</b> seeds, <b>“%2$s”</b> leechers, <b>“%3$s”</b> completed downloads for Torrent “%4$s” Info Hash “%5$s”."',
 ));

?>