<?php
/**
*
* bbcode [English]
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
	'TITLE'					=>	'BlackJack',
	'TITLE_EXP'				=>	'You must get as close as possible to 21 points...<br/>If you have more than 21 you loose<br/><br/>You can win or loose 100MB',
	'RULES'					=>	'Rules',
	'GAME_OVER'				=>	'Game Over!!',
	'GAME_START'			=>	'Deal!!!',
	'CLOSED'				=>	'Black Jack is Closed, try later...',
	'NO_AUTH'				=>	'You are not autherized to Play Black Jack',
	'NOT_ENOUPH_UP'			=>	'Sorry You haven\'t uploaded %1$d',
	'ERR_RATIO'				=>	'Sorry %1$d, your Ratio is under %2$d',
	'ERR_BANNED'			=>	'Sorry you\'re Banned from Casino.',
	'ERR_MAXTRYS'			=>	'Sorry your playtime is over %1$d Times, you have to wait 5 hours.',
	'ERR_MAX_LOOSE'			=>	'Sorry you have reached the Max Download for a Single User.',
	'ERR_MAX_WIN'			=>	'Sorry but Your maximum Profits is above %1$d',
	'ERR_WAIT'				=>	'You have to wait for another user to play against you',
	'ERR_UNFINNISHED'		=>	'You have to finish your opened game. <br /><a herf="./blackjack.php?game=count">Continue old game</a>',
	'HIT_ME'				=>	'Give me another one',
	'STAND'					=>	'Stand',
	'POINTS'				=>	'You have',
	'ROUND'					=>	'Round %1$d',
	'WELCOME'				=>	'Welcome %1$s',
	'WELCOME_USER'			=>	'Welcome',
	'WON_BLACK_JACK'		=>	'Black Jack you have hit 21 points',
	'BOTH_BLACK_JACK'		=>	'Both you and your oponinet Hit Black Jack There are no winners or loosers',
	'WON_YOU'				=>	'You Won The game You had %1$d Your oponinet “%2$d” had %3$d',
	'WON_OPT'				=>	'You lost The game You had %1$d Your oponinet “%2$d” had %3$d',
	'WON_NONE'				=>	'This game was a Wash there are no winners',
	'BUST'					=>	'Bust!!!<br /> You have gone over 21 You have lost this game',
	'MUST_WAIT'				=>	'You have %1$d Points, there\'s no other players, so you\'ll have to wait for someone to play against you. You will be PM\'d about game results',
	'PM_WON_YOU'			=>	"We are PMing you to inform you that the Black Jack game You have Played is now Over.\nYour Opponent Was <a href=\"user.php?op=profile&amp;id=" . '%1$s>%2$s</a> ' . "\n" . 'They Had “%3$s” Points and you have “%4$s” There for You [b]Win The Game[/b].' . "\n" . 'You have had “%5$s” Upload credit added to your account ' . "\n" . '<a herf="./blackjack.php">Play another Game</a>',
	'PM_WON_OPT'			=>	"We are PMing you to inform you that the Black Jack game You have Played is now Over.\nYour Opponent Was <a href=\"user.php?op=profile&amp;id=" . '%1$s>%2$s</a> ' . "\n" . 'They Had “%3$s” Points and you have “%4$s” There for You [b]Lost The Game[/b].' . "\n" . 'You have had “%5$s” Upload credit removed from your account ' . "\n" . '<a herf="./blackjack.php">Play another Game</a>',
	'PM_SUBJECT'			=>	'Your Black Jack Game results',
));
?>