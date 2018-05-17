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
** File my_torrents/english.php 2018-04-25 08:22:00 Thor
**
** CHANGES
**
** 2018-03-02 - Added New Masthead
** 2018-03-02 - Added New !defined('IN_PMBT')
** 2018-03-02 - Fixed Spelling
** 2018-04-25 - Amended the Wording of some Sentences
**/

if (!defined('IN_PMBT'))
{
    include_once './../../security.php';
    die ('Error 404 - Page Not Found');
}

if (empty($lang) || !is_array($lang))
{
    $lang = array();
}

$lang = array_merge($lang, array(
    'AUTHORIZE'        => 'Authorise',
    'UCP_TORRENTS'     => 'Torrent Control Panel',

    'UCP_TORRENTS_EXP' => 'In this area, you can Manage the Torrents that you have Uploaded (with the exception of those with <strong>Stealth Mode Selected</strong>).<br /><br />

        You can also Manage Download Requests sent from Users by Selecting the Appropriate Icon and decide whether to Accept or Deny their Download Request.</br /><br />

        Pay Attention to Upload and Download Amounts of the User.  People who Download without Sharing are of <strong>NO</strong> Benefit to our Site</br /><br />

        Refusing their Download Request can be an Appropriate way to Encourage them to Share more.',

    'MY_TORRENTS'             => 'User Torrent Panel',
    'MY_GLONAL_AUTH'          => 'My Global Authorisations',
    'NO_GLOBAL_AUYH'          => 'There are NO Global Authorisations yet',
    'ALL_USERS_AUTHORIZED'    => 'ALL Users have been Authorised',
    'SELECT_USERS_AUTHOEIZED' => 'The Selected User has been Authorised',
    'OWNER_AUTH_YOU'          => 'The Owner has Authorised you to Download their Torrents',
    'FREELY_DOWN_USER_TOR'    => 'You can now freely Download ALL of this User\'s Torrents.\nWe Protect your Privacy.',
    'PENDING_AUTH'            => 'Pending Authorisations',
    'USERS_REQUEST_AUTH'      => 'The following Users have Requested Download Authorisation',
    'NO_TORRENTS'             => 'There are NO Torrents',
    'NO_UPLOADED_TORRENTS'    => 'You have NOT Uploaded any Torrents yet',
    'ALWAYS_AUTH'             => 'Always Authorise',
    'NEVER_AUTH'              => 'Never Authorise',
    'DONT_AUTH'               => 'DO NOT Authorise',
    'CANT_VIEW_OTHER_AUTH'    => 'You can\'t View Other Users Torrents Permissions!',
    'DOWNL_AUTH_PANEL'        => 'Download Authorisations Control Panel',
    'NO_AUTH_TO_MANAGE'       => 'There are NO Authorisations to Manage',
    'GENERAL_OPTIONS'         => 'General Options',

    'USER_AUTH_SETT_EXP'      => 'Select this Option to Require Users to Ask for Download Authorisation to Access this Torrent.  You will be Notified of each New Pending Authorisation via email.  You will be able to choose whether to Allow or Deny the Authorisation for this Single Torrent or for ALL your Torrents',

    'USER_AUTH_RATO_SET_EXP'  => 'You can Set a Minimum Ratio Value to Auto-Authorise Users.  Users with a Ratio Above or Equal to this will be able to Download without Requesting Authorisation.  The Value of the Minimum Ratio will NOT be Displayed, except to Administrators',

    'AUTH_MINEATIO'       => 'Minimum Ratio',
    'DISABLE'             => 'Disabled',
    'PRIVATE_TORRENT'     => 'Private',
    'GEN_OPTION'          => 'General Options',
    'CANCEL_MOD'          => 'Cancel Modifications',
    'PRIVAZY_UPDATED'     => 'Your Privacy Settings have been Updated',
    'ERROR_ENTERING_DATA' => 'Error while Entering Data',
    'MY_TORRENTS'         => 'My Torrents',
    'AUTH_EMAIL_SUB'      => 'Download Authorisation at %1$s',
    'NUKED_TORRENT'       => 'Nuked Torrent',
    'FREE_TORRENT'        => 'Free Torrent',
    'BANNED_TORRENT'      => 'Banned Torrent',
    'EXTERNAL_TORRENT'    => 'External Torrent',
    'EDIT_TORRENT'        => 'Edit Torrent',
    'DELETE_TORRENT'      => 'Delete Torrent',
    'BAN_TORRENT'         => 'Ban Torrent',
    'REFRESH_PEER'        => 'Refresh Peer Data',
    'UPDATE_STATS'        => 'Stats Updated less than 30min ago',
    'SORT_NO_FILES'       => 'Sort by Number of Files (Ascending)',
    'DOWNLOAD_TORRENT'    => 'Download',
    'DHT_SUPORT'          => 'DHT Support',
    'DHT_EXPL'            => 'This Torrent supports DHT.  With a State-of-the-art Client, you\'ll be able to Download this Torrent even if a Central Tracker goes down.',
    'PAGES'               => 'Pages',
));

?>