define(['jquery'], function($) {
	

	showonlyone = function (thechosenone) {
     $('.wiki-text').each(function(index) {
          if ($(this).attr("id") == thechosenone) {
               $(this).slideDown(200);
          }
          else {
               $(this).slideUp(600);
          }
     });
}
  
});