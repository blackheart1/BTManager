<?php
/**
*
* email [English]
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
	'NEW_PM_EMAIL'				=>	'%1$,' . "\n\n" . 'you are receiving this message because user %2$ has sent you a private message on %3$.\nYou can read the message at %4$/pm.php?mid=%5$* after logging in.\nIf you feel bothered by the sender, use the blacklist function.This way you won\'t receive any more messages from the user.' . "\n\n" . 'Regards,' . "\n" . '%3$ Staff' . "\n" . '%4$',
	'NEW_PM_SUB'				=>	'New private message on %1$',
}
?>