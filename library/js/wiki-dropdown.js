define(['jquery'], function($) {

	//if (screen.width < 968) {
    // the width of browser is more then 700px


    	$(document).ready(function(){

    		//Add open class on only article clicked on and fade in close panel
			$("article").click(function() {
			$(this).addClass("open");
			if ($(this).hasClass("open")) {
 				$(this).next().fadeIn("slow");
 			}
		});

			//When close panel clicked, only close the active article
			$(".close-sub-section").click(function(){
				$(this).prev().removeClass("open");
				$(this).fadeOut("slow");
  				$(this).prev().find("span").removeClass("down-arrow");
			});
			

			$(".right-arrow").click(function() {
 				$(this).addClass("down-arrow");

			});
		});	
});