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
** File viewtopic/english.php 2018-04-28 08:33:00 Thor
**
** CHANGES
**
** 2018-03-02 - Added New Masthead
** 2018-03-02 - Added New !defined('IN_PMBT')
** 2018-03-02 - Fixed Spelling
** 2018-04-28 - Amended the Wording of some Sentences
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
    'ATTACHMENT'                        => 'Attachment',
    'ATTACHMENT_FUNCTIONALITY_DISABLED' => 'The Attachments Feature is Currently Disabled.',

    'BOOKMARK_ADDED'        => 'Successfully Bookmarked the Topic.',
    'BOOKMARK_ERR'          => 'Failed to Bookmark the Topic.  Please try again!',
    'BOOKMARK_REMOVED'      => 'Successfully Removed the Bookmarked Topic.',
    'BOOKMARK_TOPIC'        => 'Bookmark Topic',
    'BOOKMARK_TOPIC_REMOVE' => 'Remove from Bookmarks',
    'BUMPED_BY'             => 'Last Bumped by %1$s on %2$s.',
    'BUMP_TOPIC'            => 'Bump Topic',

    'CODE'                  => 'Code',
    'COLLAPSE_QR'           => 'Hide Quick Reply',

    'DELETE_TOPIC'          => 'Delete Topic',
    'DOWNLOAD_NOTICE'       => 'You DO NOT have the Required Permissions to View the Files Attached to this Post.',

    'EDITED_TIMES_TOTAL'    => 'Last edited by %1$s on %2$s, edited %3$d times in total.',
    'EDITED_TIME_TOTAL'     => 'Last edited by %1$s on %2$s, edited %3$d time in total.',
    'EMAIL_TOPIC'           => 'email Friend',
    'ERROR_NO_ATTACHMENT'   => 'The Selected Attachment DOES NOT Exist any more.',

    'FILE_NOT_FOUND_404'    => 'The File <strong>%s</strong> DOES NOT Exist.',
    'FORK_TOPIC'            => 'Copy Topic',
    'FULL_EDITOR'           => 'Full Editor',

    'LINKAGE_FORBIDDEN'     => 'You DO NOT have the Required Permissions to View, Download or Link from/to this Site.',
    'LOGIN_NOTIFY_TOPIC'    => 'You have been Notified about this Topic.  Please Login to View it.',
    'LOGIN_VIEWTOPIC'       => 'The Board Requires you to be Registered and Logged in to View this Topic.',

    'MAKE_ANNOUNCE'             => 'Change to Announcement',
    'MAKE_GLOBAL'               => 'Change to Global',
    'MAKE_NORMAL'               => 'Change to Standard Topic',
    'MAKE_STICKY'               => 'Change to Sticky',
    'MAX_OPTIONS_SELECT'        => 'You may Select up to <strong>%d</strong> Options',
    'MAX_OPTION_SELECT'         => 'You may Select <strong>1</strong> Option',
    'MISSING_INLINE_ATTACHMENT' => 'The Attachment <strong>%s</strong> is NO Longer Available',
    'MOVE_TOPIC'                => 'Move Topic',

    'NO_ATTACHMENT_SELECTED' => 'You haven\'t Selected an Attachment to Download or View.',
    'NO_NEWER_TOPICS'        => 'There are NO Newer Topics in this Forum.',
    'NO_OLDER_TOPICS'        => 'There are NO Older Topics in this Forum.',
    'NO_UNREAD_POSTS'        => 'There are NO New Unread Posts for this Topic.',
    'NO_VOTE_OPTION'         => 'You must Specify an Option when Voting.',
    'NO_VOTES'               => 'No Votes',

    'POLL_ENDED_AT'          => 'Poll Ended at %s',
    'POLL_RUN_TILL'          => 'Poll Runs Until %s',
    'POLL_VOTED_OPTION'      => 'You Voted for this Option',
    'PRINT_TOPIC'            => 'Print View',

    'QUICK_MOD'              => 'Quick Mod Tools',
    'QUICKREPLY'             => 'Quick Reply',
    'QUOTE'                  => 'Quote',

    'REPLY_TO_TOPIC'         => 'Reply to Topic',
    'RETURN_POST'            => '%sReturn to the Post%s',

    'SHOW_QR'                => 'Quick Reply',
    'SUBMIT_VOTE'            => 'Submit Vote',

    'TOTAL_VOTES'            => 'Total Votes',

    'UNLOCK_TOPIC'           => 'Unlock Topic',

    'VIEW_INFO'              => 'Post Details',
    'VIEW_NEXT_TOPIC'        => 'Next Topic',
    'VIEW_PREVIOUS_TOPIC'    => 'Previous Topic',
    'VIEW_RESULTS'           => 'View Results',
    'VIEW_TOPIC_POST'        => '1 Post',
    'VIEW_TOPIC_POSTS'       => '%d Posts',
    'VIEW_UNREAD_POST'       => 'First Unread Post',
    'VISIT_WEBSITE'          => 'www',
    'VOTE_SUBMITTED'         => 'Your Vote has been Cast.',
    'VOTE_CONVERTED'         => 'Changing Votes is NOT Supported for Converted Polls.',
));

?>