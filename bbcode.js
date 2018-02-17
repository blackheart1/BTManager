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
*-------------------   Saturday, JUN 27, 2009 1:05 AM   -----------------------*
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 bbcode.js  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
var bbtags   = new Array();

// browser detection
var myAgent   = navigator.userAgent.toLowerCase();
var myVersion = parseInt(navigator.appVersion);
var is_ie   = ((myAgent.indexOf("msie") != -1)  && (myAgent.indexOf("opera") == -1));
var is_win   =  ((myAgent.indexOf("win")!=-1) || (myAgent.indexOf("16bit")!=-1));

function setmode(modeValue) {
 	document.cookie = "bbcodemode="+modeValue+"; path=/; expires=Wed, 1 Jan 2020 00:00:00 GMT;";
}

function mozWrap(txtarea, open, close)
{
	var selLength = txtarea.textLength;
	var selStart = txtarea.selectionStart;
	var selEnd = txtarea.selectionEnd;
	var scrollTop = txtarea.scrollTop;

	if (selEnd == 1 || selEnd == 2) 
	{
		selEnd = selLength;
	}

	var s1 = (txtarea.value).substring(0,selStart);
	var s2 = (txtarea.value).substring(selStart, selEnd)
	var s3 = (txtarea.value).substring(selEnd, selLength);

	txtarea.value = s1 + open + s2 + close + s3;
	txtarea.selectionStart = selEnd + open.length + close.length;
	txtarea.selectionEnd = txtarea.selectionStart;
	txtarea.focus();
	txtarea.scrollTop = scrollTop;

	return;
}
function insert_text(text, spaces, popup)
{
	var textarea;
	
	if (!popup) 
	{
		textarea = document.forms[form_name].elements[text_name];
	} 
	else 
	{
		textarea = opener.document.forms[form_name].elements[text_name];
	}
	if (spaces) 
	{
		text = ' ' + text + ' ';
	}
	
	if (!isNaN(textarea.selectionStart))
	{
		var sel_start = textarea.selectionStart;
		var sel_end = textarea.selectionEnd;

		mozWrap(textarea, text, '')
		textarea.selectionStart = sel_start + text.length;
		textarea.selectionEnd = sel_end + text.length;
	}	
	
	else if (textarea.createTextRange && textarea.caretPos)
	{
		if (baseHeight != textarea.caretPos.boundingHeight) 
		{
			textarea.focus();
			storeCaret(textarea);
		}		
		var caret_pos = textarea.caretPos;
		caret_pos.text = caret_pos.text.charAt(caret_pos.text.length - 1) == ' ' ? caret_pos.text + text + ' ' : caret_pos.text + text;
		
	}
	else
	{
		textarea.value = textarea.value + text;
	}
	if (!popup) 
	{
		textarea.focus();
	} 	

}
function attach_inline(index, filename)
{
	insert_text('[attachment=' + index + ']' + filename + '[/attachment]');
	document.forms[form_name].elements[text_name].focus();
}
function normalMode(theForm) {
	if (theForm.mode[0].checked) {
		return true;
	}
	else {
		return false;
	}
}

function getArraySize(theArray) {
 	for (i = 0; i < theArray.length; i++) {
  		if ((theArray[i] == "undefined") || (theArray[i] == "") || (theArray[i] == null)) return i;
	}
 	
 	return theArray.length;
}

function pushArray(theArray, value) {
 	theArraySize = getArraySize(theArray);
 	theArray[theArraySize] = value;
}

function popArray(theArray) {
	theArraySize = getArraySize(theArray);
 	retVal = theArray[theArraySize - 1];
 	delete theArray[theArraySize - 1];
 	return retVal;
}


function smilie(theSmilie) {
	addText(" " + theSmilie, "", false, document.bbform);
}

function closetag(theForm) {
 	if (!normalMode(theForm)) {
  		if (bbtags[0]) addText("[/"+ popArray(bbtags) +"]", "", false, theForm);
  	}
 	
 	setFocus(theForm);
}

function closeall(theForm) {
 	if (!normalMode(theForm)) {
  		if (bbtags[0]) {
   			while (bbtags[0]) {
    				addText("[/"+ popArray(bbtags) +"]", "", false, theForm);
   			}
   		}
 	}
 	
 	setFocus(theForm);
}


function fontformat(theForm,theValue,theType,area) {
 	setFocus(area);
 //alert(theValue);
 	if (normalMode(theForm)) {
  		if (theValue != 0) {
   
   			var selectedText = getSelectedText(area);
   			var insertText = prompt(font_formatter_prompt+" "+theType, selectedText);
   			if ((insertText != null) && (insertText != "")) {
    				addText("["+theType+"="+theValue+"]"+insertText+"[/"+theType+"]", "", false, theForm, area);
    			}
  		}
 	}
 	else {
		if(addText("["+theType+"="+theValue+"]", "[/"+theType+"]", true, theForm, area)) {
			pushArray(bbtags, theType);	
		}
	}
 
 	theForm.sizeselect.selectedIndex = 0;
 	theForm.fontselect.selectedIndex = 0;
 	theForm.colorselect.selectedIndex = 0;
 	
 	setFocus(area);
}


function bbcode(theForm, theTag, promptText, area) {
	//alert(theForm);
	if ( normalMode(theForm) || (theTag=="IMG")) {
		var selectedText = getSelectedText(area);
		if (promptText == '' || selectedText != '') promptText = selectedText;
		
		inserttext = prompt(((theTag == "IMG") ? (img_prompt) : (tag_prompt)) + "\n[" + theTag + "]xxx[/" + theTag + "]", promptText);
		if ( (inserttext != null) && (inserttext != "") ) {
			addText("[" + theTag + "]" + inserttext + "[/" + theTag + "]", "", false, theForm, area);
		}
	}
	else {
		var donotinsert = false;
  		for (i = 0; i < bbtags.length; i++) {
   			if (bbtags[i] == theTag) donotinsert = true;
  		}
  		
  		if (!donotinsert) {
   			if(addText("[" + theTag + "]", "[/" + theTag + "]", true, theForm, area)){
				pushArray(bbtags, theTag);
			}
  		}
		else {
			var lastindex = 0;
			
			for (i = 0 ; i < bbtags.length; i++ ) {
				if ( bbtags[i] == theTag ) {
					lastindex = i;
				}
			}
			
			while (bbtags[lastindex]) {
				tagRemove = popArray(bbtags);
				addText("[/" + tagRemove + "]", "", false, theForm, area);
			}
		}
	}
}

function namedlink(theForm,theType,area) {
	var selected = getSelectedText(area);
 
	var linkText = prompt(link_text_prompt,selected);
	var prompttext;
 
	if (theType == "url") {
 		prompt_text = link_url_prompt;
 		prompt_contents = "http://";
	}
	else {
		prompt_text = link_email_prompt;
		prompt_contents = "";
		}
 
	linkURL = prompt(prompt_text,prompt_contents);
 
 
	if ((linkURL != null) && (linkURL != "")) {
		var theText = '';
		
		if ((linkText != null) && (linkText != "")) {
   			theText = "["+theType+"="+linkURL+"]"+linkText+"[/"+theType+"]";
   		}
		else {
			theText = "["+theType+"]"+linkURL+"[/"+theType+"]";
		}
  		
  		addText(theText, "", false, theForm, area);
 	}
}


function dolist(theForm,area) {
 	listType = prompt(list_type_prompt, "");
 	if ((listType == "a") || (listType == "1")) {
  		theList = "[list="+listType+"]\n";
  		listEend = "[/list="+listType+"] ";
 	}
 	else {
  		theList = "[list]\n";
  		listEend = "[/list] ";
 	}
 	
 	listEntry = "initial";
 	while ((listEntry != "") && (listEntry != null)) {
  		listEntry = prompt(list_item_prompt, "");
  		if ((listEntry != "") && (listEntry != null)) theList = theList+"[*]"+listEntry+"\n";
 	}
 	
 	addText(theList + listEend, "", false, theForm, area);
}


function addText(theTag, theClsTag, isSingle, theForm, area)
{
	var isClose = false;
	var descr = area;
	var set=false;
  	var old=false;
  	var selected="";
  	
  	if(navigator.appName=="Netscape" &&  descr.textLength>=0 ) { // mozilla, firebird, netscape
  		if(theClsTag!="" && descr.selectionStart!=descr.selectionEnd) {
  			selected=descr.value.substring(descr.selectionStart,descr.selectionEnd);
  			str=theTag + selected+ theClsTag;
  			old=true;
  			isClose = true;
  		}
		else {
			str=theTag;
		}
		
		descr.focus();
		start=descr.selectionStart;
		end=descr.textLength;
		endtext=descr.value.substring(descr.selectionEnd,end);
		starttext=descr.value.substring(0,start);
		descr.value=starttext + str + endtext;
		descr.selectionStart=start;
		descr.selectionEnd=start;
		
		descr.selectionStart = descr.selectionStart + str.length;
		
		if(old) { return false; }
		
		set=true;
		
		if(isSingle) {
			isClose = false;
		}
	}
	if ( (myVersion >= 4) && is_ie && is_win) {  // Internet Explorer
		if(descr.isTextEdit) {
			descr.focus();
			var sel = document.selection;
			var rng = sel.createRange();
			rng.colapse;
			if((sel.type == "Text" || sel.type == "None") && rng != null){
				if(theClsTag != "" && rng.text.length > 0)
					theTag += rng.text + theClsTag;
				else if(isSingle)
					isClose = true;
	
				rng.text = theTag;
			}
		}
		else{
			if(isSingle) isClose = true;
	
			if(!set) {
      				descr.value += theTag;
      			}
		}
	}
	else
	{
		if(isSingle) isClose = true;

		if(!set) {
      			descr.value += theTag;
      		}
	}

	descr.focus();
	
	return isClose;
}	


function getSelectedText(theForm) {
	var descr = theForm;
	var selected = '';
	
	if(navigator.appName=="Netscape" &&  descr.textLength>=0 && descr.selectionStart!=descr.selectionEnd ) 
  		selected=descr.value.substring(descr.selectionStart,descr.selectionEnd);	
  	
	else if( (myVersion >= 4) && is_ie && is_win ) {
		if(descr.isTextEdit){ 
			descr.focus();
			var sel = document.selection;
			var rng = sel.createRange();
			rng.colapse;
			
			if((sel.type == "Text" || sel.type == "None") && rng != null){
				if(rng.text.length > 0) selected = rng.text;
			}
		}	
	}
		 
  	return selected;
}

function setFocus(theForm) {
 	theForm.focus();
}

function getAppletText(theForm) {

}

function resetAppletText() {

}

function getMessageLength(theform) {

	return theform.message.value.length;

}







var postmaxchars = 10000;
function validate(theform) {
 getAppletText(theform);
 if (theform.message.value=="" || theform.topic.value=="") {
  alert("Topic - et le champ de Texte doiven être remplis!");
  return false;
 }
 return messagetolong(theform);
}






function checklength(theform) {
 if (postmaxchars != 0) message = " The maximum border is attached "+postmaxchars+" Indication.";
 else message = "";
 
 var messageLength = getMessageLength(theform);
 alert("Votre message est "+messageLength+" trop long." + message);
}

function messagetolong(theform) {
 	if (postmaxchars != 0) {
  		var messageLength = getMessageLength(theform);
  		if (messageLength > postmaxchars) {
   			alert("Your message is too long. Please reduce up your message as "+postmaxchars+". Max size are "+messageLength+".");
   			return false;
  		}
  		else {
  			return true;
  		}
 	} 
 	else {
 		return true;
 	}
}

function changeEditor(theForm, editorID) {
	getAppletText(theForm);
	theForm.change_editor.value = editorID;
	theForm.submit();	
}


activeMenu = false;
menuTimerRunning = false;
function toggleMenu(id, toggle) {
	if(document.getElementById) {
		if(id && toggle) {
			element = document.getElementById(id);
			status = element.style.display;
			if (!status || status == 'undefined' || status == 'none') {
				posLeft = getObjectPosLeft(toggle) + 10;
				element.style.left = posLeft + 'px';
				element.style.top = '0px';
				element.style.display = 'block';
				
				posTop = getObjectPosTop(toggle) - element.offsetHeight - 10;
				
				element.style.top = posTop + 'px';
				element.onmouseover = checkMenuTimer;
				element.onmouseout = startMenuTimer;
				activeMenu = id;
			}
			else {
				element.style.display = 'none';
				activeMenu = false;
			}
		}
		else if(activeMenu) {
			checkMenuTimer();
  			document.getElementById(activeMenu).style.display = 'none';
			activeMenu = false;
  		}
	}	
}

function getObjectPosLeft(element) {
	var left = element.offsetLeft;
	while((element = element.offsetParent) != null)	{
		left += element.offsetLeft;
	}
	return left;
}
function getObjectPosTop(element) {
	var top = element.offsetTop;
	while((element = element.offsetParent) != null)	{
		top += element.offsetTop;
	}
	return top;
}
function checkMenuTimer() {
	if(menuTimerRunning)  {
		clearTimeout(menuTimerRunning);
		menuTimerRunning = false;
	}
}
function startMenuTimer() {
	menuTimerRunning = setTimeout("toggleMenu();", 500);
}

//-->
function expand() {
        var i=1;
        var obj;
        var check = document.getElementById("adv_check");
        while (obj = document.getElementById("advanced_options_"+i)) {
                if (check.checked == false) {
                        obj.className = 'hide';
                } else {
                        obj.className = 'show';
                }
                i++;
        }

}
function comment_smile(text,area) {
//if(!area){area2 = 'descr';}else{area2 = area;}
//alert(area.value)
//var area;
        text = ' ' + makeurlsafe(text) + ' ';
        if (area.createTextRange && area.caretPos) {
                var caretPos = area.caretPos;
                caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text + ' ' : text;
                descr.focus();
        } else {
        area.value  += text;
        area.focus();
        }
}
  function mypopup(text)
  {
        my_Window = window.open (pmbtsite_url +"/preview.php?text="+text+"",  'windowname2', 
  'width=500, \
   height=300, \
   directories=no, \
   location=no, \
   menubar=no, \
   resizable=no, \
   scrollbars=1, \
   status=no, \
   toolbar=no'); 
  return false;
        my_Window.moveTo(50,50);
  }

  function popuponclick(widthVar, heightVar)
  {
        my_newWindow = window.open("","mywindow","status=1,width="+widthVar+",height="+heightVar+"");
        my_newWindow.document.write('<h1>the popup window</h1>');
  }
 
  function closepopup()
  {
        if(false == my_newWindow.closed)
        {
                my_newWindow.close();
        }
        else
        {
                alert('Window already closed!');
        }
  }
function expandpm() {
        var obj;

        obj = document.getElementById("bookmarks");
        if (obj.className == "show") obj.className = 'hide';
        else obj.className = 'show';
}
function add(name) {
        var txt;
        var obj;
        obj = document.getElementById("sendto");
        txt = obj.value;
        if (txt != "") txt += "; " + name;
        else txt = name;
        obj.value = txt;
        return;
}
