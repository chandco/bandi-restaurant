define(['jquery', 'vendor/steady'], function($, Steady) {
  var ste = new Steady({
      throttle: 100,
      handler: fn
    });
    
    // el = is the scrollElement if specified or window.
    ste.addTracker('#head-top', function(el) {
      var rect = document.body.getBoundingClientRect();
      return rect.bottom;
    });


    ste.addCondition('min-#head-top', 0);

    function fn(values, done) {
      
      var $elems = $('#wiki-content article');
      console.log(values);
      $elems.each(function(index, element) {
      console.log(element.getBoundingClientRect().top, element );
      	
      	if ( $(element).is( ':in-viewport(-25)' ) ) {

      	
      	// if (element.getBoundingClientRect().top < 200 && element.getBoundingClientRect().top > 0) {

      		var anchor = $(element).attr("id");

      		$("#skrollr-nav li.selected").removeClass('selected');
      		$("#link-" + anchor).addClass('selected');
      		if(history.pushState) {
			    history.pushState(null, null, '#' + anchor);
			}
			else {
			    location.hash = anchor;
			}
      		return false;

      	}
      	
      });
      
      done();
    }
});