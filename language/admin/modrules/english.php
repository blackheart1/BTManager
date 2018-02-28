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
** File modrules/english.php 2018-02-28 11:34:00 Thor
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
    'TITLE'                =>	'Site Rules',
    'EXPLAIN'              =>	'In this Section you can Create, Edit and Delete the Site Rules',
    'MESSAGE_BODY_EXP'     =>	'',
    'SELECT_GROUP'         =>	'Select Group',
    'SELECT_GROUP_EXP'     =>	'Select a Group for this Rule',
    'SECTION_TITTLE'       =>	'Rule Section Title',
    'SECTION_TITTLE_EXP'   =>	'Give a Title for the Group of Rules',
    'PUBLIC_VIEW'          =>	'Public View',
    'PUBLIC_VIEW_EXP'      =>	'Are these Rules Viewable by the Public?',
    'RULES_FEALD_BLANK'    =>	'Rules Field was left Blank.  Please go back and Fill in Missing Fields!',
    'TITLE_BLANK'          =>	'Rules Title Field was left Blank.  Please go back and Fill in Missing Fields!',
    'PUPLIC_FEALD_BLANK'   =>	'You did NOT Set these Rules as Public or Private',
    'GROUP_NOT_SET'        =>	'You did NOT indicate what Group these Rules are for?',
    'GO_BACK'              =>	'Go Back!',
    'RULE_ADDED'           =>	'Your New Rules have been Added.',
    'ADD_NEW_RULE_SECTION' =>	'Add a New Rules Section.',
    'ADVANCED_RULE_INFO'   =>	'Advanced Rule Information',
    'IS_PUBLIC'            =>	'Is this a Public Rule?',
    'IS_PUBLIC_EXP'        =>	'Public Rules can be seen by Unregistered Users and ALL Groups',
    'VIEWABL_BY'           =>	'What Groups is this for?',
    'VIEWABL_BY_EXP'       =>	'These Rules Apply to these Groups and will ONLY be seen by them.',
));

?>