define(['jquery'], function($) {

	//if (screen.width < 968) {
    // the width of browser is more then 700px

    	$(document).ready(function(){
			$(".section h3").click(function() {
 			$(this).toggleClass("open");
 			$(this).children().css( "background-color", "red" );


			});

			$(".right-arrow").click(function() {
 			$(this).toggleClass("down-arrow");

			});
		});	
});