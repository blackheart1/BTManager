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
** File backend-php5.php 2018-02-18 14:32:00 joeroberts
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT'))
{
	include_once './../../security.php';
	die ();
}

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
}

$rss->appendChild( $rdf );

echo $rss->saveXML();
?>