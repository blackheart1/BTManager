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
** File image-bucket/english.php 2018-09-14 10:04:00 Thor
**
** CHANGES
**
** 2018-02-24 - Added New Masthead
** 2018-02-24 - Added New !defined('IN_PMBT')
** 2018-02-24 - Fixed Spelling
** 2018-03-29 - Amended the Wording of some Sentences
** 2018-03-29 - Amended !defined('IN_PMBT') Corrected Path
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
    'TITLE'                       => 'Image Bucket',
    'TITLE_EXPLAIN'               => 'Configure your Image Bucket Settings<br /><br />',
    'HEADER_SETTINGS'             => 'Image Bucket Settings',
    '_admpallow'                  => 'Enable/Disable Image Bucket',
    '_admpallowexplain'           => 'This will Turn the Image Bucket System On or Off.',
    '_admplevel'                  => 'Image Bucket Access Level',
    '_admplevelexplain'           => 'Select which User Level\'s can use Image Bucket!',
    '_admpmax_folder_size'        => 'Maximum Size of User Folder?',
    '_admpmax_folder_sizeexplain' => 'Set the Maximum Size of Folder the User is Allowed to have in Bytes!',
    '_admpmax_file_size'          => 'Maximum Allowed Size of Image?',
    '_admpmax_file_sizeexplain'   => 'Set the Maximum Size of an Image a User can Upload in Bytes!',
    'USER_IMAGES'                 => 'User Images',
    'FILE_NAME'                   => 'Filename',
    'FILE_SIZE'                   => 'File Size',
    'FOLDER_SIZE'                 => 'Folder Size',
    'NUM_FILES'                   => 'Total Files',
    'DELETE_FILE'                 => 'Delete File',
));

?>