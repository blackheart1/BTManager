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
** File warned/english.php 2018-02-28 22:14:00 Thor
**
** CHANGES
**
** 2018-02-25 - Added New Masthead
** 2018-02-25 - Added New !defined('IN_PMBT')
** 2018-02-25 - Fixed Spelling
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
    'ACP_WARNINGS'         => 'Warned Accounts',
    'ACP_WARNINGS_EXPLAIN' => 'Here you can View all Users that currently have Warning\'s marked again their Account.',
    'USERNAME'             => 'Username',
    'REGISTERED'           => 'Registered',
    'LAST_ACCESS'          => 'Last Access',
    'CLASS_USER'           => 'User Class',
    'DOWNLOADED'           => 'Downloaded',
    'UPLOADED'             => 'Uploaded',
    'U_RATIO'              => 'Ratio',
    'MOD_COMM'             => 'Moderator Comments',
    'SORT_USERNAME'        => 'User Name',
    'SORT_REG_DATE'        => 'Registered Date',
    'SORT_UP'              => 'Uploaded',
    'SORT_DOWN'            => 'Downloaded',
    'SORT_WARN_DATE'       => 'Date Warned',
    'SORT_BY'              => 'Sort by',
    'DISPLAY_WARNED'       => 'Display Entries from previous',
));

?>