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
** File offers/english.php 2018-04-25 08:25:00 Thor
**
** CHANGES
**
** 2018-03-02 - Added New Masthead
** 2018-03-02 - Added New !defined('IN_PMBT')
** 2018-03-02 - Fixed Spelling
** 2018-04-25 - Amended the Wording of some Sentences
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
    'OFFERS'               => 'Offers',
    'MAKE_OFFER'           => 'Make an Offer',

    'DESCRIPTION_EXPLAIN'  => 'Add as much Information as Possible.  This will make it easier for the Uploader to find what your looking for.',

    'OFFER_DELETED'        => 'Your Offer %1$d was Deleted by %2$d',
    'VOTE'                 => 'Vote',
    'VOTES'                => 'Votes',
    'OFFER_VOTE'           => 'Offer Vote',
    'VOTE_FOR'             => 'Vote for this Offer to be Uploaded.',
    'EDIT_OFFER'           => 'Edit Offers',
    'OFFER_BY'             => 'Offered by',
    'OFFER_EDITED'         => 'Offer Edited',
    'OFFER_EDITED_EXP'     => 'The Offer was Successfully Edited!',
    'OFFER_DELETED'        => 'Offer Deleted',
    'OFFER_DELETED_EXP'    => 'The Offer was Successfully Removed!',
    'ERROR_DESCRIP_BLANK'  => 'The Description Field can NOT be Blank',
    'ERROR_EDIT_NOT_SAVED' => 'An Error has Occurred and the Edit was NOT Saved',
    'PM_VOTES_REACHED'     => 'Your Offer "%1$d" has Reached 3 Votes.\nYou can now Upload it',
    'PM_SUB_VOTES_REACHED' => 'Your Offered Torrent for Upload',
    'THANKS_FOR_VOTE'      => 'Thank you for your Vote',

    'VOTED_ALREADY'        => 'You\'ve already Voted on this Offer.  ONLY <strong>1</strong> Vote per Member is Allowed<br />Return to the <a href=\'offers.php\'><strong>Offers List</strong></a>',

    'VOTE_TAKEN'           => 'Your Vote has been Counted<br />Return to the <a href=\'offers.php\'><strong>Offer List</strong></a>',

    'PERMISSION_DENIED'    => 'You DO NOT have Permissions to Access Offers at this time',
    'OFFER_SHOUT'          => '"%1$s" is making a Offer for "%2$s"',
    'NO_NAME_GIVEN'        => 'You should Enter a Name for your Offer',
    'DOWNLOAD'             => 'Download',
    'UPLOAD'               => 'Upload',
    'RATIO'                => 'Ratio',
));

?>