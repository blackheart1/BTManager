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
** File scrape-external.php 2018-02-17 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (defined('IN_PMBT'))
{
	die ("You can't include this file");
}
else
{
	define("IN_PMBT",true);
}
require_once("common.php");
$user->set_lang('scrape_ext',$user->ulanguage);
$template = new Template();
set_site_var($user->lang['TITLE']);
$id2	= request_var('id', 0);
$url2 =  request_var('tracker', '');
$home =  request_var('return', '');
$back =  request_var('back', '');
require_once("include/functions.php");
require_once("include/torrent_functions.php");
if(!checkaccess("u_update_peers")){
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['AUTH_FAILD'],
					'MESSAGE'			=> $user->lang['GROUP_NOT_AU'],
				));
				echo $template->fetch('message_body.html');
				close_out();
}
        do { //I can use break to exit

        @set_time_limit(180);
        @ini_set("memory_limit","64M");
        require_once("include/bdecoder.php");

        $sql = "SELECT id, url, support FROM ".$db_prefix."_trackers WHERE url = '".$db->sql_escape($url2)."' LIMIT 1;";
        $res = $db->sql_query($sql) or btsqlerror($sql);
        if ($db->sql_numrows($res) < 1) {
                $db->sql_freeresult($res);
				$template->assign_vars(array(
                        'S_ERROR'				=> true,
						'L_WARNING'				=>	$user->lang['TRACKER_MISSING'],
						'ERROR_MSG'				=>	sprintf($user->lang['ERROR_TRACKER_MIS'],$url2),
                ));
                break;
        }
        list ($id, $annurl, $support) = $db->fetch_array($res);
        $db->sql_freeresult($res);



        $sql = "SELECT info_hash FROM ".$db_prefix."_torrents WHERE id = '".$id2."';";
        $hashres = $db->sql_query($sql);

        $infohashes = Array();
        $scrapearray = Array();
        while ($row_hash = $db->sql_fetchrow($hashres)) {
                $infohashes[] = utf8_decode($row_hash["info_hash"]);
                $scrapearray[] = Array("info_hash" => utf8_decode($row_hash["info_hash"]), "seeders" => 0, "leechers" => 0, "completed" => 0);
        }
        unset($row_hash, $sql);
        $db->sql_freeresult($hashres);

        $scrapeurl = str_replace("announce","scrape",$annurl);

        /*
        0TH ATTEMPT: CHECK FOR TRACKER ONLINE
        1ST ATTEMPT: SELECTIVE SCRAPE
        2ND ATTEMPT: GLOBAL SCRAPE
        3RD ATTEMPT: SINGLE SCRAPE
        
        
*/
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
			  $gethash = array();
			  foreach($infohashes as $k => $hash)$gethash[$hash]=preg_replace_callback('/./s', "hex_esc", str_pad($hash,20));
                $scrape = getscrapedata($scrapeurl,true, $gethash);
                $scrape_valid = false;
                //Checking if returned scrape is valid scrape data
                if ($scrape) {
                        if (!entry_exists($scrape,"failure reason(String)","Scrape") AND entry_exists($scrape,"files(Dictionary)","Scrape")) {
                                $scrape_valid = true;
                        }
                }

                if ($scrape_valid) {
                } else {
                        $support = "global";
                        $db->sql_query("UPDATE ".$db_prefix."_trackers SET support = 'global' WHERE url = '".$url2."';");
						meta_refresh(0, $_SERVER['QUERY_STRING']);
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['AUTH_FAILD'],
					'MESSAGE'			=> $user->lang['GROUP_NOT_AU'],
				));
				echo $template->fetch('message_body.html');
				close_out();                }
        }
		//die('test');
        if ($support == "global" ) {
			  $gethash = array();
				foreach($infohashes as $k => $hash)$gethash[$hash]=preg_replace_callback('/./s', "hex_esc", str_pad($hash,20));
                $scrape_valid = false;
                $scrape = getscrapedata($scrapeurl,true,$gethash);
                if ($scrape) {
                        if (!entry_exists($scrape,"failure reason(String)","Scrape") AND entry_exists($scrape,"files(Dictionary)","Scrape")) {
                                $scrape_valid = true;
                        }
                }
                if ($scrape_valid) {
                } else {
                        $support = "single";
                        $db->sql_query("UPDATE ".$db_prefix."_trackers SET support = 'single' WHERE url = '".$url2."';");
 						meta_refresh(0, $siteurl . '/scrape-external.php?' . $_SERVER['QUERY_STRING']);
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['AUTH_FAILD'],
					'MESSAGE'			=> $user->lang['GROUP_NOT_AU'],
				));
				echo $template->fetch('message_body.html');
				close_out();
				}
        }
//die(count($infohashes));
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

                        sleep(2);
                }

                $root->append_child($files);
                $scrape->append_child($root);
        }

				$template->assign_block_vars('trackers_resp', array(
											'SCRAPE'  => str_replace(Array(" ","\n"),Array("&nbsp;","<br />\n"),htmlspecialchars($scrape->dump_mem(true,"UTF-8"))),
										));
        foreach ($infohashes as $hash) {
                $hash_hex = preg_replace_callback('/./s', "hex_esc", str_pad($hash,20));
						$hash_hex = "a".$hash_hex;
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
				
				$template->assign_vars(array(
											'SEEDERS'		=> $seed,
											'LEECHERS'  	=> $leech,
											'COMPLETED'  	=> $completed,
											'NAME'  		=> htmlspecialchars(stripslashes(get_tor_name_from_has(utf8_encode($hash)))),
											'INFO_HASH'  	=> $hash_hex,
										));
                $sql = "UPDATE ".$db_prefix."_torrents SET seeders = ". $seed .", leechers = ".$leech.", tot_peer = ". ($seed + $leech) .", completed = ". $completed .", visible = '".$visible."', tracker_update = NOW(), last_action = NOW() WHERE info_hash = '".addslashes(utf8_encode($hash))."';";
                $db->sql_query($sql) or btsqlerror($sql);
        }
        unset($scrape);
        $db->sql_query("UPDATE ".$db_prefix."_trackers SET updated = NOW(), status = 'active' WHERE id = '".$id."';");


        } while (false);
		
		if ($back==""){
		meta_refresh(15,$home);
		}else{
		meta_refresh(15,"details.php?id=".$id2);
		}
echo $template->fetch('scrape-external.html');
close_out();
?>