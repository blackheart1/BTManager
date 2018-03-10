<?php

/**
**********************
** BTManager v3.0.1 **
**********************
** http://www.btmanager.org/
** https://github.com/blackheart1/BTManager
** http://demo.btmanager.org/index.php
** Licence Info: GPL
** Copyright (C) 2018
** Formerly Known As phpMyBitTorrent
** Created By Antonio Anzivino (aka DJ Echelon)
** And Joe Robertson (aka joeroberts)
** Project Leaders: Black_heart, Thor.
** File details/english.php 2018-03-10 09:27:00 Thor
**
** CHANGES
**
** 2018-03-02 - Added New Masthead
** 2018-03-02 - Added New !defined('IN_PMBT')
** 2018-03-02 - Fixed Spelling
**/

if (!defined('IN_PMBT'))
{
    include_once './../../security.php';
    die ("You can't access this file directly");
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'TITTLE'					=> 'Details for %1$s',
	'VIEW_DETAILS'				=> 'Torrent Information',
	'VIEW_IMDB'					=> 'IMDB Info',
	'VIEW_NFO'					=> 'Torrent NFO',
	'VIEW_RATING'				=> 'View Ratings',
	'VIEW_COMMENTS'				=> 'View Comments',
	'VIEW_PEERS'				=> 'View Peers',
	'PASS_PROT'					=> "Password Protection",
	'AUTH_REQ_MAIL_SUB'			=> 'Download Request on %1$s',
	'PASSWORD_REQ'				=> "This Torrent is Password Protected. The Owner of the Torrent decided to make it Visible ONLY to Authorized Users.<br />Please enter the Password to get Instant Torrent Access.",
	'WRONG_PASS'				=> 'Warning: Wrong Password.<br />Remember that Passwords are Case Sensitive.',
	'UPLOAD_SUCCESS_ANN'		=> 'Torrent Uploaded Successfully',
	'UPLOAD_SUCCESS'			=> 'You can now Start Seeding.',
	'UP_PASS_EXP'				=> 'You Set the Password to: <b>%1$s</b><br />To give Users Access to your Torrent, pass them the following Direct Link: <b>%2$s<b>',
	'HASH_CHANGE'				=> '<b>WARNING</b>: the Torrent has been Modified in such a way that it MUST be Re-downloaded. The File you Uploaded is NOT Valid any more. Please use the Download Button to get the Working Version.',
	'TORRENT_DETAILS'			=> 'Torrent Details',
	'GUEST'						=> 'Guest',
	'COMMENTS'					=> 'Comments',
	'PEER_LIST'					=> 'Peers List',
	'UP_SPEED'					=> 'Upload Speed',
	'DOWN_SPEED'				=> 'Download Speed',
	'SEEDING'					=> 'Seeding',
	'LEECHING'					=> 'Leeching',
	'CONNECTED'					=> 'Connected',
	'TIME_CONNECTED'			=> 'Time Connected',
	'RATINGS'					=> 'Ratings',
	'TOTAL_VOTES'				=> 'Total Vote',
	'OF_FIVE'					=> 'of 5 with',
	'FILE_LIST'					=> 'File List',
	'MINVOTEDNOTMATCHED'		=> 'NO Votes (Required at least %1$s Votes there is Only %2$s)',
	'TOTAL_RATING'				=> '(%1$s of 5 with %2$s Total Vote(s))',
	'NO_VOTE_YOUR_FILE'			=> 'You Can not Vote For your own file',
	'NO_RATING'					=> 'NO Rating',
	'VOTE_A'					=> 'Bad',
	'VOTE_B'					=> 'Not Good',
	'VOTE_C'					=> 'Not Bad',
	'VOTE_D'					=> 'Good',
	'VOTE_E'					=> 'Very Good',
	'V_TOT_COMP'				=> 'User\'s Sent Positive Feedback [<b>%1$s</b>] Times and Negative Feedback [<b>%2$s</b>] Times.',
	'IF_MAX_COMP'				=> 'The Torrent maybe Banned when Reaching a certain Number of Complaints.',
	'YOUR_COMP'					=> 'You said this Torrent is',
	'NOT_APLICABLE_SHORT'		=> 'N/A',
	'DIRECTORS'					=> 'Directors',
	'WRITERS'					=> 'Writers',
	'CAST'						=> 'Cast',
	'FIRST_CAST_BILLED'			=> 'Cast Overview, First Billed Only',
	'STORYLINE'					=> 'Storyline',
	'TAGLINES'					=> 'Taglines',
	'MOTION_PIC_RATING'			=> 'Motion Picture Rating',
	'MPAA'						=> 'MPAA',
	'VIDEOS'					=> 'Videos',
	'ADD_QUICK_THANKS'			=> 'Add a Quick Thank You to the Uploader',
	'ADD_COMMENT'				=> 'Add Comment',
	'WROTE'						=> 'Wrote',
	'NO_COMMENTS'				=> 'NO Comments at this time',
	'NO_PEERS'					=> 'NO Peers',
	'YOURATED_THIS'				=> 'You Rated This!',
	'VOTE'						=> 'Vote',
	'COMPLAINTS'				=> 'Complaints',
	'BAN_TORRENT'				=> 'Ban Torrent',
	'VIEW_SNATCH_LIST'			=> 'View Snatch List',
	'REQ_RESEED'				=> 'Request Reseed',
	'PASS_LINK'					=> 'Password Link',
	'NUKED_TORRENT'				=> 'Nuked Download',
	'TORRENT_DETAILS'			=> 'Torrent Details',
	'FROM'						=> 'From',
	'DL_SIZE'					=> 'Download Size',
	'INFOHASH'					=> 'Infohash',
	'NT_DOWNLOASED'				=> 'Number of Times Downloaded',
	'NT_VIEWED'					=> 'Number of Times Viewed',
	'NT_COMPLETED'				=> 'Number of Times Completed',
	'UPLOADED_BY'				=> 'Uploaded By',
	'CPL_BY'					=> 'Completed By',
	'SCREEN_SHOTS'				=> 'Screenshots',
	'NO_SCREEN_SHOTS'			=> 'NO Screenshots Added',
	'DOWNLOAD_MAGNET_URL'		=> 'Download using Magnet URI',
	'COMPLAINTS_EXP'			=> 'Torrent Complaint Form.<br>This System allows you to Flag Torrents that DO NOT conform our Rules.<br>Once a certain number of Complaints is Reached, the Torrent may be Banned from the List.<br>Please Send Positive Feedback on Torrents that are Good and Legal.<br>This Torrent is',
	'EXPORT'					=> 'Export',
	'EXPORT_EXP'				=> 'Download this Torrent without your Passkey, for Distribution on Sites that provide BitTorrent Index Services',
));

?>