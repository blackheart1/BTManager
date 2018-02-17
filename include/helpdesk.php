<?php
/*
*----------------------------phpMyBitTorrent V 2.0.4---------------------------*
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
*------              ©2008 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-----------------   SAT, FEB 21, 2009 18:12 PM   ---------------------*
*/
include("header.php");
include("include/config_lite.php");
$problem = trim($_POST["problem"]);
$answer = trim($_POST["answer"]);
$id = $_POST["id"];
$addedbyid = $_POST["addedbyid"];
$title = trim($_POST["Problem Title"]);

$action = $_GET["action"];
$solve = $_GET["solve"];
if (($problem != "") && ($title != "")){

  $dt = sqlesc(get_date_time());
$query = mysql_query("INSERT INTO ".$db_prefix."_helpdesk` (`title`, `problem`,  `solved`, `answer`) VALUES  (".$title.", ".$problem.", $dt)") or sqlerr();

// mysql_query("INSERT INTO ".$db_prefix."_helpdesk (added) VALUES ($dt)") or sqlerr();

  stdmsg("Help desk", "Message sent! Await for reply.");
  end_main_frame();
  stdfoot();
  exit;
}
{
print("<center><a href=problems.php><h1>PROBLEMS</h1></a></center><br/>");
}
?>
<!-- Start Darks Help Desk -->
<center><font color=red size=2><blockquote>Before using <b>Our Help Desk</b> make sure to read <a href=faq.php><b>FAQ</b></a> and search the <a href=phpBB.php><b>Forums</b></a> first!</blockquote></font><br/></center>
<center><font color="red"><h1>Darks Help Desk @2009 All Rights PMBT</h1></center></font>
<center><font color="red" size="2"><b>Please Note This Help Desk Is In The Testing Stage</b></font></center><br/>

<form method="post" action="helpdesk.php">
<table border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td align="right">&nbsp;<b>Problem Title:</b></td>
    <td align="left"><input type="text" size="73" maxlength="60" name="title"></td>
  </tr>
<!--
  <tr>
    <td align="left" colspan="2"></td>
  </tr>
-->
  <tr>
    <td colspan="2"><textarea name="problem" cols="90" rows="20"><?php print($problem);?></textarea><!--<br>(<a href=tags.php class=altlink>BB</a> tags are <b>allowed</b>.)--></td>
  </tr>
  <tr>
    <td align="center" colspan="2"><input type="submit" value="SEND FOR HELP!" class="btn"></td>
  </tr>
</table>
</form>


<?php
include("footer.php");
?>
