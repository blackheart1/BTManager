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
** File bencoder-xml.php 2018-02-18 14:32:00 joeroberts
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT'))
{
	include_once './../../security.php';
	die ();
}


/*
WINDOWS WARNING
ICONV.DLL MUST BE IN C:\WINDOWS\SYSTEM OR
EXTENSION LOADING WILL FAIL
*/

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
function Bencode(&$node) {
        return Benc($node->first_child);
}

/*
CONSIDER THE FOLLOWING FUNCTIONS
PRIVATE. NEVER CALL THEM UNLESS
YOU'RE DEALING WITH NODES
*/
function Benc(&$node) {
        $type = null;
        $calcX = new DOMXPath($node->ownerDocument);
        $result = $calcX->evaluate("attribute::type",$node);

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
        $calcX = new DOMXPath($node->ownerDocument);
        $result = $calcX->evaluate("attribute::type",$node);

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
        $calcX = new DOMXPath($node->owner_document());
        $result = $calcX->evaluate("attribute::type",$node);

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
        $calcX = new DOMXPath($node->owner_document());
        $result = $calcX->evaluate("attribute::type",$node);

        if (empty($result) OR $result->nodeset[0]->value != "List") {
                trigger_error("Missing or wrong type attribute on node ".$node->tagname, E_USER_WARNING);
                return null;
        }
        unset($result);


        $ret = "l";
        $children = $calcX->evaluate("Item",$node);


        foreach ($children->nodeset as $child) $ret .= Benc($child);

        $ret .= "e";

        return $ret;
}

function Benc_dict(&$node) {
        $calcX = new DOMXPath($node->ownerDocument);
        $result = $calcX->evaluate("attribute::type",$node);

        if (empty($result) OR $result->nodeset[0]->value != "Dictionary") {
                trigger_error("Missing or wrong type attribute  on node ".$node->tagname, E_USER_WARNING);
                return null;
        }
        unset($result);

        $children = $calcX->evaluate("*",$node);

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