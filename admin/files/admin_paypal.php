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
** File admin_paypal.php 2018-02-17 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT'))
{
	include_once './../../security.php';
	die ("You can't access this file directly");
}
include_once('include/function_posting.php');
include_once('include/message_parser.php');
include_once('include/class.bbcode.php');
include_once("include/utf/utf_tools.php");
$user->set_lang('admin/acp_pay_pal',$user->ulanguage);
$cfgquery = "SELECT * FROM ".$db_prefix."_paypal;";
$cgfres = $db->sql_query($cfgquery)or btsqlerror($cfgquery);
$cfgrow = $db->sql_fetchrow($cgfres);
$cfgrow['donatepage'] = str_replace('<br>', "\n",stripslashes($cfgrow['donatepage']));
$db->sql_freeresult($cgfres);
if ($do == "saveadmon_paypal") {
        //First I create the two SQL arrays
		$sub_siteurl				= request_var('sub_siteurl', '');
		$sub_paypal_email			= request_var('sub_paypal_email', '');
		$sub_donation_block			= request_var('sub_donation_block', 'false');
		$sub_sitecost				= request_var('sub_sitecost', '');
		$sub_reseaved_donations		= request_var('sub_reseaved_donations', '');
		$sub_donatepage				= utf8_normalize_nfc(request_var('sub_donatepage', '',true));
		$sub_nodonate				= request_var('sub_nodonate', '');
        $params = Array();
        $values = Array();
		$sub_donatepage				= $db->sql_escape(str_replace("\n",'<br>',html_entity_decode($sub_donatepage)));

        //Process Request

        //Then I accurately check each parameter before inserting it in SQL statement
        //Some parameters that must be numeric have to be checked with an if clause because intval() function truncates to max integer
        if (is_url($sub_siteurl)) { array_push($params,"siteurl"); array_push($values,esc_magic($sub_siteurl)); }
		if (is_email($sub_paypal_email)) { array_push($params,"paypal_email"); array_push($values,esc_magic($sub_paypal_email)); }
		if (!isset($sub_donation_block) OR $sub_donation_block != "true") $sub_donation_block = "false"; array_push($params,"donation_block"); array_push($values,$sub_donation_block);
		if (is_numeric($sub_sitecost)) { array_push($params,"sitecost"); array_push($values,$sub_sitecost); }
		if (is_numeric($sub_reseaved_donations)) { array_push($params,"reseaved_donations"); array_push($values,$sub_reseaved_donations); }
		array_push($params,"donatepage"); array_push($values,esc_magic($sub_donatepage));
        if (in_array($sub_nodonate,Array("EU","UK","US"))) { array_push($params,"nodonate"); array_push($values,$sub_nodonate); }

        //Now I save the settings
        //but first I test the insertion against SQL errors, or I lose everything in case of error
        $sql = "INSERT INTO ".$db_prefix."_paypal (".implode(", ",$params).") VALUES ('".implode("', '",$values)."');";
        if (!$db->sql_query($sql)) btsqlerror($sql);
        $db->sql_query("TRUNCATE TABLE ".$db_prefix."_paypal;");
        $db->sql_query($sql);
		$pmbt_cache->remove_file("sql_".md5("paypal").".php");

        //Finally, I redirect the user to configuration page
                                $template->assign_vars(array(
								        'S_SUCCESS'            => true,
										'S_FORWARD'			=> $siteurl."/admin.php?i=siteinfo&op=admin_paypal",
								        'TITTLE_M'          => $user->lang['SUCCESS'],
                                        'MESSAGE'            => $user->lang['_admsaved'],
                                ));
		echo $template->fetch('message_body.html');
		close_out();
}
$template->assign_vars(array(
        'L_TITLE'            		=> $user->lang["_admpdonations"],
        'L_TITLE_EXPLAIN'           => $user->lang["_admpdonationsexplain"],
		'U_ACTION'					=> "./admin.php?op=admin_paypal&do=saveadmon_paypal",
));

drawRow("siteurl","text", false , $user->lang["_admpdonations"]);
drawRow("paypal_email","text");
drawrow("donation_block","checkbox");
drawRow("sitecost","text");
drawRow("reseaved_donations","text");
drawRow("donatepage","textarea");
drawRow("nodonate","select",$user->lang["_admpnodonateopt"]);
echo $template->fetch('admin/pay_pal.html');
		close_out();
?>