<?php
/*
*-----------------------------phpMyBitTorrent V 2.0.5--------------------------*
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
*-----------------  Thursday, November 04, 2010 9:05 PM   ---------------------*
*/
/**
*
* @package phpMyBitTorrent
* @version $Id: profile_info.php 1 2010-11-04 00:22:48Z joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
        if(isset($userrow["birthday"]) OR !$userrow["birthday"]=='')$bday = explode("-", $userrow["birthday"]);
		else
		$bday = array('0','0','0');
		$now = getdate(time() - date('Z'));
$template->assign_vars(array(
		'LOCATION'		        => $countries,
		'U_ICQ'				    => (!empty($userrow["icq"])) ? $userrow["icq"] : '',
		'U_AIM'				    => (!empty($userrow["aim"])) ? $userrow["aim"] : '',
		'U_YIM'				    => (!empty($userrow["yahoo"])) ? $userrow["yahoo"] : '',
		'U_MSN'				    => (!empty($userrow["msn"])) ? $userrow["msn"] : '',
		'U_JABBER'			    => (!empty($userrow["jabber"])) ?$userrow["jabber"] : '',
		'U_SKYPE'			    => (!empty($userrow["skype"])) ? $userrow["skype"] : '',
		'U_BITH_D'              =>  $bday[0],
		'U_BITH_M'              =>  $bday[1],
		'U_BITH_Y'              =>  $bday[2],
));
?>