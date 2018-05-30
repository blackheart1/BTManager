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
** And Joe Robertson (aka joeroberts/Black_Heart)
** Project Leaders: Black_Heart, Thor.
** File security.php 2018-05-30 07:04:00 Thor
**
** CHANGES
**
** 2018-04-13 - Changed Wording
** 2018-05-30 - Updated DOCTYPE
**/

header("HTTP/1.0 Error 404 - Page Not Found");

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
    <html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-gb" xml:lang="en-gb" />
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
            <meta name="generator" content="BTManager 3.0.1" />
            <meta http-equiv="pragma" content="no-cache" />
            <meta http-equiv="expires" content="-1" />
            <meta http-equiv="cache-control" content="no-cache" />
            <title>Error 404 - Page Not Found</title>
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

?>