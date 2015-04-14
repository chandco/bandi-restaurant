# Wordpress Starter Theme

This is a generic theme that includes as many components that we *might* need, with as minimal stylings as possible but some layout to make it easy to skin builds based on the kind of sites we build.  It doesn't work for everyone and it's not supposed to be some easy fit-all starter theme for developers, it's basically a personal kind of build.

## To do list:

* Add gulp or grunt config to create wordpress style responsive images for the theme images
* add some kind of placeholder for the logo?  an SVG such that in other builds you just change the SVG code
* Add some carousel system.  Attached images define the carousel?  
* Basic Layout in LESS:
	* Colours in variables.less
	* Header
	* Navigation (responsive menu)
	* Content layout
	* Gallery
	* Carousel (swipe to change?)
	* Column System (with shortcode)
	* Widget layout areas
	* Finish contact form styles
* Add Widget Areas based on example layouts
	* Footer Widgets
	* Sidebar Widgets (general sidebar)
* Shortcodes:
	* Column System
	* create cut and paste exaple for CF7
	* FAQ system.
* JS
	* Google Analytics system.  Perhaps add the config in wordpress options?
	* analytics inview etc events system
* Yarp
* Lazy Load Blog



## Some details:

* It's made from Bones.  If Bones ever updates, we may want to look into that
* There'll be a whole bunch of sites that evolved from this.  If things are added to those sites, we may want to update this site.  I'm not sure of a way to do this automatically, one day perhaps we could build some config hooks.

## Plugins Installed

These will be installed by the theme, assuming you follow the instructions (thanks to https://github.com/thomasgriffin/TGM-Plugin-Activation)

* Yoast SEO
* Contact Form 7
* Contact Form 7 Database
* Disable Comments
* JSON Rest API
* regenerate Thumbnails
* Media Tags
* EWWW Image Optimiser

## Javascript

I'm taking a personal approach to JS using Require.js so be careful if this is ever going to be a build that might use a bunch of other plugins that might clash with the normal wp_enqueue system.

that said, jquery is still properly included which is the main dependency and nothing is deregistered, but the async nature of require.js means a lot of included JS files may not behave how you want with other plugins.  But I don't want to use plugins as much as possible.

### External JS Libraries:

* Jquery (enqueued in wordpress)
* require.js (in the footer)
* imagesloaded
* responsive images polyfill
* Skrollr
* cycle2
* Modernizr
* Magnific Popup

The above, other than Jquery and Require.js are loaded *through* require.js - so they only load if you code them to.  It means that if you dont' want to use, say, Skrollr you don't have to remove it or anything.

The idea is I'm going to add as much 'stuff' as I might ever use such that I don't have to keep looking for it each time.  I realise this is the kind of thing that package.json would solve but I have to take this kind of automation in stages

## PHP External Libraries

Just using Mobile_Detect.php at the moment, and I'm not sure if I'm going to implement it.

## CSS

CSS is generally the kidn of thing that can and will be totally overridden in builds that grow from this starter theme, but generally the layout is clear and obvious in the documentation of less/main.less

Setup the preprocessor to compile to css/main.css (not in the same folder as the less files)

## PHP Setup

This is a list of the general wordpress setup that gets things the way I like them.


### SCRIPTS AND CSS	
* lib/scripts.php	

	* Remove Style.css
	* Only enqueue jquery
	* dequeue anything else
	* enqueue css
	* enqueue any custom fonts from external sources etc fonts.com
	
* footer.php
	* manually add requirejs
	
### MEDIA	
* lib/images.php
	* add repsonsive srcset when adding media to wordpress editor.  This takes over the insert media markup and drastically changes it to make responsive inline images.
* lib/gallery.php
	* Cleanup Gallery Markup
	* oikos - only show gallery-full for gallery, don't show fullsize
	* show smallersize for tablets / mobiles

### RESPONSIVE	
* vendor-lib/mobile-detect.php	
	* require_once when needed
	
### AUTHORING	
* lib/shortcodes.php
	* column system
	
### THEME SETUP	

Commented out but there if you need: 

* lib/taxonomies.php  
custom taxonomies if needed
* lib/cpt.php  
custom post type if needed
	
	
### TEMPLATES	

These are basic until the theme needs change.  We might want to add some author stuff here.

* page	
* archive	
* category	
* single	
* homepage	
	
	
### CONTENT PARTS	
* content.php	Basic news story
* content-snippet.php	Post in a feed (is this the right naming convention?)