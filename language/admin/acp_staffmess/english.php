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
** File staffmess/english.php 2018-09-15 07:16:00 Thor
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
    'MAIN_TEXT'              => 'Mass Messages',
    'MAIN_INTRO_EXP'         => 'With this Tool you will be able to Send Multiple Messages out at the same time by either Mass PM or Mass email.<br /><br />',

    'ACP_EMAIL_BODY'         => "Message Received from  ".'%3$s'." on ".'%1$s'."  GMT.\n
    ---------------------------------------------------------------------\n\n
    ".'%2$s'." \n\n
    ---------------------------------------------------------------------\nRegards,\n
    ".'%3$s'." Staff\n
    ".'%4$s'."\n",

    'SECTION_TITLE_SENPM'    => 'Send a Mass PM',
    'SECTION_TITLE_SENEMAIL' => 'Send a Mass email',
    'BLOCK_TITLE'            => 'Mass Messenger',
    'MAY_USE_LINKS'          => 'You can use Links in your emails',
    'TX_BODY'                => 'Body',
    'TX_SUBJ'                => 'Subject',
    'BTACCESS_LEVEL'         => 'Access Level',
    'BTACCESS_LEVEL_PM_EXP'  => 'Users must be in the Specified Level to be PM\'ed if you Select a User Level Here',
    'BTACCESS_LEVEL_EXP'     => 'Users must be in the Specified Level to be emailed, if you Select a User Level Here',
    'BTACCESS_GROUP'         => 'Access Group',
    'BTACCESS_GROUP_PM_EXP'  => 'Users must be in the Specified Group to be PM\'ed if you Select a Usergroup Here',
    'BTACCESS_GROUP_EXP'     => 'Users must be in the Specified Group to be emailed if you Select a Usergroup Here',

    'MASS_MAIL_EXP'          => 'Here you can email a Message to either ALL of your Users or ALL Users of a Specific Group if they have the Option to Receive Mass emails Enabled.  To achieve this an email will be Sent Out to the Administrators email Address supplied, with a Blind Carbon Copy Sent to ALL Recipients.  The Default Setting is set to ONLY include 50 Recipients at a time.  If you are emailing a Large Group of Users, please be Patient after Submitting and DO NOT STOP the Page halfway through.  It is Normal for Mass emailing to take a Long Time, you will be Notified when the Script has Completed.',

    'MASS_MAIL'              => 'Mass Email System',
    'MASS_PM_SYS'            => 'Mass Private Message System',

    'MASS_PM_SYS_EXP'        => 'Here you can Send Mass Private Messages to either ALL of your Users or ALL Users of a Specific Group.<br /><br />',

    'EM_MANGER'              => 'Email Manager',
    'AC_TEST_EM'             => 'Test Email Only?',
    'AC_TEST_EM_EXP'         => 'Will NOT Send any email out',
    'ICON'                   => 'Icon',
    'NO_PM_ICON'             => 'No PM Icon',
    'MESS_SENT'              => 'Message Sent Successfully',

    'MESS_NOT_SENT'          => 'An Error has Occurred and the Message was NOT Sent to one or more Recipients.<br />Please use the Back Button and Try Again!',

    'BODY_EXP'               => 'Please Note that you may enter ONLY Plain Text.  ALL Markup will be Removed before Sending.',
    'LEVEL_ADMIN'            => 'Administrator',
    'LEVEL_MODER'            => 'Moderator',
    'LEVEL_PREM'             => 'Premium',
    'LEVEL_USER'             => 'User',
    'MAIL_BYPAS'             => 'Bypass Mass email Block',

    'MAIL_BYPAS_EXP'         => 'By Selecting Yes you will be able to bypass the User\'s who have chosen Not to Receive Mass email\'s from this Site.  This should ONLY be done in Urgent Situations!',

    'MESSAGE_BODY_EXPLAIN'   => 'Enter your Message here, it may contain NO more than <strong>%d</strong> Characters.',
    'PREVIEW'                => 'Preview',
    'MORE_LEVEL'             => 'Additional Group\'s <br />These are Default Level\'s to use',
    'ERR_NO_RECIP'           => 'You have to Specify a Recipient',
    'ERR_NO_SUB'             => 'You have to Specify a Subject',
    'ERR_NO_BODY'            => 'Empty Message Body',
));

?>