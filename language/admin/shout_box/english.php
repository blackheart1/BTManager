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
** File shout_box/english.php 2018-02-28 20:49:00 Thor
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
    'YES_NO'                        => array('yes'=>'Yes', 'no'=>'No'),
    'SHOUT_CONF'                    => 'ShoutBox Configuration',
    'SHOUT_CONF_EXP'                => 'Here is where you Set ALL your Settling\'s for the Site\'s Shoutbox Including, Refresh Rate, Idle Time, and Turning it On or Off.',

    'BT_SHOUT'                      => 'Shout Box',
    'BT_SHOUT_ANNOUNCEMENT'         => 'Shout Box Announcement ',

    '_admsaved'                     => 'Settings Saved!',
    '_admpannounce_ment'            => 'Shout Box Announcement ',
    '_admpannounce_mentexplain'     => 'The Text that Appears on the Top of the Shoutbox',
    '_admpturn_on'                  => 'Turn On/Off the Shoutbox ',
    '_admpturn_onexplain'           => 'Enable or Disable the Site\'s Shoutbox',
    '_admpidle_time'                => 'Idle Time',
    '_admpidle_timeexplain'         => 'This is the Amount of Time the Idle Duration is Set to in Seconds',
    '_admprefresh_time'             => 'Shoutbox Refresh Rate ',
    '_admprefresh_timeexplain'      => 'This is the Amount of Time the Shoutbox Refreshes in Seconds',
    '_admpbbcode_on'                => 'Allow the Use of BBCode in Shouts ',
    '_admpbbcode_onexplain'         => 'Allow Users to be able to use BBCodes in Shouts',
    '_admpautodelete_time'          => 'Auto Delete ',
    '_admpautodelete_timeexplain'   => 'This is how long you want Shouts to be Displayed for before they are Deleted.  Time is Set in Minutes',

    '_admpcanedit_on'               => 'Can Edit Shouts ',
    '_admpcanedit_onexplain'        => 'Allow Users to Edit their Own Shouts',
    '_admpcandelete_on'             => 'Can Delete Shouts ',
    '_admpcandelete_onexplain'      => 'Allow Users to Delete their Own Shouts',
    '_admpshouts_to_show'           => 'Shouts To Show ',
    '_admpshouts_to_showexplain'    => 'How many Shouts do you want to Display',
    '_admpallow_url'                => 'Allow Links in Shouts ',
    '_admpallow_urlexplain'         => 'Allow Users to use Links in Shouts',
    '_admpshoutnewuser'             => 'Announce New Users ',
    '_admpshoutnewuserexplain'      => 'Automatically Shout a Welcome Message for New Users',
    '_admpshout_new_torrent'        => 'Announce New Torrents ',
    '_admpshout_new_torrentexplain' => 'Automatically Post a Shout when a New Torrent is Uploaded',
    '_admpshout_new_porn'           => 'Announce New Porn Torrents ',
    '_admpshout_new_pornexplain'    => 'Automatically Post a Shout when a Torrent is Uploaded in the Porn Category.<br />This DOES NOT Override the Announce New Torrents if it\'s Turned OFF',
));

?>