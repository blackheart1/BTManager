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
** File takelink.php 2018-02-18 14:32:00 joeroberts
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
		$namex				= utf8_normalize_nfc(request_var('namex', '',true));
		$descr				= utf8_normalize_nfc(request_var('descr', '',true));
		$imdb_info			= request_var('imdb_info', '');
		$post_img			= request_var('post_img', '');
		$screen1			= request_var('screen1', '');
		$screen2			= request_var('screen2', '');
		$screen3			= request_var('screen3', '');
		$screen4			= request_var('screen4', '');
		$jump_check			= request_var('screen4', '');
		$shout				= request_var('shout', 0);
		$evidence			= request_var('evidence', 0);
		$commnotify			= request_var('commnotify',0);
		$old_files			= request_var('old_files','');
		$link_category		= request_var('link_category',0);
		$submit				= request_var('submit','');
if (isset($postback) AND $submit == '') {
	$template->assign_vars(array(
		'S_ACTION'					=> 'link',
	));

        require_once("upload/link.php");
} else {
        /*
        VULNERABILITY REPORT

        AT THIS TIME, LINKS ARE NOT RE-CHECKED AGAINST VALIDITY AND DUPLICATE
        ENTRIES. A MALICIOUS USER IS STILL ABLE TO HACK THE INPUT FORM AND SEND
        BAD DATA. THIS MAY RESULT IN BAD DISPLAYING OF THE COLLECTION, THAT HAS
        SIMPLY TO BE DELETED BY THE ADMINISTRATOR
        */
        //Upload section
        $errmsg = Array();
        if (!isset($namex) OR $namex == "") $errmsg[] = $user->lang['EMPTY_FILE_NAME'];
        if (!isset($descr) OR $descr == "") $errmsg[] = $user->lang['NO_DESCR'];
        if (!isset($link_category)) $link_category = 0;

        $cats = catlist();
        $in_cat = false;
        while ($cat = each($cats) AND !$in_cat) if ($link_category == $cat[1]["id"]) $in_cat = true;
        if (!$in_cat) $errmsg[] = $user->lang['NO_CAT_SELECTED'];

        if ($old_files == '') $errmsg[] = $user->lang['ADD_FILE_FIRST'];

if(isset($post_img) && $post_img != ''){
		if (!preg_match('#^(https?://).*?\.(gif|jpg|jpeg|png)$#i', $post_img, $match))
		{
							$template->assign_vars(array(
								'S_ERROR'			=> true,
								'S_FORWARD'			=> false,
								'TITTLE_M'			=> $user->lang['BT_ERROR'],
								'MESSAGE'			=> $user->lang['INVALID_POSTER_URL'],
							));
							echo $template->fetch('message_body.html');
							close_out();
		}
		if (empty($match[2]))
		{
							$template->assign_vars(array(
								'S_ERROR'			=> true,
								'S_FORWARD'			=> false,
								'TITTLE_M'			=> $user->lang['BT_ERROR'],
								'MESSAGE'			=> $user->lang['INVALID_POSTER_TYPE'],
							));
							echo $template->fetch('message_body.html');
							close_out();
		}
$post_img = "'".$db->sql_escape(stripslashes($post_img))."'";
}
else
$post_img = "NULL";
if(isset($screen1) && $screen1 != ''){
		if (!preg_match('#^(https?://).*?\.(gif|jpg|jpeg|png)$#i', $screen1, $match))
		{
							$template->assign_vars(array(
								'S_ERROR'			=> true,
								'S_FORWARD'			=> false,
								'TITTLE_M'			=> $user->lang['BT_ERROR'],
								'MESSAGE'			=> $user->lang['INVALID_SCREEN_URL'],
							));
							echo $template->fetch('message_body.html');
							close_out();
		}
		if (empty($match[2]))
		{
							$template->assign_vars(array(
								'S_ERROR'			=> true,
								'S_FORWARD'			=> false,
								'TITTLE_M'			=> $user->lang['BT_ERROR'],
								'MESSAGE'			=> $user->lang['INVALID_SCREEN_TYPE'],
							));
							echo $template->fetch('message_body.html');
							close_out();
		}
$screen1 = "'".$db->sql_escape(stripslashes($screen1))."'";
}
else
$screen1 = "NULL";
if(isset($screen2) && $screen2 != ''){
		if (!preg_match('#^(https?://).*?\.(gif|jpg|jpeg|png)$#i', $screen2, $match))
		{
							$template->assign_vars(array(
								'S_ERROR'			=> true,
								'S_FORWARD'			=> false,
								'TITTLE_M'			=> $user->lang['BT_ERROR'],
								'MESSAGE'			=> $user->lang['INVALID_SCREEN_URL'],
							));
							echo $template->fetch('message_body.html');
							close_out();
		}
		if (empty($match[2]))
		{
							$template->assign_vars(array(
								'S_ERROR'			=> true,
								'S_FORWARD'			=> false,
								'TITTLE_M'			=> $user->lang['BT_ERROR'],
								'MESSAGE'			=> $user->lang['INVALID_SCREEN_TYPE'],
							));
							echo $template->fetch('message_body.html');
							close_out();
		}
$screen2 = "'".$db->sql_escape(stripslashes($screen2))."'";
}
else
$screen2 = "NULL";
if(isset($screen3) && $screen3 != ''){
		if (!preg_match('#^(https?://).*?\.(gif|jpg|jpeg|png)$#i', $screen3, $match))
		{
							$template->assign_vars(array(
								'S_ERROR'			=> true,
								'S_FORWARD'			=> false,
								'TITTLE_M'			=> $user->lang['BT_ERROR'],
								'MESSAGE'			=> $user->lang['INVALID_SCREEN_URL'],
							));
							echo $template->fetch('message_body.html');
							close_out();
		}
		if (empty($match[2]))
		{
							$template->assign_vars(array(
								'S_ERROR'			=> true,
								'S_FORWARD'			=> false,
								'TITTLE_M'			=> $user->lang['BT_ERROR'],
								'MESSAGE'			=> $user->lang['INVALID_SCREEN_TYPE'],
							));
							echo $template->fetch('message_body.html');
							close_out();
		}
$screen3 = "'".$db->sql_escape(stripslashes($screen3))."'";
}
else
$screen3 = "NULL";
if(isset($screen4) && $screen4 != ''){
		if (!preg_match('#^(https?://).*?\.(gif|jpg|jpeg|png)$#i', $screen4, $match))
		{
							$template->assign_vars(array(
								'S_ERROR'			=> true,
								'S_FORWARD'			=> false,
								'TITTLE_M'			=> $user->lang['BT_ERROR'],
								'MESSAGE'			=> $user->lang['INVALID_SCREEN_URL'],
							));
							echo $template->fetch('message_body.html');
							close_out();
		}
		if (empty($match[2]))
		{
							$template->assign_vars(array(
								'S_ERROR'			=> true,
								'S_FORWARD'			=> false,
								'TITTLE_M'			=> $user->lang['BT_ERROR'],
								'MESSAGE'			=> $user->lang['INVALID_SCREEN_TYPE'],
							));
							echo $template->fetch('message_body.html');
							close_out();
		}
$screen4 = "'".$db->sql_escape(stripslashes($screen4))."'";
}
else
$screen4 = "NULL";
        if (!empty($errmsg)) {
				$template->assign_vars(array(
				'S_NOTICE'				=>	true,
				'S_ERROR'				=>	true,
				'L_MESSAGE'				=>	$user->lang['ERROR_INUPLOAD'],
				'S_ERROR_MESS'			=>	implode('<br />',$errmsg),
				'S_ACTION'					=> 'link',
				));
                //bterror($errmsg,'ERROR_INUPLOAD',false);
                require_once("upload/link.php");
        }
		else
		{
        //Now we can proceed

        if ($use_rsa) $files = unserialize($rsa->decrypt($old_files));
        else $files = unserialize(base64_decode($old_files));
        if (!$files) bterror("INVALID_MAG_LINK",'ERROR_INUPLOAD');

        preg_match_all('/([\\w]{6,}+)/', $descr, $search_descr);
        preg_match_all('/([\\w]{6,}+)/', $namex, $search_name);
        $searchtext = implode(" ",$search_descr[0])." ".implode(" ",$search_name[0]);
				if ($allow_html) {
					if (preg_match("/<[^>]* (on[a-z]*[.]*)=[^>]*>/i", $descr)) //HTML contains Javascript EVENTS. Must refuse
						{
										$template->assign_vars(array(
											'S_ERROR'			=> true,
											'S_FORWARD'			=> false,
											'TITTLE_M'			=> $user->lang['BT_ERROR'],
											'MESSAGE'			=> $user->lang['NO_HTML_ALLOWED'] . '<br /><br /><a href="javascript:history.go(-1)"  onMouseOver="self.status=document.referrer;return true">' . $user->lang['GO_BACK'] . '</a>',
										));
										echo $template->fetch('message_body.html');
										close_out();
						}
				}
				if (preg_match('/<a[^>]* href="[^"]*(javascript|vbscript):[^>]*>/i', $descr)) //HTML contains Javascript or VBScript calls. Must refuse
					{
									$template->assign_vars(array(
										'S_ERROR'			=> true,
										'S_FORWARD'			=> false,
										'TITTLE_M'			=> $user->lang['BT_ERROR'],
										'MESSAGE'			=> $user->lang['NO_JAVA_ALLOW'] . '<br /><br /><a href="javascript:history.go(-1)"  onMouseOver="self.status=document.referrer;return true">' . $user->lang['GO_BACK'] . '</a>',
									));
									echo $template->fetch('message_body.html');
									close_out();
					}
				
				include_once('include/function_posting.php');
				include_once('include/message_parser.php');
				include_once('include/class.bbcode.php');
				$bbcode_status		= ($config['allow_bbcode'] && $config['auth_bbcode_pm'] && checkaccess('add_bbcode_details')) ? true : false;
				$smilies_status		= ($config['allow_smilies'] && $config['auth_smilies_pm'] && checkaccess('add_smiles_to_details')) ? true : false;
				$img_status			= ($config['auth_img_pm'] && checkaccess('add_imgbbcode_details')) ? true : false;
				$flash_status		= ($config['auth_flash_pm'] && checkaccess('flash_in_details')) ? true : false;
				$url_status			= ($config['allow_post_links'] && checkaccess('links_in_details')) ? true : false;
				$enable_sig			= ($config['allow_sig'] && $config['allow_sig_pm'] && checkaccess('u_sig'));
				$enable_smilies		= ($config['allow_smilies'] && checkaccess('add_smiles_to_details'));
				$enable_bbcode		= ($config['allow_bbcode'] && checkaccess('add_bbcode_details'));
				$enable_urls		= ($config['enable_urls'] && checkaccess('links_in_details'))?true:false;
				$message_parser = new parse_message();
				$message_parser->message = $descr;
				$bbcode_uid = $message_parser->bbcode_uid;
				$message_parser->parse($enable_bbcode, ($config['allow_post_links']) ? $enable_urls : false, $enable_smilies, $img_status, $flash_status, true, $config['allow_post_links']);
				$descr = $db->sql_escape(stripslashes($descr));

        $numfiles = count($files);
        $size = 0;
		/*
magnet:?xt=urn:btih:A5A0DCEFA6402E5AEFF1FA91EB6A796306F4FCA0&dn=Terms.And.Conditions.May.Apply.2013.HDRip.XviD.AC3-FooKaS
&tr=udp://tracker.openbittorrent.com:80
&tr=udp://tracker.publicbt.com:80
&tr=udp://tracker.istole.it:6969
&tr=udp://tracker.ccc.de:80&tr
Buma Diminsata histern - User		*/
		preg_match_all("/tr=(?P<track>[^&\\s]*)/s",$files[0]['magnet'],$match);
		die(print_r(array_unique($match['track'])));

        foreach ($files as $file) {
                //Should check the rest
                $size += $file["size"];
        }

        $sqlfields = Array();
        $sqlvalues = Array();

        $sqlfields[] = "info_hash";
        $sqlvalues[] = "NULL";

        $sqlfields[] = "name";
        $sqlvalues[] = "'".addslashes($namex)."'";

        $sqlfields[] = "search_text";
        $sqlvalues[] = "'".addslashes($searchtext)."'";

        $sqlfields[] = "descr";
        $sqlvalues[] = "'".addslashes($descr)."'";

        $sqlfields[] = "category";
        $sqlvalues[] = "'".intval($link_category)."'";

        $sqlfields[] = "size";
        $sqlvalues[] = "'".addslashes($size)."'";

        $sqlfields[] = "type";
        $sqlvalues[] = "'link'";

        $sqlfields[] = "numfiles";
        $sqlvalues[] = "'".$numfiles."'";

        $sqlfields[] = "added";
        $sqlvalues[] = "NOW()";

        $sqlfields[] = "visible";
        $sqlvalues[] = "'yes'";

        $sqlfields[] = "owner";
        $sqlvalues[] = "'".$user->id."'";

        $sqlfields[] = "ownertype";
        $sqlvalues[] = "'0'";

        $sqlfields[] = "uploader_host";
        $sqlvalues[] = "'".getip()."'";

		if(strlen($imdb) > 1){
			$torrentfields[] = "imdb";
			$torrentvalues[] = "'".$imdb."'";
		}

		// Poster Modd
		$torrentfields[] = "post_img";
		$torrentvalues[] = $post_img;

		//ScreenShot Modd
		$torrentfields[] = "screan1";
		$torrentvalues[] = $screen1;
		
		$torrentfields[] = "screan2";
		$torrentvalues[] = $screen2;
		
		$torrentfields[] = "screan3";
		$torrentvalues[] = $screen3;
		
		$torrentfields[] = "screan4";
		$torrentvalues[] = $screen4;
		
		//End mods
        $sql_collection = "INSERT INTO ".$db_prefix."_torrents (".implode(", ",$sqlfields).") VALUES (".implode(", ",$sqlvalues).");";
        if (!$db->sql_query($sql_collection)) btsqlerror($sql_collection);

        $tid = $db->sql_nextid();

        foreach ($files as $file) {
                $sqlfields = Array();
                $sqlvalues = Array();

                $sqlfields[] = "torrent";
                $sqlvalues[] = "'".$tid."'";

                $sqlfields[] = "filename";
                $sqlvalues[] = "'".addslashes($file["name"])."'";

                $sqlfields[] = "size";
                $sqlvalues[] = "'".addslashes($file["size"])."'";

                $sqlfields[] = "md5sum";
                $sqlvalues[] = ((!empty($file["md5sum"])) ? "'".addslashes($file["md5sum"])."'" : "NULL");

                $sqlfields[] = "ed2k";
                $sqlvalues[] = "'".addslashes($file["ed2k"])."'";

                $sqlfields[] = "magnet";
                $sqlvalues[] = ((!empty($file["magnet"])) ? "'".addslashes($file["magnet"])."'" : "NULL");

                $sql_file = "INSERT INTO ".$db_prefix."_files (".implode(", ",$sqlfields).") VALUES (".implode(", ",$sqlvalues).");";
                if (!$db->sql_query($sql_file)) {
                        $sql_query("DELETE FROM ".$db_prefix."_files WHERE torrent = '".$tid."';");
                        $sql_query("DELETE FROM ".$db_prefix."_torrents WHERE id = '".$tid."';");
                        btsqlerror($sql_file);
                }
        }
        $url = "details.php?id=".$tid."&upcomplete=1";
		meta_refresh(6, $url);

$msg = array();
$msg[] = sprintf($user->lang['SUCCESS_UPLOAD_COMPL'],$url);

        if ($commnotify){
                $sql = "INSERT INTO ".$db_prefix."_comments_notify (torrent, user) VALUES ('".$tid."', ".$user->id.")";
                $db->sql_query($sql) or btsqlerror($sql);

				$msg[] = $user->lang['NOTIVY_NEW_COMMENT'];
        }
				$template->assign_vars(array(
				'S_NOTICE'				=>	true,
				'S_ERROR'				=>	false,
				'L_MESSAGE'				=>	$user->lang['SUCCESS'],
				'S_ERROR_MESS'			=>	implode('<br />',$msg),
				));
		}
}
?>
