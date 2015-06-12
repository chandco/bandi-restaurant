(function($) {

    var xhr;
    var findShortcodes = function( content, shortcode ) {
        var result;
        var elements = [];

        if (!shortcode) return false;

        var nextColumn = function( result ) {

            var offset;

            if (result) {
                offset = result.index + result.content.length;
            } else {
                offset = 0;
            }
            
            result = wp.shortcode.next(shortcode, content, offset);

            

            if (result) {
                elements.push( result );
                nextColumn(result);
            } else {
                return;
            }
        }

        nextColumn();
        return elements;
    }



    var contentPreview = function( content, callback ) {
            var data = {
                action: 'get_shortcode_preview',
                content: content
            };   

            console.log("Sending preview req for", content);

            return $.ajax(ajaxurl,{

                        url : ajaxurl,
                        type : 'get',
                        data : data,
                        cache : false,
                        dataType : 'json',                        

                    }).done( function( response ) {

                        console.log(response);
                        callback(response);

                    });
    }


    var handlePopUpWindow = function() {

        // this kicks off in the top window
        // don't put anything above this next line!
        if (self == top) return;

        $.fn.extend({
                addButton : function( className ) {
                    return this.append('<button class="col-control-' + className + '">' + className + '</button>');
                },

                removeButton : function( className ) {
                    return this.remove('.col-control-' + className);  
                },

                shrinker : function() {

                    var that = this;

                    if (this.find('.col-control-extend').length === 0) {
                        this.addButton( 'extend' );
                    }

                    this.find('.col-control-extend').on('click', function(e) {
                        
                        that.toggleClass('extend');

                    });

                    return this;
                }


        });

        var uid = (function(){var id=0;return function(){if(arguments[0]===0)id=0;return id++;}})();

        var $row = $('#column-row');


        


        var addColumn = function( content, $insertAfter ) {

            var $column = $('<div id="column-' + uid() + '" class="column"><div class="col-content">' + content + '</div></div>');

            var $preview = $('<div class="preview"></div>');



            

            contentPreview( content, function(response) {
                $preview.html( response );
                $column.prepend($preview);
            });

            $column
                .addButton('add')
                .addButton('remove')
                .addButton('edit')
                .shrinker()
                ;//.append("<button class='col-control-padding'>Padding</button>");


            if ($insertAfter) {
                $column.insertAfter($insertAfter);
            } else {
                $row.append( $column );    
            }            
        }

        // control buttons

        $('body')
            .on('click', '.col-control-add', function(e) {
                // add a column
                
                addColumn( "", $(this).parent('.column') );
            })
            .on('click', '.col-control-remove', function(e) {
                // remove a column
                if ( confirm('Are you sure you want to remove this column (and lose everything in it)?')) {

                    $(this).parent('.column').remove();

                } else {
                    return false;
                }
            })
            .on('click', '.col-control-edit', function(e) {
     
                e.preventDefault();
                ed.setContent( $(this).parent('.column').find('.col-content').html() );
                activeTextarea = $(this).parent('.column').attr('id');
                $ed.css('display', 'block');

            });


        var atts = parent.tinymce.activeEditor.windowManager.getParams();
        
        var columns = findShortcodes( decodeURI(atts.data), 'column' );

        

            
            columns.forEach( function( column, index ) {

                addColumn( column.shortcode.content );
                
            });

            
            var ed = tinyMCE.activeEditor;
            var $ed = $('#wp-popup-editor-wrap-wrap');

            var activeTextarea;
            
            


            $('.editor-update').on('click', function(e) {

                e.preventDefault();

                if (activeTextarea) {


                    var content = ed.getContent();

                    

                    $('#' + activeTextarea + ' .col-content').html( content );
                    var $preview = $('#' + activeTextarea + ' .preview').html( '<i class="fa fa-refresh fa-spin"></i>&nbsp;Loading New Content...' );

                    contentPreview( content, function(response) {
                        $preview.html( response );
                    });

                    $ed.css('display', 'none');
                    activeTextarea = false;
                }
            });



            $('#mce-update').on('click', function(e) {
                e.preventDefault();

                data = { columns : [] };
                $row.find('.column').each( function(index, column) { 

                    var extend = false;
                    if ( $(column).hasClass('extend') ) extend = true;

                    data.columns.push( { content: $(column).find('.col-content').html(), extend : extend } );

                });

                parent.tempNode.do_update( data );

                parent.tinymce.activeEditor.windowManager.close();


            });

            $('#mce-close').on('click', function(e) {
                e.preventDefault();

                parent.tinymce.activeEditor.windowManager.close();

            });     
    }

    var $buttons;

    tinymce.create('tinymce.plugins.cf_columns', {
        /**
         * Initializes the plugin, this will be executed after the plugin has been created.
         * This call is done before the editor instance has finished it's initialization so use the onInit event
         * of the editor instance to intercept that event.
         *
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.

         */


        init : function(ed, url) {


            function my_cleanup_callback(type,value) {
              switch (type) {
                case 'get_from_editor':
                  // Remove &nbsp; characters
                  //value = value.replace(/&nbsp;/ig, ' ');
                  break;
                case 'insert_to_editor':
                case 'submit_content':
                case 'get_from_editor_dom':
                case 'insert_to_editor_dom':
                case 'setup_content_dom':
                case 'submit_content_dom':
                default:
                  break;
              }
              return value;
            }

            

            var t = this;
          

            ed.addButton('columns', {
                title: 'Insert Columns',
                cmd: 'columns',
                image : url + '/../img/halves.png'
            });

            ed.addCommand('columns', function() {
                var selected_text = ed.selection.getContent();

                if (!selected_text) { selected_text = '&nbsp;'}
                return_text =   '[columns-box]' + encodeURI( '[column][/column][column][/column]') + '[/columns-box]';
                ed.selection.setContent(return_text);
                
            });


            

            handlePopUpWindow(); // only for the edit columns popup

      

        }

    });
 
    // Register plugin
    tinymce.PluginManager.add( 'cf_columns', tinymce.plugins.cf_columns );

    var shortcode_string = 'columns-box';
    var inner_shortcode = 'column';

    function build_column_shortcode( data ) {

        
        
        var s = '[' + shortcode_string + ']';

        var inner = '';
            data.columns.forEach( function( column, index ) {

                
                console.log(column);
                if (column.extend) {
                    inner += '[column extend]';
                } else {
                    inner += '[column]';
                }

                inner += column.content + '[/column]';
            });      


            s += encodeURI(inner);



            s += '[/' + shortcode_string + ']';


        return s;
    }

    
    
    

    window.wp.mce.views.register(shortcode_string, {



        template: wp.media.template('editor-' + shortcode_string),
        innerTemplate: wp.media.template('editor-' + shortcode_string + '-' + inner_shortcode),

        initialize: function() {
            var self = this;

            
           
            
            
            
            
        },

        getContent: function() {
            
                        
            
            
            var columns = findShortcodes( decodeURI( this.shortcode.content ), 'column' );

            // so we're going to say if you put stuff "outside" the columns then you broke it, so we can ditch the content...

            

            var output = '<div class="row"></div>';
            var $content = $(output);



            var current = this; // so ajax doesn't get confused
            current.uid =  tinyMCE.activeEditor.dom.uniqueId('mce_fb_');
            
            $content.attr("id",current.uid);

            

            $content.html( '<i class="fa fa-refresh fa-spin"></i>&nbsp;Loading New Content...' );

            
            
            // if (xhr) xhr.abort();
            contentPreview( decodeURI(this.shortcode.content), function(response) {
                
                
                $content = $( tinyMCE.activeEditor.dom.get( current.uid ) );
                $content.html( response );
            });

            
            return $content[0].outerHTML;
        },

        edit: function(data, update) { // action when clicks to edit

            var values = this.shortcode.attrs.named;
            window.tempNode = this;
            this.popupwindow(tinyMCE.activeEditor, values, data, update );       



        },

        do_update: function( data, editor, node ) { // editing complete, make the changes

            var instance = wp.mce.views.getInstance( tempNode ); // this

            

            var s = build_column_shortcode( data );
            

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
                    
                };
            }

            editor.windowManager.open( {
                title: "Edit Columns",
                url: mcedata.adminurl + 'admin.php?page=' + shortcode_string + '-edit',
                width: 1200,
                height: 800,
            },

            {
                data : this.shortcode.content
            }
                
            );
        }
        

    });
        




}(jQuery));




