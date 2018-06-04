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
** File bonous/english.php 2018-04-18 10:35:00 Thor
**
** CHANGES
**
** 2018-03-02 - Added New Masthead
** 2018-03-02 - Added New !defined('IN_PMBT')
** 2018-03-02 - Fixed Spelling
** 2018-04-18 - Amended the Wording of some Sentences
** 2018-04-18 - Fixed Seed Bonus not Showing
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
    'BONUS_EXCHANGE'          => 'Bonus Exchange',
    'BONUS_SYSTEM_CLOSED'     => 'Bonus System is Closed',

    'BONUS_SYSTEM_CLOSED_EXP' => 'We\'re sorry to announce, but at this time we are NOT using the Bonus System<br />If you feel you have reached this Error by mistake, please Contact one of the Site\'s Moderators so that they may assist you.',

    'BONUS_SYS_EXP'           => 'Here you can Exchange your Seed Bonus (Currently: %1$s)<br />(If the Button\'s Deactivated, then you DO NOT have enough to Trade.)<br />',

    'OPTIONS_ABOUT'           => 'What\'s this about?',
    'POINTS'                  => 'Points',
    'TRADE'                   => 'Trade',
    'DISABLED'                => 'Disabled!',
    'EXCHANGE'                => 'Exchange!',
    'HOW_TO_GET'              => 'How do I get Points?',
    'POINTS_EACH_TOR'         => ' (for each Torrent) ',
    'POINTS_TOTAL'            => ' (Total) ',

    'POINTS_OPTION_VAR'  => array('A' => 'You will Receive %1$s %2$s Points for every 10 minutes the System Registers you as being a Seeder.',
                                  'B' => 'You will Receive %1$s Points for Uploading a New Torrent.',

                                  'C' => 'You will Receive %1$s Points for Leaving a Comment on a Torrent (that includes a Quick Thanks).',

                                  'D' => 'You will Receive %1$s Points for Filling a Requested Torrent<br />(Note any Comment Deleted by you or Staff will Result in the Loss of those Points so NO Flooding)',

                                  'E' => 'You will Receive %1$s Points for Making an Offer to Upload a Torrent.',),

    'NOT_ENOUPH_POINTS'             => 'NOT enough Points to Trade...',
    'NO_VALID_ACTION'               => 'NO Valid Type',

    'POINT_TRADE_MOD_COM'           => array('TRAFIC' => '- User has Traded %1$s Points for Traffic.\n %2$s\n',
                                             'INVITE' => ' - User has Traded %1$s Points for Invites.\n ',),

    'EXCHANGE_SUC'                  => array('TRAFIC' => 'You have Traded %1$s Points for Traffic',
                                             'INVITE' => 'You have Traded %1$s Points for %2$s Invites',),
    ));

?>