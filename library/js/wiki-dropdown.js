define(['jquery', 'vendor/velocity'], function($, Velocity) {

    // the width of browser is more then 700px
    	$(document).ready(function(){

    		//Add open class on only article clicked on and fade in close panel
			$("article h2").click(function() {
				$(this).parent().toggleClass("open");
			});

			//When close panel clicked, only close the active article
			// Scroll to the top of the button
			$(".close-sub-section").click(function(){
				var $parent = $(this).parents('.section');
				$parent.removeClass("open");

				var scrollto = $parent.offset().top - 50;

				$('html, body').animate({
			        scrollTop: scrollto
			    }, 50);


			});
			
		});	
});