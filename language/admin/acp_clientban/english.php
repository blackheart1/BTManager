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
** File acp_clientban/english.php 2018-02-27 12:06:00 Thor
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
	'INTRO'					=>	'Client Ban',
	'INTRO_EXP'				=>	'This is where you can Ban Torrent Clients!<br />You can either Ban the whole Client or one version of the Client <br />To Add a Client you will need the <b>pier_id</b> Information from the Client.<br />Example &micro;Torrent 1.8.1 you would Add UT1810.<br />The reason for the Ban will be shown in the Client so you will want to keep this short.',

	'REASON'				=>	'Reason',
	'CLIENT'				=>	'Client',
	'NO_CLIENT_BANS'		=>	'No Banned Client\'s At This Time',
	'BANNED_CLIENTS'		=>	'Current Banned Client\'s',
	'BANNED_CLIENTS_EXP'	=>	'Here is a list of the Currently Banned Client\'s and the Reason Why.',
	'BANNED_CLIENT'			=>	'Add/Edit Banned Client\'s',
	'BANNED_CLIENT_EXP'		=>	'Here you can Add/Edit Banned Client\'s and the Reason Why.',
	'CANCEL_MOD'			=>	'Cancel Modifications',
	'NO_REASON'				=>	'No Reason given for the Ban',
	'SUCES_BAN'				=>	'Client Successfully Banned',
	'SUCES_BAN_EXP'			=>	'The Client "%1$s" was Successfully Banned for "%2$s"',
	'SUCES_DEL'				=>	'Client Successfully Removed',
	'SUCES_DEL_EXP'			=>	'The Client was Successfully Removed from Banned ',
	'SUCES_EDT'				=>	'Client Successfully Edited',
	'SUCES_EDT_EXP'			=>	'The Client "%1$s" was Successfully Updated for "%2$s"',
	'CONFIRM_OPERATION'		=>	'Are you sure you wish to Remove this Client from the Ban list?',
 ));

?>