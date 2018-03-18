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
** File site_settings/english.php 2018-02-28 21:27:00 Thor
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
    '_admsaved'                          => 'Settings Saved!',
    '_admconfigttl'                      => 'BTManager Configuration',
    '_admconfigttlexplain'               => 'Here you can Setup the Basic Operation of your Tracker, Site Name and Description among other Settings where you can Adjust the Default Values for Themes and Languages.',
    #user
    '_admpallow_change_email'            => 'Allow email Change',
    '_admpallow_change_emailexplain'     => 'Allow Users to Change their email Address. <br />They will be sent an email which they Must Confirm for the Changes to Take Effect.',

    '_admpgive_sign_up_credit'           => 'Give Upload Credit on Signup',
    '_admpgive_sign_up_creditexplain'    => 'Gives Users Upload Credit when they Signup to the Site.',

    '_admpoff_line_mess'                 => 'Offline Message',
    '_admpoff_line_messexplain'          => 'You can Enter a Short (255 character) Message to Display if you wish.',

    '_admpannounce_url'                  => 'Site Announce URL\'s',
    '_admpannounce_urlexplain'           => 'Add the Announce URL\'s that will be used by the Site.<br>Put each one on a New Line.',

    '_admpon_line'                       => 'Site Online',
    '_admpon_lineexplain'                => 'Set Site On/Offline.',

    '_admprecap_https'                   => 'Use SSL for reCAPTCHA',
    '_admprecap_httpsexplain'            => 'Should the Request be made over SSL?',


    '_admpPublic_Key'                    => 'reCAPTCHA Public Key',
    '_admpPublic_Keyexplain'             => 'If You have a reCAPTCHA Account and a Public Key you can use it here.<br />Leave the Field Blank and the Site will use a Base64 CAPTCHA code.<br />for more info on reCAPTCHA visit here <a href=\'http://www.google.com/recaptcha/learnmore\'>What is reCAPTCHA</a>.',


    '_admpPrivate_Key'                   => 'reCAPTCHA Private Key',
    '_admpPrivate_Keyexplain'            => 'Add your reCAPTCHA Private Key here, Leave it Blank if you don\'t have one.',


    '_admptime_zone'                     => 'Site Default Time Zone',

    '_admptime_zoneexplain'              => 'Set the Default Time Zone for your Site.<br />To find out what Time Zone to use Click on the Links below.<br /> <a target=\'_blank\' href=\'http://www.php.net/manual/en/timezones.africa.php\'>Africa</a>, '.'<a target=\'_blank\' href=\'http://www.php.net/manual/en/timezones.america.php\'>America</a>, <a target=\'_blank\' href=\'http://www.php.net/manual/en/timezones.antarctica.php\'>Antarctica</a>, <a target=\'_blank\' href=\'http://www.php.net/manual/en/timezones.arctic.php\'>Arctic</a>, <a target=\'_blank\' href=\'http://www.php.net/manual/en/timezones.asia.php\'>Asia</a>, <a target=\'_blank\' href=\'http://www.php.net/manual/en/timezones.atlantic.php\'>Atlantic</a>, <a target=\'_blank\' href=\'http://www.php.net/manual/en/timezones.australia.php\'>Australia</a>, <a target=\'_blank\' href=\'http://www.php.net/manual/en/timezones.europe.php\'>Europe</a>, <a target=\'_blank\' href=\'http://www.php.net/manual/en/timezones.indian.php\'>Indian</a>, <a target=\'_blank\' href=\'http://www.php.net/manual/en/timezones.pacific.php\'>Pacific</a>, <a target=\'_blank\' href=\'http://www.php.net/manual/en/timezones.others.php\'>Others</a>',


    '_admpconferm_email'                 => 'Force e-mail Confirmation',
    '_admpconferm_emailexplain'          => 'Force a User to Confirm their e-mail Address before they can use the Site.',

    #torrents
    '_admpallow_multy_tracker'           => 'Allow Multi Tracker Torrents',
    '_admpallow_multy_trackerexplain'    => 'Allow Users To Upload a Torrent with more than one Announce URL.',

    '_admpallow_external'                => 'Allow External Torrents',
    '_admpallow_externalexplain'         => 'Allow Users to Upload Torrents from Other Sites.',


    '_admpauto_clean'                    => 'Auto Clean Timer',
    '_admpauto_cleanexplain'             => 'Sets the Time Intervals between Cleaning Sessions (in Seconds).',

    '_admppivate_mode'                   => 'Private Tracker Mode',
    '_admppivate_modeexplain'            => 'Sets the Tracker to Private, this way NO ONE can View the Content unless they are a Member and are Logged In.',

    '_admpaddprivate'                    => 'Make ALL Local Torrents Private',
    '_admpaddprivateexplain'             => 'Sets ALL Newly Uploaded Local Torrents as Private, if they were NOT done so already when the Uploader Created the Torrent.<br /><b>The Uploader will need to Download the Torrent from the Site in order to Seed the Torrent..</b><br /><br />The Private Option which Only some Client\'s recognise. Enabling the Private Option Disables DHT',

    '_admpmax_members'                   => 'Maximum Allowed Members',
    '_admpmax_membersexplain'            => 'Maximum Number of Members Allowed to Join your Site.',

    '_admpinvite_only'                   => 'Invite Only',
    '_admpinvite_onlyexplain'            => 'Only Allows Users who have been sent an Invite to Join.',

    '_admpforce_passkey'                 => 'Force Passkey',
    '_admpforce_passkeyexplain'          => 'Set this to Force your Members to use Passkey System',

    '_admpinvites_open'                  => 'Invite System',
    '_admpinvites_openexplain'           => 'Turn On and Off the Invite System.',

    '_admpupload_dead'                   => 'Allow Dead External Torrents',
    '_admpupload_deadexplain'            => 'Use this to Allow for (apparently) Unseeded External Torrents to be Uploaded to Tracker. This might be useful if the External Torrent Monitoring doesn\'t work so well, which depends on your Server Configuration.',

    '_admpsitename'                      => 'Site Name',
    '_admpsitenameexplain'               => 'The Name of your Site. This will be displayed as the Page Title.',

    '_admpsiteurl'                       => 'Site URL',
    '_admpsiteurlexplain'                => 'URL of this Site. This must be Entered for using the Tracker.',

    '_admpcookiedomain'                  => 'Cookie Domain',
    '_admpcookiedomainexplain'           => 'Cookie Domain. This must be Set to the Domain Name of this Site (e.g. yoursite.com). Required for User Login to Work.',

    '_admpcookiepath'                    => 'Cookie Path',
    '_admpcookiepathexplain'             => 'Cookie Path. Change this Setting <b>ONLY</b> if BTManager is Installed in a Subdirectory on your Server. If your Installation is in http://yoursite.com/btmanager, the Setting should be /btmanager',

    '_admpuse_gzip'                      => 'Use gzip Compression',
    '_admpuse_gzipexplain'               => 'This Option Allows you to Enable or Disable php\'s gzip Compression on HTML and Announce Output. If Enabled, Bandwidth Usage will be Lower but CPU Usage will be Higher. This Setting doesn\'t work on ALL Servers.  If your Users Report any gzip Errors in their Clients, turn it Off. Verify that your Tracker Reads the Announce Response Correctly.',

    '_admpadmin_email'                   => 'Administrator email',
    '_admpadmin_emailexplain'            => 'email Address from which ALL emails to Users will be Sent (Signup, PM Notifications, Authorizations, etc.). Make sure you Enter a Valid Address.',

    '_admplanguage'                      => 'Default Language',
    '_admplanguageexplain'               => 'Set the Default Language the Site will use.',

    '_admptheme'                         => 'Theme',
    '_admpthemeexplain'                  => 'Set the Default Theme for this Site. Registered Users can Override this Setting from the User Control Panel.',

    '_admpwelcome_message'               => 'Site News',
    '_admpwelcome_messageexplain'        => 'Anything you Enter here will appear in a Box on Top of the Torrent Index. Leave the Field Blank to make the Box Disappear altogether.',

    '_admpannounce_text'                 => 'Tracker Message',
    '_admpannounce_textexplain'          => 'This Defines the Message that Users will see in their Torrent Client when they Connect to the Tracker. Useful for Announcements and Publicity.',

    '_admpallow_html'                    => 'Use HTML Editor',
    '_admpallow_htmlexplain'             => 'Enable this Option to Allow Users to Write Torrent Descriptions using the embedded HTML Editor. <br /><b>WARNING</b>: this feature is still Experimental!',

    '_admprewrite_engine'                => 'Search Rewrite',
    '_admprewrite_engineexplain'         => 'Search Rewrite transforms php\'s complex URL\'s into faux HTML Pages, making it easier to type into the Address Bar. This feature is also very useful to Increase Search Engine Traffic. Apaches mod_rewrite or IIS\'s ISAPI_Rewrite is REQUIRED on your Server.',

    '_admptorrent_prefix'                => 'Torrent Prefix',
    '_admptorrent_prefixexplain'         => 'This Option Allows you to Add a Custom Prefix to ALL Torrents Downloaded from this Tracker. Useful to Spread the Word about your Community.',

    '_admptorrent_per_page'              => 'Torrents Per Page',
    '_admptorrent_per_pageexplain'       => 'Indicates how many Torrents can be Displayed on each page, both in Listing and in Search Mode.',

    '_admponlysearch'                    => 'Search Only',
    '_admponlysearchexplain'             => 'Hides the Torrent List so that Users without Administrator Access (whether Registered or NOT) will have to Perform a Search in order to View any Torrents.',

    '_admpmax_torrent_size'              => 'Maximum Torrent Size',
    '_admpmax_torrent_sizeexplain'       => 'Maximum Byte Size for Uploaded .torrent Files. This DOES NOT put any Limits on the actual Torrent itself but ONLY on the size of the .torrent file itself.',

    '_admpannounce_interval'             => 'Announce Update Interval',
    '_admpannounce_intervalexplain'      => 'Recommended Time Interval (in Seconds) between Announce Requests. This Value is Sent to the Client.',

    '_admpannounce_interval_min'         => 'Minimum Announce Update Interval',
    '_admpannounce_interval_minexplain'  => 'Recommended Time Interval between Announce Requests (in Seconds). More Frequent Requests will be Refused.',

    '_admpdead_torrent_interval'         => 'Dead Torrent Interval',
    '_admpdead_torrent_intervalexplain'  => 'Specifies the Amount of Time (in Seconds) that a Dead Torrent (NO Peers) can be kept Visible on the Site after which period, they will be Automatically Hidden.',

    '_admpfree_dl'                       => 'Turn Freeleech On or Off',
    '_admpfree_dlexplain'                => 'Allows Members to Download any Torrent on the Site without it effecting their Download Ratio. Only their Upload Amount will be Recorded',

    '_admpwait_time'                     => 'Add Wait Time',
    '_admpwait_timeexplain'              => 'When you Set this, Users who meet the below criteria will have to Wait for a Set Amount of Time before their Downloads will Start. <br /><br /><b>You must Remember</b><br />to Set the Announce Access Level to Users and the Torrents must be Set to Private',

    '_admpGIGSA'                         => 'For Members With Uploads (in GB) Less than',
    '_admpGIGSAexplain'                  => 'Set the First Minimum Upload in GB for the First Wait Period before a User can Download a Torrent',

    '_admpGIGSB'                         => 'For Members With Uploads (in GB) Less than',
    '_admpGIGSBexplain'                  => 'Set the Second Minimum Upload in GB for the Second Wait Period before a User can Download a Torrent',

    '_admpGIGSC'                         => 'For Members With Uploads (in GB) Less than',
    '_admpGIGSCexplain'                  => 'Set the Third Minimum Upload in GB for the Third Wait Period before a User can Download a Torrent',

    '_admpGIGSD'                         => 'For Members With Uploads (in GB) Less than',
    '_admpGIGSDexplain'                  => 'Set the Fourth Minimum Upload in GB for the Fourth Wait Period before a User can Download a Torrent',

    '_admpRATIOA'                        => 'For Member\'s With a Ratio Less than',
    '_admpRATIOAexplain'                 => 'Set the Fist Minimum Ratio a User must have before they can Download a Torrent',

    '_admpRATIOB'                        => 'For Member\'s With a Ratio Less than',
    '_admpRATIOBexplain'                 => 'Set the Second Minimum Ratio a User must have before they can Download a Torrent',

    '_admpRATIOC'                        => 'For Member\'s With a Ratio Less than',
    '_admpRATIOCexplain'                 => 'Set the Third Minimum Ratio a User must have before they can Download a Torrent',

    '_admpRATIOD'                        => 'For Members With a Ratio Less than',
    '_admpRATIODexplain'                 => 'Set the Fourth Minimum Ratio a User must have before they can Download a Torrent',

    '_admpWAITA'                         => 'Must Wait for this many Hours',
    '_admpWAITAexplain'                  => 'Set the First Wait Period in Hours a User must Wait before they can Download a Torrent',

    '_admpWAITB'                         => 'Must Wait for this many Hours',
    '_admpWAITBexplain'                  => 'Set the Second Wait Period in Hours a User must Wait before they can Download a Torrent',

    '_admpWAITC'                         => 'Must Wait for this many Hours',
    '_admpWAITCexplain'                  => 'Set the Third Wait Period in Hours a User must Wait before they can Download a Torrent',

    '_admpWAITD'                         => 'Must Wait for this many Hours',
    '_admpWAITDexplain'                  => 'Set the Fourth Wait Period in Hours a User must Wait before they can Download a Torrent',

    '_admpminvotes'                      => 'Minimum Votes',
    '_admpminvotesexplain'               => 'Minimum Number of Votes Required to Display Torrent Ratings.',

    '_admptime_tracker_update'           => 'Autoscrape Time Interval',
    '_admptime_tracker_updateexplain'    => 'Sets the Autoscrape Time Interval (in Seconds).',

    '_admpbest_limit'                    => 'Best Torrent Peer Limit',
    '_admpbest_limitexplain'             => 'Number of Total Peers above which the Torrent is Included in the Top Torrents List/RSS Feed.',

    '_admpdown_limit'                    => 'Dead Torrent Peer Limit',
    '_admpdown_limitexplain'             => 'Number of Total Peers below which the Torrent is Treated as Dead.',

    '_admptorrent_complaints'            => 'Torrent Complaints',
    '_admptorrent_complaintsexplain'     => 'Allows Users to Complain about a Torrent in it\'s Details Page, in an Attempt to to Block Undesired Content, such as Child Pornography. Any Torrent that receives a certain Number of Complaints will be Automatically Banned.',

    '_admptorrent_global_privacy'        => 'Torrent Authorizations',
    '_admptorrent_global_privacyexplain' => 'Switching this ON Allows Registered Uploaders to put Limitations on Who Can Download their Torrents. The Owner of a Torrent can either Authorize Downloads on a Case-by-Case Basis, or Automatically by Setting an Overall Share Ratio that the Downloader has to meet. You have to Set the Tracker Access Level to User in Order for this to Work.',

    '_admpdisclaimer_check'              => 'Disclaimer',
    '_admpdisclaimer_checkexplain'       => 'If Checked, Users have to Accept a Disclaimer before they can Register. You can Change the Disclaimer by Changing the File /disclaimer/english.php.',

    '_admpgfx_check'                     => 'CAPTCHA Test',
    '_admpgfx_checkexplain'              => 'If Checked, Users have to Type in a Code from a CAPTCHA Image when Registering and Logging In.',

    '_admpupload_level'                  => 'Upload Access Level',

    '_admpupload_levelexplain'           => 'Determines the User Level Required to Upload Torrents<ul><li><b>Everyone</b> Allows Anyone to Upload Torrent Files to this Site. They wont be able to Edit them or Manage Authorizations<li><b>Registered</b> Requires Uploaders to be Registered. <br /><li><b>Premium</b> ONLY Allows Premium Users to Upload.</ul>',

    '_admplevelopt'                      => array('all'=>'Everyone', 'user'=>'Registered', 'premium'=>'Premium'),
    '_admpdownload_level'                => 'Download Access Level',

    '_admpdownload_levelexplain'         => '<ul><li><b>Everyone</b> Allows Anyone to Download Torrent Files from this Site<li><b>Registered</b> Requires Registration<li><b>Premium</b> Allows ONLY Premium Users to Download a Torrents from this Site</ul>This Setting DOES NOT affect the Tracker. So if somebody got their hands on a .torrent, they would be able to Download.',

    '_admpannounce_level'                => 'Tracker Access Level',

    '_admpannounce_levelexplain'         => '<ul><li><b>Everyone</b> Allows Anyone to Connect to the Tracker (i.e. Announce) <li><b>Registered</b> Requires the User to Log In (IP Address is Checked!) before Connecting to the Tracker.  </ul>This Setting DOES NOT Affect Torrents Downloaded from the Site.',

    '_admpannounce_levelopt'             => array('all'=>'Everyone', 'user'=>'Registered'),

    '_admpmax_num_file'                  => 'Maximum Amount of Files in a Torrent',

    '_admpmax_num_fileexplain'           => 'Maximum Number of Files a Torrent can contain, any amount above this will cause the Upload to Fail. Use it if you\'d like to encourage Users to use Compressed Archives. Setting this to Zero will Disable this Option.',

    '_admpmax_share_size'                => 'Maximum Torrent Share Size',

    '_admpmax_share_sizeexplain'         => 'Total Combined Size of Files in a Torrent, any amount above this will cause the Upload to Fail. Setting this to Zero will Disable this Option.',

    '_admpglobal_min_ratio'              => 'Global Minimum Ratio',

    '_admpglobal_min_ratioexplain'       => 'Specify the Minimum Upload/Download Ratio.  Users will NOT be Allowed to Download any more Torrents if they don\'t meet this criteria. The Option is applicable ONLY if the Announce Level (above) is Set to User on the Download Page. Setting this to Zero will Disable this Option.',

    '_admpautoscrape'                    => 'External Torrent Monitoring',

    '_admpautoscrapeexplain'             => 'This Allows you to Monitor the Peer Count for Torrents Tracked by Remote Trackers.<br />Be careful here.<br /><br />You can ONLY use this if your Server can Open Sockets to Other Machines. Many Cheap or Free Hosting Services have Firewalls that Block Outgoing Connections. If you\'re NOT using a Dedicated/Home Server, it is recommended that you DO NOT Enable this Option unless you\'re sure you know what you\'re doing.<br>If you don\'t Enable it ALL External Torrents will be Displayed as having Zero Sources. If you Enable it, but your Server can\'t Build Connections to Scrape, External Uploads may be Rejected (unless you Check Allow Dead External Torrents)',

    '_admpmax_num_file_day_e'            => 'Maximum Number of Daily Downloads',

    '_admpmax_num_file_day_eexplain'     => 'Defines how many Files can be Downloaded Per Day by a Single User. Any Requests above that will be Refused and the User will be asked to try again the next day.<br>Premium Users are NOT affected by this Setting. Setting this to Zero will Disable this Option.',

    '_admpmax_num_file_week_e'           => 'Maximum Number of Weekly Downloads',

    '_admpmax_num_file_week_eexplain'    => 'Defines how many Files can be Downloaded in a Week\'s time by a single User. Further Requests will be Refused and the User will be asked to try again the next week.<br>Premium Users are Not affected by this Setting. Setting this to Zero will Disable this Option.',

    '_admpmin_num_seed_e'                => 'Minimum Seed Number for New Downloads',

    '_admpmin_num_seed_eexplain'         => 'Defines how many Torrents a User must be Seeding before Downloading any New Files.<br>Premium Users are NOT affected by this Setting. Setting this to Zero will Disable this Option.',

    '_admpmin_size_seed_e'               => 'Minimum Seed Size for New Downloads',

    '_admpmin_size_seed_eexplain'        => 'Defines the Minimum Share Ratio a User must have before Downloading New Files.<br>Premium Users are NOT affected by this setting. Setting this to Zero will Disable this Option.',

    '_admpminupload_size_file'           => 'Minimum File Size for New Torrents',

    '_admpminupload_size_fileexplain'    => 'Defines The Minimum File Size a Torrent be.<br>Premium Users are NOT affected by this Setting. Setting this to Zero will Disable this Option.',

    '_admpmaxupload_day_num'             => 'Maximum Daily Uploads',

    '_admpmaxupload_day_numexplain'      => 'Defines how many Torrents can be Uploaded in a Single Day. Any Uploads above this will NOT be accepted and the User will be asked to try again the next day.<br>Premium Users are NOT affected by this Setting. Setting this to Zero will Disable this Option.',

    '_admpmaxupload_day_share'           => 'Maximum Daily Upload',

    '_admpmaxupload_day_shareexplain'    => 'Defines the Maximum Total Size of Files (ALL Files within a Torrent Combined) a User can Upload in a Single Day. Any further Uploads will NOT be accepted and the User will be asked to try again the next day.<br>Premium Users are NOT affected by this Setting. Setting this to Zero will Disable this Option.',

    '_admpminupload_file_size'           => 'Minimum Torrent Size for Uploads',
    '_admpminupload_file_sizeexplain'    => 'Defines Torrent\'s Minimum Size (ALL Files within a Torrent Combined) for Upload.<br>Premium Users are NOT affected by this Setting. Setting this to Zero will Disable this Option.',

    '_admpallow_backup_tracker'          => 'Backup Tracker',
    '_admpallow_backup_trackerexplain'   => 'Runs your Tracker as a Backup Tracker according to the BitTorrent\'s Announce List extension. Usage is subject to Announce Level Settings and DOES NOT affect Ratios. This Option is Ignored if Stealth Mode is Enabled.',

    '_admpstealthmode'                   => 'Disable Local Tracker',
    '_admpstealthmodeexplain'            => 'This will Disable and Hide the Local Tracker. BTManager will ONLY accept Externally Tracked Torrents.',
    'SITE_SETTINGS'                      =>	'Board Configuration',
    'MENU_PRIVATE_MESSAGE'               =>	'Private Message Settings',
    'MENU_BBCODE'                        =>	'BBcode Settings',

    #Advanced Settings PM
    'PMFULLOPTION'                       => array('1'=>'Delete Oldest Messages','2'=>'New Messages will be Held Back'),
    '_admpallow_privmsg'                 => 'Private Messaging',
    '_admpallow_privmsgexplain'          => 'Enable or Disable Private Messaging for ALL Users.',
    '_admpallow_pm_attach'               => 'Allow Attachments in Private Messages',
    '_admpallow_pm_attachexplain'        => 'Enable or Disable Allowing Attachments in Private Messaging for ALL Users.',

    '_admppm_max_boxes'                  =>	'Maximum Private Message Folders',
    '_admppm_max_boxesexplain'           =>	'By Default Users may Create this many Personal Folders for Private Messages.',

    '_admppm_max_msgs'                   =>	'Maximum Private Messages Per Box',
    '_admppm_max_msgsexplain'            =>	'Users can\'t Receive anymore than this many Messages in each of their Private Message Boxes. Set this Value to 0 to Allow Unlimited Messages.',

    '_admpfull_folder_action'            =>	'Full Folder Default Action',
    '_admpfull_folder_actionexplain'     =>	'Default Action to take if a Users Folder is Full, assuming the Users Folder Action, is Set at ALL, this is NOT applicable. The Only exception is for the Sent Messages Folder where the Default Action is always to Delete Old Messages.',

    '_admppm_edit_time'                  =>	'Limit Editing Time',
    '_admppm_edit_timeexplain'           =>	'Limits the Time Available to Edit a Private Message that has NOT already been Delivered. Setting the Value to 0 Disables this Option.',

    '_admpallow_mass_pm'                 => 'Allow Sending of Private Messages to Multiple Users and Groups',
    '_admpallow_mass_pmexplain'          => 'Allow Users to Send Private Messages to Multiple Users and Groups',

    '_admpauth_bbcode_pm'                => 'Allow BBCode in Private Messages',
    '_admpauth_bbcode_pmexplain'         => 'Allow Users to use BBCode in Private Messages',

    '_admpauth_smilies_pm'               => 'Allow Smilies in Private Messages',
    '_admpauth_smilies_pmexplain'        => 'Allow Users to use Smilies in Private Messages',

    '_admpallow_sig_pm'                  => 'Allow Signature in Private Messages',
    '_admpallow_sig_pmexplain'           => 'Allow Users to use Signatures in Private Messages',

    '_admpprint_pm'                      => 'Allow Print View in Private Messaging',
    '_admpprint_pmexplain'               => 'Allow Users to use the Print View in Private Messaging',

    '_admpforward_pm'                    => 'Allow Forwarding of Private Messages',
    '_admpforward_pmexplain'             => 'Allow Users to Forward Private Messages',

    '_admpauth_img_pm'                   => 'Allow the use of <code>[IMG]</code> BBCode Tags',
    '_admpauth_img_pmexplain'            => 'Allow Users to use the <code>[IMG]</code> Tag in Private Messages',

    '_admpauth_flash_pm'                 => 'Allow the use of <code>[FLASH]</code> BBCode Tags',
    '_admpauth_flash_pmexplain'          => 'Allow Users to use the <code>[FLASH]</code> BBCode Tag in Private Messages',

    '_admpenable_pm_icons'               => 'Enable Topic Icons in Private Messages',
    '_admpenable_pm_iconsexplain'        => 'Allow Users to use Topic Icons in Private Messages',

    '_admpallow_sig'                     => 'Allow Signatures',
    '_admpallow_sigexplain'              => 'Allow Users to use Signatures',

    '_admpallow_sig_bbcode'              => 'Allow BBCode in Users Signatures',
    '_admpallow_sig_bbcodeexplain'       => 'Allow Users to use BBCode in their Signatures',

    '_admpallow_sig_img'                 => 'Allow the use of <code>[IMG]</code> BBCode Tag in Users Signatures',
    '_admpallow_sig_imgexplain'          => 'Allow Users to use the <code>[IMG]</code> Tag in User Signatures',

    '_admpallow_sig_flash'               => 'Allow the use of <code>[FLASH]</code> BBCode Tag in User Signatures',
    '_admpallow_sig_flashexplain'        => 'Allow Users to use the <code>[FLASH]</code> BBCode Tag in Users Signatures',

    '_admpallow_sig_smilies'             => 'Allow Smilies in Users Signatures',
    '_admpallow_sig_smiliesexplain'      => 'Allow Users to use Smilies in their Signature',

    '_admpallow_sig_links'               => 'Allow Links in Users Signatures',
    '_admpallow_sig_linksexplain'        => 'Allow Users to use Links in their Signatures',

    '_admpmax_sig_chars'                 => 'Maximum Signature Length',
    '_admpmax_sig_charsexplain'          => 'Maximum Number of Characters Allowed in Users Signatures.',

    '_admpmax_sig_urls'                  => 'Maximum Signature Links',
    '_admpmax_sig_urlsexplain'           => 'Maximum Number of Links Allowed in Users Signatures. Set to 0 for Unlimited Links.',

    '_admpmax_sig_font_size'             => 'Maximum Signature Font Size',
    '_admpmax_sig_font_sizeexplain'      => 'Maximum Font Size Allowed in Users Signatures. Set to 0 for Unlimited Size.',

    '_admpmax_sig_smilies'               => 'Maximum smilies per signature',
    '_admpmax_sig_smiliesexplain'        => 'Maximum Smilies Allowed in Users Signatures. Set to 0 for Unlimited Smilies.',

    '_admpmax_sig_img_width'             => 'Maximum Signature Image Width',
    '_admpmax_sig_img_widthexplain'      => 'Maximum Width of an Image/Flash File in Users Signatures. Set to 0 for Unlimited Width.',

    '_admpmax_sig_img_height'            => 'Maximum Signature Image Height',
    '_admpmax_sig_img_heightexplain'     => 'Maximum Height of an Image/Flash File in Users Signatures. Set to 0 for Unlimited Height.',
    '_admpallow_magnet'					 => 'Allow eD2K/Magnet link\'s',
    '_admpallow_magnetexplain'			 => '',
    '_admpsourcedir'                     => 'Sources Directory',
    '_admpsourcedirexplain'              => 'Please give the Full Source Directory Path for System use.<br />DO NOT use / or ./',
    'ACP_ATTACHMENTS'                    => 'Attachments',
    'ACP_ATTACHMENT_SETTINGS'            => 'Attachment Settings',
    'ACP_BOARD_CONFIGURATION'            => 'Board Configuration',
    'ACP_EXTENSION_GROUPS'               => 'Manage Extension Groups',
    'ACP_MANAGE_EXTENSIONS'              => 'Manage Extensions',
    'ACP_ORPHAN_ATTACHMENTS'             => 'Orphaned Attachments',
    'YES_NO_NUM'                           => array('1' =>'Yes','0'   =>'No'),
));

?>