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
** File bonus_system/english.php 2018-03-29 10:28:00 Thor
**
** CHANGES
**
** 2018-02-18 - Added New Masthead
** 2018-02-18 - Added New !defined('IN_PMBT')
** 2018-02-18 - Fixed Spelling
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
    '_admbonsetting'           => 'Bonus Settings',

    '_admsettingexplain'       => 'Configure your Bonus System how you would like to handle things such as Upload Bonus, Seeding Bonus etc.',

    //'_admbonalo'               => 'Allow Bonus',
    '_admpactive'              => 'Enable/Disable Bonus',
    '_admpactiveexplain'       => 'This will Turn the Bonus System On or Off.',
    '_admpupload'              => 'Upload Bonus',
    '_admpuploadexplain'       => 'This is the Amount a User will get for Uploading a Torrent.',
    '_admpcommentexplain'      => 'This is the Amount a User will get for Commenting on a Torrent.',
    '_admpcomment'             => 'Comment Bonus',
    '_admpofferexplain'        => 'This is the Amount a User will get for Making a Torrent Offer.',
    '_admpoffer'               => 'Offer Bonus',
    '_admpseedingexplain'      => 'This is the Amount a User will get for Seeding a Torrent.<br />This Setting Works with Auto Clean Timer in Settings.',

    '_admpseeding'             => 'Seeding Bonus',
    '_admbonseedtor'           => 'Give Bonus for Each Torrent',

    '_admpby_torrentexplain'   => 'If Active Users will get a Bonus for Each Torrent that they are Seeding.<br />If NOT they will Only get a Single Bonus NO matter how many Torrents they Seed.',

    '_admpby_torrent'          => 'Bonus for Each/ALL Torrents',
    '_admbonreq'               => 'Request Bonus',

    '_admpfill_requestexplain' => 'This is the Amount a User will get for Uploading a Torrent that was Requested.<br />This is on top of the Uploading Bonus',

    '_admpfill_request'        => 'Filling Request Bonus',
    '_admbonbongo'             => 'Edit Bonus!',
    'SUBMIT'                   => 'Submit',
    'TRADE_FOR'                => 'Trade for',
    'POINTS'                   => 'Points Needed',
    'DESC'                     => 'Description',
    'SUCCESS'                  => 'Success!',
    'SETTING_SAVED'            => 'Settings have been Saved to the Database',
    'CONFIRM_OPERATION_DEL'    => 'Are you sure you wish to Remove this Bonus Option?',
    'ERROR'                    => 'Error!',
    'NO_ID'                    => 'A Error has Occurred as NO ID was Set',
    'BONUS_REMOVED'            => 'Bonus Option has been Removed from the Database.',
    'BONUS_NAME'               => 'Bonus Points Name',
    'BONUS_POINTS'             => 'How many Points are Needed?',
    'BONUS_DESC'               => 'Trade Points Explained',
    'BONUS_ART'                => 'What are they getting?',
    'BONUS_MENGE'              => 'The System Value',

    'BONUS_NAME_EXP'           => 'Give a Descriptive Name for what the User is getting for their Points.<br />1GB Upload, 1.5GB Upload, 1 Invite.',

    'BONUS_POINTS_EXP'         => 'Let the User know how many Points it will take to get this Bonus.',
    'BONUS_DESC_EXP'           => 'Explain in Detail what will happen when Exchanged.',
    'BONUS_ART_EXP'            => 'Let the System know for Order of Display what it is for (Traffic/Invite).',
    'BONUS_MENGE_EXP'          => 'Let the System know how many to give out (1, 10, 100).',
    'ADD_TITLE'                => 'Add New Bonus',

    'ADD_EXPLANE'              => 'You can Add a New Bonus to the System at any time from here.<br />Make sure you Fill in ALL the Fields!',

    'EDIT_TITLE'               => 'Edit Your Bonus',
    'EDIT_EXPLANE'             => 'You can Change the Bonus to how you would like it to be.',
    'NO_NAME'                  => 'NO Name has been Set!',
    'NO_PONTS'                 => 'NO Points have been Set!',
    'NO_DESC'                  => 'NO Description has been given!',
    'NO_SYS_VAL'               => 'NO System Required Value is Set!',
    'NOT_VALID_BONUS'          => 'There seems to be NO Bonus in the System with this ID!',
    'BONUS_UPDATED'            => 'Values for this Bonus have been Updated.',
    'BONUS_ADDED'              => 'New Bonus was Successfully Added to the Database.',
));

?>