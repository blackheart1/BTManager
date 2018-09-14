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
** File shout_cast/english.php 2018-09-14 10:13:00 Thor
**
** CHANGES
**
** 2018-02-25 - Added New Masthead
** 2018-02-25 - Added New !defined('IN_PMBT')
** 2018-02-25 - Fixed Spelling
** 2018-04-11 - Amended the Wording of some Sentences
** 2018-04-11 - Amended !defined('IN_PMBT') Corrected Path
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
    'TITLE'                  => 'Shoutcast',

    'TITLE_EXPLAIN'          => 'Shoutcast Radio Configuration and Settings.  Here you can Setup your Shoutcast Radio to Display on your Site<br /><br />',

    'HEADER_SETTINGS'        => 'Shoutcast Settings',

    "_admpallow"             => "Allow Shoutcast",
    "_admpallowexplain"      => "With this you can Activate or Deactivate your Shoutcast Radio.",
    "_admpip"                => 'Shoutcast IP Address',
    "_admpipexplain"         => 'Enter the IP Address ONLY for your Shoutcast Radio.',
    "_admpport"              => 'Shoutcast Port',
    "_admpportexplain"       => 'Enter the Port for your Shoutcast Radio.',
    "_admpadmin_name"        => 'Shoutcast Administrator Name',
    "_admpadmin_nameexplain" => 'This is your Shoutcast Administrators Username, by Default this will be Administrator.',
    "_admpadmin_pass"        => 'Shoutcast Password.',

    "_admpadmin_passexplain" => 'Enter your Administrator Password for your Shoutcast Radio.  This is needed to Retrieve the Information from Your Shoutcast.',

    "_admphost_dj"           => 'Current DJ',
    "_admphost_djexplain"    => 'Enter the Name of the Person Disk Jockeying on the Shoutcast.',
));

?>