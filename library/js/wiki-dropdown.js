define(['jquery'], function($) {

	
    // the width of browser is more then 700px


    	$(document).ready(function(){


    		//Add open class on only article clicked on and fade in close panel
			$("article h3").click(function() {
			$(this).parent().toggleClass("open");
			if ($(this).hasClass("open")) {
 				$(this).next().fadeIn("fast");
 			}
		});

			//When close panel clicked, only close the active article
			$(".close-sub-section").click(function(){
				$(this).prev().removeClass("open");
				$(this).fadeOut("medium");
  				$(this).prev().find("span").removeClass("down-arrow");
			});
			

			$(".right-arrow").click(function() {
 				$(this).addClass("down-arrow");

			});
		});	
});