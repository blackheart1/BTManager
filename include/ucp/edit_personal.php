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
** File edit_personal.php 2018-02-18 14:32:00 joeroberts
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT'))
{
	include_once './../../security.php';
	die ();
}

		//Build new info array
		$sqlval = array();
		
		$accept_mail						=  request_var('accept_mail', '0');
		$mass_mail							=  request_var('mass_mail', '0');
		$pm_notify							=  request_var('pm_notify', '0');
		$user_allow_pm						=  request_var('user_allow_pm', '0');
		$Show_online						=  request_var('Show_online', '0');
		$pm_popup							=  request_var('pm_popup', '0');
		$use_passkey						=  request_var('use_passkey', '');
		$passkey_reset						=  request_var('passkey_reset', '');
		$offset								=  request_var('offset', '0');
		$customtheme						=  request_var('customtheme', '0');
		$customlang							=  request_var('customlang', '0');
		$user_torrent_per_page				=  request_var('user_torrent_per_page', '0');
		$u_country							=  request_var('u_country', '0');
		$u_parked							=  request_var('parked', '0');
		$hide_profile						=  request_var('hide_profile', '0');



                $sqlval['country'] = $u_country;
        if ($accept_mail == "1") {
                $sqlval['accept_mail'] = "yes";
        } else {
                $sqlval['accept_mail'] = "no";
        }
        if ($mass_mail == "1") {
                $sqlval['mass_mail'] = "yes";
        } else {
                $sqlval['mass_mail'] = "no";
        }
        if ($u_parked == "1") {
                $sqlval['parked'] = "true";
        } else {
                $sqlval['parked'] = "false";
        }
        if ($pm_popup == "1") {
                $sqlval['pm_popup'] = "true";
        } else {
                $sqlval['pm_popup'] = "false";
        }
        if ($pm_notify == "1") {
                $sqlval['pm_notify'] = "true";
        } else {
                $sqlval['pm_notify'] = "false";
        }
        if ($Show_online == "1") {
                $sqlval['Show_online'] = "true";
        } else {
                $sqlval['Show_online'] = "false";
        }
        if ($hide_profile == "1") {
                $sqlval['hide_profile'] = "true";
        } else {
                $sqlval['hide_profile'] = "false";
        }
        if (($userrow["passkey"] == "" AND $use_passkey == "true") OR ($use_passkey == "true" AND $passkey_reset == "true")OR($passkey_reset == "true" AND $force_passkey)) {
                //Generate new Passkey
                do {
                        $passkey = RandomAlpha(32);
                        //Check whether passkey already exists
                        $sql = "SELECT passkey FROM ".$db_prefix."_users WHERE passkey = '".$passkey."';";
                        $res = $db->sql_query($sql);
                        $cnt = $db->sql_numrows($sql);
                        $db->sql_freeresult($res);
                } while ($cnt > 0);
                processinput("passkey",$passkey);
                $sqlval['passkey'] = $passkey;

        } elseif(($use_passkey == "0") AND $userrow["passkey"] != "") {
                //Remove Passkey
                $passkey = "NULL";
                if(!$force_passkey)$sqlval['passkey'] = $passkey;
        }
        if ($customlang == "0" OR !is_readable("language/".$customlang.".php")) $customlang = NULL;
		$sqlval['language'] = $customlang;

        if ($customtheme == "0" OR $customtheme == "CVS" OR !is_dir("themes/".$customtheme)) $customtheme = 'NULL';
		$sqlval['theme'] = $customtheme;
		if (!isset($offset) OR $offset =="") $offset = '0';
		$sqlval['tzoffset'] = $offset;
        if ($user_torrent_per_page == "0" OR $user_torrent_per_page == "") $user_torrent_per_page = NULL;
		$sqlval['torrent_per_page'] = $user_torrent_per_page;
				$sql = 'UPDATE ' . $db_prefix . '_users SET ' . $db->sql_build_array('UPDATE', $sqlval) . '
					WHERE id = ' . $userrow["id"];
                if (!$db->sql_query($sql)) btsqlerror($sql);
				if($user->id == $uid)userlogin($uname, $btuser);
                                $template->assign_vars(array(
										'S_REFRESH'				=> true,
										'META' 				  	=> '<meta http-equiv="refresh" content="5;url=' . $siteurl . '/user.php?op=editprofile' . ((!$admin_mode) ? '' : "&amp;id=" .$uid  ) . '&amp;action=preferences&amp;mode=personal" />',
										'S_ERROR_HEADER'		=>$user->lang['UPDATED'],
                                        'S_ERROR_MESS'			=> $user->lang['PROFILE_UPDATED'].back_link($siteurl . '/user.php?op=editprofile' . ((!$admin_mode) ? '' : "&amp;id=" .$uid  ) . '&amp;action=preferences&amp;mode=personal'),
                                ));
                echo $template->fetch('error.html');
				die();
?>