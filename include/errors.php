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
** File errors.php 2018-05-30 06:28:00 Thor
**
** CHANGES
**
** 2018-05-30 - Updated DOCTYPE
**/

if (!defined('IN_PMBT'))
{
	include_once './../security.php';
	die ();
}

error_reporting(E_ALL);

function myErrorHandler($errno, $errstr, $errfile, $errline)
{
	global $pmbt_cache, $db_prefix, $db, $auth, $template, $config, $user, $phpEx, $admin_email, $siteurl, $msg_title, $msg_long_text;

	if (error_reporting() == 0 && $errno != E_WARNING
                               && $errno != E_USER_ERROR
                               && $errno != E_USER_WARNING
                               && $errno != E_USER_NOTICE
                               && $errno != E_PARSE
                               && $errno != E_ERROR
                               && $errno != E_FATAL
                               && $errno != E_STRICT
                               && $errno != E_DEPRECATED)
	{
		return;
	}

    if (!(error_reporting() & $errno))
	{
        // This error code is not included in error_reporting
        return;
    }

    switch ($errno) {
    case E_USER_ERROR:
			if (!empty($user) && !empty($user->lang))
			{
				$errstr = (!empty($user->lang[$errstr])) ? $user->lang[$errstr] : $errstr;
				$msg_title = (!isset($msg_title)) ? $user->lang['BT_ERROR'] : (($user->lang[$msg_title]) ? $user->lang[$msg_title] : $msg_title);

				$l_return_index = sprintf($user->lang['RETURN_INDEX'], '<a href="' . $siteurl . '">', '</a>');
				$l_notify = '';

				if (!empty($admin_email))
				{
					$l_notify = '<p>' . sprintf($user->lang['NOTIFY_ADMIN_EMAIL'], $admin_email) . '</p>';
				}
			}
			else
			{
				$msg_title = 'General Error';
				$l_return_index = '<a href="' . $siteurl . '">Return to Index Page</a>';
				$l_notify = '';

				if (!empty($admin_email))
				{
					$l_notify = '<p>Please Notify the Board Administrator or Webmaster: <a href="mailto:' . $admin_email . '">' . $admin_email . '</a></p>';
				}
			}
			// Try to not call the adm page data...

			echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">';
			echo '<html xmlns="http://www.w3.org/1999/xhtml" dir="' . $user->lang['DIRECTION'] . '" lang="' . $user->lang['USER_LANG'] . '" xml:lang="' . $user->lang['USER_LANG'] . '" />';
			echo '<head>';
            echo '<meta http-equiv="content-type" content="text/html; charset=' . $user->lang['CONTENT_ENCODING'] . '" />';
            echo '<meta name="generator" content="BTManager ' . $version . '" />';
            echo '<meta http-equiv="pragma" content="no-cache" />';
            echo '<meta http-equiv="expires" content="-1" />';
            echo '<meta http-equiv="cache-control" content="no-cache" />';
			echo '<title>' . $msg_title . '</title>';
			echo '<style type="text/css">' . "\n" . '/* <![CDATA[ */' . "\n";
			echo '* { margin: 0; padding: 0; } html { font-size: 100%; height: 100%; margin-bottom: 1px; background-color: #E4EDF0; } body { font-family: "Lucida Grande", Verdana, Helvetica, Arial, sans-serif; color: #536482; background: #E4EDF0; font-size: 62.5%; margin: 0; } ';
			echo 'a:link, a:active, a:visited { color: #006699; text-decoration: none; } a:hover { color: #DD6900; text-decoration: underline; } ';
			echo '#wrap { padding: 0 20px 15px 20px; min-width: 615px; } #page-header { text-align: right; height: 40px; } #page-footer { clear: both; font-size: 1em; text-align: center; } ';
			echo '.panel { margin: 4px 0; background-color: #FFFFFF; border: solid 1px  #A9B8C2; } ';
			echo '#errorpage #page-header a { font-weight: bold; line-height: 6em; } #errorpage #content { padding: 10px; } #errorpage #content h1 { line-height: 1.2em; margin-bottom: 0; color: #DF075C; } ';
			echo '#errorpage #content div { margin-top: 20px; margin-bottom: 5px; border-bottom: 1px solid #CCCCCC; padding-bottom: 5px; color: #333333; font: bold 1.2em "Lucida Grande", Arial, Helvetica, sans-serif; text-decoration: none; line-height: 120%; text-align: left; } ';
			echo "\n" . '/* ]]> */' . "\n";
			echo '</style>';
			echo '</head>';
			echo '<body id="errorpage">';
			echo '<div id="wrap">';
			echo '	<div id="page-header">';
			echo '		' . $l_return_index;
			echo '	</div>';
			echo '	<div id="acp">';
			echo '	<div class="panel">';
			echo '		<div id="content">';
			echo '			<h1>' . $msg_title . '</h1>';

			echo '			<div>' . $errstr . '</div>';

			echo $l_notify;

			echo '		</div>';
			echo '	</div>';
			echo '	</div>';
			echo '	<div id="page-footer">';
			echo '		<a target="_blank" href="http://www.btmanager.org">BTManager&#8482;</a>';
			echo '	</div>';
			echo '</div>';
			echo '</body>';
			echo '</html>';
			exit;
	break;
		case E_USER_WARNING:
		case E_USER_NOTICE:
		require_once("include/config.php"); //if config file has not been loaded yet
		include_once'include/class.template.php';
		require_once("include/actions.php");
		require_once("include/user.functions.php");
			$template = new Template();
			set_site_var($user->lang['NOTICE']);
			$errstr = (!empty($user->lang[$errstr])) ? $user->lang[$errstr] : $errstr;
			$msg_title = (!isset($errstr)) ? $user->lang['INFORMATION'] : ((!empty($user->lang[$errstr])) ? $user->lang[$errstr] : $errstr);
			$template->assign_vars(array(
				'S_ERROR'			=> false,
				'S_FORWARD'			=>	false,
				'S_SUCCESS'			=> true,
				'TITTLE_M'          => $msg_title,
				'MESSAGE'           => '',
			));
			echo @$template->fetch(((preg_match("/admin.php/", $_SERVER["PHP_SELF"])) ? 'admin/' : '') . 'message_body.html');
			close_out();
		break;
    case E_ERROR:
        echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
        echo "  Fatal Error on Line $errline in File $errfile<br />";
		array_walk( debug_backtrace(), create_function( '$a,$b', 'print "<br /><b>". basename( $a[\'file\'] ). "</b> &nbsp; <font color=\"red\">{$a[\'line\']}</font> &nbsp; <font color=\"green\">{$a[\'function\']} ()</font> &nbsp; -- ". dirname( $a[\'file\'] ). "/";' ) ); 	echo "<br />";
        echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
        echo "Aborting...<br />\n";
        exit();
        break;

    case E_WARNING:
    case E_USER_WARNING:
        echo "<table><tr><td><b>My User WARNING</b> [$errno] $errstr<br />\n";
		@array_walk( debug_backtrace(), create_function( '$a,$b', 'print "<br /><b>". basename( $a[\'file\'] ). "</b> &nbsp; <font color=\"red\">{$a[\'line\']}</font> &nbsp; <font color=\"green\">{$a[\'function\']} ()</font> &nbsp; -- ". dirname( $a[\'file\'] ). "/";' ) );         echo "  Warning Error on Line $errline in File $errfile<br />";
        echo "</td></tr></table><br clear=\"all\" />";
		return true;
		break;

    //case E_NOTICE:
    case E_DEPRECATED:
    case E_USER_NOTICE:
        echo "<b>My User NOTICE</b> [$errno] $errstr<br />\n";
        echo "  Notice Error on Line $errline in File $errfile<br />\n";
        break;
    case E_NOTICE:
    case E_STRICT:
	return true;
        break;

    default:
        echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
        echo "  Fatal Error on Line $errline in File $errfile";
        echo "Unknown Error Type: [$errno] $errstr<br />\n";
        break;
    }

    /* Don't execute PHP internal error handler */
    return false;
}
?>