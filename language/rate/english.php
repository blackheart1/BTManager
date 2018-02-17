<?php
/**
*
* rate [English]
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
	'TORRENT_RATING'				=>	'Torrent Rating',
	'VOTE_FAIL'						=>	'Vote Failed!',
	'INVALID_VOTE'					=>	'Invalid Vote',
	'INVALID_ID'					=>	'Invalid ID. Torrent Does NOT Exist',
	'CANT_RATE_OWN'					=>	'You Cannot Rate your Own Torrents',
	'TORRENT_RATED'					=>	'Torrent Already Rated',
	'CANT_RATE_TWICE'				=>	'We are Sorry, but you can\'t Rate a Torrent Twice',
	'VOTE_TAKEN'					=>	'Vote Successful, you are being Redirected to the Torrent Details Page in 3 seconds.',
	'NO_COMPLAINT_ERR'				=>	'Complaint feald empmty!',
	"BANNED_COMPLAINTS"				=>	"This Torrent has been Banned due to a number of Complaints",
	"TWO_COMPLAINTS_ERR"			=>	"We're Sorry, but you can't send a Complaint twice.",
	"COMPLAINT_TAKEN"				=>	"Complaint Registered. You are being redirected to the Torrent's Detail Page in 3 seconds.",
	"COMPLAINT_REG"					=>	"Your Complaint has been Registered. User Name and IP are Logged: Please DO NOT Abuse the System.<BR>",
	"COMPLAINT_RANK"				=>	'Users Sent Positive Feedback<b>%1$s</b> times and Negative Feedback <b>%2$s</b> times.<BR>',
));
?>