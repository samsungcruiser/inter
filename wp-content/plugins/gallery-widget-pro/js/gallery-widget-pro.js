document.observe('dom:loaded', function() {
	$$('.crossfade > *').invoke('setStyle', {position:'absolute'});
	$$('.crossfade:not(.transition-fadeoutresizefadein)').each(function (el) {
		var h = el.childElements().map(function(s){
			return s.getHeight();
		}).max();
		el.setStyle({height:h+'px'});
		var w = el.getWidth();
		el.childElements().invoke('setStyle', {width:w+'px', textAlign:'center'});
	});
})