/**
* @preserve Sticky Anything 2.0 | @senff | GPL2 Licensed
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

    $('a.faq').on('click',function() {
        var tab_id = $(this).attr('href').replace('#', '#sticky-');

        // Set the current tab active
        $('.nav-tab-wrapper a').removeClass('nav-tab-active');
        $('.nav-tab-wrapper a:last-child').addClass('nav-tab-active');

        // Show the active content
        $('.tabs-content').children().addClass('hide');
        $('.tabs-content div' + tab_id).removeClass('hide');
    });

    $('#sa_legacymode').on('change',function() {
        if($("#sa_legacymode").is(':checked')) {
            $("#row-dynamic-mode").removeClass('disabled-feature'); 
        } else {
            $("#row-dynamic-mode").addClass('disabled-feature');
        }
    });

    $('.form-table').on('click','.disabled-feature', function(e) {
        e.preventDefault();
    });
});
