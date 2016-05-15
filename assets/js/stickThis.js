/**
* @preserve Sticky Anything 2.0 | @senff | GPL2 Licensed
*/

(function($) {
	$(document).ready(function($) {

		var thisIsSomeBreakpoint = '' // solely to use as a breakpoint, if needed.

		$(sticky_anything_engage.element).stickThis({
			top:sticky_anything_engage.topspace,
			minscreenwidth:sticky_anything_engage.minscreenwidth,
			maxscreenwidth:sticky_anything_engage.maxscreenwidth,
			zindex:sticky_anything_engage.zindex,
			dynamicmode:sticky_anything_engage.dynamicmode,
			debugmode:sticky_anything_engage.debugmode,
			pushup:sticky_anything_engage.pushup,
			adminbar:sticky_anything_engage.adminbar
		});

	});
}(jQuery));
