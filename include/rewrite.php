<?php
/*
*-------------------------------phpMyBitTorrent--------------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
*-------------               http://www.p2pmania.it               -------------*
*------------ Based on the Bit Torrent Protocol made by Bram Cohen ------------*
*-------------              http://www.bittorrent.com             -------------*
*------------------------------------------------------------------------------*
*------------------------------------------------------------------------------*
*--   This program is free software; you can redistribute it and/or modify   --*
*--   it under the terms of the GNU General Public License as published by   --*
*--   the Free Software Foundation; either version 2 of the License, or      --*
*--   (at your option) any later version.                                    --*
*--                                                                          --*
*--   This program is distributed in the hope that it will be useful,        --*
*--   but WITHOUT ANY WARRANTY; without even the implied warranty of         --*
*--   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the          --*
*--   GNU General Public License for more details.                           --*
*--                                                                          --*
*--   You should have received a copy of the GNU General Public License      --*
*--   along with this program; if not, write to the Free Software            --*
*-- Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA --*
*--                                                                          --*
*------------------------------------------------------------------------------*
*------              ©2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*/
if (eregi("rewrite.php",$_SERVER["PHP_SELF"])) die ("You can't access this file directly");
if ($rewrite_engine) {
$buffer = ob_get_clean();


//Valid HTML
$buffer = preg_replace("(&(?!([a-zA-Z]{2,6}|[0-9\#]{1,6})[\;]))", "&amp;", $buffer);
$buffer = str_replace(array("&amp;&amp;", "&amp;middot", "&amp;nbsp"), array("&&", "·", " ;"), $buffer);


        $rewrite_search = Array();
        $rewrite_replace = Array();

        $rewrite_search[] = "'(?<!//)index\.php\?cat=([0-9]*)&amp;page=([0-9]*)'";
        $rewrite_replace[] = "torrent-page-\\2-cat-\\1.html";

        $rewrite_search[] = "'(?<!//)index\.php\?page=([0-9]*)'";
        $rewrite_replace[] = "home-page-\\1";

        $rewrite_search[] = "'(?<!//)index\.php\?cat=([0-9]*)'";
        $rewrite_replace[] = "home-cat-\\1";

        $rewrite_search[] = "'(?<!//)index\.php'";
        $rewrite_replace[] = "home";

        $rewrite_search[] = "'(?<!//)phpBB\.php?page=([a-zA-Z]*)\.php\&amp;([a-zA-Z0-9]*)'";
        $rewrite_replace[] = "forum-\\1";

        $rewrite_search[] = "'(?<!//)phpBB\.php'";
        $rewrite_replace[] = "forum";

        $rewrite_search[] = "'(?<!//)phpBB\.php\?index\.php'";
        $rewrite_replace[] = "forum";

        $rewrite_search[] = "'(?<!//)user\.php\?op=([a-zA-Z]*)\&amp;id=([0-9]*)'";
        $rewrite_replace[] = "user-\\1-\\2";

        $rewrite_search[] = "'(?<!//)download\.php\?id=([0-9]*)'";
        $rewrite_replace[] = "export-\\1";

       /* $rewrite_search[] = "'(?<!//)download\.php\?id=([0-9]*)&password=([a-zA-Z]*)'";
        $rewrite_replace[] = "download-\\1-pass-\\2.torrent";

        $rewrite_search[] = "'(?<!//)download\.php\?id=([0-9]*)'";
        $rewrite_replace[] = "download-\\1.torrent";

        $rewrite_search[] = "'(?<!//)edit\.php\?id=([0-9]*)'";
        $rewrite_replace[] = "edit-\\1.html";

        $rewrite_search[] = "'(?<!//)edit\.php\?op=delete&amp;id=([0-9]*)'";
        $rewrite_replace[] = "delete-\\1.html";

        $rewrite_search[] = "'(?<!//)mytorrents\.php\?op=displaytorrent&amp;id=([0-9]*)'";
        $rewrite_replace[] = "displaytorrent-\\1.html";

        $rewrite_search[] = "'(?<!//)mytorrents\.php'";
        $rewrite_replace[] = "mytorrents.html";

        $rewrite_search[] = "'(?<!//)user\.php\?op=editprofile'";
        $rewrite_replace[] = "editprofile.html";

        $rewrite_search[] = "'(?<!//)user\.php\?op=profile&amp;username=([^&\"]*)'";
        $rewrite_replace[] = "viewprofile-\\1.html";

        $rewrite_search[] = "'(?<!//)user\.php\?op=profile&amp;id=([0-9]*)'";
        $rewrite_replace[] = "profile-\\1.html";

        $rewrite_search[] = "'(?<!//)pm\.php?op=inbox'";
        $rewrite_replace[] = "inbox.html";

        $rewrite_search[] = "'(?<!//)pm\.php?op=inbox&page=([0-9]*)'";
        $rewrite_replace[] = "inbox-page-\\1.html";

        $rewrite_search[] = "'(?<!//)pm\.php?op=readmsg&mid=([0-9]*)'";
        $rewrite_replace[] = "msg-\\1.html";

        $rewrite_search[] = "'(?<!//)pm\.php?mid=([0-9]*)'";
        $rewrite_replace[] = "msg-\\1.html";

        $rewrite_search[] = "'(?<!//)pm\.php?op=delall'";
        $rewrite_replace[] = "msg-delall.html";

        $rewrite_search[] = "'(?<!//)pm\.php?op=del&mid=([0-9]*)'";
        $rewrite_replace[] = "msg-\\1-del.html";

        $rewrite_search[] = "'(?<!//)pm\.php?op=send&replyto=([0-9]*)'";
        $rewrite_replace[] = "msg-reply-\\1.html";

        $rewrite_search[] = "'(?<!//)pm\.php'";
        $rewrite_replace[] = "pm.html";*/

        $buffer = preg_replace($rewrite_search,$rewrite_replace,$buffer);
//Restart Output Buffering again
ob_start("ob_gzhandler");
ob_implicit_flush(0);
//echo $_SERVER["PHP_SELF"];
echo $buffer;
}
?>