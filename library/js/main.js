
requirejs.config({ 
  paths: {
    jquery : 'vendor/jquery-2.1.4.min'
  },
  "shim": {
        'vendor/slick': {
            deps: ['jquery']
        },
        // 'cf7' : ['jquery', 'jqueryForm'],
        'vendor/mailchimp' : ['jquery', 'vendor/mc-validate'],
        'vendor/magnific-popup' : ['jquery'],
        'cf7' : ['jquery', 'vendor/jquery.form.min'],
        'plugins/jquery-isonscreen' : ['jquery'],
        'plugins/jquery-visualnav' : ['jquery'],
        'plugins/jquery-scrollto' : ['jquery'],
        'vendor/modernizr': {
          exports: 'Modernizr'
        },
      
  }


});






require(["smoothscroll"]);
require(["scroll-nav"]);

require(["wiki-dropdown"]);



/* 
  ALWAYS ON STUFF 
  Basically anything that we would want on every page, not conditional on what's there, eg responsive stuff.
*/


require(["vendor/modernizr"]);


require(['navigation']);


// Stuff for layout when the window loads / resizes
// require(['components/resize-fix']);

// init magnific popup stuff.  Probably should load conditionally, but people could use it anywhere.  Perhaps we should avoid for homepage?
require(['components/popups']);

// init carousels
require(['components/carousel']);


require(['jquery'], function($) {

  // only load the form if the form is there.

  if ($('.wpcf7-form').length) {
    // Load CF7 JS only if there's actually a form.
    require(['cf7']);
  }

  if ($('#mc_embed_signup').length) {
    // basically takes the MC stuff and loads it "our way";]
    require(['vendor/mailchimp']);
  }




});
  



require(['responsive-table']);