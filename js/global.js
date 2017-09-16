$(document).ready(function(){
        var chImgLink = "https://www.tousrenov.fr/images/switzerland.png";
    	var frImgLink = "https://www.tousrenov.fr/images/france.png";
		var beImgLink = "https://www.tousrenov.fr/images/belgium.png";

		var imgNavFra = $('#imgNavFra');
		var imgNavFr = $('#imgNavFr');
		var imgNavCh = $('#imgNavCh');
		var imgNavBe = $('#imgNavBe');
    
        var lanNavBe = $('#lanNavBe');
		var lanNavCh = $('#lanNavCh');
		var lanNavFr = $('#lanNavFr');
		var lanNavFra = $('#lanNavFra');

		var spanNavSel = $('#lanNavFra');
		var spanBtnSel = $('#lanNavFra');

		imgNavCh.attr("src",chImgLink);
		imgNavFr.attr("src",frImgLink);
		imgNavBe.attr("src",beImgLink);
		imgNavFra.attr("src",frImgLink);
    
        lanNavCh.attr("src",chImgLink);
		lanNavFr.attr("src",frImgLink);
		lanNavBe.attr("src",beImgLink);
		lanNavFra.attr("src",frImgLink);

		$( ".language" ).on( "click", function( event ) {
			var currentId = $(this).attr('id');

			if(currentId == "navFr") {
				imgNavFra.attr("src",frImgLink);
				spanNavSel.text("Fr");
			} else if (currentId == "navCh") {
				imgNavFra.attr("src",chImgLink);
				spanNavSel.text("Ch");
			} else if (currentId == "navBe") {
				imgNavFra.attr("src",beImgLink);
				spanNavSel.text("Be");
			}  

		});
});

jQuery("document").ready(function($){
    
    var nav = $('.navbar');
    
    $(window).scroll(function () {
        if ($(this).scrollTop() > 40) {
            nav.addClass("navbar-fixed-top");
        } else {
            nav.removeClass("navbar-fixed-top");
        }
    });

    $('.infinite-scroll').jscroll({

    // Enable debug mode
    debug: false,

    // When set to true, triggers the loading of the next set of content automatically when the user scrolls to the bottom of the containing element. 
    // When set to false, the required next link will trigger the loading of the next set of content when clicked.
    autoTrigger: true,

    // Set to an integer great than 0 to turn off autoTrigger of paging after the specified number of pages. 
    // Requires autoTrigger to be true.
    autoTriggerUntil: false,

    // The HTML to show at the bottom of the content while loading the next set.
    loadingHtml: '<img src="loading.gif" alt="Loading" /> Loading...', 

    // The distance from the bottom of the scrollable content at which to trigger the loading of the next set of content. 
    padding: 20, 

    // The selector to use for finding the link which contains the href pointing to the next set of content.
    nextSelector: 'a.jscroll-next:last', 

    // A convenience selector for loading only part of the content in the response for the next set of content. 
    contentSelector: 'li',

    // Optionally define a selector for your paging controls so that they will be hidden, 
    // instead of just hiding the next page link.
    pagingSelector: '',

    // Optionally define a callback function to be called after a set of content has been loaded.
    callback: false

    });

    $("#services-carousel").owlCarousel({
     
        // Most important owl features
        items : "3",
        itemsCustom : false,
        itemsDesktop : [1199,4],
        itemsDesktopSmall : [980,3],
        itemsTablet: [768,2],
        itemsTabletSmall: false,
        itemsMobile : [479,1],
        singleItem : false,
        itemsScaleUp : false,
     
        //Basic Speeds
        slideSpeed : 200,
        paginationSpeed : 800,
        rewindSpeed : 1000,
      
        //Autoplay
        autoPlay : true,
        stopOnHover : true,
     
        // Navigation
        navigation : true,
        navigationText : ["<i class='fa fa-angle-left' aria-hidden='true'></i>","<i class='fa fa-angle-right' aria-hidden='true'></i>"],
        rewindNav : true,
        scrollPerPage : false,
     
        //Pagination
        pagination : true,
        paginationNumbers: false,
     
        // Responsive 
        responsive: true,
        responsiveRefreshRate : 200,
        responsiveBaseWidth: window,
     
        // CSS Styles
        baseClass : "owl-carousel",
        theme : "owl-theme",

    })


    $("#clients-logos").owlCarousel({
     
        // Most important owl features
        items : "6",
        itemsCustom : false,
        itemsDesktop : [1199,4],
        itemsDesktopSmall : [980,6],
        itemsTablet: [768,2],
        itemsTabletSmall: false,
        itemsMobile : [479,1],
        singleItem : false,
        itemsScaleUp : false,
     
        //Basic Speeds
        slideSpeed : 200,
        paginationSpeed : 800,
        rewindSpeed : 1000,
      
        //Autoplay
        autoPlay : true,
        stopOnHover : true,
     
        // Navigation
        navigation : true,
        navigationText : ["<i class='fa fa-angle-left' aria-hidden='true'></i>","<i class='fa fa-angle-right' aria-hidden='true'></i>"],
        rewindNav : true,
        scrollPerPage : false,
     
        //Pagination
        pagination : true,
        paginationNumbers: false,
     
        // Responsive 
        responsive: true,
        responsiveRefreshRate : 200,
        responsiveBaseWidth: window,
     
        // CSS Styles
        baseClass : "owl-carousel",
        theme : "owl-theme",

    })
 
});
