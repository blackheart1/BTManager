<?php
/*
*-----------------------------phpMyBitTorrent V 3.0.0--------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
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
*------              ©2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-----------------   Sunday, September 14, 2008 9:05 PM   ---------------------*
*/
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}
$lang = array_merge($lang, array(
	'BONUS_EXCHANGE'				=>	'Bonus Exchange',
	'BONUS_SYSTEM_CLOSED'			=>	"Bonus System is Closed",
	"BONUS_SYSTEM_CLOSED_EXP"		=>	"Sorry to Announce but at this time we are NOT using the Bonus System<br />If you feel you have reached this error by Mistake please contact on of the sites moderators so they may assist you",
	"BONUS_SYS_EXP"					=>	"Here you can Exchange your Seeder-Bonus (currently: ".$user->seedbonus.")<br>(If the button's Deactivated, you DO NOT have enough to Trade.)<br>",
	"OPTIONS_ABOUT"					=>	"What's this about?",
	'POINTS'						=>	'Points',
	"TRADE"							=>	"Trade",
	'DISABLED'						=>	'Disabled!',
	"EXCHANGE"						=>	"Exchange!",
	'HOW_TO_GET'					=>	'How do I get Points?',
	'POINTS_EACH_TOR'				=>	' (For each torrent) ',
	'POINTS_TOTAL'					=>	' (total) ',
	'POINTS_OPTION_VAR'				=>	array(
										'A'		=>	'You receive %1$s %2$s Points for every 10 minutes the System Registers you as being a Seeder.',
										'B'		=>	'You will Receive %1$s Points for Uploading a new torrent.',
										'C'		=>	'You will Receive %1$s Points for Leaving a Comment on a torrent (that includes a quick thanks).',
										'D'		=>	'You will Receive %1$s Points for filling a Requested torrent<br />(Note any comment deleted By you or staff will result in loss of those points so no flooding)',
										'E'		=>	'You will Receive %1$s Points for Making a Offer to upload a torrent.',
										),
	'NOT_ENOUPH_POINTS'				=>	'Not enough Points to Trade...',
	'NO_VALID_ACTION'				=>	'No Nalid Type',
	'POINT_TRADE_MOD_COM'			=>	array(
										'TRAFIC'	=>	'- User has Traded %1$s Points for Traffic.\n %2$s\n',
										'INVITE'	=>	' - User has traded %1$s Points for Invites.\n ',
										),
	'EXCHANGE_SUC'					=>	array(
										'TRAFIC'	=>	'You have Traded %1$s Points for Traffic',
										'INVITE'	=>	'You have Traded %1$s Points for %2$s Invites',
										),
	));
?>