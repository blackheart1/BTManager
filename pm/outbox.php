<?php
/*
*----------------------------phpMyBitTorrent V 2.0-----------------------------*
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
if (!eregi("pm.php",$_SERVER["PHP_SELF"])) die ("You cannot access this file directly");

if (!isset($page) OR !is_numeric($page) OR $page < 1) $page = 1;
$from = ($page - 1) * 20;

$totsql = "SELECT COUNT(id) FROM ".$db_prefix."_private_messages WHERE sender = '".$user->id."' AND sender_del = 'false';";
$totres = $db->sql_query($totsql);
list ($tot) = $db->fetch_array($totres);
$db->sql_freeresult($totres);

$pages = ceil($tot / 20);

if($page < $pages) {
        $next = "<b><a href=\"pm.php?op=outbox&page=".($page+1)."\">>>>></a></b>";
} else {
        $next = ">>>>";
}
if ($page > 1) {
        $prev = "<b><a href=\"pm.php?op=outbox&page=".($page-1)."\"><<<<</a></b>";
} else {
        $prev = "<<<<";
}
$pager = "<a href=\"pm.php?op=outbox\">".(($page == 1) ? "<b>1</b>" : "1")."</a>&nbsp;";

if (($page - 15) > 1) $pager .= "...";

for ($i = max(2,$page - 15); $i < min($pages, $page + 15); $i++) {
        $pager .= "<a href=\"pm.php?op=outbox&page=".$i."\">".(($i == $page) ? "<b>".$i."</b>" : $i)."</a>&nbsp;";
}
if (($page + 15) < $pages) $pager .= "...";
$pager .= "<a href=\"pm.php?op=outbox&page=".$pages."\">".(($page == $pages) ? "<b>".$pages."</b>" : $pages)."</a>";

OpenTable(_btoutbox);

echo "<form name=\"folder\" action=\"pm.php\" method=\"POST\">\n";
                    echo "<select name=\"op\" onchange=\"javascript: document.folder.submit();\"> <option value=\"inbox\">Inbox</option><option value=\"outbox\" selected>Outbox</option></select>\n";
                        #echo "<a align=\"center\" href=\"javascript: document.folder.submit();\">Folder</a>\n";
                        echo "</form><br>\n";

$sql = "SELECT P.*, U.username AS username, IF (U.name IS NULL, U.username, U.name) as user_name, U.level as user_level FROM ".$db_prefix."_private_messages P LEFT JOIN ".$db_prefix."_users U ON P.recipient = U.id WHERE P.sender = '".$user->id."' AND sender_del = 'false' ORDER BY P.sent DESC LIMIT ".$from.",20;";

$res = $db->sql_query($sql) or btsqlerror($sql);

if (!$db->sql_numrows($res)) {
        echo "<p align=\"center\">"._btpmnomessages."</p>\n";
        echo "<p>&nbsp;</p>";
        echo "<p>".pic("pm_write.png","pm.php?op=send",_btpmnewmsg)."</p>\n";
} else {
        echo "<form method=\"POST\" name=\"privmsg_list\" action=\"pm.php\">\n";
        echo "<input type=\"hidden\" name=\"op\" value=\"outbox_delete\" />\n";
        echo "<table style=\"border-collapse:collapse;\" border=\"1\" bordercolor=\"#CDCDCF\" cellpadding=\"3\" cellspacing=\"1\" width=\"100%\" >\n";
        echo "<thead>\n<tr>\n";
        echo "<th width=\"2%\"><p>&nbsp;</p></th>\n";
        echo "<th align=\"center\"><p>"._btpmsub."</p></th>\n";
        echo "<th align=\"center\"><p>"._btpmto."</p></th>\n";
        echo "<th align=\"center\"><p>"._btpmdate."</p></th>\n";
        echo "<th width=\"5%\" nowrap><p>"._btplmselect."</p></th>\n";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($msg = $db->sql_fetchrow($res)) {
                echo "<tr>\n";

                echo "<td width=\"2%\" align=\"center\" valign=\"middle\"><p align=\"center\">";
                if ($msg["is_read"] == "true") echo pic("pm_read.gif",null,_btpmread);
                else echo pic("pm_unread.gif",null,_btpmunread);
                echo "</p></td>\n";
                echo "<td><p align=\"center\"><a href=\"pm.php?op=readmsg&mode=outbox&mid=".$msg["id"]."\">".stripslashes($msg["subject"])."</a></p></td>\n";
                if ($row["level"] == "user") $userclass = "";
		elseif ($row["level"] == "premium") $userclass = "premium";
               	elseif ($row["level"] == "moderator") $userclass = "mod";
                elseif ($row["level"] == "admin") $userclass = "admin";
		echo "<td><p align=\"center\"><a class=\"userclass\" href=\"user.php?op=profile&id=".$msg["recipient"]."\">".$msg["user_name"]."</a></p></td>\n";
                echo "<td><p align=\"center\">".$msg["sent"]."</td>\n";
                echo "<td width=\"5%\"><p align=\"center\"><input type=\"checkbox\" name=\"del_".$msg["id"]."\" value=\"true\" /></p></td>\n";

                echo "</tr>\n";
        }
        $db->sql_freeresult($res);
        echo "</tbody>\n";
        echo "</table>\n";
        echo "<table border=\"0\" width=\"100%\"><tr><td align=\"left\"><p>".$prev."</p></td><td align=\"center\"><p>".(($pages > 1) ? $pager : "")."</p></td><td align=\"right\"><p>".$next."</p></td></tr></table>";
        echo "<p>&nbsp;</p>";
        echo "<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">\n";
        echo "<tr>\n";
        echo "<td align=\"left\">".pic("pm_write.png","pm.php?op=send",_btpmnewmsg)."</td>\n";
        echo "<td colspan=\"5\" align=\"right\">";
        echo pic("pm_delete.png","javascript:document.forms['privmsg_list'].submit()",_btpmdelete).pic("pm_delall.png","pm.php?op=outbox_delall",_btpmdelall);
        echo "</td>\n";
        echo "</tr>\n";
        echo "</table>\n";

        echo "</form>\n";
}

CloseTable();

OpenTable(_btuserlists);
echo "<p>"._btuserlistsintro."</p>\n";
echo "<p>&nbsp;</p>\n";

echo "<table width=\"100%\" border=\"0\">\n";
echo "<tr><td width=\"50%\">";
//Favourite users
echo "<table width=\"100%\" border=\"1\" bordercolor=\"#CDCDCF\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "<thead align=\"center\"><tr><th><p><b>"._btpmbookmarks."</b></p></th></tr></thead>\n";
echo "<tbody>";

$sql = "SELECT B.slave, IF (U.name IS NULL, U.username, U.name) as username FROM ".$db_prefix."_private_messages_bookmarks B LEFT JOIN ".$db_prefix."_users U ON B.slave = U.id WHERE B.master = '".$user->id."' ORDER BY username;";
$res = $db->sql_query($sql) or btsqlerror($sql);
while (list ($id, $name) = $db->fetch_array($res)) {
        echo "<tr><td><p><a href=\"user.php?op=profile&id=".$id."\">".htmlspecialchars($name)."</a></p></td></tr>\n";
}
$db->sql_freeresult($res);
echo "</tbody>\n";
echo "</table>";
//End favourite
echo "</td><td width=\"50%\">";
//Blacklisted users
echo "<table width=\"100%\" border=\"1\" bordercolor=\"#CDCDCF\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "<thead align=\"center\"><tr><th><p><b>"._btpmblacklist."</b></p></th></tr></thead>\n";
echo "<tbody>";

$sql = "SELECT B.slave, IF (U.name IS NULL, U.username, U.name) as username FROM ".$db_prefix."_private_messages_blacklist B LEFT JOIN ".$db_prefix."_users U ON B.slave = U.id WHERE B.master = '".$user->id."' ORDER BY username;";
$res = $db->sql_query($sql) or btsqlerror($sql);
while (list ($id, $name) = $db->fetch_array($res)) {
        echo "<tr><td><p><a href=\"user.php?op=profile&id=".$id."\">".htmlspecialchars($name)."</a></p></td></tr>\n";
}
$db->sql_freeresult($res);
echo "</tbody>\n";
echo "</table>";
//End blacklist
echo "</td></tr>\n";
echo "</table>";

CloseTable();
?> 
