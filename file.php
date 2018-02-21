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
** File file.php 2018-02-17 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
require_once("common.php");
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
function wrap_img_in_html($src, $title)
{
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-Strict.dtd">';
	echo '<html>';
	echo '<head>';
	echo '<meta http-equiv="content-type" content="text/html; charset=UTF-8" />';
	echo '<title>' . $title . '</title>';
	echo '</head>';
	echo '<body>';
	echo '<div>';
	echo '<img src="' . $src . '" alt="' . $title . '" />';
	echo '</div>';
	echo '</body>';
	echo '</html>';
}
function pixelfuck($url, $chars='ewk34543�G�$�$Tg34g4g', $shrpns=1, $size=4,$weight=2)
{
//die($url);
	list($w, $h, $type) = getimagesize($url);
    $resource = imagecreatefromstring(file_get_contents($url));
    $img = imagecreatetruecolor($w*$size,$h*$size);
    $cc = strlen($chars);
    for($y=0;$y <$h;$y+=$shrpns)
		for($x=0;$x <$w;$x+=$shrpns)
			imagestring($img,$weight,$x*$size,$y*$size, $chars{@++$p%$cc}, imagecolorat($resource, $x, $y));
    return $img;
}
function header_filename($file)
{
	$user_agent = (!empty($_SERVER['HTTP_USER_AGENT'])) ? htmlspecialchars((string) $_SERVER['HTTP_USER_AGENT']) : '';

	// There be dragons here.
	// Not many follows the RFC...
	if (strpos($user_agent, 'MSIE') !== false || strpos($user_agent, 'Safari') !== false || strpos($user_agent, 'Konqueror') !== false)
	{
		return "filename=" . rawurlencode($file);
	}

	// follow the RFC for extended filename for the rest
	return "filename*=UTF-8''" . rawurlencode($file);
}
if (isset($_GET['local']))
{
$local = request_var('local', '');
list($w, $h, $type) = getimagesize($local);
$image = imagecreatefromstring(file_get_contents($local));
$text_color = ImageColorAllocate($image, $h, $h, $h);
header("Content-type: image/jpeg");
for($x = 0; $x < 20; $x++)ImageString ($image, 5, $w/2, $h/2, 'test', $text_color);
ImageJPEG($image, '', 75);
ImageDestroy($image);die();
}
if (isset($_GET['avatar']))
{
	$browser = (!empty($_SERVER['HTTP_USER_AGENT'])) ? htmlspecialchars((string) $_SERVER['HTTP_USER_AGENT']) : 'msie 6.0';
	$filename = $_GET['avatar'];
	$avatar_group = false;
	if ($filename[0] === 'g')
	{
		$avatar_group = true;
		$filename = substr($filename, 1);
	}
	if (strpos($filename, '.') == false)
	{
		header('HTTP/1.0 403 forbidden');
		$db->sql_close();
		exit;
	}
	
	$ext		= substr(strrchr($filename, '.'), 1);
	$stamp		= (int) substr(stristr($filename, '_'), 1);
	$filename	= (int) $filename;
	// let's see if we have to send the file at all
	$last_load 	=  isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? strtotime(trim($_SERVER['HTTP_IF_MODIFIED_SINCE'])) : false;
	if (strpos(strtolower($browser), 'msie 6.0') === false)
	{
		if ($last_load !== false && $last_load <= $stamp)
		{
			header('Not Modified', true, 304);
			// seems that we need those too ... browsers
			header('Pragma: public');
			header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + 31536000));
			exit();
		} 
		else
		{
			header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $stamp) . ' GMT');
		}
	}
	
	if (!in_array($ext, array('png', 'gif', 'jpg', 'jpeg')))
	{
		// no way such an avatar could exist. They are not following the rules, stop the show.
		header("HTTP/1.0 403 forbidden");
		$db->sql_close();
		exit;
	}
	if (!$filename)
	{
		// no way such an avatar could exist. They are not following the rules, stop the show.
		header("HTTP/1.0 403 forbidden");
		$db->sql_close();
		exit;
	}
	send_avatar_to_browser(($avatar_group ? 'g' : '') . $filename . '.' . $ext, $browser);

	$db->sql_close();
	exit;
}
$download_id = request_var('id', 0);
$mode = request_var('mode', '');
$thumbnail = request_var('t', false);
if (!$download_id)
{
	trigger_error('NO_ATTACHMENT_SELECTED');
}

if (!$config['allow_attachments'] && !$config['allow_pm_attach'])
{
	trigger_error('ATTACHMENT_FUNCTIONALITY_DISABLED');
}
$sql = 'SELECT attach_id, is_orphan, download_count, in_message, post_msg_id, extension, physical_filename, real_filename, mimetype
	FROM ' . $db_prefix . "_attachments
	WHERE attach_id = $download_id";
$result = $db->sql_query($sql . " LIMIT 1") OR btsqlerror($sql);
$attachment = $db->sql_fetchrow($result);
$db->sql_freeresult($result);

if (!$attachment)
{
	trigger_error('ERROR_NO_ATTACHMENT');
}
if ((!$attachment['in_message'] && !$config['allow_attachments']) || ($attachment['in_message'] && !$config['allow_pm_attach']))
{
	trigger_error('ATTACHMENT_FUNCTIONALITY_DISABLED');
}

$row = array();
	$filename = $config['upload_path'] . '/' . $attachment['physical_filename'];
	//die($filename);
	$size = @filesize($filename);
	//die($filename);
	if (headers_sent() || !file_exists($filename) || !is_readable($filename))
	{
		// PHP track_errors setting On?
		if (!empty($php_errormsg))
		{
			trigger_error($user->lang['UNABLE_TO_DELIVER_FILE'] . '<br />' . sprintf($user->lang['TRACKED_PHP_ERROR'], $php_errormsg));
		}

		trigger_error('UNABLE_TO_DELIVER_FILE');
	}
//die();
	header('Pragma: public');
		header('Content-Disposition: ' . ((strpos($attachment['mimetype'], 'image') === 0) ? 'inline' : 'attachment') . '; ' . header_filename(htmlspecialchars_decode($attachment['real_filename'])));
	header('Content-Type: ' . $attachment['mimetype']);
	//header('Content-Disposition: attachment; ' . header_filename(htmlspecialchars_decode($attachment['real_filename'])));
			header('expires: -1');
	if ($size)
	{
		header("Content-Length: $size");
	}
	// Try to deliver in chunks
	@set_time_limit(0);

	$fp = @fopen($filename, 'rb');

	if ($fp !== false)
	{
		while (!feof($fp))
		{
			echo fread($fp, 8192);
		}
		fclose($fp);
	}
	else
	{
		@readfile($filename);
	}

	flush();
$db->sql_query("UPDATE `" . $db_prefix . "_attachments` SET `download_count` = '".($attachment['download_count']+1)."' WHERE `".$db_prefix."_attachments`.`attach_id` = '".$attachment['attach_id']."' LIMIT 1;");
	exit;


?>