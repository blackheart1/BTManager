<?php
/**
*
* betting_system [English]
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
		'BETTIN_INTRO'							=>	'							welcome!<br>
							On this page  you can make bets on sports event! Make your bets and be the best !<br><br>
							Newest bet: <b>%1$s</b>.<br><br>
							If you already bet  and you wish to see if you won, then click 
							<a href="betwin.php">here</a>
							for the winners list!<br><br>
							If you want to know which team won ,then  please click
							<a href="/forum.php?action=viewtopic&t=%2$s">here</a>
							for see that!<br><br>
							Rules:<br>- The max bet is 10&permil;  from your upload <br>
							- For each game you can bet only once.<br>
							- A bet that you made , can not be delete or modify.<br>
							- When the event is ending and if you won ,you will receive the amount what you betting.!<br>
							- If you lose, Nothing will happen anything, your upload amount was taken when you bet.!<br>
							- If your bet is 1 credit, that is equal to 1MB of your upload credit. If you bet 10, that is equal to 10 MB, and so on.<br>
							- The bet amount will be taken from the moment when you agree with the bet.
							<br><br>
							Max credit what you can use With upload : <b>%3$s</b>.<br>
							Max credit what you can use With Bonus points : <b>%4$s</b>.<br>
							Your Actually bet: <b>%5$s</b>.<br>
							Good luck and have fun.',
		'EDIT_BETTING'							=>	'Bet Editing',
		'INVALID_BIT_ID'						=>	'There seems to be a problem with Your bet. No ID attached',
		'INAD_UPLOAD'							=>	'You don\'t have enough upload credit! Make a smaller bet!',
		'ALREADY_BET'							=>	'You have already placed a bet on this category!',
		'EXEED_BET_POOL'						=>	'You exceeded your maximum total bet for this pool.',
		'SUCCESSFULL_BET_UP'					=>	'Successful bet!<br> %1$s your bet is confirmed by the system.<br> The amount was taken from your upload credit! When the mathc is ended , you will receive a PM about the result! Good luck and good betting to everyone!<br><br><a href="betting.php">Click here to go back</a>.',
		'SUCCESSFULL_BET_BO'					=>	'Successful bet!<br> %1$s your bet is confirmed by the system.<br> The amount was taken from your Bonus credit! When the mathc is ended , you will receive a PM about the result! Good luck and good betting to everyone!<br><br><a href="betting.php">Click here to go back</a>.',
		'NOT_AUTH_EDIT_CAT'						=>	'You do not have Authorization to edit Betting Categories!',
		'PAY_LABLE'								=>	'Payout %1$s',
		'CH_LABLE'								=>	'Choice %1$s',
		'BETS_OPEN'								=>	'Bets open',
		'OPEN_BETS'								=>	'Open bets',
		'ED_TH_CAT'								=>	'Edit this category!',
		'POOL'									=>	'Pool',
		'NONEWEST_BET'							=>	'No bets right now , look back later..',
		'YOU_WONE_BET_PM'						=>	'Congratulations you have won Bet %1$s for %2$s %3$s Credits',
		'PM_SUBJECT'							=>	'You are a winner',
		'NO_AUTH_BETWIN'						=>	'You are not authorized to view Bet Winners',
		'WINNER_LIST_T'							=>	'List of winners/bets',
		'WIN_BLOCK_TI'							=>	'List of all winners %1$s on this bet %2$s',
		'PAY_OUT'								=>	'Pay out(click once)',
		'PUT_ACTIVE'							=>	'Put active',
		'OTHER_BETS_CLOSED'						=>	'Other bets (closed)',
		'OPTION1'								=>	'Options 1',
		'OPTION2'								=>	'Options 2',
		'OPTION3'								=>	'Options 3',
		'OPTION4'								=>	'Options 4',
		'OPTION5'								=>	'Options 5',
		'OPTION6'								=>	'Options 6',
		'OPTION7'								=>	'Options 7',
		'OPTION8'								=>	'Options 8',
		'OPTION9'								=>	'Options 9',
		'OPTION10'								=>	'Options 10',
		'MULTPLY1'								=>	'Multiplier 1',
		'MULTPLY2'								=>	'Multiplier 2',
		'MULTPLY3'								=>	'Multiplier 3',
		'MULTPLY4'								=>	'Multiplier 4',
		'MULTPLY5'								=>	'Multiplier 5',
		'MULTPLY6'								=>	'Multiplier 6',
		'MULTPLY7'								=>	'Multiplier 7',
		'MULTPLY8'								=>	'Multiplier 8',
		'MULTPLY9'								=>	'Multiplier 9',
		'MULTPLY10'								=>	'Multiplier 10',
		'BET_EXPIRE'							=>	'Bet Expires',
		'BET_NAME'								=>	'Bet Name',
		'CREATE_NEW'							=>	'Create a new Bet',
		'ACTUAL_BETS'							=>	'Actual bets',
		'USE_YOUR_UPL_BON'						=>	'Use your Upload credit or your Bonus points.',
		'MULTIPLIER'							=>	'Multiplier',
		'UPL_AMOUNT'							=>	'Upload amount',
		'MAKE_YOUR_BET'							=>	'Make your bet',
		'SPORT_BET'								=>	'Sports Bet',
		'RESULTS_FOR'							=>	'What\'s the result?',
		'NO_AUTH_BET'							=>	'You are not Authorized to place bet!',
		'EDIT'                                  =>  'Edit',
		'DEL'                                   =>  'Delete',
        'END_BET'                               =>	'End Betting',	
));
?>