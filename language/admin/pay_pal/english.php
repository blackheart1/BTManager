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
** File paypal/english.php 2018-02-28 11:36:00 Thor
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
    '_admpnodonateopt'               => array("EU"=>"EURO", "UK"=>"BPD", "US" => "USD"),
    '_admsaved'                      => 'Settings Saved!',
    '_admpdonations'                 => 'Donations',
    '_admpdonationsexplain'          => 'Donations',
    '_admppaypal_email'              => 'PayPal email',
    '_admppaypal_emailexplain'       => 'The email Address used with your Paypal Account. Donations to this Account will Update the Progress Bar in the Donations Block on the Front Page. Log on to your PayPal Account, go to My Account > Profile > Instant Payment Notification Preferences, and Set the URL to http://YOUR_SITE_URL/paypal.php',

    '_admpsitecost'                  => 'Donations Goal',
    '_admpsitecostexplain'           => 'Enter a Goal for your Donation Drive in Dollars',
    '_admpreseaved_donations'        => 'Donations Collected',
    '_admpreseaved_donationsexplain' => 'Amount of Money you\'ve already received. Any Donations Reported by PayPal will be added to this, if you Fill in your Data above.',

    '_admpdonatepage'                => 'Donations Page',
    '_admpdonatepageexplain'         => 'Enter your Donations Page Information (i.e., the Page that is Linked from the Donations Block on the Front Page). When Pasting the Code for the Donate Button from PayPal, remember to Click on Source in the Editor First.',

    '_admpdonation_block'            => 'Donation Block',
    '_admpdonation_blockexplain'     => 'Check if you want a Donations Block to be shown on the Main Page.',
    '_admpnodonate'                  => 'Indicator for Zero Donations',
    '_admpnodonateexplain'           => '<ul><li><b>EU</b> Displays a EURO Symbol when NO Donations have been made yet!<li><b>UK</b> Displays a British Pound Symbol when NO Donations have been made yet!<li><b>US</b> Displays a Dollar Symbol when NO Donations have been made yet!</ul>This Setting DOES NOT affect the Donation Currency in any way, it\'s purely optical.',
));

?>