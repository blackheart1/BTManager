<?php
/**
*
* edit [English]
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
	'TITTLE_EDIT'					=>	'Edit post',
	'BLOCK_TITLE'					=>	'Editing Comment for %1$s',
	'T_TITTLE_EDIT'					=>	'Edit Torrent %1$s',
	'T_BLOCK_TITLE'					=>	'Editing Torrent %1$s',
	'DESCRIPTION'					=>	'Message body',
	'DESCRIPTION_EXPLAIN'			=>	'Enter your message here, it may contain no more than 60000 characters. ',
	'DESCRIPTION_T_EXPLAIN'			=>	'Please Give as much information that you can about this file.',
	'ERROR_COMENT_ID'				=>	'Invalid Comment id',
	'ERROR_COMENT_TOR'				=>	'Invalid Torrent id',
	'ERROR_NOT_AUTH_EDCOM'			=>	'You are Not Autherized to Edit your Comments',
	'ERROR_NOT_AUTH_MDCOM'			=>	'You are not Autherized to Edit Others comments',
	'ERROR_COMMENT_BLANK'			=>	'Your Comment can not be blank If you wich to remove your Comment please delete it',
	'ERROR_NOT_U_AUTH_EDIT'			=>	'Your group is not autherized to edit there torrents',
	'ERROR_NOT_M_AUTH_EDIT'			=>	'Your group is not autherized to edit torrents',
	'ERROR_NOT_U_AUTH_DELETE'		=>	'Your group is not autherized to delete there torrents',
	'ERROR_NOT_M_AUTH_DELETE'		=>	'Your group is not autherized to delete torrents',
	'ERROR_NOT_M_AUTHE_BAN'			=>	'Your group is not autherized to BANN torrents',
	'SUCCES_EDIT_TAKEN'				=>	'Your edit was Succesfuly added',
	'SUCCES_ADMIN_DELETE'			=>	'Torrents Have been succes Fully removed!',
	'UPLOAD_NFO'					=>	'Upload NFO File',
	'EDIT_NAME'						=>	'Torrent Name',
	'EDIT_NAME_EXP'					=>	'Will be Generated from the File Name if left Blank. <strong>Try to give it a Descriptive Name</strong>',
	'EDIT_IMDB'						=>	'IMDB Link',
	'EDIT_IMDB_EXP'					=>	'Add IMDB to details page By providing a IMDB link or IMDB NUMBER',
	'EDIT_EVIDENT'					=>	'Sticky',
	'EDIT_EVIDENT_EXP'				=>	'Mark Torrent as Sticky and keep it on the top of the list.',
	'EDIT_PRIVACY'					=>	'Display Name',
	'EDIT_PRIVACY_EXP'				=>	'\'SHOW USER\' <br />Allows other Users to see your User Name, <br />\'PRIVACY MODE\' <br />Hides it, retaining Edit/Delete Permissions, <br />\'STEALTH MODE\'<br /> (if available) Completely Hides the Owner to the System, and Doesn\'t allow any Edit/Deletion by the User.',
	'ERROR_EDIT_NOT_SAVED'			=>	'An error has accurd and the Edit was not saved',
	'SHOW_USER'						=>	'SHOW USER',
	'PRIVACY_MODE'					=>	'PRIVACY MODE',
	'STEALTH_MODE'					=>	'STEALTH MODE',
	'PASSWORD_EXP'					=>	'You may choose a Password to Protect your Torrent from Unauthorized View. If a Password is Set, the Torrent will NOT be Visible to Anyone Except Select Groups SET By Administrator\'s in the Torrent List and Torrent Search. You will have to provide a Direct Link to the people that you want to Access the Torrent. Only Internal Torrents can be Password Protected.',
	'EDIT_POSTER'					=>	'Poster',
	'EDIT_POSTER_EXP'				=>	'Direct link for a poster,<br />(Example http://img52.imageshack.us/img52/6272/lookatme.png)',
	'EDIT_SCREENA'					=>	'Screenshot 1',
	'EDIT_SCREENA_EXP'				=>	'Direct link for a Screenshot 1',
	'EDIT_SCREENB'					=>	'Screenshot 2',
	'EDIT_SCREENB_EXP'				=>	'Direct link for a Screenshot 2',
	'EDIT_SCREENC'					=>	'Screenshot 3',
	'EDIT_SCREENC_EXP'				=>	'Direct link for a Screenshot 3',
	'EDIT_SCREEND'					=>	'Screenshot 3',
	'EDIT_SCREEND_EXP'				=>	'Direct link for a Screenshot 4',
	'ERROR_EDIT_NOT_SAVED'			=>	'An error has accurd and the Edit was not saved',
	'ERROR_POSTER_A'				=>	'The URL you specified For poster is invalid.',
	'ERROR_POSTER_B'				=>	'The URL you specified for poster is not a (gif|jpg|jpeg|png) Image.',
	'ERROR_IMAGEA_A'				=>	'The URL you specified For Screen Shot 1 is invalid.',
	'ERROR_IMAGEA_B'				=>	'The URL you specified for Screen Shot 1 is not a (gif|jpg|jpeg|png) Image.',
	'ERROR_IMAGEB_A'				=>	'The URL you specified For Screen Shot 2 is invalid.',
	'ERROR_IMAGEB_B'				=>	'The URL you specified for Screen Shot 2 is not a (gif|jpg|jpeg|png) Image.',
	'ERROR_IMAGEC_A'				=>	'The URL you specified For Screen Shot 3 is invalid.',
	'ERROR_IMAGEC_B'				=>	'The URL you specified for Screen Shot 3 is not a (gif|jpg|jpeg|png) Image.',
	'ERROR_IMAGED_A'				=>	'The URL you specified For Screen Shot 4 is invalid.',
	'ERROR_IMAGED_B'				=>	'The URL you specified for Screen Shot 4 is not a (gif|jpg|jpeg|png) Image.',
	'ERROR_EDIT_NOT_SAVED'			=>	'An error has accurd and the Edit was not saved',
	'ERROR_NO_CAT_SELECTED'			=>	'No Category Selected. Please go back to the Edit Form.',
	'ERROR_INVALID_NFO_NAME'		=>	'Invalid NFO File name',
	'ERROR_NOT_NFO'					=>	'This is NOT a NFO File (.nfo)',
	'ERROR_EMPTY_NFO'				=>	'The NFO file is Empty',
	'ERROR_UPLOADING_NFO'			=>	'Fatal Error in Uploaded NFO File.',
	'ERROR_INVALID_CAT'				=>	'Illegal Category!',
	'ERROR_DECRP_IS_BLANK'			=>	'Description Field is Empty. Please go back and enter a Description.',
	'EDITED'						=>	'Edit was Completed',
	'EDITED_EXP'					=>	'Edit was Completed Successfuly You changes have been applied',
	'CONFERM_BAN'					=>	'Confirm Torrent Bann',
	'CONFERM_DELETE'				=>	'Confirm Torrent Deletion',
	'TORRENT_BANNED'				=>	'The torrent was Successfuly Banned.<br /><a href="index.php">Return to Index </a>',
	'TORRENT_BANNED_CANCEL'			=>	'The torrent Ban was Successfuly Canceled.<br /><a href="index.php">Return to Index </a>',
	'TORRENT_DELETE'				=>	'The torrent was Successfuly Deleted.<br /><a href="index.php">Return to Index </a>',
	'TORRENT_DELETE_CANCEL'			=>	'The torrent Delete was Successfuly Canceled.<br /><a href="index.php">Return to Index </a>',
));
?>