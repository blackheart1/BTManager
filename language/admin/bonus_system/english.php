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
** File bonus_system/english.php 2018-02-28 08:37:00 Thor
**
** CHANGES
**
** 2018-02-18 - Added New Masthead
** 2018-02-18 - Added New !defined('IN_PMBT')
** 2018-02-18 - Fixed Spelling
**/

if (!defined('IN_PMBT'))
{
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <title>
        <?php if (isset($_GET['error']))
        {
        echo htmlspecialchars($_GET['error']);
        }
        ?> Error</title>

        <link rel='stylesheet' type='text/css' href='/errors/error-style.css' />
    </head>

    <body>
        <div id='container'>
        <div align='center' style='padding-top: 15px'>
            <img src='/errors/error-images/alert.png' width='89' height='94' alt='' title='' />
        </div>

        <h1 class='title'>Error 404 - Page Not Found</h1>
        <p class='sub-title' align='center'>The page that you are looking for does not appear to exist on this site.</p>
        <p>If you typed the address of the page into the address bar of your browser, please check that you typed it in correctly.</p>
        <p>If you arrived at this page after you used an old Bookmark or Favourite, the page in question has probably been moved. Try locating the page via the navigation menu and then update your bookmarks.</p>
        </div>
    </body>
    </html>

    <?php
    exit();
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
    '_admbonsetting'           => "Bonus Settings",
    '_admsettingexplain'       => 'Configure your Bonus System how you would like to handle things such as Upload Bonus, Seeding Bonus, and More.',

    '_admbonalo'               => "Allow Bonus",
    '_admpactive'              => "Bonus On/Off",
    '_admpactiveexplain'       => "This will Turn the Bonus System On or Off.",
    '_admpupload'              => "Upload Bonus",
    '_admpuploadexplain'       => "This is the Amount a User will get<br />for Uploading a Torrent.",
    '_admpcommentexplain'      => "This is the Amount a User will get<br />for Making a Torrent Comment.",
    '_admpcomment'             => "Comment Bonus",
    '_admpofferexplain'        => "This is the Amount a User will get<br />for Making a Torrent Offer.",
    '_admpoffer'               => "Offer Bonus",
    '_admpseedingexplain'      => "This is the Amount a User will get<br />for Seeding a Torrent.<br />This Setting Works with Auto Clean Timer in Settings",

    '_admpseeding'             => "Seeding Bonus",
    '_admbonseedtor'           => "Give Bonus for each Torrent",
    '_admpby_torrentexplain'   => "If Active Users will get a Bonus for each Torrent that they are Seeding<br />If NOT they will Only get a Single Bonus NO matter how many Torrents they Seed",

    '_admpby_torrent'          => "Bonus For Each/ALL Torrents",
    '_admbonreq'               => "Request Bonus",
    '_admpfill_requestexplain' => "This is the Amount a User will get<br />for Uploading a Torrent that was Requested. This is on top of the Uploading Bonus",

    '_admpfill_request'        => "Filling Request Bonus",
    '_admbonbongo'             => "Edit Bonus!",
    'SUBMIT'                   => 'Submit',
    'TRADE_FOR'                => 'Trade for',
    'POINTS'                   => 'Points needed',
    'DESC'                     => 'Description',
    'SUCCESS'                  => 'Success!',
    'SETTING_SAVED'            => 'Settings have been Saved to the Database',
    'CONFIRM_OPERATION_DEL'    => 'Are you sure you wish to Remove this Bonus Option.',
    'ERROR'                    => 'Error!',
    'NO_ID'                    => 'A Error has Occurred as NO ID was Set',
    'BONUS_REMOVED'            => 'Bonus Option has been Removed from the Database.',
    'BONUS_NAME'               => 'Bonus Points Name',
    'BONUS_POINTS'             => 'How many Points are needed',
    'BONUS_DESC'               => 'Trade Points Explained',
    'BONUS_ART'                => 'What are they getting',
    'BONUS_MENGE'              => 'The System Value',
    'BONUS_NAME_EXP'           => 'Give a Descriptive Name for what the User is getting for there Points.<br />1GB Upload, 1.5GB Upload, 1 Invite',

    'BONUS_POINTS_EXP'         => 'Let the User know how many Points it will take to get this Bonus',
    'BONUS_DESC_EXP'           => 'Explain in Detail what will happen when Exchanged',
    'BONUS_ART_EXP'            => 'Let the System know for Order of Display what it is for (Traffic/Invite)',
    'BONUS_MENGE_EXP'          => 'Let the System know how many to give out (1, 10, 100)',
    'ADD_TITLE'                => 'Add New Bonus',
    'ADD_EXPLANE'              => 'You can Add a New Bonus to the System at any time from here<br />Make sure you Fill in ALL the Fields!',

    'EDIT_TITLE'               => 'Edit Your Bonus',
    'EDIT_EXPLANE'             => 'You can Change the Bonus to how you would like it to be.',
    'NO_NAME'                  => 'No Name has been Set',
    'NO_PONTS'                 => 'No Points have been Set',
    'NO_DESC'                  => 'No Description has been given',
    'NO_SYS_VAL'               => 'No System Required Value is Set',
    'NOT_VALID_BONUS'          => 'There seems to be NO Bonus in the System with this ID!',
    'BONUS_UPDATED'            => 'Values for this Bonus have been Updated',
    'BONUS_ADDED'              => 'New Bonus was Successfully Added to the Database',
));

?>