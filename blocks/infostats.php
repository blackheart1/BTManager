<div class="myFrame">
<div class="myF-caption">Info</div>
<div class="myF-content">
  <table width="100%" cellspacing="0">

<tr valign="middle">
<td ><div id="nnNewest_Members">
<table width="100%" border="0" cellpadding="3"><tr>
<td width="25%" align="center">
<b>Avatar</b><br><br>
{U_AVATAR}<br>
</td>
<td width="25%" align="center">
Theme/Language<br><br>
<form id="acp_styles" type="hidden" method="post" action="#"><p><select id="template_file" name="theme_change" onchange="if (this.options[this.selectedIndex].value != '') this.form.submit();">
<option selected value="M-TV1">MTV1</option>
<option selected value="TVC1">TVC1</option>
<option selected value="NB-TT">NB-TT</option>
<option selected value="NB-H20">NB-H20</option>
<option selected value="NB-Dark">NB-Dark</option>
<option selected value="Bitfarm">Bitfarm</option>
<option selected value="NB-StN">NB-StN</option>
<option selected value="Jungle">Jungle</option>
<option selected value="NB-Christmas">NB-Christmas</option>
</select></p><p align="center"><b>Language</b></p>
<p><select id="language_file" name="language_change" onchange="if (this.options[this.selectedIndex].value != '') this.form.submit();"><option  value="spanish">Spanish</option>
<option  value="brazilian">Brazilian</option>
<option  value="german">German</option>
<option  value="help">Help</option>
<option  value="turkish">Turkish</option>
<option  value="tessw">Tessw</option>

<option  value="czech">Czech</option>
<option  value="greek">Greek</option>
<option  value="italian">Italian</option>
<option  value="french">French</option>
<option selected value="english">English</option>
</select></p> <input class="button2" type="submit" value="SELECT" ></form>
</td>

<td width="25%" align="center">
<b>Navigation</b><br><br>
Offers: <a href="offer.php">Here</a><br>
Videos: <a href="youtube.php">Here</a>&nbsp;<br>
Requests: <a href="viewrequests.php">Here</a><br>
My Torrents: <a href="mytorrents.php">Here</a><br>
Transfer Bonus: <a href="bonus_transfer.php">Here</a><br>
<!-- IF U_ADMIN -->MemberList: <a href="memberdlist.php">Admin View</a><!-- ENDIF -->

</td>

<td width="25%" align="center">
<b>Newest Members</b><br><br>
<div id="nnNewest_Members" class="row3">
<!-- BEGIN new_user_block -->
<a href="user.php?op=profile&amp;id={new_user_block.UID}"><font color="{new_user_block.COLOR}">{new_user_block.NAME}</font></a><br />
<!-- END new_user_block -->
</td>
</tr></table>
</div>
</td></tr>

</table>
</div>
			  </div>

