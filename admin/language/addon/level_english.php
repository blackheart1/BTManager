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
** Project Leaders: joeroberts, Thor.
**
** CHANGES
**
** 20-02-18 - Added New Masthead
** 20-02-18 - Added New !defined('IN_PMBT')
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
    'ACP_GROUPS_MANAGE_EXPLAIN'    => 'From this panel you can Administrate all your Usergroups. You can Delete, Create and Edit Existing Groups. Furthermore, you may choose Group Leaders, Toggle Open/Hidden/Closed Group Status and set the Group Name and Description.',
    'GROUP_EDIT_EXPLAIN'           => 'Here you can Edit an existing Group. You can change its Name, Description and Type (Open, Closed, etc.). You can also set certain Group Wide Options such as Colouration, Rank, etc. Changes made here override the Users Current Settings. Please note that Group Members can override Group Avatar Settings, unless you set appropriate User Permissions.',
    'COPY_PERMISSIONS'             => 'Copy Permissions From',
    'COPY_PERMISSIONS_EXPLAIN'     => 'Once created, the Group will have the same Permissions as the one you select here.',
    'CREATE_GROUP'                 => 'Create New Group',
    'PRIMARY_GROUP'                => 'Primary Group',
    'REMOVE_SELECTED'              => 'Remove Selected',
    'USER_GROUP_CHANGE'            => 'From ?%1$s? Group to ?%2$s?',
    'GROUP_AVATAR'                 => 'Group Avatar',
    'GROUP_COLOR'                  => 'Group Colour',
    'GROUP_COLOR_EXPLAIN'          => 'Defines the colour a members Usernames will appear in, leave Blank for User Default.',
    'GROUP_CREATED'                => 'Group has been Created Successfully.',
    'GROUP_DEFAULT'                => 'Make Group Default for Member',
    'GROUP_DEFS_UPDATED'           => 'Default Group Set for All Selected Members.',
    'GROUP_DELETED'                => 'Group Deleted and User Default Groups Set Successfully.',
    'GROUP_DESC'                   => 'Group Description',
    'GROUP_LEGEND'                 => 'Display Group in Legend',
    'GROUP_LIST'                   => 'Current Members',
    'GROUP_LIST_EXPLAIN'           => 'This is a complete list of all the current Users with Membership of this Group. You can Delete Members (except in certain Special Groups) or Add new ones as you see fit.',
    'GROUP_MEMBERS'                => 'Group Members',
    'GROUP_NAME'                   => 'Group Name',
    'GROUP_NAME_TAKEN'             => 'The Group name you entered is already in use, please select an alternative.',
    'GROUP_MAX_RECIPIENTS'         => 'Maximum number of Allowed Recipients per Private Message',
    'GROUP_MAX_RECIPIENTS_EXPLAIN' => 'The Maximum number of allowed Recipients in a Private Message. If 0 is entered, the Board-wide Setting is Used.',
    'GROUP_RECEIVE_PM'             => 'Group able to receive Private Messages',
    'GROUP_UPDATED'                => 'Group Preferences Updated Successfully.',
    'NO_GROUPS_CREATED'            => 'No Groups Created yet.',
    'NO_PERMISSIONS'               => 'Do Not Copy Permissions',
    'TOTAL_MEMBERS'                => 'Members',
    'USER_DEF_GROUPS_EXPLAIN'      => 'These are Groups created by you or another Admin on this board. You can Manage Memberships as well as Edit Group Properties or even Delete the Group.',
    'USER_GROUP_DEFAULT_EXPLAIN'   => 'Saying yes here will set this Group as the Default Group for the Added Users.'
));

?>