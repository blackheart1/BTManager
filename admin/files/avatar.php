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
** File avatar.php 2018-07-28 07:33:00 Thor
**
** CHANGES
**
** 2018-07-28 - Added Language to bterror()
**/

if (!defined('IN_PMBT'))
{
    include_once './../../security.php';
    die ("You can't access this file directly");
}

$user->set_lang('admin/acp_avatar',$user->ulanguage);

$cfgquery = "SELECT
        `enable_avatars` AS ALLOW_AVATARS,
        `enable_gallery_avatars` AS ALLOW_LOCAL,
        `enable_remote_avatars` AS ALLOW_REMOTE,
        `enable_avatar_uploading` AS ALLOW_UPLOAD,
        `enable_remote_avatar_uploading` AS ALLOW_REMOTE_UPLOAD,
        `maximum_avatar_file_size` AS MAX_FILESIZE,
        `avatar_storage_path` AS AVATAR_STORAGE_PATH,
        `avatar_gallery_path` AS AVATAR_GALLERY_PATH,
        `minimum_avatar_dimensions_ht` AS MIN_AVATAR_SIZE_A,
        `minimum_avatar_dimensions_wt` AS MIN_AVATAR_SIZE_B,
        `maximum_avatar_dimensions_ht` AS MAX_AVATAR_SIZE_A,
        `maximum_avatar_dimensions_wt` AS MAX_AVATAR_SIZE_B
    FROM " . $db_prefix . "_avatar_config;";

$cfgres = $db->sql_query($cfgquery)or die(mysql_error());
$cfgrow = $db->sql_fetchrow($cfgres);
//print_r($cfgrow);
$db->sql_freeresult($cfgres);

if (isset($do) && $do == "save")
{
    $ALLOW_AVATARS       = request_var('sub_ALLOW_AVATARS', '');
    $ALLOW_LOCAL         = request_var('sub_ALLOW_LOCAL', '');
    $ALLOW_REMOTE_UPLOAD = request_var('sub_ALLOW_REMOTE_UPLOAD', '');
    $ALLOW_UPLOAD        = request_var('sub_ALLOW_UPLOAD', '');
    $ALLOW_REMOTE        = request_var('sub_ALLOW_REMOTE', '');
    $MAX_FILESIZE        = request_var('sub_MAX_FILESIZE', '');
    $AVATAR_STORAGE_PATH = request_var('sub_AVATAR_STORAGE_PATH', '');
    $AVATAR_GALLERY_PATH = request_var('sub_AVATAR_GALLERY_PATH', '');
    $MIN_AVATAR_SIZE_A   = request_var('sub_MIN_AVATAR_SIZE_A', '');
    $MIN_AVATAR_SIZE_B   = request_var('sub_MIN_AVATAR_SIZE_B', '');
    $MAX_AVATAR_SIZE_A   = request_var('sub_MAX_AVATAR_SIZE_A', '');
    $MAX_AVATAR_SIZE_B   = request_var('sub_MAX_AVATAR_SIZE_B', '');

    $errors    = array();
    $sqlfields = array();
    $sqlvalues = array();

    if ($ALLOW_AVATARS != "")
    {
        $sqlfields[] = (($ALLOW_AVATARS == 'false')? "false" : "true");
        $sqlvalues[] = "enable_avatars";
    }
    else
       $errors[] = sprintf($user->lang["ERR_NOT_NUMERIC"], $user->lang["_admpALLOW_AVATARS"], $ALLOW_AVATARS);

    if ($ALLOW_LOCAL != "")
    {
        $sqlfields[] = (($ALLOW_LOCAL == 'false')? "false" : "true");
        $sqlvalues[] = "enable_gallery_avatars";
    }
    else
        $errors[] = sprintf($user->lang["ERR_NOT_NUMERIC"], $user->lang["_admpALLOW_LOCAL"], $ALLOW_LOCAL);

    if ($ALLOW_REMOTE != "")
    {
        $sqlfields[] = (($ALLOW_REMOTE == 'false')? "false" : "true");
        $sqlvalues[] = "enable_remote_avatars";
    }
    else
        $errors[] = sprintf($user->lang["ERR_NOT_NUMERIC"], $user->lang["_admpALLOW_REMOTE"], $ALLOW_REMOTE);

    if ($ALLOW_UPLOAD != "")
    {
        $sqlfields[] = (($ALLOW_UPLOAD == 'false')? "false" : "true");
        $sqlvalues[] = "enable_avatar_uploading";
    }
    else
        $errors[] = sprintf($user->lang["ERR_NOT_NUMERIC"], $user->lang["_admpALLOW_UPLOAD"], $ALLOW_UPLOAD);

    if ($ALLOW_REMOTE_UPLOAD != "")
    {
        $sqlfields[] = (($ALLOW_REMOTE_UPLOAD == 'false')? "false" : "true");
        $sqlvalues[] = "enable_remote_avatar_uploading";
    }
    else
        $errors[] = sprintf($user->lang["ERR_NOT_NUMERIC"], $user->lang["_admpALLOW_REMOTE_UPLOAD"], $ALLOW_UPLOAD);

    if (isset($MAX_FILESIZE) AND is_numeric($MAX_FILESIZE))
    {
        $sqlfields[] = $MAX_FILESIZE;
        $sqlvalues[] = "maximum_avatar_file_size";
    }
    else
        $errors[] = sprintf($user->lang["ERR_NOT_NUMERIC"], $user->lang["_admpMAX_FILESIZE"], $MAX_FILESIZE);

    if (isset($MIN_AVATAR_SIZE_B) AND is_numeric($MIN_AVATAR_SIZE_B))
    {
        $sqlfields[] = $MIN_AVATAR_SIZE_B;
        $sqlvalues[] = "minimum_avatar_dimensions_wt";
    }
    else
        $errors[] = sprintf($user->lang["ERR_NOT_NUMERIC"], $user->lang["_admpMIN_AVATAR_SIZE"], $MIN_AVATAR_SIZE_B);

    if (isset($MIN_AVATAR_SIZE_A) AND is_numeric($MIN_AVATAR_SIZE_A))
    {
        $sqlfields[] = $MIN_AVATAR_SIZE_A;
        $sqlvalues[] = "minimum_avatar_dimensions_ht";
    }
    else
        $errors[] = sprintf($user->lang["ERR_NOT_NUMERIC"], $user->lang["_admpMIN_AVATAR_SIZE"], $MIN_AVATAR_SIZE_A);

    if (isset($MAX_AVATAR_SIZE_B) AND is_numeric($MAX_AVATAR_SIZE_B))
    {
        $sqlfields[] = $MAX_AVATAR_SIZE_B;
        $sqlvalues[] = "maximum_avatar_dimensions_wt";
    }
    else
        $errors[] = sprintf($user->lang["ERR_NOT_NUMERIC"], $user->lang["_admpMAX_AVATAR_SIZE"], $MAX_AVATAR_SIZE_B);

    if (isset($MAX_AVATAR_SIZE_A) AND is_numeric($MAX_AVATAR_SIZE_A))
    {
        $sqlfields[] = $MAX_AVATAR_SIZE_A;
        $sqlvalues[] = "maximum_avatar_dimensions_ht";
    }
    else
         $errors[] = sprintf($user->lang["ERR_NOT_NUMERIC"], $user->lang["_admpMAX_AVATAR_SIZE"], $MAX_AVATAR_SIZE_A);

    if (!isset($AVATAR_STORAGE_PATH) OR $AVATAR_STORAGE_PATH == "" OR !is_dir($AVATAR_STORAGE_PATH))
    {
        $errors[] = sprintf($user->lang['NO_SUCH_DIR'], $AVATAR_STORAGE_PATH);
    }
    elseif (!is_writable($AVATAR_STORAGE_PATH))
    {
        $errors[] = sprintf($user->lang['DIR_NO_WRITE'], $AVATAR_STORAGE_PATH);
    }
    else
    {
        $sqlfields[] = $AVATAR_STORAGE_PATH;
        $sqlvalues[] = "avatar_storage_path";
    }

    if (!isset($AVATAR_GALLERY_PATH) OR $AVATAR_GALLERY_PATH == "" OR !is_dir($AVATAR_GALLERY_PATH))
    {
        $errors[] = sprintf($user->lang['NO_SUCH_DIR'], $AVATAR_GALLERY_PATH);
    }
    elseif (!is_readable($AVATAR_GALLERY_PATH)){
        $errors[] = sprintf($user->lang['DIR_NO_WRITE'], $AVATAR_GALLERY_PATH);
    }
    else
    {
        $sqlfields[] = $AVATAR_GALLERY_PATH;
        $sqlvalues[] = "avatar_gallery_path";
    }

    if (count($errors) > 0)
    {
        $report = '<ul>';

        foreach ($errors as $msg)
        {
            $report .= sprintf($user->lang['ERR_ARRAY_MESS'], $msg);
        }

        $report .= '</ul>';

        $template->assign_vars(array(
                'S_USER_NOTICE' => false,
                'S_FORWARD'     => false,
                'MESSAGE_TITLE' => $user->lang['SETTINGS_NOT_SAVED'],
                'MESSAGE_TEXT'  => $report . back_link($u_action),
        ));

        echo $template->fetch('admin/message_body.html');
        close_out();
    }
    else
    {
        $sql = "INSERT INTO " . $db_prefix . "_avatar_config (" . implode(", ",$sqlvalues) . ") VALUES ('" . implode("', '",$sqlfields) . "');";

        if (!$db->sql_query($sql)) btsqlerror($sql);

        $db->sql_query("TRUNCATE TABLE " . $db_prefix . "_avatar_config;");
        $db->sql_query($sql);
        $pmbt_cache->remove_file("sql_" . md5("avatar") . " . php");

        add_log('admin', 'LOG_CONFIG_AVATAR');

        $template->assign_vars(array(
                'S_USER_NOTICE' => true,
                'S_FORWARD'     => $u_action,
                'MESSAGE_TITLE' => $user->lang['SUCCESS'],
                'MESSAGE_TEXT'  => sprintf($user->lang['SITTINGS_SAVED'], $user->lang['AVATAR_SETTINGS']) . back_link($u_action),
        ));

        echo $template->fetch('admin/message_body.html');
        close_out();

    }
}

$hidden = build_hidden_fields(array(
        'do' => 'save',
        'i'  => 'userinfo',
        'op' => 'avatar',
));

$template->assign_vars(array(
        'L_TITLE'         => $user->lang['AVATAR_SETTINGS'],
        'L_TITLE_EXPLAIN' => $user->lang['AVATAR_SETTINGSexplain'],
        'U_ACTION'        => 'admin.php',
        'HIDEN' => $hidden,
));

drawRow("AVATAR_SETTINGS", "text", false, $user->lang["AVATAR_SETTINGS"]);
drawRow("ALLOW_AVATARS", "select", $user->lang["YES_NO_TF"]);
drawRow("ALLOW_LOCAL", "select", $user->lang["YES_NO_TF"]);
drawRow("ALLOW_REMOTE", "select", $user->lang["YES_NO_TF"]);
drawRow("ALLOW_UPLOAD", "select", $user->lang["YES_NO_TF"]);
drawRow("ALLOW_REMOTE_UPLOAD", "select", $user->lang["YES_NO_TF"]);
drawRow("MAX_FILESIZE", "text");
drawRow("MIN_AVATAR_SIZE", "text2");
drawRow("MAX_AVATAR_SIZE", "text2");
drawRow("AVATAR_STORAGE_PATH", "text");
drawRow("AVATAR_GALLERY_PATH", "text");

echo $template->fetch('admin/avatar.html');
close_out();

?>