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
** File 2.php 2018-02-18 10:18:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/



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
