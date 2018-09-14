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
** File acp_email/english.php 2018-09-14 10:27:00 Thor
**
** CHANGES
**
** 2018-02-21 - Added New Masthead
** 2018-02-21 - Added New !defined('IN_PMBT')
** 2018-02-21 - Fixed Spelling
** 2018-03-24 - Amended !defined('IN_PMBT')
** 2018-03-24 - Additions to Language
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
    'ACP_EMAIL_SETTINGS_EXPLAIN' => 'This Information is used when your Site Sends emails to your Users.  Please ensure the email Address you Specify is Valid.  If your Host DOES NOT provide a native (PHP based) email Service you can instead Send Messages Directly using SMTP.  This Requires the Address of an Appropriate Server (ask your Provider if necessary). If the Server Requires Authentication (and ONLY if it Does) Enter the Required Username, Password and Authentication Method.<br /><br />',

    'ADMIN_EMAIL'                 => 'Return email Address',

    'ADMIN_EMAIL_EXPLAIN'         => 'This will be used as the Return Address on ALL emails.  It will always be used as the <em>Return Path</em> and <em>Sender Address</em> in emails.',

    'BOARD_EMAIL_FORM'            => 'Users Send email via Site',
    'BOARD_EMAIL_FORM_EXPLAIN'    => 'Instead of Showing the Users email Address, Users are able to Send emails via the Site.',
    'BOARD_HIDE_EMAILS'           => 'Hide email Address',
    'BOARD_HIDE_EMAILS_EXPLAIN'   => 'This Function Keeps email Addresses Completely Private.',
    'CONTACT_EMAIL'               => 'Contact email Address',

    'CONTACT_EMAIL_EXPLAIN'       => 'This Address will be used whenever a Specific Contact Point is needed, e.g. Spam, Error Output, etc.  It will always be used as the <em>From</em> and <em>Reply to</em> Address in emails.',

    'EMAIL_FUNCTION_NAME'         => 'email Function Name',
    'EMAIL_FUNCTION_NAME_EXPLAIN' => 'The email Function used to Send Mail through PHP.',
    'EMAIL_PACKAGE_SIZE'          => 'email Package Size',

    'EMAIL_PACKAGE_SIZE_EXPLAIN'  => 'This is the Number of Maximum emails Sent out in one Package.  This Setting is applied to the Internal Message Queue.  Set this Value to 0 if you have problems with Non-Delivered Notification emails.',

    'ALLOW_TOPIC_NOTIFY'          => 'Allow Subscribing to Topics',

    'EMAIL_SIG'                   => 'email Signature',
    'EMAIL_SIG_EXPLAIN'           => 'This Text will be Attached to ALL emails the Site Sends.',
    'ENABLE_EMAIL'                => 'Enable Site Wide emails',

    'ENABLE_EMAIL_EXPLAIN'        => 'If this is Set to Disabled then emails will NOT be sent by the Site. <em>Note the User and Administrator Account Activation Settings Require this Setting to be Enabled.  If your currently using User or Administrator Activation in the Activation Settings, then Disabling this Setting will Require NO Activation of New Accounts.</em>',

    'SMTP_AUTH_METHOD'            => 'Authentication Method for SMTP',

    'SMTP_AUTH_METHOD_EXPLAIN'    => 'Only used if a Username/Password is Set.  (Ask your Provider if you are unsure which method to use)',

    'SMTP_CRAM_MD5'               => 'CRAM-MD5',
    'SMTP_NTLM'                   => 'NTLM',
    'SMTP_LOGIN'                  => 'LOGIN',
    'SMTP_PASSWORD'               => 'SMTP Password',

    'SMTP_PASSWORD_EXPLAIN'       => 'Only Enter a Password if your SMTP Server Requires it.<br /><em><strong>Warning: </strong>This Password will be stored as Plain Text in the Database, Visible to everybody who can Access your Database or who can View this Configuration Page.</em>',

    'SMTP_PLAIN'                  => 'PLAIN',
    'SMTP_POP_BEFORE_SMTP'        => 'POP-BEFORE-SMTP',
    'SMTP_PORT'                   => 'SMTP Server Port',
    'SMTP_PORT_EXPLAIN'           => 'Only Change this if you know your SMTP Server is on a Different Port.',
    'SMTP_SERVER'                 => 'SMTP Server Address',
    'SMTP_SERVER_EXPLAIN'         => 'Enter your SMTP Server Address.  (Ask your Provider if you are unsure).',
    'SMTP_SETTINGS'               => 'SMTP Settings',
    'SMTP_USERNAME'               => 'SMTP Username',
    'SMTP_USERNAME_EXPLAIN'       => 'Only Enter a Username if your SMTP Server Requires it.',
    'USE_SMTP'                    => 'Use SMTP Server for email',

    'USE_SMTP_EXPLAIN'            => 'Select Yes if you want or have to Send email via a Named Server instead of the Local Mail Function.',

    'USE_SMTP_SSL'                => 'SMTP Connection Type',
    'USE_SMTP_SSL_EXPLAIN'        => 'Set Connection Prefix.',
    'USE_AUTHEN'                  => 'SMTP Authorisation',
    'USE_AUTHEN_EXPLAIN'          => 'Set SMTP Authentication.',
    'USE_DEBUGING'                => 'SMTP Debugging',
    'USE_DEBUGING_EXPLAIN'        => 'Use SMTP Debugging.',
    'DISABLED'                    => 'Disabled',
    'ENABLED'                     => 'Enabled',
    'SMTP_SSL_NONE'               => 'None',
    'SMTP_SSL_SSL'                => 'SSL',
    'SMTP_SSL_TLS'                => 'TLS',
    'SMTP_SSL_AUTO'               => 'Auto',
));

?>