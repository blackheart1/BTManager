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
	'INTRO'								=>	'TorrentClinic&trade;',
	'INTRO_EXP'							=>	'TorrentClinic&trade; allows you to check .torrent file properties.<br />
If you are having trouble with a Torrent you can verify it has been generated correctly, or you can simply look inside it.<br />
Uploading a Torrent from your hard drive you will be able to verify all information that it contains and even check against sources!',
	'UPLOAD_TORRENT'					=>	'Upload a Torrent',
	'UPLOAD_LOCAL_FILE'					=>	'Upload A torrent from You Hard drive to Be Checked',
	'SHOW_STRUCTURE'					=>	'Show Advanced XML Structures (useful for debugging)',
	'FORCE_SCRAPE'						=>	'Force scrape on External Torrents',
	'ERROR_DECODING'					=>	'Decoding Error. File is probabily not a valid torrent file.',
	'DECODED_DATA'						=>	'Reading Torrent...',
	'NO_DEFAULT_ANNOUNCE'				=>	'Default tracker is not set. Invalid Torrent file.',
	'XML_STRUCTURE'						=>	'XML Structure',
	'CHECK_ANNOUNCE'					=>	'Checking against default tracker...',
	'CKECK_DIRECTORY'					=>	'Checking against Info dictionary...',
	'CKECK_DIRECTORY_ERR'				=>	'Info dictionary is not present. Invalid Torrent file.',
	'CHECK_FOUND'						=>	'Found',
	'CHECK_FILES'						=>	'Checking against file number...',
	'TORRENT_NOT_CONSISTANT'			=>	'Torrent is not consistent!!',
	'TORRENT_SINGLE_FILE'				=>	'Torrent contains a single file',
	'TORRENT_MULTY_FILE'				=>	'Torrent contains more files',
	'INVALID_FILE_SIZE_NUM'				=>	'Invalid file size. Must be numeric',
	'INVALID_FILE_PATH'					=>	'Invalid file path.',
	'FILES_SIZE'						=>	'Total size',
	'CHECK_PEACES'						=>	'Checking against pieces...',
	'CHECK_PEACES_LENGTH'				=>	'Checking against Piece Length...',
	'PEACES_DATA_GOOD'					=>	'Data is valid!',
	'PEACES_DATA_FAIL'					=>	'Data is invalid!',
	'DHT_SUPORT_CHECK'					=>	'Checking against DHT Support in Azureus...',
	'TORRENT_IS_VALID'					=>	'This Torrent is valid and has passed basic tests.',
	'TORRENT_ADVANCE_CHECK'				=>	'Going through advanced tests...',
	'CHECK_SUPPORTED'					=>	'Supported',
	'CHECK_NOT_SUPPORTED'				=>	'Not Supported',
	'MULTY_TRACKER_CHECK'				=>	'Checking against Multiple Trackers...',
	'TRACKER_SCRAPE'					=>	'Querying Tracker...',
	'TORRENT_NOT_REGED_WITH'			=>	'It looks like this Torrent is not registered with the External Tracker',
	
));

?>