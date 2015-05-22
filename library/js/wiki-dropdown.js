define(['jquery'], function($) {

	//if (screen.width < 968) {
    // the width of browser is more then 700px

    	$(document).ready(function(){
			$(".section").click(function() {
 			$(this).toggleClass("open");

 			$( "close-sub-section" ).each(function() {
 			 $( this ).click(function(){
 			 	alert('clicked');

 			 });
});

			});
		});
	

});