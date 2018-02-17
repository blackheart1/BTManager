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
	'INTRO'					=>	'Client Ban',
	'INTRO_EXP'				=>	'This is Where you can ban Torrent Client!<br />You can ban eather the hole client or one version of the Client <br />To add  client you well need the pier_id info from the Client You well use such as With<br /> &micro;Torrent 1.8.1 You would add UT1810.<br />The reason for the Ban well be shown in the client So you well want to keep this short.',
	'NO_ENTRIES'			=> 'No Torrent entries for this period.',
	'TOR_NAME'				=>	'Torrent Name',
	'TRACKER'				=> 'Tracker',
	'LEECHERS'				=> 'Leechers',
 ));

?>