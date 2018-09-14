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
** File searchcloud/english.php 2018-09-14 10:12:00 Thor
**
** CHANGES
**
** 2018-02-25 - Added New Masthead
** 2018-02-25 - Added New !defined('IN_PMBT')
** 2018-02-25 - Fixed Spelling
** 2018-04-11 - Amended the Wording of some Sentences
** 2018-04-11 - Amended !defined('IN_PMBT') Corrected Path
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
    'SC_CONFIG'         => 'Search Cloud Control',
    'USER_ONLY_RC'      => '<strong>Record Only Users</strong>',
    'USER_ONLY_RC_EXP'  => 'Record Only Users Search Terms to Database',
    'HOW_MANY'          => '<strong>How many Search Terms</strong>',
    'HOW_MANY_EXP'      => 'How many Search Terms would you like to Display in the Search Cloud',
    'CONFIG_NOT_SET'    => 'There seems to be a Problem with your Entries.  Configuration NOT Set',
    'ERR_HOWMANY'       => 'The Entered Value for "<strong>How many</strong>" was NOT Numeric',
    'ERR_ACTIVE'        => 'The Entered Value for "<strong>Display Search Cloud</strong>" was NOT Set Properly',
    'ERR_USERONLY'      => 'The Entered Value for "<strong>Record Only Users</strong>" was NOT Set Properly',
    'SCBLOCKDSP'        => '<strong>Display Search Cloud</strong>',

    'SCBLOCK_EXP'       => 'Display a Block with a Search Cloud.  ALL Terms your Users Search for are Recorded and Displayed in a Cloud.  The more often a Term is Searched, the Larger the Font Size/Weight will be.',

    'SCTERM'            => 'Search Term',
    'SCTERMS'           => 'Search Terms',

    'SCTITLEEXP'        => 'This Tool Allows you to List and Remove Search Terms that are Saved in the Database and Displayed in the Search Cloud.  Terms are Ordered by Search Frequency and can be Searched.<br /><br />',

    'SCTIMES'           => 'Times Searched',
    'SCTERM_ID'         => 'Term ID',
    'SCTERM_REMOVED'    => 'Term Removed',
    'SCTERMREMOVE'      => 'Remove Term from the Database',
    'SCLOUD'            => 'Search Cloud',
    'SC_SET_UPDATED'    => 'Settings Updated Successfully',
    'PRUNE_SUCCESS'     => 'ALL Search Terms have been Removed',
    'CONFIRM_OPERATION' => 'Are you sure you wish to Remove ALL Search Terms?<br />This Action can NOT be Undone.',
    'DELETE_ALL'        => 'Delete ALL Terms',
));

?>