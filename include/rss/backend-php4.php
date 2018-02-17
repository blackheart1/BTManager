<?php
/*
*-------------------------------phpMyBitTorrent--------------------------------*
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
*/
if (!extension_loaded("domxml")) @dl((PHP_OS=="WINNT"||PHP_OS=="WIN32") ? "include/extensions/domxml.dll" : "include/extensions/domxml.so");


$rss = domxml_new_doc("1.0");
{
        $rdf = $rss->add_root("rdf:RDF");
        $rdf->set_attribute("xmlns:rdf","http://www.w3.org/1999/02/22-rdf-syntax-ns#");
        $rdf->set_attribute("xmlns:dc","http://purl.org/dc/elements/1.1/");
        $rdf->set_attribute("xmlns:sy","http://purl.org/rss/1.0/modules/syndication/");
        $rdf->set_attribute("xmlns:admin","http://webns.net/mvcb/");
        $rdf->set_attribute("xmlns","http://purl.org/rss/1.0/");
        {
                $channel = $rss->create_element("channel");
                $channel->set_attribute("rdf:about",$siteurl);
                {
                        $title = $rss->create_element("title");
                        $title->append_child($rss->create_text_node($sitename));
                }
                $channel->append_child($title);
                {
                        $link = $rss->create_element("link");
                        $link->append_child($rss->create_text_node($siteurl));
                }
                $channel->append_child($link);
                {
                        $description = $rss->create_element("description");
                        $description->append_child($rss->create_text_node($descr));
                }
                $channel->append_child($description);
                {
                        $items = $rss->create_element("items");
                        {
                                $rdf_Seq = $rss->create_element("rdf:Seq");

                                foreach ($ids as $tid) {
                                        $rdf_li = $rss->create_element("rdf:li");
                                        $rdf_li->set_attribute("rdf:resource",$siteurl."/details.php?id=".$tid);
                                        $rdf_Seq->append_child($rdf_li);
                                }

                        }
                        $items->append_child($rdf_Seq);
                }
                $channel->append_child($items);
        }
        $rdf->append_child($channel);
        for ($i = 0; $i < count($ids); $i++) {
                $item = $rss->create_element("item");
                $item->set_attribute("rdf:about",$siteurl."/details.php?id=".$ids[$i]);
                {
                        $title = $rss->create_element("title");
                        $title->append_child($rss->create_text_node($names[$i]));
                }
                $item->append_child($title);
                {
                        $link = $rss->create_element("link");
                        $link->append_child($rss->create_text_node($siteurl."/details.php?id=".$ids[$i]));
                }
                $item->append_child($link);
                {
                        $description = $rss->create_element("description");
                        $description->append_child($rss->create_text_node($descrs[$i]));
                }
                $item->append_child($description);
                {
                        $seeders = $rss->create_element("seeders");
                        $seeders->append_child($rss->create_text_node($seeds[$i]));
                }
                $item->append_child($seeders);
                {
                        $leechers = $rss->create_element("leechers");
                        $leechers->append_child($rss->create_text_node($leeches[$i]));
                }
                $item->append_child($leechers);

        $rdf->append_child($item);
        }

}
$rss->append_child($rdf);

echo $rss->dump_mem(true, "UTF-8");
?>
