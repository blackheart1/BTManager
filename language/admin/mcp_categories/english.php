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
	'INTRO'								=>	'Categories',
	'INTRO_EXP'							=>	'In this section you can manage Torrent categories that users may upload. Installation provides this tracker with some common categories for Torrents.<br />You can add your own ones or edit others. Be careful that every category must be represented by a significant image for best experience.<br />Images are in the <i>cat_pics</i> directory of the tracker\'s root directory.<br />If the theme has a <i>pics/cat_pics</i> directory within it, images that are in that directory will be displayed instead of global images.',
	'INTRO_EDIT'						=>	'Add New Category Icon',
	'INTRO_EXP_EDIT'					=>	'In this section you can upload new images to use for you category Icons. At this time you are allowed to use png, gif, jpg , and jpeg. Remember that you have to make the /cat_pics folder writable first. Icons must not exceed 48px X 48px and must not be larger than 17kb. Once you have uploaded the new icon, you can choose it from the drop-down list above.',
	'NO_CATEGORIES'						=>	'No categories to administer',
	'ADD_EDIT_CAT'						=>	'Add/Edit category',
	'POSITION'							=>	'Position',
	'PARENT'							=>	'Parent',
	'AT_END'							=>	'At the end',
	'AT_BEGIN'							=>	'At the beginning',
	'AFTER'								=>	'After %1$s',
	'SETASPARENT'						=>	'Set as Parent',
	'UPLOAD_CAT'						=>	'Upload Category Icon',
	'CAT_UPLOAD_TOBIG'					=>	'Category Icon Is To Big',
	'INVALID_ICON'						=>	'Invalid Category Icon',
	'EMPTY_FILE'						=>	'The icon you are uploading is Empty',
	'FATAL_ERROR_UPLOAD'				=>	'Fatal error in uploaded Category Icon.',
	'UPLOAD_SUCCESSFUL'					=>	'Upload was Successful the New Icon has been added and you may now use it.',
	'UPLOAD_FAILED'						=>	'The Upload has Failed please check Permitions of <i>cat_pics</i> directory and Make sure that you do have permitions set Properly',
));

?>