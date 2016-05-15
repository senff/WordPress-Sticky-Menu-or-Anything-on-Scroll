/**
* @preserve Sticky Anything 1.3.1 | @senff | GPL2 Licensed
*/

jQuery(function($) {

	// --- HANDLING THE TABS ----------------------------------- 

    var hash = window.location.hash;

	$('.tabs-content').children().addClass('hide');

    if (hash != '') {
        $('.nav-tab-wrapper a[href="' + hash + '"]').addClass('nav-tab-active');
        $('.tabs-content div' + hash.replace('#', '#sticky-')).removeClass('hide');
    } else {
        $('.nav-tab-wrapper a:first-child').addClass('nav-tab-active');
        $('.tabs-content div#sticky-main').removeClass('hide');

    }

    $('.nav-tab-wrapper a').on('click',function() {
        var tab_id = $(this).attr('href').replace('#', '#sticky-');

        // Set the current tab active
        $(this).parent().children().removeClass('nav-tab-active');
        $(this).addClass('nav-tab-active');

        // Show the active content
        $('.tabs-content').children().addClass('hide');
        $('.tabs-content div' + tab_id).removeClass('hide');
    });


});
