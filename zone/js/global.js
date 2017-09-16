jQuery("document").ready(function($){
    
    var nav = $('.main-navbar');
    
    $(window).scroll(function () {
        if ($(this).scrollTop() > 40) {
            nav.addClass("navbar-fixed-top");
        } else {
            nav.removeClass("navbar-fixed-top");
        }
    });
 
});

// $(function(){
//   $('.main-navbar').data('size','big');
// });

// $(window).scroll(function(){
//   if($(document).scrollTop() > 160)
// {
//     if($('.main-navbar').data('size') == 'big')
//     {
//         $('.main-navbar').data('size','small');
//         $('.main-navbar').stop().animate({
//             height:'50px'
//         },600);
//     }
// }
// else
//   {
//     if($('.main-navbar').data('size') == 'small')
//       {
//         $('.main-navbar').data('size','big');
//         $('.main-navbar').stop().animate({
//             height:'100px'
//         },600);
//       }  
//   }
// });