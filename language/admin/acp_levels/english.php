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
** Formerly KnOwn As phpMyBitTorrent
** Created By Antonio Anzivino (aka DJ Echelon)
** And Joe Robertson (aka joeroberts)
** Project Leaders: Black_heart, Thor.
** File acp_levels/english.php 2018-02-28 06:44:00 Thor
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
        <p>If you arrived at this page after you used an old Bookmark or Favourite, the page in question has probably been moved. Try locating the page via the navigation menu and then update your bookmarks.</p>
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
	'permission_type' => array(
        'a_override_user_pm_block'   => 'Group Can Override the PM Block for Groups',
        'a_override_email_block '    => 'Group Can Override the email Block for Groups',
        'm_see_admin_cp'             => 'Group Can View the Administration Panel',
        'a_edit_level'               => 'Group Can Edit Groups and Permissions',
        'u_upload'                   => 'Group Can Upload Torrents',
        'u_download'                 => 'Group Can Download Torrents',
        'u_delete_own_torrents'      => 'Group Can Delete their Own Torrents',
        'm_delete_others_torrents'   => 'Group Can Delete Other Users Torrents',
        'm_banusers'                 => 'Group Can Ban Other Users',
        'm_bann_torrents'            => 'Group Can Ban Torrents',
        'm_bann_trackers'            => 'Group Can Ban External Trackers',
        'm_bann_shouts'              => 'Group Can Ban Others from Shoutbox',
        'a_see_ip'                   => 'Group Can See Other Users IP Address',
        'u_edit_own_comments'        => 'Group Can Edit their Own Comments',
        'm_edit_comments'            => 'Group Can Edit Others Comments',
        'm_edit_user'                => 'Group Can Edit Other Users Profiles of the same Class or Lower',
        'm_mass_upload'              => 'Group Can Use the Mass Upload Option',
        'u_view_nfo'                 => 'Group Can View NFO Files',
        'u_requests'                 => 'Group Can Use the Torrent Requests (Provided it is Activated)',
        'u_offers'                   => 'Group Can Use the Torrent Offers (Provided it is Activated)',
        'u_top_torrentlist'          => 'Group Can View the Top Torrent List',
        'u_can_comment'              => 'Group Can Make Comments on Torrents',
        'u_can_shout'                => 'Group Can Use the Shoutbox (this DOES NOT Override Bans)',
        'u_can_change_theme'         => 'Group Can Change Themes',
        'u_can_change_language'      => 'Group Can Change Languages',
        'u_can_view_profiles'        => 'Group Can View Other Users Profiles',
        'u_can_view_others_email'    => 'Group Can View Other Users email Address (this DOES NOT Override the Privacy Settings)',
        'u_see_member_list'          => 'Group Can View the Members/Groups List',
        'u_can_view_utube'           => 'Group Can View Posted YouTube Links',
        'u_can_add_uttube'           => 'Group Can Add New YouTube Links',
        'u_hit_run'                  => 'Group Can be Flagged for Hit and Run',
        'u_hnr_demote'               => 'Group Can be Demoted for Hit and Run',
        'u_arcade'                   => 'Group Can Access the Arcade Room',
        'u_can_use_bitbucket'        => 'Group Can Use the BitBucket Option (Provided it is Activated)',
        'u_black_jack'               => 'Group Can Play Black Jack (Provided it is Activated)',
        'u_casino'                   => 'Group Can Play in the Casino (Provided it is Activated)',
        'm_can_edit_others_torrents' => 'Group Can Edit other Users Torrents',
        'm_manage_faqs'              => 'Group Can Manage the FAQ\'s',
        'm_edit_polls'               => 'Group Can Edit/Add Poll\'s',
        'm_modforum'                 => 'Group Can Moderate the Forum',
        'm_del_users'                => 'Group Can Delete Users',
        'u_edit_own_torrents'        => 'Group Can Edit their Own Torrents',
        'm_edit_others_shouts'       => 'Group Can Edit Other Users Torrents',
        'u_masspm'                   => 'Group Can Send Messages to Multiple Users',
        'u_masspm_group'             => 'Group Can Send Messages to Groups',
        'u_pm_delete'                => 'Group Can Remove Private Messages from their Own Folder',
        'u_pm_forward'               => 'Group Can Forward Private Messages',
        'u_pm_edit'                  => 'Group Can Edit their Own Private Messages',
        'u_pm_smilies'               => 'Group Can Use Smilies in Private Messages',
        'u_pm_bbcode'                => 'Group Can Use BBCODE in Private Messages',
        'u_sig'                      => 'Group Can Use Signatures',
        'u_savedrafts'               => 'Group Can Save Drafts',
        'u_pm_img'                   => 'Group Can Use [IMG] BBCode Tag in Private Messages',
        'u_pm_flash'                 => 'Group Can Use [FLASH] BBCode Tag in Private Messages',
        'u_ignoreflood'              => 'Group Can Ignore the Flood Limit',
        'u_sendpm'                   => 'Group Can Send Private Messages',
        'u_pm_attach'                => 'Group Can Attach Files in Private Messages',
        'a_groupadd'                 => 'Group Can Create New Groups',
        'a_groupdel'                 => 'Group Can Delete Groups',
        'u_pm_download'              => 'Group Can Download Files in Private Messages',
        'u_sendim'                   => 'Group Can Send Instant Messages',
        'group_receive_pm'           => 'Group Can Receive Private Messages',
        'a_clearlogs'                => 'Group Can Clear Logs',
        'a_forumadd'                 => 'Group Can Add Forums',
        'a_forumdel'                 => 'Group Can Delete Forums',
        'a_fauth'                    => 'Group Can Manage Forum Permissions',
        'a_authusers'                => 'Group Can Manage User Permissions',
        'a_authgroups'               => 'Group Can Manage Group Permissions',
        'a_mauth'                    => 'Can Alter the Moderator Permission Class',
        'a_forum'                    => 'Group Can Manage the Forums',
        'f_list'                     => 'Group Can View the Forums',
        'f_post'                     => 'Group Can Start New Topics',
        'm_approve'                  => 'Group Can Approve Posts',
        'f_noapprove'                => 'Group Can Post Without Approval',
        'a_warn_sys'                 => 'Group Can Alter and Edit the Systems Warning Configuration',
        'a_prune'                    => 'Group Can Alter and Edit the User Pruning System',
        'a_aauth'                    => 'Group Can Alter the Administrator Permission Class',
        'a_uauth'                    => 'Group Can Alter the User Permission Class',
    ),

    'ACP_GROUPS_PERMISSIONS'         => 'Group Permissions',
    'LEVELS'                         =>	'User Class Levels',
    'USER__PERMISSIONS'              => 'User Permissions',
    'ADMIN_PERMISSIONS'              => 'Administrator Permissions',
    'MODERATOR_PERMISSIONS'          => 'Moderator Permissions',
    'ACP_GROUPS_PERMISSIONS_EXPLAIN' => 'Here you can Assign Global Permissions to Groups - User Permissions, Global Moderator Permissions and Administrator Permissions. <ul><li>User Permissions include the ability to use Avatars, send Private Messages etc. <li>Global Moderator Permissions include the ability to Approve Posts, Manage Topics, Manage Bans etc.<li>Administrator Permissions include the ability to Alter Permissions, Define Custom BBCodes, Manage Forums etc.</ul>Individual User Permissions should ONLY be changed in rare occasions, the preferred method is putting Users in Groups and assigning the Groups Permissions.',

    'ACP_GROUPS_MANAGE_EXPLAIN'      => 'From here you can Administer ALL your User Groups. You can Create, Edit and Delete Existing Groups. Furthermore, you may choose Group Leaders, Toggle Open/Hidden/Closed Group Status and Set the Groups Name and Description.<br /><br />',

    'GROUP_EDIT_EXPLAIN'             => 'From here you can Edit an Existing Group. You can change its Name, Description and Type (Open, Closed, etc.). You can also set certain Group Wide Options such as Colouration, Rank, etc. Changes made here Override Users Current Settings. Please Note that Group Members Can Override Group Avatar Settings, unless you Set the appropriate User Permissions.<br /><br />',

    'COPY_PERMISSIONS'               => 'Copy Permissions from',
    'COPY_PERMISSIONS_EXPLAIN'       => 'Once Created, the Group will have the same Permissions as the one you Select here.',
    'LOOK_UP_GROUP'                  => 'Look up User Group',
    'ACL_SET'                        => 'Setting Permissions',
    'ACL_SET_EXPLAIN'                => 'Permissions are based on a simple <samp>YES</samp>/<samp>NO</samp> System. Setting an Option to <samp>NEVER</samp> for a User or User Group Overrides any Other Value Assigned to it. If you DO NOT wish to Assign a Value for an Option for this User or Group, Select <samp>NO</samp>. If Values are Assigned to this Option elsewhere they will be used in Preference, else <samp>NEVER</samp> is assumed. All Objects Marked (with the Checkbox in front of them) will Copy the Permission Set you Defined.',

    'APPLY_ALL_PERMISSIONS'          => 'Apply ALL Permissions',
    'GROUP'                          => 'Group',
    'INVALED_PERM_ID'                =>	'An Error has Occurred you have Selected an Invalid or Non Exiting ID',
    'INVALED_PERM_NAME'              =>	'You have entered an Invalid Permission Name<br />The Name can NOT be Blank or contain Blank Spaces',

    'INVALED_PERM_TAG'               =>	'You have NOT Selected a Proper Permission Group',
    'INVALED_PERM_DESC'              =>	'You Must Enter a Description for this Permission',
    'GROUPS'                         => 'Groups',
    'EDIT_PERM'                      =>	'Edit Permission',
    'EDIT_PERM_NAME'                 =>	'Permission Name',
    'EDIT_PERM_DESC'                 =>	'Permission Description',
    'EDIT_PERM_NAME_EXP'             =>	'DO NOT use Blank Spaces in the Name or Line Breaks<br />If you do, it will cause an Error if you want a Blank Space Please use an under score (_)',

    'EDIT_PERM_DESC_EXP'             =>	'Enter a Description for this Permission<br />If this is a Default Permission, and you leave it Blank it will use the Default Description',

    'TOTAL_MEMBERS'                  => 'Members',
    'VIEW_LEVELS'                    =>	'View Levels',
    'MEMBERS'                        => 'Members',
    'CREATE_GROUP'                   => 'Create New Group',
    'PRIMARY_GROUP'                  => 'Primary Group',
    'REMOVE_SELECTED'                => 'Remove Selected',
    'USER_GROUP_CHANGE'              => 'From "%1$s" Group to "%2$s"',
    'GROUP_DELET_EXPLAIN'            => 'You have "%1$s" Members set to "%2$s" Please Select a New Group to Set them to',
    'GROUP_AVATAR'                   => 'Group Avatar',
    'GROUP_COLOR'                    => 'Group Colour',
    'GROUP_COLOR_EXPLAIN'            => 'Defines the Colour that Members Usernames will appear in, leave Blank for User Default.',
    'GROUP_CREATED'                  => 'Group has been Created Successfully.',
    'GROUP_DEFAULT'                  => 'Make Group Default for Member',
    'GROUP_DEFS_UPDATED'             => 'Default Group Set for ALL Selected Members.',
    'GROUP_DELETED'                  => 'Group Deleted and User Default Groups Set Successfully.',
    'GROUP_DESC'                     => 'Group Description',
    'GROUP_LEGEND'                   => 'Display Group in Legend',
    'GROUP_LIST'                     => 'Current Members',
    'GROUP_LIST_EXPLAIN'             => 'This is a Complete List of ALL the Current Users with Membership of this Group. You can Delete Members (except in certain Special Groups) or Add New ones as you see fit.',

    'GROUP_MEMBERS'                  => 'Group Members',
    'GROUP_NAME'                     => 'Group Name',
    'GROUP_NAME_TAKEN'               => 'The Group Name you entered is Already In Use. Please Select an Alternative.',
    'GROUP_MAX_RECIPIENTS'           => 'Maximum Number of Allowed Recipients Per Private Message',
    'GROUP_MAX_RECIPIENTS_EXPLAIN'   => 'The Maximum Number of Allowed Recipients in a Private Message. If 0 is Entered, the Site Wide Setting will be used.',

    'GROUP_OPTIONS_SAVE'             => 'Group Wide Options',
    'GROUP_SETTINGS_SAVE'            => 'Group Wide Settings',
    'GROUP_MESSAGE_LIMIT'            => 'Group Private Message Limit Per Folder',
    'GROUP_MESSAGE_LIMIT_EXPLAIN'    => 'This Setting Overrides the Per User Folder Message Limit. A Value of 0 means the User Default Limit will be Used.',

    'GROUP_FOUNDER_MANAGE'           => 'Founder Manage Only',
    'GROUP_FOUNDER_MANAGE_EXPLAIN'   => 'Restrict Management of this Group to Founders Only. Users having Group Permissions are still able to see this Group as well as this Group\'s Members.',

    'GROUP_SKIP_AUTH'                => 'Exempt Group Leader from Permissions',
    'GROUP_SKIP_AUTH_EXPLAIN'        => 'If Enabled the Group Leader will NO Longer Inherit Permissions from this Group.',
    'GROUP_DETAILS'                  => 'Group Details',
    'GROUP_RANK'                     => 'Group Rank',
    'GROUP_RECEIVE_PM'               => 'Group able to Receive Private Messages',
    'GROUP_RECEIVE_PM_EXPLAIN'       => 'Please Note that Hidden Groups will NOT be Allowed to be Messaged, regardless of this Setting.',
    'GROUP_TYPE'                     => 'Group Type',
    'GROUP_TYPE_EXPLAIN'             => 'This determines which Users can Join or View this Group.',
    'GROUP_REQUEST'                  => 'Request',
    'GROUP_OPEN'                     => 'Open',
    'GROUP_CLOSED'                   => 'Closed',
    'GROUP_HIDDEN'                   => 'Hidden',
    'ADD_PERM'                       =>	'Add a New Permission',
    'ADD_PERM_ALREADY_PRESENT'       =>	'The Permission you are trying to Create Already Exists',
    'ACP_PERMISSIONS'                =>	'Permissions',
    'ACP_PERMISSIONS_EXPLAIN'        =>	'Here you can Edit, Add and Remove Permissions on the Site',
    'ACP_GROUPS_MANAGE'              => 'Manage Groups',
    'ACP_GROUPS_PERMISSIONS'         => 'Groups Permissions',
    'GROUP_UPDATED'                  => 'Group Preferences Updated Successfully.',
    'GROUP_USERS_REMOVE'             => 'Users Removed from Group and New Defaults Set Successfully.',
    'NO_GROUPS_CREATED'              => 'NO Groups Created Yet.',
    'NO_PERMISSIONS'                 => 'DO NOT Copy Permissions',
    'TOTAL_MEMBERS'                  => 'Members',
    'PERMISSION_UPDATED'             =>	'The Permission was Successfully Updated',
    'PERMISSION_ADDED'               =>	'The Permission was Successfully Added.  Please make sure to Assign this New Permission to the correct Groups',

    'CREATE_NEW_PERM'                =>	'Create New Permission',
    'USER_DEF_GROUPS'                => 'User Defined Groups',
    'ACP_GROUPS_MANAGE'              => 'Manage Groups',
    'USER_DEF_GROUPS_EXPLAIN'        => 'These are Groups Created by you or another Administrator of this Site. You can Manage Memberships as well as Edit Group Properties or Delete the Group.',

    'USER_GROUP_DEFAULT_EXPLAIN'     => 'Saying YES here will Set this Group as the Default Group for the Added Users.',
    'SPECIAL_GROUPS'                 => 'Pre Defined Groups',
    'SPECIAL_GROUPS_EXPLAIN'         => 'Pre Defined Groups are Special Groups, they can NOT be Deleted or Directly Modified. However, you can still Add Users and Alter Basic Settings.',

    'NO_GROUP'                       => 'NO Group Specified.',
    'NO_GROUPS_CREATED'              => 'NO Groups Created Yet.',
    'NO_PERMISSIONS'                 => 'DO NOT Copy Permissions',
    'NO_USERS'                       => 'You haven\'t entered any Users.',
    'NO_USERS_ADDED'                 => 'NO Users were Added to the Group.',
    'NO_VALID_USERS'                 => 'You haven\'t entered any Users Eligible for that Action.',
    'NO_AUTH_OPERATION'              => 'You DO NOT have the necessary Permissions to Complete this Operation.',
    'NOT_ALLOWED_MANAGE_GROUP'       => 'You are NOT Allowed to Manage this Group.',
    'G_ADMINISTRATORS'               => 'Administrator',
    'G_MODERATOR'                    => 'Moderator',
    'G_PREMIUM_USER'                 => 'VIP',
    'G_USER'                         => 'User',
    'USER_DEFAULT'                   => 'User Default',
    'AUTH_UPDATED'                   => 'Permissions have been Updated.',
    'GROUP_MEMBERS_EXPLAIN'          => 'This is a Complete Listing of ALL the Members of this User Group. It includes separate sections for Leaders, Pending and Existing Members. From here you can Manage ALL aspects of who has Membership of this Group and what their Role is. To Remove a Leader but keep them in the Group use Demote rather than Delete. Similarly use Promote to make an Existing Member a Leader.',

    'ADD_USERS'                      => 'Add Users',
    'ADD_USERS_EXPLAIN'              => 'Here you can Add New Users to the Group. You can select whether this Group becomes the New Default for the Selected Users. Additionally you can Define them as Group Leaders. Please enter each Username on a Separate Line.',

    'GROUP_LEAD'                     => 'Group Leaders',
    'GROUP_APPROVE'                  => 'Approve Member',
    'GROUP_APPROVED'                 => 'Approved Members',
    'USER_GROUP_LEADER'              => 'Set as Group Leader',
    'USER_GROUP_DEFAULT'             => 'Set as Default Group',
    'GROUPS_NO_MEMBERS'              => 'This Group has NO Members',
    'GROUPS_NO_MODS'                 => 'NO Group Leaders Defined',
    'MAKE_DEFAULT_FOR_ALL'           => 'Make Default Group for every Member',
    'GROUP_DEMOTE'                   => 'Demote Group Leader',
    'GROUP_PROMOTE'                  => 'Promote to Group Leader',
    'GROUP_DELETE'                   => 'Remove Member from Group',
    'FORM_INVALID'                   => 'The Submitted Form was Invalid. Try submitting again.',
    'NO_GROUP'                       => 'NO Group specified.',
    'GROUP_MODS_ADDED'               => 'New Group Leaders Added Successfully.',
    'GROUP_USERS_ADDED'              => 'New Users Added to the Group Successfully.',
    'GROUP_MODS_DEMOTED'             => 'Group Leaders Demoted Successfully.',
    'GROUP_MODS_PROMOTED'            => 'Group Members Promoted Successfully.',
    'USERS_APPROVED'                 => 'Users Approved Successfully.',
));

?>