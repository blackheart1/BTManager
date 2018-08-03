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
** File client_ban.php 2018-07-28 07:49:00 Thor
**
** CHANGES
**
** 2018-07-28 - Code Cleanup
**/

if (!defined('IN_PMBT'))
{
    include_once './../../security.php';
    die ("You can't access this file directly");
}

$user->set_lang('admin/acp_clientban', $user->ulanguage);

$is_edit = false;

$banedit_client = Array("client" => "", "reason" => "");
        $postback_client = request_var('postback_client', '');
        $id              = request_var('id', 0);
        $do              = request_var('do', '');

switch($do)
{
    case "addclientban":
    {
        if ($postback_client)
        {   //Ban Client
            $ban_client    = request_var('ban_client', '');
            $reason_client = request_var('reason_client', '');

            $sql = "INSERT INTO " . $db_prefix . "_client_ban (client, reason, date) VALUES ('" . $db->sql_escape($ban_client) . "', '" . $db->sql_escape($reason_client) . "', NOW());";

            $db->sql_query($sql) or btsqlerror($sql);

            $template->assign_vars(array(
                    'S_MESSAGE'     => true,
                    'S_USER_NOTICE' => true,
                    'MESSAGE_TITLE' => $user->lang['SUCES_BAN'],
                    'MESSAGE_TEXT'  => sprintf($user->lang['SUCES_BAN_EXP'], $ban_client, $reason_client),
            ));
        }
        break;
    }

    case "editclientban":
    {
        if (!isset($id) OR !is_numeric($id)) break;

         if (!$postback_client)
         {
            $is_edit = true;

            $sql = "SELECT * FROM " . $db_prefix . "_client_ban WHERE id='" . $id . "' LIMIT 1;";

            $res = $db->sql_query($sql);

            if ($db->sql_numrows($res) < 1) $is_edit = false;
            else $banedit_client = $db->sql_fetchrow($res);

            $db->sql_freeresult($res);
        }
        elseif ($postback_client)
        {
            $ban_client    = request_var('ban_client', '');
            $reason_client = request_var('reason_client', '');

            if ($ban_client == '')
            { 
                bterror('NO_CLIENT_DEFINED','BT_ERROR', false);
                break;
            }

            $sql = "UPDATE " . $db_prefix . "_client_ban SET client = '" . $ban_client . "', reason = '" . $reason_client . "' WHERE id = '" . $id . "';";

            $db->sql_query($sql) or btsqlerror($sql);

            $template->assign_vars(array(
                    'S_MESSAGE'     => true,
                    'S_USER_NOTICE' => true,
                    'MESSAGE_TITLE' => $user->lang['SUCES_EDT'],
                    'MESSAGE_TEXT'  => sprintf($user->lang['SUCES_EDT_EXP'], $ban_client, $reason_client),
            ));
        }
        break;
    }

    case "delclientban":
    {
        if ($id)
        {
            if (!$id) break;

            if (confirm_box(true))
            {
                $db->sql_query("DELETE FROM " . $db_prefix . "_client_ban WHERE id = '" . $id . "';");

                $template->assign_vars(array(
                        'S_MESSAGE'     => true,
                        'S_USER_NOTICE' => true,
                        'MESSAGE_TITLE' => $user->lang['SUCES_DEL'],
                        'MESSAGE_TEXT'  => $user->lang['SUCES_DEL_EXP'],
                ));
            }
            else
            {
                confirm_box(false, $user->lang['CONFIRM_OPERATION'], build_hidden_fields(array(
                        'i'  => 'torrentinfo',
                        'op' => 'client_ban',
                        'do' => 'delclientban',
                        'id' => $id)), 'admin/confirm_body.html', $u_action
                    );
            }
        }
        break;
    }
}

$sql = "SELECT * FROM " . $db_prefix . "_client_ban;";
$res = $db->sql_query($sql);

if ($db->sql_numrows($res) < 1)
{
    $template->assign_vars(array(
            'S_BANNED' => false,
    ));

}
else
{
    $template->assign_vars(array(
            'S_BANNED' => true,
    ));

    while ($ban = $db->sql_fetchrow($res))
    {
        $template->assign_block_vars('clientbans', array(
                'CLIENT_BAN_NAME'   => $ban["client"],
                'CLIENT_BAN_REASON' => htmlspecialchars($ban["reason"]),
                'ID'                => $ban["id"],
        ));
    }
}

$db->sql_freeresult($res);

if (!$is_edit OR isset($id))
{
    if ($is_edit)
    {
        $hide = array(
                'op' => 'client_ban',
                'id' => $id,
                'i'  => 'torrentinfo',
                'do' => 'editclientban',
        );

    }
    else
    {
        $hide = array(
                'op' => 'client_ban',
                'i'  => 'torrentinfo',
                'do' => 'addclientban',
        );
    }
}

$template->assign_vars(array(
        'CLIENT_BAN_NAME'   => $banedit_client["client"],
        'CLIENT_BAN_REASON' => $banedit_client["reason"],
        'HIDDEN'            => build_hidden_fields($hide),
        'U_ACTION'          => './admin.php',
));

echo $template->fetch('admin/acp_clientban.html');
close_out();

?>