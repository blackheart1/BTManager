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
** File mcp_massupload/english.php 2018-02-28 11:34:00 Thor
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
    'INTRO'                     =>	'Mass Upload',
    'INTRO_EXP'                 =>	'With this Tool you can Upload Multiple Torrents at a time.
    The Torrents must be in your Site\'s Root Sub Directory called <i>massupload</i>, which should be Writeable (in Order to Delete Torrents once Uploaded or Duplicated).<br>
    <i>Tip</i>: on UNIX systems, if you need to use a different Directory for Mass Upload, you can change the <i>massupload</i> Directory with a <i><u>Symbolic Link</u></i>.',

    'MAX_SEARCH'                =>	'Maximum Torrents to Process (Prevents Memory or Time Out Errors)',
    'TRACKER_DISABLED'          =>	'Our Tracker has been Disabled: Only External Torrents can be Uploaded.',
    'BLACKLISTEDTRACKER'        =>	'The Tracker used by this Torrent (<b>"%1$s"</b>) has been Blacklisted. Please use a Different Tracker.',

    'AUTO_DEL_DUPE_FILE'        =>	'Automatically Delete Duplicate Torrents',
    'BAD_TRK_RESPONCE'          =>	'Invalid Data from External Tracker. The Tracker may have Server Problems. Please try again later.',

    'SKIP_SCRAPE'               =>	'Skips External Tracker Check. This Option Skips the Check of External Tracker Sources until the next Automatic Update. Useful to Process Large Amounts of Torrents Faster.',

    'UP_ANONYM'                 =>	'Anonymous Upload. If Unchecked, the Torrent will look like you Manually Uploaded it.',
    'CHECK_CHMODD'              =>	'Unable to Delete Duplicate Torrents. Please Delete them Manually or Check your Directory Permissions (must be Writeable).',

    'TOR_EXEST'                 =>	'Torrent is Already Here.',
    'CANNOT_CANTACT_URL'        =>	'Cannot Contact URL Address. Tracker will be Set as Offline',
    'NO_MASSUPDIR'              =>	'Mass Upload Directory DOES NOT Exist or is NOT Readable.',
    'SEARCH_OPT'                =>	'Search Options:',
    'INFO_HASH'                 =>	'Info Hash',
    'MASS_DIR_EMPTY'            =>	'NO Torrents there',
    'SCAN'                      =>	'Scan',
    'DESCRIPTION'               =>	'Description',
    'DESCRIPTION_EXP'           =>	'Please enter a Description that Indicates File Type and Quality, particularly in case of Media Files',

    'TOR_PROS_ALREADY'          =>	'Torrent Already been Processed',
    'SUCCESFUL_UPLOAD'          =>	'Torrent Successfully Uploaded',
    'DECODE_ERROR'              =>	'Decoding Error. File is Probably NOT a Valid Torrent File.',
    'INVALID'                   =>	'Invalid',
    'NOT_REDG_TO_TRACK'         =>	'Torrent DOES NOT seem to be Registered on the External Tracker. You can Upload External Torrents ONLY if they\'re Active.',

    'MISSING_DATA'              =>	'Required Data is Missing!',
    'DEAD_TORRENT'              =>	'Your Torrent is NOT Seeded!',
    'INVALID_FILEPATH'          =>	'Invalid File Path.',
    'INVALIDE_FILE_SIZE'        =>	'Invalid File Size. Must be Numeric',
    'INVALID_PEASES'            =>	'Invalid Torrent Parts',
    'INVALID_ANNOUNCE'          =>	'Invalid Announce URL. Can NOT be <strong> %1$s </strong>',
    'TOTLE_SIZE'                =>	'Total Size',
    'NO_CAT_SET'                =>	'NO Category Selected. Please go back to the Upload Form.',
    'ERROR_NOTCONS'             =>	'Torrent is NOT Consistent!!',
    'ANNOUNCE_URL'              =>	'Announce URL.',
    'CHECK_DHT'                 =>	'Checking against DHT Support in Azureus...',
    'MULTY_TRACKER_CHECK'       =>	'Checking against Multiple Trackers...',
    'UNABLE_TO_REMOVE_TORRENTS' =>	'Unable to Delete Torrents that have been processed (whether Successfully or NOT). Please Delete them Manually or Check your Directory Permissions (must be Writeable).',
 ));

?>