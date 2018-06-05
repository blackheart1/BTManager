<?php

/**
**********************
** BT.Manager v3.0.1 **
**********************
** http://www.BT.Manager.org/
** https://github.com/blackheart1/BT.Manager
** http://demo.BT.Manager.org/index.php
** Licence Info: GPL
** Copyright (C) 2018
** Formerly Known As phpMyBitTorrent
** Created By Antonio Anzivino (aka DJ Echelon)
** And Joe Robertson (aka joeroberts)
** Project Leaders: joeroberts, Thor.
** File english.php 2018-06-04 08:34:00 Thor
**
** CHANGES
**
** 2018-06-04 - Fixed Spelling
** 2018-06-04 - Amended the Wording of some Sentences
**/

define("_ok","OK");
define("_error","Error");
define("_warning","Warning");
define("_nextstep","Next");
define("_reset","Reset");

//Step 1
define("_step1","<strong>Step 1: Installation Requirements</strong>");
define("_phpvercheck","Checking PHP Version");
define("_phpverfail","You need at least PHP version 4.3 to Install BT.Manager.");
define("_zlibcheck","Checking Zlib");
define("_zlibfail","Installing Zlib allows you to Save Bandwidth.");
define("_mysqlcheck","Checking MySQL");
define("_mysqlfail","You need MySQL PHP Extension to Access MySQL Database.");
define("_domxmlcheck","Checking Installed DOM XML");
define("_domxmlnotinstalled","DOM XML is not loaded in PHP and this could affect Performance.");
define("_domxmlload","Loading DOM XML from External Library");

define("_domxmlcantload","Cannot load DOM XML.  Check out how to Compile and Install it.  This is Required but, you could still run the Tracker without it.");

define("_externalcheck","Testing Outgoing Connections");
define("_externalfail","Cannot Update External Torrent Statistics in Real-time nor determine Active and Passive Users.");
define("_oscheck","Checking Operating System");
define("_files_folder","Checking to see if your Files Folder is Writeable");
define("_files_folder_fail","This Folder needs to be Writeable or you will not be able to Upload Forum Attachments.");
define("_cat_pics","Checking to see if your Category Pictures Folder is Writeable");
define("_cat_pics_fail","This Folder needs to be Writeable or you will not be able to Upload Category Images.");
define("_massupload","Checking to see if your Mass Upload Folder is Writeable");
define("_massupload_fail","This Folder needs to be Writeable for the Mass Upload System to work.");
define("_torrent_folder","Checking to see if your Torrent Folder is Writeable ");
define("_torrent_fail","This Folder needs to be Writeable or you will not be able to Upload Torrent Files.");
define("_image_bucket","Checking to see if your User Files Folder is Writeable ");
define("_image_bucket_fail","This Folder needs to be Writeable or your Users won't be able Upload Images to the Image Bucket.");
define("_avatarfolder","Checking to see if your Avatar Folder is Writeable ");

define("_avatarfail","This Folder needs to be Writeable or your Users will not be able to Upload their own Avatars.<br />They can still use Local or External Avatars depending on how you Configure Avatars in the Administration Panel.");

define("_cachefolder","Checking to make sure your Cache Folder is Writeable");

define("_cache_fail","This Folder needs to be Writeable because as the Template System depends on it.  Please <strong>CHMOD</strong> the Cache Folder to <strong>777</strong>.");

define("_udp_check","Checking to make sure UDP:// works on your Server");

define("_udpfail","Your Server is not Configured to work with Torrents that have a UDP Announce URL.<br />You may still be able to handle External Torrents so as long as their Announce URL is not based on the UDP Protocol.");

define("_step1fail","You cannot proceed with the Installation of BT.Manager as your Server doesn't meet the Minimum System Requirements.");

define("_step1warn","You can proceed with the Installation of BT.Manager, but you will not experience the Best Performance.");

//Step 2
define("_step2","<strong>Step 2: License Agreement</strong>");

define("_gpllicense","In order to Install BT.Manager you must Agree to ALL the Terms of the GNU/GPL License, under which BT.Manager is Released.");

define("_lgpllicense","You must also Agree to ALL Terms of the GNU/LGPL License because BT.Manager uses Open Source Libraries Released under that License.");

define("_iagree","I Agree");
define("_idontagree","I Do Not Agree");
define("_step2fail","You cannot proceed until you Accept both Licenses.");

//Step 3
define("_step3","<strong>Step 3: Basic Configuration</strong>");

define("_step3explain","You can now Configure BT.Manager's Basic Settings.  These Settings include Database Access (i.e. username, password...) and some Advanced Settings like Cookie Encryption and the Torrent Upload Directory.  Further details below.");

define("_dbconfig","Database Configuration");
define("_dbtype","Database Type");
define("_dbhost","Database Server");
define("_dbhosterror","Host is Unreachable.");
define("_dbuser","Access User Name");
define("_dbusererror","Cannot use these Credentials.");
define("_dbpass","Password");
define("_dbname","Database Name");
define("_dbnameerror","Cannot use this Database.  It may be non-existent or not accessible.");
define("_dbprefix","Table Prefix");
define("_dbpers","Persistent Connection");
define("_moresettings","More Settings");
define("_uploaddirectory","Upload Directory");
define("_mustwritable","Must be Writeable");
define("_updirnoexist","Directory Does Not Exist.");
define("_updirnowrite","Directory is Not Writeable.");
define("_serverreturned","Server Returned: <strong>**msg**</strong>");
define("_securecookies","Secure Cookies");
define("_rsacookies","Enable RSA&reg; Security");
define("_rsamod","Modulo");
define("_pubkey","Public Key");
define("_privkey","Private Key");

define("_permissioncmd","In order to make the Directory Writeable, Run the following Command from your Server Shell, making sure that your Logged in as <em>**User**</em>: <u>**cmd**</u>");

define("_cannotwriteconfig","Cannot Save the Configuration File.  Please Create a File named <strong>configdata.php</strong> in the <strong>/include</strong> directory of BT.Manager and Paste the following code in it (ALL of it -- if you Copy & Pasted correctly, the file starts with <strong><?php</strong> and ends with <strong>?></strong>)");

define("_step3complete","Configuration Completed.  You can now Install the BT.Manager Database.");

//Step 4
define("_step4","<strong>Step 4: Installing Database</strong>");
define("_checkingfiles","Checking Files...");
define("_step4fnotfound","Fatal Error.  Unable to Read File **file**.  Check Package Integrity and File Access Permissions.");
define("_btsqlerror1","Error Executing SQL Query ");
define("_btsqlerror2","Error ID: ");
define("_btsqlerror3","Error Message: ");
define("_tblcreating","Creating Table <strong>**table**</strong>...");
define("_installcategories","Creating Default Categories...");
define("_installsmiles","Installing Default Smiley's...");

define("_step4failed","A Fatal Error Occurred during Setup.  Please Fix the above Error and try running the Setup again, or Refreshing your Browser.");

define("_step4complete","Database Installation was Completed Successfully.  You can now Configure your Tracker according to your Preferences.");

define("_sql_admin_forum","Installing Default Forum Configuration");
define("_sql_arcade_categories","Installing Default Arcade Categories");
define("_sql_site_settings","Installing Default Site Settings");
define("_sql_arcade_settings","Installing Default Arcade Settings");
define("_sql_arcade_games","Installing Default Arcade Games");
define("_sql_attachments_config","Installing Default Attachment Configuration");
define("_sql_avatar_config","Installing Default Avatar Configuration");
define("_sql_avp","Installing Default Cleanup Clock");
define("_sql_bbcode","Installing a Test BBcode");
define("_sql_bonus","Installing Default Bonus Notice");
define("_sql_bonus_points","Installing Default Bonus Points");
define("_sql_cache_con","Installing Default Cache Configuration");
define("_sql_extension_groups","Installing Default File Extension Groups");
define("_sql_extensions","Installing Default File Extensions");
define("_sql_forum_config","Installing Default Forum Configuration");
define("_sql_icons","Installing Default Icons");
define("_sql_img_bucket","Installing Default Image Bucket Configuration");
define("_sql_level_privlages","Installing Default Level Privileges");
define("_sql_level_settings","Installing Default Level Settings");
define("_sql_levels","Installing Default Levels");
define("_sql_paypal","Installing Default PayPal Settings");
define("_sql_ranks","Installing Default Ranks");
define("_sql_ratiowarn_config","Installing Ratio Warning Configuration");
define("_sql_search_cloud","Installing Default Search Cloud Settings");
define("_sql_shout_config","Installing Default Shoutbox Settings");
define("_sql_time_offset","Installing Default Time Zones");
define("_sql_userautodel","Installing Default User Auto Delete Configuration");
define("_sql_acl_options","Installing Default Forum ACL");
define("_sql_acl_roles","Installing Default Forum ACL Roles");
define("_sql_acl_roles_data","Installing Default Forum ACL Roles Data");
define("_sql_modules","Installing Default Forum ACL Modules");
define("_sql_report_reasons","Installing Default Report Reasons");
define("_sql_countries","Installing Default Countries");
define("_sql_hit_run","Installing Default Hit & Run Configuration");
define("_sql_acl_groups","Installing Default Groups to ACL Table");

//Step 5
define("_step5","Step 5: BT.Manager Configuration");

define("_step5explain","Now you have to Configure your New BT.Manager Tracker.  The following are the Configuration Parameters that are available, that allow you to Customize every aspect of the Tracker.  However, you only need to make sure that the Basic Parameters are Set Correctly.  You will always be able to Change these Settings through the (ACP) Administrator Configuration Panel.");

define("_admpfree_dl","<strong>Freeleech Torrents</strong>");

define("_admpfree_dlexplain","Any Torrent that is marked Freeleech will not count against their Download Credit.  They will however still receive Upload Credit for any amount they Upload.  This is a Excellent way for them to Build up their Ratio.");

define("_admpgive_sign_up_credit","Give Upload Credit upon Signup");
define("_admpgive_sign_up_creditexplain","Give Users Upload Credit when they Signup to the Site.");

define("_admpconferm_email","Force email Confirmation");
define("_admpconferm_emailexplain","Force a User to Confirm their email Address before they can use the Site.");

define("_admpallow_multy_tracker","Allow Multi-Tracker Torrents");
define("_admpallow_multy_trackerexplain","Allow Users to Upload a Torrent with more then one Announce URL.");

define("_admpallow_external","Allow External Torrents");
define("_admpallow_externalexplain","Allow Users to Upload Torrents from other Sites.  Note: this may not work for every Site.");

define("_admppivate_mode","Private Tracker Mode");

define("_admppivate_modeexplain","Sets the Tracker to Private, this way no one can see the content unless they are a Member and are Logged in.");

define("_admpforce_passkey","Force Passkey");
define("_admpforce_passkeyexplain","Set this to Force your Members to use Passkey System.");

define("_admpaddprivate","Make ALL Internal Torrents Private");

define("_admpaddprivateexplain","When this is Set, then ALL Internal Torrents will be set to Private and the Uploaders will have to Download the Torrent from the Site in order to Seed it<br /><strong>This does not change External Torrents.</strong>");

define("_admpwait_time","Add Wait Time");

define("_admpwait_timeexplain","Once Enabled, Users who Do Not meet the Requirements that you've Set will have to Wait for 'x' amount of time before their Downloads will Start.<br /><br /><strong>You Must Remember</strong><br />to Set the Announce Access Level to Users and the Torrents will need to be set to Private.");

define("_admpGIGSA","Members with Uploads (in Gigabytes) Less than");
define("_admpGIGSAexplain","Set the First Minimum Upload in GB for the First Wait Period.");

define("_admpGIGSB","Members with Uploads (in Gigabytes) Less than");
define("_admpGIGSBexplain","Set the Second Minimum Upload in GB for the Second Wait Period.");

define("_admpGIGSC","Members with Uploads (in Gigabytes) Less than");
define("_admpGIGSCexplain","Set the Third Minimum Upload in GB for the Third Wait Period.");

define("_admpGIGSD","Members with Uploads (in Gigabytes) Less than");
define("_admpGIGSDexplain","Set the Fourth Minimum Upload in GB for the Fourth Wait Period.");

define("_admpRATIOA","Members with a Ratio Less than");
define("_admpRATIOAexplain","Set the Fist Minimum Ratio.");

define("_admpRATIOB","Members with a Ratio Less than");
define("_admpRATIOBexplain","Set the Second Minimum Ratio.");

define("_admpRATIOC","Members with a Ratio Less than");
define("_admpRATIOCexplain","Set the Third Minimum Ratio.");

define("_admpRATIOD","Members with a Ratio Less than");
define("_admpRATIODexplain","Set the Fourth Minimum Ratio.");

define("_admpWAITA","Members must Wait 'x' amount of Hours.");
define("_admpWAITAexplain","Set the First Wait Period in Hours.");

define("_admpWAITB","Members must Wait 'x' amount of Hours");
define("_admpWAITBexplain","Set the Second Wait Period in Hours.");

define("_admpWAITC","Members must Wait 'x' amount of Hours");
define("_admpWAITCexplain","Set the Third Wait Period in Hours.");

define("_admpWAITD","Members must Wait 'x' amount of Hours");
define("_admpWAITDexplain","Set the Fourth Wait Period in Hours.");

define("_admpallow_magnet","Allow eD2K/Magnet Link's");
define("_admpallow_magnetexplain","");

define("_admpauto_clean","Auto Clean Timer");
define("_admpauto_cleanexplain","Sets the Time Intervals of the Cleanup Sessions.  Example the Bonus System.");

define("_admpmax_members","Maximum Allowed Members");
define("_admpmax_membersexplain","Maximum Number of Members Allowed to Join your Site.");

define("_admpinvite_only","Invite Only");
define("_admpinvite_onlyexplain","Only Allows Users to Join if they have been Invited.");

define("_admpinvites_open","Invite System");
define("_admpinvites_openexplain","Turn the Invite System On or Off.");

define("_admpupload_dead","Allow 'Dead' External Torrents");

define("_admpupload_deadexplain","Use this to Allow for (apparently) Unseeded External Torrents to be Uploaded to the Site.  This might be useful if the External Torrent Monitoring System doesn't work so well, which depends on your Server Configuration.");

define("_basicsettings","Basic Settings");
define("_advancedsettings","Advanced Settings");
define("_admpsitename","Site Name");
define("_admpsitenameexplain","The Name of this Site.  This will be displayed as the Page Title.");

define("_admpsiteurl","Site URL");
define("_admpsiteurlexplain","The URL of this Site.  This must be entered before using the Tracker.");

define("_admpcookiedomain","Cookie Domain");

define("_admpcookiedomainexplain","Cookie Domain.  This must be Set to the Domain Name of this Site (e.g. yoursite.com).  Required for the User Login to work.");

define("_admpcookiepath","Cookie Path");

define("_admpcookiepathexplain","Cookie Path.  Change this Setting <strong>ONLY</strong> if BT.Manager is Installed in a Sub-Directory on your Server.  If your Installation is in http://yoursite.com/BT.Manager, the Setting should be /BT.Manager");

define("_admpsourcedir","Source Directory");

define("_admpsourcedirexplain","Please enter the Full Source/File Directory Path for System use.<br />DO NOT use / or ./ Using the Wrong Path will Cause Errors on the Site Pages.");

define("_admpuse_gzip","Use GZIP Compression");

define("_admpuse_gzipexplain","This Option allows you to Enable or Disable PHP's GZIP Compression on HTML and Announce Output.  If Enabled, Bandwidth Usage will be Lower but CPU Usage will be Higher.  This Setting doesn't work OK on All Servers; if your Users Report any GZIP Errors in their Clients, Turn it Off.  Verify that your Tracker Reads the Announce Response Correctly.");

define("_admpadmin_email","Administrator email Address");

define("_admpadmin_emailexplain","The email Address from which ALL emails to Users will be Sent (Signup,PM Notifications, Authorisations, etc.). It may be a good idea to use a Valid Address.");

define("_admplanguage","Default Language");
define("_admplanguageexplain","Specifies the Default Language the Site will use.");

define("_admpannounce_url","Site Announce URL's");

define("_admpannounce_urlexplain","Add the Announce URL's that will be used by the Site.<br />Put each one on a New Line.");

define("_admptheme","Theme");

define("_admpthemeexplain","Set the Default Theme for this Site.  Registered Users can Override this Setting from their User Control Panel.");

define("_admpwelcome_message","Welcome Message");

define("_admpwelcome_messageexplain","If Set, this Defines the Message that you get on Top of the Main Page.  If you leave this Blank, you'll get the Default Message.");

define("_admpannounce_text","Tracker Message");

define("_admpannounce_textexplain","If Set, this Defines the Message that Users will see in their BitTorrent Client when they Connect to the Tracker.  Useful for Announcements and Publicity.");

define("_admpallow_html","Use HTML Editor");

define("_admpallow_htmlexplain","Enable this Option to Allow Users to Write Torrent Descriptions using the embedded HTML Editor. <br /><strong>WARNING</strong>: this Feature is Still Experimental!");

define("_admprewrite_engine","SearchRewrite");

define("_admprewrite_engineexplain","SearchRewrite transforms PHP's Complex URL's into Faux HTML Pages, which are easier to type into the Address Bar.  This Feature is also Very Useful to Increase Search Engine Traffic.  Apache's mod_rewrite or IIS's ISAPI_Rewrite are REQUIRED to be Installed on your Server.");

define("_admptorrent_prefix","Torrent Prefix");

define("_admptorrent_prefixexplain","This Option Allows you to Add a Custom Prefix to All Torrents Downloaded from this Tracker.  Useful to Spread the Word about your Community.");

define("_admptorrent_per_page","Torrents Per Page");

define("_admptorrent_per_pageexplain","Indicates how many Torrents can be Displayed on each page, both in Listing and in Search Mode.");

define("_admponlysearch","Search Only");

define("_admponlysearchexplain","Hide Torrent List to non-Administrators.  Users (whether Registered or not) will have to perform a Search to See and Download to any Torrents.");

define("_admpmax_torrent_size","Maximum Torrent Size");

define("_admpmax_torrent_sizeexplain","Maximum Byte Size for Uploaded .torrent Files.  This does NOT put any Limit on the Size of the Actual Files being Shared with the .torrent!");

define("_admpannounce_interval","Announce Update Interval");
define("_admpannounce_intervalexplain","Recommended Time Interval between Announce Requests.  This Value is Sent to the Client.");

define("_admpannounce_interval_min","Minimum Announce Update Interval");

define("_admpannounce_interval_minexplain","Recommended Time Interval between Announce Requests.  More Frequent Requests will be Refused.");

define("_admpdead_torrent_interval","Dead Torrent Interval");

define("_admpdead_torrent_intervalexplain","Specifies the Amount of Time (in seconds) that a Dead Torrent (No Peers) can be kept Visible in the Tracker. After that Period, it will be Automatically Hidden.");

define("_admpminvotes","Minimum Votes");
define("_admpminvotesexplain","Minimum Number of Votes before Torrent Ratings are Displayed.");

define("_admptime_tracker_update","Autoscrape Interval");

define("_admptime_tracker_updateexplain","Specifies the Interval between External Tracker Queries.  Requires Autoscrape Enabled.");

define("_admpbest_limit","Best Torrent Peer Limit");
define("_admpbest_limitexplain","Number of Total Peers above which the Torrent is Included in the Top Torrents List/RSS Feed.");

define("_admpdown_limit","Dead Torrent Peer Limit");
define("_admpdown_limitexplain","Number of Total Peers below which the Torrent is Treated as Dead.");

define("_admptorrent_complaints","Torrent Complaints");

define("_admptorrent_complaintsexplain","Allows Users to Complain about a Torrent in it's Details Page, in an attempt to Block Undesired Content, such as Child Pornography.  Torrents that get a certain number of Complaints will Automatically be Banned.");

define("_admptorrent_global_privacy","Torrent Authorisations");

define("_admptorrent_global_privacyexplain","Switching this On Allows Registered Uploaders to put Limitations on Who can Download their Torrents.  The Owner of a Torrent can either Authorise Downloads on a case-by-case Basis, or Automatically, by Setting an Overall Share Ratio that the Downloader must Meet.  You have to Set the Tracker Access Level to 'User' in order for this to work.");

define("_admpdisclaimer_check","Disclaimer");

define("_admpdisclaimer_checkexplain","If Checked, Users have to Accept a Disclaimer before they Register.  You can change the Disclaimer by Changing the File /disclaimer/english.txt");

define("_admpgfx_check","Captcha Test");
define("_admpgfx_checkexplain","If Checked, Users have to Type in a Code from a Captcha Image when Registering and Logging in.");

define("_admpupload_level","Upload Access Level");

define("_admpupload_levelexplain","Determines the User Level Required to Upload Torrents<ul><li><strong>'Everyone'</strong> Allows Anyone to Upload Torrent Files to this Site. They won't be able to Edit them or Manage Authorisations<li><strong>'Registered'</strong> Requires Uploaders to be Registered. <strong>'Premium'</strong> Only Allows Premium Users to Upload.<li></ul>");

define("_admpupload_levelopt1","Everyone");
define("_admpupload_levelopt2","Registered");
define("_admpupload_levelopt3","Premium");

define("_admpdownload_level","Download Access Level");

define("_admpdownload_levelexplain","<ul><li><strong>'Everyone'</strong>, anyone can Download Torrents<li><strong>'Registered'</strong>, Only Registered Users can Download Torrents<li><strong>'Premium'</strong>, Only Premium Users can Download Torrents</ul>This Setting does Not affect the Tracker, so if somebody got their hands on a .torrent they can Download.");

define("_admpdownload_levelopt1","Everyone");
define("_admpdownload_levelopt2","Registered");
define("_admpdownload_levelopt3","Premium");

define("_admpannounce_level","Tracker Access Level");

define("_admpannounce_levelexplain","<ul><li><strong>'Everyone'</strong>, anyone to Connect to the Tracker (i.e. announce)<li><strong>'Registered'</strong>, Requires the User to be Logged in (IP Address is Checked!) before Connecting to the Tracker</ul>This Setting does Not affect Torrent Downloads from the Site.");

define("_admpannounce_levelopt1","Everyone");
define("_admpannounce_levelopt2","Registered");

define("_admpmax_num_file","Maximum Torrent File Number");

define("_admpmax_num_fileexplain","Maximum Number a Torrent can contain, above which it won't be Accepted for Upload.  Use it if you'd like to encourage people to use Compressed Archives.  Setting this to Zero will just Ignore the Parameter.");

define("_admpmax_share_size","Maximum Torrent Share Size");

define("_admpmax_share_sizeexplain","Total Combined Size of Files in a Torrent, above which the Upload won't be Accepted.  Setting this to Zero will just Ignore the Parameter.");

define("_admpglobal_min_ratio","Global Minimum Ratio");

define("_admpglobal_min_ratioexplain","Specify a Minimum Upload/Download Ratio, below which a User will Not be Allowed to Download any more Torrents. The Option is applicable Only if the Announce Level (above) is set to 'User' on the Download page.  Setting this to Zero will Disable the Option.");

define("_admpautoscrape","External Torrent Monitoring");

define("_admpautoscrapeexplain","This allows you to Monitor the Peer Count for Torrents Tracked by Remote Trackers.<br />Be careful here, you can ONLY use this if your Server can Open Sockets to Sites.  Many Cheap or Free Hosting Services have Firewalls that Block Outgoing Connections.  If you're not using a Dedicated/Home Server, it is recommended that you DO NOT Enable this Option unless you're sure of what you're doing.<br />If you don't Enable it all External Torrents will be Displayed as having Zero Seeds.  If you Enable it, but your Server can't Build Connections to Scrape then External Uploads may be Rejected (unless you check the 'Allow Dead External Torrents'");

define("_admpmax_num_file_day_e","Maximum Number of Daily Downloads");

define("_admpmax_num_file_day_eexplain","Defines how many Files can be Downloaded Per Day by a Single User.  Any Requests above this will be Refused and the User will be asked to try again the Next Day.<br />Premium Users are Not affected by this Setting.  Setting this Option to Zero will Disable it.");

define("_admpmax_num_file_week_e","Maximum Number of Weekly Downloads");

define("_admpmax_num_file_week_eexplain","Defines how many Files can be Downloaded in a Week's time by a Single User.  Any Requests above this will be Refused and the User will be asked to try again the following Week.<br />Premium Users are Not affected by this Setting.  Setting this Option to Zero will Disable it.");

define("_admpmin_num_seed_e","Minimum Seed Number for New Downloads");

define("_admpmin_num_seed_eexplain","Defines how many Torrents the User must be Seeding before Downloading New Files.<br />Premium Users are Not affected by this Setting.  Setting this Option to Zero will Disable it.");

define("_admpmin_size_seed_e","Minimum Seed Size for New Downloads");

define("_admpmin_size_seed_eexplain","Defines how many Torrents the User must be Seeding before Downloading New Files.<br />Premium Users are Not affected by this Setting.  Setting this Option to Zero will Disable it.");

define("_admpsourcedir","Sources Directory");
define("_admpsourcedirexplain","Please give the Full Source Directory Path for System Use.<br />DO NOT use / or ./");

define("_admpmaxupload_day_num","Maximum Daily Torrent Uploads");

define("_admpmaxupload_day_numexplain","Defines how many Torrents can be Uploaded in a Single Day.  Any Uploads above above this will be Refused and the User will be asked to try again the Next Day.<br />Premium Users are Not affected by this Setting.  Setting this Option to Zero will Disable it.");

define("_admpmaxupload_day_share","Maximum Daily Files Upload");

define("_admpmaxupload_day_shareexplain","Defines the Maximum Total Size of Files (all files within a torrent combined) a User can Upload in a Single Day.  Any further Uploads above this will be Refused and the User will be asked to try again the Next Day.<br />Premium Users are Not affected by this Setting.  Setting this Option to Zero will Disable it.");

define("_admpminupload_file_size","Minimum Torrent Size for Upload");

define("_admpminupload_file_sizeexplain","Defines the Minimum Total Size of Files (all files within a torrent combined) for Upload.<br />Premium Users are Not affected by this Setting.  Setting this Option to Zero will Disable it.");

define("_admpallow_backup_tracker","Backup Tracker");

define("_admpallow_backup_trackerexplain","Runs your Tracker as a Backup Tracker according to the BitTorrent's Announce List Extension.  Usage is subject to Announce Level Settings and does Not affect Ratios.  This Option is Ignored if Stealth Mode is Enabled.");

define("_admpstealthmode","Disable Local Tracker");

define("_admpstealthmodeexplain","This will Disable and Hide the Local Tracker.  BT.Manager will Only Accept Externally Tracked Torrents.");

define("_step5complete","Tracker is now Configured.  Now Create your Administrator Account and get ready to Log in!");

//Step 6
define("_step6","<strong>Step 6: Administrator Account</strong>");

define("_step6explain","Now that you have Configured your Tracker, you need to Define an Administrator Account.  Logging in as an Administrator will give you Access the Administration Panel and you'll have Full Control over your Tracker.  Administrators act as Super Users.  Remember also that you can Change your Personal Settings in your Profile Page.");

define("_username","Username");
define("_password","Password");
define("_passwordconf","Confirm Password");
define("_email","email Address");
define("_fullname","Full Name (Optional)");
define("_usernamereq","Username (Required)");
define("_usernametoolong","Username can Not be Longer Than 25 Characters!");
define("_passwordreq","Password (Required)");
define("_passwordnomatch","Passwords DO NOT match!");
define("_emailinvalid","A Valid email Address is Required!");
define("_step6complete","Administrator Account Successfully Registered. Now you are ready to Complete the Setup.");

//Step 7
define("_step7","<strong>Installation Complete!</strong>");

define("_step7explain","Congratulations!  BT.Manager has now been Installed and Configured.  Now you can start using your Brand New Tracker and Start Sharing Files!  Before starting, keep in mind the following:-");

define("_thingstodo","<ul>\n
<li><p>Please Delete the <em>setup</em> Directory!  For Security Reasons, BT.Manager will Not work until the Directory is Deleted.</p></li>\n
<li><p>Use the Account you just Created to Set your Tracker Preferences to Create your Peer-to-Peer Community.  Don't Share your Administrator Password.</p></li>\n
<li><p>Please remember to Run often the Database Optimiser, an Important Tool to keep the Tracker efficient when Server Load Grows.</p></li>\n
<li><p>If you need Help from Trusted Users to Manage the Tracker, remember that Moderators can Freely Manage Torrents without them needing Access to the Administration Panel.</p></li>\n
<li><p>Finally, remember that Culture Exchange is Freedom, but Piracy is a Crime.</p></li>\n
<li><p>If you like BT.Manager, why don't you consider making a Small <strong>Donation</strong> to those who wrote it in order to help keep the Project Alive and Updated?</p></li>\n
</ul>\n");

define("_thanks","Thank you for choosing this fantastic Open Source Software. Regards, the BT.Manager Team!");
define("_enter","Enter BT.Manager");

?>