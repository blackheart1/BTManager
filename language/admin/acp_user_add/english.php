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
** File user_add/english.php 2018-09-15 07:55:00 Thor
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
    'NEW_USER_CREAT'      => 'Add New User',

    'NEW_USER_CREAT_EXP'  => 'Adding a New User via the Administrator Control Panel is the same as someone Registering a New Account, except that you don\'t have to Fill in any of the Required Fields or Agreements that are Imposed on the Registration Form, and you can Create the Account without a Valid email Address when using the Administrator CP.<br /><br />',

    'ERROR'               => 'Error!',
    'USER_NAME'           => 'User Name',

    'USER_NAME_EXP'       => 'Enter the Username of the User Here.<br />A Member\'s Username is used when logging in and is Displayed next to their Posts. ',

    'USER_NICK'           => 'Complete Name',
    'USER_NICK_EXP'       => 'Length must be between 3 and 20 Characters.',
    'USER_PASS'           => 'Password (Minimum of 5 Characters)',
    'USER_PASS_EXP'       => 'Enter the User\'s Password Here.',
    'USER_PASS_CON'       => 'Confirm Password',
    'USER_PASS_CON_EXP'   => 'Confirm the User\'s Password Here.',
    'USER_EMAIL'          => 'email Address',

    'USER_EMAIL_EXP'      => 'Enter the email Address of the User<br />This will be used when Contact is made between the User and the System or by Other User\'s, if Allowed?',

    'USER_UPLOAD'         => 'Uploaded',

    'USER_UPLOAD_EXP'     => 'Here you can Enter an Amount of Upload Data to the User\'s Account.  <strong>This is Optional</strong>',

    'USER_DOWNLOAD'       => 'Downloaded',

    'USER_DOWNLOAD_EXP'   => 'Here you can Enter an Amount of Download Data to the User\'s Account.  <strong>This is Optional</strong>',

    'USER_SEED'           => 'Seeding Bonus',

    'USER_SEED_EXP'       => 'Here you can Enter an Amount of Seeding Bonus to the User\'s Account.  <strong>This is Optional</strong>',

    'USER_INVITES'        => 'Invites',

    'USER_INVITES_EXP'    => 'Here you can Enter an Amount of Invites to the User\'s Account.  <strong>This is Optional</strong>',
    'USER_ACTIVE'         => 'Active',

    'USER_ACTIVE_EXP'     => 'By NOT Setting the User Active you will Receive a Link to provide the New User to use in Order for them to Activate the Account.<br />If they <strong>DO NOT</strong> Activate the Account within <strong>24 hours</strong> it will be Deleted.',

    'USER_LEVEL'          => 'Level',
    'USER_LEVEL_EXP'      => 'Set the Level you would like to have this User placed in.',
    'USER_GROUPS'         => 'Group',
    'USER_GROUPS_EXP'     => 'Set the Group you would like to have this User placed in.',
    'ERR_NO_EMAIL'        => 'email Address NOT Specified.',
    'ERR_EMAIL_ACSEST'    => 'The email Address you Entered is already Registered.',
    'ERR_EMAIL_NOT_VALID' => 'The email Address you Entered is NOT Valid.',
    'ERR_NO_NAME'         => 'Username NOT Specified.',
    'ERR_USER_ACSEST'     => 'Username already Exists.',
    'ERR_REGED_NO_ACTIVE' => 'User Registered but NOT Activated!!',
    'ERR_NO_PASS'         => 'NO Password Set',
    'ERR_PASS_NOT_MATCH'  => 'The Passwords you Entered DO NOT Match',
    'ERR_PASS_TO_SHORT'   => 'The Password you Entered is Too Short. (Minimum Length is 5 Characters)',
    'ERR_FORM_NOT_SET'    => 'Form NOT Submitted due to the following Errors.<br />',
    'MOD_COMENT'          => 'Account Created by Moderator',
    'ACTION_LOG'          => '<strong>%1$s</strong> Created a New Account for <strong>%2$s</strong>',

    'USER_VREATED'        => 'The User <strong>%1$s</strong> was Created.<br /> <strong>%2$s</strong> This Action was Logged.<br /> You can Check their Account and Verify the Information <a class=\'altlink\' href=\'user.php?op=profile&amp;id=%3$s\'>Here</a>',

    'ACTIVATE_LINK'       => 'The User will need to use this Link<br /> <strong>%1$s</strong> <br />to Confirm their Account within 24 hours or it will be Deleted.<br />',
));

?>