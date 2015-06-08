define(['jquery', 'components/arrayForEach'], function($) {

    // stop executing for <IE10
    console.log("check...");   

    if (!('visibilityState' in document)) return;

    console.log("Table");


	$(document).ready(function() {


    if ($('.page-template-template-home').length === 0) return;


    $('.right-content table, .left-content table').each(function(index, table) {
       	$(table).wrap('<div class="table-wrapper"><div class="table-viewport"></div></div>');

        var $wrapper = $( $(table).parents('.table-wrapper')[0] );

        $wrapper.append("<button class='table-prev'><i class='fa fa-angle-left'></i></button><button class='table-next'><i class='fa fa-angle-right'></i></button>");


        
        // if there are 6 columns then we have a label column

        var tds = $(table).find('tr:eq(0) td');

        var days = [
        'sunday', 'monday','tuesday','wednesday', 'thursday','friday', 'saturday'
        ];

        var d = new Date();
		var today = d.getDay();
		var today_cell_index;

        

        $(tds).each( function( index, td ) {

           

        	var cell = $(td).text().toLowerCase();

        	days.forEach( function(day, dayIndex) {
        		if ( day.indexOf( cell ) != -1 ) {
        			

        			$(td).addClass(day);



        			if (today == dayIndex) {
        				$(td).addClass('today');
        				today_cell_index = index; // NOT DAY INDEX, BUT THE INDEX OF THE TABLE CELL
        			}

        		}
        	});

        	

        	

        });


     //   console.log(today, days[today_cell_index]);

        $(table).find('tr').find('td:eq(' + today_cell_index + ')').addClass('today');



        window.newTDs = [];
        if (tds.length === 6) {


        	var $labelColumn = $('<div class="label-column"></div>');

            var idcounter = 1;
            $(table).find('td').each(function(index, cell) {
                $(cell).addClass('td-id-' + idcounter);
                idcounter++;
            });

            $(table).find('tr').each(function(index, row) {
                
                $(row).addClass('tr-id-' + idcounter);
                idcounter++;
                    
            });

            var $clone = $(table).clone();

        	$labelColumn.append( $clone );

        	$wrapper.prepend($labelColumn);

           

            var recheckHeights = function() {
                var width = document.documentElement.clientWidth;
            
                


                // get the height of everything
                $(table).find('td').not('td:first-child').each(function(index, row) {
                   
                    $(".label-column ." + this.className).width( $(this).width() );
                });

                $(table).find('tr').each(function(index, row) {
                    
                    $(".label-column ." + this.className).height( $(this).height() );
                });


                if (width < 768) {

                    window.$trs = [];
                    $(".label-column tr td:first-child").each(function(index,row) {

                        $(row).css( 'width' ,'100%').css('display','block').css( 'height', $(row).parent('tr').css('height') );
                    });

                } else {
                    $clone.find('td:first-child').width( $labelColumn.width() );

                }

                    
                
                
            };

            recheckHeights();

            $(window).on('resize', recheckHeights);



        }


        var moveColumns = function(btn, move, e) {
        	e.preventDefault();
        	var $container = $(btn).prevAll('.table-viewport');       	
        	Animating = false;
        	checkTablePosition($container, move);
        };

		$('.table-next').click(function(e) {
        	
        	moveColumns( this, 20, e);
        	
		});

		$('.table-prev').click(function(e) {
        	
        	moveColumns( this, -20, e);
		});

		// finally, scroll to today

		Animating = false;


        checkTablePosition($($wrapper).find('.table-viewport'), 20 * (today_cell_index-1));

    });

    


    var rtime = new Date(1, 1, 2000, 12,0,0);
	var timeout = false;
	var delta = 50;

	var scrollFinishTimer;
	var scrollFinishCount = 0;
	var Animating;

        // used below for resize throttling
	function debounce( callback, args ) {
	    if (new Date() - rtime < delta) {
	        setTimeout(function() {
	            debounce( callback, args );
	        }, delta);
	    } else {
	        timeout = false;
	        
	        callback(args);
	    }               
	}

	

	function checkTablePosition(element, move) {

		

		if (Animating) {
			return;
		}

		move = move || 0;

		var $table = $(element).find('table');

		if ($table.length === 0) return;

		var width = $( $table[0] ).width();
		var left = $(element).scrollLeft();

		// we're assuming 5 here
		var offset = Math.round((100 * (left / width)) / 20) * 20;
		var offset_percent = (offset + move) / 100; 

		

		Animating = true;

		$(element).animate({ scrollLeft: (offset_percent * width) }, 200, function() {
			Animating = false;
		});





	}


      
   
   	$(".table-viewport").scroll(function() {
            
        var element = this;
        rtime = new Date();
		if (timeout === false) {
	        timeout = true;

		    setTimeout(function() {
		      	debounce(checkTablePosition, element); // , args if needed
		    }, delta);
	    }


    });





  });
});