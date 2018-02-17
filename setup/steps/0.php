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
echo "<p align=\"center\"><font size=\"5\">Please select your language:</font></p>\n";

echo "<table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\n";
$langdir = opendir("language");
$maxtd = 3;
$td = 0;
while ($langfile = readdir($langdir)) {
        if (!preg_match("/\.php$/",$langfile)) continue;
        if ($td == 0) echo "<tr>";
        $lang = substr($langfile,0,strpos($langfile,"."));
        echo "<td><div align=\"center\"><a href=\"index.php?step=1&language=".$lang."\"><img src=\"language/".$lang.".png\" border=\"0\" alt=\"".ucwords($lang)."\" /></a></div></td>\n";

        $td++;
        if ($td == $maxtd) {
                echo "</tr>";
                $td = 0;
        }
}
if ($td != 0) echo "</tr>";
closedir($langdir);
echo "</table>\n";

?>
