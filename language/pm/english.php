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
** File pm/english.php 2018-08-29 07:44:00 Thor
**
** CHANGES
**
** 2018-03-02 - Added New Masthead
** 2018-03-02 - Added New !defined('IN_PMBT')
** 2018-03-02 - Fixed Spelling
** 2018-04-25 - Amended the Wording of some Sentences
** 2018-04-25 - Added Missing Languages
** 2018-07-11 - Added Missing Languages
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
    'ANONYMOUS'                  => '0',
    '_ASCENDING'                 => 'Ascending',
    '_DESCENDING'                => 'Descending',
    '_POST_TIME'                 => 'Post Time',
    'ALL_MESSAGES'               => 'All Messages',
    '_FILENAME'                  => 'Filename',
    '_FILE_COMMENT'              => 'File Comment',
    '_MISSING_INLINE_ATTACHMENT' => 'The Attachment <strong>%s</strong> is NO Longer Available',
    '_EXPAND_VIEW'               => 'Expand View',
    '_ATTACHMENTS'               => 'Attachments',
    '_EXTENSION'                 => 'Extension',

    '_EXTENSION_DISABLED_AFTER_POSTING' => 'The Extension <strong>%s</strong> has been Deactivated and can NO Longer be Displayed.',

    '_USERNAME'      => 'Username',
    '_USERNAMES'     => 'Usernames',
    '_ICON'          => 'Icon',
    '_BCC'           => 'BCC',
    '_FIND_USERNAME' => 'Find a Member',
    '_PREVIEW'       => 'Preview',
    '_CANCEL'        => 'Cancel',
    '_USERGROUPS'    => 'Groups',
    '_INDEX'         => 'Site Index',
    '_DELETE_MARKED' => 'Delete Marked',
    '_MESSAGE'       => 'Private Message',
    'PM_NOTICE_SUB'  => 'New Private Message on %1$s',

    '_ACCOUNT_ACTIVE'         => 'Your Account has been Activated.  Thank You for Registering.',
    '_ACCOUNT_ACTIVE_ADMIN'   => 'The Account has been Activated.',
    '_ACCOUNT_ACTIVE_PROFILE' => 'Your Account has been Successfully Reactivated.',

    '_ACCOUNT_ADDED'          => 'Thank you for Registering, your Account has now been Created.  You may now Login with your Username and Password.',

    '_ACCOUNT_COPPA'          => 'Your Account has been Created and is awaiting Staff Approval.  Please Check your email for further Information.',

    '_ACCOUNT_EMAIL_CHANGED'  => 'Your Account has been Updated.  However, the Board Requires you to Reactivate your Account to Verify that the New email Address is Valid.  An Activation Key has been sent to the New email Address you provided.  Please Check your email for further Information.',

    '_ACCOUNT_EMAIL_CHANGED_ADMIN' => 'Your Account has been Updated.  However, the Board Requires Account Reactivation by the Administrator Group for email Address changes.  An email has been sent to them and you will be informed when your Account has been Reactivated.',

    '_ACCOUNT_INACTIVE'       => 'Your Account has been Created.  However, the Board Requires Account Activation.  You have been sent a Key to the email Address you provided.  Please Check your email for further Information.',

    '_ACCOUNT_INACTIVE_ADMIN' => 'Your Account has been Created.  However, the Board Requires Account Activation by the Administrator Group.  An email has been sent to them and you will be informed when your Account has been Activated.',

    '_ACTIVATION_EMAIL_SENT'       => 'The Activation email has been sent to your email Address.',
    '_ACTIVATION_EMAIL_SENT_ADMIN' => 'The Activation email has been sent to the Administrators email Addresses.',
    '_POST_REPLY'                  => 'Reply',
    '_FOLDER'                      => 'Folder',
    '_AND'                         => 'and',
    '_CHANGE'                      => 'Change',
    '_REMOVE'                      => 'Remove',
    '_PREVIOUS_STEP'               => 'Previous',
    '_ADD'                         => 'Add',
    '_ADD_BCC'                     => 'Add [BCC]',
    '_ADD_FOES'                    => 'Add New Foes',
    '_ADD_FOES_EXPLAIN'            => 'You may Enter Several Usernames, each on a Separate Line.',
    '_ADD_FOLDER'                  => 'Add Folder',
    '_ADD_FRIENDS'                 => 'Add New Friends',
    '_ADD_FRIENDS_EXPLAIN'         => 'You may Enter Several Usernames, each on a Separate Line.',
    '_ADD_NEW_RULE'                => 'Add New Rule',
    '_ADD_RULE'                    => 'Add Rule',
    '_ADD_TO'                      => 'Add [To]',

    '_ADD_USERS_UCP_EXPLAIN'     => 'Here you can Add New Users to the Group.  You can Select whether this Group becomes the New Default for the Selected Users.  Please Enter each Username on a Separate Line.',

    '_ADMIN_EMAIL'                 => 'Administrators can email me Information',
    '_AGREE'                       => 'I Agree to these Terms',
    '_ALLOW_PM'                    => 'Allow Users to Send you Private Messages',
    '_ALLOW_PM_EXPLAIN'            => 'Note that Administrators and Moderators will always be able to Send you Messages.',
    '_ALREADY_ACTIVATED'           => 'Your Account is already Activated.',
    '_ATTACHMENTS_EXPLAIN'         => 'This is a List of Attachments you have made in Posts on this Board.',
    '_ATTACHMENTS_DELETED'         => 'Attachments Successfully Deleted.',
    '_ATTACHMENT_DELETED'          => 'Attachment Successfully Deleted.',
    '_AVATAR_CATEGORY'             => 'Category',
    '_AVATAR_EXPLAIN'              => 'Maximum Dimensions; Width: %1$d Pixels, Height: %2$d Pixels, File Size: %3$.2f KiB.',
    '_AVATAR_FEATURES_DISABLED'    => 'Sorry, but the Avatar Functionality is currently Disabled.',
    '_AVATAR_GALLERY'              => 'Local Gallery',
    '_AVATAR_GENERAL_UPLOAD_ERROR' => 'Could NOT Upload Avatar to %s.',
    '_AVATAR_NOT_ALLOWED'          => 'Your Avatar can NOT be Displayed because Avatars have been Disabled.',
    '_AVATAR_PAGE'                 => 'Page',
    '_AVATAR_TYPE_NOT_ALLOWED'     => 'Your Current Avatar can NOT be Displayed because it\'s File Type has been Disallowed.',

    '_NA'               => 'NA',
    '_SUBJECT'          => 'Subject',
    '_AUTHOR'           => 'Author',
    '_MARK'             => 'Mark',
    '_GO'               => 'Go',
    '_NO_MESSAGES'      => 'No Messages',

    'BACK_TO_DRAFTS'    => 'Back to Saved Drafts',
    '_BACK_TO_LOGIN'    => 'Back to Login Screen',
    '_BIRTHDAY'         => 'Birthday',
    '_BIRTHDAY_EXPLAIN' => 'Setting a Year will List your Age when it\'s your Birthday.',

    '_BOARD_DATE_FORMAT'         => 'My Date Format',

    '_BOARD_DATE_FORMAT_EXPLAIN' => 'The Syntax Used is Identical to the PHP <a href=\'http://www.php.net/date\'>date()</a> Function.',

    '_BOARD_DST'          => 'Summer Time/<abbr title=\'Daylight Saving Time\'>DST</abbr> is in effect',
    '_BOARD_LANGUAGE'     => 'My Language',
    '_BOARD_STYLE'        => 'My Board Style',
    '_BOARD_TIMEZONE'     => 'My Time Zone',

    '_BOOKMARKS'          => 'Bookmarks',

    '_BOOKMARKS_EXPLAIN'  => 'You can Bookmark Topics for Future Reference.  Select the Checkbox for any Bookmark you wish to Delete, then Press the <em>Remove Marked Bookmarks</em> Button.',

    '_BOOKMARKS_DISABLED' => 'Bookmarks are currently Disabled on this Board.',
    '_BOOKMARKS_REMOVED'  => 'Bookmarks Successfully Removed.',

    '_CANNOT_EDIT_MESSAGE_TIME'   => 'You can NO Longer Edit or Delete that Message.',
    '_CANNOT_MOVE_TO_SAME_FOLDER' => 'Messages can NOT be Moved to the Folder you want to Remove.',
    '_CANNOT_MOVE_FROM_SPECIAL'   => 'Messages can NOT be Moved from the Outbox.',
    '_CANNOT_RENAME_FOLDER'       => 'This Folder can NOT be Renamed.',
    '_CANNOT_REMOVE_FOLDER'       => 'This folder can NOT be Removed.',
    '_CHANGE_DEFAULT_GROUP'       => 'Change Default Group',
    '_CHANGE_PASSWORD'            => 'Change Password',
    '_CLICK_RETURN_FOLDER'        => '%1$sReturn to your "%3$s" folder%2$s',

    '_CONFIRMATION'             => 'Confirmation of Registration',
    '_CONFIRM_CHANGES'          => 'Confirm Changes',
    '_CONFIRM_EMAIL'            => 'Confirm email Address',
    '_CONFIRM_EMAIL_EXPLAIN'    => 'You Only Need to Specify this if you are Changing your Email Address.',

    '_CONFIRM_EXPLAIN'          => 'To Prevent Automated Registrations the Board Requires you to Enter a Confirmation Code.  The Code is displayed in the Image you should see below.  If you are Visually Impaired or can NOT otherwise Read this Code,  please Contact the %sBoard Administrator%s.',

    '_VC_REFRESH'               => 'Refresh Confirmation Code',
    '_VC_REFRESH_EXPLAIN'       => 'If you can NOT Read the Code you can Request a New One by Clicking the Button.',

    '_CONFIRM_PASSWORD'         => 'Confirm Password',
    '_CONFIRM_PASSWORD_EXPLAIN' => 'You Only Need to Confirm your Password if you Changed it above.',
    '_COPPA_BIRTHDAY'           => 'To Continue with the Registration Procedure, please tell us when you were Born.',
    '_COPPA_COMPLIANCE'         => 'COPPA Compliance',

    '_COPPA_EXPLAIN'            => 'Please Note that Clicking Submit will Create your Account.  However it can NOT be Activated until a Parent or Guardian Approves your Registration. You will be emailed a Copy of the Necessary Form with Details of where to Send it.',

    '_CREATE_FOLDER'            => 'Add Folder',
    '_CURRENT_IMAGE'            => 'Current Image',
    '_CUSTOM_DATEFORMAT'        => 'Custom',

    '_CURRENT_PASSWORD'         => 'Current Password',

    '_CURRENT_PASSWORD_EXPLAIN' => 'You must Confirm your Current Password if you wish to Change it, Alter your email Address or Username.',

    '_CUR_PASSWORD_ERROR'       => 'The Current Password you entered is Incorrect.',

    '_DEFAULT_ACTION'             => 'Default Action',
    '_DEFAULT_ACTION_EXPLAIN'     => 'This Action will be Triggered if None of the above is Applicable.',
    '_DEFAULT_ADD_SIG'            => 'Attach my Signature by Default',
    '_DEFAULT_BBCODE'             => 'Enable BBCode by Default',
    '_DEFAULT_NOTIFY'             => 'Notify me upon Replies by Default',
    '_DEFAULT_SMILIES'            => 'Enable Smilies by Default',
    '_DEFINED_RULES'              => 'Defined Rules',
    '_DELETED_TOPIC'              => 'Topic has been Removed.',
    '_DELETE_ATTACHMENT'          => 'Delete Attachment',
    '_DELETE_ATTACHMENTS'         => 'Delete Attachments',
    '_DELETE_ATTACHMENT_CONFIRM'  => 'Are you sure you want to Delete this Attachment?',
    '_DELETE_ATTACHMENTS_CONFIRM' => 'Are you sure you want to Delete these Attachments?',
    '_DELETE_AVATAR'              => 'Delete Image',
    '_DELETE_COOKIES_CONFIRM'     => 'Are you sure you want to Delete ALL Cookies Set by this Board?',
    '_DELETE_MARKED_PM'           => 'Delete Marked Messages',
    'DELETE_MARKED_PM'            => 'Delete Marked Messages',
    '_DELETE_MARKED_PM_CONFIRM'   => 'Are you sure you want to Delete ALL Marked Private Messages?',
    '_DELETE_OLDEST_MESSAGES'     => 'Delete Oldest Private Messages',
    '_DELETE_MESSAGE'             => 'Delete Private Message',
    '_DELETE_MESSAGE_CONFIRM'     => 'Are you sure you want to Delete this Private Message?',
    'DELETE_MESSAGE_CONFIRM'      => 'Are you sure you want to Delete this Private Message?',
    '_DELETE_MESSAGES_IN_FOLDER'  => 'Delete ALL Private Message within Removed Folder',
    '_DELETE_RULE'                => 'Delete Rule',
    '_DELETE_RULE_CONFIRM'        => 'Are you sure you want to Delete this Rule?',
    '_DEMOTE_SELECTED'            => 'Demote Selected',
    '_DISABLE_CENSORS'            => 'Enable Word Censoring',
    '_DISPLAY_GALLERY'            => 'Display Gallery',
    '_DOMAIN_NO_MX_RECORD_EMAIL'  => 'The entered email Domain has NO Valid MX Record.',
    '_DOWNLOADS'                  => 'Downloads',
    '_DRAFTS_DELETED'             => 'ALL Selected Drafts were Successfully Deleted.',
    '_DRAFTS_EXPLAIN'             => 'Here you can View, Edit and Delete your Saved Drafts.',
    '_DRAFT_UPDATED'              => 'Draft Successfully Updated.',
    'EDIT_DRAFT_EXPLAIN'          => 'Here you are able to Edit your Draft.  Drafts DO NOT contain Attachment and Poll Information.',

    '_EMAIL_BANNED_EMAIL'  => 'The email Address you entered is NOT Allowed to be used.',
    '_EMAIL_INVALID_EMAIL' => 'The email Address you entered is Invalid.',

    '_EMAIL_REMIND'        => 'This must be the email Address Associated with your Account.  If you have NOT changed this via your User Control Panel then it\'s the email Address you Registered your Account with.',

    '_EMAIL_TAKEN_EMAIL'   => 'The entered email Address is already in Use.',
    '_EMPTY_DRAFT'         => 'You must enter a Message to Submit your Changes.',
    '_EMPTY_DRAFT_TITLE'   => 'You must enter a Draft Title.',
    '_EXPORT_AS_XML'       => 'Export as XML',
    '_EXPORT_AS_CSV'       => 'Export as CSV',
    '_EXPORT_AS_CSV_EXCEL' => 'Export as CSV (Excel)',
    '_EXPORT_AS_TXT'       => 'Export as TXT',
    '_EXPORT_AS_MSG'       => 'Export as MSG',
    '_EXPORT_FOLDER'       => 'Export this View',

    '_FIELD_REQUIRED'                   => 'The Field \'%s\' must be Completed.',
    '_FIELD_TOO_SHORT'                  => 'The Field \'%1$s\' is Too Short, a Minimum of \'%2$d\' Characters is Required.',
    '_FIELD_TOO_LONG'                   => 'The Field \'%1$s\' is Too Long, a Maximum of \'%2$d\' Characters is Allowed.',
    '_FIELD_TOO_SMALL'                  => 'The Value of \'%1$s\' is Too Small, a Minimum Value of \'%2$d\' is Required.',
    '_FIELD_TOO_LARGE'                  => 'The Value of \'%1$s\' is Too large, a Maximum Value of \'%2$d\' is aLlowed.',
    '_FIELD_INVALID_CHARS_NUMBERS_ONLY' => 'The Field \'%s\' has Invalid Characters.  Only Numbers are Allowed.',
    '_FIELD_INVALID_CHARS_ALPHA_ONLY'   => 'The Field \'%s\' has Invalid Characters.  Only Alphanumeric Characters are Allowed.',

    '_FIELD_INVALID_CHARS_SPACERS_ONLY' => 'The Field \'%s\' has Invalid Characters.  Only Alphanumeric, Space or -+_[] Characters are Allowed.',

    '_FIELD_INVALID_DATE'               => 'The Field \'%s\' has an Invalid Date.',

    '_FOE_MESSAGE'  => 'Message from Foe',

    '_FOES_EXPLAIN' => 'Foes are Users which will be Ignored by Default.  Posts by these Users will NOT be Fully Visible.  Personal Messages from Foes are Still Permitted.  Please Note that you can NOT Ignore Moderators or Administrators.',

    '_FOES_UPDATED' => 'Your Foes List has been Successfully Updated.',

    '_FOLDER_ADDED'               => 'Folder Successfully Added.',
    '_FOLDER_MESSAGE_STATUS'      => '%1$d from %2$d Messages Stored',
    '_FOLDER_NAME_EMPTY'          => 'You must enter a Name for this Folder.',
    '_FOLDER_NAME_EXIST'          => 'Folder <strong>%s</strong> Already Exists.',
    '_FOLDER_OPTIONS'             => 'Folder Options',
    '_FOLDER_RENAMED'             => 'Folder Successfully Renamed.',
    '_FOLDER_REMOVED'             => 'Folder Successfully Removed.',
    '_FOLDER_STATUS_MSG'          => 'Folder is %1$d%% FULL (%2$d from %3$d Messages Stored)',
    '_FORWARD_PM'                 => 'Forward PM',
    '_FORCE_PASSWORD_EXPLAIN'     => 'Before you continue Browsing the Board, you are Required to Change your Password.',
    '_FRIEND_MESSAGE'             => 'Message from Friend',
    '_FRIENDS'                    => 'Friends',
    '_FRIENDS_EXPLAIN'            => 'Friends Enable you Quick Access to Members you Communicate with Frequently.',
    '_FRIENDS_OFFLINE'            => 'Offline',
    '_FRIENDS_ONLINE'             => 'Online',
    '_FRIENDS_UPDATED'            => 'Your Friends List has been Successfully Updated.',
    '_FULL_FOLDER_OPTION_CHANGED' => 'The Action to take when a Folder is FULL has been Successfully Changed.',
    '_FWD_ORIGINAL_MESSAGE'       => '-------- Original Message --------',
    '_FWD_SUBJECT'                => 'Subject: %s',
    '_FWD_DATE'                   => 'Date: %s',
    '_FWD_FROM'                   => 'From: %s',
    '_FWD_TO'                     => 'To: %s',

    '_GLOBAL_ANNOUNCEMENT'     => 'Global Announcement',

    '_HIDE_ONLINE'             => 'Hide my Online Status',
    '_HIDE_ONLINE_EXPLAIN'     => 'Changing this Setting won\'t become Effective until your Next Visit to the Board.',

    '_HOLD_NEW_MESSAGES'       => 'DO NOT Accept New Private Messages (New Private Messages will be Held Back until enough Space is Available)',

    '_HOLD_NEW_MESSAGES_SHORT' => 'New Private Messages will be Held Back',

    '_IF_FOLDER_FULL'             => 'If Folder is FULL',
    '_IMPORTANT_NEWS'             => 'Important Announcements',
    '_INVALID_USER_BIRTHDAY'      => 'The entered Birthday is NOT a Valid Date.',
    '_INVALID_CHARS_USERNAME'     => 'The Username contains Forbidden Characters.',
    '_INVALID_CHARS_NEW_PASSWORD' => 'The Password DOES NOT contain the Required Characters.',

    '_ITEMS_REQUIRED'             => 'The Items marked with <strong>*</strong> are Required Profile Fields and must be Filled Out.',

    'JUMP_TO'        => 'Click to Jump to Page',
    '_JOIN_SELECTED' => 'Join Selected',
    'FOLDER_OPTIONS' => 'Rules, Folders and Settings',

    '_LANGUAGE'                   => 'Language',
    '_LINK_REMOTE_AVATAR'         => 'Link Off-Site',
    '_LINK_REMOTE_AVATAR_EXPLAIN' => 'Enter the URL of the Location containing the Avatar Image you wish to Link to.',
    '_LINK_REMOTE_SIZE'           => 'Avatar Dimensions',
    '_LINK_REMOTE_SIZE_EXPLAIN'   => 'Specify the Width and Height of the Avatar.  Leave Blank to Attempt Automatic Verification.',

    '_LOGIN_EXPLAIN_UCP' => 'Please Login In Order to Access the User Control Panel.',
    '_LOGIN_REDIRECT'    => 'You have been Successfully Logged In.',

    '_LOGOUT_FAILED'     => 'You were NOT Logged Out.  As the Request DID NOT Match your Session.  Please contact the Board Administrator if you Continue to Experience Problems.',

    '_LOGOUT_REDIRECT'   => 'You have been Successfully Logged Out.',

    '_MARK_IMPORTANT'               => 'Mark/Unmark as Important',
    '_MARKED_MESSAGE'               => 'Marked Private Message',
    '_MAX_FOLDER_REACHED'           => 'Maximum Number of Allowed User Defined Folders Reached.',
    '_MESSAGE_BY_AUTHOR'            => 'by',
    '_MESSAGE_COLOURS'              => 'Private Message Colours',
    '_MESSAGE_HISTORY'              => 'Private Message History',
    '_MESSAGE_REMOVED_FROM_OUTBOX'  => 'This Private Message has been Removed by its Author before it was Delivered.',
    '_MESSAGE_SENT_ON'              => 'on',
    '_MESSAGE_STORED'               => 'This Private Message has been Successfully Sent.',
    '_MESSAGE_TO'                   => 'To',
    'MESSAGES_DELETED'              => 'Private Messages Successfully Deleted',
    '_MOVE_DELETED_MESSAGES_TO'     => 'Move Private Messages from Removed Folder to',
    '_MOVE_DOWN'                    => 'Move Down',
    '_MOVE_MARKED_TO_FOLDER'        => 'Move Marked to %s',

    '_MOVE_PM_ERROR'                => 'An Error Occurred while Moving the Private Messages to the New Folder.  Only %1d from %2d Private Messages were Moved.',

    '_MOVE_TO_FOLDER'               => 'Move to Folder',
    '_MOVE_UP'                      => 'Move up',
    'FORM_INVALID'                  => 'Invalid ID',

    '_NEW_EMAIL_ERROR'              => 'The email Address\'s you entered DO NOT Match.',
    '_NEW_FOLDER_NAME'              => 'New Folder Name',
    '_NEW_PASSWORD'                 => 'New Password',
    '_NEW_PASSWORD_ERROR'           => 'The Passwords you entered DO NOT Match.',
    '_NOTIFY_METHOD'                => 'Notification Method',
    '_NOTIFY_METHOD_BOTH'           => 'Both',
    '_NOTIFY_METHOD_EMAIL'          => 'email Only',
    '_NOTIFY_METHOD_EXPLAIN'        => 'Method for Sending Messages sent via this Board.',
    '_NOTIFY_METHOD_IM'             => 'Jabber Only',
    '_NOTIFY_ON_PM'                 => 'Notify me when New Private Messages are Received',
    '_NOT_ADDED_FRIENDS_ANONYMOUS'  => 'You can NOT Add Anonymous Users to your Friends List.',
    '_NOT_ADDED_FRIENDS_BOTS'       => 'You can NOT Add BOTS to your Friends List.',
    '_NOT_ADDED_FRIENDS_FOES'       => 'You can NOT Add Users to your Friends List who are currently on your Foes List.',
    '_NOT_ADDED_FRIENDS_SELF'       => 'You can NOT Add Yourself to the Friends List.',
    '_NOT_ADDED_FOES_MOD_ADMIN'     => 'You can NOT Add Administrators and Moderators to your Foes List.',
    '_NOT_ADDED_FOES_ANONYMOUS'     => 'You can NOT Add an Anonymous User to your Foes List.',
    '_NOT_ADDED_FOES_BOTS'          => 'You can NOT Add BOTS to your Foes List.',
    '_NOT_ADDED_FOES_FRIENDS'       => 'You can NOT Add Users to your Foes List who are currently on your Friends List.',
    '_NOT_ADDED_FOES_SELF'          => 'You can NOT Add Yourself to the Foes List.',
    '_NOT_AGREE'                    => 'I DO NOT Agree to these Terms.',
    '_NOT_ENOUGH_SPACE_FOLDER'      => 'The Destination Folder \'%s\' seems to be FULL.  Therefore the Requested Action Failed.',
    '_NOT_MOVED_MESSAGE'            => 'You have 1 Private Message On Hold because the Folder is FULL.',
    '_NOT_MOVED_MESSAGES'           => 'You have %d Private Messages On Hold because the Folder is FULL.',
    '_NO_ACTION_MODE'               => 'NO Message Action Specified.',
    '_NO_AUTHOR'                    => 'NO Author Defined for this Message',
    '_NO_AVATAR_CATEGORY'           => 'None',

    '_NO_AUTH_DELETE_MESSAGE'       => 'You are NOT Authorised to Delete Private Messages.',
    '_NO_AUTH_EDIT_MESSAGE'         => 'You are NOT Authorised to Edit Private Messages.',
    '_NO_AUTH_FORWARD_MESSAGE'      => 'You are NOT Authorised to Forward Private Messages.',
    '_NO_AUTH_GROUP_MESSAGE'        => 'You are NOT Authorised to Send Private Messages to Groups.',
    '_NO_AUTH_PASSWORD_REMINDER'    => 'You are NOT Authorised to Request a New Password.',
    '_NO_AUTH_READ_HOLD_MESSAGE'    => 'You are NOT Authorised to Read Private Messages that are On Hold.',
    '_NO_AUTH_READ_MESSAGE'         => 'You are NOT Authorised to Read Private Messages.',
    '_NO_AUTH_READ_REMOVED_MESSAGE' => 'You can NOT Read this Message because it was Removed by the Author.',
    '_NO_AUTH_SEND_MESSAGE'         => 'You are NOT Authorised to Send Private Messages.',
    '_NO_AUTH_SIGNATURE'            => 'You are NOT Authorised to Define a Signature.',

    '_NO_BCC_RECIPIENT'      => 'None',
    '_NO_BOOKMARKS'          => 'You have NO Bookmarks!',
    '_NO_BOOKMARKS_SELECTED' => 'You have Selected NO Bookmarks!',
    '_NO_EDIT_READ_MESSAGE'  => 'Private Message can NOT be Edited because it has already been Read!',
    '_NO_EMAIL_USER'         => 'The email/Username Information Submitted could NOT be Found!',
    '_NO_FOES'               => 'NO Foes Currently Defined!',
    '_NO_FRIENDS'            => 'NO Friends Currently Defined!',
    '_NO_FRIENDS_OFFLINE'    => 'NO Friends Offline.',
    'NO_FRIENDS_ONLINE'      => 'NO Friends Online.',
    '_NO_GROUP_SELECTED'     => 'NO Group Specified.',
    '_NO_IMPORTANT_NEWS'     => 'NO Important Announcements Present!',
    '_NO_MESSAGE'            => 'Private Message could NOT be Found!',
    '_NO_NEW_FOLDER_NAME'    => 'You have to Specify a New Folder Name.',
    '_NO_NEWER_PM'           => 'NO Newer Private Messages!',

    '_NO_OLDER_PM'           => 'NO Older Private Messages.',
    '_NO_PASSWORD_SUPPLIED'  => 'You can NOT Login without a Password.',
    '_NO_RECIPIENT'          => 'NO Recipient Defined.',
    '_NO_RULES_DEFINED'      => 'NO Rules Defined.',
    '_NO_SAVED_DRAFTS'       => 'NO Drafts Saved.',
    '_NO_TO_RECIPIENT'       => 'None',
    '_NO_WATCHED_FORUMS'     => 'You are NOT Subscribed to any Forums.',
    '_NO_WATCHED_SELECTED'   => 'You have NOT Selected any Subscribed Topics or Forums.',
    '_NO_WATCHED_TOPICS'     => 'You are NOT Subscribed to any Topics.',

    '_PASS_TYPE_ALPHA_EXPLAIN'  => 'Password must be AlphaNumeric containing both Upper and Lower Case Characters and be between %1$d and %2$d Characters Long.',

    '_PASS_TYPE_ANY_EXPLAIN'    => 'Password must be between %1$d and %2$d Characters Long.',

    '_PASS_TYPE_CASE_EXPLAIN'   => 'Password must contain both Upper and Lower case Characters and be between %1$d and %2$d Characters Long.',

    '_PASS_TYPE_SYMBOL_EXPLAIN' => 'Password must be AlphaNumeric containing both Upper and Lower case Characters and must also contain Symbols and be between %1$d and %2$d Characters Long.',

    '_PASSWORD'                 => 'Password',
    '_PASSWORD_ACTIVATED'       => 'Your New Password has been Activated.',
    '_PASSWORD_UPDATED'         => 'A New Password was Sent to your Registered email Address.',
    '_PERMISSIONS_RESTORED'     => 'Successfully Restored Original Permissions.',

    '_PERMISSIONS_TRANSFERRED'  => 'Successfully Transferred Permissions from <strong>%s</strong>, you are now able to Browse the Board with this User\'s Permissions.<br />Please Note that Administration Permissions were NOT Transferred.  You are able to Revert to your Permission Set at any time.',

    'PM_ACTION' => array(
        'PLACE_INTO_FOLDER' => 'Place into Folder',
        'MARK_AS_READ'      => 'Mark as Read',
        'MARK_AS_IMPORTANT' => 'Mark Message',
        'DELETE_MESSAGE'    => 'Delete Message'
    ),

    'PM_CHECK' => array(
        'SUBJECT' => 'Subject',
        'SENDER'  => 'Sender',
        'MESSAGE' => 'Message',
        'STATUS'  => 'Message Status',
        'TO'      => 'Sent to'
    ),

    'PM_RULE' => array(
        'IS_LIKE'     => 'is like',
        'IS_NOT_LIKE' => 'is NOT like',
        'IS'          => 'is',
        'IS_NOT'      => 'is NOT',
        'BEGINS_WITH' => 'Begins with',
        'ENDS_WITH'   => 'Ends with',
        'IS_FRIEND'   => 'is Friend',
        'IS_FOE'      => 'is Foe',
        'IS_USER'     => 'is User',
        'IS_GROUP'    => 'is in Usergroup',
        'ANSWERED'    => 'Answered',
        'FORWARDED'   => 'Forwarded',
        'TO_GROUP'    => 'to my Default Usergroup',
        'TO_ME'       => 'to me'
    ),

    '_PM_DISABLED'            => 'Private Messaging has been Disabled on this Board.',
    '_PM_FROM'                => 'From',
    '_PM_FROM_REMOVED_AUTHOR' => 'This Private Message was Sent by a User NO Longer Registered.',
    '_PM_ICON'                => 'Private Message Icon',
    '_PM_INBOX'               => 'Inbox',
    '_PM_NO_USERS'            => 'The Requested Users to be Added DO NOT Exist.',
    '_PM_OUTBOX'              => 'Outbox',
    '_PM_SENTBOX'             => 'Sent Private Messages',
    '_PM_SUBJECT'             => 'Message Subject',
    '_PM_TO'                  => 'Send to',
    '_PM_USERS_REMOVED_NO_PM' => 'Some Users couldn\'t be Added as they have Disabled Private Message Receipt.',
    '_POPUP_ON_PM'            => 'Pop-Up Window on New Private Message',
    '_POST_EDIT_PM'           => 'Edit Private Message',
    '_POST_FORWARD_PM'        => 'Forward Private Message',
    '_POST_NEW_PM'            => 'Compose Private Message',
    '_POST_PM_LOCKED'         => 'Private Messaging is Locked.',
    '_POST_PM_POST'           => 'Quote Post',
    '_POST_QUOTE_PM'          => 'Quote Private Message',
    '_POST_REPLY_PM'          => 'Reply to Private Message',
    '_PRINT_PM'               => 'Print View',
    '_REPORT_PM'              => 'Report Private Message',
    '_PREFERENCES_UPDATED'    => 'Your Preferences have been Updated.',

    '_PROFILE_INFO_NOTICE' => 'Please Note that this Information may be Viewable to other Members.  Be careful when including any Personal Details.  Any Fields Marked with a <strong>*</Strong> must be Completed.',

    '_PROFILE_UPDATED'     => 'Your Profile has been Updated.',

    '_RECIPIENT'           => 'Recipient',
    '_RECIPIENTS'          => 'Recipients',
    '_REGISTRATION'        => 'Registration',

    '_RELEASE_MESSAGES'    => '%sRelease ALL On-Hold Private Messages%s.  They will be Re-Sorted into the Appropriate Folder, if enough Space is made Available.',

    '_REMOVE_ADDRESS'                    => 'Remove Address',
    '_REMOVE_SELECTED_BOOKMARKS'         => 'Remove Selected Bookmarks',
    '_REMOVE_SELECTED_BOOKMARKS_CONFIRM' => 'Are you sure you want to Delete ALL Selected Bookmarks?',
    '_REMOVE_BOOKMARK_MARKED'            => 'Remove Marked Bookmarks',
    '_REMOVE_FOLDER'                     => 'Remove Folder',
    '_REMOVE_FOLDER_CONFIRM'             => 'Are you sure you want to Remove this Folder?',
    '_RENAME'                            => 'Rename',
    '_RENAME_FOLDER'                     => 'Rename Folder',
    '_REPLIED_MESSAGE'                   => 'Replied to Message',
    '_REPLY_TO_ALL'                      => 'Reply to Sender and ALL Recipients.',
    '_RESIGN_SELECTED'                   => 'Resign Selected',
    'RETURN_FOLDER'                      => '%1$sReturn to Previous Folder%2$s',
    '_RETURN_UCP'                        => '%sReturn to the User Control Panel%s',
    '_RULE_ADDED'                        => 'Rule Successfully Added.',
    '_RULE_ALREADY_DEFINED'              => 'This Rule has already been Defined.',
    '_RULE_DELETED'                      => 'Rule Successfully Removed.',
    '_RULE_NOT_DEFINED'                  => 'Rule NOT Correctly Specified.',
    '_RULE_REMOVED_MESSAGE'              => 'One Private Message has been Removed due to Private Message Filters.',
    '_RULE_REMOVED_MESSAGES'             => '%d Private Messages were Removed due to Private Message Filters.',

    '_SAME_PASSWORD_ERROR' => 'The New Password you Entered is the Same as Your Current Password.',
    '_SEARCH_YOUR_POSTS'   => 'Show your Posts',
    '_SEND_PASSWORD'       => 'Send Password',
    '_SENT_AT'             => 'Sent',  // Used Before Dates In Private Messages
    '_SHOW_EMAIL'          => 'Users can Contact me by email',

    '_SIGNATURE_EXPLAIN'  => 'This is a Block of text that can be Added to Posts you make.  There is a %d Character Limit.',
    '_SIGNATURE_PREVIEW'  => 'Your Signature will appear like this in Posts',
    '_SIGNATURE_TOO_LONG' => 'Your Signature is Too Long.',
    '_SORT'               => 'Sort',
    '_SORT_COMMENT'       => 'File Comment',
    '_SORT_DOWNLOADS'     => 'Downloads',
    '_SORT_EXTENSION'     => 'Extension',
    '_SORT_FILENAME'      => 'Filename',
    '_SORT_POST_TIME'     => 'Post Time',
    '_SORT_SIZE'          => 'File Size',

    '_TIMEZONE'            => 'Time Zone',
    '_TO'                  => 'To',
    '_TOO_MANY_RECIPIENTS' => 'You tried to Send a Private Message to Too Many Recipients.',

    '_TOO_MANY_REGISTERS'  => 'You have Exceeded the Maximum Number of Registration Attempts for this Session.  Please try again later!',

    '_UCP'                      => 'User Control Panel',
    '_UCP_ACTIVATE'             => 'Activate Account',

    '_UCP_ADMIN_ACTIVATE'       => 'Please Note that you will need to Enter a Valid email Address before your Account is Activated.  The Administrator will Review your Account and, if Approved you will receive an email at the Address you Specified.',

    '_UCP_AIM'                  => 'AOL Instant Messenger',
    '_UCP_ATTACHMENTS'          => 'Attachments',
    '_UCP_COPPA_BEFORE'         => 'Before %s',
    '_UCP_COPPA_ON_AFTER'       => 'On or After %s',

    '_UCP_EMAIL_ACTIVATE'       => 'Please Note that you will need to enter a Valid email Address before your Account is Activated.  You will receive an email at the Address you provide that contains an Account Activation Link.',

    '_UCP_ICQ'                  => 'ICQ Number',
    '_UCP_JABBER'               => 'Jabber Address',

    '_UCP_MAIN'                 => 'Overview',
    '_UCP_MAIN_ATTACHMENTS'     => 'Manage Attachments',
    '_UCP_MAIN_BOOKMARKS'       => 'Manage Bookmarks',
    '_UCP_MAIN_DRAFTS'          => 'Manage Drafts',
    '_UCP_MAIN_FRONT'           => 'Front Page',
    '_UCP_MAIN_SUBSCRIBED'      => 'Manage Subscriptions',

    '_UCP_MSNM'                 => 'WL/MSN Messenger',
    'UCP_NO_ATTACHMENTS'        => 'You haven\'t Posted any Files.',

    '_UCP_PREFS'                => 'Board Preferences',
    '_UCP_PREFS_PERSONAL'       => 'Edit Global Settings',
    '_UCP_PREFS_POST'           => 'Edit Posting Defaults',
    '_UCP_PREFS_VIEW'           => 'Edit Display Options',

    '_UCP_PM'                   => 'Private Messages',
    '_UCP_PM_COMPOSE'           => 'Compose Private Message',
    '_UCP_PM_DRAFTS'            => 'Manage Private Message Drafts',
    '_UCP_PM_OPTIONS'           => 'Rules, Folders and Settings',
    '_UCP_PM_POPUP'             => 'Private Messages',
    '_UCP_PM_POPUP_TITLE'       => 'Private Message Pop-Up',
    '_UCP_PM_UNREAD'            => 'Unread Private Messages',
    '_UCP_PM_VIEW'              => 'View Private Messages',
    'UCP_PM_COMPOSE'            => 'Compose Private Message',
    'UCP_PM_DRAFTS'             => 'Manage Private Message Drafts',

    '_UCP_PROFILE'              => 'Profile',
    '_UCP_PROFILE_AVATAR'       => 'Edit Avatar',
    '_UCP_PROFILE_PROFILE_INFO' => 'Edit Profile',
    '_UCP_PROFILE_REG_DETAILS'  => 'Edit Account Settings',
    '_UCP_PROFILE_SIGNATURE'    => 'Edit Signature',

    '_UCP_USERGROUPS'           => 'Usergroups',
    '_UCP_USERGROUPS_MEMBER'    => 'Edit Memberships',
    '_UCP_USERGROUPS_MANAGE'    => 'Manage Groups',

    '_UCP_REGISTER_DISABLE'     => 'Creating a New Account is Currently NOT Possible.',
    '_UCP_REMIND'               => 'Send Password',
    '_UCP_RESEND'               => 'Send Activation email',

    '_UCP_WELCOME'              => 'Welcome to the User Control Panel.  From here you can Monitor, View and Update your Profile, Preferences, Subscribed Forums and Topics.  You can also Send Private Messages to other Users (if Permitted).  Please ensure you Read any Announcements before continuing.',

    '_UCP_YIM'                  => 'Yahoo Messenger',
    '_UCP_ZEBRA'                => 'Friends and Foes',
    '_UCP_ZEBRA_FOES'           => 'Manage Foes',
    '_UCP_ZEBRA_FRIENDS'        => 'Manage Friends',

    '_UNDISCLOSED_RECIPIENT' => 'Undisclosed Recipient',
    '_UNKNOWN_FOLDER'        => 'Unknown Folder',
    '_UNWATCH_MARKED'        => 'Unwatch Marked',
    '_UPLOAD_AVATAR_FILE'    => 'Upload Avatar from your Computer',
    '_UPLOAD_AVATAR_URL'     => 'Upload from a URL',

    '_UPLOAD_AVATAR_URL_EXPLAIN'      => 'Enter the URL of the Location containing the Image.  The Image will be Uploaded to this Site.',

    '_USERNAME_ALPHA_ONLY_EXPLAIN'    => 'Username must be between %1$d and %2$d Characters Long and Use Only Alphanumeric Characters.',

    '_USERNAME_ALPHA_SPACERS_EXPLAIN' => 'Username must be between %1$d and %2$d Characters Long and Use Alphanumeric, Space or -+_[] Characters.',

    '_USERNAME_ASCII_EXPLAIN'         => 'Username must be between %1$d and %2$d Characters Long and Use Only ASCII Characters, so <strong>NO</strong> Special Symbols.',

    '_USERNAME_LETTER_NUM_EXPLAIN'    => 'Username must be between %1$d and %2$d Characters Long and Use Only Letters or Number Characters.',

    '_USERNAME_LETTER_NUM_SPACERS_EXPLAIN' => 'Username must be between %1$d and %2$d Characters Long and Use Letters, Numbers, Space or -+_[] Characters.',

    '_USERNAME_CHARS_ANY_EXPLAIN'   => 'Length must be between %1$d and %2$d Characters.',
    '_USERNAME_TAKEN_USERNAME'      => 'The Username already Exists.  Please Select an Alternative.',

    '_USERNAME_DISALLOWED_USERNAME' => 'The Username you entered has been Disallowed or contains a Disallowed Word.  Please choose a Different Name.',

    '_USER_NOT_FOUND_OR_INACTIVE'   => 'The Usernames you Specified could NOT be found or their Accounts have NOT been Activated yet.',

    '_VIEW_AVATARS'          => 'Display Avatars',
    '_VIEW_EDIT'             => 'View/Edit',
    '_VIEW_FLASH'            => 'Display Flash Animations',
    '_VIEW_IMAGES'           => 'Display Images within Posts',
    '_VIEW_NEXT_HISTORY'     => 'Next Private Message in History',
    '_VIEW_NEXT_PM'          => 'Next Private Message',
    '_VIEW_PM'               => 'View Private Message',
    '_VIEW_PM_INFO'          => 'Private Message Details',
    '_VIEW_PM_MESSAGE'       => '1 Private Message',
    '_VIEW_PM_MESSAGES'      => '%d Private Messages',
    '_VIEW_PREVIOUS_HISTORY' => 'Previous Private Message in History',
    '_VIEW_PREVIOUS_PM'      => 'Previous Private Message',
    '_VIEW_SIGS'             => 'Display Signatures',
    '_VIEW_SMILIES'          => 'Display Smilies as Images',
    '_VIEW_TOPICS_DAYS'      => 'Display Topics from Previous Days',
    '_VIEW_TOPICS_DIR'       => 'Display Topic Order Direction',
    '_VIEW_TOPICS_KEY'       => 'Display Topics Ordering by',
    '_VIEW_POSTS_DAYS'       => 'Display Posts from Previous Days',
    '_VIEW_POSTS_DIR'        => 'Display Post Order Direction',
    '_VIEW_POSTS_KEY'        => 'Display Posts Ordering by',

    '_WATCHED_EXPLAIN'       => 'Below is a List of Forums and Topics that you are Subscribed to, and you\'ll be Notified of any New Posts. To Unsubscribe Mark the Forum or Topic and then, Press the <em>Unwatch Marked</em> Button.',

    '_WATCHED_FORUMS'        => 'Watched Forums',
    '_WATCHED_TOPICS'        => 'Watched Topics',
    '_WRONG_ACTIVATION'      => 'The Activation Key you supplied DOES NOT Match any in the Database.',

    '_YOUR_DETAILS'          => 'Your Activity',
    '_YOUR_FOES'             => 'Your Foes',
    '_YOUR_FOES_EXPLAIN'     => 'To Remove Usernames Select them and Click Submit.',
    '_YOUR_FRIENDS'          => 'Your Friends',
    '_YOUR_FRIENDS_EXPLAIN'  => 'To Remove Usernames Select them and Click Submit.',
    '_YOUR_WARNINGS'         => 'Your Warning Level',

    '_GROUPS_EXPLAIN'  => 'Usergroups Enable Board Administrators to better Administer Users.  By Default you will be placed in a Specific Group, this is your Default Group.  This Group Defines how you appear to other Users, for example your Username Colouration, Avatar, Rank, etc. Depending on whether the Administrator Allows it, you may be Allowed to Change your Default Group.  You may also be Placed in or Allowed to Join Other Groups.  Some Groups may give you Additional Permissions to View Content or Increase your Capabilities in other areas.',

    '_GROUP_LEADER'    => 'Leaderships',
    '_GROUP_MEMBER'    => 'Memberships',
    '_GROUP_PENDING'   => 'Pending Memberships',
    '_GROUP_NONMEMBER' => 'Non-Memberships',
    '_GROUP_DETAILS'   => 'Group Details',

    '_NO_LEADER'       => 'NO Group Leaderships',
    '_NO_MEMBER'       => 'NO Group Memberships',
    '_NO_PENDING'      => 'NO Pending Memberships',
    '_NO_NONMEMBER'    => 'NO Non-Member Groups',

    '_ADD_ATTACHMENT'         => 'Upload Attachment',
    '_ADD_ATTACHMENT_EXPLAIN' => 'If you wish to Attach one or more Files enter the Details below.',
    '_ADD_FILE'               => 'Add the File',
    '_ADD_POLL'               => 'Poll Creation',
    '_ADD_POLL_EXPLAIN'       => 'If you DO NOT want to Add a Poll to your Topic, Leave the Fields Blank.',
    '_ALREADY_DELETED'        => 'Sorry, but this Private Message was already Deleted.',
    '_ATTACH_QUOTA_REACHED'   => 'Sorry, the Board Attachment Quota has been Reached.',
    '_ATTACH_SIG'             => 'Attach a Signature (Signatures can be Altered via the UCP)',

    '_BBCODE_A_HELP'          => 'Inline Uploaded Attachment: [attachment=]filename.ext[/attachment]',
    '_BBCODE_B_HELP'          => 'Bold Text: [b]text[/b]',
    '_BBCODE_C_HELP'          => 'Code Display: [code]code[/code]',
    '_BBCODE_E_HELP'          => 'List: Add List Element',
    '_BBCODE_F_HELP'          => 'Font Size: [size=85]small text[/size]',
    '_BBCODE_IS_OFF'          => '%sBBCode%s is <em>OFF</em>',
    '_BBCODE_IS_ON'           => '%sBBCode%s is <em>ON</em>',
    '_BBCODE_I_HELP'          => 'Italic Text: [i]text[/i]',
    '_BBCODE_L_HELP'          => 'List: [list]text[/list]',
    '_BBCODE_LISTITEM_HELP'   => 'List Item: [*]text[/*]',
    '_BBCODE_O_HELP'          => 'Ordered List: [list=(1)(a)][*]text[/list]',
    '_BBCODE_P_HELP'          => 'Insert Image: [img]http://image_url[/img]',
    '_BBCODE_Q_HELP'          => 'Quote Text: [quote]text[/quote]',
    '_BBCODE_S_HELP'          => 'Font Colour: [color=red]text[/color]  Tip: you can also use color=#FF0000',
    '_BBCODE_U_HELP'          => 'Underline Text: [u]text[/u]',
    '_BBCODE_W_HELP'          => 'Insert URL: [url]http://url[/url] or [url=http://url]URL text[/url]',
    '_BBCODE_D_HELP'          => 'Flash: [flash=width,height]http://url[/flash]',
    '_BUMP_ERROR'             => 'You can NOT Bump this Topic so soon after the Last Post.',

    '_CANNOT_DELETE_REPLIED'   => 'Sorry, but you can Only Delete Posts which have NOT been Replied to.',
    '_CANNOT_EDIT_POST_LOCKED' => 'This Post has been Locked.  You can NO Longer Edit that Post.',
    '_CANNOT_EDIT_TIME'        => 'You can NO Longer Edit or Delete that Post.',
    '_CANNOT_POST_ANNOUNCE'    => 'Sorry, but you can NOT Post Announcements.',
    '_CANNOT_POST_STICKY'      => 'Sorry, but you can NOT Post Sticky Topics.',
    '_CHANGE_TOPIC_TO'         => 'Change Topic Type to',
    '_CLOSE_TAGS'              => 'Close Tags',
    '_CURRENT_TOPIC'           => 'Current Topic',

    '_DELETE_FILE'             => 'Delete File',
    '_DELETE_OWN_POSTS'        => 'Sorry, but you can Only Delete your Own Posts.',
    '_DELETE_POST_CONFIRM'     => 'Are you sure you want to Delete this Post?',
    '_DELETE_POST_WARN'        => 'Once Deleted the Post can NOT be Recovered!',
    '_DISABLE_BBCODE'          => 'Disable BBCode',
    '_DISABLE_MAGIC_URL'       => 'DO NOT Automatically Parse URL\'s',
    '_DISABLE_SMILIES'         => 'Disable Smilies',
    '_DISALLOWED_CONTENT'      => 'The Upload was Rejected because the Uploaded File was Identified as a Possible Attack Vector.',
    '_DISALLOWED_EXTENSION'    => 'The Extension %s is NOT Allowed.',

    '_DRAFT_LOADED'         => 'Draft Loaded into Posting Area, you may want to finish your Post now.<br />Your Draft will be Deleted after Submitting this Post.',

    '_DRAFT_LOADED_PM'      => 'Draft Loaded into Private Message Area, you may want to finish your Private Message now.<br />Your Draft will be Deleted after Submitting this Private Message.',

    '_DRAFT_SAVED'          => 'Draft Successfully Saved.',
    '_DRAFT_TITLE'          => 'Draft Title',

    '_EDIT_REASON'          => 'Reason for Editing this Post',
    '_EMPTY_FILEUPLOAD'     => 'The Uploaded File is Empty.',
    '_EMPTY_MESSAGE'        => 'You must enter a Message when Posting.',
    '_EMPTY_REMOTE_DATA'    => 'File could NOT be Uploaded.  Please try Uploading the File Manually!',

    '_FLASH_IS_OFF'         => '[flash] is <em>OFF</em>',
    '_FLASH_IS_ON'          => '[flash] is <em>ON</em>',
    '_FLOOD_ERROR'          => 'You can NOT make another Post so soon after your Last.',

    '_GENERAL_UPLOAD_ERROR' => 'Could NOT Upload Attachment to %s.',

    '_IMAGES_ARE_OFF'       => '[img] is <em>OFF</em>',
    '_IMAGES_ARE_ON'        => '[img] is <em>ON</em>',
    '_INVALID_FILENAME'     => '%s is an Invalid Filename.',

    '_LOAD'                 => 'Load',
    '_LOAD_DRAFT'           => 'Load Draft',

    '_LOAD_DRAFT_EXPLAIN'   => 'Here you are able to Select the Draft you want to Continue Writing.  Your Current Post will be Cancelled.  ALL Current Post Contents will be Deleted.  View, Edit and Delete Drafts within your User Control Panel.',

    '_LOGIN_EXPLAIN_BUMP'       => 'You need to Login in order to Bump Topics within this Forum.',
    '_LOGIN_EXPLAIN_DELETE'     => 'You need to Login in order to Delete Posts within this Forum.',
    '_LOGIN_EXPLAIN_POST'       => 'You need to Login in order to Post within this Forum.',
    '_LOGIN_EXPLAIN_QUOTE'      => 'You need to Login in order to Quote Posts within this Forum.',
    '_LOGIN_EXPLAIN_REPLY'      => 'You need to Login in order to Reply to Topics within this Forum.',

    '_MAX_FONT_SIZE_EXCEEDED'    => 'You can Only Use Fonts up to Size %1$d.',
    '_MAX_FLASH_HEIGHT_EXCEEDED' => 'Your Flash Files can Only be up to %1$d Pixels High.',
    '_MAX_FLASH_WIDTH_EXCEEDED'  => 'Your Flash Files can Only be up to %1$d Pixels Wide.',
    '_MAX_IMG_HEIGHT_EXCEEDED'   => 'Your Images can Only be up to %1$d Pixels High.',
    '_MAX_IMG_WIDTH_EXCEEDED'    => 'Your Images can Only be up to %1$d Pixels Wide.',

    '_MESSAGE_BODY'               => 'Private Message Body',

    '_MESSAGE_BODY_EXPLAIN'       => 'Enter your Private Message Here, it can contain NO more than <strong>%d</strong> Characters.',

    'MESSAGE_DELETED'             => 'This Private Message has been Deleted Successfully.',
    '_MORE_SMILIES'               => 'View More Smilies',

    '_NOTIFY_REPLY'               => 'Notify me when a Reply is Posted',
    '_NOT_UPLOADED'               => 'File could NOT be Uploaded.',
    '_NO_DELETE_POLL_OPTIONS'     => 'You can NOT Delete Existing Poll Options.',
    '_NO_PM_ICON'                 => 'NO Private Message Icon',
    '_NO_POLL_TITLE'              => 'You have to enter a Poll Title.',
    '_NO_POST'                    => 'The Requested Post DOES NOT Exist.',
    '_NO_POST_MODE'               => 'NO Post Mode Specified.',

    '_PARTIAL_UPLOAD'             => 'The Uploaded File was Only Partially Uploaded.',

    '_PHP_SIZE_NA'                => 'The Attachment\'s File Size is Too Large.<br />Could NOT determine the Maximum Size Defined by PHP in php.ini.',

    '_PHP_SIZE_OVERRUN'           => 'The Attachment\'s File Size is Too Large, the Maximum Upload Size is %1$d %2$s.<br />Please Note this is Set in php.ini and can NOT be Overridden.',

    '_PLACE_INLINE'               => 'Place Inline',
    '_POLL_DELETE'                => 'Delete Poll',
    '_POLL_FOR'                   => 'Run Poll for',
    '_POLL_FOR_EXPLAIN'           => 'Enter 0 or Leave Blank for a Never Ending Poll.',
    '_POLL_MAX_OPTIONS'           => 'Options Per User',
    '_POLL_MAX_OPTIONS_EXPLAIN'   => 'This is the Number of Options each User can Select when Voting.',
    '_POLL_OPTIONS'               => 'Poll Options',
    '_POLL_OPTIONS_EXPLAIN'       => 'Place each Option on a New Line.  You can enter up to <strong>%d</strong> Options.',

    '_POLL_OPTIONS_EDIT_EXPLAIN'  => 'Place each Option on a New Line.  You can enter up to <strong>%d</strong> Options.  If you Remove or Add Options then ALL previous Votes will be Reset.',

    '_POLL_QUESTION'              => 'Poll Question',
    '_POLL_TITLE_TOO_LONG'        => 'The Poll Title must contain Less than 100 Characters.',
    '_POLL_TITLE_COMP_TOO_LONG'   => 'The Parsed Size of your Poll Title is Too Large, consider Removing BBCodes or Smilies.',
    '_POLL_VOTE_CHANGE'           => 'Allow Re-Voting',
    '_POLL_VOTE_CHANGE_EXPLAIN'   => 'If Enabled Users are able to Change their Vote.',
    '_POSTED_ATTACHMENTS'         => 'Posted Attachments',
    '_POST_APPROVAL_NOTIFY'       => 'You will be Notified when your Post has been Approved.',
    '_POST_CONFIRMATION'          => 'Confirmation of Post',

    '_POST_CONFIRM_EXPLAIN'       => 'To Prevent Automated Posts the Board Requires you to enter a Confirmation Code. The Code is Displayed in the Image you should see below.  If you are Visually Impaired or can NOT otherwise Read this Code, please contact the %sBoard Administrator%s.',

    '_POSTED'                   => 'Posted',
    'POSTED'                    => 'Posted',
    '_POST_SUBJECT'             => 'Post Subject',

    '_POST_DELETED'             => 'This Message has been Successfully Deleted.',
    '_POST_EDITED'              => 'This Message has been Successfully Edited.',

    '_POST_EDITED_MOD'          => 'This Message has been Successfully Edited but, it will need to be Approved by a Moderator before it is Publicly Viewable.',

    '_POST_GLOBAL'              => 'Global',
    '_POST_ICON'                => 'Post Icon',
    '_POST_NORMAL'              => 'Normal',
    '_POST_REVIEW'              => 'Post Review',
    '_POST_REVIEW_EDIT'         => 'Post Review Edit\'s',

    '_POST_REVIEW_EDIT_EXPLAIN' => 'This Post has been Altered by another User while you were Editing it.  You may wish to Review the Current Version of this Post and Adjust your Edits.',

    '_POST_REVIEW_EXPLAIN'      => 'At least One New Post has been made to this Topic.  You may wish to Review your Post in light of this.',

    '_POST_STORED'              => 'This Message has been Successfully Posted.',

    '_POST_STORED_MOD'          => 'This Message has been Successfully Submitted but, it will need to be Approved by a Moderator before it is Publicly Viewable.',

    '_POST_TOPIC_AS'            => 'Post Topic as',
    '_PROGRESS_BAR'             => 'Progress Bar',

    '_QUOTE_DEPTH_EXCEEDED'     => 'You can Embed Only %1$d Quotes within each other.',

    '_SAVE'                     => 'Save',
    '_SAVE_DATE'                => 'Saved at',
    '_SAVE_DRAFT'               => 'Save Draft',

    '_SAVE_DRAFT_CONFIRM'       => 'Please Note that Saved Drafts Only Include the Subject and the Message, any other element will be Removed.  Do you want to Save your Draft now?',

    '_SMILIES'         => 'Smilies',
    '_SMILIES_ARE_OFF' => 'Smilies are <em>OFF</em>',
    '_SMILIES_ARE_ON'  => 'Smilies are <em>ON</em>',

    '_STICKY_ANNOUNCE_TIME_LIMIT' => 'Sticky/Announcement Time Limit',
    '_STICK_TOPIC_FOR'            => 'Stick Topic for',

    '_STICK_TOPIC_FOR_EXPLAIN'    => 'Enter 0 or Leave Blank for a Never Ending Sticky/Announcement.  Please Note that this Number is Relative to the Date of the Post.',

    '_STYLES_TIP'            => 'Tip: Styles can be Applied Quickly to Selected Text.',

    '_TOO_FEW_CHARS'         => 'Your Message is Too Short.',

    '_TOO_FEW_CHARS_LIMIT'   => 'Your Message contains %1$d Characters.  The Minimum Number of Characters you need to enter is %2$d.',

    '_TOO_FEW_POLL_OPTIONS'  => 'You nust enter at least Two Poll Options.',
    '_TOO_MANY_ATTACHMENTS'  => 'Can NOT Add another Attachment, %d is the Maximum.',
    '_TOO_MANY_CHARS'        => 'Your Message contains Too many Characters.',
    '_TOO_MANY_CHARS_POST'   => 'Your Message contains %1$d Characters.  The Maximum Number of Allowed Characters is %2$d.',
    '_TOO_MANY_CHARS_SIG'    => 'Your Signature contains %1$d Characters.  The Maximum Number of Allowed Characters is %2$d.',
    '_TOO_MANY_POLL_OPTIONS' => 'You have tried to enter Too many Poll Options.',
    '_TOO_MANY_SMILIES'      => 'Your Message contains Too many Smilies.  The Maximum Number of Smilies Allowed is %d.',
    '_TOO_MANY_URLS'         => 'Your Message contains Too many URL\'s.  The Maximum Number of URL\'s Allowed is %d.',
    '_TOO_MANY_USER_OPTIONS' => 'You can NOT Specify more Options Per User than Existing Poll Options.',
    '_TOPIC_BUMPED'          => 'Topic has been Successfully Bumped.',

    '_UNAUTHORISED_BBCODE'   => 'You can NOT use certain BBCodes: %s.',

    '_UNGLOBALISE_EXPLAIN'   => 'To Switch this Topic back from being Global to a Normal Topic, you need to Select the Forum you wish this Topic to be Displayed in.',

    '_UPDATE_COMMENT'         => 'Update Comment',
    '_URL_INVALID'            => 'The URL you Specified is Invalid.',
    '_URL_NOT_FOUND'          => 'The File Specified could NOT be Found.',
    '_URL_IS_OFF'             => '[url] is <em>OFF</em>',
    '_URL_IS_ON'              => '[url] is <em>ON</em>',
    '_USER_CANNOT_BUMP'       => 'You can NOT Bump Topics in this Forum.',
    '_USER_CANNOT_DELETE'     => 'You can NOT Delete Posts in this Forum.',
    '_USER_CANNOT_EDIT'       => 'You can NOT Edit Posts in this Forum.',
    '_USER_CANNOT_REPLY'      => 'You can NOT Reply in this Forum.',

    '_USER_CANNOT_FORUM_POST' => 'You are NOT able to make Posts in this Forum.',

    '_VIEW_MESSAGE'           => '%sView your Submitted Private Message%s',
    '_VIEW_PRIVATE_MESSAGE'   => '%sView your Submitted Private Message%s',

    '_WRONG_FILESIZE'         => 'The File is Too Big, Maximum Allowed Size is %1d %2s.',

    '_WRONG_SIZE'             => 'The Image must be at least %1$d Pixels Wide, %2$d Pixels High and at most %3$d Pixels Wide and %4$d Pixels High.  The Submitted Image is %5$d Pixels Wide and %6$d Pixels High.',

    'UCP_PM_COMPOSE'          => 'Compose Private Message',
    'UCP_PM_DRAFTS'           => 'Manage Private Drafts',
    '_NO_TOPIC_FORUM'         => 'The Topic or Forum NO Longer Exists',
    '_btpm'                   => 'Private Messages',
    '_btrulesadd'             => 'Add New Rules Section',
    '_CONFIRM'                => 'Confirm Deletion of Attachment',
    '_REMOVE_FOLDER'          => 'Delete Folder',

    'REPLY_PM_RE'             => 'Re: ',
    'DEL_USER'                => 'DelUser',
    'DELETED_ACCOUNT'         => 'Deleted Account',
));
?>