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
** File rate/english.php 2018-04-28 07:16:00 Thor
**
** CHANGES
**
** 2018-03-02 - Added New Masthead
** 2018-03-02 - Added New !defined('IN_PMBT')
** 2018-03-02 - Fixed Spelling
** 2018-04-28 - Amended the Wording of some Sentences
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
    'TORRENT_RATING'     => 'Torrent Rating',
    'VOTE_FAIL'          => 'Vote Failed!',
    'INVALID_VOTE'       => 'Invalid Vote',
    'INVALID_ID'         => 'Invalid ID.  Torrent DOES NOT Exist',
    'CANT_RATE_OWN'      => 'You can NOT Rate your Own Torrents',
    'TORRENT_RATED'      => 'Torrent already Rated',
    'CANT_RATE_TWICE'    => 'We\'re Sorry, but you can\'t Rate a Torrent Twice',
    'VOTE_TAKEN'         => 'Vote Successful.  You will be Redirected back to the Torrent Details Page in 3 seconds.',
    'NO_COMPLAINT_ERR'   => 'Complaint Field Empty!',
    'BANNED_COMPLAINTS'  => 'This Torrent has been Banned due to a number of Complaints.',
    'TWO_COMPLAINTS_ERR' => 'We\'re Sorry, but you can\'t send a Complaint Twice.',
    'COMPLAINT_TAKEN'    => 'Complaint Received.  You will be Redirected back to the Torrent\'s Detail Page in 3 seconds.',

    'COMPLAINT_REG'      => 'Your Complaint has been Received.  Your Username and IP have been Logged.  Please DO NOT Abuse the System.<br />',

    'COMPLAINT_RANK'     => 'User\'s Sent Positive Feedback <strong>%1$s</strong> times and Negative Feedback <strong>%2$s</strong> times.<br />',
));

?>