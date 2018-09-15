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
** File mcp_massupload/english.php 2018-09-15 08:45:00 Thor
**
** CHANGES
**
** 2018-02-24 - Added New Masthead
** 2018-02-24 - Added New !defined('IN_PMBT')
** 2018-02-24 - Fixed Spelling
** 2018-04-01 - Amended the Wording of some Sentences
** 2018-04-01 - Amended !defined('IN_PMBT') Corrected Path
** 2018-04-10 - Amended the Wording of some Sentences & Removed - 0 = &infin; from /templates/admin/mcp_massupload.html
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
    'INTRO'                     => 'Mass Upload',

    'INTRO_EXP'                 => 'With this Tool you can Upload Multiple Torrents at the same time.<br /><br /><br />The Torrents Must be in your Site\'s Root Sub-Directory called <em><strong>massupload</strong></em>, which should be Writeable (in Order to Delete Torrents once Uploaded or Duplicated).<br /><br /><em>Tip:</em> on UNIX systems, if you need to use a different Directory for Mass Upload, you can change the <em><strong>massupload</strong></em> Directory with a <em><u>Symbolic Link</u></em>.<br /><br />',

    'MAX_SEARCH'                => 'Maximum Torrents to Process (Prevents Memory or Time Out Errors)',
    'TRACKER_DISABLED'          => 'Our Tracker has been Disabled.  Only External Torrents can be Uploaded.',

    'BLACKLISTEDTRACKER'        => 'The Tracker used by this Torrent (<strong> %1$s </strong>) has been Blacklisted.  Please use a Different Tracker.',

    'AUTO_DEL_DUPE_FILE'        => 'Automatically Delete Duplicate Torrents',

    'BAD_TRK_RESPONCE'          => 'Invalid Data from External Tracker.  The Tracker may have Server Issues.  Please try again later.',

    'SKIP_SCRAPE'               => 'Skips the External Tracker Check.  This Option Skips the Check of External Tracker Sources until the next Automatic Update.  Useful to Process Large Amounts of Torrents Faster.',

    'UP_ANONYM'                 => 'Anonymous Upload.  If Unchecked, the Torrent will look like you Manually Uploaded it.',

    'CHECK_CHMODD'              => 'Unable to Delete Duplicate Torrents.  Please Delete them Manually or Check your Directory Permissions (must be Writeable).',

    'TOR_EXEST'                 => 'Torrent Already Exists.',
    'CANNOT_CANTACT_URL'        => 'Can NOT Contact URL Address.  Tracker will be Set as Offline',
    'NO_MASSUPDIR'              => 'Mass Upload Directory DOES NOT Exist or is NOT Readable.',
    'SEARCH_OPT'                => 'Search Options:',
    'INFO_HASH'                 => 'Info Hash',
    'MASS_DIR_EMPTY'            => 'Mass Upload Directory is Empty!',
    'SCAN'                      => 'Scan',
    'DESCRIPTION'               => 'Description',

    'DESCRIPTION_EXP'           => 'Please Enter a Description that Indicates the File Type and Quality, (especially in the case of Media Files)',

    'TOR_PROS_ALREADY'          => 'Torrent has already been Processed',
    'SUCCESFUL_UPLOAD'          => 'Torrent Successfully Uploaded',
    'DECODE_ERROR'              => 'Decoding Error.  The File is probably NOT a Valid Torrent File.',
    'INVALID'                   => 'Invalid',

    'NOT_REDG_TO_TRACK'         => 'Torrent DOES NOT seem to be Registered on the External Tracker.  You can Upload External Torrents ONLY if they\'re Active.',

    'MISSING_DATA'              => 'Required Data is Missing!',
    'DEAD_TORRENT'              => 'Your Torrent is NOT Seeded!',
    'INVALID_FILEPATH'          => 'Invalid File Path.',
    'INVALIDE_FILE_SIZE'        => 'Invalid File Size.  Must be Numeric',
    'INVALID_PEASES'            => 'Invalid Torrent Parts',
    'INVALID_ANNOUNCE'          => 'Invalid Announce URL.  Can NOT be <strong> %1$s </strong>',
    'TOTLE_SIZE'                => 'Total Size',
    'NO_CAT_SET'                => 'NO Category Selected.  Please go back to the Upload Form.',
    'ERROR_NOTCONS'             => 'Torrent is NOT Consistent!!',
    'ANNOUNCE_URL'              => 'Announce URL.',
    'CHECK_DHT'                 => 'Checking against DHT Support in Azureus...',
    'MULTY_TRACKER_CHECK'       => 'Checking against Multiple Trackers...',

    'UNABLE_TO_REMOVE_TORRENTS' => 'Unable to Delete Torrents that have been processed (whether Successfully or NOT).  Please Delete them Manually or Check your Directory Permissions (must be Writeable).',
 ));

?>