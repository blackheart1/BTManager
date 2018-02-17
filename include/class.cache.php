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
*------              �2010 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*--------------------   Sunday, May 17, 2009 1:05 AM   ------------------------*
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 cache.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
$pmbt_cache = new pmbt_cache();
class pmbt_cache {

	var $cache_dir = './';
	var $expire = '60';
	var $theme_expire = '60';


       function pmbt_cache()
	   {
			global $db, $db_prefix;
			$ch_con = $this->get_sql('cache');
			if(!$ch_con)
			{
				$sql = "SELECT * FROM ".$db_prefix."_cache_con;";
				$ch_con = array();
				$sql_query = $db->sql_query($sql);
				while ($row_attach = $db->sql_fetchrow($sql_query))
				{
					$ch_con[$row_attach['name']] = $row_attach['value'];
				}
				$db->sql_freeresult($sql_query);
				$this->cache_dir = $ch_con['cache_dir'] . '/';
				$this->expire = $ch_con['sql_time'];
				$this->theme_expire = $ch_con['theme_time'];
				$this->set_sql('cache', $ch_con);
			}
	   }
	   function get_sql($file, $expire = 60)
	   {
		   if($expire > $this->expire)$expire = $expire;
		   else
		   $expire = $this->expire;
          if (file_exists($this->cache_dir."sql_".md5($file).".php")) 
		  {
		  		  if(filemtime($this->cache_dir."sql_".md5($file).".php") < (time() - $expire))
		         {
		         $this->remove_file("sql_".md5($file).".php");
		         return false;
		         }

                 $record = unserialize(file_get_contents($this->cache_dir."sql_".md5($file).".php"));
				 return $record;
          }else{
		         return false;
		  }
	   }
       function get($file, $expire = 60)
	   {
	   if($expire > $this->expire)$expire = $expire;
	   else
	   $expire = $this->expire;
          if (file_exists($this->cache_dir.$file.".php")) 
		  {
		  		  if(filemtime($this->cache_dir.$file.".php") < (time() - $expire))
		         {
		         $this->remove_file($file.".php");
		         return false;
		         }

                 $record = unserialize(file_get_contents($this->cache_dir.$file.".php"));
				 return $record;
          }else{
		         return false;
		  }
	   }
	   function remove_file($filename)
    	{
          if (file_exists($this->cache_dir.$filename)) 
		  {
		//  echo $this->cache_dir.$filename;
    		if (!@unlink($this->cache_dir.$filename))
    		{
    			// E_USER_ERROR - not using language entry - intended.
    			trigger_error('Unable to remove files within ' . $this->cache_dir . $filename . '. Please check directory permissions.', E_USER_ERROR);
    		}
		}
    	}
	function obtain_icons()
	{
		if (($icons = $this->get('_icons')) === false)
		{
			global $db, $db_prefix;

			// Topic icons
			$sql = 'SELECT *
				FROM ' . $db_prefix . '_icons
				ORDER BY icons_order';
			$result = $db->sql_query($sql);

			$icons = array();
			while ($row = $db->sql_fetchrow($result))
			{
				$icons[$row['icons_id']]['img'] = $row['icons_url'];
				$icons[$row['icons_id']]['width'] = (int) $row['icons_width'];
				$icons[$row['icons_id']]['height'] = (int) $row['icons_height'];
				$icons[$row['icons_id']]['display'] = (bool) $row['display_on_posting'];
			}
			$db->sql_freeresult($result);

			$this->put('_icons', $icons);
		}

		return $icons;
	}
	function obtain_ranks()
	{
		if (($ranks = $this->get('_ranks')) === false)
		{
			global $db, $db_prefix;

			$sql = 'SELECT *
				FROM ' . $db_prefix . '_ranks
				ORDER BY rank_min DESC';
			$result = $db->sql_query($sql);

			$ranks = array();
			while ($row = $db->sql_fetchrow($result))
			{
				if ($row['rank_special'])
				{
					$ranks['special'][$row['rank_id']] = array(
						'rank_title'	=>	$row['rank_title'],
						'rank_image'	=>	$row['rank_image']
					);
				}
				else
				{
					$ranks['normal'][] = array(
						'rank_title'	=>	$row['rank_title'],
						'rank_min'		=>	$row['rank_min'],
						'rank_image'	=>	$row['rank_image']
					);
				}
			}
			$db->sql_freeresult($result);

			$this->put('_ranks', $ranks);
		}

		return $ranks;
	}
	function obtain_disallowed_usernames()
	{
		if (($usernames = $this->get('_disallowed_usernames')) === false)
		{
			global $db, $db_prefix;

			$sql = 'SELECT disallow_username
				FROM ' . $db_prefix . '_disallow';
			$result = $db->sql_query($sql);

			$usernames = array();
			while ($row = $db->sql_fetchrow($result))
			{
				$usernames[] = str_replace('%', '.*?', preg_quote(utf8_clean_string($row['disallow_username']), '#'));
			}
			$db->sql_freeresult($result);

			$this->put('_disallowed_usernames', $usernames);
		}

		return $usernames;
	}
	   function purge()
	   {
		// Purge all phpbb cache files
		$dir = @opendir($this->cache_dir);

		if (!$dir)
		{
			return;
		}
		while (($entry = readdir($dir)) !== false)
		{
			if (strpos($entry, 'html') === false && strpos($entry, 'sql_') === false && strpos($entry, 'cache_') !== 0 && strpos($entry, 'staff') !== 0 )
			{
				continue;
			}

			$this->remove_file($entry);
		}
		closedir($dir);
	   }
	   function put($file, $output)
	   {
	       $OUTPUT = serialize($output);
           $fp = fopen($this->cache_dir.$file.".php","w");
          fputs($fp, $OUTPUT);
          fclose($fp);
		  @chmod($this->cache_dir.$file.".php", 0755);
	   }
	   function set_sql($file, $output)
	   {
	       $OUTPUT = serialize($output);
           $fp = fopen($this->cache_dir."sql_".md5($file).".php","w");
          fputs($fp, $OUTPUT);
          fclose($fp);
		  @chmod($this->cache_dir."sql_".md5($file).".php", 0755);
	   }
	function obtain_attach_extensions($forum_id)
	{
		if (($extensions = $this->get('_extensions')) === false)
		{
			global $db, $db_prefix;

			$extensions = array(
				'_allowed_post'	=> array(),
				'_allowed_pm'	=> array(),
			);

			// The rule is to only allow those extensions defined. ;)
			$sql = 'SELECT e.extension, g.*
				FROM ' . $db_prefix . '_extensions e, ' . $db_prefix . '_extension_groups g
				WHERE e.group_id = g.group_id
					AND (g.allow_group = 1 OR g.allow_in_pm = 1)';
			$result = $db->sql_query($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				$extension = strtolower(trim($row['extension']));

				$extensions[$extension] = array(
					'display_cat'	=> (int) $row['cat_id'],
					'download_mode'	=> (int) $row['download_mode'],
					'upload_icon'	=> trim($row['upload_icon']),
					'max_filesize'	=> (int) $row['max_filesize'],
					'allow_group'	=> $row['allow_group'],
					'allow_in_pm'	=> $row['allow_in_pm'],
				);

				$allowed_forums = ($row['allowed_forums']) ? unserialize(trim($row['allowed_forums'])) : array();

				// Store allowed extensions forum wise
				if ($row['allow_group'])
				{
					$extensions['_allowed_post'][$extension] = (!sizeof($allowed_forums)) ? 0 : $allowed_forums;
				}

				if ($row['allow_in_pm'])
				{
					$extensions['_allowed_pm'][$extension] = 0;
				}
			}
			$db->sql_freeresult($result);

			$this->put('_extensions', $extensions);
		}

		// Forum post
		if ($forum_id === false)
		{
			// We are checking for private messages, therefore we only need to get the pm extensions...
			$return = array('_allowed_' => array());

			foreach ($extensions['_allowed_pm'] as $extension => $check)
			{
				$return['_allowed_'][$extension] = 0;
				$return[$extension] = $extensions[$extension];
			}

			$extensions = $return;
		}
		else if ($forum_id === true)
		{
			return $extensions;
		}
		else
		{
			$forum_id = (int) $forum_id;
				//die(print_r($extensions['_allowed_post']));
	$return = array('_allowed_' => array());

			foreach ($extensions['_allowed_post'] as $extension => $check)
			{
				// Check for allowed forums
				if (is_array($check))
				{
					$allowed = (!in_array($forum_id, $check)) ? false : true;
				}
				else
				{
					$allowed = true;
				}

				if ($allowed)
				{
					$return['_allowed_'][$extension] = 0;
					$return[$extension] = $extensions[$extension];
				}
			}

			$extensions = $return;
		}

		if (!isset($extensions['_allowed_']))
		{
			$extensions['_allowed_'] = array();
		}
//die(print_r($extensions));
		return $extensions;
	}
}
?>
