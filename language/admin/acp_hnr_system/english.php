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
** File acp_hnr_system/english.php 2018-09-15 06:36:00 Thor
**
** CHANGES
**
** 2018-02-18 - Added New Masthead
** 2018-02-18 - Added New !defined('IN_PMBT')
** 2018-02-18 - Fixed Spelling
** 2018-03-27 - Amended !defined('IN_PMBT')
** 2018-03-27 - Amended the Wording of some Sentences
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
    'TITLE'                           => 'Automated Hit and Run System',

    'TITLE_EXP'                       => 'A Hit and Run User is someone that will Download a File and as Soon as it is Completely Downloaded they Close their Torrent Client without Seeding it back.<br />With this System you can Monitor your Users to make sure that this DOES NOT happen and to Take Action for those that do.<br /><br />',

    'HNR_HEADER'                      => 'Hit and Run Settings',
    'SETTING_SAVED'                   => 'Settings have been Saved to the Database',
    '_admphnr_system'                 => 'Turn ON the Hit and Run System',
    '_admphnr_systemexplain'          => 'Enable or Disable the Hit and Run System',
    '_admpseedtime'                   => 'Seed Time',
    '_admpseedtimeexplain'            => 'Set the Time in Minutes for How Long a User Needs to Seed a Torrent',
    '_admptime_before_warn'           => 'Time Allowed between each Announce',

    '_admptime_before_warnexplain'    => 'How long after the First Missed Announce to give a User before they Receive a Warning PM <br />(Set Time in Minutes)',

    '_admpmaxhitrun'                  => 'Maximum Number of Hit and Runs',
    '_admpmaxhitrunexplain'           => 'Maximum Number of Hit and Runs before a User Receives Warning',
    '_admpwarnlength'                 => 'Length of Warning for Hit and Run',
    '_admpwarnlengthexplain'          => 'How Long should the Hit And Run Warning Last for (Set the Time in Days)',
    '_admpban_hnr_users'              => 'Ban User for Hit and Run',
    '_admpban_hnr_usersexplain'       => 'Select this Option if you want to Ban Users for Hit and Run',
    '_admpdemote_hnr_users'           => 'Demote User for Hit and Run',
    '_admpdemote_hnr_usersexplain'    => 'Select this Option if you want to Demote Users for Hit and Run',
    '_admpafter_high_hnr'             => 'Demote after Maximum Number of Hit And Runs',
    '_admpafter_high_hnrexplain'      => 'Maximum Number of Hit and Runs before User is Demoted',
    '_admpdemote_hnr_users_to'        => 'Demote User',
    '_admpdemote_hnr_users_toexplain' => 'Demote User to a Lower User Class',
    '_admpban_time'                   => 'Length of Time to Demote for Hit and Run',
    '_admpban_timeexplain'            => 'How Long should the Hit And Run User Class Demotion Last for (Set the Time in Days)',
    'ERR_ON'                          => 'Invalid Entry for <strong>Turn ON Hit And Run System</strong>  ( %s )',
    'ERR_DEMOTE'                      => 'Invalid Entry for <strong>Demote User for Hit and Run</strong>  ( %s )',

    'ERR_DEMOTE_TIME'                 => 'Invalid Entry for <strong>Length of Time to Demote for Hit and Run</strong> ( %s ) is NOT Numeric',

    'ERR_DEMOTE_LEVEL'                => 'Invalid Entry for <strong>Demote User to</strong> ( %s ) is NOT a Valid Group',
    'ERR_SEED_TIME'                   => 'Invalid Entry for <strong>Seed Time</strong> ( %s ) is NOT Numeric',
    'ERR_TIME_PREWARN'                => 'Invalid Entry for <strong>Time Allowed between Announce</strong> ( %s ) is NOT Numeric',
    'ERR_MAX_HITS'                    => 'Invalid Entry for <strong>Maximum Number of Hit And Runs</strong> ( %s ) is NOT Numeric',
    'ERR_WARN_LEN'                    => 'Invalid Entry for <strong>Length of Warning for Hit and Run</strong> ( %s ) is NOT Numeric',

    'ERR_AFTER_HIGH'                  => 'Invalid Entry for <strong>Maximum Number of Hit And Runs before User is Demoted</strong> ( %s ) is NOT Numeric',

    'ERR_BAN_HNR'                     => 'Invalid Entry for <strong>Ban User for Hit and Run</strong>  ( %s )',
    'ERR_ARRAY_MESS'                  => '<li>%s</li><br />',
    'SETTINGS_NOT_SAVED'              => 'Hit And Run Settings NOT Saved<br /><br />',
));

?>