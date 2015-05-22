define(['jquery'], function($) {
	
	$(document).ready(function(){

	$(".section").click(function() {
 
    if ( $(this).toggleClass("open") ) {
    	$(this).css('height', "500px");
   
    }
 
});


	});
});