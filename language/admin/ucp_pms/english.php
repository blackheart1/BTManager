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
** File ucp_pms/english.php 2018-09-15 07:21:00 Thor
**
** CHANGES
**
** 2018-02-25 - Added New Masthead
** 2018-02-25 - Added New !defined('IN_PMBT')
** 2018-02-25 - Fixed Spelling
** 2018-04-11 - Amended the Wording of some Sentences
** 2018-04-11 - Amended !defined('IN_PMBT') Corrected Path
** 2018-05-07 - Added Missing Languages
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
    'READ_USER_PMS'           => 'Read Private Messages',
    'HEADER_READ_USER'        => 'Read User\'s Private Messages',
    'USER_ID_SEARCH'          => 'User ID or Username',
    'USER_ID_SEARCH_EXP'      => 'Search using the User\'s ID or Name.  Only the Signup Name will be Searched',
    'LIST_OF_PMS'             => 'List Users with Private Messages',
    'LIST_OF_PMS_EXP'         => 'Shows a List of Users with Private Messages and How Many they have',
    'HEADER_SEARCH'           => 'Search for Private Messages',
    'SEARCH_PMS'              => 'Search for',

    'SEARCH_PMS_EXP'          => 'Separate each Search Term with a Space.<br />Each Search should be No Less than 4 Characters Long',

    'SEARCH_MATCH'            => 'Match',
    'EXACT_TEXT'              => 'The Exact Text',
    'ALL_WORDS'               => 'ALL of the Words',
    'ATLEAST_ONE_WORD'        => 'at least One of the Words',
    'LATEST_PMS'              => 'Latest Private Messages',
    'NUM_TO_SHOW'             => 'Number of Private Messages to Show',
    'RAED_USER_EXP'           => '',
    'PM_MANAGER'              => 'Private Message Management',

    'PM_MANAGER_EXP'          => 'Private Message Management is used to keep a eye on Users Private Messages to look for Spammers or Trouble Makers on your Site.  This should <strong>ONLY</strong> be used if you have a <strong>Valid Reason</strong> to do so, and is <strong>NOT</strong> to be used for anything else.<br />Use this Tool to Search ALL Users Private Messages.<br /><br />',

    'LATEST_HEADER'           => 'Show Last "%1$s" Private Messages',
    'LIST_HEADER'             => '',
    'HAVE_PMS_HEADER'         => 'Read Private Messages - List Users with Private Messages',
    'HEADER_SENT_PMS'         => '%1$s Private Messages Sent by %2$s',
    'HEADER_RESEAVED_PMS'     => '%1$s Private Messages Received for %2$s',
    'VIEW_PMS'                => 'View Private Message',
    'FROM'                    => 'From',
    'TO'                      => 'To',
    'SENT'                    => 'Sent',
    'LINK_TO_USER'            => 'Link goes to User\'s Details',
    'GO_BACK'                 => 'Go Back',
    'LIST_USERS'              => 'List ALL Users',
    'LIST_ROW_COUNT'          => 'There are %1$s Users with %2$s Private Messages',
    'ERROR_MUST_ONE_WORD'     => 'You must Type in at least One Word to Search for.',
    'ERROR_MUST_FOUR_LETTERS' => 'You must Type in at least One Word to Search for.<br />Must be No Less than 4 Characters Long',
    'ERROR_LATEST_NUM'        => 'Enter a Positive Number Greater than 0.',
    'ERROR_NO_PMS'            => 'There are No Private Messages to View.',
    'ERROR_EMPTY_FEALD'       => 'You Need to Enter a User ID or Username.',
    'ERROR_NO_SUCH_USER_NAME' => 'User <strong>%1$s</strong> DOES NOT Exist.',
    'ERROR_NO_SUCH_USER_ID'   => 'User ID: <strong>%1$s</strong> DOES NOT Exist.',
    'SHOW_ALL_PMS'            => 'Show All PM\'s',
    'SEND_PM_USER'            => 'Send PM to User',
    'EDIT_USER'               => 'Edit User',
    'SEARCH_RESULT'           => 'Search Results for',
    'READ_PMS'                => 'Read PM\'s',
));

?>