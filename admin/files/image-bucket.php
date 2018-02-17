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
*------              ©2010 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*--------------------   Sunday, May 17, 2009 1:05 AM   ------------------------*
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 image-bucket.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
$user->set_lang('admin/image-bucket',$user->ulanguage);
	if(!isset($userfile)){
		$sql = "SELECT * FROM `".$db_prefix."_img_bucket` LIMIT 0, 30 ";
		$res = $db->sql_query($sql);
		$cfgrow = $db->sql_fetchrow($res);
		$db->sql_freeresult($res);
		$template->assign_vars(array(
				'S_SHOW_USER_IMAGES'		=> true,
		        'L_TITLE'            		=> $user->lang['TITLE'],
		        'L_TITLE_EXPLAIN'           => $user->lang['TITLE_EXPLAIN'],
				'U_ACTION'					=> "./admin.php?i=siteinfo&op=imagesettings",
				'SETTINGS'					=> true,
		));
	drawRow("allow","text", false ,$user->lang['HEADER_SETTINGS']);
	drawRow("allow","checkbox");
				$template->assign_block_vars('options', array(
					'S_LEGEND'		=> false,
					'LEGEND'		=> '',
					'S_EXPLAIN'		=> true,
					'TITLE'			=> (isset($user->lang["_admplevel"])) ? $user->lang["_admplevel"] : "_admplevel",
					'TITLE_EXPLAIN'	=> (isset($user->lang["_admplevelexplain"])) ? $user->lang["_admplevelexplain"] : "_admplevelexplain",
					'CONTENT'		=> "<select name=\"level[]\" style=\"width: 100%; height: 107px;\" multiple=\"multiple\">\n".group_select_options($cfgrow['level'], false, false)."</select>",
				));
	drawRow("max_folder_size","text");
	drawRow("max_file_size","text");
	}
	if ($op == "imagesettings"){
		$allow					= request_var('sub_allow', 'false');
		$level					= request_var('level', array(''));
		$max_folder_size		= request_var('sub_max_folder_size', 0);
		$max_file_size			= request_var('sub_max_file_size', 0);
        $sql = "INSERT INTO ".$db_prefix."_img_bucket (allow, level, max_folder_size, max_file_size) VALUES ('".$allow."', '".implode(';;',$level)."', '".$max_folder_size."', '".$max_file_size."');";
        if (!$db->sql_query($sql)) btsqlerror($sql);
        $db->sql_query("TRUNCATE TABLE ".$db_prefix."_img_bucket;");
        $db->sql_query($sql);
                                $template->assign_vars(array(
								        'S_SUCCESS'            => true,
										'S_FORWARD'			=> $siteurl."/admin.php?i=siteinfo&op=image-bucket",
								        'TITTLE_M'          => $user->lang['SUCCESS'],
                                        'MESSAGE'            => $user->lang['_admsaved'],
                                ));
		echo $template->fetch('message_body.html');
		close_out();
	}
	if ($op == "delimage"){
		if (file_exists("./UserFiles/".$file."/".$name))@unlink("./UserFiles/".$file."/".$name);
		if(!num_files("./UserFiles/".$file."/") > 0)@unlink("./UserFiles/".$file);
		else
		$userfile = $file;
	}
	if(!isset($userfile)){
		$sql = "SELECT * FROM `".$db_prefix."_img_bucket` LIMIT 0, 30 ";
		$res = $db->sql_query($sql);
		$bucketrow = $db->sql_fetchrow($res);
		$db->sql_freeresult($res);
        $themes = Array();
        $thememaindir = "UserFiles";
        $themehandle = opendir($thememaindir);
        while ($themedir = readdir($themehandle)) {
                if (is_dir($thememaindir."/".$themedir) AND $themedir != "." AND $themedir != ".." AND $themedir != "CVS")
                        $themes[$themedir] = $themedir;
        }
        closedir($themehandle);
        unset($thememaindir,$themedir);
		foreach ($themes as $key=>$val) {
			$template->assign_block_vars('userimage',array(
				'VAL'				=> $val,
				'VALFSIZE'			=> GetFolderSize("./UserFiles/".$val),
				'VALFILE_COUNT'		=> num_files("./UserFiles/".$val."/"),
			));
		}

unset($themes);
}else{
		$template->assign_vars(array(
				'U_ACTION'					=> "./admin.php",
				'SETTINGS'					=> false,
		));
$imgdir = "UserFiles/".$userfile."/"; // the directory, where your images are stored
  $allowed_types = array('png','jpg','jpeg','gif'); // list of filetypes you want to show
  
  $dimg = opendir($imgdir);
  while($imgfile = readdir($dimg))
  {
   if(in_array(strtolower(substr($imgfile,-3)),$allowed_types))
   {
    $a_img[] = $imgfile;
    sort($a_img);
    reset ($a_img);
   }
  }
 $imagtotnum = 1; 
  $totimg = count($a_img); // total image number
   
  for($x=0; $x < $totimg; $x++)
  {
   $size = getimagesize($imgdir.'/'.$a_img[$x]);
   $i++;
  $imagtotnum = $imagtotnum + 1;
   // do whatever
   $halfwidth = ceil($size[0]/2);
   $halfheight = ceil($size[1]/2);
						$hidden = build_hidden_fields(array(
							'name'		=> $a_img[$x],
							'i'			=> 'siteinfo',
							'op'		=> 'delimage',
							'file'		=> $userfile,
						));

	$template->assign_block_vars('images',array(
		'NAME'		=> $a_img[$x],
		'SIZE'		=> mksize(filesize("./".$imgdir.'/'.$a_img[$x])),
		'LINK'		=> $siteurl.'/'.$imgdir.$a_img[$x].'" target="_blank"',
		'SOURCE'		=> $siteurl.'/'.$imgdir.$a_img[$x],
		'HIDDEN'		=> $hidden,
	));

  } 
}
echo $template->fetch('admin/acp_image-bucket.html');
		close_out();
?>