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
** File irc/english.php 2018-02-28 08:48:00 Thor
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
    'IRC_INTRO'           => 'Configure BTManager\'s Built-in IRC Chat.',
    'IRC_INTRO_EXP'       => 'You can Configure every aspect of the PJIRC Client: Please Read PJIRC\'s Documentation before Editing Advanced Parameters.<br />

    <b>NOTICE</b>: file <i>include/irc.ini</i> MUST be Writeable',

    'IRC_SERVER'          => 'Server',
    'IRC_CHANNEL'         => 'Channel',
    'IRC_ADV_SETTING'     => 'Advanced Settings',
    'IRC_ADV_SETTING_EXP' => 'Here you can Configure PJIRC\'s Advanced Settings. According to PJIRC Documentation, Insert the Parameters with the following Syntax:<br />

    <i>name</i>           = </i>value</i>',

    'APPLY_SETTINGS'      => 'Apply Settings',
    'VALUE'               => 'VALUE',
    'RESET'               => 'Reset',
    'IRC_ENABLE'          => 'Enable IRC',
    'IRC_DISABLE'         => 'Disable IRC',
    'IRC_WRIET_PROT'      => 'You can NOT Delete <i>include/irc.ini</i> because it\'s Write Protected. Please Delete the File Manually. IRC Chat is still Enabled!',

    'IRC_INVALID_HOST'    => 'Invalid Hostname or IP Address',
    'IRC_INVALID_CHANNEL' => 'Invalid Channel Name',
    'IRC_INVALID_SYNTAX'  => 'Invalid Syntax for Advanced Parameters',
    'IRC_WRIET_PROT_SAVE' => '<p>You can NOT Save <i>include/irc.ini</i> because it\'s Write Protected. Please Save the File Manually with the Following Content:</p><p>&nbsp;</p><p class=\'nfo\'>%s</p>',

    'ERR_ARRAY_MESS'      => '<li><p>%s</p></li>',
    'ERROR'               =>'Error',
    'SAVED_SET'           =>'Settings Saved!',
));

?>