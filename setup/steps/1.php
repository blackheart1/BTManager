<?php
/*
*----------------------------phpMyBitTorrent V 3.0.0---------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
*-------------------   And Joe Robertson (aka joeroberts)   -------------------*
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
*------              ©2014 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-------------------Saturday, January 23, 2010 4:02 PM ------------------------*
*/

echo "<input type=\"hidden\" name=\"step\" value=\"2\" />\n";

echo "<p align=\"center\"><font size=\"5\">"._step1."</font></p>\n";

function err() {
        echo "<font class=\"err\">"._error."</font>";
}
function warn() {
        echo "<font class=\"warn\">"._warning."</font>";
}
function ok() {
        echo "<font class=\"ok\">"._ok."</font>";
}

$error = false;
$warn = false;

echo "<p>";

//PHP Version
echo _phpvercheck;
echo " - ". phpversion();
echo " - ";
if (phpversion() < "4.3") {
        $error = true;
        err();
        echo " - "._phpverfail;
} else ok();
echo "<br />";

//ZLib
echo _zlibcheck;
echo " - ";
if (!extension_loaded("zlib")) {
        $warn = true;
        warn();
        echo " - "._zlibfail;
} else ok();
echo "<br />";

//MySQL
echo _mysqlcheck;
echo " - ";
if (!extension_loaded("mysql") OR !extension_loaded("mysqli")) {
        $error = true;
        err();
        echo " - "._mysqlfail;
} else {
        ok();
        echo " - ".mysql_get_client_info();
}

echo "<br />";


//Checking against PHP's DOM XML
echo _domxmlcheck;
echo " - ";
if (phpversion() < '5' AND !extension_loaded("domxml")) {
        $warn = true;
        warn();
        echo " - "._domxmlnotinstalled;
        echo "<br />\n";
        echo _domxmlload;
        if (!@dl((PHP_OS=="WINNT"||PHP_OS=="WIN32") ? "../include/extensions/domxml.dll" : "../include/extensions/domxml.so")) {
                $error = true;
                err();
                echo " - "._domxmlcantload;
        }
} else ok();

echo "<br />";

//External
echo _externalcheck;
echo " - ";
$fp = @fopen("http://btmanager.org","r");
if (!$fp) {
        $warn = true;
        warn();
        echo " - "._externalfail;
} else ok();
@fclose($fp);

echo "<br />";

//Just checking the operating system
echo _oscheck . " - ". PHP_OS;

echo '<br />';

echo _udp_check;
echo " - ";
if(!getscrapedata('udp://tracker.publicbt.com:80/scrape', false, array('ÏWX™xyTâ¡4«›Lì„âÍl!Ð'=>preg_replace_callback('/./s', "hex_esc", str_pad('ÏWX™xyTâ¡4«›Lì„âÍl!Ð',20)))))
{
warn();
echo '<br />';
echo _udpfail;
}
else
ok();
echo '<br />';
echo _cachefolder;
echo " - ";
if (!is__writable('./../cache/'))
{
	err();
	$error = true;
	echo '<br />';
	echo _cache_fail;
}
else
ok();
echo '<br />';
echo _avatarfolder;
echo " - ";
if (!is__writable('./../avatars/user/'))
{
warn();
echo '<br />';
echo _avatarfail;
}
else
ok();
echo '<br />';
echo _image_bucket;
echo " - ";
if (!is__writable('./../UserFiles/'))
{
warn();
echo '<br />';
echo _image_bucket_fail;
}
else
ok();
echo '<br />';
echo _torrent_folder;
echo " - ";
if (!is__writable('./../torrent/'))
{
err();
$warn = true;
$error = true;
echo '<br />';
echo _torrent_fail;
}
else
ok();
echo '<br />';
echo _cat_pics;
echo " - ";
if (!is__writable('./../cat_pics/'))
{
warn();
echo '<br />';
echo _cat_pics_fail;
}
else
ok();
echo '<br />';
echo _massupload;
echo " - ";
if (!is__writable('./../massupload/'))
{
warn();
echo '<br />';
echo _massupload_fail;
}
else
ok();

echo "</p>";

if (!$error) {
        if ($warn) echo "<p>"._step1warn."</p>\n";
        echo "<p><input type=\"submit\" value=\""._nextstep."\" /></p>\n";
} else echo "<p align=\"center\">"._step1fail."</p>\n;";
?>
