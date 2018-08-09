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
** File link.php 2018-02-18 14:32:00 joeroberts
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
require_once("include/torrent_functions.php");
define("INVALID_LINK",0);
define("LINK_OK",1);
define("FILES_DONT_MATCH",-2);

$ed2k_regex = "/^ed2k:\/\/\|file\|(?P<name>[^|]*)\|(?P<size>[0-9]*)\|(?P<hash>[0-fA-Z]*)\|/i";
$magnet_regex_sha1 = "/^magnet:\\?xt=urn:(btih|sha1):(?P<hash>[a-zA-Z0-9]*)(&|&amp;)dn=(?P<name>[^&\\s]*)/i";
$mg_trackers = '/tr=([^&]*)/i';
$magnet_regex_bitprint = "/^magnet:\\?xt=urn:bitprint:(?P<bitprint>[a-zA-Z0-9]*)&dn=(?P<name>[^&\\s]*)/i";
$md5sum_regex = "/^[0-f]{32}$/i";

		$ed2klink			= request_var('ed2klink', '');
		$magnetlink			= request_var('magnetlink', '');
		$md5sum				= request_var('md5sum', '');
		$link_category		= request_var('link_category', 0);
		$old_files			= request_var('old_files', '');
		$priv_key = base64_encode($_SERVER["SERVER_SIGNATURE"].$_SERVER["SCRIPT_NAME"]);
#Build Missing ED2K link
if($ed2klink == '' AND !$magnetlink == '')
{
	preg_match_all($magnet_regex_sha1,$magnetlink,$matches);
	$ed2klink = "ed2k://|file|".rawurldecode($matches["name"][0])."|10|".$matches["hash"][0]."|";
}
$can_submit = false;
$files = Array();
if ($old_files != "") {
        if ($use_rsa) {
                $files = unserialize($rsa->decrypt($old_files));
        } else {
                $files = unserialize(base64_decode($old_files));
                if (crypt($old_files,$priv_key) != $fingerprint) bterror('LIST_ALTERED','ERROR_INUPLOAD');
        }
}

if (isset($postback) AND is_numeric($postback)) {
unset($files[$postback]);
$nf = array();
foreach($files as $val) $nf[] = $val;
        $files = $nf;
        unset($nf);

#die(print_r($files));
        /* SECURITY NOTICE
        In order to avoid a faker to alter the content of a Link Archive by
        submitting a custom string (that could even be dangerous for SQL)
        phpMyBitTorrent does the following:
        IF RSA Security is enabled, the hidden field of the old files is simply
        encrypted with private keys.
        Else a fingerprint is attached to the form. This fingerprint is, at
        this time, generated with values that nobody should know.
        This will make impossible to alter the form input during postback.
        */
        if ($use_rsa) {
                $old_files = $rsa->encrypt(serialize($files));
        } else {
                $old_files = base64_encode(serialize($files));
                $fingerprint = crypt($old_files,$priv_key);
        }
}

		$postback			= request_var('postback', '');

if (isset($postback) AND !is_numeric($postback) AND !$postback == '') {

        if (isset($ed2klink)) {
                $file = Array();
                $torrentid = null;
                $result = checked2k($ed2klink,$file);

                if ($result == INVALID_LINK) bterror($user->lang['INVALID_EXEEM_LINK'],'ERROR_INUPLOAD',false);
                else {
                        $file["ed2k"] = "ed2k://|file|".urlencode($file["name"])."|".$file["size"]."|".strtoupper($file["hash"])."|";
                        $file["md5sum"] = $md5sum;
                        if (isset($magnetlink) AND !empty($magnetlink)) {
                                $magnetfile = Array();
                                $result = checkmagnet($magnetlink,$file["name"],$magnetfile);
                                if ($result == LINK_OK) {
									$trackers = '';
									if(preg_match_all($mg_trackers,$magnetlink,$trurl))
									{
										$trackers = "&tr=".rawurldecode(implode("&tr=", $trurl[1]));
									}
                                        $file["magnet"] = (($magnetfile["hash"] != "") ? "magnet:?xt=urn:btih:".strtoupper($magnetfile["hash"])."&dn=".$file["name"].$trackers : "magnet:?xt=urn:bitprint:".strtoupper($magnetfile["bitprint"])."&dn=".$file["name"]).$trackers;
                                        unset($magnetfile);
                                        $magnet_ok = true;
                                } else {
                                        $magnet_ok = false;
                                        if ($result == FILES_DONT_MATCH) bterror($user->lang['LINKS_FILE_NOT_MATCH'],'ERROR_INUPLOAD',false);
                                        else bterror($user->lang['INVALID_MAG_LINK'],'ERROR_INUPLOAD',false);
                                }
                        } else {
                                $magnet_ok = true;
                                $file["magnet"] = "";
                        }
                        if ($magnet_ok) {
                                //Ready to insert file but must check against duplicate!
                                $duplicate = false;
                                if (count($files) > 0) foreach ($files as $sf) if ($sf["name"] == $file["name"]) $duplicate = true;
                                if (!$duplicate) {
                                        $files[] = $file;
                                        if ($use_rsa) {
                                                $old_files = $rsa->encrypt(serialize($files));
                                        } else {
                                                $old_files = base64_encode(serialize($files));
                                                $fingerprint = crypt($old_files,$priv_key);
                                        }
                                } else bterror($user->lang['DUPLICATE_FILES_NOT_ALL'],'ERROR_INUPLOAD',false);
                                //Add file
                        } //else error has been displayed
                }
        } else bterror('INVALID_ED_LINK','ERROR_INUPLOAD',false);

}
$hiden = array();
$hiden['old_files'] = $old_files;
$hiden['op']='takelink';
$s = "<select name=\"link_category\"><option value=\"0\">(".$user->lang['CHOOSE'].")</option>\n";
$cats = genrelist2();
foreach ($cats as $cat)
{
 $s .= "<optgroup label=\"" . htmlspecialchars($cat["name"]) . "\">";
 $subcats = $cat['subcategory'];

 if (count($subcats) > 0)
 {
 foreach ($subcats as $subcat)
 {
 $s .= "<option value=\"" . $subcat["id"] . "\" ".(($link_category == $subcat["id"]) ? "selected" : "")." >" . htmlspecialchars($subcat["name"]) . "</option>\n";

 }
 }
 $s .= "</optgroup>\n";

}  
$s .= "</select>\n";
if (!$use_rsa)$hiden['fingerprint'] = $fingerprint;
$total = count($files);
$duplicate = 0;
$has_link = false;
if ($total > 0) {
        $i = 0;
        foreach ($files as $file) {
                if ($file["torrent"] != 0) $duplicate++;
           $template->assign_block_vars('links_var', array(
		   'LINK_ID'				=>	$i,
		   'LINK_NAME'				=>	$file["name"],
		   'LINK_MAGNET'			=>	$file["magnet"],
		   'LINK_ED2K'				=>	$file["ed2k"],
		   'LINK_SIZE'				=>	$file["size"],
		   'LINK_MATCH'				=>	($file["torrent"] != 0)? $file["torrent"] : false,
           ));
                $i++;
				$has_link = true;
        }

        if ($duplicate <= $total/2) $can_submit = true;

}
					
					include_once('include/function_posting.php');
					include_once('include/message_parser.php');
					include_once('include/class.bbcode.php');
				generate_smilies('inline', 0);
				$num_predefined_bbcodes = 22;
				$s_pm_icons = false;
				if (!isset($icon_id))
				{
					$icon_id = false;
				}
				if ($config['enable_pm_icons'])
				{
					$s_pm_icons = posting_gen_topic_icons('post', $icon_id);
				}
			
				$sql = 'SELECT bbcode_id, bbcode_tag, bbcode_helpline
					FROM '.$db_prefix.'_bbcodes
					WHERE display_on_posting = 1
					ORDER BY bbcode_tag';
				$result = $db->sql_query($sql);
			
				$i = 0;
				while ($row = $db->sql_fetchrow($result))
				{
					// If the helpline is defined within the language file, we will use the localised version, else just use the database entry...
					if (isset($user->lang[strtoupper($row['bbcode_helpline'])]))
					{
						$row['bbcode_helpline'] = $user->lang[strtoupper($row['bbcode_helpline'])];
					}
			
					$template->assign_block_vars('custom_tags', array(
						'BBCODE_NAME'		=> "'[{$row['bbcode_tag']}]', '[/" . str_replace('=', '', $row['bbcode_tag']) . "]'",
						'BBCODE_ID'			=> $num_predefined_bbcodes + ($i * 2),
						'BBCODE_TAG'		=> $row['bbcode_tag'],
						'BBCODE_HELPLINE'	=> $row['bbcode_helpline'],
						'A_BBCODE_HELPLINE'	=> str_replace(array('&amp;', '&quot;', "'", '&lt;', '&gt;'), array('&', '"', "\'", '<', '>'), $row['bbcode_helpline']),
					));
			
					$i++;
				}
				$db->sql_freeresult($result);
				$template->assign_vars(array(
				'TITLE_TABLE'				=> $user->lang['UPLOAD_TABLE'],
				'L_INTRO_TORRENT'			=> $user->lang['UPLOAD_LINK'],
				'L_INTRO_TORRENT_EXP'		=> $user->lang['UPLOAD_LINK_EXP'],
				'S_NAMEX'					=>	$namex,
				'S_DESCR'					=>	$descr,
				'S_IMDB'					=>	$imdb_info,
				'S_POSTER'					=>	$post_img,
				'S_SCREENA'					=>	$screen1,
				'S_SCREENB'					=>	$screen2,
				'S_SCREENC'					=>	$screen3,
				'S_SCREEND'					=>	$screen4,
				'S_CAN_SUBMIT'				=>	$can_submit,
				'HAS_LINK'					=>	$has_link,
				'S_DUPLICATE'				=>	$duplicate,
				'S_CAT_SELECT'				=>	$s,
		'ALOW_POSTER'				=> checkaccess("u_add_poster"),
		'ALOW_SCREEN_SHOT'			=> checkaccess("u_add_screen_shots"),
		'ALOW_NFO'					=> checkaccess("u_add_nfo"),
		'S_SMILIES_ALLOWED'			=> checkaccess("u_add_smiles_to_details"),
		'S_MESSAGE'					=> false,
		'S_CAT_SELECT'				=>	$s,
		'S_SHOW_SMILEY_LINK'		=> checkaccess("u_add_smiles_to_details"),
		'S_BBCODE_ALLOWED'			=> checkaccess("u_add_bbcode_details"),
		'T_TEMPLATE_PATH' 			=> 'themes/' . $theme . '/templates',
		'S_BBCODE_QUOTE'			=> checkaccess("u_add_quote_details"),
		'S_BBCODE_IMG'				=> checkaccess("u_add_imgbbcode_details"),
		'S_LINKS_ALLOWED'			=> checkaccess("u_links_in_details"),
		'S_BBCODE_FLASH'			=> checkaccess("u_flash_in_details"),
		'ALOW_NOTIFY'				=> checkaccess("u_upload_notify"),
		'ALOW_HIDE_OWNER'			=> checkaccess("u_hide_torrent_owner"),
		'ALOW_PASSWORD'				=> checkaccess("u_add_password_torrent"),
		'ALOW_ADVANCED'				=> checkaccess("u_advance_upload_setting"),
		'ALOW_RATIO_BUILD'			=> checkaccess("u_apply_ratiobuild"),
		'ALOW_STICKY'				=> checkaccess("u_add_sticky_upload"),
		'ALOW_SHOUT_NEW'			=> checkaccess("u_shout_upload"),
		'ALOW_ATTACHMENTS'			=> checkaccess("u_torrent_attach"),
		'S_HIDDEN_FIELDS'			=>	build_hidden_fields($hiden),
				));
#echo "</table><HR SIZE=1 NOSHADE><input type=\"submit\" value=\""._btfsend."\" ".((!$can_submit) ? "disabled" : "")." /></form>\n";

?>