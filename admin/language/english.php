<?php
/*
*----------------------------phpMyBitTorrent V 2.0-----------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
*-------------               http://www.p2pmania.it               -------------*
*------------ Based on the Bit Torrent Protocol made by Bram Cohen ------------*
*-------------              http://www.bittorrent.com             -------------*
*------------------------------------------------------------------------------*
*------------------------------------------------------------------------------*
*--   This program is free software; you can redistribute it and/or modify   --*
*--   it under the terms of the GNU General Public License as published by   --*
*--   the Free Software Foundation; either version 2 of the License, or      --*
*--   (at your option) any later version.                                    --*
*--                                                                          --*
*--   This program is distributed in the hope that it will be useful,        --*
*--   but WITHOUT ANY WARRANTY; without even the implied warranty of         --*
*--   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the          --*
*--   GNU General Public License for more details.                           --*
*--                                                                          --*
*--   You should have received a copy of the GNU General Public License      --*
*--   along with this program; if not, write to the Free Software            --*
*-- Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA --*
*--                                                                          --*
*------------------------------------------------------------------------------*
*------              ©2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-----------------   Sunday, September 14, 2008 9:05 PM   ---------------------*
*/

if (!defined('IN_PMBT')) die ("You can't access this file directly");

define("_admsavebtn","Save");
define("_admresetbtn","Reset");
define("_admsaved","Settings saved!");

#MENU
define("_admtrackers","Tracker Controle");
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
#prune
define("_userprune",'User Prune Settings');
define("_admpautodel_users","Turn on User Prune System ");
define("_admpautodel_usersexplain","Inable or Disable User Prune System");
define("_admpinactwarning_time","Time before Email Warning In days");
define("_admpinactwarning_timeexplain","How Long To allow a user to be inactive Before a notice is sent to them and account set inactive");
define("_admpautodel_users_time","Time before delete In days");
define("_admpautodel_users_timeexplain","How long after account is set Inactive To Prune it(Delete it)<br> This dose not include Banned accounts");
#OVERVIEW
define("_admoverview","Overview");
define("_admtotalusers","Total Registered Users:");
define("_admtotaltorrents","Total Torrents:");
define("_admtotalshare","Total shared data:");
define("_admtotalpeers","Total Peers:");
define("_admtotalspeed","Total transfer speed:");
define("_admtotalseeders","Total seeders:");
define("_admtotalleechers","Total leechers:");
define("_admmostusedclient","Most used client:");
#KEYWORD FILTER
define("_admnofilterkey","No filter keywords");
define("_admaddkeyword","Add/Edit keyword");
define("_admkeyword","Keyword");
define("_admkeywordreason","Reason");
define("_admmissingkeyword","Missing keyword");
define("_admmissingreason","Missing reason");
define("_admkeywordillegalformat","Keyword must be 5 to 50 alphanumeric chars");
define("_admreasonillegalformat","Reason must be maximum 255 chars long");
define("_admfilterintro","With the Keyword Filter, you can stop users from uploading Torrents that may violate tracker rules or the law.<br />
This checks the names of the files within a torrent. Be careful to not insert any common words.");

#TORRENTCLINIC
define("_admclinicintro","TorrentClinic&trade; allows you to check .torrent file properties.<br />
If you are having trouble with a Torrent you can verify it has been generated correctly, or you can simply look inside it.<br />
Uploading a Torrent from your hard drive you will be able to verify all information that it contains and even check against sources!");
define("_admclinicshowxml","Show Advanced XML Structures (useful for debugging)");
define("_admclinicforcescrape","Force scrape on External Torrents");
define("_admclinicdiag","Diagnostics");
define("_admclinicdecoding","Reading Torrent...");
define("_admclinicdecodeerror","Decoding Error. File is probabily not a valid torrent file.");
define("_admclinicxmlstruct","XML Structure");
define("_admclinickchkannounce","Checking against default tracker...");
define("_admclinicchkannounceerror","Default tracker is not set. Invalid Torrent file.");
define("_admclinicinvalidannounce","Invalid");
define("_admclinickchkinfo","Checking against Info dictionary...");
define("_admclinicchkinfoerror","Info dictionary is not present. Invalid Torrent file.");
define("_admclinicchkinfook","Found");
define("_admclinicchkmulti","Checking against file number...");
define("_admclinicchkmultis","Torrent contains a single file");
define("_admclinicchkmultim","Torrent contains more files");
define("_admclinicchkmultif","Torrent is not consistent!!");
define("_admclinicchkfile","File:");
define("_admchkinvalidfsize","Invalid file size. Must be numeric");
define("_admchkinvalidfilepath","Invalid file path.");
define("_admclinickchktotsize","Total size:");
define("_admclinicchkplen","Checking against Piece Length...");
define("_admclinicchkplenmissing","Piece Length missing. Invalid Torrent!");
define("_admclinicchkpieces","Checking against pieces...");
define("_admclinicchkpiecesok","Data is valid!");
define("_admclinicchkpiecesfail","Data is invalid!");
define("_admclinicchkpiecesmissing","Data is missing!");
define("_admclinicchkbasic","This Torrent is valid and has passed basic tests.");
define("_admclinicchkadvanced","Going through advanced tests...");
define("_admclinicdht","Checking against DHT Support in Azureus...");
define("_admclinicannouncelist","Checking against Multiple Trackers...");
define("_admclinicsupported","Supported");
define("_admclinicnotsupported","Not Supported");
define("_admclinicscraping","Querying Tracker...");
define("_admclinicscrapefail","It looks like this Torrent is not registered with the External Tracker");

#IRC
define("_admircintro","Configure phpMyBitTorrent's built-in IRC Chat.
You may configure every aspect of the PJIRC client: please read PJIRC's documentation before editing advanced parameters.<br />
<b>NOTICE</b>: file <i>include/irc.ini</i> MUST be writable");
define("_admircserver","Server");
define("_admircchannel","Channel");
define("_admircadvsettings","Here you can configure PJIRC's advanced settings. According to PJIRC documentation, insert the parameters with the following syntax:<br />
<i>name</i> = </i>value</i>");
define("_admircedit","Apply settings");
define("_VALUE","VALUE");
define("_admircenable","Enable IRC");
define("_admircdisable","Disable IRC");
define("_admirccantdelete","Cannot delete <i>include/irc.ini</i> because it's write-protected. Please delete the file manually. IRC Chat is still enabled!");
define("_admircinvalidhost","Invalid hostname or IP address");
define("_admircinvalidchannel","Invalid channel name");
define("_admircinvalidadvanced","Invalid syntax for advanced parameters");
define("_admirccantsave","Cannot save <i>include/irc.ini</i> because it's write-protected. Please save the file manually with the following content:");

#UPDATE
define("_admupdintro","phpMyBitTorrent is now trying to check for a newer version. The server must be capable of opening HTTP connections.");
define("_admupderror","Error: unable to connect.");
define("_admupdcurver","Current phpMyBitTorrent version is");
define("_admupdlastver","Last phpMyBitTorrent version is");
define("_admupdupdate","Please consider updating to the latest version.");
define("_admupdnoupdate","There is no need to update phpMyBitTorrent. Thank you.");

#USER MANAGER
define("_admuserintro","Manage registered users by editing their profile, setting their level or banning them.");
define("_admusersearchbtn","Search user");
define("_admuserlastlogin","Last seen");
define("_admuserlastip","Last IP");
define("_admuserviewprofile","View profile");
define("_admusereditprofile","Edit profile");
define("_admuserdelete","Delete user");
define("_admuserban","Ban user");
define("_admuserunban","Unban user");
define("_admusermailsearchbtn","Search E-Mail");
define("_admuserusername","User");
define("_admuseremail","E-Mail");
define("_admuserregistered","Registered");
define("_admuseripsearchbtn","Search IP");
define("_admuserhostsearchbtn","Search Host");

#DONATIONS
define("_admpdonations","Donations");
define("_admppaypal_email","PayPal E-Mail");
define("_admppaypal_emailexplain","The E-Mail address used with your Paypal-Account. Donations to this account will update the progress bar in the Donations Block on the front page. Log on to your PayPal account, go to My Account>Profile>Instant Payment Notification Preferences, and set the url there to $siteurl/paypal.php");

define("_admpsitecost","Donations Goal");
define("_admpsitecostexplain","Enter a goal for your donations drive in Dollars");

define("_admpreseaved_donations","Donations Collected");
define("_admpreseaved_donationsexplain","Amount of Money you've already got. Any donations reported by PayPal will be added to this, if you fill in your data above.");

define("_admpdonatepage","Donations Page");
define("_admpdonatepageexplain","Edit your Donations Page here (i.e., the page that is linked from the Donations Block on the front page). When pasting the code for the Donate-Button from PayPal, remember to click on 'Source' in the editor first.");

define("_admpdonation_block","Donation Block");
define("_admpdonation_blockexplain","Check if you want a donations block to be shown on the main page.");

define("_admpclock","Clock Block");
define("_admpclockexplain","Select If You Want a clock Block To be shown");

define("_admpradio","Radio Block");
define("_admpradioexplain","Select If You Want a Radio Block To be shown");

define("_admpnodonate","Indicator for zero donations");
define("_admpnodonateexplain","<ul><li><b>EU</b> Displays a EURO symbol when no donations have been made yet<li><b>UK</b> Displays a British Pound symbol when no donations have been made yet<li><b>US</b>  Displays a Dollar symbol when no donations have been made yet</ul>This setting does not affect the donation currency in any way, it's purely optical.");
define("_admpnodonateopt1","EURO");
define("_admpnodonateopt2","BPD");
define("_admpnodonateopt3","USD");

#Mass messages

define("_admmassmail","Mass Mail");
define("_admmassmailall","All");
define("_admmassmessage","Mass Messages");
define("_admmassmailerror","Try Again");
define("_admmasspm","Mass PM");
define("_admmasspmlong","Mass PM to selected User Levels");
define("_admmmsendto","Mass Mail to selected User Levels");


#LOGS
define("_admlogs","Log's");
define("_admlogmall","Mark All");
define("_admlogumall","Unmark all");
define("_admlles0","All entries");
define("_admlles1","1 day");
define("_admlles2","7 days");
define("_admlles3","2 weeks");
define("_admlles4","1 month");
define("_admlles5","3 months");
define("_admlles6","6 months");
define("_admlles7","1 year");
define("_admdisxpl","Display entries from previous: &nbsp;");
define("_admdodleal","Are you sure you want to Delete all log's ?");
define("_admdellogsse","Delete selected");
define("_admdodlese","Are you sure you want to Delete selected log's ?");
define("_admselcclear","Selected Log's have been cleared");
define("_admallclear","Log's have been cleared");

#style Editor
define("_admedt","Template");
define("_admedtp","Edit Template");
define("_admedtpexp","Here you can edit your template set directly. Please remember that these edits are permanent and cannot be undone once submitted. If PHP can write to the template files in your styles directory any changes here will be written directly to those files. If PHP cannot write to those files they will be copied into the database and all changes will only be reflected there. Please take care when editing your template set, remember to close all replacement variable terms {XXXX} and conditional statements.");
define("_admtmpslct","Selected Template: ");
define("_admtmpslctf","Select Template Folder");
define("SELECTED_TEMPLATE_FILE","Selected template file");
define("SELECT_TEMPLATE","Select template file");
define("SELECT_FOLDER","Theme folder");
define("TEMPLATE_EDITOR_HEIGHT","Template editor height");
define("TEMPLATE_EDITOR","Raw HTML template editor");
define("ACP_TEMPLATES_EXPLAIN","A template set comprises all the markup used to generate the layout of your board. Here you can edit existing template sets and preview sets.");
define("_admteditor","Theme Editor");
#Torrent Cient ban
define("_admnoclient","Client not set");
define("_admnobannedclient","No Banned Clients at this time");
define("_admclientban","Client Ban");
define("_adminclient","Client");
define("_adminclientre","Reason");
define("_admbanclientexp","This is Where you can ban Torrent Client!<br />You can ban eather the hole client or one version of the Client <br />To add  client you well need the pier_id info from the Client You well use such as With<br /> &micro;Torrent 1.8.1 You would add UT1810.<br />The reason for the Ban well be shown in the client So you well want to keep this short.");
#Bonus System
define("_admbonsetting","Bounce Settings");
define("_admbonalo","Allow Bonus");
define("_admbononof","Bonus On/Off");
define("_admbononofexp","This well Turn on Or Off Bonus System.");
define("_admbonup","Upload");
define("_admbonupex","This is the amount a user well get<br />for Uploading a torrent.");
define("_admbonupext","Upload Bonus");
define("_admbonco","Comments");
define("_admboncoex","This is the amount a user well get<br />for making a torrent comment.");
define("_admboncoext","Comment Bonus");
define("_admbonoffer","Offers");
define("_admbonofferex","This is the amount a user well get<br />for making a torrent Offer.");
define("_admbonofferext","Offer Bonus");
define("_admbonseed","Seeding");
define("_admbonseedex","This is the amount a user well get<br />for Seeding a torrent.<br />This setting works with Auto Clean Timer in settings");
define("_admbonseedext","Seeding Bonus");
define("_admbonseedtor","Give Bonus for Each Torrent");
define("_admbonseedtorex","If active Users well get a bonus for each torrent that they are seeding<br />If not they well only get a single bonus no matter how many torrents they seed");
define("_admbonseedtorext","Bonus For Each/All Torrents");
define("_admbonreq","Request Fill");
define("_admbonreqex","This is the amount a user well get<br />for Uploading a Torrent That was requested. This is ontop of the Uploading Bonus");
define("_admbonreqext","Filling Request Bonus");
define("_admbonbongo","Edit Bonus!");
#Level System
define("_adm_level_table","Admin Levels");
define("_adm_level_table_details","Viewing Level Details");
#FAQS
define("_adm_faq_sectile","Section/Item Title");
define("_adm_faq_hidden","Hidden");
define("_adm_faq_updated","Updated");
define("_adm_faq_new","New");
define("_adm_faq_norm","Normal");
define("_adm_faq_tile","Item Title");
define("_adm_faq_additem","Add new item");
define("_adm_faq_addsection","Add new section");
define("_adm_faq_orphen","Orphaned Items");
define("_adm_faq_order","Reorder");
define("_adm_faq_order_no_match","When the position numbers don't reflect the position in the table, it means the order id is bigger than the total number of sections/items and you should check all the order id's in the table and click \"reorder\"\n");
define("_TIME","Time");
define("_IP","User IP");
?>