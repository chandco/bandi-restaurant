define(['jquery', 'vendor/steady', 'plugins/jquery-scrollto', 'plugins/isonscreen', 'plugins/isinviewport'], function($, Steady) {
  

  // don't do anything if we're not on a wiki page, and don't do anything for mobiles
  if ($('#wiki-content').length == 0) {
    return;
  }

  if (screen.width <= 968) {
    console.log("mobile...exiting");
    return;
  }
  


  // Manual for Steady: https://lafikl.github.io/steady.js/

  /*
  * Steady initiates, adds a handler (fn) and a throttle - throttle stops it firing too often.
  * Fire too often and the browser may chug a bit.  Fire too little and a highlight might be 'missed' as 
  * the user scrolls
  */
  var ste = new Steady({
      throttle: 100,
      handler: fn
  });

  // Add a tracker to the Steady instance.  This basically defines a 'thing' to watch on scroll.
  // #head-top is not an id of an element but a Steady id.  
    
  // el = is the scrollElement if specified or window.
  // We don't want to specify an element as we're scrolling the whole page but if this 
  // was to be a scrolling div then we'd configure that in the options above
  ste.addTracker('#head-top', function(el) {

    // the tracker function is a little method to pull a number (or whatever, it could be anything we return)
    // to send to our handler function.  Thus the process goes like this:


    /*

    User Scrolls -> (Throttled) Event Fires 
                                          -> Tracker function gets some data
                                          -> Data from tracker sent to handler function (fn in this case)
                                          -> Fn does whatever we want until we say it's 'done'
                                          -> Scroll event won't fire until the above is finished to avoid 'jank'


    */
      
    // it's really simple, we just want to work out the viewport height and use that to work out where an element is
      return $( window ).height();
  });


    // Addding a
    ste.addCondition('min-#head-top', 0);


    function fn(values, done) {
      
      // values is a key/value pair object where the key is the tracker id (#head-top) and the value is whatever
      // returned from the tracker function above. (rect.bottom in this case)

      // Get our articles...
      var $elems = $('.article-div');
      
      // ...loop through them - this is potentially a very heavy operation.  
      // I'd think of another way if it gets slow but then again since this is a throttled function
      // it won't fire too often.  If we had a much 'heavier' page we'd have to worry about a better method.

      var clientHeight = values['#head-top'];
      console.log( clientHeight );

      var hasActive = false; // more on this later


      function getLinkItem(element) {
        // get the corresponding link item for element
        return $( '#' + $(element).data('link') );
      }

      


      $elems.each(function(index, element) {
            
          var title = $(element).find('h3').text();

          // 
          var articleTop = element.getBoundingClientRect().top;
          var articleBottom = element.getBoundingClientRect().bottom;

          // So...if Top is 0 then the TOP of the element is at the TOP of the viewport.
          // if it is LESS THAN 0, i.e. negative number then it is above the viewport.

          // if BOTTOM is LESS THAN 0 then the BOTTOM (and thus the top) is now ABOVE the viewport.

          // and so on...

          // thus our code is...

          console.log(title, articleTop, articleBottom);

          var offset = clientHeight * 0.2; // why this? because we want to turn an article "off" as it nears the top of the viewport, in this case 20% (0.2)

          if (articleBottom < offset) {
            
            // Because we want to consider this "gone" when it's nearly past, so that the next one in view can be highighted
            // element has passed the top 20% area of the viewport. This would naturally mean the next article is in the next 80% of the viewport, and thus above the fold
            getLinkItem(element).removeClass('current').removeClass('future').addClass('past');
          

            // return true to skip the rest of this code and move to the next element in the loop
            return true;
          }


          if (articleTop > clientHeight) {
            // the element is 'below the fold' i.e. we need to scroll down to see it
            getLinkItem(element).removeClass('current').removeClass('past').addClass('future');
           

            // return true to skip the rest of this code and move to the next element in the loop
            return true;
          }



          // if we are this far then the element is in the viewport, so we can set it active

          if (hasActive) { // then we have an active element, so let's not highlight anything else
            getLinkItem(element).removeClass('current').removeClass('past').addClass('future');
            return true; //
          
          } else {
            // if we haven't told the loop that active exists, then make something active.



            getLinkItem(element).removeClass('past').removeClass('future').addClass('current');

            // and set the browser URL to the current ID
            var anchor = $(element).attr("id");

                if(history.pushState) {
                history.pushState(null, null, '#' + anchor);
            }
            else {
                location.hash = anchor;
            }

            


            // set the hasActive variable to true indicating the next item in the list that it shouldn't be highlighted as active.
            // Let's say an element is small enough to be in the viewport
            hasActive = true;
             return true; //
          }



          
      	
       });

      // now the loop has finished, set the parents of active lis

      $('li.parent').removeClass('active-parent');
      $('li.current').closest('.parent').addClass('active-parent');

      

      
      done();
    }

    // just to kick this thing off before the first scroll, fire the function once:
    fn( {
      '#head-top' : $( window ).height()
    }, function() {return; });
});