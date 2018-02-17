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

$error = ((!isset($gpl) OR $gpl != "yes" OR !isset($lgpl) OR $lgpl != "yes") AND !isset($postback));
$errors = Array("db_host"=>false,"db_host_msg"=>"","db_user"=>false,"db_user_msg"=>"","db_name"=>false,"upload_directory"=>false,"upload_directory"=>false);

if (!isset($db_type)) $db_type = "MySQL";
if (!isset($db_host)) $db_host = "localhost";
if (!isset($db_user)) $db_user = "root";
if (!isset($db_pass)) $db_pass = "";
if (!isset($db_name)) $db_name = "phpMyBitTorrent";
if (!isset($db_prefix)) $db_prefix = "torrent";
if (!isset($db_persistency)) $db_persistency = "false";
if (!isset($upload_directory)) $upload_directory = "torrent";
if (!isset($use_rsa)) $use_rsa = "false";
if (!isset($rsa_modulo)) $rsa_modulo = 0;
if (!isset($rsa_public)) $rsa_public = 0;
if (!isset($rsa_private)) $rsa_private = 0;

$showpanel = false;


//Configuration file prototype. Copyright Notice included ;)
$configproto = <<<EOF
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
*----------------------Tuesday, May 07, 2013 4:02 PM --------------------------*
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 configdata.php  2013-11-04 00:22:48 joeroberts $
* @copyright (c) 2014 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT'))die ("You can't include this file");
/* ---------------------------------
Database Configuration
You have to configure your database
connection here. Here is a quick
explanation:

db_type: your database type
    Possible options:
    MySQL
    MySQL4
	MySQLi
    Postgres
    MSSQL
    Oracle
    MSAccess
    MSSQL-ODBC
    DB2
db_host: host where database runs
db_port: not used
db_user: database user name
db_password: database password
db_name: database name on server
db_prefix: prefix for tables
persistency: connection persistency
--------------------------------- */
\$db_type = "$db_type";
\$db_host = "$db_host";
\$db_user = "$db_user";
\$db_pass = "$db_pass";
\$db_name = "$db_name";
\$db_prefix = "$db_prefix"; //Without "_"
\$db_persistency = $db_persistency;

/* ---------------------------------
RSA Engine configuration
Make sure you ran rsa_keygen BEFORE
configuring RSA. You NEED a VALID
key pair to enable RSA.
You can copy&paste rsa_keygen output
--------------------------------- */
\$use_rsa = $use_rsa;
\$rsa_modulo = $rsa_modulo;
\$rsa_public = $rsa_public;
\$rsa_private = $rsa_private;

/*----------------------------------
Torrent Upload Directory
You can change the default setting,
but remember that it MUST be writable
by httpd/IUSR_MACHINE user
----------------------------------*/
\$torrent_dir = "$upload_directory";
?>
EOF;
?>
<?php


if (isset($postback)) {
        switch ($db_type) {
                case "MySQL":
                case "MySQL4": {
                        $db = @mysql_connect($db_host,$db_user,$db_pass);
                        if (!$db) {
                                $myerr = mysql_errno();
                                if ($myerr > 2000 AND $myerr < 2100) { //Connection error
                                        $showpanel = true;
                                        $errors["db_host"] = true;
                                        $errors["db_host_msg"] = mysql_error();

                                } elseif($myerr == 1045 OR $myerr == 1251) { //Authentication error
                                        $showpanel = true;
                                        $errors["db_user"] = true;
                                        $errors["db_user_msg"] = mysql_error();
                                }
                                //echo "<p>".mysql_error()."<br />".mysql_errno()."</p>";
                                break;
                        }
                        if (!mysql_select_db($db_name,$db)) { //Can't access database
                                $showpanel = true;
                                $errors["db_name"] = true;
                                $errors["db_name_msg"] = mysql_error();
                                //echo "<p>".mysql_error()."<br />".mysql_errno()."</p>";
                                @mysql_close($db);
                                break;
                        }
                        @mysql_close($db);
                        break;
                }
                case "MySQLi": {
                        $db = @mysqli_connect($db_host,$db_user,$db_pass,$db_name);
                        if (!$db) {
                                $myerr = mysqli_errno();
                                if ($myerr > 2000 AND $myerr < 2100) { //Connection error
                                        $showpanel = true;
                                        $errors["db_host"] = true;
                                        $errors["db_host_msg"] = mysqli_error();

                                } elseif($myerr == 1045 OR $myerr == 1251) { //Authentication error
                                        $showpanel = true;
                                        $errors["db_user"] = true;
                                        $errors["db_user_msg"] = mysqli_error();
                                }
                                //echo "<p>".mysql_error()."<br />".mysql_errno()."</p>";
                                break;
                        }
                        if (!mysqli_select_db($db, $db_name)) { //Can't access database
                                $showpanel = true;
                                $errors["db_name"] = true;
                                $errors["db_name_msg"] = mysqli_error();
                                //echo "<p>".mysql_error()."<br />".mysql_errno()."</p>";
                                @mysqli_close($db);
                                break;
                        }
                        @mysqli_close($db);
                        break;
				}
        }
        if (!is_dir("../".$upload_directory)) {
                $showpanel = true;
                $errors["upload_directory"] = true;
                $errors["upload_directory_msg"] = _updirnoexist;
        } else {
                $fp = @fopen("../".$upload_directory."/testfile","w");
                if (!$fp) {
                        $showpanel = true;
                        $errors["upload_directory"] = true;
                        $errors["upload_directory_msg"] = _updirnowrite;
                } else {
                        if (!fputs($fp,"Test Write")) {
                                $showpanel = true;
                                $errors["upload_directory"] = true;
                                $errors["upload_directory_msg"] = _updirnowrite;
                        }
                }
                @unlink("../".$upload_directory."/testfile"); //Deleting the mess we just done
                @fclose($fp);
        }


} else $showpanel = true;



if ($error) {
        //Step back
        include("steps/2.php");
} elseif($showpanel) {
        //Proceed with step 3
        echo "<input type=\"hidden\" name=\"step\" value=\"3\" />\n";
        echo "<input type=\"hidden\" name=\"truestep\" value=\"3\" />\n"; //Used to display correct image


        echo "<p align=\"center\"><font size=\"5\">"._step3."</font></p>\n";

        echo "<p>&nbsp;</p>\n";
        echo "<p>"._step3explain."</p>\n";

        echo "<p>&nbsp;</p>\n";

        #Database Settings
        echo "<p><b>"._dbconfig."</b></p>\n";
        echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n";

        //DB Type
        echo "<tr><td width=\"30%\"><p>"._dbtype."</p></td><td width=\"70%\"><p><select size=\"1\" name=\"db_type\">";
        echo "<option value=\"MySQL\" "; if ($db_type == "MySQL") echo "selected"; echo ">MySQL >= 4.1</option>";
        echo "<option value=\"MySQL4\" "; if ($db_type == "MySQL4") echo "selected"; echo ">MySQL < 4.1</option>";
        echo "<option value=\"MySQLi\" "; if ($db_type == "MySQLi") echo "selected"; echo ">MySQLi</option>";
        echo "</select></p></td></tr>\n";

        //DB Host
        echo "<tr><td width=\"30%\"><p>"._dbhost."</p></td><td width=\"70%\"><p><input type=\"text\" name=\"db_host\" value=\"".$db_host."\" />";
        if ($errors["db_host"]) echo "<font class=\"err\"><br />"._dbhosterror."<br />".str_replace("**msg**",$errors["db_host_msg"],_serverreturned)."</font>";
        echo "</p></td></tr>\n";

        //DB User
        echo "<tr><td width=\"30%\"><p>"._dbuser."</p></td><td width=\"70%\"><p><input type=\"text\" name=\"db_user\" value=\"".$db_user."\" />";
        if ($errors["db_user"]) echo "<font class=\"err\"><br />"._dbusererror."<br />".str_replace("**msg**",$errors["db_user_msg"],_serverreturned)."</font>";
        echo "</p></td></tr>\n";

        //DB Pass
        echo "<tr><td width=\"30%\"><p>"._dbpass."</p></td><td width=\"70%\"><p><input type=\"text\" name=\"db_pass\" value=\"".$db_pass."\" /></p></td></tr>\n";

        //DB Name
        echo "<tr><td width=\"30%\"><p>"._dbname."</p></td><td width=\"70%\"><p><input type=\"text\" name=\"db_name\" value=\"".$db_name."\" />";
        if ($errors["db_name"]) echo "<font class=\"err\"><br />"._dbnameerror."<br />".str_replace("**msg**",$errors["db_name_msg"],_serverreturned)."</font>";
        echo "</p></td></tr>\n";

        //DB Prefix
        echo "<tr><td width=\"30%\"><p>"._dbprefix."</p></td><td width=\"70%\"><p><input type=\"text\" name=\"db_prefix\" value=\"".$db_prefix."\" /></p></td></tr>\n";

        //DB Persistency
        echo "<tr><td width=\"30%\"><p>"._dbpers."</p></td><td width=\"70%\"><p><input type=\"checkbox\" name=\"db_persistency\" value=\"true\" "; if ($db_persistency == "true") echo "checked"; echo "/></p></td></tr>\n";
        echo "</table>\n";

        echo "<p>&nbsp;</p>\n";

        #Upload Directory
        echo "<p><b>"._moresettings."</b></p>\n";
        echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n";
        echo "<tr><td width=\"30%\"><p>"._uploaddirectory."</p></td><td width=\"70%\"><p><input type=\"text\" name=\"upload_directory\" value=\"".$upload_directory."\" />";
        if ($errors["upload_directory"]) {
                echo "<br />";
                $currentfile = (array_key_exists("SCRIPT_FILENAME",$_SERVER)) ? stripslashes($_SERVER["SCRIPT_FILENAME"]) : stripslashes($_SERVER["PATH_TRANSLATED"]);
                $dirchar = ($os == "Windows") ? "\\" : "/";
                $setupdir = substr($currentfile,0,strrpos($currentfile,$dirchar));
                $pmbtdir = substr($currentfile,0,strrpos($currentfile,$dirchar));
                if ($os == "Windows") {
                        //cacls %path% /E /G IUSR_MACHINE:RWCF
                        $machinename = $_SERVER["COMPUTERNAME"];
                        $superuser = "Administrator";
                        $command = "cacls ".$pmbtdir."\\".$upload_directory." /E /G IUSR_".$machinename.":RWCF";
                } else {
                        $superuser = "root";
                        $command = "chmod -R 0666 ".$pmbtdir."/".$upload_directory;
                }
                //Determining the right command to make directory writable
                echo "<br /><b><font class=\"err\">";
                echo $errors["upload_directory_msg"];
                if ($errors["upload_directory_msg"] == _updirnoexist) { //The directory does not exist. Telling how to create one
                        echo "</font><br />";
                        echo "<font class=\"err\">"; //Just to respect HTML
                        echo str_replace(Array("**cmd**","**user**"),Array($command, $superuser),_permissioncmd);
                }
                echo "</font></b>";
        }
        echo "</p></td></tr>\n";
        echo "</table>\n";

        echo "<p>&nbsp;</p>\n";


        if (!$rsa_modulo OR !$rsa_public OR !$rsa_private) {
                require_once("include/rsa.php");
                list ($rsa_modulo, $rsa_public, $rsa_private) = generate_keys();
        }

        #RSA Configuration
        echo "<p><b>"._securecookies."</b></p>\n";
        echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n";
        echo "<tr><td width=\"30%\"><p>"._rsacookies."</p></td><td width=\"70%\"><p><input type=\"checkbox\" onClick=\"javascript:expand('rsa');\" name=\"use_rsa\" value=\"true\" "; if ($use_rsa == "true") echo "checked"; echo " /></p></td></tr>\n";
        $rsaclass =  ($use_rsa == "true") ? "visible" : "hide";
        echo "<tr id=\"rsa_1\" class=\"".$rsaclass."\"><td width=\"30%\"><p>"._rsamod."</p></td><td width=\"70%\"><p><input type=\"text\" readonly name=\"rsa_modulo\" value=\"".$rsa_modulo."\" /></p></td></tr>\n";
        echo "<tr id=\"rsa_2\" class=\"".$rsaclass."\"><td width=\"30%\"><p>"._pubkey."</p></td><td width=\"70%\"><p><input type=\"text\" readonly name=\"rsa_public\" value=\"".$rsa_public."\" /></p></td></tr>\n";
        echo "<tr id=\"rsa_3\" class=\"".$rsaclass."\"><td width=\"30%\"><p>"._privkey."</p></td><td width=\"70%\"><p><input type=\"text\" readonly name=\"rsa_private\" value=\"".$rsa_private."\" /></p></td></tr>\n";
        echo "</table>\n";

        echo "<p><input type=\"submit\" name=\"postback\" value=\""._nextstep."\" /></p>\n";
} else {
        echo "<p align=\"center\"><font size=\"5\">"._step3."</font></p>\n";
        //Get ready for step 4
        //Write to configuration file, else display to user
        echo "<input type=\"hidden\" name=\"step\" value=\"4\" />\n";
        @unlink("../include/configdata.php");
        $err = false;
        $fp = fopen("../include/configdata.php","w");
        if ($fp) {
                if (!fputs($fp,$configproto)) $err = true;
                fclose($fp);
        } else $err = true;
        if ($err) {
                echo "<p>"._cannotwriteconfig."</p>";
                echo "<p><textarea>".htmlspecialchars($configproto)."</textarea></p>";
        } else {

        }
        echo "<p>"._step3complete."</p>";
        echo "<p><input type=\"submit\" name=\"postback\" value=\""._nextstep."\" /></p>\n";
}

?>