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
** File polls/english.php 2018-03-20 11:08:00 Thor
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
    'POLL_OVER_VIEW'      => 'Polls Overview',
    'POLL_QUESTION'       => 'Poll Questions',
    'POLL_OPTION_NUM'     => 'Poll Option Number',
    'POLL_USER_OVER_VIEW' => 'Polls User Overview',
    'SELECTION'           => 'Selection',
    'POLL_REMOVED'        => 'Poll was Successfully Removed',
));

?>