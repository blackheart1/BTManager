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
** File email/english.php 2018-03-10 10:54:00 Thor
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
    'NEW_PM_EMAIL' => '%1$,' . "\n\n" . 'You are receiving this message because User %2$ has sent you a Private Message on %3$.\nYou can read the message at %4$/pm.php?mid=%5$* after logging in.\nIf you feel bothered by the Sender, use the Blacklist Function.  This way you won\'t receive any more messages from the User.' . "\n\n" . 'Regards,' . "\n" . '%3$ Staff' . "\n" . '%4$',

    'NEW_PM_SUB' => 'New Private Message on %1$',
));

?>