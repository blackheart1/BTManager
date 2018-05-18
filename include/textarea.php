<?php
/*
*----------------------------phpMyBitTorrent V 2.0-beta4-----------------------*
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
*------              ©2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-----------------   Sunday, September 14, 2008 9:05 PM   ---------------------*
*/

if (!defined('IN_PMBT')) die ("You can't access this file directly");
$textarea = new textarea();

class textarea {
				function open_textarea($open, $forum_name, $method, $action)
				{
				$open_text = '';
                 $open_text .= "<table border=\"0\" cellpadding=\"2\" cellspacing=\"3\" width=\"100%\">\n";
                 $open_text .= "<tr><td><HR SIZE=1 NOSHADE></td></tr>\n";
	             $open_text .= "<tr><td><p>".$open."</p></td><td>";
                 $open_text .= "<form name=\"" . $forum_name . "\" method=\"" . $method . "\" action=\"" . $action . "\">";
				 return $open_text;
				}
				function input($descr, $align='center', $colspan="2", $rows="10", $cols="80", $text="")
				{
				//$preview = str_replace('_','',$descr);
				$textarea = "<tr><td align=" . $align . " colspan=" . $colspan . "><p><textarea type=\"hidden\" id=\"" . $descr . "\"  name=\"" . $descr . "\" rows=" . $rows . " cols=" . $cols . ">" . $text . "</textarea><input type=\"button\" onclick=\"mypopup(" . $descr . ".value)\" value=\"preview!\"></p></td></tr>";
				return $textarea;
				}
				function quick_smilies($area = 'descr',$return = 'forumdata')
				{
                        global $db, $db_prefix;
						if(defined('INSETUP')) $root_dir = './../';
						else
						$root_dir = './';
				        $sql = "SELECT * FROM ".$db_prefix."_smiles ORDER BY id ASC LIMIT 14;";
                        $smile_res = $db->sql_query($sql);
                        if ($db->sql_numrows($smile_res) > 0) {
                        $smile_rows = $db->sql_fetchrowset($smile_res);
						$q_smile = '';
                        foreach ($smile_rows as $smile) {
                             $q_smile .= "<a onclick=\"comment_smile('".$smile["code"]."',".$return.".".$area.");\"><img src=\"{$root_dir}smiles/".$smile["file"]."\" border=\"0\" alt=\"".$smile["alt"]."\"></a>\n";
                             }
                         }

				return $q_smile;
				}
				function quick_bbcode($return,$area)
				{
                        global $db, $db_prefix, $textarea;
						if(defined('INSETUP')) $root_dir = './../';
						else
						$root_dir = './';

                        $quick_bb = '
                        <table width="56%" style="background-color:#C9C299" cellspacing=0 cellpadding=0>
                        <tr class=tablea_fc>
                        <td  align=center colspan=3><span class=smallfont>
                        <input type="radio" name="mode" id="radio_bbcodemode_1" value="0" title="normal Mode (alt+n)" accesskey="n" onclick="setmode(this.value)" checked="checked" /><label for="radio_bbcodemode_1">
                        Mode Normal</label>
                        <input type="radio" name="mode" id="radio_bbcodemode_2" value="1" title="enhanced Mode (alt+e)" accesskey="e" onclick="setmode(this.value)"  /><label for="radio_bbcodemode_2">
                        Mode Expert</label><br><br></span></td>
                        </tr>
                        <tr>
                        <td align=center>';
                        $quick_bb .= "<select id=fontselect".$area." 
                        onchange=fontformat(".$return.",this.options[this.selectedIndex].value,'font',".$area.")>
                        <option value=0>FONT</option>
                        <option value=arial><font face=\"arial\">Arial</font></option>
                        <option value=comic sans ms>Comic</option>
                        <option value=courier new>Courier New</option>
                        <option value=tahoma>Tahoma</option>
                        <option value=times new roman>Times New Roman</option>
                        <option value=verdana>Verdana</option>

                        </select>
                        <select id=sizeselect".$area." onchange=fontformat(".$return.",this.options[this.selectedIndex].value,'size',".$area.")>

                        <option value=0>Size</option>
                        <option value=1>Thery Small</option>
                        <option value=2>Small</option>
                        <option value=3>Normal</option>
                        <option value=4>Large</option>
                        <option value=5>X-Large</option>
                        </select>
                        <select id=colorselect".$area." 
                        onchange=fontformat(".$return.",this.options[this.selectedIndex].value,'color',".$area.")>
                        <option value=0>COLOR</option>
                        <option value=skyblue style=color:skyblue>sky blue</option>
                        <option value=royalblue style=color:royalblue>royal blue</option>
                        <option value=blue style=color:blue>blue</option>
                        <option value=darkblue style=color:darkblue>dark-blue</option>
                        <option value=orange style=color:orange>orange</option>
                        <option value=orangered style=color:orangered>orange-red</option>
                        <option value=crimson style=color:crimson>crimson</option>
                        <option value=red style=color:red>red</option>
                        <option value=firebrick style=color:firebrick>firebrick</option>
                        <option value=darkred style=color:darkred>dark red</option>
                        <option value=green style=color:green>green</option>
                        <option value=limegreen style=color:limegreen>limegreen</option>
                        <option value=seagreen style=color:seagreen>sea-green</option>
                        <option value=deeppink style=color:deeppink>deeppink</option>
                        <option value=tomato style=color:tomato>tomato</option>
                        <option value=coral style=color:coral>coral</option>
                        <option value=purple style=color:purple>purple</option>
                        <option value=indigo style=color:indigo>indigo</option>
                        <option value=burlywood style=color:burlywood>burlywood</option>
                        <option value=sandybrown style=color:sandybrown>sandy brown</option>
                        <option value=sienna style=color:sienna>sienna</option>
                        <option value=chocolate style=color:chocolate>chocolate</option>
                        <option value=teal style=color:teal>teal</option>
                        <option value=silver style=color:silver>silver</option>
                        </select>
                        </td>
  
                        </tr>
                        <tr>
                        <td align=center colspan=2>
                        <img src={$root_dir}images/bold.gif alt=Bold&nbsp;Text Text title=Bold&nbsp;Text Text border=0 onclick=bbcode(document." . $return .",'b',''," . $return .".".$area.") onmouseover=this.style.cursor='pointer'; />
                        <img src={$root_dir}images/italic.gif alt=Italic&nbsp;Text Text title=Italic&nbsp;Text Text border=0 onclick=bbcode(document." . $return .",'i',''," . $return .".".$area.") onmouseover=this.style.cursor='pointer'; />
                        <img src={$root_dir}images/underline.gif alt=Underlined&nbsp;Text Text title=Underlined&nbsp;Text Text border=0 onclick=bbcode(document." . $return .",'u',''," . $return .".".$area.") onmouseover=this.style.cursor='pointer'; />
                        <img src={$root_dir}images/justifycenter.gif alt=Center&nbsp;Text Text title=Centerd&nbsp;Text Text border=0 onclick=bbcode(document." . $return .",'center',''," . $return .".".$area.") onmouseover=this.style.cursor='pointer'; />
                        <img src={$root_dir}images/link.gif alt=Add&nbsp;Link einf&uuml;gen title=Add&nbsp;Link einf&uuml;gen border=0 onclick=namedlink(document." . $return .",'url'," . $return .".".$area.") onmouseover=this.style.cursor='pointer'; />
                        <img src={$root_dir}images/image.gif alt=Insert&nbsp;Image einf&uuml;gen title=Insert&nbsp;Image einf&uuml;gen border=0 onclick=bbcode(document." . $return .",'img','http://'," . $return .".".$area.") onmouseover=this.style.cursor='pointer'; />
                        <img src={$root_dir}images/copy.gif alt=Insert&nbsp;Quote einf&uuml;gen title=Insert&nbsp;Quote einf&uuml;gen border=0 onclick=bbcode(document." . $return .",'quote','',".$area.") onmouseover=this.style.cursor='pointer'; />
                        <img src={$root_dir}images/unorderedlist.gif alt=Add&nbsp;List title=Add&nbsp;List erstellen border=0 onclick=dolist(document." . $return .",".$area.") onmouseover=this.style.cursor='pointer'; />
                        <img src={$root_dir}images/source.gif alt=Insert&nbsp;Code einf&uuml;gen title=Insert&nbsp;Code einf&uuml;gen border=0 onclick=bbcode(document." . $return .",'code',''," . $return .".".$area.") onmouseover=this.style.cursor='pointer'; />
                        <img src={$root_dir}images/textfield.gif alt=Insert&nbsp;Syntax&nbsp;Highlighted&nbsp;PHP&nbsp;CODE title=Insert&nbsp;Syntax&nbsp;Highlighted&nbsp;PHP&nbsp;CODE border=0 onclick=bbcode(document." . $return .",'php',''," . $return .".".$area.") onmouseover=this.style.cursor='pointer'; /></td></tr><tr><td align=center>";
                                #Smiles
                        $quick_bb .= $textarea->quick_smilies($area,$return);
                        $quick_bb .= " </td></tr>";	
                        return $quick_bb;		
                        }	
						function text_close($type, $value, $type2, $name, $value2, $type3, $name2, $value3)
						{
						$close_text = '';
						$close_text .= "</table>\n";
                        $close_text .= "</p>";
                        $close_text .= "<p><input type=\"".$type."\" value=\"".$value."\"></p>";
                        $close_text .= "<input type=\"".$type2."\" name=\"".$name."\" value=\"".$value2."\"><input type=\"".$type3."\" name=\"".$name2."\" value=\"".$value3."\">";
                        $close_text .= "</form>";
                        $close_text .= "</td></tr>";
                        $close_text .= "</table>";
                        return $close_text;
						}
}
?>