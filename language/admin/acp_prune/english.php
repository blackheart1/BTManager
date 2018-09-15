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
** File acp_prune/english.php 2018-09-15 07:02:00 Thor
**
** CHANGES
**
** 2018-03-24 - Amended New !defined('IN_PMBT')
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
    'TITLE'                     => 'Automated Pruning System',
    'TITLE_EXP'                 => 'Configure the Automated Pruning System<br /><br />',
    'SETTING_SAVED'             => 'Settings have been Saved to the Database',
    'USERPRUNE_HEADER'          => 'User Prune Settings',
    '_admpautodel_users'        => 'Turn ON User Prune System',
    '_admpautodel_usersexplain' => 'Enable or Disable User Prune System',
    '_admpinactwarning_time'    => 'Time before email Warning in Days',

    '_admpinactwarning_timeexplain'  => 'How long to Allow a User to be Inactive before a Notice is Sent to them and their Account is Set to Inactive',

    '_admpautodel_users_time'        => 'Time before Delete In Days',

    '_admpautodel_users_timeexplain' => 'How Long after their Account is Set as Inactive before it gets Pruned (Deleted)<br>This DOES NOT Include Parked or Banned Accounts',
));

?>