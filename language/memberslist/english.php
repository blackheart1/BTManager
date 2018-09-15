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
** File memberlist/english.php 2018-09-14 20:59:00 Black_heart
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
    'GROUP_INFORMATION'         => '',
    'GROUP_NAME'                => 'Group Name',
    'GROUP_DESC'                => 'Group Description',
    'GROUP_AVAT'                => 'Group Avatar',
    'GROUP_MEMBERS'             => 'Group Members',
    'NO_GROUP_MEMBERS'          => 'No Group Members',
    'ABOUT_USER'                => 'Profile',
    'ACTIVE_IN_FORUM'           => 'Most Active Forum',
    'ACTIVE_IN_TOPIC'           => 'Most Active Topic',
    'ADD_FOE'                   => 'Add Foe',
    'ADD_FRIEND'                => 'Add Friend',
    'AFTER'                     => 'After',
    'ALL'                       => 'All',

    'BEFORE'                    => 'Before',

    'CC_EMAIL'                  => 'Send a Copy of this email to yourself.',
    'CONTACT_USER'              => 'Contact',

    'DEST_LANG'                 => 'Language',
    'DEST_LANG_EXPLAIN'         => 'Select an Appropriate Language (if available) for the Recipient of this Message.',

    'EMAIL_BODY_EXPLAIN'        => 'This Message will be Sent as Plain Text.  DO NOT include any HTML or BBCode.  The Return Address for this Message will be Set to your email Address.',

    'EMAIL_DISABLED'            => 'Sorry but ALL email Related Functions are currently Disabled.',
    'EMAIL_SENT'                => 'The email has been Sent.',

    'EMAIL_TOPIC_EXPLAIN'       => 'This Message will be Sent as Plain Text.  DO NOT include any HTML or BBCode.  Please Note that the Topic Information is already included in the Message.  The Return Address for this Message will be Set to your email Address.',

    'EMPTY_ADDRESS_EMAIL'       => 'You must Provide a Valid email Address for the Recipient.',
    'EMPTY_MESSAGE_EMAIL'       => 'You must Enter a Message to be emailed.',
    'EMPTY_MESSAGE_IM'          => 'You must Enter a Message to be Sent.',
    'EMPTY_NAME_EMAIL'          => 'You must Enter the Real Name of the Recipient.',
    'EMPTY_SUBJECT_EMAIL'       => 'You must Specify a Subject for the email.',
    'EQUAL_TO'                  => 'Equal to',

    'FIND_USERNAME_EXPLAIN'     => 'Use this Form to Search for Specific Members.  You DO NOT need to fill out all the fields.  To Match Partial Data use * as a Wildcard.  When Entering Dates use the Format <kbd>YYYY-MM-DD</kbd>, e.g. <em>2004-02-29</em>.  Use the Check Boxes to Select One or More Usernames (Several Usernames may be Accepted depending on the Form itself) and Click the "Select Marked Button" to Return to the Previous Form.',

    'FLOOD_EMAIL_LIMIT'         => 'You can NOT Send another email at this time.  Please try again later!',

    'GROUP_LEADER'              => 'Group Leader',
    'SORT_BY'                   => 'Sort by',
    'SORT_JOINED'               => 'Joined Date',
    'SORT_LOCATION'             => 'Location',
    'SORT_RANK'                 => 'Rank',
    'SORT_POSTS'                => 'Posts',
    'SORT_TOPIC_TITLE'          => 'Topic Title',
    'SORT_USERNAME'             => 'Username',
    'ICQ'                       => 'ICQ',
    'AIM'                       => 'AIM',
    'MSNM'                      => 'MSNM/WLM',
    'YIM'                       => 'YIM',
    'JABBER'                    => 'Jabber',
    'HIDE_MEMBER_SEARCH'        => 'Hide Member Search',
    'MEMBERLIST'                => 'Members',
    'DISPLAY'                   => 'Display',
    'TOTAL_POSTS'               => 'Total Posts',
    'EMAIL_ADDRESS'             => 'email Address',
    'USERGROUPS'                => 'Groups',
    'OCCUPATION'                => 'Occupation',
    'INTERESTS'                 => 'Interests',
    'WEBSITE'                   => 'Website',
    'SIGNATURE'                 => 'Signature',
    'POST_PCT'                  => '%.2f%% of ALL Posts',
    'POST_PCT_ACTIVE'           => '%.2f%% of User\'s Posts',
    'POST_PCT_ACTIVE_OWN'       => '%.2f%% of Your Posts',
    'USER_POST'                 => '%d Post',
    'USER_POSTS'                => '%d Posts',
    'POST_DAY'                  => '%.2f Posts Per Day',

    'IM_ADD_CONTACT'            => 'Add Contact',
    'IM_AIM'                    => 'Please Note that you need AOL Instant Messenger Installed to use this.',
    'IM_AIM_EXPRESS'            => 'AIM Express',
    'IM_DOWNLOAD_APP'           => 'Download Application',
    'IM_ICQ'                    => 'Please Note that Users may have Opted NOT to Receive Unsolicited Instant Messages.',
    'IM_JABBER'                 => 'Please Note that Users may have Opted NOT to Receive Unsolicited Instant Messages.',
    'IM_JABBER_SUBJECT'         => 'This is an Automated Message.  Please DO NOT Reply! Message from User %1$s at %2$s.',
    'IM_MESSAGE'                => 'Your Message',
    'IM_MSNM'                   => 'Please Note that you need Windows Messenger Installed to use this.',
    'IM_MSNM_BROWSER'           => 'Your Browser DOES NOT Support this.',
    'IM_MSNM_CONNECT'           => 'MSNM is NOT Connected.\nYou have to Connect to MSNM to Continue.',
    'IM_NAME'                   => 'Your Name',
    'IM_NO_DATA'                => 'There are NO Suitable Contact Details Available for this User.',

    'IM_NO_JABBER'              => 'Sorry.  Direct Messaging of Jabber Users is NOT Supported on this Board.  You will need a Jabber Client Installed on your System to Contact the Recipient above.',

    'IM_RECIPIENT'              => 'Recipient',
    'IM_SEND'                   => 'Send Message',
    'IM_SEND_MESSAGE'           => 'Send Message',
    'IM_SENT_JABBER'            => 'Your Message to %1$s was Successfully Sent.',
    'IM_USER'                   => 'Send an Instant Message',

    'LAST_ACTIVE'               => 'Last Active',
    'LAST_LOGIN'                => 'Last Login',
    'LESS_THAN'                 => 'Less than',
    'LIST_USER'                 => '1 User',
    'LIST_USERS'                => '%d Users',
    'LOGIN_EXPLAIN_LEADERS'     => 'The Board Requires you to be Registered and Logged In to View the Team Listing.',
    'LOGIN_EXPLAIN_MEMBERLIST'  => 'The Board Requires you to be Registered and Logged In to Access the Member List.',
    'LOGIN_EXPLAIN_SEARCHUSER'  => 'The Board Requires you to be Registered and Logged In to Search Users.',
    'LOGIN_EXPLAIN_VIEWPROFILE' => 'The Board Requires you to be Registered and Logged In to View Profiles.',

    'MORE_THAN'                 => 'More than',

    'NO_EMAIL'                  => 'You are NOT Authorised to Send emails to this User.',
    'NO_VIEW_USERS'             => 'You are NOT Authorised to View the Member List or Profiles.',

    'ORDER'                     => 'Order',
    'OTHER'                     => 'Other',

    'POST_IP'                   => 'Posted from IP/Domain',

    'REAL_NAME'                 => 'Recipient Name',
    'RECIPIENT'                 => 'Recipient',
    'REMOVE_FOE'                => 'Remove Foe',
    'REMOVE_FRIEND'             => 'Remove Friend',

    'SELECT_MARKED'             => 'Select Marked',
    'SELECT_SORT_METHOD'        => 'Select Sort Method',
    'SEND_AIM_MESSAGE'          => 'Send AIM Message',
    'SEND_ICQ_MESSAGE'          => 'Send ICQ Message',
    'SEND_IM'                   => 'Instant Messaging',
    'SEND_JABBER_MESSAGE'       => 'Send Jabber Message',
    'SEND_MESSAGE'              => 'Message',
    'SEND_MSNM_MESSAGE'         => 'Send MSNM/WLM Message',
    'SEND_YIM_MESSAGE'          => 'Send YIM Message',
    'SORT_EMAIL'                => 'email',
    'SORT_LAST_ACTIVE'          => 'Last Active',
    'SORT_POST_COUNT'           => 'Post Count',

    'USERNAME_BEGINS_WITH'      => 'Username begins with',
    'USER_ADMIN'                => 'Administer User',
    'USER_BAN'                  => 'Banning',
    'USER_FORUM'                => 'User Statistics',
    'USER_ONLINE'               => 'Online',
    'USER_PRESENCE'             => 'Board Presence',

    'VIEWING_PROFILE'           => 'Viewing Profile - %s',

    'WWW'                       => 'Website',
    'ACTIVATE'                  => 'Activate',
    'REMIND'                    => 'Remind',
    'SEND_EMAIL'                => 'email',             // Used for Submit Buttons
    'NO_USER'                   => 'No Matches Found.',
    'NO_TOPIC'                  => 'The Requested Topic does NOT Exist.',
    'SORRY_AUTH_READ'           => 'You Are NOT Authorised to Read this Forum.',
    'FORM_INVALID'              => 'The Submitted Form was Invalid.  Try Submitting Again!',
    'PRIMARY_GROUP'             => 'Primary Group',
    'FORUMS'                    => 'Forum\'s',
    'ALL_FORUMS'                => 'All Forum\'s',
    'RANK'                      => 'Rank',

    'GROUP_DISC_OWNER'          => 'Site Creator and Owner',
    'GROUP_DISC_GUEST'          => 'Default Group for Not Logged in Users',
    'GROUP_DISC_ADMIN'          => 'High Level Staff - will help with any problems',
    'GROUP_DISC_MODS'           => 'Moderators - will help where they can',
    'GROUP_DISC_PREM'           => 'VIP - for Donors and those who have helped the Site in some way',
    'GROUP_DISC_USER'           => 'User Class - everyone has to start somewhere',

    'USER_LAST_REMINDED' => array(
        0 => 'No Reminder was Sent at this time',
        1 => '%1$d Reminder Sent<br />%2$s',
    ),
));

?>