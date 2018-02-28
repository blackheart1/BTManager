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
** File acp_forum/english.php 2018-02-27 19:23:00 Thor
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
                <p>If you arrived at this page after you used an old Boomark or Favorite, the page in question has probably been moved. Try locating the page via the navigation menu and then update your bookmarks.</p>
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
    'AUTO_PRUNE_DAYS_EXPLAIN'          => 'Number of Days since last Post after which the Topic is Removed.',
    'AUTO_PRUNE_FREQ'                  => 'Auto Prune Frequency',
    'AUTO_PRUNE_FREQ_EXPLAIN'          => 'Time in Days between Pruning Events.',
    'AUTO_PRUNE_VIEWED'                => 'Auto Prune Post Viewed Age',
    'AUTO_PRUNE_VIEWED_EXPLAIN'        => 'Number of Days since Topic was Viewed after which the Topic is Removed.',
    'COPY_PERMISSIONS'                 => 'Copy Permissions From',
    'COPY_PERMISSIONS_EXPLAIN'         => 'To make things easy when Setting up your New Forum, you can Copy the Permissions of an Existing Forum.',

    'COPY_PERMISSIONS_ADD_EXPLAIN'     => 'Once Created, the Forum will have the same Permissions as the one you select here. If No Forum is Selected the Newly Created Forum will NOT be Visible until Permissions had been Set.',

    'COPY_PERMISSIONS_EDIT_EXPLAIN'    => 'If you Select to Copy Permissions, the Forum will have the same Permissions as the one you select here. This will Overwrite any Permissions you have Previously Set for this Forum with the Permissions of the Forum you select here. If NO Forum is Selected the Current Permissions will be kept.',

    'COPY_TO_ACL'                      => 'Alternatively, you are also able to %sSetup New Permissions%s for this Forum.',
    'CREATE_FORUM'                     => 'Create New Forum',
    'DECIDE_MOVE_DELETE_CONTENT'       => 'Delete Content or Move to Forum',
    'DECIDE_MOVE_DELETE_SUBFORUMS'     => 'Delete Sub Forums or Move to Forum',
    'DEFAULT_STYLE'                    => 'Default Style',
    'DELETE_ALL_POSTS'                 => 'Delete Posts',
    'DELETE_SUBFORUMS'                 => 'Delete Sub-Forums and Posts',
    'DISPLAY_ACTIVE_TOPICS'            => 'Enable Active Topics',
    'DISPLAY_ACTIVE_TOPICS_EXPLAIN'    => 'If set to Yes Active Topics in Selected Sub Forums will be Displayed under this Category.',

    'SETTING_TOO_LOW'                  => 'The Provided Value for the Setting "%1$s" is Too Low. The Minimum Acceptable Value is %2$d.',

    'SETTING_TOO_BIG'                  => 'The Provided Value for the Setting "%1$s" is Too High. The Maximum Acceptable Value is %2$d.',

    'SETTING_TOO_LONG'                 => 'The Provided Value for the Setting "%1$s" is Too Long. The Maximum Acceptable Length is %2$d.',

    'SETTING_TOO_SHORT'                => 'The Provided Value for the Setting "%1$s" is Too Short. The Minimum Acceptable Length is %2$d.',

    'EDIT_FORUM'                       => 'Edit Forum',
    'ENABLE_INDEXING'                  => 'Enable Search Indexing',
    'ENABLE_INDEXING_EXPLAIN'          => 'If Set to Yes Posts made to this Forum will be Indexed for Searching.',
    'ENABLE_POST_REVIEW'               => 'Enable Post Review',
    'ENABLE_POST_REVIEW_EXPLAIN'       => 'If Set to Yes Users are able to Review their Post, if New Posts were made to the Topic while Users wrote theirs. This should be Disabled for Chat Forums.',

    'ENABLE_QUICK_REPLY'               => 'Enable Quick Reply',
    'ENABLE_QUICK_REPLY_EXPLAIN'       => 'Enables the Quick Reply in this Forum. This Setting is NOT considered if the Quick Reply is Disabled Site Wide. The Quick Reply will ONLY be displayed for Users who have Permission to Post in this Forum.',

    'ENABLE_RECENT'                    => 'Display Active Topics',
    'ENABLE_RECENT_EXPLAIN'            => 'If Set to Yes Topics made to this Forum will be shown in the Active Topics List.',
    'ENABLE_TOPIC_ICONS'               => 'Enable Topic Icons',

    'FORUM_ADMIN'                      => 'Forum Administration',
    'FORUM_ADMIN_EXPLAIN'              => 'In phpBB3 there are NO Categories, everything is Forum Based. Each Forum can have an Unlimited Number of Sub Forums and you can determine whether each may be Posted to or not (i.e. whether it Acts like an Old Category). Here you can Add, Edit, Delete, Lock, Unlock Individual Forums as well as Set certain Additional Controls. If your Posts and Topics have got out of Sync you can also Resynchronise a Forum. <strong>You need to Copy or Set appropriate Permissions for Newly Created Forums to have them Displayed.</strong>',

    'FORUM_AUTO_PRUNE'                 => 'Enable Auto Pruning',
    'FORUM_AUTO_PRUNE_EXPLAIN'         => 'Prunes the Forum of Topics. Set the Frequency/Age Parameters below.',
    'FORUM_CREATED'                    => 'Forum Created Successfully.',
    'FORUM_DATA_NEGATIVE'              => 'Pruning Parameters can NOT be Negative.',
    'FORUM_DESC_TOO_LONG'              => 'The Forum Description is Too Long, it must be less than 4000 Characters.',
    'FORUM_DELETE'                     => 'Delete Forum',
    'FORUM_DELETE_EXPLAIN'             => 'The Form below will allow you to Delete a Forum. If the Forum is Postable you are able to decide where you want to put ALL Topics (or Forums) it contained.',

    'FORUM_DELETED'                    => 'Forum Fully Deleted.',
    'FORUM_DESC'                       => 'Description',
    'FORUM_DESC_EXPLAIN'               => 'Any HTML Markup entered here will be displayed as is.',
    'FORUM_EDIT_EXPLAIN'               => 'The Form below will allow you to Customise this Forum. Please Note that Moderation and Post Count Controls are Set via Forum Permissions for each User or User Group.',

    'FORUM_IMAGE'                      => 'Forum Image',
    'FORUM_IMAGE_EXPLAIN'              => 'Location, Relative to the phpBB Root Directory, of an Additional Image to Associate with this Forum.',

    'FORUM_IMAGE_NO_EXIST'             => 'The Specified Forum Image Does NOT Exist',
    'FORUM_LINK_EXPLAIN'               => 'Full URL (including the Protocol, i.e.: <samp>http://</samp>) to the Destination Location that clicking this Forum will take the User, e.g.: <samp>http://www.phpbb.com/</samp>.',

    'FORUM_LINK_TRACK'                 => 'Track Link Redirects',
    'FORUM_LINK_TRACK_EXPLAIN'         => 'Records the Number of Times a Forum Link was Clicked.',
    'FORUM_NAME'                       => 'Forum Name',
    'FORUM_NAME_EMPTY'                 => 'You Must enter a Name for this Forum.',
    'FORUM_PARENT'                     => 'Parent Forum',
    'FORUM_PASSWORD'                   => 'Forum Password',
    'FORUM_PASSWORD_CONFIRM'           => 'Confirm Forum Password',
    'FORUM_PASSWORD_CONFIRM_EXPLAIN'   => 'Only needs to be Set if a Forum Password is entered.',
    'FORUM_PASSWORD_EXPLAIN'           => 'Defines a Password for this Forum, use the Permission System in Preferences.',
    'FORUM_PASSWORD_UNSET'             => 'Remove Forum Password',
    'FORUM_PASSWORD_UNSET_EXPLAIN'     => 'Check Here if you want to Remove the Forum Password.',
    'FORUM_PASSWORD_OLD'               => 'The Forum Password is using an Old Hashing Method and should be changed.',
    'FORUM_PASSWORD_MISMATCH'          => 'The Passwords you entered DID NOT Match.',
    'FORUM_PRUNE_SETTINGS'             => 'Forum Prune Settings',
    'FORUM_RESYNCED'                   => 'Forum "%s" Successfully Resynced',
    'FORUM_RULES_EXPLAIN'              => 'Forum Rules are Displayed on any Page within the given Forum.',
    'FORUM_RULES_LINK'                 => 'Link to Forum Rules',
    'FORUM_RULES_LINK_EXPLAIN'         => 'You are able to enter the URL of the Page/Post containing your Forum Rules here. This Setting will Override the Forum Rules text you specified.',

    'FORUM_RULES_PREVIEW'              => 'Forum Rules Preview',
    'FORUM_RULES_TOO_LONG'             => 'The Forum Rules must be less than 4000 Characters.',
    'FORUM_SETTINGS'                   => 'Forum Settings',
    'FORUM_STATUS'                     => 'Forum Status',
    'FORUM_STYLE'                      => 'Forum Style',
    'FORUM_TOPICS_PAGE'                => 'Topics Per Page',
    'FORUM_TOPICS_PAGE_EXPLAIN'        => 'If Non Zero, this Value will Override the Default Topics Per Page Setting.',
    'FORUM_TYPE'                       => 'Forum Type',
    'FORUM_UPDATED'                    => 'Forum Information Updated Successfully.',
    'FORUM_WITH_SUBFORUMS_NOT_TO_LINK' => 'You want to change a Postable Forum having Sub Forums to a Link. Please Move ALL Sub Forums out of this Forum before you proceed, because after changing to a Link you will no longer able to see the Sub Forums currently connected to this Forum.',

    'GENERAL_FORUM_SETTINGS'           => 'General Forum Settings',
    'LINK'                             => 'Link',
    'LIST_INDEX'                       => 'List Sub Forum in Parent Forum\'s Legend',
    'LIST_INDEX_EXPLAIN'               => 'Displays this Forum on the Index and elsewhere as a Link within the Legend of its Parent Forum if the Parent Forum\'s "List Sub Forums in Legend" option is Enabled.',

    'LIST_SUBFORUMS'                   => 'List Sub Forums in Legend',
    'LIST_SUBFORUMS_EXPLAIN'           => 'Displays this Forum\'s Sub Forums on the Index and elsewhere as a Link within the Legend if their "List Sub Forum in Parent-Forum\'s Legend" option is Enabled.',

    'LOCKED'                           => 'Locked',
    'MOVE_POSTS_NO_POSTABLE_FORUM'     => 'The Forum you selected for Moving the Posts to is NOT Postable. Please Select a Postable Forum.',

    'MOVE_POSTS_TO'                    => 'Move Posts to',
    'MOVE_SUBFORUMS_TO'                => 'Move Sub Forums to',
    'NO_DESTINATION_FORUM'             => 'You have NOT specified a Forum to Move content to.',
    'NO_FORUM_ACTION'                  => 'NO Action Defined for what happens with the Forum Content.',
    'NO_PARENT'                        => 'NO Parent',
    'NO_PERMISSIONS'                   => 'DO NOT Copy Permissions',
    'NO_PERMISSION_FORUM_ADD'          => 'You DO NOT have the necessary Permissions to Add Forums.',
    'NO_PERMISSION_FORUM_DELETE'       => 'You DO NOT have the necessary Permissions to Delete Forums.',
    'PARENT_IS_LINK_FORUM'             => 'The Parent you Specified is a Forum Link. Link Forums are NOT able to hold other Forums, please Specify a Category or Forum as the Parent Forum.',

    'PARENT_NOT_EXIST'                 => 'Parent DOES NOT Exist.',
    'PRUNE_ANNOUNCEMENTS'              => 'Prune Announcements',
    'PRUNE_STICKY'                     => 'Prune Stickies',
    'PRUNE_OLD_POLLS'                  => 'Prune Old Polls',
    'PRUNE_OLD_POLLS_EXPLAIN'          => 'Removes Topics with Polls NOT Voted in for Post Age Days.',
    'REDIRECT_ACL'                     => 'Now you are able to %sSet Permissions%s for this Forum.',
    'SYNC_IN_PROGRESS'                 => 'Synchronizing Forum',
    'SYNC_IN_PROGRESS_EXPLAIN'         => 'Currently Resyncing Topic Range %1$d/%2$d.',
    'TYPE_CAT'                         => 'Category',
    'TYPE_FORUM'                       => 'Forum',
    'TYPE_LINK'                        => 'Link',

    'ACP_PRUNE_USERS_EXPLAIN'          => 'This Section allows you to Delete or Deactivate Users on your Site. Accounts can be filtered in a variety of ways; by Post Count, Most Recent Activity, etc. Criteria may be combined to narrow down which accounts are affected. For example, you can Prune Users with fewer than 10 Posts, who were also Inactive After 2002-01-01. Alternatively, you may skip the criteria selection completely by entering a List of Users (each on a separate line) into the text field. Take care with this facility! Once a User is Deleted, there is NO Way to reverse the action.',

    'DEACTIVATE_DELETE'                => 'Deactivate or Delete',
    'DEACTIVATE_DELETE_EXPLAIN'        => 'Choose whether to Deactivate Users or Delete them entirely. Please Note that Deleted Users Cannot be Restored!',

    'DELETE_USERS'                     => 'Delete',
    'DELETE_USER_POSTS'                => 'Delete Pruned User Posts',
    'DELETE_USER_POSTS_EXPLAIN'        => 'Removes Posts made by Deleted Users, has NO effect if Users are Deactivated.',
    'JOINED_EXPLAIN'                   => 'Enter a Date in <kbd>YYYY-MM-DD</kbd> Format.',
    'LAST_ACTIVE_EXPLAIN'              => 'Enter a Date in <kbd>YYYY-MM-DD</kbd> Format. Enter <kbd>0000-00-00</kbd> to Prune Users who Never Logged In, <em>Before</em> and <em>After</em> conditions will be Ignored.',

    'PRUNE_USERS_LIST'                 => 'Users to be Pruned',
    'PRUNE_USERS_LIST_DELETE'          => 'With the Selected Criteria for Pruning Users the following Accounts will be Removed.',
    'PRUNE_USERS_LIST_DEACTIVATE'      => 'With the Selected Criteria for Pruning Users the following Accounts will be Deactivated.',

    'SELECT_USERS_EXPLAIN'             => 'Enter Specific Usernames here, they will be used in preference to the criteria above. Founders cannot be pruned.',

    'USER_DEACTIVATE_SUCCESS'          => 'The Selected Users have been Deactivated Successfully.',
    'USER_DELETE_SUCCESS'              => 'The Selected Users have been Deleted Successfully.',
    'USER_PRUNE_FAILURE'               => 'NO Users Matched the Selected Criteria.',
    'WRONG_ACTIVE_JOINED_DATE'         => 'The Date entered is wrong, it is expected in <kbd>YYYY-MM-DD</kbd> Format.',
    'ACP_PRUNE_FORUMS'                 => 'Prune Forums',
    'ALL_FORUMS'                       => 'All Forums',
    'ACP_PRUNE_FORUMS_EXPLAIN'         => 'This will Delete any Topic which has NOT been Posted to or Viewed within the Number of Days you select. If you DO NOT enter a Number then ALL Topics will be Deleted. By Default, it will NOT Remove Topics in which Polls are still running nor will it Remove Stickies or Announcements.',

    'LOOK_UP_FORUM'                    => 'Select a Forum',
    'LOOK_UP_FORUMS_EXPLAIN'           => 'You can Select more than one Forum.',
    'FORUM_PRUNE'                      => 'Forum Prune',
    'NO_PRUNE'                         => 'No Forums Pruned.',
    'SELECTED_FORUM'                   => 'Selected Forum',
    'SELECTED_FORUMS'                  => 'Selected Forums',
    'POSTS_PRUNED'                     => 'Posts Pruned',
    'PRUNE_ANNOUNCEMENTS'              => 'Prune Announcements',
    'PRUNE_FINISHED_POLLS'             => 'Prune Closed Polls',
    'PRUNE_FINISHED_POLLS_EXPLAIN'     => 'Removes Topics with Polls which have Ended.',
    'PRUNE_FORUM_CONFIRM'              => 'Are you sure you want to Prune the Selected Forums with the Settings Specified? Once Removed, there is NO Way to Recover the Pruned Posts and Topics.',

    'PRUNE_NOT_POSTED'                 => 'Days Since Last Posted',
    'PRUNE_NOT_VIEWED'                 => 'Days Since Last Viewed',
    'PRUNE_OLD_POLLS'                  => 'Prune Old Polls',
    'PRUNE_OLD_POLLS_EXPLAIN'          => 'Removes Topics with Polls NOT Voted in for Post Age Days.',
    'PRUNE_STICKY'                     => 'Prune Stickies',
    'PRUNE_SUCCESS'                    => 'Pruning of Forums was Successful.',
    'TOPICS_PRUNED'                    => 'Topics Pruned',
));

?>