define(['jquery', 'components/arrayForEach'], function($) {
	$(document).ready(function() {




    $('.right-content table, .left-content table').each(function(index, element) {
       	$(element).wrap('<div class="table-wrapper"><div class="table-viewport"></div></div>');

        var $wrapper = $( $(element).parents('.table-wrapper')[0] );

        $wrapper.append("<button class='table-prev'><i class='fa fa-angle-left'></i></button><button class='table-next'><i class='fa fa-angle-right'></i></button>");

        
        // if there are 6 columns then we have a label column

        var tds = $(element).find('tr:eq(0) td');

        window.newTDs = [];
        if (tds.length === 6) {
        	var trs = $(element).find('tr');

        	trs.each(function(row_index, row) {
        		newTDs.push( $(row).find('td:eq(0)')[0] );
        	});


        	var $labelColumn = $('<table class="label-column"></table>');

        	newTDs.forEach( function(td) {
        		var tr = $('<Tr></tr>');
        		tr.append(td);
        		$labelColumn.append( tr );
        	});

        	$wrapper.prepend($labelColumn);

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

		
		console.log(offset_percent);
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