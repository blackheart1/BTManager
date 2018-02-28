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
** File ucp_pms/english.php 2018-02-28 21:45:00 Thor
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
    'READ_USER_PMS'           => 'Read PM\'s - Read a User\'s PM\'s',
    'HEADER_READ_USER'        => 'Read User\'s PM\'s',
    'USER_ID_SEARCH'          => 'User ID or Username',
    'USER_ID_SEARCH_EXP'      => 'Search using the User\'s ID or Name.  Only the Signup Name will be Searched',
    'LIST_OF_PMS'             => 'List Users with PM\'s',
    'LIST_OF_PMS_EXP'         => 'Show a List of Users with PM\'s and how many they have',
    'HEADER_SEARCH'           => 'Search for PM\'s',
    'SEARCH_PMS'              => 'Search for',
    'SEARCH_PMS_EXP'          => 'Separate each Search Term with a Space.<br />Each Search should be NO Less than 4 Characters Long.',

    'SEARCH_MATCH'            => 'Match',
    'EXACT_TEXT'              => 'The Exact Text',
    'ALL_WORDS'               => 'ALL of the Words',
    'ATLEAST_ONE_WORD'        => 'at least One of the Words',
    'LATEST_PMS'              => 'Latest PM\'s',
    'NUM_TO_SHOW'             => 'Number of PM\'s to Show',
    'RAED_USER_EXP'           => '',
    'PM_MANAGER'              => 'PM Management',
    'PM_MANAGER_EXP'          => 'PM Management is used to keep a eye on Users PM\'s to look for Spammers or Trouble Makers on your Site. This should <strong>ONLY</strong> be used if you have good reason to do so, and is <strong>NOT</strong> to be used for anything else.<br />Use this Tool to Search ALL Users PM\'s',

    'LATEST_HEADER'           => 'Show Last "%1$s" PM\'s',
    'LIST_HEADER'             => '',
    'HAVE_PMS_HEADER'         => 'Read PM\'s - List Users with PM\'s',
    'HEADER_SENT_PMS'         => '%1$s PM\'s Sent by %2$s',
    'HEADER_RESEAVED_PMS'     => '%1$s PM\'s Received for %2$s',
    'VIEW_PMS'                => 'View Private Message',
    'FROM'                    => 'From',
    'TO'                      => 'To',
    'SENT'                    => 'Sent',
    'LINK_TO_USER'            => 'Link goes to User\'s Details.',
    'GO_BACK'                 => 'Go Back',
    'LIST_USERS'              => 'List ALL Users',
    'LIST_ROW_COUNT'          => 'There are %1$s Users with %2$s PM\'s',
    'ERROR_MUST_ONE_WORD'     => 'You must Type in at least One Word to Search for.',
    'ERROR_MUST_FOUR_LETTERS' => 'You must Type in at least One Word to Search for.<br />Must be NO Less than 4 Characters Long.',
    'ERROR_LATEST_NUM'        => 'Enter a Positive Number Greater than 0.',
    'ERROR_NO_PMS'            => 'There are NO PM\'s to View.',
    'ERROR_EMPTY_FEALD'       => 'You Need to Enter a User ID or Username.',
    'ERROR_NO_SUCH_USER_NAME' => 'User <b>%1$s</b> DOES NOT Exist.',
    'ERROR_NO_SUCH_USER_ID'   => 'User ID: <b>%1$s</b> DOES NOT Exist.',
));

?>