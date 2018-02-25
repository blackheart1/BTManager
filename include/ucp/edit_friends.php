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
** File edit_friends.php 2018-02-18 14:32:00 joeroberts
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
        # Add New Friend To Users Account
        if (isset($new_friend[0]) AND $new_friend[0] != ''){
              $new_friend = preg_split("/\\n[\\s]*/",$new_friend);
              foreach($new_friend as $s){
                   $res_friend = $db->sql_query("SELECT id FROM ".$db_prefix."_users WHERE username ='".escape($s)."' OR name = '".escape($s)."' OR clean_username = '".escape(strtolower($s))."';");
                   if (!$res_friend) echo "No Such user found";
                   $row_friend = $db->sql_fetchrow($res_friend);
                   $sql = "INSERT INTO ".$db_prefix."_private_messages_bookmarks (master, slave) VALUES ('".$user->id."','".$row_friend['id']."');";
                   $db->sql_query($sql) or btsqlerror($sql);
                   $sql = "DELETE FROM ".$db_prefix."_private_messages_blacklist WHERE master = '".$user->id."' AND slave = '".$row_friend['id']."';";
                   $db->sql_query($sql) or btsqlerror($sql);
              }
        }
        #Remove Friend From Users Account
        if (isset($remove_friend[0]) AND $remove_friend[0] != ''){
              foreach($remove_friend as $s){
                    if (isset($s) AND is_numeric($s)){
                    $sql = "DELETE FROM ".$db_prefix."_private_messages_bookmarks WHERE master='".$user->id."' AND slave = '".$s."';";
                    $db->sql_query($sql) or btsqlerror($sql);
                    }
              }
        }

?>