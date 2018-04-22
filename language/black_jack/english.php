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
** File black_jack/english.php 2018-04-18 10:35:00 Thor
**
** CHANGES
**
** 2018-03-02 - Added New Masthead
** 2018-03-02 - Added New !defined('IN_PMBT')
** 2018-03-02 - Fixed Spelling
** 2018-04-18 - Amended the Wording of some Sentences
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
    'TITLE'           => 'BlackJack',

    'TITLE_EXP'       => 'You must get as close as possible to 21 Points...<br />If you have more than 21 you Loose<br /><br />You can Win or Loose 100MB.',

    'RULES'           => 'Rules',
    'GAME_OVER'       => 'Game Over!!',
    'GAME_START'      => 'Deal!!!',
    'CLOSED'          => 'Black Jack is Closed.  Please try later.',
    'NO_AUTH'         => 'You DO NOT have Permission to Play Black Jack.',
    'NOT_ENOUPH_UP'   => 'Sorry.  You haven\'t Uploaded %1$d.',
    'ERR_RATIO'       => 'Sorry.  %1$d, your Ratio is Under %2$d.',
    'ERR_BANNED'      => 'Sorry.  You\'re Banned from playing Black Jack.',
    'ERR_MAXTRYS'     => 'Sorry.  Your Playtime is over %1$d times, you have to wait 5 hours.',
    'ERR_MAX_LOOSE'   => 'Sorry.  You have Reached the Maximum Download for a Single User.',
    'ERR_MAX_WIN'     => 'Sorry.  But your Maximum Profits is above %1$d.',
    'ERR_WAIT'        => 'You have to wait for another User to play against you.',
    'ERR_UNFINNISHED' => 'You have to Finish your Opened Game.<br /><a href=\'blackjack.php?game=count\'>Continue Old Game</a>',
    'HIT_ME'          => 'Give me another one.',
    'STAND'           => 'Stand.',
    'POINTS'          => 'You have',
    'ROUND'           => 'Round %1$d',
    'WELCOME'         => 'Welcome %1$s',
    'WELCOME_USER'    => 'Welcome',
    'WON_BLACK_JACK'  => 'Black Jack.  You have Hit 21 Points.',
    'BOTH_BLACK_JACK' => 'Both you and your opponent Hit Black Jack so there are No Winners or Losers.',
    'WON_YOU'         => 'You Won the game you had %1$d your Opponent %2$d had %3$d',
    'WON_OPT'         => 'You Lost the game you had %1$d your Opponent %2$d had %3$d',
    'WON_NONE'        => 'This Game was awash there are NO Winners',
    'BUST'            => 'Bust!!!<br />You have gone Over 21.  You have Lost this Game',

    'MUST_WAIT'       => 'You have %1$d Points, there are NO other Players, so you\'ll have to wait for someone to play against you.  You will be PM\'d about the Game Results',

    'PM_WON_YOU'      => "We are PM\'ing you to inform you that the Black Jack game you have Played is Now Over.\nYour Opponent was <a href=\"user.php?op=profile&amp;id=" . '%1$s>%2$s</a> ' . "\n" . 'they had %3$s Points and you have %4$s therefore you [b]Win the Game[/b].' . "\n" . 'You have had %5$s Upload Credit Added to your Account ' . "\n" . '<a href=\'blackjack.php\'>Play another Game?</a>',

    'PM_WON_OPT'      => "We are PM\'ing you to inform you that the Black Jack game you have Played is now Over.\nYour Opponent was <a href=\"user.php?op=profile&amp;id=" . '%1$s>%2$s</a> ' . "\n" . 'they had %3$s Points and you have %4$s therefore you [b]Lost the Game[/b].' . "\n" . 'You have had %5$s Upload Credit Removed from your account ' . "\n" . '<a href=\'blackjack.php\'>Play another Game?</a>',

    'PM_SUBJECT'      => 'Your Black Jack Game Results',
));

?>