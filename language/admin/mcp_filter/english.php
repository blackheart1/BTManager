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
* @version $Id: 3.0.0 mcp_filiter/english.php  2010-11-04 00:22:48 joeroberts $
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
	'INTRO'								=>	'Keyword Filter',
	'INTRO_EXP'							=>	'With the Keyword Filter, you can stop users from uploading Torrents that may violate tracker rules or the law.<br>
This checks the names of the files within a torrent. Be careful to not insert any common words.',
	'KEYWORD'							=>	'KeyWord',
	'ADD_EDIT_KEYW'						=>	'Add/Edit keyword',
	'REASON'							=>	'Reason',
	'KEYWORD_ADDED'						=>	'Your Mew Keyword Has Been Successfuly added',
	'KEYWORD_UPDATED'					=>	'Your Keyword Has Been Successfuly updated',
	'KEYWORD_REMOVED'					=>	'Your Keyword Has Been Successfuly Removed',
	'NOSET_KEY_WORDS'					=>	'No filter keywords',
	'MISSING_KYEWORD'					=>	'Missing keyword',
	'MISSING_REASON'					=>	'Missing reason',
	'BAD_KEY_WORD'						=>	'Keyword must be 5 to 50 alphanumeric chars',
	'BAD_REASON'						=>	'Reason must be maximum 255 chars long',
	));

?>