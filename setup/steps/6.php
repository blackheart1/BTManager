<?php
/*
*----------------------------phpMyBitTorrent V 3.0.0---------------------------*
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
*------              ©2014 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-------------------Saturday, January 23, 2010 4:02 PM ------------------------*
*/
require_once("../include/configdata.php");
require_once("udl/database.php");


function is_email($email) {
        return preg_match("/^(([A-Za-z0-9]+_+)|([A-Za-z0-9]+\\-+)|([A-Za-z0-9]+\\.+)|([A-Za-z0-9]+\\++))*[A-Za-z0-9]+@((\\w+\\-+)|(\\w+\\.))*\\w{1,63}\\.[a-zA-Z]{2,6}$/",$email);
}

$db = new sql_db($db_host, $db_user, $db_pass, $db_name, $db_persistency);
$can_proceed = false;
$errors = Array("username" => false, "usernamelong" => false, "password" => false, "passwordconf" => false, "email" => false);
global $force_passkey;
if (!isset($postback)) {
        $username = $email = $fullname = "";
        $showpanel = true;
} else {

        $can_proceed = true;
        if (!isset($username) OR $username == "") {
                $username = "";
                $errors["username"] = true;
                $can_proceed = false;
        } elseif (strlen($username) > 25) {
                $username = substr($username,0,25);
                $errors["usernamelong"] = true;
                $can_proceed = false;
        }
        if (!isset($password) OR $password == "") {
                $errors["password"] = true;
                $can_proceed = false;
        }
        if (isset($password) AND $password != $passwordconf) {
                $errors["passwordconf"] = true;
                $can_proceed = false;
        }
        if (!isset($email) OR !is_email($email)) {
                $errors["email"] = true;
                $can_proceed = false;
        }
        if (!isset($fullname) OR $fullname == "") $fullname = "NULL";
        else $fullname = "'".addslashes($fullname)."'";
	if($force_passkey)
	{
		do
		{
			$passkey = ", '".RandomAlpha(32)."'";
			//Check whether passkey already exists
			$sql = "SELECT passkey FROM ".$db_prefix."_users WHERE passkey = '".$passkey."';";
			$res = $db->sql_query($sql);
			$cnt = $db->sql_numrows($sql);
			$db->sql_freeresult($res);
		} while ($cnt > 0);
			$passkeyrow = ', passkey';
	}
	else
	{
		$passkeyrow = NULL;
		$passkey = NULL;
	}
}
if (!$can_proceed) $showpanel = true;
else $showpanel = false;

if ($showpanel) {
        echo "<input type=\"hidden\" name=\"step\" value=\"6\" />\n";

        echo "<p align=\"center\"><font size=\"5\">"._step6."</font></p>\n";
        echo "<p>&nbsp;</p>\n";
        echo "<p>"._step6explain."</p>\n";
        echo "<p>&nbsp;</p>\n";

        //Show form
        echo "<table width=\"100%\">\n";

        //Username
        echo "<tr><td><p>"._username."</p></td><td><p><input type=\"text\" name=\"username\" value=\"".$username."\" size=\"40\" />";
        if ($errors["username"]) echo "<br />\n<font class=\"err\">"._usernamereq."</font>";
        elseif ($errors["usernamelong"]) echo "<br />\n<font class=\"err\">"._usernametoolong."</font>";
        echo "</p></td>";

        //Password
        echo "<tr><td><p>"._password."</p></td><td><p><input type=\"password\" name=\"password\" size=\"40\" />";
        if ($errors["password"]) echo "<br />\n<font class=\"err\">"._passwordreq."</font>";
        echo "</p></td>";

        //Confirm Password
        echo "<tr><td><p>"._passwordconf."</p></td><td><p><input type=\"password\" name=\"passwordconf\" size=\"40\" />";
        if ($errors["passwordconf"]) echo "<br />\n<font class=\"err\">"._passwordnomatch."</font>";
        echo"</p></td>";

        //Email
        echo "<tr><td><p>"._email."</p></td><td><p><input type=\"text\" name=\"email\" value=\"".$email."\" size=\"40\" />";
        if ($errors["email"]) echo "<br />\n<font class=\"err\">"._emailinvalid."</font>";
        echo"</p></td>";

        //Full Name
        echo "<tr><td><p>"._fullname."</p></td><td><p><input type=\"text\" name=\"fullname\" value=\"".$fullname."\" size=\"40\" /></p></td>";

        echo "</table>\n";

        echo "<p><input type=\"submit\" name=\"postback\" value=\""._nextstep."\" /></p>\n";
}

if ($can_proceed) {
        //Run Query
        //Full name has already been escaped
        //We don't care of the act_key field because it serves only as activation code
		$sql = "INSERT INTO `".$db_prefix."_user_group` (`group_id`, `user_id`, `group_leader`, `user_pending`) VALUES ('5', '1', '0', '0');";
		$db->sql_query($sql) or btsqlerror($sql);
        $sql = "INSERT INTO ".$db_prefix."_users (id, username, clean_username, password, email, name, uploaded, active".$passkeyrow.", act_key, level, can_do, user_rank, user_type, regdate) VALUES(1, '".addslashes($username)."','".addslashes(strtolower($username))."','".md5($password)."','".addslashes($email)."', ".$fullname.", '".$give_sign_up_credit."', 1".$passkey.",'".base64_encode(microtime())."', 'admin', '5', '1', '3', NOW());";
        if (!$db->sql_query($sql)) {
                //Error
                $err = $db->sql_error();
                echo "<p>";
                echo "<font class=\"err\">";
                echo _btsqlerror1.htmlspecialchars($sql);
                echo "<br />" ;
                echo _btsqlerror2.$err["code"];
                echo "<br />";
                echo _btsqlerror3.$err["message"];
                echo "</font></p>";
        } else {
                //Go ahead
                header("Location: index.php?step=7&language=".$language);
                die();
                echo "<p>"._step6complete."</p>";

                echo "<input type=\"hidden\" name=\"step\" value=\"7\" />\n";
                echo "<p><input type=\"submit\" value=\""._nextstep."\" /></p>\n";
        }

}

//$db->sql_query("",END_TRANSACTION);
$db->sql_close();
?>
