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
** File personal.php 2018-02-18 14:32:00 joeroberts
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
        $languages = Array();
        $langdir = "language/common";
        $langhandle = opendir($langdir);
        while ($langfile = readdir($langhandle)) {
                if (preg_match("/\.php$/",$langfile) AND strtolower($langfile) != "mailtexts.php")
                        $languages[str_replace(".php","",$langfile)] = ucwords(str_replace(".php","",$langfile));
        }
        closedir($langhandle);
        unset($langdir,$langfile);
		$custlang = '';
foreach ($languages as $key=>$val) {
        $custlang .="<option ";
        if ($userrow["language"] == $key) $custlang .="selected";
        $custlang .=" value=\"".$key."\">".$val."</option>\n";
}
unset($languages);
        $themes = Array();
        $thememaindir = "themes";
        $themehandle = opendir($thememaindir);
        while ($themedir = readdir($themehandle)) {
                if (is_dir($thememaindir."/".$themedir) AND $themedir != "." AND $themedir != ".." AND $themedir != "CVS")
                        $themes[$themedir] = $themedir;
        }
        closedir($themehandle);
        unset($thememaindir,$themedir);
		$custtheme = '';
foreach ($themes as $key=>$val) {
        $custtheme .="<option ";
        if ($userrow["theme"] == $key) $custtheme .="selected";
        $custtheme .=" value=\"".$key."\">".$val."</option>\n";
}
unset($themes);
$off_set ='';
$sql = ("SELECT id,name from ".$db_prefix."_time_offset ORDER BY name");
$tz_r = $db->sql_query($sql);
while ($tz_a = $db->sql_fetchrow($tz_r))
  $off_set .= "<option value=$tz_a[id]" . ($userrow["tzoffset"] == $tz_a['id'] ? " selected" : "") . ">$tz_a[name]</option>\n";
$hidden = array(
			'op'		=> 'editprofile',
			'action'	=> 'preferences',
			'mode'		=> 'personal',
			'take_edit'	=> '1'
			);
			//die($userrow["pm_popup"]);
$template->assign_vars(array(
		'S_HIDDEN_FIELDS'		=> build_hidden_fields($hidden),
		'CP_TORPERPAGE'			=> $userrow["torrent_per_page"],
		'CP_SHOW_ONLINE'		=> ($userrow["Show_online"] == 'true')? true : false,
		'CP_PM_POPUP'			=> ($userrow["pm_popup"] == 'true')? true : false,
		'CP_ALLOW_PM'			=> ($userrow["user_allow_pm"] == '1')? true : false,
		'CP_ALLOW_MASS_MAIL'	=> ($userrow["mass_mail"] == 'yes')? true : false,
		'CP_PM_NOTIVY'			=> ($userrow["pm_notify"] == 'true')? true : false,
		'U_ALLOW_EMAIL'			=> ($userrow["accept_mail"] == 'yes')? true : false,
		'CP_PASSKEY'			=> $userrow["passkey"],
		'TX_OFF_SET'			=> tz_select('',$userrow),
		'U_COUNTRY'				=> cnt_select("" , $userrow ),
		'U_THEMES'				=> $custtheme,
		'U_LANGUAGES'			=> $custlang,
));
?>