define(['jquery'], function($) {
	
	$(document).ready(function(){


	showSubSection = function() {
    	$(this).click(function(){
    		$(this).closest('.wiki-text').toggle();
			});
		}

	});
});