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
** File config_light.php 2018-02-18 14:32:00 joeroberts
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT'))
{
	include_once './../security.php';
	die ();
}
//if (@file_exists("setup/index.php")) die();

//Compressed Output Buffering always makes trouble with BT clients
if (extension_loaded('zlib')){ ob_end_clean();}
if (function_exists('ob_gzhandler') && !ini_get('zlib.output_compression'))
	ob_start('ob_gzhandler');
else
	ob_start();
@ob_implicit_flush(0);

$phpver = phpversion();
if ($phpver < '4.1.0') {
        $_GET = $HTTP_GET_VARS;
        $_POST = $HTTP_POST_VARS;
        $_SERVER = $HTTP_SERVER_VARS;
}


if (!ini_get("register_globals")) {
	if (phpversion() < '5.4') {
		@import_request_variables('GPC');
	}else{
		@extract($_REQUEST, EXTR_PREFIX_SAME,'GPS');
	}
}

require_once("include/configdata.php");
require_once("include/db/database.php");

$db = new sql_db($db_host, $db_user, $db_pass, $db_name, $db_persistency) or die("Class error");
if(!$db->db_connect_id) {
        die("d14:failure reason26:Cannot connect to databasee");
}

//This way we protect database authentication against hacked mods
unset($db_type,$db_host,$db_user,$db_pass,$db_persistency);


$sql = "SELECT * FROM ".$db_prefix."_config LIMIT 1;";

$configquery = $db->sql_query($sql,BEGIN_TRANSACTION);

if (!$configquery) die($sql."1phpMyBitTorrent not correctly installed! Ensure you have run setup.php or config_default.sql!!");
if (!$row = $db->sql_fetchrow($configquery)) die("2phpMyBitTorrent not correctly installed! Ensure you have run setup.php or config_default.sql!!");
$sql = "SELECT * FROM ".$db_prefix."_paypal LIMIT 1;";

$paypal = $db->sql_query($sql,BEGIN_TRANSACTION);

if (!$paypal) die("Configuration not found! Make sure you have installed phpMyBitTorrent correctly.");
if (!$row2 = $db->sql_fetchrow($paypal)) die("phpMyBitTorrent not correctly installed! Ensure you have run setup.php or config_default.sql!!");
#Config parser start
$sitename = $row["sitename"];
$siteurl = $row["siteurl"];
$admin_email = $row["admin_email"];
$language = $row["language"];
$theme = $row["theme"];
$pmbt_time_zone = $row['time_zone'];
$sourcedir = $row["sourcedir"];
$torrent_prefix = $row["torrent_prefix"];
$announce_text = $row["announce_text"];
$announce_interval = $row["announce_interval"];
$announce_interval_min = ($row["announce_interval_min"] == 0) ? ($row["announce_interval"]-1) : $row["announce_interval_min"];
$dead_torrent_interval = $row["dead_torrent_interval"];
$time_tracker_update = $row["time_tracker_update"];
$best_limit = $row["best_limit"];
$down_limit = $row["down_limit"];
$torrent_global_privacy = ($row["torrent_global_privacy"] == "true") ? true : false;
$download_level = $row["download_level"];
$announce_level = $row["announce_level"];
$max_num_file = $row["max_num_file"];
$max_share_size = $row["max_share_size"];
$min_size_seed = $row["min_size_seed"];
$min_share_seed = $row["min_share_seed"];
$global_min_ratio = $row["global_min_ratio"];
$autoscrape = ($row["autoscrape"] == "true" ? true : false);
$min_num_seed_e = $row["min_num_seed_e"];
$min_size_seed_e = $row["min_size_seed_e"];
$minupload_size_file = $row["minupload_size_file"];
$allow_backup_tracker = ($row["allow_backup_tracker"] == "true") ? true : false;
$stealthmode = ($row["stealthmode"] == "true") ? true : false;
$free_dl = ($row["free_dl"] == "true") ? true : false;
$GIGSA= $row["GIGSA"];
$RATIOA= $row["RATIOA"];
$WAITA=$row["WAITA"];
$GIGSB= $row["GIGSB"];
$RATIOB= $row["RATIOB"];
$WAITB= $row["WAITB"];
$GIGSC= $row["GIGSC"];
$RATIOC= $row["RATIOC"];
$WAITC= $row["WAITC"];
$GIGSD= $row["GIGSD"];
$RATIOD= $row["WAITD"];
$WAITD= $row["WAITD"];
$force_passkey = ($row["force_passkey"] == "true" ? true : false);
$pivate_mode = ($row["pivate_mode"] == "true") ? true : false;
$wait_time = ($row["wait_time"] == "true") ? true : false;
$most_users_online = $row["most_on_line"];
$most_users_online_when = $row["when_most"];

$version = $row["version"];
$announce_url = $siteurl."/announce.php";
#donationblock
$paypal_email = $row2["paypal_email"];
$donatein = $row2["reseaved_donations"];
$donateasked = $row2["sitecost"];
$donatepagecontents = $row2['donatepage'];
$donations = ($row2["donation_block"]=="true") ? true : false;
$nodonate = $row2["nodonate"];
/*Set inclued path*/
set_include_path($sourcedir);
ini_set('include_path',$sourcedir);
/*Set your time zone*/
date_default_timezone_set($pmbt_time_zone);
/*Set data base to use same time zone*/
$now = new DateTime();
$mins = $now->getOffset() / 60;
$sgn = ($mins < 0 ? -1 : 1);
$mins = abs($mins);
$hrs = floor($mins / 60);
$mins -= $hrs * 60;
$offset = sprintf('%+d:%02d', $hrs*$sgn, $mins);
$db->sql_query('SET time_zone = "' . $offset . '";');
require_once("include/functions.php");
require_once("include/class.user.php");
if ($use_rsa) require_once("include/rsalib.php");
if ($use_rsa) $rsa = New RSA($rsa_modulo, $rsa_public, $rsa_private);
if(!$_COOKIE["btuser"])$_COOKIE["btuser"] = '';
$user = @new User($_COOKIE["btuser"]);

#Config Parser end
?>