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
** File 1.php 2018-02-17 14:32:00 joeroberts
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/

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
if (!extension_loaded("mysql") AND !extension_loaded("mysqli")) {
        $error = true;
        err();
        echo " - "._mysqlfail;
} else {
        ok();
        echo " - ";
		if(extension_loaded("mysql"))
		{
			echo "MySql " . mysql_get_client_info();
		}
		else
		{
			echo "MySqli " . mysqli_get_client_info();
		}
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
if(!getscrapedata('udp://tracker.coppersurfer.tk:6969/scrape', false, array(utf8_decode('Ñd>[÷lzÜ5ÉE')=>preg_replace_callback('/./s', "hex_esc", str_pad(utf8_decode('Ñd>[÷lzÜ5ÉE'),20)))))
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
echo _files_folder;
echo " - ";
if (!is__writable('./../files/'))
{
warn();
echo '<br />';
echo _files_folder_fail;
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
