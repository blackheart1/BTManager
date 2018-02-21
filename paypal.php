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
** File paypal.php 2018-02-17 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);

include("include/config_lite.php");
require_once'include/class.cache.php';
function getip() {
   if (isset($_SERVER)) {
     if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && validip($_SERVER['HTTP_X_FORWARDED_FOR'])) {
       $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
     } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && validip($_SERVER['HTTP_CLIENT_IP'])) {
       $ip = $_SERVER['HTTP_CLIENT_IP'];
     } else {
       $ip = $_SERVER['REMOTE_ADDR'];
     }
   } else {
     if (getenv('HTTP_X_FORWARDED_FOR') && validip(getenv('HTTP_X_FORWARDED_FOR'))) {
       $ip = getenv('HTTP_X_FORWARDED_FOR');
     } elseif (getenv('HTTP_CLIENT_IP') && validip(getenv('HTTP_CLIENT_IP'))) {
       $ip = getenv('HTTP_CLIENT_IP');
     } else {
       $ip = getenv('REMOTE_ADDR');
     }
   }

   return $ip;
}
function logerror($message, $error = '') {
        global $db, $db_prefix, $user;
                $ip = getip();
       $sql = "INSERT INTO ".$db_prefix."_log (action, results, ip, host, userid) VALUES ('".addslashes($error)."', '".addslashes($message)."', '".sprintf("%u",ip2long($ip))."',  '".gethostbyaddr($ip)."', '".$user->id."');";
        $db->sql_query($sql);
        return;
}
function gmtime()
{
    return strtotime(get_date_time());
}

function get_date_time($timestamp = 0)
{
  if ($timestamp)
    return date("Y-m-d H:i:s", $timestamp);
  else
    return gmdate("Y-m-d H:i:s");
}

// read the post from PayPal system and add 'cmd'
// Read the post from PayPal and add 'cmd' 
$req = 'cmd=_notify-validate'; 
if(function_exists('get_magic_quotes_gpc')) 
  { $get_magic_quotes_exits = true;} 
foreach ($_POST as $key => $value) 
  // Handle escape characters, which depends on setting of magic quotes 
  { if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) 
    {  $value = urlencode(stripslashes($value)); 
  } else { 
    $value = urlencode($value); 
  }  
  $req .= "&$key=$value";  
} 
logerror($req,'Donation');
// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);

// assign posted variables to local variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];
$clid = $_POST['payer_id'];
$gift = $_POST['custom'];
if($gift == 3 AND $payment_amount < 10){
$gift = 1;
$gift_message = 'Your requist for FTP Was denide due to Donation not enouph\nYou well get Free leech for your Donation.\nit well stay active for one day for each $0.323 you donated.';
}
$ftp_gift = false;
if($gift == 3){
$ftp_gift = true;
$gift_message = 'Your requist for FTP was aproved and well take UP to 24 hours to activate';
}
if($gift == 1)$gift_message = 'Your request for Free leech is now active.\nit well stay active for one day for each $0.323 you donated.';
if($gift == 2)$gift_message = 'Your request for No Hit And Run Warnings is now active.\nit well stay active for one day for each $0.323 you donated.';
$donated = $payment_amount;
$days = $donated/0.322;
$time = 86400*$days;
$gig = 1025*1025*1025*$donated;//86400
$gig = $gig*10;

if (!$fp) {
} else {
fputs ($fp, $header . $req);
while (!feof($fp)) {
$res = fgets ($fp, 1024);
if (strcmp ($res, "VERIFIED") == 0) {
$sql = "SELECT * FROM ".$db_prefix."_users WHERE id='$item_number';";
$row = $db->sql_query($sql);
$user = $db->sql_fetchrow($row);
if($user['dondate'] == '0000-00-00 00:00:00' OR get_date_time(gmtime() - $user['donator_tell']) > $user['dondate'])$donatedate = get_date_time();
else
$donatedate = $user['dondate'];
  $db->sql_query("UPDATE ".$db_prefix."_users SET uploaded = uploaded + '$gig', dondate = NOW(), donator_tell = UNIX_TIMESTAMP(donator_tell) + '$time',  `dongift` = $gift, donator = 'true', donated = donated + '$payment_amount' WHERE id='$item_number'");
  $db->sql_query("UPDATE ".$db_prefix."_paypal SET reseaved_donations = $donatein + '$payment_amount' ");
  $db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sent, sender, recipient, subject, text) VALUES (NOW(), 0, $item_number, 'Donation', ':thankyou:\nFor your donation of $".$payment_amount."\n".$gift_message."')");
  if($ftp_gift)$db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sent, sender, recipient, subject, text) VALUES (NOW(), 0, 145, 'Donation For FTP', '".$item_number." has dontaed and requested FTP access')");
		$pmbt_cache->remove_file("sql_".md5("paypal").".php");

}
else if (strcmp ($res, "INVALID") == 0) {
// log for manual investigation

}//header("Location: ".$siteurl."");
}
fclose ($fp);
}
?>