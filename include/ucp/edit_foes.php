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
** File edit_foes.php 2018-02-18 14:32:00 joeroberts
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
        # Add New Foe To Users Account
        if (isset($new_foe[0]) AND $new_foe[0] != ''){
              $new_foe = preg_split("/\\n[\\s]*/",$new_foe);
              foreach($new_foe as $s){
                   $res_foe = $db->sql_query("SELECT id FROM ".$db_prefix."_users WHERE username ='".escape($s)."' OR name = '".escape($s)."' OR clean_username = '".escape(strtolower($s))."';");
                   if (!$res_foe) echo "No Such user found";
                   $row_foe = $db->sql_fetchrow($res_foe);
                    $sql = "INSERT INTO ".$db_prefix."_private_messages_blacklist (master, slave) VALUES ('".$user->id."','".$row_foe['id']."');";
                    $db->sql_query($sql) or btsqlerror($sql);
                    $sql = "DELETE FROM ".$db_prefix."_private_messages_bookmarks WHERE master = '".$user->id."' AND slave = '".$row_foe['id']."';";
                    $db->sql_query($sql) or btsqlerror($sql);

              }
        }
        #Remove Foe From Users Account
        if (isset($remove_foe[0]) AND $remove_foe[0] != ''){
              foreach($remove_foe as $s){
                    if (isset($s) AND is_numeric($s)){
                    $sql = "DELETE FROM ".$db_prefix."_private_messages_blacklist WHERE master = '".$user->id."' AND slave = '".$s."';";
                    $db->sql_query($sql) or btsqlerror($sql);
    				}
              }
        }

?>