<?php
 #############################################################################
 # IMDBPHP                              (c) Giorgos Giagas & Itzchak Rehberg #
 # written by Giorgos Giagas                                                 #
 # extended & maintained by Itzchak Rehberg <izzysoft AT qumran DOT org>     #
 # http://www.izzysoft.de/                                                   #
 # ------------------------------------------------------------------------- #
 # This program is free software; you can redistribute and/or modify it      #
 # under the terms of the GNU General Public License (see doc/LICENSE)       #
 # ------------------------------------------------------------------------- #
 # Show what we have in the Cache                                            #
 #############################################################################
 # $Id: cache.php,v 1.1 2008/09/21 02:34:43 joerobe Exp $

require_once("imdb.class.php");

$conf = new imdb_config;
echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{S_CONTENT_DIRECTION}" lang="{S_USER_LANG}" xml:lang="{S_USER_LANG}">
    <head>
        <meta name="generator" content="HTML Tidy for Linux (vers 6 November 2007), see www.w3.org">
        <meta http-equiv="Content-Type" content="text/html; charset={S_CONTENT_ENCODING}">
        <meta name="generator" content="PMBT {PMBT_VER}">
        <meta http-equiv="PRAGMA" content="NO-CACHE">
        <meta http-equiv="EXPIRES" content="-1">
        <meta http-equiv="Cache-Control" content="no-cache">
    </head>
    <title>IMDBPHP Cache Contents</title>
    <body>';

$movie = new imdb ("0");

if ($d = opendir ($conf->cachedir))
{
    echo "<table align='center' border='1' style='border-collapse:collapse;margin-top:20px;'>\n"
    . " <tr><th style='background-color:#ffb000'>Movie Details</th><th style='background-color:#ffb000'>imdb page</th></tr>\n";

    while (false !== ($entry = readdir ($d)))
    {
        if (strstr ($entry, "Title"))
        {
            $imdbid = substr ($entry, 0, 7);
            $movie->setid ($imdbid);

            echo " <tr><td><a href='imdb.php?mid=${imdbid}'>".$movie->title()."</a></td>"
                .    "<td><a href=\"http://us.imdb.com/title/tt${imdbid}\">imdb page</a></td></tr>\n";
        }
    }
  echo "</table>\n";
}
echo "</body></html>";

?>