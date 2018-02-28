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
** File image-bucket/english.php 2018-02-28 08:48:00 Thor
**
** CHANGES
**
** 2018-02-24 - Added New Masthead
** 2018-02-24 - Added New !defined('IN_PMBT')
** 2018-02-24 - Fixed Spelling
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
    'TITLE'                       => 'BitBucket',
    'TITLE_EXPLAIN'               => 'Configure your BitBucket Settings',
    'HEADER_SETTINGS'             => 'BitBucket Settings',
    '_admpallow'                  => 'Allow BitBucket',
    '_admpallowexplain'           => 'With this you can Allow or Deny Access<br />to the BitBucket.',
    '_admplevel'                  => 'BitBucket Access Level',
    '_admplevelexplain'           => 'Select the User Level which can use BitBucket!',
    '_admpmax_folder_size'        => 'Maximum Size of User Folder',
    '_admpmax_folder_sizeexplain' => 'Set the Maximum Size of Folder the User is Allowed to have in Bytes!',
    '_admpmax_file_size'          => 'Maximum Allowed Size of Image',
    '_admpmax_file_sizeexplain'   => 'Set the Maximum Size of an Image a User can Upload in Bytes!',
    'USER_IMAGES'                 => 'User Images',
    'FILE_NAME'                   => 'Filename',
    'FILE_SIZE'                   => 'File Size',
    'FOLDER_SIZE'                 => 'Folder Size',
    'NUM_FILES'                   => 'Total Files',
    'DELETE_FILE'                 => 'Delete File',
));

?>