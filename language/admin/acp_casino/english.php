<?php
/*
*----------------------------phpMyBitTorrent V 3.0.0---------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
*-------------------   And Joe Robertson (aka joeroberts)   -------------------*
*-------------               http://www.p2pmania.it               -------------*
*------------ Based on the Bit Torrent Protocol made by Bram Cohen ------------*
*-------------              http://www.bittorrent.com             -------------*
*------------------------------------------------------------------------------*
*------------------------------------------------------------------------------*
*--   This program is free software; you can redistribute it and/or modify   --*
*--   it under the terms of the GNU General Public License as published by   --*
*--   the Free Software Foundation; either version 2 of the License, or      --*
*--   (at your option) any later version.                                    --*
*--                                                                          --*
*--   This program is distributed in the hope that it will be useful,        --*
*--   but WITHOUT ANY WARRANTY; without even the implied warranty of         --*
*--   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the          --*
*--   GNU General Public License for more details.                           --*
*--                                                                          --*
*--   You should have received a copy of the GNU General Public License      --*
*--   along with this program; if not, write to the Free Software            --*
*-- Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA --*
*--                                                                          --*
*------------------------------------------------------------------------------*
*------              ©2010 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*--------------------   Sunday, May 17, 2009 1:05 AM   ------------------------*
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 functions.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
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
		'MAIN_TEXT'							=> 'Casino Configuation Settings',
		'MAIN_INTRO_EXP'					=> 'Set Up your Casino Basic configuration so that you can limit users that may access make bets.',
		'CASINO_CONFIG'						=> 'Casino Settings',
		'_admpenable'						=> "Enable The Casino",
		'_admpenableexplain'				=> "Turning On your cassino Well enable your user to Play Betting games that they can use some of there Uploaded credit on.<br />This Can go good for some users and very bad for others But it is all in fun.",
		'_admpratio_mini'					=> "Minimun Ratio",
		'_admpratio_miniexplain'			=> "Set the Minimun Ratio That a user Must have in order to Access the Casino.<br />This setting is in percentage 2.00, 1.50, 1.00, .95, .90",
		'_admpmaxtrys'						=> "Casino Max Trys",
		'_admpmaxtrysexplain'				=> "How many times users can play? After that they have to wait 5 hours in order to play again.",
		'_admpwin_amount_on_number'			=> "Win Amount in Bet on Number Game",
		'_admpwin_amount_on_numberexplain'	=> "How much do the player win in the bet on Number game eg.<br />bet 300, <br />win amount = 3<br />300*3<br />900 win",
		'_admpwin_amount'					=> "Win Amount in Bet on a Color",
		'_admpwin_amountexplain'			=> "How much do the player win in the bet on Color game eg.<br />bet 300, <br />win amount = 3<br />300*3<br />900 win",
		'_admpmaxusrbet'					=> "Amount of bets to allow per person",
		'_admpmaxusrbetexplain'				=> "How Many open Bets is a user allowed to Have for P2P Games",
		'_admpmaxtotbet'					=> "Amount of total open bets allowed",
		'_admpmaxtotbetexplain'				=> "How many open bets are allowed total on P2P Games",
		'_admpcheat_value'					=> "Casino Cheat Value",
		'_admpcheat_valueexplain'			=> "higher value -> less winner",
		'_admpcheat_value_max'				=> "Casino Cheat Value Max",
		'_admpcheat_value_maxexplain'		=> "The cheat value = cheat value max -->> I hope you know what i mean. ps: must be higher then cheat value.",
		'_admpcheat_breakpoint'				=> "Casino Cheat Breackpoint",
		'_admpcheat_breakpointexplain'		=> "Very important value -> if (win MB > max download global/cheat breakpoint)",
		'_admpcheat_ratio_user'				=> "Casino Cheat Ratio User",
		'_admpcheat_ratio_userexplain'		=> "If casino ratio user > cheat ratio user -> cheat value = random(cheat value,cheat value max)",
		'_admpcheat_ratio_global'			=> "Casino Cheat Ratio Global",
		'_admpcheat_ratio_globalexplain'	=> "(same as user just global)",
		'_admpclass_allowed'				=> "Access Level",
		'_admpclass_allowedexplain'			=> "What Group is allow to Play in the Casino",
		'YES_NO_OPTION'						=> array('1'=> 'Yes', '0' => 'No'),
		'ERR_RATIO'		=> 'The Number you interd for Minimun Ratio Is Not numeric please go Back and inter a numeric number',
		'ERR_MATRY'		=> 'The Number you interd for Casino Max Trys Is Not numeric please go Back and inter a numeric number',
		'ERR_WIN_NUMBER'		=> 'The Number you interd for Win Amount in Bet on Number Game Is Not numeric please go Back and inter a numeric number',
		'ERR_WIN_COLOR'		=> 'The Number you interd for Win Amount in Bet on a Color Is Not numeric please go Back and inter a numeric number',
		'ERR_M_USER_BETS'		=> 'The Number you interd for Amount of bets to allow per person Is Not numeric please go Back and inter a numeric number',
		'ERR_M_TOT_BETS'		=> 'The Number you interd for Amount of total open bets allowed Is Not numeric please go Back and inter a numeric number',
		'ERR_CHEAT_VAL'		=> 'The Number you interd for Casino Cheat Value Is Not numeric please go Back and inter a numeric number',
		'ERR_CHEAT_VAL_MAX'		=> 'The Number you interd for Casino Cheat Value Max Is Not numeric please go Back and inter a numeric number',
		'ERR_CHEAT_BREAK'		=> 'The Number you interd for Casino Cheat Breackpoint Is Not numeric please go Back and inter a numeric number',
		'ERR_CHEAT_RATIO'		=> 'The Number you interd for Casino Cheat Ratio User Is Not numeric please go Back and inter a numeric number',
		'ERR_CHEAT_RATIO_GLOBAL'		=> 'The Number you interd for Casino Cheat Ratio Global Is Not numeric please go Back and inter a numeric number',
		'ERR_BAD_LEVEL'		=> 'One or more of the Groups you intered Is not Valid please go back and try again',
		'CONFIG_NOT_SET'		=> 'A error accurd while Processing the new Settings Please read Bellow!',
));

?>