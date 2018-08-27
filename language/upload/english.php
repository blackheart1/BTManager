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
** File upload/english.php 2018-08-27 07:17:00 Thor
**
** CHANGES
**
** 2018-03-02 - Added New Masthead
** 2018-03-02 - Added New !defined('IN_PMBT')
** 2018-03-02 - Fixed Spelling
** 2018-04-28 - Amended the Wording of some Sentences
**/

if (!defined('IN_PMBT'))
{
    include_once './../../security.php';
    die ('Error 404 - Page Not Found');
}

if (empty($lang) || !is_array($lang))
{
    $lang = array();
}

$lang = array_merge($lang, array(
    'UPLOAD_TABLE'      => '',
    'INTRO'             => 'Please Select your Upload Type',

    'INTRO_EXP_SEL'     => 'You can Upload a Torrent File, an eD2K/Magnet Links by Clicking on the Options Provided',

    'UPLOAD_A_TORRENT'  => 'Upload a Torrent File',
    'UPLOAD_A_EDTWOK'   => 'Submit eD2K/Magnet Link',
    'INTRO_TORRENT'     => 'Select your File',

    'INTRO_TORRENT_EXP' => '<br />The Tracker\'s Announce URL is:<br /><strong>%1$s</strong><br /><br />Please <strong>Only</strong> Upload Torrents that are Seeded.  Torrents without Peers will NOT show up on the Main Page.',

    'UPLOAD_FILE'         => 'Select Torrent',
    'UPLOAD_FILE_EXP'     => 'Choose a (.)torrent File from your Computer to Upload to the Site',
    'UPLOAD_NFO'          => 'Upload NFO',
    'UPLOAD_NFO_EXP'      => 'An (.)nfo File is a Text File containing Information about this Torrent.',
    'UPLOAD_NAME'         => 'Torrent Name',
    'UPLOAD_NAME_EXP'     => 'Will be Generated from the Filename if Left Blank.  Try to give it a Descriptive Name',
    'UPLOAD_IMDB'         => 'IMDB LINK',
    'UPLOAD_IMDB_EXP'     => 'Add IMDB to Details Page by Providing an IMDB Link or IMDB NUMBER',
    'MESSAGE_BODY'        => 'Description',
    'MESSAGE_BODY_EXP'    => 'Please Provide as much Information about your Upload as you can',
    'UPLOAD_POSTER'       => 'Poster',
    'UPLOAD_SCREEN_A'     => 'Screenshot 1',
    'UPLOAD_SCREEN_B'     => 'Screenshot 2',
    'UPLOAD_SCREEN_C'     => 'Screenshot 3',
    'UPLOAD_SCREEN_D'     => 'Screenshot 4',
    'UPLOAD_POSTER_EXP'   => '(Direct Link for a Poster, Poster Upload %1$s)',
    'UPLOAD_SCREEN_A_EXP' => '(Direct Link for a Screenshot 1)',
    'UPLOAD_SCREEN_B_EXP' => '(Direct Link for a Screenshot 2)',
    'UPLOAD_SCREEN_C_EXP' => '(Direct Link for a Screenshot 3)',
    'UPLOAD_SCREEN_D_EXP' => '(Direct Link for a Screenshot 4)',
    'UPLOAD_CHECK_SEM'    => 'Check for Similar Torrents',

    'UPLOAD_CHECK_SEM_EXP'    => 'Prevents Uploading of Torrents Similar to ones already on the List.  Uncheck to Upload anyway.  Remember that having Duplicate Torrents for Identical Files Reduces the Overall Efficiency.',

    'UPLOAD_RATO_BUILDER'     => 'Ratio Builder',

    'UPLOAD_RATO_BUILDER_EXP' => 'Choosing this Option will Allow Users to Download the File without it affecting their Download Ratio but, they will get Credit for ALL that they Upload.',

    'UPLOAD_ADVANCED_OP'      => 'Advanced Options',

    'UPLOAD_ADVANCED_OP_EXP'  => 'Show Advanced Options.  This Controls some Technical Aspects of the Torrent.  Use these Options <strong>ONLY</strong> if you know what you\'re doing!',

    'UPLOAD_ADVANCED_OP_DHT_EXP' => 'This Forces DHT Backup Tracking on your Torrent, or Disables it.  DHT is useful when the Main Tracker goes Offline or is Overloaded',

    'UPLOAD_ADVANCED_OP_PRIVATE_EXP' => 'The <strong>Private</strong> Option (which ONLY some Clients can handle), tells the Client to Deal Only with Peers it Receives from the Central Tracker.  Enabling the Private Option Disables DHT',

    'UPLOAD_ADVANCE_NOEDIT'      => 'DO NOT Edit this Setting',
    'UPLOAD_ADVANCE_DHT'         => 'DHT Support',
    'UPLOAD_ADVANCE_DHT_INABLE'  => 'Force Backup DHT Tracking',
    'UPLOAD_ADVANCE_DHT_DISABLE' => 'Disable DHT Tracking',
    'UPLOAD_ADVANCE_PVT'         => 'Private Torrent',
    'UPLOAD_ADVANCE_PVT_INABLE'  => 'Mark Torrent as Private',
    'UPLOAD_ADVANCE_PVT_DISABLE' => 'Mark Torrent as Public',

    'UPLOAD_PASSWORD_EXP'       => 'You may choose a Password to Protect your Torrent from Unauthorised Viewing.  If a Password is Set, the Torrent will NOT be Visible in the Torrent List or the Torrent Search except for, Premium Users and Administrator\'s.  You will have to provide a Direct Link to the people that you want to Access the Torrent.  Only Internal Torrents can be Password Protected.',

    'UPLOAD_OWNER_TYPE'         => 'Display Name',

    'UPLOAD_OWNER_TYPE_EXP'     => '<strong>SHOW USER</strong> Allows other Users to see your Username,<br /><strong>PRIVACY MODE</strong> Hides it, retaining Edit/Delete Permissions,<br /><strong>STEALTH MODE</strong> (if available) Completely Hides the Owner to the System, and <strong>DOES NOT</strong> Allow any Changes to be made by the User.',

    'UPLOAD_OWNER_TYPE_SHOW'    => 'Show User',
    'UPLOAD_OWNER_TYPE_HIDE'    => 'Privacy Mode',
    'UPLOAD_OWNER_TYPE_RELEASE' => 'Stealth Mode',
    'UPLOAD_NOTIFY'             => 'Notifications',
    'UPLOAD_NOTIFY_NEW_SEED'    => 'Receive email Notifications when a Leecher Completes the File (Only Torrents on Local Tracker)',

    'UPLOAD_NOTIFY_COMMENT' => 'Receive email Notifications when a Comment is Added',
    'UPLOAD_STICKY'         => 'Sticky',

    'UPLOAD_STICKY_EXP'     => 'Mark Torrent as Sticky to Keep it to the Top of the List.  Restricted to Moderators/Administrator',

    'UPLOAD_SHOUT'          => 'Shout New Upload',

    'UPLOAD_SHOUT_EXP'      => 'Automatically Post a New Shout in the Shoutbox (It will appear as if you made the Shout).<br />This Only Works if Permitted by the System.',

    'NO_CAT_SELECTED'         => 'No Category Selected.  Please go back to the Upload Form.',
    'INVALID_CATEGORY'        => 'Illegal Category!',
    'ADD_FILE_FIRST'          => 'You have to Submit at least One File using the Appropriate Button',
    'GO_BACK'                 => 'Go Back',
    'EMPTY_FILE_NAME'         => 'Empty Filename!',
    'INVALID_VILE_NAME'       => 'Invalid Filename!',
    'NO_TORRENT_FILE'         => 'This is NOT a Torrent File (.torrent)',
    'EMPTY_NFO_NAME'          => 'Invalid NFO Filename!',
    'ERROR_INUPLOAD'          => 'Upload Failed!',
    'NO_TORRENT_UPLOADED'     => 'Fatal Error in Uploaded Torrent File!',
    'EMPTY_TORRENT_FILE'      => 'The Torrent File your Uploading is Empty!',
    'NO_NFO_UPLOADED'         => 'Fatal Error in Uploaded NFO File!',
    'NOT_NFO_FILE'            => 'This is NOT an NFO File (.nfo)',
    'EMPTY_NFO_FILE'          => 'The NFO File is Empty!',
    'ERROR_IN_UPLOAD'         => 'There was a Problem while Uploading.  Please go back and Fix the Issue and try again!',
    'INVALID_PEASES'          => 'This Torrent contains Invalid Pieces!',
    'NO_DESCR'                => 'There was NO Description entered for the Upload.  Please go back and correct this!',

    'NO_HTML_ALLOWED'         => 'You are NOT Allowed to use HTML Code in your Description.  We provide you with BBcodes to use instead.',

    'NO_JAVA_ALLOW'           => 'Java Code is NOT Allowed in the Torrent Description.  Ever!',
    'LOCAL_TRACKER_DISABLED'  => 'Our Internal Tracker is Currently Disabled.  Only External Torrents can be Uploaded.',

    'TRACKER_IS_BLACK_LISTED' => 'The Tracker used by this Torrent (<strong>%1$d</strong>) has been Blacklisted.  Please use a Different Tracker.',

    'MISSING_ANNOUNCE_STRING' => 'You are Uploading an Invalid Torrent, it contains NO Tracker Announce URL.',
    'MISSING_INFO_DICTIONARY' => 'There appears to be a Issue with your Torrent, there are NO Files Included in it.',
    'MISSING_LENGTH_STRING'   => 'There appears to be a Issue with the Torrent\'s File Length.',
    'MISSING_PIECES_STRING'   => 'There appears to be a Issue with the Torrent\'s Hex String.',
    'BANNED_TORRENT'          => 'This Torrent has been Banned!',

    'TORRENT_TO_SMALL' => 'The Torrent you are Uploading is Only (<strong>%1$d</strong>).  The Site\'s Minimum Size is (<strong>%2$d</strong>)',

    'TORRENT_TO_BIG'   => 'The Torrent you are Uploading is (<strong>%1$d</strong>).  The Site Maximum size is (<strong>%2$d</strong>)',
    'MAX_UPLOADS_SET'  => 'You have already Uploaded your Maximum Daily Upload Quota (<strong>%1$d</strong>)',

    'MAX_SHARE_MET'    => '<p>You can\'t Upload more than <strong>%1$d</strong> Files in any 24 hour period.</p><p>You have already Uploaded <strong>%2$d</strong> Files, Totalling <strong>%3$d</strong>',

    'ELEGALE_CONTENT'  => 'Your Torrent didn\'t make it through the Automatic Content Filter for the following Reason (if specified):. %1$d .:  If you feel that you\'re getting this Message in Error, please contact %2$d',

    'DUPLICATE_UPLOAD' => 'You are Attempting to Upload a Duplicate File %1$d',
    'NOTICE'           => 'Notice!',

    'SCARPE_NOT_REG'   => 'Torrent Does NOT seem to be Registered on the External Tracker.  You can ONLY Upload External Torrents if they\'re Active.',

    'INVALID_TRACKER_RESPONCE' => 'Invalid Data from External Tracker.  The Tracker may have Issues with it\'s Server?  Please try again later.',

    'NO_SEEDERS'              => 'Your Torrent is NOT Seeded!',
    'NO_SEEDERS_NOT ALLOWED'  => 'Sorry we DO NOT Allow Torrents that are NOT Seeded!',
    'INVALID_POSTER_URL'      => 'The Link you Provided for your Poster Image is Invalid your Link must Start with http://',
    'INVALID_POSTER_TYPE'     => 'The Poster Filename you entered is NOT in (gif|jpg|jpeg|png) format.',
    'INVALID_SCREEN_URL'      => 'The Link you Provided for your Poster is Invalid your Link must Start http://',
    'INVALID_SCREEN_TYPE'     => 'The Screenshot Filename you entered is NOT in (gif|jpg|jpeg|png) format.',
    'UPLOAD_SUCCESSFUL'       => 'Upload Successful.',

    'SUCCESS_UPLOAD_COMPL'    => 'Successfully Uploaded.  You will be Redirected back to the Torrent Details Page in 3 seconds.  Remember to Seed, or the Torrent won\'t be Visible on the Main Page.<br />Click <a href=\'%1$d\'>HERE</a> if your Browser doesn\'t forward you.',

    'NOTIVY_NEW_COMMENT'      => 'You have been Added to the Notification List: you\'ll be emailed about New Comments.',
    'NOTIFY_NEW_SEED'         => 'You have been Added to the Notification List: you\'ll be emailed about New Seeds.',
    'ADD_FILE'                => 'Add File',
    'UPLOAD_LINK'             => 'Post an eD2K/Magnet Link',
    'EXTERNAL_NOT_ALLOWED'    => 'External Torrents are Not Allowed on this Site.',

    'UPLOAD_LINK_EXP'  => 'Post Only if the File is being Shared.<br />The Link will NOT be Accepted, if more than half of the Files you Submit are already Present on the Index.  Duplicates Reduce the Overall Efficiency',

    'ADD_LINK_FILE'    => 'Enter Link(s) for your File, and Hit \'Add File\'.  The eD2K Link is Mandatory and will be Generated by the System if NOT Added.  You can Add more than one File to your Submission.',

    'FILTER_FAIL'      => 'Your Torrent didn\'t make it through the Automatic Content Filter for the following Reason (if specified):.',

    'FILTER_FAIL_INFO' => 'If you feel that you\'re getting this Message in Error, please contact the Administrator',

    'INVALID_EXEEM_LINK'      => 'Invalid eXeem Link!',
    'LINKS_FILE_NOT_MATCH'    => 'The Links you entered DO NOT Represent the same File',
    'INVALID_ED_LINK'         => 'Invalid eD2K Link',
    'INVALID_MAG_LINK'        => 'Invalid Magnet Link',
    'DUPLICATE_FILES'         => 'Duplicate File',
    'DUPLICATE_FILES_NOT_ALL' => 'Duplicate Files are NOT Allowed',
    'LIST_ALTERED'            => 'The File List has been Altered!  It has NOT been Created using this Tool.',

    'ACCOUNT_PARKED'          => 'This Account has been Parked!  If you are the Owner of this Account please Disable \'Park Account\' in the User Control Panel',

    'ACCOUNT_DISABLED'        => 'This Account has been Disabled for %1$s',
    'ATTACH_FILE'             => 'Attach Files',
    'YOUR_IMAGE_BUCKET'       => 'Your Image Bucket',
    'VALID_EXTENTIONS'        => 'Valid File Extensions: bmp, gif, jpe, jpeg, jpg, png',
    'MANAGE_ATTACHMENTS'      => 'Manage Attachments',
    'ADD_EDIT_ATTACHMENTS'    => 'Click here to Add or Edit Files Attached to this Message',
));

?>