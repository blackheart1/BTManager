<?php
/**
*
* ucp [English]
*
* @package language
* @version $Id$
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}
$lang = array_merge($lang, array(
'CHOSE'			=> 'Choose',
'PL_AT_END'		=> 'Place at the end',
'PL_AFT_'		=> 'Place After ',
'PL_AT_BEGGIN'		=> 'Place at the begginning',
"SMILIES"		=> "Smilies",
"SMILIES_EXP"		=> "In this section you can manage Smilies that users may upload. Installation provides this tracker with some common Smilies for Shoutbox, Descriptions and Forum.
You can add your own ones or edit others. Be careful that every Smilie must be represented by a significant Tag for best experience. Images are in the smiles directory of the tracker's root directory.",
"NO_SET_SMILIES"		=> "No Smilies Are set",
"SMILE_CODE"		=> "Code",
"SM_IMAGECODE"		=> "Image/Smilie",
"SMILE_ALT"		=> "Alternat",
"SMILE_ALT_NAME"		=> "Alternat Name",
"SMILE_SELEC"		=> "Smile Code",
"SMILE_IMAGE"		=> "Smile Image",
"AD_EDIT_SMILE"		=> "Add/Edit Smilies",
'POSITION'			=> 'Position',
));
?>