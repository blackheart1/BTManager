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
** File shouts/english.php 2018-03-20 15:48:00 Thor
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
	'SHOUT_COMAND_HELP_USER' => '[quote]As a User, you have the following Commands:
        If you want to View this Message in the Shoutbox <strong>/help</strong>
        If you want to Slap a User <strong>/slapuser</strong> Username
        If you want to Send a Quick Private Message <strong>/pmuser</strong> Username or ID + Message
        If you want to Speak at 3rd Person <strong>/me</strong> Message[/quote]',

	'SHOUT_COMAND_HELP_ADMIN' => '[quote]As a Staff Member, you have the following Commands:
        If you want to make an Notice <strong>/notice</strong>
        If you want to Empty Shouts <strong>/empty</strong>
        If you want to Warn or Unwarn a User <strong>/warn</strong> Username AND <strong>/unwarn</strong> Username
        If you want to Ban(Disable) or Unban(Enable) a User <strong>/ban</strong> Username AND <strong>/unban</strong> Username
        To Delete All Notices from the Shout <strong>/deletenotice</strong>
        If you want to Slap a User <strong>/slapuser</strong> Username
        If you want to Send a Quick Private Message <strong>/pmuser</strong> Username or ID + Message
        If you want to Speak at 3rd Person <strong>/me</strong> Message[/quote]',

    'NO_SHOUTS'           => 'NO Shouts at this Time!',
    'SHOUTBOX_ARCHIVE'    => 'Shoutbox Archive',
    'TOTAL_SHOUTS_POSTED' => 'Total Shouts Posted',
    'SHOUTS_IN_TWFOUR'    => 'Shouts in Past 24 Hours',
    'YOUR_SHOUTS'         => 'Your Shouts',
    'TOPFIFTEEN_SHOUTERS' => 'Top 15 Shouters',
    'SORT_BY'             => 'Sort Results by',
    'NEW_FIRST'           => 'Newest First',
    'OLD_FIRST'           => 'Oldest First',
    'SEARCH_TIME'         => 'Within Past <em>X</em> Hours',
    'USERNAME_CONTAINS'   => 'Username Contains',
    'SEARCH_CONTAINS'     => 'Shout Contains',
    'SEARCH_TERM'         => 'Search Terms',
    'SEARCH_SHOUTS'       => 'Search Shouts',
));

?>