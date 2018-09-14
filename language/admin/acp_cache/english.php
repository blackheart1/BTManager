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
** File acp_cache/english.php 2018-09-14 06:52:00 Thor
**
** CHANGES
**
** 2018-02-21 - Added New Masthead
** 2018-02-21 - Added New !defined('IN_PMBT')
** 2018-02-21 - Fixed Spelling
** 2018-03-24 - Amended !defined('IN_PMBT')
** 2018-03-24 - Amended the Wording of some Sentences
** 2018-03-28 - Amended !defined('IN_PMBT') Corrected Path
**/

if (!defined('IN_PMBT'))
{
    include_once './../../../security.php';
    die ("Error 404 - Page Not Found");
}

if (empty($lang) || !is_array($lang))
{
    $lang = array();
}

$lang = array_merge($lang, array(
    'CACHE'                  => 'Cache',
    'TITLE'                  => 'Site Cache',

    'TITLE_EXP'              => 'Here is where you can Set the Maximum Time to Hold Cache Files for before they get Updated.  The Longer you Keep them, the Better the Site Speed will be.<br /><br />',

    '_admpsql_time'          => 'SQL Cache Time',

    '_admpsql_timeexplain'   =>  'Note:- The Value that you Enter Here is also used for the Site\'s Configuration Settings, Shout Box Configuration and more...',

    '_admptheme_time'        => 'Theme Cache Time',
    '_admptheme_timeexplain' => 'Maximum Time to Hold Cache Files for your Themes',
    '_admpcache_dir'         => 'Cache Directory',

    '_admpcache_direxplain'  => 'This Directory will Need to be Writeable by the System.<br /><strong>DO NOT</strong> Add the Trailing Slash <strong>/</strong>',

    'ERR_SQL_TIME'           => 'There Appears to be an Issue with the Time you Set for the SQL Cache<br /><br />You Entered %1$s<br /><br /> Please Go Back and Enter a Numeric Value.',

    'ERR_THEME_TIME'         => 'There Appears to be an Issue with the Time you Set for the Theme\'s Cache<br /><br />You Entered %1$s<br /><br />Please Go Back and Enter a Numeric Value.',

    'ERR_CACHE_DIR_NOTSET'   => 'There Appears to be an Issue Locating the Cache Directory you chose (%1$s).<br /><br />Please Go Back and make sure that you\'ve Entered the Correct Path to your Cache Directory and that it\'s Writeable.',

    'ERR_CACHE_DIR_NOT_WRITEABLE' => 'The Directory is NOT Writeable<br /><br />(%1$s)',
    'ERR_ARRAY_MESS'              => '<li>%s</li>',
));

?>