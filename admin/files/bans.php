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
** File bans.php 2018-08-02 07:37:00 Black_Heart
**
** CHANGES
**
** 2018-07-28 - Code Cleanup
** 2018-08-02 - Remove Depricated code
**/

if (!defined('IN_PMBT'))
{
    include_once './../../security.php';
    die ("You can't access this file directly");
}

$user->set_lang('admin/acp_bans',$user->ulanguage);
$user->set_lang('admin/acp_users',$user->ulanguage);

$mode = request_var('mode', 'user');

$template->assign_block_vars('l_block1.l_block2',array(
        'L_TITLE'    => $user->lang['ACP_BAN'],
        'S_SELECTED' => true,
        'U_TITLE'    => '1',));

$template->assign_block_vars('l_block1.l_block2.l_block3',array(
        'S_SELECTED' => ('user' ==$mode)? true:false,
        'IMG'        => '',
        'L_TITLE'    => $user->lang['ACP_BAN_USERNAMES'],
        'U_TITLE'    => append_sid("{$siteurl}/admin.$phpEx", 'i=userinfo&amp;op=bans&amp;mode=user'),
));

$template->assign_block_vars('l_block1.l_block2.l_block3',array(
        'S_SELECTED' => ('ip' ==$mode)? true:false,
        'IMG'        => '',
        'L_TITLE'    => $user->lang['ACP_BAN_IPS'],
        'U_TITLE'    => append_sid("{$siteurl}/admin.$phpEx", 'i=userinfo&amp;op=bans&amp;mode=ip'),
));

$template->assign_block_vars('l_block1.l_block2.l_block3',array(
        'S_SELECTED' => ('email' ==$mode)? true:false,
        'IMG'        => '',
        'L_TITLE'    => $user->lang['ACP_BAN_EMAILS'],
        'U_TITLE'    => append_sid("{$siteurl}/admin.$phpEx", 'i=userinfo&amp;op=bans&amp;mode=email'),
));

include_once('include/message_parser.php');
include_once('include/class.bbcode.php');
include_once('include/user.functions.php');
include_once('include/acp/acp_ban.php');
include_once('include/modules.php');

$module           = new acp_ban();
$module->module   =  'acp_ban';
$module->u_action =  append_sid("{$siteurl}/admin.$phpEx", 'i=userinfo&amp;op=bans&amp;mode=' . $mode);

$module->main('',$mode);

echo $template->fetch('admin/' . $module->tpl_name . '.html');
close_out();
?>