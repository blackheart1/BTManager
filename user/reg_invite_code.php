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

if (!defined('IN_PMBT')) die ("You can't access this file directly");
global $db, $db_prefix;
$sql=("SELECT COUNT(*) FROM ".$db_prefix."_users");
$res = $db->sql_query($sql) or btsqlerror($sql);
$arr = $db->sql_fetchrow($res);
if ($arr[0] >= $invites1)bterror("Sorry, The current user account limit (" . number_format($invites1) . ") has been reached. Inactive accounts are pruned all the time, please check back again later...","Limmet reached");

if($singup_open)
{
OpenTable(_btsignup);
echo '<p>Open sign ups are close The only way you can join this site is by Invite</p>';
CloseTable();
include('footer.php');
}
OpenTable(_btsignup);
echo _btregwelcome."<br>";
echo "<form method=\"POST\" action=\"user.php\"><input type=\"hidden\" name=\"op\" value=\"takeregister\">\n";
echo "<table border=\"0\">\n";
echo "<tr><td><p>"._btusername."</p></td><td><p><input type=\"text\" name=\"username\" size=\"20\"></p></td></tr>\n";
echo "<tr><td><p>"._btemailaddress."<p></td><td><p><input type=\"text\" name=\"email\" size=\"20\"></p></td></tr>\n";
echo "<tr><td><p>"._btpasswd."</p></td><td><p><input type=\"password\" name=\"password\" size=\"20\"></p></td></tr>\n";
echo "<tr><td><p>"._btpasswd2."</p></td><td><p><input type=\"password\" name=\"cpassword\" size=\"20\"></p></td></tr></table>\n"."<br>";
if ($disclaimer_check) {
        $disclaimer = "";
        echo "<p align=\"center\">"._btdisclaimer."<br>";
        if (is_readable("disclaimer/".$language.".txt")) {
                $fp = fopen("disclaimer/".$language.".txt","r");
                while (!feof($fp)) $disclaimer.= fread($fp,1000);
        } else {
                $fp = fopen("disclaimer/english.txt","r");
                while (!feof($fp)) $disclaimer.= fread($fp,1000);
        }
        fclose($fp);
        $search = Array("*MYBT*","*URL*","*EMAIL*");
        $replace = Array($sitename,$siteurl,spellmail($admin_email));
        echo "<table width=\"100%\"><tr><td>";
        echo str_replace($search,$replace,$disclaimer);
        echo "</td></tr></table>";
        echo "<br>"._btdisclaccept." <input type=\"radio\" value=\"yes\" name=\"disclaimer\">";
        echo _btdisclrefuse."<input type=\"radio\" name=\"disclaimer\" value=\"no\" checked></p>";
}
if ($gfx_check) {
        $rnd_code = strtoupper(RandomAlpha(5));
	echo "<br>"._btreggfxcheck;
        echo "<table><tr><td>"._btgfxcode."</td><td><img src=\"gfxgen.php?code=".base64_encode($rnd_code)."\"></td></tr>";
        echo "<tr><td>&nbsp;</td><td><input type=\"text\" name=\"gfxcode\" size=\"10\" maxlength=\"6\"></td></tr></table>";
        echo "<input type=\"hidden\" name=\"gfxcheck\" value=\"".md5($rnd_code)."\">\n\n\n\n";
}

echo "<p><input type=\"submit\" value=\""._btsubmit."\"><input type=\"reset\" value=\""._btreset."\"></p></form>";
CloseTable();
?>