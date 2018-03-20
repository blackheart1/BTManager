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
** File english.php 2018-02-17 14:32:00 joeroberts
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/

define("_ok","OK");
define("_error","Error");
define("_warning","Warning");
define("_nextstep","Next");
define("_reset","Reset");

//Step 1
define("_step1","Step 1: Installation Requirements");
define("_phpvercheck","Checking PHP Version");
define("_phpverfail","You need PHP at least 4.3 to install BT.Manager");
define("_zlibcheck","Checking Zlib");
define("_zlibfail","Installing Zlib allows you to save bandwidth");
define("_mysqlcheck","Checking MySQL");
define("_mysqlfail","You need MySQL PHP Extension to access MySQL Database");
define("_domxmlcheck","Checking installed DOM XML");
define("_domxmlnotinstalled","DOM XML is not loaded in PHP. This could affect performance.");
define("_domxmlload","Loading DOM XML from external library");
define("_domxmlcantload","Cannot load DOM XML. Check out how to compile and install it. It is required, but you could still run the Tracker");
define("_externalcheck","Testing outgoing connections");
define("_externalfail","Cannot update External Torrent statistics realtime nor determine Active and Passive users");
define("_oscheck","Checking Operating System");
define('_files_folder','Checking to see if your files folder is write able');
define('_files_folder_fail','This folder well need to be write able for you to beable to use Forum attachments');
define('_cat_pics','Checking to see if your Cat Pics folder is Write able');
define('_cat_pics_fail','This folder well need to be write able for you to beable to use Category image upload');
define('_massupload','Checking to see if your MassUpload folder is Write able');
define('_massupload_fail','This well need to be made write able for the massupload system to work properly');
define('_torrent_folder','Checking to see if your torrent folder is Write able');
define('_torrent_fail','This folder must be writeable or you well not beable to upload torrent files.');
define('_image_bucket','Checking to see if your UserFiles folder is Write able');
define('_image_bucket_fail','UserFiles folder is not Write able this means that users well not be able to use the image bucket');
define('_avatarfolder','Checking to see if your Avatar folder is Write able');
define('_avatarfail','Your avatars/user folder is not writeable so your users well not beable to upload there own avatars <br />But they can still use local or external depending on how you configure avatars in admin panel');
define('_cachefolder','Checking to make sure your Cache folder is Writeable');
define('_cache_fail','Your Cache folder is not writeable Please make it chmod 777 because the template system depends on it');
define('_udp_check','Checking to make sure udp:// works on your server');
define('_udpfail','Your server is not configured to work with torrents that have a udp announce url.<br />You may stell beable to handle external torrents as long as there announce is not based on udp protocal.');


define("_step1fail","You can't proceed with the installation of BT.Manager since you don't match minimum requirements.");
define("_step1warn","You can proceed with the installation of BT.Manager, but you won't experience best performance.");

//Step 2
define("_step2","Step 2: License Agreement");
define("_gpllicense","In order to install BT.Manager you must agree with all terms of the GNU/GPL license,
under which BT.Manager is released.");
define("_lgpllicense","You must also agree to all terms of the GNU/LGPL license because BT.Manager uses
Open Source libraries released under that license.");
define("_iagree","I Agree");
define("_idontagree","I Do Not Agree");
define("_step2fail","You cannot proceed until you accept both licenses.");

//Step 3
define("_step3","Step 3: Basic configuration");
define("_step3explain","You can now configure BT.Manager's basic settings.
These settings include database access (ie username, password...) and some advanced settings
like cookie encryption and Torrent upload directory. Further details below.");
define("_dbconfig","Database Configuration");
define("_dbtype","Database Type");
define("_dbhost","Database Server");
define("_dbhosterror","Host is unreachable.");
define("_dbuser","Access User Name");
define("_dbusererror","Cannot use these credentials.");
define("_dbpass","Password");
define("_dbname","Database Name");
define("_dbnameerror","Cannot use this database. It may be non-existant or not accessible.");
define("_dbprefix","Table Prefix");
define("_dbpers","Persistent Connection");
define("_moresettings","More Settings");
define("_uploaddirectory","Upload Directory.");
define("_mustwritable","Must be writable");
define("_updirnoexist","Directory does not exist.");
define("_updirnowrite","Directory is not writable.");
define("_serverreturned","Server Returned: <b>**msg**</b>");
define("_securecookies","Secure Cookies");
define("_rsacookies","Enable RSA&reg; Security");
define("_rsamod","Modulo");
define("_pubkey","Public Key");
define("_privkey","Private Key");
define("_permissioncmd","In order to make the directory writable, run the following command from your server shell, logged in as <i>**user**</i>: <u>**cmd**</u>");
define("_cannotwriteconfig","Cannot save the configuration file. Please create a file named configdata.php in the /include directory of BT.Manager and paste the following code in it (ALL of it -- if you copy&pasted correctly, the file starts with '<?php' and ends with '?>')");
define("_step3complete","Configuration completed. Now you can install BT.Manager Database.");

//Step 4
define("_step4","Step 4: Installing Database");
define("_checkingfiles","Checking files...");
define("_step4fnotfound","Fatal Error. Unable to read file **file**. Check package integrity and file access permissions.");
define("_btsqlerror1","Error executing SQL Query ");
define("_btsqlerror2","Error ID: ");
define("_btsqlerror3","Error Message: ");
define("_tblcreating","Creating table <b>**table**</b>...");
define("_installcategories","Creating default categories...");
define("_installsmiles","Installing default smileys...");
define("_step4failed","A fatal error occurred during setup. Please fix the above error and try running Setup again, or refreshing your browser.");
define("_step4complete","Database Installation has been successfully completed. Now you can configure your tracker according to your preferences.");
define('_sql_admin_forum','Installing default forum configs');
define('_sql_arcade_categories','Installing default Arcade Categories');
define('_sql_site_settings','Installing default Site Settings');
define('_sql_arcade_settings','Installing default Arcade Settings');
define('_sql_arcade_games','Installing default Arcade Games');
define('_sql_attachments_config','Installing default attachment configs');
define('_sql_avatar_config','Installing default avatar configs');
define('_sql_avp','Installing default cleanup clock');
define('_sql_bbcode','Installing a test BBcode');
define('_sql_bonus','Instaling default Bonus notice');
define('_sql_bonus_points','Installing default Bonus points');
define('_sql_cache_con','Installing default cache configs');
define('_sql_extension_groups','Installing default file extention groups');
define('_sql_extensions','Installing default file extentions');
define('_sql_forum_config','Installing default Forum config');
define('_sql_icons','Installing default Icons');
define('_sql_img_bucket','Installing default Image Bucket configs');
define('_sql_level_privlages','Installing default level privilages');
define('_sql_level_settings','Installing default level settings');
define('_sql_levels','Installing default levels');
define('_sql_paypal','Installing default paypal settings');
define('_sql_ranks','Installing default ranks');
define('_sql_ratiowarn_config','Installing Ratio Warning confis');
define('_sql_search_cloud','Installing default search cloud settings');
define('_sql_shout_config','Installing default shout box settings');
define('_sql_time_offset','Instaling default time zones');
define('_sql_userautodel','installing default user auto delete config');
define('_sql_acl_options','installing default Forum ACL');
define('_sql_acl_roles','installing default  Forum ACL Roles');
define('_sql_acl_roles_data','installing default  Forum ACL Roles Data');
define('_sql_modules','installing default  Forum ACL Modules');
define('_sql_report_reasons','installing default Report reasons');
define('_sql_countries','installing default Countries');
define('_sql_hit_run','installing default Default H&R Configs');
define('_sql_acl_groups','Installing Default Groups to ACL table');

//Step 5
define("_admpfree_dl","Free Torrent Down Loads");
define("_admpfree_dlexplain","Give Members Free down loads. None of the down loads well e recorded during the time that this is seleted only ther upload");

define("_admpgive_sign_up_credit","Give Upload on signup");
define("_admpgive_sign_up_creditexplain","Give users Upload win the sign up to the site.");

define("_admpconferm_email","Force E-mail comfermation");
define("_admpconferm_emailexplain","Force a user to conferm ther e-mail Before they can use the site.");

define("_admpallow_multy_tracker","Allow Multy Tracker Torrents");
define("_admpallow_multy_trackerexplain","Allow Users To Upload A Torrent with More then One announce.");

define("_admpallow_external","Allow External Torrents");
define("_admpallow_externalexplain","Allow Users to Upload Torrents From Other Sites.");

define("_admppivate_mode","Privat Tracker Mode");
define("_admppivate_modeexplain","Sets tracker to private and no one can see the content inless they are a member and are logged in.");

define("_admpforce_passkey","Force Passkey");
define("_admpforce_passkeyexplain","Set this to force your members to use Passkey system");

define("_admpaddprivate","Make All Internal Torrents private");
define("_admpaddprivateexplain","When this is set all Internal torrents well be set to private and the uploaders well have to down load the torrent from the site in order to seed it<br /><b>This dose not change external torrents!!!</b>");
////////wait
define("_admpwait_time","Add Wait Time");
define("_admpwait_timeexplain","When You set this users with a set cryterea well have to wait for a set amount of time before there downloads well start. <br /><br /><b>You must remember</b><br />To set the anounce access level to users and the torrents well need to be set to Private");

define("_admpGIGSA","For Member With Uploads (IN GIGS) less then");
define("_admpGIGSAexplain","Set the first minnum upload In Gigs for the first wait period");

define("_admpGIGSB","For Member With Uploads (IN GIGS) less then");
define("_admpGIGSBexplain","Set the second minnum upload In Gigs for the first wait period");

define("_admpGIGSC","For Member With Uploads (IN GIGS) less then");
define("_admpGIGSCexplain","Set the third minnum upload In Gigs for the first wait period");

define("_admpGIGSD","For Member With Uploads (IN GIGS) less then");
define("_admpGIGSDexplain","Set the fourth minnum upload In Gigs for the first wait period");

define("_admpRATIOA","For Member With a ratio less then");
define("_admpRATIOAexplain","Set the fist minnamum ratio");

define("_admpRATIOB","For Member With a ratio less then");
define("_admpRATIOBexplain","Set the second minnamum ratio");

define("_admpRATIOC","For Member With a ratio less then");
define("_admpRATIOCexplain","Set the third minnamum ratio");

define("_admpRATIOD","For Member With a ratio less then");
define("_admpRATIODexplain","Set the fourth minnamum ratio");

define("_admpWAITA","Must Wait for this many hours");
define("_admpWAITAexplain","Set the first wait period in hours");

define("_admpWAITB","Must Wait for this many hours");
define("_admpWAITBexplain","Set the second wait period in hours");

define("_admpWAITC","Must Wait for this many hours");
define("_admpWAITCexplain","Set the third wait period in hours");

define("_admpallow_magnet","Allow eD2K/Magnet link's");
define("_admpallow_magnetexplain","");

define("_admpWAITD","Must Wait for this many hours");
define("_admpWAITDexplain","Set the fourth wait period in hours");
define("_admpauto_clean","Auto Clean Timer");
define("_admpauto_cleanexplain","Sets the time intervals Of the clean sessions. For like with the bonus system.");

define("_admpmax_members","Max allowed Members");
define("_admpmax_membersexplain","Max number of members allowed to join your site.");

define("_admpinvite_only","Inite Only");
define("_admpinvite_onlyexplain","Only allows for users to join if they have been invited.");

define("_admpinvites_open","Invite system");
define("_admpinvites_openexplain","turn on and off the invite system.");

define("_admpupload_dead","Allow 'dead' External Torrents");
define("_admpupload_deadexplain","Use this to allow for (apparently) un-seeded external torrents to be uploaded to tracker. Might be usefull if the external torrent monitoring doesn't work so well, which depends on your server configuration.");
define("_step5","Step 5: BT.Manager Configuration");
define("_step5explain","Now you have to configure your new BT.Manager Tracker. The following are all configuration parameters available, that allow you
to customize every aspect of the tracker. However, you will need only to make sure that the basic parameters are set correctly. You will always be able to change
the settings by logging in as an Administrator into your Config Panel.");
define("_basicsettings","Basic Settings");
define("_advancedsettings","Advanced Settings");
define("_admpsitename","Site Name");
define("_admpsitenameexplain","The name of your site. Will be displayed as the page title.");

define("_admpsiteurl","Site URL");
define("_admpsiteurlexplain","URL of this site. Must be entered for using the tracker.");

define("_admpcookiedomain","Cookie Domain");
define("_admpcookiedomainexplain","Cookie domain. Must be set to the domain name of this site (e.g. yoursite.com). Required for user login to work.");

define("_admpcookiepath","Cookie Path");
define("_admpcookiepathexplain","Cookie Path. Change this setting <b>only</b> if BT.Manager is installed in a subdirectory of your server. If your installation is in http://yoursite.com/BT.Manager, the setting should be /BT.Manager");

define("_admpsourcedir","Source Directory");
define("_admpsourcedirexplain","Please Give the Full Source/File directory path for system use.<br />Do not use / or ./ Using the wrong path well cause errors on the site pages.");

define("_admpuse_gzip","Use GZIP compression");
define("_admpuse_gzipexplain","This option allows you to enable or disable PHP's GZIP compression on HTML and Announce output. If enabled, bandwidth usage will be lower but CPU usage will be higher. This setting doesn't work fine on all servers; if your users report any Gzip errors in their clients, turn it off. Verify that your tracker reads the Announce response correctly.");

define("_admpadmin_email","Administrator E-Mail");
define("_admpadmin_emailexplain","E-Mail Address from which all emails to users will be sent (signup,pm notifications, authorizations, etc.). It may be a good idea to enter a valid address.");

define("_admplanguage","Default Language");
define("_admplanguageexplain","Specifies the default language to use.");

define('_admpannounce_url','Site Announce URL\'s');
define('_admpannounce_urlexplain','Add the Announce URL\'s that well be used by the site.<br />Put each one on a new line.');

define("_admptheme","Theme");
define("_admpthemeexplain","Set the default theme for this site. Registered users can override this setting from their panel.");

define("_admpwelcome_message","Welcome Message");
define("_admpwelcome_messageexplain","If set, this defines the message that you get o the top of the Main Page. If you leave this blank, you'll get the default message.");

define("_admpannounce_text","Tracker Message");
define("_admpannounce_textexplain","This defines the message that users see on their BitTorrent Client when they connect to the Tracker. Useful for announcements and publicity.");

define("_admpallow_html","Use HTML Editor");
define("_admpallow_htmlexplain","Enable this option to allow users to write Torrent Descriptions using the embedded HTML-editor. <br /><b>WARNING</b>: this feature is still experimental!");

define("_admprewrite_engine","SearchRewrite");
define("_admprewrite_engineexplain","SearchRewrite transforms PHP's complex URLs into faux HTML pages, easier to type into the address bar. This feature is also very useful to increase search engine traffic. Apache's mod_rewrite or IIS's ISAPI_Rewrite are REQUIRED on your server.");

define("_admptorrent_prefix","Torrent Prefix");
define("_admptorrent_prefixexplain","This option allows you to add a custom prefix to all Torrents downloaded from this tracker. Useful to spread the word about your community.");

define("_admptorrent_per_page","Torrents per page");
define("_admptorrent_per_pageexplain","Indicates how many Torrents can be displayed each page, both in listing and in search mode.");

define("_admponlysearch","Search Only");
define("_admponlysearchexplain","Hide Torrent List to non-Admins. Users (whether registered or not) have to perform a search to get to any torrents.");

define("_admpmax_torrent_size","Maximum Torrent Size");
define("_admpmax_torrent_sizeexplain","Maximum byte size for uploaded .torrent files. This does NOT put any limit to the size of the actual size of any files shared with the .torrent!");

define("_admpannounce_interval","Announce Update Interval");
define("_admpannounce_intervalexplain","Recommended time interval between Announce request. This value is sent to the client.");

define("_admpannounce_interval_min","Minimum Announce Update Interval");
define("_admpannounce_interval_minexplain","Recommended time interval between Announce requests. More frequent requests will be refused.");

define("_admpdead_torrent_interval","Dead Torrent Interval");
define("_admpdead_torrent_intervalexplain","Specifies the amount of time (in seconds) that a dead Torrent (no peers) can be kept visible in the tracker. After that period, it will be automatically hidden.");

define("_admpminvotes","Minimum votes");
define("_admpminvotesexplain","Minimum number of votes to display a Torrent rating at all.");

define("_admptime_tracker_update","Autoscrape Interval");
define("_admptime_tracker_updateexplain","Specifies the interval between External Tracker queries. Requires Autoscrape enabled.");

define("_admpbest_limit","Best Torrent Peer Limit");
define("_admpbest_limitexplain","Number of total peers above which the Torrent is included in the Top Torrents List/RSS feed.");

define("_admpdown_limit","Dead Torrent Peer Limit");
define("_admpdown_limitexplain","Number of total peers below which the Torrent is treated as Dead.");

define("_admptorrent_complaints","Torrent Complaints");
define("_admptorrent_complaintsexplain","Allows users to complain about a  torrent in its details page, in an attempt to to block undesired content, such as child pornography. Torrent that get a certain number of complaints are automatically banned.");

define("_admptorrent_global_privacy","Torrent Authorizations");
define("_admptorrent_global_privacyexplain","Switching this on allows registered uploaders to put limitations on who can download their torrents. The owner of a torrent can either authorize downloads on a case-to case basis, or automatically, by setting a overall share ratio that the downloader has to meet. You have to set the Tracker Access Level to 'User' in order for this to work.");

define("_admpdisclaimer_check","Disclaimer");
define("_admpdisclaimer_checkexplain","If checked, users have to accept a disclaimer before they register. You can change the disclaimer by changing the file /disclaimer/english.php.");

define("_admpgfx_check","Captcha Test");
define("_admpgfx_checkexplain","If checked, users have to type in a code from a captcha image when registering and logging in.");

define("_admpupload_level","Upload access level");
define("_admpupload_levelexplain","Determines the user level required for the permission to upload torrents<ul><li><b>'Everyone'</b> allows anyone to upload Torrent files to this site. They won't be able to edit them or manage authorizations<li><b>'Registered'</b> requires uploaders to be registered. <b>'Premium'</b> only allows Premium users to upload.<li></ul>");
define("_admpupload_levelopt1","Everyone");
define("_admpupload_levelopt2","Registered");
define("_admpupload_levelopt3","Premium");

define("_admpdownload_level","Download access level");
define("_admpdownload_levelexplain","<ul><li><b>'Everyone'</b> allows anyone to download Torrent files from this site<li><b>'Registered'</b> requires registration<li><b>'Premium'</b> allows only Premium users to download a .torrent from this site</ul>This setting does not affect the tracker. So if somebody got their hands on a .torrent, they can download.");
define("_admpdownload_levelopt1","Everyone");
define("_admpdownload_levelopt2","Registered");
define("_admpdownload_levelopt3","Premium");

define("_admpannounce_level","Tracker access level");
define("_admpannounce_levelexplain","<ul><li><b>'Everyone'</b> allows anyone to connect to the tracker (i.e. announce) <li><b>'Registered'</b> requires the user to log in (IP address is checked!) before connecting to the tracker</ul>This setting does not affect Torrent download from site.");
define("_admpannounce_levelopt1","Everyone");
define("_admpannounce_levelopt2","Registered");

define("_admpmax_num_file","Maximum Torrent file number");
define("_admpmax_num_fileexplain","Maximum number a torrent can contain, above which it won't be accepted for upload. Use it if you'd like to encourage people to use compressed archives. Setting to zero will just ignore the parameter.");

define("_admpmax_share_size","Maximum Torrent Share Size");
define("_admpmax_share_sizeexplain","Total combined size of files in a torrent, above which the upload won't be accepted. Setting this to zero will just ignore the parameter.");

define("_admpglobal_min_ratio","Global Minimum Ratio");
define("_admpglobal_min_ratioexplain","Specify a minimum upload/download ratio, below which a user will not be allowed to download any more torrents. The option is applicable only if the Announce Level (above) is set to 'User' of the download page. Setting zero will disable the option.");

define("_admpautoscrape","External Torrent Monitoring");
define("_admpautoscrapeexplain","This allows you to monitor the peer count for torrents tracked by remote trackers.<br>Be careful here.<br>You can use this ONLY if your server can open sockets to any other machines. Many cheap or free hosting services have firewalls that block outgoing connections. If you're not using a Dedicated/Home Server, it is recommended that you DO NOT enable this option unless you're sure what you're doing.<br>If you don't enable it all external torrents will be displayed having zero sources. If you enable it, but your server can't build connections to scrape, external uploads may be rejected (unless you check 'Allow dead External Torrents'");

define("_admpmax_num_file_day_e","Maximum number of daily downloads");
define("_admpmax_num_file_day_eexplain","Defines how many files can be downloaded per day by a single user. Any requests abov that will be refused and the user will be asked to try again the next day.<br>Premium users are not affected by this setting. Setting this option to zero will disable it.");

define("_admpmax_num_file_week_e","Maximum number of weekly downloads");
define("_admpmax_num_file_week_eexplain","Defines how many files can be downloaded in a week's time by a single user. Further requests will be refused and the user will be asked to try again the next week.<br>Premium users are not affected by this setting. Setting this option to zero will disable it.");

define("_admpmin_num_seed_e","Minimum seed number for new downloads");
define("_admpmin_num_seed_eexplain","Defines how many Torrents the user must be seeding before downloading new files.<br>Premium users are not affected by this setting. Setting this option to zero will disable it.");

define("_admpmin_size_seed_e","Minimum seed size for new downloads");
define("_admpmin_size_seed_eexplain","Defines how much share the user must be seeding before downloading new files.<br>Premium users are not affected by this setting. Setting this option to zero will disable it.");

define("_admpsourcedir","Sources Directory");
define("_admpsourcedirexplain","Please Give the Full source directory path for system use.<br />Do not use / or ./");

define("_admpmaxupload_day_num","Maximum daily uploads");
define("_admpmaxupload_day_numexplain","Defines how many Torrents can be uploaded in a single day. Any uploads above that won't be accepted and the user will be asked to try again the next day.<br>Premium users are not affected by this setting. Setting this option to zero will disable it.");

define("_admpmaxupload_day_share","Maximum Daily upload");
define("_admpmaxupload_day_shareexplain","Defines the maximum total size of files (all files within a torrent combined) a user can upload in a single day. Any further uploads won't be accepted and the user will be asked to try again the next day.<br>Premium users are not affected by this setting. Setting this option to zero will disable it.");

define("_admpminupload_file_size","Minimum Torrent size for upload");
define("_admpminupload_file_sizeexplain","Defines Torrent's minimum size (all files within a torrent combined) for upload.<br>Premium users are not affected by this setting. Setting this option to zero will disable it.");

define("_admpallow_backup_tracker","Backup Tracker");
define("_admpallow_backup_trackerexplain","Runs your tracker as a Backup Tracker according to the BitTorrent's Announce-List extension. Usage is subject to Announce level settings and does not affect ratios. This option is ignored if Stealth Mode is enabled.");

define("_admpstealthmode","Disable Local Tracker");
define("_admpstealthmodeexplain","This will disable and hide the local tracker. BT.Manager will only accept externally tracked torrents.");
define("_step5complete","Tracker is now configured. Now create your Administrator account and get ready to log in!");

//Step 6
define("_step6","Step 6: Administrator Account");
define("_step6explain","Now that you have configured your Tracker, you need to define an Administrator account. Logging in as an Administrator will give you access the Administration Panel and have full control over your Tracker. Administrators act as Super Users. Remember also that you can change your personal settings in your Profile Page.");
define("_username","Username");
define("_password","Password");
define("_passwordconf","Confirm Password");
define("_email","E-Mail Address");
define("_fullname","Full Name (optional)");
define("_usernamereq","Username is required!");
define("_usernametoolong","Username cannot be longer than 25 characters!");
define("_passwordreq","Password is required!");
define("_passwordnomatch","Passwords do not match!");
define("_emailinvalid","A valid E-Mail Address is required!");
define("_step6complete","Administrator Account successfully registered. Now you are ready to complete the setup.");

//Step 7
define("_step7","Installation Completed!");
define("_step7explain","Congratulations! BT.Manager has been finally installed and configured. Now you have just to run your brand new Tracker and start sharing files!
Before starting, keep in mind the following:");
define("_thingstodo","<ul>\n
<li><p>Please delete the <i>setup</i> directory! For security reasons, BT.Manager will not work until the directory is deleted.</p></li>\n
<li><p>Use the account you just created to set your Tracker preferences and learn how to use them best to create your peer-to-peer community. Don't tell anybody your Administrator Password.</p></li>\n
<li><p>Please remember to run often the Database Optimizator, an important tool to keep the Tracker efficient when server load grows.</p></li>\n
<li><p>If you need help from trusted users to manage the Tracker, please remember that Moderators can freely manage Torrents without being able to enter Administration Panel.</p></li>\n
<li><p>Finally, remember that culture exchange is freedom, but piracy is a crime.</p></li>\n
<li><p>If you like BT.Manager, why don't you make a small <b>donazione</b> to who wrote it in order to keep the Project alive?</p></li>\n
</ul>\n");
define("_thanks","Thanks for having chosen this fantastic Open Source Software. The BT.Manager Team!");
define("_enter","Enter BT.Manager");

?>