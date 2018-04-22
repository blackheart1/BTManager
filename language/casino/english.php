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
** File casino/english.php 2018-04-20 20:44:00 Thor
**
** CHANGES
**
** 2018-03-02 - Added New Masthead
** 2018-03-02 - Added New !defined('IN_PMBT')
** 2018-03-02 - Fixed Spelling
** 2018-04-20 - Amended the Wording of some Sentences
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
    'TITLE'                => 'Casino',
    'TITLE_EXP'            => '',
    'CASINO_CLOSED'        => 'Casino is Currently Closed.',
    'AMOUNT'               => 'Amount',
    'AMOUNT_TO_BET'        => 'Amount to Bet',
    'CASINO_PLAYER_LIST'   => 'Casino Players List',
    'BET_SITE_USERS'       => 'Make Bets with other Users',
    'EDIT_PLAYER'          => 'Edit Player',
    'U_CHANCES'            => 'Your Chances',
    'HOW_MUCH_BET'         => 'How much',
    'RED'                  => 'Red',
    'BLACK'                => 'Black',
    'BET_ON_COLOR'         => 'Bet on a Colour',
    'BET_ON_NUMB'          => 'Bet on a Number',
    'NO_AUTH'              => 'Sorry, but your Group is NOT Allowed Access to the Casino at this time.',
    'BANNED'               => 'Sorry, but your currently Banned from the Casino!',
    'PLAYTIME_EXEEDED'     => 'Your Playtime is over %1$s times, you have to wait 5 hours.',
    'MAX_DOWNLOAD_EXEEDED' => 'You have Reached the Maximum Download for a Single User.',
    'RATIO_TO_LOW'         => 'Sorry, your Ratio %1$s at this time is below %2$s.  Please come Back when this has Improved.',
    'MAX_WIN_TO_HIGH'      => 'Global Maximum Win is above %1$s',
    'CAN_NOT_COVER'        => 'Sorry, %1$s you haven\'t Uploaded %2$s to Cover that Bet"',
    'WIN_COLOR'            => 'Yes %1$s is the Result %2$s you got it and Win %3$s',
    'LOOSE_COLOR'          => 'Sorry, %1$s is the Winner and not %2$s, %3$s you Lost %4$s',
    'CANT_BET_SELF'        => 'Sorry, but you can NOT Bet against yourself',
    'PM_YOU_WIN'           => 'You just Won %1$s of Upload Credit from %2$s',
    'PM_YOU_LOOSE'         => 'You Lost a Bet! %1$s just Won %2$s of your Upload Credit!',
    'PM_SUBJECT'           => 'CASINO BET',
    'BET_TAKEN'            => 'Sorry, this Bet has already been Claimed.',
    'CANT_COVER_BET'       => 'You are %1$s Short of making that Bet!',
    'WIN_CHALENGE'         => '<h3>You got it</h3>, <h3>You Won the Bet, %1$s has been Credited to your Account!</h3>',

    'LOOSE_CHALENGE'       => '<h3>Damn it</h3>, <h3>You Lost the Bet, <a href=./user.php?op=profile&id="%1$s">"%2$s"</a> has Won %3$s of your Hard Earned Upload Credit!</h3>',

    'BET_TAKEN_WIN'        => 'You just Won %1$s of Upload Credit from %2$s!',
    'BET_TAKEN_LOOSE'      => 'You Lost a Bet! %1$s just Won %2$s of your Upload Credit!',

    'MAX_BETS_OPEN'        => 'There are already %1$s Bets Open, take an Open Bet and don\'t *tsk-tsk... bad language!* with the System!',

    'NO_ZERO_BETS'         => 'If you Win an amount of 0, zero, Nada, Niente or Nichts you are very unhappy, so please don´t Add Bets without a Win!',

    'DONT_CHEAT'           => 'Don\'t try to Cheat the System, or you\'ll be Banned!',
    'CAN_NOT_COVER'        => '<h2>You can NOT Cover that Bet it\'s %1$s more than you\'ve got!</h2>',
    'BET_ADDED'            => 'Bet Added.  You\'ll Receive a PM notifying you of the Results when someone has taken it',
    'BACK_TO_GAME_LIST'    => 'Back to Games Choice',
    'YOUR_STATS'           => 'Your Current Statistics',
    'YOUR_CASINO_STATS'    => 'Your Casino Statistics',
    'CASINO_STATS'         => 'Global Statistics',
    'CASINO_DEPOSIT'       => 'Deposit on P2P',
    'PLAY_LOTTERY_NOW'     => 'Play the Lottery NOW',
    'WON'                  => 'Won',
    'GAMES'                => 'Games',
    'LOTTERY_STATS'        => 'Lottery Statistics',
    'LOTTERY_STATUS'       => 'Lottery Status',
    'NEXT_LOTTERY'         => 'Next Lottery Drawing',
    'LOTTERY_NOT_ACTIVE'   => 'Lottery is Currently NOT Activated',
    'OPENED'               => 'Opened',
    'CLOSED'               => 'Closed',
    'WINNERS'              => 'Winners',
    'EACH'                 => 'each',
    'CURRENT_POT'          => 'The Current Pot',
    'CURRENT_POT_VAL'      => '%1$d Extra Upload Data',
    'CURRENT_POT_VAL_EACH' => '%1$d Extra Upload Data each',
    'LOST'                 => 'Lost',
    'HOW_MANY_WON'         => 'Lottery Winner Count was',
    'HOW_MANY_WON_COUNT'   => '%1$d Won',
    'CURRENT_POT'          => 'Pot Amount',
    'LAST_LOT_DATE'        => 'Last Lottery Date',
    'CURRENT_SOLD_TICK'    => 'Current Tickets Bought',
    'SHOW_LOTTERY_PLAYERS' => 'Show ALL Players',
    'LOTTERY_WINNER'       => 'Last Lottery Winner was',
    'LOTTERY_WINNERS'      => 'Last Lottery Winner\'s were',
    'PLAYS'                => 'Play\'s',
    'LAST_PLAY'            => 'Last Time Played',
    'BANN_CASINO'          => 'Allow User to Play Casino',
    'MEMBERS_CAN_WIN'      => 'Members can Win',
    'USER_CAN_WIN'         => 'You can Win',
    'STAKE'                => 'Stake',
    'OVER_ALL_STATS'       => 'Overall Casino Statistics',
    'TAKE_BET'             => 'Take Bet',
    'OPEN_BETS'            => 'Open Bets',
    'PLACE_A_BET'          => 'Place a Bet',
    'NO_OPEN_BETS'         => 'There are NO Open Bets so go ahead and make one.',
    'WINNINGS'             => 'Winnings',
    'BACK_CASINO'          => 'Back to the Casino.',
    'BACK_PLAYER_LIST'     => 'Back to the Players List.',
));

?>