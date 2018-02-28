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
** File acp_ratio/english.php 2018-02-28 07:55:00 Thor
**
** CHANGES
**
** 2018-02-23 - Added New Masthead
** 2018-02-23 - Added New !defined('IN_PMBT')
** 2018-02-23 - Fixed Spelling
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
    'SEL_YES_NO'              => array('true'=>'Yes','false'=>'No'),

    'TITLE_INDEX'             => 'Site Warning System',
    'TITLE_EXPLAIN_INDEX'     => 'In this area you are able to View and Edit your Warning Configuration',
    'TITLE_CONFIG'            => 'Warning Configuration',
    'TITLE_EXPLAIN_CONFIG'    => 'Warning Configurations are the Settings Used by the System to determine who and when to Warn a User for a Low Ratio.',

    'SECTION_EXPLAIN_CONFIG'  => 'This is used to Alter and Set your Warning Systems Controls.',
    'TITLE_WARNED'            => 'Ratio Warn System - Warned Users',
    'TITLE_EXPLAIN_WARNED'    => 'This is a List of Users that have been Warned or Banned by the System (NOT including Users Warned or Banned by Moderators.)',

    'SECTION_EXPLAIN_WARNED'  => 'This is a List of Users that have been Warned by the System (NOT including Users Warned by Moderators.)',

    'TITLE_WATCHED'           => 'Ratio Warn System - Watched/Warned Users',
    'TITLE_EXPLAIN_WATCHED'   => 'This is a List of Users being Watched by the System for having a Low Ratio on the Site.',
    'SECTION_EXPLAIN_WATCHED' => 'This is a List of Users being Watched by the System for having a Low Ratio on the Site.',
    'BLOCK_TITLE'             => 'Ratio Warning System',
    'SECTION_TITLE_CONFIG'    => 'Ratio Warning Configuration',
    'SECTION_TITLE_WARNED'    => 'Ratio Warned Users',
    'SECTION_TITLE_WATCHED'   => 'Ratio Watched Users',
    'NO_ERROR'                => 'No Error Found!',
    '_admpenableexplain'      => 'Enable Ratio Warning System',
    '_admpenable'             => 'Enable Ratio Waning',
    '_admpratio_miniexplain'  => 'Set the Ratio Amount to where you want Members to be Added to the Watched List',
    '_admpratio_mini'         => 'Ratio Warn Amount',
    '_admpratio_warnexplain'  => 'How long in Days do you want the User to be Watched before they are Warned',
    '_admpratio_warn'         => 'Warning Time',
    '_admpratio_banexplain'   => 'How long in Days do you want the User to be Warned before they are Banned',
    '_admpratio_ban'          => 'Banning Time',
    'NO_ENTRIES_WARNED'       => 'No Users have been Warned for Maintaining Poor Ratios.',
    'BANNED'                  => 'Banned',
    'TIME_TO_BAN'             => 'Time Until Ban',
    'TO_GO'                   => '%1$s Days',
    'USER_STST_UPDATE'        => 'Status for User %1$s have now been Updated!<br />If the User still has a Bad Ratio they will be Added Back to the Watch List but their Warning will be Removed.',

    'NO_ENTRIES'              => 'There are NO Users Currently being Watched for Poor Ratios.',
    'TIME_TO_WARN'            => 'Time Until Warning',
    'REMOVED_WATCH'           => 'Remove from Watch',
));

?>