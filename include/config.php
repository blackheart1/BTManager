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
** And Joe Robertson (aka joeroberts/Black_Heart)
** Project Leaders: Black_Heart, Thor.
** File config.php 2018-08-30 20:50:00 Thor
**
** CHANGES
**
** 2018-08-30 - Changed phpMyBitTorrent to BT.Manager
**/

if (!defined('IN_PMBT'))
{
    include_once './../security.php';
    die ();
}

if (extension_loaded('zlib'))
{
    ob_end_clean();
}

if (function_exists('ob_gzhandler') && !ini_get('zlib.output_compression'))
    ob_start('ob_gzhandler');
else
    ob_start();
    ob_implicit_flush(0);

if (!file_exists("include/configdata.php"))
{
    header("Location: setup/index.php");
    die();
}

if (file_exists("setup/index.php"))
    die("You MUST Delete the Setup Directory before running BT.Manager");

/*
WARNING: (IIS USERS)
You MUST Add the APPLICATION/X-BITTORRENT MIMETYPE to your Server Configuration
associating it to the .torrent Extension or your Users Browsers won't accept any torrent
*/

if (!ini_get("register_globals"))
{
    if (phpversion() < '5.4')
    {
        @import_request_variables('GPC');
    }
    else
    {
        @extract($_REQUEST, EXTR_PREFIX_SAME, 'GPS');
    }
}

// Overriding against Fake Input
// if (!isset($btuser)) $btuser = "";

if (!isset($_COOKIE["btuser"])) $btuser = "";
if (!isset($_COOKIE["bttheme"])) $bttheme = "";
if (!isset($_COOKIE["btlanguage"])) $btlanguage = "";

require_once("include/configdata.php");
require_once("include/db/database.php");

$db = new sql_db($db_host, $db_user, $db_pass, $db_name, $db_persistency) or die("Class Error");

if (!$db->db_connect_id)
{
    $err    = $db->sql_error;
    $errmsg = $err['message'];

    die("<html>\n
            <head><title>BT.Manager Error</title>\n</head>\n
                <body>\n
                <!-- Error: $errmsg -->\n
                <p><center>\n
                <br /><br />\n
                <strong>There seems to be a problem with the Database Server, sorry for the inconvenience.
                <br /><br />\n
                We should be back shortly.</strong></center></p>\n
                </body>\n
        </html>");
}

// This way we Protect Database Authentication against Hacked Mods
unset($db_type, $db_host, $db_user, $db_pass);

require_once'include/class.cache.php';
require_once("include/bittorrent.php");

if (!$row = $pmbt_cache->get_sql("config"))
{
    $sql = "SELECT * FROM " . $db_prefix . "_config LIMIT 1;";

    $configquery = $db->sql_query($sql);

    if (!$configquery) die("Configuration Not Found!  Make sure you have Installed BT.Manager correctly.");

    if (!$row = $db->sql_fetchrow($configquery)) die("BT.Manager not Installed Correctly!  Ensure you have run setup.php or config_default.sql!!");

    $pmbt_cache->set_sql("config", $row);
    $db->sql_freeresult($configquery);
}

if (!$row3 = $pmbt_cache->get_sql("userautodel"))
{
    $sql = "SELECT * FROM " . $db_prefix . "_userautodel LIMIT 1;";

    $userautodel = $db->sql_query($sql);

    if (!$userautodel) die("Configuration Not Found!  Make sure you have Installed BT.Manager correctly.");

    if (!$row3 = $db->sql_fetchrow($userautodel)) die("BT.Manager not Installed Correctly!  Ensure you have run setup.php or config_default.sql!!");

    $pmbt_cache->set_sql("userautodel", $row3);
    $db->sql_freeresult($userautodel);
}

if (!$row2 = $pmbt_cache->get_sql("paypal"))
{
    $sql = "SELECT * FROM " . $db_prefix . "_paypal LIMIT 1;";

    $paypal = $db->sql_query($sql);

    if (!$paypal) die("Configuration Not Found!  Make sure you have Installed BT.Manager correctly.");

    if (!$row2 = $db->sql_fetchrow($paypal)) die("BT.Manager not Installed Correctly!  Ensure you have run setup.php or config_default.sql!!");

    $pmbt_cache->set_sql("paypal", $row2);
    $db->sql_freeresult($paypal);
}

if (!$row4 = $pmbt_cache->get_sql("shout"))
{
    $sql = "SELECT * FROM " . $db_prefix . "_shout_config LIMIT 1;";

    $shout = $db->sql_query($sql);

    if (!$shout) die("Configuration Not Found!  Make sure you have Installed BT.Manager correctly.");

    if (!$row4 = $db->sql_fetchrow($shout)) die("BT.Manager not Installed Correctly!  Ensure you have run setup.php or config_default.sql!!");

    $pmbt_cache->set_sql("shout", $row4);
    $db->sql_freeresult($shout);
}

$shout_config = $row4;

if (!$row5 = $pmbt_cache->get_sql("search_cloud"))
{
    $sql = "SELECT * FROM " . $db_prefix . "_search_cloud LIMIT 1;";

    $search = $db->sql_query($sql);

    if (!$search) die("Configuration Not Found!  Make sure you have Installed BT.Manager correctly.");

    if (!$row5 = $db->sql_fetchrow($search)) die("BT.Manager not Installed Correctly!  Ensure you have run setup.php or config_default.sql!!");

    $pmbt_cache->set_sql("search_cloud", $row5);
    $db->sql_freeresult($search);
}

unset($search);

if (!$avconfig = $pmbt_cache->get_sql("avatar"))
{
    $avsql = "SELECT * FROM " . $db_prefix . "_avatar_config";

    $avres    = $db->sql_query($avsql) or btsqlerror($avsql);
    $avconfig = $db->sql_fetchrow($avres);

    $pmbt_cache->set_sql("avatar", $avconfig);
}

$avon         = ($avconfig['enable_avatars'] == 'true') ? true : false;
$avgalon      = ($avconfig['enable_gallery_avatars'] == 'true') ? true : false;
$avremoteon   = ($avconfig['enable_remote_avatars'] == 'true') ? true : false;
$avuploadon   = ($avconfig['enable_avatar_uploading'] == 'true') ? true : false;
$avremoteupon = ($avconfig['enable_remote_avatar_uploading'] == 'true') ? true : false;
$avmaxsz      = $avconfig['maximum_avatar_file_size'];
$avstore      = $avconfig['avatar_storage_path'];
$avgal        = $avconfig['avatar_gallery_path'];
$avminht      = $avconfig['minimum_avatar_dimensions_ht'];
$avminwt      = $avconfig['minimum_avatar_dimensions_wt'];
$avmaxht      = $avconfig['maximum_avatar_dimensions_ht'];
$avmaxwt      = $avconfig['maximum_avatar_dimensions_wt'];

if (!$attach_config = $pmbt_cache->get_sql("attachmet_con"))
{
    $sql_attach = "SELECT config_name, config_value, is_dynamic
                   FROM " . $db_prefix . "_attachments_config";

    $result = $db->sql_query($sql_attach);

    while ($row_attach = $db->sql_fetchrow($result))
    {
        $attach_config[$row_attach['config_name']] = $row_attach['config_value'];
    }

    $pmbt_cache->set_sql("attachmet_con", $attach_config);
    $db->sql_freeresult($result);
}

// Config Parser Start
$emaileditecf     = true;
$sitename         = $row["sitename"];
$siteurl          = $row["siteurl"];
$cookiedomain     = $row["cookiedomain"];
$cookiepath       = $row["cookiepath"];
$sourcedir        = $row["sourcedir"];
$admin_email      = $row["admin_email"];
$language         = $row["language"];
$theme            = $row["theme"];
$pmbt_time_zone   = $row['time_zone'];
$site_announce    = unserialize($row['announce_url']);
$welcome_message  = $row["welcome_message"];
$announce_message = $row["announce_ments"];
$announce_text    = $row["announce_text"];
$allow_html       = ($row["allow_html"] == "true") ? true : false;
$rewrite_engine   = ($row["rewrite_engine"] == "true") ? true : false;
$torrent_prefix   = $row["torrent_prefix"];
$torrent_per_page = $row["torrent_per_page"];

if ($torrent_per_page == "" or $torrent_per_page == "0") $torrent_per_page = 20;

$onlysearch             = ($row["onlysearch"] == "true") ? true : false;
$max_torrent_size       = $row["max_torrent_size"];
$announce_interval      = $row["announce_interval"];
$announce_interval_min  = $row["announce_interval_min"];
$dead_torrent_interval  = $row["dead_torrent_interval"];
$pivate_mode            = ($row["pivate_mode"] == "true") ? true : false;
$minvotes               = $row["minvotes"];
$time_tracker_update    = $row["time_tracker_update"];
$best_limit             = $row["best_limit"];
$down_limit             = $row["down_limit"];
$torrent_complaints     = ($row["torrent_complaints"] == "true") ? true : false;
$torrent_global_privacy = ($row["torrent_global_privacy"] == "true") ? true : false;
$disclaimer_check       = ($row["disclaimer_check"] == "true") ? true : false;
$gfx_check              = ($row["gfx_check"] == "true") ? true : false;
$recap_puplic_key       = (!$row["Public_Key"] == '') ? $row["Public_Key"] : false;
$recap_private_key      = (!$row["Private_Key"] == '') ? $row["Private_Key"] : false;
$recap_https            = ($row["recap_https"] == "true") ? true : false;
$upload_level           = $row["upload_level"];
$download_level         = $row["download_level"];
$announce_level         = $row["announce_level"];
$max_num_file           = $row["max_num_file"];
$max_share_size         = $row["max_share_size"];
$min_size_seed          = $row["min_size_seed"];
$min_share_seed         = $row["min_share_seed"];
$global_min_ratio       = $row["global_min_ratio"];
$autoscrape             = ($row["autoscrape"] == "true") ? true : false;
$min_num_seed_e         = $row["min_num_seed_e"];
$min_size_seed_e        = $row["min_size_seed_e"];
$minupload_size_file    = $row["minupload_size_file"];
$allow_backup_tracker   = ($row["allow_backup_tracker"] == "true") ? true : false;
$allow_magnet           = $row["allow_magnet"];
$stealthmode            = ($row["stealthmode"] == "true") ? true : false;
$version                = $row["version"];
$force_upload           = ($row["upload_dead"] == "true") ? true : false;
$force_passkey          = ($row["force_passkey"] == "true") ? true : false;
$free_dl                = ($row["free_dl"] == "true") ? true : false;
$most_users_online      = $row["most_on_line"];
$most_users_online_when = $row["when_most"];
$give_sign_up_credit    = $row['give_sign_up_credit'];
$conferm_email          = ($row['conferm_email'] == "true") ? true : false;
$allow_change_email     = ($row['allow_change_email'] == "true") ? true : false;
$start_date             = $row['start_date'];
$INVITEONLY             = ($row["invites_open"] == "true") ? true : false;
$singup_open            = ($row["invite_only"] == "true") ? true : false;
$invite_timeout         = 86400 * 3;
$invites1               = $row["max_members"];
$autoclean_interval     = $row["auto_clean"];
$addprivate             = ($row["addprivate"] == "true") ? true : false;
$allow_external         = ($row["allow_external"] == "true") ? true : false;

$phpEx = substr(strrchr(__FILE__, '.'), 1);

// Donation Block
$paypal_email       = $row2["paypal_email"];
$donatein           = $row2["reseaved_donations"];
$donateasked        = $row2["sitecost"];
$donatepagecontents = $row2['donatepage'];
$donations          = ($row2["donation_block"] == "true") ? true : false;
$nodonate           = $row2["nodonate"];

// User Purge
$inactwarning_time  = 86400 * $row3["inactwarning_time"];
$autodel_users_time = 86400 * $row3["autodel_users_time"];
$autodel_users      = ($row3["autodel_users"] == "true") ? true : false;

// HNR System Not Active Yet
$runhnrsystem  = false;
$TheQueryCount = 0;

// Config Parser End

// Set Inclued Path
set_include_path($sourcedir);
ini_set('include_path', $sourcedir);

// Set Your Time Zone
date_default_timezone_set($pmbt_time_zone);

//Set Data Base To Use Same Time Zone
$now    = new DateTime();
$mins   = $now->getOffset() / 60;
$sgn    = ($mins < 0 ? -1 : 1);
$mins   = abs($mins);
$hrs    = floor($mins / 60);
$mins   -= $hrs * 60;
$offset = sprintf('%+d:%02d', $hrs * $sgn, $mins);

$db->sql_query('SET time_zone = "' . $offset . '";');

#Temp Config
$config = array();

$sql = "SELECT config_name, config_value, is_dynamic
        FROM " . $db_prefix . "_settings";

$var = $db->sql_query($sql);

while ($row = $db->sql_fetchrow($var))
{
    $config[$row['config_name']] = $row['config_value'];
}

$db->sql_freeresult($var);

$user = @new User($_COOKIE["btuser"]);

if (isset($user->user_torrent_per_page) and $user->user_torrent_per_page != "0" and $user->user_torrent_per_page != "")$torrent_per_page = $user->user_torrent_per_page;

$announce_url = $siteurl . "/announce.php";

// Search Cloud Settings
$search_cloud           = ($row5["active"] == "1") ? true : false;
$search_cloud_user_only = ($row5["user_only"] == "1") ? true : false;
$search_cloud_limmit    = $row5["how_many"];

if ($user->moderator) $onlysearch = false;

if (isset($theme_change))
{
    $bttheme = $theme_change;

    if ($bttheme != "" and is_dir("themes/" . $bttheme) and $bttheme != "CVS")
    {
        setcookie("bttheme", $bttheme, $session_time, $cookiepath, $cookiedomain, 0);
        unset($_POST);

        if ($user->user) $db->sql_query('UPDATE ' . $db_prefix . "_users SET theme = '" . $db->sql_escape($bttheme) . "' WHERE id = " . $user->id);
    }
}

if(isset($language_change))
{
    $btlanguage = $language_change;

    if ($btlanguage != "" and is_readable("language/common/" . $btlanguage . ".php") and $btlanguage != "CVS")
    {
        setcookie("btlanguage", $btlanguage, (time() + 31536000), $cookiepath, $cookiedomain, 0);
        unset($_POST);

        if ($user->user) $db->sql_query('UPDATE ' . $db_prefix . "_users SET language = '" . $db->sql_escape($btlanguage) . "' WHERE id = " . $user->id);
    }
}

if (isset($btlanguage) and is_readable("language/common/" . $btlanguage . ".php")) $language = $btlanguage;

$theme = $user->theme;

if (isset($bttheme) and is_readable("themes/" . $bttheme . "/main.php")) $theme = $bttheme;

$user->set_lang('common', $user->ulanguage);

if (file_exists("./themes/" . $theme . "/main.php"))
{
        $theme = $theme;

        require_once("./themes/" . $theme . "/main.php");
}
elseif (file_exists("./themes/Bitfarm/main.php"))
{
    $theme = "Bitfarm";

    require_once("./themes/" . $theme . "/main.php");
}
else
{
    die("Cannot run without Theme!  Reinstall BT.Manager NOW!!");
}

$reason = '';

?>