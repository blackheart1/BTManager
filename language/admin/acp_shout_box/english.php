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
** File shout_box/english.php 2018-09-14 10:22:00 Thor
**
** CHANGES
**
** 2018-02-25 - Added New Masthead
** 2018-02-25 - Added New !defined('IN_PMBT')
** 2018-02-25 - Fixed Spelling
** 2018-04-11 - Amended the Wording of some Sentences
** 2018-04-11 - Amended !defined('IN_PMBT') Corrected Path
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
    'YES_NO_NM' => array('1' => 'Yes',
                         '0' => 'No'),

    'YES_NO'    => array('yes' => 'Yes',
                         'no' => 'No'),

    'YES_NO_TF' => array('true' => 'Yes',
                         'false' => 'No'),

    'SHOUT_CONF'            => 'Shoutbox Configuration',

    'SHOUT_CONF_EXP'        => 'Here is where you Set ALL your Settling\'s for the Site\'s Shoutbox including, Refresh Rate, Idle Time, and Turning it On or Off.<br /><br />',

    'BT_SHOUT'              => 'Shout Box',
    'BT_SHOUT_ANNOUNCEMENT' => 'Shout Box Announcement ',
    'DATE_FORMAT'           => 'Date format',
    'DATE_FORMAT_EXPLAIN'   => 'The Syntax used is Identical to the PHP <a href="http://www.php.net/date">date()</a> function.',

    '_admsaved'                     => 'Settings Saved!',
    '_admpannounce_ment'            => 'Shout Box Announcement ',
    '_admpannounce_mentexplain'     => 'The Text that Appears on the Top of the Shoutbox',
    '_admpturn_on'                  => 'Turn Shoutbox On/Off',
    '_admpturn_onexplain'           => 'Enable or Disable the Site\'s Shoutbox',
    '_admpidle_time'                => 'Idle Time',
    '_admpidle_timeexplain'         => 'This is the Amount of Time the Idle Duration is Set to in Seconds',
    '_admprefresh_time'             => 'Shoutbox Refresh Rate ',
    '_admprefresh_timeexplain'      => 'This is the Amount of Time the Shoutbox Refreshes in Seconds',
    '_admpbbcode_on'                => 'Allow the Use of BBCode in Shouts ',
    '_admpbbcode_onexplain'         => 'Allow Users to be able to use BBCodes in Shouts',
    '_admpautodelete_time'          => 'Auto Delete Time',

    '_admpautodelete_timeexplain'   => 'How Long do you want Shouts to be Displayed for before they are Deleted.  Time is Set in Minutes',

    '_admpcanedit_on'               => 'Can Edit Shouts ',
    '_admpcanedit_onexplain'        => 'Allow Users to Edit their Own Shouts',
    '_admpcandelete_on'             => 'Can Delete Shouts ',
    '_admpcandelete_onexplain'      => 'Allow Users to Delete their Own Shouts',
    '_admpshouts_to_show'           => 'Shouts to Show ',
    '_admpshouts_to_showexplain'    => 'How many Shouts do you want to Display',
    '_admpallow_url'                => 'Allow Links in Shouts ',
    '_admpallow_urlexplain'         => 'Allow Users to use Links in Shouts',
    '_admpshoutnewuser'             => 'Announce New Users ',
    '_admpshoutnewuserexplain'      => 'Automatically Shout a Welcome Message for New Users',
    '_admpshout_new_torrent'        => 'Announce New Torrents ',
    '_admpshout_new_torrentexplain' => 'Automatically Post a Shout when a New Torrent is Uploaded',
    '_admpshout_new_porn'           => 'Announce New Porn Torrents ',

    '_admpshout_new_pornexplain'    => 'Automatically Post a Shout when a Torrent is Uploaded in the Porn Category.<br />This DOES NOT Override the Announce New Torrents if it\'s Turned OFF',

    '_admpcan_quote'                => 'Allow Quote',
    '_admpcan_quoteexplain'         => 'Allow users to use the quote function',
    '_admpautodelet'                => 'Auto Delete Shouts',
    '_admpautodeletexplain'         => 'Turn on shout auto delete system to help remove old shouts',
));

?>