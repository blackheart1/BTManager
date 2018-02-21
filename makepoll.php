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
** File makepoll.php 2018-02-17 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
include("header.php");
global $db, $db_prefix;
function is_valid_id($id)
{
  return is_numeric($id) && ($id > 0) && (floor($id) == $id);
}
$timestamp=time();                                                                                            
$timeout=$timestamp-$timeoutseconds=300;  
$action = $_GET["action"];
$pollid = $_GET["pollid"];
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
  $pollid = $_POST["pollid"];
  $question = $_POST["question"];
  $option0 = $_POST["option0"];
  $option1 = $_POST["option1"];
  $option2 = $_POST["option2"];
  $option3 = $_POST["option3"];
  $option4 = $_POST["option4"];
  $option5 = $_POST["option5"];
  $option6 = $_POST["option6"];
  $option7 = $_POST["option7"];
  $option8 = $_POST["option8"];
  $option9 = $_POST["option9"];
  $sort = $_POST["sort"];
  $returnto = $_POST["returnto"];

  if (!$question || !$option0 || !$option1)
    bterror("Missing form data!","Error");

  if ($pollid)
  
		$db->sql_query("UPDATE ".$db_prefix."_polls SET " .
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
    "WHERE id = $pollid") or die(mysql_error(__FILE__, __LINE__));
	
	
  else
  
  	$db->sql_query("INSERT INTO ".$db_prefix."_polls VALUES(0" .
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
  	"')")  or die(mysql_error(__FILE__, __LINE__));

  if ($returnto == "main")
		header("Location: $siteurl");
  elseif ($pollid)
		header("Location: $siteurl/polls.php#$pollid");
	else
		header("Location: $siteurl");
	die;
}

//stdhead();

if ($pollid)
	print("<center><h1>Edit poll</h1></center>");
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
	    print("<p><center><font color=red><b>Note: The current poll (<i>" . $arr["question"] . "</i>) is only $t old.</b></font></center></p>");
	  }
	}

}
	OpenTable("polls");
print("<p><font color=red><center>*</font> required</center></p>");
?>

<table border=0 cellspacing=1 cellpadding=5 align=center>
<form method=post action=makepoll.php>
<tr><td class=rowhead>Question <font color=red>*</font></td><td align=left><input name=question size=80 maxlength=255 value="<?php echo $poll['question']?>"></td></tr>
<tr><td class=rowhead>Option 1 <font color=red>*</font></td><td align=left><input name=option0 size=80 maxlength=60 value="<?php echo $poll['option0']?>"><br></td></tr>
<tr><td class=rowhead>Option 2 <font color=red>*</font></td><td align=left><input name=option1 size=80 maxlength=60 value="<?php echo $poll['option1']?>"><br></td></tr>
<tr><td class=rowhead>Option 3</td><td align=left><input name=option2 size=80 maxlength=60 value="<?php echo $poll['option2']?>"><br></td></tr>
<tr><td class=rowhead>Option 4</td><td align=left><input name=option3 size=80 maxlength=60 value="<?php echo $poll['option3']?>"><br></td></tr>
<tr><td class=rowhead>Option 5</td><td align=left><input name=option4 size=80 maxlength=60 value="<?php echo $poll['option4']?>"><br></td></tr>
<tr><td class=rowhead>Option 6</td><td align=left><input name=option5 size=80 maxlength=60 value="<?php echo $poll['option5']?>"><br></td></tr>
<tr><td class=rowhead>Option 7</td><td align=left><input name=option6 size=80 maxlength=60 value="<?php echo $poll['option6']?>"><br></td></tr>
<tr><td class=rowhead>Option 8</td><td align=left><input name=option7 size=80 maxlength=60 value="<?php echo $poll['option7']?>"><br></td></tr>
<tr><td class=rowhead>Option 9</td><td align=left><input name=option8 size=80 maxlength=60 value="<?php echo $poll['option8']?>"><br></td></tr>
<tr><td class=rowhead>Sort</td><td>
<input type=radio name=sort value=yes <?php echo $poll["sort"] != "no" ? " checked" : "" ?>>Yes
<input type=radio name=sort value=no <?php echo $poll["sort"] == "no" ? " checked" : "" ?>> No
</td></tr>
<tr><td colspan=2 align=center><input type=submit value=<?php echo $pollid?"'Edit poll'":"'Create poll'"?> style='height: 20pt'></td></tr>
</table>
<input type=hidden name=pollid value=<?php echo $poll["id"]?>>
<input type=hidden name=returnto value=<?php echo $_GET["returnto"]?>>
</form>
<br>
<?php CloseTable();
include ("footer.php")
?>
