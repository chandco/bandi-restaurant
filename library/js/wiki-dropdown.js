define(['jquery'], function($) {

	//if (screen.width < 968) {
    // the width of browser is more then 700px


    	$(document).ready(function(){
			$("article").click(function() {
				$(this).addClass("open");
				if ($(this).hasClass("open")) {
 			$(".close-sub-section").fadeIn("slow");
 			
 			}
		});


			$(".close-sub-section").click(function(e){
				if ($("article").hasClass("open")) {
  					$("article").removeClass("open");
  					$(".down-arrow").removeClass("down-arrow");
  					e.stopPropagation();
				} 
			});
			

			$(".right-arrow").click(function() {
 				$(this).addClass("down-arrow");

			});
		});	
});