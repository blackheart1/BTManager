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
** And Joe Robertson (aka joeroberts)
** Project Leaders: Black_heart, Thor.
** File ajax/scrape.php 2018-08-27 07:36:00 Thor
**
** CHANGES
**
** 2018-08-31 - Added New Masthead
**/

if (defined('IN_PMBT'))
{
    die ("You can't include this file");
}
else
{
    define("IN_PMBT",true);
}

require_once("include/bdecoder.php");
require_once("include/bencoder.php");

$infohash_hex = $info_hash;
$info_hash    = urlencode(pack('H*', $info_hash ? $info_hash : $info_hash));
$tmp_tracker  = str_replace("announce", "scrape", $tracker) . ((strpos($tracker, "?")) ? "&" : "?") . "info_hash=" . $info_hash;

if ($fp = @fopen($tmp_tracker, "rb"))
{
    stream_set_timeout($fp, 10);

    $page = "";

    while (!feof($fp))
    {
        $page .= @fread($fp, 1000000);
    }
    @fclose($fp);
}

$scrape    = Bdecode($page, "Scrape");
$seeders   = 0 + entry_read($scrape,"files/a" . strtolower($infohash_hex) . "/complete(Integer)", "Scrape");
$leechers  = 0 + entry_read($scrape,"files/a" . strtolower($infohash_hex) . "/incomplete(Integer)", "Scrape");
$completed = 0 + entry_read($scrape,"files/a" . strtolower($infohash_hex) . "/downloaded(Integer)", "Scrape");
$xmldata   = "Seeds: {$seeders}, Peers: {$leechers}, Completed: {$completed}";

header('Content-Type: text/xml');
header('status: 200');
header('Seed: 200');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\" ?>\n";
echo $xmldata;

?>