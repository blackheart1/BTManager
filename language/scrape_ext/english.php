<?php
/**
*
* scrape_ext [English]
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
	'TITLE'				=>	'Peer update for',
	'AUTH_FAILD'		=>	'Autherazation Failed',
	'GROUP_NOT_AU'		=>	'Your Group permitions do not allow you to update Peers',
	'TRACKER_MISSING'	=>	'Tracker not listed',
	'ERROR_TRACKER_MIS'	=>	'There seems to be an error the tracker you requested %1$s is not listed',
	'INFO_HASH'			=>	'Info Hash',
	'DECODED_DATA'		=>	'Here id the decoded responce from the tracker.',
));
?>