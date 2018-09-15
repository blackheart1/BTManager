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
** File trackers.php 2018-02-23 14:32:00 Black_Heart
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
require_once("include/torrent_functions.php");
$user->set_lang('admin/acp_trackers',$user->ulanguage);
		$do	= request_var('do', '');
		$id	= request_var('id', 0);
		$action	= request_var('action', '');
		$hide = array();

if ($do == "bantracker" AND $id AND is_numeric($id) AND $action) do {
        $sql = "SELECT url FROM ".$db_prefix."_trackers WHERE id = ".$id." LIMIT 1;";
        $res = $db->sql_query($sql) or btsqlerror($sql);
        if ($db->sql_numrows($res) < 1) {
                $db->sql_freeresult($res);
                break;
        }
        list ($annurl) = $db->fetch_array($res);
        $db->sql_freeresult($res);

        if ($action == "ban") {
                $sql = "UPDATE ".$db_prefix."_trackers SET status = 'blacklisted' WHERE id = '".$id."';";
                $db->sql_query($sql) or btsqlerror($sql);
                $sql = "UPDATE ".$db_prefix."_torrents SET banned = 'yes' WHERE tracker = '".$annurl."';";
                $db->sql_query($sql) or btsqlerror($sql);
        }
		elseif ($action == "unban")
		{
                $sql = "UPDATE ".$db_prefix."_trackers SET status = 'active' WHERE id = '".$id."';";
                $db->sql_query($sql) or btsqlerror($sql);
                $sql = "UPDATE ".$db_prefix."_torrents SET banned = 'no' WHERE tracker = '".$annurl."';";
                $db->sql_query($sql) or btsqlerror($sql);
        }
} while (false);
if ($do == "bannewtracker") {
        $annregexp = "/(udp|http[s]?+):\/\/[-\/.:_\\w]*\/announce[^\/\\s]*/";
        if (!preg_match($annregexp, $announce) OR $announce == $announce_url)
		{
			if($announce == '')$announce = $user->lang['BLANK_ANNOUNCE_URL'];
				$template->assign_vars(array(
                        'S_ERROR'				=> true,
						'L_WARNING'				=>	$user->lang['BANNED_ANNOUNCE'],
						'ERROR_MSG'				=>	sprintf($user->lang['INVALID_ANNOUNCE'],$announce),
                ));
		}
        else
		{
                $sql = "INSERT INTO ".$db_prefix."_trackers (url , status , updated) VALUES ('".addslashes($announce)."', 'blacklisted', NOW( ));";
                $db->sql_query($sql);
        }
}

$sql = "SELECT id, url, status, UNIX_TIMESTAMP(updated) AS updated FROM ".$db_prefix."_trackers;";

$res = $db->sql_query($sql) or btsqlerror($sql);
 if ($db->sql_numrows($res) < 1) {
		$template->assign_vars(array(
		'S_TRACKERS'			=> false,
		));
	
} else {
		$template->assign_vars(array(
		'S_TRACKERS'			=> true,
		));

       while ($tracker = $db->sql_fetchrow($res)) {
                $torrentsql = "SELECT COUNT(id) FROM ".$db_prefix."_torrents WHERE tracker = '".$tracker["url"]."';";
                $torrentres = $db->sql_query($torrentsql) or btsqlerror($torrentsql);
                list ($torrents) = $db->fetch_array($torrentres);
                $db->sql_freeresult($torrentres);

                $act = "ban";
                $alt = $user->lang['BLACK_LIST'];
                $ban = "lock.gif";
				$tbanned = false;
                if ($tracker["status"] == "active") $trkstatus = $user->lang['TRACKER_ACTIVE'];
                elseif($tracker["status"] == "dead") $trkstatus = $user->lang['TRACKER_OFF_LINE'];
                else {
						$tbanned = true;
                        $trkstatus = $user->lang['TRACKER_BLACK_LISTED'];
                        $act = "unban";
                        $alt = $user->lang['UNBLACK_LIST'];
                        $ban = "unlock.gif";
                }
				$template->assign_vars(array(
                        'S_RETURN'				=> 'admin.php?i=torrentinfo&op=trackers',
                ));
			$template->assign_block_vars('trackers', array(
				'ID'			=> $tracker["id"],
				'TRACKER'		=> $tracker["url"],
				'STATUS'		=> $trkstatus,
				'UPDATED'		=> mkprettytime(time()-$tracker["updated"]),
				'TORRENTS'		=> $torrents,
				'ACT'		=> $act,
				'ALT'		=> $alt,
				'BAN'		=> $ban,
				'BANNED'	=> $tbanned
				)
			);
        }
}
$db->sql_freeresult($res);


if ($do == "listtorrents" AND isset($id) AND is_numeric($id)) {
        $sql = "SELECT ".$db_prefix."_torrents.*, IF(".$db_prefix."_torrents.numratings < '$minvotes', NULL, ROUND(".$db_prefix."_torrents.ratingsum / ".$db_prefix."_torrents.numratings, 1)) AS rating, ".$db_prefix."_categories.name AS cat_name, ".$db_prefix."_categories.image AS cat_pic, U.username, IF(U.name IS NULL, U.username, U.name) as user_name, U.level as user_level FROM ".$db_prefix."_torrents LEFT JOIN ".$db_prefix."_categories ON category = ".$db_prefix."_categories.id LEFT JOIN ".$db_prefix."_users U ON ".$db_prefix."_torrents.owner = U.id LEFT JOIN ".$db_prefix."_trackers ON ".$db_prefix."_torrents.tracker = ".$db_prefix."_trackers.url WHERE ".$db_prefix."_trackers.id = '".$id."' ORDER BY ".$db_prefix."_torrents.evidence DESC, ".$db_prefix."_torrents.added DESC;";
        $res = $db->sql_query($sql) or btsqlerror($sql);
        	if ($db->sql_numrows($res) < 1) {
				$template->assign_vars(array(
                        'S_ERROR'				=> true,
						'L_WARNING'				=>	$user->lang['NOTOR_ERR'],
						'ERROR_MSG'				=>	sprintf($user->lang['NO_TORRENTS_LISTED'],$id),
                ));
			}
			else
			{
                $template->assign_vars(array(
                        'S_TORRENTS'            => true,
                ));
		        get_tor_vars($res);
		        $db->sql_freeresult($res);
			}
}

if ($do == "scrapenow" AND isset($id) AND is_numeric($id))
{
                $scrape_valid = false;
        do { //I can use break to exit

        	@set_time_limit(180);
        	@ini_set("memory_limit","64M");
        	require_once("include/bdecoder.php");

        	$sql = "SELECT url, support 
				FROM ".$db_prefix."_trackers 
				WHERE 
				id = ".$id." 
				AND 
				status NOT IN ('blacklisted')
				LIMIT 1;";
        	$res = $db->sql_query($sql) or btsqlerror($sql);
        	if ($db->sql_numrows($res) < 1) {
                $db->sql_freeresult($res);
				$template->assign_vars(array(
                        'S_ERROR'				=> true,
						'L_WARNING'				=>	$user->lang['NOTOR_ERR'],
						'ERROR_MSG'				=>	sprintf($user->lang['NO_TORRENTS_LISTED'],$annurl),
                ));
                break;
        	}
        	list ($annurl,$support) = $db->fetch_array($res);
        	$db->sql_freeresult($res);
        	$sql = "SELECT info_hash FROM ".$db_prefix."_torrents WHERE tracker = '".$annurl."';";
        	$hashres = $db->sql_query($sql);
        	if ($db->sql_numrows($hashres) < 1) {
                $db->sql_query("DELETE FROM ".$db_prefix."_trackers WHERE url = '".$annurl."';");
				$template->assign_vars(array(
                        'S_ERROR'				=> true,
						'L_WARNING'				=>	$user->lang['NOTOR_ERR'],
						'ERROR_MSG'				=>	sprintf($user->lang['NO_TORRENTS_LISTED'],$annurl),
                ));
                break;
        	}
        	$infohashes = Array();
        	$scrapearray = Array();
        	while ($row_hash = $db->sql_fetchrow($hashres)) {
                $infohashes[] = utf8_decode($row_hash["info_hash"]);
                $scrapearray[] = Array("info_hash" => utf8_decode($row_hash["info_hash"]), "seeders" => 0, "leechers" => 0, "completed" => 0);
        	}
        	$db->sql_freeresult($hashres);
        	unset($row_hash, $sql);

        	$scrapeurl = str_replace("announce","scrape",$annurl);

        /*
        0TH ATTEMPT: CHECK FOR TRACKER ONLINE
        1ST ATTEMPT: SELECTIVE SCRAPE
        2ND ATTEMPT: GLOBAL SCRAPE
        3RD ATTEMPT: SINGLE SCRAPE
        */
        /*if (!ResolveTracker($scrapeurl, $resp)) 
		{
				$template->assign_vars(array(
                        'S_ERROR'				=> true,
						'L_WARNING'				=>	$user->lang['NOTOR_ERR'] . '#4',
						'ERROR_MSG'				=>	$user->lang['TRACKER_OFFLINE'] . (($resp)? " (".htmlspecialchars($resp).")" : ''),
                ));
                $sql = "UPDATE ".$db_prefix."_trackers SET status = 'dead' WHERE url = '".$annurl."';";
                $db->sql_query($sql) or btsqlerror($sql);
                $sql = "UPDATE ".$db_prefix."_torrents SET seeders = 0, leechers = 0, tot_peer = 0 WHERE tracker = '". $annurl . "';";
                $db->sql_query($sql) or btsqlerror($sql);
                break;
        }*/
        if ($support == "selective" AND  count($infohashes) > 1) {
                /*
                TRIES SELECTIVE SCRAPE.
                IF WORKS SAVES DATA AND TERMINATES BLOCK (WITH BREAK)
                ELSE TRIES GLOBAL SCRAPE (WHICH IS A *STANDARD*)
                */
                $url = $scrapeurl.((strpos($scrapeurl,"?")) ? "&" : "?")."info_hash=".urlencode($infohashes[0]);
                for ($i = 1; $i < count($infohashes); $i++) {
                        $url .= "&info_hash=".urlencode($infohashes[$i]);

                }
			  $gethashudp = array();
			  $gethash = array();
			  $infocount = 0;
				$joins = false;
				$startscrape = false;
				$cont = 0;
			  foreach($infohashes as $k => $hash)
			  {
			  	$infocount++;
				$gethashudp[$hash]=preg_replace_callback('/./s', "hex_esc", str_pad($hash,20));
				$gethash[] = $hash;
				if($infocount == 70 or end($infohashes) == $hash)
				{
                $url = $scrapeurl.((strpos($scrapeurl,"?")) ? "&" : "?")."info_hash=".urlencode($gethash[0]);
                for ($i = 1; $i < count($gethash); $i++) {
                        $url .= "&info_hash=".urlencode($gethash[$i]);
					}
					if(!$startscrape)
					{
						$scrape = getscrapedata($url, false, $gethashudp);
						$startscrape = 1;
					}else{
						$scrapeb = getscrapedata($url, false, $gethash);
						$joins = true;
					}
					if($scrapeb)
					{
					$scrape = domxml_open_mem(joinXML($scrape, $scrapeb, $tag = 'files'));
					
					}
					$ret = $gethash = $retb = '';
					$infocount = 0;
					$cont++;
				}
			}
                $scrape_valid = false;


                //Checking if returned scrape is valid scrape data
                if ($scrape) {
                        if (!entry_exists($scrape,"failure reason(String)","Scrape") AND entry_exists($scrape,"files(Dictionary)","Scrape")) {
                                $scrape_valid = true;
                        }
                }

                if ($scrape_valid) {
					$template->assign_vars(array(
										'S_UPDATE_TORRENTS'				=>	true,
										));
					$template->assign_block_vars('trackers_resp', array(
											'SCRAPE'  => str_replace(Array(" ","\n"),Array("&nbsp;","<br />\n"),htmlspecialchars($scrape->dump_mem(true,"UTF-8"))),
										));
                }
				else
				{
                        $support = "global";
                        $db->sql_query("UPDATE ".$db_prefix."_trackers SET support = 'global' WHERE id = '".$id."';");
                }
        }

        if ($support == "global" AND count($infohashes) >=1) {
			  $gethash = array();
				foreach($infohashes as $k => $hash)$gethash[$hash]=preg_replace_callback('/./s', "hex_esc", str_pad($hash,20));
                $scrape_valid = false;
                $scrape = getscrapedata($scrapeurl,true,$gethash);
                if ($scrape) {
                        if (!entry_exists($scrape,"failure reason(String)","Scrape") AND entry_exists($scrape,"files(Dictionary)","Scrape")) {
                                $scrape_valid = true;
                        }
                }
                if ($scrape_valid)
				{
				$template->assign_vars(array(
										'S_UPDATE_TORRENTS'				=>	true,
										));
					$template->assign_block_vars('trackers_resp', array(
											'SCRAPE'  => str_replace(Array(" ","\n"),Array("&nbsp;","<br />\n"),htmlspecialchars($scrape->dump_mem(true,"UTF-8"))),
										));
                } else {
                        $support = "single";
                        $db->sql_query("UPDATE ".$db_prefix."_trackers SET support = 'single' WHERE id = '".$id."';");
                }
        }

        if ($support == "single" OR count($infohashes) == 1) {
                $rewrite_engine = false; //We'll send output buffer to client
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
                        if(!$scr = getscrapedata ($scrapeurl.((strpos($scrapeurl,"?")) ? "&" : "?")."info_hash=".urlencode($hash), true,array($hash=>preg_replace_callback('/./s', "hex_esc", str_pad($hash,20))))) continue;
                        $hash_hex = preg_replace_callback('/./s', "hex_esc", str_pad($hash,20));
						$hash_hex = "a".$hash_hex;
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

                       // ob_flush();
                        sleep(2);
                }

                $root->append_child($files);
                $scrape->append_child($root);
				$template->assign_vars(array(
										'S_UPDATE_TORRENTS'				=>	true,
										));
				$template->assign_block_vars('trackers_resp', array(
											'SCRAPE'  => str_replace(Array(" ","\n"),Array("&nbsp;","<br />\n"),htmlspecialchars($scrape->dump_mem(true,"UTF-8"))),
										));
        }

        foreach ($infohashes as $hash) {
                $hash_hex = preg_replace_callback('/./s', "hex_esc", str_pad($hash,20));
						$hash_hex = "a".$hash_hex;
                if ($support == "selective" AND !entry_exists($scrape,"files/".$hash_hex."(Dictionary)","Scrape")) {
                        $support = "global";
                        $db->sql_query("UPDATE ".$db_prefix."_trackers SET support = 'global' WHERE id = '".$id."';");
		                echo "<meta http-equiv=\"refresh\" content=\"0;url=admin.php?op=scrapenow&id=".$id."\">";
						die;
						}
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
				$template->assign_block_vars('trackers_update', array(
											'SEEDERS'		=> $seed,
											'LEECHERS'  	=> $leech,
											'COMPLETED'  	=> $completed,
											'NAME'  		=> htmlspecialchars(stripslashes(get_tor_name_from_has(utf8_encode($hash)))),
											'INFO_HASH'  	=> $hash_hex,
										));
                $sql = "UPDATE ".$db_prefix."_torrents SET seeders = ". $seed .", leechers = ".$leech.", tot_peer = ". ($seed + $leech) .", completed = ". $completed .", visible = '".$visible."', last_action = NOW() WHERE info_hash = '".addslashes(utf8_encode($hash))."';";
                $db->sql_query($sql) or btsqlerror($sql);
        }
        unset($scrape);
        $db->sql_query("UPDATE ".$db_prefix."_trackers SET updated = NOW(), status = 'active' WHERE id = '".$id."';");


        } while (false);
}
                $hide['do'] = 'bannewtracker';
				$template->assign_vars(array(
                        'U_ACTION'				=> $u_action,
						'HIDDEN'				=>	build_hidden_fields($hide),
                ));
echo $template->fetch('admin/acp_trackers.html');
		close_out();
?>