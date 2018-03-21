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
** File rate/english.php 2018-03-20 14:04:00 Thor
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
    'TORRENT_RATING'     =>	'Torrent Rating',
    'VOTE_FAIL'          =>	'Vote Failed!',
    'INVALID_VOTE'       =>	'Invalid Vote',
    'INVALID_ID'         =>	'Invalid ID. Torrent DOES NOT Exist',
    'CANT_RATE_OWN'      =>	'You can NOT Rate your Own Torrents',
    'TORRENT_RATED'      =>	'Torrent Already Rated',
    'CANT_RATE_TWICE'    =>	'We are Sorry, but you can\'t Rate a Torrent Twice',
    'VOTE_TAKEN'         =>	'Vote Successful, you will be Redirected to the Torrent Details Page in 3 seconds.',
    'NO_COMPLAINT_ERR'   =>	'Complaint Field Empty!',
    "BANNED_COMPLAINTS"  =>	"This Torrent has been Banned due to a number of Complaints",
    "TWO_COMPLAINTS_ERR" =>	"We're Sorry, but you can't send a Complaint Twice.",
    "COMPLAINT_TAKEN"    =>	"Complaint Registered. You will be Redirected to the Torrent's Detail Page in 3 seconds.",

    "COMPLAINT_REG"      =>	"Your Complaint has been Registered. Your Username and IP have been Logged.  Please DO NOT Abuse the System.<BR>",

    "COMPLAINT_RANK"     =>	'User\'s Sent Positive Feedback<b>%1$s</b> times and Negative Feedback <b>%2$s</b> times.<BR>',
));

?>