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
** File reg_invite_code.php 2018-02-18 14:32:00 joeroberts
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT'))
{
	include_once './../security.php';
	die ();
}
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