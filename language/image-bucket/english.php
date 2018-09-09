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
** File image-bucket/english.php 2018-09-09 06:01:00 Thor
**
** CHANGES
**
** 2018-03-02 - Added New Masthead
** 2018-03-02 - Added New !defined('IN_PMBT')
** 2018-03-02 - Fixed Spelling
** 2018-04-18 - Amended the Wording of some Sentences
**/

if (!defined('IN_PMBT'))
{
    include_once './../../security.php';
    die ('Error 404 - Page Not Found');
}

if (empty($lang) || !is_array($lang))
{
    $lang = array();
}

$lang = array_merge($lang, array(
    'BITBUCKET_MANAGER'    => 'Image Manager',

    'BTMNGR_EXP'           => 'Select the File you wish to Add to your Torrent and Image Bucket.<br />You will NOT need to Upload this Image in the future.<br />Valid File Extensions: %1$s.',

    'BITBUCKET_GALERY'     => 'Image Gallery',

    'BTGALLERY_EXP'        => 'Here are ALL the Images you have in your Gallery<br />You can Add Images by Clicking on the Name of the Image or View the Full Image by Clicking the Thumb.<br />You can also use it elsewhere with [img]%1$s[/img]',

    'BITBUCKET_CLOSED'     => 'Image Bucket is Closed',
    'BITBUCKET_CLOSED_EXP' => 'We are NOT allowing Image Bucket Uploads at this time.',
    'ERROR_NOT_U_AUTH'     => 'Your Group is NOT Authorised to Use Image Bucket at this time',
    'BIT_FILE_TO_BIG'      => 'File Too Big',
    'BIT_FILE_TO_BIG_EXP'  => 'The Size of the File %1$s is Larger than Allowed by this System %2$s',
    'IMAGE_STATS'          => 'You are Currently using %1$s to Store %2$s Uploaded Images.',
    'STATS_BLOCK'          => 'Image Statistics',
    'SELECT_ATTACH_ERROR'  => 'Please Select a File to Attach.',
    'UPLOADING_WAIT'       => 'Uploading File(s) - Please Wait',
    'BITBUCKET_FULL'       => 'Image Bucket is Full',
    'BITBUCKET_FULL_EXP'   => 'Your Image Bucket is Full!<br />Please Delete some of your Images and try again.',
    'SERVER_ERROR'         => 'Server Error',
    'SERVER_ERROR_EXP'     => 'Server Configuration Error.  Sorry for the Inconvenience.',
    'INVALID_FILE'         => 'Invalid File',
    'INVALID_FILE_EXP'     => 'You may Only Upload File Types with the Extensions:- bmp, gif, jpe, jpeg, jpg, png<br /><br />',
    'FILE_NAME'            => 'File Name: %1$s',
    'FILE_TYPE'            => 'File Type: %1$s',
    'FILE_SIZE'            => 'File Size: %1$s',
));

?>