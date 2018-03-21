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
** File viewtopic/english.php 2018-03-20 14:08:00 Thor
**
** CHANGES
**
** 2018-03-02 - Added New Masthead
** 2018-03-02 - Added New !defined('IN_PMBT')
** 2018-03-02 - Fixed Spelling
**/

if (!defined('IN_PMBT'))
{
    include_once './../../security.php';
    die ("You can't access this file directly");
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files must use UTF-8 as their encoding and the files must Not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You Do Not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a String contains only two placeholders which are used to wrap text
// in a URL you again Do Not need to specify an order e.g., 'Click %sHERE%s' is fine

// Privacy Policy and T&C
// Common Language Entries

$lang = array_merge($lang, array(
    'ATTACHMENT'                        => 'Attachment',
    'ATTACHMENT_FUNCTIONALITY_DISABLED' => 'The attachments feature has been disabled.',

    'BOOKMARK_ADDED'            => 'Bookmarked topic successfully.',
    'BOOKMARK_ERR'              => 'Bookmarking the topic failed. Please try again.',
    'BOOKMARK_REMOVED'          => 'Removed bookmarked topic successfully.',
    'BOOKMARK_TOPIC'            => 'Bookmark topic',
    'BOOKMARK_TOPIC_REMOVE'     => 'Remove from bookmarks',
    'BUMPED_BY'                 => 'Last bumped by %1$s on %2$s.',
    'BUMP_TOPIC'                => 'Bump topic',

    'CODE'                      => 'Code',
    'COLLAPSE_QR'               => 'Hide Quick Reply',

    'DELETE_TOPIC'              => 'Delete topic',
    'DOWNLOAD_NOTICE'           => 'You do not have the required permissions to view the files attached to this post.',

    'EDITED_TIMES_TOTAL'        => 'Last edited by %1$s on %2$s, edited %3$d times in total.',
    'EDITED_TIME_TOTAL'         => 'Last edited by %1$s on %2$s, edited %3$d time in total.',
    'EMAIL_TOPIC'               => 'email friend',
    'ERROR_NO_ATTACHMENT'       => 'The selected attachment does not exist anymore.',

    'FILE_NOT_FOUND_404'        => 'The file <strong>%s</strong> does not exist.',
    'FORK_TOPIC'                => 'Copy topic',
    'FULL_EDITOR'               => 'Full Editor',

    'LINKAGE_FORBIDDEN'         => 'You are not authorised to view, download or link from/to this site.',
    'LOGIN_NOTIFY_TOPIC'        => 'You have been notified about this topic, please login to view it.',
    'LOGIN_VIEWTOPIC'           => 'The board requires you to be registered and logged in to view this topic.',

    'MAKE_ANNOUNCE'             => 'Change to "Announcement"',
    'MAKE_GLOBAL'               => 'Change to "Global"',
    'MAKE_NORMAL'               => 'Change to "Standard Topic"',
    'MAKE_STICKY'               => 'Change to "Sticky"',
    'MAX_OPTIONS_SELECT'        => 'You may select up to <strong>%d</strong> options',
    'MAX_OPTION_SELECT'         => 'You may select <strong>1</strong> option',
    'MISSING_INLINE_ATTACHMENT' => 'The attachment <strong>%s</strong> is no longer available',
    'MOVE_TOPIC'                => 'Move topic',

    'NO_ATTACHMENT_SELECTED'    => 'You haven\'t selected an attachment to download or view.',
    'NO_NEWER_TOPICS'           => 'There are no newer topics in this forum.',
    'NO_OLDER_TOPICS'           => 'There are no older topics in this forum.',
    'NO_UNREAD_POSTS'           => 'There are no new unread posts for this topic.',
    'NO_VOTE_OPTION'            => 'You must specify an option when voting.',
    'NO_VOTES'                  => 'No votes',

    'POLL_ENDED_AT'             => 'Poll ended at %s',
    'POLL_RUN_TILL'             => 'Poll runs till %s',
    'POLL_VOTED_OPTION'         => 'You voted for this option',
    'PRINT_TOPIC'               => 'Print view',

    'QUICK_MOD'                 => 'Quick-mod tools',
    'QUICKREPLY'                => 'Quick Reply',
    'QUOTE'                     => 'Quote',

    'REPLY_TO_TOPIC'            => 'Reply to topic',
    'RETURN_POST'               => '%sReturn to the post%s',

    'SHOW_QR'                   => 'Quick Reply',
    'SUBMIT_VOTE'               => 'Submit vote',

    'TOTAL_VOTES'               => 'Total votes',

    'UNLOCK_TOPIC'              => 'Unlock topic',

    'VIEW_INFO'                 => 'Post details',
    'VIEW_NEXT_TOPIC'           => 'Next topic',
    'VIEW_PREVIOUS_TOPIC'       => 'Previous topic',
    'VIEW_RESULTS'              => 'View results',
    'VIEW_TOPIC_POST'           => '1 post',
    'VIEW_TOPIC_POSTS'          => '%d posts',
    'VIEW_UNREAD_POST'          => 'First unread post',
    'VISIT_WEBSITE'             => 'WWW',
    'VOTE_SUBMITTED'            => 'Your vote has been cast.',
    'VOTE_CONVERTED'            => 'Changing votes is not supported for converted polls.',
));

?>