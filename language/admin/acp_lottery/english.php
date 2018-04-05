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
** File acp_lottery/english.php 2018-03-28 00:53:00 Thor
**
** CHANGES
**
** 2018-02-23 - Added New Masthead
** 2018-02-23 - Added New !defined('IN_PMBT')
** 2018-02-23 - Fixed Spelling
** 2018-03-28 - Amended !defined('IN_PMBT')
** 2018-03-28 - Amended the Wording of some Sentences
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
    'YES_NO_TF' => array('1'=>'Yes','0'=>'No'),
    'YES_NO'    => array('yes'=> 'Yes','no'=>'No'),
    'GB_MB'     => array('GB'=>'GB','MB'=>'MB'),

    'AUTH_UPDATED'               => 'Settings were Successfully Changed',
    'TITLE'                      => 'Lottery Configuration',
    'TITLE_EXPLAIN'              => 'You can Configure the Lottery Settings Here',
    'ERR_LOTTERY_OPEN'           => 'Lottery Enabled',

    'ERR_LOTTERY_OPEN_EXP'       => 'The Lottery is Currently Enabled, so this Configuration Page is Closed.<br /><br />Users Currently Playing in this Lottery, are:- <br /> %s',

    'TABLE_OPEN'                 => 'The Lottery',

    '_admpenable'                => 'Enable the Lottery',

    '_admpenableexplain'         => 'Once you have Enabled the Lottery you will NO longer be able to Edit it!<br />So make sure it is how you want before doing so.',

    '_admpuse_prize_fund'            => 'Use Prize Fund',
    '_admpuse_prize_fundexplain'     => 'Sets the Pot to Use: Default Pot of ALL Users',
    '_admpprize_fund'                => 'Prize Fund',
    '_admpprize_fundexplain'         => 'What Size will the Pot be when a User Wins?<br />Only if Set to Use the Prize Fund.',
    '_admpticket_amount'             => 'Ticket Amount',
    '_admpticket_amountexplain'      => 'How much will you Charge for a Ticket?',
    '_admpticket_amount_type'        => 'Ticket Amount Type',
    '_admpticket_amount_typeexplain' => 'Set the Ticket Type and how much Ticket Costs',
    '_admpuser_tickets'              => 'Amount of Tickets Allowed',
    '_admpuser_ticketsexplain'       => 'How many Tickets is a User Allowed to Purchase?',
    '_admpclass_allowed'             => 'Access Level',
    '_admpclass_allowedexplain'      => 'Select the Groups you wish to Allow to Play Lottery.',
    '_admptotal_winners'             => 'Total Winners',
    '_admptotal_winnersexplain'      => 'How many Users will Win the Lottery?',
    '_admpcurenttime'                => 'Current Date/Time',
    '_admpcurenttimeexplain'         => 'Set the Date/Time the Lottery will Start',
    '_admpstart_date'                => 'Start Date',
    '_admpstart_dateexplain'         => 'This will Set the Start Date of the Lottery',
    '_admpend_date'                  => 'End Date',
    '_admpend_dateexplain'           => 'This will Set the End Date of Lottery will End',
));

?>