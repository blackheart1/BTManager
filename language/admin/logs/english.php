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
** File logs/english.php 2018-02-28 08:48:00 Thor
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
    'ADMIN'                        => 'Administration',
    '_ASCENDING'                   => 'Ascending',
    '_DESCENDING'                  => 'Descending',
    'ACP_ADMIN_LOGS'               => 'Administration Log',
    'ACP_ADMIN_LOGS_EXPLAIN'       => 'This Lists ALL the Actions carried out by Board Administrators. You can Sort by Username, Date, IP or Action. If you have the Appropriate Permissions you can also Clear Individual Operations or the Entire Log.',

    'ACP_CRITICAL_LOGS_EXPLAIN'    => 'This Lists the Actions carried out by the Board itself. This Log provides you with Information, you are able to use for Solving Specific Problems, for example Non Delivery of emails. You can Sort by Username, Date, IP or Action. If you have the Appropriate Permissions, you can also Clear Individual Operations or the Entire Log.',

    'ACP_MOD_LOGS_EXPLAIN'         => 'This Lists ALL the Actions Done on the Forums, Topics and Posts as well as Actions carried out on Users by Moderators, including Banning. You can Sort by Username, Date, IP or Action. If you have the Appropriate Permissions, you can also Clear Individual Operations or the Entire Log.',

    'ACP_USERS_LOGS_EXPLAIN'       => 'This Lists ALL Actions Carried out by Users or on Users (Reports, Warnings and User Notes).',

    'SORT_USERNAME'                => 'Username',
    'SORT_DATE'                    => 'Date',
    'NO_AUTH_ACC'                  => 'You DO NOT have Permissions to Access Logs',
    'AUTH_CLEAR_LOGS_FAIL'         => 'You are NOT Authorized to Clear the Logs',
    'SORT_IP'                      => 'IP Address',
    'SORT_ACTION'                  => 'Log Action',
    'NO_ENTRIES'                   => 'NO Log Entries for this Period.',
    'SORT_IP'                      => 'IP Address',
    'SORT_DATE'                    => 'Date',
    'SORT_ACTION'                  => 'Log Action',
    'SEARCH_KEYWORDS'              => 'Search for Keywords',
    'IP'                           => 'Users IP',
    'TIME'                         => 'Time/Date',
    'CONFIRM_OPERATION'            => 'Are you sure you wish to carry out this Operation?',
    'PRUNE_SUCCESS'                => 'Pruning of Logs was Successful.',
    'PRUNE_SEL_SUCCESS'            => 'Pruning of Selected Logs was Successful.',
    'A_CLEAR_LOG'                  => 'Cleared Administrator Log',
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