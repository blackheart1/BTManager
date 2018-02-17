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
	'REASON'				=>	'Reason',
	'CLIENT'				=>	'Client',
	'NO_CLIENT_BANS'		=>	'No Banned Client\'s At This Time',
	'BANNED_CLIENTS'		=>	'Currently Banned Client\'s',
	'BANNED_CLIENTS_EXP'	=>	'Here is a list of the currently banned Client\'s and the reason',
	'BANNED_CLIENT'			=>	'Add/Edit Ban Client\'s',
	'BANNED_CLIENT_EXP'		=>	'Here is You can Add/Edit  banned Client\'s and the reason',
	'CANCEL_MOD'			=>	'Cancel Modifications',
	'NO_REASON'				=>	'No reason given for ban',
	'SUCES_BAN'				=>	'Client Successfully Banned',
	'SUCES_BAN_EXP'			=>	'The Client “%1$s” Was Successfully Banned For “%2$s”',
	'SUCES_DEL'				=>	'Client Successfully Removed',
	'SUCES_DEL_EXP'			=>	'The Client Was Successfully Removed from Banned ',
	'SUCES_EDT'				=>	'Client Successfully Edited',
	'SUCES_EDT_EXP'			=>	'The Client “%1$s” Was Successfully Updated For “%2$s”',
	'CONFIRM_OPERATION'		=>	'Are you suren you wish to remove this Client from the Ban list?',
	
 ));

?>