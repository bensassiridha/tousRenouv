jQuery(function($){
 
 /* Footer widgets*/
    var sidebars = $('#footer-widgets'); 
    
    $.each(sidebars, function() {

        var widgetCount = $(this).find('.widget').length;
        var widgetArray = $(this).find('.widget');
        
        widgetArray.last().addClass( 'last' );
        
        if ( widgetCount == 2) {
            widgetArray.addClass('one-half');
        }else if ( widgetCount == 3 ) {
            widgetArray.addClass('one-third');
        }else if ( widgetCount == 4 ) {
            widgetArray.addClass('one-fourth');
        };
    
    });
        
});