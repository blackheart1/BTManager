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
** File logs/english.php 2018-07-05 08:47:00 Thor
**
** CHANGES
**
** 2018-02-24 - Added New Masthead
** 2018-02-24 - Added New !defined('IN_PMBT')
** 2018-02-24 - Fixed Spelling
** 2018-03-29 - Amended the Wording of some Sentences
** 2018-03-29 - Amended !defined('IN_PMBT') Corrected Path
** 2018-04-09 - Amended the Wording of some Sentences
** 2018-07-05 - Amended the Wording of some Sentences and Spell Checked
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
    'ADMIN'                     => 'Administration',
    '_ASCENDING'                => 'Ascending',
    '_DESCENDING'               => 'Descending',
    'ACP_ADMIN_LOGS'            => 'Administration Logs',
    'ACP_CRITICAL_LOGS'         => 'Error Logs',
    'ACP_MOD_LOGS'              => 'Moderator Logs',
    'ACP_USERS_LOGS'            => 'User Logs',
    'ACP_LOGGING'               => 'Logging',
    'LOGVIEW_VIEWTOPIC'         => 'View Topic',
    'LOGVIEW_VIEWLOGS'          => 'View Topic Log',
    'LOGVIEW_VIEWFORUM'         => 'View Forum',
    'ALL_FORUMS'                => 'All Forums',

    'ACP_ADMIN_LOGS_EXPLAIN'    => 'This Lists ALL the Actions carried out by the Board Administrators.  You can Sort by Username, Date, IP or Action.  If you have the Appropriate Permissions you can also Clear Individual Operations or the Entire Log.',

    'ACP_CRITICAL_LOGS_EXPLAIN' => 'This Lists the Actions carried out by the Board itself.  This Log provides you with Information that you are able to use for Solving Specific Problems, for example Non Delivery of emails.  You can Sort by Username, Date, IP or Action.  If you have the Appropriate Permissions, you can also Clear Individual Operations or the Entire Log.',

    'ACP_MOD_LOGS_EXPLAIN'      => 'This Lists ALL the Actions Done on the Forums, Topics and Posts as well as Actions carried out on Users by Moderators, including Banning.  You can Sort by Username, Date, IP or Action.  If you have the Appropriate Permissions, you can also Clear Individual Operations or the Entire Log.',

    'ACP_USERS_LOGS_EXPLAIN'    => 'This Lists ALL the Actions Carried out by Users or on User (Reports, Warnings and User Notes).',

    'SORT_USERNAME'                => 'Username',
    'SORT_DATE'                    => 'Date',
    'NO_AUTH_ACC'                  => 'You DO NOT have Permission to Access the Logs!',
    'AUTH_CLEAR_LOGS_FAIL'         => 'You DO NOT have Permission to Clear the Logs!',
    'SORT_IP'                      => 'IP Address',
    'SORT_ACTION'                  => 'Log Action',
    'NO_ENTRIES'                   => 'No Log Entries for this Period.',
    'SORT_IP'                      => 'IP Address',
    'SORT_DATE'                    => 'Date',
    'SORT_ACTION'                  => 'Log Action',
    'SEARCH_KEYWORDS'              => 'Search for Keywords',
    'IP'                           => 'User\'s IP',
    'TIME'                         => 'Time/Date',
    'CONFIRM_OPERATION'            => 'Are you sure you wish to Carry Out this Operation?',
    'PRUNE_SUCCESS'                => 'Pruning the Logs was Successful.',
    'PRUNE_SEL_SUCCESS'            => 'Pruning the Selected Logs was Successful.',
    'A_CLEAR_LOG'                  => 'Cleared Administrator Log.',
    'EXT_GROUP_ARCHIVES'           => 'Archives',
    'EXT_GROUP_DOCUMENTS'          => 'Documents',
    'EXT_GROUP_DOWNLOADABLE_FILES' => 'Downloadable Files',
    'EXT_GROUP_FLASH_FILES'        => 'Flash Files',
    'EXT_GROUP_IMAGES'             => 'Images',
    'EXT_GROUP_PLAIN_TEXT'         => 'Plain Text',
    'EXT_GROUP_QUICKTIME_MEDIA'    => 'Quicktime Media',
    'EXT_GROUP_REAL_MEDIA'         => 'Real Media',
    'EXT_GROUP_WINDOWS_MEDIA'      => 'Windows Media',
));

?>