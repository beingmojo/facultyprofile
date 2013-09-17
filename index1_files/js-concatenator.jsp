/* IMPORTED FROM FILE: /opt/magnolia/webapps/magnoliaAssets/txstate/js/khan-webtools.js */

function togglewebtools() {
	if (!togglewebtools.shown) {
		showwebtools();
	}	else {
		hidewebtools();
	}
}
function showwebtools() {
	$('txst-banner-webtools-menuitems').setStyle({display: 'block'});
	togglewebtools.shown = 1;
}
function hidewebtools() {
	$('txst-banner-webtools-menuitems').setStyle({display: 'none'});
	togglewebtools.shown = 0;
}


// Drop-down button for webtools
Event.observe(window, 'load', function() {
	Event.observe('txst-banner-webtools-dropdown', 'click', function(event) {
		this.blur();
		togglewebtools();
		Event.stop(event);
	});
	
	// let's set a timeout to close the web tools after a couple seconds, but
	// not if they're hovering over it
	$('txst-banner-webtools-dropdown').onmouseout = $('txst-banner-webtools-menuitems').onmouseout = function() { 
		hidewebtools.timer = setTimeout("hidewebtools()", 2000); 
	}
	$('txst-banner-webtools-dropdown').onmouseover = $('txst-banner-webtools-menuitems').onmouseover = function() { 
		clearTimeout(hidewebtools.timer); 
	}
	
	// clear the search field of its default when clicked
	$$('.txst-banner-search input')[0].observe('focus', function (event) {
		if (this.value == this.defaultValue) this.value = '';
	});
	
	// alternate action for submitting the form, since IE6 barfs on the transparent PNG magnifying glass
	$$('.txst-banner-webtools-searchbg')[0].observe('click', function (event) {
		event.stop();
		this.up('form').submit();
	});
});
/* IMPORTED FROM FILE: /opt/magnolia/webapps/magnoliaAssets/txstate-home/js/khan-usefullinks.js */

var usefullinks_max;
var usefullinks_min;
var expanderparent;

function usefullinkexpand() {
	usefullinksexpanded = true;
	expanderparent.morph('height: '+usefullinks_max+'em', {duration: .4});
	setTimeout("expanderparent.style.overflow = 'visible'", 450);
	
	expanderlink.innerHTML = "Collapse Navigation";
	expanderdiv.removeClassName('expand');
	expanderdiv.addClassName('collapse');
}

function usefullinkcontract() {
	usefullinksexpanded = false;

	expanderparent.style.overflow = 'hidden';
	expanderparent.morph('height: '+usefullinks_min+'em', {duration: .4});

	expanderlink.innerHTML = "Expand Navigation";
	expanderdiv.removeClassName('collapse');
	expanderdiv.addClassName('expand');
}

function usefullinktoggle() {
	if (usefullinksexpanded) usefullinkcontract();
	else usefullinkexpand();
}

function usefullink_recur(item, mycount, myheight) {
	var mynext = item.down();
	if (mynext != null) {
		do {
				if (mynext.hasClassName('txst-mainsite-usefullinks-linkitem')) {
					myheight += mynext.getHeight();
					mycount++;
				} else {
					var arr = usefullink_recur(mynext, mycount, myheight);
					mycount = arr[0];
					myheight = arr[1];
				}
				mynext = mynext.next();
		} while (mynext != null)
	}
	return [mycount,myheight];
}

function px2em(px) {
	var bodypx = 16;
	var em = px / bodypx;
	return Math.round(em*10)/10;
}

function style2dim(style) {
	return style.substring(0, style.length-2);
}

function px2links(px) {
	return Math.round(px2em(px)/linkitemsize);
}

Event.observe(document, "dom:loaded", function() {
	expanderparent = $$('.txst-mainsite-usefullinks')[0];
	expanderlink = $('usefulLinksExpanderLink');
	expanderdiv = $('expander-arrow');
	usefullinksexpanded = false;

	var headersize = 1.7;
	linkitemsize = 1.2;
	var collapsedlinks = 6;
	
	usefullinks_min = collapsedlinks * linkitemsize + headersize;
	expanderparent.setStyle({height: usefullinks_min+'em'});
	
	var maxcount = 0;
	var cols = expanderparent.childNodes;
	for (var i = 0; i < cols.length; i++) {
		var arr = usefullink_recur($(cols[i]), 0, 0);
		var colcount = arr[0];
		var colheight = arr[1];
		if (colheight > maxcount) maxcount = colheight;
	}
	
	usefullinks_max = px2links(maxcount) * linkitemsize + headersize;
	Event.observe('usefulLinksExpanderLink', 'click', function(event) {
		usefullinktoggle();
		event.element().blur();
		event.stop();
	});
});
/* IMPORTED FROM FILE: /opt/magnolia/webapps/magnoliaAssets/txstate-home/js/khan-marketing.js */

/************* BARE FUNCTIONS ***************/

// EXPLORE TEXAS STATE
BACKGROUND_ELEMENT_GRAPHIC_KEY = 'backgroundImagePath';
BACKGROUND_TAB_GRAPHIC_KEY = 'tabPath';
BACKGROUND_ACTIVE_TAB_GRAPHIC_KEY = 'activeTabPath';

backgroundElements = new Hash();
function explore_display( uuid ) {
	var displayElement = backgroundElements.get( uuid );
	if ( displayElement ) {
		var tabPath = displayElement.get( BACKGROUND_TAB_GRAPHIC_KEY );
		var activeTabPath = displayElement.get( BACKGROUND_ACTIVE_TAB_GRAPHIC_KEY );
		var backgroundPath = displayElement.get( BACKGROUND_ELEMENT_GRAPHIC_KEY );

		$('explore-content-bg').style.backgroundImage= "url(" + backgroundPath + ")";
		$$('#explore-link img')[0].src = tabPath;
		$$('#txst-marketing-explore span.bg-span')[0].style.backgroundImage = "url(" + activeTabPath + ")";
	}
}

function explore_display_random() {
	var keys = backgroundElements.keys();
	var indexToUse = Math.floor( Math.random() * backgroundElements.size() );
	explore_display( keys[indexToUse] );
}

// BOBCAT TUBE
function video_unload_all() {
	if (flashembed && flashembed.isSupported([9, 115])) {
		$f("*").each(function() {
			if (this.isLoaded()) this.unload();
		});
	}
}

// run this after changing the video linked to, or the player will play the old
// video since its location is cached
function video_update(lnk) {
	var p = $f(lnk);
	if (p && p.isLoaded()) p.unload();
	var newlnk = $(document.createElement('a'));
	newlnk.className="txst-videolink";
	newlnk.href = lnk.href;
	while (lnk.childNodes.length > 0) newlnk.appendChild(lnk.firstChild);
	lnk.parentNode.replaceChild(newlnk, lnk);
	video_load(newlnk);
}

function set_active_tube(idx) {

	video_unload_all();
	
	$$('.txst-mainsite-videos-item').each( function (item) {
		item.setStyle({display: 'none'});
	});
	
	var vidframe = video_mains[idx];
	
	vidframe.setStyle({display: 'block'});
	
	var myimg = vidframe.down('img')
	if (!vidframe.src_altered) myimg.src = tubetabs[idx].posterImage;
	vidframe.src_altered = true;
	
	video_load(video_mains[idx].down('.txst-videolink'));
}

function check_video_buttons() {
	if (!video_scroll_level) disable_arrow($('videos-left'));
	else enable_arrow($('videos-left'));
	
	if (video_scroll_level == video_scroll_max - 1) disable_arrow($('videos-right'));
	else enable_arrow($('videos-right'));
}

// RISING STARS
function set_active_rising_star(link) {
	if (link.hasClassName('inactive')) {
		video_unload_all();
	}
		
	$$('.txst-mainsite-rising-stars-item').each( function (item) {
		item.setStyle({display: 'none'});
	});
	$$('.txst-mainsite-rising-stars-thumb a').each( function (item) {
		item.addClassName('inactive');
		item.down('img').setStyle({opacity: 0.5});
	});

	var idx = link.up('div').myRisingStarsIndex;
	rising_star_mains[idx].setStyle({display: 'block'});
	
	// change to the correct source, done for performance
	var myimg = rising_star_mains[idx].down('.txst-mainsite-rising-stars-videoframe img');
	if (!link.src_altered)  myimg.src = startabs[idx].posterImage;
	link.src_altered = true;
	video_load(myimg.up('a'));
	
	link.down('img').setStyle({opacity: 1});
	link.removeClassName('inactive');
	check_up_button();
	check_down_button();
	
	auto_lang_toggle(rising_star_mains[idx]);
}

function disable_arrow(item) {
	item.addClassName('disabled-link');
	load_alpha(item);
}

function enable_arrow(item) {
	item.removeClassName('disabled-link');
}

function check_down_button() {
	if (typeof risingstar_lastchild == 'undefined') {
		$$('.txst-mainsite-rising-stars-thumb').each( function (item) {
			risingstar_lastchild = item;
		});
	}
	if (!risingstar_lastchild.down('a').hasClassName('inactive')) {
		disable_arrow($('rising-stars-down'));
	} else {
		enable_arrow($('rising-stars-down'));
	}
}

function check_up_button() {
	if (!$('rising-stars-thumbs').firstDescendant().down('a').hasClassName('inactive')) {
		disable_arrow($('rising-stars-up'));
	} else {
		enable_arrow($('rising-stars-up'));
	}
}
	
// BE A BOBCAT
function set_active_bobcat(link) {
	if (link.hasClassName('inactive')) {
		video_unload_all();
	}
	
	$$('.txst-mainsite-bobcats-item').each( function (item) {
		item.setStyle({display: 'none'});
	});
	$$('.txst-mainsite-bobcats-thumb a').each( function (item) {
		item.down('img').setStyle({opacity: 0.5});
		item.addClassName('inactive');
	});

	var idx = link.up('div').myBobcatIndex;
	bobcat_mains[idx].setStyle({display: 'block'});

	// change to the correct source, done for performance
	var myimg = bobcat_mains[idx].down('.txst-mainsite-bobcats-videoframe img');
	if (!link.src_altered) myimg.src = cattabs[idx].posterImage;
	link.src_altered = true;
	video_load(myimg.up('a'));
	
	link.down('img').setStyle({opacity: 1});
	link.removeClassName('inactive');
	check_bobcat_up();
	check_bobcat_down();
	
	auto_lang_toggle(bobcat_mains[idx]);
}

function check_bobcat_down() {
	if (typeof bobcat_lastchild == 'undefined') {
		$$('.txst-mainsite-bobcats-thumb').each( function (item) {
			bobcat_lastchild = item;
		});
	}
	if (!bobcat_lastchild.down('a').hasClassName('inactive')) {
		disable_arrow($('bobcats-down'));
	} else {
		enable_arrow($('bobcats-down'));
	}
}

function check_bobcat_up() {
	if (!$('bobcat-thumbs').firstDescendant().down('a').hasClassName('inactive')) {
		disable_arrow($('bobcats-up'));
	} else {
		enable_arrow($('bobcats-up'));
	}
}

function load_thumbs(id, urls) {
	if (load_thumbs[id]) return; // run once
	var thumbs = $(id).select('img');
	for (var i = 0; i < urls.length; i++) {
		thumbs[i].src = urls[i].thumbnail;
		load_alpha(thumbs[i]);
	}
	load_thumbs[id] = 1; // run once
}

function display_random_tab(id, urls) {
	var num = urls.length;
	id = $(id);
	if (num > 0) {
		var visi = Math.floor(Math.random()*num);
		id.selectedimage = visi;
		id.down('img').src = urls[visi].tabImage;
	}
}

function cache_marketing_images(urls) {
	var num = urls.length;
	for (var i = 0; i < num; i++) {
		var img = new Image();
		img.src = urls[i].thumbnail;
	}
}

function swap_content(o1, o2, data, data2) {
	if (!data) data = 'innerHTML';
	if (!data2) data2 = data;
	
	if (typeof o1 == 'undefined' || typeof o2 == 'undefined') return;
	
	var val1 = (data == 'href' ? o1.readAttribute('href') : o1[data]);
	var val2 = (data2 == 'href' ? o2.readAttribute('href') : o2[data2]);
	
	o1[data] = val2;
	o2[data2] = val1;
}

function auto_lang_toggle(entry) {
	var tog = entry.down('.lang-toggle');
	if (tog && userLang.substr(0,2) == "es" && !tog.runOnce) {
		fireEvent(tog,'click');
		tog.runOnce = true;
	}
}

function activate_language_toggles(id) {
	var itemclass = (id == 'rising-stars-content' ? '.txst-mainsite-rising-stars-item' : '.txst-mainsite-bobcats-item');
	var items = $(id).select(itemclass+' .lang-toggle');
	for (var i = 0; i < items.length; i++) {
		var toggle = items[i];
		toggle.observe('click', function (event) {
			this.down('a').blur();
			video_unload_all();
			
			var entry = this.up();
			// swapping code here
			var esdiv = entry.down('.marketing-es-content');
			// title
			swap_content(entry.down('h4'), esdiv.down('.marketing-es-title'));
			// text
			swap_content(entry.down('.marketing-desc'), esdiv.down('.marketing-es-desc'));
			// link
			swap_content(entry.down('.marketing-readfull'), esdiv.down('.marketing-es-link'));
			// videoUrl
			swap_content(entry.down('.marketing-videoframe a'), esdiv.down('.marketing-es-video a.es-videoUrl'), 'href');
			// subUrl
			swap_content(entry.down('.marketing-videoframe a.videoframe-caption-link'), esdiv.down('.marketing-es-video a.es-subUrl'), 'href');
			// posterImage
			swap_content(entry.down('.marketing-videoframe a img'), esdiv.down('.marketing-es-video a.es-posterImage'), 'src', 'href');
			// posterImageAlt
			swap_content(entry.down('.marketing-videoframe a img'), esdiv.down('.marketing-es-video a.es-posterImage'), 'alt', 'title');

			// update the video clip since flowplayer has the old one cached
			video_update(entry.down('.marketing-videoframe a'));
							
			// update the link itself to indicate which state we're in
			this.inSpanish = !this.inSpanish;
			this.down('a').innerHTML = (this.inSpanish ? 'in english' : 'en espa&ntilde;ol');
			
			event.stop();
		});
	}
}

/* choose a random image for each tab */
// we'd like to get this done asap, so we'll use dom:loaded
document.observe('dom:loaded', function (event) {
	display_random_tab("beabobcat-link", cattabs);
	display_random_tab("risingstars-link", startabs);
	explore_display_random();
	activate_language_toggles('rising-stars-content');
	activate_language_toggles('be-a-bobcat-content');
});
/* done choosing a random image */

Event.observe(window, "load", function() {
	
	// hide and show the main tabs and content areas
	var markmodule = $('txst-mainsite-marketingtabs');
	var tabs = ['explore-link', 'risingstars-link', 'beabobcat-link', 'bobcattube-link'];
	var carea = ['explore-content', 'rising-stars-content', 'be-a-bobcat-content', 'bobcat-tube-content'];
	for (var i = 0; i < tabs.length; i++) {
		Event.observe($(tabs[i]).up('h3'), 'click',function(event,carea) {
			this.blur();

			if (this.up('h3').hasClassName('active-tab')) { 
				if (this.up('h3').id == 'txst-marketing-explore') {
					fireEvent($('txst-marketing-risingstars'),'click');
				}
				event.stop(); 
				return; 
			}
			
			/* support flash video in the marketing module */
			video_unload_all();
			/* end supporting flash video */

			markmodule.select('h3.txst-marketing-header').each( function(item) {
				item.down('.bg-span').setStyle({display: 'none'});
				item.removeClassName('active-tab');
				item.down('img').setStyle({opacity: 1});
			});
						
			// hide all the content areas, we'll show the proper one in a moment
			markmodule.select('.txst-mainsite-marketing-content').each( function(item) {
				item.setStyle({visibility: "hidden"});
			});
			
			// load thumbnail image sources, we're doing this for performance, so
			// the browser doesn't request all these thumbnails before rendering the page the first time
			if (this.id == tabs[1]) load_thumbs('rising-stars-thumbs', startabs);
			if (this.id == tabs[2]) load_thumbs('bobcat-thumbs', cattabs);
			if (this.id == tabs[3]) load_thumbs('videos-thumbs', tubetabs);
			
			/* support animating the tabs */
			// if there's an animation running when the user clicks, we'll cancel it and skip to the end
			if (tab_morphs[this.id]) tab_morphs[this.id].cancel();
			if (tab_morphs_bg[this.id]) tab_morphs_bg[this.id].cancel();
			this.down('img').setStyle({opacity: 0});
			this.previous('.bg-span').setStyle({display: 'block', opacity: 1});
			this.fadedout = false;
			/* end support for animating tabs */
						
			this.up('h3').addClassName('active-tab');
			$(carea).setStyle({visibility: 'visible'});
			
			// if we have multiple images on the tabs, let's make sure we activate the
			// item that matches the tab we can currently see
			if (typeof this.selectedimage != 'undefined' && this.id == tabs[1]) {
				var thumbdiv = $('rising-stars-thumbs').childElements()[this.selectedimage];
				// make sure we scroll it into visible territory
				if (thumbdiv.getStyle('display') == 'none') {
					halt_video_load = true;
					while (thumbdiv.myRisingStarsIndex < rising_star_top.length) fireEvent($('rising-stars-up'), 'click');
					while (thumbdiv.myRisingStarsIndex >= rising_star_top.length + rising_star_visible.length) fireEvent($('rising-stars-down'), 'click');
					halt_video_load = false;
				}
				set_active_rising_star(thumbdiv.down('a'));
			}
			if (typeof this.selectedimage != 'undefined' && this.id == tabs[2]) {
				var thumbdiv = $('bobcat-thumbs').childElements()[this.selectedimage];
				// make sure we scroll it into visible territory
				if (thumbdiv.getStyle('display') == 'none') {
					halt_video_load = true;
					while (thumbdiv.myBobcatIndex < bobcat_top.length) fireEvent($('bobcats-up'), 'click');
					while (thumbdiv.myBobcatIndex >= bobcat_top.length + bobcat_visible.length) fireEvent($('bobcats-down'), 'click');
					halt_video_load = false;
				}
				set_active_bobcat(thumbdiv.down('a'));
			}
			if (this.id == tabs[3] && !this.activate_once) {
					set_active_tube(0);
					this.activate_once = true;
			}
			
			event.stop();
		}.bindAsEventListener($(tabs[i]),carea[i]));
		$('explore-link').down('img').setStyle({opacity: 0});
		
		/* attempt at animating the tabs */
		tab_morphs = new Array();
		tab_morphs_bg = new Array();
		tab_duration = 0.4;
		mycarea = $(carea[i]);
		
		// We have to observe on the images because the link area is slightly larger.
		// If we observe on the link, we'll get extra mouseouts and mouseovers as
		// the mouse passes from linkarea to imagearea.  This is because of bubbling.
		var item = $(tabs[i]).down('img');
		item.observe('mouseover', function(event, carea) {
			if (detect_touch()) {
				// touch screen devices often fire mouseover on the first click, but we'd prefer to just
				// activate the tab immediately
				fireEvent(this.up('h3'), 'click');
				return;
			}
			var link = this.up('a');
			if (carea.getStyle('visibility') == 'hidden' && !link.fadedout) {
				if (tab_morphs[link.id]) tab_morphs[link.id].cancel();
				if (tab_morphs_bg[link.id]) tab_morphs_bg[link.id].cancel();
				var bgspan = link.previous('.bg-span');
				bgspan.setStyle({display: 'block', opacity: 0});
				tab_morphs[link.id] = new Effect.Morph(this, {style: 'opacity: 0', duration: tab_duration});
				tab_morphs_bg[link.id] = new Effect.Morph(bgspan, {style: 'opacity: 1', duration: tab_duration/1.5});
				link.fadedout = true;
			}
		}.bindAsEventListener(item, mycarea));
		item.observe('mouseout', function(event, carea) {
			var link = this.up('a');
			if (carea.getStyle('visibility') == 'hidden' && link.fadedout) {
				if (tab_morphs[link.id]) { tab_morphs[link.id].cancel(); }
				if (tab_morphs_bg[link.id]) tab_morphs_bg[link.id].cancel();
				var duration = (tab_morphs[link.id] ? tab_morphs[link.id].position : 1) * tab_duration;
				tab_morphs[link.id] = new Effect.Morph(this, {style: 'opacity: 1', duration: duration});
				tab_morphs_bg[link.id] = new Effect.Morph(link.previous('.bg-span'), {style: 'opacity: 0; display: none', duration: duration});
				link.fadedout = false;
			}
		}.bindAsEventListener(item, mycarea));
		/* end of attempt at animating the tabs */
		
	}

	/***************************************/
	/*    News & Announcements scrolling   */
	/***************************************/
	news_item_stack_visible = new Array();
	news_item_stack_invisible = new Array();
	markmodule.select('.explore-content-newsitem').each( function (item, i) {
		// build a stack of news items
		item.myRealHeight = item.getHeight();
		item.id = 'news'+(i+1);
		news_item_stack_visible.unshift(item);
	});
	
	$('explore-content-news-down').observe('click', function(event) {
		this.blur();
		if (news_item_stack_visible.length > 1) {
			var myitem = news_item_stack_visible.pop();
			myitem.morph('margin-top: -'+(myitem.myRealHeight)+'px', {duration: 0.25, queue: 'end'});
			myitem.timeout = setTimeout("$('"+myitem.id+"').setStyle({display: 'none'})", 250);
			news_item_stack_invisible.push(myitem);
			$('explore-content-news-up').removeClassName('disabled-link');
		}
		if (news_item_stack_visible.length < 2) {
			this.addClassName('disabled-link');
		}
		event.stop();
	});
	$('explore-content-news-up').observe('click', function(event) {
		this.blur();
		if (news_item_stack_invisible.length > 0) {
			var myitem = news_item_stack_invisible.pop();
			clearTimeout(myitem.timeout);
			myitem.setStyle({display: 'block'});
			myitem.morph('margin-top: 0px', {duration: 0.25, queue: 'end'});
			news_item_stack_visible.push(myitem);
			$('explore-content-news-down').removeClassName('disabled-link');
		}
		if (news_item_stack_invisible.length == 0) {
			this.addClassName('disabled-link');
		}
		event.stop();
	});
	$('explore-content-news-up').addClassName('disabled-link');

	/******************************/
	/*    Rising Stars scrolling   */
	/******************************/
	
	rising_star_thumbs = new Array();
	rising_star_top = new Array();
	rising_star_visible = new Array();
	rising_star_bottom = new Array();
	i = 0;
	markmodule.select('.txst-mainsite-rising-stars-thumb').each( function (item) {
		$('rising-stars-thumbs').appendChild(item);
		if (i) {
			item.down('a').addClassName('inactive');
			item.down('img').setStyle({opacity: 0.5});
		}
		if (i > 2) {
			item.setStyle({display: 'none'});
			rising_star_bottom.unshift(item);
		} else {
			rising_star_visible.unshift(item);
		}
		rising_star_thumbs.push(item);
		item.myRisingStarsIndex = i;
		i++;
	});
	found_rising_stars = false;
	rising_star_mains = new Array();
	i = 0;
	markmodule.select('.txst-mainsite-rising-stars-item').each( function (item) {
		if (found_rising_stars) item.setStyle({display: 'none'});
		else found_rising_stars = true;
		rising_star_mains.push(item);
		item.myRisingStarsIndex = i;
		i++;
	});
	markmodule.select('.txst-mainsite-rising-stars-thumb a').each( function (item) {
		item.observe('click', function (event) {
			this.blur();
			set_active_rising_star(this);
			event.stop();
		});
		item.down('img').observe('mouseover', function (event) {
			if (this.up('a').hasClassName('inactive')) {
				this.fade({from: 0.5, to: .8, duration: 0.2});
			}
		});
		item.down('img').observe('mouseout', function (event) {
			if (this.up('a').hasClassName('inactive')) {
				this.fade({from: .8, to: 0.5, duration: 0.2});
			}
		});
	});
		
	
	$('rising-stars-down').observe('click', function(event) {
		this.blur();
		
		// let's maintain the POSITION of the active tab
		found_active = false;
		markmodule.select('.txst-mainsite-rising-stars-thumb a').each(function (item) {
			if (!found_active && !item.hasClassName('inactive')) {
				if (item.up('div').next('.txst-mainsite-rising-stars-thumb')) set_active_rising_star(item.up('div').next('div').down('a'));
				found_active = true;
			}
		});
		
		var nextitem = rising_star_bottom.pop();
		if (nextitem) {
			var topitem = rising_star_visible.pop();
			topitem.setStyle({display: 'none'});
			rising_star_top.push(topitem);

			nextitem.setStyle({display: 'block'}); 
			rising_star_visible.unshift(nextitem);
		}
		
		event.stop();
	});
	
	$('rising-stars-up').observe('click', function(event) {
		this.blur();
		
		// let's maintain the POSITION of the active tab
		found_active = false;
		markmodule.select('.txst-mainsite-rising-stars-thumb a').each(function (item) {
			if (!found_active && !item.hasClassName('inactive')) {
				if (item.up('div').previous('.txst-mainsite-rising-stars-thumb')) set_active_rising_star(item.up('div').previous('div').down('a'));
				found_active = true;
			}
		});

		var topitem = rising_star_visible[rising_star_visible.length-1];
		var bottomitem = rising_star_visible[0];
		var previtem = rising_star_top.pop();
		if (previtem) {
			bottomitem.setStyle({display: 'none'});
			rising_star_bottom.push(bottomitem);
			rising_star_visible.shift();

			previtem.setStyle({display: 'block'});
			rising_star_visible.push(previtem);
		}
		
		event.stop();
	});
		
	/******************************/
	/*    Be A Bobcat scrolling   */
	/******************************/
	
	bobcat_thumbs = new Array();
	bobcat_top = new Array();
	bobcat_visible = new Array();
	bobcat_bottom = new Array();
	i = 0;
	markmodule.select('.txst-mainsite-bobcats-thumb').each( function (item) {
		$('bobcat-thumbs').appendChild(item);
		if (i) item.down('a').addClassName('inactive');
		if (i > 2) {
			item.setStyle({display: 'none'});
			bobcat_bottom.unshift(item);
		} else {
			bobcat_visible.unshift(item);
		}
		bobcat_thumbs.push(item);
		item.myBobcatIndex = i;
		i++;
	});
	found_bobcat = false;
	bobcat_mains = new Array();
	i = 0;
	markmodule.select('.txst-mainsite-bobcats-item').each( function (item) {
		if (found_bobcat) item.setStyle({display: 'none'});
		else found_bobcat = true;
		bobcat_mains.push(item);
		item.myBobcatIndex = i;
		i++;
	});
	markmodule.select('.txst-mainsite-bobcats-thumb a').each( function (item) {
		item.observe('click', function (event) {
			this.blur();
			set_active_bobcat(this);
			event.stop();
		});
		item.down('img').observe('mouseover', function (event) {
			if (this.up('a').hasClassName('inactive')) {
				this.fade({from: 0.5, to: .8, duration: 0.2});
			}
		});
		item.down('img').observe('mouseout', function (event) {
			if (this.up('a').hasClassName('inactive')) {
				this.fade({from: .8, to: 0.5, duration: 0.2});
			}
		});
	});
		
	
	$('bobcats-down').observe('click', function(event) {
		this.blur();
		
		// let's maintain the POSITION of the active tab
		found_active = false;
		markmodule.select('.txst-mainsite-bobcats-thumb a').each(function (item) {
			if (!found_active && !item.hasClassName('inactive')) {
				if (item.up('div').next('.txst-mainsite-bobcats-thumb')) set_active_bobcat(item.up('div').next('div').down('a'));
				found_active = true;
			}
		});
		
		// shift the images up iff there are more invisible ones below
		var nextitem = bobcat_bottom.pop();
		if (nextitem) {
			var topitem = bobcat_visible.pop();
			topitem.setStyle({display: 'none'});
			bobcat_top.push(topitem);

			nextitem.setStyle({display: 'block'}); 
			bobcat_visible.unshift(nextitem);
		}
				
		event.stop();
	});
	
	$('bobcats-up').observe('click', function(event) {
		this.blur();
		
		// let's maintain the POSITION of the active tab
		found_active = false;
		markmodule.select('.txst-mainsite-bobcats-thumb a').each(function (item) {
			if (!found_active && !item.hasClassName('inactive')) {
				if (item.up('div').previous('.txst-mainsite-bobcats-thumb')) set_active_bobcat(item.up('div').previous('div').down('a'));
				found_active = true;
			}
		});

		var topitem = bobcat_visible[bobcat_visible.length-1];
		var bottomitem = bobcat_visible[0];
		var previtem = bobcat_top.pop();
		if (previtem) {
			bottomitem.setStyle({display: 'none'});
			bobcat_bottom.push(bottomitem);
			bobcat_visible.shift();

			previtem.setStyle({display: 'block'});
			bobcat_visible.push(previtem);
		}
		
		event.stop();
	});
	
	/******************************/
	/*    Bobcat Tube scrolling   */
	/******************************/
	count = 0;
	video_mains = new Array();
	markmodule.select('.txst-mainsite-videos-item').each( function (item) {
		video_mains.push(item);
		count++;
	});
	
	count = 0;
	video_scroll_max = 0;
	markmodule.select('.txst-mainsite-videos-thumb').each( function (item) {
		if (!(count % 3)) {
			video_column = document.createElement('div');
			video_column.id = 'videos_column'+video_scroll_max;
			video_column.className = 'videos-thumbs-column';
			$('videos-thumbs').appendChild(video_column);
			video_scroll_max++;
		}
		video_column.appendChild(item);
		item.myIndex = count;
		count++;
		
		item.observe('click', function (event) {
			this.down('a').blur();
			if (video_mains[this.myIndex].getStyle('display') != 'block') {
				set_active_tube(this.myIndex);
			}
			event.stop();
		});
	});
		
	video_scroll_level = 0;
	$('videos-right').observe('click', function (event) {
		this.blur();
		if (video_scroll_level < video_scroll_max - 1) {
			var myid = 'videos_column'+video_scroll_level;
			if ($(myid)) {
				$(myid).morph('margin-left: -'+($(myid).getWidth()+50)+'px', {duration: 0.4, 
						afterFinish: function() { $(myid).setStyle({display: 'none'}); }
					});
				var scrollon = $(myid).next().next();
				if (scrollon) {
					scrollon.setStyle({marginRight: '-'+scrollon.getWidth()+'px', marginLeft: '0px'});
					scrollon.morph('margin-right: 0px', {duration: 0.4});
				}
				video_scroll_level++;
			}
			check_video_buttons();
		}
		event.stop();
	});
	$('videos-left').observe('click', function (event) {
		this.blur();
		if (video_scroll_level) {
			var myid = 'videos_column'+(video_scroll_level-1);
			if ($(myid)) {
				$(myid).setStyle({display: 'block'});
				$(myid).morph('margin-left: 0px', {duration: 0.4});
				var scrolloff = $(myid).next().next();
				if (scrolloff) {
				
					// We are running this scrolloff animation a little FASTER than the animation
					// of the current item so that it never decides to wrap down prematurely...
					// So it's possible that yet more objects off to the right will poke their heads
					// in during the animation.  We'll give them 100px padding to be sure they don't.
					// This has to be undone in the txst-events-right event!
					var remains = scrolloff.next()
					while (remains) {
						remains.setStyle({marginLeft: '100px'});
						remains = remains.next();
					}

					scrolloff.setStyle({marginRight: '-8px'});
					scrolloff.morph('margin-right: -'+scrolloff.getWidth()+'px', {duration: 0.35});
				}
				video_scroll_level--;
			}
		}
		check_video_buttons();
		event.stop();
	});
	check_video_buttons();
	
	$('explore-content').setStyle({visibility: 'visible'});
	markmodule.setStyle({visibility: 'visible'});
	$('txst-marketing-explore').addClassName('active-tab');
	setTimeout('cache_marketing_images(startabs)', 250);
	setTimeout('cache_marketing_images(cattabs)', 400);
	setTimeout('cache_marketing_images(tubetabs)', 550);
});
/* IMPORTED FROM FILE: /opt/magnolia/webapps/magnoliaAssets/txstate-home/js/khan-specialevents.js */

Event.observe(document, 'dom:loaded', function () {
	// Special Events scrolling
	var event_stack_visible = new Array();
	var event_stack_invisible = new Array();
	$$('.txst-eventsbox-entry').each( function (item) {
		// build a stack of event items
		event_stack_visible.unshift(item);
	});
	var event_total = event_stack_visible.length;
	
	$('txst-events-right').observe('click', function(event) {
		this.blur();
		event.stop();
		if (event_total < 3) return;
		if (event_stack_visible.length > 1) {
			var myitem = event_stack_visible.pop()
			
			// perform the animation
			myitem.morph('margin-left: -'+(myitem.getWidth()+50)+'px', {duration: 0.4});
			var scrollon = myitem.next().next();
			if (scrollon) {
				scrollon.setStyle({marginRight: '-'+scrollon.getWidth()+'px', marginLeft: '0px'});
				scrollon.morph('margin-right: 0px', {duration: 0.4});
			}
			
			event_stack_invisible.push(myitem);
			$('txst-events-left').removeClassName('disabled-link');
		}
		if (event_stack_visible.length < 2) {
			this.addClassName('disabled-link');
			load_alpha(this);
		}
	});
	$('txst-events-left').observe('click', function(event) {
		this.blur();
		event.stop();
		if (event_total < 3) return;
		if (event_stack_invisible.length > 0) {
			var myitem = event_stack_invisible.pop();
			
			// perform the animation
			var mywidth = myitem.getWidth();
			myitem.setStyle({display: 'block', marginLeft: '-'+mywidth+'px'});
			myitem.morph('margin-left: 0px', {duration: 0.4});
			var scrolloff = myitem.next().next();
			if (scrolloff) {
				
				// We are running this scrolloff animation a little FASTER than the animation
				// of myitem so that it never decides to wrap down prematurely...
				// So it's possible that yet more events off to the right will poke their heads
				// in during the animation.  We'll give them 100px padding to be sure they don't.
				// This has to be undone in the txst-events-right event!
				var remains = scrolloff.next()
				while (remains) {
					remains.setStyle({marginLeft: '100px'});
					remains = remains.next();
				}
				
				scrolloff.setStyle({marginRight: '-10px'});
				scrolloff.morph('margin-right: -'+scrolloff.getWidth()+'px', {duration: 0.35});
			}
			
			event_stack_visible.push(myitem);
			$('txst-events-right').removeClassName('disabled-link');
		}
		if (event_stack_invisible.length == 0) {
			this.addClassName('disabled-link');
			load_alpha(this);
		}
	});
	$('txst-events-left').addClassName('disabled-link');
	load_alpha($('txst-events-left'));

	if (event_total < 3) {
		$('txst-events-left').setStyle({display: 'none'});
		$('txst-events-right').setStyle({display: 'none'});
	}
});
/* IMPORTED FROM FILE: /opt/magnolia/webapps/magnoliaAssets/common/js/easter-egg.js */

keyCodes = new Array();
Event.observe( window, "load", function() {
        Event.observe( window, "keyup", function( event ) {
                keyCodes.push( event.keyCode );
                if ( keyCodes.length > 10 ) {
                        keyCodes.shift();
                }
                if ( keyCodes[0] == Event.KEY_UP &&
                        keyCodes[1] == Event.KEY_UP &&
                        keyCodes[2] == Event.KEY_DOWN &&
                        keyCodes[3] == Event.KEY_DOWN &&
                        keyCodes[4] == Event.KEY_LEFT &&
                        keyCodes[5] == Event.KEY_RIGHT &&
                        keyCodes[6] == Event.KEY_LEFT &&
                        keyCodes[7] == Event.KEY_RIGHT &&
                        keyCodes[8] == 66 &&
                        keyCodes[9] == 65
                    ) {
						var s = document.createElement('script');
						s.type='text/javascript';
						document.body.appendChild(s);
						s.src='/magnoliaAssets/common/js/asteroids.min.js'                
					}
        });
});

