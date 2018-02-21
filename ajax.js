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
** File ajax.js 2018-02-19 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
var req;
var offset = 1;
function doAjax() {
    if ( trackers[offset] == null )
        return;
        
    var command = 'op=scrape&tracker=' + trackers[offset] + '&info_hash=' + hash;
    document.getElementById('scrape_' + offset).innerHTML = 'connecting...';

    req = false;
    // branch for native XMLHttpRequest object
    if (window.XMLHttpRequest && !(window.ActiveXObject)) {
    	try {
			req = new XMLHttpRequest();
        } catch(e) {
			req = false;
        }
    // branch for IE/Windows ActiveX version
    } else if (window.ActiveXObject) {
       	try {
        	req = new ActiveXObject("Msxml2.XMLHTTP");
      	} catch(e) {
        	try {
          		req = new ActiveXObject("Microsoft.XMLHTTP");
        	} catch(e) {
          		req = false;
        	}
		}
    }

	if (req) {
        req.onreadystatechange=state;
		req.open('POST', 'ajax.php', true);
		req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        req.setRequestHeader('Content-length', command.length);
		req.send(command);

	} else {
        alert('Your browser is not supported.');
    }
}

function state()
{
    if (req.readyState==4)
    {
        if (req.status==200)
        {
            if ( document.getElementById('scrape_' + offset) )
            {
                document.getElementById('scrape_' + offset).innerHTML = req.responseText;
                if ( req.responseText == 'Tracker has not seen this torrent.' )
                {
                    document.getElementById('tracker_' + offset ).style.background = '#FFFF80';
                }
                else if ( req.responseText.indexOf( "Seed" ) != 0 && req.responseText.indexOf( "Unsupported" ) != 0 )
                {
                    document.getElementById('tracker_' + offset ).style.background = '#000000';
                }
            }
            offset++;
            doAjax();
        }
        else
        {
            alert("Ajax error");
        }
    }
}