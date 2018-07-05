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
** File edit/english.php 2018-07-05 12:42:00 Thor
**
** CHANGES
**
** 2018-03-02 - Added New Masthead
** 2018-03-02 - Added New !defined('IN_PMBT')
** 2018-03-02 - Fixed Spelling
** 2018-04-21 - Amended the Wording of some Sentences
** 2018-04-23 - Removed Reduntent text
** 2018-07-05 - Added Missing Language
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
    'EDIT_TITLE'              => 'Edit Torrent',
    'BLOCK_TITLE'             => 'Editing Comment for %1$s',
    'T_TITTLE_EDIT'           => 'Edit Torrent %1$s',
    'T_BLOCK_TITLE'           => 'Editing Torrent %1$s',
    'DESCRIPTION'             => 'Message Body',
    'DESCRIPTION_EXPLAIN'     => 'Enter your Message, it may contain NO more than 60,000 Characters. ',
    'DESCRIPTION_T_EXPLAIN'   => 'Please give as much Information as you can about this File.',
    'ERROR_COMENT_ID'         => 'Invalid Comment ID',
    'ERROR_COMENT_TOR'        => 'Invalid Torrent ID',
    'ERROR_NOT_AUTH_EDCOM'    => 'You are NOT Authorised to Edit your Comments',
    'ERROR_NOT_AUTH_MDCOM'    => 'You are NOT Authorised to Edit others Comments',
    'ERROR_COMMENT_BLANK'     => 'Your Comment can NOT be Blank.  If you which to Remove your Comment, please Delete it',
    'ERROR_NOT_U_AUTH_EDIT'   => 'Your Group is NOT Authorised to Edit Torrents',
    'ERROR_NOT_M_AUTH_EDIT'   => 'Your Group is NOT Authorised to Edit Torrents',
    'ERROR_NOT_U_AUTH_DELETE' => 'Your Group is NOT Authorised to Delete Torrents',
    'ERROR_NOT_M_AUTH_DELETE' => 'Your Group is NOT Authorised to Delete Torrents',
    'ERROR_NOT_M_AUTHE_BAN'   => 'Your Group is NOT Authorised to Ban Torrents',
    'SUCCES_EDIT_TAKEN'       => 'Your Changes were Successfully Updated!',
    'SUCCES_ADMIN_DELETE'     => 'Torrents have been Successfully Removed!',
    'UPLOAD_NFO'              => 'Upload NFO File',
    'UPLOAD_NFO_EXP'          => 'An (.)nfo File is a Text File containing Information about this Torrent.',
    'EDIT_NAME'               => 'Torrent Name',

    'EDIT_NAME_EXP'           => 'Will be Generated from the Filename if left Blank.  Try to give it a Descriptive Name',

    'EDIT_IMDB'        => 'IMDB Link',
    'EDIT_IMDB_EXP'    => 'Add IMDB to Details Page by providing an IMDB Link or IMDB NUMBER',
    'EDIT_EVIDENT'     => 'Sticky',
    'EDIT_EVIDENT_EXP' => 'Mark Torrent as Sticky so that is stays at the Top of the List.',
    'EDIT_PRIVACY'     => 'Display Name',

    'EDIT_PRIVACY_EXP' => '<br /><strong>SHOW USER</strong> Allows other Users to see your Username,<br />
                            <strong>PRIVACY MODE</strong> Hides it, retaining Edit/Delete Permissions,<br />
                            <strong>STEALTH MODE</strong> (if available) Completely Hides the Owner to the System, and Doesn\'t Allow any Edit/Deletions by the User.',

    'SHOW_USER'            => 'SHOW USER',
    'PRIVACY_MODE'         => 'PRIVACY MODE',
    'STEALTH_MODE'         => 'STEALTH MODE',

    'PASSWORD_EXP'         => 'You may choose a Password to Protect your Torrent from Unauthorised Viewing.  If a Password is Set, the Torrent will NOT be Visible to Anyone Except Select Groups which have been SET by the Administrator\'s in the Torrent List and Torrent Search.  If you want others to Access your Torrent you\'ll have to send them a Direct Link to the Torrent.  Only Internal Torrents can be Password Protected.',

    'RATIO_BUILDER'          => 'Ratio Builder',
    'NUKED_REASON'           => 'Nuke Reason',
    'NUKE'                   => 'Nuke',
    'BANNED'                 => 'Banned',
    'EDIT_POSTER'            => 'Poster',
    'EDIT_POSTER_EXP'        => 'Direct Link for a Poster,<br />(Example http://img52.imageshack.us/img52/6272/lookatme.png)',
    'EDIT_SCREENA'           => 'Screenshot 1',
    'EDIT_SCREENA_EXP'       => 'Direct Link for a Screenshot 1',
    'EDIT_SCREENB'           => 'Screenshot 2',
    'EDIT_SCREENB_EXP'       => 'Direct Link for a Screenshot 2',
    'EDIT_SCREENC'           => 'Screenshot 3',
    'EDIT_SCREENC_EXP'       => 'Direct Link for a Screenshot 3',
    'EDIT_SCREEND'           => 'Screenshot 4',
    'EDIT_SCREEND_EXP'       => 'Direct Link for a Screenshot 4',
    'ERROR_EDIT_NOT_SAVED'   => 'An Error has Occurred and your Edit was NOT Saved',
    'ERROR_POSTER_A'         => 'The URL you Specified for Poster is Invalid.',
    'ERROR_POSTER_B'         => 'The URL you Specified for Poster is NOT a (gif|jpg|jpeg|png) Image.',
    'ERROR_IMAGEA_A'         => 'The URL you Specified for Screen Shot 1 is Invalid.',
    'ERROR_IMAGEA_B'         => 'The URL you Specified for Screen Shot 1 is NOT a (gif|jpg|jpeg|png) Image.',
    'ERROR_IMAGEB_A'         => 'The URL you Specified for Screen Shot 2 is Invalid.',
    'ERROR_IMAGEB_B'         => 'The URL you Specified for Screen Shot 2 is NOT a (gif|jpg|jpeg|png) Image.',
    'ERROR_IMAGEC_A'         => 'The URL you Specified for Screen Shot 3 is Invalid.',
    'ERROR_IMAGEC_B'         => 'The URL you Specified for Screen Shot 3 is NOT a (gif|jpg|jpeg|png) Image.',
    'ERROR_IMAGED_A'         => 'The URL you Specified for Screen Shot 4 is Invalid.',
    'ERROR_IMAGED_B'         => 'The URL you Specified for Screen Shot 4 is NOT a (gif|jpg|jpeg|png) Image.',
    'ERROR_NO_CAT_SELECTED'  => 'NO Category Selected. Please go back to the Edit Form.',
    'ERROR_INVALID_NFO_NAME' => 'Invalid NFO Filename',
    'ERROR_NOT_NFO'          => 'This is NOT an NFO File (.nfo)',
    'ERROR_EMPTY_NFO'        => 'The NFO File is Empty',
    'ERROR_UPLOADING_NFO'    => 'Fatal Error in the Uploaded NFO File.',
    'ERROR_INVALID_CAT'      => 'Illegal Category!',
    'ERROR_DECRP_IS_BLANK'   => 'Description Field is Empty.  Please go back and enter a Description.',
    'EDITED'                 => 'Edit was Completed',
    'EDITED_EXP'             => 'Edit was Completed Successfully.  Your Changes have been Applied',
    'CONFERM_BAN'            => 'Confirm Torrent Ban',
    'CONFERM_DELETE'         => 'Confirm Torrent Deletion',
    'TORRENT_BANNED'         => 'The Torrent was Successfully Banned.<br /><a href=\'index.php\'>Return to Index </a>',
    'TORRENT_BANNED_CANCEL'  => 'The Torrent Ban was Successfully Cancelled.<br /><a href=\'index.php\'>Return to Index </a>',
    'TORRENT_DELETE'         => 'The Torrent was Successfully Deleted.<br /><a href=\'index.php\'>Return to Index </a>',
    'TORRENT_DELETE_CANCEL'  => 'The Torrent Delete was Successfully Cancelled.<br /><a href=\'index.php\'>Return to Index </a>',
));

?>