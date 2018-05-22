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

#MISC
define("_admsavebtn","Save");
define("_admresetbtn","Reset");
define("_admsaved","Settings Saved!");

#MENU
define("_admtrackers","Tracker Control");
define("_adm_tables_user","Edit Users");
define("_adm_tables_torrents","Edit Torrents");
define("_adm_tables_site","Edit Site");
define("_admmenu","Administrative Menu");
define("_admsettings","Settings");
define("_admbans","Bans");
define("_admfilter","Keyword Filter");
define("_admcategories","Categories");
define("_admoptimizedb","Optimize Database");
define("_admirc","IRC Chat");
define("_admwebupdate","Updates");
define("_admuser","User Manager");
define("_admmassupload","Massive Upload");

#PRUNE
define("_userprune",'User Prune Settings');
define("_admpautodel_users","Turn on User Prune System ");
define("_admpautodel_usersexplain","Enable or Disable User Prune System");
define("_admpinactwarning_time","Time before Email Warning In days");
define("_admpinactwarning_timeexplain","How long to allow a User to be Inactive for before a notice is sent to them and their account is set to Inactive");
define("_admpautodel_users_time","Time before Delete in days");
define("_admpautodel_users_timeexplain","How long after their account is set as Inactive before it gets Pruned (Deleted)<br> This does NOT include Banned Accounts");

#OVERVIEW
define("_admoverview","Overview");
define("_admtotalusers","Total Registered Users:");
define("_admtotaltorrents","Total Torrents:");
define("_admtotalshare","Total Shared Data:");
define("_admtotalpeers","Total Peers:");
define("_admtotalspeed","Total Transfer Speed:");
define("_admtotalseeders","Total Seeders:");
define("_admtotalleechers","Total Leechers:");
define("_admmostusedclient","Most Used Client:");

#KEYWORD FILTER
define("_admnofilterkey","No Filter Keywords");
define("_admaddkeyword","Add/Edit Keyword");
define("_admkeyword","Keyword");
define("_admkeywordreason","Reason");
define("_admmissingkeyword","Missing Keyword");
define("_admmissingreason","Missing Reason");
define("_admkeywordillegalformat","Keyword must be between 5 and 50 Alphanumeric Characters");
define("_admreasonillegalformat","Reason must be no longer than 255 Characters Long");
define("_admfilterintro","With the Keyword Filter, you can STOP Users from Uploading Torrents that may violate the Rules or Law Enforcement.<br />
This checks the names of the files within a torrent. Be careful to NOT insert any common words.");

#TORRENT CLINIC
define("_admclinicintro","Torrent Clinic allows you to check .torrent File Properties.<br />
If you are having trouble with a Torrent you can verify it has been generated correctly, or you can simply look inside it.<br />
When Uploading a Torrent from your HDD you will be able to verify ALL information it contains and even check it against sources!");
define("_admclinicshowxml","Show Advanced XML Structures (useful for debugging)");
define("_admclinicforcescrape","Force Scrape on External Torrents");
define("_admclinicdiag","Diagnostics");
define("_admclinicdecoding","Reading Torrent...");
define("_admclinicdecodeerror","Decoding Error. File is probably NOT a valid torrent file.");
define("_admclinicxmlstruct","XML Structure");
define("_admclinickchkannounce","Checking against Default Tracker...");
define("_admclinicchkannounceerror","Default Tracker is NOT set. Invalid Torrent file.");
define("_admclinicinvalidannounce","Invalid");
define("_admclinickchkinfo","Checking against Info Dictionary...");
define("_admclinicchkinfoerror","Info Dictionary is NOT present. Invalid Torrent file.");
define("_admclinicchkinfook","Found");
define("_admclinicchkmulti","Checking against File Number...");
define("_admclinicchkmultis","Torrent contains a single file");
define("_admclinicchkmultim","Torrent contains multiple files");
define("_admclinicchkmultif","Torrent is NOT consistent!!");
define("_admclinicchkfile","File:");
define("_admchkinvalidfsize","Invalid File Size. Must be Numeric");
define("_admchkinvalidfilepath","Invalid File Path.");
define("_admclinickchktotsize","Total Size:");
define("_admclinicchkplen","Checking against Piece Length...");
define("_admclinicchkplenmissing","Piece Length missing. Invalid Torrent!");
define("_admclinicchkpieces","Checking against Pieces...");
define("_admclinicchkpiecesok","Data is Valid!");
define("_admclinicchkpiecesfail","Data is Invalid!");
define("_admclinicchkpiecesmissing","Data is Missing!");
define("_admclinicchkbasic","This Torrent is valid and has passed the Basic Tests.");
define("_admclinicchkadvanced","Going through Advanced Tests...");
define("_admclinicdht","Checking against DHT Support in Azureus...");
define("_admclinicannouncelist","Checking against Multiple Trackers...");
define("_admclinicsupported","Supported");
define("_admclinicnotsupported","Not Supported");
define("_admclinicscraping","Querying Tracker...");
define("_admclinicscrapefail","It looks like this torrent is not registered with the External Tracker");

#IRC
define("_admircintro","Configure BTManager's built-in IRC Chat.
You may Configure every aspect of the PJIRC Client: Please read PJIRC's documentation before editing advanced parameters.<br />
<b>NOTICE</b>: file <i>include/irc.ini</i> MUST be Writeable");
define("_admircserver","Server");
define("_admircchannel","Channel");
define("_admircadvsettings","Here you can Configure PJIRC's Advanced Settings. According to PJIRC documentation, insert the parameters with the following syntax:<br />
<i>name</i> = </i>value</i>");
define("_admircedit","Apply Settings");
define("_VALUE","VALUE");
define("_admircenable","Enable IRC");
define("_admircdisable","Disable IRC");
define("_admirccantdelete","Cannot delete <i>include/irc.ini</i> because it's Write-Protected. Please Delete the file manually. IRC Chat is still enabled!");
define("_admircinvalidhost","Invalid Host Name or IP address");
define("_admircinvalidchannel","Invalid Channel Name");
define("_admircinvalidadvanced","Invalid Syntax for Advanced Parameters");
define("_admirccantsave","Cannot Save <i>include/irc.ini</i> because it's Write-Protected. Please Save the file manually with the following content:");

#UPDATE
define("_admupdintro","BTManager is now trying to check for a Newer Version. The Server must be capable of opening HTTP Connections.");
define("_admupderror","Error: Unable to Connect.");
define("_admupdcurver","Current BTManager Version is");
define("_admupdlastver","Last BTManager Version is");
define("_admupdupdate","Please consider Updating to the latest version.");
define("_admupdnoupdate","BTManager is up-to-date");

#USER MANAGER
define("_admuserintro","Manage Registered Users by Editing their Profile, Setting their User Class or Banning them.");
define("_admusersearchbtn","Search User");
define("_admuserlastlogin","Last Seen");
define("_admuserlastip","Last IP");
define("_admuserviewprofile","View Profile");
define("_admusereditprofile","Edit Profile");
define("_admuserdelete","Delete User");
define("_admuserban","Ban user");
define("_admuserunban","Unban User");
define("_admusermailsearchbtn","Search e-Mail");
define("_admuserusername","User");
define("_admuseremail","e-Mail");
define("_admuserregistered","Registered");
define("_admuseripsearchbtn","Search IP");
define("_admuserhostsearchbtn","Search Host");

#DONATIONS
define("_admpdonations","Donations");
define("_admppaypal_email","PayPal e-Mail");
define("_admppaypal_emailexplain","Your Paypal e-Mail account. Donations to this account will update the progress bar in the Donations Block on the front page. Log in to your PayPal account, go to My Account>Profile>Instant Payment Notification Preferences, and set the URL to $siteurl/paypal.php");

define("_admpsitecost","Donations Goal");
define("_admpsitecostexplain","Enter a Goal for your Donations Drive.");

define("_admpreseaved_donations","Donations Collected");
define("_admpreseaved_donationsexplain","Current Donation Amount. Any Donations reported by PayPal will be added to this, if you fill in the data above.");

define("_admpdonatepage","Donations Page");
define("_admpdonatepageexplain","Edit your Donations Page (i.e., the page that is linked from the Donations Block on the front page). When pasting the code for the Donate Button from PayPal, remember to click on 'Source' in the editor first.");

define("_admpdonation_block","Donation Block");
define("_admpdonation_blockexplain","Select if you want the Donations Block to be shown on the main page.");

define("_admpclock","Clock Block");
define("_admpclockexplain","Select If You want the Clock Block to be shown");

define("_admpradio","Radio Block");
define("_admpradioexplain","Select If You want the Radio Block to be shown");

define("_admpnodonate","Indicator for Zero Donations");
define("_admpnodonateexplain","<ul><li><b>EU</b> Displays a EURO symbol when NO Donations have been made yet.<li><b>UK</b> Displays a British Pound symbol when NO Donations have been made yet.<li><b>US</b> Displays a Dollar symbol when NO Donations have been made yet.</ul>This setting does NOT affect the Donation Currency in any way, it's purely for visual display.");
define("_admpnodonateopt1","EURO");
define("_admpnodonateopt2","BPD");
define("_admpnodonateopt3","USD");

#MASS MESSAGES
define("_admmassmail","Mass Mail");
define("_admmassmailall","All");
define("_admmassmessage","Mass Messages");
define("_admmassmailerror","Try Again");
define("_admmasspm","Mass PM");
define("_admmasspmlong","Mass PM to Selected User Levels");
define("_admmmsendto","Mass Mail to Selected User Levels");

#LOGS
define("_admlogs","Log's");
define("_admlogmall","Mark All");
define("_admlogumall","Unmark All");
define("_admlles0","All Entries");
define("_admlles1","1 Day");
define("_admlles2","7 Days");
define("_admlles3","2 Weeks");
define("_admlles4","1 Month");
define("_admlles5","3 Months");
define("_admlles6","6 Months");
define("_admlles7","1 Year");
define("_admdisxpl","<b>Display entries from:</b> ");
define("_admdodleal","Are you sure you want to Delete ALL Log's ?");
define("_admdellogsse","Delete Selected");
define("_admdodlese","Are you sure you want to Delete Selected Log's ?");
define("_admselcclear","Selected Log's have been Cleared");
define("_admallclear","Log's have been Cleared");

#STYLE EDITOR
define("_admedt","Template");
define("_admedtp","Edit Template");
define("_admedtpexp","Here you can Edit your Template directly. Please remember that these edits are permanent and cannot be undone once submitted. If PHP can write to the Template Files in your Styles Directory any changes here will be written directly to those files. If PHP cannot write to those files they will be copied into the Database and all changes will only be reflected there. Please take care when editing your template set, remember to close all replacement Variable Terms {XXXX} and Conditional Statements.");
define("_admtmpslct","Selected Template: ");
define("_admtmpslctf","Select Template Folder");
define("SELECTED_TEMPLATE_FILE","Selected Template File");
define("SELECT_TEMPLATE","Select Template File");
define("SELECT_FOLDER","Theme Folder");
define("TEMPLATE_EDITOR_HEIGHT","Template Editor Height");
define("TEMPLATE_EDITOR","Raw HTML Template Editor");
define("ACP_TEMPLATES_EXPLAIN","A Template Set comprises all the markup used to generate the layout of your board. Here you can Edit Existing Template Sets and Preview Sets.");
define("_admteditor","Theme Editor");

#TORRENT CLIENT BAN
define("_admnoclient","Client Not Set");
define("_admnobannedclient","No Banned Clients at this time");
define("_admclientban","Client Ban");
define("_adminclient","Client");
define("_adminclientre","Reason");
define("_admbanclientexp","This is where you can Ban Torrent Clients!<br />You can Ban either the Hole Client or one version of the Client <br />To Add a Client you will need the pier_id info from the Client.<br />Example: &micro;Torrent 1.8.1 You would Add UT1810.<br />The reason for the Ban will be shown in the Client So you will want to keep this short.");

#BONUS SYSTEM
define("_admbonsetting","Bounce Settings");
define("_admbonalo","Allow Bonus");
define("_admbononof","Bonus On/Off");
define("_admbononofexp","This will Turn On or Off the Bonus System.");
define("_admbonup","Upload");
define("_admbonupex","This is the amount a User will get<br />for Uploading a Torrent.");
define("_admbonupext","Upload Bonus");
define("_admbonco","Comments");
define("_admboncoex","This is the amount a User will get<br />for making a Torrent Comment.");
define("_admboncoext","Comment Bonus");
define("_admbonoffer","Offers");
define("_admbonofferex","This is the amount a User will get<br />for making a Torrent Offer.");
define("_admbonofferext","Offer Bonus");
define("_admbonseed","Seeding");
define("_admbonseedex","This is the amount a User will get<br />for Seeding a Torrent.<br />This setting works with Auto Clean Timer in Settings");
define("_admbonseedext","Seeding Bonus");
define("_admbonseedtor","Give Bonus for each Torrent");
define("_admbonseedtorex","If Active, Users will get a Bonus for each Torrent that they are Seeding<br />If not they will only get a Single Bonus no matter how many torrents they seed");
define("_admbonseedtorext","Bonus For each/all Torrents");
define("_admbonreq","Filling a Request");
define("_admbonreqex","This is the amount a User will get<br />for Uploading a Torrent that was Requested. This is on top of the Uploading Bonus");
define("_admbonreqext","Filling Request Bonus");
define("_admbonbongo","Edit Bonus!");

#LEVEL SYSTEM
define("_adm_level_table","Administration Levels");
define("_adm_level_table_details","Viewing Level Details");

#FAQS
define("_adm_faq_sectile","Section/Item Title");
define("_adm_faq_hidden","Hidden");
define("_adm_faq_updated","Updated");
define("_adm_faq_new","New");
define("_adm_faq_norm","Normal");
define("_adm_faq_tile","Item Title");
define("_adm_faq_additem","Add New Item");
define("_adm_faq_addsection","Add New Section");
define("_adm_faq_orphen","Orphaned Items");
define("_adm_faq_order","Reorder");
define("_adm_faq_order_no_match","When the position numbers don't reflect the position in the table, it means the Order ID is larger than the total number of sections/items and you should check all the Order ID's in the table and click Reorder\n");
define("_TIME","Time");
define("_IP","User IP");

?>