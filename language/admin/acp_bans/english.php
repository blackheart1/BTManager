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
** File bans/english.php 2018-09-15 06:15:00 Thor
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

    'MAIN_TITLE_EXP'   => 'Use this Page to Ban Users from your Tracker.  You can Define IP Ranges to Ban and Manage Banned IP\'s and Users.  You can also Provide a Reason that is Displayed to the Banned User when they try to Log in.',

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
    'MENU_BANS'       => 'Banned Users and Settings',

    'ACP_BAN_EXPLAIN' => 'Here you can Control how Users are Banned.  You can select Ban by Username, IP Address or even email Address.  These methods Prevent any User from Accessing any part of the Site.  You can give a Short (Maximum 3000 Characters) Reason for the Ban if you wish.  This will be Displayed in the Administrator\'s Log.  You can also Specify the Duration that a User is Banned for.  If you want the Ban to End on a Specific Date rather than After a Set amount of Time, Select <strong>Until -></strong> for the Ban Length and enter a Date in <em>YYYY-MM-DD</em> Format.<br /><br />',

    'ACP_BAN'               => 'Banning',
    'ACP_BAN_EMAILS'        => 'Ban by email Address',
    'ACP_BAN_IPS'           => 'Ban by IP Address',
    'ACP_BAN_USERNAMES'     => 'Ban by Username',

    'BAN_CELL'              => 'email Address',
    'BAN_EXCLUDE'           => 'Exclude from Banning',
    'BAN_LENGTH'            => 'Length of the Ban',
    'BAN_REASON'            => 'Reason for the Ban',
    'BAN_GIVE_REASON'       => 'Reason Displayed to the Banned User',
    'BAN_UPDATE_SUCCESSFUL' => 'The Ban List was Successfully Updated.',

    'EMAIL_BAN'                 => 'Ban one or more email Addresses',
    'EMAIL_BAN_EXCLUDE_EXPLAIN' => 'If Enabled you can Exclude the entered email Address from ALL Current Bans.',

    'EMAIL_BAN_EXPLAIN'         => 'To Specify more than one email Address, enter each on a New Line.  To Match Partial Addresses use <strong>*</strong> as the Wildcard, e.g. <em>*@hotmail.com</em>, <em>*@*.domain.tld</em>, etc.<br /><br />',

    'EMAIL_NO_BANNED'           => 'No Banned email Addresses',
    'EMAIL_UNBAN'               => 'Unban emails',

    'EMAIL_UNBAN_EXPLAIN'       => 'You can Unban Single or Multiple email Addresses in one go, simply Click on the email Addresses that you wish to Unban and Click Submit.<br /><br />',

    'IP_BAN'                    => 'Ban one or more IP Address',
    'IP_BAN_EXCLUDE_EXPLAIN'    => 'If Enabled you can Exclude the entered IP from ALL Current Bans.',

    'IP_BAN_EXPLAIN'            => 'To Specify Multiple IP\'s or Hostnames, enter each on a New Line.  To Specify a Range of IP Addresses separate the Start and End with a hyphen <strong>-</strong>, to Specify a Wildcard use <strong>*</strong>.<br /><br />',

    'IP_HOSTNAME'               => 'IP Addresses or Hostnames',
    'IP_NO_BANNED'              => 'No Banned IP Addresses',
    'IP_UNBAN'                  => 'Unban IP\'s',

    'IP_UNBAN_EXPLAIN'          => 'You can Unban Single or Multiple IP Addresses in one go, simply Click on the IP Addresses that you wish to Unban and Click Submit.<br /><br />',

    'LENGTH_BAN_INVALID'        => 'The Date has to be Formatted like:- <em>YYYY-MM-DD</em>.',

    'PERMANENT'                 => 'Permanent',
    'UNTIL'                     => 'Until',

    'USER_BAN'                  => 'Ban one or more Usernames',

    'USER_BAN_EXCLUDE_EXPLAIN'  => 'If Enabled you can Exclude the entered Users from ALL Current Bans.',

    'USER_BAN_EXPLAIN'          => 'You can Ban Multiple Users in one go by entering each Username on a New Line.  Use the <em>Find a Member</em> Facility to Look Up and Add one or more Usernames.<br /><br />',

    'USER_NO_BANNED'            => 'No Banned Usernames',
    'USER_UNBAN'                => 'Unban Usernames',

    'USER_UNBAN_EXPLAIN'        => 'You can Unban Single or Multiple Usernames in one go, simply Click on the Username that you wish to Unban and Click Submit.<br /><br />',
));

?>