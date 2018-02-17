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
* @version $Id: english.php 1 2010-11-04 00:22:48Z joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
define("attach_lang_set",true);
define("GENERAL_UPLOAD_ERROR","Could not upload attachment to %s.");
define("IMAGE_FILETYPE_INVALID",'Image file type %d for mimetype %s not supported.');
define("IMAGE_FILETYPE_MISMATCH",'Image file type mismatch: expected extension %1$s but extension %2$s given.');
define("ATTACHED_IMAGE_NOT_IMAGE",'The image file you tried to attach is invalid.');
define("UNABLE_GET_IMAGE_SIZE",'It was not possible to determine the dimensions of the image.');
define("MB","MB");
define("KB","KB");
define("BYTES","Bytes");
define("WRONG_FILESIZE",'The file is too big, maximum allowed size is %1d %2s.');
define("WRONG_SIZE",'The image must be at least %1$d pixels wide, %2$d pixels high and at most %3$d pixels wide and %4$d pixels high. The submitted image is %5$d pixels wide and %6$d pixels high.');
define("EMPTY_FILEUPLOAD",'The uploaded file is empty.');
define("PHP_SIZE_NA",'The attachment’s file size is too large.<br />Could not determine the maximum size defined by PHP in php.ini.');
define("PHP_SIZE_OVERRUN",'The attachment’s file size is too large, the maximum upload size is %d MB.<br />Please note this is set in php.ini and cannot be overridden.');
define("NOT_UPLOADED",'File could not be uploaded.');
define("URL_INVALID",'The URL you specified is invalid.');
define("URL_NOT_FOUND","The file specified could not be found.");
define("EMPTY_REMOTE_DATA","File could not be uploaded, please try uploading the file manually.");
define("PARTIAL_UPLOAD","The uploaded file was only partially uploaded.");
define("DISALLOWED_EXTENSION",'The extension %s is not allowed.');
define("_bt_fm_del_attach","Delete attachment");
define("_bt_fm_del_attach_CONFIRM","Are you sure you want to delete this attachment?");
define("RETURN_UCP",'%sReturn to the User Control Panel%s');
define("ATTACHMENTS_DELETED",'Attachments successfully deleted.');
define("ATTACHMENT_DELETED",'Attachment successfully deleted.');
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}
$lang = array_merge($lang, array(
	'_FILENAME'	=> 'File Name',
	'_FILE_COMMENT'	=> 'File Comment',
));
?>