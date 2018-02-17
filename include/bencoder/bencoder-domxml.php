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
*
* @package phpMyBitTorrent
* @version $Id: bencoder-domxml.php 1 2014-01-22 00:22:48Z joeroberts $
* @copyright (c) 2014 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT'))die("You can't access this file directly");

function unescape_hex($str) {
        if (!preg_match("/^[0-9a-f]*$/i",$str)){
                trigger_error("Invalid encoding. String is not hexadecimal.",E_USER_WARNING);
                return null;
        }
        return pack("H*", $str);
}

/*
THIS FUNCTION AUTOMATICALLY ACCESS
THE RECURSIVE FUNCTIONS FAMILY FOR
BENCODING. NONE OF THE OTHERS SHOULD
BE CALLED WHILE HANDLING A DOCUMENT
OBJECT. INSTEAD, THEY ARE GOOD
FOR SINGLE NODES
*/
function Bencode($node) {
$pass = $node->first_child();
        return Benc($pass);
}

/*
CONSIDER THE FOLLOWING FUNCTIONS
PRIVATE. NEVER CALL THEM UNLESS
YOU'RE DEALING WITH NODES
*/
function Benc(&$node) {
		$node_pass = $node->owner_document();
        $type = null;
        $calcX = xpath_new_context($node_pass);
        $result = xpath_eval($calcX,"attribute::type",$node);

        if (empty($result)) {
                trigger_error("Invalid encoding. Missing type attribute inside node ".$node->tagname, E_USER_WARNING);
                return null;
        } else $type = $result->nodeset[0]->value;
        unset($calcX, $result);

        switch ($type){
                case "Integer": {
                        return Benc_integer($node);
                        break;
                }
                case "String": {
                        return Benc_string($node);
                        break;
                }
                case "List": {
                        return Benc_list($node);
                        break;
                }
                case "Dictionary": {
                        return Benc_dict($node);
                        break;
                }
                default: {
                        trigger_error("Invalid encoding. Node type must be one of the following: String, Dictionary, List, Integer", E_USER_WARNING);
                        trigger_error("Node content: ".$node->get_content);
                        return null;
                }
        }
}
function Benc_integer(&$node) {
		$node_pass = $node->owner_document();
        $calcX = xpath_new_context($node_pass);
        $result = xpath_eval($calcX,"attribute::type",$node);

        if (empty($result) OR $result->nodeset[0]->value != "Integer") {
                trigger_error("Missing or wrong type attribute on node ".$node->tagname, E_USER_WARNING);
                return null;
        }
        unset($calcX, $result);

        $content = $node->get_content();

        if (!is_numeric($content)) {
                trigger_error("Invalid encoding. Value is not an integer number on node ".$node->tagname, E_USER_WARNING);
                return null;
        }

        return "i".$content."e";
}

function Benc_string(&$node) {
		$node_pass = $node->owner_document();
        $calcX = xpath_new_context($node_pass);
        $result = xpath_eval($calcX,"attribute::type",$node);

        if (empty($result) OR $result->nodeset[0]->value != "String") {
                trigger_error("Missing or wrong type attribute on node ".$node->tagname, E_USER_WARNING);
                return null;
        }
        unset($calcX, $result);

        $content = $node->get_content();

        if ($node->has_attribute("encode") AND $node->get_attribute("encode") == "hex") $content = unescape_hex($content);


        return strlen($content).":".$content;
}

function Benc_list(&$node) {
		$node_pass = $node->owner_document();
        $calcX = xpath_new_context($node_pass);
        $result = xpath_eval($calcX,"attribute::type",$node);

        if (empty($result) OR $result->nodeset[0]->value != "List") {
                trigger_error("Missing or wrong type attribute on node ".$node->tagname, E_USER_WARNING);
                return null;
        }
        unset($result);


        $ret = "l";
        $children = xpath_eval($calcX,"Item",$node);


        foreach ($children->nodeset as $child) $ret .= Benc($child);

        $ret .= "e";

        return $ret;
}

function Benc_dict(&$node) {
		$node_pass = $node->owner_document();
        $calcX = xpath_new_context($node_pass);
        $result = xpath_eval($calcX,"attribute::type",$node);

        if (empty($result) OR $result->nodeset[0]->value != "Dictionary") {
                trigger_error("Missing or wrong type attribute  on node ".$node->tagname, E_USER_WARNING);
                return null;
        }
        unset($result);

        $children = xpath_eval($calcX,"*",$node);

        $ret = "d";
        foreach ($children->nodeset as $child) {
                $name = $child->tagname;
                if ($child->has_attribute("tag_encode") AND $child->get_attribute("tag_encode") == "hex") $name = unescape_hex($name);
                elseif ($child->has_attribute("original")) $name = $child->get_attribute("original");

                $ret .= strlen($name).":".$name;
                $ret .= Benc($child);
        }

        $ret .= "e";

        return $ret;
}
/*
END OF PRIVATE FUNCTIONS
*/


?>