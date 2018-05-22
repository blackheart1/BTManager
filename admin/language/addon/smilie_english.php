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
    include_once './../../../security.php';
    die ("Error 404 - Page Not Found");
}

if (empty($lang) || !is_array($lang))
{
    $lang = array();
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