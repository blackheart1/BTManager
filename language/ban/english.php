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
** File ban/english.php 2018-03-02 10:15:00 Thor
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
    '1_HOUR'  => '1 hour',
    '30_MINS' => '30 minutes',
    '6_HOURS' => '6 hours',

	'ACP_BAN_EXPLAIN'	=> 'Here you can Control the Banning of Users by Name, IP or email Address. These methods prevent a User reaching any part of the Board. You can give a Short (Maximum 3000 Characters) Reason for the Ban if you wish. This will be Displayed in the Administrator\'s Log. The Duration of a Ban can also be Specified. If you want the Ban to End on a Specific Date rather than After a Set Time Period, Select <span style="text-decoration: underline;">Until -&gt;</span> for the Ban Length and Enter a Date in <kbd>YYYY-MM-DD</kbd> Format.',

	'ACP_BAN'					=> 'Banning',
	'ACP_BAN_EMAILS'			=> 'Ban emails',
	'ACP_BAN_IPS'				=> 'Ban IP\'s',
	'ACP_BAN_USERNAMES'			=> 'Ban Username\'s',

    'BAN_EXCLUDE'               => 'Exclude From Banning',
    'BAN_LENGTH'                => 'Length of Ban',
    'BAN_REASON'                => 'Reason for Ban',
    'BAN_GIVE_REASON'           => 'Reason Displayed to the Banned User',
    'BAN_UPDATE_SUCCESSFUL'     => 'The Ban List has been Updated Successfully.',

    'EMAIL_BAN'                 => 'Ban one or more email Addresses',
    'EMAIL_BAN_EXCLUDE_EXPLAIN' => 'Enable this to, Exclude the entered email Address from ALL Current Bans.',
    'EMAIL_BAN_EXPLAIN'         => 'To Specify more than one email Address, enter each on a New Line. To Match Partial Addresses use * as the Wildcard, e.g. <samp>*@hotmail.com</samp>, <samp>*@*.domain.tld</samp>, etc.',

    'EMAIL_NO_BANNED'           => 'No Banned email Addresses',
    'EMAIL_UNBAN'               => 'Unban emails',
    'EMAIL_UNBAN_EXPLAIN'       => 'You can Unban Single or Multiple email Addresses in one go using the appropriate combination of Mouse and Keyboard for your Computer and Browser. Excluded email Addresses are Emphasised.',

    'IP_BAN'                    => 'Ban one or more IP\'s',
    'IP_BAN_EXCLUDE_EXPLAIN'    => 'Enable this to Exclude the entered IP from ALL Current Bans.',
    'IP_BAN_EXPLAIN'            => 'To Specify Multiple IP\'s or Hostnames, enter each on a New Line. To Specify a Range of IP Addresses separate the Start and End with a hyphen (-), to Specify a Wildcard use ?*?.',

    'IP_HOSTNAME'               => 'IP Addresses or Hostnames',
    'IP_NO_BANNED'              => 'No Banned IP Addresses',
    'IP_UNBAN'                  => 'Unban IP\'s',
    'IP_UNBAN_EXPLAIN'          => 'You can Unban Single or Multiple IP Addresses in one go using the appropriate combination of Mouse and Keyboard for your Computer and Browser. Excluded IP\'s are Emphasised.',

    'LENGTH_BAN_INVALID'        => 'The Date has to be Formatted like:- <kbd>YYYY-MM-DD</kbd>.',

    'PERMANENT'                 => 'Permanent',

    'UNTIL'                     => 'Until',
    'USER_BAN'                  => 'Ban one or more Usernames',
    'USER_BAN_EXCLUDE_EXPLAIN'  => 'Enable this to Exclude the entered Users from ALL Current Bans.',
    'USER_BAN_EXPLAIN'          => 'You can Ban Multiple Users in one go by entering each Name on a New Line. Use the <span style="text-decoration: underline;">Find a Member</span> Facility to Look Up and Add one or more Users Automatically.',

    'USER_NO_BANNED'            => 'No Banned Usernames',
    'USER_UNBAN'                => 'Unban Usernames',
    'USER_UNBAN_EXPLAIN'        => 'You can Unban Single or Multiple Users in one go using the appropriate combination of Mouse and Keyboard for your Computer and Browser.  Excluded Users are Emphasised.',
));

?>