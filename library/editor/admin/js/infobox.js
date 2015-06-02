(function($) {

    var $buttons;

    tinymce.create('tinymce.plugins.cf_infobox', {
        /**
         * Initializes the plugin, this will be executed after the plugin has been created.
         * This call is done before the editor instance has finished it's initialization so use the onInit event
         * of the editor instance to intercept that event.
         *
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.


        
    


         */


        init : function(ed, url) {


            
            
            ed.addButton('infobox', {
                title: 'Insert info box Box',
                cmd: 'infobox',
                image : url + '/../img/infobox.png'
            });

            
            ed.addCommand('infobox', function() {
               
                var selected_text = ed.selection.getContent();
                
                //ed.execCommand('mceInsertContent', 0, return_text);
                var data = {
                        imgid: "",
                        link: "",
                        title: "Edit by Clicking",
                        linktitle: "",
                        innercontent: ""
                    }



                var tag = tinyMCE.activeEditor.selection.getNode();

                if (tag.tagName == 'A') {
                    data.link = tag.href;
                }



                data.title = selected_text;
                

                var return_text = build_feature_shortcode( data );

                tinyMCE.activeEditor.selection.select( tinyMCE.activeEditor.selection.getNode() );
                tinyMCE.activeEditor.selection.setContent( return_text );


            });

           

            

            // Just the columns, start with two, add more if needed.  in the future we can add a feature to add predefined layouts with less functionality but
            // for the most part it should be enough for uniformity.  We could also maybe add in a class to set the width dynamically.

            // eg "col-smart' but :first-of-type { width 66% } for wider etc"

            
        },

        /**
        * Returns information about the plugin as a name/value array.
        * The current keys are longname, author, authorurl, infourl and version.
        *
        * @return {Object} Name/value array containing information about the plugin.
        */
        getInfo : function() {
            return {
                longname : 'Nathans Wordpress Starter Theme Editor Features',
                author : 'Nathan',
                authorurl : 'http://cowfields.co.uk',
                version : "0.1"
            };
        }
    });
 
    // Register plugin
    tinymce.PluginManager.add( 'cf_infobox', tinymce.plugins.cf_features );

    var shortcode_string = 'infobox';
    function build_feature_shortcode( data ) {

        
        var s = '[' + shortcode_string;

                            
                            //s += ' img="' + data.img + '" ';
                            // s += ' imgid="' + data.imgid + '" ';
                            // s += ' link="' + data.link + '" ';
                            s += ' title="' + data.title + '" ';
                            // s += ' linktitle="' + data.linktitle + '" ';
                            // s += ' colour="' + data.colour + '" ';
                            // s += ' icon="' + data.icon + '" ';
                                
                            s += ']';
                            s += data.innercontent;
                            s += '[/' + shortcode_string + ']';


        return s;
    }

    
                
    window.wp.mce.views.register(shortcode_string, {


        template: wp.media.template('editor-' + shortcode_string),

        initialize: function() {
            var self = this;

            
         
            
            
            
        },

        getContent: function() {
            var options = this.shortcode.attrs.named;
            options['innercontent'] = this.shortcode.content;



            
            // format the template
            var output = this.template(options);

            // get HTML as Jquery object
            $content = $(output);

           
            // add in the image from the id

            // get image SRC

           

            // replace the image content;     
            return $content[0].outerHTML;
        },

        edit: function(data, update) { // action when clicks to edit

            var values = this.shortcode.attrs.named;
            window.tempNode = this;
            this.popupwindow(tinyMCE.activeEditor, values, data, update );       



        },

        do_update: function( data, editor, node ) { // editing complete, make the changes

            var instance = wp.mce.views.getInstance( tempNode ); // this

            console.log( instance );

            var s = build_feature_shortcode( data );
            

            // tinyMCE.activeEditor.insertContent( s ); 
            //editor.insertContent( s );

            

            wp.media.editor.insert(s);

            // hack to force a refresh of the content
            var html = tinyMCE.activeEditor.getContent();
            tinyMCE.activeEditor.setContent( html );
            
            // remove global object.
            window.tempNode = false;
            
            

        },

        popupwindow: function(editor, values, node, onsubmit_callback) {
                        
            if(typeof onsubmit_callback != 'function'){
                onsubmit_callback = function( e ) {
                    // not being called right now
                    console.log(e);
                    console.log("Submit Callback");
                };
            }

            editor.windowManager.open( {
                title: "Edit Info Box",
                url: mcedata.adminurl + 'admin.php?page=' + shortcode_string + '-edit',
                width: 900,
                height: 700,
            },

            {
                data : values
            }
                
            );
        }
        

    });
        




}(jQuery));


