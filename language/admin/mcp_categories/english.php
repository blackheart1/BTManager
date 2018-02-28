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
** File mcp_categories/english.php 2018-02-28 11:24:00 Thor
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
    'INTRO'              =>	'Categories',
    'INTRO_EXP'          =>	'In this Section you can Manage Torrent Categories that Users can Upload to. The Installation provides this Tracker with some Common Categories for Torrents.<br />You can Add/Edit or Delete Categories from here. Be careful that every Category MUST be Represented by a Significant Image for the Best Experience.<br />Images are in the <i>cat_pics</i> Directory of the Tracker\'s Root Directory.<br />If the Theme has a <i>pics/cat_pics</i> Directory within it, Images that are in that Directory will be Displayed instead of Global Images.',

    'INTRO_EDIT'         =>	'Add New Category Icon',
    'INTRO_EXP_EDIT'     =>	'In this Section you can Upload New Images to use for you Category Icons. At this time you are Allowed to use <b>png</b>, <b>gif</b>, <b>jpg</b> and <b>jpeg</b> Extensions. Remember that you have to make the <i>/cat_pics</i> Folder Writeable first. Icons must NOT exceed <b>48px x 48px</b> and must NOT be larger than <b>17kb</b>. Once you have Uploaded the New Icon, you can choose it from the Drop Down List above.',

    'NO_CATEGORIES'      =>	'NO Categories to Administer',
    'ADD_EDIT_CAT'       =>	'Add/Edit Category',
    'POSITION'           =>	'Position',
    'PARENT'             =>	'Parent',
    'AT_END'             =>	'At the End',
    'AT_BEGIN'           =>	'At the Beginning',
    'AFTER'              =>	'After %1$s',
    'SETASPARENT'        =>	'Set as Parent',
    'UPLOAD_CAT'         =>	'Upload Category Icon',
    'CAT_UPLOAD_TOBIG'   =>	'Category Icon is too Big',
    'INVALID_ICON'       =>	'Invalid Category Icon',
    'EMPTY_FILE'         =>	'The Icon you are Uploading is Empty',
    'FATAL_ERROR_UPLOAD' =>	'Fatal Error in Uploaded Category Icon.',
    'UPLOAD_SUCCESSFUL'  =>	'Upload was Successful the New Icon has been Added and you may now use it.',
    'UPLOAD_FAILED'      =>	'The Upload has Failed.  Please Check the Permissions of the <i>cat_pics</i> Directory and make sure that you do have the Permissions Set Properly',
));

?>