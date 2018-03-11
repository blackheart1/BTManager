<?php

/**
**********************
** BTManager v3.0.1 **
**********************
** http://www.btmanager.org/
** https://github.com/blackheart1/BTManager
** http://demo.btmanager.org/index.php
** Licence Info: GPL
** Copyright (C) 2018
** Formerly Known As phpMyBitTorrent
** Created By Antonio Anzivino (aka DJ Echelon)
** And Joe Robertson (aka joeroberts)
** Project Leaders: Black_heart, Thor.
** File faq_manager.php 2018-03-02 07:39:00 Thor
**
** CHANGES
**
** 2018-03-02 - Added New Masthead
** 2018-03-02 - Added New !defined('IN_PMBT')
** 2018-03-02 - Fixed Spelling
**/

if (!defined('IN_PMBT'))
{
    include_once './../../security.php';
    die ("You Can't Access This File Directly");
}
define("attach_lang_set",true);
define("GENERAL_UPLOAD_ERROR","Could NOT Upload Attachment to %s.");
define("IMAGE_FILETYPE_INVALID",'Image File Type %d for Mimetype %s NOT Supported.');
define("IMAGE_FILETYPE_MISMATCH",'Image File Type Mismatch: Expected Extension %1$s but Extension %2$s given.');
define("ATTACHED_IMAGE_NOT_IMAGE",'The Image File you tried to Attach is Invalid.');
define("UNABLE_GET_IMAGE_SIZE",'It was NOT possible to determine the Dimensions of the Image.');
define("MB","MB");
define("KB","KB");
define("BYTES","Bytes");
define("WRONG_FILESIZE",'The File is too Big, Maximum Allowed Size is %1d %2s.');
define("WRONG_SIZE",'The Image must be at least %1$d Pixels Wide, %2$d Pixels High and at most %3$d Pixels Wide and %4$d Pixels High. The Submitted Image is %5$d Pixels Wide and %6$d Pixels High.');

define("EMPTY_FILEUPLOAD",'The Uploaded File is Empty.');
define("PHP_SIZE_NA",'The Attachment\'s File Size is too Large.<br />Could NOT determine the Maximum Size Defined by PHP in php.ini.');

define("PHP_SIZE_OVERRUN",'The Attachment\'s File Size is too Large, the Maximum Upload Size is %d MB.<br />Please Note this is Set in php.ini and can NOT be Overridden.');

define("NOT_UPLOADED",'File Could NOT be Uploaded.');
define("URL_INVALID",'The URL you Specified is Invalid.');
define("URL_NOT_FOUND","The File Specified could NOT be Found.");
define("EMPTY_REMOTE_DATA","File could NOT be Uploaded.  Please Try Uploading the file Manually!");
define("PARTIAL_UPLOAD","The Uploaded File was Only Partially Uploaded.");
define("DISALLOWED_EXTENSION",'The Extension %s is NOT Allowed.');
define("_bt_fm_del_attach","Delete Attachment");
define("_bt_fm_del_attach_CONFIRM","Are you sure you want to Delete this Attachment?");
define("RETURN_UCP",'%sReturn to the User Control Panel%s');
define("ATTACHMENTS_DELETED",'Attachments Successfully Deleted.');
define("ATTACHMENT_DELETED",'Attachment Successfully Deleted.');

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
    '_FILENAME'     => 'File Name',
    '_FILE_COMMENT' => 'File Comment',
));

?>