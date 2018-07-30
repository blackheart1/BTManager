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
** File massupload.php 2018-07-30 08:55:00 Thor
**
** CHANGES
**
** 2018-07-30 - Code Tidy
**/

if (!defined('IN_PMBT'))
{
    include_once './../../security.php';
    die ("You can't access this file directly");
}

$do         = request_var('do', 'massupload');
$page_title = $user->lang['INTRO'];

$user->set_lang('admin/mcp_massupload', $user->ulanguage);

$template->assign_vars(array(
        'PAGE_TITLE'      => $page_title,
        'L_TITLE'         => $user->lang['INTRO'],
        'L_TITLE_EXPLAIN' => $user->lang['INTRO_EXP'],
));

$annregexp_http = "/(http[s]?+):\/\/[-\/.:_\\w]*\/announce[^\/\\s]*/i";
$annregexp_dht  = "/^dht:\/\/[0-9a-f]*.dht\/announce$/i";
$annregexp_udp  = "/udp:\/\/[-\/.:_\\w]*\/announce[^\/\\s]*/i";

define("ANNOUNCE_NONE",0);
define("ANNOUNCE_HTTP",1);
define("ANNOUNCE_DHT",2);

switch ($do)
{
    case "massupload":
    {
        /*
        INTRO SCREEN: USER IS ASKED TO SCAN THE DIRECTORY AND MAY CHOOSE
        TO AUTOMATICALLY DELETE DUPLICATED TORRENTS.
        USER MAY ALSO SET A LIMIT TO SCANNED TORRENTS TO PREVENT PHP
        ERRORS DUE TO EXCESSIVE TIMEOUT OR MEMORY USAGE
        */

        if (!is_dir("massupload"))
        {
            $template->assign_vars(array(
                    'S_USER_NOTICE' => true,
                    'S_FORWARD'     => false,
                    'MESSAGE_TITLE' => $user->lang['GEN_ERROR'],
                    'MESSAGE_TEXT'  => $user->lang['NO_MASSUPDIR'],
            ));

            echo $template->fetch('admin/message_body.html');
            close_out();
        }

        $hidden = build_hidden_fields(array(
                'i'  => $i,
                'op' => $op,
                'do' => 'scantorrents',
        ));

        $template->assign_vars(array(
                'U_ACTION' => './admin.php',
                'HIDDEN'   => $hidden,
                'ACTION'   => 'massupload',
        ));

    break;
    }

    case "scantorrents":
    {
        $hidden = build_hidden_fields(array(
                'i'       => 'torrentinfo',
                'op'      => $op,
                'do'      => 'takemassupload',
                'autodel' => ($autodel) ? '1' : '0',
        ));

        $template->assign_vars(array(
                'U_ACTION' => './admin.php',
                'HIDDEN'   => $hidden,
                'ACTION'   => 'scantorrents',
        ));

        $template->assign_block_vars('tor_block1', array(
                'L_TITLE'    => '',
                'S_SELECTED' => true,
                'U_TITLE'    => '',
        ));

        $table_info = array();

        $cats = genrelist2();
        $s    = '';

        foreach ($cats as $cat)
        {
            $s .= "<optgroup label=\"" . htmlspecialchars($cat["name"]) . "\">";

            $subcats = $cat["subcategory"];

            if (count($subcats) > 0)
            {
                foreach ($subcats as $subcat)
                {
                    $s .= "<option value=\"" . $subcat["id"] . "\">" . htmlspecialchars($subcat["name"]) . "</option>\n";
                }
            }

            $s .= "</optgroup>\n";
        }

        $template->assign_vars(array(
                'TCATS' => $s,
        ));

        require_once("include/bencoder.php");
        require_once("include/bdecoder.php");

        @ini_set("memory_limit", "128M");
        @ini_set("max_execution_time", "600");

        /*
        DIRECTORY SCANNING: THE PROGRAM SCANS THE DIRECTORY TO SEARCH
        FOR NEW TORRENTS. THOSE THAT ARE ALREADY IN THE DATABASE ARE
        IGNORED/DELETED, THEN INFO ARE DISPLAYED
        */

        $maxtorrents = intval(request_var('maxtorrents', '0'));
        $autodel     = (request_var('autodel', 'false') == 'true') ? true : false;
        $cantdel     = false;

        if (!is_dir("massupload"))
        {
            $template->assign_vars(array(
                    'S_USER_NOTICE' => true,
                    'S_FORWARD'     => false,
                    'MESSAGE_TITLE' => $user->lang['GEN_ERROR'],
                    'MESSAGE_TEXT'  => $user->lang['NO_MASSUPDIR'],
            ));

            echo $template->fetch('admin/message_body.html');
            close_out();
        }

        $dir = opendir("massupload");

        $infohashes = Array();

        for ($i = 1; $file = readdir($dir) AND !($maxtorrents > 0 AND $i > $maxtorrents);)
        {
            unset($table_info['FILES']);
            $error = array();
            $table_info['NAME'] = htmlspecialchars($file);

            if (preg_match("/.torrent/", $file))
            {
                $ignored = false;
                $content = file_get_contents("massupload/".$file);
                //Clean up invalid entries in the torrent
                $content =preg_replace('/file-mediali(.*?)ee(.*?):/i', 'file-mediali0ee$2:', $content);
                $content =preg_replace('/file-durationli(.*?)ee(.*?):/i', 'file-durationli0ee$2:', $content);
                $torrent = BDecode($content);
                //die();

                if (!$torrent)
                {
                    $error[] = $user->lang['DECODE_ERROR'];

                    if ($autodel) if (!@unlink("massupload/" . $file)) $cantdel = true;
                }
                else
                {
                    $info      = entry_get($torrent,"info");
                    $info_hash = sha1(Benc($info));

                    unset($info);

                    // Check if Duplicate
                    $sql = "SELECT id FROM " . $db_prefix . "_torrents WHERE info_hash = '" . pack("H*", $info_hash) . "';";
                    $res = $db->sql_query($sql);

                    if ($db->sql_numrows($res))
                    {
                        // Torrent is Already Present
                        list ($id) = $db->fetch_array($res);
                        $error[]   = $user->lang['TOR_EXEST'];
                        $error[]   = $id;

                        $db->sql_freeresult($res);
                        unset($torrent);

                        if ($autodel) if (!@unlink("massupload/" . $file)) $cantdel = true;
                    }
                    else
                    {
                        $db->sql_freeresult($res);

                        if (in_array($info_hash, $infohashes))
                        {
                            //Torrent has been already processed
                            $error[] = $user->lang['TOR_PROS_ALREADY'];

                            unset($torrent);

                            if ($autodel) if (!@unlink("massupload/" . $file)) $cantdel = true;
                        }
                        else
                        {
                            $infohashes[]       = $info_hash;
                            $table_info['HASH'] = $info_hash;

                            // Get Advanced Info
                            // Check Announce
                            $announce = entry_read($torrent, "announce(String)");
                            $ann_type = ANNOUNCE_NONE;

                            if (preg_match($annregexp_http, $announce)) $ann_type = ANNOUNCE_HTTP;

                            if (preg_match($annregexp_udp, $announce)) $ann_type = ANNOUNCE_HTTP;

                            elseif (preg_match($annregexp_dht, $announce)) $ann_type = ANNOUNCE_DHT;

                            if ($ann_type == ANNOUNCE_NONE)
                            {
                                $error[] = $user->lang['INVALID'];

                                if ($autodel) if (!@unlink("massupload/" . $file)) $cantdel = true;
                            }
                            else
                            {
                                $table_info['ANNOUMCE'] = $announce;

                                // Check file and size
                                if (entry_exists($torrent, "info/length(Integer)") AND entry_exists($torrent, "info/name(String)"))
                                {
                                    //Single file
                                    $length = entry_read($torrent, "info/length(Integer)");
                                    $name   = entry_read($torrent, "info/name(String)");

                                    $table_info['FILES'][]['NAME'] = htmlspecialchars($name);
                                    $table_info['FILES'][]['SIZE'] = mksize($length);

                                    unset($length, $name);
                                    //echo "<br />\n";
                                }
                                elseif (entry_exists($torrent, "info/files(List)"))
                                {
                                    //Multiple files
                                    $accum = 0;
                                    $co    = 0;
                                    $files = entry_read($torrent, "info/files(List)");

                                    foreach ($files as $f)
                                    {
                                        $length = $f->get_elements_by_tagname("length");
                                        $size   = $length[0]->get_content();

                                        if (!is_numeric($size) or $length[0]->get_attribute("type") != "Integer")
                                        {
                                            $error[] = $user->lang['INVALIDE_FILE_SIZE'];

                                            unset($torrent);

                                            if ($autodel) if (!@unlink("massupload/".$file)) $cantdel = true;

                                            continue 2;
                                        }

                                        $accum += $size;
                                        $path  = $f->get_elements_by_tagname("path");

                                        if ($path[0]->get_attribute("type") != "List")
                                        {
                                            $error[] = $user->lang['INVALID_FILEPATH'];

                                            $user->lang['INVALID_FILEPATH'];

                                            continue 2;
                                        }

                                        $fpath = Array();

                                        foreach ($path[0]->child_nodes() as $child)
                                        {
                                            array_push($fpath, $child->get_content());
                                        }

                                        $table_info['FILES'][$co]['NAME'] = htmlspecialchars(implode("/", $fpath));
                                        $table_info['FILES'][$co]['SIZE'] = mksize($size);

                                        $co++;
                                    }

                                    $table_info['TOTAL_SIZE'] = mksize($accum);

                                    unset($files, $children, $child, $length, $size, $path, $fpath, $accum, $f);
                                }
                                else
                                {
                                    $error[] = $user->lang['ERROR_NOTCONS'];

                                    unset($torrent);

                                    if ($autodel) if (!@unlink("massupload/" . $file)) $cantdel = true;

                                    continue;
                                }

                                if (!count($error) > 0)
                                {
                                    //DHT Support
                                    $table_info['SUPORT_DHT'] = (entry_exists($torrent, "azureus_properties/dht_backup_enable(Integer)")) ? true : false;

                                    //Multiple Trackers
                                    $table_info['ANNOUNCE_LIST'] = (entry_exists($torrent, "announce-list(List)")) ? true : false;

                                    /*END OF HIDDEN AREA*/

                                    unset($torrent);

                                    $i++;
                                }

                                $sql = 'INSERT INTO ' . $db_prefix . "_massupload(`id`, `name` )
                                        VALUES (NULL , '" . $db->sql_escape($table_info['NAME']) . "');";

                                $db->sql_query($sql);

                                $mas_id = $db->sql_nextid();

                                $template->assign_block_vars('tor_block1.tor_block2', array(
                                        'L_TITLE'    => str_replace(array('[',']'), array('|','|'), $table_info['NAME']),
                                        'ID'         => $mas_id,
                                        'S_SELECTED' => true,
                                        'U_TITLE'    => '1',
                                ));
                            }

                            //die(print_r($table_info));
                            $template->assign_block_vars('tor_block1.tor_block2.tor_block3', $table_info);

                            if ($table_info['FILES'])
                            {
                                foreach($table_info['FILES'] as $var)
                                {
                                    $template->assign_block_vars('tor_block1.tor_block2.tor_block3.tor_block4', $var);
                                }
                            }
                        }
                        // iNvalid Data
                    }
                    // Infohash in Database
                }
                // Torrent Listed
            }
            // dEcoding Error
        }
        // Not a Torrent
        closedir($dir);
        //break;
        echo $template->fetch('admin/mcp_massupload.html');
        close_out();
    }

    case "takemassupload":
    {
        require_once("include/torrent_functions.php");
        require_once("include/bdecoder.php");
        require_once("include/bencoder.php");
        include_once('include/class.bbcode.php');

        @ini_set("memory_limit", "128M");
        @ini_set("max_execution_time", "600");

        /*
        TORRENTS ARE NOW BEING PROCESSED
        */
        $uploader_host = gethostbyaddr($_SERVER["REMOTE_ADDR"]); //uploader's hostname
        $owner         = (isset($anonupload) AND $anonupload == "true") ? 0 : $user->id;
        $ownertype     = ($owner != 0) ? 0 : 2;
        $q_m           = array();

        $sql_m = 'SELECT id AS id, name AS name
                  FROM `' . $db_prefix . '_massupload`';

        $res_m = $db->sql_query($sql_m);

        while($row = $db->sql_fetchrow($res_m))
        {
            $q_m[$row['name']] = array('ID' => $row['id'], 'Name' => $row['name']);
        }

        $cantdel = false;

        if (!is_dir("massupload")) bterror($user->lang['NO_MASSUPDIR'], $user->lang['BT_ERROR']);

        $dir = opendir("massupload");

        while ($file = readdir($dir))
        {
            $category = $_POST['upload_'][str_replace(array('[',']'), array('|','|'), htmlspecialchars($file))]['cat'];

            if ($category < 1 AND $_POST['upload_'][str_replace(array('[',']'), array('|','|'), htmlspecialchars($file))]['upload'] == "true") bterror($user->lang['NO_CAT_SET'], $user->lang['BT_ERROR']);

            $cats   = catlist();
            $in_cat = false;

            while ($cat = each($cats) AND !$in_cat)
            {
                if ($category == $cat[1]["id"]) $in_cat = true;
            }

            if (!$in_cat AND $_POST['upload_'][str_replace(array('[',']'), array('|','|'), htmlspecialchars($file))]['upload'] == "true");
            {
                $template->assign_block_vars('massuploaded', array(
                        'ERROR'        => true,
                        'ERROR_TXT'    => $user->lang['ILLIGALCAT'],
                        'NAME'         => htmlspecialchars($file),
                        'ANNOUNCE_URL' => $user->lang['UNKNOWN'],
                        'SEEDERS'      => '0',
                        'LEECHERS'     => '0',
                ));

                continue;
            }

            $desc = $_POST['upload_'][str_replace(array('[',']'), array('|','|'), htmlspecialchars($file))]['desc'];
            $desc = (STRIP)? stripslashes($desc) : $desc;

            if (!class_exists('parse_message'))
            {
                include('include/message_parser.' . $phpEx);
            }

            $message_parser = new parse_message($desc);
            $message_parser->parse(true, true, true);

            $desc = $message_parser->message;

            if (!preg_match('/^(.+)\.torrent$/si', $file, $matches)) continue;

            $shortfname = $torrentname = $matches[1];
            $htmlfile = base64_encode($file);

            if (!isset($q_m[htmlspecialchars($file)]) or $_POST['upload_'][str_replace(array('[',']'), array('|','|'), htmlspecialchars($file))]['upload'] != "true") continue;

            $db->sql_query('DELETE FROM `' . $db_prefix . '_massupload` WHERE `id` = ' . $_POST['upload_'][str_replace(array('[',']'), array('|','|'), htmlspecialchars($file))]['id'] . ' LIMIT 1');

            $content = file_get_contents("massupload/" . $file);

            // Clean up invalid entries in the torrent
            $content = preg_replace('/file-mediali(.*?)ee(.*?):/i', 'file-mediali0ee$2:', $content);
            $content = preg_replace('/file-durationli(.*?)ee(.*?):/i', 'file-durationli0ee$2:', $content);
            $torrent = BDecode($content);

            if (!$torrent)
            {
                $template->assign_block_vars('massuploaded', array(
                        'ERROR'        => true,
                        'ERROR_TXT'    => $user->lang['DECODE_ERROR'],
                        'NAME'         => htmlspecialchars($file),
                        'ANNOUNCE_URL' => $user->lang['UNKNOWN'],
                        'SEEDERS'      => '0',
                        'LEECHERS'     => '0',
                ));

                if ($autodel) if (!@unlink("massupload/" . $file)) $cantdel = true;

                continue;
            }

            if (!entry_exists($torrent,"info(Dictionary)"))
            {
                $template->assign_block_vars('massuploaded', array(
                        'ERROR'        => true,
                        'ERROR_TXT'    => $user->lang['MISSING_DATA'],
                        'NAME'         => htmlspecialchars($file),
                        'ANNOUNCE_URL' => $user->lang['UNKNOWN'],
                        'SEEDERS'      => '0',
                        'LEECHERS'     => '0',
                 ));

                unset($torrent);

                if ($autodel) if (!@unlink("massupload/" . $file)) $cantdel = true;

                continue;
            }

            if (!entry_exists($torrent, "announce(String)"))
            {
                $template->assign_block_vars('massuploaded', array(
                        'ERROR'        => true,
                        'ERROR_TXT'    => $user->lang['MISSING_DATA'],
                        'NAME'         => htmlspecialchars($file),
                        'ANNOUNCE_URL' => $user->lang['UNKNOWN'],
                        'SEEDERS'      => '0',
                        'LEECHERS'     => '0',
                ));

                unset($torrent);

                if ($autodel) if (!@unlink("massupload/" . $file)) $cantdel = true;

                continue;
            }

            $info     = entry_read($torrent, "info(Dictionary)");
            $announce = entry_read($torrent, "announce(String)");

            // Checking against DHT
            $dht = "no";

            if (entry_exists($torrent, "azureus_properties/dht_backup_enable(Integer)"))
            {
                if (entry_read($torrent, "azureus_properties/dht_backup_enable(Integer)") != 0) $dht = "yes";
            }

            if (!entry_exists($torrent,"info/piece length(Integer)"))
            {
                $template->assign_block_vars('massuploaded',array(
                        'ERROR'        => true,
                        'ERROR_TXT'    => $user->lang['MISSING_DATA'],
                        'NAME'         => htmlspecialchars($file),
                        'ANNOUNCE_URL' => $user->lang['UNKNOWN'],
                        'SEEDERS'      => '0',
                        'LEECHERS'     => '0',
                ));

                unset($torrent);

                if ($autodel) if (!@unlink("massupload/".$file)) $cantdel = true;

                continue;
            }

            if (!entry_exists($torrent,"info/pieces(String)"))
            {
                $template->assign_block_vars('massuploaded',array(
                        'ERROR'        => true,
                        'ERROR_TXT'    => $user->lang['MISSING_DATA'],
                        'NAME'         => htmlspecialchars($file),
                        'ANNOUNCE_URL' => $user->lang['UNKNOWN'],
                        'SEEDERS'      => '0',
                        'LEECHERS'     => '0',
                ));

                unset($torrent);

                if ($autodel) if (!@unlink("massupload/" . $file)) $cantdel = true;

                continue;
            }

            $dname = (entry_exists($torrent, "info/name(String)")) ? $dname = entry_read($torrent,"info/name(String)") : "";
            $plen = entry_read($torrent, "info/piece length(Integer)");
            $pieces = entry_read($torrent, "info/pieces(String)");

            if (strlen($pieces) % 20 != 0)
            {
                $template->assign_block_vars('massuploaded', array(
                        'ERROR'        => true,
                        'ERROR_TXT'    => $user->lang['INVALID_PEASES'],
                        'NAME'         => htmlspecialchars($file),
                        'ANNOUNCE_URL' => $user->lang['UNKNOWN'],
                        'SEEDERS'      => '0',
                        'LEECHERS'     => '0',
                ));

                unset($torrent);

                if ($autodel) if (!@unlink("massupload/" . $file)) $cantdel = true;

                continue;
            }

            $tcomment = (entry_exists($torrent, "comment(String)")) ? entry_read($torrent, "comment(String)") : "";

            #Parsing Torrent Description
            if (get_magic_quotes_gpc()) $tcomment = stripslashes($tcomment);

            $descr = htmlspecialchars($tcomment);
            $descr = $db->sql_escape($desc . "\n" . $descr);

            #Parsing Announce
            if (in_array($announce, $site_announce))
            {
                if ($stealthmode)
                {
                    $template->assign_block_vars('massuploaded', array(
                            'ERROR'        => true,
                            'ERROR_TXT'    => sprintf($user->lang['TRACKER_DISABLED'], $sitename),
                            'NAME'         => htmlspecialchars($file),
                            'ANNOUNCE_URL' => $user->lang['UNKNOWN'],
                            'SEEDERS'      => '0',
                            'LEECHERS'     => '0',
                    ));

                    unset($torrent);

                    if ($autodel) if (!@unlink("massupload/" . $file)) $cantdel = true;

                    continue;
                }

                $announce = "";
            }
            elseif (preg_match($annregexp_http, $announce) or preg_match($annregexp_udp, $announce))
            {
                $sql = "SELECT id FROM " . $db_prefix . "_trackers WHERE url = '" . addslashes($announce) . "' AND status = 'blacklisted' LIMIT 1;";

                $res = $db->sql_query($sql);

                if ($db->sql_numrows($res) > 0)
                {
                    $template->assign_block_vars('massuploaded', array(
                            'ERROR'        => true,
                            'ERROR_TXT'    => sprintf($user->lang['BLACKLISTEDTRACKER'], $announce),
                            'NAME'         => htmlspecialchars($file),
                            'ANNOUNCE_URL' => $announce,
                            'SEEDERS'      => '0',
                            'LEECHERS'     => '0',
                    ));

                    unset($torrent);

                    $db->sql_freeresult($res);

                    if ($autodel) if (!@unlink("massupload/" . $file)) $cantdel = true;

                    continue;
                }

                $db->sql_freeresult($res);
            }
            elseif (preg_match($annregexp_dht,  $announce))
            {
                $dht = "yes";
            }
            else
            {
                $template->assign_block_vars('massuploaded', array(
                        'ERROR'        => true,
                        'ERROR_TXT'    => sprintf($user->lang['INVALID_ANNOUNCE'], $announce),
                        'NAME'         => htmlspecialchars($file),
                        'ANNOUNCE_URL' => $announce,
                        'SEEDERS'      => '0',
                        'LEECHERS'     => '0',
                ));

                unset($torrent);

                if ($autodel) if (!@unlink("massupload/" . $file)) $cantdel = true;

                continue;
            }

            // UDP trackers or trackers inside the TOR/I2P networks are not supported *yet*

            #Parsing Multiple Announce
            $trackers       = "NULL";
            $backup_tracker = "false";

            if (entry_exists($torrent, "announce-list(List)"))
            {
                $trackers = Array();
                $to_check = Array();

                $announce_list = entry_read($torrent, "announce-list(List)");

                foreach ($announce_list as $group)
                {
                    $trackers_in_group = Array();

                    foreach ($group->child_nodes() as $tracker_node)
                    {
                        $tracker = $tracker_node->get_content();
                        /* if (!preg_match($annregexp_http, $tracker) AND !preg_match($annregexp_udp, $tracker))
                        {
                            bterror(_btinvannounce . "<b>" . $tracker . "</b>", _btuploaderror, false);

                            $template->assign_block_vars('massuploaded', array(
                                    'ERROR'        => true,
                                    'ERROR_TXT'    => sprintf($user->lang['INVALID_ANNOUNCE'], $tracker),
                                    'NAME'         => htmlspecialchars($file),
                                    'ANNOUNCE_URL' => $tracker,
                                    'SEEDERS'      => '0',
                                    'LEECHERS'     => '0',
                            ));

                            unset($torrent);

                            if ($autodel) if (!@unlink("massupload/".$file)) $cantdel = true;

                            continue 3;
                        }*/

                        // If the main tracker is NOT this one, but this one APPEARS within the Announce list then we're running backup tracker
                        if (in_array($tracker["value"], $site_announce) AND $announce != "") $backup_tracker = "true";

                        array_push($trackers_in_group, $tracker);
                        array_push($to_check, "'" . $tracker . "'");

                        unset($tracker, $tracker_node);
                    }
                    array_push($trackers, $trackers_in_group);

                    unset($trackers_in_group, $group);
                }

                $sql = "SELECT url FROM " . $db_prefix . "_trackers WHERE url IN (".implode(", ",$to_check) . ") AND status = 'blacklisted';";

                $res = $db->sql_query($sql) or btsqlerror($sql);

                if ($db->sql_numrows($res) > 0)
                {
                    $blacklisted_trackers = $db->sql_fetchrowset($res);
                    $blacklisted_trackers = implode(", ", $blacklisted_trackers);

                    $template->assign_block_vars('massuploaded', array(
                            'ERROR'        => true,
                            'ERROR_TXT'    => sprintf($user->lang['BLACKLISTEDTRACKER'], $blacklisted_trackers),
                            'NAME'         => htmlspecialchars($file),
                            'ANNOUNCE_URL' => $announce,
                            'SEEDERS'      => '0',
                            'LEECHERS'     => '0',
                    ));

                    unset($torrent);

                    if ($autodel) if (!@unlink("massupload/" . $file)) $cantdel = true;

                    continue;
                }

                $db->sql_freeresult($res);

                unset($sql, $to_check,$announce_list, $res);

                for ($i = 0; $i < count($trackers); $i++) $trackers[$i] = implode("\n", $trackers[$i]);

                $trackers = "'" . addslashes(implode("\n\n", $trackers)) . "'";
            }

            #Parsing files
            $filelist = Array();

            if (entry_exists($torrent, "info/length(Integer)"))
            {
                //Single file
                $totallen = entry_read($torrent, "info/length(Integer)");

                if (entry_exists($torrent, "info/sha1(String)"))
                {
                    $sha1code = entry_read($torrent, "info/sha1(String)");
                    $magnet_link = "magnet:?xt=urn:sha1:" . addslashes(hex_to_base32($sha1code)) . "&dn=" . urlencode($dname);
                }
                else
                {
                    $magnet_link = "";
                }

                if (entry_exists($torrent, "info/ed2k(String)"))
                {
                    $ed2k = entry_read($torrent, "info/ed2k(String)");
                    $ed2k_link = "ed2k://|file|" . urlencode($dname) . "|" . $totallen . "|" . strtoupper(str_pad($ed2k,32, "0")) . "|/";
                }
                else
                {
                    $ed2k_link = "";
                }

                $filelist[] = Array($dname, $totallen, $magnet_link, $ed2k_link);

                $type = "single";

            } else
            {
                //Multiple files
                $flist = entry_read($torrent, "info/files(List)");

                 if (!isset($flist))
                 {
                    $template->assign_block_vars('massuploaded', array(
                            'ERROR'        => true,
                            'ERROR_TXT'    => $user->lang['MISSING_DATA'],
                            'NAME'         => htmlspecialchars($file),
                            'ANNOUNCE_URL' => $announce,
                            'SEEDERS'      => '0',
                            'LEECHERS'     => '0',
                    ));

                    unset($torrent);

                    if ($autodel) if (!@unlink("massupload/" . $file)) $cantdel = true;

                    continue;

                }

                if (!count($flist))
                {
                    $template->assign_block_vars('massuploaded', array(
                            'ERROR'         => true,
                            'ERROR_TXT'     => $user->lang['MISSING_DATA'],
                            'NAME'          => htmlspecialchars($file),
                            'ANNOUNCE_URL'  => $announce,
                            'SEEDERS'       => '0',
                            'LEECHERS'      => '0',
                    ));

                    unset($torrent);

                    if ($autodel) if (!@unlink("massupload/" . $file)) $cantdel = true;

                    continue;
                }

                $totallen = 0;

                foreach ($flist as $fn)
                {
                    $ffe         = "";
                    $magnet_link = "";
                    $ed2k_link   = "";

                    $children = $fn->child_nodes();
                    $f = Array();

                    foreach ($children as $child)
                    {
                        $f[$child->tagname] = $child;
                    }

                    if (!array_key_exists("length",$f) or !array_key_exists("path", $f))
                    {
                        $template->assign_block_vars('massuploaded', array(
                                'ERROR'         => true,
                                'ERROR_TXT'     => $user->lang['MISSING_DATA'],
                                'NAME'          => htmlspecialchars($file),
                                'ANNOUNCE_URL'  => $announce,
                                'SEEDERS'       => '0',
                                'LEECHERS'      => '0',
                        ));

                        unset($torrent);

                        if ($autodel) if (!@unlink("massupload/" . $file)) $cantdel = true;

                        continue 2;
                    }

                    $ll = $f["length"]->get_content();

                    $path = Array();

                    foreach ($f["path"]->child_nodes() as $p) array_push($path, $p->get_content());

                    $ffe = implode("/", $path);

                    if (empty($ffe))
                    {
                        $template->assign_block_vars('massuploaded', array(
                                'ERROR'        => true,
                                'ERROR_TXT'    => $user->lang['MISSING_DATA'],
                                'NAME'         => htmlspecialchars($file),
                                'ANNOUNCE_URL' => $announce,
                                'SEEDERS'      => '0',
                                'LEECHERS'     => '0',
                        ));

                        unset($torrent);

                        if ($autodel) if (!@unlink("massupload/" . $file)) $cantdel = true;

                        continue 2;
                    }

                    if (array_key_exists("sha1",$f))
                    {
                        $magnet_link = "magnet:?xt=urn:sha1:" . addslashes(hex_to_base32($f["sha1"]->get_content())) . "&dn=" . urlencode($path[count($path)-1]);
                    }

                    if (array_key_exists("ed2k", $f))
                    {
                        $ed2k_link = "ed2k://|file|" . urlencode($path[count($path)-1]) . "|" . $ll . "|" . strtoupper(str_pad($f["ed2k"]->get_content(),32,0)) . "|/";
                    }

                    unset($p, $path);

                    $filelist[] = Array($ffe, $ll, $magnet_link, $ed2k_link);
                    $totallen   += $ll;
                }

                $type = "multi";
            }

            #Info Hash. The most important value
            $info         = entry_get($torrent, "info");
            $infohash_hex = @sha1(Benc($info));
            $infohash     = pack("H*", $infohash_hex);

            unset($info);
            unset($torrent);

            #Checking against the SAME Torrent
            $sql = "SELECT id FROM " . $db_prefix . "_torrents WHERE info_hash = '" . addslashes($infohash) . "';";

            $res = $db->sql_query($sql) or btsqlerror($sql);

            if ($db->sql_numrows($res) > 0)
            {
                list ($id) = $db->fetch_array($res);

                $template->assign_block_vars('massuploaded', array(
                        'ERROR'        => true,
                        'ERROR_TXT'    => $user->lang['TOR_PROS_ALREADY'],
                        'NAME'         => htmlspecialchars($file),
                        'ANNOUNCE_URL' => $announce,
                        'SEEDERS'      => '0',
                        'LEECHERS'     => '0',
                ));

                $db->sql_freeresult($res);

                unset($torrent);

                if ($autodel) if (!@unlink("massupload/" . $file)) $cantdel = true;

                continue;
            }

            $db->sql_freeresult($res);

            #Parsing keywords
            preg_match_all('/([\\w]{6,}+)/', $descr, $search_descr);
            preg_match_all('/([\\w]{6,}+)/', $dname, $search_name);

            $searchtext = $shortfname . " " . implode(" ", $search_descr[0]) . " " . implode(" ", $search_name[0]);

            $force_upload = false; //Used to force upload even if Torrent has 0 peers or the tracker does not respond
            $seeders = $leechers = $tot_peer = 0;

            if ($autoscrape AND $announce != "" AND !$scrapelater)
            {
                $scrape_url = str_replace("announce", "scrape", $announce);

                $tmp_tracker = $scrape_url . ((strpos($scrape_url, "?")) ? "&" : "?") . "info_hash=" . urlencode($infohash);
                //echo $tmp_tracker;
                if (!ResolveTracker($scrape_url, $resp))
                {
                    $err = $scrape_url . "<br />" . $user->lang['CANNOT_CANTACT_URL'];

                    if ($resp) $err .= " (".htmlspecialchars(addslashes($resp)) . ")";

                    $template->assign_block_vars('massuploaded', array(
                            'ERROR'         => true,
                            'ERROR_TXT'     => $err,
                            'NAME'          => htmlspecialchars($file),
                            'ANNOUNCE_URL'  => $announce,
                            'SEEDERS'       => '0',
                            'LEECHERS'      => '0',
                    ));

                    if ($autodel) if (!@unlink("massupload/" . $file)) $cantdel = true;

                    continue;
                    break;
                }

                $scrape = getscrapedata ($tmp_tracker, false, array($infohash=>preg_replace_callback('/./s', "hex_esc", str_pad($infohash, 20))));

                if ($scrape)
                {
                    #Debug 2
                    //echo str_replace(Array(" ", "\n"), Array("&nbsp;", "<br />\n"), htmlspecialchars($scrape->dump_mem(true, "UTF-8")));
                    #Check data

                    if (!entry_exists($scrape,"files(dictionary)", "Scrape"))
                    {
                        $template->assign_block_vars('massuploaded', array(
                                'ERROR'        => true,
                                'ERROR_TXT'    => $user->lang['BAD_TRK_RESPONCE'],
                                'NAME'         => htmlspecialchars($file),
                                'ANNOUNCE_URL' => $announce,
                                'SEEDERS'      => '0',
                                'LEECHERS'     => '0',
                        ));

                        if ($autodel) if (!@unlink("massupload/" . $file)) $cantdel = true;

                        continue;
                        break;
                    }
                    elseif (!entry_exists($scrape, "files/a" . $infohash_hex . "(Dictionary)", "Scrape"))
                    {
                        $template->assign_block_vars('massuploaded', array(
                                'ERROR'        => true,
                                'ERROR_TXT'    => $user->lang['NOT_REDG_TO_TRACK'],
                                'NAME'         => htmlspecialchars($file),
                                'ANNOUNCE_URL' => $announce,
                                'SEEDERS'      => '0',
                                'LEECHERS'     => '0',
                        ));

                        if ($autodel) if (!@unlink("massupload/" . $file)) $cantdel = true;

                        continue;
                        break;
                    }
                    else
                    {
                        #Check seeder
                        $seeders = entry_read($scrape,"files/a" . $infohash_hex . "/complete(Integer)", "Scrape");

                        if ($seeders <= 0 AND !$force_upload)
                        {
                            $template->assign_block_vars('massuploaded', array(
                                    'ERROR'         => true,
                                    'ERROR_TXT'     => $user->lang['DEAD_TORRENT'],
                                    'NAME'          => htmlspecialchars($file),
                                    'ANNOUNCE_URL'  => $announce,
                                    'SEEDERS'       => '0',
                                    'LEECHERS'      => '0',
                            ));

                            if ($autodel) if (!@unlink("massupload/" . $file)) $cantdel = true;

                            continue;
                            break;
                        }

                        $leechers = entry_read($scrape, "files/a" . $infohash_hex . "/incomplete(Integer)", "Scrape");
                        $completed = entry_read($scrape, "files/a" . $infohash_hex . "/downloaded(Integer)", "Scrape");
                    }

                    unset($scrape);

                    $visible = ($tot_peer > 0) ? "yes" : "no";
                }
                elseif (!$force_upload)
                {
                    $template->assign_block_vars('massuploaded', array(
                            'ERROR'         => true,
                            'ERROR_TXT'     => $user->lang['CANNOT_CANTACT_URL'],
                            'NAME'          => htmlspecialchars($file),
                            'ANNOUNCE_URL'  => $announce,
                            'SEEDERS'       => '0',
                            'LEECHERS'      => '0',
                    ));

                    if ($autodel) if (!@unlink("massupload/" . $file)) $cantdel = true;

                    continue;
                    break;
                }
            }
            else
            {
                $completed = 0;
                $visible   = ($announce != "") ? "yes" : "no";
            }

            #Preparing SQL
            $torrentfields = Array();
            $torrentvalues = Array();

            $torrentfields[] = "info_hash";
            $torrentvalues[] = "'" . addslashes($infohash) . "'";

            $torrentfields[] = "name";
            $torrentvalues[] = "'" . addslashes($file) . "'";

            $torrentfields[] = "filename";
            $torrentvalues[] = "'" . addslashes($dname) . "'";

            $torrentfields[] = "save_as";
            $torrentvalues[] = "'" . addslashes($shortfname) . "'";

            $torrentfields[] = "md5sum";
            $torrentvalues[] = "'" . md5_file("massupload/" . $file) . "'";

            $torrentfields[] = "search_text";
            $torrentvalues[] = "'" . addslashes($searchtext) . "'";

            $torrentfields[] = "descr";
            $torrentvalues[] = "'" . $descr . "'";

            // Poster Modd
            $torrentfields[] = "post_img";
            $torrentvalues[] = "NULL";

            //ScreenShot Modd
            $torrentfields[] = "screan1";
            $torrentvalues[] = "NULL";

            $torrentfields[] = "screan2";
            $torrentvalues[] = "NULL";

            $torrentfields[] = "screan3";
            $torrentvalues[] = "NULL";

            $torrentfields[] = "screan4";
            $torrentvalues[] = "NULL";

            $torrentfields[] = "size";
            $torrentvalues[] = "'" . $totallen . "'";

            $torrentfields[] = "plen";
            $torrentvalues[] = "'" . $plen . "'";

            $torrentfields[] = "category";
            $torrentvalues[] = "'" . intval($category) . "'";

            $torrentfields[] = "type";
            $torrentvalues[] = "'" . $type . "'";

            $torrentfields[] = "numfiles";
            $torrentvalues[] = "'" . count($filelist) . "'";

            $torrentfields[] = "added";
            $torrentvalues[] = "NOW()";

            $torrentfields[] = "exeem";
            $torrentvalues[] = "NULL";

            $torrentfields[] = "dht";
            $torrentvalues[] = "'" . $dht . "'";

            $torrentfields[] = "backup_tracker";
            $torrentvalues[] = "'" . $backup_tracker . "'";

            $torrentfields[] = "views";
            $torrentvalues[] = "'0'";

            $torrentfields[] = "downloaded";
            $torrentvalues[] = "'0'";

            $torrentfields[] = "completed";
            $torrentvalues[] = "'" . $completed . "'";

            $torrentfields[] = "banned";
            $torrentvalues[] = "'no'";

            $torrentfields[] = "password";
            $torrentvalues[] = "NULL";

            $torrentfields[] = "visible";
            $torrentvalues[] = "'" . $visible . "'";

            $torrentfields[] = "evidence";
            $torrentvalues[] = "'" . intval($evidence) . "'";

            $torrentfields[] = "owner";
            $torrentvalues[] = "'" . $owner . "'";

            $torrentfields[] = "ownertype";
            $torrentvalues[] = "'" . $ownertype . "'";

            $torrentfields[] = "uploader_host";
            $torrentvalues[] = "'" . $uploader_host . "'";

            $torrentfields[] = "numratings";
            $torrentvalues[] = "'0'";

            $torrentfields[] = "ratingsum";
            $torrentvalues[] = "'0'";

            $torrentfields[] = "seeders";
            $torrentvalues[] = "'" . intval($seeders) . "'";

            $torrentfields[] = "leechers";
            $torrentvalues[] = "'" . intval($leechers) . "'";

            $torrentfields[] = "tot_peer";
            $torrentvalues[] = "'" . intval($seeders + $leechers) . "'";

            $torrentfields[] = "speed";
            $torrentvalues[] = "'0'";

            $torrentfields[] = "comments";
            $torrentvalues[] = "'0'";

            $torrentfields[] = "complaints";
            $torrentvalues[] = "'0,0'";

            $torrentfields[] = "tracker";

            if ($announce == "") $torrentvalues[] = "NULL";

            else $torrentvalues[] = "'" . $announce . "'";

            $torrentfields[] = "tracker_list";
            $torrentvalues[] = $trackers;

            $torrentfields[] = "tracker_update";
            $torrentvalues[] = "NOW()";

            $torrentfields[] = "last_action";
            $torrentvalues[] = "NOW()";


            $torrentsql = "INSERT INTO " . $db_prefix . "_torrents (" . implode(", ", $torrentfields) . ") VALUES (" . implode(", ", $torrentvalues) . ");";

            $db->sql_query($torrentsql) or btsqlerror($torrentsql);

            $id = $db->sql_nextid();

            if ($id == 0) bterror($user->lang["INVALID_ID"], $user->lang['BT_ERROR']);

            if ($announce != "") $db->sql_query("INSERT INTO " . $db_prefix . "_trackers (url, updated) VALUES ('" . addslashes($announce) . "', NOW());");

            $db->sql_query("DELETE FROM " . $db_prefix . "_files WHERE torrent = '" . $id . "'") or btsqlerror("DELETE FROM " . $db_prefix . "_files WHERE torrent = '$id'");

            foreach ($filelist as $f)
            {
                list ($fname, $fsize, $magnet, $ed2k) = $f;

                $fields = "(torrent, filename, size";

                $values = "('" . $id . "', '" . str_replace("'", "\'", $fname) . "', '" . $fsize . "'";

                if ($magnet != "")
                {
                    $fields.= ", magnet";
                    $values.= ", '" . addslashes($magnet) . "'";
                }

                if ($ed2k != "")
                {
                    $fields.= ", ed2k";
                    $values.= ", '" . addslashes($ed2k) . "'";
                }

                $fields.= ")";
                $values.= ")";

                $filesql = "INSERT INTO " . $db_prefix . "_files " . $fields . " VALUES " . $values . ";";

                if (!$db->sql_query($filesql))
                {   //Rollback
                    $db->sql_query("DELETE FROM " . $db_prefix . "_torrents WHERE id = '" . $id . "' LIMIT 1;");
                    $db->sql_query("DELETE FROM " . $db_prefix . "_files WHERE torrent = '" . $id . "';");

                    btsqlerror($filesql);
                }
            }

            $torrentpath = $torrent_dir . "/" . $id . ".torrent";

            if (file_exists($torrentpath)) unlink($torrentpath);

            copy("massupload/" . $file,$torrentpath);

            if (!@unlink("massupload/" . $file)) $cantdel = true;

            $template->assign_block_vars('massuploaded', array(
                    'ERROR'        => false,
                    'ERROR_TXT'    => false,
                    'NAME'         => htmlspecialchars($torrentname),
                    'ANNOUNCE_URL' => $announce,
                    'SEEDERS'      => intval($seeders),
                    'LEECHERS'     => intval($leechers),
            ));

            $mesg = sprintf($user->lang['SHOUT_NEW_UPLOAD'], $siteurl, $id, $torrentname);

            if (isset($shout))
            {
                $sql = 'INSERT INTO ' . $db_prefix . "_shouts (id, user, text, posted, id_to)
                        VALUES (NULL, '{$owner}', '{$mesg}', NOW(), '0');";

                $db->sql_query($sql);
            }
        }

        closedir($dir);

        $template->assign_vars(array(
                'U_ACTION' => '',
                'ACTION'   => 'takemassupload',
                'CANTDEL'  => ($cantdel)? true : false,
        ));

        break;
    }
}

echo $template->fetch('admin/mcp_massupload.html');
close_out();

?>