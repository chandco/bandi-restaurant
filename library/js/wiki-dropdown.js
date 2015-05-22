define(['jquery'], function($) {
	
	$(document).ready(function(){

	$(".section").click(function() {
 
    if ( $(this).toggleClass("open") ) {
    	$("open").css('height', "500px");
   
    }
 
});


	});
});