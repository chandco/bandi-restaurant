define(['jquery'], function($) {
	
	$(document).ready(function(){

	$(".section").click(function() {
 
    if ( $(this).hasClass("close") ) {
 
        $(this)
        	.removeClass("close")
        	.addClass("open");
 
    }
 
});
 
}

	});
});