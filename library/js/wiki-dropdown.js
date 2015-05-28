define(['jquery', 'vendor/velocity'], function($, Velocity) {

<<<<<<< HEAD
	
=======
>>>>>>> develop
    // the width of browser is more then 700px
    	$(document).ready(function(){


    		//Add open class on only article clicked on and fade in close panel
<<<<<<< HEAD
			$("article h3").click(function() {
			$(this).parent().toggleClass("open");
			if ($(this).parent().hasClass("open")) {
 				$(this).parent().next().fadeIn("fast");
 				$(this).removeClass("right-arrow");
 				$(this).addClass("down-arrow");
 			} else {
 				$(this).removeClass("down-arrow");
 				$(this).addClass("right-arrow");
 			}
		});

			//When close panel clicked, only close the active article
			$(".close-sub-section").click(function(){
				$(this).prev().removeClass("open");
				$(this).fadeOut("medium");
  				//$(this).prev().find("span").removeClass("down-arrow");
			});
			

			
=======
			$("article h2").click(function() {
				$(this).parent().toggleClass("open");
			});

			//When close panel clicked, only close the active article
			$(".close-sub-section").click(function(){
				var $parent = $(this).parents('.section');
				$parent.removeClass("open");				
			});
			
>>>>>>> develop
		});	
});