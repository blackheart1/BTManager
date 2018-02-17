<?php
/**
*
* comment [English]
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
	'THANK_YOU'					=>	'Thank You!',
	'NO_ID_SET'					=>	'No ID was set Please recheck your link',
	'BAD_ID_NO_FILE'			=>	'There seems to be an error with the ID.<br />There is no file with that ID.',
	'ALREADY_THANKED'			=>	'You have already posted a Quick Thank You on this torrent.',
	'THANK_TAKEN'				=>	'Thank You was posted',
	'COMMENTNOTIFY_SUB'			=>	'New comment on %1$s',
	'COMENT_ON_TOR'				=>	'Comments on this Torrent.',
	'COMENT_REMOVED'			=>	'Comment Deleted. You are being Redirected to the Torrent Details page in 3 seconds.<br>Click <a href="details.php?id=%1$s&comm=startcomments">HERE</a> if your Browser doesn\'t forward you.',
	'COMMENT_POSTED'			=>	'Your Comment has been Posted. You are being Redirected to the Torrent Details page in 3 seconds.<br>Click <a href="details.php?id=%1$s&comm=startcomments">HERE</a> if your Browser doesn\'t forward you.'
));
?>