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
** File acp_attachments/english.php 2018-09-14 10:31:00 Thor
**
** CHANGES
**
** 2018-02-21 - Added New Masthead
** 2018-02-21 - Added New !defined('IN_PMBT')
** 2018-02-21 - Fixed Spelling
** 2018-03-25 - Amended !defined('IN_PMBT')
** 2018-03-25 - Amended the Wording of some Sentences
** 2018-03-28 - Amended !defined('IN_PMBT') Corrected Path
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
    'BYTES'                    => 'Bytes',
    'KB'                       => 'KB',
    'KIB'                      => 'KiB',
    'MB'                       => 'MB',
    'MIB'                      => 'MiB',
    'DIRECTORY_DOES_NOT_EXIST' => 'The Entered Path %s DOES NOT Exist.',
    'DIRECTORY_NOT_DIR'        => 'The Entered Path %s is NOT a Directory.',
    'DIRECTORY_NOT_WRITABLE'   => 'The Entered Path %s is NOT Writeable.',
    'WARNING'                  => 'Warning',

    'ACP_ATTACHMENT_SETTINGS_EXPLAIN' => 'Here you can Configure the Main Settings for Attachments and the Associated Special Categories.<br /><br />',

    'ACP_EXTENSION_GROUPS_EXPLAIN'    => 'Here you can Add, Delete, Modify or Disable your Extension Groups.  Further Options Include Assigning a Special Category to them, changing the Download Mechanism and Defining an Upload Icon which will be Displayed in front of the Attachment which belongs to the Group.<br /><br />',

    'ACP_MANAGE_EXTENSIONS_EXPLAIN'   => 'Here you can Manage your Allowed Extensions.  To Activate your Extensions, please refer to the Extension Groups Management Panel.  We Strongly Recommend <strong>NOT</strong> Allowing Scripting Extensions (such as <em>php</em>, <em>php3</em>, <em>php4</em>, <em>phtml</em>, <em>pl</em>, <em>cgi</em>, <em>py</em>, <em>rb</em>, <em>asp</em>, <em>aspx</em>, and so forth).<br /><br />',

    'ACP_ORPHAN_ATTACHMENTS_EXPLAIN'  => 'Here you are able to see Orphaned Files. This happens mostly when Users are Attaching Files but NOT Submitting the Post.  Here you are able to Delete or Attach the Files to Existing Posts.  Attaching to Posts Requires a Valid Post ID.  You have to determine this ID by yourself.  This will Assign the already Uploaded Attachment to the Post you Entered.<br /><br />',

    'ADD_EXTENSION'          => 'Add Extension',
    'ADD_EXTENSION_GROUP'    => 'Add Extension Group',
    'ADMIN_UPLOAD_ERROR'     => 'Errors while trying to Attach File %s.',
    'ALLOWED'                => 'Allowed',
    'ALLOWED_FORUMS'         => 'Allowed Forums',
    'ALLOWED_FORUMS_EXPLAIN' => 'Able to Post the Assigned Extensions at the Selected (or ALL, if Selected) Forums.',
    'ALLOWED_IN_PM_POST'     => 'Allowed',
    'ALLOW_ATTACHMENTS'      => 'Allow Attachments',
    'ALLOW_ALL_FORUMS'       => 'Allow ALL Forums',
    'ALLOW_IN_PM'            => 'Allowed in Private Messaging',
    'ALLOW_PM_ATTACHMENTS'   => 'Allow Attachments in Private Messages',
    'ALLOW_SELECTED_FORUMS'  => 'Only Forums Selected below',
    'ASSIGNED_EXTENSIONS'    => 'Assigned Extensions',
    'ASSIGNED_GROUP'         => 'Assigned Extension Group',
    'ATTACH_EXTENSIONS_URL'  => 'Extensions',
    'ATTACH_EXT_GROUPS_URL'  => 'Extension Groups',
    'ATTACH_ID'              => 'ID',
    'ATTACH_MAX_FILESIZE'    => 'Maximum File Size',

    'ATTACH_MAX_FILESIZE_EXPLAIN'    => 'Maximum Size of each File.  If this Value is Set to Zero, the Uploadable Filesize is ONLY Limited by your PHP Configuration.',

    'ATTACH_MAX_PM_FILESIZE'         => 'Maximum File Size for Private Messages',
    'ATTACH_MAX_PM_FILESIZE_EXPLAIN' => 'Maximum Size of each File Attached to a Private Message.  Set to Zero for Unlimited.',
    'ATTACH_ORPHAN_URL'              => 'Orphaned Attachments',
    'ATTACH_POST_ID'                 => 'Post ID',
    'ATTACH_QUOTA'                   => 'Total Attachment Quota',

    'ATTACH_QUOTA_EXPLAIN'           => 'Maximum Drive Space Available for Attachments for the Entire Site.  Set to Zero for Unlimited.',

    'ATTACH_TO_POST'                 => 'Attach File to Post',
    'CAT_FLASH_FILES'                => 'Flash Files',
    'CAT_IMAGES'                     => 'Images',
    'CAT_QUICKTIME_FILES'            => 'Quicktime Media Files',
    'CAT_RM_FILES'                   => 'RealMedia, Media Files',
    'CAT_WM_FILES'                   => 'Windows Media, Media Files',
    'CHECK_CONTENT'                  => 'Check Attachment Files',
    'CHECK_CONTENT_EXPLAIN'          => 'Some Browsers can be Tricked to assume an Incorrect Mimetype for Uploaded Files.  This Option ensures that such Files which are likely to cause this are Rejected.',

    'CREATE_GROUP'                   => 'Create New Group',
    'CREATE_THUMBNAIL'               => 'Create Thumbnail',
    'CREATE_THUMBNAIL_EXPLAIN'       => 'Create a Thumbnail in ALL Possible Situations.',
    'DEFINE_ALLOWED_IPS'             => 'Define Allowed IP\'s/Hostnames',
    'DEFINE_DISALLOWED_IPS'          => 'Define Disallowed IP\'s/Hostnames',
    'DOWNLOAD_ADD_IPS_EXPLAIN'       => 'To Specify Several Different IP\'s or Hostnames Enter Each on a New Line.  To Specify a Range of IP Addresses, Separate the Start and End with a Hyphen (<strong>-</strong>).  To Specify a Wildcard use <strong>*</strong> (Asterix).',

    'DOWNLOAD_REMOVE_IPS_EXPLAIN'    => 'You can Remove Multiple IP Addresses in one go, simply Click on the IP Addresses that you wish to Remove and Click Submit.  Excluded IP\'s have a Blue Background.',

    'DISPLAY_INLINED'                => 'Display Images Inline',
    'DISPLAY_INLINED_EXPLAIN'        => 'If Set to NO then Image Attachments will Show as a Link.',
    'DISPLAY_ORDER'                  => 'Attachment Display Order',
    'DISPLAY_ORDER_EXPLAIN'          => 'Display Attachments Ordered by Time.',
    'EDIT_EXTENSION_GROUP'           => 'Edit Extension Group',
    'EXCLUDE_ENTERED_IP'             => 'Enable this to Exclude the Entered IP/Hostname.',
    'EXCLUDE_FROM_ALLOWED_IP'        => 'Exclude IP from Allowed IP\'s/Hostnames List',
    'EXCLUDE_FROM_DISALLOWED_IP'     => 'Exclude IP from Disallowed IP\'s/Hostnames List',
    'EXTENSION'                      => 'Extension',
    'EXTENSIONS_UPDATED'             => 'Extensions Successfully Updated.',
    'EXTENSION_EXIST'                => 'The Extension <em>%s</em> already Exists.',
    'EXTENSION_GROUP'                => 'Extension Group',
    'EXTENSION_GROUPS'               => 'Extension Groups',
    'EXTENSION_GROUP_DELETED'        => 'Extension Group Successfully Deleted.',
    'EXTENSION_GROUP_EXIST'          => 'The Extension Group <em>%s<em> already Exists.',
    'EXT_GROUP_ARCHIVES'             => 'Archives',
    'EXT_GROUP_DOCUMENTS'            => 'Documents',
    'EXT_GROUP_DOWNLOADABLE_FILES'   => 'Downloadable Files',
    'EXT_GROUP_FLASH_FILES'          => 'Flash Files',
    'EXT_GROUP_IMAGES'               => 'Images',
    'EXT_GROUP_PLAIN_TEXT'           => 'Plain Text',
    'EXT_GROUP_QUICKTIME_MEDIA'      => 'Quicktime Media',
    'EXT_GROUP_REAL_MEDIA'           => 'Real Media',
    'EXT_GROUP_WINDOWS_MEDIA'        => 'Windows Media',
    'GO_TO_EXTENSIONS'               => 'Go to the Extension Management Screen',
    'GROUP_NAME'                     => 'Group Name',
    'IP_HOSTNAME'                    => 'IP Addresses or Hostnames',
    'IMAGE_LINK_SIZE'                => 'Image Link Dimensions',

    'IMAGE_LINK_SIZE_EXPLAIN'        => 'Display Image Attachments as an Inline Text Link if the Image is Larger than this.  To Disable this Option, Set the Values to 0px by 0px.',

    'IMAGICK_PATH'                   => 'ImageMagick Path',
    'IMAGICK_PATH_EXPLAIN'           => 'Full Path to the ImageMagick Convert Application, e.g. <em>/usr/bin/</em>',
    'MAX_ATTACHMENTS'                => 'Maximum Number of Attachments Per Post',
    'MAX_ATTACHMENTS_PM'             => 'Maximum Number of Attachments Per Private Message',
    'MAX_EXTGROUP_FILESIZE'          => 'Maximum File Size',
    'MAX_IMAGE_SIZE'                 => 'Maximum Image Dimensions',

    'MAX_IMAGE_SIZE_EXPLAIN'         => 'Maximum Size of Image Attachments.  To Disable this Option, Set the Values to 0px by 0px.',

    'MAX_THUMB_WIDTH'                => 'Maximum Thumbnail Width in Pixels',
    'MAX_THUMB_WIDTH_EXPLAIN'        => 'A Generated Thumbnail will NOT Exceed the Width Set Here.',
    'MIN_THUMB_FILESIZE'             => 'Minimum Thumbnail File Size',
    'MIN_THUMB_FILESIZE_EXPLAIN'     => 'DO NOT Create a Thumbnail for Images Smaller than this.',
    'MODE_INLINE'                    => 'Inline',
    'MODE_PHYSICAL'                  => 'Physical',
    'NOT_ALLOWED_IN_PM'              => 'Only Allowed in Posts',
    'NOT_ALLOWED_IN_PM_POST'         => 'NOT Allowed',
    'NOT_ASSIGNED'                   => 'NOT Assigned',
    'NO_EXT_GROUP'                   => 'None',
    'NO_EXT_GROUP_NAME'              => 'No Group Name Entered',
    'NO_EXT_GROUP_SPECIFIED'         => 'No Extension Group Specified.',
    'NO_FILE_CAT'                    => 'None',
    'NOTIFY'                         => 'Notification',
    'NO_IPS_DEFINED'                 => 'No IP Addresses or Hostnames Defined',
    'NO_IMAGE'                       => 'No Image',

    'NO_THUMBNAIL_SUPPORT'           => 'Thumbnail Support has been Disabled.  For Proper Functionality either the GD Extension or ImageMagick Needs to be Installed.  Both were NOT found.',

    'NO_UPLOAD_DIR'                  => 'The Upload Directory you Specified DOES NOT Exist.',

    'NO_WRITE_UPLOAD'                => 'The Upload Directory you Specified can NOT be Written to.  Please Alter the Permissions to Allow the Web Server to Write to it.',

    'ONLY_ALLOWED_IN_PM'             => 'Only Allowed in Private Messages',
    'ORDER_ALLOW_DENY'               => 'Allow',
    'ORDER_DENY_ALLOW'               => 'Deny',
    'REMOVE_ALLOWED_IPS'             => 'Remove or Include <em>Allowed</em> IP\'s/Hostnames',
    'REMOVE_DISALLOWED_IPS'          => 'Remove or Include <em>Disallowed</em> IP\'s/Hostnames',
    'SEARCH_IMAGICK'                 => 'Search for ImageMagick',
    'SECURE_ALLOW_DENY'              => 'Allow/Deny List',

    'SECURE_ALLOW_DENY_EXPLAIN'      => 'Change the Default Behaviour when Secure Downloads are Enabled on the Allow/Deny List to that of a <strong>Whitelist</strong> (Allow) or a <strong>Blacklist</strong> (Deny).',

    'SECURE_DOWNLOADS'               => 'Enable Secure Downloads',
    'SECURE_DOWNLOADS_EXPLAIN'       => 'With this Option Enabled, Downloads are Limited to IP\'s/Hostnames you Define.',
    'SECURE_DOWNLOAD_NOTICE'         => 'Secure Downloads are NOT Enabled.  The Settings below will be applied after Enabling Secure Downloads.',

    'SECURE_DOWNLOAD_UPDATE_SUCCESS' => 'The IP List has been Updated Successfully.',
    'SECURE_EMPTY_REFERRER'          => 'Allow Empty Referrer',

    'SECURE_EMPTY_REFERRER_EXPLAIN'  => 'Secure Downloads are Based on Referrers.  Do you want to Allow Downloads for those Omitting the Referrer?',

    'SETTINGS_CAT_IMAGES'            => 'Image Category Settings',
    'SPECIAL_CATEGORY'               => 'Special Category',
    'SPECIAL_CATEGORY_EXPLAIN'       => 'Special Categories differ between the way presented within Posts.',
    'SUCCESSFULLY_UPLOADED'          => 'Successfully Uploaded.',
    'SUCCESS_EXTENSION_GROUP_ADD'    => 'Extension Group Successfully Added.',
    'SUCCESS_EXTENSION_GROUP_EDIT'   => 'Extension Group Successfully Updated.',
    'UPLOADING_FILES'                => 'Uploading Files',
    'UPLOADING_FILE_TO'              => 'Uploading File %1$s to Post Number %2$d',
    'UPLOAD_DENIED_FORUM'            => 'You DO NOT have Permission to Upload Files to the Forum %s.',
    'UPLOAD_DIR'                     => 'Upload Directory',

    'UPLOAD_DIR_EXPLAIN'             => 'Storage Path for Attachments.  Please Note that if you change this Directory while already having Uploaded Attachments you will Need to Manually Copy the Files to their New Location.',

    'UPLOAD_ICON'                    => 'Upload Icon',
    'UPLOAD_NOT_DIR'                 => 'The Upload Location you specified DOES NOT appear to be a Directory.',
    'FILENAME'                       => 'File Name',
    'FILEDATE'                       => 'File Date',
    'FILESIZE'                       => 'File Size',
));

?>