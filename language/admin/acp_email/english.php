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
** File acp_email/english.php 2018-02-27 12:08:00 Thor
**
** CHANGES
**
** 2018-02-21 - Added New Masthead
** 2018-02-21 - Added New !defined('IN_PMBT')
** 2018-02-21 - Fixed Spelling
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
                <p>If you arrived at this page after you used an old Boomark or Favorite, the page in question has probably been moved. Try locating the page via the navigation menu and then update your bookmarks.</p>
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
    'ACP_EMAIL_SETTINGS_EXPLAIN'  => 'This Information is used when your Site Sends e-mails to your Users. Please ensure the e-mail Address you Specify is Valid.  If your Host DOES NOT provide a native (PHP based) e-mail Service you can instead Send Messages Directly using SMTP. This Requires the Address of an appropriate server (ask your Provider if necessary). If the Server Requires Authentication (and ONLY if it does) Enter the necessary Username, Password and Authentication Method.',

    'ADMIN_EMAIL'                 => 'Return e-mail Address',
    'ADMIN_EMAIL_EXPLAIN'         => 'This will be used as the Return Address on ALL emails. It will always be used as the <samp>Return Path</samp> and <samp>Sender</samp> Address in emails.',

    'SITE_EMAIL_FORM'             => 'Users Send email via Site',
    'SITE_EMAIL_FORM_EXPLAIN'     => 'Instead of showing the Users email Address Users are able to Send e-mails via the Site.',
    'SITE_HIDE_EMAILS'            => 'Hide email Addresses',
    'SITE_HIDE_EMAILS_EXPLAIN'    => 'This Function keeps email Addresses Completely Private.',
    'CONTACT_EMAIL'               => 'Contact email Address',
    'CONTACT_EMAIL_EXPLAIN'       => 'This Address will be used whenever a specific contact point is needed, e.g. Spam, Error Output, etc. It will always be used as the <samp>From</samp> and <samp>Reply To</samp> Address in emails.',

    'EMAIL_FUNCTION_NAME'         => 'email Function Name',
    'EMAIL_FUNCTION_NAME_EXPLAIN' => 'The email Function used to Send Mail through PHP.',
    'EMAIL_PACKAGE_SIZE'          => 'email Package Size',
    'EMAIL_PACKAGE_SIZE_EXPLAIN'  => 'This is the Number of Maximum emails sent out in one package. This Setting is applied to the Internal Message Queue.  Set this Value to 0 if you have problems with non-delivered Notification emails.',

    'EMAIL_SIG'                   => 'e-mail Signature',
    'EMAIL_SIG_EXPLAIN'           => 'This text will be Attached to ALL emails the Site Sends.',

    'ENABLE_EMAIL'                => 'Enable Site Wide emails',
    'ENABLE_EMAIL_EXPLAIN'        => 'If this is Set to Disabled NO emails will be sent by the Site at all. <em>Note the User and Admin Account Activation Settings require this Setting to be Enabled. If currently using User or Admin Activation in the Activation Settings, Disabling this setting will require NO Activation of New Accounts.</em>',

    'SMTP_AUTH_METHOD'            => 'Authentication Method for SMTP',
    'SMTP_AUTH_METHOD_EXPLAIN'    => 'Only used if a Username/Password is Set.  Ask your Provider if you are unsure which method to use.',

    'SMTP_CRAM_MD5'               => 'CRAM-MD5',
    'SMTP_NTLM'                   => 'NTLM',
    'SMTP_LOGIN'                  => 'LOGIN',
    'SMTP_PASSWORD'               => 'SMTP Password',
    'SMTP_PASSWORD_EXPLAIN'       => 'Only enter a Password if your SMTP Server requires it.<br /><em><strong>Warning:</strong> This Password will be stored as Plain Text in the Database, Visible to everybody who can Access your Database or who can View this Configuration Page.</em>',

    'SMTP_PLAIN'                  => 'PLAIN',
    'SMTP_POP_BEFORE_SMTP'        => 'POP-BEFORE-SMTP',
    'SMTP_PORT'                   => 'SMTP Server Port',
    'SMTP_PORT_EXPLAIN'           => 'Only change this if you know your SMTP Server is on a different Port.',
    'SMTP_SERVER'                 => 'SMTP Server Address',
    'SMTP_SETTINGS'               => 'SMTP Settings',
    'SMTP_USERNAME'               => 'SMTP Username',
    'SMTP_USERNAME_EXPLAIN'       => 'Only enter a Username if your SMTP Server requires it.',
    'USE_SMTP'                    => 'Use SMTP Server for email',
    'USE_SMTP_EXPLAIN'            => 'Select Yes if you want or have to Send email via a Named Server instead of the Local Mail Function.',

    'USE_SMTP_SSL'                => 'SMTP Connection Type',
    'USE_SMTP_SSL_EXPLAIN'        => 'Set Connection Prefix.',
    'USE_AUTHEN'                  => 'SMTP Authorisation',
    'USE_AUTHEN_EXPLAIN'          => 'Set SMTP Authentication.',
    'USE_DEBUGING'                => 'SMPT Debugging',
    'USE_DEBUGING_EXPLAIN'        => 'Use SMPT Debugging.',
    'DISABLED'                    => 'Disabled',
    'ENABLED'                     => 'Enabled',
    'SMTP_SSL_NONE'               => 'None',
    'SMTP_SSL_SSL'                => 'SSL',
    'SMTP_SSL_TLS'                => 'TLS',
    'SMTP_SSL_AUTO'               => 'Auto',
));

?>