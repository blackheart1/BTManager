<?php
/*
*------------------------------phpMyBitTorrent V 3.0.0-------------------------* 
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
*--------            ©2013 BT.Manager Development Team                 --------*
*-----------               http://btmagaer.com                      -----------*
*------------------------------------------------------------------------------*
*--------------------   Saturday, April 13, 2013 9:41 PM  ---------------------*
*
*
* whos_online [English]
*
* @package language
* @version $Id$
* @copyright (c) 2013 BT.Manager Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'REQ_TO_LESTIN'				=>	'You will need Windows Media Player 10+ or Real Player to listen to the radio stream!',
	'POWERED_BY'				=>	'Radio Powered by Shoutcast &amp; Winamp.',
	'LAST_TRACKS'				=>	'Last Tracks Played....',
	'MEMBERS_LESTINING'			=>	'Members Listening',
	'CURNETLY_PLAYING'			=>	'Currently Playing',
	'CLICK_HERE_TO_LISTEN'		=>	'Click here to tune in and listen now.',
	'RADIO_STATUS'				=>	'Status',
	'RADIO_DJ'					=>	'Radio DJ',
	'CUR_BITRATE'				=>	'Curent Bitrate',
));
?>