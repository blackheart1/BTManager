<?php
/**
*
* ucp [English]
*
* @package language
* @version $Id$
* @copyright (c) 2005 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}
$lang = array_merge($lang, array(
	'_admsaved'	=> 'Settings saved!',
"_admconfigttl"							=> "BT.Manager Configuration",
"_admconfigttlexplain"					=> "Here you can determine the basic operation of your Tracker, give it a fitting name and description, and among other settings adjust the default values for theme and language.",
#user
"_admpallow_change_email"				=> "Allow e-mail change",
"_admpallow_change_emailexplain"		=> "Allow users to change there e-mail. <br />They well be sent a e-mail comfirmation for the change to take effect.",

"_admpgive_sign_up_credit"				=> "Give Upload on signup",
"_admpgive_sign_up_creditexplain"		=> "Give users Upload win the sign up to the site.",

"_admpoff_line_mess"				=> "Off line message",
"_admpoff_line_messexplain"		=> "You can enter a short (255 character) message to display if you wish.",

"_admpannounce_url"				=> "Site Announce URL's",
"_admpannounce_urlexplain"		=> "Add the Announce URL's that well be used by the site.<br>Put each one on a new line.",

"_admpon_line"				=> "Site on line",
"_admpon_lineexplain"		=> "Set site on/off Line.",

"_admprecap_https"						=> "Use SSL for reCAPTCHA",
"_admprecap_httpsexplain"				=> "Should the request be made over ssl?",


"_admpPublic_Key"						=> "reCAPTCHA Publick Key",
"_admpPublic_Keyexplain"				=> "If You have a reCAPTCHA account and a Puplic key you can use it here.<br />Leave field blank and site well use a base 64 captcha code.<br />for more info on reCAPTCHA visit here <a href=\"http://www.google.com/recaptcha/learnmore\">WHAT IS reCAPTCHA</a>.",


"_admpPrivate_Key"						=> "reCAPTCHA Private Key",
"_admpPrivate_Keyexplain"				=> "Add your reCAPTCHA Private Key here Leave it blank if you dont have one.",


"_admptime_zone"		=> "Site Default Time Zone",
"_admptime_zoneexplain"		=> "Set the Default Time zone for your Site.<br />To Find out what time zone to use you can Find it<br /> <a target=\"_blank\" href=\"http://www.php.net/manual/en/timezones.africa.php\">Africa</a>, ".'<a target="_blank" href="http://www.php.net/manual/en/timezones.america.php">America</a>, <a target="_blank" href="http://www.php.net/manual/en/timezones.antarctica.php">Antarctica</a>, <a target="_blank" href="http://www.php.net/manual/en/timezones.arctic.php">Arctic</a>, <a target="_blank" href="http://www.php.net/manual/en/timezones.asia.php">Asia</a>, <a target="_blank" href="http://www.php.net/manual/en/timezones.atlantic.php">Atlantic</a>, <a target="_blank" href="http://www.php.net/manual/en/timezones.australia.php">Australia</a>, <a target="_blank" href="http://www.php.net/manual/en/timezones.europe.php">Europe</a>, <a target="_blank" href="http://www.php.net/manual/en/timezones.indian.php">Indian</a>, <a target="_blank" href="http://www.php.net/manual/en/timezones.pacific.php">Pacific</a>, <a target="_blank" href="http://www.php.net/manual/en/timezones.others.php">Others</a>',


"_admpconferm_email"		=> "Force E-mail comfirmation",
"_admpconferm_emailexplain"		=> "Force a user to confirm ther e-mail Before they can use the site.",

#torrents
"_admpallow_multy_tracker"		=> "Allow Multi Tracker Torrents",
"_admpallow_multy_trackerexplain"		=> "Allow Users To Upload A Torrent with More then One announce.",

"_admpallow_external"		=> "Allow External Torrents",
"_admpallow_externalexplain"		=> "Allow Users to Upload Torrents From Other Sites.",


"_admpauto_clean"		=> "Auto Clean Timer",
"_admpauto_cleanexplain"		=> "Sets the time intervals Of the clean sessions. For like with the bonus system.",

"_admppivate_mode"		=> "Private Tracker Mode",
"_admppivate_modeexplain"		=> "Sets tracker to private and no one can see the content inless they are a member and are logged in.",

"_admpaddprivate"		=> "Make all local Torrents Private",
"_admpaddprivateexplain"		=> "Sets all newly uploaded local torrents as private if they have not been done so.<br /><b>The uploader well need to download the torrent from the site once this is active.</b><br /><br />The (private)-option (which only some clients can handle), tells the client to deal only with peers it receives from the central tracker. Enabling the Private option disables DHT",

"_admpmax_members"		=> "Max allowed Members",
"_admpmax_membersexplain"		=> "Max number of members allowed to join your site.",

"_admpinvite_only"		=> "Inite Only",
"_admpinvite_onlyexplain"		=> "Only allows for users to join if they have been invited.",

"_admpforce_passkey"		=> "Force Passkey",
"_admpforce_passkeyexplain"		=> "Set this to force your members to use Passkey system",

"_admpinvites_open"		=> "Invite system",
"_admpinvites_openexplain"		=> "turn on and off the invite system.",

"_admpupload_dead"		=> "Allow 'dead' External Torrents",
"_admpupload_deadexplain"		=> "Use this to allow for (apparently) un-seeded external torrents to be uploaded to tracker. Might be usefull if the external torrent monitoring doesn't work so well, which depends on your server configuration.",

"_admpsitename"		=> "Site Name",
"_admpsitenameexplain"		=> "The name of your site. Will be displayed as the page title.",

"_admpsiteurl"		=> "Site URL",
"_admpsiteurlexplain"		=> "URL of this site. Must be entered for using the tracker.",

"_admpcookiedomain"		=> "Cookie Domain",
"_admpcookiedomainexplain"		=> "Cookie domain. Must be set to the domain name of this site (e.g. yoursite.com). Required for user login to work.",

"_admpcookiepath"		=> "Cookie Path",
"_admpcookiepathexplain"		=> "Cookie Path. Change this setting <b>only</b> if BT.Manager is installed in a subdirectory of your server. If your installation is in http://yoursite.com/btmanager, the setting should be /btmanager",

"_admpuse_gzip"		=> "Use GZIP compression",
"_admpuse_gzipexplain"		=> "This option allows you to enable or disable PHP's GZIP compression on HTML and Announce output. If enabled, bandwidth usage will be lower but CPU usage will be higher. This setting doesn't work fine on all servers; if your users report any Gzip errors in their clients, turn it off. Verify that your tracker reads the Announce response correctly.",

"_admpadmin_email"		=> "Administrator E-Mail",
"_admpadmin_emailexplain"		=> "E-Mail Address from which all emails to users will be sent (signup,pm notifications, authorizations, etc.). It may be a good idea to enter a valid address.",

"_admplanguage"		=> "Default Language",
"_admplanguageexplain"		=> "Specifies the default language to use.",

"_admptheme"		=> "Theme",
"_admpthemeexplain"		=> "Set the default theme for this site. Registered users can override this setting from the panel.",

"_admpwelcome_message"		=> "Site News",
"_admpwelcome_messageexplain"		=> "Anything you enter here will appear in a box on top of the torrent index. Leave the field blank to make the box disappear altogether.",

"_admpannounce_text"		=> "Tracker Message",
"_admpannounce_textexplain"		=> "This defines the message that users see on their BitTorrent Client when they connect to the Tracker. Useful for announcements and publicity.",

"_admpallow_html"		=> "Use HTML Editor",
"_admpallow_htmlexplain"		=> "Enable this option to allow users to write Torrent Descriptions using the embedded HTML-editor. <br /><b>WARNING</b>: this feature is still experimental!",

"_admprewrite_engine"		=> "SearchRewrite",
"_admprewrite_engineexplain"		=> "SearchRewrite transforms PHP's complex URLs into faux HTML pages, easier to type into the address bar. This feature is also very useful to increase search engine traffic. Apache's mod_rewrite or IIS's ISAPI_Rewrite are REQUIRED on your server.",

"_admptorrent_prefix"		=> "Torrent Prefix",
"_admptorrent_prefixexplain"		=> "This option allows you to add a custom prefix to all Torrents downloaded from this tracker. Useful to spread the word about your community.",

"_admptorrent_per_page"		=> "Torrents per page",
"_admptorrent_per_pageexplain"		=> "Indicates how many Torrents can be displayed each page, both in listing and in search mode.",


"_admponlysearch"		=> "Search Only",
"_admponlysearchexplain"		=> "Hide Torrent List to non-Admins. Users (whether registered or not) have to perform a search to get to any torrents.",

"_admpmax_torrent_size"		=> "Maximum Torrent Size",
"_admpmax_torrent_sizeexplain"		=> "Maximum byte size for uploaded .torrent files. This does NOT put any limit to the size of the actual size of any files shared with the .torrent!",

"_admpannounce_interval"		=> "Announce Update Interval",
"_admpannounce_intervalexplain"		=> "Recommended time interval (seconds) between Announce request. This value is sent to the client.",

"_admpannounce_interval_min"		=> "Minimum Announce Update Interval",
"_admpannounce_interval_minexplain"		=> "Recommended time interval between Announce requests. More frequent requests will be refused.",

"_admpdead_torrent_interval"		=> "Dead Torrent Interval",
"_admpdead_torrent_intervalexplain"		=> "Specifies the amount of time (in seconds) that a dead Torrent (no peers) can be kept visible in the tracker. After that period, it will be automatically hidden.",

"_admpfree_dl"		=> "Free Torrent DownLoads",
"_admpfree_dlexplain"		=> "Give Members Free downloads. None of the downloads well be recorded during the time that this is seleted only ther upload",

////////wait
"_admpwait_time"		=> "Add Wait Time",
"_admpwait_timeexplain"		=> "When You set this users with a set cryterea well have to wait for a set amount of time before there downloads well start. <br /><br /><b>You must remember</b><br />To set the anounce access level to users and the torrents well need to be set to Private",

"_admpGIGSA"		=> "For Member With Uploads (IN GIGS) less then",
"_admpGIGSAexplain"		=> "Set the first min upload In Gigs for the first wait period",

"_admpGIGSB"		=> "For Member With Uploads (IN GIGS) less then",
"_admpGIGSBexplain"		=> "Set the second min upload In Gigs for the first wait period",

"_admpGIGSC"		=> "For Member With Uploads (IN GIGS) less then",
"_admpGIGSCexplain"		=> "Set the third min upload In Gigs for the first wait period",

"_admpGIGSD"		=> "For Member With Uploads (IN GIGS) less then",
"_admpGIGSDexplain"		=> "Set the fourth min upload In Gigs for the first wait period",

"_admpRATIOA"		=> "For Member With a ratio less then",
"_admpRATIOAexplain"		=> "Set the fist min ratio",

"_admpRATIOB"		=> "For Member With a ratio less then",
"_admpRATIOBexplain"		=> "Set the second min ratio",

"_admpRATIOC"		=> "For Member With a ratio less then",
"_admpRATIOCexplain"		=> "Set the third min ratio",

"_admpRATIOD"		=> "For Member With a ratio less then",
"_admpRATIODexplain"		=> "Set the fourth min ratio",

"_admpWAITA"		=> "Must Wait for this many hours",
"_admpWAITAexplain"		=> "Set the first wait period in hours",

"_admpWAITB"		=> "Must Wait for this many hours",
"_admpWAITBexplain"		=> "Set the second wait period in hours",

"_admpWAITC"		=> "Must Wait for this many hours",
"_admpWAITCexplain"		=> "Set the third wait period in hours",

"_admpWAITD"		=> "Must Wait for this many hours",
"_admpWAITDexplain"		=> "Set the fourth wait period in hours",
///wait end
"_admpminvotes"							=> "Minimum votes",
"_admpminvotesexplain"					=> "Minimum number of votes to display a Torrent rating at all.",

"_admptime_tracker_update"				=> "Autoscrape Interval",
"_admptime_tracker_updateexplain"		=> "Autoscrape Interval",

"_admpbest_limit"						=> "Best Torrent Peer Limit",
"_admpbest_limitexplain"				=> "Number of total peers above which the Torrent is included in the Top Torrents List/RSS feed.",

"_admpdown_limit"						=> "Dead Torrent Peer Limit",
"_admpdown_limitexplain"				=> "Number of total peers below which the Torrent is treated as Dead.",

"_admptorrent_complaints"				=> "Torrent Complaints",
"_admptorrent_complaintsexplain"		=> "Allows users to complain about a  torrent in its details page, in an attempt to to block undesired content, such as child pornography. Torrent that get a certain number of complaints are automatically banned.",

"_admptorrent_global_privacy"			=> "Torrent Authorizations",
"_admptorrent_global_privacyexplain"	=> "Switching this on allows registered uploaders to put limitations on who can download their torrents. The owner of a torrent can either authorize downloads on a case-to case basis, or automatically, by setting a overall share ratio that the downloader has to meet. You have to set the Tracker Access Level to 'User' in order for this to work.",

"_admpdisclaimer_check"					=> "Disclaimer",
"_admpdisclaimer_checkexplain"			=> "If checked, users have to accept a disclaimer before they register. You can change the disclaimer by changing the file /disclaimer/english.php.",

"_admpgfx_check"						=> "Captcha Test",
"_admpgfx_checkexplain"					=> "If checked, users have to type in a code from a captcha image when registering and logging in.",

"_admpupload_level"						=> "Upload access level",
"_admpupload_levelexplain"				=> "Determines the user level required for the permission to upload torrents<ul><li><b>'Everyone'</b> allows anyone to upload Torrent files to this site. They won't be able to edit them or manage authorizations<li><b>'Registered'</b> requires uploaders to be registered. <b>'Premium'</b> only allows Premium users to upload.<li></ul>",
"_admplevelopt"							=> array("all"=>"Everyone", "user"=>"Registered", "premium"=>"Premium"),
"_admpdownload_level"					=> "Download access level",
"_admpdownload_levelexplain"			=> "<ul><li><b>'Everyone'</b> allows anyone to download Torrent files from this site<li><b>'Registered'</b> requires registration<li><b>'Premium'</b> allows only Premium users to download a .torrent from this site</ul>This setting does not affect the tracker. So if somebody got their hands on a .torrent, they can download.",

"_admpannounce_level"					=> "Tracker access level",
"_admpannounce_levelexplain"			=> "<ul><li><b>'Everyone'</b> allows anyone to connect to the tracker (i.e. announce) <li><b>'Registered'</b> requires the user to log in (IP address is checked!) before connecting to the tracker</ul>This setting does not affect Torrent download from site.",
"_admpannounce_levelopt"				=> array("all"=>"Everyone", "user"=>"Registered"),

"_admpmax_num_file"						=> "Maximum Torrent file number",
"_admpmax_num_fileexplain"				=> "Maximum number a torrent can contain, above which it won't be accepted for upload. Use it if you'd like to encourage people to use compressed archives. Setting to zero will just ignore the parameter.",

"_admpmax_share_size"					=> "Maximum Torrent Share Size",
"_admpmax_share_sizeexplain"			=> "Total combined size of files in a torrent, above which the upload won't be accepted. Setting this to zero will just ignore the parameter.",

"_admpglobal_min_ratio"					=> "Global Minimum Ratio",
"_admpglobal_min_ratioexplain"			=> "Specify a minimum upload/download ratio, below which a user will not be allowed to download any more torrents. The option is applicable only if the Announce Level (above) is set to 'User' of the download page. Setting zero will disable the option.",

"_admpautoscrape"						=> "External Torrent Monitoring",
"_admpautoscrapeexplain"				=> "This allows you to monitor the peer count for torrents tracked by remote trackers.<br>Be careful here.<br>You can use this ONLY if your server can open sockets to any other machines. Many cheap or free hosting services have firewalls that block outgoing connections. If you're not using a Dedicated/Home Server, it is recommended that you DO NOT enable this option unless you're sure what you're doing.<br>If you don't enable it all external torrents will be displayed having zero sources. If you enable it, but your server can't build connections to scrape, external uploads may be rejected (unless you check 'Allow dead External Torrents'",

"_admpmax_num_file_day_e"				=> "Maximum number of daily downloads",
"_admpmax_num_file_day_eexplain"		=> "Defines how many files can be downloaded per day by a single user. Any requests abov that will be refused and the user will be asked to try again the next day.<br>Premium users are not affected by this setting. Setting this option to zero will disable it.",

"_admpmax_num_file_week_e"				=> "Maximum number of weekly downloads",
"_admpmax_num_file_week_eexplain"		=> "Defines how many files can be downloaded in a week's time by a single user. Further requests will be refused and the user will be asked to try again the next week.<br>Premium users are not affected by this setting. Setting this option to zero will disable it.",

"_admpmin_num_seed_e"					=> "Minimum seed number for new downloads",
"_admpmin_num_seed_eexplain"			=> "Defines how many Torrents the user must be seeding before downloading new files.<br>Premium users are not affected by this setting. Setting this option to zero will disable it.",

"_admpmin_size_seed_e"					=> "Minimum seed size for new downloads",
"_admpmin_size_seed_eexplain"			=> "Defines how much share the user must be seeding before downloading new files.<br>Premium users are not affected by this setting. Setting this option to zero will disable it.",

"_admpminupload_size_file"				=> "Minimum file size for new Torrents",
"_admpminupload_size_fileexplain"		=> "Defines The Minimum size a torrent file can be.<br>Premium users are not affected by this setting. Setting this option to zero will disable it.",

"_admpmaxupload_day_num"				=> "Maximum daily uploads",
"_admpmaxupload_day_numexplain"			=> "Defines how many Torrents can be uploaded in a single day. Any uploads above that won't be accepted and the user will be asked to try again the next day.<br>Premium users are not affected by this setting. Setting this option to zero will disable it.",

"_admpmaxupload_day_share"				=> "Maximum Daily upload",
"_admpmaxupload_day_shareexplain"		=> "Defines the maximum total size of files (all files within a torrent combined) a user can upload in a single day. Any further uploads won't be accepted and the user will be asked to try again the next day.<br>Premium users are not affected by this setting. Setting this option to zero will disable it.",

"_admpminupload_file_size"				=> "Minimum Torrent size for upload",
"_admpminupload_file_sizeexplain"		=> "Defines Torrent's minimum size (all files within a torrent combined) for upload.<br>Premium users are not affected by this setting. Setting this option to zero will disable it.",

"_admpallow_backup_tracker"				=> "Backup Tracker",
"_admpallow_backup_trackerexplain"		=> "Runs your tracker as a Backup Tracker according to the BitTorrent's Announce-List extension. Usage is subject to Announce level settings and does not affect ratios. This option is ignored if Stealth Mode is enabled.",

"_admpstealthmode"						=> "Disable Local Tracker",
"_admpstealthmodeexplain"				=> "This will disable and hide the local tracker. BT.Manager will only accept externally tracked torrents.",
'SITE_SETTINGS'							=>	'Board configuration',
'MENU_PRIVATE_MESSAGE'					=>	'Private message settings',
'MENU_BBCODE'							=>	'BBcode settings',

#advanced settings PM
'PMFULLOPTION'							=> array('1'=>'Delete oldest messages','2'=>'New messages will be held back'),
"_admpallow_privmsg"					=> "Private messaging",
"_admpallow_privmsgexplain"				=> "Enable or disable private messaging for all users.",
"_admpallow_pm_attach"					=> "Allow attachments in private messages",
"_admpallow_pm_attachexplain"			=> "",
     
'_admppm_max_boxes'						=>	'Maximum private message folders',
'_admppm_max_boxesexplain'				=>	'By default users may create this many personal folders for private messages.',

'_admppm_max_msgs'						=>	'Maximum private messages per box',
'_admppm_max_msgsexplain'				=>	'Users may receive no more than this many messages in each of their private message boxes. Set this value to 0 to allow unlimited messages.',

'_admpfull_folder_action'				=>	'Full folder default action',
'_admpfull_folder_actionexplain'		=>	'Default action to take if a user�s folder is full assuming the user�s folder action, if set at all, is not applicable. The only exception is for the �Sent messages� folder where the default action is always to delete old messages.',

'_admppm_edit_time'						=>	'Limit editing time',
'_admppm_edit_timeexplain'				=>	'Limits the time available to edit a private message not already delivered. Setting the value to 0 disables this behaviour',


'_admpallow_mass_pm'					=> "Allow sending of private messages to multiple users and groups",
'_admpallow_mass_pmexplain'				=> "",

'_admpauth_bbcode_pm'					=> "Allow BBCode in private messages",
'_admpauth_bbcode_pmexplain'			=> "",

'_admpauth_smilies_pm'					=> "Allow smilies in private messages",
'_admpauth_smilies_pmexplain'			=> "",


'_admpallow_sig_pm'						=> "Allow signature in private messages",
'_admpallow_sig_pmexplain'				=> "",

'_admpprint_pm'							=> "Allow print view in private messaging",
'_admpprint_pmexplain'					=> "",

'_admpforward_pm'						=> "Allow forwarding of private messages",
'_admpforward_pmexplain'				=> "",

'_admpauth_img_pm'						=> "Allow use of <code>[IMG]</code> BBCode tag",
'_admpauth_img_pmexplain'				=> "",

'_admpauth_flash_pm'					=> "Allow use of <code>[FLASH]</code> BBCode tag",
'_admpauth_flash_pmexplain'				=> "",

'_admpenable_pm_icons'					=> "Enable use of topic icons in private messages",
'_admpenable_pm_iconsexplain'			=> "",

'_admpallow_sig'						=> "Allow signatures",
'_admpallow_sigexplain'					=> "",

'_admpallow_sig_bbcode'					=> "Allow BBCode in user signatures",
'_admpallow_sig_bbcodeexplain'			=> "",

'_admpallow_sig_img'					=> "Allow use of <code>[IMG]</code> BBCode tag in user signatures",
'_admpallow_sig_imgexplain'				=> "",

'_admpallow_sig_flash'					=> "Allow use of <code>[FLASH]</code> BBCode tag in user signatures",
'_admpallow_sig_flashexplain'			=> "",

'_admpallow_sig_smilies'				=> "Allow use of smilies in user signatures",
'_admpallow_sig_smiliesexplain'			=> "",

'_admpallow_sig_links'					=> "Allow use of links in user signatures",
'_admpallow_sig_linksexplain'			=> "",


'_admpmax_sig_chars'					=> "Maximum signature length",
'_admpmax_sig_charsexplain'				=> "Maximum number of characters in user signatures.",

'_admpmax_sig_urls'						=> "Maximum signature links",
'_admpmax_sig_urlsexplain'				=> "Maximum number of links in user signatures. Set to 0 for unlimited links.",

'_admpmax_sig_font_size'				=> "Maximum signature font size",
'_admpmax_sig_font_sizeexplain'			=> "Maximum font size allowed in user signatures. Set to 0 for unlimited size.",

'_admpmax_sig_smilies'					=> "Maximum smilies per signature",
'_admpmax_sig_smiliesexplain'			=> "Maximum smilies allowed in user signatures. Set to 0 for unlimited smilies.",

'_admpmax_sig_img_width'				=> "Maximum signature image width",
'_admpmax_sig_img_widthexplain'			=> "Maximum width of an image/flash file in user signatures. Set to 0 for unlimited width.",

'_admpmax_sig_img_height'				=> "Maximum signature image height",
'_admpmax_sig_img_heightexplain'		=> "Maximum height of an image/flash file in user signatures. Set to 0 for unlimited height.",

"_admpsourcedir"						=> "Sources Directory",
"_admpsourcedirexplain"					=> "Please Give the Full source directory path for system use.<br />Do not use / or ./",
	'ACP_ATTACHMENTS'			=> 'Attachments',
	'ACP_ATTACHMENT_SETTINGS'	=> 'Attachment settings',
	'ACP_BOARD_CONFIGURATION'	=> 'Board configuration',
	'ACP_EXTENSION_GROUPS'		=> 'Manage extension groups',
	'ACP_MANAGE_EXTENSIONS'		=> 'Manage extensions',
	'ACP_ORPHAN_ATTACHMENTS'	=> 'Orphaned attachments',
));
?>