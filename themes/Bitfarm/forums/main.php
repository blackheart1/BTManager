<?php
$folder_icon = "topic_read.png";
$subforumread = "subforum_read.gif";
$subforumunread = "subforum_unread.gif";
$topic_unread = "topic_unread.png";
$topic_read_locked = "topic_read_locked.png";
$topic_unread_locked = "topic_unread_locked.png";
$button_reply = "button_topic_reply.png";
$button_new_topic = "button_topic_new.png";
$p_quote = "icon_post_quote.png";
$p_delete = "icon_post_delete.png";
$p_reply = "p_reply.png";
$p_report = "p_report.png";
$p_edit = "icon_post_edit.png";
$icon_pm = "icon_contact_pm.png";
$topic_delete = "topic_delete.png";
echo "\n<link href=\"./themes/$theme/forums/style.css\" rel=\"stylesheet\" type=\"text/css\" media=\"screen, projection\" />\n";
function showerror($heading = "Error", $text, $sort = "Error") {
  stdhead("$sort: $heading");
  forum_table("<font color=red>$sort: $heading</font>", center);
  echo $text;
  forum_table_close();
  stdfoot();
  die;
}
//setup the forum head aread
function forumheader($location){
global $user,$db, $db_prefix;
echo "<table align=center cellpadding=0 cellspacing=0 style='border-collapse: collapse; border-left: solid 2px #666666; border-right: solid 2px #666666; border-top: solid 2px #3C3C3C; border-bottom: solid 2px #131313;'  width=100% border=1><tr><td><table  width='100%' cellspacing='5' border=0 class = fheader ><tr><td><a href='forums.php'>Welcome to our Forums</a></td><td align='right'>";
if(checkaccess("m_modforum"))echo"[ <a href=admin-forums.php>Administration Control Panel</a> ]&nbsp;&nbsp;";
echo"<img src='images/atb_help.gif' border='0' alt='' />&nbsp;<a href='faq.php'>FAQ</a>&nbsp; &nbsp;&nbsp;<img src='images/atb_search.gif' border='0' alt='' />&nbsp;<a href='forums.php?action=search'>Search</a></td></tr></table><table width='100%' cellspacing='5' border=0 class = ftableback><tr><td><strong>&nbsp;</td><td align='right'><b>Controls</a></b> &middot; <a href='forums.php?action=viewunread'>View New Posts</a> &middot; <a href='?catchup'>Mark All Read</a></td></tr></table></td></tr></table><br />";
print ("<table align=center cellpadding=0 cellspacing=5  width=100% border=1 class='fnavbar'><tr><td><div>&nbsp;&nbsp;You are in: &nbsp;<a href='forums.php'>Forums</a> > $location</b></div></td></tr></table><br />");
}
function forummain(){
}
function legend(){
global $themedir, $topic_unread, $folder_icon, $topic_read_locked;
print("<p><table class=\"legend\" border=0 cellspacing=0 cellpadding=0><tr valing=center>\n");
print("<td ><img src=". $themedir ."$topic_unread style='margin-right: 5px'></td><td >New posts</td>\n");
print("<td ><img src=". $themedir ."$folder_icon style='margin-left: 10px; margin-right: 5px'></td><td >No New posts</td>\n");
print("<td ><img src=". $themedir ."$topic_read_locked style='margin-left: 10px; margin-right: 5px'></td><td >Locked topic</td>\n");
print("</tr></table></p>\n");
}
function forumpostertable($res, $frame_caption) {
global $user,$db, $db_prefix;
	print("$frame_caption<br><table width=160 border=0><tr><td>\n");
	print("<table align=center cellpadding=1 cellspacing=0 style='border-collapse: collapse; border-left: solid 2px #666666; border-right: solid 2px #666666; border-top: solid 2px #3C3C3C; border-bottom: solid 2px #131313;'  width=100% border=1 >\n");
	?>
	<tr>
	<td width="10"><font size=1 face=Verdana><b>Rank</b></td>
	<td width="130" align=left><font size=1 face=Verdana><b>User</b></td>
	<td width="10" align=right><font size=1 face=Verdana><b>Posts</b></td>
	</tr>
	<?
    $num = 0;
    while ($a = $db->sql_fetchrow($res))
    {
      ++$num;
      print("<tr><td class=alt1>$num</td><td class=alt2 align=left><a href=user.php?op=profile&id=" . $a['id'] . "><font color=\"".getusercolor(getlevel_name($a['id']))."\">" . $a['username'] . "</font></a></td><td align=right class=alt1>$a[num]</td></tr>\n");
    }
  print("</table>");
	 print("</td></tr></table>\n");
}
function stdhead($title = '', $width = '')
{
        echo "<table width=\"100%\" cellspacing=\"0\">";
	    echo" <tr valign=\"middle\"><td>";   
}
function forum_table($title = '', $width = '')
{
        global $tableopen, $siteurl, $db, $db_prefix;
OpenTable($title, $width);
}
function forum_table_close()
{
        global $tableopen, $siteurl,$db, $db_prefix;
		CloseTable();
}
function stdfoot(){
        echo "</td></tr></table>\n";
}
// Inserts a quick jump menu
function insert_quick_jump_menu($currentforum = 0) {
global $user,$db, $db_prefix;
    print("<p align=right><form method=get action=? name=jump>\n");
    print("<input type=hidden name=action value=viewforum>\n");
    print("Quick Jump: ");
    print("<select name=forumid onchange=\"if(this.options[this.selectedIndex].value != -1){ forms['jump'].submit() }\">\n");
    $res = $db->sql_query("SELECT * FROM ".$db_prefix."_forum_forums ORDER BY name") or forumsqlerr(__FILE__, __LINE__);
    while ($arr = $db->sql_fetchrow($res)) {
      if ($arr["minclassread"] == "0" || in_array($user->group,explode("  ", $arr["minclassread"])))
        print("<option value=" . $arr["id"] . ($currentforum == $arr["id"] ? " selected>" : ">") . $arr["name"] . "\n");
		
    }
    print("</select>\n");
    print("<input type=image class=btn src=images/go.gif border=0>\n");
   // print("<input type=submit value='Go!'>\n");
    print("</form>\n</p>");
}
// Inserts a compose frame
function insert_compose_frame($id, $newtopic = true, $text = '') {
    global $max_subject_length, $textarea, $db, $db_prefix, $user, $attach_config, $siteurl;

	if ($newtopic) {
		$res = $db->sql_query("SELECT name FROM ".$db_prefix."_forum_forums WHERE id=$id") or forumsqlerr(__FILE__, __LINE__);
		$arr = $db->sql_fetchrow($res) or die("Bad forum id");
		$forumname = stripslashes($arr["name"]);
		$forum_id = $id;

		print("<p align=center><b>New topic in <a href=forums.php?action=viewforum&forumid=$id>$forumname</a></b></p>\n");
	}else{
		$res = $db->sql_query("SELECT * FROM ".$db_prefix."_forum_topics WHERE id=$id") or forumsqlerr(__FILE__, __LINE__);
		$arr = $db->sql_fetchrow($res) or showerror("Forum error", "Topic not found.");
		$forum_id = $arr["forumid"];
		$subject = stripslashes($arr["subject"]);
		print("<p align=center>Reply to topic: <a href=forums.php?action=viewtopic&topicid=$id>$subject</a></p>");
	}

    print("<p align=center>Flaming or other anti-social behavior will not be tolerated.\n");
    print("<br>Please do try not to discuss upload/release-specific stuff here, post a torrent comment instead!<br><br><B>Please make sure to read the <a href=rules.php>rules</a> before you post</B><br></p>\n");

    forum_table("Compose Message", true);
    print("<form id=\"postform\" enctype=\"multipart/form-data\" name=Form method=post action=?action=post>\n");
    if ($newtopic)
      print("<input type=hidden name=forumid value=$id>\n");
    else
      print("<input type=hidden name=topicid value=$id>\n");
  print("<table border=0 width=100%>");


			print("<center><table border=0 cellpadding=0 cellspacing=0><tr><td colspan=3>&nbsp;</td></tr>");
			if ($newtopic)echo "<tr><td> <b>Subject:</b><input type=text size=70 maxlength=$max_subject_length name=subject ></td></tr>";
			echo "<tr><td valign=top>";
echo $textarea->quick_bbcode('Form','body');
if ($newtopic)echo $textarea->input('body');
else
echo $textarea->input('body','center',"2","10","80",$text);
echo "</table><br />\n";
?><script language=javascript>
var text_name = 'body';
var form_name = 'postform';
var panels = new Array('options-panel', 'attach-panel', 'poll-panel');
var show_panel = 'options-panel';
function PopMoreSmiles(form,text) {
        link='moresmiles.php?form='+form+'&text='+text;
		newWin=window.open(link,'moresmile','height=500,width=600,resizable=no,scrollbars=yes');
		if (window.focus) {newWin.focus()
		}
		}
		</script><?php echo "<center><a href=\"javascript: PopMoreSmiles('Form','body')\">More Smiles</a><br /><a href=bbcode.php target=\"_blank\">BBcode help</a><br /><br /></center>";
echo "<input name=\"book\" value=\"yes\" type=\"checkbox\">Notify me when a reply is posted";

if(isset($_POST['add_file'])){
	include_once('include/function_posting.php');
	$filedata = add_attach('fileupload', $forum_id, false, '', false);
	$filecomment = request_var('filecomment', '');
				$error = $filedata['error'];
				
				if ($filedata['post_attach'] && !sizeof($error))
				{
					$sql_ary = array(
						'physical_filename'	=> $filedata['physical_filename'],
						'attach_comment'	=> $db->sql_escape(stripslashes($filecomment)),
						'real_filename'		=> $filedata['real_filename'],
						'extension'			=> $filedata['extension'],
						'mimetype'			=> $filedata['mimetype'],
						'filesize'			=> $filedata['filesize'],
						'filetime'			=> $filedata['filetime'],
						'thumbnail'			=> $filedata['thumbnail'],
						'is_orphan'			=> 1,
						'in_message'		=> 0,
						'poster_id'			=> $user->id,
					);

					$db->sql_query('INSERT INTO torrent_attachments ' . $db->sql_build_array('INSERT', $sql_ary));
					$filedata['real_id'] = $db->sql_nextid();
					}
		$attachment_data = (isset($_POST['attachment_data'])) ? $_POST['attachment_data'] : array();
		$comment_list = request_var('comment_list', array(''), true);
echo "<div class=\"inner\"><span class=\"corners-top\"><span></span></span>";
			echo "<h3>Posted attachments</h3>";

			foreach($attachment_data as $data => $val)
			{
			echo "<fieldset class=\"fields2\">";

						echo "<dl>";

				echo "<dt><label for=\"comment_list_" . $data . "\">File comment:</label></dt>";
				echo "<dd><textarea name=\"comment_list[" . $data . "]\" id=\"comment_list_" . $data . "\" rows=\"1\" cols=\"35\" class=\"inputbox\">" . $comment_list[$data] . "</textarea></dd>";

				echo "<dd><a href=\"file.php?id=" . $attachment_data[$data]['attach_id'] . "\" class=\"right\">" . $attachment_data[$data]['real_filename'] . "</a></dd>";
				echo "<dd style=\"margin-top: 5px;\">";
					echo "<input value=\"Place inline\" onclick=\"attach_inline(0, '" . $attachment_data[$data]['real_filename'] . "');\" class=\"button2\" type=\"button\">&nbsp; 					<input name=\"delete_file[" . $data . "]\" value=\"Delete file\" class=\"button2\" type=\"submit\">";
				echo "</dd>";
			echo "</dl>";
			echo "<input name=\"attachment_data[" . $data . "][attach_id]\" value=\"" . $attachment_data[$data]['attach_id'] . "\" type=\"hidden\"><input name=\"attachment_data[" . $data . "][is_orphan]\" value=\"" . $attachment_data[$data]['is_orphan'] . "\" type=\"hidden\"><input name=\"attachment_data[" . $data . "][real_filename]\" value=\"" . $attachment_data[$data]['real_filename'] . "\" type=\"hidden\"><input name=\"attachment_data[" . $data . "][attach_comment]\" value=\"" . $comment_list[$data] . "\" type=\"hidden\">				";
			echo "</fieldset>";

			echo "<span class=\"corners-bottom\"><span></span></span>";
			}
		if(!isset($data) AND !$data == '')$data = 0;
		else
		$data = $data+1;
			echo "<fieldset class=\"fields2\">";

						echo "<dl>";

				echo "<dt><label for=\"comment_list_" . $data . "\">File comment:</label></dt>";
				echo "<dd><textarea name=\"comment_list[" . $data . "]\" id=\"comment_list_" . $data . "\" rows=\"1\" cols=\"35\" class=\"inputbox\">" . $filecomment . "</textarea></dd>";

				echo "<dd><a href=\"./file.php?id=" . $filedata['real_id'] . "\" class=\"right\">" . $filedata['real_filename'] . "</a></dd>";
				echo "<dd style=\"margin-top: 5px;\">";
					echo "<input value=\"Place inline\" onclick=\"attach_inline(" . $data . ", '" . $filedata['real_filename'] . "');\" class=\"button2\" type=\"button\">&nbsp; 					<input name=\"delete_file[0]\" value=\"Delete file\" class=\"button2\" type=\"submit\">";
				echo "</dd>";
			echo "</dl>";
			echo "<input name=\"attachment_data[" . $data . "][attach_id]\" value=\"" . $filedata['real_id'] . "\" type=\"hidden\"><input name=\"attachment_data[" . $data . "][is_orphan]\" value=\"1\" type=\"hidden\"><input name=\"attachment_data[" . $data . "][real_filename]\" value=\"" . $filedata['real_filename'] . "\" type=\"hidden\"><input name=\"attachment_data[" . $data . "][attach_comment]\" value=\"" . $filecomment . "\" type=\"hidden\">				";
			echo "</fieldset>";

			echo "<span class=\"corners-bottom\"><span></span></span>";
			echo "</div>";
}
			print("</td></tr><tr><td colspan=3 align=center><br><input accesskey=\"k\" tabindex=\"8\" name=\"save\" value=\"Save\" class=\"button2\" type=\"submit\">&nbsp; <input tabindex=\"5\" name=\"preview\" value=\"Preview\" class=\"button1\" onclick=\"document.getElementById('postform').action += '#preview';\" type=\"submit\">&nbsp;<input type=submit class=btn value='Submit'><br><br></td></tr></center>");
	
    print("</table>");
echo '			<div id="tabs">

			<ul>
				<li id="options-panel-tab" class="activetab"><a href="#tabs" onclick="subPanels(\'options-panel\'); return false;"><span>Options</span></a></li>
				<li class="" id="attach-panel-tab"><a href="#tabs" onclick="subPanels(\'attach-panel\'); return false;"><span>Upload attachment</span></a></li>			</ul>
		</div>
		<div style="display: block;" class="panel bg3" id="options-panel">
		<div class="inner"><span class="corners-top"><span></span></span>

		<fieldset class="fields1">

							<div><label for="disable_bbcode"><input name="disable_bbcode" id="disable_bbcode" type="checkbox"> Disable BBCode</label></div>
							<div><label for="disable_smilies"><input name="disable_smilies" id="disable_smilies" type="checkbox"> Disable smilies</label></div>
							<div><label for="disable_magic_url"><input name="disable_magic_url" id="disable_magic_url" type="checkbox"> Do not automatically parse URLs</label></div>
							<div><label for="attach_sig"><input name="attach_sig" id="attach_sig" checked="checked" type="checkbox"> Attach a signature (signatures can be altered via the UCP)</label></div>
							<div><label for="notify"><input name="notify" id="notify" type="checkbox"> Notify me when a reply is posted</label></div>

							<div><label for="lock_topic"><input name="lock_topic" id="lock_topic" type="checkbox"> Lock topic</label></div>
					</fieldset>
			<input name="creation_time" value="1293527231" type="hidden">
<input name="form_token" value="40411948b261af014b5c0b4f867cf21d11fdaac6" type="hidden">
	<span class="corners-bottom"><span></span></span></div>
</div>

<div style="display: none;" class="panel bg3" id="attach-panel">
	<div class="inner"><span class="corners-top"><span></span></span>

	<p>If you wish to attach one or more files enter the details below.</p>
	
	<fieldset class="fields2">
	<dl>
		<dt><label for="fileupload">Filename:</label></dt>
		<dd>
			<input name="fileupload" id="fileupload" maxlength="262144" value="" class="inputbox autowidth" type="file"> 
			<input name="add_file" value="Add the file" class="button2" onclick="upload = true;" type="submit">
		</dd>

	</dl>
	<dl>
		<dt><label for="filecomment">File comment:</label></dt>
		<dd><textarea name="filecomment" id="filecomment" rows="1" cols="40" class="inputbox autowidth"></textarea></dd>
	</dl>
	</fieldset>

	<span class="corners-bottom"><span></span></span></div>

</div><h3 id="review">';
    print("</form>\n");

    forum_table_close();

	insert_quick_jump_menu();
}
//LASTEST FORUM POSTS
function latestforumposts() {
global $db,$db_prefix, $user,$theme;
print("<b>Latest Topics</b><br>");
print("<table align=center cellpadding=1 cellspacing=0 style='border-collapse: collapse' bordercolor=#646262 width=100% border=1 ><tr>".
"<td class = ftableback align=left  width=100%><b>Topic Title</b></td>". 
"<td class = ftableback align=center width=47><b>Replies</b></td>".
"<td class = ftableback align=center width=47><b>Views</b></td>".
"<td class = ftableback align=center width=85><b>Author</b></td>".
"<td class = ftableback align=right width=85><b>Last Post</b></td>".
"</tr>");


/// HERE GOES THE QUERY TO RETRIEVE DATA FROM THE DATABASE AND WE START LOOPING ///
$for = $db->sql_query("SELECT * FROM ".$db_prefix."_forum_topics ORDER BY lastpost DESC LIMIT 5");

while ($topicarr = $db->sql_fetchrow($for)) {
// Set minclass
$res = $db->sql_query("SELECT name,minclassread FROM ".$db_prefix."_forum_forums WHERE id=$topicarr[forumid]") or sqlerr();
$forum = $db->sql_fetchrow($res);

if ($forum["minclassread"] == '0' || in_array($user->group,explode("  ", $forum["minclassread"]))){
$forumname = "<a href=?action=viewforum&amp;forumid=$topicarr[forumid]><b>" . htmlspecialchars($forum["name"]) . "</b></a>";

$topicid = $topicarr["id"];
$topic_title = stripslashes($topicarr["subject"]);
$topic_userid = $topicarr["userid"];
// Topic Views
$views = $topicarr["views"];
// End

/// GETTING TOTAL NUMBER OF POSTS ///
$res = $db->sql_query("SELECT COUNT(*) FROM ".$db_prefix."_forum_posts WHERE topicid=$topicid") or sqlerr(__FILE__, __LINE__);
$arr = $db->sql_fetchrow($res);
$posts = $arr[0];
$replies = max(0, $posts - 1);

/// GETTING USERID AND DATE OF LAST POST ///   
$res = $db->sql_query("SELECT * FROM ".$db_prefix."_forum_posts WHERE topicid=$topicid ORDER BY id DESC LIMIT 1") or sqlerr(__FILE__, __LINE__);
$arr = $db->sql_fetchrow($res);
$postid = 0 + $arr["id"];
$userid = 0 + $arr["userid"];
$added = "<nobr>" . $arr["added"] . "</nobr>";

/// GET NAME OF LAST POSTER ///
$res = $db->sql_query("SELECT id, username FROM ".$db_prefix."_users WHERE id=$userid") or sqlerr(__FILE__, __LINE__);
if ($db->sql_numrows($res) == 1) {
$arr = $db->sql_fetchrow($res);
$username = "<a href=user.php?op=profile&id=$userid><font color=\"".getusercolor(getlevel_name($userid))."\">" . $arr['username'] . "</font></a>";
}
else
$username = "Unknown[$topic_userid]";

/// GET NAME OF THE AUTHOR ///
$res = $db->sql_query("SELECT username FROM ".$db_prefix."_users WHERE id=$topic_userid") or sqlerr(__FILE__, __LINE__);
if ($db->sql_numrows($res) == 1) {
$arr = $db->sql_fetchrow($res);
$author = "<a href=user.php?op=profile&id=$topic_userid><font color=\"".getusercolor(getlevel_name($topic_userid))."\">" . $arr['username'] . "</font></a>";
}
else
$author = "Unknown[$topic_userid]";

/// GETTING THE LAST INFO AND MAKE THE TABLE ROWS ///
$r = $db->sql_query("SELECT lastpostread FROM ".$db_prefix."_forum_readposts WHERE userid=$userid AND topicid=$topicid") or sqlerr(__FILE__, __LINE__);
$a = $db->sql_fetchrow($r);
$new = !$a || $postid > $a[0];
$subject = "<a href=forums.php?action=viewtopic&topicid=$topicid><b>" . encodehtml(stripslashes($topicarr["subject"])) . "</b></a>";

print("<tr class=alt1><td style='padding-right: 5px'>$subject</td>".
"<td class=alt2 align=center>$replies</td>" .
"<td class=alt1 align=center>$views</td>" .
"<td class=alt1 align=center>$author</td>" .
"<td class=alt2 align=center><nobr><small>$added<br />$username <a href=forums.php?action=viewtopic&topicid=$topicid&page=last#last><img src=\"./themes/$theme/forums/icon_topic_latest.gif\" alt=\"View the latest post\" title=\"View the latest post\" width=\"11\" height=\"8\"border=\"0\"></a></small></nobr></td>");

print("</tr>");
} // while
}
print("</table><br>");
} // end function
//define the clickable tags
function quickbb(){
global $db, $db_prefix;
	echo "<center><table border=0 width=125px cellpadding=0 cellspacing=2><tr>";
	echo "<tr>";
                       echo "<input type=\"radio\" name=\"mode\" id=\"radio_bbcodemode_1\" value=\"0\" title=\"normal Mode (alt+n)\" accesskey=\"n\" onclick=\"setmode(this.value)\" checked=\"checked\" /><label for=\"radio_bbcodemode_1\">Mode Normal</label><br />
                        <input type=\"radio\" name=\"mode\" id=\"radio_bbcodemode_2\" value=\"1\" title=\"enhanced Mode (alt+e)\" accesskey=\"e\" onclick=\"setmode(this.value)\"  /><label for=\"radio_bbcodemode_2\">Mode Expert</label><br />";
                echo "<br /><img src=\"images/bbcode/bbcode_bold.gif\" alt=Bold&nbsp;Text Text title=Bold&nbsp;Text Text border=0 onclick=bbcode(document.Form,'b','',Form.body) onmouseover=this.style.cursor='pointer'; >";
                echo "<img src=\"images/bbcode/bbcode_underline.gif\" alt=Underlined&nbsp;Text Text title=Underlined&nbsp;Text Text border=0 onclick=bbcode(document.Form,'u','',Form.body) onmouseover=this.style.cursor='pointer'; >";
                echo "<img src=\"images/bbcode/bbcode_italic.gif\" alt=Italic&nbsp;Text Text title=Italic&nbsp;Text Text border=0 onclick=bbcode(document.Form,'i','',Form.body) onmouseover=this.style.cursor='pointer';>";
                echo "<img src=\"images/bbcode/bbcode_quote.gif\" alt=Quote&nbsp;Text Text title=Quote&nbsp;Text Text border=0 onclick=bbcode(document.Form,'quote','',Form.body) onmouseover=this.style.cursor='pointer';>";
                echo "<img src=\"images/bbcode/bbcode_image.gif\" alt=Image&nbsp;Text Text title=Image&nbsp;Text Text border=0 onclick=bbcode(document.Form,'img','',Form.body) onmouseover=this.style.cursor='pointer';>";
                echo "<img src=\"images/bbcode/bbcode_url.gif\" alt=Link&nbsp;Text Text title=Link&nbsp;Text Text border=0 onclick=bbcode(document.Form,'url','',Form.body) onmouseover=this.style.cursor='pointer';>";

	echo "</tr></table>";
}
function quicktags(){
global $db, $db_prefix;
	echo "<center><table border=0 cellpadding=0 cellspacing=0><tr>";
			        $sql = "SELECT * FROM ".$db_prefix."_smiles WHERE id > '1' GROUP BY file ORDER BY id ASC LIMIT 14;";
        $smile_res = $db->sql_query($sql);
        if ($db->sql_numrows($smile_res) > 0) {
                $smile_rows = $db->sql_fetchrowset($smile_res);
                echo "<td><p>";
                foreach ($smile_rows as $smile) {
                        echo " <img src=\"smiles/".$smile["file"]."\" onclick=\"comment_smile('".$smile["code"]."',Form.body);\" border=\"0\" alt=\"".$smile["alt"]."\">\n";
                }
				echo "</p></td>";
				}
				
	echo "</tr></table></center>";
}
//Handle SQL Errors
function forumsqlerr($file = '', $line = '')//handle errors
{
global $db, $db_prefix;
$error = $db->sql_error();
  print("<table border=0 align=left cellspacing=0 cellpadding=10>" .
    "<tr><td class=embedded><font color=white><h1>SQL Error</h1>\n" .
  "<b>" . $error['message'] . ($file != '' && $line != '' ? "<p>in $file, line $line</p>" : "") . "</b></font></td></tr></table>");
  die;
}
?>