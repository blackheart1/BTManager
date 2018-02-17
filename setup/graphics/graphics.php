<?php
/*
*----------------------------phpMyBitTorrent V 2.0.5---------------------------*
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
*------              ©2014 BT.Manager Development Team              -----------*
*-----------               http://BT.Manager.com               ----------------*
*------------------------------------------------------------------------------*
*----------------------Saturday, May 07, 2013 4:02 PM--------------------------*
*/

if(preg_match("/^graphics\.php/",$_SERVER["PHP_SELF"])) die("You can't access this file directly");

function makeheader() {
        global $step;
        echo "<table border=\"0\" width=\"780\" height=\"176\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
        <tr>
        <td width=\"356\" rowspan=\"2\" height=\"183\"><img height=\"183\" alt=\"\" src=\"graphics/1.jpg\" width=\"356\"></td><td width=\"424\" height=\"91\"><img height=\"91\" alt=\"\" src=\"graphics/2.jpg\" width=\"424\" hspace=\"0\" vspace=\"0\"></td>
        </tr>
        <tr>
        <td width=\"424\" height=\"92\"><img height=\"64\" alt=\"\" src=\"graphics/3.jpg\" width=\"102\" border=\"0\"><img height=\"64\" alt=\"\" src=\"graphics/4.jpg\" width=\"63\" border=\"0\"><img height=\"64\" alt=\"\" src=\"graphics/5.jpg\" width=\"55\" border=\"0\"><img height=\"64\" alt=\"\" src=\"graphics/6.jpg\" width=\"145\" border=\"0\"><img height=\"64\" alt=\"\" src=\"graphics/7.jpg\" width=\"59\"><br /><img height=\"28\" alt=\"\" src=\"graphics/8.jpg\" width=\"424\"></td>
        </tr>
        </table>\n";
}


function makefooter() {
        echo "<table width=\"100%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n
        <tr>\n
        <td colspan=6  style=\"background:url(graphics/11.jpg)\" width=\"622\" height=\"43\">\n
        <p style=\"font-size:10px; margin-left:40\"> Copyright 2005-2014
        BT.Manager Team. All rights reserved.
        Distributed under GNU/GPL license.</p>\n
        </td>\n
        <td width=34 height=43>\n
        <a href=\"http://btmanager.com/index.php\"><img src=\"graphics/12.jpg\" width=34 height=43 alt=\"\" border=\"0\" /></a></td>\n
        <td width=30 height=43>\n
        <a href=\"https://sourceforge.net/projects/phpmybittorrent\"><img src=\"graphics/13.jpg\" width=30 height=43 alt=\"\" border=\"0\" /></a></td>\n
        <td width=35 height=43>\n
        <a href=\"mailto:joeroberts@actfas.com\"><img src=\"graphics/14.jpg\" width=35 height=43 alt=\"\" border=\"0\" /></a></td>\n
        <td width=59 height=43>\n
        <img src=\"graphics/15.jpg\" width=59 height=43 alt=\"\" /></td>\n
        </tr>\n
        </table>\n";
}

function stepimage() {
        global $step, $gpl, $lgpl, $truestep;
        switch ($step) {
                case "0": {
                        return "Language.png";
                }
                case "1": {
                        return "Requirements.png";
                }
                case "2": {
                        return "License.png";
                }
                case "3": {
                        if ((!isset($gpl) OR $gpl != "yes" OR !isset($lgpl) OR $lgpl != "yes") AND !isset($truestep)) return "License.png";
                        else return "Database.png";
                }
                case "4": {
                        return "Install.png";
                }
                case "5": {
                        return "Settings.png";
                }
                case "6": {
                        return "Admin.png";
                }
                case "7": {
                        return "Runtime.png";
                }
        }
}
?>