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
** File acp_attachments.php 2018-02-18 07:18:00 Thor
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

define('ATTACHMENT_CATEGORY_NONE', 0);
define('ATTACHMENT_CATEGORY_IMAGE', 1); // Inline Images
define('ATTACHMENT_CATEGORY_WM', 2); // Windows Media Files - Streaming
define('ATTACHMENT_CATEGORY_RM', 3); // Real Media Files - Streaming
define('ATTACHMENT_CATEGORY_THUMB', 4); // Not used within the Database, only while displaying posts
define('ATTACHMENT_CATEGORY_FLASH', 5); // Flash/SWF files
define('ATTACHMENT_CATEGORY_QUICKTIME', 6); // Quicktime/Mov Files

$lang = array_merge($lang, array(
    'BYTES'                           => 'Bytes',
    'KB'                              => 'KB',
    'KIB'                             => 'KiB',
    'MB'                              => 'MB',
    'MIB'                             => 'MiB',
    'DIRECTORY_DOES_NOT_EXIST'        => 'The entered Path “%s” Does NOT Exist.',
    'DIRECTORY_NOT_DIR'               => 'The entered Path “%s” is NOT a Directory.',
    'DIRECTORY_NOT_WRITABLE'          => 'The entered Path “%s” is NOT Writeable.',
    'WARNING'                         => 'Warning',
    'ACP_ATTACHMENT_SETTINGS_EXPLAIN' => 'Here you can Configure the Main Settings for Attachments and the Associated Special Categories.',

    'ACP_EXTENSION_GROUPS_EXPLAIN'    => 'Here you can Add, Delete, Modify or Disable your Extension Groups. Further options include assigning a Special Category to them, changing the Download Mechanism and defining an Upload Icon which will be displayed in front of the attachment which belongs to the Group.',

    'ACP_MANAGE_EXTENSIONS_EXPLAIN'   => 'Here you can manage your Allowed Extensions. To Activate your Extensions, please refer to the Extension Groups Management Panel. We strongly recommend NOT allowing Scripting Extensions (such as <code>php</code>, <code>php3</code>, <code>php4</code>, <code>phtml</code>, <code>pl</code>, <code>cgi</code>, <code>py</code>, <code>rb</code>, <code>asp</code>, <code>aspx</code>, and so forth…).',

    'ACP_ORPHAN_ATTACHMENTS_EXPLAIN'  => 'Here you are able to see Orphaned Files. This happens mostly when Users are Attaching Files but NOT submitting the Post. You are able to Delete the Files or Attach them to Existing Posts. Attaching to Posts requires a valid Post ID.  You have to determine this ID by yourself. This will assign the already Uploaded Attachment to the Post you entered.',

    'ADD_EXTENSION'                   => 'Add Extension',
    'ADD_EXTENSION_GROUP'             => 'Add Extension Group',
    'ADMIN_UPLOAD_ERROR'              => 'Errors while trying to attach file: “%s”.',
    'ALLOWED'                         => 'Allowed',
    'ALLOWED_FORUMS'                  => 'Allowed Forums',
    'ALLOWED_FORUMS_EXPLAIN'          => 'Able to post the assigned extensions at the selected (or all if selected) Forums.',
    'ALLOWED_IN_PM_POST'              => 'Allowed',
    'ALLOW_ATTACHMENTS'               => 'Allow Attachments',
    'ALLOW_ALL_FORUMS'                => 'Allow All Forums',
    'ALLOW_IN_PM'                     => 'Allowed in Private Messaging',
    'ALLOW_PM_ATTACHMENTS'            => 'Allow Attachments in Private Messages',
    'ALLOW_SELECTED_FORUMS'           => 'Only Forums Selected Below',
    'ASSIGNED_EXTENSIONS'             => 'Assigned Extensions',
    'ASSIGNED_GROUP'                  => 'Assigned Extension Group',
    'ATTACH_EXTENSIONS_URL'           => 'Extensions',
    'ATTACH_EXT_GROUPS_URL'           => 'Extension Groups',
    'ATTACH_ID'                       => 'ID',
    'ATTACH_MAX_FILESIZE'             => 'Maximum File Size',
    'ATTACH_MAX_FILESIZE_EXPLAIN'     => 'Maximum Size of each File. If this value is 0, the Uploadable Filesize is ONLY limited by your PHP Configuration.',
    'ATTACH_MAX_PM_FILESIZE'          => 'Maximum File Size Messaging',
    'ATTACH_MAX_PM_FILESIZE_EXPLAIN'  => 'Maximum Size of each File, with 0 being Unlimited, attached to a Private Message.',
    'ATTACH_ORPHAN_URL'               => 'Orphan Attachments',
    'ATTACH_POST_ID'                  => 'Post ID',
    'ATTACH_QUOTA'                    => 'Total Attachment Quota',
    'ATTACH_QUOTA_EXPLAIN'            => 'Maximum Drive Space available for Attachments for the whole board, with 0 being Unlimited.',
    'ATTACH_TO_POST'                  => 'Attach File to Post',
    'CAT_FLASH_FILES'                 => 'Flash Files',
    'CAT_IMAGES'                      => 'Images',
    'CAT_QUICKTIME_FILES'             => 'Quicktime Media Files',
    'CAT_RM_FILES'                    => 'RealMedia Media Files',
    'CAT_WM_FILES'                    => 'Windows Media Media Files',
    'CHECK_CONTENT'                   => 'Check Attachment Files',
    'CHECK_CONTENT_EXPLAIN'           => 'Some browsers can be tricked to assume an incorrect mimetype for Uploaded Files. This option ensures that such files likely to cause this are rejected.',

    'CREATE_GROUP'                    => 'Create New Group',
    'CREATE_THUMBNAIL'                => 'Create Thumbnail',
    'CREATE_THUMBNAIL_EXPLAIN'        => 'Create a Thumbnail in all possible situations.',
    'DEFINE_ALLOWED_IPS'              => 'Define Allowed IPs/hostnames',
    'DEFINE_DISALLOWED_IPS'           => 'Define Disallowed IPs/hostnames',
    'DOWNLOAD_ADD_IPS_EXPLAIN'        => 'To specify several different IPs or hostnames enter each on a new line. To specify a range of IP Addresses separate the Start and End with a hyphen (-), to specify a wildcard use “*”.',

    'DOWNLOAD_REMOVE_IPS_EXPLAIN'     => 'You can remove multiple IP addresses in one go using the appropriate combination of mouse and keyboard for your computer and browser. Excluded IPs have a blue background.',

    'DISPLAY_INLINED'                 => 'Display Images Inline',
    'DISPLAY_INLINED_EXPLAIN'         => 'If set to No Image Attachments will show as a link.',
    'DISPLAY_ORDER'                   => 'Attachment Display Order',
    'DISPLAY_ORDER_EXPLAIN'           => 'Display Attachments Ordered by Time.',
    'EDIT_EXTENSION_GROUP'            => 'Edit Extension Group',
    'EXCLUDE_ENTERED_IP'              => 'Enable this to Exclude the entered IP/hostname.',
    'EXCLUDE_FROM_ALLOWED_IP'         => 'Exclude IP from Allowed IPs/hostnames',
    'EXCLUDE_FROM_DISALLOWED_IP'      => 'Exclude IP from Disallowed IPs/hostnames',
    'EXTENSION'                       => 'Extension',
    'EXTENSIONS_UPDATED'              => 'Extensions Successfully Updated.',
    'EXTENSION_EXIST'                 => 'The Extension %s Already Exists.',
    'EXTENSION_GROUP'                 => 'Extension Group',
    'EXTENSION_GROUPS'                => 'Extension Groups',
    'EXTENSION_GROUP_DELETED'         => 'Extension Group Successfully Deleted.',
    'EXTENSION_GROUP_EXIST'           => 'The Extension Group %s already exists.',
    'EXT_GROUP_ARCHIVES'              => 'Archives',
    'EXT_GROUP_DOCUMENTS'             => 'Documents',
    'EXT_GROUP_DOWNLOADABLE_FILES'    => 'Downloadable Files',
    'EXT_GROUP_FLASH_FILES'           => 'Flash Files',
    'EXT_GROUP_IMAGES'                => 'Images',
    'EXT_GROUP_PLAIN_TEXT'            => 'Plain Text',
    'EXT_GROUP_QUICKTIME_MEDIA'       => 'Quicktime Media',
    'EXT_GROUP_REAL_MEDIA'            => 'Real Media',
    'EXT_GROUP_WINDOWS_MEDIA'         => 'Windows Media',
    'GO_TO_EXTENSIONS'                => 'Go to Extension Management Screen',
    'GROUP_NAME'                      => 'Group Name',
    'IP_HOSTNAME'                     => 'IP addresses or hostnames',
    'IMAGE_LINK_SIZE'                 => 'Image Link Dimensions',
    'IMAGE_LINK_SIZE_EXPLAIN'         => 'Display Image Attachment as an Inline Text Link, if the image is larger than this. To Disable this behaviour, set the values to 0px by 0px.',

    'IMAGICK_PATH'                    => 'ImageMagick Path',
    'IMAGICK_PATH_EXPLAIN'            => 'Full path to the ImageMagick convert application, e.g. <samp>/usr/bin/</samp>.',
    'MAX_ATTACHMENTS'                 => 'Maximum number of Attachments per Post',
    'MAX_ATTACHMENTS_PM'              => 'Maximum number of Attachments per Private Message',
    'MAX_EXTGROUP_FILESIZE'           => 'Maximum File Size',
    'MAX_IMAGE_SIZE'                  => 'Maximum Image Dimensions',
    'MAX_IMAGE_SIZE_EXPLAIN'          => 'Maximum Size of Image Attachments. Set both values to 0px by 0px to Disable Dimension Checking.',
    'MAX_THUMB_WIDTH'                 => 'Maximum thumbnail width in pixel',
    'MAX_THUMB_WIDTH_EXPLAIN'         => 'A generated thumbnail will NOT exceed the width set here.',
    'MIN_THUMB_FILESIZE'              => 'Minimum thumbnail File Size',
    'MIN_THUMB_FILESIZE_EXPLAIN'      => 'Do NOT Create a thumbnail for images smaller than this.',
    'MODE_INLINE'                     => 'Inline',
    'MODE_PHYSICAL'                   => 'Physical',
    'NOT_ALLOWED_IN_PM'               => 'Only allowed in Posts',
    'NOT_ALLOWED_IN_PM_POST'          => 'Not Allowed',
    'NOT_ASSIGNED'                    => 'Not Assigned',
    'NO_EXT_GROUP'                    => 'None',
    'NO_EXT_GROUP_NAME'               => 'No Group Name entered',
    'NO_EXT_GROUP_SPECIFIED'          => 'No Extension Group specified.',
    'NO_FILE_CAT'                     => 'None',
    'NOTIFY'                          => 'Notification',
    'NO_IPS_DEFINED'                  => 'No IP addresses or hostnames defined',
    'NO_IMAGE'                        => 'No Image',
    'NO_THUMBNAIL_SUPPORT'            => 'Thumbnail support has been Disabled. For proper functionality either the GD Extension needs to be available or ImageMagick needs to be installed. Both were NOT found.',

    'NO_UPLOAD_DIR'                   => 'The Upload Directory you specified does NOT Exist.',
    'NO_WRITE_UPLOAD'                 => 'The Upload Directory you specified cannot be written to. Please alter the Permissions to allow the web server to write to it.',

    'ONLY_ALLOWED_IN_PM'              => 'Only Allowed in Private Messages',
    'ORDER_ALLOW_DENY'                => 'Allow',
    'ORDER_DENY_ALLOW'                => 'Deny',
    'REMOVE_ALLOWED_IPS'              => 'Remove or un-exclude <em>allowed</em> IPs/hostnames',
    'REMOVE_DISALLOWED_IPS'           => 'Remove or un-exclude <em>disallowed</em> IPs/hostnames',
    'SEARCH_IMAGICK'                  => 'Search for ImageMagick',
    'SECURE_ALLOW_DENY'               => 'Allow/Deny list',
    'SECURE_ALLOW_DENY_EXPLAIN'       => 'Change the default behaviour when Secure Downloads are Enabled of the Allow/Deny list to that of a <strong>Whitelist</strong> (Allow) or a <strong>Blacklist</strong> (Deny).',

    'SECURE_DOWNLOADS'                => 'Enable Secure Downloads',
    'SECURE_DOWNLOADS_EXPLAIN'        => 'With this option Enabled, Downloads are Limited to IP’s/hostnames you define.',
    'SECURE_DOWNLOAD_NOTICE'          => 'Secure Downloads are NOT Enabled. The settings below will be applied after Enabling Secure Downloads.',

    'SECURE_DOWNLOAD_UPDATE_SUCCESS'  => 'The IP list has been Updated Successfully.',
    'SECURE_EMPTY_REFERRER'           => 'Allow Empty Referrer',
    'SECURE_EMPTY_REFERRER_EXPLAIN'   => 'Secure Downloads are based on Referrers. Do you want to Allow Downloads for those omitting the Referrer?',

    'SETTINGS_CAT_IMAGES'             => 'Image Category Settings',
    'SPECIAL_CATEGORY'                => 'Special Category',
    'SPECIAL_CATEGORY_EXPLAIN'        => 'Special Categories differ between the way presented within Posts.',
    'SUCCESSFULLY_UPLOADED'           => 'Successfully Uploaded.',
    'SUCCESS_EXTENSION_GROUP_ADD'     => 'Extension Group Successfully Added.',
    'SUCCESS_EXTENSION_GROUP_EDIT'    => 'Extension Group Successfully Updated.',
    'UPLOADING_FILES'                 => 'Uploading Files',
    'UPLOADING_FILE_TO'               => 'Uploading File “%1$s” to Post Number %2$d…',
    'UPLOAD_DENIED_FORUM'             => 'You Do NOT have Permission to Upload Files to the Forum “%s”.',
    'UPLOAD_DIR'                      => 'Upload Directory',
    'UPLOAD_DIR_EXPLAIN'              => 'Storage Path for Attachments. Please Note that if you change this directory while already having Uploaded Attachments you will need to manually copy the files to their new location.',

    'UPLOAD_ICON'                     => 'Upload Icon',
    'UPLOAD_NOT_DIR'                  => 'The Upload Location you specified Does NOT appear to be a Directory.',
));

?>