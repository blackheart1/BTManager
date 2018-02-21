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
** File acp_cache.php 2018-02-21 07:27:00 Thor
**
** CHANGES
**
** 2018-02-21 - Added New Masthead
** 2018-02-21 - Added New !defined('IN_PMBT')
** 2018-02-21 - Fixed Spelling
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
	'CACHE'							=>	'Cache',
	'TITLE'							=>	'Site Cache',
	'TITLE_EXP'						=>	'Here is where you can Set the Maximum Time to Hold Cache Files for before they get Updated.<br>The longer you can keep them the better the Site Speed will be.',

	'_admpsql_time'					=>	'SQL Cache Time',
	'_admpsql_timeexplain'			=>	'These Files are some of the Base Query`s used for the Site such as the Configuration Settings, Shout Box Configuration and more',

	'_admptheme_time'				=>	'Theme Cache Time',
	'_admptheme_timeexplain'		=>	'Maximum Time to Hold Cache Files for your Themes',
	'_admpcache_dir'				=>	'Cache Directory',
	'_admpcache_direxplain'			=>	'This Directory will need to be Writeable by the System.<br>Do NOT add the trailing slash `/`',

	'ERR_SQL_TIME'					=>	'There seems to be an issue with the Time you set for the SQl Cache.  Please check the Form and try again. (%1$s)',

	'ERR_THEME_TIME'				=>	'There seems to be an issue with the Time you set for the Theme Cache.  Please check the Form and try again. (%1$s)',

	'ERR_CACHE_DIR_NOTSET'			=>	'There seems to be an issue locating the Cache Directory you chose (%1$s).  Please check the form and try again.',

	'ERR_CACHE_DIR_NOT_WRITEABLE'	=>	'The Directory is NOT Writeable (%1$s)',
	'ERR_ARRAY_MESS'				=>	'<li>%s</li>',
));

?>