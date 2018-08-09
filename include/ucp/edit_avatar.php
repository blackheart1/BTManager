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
** File edit_avatar.php 2018-08-06 20:32:00 Thor
**
** CHANGES
**
**/

if (!defined('IN_PMBT'))
{
    include_once './../../security.php';
    die ();
}

$avatar_uploaded = false;

if ($_POST['delete'])
{
    //trigger_error('NO_TOPIC');

    // Deleting Any Previous Images
    $fhandle = opendir($avstore);

    while ($file = readdir($fhandle))
    {
        if (preg_match("/^" . $uname . "\.(gif|jpg|jpeg|png)$/si", $file)) @unlink($avstore . "/" . $file);
    }

    closedir($fhandle);

    $sqlfields[] = "avatar_type";
    $sqlvalues[] = "'0'";
    $sqlfields[] = "avatar_ht";
    $sqlvalues[] = "'0'";
    $sqlfields[] = "avatar_wt";
    $sqlvalues[] = "'0'";
    $sqlfields[] = "avatar";
    $sqlvalues[] = "'blank.gif'";
    $width       = '0';
    $height      = '0';
}
elseif (extension_loaded("gd"))
{
    $avupload  = request_var('avupload', '', true, false, true); //$_FILES["avupload"];
    $width     = request_var('width', 0);
    $height    = request_var('height', 0);
    $avgallery = request_var('avgallery', 'none');

    //die(print_r($avupload));

    if ($avuploadon && $avupload["name"] != "")
    {
        //die($avupload["name"]);

        $avatar_uploaded = true;
        $filename        = $avupload["name"];

        if (preg_match("/\.(gif|jpg|jpeg|png)$/", $filename))
        {
            $imageinfo = getimagesize($avupload["tmp_name"]);

            if ($width == '' || $width == 0) $width = $imageinfo[0];

            if ($height == '' || $height == 0) $height = $imageinfo[1];

            if ($width > $avmaxwt or $height > $avmaxht)
            {
                $errors[] = $user->lang['INVALID_SIZE'];

                unlink($avupload["tmp_name"]);
            }
            else
            {
                $newfname = preg_replace("/^([^\\\\:\/<>|*\"?])*\\.(gif|jpg|jpeg|png)$/si", $uname . ".\\2", $filename);

                // Deleting Any Previous Images
                $fhandle = opendir($avstore);

                while ($file = readdir($fhandle))
                {
                    if (preg_match("/^" . $uname . "\.(gif|jpg|jpeg|png)$/si", $file)) @unlink($avstore . "/" . $file);
                }

                closedir($fhandle);

                move_uploaded_file($avupload["tmp_name"], $avstore . "/" . $newfname);

                $sqlfields[] = "avatar_type";
                $sqlvalues[] = "'1'";
                $sqlfields[] = "avatar_ht";
                $sqlvalues[] = "'" . $height . "'";
                $sqlfields[] = "avatar_wt";
                $sqlvalues[] = "'" . $width . "'";
                $sqlfields[] = "avatar";
                $sqlvalues[] = "'" . $avstore . "/" . $newfname . "'";
            }
        }
        else
        {
            $errors[] = $user->lang['INVALID_IMAGE_TYPE'];

            unlink($avupload["tmp_name"]);
        }
    }

    /**
    ****************
    ** UPLOAD URL **
    ****************/

    elseif ($avremoteupon && $uploadurl !='')
    {
        $upload_ary = array();

        $upload_ary['local_mode'] = true;

        if (!preg_match('#^(https?://).*?\.(gif|jpg|jpeg|png)$#i', $uploadurl, $match))
        {
            bterror($errors, $user->lang['_URL_INVALID']);
        }

        if (empty($match[2]))
        {
            bterror($errors, $user->lang['INVALID_IMAGE_EXT']);
        }

        $url = parse_url($uploadurl);

        $host = $url['host'];
        $path = $url['path'];
        $port = (!empty($url['port'])) ? (int) $url['port'] : 80;

        $upload_ary['type'] = 'application/octet-stream';
        $url['path'] = explode('.', $url['path']);
        $ext = array_pop($url['path']);
        $url['path'] = implode('', $url['path']);
        $upload_ary['name'] = basename($url['path']) . (($ext) ? '.' . $ext : '');

        $filename = $url['path'];
        $filesize = 0;
        $errno    = 0;
        $errstr   = '';

        if (!($fsock = @fsockopen($host, $port, $errno, $errstr)))
        {
            bterror($errors, $user->lang['AVATAR_NOT_UPLOADED']);
        }

        // Make Sure $path Not Beginning With
        if (strpos($path, '/') === 0)
        {
            $path = substr($path, 1);
        }

        fputs($fsock, 'GET /' . $path . " HTTP/1.1\r\n");
        fputs($fsock, "HOST: " . $host . "\r\n");
        fputs($fsock, "Connection: close\r\n\r\n");

        $get_info = false;
        $data     = '';

        while (!@feof($fsock))
        {
           if ($get_info)
            {
                $data .= @fread($fsock, 1024);
            }
            else
            {
                $line = @fgets($fsock, 1024);

                if ($line == "\r\n")
                {
                    $get_info = true;
                }
                else
                {
                    if (stripos($line, 'content-type: ') !== false)
                    {
                        $upload_ary['type'] = rtrim(str_replace('content-type: ', '', strtolower($line)));
                    }
                    else if (stripos($line, '404 not found') !== false)
                    {
                        bterror($errors, $user->lang['_URL_NOT_FOUND']);
                    }
                }
            }
        }

        @fclose($fsock);

        if (empty($data))
        {
            bterror($errors, $user->lang['INVALID_REMOTE_DATA']);
        }

        $filename = $uname . '.' . $match[2];

        if (!($fp = @fopen("cache/" . $filename, 'wb')))
        {
            bterror($errors, $user->lang['AVATAR_NOT_UPLOADED']);
        }

        $upload_ary['size'] = fwrite($fp, $data);

        fclose($fp);
        unset($data);

        $imageinfo = getimagesize("cache/" . $filename);

        if ($width == '' || $width == 0) $width = $imageinfo[0];

        if ($height == '' || $height == 0) $height = $imageinfo[1];

        if ($width > $avmaxwt or $height > $avmaxht)
        {
           $errors[] = $user->lang['INVALID_SIZE'];

           unlink("cache/" . $filename);
        }
        elseif ($width < $avminwt or $height < $avminht)
        {
            $errors[] = $user->lang['INVALID_SIZE'];

            unlink("cache/" . $filename);
        }
        else
        {
            $newfname = preg_replace("/^([^\\\\:\/<>|*\"?])*\\.(gif|jpg|jpeg|png)$/si", $uname . ".\\2", $filename);

            // Deleting Any Previous Images
            $fhandle = opendir($avstore);

            while ($file = readdir($fhandle))
            {
                if (preg_match("/^" . $uname . "\.(gif|jpg|jpeg|png)$/si", $file)) @unlink($avstore . "/" . $file);
            }

            closedir($fhandle);

            copy("cache/" . $filename,$avstore . "/" . $newfname);
            unlink("cache/" . $filename);

            $sqlfields[] = "avatar_type";
            $sqlvalues[] = "'1'";
            $sqlfields[] = "avatar_ht";
            $sqlvalues[] = "'" . $height . "'";
            $sqlfields[] = "avatar_wt";
            $sqlvalues[] = "'" . $width . "'";
            $sqlfields[] = "avatar";
            $sqlvalues[] = "'" . $avstore . "/" . $newfname . "'";
        }
    }

    /**
    *****************
    ** REMOTE LINK **
    *****************/

    elseif ($avremoteupon && $remotelink !='')
    {
        if (!preg_match('#^(https?://).*?\.(gif|jpg|jpeg|png)$#i', $remotelink, $match))
        {
            bterror($errors, $user->lang['_URL_INVALID']);
        }

        if (empty($match[2]))
        {
            bterror($errors, $user->lang['_URL_INVALID']);

        }

        $imageinfo = @getimagesize($remotelink);
        if (!is_array($imageinfo) OR $imageinfo[0] <= 0)
        {
            bterror($errors, $user->lang['_URL_INVALID']);
        }

        if ($width == '' || $width == 0) $width = $imageinfo[0];

        if ($height == '' || $height == 0) $height = $imageinfo[1];

        if ($width > $avmaxwt or $height > $avmaxht)
        {
           $errors[] = $user->lang['INVALID_SIZE'];
        }
        elseif ($width < $avminwt or $height < $avminht)
        {
            $errors[] = $user->lang['INVALID_SIZE'];
        }
        else
        {
            $fhandle = opendir($avstore);

            while ($file = readdir($fhandle))
            {
                if (preg_match("/^" . $uname . "\.(gif|jpg|jpeg|png)$/si", $file)) @unlink($avstore . "/" . $file);
            }

            closedir($fhandle);

            $sqlfields[] = "avatar_type";
            $sqlvalues[] = "'2'";
            $sqlfields[] = "avatar_ht";
            $sqlvalues[] = "'" . $height . "'";
            $sqlfields[] = "avatar_wt";
            $sqlvalues[] = "'" . $width . "'";
            $sqlfields[] = "avatar";
            $sqlvalues[] = "'" . $remotelink . "'";
        }
    }
}
elseif ($avgalon and !$avatar_uploaded and isset($avgallery) and $avgallery != "none")
{
    $fhandle = opendir($avstore);

    while ($file = readdir($fhandle))
    {
        if (preg_match("/^" . $uname . "\.(gif|jpg|jpeg|png)$/si", $file)) @unlink($avstore . "/" . $file);
    }

    closedir($fhandle);

    $sqlfields[] = "avatar_type";
    $sqlvalues[] = "'3'";
    $sqlfields[] = "avatar_ht";
    $sqlvalues[] = "'0'";
    $sqlfields[] = "avatar_wt";
    $sqlvalues[] = "'0'";
    $sqlfields[] = "avatar";
    $sqlvalues[] = "'" . $avgal . "/" . $avgallery . "'";
    $width       = '0';
    $height      = '0';
}

if (count($errors) > 0)
{
    $msg = "<p>" . $user->lang['ALERT_ERROR'] . "</p>\n";
    $msg .= "<ul>\n";

    foreach ($errors as $msge)
    {
        $msg .= "<li><p>" . $msge . "</p></li>\n";
    }

    $msg .= "</ul>\n";

    set_site_var('- ' . $user->lang['USER_CPANNEL'] . ' - ' . $user->lang['BT_ERROR']);

    $template->assign_vars(array(
            'S_ERROR_HEADER' => $user->lang['EDIT_PROFILE'],
            'S_ERROR_MESS'   => $msg,
    ));

    echo $template->fetch('error.html');
    @include_once("include/cleanup.php");
    ob_end_flush();
    die();
}

if (count($sqlvalues) >= 1)
{
    $sql = "UPDATE " . $db_prefix . "_users SET ";

    for ($i = 0; $i < count($sqlfields); $i++) $sql .= $sqlfields[$i] ." = " . $sqlvalues[$i] . ", ";

    $sql .= "act_key = act_key WHERE id = '" . $uid . "';";

    if (!$db->sql_query($sql)) btsqlerror($sql);

    $userrow["avatar_ht"] = $height;
    $userrow["avatar_wt"] = $width;
}
?>