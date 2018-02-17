<?php
/**
*
* bitbucket [English]
*
* @package language
* @version $Id$
* @copyright (c) 2005 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}
$lang = array_merge($lang, array(
		'BITBUCKET_MANAGER'									=>	'Image Manager',
		'BTMNGR_EXP'										=>	'Select the File You wish to add to your torrent and BitBucket.<br />You will not need to upload this Image in the future.<br />Valid file extensions: %1$s.',
		'BITBUCKET_GALERY'									=>	'Image Gallery',
		'BTGALLERY_EXP'										=>	'Here are all the Images You have In your Gallery<br />You can add a Images By clicking on the Name of the Image Or View the full Image by Clicking the Thumb.<br>You can also use it else where with [img]%1$s[/img]',
		'BITBUCKET_CLOSED'									=>	'Bit-Bucket is Closed',
		'BITBUCKET_CLOSED_EXP'								=>	'We are NOT allowing Bit-Bucket Uploads At this time.',
		'ERROR_NOT_U_AUTH'									=>	'Your Group is not Autherized to Use Bit-bucket at this time',
		'BIT_FILE_TO_BIG'									=>	'File To Big',
		'BIT_FILE_TO_BIG_EXP'								=>	'The size of the file %1$s Is larger then allowed by this system %2$s',
		'IMAGE_STATS'										=>	'You are currently using %1$s to store %2$s uploaded images.',
		'STATS_BLOCK'										=>	'Image Statistics',
		'SELECT_ATTACH_ERROR'								=>	'Please select a file to attach.',
		'UPLOADING_WAIT'									=>	'Uploading File(s) - Please Wait',
		'BITBUCKET_FULL'									=>	'BitBucket is Full',
		'BITBUCKET_FULL_EXP'								=>	'Your BitBucket is Full!<br />Please Delete some of your Images and try again.',
		'SERVER_ERROR'										=>	'Server Error',
		'SERVER_ERROR_EXP'									=>	'Server Configuration Error. Sorry for the Inconvenience.',
		'INVALID_FILE'										=>	'Invalid File',
		'INVALID_FILE_EXP'									=>	'You may only upload file types with the extensions bmp gif jpe jpeg jpg png',
		'FILE_NAME'											=>	'File Name: %1$s',
		'FILE_TYPE'											=>	'File Type: %1$s',
		'FILE_SIZE'											=>	'File Size: %1$s',
));
?>