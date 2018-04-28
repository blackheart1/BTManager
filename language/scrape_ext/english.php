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
** File scrape/english.php 2018-03-20 15:04:00 Thor
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
    'TITLE'             => 'Peer Update for',
    'AUTH_FAILD'        => 'Authorisation Failed',
    'GROUP_NOT_AU'      => 'Your Group Permissions DO NOT Allow you to Update Peers',
    'TRACKER_MISSING'   => 'Tracker NOT Listed',
    'ERROR_TRACKER_MIS' => 'There appears to be an Error.  The Tracker you Requested %1$s is NOT Listed',
    'INFO_HASH'         => 'Info Hash',
    'DECODED_DATA'      => 'Here is the ID Decoded Response from the Tracker.',
));

?>