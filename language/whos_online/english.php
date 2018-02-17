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
*--------            �2013 BT.Manager Development Team                 --------*
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
		'VIEWING_THREAD'					=>	'Viewing Thread <br /><strong>%s</strong>',
		'VIEWING_FORUM'						=>	'Viewing Forum <br /><strong>%s</strong>',
		'VIEWING_ERROR'						=>	'Viewing error Message',
		'VIEWING_FORUM'						=>	'Viewing Forum Index',
		'CREATING_TOPIC'					=>	'Creating New Topic in<br /><strong>%s</strong>',
		'REPLYING_TO'						=>	'Replying To<br /><strong>%s</strong>',
		'EDITING_POST'						=>	'Modifying Post<br /><strong>%s</strong>',
		'WHOS_ON_LINE'                      => 'Who is On-line?',
		'LEGEND'                            => 'Legend:',
		'USERNAME'                          =>  'Username',
		'MOST_CLIENT'                       => 'Most used client:',
		'TOTAL_LEECHERS'                    => 'Total leechers:',
		'TOTAL_SEEDERS'                     => 'Total seeders:',
		'TOTAL_SPEED'                       => 'Total transfer speed:',
		'TOTAL_PEERS'                       => 'Total Peers:',
		'TOTAL_SHARED'                      => 'Total shared data:',
		'TOTAL_TORRENTS'                    => 'Total Torrents:',
		'TOTAL_USERS'                       => 'Total Registered Users:',
		'TOTAL_REG_24'                      => 'Total Registered Users In Last 24Hours:',
		'TOTAL_REG_7D'                      => 'Total Registered Users In Last 7Days:',
		'ONLINE_24HRS'                      => 'Total Users Online In Last 24Hours:',
		'STAT1'                             => 'In total there is',
		'STAT2'                             => 'user online (based on users active over the past 5 minutes)',
		'MOST_EVER_ON'                      => 'Most users ever online was',
		
));
?>