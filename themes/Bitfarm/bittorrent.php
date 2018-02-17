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
*------              ©2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-----------------   Sunday, September 14, 2008 9:05 PM   ---------------------*
*/
function theme_torrenttable($res, $variant = "index", $user = "", $block = "") {
        global $db, $name, $search, $user, $download_level, $torrent_global_privacy, $onlysearch, $db_prefix, $autoscrape, $theme, $btback1, $btback2, $btback3, $free_dl,$page, $prev, $pages, $pager, $next;
$utc = $btback1;
$phpself = $_SERVER['PHP_SELF'];

?>
<?php
$count_get = 0;

foreach ($_GET as $get_name => $get_value) {
if ($get_name != "sort" && $get_name != "type") {
if ($count_get > 0) {
$oldlink = $oldlink . "&" . $get_name . "=" . $get_value;
} else {
$oldlink = $oldlink . $get_name . "=" . $get_value;
}
$count_get++;
}}

if ($count_get > 0) {
$oldlink = "?" . $oldlink . "&";
}else{
$oldlink = "?";
}
if ($_GET['sort'] == "1") {
if ($_GET['type'] == "desc") {
$link1 = "asc";
} else {
$link1 = "desc";
}
}

if ($_GET['sort'] == "2") {
if ($_GET['type'] == "desc") {
$link2 = "asc";
} else {
$link2 = "desc";
}
}

if ($_GET['sort'] == "3") {
if ($_GET['type'] == "desc") {
$link3 = "asc";
} else {
$link3 = "desc";
}
}

if ($_GET['sort'] == "4") {
if ($_GET['type'] == "desc") {
$link4 = "asc";
} else {
$link4 = "desc";
}
}

if ($_GET['sort'] == "5") {
if ($_GET['type'] == "desc") {
$link5 = "asc";
} else {
$link5 = "desc";
}
}

if ($_GET['sort'] == "6") {
if ($_GET['type'] == "desc") {
$link6 = "asc";
} else {
$link6 = "desc";
}
}

if ($_GET['sort'] == "7") {
if ($_GET['type'] == "desc") {
$link7 = "asc";
} else {
$link7 = "desc";
}
}

if ($_GET['sort'] == "8") {
if ($_GET['type'] == "desc") {
$link8 = "asc";
} else {
$link8 = "desc";
}
}

if ($_GET['sort'] == "9") {
if ($_GET['type'] == "desc") {
$link9 = "asc";
} else {
$link9 = "desc";
}
}

if ($link1 == "") { $link1 = "asc"; } // for torrent name
if ($link2 == "") { $link2 = "desc"; }
if ($link3 == "") { $link3 = "desc"; }
if ($link4 == "") { $link4 = "desc"; }
if ($link5 == "") { $link5 = "desc"; }
if ($link6 == "") { $link6 = "desc"; }
if ($link7 == "") { $link7 = "desc"; }
if ($link8 == "") { $link8 = "desc"; }
if ($link9 == "") { $link9 = "desc"; }
if ($variant == "index")
{
OpenTable("&nbsp;");
        echo "<p class=\"explane\">"._btmfreetorrentexplain."</p><br><br>";
        echo "<p class=\"explane\">"._btmnuketorrentexplain."</p>";
CloseTable();
}
echo"<center>\n";

				                echo "<div class=\"pagination\"><span><strong>Pages ".$page."/".$pages."</strong></span> &bull; <span>".$prev."<span><span>".(($pages > 1) ? $pager : "")."</span><span>".$next."<span></div><br /><br />";
echo  "<table border=\"1\" cellpadding=\"5\" cellspacing=\"0\">\n";
echo"<tbody><tr>\n";
echo"<td class=\"colhead\" align=\"center\"><a href=\"$phpself?sort=4&type=$link4\" title=\"Sort by "._bttype." ".$link4."\">"._bttype."</a></td>\n";
echo"<td class=\"colhead\" align=\"left\"><a href=\"$phpself".$oldlink."sort=1&type=$link1\" title=\"Sort by "._btname." ".$link1."\">"._btname."</a></td>\n";
echo"<!--<td class=\"heading\" align=left>DL</td>-->\n";

echo"<td class=\"colhead\" align=\"right\"><a href=\"$phpself".$oldlink."sort=2&type=$link2\" title=\"Sort by Number of files ".$link2."\">".pic("completed.gif",null,_btnfile)."</a></td>\n";

echo"<td class=\"colhead\" align=\"right\">".pic("comments.png",null,_bt_offers_comments)."</td>\n";
echo"<td class=\"colhead\" align=\"center\">".pic("report.gif",null,_btvote)."</td>\n";
echo"<td class=\"colhead\" align=\"center\">"._btadded."</td>\n";

//echo"<td class=\"colhead\" align=\"center\"><a href=\"browse.php?sort=added&h=7&d=DESC\">Time Alive</a></td>\n";
echo"<td class=\"colhead\" align=\"center\">".pic("completion.gif",null,_btpeerspeed)."</td>\n";
echo"<td class=\"colhead\" align=\"center\"><a href=\"$phpself".$oldlink."sort=5&type=$link5\" title=\"Sort by Number of files ".$link5."\">".pic("servers.png",null,_btsize)."</a></td>\n";
echo"<!--\n";
echo"<td class=\"colhead\" align=right>Views</td>\n";
echo"<td class=\"colhead\" align=right>Hits</td>\n";
echo"-->\n";
echo"<td class=\"colhead\" align=\"center\">".pic("completed.png",null,_bthits)."</td>\n";
echo"<td class=\"colhead\" align=\"right\"><a href=\"$phpself".$oldlink."sort=7&type=$link7\" title=\"Sort by "._btseeders." ".$link7."\">".pic("seeders.png",null,_btseeders)."</a></td>\n";
echo"<td class=\"colhead\" align=\"right\"><a href=\"$phpself".$oldlink."sort=8&type=$link8\" title=\"Sort by "._btleechers." ".$link8."\">".pic("leechers.png",null,_btleechers)."</a></td>\n";
if ($variant == "index")echo"<td class=\"colhead\" align=\"center\">".pic("peers.gif",null,addedby)."</td>\n";
echo"</tr>\n";
        while ($row = $db->sql_fetchrow($res)) {
                $id = $row["id"];
echo"<tr>\n";
echo"<td style=\"padding: 0px;\" align=\"center\">";
                if (isset($row["cat_name"])) {
                        if (!$onlysearch AND $variant == "index") echo "<a href=\"$phpself?cat=".$row["category"]."\">";
                        if (isset($row["cat_pic"]) AND $row["cat_pic"] != "" AND is_readable("themes/".$theme."/pics/cat_pics/".$row["cat_pic"]))
                                echo "<img border=\"0\" src=\"themes/" . $theme . "/pics/cat_pics/". $row["cat_pic"] . "\" alt=\"" . $row["cat_name"] . "\" >";
                                elseif (isset($row["cat_pic"]) AND $row["cat_pic"] != "" AND is_readable("cat_pics/".$row["cat_pic"]))
                                echo "<img border=\"0\" src=\"cat_pics/" . $row["cat_pic"] . "\" alt=\"" . $row["cat_name"] . "\" >";
                        else
                                echo $row["cat_name"];
                        if (!$onlysearch AND $variant == "index") echo "</a>";
                } else echo "-";
echo"</td>\n";
echo"<td align=\"left\">";
                $imgs = 0;
                //help(pic ("help.gif","",null),preg_replace("/[^0-9a-z -<>._#]/i",'',$row["descr"]),$dispname);
                if($row["ratiobuild"] == "yes" || $free_dl) {help(pic ("magic.gif","",null),"This File Is Set As A Ratio Builder Yuor Download Is Not Counted Only your Upload");$imgs++; }
                if($row["nuked"] == "yes") {help(pic ("nuked.gif","",null),"This File Has Been Nuked. Wich meens It may have parts missing Sound is off time or some other troubles so download at your own risk"); $imgs++; }
                if ($row["evidence"] != 0) { echo pic("sticky.gif",null,_btalt_sticky); $imgs++; }
        if ($row["banned"] == "yes") { echo pic("banned.png",null,_btalt_banned); $imgs++; }
        if ($row["type"]=="link") { echo pic("minidonkey.gif",$row["ed2k"],_btalternatesource); $imgs++; }
        if ($row["tracker"] != "" AND $row["tracker"] != "dht:") { echo pic("external.gif",null,_btalt_external); $imgs++; }
                if ($imgs == 2) { echo "<br>"; $imgs = 0; }
                if ($row["dht"] == "yes" AND $variant != "mytorrents") { help(pic("dht.gif","",null),_btdhtexplanation,_btdht); $imgs++; }
                $dispname = htmlspecialchars($row["name"]);
                $dispname = str_replace("_", " ", $dispname);
                $dispname = str_replace(".", " ", $dispname);
        echo "<nobr><p class=\"title\"><a STYLE=\"text-decoration:none\" href=\"details.php?id=".$id;
                if ($row["owner"] != $user->id)
                        echo "&hit=1";

                echo "\"  title=\"".$dispname."\"><nobr>".((strlen($dispname) <= 37) ? search_word($dispname, $search): search_word(substr($dispname,0,36)."...", $search))."</a></p>";
                if ((checkaccess("u_download")) AND $row["type"] != "link") echo"<a class=\"index\" href=\"download.php?id=".$row["id"]."\"><img style=\"border: medium none ;\" alt=\"download\" src=\"themes/$theme/pics/download2.gif\" align=\"right\">";
echo"</nobr></a>";
                if ($variant == "index" OR $variant == "usertorrent") echo "<br>";
                //Edit & Delete
                if ($user->moderator OR ($row["owner"] == $user->id AND $row["owner"] != "0")) echo pic("edit.gif","edit.php?id=".$row["id"],_btalt_edit).pic("drop.gif","edit.php?op=delete&id=".$row["id"],_btalt_drop);
        // Ban
        if ($user->moderator AND $row["banned"] != "yes"){
            echo pic("ban.png","edit.php?op=ban&id=".$row["id"],_btban);
        }
        //Scrape
        if ($row["tracker"] != "") {
            if ($user->user){
                if (time()- sql_timestamp_to_unix_timestamp($row["tracker_update"])> 1800) {
                     echo pic("refresh.png","scrape-external.php?id=".$row["id"]."&tracker=".$row["tracker"]."&return=". urlencode($_SERVER["REQUEST_URI"]),_btalt_scrape);
                }else{
                    echo pic("refresh_gray.png",NULL,_btalt_noscrape);
                }
            
            }elseif ($user->moderator){
                echo pic("refresh.png","scrape-external.php?id=".$row["id"]."&tracker=".$row["tracker"]."&return=". urlencode($_SERVER["REQUEST_URI"]),_btalt_scrape);
            }else{
                echo pic("refresh_gray.png","scrape-external.php",_btalt_logintoscrape);
                       }
        }
                //Permission Administration
                if ($torrent_global_privacy AND $user->user AND $row["type"] != "link") {
                        if ($row["owner"] == $user->id) {
                                $pic = "auth_none.gif";
                                $authsql = "SELECT status FROM ".$db_prefix."_privacy_file WHERE torrent = '".$row["id"]."' AND status = 'pending';";
                                $authres = $db->sql_query($authsql) or btsqlerror($authsql);
                                if ($db->sql_numrows($authres) > 0) $pic = "auth_pending.gif";
                                echo pic($pic,"mytorrents.php?op=displaytorrent&id=".$row["id"]);
                        } elseif (!can_download($user,$row)) {
                                $authres = $db->sql_query("SELECT status FROM ".$db_prefix."_privacy_file WHERE torrent = '".$row["id"]."' AND slave = '".$user->id."' LIMIT 1;");
                                if ($db->sql_numrows($authres) == 0) echo pic("lock_request.gif","details.php?op=authorization&id=".$row["id"],_btalt_lock_request);
                                else echo pic("lock.gif",null,_btalt_lock);
                        }
                }
				
                if ($variant == "index")echo"<br /><span id=ID" . $row["id"] . "><a onclick=\"sndReq('op=view_details&torrent=" . $row["id"] . "', 'ID" . $row["id"] . "')\">".pic("plus.gif","",_btddetails)."</a></span>";
echo"</td>\n";
echo"<td align=\"right\">";
                if ($variant == "index" OR $variant == "usertorrent") {
                        //Size

                        if ($row["type"] == "single" OR $row["numfiles"] <= 1)
                                echo("<a href=\"$phpself".$oldlink."sort=2&type=$link2\" title=\"Sort by Number of files ".$link2."\">" .$row["numfiles"]."</a>");
                        else {
                                if ($row["owner"] != $user->id)
                                        echo "<a href=\"$phpself".$oldlink."sort=2&type=$link2\" title=\"Sort by Number of files ".$link2."\">" . $row["numfiles"] . "</a>";
                                else
                                        echo "<a href=\"$phpself".$oldlink."sort=2&type=$link2\" title=\"Sort by Number of files ".$link2."\">" . $row["numfiles"] . "</a>";
                        }
                }
echo"</td>\n";
echo"<td align=\"right\">";
                if (!$row["comments"])
                        print($row["comments"] . "");
                else {
                        $hit = ($row["owner"] == $user->id) ? "" : "&hit=1";
                        echo "<b><a href=\"details.php?id=".$row["id"].$hit."&comm=startcomments\">" . $row["comments"] . "</a></b>";
                }
echo"</td>\n";
echo"<td align=\"center\">";
                if (!isset($row["rating"]))
                        echo "---";
                else {
                        $rating = round($row["rating"] * 2) / 2;
                        $rating = ratingpic($row["rating"]);
                        if (!isset($rating))
                                echo "---";
                        else
                                echo ($rating);
                }
echo"</td>\n";
echo"<td align=\"center\">".$row['added']."</td>\n";

//echo"<td align=\"center\">10<br>hours</td>\n";
echo"<td align=\"center\">";
                if ($row["type"] != "link" AND $row["tracker"] == "") {
                        if ($row["leechers"] > 0 AND $row["speed"] > 0) {
                                $ro = $row["seeders"]/$row["leechers"];
                                $speed_leech = ($ro == 0) ? round($row["speed"]/$row["leechers"]) : min($row["speed"],round($row["speed"]*$ro));
                                $edt_m = ($row["size"] / $speed_leech)/60; //to minutes
                                $edt = ($edt_m % 60)."m"; //minutes
                                $edt_h = floor($edt_m / 60);
                                if ($edt_h>0) $edt = $edt_h."h ".$edt;
                                $speed_leech = mksize($speed_leech)."/s";
                        } else {
                                $speed_leech = "--";
                                $edt = "--";
                        }
                }
echo"".mksize($row["speed"])."/s</td>\n";
echo"<td align=\"center\">".mksize($row["size"])."</td>\n";
$totsql = "SELECT count(`torrentid`)as `snatch` FROM `torrent_snatched` WHERE `torrentid` = '".$row["id"]."'";
$totres = $db->sql_query($totsql);
$sncount = $db->sql_fetchrow($totres);
echo"<td align=\"center\">".$sncount['snatch']."<br>times</td>\n";
echo"<td align=\"right\"><b>".$row["seeders"]."</b></td>\n";
echo"<td align=\"right\"><b>".$row["leechers"]."</b></td>\n";
if ($variant == "index"){
echo"<td align=\"center\">";
                if ($variant == "index") {
                        if (isset($row["username"]) AND $row["ownertype"]==0) {
                                echo "<a href=\"user.php?op=profile&username=".$row["username"]."\"><font color=\"".getusercolor($row["can_do"])."\">" . htmlspecialchars($row["user_name"])."</font></a>";
                        } else
                        echo "(<i>"._btunknown."</i>)";
                }
}
echo"</a></td>\n";

echo"</tr>\n";
}
echo "</table>";
echo"</center>\n";

return;
}
?>