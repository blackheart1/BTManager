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
** File acp_requests/english.php 2018-03-28 09:57:00 Thor
**
** CHANGES
**
** 2018-02-23 - Added New Masthead
** 2018-02-23 - Added New !defined('IN_PMBT')
** 2018-02-23 - Fixed Spelling
** 2018-03-28 - Amended the Wording of some Sentences
** 2018-03-28 - Amended !defined('IN_PMBT') Corrected Path
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
    'YES_NO_OPTION' => array('1'=> 'Yes', '0' => 'No'),

    'INTRO'                     => 'Requests Configuration',
    'INTRO_EXP'                 => 'Configure the Requests System',
    '_admpenable'               => 'Enable Requests',
    '_admpenableexplain'        => 'Enable Requests System',
    '_admpclass_allowed'        => 'Access Level',
    '_admpclass_allowedexplain' => 'What Group is Allowed to Use the Requests System',
    'ERR_BAD_LEVEL'             => 'One or more of the Groups you Entered is NOT Valid.  Please Go Back and Try Again!',
    'CONFIG_NOT_SET'            => 'A Error Occurred while Processing the New Settings.  Please Read Below!',
 ));

?>