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
** File mcp_clinic/english.php 2018-09-15 08:24:00 Thor
**
** CHANGES
**
** 2018-02-24 - Added New Masthead
** 2018-02-24 - Added New !defined('IN_PMBT')
** 2018-02-24 - Fixed Spelling
** 2018-04-01 - Amended the Wording of some Sentences
** 2018-04-01 - Amended !defined('IN_PMBT') Corrected Path
**/

if (!defined('IN_PMBT'))
{
    include_once './../../../security.php';
    die ("Error 404 - Page Not Found");
}

if (empty($lang) || !is_array($lang))
{
    $lang = array();
}

$lang = array_merge($lang, array(
    'INTRO'                  =>	'TorrentClinic',

    'INTRO_EXP'              =>	'Torrent Clinic Allows you to Check .torrent File Properties.<br /><br /><br />If you are having Issues with a Torrent you can Verify that it has been Generated Correctly.<br /><br />When Uploading a Torrent from your Hard Drive, you will be able to Verify <strong>ALL</strong> the Information that it contains and even Check against Sources!<br /><br />',

    'UPLOAD_TORRENT'         =>	'Upload a Torrent',
    'UPLOAD_LOCAL_FILE'      =>	'Upload a Torrent from your Hard Drive to be Checked.',
    'SHOW_STRUCTURE'         =>	'Show Advanced XML Structures (Useful for Debugging)',
    'FORCE_SCRAPE'           =>	'Force Scrape on External Torrents',
    'ERROR_DECODING'         =>	'Decoding Error!  File is probably NOT a Valid Torrent File.',
    'DECODED_DATA'           =>	'Reading Torrent...',
    'NO_DEFAULT_ANNOUNCE'    =>	'Default Tracker is NOT Set.  Invalid Torrent File.',
    'XML_STRUCTURE'          =>	'XML Structure',
    'CHECK_ANNOUNCE'         =>	'Checking against Default Tracker...',
    'CKECK_DIRECTORY'        =>	'Checking against Info Dictionary...',
    'CKECK_DIRECTORY_ERR'    =>	'Info Dictionary is NOT Present.  Invalid Torrent File.',
    'CHECK_FOUND'            =>	'Found',
    'CHECK_FILES'            =>	'Checking against File Number...',
    'TORRENT_NOT_CONSISTANT' =>	'Torrent is NOT Consistent!',
    'TORRENT_SINGLE_FILE'    =>	'Torrent Contains a Single File',
    'TORRENT_MULTY_FILE'     =>	'Torrent Contains Multiple Files',
    'INVALID_FILE_SIZE_NUM'  =>	'Invalid File Size.  It must be Numeric',
    'INVALID_FILE_PATH'      =>	'Invalid File Path.',
    'FILES_SIZE'             =>	'Total Size',
    'CHECK_PEACES'           =>	'Checking against Pieces...',
    'CHECK_PEACES_LENGTH'    =>	'Checking against Piece Length...',
    'PEACES_DATA_GOOD'       =>	'Data is Valid!',
    'PEACES_DATA_FAIL'       =>	'Data is Invalid!',
    'DHT_SUPORT_CHECK'       =>	'Checking against DHT Support in Azureus...',
    'TORRENT_IS_VALID'       =>	'This Torrent is Valid and has Passed Basic Tests.',
    'TORRENT_ADVANCE_CHECK'  =>	'Going through Advanced Tests...',
    'CHECK_SUPPORTED'        =>	'Supported',
    'CHECK_NOT_SUPPORTED'    =>	'NOT Supported',
    'MULTY_TRACKER_CHECK'    =>	'Checking against Multiple Trackers...',
    'TRACKER_SCRAPE'         =>	'Querying Tracker...',
    'TORRENT_NOT_REGED_WITH' =>	'It looks like this Torrent is NOT Registered with the External Tracker',
));

?>