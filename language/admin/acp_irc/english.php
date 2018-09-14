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
** File irc/english.php 2018-09-14 10:04:00 Thor
**
** CHANGES
**
** 2018-02-24 - Added New Masthead
** 2018-02-24 - Added New !defined('IN_PMBT')
** 2018-02-24 - Fixed Spelling
** 2018-03-29 - Amended the Wording of some Sentences
** 2018-03-29 - Amended !defined('IN_PMBT') Corrected Path
**/

if (!defined('IN_PMBT'))
{
    include_once './../../../security.php';
    die ("Error 404 - Page Not Found");
}

if (empty($lang) || !is_array($lang))
{
    $lang = array();
}

$lang = array_merge($lang, array(
    'IRC_INTRO'           => 'Configure BTManager\'s Built-in IRC Chat.',

    'IRC_INTRO_EXP'       => 'You can Configure every aspect of the PJIRC Client:  Please Read PJIRC\'s Documentation before Editing Advanced Parameters.<br />

    <strong>NOTICE</strong>: file <em>include/irc.ini</em> MUST be Writeable<br /><br />',

    'IRC_SERVER'          => 'Server',
    'IRC_CHANNEL'         => 'Channel',
    'IRC_ADV_SETTING'     => '<br />Advanced Settings',

    'IRC_ADV_SETTING_EXP' => 'Here you can Configure PJIRC\'s Advanced Settings.  According to PJIRC Documentation, Insert the Parameters with the following Syntax: <em>name</em> = <em>value</em><br /><br />',

    'APPLY_SETTINGS'      => 'Apply Settings',
    'VALUE'               => 'VALUE',
    'RESET'               => 'Reset',
    'IRC_ENABLE'          => 'Enable IRC',
    'IRC_DISABLE'         => 'Disable IRC',

    'IRC_WRIET_PROT'      => 'You can NOT Delete <em>include/irc.ini</em> because it\'s Write Protected.  Please Delete the File Manually.  IRC Chat is still Enabled!',

    'IRC_INVALID_HOST'    => 'Invalid Hostname or IP Address',
    'IRC_INVALID_CHANNEL' => 'Invalid Channel Name',
    'IRC_INVALID_SYNTAX'  => 'Invalid Syntax for Advanced Parameters',

    'IRC_WRIET_PROT_SAVE' => '<p>You can NOT Save <em>include/irc.ini</em> because it\'s Write Protected.  Please Save the File Manually with the Following Content:</p><p>&nbsp;</p><p>%s</p>',

    'ERR_ARRAY_MESS'      => '<li><p>%s</p></li>',
    'ERROR'               =>'Error',
    'SAVED_SET'           =>'Settings Saved!',
));

?>