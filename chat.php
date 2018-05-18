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
** File chat.php 2018-02-19 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (defined('IN_PMBT'))
{
	die ("You can't include this file");
}
else
{
	define("IN_PMBT",true);
}
require_once("common.php");
$template = new Template();
set_site_var($user->lang['IRC_CHAT']);
function build_hidden_parms($field_ary, $specialchar = false, $stripslashes = false)
{
	$s_hidden_fields = '';

	foreach ($field_ary as $name => $vars)
	{
		$name = ($stripslashes) ? stripslashes($name) : $name;
		$name = ($specialchar) ? htmlspecialchars($name, ENT_COMPAT, 'UTF-8') : $name;

		$s_hidden_fields .= _build_hidden_parms($name, $vars, $specialchar, $stripslashes);
	}

	return $s_hidden_fields;
}
function _build_hidden_parms($key, $value, $specialchar, $stripslashes)
{
	$hidden_fields = '';

	if (!is_array($value))
	{
		$value = ($stripslashes) ? stripslashes($value) : $value;
		$value = ($specialchar) ? htmlspecialchars($value, ENT_COMPAT, 'UTF-8') : $value;
		echo $val;

		$hidden_fields .= '<param name="' . $key . '" value="' . $value . '">' . "\n";
	}
	else
	{
		foreach ($value as $_key => $_value)
		{
			$_key = ($stripslashes) ? stripslashes($_key) : $_key;
			$_key = ($specialchar) ? htmlspecialchars($_key, ENT_COMPAT, 'UTF-8') : $_key;

			$hidden_fields .= _build_hidden_parms($key . '[' . $_key . ']', $_value, $specialchar, $stripslashes);
		}
	}

	return $hidden_fields;
}
$ircconfig = parse_ini_file("include/irc.ini");
$nick = preg_replace("/[^a-z0-9_]/i","",$user->name);
if($user->nick != "")$nick2 = preg_replace("/[^a-z0-9_]/i","",$user->nick);
else
$nick2 = $nick."@bittorrent.".$cookiedomain;
$parms = array(
			'CABINETS'					=>	'pjirc/irc.cab,pjirc/securedirc.cab,pjirc/pixx.cab',
			'nick'						=>	$nick,
			'alternatenick'				=>	$nick2,
			'name'						=>	$user->name,
			'host'						=>	$ircconfig["server"],
			'port'						=>	'6667',
			'language'					=>	"pjirc/".$language,
			'pixx:language'				=>	"pjirc/pixx-".$language,
			'gui'						=>	'pixx',
			'soundbeep'					=>	'pjirc/snd/bell2.au',
			'soundquery'				=>	'pjirc/snd/ding.au',
			'command1'					=>	"/join ".$ircconfig["channel"],
			'style:bitmapsmileys'		=>	'true',
			);


	
	$sql = "SELECT code, file FROM ".$db_prefix."_smiles ORDER BY code ASC;";
$res = $db->sql_query($sql);
$i = 1;
$num = $db->sql_numrows($res);
$smlilie_list = '';
while (list($code, $file) = $db->fetch_array($res)) {
        $parms['style:smiley' . $i]		= $code . " smiles/" . $file;
        $i++;
}
$db->sql_freeresult($res);
//Other eventual parameters by .ini file
foreach ($ircconfig as $key=>$val) {
        if ($key == "server" OR $key == "channel") continue;
        $parms[$key]		= ($val == '')? 'false' : $val;
}
$template->assign_vars(array(
						'PARMS'				=>	build_hidden_parms($parms),
						));
echo $template->fetch('chat.html');
close_out();
?>