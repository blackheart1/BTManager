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
** File info_acp_recenttopics/english.php 2018-03-11 10:01:00 Thor
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
    'RECENT_TOPICS'              => 'Recent Topics',
    'POST_BY_AUTHOR'             => 'by',
    'IN'                         => 'in',
    'RECENT_TOPICS_LIST'         => 'View on Recent Topics',
    'RECENT_TOPICS_LIST_EXPLAIN' => 'Shall Topics of this Forum be Displayed on the Index in Recent Topics?',
    'RECENT_TOPICS_MOD'          => 'Recent Topics MOD',

    'RT_CONFIG'                  => 'Configuration',
    'RT_ANTI_TOPICS'             => 'Excluded Topics',

    'RT_ANTI_TOPICS_EXP'         => 'Separated by a <strong>,</strong> (Example: 7, 9)<br />If you Don\'t want to Exclude a Topic, just enter 0.',

    'RT_NUMBER'                  => 'Recent Topics',
    'RT_NUMBER_EXP'              => 'Number of Topics Displayed on the Index.',
    'RT_PAGE_NUMBER'             => 'Recent Topics Pages',

    'RT_PAGE_NUMBER_EXP'         => 'You can Display more Recent Topics on a Little Pagination. If you Enter 0 you\'ll end up with Multiple Pages which is  Required to Display ALL the Topics.  Enter 1 to Disable this Feature. ',

    'RT_PARENTS'                 => 'Display Parent Forums',
    'RT_SAVED'                   => 'Saved Adjustments.',

    'RT_VIEW_ON'                 => 'View Recent Topics on',
    'RT_MEMBERLIST'              => 'Member List',
    'RT_INDEX'                   => 'Index',
    'RT_SEARCH'                  => 'Search',
    'RT_FAQ'                     => 'FAQ',
    'RT_MCP'                     => 'MCP (Moderator Control Panel)',
    'RT_UCP'                     => 'UCP (User Control Panel)',
    'RT_VIEWFORUM'               => 'View Forum',
    'RT_VIEWTOPIC'               => 'View Topic',
    'RT_VIEWONLINE'              => 'View Online',
    'RT_POSTING'                 => 'Posting',
    'RT_REPORT'                  => 'Reporting',
    'RT_OTHERS'                  => 'Other Site',

    // Installer
    'INSTALL_RECENT_TOPICS_MOD'           => 'Install Recent Topics MOD',

    'INSTALL_RECENT_TOPICS_MOD_CONFIRM'   => 'Are you sure you want to Install the Recent Topics MOD?',

    'UPDATE_RECENT_TOPICS_MOD'            => 'Update Recent Topics MOD',

    'UPDATE_RECENT_TOPICS_MOD_CONFIRM'    => 'Are you sure you want to Update the Recent Topics MOD?',

    'UNINSTALL_RECENT_TOPICS_MOD'         => 'Uninstall Recent Topics MOD',

    'UNINSTALL_RECENT_TOPICS_MOD_CONFIRM' => 'Are you sure you want to Uninstall the Recent Topics MOD?',
));

?>