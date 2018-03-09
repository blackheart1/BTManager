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
** File 0.php 2018-02-18 10:18:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('INSETUP'))die ("You can't access this file directly");
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
