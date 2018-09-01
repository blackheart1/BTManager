<!--
function vB_Attachment(listobjid, editorid)
{
	this.attachments = new Array();
	this.menu_contents = new Array();
	this.windows = new Array();

	this.listobjid = listobjid;

	if (editorid == '')
	{
		for (var editorid in vB_Editor)
		{
			if (typeof vB_Editor[editorid] != 'function')
			{
				this.editorid = editorid;
				break;
			}
		}
	}
	else
	{
		this.editorid = (editorid ? editorid : null);
	}
};

// =============================================================================
// vB_Attachment methods

/**
* Does the editor popup exist in a built state?
*
* @return	boolean
*/
vB_Attachment.prototype.popup_exists = function()
{
	if (
		this.editorid &&
		((typeof vB_Editor[this.editorid].popups['attach'] != 'undefined' && vB_Editor[this.editorid].popups['attach'] != null)
		||
		(!vB_Editor[this.editorid].popupmode && typeof vB_Editor[this.editorid].buttons['attach'] != 'undefined' && vB_Editor[this.editorid].buttons['attach'] != null))
	)
	{
		return true;
	}
	else
	{
		return false;
	}
};

/**
* Add a new attachment
*
* @param	integer	Attachment ID
* @param	string	File name
* @param	string	File size
* @param	string	Path to item's image (images/attach/jpg.gif etc.)
*/
vB_Attachment.prototype.add = function(id, filename, filesize, imgpath)
{
	this.attachments[id] = new Array();
	this.attachments[id] = {
		'filename' : filename,
		'filesize' : filesize,
		'imgpath'  : imgpath
	};

	this.update_list();
};

/**
* Remove an attachment
*
* @param	integer	Attachment ID
*/
vB_Attachment.prototype.remove = function(id)
{
	if (typeof this.attachments[id] != 'undefined')
	{
		this.attachments[id] = null;

		this.update_list();
	}
};

/**
* Do we have any attachments?
*
* @return	boolean
*/
vB_Attachment.prototype.has_attachments = function()
{
	for (var id in this.attachments)
	{
		if (this.attachments[id] != null)
		{
			return true;
		}
	}
	return false;
};

/**
* Reset the attachments array
*/
vB_Attachment.prototype.reset = function()
{
	this.attachments = new Array();

	this.update_list();
};

/**
* Build Attachments List
*
* @param	string	ID of the HTML element to contain the list of attachments
*/
vB_Attachment.prototype.build_list = function(listobjid)
{
	var listobj = fetch_object(listobjid);
	if (listobjid != null)
	{
		while(listobj.hasChildNodes())
		{
			listobj.removeChild(listobj.firstChild)
		}
		for (var id in this.attachments)
		{
			if(this.attachments[id]['filename'] != 'undefined')
			{
				if(this.attachments[id]['filename'] != null)
				{
						var C = document.createElement("div");
						// try to use the template if it's been submitted to Javascript
					if(typeof newpost_attachmentbit!="undefined")
					{
						C.innerHTML = construct_phrase(newpost_attachmentbit,this.attachments[id]["imgpath"],pmbtsite_url,id,Math.ceil((new Date().getTime())/1000),this.attachments[id]["filename"],this.attachments[id]["filesize"])
				}else{
					C.innerHTML='<div style="margin:2px"><img src="'+this.attachments[id]["imgpath"]+'" alt="" class="inlineimg" /> <a href="attachment.php?'+SESSIONURL+"attachmentid="+id+"&stc=1&d="+Math.ceil((new Date().getTime())/1000)+'" target="_blank" />'+this.attachments[id]["filename"]+"</a> ("+this.attachments[id]["filesize"]+")</div>"
					}
						listobj.appendChild(C)
				}
			}
		}
	}
};
/*
Timestamp: 10/10/2012 10:25:57 PM
Error: HierarchyRequestError: Node cannot be inserted at the specified point in the hierarchy
Source File: http://guv2.com/3/pmbt/themes/Bitfarm/templates/attach.js
Line: 140
vB_Attachment.prototype.build_list=function(A)
{
	var B=fetch_object(A);
	if(A!=null)
	{
		while(B.hasChildNodes())
		{
			B.removeChild(B.firstChild)
		}
		for(var D in this.attachments)
		{
			if(!YAHOO.lang.hasOwnProperty(this.attachments,D))
			{
				continue
			}
			var C=document.createElement("div");
				if(typeof newpost_attachmentbit!="undefined")
				{
					C.innerHTML=construct_phrase(newpost_attachmentbit,this.attachments[D]["imgpath"],SESSIONURL,D,Math.ceil((new Date().getTime())/1000),this.attachments[D]["filename"],this.attachments[D]["filesize"])
				}else{
					C.innerHTML='<div style="margin:2px"><img src="'+this.attachments[D]["imgpath"]+'" alt="" class="inlineimg" /> <a href="attachment.php?'+SESSIONURL+"attachmentid="+D+"&stc=1&d="+Math.ceil((new Date().getTime())/1000)+'" target="_blank" />'+this.attachments[D]["filename"]+"</a> ("+this.attachments[D]["filesize"]+")</div>"
					}
					B.appendChild(C)
		}
	}
};*/
/**
* Update the places we show a list of attachments
*/
vB_Attachment.prototype.update_list = function()
{
	this.build_list(this.listobjid);

	if (this.popup_exists())
	{
		vB_Editor[this.editorid].build_attachments_popup(
			vB_Editor[this.editorid].popupmode ? vB_Editor[this.editorid].popups['attach'] : vB_Editor[this.editorid].buttons['attach'],
			vB_Editor[this.editorid].buttons['attach']
		);
	}
};

/**
* Opens the attachment manager window
*
* @param	string	URL
* @param	integer	Width
* @param	integer	Height
* @param	string	Hash
*
* @return	window
*/
vB_Attachment.prototype.open_window = function(url, width, height, hash)
{
	if (typeof(this.windows[hash]) != 'undefined' && this.windows[hash].closed == false)
	{
		this.windows[hash].focus();
	}
	else
	{
		this.windows[hash] = openWindow(url, width, height, 'Attach' + hash);
	}

	return this.windows[hash];
};
//-->