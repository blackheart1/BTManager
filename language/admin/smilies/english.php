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
** File smilies/english.php 2018-02-28 21:27:00 Thor
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
    'CHOSE'          => 'Choose',
    'PL_AT_END'      => 'Place at the End',
    'PL_AFT_'        => 'Place After ',
    'PL_AT_BEGGIN'   => 'Place at the Beginning',
    'SMILIES'        => 'Smilies',
    'SMILIES_EXP'    => 'In this Section you can Manage Smilies that Users can Upload. Installation provides this Tracker with some Common Smilies for the Shoutbox, Descriptions and Forums.
    You can Add your Own or Edit Others. Be careful that every Smiley MUST be Represented by a Significant Tag for the best experience. Images are in the Smiles Directory off of the Tracker\'s Root Directory.',

    'NO_SET_SMILIES' => 'No Smilies are Set',
    'SMILE_CODE'     => 'Code',
    'SM_IMAGECODE'   => 'Image/Smiley',
    'SMILE_ALT'      => 'Alternate',
    'SMILE_ALT_NAME' => 'Alternate Name',
    'SMILE_SELEC'    => 'Smile Code',
    'SMILE_IMAGE'    => 'Smile Image',
    'AD_EDIT_SMILE'  => 'Add/Edit Smilies',
    'POSITION'       => 'Position',
));

?>