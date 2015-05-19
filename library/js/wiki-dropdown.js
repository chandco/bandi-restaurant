define(['jquery'], function($) {
	

	function showWikiContent(wikiID) {
     $('.box').each(function(index) {
          if ($(this).attr("id") == wikiID) {
               $(this).show(200);
          }
          else {
               $(this).hide(600);
          }
     });
}
  
});