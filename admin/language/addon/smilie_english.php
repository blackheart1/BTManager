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

define("_admsmilies","Smilies");
define("_admsmiliesintro","In this section you can manage Smilies that Users may Upload. Installation provides this tracker with some common Smilies for Shoutbox, Descriptions and Forum.
You can add your own or edit others. Be careful as every Smilie must be represented by a significant Tag for best experience. Images are in the Smiles Directory of the tracker's Root Directory.");
define("_admnosmilies","No Smilies are Set");
define("_admcode","Code");
define("_admcodeimage","Image/Smilie");
define("_admsmiliealt","Alternate");
define("","Alternat Name");
define("_admsmilecode","Smile Code");
define("_admsmileimage","Smile Image");
define("_admaddsmilies","Add/Edit Smilies");

?>