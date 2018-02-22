<?php
/*
*------------------------------phpMyBitTorrent V 3.0.0-------------------------* 
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
*-------------------   And Joe Robertson (aka joeroberts)   -------------------*
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
*------              ©2010 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*--------------------   Sunday, May 14, 2010 9:05 PM   ------------------------*
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 poll.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
global $db_prefix, $user, $db, $shout_config,$template,$siteurl,$language,$pmbt_cache;
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
   $vote			= request_var('vote', '0');
  if($vote=='1'){
    $choice			= request_var('choice', '0');
	//die($choice);
	if (!is_numeric($choice) OR $choice > 8)
	pmbt_trigger_error($user->lang['INVALID_ID'],$user->lang['BT_ERROR'],$siteurl);
  if ($user->user && $choice != "" && $choice < 256 && $choice == floor($choice))
  {
    $res = $db->sql_query("SELECT id FROM ".$db_prefix."_polls ORDER BY added DESC LIMIT 1") or sqlerr();
    $arr = $db->sql_fetchrow($res) or die("No poll");
    $pollid = $arr["id"];
  	$userid = $user->id;
    $res = $db->sql_query("SELECT pollid FROM ".$db_prefix."_pollanswers WHERE pollid=$pollid && userid=$userid") or sqlerr();
    $arr = $db->sql_fetchrow($res);
    if ($arr) pmbt_trigger_error("You have already Voted.","Error",$siteurl);
    $db->sql_query("INSERT INTO ".$db_prefix."_pollanswers VALUES(0, $pollid, 0, $userid, $choice)");
    if ($db->sql_affectedrows() != 1)
      pmbt_trigger_error("An error occured. Your vote has not been counted.","Error",$siteurl);
    header("Location: $siteurl/");
    die;
  }
  }
}
	$template->assign_vars(array(
	'POLL_LOCKED'     => false,
	));
if ($user->user){
  $res = $db->sql_query("SELECT * FROM ".$db_prefix."_polls ORDER BY added DESC LIMIT 1");
  if($pollok=($db->sql_numrows($res)))
  {
  	$arr = $db->sql_fetchrow($res);
  	$pollid = $arr["id"];
  	$userid = "".$user->id."";
  	$question = $arr["question"];
  	$o = array($arr["option0"], 
	(!isset($arr["option1"])) ? "" : $arr["option1"], 
	(!isset($arr["option2"])) ? "" : $arr["option2"], 
	(!isset($arr["option3"])) ? "" : $arr["option3"], 
	(!isset($arr["option4"])) ? "" : $arr["option4"],
    (!isset($arr["option5"])) ? "" : $arr["option5"], 
	(!isset($arr["option6"])) ? "" : $arr["option6"], 
	(!isset($arr["option7"])) ? "" : $arr["option7"], 
	(!isset($arr["option8"])) ? "" : $arr["option8"], 
	(!isset($arr["option9"])) ? "" : $arr["option9"],
    (!isset($arr["option10"])) ? "" : $arr["option10"], 
	(!isset($arr["option11"])) ? "" : $arr["option11"], 
	(!isset($arr["option12"])) ? "" : $arr["option12"], 
	(!isset($arr["option13"])) ? "" : $arr["option13"], 
	(!isset($arr["option14"])) ? "" : $arr["option14"],
    (!isset($arr["option15"])) ? "" : $arr["option15"], 
	(!isset($arr["option16"])) ? "" : $arr["option16"], 
	(!isset($arr["option17"])) ? "" : $arr["option17"], 
	(!isset($arr["option18"])) ? "" : $arr["option18"], 
	(!isset($arr["option19"])) ? "" : $arr["option19"]
	);

  // Check if user has already voted
  	$res = $db->sql_query("SELECT * FROM ".$db_prefix."_pollanswers WHERE pollid=$pollid AND userid=$userid") or sqlerr();
  	$arr2 = $db->sql_fetchrow($res);
  }

	$template->assign_vars(array(
	'POLL_ID'         => (isset($arr['id']))? $arr['id'] : '',
	'POLL_LOCKED'     => true,
	'POLL_QUESTION'   => (isset($question))? $question : '',
	));

	if($pollok) {
	$template->assign_vars(array(
	'POLL_VOTED'      => ($arr2) ? true : false,
	));
  	$voted = $arr2;
  	if ($voted)
  	{
    	// display results
    	if (isset($arr["selection"]))
      	$uservote = $arr["selection"];
    	else
      	$uservote = -1;
			// we reserve 255 for blank vote.
    	$res = $db->sql_query("SELECT selection FROM ".$db_prefix."_pollanswers WHERE pollid=$pollid AND selection < 20") or sqlerr();

    	$tvotes = $db->sql_numrows($res);

    	$vs = array(); // array of
    	$os = array();

    	// Count votes
    	while ($arr2 = $db->sql_fetchrow($res))
      	@$vs[$arr2['selection']] += 1;

    	reset($o);
    	for ($i = 0; $i < count($o); ++$i)
      	if ($o[$i])
        	$os[$i] = array($vs[$i], $o[$i]);

    	function srt($a,$b)
    	{
      	if ($a[0] > $b[0]) return -1;
      	if ($a[0] < $b[0]) return 1;
      	return 0;
    	}

    	// now os is an array like this: array(array(123, "Option 1"), array(45, "Option 2"))
    	if ($arr["sort"] == "yes")
    		usort($os, 'srt');

    	$i = 0;
    	while ($a = @$os[$i])
    	{
      	if ($i == $uservote)
        	$a[1] .= "&nbsp;*";
      	if ($tvotes == 0)
      		$p = 0;
      	else
      		$p = round($a[0] / $tvotes * 100);
   $template->assign_block_vars('poll_var_answered', array(
		"P_ANSWER"               => $a[1],
		"P_IMAGE_W"              => ($p * 2),
		"ANSWER_VOTES"           => $p,
		));
      	++$i;
    	}
	$template->assign_vars(array(
	'POLL_VOTE_COUNT'      => number_format($tvotes),
	));
  	}
  	else
  	{
    	$i = 0;
    	while ($a = $o[$i])
    	{
   $template->assign_block_vars('poll_var_no_answered', array(
     'VALUE'      => $i,
	 'VAL_QUEST'  => $a,
     ));
      	++$i;
    	}
  	}
   

}else{
	$template->assign_vars(array(
	'POLL_NO_POLL'      => 'No Polls Set',
	'POLL_VOTED'      => true,
	'POLL_LOCKED'		=> false,
	));
}
}
echo $template->fetch('poll.html');				
?>