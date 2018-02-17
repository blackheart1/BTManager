<?php
/**
*
* avatar [English]
*
* @package language
* @version $Id$
* @copyright (c) 2010 phpMyBitTorrent Group
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
'AVATAR_SETTINGS'					=> 'Avatar settings',
'_admpAVATAR_SETTINGS'					=> 'Avatar settings',
'AVATAR_SETTINGSexplain'					=> 'Avatars are generally small, unique images a user can associate with themselves. Depending on the style they are usually displayed below the username when viewing topics. Here you can determine how users can define their avatars. Please note that in order to upload avatars you need to have created the directory you name below and ensure it can be written to by the web server. Please also note that file size limits are only imposed on uploaded avatars, they do not apply to remotely linked images.',
'_admpALLOW_AVATARS'					=> 'Enable avatars',
'_admpALLOW_AVATARSexplain'					=> 'Allow general usage of avatars;<br>If you disable avatars in general or avatars of a certain mode, the disabled avatars will no longer be shown on the board, but users will still be able to download their own avatars in the User Control Panel.',
'_admpALLOW_LOCAL'					=> 'Enable gallery avatars',
'_admpALLOW_LOCALexplain'			=> '&nbsp;',
'_admpALLOW_UPLOADexplain'			=> '&nbsp;',
'_admpALLOW_REMOTE'					=> 'Enable remote avatars',
'_admpALLOW_REMOTEexplain'					=> 'Avatars linked to from another website.',
'_admpALLOW_UPLOAD'					=> 'Enable avatar uploading',
'_admpALLOW_REMOTE_UPLOAD'					=> 'Enable remote avatar uploading',
'_admpALLOW_REMOTE_UPLOADexplain'					=> 'Allow uploading of avatars from another website.',
'_admpMAX_FILESIZE'					=> 'Maximum avatar file size',
'_admpMAX_FILESIZEexplain'					=> 'For uploaded avatar files.',
'_admpMIN_AVATAR_SIZE'				=> 'Minimum avatar dimensions',
'_admpMIN_AVATAR_SIZEexplain'		=> 'Width x Height in pixels.',
'_admpMAX_AVATAR_SIZE'				=> 'Maximum avatar dimensions',
'_admpMAX_AVATAR_SIZEexplain'		=> 'Width x Height in pixels.',
'_admpAVATAR_STORAGE_PATH'					=> 'Avatar storage path',
'_admpAVATAR_STORAGE_PATHexplain'					=> 'Path under your Tracker root directory, e.g. <samp>avatar/users</samp>.',
'_admpAVATAR_GALLERY_PATH'					=> 'Avatar gallery path',
'_admpAVATAR_GALLERY_PATHexplain'					=> 'Path under your Tracker root directory for pre-loaded images, e.g. <samp>avatar</samp>.',
'SETTINGS_NOT_SAVED'					=> 'Avatar settings not saved',
'DIR_NO_WRITE'					=> 'Directory " %s " is not writable',
'NO_SUCH_DIR'					=> 'No such Directory " %s "',
'YES_NO_TF'					=> array("true"=>'Yes', "false"=>'No'),
'YES_NO'					=> array("yes"=>'Yes', "no"=>'No'),
'ERR_ARRAY_MESS'			=> '<li><p>%s</p></li>',
));
?>