<?php
 #############################################################################
 # IMDBPHP                              (c) Giorgos Giagas & Itzchak Rehberg #
 # written by Giorgos Giagas                                                 #
 # extended & maintained by Itzchak Rehberg <izzysoft AT qumran DOT org>     #
 # http://www.izzysoft.de/                                                   #
 # ------------------------------------------------------------------------- #
 # This program is free software; you can redistribute and/or modify it      #
 # under the terms of the GNU General Public License (see doc/LICENSE)       #
 #############################################################################

 /* $Id: imdb.php,v 1.1 2008/09/21 02:34:43 joerobe Exp $ */

require ("imdb.class.php");

$movie = new imdb ($_GET["mid"]);

if (isset ($_GET["mid"])) {
  $movieid = $_GET["mid"];
  $movie->setid ($movieid);

  echo '<HTML><HEAD><TITLE>'.$movie->title().' ('.$movie->year().')';
  echo "</TITLE></HEAD>\n<BODY>\n<TABLE BORDER='1' ALIGN='center' STYLE='border-collapse:collapse'>";

  # Title & year
  echo '<TR><TH COLSPAN="3" STYLE="background-color:#ffb000">';
  echo $movie->title().' ('.$movie->year().")</TD></tr>\n";
  flush();

  # Photo
  echo '<TR><TD rowspan="28" valign="top">';
  if (($photo_url = $movie->photo_localurl() ) != FALSE) {
    echo '<img src="'.$photo_url.'" alt="Cover">';
  } else {
    echo "No photo available";
  }

  # AKAs
  $aka = $movie->alsoknow();
  $cc  = count($aka);
  if ($cc > 0) {
    echo '</TD><TD valign=top width=120><b>Also known as:</b> </td><td>';
    foreach ( $aka as $ak){
      if (empty($ak["year"])) echo $ak["title"]." =&gt; ".$ak["country"]." (".$ak["comment"].")<BR>";
      else echo $ak["title"]." =&gt; ".$ak["year"].", ".$ak["country"]." (".$ak["comment"].")<BR>";
    }
    echo '</td></tr>';
    flush();
  }

  # Seasons
  if ( $movie->seasons() != 0 ) {
   echo '<TR><TD><B>Seasons:</B></TD><TD>'.$movie->seasons().'</TD></TR>';
    flush();
  }

  # Year & runtime
  echo '<TR><TD><B>Year:</B></TD><TD>'.$movie->year().'</TD></TR>';
  echo '<TR><TD valign=top><B>Runtime:</b></TD><TD>';
  echo $movie->runtime ().' minutes</TD></TR>';
  flush();
/*
  # Runtime Line and Runtimes
  echo '<TR><TD valign=top><B>Runtime line:</b></TD><TD>';
  echo $movie->runtime_all().'</TD></TR>';
  echo '<TR><TD valign=top><B>All Runtimes:</b></TD><TD>';
  $runtimes = $movie->runtimes ();
  foreach ($runtimes as $runtime){
    echo $runtime["time"]." min in ".$runtime["country"]." (".$runtime["comment"].")<BR>";
//    if ( ($i+1) != count($runtime)) echo ", ";
  }
  echo '</TD></TR>';
*/

  # MPAA
  echo '<TR><TD><B>MPAA:</b></TD><TD>';
  echo "<table align='left' border='1' style='border-collapse:collapse;background-color:#ddd;'><tr><th style='background-color:#07f;'>Country</th><th style='background-color:#07f;'>Rating</th></tr>";
  foreach ($movie->mpaa() as $key=>$mpaa) {
    echo "<tr><td>$key</td><td>$mpaa</td></tr>";
  }
  echo '</table></TD></TR>';

  # Ratings and votes
  echo '<TR><TD><B>Rating:</b></TD><TD>';
  echo $movie->rating().'</TD></TR>';
  echo '<TR><TD><B>Votes:</B></TD><TD>';
  echo $movie->votes().'</TD></TR>';
  flush();

  # Languages
  echo '<TR><TD><B>Languages:</B></TD><TD>';
  $languages = $movie->languages();
  for ($i = 0; $i + 1 < count($languages); $i++) {
    echo $languages[$i].', ';
  }
  echo $languages[$i].'</TD></TR>';
  flush();

  # Country
  echo '<TR><TD><B>Country:</B></TD><TD>';
  $country = $movie->country();
  for ($i = 0; $i + 1 < count($country); $i++) {
    echo $country[$i].', ';
  }
  echo $country[$i].'</TD></TR>';

  # Genres
  echo '<TR><TD><B>Genre:</B></TD><TD>';
  echo $movie->genre().'</TD></TR>';

  echo '<TR><TD><B>All Genres:</B></TD><TD>';
  $gen = $movie->genres();
  for ($i = 0; $i + 1 < count($gen); $i++) {
    echo $gen[$i].', ';
  }
  echo $gen[$i].'</TD></TR>';

  # Colors
  echo '<TR><TD><B>Colors:</B></TD><TD>';
  $col = $movie->colors();
  for ($i = 0; $i + 1 < count($col); $i++) {
    echo $col[$i].', ';
  }
  echo $col[$i].'</TD></TR>';
  flush();

  # Sound
  echo '<TR><TD><B>Sound:</B></TD><TD>';
  $sound = $movie->sound ();
  for ($i = 0; $i + 1 < count($sound); $i++) {
    echo $sound[$i].', ';
  }
  echo $sound[$i].'</TD></TR>';

  $tagline = $movie->tagline();
  if (!empty($tagline)) {
    echo '<TR><TD valign=top><B>Tagline:</B></TD><TD>$tagline</TD></TR>';
  }

  #==[ Staff ]==
  # director(s)
  $director = $movie->director();
  if (!empty($director)) {
    echo '<TR><TD valign=top><B>Director:</B></TD><TD>';
    echo "<table align='left' border='1' style='border-collapse:collapse;background-color:#ddd;'><tr><th style='background-color:#07f;'>Actor</th><th style='background-color:#07f;'>Role</th></tr>";
    for ($i = 0; $i < count($director); $i++) {
      echo '<tr><td width=200>';
      echo '<a href="http://us.imdb.com/Name?'.$director[$i]["imdb"].'">';
      echo $director[$i]["name"].'</a></td><td>';
      echo $director[$i]["role"]."</td></tr>\n";
    }
    echo '</table></td></tr>';
  }

  # Story
  $write = $movie->writing();
  if (!empty($write)) {
    echo '<TR><TD valign=top><B>Writing By:</B></TD><TD>';
    echo "<table align='left' border='1' style='border-collapse:collapse;background-color:#ddd;'><tr><th style='background-color:#07f;'>Actor</th><th style='background-color:#07f;'>Role</th></tr>";
    for ($i = 0; $i < count($write); $i++) {
      echo '<tr><td width=200>';
      echo '<a href="http://us.imdb.com/Name?'.$write[$i]["imdb"].'">';
      echo $write[$i]["name"].'</a></td><td>';
      echo $write[$i]["role"]."</td></tr>\n";
    }
    echo '</table></td></tr>';
  }
  flush();

  # Producer
  $produce = $movie->producer();
  if (!empty($produce)) {
    echo '<TR><TD valign=top><B>Produced By:</B></TD><TD>';
    echo "<table align='left' border='1' style='border-collapse:collapse;background-color:#ddd;'><tr><th style='background-color:#07f;'>Actor</th><th style='background-color:#07f;'>Role</th></tr>";
    for ($i = 0; $i < count($produce); $i++) {
      echo '<tr><td width=200>';
      echo '<a href="http://us.imdb.com/Name?'.$produce[$i]["imdb"].'">';
      echo $produce[$i]["name"].'</a></td><td>';
      echo $produce[$i]["role"]."</td></tr>\n";
    }
    echo '</table></td></tr>';
  }

  # Music
  $compose = $movie->composer();
  if (!empty($compose)) {
    echo '<TR><TD valign=top><B>Music:</B></TD><TD>';
    echo "<table align='left' border='1' style='border-collapse:collapse;background-color:#ddd;'><tr><th style='background-color:#07f;'>Actor</th><th style='background-color:#07f;'>Role</th></tr>";
    for ($i = 0; $i < count($compose); $i++) {
      echo '<tr><td width=200>';
      echo '<a href="http://us.imdb.com/Name?'.$compose[$i]["imdb"].'">';
      echo $compose[$i]["name"]."</a></td></tr>\n";
    }
    echo '</table></td></tr>';
  }
  flush();

  # Cast
  $cast = $movie->cast();
  echo '<TR><TD valign=top><B>Cast:</B></TD><TD>';
  echo "<table align='left' border='1' style='border-collapse:collapse;background-color:#ddd;'><tr><th style='background-color:#07f;'>Actor</th><th style='background-color:#07f;'>Role</th></tr>";
  for ($i = 0; $i < count($cast); $i++) {
    echo '<tr><td width=200>';
    echo '<a href="http://us.imdb.com/Name?'.$cast[$i]["imdb"].'">';
    echo $cast[$i]["name"].'</a></td><td>';
    echo $cast[$i]["role"]."</td></tr>\n";
  }
  echo '</table></td></tr>';
  flush();

  # Plot outline & plot
  echo '<tr><td valign=top><b>Plot Outline:</b></td><td>';
  echo $movie->plotoutline().'</td></tr>';

  $plot = $movie->plot();
  echo '<tr><td valign=top><b>Plot:</b></td><td><ul>';
  for ($i = 0; $i < count($plot); $i++) {
    echo "<li>".$plot[$i]."</li>\n";
  }
  echo '</ul></td></tr>';
  flush();

  # Taglines
  $taglines = $movie->taglines();
  if (!empty($taglines)) {
    echo '<tr><td valign=top><b>Taglines:</b></td><td><ul>';
    for ($i = 0; $i < count($taglines); $i++) {
      echo "<li>".$taglines[$i]."</li>\n";
    }
    echo '</ul></td></tr>';
  }

  if ( $movie->seasons() != 0 ) {
    $episodes = $movie->episodes();
    echo '<tr><td valign=top><b>Episodes:</b></td><td>';
    for ( $season = 1; $season <= $movie->seasons(); $season++ ) {
      for ( $episode = 1; $episode <= count($episodes[$season]); $episode++ ) {
        $episodedata = &$episodes[$season][$episode];
        echo '<b>Season '.$season.', Episode '.$episode.': <a href="'.$_SERVER["PHP_SELF"].'?mid='.$episodedata['imdbid'].'">'.$episodedata['title'].'</a></b> (<b>Original Air Date: '.$episodedata['airdate'].'</b>)<br>'.$episodedata['plot'].'<br/><br/>';
      }
    }
    echo '</td></tr>';
  }

  # Selected User Comment
  echo '<tr><td valign=top><b>User Comments:</b></td><td>';
  echo $movie->comment().'</td></tr>';

  # Quotes
  echo '<tr><td valign=top><b>Movie Quotes:</b></td><td>';
  $quotes = $movie->quotes();
  echo $quotes[0].'</td></tr>';

  # Trailer
  echo '<tr><td valign=top><b>Trailers:</b></td><td>';
  $trailers = $movie->trailers();
  for ($i=0;$i<count($trailers);++$i) {
    echo "<a href='".$trailers[$i]."'>".$trailers[$i]."</a><br>\n";
  }
  echo '</td></tr>';

  # Crazy Credits
  $crazy = $movie->crazy_credits();
  $cc    = count($crazy);
  if ($cc) {
    echo '<tr><td valign=top><b>Crazy Credits:</b></td><td>';
    echo "We know about $cc <i>Crazy Credits</i>. One of them reads:<br>$crazy[0]</td></tr>";
  }

  # Goofs
  $goofs = $movie->goofs();
  $gc    = count($goofs);
  if ($gc > 0) {
    echo '<tr><td valign=top><b>Goofs:</b></td><td>';
    echo "We know about $gc goofs. Here comes one of them:<br>";
    echo "<b>".$goofs[0]["type"]."</b> ".$goofs[0]["content"]."</td></tr>";
  }

  # Trivia
  $trivia = $movie->trivia();
  $gc     = count($trivia);
  if ($gc > 0) {
    echo '<tr><td valign=top><b>Trivia:</b></td><td>';
    echo "There are $gc entries in the trivia list - like these:<br><ul>";
    for ($i=0;$i<5;++$i) {
      if (empty($trivia[$i])) break;
      echo "<li>".$trivia[$i]."</li>";
    }
    echo "</ul></td></tr>\n";
  }

  # Soundtracks
  $soundtracks = $movie->soundtrack();
  $gc = count($soundtracks);
  if ($gc > 0) {
    echo '<tr><td valign=top><b>Soundtracks:</b></td><td>';
    echo "There are $gc soundtracks listed - like these:<br>";
    echo "<table align='center' border='1' style='border-collapse:collapse;background-color:#ddd;'><tr><th style='background-color:#07f;'>Soundtrack</th><th style='background-color:#07f;'>Credit 1</th><th style='background-color:#07f;'>Credit 2</th></tr>";
    for ($i=0;$i<5;++$i) {
      if (empty($soundtracks[$i])) break;
      echo "<tr><td>".$soundtracks[$i]["soundtrack"]."</td><td>".$soundtracks[$i]["credits"][0]."</td><td>".$soundtracks[$i]["credits"][1]."</td></tr>";
    }
    echo "</table></td></tr>\n";
  }

  echo '</TABLE><BR>';
}
?>
