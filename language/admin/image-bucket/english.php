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
* @version $Id: 3.0.0 image-buket/english.php  2010-11-04 00:22:48 joeroberts $
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
'TITLE'								=> 'BitBucket',
'TITLE_EXPLAIN'						=> '',
'HEADER_SETTINGS'					=> 'BitBucket Settings',
"_admpallow"						=> "Allow BitBucket",
"_admpallowexplain"					=> "With this You can allow or disallow access<br />To the BitBucket.",
"_admplevel"						=> "BitBucket Access Level",
"_admplevelexplain"					=> "Select the user Level wich can use the BitBucket!",
"_admpmax_folder_size"				=> "Max Size Of User Folder",
"_admpmax_folder_sizeexplain"		=> "Set the max size of folder the user is allowed to have in Bytes!",
"_admpmax_file_size"				=> "Max Allowed Size of Image",
"_admpmax_file_sizeexplain"			=> "Set the max size of a image a user can upload in Bytes!",
'USER_IMAGES'						=> 'User Images',
'FILE_NAME'							=> 'File name',
'FILE_SIZE'							=> 'File size',
'FOLDER_SIZE'						=> 'Folder size',
'NUM_FILES'							=> 'Total Files',
'DELETE_FILE'						=> 'Delete File',
));

?>