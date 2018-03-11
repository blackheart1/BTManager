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
** File comment/english.php 2018-03-09 08:16:00 Thor
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
    'THANK_YOU'         =>	'Thank You!',
    'NO_ID_SET'         =>	'NO ID was Set.  Please Recheck your Link',
    'BAD_ID_NO_FILE'    =>	'There seems to be an Error with the ID.<br />There are NO Files with that ID.',
    'ALREADY_THANKED'   =>	'You have already Posted a Quick "Thank You" on this Torrent.',
    'THANK_TAKEN'       =>	'Thank You was Posted',
    'COMMENTNOTIFY_SUB' =>	'New Comment on %1$s',
    'COMENT_ON_TOR'     =>	'Comments on this Torrent.',
    'COMENT_REMOVED'    =>	'Comment Deleted.  You are being Redirected to the Torrent Details Page in 3 seconds.<br>Click <a href=\'details.php?id=%1$s&comm=startcomments\'>HERE</a> if your Browser doesn\'t forward you.',

    'COMMENT_POSTED'    =>	'Your Comment has been Posted.  You are being Redirected to the Torrent Details Page in 3 seconds.<br>Click <a href=\'details.php?id=%1$s&comm=startcomments\'>HERE</a> if your Browser doesn\'t forward you.'
));

?>