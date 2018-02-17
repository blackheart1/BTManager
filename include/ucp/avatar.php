<?php
/*
*-----------------------------phpMyBitTorrent V 3.0.0--------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
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
*------              ©2011 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*/
/**
*
* @package phpMyBitTorrent
* @version $Id: avatar.php 1 2011-07-05 00:22:48Z joeroberts $
* @copyright (c) 2011 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
$galery = '';
$galery .= "<option value=\"none\">".$user->lang['CHOOSE_AVATAR']."</option>";
$galery .= "<option value=\"blank.gif\">".$user->lang['NONE']."</option>";
$dhandle = opendir("./".$avgal."/");
while ($file = readdir($dhandle)) {
        if (is_dir("./".$avgal."/".$file) OR $file == "blank.gif" OR !preg_match("/\.(gif|jpg|jpeg|png)/",$file)) continue;
        $galery .= "<option value=\"".$file."\">".$file."</option>";
}
$template->assign_vars(array(
        'CP_UAVATAR'            => gen_avatar($userrow["id"]),
		'ALLOW_AVATAR_UPLOAD'   => $avuploadon,
		'ALLOW_AVATAR_LINK'     => $avremoteon,
		'ALLOW_AVATAR_GALORY'   => $avgalon,
		'ALLOW_AVATAR'          => $avon,
		'AVATAR_SETHT'          => $userrow["avatar_ht"],
		'AVATAR_SETWT'          => $userrow["avatar_wt"],
		'AVATAR_MAXHT'          => $avmaxht,
		'AVATAR_MAXWT'          => $avmaxwt,
		'AVATAR_MAXSZ'          => mksize($avmaxsz),
		'AVATAR_MAXSZ_SEL'      => $galery,
		'AVATAR_GALORY'      	=> $avgal,
));

?>