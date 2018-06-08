NcodeImageResizer.IMAGE_ID_BASE = 'ncode_imageresizer_container_';
NcodeImageResizer.WARNING_ID_BASE = 'ncode_imageresizer_warning_';

function NcodeImageResizer(id, img) {
	this.id = id;
	this.img = img;
	this.originalWidth = 0;
	this.originalHeight = 0;
	this.warning = null;
	this.warningTextNode = null;
	
	img.id = NcodeImageResizer.IMAGE_ID_BASE+id;
}

NcodeImageResizer.getNextId = function() {
	id = 1;
	while(document.getElementById(NcodeImageResizer.IMAGE_ID_BASE+id) != null) {
		id++;
	}
	return id;
}

NcodeImageResizer.createOn = function(img) {
	isRecovery = false; // if this is a recovery from QuickEdit, which only restores the HTML, not the OO structure
	if(img.id && img.id.indexOf(NcodeImageResizer.IMAGE_ID_BASE) == 0 && document.getElementById(NcodeImageResizer.WARNING_ID_BASE+img.id.substr(NcodeImageResizer.IMAGE_ID_BASE.length)) != null) {
		newid = img.id.substr(NcodeImageResizer.IMAGE_ID_BASE.length);
		resizer = new NcodeImageResizer(newid, img);
		isRecovery = true;
		resizer.restoreImage();
	} else {
		newid = NcodeImageResizer.getNextId();
		resizer = new NcodeImageResizer(id, img);
	}
	
	if (resizer.originalWidth == 0) resizer.originalWidth = img.width;
	if (resizer.originalHeight == 0) resizer.originalHeight = img.height;
	
	if((NcodeImageResizer.MAXWIDTH > 0 && resizer.originalWidth > NcodeImageResizer.MAXWIDTH) || (NcodeImageResizer.MAXHEIGHT > 0 && resizer.originalHeight > NcodeImageResizer.MAXHEIGHT)) {
		if(isRecovery) {
			resizer.reclaimWarning(warning);
		} else {
			resizer.createWarning();
		}
		resizer.scale();
	}
}

NcodeImageResizer.prototype.restoreImage = function() {
	newimg = document.createElement('IMG');
	newimg.src = this.img.src;
	this.img.width = newimg.width;
	this.img.height = newimg.height;
}

NcodeImageResizer.prototype.reclaimWarning = function() {
	warning = document.getElementById(NcodeImageResizer.WARNING_ID_BASE+newid);
	
	this.warning = warning;
	this.warningTextNode = warning.firstChild.firstChild.childNodes[1].firstChild;
	this.warning.resize = this;
	
	this.scale();
}

NcodeImageResizer.prototype.createWarning = function() {
	mtable = document.createElement('TABLE');
	mtbody = document.createElement('TBODY');
	mtr = document.createElement('TR');
	mtd1 = document.createElement('TD');
	mtd2 = document.createElement('TD');
	mimg = document.createElement('IMG');
	mtext = document.createTextNode('');
	
	mimg.src = 'images/expand.png';
	mimg.width = 16;
	mimg.height = 16;
	mimg.alt = '';
	mimg.border = 0;
	
	mtd1.width = 20;
	mtd1.className = 'td1';
	
	mtd2.unselectable = 'on';
	mtd2.className = 'td2';
	
	mtable.className = 'ncode_imageresizer_warning';
	mtable.textNode = mtext;
	mtable.resize = this;
	mtable.id = NcodeImageResizer.WARNING_ID_BASE+this.id;
	
	mtd1.appendChild(mimg);
	mtd2.appendChild(mtext);
	
	mtr.appendChild(mtd1);
	mtr.appendChild(mtd2);
	
	mtbody.appendChild(mtr);
	
	mtable.appendChild(mtbody);
	
	this.img.parentNode.insertBefore(mtable, this.img);
	
	this.warning = mtable;
	this.warningTextNode = mtext;
}

NcodeImageResizer.prototype.scale = function() {
	if(NcodeImageResizer.MAXWIDTH > 0 && this.originalWidth > NcodeImageResizer.MAXWIDTH) {
		resized = true;
		this.img.width = NcodeImageResizer.MAXWIDTH;
		this.img.height = (NcodeImageResizer.MAXWIDTH / this.originalWidth) * this.originalHeight;
	}
	if(NcodeImageResizer.MAXHEIGHT > 0 && this.originalHeight > NcodeImageResizer.MAXHEIGHT) {
		resized = true;
		this.img.height = NcodeImageResizer.MAXHEIGHT;
		this.img.width = (NcodeImageResizer.MAXHEIGHT / this.originalHeight) * this.originalWidth;
	}
	
	this.warning.width = this.img.width;
	this.warning.onclick = function() { return this.resize.unScale(); }
	
	if(this.img.width < 450) {
		this.warningTextNode.data = NcodeImageResizer.Msg1;
	} else if(this.img.fileSize && this.img.fileSize > 0) {
		this.warningTextNode.data = NcodeImageResizer.Msg2.replace('%1$s', this.originalWidth).replace('%2$s', this.originalHeight).replace('%3$s', Math.round(this.img.fileSize/1024));		
	} else {
		this.warningTextNode.data = NcodeImageResizer.Msg3.replace('%1$s', this.originalWidth).replace('%2$s', this.originalHeight);		
	}
	
	return false;
}

NcodeImageResizer.prototype.unScale = function() {
	switch(NcodeImageResizer.MODE) {
		case 'none':			
			break;
		case 'samewindow':
			window.open(this.img.src, '_self');
			break;
		case 'newwindow':
			window.open(this.img.src, '_blank');
			break;
		case 'enlarge':
		default:
			this.img.width = this.originalWidth;
			this.img.height = this.originalHeight;
			this.img.className = 'ncode_imageresizer_original';
			if(this.warning != null) {
				this.warningTextNode.data = NcodeImageResizer.Msg4;
				this.warning.width = this.img.width;
				this.warning.onclick = function() { return this.resize.scale() };
			}
			break;
	}
	
	return false;
}