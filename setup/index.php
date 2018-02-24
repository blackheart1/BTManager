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
** File index.php 2018-02-18 10:18:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
error_reporting(E_ALL ^ E_NOTICE);
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
define('INSETUP',true);

if (function_exists('ob_gzhandler') && !ini_get('zlib.output_compression'))

    ob_start('ob_gzhandler');

    else

        ob_start();

ob_implicit_flush(0);

define("_VERSION","3.0.1");

if (!ini_get("register_globals")) {
	if (phpversion() < '5.4') {
		@import_request_variables('GPC');
	}else{
		@extract($_REQUEST, EXTR_PREFIX_SAME,'GPS');
	}
}


if (!isset($step) OR !is_numeric($step)) $step = 0;

/*
Operating System Analysis
Useful for setup help
*/
if (strtoupper(substr(PHP_OS,0,3)) == "WIN") $os = "Windows";
else $os = "Linux";


require_once("graphics/graphics.php");

function check_chmod($file_check)
{
}
function is__writable($path, $file = '') 
{
	if ($path{strlen($path)-1}=='/' AND $file == '') return is__writable($path, uniqid(mt_rand()).'.tmp');
	//die($path);

	if (!is_dir($path))
	{
		return false;
	}
	else
	{
		$path = $path.$file;
		//die($path);
		$fp = @fopen($path,"w");
		if (!$fp)
		{
			return false;
		}
		else
		{
			if (!fputs($fp,"Test Write"))
			{
				return false;
			}
		}
		@unlink($path); //Deleting the mess we just done
		@fclose($fp);
	}
	return true;
}

function hex_esc($matches) {
        return sprintf("%02x", ord($matches[0]));
}
function getscrapedata($url, $display=false, $info = false) {
	if (preg_match("/thepiratebay.org/i", $url))$url = 'udp://tracker.openbittorrent.com:80';
		if(preg_match('%udp://([^:/]*)(?::([0-9]*))?(?:/)?%si', $url, $m))
			{
				$tracker = 'udp://' . $m[1];
				$port = isset($m[2]) ? $m[2] : 80;
				$page = "d5:filesd";
				$transaction_id = mt_rand(0,65535);
				$fp = @fsockopen($tracker, $port, $errno, $errstr);
				stream_set_timeout($fp, 10);
				if(!$fp)
					{
						return false;
					}
						@fclose($fp);
						return true;
				$current_connid = "\x00\x00\x04\x17\x27\x10\x19\x80";
				//Connection request
				$packet = $current_connid . pack("N", 0) . pack("N", $transaction_id);
				fwrite($fp,$packet);
				//Connection response
				$ret = fread($fp, 100);
				if(strlen($ret) < 1 OR strlen($ret) < 16)
					{
						die($ret);
						return false;
					}
				$retd = unpack("Naction/Ntransid",$ret);
				if($retd['action'] != 0 || $retd['transid'] != $transaction_id)
					{
						return false;
					}
				$current_connid = substr($ret,8,8);
				//Scrape request
				$hashes = '';
				foreach($info as $hash)
					{
						$hashes .= pack('H*', $hash);
					}
				$packet = $current_connid . pack("N", 2) . pack("N", $transaction_id) . $hashes;
				fwrite($fp,$packet);
				//Scrape response
				$readlength = 8 + (12 * count($info));
				$ret = fread($fp, $readlength);
				if(strlen($ret) < 1 OR strlen($ret) < 8)
					{
						return false;
					}
					else 
					{
						return true;
					}
				$retd = unpack("Naction/Ntransid",$ret);
				// Todo check for error string if response = 3
				if($retd['action'] != 2 || $retd['transid'] != $transaction_id || strlen($ret) < $readlength)
					{
						return false;
					}
				$torrents = array();
				$index = 8;
				foreach($info as $k => $hash)
					{
						$retd = unpack("Nseeders/Ncompleted/Nleechers",substr($ret,$index,12));
						$retd['infohash'] = $k;
						$torrents[$hash] = $retd;
						$index = $index + 12;
					}
				foreach($torrents as $retb)$page .= "20:".str_pad($retb['infohash'], 20)."d".
				"8:completei".$retb['seeders']."e".
				"10:downloadedi".$retb['completed']."e".
				"10:incompletei".$retb['leechers']."e".
				"e";
				$page .= "ee";
			}
			else
			{
				if (!$fp = @fopen($url,"rb")) return false; //Warnings are shown
					stream_set_timeout($fp, 10);
				$page = "";
				while (!feof($fp)) $page .= @fread($fp,10000);
				@fclose($fp);
			}
				if(strlen($page) < 1 OR strlen($page) < 16)
					{
						return false;
					}


        return $page;
}
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n";
echo "<html>\n";
echo "<head>\n";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1252\">\n";
echo "<title>BT.Manager - Setup</title>\n";
echo "<link rel=\"StyleSheet\" href=\"graphics/style.css\" type=\"text/css\">\n";

if (isset($language) AND $language != "" AND is_readable("language/".$language.".php")) {
        require_once("language/".$language.".php");
        $langpic = "language/".$language.".png";
} else $langpic = "graphics/blank.gif";

echo "<script type=\"text/javascript\" src=\"../overlib/overlib.js\"><!-- overLIB (c) Erik Bosrup --></script>\n";
echo "<script type=\"text/javascript\" src=\"../overlib/overlib_shadow.js\"><!-- overLIB (c) Erik Bosrup --></script>\n";
echo <<<EOF
<script type="text/javascript" language="JavaScript">
function expand(id) {
        var i=1;
        var obj;
        while (obj = document.getElementById(id+"_"+i)) {
                if (obj.className == 'show') {
                        obj.className = 'hide';
                } else {
                        obj.className = 'show';
                }
                i++;
        }

}
</script>
EOF;

echo "</head>\n";


echo "<body>\n";
echo "<div id=\"overDiv\" style=\"position:absolute; visibility:hidden; z-index:1000;\"></div>\n";
echo "<table width=782 border=0 cellpadding=0 cellspacing=0 align=\"center\">\n";
echo "<tr><td>";
makeheader();
echo "</td>\n</tr>\n";
echo "<tr><td>\n";


#HERE COMES THE SCRIPT
echo "<table>\n";
echo "<tr><td width=\"259\">\n";
#LEFT SIDE

$stepimg = stepimage();
$stepimg = "graphics/".$stepimg;

echo "<table border=\"0\" width=\"100%\">\n";
echo "<tr>\n";
echo "<td colspan=1 style=\"background:url(graphics/r4.jpg)\" width=135 height=66><div align=\"center\"><img src=\"".$langpic."\" alt=\"Language\" width=\"48\" height=\"48\" /></div></td>\n";
echo "<td colspan=1 style=\"background:url(graphics/r5.jpg)\" width=124 height=66></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td colspan=1 style=\"background:url(graphics/r6.jpg)\" width=135 height=62><div align=\"center\"><img src=\"".$stepimg."\" alt=\"Current Step\" width=\"48\" height=\"48\" /></div></td>\n";
echo "<td colspan=1 style=\"background:url(graphics/r7.jpg)\" width=124 height=62></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td colspan=1 style=\"background:url(graphics/r8.jpg)\" width=135 height=65><div align=\"center\"><img src=\"graphics/".$os.".png\" alt=\"Operating System\" width=\"48\" height=\"48\" /></div></td>\n";
echo "<td colspan=1 style=\"background:url(graphics/r9.jpg)\" width=124 height=65></td>\n";
echo "</tr>\n";
echo "</table>";

echo "</td>\n<td width=\"512\">\n";

echo "<form name=\"formdata\" action=\"index.php\" method=\"POST\">\n";
if (isset($language)) echo "<input type=\"hidden\" name=\"language\" value=\"".$language."\" />\n";


#INTERFACE HERE
require_once("steps/".$step.".php");

echo "</form>\n";
echo "</td>\n</tr>";
echo "</table>\n";

/*
DEBUG INFORMATION

echo "<p>Debug: GET = ";
print_r($_GET);
echo " POST = ";
print_r($_POST);
echo "</p>";
*/

echo "</td>\n<tr><td>";
makefooter();
echo "</td>\n</tr>\n";
echo "</table>\n";
echo "</body>\n";
echo "</html>";
ob_end_flush();
die();
?>