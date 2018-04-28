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
** File shout_cast/english.php 2018-03-20 15:23:00 Thor
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
    die ('Error 404 - Page Not Found');
}

if (empty($lang) || !is_array($lang))
{
    $lang = array();
}

$lang = array_merge($lang, array(
    'REQ_TO_LESTIN'        => 'You will need Windows Media Player 10+ or Real Player to Listen to the Radio Stream!',
    'POWERED_BY'           => 'Radio Powered by Shoutcast and Winamp.',
    'LAST_TRACKS'          => 'Last Tracks Played....',
    'MEMBERS_LESTINING'    => 'Members Listening',
    'CURNETLY_PLAYING'     => 'Currently Playing',
    'CLICK_HERE_TO_LISTEN' => 'Click Here to Tune in and Listen Now.',
    'RADIO_STATUS'         => 'Status',
    'RADIO_DJ'             => 'Radio DJ',
    'CUR_BITRATE'          => 'Current Bitrate',
));

?>