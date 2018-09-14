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
** File site_settings/english.php 2018-09-14 10:20:00 Thor
**
** CHANGES
**
** 2018-02-25 - Added New Masthead
** 2018-02-25 - Added New !defined('IN_PMBT')
** 2018-02-25 - Fixed Spelling
** 2018-04-12 - Amended the Wording of some Sentences
** 2018-04-12 - Amended !defined('IN_PMBT') Corrected Path
** 2018-04-15 - Amended !defined('IN_PMBT') New Version
** 2018-04-15 - Added Missing Languages
** 2018-07-29 - Add Language to drawRow
**/

if (!defined('IN_PMBT'))
{
    require_once($_SERVER['DOCUMENT_ROOT'].'/security.php');
    die ('Error 404 - Page Not Found');
}

if (empty($lang) || !is_array($lang))
{
    $lang = array();
}

$lang = array_merge($lang, array(
    'YES_NO_NUM' => array('1' => 'Yes',
                          '0' => 'No'),

    '_admsaved'            => 'Settings Saved!',
    '_admconfigttl'        => 'BTManager Configuration',

    '_admconfigttlexplain' => 'Here you can Setup the Basic Operation of your Tracker, Site Name and Description among other Settings where you can Adjust the Default Values for Themes and Languages.<br /><br />',

    'GENERAL_SETTINGS'     => 'General Settings',
    'GENERAL_OPTIONS'      => 'General Options',
    'EDIT_TIME_MINUTES'    => 'Minutes',

    #User
    '_admpallow_change_email'         => 'Allow email Change',

    '_admpallow_change_emailexplain'  => 'Allow Users to Change their email Address.<br />They will be sent an email which they Must Confirm for the Changes to Take Effect.',

    '_admpgive_sign_up_credit'        => 'Give Upload Credit on Signup',
    '_admpgive_sign_up_creditexplain' => 'Gives Users Upload Credit when they Signup to the Site.',

    '_admpoff_line_mess'        => 'Offline Message',
    '_admpoff_line_messexplain' => 'You can Enter a Short (255 Character) Message to Display if you wish.',

    '_admpannounce_url'        => 'Site Announce URL\'s',
    '_admpannounce_urlexplain' => 'Add the Announce URL\'s that will be used by the Site.<br />Enter each one on a <strong>Separate Line</strong>.',

    '_admpon_line'        => 'Site Online',
    '_admpon_lineexplain' => 'Set Site On/Offline.',

    '_admprecap_https'        => 'Use SSL for reCAPTCHA',
    '_admprecap_httpsexplain' => 'Should the Request be made over SSL?',

    '_admpPublic_Key'         => 'reCAPTCHA Public Key',

    '_admpPublic_Keyexplain'  => 'If You have a reCAPTCHA Account and a Public Key you need to Enter it Here.<br />Leave the Field Blank and the Site will use a Base64 CAPTCHA code.<br />For more info on reCAPTCHA visit here <strong><a href=\'http://www.google.com/recaptcha/learnmore\'>What is reCAPTCHA</a></strong>.',

    '_admpPrivate_Key'        => 'reCAPTCHA Private Key',
    '_admpPrivate_Keyexplain' => 'Add your reCAPTCHA Private Key Here.  Leave it Blank if you don\'t have one.',

    '_admptime_zone'        => 'Site Default Time Zone',

    '_admptime_zoneexplain' => 'Set the Default Time Zone for your Site.<br />To find out what Time Zone to use Click on the Links below.<br /><strong><a target=\'_blank\' href=\'http://www.php.net/manual/en/timezones.africa.php\'>Africa</a>, '.'<a target=\'_blank\' href=\'http://www.php.net/manual/en/timezones.america.php\'>America</a>, <a target=\'_blank\' href=\'http://www.php.net/manual/en/timezones.antarctica.php\'>Antarctica</a>, <a target=\'_blank\' href=\'http://www.php.net/manual/en/timezones.arctic.php\'>Arctic</a>, <a target=\'_blank\' href=\'http://www.php.net/manual/en/timezones.asia.php\'>Asia</a>, <a target=\'_blank\' href=\'http://www.php.net/manual/en/timezones.atlantic.php\'>Atlantic</a>, <a target=\'_blank\' href=\'http://www.php.net/manual/en/timezones.australia.php\'>Australia</a>, <a target=\'_blank\' href=\'http://www.php.net/manual/en/timezones.europe.php\'>Europe</a>, <a target=\'_blank\' href=\'http://www.php.net/manual/en/timezones.indian.php\'>Indian</a>, <a target=\'_blank\' href=\'http://www.php.net/manual/en/timezones.pacific.php\'>Pacific</a>, <a target=\'_blank\' href=\'http://www.php.net/manual/en/timezones.others.php\'>Others</a></strong>',

    '_admpconferm_email'        => 'Force email Confirmation',
    '_admpconferm_emailexplain' => 'Force a User to Confirm their email Address before they can use the Site.',

    #Torrents
    '_admpallow_multy_tracker'        => 'Allow Multi Tracker Torrents',
    '_admpallow_multy_trackerexplain' => 'Allow Users To Upload a Torrent with more than one Announce URL.',

    '_admpallow_external'        => 'Allow External Torrents',
    '_admpallow_externalexplain' => 'Allow Users to Upload Torrents from Other Sites.',

    '_admpauto_clean'        => 'Auto Clean Timer',
    '_admpauto_cleanexplain' => 'Sets the Time Intervals between Cleaning Sessions (in Seconds).',

    '_admppivate_mode'        => 'Private Tracker Mode',

    '_admppivate_modeexplain' => 'Sets the Tracker to Private, this way NO ONE can View the Content unless they are a Member.',

    '_admpaddprivate'        => 'Make ALL Local Torrents Private',

    '_admpaddprivateexplain' => 'Sets ALL Newly Uploaded Local Torrents as Private, if they were NOT done so already when the Uploader Created the Torrent.<br /><br /><strong>The Uploader will need to Download the Torrent from the Site in order to Seed the Torrent..</strong><br />Not All Torrent Client\'s recognise the Private Option.<br />Enabling the Private Option Disables DHT.',

    '_admpmax_members'          => 'Maximum Allowed Members',
    '_admpmax_membersexplain'   => 'Maximum Number of Members Allowed to Join your Site.',

    '_admpinvite_only'          => 'Invite Only',
    '_admpinvite_onlyexplain'   => 'Only Allows Users who have been Sent an Invite to Join.',

    '_admpforce_passkey'        => 'Force Passkey',
    '_admpforce_passkeyexplain' => 'Set this to Force your Members to use the Passkey System',

    '_admpinvites_open'         => 'Invite System',
    '_admpinvites_openexplain'  => 'Turns the Invite System On and Off.',

    '_admpupload_dead'          => 'Allow Dead External Torrents',

    '_admpupload_deadexplain'   => 'Use this to Allow for (apparently) Unseeded External Torrents to be Uploaded to Tracker.<br />This might be useful if the External Torrent Monitoring doesn\'t work so well, which depends on your Server Configuration.',

    '_admpsitename'        => 'Site Name',
    '_admpsitenameexplain' => 'The Name of your Site.  This will be Displayed as the Page Title.',

    '_admpsiteurl'         => 'Site URL',
    '_admpsiteurlexplain'  => 'URL of this Site.  This Must be Entered before using the Tracker.',

    '_admpcookiedomain'        => 'Cookie Domain',

    '_admpcookiedomainexplain' => 'Cookie Domain.  This Must be Set to the Domain Name of this Site (e.g. <strong>yoursite.com</strong>).  Required for User Login to Work.',

    '_admpcookiepath'          => 'Cookie Path',

    '_admpcookiepathexplain'   => 'Cookie Path.  Change this Setting <strong>ONLY</strong> if BTManager is Installed in a <strong>Sub-Directory</strong> on your Server.  If your Installation is in <strong>http://yoursite.com/btmanager</strong>, the Setting should be <strong>/btmanager</strong>',

    '_admpuse_gzip'        => 'Use gzip Compression',

    '_admpuse_gzipexplain' => 'This Option Allows you to Enable or Disable php\'s gzip Compression on HTML and Announce Output. If Enabled, Bandwidth Usage will be Lower <strong>but</strong> CPU Usage will be Higher.  This Setting doesn\'t work on ALL Servers.  If your Users Report any gzip Errors in their Clients, turn it Off.  Verify that your Tracker Reads the Announce Response Correctly.',

    '_admpadmin_email'        => 'Administrator email',

    '_admpadmin_emailexplain' => 'email Address from which ALL emails to Users will be Sent (Signup, PM Notifications, Authorisations, etc..).  Make sure that the email Address is Valid.',

    '_admplanguage'        => 'Default Language',
    '_admplanguageexplain' => 'Set the Default Language the Site will use.',

    '_admptheme'        => 'Theme',

    '_admpthemeexplain' => 'Set the Default Theme for the Site.  Registered Users can Override this Setting from the User Control Panel.',

    '_admpwelcome_message'        => 'Site News',

    '_admpwelcome_messageexplain' => 'Can be used to Post any News Items (e.g. Welcome Message, Donation Drive etc..).  This will be shown on the Site\'s Index Page.',

    '_admpannounce_text'        => 'Tracker Message',

    '_admpannounce_textexplain' => 'This Defines the Message that Users will see in their Torrent Client when they Connect to the Tracker.<br />Useful for Announcements and Publicity.',

    '_admpallow_html'        => 'Use HTML Editor',

    '_admpallow_htmlexplain' => 'Enable this Option to Allow Users to Write Torrent Descriptions using the embedded HTML Editor.  <br /><strong>WARNING</strong>: this Feature is still Experimental!',

    '_admprewrite_engine'        => 'Search Rewrite',

    '_admprewrite_engineexplain' => 'Search Rewrite transforms php\'s Complex URL\'s into Faux HTML Pages, making it easier to type into the Address Bar.  This Feature is also very useful to Increase Search Engine Traffic.<br />Apaches mod_rewrite or IIS\'s ISAPI_Rewrite is <strong>REQUIRED</strong> on your Server.',

    '_admptorrent_prefix'        => 'Torrent Prefix',

    '_admptorrent_prefixexplain' => 'This Option Allows you to Add a Custom Prefix to ALL Torrents Downloaded from this Tracker.  <br />Useful to Spread the Word about your Community.',

    '_admptorrent_per_page'        => 'Torrents Per Page',

    '_admptorrent_per_pageexplain' => 'Indicates how many Torrents can be Displayed on each page, both in Listing and in Search Mode.',

    '_admponlysearch'        => 'Search Only',

    '_admponlysearchexplain' => 'Hides the Torrent List so that Users without Administrator Access (whether Registered or NOT) will have to Perform a Search in order to View any Torrents.',

    '_admpmax_torrent_size'         => 'Maximum Torrent Size',

    '_admpmax_torrent_sizeexplain'  => 'Maximum Byte Size for Uploaded .torrent Files.<br />This DOES NOT put any Limits on the actual Torrent itself but ONLY on the size of the .torrent File itself.',

    '_admpannounce_interval'        => 'Announce Update Interval',

    '_admpannounce_intervalexplain' => 'Recommended Time Interval (in Seconds) between Announce Requests.<br />This Value is Sent to the Torrent Client.',

    '_admpannounce_interval_min'        => 'Minimum Announce Update Interval',

    '_admpannounce_interval_minexplain' => 'Recommended Time Interval between Announce Requests (in Seconds).<br /> More Frequent Requests will be Refused.',

    '_admpdead_torrent_interval'        => 'Dead Torrent Interval',

    '_admpdead_torrent_intervalexplain' => 'Specifies the Amount of Time (in Seconds) that a Dead Torrent (NO Peers) can be kept Visible on the Site, after which period they will Automatically be Hidden.',

    '_admpfree_dl'        => 'Turn Freeleech On or Off',

    '_admpfree_dlexplain' => 'Setting this to ON allows your Members to Download any Torrent on the Site without it effecting their Download Ratio.  Only their Upload Amount will be Recorded',

    '_admpwait_time'        => 'Add Wait Time',

    '_admpwait_timeexplain' => 'Setting this to ON Users who don\'t meet the below Criteria will have to Wait for a Set Amount of Time before their Downloads will Start.<br /><br /><strong>You Must Remember</strong><br />to Set the Announce Access Level to Users and the Torrents Must be Set to Private',

    '_admpGIGSA'         => 'For Members with Uploads (in GB) Less than',
    '_admpGIGSAexplain'  => 'Set the First Minimum Upload in GB for the First Wait Period before a User can Download a Torrent',

    '_admpGIGSB'         => 'For Members with Uploads (in GB) Less than',
    '_admpGIGSBexplain'  => 'Set the Second Minimum Upload in GB for the Second Wait Period before a User can Download a Torrent',

    '_admpGIGSC'         => 'For Members with Uploads (in GB) Less than',
    '_admpGIGSCexplain'  => 'Set the Third Minimum Upload in GB for the Third Wait Period before a User can Download a Torrent',

    '_admpGIGSD'         => 'For Members with Uploads (in GB) Less than',
    '_admpGIGSDexplain'  => 'Set the Fourth Minimum Upload in GB for the Fourth Wait Period before a User can Download a Torrent',

    '_admpRATIOA'        => 'For Member\'s with a Ratio Less than',
    '_admpRATIOAexplain' => 'Set the Fist Minimum Ratio a User must have before they can Download a Torrent',

    '_admpRATIOB'        => 'For Member\'s with a Ratio Less than',
    '_admpRATIOBexplain' => 'Set the Second Minimum Ratio a User must have before they can Download a Torrent',

    '_admpRATIOC'        => 'For Member\'s with a Ratio Less than',
    '_admpRATIOCexplain' => 'Set the Third Minimum Ratio a User must have before they can Download a Torrent',

    '_admpRATIOD'        => 'For Members with a Ratio Less than',
    '_admpRATIODexplain' => 'Set the Fourth Minimum Ratio a User must have before they can Download a Torrent',

    '_admpWAITA'         => 'Members must Wait \'x\' amount of Hours',
    '_admpWAITAexplain'  => 'Set the First Wait Period in Hours a User must Wait before they can Download a Torrent',

    '_admpWAITB'         => 'Members must Wait \'x\' amount of Hours',
    '_admpWAITBexplain'  => 'Set the Second Wait Period in Hours a User must Wait before they can Download a Torrent',

    '_admpWAITC'         => 'Members must Wait \'x\' amount of Hours',
    '_admpWAITCexplain'  => 'Set the Third Wait Period in Hours a User must Wait before they can Download a Torrent',

    '_admpWAITD'         => 'Members must Wait \'x\' amount of Hours',
    '_admpWAITDexplain'  => 'Set the Fourth Wait Period in Hours a User must Wait before they can Download a Torrent',

    '_admpminvotes'        => 'Minimum Votes',
    '_admpminvotesexplain' => 'Minimum Number of Votes Required to Display Torrent Ratings.',

    '_admptime_tracker_update'        => 'Autoscrape Time Interval',
    '_admptime_tracker_updateexplain' => 'Sets the Autoscrape Time Interval (in Seconds).',

    '_admpbest_limit'        => 'Best Torrent Peer Limit',
    '_admpbest_limitexplain' => 'Number of Total Peers above which the Torrent is Included in the Top Torrents List/RSS Feed.',

    '_admpdown_limit'        => 'Dead Torrent Peer Limit',
    '_admpdown_limitexplain' => 'Number of Total Peers below which the Torrent is Treated as Dead.',

    '_admptorrent_complaints'        => 'Torrent Complaints',

    '_admptorrent_complaintsexplain' => 'Allows Users to make a Complaint about a Torrent on the Details Page.  This Helps to Block Undesired Content, such as Child Pornography.  Any Torrent that receives 20 Complaints will Automatically be Banned.',

    '_admptorrent_global_privacy'    => 'Torrent Authorisations',

    '_admptorrent_global_privacyexplain' => 'Switching this ON Allows Registered Uploaders to put Limitations on Who can Download their Torrents.  The Owner of a Torrent can either Authorise Downloads on a Case-by-Case Basis, or Automatically by Setting an Overall Share Ratio that the Downloader has to meet.<br />You have to Set the Tracker Access Level to User in Order for this to Work.',

    '_admpdisclaimer_check'        => 'Disclaimer',

    '_admpdisclaimer_checkexplain' => 'If Checked, Users have to Accept a Disclaimer before they can Register.  You can Change the Disclaimer by Changing the File <strong>/disclaimer/english.php</strong>',

    '_admpgfx_check'        => 'CAPTCHA Setting',
    '_admpgfx_checkexplain' => 'If Checked, Users will have to Type in a Code from a CAPTCHA Image when Registering and Logging In.',

    '_admpupload_level'        => 'Upload Access Level',

    '_admpupload_levelexplain' => 'Determines the User Level Required to Upload Torrents<br /> &bull; <strong>Everyone</strong> Allows Anyone to Upload Torrent Files to the Site.  They wont be able to Edit them or Manage Authorisations<br /> &bull; <strong>Registered</strong> Requires Users to be Registered.<br /> &bull; <strong>Premium</strong> ONLY Allows Premium Users to Upload.',


    '_admplevelopt' => array('all'     => 'Everyone',
                             'user'    => 'Registered',
                             'premium' => 'Premium'),

    '_admpdownload_level'        => 'Download Access Level',

    '_admpdownload_levelexplain' => 'Determines the User Level Required to Download Torrents.<ul><li><strong>Everyone</strong> Allows Anyone to Download Torrent Files from the Site<li><strong>Registered</strong> Requires Users to be Registered<li><strong>Premium</strong> ONLY Allows Premium Users to Download Torrents from the Site</ul>This Setting DOES NOT affect the Tracker.  So if somebody got their hands on a .torrent, they would be able to Download.',

    '_admpannounce_level'        => 'Tracker Access Level',

    '_admpannounce_levelexplain' => '<ul><li><strong>Everyone</strong> Allows Anyone to Connect to the Tracker (i.e. Announce)<li><strong>Registered</strong> Requires the User to Log In (IP Address is Checked!) before Connecting to the Tracker.  </ul>This Setting DOES NOT Affect Torrents Downloaded from the Site.',

    '_admpannounce_levelopt' => array('all'  => 'Everyone',
                                      'user' => 'Registered'),

    '_admpmax_num_file'        => 'Maximum Amount of Files in a Torrent',

    '_admpmax_num_fileexplain' => 'Maximum Number of Files a Torrent can contain, any amount above this will cause the Upload to Fail.<br />Use it if you\'d like to encourage Users to use Compressed Archives.<br />Setting this to Zero will Disable this Option.',

    '_admpmax_share_size'        => 'Maximum Torrent Share Size',

    '_admpmax_share_sizeexplain' => 'Total Combined Size of Files in a Torrent, any amount above this will cause the Upload to Fail.<br />Setting this to Zero will Disable this Option.',

    '_admpglobal_min_ratio'        => 'Global Minimum Ratio',

    '_admpglobal_min_ratioexplain' => 'Specify the Minimum Upload/Download Ratio.<br />Users will NOT be Allowed to Download any more Torrents if they don\'t meet this criteria.<br />The Option is applicable ONLY if the Announce Level (above) is Set to User on the Download Page.<br />Setting this to Zero will Disable this Option.',

    '_admpautoscrape'        => 'External Torrent Monitoring',

    '_admpautoscrapeexplain' => 'This Allows you to Monitor the Peer Count for Torrents Tracked by Remote Trackers.<br />Be careful here.<br /><br />You can ONLY use this if your Server can Open Sockets to Other Machines.  Many Cheap or Free Hosting Services have Firewalls that Block Outgoing Connections.  If you\'re NOT using a Dedicated/Home Server, it is recommended that you DO NOT Enable this Option unless you\'re sure you know what you\'re doing.<br /><br />If you don\'t Enable it ALL External Torrents will be Displayed as having Zero Sources.<br /><br />If you Enable it, but your Server can\'t Build Connections to Scrape External Uploads may be Rejected (unless you Check Allow Dead External Torrents)',

    '_admpmax_num_file_day_e'        => 'Maximum Number of Daily Downloads',

    '_admpmax_num_file_day_eexplain' => 'Defines how many Files can be Downloaded Per Day by a Single User.  Any Requests above this will be Refused and the User will be asked to try again the following Day.<br />Premium Users are NOT affected by this Setting.  Setting this to Zero will Disable this Option.',

    '_admpmax_num_file_week_e'        => 'Maximum Number of Weekly Downloads',

    '_admpmax_num_file_week_eexplain' => 'Defines how many Files can be Downloaded in a Week by a Single User.  Further Requests will be Refused and the User will be asked to try again the following Week.<br />Premium Users are Not affected by this Setting.  Setting this to Zero will Disable this Option.',

    '_admpmin_num_seed_e'        => 'Minimum Seed Number for New Downloads',

    '_admpmin_num_seed_eexplain' => 'Defines how many Torrents a User must be Seeding before Downloading any New Files.<br />Premium Users are NOT affected by this Setting.<br />Setting this to Zero will Disable this Option.',

    '_admpmin_size_seed_e'        => 'Minimum Seed Size for New Downloads',

    '_admpmin_size_seed_eexplain' => 'Defines the Minimum Share Ratio a User must have before Downloading New Files.<br />Premium Users are NOT affected by this setting.<br />Setting this to Zero will Disable this Option.',

    '_admpminupload_size_file'        => 'Minimum File Size for New Torrents',

    '_admpminupload_size_fileexplain' => 'Defines the Minimum File Size a Torrent can be.<br />Premium Users are NOT affected by this Setting.<br />Setting this to Zero will Disable this Option.',

    '_admpmaxupload_day_num'        => 'Maximum Daily Uploads',

    '_admpmaxupload_day_numexplain' => 'Defines how many Torrents can be Uploaded in a Single Day.  Any Uploads above this will NOT be accepted and the User will be asked to try again the following Day.<br />Premium Users are NOT affected by this Setting.  Setting this to Zero will Disable this Option.',

    '_admpmaxupload_day_share'        => 'Maximum Daily Upload',

    '_admpmaxupload_day_shareexplain' => 'Defines the Maximum Total Size of Files (ALL Files within a Torrent Combined) a User can Upload in a Single Day.  Any further Uploads will NOT be Accepted and the User will be asked to try again the following Day.<br />Premium Users are NOT affected by this Setting.  Setting this to Zero will Disable this Option.',

    '_admpminupload_file_size'        => 'Minimum Torrent Size for Uploads',

    '_admpminupload_file_sizeexplain' => 'Defines the Torrent\'s Minimum Size (ALL Files within a Torrent Combined) for Upload.<br />Premium Users are NOT affected by this Setting.  Setting this to Zero will Disable this Option.',

    '_admpallow_backup_tracker'        => 'Backup Tracker',

    '_admpallow_backup_trackerexplain' => 'Runs your Tracker as a Backup Tracker according to the BitTorrent\'s Announce List extension.<br />Usage is subject to the Announce Level Settings and DOES NOT affect Ratios.<br />This Option is Ignored if Stealth Mode is Enabled.',

    '_admpstealthmode'        => 'Disable Local Tracker',

    '_admpstealthmodeexplain' => 'This will Disable and Hide the Local Tracker.  BTManager will ONLY accept Externally Tracked Torrents.',

    'SITE_SETTINGS'        => 'Board Configuration',
    'MENU_PRIVATE_MESSAGE' => 'Private Message Settings',
    'MENU_BBCODE'          => 'BBcode Settings',
    'TRACKER_SETTINGS'     => 'Tracker Settings',
    'USER_SETTINGS'        => 'User Settings',
    'UPLOAD_SETTINGS'      => 'Torrent Upload Settings',
    'EXT_TORRENT_SETTINGS' => 'External Torrent Upload Settings',

    #Advanced Settings PM
    'PMFULLOPTION' => array('1' => 'Delete Oldest Messages',
                            '2' => 'New Messages will be Held Back'),

    '_admpallow_privmsg'          => 'Private Messaging',
    '_admpallow_privmsgexplain'   => 'Enable or Disable Private Messaging for ALL Users.',
    '_admpallow_pm_attach'        => 'Allow Attachments in Private Messages',
    '_admpallow_pm_attachexplain' => 'Enable or Disable Allowing Attachments in Private Messaging for ALL Users.',

    '_admppm_max_boxes'        => 'Maximum Private Message Folders',
    '_admppm_max_boxesexplain' => 'By Default Users may Create this many Personal Folders for Private Messages.',

    '_admppm_max_msgs'         => 'Maximum Private Messages Per Box',

    '_admppm_max_msgsexplain'  => 'Users can\'t Receive any more than this many Messages in each of their Private Message Boxes.  Set this Value to Zero to Allow Unlimited Messages.',

    '_admpfull_folder_action'        => 'Full Folder Default Action',

    '_admpfull_folder_actionexplain' => 'Default Action to take if a Users Folder is Full, assuming the Users Folder Action is Set at ALL, this is NOT applicable.  The Only exception is for the Sent Messages Folder where the Default Action is always to Delete Old Messages.',

    '_admppm_edit_time'        => 'Limit Editing Time',

    '_admppm_edit_timeexplain' => 'Limits the Time Available to Edit a Private Message that has NOT already been Delivered.  Setting the Value to Zero Disables this Option.',

    '_admpallow_mass_pm'             => 'Allow Sending of Private Messages to Multiple Users and Groups',
    '_admpallow_mass_pmexplain'      => 'Allow Users to Send Private Messages to Multiple Users and Groups',

    '_admpauth_bbcode_pm'            => 'Allow BBCode in Private Messages',
    '_admpauth_bbcode_pmexplain'     => 'Allow Users to use BBCode in Private Messages',

    '_admpauth_smilies_pm'           => 'Allow Smilies in Private Messages',
    '_admpauth_smilies_pmexplain'    => 'Allow Users to use Smilies in Private Messages',

    '_admpallow_sig_pm'              => 'Allow Signature in Private Messages',
    '_admpallow_sig_pmexplain'       => 'Allow Users to use Signatures in Private Messages',

    '_admpprint_pm'                  => 'Allow Print View in Private Messaging',
    '_admpprint_pmexplain'           => 'Allow Users to use the Print View in Private Messaging',

    '_admpforward_pm'                => 'Allow Forwarding of Private Messages',
    '_admpforward_pmexplain'         => 'Allow Users to Forward Private Messages',

    '_admpauth_img_pm'               => 'Allow the use of <em>[IMG]</em> BBCode Tags',
    '_admpauth_img_pmexplain'        => 'Allow Users to use the <em>[IMG]</em> Tag in Private Messages',

    '_admpauth_flash_pm'             => 'Allow the use of <em>[FLASH]</em> BBCode Tags',
    '_admpauth_flash_pmexplain'      => 'Allow Users to use the <em>[FLASH]</em> BBCode Tag in Private Messages',

    '_admpenable_pm_icons'           => 'Enable Topic Icons in Private Messages',
    '_admpenable_pm_iconsexplain'    => 'Allow Users to use Topic Icons in Private Messages',

    '_admpallow_sig'                 => 'Allow Signatures',
    '_admpallow_sigexplain'          => 'Allow Users to use Signatures',

    '_admpallow_sig_bbcode'          => 'Allow BBCode in Users Signatures',
    '_admpallow_sig_bbcodeexplain'   => 'Allow Users to use BBCode in their Signatures',

    '_admpallow_sig_img'             => 'Allow the use of <em>[IMG]</em> BBCode Tag in Users Signatures',
    '_admpallow_sig_imgexplain'      => 'Allow Users to use the <em>[IMG]</em> Tag in User Signatures',

    '_admpallow_sig_flash'           => 'Allow the use of <em>[FLASH]</em> BBCode Tag in User Signatures',
    '_admpallow_sig_flashexplain'    => 'Allow Users to use the <em>[FLASH]</em> BBCode Tag in Users Signatures',

    '_admpallow_sig_smilies'         => 'Allow Smilies in Users Signatures',
    '_admpallow_sig_smiliesexplain'  => 'Allow Users to use Smilies in their Signature',

    '_admpallow_sig_links'           => 'Allow Links in Users Signatures',
    '_admpallow_sig_linksexplain'    => 'Allow Users to use Links in their Signatures',

    '_admpmax_sig_chars'             => 'Maximum Signature Length',
    '_admpmax_sig_charsexplain'      => 'Maximum Number of Characters Allowed in Users Signatures.',

    '_admpmax_sig_urls'              => 'Maximum Signature Links',
    '_admpmax_sig_urlsexplain'       => 'Maximum Number of Links Allowed in Users Signatures.  Set to Zero for Unlimited Links.',

    '_admpmax_sig_font_size'         => 'Maximum Signature Font Size',
    '_admpmax_sig_font_sizeexplain'  => 'Maximum Font Size Allowed in Users Signatures.  Set to Zero for Unlimited Size.',

    '_admpmax_sig_smilies'           => 'Maximum smilies per signature',
    '_admpmax_sig_smiliesexplain'    => 'Maximum Smilies Allowed in Users Signatures.  Set to Zero for Unlimited Smilies.',

    '_admpmax_sig_img_width'         => 'Maximum Signature Image Width',
    '_admpmax_sig_img_widthexplain'  => 'Maximum Width of an Image/Flash File in Users Signatures.  Set to Zero for Unlimited Width.',

    '_admpmax_sig_img_height'        => 'Maximum Signature Image Height',

    '_admpmax_sig_img_heightexplain' => 'Maximum Height of an Image/Flash File in Users Signatures.  Set to Zero for Unlimited Height.',

    '_admpallow_magnet'        => 'Allow eD2K/Magnet Link\'s',
    '_admpallow_magnetexplain' => 'Allow the use of eD2K/Magnet Link\'s',
    '_admpsourcedir'           => 'Sources Directory',

    '_admpsourcedirexplain'    => 'Please give the Full Source Directory Path for System use.<br /><strong>DO NOT</strong> use <strong>/</strong> or <strong>./</strong>',

    'ACP_ATTACHMENTS'          => 'Attachments',
    'ACP_ATTACHMENT_SETTINGS'  => 'Attachment Settings',
    'ACP_BOARD_CONFIGURATION'  => 'Board Configuration',
    'ACP_EXTENSION_GROUPS'     => 'Manage Extension Groups',
    'ACP_MANAGE_EXTENSIONS'    => 'Manage Extensions',
    'ACP_ORPHAN_ATTACHMENTS'   => 'Orphaned Attachments',

    #ADDON 3.0.1
    '_admpannounce_ments'           => 'Announcement\'s',

    '_admpannounce_mentsexplain'    => 'Used for making Site Announcements.<br />These Announcements will be seen by Users in their User - Profile - Edit Section.',

    '_admppm_max_recipients'        => 'Maximum Number of Allowed Recipients',

    '_admppm_max_recipientsexplain' => 'The Maximum Number of Allowed Recipients in a Private Message.  If 0 is Entered, an Unlimited Number is Allowed.  This Setting can be Adjusted for every Group within the Group Settings Page.',

    'PM_SETTING_TITLE_EXPLAIN'      => 'Here you can Set ALL Default Settings for Private Messaging.<br /><br />',
    'PM_SETTING_TITLE'              => 'Private Message Settings',
));

?>