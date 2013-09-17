var supersleight=function(){
	var shim=magnolia_assets_url+'/common/images/x.gif';
	var imgarray = [];
	var readyforsecond = false;
	var secondruntries = 0;
	
	var load_alpha = function (item, firstrun) {
		if (item.nodeType != 1) return;
		if (item.alphaloaded) return;
		var src = '';
		if (item.tagName == 'IMG' || item.tagName == 'INPUT') {
			src = item.src;
			if (src.match(/.png/) && !src.match(/noalpha|mgnl/)) {
				if (firstrun && !item.getAttributeNode('width').specified && (!item.style.width || item.style.width == 'auto')) {
					imgarray.push(item);
					return;
				}
				item = $(item);
				item.setStyle({width: item.width + "px"});
				item.setStyle({height: item.height + "px"});
				item.setStyle({filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + src + "', sizingMethod='scale')"});
				item.src = shim;
				item.alphaloaded = true;
				item.origsrc = src;
			}
		} else {
			var mode = 'scale';
			var bg	= item.currentStyle.backgroundImage;
			src = bg.substring(5,bg.length-2);
			if (src.match(/.png/) && !src.match(/noalpha|mgnl/)) {
				if (item.currentStyle.backgroundRepeat == 'no-repeat') mode = 'crop';
				item.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + src + "', sizingMethod='" + mode + "')";
				item.style.background = 'none';
				item.alphaloaded = true;
				item.origsrc = src;
			}
		}
	}
	
	var unload_alpha = function (item) {
		if (!item.alphaloaded) return;
		item = $(item);
		item.style.filter = '';
		if (item.tagName == 'IMG') {
			item.src = item.origsrc;
		} else {
			if (item.origsrc)
				item.setStyle({backgroundImage: "url("+item.origsrc+")"});
			else
				item.setStyle({background: "none"});
		}
		item.alphaloaded = false;
	}
	
	var firstrun = function () {
		var objs = document.all;
		var num = objs.length;
		for (var i = 0; i < num; i++)
			load_alpha(objs[i], true);
		readyforsecond = true;
	}
	
	var secondrun = function () {
		if (!readyforsecond) {
			if (secondruntries > 20) return;
			setTimeout('supersleight.postrun()', 100);
			secondruntries++;
			return;
		}
		for (var i = 0; i < imgarray.length; i++) {
			load_alpha(imgarray[i], false);
		}
	}
	
	return {firstrun: firstrun, secondrun: secondrun, load_alpha: load_alpha, unload_alpha: unload_alpha};
}();

Event.observe(document, 'dom:loaded', supersleight.firstrun);
Event.observe(window, 'load', supersleight.secondrun);