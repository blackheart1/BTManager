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
** File betting_system/english.php 2018-03-07 08:44:00 Thor
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
    'BETTIN_INTRO' => 'Welcome!<br>
        On this page you can make Bet\'s on Sporting Event\'! Make your Bets and be the Best !<br><br>
        Newest Bet: <b>%1$s</b>.<br><br>

        If you had already placed a Bet and you wish to see if you Won, then please Click
        <a href = "betwin.php">HERE</a>


        If you want to know which Team Won, then please Click
        <a href = "/forum.php?action=viewtopic&t=%2$s">HERE</a>
        <br><br>

        Rules:<br>- The Maximum Bet is 10& per mil; from your Upload <br>

        - For each Game you can Bet Only Once.<br>

        - A Bet that you made, can NOT be Deleted or Modified.<br>

        - When the Event has Ended and if you Won then you will Receive that Amount!<br>

        - If you Lose, Nothing will happen, your Upload Amount was taken when you Bet.!<br>

        - If your Bet is 1 Credit, that is Equal to 1MB of your Upload Credit. If you Bet 10, that is Equal to 10MB, and so on.<br>

        - The Bet Amount will be Taken the moment you Agree with the Bet.<br><br>

        Maximum Credit what you can use with Upload : <b>%3$s</b>.<br>
        Maximum Credit what you can use with Bonus Points : <b>%4$s</b>.<br>
        Your Actually Bet: <b>%5$s</b>.<br>
        Good Luck and have Fun...',

    'EDIT_BETTING'       =>	'Bet Editing',
    'INVALID_BIT_ID'     =>	'There seems to be a problem with Your Bet. NO ID Attached',
    'INAD_UPLOAD'        =>	'You Don\'t have enough Upload Credit! Make a Smaller Bet!',
    'ALREADY_BET'        =>	'You have already placed a Bet on this Category!',
    'EXEED_BET_POOL'     =>	'You Exceeded your Maximum Total Bet for this Pool.',

    'SUCCESSFULL_BET_UP' =>	'Successful Bet!<br> %1$s your Bet has been Confirmed by the System.<br> The Amount was Taken from your Upload Credit! When the Match has Ended, you will Receive a PM about the Result! Good Luck and Good Betting to everyone!<br><br><a href="betting.php">Click here to go back</a>.',

    'SUCCESSFULL_BET_BO' =>	'Successful Bet!<br> %1$s your Bet has been Confirmed by the System.<br> The Amount was Taken from your Bonus Credit! When the Match has Ended, you will Receive a PM about the Result! Good Luck and Good Betting to everyone!<br><br><a href="betting.php">Click here to go back</a>.',

    'NOT_AUTH_EDIT_CAT'  =>	'You DO NOT have Authorization to Edit Betting Categories!',
    'PAY_LABLE'          =>	'Payout %1$s',
    'CH_LABLE'           =>	'Choice %1$s',
    'BETS_OPEN'          =>	'Bets Open',
    'OPEN_BETS'          =>	'Open Bet\'s',
    'ED_TH_CAT'          =>	'Edit this Category!',
    'POOL'               =>	'Pool',
    'NONEWEST_BET'       =>	'No Bets right now , look back later..',
    'YOU_WONE_BET_PM'    =>	'Congratulations you have Won Bet %1$s for %2$s %3$s Credits',
    'PM_SUBJECT'         =>	'You are a Winner',
    'NO_AUTH_BETWIN'     =>	'You are NOT Authorized to View Bet Winners',
    'WINNER_LIST_T'      =>	'List of Winners/Bets',
    'WIN_BLOCK_TI'       =>	'List of ALL Winners %1$s on this Bet %2$s',
    'PAY_OUT'            =>	'Pay Out (Click Once)',
    'PUT_ACTIVE'         =>	'Put Active',
    'OTHER_BETS_CLOSED'  =>	'Other Bets (Closed)',
    'OPTION1'            =>	'Options 1',
    'OPTION2'            =>	'Options 2',
    'OPTION3'            =>	'Options 3',
    'OPTION4'            =>	'Options 4',
    'OPTION5'            =>	'Options 5',
    'OPTION6'            =>	'Options 6',
    'OPTION7'            =>	'Options 7',
    'OPTION8'            =>	'Options 8',
    'OPTION9'            =>	'Options 9',
    'OPTION10'           =>	'Options 10',
    'MULTPLY1'           =>	'Multiplier 1',
    'MULTPLY2'           =>	'Multiplier 2',
    'MULTPLY3'           =>	'Multiplier 3',
    'MULTPLY4'           =>	'Multiplier 4',
    'MULTPLY5'           =>	'Multiplier 5',
    'MULTPLY6'           =>	'Multiplier 6',
    'MULTPLY7'           =>	'Multiplier 7',
    'MULTPLY8'           =>	'Multiplier 8',
    'MULTPLY9'           =>	'Multiplier 9',
    'MULTPLY10'          =>	'Multiplier 10',
    'BET_EXPIRE'         =>	'Bet Expires',
    'BET_NAME'           =>	'Bet Name',
    'CREATE_NEW'         =>	'Create a New Bet',
    'ACTUAL_BETS'        =>	'Actual Bets',
    'USE_YOUR_UPL_BON'   =>	'Use your Upload Credit or your Bonus Points.',
    'MULTIPLIER'         =>	'Multiplier',
    'UPL_AMOUNT'         =>	'Upload Amount',
    'MAKE_YOUR_BET'      =>	'Make your Bet',
    'SPORT_BET'          =>	'Sports Bet',
    'RESULTS_FOR'        =>	'What\'s the Result?',
    'NO_AUTH_BET'        =>	'You are NOT Authorized to Place a Bet!',
    'EDIT'               => 'Edit',
    'DEL'                => 'Delete',
    'END_BET'            =>	'End Betting',
));

?>