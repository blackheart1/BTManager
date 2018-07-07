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
** File clinic.php 2018-02-17 14:32:00 Black_Heart
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
$user->set_lang('admin/mcp_clinic',$user->ulanguage);

@set_time_limit(300);
@ini_set("memory_limit","64M");

$hidden = array('MAX_FILE_SIZE'=>$max_torrent_size,'do'=>'1','i'=>'torrentinfo','op'=>'clinic');
$template->assign_vars(array(
			'S_MESSAGE'			=>	false,
			'S_SRAPE'			=>	($autoscrape)? false:true,
			'U_ACTION'			=>	'./admin.php',
			'HIDDEN'			=>	build_hidden_fields($hidden),
			'S_STRUCTURE'		=>	false,
			'S_ANN_CHECK'		=>	true,
			'S_VALIDANN'		=>	true,
			'S_VALIDDIRECT'		=>	true,
			'S_VALIDFILES'		=>	true,
			'S_PEACES_LENGTH'	=>	true,
			'S_PEACES_CHECK'	=>	true,
			'S_VALID_TORRENT'	=>	false,
			));
$do					= request_var('do', '');
if ($do) {
        do { //trick to use break as exit

                //Load XML Bencoder Library
                require_once("include/bdecoder.php");
                require_once("include/bencoder.php");

                //Read Torrent Info
                if (!isset($_FILES["filex"])) {
                                $template->assign_vars(array(
											'S_MESSAGE'				=> true,
											'S_USER_NOTICE'			=> false,
											'MESSAGE_TITLE'			=> $user->lang['BT_ERROR'],
											'MESSAGE_TEXT'			=> $user->lang['MISSING_DATA'],
											'FILE_DECODED'			=>	false,
											));
                        break;
                }
                $f = $_FILES["filex"];
                $fname = unesc($f["name"]);
                $tmpname = $f["tmp_name"];

                if (empty($fname)) {
                                $template->assign_vars(array(
											'S_MESSAGE'				=> true,
											'S_USER_NOTICE'			=> false,
											'MESSAGE_TITLE'			=> $user->lang['BT_ERROR'],
											'FILE_DECODED'			=>	false,
											'MESSAGE_TEXT'			=> $user->lang['EMPTY_FILE_NAME'],
											));
                        break;
                }

                if (!is_filename($fname)) {
                                $template->assign_vars(array(
											'S_MESSAGE'				=> true,
											'S_USER_NOTICE'			=> false,
											'MESSAGE_TITLE'			=> $user->lang['BT_ERROR'],
											'MESSAGE_TEXT'			=> $user->lang['INVALID_FILE_NAME'],
											'FILE_DECODED'			=>	false,
											));
                        break;
                }
                if (!preg_match('/^(.+)\.torrent$/si', $fname, $matches)) {
                                $template->assign_vars(array(
											'S_MESSAGE'				=> true,
											'S_USER_NOTICE'			=> false,
											'MESSAGE_TITLE'			=> $user->lang['BT_ERROR'],
											'MESSAGE_TEXT'			=> $user->lang['NOT_A_TORRENT_FILE'],
											'FILE_DECODED'			=>	false,
											));
                        break;
                }

                if (!is_uploaded_file($tmpname)) {
                                $template->assign_vars(array(
											'S_MESSAGE'				=> true,
											'S_USER_NOTICE'			=> false,
											'MESSAGE_TITLE'			=> $user->lang['BT_ERROR'],
											'MESSAGE_TEXT'			=> $user->lang['NO_FILE_UPLOADED'],
											'FILE_DECODED'			=>	false,
											));
                        break;
                }
                if (!filesize($tmpname)) {
                                $template->assign_vars(array(
											'S_MESSAGE'				=> true,
											'S_USER_NOTICE'			=> false,
											'MESSAGE_TITLE'			=> $user->lang['BT_ERROR'],
											'MESSAGE_TEXT'			=> $user->lang['FILE_EMPTY'],
											'FILE_DECODED'			=>	false,
											));
                        break;
                }
                $pagetorrent = "";
                $fp = @fopen($tmpname,"rb");
                while (!feof($fp)) $pagetorrent .= @fread($fp,1000);

                @fclose($fp);
				$pagetorrent=preg_replace('/file-mediali(.*?)ee(.*?):/i','file-mediali0ee$2:',$pagetorrent);
				$pagetorrent=preg_replace('/file-durationli(.*?)ee(.*?):/i','file-durationli0ee$2:',$pagetorrent);

                //In this area Warnings may appear without harming the page look
                $torrent = BDecode($pagetorrent);
               // echo str_replace(Array(" ","\n"),Array("&nbsp;","<br />\n"),htmlspecialchars($torrent->dump_mem(true,"UTF-8")));
				//die();
                unset($pagetorrent);
                if (!$torrent) {
                                $template->assign_vars(array(
											'S_MESSAGE'				=> true,
											'S_USER_NOTICE'			=> false,
											'MESSAGE_TITLE'			=> $user->lang['BT_ERROR'],
											'MESSAGE_TEXT'			=> $user->lang['FILE_EMPTY'],
											'FILE_DECODED'			=>	false,
											));
                        break;
                }
                if (isset($showxml) AND $showxml == "true")
				{
						$template->assign_vars(array(
									'S_STRUCTURE'			=>	str_replace(Array(" ","\n"),Array("&nbsp;","<br />\n"),htmlspecialchars($torrent->dump_mem(true,"UTF-8"))),
									'FILE_DECODED'			=>	true,
									));
                }


                #Checking against basic dictionaries

                //Checking against default tracker

                if (!entry_exists($torrent,"announce(String)")) {
                                $template->assign_vars(array(
											'S_MESSAGE'				=> true,
											'S_USER_NOTICE'			=> false,
											'MESSAGE_TITLE'			=> $user->lang['BT_ERROR'],
											'MESSAGE_TEXT'			=> $user->lang['NO_DEFAULT_ANNOUNCE'],
											));
                        break;
                }
                $announce = entry_read($torrent,"announce(String)");
                $annregexp_http = "/(http[s]?+):\/\/[-\/.:_\\w]*\/announce[^\/\\s]*/i";
                $annregexp_dht = "/^dht:\/\/[0-9a-f]*.dht\/announce$/i";
						$template->assign_vars(array(
									'S_ANNOUNCE'			=>	$announce,
									));
                if (!preg_match($annregexp_http,$announce) AND !preg_match($annregexp_dht,$announce)) {
						$template->assign_vars(array(
									'S_VALIDANN'			=>	false,
									));
                        break;
                }

                unset($annregexp_dht);

                //Checking against Info dictionary
                if (!entry_exists($torrent,"info(Dictionary)")) {
						$template->assign_vars(array(
									'S_VALIDDIRECT'			=>	false,
									));
                        break;
                }

                //Checking against single or multi-file
                if (entry_exists($torrent,"info/length(Integer)") AND entry_exists($torrent,"info/name(String)")) {
                        //Single file
						$template->assign_vars(array(
									'S_FILES_CONDITION'			=>	$user->lang['TORRENT_SINGLE_FILE'],
									));
                        $length = entry_read($torrent,"info/length(Integer)");
                        $name = entry_read($torrent,"info/name(String)");

						$template->assign_block_vars('filesinfo', array(
													'NAME'		    =>	$name,
													'SIZE'		    =>	mksize($length),
													'ERROR_FILE'	=>	false,
													));
                        unset($length, $name);
                } elseif(entry_exists($torrent,"info/files(List)")) {
                        //Multiple files
						$template->assign_vars(array(
									'S_FILES_CONDITION'			=>	$user->lang['TORRENT_MULTY_FILE'],
									));

                        $accum = 0;

                        $files = entry_read($torrent,"info/files(List)");

                        foreach ($files as $file) {
                                $length = $file->get_elements_by_tagname("length");
                                $size = $length[0]->get_content();


                                if (!is_numeric($size) OR $length[0]->get_attribute("type") != "Integer") {
						$template->assign_block_vars('filesinfo', array(
													'NAME'		    =>	false,
													'SIZE'		    =>	false,
													'ERROR_FILE'	=>	$user->lang['INVALID_FILE_SIZE_NUM'],
													));
                                        continue;
                                }
                                $accum += $size;

                                $path = $file->get_elements_by_tagname("path");

                                if ($path[0]->get_attribute("type") != "List") {
						$template->assign_block_vars('filesinfo', array(
													'NAME'		    =>	false,
													'SIZE'		    =>	false,
													'ERROR_FILE'	=>	$user->lang['INVALID_FILE_PATH'],
													));
                                        continue;
                                }

                                $fpath = Array();
                                foreach ($path[0]->child_nodes() as $child) {
                                        array_push($fpath,$child->get_content());
                                }

						$template->assign_block_vars('filesinfo', array(
													'NAME'		    =>	htmlspecialchars(implode("/",$fpath)),
													'SIZE'		    =>	mksize($size),
													'ERROR_FILE'	=>	false,
													));

                        }
						$template->assign_vars(array(
									'S_FILES_SIZE'			=>	mksize($accum),
									));

                        unset($files, $children, $child, $length, $size, $path, $fpath, $accum);
                }

                //Checking against piece length
                if (!entry_exists($torrent,"info/piece length(Integer)")) {
						$template->assign_vars(array(
									'S_PEACES_LENGTH'			=>	false,
									));
                        break;
                }
                $piece_length = entry_read($torrent,"info/piece length(Integer)");
						$template->assign_vars(array(
									'S_FILES_PEASES_LENGTH'			=>	$piece_length,
									));
                unset($piece_length);

                //Checking against pieces integrity
                if (!entry_exists($torrent,"info/pieces(String)")) {
						$template->assign_vars(array(
									'S_PEACES_CHECK'			=>	false,
									));
                        break;
                }
                $pieces = entry_read($torrent,"info/pieces(String)");
                if (strlen($pieces) % 20 == 0)
				{
						$template->assign_vars(array(
									'S_PEACES_CHECK'			=>	true,
									));
				}
				else
				{
						$template->assign_vars(array(
									'S_PEACES_CHECK'			=>	false,
									));
				}
                unset($pieces);

                //The Torrent is valid till now
						$template->assign_vars(array(
									'S_VALID_TORRENT'			=>	true,
									));

                //DHT Support
                if (entry_exists($torrent,"azureus_properties/dht_backup_enable(Integer)"))
				{
						$template->assign_vars(array(
									'S_DHT_SUPORT'			=>	true,
									));
				}
                else
				{
						$template->assign_vars(array(
									'S_DHT_SUPORT'			=>	false,
									));
				}

                //Multiple Trackers
                if (entry_exists($torrent,"announce-list(List)"))
				{
						$template->assign_vars(array(
									'S_MULTY_SUPORT'			=>	true,
									));
				}
				else
				{
						$template->assign_vars(array(
									'S_MULTY_SUPORT'			=>	false,
									));
				}
                if (($autoscrape OR isset($scrape)) AND preg_match($annregexp_http,$announce) AND !strstr($announce,$announce_url) ) do {
                        @set_time_limit(180);
						$template->assign_vars(array(
									'S_SCRAPE_ANNOUNCE'			=>	$announce,
									));
                        $scrape_url = str_replace("announce","scrape",$announce);
                        $info = entry_get($torrent,"info");
                        $info_hash = sha1(Benc($info));
                        unset($info);
                        $scrape_url .= ((strpos($scrape_url,"?")) ? "&" : "?")."info_hash=".urlencode(pack("H*",$info_hash));

                        if (!$fp = @fopen($scrape_url,"rb")) {
						$template->assign_vars(array(
									'S_SCRAPE_GOOD'			=>	false,
									));
                                break;
                        }
						$template->assign_vars(array(
									'S_SCRAPE_GOOD'			=>	true,
									));

                        $page = "";
                        while (!@feof($fp)) $page .= @fread($fp,1000);
                        @fclose($fp);
                        $scrape = Bdecode($page,"Scrape");
                        unset($page);
                        $info_hash = 'a'.$info_hash;


                        if (isset($showxml) AND $showxml == "true") {
						$template->assign_vars(array(
									'S_SCRAPE_RESULT'			=>	str_replace(Array(" ","\n"),Array("&nbsp;","<br />\n"),htmlspecialchars($scrape->dump_mem(true,"UTF-8"))),
									'S_SCRAPE_SHOW'			=>true,
									));
                        }

                        if (!entry_exists($scrape,"files/".$info_hash."(Dictionary)","Scrape")) {
						$template->assign_vars(array(
									'S_SCRAPE_GOOD'			=>	false,
									));
                        } else {
                                $seeders = entry_read($scrape,"files/".$info_hash."/complete(Integer)","Scrape");
                                $leechers = entry_read($scrape,"files/".$info_hash."/incomplete(Integer)","Scrape");
                                $completed = entry_read($scrape,"files/".$info_hash."/downloaded(Integer)","Scrape");

						$template->assign_vars(array(
									'S_SCRAPE_SEEDERS'			=>	$seeders,
									'S_SCRAPE_LEECHERS'			=>	$leechers,
									'S_SCRAPE_COMPLETED'			=>	$completed,
									));
                        }
                        unset($scrape);


                } while (false);

        } while (false);
        unset($torrent);
}
echo $template->fetch('admin/mcp_clinic.html');
		close_out();
?>