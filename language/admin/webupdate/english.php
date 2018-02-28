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
** File webupdate/english.php 2018-02-28 22:21:00 Thor
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
	'CURRENT_VERSION'				=> 'Current Version',
	'LATEST_VERSION'				=> 'Latest Version',
	'VERSION_CHECK'					=> 'Version Check',
	'VERSION_CHECK_EXPLAIN'			=> 'Checks to see if your BTManager Installation is up-to-date.',
	'VERSION_NOT_UP_TO_DATE'		=> 'Your BTManager Installation is NOT up-to-date. Please Continue the Update Process.',
	'UPDATE_INSTRUCTIONS'			=> '
		<h1>Release Announcement</h1>

		<p>Please Read <a href="%1$s" title="%1$s"><strong>the Release Announcement for the Latest Version</strong></a> before you Continue your Update Process, it may contain useful Information. It also contains Full Download Links as well as the Change Log.</p>

		<br />

		<h1>How to Update your Installation with the Automatic Update Package</h1>

		<p>The Recommended way of Updating your Installation Listed here is Only Valid for the Automatic Update Package. You are also able to Update your Installation using the Methods Listed within the INSTALL.html Document. The Steps for Updating BTManager Automatically are:</p>

		<ul style="margin-left: 20px; font-size: 1.1em;">
			<li>Go to the <a href="https://github.com/blackheart1/BTManager" title="https://github.com/blackheart1/BTManager">BTManager Downloads Page</a> and Download the "Latest Version" Archive.<br /><br /></li>
			<li>Unpack the Archive.<br /><br /></li>
			<li>Upload the Complete Uncompressed Install Folder to your BTManager Root Directory (where your config.php file is).<br /><br /></li>
		</ul>

		<p>Once Uploaded, your Board will be Offline for Normal Users due to the Install Directory you Uploaded now being present.<br /><br />
		<strong><a href="%2$s" title="%2$s">Now Start the Update Process by Pointing your Browser to the Install Folder</a>.</strong><br />
		<br />
		You will then be Guided through the Update Process. You will be Notified once the Update is Complete.
		</p>
	',
	'UPGRADE_INSTRUCTIONS'			=> 'A New Feature Release <strong>%1$s</strong> is Available. Please Read <a href="%2$s" title="%2$s"><strong>the Release Announcement</strong></a> to Learn about what it has to Offer, and How to Upgrade.',

	'VERSION_UP_TO_DATE_ACP'		=> 'Your BTManager Installation is up-to-date. Their are NO Updates Available at this time.',
	'VERSIONCHECK_FORCE_UPDATE'		=> 'Re-Check Version',
	'VERSION_NOT_UP_TO_DATE_ACP'	=> 'Your BTManager Installation is NOT up-to-date.<br />Below is a Link to the Release Announcement, which Contains more Information as well as Instructions on Updating.',
));

?>