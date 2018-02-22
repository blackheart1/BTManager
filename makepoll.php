<?php
/*
*----------------------------phpMyBitTorrent V 2.0-beta4-----------------------*
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
*------              2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*/
if (defined('IN_PMBT'))
{
	die ("You can't include this file");
}
else
{
	define("IN_PMBT",true);
}
require_once("common.php");
require_once("include/torrent_functions.php");
$template = new Template();
$user->set_lang('makepoll',$user->ulanguage);
set_site_var($user->lang['POLL_MANAGER']);
function is_valid_id($id)
{
  return is_numeric($id) && ($id > 0) && (floor($id) == $id);
}
$timestamp=time();                                                                                            
$timeout=$timestamp-$timeoutseconds=300;  
$action			= request_var("action", '' , true);
$pollid			= request_var('pollid', '0');
$question		= request_var("question", '' , true);
$option0		= request_var("option0", '' , true);
$option1		= request_var("option1", '' , true);
$option2		= request_var("option2", '' , true);
$option3		= request_var("option3", '' , true);
$option4		= request_var("option4", '' , true);
$option5		= request_var("option5", '' , true);
$option6		= request_var("option6", '' , true);
$option7		= request_var("option7", '' , true);
$option8		= request_var("option8", '' , true);
$option9		= request_var("option9", '' , true);
$sort			= request_var("sort", '' , true);
$returnto		= request_var("returnto", '' , true);
				$template->assign_vars(array(
										'HEADER'	=>	$user->lang['MAKE_POLL'],
										));
if ($action == "edit")
{
	if (!is_valid_id($pollid))
		bterror("Invalid ID $pollid.","Error");
	$res = $db->sql_query("SELECT * FROM ".$db_prefix."_polls WHERE id = $pollid")
			or sqlerr(__FILE__, __LINE__);
	if ($db->sql_numrows($res) == 0)
		bterror("No poll found with ID $pollid.","Error");
	$poll = $db->sql_fetchrow($res);
}
if ($_SERVER["REQUEST_METHOD"] == "POST")
{

  if ($question == '' || $option0 == '' || $option1 == '')
    bterror("Missing form data!","Error");

  if ($pollid)
  {
	  $sql = "UPDATE ".$db_prefix."_polls SET " .
		"question = '" . $question . "', " .
		"option0 = '" . $option0 . "', " .
		"option1 = '" . $option1 . "', " .
		"option2 = '" . $option2 . "', " .
		"option3 = '" . $option3 . "', " .
		"option4 = '" . $option4 . "', " .
		"option5 = '" . $option5 . "', " .
		"option6 = '" . $option6 . "', " .
		"option7 = '" . $option7 . "', " .
		"option8 = '" . $option8 . "', " .
		"option9 = '" . $option9 . "', " .
		"sort = '" . $sort . "' " .
    	"WHERE id = $pollid";
  
		$db->sql_query($sql);
  }
  else
  {
	  $sql = "INSERT INTO ".$db_prefix."_polls VALUES(0" .
		", '" . gmdate("Y-m-d H:i:s", time()) . "'" .
		", '" . $question .
		"', '" . $option0 .
		"', '" . $option1 .
		"', '" . $option2 .
		"', '" . $option3 .
		"', '" . $option4 .
		"', '" . $option5 .
		"', '" . $option6 .
		"', '" . $option7 .
		"', '" . $option8 .
		"', '" . $option9 .
		"', '" . $sort .
		"')";
  
  	$db->sql_query($sql);
  }

  if ($returnto == "main")
		header("Location: $siteurl");
  elseif ($pollid)
		header("Location: $siteurl/polls.php#$pollid");
	else
		header("Location: $siteurl");
	die;
}


if ($pollid)
				$template->assign_vars(array(
										'HEADER'	=>	$user->lang['EDIT_POLL'],
										'HIDDEN'	=>	build_hidden_fields(array('pollid'=>$pollid , 'action'=>'edit','returnto'=>$returnto)),
										));
	//print("<center><h1>Edit poll</h1></center>");
else
{
	// Warn if current poll is less than 3 days old
	$res = $db->sql_query("SELECT question,added FROM ".$db_prefix."_polls ORDER BY added DESC LIMIT 1") or sqlerr();
	$arr = $db->sql_fetchrow($res);
	if ($arr)
	{
	  $hours = floor((strtotime(gmdate("Y-m-d H:i:s", time())) - sql_timestamp_to_unix_timestamp($arr["added"])) / 3600);
	  $days = floor($hours / 24);
	  if ($days < 3)
	  {
	    $hours -= $days * 24;
	    if ($days)
	      $t = "$days day" . ($days > 1 ? "s" : "");
	    else
	      $t = "$hours hour" . ($hours > 1 ? "s" : "");
	    //print("<p><center><font color=red><b>Note: The current poll (<i>" . $arr["question"] . "</i>) is only $t old.</b></font></center></p>");
	  }
	}

}
				$template->assign_vars(array(
										'P_QUESTION'	=>	$poll['question'],
										'P_OPTIONA'		=>	$poll['option0'],
										'P_OPTIONB'		=>	$poll['option1'],
										'P_OPTIONC'		=>	$poll['option2'],
										'P_OPTIOND'		=>	$poll['option3'],
										'P_OPTIONE'		=>	$poll['option4'],
										'P_OPTIONF'		=>	$poll['option5'],
										'P_OPTIONG'		=>	$poll['option6'],
										'P_OPTIONH'		=>	$poll['option7'],
										'P_OPTIONI'		=>	$poll['option8'],
										'P_SORT'		=>	$poll["sort"] == "no" ? false : true,
										'P_SUBMIT'		=>	$user->lang['SUBMIT'],
										));
				echo $template->fetch('managepolls.html');
					close_out();
?>
