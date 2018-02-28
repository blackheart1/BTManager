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
** File staffmess/english.php 2018-02-28 21:31:00 Thor
**
** CHANGES
**
** 2018-02-25 - Added New Masthead
** 2018-02-25 - Added New !defined('IN_PMBT')
** 2018-02-25 - Fixed Spelling
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
    'MAIN_TEXT'              => 'Mass Messages',
    'MAIN_INTRO_EXP'         => 'With this Tool you will be able to Send Multiple Messages out at the same time by either Mass PM or Mass email.',

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

    'MASS_MAIL_EXP'          => 'Here you can email a Message to either ALL of your Users or ALL Users of a Specific Group if they have the Option to Receive Mass emails Enabled. To achieve this an email will be Sent Out to the Administrators email Address supplied, with a Blind Carbon Copy Sent to ALL Recipients. The Default Setting is to ONLY include 50 Recipients at a time. If you are emailing a Large Group of Users, please be Patient after Submitting and DO NOT STOP the Page halfway through. It is Normal for Mass emailing to take a Long Time, you will be Notified when the Script has Completed.',

    'MASS_MAIL'              => 'Mass Email System',
    'MASS_PM_SYS'            => 'Mass Private Message System',
    'MASS_PM_SYS_EXP'        => 'Here you can Send Mass Private Messages to either ALL of your Users or ALL Users of a Specific Group',

    'EM_MANGER'              => 'Email Manager',
    'AC_TEST_EM'             => 'Test Email Only?',
    'AC_TEST_EM_EXP'         => 'Will NOT Send any email out',
    'ICON'                   => 'Icon',
    'NO_PM_ICON'             => 'No PM Icon',
    'MESS_SENT'              => 'Message Sent Successfully',
    'MESS_NOT_SENT'          => 'An Error has Occurred and the Message was NOT Sent to one or more Recipients.<br />Please use the Back Button and Try Again!',

    'BODY_EXP'               => 'Please Note that you may enter ONLY Plain Text. ALL Markup will be Removed before Sending.',
    'LEVEL_ADMIN'            => 'Administrator',
    'LEVEL_MODER'            => 'Moderator',
    'LEVEL_PREM'             => 'Premium',
    'LEVEL_USER'             => 'User',
    'MAIL_BYPAS'             => 'Bypass Mass Email Block',
    'MAIL_BYPAS_EXP'         => 'By Selecting Yes you will be able to bypass the User\'s who wish NOT to Receive Mass email from this Site.<br />This should ONLY be done in Urgent Situations!',

    'MESSAGE_BODY_EXPLAIN'   => 'Enter your Message here, it may contain NO more than <strong>%d</strong> Characters.',
    'PREVIEW'                => 'Preview',
    'MORE_LEVEL'             => 'Additional Group\'s <br /> These are Default Level\'s to use',
    'ERR_NO_RECIP'           => 'You have to Specify a Recipient',
    'ERR_NO_SUB'             => 'You have to Specify a Subject',
    'ERR_NO_BODY'            => 'Empty Message Body',
));

?>