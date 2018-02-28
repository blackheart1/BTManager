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
** File shout_cast/english.php 2018-02-28 20:50:00 Thor
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
    'TITLE'                  => 'Shoutcast',
    'TITLE_EXPLAIN'          => 'Shoutcast Radio Configuration and Settings<br />Here you can Setup your Shoutcast Radio to Display on your Site',
    'HEADER_SETTINGS'        => 'Shoutcast Settings',

    "_admpallow"             => "Allow Shoutcast",
    "_admpallowexplain"      => "With this you can Activate or Deactivate your Shoutcast Radio.",
    "_admpip"                => 'Shoutcast IP Address',
    "_admpipexplain"         => 'Enter the IP Address ONLY for your Shoutcast Radio',
    "_admpport"              => 'Shoutcast Port',
    "_admpportexplain"       => 'Enter the Port for your Shoutcast Radio',
    "_admpadmin_name"        => 'Shoutcast Administrator Name',
    "_admpadmin_nameexplain" => 'This is your Shoutcast Administrators Username, by Default this will be Administrator',
    "_admpadmin_pass"        => 'Shoutcast Password',
    "_admpadmin_passexplain" => 'Enter your Administrator Password for your Shoutcast Radio.  This is needed to Retrieve the Information from Your Shoutcast',
    "_admphost_dj"           => 'Current DJ',
    "_admphost_djexplain"    => 'Enter the Name of the Person Disk Jockeying on the Shoutcast.',
));

?>