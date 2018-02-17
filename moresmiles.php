<?php
/*
*----------------------------phpMyBitTorrent V 2.0-beta4-----------------------*
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
*-----------------   Sunday, September 14, 2008 9:05 PM   ---------------------*
*/
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);

require_once("include/config.php");
echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>'.$sitename.'</title>
</head>
<body>';
?>
<style type="text/css">
.alt1, .alt1Active
{
	background: #e6eaed;
	color: #000000;
	border:1px solid #bfc3c6;
	border-top:1px solid white;
	border-left:1px solid white;
}
.alt2, .alt2Active
{
	background: #d9e1e8;
	color: #000000;
	border:1px solid #bfc3c6;
	border-top:1px solid white;
}
.tcat_alt_collapse a:hover {
color:#fff;
text-decoration:underline;
}
.smallfont
{
	font: 11px verdana, geneva, lucida, 'lucida grande', arial, helvetica, sans-serif;
}
.tcat .shade, .thead .shade, .tfoot .shade { color: #DDDDDD; }
td.thead, th.thead, div.thead { padding: 2px; }
.thead a:hover, .thead a:active, .thead_ahover
{
	color: #000;
}
</style>
<script language=javascript>

function comment_smile(smile,form,text){
window.opener.document.forms[form].elements[text].value = window.opener.document.forms[form].elements[text].value+" "+smile+" ";
window.opener.document.forms[form].elements[text].focus();
}
</script>
<?
if(isset($_GET['amp;text']))$text = $_GET['amp;text'];
		if (!$user->user) loginrequired("user",true);
		        $sql = "SELECT * FROM ".$db_prefix."_smiles GROUP BY file ORDER BY id ASC;";
        $smile_res = $db->sql_query($sql);
		echo"<table align='center' width='80%' bgcolor='#cecece' cellspacing='0' cellpadding='6' style='border: 1px solid black'>\n";
		echo"<tr>\n";
		echo"<td class=\"tcat\" colspan=\"4\">\n";
		echo"Smilie List\n";
		echo"<div class=\"smallfont\">Click a smilie to insert it into your message.</div>\n";
		echo"</td>\n";
		echo"</tr>\n";
		echo"<tr>\n";
		echo"<td class=\"thead\" align=\"center\" colspan=\"4\"><div class=\"smallfont\"><strong>Generic Smilies</strong></div></td>\n";
		echo"</tr>\n";
		
        if ($db->sql_numrows($smile_res) > 0) {
		$i=1;
                $smile_rows = $db->sql_fetchrowset($smile_res);
                foreach ($smile_rows as $smile) {
				if($i==1)echo "<tr>\n";
				echo"<td class=\"alt{$i}\">\n";
				echo $smile["code"];
				echo"</td><td class=\"alt{$i}\">";
                echo "<p>";
                        echo " <img src=\"smiles/".$smile["file"]."\" onclick=\"comment_smile('".$smile["code"]."','".$form."','".$text."');\" border=\"0\" alt=\"".$smile["alt"]."\">\n";
				echo "</p>";
				echo"</td>";
				if($i==2)echo "</tr>";
				if($i==2)$i=0;
				$i++;
                }
        }
		echo"</table>";
        $db->sql_freeresult($smile_res);

		ob_end_flush();
$db->sql_close();
echo '</body>
</html>';
?>
