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
** File mcp/english.php 2018-05-16 10:04:00 Thor
**
** CHANGES
**
** 2018-03-02 - Added New Masthead
** 2018-03-02 - Added New !defined('IN_PMBT')
** 2018-03-02 - Fixed Spelling
** 2018-04-25 - Amended the Wording of some Sentences
** 2018-05-16 - Added Missing Language
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
    'ACTION'               => 'Action',
    'ACTION_NOTE'          => 'Action/Note',
    'ADD_FEEDBACK'         => 'Add Feedback',

    'ADD_FEEDBACK_EXPLAIN' => 'If you would like to Add a Report on this please complete the following Form.  Only use Plain Text; HTML, BBCode, etc. are NOT Permitted.',

    'ADD_WARNING'          => 'Add Warning',

    'ADD_WARNING_EXPLAIN'  => 'To Send a Warning to this User please complete the following Form.  Only use Plain Text; HTML, BBCode, etc. are NOT Permitted.',

    'ALL_ENTRIES'                  => 'ALL Entries',
    'ALL_NOTES_DELETED'            => 'Successfully Removed ALL User Notes.',
    'ALL_REPORTS'                  => 'ALL Reports',
    'ALREADY_REPORTED'             => 'This Post has already been Reported.',
    'ALREADY_WARNED'               => 'A Warning has already been Issued for this Post.',
    'APPROVE'                      => 'Approve',
    'APPROVE_POST'                 => 'Approve Post',
    'APPROVE_POST_CONFIRM'         => 'Are you sure you want to Approve this Post?',
    'APPROVE_POSTS'                => 'Approve Posts',
    'APPROVE_POSTS_CONFIRM'        => 'Are you sure you want to Approve the Selected Posts?',

    'CANNOT_MOVE_SAME_FORUM'       => 'You can NOT Move a Topic to the Forum that it\'s already in.',
    'CANNOT_WARN_ANONYMOUS'        => 'You can NOT Warn Unregistered Guest Users.',
    'CANNOT_WARN_SELF'             => 'You can NOT Warn Yourself.',
    'CAN_LEAVE_BLANK'              => 'This can be Left Blank.',
    'CHANGE_POSTER'                => 'Change Poster',
    'CLOSE_REPORT'                 => 'Close Report',
    'CLOSE_REPORT_CONFIRM'         => 'Are you sure you want to Close the Selected Report?',
    'CLOSE_REPORTS'                => 'Close Reports',
    'CLOSE_REPORTS_CONFIRM'        => 'Are you sure you want to Close the Selected Reports?',

    'DELETE_POSTS'                 => 'Delete Posts',
    'SEARCH_KEYWORDS'              => 'Search Keywords',
    'TOPIC_REVIEW'                 => 'Topic Review',
    'TOPIC_ICON'                   => 'Topic Icon',
    'DELETE_POSTS_CONFIRM'         => 'Are you sure you want to Delete these Posts?',
    'DELETE_POST_CONFIRM'          => 'Are you sure you want to Delete this Post?',
    'DELETE_REPORT'                => 'Delete Report',
    'DELETE_REPORT_CONFIRM'        => 'Are you sure you want to Delete the Selected Report?',
    'DELETE_REPORTS'               => 'Delete Reports',
    'DELETE_REPORTS_CONFIRM'       => 'Are you sure you want to Delete the Selected Reports?',
    'DELETE_SHADOW_TOPIC'          => 'Delete Shadow Topic',
    'DELETE_TOPICS'                => 'Delete Selected Topics',
    'DELETE_TOPICS_CONFIRM'        => 'Are you sure you want to Delete these Topics?',
    'DELETE_TOPIC_CONFIRM'         => 'Are you sure you want to Delete this Topic?',
    'DISAPPROVE'                   => 'Disapprove',
    'DISAPPROVE_REASON'            => 'Reason for Disapproval',
    'DISAPPROVE_POST'              => 'Disapprove Post',
    'DISAPPROVE_POST_CONFIRM'      => 'Are you sure you want to Disapprove this Post?',
    'DISAPPROVE_POSTS'             => 'Disapprove Posts',
    'DISAPPROVE_POSTS_CONFIRM'     => 'Are you sure you want to Disapprove the Selected Posts?',
    'DISPLAY_LOG'                  => 'Display Entries from previous',
    'DISPLAY_OPTIONS'              => 'Display Options',

    'EMPTY_REPORT'                 => 'You Must Enter a Description when Selecting this Reason.',

    'EMPTY_TOPICS_REMOVED_WARNING' => 'Please Note that one or several Topics have been Removed from the Database because they were or become Empty.',

    'FEEDBACK'                     => 'Feedback',
    'VIEW_FORUM_LOGS'              => 'View Logs',
    'POST'                         => 'Post',
    'FORK'                         => 'Copy',
    'FORK_TOPIC'                   => 'Copy Topic',
    'FORK_TOPIC_CONFIRM'           => 'Are you sure you want to Copy this Topic?',
    'FORK_TOPICS'                  => 'Copy Selected Topics',
    'FORK_TOPICS_CONFIRM'          => 'Are you sure you want to Copy the Selected Topics?',
    'FORUM_DESC'                   => 'Description',
    'FORUM_NAME'                   => 'Forum Name',
    'FORUM_NOT_EXIST'              => 'The Forum you Selected DOES NOT Exist.',
    'FORUM_NOT_POSTABLE'           => 'The Forum you Selected can NOT be Posted to.',
    'FORUM_STATUS'                 => 'Forum Status',
    'FORUM_STYLE'                  => 'Forum Style',

    'GLOBAL_ANNOUNCEMENT'          => 'Global Announcement',

    'IP_INFO'                      => 'IP Address Information',
    'IPS_POSTED_FROM'              => 'IP Addresses this User has Posted from',

    'LATEST_LOGS'                  => 'Latest 5 Logged Actions',
    'LATEST_REPORTED'              => 'Latest 5 Reports',
    'LATEST_UNAPPROVED'            => 'Latest 5 Posts that are waiting to be Approved',
    'LATEST_WARNING_TIME'          => 'Latest Warning Issued',
    'LATEST_WARNINGS'              => 'Latest 5 Warnings',
    'LEAVE_SHADOW'                 => 'Leave Shadow Topic in Place',
    'LIST_REPORT'                  => '1 Report',
    'LIST_REPORTS'                 => '%d Reports',
    'LOCK'                         => 'Lock',
    'LOCK_POST_POST'               => 'Lock Post',
    'LOCK_POST_POST_CONFIRM'       => 'Are you sure you want to Prevent the Editing of this Post?',
    'LOCK_POST_POSTS'              => 'Lock Selected Posts',
    'LOCK_POST_POSTS_CONFIRM'      => 'Are you sure you want to Prevent the Editing of the Selected Posts?',
    'LOCK_TOPIC_CONFIRM'           => 'Are you sure you want to Lock this Topic?',
    'LOCK_TOPICS'                  => 'Lock Selected Topics',
    'LOCK_TOPICS_CONFIRM'          => 'Are you sure you want to Lock ALL Selected Topics?',
    'LOGS_CURRENT_TOPIC'           => 'Currently Viewing Logs of:',
    'LOGIN_EXPLAIN_MCP'            => 'To Moderate this Forum you must Log in.',
    'LOGVIEW_VIEWTOPIC'            => 'View Topic',
    'LOGVIEW_VIEWLOGS'             => 'View Topic Log',
    'LOGVIEW_VIEWFORUM'            => 'View Forum',
    'LOOKUP_ALL'                   => 'Look up ALL IP\'s',
    'LOOKUP_IP'                    => 'Look up IP',

    'MARKED_NOTES_DELETED'         => 'Successfully Removed ALL Marked User Notes.',

    'MCP_ADD'             => 'Add a Warning',

    'MCP_BAN'             => 'Banning',
    'MCP_BAN_EMAILS'      => 'Ban emails',
    'MCP_BAN_IPS'         => 'Ban IP\'s',
    'MCP_BAN_USERNAMES'   => 'Ban Usernames',

    'MCP_LOGS'            => 'Moderator Logs',
    'MCP_LOGS_FRONT'      => 'Front Page',
    'MCP_LOGS_FORUM_VIEW' => 'Forum Logs',
    'MCP_LOGS_TOPIC_VIEW' => 'Topic Logs',

    'MCP_MAIN'                       => 'Main',
    'MCP_MAIN_FORUM_VIEW'            => 'View Forum',
    'MCP_MAIN_FRONT'                 => 'Front Page',
    'MCP_MAIN_POST_DETAILS'          => 'Post Details',
    'MCP_MAIN_TOPIC_VIEW'            => 'View Topic',
    'MCP_MAKE_ANNOUNCEMENT'          => 'Change Topic to an Announcement?',
    'MCP_MAKE_ANNOUNCEMENT_CONFIRM'  => 'Are you sure you want to Change this Topic to an Announcement?',
    'MCP_MAKE_ANNOUNCEMENTS'         => 'Change Topics to Announcements?',
    'MCP_MAKE_ANNOUNCEMENTS_CONFIRM' => 'Are you sure you want to Change the Selected Topics to Announcements?',
    'MCP_MAKE_GLOBAL'                => 'Change Topic to a Global Announcement?',
    'MCP_MAKE_GLOBAL_CONFIRM'        => 'Are you sure you want to Change this Topic to a Global Announcement?',
    'MCP_MAKE_GLOBALS'               => 'Change Topics to Global Announcements?',
    'MCP_MAKE_GLOBALS_CONFIRM'       => 'Are you sure you want to Change the Selected Topics to Global Announcements?',
    'MCP_MAKE_STICKY'                => 'Change Topic to a Sticky Topic?',
    'MCP_MAKE_STICKY_CONFIRM'        => 'Are you sure you want to Change this Topic to a Sticky Topic?',
    'MCP_MAKE_STICKIES'              => 'Change Topics to Sticky Topics?',
    'MCP_MAKE_STICKIES_CONFIRM'      => 'Are you sure you want to Change the Selected Topics to Sticky Topics?',
    'MCP_MAKE_NORMAL'                => 'Change to a Standard Topic?',
    'MCP_MAKE_NORMAL_CONFIRM'        => 'Are you sure you want to Change this Topic to a Standard Topic?',
    'MCP_MAKE_NORMALS'               => 'Change Topics to Standard Topics?',
    'MCP_MAKE_NORMALS_CONFIRM'       => 'Are you sure you want to Change the Selected Topics to Standard Topics?',

    'MCP_NOTES'                  => 'User Notes',
    'MCP_NOTES_FRONT'            => 'Front Page',
    'MCP_NOTES_USER'             => 'User Details',

    'MCP_POST_REPORTS'           => 'Reports Issued on this Post',

    'MCP_REPORTS'                => 'Reported Posts',
    'MCP_REPORT_DETAILS'         => 'Report Details',
    'MCP_REPORTS_CLOSED'         => 'Closed Reports',
    'MCP_REPORTS_CLOSED_EXPLAIN' => 'This is a List of ALL Reports about Posts which have been Resolved.',
    'MCP_REPORTS_OPEN'           => 'Open Reports',
    'MCP_REPORTS_OPEN_EXPLAIN'   => 'This is a List of ALL Reported Posts which Still need to be Dealt with.',

    'MCP_QUEUE'                  => 'Moderation Queue',
    'MCP_QUEUE_APPROVE_DETAILS'  => 'Approve Details',
    'MCP_QUEUE_UNAPPROVED_POSTS' => 'Posts waiting to be Approved',

    'MCP_QUEUE_UNAPPROVED_POSTS_EXPLAIN'  => 'This is a List of ALL Posts which Require Approving before they will be Visible to Users.',

    'MCP_QUEUE_UNAPPROVED_TOPICS'         => 'Topics waiting to be Approved',

    'MCP_QUEUE_UNAPPROVED_TOPICS_EXPLAIN' => 'This is a List of ALL Topics which Require Approving before they will be Visible to Users.',

    'MCP_VIEW_USER'              => 'View Warnings for a Specific User',

    'MCP_WARN'                   => 'Warnings',
    'MCP_WARN_FRONT'             => 'Front Page',
    'MCP_WARN_LIST'              => 'List Warnings',
    'MCP_WARN_POST'              => 'Warn for a Specific Post',
    'MCP_WARN_USER'              => 'Warn User',

    'MERGE_POSTS'                => 'Merge Posts',
    'MERGE_POSTS_CONFIRM'        => 'Are you sure you want to Merge the Selected Posts?',

    'MERGE_TOPIC_EXPLAIN'        => 'Using the form below you can Merge Selected Posts into another Topic.  These Posts will NOT be Reordered and will Appear as if the User\'s Posted them to the New Topic.<br />Please Enter the Destination Topic ID or Click on "Select Topic" to Search for one.',

    'MERGE_TOPIC_ID'             => 'Destination Topic Identification Number',
    'MERGE_TOPICS'               => 'Merge Topics',
    'MERGE_TOPICS_CONFIRM'       => 'Are you sure you want to Merge the Selected Topics?',
    'MODERATE_FORUM'             => 'Moderate Forum',
    'MODERATE_TOPIC'             => 'Moderate Topic',
    'MODERATE_POST'              => 'Moderate Post',
    'MOD_OPTIONS'                => 'Moderator Options',
    'MORE_INFO'                  => 'Further Information',
    'MOST_WARNINGS'              => 'Users with the Most Warnings',
    'MOVE_TOPIC_CONFIRM'         => 'Are you sure you want to Move the Topic into a New Forum?',
    'MOVE_TOPICS'                => 'Move Selected Topics',
    'MOVE_TOPICS_CONFIRM'        => 'Are you sure you want to Move the Selected Topics into a New Forum?',

    'NOTIFY_POSTER_APPROVAL'     => 'Notify Poster about Approval?',
    'NOTIFY_POSTER_DISAPPROVAL'  => 'Notify Poster about Disapproval?',
    'NOTIFY_USER_WARN'           => 'Notify User about Warning?',
    'NOT_MODERATOR'              => 'You are NOT a Moderator of this Forum.',
    'NO_DESTINATION_FORUM'       => 'Please Select a Destination Forum.',
    'NO_DESTINATION_FORUM_FOUND' => 'There is No Destination Forum Available.',
    'NO_ENTRIES'                 => 'No Log Entries for this Period.',
    'NO_FEEDBACK'                => 'No Feedback Exists for this User.',
    'NO_FINAL_TOPIC_SELECTED'    => 'You have to Select a Destination Topic for Merging Posts.',
    'NO_MATCHES_FOUND'           => 'No Matches Found.',
    'NO_POST'                    => 'You have to Select a Post in order to Warn the User for a Post.',
    'NO_POST_REPORT'             => 'This Post was NOT Reported.',
    'NO_POST_SELECTED'           => 'You must Select at least One Post to Perform this Action.',
    'NO_REASON_DISAPPROVAL'      => 'Please give an Appropriate Reason for Disapproval.',
    'NO_REPORT'                  => 'No Report Found',
    'NO_REPORTS'                 => 'No Reports Found',
    'NO_REPORT_SELECTED'         => 'You must Select at least One Report to Perform this Action.',
    'NO_TOPIC_ICON'              => 'None',
    'NO_TOPIC_SELECTED'          => 'You must Select at least One Topic to Perform this Action.',
    'NO_TOPICS_QUEUE'            => 'There are No Topics waiting to be Approved.',
    'NO_USER'                    => 'No Matches Found.',

    'ONLY_TOPIC'                 => 'Only Topic %s',
    'OTHER_USERS'                => 'Other Users Posting from this IP',

    'POSTER'                     => 'Poster',
    'POSTS_APPROVED_SUCCESS'     => 'The Selected Posts were Approved.',
    'POSTS_DELETED_SUCCESS'      => 'The Selected Posts were Successfully Removed from the Database.',
    'POSTS_DISAPPROVED_SUCCESS'  => 'The Selected Posts were Disapproved.',
    'POSTS_LOCKED_SUCCESS'       => 'The Selected Posts were Successfully Locked.',
    'POSTS_MERGED_SUCCESS'       => 'The Selected Posts were Merged.',
    'POSTS_UNLOCKED_SUCCESS'     => 'The Selected Posts were Successfully Unlocked.',
    'POSTS_PER_PAGE'             => 'Posts Per Page',
    'POSTS_PER_PAGE_EXPLAIN'     => '(Set to 0 to View ALL Posts.)',
    'POST_APPROVED_SUCCESS'      => 'The Selected Post has been Approved.',
    'POST_DELETED_SUCCESS'       => 'The Selected Post has been Successfully Removed from the Database.',
    'POST_DISAPPROVED_SUCCESS'   => 'The Selected Post has been Disapproved.',
    'POST_LOCKED_SUCCESS'        => 'Post Successfully Locked.',
    'POST_NOT_EXIST'             => 'The Post you Requested DOES NOT Exist.',
    'POST_REPORTED_SUCCESS'      => 'This Post has been Successfully Reported.',
    'POST_UNLOCKED_SUCCESS'      => 'Post Successfully Unlocked.',

    'READ_USERNOTES'             => 'User Notes',
    'READ_WARNINGS'              => 'User Warnings',
    'REPORTER'                   => 'Reporter',
    'REPORTED'                   => 'Reported',
    'REPORTED_BY'                => 'Reported by',
    'REPORTED_ON_DATE'           => 'on',
    'REPORTS_CLOSED_SUCCESS'     => 'The Selected Reports were Closed Successfully.',
    'REPORTS_DELETED_SUCCESS'    => 'The Selected Reports were Deleted Successfully.',
    'REPORTS_TOTAL'              => 'In Total there are <strong>%d</strong> Reports to Review.',
    'REPORTS_ZERO_TOTAL'         => 'There are No Reports to Review.',
    'REPORT_CLOSED'              => 'This Report has already been Closed.',
    'REPORT_CLOSED_SUCCESS'      => 'The Selected Report was Closed Successfully.',
    'REPORT_DELETED_SUCCESS'     => 'The Selected Report was Deleted Successfully.',
    'REPORT_DETAILS'             => 'Report Details',
    'REPORT_MESSAGE'             => 'Report this Message',

    'REPORT_MESSAGE_EXPLAIN'     => 'Use this Form to Report the Selected Message.  Reporting should generally be used Only if the Message Breaks the Forum Rules.',

    'REPORT_NOTIFY'              => 'Notify me',
    'REPORT_NOTIFY_EXPLAIN'      => 'Informs you when your Report was Dealt with.',

    'REPORT_POST_EXPLAIN'        => 'Use this Form to Report the Selected Post to the Forum Moderators and Board Administrators. Reporting should generally be used Only if the Post Breaks the Forum Rules.',

    'REPORT_REASON'              => 'Report Reason',
    'REPORT_TIME'                => 'Report Time',
    'REPORT_TOTAL'               => 'In Total there is <strong>1</strong> Report to Review.',
    'RESYNC'                     => 'Resync',
    'RETURN_MESSAGE'             => '%sReturn to the Message%s',
    'RETURN_NEW_FORUM'           => '%sGo to the New Forum%s',
    'RETURN_NEW_TOPIC'           => '%sGo to the New Topic%s',
    'RETURN_POST'                => '%sReturn to the Post%s',
    'RETURN_QUEUE'               => '%sReturn to the Queue%s',
    'RETURN_REPORTS'             => '%sReturn to the Reports%s',
    'RETURN_TOPIC_SIMPLE'        => '%sReturn to the Topic%s',

    'SEARCH_POSTS_BY_USER'              => 'Search Posts by',
    'SELECT_ACTION'                     => 'Select Desired Action',
    'SELECT_FORUM_GLOBAL_ANNOUNCEMENT'  => 'Please Select the Forum you wish this Global Announcement to be Displayed in.',

    'SELECT_FORUM_GLOBAL_ANNOUNCEMENTS' => 'One or more of the Selected Topics are Global Announcements.  Please Select the Forum you wish these to be Displayed in.',

    'SELECT_MERGE'                => 'Select for Merge',
    'SELECT_TOPICS_FROM'          => 'Select Topics from',
    'SELECT_TOPIC'                => 'Select Topic',
    'SELECT_USER'                 => 'Select User',
    'SORT_ACTION'                 => 'Log Action',
    'SORT_DATE'                   => 'Date',
    'SORT_IP'                     => 'IP Address',
    'SORT_WARNINGS'               => 'Warnings',
    'SPLIT_AFTER'                 => 'Split Topic from Selected Post Onwards',
    'SPLIT_FORUM'                 => 'Forum for New Topic',
    'SPLIT_POSTS'                 => 'Split Selected Posts',
    'SPLIT_SUBJECT'               => 'New Topic Title',
    'SPLIT_TOPIC_ALL'             => 'Split Topic from Selected Posts',
    'SPLIT_TOPIC_ALL_CONFIRM'     => 'Are you sure you want to Split this Topic?',
    'SPLIT_TOPIC_BEYOND'          => 'Split Topic at Selected Post',
    'SPLIT_TOPIC_BEYOND_CONFIRM'  => 'Are you sure you want to Split this Topic at the Selected Post?',

    'SPLIT_TOPIC_EXPLAIN'         => 'Using the Form below you can Split a Topic in two, either by Selecting the Posts Individually or by Splitting at a Selected Post.',

    'THIS_POST_IP'                => 'IP for this Post',
    'TOPICS_APPROVED_SUCCESS'     => 'The Selected Topics were Approved.',
    'TOPICS_DELETED_SUCCESS'      => 'The Selected Topics were Successfully Removed from the Database.',
    'TOPICS_DISAPPROVED_SUCCESS'  => 'The Selected Topics were Disapproved.',
    'TOPICS_FORKED_SUCCESS'       => 'The Selected Topics were Successfully Copied.',
    'TOPICS_LOCKED_SUCCESS'       => 'The Selected Topics were Locked.',
    'TOPICS_MOVED_SUCCESS'        => 'The Selected Topics were Successfully Moved.',
    'TOPICS_RESYNC_SUCCESS'       => 'The Selected Topics were Resynchronised.',
    'TOPICS_TYPE_CHANGED'         => 'Topic Types Changed Successfully.',
    'TOPICS_UNLOCKED_SUCCESS'     => 'The Selected Topics were Unlocked.',
    'TOPIC_APPROVED_SUCCESS'      => 'The Selected Topic were Approved.',
    'TOPIC_DELETED_SUCCESS'       => 'The Selected Topic were Successfully Removed from the Database.',
    'TOPIC_DISAPPROVED_SUCCESS'   => 'The Selected Topic were Disapproved.',
    'TOPIC_FORKED_SUCCESS'        => 'The Selected Topic were Successfully Copied.',
    'TOPIC_LOCKED_SUCCESS'        => 'The Selected Topic were Locked.',
    'TOPIC_MOVED_SUCCESS'         => 'The Selected Topic were Successfully Moved.',
    'TOPIC_NOT_EXIST'             => 'The Topic you Selected DOES NOT Exist.',
    'TOPIC_RESYNC_SUCCESS'        => 'The Selected Topic has been Resynchronised.',
    'TOPIC_SPLIT_SUCCESS'         => 'The Selected Topic has been Split Successfully.',
    'TOPIC_TIME'                  => 'Topic Time',
    'TOPIC_TYPE_CHANGED'          => 'Topic Type Successfully Changed.',
    'TOPIC_UNLOCKED_SUCCESS'      => 'The Selected Topic has been Unlocked.',
    'TOTAL_WARNINGS'              => 'Total Warnings',

    'UNAPPROVED_POSTS_TOTAL'      => 'In Total there are <strong>%d</strong> Posts Waiting for Approval.',
    'UNAPPROVED_POSTS_ZERO_TOTAL' => 'There are No Posts Waiting for Approval.',
    'UNAPPROVED_POST_TOTAL'       => 'In Total there is <strong>1</strong> Post Waiting for Approval.',
    'UNLOCK'                      => 'Unlock',
    'UNLOCK_POST'                 => 'Unlock Post',
    'UNLOCK_POST_EXPLAIN'         => 'Allow Editing',
    'UNLOCK_POST_POST'            => 'Unlock Post',
    'UNLOCK_POST_POST_CONFIRM'    => 'Are you sure you want to Allow Editing of this Post?',
    'UNLOCK_POST_POSTS'           => 'Unlock Selected Posts',
    'UNLOCK_POST_POSTS_CONFIRM'   => 'Are you sure you want to Allow Editing of the Selected Posts?',
    'UNLOCK_TOPIC'                => 'Unlock Topic',
    'UNLOCK_TOPIC_CONFIRM'        => 'Are you sure you want to Unlock this Topic?',
    'UNLOCK_TOPICS'               => 'Unlock Selected Topics',
    'UNLOCK_TOPICS_CONFIRM'       => 'Are you sure you want to Unlock ALL Selected Topics?',
    'USER_CANNOT_POST'            => 'You can NOT Post in this Forum.',
    'USER_CANNOT_REPORT'          => 'You can NOT Report Posts in this Forum.',
    'USER_FEEDBACK_ADDED'         => 'User Feedback Successfully Added.',
    'USER_WARNING_ADDED'          => 'User Successfully Warned.',

    'VIEW_DETAILS'         => 'View Details',
    'VIEW_POST'            => 'View Post',
    'ALL_FORUMS'           => 'ALL Forums',
    'SELECT_FORUM'         => 'Select a Forum',
    'JUMP_TO'              => 'Jump to',
    'REASON'               => 'Reason',

    'WARNED_USERS'         => 'Warned Users',
    'WARNED_USERS_EXPLAIN' => 'This is a List of Users with Active Warnings.',

    'WARNING_PM_BODY'      => 'The following is a Warning which has been Issued to you by an Administrator or Moderator of this Site.[quote]%s[/quote]',

    'WARNING_PM_SUBJECT'   => 'Board Warning Issued',
    'WARNING_POST_DEFAULT' => 'This is a Warning regarding the following Post made by you: %s .',
    'WARNINGS_ZERO_TOTAL'  => 'No Warnings Exist.',

    'YOU_SELECTED_TOPIC'   => 'You Selected Topic Number %d: %s.',

    'report_reasons' => array(
        'TITLE' => array(
            'WAREZ'     => 'Warez',
            'SPAM'      => 'Spam',
            'OFF_TOPIC' => 'Off Topic',
            'OTHER'     => 'Other',
        ),

        'DESCRIPTION' => array(
            'WAREZ'     => 'The Post contains Links to Illegal or Pirated Software.',
            'SPAM'      => 'The Reported Post\'s ONLY purpose was to Advertise for a Website or another Product.',
            'OFF_TOPIC' => 'The Reported Post is Off Topic.',
            'OTHER'     => 'The Reported Post DOES NOT fit into any other Category.  Please use the further Information Field.',
        )
    ),
));

?>