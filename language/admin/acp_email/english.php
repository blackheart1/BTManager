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
** File acp_email.php 2018-02-21 08:41:00 Thor
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
	'ACP_EMAIL_SETTINGS_EXPLAIN'	=> 'This information is used when your site sends e-mails to your Users. Please ensure the e-mail address you specify is valid.  If your host does NOT provide a native (PHP based) e-mail service you can instead send messages directly using SMTP. This requires the address of an appropriate server (ask your provider if necessary). If the server requires authentication (and ONLY if it does) enter the necessary Username, Password and Authentication Method.',

	'ADMIN_EMAIL'					=> 'Return e-mail Address',
	'ADMIN_EMAIL_EXPLAIN'			=> 'This will be used as the Return Address on all e-mails. It will always be used as the <samp>Return Path</samp> and <samp>Sender</samp> Address in e-mails.',

	'Site_EMAIL_FORM'				=> 'Users send e-mail via Site',
	'Site_EMAIL_FORM_EXPLAIN'		=> 'Instead of showing the Users e-mail Address Users are able to send e-mails via the Site.',
	'Site_HIDE_EMAILS'				=> 'Hide e-mail Addresses',
	'Site_HIDE_EMAILS_EXPLAIN'		=> 'This function keeps e-mail Addresses completely Private.',
	'CONTACT_EMAIL'					=> 'Contact e-mail Address',
	'CONTACT_EMAIL_EXPLAIN'			=> 'This address will be used whenever a specific contact point is needed, e.g. Spam, Error Output, etc. It will always be used as the <samp>From</samp> and <samp>Reply To</samp> address in e-mails.',

	'EMAIL_FUNCTION_NAME'			=> 'e-mail Function Name',
	'EMAIL_FUNCTION_NAME_EXPLAIN'	=> 'The e-mail function used to send mail through PHP.',
	'EMAIL_PACKAGE_SIZE'			=> 'e-mail Package Size',
	'EMAIL_PACKAGE_SIZE_EXPLAIN'	=> 'This is the number of Maximum e-mails sent out in one package. This setting is applied to the Internal Message Queue.  Set this value to 0 if you have problems with non-delivered notification e-mails.',

	'EMAIL_SIG'						=> 'e-mail Signature',
	'EMAIL_SIG_EXPLAIN'				=> 'This text will be attached to ALL e-mails the Site sends.',
	'ENABLE_EMAIL'					=> 'Enable Site Wide e-mails',
	'ENABLE_EMAIL_EXPLAIN'			=> 'If this is set to Disabled NO e-mails will be sent by the Site at all. <em>Note the User and Admin Account Activation Settings require this setting to be Enabled. If currently using User or Admin Activation in the Activation Settings, Disabling this setting will require NO Activation of New Accounts.</em>',
	'SMTP_AUTH_METHOD'				=> 'Authentication Method for SMTP',

	'SMTP_AUTH_METHOD_EXPLAIN'		=> 'Only used if a Esername/Password is set.  Ask your provider if you are unsure which method to use.',
	'SMTP_CRAM_MD5'					=> 'CRAM-MD5',
	'SMTP_NTLM'						=> 'NTLM',
	'SMTP_LOGIN'					=> 'LOGIN',
	'SMTP_PASSWORD'					=> 'SMTP Password',
	'SMTP_PASSWORD_EXPLAIN'			=> 'Only enter a Password if your SMTP server requires it.<br /><em><strong>Warning:</strong> This password will be stored as Plain Text in the database, visible to everybody who can access your database or who can view this Configuration Page.</em>',

	'SMTP_PLAIN'					=> 'PLAIN',
	'SMTP_POP_BEFORE_SMTP'			=> 'POP-BEFORE-SMTP',
	'SMTP_PORT'						=> 'SMTP Server Port',
	'SMTP_PORT_EXPLAIN'				=> 'Only change this if you know your SMTP Server is on a different Port.',
	'SMTP_SERVER'					=> 'SMTP Server Address',
	'SMTP_SETTINGS'					=> 'SMTP Settings',
	'SMTP_USERNAME'					=> 'SMTP Username',
	'SMTP_USERNAME_EXPLAIN'			=> 'Only enter a Username if your SMTP Server requires it.',
	'USE_SMTP'						=> 'Use SMTP Server for e-mail',
	'USE_SMTP_EXPLAIN'				=> 'Select Yes if you want or have to send e-mail via a Named Server instead of the Local Mail Function.',

	'DISABLED'						=> 'Disabled',
	'ENABLED'						=> 'Enabled',
	'SMTP_SSL_NONE'					=>	'None',
	'SMTP_SSL_SSL'					=>	'SSL',
	'SMTP_SSL_TLS'					=>	'TLS',
	'SMTP_SSL_AUTO'					=>	'Auto',
));

?>