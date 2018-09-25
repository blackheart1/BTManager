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
** File shout_cast.php 2018-09-22 14:32:00 joeroberts
**
** CHANGES
**
** 22-09-2018 - Removed truncated code
**/
if (!defined('IN_PMBT'))
{
	include_once './../security.php';
	die ();
}
global $db_prefix, $user, $db, $shout_config,$template,$siteurl,$language,$pmbt_cache,$theme, $auth,$phpEx;
$user->set_lang('shout_cast',$user->ulanguage);
if(!$radio = $pmbt_cache->get_sql("shout_cast")){
		$sql = "SELECT * FROM `".$db_prefix."_shout_cast`";
		$res = $db->sql_query($sql);
		$radio = $db->sql_fetchrow($res);
		$db->sql_freeresult($res);
		$pmbt_cache->set_sql("shout_cast", $radio);
}
if($radio['allow'] == 'true')
{
	$scip = $radio['ip'];  // IP adress or domain
	$scport = $radio['port'];     // Port               
	$scpass = $radio['admin_pass'];   // SHOUTcast Password
	$page = '';
	function time_elapsed_A($secs)
	{
		$bit = array(
		'y' => $secs / 31556926 % 12,
		'w' => $secs / 604800 % 52,
		'd' => $secs / 86400 % 7,
		'h' => $secs / 3600 % 24,
		'm' => $secs / 60 % 60,
		's' => $secs % 60
		);
		foreach($bit as $k => $v)
		if($v > 0)$ret[] = $v . $k;
		return join(' ', $ret);
	}
	$scfp = fsockopen($scip, $scport, $errno, $errstr, 1);
	if(!$scfp)
	{
		$scsuccs=1;
	}
	if($scsuccs!=1)
	{
		fputs($scfp,"GET /admin.cgi?pass=$scpass&mode=viewxml HTTP/1.0\r\nUser-Agent: SHOUTcast Song Status (Mozilla Compatible)\r\n\r\n");
		while(!feof($scfp))
		{
			$page .= fgets($scfp, 1000);
		}

		$loop = array("STREAMSTATUS", "BITRATE", "SERVERTITLE", "CURRENTLISTENERS", "MAXLISTENERS", "BITRATE");
		$y=0;
		while($loop[$y]!='')
		{
			preg_match("/<$loop[$y]>(.*?)<\/$loop[$y]>/",$page,$match);
			$scphp = strtolower($loop[$y]);
			$$scphp = $match[1];
			if($loop[$y]=='SERVERGENRE' || $loop[$y]=='SERVERTITLE' || $loop[$y]=='SONGTITLE' || $loop[$y]=='SERVERTITLE')
			{
				$$scphp = urldecode($$scphp);
			}
		
		  $y++;
		 }
		preg_match("/<SONGHISTORY>(.*?)<\/SONGHISTORY>/",$page,$match);
		$pageed = $match[1];
		$songatime = explode("<SONG>", $pageed);
		$r=1;
		while($songatime[$r]!=""){
			$t=$r-1;
			preg_match("/<PLAYEDAT>(.*?)<\/PLAYEDAT>/",$songatime[$r],$match);
			$playedat[$t] = $match[1];
			preg_match("/<TITLE>(.*?)<\/TITLE>/",$songatime[$r],$match);
			$song[$t]['SONG'] = urldecode($match[1]);
			$song[$t]['DATE'] = time_elapsed_A(time()-$playedat[$t]);
			$r++;
		}
		fclose($scfp);
	}

	$template->assign_vars(array(
			'STREAMSTATUS'			=>	$streamstatus,
			"BITRATE"				=>	$bitrate,
			"SERVERTITLE"			=>	$servertitle,
			"CURRENTLISTENERS"		=>	$currentlisteners,
			"MAXLISTENERS"			=>	$maxlisteners,
			"BITRATE"				=>	$bitrate,
			'LAST_TRACK'			=>	$song[0]['SONG'],
			'RADIO_DJ'				=>	$radio['host_dj'],
			'RADIO_IP'				=>	$radio['ip'],
			'RADIO_PORT'			=>	$radio['port'],
		));
	foreach($song as $val)
	{
		$template->assign_block_vars('last_songs', $val);
	}
	echo $template->fetch('shout_cast.html');
}

?>