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
** File bans/english.php 2018-02-28 08:28:00 Thor
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
    'MAIN_TITLE'       => 'User Ban',
    'MAIN_TITLE_EXP'   => 'Use this page to Ban Users from your Tracker. You can Define IP Ranges to Ban and Manage Banned IP\'s and Users. You can also provide a Reason that is presented to the Banned User when they try to Log In.',

    'BANNED_IPS'       => 'Banned IP\'s',
    'BANNED_IPS_EXP'   => 'Here is a List of the Currently Banned IP\'s and the Reason Why!',
    'START_IP'         => 'Start IP',
    'END_IP'           => 'End IP',
    'REASON'           => 'Reason',
    'BANNED_USERS'     => 'Banned Users',
    'USER_BANNED'      => 'User Name',
    'ADD_EDIT_BAN'     => 'Add/Edit Ban',
    'BAN_IP'           => 'Ban an IP',
    'BAN_IP_EXP'       => 'Ban a Single IP or an Entire Range',
    'BAN_USER_EXP'     => 'Ban a User By Name this is Case Sensitive.',
    'BAN_USER'         => 'Ban a User',
    'BANNED_USERS_EXP' => 'Here is the List of Curently Banned Users',
    'CANCEL_MOD'       => 'Cancel Modifications',
    'NO_REASON'        => 'No Reason given for the Ban',
    'NO_USER_BANS'     => 'There are NO Banned Users',
    'NO_IP_BANS'       => 'There are NO Banned IP\'s',
    'YEAR_MONTH_DAY'   => '(YYYY-MM-DD)',
));

?>