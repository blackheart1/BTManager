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
** File makepoll/english.php 2018-03-11 10:27:00 Thor
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
    'POLL_MANAGER'      => 'Poll Management',
    'MAKE_POLL'         => 'Make Poll',
    'EDIT_POLL'         => 'Edit Poll',
    'REQ_FEALD'         => 'Required Field',
    'QUISTION'          => 'Poll Question',
    'SORT'              => 'Sort',
    'OPTION_A'          => 'Option 1',
    'OPTION_B'          => 'Option 2',
    'OPTION_C'          => 'Option 3',
    'OPTION_D'          => 'Option 4',
    'OPTION_E'          => 'Option 5',
    'OPTION_F'          => 'Option 6',
    'OPTION_G'          => 'Option 7',
    'OPTION_H'          => 'Option 8',
    'OPTION_I'          => 'Option 9',
    'OPTION_J'          => 'Option 10',
    'NEW_POLL_NOTICE'   => 'Note: The Current Poll <em>%1$s</em> is Only %2$s Old.',
    'WARNING'           => 'Warning!',
    'HOUR'              => 'Hour',
    'HOURS'             => 'Hours',
    'DAY'               => 'Day',
    'DAYS'              => 'Days',
    'POLL_EDITED'       => 'Poll Successfully Edited',
    'POLL_TAKEN'        => 'New Poll Has Been Added',
    'NO_POLL_FOUND'     => 'No Poll found with ID <em>%1$s</em>',
    'INVALID_POLL_ID'   => 'Invalid ID <em>%1$s</em>',
    'MISSING_FORM_DATA' => 'Missing Form Data!',
));

?>