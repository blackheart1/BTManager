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
** File searchcloud/english.php 2018-02-28 20:42:00 Thor
**
** CHANGES
**
** 2018-02-25 - Added New Masthead
** 2018-02-25 - Added New !defined('IN_PMBT')
** 2018-02-25 - Fixed Spelling
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
    'SC_CONFIG'         => 'Search Cloud Control',
    'USER_ONLY_RC'      => 'Record Only Users',
    'USER_ONLY_RC_EXP'  => 'Record Only <strong>Users</strong> Search Terms to Database',
    'HOW_MANY'          => 'How many',
    'HOW_MANY_EXP'      => 'How many Search Terms would you like to Display in the Search Cloud',
    'CONFIG_NOT_SET'    => 'There seems to be a Problem with your Entries.  Configuration NOT Set',
    'ERR_HOWMANY'       => 'The Entered Value for "<strong>How many</strong>" was NOT Numeric',
    'ERR_ACTIVE'        => 'The Entered Value for "<strong>Display Search Cloud</strong>" was NOT Set Properly',
    'ERR_USERONLY'      => 'The Entered Value for "<strong>Record Only Users</strong>" was NOT Set Properly',
    'SCBLOCKDSP'        => 'Display Search Cloud',
    'SCBLOCK_EXP'       => 'Display a Block with a Search Cloud. ALL Terms your Users Search for are Recorded and Displayed in a Cloud. The more often a Term is Searched, the Larger the Font Size/Weight will be.',
    'SCTERM'            => 'Search Term',
    'SCTERMS'           => 'Search Terms',
    'SCTITLEEXP'        => 'This Tool Allows you to List and Remove Search Terms that are Saved in the Database and Displayed in the Search Cloud. Terms are Ordered by Search Frequency and can be Searched.',
    'SCTIMES'           => 'Times Searched',
    'SCTERM_ID'         => 'Term ID',
    'SCTERM_REMOVED'    => 'Term Removed',
    'SCTERMREMOVE'      => 'Remove Term from the Database',
    'SCLOUD'            => 'Search Cloud',
    'SC_SET_UPDATED'    => 'Settings Updated Successfully',
    'PRUNE_SUCCESS'     => 'ALL Search Terms have been Removed',
    'CONFIRM_OPERATION' => 'Are you sure you wish to Remove ALL Search Terms?<br />This Action can NOT be Undone.',
    'DELETE_ALL'        => 'Delete ALL Terms',
));

?>