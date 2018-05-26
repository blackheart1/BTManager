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
** File 5.php 2018-02-18 10:18:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/


require_once("../include/configdata.php");
require_once("udl/database.php");
require_once'../include/textarea.php';
echo"<script type=\"text/javascript\" src=\"../bbcode.js\"></script>";

$db = new sql_db($db_host, $db_user, $db_pass, $db_name, $db_persistency);

function is_url($url) {
        return preg_match('/^http[s]{0,1}:\/\/[\\w\\.]*\\.[\\w]{2,6}(\/[\\w]*){0,}/', $url);
}

function is_email($email) {
        return preg_match("/^(([A-Za-z0-9]+_+)|([A-Za-z0-9]+\\-+)|([A-Za-z0-9]+\\.+)|([A-Za-z0-9]+\\++))*[A-Za-z0-9]+@((\\w+\\-+)|(\\w+\\.))*\\w{1,63}\\.[a-zA-Z]{2,6}$/",$email);
}
function esc_magic($x) {
        if (!get_magic_quotes_gpc()) return addslashes($x);
        else return $x;
}

function help($name,$help,$title = "") {
        echo "<span onmouseover=\"return overlib('".addslashes(str_replace("\n","",$help)),"'";
        if ($title != "") echo ",CAPTION, '".addslashes(str_replace("\n","",$title))."'";
        echo ",FGCOLOR,'#3989A6',CAPICON,'graphics/help.gif',SHADOW,SHADOWOPACITY,40,SHADOWCOLOR,'#000000',SHADOWX,2,SHADOWY,2,HAUTO,VAUTO);\" onmouseout=\"return nd();\" style=\"cursor:help\">".$name."</span>";
}

function drawRow($param, $type, $options = NULL) {
        global $cfgrow, $textarea;
        echo "<tr>";
        echo "<td width=\"16\"><p>";
        help("<img src=\"graphics/help.gif\" />",constant("_admp".$param."explain"),constant("_admp".$param));
        echo "</p></td>\n";
        echo "<td><p>".constant("_admp".$param)."</p></td>\n";
        echo "<td align=\"right\"><p>";
        if ($type == "text") {
                echo "<input type=\"text\" name=\"sub_".$param."\" value=\"".$cfgrow[$param]."\" size=\"40\" />";
        }
        elseif ($type == "text3") {
                $content = "<textarea type=\"text\" name=\"sub_".$param."\" rows=\"15\" cols=\"76\">" . $cfgrow[$param] . "</textarea>";
        } elseif ($type == "select") {
                echo "<select name=\"sub_".$param."\">\n";
                foreach ($options as $key=>$val) {
                        echo "<option ";
                        if ($cfgrow[$param] == $key) echo "selected";
                        echo " value=\"".$key."\">".$val."</option>\n";
                }
                echo "</select>";
        } elseif ($type == "checkbox") {
                echo "<input type=\"checkbox\" name=\"sub_".$param."\" value=\"true\" ";
                if ($cfgrow[$param] == "true") echo "checked";
                echo "/>";
        } elseif ($type == "textarea") {
                echo $textarea->quick_bbcode('formdata',"sub_".$param);
                echo $textarea->input("sub_".$param,'center','2','10','60',$cfgrow[$param]);
				echo "</table>\n";
                echo "</p>";


        }
        echo "</p></td>\n";
        echo "</tr>\n";
}
function drawConfig() {
        echo "<table width=\"100%\">\n";
        echo "<tr><td></td><td><p><b>"._basicsettings."</b></p></td><td></td></tr>\n";
        echo "<tr><td></td><td><p>&nbsp;</p></td><td></td></tr>\n";
        echo "<tr><td></td><td><p>&nbsp;</p></td><td></td></tr>\n";
        drawRow("sitename","text");
        drawRow("siteurl","text");
        drawRow("cookiedomain","text");
        drawRow("cookiepath","text");
        drawRow("sourcedir","text");
        drawRow("admin_email","text");
        echo "<tr><td></td><td><p>&nbsp;</p></td><td></td></tr>\n";
        echo "<tr><td></td><td><p>&nbsp;</p></td><td></td></tr>\n";
        echo "<tr><td></td><td><p><b>"._advancedsettings."</b></p></td><td></td></tr>\n";
        echo "<tr><td></td><td><p>&nbsp;</p></td><td></td></tr>\n";
        echo "<tr><td></td><td><p>&nbsp;</p></td><td></td></tr>\n";

        //Language handling
        {
                $languages = Array();
                $langdir = "./../language/common";
                $langhandle = opendir($langdir);
                while ($langfile = readdir($langhandle)) {
                        if (preg_match("/.php/",$langfile) AND strtolower($langfile) != "mailtexts.php")
                                $languages[str_replace(".php","",$langfile)] = ucwords(str_replace(".php","",$langfile));
                }
                closedir($langhandle);
                unset($langdir,$langfile);
        }
        drawRow("language","select",$languages);
        unset($languages);
        //Theme handling
        {
                $themes = Array();
                $thememaindir = "./../themes";
                $themehandle = opendir($thememaindir);
                while ($themedir = readdir($themehandle)) {
                        if (is_dir($thememaindir."/".$themedir) AND $themedir != "." AND $themedir != ".." AND $themedir != "CVS")
                                $themes[$themedir] = $themedir;
                }
                closedir($themehandle);
                unset($thememaindir,$themedir);
        }
        drawRow("theme","select",$themes);
        unset($themes);
        drawRow("welcome_message","textarea");
        drawRow("announce_text","text");
		drawRow("announce_url","text3");
        drawRow("allow_html","checkbox");
        drawRow("allow_magnet","checkbox");
        drawRow("rewrite_engine","checkbox");
        drawRow("torrent_prefix","text");
        drawRow("torrent_per_page","text");
        drawRow("onlysearch","checkbox");
        drawRow("pivate_mode","checkbox");
        drawRow("force_passkey","checkbox");
        drawRow("max_torrent_size","text");
        drawRow("announce_interval","text");
        drawRow("announce_interval_min","text");
        drawRow("dead_torrent_interval","text");
        drawRow("minvotes","text");
        drawRow("time_tracker_update","text");
        drawRow("give_sign_up_credit","text");//new
        drawRow("conferm_email","checkbox");//new
        drawRow("allow_multy_tracker","checkbox");//new
        drawRow("best_limit","text");
        drawRow("down_limit","text");
        drawRow("torrent_complaints","checkbox");
        drawRow("torrent_global_privacy","checkbox");
        drawRow("disclaimer_check","checkbox");
        drawRow("gfx_check","checkbox");
        drawRow("upload_level","select",Array("all"=>_admpupload_levelopt1, "user"=>_admpupload_levelopt2, "premium"=>_admpupload_levelopt3));
        drawRow("download_level","select",Array("all"=>_admpdownload_levelopt1, "user"=>_admpdownload_levelopt2, "premium" => _admpdownload_levelopt3));
        drawRow("announce_level","select",Array("all"=>_admpannounce_levelopt1, "user"=>_admpannounce_levelopt2));
        drawRow("max_num_file","text");
        drawRow("max_share_size","text");
        drawRow("global_min_ratio","text");
        drawRow("autoscrape","checkbox");
		drawrow("upload_dead","checkbox");
        drawRow("min_num_seed_e","text");
        drawRow("min_size_seed_e","text");
        drawRow("minupload_file_size","text");
        drawRow("allow_backup_tracker","checkbox");
        drawRow("stealthmode","checkbox");
		drawRow("invites_open","checkbox");
        drawRow("invite_only","checkbox");
        drawRow("max_members","text");
        drawRow("auto_clean","text");
        drawRow("free_dl","checkbox");
        drawRow("addprivate","checkbox");
		drawRow("wait_time","checkbox");
		drawRow("GIGSA","text");
		drawRow("RATIOA","text");
		drawRow("WAITA","text");
		drawRow("GIGSB","text");
		drawRow("RATIOB","text");
		drawRow("WAITB","text");
		drawRow("GIGSC","text");
		drawRow("RATIOC","text");
		drawRow("WAITC","text");
		drawRow("GIGSD","text");
		drawRow("RATIOD","text");
		drawRow("WAITD","text");

        echo "</table>\n\n";
}


if (!isset($postback)) { //Set default parameters
        $script_uri = array_key_exists("SCRIPT_URI",$_SERVER) ? $_SERVER["SCRIPT_URI"] : "http://".$_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"];
        $pmbturl = parse_url($script_uri);
        if (preg_match("/(.*)\/setup\/index\.php/i",$pmbturl["path"],$pmreg)) $pmpath = $pmreg[1];
        else $pmpath = "/";

        $cfgrow["sitename"] = "phpMyBitTorrent";
        $cfgrow["siteurl"] = $pmbturl["scheme"]."://".$pmbturl["host"].$pmpath;
        $cfgrow["cookiedomain"] = $pmbturl["host"];
        $cfgrow["cookiepath"] = $pmpath;
        $cfgrow["sourcedir"] = str_replace('/setup/index.php','',preg_replace("!${_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME'])) . DIRECTORY_SEPARATOR;
        $cfgrow["admin_email"] = array_key_exists("SERVER_ADMIN",$_SERVER) ? $_SERVER["SERVER_ADMIN"] : "admin@".$pmbturl["host"];
        $cfgrow["language"] = $language;
        $cfgrow["theme"] = "pmbt";
        $cfgrow["welcome_message"] = "";
        $cfgrow["announce_text"] = "";
        $cfgrow["announce_url"] = "";
        $cfgrow["allow_html"] = true;
		$cfgrow["allow_magnet"] = true;
        $cfgrow["rewrite_engine"] = false;
        $cfgrow["torrent_prefix"] = "";
        $cfgrow["torrent_per_page"] = 10;
        $cfgrow["onlysearch"] = false;
        $cfgrow["pivate_mode"] = false;
        $cfgrow["force_passkey"] = false;
        $cfgrow["max_torrent_size"] = 0;
        $cfgrow["announce_interval"] = 300;
        $cfgrow["announce_interval_min"] = 0;
        $cfgrow["dead_torrent_interval"] = 1500;
        $cfgrow["minvotes"] = 0;
        $cfgrow["time_tracker_update"] = 3600;
        $cfgrow["best_limit"] = 0;
        $cfgrow["down_limit"] = 0;
        $cfgrow["allow_multy_tracker"] = true;
        $cfgrow["conferm_email"] = true;
        $cfgrow["give_sign_up_credit"] = 0;
        $cfgrow["torrent_complaints"] = false;
        $cfgrow["torrent_global_privacy"] = false;
        $cfgrow["disclaimer_check"] = true;
        $cfgrow["gfx_check"] = (extension_loaded("gd")) ? true : false;
        $cfgrow["upload_level"] = "user";
        $cfgrow["download_level"] = "all";
        $cfgrow["announce_level"] = "all";
        $cfgrow["max_num_file"] = 0;
        $cfgrow["max_share_size"] = 0;
        $cfgrow["global_min_ratio"] = 0;
        $cfgrow["autoscrape"] = true;
        $cfgrow["min_num_seed_e"] = 0;
        $cfgrow["min_size_seed_e"] = 0;
        $cfgrow["minupload_file_size"] = 0;
        $cfgrow["allow_backup_tracker"] = true;
        $cfgrow["stealthmode"] = false;
		$cfgrow["upload_dead"] = false;
        $cfgrow["version"] = _VERSION;
		$cfgrow["invites_open"] = false;
        $cfgrow["invite_only"] = false;
        $cfgrow["max_members"] = 50000;
        $cfgrow["auto_clean"] = 600;
        $cfgrow["free_dl"] = false;
        $cfgrow["addprivate"] = false;
        $cfgrow["wait_time"] = false;
        $cfgrow["GIGSA"] = 0;
        $cfgrow["RATIOA"] = 0.0;
        $cfgrow["WAITA"] = 0;
        $cfgrow["GIGSB"] = 0;
        $cfgrow["RATIOB"] = 0.0;
        $cfgrow["WAITB"] = 0;
        $cfgrow["GIGSC"] = 0;
        $cfgrow["RATIOC"] = 0.0;
        $cfgrow["WAITC"] = 0;
        $cfgrow["GIGSD"] = 0;
        $cfgrow["RATIOD"] = 0.0;
        $cfgrow["WAITD"] = 0;

} else {
        $cfgrow["sitename"] = $sub_sitename;
        $cfgrow["siteurl"] = $sub_siteurl;
        $cfgrow["cookiedomain"] = $sub_cookiedomain;
        $cfgrow["cookiepath"] = $sub_cookiepath;
        $cfgrow["sourcedir"] = $sub_sourcedir;
        $cfgrow["admin_email"] = $sub_admin_email;
        $cfgrow["language"] = $sub_language;
        $cfgrow["theme"] = $sub_theme;
        $cfgrow["welcome_message"] = $sub_welcome_message;
        $cfgrow["announce_text"] = $sub_announce_text;
        $cfgrow["announce_url"] = $announce_url;
        $cfgrow["allow_html"] = (isset($sub_allow_html) AND $sub_allow_html == "true") ? true : false;
		$cfgrow["allow_magnet"] = (isset($sub_allow_magnet) AND $sub_allow_magnet == "true") ? true : false;
        $cfgrow["rewrite_engine"] = (isset($sub_rewrite_engine) AND $sub_rewrite_engine == "true") ? true : false;
        $cfgrow["torrent_prefix"] = $sub_torrent_prefix;
        $cfgrow["torrent_per_page"] = $sub_torrent_per_page;
        $cfgrow["onlysearch"] = (isset($sub_onlysearch) AND $sub_onlysearch == "true") ? true : false;
        $cfgrow["pivate_mode"] = (isset($sub_pivate_mode) AND $sub_pivate_mode == "true") ? true : false;
        $cfgrow["force_passkey"] = (isset($sub_force_passkey) AND $sub_force_passkey == "true") ? true : false;
        $cfgrow["max_torrent_size"] = $sub_max_torrent_size;
        $cfgrow["announce_interval"] = $sub_announce_interval;
        $cfgrow["announce_interval_min"] = $sub_announce_interval_min;
        $cfgrow["dead_torrent_interval"] = $sub_dead_torrent_interval;
        $cfgrow["minvotes"] = $sub_minvotes;
        $cfgrow["time_tracker_update"] = $sub_time_tracker_update;
        $cfgrow["best_limit"] = $sub_best_limit;
        $cfgrow["down_limit"] = $sub_down_limit;
        $cfgrow["allow_multy_tracker"] = (isset($sub_allow_multy_tracker) AND $sub_allow_multy_tracker == "true") ? true : false;
        $cfgrow["conferm_email"] = (isset($sub_conferm_email) AND $sub_conferm_email == "true") ? true : false;
        $cfgrow["give_sign_up_credit"] = $sub_give_sign_up_credit;
        $cfgrow["torrent_complaints"] = (isset($sub_torrent_complaints) AND $sub_torrent_complaints == "true") ? true : false;
        $cfgrow["torrent_global_privacy"] = (isset($sub_torrent_global_privacy) AND $sub_torrent_global_privacy == "true") ? true : false;
        $cfgrow["disclaimer_check"] = (isset($sub_disclaimer_check) AND $sub_disclaimer_check == "true") ? true : false;
        $cfgrow["gfx_check"] = (isset($sub_gfx_check) AND $sub_gfx_check == "true") ? true : false;
        $cfgrow["upload_level"] = $sub_upload_level;
        $cfgrow["download_level"] = $sub_download_level;
        $cfgrow["announce_level"] = $sub_announce_level;
        $cfgrow["max_num_file"] = $sub_max_num_file;
        $cfgrow["max_share_size"] = $sub_max_share_size;
        $cfgrow["global_min_ratio"] = $sub_global_min_ratio;
        $cfgrow["autoscrape"] = (isset($sub_autoscrape) AND $sub_autoscrape == "true") ? true : false;
        $cfgrow["min_num_seed_e"] = $sub_min_num_seed_e;
        $cfgrow["min_size_seed_e"] = $sub_min_size_seed_e;
        $cfgrow["minupload_file_size"] = $sub_minupload_file_size;
        $cfgrow["allow_backup_tracker"] = (isset($sub_allow_backup_tracker) AND $sub_allow_backup_tracker == "true") ? true : false;
        $cfgrow["stealthmode"] = (isset($sub_stealthmode) AND $sub_stealthmode == "true") ? true : false;
		$cfgrow["upload_dead"] = (isset($sub_upload_dead) And $sub_upload_dead == "true") ? true : false;
		$cfgrow["invites_open"] = (isset($sub_invites_open) And $sub_invites_open == "true") ? true : false;
        $cfgrow["invite_only"] = (isset($sub_invite_only) And $sub_invite_only == "true") ? true : false;
        $cfgrow["max_members"] = $sub_max_members;
        $cfgrow["auto_clean"] = $sub_auto_clean;
        $cfgrow["free_dl"] = (isset($sub_free_dl) AND $sub_free_dl == "true") ? true : false;
        $cfgrow["addprivate"] = (isset($sub_addprivate) AND $sub_addprivate == "true") ? true : false;
        $cfgrow["wait_time"] = (isset($sub_wait_time) AND $sub_wait_time == "true") ? true : false;
        $cfgrow["GIGSA"] = $sub_GIGSA;
        $cfgrow["RATIOA"] = $sub_RATIOA;
        $cfgrow["WAITA"] = $sub_WAITA;
        $cfgrow["GIGSB"] = $sub_GIGSB;
        $cfgrow["RATIOB"] = $sub_RATIOB;
        $cfgrow["WAITB"] = $sub_WAITB;
        $cfgrow["GIGSC"] = $sub_GIGSC;
        $cfgrow["RATIOC"] = $sub_RATIOC;
        $cfgrow["WAITC"] = $sub_WAITC;
        $cfgrow["GIGSD"] = $sub_GIGSD;
        $cfgrow["RATIOD"] = $sub_RATIOD;
        $cfgrow["WAITD"] = $sub_WAITD;
        $cfgrow["version"] = _VERSION;
}

if (isset($postback)) {
        //Process Request
        //First I create the two SQL arrays
        $params = Array();
        $values = Array();
		$vallad_ann = array();
		$announce_url = explode("\n", $sub_announce_url);
		foreach($announce_url as $a)
		{
			if(is_url(strtolower($a)))array_push($vallad_ann,$a);
		}

        //Then I accurately check each parameter before inserting it in SQL statement
        //Some parameters that must be numeric have to be checked with an if clause because intval() function truncates to max integer
		array_push($params,"announce_url"); array_push($values,serialize($vallad_ann));
        array_push($params,"sitename"); array_push($values,$db->sql_escape($sub_sitename));
        if (is_url($sub_siteurl)) { array_push($params,"siteurl"); array_push($values,$db->sql_escape($sub_siteurl)); }
        array_push($params,"cookiedomain"); array_push($values,$sub_cookiedomain);
		$cookiedomain = $sub_cookiedomain;
        if (preg_match('/^\/.*/', $sub_cookiepath)) { array_push($params,"cookiepath"); array_push($values,$db->sql_escape($sub_cookiepath)); }
		$cookiepath = $sub_cookiedomain;
        array_push($params,"sourcedir"); array_push($values,$db->sql_escape($sub_sourcedir));
        if (is_email($sub_admin_email)) { array_push($params,"admin_email"); array_push($values,$db->sql_escape($sub_admin_email)); }
        if (file_exists("../language/common/".$sub_language.".php")) { array_push($params,"language"); array_push($values,$sub_language); }
        if (is_dir("../themes/".$sub_theme)) { array_push($params,"theme"); array_push($values,$sub_theme); }
        array_push($params,"welcome_message"); array_push($values,$db->sql_escape($sub_welcome_message));
        array_push($params,"announce_text"); array_push($values,$db->sql_escape($sub_announce_text));
        if ($sub_allow_html != "true") $sub_allow_html = "false"; array_push($params,"allow_html"); array_push($values,$sub_allow_html);
		if ($sub_allow_magnet != "true") $sub_allow_magnet = "false"; array_push($params,"allow_magnet"); array_push($values,($sub_allow_magnet == 'true')? '1' : '0');
        if (!isset($sub_rewrite_engine) OR $sub_rewrite_engine != "true") $sub_rewrite_engine = "false"; array_push($params,"rewrite_engine"); array_push($values,$sub_rewrite_engine);
        array_push($params,"torrent_prefix"); array_push($values,$sub_torrent_prefix);
        array_push($params,"torrent_per_page"); array_push($values,intval($sub_torrent_per_page));
        if (!isset($sub_onlysearch) OR $sub_onlysearch != "true") $sub_onlysearch = "false"; array_push($params,"onlysearch"); array_push($values,$sub_onlysearch);
        if (!isset($sub_force_passkey) OR $sub_force_passkey != "true") $sub_force_passkey = "false"; array_push($params,"force_passkey"); array_push($values,$sub_force_passkey);
        if (!isset($sub_pivate_mode) OR $sub_pivate_mode != "true") $sub_pivate_mode = "false"; array_push($params,"pivate_mode"); array_push($values,$sub_pivate_mode);
        if (!isset($sub_conferm_email) OR $sub_conferm_email != "true") $sub_conferm_email = "false"; array_push($params,"conferm_email"); array_push($values,$sub_conferm_email);
        if (is_numeric($sub_give_sign_up_credit)) {array_push($params,"give_sign_up_credit"); array_push($values,$sub_give_sign_up_credit); }
        if (!isset($sub_allow_multy_tracker ) OR $sub_allow_multy_tracker  != "true") $sub_allow_multy_tracker  = "false"; array_push($params,"allow_multy_tracker "); array_push($values,$sub_allow_multy_tracker );
        if (!isset($sub_allow_external) OR $sub_allow_external != "true") $sub_allow_external = "false"; array_push($params,"allow_external"); array_push($values,$sub_allow_external);
        array_push($params,"max_torrent_size"); array_push($values,intval($sub_max_torrent_size));
        array_push($params,"announce_interval"); array_push($values,intval($sub_announce_interval));
        array_push($params,"announce_interval_min"); if($sub_announce_interval_min > $sub_announce_interval) array_push($values,intval($sub_announce_interval)); else array_push($values,intval($sub_announce_interval_min));
        array_push($params,"dead_torrent_interval"); array_push($values,intval($sub_dead_torrent_interval));
        array_push($params,"minvotes"); array_push($values,intval($sub_minvotes));
        array_push($params,"time_tracker_update"); array_push($values,intval($sub_time_tracker_update));
        array_push($params,"best_limit"); array_push($values,intval($sub_best_limit));
        array_push($params,"down_limit"); array_push($values,intval($sub_down_limit));
        if (!isset($sub_torrent_complaints) OR $sub_torrent_complaints != "true") $sub_torrent_complaints = "false"; array_push($params,"torrent_complaints"); array_push($values,$sub_torrent_complaints);
        if (!isset($sub_torrent_global_privacy) OR $sub_torrent_global_privacy != "true") $sub_torrent_global_privacy = "false"; array_push($params,"torrent_global_privacy"); array_push($values,$sub_torrent_global_privacy);
        if (!isset($sub_disclaimer_check) OR $sub_disclaimer_check != "true") $sub_disclaimer_check = "false"; array_push($params,"disclaimer_check"); array_push($values,$sub_disclaimer_check);
        if (!isset($sub_gfx_check) OR $sub_gfx_check != "true") $sub_gfx_check = "false"; array_push($params,"gfx_check"); array_push($values,$sub_gfx_check);
        if (in_array($sub_upload_level,Array("all","user","premium"))) { array_push($params,"upload_level"); array_push($values,$sub_upload_level); }
        if (in_array($sub_download_level,Array("all","user","premium"))) { array_push($params,"download_level"); array_push($values,$sub_download_level); }
        if ($sub_announce_level != "all") $sub_announce_level = "user"; array_push($params,"announce_level"); array_push($values,$sub_announce_level);
        array_push($params,"max_num_file"); array_push($values,intval($sub_max_num_file));
        if (is_numeric($sub_max_share_size)) { array_push($params,"max_share_size"); array_push($values,$sub_max_share_size); }
        array_push($params,"global_min_ratio"); array_push($values,number_format($sub_global_min_ratio,2));
        if (!isset($sub_autoscrape) OR $sub_autoscrape != "true") $sub_autoscrape = "false"; array_push($params,"autoscrape"); array_push($values,$sub_autoscrape);
        if (is_numeric($sub_min_num_seed_e)) { array_push($params,"min_num_seed_e"); array_push($values,$sub_min_num_seed_e); }
        if (is_numeric($sub_min_size_seed_e)) { array_push($params,"min_size_seed_e"); array_push($values,$sub_min_size_seed_e); }
        if (!isset($sub_allow_backup_tracker) OR $sub_allow_backup_tracker != "true") $sub_allow_backup_tracker = "false"; array_push($params,"allow_backup_tracker"); array_push($values,$sub_allow_backup_tracker);
        if (!isset($sub_stealthmode) OR $sub_stealthmode != "true") $sub_stealthmode = "false"; array_push($params,"stealthmode"); array_push($values,$sub_stealthmode);
        if (!isset($sub_upload_dead) OR $sub_upload_dead != "true") $sub_upload_dead = "false"; array_push($params,"upload_dead"); array_push($values,$sub_upload_dead);
        if (!isset($sub_invites_open) OR $sub_invites_open != "true") $sub_invites_open = "false"; array_push($params,"invites_open"); array_push($values,$sub_invites_open);
        if (!isset($sub_invite_only) OR $sub_invite_only != "true") $sub_invite_only = "false"; array_push($params,"invite_only"); array_push($values,$sub_invite_only);
        if (is_numeric($sub_max_members)) {array_push($params,"max_members"); array_push($values,$sub_max_members); }
        if (is_numeric($sub_auto_clean)) {array_push($params,"auto_clean"); array_push($values,$sub_auto_clean); }
        if (!isset($sub_free_dl) OR $sub_free_dl != "true") $sub_free_dl = "false"; array_push($params,"free_dl"); array_push($values,$sub_free_dl);
        if (!isset($sub_addprivate) OR $sub_addprivate != "true") $sub_addprivate = "false"; array_push($params,"addprivate"); array_push($values,$sub_addprivate);
        if (is_numeric($sub_GIGSA)) {array_push($params,"GIGSA"); array_push($values,$sub_GIGSA); }
        if (is_numeric($sub_RATIOA)) {array_push($params,"RATIOA"); array_push($values,$sub_RATIOA); }
        if (is_numeric($sub_WAITA)) {array_push($params,"WAITA"); array_push($values,$sub_WAITA); }
        if (is_numeric($sub_GIGSB)) {array_push($params,"GIGSB"); array_push($values,$sub_GIGSB); }
        if (is_numeric($sub_RATIOB)) {array_push($params,"RATIOB"); array_push($values,$sub_RATIOB); }
        if (is_numeric($sub_WAITB)) {array_push($params,"WAITB"); array_push($values,$sub_WAITB); }
        if (is_numeric($sub_GIGSC)) {array_push($params,"GIGSC"); array_push($values,$sub_GIGSC); }
        if (is_numeric($sub_RATIOC)) {array_push($params,"RATIOC"); array_push($values,$sub_RATIOC); }
        if (is_numeric($sub_WAITC)) {array_push($params,"WAITC"); array_push($values,$sub_WAITC); }
        if (is_numeric($sub_GIGSD)) {array_push($params,"GIGSD"); array_push($values,$sub_GIGSD); }
        if (is_numeric($sub_RATIOD)) {array_push($params,"RATIOD"); array_push($values,$sub_RATIOD); }
        if (is_numeric($sub_WAITD)) {array_push($params,"WAITD"); array_push($values,$sub_WAITD); }
        array_push($params,"version"); array_push($values,_VERSION);

        $db->sql_query("TRUNCATE TABLE ".$db_prefix."_config;");
        $sql = "INSERT INTO ".$db_prefix."_config (start_date, ".implode(", ",$params).") VALUES (NOW(), '".implode("', '",$values)."');";
        if (!$db->sql_query($sql)) {
                //Error Handling
                $err = $db->sql_error();
                echo "<input type=\"hidden\" name=\"step\" value=\"5\" />\n";

                echo "<p align=\"center\"><font size=\"5\">"._step5."</font></p>\n";
                echo "<p>&nbsp;</p>\n";

                echo "<p>";
                echo "<font class=\"err\">";
                echo _btsqlerror1."<br />\n<textarea rows=\"4\" cols=\"65\">".htmlspecialchars($sql)."</textarea>";
                echo "<br />" ;
                echo _btsqlerror2.$err["code"];
                echo "<br />";
                echo _btsqlerror3.$err["message"];
                echo "</font></p>";


                echo "<p>"._step5explain."</p>\n";
                echo "<p>&nbsp;</p>\n";

                drawConfig();

                echo "<p><input type=\"submit\" name=\"postback\" value=\""._nextstep."\" /><input type=\"reset\" value=\""._reset."\" /></p>\n";
        } else {
			$db->sql_query('UPDATE '.$db_prefix.'_cache_con SET value = \'' . $sub_sourcedir . 'cache\' WHERE name = \'cache_dir\'');
                echo "<input type=\"hidden\" name=\"cookiepath\" value=\"{$cookiepath}\" />\n";
                echo "<input type=\"hidden\" name=\"cookiedomain\" value=\"{$cookiedomain}\" />\n";
                echo "<input type=\"hidden\" name=\"step\" value=\"6\" />\n";
                echo "<p>"._step5complete."</p>";
                echo "<p><input type=\"submit\" value=\""._nextstep."\" /></p>\n";
        }
} else {
        echo "<input type=\"hidden\" name=\"step\" value=\"5\" />\n";

        echo "<p align=\"center\"><font size=\"5\">"._step5."</font></p>\n";
        echo "<p>&nbsp;</p>\n";
        echo "<p>"._step5explain."</p>\n";
        echo "<p>&nbsp;</p>\n";

        drawConfig();

        echo "<p><input type=\"submit\" name=\"postback\" value=\""._nextstep."\" /><input type=\"reset\" value=\""._reset."\" /></p>\n";
}

//$db->sql_query("",END_TRANSACTION);
$db->sql_close();
?>