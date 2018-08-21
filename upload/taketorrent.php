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
** File taketorrent.php 2018-02-18 14:32:00 joeroberts
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
@ini_set("upload_max_filesize",$max_torrent_size);
@set_time_limit(60);
@ini_set("memory_limit","64M");
require_once("include/bdecoder.php");
require_once("include/bencoder.php");
require_once("include/torrent_functions.php");
include_once("include/utf/utf_tools.php");
//die('test');

$torrent_edited = false;
$notice = false;
$errmsg = Array();
		$category			= request_var('torrent_category', 0);
if (!isset($_FILES["filex"]))
        $errmsg[] = $user->lang['ERROR_INUPLOAD'];
if (!$category)
{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $user->lang['NO_CAT_SELECTED'] . '<br /><br /><a href="javascript:history.go(-1)"  onMouseOver="self.status=document.referrer;return true">' . $user->lang['GO_BACK'] . '</a>',
				));
				echo $template->fetch('message_body.html');
				close_out();
}
$cats = catlist();
$in_cat = false;
while ($cat = @each($cats) AND !$in_cat) {
        if ($category == $cat[1]["id"]) $in_cat = true;
}
if (!$in_cat) $errmsg[] = $user->lang['INVALID_CATEGORY'];
		$imdb_info			= request_var('imdb_info', '');
if(strlen($imdb_info) > 1)$imdb = $db->sql_escape(stripslashes($imdb_info));
else
$imdb = '';

$f = $_FILES["filex"];
$fname = unesc($f["name"]);

if (empty($fname))
        $errmsg[] = $user->lang['EMPTY_FILE_NAME'];
if (!is_filename($fname))
        $errmsg[] = $user->lang['INVALID_VILE_NAME'];
if (!preg_match('/^(.+)\.torrent$/si', $fname, $matches))
        $errmsg[] = $user->lang['NO_TORRENT_FILE'];

$nf = $_FILES["nfox"];
$nfname = unesc($nf["name"]);
if ($nfname != "") {
        if (!is_filename($nfname))
                $errmsg[] = $user->lang['EMPTY_NFO_NAME'];
        if (!preg_match('/^(.+)\.nfo$/si', $nfname))
                $errmsg[] = $user->lang['NOT_NFO_FILE'];
        if (!is_uploaded_file($nf["tmp_name"]))
                $errmsg[] = $user->lang['NO_NFO_UPLOADED'];
        if ($nf["size"] <= 0)
                $errmsg[] = $user->lang['EMPTY_NFO_FILE'];
}

#Return Error
if (count($errmsg) > 0)
{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $user->lang['ERROR_IN_UPLOAD'] . '<br />' . implode("<br />",$errmsg) . '<br /><br /><a href="javascript:history.go(-1)"  onMouseOver="self.status=document.referrer;return true">' . $user->lang['GO_BACK'] . '</a>',
				));
				echo $template->fetch('message_body.html');
				close_out();
}
$shortfname = $torrentname = $matches[1];
$namex = utf8_normalize_nfc(request_var('namex', '',true));
if (!empty($namex))
        $torrentname = $namex;

$tmpname = $f["tmp_name"];

if (!is_uploaded_file($tmpname))
        $errmsg[] = $user->lang['NO_TORRENT_UPLOADED'];
if (!filesize($tmpname))
        $errmsg[] = $user->lang['EMPTY_TORRENT_FILE'];

#Return Error
if (count($errmsg) > 0)
{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $user->lang['ERROR_IN_UPLOAD'] . '<br />' . implode("<br />",$errmsg) . '<br /><br /><a href="javascript:history.go(-1)"  onMouseOver="self.status=document.referrer;return true">' . $user->lang['GO_BACK'] . '</a>',
				));
				echo $template->fetch('message_body.html');
				close_out();
}


$uploader_host = gethostbyaddr($_SERVER["REMOTE_ADDR"]); //uploader's hostname

#File read
$pagetorrent = "";
$fp = @fopen($tmpname,"rb");
while (!@feof($fp)) {
        $pagetorrent .= @fread($fp,1000);
}
@fclose($fp);
//Clean up invalid entries in the torrent
$pagetorrent=preg_replace('/file-mediali(.*?)ee(.*?):/i','file-mediali0ee$2:',$pagetorrent);
$pagetorrent=preg_replace('/file-durationli(.*?)ee(.*?):/i','file-durationli0ee$2:',$pagetorrent);
//Decode
$torrent = Bdecode($pagetorrent);
unset($pagetorrent);
if (!entry_exists($torrent,"info(Dictionary)"))
{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $user->lang['MISSING_INFO_DICTIONARY'],
				));
				echo $template->fetch('message_body.html');
				close_out();
}
if (!entry_exists($torrent,"announce(String)"))
{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $user->lang['MISSING_ANNOUNCE_STRING'],
				));
				echo $template->fetch('message_body.html');
				close_out();
}
$info = entry_get($torrent,"info");
$announce = entry_read($torrent,"announce(String)");


#Checking against DHT
$dht = "no";
if (entry_exists($torrent,"azureus_properties/dht_backup_enable(Integer)")) {
        if (entry_read($torrent,"azureus_properties/dht_backup_enable(Integer)") != 0) $dht = "yes";
}

$info_intact = true;

if (isset($adv_opts) AND $adv_opts == 1 OR $addprivate) {
        if (!isset($dht_support)) $dht_support = 0;
        if (!isset($private_torrent)) $private_torrent = 0;

        //If DHT Support is forced we must disable Private Flag
        $root = $torrent->first_child();
        if ($dht_support == 1) {

                $private_torrent = 2;
                if ($dht == "no") {
                        if (entry_exists($torrent,"azureus_properties")) {
                                $az_props = entry_get($torrent,"azureus_properties");
                        } else {
                                $az_props = $torrent->create_element("azureus_properties");
                                $az_props->set_attribute("type","Dictionary");
                        }
                        if (entry_exists($torrent,"dht_backup_enable")) {
                                $dht_back = $torrent->create_element("dht_backup_enable");
                                $az_props->remove_child($dht_back);
                        }
                        $dht_back = $torrent->create_element("dht_backup_enable");
                        $dht_back->set_attributes("type","Integer");
                        $enable = $torrent->create_text_node("1");
                        $dht_back->append_child($enable);
                        $az_props->append_child($dht_back);
                        foreach ($root->child_nodes() as $child) {
                                if ($child->node_name() > "azureus_properties") break;
                        }
                        $root->insert_before($az_props,$child);
                }
        } elseif ($dht_support == 2) {
                if ($dht == "yes") {
                        $aznode = entry_get($torrent,"azureus_properties");
                        $dhtnode = entry_get($torrent,"azureus_properties/dht_backup_enable");
                        $aznode->remove_child($dhtnode);
                        if (!$aznode->has_child_nodes()) $root->remove_child($aznode);

                }
        }
        unset($root);

        $priv_exists = entry_exists($torrent,"info/private(Integer)");
        $priv_enabled = ($priv_exists AND entry_read($torrent,"info/private(Integer)") == 1);

        if ($private_torrent == 1 OR $addprivate) {
		if(in_array($announce, $site_announce)){
                //Force enabling Private Torrent
                if (!$priv_enabled ) {
                        $info_intact = false;
                        if ($priv_exists) {
                                $private = entry_get($torrent,"info/private");
                                $info->remove_child($private);
                        }
                        $private = $torrent->create_element("private");
                        $private->set_attribute("type","Integer");
                        $enable = $torrent->create_text_node("1");
                        $private->append_child($enable);
                        foreach ($info->child_nodes() as $child) {
                                if ($child->node_name() > "private") break;
                        }
                        $info->append_child($private);
                }
			}
        } elseif ($private_torrent == 2) {
                if ($priv_exists) {
                        $info_intact = false;
                        $private = entry_get($torrent,"info/private");
                        $info->remove_child($private);
                }
        }
}

#Name, piece length and pieces

if (!entry_exists($torrent,"info/piece length(Integer)"))
{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $user->lang['MISSING_LENGTH_STRING'],
				));
				echo $template->fetch('message_body.html');
				close_out();
}
if (!entry_exists($torrent,"info/pieces(String)"))
{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $user->lang['MISSING_PIECES_STRING'],
				));
				echo $template->fetch('message_body.html');
				close_out();
}
$dname = (entry_exists($torrent,"info/name(String)")) ? $dname = entry_read($torrent,"info/name(String)") : "";
$plen = entry_read($torrent,"info/piece length(Integer)");
$pieces = entry_read($torrent,"info/pieces(String)");

if (strlen($pieces) % 20 != 0)
{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $user->lang['INVALID_PEASES'] . '<br /><br /><a href="javascript:history.go(-1)"  onMouseOver="self.status=document.referrer;return true">' . $user->lang['GO_BACK'] . '</a>',
				));
				echo $template->fetch('message_body.html');
				close_out();
}
unset($pieces);

$tcomment = (entry_exists($torrent,"comment(String)")) ? entry_read($torrent,"comment(String)") : "";

#Parsing Torrent Description
$descr	= utf8_normalize_nfc(request_var('descr', '',true));
if ($tcomment == "" AND (!isset($descr) OR empty($descr)))
{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $user->lang['NO_DESCR'] . '<br /><br /><a href="javascript:history.go(-1)"  onMouseOver="self.status=document.referrer;return true">' . $user->lang['GO_BACK'] . '</a>',
				));
				echo $template->fetch('message_body.html');
				close_out();
}
if ($descr == "") $descr = parsedescr($tcomment);
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
				$bbcode_status		= ($config['allow_bbcode'] && $config['auth_bbcode_pm'] && checkaccess('u_add_bbcode_details')) ? true : false;
				$smilies_status		= ($config['allow_smilies'] && $config['auth_smilies_pm'] && checkaccess('u_add_smiles_to_details')) ? true : false;
				$img_status			= ($config['auth_img_pm'] && checkaccess('u_add_imgbbcode_details')) ? true : false;
				$flash_status		= ($config['auth_flash_pm'] && checkaccess('u_flash_in_details')) ? true : false;
				$url_status			= ($config['allow_post_links'] && checkaccess('u_links_in_details')) ? true : false;
				$enable_sig			= ($config['allow_sig'] && $config['allow_sig_pm'] && checkaccess('u_sig'));
				$enable_smilies		= ($config['allow_smilies'] && checkaccess('u_add_smiles_to_details'));
				$enable_bbcode		= ($config['allow_bbcode'] && checkaccess('u_add_bbcode_details'));
				$enable_urls		= ($config['enable_urls'] && checkaccess('u_links_in_details'))?true:false;
				$message_parser = new parse_message();
				$message_parser->message = $descr;
				$bbcode_uid = $message_parser->bbcode_uid;
				$message_parser->parse($enable_bbcode, ($config['allow_post_links']) ? $enable_urls : false, $enable_smilies, $img_status, $flash_status, true, $config['allow_post_links']);
				$descr = $db->sql_escape($message_parser->message);


#Parsing Announce
$annregexp_http = "/(http[s]?+):\/\/[-\/.:_\\w]*\/announce[^\/\\s]*/i";
$annregexp_dht = "/^dht:\/\/[0-9a-f]*.dht\/announce$/i";
if (in_array($announce, $site_announce)) {
        if ($stealthmode)
		{
					$template->assign_vars(array(
						'S_ERROR'			=> true,
						'S_FORWARD'			=> false,
						'TITTLE_M'			=> $user->lang['BT_ERROR'],
						'MESSAGE'			=> $user->lang['LOCAL_TRACKER_DISABLED'] . '<br /><br /><a href="javascript:history.go(-1)"  onMouseOver="self.status=document.referrer;return true">' . $user->lang['GO_BACK'] . '</a>',
					));
					echo $template->fetch('message_body.html');
					close_out();
		} 
        $announce = "";
} elseif (preg_match($annregexp_http, $announce)) {
        $sql = "SELECT id FROM ".$db_prefix."_trackers WHERE url = '".addslashes($announce)."' AND status = 'blacklisted' LIMIT 1;";
        $res = $db->sql_query($sql);
        if ($db->sql_numrows($res) > 0)
		{
					$template->assign_vars(array(
						'S_ERROR'			=> true,
						'S_FORWARD'			=> false,
						'TITTLE_M'			=> $user->lang['BT_ERROR'],
						'MESSAGE'			=> sprintf($user->lang['TRACKER_IS_BLACK_LISTED'],$announce) . '<br /><br /><a href="javascript:history.go(-1)"  onMouseOver="self.status=document.referrer;return true">' . $user->lang['GO_BACK'] . '</a>',
					));
					echo $template->fetch('message_body.html');
					close_out();
		} 
        $db->sql_freeresult($res);
} elseif (preg_match($annregexp_dht,$announce)) {
        $dht = "yes";
} 

if(!$announce == "" AND !$allow_external)
{
					$template->assign_vars(array(
						'S_ERROR'			=> true,
						'S_FORWARD'			=> false,
						'TITTLE_M'			=> $user->lang['BT_ERROR'],
						'MESSAGE'			=> $user->lang['EXTERNAL_NOT_ALLOWED'],
					));
					echo $template->fetch('message_body.html');
					close_out();
}

#Parsing Multiple Announce
$trackers = "NULL";
$backup_tracker = "false";
if (entry_exists($torrent,"announce-list(List)")) {
//die('backup trackers not allowed');
        $trackers = Array();
        $to_check = Array();
        $announce_list = entry_read($torrent,"announce-list(List)");
        foreach ($announce_list as $group) {
                $trackers_in_group = Array();
                foreach ($group->child_nodes() as $tracker_node) {
                        $tracker = $tracker_node->get_content();
                        //If the main tracker is NOT this one, but this one APPEARS within the Announce list then we're running backup tracker
                        if (in_array($tracker, $site_announce) AND $announce != "")
						{
							$backup_tracker = "true";
						}
                        if (in_array($tracker, $site_announce))
						{
                        	unset($tracker, $tracker_node);
						}
						else
						{
							array_push($trackers_in_group,$tracker);
							array_push($to_check,"'".$tracker."'");
						}
                        	unset($tracker, $tracker_node);
                }
                array_push($trackers,$trackers_in_group);
                unset($trackers_in_group, $group);

        }
		if(count($to_check) > 0 AND !$allow_external)
		{
							$template->assign_vars(array(
								'S_ERROR'			=> true,
								'S_FORWARD'			=> false,
								'TITTLE_M'			=> $user->lang['BT_ERROR'],
								'MESSAGE'			=> $user->lang['EXTERNAL_NOT_ALLOWED'],
							));
							echo $template->fetch('message_body.html');
							close_out();
		}
		if(count($to_check) > 0)
		{
			$sql = "SELECT url FROM ".$db_prefix."_trackers WHERE url IN (".implode(", ",$to_check).") AND status = 'blacklisted';";
			$res = $db->sql_query($sql) or btsqlerror($sql);
			if ($db->sql_numrows($res) > 0)
			{
					$blacklisted_trackers = $db->sql_fetchrowset($res);
					$blacklisted_trackers = implode(",",$blacklisted_trackers);
						$template->assign_vars(array(
							'S_ERROR'			=> true,
							'S_FORWARD'			=> false,
							'TITTLE_M'			=> $user->lang['BT_ERROR'],
							'MESSAGE'			=> sprintf($user->lang['TRACKER_IS_BLACK_LISTED'],$blacklisted_trackers) . '<br /><br /><a href="javascript:history.go(-1)"  onMouseOver="self.status=document.referrer;return true">' . $user->lang['GO_BACK'] . '</a>',
						));
						echo $template->fetch('message_body.html');
						close_out();
			}
		}
        $db->sql_freeresult($res);
        unset($sql, $to_check,$announce_list, $res);
        for ($i = 0; $i < count($trackers); $i++) $trackers[$i] = implode("\n",$trackers[$i]);
        $trackers = "'".addslashes(implode("\n\n",$trackers))."'";
}


#Parsing password
$password	= request_var('password', '');
$torrentpass = $password; //Keep for URL Redirect
if ($password != "" AND $announce == "") {
        $password = "'".$db->sql_escape(stripslashes($password))."'";
} else $password = "NULL";


#Parsing files
$filelist = Array();
if (entry_exists($torrent,"info/length(Integer)")) {
        //Single file
        $totallen = entry_read($torrent,"info/length(Integer)");

        if (entry_exists($torrent,"info/sha1(String)")) {
                $sha1code = entry_read($torrent, "info/sha1(String)");
                $magnet_link = "magnet:?xt=urn:bitprint:".addslashes(hex_to_base32($sha1code))."&dn=".urlencode($dname);
        } else {
                $magnet_link = "";
        }
        if (entry_exists($torrent,"info/ed2k(String)")) {
                $ed2k = entry_read($torrent, "info/ed2k(String)");
                $ed2k_link = "ed2k://|file|".urlencode($dname)."|".$totallen."|".strtoupper(str_pad($ed2k,32,"0"))."|/";
        } else {
                $ed2k_link = "";
        }
        $filelist[] = Array($dname, $totallen, $magnet_link, $ed2k_link);
        $type = "single";
} else {
        //Multiple files
        $flist = entry_read($torrent, "info/files(List)");
        if (!isset($flist))
			{
							$template->assign_vars(array(
								'S_ERROR'			=> true,
								'S_FORWARD'			=> false,
								'TITTLE_M'			=> $user->lang['BT_ERROR'],
								'MESSAGE'			=> $user->lang['MISSING_LENGTH_STRING'],
							));
							echo $template->fetch('message_body.html');
							close_out();
			}
        if (!count($flist))
			{
							$template->assign_vars(array(
								'S_ERROR'			=> true,
								'S_FORWARD'			=> false,
								'TITTLE_M'			=> $user->lang['BT_ERROR'],
								'MESSAGE'			=> $user->lang['MISSING_INFO_DICTIONARY'],
							));
							echo $template->fetch('message_body.html');
							close_out();
			}

        foreach ($flist as $fn) {
                $ffe = "";
                $magnet_link = "";
                $ed2k_link = "";
                $children = $fn->child_nodes();
                $file = Array();
                foreach ($children as $child) {
                        $file[$child->tagname] = $child;
                }

                if (!array_key_exists("length",$file) OR !array_key_exists("path",$file))
					{
									$template->assign_vars(array(
										'S_ERROR'			=> true,
										'S_FORWARD'			=> false,
										'TITTLE_M'			=> $user->lang['BT_ERROR'],
										'MESSAGE'			=> $user->lang['MISSING_LENGTH_STRING'],
									));
									echo $template->fetch('message_body.html');
									close_out();
					}

                $ll = $file["length"]->get_content();

                $path = Array();
                foreach ($file["path"]->child_nodes() as $p) array_push($path,$p->get_content());
                $ffe = implode("/",$path);
                if (empty($ffe)) bterror('INVALID_VILE_NAME','ERROR_INUPLOAD');

                if (array_key_exists("sha1",$file)) {
                        $magnet_link = "magnet:?xt=urn:bitprint:".addslashes(hex_to_base32($file["sha1"]->get_content()))."&dn=".urlencode($path[count($path)-1]);
                }
                if (array_key_exists("ed2k",$file)) {
                        $ed2k_link = "ed2k://|file|".urlencode($path[count($path)-1])."|".$ll."|".strtoupper(str_pad($file["ed2k"]->get_content(),32,0))."|/";
                }
                unset($p, $path);

                $filelist[] = Array($ffe, $ll, $magnet_link, $ed2k_link);
                $totallen += $ll;
        }
        $type = "multi";
}

#Info Hash. The most important value
$infohash_hex = sha1(Benc($info));
$infohash = pack("H*", $infohash_hex);
unset($info);

#eXeem Alternate Link
if (isset($exeem) AND $exeem != "" AND $info_intact) {
        if (!preg_match("/exeem:\/\/[\\d]{1,2}/".$infohash_hex."*/i", $exeem)) bterror('INVALID_EXEEM_LINK','ERROR_INUPLOAD');
} else {
        $exeem = "";
}

#Torrent Owner
$owner = $user->id;
$ownertype = ($owner == 0) ? 0 : intval($ownertype);
if ($ownertype == 2) $owner = 0;
if (isset($evidence) AND $user->moderator) $evidence = 1;
else $evidence = 0;
#Checking against the SAME Torrent
if (isset($jump_check) AND $jump_check == 1) {
$sql = "SELECT id FROM ".$db_prefix."_torrents WHERE info_hash = '".$db->sql_escape(utf8_encode($infohash))."';";
$res = $db->sql_query($sql) or btsqlerror($sql);
if ($db->sql_numrows($res) > 0) {
        list ($id) = $db->fetch_array($res);
			{
							$template->assign_vars(array(
								'S_ERROR'			=> true,
								'S_FORWARD'			=> false,
								'TITTLE_M'			=> $user->lang['BT_ERROR'],
								'MESSAGE'			=> $user->lang['BANNED_TORRENT'],
							));
							echo $template->fetch('message_body.html');
							close_out();
			}
}
$db->sql_freeresult($res);
}

if (!$user->premium) {
        $sql = "SELECT count(id) as num, sum(size) as tot_size FROM ".$db_prefix."_torrents where added > sysdate() - 1000000 AND owner = '".$user->id."'";
        $res = $db->sql_query($sql) or btsqlerror($sql);
        list ($torrents, $uploaded_size) = $db->fetch_array($res);
        $db->sql_freeresult($res);

        #Checking against minimumupload size
        if ($totallen < $minupload_size_file)
			{
							$template->assign_vars(array(
								'S_ERROR'			=> true,
								'S_FORWARD'			=> false,
								'TITTLE_M'			=> $user->lang['BT_ERROR'],
								'MESSAGE'			=> sprintf($user->lang['TORRENT_TO_SMALL'],mksize($totallen),mksize($minupload_size_file)),
							));
							echo $template->fetch('message_body.html');
							close_out();
			}

        #Checking against Max num upload on 24h time
        if ($maxupload_day_num > 0 AND $maxupload_day_num <= $torrents)
			{
							$template->assign_vars(array(
								'S_ERROR'			=> true,
								'S_FORWARD'			=> false,
								'TITTLE_M'			=> $user->lang['BT_ERROR'],
								'MESSAGE'			=> sprintf($user->lang['MAX_UPLOADS_SET'],$maxupload_day_num),
							));
							echo $template->fetch('message_body.html');
							close_out();
			}

        #Max size share upload on 24h
        if ($maxupload_day_share > 0 AND $maxupload_day_share < $uploaded_size+$totallen) 
			{
							$template->assign_vars(array(
								'S_ERROR'			=> true,
								'S_FORWARD'			=> false,
								'TITTLE_M'			=> $user->lang['BT_ERROR'],
								'MESSAGE'			=> sprintf($user->lang['MAX_SHARE_MET'],$maxupload_day_share,$torrents,mksize($uploaded_size)),
							));
							echo $template->fetch('message_body.html');
							close_out();
			}
        
}

#Filename must be at least 4 chars
$materia = trim($fname);
$pos = strrpos($materia, '.');
if (!$pos===false)
        $materia = substr($materia, 0, $pos);
$search = array ("'[^\w]'",                 // Remove not letter
        "'([\r\n])[\s]+'"                 // Remove Blank space
);
$replace = array (
        " ",
        "\\1"
);
$materia = preg_replace ($search, $replace, $materia);
$materia = explode(" ", $materia);

$sql_filter = "";
foreach($materia as $x) {
        $x = trim($x);
        if(strlen($x) > 2){
                $sql_filter .= " OR keyword LIKE '".$x."'";
        }
}
$errmsg = "";
$sql_filter = "SELECT * FROM ".$db_prefix."_filter WHERE 1=0 ".$sql_filter.";";
$res = $db->sql_query($sql_filter) or btsqlerror($sql_filter);
if ($db->sql_numrows($res) > 0) {
                $errmsg = "<p align=\"center\">".$user->lang['FILTER_FAIL']."</p></br>";
              
                while ($row = $db->sql_fetchrow($res)){
                        $errmsg.= "<p align=\"center\">".htmlspecialchars($row["reason"])."</p></br>";
                }
              
                $errmsg.= "<p align=\"center\">".$user->lang['FILTER_FAIL_INFO']."</p>";
								$template->assign_vars(array(
									'S_ERROR'			=> true,
									'S_FORWARD'			=> false,
									'TITTLE_M'			=> $user->lang['BT_ERROR'],
									'MESSAGE'			=> sprintf($user->lang['ELEGALE_CONTENT'],$errmsg,$admin_email),
								));
								echo $template->fetch('message_body.html');
								close_out();
}
$db->sql_freeresult($res);

#Checking against SIMILAR files
if (isset($jump_check) AND $jump_check == 1) {
        $materia=trim($fname);
        $pos = strrpos($materia, '.');
        if (!$pos===false)
                $materia = substr($materia, 0, $pos);
        $search = array (
                 "'[^a-zA-Z]'",                 // Remove not lecter
                 "'([\r\n])[\s]+'"                 // Remove Blank space
        );
        $replace = array (
                 " ",
                 "\\1"
        );

        $materia = preg_replace ($search, $replace, $materia);
        $materia = explode(" ", $materia);

        $sql = "";
        $sql_filter = "";
        foreach($materia as $x){
                $x = trim($x);
                if(strlen($x)>=5){
                        $sql .= " OR filename LIKE '".str_replace("\'","\\\'",$x)."'";

                }
        }
        foreach ($filelist as $file) {
                $sql .= " OR size = '".$file[1]."'";
        }


        $sql = "SELECT torrent, filename, size FROM ".$db_prefix."_files WHERE 1=0 ".$sql;
        $res = $db->sql_query($sql) or btsqlerror($sql);

        $errmsg = "";
        if ($db->sql_numrows($res) > 0){
                $errmsg .= "<ul>\n";
                while ($row = $db->sql_fetchrow($res)){
                        $errmsg.= "<li><p><a href='details.php?id=".$row["torrent"]."&hit=1'>".$row["filename"]."</a> (".mksize($row["size"]).")</p></li>\n";
                }
                $errmsg .= "</ul>\n";
							$template->assign_vars(array(
								'S_ERROR'			=> true,
								'S_FORWARD'			=> false,
								'TITTLE_M'			=> $user->lang['BT_ERROR'],
								'MESSAGE'			=> sprintf($user->lang['DUPLICATE_UPLOAD'],$errmsg),
							));
							echo $template->fetch('message_body.html');
							close_out();
        }
}


#$searchtext = "".$shortfname." ". $dname." ". $descr." ".implode(" ",$filelist);

$searchtext = "".$shortfname." ". $dname." ". $descr." ";
foreach($filelist as $subarray) {
$searchtext.=implode(" ",$subarray);
}
#Parsing external tracker sources
global $force_upload; //Used to force upload even if Torrent has 0 peers or the tracker does not respond
$seeders = $leechers = $tot_peer = 0;
if($autoscrape AND $announce != "") {

        $tmp_tracker = str_replace("announce", "scrape", $announce).((strpos($announce,"?")) ? "&" : "?")."info_hash=".urlencode($infohash);
                        $scrape = getscrapedata($tmp_tracker, false,array($infohash=>preg_replace_callback('/./s', "hex_esc", str_pad($infohash,20))));
						//die();
        if ($scrape) {
                #Check data
                if (!entry_exists($scrape,"files(dictionary)","Scrape")) {
							$template->assign_vars(array(
								'S_ERROR'			=> true,
								'S_FORWARD'			=> false,
								'TITTLE_M'			=> $user->lang['BT_ERROR'],
								'MESSAGE'			=> $user->lang['INVALID_TRACKER_RESPONCE'],
							));
							echo $template->fetch('message_body.html');
							close_out();
                } elseif (!entry_exists($scrape,"files/a".$infohash_hex."(Dictionary)","Scrape")) {
							$template->assign_vars(array(
								'S_ERROR'			=> true,
								'S_FORWARD'			=> false,
								'TITTLE_M'			=> $user->lang['NOTICE'],
								'MESSAGE'			=> $user->lang['SCARPE_NOT_REG'],
							));
							$notice .= $template->fetch('message_body.html');
                } else {
                        #Check seeder
                        $seeders = entry_read($scrape,"files/a".$infohash_hex."/complete(Integer)","Scrape");
						if ($seeders <= 0 AND $force_upload)
						{
							$template->assign_vars(array(
								'S_ERROR'			=> true,
								'S_FORWARD'			=> false,
								'TITTLE_M'			=> $user->lang['NOTICE'],
								'MESSAGE'			=> $user->lang['NO_SEEDERS'],
							));
							$notice .= $template->fetch('message_body.html');
						}
                        if ($seeders <= 0 AND !$force_upload)
						{
							$template->assign_vars(array(
								'S_ERROR'			=> true,
								'S_FORWARD'			=> false,
								'TITTLE_M'			=> $user->lang['BT_ERROR'],
								'MESSAGE'			=> $user->lang['NO_SEEDERS_NOT'],
							));
							echo $template->fetch('message_body.html');
							close_out();
						}
                        $leechers = entry_read($scrape,"files/a".$infohash_hex."/incomplete(Integer)","Scrape");
                        $completed = entry_read($scrape,"files/a".$infohash_hex."/downloaded(Integer)","Scrape");
                }
                unset($scrape);
                $visible = ($tot_peer > 0) ? "yes" : "no";				
        } elseif (!$force_upload) {
							$template->assign_vars(array(
								'S_ERROR'			=> true,
								'S_FORWARD'			=> false,
								'TITTLE_M'			=> $user->lang['BT_ERROR'],
								'MESSAGE'			=> $user->lang['INVALID_TRACKER_RESPONCE'],
							));
							echo $template->fetch('message_body.html');
							close_out();
        }
} else {
                $completed = $leechers = 0;
                $visible = ($announce != "") ? "yes" : "no";
}
$build = request_var('build','no');
if($build=='' OR !$build == 'yes') $build = "no";
$post_img = request_var('post_img','');
$screen1 = request_var('screen1','');
$screen2 = request_var('screen2','');
$screen3 = request_var('screen3','');
$screen4 = request_var('screen4','');
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
#Preparing SQL
$torrentfields = Array();
$torrentvalues = Array();

$torrentfields[] = "info_hash";
$torrentvalues[] = "'".$db->sql_escape(utf8_encode($infohash))."'";

$torrentfields[] = "name";
$torrentvalues[] = "'".$db->sql_escape($torrentname)."'";

$torrentfields[] = "filename";
$torrentvalues[] = "'".$db->sql_escape($dname)."'";

$torrentfields[] = "save_as";
$torrentvalues[] = "'".$db->sql_escape($shortfname)."'";

$torrentfields[] = "md5sum";
$torrentvalues[] = "'".md5_file($tmpname)."'";

$torrentfields[] = "search_text";
$torrentvalues[] = "'".$db->sql_escape($searchtext)."'";

$torrentfields[] = "descr";
$torrentvalues[] = "'".$descr."'";

$torrentfields[] = "bbcode_bitfield";
$torrentvalues[] = "'".$message_parser->bbcode_bitfield."'";

$torrentfields[] = "bbcode_uid";
$torrentvalues[] = "'".$message_parser->bbcode_uid."'";

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
$torrentfields[] = "size";
$torrentvalues[] = "'".$totallen."'";

$torrentfields[] = "ratiobuild";
$torrentvalues[] = "'".$build."'";

$torrentfields[] = "plen";
$torrentvalues[] = "'".$plen."'";

$torrentfields[] = "category";
$torrentvalues[] = "'".intval($category)."'";

$torrentfields[] = "type";
$torrentvalues[] = "'".$type."'";

$torrentfields[] = "numfiles";
$torrentvalues[] = "'".count($filelist)."'";

$torrentfields[] = "added";
$torrentvalues[] = "NOW()";

$torrentfields[] = "exeem";
if (isset($exeem) AND $exeem != "") $torrentvalues[] = "'".$exeem."'";
else $torrentvalues[] = "NULL";

$torrentfields[] = "dht";
$torrentvalues[] = "'".$dht."'";

$torrentfields[] = "backup_tracker";
$torrentvalues[] = "'".$backup_tracker."'";

$torrentfields[] = "views";
$torrentvalues[] = "'0'";

$torrentfields[] = "downloaded";
$torrentvalues[] = "'0'";

$torrentfields[] = "completed";
$torrentvalues[] = "'".$completed."'";

$torrentfields[] = "banned";
$torrentvalues[] = "'no'";

$torrentfields[] = "password";
$torrentvalues[] = $password;

$torrentfields[] = "visible";
$torrentvalues[] = "'".$visible."'";

$torrentfields[] = "evidence";
$torrentvalues[] = "'".intval($evidence)."'";

$torrentfields[] = "owner";
$torrentvalues[] = "'".intval($owner)."'";

$torrentfields[] = "ownertype";
$torrentvalues[] = "'".intval($ownertype)."'";

$torrentfields[] = "uploader_host";
$torrentvalues[] = "'".$uploader_host."'";

$torrentfields[] = "numratings";
$torrentvalues[] = "'0'";

$torrentfields[] = "ratingsum";
$torrentvalues[] = "'0'";

$torrentfields[] = "seeders";
$torrentvalues[] = "'".intval($seeders)."'";

$torrentfields[] = "leechers";
$torrentvalues[] = "'".intval($leechers)."'";

$torrentfields[] = "tot_peer";
$torrentvalues[] = "'".intval($seeders+$leechers)."'";

$torrentfields[] = "speed";
$torrentvalues[] = "'0'";

$torrentfields[] = "comments";
$torrentvalues[] = "'0'";

$torrentfields[] = "complaints";
$torrentvalues[] = "'0,0'";

$torrentfields[] = "tracker";
if ($announce == "") $torrentvalues[] = "NULL";
else $torrentvalues[] = "'".$announce."'";

$torrentfields[] = "tracker_list";
$torrentvalues[] = $trackers;

$torrentfields[] = "tracker_update";
$torrentvalues[] = "NOW()";

$torrentfields[] = "last_action";
$torrentvalues[] = "NOW()";

if(strlen($imdb) > 1){
$torrentfields[] = "imdb";
$torrentvalues[] = "'".$imdb."'";
}


$torrentsql = "INSERT INTO ".$db_prefix."_torrents (".implode(", ",$torrentfields).") VALUES (".implode(", ",$torrentvalues).");";
//die($torrentsql);

$db->sql_query($torrentsql) or btsqlerror($torrentsql);
$id = $db->sql_nextid();

if ($announce != ""){ 
$db->sql_query("INSERT INTO ".$db_prefix."_trackers (url, updated) VALUES ('".addslashes($announce)."', NOW());");
}
$db->sql_query("DELETE FROM ".$db_prefix."_files WHERE torrent = '".$id."'") or btsqlerror("DELETE FROM ".$db_prefix."_files WHERE torrent = '$id'");
$sql_ary = array();
foreach ($filelist as $file) {
        list ($fname, $fsize, $magnet, $ed2k) = $file;
        if ($magnet != "") {
                $magnet = $db->sql_escape($magnet);
        }
		else
		{
                $magnet = NULL;
		}
        if ($ed2k != "") {
                $ed2k = $db->sql_escape($ed2k);
        }
		else
		{
                $ed2k = NULL;
		}
	$sql_ary[] = array(
		'torrent'		=> (int) $id,
		'filename'		=> $db->sql_escape($fname),
		'size'		=> (int) $fsize,
		'magnet'	=> $magnet,
		'ed2k'	=> $ed2k,
	);
}
//die(print_r($sql_ary));
        if (!$db->sql_multi_insert($db_prefix . '_files', $sql_ary)) { //Rollback
                $db->sql_query("DELETE FROM ".$db_prefix."_torrents WHERE id = '".$id."' LIMIT 1;");
                $db->sql_query("DELETE FROM ".$db_prefix."_files WHERE torrent = '".$id."';");
				
                btsqlerror($filesql);
        }

$torrentpath = $torrent_dir."/".$id.".torrent";
if (file_exists($torrentpath)) unlink($torrentpath);

$fp = fopen($torrentpath,"wb");
fwrite($fp,Bencode($torrent));
fclose($fp);
@unlink($tmpname);

$nfopath = "$torrent_dir/".$id.".nfo";
if (file_exists($nfopath)) unlink($nfopath);
if (!empty($nfname)) move_uploaded_file($nf["tmp_name"],$nfopath);
$url = "details.php?id=".$id."&upcomplete=1";
if ($password != "NULL") { //Password is included in SQL Statement
        $url .= "&password=".$torrentpass;
}
if (!$info_intact) { //If Info Hash changed the user MUST re-download the Torrent to use it
        $url .= "&upload_notice=1";
}
$meta = meta_refresh(3,$url);
if($user->user)
{
                        $bon = "SELECT active, upload FROM ".$db_prefix."_bonus_points ;";
                        $bonset = $db->sql_query($bon);
                        list ($active, $upload_point) = $db->fetch_array($bonset);
                        $db->sql_freeresult($bonset);
	if($active=='true')
	{
	$do="UPDATE ".$db_prefix."_users SET seedbonus = seedbonus + '".$upload_point."' WHERE id= ".$user->id."" ;
	$db->sql_query($do) or btsqlerror($do);
	}
}
		$shout			= request_var('shout', 0);
if(checkaccess("u_shout_upload") AND $shout){
				$mesg = sprintf($user->lang['SHOUT_NEW_UPLOAD'],$siteurl,$id,$torrentname);
				$up_shout = new parse_message();
				$up_shout->message = $mesg;
				$up_shout->parse(true, true, true, true, false, true,true);
				$mesg = $db->sql_escape(stripslashes($up_shout->message));
				$sql = "INSERT INTO ".$db_prefix."_shouts (user, text, posted, bbcode_bitfield, bbcode_uid) VALUES ('".$user->id."', '".$mesg."', NOW(), '" . $up_shout->bbcode_bitfield . "', '" . $up_shout->bbcode_uid . "');";
				$db->sql_query($sql);
}


$msg[] = sprintf($user->lang['SUCCESS_UPLOAD_COMPL'],$url);
$msg = array();
if (isset($commnotify)){
        $sql = "INSERT INTO ".$db_prefix."_comments_notify (torrent, user) VALUES ('".$id."', ".$user->id.")";
        $db->sql_query($sql) or btsqlerror($sql);
$msg[] = $user->lang['NOTIVY_NEW_COMMENT'];
}
if (isset($seednotify) AND $announce == "") {
        $sql = "INSERT INTO ".$db_prefix."_seeder_notify (torrent, user) VALUES ('".$id."', ".$user->id.")";
        $db->sql_query($sql) or btsqlerror($sql);
$msg[] = $user->lang['NOTIFY_NEW_SEED'];
}
							$template->assign_vars(array(
								'S_NOTICE'			=> true,
								'S_ERROR'			=>	false,
								'META'				=>	$meta,
								'L_MESSAGE'			=> $user->lang['SUCCESS'],
								'S_ERROR_MESS'			=> implode("<br />",$msg),
							));
?>