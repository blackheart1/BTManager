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
** File shoutbox.php 2018-02-23 14:32:00 Black_Heart
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
$cfgquery = "SELECT * FROM ".$db_prefix."_shout_config;";
$cfgres = $db->sql_query($cfgquery);
$cfgrow = $db->sql_fetchrow($cfgres);
$db->sql_freeresult($cfgres);
$user->set_lang('admin/shout_box',$user->ulanguage);
		$do						= request_var('do', '');
if ($do == "saveshout") {
		$dateformat		= utf8_normalize_nfc(request_var('dateformat', $cfgrow['dateformat'], true));
		$sub_announce_ment						= request_var('sub_announce_ment', '',true);
		$sub_shoutnewuser						= request_var('sub_shoutnewuser', '');
		$sub_shout_new_torrent					= request_var('sub_shout_new_torrent', '');
		$sub_shout_new_porn						= request_var('sub_shout_new_porn', '');
		$sub_turn_on							= request_var('sub_turn_on', '');
		$sub_refresh_time						= request_var('sub_refresh_time', '');
		$sub_shouts_to_show						= request_var('sub_shouts_to_show', '');
		$sub_bbcode_on							= request_var('sub_bbcode_on', '');
		$sub_allow_url							= request_var('sub_allow_url', '');
		$sub_autodelete_time					= request_var('sub_autodelete_time', '');
		$sub_canedit_on							= request_var('sub_canedit_on', '');
		$sub_candelete_on						= request_var('sub_candelete_on', '');
		//die($dateformat);
        //First I create the two SQL arrays
        $params = Array();
        $values = Array();
        array_push($params,"announce_ment"); array_push($values,esc_magic($sub_announce_ment));
        array_push($params,"shoutnewuser"); array_push($values,$sub_shoutnewuser);
        array_push($params,"dateformat"); array_push($values,$db->sql_escape($dateformat));
        array_push($params,"shout_new_torrent"); array_push($values,$sub_shout_new_torrent);
        array_push($params,"shout_new_porn"); array_push($values,$sub_shout_new_porn);
        array_push($params,"turn_on"); array_push($values,$sub_turn_on);
        array_push($params,"refresh_time"); array_push($values,intval($sub_refresh_time));
        array_push($params,"idle_time"); array_push($values,intval($sub_idle_time));
        array_push($params,"shouts_to_show"); array_push($values,intval($sub_shouts_to_show));
        if ($sub_bbcode_on != "yes") $sub_bbcode_on = "no"; array_push($params,"bbcode_on"); array_push($values,$sub_bbcode_on);
        if ($sub_allow_url != "yes") $sub_allow_url = "no"; array_push($params,"allow_url"); array_push($values,$sub_allow_url);
        array_push($params,"autodelete_time"); array_push($values,intval($sub_autodelete_time));
        if ($sub_canedit_on != "yes") $sub_canedit_on = "no"; array_push($params,"canedit_on"); array_push($values,$sub_canedit_on);
        if ($sub_candelete_on != "yes") $sub_candelete_on = "no"; array_push($params,"candelete_on"); array_push($values,$sub_candelete_on);

        //Now I save the settings
        //but first I test the insertion against SQL errors, or I lose everything in case of error
        $sql = "INSERT INTO ".$db_prefix."_shout_config (".implode(", ",$params).") VALUES ('".implode("', '",$values)."');";
        if (!$db->sql_query($sql)) btsqlerror($sql);
        $db->sql_query("TRUNCATE TABLE ".$db_prefix."_shout_config;");
        $db->sql_query($sql);
		$pmbt_cache->remove_file("sql_".md5("shout").".php");

        //Finally, I redirect the user to configuration page
                                $template->assign_vars(array(
								        'S_SUCCESS'            => true,
										'S_FORWARD'			=> $siteurl."/admin.php?i=siteinfo&op=shoutbox",
								        'TITTLE_M'          => $user->lang['SUCCESS'],
                                        'MESSAGE'            => $user->lang['_admsaved'],
                                ));
		echo $template->fetch('message_body.html');
		close_out();
}

				$dateformat_options = '';
				//echo $u_datetime;
				foreach ($user->lang['dateformats'] as $format => $null)
				{
					$dateformat_options .= '<option value="' . $format . '"' . (($format == $cfgrow['dateformat']) ? ' selected="selected"' : '') . '>';
					$dateformat_options .= $user->format_date(time(), $format, false) . ((strpos($format, '|') !== false) ? $user->lang['VARIANT_DATE_SEPARATOR'] . $user->format_date(time(), $format, true) : '');
					$dateformat_options .= '</option>';
				}

				$s_custom = false;

				$dateformat_options .= '<option value="custom"';
				if (!isset($user->lang['dateformats'][$cfgrow['dateformat']]))
				{
					$dateformat_options .= ' selected="selected"';
					$s_custom = true;
				}
				$dateformat_options .= '>' . $user->lang['CUSTOM_DATEFORMAT'] . '</option>';
$template->assign_vars(array(
        'L_TITLE'            		=> $user->lang["SHOUT_CONF"],
        'L_TITLE_EXPLAIN'           => $user->lang["SHOUT_CONF_EXP"],
		'S_DATEFORMAT_OPTIONS'					=> $dateformat_options,
		'DATE_FORMAT'			=> $cfgrow['dateformat'],
		'S_CUSTOM_DATEFORMAT'	=> $s_custom,


		'U_ACTION'					=> "./admin.php?i=siteinfo&op=shoutbox&do=saveshout",
));

drawRow("announce_ment","text", false , $user->lang["BT_SHOUT"]);
drawRow("announce_ment","text", $user->lang["BT_SHOUT_ANNOUNCEMENT"]);
drawRow("shoutnewuser","select",$user->lang["YES_NO"]);
drawRow("shout_new_torrent","select",$user->lang["YES_NO"]);
drawRow("shout_new_porn","select",$user->lang["YES_NO"]);
drawRow("turn_on","select",$user->lang["YES_NO"]);
drawRow("refresh_time","text");
drawRow("idle_time","text");
drawRow("shouts_to_show","text");
drawRow("bbcode_on","select",$user->lang["YES_NO"]);
drawRow("allow_url","select",$user->lang["YES_NO"]);
drawRow("autodelete_time","text");
drawRow("canedit_on","select",$user->lang["YES_NO"]);
drawRow("candelete_on","select",$user->lang["YES_NO"]);
echo $template->fetch('admin/shout_box.html');
		close_out();
?>