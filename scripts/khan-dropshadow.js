function dropshadow_repair(item) {
		var par = item.up();
		var newwidth = par.getWidth()+6;
		var newheight = par.getHeight()+6;
		if (newwidth % 2 && detect_ie6()) {
			newwidth++;
		}
		item.setStyle({height: newheight+'px'});
		item.setStyle({width: newwidth+'px'});
		item.down('.dropshadow-bottom').setStyle({width: (newwidth-12)+'px'});
		item.down('.dropshadow-left').setStyle({height: (newheight-12)+'px'});
		item.down('.dropshadow-right').setStyle({height: (newheight-12)+'px'});
}

// support drop shadows in all versions of IE
Event.observe(window, 'load', function(event) {
	$$('.dropshadow').each( function (item) {
		// fix shadows upon page load
		dropshadow_repair(item);
		
		// fix shadows any time the parent element changes size
		item.up().observe('resize', function (e) {
			dropshadow_repair(item);
		});
	});
});