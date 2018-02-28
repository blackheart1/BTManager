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
** File mcp_filter/english.php 2018-02-28 11:30:00 Thor
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
    'INTRO'           =>	'Keyword Filter',
    'INTRO_EXP'       =>	'With the Keyword Filter, you can Stop Users from Uploading Torrents that may Violate the Tracker\'s Rules or Law Enforcement.<br>
    This Checks the Names of the Files within a torrent. Be careful to NOT insert any Common Words.',

    'KEYWORD'         =>	'KeyWord',
    'ADD_EDIT_KEYW'   =>	'Add/Edit keyword',
    'REASON'          =>	'Reason',
    'KEYWORD_ADDED'   =>	'Your New Keyword has been Successfully Added',
    'KEYWORD_UPDATED' =>	'Your Keyword has been Successfully Updated',
    'KEYWORD_REMOVED' =>	'Your Keyword has been Successfully Removed',
    'NOSET_KEY_WORDS' =>	'NO Filter Keywords',
    'MISSING_KYEWORD' =>	'Missing Keyword',
    'MISSING_REASON'  =>	'Missing Reason',
    'BAD_KEY_WORD'    =>	'Keyword must be between 5 and 50 Alphanumeric Characters',
    'BAD_REASON'      =>	'Reason must be a Maximum of 255 Characters Long',
));

?>