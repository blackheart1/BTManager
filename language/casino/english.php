<?php
/**
*
* common [English]
*
* @package language
* @version $Id$
* @copyright (c) 2005 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}
$lang = array_merge($lang, array(
	'TITLE'							=>	'Casino',
	'TITLE_EXP'						=>	'',
	'CASINO_CLOSED'					=>	'Casino is Closed, try later...',
	'AMOUNT'						=>	'Amount',
	'AMOUNT_TO_BET'					=>	'Amount To Bet',
	'CASINO_PLAYER_LIST'			=>	'Casino Players List',
	'BET_SITE_USERS'				=>	'Make bets with other users',
	'EDIT_PLAYER'					=>	'Edit Player',
	'U_CHANCES'						=>	'Your chances',
	'HOW_MUCH_BET'					=>	'How much',
	'RED'							=>	'Red',
	'BLACK'							=>	'Black',
	'BET_ON_COLOR'					=>	'Bet on a Color',
	'BET_ON_NUMB'					=>	'Bet on a Number',
	'NO_AUTH'						=>	'Your Group is not allowed Access to the Casino at this time.',
	'BANNED'						=>	'You have been banned from the Casino.',
	'PLAYTIME_EXEEDED'				=>	'Your playtime is over “%1$s” Times, you have to wait 5 hours.',
	'MAX_DOWNLOAD_EXEEDED'			=>	'You have reached the max download for a single user.',
	'RATIO_TO_LOW'					=>	'Sorry but your Ratio “%1$s” at this time Is Below “%2$s” Please come Back when this has Improved.',
	'MAX_WIN_TO_HIGH'				=>	'Global Max win is above “%1$s”',
	'CAN_NOT_COVER'					=>	'Sorry %1$s you haven\'t uploaded %2$s to cover that Bet"',
	'WIN_COLOR'						=>	'Yes %1$s is the result %2$s you got it and Win %3$s',
	'LOOSE_COLOR'					=>	'Sorry %1$s is Winner and not %2$s, %3$s you lost %4$s',
	'CANT_BET_SELF'					=>	'Sorry You can not Bet your self',
	'PM_YOU_WIN'					=>	'You just won %1$s of upload credit from %2$s',
	'PM_YOU_LOOSE'					=>	'You lost a bet! %1$s just won %2$s of your upload credit!',
	'PM_SUBJECT'					=>	'CASINO BET',
	'BET_TAKEN'						=>	'Sorry this bet has already been taken',
	'CANT_COVER_BET'				=>	'You are “%1$s” short of making that bet!',
	'WIN_CHALENGE'					=>	'<h3>You got it</h3>, <h3>You won the bet, “%1$s” has been creditied to your account!</h3>',
	'LOOSE_CHALENGE'				=>	'<h3>Damn it</h3>, <h3>You lost the bet, <a href=./user.php?op=profile&id=“%1$s”>“%2$s”</a> has won “%3$s” of your hard earned upload credit!</h3>',
	'BET_TAKEN_WIN'					=>	'You just won %1$s of upload credit from %2$s!',
	'BET_TAKEN_LOOSE'				=>	'You lost a bet! %1$s just won %2$s of your upload credit!',
	'MAX_BETS_OPEN'					=>	'There are already %1$s bets open, take an open bet and don´t *tsk tsk... bad language!* with the system!',
	'NO_ZERO_BETS'					=>	'If you win a amount of 0, zero, nada, niente or nichts you are very unhappy. so please don´t add bets without a win!',
	'DONT_CHEAT'					=>	'Don\'t try to cheat the system, or I ban you right now!',
	'CAN_NOT_COVER'					=>	'<h2>You can not cover that bet it\'s %1$s more than you got!</h2>',
	'BET_ADDED'						=>	'Bet added, you will receive a PM notifying you of the results when someone has taken it',
	'BACK_TO_GAME_LIST'				=>	'Back to Games Choice',
	'YOUR_STATS'					=>	'Your Current Stats',
	'YOUR_CASINO_STATS'				=>	'Your Casino Stats',
	'CASINO_STATS'					=>	'Global Stats',
	'CASINO_DEPOSIT'				=>	'Deposit on P2P',
	'PLAY_LOTTERY_NOW'				=>	'Play the Lottery NOW',
	'WON'							=>	'Won',
	'GAMES'							=>	'Games',
	'LOTTERY_STATS'					=>	'Lottery Stats',
	'LOTTERY_STATUS'				=>	'Lottery Status',
	'NEXT_LOTTERY'					=>	'Next Lottery Drawing',
	'LOTTERY_NOT_ACTIVE'			=>	'Lottery Not Activated',
	'OPENED'						=>	'Opened',
	'CLOSED'						=>	'Closed',
	'WINNERS'						=>	'Winners',
	'EACH'							=>	'each',
	'CURRENT_POT'					=>	'The Current Pot',
	'CURRENT_POT_VAL'				=>	'%1$d Extra Upload Data',
	'CURRENT_POT_VAL_EACH'			=>	'%1$d Extra Upload Data Each',
	'LOST'							=>	'Lost',
	'HOW_MANY_WON'					=>	'Lottery Winner count was',
	'HOW_MANY_WON_COUNT'			=>	'%1$d Won',
	'CURRENT_POT'					=>	'Pot Amount',
	'LAST_LOT_DATE'					=>	'Last Lottery Date',
	'CURRENT_SOLD_TICK'				=>	'Current Tickets Bought',
	'SHOW_LOTTERY_PLAYERS'			=>	'Show actuals players',
	'LOTTERY_WINNER'				=>	'Last Lottery Winner was',
	'LOTTERY_WINNERS'				=>	'Last Lottery Winners where',
	'PLAYS'							=>	'Plays',
	'LAST_PLAY'						=>	'Last Time Played',
	'BANN_CASINO'					=>	'Allow User To Play Casino',
	'MEMBERS_CAN_WIN'				=>	'Members can win',
	'USER_CAN_WIN'					=>	'You can win',
	'STAKE'							=>	'Stake',
	'OVER_ALL_STATS'				=> 'Over all Casino Stats',
	'TAKE_BET'						=>	'Take Bet',
	'OPEN_BETS'						=>	'Open Bets',
	'PLACE_A_BET'					=>	'Place a bet',
	'NO_OPEN_BETS'					=>	'There are no Open Bets So Go ahead and make one.',
	'WINNINGS'						=>	'Winnings',
	'BACK_CASINO'					=>	'Back To The Casino.',
	'BACK_PLAYER_LIST'				=>	'Back To The Players List.',
));

?>