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
** File sig_settings.php 2018-07-29 07:27:00 Thor
**
** CHANGES
**
** 2018-07-29 - Add Language to drawRow & Code Tidy
**/

if (!defined('IN_PMBT'))
{
	include_once './../../security.php';
	die ("You can't access this file directly");
}

$sql = 'SELECT * FROM `' . $db_prefix . '_settings`';

$avres  = $db->sql_query($sql) or btsqlerror($avsql);
$cfgrow = array();

while ($adv_sett = $db->sql_fetchrow($avres))$cfgrow[$adv_sett['config_name']] = $adv_sett['config_value'] ;
    $do = request_var('do', '');

if (isset($do) && $do == "save")
{
    $new_config = array();
    $allow_sig          = request_var('sub_allow_sig', 0);
    $allow_sig_bbcode   = request_var('sub_allow_sig_bbcode', 0);
    $allow_sig_img      = request_var('sub_allow_sig_img', 0);
    $allow_sig_flash    = request_var('sub_allow_sig_flash', 0);
    $allow_sig_smilies  = request_var('sub_allow_sig_smilies', 0);
    $allow_sig_links    = request_var('sub_allow_sig_links', 0);
    $max_sig_links      = request_var('sub_max_sig_links', 0);
    $max_sig_chars      = request_var('sub_max_sig_chars', 0);
    $max_sig_urls       = request_var('sub_max_sig_urls', 0);
    $max_sig_font_size  = request_var('sub_max_sig_font_size', 0);
    $max_sig_smilies    = request_var('sub_max_sig_smilies', 0);
    $max_sig_img_width  = request_var('sub_max_sig_img_width', 0);
    $max_sig_img_height = request_var('sub_max_sig_img_height', 0);

    if ($cfgrow['allow_sig']          != $allow_sig)$new_config['allow_sig'] = $allow_sig;
    if ($cfgrow['allow_sig_bbcode']   != $allow_sig_bbcode)$new_config['allow_sig_bbcode'] = $allow_sig_bbcode;
    if ($cfgrow['allow_sig_img']      != $allow_sig_img)$new_config['allow_sig_img'] = $allow_sig_img;
    if ($cfgrow['allow_sig_flash']    != $allow_sig_flash)$new_config['allow_sig_flash'] = $allow_sig_flash;
    if ($cfgrow['allow_sig_smilies']  != $allow_sig_smilies)$new_config['allow_sig_smilies'] = $allow_sig_smilies;
    if ($cfgrow['allow_sig_links']    != $allow_sig_links)$new_config['allow_sig_links'] = $allow_sig_links;
    if ($cfgrow['max_sig_chars']      != $max_sig_chars)$new_config['max_sig_chars'] = $max_sig_chars;
    if ($cfgrow['max_sig_urls']       != $max_sig_urls)$new_config['max_sig_urls'] = $max_sig_urls;
    if ($cfgrow['max_sig_font_size']  != $max_sig_font_size)$new_config['max_sig_font_size'] = $max_sig_font_size;
    if ($cfgrow['max_sig_smilies']    != $max_sig_smilies)$new_config['max_sig_smilies'] = $max_sig_smilies;
    if ($cfgrow['max_sig_img_width']  != $max_sig_img_width)$new_config['max_sig_img_width'] = $max_sig_img_width;
    if ($cfgrow['max_sig_img_height'] != $max_sig_img_height)$new_config['max_sig_img_height'] = $max_sig_img_height;
    if ($cfgrow['max_sig_links']      != $max_sig_links)$new_config['max_sig_links'] = $max_sig_links;

	foreach($new_config as $config_name => $config_value)
	{
		set_config($config_name, $config_value);
	}

    $template->assign_vars(array(
            'S_SUCCESS' => true,
            'S_FORWARD' => $siteurl . "/admin.php?i=siteinfo&op=sig_settings",
            'TITTLE_M'  => $user->lang['SUCCESS'],
            'MESSAGE'   => $user->lang['_admsaved'],
    ));

    echo $template->fetch('message_body.html');
    die();
}

$hidden = build_hidden_fields(array(
        'do' => 'save',
        'i'  => 'siteinfo',
        'op' => 'sig_settings',
));

$template->assign_vars(array(
        'L_TITLE'         => $user->lang['MENU_SIG_SETTINGS'],
        'L_TITLE_EXPLAIN' => $user->lang['MENU_SIG_SETTINGS_EXP'],
        'U_ACTION'        => "./admin.php",
        'S_FORM_TOKEN'    => $hidden,
));

drawRow('sitename','text', false, $user->lang['GENERAL_SETTINGS']);
drawRow('allow_sig', 'selecty_n', NULL, false, 'allow_sig');
drawRow('allow_sig_bbcode', 'selecty_n', NULL, false, 'allow_sig_bbcode');
drawRow('allow_sig_img', 'selecty_n', NULL,false, 'allow_sig_img');
drawRow('allow_sig_flash', 'selecty_n', NULL,false, 'allow_sig_flash');
drawRow('allow_sig_smilies', 'selecty_n', NULL,false, 'allow_sig_smilies');
drawRow('allow_sig_links', 'selecty_n', NULL,false, 'allow_sig_links');
drawRow('sitename', 'text', false ,$user->lang['GENERAL_OPTIONS']);
drawRow('max_sig_chars', 'text');
drawRow('max_sig_urls', 'text');
drawRow('max_sig_font_size', 'text', NULL, false, '%');
drawRow('max_sig_smilies', 'text');
drawRow('max_sig_img_width', 'text', NULL, false, 'px');
drawRow('max_sig_img_height', 'text', NULL, false, 'px');

echo $template->fetch('admin/site_settings.html');
close_out();

?>