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
** File levels.php 2018-07-28 08:27:00 Thor
**
** CHANGES
**
** 2018-05-10 - Added Languages Back In
** 2018-05-10 - Fixed Images
** 2018-05-10 - Added New Languages
** 2018-07-28 - Added Language to bterror()
**/

if (!defined('IN_PMBT'))
{
    include_once './../../security.php';
    die ("You can't access this file directly");
}

include_once 'include/class.bbcode.php';
include_once 'include/functions_forum.php';
include_once 'include/function_posting.php';
include_once 'include/user.functions.php';

$user->set_lang('admin/acp_levels', $user->ulanguage);

$start      = request_var('page', 0) * $config['topics_per_page'];
$page_title = $user->lang['ACP_GROUPS_MANAGE'];

$template->assign_vars(array(
        'PAGE_TITLE' => $page_title,
));

$form_key = 'acp_groups';

add_form_key($form_key);

$action = request_var('action', array('a' => ''));

if (!count($action))$action = (isset($_POST['add'])) ? 'add' : ((isset($_POST['addusers'])) ? 'addusers' : request_var('action', ''));

else $action = key($action);

if (!$auth->acl_get('a_group'))
{
    $template->assign_vars(array(
            'S_USER_NOTICE' => false,
            'S_FORWARD'     => false,
            'MESSAGE_TITLE' => $user->lang['GEN_ERROR'],
            'MESSAGE_TEXT'  => $user->lang['NO_AUTH_OPERATION'] . back_link($u_action),
        ));

    echo $template->fetch('admin/message_body.html');
    close_out();
}

$template->assign_block_vars('l_block1.l_block2', array(
        'L_TITLE'    => $user->lang['GROUPS'],
        'S_SELECTED' => true,
        'U_TITLE'    => '1',
));

$template->assign_block_vars('l_block1.l_block2.l_block3', array(
        'S_SELECTED' => ('manage_groups' == $action)? true : false,
        'IMG'        => '',
        'L_TITLE'    => $user->lang['MANAGE_GROUPS'],
        'U_TITLE'    => append_sid($u_action, 'action=manage_groups'),
));

$template->assign_block_vars('l_block1.l_block2.l_block3', array(
        'S_SELECTED' => ('group_prem' == $action)? true : false,
        'IMG'        => '',
        'L_TITLE'    => $user->lang['MANAGE_GROUP_PERM'],
        'U_TITLE'    => append_sid($u_action, 'action=group_prem'),
));

$template->assign_block_vars('l_block1.l_block2.l_block3', array(
        'S_SELECTED' => ('edit_site_prem' == $action)? true : false,
        'IMG'        => '',
        'L_TITLE'    => $user->lang['EDIT_GROUP_PERM'],
        'U_TITLE'    => append_sid($u_action, 'action=edit_site_prem'),
));

if ($auth->acl_get('a_roles'))
{
    $template->assign_block_vars('l_block1.l_block2', array(
            'L_TITLE'    => $user->lang['PERM_ROLES'],
            'S_SELECTED' => true,
            'U_TITLE'    => '1',
    ));

    if ($auth->acl_get('a_aauth'))
    {
        $template->assign_block_vars('l_block1.l_block2.l_block3', array(
                'S_SELECTED' => ('admin_roles' == $action)? true : false,
                'IMG'        => '',
                'L_TITLE'    => $user->lang['ADMIN_ROLES'],
                'U_TITLE'    => append_sid($u_action, 'action=admin_roles'),
        ));
    }

    if ($auth->acl_get('a_mauth'))
    {
        $template->assign_block_vars('l_block1.l_block2.l_block3', array(
                'S_SELECTED' => ('mod_roles' == $action)? true : false,
                'IMG'        => '',
                'L_TITLE'    => $user->lang['MOD_ROLES'],
                'U_TITLE'    => append_sid($u_action, 'action=mod_roles'),
        ));
    }

    if ($auth->acl_get('a_uauth'))
    {
        $template->assign_block_vars('l_block1.l_block2.l_block3', array(
                'S_SELECTED' => ('user_roles' == $action)? true : false,
                'IMG'        => '',
                'L_TITLE'    => $user->lang['USER_ROLES'],
                'U_TITLE'    => append_sid($u_action, 'action=user_roles'),
        ));
    }

    if ($auth->acl_get('a_fauth'))
    {
        $template->assign_block_vars('l_block1.l_block2.l_block3', array(
                'S_SELECTED' => ('forum_roles' == $action)? true : false,
                'IMG'        => '',
                'L_TITLE'    => $user->lang['FORUM_ROLES'],
                'U_TITLE'    => append_sid($u_action, 'action=forum_roles'),
        ));
    }
}

if ($auth->acl_get('a_authgroups'))
{
    $template->assign_block_vars('l_block1.l_block2', array(
            'L_TITLE'    => $user->lang['ASSIGN_ROLES'],
            'S_SELECTED' => true,
            'U_TITLE'    => '1',
    ));
}

if ($auth->acl_get('a_authgroups') && ($auth->acl_get('a_mauth') || $auth->acl_get('a_aauth')))
{
    $template->assign_block_vars('l_block1.l_block2.l_block3', array(
            'S_SELECTED' => ('setting_group_global' == $action)? true : false,
            'IMG'        => '',
            'L_TITLE'    => $user->lang['GLOBAL_GROUP_PERM'],
            'U_TITLE'    => append_sid($u_action, 'action=setting_group_global&amp;mode=setting_group_global'),
    ));
}

if ($auth->acl_get('a_authgroups') && ($auth->acl_get('a_mauth') || $auth->acl_get('a_fauth')))
{
    $template->assign_block_vars('l_block1.l_block2.l_block3', array(
            'S_SELECTED' => ('setting_group_local' == $action)? true : false,
            'IMG'        => '',
            'L_TITLE'    => $user->lang['GROUP_FORUM_PERM'],
            'U_TITLE'    => append_sid($u_action, 'action=setting_group_local&amp;mode=setting_group_local'),
    ));
}

// Check and Set some Common Vars
$group_id = request_var('g', '0');
$mark_ary = request_var('mark', array(0));
$name_ary = request_var('usernames', '', true);
$start    = ((request_var('page', 0)) ? (request_var('page', 0) - 1) : 0) * 15;
$update   = (isset($_POST['update'])) ? true : false;

// Clear some Vars
$can_upload = (file_exists($avstore) && is_writable($avstore) && $file_uploads) ? true : false;
$group_row  = array();

if ($group_id)
{
    $sql = 'SELECT *
            FROM ' . $db_prefix . "_level_settings
            WHERE group_id = $group_id";

    $result    = $db->sql_query($sql);
    $group_row = $db->sql_fetchrow($result);

    $db->sql_freeresult($result);

    if (!$group_row)
    {
        bterror($user->lang['NO_GROUP'] . back_link($u_action), $user->lang['GEN_ERROR']);
    }

    // Check if the User is Allowed to Manage this Group if Set to Founder Only.
    if ($user->data['user_type'] != 3 && $group_row['group_founder_manage'])
    {
        bterror($user->lang['NOT_ALLOWED_MANAGE_GROUP'] . back_link($u_action), $user->lang['GEN_ERROR']);
    }
}

switch ($action)
{
    case 'approve':
    case 'demote':
    case 'promote':

    if (!check_form_key($form_key))
    {
        trigger_error($user->lang['FORM_INVALID'] . back_link($u_action), E_USER_WARNING);
    }

    if (!$group_id)
    {
        trigger_error($user->lang['NO_GROUP'] . back_link($u_action), E_USER_WARNING);
    }

    // Approve, Demote or Promote
    $group_name = ($group_row['group_type'] == 3) ? $user->lang['G_' . $group_row['group_name']] : $group_row['group_name'];

    $error = group_user_attributes($action, $group_id, $mark_ary, false, $group_name);

    if (!$error)
    {
        switch ($action)
        {
            case 'demote':
                $message = 'GROUP_MODS_DEMOTED';
            break;

            case 'promote':
                $message = 'GROUP_MODS_PROMOTED';
            break;

            case 'approve':
                $message = 'USERS_APPROVED';
            break;
        }

        trigger_error($user->lang[$message] . back_link($u_action . '&amp;action=list&amp;g=' . $group_id));
    }
    else
    {
        trigger_error($user->lang[$error] . back_link($u_action . '&amp;action=list&amp;g=' . $group_id), E_USER_WARNING);
    }
    break;

    case 'default':
        if (!$group_id)
        {
            trigger_error($user->lang['NO_GROUP'] . back_link($u_action), E_USER_WARNING);
        }
        else if (empty($mark_ary))
        {
            trigger_error($user->lang['NO_USERS'] . back_link($u_action . '&amp;action=list&amp;g=' . $group_id), E_USER_WARNING);
        }

        if (confirm_box(true))
        {
            $group_name = ($group_row['group_type'] == 3) ? $user->lang['G_' . $group_row['group_name']] : $group_row['group_name'];

            group_user_attributes('default', $group_id, $mark_ary, false, $group_name, $group_row);

            trigger_error($user->lang['GROUP_DEFS_UPDATED'] . back_link($u_action . '&amp;action=list&amp;g=' . $group_id));
        }
        else
        {
            confirm_box(false, $user->lang['CONFIRM_OPERATION'], build_hidden_fields(array(
                    'mark'      => $mark_ary,
                    'ggroup_id' => $group_id,
                    'i'         => $i,
                    'mode'      => $mode,
                    'action'    => $action)), 'admin/confirm_body.html', $u_action
            );
        }
    break;

    case 'set_default_on_all':
        if (confirm_box(true))
        {
            $group_id   = request_var('g', '0');
            $group_name = ($group_row['group_type'] == 3) ? $user->lang['G_' . $group_row['group_name']] : $group_row['group_name'];
            $start = 0;

            do
            {
                $sql = 'SELECT user_id
                        FROM ' . $db_prefix . "_user_group
                        WHERE group_id = $group_id
                        ORDER BY user_id LIMIT " . $start . ',200';

                $result = $db->sql_query($sql);

                $mark_ary = array();

                if ($row = $db->sql_fetchrow($result))
                {
                    do
                    {
                        $mark_ary[] = $row['user_id'];
                    }
                    while ($row = $db->sql_fetchrow($result));

                    group_user_attributes('default', $group_id, $mark_ary, false, $group_name, $group_row);
                    $start = (sizeof($mark_ary) < 200) ? 0 : $start + 200;
                }
                else
                {
                    $start = 0;
                }
                $db->sql_freeresult($result);
            }
            while ($start);

            trigger_error($user->lang['GROUP_DEFS_UPDATED'] . back_link($u_action . '&amp;action=list&amp;g=' . $group_id));
        }
        else
        {
            confirm_box(false, $user->lang['CONFIRM_OPERATION'], build_hidden_fields(array(
                    'mark'   => $mark_ary,
                    'g'      => $group_id,
                    'i'      => $i,
                    'mode'   => $mode,
                    'action' => $action)), 'admin/confirm_body.html', $u_action
                );
        }
    break;

    case 'deleteusers':
        if (empty($mark_ary))
        {
            trigger_error($user->lang['NO_USERS'] . back_link($this->u_action . '&amp;action=list&amp;g=' . $group_id), E_USER_WARNING);
        }

        case 'delete':
            if (!$group_id)
            {
                bterror($user->lang['GEN_ERROR'], $user->lang['NO_GROUP'] . back_link($u_action));
            }
            else if ($action === 'delete' && $group_row['group_type'] == 3)
            {
                bterror($user->lang['GEN_ERROR'], $user->lang['NO_AUTH_OPERATION'] . back_link($u_action));
            }

            if (confirm_box(true))
            {
                switch ($action)
                {
                    case 'delete':
                        $error = '';

                        if (!$auth->acl_get('a_groupdel'))
                        {
                            bterror($user->lang['GEN_ERROR'], $user->lang['NO_AUTH_OPERATION'] . back_link($u_action));

                            $template->assign_vars(array(
                                    'S_USER_NOTICE' => false,
                                    'S_FORWARD'     => false,
                                    'MESSAGE_TITLE' => $user->lang['GEN_ERROR'],
                                    'MESSAGE_TEXT'  => $user->lang['NO_AUTH_OPERATION'] . back_link($u_action),
                            ));

                            echo $template->fetch('admin/message_body.html');
                            close_out();
                        }

                        $sql = 'SELECT COUNT(id) AS num
                                FROM `' . $db_prefix . '_users`
                                WHERE `can_do` = ' . $group_id;

                        $result = $db->sql_query($sql);
                        $row    = $db->sql_fetchrow($result);
                        $gn     = request_var('gn', '');
                        $gname  = request_var('gname', '');

                        if ($row[0] >= 1 && !$gn)
                        {
                            $hidden = build_hidden_fields(array(
                                    'g'           => $group_id,
                                    'i'           => $i,
                                    'mode'        => $mode,
                                    'user_id'     => $user->id,
                                    'confirm'     => 'Yes',
                                    'action'      => $action,
                                    'confirm_key' => '1',
                                    'sid'         => '',
                                    'gname'       => $gname,
                            ));

                            $template->assign_vars(array(
                                    'U_ACTION'              => $u_action,
                                    'U_BACK'                => $u_action,

                                    'L_GROUP_DELET_EXPLAIN' => sprintf($user->lang['GROUP_DELET_EXPLAIN'], $row[0], request_var('gname', '')),

                                    'S_HIDDEN_FIELDS'       => $hidden,
                                    'S_CONVERT_GROUP'       => true,
                                    'S_GROUP_OPTIONS'       => group_select_options_id(false, array($group_id), false), // Show All Groups
                            ));

                            echo $template->fetch('admin/acp_levels.html');
                            close_out();

                        }
                        else
                        {
                            $gn    = request_var('gn', '');
                            $gname = request_var('gname', '');

                            // Reset Users Group
                            $sql = 'UPDATE ' . $db_prefix . "_users
                                    SET `can_do` = '$gn'
                                    WHERE `can_do` = $group_id;";

                            $db->sql_query($sql);

                            // Delete Group
                            $sql = 'DELETE FROM ' . $db_prefix . "_levels
                                    WHERE group_id = $group_id";

                            $db->sql_query($sql);

                            // Delete Auth entries from the Groups Table
                            $sql = 'DELETE FROM ' . $db_prefix . "_level_settings
                                    WHERE group_id = $group_id";

                            $db->sql_query($sql);

                            // Delete Auth Entries from the Groups Table
                            $sql = 'DELETE FROM ' . $db_prefix . "_user_group
                                    WHERE group_id = $group_id";

                            $db->sql_query($sql);
                        }


                        add_log('admin','LOG_GROUP_DELETE', $gname);

                        $template->assign_vars(array(
                                'S_USER_NOTICE' => true,
                                'S_FORWARD'     => false,
                                'MESSAGE_TITLE' => $user->lang['SUCCESS'],
                                'MESSAGE_TEXT'  => $user->lang['GROUP_DELETED'] . back_link($u_action),
                        ));

                                echo $template->fetch('admin/message_body.html');
                                close_out();
                    break;

                    case 'deleteusers':
                        $group_id = request_var('g', '0');
                        //die(print_r($mark_ary));
                        $group_name = ($group_row['group_type'] == 3) ? $user->lang['G_' . $group_row['group_name']] : $group_row['group_name'];

                        $error = group_user_del($group_id, $mark_ary, false, $group_name);
                    break;
                }

                $back_link = ($action == 'delete') ? $u_action : $u_action . '&amp;action=list&amp;g=' . $group_id;

                if ($error)
                {
                    trigger_error($user->lang[$error] . back_link($back_link), E_USER_WARNING);
                }

                $message = ($action == 'delete') ? 'GROUP_DELETED' : 'GROUP_USERS_REMOVE';
                trigger_error($user->lang[$message] . back_link($back_link));
            }
            else
            {
                confirm_box(false, $user->lang['CONFIRM_OPERATION'], build_hidden_fields(array(
                        'mark'   => $mark_ary,
                        'g'      => $group_id,
                        'i'      => $i,
                        'gname'  => $group_row['group_name'],
                        'action' => $action)), 'admin/confirm_body.html', $u_action
                );
            }
        break;

        case 'admin_roles':
        case 'user_roles':
        case 'mod_roles':
        case 'forum_roles':

            require_once("include/auth.php");
            require_once("admin/files/acp_permission_roles.php");

            $action_a = (isset($_POST['add_role'])) ? 'add' : request_var('action_a', '');
            $auth     = new auth();

            $auth->acl($user);

            $admin_role           = new acp_permission_roles();
            $admin_role->u_action = '/admin.php?op=levels&i=userinfo&action=' . $action;

            $template->assign_vars(array(
                    'U_ACTION'                => '/admin.php?op=levels&i=userinfo&action=' . $action,
                    'ICON_MOVE_DOWN'          => $user->img('icon_down', 'MOVE_DOWN'),
                    'ICON_MOVE_DOWN_DISABLED' => $user->img('icon_down_disabled', 'MOVE_DOWN_DISABLED'),
                    'ICON_MOVE_UP'            => $user->img('icon_up', 'MOVE_UP'),
                    'ICON_MOVE_UP_DISABLED'   => $user->img('icon_up_disabled', 'MOVE_UP_DISABLED'),
                    'ICON_EDIT'               => $user->img('icon_edit', 'EDIT'),
                    'ICON_EDIT_DISABLED'      => $user->img('icon_edit_disabled', 'EDIT_DISABLED'),
                    'ICON_DELETE'             => $user->img('icon_delete', 'DELETE'),
                    'ICON_DELETE_DISABLED'    => $user->img('icon_delete_disabled', 'DELETE_DISABLED'),
            ));

            $admin_role->main('',$action);
            echo $template->fetch('admin/' . $admin_role->tpl_name . '.html');
            close_out();
        break;

        case 'setting_user_global':
        case 'setting_user_local':
        case 'setting_group_local':
        case 'setting_group_global':
        case 'setting_forum_local':
        case 'permissions':
        case 'delete_per':
        case 'apply_all_permissions':

            require_once("include/auth.php");
            require_once("admin/files/acp_permissions.php");

            $action_a = (isset($_POST['add_role'])) ? 'add' : request_var('action_a', '');
            $auth     = new auth();

            $auth->acl($user);

            $admin_role           = new acp_permissions();
            $admin_role->u_action = '/admin.php?op=levels&i=userinfo' . (($mode)? '&amp;mode=' . $mode : '') . '&action=' . $action;

            $template->assign_vars(array(
                    'U_ACTION'                => '/admin.php?op=levels&i=userinfo' . (($mode)? '&amp;mode=' . $mode : '') . '&action=' . $action,

                    'ICON_MOVE_DOWN'          => $user->img('icon_down', 'MOVE_DOWN'),
                    'ICON_MOVE_DOWN_DISABLED' => $user->img('icon_down_disabled', 'MOVE_DOWN_DISABLED'),
                    'ICON_MOVE_UP'            => $user->img('icon_up', 'MOVE_UP'),
                    'ICON_MOVE_UP_DISABLED'   => $user->img('icon_up_disabled', 'MOVE_UP_DISABLED'),
                    'ICON_EDIT'               => $user->img('icon_edit', 'EDIT'),
                    'ICON_EDIT_DISABLED'      => $user->img('icon_edit_disabled', 'EDIT_DISABLED'),
                    'ICON_DELETE'             => $user->img('icon_delete', 'DELETE'),
                    'ICON_DELETE_DISABLED'    => $user->img('icon_delete_disabled', 'DELETE_DISABLED'),
            ));

            $admin_role->main('',$mode);
            echo $template->fetch('admin/' . $admin_role->tpl_name . '.html');
            close_out();
        break;

        case 'edit_site_prem':
            $do = request_var('do', '');

            if ($do == 'edit_perm')
            {
                $take_edit = request_var('take_edit', '');

                if ($take_edit)
                {
                    $error = array();
                    unset($val);
                    $perm_id    = request_var('perm_id', 0);

                    if (!$perm_id)
                    {
                        $error[] = $user->lang['INVALED_PERM_ID'];
                    }
                    else
                    {
                        $sql = "SELECT * FROM
                                `" . $db_prefix . "_level_privlages`
                                WHERE id = " . $perm_id;

                        $result = $db->sql_query($sql);
                        $val    = $db->sql_fetchrow($result);
                    }

                    if (count($val['id'])<1)$error[] = $user->lang['INVALED_PERM_ID'];
                        $perm_tag   = request_var('perm_tag', '');

                    if (!$perm_tag == 'a' || !$perm_tag == 'm' || !$perm_tag == 'u')$error[] = $user->lang['INVALED_PERM_TAG'];

                        $perm_name  = request_var('perm_name', '');

                    if ($perm_name == '' || preg_match('/ /',$perm_name))
                    {
                        $error[] = $user->lang['INVALED_PERM_NAME'];
                    }
                    else
                    {
                        $perm_name     = "'" . $db->sql_escape(stripslashes($perm_tag . '_' . $perm_name)) . "'";
                        $old_perm_name = $db->sql_escape(stripslashes($val['acc_point']));
                    }

                    $perm_desc  = request_var('perm_desc', '');

                    if (!$perm_desc == '')
                    {
                        if ($user->lang['permission_type'][str_replace("'", "", $perm_name)] AND $user->lang['permission_type'][str_replace("'", "", $perm_name)] == $perm_desc)
                        {
                            $perm_desc  = 'NULL';
                        }
                        else
                        {
                            $perm_desc  = "'" . $db->sql_escape(stripslashes($perm_desc)) . "'";
                        }
                    }
                    else
                    {
                        $error[] = $user->lang['INVALED_PERM_DESC'];
                    }

                    if (count($error) > 0)
                    {
                        $template->assign_vars(array(
                                'S_USER_NOTICE' => false,
                                'S_FORWARD'     => false,
                                'MESSAGE_TITLE' => $user->lang['BT_ERROR'],
                                'MESSAGE_TEXT'  => implode("<br />", $error),
                        ));

                        echo $template->fetch('admin/message_body.html');
                        close_out();
                    }

                    //Update Changes
                    $sql = 'UPDATE `' . $db_prefix . '_level_privlages`
                            SET acc_point = ' . $perm_name . ', descr = ' . $perm_desc . '
                            WHERE id = ' . $perm_id . ' LIMIT 1;';

                    $db->sql_query($sql) OR btsqlerror($sql);

                    //Check to see if changes need to be made and do so if needed
                    if (!str_replace("'", "", $perm_name) == $old_perm_name)
                    {
                         $sql = "ALTER TABLE `" . $db_prefix . "_levels`
                                CHANGE `" . $old_perm_name . "` `" . str_replace("'","",$perm_name) . "`
                                ENUM(\'true\',\'false\')
                                CHARACTER SET utf8_bin
                                COLLATE utf8_bin
                                NOT NULL DEFAULT \'false\'";

                        $db->sql_query($sql) OR btsqlerror($sql);
                    }

                    $template->assign_vars(array(
                            'S_USER_NOTICE' => true,
                            'S_FORWARD'     => false,
                            'MESSAGE_TITLE' => $user->lang['SUCCESS'],
                            'MESSAGE_TEXT'  => $user->lang['PERMISSION_UPDATED'] . back_link($u_action . '&amp;action=edit_site_prem'),
                    ));

                    echo $template->fetch('admin/message_body.html');
                    close_out();
                }

                $id         = request_var('id', 0);
                $page_title =  'ACP_PERMISSIONS';

                $template->assign_vars(array(
                        'L_TITLE'            => $user->lang[$page_title],
                        'L_EXPLAIN'          => $user->lang[$page_title . '_EXPLAIN'],
                        'S_SITE_PERMISSIONS' => true,
                        'S_EDIT_PERMISSIONS' => true,
                ));

                if (!$id)
                {
                    $template->assign_vars(array(
                            'S_USER_NOTICE' => false,
                            'S_FORWARD'     => false,
                            'MESSAGE_TITLE' => $user->lang['BT_ERROR'],
                            'MESSAGE_TEXT'  => $user->lang['INVALED_PERM_ID'],
                    ));

                    echo $template->fetch('admin/message_body.html');
                    close_out();
                }

                $sql    = "SELECT * FROM `" . $db_prefix . "_level_privlages` WHERE id = '" . $id . "'";
                $result = $db->sql_query($sql)or btsqlerror($sql);
                $val    = $db->sql_fetchrow($result);

                if (preg_match('/^a_/',$val['acc_point']))$level = 'a';
                if (preg_match('/^m_/',$val['acc_point']))$level = 'm';
                if (preg_match('/^u_/',$val['acc_point']))$level = 'u';

                $hidden = build_hidden_fields(array(
                        'perm_id'   => $id,
                        'op'        => $op,
                        'take_edit' => 1,
                        'do'        => $do,
                        'i'         => $i,
                        'action'    => $action
                ));

                $template->assign_vars(array(
                        'PERM_NAME' => preg_replace('/^(a|u|m)_/', '', $val['acc_point']),
                        'PERM_TAG'  =>  $level,
                        'PERM_DESC' => (!$val['descr'] AND $user->lang['permission_type'][$val['acc_point']])? $user->lang['permission_type'][$val['acc_point']] : $val['descr'],
                        'HIDDEN'    =>  $hidden,
                ));
            }
            elseif ($do == 'delete_perm')
            {
                if ($auth->acl_get('a_groupdel'))
                {
                    if (confirm_box(true))
                    {
                        $group_id   = request_var('gid', 0);
                        $group_name = request_var('gname', '');

                        $sqla = 'DELETE FROM `' . $db_prefix . '_level_privlages` WHERE `torrent_level_privlages`.`id` = $group_id"';

                        $sqlb = 'ALTER TABLE `' . $db_prefix . '_levels` DROP `' . $group_name . '`;';

                        $db->sql_query($sqla);
                        $db->sql_query($sqlb);

                        add_log('admin','LOG_ACL_DEL_ACC_PERM_', $group_name);

                        $template->assign_vars(array(
                                'S_USER_NOTICE' => true,
                                'S_FORWARD'     => false,
                                'MESSAGE_TITLE' => $user->lang['SUCCESS'],
                                'MESSAGE_TEXT'  => $user->lang['AUTH_UPDATED'] . back_link('admin.php?op=levels&i=userinfo&action=edit_site_prem'),
                        ));

                        echo $template->fetch('admin/message_body.html');
                        close_out();
                    }
                    else
                    {
                        $group_id = request_var('id', 0);

                        $sql = "SELECT * FROM
                                `" . $db_prefix . "_level_privlages`
                                WHERE id = '" . $group_id . "'";

                        $result = $db->sql_query($sql);
                        $val    = $db->sql_fetchrow($result);

                        confirm_box(false, $user->lang['CONFIRM_OPERATION'], build_hidden_fields(array(
                                'gid'    => $group_id,
                                'gname'  => $val['acc_point'],
                                'do'     => 'delete_perm',
                                'action' => 'edit_site_prem')), 'admin/confirm_body.html', $u_action
                        );
                    }
                }
                else
                {
                    break;
                }
            }
            elseif ($do == 'new_perm')
            {
                if (!checkaccess("a_can_add_perm"))
                {
                    $template->assign_vars(array(
                            'S_USER_NOTICE' => false,
                            'S_FORWARD'     => false,
                            'MESSAGE_TITLE' => $user->lang['GEN_ERROR'],
                            'MESSAGE_TEXT'  => $user->lang['NO_AUTH_OPERATION'] . back_link($u_action),
                    ));

                    echo $template->fetch('admin/message_body.html');
                    close_out();
                }

                $page_title =  'ACP_PERMISSIONS';
                $perm_name  = request_var('perm_name', '');
                $take_add   = request_var('take_add', 0);

                if ($take_add)
                {
                    $perm_tag   = request_var('perm_tag', '');

                    if (!$perm_tag == 'a' || !$perm_tag == 'm' || !$perm_tag == 'u')$error[] = $user->lang['INVALED_PERM_TAG'];

                    $perm_name  = request_var('perm_name', '');

                    $sql = "SELECT * FROM
                            `" . $db_prefix . "_level_privlages`
                            WHERE acc_point = '" . $perm_name . "'";

                    $result = $db->sql_query($sql);
                    $val    = $db->sql_fetchrow($result);

                    if (count($val['id']) > 0)$error[] = $user->lang['ADD_PERM_ALREADY_PRESENT'] . $val['id'];

                    if ($perm_name == '' || preg_match('/ /',$perm_name))
                    {
                        $error[] = $user->lang['INVALED_PERM_NAME'];
                    }
                    else
                    {
                        $perm_name  = $db->sql_escape(stripslashes($perm_tag . '_' . $perm_name));
                    }

                    $perm_desc  = request_var('perm_desc', '');

                    if (!$perm_desc == '')
                    {
                        $perm_desc  = "'" . $db->sql_escape(stripslashes($perm_desc)) . "'";
                    }
                    else
                    {
                        $error[] = $user->lang['INVALED_PERM_DESC'];
                    }

                    if (count($error) > 0)
                    {
                        $template->assign_vars(array(
                                'S_USER_NOTICE' => false,
                                'S_FORWARD'     => false,
                                'MESSAGE_TITLE' => $user->lang['BT_ERROR'],
                                'MESSAGE_TEXT'  => implode("<br />", $error),
                        ));

                        echo $template->fetch('admin/message_body.html');
                        close_out();
                    }

                    $sql = 'INSERT INTO `' . $db_prefix . '_level_privlages` (`id`, `acc_point`, `descr`)
                            VALUES (NULL , \'' . $perm_name . '\', ' . $perm_desc . ');';

                    $db->sql_query($sql);

                    $sql = "ALTER TABLE `" . $db_prefix . "_levels`
                            ADD `" . $perm_name . "`
                            ENUM ('true', 'false')
                            NOT NULL
                            DEFAULT 'false';";

                    $db->sql_query($sql);

                    $template->assign_vars(array(
                            'S_USER_NOTICE' => true,
                            'S_FORWARD'     => false,
                            'MESSAGE_TITLE' => $user->lang['SUCCESS'],
                            'MESSAGE_TEXT'  => $user->lang['PERMISSION_ADDED'] . back_link($u_action . '&amp;action=edit_site_prem'),
                    ));

                    echo $template->fetch('admin/message_body.html');
                    close_out();
                }

                $hidden = build_hidden_fields(array(
                        'op'       => $op,
                        'take_add' => 1,
                        'do'       => $do,
                        'i'        => $i,
                        'action'   => $action
                ));

                $template->assign_vars(array(
                        'L_TITLE'            =>  $user->lang[$page_title],
                        'L_EXPLAIN'          =>  $user->lang[$page_title . '_EXPLAIN'],
                        'S_SITE_PERMISSIONS' =>  true,
                        'S_ADD_PERMISSIONS'  =>  true,
                        'PERM_NAME'          =>  $perm_name,
                        'HIDDEN'             =>  $hidden,
                ));

            }
            else
            {
                $page_title =  'ACP_PERMISSIONS';

                $template->assign_vars(array(
                        'L_TITLE'            => $user->lang[$page_title],
                        'L_EXPLAIN'          => $user->lang[$page_title . '_EXPLAIN'],
                        'S_SITE_PERMISSIONS' => true,
                ));

                $sql = "SELECT * FROM `" . $db_prefix . "_level_privlages`";

                $result = $db->sql_query("SELECT * FROM `" . $db_prefix . "_level_privlages`") OR btsqlerror($sql);

                while ($val = $db->sql_fetchrow($result))
                {
                    if (preg_match('/^a_/',$val['acc_point']))
                    {
                        $template->assign_block_vars('perms_a', array(
                                'PERM_EXP' => (!$val['descr'] AND $user->lang['permission_type'][$val['acc_point']])? $user->lang['permission_type'][$val['acc_point']] : $val['descr'],

                                'PERM_VAR' => preg_replace('/^a_/', '', $val['acc_point']),
                                'PERM_ID'  =>  $val['id'],
                        ));
                    }

                    if (preg_match('/^m_/',$val['acc_point']))
                    {
                        $template->assign_block_vars('perms_m', array(
                                'PERM_EXP' => (!$val['descr'] AND $user->lang['permission_type'][$val['acc_point']])? $user->lang['permission_type'][$val['acc_point']] : $val['descr'],

                                'PERM_VAR' => preg_replace('/^m_/', '', $val['acc_point']),
                                'PERM_ID'  =>  $val['id'],
                        ));
                    }

                    if (preg_match('/^u_/',$val['acc_point']) OR preg_match('/^f_/',$val['acc_point']))
                    {
                        $template->assign_block_vars('perms_u', array(
                                'PERM_EXP' => (!$val['descr'] AND $user->lang['permission_type'][$val['acc_point']])? $user->lang['permission_type'][$val['acc_point']] : $val['descr'],

                                'PERM_VAR' => preg_replace('/^u_/', '', $val['acc_point']),
                                'PERM_ID'  =>  $val['id'],
                        ));
                    }
                }
        }
        break;

        case 'group_prem':
            $do = request_var('do', '');

            if (!$group_id)
            {
                $page_title =  'ACP_GROUPS_PERMISSIONS';

                $template->assign_vars(array(
                        'U_ACTION'        => append_sid($u_action, 'action=group_prem'),
                        'S_SELECT_GROUP'  => true,
                        'S_GROUP_OPTIONS' => group_select_options_id(false, false, false), // Show All Groups
                ));
            }
            else if (!$do=='take_edit')
            {
                $sql = "SELECT * FROM `" . $db_prefix . "_level_privlages`";
                $row = $db->sql_query($sql);

                while($val = $db->sql_fetchrow($row))
                {
                    if ($val['descr'])$user->lang['permission_type'][$val['acc_point']] = $val['descr'];
                }

                $sql = 'SELECT *
                        FROM ' . $db_prefix . '_levels
                        WHERE group_id = ' . $group_id;

                $result = $db->sql_query($sql);
                $row    = $db->sql_fetchrow($result);

                foreach ($row as $var => $val)
                {
                    if (!is_numeric($var) AND ($val == 'true' || $val == 'false'))
                    {
                        if (checkaccess($var))
                        {
                            if (preg_match('/^a_/',$var))
                            {
                                $template->assign_block_vars('perms_a', array(
                                        'PERM_TITLE' => ($user->lang['permission_type'][$var])? $user->lang['permission_type'][$var] : $var,

                                        'PERM_VAR'   => $var,
                                        'VAL_YES'    => ($val == 'true')? true : false,
                                        'VAL_NO'     => ($val == 'false')? true : false,
                                ));
                            }

                            if (preg_match('/^m_/',$var))
                            {
                                $template->assign_block_vars('perms_m', array(
                                        'PERM_TITLE' => ($user->lang['permission_type'][$var])? $user->lang['permission_type'][$var] : $var,

                                        'PERM_VAR'   => $var,
                                        'VAL_YES'    => ($val == 'true')? true : false,
                                        'VAL_NO'     => ($val == 'false')? true : false,
                                ));
                            }

                            if (preg_match('/^u_/',$var) OR preg_match('/^f_/',$var))
                            {
                                $template->assign_block_vars('perms_u', array(
                                        'PERM_TITLE' => ($user->lang['permission_type'][$var])? $user->lang['permission_type'][$var] : $var,

                                        'PERM_VAR'   => $var,
                                        'VAL_YES'    => ($val == 'true')? true : false,
                                        'VAL_NO'     => ($val == 'false')? true : false,
                                ));
                            }
                        }
                    }
                }

                $s_hidden_fields = array(
                        'gt' => $row['name'],
                        'do' => 'take_edit',
                        'g'  => $group_id,
                );

                $s_hidden_fields = build_hidden_fields($s_hidden_fields);

                $template->assign_vars(array(
                        'GROUP_ID'        => $group_id,
                        'U_ACTION'        => append_sid($u_action, 'action=group_prem'),
                        'GROUP_TITLE'     => $row['name'],
                        'S_HIDDEN_FIELDS' => $s_hidden_fields,
                ));
            }
            else
            {
                $gt = request_var('gt', '');
                $auth_settings = array_map('intval', $_POST['perm_set'][$group_id][0]);

                foreach($auth_settings as $var => $val)
                {
                    if ($val == 1)$auth_settings[$var] = 'true';
                    else
                        $auth_settings[$var] = 'false';
                }

                $sql = 'UPDATE ' . $db_prefix . '_levels SET ' . $db->sql_build_array('UPDATE', $auth_settings)  . "WHERE group_id = {$group_id}";

                $db->sql_query($sql);

                add_log('admin','LOG_GROUP_UPDATED', $gt);

                $template->assign_vars(array(
                        'S_USER_NOTICE' => true,
                        'S_FORWARD'     => false,
                        'MESSAGE_TITLE' => $user->lang['SUCCESS'],
                        'MESSAGE_TEXT'  => $user->lang['AUTH_UPDATED'] . back_link($u_action),
                ));

                echo $template->fetch('admin/message_body.html');
                close_out();
            }

            $template->assign_vars(array(
                    'L_TITLE'       => $user->lang[$page_title],
                    'L_EXPLAIN'     => $user->lang[$page_title . '_EXPLAIN'],
                    'S_PERMISSIONS' => true,
            ));
            echo $template->fetch('admin/acp_levels.html');
            close_out();
        break;

        case 'addusers':
            if (!check_form_key($form_key))
            {
                trigger_error($user->lang['FORM_INVALID'] . back_link($u_action), E_USER_WARNING);
            }

            if (!$group_id)
            {
                trigger_error($user->lang['NO_GROUP'] . back_link($u_action), E_USER_WARNING);
            }

            if (!$name_ary)
            {
                trigger_error($user->lang['NO_USERS'] . back_link($u_action . '&amp;action=list&amp;g=' . $group_id), E_USER_WARNING);
            }

            $name_ary   = array_unique(explode("\n", $name_ary));
            $group_name = ($group_row['group_type'] == 3) ? $user->lang['G_' . $group_row['group_name']] : $group_row['group_name'];
            //die(print_r($name_ary));

            // Add User/s to Group
            if ($error = group_user_add($group_id, false, $name_ary, $group_name, $default, $leader, 0, $group_row))
            {
                trigger_error($user->lang[$error] . back_link($u_action . '&amp;action=list&amp;g=' . $group_id), E_USER_WARNING);
            }

            $message = ($leader) ? 'GROUP_MODS_ADDED' : 'GROUP_USERS_ADDED';
            trigger_error($user->lang[$message] . back_link($u_action . '&amp;action=list&amp;g=' . $group_id));
        break;

        case 'list':
            if (!$group_id)
            {
                trigger_error($user->lang['NO_GROUP'] . back_link($u_action), E_USER_WARNING);
            }

            //$this->page_title = 'GROUP_MEMBERS';

            // Grab the Leaders - always, on every page...
            $sql = 'SELECT u.id, u.username, u.clean_username, u.regdate, u.user_colour, u.user_posts, u.can_do, ug.group_leader, ug.user_pending
                    FROM ' . $db_prefix . '_users u, ' . $db_prefix . "_user_group ug
                    WHERE ug.group_id = $group_id
                    AND u.id = ug.user_id
                    AND ug.group_leader = 1
                    ORDER BY ug.group_leader DESC, ug.user_pending ASC, u.clean_username";
            //die($sql);

            $result = $db->sql_query($sql) OR mysql_error();

            while ($row = $db->sql_fetchrow($result))
            {
                $template->assign_block_vars('leader', array(
                        'U_USER_EDIT'     => append_sid("{$phpbb_admin_path}admin.$phpEx", "op=user&i=userinfo&mode=overview&vas=overview&u={$row['id']}"),

                        'USERNAME'        => $row['username'],
                        'USERNAME_COLOUR' => $row['user_colour'],
                        'S_GROUP_DEFAULT' => ($row['can_do'] == $group_id) ? true : false,
                        'JOINED'          => ($row['regdate']) ? $user->format_date(sql_timestamp_to_unix_timestamp($row['regdate'])) : ' - ',

                        'USER_POSTS'      => $row['user_posts'],
                        'USER_ID'         => $row['id'],
                ));
            }

            $db->sql_freeresult($result);

            // Total Number of Group Members (Non-Leaders)
            $sql = 'SELECT COUNT(user_id) AS total_members
                    FROM ' . $db_prefix . "_user_group
                    WHERE group_id = $group_id
                    AND group_leader = 0";

            $result        = $db->sql_query($sql);
            $total_members = (int) $db->sql_fetchfield('total_members');

            $db->sql_freeresult($result);

            $s_action_options = '';

            $options = array(
                    'default' => 'DEFAULT',
                    'approve' => 'APPROVE',
                    'demote' => 'DEMOTE',
                    'promote' => 'PROMOTE',
                    'deleteusers' => 'DELETE');

            foreach ($options as $option => $lang)
            {
                $s_action_options .= '<option value="' . $option . '">' . $user->lang['GROUP_' . $lang] . '</option>';
            }

            $template->assign_vars(array(
                    'S_LIST'           => true,
                    'S_GROUP_SPECIAL'  => ($group_row['group_type'] == 3) ? true : false,
                    'S_ACTION_OPTIONS' => $s_action_options,

                    'S_ON_PAGE'        => on_page($total_members, $config['topics_per_page'], $start),
                    'PAGINATION'       => generate_pagination($u_action . "&amp;action=$action&amp;g=$group_id", $total_members, $config['topics_per_page'], $start, true),

                    'GROUP_NAME'       => ($group_row['group_type'] == 3) ? $user->lang['G_' . $group_row['group_name']] : $group_row['group_name'],

                    'U_ACTION_LIST'    => $u_action . "&amp;action=$action&amp;g=$group_id",
                    'U_BACK'           => $u_action,

                    'U_FIND_USERNAME'  => append_sid("{$phpbb_root_path}userfind_to_pm.$phpEx", 'mode=searchuser&amp;form=list&amp;field=usernames'),

                    'U_DEFAULT_ALL'    => "{$u_action}&amp;action=set_default_on_all&amp;g=$group_id",
            ));

            // Grab the Members
            $sql = 'SELECT u.id, u.username, u.clean_username, u.user_colour, MICROSECOND(u.regdate), u.user_posts, u.can_do, ug.group_leader, ug.user_pending
                    FROM ' . $db_prefix . '_users u, ' . $db_prefix . "_user_group ug
                    WHERE ug.group_id = $group_id
                    AND u.id = ug.user_id
                    AND ug.group_leader = 0
                    ORDER BY ug.group_leader DESC, ug.user_pending ASC, u.clean_username
                    LIMIT " . $start . "," . $config['topics_per_page'];
            //die($sql);

            $result = $db->sql_query($sql) OR mysql_error();

            $pending = false;

            while ($row = $db->sql_fetchrow($result))
            {
                if ($row['user_pending'] && !$pending)
                {
                    $template->assign_block_vars('member', array(
                            'S_PENDING' => true)
                    );

                    $pending = true;
                }

                $template->assign_block_vars('member', array(
                        'U_USER_EDIT'     => append_sid("{$phpbb_admin_path}admin.$phpEx", "op=user&i=userinfo&mode=overview&vas=overview&u={$row['id']}"),

                        'USERNAME'        => $row['username'],
                        'USERNAME_COLOUR' => $row['user_colour'],
                        'S_GROUP_DEFAULT' => ($row['can_do'] == $group_id) ? true : false,
                        'JOINED'          => ($row['regdate']) ? $user->format_date($row['regdate']) : ' - ',
                        'USER_POSTS'      => $row['user_posts'],
                        'USER_ID'         => $row['id'])
                );
            }

            $db->sql_freeresult($result);

            //return;
        break;

        case 'edit':
        case 'add':
            $data = $submit_ary = array();

            if ($action == 'edit' && !$group_id)
            {
                $template->assign_vars(array(
                        'S_USER_NOTICE' => false,
                        'S_FORWARD'     => false,
                        'MESSAGE_TITLE' => $user->lang['GEN_ERROR'],
                        'MESSAGE_TEXT'  => $user->lang['NO_GROUP'] . back_link($u_action),
                ));

                echo $template->fetch('admin/message_body.html');
                close_out();
            }

            if ($action == 'add' && !checkaccess("a_edit_level"))
            {
                add_log('admin','LOG_ACL_ACCESS_NOTALLOW', $user->lang['ACP_GROUPS_MANAGE']);

                $template->assign_vars(array(
                        'S_USER_NOTICE' => false,
                        'S_FORWARD'     => false,
                        'MESSAGE_TITLE' => $user->lang['GEN_ERROR'],
                        'MESSAGE_TEXT'  => $user->lang['NO_AUTH_OPERATION'] . back_link($u_action),
                ));

                echo $template->fetch('admin/message_body.html');
                close_out();
            }

            $error = array();

            $avatar_select = basename(request_var('avatar_select', ''));
            $category      = basename(request_var('category', ''));

            // Did we Submit?
            if ($update)
            {
                if (!check_form_key($form_key))
                {
                    $template->assign_vars(array(
                            'S_USER_NOTICE' => false,
                            'S_FORWARD'     => false,
                            'MESSAGE_TITLE' => $user->lang['GEN_ERROR'],
                            'MESSAGE_TEXT'  => $user->lang['FORM_INVALID'] . back_link($u_action),
                    ));

                    echo $template->fetch('admin/message_body.html');
                    close_out();
                }

                $group_name         = request_var('group_name', '', true);
                $group_desc         = request_var('group_desc', '', true);
                $group_type         = request_var('group_type', 4);
                $allow_desc_bbcode  = request_var('desc_parse_bbcode', false);
                $allow_desc_urls    = request_var('desc_parse_urls', false);
                $allow_desc_smilies = request_var('desc_parse_smilies', false);
                $data['uploadurl']  = request_var('uploadurl', '');
                $data['remotelink'] = request_var('remotelink', '');
                $data['width']      = request_var('width', '');
                $data['height']     = request_var('height', '');
                $delete             = request_var('delete', '');

                $submit_ary = array(
                        'colour'         => request_var('group_colour', ''),
                        'rank'           => request_var('group_rank', 0),
                        'receive_pm'     => isset($_REQUEST['group_receive_pm']) ? 1 : 0,
                        'legend'         => isset($_REQUEST['group_legend']) ? 1 : 0,
                        'message_limit'  => request_var('group_message_limit', 0),
                        'max_recipients' => request_var('group_max_recipients', 0),
                        'founder_manage' => 0,
                        'skip_auth'      => request_var('group_skip_auth', 0),
                );

                if ($user->admin)
                {
                    $submit_ary['founder_manage'] = isset($_REQUEST['group_founder_manage']) ? 1 : 0;
                }

                if (!empty($_FILES['uploadfile']['tmp_name']) || $data['uploadurl'] || $data['remotelink'])
                {
                    // Avatar Stuff
                    $var_ary = array(
                            'uploadurl'  => array('string', true, 5, 255),
                            'remotelink' => array('string', true, 5, 255),
                            'width'      => array('string', true, 1, 3),
                            'height'     => array('string', true, 1, 3),
                    );

                    if (!($error = validate_data($data, $var_ary)))
                    {
                        $data['id']          = "g$group_id";
                        $data['upload_dir']  = $avgal;
                        $data['upload_name'] = "g_" . time();

                        if ((!empty($_FILES['uploadfile']['tmp_name']) || $data['uploadurl']) && $can_upload)
                        {
                            list($submit_ary['avatar_type'], $submit_ary['avatar'], $submit_ary['avatar_width'], $submit_ary['avatar_height']) = avatar_upload($data, $error);
                        }
                        else if ($data['remotelink'])
                        {
                            list($submit_ary['avatar_type'], $submit_ary['avatar'], $submit_ary['avatar_width'], $submit_ary['avatar_height']) = avatar_remote($data, $error);
                        }
                    }
                }
                else if ($avatar_select && $avgalon)
                {
                    // Check Avatar Gallery
                    if (is_dir('./' . $avgal . '/' . $category))
                    {
                        $submit_ary['avatar_type'] = 3;

                        list($submit_ary['avatar_width'], $submit_ary['avatar_height']) = getimagesize('./' . $avgal . '/' . $category . '/' . $avatar_select);

                        $submit_ary['avatar'] = $category . '/' . $avatar_select;
                    }
                }
                else if ($delete)
                {
                    $submit_ary['avatar']      = '';
                    $submit_ary['avatar_type'] = $submit_ary['avatar_width'] = $submit_ary['avatar_height'] = 0;
                }
                else if ($data['width'] && $data['height'])
                {
                    // Only Update the Dimensions?
                    if ($avmaxwt || $avmaxht)
                    {
                        if ($data['width'] > $avmaxwt || $data['height'] > $avmaxht)
                        {
                            $error[] = sprintf($user->lang['AVATAR_WRONG_SIZE'], $avminwt, $avminht, $avmaxwt, $avmaxht, $data['width'], $data['height']);
                        }
                    }

                    if (!sizeof($error))
                    {
                        if ($avminwt || $avminht)
                        {
                            if ($data['width'] < $avminwt || $data['height'] < $avminht)
                            {
                                $error[] = sprintf($user->lang['AVATAR_WRONG_SIZE'], $avminwt, $avminht, $avmaxwt, $avmaxht, $data['width'], $data['height']);
                            }
                        }
                    }

                    if (!sizeof($error))
                    {
                        $submit_ary['avatar_width']  = $data['width'];
                        $submit_ary['avatar_height'] = $data['height'];
                    }
                }

                if ((isset($submit_ary['avatar']) && $submit_ary['avatar'] && (!isset($group_row['group_avatar']))) || $delete)
                {
                    if (isset($group_row['group_avatar']) && $group_row['group_avatar'])
                    {
                        $sql = 'UPDATE ' . $db_prefix . "_users
                                SET avatar = 'blank.gif',
                                user_avatar_type = 0,
                                avatar_ht = 0,
                                avatar_wt = 0
                                WHERE user_avatar = '" . $db->sql_escape($group_row['group_avatar']) . '\'';

                        $db->sql_query($sql);

                        if (file_exists('./' . $group_row['group_avatar']))
                        {
                            @unlink('./' . $group_row['group_avatar']);
                        }
                    }
                }

                // Validate the Length of "Maximum Number of Allowed Recipients Per Private Message" Setting.
                // We use 16777215 as a Maximum because it Matches MySQL Unsigned Mediumint Maximum Value
                // which is the Lowest amongst DBMSes Supported by phpBB3

                if ($max_recipients_error = validate_data($submit_ary, array('max_recipients' => array('num', false, 0, 16777215))))
                {
                    // Replace "error" String with its Real, Localised Form
                    $error = array_merge($error, array_map(array(&$user, 'lang'), $max_recipients_error));
                }

                if (!sizeof($error))
                {
                    // Only Set the Rank, Colour, etc. if it's Changed or if we're Adding a New
                    // Group. This prevents Existing Group Members being updated if No Changes
                    // were made.

                    $group_attributes = array();
                    $test_variables   = array('rank', 'colour', 'avatar', 'avatar_type', 'avatar_width', 'avatar_height', 'receive_pm', 'legend', 'message_limit', 'max_recipients', 'founder_manage');

                    foreach ($test_variables as $test)
                    {
                        if (isset($submit_ary[$test]) && ($action == 'add' || $group_row['group_' . $test] != $submit_ary[$test]))
                        {
                            $group_attributes['group_' . $test] = $group_row['group_' . $test] = $submit_ary[$test];
                        }
                    }
                    if (!($error = group_create($group_id, $group_type, $group_name, $group_desc, $group_attributes, $allow_desc_bbcode, $allow_desc_urls, $allow_desc_smilies)))
                    {
                        $group_perm_from = request_var('group_perm_from', 0);

                        // Copy Permissions?
                        // If the User has the a_authgroups Permission and at least One Additional Permission Ability Set the Permissions are Fully Transferred.
                        // We Do Not Limit on One Auth Category because this can Lead to Incomplete Permissions being Tricky to Fix for the Admin, Roles being Assigned or Added Non-Default Permissions.
                        // Since the User Only has the Option to Copy Permissions from Non Leader Managed Groups this seems to be a good compromise.

                        if ($group_perm_from && $action == 'add' && checkaccess('a_authgroups') && checkaccess('a_aauth') && checkaccess('a_fauth') && checkaccess('a_mauth') && checkaccess('a_uauth'))
                        {
                            $sql = 'SELECT group_founder_manage
                                    FROM ' . $db_prefix . '_level_settings
                                    WHERE group_id = ' . $group_perm_from;

                            $result    = $db->sql_query($sql);
                            $check_row = $db->sql_fetchrow($result);

                            $db->sql_freeresult($result);

                            // Check the group if non-founder
                            if ($check_row && ($user->admin || $check_row['group_founder_manage'] == 0))
                            {
                                // From the MySQL Documentation:
                                // Prior to MySQL 4.0.14, the target table of the INSERT statement cannot appear in the FROM clause of the SELECT part of the query. This limitation is lifted in 4.0.14.
                                // Due to this we stay on the safe side if we do the insertion "the manual way"

                                // Copy Permisisons from/to the ACL Groups Table (Only group_id gets changed)
                                $sql = 'SELECT *
                                        FROM ' . $db_prefix . '_levels
                                        WHERE group_id = ' . $group_perm_from;

                                $result = $db->sql_query($sql);
                                $row    = $db->sql_fetchrow($result);
                                $params = array();
                                $values = array();

                                array_push($params, 'group_id');
                                array_push($values, $group_id);
                                array_push($params, 'name');
                                array_push($values, $db->sql_escape($group_name));
                                array_push($params, 'level');
                                array_push($values, strtoupper($db->sql_escape($group_name)));

                                foreach ($row as $var => $val)
                                {
                                    if (!is_numeric($var))
                                    {
                                        if ($val=="false" || $val=="true" || $var=="color" || $var=="group_desc")
                                        {
                                            array_push($params,$var);
                                            array_push($values,$val);
                                        }
                                    }
                                }

                                $db->sql_query("INSERT INTO " . $db_prefix . "_levels (" . implode(", ",$params) . ") VALUES ('" . implode("', '",$values) . "');") OR btsqlerror();
                        }
                    }
                    elseif ($action == 'add' && checkaccess('a_authgroups'))
                    {
                        $db->sql_query("INSERT INTO " . $db_prefix . "_levels (level, name, group_id ) VALUES ('" . strtoupper($db->sql_escape($group_name)) . "', '" . $db->sql_escape($group_name) . "' , '" . $group_id . "');") OR btsqlerror("INSERT INTO " . $db_prefix . "_levels (level, name, group_id ) VALUES ('" . strtoupper($db->sql_escape($group_name)) . "', '" . $db->sql_escape($group_name) . "' , '" . $group_id . "');");
                    }

                    $message = ($action == 'edit') ? 'GROUP_UPDATED' : 'GROUP_CREATED';

                    add_log('admin', 'LOG_' . $message, $db->sql_escape($group_name));

                    $template->assign_vars(array(
                            'S_USER_NOTICE' => true,
                            'S_FORWARD'     => false,
                            'MESSAGE_TITLE' => $user->lang['SUCCESS'],
                            'MESSAGE_TEXT'  => $user->lang[$message] . back_link($u_action),
                    ));

                    echo $template->fetch('admin/message_body.html');
                    close_out();
                }
            }

            if (sizeof($error))
            {
                $group_rank = $submit_ary['rank'];

                $group_desc_data = array(
                        'text'          => $group_desc,
                        'allow_bbcode'  => $allow_desc_bbcode,
                        'allow_smilies' => $allow_desc_smilies,
                        'allow_urls'    => $allow_desc_urls
                );
            }
        }
        else if (!$group_id)
        {
            $group_name = utf8_normalize_nfc(request_var('group_name', '', true));

            $group_desc_data = array(
                    'text'          => '',
                    'allow_bbcode'  => true,
                    'allow_smilies' => true,
                    'allow_urls'    => true
            );

            $group_rank = 0;
            $group_type = 0;
        }
        else
        {
            $group_name = $group_row['group_name'];
			$gourpdesc = ((isset($user->lang[$group_row['group_desc']]))? $user->lang[$group_row['group_desc']] : $group_row['group_desc']);
			if($gourpdesc == $group_row['group_desc']) $gourpdesc = false;

            $group_desc_data = generate_text_for_edit($group_row['group_desc'], $group_row['group_desc_uid'], $group_row['group_desc_options']);

            $group_type = $group_row['group_type'];
            $group_rank = $group_row['group_rank'];
        }

        $sql = 'SELECT *
                FROM ' . $db_prefix . '_ranks
                WHERE rank_special = 1
                ORDER BY rank_title';

        $result = $db->sql_query($sql);

        $rank_options = '<option value="0"' . ((!$group_rank) ? ' selected="selected"' : '') . '>' . $user->lang['USER_DEFAULT'] . '</option>';

        while ($row = $db->sql_fetchrow($result))
        {
            $selected = ($group_rank && $row['rank_id'] == $group_rank) ? ' selected="selected"' : '';
            $rank_options .= '<option value="' . $row['rank_id'] . '"' . $selected . '>' . $row['rank_title'] . '</option>';
        }

        $db->sql_freeresult($result);

        $type_free   = ($group_type == 4) ? ' checked="checked"' : '';
        $type_open   = ($group_type == 0) ? ' checked="checked"' : '';
        $type_closed = ($group_type == 1) ? ' checked="checked"' : '';
        $type_hidden = ($group_type == 2) ? ' checked="checked"' : '';

        $avatar_img = (!empty($group_row['group_avatar'])) ? get_group_avatar($group_row['group_avatar'], $group_row['group_avatar_type'], $group_row['group_avatar_width'], $group_row['group_avatar_height'], 'GROUP_AVATAR') : gen_avatar(0);

        $display_gallery = (isset($_POST['display_gallery'])) ? true : false;

        if ($avgalon && $display_gallery)
        {
            avatar_gallery($category, $avatar_select, 4);
        }

        $back_link = request_var('back_link', '');

        switch ($back_link)
        {
            case 'acp_users_groups':
                $u_back = append_sid("{$phpbb_admin_path}index.$phpEx", 'i=users&amp;mode=groups&amp;u=' . request_var('u', 0));
            break;

            default:
                $u_back = $u_action;
            break;
        }
		//die($group_desc_data['text']);

        $template->assign_vars(array(
                'S_EDIT'            => true,
                'S_ADD_GROUP'       => ($action == 'add') ? true : false,
                'S_GROUP_PERM'      => ($action == 'add' && checkaccess("a_edit_level")) ? true : false,
                'S_INCLUDE_SWATCH'  => true,
                'S_CAN_UPLOAD'      => $can_upload,
                'S_ERROR'           => (sizeof($error)) ? true : false,
                'S_SPECIAL_GROUP'   => ($group_type == 3) ? true : false,
                'S_DISPLAY_GALLERY' => ($avgalon && !$display_gallery) ? true : false,
                'S_IN_GALLERY'      => ($avgalon && $display_gallery) ? true : false,
                'S_USER_FOUNDER'    => ($user->admin) ? true : false,

                'ERROR_MSG'            => (sizeof($error)) ? implode('<br />', $error) : '',

                'GROUP_NAME'           => ($group_type == 3) ? $user->lang['G_' . $group_name] : $group_name,
                'GROUP_INTERNAL_NAME'  => $group_name,
                'GROUP_DESC'           => $group_desc_data['text'],
				'GROUP_DESC_FILE'		=> $gourpdesc,

                'GROUP_RECEIVE_PM'     => (isset($group_row['group_receive_pm']) && $group_row['group_receive_pm']) ? ' checked="checked"' : '',

                'GROUP_FOUNDER_MANAGE' => (isset($group_row['group_founder_manage']) && $group_row['group_founder_manage']) ? ' checked="checked"' : '',

                'GROUP_LEGEND'         => (isset($group_row['group_legend']) && $group_row['group_legend']) ? ' checked="checked"' : '',

                'GROUP_MESSAGE_LIMIT'  => (isset($group_row['group_message_limit'])) ? $group_row['group_message_limit'] : 0,
                'GROUP_MAX_RECIPIENTS' => (isset($group_row['group_max_recipients'])) ? $group_row['group_max_recipients'] : 0,
                'GROUP_COLOUR'         => (isset($group_row['group_colour'])) ? $group_row['group_colour'] : '',
                'GROUP_SKIP_AUTH'      => (!empty($group_row['group_skip_auth'])) ? ' checked="checked"' : '',

                'S_DESC_BBCODE_CHECKED'  => $group_desc_data['allow_bbcode'],
                'S_DESC_URLS_CHECKED'    => $group_desc_data['allow_urls'],
                'S_DESC_SMILIES_CHECKED' => $group_desc_data['allow_smilies'],
                'S_RANK_OPTIONS'         => $rank_options,
                'S_GROUP_OPTIONS'        => group_select_options_id(false, false, (($user->admin) ? false : 0)),

                'AVATAR'                 => $avatar_img,
                'AVATAR_IMAGE'           => $avatar_img,
                'AVATAR_MAX_FILESIZE'    => $config['avatar_filesize'],
                'AVATAR_WIDTH'           => (isset($group_row['group_avatar_width'])) ? $group_row['group_avatar_width'] : '',
                'AVATAR_HEIGHT'          => (isset($group_row['group_avatar_height'])) ? $group_row['group_avatar_height'] : '',

                'GROUP_TYPE_FREE'    => 4,
                'GROUP_TYPE_OPEN'    => 0,
                'GROUP_TYPE_CLOSED'  => 1,
                'GROUP_TYPE_HIDDEN'  => 2,
                'GROUP_TYPE_SPECIAL' => 3,

                'GROUP_FREE'         => $type_free,
                'GROUP_OPEN'         => $type_open,
                'GROUP_CLOSED'       => $type_closed,
                'GROUP_HIDDEN'       => $type_hidden,

                'U_BACK'             => $u_back,
                'U_SWATCH'           => append_sid("./swatch.$phpEx", 'form=settings&amp;name=group_colour'),
                'U_ACTION'           => "{$u_action}&amp;action=$action&amp;g=$group_id",

                'L_AVATAR_EXPLAIN'   => sprintf($user->lang['AVATAR_EXPLAIN'], $avminwt, $avminht, round($avmaxsz / 1024)),
        ));

        $u_action = "{$u_action}&amp;action=$action&amp;g=$group_id";
    break;
}

$template->assign_vars(array(
        'U_ACTION'    => $u_action,
        'S_GROUP_ADD' => (checkaccess("a_edit_level")) ? true : false)
);

// Get All the Groups
$sql = 'SELECT g.group_id, g.group_name, g.group_type
        FROM ' . $db_prefix . '_level_settings g
        ORDER BY g.group_type ASC, g.group_name';

$result = $db->sql_query($sql);
$lookup = $cached_group_data = array();

while ($row = $db->sql_fetchrow($result))
{
    $type = ($row['group_type'] == 3) ? 'special' : 'normal';

    // used to Determine what Type a Group is
    $lookup[$row['group_id']] = $type;

    // used for Easy Access to the Data within a Group
    $cached_group_data[$type][$row['group_id']] = $row;
    $cached_group_data[$type][$row['group_id']]['total_members'] = 0;
}

$db->sql_freeresult($result);

// How many people are in which Group?
$sql = 'SELECT COUNT(ug.id) AS total_members, ug.can_do
        FROM ' . $db_prefix . '_users ug
        WHERE ' . $db->sql_in_set('ug.can_do', array_keys($lookup)) . '
        GROUP BY ug.can_do';

$result = $db->sql_query($sql);

while ($row = $db->sql_fetchrow($result))
{
    $type = $lookup[$row['can_do']];
    $cached_group_data[$type][$row['can_do']]['total_members'] = $row['total_members'];
}

$db->sql_freeresult($result);

// The Order is... Normal, then Special
ksort($cached_group_data);

foreach ($cached_group_data as $type => $row_ary)
{
    if ($type == 'special')
    {
        $template->assign_block_vars('groups', array(
                'S_SPECIAL' => true
        ));
    }

    foreach ($row_ary as $group_id => $row)
    {
        $group_name = (!empty($user->lang['G_' . $row['group_name']]))? $user->lang['G_' . $row['group_name']] : $row['group_name'];

        $template->assign_block_vars('groups', array(
                'U_LIST'          => "{$u_action}&amp;action=list&amp;g=$group_id",
                'U_EDIT'          => "{$u_action}&amp;action=edit&amp;g=$group_id",

                'U_DELETE'        => ($auth->acl_get('a_groupdel')) ? "{$u_action}&amp;action=delete&amp;g=$group_id" : '',

                'S_GROUP_SPECIAL' => ($row['group_type'] == 3) ? true : false,

                'GROUP_NAME'      => $group_name,
                'TOTAL_MEMBERS'   => $row['total_members'],
        ));
    }
}

echo $template->fetch('admin/acp_levels.html');
close_out();

?>