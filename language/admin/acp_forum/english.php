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
** File acp_forum/english.php 2018-09-14 09:05:00 Thor
**
** CHANGES
**
** 2018-02-21 - Added New Masthead
** 2018-02-21 - Added New !defined('IN_PMBT')
** 2018-02-21 - Fixed Spelling
** 2018-03-26 - Amended !defined('IN_PMBT')
** 2018-03-26 - Amended the Wording of some Sentences
** 2018-03-28 - Amended !defined('IN_PMBT') Corrected Path
** 2018-05-22 - Added Missing Language
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
    'FORUM_INDEX'                      => 'Board Index',
    'SELECT_FORUM'                     => 'Select a Forum',
    'FORUM_MANAGE'                     => 'Manage Forums',
    'FORUM_CONF'                       => 'Forum Configuration',
    'FORUMS_PRUNE'                     => 'Prune Forums',
    'FORUMS_USER_PERM'                 => 'Users Forum Permissions',
    'FORUMS_GROUP_PERM'                => 'Groups Forum Permissions',
    'FORUMS_PERMISSIONS'               => 'Forum Permissions',
    'FORUMS_MODERATORS'                => 'Forum Moderators',
    'FORUM_BASD_PERM'                  => 'Forum Based Permissions',
    'FORUM_RULES'                      => 'Forum Rules',
    'PARSE_BBCODE'                     => 'Parse BBCode',
    'PARSE_SMILIES'                    => 'Parse Smilies',
    'PARSE_URLS'                       => 'Parse Links',
    'RESYNC'                           => 'Resynchronise',
    'AUTO_PRUNE_DAYS'                  => 'Auto Prune Post Age',
    'AUTO_PRUNE_DAYS_EXPLAIN'          => 'Number of Days since Last Post, after which the Topic is Removed.',
    'AUTO_PRUNE_FREQ'                  => 'Auto Prune Frequency',
    'AUTO_PRUNE_FREQ_EXPLAIN'          => 'Time in Days between Pruning Events.',
    'AUTO_PRUNE_VIEWED'                => 'Auto Prune Post Viewed Age',
    'AUTO_PRUNE_VIEWED_EXPLAIN'        => 'Number of Days since Topic was Viewed, after which the Topic is Removed.',
    'COPY_PERMISSIONS'                 => 'Copy Permissions From',
    'COPY_PERMISSIONS_EXPLAIN'         => 'To make things Easy when Setting up your New Forum, you can Copy the Permissions of an Existing Forum.',

    'COPY_PERMISSIONS_ADD_EXPLAIN'     => 'Once Created, the Forum will have the same Permissions as the one you select here.  If No Forum is Selected, the Newly Created Forum will NOT be Visible until Permissions had been Set.',

    'COPY_PERMISSIONS_EDIT_EXPLAIN'    => 'If you Select to Copy Permissions, the Forum will have the same Permissions as the one you Select Here.  This will Overwrite any Permissions you have Previously Set for this Forum with the Permissions of the Forum you Select Here.  If NO Forum is Selected the Current Permissions will be kept.',

    'COPY_TO_ACL'                      => 'Alternatively, you are also able to Setup New Permissions for this Forum.',
    'CREATE_FORUM'                     => 'Create New Forum',
    'DECIDE_MOVE_DELETE_CONTENT'       => 'Delete Content or Move to Forum',
    'DECIDE_MOVE_DELETE_SUBFORUMS'     => 'Delete Sub Forums or Move to Forum',
    'DEFAULT_STYLE'                    => 'Default Style',
    'DELETE_ALL_POSTS'                 => 'Delete Posts',
    'DELETE_SUBFORUMS'                 => 'Delete Sub-Forums and Posts',
    'DISPLAY_ACTIVE_TOPICS'            => 'Enable Active Topics',

    'DISPLAY_ACTIVE_TOPICS_EXPLAIN'    => 'If Set to YES then any Active Topics in the Selected Sub Forums will be Displayed under this Category.',

    'SETTING_TOO_LOW'                  => 'The Provided Value for this Setting <em>%1$s</em> is Too Low.  The Minimum Acceptable Value is <em>%2$d</em>.',

    'SETTING_TOO_BIG'                  => 'The Provided Value for this Setting <em>%1$s</em> is Too High.  The Maximum Acceptable Value is <em>%2$d</em>.',

    'SETTING_TOO_LONG'                 => 'The Provided Value for this Setting <em>%1$s</em> is Too Long.  The Maximum Acceptable Length is <em>%2$d</em>.',

    'SETTING_TOO_SHORT'                => 'The Provided Value for this Setting <em>%1$s</em> is Too Short.  The Minimum Acceptable Length is <em>%2$d</em>.',

    'EDIT_FORUM'                       => 'Edit Forum',
    'ENABLE_INDEXING'                  => 'Enable Search Indexing',
    'ENABLE_INDEXING_EXPLAIN'          => 'If Set to YES then any Posts made to this Forum will be Indexed for Searching.',
    'ENABLE_POST_REVIEW'               => 'Enable Post Review',
    'ENABLE_POST_REVIEW_EXPLAIN'       => 'If Set to YES then Users are able to Review their Post, if New Posts were made to the Topic while Users wrote theirs.  This should be Disabled for Chat Forums.',

    'ENABLE_QUICK_REPLY'               => 'Enable Quick Reply',
    'ENABLE_QUICK_REPLY_EXPLAIN'       => 'Enables the Quick Reply in this Forum.  This Setting is NOT considered if the Quick Reply is Disabled Site Wide. The Quick Reply will ONLY be displayed for Users who have Permission to Post in this Forum.',

    'ENABLE_RECENT'                    => 'Display Active Topics',
    'ENABLE_RECENT_EXPLAIN'            => 'If Set to YES then any Topics made to this Forum will be Shown in the Active Topics List.',

    'ENABLE_TOPIC_ICONS'               => 'Enable Topic Icons',

    'FORUM_ADMIN'                      => 'Forum Administration',

    'FORUM_ADMIN_EXPLAIN'              => 'In phpBB3 there are NO Categories, everything is Forum Based.  Each Forum can have an Unlimited Number of Sub-Forums and, you can determine whether each may be Posted TO or NOT (i.e. whether it Acts like an Old Category).  Here you can Add, Edit, Delete, Lock, Unlock Individual Forums as well as Set certain Additional Controls.  If your Posts and Topics have got out of Sync you can also Resynchronise a Forum.<br /><strong>You will need to Copy or Set Appropriate Permissions for Newly Created Forums to have them Displayed.</strong><br /><br />',

    'FORUM_AUTO_PRUNE'                 => 'Enable Auto Pruning',
    'FORUM_AUTO_PRUNE_EXPLAIN'         => 'Prunes the Forum of Topics.  Set the Frequency/Age Parameters below.',
    'FORUM_CREATED'                    => 'Forum Created Successfully.',
    'FORUM_DATA_NEGATIVE'              => 'Pruning Parameters can NOT be Negative.',
    'FORUM_DESC_TOO_LONG'              => 'The Forum Description is Too Long, it must be less than 4000 Characters.',
    'FORUM_DELETE'                     => 'Delete Forum',

    'FORUM_DELETE_EXPLAIN'             => 'The Form below will Allow you to Delete a Forum.  If the Forum is Postable you will be able to decide where you want to put ALL Topics (or Forums) it contained.<br /><br />',

    'FORUM_DELETED'                    => 'Forum Fully Deleted.',
    'FORUM_DESC'                       => 'Description',

    'FORUM_DESC_EXPLAIN'               => 'Any HTML Markup Entered Here will be Displayed as is.',

    'FORUM_EDIT_EXPLAIN'               => 'The Form below will Allow you to Customise this Forum.  Please Note that Moderation and Post Count Controls are Set via Forum Permissions for each User or User Group.<br /><br />',

    'FORUM_IMAGE'                      => 'Forum Image',

    'FORUM_IMAGE_EXPLAIN'              => 'Enter the Location, Relative to the BTManager Root Directory, for the Image you\'d like to Associate with this Forum.',

    'FORUM_IMAGE_NO_EXIST'             => 'The Specified Forum Image DOES NOT Exist',
    'WARNING'                          => 'WARNING',
    'FORUM_LINK'                       => 'PLACEHOLDER PLACEHOLDER PLACEHOLDER',

    'FORUM_LINK_EXPLAIN'               => 'Full URL (including the Protocol, i.e.: <em>http://</em>) to the Destination Location that Clicking this Forum will take the User, e.g.: <em>http://www.phpbb.com/</em>.',

    'FORUM_LINK_TRACK'                 => 'Track Link Redirects',
    'FORUM_LINK_TRACK_EXPLAIN'         => 'Records the Number of Times a Forum Link is Clicked.',
    'FORUM_NAME'                       => 'Forum Name',
    'FORUM_NAME_EMPTY'                 => 'You Must Enter a Name for this Forum.',
    'FORUM_PARENT'                     => 'Parent Forum',
    'FORUM_PASSWORD'                   => 'Forum Password',
    'FORUM_PASSWORD_CONFIRM'           => 'Confirm Forum Password',
    'FORUM_PASSWORD_CONFIRM_EXPLAIN'   => 'Only needs to be Set if a Forum Password is entered.',
    'FORUM_PASSWORD_EXPLAIN'           => 'Defines a Password for this Forum, use the Permission System in Preferences.',
    'FORUM_PASSWORD_UNSET'             => 'Remove Forum Password',
    'FORUM_PASSWORD_UNSET_EXPLAIN'     => 'Check Here if, you want to Remove the Forum Password.',
    'FORUM_PASSWORD_OLD'               => 'The Forum Password is using an OLD Hashing Method and Should be Changed.',
    'FORUM_PASSWORD_MISMATCH'          => 'The Passwords you Entered DID NOT Match.',
    'FORUM_PRUNE_SETTINGS'             => 'Forum Prune Settings',
    'NOTIFY'                           => 'SUCCESSFUL',
    'FORUM_RESYNCED'                   => 'Forum (%s) Successfully Resynced  ',
    'FORUM_RULES_EXPLAIN'              => 'Forum Rules are Displayed on any Page within the given Forum.',
    'FORUM_RULES_LINK'                 => 'Link to Forum Rules',

    'FORUM_RULES_LINK_EXPLAIN'         => 'Here you are able to Enter the URL of the Page/Post Containing your Forum Rules. This Setting will Override the Forum Rules Text you Specified.',

    'FORUM_RULES_PREVIEW'              => 'Forum Rules Preview',
    'FORUM_RULES_TOO_LONG'             => 'The Forum Rules Must be Less than 4000 Characters.',
    'FORUM_SETTINGS'                   => 'Forum Settings',
    'FORUM_STATUS'                     => 'Forum Status',
    'FORUM_STYLE'                      => 'Forum Style',
    'FORUM_TOPICS_PAGE'                => 'Topics Per Page',
    'FORUM_TOPICS_PAGE_EXPLAIN'        => 'This Value will Override the Default Topics Per Page Setting, unless it\'s Set to Zero.',
    'FORUM_TYPE'                       => 'Forum Type',
    'FORUM_UPDATED'                    => 'Forum Information Updated Successfully.',

    'FORUM_WITH_SUBFORUMS_NOT_TO_LINK' => 'If you want to Change a Postable Forum having Sub-Forums to a Link then, please Move ALL Sub-Forums Out of this Forum before you proceed.  Once it\'s Changed to a Link you will NO Longer able to see the Sub -Forums Currently Connected to this Forum.',

    'GENERAL_FORUM_SETTINGS'           => 'General Forum Settings',
    'LINK'                             => 'Link',
    'LIST_INDEX'                       => 'List Sub-Forum in Parent Forum\'s Legend',

    'LIST_INDEX_EXPLAIN'               => 'Displays this Forum on the Index Page and elsewhere as a Link within the Legend of its Parent Forum, Only if the "List Sub-Forum in Parent Forum\'s Legend" Option is Enabled.',

    'LIST_SUBFORUMS'                   => 'List Sub-Forums in Legend',

    'LIST_SUBFORUMS_EXPLAIN'           => 'Displays this Forum\'s Sub-Forums on the Index Page and elsewhere as a Link within the Legend, Only if the "List Sub-Forum in Parent Forum\'s Legend" Option is Enabled.',

    'LOCKED'                           => 'Locked',

    'MOVE_POSTS_NO_POSTABLE_FORUM'     => 'The Forum you Selected for Moving the Posts to is NOT Postable.  Please Select a Postable Forum.',

    'MOVE_POSTS_TO'                    => 'Move Posts to',
    'MOVE_SUBFORUMS_TO'                => 'Move Sub-Forums to',
    'NO_DESTINATION_FORUM'             => 'You have NOT specified a Forum to Move Content to.',
    'NO_FORUM_ACTION'                  => 'No Action Defined for what happens with the Forum Content.',
    'NO_PARENT'                        => 'No Parent',
    'NO_PERMISSIONS'                   => 'DO NOT Copy Permissions',
    'NO_PERMISSION_FORUM_ADD'          => 'You DO NOT have the Required Permissions to Add Forums.',
    'NO_PERMISSION_FORUM_DELETE'       => 'You DO NOT have the Required Permissions to Delete Forums.',

    'PARENT_IS_LINK_FORUM'             => 'The Parent you Specified is a Forum Link.  Link Forums are NOT able to Hold Other Forums.  Please Specify a Category or Forum as the Parent Forum.',

    'PARENT_NOT_EXIST'                 => 'Parent DOES NOT Exist.',
    'PRUNE_ANNOUNCEMENTS'              => 'Prune Announcements',
    'PRUNE_STICKY'                     => 'Prune Stickies',
    'PRUNE_OLD_POLLS'                  => 'Prune Old Polls',
    'PRUNE_OLD_POLLS_EXPLAIN'          => 'Removes Topics with Polls NOT Voted on for Post Age Days.',
    'REDIRECT_ACL'                     => 'Now you are able to Set Permissions for this Forum.',
    'SYNC_IN_PROGRESS'                 => 'Synchronizing Forum',
    'SYNC_IN_PROGRESS_EXPLAIN'         => 'Currently Resyncing Topic Range %1$d/%2$d.',
    'TYPE_CAT'                         => 'Category',
    'TYPE_FORUM'                       => 'Forum',
    'TYPE_LINK'                        => 'Link',
    '_admpallow_forum_notify'          => 'Allow Subscribing to Forums',
    '_admpallow_forum_notifyexplain'   => '',
    '_admpallow_topic_notify'          => 'Allow Subscribing to Topics',
    '_admpallow_topic_notifyexplain'   => '',

    'ACP_PRUNE_USERS_EXPLAIN'          => 'This Section Allows you to Delete or Deactivate Users on your Site.  Accounts can be Filtered in a variety of ways; by Post Count, Most Recent Activity, etc.  Criteria may be combined to narrow down which Accounts are Affected.  For example, you can Prune Users with Fewer than 10 Posts, who were also Inactive After 2002-01-01.  Alternatively, you may Skip the Criteria Selection completely by Entering a List of Users (each on a Separate Line) into the Text Field.  Take Care with this Facility!  Once a User is Deleted, there is NO Way to Reverse the Action.',

    'DEACTIVATE_DELETE'                => 'Deactivate or Delete',
    'DEACTIVATE_DELETE_EXPLAIN'        => 'Choose whether to Deactivate Users or Delete them Entirely.  Please Note that Deleted Users can NOT be Restored!',

    'DELETE_USERS'                     => 'Delete',
    'DELETE_USER_POSTS'                => 'Delete Pruned User Posts',
    'DELETE_USER_POSTS_EXPLAIN'        => 'Removes Posts made by Deleted Users.  This has NO effect if Users are Deactivated.',
    'JOINED_EXPLAIN'                   => 'Enter a Date in <kbd>YYYY-MM-DD</kbd> Format.',

    'LAST_ACTIVE_EXPLAIN'              => 'Enter a Date in <kbd>YYYY-MM-DD</kbd> Format.  Enter <kbd>0000-00-00</kbd> to Prune Users who Never Logged In, <em>Before</em> and <em>After</em> Conditions will be Ignored.',

    'PRUNE_USERS_LIST'                 => 'Users to be Pruned',
    'PRUNE_USERS_LIST_DELETE'          => 'With the Selected Criteria for Pruning Users the Following Accounts will be Removed.',

    'PRUNE_USERS_LIST_DEACTIVATE'      => 'With the Selected Criteria for Pruning Users the Following Accounts will be Deactivated.',

    'SELECT_USERS_EXPLAIN'             => 'Enter Specific Usernames Here.  They will be used in Preference to the Criteria above. Founders can NOT be Pruned.',

    'USER_DEACTIVATE_SUCCESS'          => 'The Selected Users have been Deactivated Successfully.',
    'USER_DELETE_SUCCESS'              => 'The Selected Users have been Deleted Successfully.',
    'USER_PRUNE_FAILURE'               => 'No Users Matched the Selected Criteria.',
    'WRONG_ACTIVE_JOINED_DATE'         => 'The Date Entered is Incorrect, it is Expected in <kbd>YYYY-MM-DD</kbd> Format.',
    'ACP_PRUNE_FORUMS'                 => 'Prune Forums',
    'ALL_FORUMS'                       => 'All Forums',

    'ACP_PRUNE_FORUMS_EXPLAIN'         => 'This will Delete any Topic which has NOT been Posted to or Viewed within the Number of Days you Select.  If you DO NOT Enter a Number then ALL Topics will be Deleted.  By Default, it will NOT Remove Topics in which Polls are Still Running, nor will it Remove Stickies or Announcements.<br /><br />',

    'LOOK_UP_FORUM'                    => 'Select a Forum',
    'LOOK_UP_FORUMS_EXPLAIN'           => 'You can Select More than One Forum.',
    'FORUM_PRUNE'                      => 'Forum Prune',
    'NO_PRUNE'                         => 'No Forums Pruned.',
    'SELECTED_FORUM'                   => 'Selected Forum',
    'SELECTED_FORUMS'                  => 'Selected Forums',
    'POSTS_PRUNED'                     => 'Posts Pruned',
    'PRUNE_ANNOUNCEMENTS'              => 'Prune Announcements',
    'PRUNE_FINISHED_POLLS'             => 'Prune Closed Polls',
    'PRUNE_FINISHED_POLLS_EXPLAIN'     => 'Removes Topics with Polls which have Ended.',

    'PRUNE_FORUM_CONFIRM'              => 'Are you sure you want to Prune the Selected Forums with the Settings Specified?  Once Removed, there is NO Way to Recover the Pruned Posts and Topics.',

    'PRUNE_NOT_POSTED'                 => 'Days Since Last Posted',
    'PRUNE_NOT_VIEWED'                 => 'Days Since Last Viewed',
    'PRUNE_SUCCESS'                    => 'Successfully Pruned Forums',
    'TOPICS_PRUNED'                    => 'Topics Pruned',
));

    #3.0.1 Add-on
    // Word Censors
$lang = array_merge($lang, array(
    'ACP_WORDS'          => 'Word Censoring',

    'ACP_WORDS_EXPLAIN'  => 'From this Control Panel you can Add, Edit, and Remove Words that will be Automatically Censored on your Forums.  People are still Allowed to Register with Usernames Containing these Words.  Wildcards (*) are Accepted in the Word Field, e.g. *test* will Match Detestable, test* would Match Testing, *test would Match Detest.',

    'ACP_NO_ITEMS'       => 'There are No Items Yet.',
    'ADD_WORD'           => 'Add New Word',

    'EDIT_WORD'          => 'Edit Word Censor',
    'ENTER_WORD'         => 'You Must Enter a Word and its Replacement.',

    'NO_WORD'            => 'No Word Selected for Editing.',

    'REPLACEMENT'        => 'Replacement',

    'UPDATE_WORD'        => 'Update Word Censor',

    'WORD'               => 'Word',
    'WORD_ADDED'         => 'The Word Censor has been Successfully Added.',
    'WORD_REMOVED'       => 'The Selected Word Censor has been Successfully Removed.',
    'WORD_UPDATED'       => 'The Selected Word Censor has been Successfully Updated.',
    'MOVE_DOWN'          => 'Move Down',
    'MOVE_DOWN_DISABLED' => 'Move Down Disabled',
    'MOVE_UP'            => 'Move Up',
    'MOVE_UP_DISABLED'   => 'Move Up Disabled',
    'RESYNC'             => 'Resynchronise',
    'RESYNC_DISABLED'    => 'Resynchronise',
));

    #3.0.1 Add-on
    // Error Messages
$lang = array_merge($lang, array(
    'ERROR_TPP_NOT_N'           => 'Topics Per Page Not Numeric',
    'ERROR_TPP_NOT_SET'         => 'Topics Per Page Not Set',
    'ERROR_PPP_NOT_N'           => 'Posts Per Page Not Numeric',
    'ERROR_PPP_NOT_SET'         => 'Posts Per Page Not Set',
    'ERROR_MAX_POST_LEN'        => 'Maximum Post Length Not Numeric',
    'ERROR_MAX_POST_LEN_SET'    => 'Maximum Post Length Not Set',
    'ERROR_SEARCH_W_MIN_N'      => 'Search Word Minimum Not Numeric',
    'ERROR_SEARCH_W_MIN_SET'    => 'Search Word Minimum Not Set',
    'ERROR_FLOOD_INTER_N'       => 'Flood Intervals Not Numeric',
    'ERROR_FLOOD_INTER_SET'     => 'Flood Intervals Not Set',
    'ERROR_BUMP_INTER_N'        => 'Bump Intervals Not Numeric',
    'ERROR_BUMP_INTER_SET'      => 'Bump Intervals Not Set',
    'ERROR_IMG_LNG_W_N'         => 'Maximum Width Not Numeric',
    'ERROR_IMG_LNG_W_SET'       => 'Maximum Width Not Set',
    'ERROR_IMG_HGT_W_N'         => 'Maximum Height Not Numeric',
    'ERROR_IMG_HGT_W_SET'       => 'Maximum Height Not Set',
    'ERROR_MAX_FONT_N'          => 'Maximum Font Size Not Numeric',
    'ERROR_MAX_FONT_SET'        => 'Maximum Font Size Not Set',
    'ERROR_MAX_ATTACH_N'        => 'Maximum Number of Attachments Not Numeric',
    'ERROR_MAX_ATTACH_SET'      => 'Maximum Number of Attachments Not Set',
));
?>