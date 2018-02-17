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
*------              �2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*/

header('Content-Type: text/xml');

 $rss = new DomDocument("1.0","UTF-8");
{
     $rss->formatOutput = true;

     $rdf = $rss->appendChild( $rss->createElement( 'rss' ) );
     $rdf->setAttribute( "version" , "2.0" );
     $rdf->setAttribute( "xmlns:dc" , "http://purl.org/dc/elements/1.1/" );
     $rdf->setAttribute( "xmlns:content" , "http://purl.org/rss/1.0/modules/content/" );
     $rdf->setAttribute( "xmlns:atom" , "http://www.w3.org/2005/Atom" );
	 $channel = $rss->createElement( "channel" );
	 $rdf->appendChild($channel );
       {
         $title = $rss->createElement( "title" );
         $title->appendChild( $rss->createTextNode( $sitename ) );
       }
       $channel->appendChild( $title );
       {
         $link = $rss->createElement( "link" );
         $link->appendChild( $rss->createTextNode( $siteurl ) );
       }
       $channel->appendChild( $link );
       {
         $description = $rss->createElement( "description" );
         $description->appendChild( $rss->createTextNode( sprintf($user->lang[$descr],$descra,$descrb) ) );
       }
       $channel->appendChild( $description );
       {
         $language = $rss->createElement( "language" );
         $language->appendChild( $rss->createTextNode( $user->lang['USER_LANG'] ) );
       }
       $channel->appendChild( $language );
       {
         $lastbuild = $rss->createElement( "lastBuildDate" );
         $lastbuild->appendChild( $rss->createTextNode( date(DATE_RFC2822, time()) ) );
       }
       $channel->appendChild( $lastbuild );
       {
         $generator = $rss->createElement( "generator" );
         $generator->appendChild( $rss->createTextNode( 'Bit Torrent Manager' ) );
       }
       $channel->appendChild( $generator );
       {
         $ttl = $rss->createElement( "ttl" );
         $ttl->appendChild( $rss->createTextNode( '60' ) );
       }
       $channel->appendChild( $ttl );
       {
         $atom = $rss->createElement( "atom:link" );
	     $atom->setAttribute( "href" , $siteurl."/backend.php?op=".$op );
	     $atom->setAttribute( "rel" , "self" );
	     $atom->setAttribute( "type" , "application/rss+xml" );
       }
       $channel->appendChild( $atom );
     for ( $i = 0; $i < count( $ids ); $i++ )
     {
       $item = $rss->createElement( "item" );
       //$item->setAttribute( "rdf:about" , $siteurl . "/details.php?id=" . $ids[ $i ] );
       {
         $title = $rss->createElement( "title" );
         $title->appendChild( $rss->createTextNode( $names[ $i ] ) );
       }
       $item->appendChild( $title );
       {
         $size = $rss->createElement( "size" );
         $size->appendChild( $rss->createTextNode( $sizet[ $i ] ) );
       }
       $item->appendChild( $size );
                {
                        $pubdt = $rss->createElement("pubDate");
                        $pubdt->appendChild($rss->createTextNode($pubd[$i]));
                }
                $item->appendChild($pubdt);
       {
         $link = $rss->createElement( "link" );
         $link->appendChild( $rss->createTextNode( $siteurl."/details.php?id=" . $ids[ $i ] ) );
       }
       $item->appendChild( $link );
       {
         $description = $rss->createElement( "description" );
         $description->appendChild( $rss->createCDATASection( $descrs[ $i ] ) );
       }
       $item->appendChild( $description );
	   {
		$enclosures = $rss->createElement( "enclosure" );
		$enclosures->setAttribute( "url" , $siteurl."/download.php?id=" . $ids[ $i ] . (($user->passkey)?"&rsskey=$user->passkey" : '' ));
		$enclosures->setAttribute( "length" , $sizet[ $i ] );
		$enclosures->setAttribute( "Content-ID" , $names[ $i ]  );
		$enclosures->setAttribute( "size" , $sizet[ $i ] );
		$enclosures->setAttribute( "type" , "application/x-bittorrent" );
	   }
       $item->appendChild( $enclosures );
       {
         $guid = $rss->createElement( "guid" );
		$guid->setAttribute( "isPermaLink" , 'false' );
         $guid->appendChild( $rss->createTextNode( $siteurl."/details.php?id=" . $ids[ $i ] ) );
       }
       $item->appendChild( $guid );

       $channel->appendChild( $item );
     }
/*
       {
         $items = $rss->createElement( "items" );
         {
           $rdf_Seq = $rss->createElement( "rdf:Seq" );

           foreach ( $ids as $tid )
           {
             $rdf_li = $rss->createElement( "rdf:li" );
             $rdf_li->setAttribute( "rdf:resource" , $siteurl."/details.php?id=".$tid );
             $rdf_Seq->appendChild( $rdf_li );
           }

         }
         $items->appendChild( $rdf_Seq );
       }
       $channel->appendChild( $items );
     }


     $rdf->appendChild( $channel );
     for ( $i = 0; $i < count( $ids ); $i++ )
     {
       $item = $rss->createElement( "item" );
       $item->setAttribute( "rdf:about" , $siteurl . "/details.php?id=" . $ids[ $i ] );
       {
         $title = $rss->createElement( "title" );
         $title->appendChild( $rss->createTextNode( $names[ $i ] ) );
       }
       $item->appendChild( $title );
       {
         $link = $rss->createElement( "link" );
         $link->appendChild( $rss->createTextNode( $siteurl."/details.php?id=" . $ids[ $i ] ) );
       }
       $item->appendChild( $link );
       {
         $description = $rss->createElement( "description" );
         $description->appendChild( $rss->createTextNode( $descrs[ $i ] ) );
       }
       $item->appendChild( $description );
	   {
		$enclosures = $rss->createElement( "enclosure" );
		$enclosures->setAttribute( "url" , $siteurl."/download.php?id=" . $ids[ $i ] );
		$enclosures->setAttribute( "Length" , "432080416" );
		$enclosures->setAttribute( "Type" , "application/x-bittorrent" );
	   }
       $item->appendChild( $enclosures );
       {
         $seeders = $rss->createElement( "seeders" );
         $seeders->appendChild( $rss->createTextNode( $seeds[ $i ] ) );
       }
       $item->appendChild( $seeders );
       {
         $leechers = $rss->createElement( "leechers" );
         $leechers->appendChild( $rss->createTextNode( $leeches[ $i ] ) );
       }
       $item->appendChild( $leechers );

       $rdf->appendChild( $item );
     }*/
}

$rss->appendChild( $rdf );

echo $rss->saveXML();
?>