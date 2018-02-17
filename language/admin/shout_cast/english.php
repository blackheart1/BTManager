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
*--------------------   Sunday, May 17, 2010 1:05 AM   ------------------------*
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 shout_cast/english.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}
$lang = array_merge($lang, array(
'TITLE'								=> 'Shout Cast',
'TITLE_EXPLAIN'						=> 'ShoutCast Radio Configuration and settings<br />Here you can set up your shoutcast Radio to display on your site',
'HEADER_SETTINGS'					=> 'ShoutCast Settings',
"_admpallow"						=> "Allow ShoutCast",
"_admpallowexplain"					=> "With this You can activate or deactivate your shoutcast radio.",
"_admpip"							=>	'ShoutCast IP',
"_admpipexplain"					=>	'Enter the IP only for your ShoutCast Radio',
"_admpport"							=>	'ShoutCast Port',
"_admpportexplain"					=>	'Enter The port for your ShoutCast Radio',
"_admpadmin_name"					=>	'ShoutCast Admin Name',
"_admpadmin_nameexplain"			=>	'This is your ShoutCast administrators user name By default this well be Admin',
"_admpadmin_pass"					=>	'ShoutCast Password',
"_admpadmin_passexplain"			=>	'Inter your Admin Pass word for your ShoutCast Radio This is needed to Retreave the information from Your ShoutCast',
"_admphost_dj"						=>	'Current DJ',
"_admphost_djexplain"				=>	'Inter the Name of the Person Disk Jockying on the ShoutCast.',
));
?>