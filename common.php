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
** File common.php 2018-05-30 07:03:00 Thor
**
** CHANGES
**
** 2018-05-30- Updated DOCTYPE
**/

if (!defined('IN_PMBT'))
    die ("You can't Directly Access this File");

if (!ini_get('display_errors'))
{
    @ini_set('error_reporting', E_ALL);
    @ini_set('display_errors', 1);
}

require_once("include/errors.php");

$old_error_handler = set_error_handler("myErrorHandler");
$startpagetime = microtime();

if($_SERVER["PHP_SELF"] == '')$_SERVER["PHP_SELF"] = 'index.php';

if (!function_exists("sha1"))
    require_once("include/sha1lib.php");

require_once("include/config.php"); //if config file has not been loaded yet

set_include_path($sourcedir);
ini_set('include_path',$sourcedir);
date_default_timezone_set($pmbt_time_zone);

include_once('include/class.template.php');
require_once("include/actions.php");
require_once("include/user.functions.php");
include('include/auth.php');

if (is_banned($user, $reason) && !preg_match("/ban.php/",$_SERVER["PHP_SELF"]))
{
    echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
            <html xmlns="http://www.w3.org/1999/xhtml" dir="' . $user->lang['DIRECTION'] .'" lang="' .$user->lang['USER_LANG'] . '" xml:lang="' .$user->lang['USER_LANG'] . '" />
                <head>
                    <meta http-equiv="content-type" content="text/html; charset=' .$user->lang['CONTENT_ENCODING'] . '" />
                    <meta name="generator" content="BTManager ' . $version . '" />
                    <meta http-equiv="pragma" content="no-cache" />
                    <meta http-equiv="expires" content="-1" />
                    <meta http-equiv="cache-control" content="no-cache" />
                    <meta http-equiv="refresh" content="0; url=ban.php?reson='.urlencode($reason).'" />
                </head>
                <body>' . $user->lang['BANNED'] . '</body>
            </html>';
    die();
}

if (!preg_match("/cron.php/",$_SERVER['PHP_SELF']))
{
    $auth = new auth();
    $auth->acl($user);

    if ($pivate_mode AND !$user->user AND !newuserpage($_SERVER["PHP_SELF"]))
    {
        //die($_SERVER["PHP_SELF"]);
        $a = 0;
        $returnto = '';
        foreach ($_GET as $var=>$val)
        {
            $returnto .= "&$var=$val";
            $a++;
        }

        $i = strpos($returnto, "&return=");

        if ($i !== false)
        {
            $returnto = substr($returnto, $i + 8);
        }

        $pagename = substr($_SERVER["PHP_SELF"],strrpos($_SERVER["PHP_SELF"],"/")+1);
        $returnto ='?page=' . $pagename . $returnto;
        $template = new Template();
        set_site_var($user->lang['BT_ERROR']);
        meta_refresh(5, $siteurl . "/login.php$returnto");
        $template->assign_vars(array(
                                    'S_ERROR'   => true,
                                    'S_FORWARD' => $siteurl."/login.php$returnto",
                                    'TITTLE_M'  => $user->lang['BT_ERROR'],
                                    'MESSAGE'   => $user->lang['LOGIN_SITE'],
                                ));

        echo $template->fetch('message_body.html');
        close_out();
    }

    if($user->user  && !preg_match("/httperror.php/",$_SERVER['PHP_SELF']) && !preg_match("/file.php/",$_SERVER['PHP_SELF']) && !preg_match("/ajax.php/",$_SERVER['PHP_SELF']))
    {
        $ip = getip();
        $sql = "UPDATE ".$db_prefix."_users
                        SET lastip = '".sprintf("%u",ip2long($ip))."',
                        lastpage = '".addslashes(str_replace("/", '',substr($_SERVER['REQUEST_URI'],strrpos($_SERVER["REQUEST_URI"],"/")+1)))."',
                        lastlogin = NOW()
                        WHERE id = '".$user->id."'
                        LIMIT 1;";

        $db->sql_query($sql) or btsqlerror($sql);
    }
}
?>