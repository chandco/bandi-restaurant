({
    baseUrl: "./library/js/",
    name: "main",
    out: "./library/js/main-built.js",
    paths: {
        jquery : 'vendor/jquery-2.1.4.min'
    },
    
    shim: {
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

})

/*

require.config({

  baseUrl : rjs_baseURL,
	paths: {
        // the left side is the module ID,
        // the right side is the path to
        // the jQuery file, relative to baseUrl.
        // Also, the path should NOT include
        // the '.js' file extension. This example
        // is using jQuery 1.9.0 located at
        // js/lib/jquery-1.9.0.js, relative to
        // the HTML page.
        //jquery  : "//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min",
        app     : "../app",
        bones   : "../bones",
        'mc-validate'   : "../mc-validate",
        mailchimp : '../mailchimp',
        jqueryForm :  rjs_pluginURL + '/contact-form-7/includes/js/jquery.form.min',
        typekit : '//use.typekit.net/jfl7esy',
        jquery : '//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min'
        
    },
    "shim": {
        'slick': {
            deps: ['jquery']
        },
        'cf7' : ['jquery', 'jqueryForm'],
        'mailchimp' : ['jquery', 'mc-validate'],
        'magnific-popup' : ['jquery']
      
    }
});

*/