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
** File my_torrents/english.php 2018-03-17 11:39:00 Thor
**
** CHANGES
**
** 2018-03-02 - Added New Masthead
** 2018-03-02 - Added New !defined('IN_PMBT')
** 2018-03-02 - Fixed Spelling
**/

if (!defined('IN_PMBT'))
{
    include_once './../../security.php';
    die ("You can't access this file directly");
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
    'AUTHORIZE'        =>	'Authorize',
    'UCP_TORRENTS'     =>	'Torrent Control Panel',

    'UCP_TORRENTS_EXP' =>	'In this area, you can Manage the Torrents that you have Uploaded (with the exception of those with <strong>Stealth Mode Selected</strong>).<br><br>

        You can also Manage Download Requests sent from Users by Selecting the Appropriate Icon and decide whether to Accept or Deny their Download Request.</br><br>

        Pay Attention to Upload and Download Amounts of the User. People who Download without Sharing are of <strong>NO</strong> Benefit to our Site</br><br>

        Refusing their Download Request can be an Appropriate way to Encourage them to Share more.',

    'MY_TORRENTS'             =>	'User Torrent Panel',
    'MY_GLONAL_AUTH'          =>	'My Global Authorizations',
    'NO_GLOBAL_AUYH'          =>	'There are NO Global Authorizations yet',
    'ALL_USERS_AUTHORIZED'    =>	'ALL Users have been Authorized',
    'SELECT_USERS_AUTHOEIZED' =>	'The Selected User has been Authorized',
    'OWNER_AUTH_YOU'          =>	'The Owner has Authorized you to Download their Torrents',
    'FREELY_DOWN_USER_TOR'    =>	'You Can Now Freely Download ALL of this User\'s Torrents.\nWe Protect your Privacy.',
    'PENDING_AUTH'            =>	'Pending Authorizations',
    'USERS_REQUEST_AUTH'      =>	'The following Users have Requested Download Authorization',
    'NO_TORRENTS'             =>	'There are NO Torrents',
    'NO_UPLOADED_TORRENTS'    =>	'You have NOT Uploaded any Torrents yet',
    'ALWAYS_AUTH'             =>	'Always Authorize',
    'NEVER_AUTH'              =>	'Never Authorize',
    'DONT_AUTH'               =>	'DO NOT Authorize',
    'CANT_VIEW_OTHER_AUTH'    =>	'You can\'t view Other Users Torrents Permissions!',
    'DOWNL_AUTH_PANEL'        =>	'Download Authorizations Control Panel',
    'NO_AUTH_TO_MANAGE'       =>	'There are NO Authorizations to Manage',

    'USER_AUTH_SETT_EXP'      =>	'Select this Option to Require Users to Ask for a Download Authorization to Access this Torrent. You will be Notified of each New Pending Authorization via email.You will be able to choose whether to Allow or Deny the Authorization for this Single Torrent or for ALL your Torrents',

    'USER_AUTH_RATO_SET_EXP'  =>	'You can Set a Minimum Ratio Value to Auto-Authorize Users. Users with a Ratio Above or Equal to this will be able to Download without Requesting Authorization.  The Value of the Minimum Ratio will NOT be Displayed, except to Administrators',

    'AUTH_MINEATIO'       =>	'Minimum Ratio',
    'DISABLE'             =>	'Disabled',
    'PRIVATE'             =>	'Private',
    'GEN_OPTION'          =>	'General Options',
    'CANCEL_MOD'          =>	'Cancel Modifications',
    'PRIVAZY_UPDATED'     =>	'Your Privacy Settings have been Updated',
    'ERROR_ENTERING_DATA' =>	'Error while Entering Data',
    'MY_TORRENTS'         =>	'My Torrents',
    'AUTH_EMAIL_SUB'      =>	'Download Authorization at %1$s"',
));

?>