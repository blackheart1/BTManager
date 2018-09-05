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
** File torrent_functions.php 2018-02-18 14:32:00 joeroberts
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
function generate_torrentpager($link, $page, $pages, $cat = false, $sort1 = '', $sort2 = '', $extra = ''){
global $template;
           $template->assign_vars(array(
		   'TOTTAL_PAGES'.$extra  =>  $pages,
		   'CURENT_PAGE'.$extra  =>  $page,
		   ));

				if($page < $pages AND $cat) {
           $template->assign_vars(array(
		   'NEXT_PAGE'.$extra  =>  ($page+1)."&cat=".$cat.$sort1,
		   ));
                } elseif($page < $pages ) {
           $template->assign_vars(array(
		   'NEXT_PAGE'.$extra  =>  ($page+1).$sort1,
		   ));
						
                }else{
           $template->assign_vars(array(
		   'NEXT_PAGE'.$extra  =>  false,
		   ));
				}
				if($page > 1 AND $cat) {
           $template->assign_vars(array(
		   'PREV_PAGE'.$extra  =>  "page=".($page-1)."&cat=".$cat.$sort1,
		   ));
                } elseif($page > 1) {
           $template->assign_vars(array(
		   'PREV_PAGE'.$extra  =>  ($page-1).$sort1,
		   ));
						
                }else{
           $template->assign_vars(array(
		   'PREV_PAGE'.$extra  =>  false,
		   ));
				}
                if($cat){
                $pager = "<a href=\"" . $link . "".$cat.$sort1."\">".(($page == 1) ? "<strong>1</strong>" : "1")."</a><span class=\"page-sep\">, </span>";

                if (($page - 5) > 1) $pager .= "...";

                for ($i = max(2,$page - 5); $i < min($pages, $page + 5); $i++) {
                        $pager .= "<a href=\"" . $link . "".$i."&cat=".$cat.$sort1."\">".(($i == $page) ? "<strong>".$i."</strong>" : $i)."</a><span class=\"page-sep\">, </span>";
                }
                if (($page + 5) < $pages) $pager .= "...";
                $pager .= "<a href=\"" . $link . "".$pages."&cat=".$cat.$sort1."\">".(($page == $pages) ? "<strong>".$pages."</strong>" : $pages)."</a>";
           $template->assign_vars(array(
		   'GENERATED_PAGES'.$extra  =>  "<span>".(($pages > 1) ? $pager : "")."</span>",
		   ));
				}else {
                $pager = "<a href=\"" . $link . "".$sort2."\">".(($page == 1) ? "<strong>1</strong>" : "1")."</a><span class=\"page-sep\">, </span>";

                if (($page - 5) > 1) $pager .= "...";

                for ($i = max(2,$page - 5); $i < min($pages, $page + 5); $i++) {
                        $pager .= "<a href=\"" . $link . "".$i.$sort1."\">".(($i == $page) ? "<strong>".$i."</strong>" : $i)."</a><span class=\"page-sep\">, </span>";
                }
                if (($page + 5) < $pages) $pager .= "...";
                $pager .= "<a href=\"" . $link . "".$pages.$sort1."\">".(($page == $pages) ? "<strong>".$pages."</strong>" : $pages)."</a>";
           $template->assign_vars(array(
		   'GENERATED_PAGES'.$extra  =>  "<span>".(($pages > 1) ? $pager : "")."</span>",
		   ));
				}
}
function get_tor_id_from_has($hash)
{
        global $db, $db_prefix, $user;
                $sql = "SELECT id FROM ".$db_prefix."_torrents WHERE info_hash = '".addslashes($hash)."' LIMIT 1;";
                $trkres = $db->sql_query($sql);
                if (!$trkrow = $db->sql_fetchrow($trkres)) 
				{
					return '0';
				}
				else
				{
					return $trkrow[0];
				}
}
function get_tor_name_from_has($hash)
{
        global $db, $db_prefix, $user;
                $sql = "SELECT name FROM ".$db_prefix."_torrents WHERE info_hash = '".$db->sql_escape($hash)."' LIMIT 1;";
                $trkres = $db->sql_query($sql);
                if (!$trkrow = $db->fetch_array($trkres)) 
				{
					return $user->lang['UNKNOWN'];
				}
				else
				{
				// die(print_r($trkrow));
					return $trkrow[0];
				}
}
function get_tor_vars($res, $variant = "index", $user = "", $block = "", $extra = '') {
        global $db, $template, $name, $search, $user, $download_level, $torrent_global_privacy, $onlysearch, $db_prefix, $autoscrape, $theme, $btback1, $btback2, $btback3, $free_dl,$page, $prev, $pages, $pager, $next;
        while ($row = $db->sql_fetchrow($res))
		{       #Category
                if (isset($row["cat_name"])) {
                        if (isset($row["cat_pic"]) AND $row["cat_pic"] != "" AND is_readable("themes/".$theme."/pics/cat_pics/".$row["cat_pic"]))
						{
                                $catimg = "themes/".$theme."/pics/cat_pics/".$row["cat_pic"];
                                $catigory = "<img border=\"0\" src=\"themes/" . $theme . "/pics/cat_pics/". $row["cat_pic"] . "\" alt=\"" . $row["cat_name"] . "\" >";
						}
                        elseif (isset($row["cat_pic"]) AND $row["cat_pic"] != "" AND is_readable("cat_pics/".$row["cat_pic"]))
						{
                                $catimg = "cat_pics/".$row["cat_pic"];
                                $catigory =  "<img border=\"0\" src=\"cat_pics/" . $row["cat_pic"] . "\" alt=\"" . $row["cat_name"] . "\" >";
						}
                        else
                                $catigory =  $row["cat_name"];
                } else $catigory =  "-";
				#ShortName
                $dispname = htmlspecialchars($row["name"]);
                $dispname = str_replace("_", " ", $dispname);
                $dispname = str_replace(".", " ", $dispname);
                //Permission Administration
				$alt = $auth_link = $pic = '';
                if ($torrent_global_privacy AND $user->user AND $row["type"] != "link") {
                        if ($row["owner"] == $user->id) {
                                $pic = "auth_none.gif";
								$alt = 'AUTH_PENDING_NONE';
                                $authsql = "SELECT status FROM ".$db_prefix."_privacy_file WHERE torrent = '".$row["id"]."' AND status = 'pending';";
                                $authres = $db->sql_query($authsql) or btsqlerror($authsql);
                                if ($db->sql_numrows($authres) > 0)
								{
									$pic = "auth_pending.gif";
									$alt = 'AUTH_PENDING';
								}
								//echo $pic;
                                $auth_link = pic($pic,"mytorrents.php?op=displaytorrent&id=".$row["id"],$user->lang[$alt]);
                        } elseif (!can_download($user,$row)) {
                                $authres = $db->sql_query("SELECT status FROM ".$db_prefix."_privacy_file WHERE torrent = '".$row["id"]."' AND slave = '".$user->id."' LIMIT 1;");
                                if ($db->sql_numrows($authres) == 0) $auth_link = pic("lock_request.gif","details.php?op=authorization&id=".$row["id"],$user->lang['ALT_LOCKED_T_REQ']);
                                else $auth_link = pic("lock.gif",null,$user->lang['ALT_LOCKED_T']);
                        }
                }
				#Rating
                if (!isset($row["rating"]))
                        $rating = pic("0-rating.png");
                else {
                        $rating = round($row["rating"] * 2) / 2;
                        $rating = ratingpic($row["rating"]);
                        if (!isset($rating))
                                $rating = pic("0-rating.png");
                }
				#Snatched
                $totsql = "SELECT count(`torrentid`)as `snatch` FROM `".$db_prefix."_snatched` WHERE `torrentid` = '".$row["id"]."'";
                $totres = $db->sql_query($totsql);
                $sncount = $db->sql_fetchrow($totres);
				#Peer speed
				$speed_leech = "--";
				$edt = "--";
                if ($row["type"] != "link" AND $row["tracker"] == "") {
                        if ($row["leechers"] > 0 AND $row["speed"] > 0) {
                                $ro = $row["seeders"]/$row["leechers"];
                                $speed_leech = ($ro == 0) ? round($row["speed"]/$row["leechers"]) : min($row["speed"],round($row["speed"]*$ro));
                                $edt_m = ($row["size"] / $speed_leech)/60; //to minutes
                                $edt = ($edt_m % 60)."m"; //minutes
                                $edt_h = floor($edt_m / 60);
                                if ($edt_h>0) $edt = $edt_h."h ".$edt;
                                $speed_leech = mksize($speed_leech)."/s";
                        } else {
                                $speed_leech = "--";
                                $edt = "--";
                        }
                }

		$refreshable = false;
		if ($row["tracker"] != "") {
			if ($user->user){
				if ((time()- sql_timestamp_to_unix_timestamp($row["tracker_update"]))> 1800) {
				$refreshable = true;
				}else{
				$refreshable = false;
				}
			}elseif ($user->moderator){
				$refreshable = true;
			}else{
				$refreshable = false;
               		}
		}
		$can_edit=$can_delete=true;
		$can_ban = false;
		if ($row['owner'] == $user->id AND !checkaccess("u_edit_own_torrents"))
		{
		$can_edit=false;
		} 
		if ($row['owner'] == $user->id AND !checkaccess("u_delete_own_torrents"))
		{
		$can_delete=false;
		} 
		if ($row['owner'] != $user->id AND !checkaccess("m_delete_others_torrents"))
		{
		$can_delete=false;
		} 
		if ($row['owner'] != $user->id AND !checkaccess("m_can_edit_others_torrents"))
		{
		$can_edit=false;
		} 
		if (checkaccess("m_bann_torrents"))$can_ban = true;
           $template->assign_block_vars('torrent_var'.$extra, array(
		   'ID'          => $row["id"],
		   'CAN_EDIT'    => ($can_edit) ? true : false,
		   'CAN_DEL'     => ($can_delete) ? true : false,
		   'CAN_BAN'     => ($can_ban) ? true : false,
		   'CAT_ID'      => $row["category"],
		   'CAT_PID'      => $row["parent_id"],
		   'CATEGORY'    => $catigory,
		   'CAT_PIC'		=> $catimg,
		   'REFRESH_T'   => $refreshable,
		   'FREE_DL'     => ($row["ratiobuild"] == "yes" || $free_dl) ? true : false,
		   'NUKED'       => ($row["nuked"] == "yes") ? true : false,
		   'EVIDENCE'    => ($row["evidence"] != 0) ? true :false,
		   'BANNED'      => ($row["banned"] == "yes") ?  true : false,
		   'LINK'        => ($row["type"]=="link") ? true : false,
		   'TRACKER_URL' => $row["tracker"],
		   'LOCAL_T'     => ($row["tracker"] != "" AND $row["tracker"] != "dht:") ? false : true,
		   'DHT_INABLED' => ($row["dht"] == "yes") ? true : false,
		   'SHORTNAME'   => ((strlen($dispname) <= 21) ? search_word($dispname, $search): search_word(substr($dispname,0,20)."...", $search)),
		   'FULL_NAME'   => $dispname,
		   'TIMES_T_DOWNLOADED'   => $row["downloaded"],
		   'HIT_COUNT'   => ($row["owner"] != $user->id) ? true: false,
		   'CAN_DOWN_LOAD' => ((checkaccess("u_download")) AND $row["type"] != "link") ? true : false,
		   'PEERS_UPDATE'  => (($row["tracker"] != "") AND ((time()- sql_timestamp_to_unix_timestamp($row["tracker_update"]))> 1800)) ? true : false,
		   'LAST_TIME_SCR' => get_formatted_timediff(sql_timestamp_to_unix_timestamp($row["tracker_update"])),
		   'AUTH_LINK'     => $auth_link,
		   'NEED_AUTH'     => $torrent_global_privacy,
		   'MULTY_FILES'   => ($row["type"] == "single" OR $row["numfiles"] <= 1) ? false : true,
		   'NUM_FILE'      => $row["numfiles"],
		   'NUM_COMENTS'   => $row["comments"],
		   'RATEING_PIC'   => $rating,
		   'DATE_ADDED'    => $user->format_date(sql_timestamp_to_unix_timestamp($row['added'])),
		   'TIMES_SNATHED' => $sncount['snatch'],
		   'DOWNLOAD_SP'   => mksize($row["speed"]),
		   'DOWNLOAD_SIZE' => mksize($row["size"]),
		   'SEEDERS'       => $row["seeders"],
		   'LEECHERS'      => $row["leechers"],
		   'TOTAL_SPEED'   => $speed_leech,
		   'EST_DL_SPD'    => $edt,
		   'ANONUMUS_UPLO' => (isset($row["username"]) AND $row["ownertype"]==0) ? false : true,
		   'UPLOADERS_NAM' => ($row['owner'] == 0) ? $user->lang['UNKNOWN'] : username_is($row['owner']),
		   'UPLODER_ID'    => $row['owner'],
		   'UPLDER_COLOR'  => getusercolor(getlevel_name($row['owner'])),
           ));
}
return;
}
function getscrapedata($url, $display=false, $info = false) {
	if (preg_match("/thepiratebay.org/i", $url))$url = 'udp://tracker.openbittorrent.com:80';
		if(preg_match('%udp://([^:/]*)(?::([0-9]*))?(?:/)?%si', $url, $m))
			{
				$tracker = 'udp://' . $m[1];
				$port = isset($m[2]) ? $m[2] : 80;
$ports = array(21, 25, 80, 81, 110, 443, 3306, $port);
foreach ($ports as $port)
{
    $connection = @fsockopen($tracker, $port);
    if (is_resource($connection))
    {
        //echo '<h2>' . $tracker . ':' . $port . ' ' . '(' . getservbyport($port, 'udp') . ') is open.</h2>' . "\n";
        fclose($connection);
    }
    else
    {
        //echo '<h2>' . $tracker . ':' . $port . ' is not responding.</h2>' . "\n";
    }
}
//exit();
				$page = "d5:filesd";
				$transaction_id = mt_rand(0,65535);
				$fp = fsockopen($tracker, $port, $errno, $errstr);
				stream_set_timeout($fp, 100);
				if(!$fp)
					{
						return false;
					}
				$current_connid = "\x00\x00\x04\x17\x27\x10\x19\x80";
				//Connection request
				$packet = $current_connid . pack("N", 0) . pack("N", $transaction_id);
				fwrite($fp,$packet);
				//Connection response
				$ret = fread($fp, 16);
				//die($errno . $errstr);
				if(strlen($ret) < 1 OR strlen($ret) < 16)
					{
						return false;
					}
				$retd = unpack("Naction/Ntransid",$ret);
				if($retd['action'] != 0 || $retd['transid'] != $transaction_id)
					{
						return false;
					}
				$current_connid = substr($ret,8,8);
				//Scrape request
				$hashes = '';
				foreach($info as $hash)
					{
						$hashes .= pack('H*', $hash);
					}
				$packet = $current_connid . pack("N", 2) . pack("N", $transaction_id) . $hashes;
				fwrite($fp,$packet);
				//Scrape response
				$readlength = 8 + (12 * count($info));
				$ret = fread($fp, $readlength);
				//echo $ret;
				if(strlen($ret) < 1 OR strlen($ret) < 8)
					{
						return false;
					}
				$retd = unpack("Naction/Ntransid",$ret);
				// Todo check for error string if response = 3
				if($retd['action'] != 2 || $retd['transid'] != $transaction_id || strlen($ret) < $readlength)
					{
						return false;
					}
				$torrents = array();
				$index = 8;
				foreach($info as $k => $hash)
					{
						$retd = unpack("Nseeders/Ncompleted/Nleechers",substr($ret,$index,12));
						$retd['infohash'] = $k;
						$torrents[$hash] = $retd;
						$index = $index + 12;
					}
				foreach($torrents as $retb)$page .= "20:".str_pad($retb['infohash'], 20)."d".
				"8:completei".$retb['seeders']."e".
				"10:downloadedi".$retb['completed']."e".
				"10:incompletei".$retb['leechers']."e".
				"e";
				$page .= "ee";
			}
			else
			{
				if (!$fp = @fopen($url,"rb")) return false; //Warnings are shown
					@stream_set_timeout($fp, 10);
				$page = "";
				while (!feof($fp)) $page .= @fread($fp,10000);
				@fclose($fp);
			}
					//die($url);
				if(strlen($page) < 1 OR strlen($page) < 16)
					{
						return false;
					}

        $scrapef = BDecode($page,"Scrape");
        unset($page);

        if (!$scrapef) {
                //if($display)echo "<p>"._admtrkinvalidbencode."</p>\n";
                return false;
        }

        return $scrapef;
}
function ResolveTracker($url, &$resp) {
        $server = parse_url($url);

        if (!isset($server["port"]) OR !$server["port"] == '') $server["port"] = 80;
        $out  = "GET / HTTP/1.1\r\n";
        $out .= "Host: ".$server['host'].":".$server["port"]."\r\n";
        $out .= "User-Agent: Azureus 2.5.0.0\r\n";
        $out .= "Connection: Close\r\n\r\n";

        $fp = @fsockopen($server["host"],'',$errno,$errstr,1.0);
        $fp2 = @fsockopen($server["host"],'80',$errno,$errstr,1.0);
		$fp3 = @fsockopen($server["host"],$server["port"],$errno,$errstr,1.0);
        if (!$fp) $fp = $fp2;
        if (!$fp) $fp = $fp3;
        if (!$fp) {
               return false;
        }

        fwrite($fp,$out);
        $resp = fgets($fp,512);
        fclose($fp);
        if(!preg_match("/HTTP\/1\.[01]\ 30[0-3] Found/",$resp)) return true;
        if(!preg_match("/HTTP\/1\.[01]\ 20[0-3] OK/",$resp)) return true;
       return false;
}
function multiscrape() {
        //echo "Debug: entro in multiscrape\n";
        global $db, $db_prefix, $time_tracker_update;
        $sql = "SELECT url, support, id, support FROM ".$db_prefix."_trackers WHERE UNIX_TIMESTAMP(updated) < UNIX_TIMESTAMP(NOW()) - (".intval($time_tracker_update).") AND status = 'active' ORDER BY updated ASC LIMIT 1;";
        $trkres = $db->sql_query($sql);
        if (!$trkrow = $db->sql_fetchrow($trkres)) {
              //echo "Debug: Non ho un tracker attivo\n(".intval($time_tracker_update).")";
                $db->sql_freeresult($trkres);
                //Trying to contact a dead tracker after thrice the interval
                $sql = "SELECT url, support, id FROM ".$db_prefix."_trackers WHERE UNIX_TIMESTAMP(updated) < UNIX_TIMESTAMP(NOW()) - (3 * ".intval($time_tracker_update).") AND status = 'offline' ORDER BY RAND() LIMIT 1;";
                $trkres = $db->sql_query($sql);
                if (!$trkrow = $db->sql_fetchrow($trkres)) return;
        }
        $db->sql_freeresult($trkres);
        $announce = $trkrow["url"];
        $support = $trkrow["support"];
		$id = $trkrow['id'];

        $sql = "SELECT info_hash FROM ".$db_prefix."_torrents WHERE tracker = '".$announce."';";
        $hashres = $db->sql_query($sql);

        if ($db->sql_numrows($hashres) < 1) {
                $db->sql_query("DELETE FROM ".$db_prefix."_trackers WHERE url = '".$announce."';");
                return;
        }

        $infohashes = Array();
        while ($row_hash = $db->sql_fetchrow($hashres)) {
                $infohashes[] = utf8_decode($row_hash["info_hash"]);
        }
        unset($row_hash, $sql);
        $db->sql_freeresult($hashres);

        //echo "Debug: ho scelto un tracker: ".$announce."\n";
        $scrapeurl = str_replace("announce","scrape",$announce);
        /*
        0TH ATTEMPT: CHECK FOR TRACKER ONLINE
        1ST ATTEMPT: SELECTIVE SCRAPE
        2ND ATTEMPT: GLOBAL SCRAPE
        3RD ATTEMPT: SINGLE SCRAPE
        */
		/*removed for now
        if (!ResolveTracker($scrapeurl, $resp)) {
                //echo "Debug: Impossibile collegarsi al tracker\n";
               // if ($resp) //echo $resp;
                $sql = "UPDATE ".$db_prefix."_trackers SET status = 'dead' WHERE url = '".addslashes($announce)."';";
                $db->sql_query($sql);
                $sql = "UPDATE ".$db_prefix."_torrents SET seeders = 0, leechers = 0, tot_peer = 0 WHERE tracker = '". addslashes($announce) . "';";
                $db->sql_query($sql);
                return;
        }
		*/

        //echo "Debug: il tracker è pronto\n";

        if ($support == "selective" AND  count($infohashes) > 1) {
                //echo "Debug: Tento il selettivo\n";
                /*
                TRIES SELECTIVE SCRAPE.
                IF WORKS SAVES DATA AND TERMINATES BLOCK (WITH BREAK)
                ELSE TRIES GLOBAL SCRAPE (WHICH IS A *STANDARD*)
                */
                $url = $scrapeurl.((strpos($scrapeurl,"?")) ? "&" : "?")."info_hash=".urlencode($infohashes[0]);
                for ($i = 1; $i < count($infohashes); $i++) {
                        $url .= "&info_hash=".urlencode($infohashes[$i]);

                }
			  foreach($infohashes as $k => $hash)$gethash[$hash]=preg_replace_callback('/./s', "hex_esc", str_pad($hash,20));
                $scrape = getscrapedata($url,false, $gethash);
                $scrape_valid = false;

                //Checking if returned scrape is valid scrape data
                if ($scrape) {
                        if (!entry_exists($scrape,"failure reason(String)","Scrape") AND entry_exists($scrape,"files(Dictionary)","Scrape")) {
                                $scrape_valid = true;
                        }
                }

                if (!$scrape_valid) {
                        $support = "global";
                        $db->sql_query("UPDATE ".$db_prefix."_trackers SET support = 'global' WHERE id = '".$id."';");
                }
        }

        if ($support == "global" AND count($infohashes) >= 1) {
 			  $gethash = array();
				foreach($infohashes as $k => $hash)$gethash[$hash]=preg_replace_callback('/./s', "hex_esc", str_pad($hash,20));
               //echo "Debug: Tento il globale\n";
                $scrape_valid = false;
                $scrape = getscrapedata($scrapeurl,false, $gethash);
                if ($scrape) {
                        if (!entry_exists($scrape,"failure reason(String)","Scrape") AND entry_exists($scrape,"files(Dictionary)","Scrape")) {
                                $scrape_valid = true;
                        }
                }
                if (!$scrape_valid) {
                        $support = "single";
                        $db->sql_query("UPDATE ".$db_prefix."_trackers SET support = 'single' WHERE id = '".$id."';");
                }
        }

        if ($support == "single" OR count($infohashes) == 1) {
                //echo "Debug: Tento il singolo\n";

                /*
                SINGLE SCRAPE CREATES A FAKE GLOBAL SCRAPE QUERYING THE TRACKER MULTIPLE TIMES
                THE FAKE SCRAPE IS USED TO MAKE THE NEXT PART OF THE CODE BELIEVE WE DID A SINGLE JOB
                THIS METHOD IS USED ON LARGE TRACKERS AND HAS ONE INCONVENIENT: WITH MANY TORRENTS
                YOUR SERVER COULD GET BANNED FOR HAMMERING
                */

                $scrape = domxml_new_doc("1.0");
                $root = $scrape->create_element("Scrape");
                $root->set_attribute("type","Dictionary");
                $files = $scrape->create_element("files");
                $files->set_attribute("type","Dictionary");

                foreach ($infohashes as $hash) {
                         if(!$scr = getscrapedata ($scrapeurl.((strpos($scrapeurl,"?")) ? "&" : "?")."info_hash=".urlencode($hash), false,array($hash=>preg_replace_callback('/./s', "hex_esc", str_pad($hash,20))))) continue;
                        $hash_hex = preg_replace_callback('/./s', "hex_esc", str_pad($hash,20));
						$hash_hex = 'a'.$hash_hex;

                        if (entry_exists($scr,"files/".$hash_hex."(Dictionary)","Scrape")) {
                                #Create the XML node for fake global scrape
                                $item = $scrape->create_element($hash_hex);
                                $item->set_attribute("type","Dictionary");

                                $complete = $scrape->create_element("complete");
                                $complete->set_attribute("type","Integer");
                                $child = $scrape->create_text_node(entry_read($scr,"files/".$hash_hex."/complete(Integer)","Scrape"));
                                $complete->append_child($child);

                                $incomplete = $scrape->create_element("incomplete");
                                $incomplete->set_attribute("type","Integer");
                                $child = $scrape->create_text_node(entry_read($scr,"files/".$hash_hex."/incomplete(Integer)","Scrape"));
                                $incomplete->append_child($child);

                                $downloaded = $scrape->create_element("downloaded");
                                $downloaded->set_attribute("type","Integer");
                                $child = $scrape->create_text_node(entry_read($scr,"files/".$hash_hex."/downloaded(Integer)","Scrape"));
                                $downloaded->append_child($child);

                                $item->append_child($complete);
                                $item->append_child($incomplete);
                                $item->append_child($downloaded);

                                $files->append_child($item);
                        }
                        unset($scr);

                        ob_flush();
                        sleep(2);
                }

                $root->append_child($files);
                $scrape->append_child($root);

        }

        //echo "Debug: Ho fatto lo scrape\n";
		$c = 0;
        foreach ($infohashes as $hash) {
                $hash_hex = preg_replace_callback('/./s', "hex_esc", str_pad($hash,20));
				$hash_hex = 'a'.$hash_hex;
                if (!entry_exists($scrape,"files/".$hash_hex."(Dictionary)","Scrape")) {
                        $seed = $leech = $completed = 0;
                } else {

                        $seed = entry_read($scrape,"files/".$hash_hex."/complete(Integer)","Scrape");
                        $leech = entry_read($scrape,"files/".$hash_hex."/incomplete(Integer)","Scrape");
                        $completed = entry_read($scrape,"files/".$hash_hex."/downloaded(Integer)","Scrape");
                        $name = ((entry_exists($scrape,"files/".$hash_hex."/name(String)","Scrape")) ? entry_read($scrape,"files/".$hash_hex."/name(String)","Scrape") : "");
                }
                if (($seed + $leech) > 0) $visible = "yes";
                else $visible = "no";
                $sql = "UPDATE ".$db_prefix."_torrents SET seeders = ". $seed .", leechers = ".$leech.", tot_peer = ". ($seed + $leech) .", completed = ". $completed .", visible = '".$visible."', tracker_update = NOW(), last_action = NOW() WHERE info_hash = '".$db->sql_escape(utf8_encode($hash))."';";
                $db->sql_query($sql);
				$c++;
        }
        unset($scrape);
        $db->sql_query("UPDATE ".$db_prefix."_trackers SET updated = NOW(), status = 'active' WHERE id = '".$id."';");
		     if(defined('PMBT_DEBUG'))logerror('multysxrape done for tracker #' . $id . 'With ' . $c . ' Torrents updated' , "system",get_tor_id_from_has($hash));


        //echo "Debug: Scrape completato\n";

}
function hex_to_base32($hex) {
  $b32_alpha_to_rfc3548_chars = array(
    '0' => 'A',
    '1' => 'B',
    '2' => 'C',
    '3' => 'D',
    '4' => 'E',
    '5' => 'F',
    '6' => 'G',
    '7' => 'H',
    '8' => 'I',
    '9' => 'J',
    'a' => 'K',
    'b' => 'L',
    'c' => 'M',
    'd' => 'N',
    'e' => 'O',
    'f' => 'P',
    'g' => 'Q',
    'h' => 'R',
    'i' => 'S',
    'j' => 'T',
    'k' => 'U',
    'l' => 'V',
    'm' => 'W',
    'n' => 'X',
    'o' => 'Y',
    'p' => 'Z',
    'q' => '2',
    'r' => '3',
    's' => '4',
    't' => '5',
    'u' => '6',
    'v' => '7'
  );
  for ($pos = 0; $pos < strlen($hex); $pos += 10) {
    $hs = substr($hex,$pos,10);
    $b32_alpha_part = base_convert($hs,16,32);
    $expected_b32_len = strlen($hs) * 0.8;
    $actual_b32_len = strlen($b32_alpha_part);
    $b32_padding_needed = $expected_b32_len - $actual_b32_len;
    for ($i = $b32_padding_needed; $i > 0; $i--) {
      $b32_alpha_part = '0' . $b32_alpha_part;
    }
    $b32_alpha .= $b32_alpha_part;
  }
  for ($i = 0; $i < strlen($b32_alpha); $i++) {
    $b32_rfc3548 .= $b32_alpha_to_rfc3548_chars[$b32_alpha[$i]];
  }
  return $b32_rfc3548;
}
function getauthstatus($torrent) {
        global $user, $db, $db_prefix;
        if ($torrent["owner"] != 0) {
                $sql = "SELECT * FROM ".$db_prefix."_privacy_global WHERE master = '".$torrent["owner"]."' AND slave = '".$user->id."' LIMIT 1;";
                $res = $db->sql_query($sql);
                if ($row = $db->sql_fetchrow($res)) {
                        if ($row["status"] == "whitelist") return AUTH_GRANTED;
                        elseif ($row["status"] == "blacklistlist") return AUTH_DENIED;
                }
                $sql = "SELECT * FROM ".$db_prefix."_privacy_file WHERE torrent = '".$torrent["id"]."' AND slave = '".$user->id."' LIMIT 1;";
                $res = $db->sql_query($sql) or btsqlerror($sql);
                if ($row = $db->sql_fetchrow($res)) {
                        if ($row["status"] == "granted") return AUTH_GRANTED;
                        elseif ($row["status"] == "denied") return AUTH_DENIED;
                        return AUTH_PENDING;
                } else return AUTH_NONE;
        } else return AUTH_NONE;
}
function checked2k($link, &$out) {
        global $db, $ed2k_regex, $db_prefix;
        $matches = Array();
        if (!preg_match($ed2k_regex,$link,$matches)) return INVALID_LINK;
        $out = Array("name" => rawurldecode($matches["name"]), "size" => $matches["size"], "hash" => $matches["hash"], "torrent" => 0);

        //We get only one Torrent
        $sql = "SELECT torrent FROM ".$db_prefix."_files WHERE size = ".$out["size"]." AND ed2k LIKE '%".$out["hash"]."%' LIMIT 1;";
        $res = $db->sql_query($sql);
        if ($db->sql_numrows($res) != 0) {
                list ($torrentid) = $db->fetch_array($res);
                $out["torrent"] = $torrentid;
        }
        $db->sql_freeresult($res);
        return LINK_OK;
}

function checkmagnet($link, $fname, &$out) {
        global $magnet_regex_sha1, $magnet_regex_bitprint;
        $sha1 = $bitprint = false;
        if (preg_match($magnet_regex_sha1,$link,$matches)) {
                $out = Array("name" => rawurldecode($matches["name"]), "hash" => $matches["hash"], "bitprint" => "");
                if ($out["name"] != $fname) return FILES_DONT_MATCH;
                return LINK_OK;
        }
        if (preg_match($magnet_regex_bitprint,$link,$matches)) {
                $out = Array("name" => rawurldecode($matches["name"][0]), "hash" => "", "bitprint" => $matches["bitprint"][0]);
                if ($out["name"] != $fname) return FILES_DONT_MATCH;
                return LINK_OK;
        }
        return INVALID_LINK;
}
?>