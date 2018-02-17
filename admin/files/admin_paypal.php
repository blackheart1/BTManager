<?php
/*
*----------------------------phpMyBitTorrent V 3.0.0---------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
*-------------------   And Joe Robertson (aka joeroberts)   -------------------*
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
*------              ©2010 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*--------------------   Sunday, May 17, 2009 1:05 AM   ------------------------*
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 admin_paypal.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
include_once('include/function_posting.php');
include_once('include/message_parser.php');
include_once('include/class.bbcode.php');
include_once("include/utf/utf_tools.php");
$user->set_lang('admin/pay_pal',$user->ulanguage);
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