<?php 
/* 
*----------------------------phpMyBitTorrent V 3.0.0---------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
*-------------------   And Joe Robertson (aka joeroberts)   -------------------*
*-------------               http://www.p2pmania.it               -------------*
*------------ Based on the Bit Torrent Protocol made by Bram Cohen ------------*
*-------------              http://www.bittorrent.com             -------------*
*------------------------------------------------------------------------------*
*------------------------------------------------------------------------------* 
*--   This program is free software; you can redistribute it and/or modify   --* 
*--   it under the terms of the GNU General Public License as published by   --* 
*--   the Free Software Foundation; either version 2 of the License, or      --* 
*--   (at your option) any later version.                                    --* 
*--                                                                          --* 
*--   This program is distributed in the hope that it will be useful,        --* 
*--   but WITHOUT ANY WARRANTY; without even the implied warranty of         --* 
*--   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the          --* 
*--   GNU General Public License for more details.                           --* 
*--                                                                          --* 
*--   You should have received a copy of the GNU General Public License      --* 
*--   along with this program; if not, write to the Free Software            --* 
*-- Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA --* 
*--                                                                          --* 
*------------------------------------------------------------------------------* 
*------              2009 phpMyBitTorrent Development Team              ------* 
*-----------               http://phpmybittorrent.com               -----------* 
*------------------------------------------------------------------------------* 
*-----------------   Sunday, September 14, 2008 9:05 PM   ---------------------* 
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 bitbucket-upload.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/ 

if (defined('IN_PMBT'))
{
	die ("You can't include this file");
}
else
{
	define("IN_PMBT",true);
}
require_once("common.php");
require_once("include/torrent_functions.php");
$template = new Template();
$user->set_lang('bitbucket',$user->ulanguage);
set_site_var($user->lang['BITBUCKET_MANAGER']);
$totimg = 0;
function get_image_extension($filename, $include_dot = true, $shorter_extensions = true) {
  $image_info = @getimagesize($filename);
  if (!$image_info || empty($image_info[2])) {
    return false;
  }

  if (!function_exists('image_type_to_extension')) {
    /**
     * Given an image filename, get the file extension.
     *
     * @param $imagetype
     *   One of the IMAGETYPE_XXX constants.
     * @param $include_dot
     *   Whether to prepend a dot to the extension or not. Default to TRUE.
     * @param $shorter_extensions
     *   Whether to use a shorter extension or not. Default to TRUE.
     * @return
     *   A string with the extension corresponding to the given image type, or
     *   FALSE on failure.
     */
    function image_type_to_extensiona ($imagetype, $include_dot = true) {
      // Note we do not use the IMAGETYPE_XXX constants as these will not be
      // defined if GD is not enabled.
      $extensions = array(
        1  => 'gif',
        2  => 'jpeg',
        3  => 'png',
        4  => 'swf',
        5  => 'psd',
        6  => 'bmp',
        7  => 'tiff',
        8  => 'tiff',
        9  => 'jpc',
        10 => 'jp2',
        11 => 'jpf',
        12 => 'jb2',
        13 => 'swc',
        14 => 'aiff',
        15 => 'wbmp',
        16 => 'xbm',
		17 => 'JPG',
      );

      // We are expecting an integer between 1 and 16.
      $imagetype = (int)$imagetype;
      if (!$imagetype || !isset($extensions[$imagetype])) {
        return false;
      }

      return ($include_dot ? '.' : '') . $extensions[$imagetype];
    }
  }

  $extension = image_type_to_extension($image_info[2], $include_dot);
  if (!$extension) {
    return false;
  }

  if ($shorter_extensions) {
    $replacements = array(
      'jpeg' => 'jpg',
      'tiff' => 'tif',
    );
    $extension = strtr($extension, $replacements);
  }
  return $extension;
}
if(!$pmbt_cache->get_sql("bitbucket_config"))
{
	$sql = "SELECT * FROM `".$db_prefix."_img_bucket` LIMIT 0, 30 ";
	$res = $db->sql_query($sql);
	$bucketrow = $db->sql_fetchrow($res);
	$db->sql_freeresult($res);
	$pmbt_cache->set_sql("bitbucket_config", $bucketrow);
}
else
{
	$bucketrow = $pmbt_cache->get_sql("bitbucket_config");
}

if ($bucketrow["allow"]!='true')
{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BITBUCKET_CLOSED'],
					'MESSAGE'			=> $user->lang['BITBUCKET_CLOSED_EXP'],
				));
				echo $template->fetch('message_body.html');
				close_out();
} 
if(!checkaccess("u_can_use_bitbucket"))
{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $user->lang['ERROR_NOT_U_AUTH'],
				));
				echo $template->fetch('message_body.html');
				close_out();
} 
$max_size = $bucketrow['max_file_size'];          //maximum filesize71096
$outtopage = '';
$attachment	= request_var('attachment', '',true,false,true);
//if($error = codeToMessage($attachment['error']))die($error);
//die(print_r($attachment));
//$attachment	= $_FILES['attachment'];
if (is_uploaded_file($attachment['tmp_name']))
{
	if ($attachment['size'] > $max_size)
	{
					$template->assign_vars(array(
						'S_ERROR'			=> true,
						'S_FORWARD'			=> false,
						'TITTLE_M'			=> $user->lang['BIT_FILE_TO_BIG'],
						'MESSAGE'			=> sprintf($user->lang['BIT_FILE_TO_BIG_EXP'],$attachment['size'],$max_size),
					));
					echo $template->fetch('message_body.html');
					close_out();
	}
	if (($attachment['type']=="image/gif") || ($attachment['type']=="image/bmp") || ($attachment['type']=="image/png") || ($attachment['type']=="image/pjpeg") || ($attachment['type']=="image/jpeg") || ($attachment['type']=="image/JPG")) 
	{
	
		if(!is_dir("UserFiles/".$user->name))
		{
			@mkdir("UserFiles/".$user->name,0777);
		}
		if (GetFolderSize("UserFiles/".$user->name) > $bucketrow["max_folder_size"])
		{
					$template->assign_vars(array(
						'S_ERROR'			=> true,
						'S_FORWARD'			=> false,
						'TITTLE_M'			=> $user->lang['BITBUCKET_FULL'],
						'MESSAGE'			=> $user->lang['BITBUCKET_FULL_EXP'],
					));
					echo $template->fetch('message_body.html');
					close_out();
		}
		$res = copy($attachment['tmp_name'], "UserFiles/".$user->name .'/' .$attachment['name']);
	
		if (!$res)
		{ 
					$template->assign_vars(array(
						'S_ERROR'			=> true,
						'S_FORWARD'			=> false,
						'TITTLE_M'			=> $user->lang['SERVER_ERROR'],
						'MESSAGE'			=> $user->lang['SERVER_ERROR_EXP'],
					));
					echo $template->fetch('message_body.html');
					close_out();
		}
		else
		{
			@chmod("UserFiles/".$user->name .'/' .$attachment['name'], 0777);
			$upcount=1;
			//$outtopage = "window.opener.vB_Attachments.add(".$upcount.", '".$attachment['name']."', '".mksize($attachment['size'])."','UserFiles/".$user->name."/".$attachment['name']."');";
			preg_match_all('/imgsize=([^&]*)/i', $_SERVER["QUERY_STRING"], $imgsize_array);
			$imgsize_array = str_replace('imgsize=','',$imgsize_array[0]);
			preg_match_all('/img=([^&]*)/i', $_SERVER["QUERY_STRING"], $img_array);
			$img_array = str_replace('img=','',$img_array[0]);
			if (count($img_array) < 1)
			{
				$allimage = "?img=".$attachment['name'];
			}
			else
			{
				$allimage = "?img=".implode("&amp;img=", $img_array)."&amp;img=".$attachment['name'];
			}
		}
		foreach($img_array as $imgupd)
		{
			$upcount=$upcount+1;
			$imgupsize = filesize("UserFiles/".$user->name."/".$imgupd);
			//print_r($imgupsize);
			$outtopage .= "window.opener.vB_Attachments.add(".$upcount.", '".$imgupd."', '".mksize($imgupsize)."', 'UserFiles/".$user->name."/".$imgupd."');";
		}
		$outtopage .= "window.close();";
		echo "<br>";
		echo sprintf($user->lang['FILE_NAME'],$attachment['name'])." <br>\n";
		echo sprintf($user->lang['FILE_SIZE'],$attachment['size'])." <br>\n";
		echo sprintf($user->lang['FILE_TYPE'],$attachment['type'])."<br>\n";
		echo "</font>";
	}
	else
	{ 
					$template->assign_vars(array(
						'S_ERROR'			=> true,
						'S_FORWARD'			=> false,
						'TITTLE_M'			=> $user->lang['INVALID_FILE'],
						'MESSAGE'			=> $user->lang['INVALID_FILE_EXP'],
					));
					echo $template->fetch('message_body.html');
					close_out();
	}
}
$i = 0;
$imgdir = "UserFiles/".$user->name; // the directory, where your images are stored
  $allowed_types = array('png','jpg','jpeg','gif','JPG'); // list of filetypes you want to show
if (!is_dir($imgdir))@mkdir($imgdir,0777);  
  $dimg = @opendir($imgdir);
  while($imgfile = @readdir($dimg))
  {
   if(in_array(strtolower(substr($imgfile,-3)),$allowed_types))
   {
    $a_img[] = $imgfile;
    sort($a_img);
    reset ($a_img);
   }
  }
  $img_png = 0;
  $img_jpg = 0;
  $img_jpeg = 0;
  $img_gif = 0;
 $imagtotnum = 1; 
  $totimg = count($a_img); // total image number
   
  for($x=0; $x < $totimg; $x++)
  {
	$size = getimagesize($imgdir.'/'.$a_img[$x]);
	$img_png = 0;
	$img_jpg = 0;
	$img_jpeg = 0;
	$img_gif = 0;
	//echo get_image_extension("./".$imgdir.'/'.$a_img[$x],0);
	$imagtotnum = $imagtotnum + 1;
	$template->assign_block_vars('u_images', array(
   'IMAGE_SOURCE'					=>	$siteurl . '/' . $imgdir . '/' . $a_img[$x],
   'IMAGE_NAME'						=>	$a_img[$x],
   'IMAGE_ID'						=>	$imagtotnum,
   'IMAGE_SIZE'						=>	mksize(filesize("./".$imgdir.'/'.$a_img[$x])),
   'IMAGE_HEIGHT'					=>	$size[1],
   'IMAGE_WIDTH'					=>	$size[0],
   ));
  } 
$template->assign_vars(array(
        'I_FILES'            =>	$totimg, //sprintf($user->lang['BANNED_FOR'],$reson),
		'I_FOLDER_SIZE'		=>	mksize(GetFolderSize("UserFiles/".$user->name)),
		'I_MAX_FOLDER_SIZE'	=>	mksize($bucketrow["max_folder_size"]),
		'L_BTMNGR_EXP'		=>	sprintf($user->lang['BTMNGR_EXP'],'bmp, png, jpeg, jpeg, gif'),
		'L_BTGALLERY_EXP'	=>	sprintf($user->lang['BTGALLERY_EXP'],$siteurl . '/UserFiles/' . $user->name . '/image'),
		'L_IMAGE_STATS'		=>	sprintf($user->lang['IMAGE_STATS'],mksize(GetFolderSize("UserFiles/".$user->name)),$totimg),
));
		echo $template->fetch('bitbucket.html');
		close_out();
?>