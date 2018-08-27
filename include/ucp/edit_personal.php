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
		$dateformat		= utf8_normalize_nfc(request_var('dateformat', $userrow['user_dateformat'], true));
		$accept_mail						=  request_var('accept_mail', '0');
		$mass_mail							=  request_var('mass_mail', '0');
		$pm_notify							=  request_var('pm_notify', '0');
		$user_allow_pm						=  request_var('user_allow_pm', '0');
		$Show_online						=  request_var('Show_online', '0');
		$pm_popup							=  request_var('pm_popup', '0');
		$use_passkey						=  request_var('use_passkey', '');
		$passkey_reset						=  request_var('passkey_reset', '');
		$offset								=  request_var('offset', '0');
		$dst								=  request_var('dst', $userrow['user_dst']);
		$customtheme						=  request_var('customtheme', '0');
		$customlang							=  request_var('customlang', '0');
		$user_torrent_per_page				=  request_var('user_torrent_per_page', '0');
		$view_dead_tor						=  request_var('view_dead', $userrow['view_dead_tor']);
		$u_country							=  request_var('u_country', '0');
		$u_parked							=  request_var('parked', '0');
		$hide_profile						=  request_var('hide_profile', '0');
		$view_images						= request_var('view_images', btm_optionget($userrow, 'viewimg'));
		$view_flash							= request_var('view_flash', btm_optionget($userrow, 'viewflash'));
		$view_smilies						= request_var('view_smilies', btm_optionget($userrow, 'viewsmilies'));
		$view_sigs							= request_var('view_sigs', btm_optionget($userrow, 'viewsigs'));
		$view_avatars						= request_var('view_avatars', btm_optionget($userrow, 'viewavatars'));
		$view_wordcensor					= request_var('view_wordcensor', btm_optionget($userrow, 'viewcensors'));
		$bbcode								= request_var('bbcode', btm_optionget($userrow, 'bbcode'));
		$smilies							= request_var('smilies', btm_optionget($userrow, 'smilies'));
		$sig								= request_var('sig', btm_optionget($userrow, 'attachsig'));
		$topic_sk							= request_var('topic_sk', ($userrow['user_topic_sortby_type']) ? $userrow['user_topic_sortby_type'] : 't');
		$topic_sd							= request_var('topic_sd', ($userrow['user_topic_sortby_dir']) ? $userrow['user_topic_sortby_dir'] : 'd');
		$topic_st							= request_var('topic_st', ($userrow['user_topic_show_days']) ? $userrow['user_topic_show_days'] : 0);

		$post_sk							= request_var('post_sk', ($userrow['user_post_sortby_type']) ? $userrow['user_post_sortby_type'] : 't');
		$post_sd							= request_var('post_sd', ($userrow['user_post_sortby_dir']) ? $userrow['user_post_sortby_dir'] : 'a');
		$post_st							= request_var('post_st', ($userrow['user_post_show_days']) ? $userrow['user_post_show_days'] : 0);


		$sqlval['view_dead_tor']			= $view_dead_tor;
		$sqlval['user_topic_sortby_type']	= $topic_sk;
		$sqlval['user_post_sortby_type']	= $post_sk;
		$sqlval['user_topic_sortby_dir']	= $topic_sd;
		$sqlval['user_post_sortby_dir']		= $post_sd;
		$sqlval['user_topic_show_days']		= $topic_st;
		$sqlval['user_post_show_days']		= $post_st;
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

        if ($customtheme == "0" OR $customtheme == "CVS" OR !is_dir("themes/".$customtheme)) $customtheme = NULL;
		$sqlval['theme'] = $customtheme;
		if (!isset($offset) OR $offset =="") $offset = '0';
		$sqlval['tzoffset'] = $offset;
		$sqlval['user_dst'] = $dst;
        if ($user_torrent_per_page == "0" OR $user_torrent_per_page == "") $user_torrent_per_page = 0;
		$sqlval['torrent_per_page'] = $user_torrent_per_page;
		btm_optionset($userrow, 'viewimg', $view_images);
		btm_optionset($userrow, 'viewflash', $view_flash);
		btm_optionset($userrow, 'viewsmilies', $view_smilies);
		btm_optionset($userrow, 'viewsigs', $view_sigs);
		btm_optionset($userrow, 'viewavatars', $view_avatars);
		btm_optionset($userrow, 'viewcensors', $view_wordcensor);
		btm_optionset($userrow, 'bbcode', $bbcode);
		btm_optionset($userrow, 'smilies', $smilies);
		btm_optionset($userrow, 'attachsig', $sig);
		$sqlval['user_options'] = $userrow['user_options'];
		$sqlval['user_dateformat'] = $dateformat;
						//die(print_r($userrow));
					$error = validate_data($sqlval, array(
						'user_dateformat'	=> array('string', false, 1, 30),
						'user_topic_sortby_type'		=> array('string', false, 1, 1),
						'user_topic_sortby_dir'			=> array('string', false, 1, 1),
						'user_post_sortby_type'		=> array('string', false, 1, 1),
						'user_post_sortby_dir'		=> array('string', false, 1, 1),
					));
			if (!sizeof($error))
			{
				$sql = 'UPDATE ' . $db_prefix . '_users SET ' . $db->sql_build_array('UPDATE', $sqlval) . '
						WHERE id = ' . $userrow["id"];
                if (!$db->sql_query($sql)) btsqlerror($sql);
				if($user->id == $uid)userlogin($uname, $btuser);
				$template->assign_vars(array(
						'S_SUCCESS'			=> true,
						'S_FORWARD' 	  	=> $siteurl . '/user.php?op=editprofile' . ((!$admin_mode) ? '' : "&amp;id=" .$uid  ) . '&amp;action=preferences&amp;mode=personal',
						'TITTLE_M'			=>$user->lang['UPDATED'],
						'MESSAGE'			=> $user->lang['PROFILE_UPDATED'].back_link($siteurl . '/user.php?op=editprofile' . ((!$admin_mode) ? '' : "&amp;id=" .$uid  ) . '&amp;action=preferences&amp;mode=personal'),
				));
			}
			else
			{
				$error = array_map(array($user, 'lang'), $error);
				$template->assign_vars(array(
						'S_ERROR'			=> true,
						'TITTLE_M'			=>$user->lang['ALERT_ERROR'],
						'MESSAGE'			=> implode('<br />', $error).back_link($siteurl . '/user.php?op=editprofile' . ((!$admin_mode) ? '' : "&amp;id=" .$uid  ) . '&amp;action=preferences&amp;mode=personal'),
				));
			}
                echo $template->fetch('message_body.html');
				die();
?>