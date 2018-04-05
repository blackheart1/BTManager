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
** File bans/english.php 2018-04-05 08:40:00 Thor
**
** CHANGES
**
** 2018-02-24 - Added New Masthead
** 2018-02-24 - Added New !defined('IN_PMBT')
** 2018-02-24 - Fixed Spelling
** 2018-03-29 - Amended the Wording of some Sentences
** 2018-03-29 - Amended !defined('IN_PMBT') Corrected Path
** 2018-04-05 - Amended the Wording of some Sentences
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
    'MAIN_TITLE'       => 'User Ban',

    'MAIN_TITLE_EXP'   => 'Use this page to Ban Users from your Tracker.  You can Define IP Ranges to Ban and Manage Banned IP\'s and Users.  You can also provide a Reason that is Displayed to the Banned User when they try to Log in.',

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
    'BAN_USER_EXP'     => 'Ban a User by Name.  Note this is Case Sensitive.',
    'BAN_USER'         => 'Ban a User',
    'BANNED_USERS_EXP' => 'Here is the List of Currently Banned Users',
    'CANCEL_MOD'       => 'Cancel Modifications',
    'NO_REASON'        => 'No Reason given for the Ban',
    'NO_USER_BANS'     => 'There are NO Banned Users',
    'NO_IP_BANS'       => 'There are NO Banned IP\'s',
    'YEAR_MONTH_DAY'   => '(YYYY-MM-DD)',

    #Addon for 3.0.1
    'NO_BAN_FOUNDER'   => 'This User is a Founder and can NOT be Banned!',
));

?>