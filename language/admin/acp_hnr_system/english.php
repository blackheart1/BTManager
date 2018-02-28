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
** And Joe Robertson (aka joeroberts)
** Project Leaders: Black_heart, Thor.
** File acp_hnr_system/english.php 2018-02-28 06:20:00 Thor
**
** CHANGES
**
** 2018-02-18 - Added New Masthead
** 2018-02-18 - Added New !defined('IN_PMBT')
** 2018-02-18 - Fixed Spelling
**/

if (!defined('IN_PMBT'))
{
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

            <title>
                <?php if (isset($_GET['error']))
            {
                echo htmlspecialchars($_GET['error']);
            }
            ?> Error</title>

            <link rel='stylesheet' type='text/css' href='/errors/error-style.css' />
        </head>

        <body>
            <div id='container'>
                <div align='center' style='padding-top: 15px'>
                    <img src='/errors/error-images/alert.png' width='89' height='94' alt='' title='' />
                </div>

                <h1 class='title'>Error 404 - Page Not Found</h1>
                <p class='sub-title' align='center'>The page that you are looking for does not appear to exist on this site.</p>
                <p>If you typed the address of the page into the address bar of your browser, please check that you typed it in correctly.</p>
                <p>If you arrived at this page after you used an old Boomark or Favorite, the page in question has probably been moved. Try locating the page via the navigation menu and then update your bookmarks.</p>
            </div>
        </body>
    </html>

    <?php
    exit();
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
    'TITLE'                           => 'Automated Hit and Run System',
    'TITLE_EXP'                       => 'A Hit and Run User is someone that will Download a File and as soon as it is completely downloaded they close their Torrent Client without Seeding it back.<br />With this System you can Monitor your Users to make sure that this does NOT happen and to take action for those that do.',

    'HNR_HEADER'                      => 'Hit and Run Settings',
    'SETTING_SAVED'                   => 'Settings have been Saved to the Database',
    '_admphnr_system'                 => 'Turn ON the Hit and Run System',
    '_admphnr_systemexplain'          => 'Enable or Disable the Hit and Run System',
    '_admpseedtime'                   => 'Seed Time',
    '_admpseedtimeexplain'            => 'Set the Time in Minutes for how long a User Needs to Seed a Torrent',
    '_admptime_before_warn'           => 'Time Allowed between each Announce',
    '_admptime_before_warnexplain'    => 'How long after the First Missed Announce to give a User before they Receive a Warning PM <br />(Set Time in Minutes)',

    '_admpmaxhitrun'                  => 'Maximum Number of Hit and Runs',
    '_admpmaxhitrunexplain'           => 'Maximum Hit and Runs before a User gets a Site Warning',
    '_admpwarnlength'                 => 'Length of Warning for Hit and Run',
    '_admpwarnlengthexplain'          => 'How long should the Hit And Run Warning be for (Set the Time in Days)',
    '_admpban_hnr_users'              => 'Ban User for Hit and Run',
    '_admpban_hnr_usersexplain'       => 'Select if you want to Ban Users for Hit and Run',
    '_admpdemote_hnr_users'           => 'Demote User for Hit and Run',
    '_admpdemote_hnr_usersexplain'    => 'Select if you want to Demote Users for Hit and Run',
    '_admpafter_high_hnr'             => 'Demote after Maximum Number of Hit And Runs',
    '_admpafter_high_hnrexplain'      => 'Maximum Number of Hit and Runs before User is Demoted',
    '_admpdemote_hnr_users_to'        => 'Demote User',
    '_admpdemote_hnr_users_toexplain' => 'Demote User to a Lower User Class',
    '_admpban_time'                   => 'Length of Time to Demote for Hit and Run',
    '_admpban_timeexplain'            => 'How long should the Demotion last for Hit and Run (Set the Time in Days)',
    'ERR_ON'                          => 'Invalid Entry for "<b>Turn ON Hit And Run System</b>"  ( %s )',
    'ERR_DEMOTE'                      => 'Invalid Entry for "<b>Demote User for Hit and Run</b>"  ( %s )',
    'ERR_DEMOTE_TIME'                 => 'Invalid Entry for "<b>Length of Time to Demote for Hit and Run</b>" ( %s ) is NOT Numeric',
    'ERR_DEMOTE_LEVEL'                => 'Invalid Entry for "<b>Demote User to</b>" ( %s ) is NOT a Valid Group',
    'ERR_SEED_TIME'                   => 'Invalid Entry for "<b>Seed Time</b>" ( %s ) is NOT Numeric',
    'ERR_TIME_PREWARN'                => 'Invalid Entry for "<b>Time allowed between Announce</b>" ( %s ) is NOT Numeric',
    'ERR_MAX_HITS'                    => 'Invalid Entry for "<b>Maximum Number of Hit And Runs</b>" ( %s ) is NOT Numeric',
    'ERR_WARN_LEN'                    => 'Invalid Entry for "<b>Length of Warning for Hit and Run</b>" ( %s ) is NOT Numeric',
    'ERR_AFTER_HIGH'                  => 'Invalid Entry for "<b>Maximum Number of Hit And Runs before User is Demoted</b>" ( %s ) is NOT Numeric',
    'ERR_BAN_HNR'                     => 'Invalid Entry for "<b>Ban User for Hit and Run</b>"  ( %s )',
    'ERR_ARRAY_MESS'                  => '<li>%s</li>',
    'SETTINGS_NOT_SAVED'              => 'Hit And Run Settings NOT Saved',
));

?>