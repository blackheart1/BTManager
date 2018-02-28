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
** File mcp_clinic/english.php 2018-02-28 11:24:00 Thor
**
** CHANGES
**
** 2018-02-24 - Added New Masthead
** 2018-02-24 - Added New !defined('IN_PMBT')
** 2018-02-24 - Fixed Spelling
**/

if (!defined('IN_PMBT'))
{
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html>
    <head>
       <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

       <title>
       <?php if (isset($_GET['error']))
       {
       echo htmlspecialchars($_GET['error']);
       }
       ?> Error</title>

       <link rel='stylesheet' type='text/css' href='/errors/error-style.css' />
    </head>

    <body>
       <div id='container'>
       <div align='center' style='padding-top: 15px'>
          <img src='/errors/error-images/alert.png' width='89' height='94' alt='' title='' />
       </div>

       <h1 class='title'>Error 404 - Page Not Found</h1>
       <p class='sub-title' align='center'>The page that you are looking for does not appear to exist on this site.</p>
       <p>If you typed the address of the page into the address bar of your browser, please check that you typed it in correctly.</p>
       <p>If you arrived at this page after you used an old Bookmark or Favourite, the page in question has probably been moved. Try locating the page via the navigation menu and then update your bookmarks.</p>
       </div>
    </body>
    </html>

    <?php
    exit();
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
    'INTRO'                  =>	'TorrentClinic',
    'INTRO_EXP'              =>	'Torrent Clinic Allows you to Check .torrent File Properties.<br />
    If you are having trouble with a Torrent you can Verify it has been Generated Correctly, or you can simply look inside it.<br />
    Uploading a Torrent from your Hard Drive, you will be able to Verify ALL the Information that it contains and even Check against Sources!',

    'UPLOAD_TORRENT'         =>	'Upload a Torrent',
    'UPLOAD_LOCAL_FILE'      =>	'Upload a Torrent from your Hard Drive to be Checked',
    'SHOW_STRUCTURE'         =>	'Show Advanced XML Structures (Useful for Debugging)',
    'FORCE_SCRAPE'           =>	'Force Scrape on External Torrents',
    'ERROR_DECODING'         =>	'Decoding Error. File is probably NOT a Valid Torrent File.',
    'DECODED_DATA'           =>	'Reading Torrent...',
    'NO_DEFAULT_ANNOUNCE'    =>	'Default Tracker is NOT Set. Invalid Torrent file.',
    'XML_STRUCTURE'          =>	'XML Structure',
    'CHECK_ANNOUNCE'         =>	'Checking against Default Tracker...',
    'CKECK_DIRECTORY'        =>	'Checking against Info Dictionary...',
    'CKECK_DIRECTORY_ERR'    =>	'Info Dictionary is NOT Present. Invalid Torrent File.',
    'CHECK_FOUND'            =>	'Found',
    'CHECK_FILES'            =>	'Checking against File Number...',
    'TORRENT_NOT_CONSISTANT' =>	'Torrent is NOT Consistent!',
    'TORRENT_SINGLE_FILE'    =>	'Torrent Contains a Single File',
    'TORRENT_MULTY_FILE'     =>	'Torrent Contains Multiple Files',
    'INVALID_FILE_SIZE_NUM'  =>	'Invalid File Size. It must be Numeric',
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