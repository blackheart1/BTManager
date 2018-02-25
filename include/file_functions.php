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
** File file_functions.php 2018-02-18 14:32:00 joeroberts
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT'))
{
	include_once './../security.php';
	die ();
}
function file_md5($file)
{
	$contents = file_contents($file);
	if (isset($contents))
	{
		$md5 = md5($contents);
		return $md5;
	}
	else
	{
		return(false);
	}
}
function file_create($file, $contents, $overwrite = false)
{
	if (!file_exists($file))
	{
		//opens the file for editing
		$editfile = fopen($file, "w");
		//writes to the file
		fwrite($editfile, $contents);
		//saves the file
		fclose($editfile);
		return(true);
	}
	elseif ($overwrite)
	{
		//opens the file for editing
		$editfile = fopen($file, "w");
		//writes to the file
		fwrite($editfile, $contents);
		//saves the file
		fclose($editfile);
		return(true);
	}
	else
	{
		return(false);
	}
}

function file_copy($source, $destination)
{
	if (file_exists($destination))
	{
		unlink($destination);
	}
	copy($source, $destination);
}

function file_contents($file)
{
	if (file_exists($file))
	{
		return file_get_contents($file);
	}
	else
	{
		return(false);
	}
}

function file_edited_check($file, $find)
{
	if (file_exists($file))
	{
		//request for all the text inside the file
		$viewfile = file_get_contents($file);
		//checks if the file has already been changed
		$test = explode($find, $viewfile);
		if (@$test['1'])
		{
			return(true);
		}
		else
		{
			return(false);
		}
	}
	else
	{
		return('error');
	}
}

function file_add_after($file, $find, $add)
{
	if (file_exists($file))
	{
		//request for all the text inside the file
		$viewfile = file_get_contents($file);
		//checks if the file has already been changed
		$test = explode($add, $viewfile);
		if (@!$test['1'])
		{
			//splits the document where the find value is in the document
			$split = explode($find, $viewfile);
			if (@$split ['1'])
			{
				//builds the file back together with the new text
				$newfile = $split['0'] . $find . "\n\n" . $add . $split['1'];
				if (@$split ['2'])
				{
					$newfile .= $find . $split['2'];
				}
				if (@$split ['3'])
				{
					$newfile .= $find . $split['2'];
				}
				if (@$split ['4'])
				{
					$newfile .= $find . $split['2'];
				}
				if (@$split ['5'])
				{
					$newfile .= $find . $split['2'];
				}
				//opens the file for editing
				$editfile = fopen($file, "w");
				//writes to the file
				fwrite($editfile, $newfile);
				//saves the file
				fclose($editfile);
				return(true);
			}
			else
			{
				return('error');
			}
		}
	}
	else
	{
		return(false);
	}
}

function file_add_before($file, $find, $add)
{
	if (file_exists($file))
	{
		//request for all the text inside the file
		$viewfile = file_get_contents($file);
		//checks if the file has already been changed
		$test = explode($add, $viewfile);
		if (@!$test['1'])
		{
			//splits the document where the find value is in the document
			$split = explode($find, $viewfile);
			if (@$split ['1'])
			{
				//builds the file back together with the new text
				$newfile = $split['0'] . $add . "\n\n" . $find . $split['1'];
				if (@$split ['2'])
				{
					$newfile .= $find . $split['2'];
				}
				if (@$split ['3'])
				{
					$newfile .= $find . $split['2'];
				}
				if (@$split ['4'])
				{
					$newfile .= $find . $split['2'];
				}
				if (@$split ['5'])
				{
					$newfile .= $find . $split['2'];
				}
				//opens the file for editing
				$editfile = fopen($file, "w");
				//writes to the file
				fwrite($editfile, $newfile);
				//saves the file
				fclose($editfile);
				return(true);
			}
			else
			{
				return('error');
			}
		}
	}
	else
	{
		return(false);
	}
}

function file_replace($file, $find, $replace)
{
	if (file_exists($file))
	{
		//request for all the text inside the file
		$viewfile = file_get_contents($file);
		//checks if the file has already been changed
		$test = @explode($replace, $viewfile);
		if (@!$test['1'])
		{
			//splits the document where the find value is in the document
			$split = explode($find, $viewfile);
			//builds the file back together with the new text in place of the old text
			@$newfile = $split['0'] . $replace . $split['1'];
			//opens the file for editing
			$editfile = fopen($file, "w");
			//writes to the file
			fwrite($editfile, $newfile);
			//saves the file
			fclose($editfile);
			return(true);
		}
	}
	else
	{
		return(false);
	}
}

function file_remove($file, $remove)
{
	if (file_exists($file))
	{
		//request for all the text inside the file
		$viewfile = file_get_contents($file);
		//splits the document where the find value is in the document
		$split = @explode($remove, $viewfile);
		if (@$split['1'])
		{
			//builds the file back together with the new text in place of the old text
			@$newfile = $split['0'] . $split['1'];
			//opens the file for editing
			$editfile = fopen($file, "w");
			//writes to the file
			fwrite($editfile, $newfile);
			//saves the file
			fclose($editfile);
			return(true);
		}
	}
	else
	{
		return(false);
	}
}

function file_compare($file, $file2)
{
	if (file_exists($file) && file_exists($file))
	{
		$viewfile = file_get_contents($file);
		$viewfile2 = file_get_contents($file2);
		if ($viewfile == $viewfile2)
		{
			return(true);
		}
	}
	else
	{
		return(false);
	}
}

function file_temp_name($ext)
{
	$name = md5(rand() * time());
	$s = rand(1, 10) . '-';
	$l = rand(5, 10) . '-';
	$name = substr($name, $s, $l);
	$name .= $ext;
	return($name);
}

function file_rename($file, $new_file, $overwrite = false)
{
	if (file_exists($file))
	{
		if (!file_exists($new_file))
		{
			rename($file, $new_file);
			return(true);
		}
		elseif ($overwrite)
		{
			unlink($new_file);
			rename($file, $new_file);
			return(true);
		}
		else
		{
			return(false);
		}
	}
	else
	{
		return(false);
	}
}

function dir_create($dir)
{
	if (!file_exists($dir))
	{
		mkdir($dir);
		return(true);
	}
	else
	{
		return(false);
	}
}

function dir_get_files($dir)
{
	$count = 0;
	$files = scan_dir($dir);
	foreach($files as $file)
	{
		if (is_file($dir . '/' . $file))
		{
			$file_list[$count] = $file;
			$count += 1;
		}
	}
	if (isset($file_list))
	{
		return($file_list);
	}
}

function dir_get_dirs($dir)
{
	$count = 0;
	$dirs = scan_dir($dir);
	foreach($dirs as $dir2)
	{
		if (is_dir($dir . '/' . $dir2))
		{
			$dir_list[$count] = $dir2;
			$count += 1;
		}
	}
	if (isset($dir_list))
	{
		return($dir_list);
	}
}

function dir_count_files($dir)
{
	if (is_dir($dir))
	{
		$count = 0;
		$files = scan_dir($dir);
		foreach($files as $file)
		{
			if (is_file($dir . '/' . $file))
			{
				$count += 1;
			}
		}
		return($count);
	}
}

function dir_count_dirs($dir)
{
	if (is_dir($dir))
	{
		$count = 0;
		$files = scan_dir($dir);
		foreach($files as $file)
		{
			if (is_dir($dir . '/' . $file))
			{
				$count += 1;
			}
		}
		$count -= 2;
		return($count);
	}
}
function scan_dir($dir)
{
	$dir_contents = array();
	if ($handle = opendir($dir)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				array_push($dir_contents, $file);
			}
		}
		return $dir_contents;
		closedir($handle);
	}
}

function dir_delete($dir, $deletefiles = false)
{
	if (@rmdir($dir))
	{
		return(true);
	}
	elseif (file_exists($dir))
	{
		if ($deletefiles)
		{
			$files = scan_dir($dir);
	
			foreach($files as $file)
			{
				$file2 = $dir . '/' . $file;
				if (!is_dir($file2))
				{
					if (is_file($file2))
					{
						unlink($file2);
					}
				}
				else
				{
					if ($file != '.' && $file != '..')
					{
						dir_delete($dir . '/' . $file, true);
					}
				}
			}
			if (@rmdir($dir))
			{
				return(true);
			}
			else
			{
				return(false);
			}
		}
		else
		{
			return(false);
		}
	}
}

function get_file_size($file) {
    $kb = 1024;
    $mb = 1024 * $kb;
    $gb = 1024 * $mb;
    $tb = 1024 * $gb;
	if ($file) {
		$size = filesize($file);
		if ($size < $kb) {
			$file_size = "$size Bytes";
		}
		elseif ($size < $mb) {
			$final = round($size/$kb, 2);
			$file_size = "$final KB";
		}
		elseif ($size < $gb) {
			$final = round($size/$mb, 2);
			$file_size = "$final MB";
		}
		elseif($size < $tb) {
			$final = round($size/$gb, 2);
			$file_size = "$final GB";
		} else {
			$final = round($size/$tb, 2);
			$file_size = "$final TB";
		}
	} else {
		return(false);
	}
	return($file_size);
}

function convert_file_size($size) {
    $kb = 1024;
    $mb = 1024 * $kb;
    $gb = 1024 * $mb;
    $tb = 1024 * $gb;
	if ($size < $kb) {
		$file_size = "$size Bytes";
	}
	elseif ($size < $mb) {
		$final = round($size/$kb, 2);
		$file_size = "$final KB";
	}
	elseif ($size < $gb) {
		$final = round($size/$mb, 2);
		$file_size = "$final MB";
	}
	elseif($size < $tb) {
		$final = round($size/$gb, 2);
		$file_size = "$final GB";
	} else {
		$final = round($size/$tb, 2);
		$file_size = "$final TB";
	}
	return($file_size);
}

function getmod($filename) {
   $val = 0;
   $perms = fileperms($filename);
   // Owner; User
   $val += (($perms & 0x0100) ? 0x0100 : 0x0000); //Read
   $val += (($perms & 0x0080) ? 0x0080 : 0x0000); //Write
   $val += (($perms & 0x0040) ? 0x0040 : 0x0000); //Execute
 
   // Group
   $val += (($perms & 0x0020) ? 0x0020 : 0x0000); //Read
   $val += (($perms & 0x0010) ? 0x0010 : 0x0000); //Write
   $val += (($perms & 0x0008) ? 0x0008 : 0x0000); //Execute
 
   // Global; World
   $val += (($perms & 0x0004) ? 0x0004 : 0x0000); //Read
   $val += (($perms & 0x0002) ? 0x0002 : 0x0000); //Write
   $val += (($perms & 0x0001) ? 0x0001 : 0x0000); //Execute

   // Misc
   $val += (($perms & 0x40000) ? 0x40000 : 0x0000); //temporary file (01000000)
   $val += (($perms & 0x80000) ? 0x80000 : 0x0000); //compressed file (02000000)
   $val += (($perms & 0x100000) ? 0x100000 : 0x0000); //sparse file (04000000)
   $val += (($perms & 0x0800) ? 0x0800 : 0x0000); //Hidden file (setuid bit) (04000)
   $val += (($perms & 0x0400) ? 0x0400 : 0x0000); //System file (setgid bit) (02000)
   $val += (($perms & 0x0200) ? 0x0200 : 0x0000); //Archive bit (sticky bit) (01000)

   return $val;
}

function create_thumb($src_image, $dest_file, $max_size)
{
	if (file_exists($src_image))
	{
		$size = getimagesize($src_image);
		
		if($size[0] > $size[1]) {
		  $divisor = $size[0] / $max_size;
		}
		else {
		  $divisor = $size[1] / $max_size;
		}
	
		$new_width = $size[0] / $divisor;
		$new_height = $size[1] / $divisor;
		
		settype($new_width, 'integer');
		settype($new_height, 'integer');
		
		$src_type = filetype($src_image);
		
		$src_type = array_pop(explode('.', $dest_file));

		if ($src_type == 'jpeg' || $src_type == 'jpg' || $src_type == 'pjpeg')
		{
			$src_image_big = imagecreatefromjpeg($src_image);
		}
		elseif ($src_type == 'png')
		{
			$src_image_big = imagecreatefrompng($src_image);
		}
		elseif ($src_type == 'gif')
		{
			$src_image_big = imagecreatefromgif($src_image);
		}
		else
		{
			return false;
		}

		$src_image_small = imagecreatetruecolor($new_width, $new_height);

		imagecopyresampled($src_image_small, $src_image_big, 0,0, 0,0, $new_width,$new_height, $size[0],$size[1]);

		imagedestroy($src_image_big);		

		if ($src_type == 'jpeg' || $src_type == 'jpg' || $src_type == 'pjpeg')
		{
			imagejpeg($src_image_small, $dest_file, 100);
		}
		elseif ($src_type == 'png')
		{
			imagepng($src_image_small, $dest_file, 100);
		}
		elseif ($src_type == 'gif')
		{
			imagegif($src_image_small, $dest_file, 100);
		}
		else
		{
			return false;
		}
		
		return true;
	}
	else
	{
		return false;
	}
}

function get_file_type($file)
{		
	return array_pop(explode('.', $file));
}

/**
 * xml2array() will convert the given XML text to an array in the XML structure.
 * Link: http://www.bin-co.com/php/scripts/xml2array/
 * Arguments : $contents - The XML text
 *                $get_attributes - 1 or 0. If this is 1 the function will get the attributes as well as the tag values - this results in a different array structure in the return value.
 * Return: The parsed XML in an array form.
 */
function xml2array($contents, $get_attributes=1) {
    if(!$contents) return array();

    if(!function_exists('xml_parser_create')) {
        //print "'xml_parser_create()' function not found!";
        return array();
    }
    //Get the XML parser of PHP - PHP must have this module for the parser to work
    $parser = xml_parser_create();
    xml_parser_set_option( $parser, XML_OPTION_CASE_FOLDING, 0 );
    xml_parser_set_option( $parser, XML_OPTION_SKIP_WHITE, 1 );
    xml_parse_into_struct( $parser, $contents, $xml_values );
    xml_parser_free( $parser );

    if(!$xml_values) return;//Hmm...

    //Initializations
    $xml_array = array();
    $parents = array();
    $opened_tags = array();
    $arr = array();

    $current = &$xml_array;

    //Go through the tags.
    foreach($xml_values as $data) {
        unset($attributes,$value);//Remove existing values, or there will be trouble

        //This command will extract these variables into the foreach scope
        // tag(string), type(string), level(int), attributes(array).
        extract($data);//We could use the array by itself, but this cooler.

        $result = '';
        if($get_attributes) {//The second argument of the function decides this.
            $result = array();
            if(isset($value)) $result['value'] = $value;

            //Set the attributes too.
            if(isset($attributes)) {
                foreach($attributes as $attr => $val) {
                    if($get_attributes == 1) $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'
                    /**  :TODO: should we change the key name to '_attr'? Someone may use the tagname 'attr'. Same goes for 'value' too */
                }
            }
        } elseif(isset($value)) {
            $result = $value;
        }

        //See tag status and do the needed.
        if($type == "open") {//The starting of the tag '<tag>'
            $parent[$level-1] = &$current;

            if(!is_array($current) or (!in_array($tag, array_keys($current)))) { //Insert New tag
                $current[$tag] = $result;
                $current = &$current[$tag];

            } else { //There was another element with the same tag name
                if(isset($current[$tag][0])) {
                    array_push($current[$tag], $result);
                } else {
                    $current[$tag] = array($current[$tag],$result);
                }
                $last = count($current[$tag]) - 1;
                $current = &$current[$tag][$last];
            }

        } elseif($type == "complete") { //Tags that ends in 1 line '<tag />'
            //See if the key is already taken.
            if(!isset($current[$tag])) { //New Key
                $current[$tag] = $result;

            } else { //If taken, put all things inside a list(array)
                if((is_array($current[$tag]) and $get_attributes == 0)//If it is already an array...
                        or (isset($current[$tag][0]) and is_array($current[$tag][0]) and $get_attributes == 1)) {
                    array_push($current[$tag],$result); // ...push the new element into that array.
                } else { //If it is not an array...
                    $current[$tag] = array($current[$tag],$result); //...Make it an array using using the existing value and the new value
                }
            }

        } elseif($type == 'close') { //End of tag '</tag>'
            $current = &$parent[$level-1];
        }
    }

    return($xml_array);
}
function get_remote_file($host, $directory, $filename, &$errstr, &$errno, $port = 80, $timeout = 10)
{
	global $user;

	if ($fsock = @fsockopen($host, $port, $errno, $errstr, $timeout))
	{
		@fputs($fsock, "GET $directory/$filename HTTP/1.1\r\n");
		@fputs($fsock, "HOST: $host\r\n");
		@fputs($fsock, "Connection: close\r\n\r\n");

		$file_info = '';
		$get_info = false;

		while (!@feof($fsock))
		{
			if ($get_info)
			{
				$file_info .= @fread($fsock, 1024);
			}
			else
			{
				$line = @fgets($fsock, 1024);
				if ($line == "\r\n")
				{
					$get_info = true;
				}
				else if (stripos($line, '404 not found') !== false)
				{
					$errstr = $user->lang['FILE_NOT_FOUND'] . ': ' . $filename;
					return false;
				}
			}
		}
		@fclose($fsock);
	}
	else
	{
		if ($errstr)
		{
			$errstr = utf8_convert_message($errstr);
			return false;
		}
		else
		{
			$errstr = $user->lang['FSOCK_DISABLED'];
			return false;
		}
	}

	return $file_info;
}
?>