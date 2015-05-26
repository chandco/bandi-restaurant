define(['jquery'], function($) {

	//if (screen.width < 968) {
    // the width of browser is more then 700px

    	$(document).ready(function(){
			$("article").click(function() {
 			$(this).addClass("open");
			});


			$(".close-sub-section").click(function(e){
				if ($("article").hasClass("open")) {
  				$("article").removeClass("open");
  				e.stopPropagation();
				} 

			});
			


			$(".right-arrow").click(function() {
 			$(this).toggleClass("down-arrow");

			});
		});	
});