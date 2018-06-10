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
** File global.js 2018-02-17 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
/// Space for AJAX mods \\\
function advanced() {
        var obj;
        var obj2;
        obj = document.getElementById("users_simple");
        obj.className = 'hide';

        obj2 = document.getElementById("users_advanced");
        obj2.className = 'show';
}

function simple() {
        var obj;
        var obj2;
        obj2 = document.getElementById("users_advanced");
        obj2.className = 'hide';

        obj = document.getElementById("users_simple");
        obj.className = 'show';
}
function descriptor(val) {
        var obj;
        obj = document.getElementById("descriptor");
        if (!obj) return;
        obj.firstChild.nodeValue = val;
}
function ajax_createRequestObject(){
var ro;
var browser = navigator.appName;
if(browser == "Microsoft Internet Explorer"){
ro = new ActiveXObject("Microsoft.XMLHTTP");
} else{
ro = new XMLHttpRequest();
}
return ro;
}
var ajax_http = ajax_createRequestObject();
var ajax_destObj;
function SetSize(obj, x_size) {
       if (obj.offsetWidth > x_size) {
       obj.style.width = x_size;
   };
};
var c=0;
var _loading = 0;
function shoutthis_ajax()
{ 
	//alert('test');
c=0;
this.ts = window.setInterval('shoutload()', shoutrefresht);
this.ta = window.setInterval('getactive()', 55100);
this.tpm = window.setInterval('sendPmId()', 55500);
this.idletime = window.setInterval('stopall()',shoutidle);
}
 showsmiles = "show";
 inprivate = 'no';
function sndReq(argumentString, destStr){
		showprivateonly = '';

		if(inprivate == 'no'){
	showprivateonly = argumentString;
	}else{
		showprivateonly = argumentString+'&shotuser='+inprivate;
	}
//alert(showprivateonly);

	if(argumentString == "op=activeusers"){
	//alert("user");
	refreshoff = true;
	}
	if(argumentString == "op=view_shout"){
		refreshoff = false;
	}
	
	if(argumentString == "op=more_smiles")
	{
	if(showsmiles == "show")
	{
		 showsmiles = "hide";
		 ajax_destObj = document.getElementById(destStr);
ajax_http.open('get', './ajax.php?'+showprivateonly);
ajax_http.onreadystatechange = ajax_handleResponse;
ajax_http.send(null);

	}
	else if(showsmiles == "hide")
	{
		 showsmiles = "show";
		 ajax_destObj = document.getElementById(destStr);
ajax_http.open('get', './ajax.php?op=take_edit_shout_cancel');
ajax_http.onreadystatechange = ajax_handleResponse;
ajax_http.send(null);

	}
	}
	else
	{
ajax_destObj = document.getElementById(destStr);
ajax_http.open('get', './ajax.php?'+showprivateonly);
ajax_http.onreadystatechange = ajax_handleResponse;
ajax_http.send(null);
	}
}
function toggleprivate(nome, pmshout) {
		//alert(inprivate);

	//alert(document.getElementById(nome).attributes["onclick"].value)
if(document.getElementById(nome).value=="Shout!")
{
//document.getElementById(nome).style.display = '';
 inprivate = pmshout;
document.getElementById(nome).value= _btshoutnowprivate;
document.getElementById(nome).attributes["onclick"].value="sndprivateshoutReq(text.value, 'shout_out', '"+pmshout+"');  text.value = '';";
document.getElementById("shoutthisch").attributes["onclick"].value="toggleprivate('shout_send'); sndReq('op=view_shout', 'shout_out');";
document.getElementById("shout_text_area").attributes["onkeypress"].value="if (event.keyCode == 13) {sndprivateshoutReq(this.value, 'shout_out', '"+pmshout+"');}";
} else {
//document.getElementById(nome).style.display = 'auto';
 inprivate = 'no';
document.getElementById(nome).value="Shout!";
document.getElementById(nome).attributes["onclick"].value="sendshoutout(text.value, 'shout_out');  text.value = '';";
document.getElementById("shoutthisch").attributes["onclick"].value="sndReq('op=view_shout', 'shout_out');";
document.getElementById("shout_text_area").attributes["onkeypress"].value="if (event.keyCode == 13) {sendshoutout(this.value, 'shout_out');}";

}
}
function getactive(){
	_loading = 1;
	//alert(inprivate);
ajax_destObj = document.getElementById('shoutbox_activity');
ajax_http.open('get', './ajax.php?op=getactive');
ajax_http.onreadystatechange = ajax_handleResponse;
ajax_http.send(null);
_loading = 0;
}
function stopall()
{
	c=c+1;

if(c >= 30){
	 var div = document.getElementById('shoutidle');
	 if(div != null)div.innerHTML = shout_idle_text;
window.clearTimeout(this.ts);
window.clearTimeout(this.ta);
window.clearTimeout(this.tpm);
window.clearTimeout(this.idletime);
}	else
	{
		return null;
	}

}
function shoutload(){
	_loading = 1;
		showprivateonly = '';
	//alert(_loading);
	if(inprivate == 'no'){
	showprivateonly = '';
	}else{
		showprivateonly = '&shotuser='+inprivate;
	}

ajax_destObj = document.getElementById('shout_out');
if(ajax_destObj == null){return}
ajax_http.open('get', './ajax.php?op=view_shout'+showprivateonly);
ajax_http.onreadystatechange = ajax_handleResponse;
ajax_http.send(null);
	_loading = 0;
}
function sndprivateshoutReq(argumentString, destStr, sendto){
	//alert(argumentString);
	//validate(theform)
	
ajax_destObj = document.getElementById(destStr);
ajax_http.open('POST', './ajax.php?op=take_shout&sendto='+sendto+'&text='+argumentString);
ajax_http.onreadystatechange = ajax_handleResponse;
ajax_http.send(null);
	//shoutload();
}
function makeurlsafe(text){
	argumentString = text.replace(/&/gi,"/amp2/");
	argumentString2 = argumentString.replace(/#/gi,"/amp3/");
	argumentString3 = argumentString2.replace(/<br>/gi,"\n");
	argumentString4 = argumentString3.replace(/<br>/,"\n");
	argumentString5 = argumentString4.replace(/&middot;/gi,"'");
	return argumentString5;
}
function stopIt() { 
window.clearInterval(this.ts);
window.clearInterval(this.ta);
window.clearInterval(this.tpm);
window.clearInterval(this.idletime);
} 
function sndshoutReq(argumentString, destStr){
	//alert(makeurlsafe(argumentString));
	//validate(theform)
	if(_loading == 1){
		stopIt();
	}
ajax_destObj = document.getElementById(destStr);
ajax_http.open('POST', './ajax.php?op=take_shout&text='+makeurlsafe(argumentString));
ajax_http.onreadystatechange = ajax_handleResponse;
ajax_http.send(null);
if(_loading == 1){
	shoutthis_ajax();
}
	//shoutload();
}
function sendshoutout(text, destStr){
	c=0;
	//alert(_loading);
	sndshoutReq(text, 'shout_out');
	//shoutload();
}
function ajax_handleResponse(){
if(ajax_http.readyState == 4){
var response = ajax_http.responseText;
if(ajax_destObj != null)ajax_destObj.innerHTML = response;
//alert(response);
//ajax_destObj.innerHTML = response;
} else if(ajax_http.readyState == 1 ){
// Uncomment the next line if you want
// to display a Loading text. This will
// cause the page to blink if lots of
// data is being transferred. I vote off.
// However, if your server is slow and
// you want to tell your users something
// is being processed, turn it on.
//ajax_destObj.innerHTML = '<img src="/images/please_wait.gif" title="Loading" border="0" alt="Loading" />';
}
}
//// END AJAX MODS \\\\
function SetSize(obj, x_size) {
       if (obj.offsetWidth > x_size) {
       obj.style.width = x_size;
   };
};
function sendPmId()
{
	_loading = 1;
	
    if(document.getElementById("nopm_notif"))
    {
        try
          {
          // Firefox, Opera 8.0+, Safari
          pmIdsend=new XMLHttpRequest();
          }
        catch (e)
          {
          // Internet Explorer
          try
            {
            pmIdsend=new ActiveXObject("Msxml2.XMLHTTP");
            }
          catch (e)
            {
            try
              {
              pmIdsend=new ActiveXObject("Microsoft.XMLHTTP");
              }
            catch (e)
              {
              alert(NO_AJAX_SUPORT);
              return false;
              }
            }
          }
          
          
          pmIdsend.onreadystatechange = pmResponse;
          pmIdsend.open("GET", pmbtsite_url+"/pm_ajax.php?"+document.cookie, true);
          pmIdsend.send(null);
		  _loading = 0;
          
          
          return false;
    }  
}

function pmResponse()
{
if(pmIdsend.readyState == 4)
          {
            if(pmIdsend.status == 200){// ok
                try { // precte odpoved
                    var response = pmIdsend.responseText;
                    //alert(response);
                    if(response.length == 0) throw invalid_server_responce;
                    /*if(response.indexOf("login_error") >= 0) {
                        zobrazChybuPrihlaseni();
                        return;
                    }*/
                    response = pmIdsend.responseXML.documentElement;
                    stav = response.getElementsByTagName("status"); // vsechny elementy kontakt
                    // nepodarilo se ulozit
                    if(stav[0].firstChild.data != "OK"){
                        alert(message_was_saved);
                        //document.getElementById('tarea_text').focus();
                    }
                    //else  zjistiPocetZpravAjax(); //odeslanoOK = true;
                      else{ 
                          pm = response.getElementsByTagName("pm");
                          if(pm[0].firstChild.data != "false"){
                             // alert(pm[0].firstChild.data+"\n");
                            pmNotif = document.getElementById("nopm_notif");
                            pmNotif.id = "pm_notif";  
                            
                            while(pmNotif.hasChildNodes()) pmNotif.removeChild(pmNotif.firstChild);
                            
                            a = document.createElement("a");
                            atr = document.createAttribute("href");
                            atr.value = "pm.php?op=inbox";
                            a.setAttributeNode(atr);
                            txt = document.createTextNode(pm[0].firstChild.data);
                            a.appendChild(txt);
                            blink = document.createElement("blink");
                            blink.appendChild(a);
                            pmNotif.appendChild(blink);
                            
                            conftext = response.getElementsByTagName("confirm");
                            conftext = conftext[0].firstChild.data;
                            var answer = confirm (conftext);
                            if (answer) window.location="pm.php?op=inbox";
                          }
                          
                        
                      }                
                }
                catch(e) {
                    //alert("Error when processing:\n " + e.toString());
                }
            }
          }
}
var newwindow;
function popshout(url)
{
 newwindow=window.open(url,'popshout','height=700,width=900,status=yes,toolbar=no,scrollbars=yes,menubar=yes,location=yes');
}
function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'scrollbars=1,resizable=1,width=700,height=900,left = 290,top = -50');");
}
function popusers(url)
{
 newwindow=window.open(url,'popusers','height=70,width=400');
 if (window.focus) {newwindow.focus()}
}
function subPanels(p)
{
	var i, e, t;

	if (typeof(p) == 'string')
	{
		show_panel = p;
	}

	for (i = 0; i < panels.length; i++)
	{
		e = document.getElementById(panels[i]);
		t = document.getElementById(panels[i] + '-tab');

		if (e)
		{
			if (panels[i] == show_panel)
			{
				e.style.display = 'block';
				if (t)
				{
					t.className = 'activetab';
				}
			}
			else
			{
				e.style.display = 'none';
				if (t)
				{
					t.className = '';
				}
			}
		}
	}
}