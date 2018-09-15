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
				{
					if (file_exists($thememaindir . "/" . $themedir . "/main.php"))
                        $themes[$themedir] = $themedir;
				}
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
$hidden = array(
			'op'		=> 'editprofile',
			'action'	=> 'preferences',
			'mode'		=> 'personal',
			'take_edit'	=> '1'
			);
				$dateformat_options = '';
				//echo $u_datetime;
				foreach ($user->lang['dateformats'] as $format => $null)
				{
					$dateformat_options .= '<option value="' . $format . '"' . (($format == $user->date_format) ? ' selected="selected"' : '') . '>';
					$dateformat_options .= $user->format_date(time(), $format, false) . ((strpos($format, '|') !== false) ? $user->lang['VARIANT_DATE_SEPARATOR'] . $user->format_date(time(), $format, true) : '');
					$dateformat_options .= '</option>';
				}

				$s_custom = false;

				$dateformat_options .= '<option value="custom"';
				if (!isset($user->lang['dateformats'][$user->date_format]))
				{
					$dateformat_options .= ' selected="selected"';
					$s_custom = true;
				}
				$dateformat_options .= '>' . $user->lang['CUSTOM_DATEFORMAT'] . '</option>';
			//die($userrow["pm_popup"]);
				$sort_dir_text = array('a' => $user->lang['ASCENDING'], 'd' => $user->lang['DESCENDING']);

				// Topic ordering options
				$limit_topic_days = array(0 => $user->lang['ALL_TOPICS'], 1 => $user->lang['1_DAY'], 7 => $user->lang['7_DAYS'], 14 => $user->lang['2_WEEKS'], 30 => $user->lang['1_MONTH'], 90 => $user->lang['3_MONTHS'], 180 => $user->lang['6_MONTHS'], 365 => $user->lang['1_YEAR']);
				$sort_by_topic_text = array('a' => $user->lang['AUTHOR'], 't' => $user->lang['POST_TIME'], 'r' => $user->lang['REPLIES'], 's' => $user->lang['SUBJECT'], 'v' => $user->lang['VIEWS']);

				// Post ordering options
				$limit_post_days = array(0 => $user->lang['ALL_POSTS'], 1 => $user->lang['1_DAY'], 7 => $user->lang['7_DAYS'], 14 => $user->lang['2_WEEKS'], 30 => $user->lang['1_MONTH'], 90 => $user->lang['3_MONTHS'], 180 => $user->lang['6_MONTHS'], 365 => $user->lang['1_YEAR']);
				$sort_by_post_text = array('a' => $user->lang['AUTHOR'], 't' => $user->lang['POST_TIME'], 's' => $user->lang['SUBJECT']);

				$_options = array('topic', 'post');
				foreach ($_options as $sort_option)
				{
					${'s_limit_' . $sort_option . '_days'} = '<select name="' . $sort_option . '_st">';
					foreach (${'limit_' . $sort_option . '_days'} as $day => $text)
					{
						$selected = ($userrow['user_' . $sort_option . '_show_days'] == $day) ? ' selected="selected"' : '';
						${'s_limit_' . $sort_option . '_days'} .= '<option value="' . $day . '"' . $selected . '>' . $text . '</option>';
					}
					${'s_limit_' . $sort_option . '_days'} .= '</select>';

					${'s_sort_' . $sort_option . '_key'} = '<select name="' . $sort_option . '_sk">';
					foreach (${'sort_by_' . $sort_option . '_text'} as $key => $text)
					{
						$selected = ($userrow['user_' . $sort_option . '_sortby_type'] == $key) ? ' selected="selected"' : '';
						${'s_sort_' . $sort_option . '_key'} .= '<option value="' . $key . '"' . $selected . '>' . $text . '</option>';
					}
					${'s_sort_' . $sort_option . '_key'} .= '</select>';

					${'s_sort_' . $sort_option . '_dir'} = '<select name="' . $sort_option . '_sd">';
					foreach ($sort_dir_text as $key => $value)
					{
						$selected = ($userrow['user_' . $sort_option . '_sortby_dir'] == $key) ? ' selected="selected"' : '';
						${'s_sort_' . $sort_option . '_dir'} .= '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
					}
					${'s_sort_' . $sort_option . '_dir'} .= '</select>';
				}
$template->assign_vars(array(
		'S_DATEFORMAT_OPTIONS'	=> $dateformat_options,
		'DATE_FORMAT'			=> $user->date_format,
		'S_CUSTOM_DATEFORMAT'	=> $s_custom,
		'S_HIDDEN_FIELDS'		=> build_hidden_fields($hidden),
		'CP_TORPERPAGE'			=> ($userrow["torrent_per_page"] > 0)? $userrow["torrent_per_page"] : 0,
		'CP_VIEW_DEAD'			=> $userrow["view_dead_tor"],
		'CP_HIDE_PROFILE'		=> ($userrow["hide_profile"] == 'true')? true : false,
		'CP_PARKED'				=> ($userrow["parked"] == 'true')? true : false,
		'CP_SHOW_ONLINE'		=> ($userrow["Show_online"] == 'true')? true : false,
		'CP_PM_POPUP'			=> ($userrow["pm_popup"] == 'true')? true : false,
		'CP_ALLOW_PM'			=> ($userrow["user_allow_pm"] == '1')? true : false,
		'CP_ALLOW_MASS_MAIL'	=> ($userrow["mass_mail"] == 'yes')? true : false,
		'CP_PM_NOTIVY'			=> ($userrow["pm_notify"] == 'true')? true : false,
		'U_ALLOW_EMAIL'			=> ($userrow["accept_mail"] == 'yes')? true : false,
		'CP_VIEW_FLASH'			=> btm_optionget($userrow, 'viewflash'),
		'CP_VIEW_IMAGES'		=> btm_optionget($userrow, 'viewimg'),
		'BBCODE'				=> btm_optionget($userrow, 'bbcode'),
		'CP_VIEW_SMILIES'		=> btm_optionget($userrow, 'viewsmilies'),
		'CP_VIEW_SIGS'			=> btm_optionget($userrow, 'viewsigs'),
		'CP_VIEW_AVATAR'		=> btm_optionget($userrow, 'viewavatars'),
		'CP_VIEW_CENSOR'		=> btm_optionget($userrow, 'viewcensors'),
		'CP_SMILES'				=> btm_optionget($userrow, 'smilies'),
		'CP_ATACH_SIG'			=> btm_optionget($userrow, 'attachsig'),
		'CP_PASSKEY'			=> $userrow["passkey"],
		'TX_OFF_SET'			=> tz_select('',$userrow,1),
		'U_COUNTRY'				=> cnt_select("" , $userrow ),
		'U_THEMES'				=> $custtheme,
		'U_LANGUAGES'			=> $custlang,
		'DST'					=> $userrow['user_dst'],
		'S_FORCE_PASSKEY'		=> $force_passkey,
		'S_TOPIC_SORT_DAYS'		=> $s_limit_topic_days,
		'S_TOPIC_SORT_KEY'		=> $s_sort_topic_key,
		'S_TOPIC_SORT_DIR'		=> $s_sort_topic_dir,
		'S_POST_SORT_DAYS'		=> $s_limit_post_days,
		'S_POST_SORT_KEY'		=> $s_sort_post_key,
		'S_POST_SORT_DIR'		=> $s_sort_post_dir,
));
?>