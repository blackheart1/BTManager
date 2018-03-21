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
** File upload/english.php 2018-03-20 14:08:00 Thor
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
    'UPLOAD_TABLE'                   =>	'',
    'INTRO'                          =>	'Please Select You Upload Type',
    'INTRO_EXP_SEL'                  =>	'You can upload a Torrent File, you can Upload a eD2K and Magnet links By clicking on one of the two options provided',
    'UPLOAD_A_TORRENT'               =>	'Upload a Torrent File',
    'UPLOAD_A_EDTWOK'                =>	'Submit eD2K/Magnet Link',
    'INTRO_TORRENT'                  =>	'Select your File',
    'INTRO_TORRENT_EXP'              =>	'This Site\'s Official Tracker is: %1$s<br />Please Only Upload Torrents that are Seeded. Torrents without Peers will NOT show up on the Main Page.',
    'UPLOAD_FILE'                    =>	'Select Torrent',
    'UPLOAD_FILE_EXP'                =>	'Choose a (.)torrent file from your computer to upload to the site',
    'UPLOAD_NFO'                     =>	'Upload NFO',
    'UPLOAD_NFO_EXP'                 =>	'An (.)nfo file is a text file containing information about this torrent.',
    'UPLOAD_NAME'                    =>	'Torrent Name',
    'UPLOAD_NAME_EXP'                =>	'Will be Generated from the Filename if left Blank. Try to give it a Descriptive Name',
    'UPLOAD_IMDB'                    =>	'IMDB LINK',
    'UPLOAD_IMDB_EXP'                =>	'Add IMDB to details page By providing a imdb link or IMDB NUMBER',
    'MESSAGE_BODY'                   =>	'Description',
    'MESSAGE_BODY_EXP'               =>	'Please give as much information about your Upload as you can som people well know what they are getting',
    "UPLOAD_POSTER"                  =>	"Poster",
    "UPLOAD_SCREEN_A"                =>	"Screenshot 1",
    "UPLOAD_SCREEN_B"                =>	"Screenshot 2",
    "UPLOAD_SCREEN_C"                =>	"Screenshot 3",
    "UPLOAD_SCREEN_D"                =>	"Screenshot 4",
    "UPLOAD_POSTER_EXP"              =>	'(Direct link for a poster,Poster Upload %1$s)',
    "UPLOAD_SCREEN_A_EXP"            =>	"(Direct link for a Screenshot 1)",
    "UPLOAD_SCREEN_B_EXP"            =>	"(Direct link for a Screenshot 2)",
    "UPLOAD_SCREEN_C_EXP"            =>	"(Direct link for a Screenshot 3)",
    "UPLOAD_SCREEN_D_EXP"            =>	"(Direct link for a Screenshot 4)",
    'UPLOAD_CHECK_SEM'               =>	'Check for Similar Torrents',
    'UPLOAD_CHECK_SEM_EXP'           =>	'Prevents Uploading of Torrents Similar to Ones Already on the List. Uncheck to upload anyway. Remember that having Duplicate Torrents for Identical Files Reduces Overall Efficiency.',
    'UPLOAD_RATO_BUILDER'            =>	'Ratio Builder',
    'UPLOAD_RATO_BUILDER_EXP'        =>	'Choosing this option allows users to download the file with out it going against there download stats But they get credit for all they upload.',
    'UPLOAD_ADVANCED_OP'             =>	'Advanced Options',
    'UPLOAD_ADVANCED_OP_EXP'         =>	'Show Advanced Options, Controlling some Technical Aspects of the torrent. Use these Options ONLY if you know what you\'re doing!',
    'UPLOAD_ADVANCED_OP_DHT_EXP'     =>	'This Forces DHT Backup Tracking on your Torrent, or Disables it. DHT is useful when the Main Tracker goes Off-line or is Overloaded',
    'UPLOAD_ADVANCED_OP_PRIVATE_EXP' =>	'The "Private"-Option (which ONLY some Clients can handle), tells the Client to Deal only with Peers it receives from the Central Tracker. Enabling the Private Option Disables DHT',
    'UPLOAD_ADVANCE_NOEDIT'          =>	'DO NOT Edit this Setting',
    'UPLOAD_ADVANCE_DHT'             =>	'DHT Support',
    'UPLOAD_ADVANCE_DHT_INABLE'      =>	'Force Backup DHT Tracking',
    'UPLOAD_ADVANCE_DHT_DISABLE'     =>	'Disable DHT Tracking',
    'UPLOAD_ADVANCE_PVT'             =>	'Private Torrent',
    'UPLOAD_ADVANCE_PVT_INABLE'      =>	'Mark Torrent as Private',
    'UPLOAD_ADVANCE_PVT_DISABLE'     =>	'Mark Torrent as Public',
    'UPLOAD_PASSWORD_EXP'            =>	'You may choose a Password to Protect your Torrent from Unauthorized View. If a Password is Set, the Torrent will NOT
    be Visible to Anyone Except Premium Users and Administrator\'s in the Torrent List and Torrent Search. You will have to provide a Direct Link to the people that you want to Access the Torrent.
    Only Internal Torrents can be Password Protected.',
    'UPLOAD_OWNER_TYPE'              =>	'Display Name',
    'UPLOAD_OWNER_TYPE_EXP'          =>	'\'SHOW USER\' Allows other Users to see your User Name,<br />\'PRIVACY MODE\' Hides it, retaining Edit/Delete Permissions,<br />\'STEALTH MODE\' (if available) Completely Hides the Owner to the System, and Doesn\'t allow any Edit/Deletion by the User.',
    'UPLOAD_OWNER_TYPE_SHOW'         =>	'Show User',
    'UPLOAD_OWNER_TYPE_HIDE'         =>	'Privacy Mode',
    'UPLOAD_OWNER_TYPE_RELEASE'      =>	'Stealth Mode',
    'UPLOAD_NOTIFY'                  =>	'Notifications',
    'UPLOAD_NOTIFY_NEW_SEED'         =>	'Receive email-Notification when a Leecher Completes the File (Only Torrents on Local Tracker)',
    'UPLOAD_NOTIFY_COMMENT'          =>	'Receive email-Notification when a Comment is Added',
    'UPLOAD_STICKY'                  =>	'Sticky',
    'UPLOAD_STICKY_EXP'              =>	'Mark Torrent as Sticky and keep it on the top of the list. Restricted to Moderators/Admins',
    'UPLOAD_SHOUT'                   =>	'Shout new upload',
    'UPLOAD_SHOUT_EXP'               =>	'Automaticaly post a New shout in the shoutbox (It well appear as if you made the shout).<br />This only works if permitted by the system.',
    'NO_CAT_SELECTED'                =>	'No Category Selected. Please go back to the Upload Form.',
    'INVALID_CATEGORY'               =>	'Illegal Category!',
    'ADD_FILE_FIRST'                 =>	'You have to Submit at least One File using the Appropriate Button',
    'GO_BACK'                        =>	'Go Back',
    'EMPTY_FILE_NAME'                =>	'Empty File name',
    'INVALID_VILE_NAME'              =>	'Invalid File name',
    'NO_TORRENT_FILE'                =>	'This is NOT a Torrent File (.torrent)',
    'EMPTY_NFO_NAME'                 =>	'Invalid NFO File name',
    'ERROR_INUPLOAD'                 =>	'Upload Failed!',
    'NO_TORRENT_UPLOADED'            =>	'Fatal Error in Uploaded Torrent File.',
    'EMPTY_TORRENT_FILE'             =>	'The Torrent file your uploading is Empty',
    'NO_NFO_UPLOADED'                =>	'Fatal Error in Uploaded NFO File.',
    'NOT_NFO_FILE'                   =>	'This is NOT a NFO File (.nfo)',
    'EMPTY_NFO_FILE'                 =>	'The NFO file is Empty',
    'ERROR_IN_UPLOAD'                =>	'There was a Problem While uploading Please go back and fix the problems and try again.',
    'INVALID_PEASES'                 =>	'This torrent contains Invalid peases!',
    'NO_DESCR'                       =>	'There was No description Filled out for the Upload please go back and fix this!',
    'NO_HTML_ALLOWED'                =>	'You are not allowed to use HTML code in your description We provide you with BBcodes to use',
    'NO_JAVA_ALLOW'                  =>	'Java code is Not allowed In torrent desciption ever!',
    'LOCAL_TRACKER_DISABLED'         =>	'Our Tracker has been Disabled: Only External Torrents can be Uploaded.',
    'TRACKER_IS_BLACK_LISTED'        =>	'The Tracker used by this Torrent (<b>%1$d</b>) has been Blacklisted. Please use a different Tracker.',
    'MISSING_ANNOUNCE_STRING'        =>	'You are uploading a invalid torrent It has no tracker announce.',
    'MISSING_INFO_DICTIONARY'        =>	'There seems to be a problem with your torrent there is not Files included in it.',
    'MISSING_LENGTH_STRING'          =>	'There seems to be a problem with your torrent there is file length.',
    'MISSING_PIECES_STRING'          =>	'There seems to be a problem with your torrent there is not Files hex string.',
    'BANNED_TORRENT'                 =>	'This Torrent has been Banned!',
    'TORRENT_TO_SMALL'               =>	'The torrent you are uploading is only (<b>%1$d</b>) The site min size is (<b>%2$d</b>)',
    'TORRENT_TO_BIG'                 =>	'The torrent you are uploading is (<b>%1$d</b>) The site max size is (<b>%2$d</b>)',
    'MAX_UPLOADS_SET'                =>	'You have already uploaded your max uploads (<b>%1$d</b>) For one day',
    'MAX_SHARE_MET'                  =>	'<p>You can\'t Upload more than <b>%1$d</b> Files in a 24 hour period.</p><p>You have already Uploaded <b>%2$d</b> Files, Totalling <b>%3$d</b>',
    'ELEGALE_CONTENT'                =>	'Your Torrent didn\'t make it through the Automatic Content Filter for the following Reason (if specified):. %1$d .: If you feel that you\'re getting this message in error, please contact %2$d',
    'DUPLICATE_UPLOAD'               =>	'You are atempting to upload a duplicate file %1$d',
    'NOTICE'                         =>	'Notice!',
    'SCARPE_NOT_REG'                 =>	'Torrent does NOT seem to be Registered on the External Tracker. You can upload External Torrents ONLY if they\'re Active.',
    'INVALID_TRACKER_RESPONCE'       =>	'Invalid Data from External Tracker. The Tracker may have Server Problems. Please try again later.',
    'NO_SEEDERS'                     =>	'Your Torrent is NOT Seeded!',
    'NO_SEEDERS_NOT ALLOWED'         =>	'Sorry we do not allow Torrents that are not seeded!',
    'INVALID_POSTER_URL'             =>	'The link you provided for your Poster is invalid Must link must start http://',
    'INVALID_POSTER_TYPE'            =>	'The Poster you specified is not a (gif|jpg|jpeg|png).',
    'INVALID_SCREEN_URL'             =>	'The link you provided for your Poster is invalid Must link must start http://',
    'INVALID_SCREEN_TYPE'            =>	'The Screen you specified is not a (gif|jpg|jpeg|png).',
    'UPLOAD_SUCCESSFUL'              =>	'Upload Successfuly',
    'SUCCESS_UPLOAD_COMPL'           =>	'Successfully Uploaded. You are being redirected to the Torrent Details Page in 3 seconds. Remember to Seed, or the Torrent won\'t be Visible on the Main Page.<br>Click <a href="%1$d">HERE</a> if your Browser doesn\'t forward you.',
    'NOTIVY_NEW_COMMENT'             =>	'You have been Added to the Notification List: you\'ll be emailed about New Comments.',
    'NOTIFY_NEW_SEED'                =>	'You have been Added to the Notification List: you\'ll be emailed about New Seeds.',
    'ADD_FILE'                       =>	'Add File',
    'UPLOAD_LINK'                    =>	'Post a eD2K/Magnet link',
    'UPLOAD_LINK_EXP'                =>	'Post only if the file is being shared.<br />The link will NOT be accepted if more than half of the files you submit is already present on the index. Duplicates reduce overall efficiency',
    'ADD_LINK_FILE'                  =>	'Enter link(s) for your file, and hit \'Add File\'. The eD2K link is obligatory and well be generated by the system if not added. You can add more than one file to your submission.',
    'FILTER_FAIL'                    =>	'Your Torrent didn\'t make it through the Automatic Content Filter for the following Reason (if specified):.',
    'FILTER_FAIL_INFO'               =>	'If you feel that you\'re getting this message in error, please contact the Admin',
    'INVALID_EXEEM_LINK'             =>	'Invalid eXeem Link!',
    'LINKS_FILE_NOT_MATCH'           =>	'The Links you Entered DO NOT Represent the same File',
    'INVALID_ED_LINK'                =>	'Invalid eD2K Link',
    'INVALID_MAG_LINK'               =>	'Invalid Magnet Link',
    'DUPLICATE_FILES'                =>	'Duplicate File',
    'DUPLICATE_FILES_NOT_ALL'        =>	'Duplicate File are NOT Allowed',
    'LIST_ALTERED'                   =>	'The File List has been Altered! It has NOT been created using this Tool.',
    'ACCOUNT_PARKED'                 => 'This Account Has been parked! If you are the owner of this account please Disable account parked in settings',
    'ACCOUNT_DISABLED'               => 'This account has Been Disabled for %1$s',
));

?>