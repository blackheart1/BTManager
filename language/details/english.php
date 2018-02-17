<?php
/**
*
* details [English]
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
	'TITTLE'					=>	'Details for %1$s',
	'VIEW_DETAILS'				=>	'Torrent Info',
	'VIEW_IMDB'					=>	'IMDB Info',
	'VIEW_NFO'					=>	'Torrent NFO',
	'VIEW_RATING'				=>	'View Ratings',
	'VIEW_COMMENTS'				=>	'View Comments',
	'VIEW_PEERS'				=>	'View Peers',
	'PASS_PROT'					=>	"Password Protection",
	'AUTH_REQ_MAIL_SUB'			=>	'Download Request on %1$s',
	'PASSWORD_REQ'				=>	"This Torrent is Password Protected. The Owner of the Torrent decided to make it visible ONLY to Authorized Users.<br />Please provide the Password NOW to get Instant Torrent Access.",
	'WRONG_PASS'				=>	'Warning: Wrong Password.<br />Remember that Passwords are Case-Sensitive.',
	'UPLOAD_SUCCESS_ANN'		=>	'Torrent Uploaded Successfully',
	'UPLOAD_SUCCESS'			=>	'Please Start Seeding NOW. Visibility depends on the number of the sources',
	'UP_PASS_EXP'				=>	'You Set the Password to: <b>%1$s</b><br />To give Users Access to your Torrent, pass them the following Direct Link: <b>%2$s<b>',
	'HASH_CHANGE'				=>	'<b>WARNING</b>: the Torrent has been modified in such a way that it MUST be re-downloaded. The file you uploaded is NOT Valid any more. Please use the download button to get the working version.',
	'TORRENT_DETAILS'			=>	'Torrent Details',
	'GUEST'						=>	'Guest',
	'COMMENTS'					=>	'Comments',
	'PEER_LIST'					=>	'Peers List',
	'UP_SPEED'					=>	'Upload Speed',
	'DOWN_SPEED'				=>	'Download Speed',
	'SEEDING'					=>	'Seeding',
	'LEECHING'					=>	'Leeching',
	'CONNECTED'					=>	'Connected',
	'TIME_CONNECTED'			=>	'Time Connected',
	'RATINGS'					=>	'Ratings',
	'TOTAL_VOTES'				=>	'Total Vote',
	'OF_FIVE'					=>	'of 5 with',
	'FILE_LIST'					=>	'File List',
	'MINVOTEDNOTMATCHED'		=>	'No Votes (Required at least %1$s Votes there is only %2$s)',
	'TOTAL_RATING'				=>	'(%1$s of 5 with %2$s Total Vote(s))',
	'NO_VOTE_YOUR_FILE'			=>	'You Can not Vote For your own file',
	'NO_RATING'					=>	'No Rating',
	'VOTE_A'					=>	'Bad',
	'VOTE_B'					=>	'Not Good',
	'VOTE_C'					=>	'Not Bad',
	'VOTE_D'					=>	'Good',
	'VOTE_E'					=>	'Very Good',
	'V_TOT_COMP'				=>	'Users Sent Positive Feedback [<b>%1$s</b>] times and Negative Feedback [<b>%2$s</b>] times.',
	'IF_MAX_COMP'				=>	'The Torrent may be Banned when Reaching a certain Number of Complaints.',
	'YOUR_COMP'					=>	'You said this Torrent is',
	'NOT_APLICABLE_SHORT'		=>	'N/A',
	'DIRECTORS'					=>	'Directors',
	'WRITERS'					=>	'Writers',
	'CAST'						=>	'Cast',
	'FIRST_CAST_BILLED'			=>	'Cast overview, first billed only',
	'STORYLINE'					=>	'Storyline',
	'TAGLINES'					=>	'Taglines',
	'MOTION_PIC_RATING'			=>	'Motion Picture Rating',
	'MPAA'						=>	'MPAA',
	'VIDEOS'					=>	'Videos',
	'ADD_QUICK_THANKS'			=>	'Add a Quick Thankyou to the uploader',
	'ADD_COMMENT'				=>	'Add Comment',
	'WROTE'						=>	'Wrote',
	'NO_COMMENTS'				=>	'No Comments at this time',
	'NO_PEERS'					=>	'No Peers',
	'YOURATED_THIS'				=>	'You Rated This!',
	'VOTE'						=>	'Votw',
	'COMPLAINTS'				=>	'Complaints',
	'BAN_TORRENT'				=>	'Ban Torrent',
	'VIEW_SNATCH_LIST'			=>	'View Snatch List',
	'REQ_RESEED'				=>	'Request Reseed',
	'PASS_LINK'					=>	'Password Link',
	'NUKED_TORRENT'				=>	'Nuked Down Load',
	'TORRENT_DETAILS'			=>	'Torrent Details',
	'FROM'						=>	'From',
	'DL_SIZE'					=>	'Down Load Size',
	'INFOHASH'					=>	'Infohash',
	'NT_DOWNLOASED'				=>	'Number Of Times Downloaded',
	'NT_VIEWED'					=>	'Number Of Times Viewed',
	'NT_COMPLETED'				=>	'Number Of Times completed',
	'UPLOADED_BY'				=>	'Uploaded By',
	'CPL_BY'					=>	'Completed By',
	'SCREEN_SHOTS'				=>	'Screen Shots',
	'NO_SCREEN_SHOTS'			=>	'No Screen shots added',
	'DOWNLOAD_MAGNET_URL'		=>	'Download using Magnet URI',
	'COMPLAINTS_EXP'			=>	'Torrent Complaint form.<br>This system allows you to Flag Torrents that DO NOT fit our Rules.<br>Once a certain number of Complaints is Reached, the Torrent may be Banned from the List.<br>Please Send Positive Feedback on Torrents that are Good and Legal.<br>This Torrent is',
	'EXPORT'					=>	'Export',
	'EXPORT_EXP'				=>	'Download this Torrent without your Passkey, for Distribution on Sites that provide BitTorrent Index Services',
));
?>