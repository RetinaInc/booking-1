$(document).ready(function(){
    $(".coursedetails").colorbox();

      // toggle textarea in showspec
    $('.toggleme').live('click', function(event) {
        event.preventDefault();
        $('#togglethis').slideToggle("slow");
    });




// not working auto submit

   $("#trainer_name").change(function()  {
    $('#autosubmit').submit();
   });



        // for sorting courses, This works fine :-)
// add rel=imagebox-all to cildren of li, originally it added to a tag
// It is for lightbox effect
//$('ul#portfolio li').children().attr('rel', 'imagebox-all');

// #filter is the index li to click for filtering
	$('ul#filter a').click(function(event) { // when you click one of a tag
		// $(this).css('outline','none');
                event.preventDefault();
		$('ul#filter .current').removeClass('current');
		$(this).parent().addClass('current');

                var type = $(this).attr('href');
		if(type == 'all') {
			$('ul.applications li.hidden').fadeIn('slow').removeClass('hidden');
			//$('ul.applications li').children().attr('rel', 'imagebox-all');
		} else {

			$('ul.applications li').each(function() {
				if(!$(this).hasClass(type)) {
					$(this).fadeOut('normal').addClass('hidden');
				} else {
					$(this).fadeIn('slow').removeClass('hidden');
				}
			});
		}
	});


        // exactly same as above. for indexnew

        $('ul#filter a').click(function(event) { // when you click one of a tag
		// $(this).css('outline','none');
                event.preventDefault();
		$('ul#filter .current').removeClass('current');
		$(this).parent().addClass('current');

                var type = $(this).attr('href');
		if(type == 'all') {
			$('ul.dateul li.hidden').fadeIn('slow').removeClass('hidden');
			//$('ul.applications li').children().attr('rel', 'imagebox-all');
		} else {

			$('ul.dateul li').each(function() {
				if(!$(this).hasClass(type)) {
					$(this).fadeOut('normal').addClass('hidden');
				} else {
					$(this).fadeIn('slow').removeClass('hidden');
				}
			});
		}
	});


// hovering over li, add opacity 0.5 to all li, then opacity 1 to $(this)

      $('ul .applications li').hover(function () {
      $('ul .applications li').stop(true).animate({ opacity: 0.6 }, 800 );
      $(this).stop(true).animate({ opacity: 1 });
    }, function () {
      $('ul .applications li').stop(true).animate({ opacity: 1 }, 500 );
    });


// Same as above for new index

      $('ul .dateul li').hover(function () {
      $('ul .dateul li').stop(true).animate({ opacity: 0.6 }, 800 );
      $(this).stop(true).animate({ opacity: 1 });
    }, function () {
      $('ul .dateul li').stop(true).animate({ opacity: 1 }, 500 );
    });

 });