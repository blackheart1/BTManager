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
** File polls.php 2018-07-17 07:28:00 Thor
**
** CHANGES
**
** 2018-07-17 - Added Language
**/

if (defined('IN_PMBT'))
{
    die ("You can't include this file");
}
else
{
    define('IN_PMBT', true);
}

require_once("common.php");
require_once("include/torrent_functions.php");

$user->set_lang('polls',$user->ulanguage);
$template = new Template();
set_site_var($user->lang['POLL_OVER_VIEW']);

$action   = request_var('action', '');
$pollid   = request_var('pollid', 0);
$returnto = strip_tags(request_var('returnto', ''));

if ($action == "delete")
{
    if (!$pollid)
    {
        trigger_error('INVALID_ID', E_USER_ERROR);
    }

    if (confirm_box(true))
    {
        $db->sql_query( "DELETE FROM " . $db_prefix . "_pollanswers WHERE pollid = $pollid") or sqlerr();
        $db->sql_query( "DELETE FROM " . $db_prefix . "_polls WHERE id = $pollid") or sqlerr();

        if ($returnto == "main")
            header("Location: $siteurl");
        else
            header("Location: $siteurl/polls.php?deleted=1");
        die;

        $template->assign_vars(array(
                                'S_SUCCESS' => true,
                                'S_FORWARD' => $siteurl . '/' . (($returnto == "main") ? 'index.php' : 'polls.php'),
                                'TITTLE_M'  => $user->lang['SUCCESS'],
                                'MESSAGE'   => $user->lang['POLL_REMOVED'],
        ));

        echo $template->fetch('message_body.html');
        close_out();
    }
    else
    {
        $hidden = build_hidden_fields(array(
                                        'pollid'   => $pollid,
                                        'action'   => 'delete',
                                        'returnto' => $returnto,
        ));

        confirm_box(false, $user->lang['POLL_DELETE'], $hidden, 'confirm_body.html', 'polls.php');
    }
}

$rows = $db->sql_query("SELECT COUNT(*) as count FROM " . $db_prefix . "_polls") or sqlerr();
$row = $db->sql_fetchrow($rows);
$pollcount = $row['count'];

if ($pollcount == 0)
{
    bterror($user->lang['ERROR_NO_POLLS'], $user->lang['BT_ERROR']);
}

$polls = $db->sql_query("SELECT * FROM " . $db_prefix . "_polls ORDER BY id DESC") or sqlerr();

function srt($a,$b)
{
    if ($a[0] > $b[0]) return -1;
    if ($a[0] < $b[0]) return 1;
    return 0;
}

while ($poll = $db->sql_fetchrow( $polls))
{
    $poll_out = array();
    $poll_out['CAN_EDIT'] = false;

    $o = array($poll['option0'],
               $poll['option1'],
               $poll['option2'],
               $poll['option3'],
               $poll['option4'],
               $poll['option5'],
               $poll['option6'],
               $poll['option7'],
               $poll['option8'],
               $poll['option9']);

    $key = array('OP_A',
                 'OP_B',
                 'OP_C',
                 'OP_D',
                 'OP_E',
                 'OP_F',
                 'OP_G',
                 'OP_H',
                 'OP_I',
                 'OP_J');

    $poll_out['ADDED']         = gmdate("Y-m-d",strtotime($poll['added']));
    $poll_out['TIME_ELAPS']    = get_elapsed_time(sql_timestamp_to_unix_timestamp($poll['added']));
    $poll_out['POLL_ID']       = $poll['id'];
    $poll_out['POLL_QUESTION'] = $poll['question'];

    if (checkaccess('edit_polls'))
    {
        $poll_out['CAN_EDIT'] = true;
    }

    $pollanswers = $db->sql_query("SELECT selection FROM " . $db_prefix . "_pollanswers WHERE pollid=" . $poll['id'] . " AND  selection < 20") or sqlerr();

    $tvotes = $db->sql_numrows($pollanswers);
    $poll_out['POLL_VOTES'] = number_format($tvotes);
    $vs = array(); // Count for each Option ([0]..[19])
    $os = array(); // Votes and Options: array(array(123, "Option 1"), array(45, "Option 2"))

    // Count Votes
    while ($pollanswer = $db->sql_fetchrow($pollanswers))
        $vs[$pollanswer['selection']] += 1;
    reset($o);

    for ($i = 0; $i < count($o); ++$i)

    if ($o[$i])
        $os[$i] = array($vs[$i], $o[$i]);

        // Now os is an Array like this:
        if ($poll['sort'] == "yes")
    	usort($os, 'srt');
            $i = 0;

        while ($a = $os[$i])
        {
            if ($tvotes > 0)
                $p = round($a[0] / $tvotes * 100);
            else
                $p = 0;
                $poll_out[$key[$i]] = $a[1];
                $poll_out[$key[$i] . '_IMG'] = ($p*2);
                $poll_out[$key[$i] . '_ANSWERS'] = $p;
                ++$i;
        }
    //die(print_r($poll_out));
    $template->assign_block_vars('poll_out',$poll_out);
}//POLLS_VIEW

$template->assign_vars(array(
                        'POLLS_VIEW' => true,));

echo $template->fetch('polloverview.html');
close_out();

?>