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
** File redirect.php 2018-02-17 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('INSETUP'))die ("You can't access this file directly");

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
        <a href=\"http://btmanager.org/index.php\"><img src=\"graphics/12.jpg\" width=34 height=43 alt=\"\" border=\"0\" /></a></td>\n
        <td width=30 height=43>\n
        <a href=\"https://github.com/blackheart1/BTManager\"><img src=\"graphics/13.jpg\" width=30 height=43 alt=\"\" border=\"0\" /></a></td>\n
        <td width=35 height=43>\n
        <a href=\"mailto:black_heart@btmanager.org\"><img src=\"graphics/14.jpg\" width=35 height=43 alt=\"\" border=\"0\" /></a></td>\n
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