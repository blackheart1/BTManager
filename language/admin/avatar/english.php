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
** File avatar/english.php 2018-03-29 09:20:00 Thor
**
** CHANGES
**
** 2018-02-18 - Added New Masthead
** 2018-02-18 - Added New !defined('IN_PMBT')
** 2018-02-18 - Fixed Spelling
** 2018-03-29 - Amended the Wording of some Sentences
** 2018-03-29 - Amended !defined('IN_PMBT') Corrected Path
** 2018-03-29 - Added Missing Language
**/

if (!defined('IN_PMBT'))
{
    include_once './../../../security.php';
    die ("Error 404 - Page Not Found");
}

if (empty($lang) || !is_array($lang))
{
    $lang = array();
}

$lang = array_merge($lang, array(
    'YES_NO_TF'              => array("true"=>'Yes', "false"=>'No'),
    'YES_NO'                 => array("yes"=>'Yes', "no"=>'No'),
    'ERR_ARRAY_MESS'         => '<li><p>%s</p></li>',

    'AVATAR_SETTINGS'        => 'Avatar Settings',

    'AVATAR_SETTINGSexplain' => 'Avatars are generally small, unique images a User can associate with themselves. Depending on the style, they are usually displayed below the Username when Viewing Topics.  Here you can determine how Users can Define their Avatars.  Please Note that in Order to Upload Avatars you need to have Created the Directory you named below and ensure it CAN be Written to by the Web Server.  Please Also Note that File Size Limits are Only Imposed on Uploaded Avatars, they DO NOT Apply to Remotely Linked Images.',

    'SETTINGS_NOT_SAVED'     => 'Avatar Settings NOT Saved',
    'DIR_NO_WRITE'           => 'Directory " %s " is NOT Writeable',
    'NO_SUCH_DIR'            => 'No Such Directory " %s "',
    '_SUBMIT'                => 'SUBMIT',
    '_RESET'                 => 'RESET',

    '_admpALLOW_AVATARS'              => 'Enable Avatars',

    '_admpALLOW_AVATARSexplain'       => 'Allow General Usage of Avatars:<br>If you Disable Avatars in General or Avatars of a Certain Mode, the Disabled Avatars will NO longer be shown on the Board, but Users will still be able to Download their Own Avatars in the User Control Panel.',

    '_admpALLOW_LOCAL'                => 'Enable Gallery Avatars',
    '_admpALLOW_LOCALexplain'         => 'Enable Users to Select a Pre-Loaded Image from the User Control Panel.',
    '_admpALLOW_UPLOADexplain'        => 'Enable Avatars to be Uploaded to the Site.',
    '_admpALLOW_REMOTE'               => 'Enable Remote Avatars',
    '_admpALLOW_REMOTEexplain'        => 'Avatars Linked to from another Website.',
    '_admpALLOW_UPLOAD'               => 'Enable Avatar Uploading',
    '_admpALLOW_REMOTE_UPLOAD'        => 'Enable Remote Avatar Uploading',
    '_admpALLOW_REMOTE_UPLOADexplain' => 'Allow Uploading of Avatars from another Website.',
    '_admpMAX_FILESIZE'               => 'Maximum Avatar File Size',
    '_admpMAX_FILESIZEexplain'        => 'For Uploaded Avatar Files.',
    '_admpMIN_AVATAR_SIZE'            => 'Minimum Avatar Dimensions',
    '_admpMIN_AVATAR_SIZEexplain'     => 'Width x Height in Pixels.',
    '_admpMAX_AVATAR_SIZE'            => 'Maximum Avatar Dimensions',
    '_admpMAX_AVATAR_SIZEexplain'     => 'Width x Height in Pixels.',
    '_admpAVATAR_STORAGE_PATH'        => 'Avatar Storage Path',
    '_admpAVATAR_STORAGE_PATHexplain' => 'Path under your Tracker Root Directory, e.g. <em>avatar/users</em>.',
    '_admpAVATAR_GALLERY_PATH'        => 'Avatar Gallery Path',
    '_admpAVATAR_GALLERY_PATHexplain' => 'Path under your Tracker Root Directory for Pre-Loaded Images, e.g. <em>avatar</em>.',
));

?>