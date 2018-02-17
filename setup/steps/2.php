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


echo "<input type=\"hidden\" name=\"step\" value=\"3\" />\n";

echo "<p align=\"center\"><font size=\"5\">"._step2."</font></p>\n";

echo "<p>&nbsp;</p>\n";
echo "<p align=\"center\">"._gpllicense."</p>\n";
echo "<p align=\"center\"><textarea rows=\"10\" cols=\"60\">";
readfile("gpl.txt");
echo "</textarea></p>\n";
echo "<p align=\"center\"><input type=\"radio\" name=\"gpl\" value=\"yes\" />"._iagree." <input type=\"radio\" name=\"gpl\" value=\"no\" />"._idontagree."</p>\n";

echo "<p>&nbsp</p>\n";
echo "<p align=\"center\">"._lgpllicense."</p>\n";
echo "<p align=\"center\"><textarea rows=\"10\" cols=\"60\">";
readfile("lgpl.txt");
echo "</textarea></p>\n";
echo "<p align=\"center\"><input type=\"radio\" name=\"lgpl\" value=\"yes\" />"._iagree." <input type=\"radio\" name=\"lgpl\" value=\"no\" />"._idontagree."</p>\n";

if (isset($error)) echo "<p><font class\"err\">"._step2fail."</font></p>";

echo "<p><input type=\"submit\" value=\""._nextstep."\" /></p>\n";

?>
