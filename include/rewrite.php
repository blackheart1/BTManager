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
** File rewrite.php 2018-02-18 14:32:00 joeroberts
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