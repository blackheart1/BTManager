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
** File backend/english.php 2018-04-17 05:35:00 Thor
**
** CHANGES
**
** 2018-03-02 - Added New Masthead
** 2018-03-02 - Added New !defined('IN_PMBT')
** 2018-03-02 - Fixed Spelling
** 2018-04-17 - Amended !defined('IN_PMBT')
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
    'RSS_BY_CAT'    => 'Best 10 Torrents for Category %1$s on %2$s\' (Files Feed)',
    'RSS_BY_BEST'   => 'Best 10 Torrents on %1$s\' (Files Feed)',
    'RSS_BY_SEARCH' => 'Results for Search Term %1$s on %2$s\' (Files Feed)',
    'RSS_BY_LAST'   => 'The Latest 10 Torrents on %1$s (Files Feed)',
));

?>