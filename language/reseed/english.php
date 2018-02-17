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
	"RESEED_REQ"					=>	"Reseed Request",
	"ALREAD_REQUISTED"				=>	"You have recently made a Request for this Re-Seed. Please wait longer for another Request.",
	"ALREADY_SEEDED"				=>	'No need for this Request there are seeders <br />%1$s<br /> on this torrent',
	"RESEED_REQ_SENT"				=>	"Your Request for a Re-Seed has been sent to the following members that have Completed this torrent: <br />%1$s",
	"RESEED_PM"						=>	'%1$s has Requested a Re-Seed on the %2$s because there are currently FEW OR NO SEEDERS: <br />click here for more on this file %3$s',
	"THANK_YOU"						=>	"Thank You!",
));
?>