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
** File whois.php 2018-02-17 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
require_once("common.php");
$template = new Template();
set_site_var($user->lang['WHOIS'] . ': ' . long2ip($ip));
if(!checkaccess("m_view_whois"))
{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $user->lang['NO_AUTH'],
				));
				echo $template->fetch('message_body.html');
				close_out();
}
if (!function_exists('htmlspecialchars_decode'))
{
	/**
	* A wrapper for htmlspecialchars_decode
	* @ignore
	*/
	function htmlspecialchars_decode($string, $quote_style = ENT_COMPAT)
	{
		return strtr($string, array_flip(get_html_translation_table(HTML_SPECIALCHARS, $quote_style)));
	}
}
if (!function_exists('user_ipwhois'))
{
	function user_ipwhois($ip)
	{
		$ipwhois = '';
	
		// Check IP
		// Only supporting IPv4 at the moment...
		if (empty($ip) || !preg_match(get_preg_expression('ipv4'), $ip))
		{
			return '';
		}
	
		if (($fsk = fsockopen('whois.arin.net', 43, $errno, $errstr, 10)))
		{
			// CRLF as per RFC3912
			fputs($fsk, "$ip\r\n");
			while (!feof($fsk))
			{
				$ipwhois .= fgets($fsk, 1024);
			}
			fclose($fsk);
		}
	
		$match = array();
	
		// Test for referrals from ARIN to other whois databases, roll on rwhois
		if (preg_match('#ReferralServer: whois://(.+)#im', $ipwhois, $match))
		{
			if (strpos($match[1], ':') !== false)
			{
				$pos	= strrpos($match[1], ':');
				$server	= substr($match[1], 0, $pos);
				$port	= (int) substr($match[1], $pos + 1);
				unset($pos);
			}
			else
			{
				$server	= $match[1];
				$port	= 43;
			}
	
			$buffer = '';
	
			if (($fsk = fsockopen($server, $port)))
			{
				fputs($fsk, "$ip\r\n");
				while (!feof($fsk))
				{
					$buffer .= fgets($fsk, 1024);
				}
				@fclose($fsk);
			}
	
			// Use the result from ARIN if we don't get any result here
			$ipwhois = (empty($buffer)) ? $ipwhois : $buffer;
		}
	
		$ipwhois = htmlspecialchars($ipwhois);
	
		// Magic URL ;)
		return trim(make_clickable($ipwhois, false, ''));
	}
}
		$ip	= request_var('ip', '');
   
		$template->assign_var('WHOIS', user_ipwhois(long2ip($ip)));
   
echo $template->fetch('viewonline_whois.html');
$db->sql_close();
?>