(function( $ ) {
	'use strict';

	$(document).ready(function(){
		$('.widget_wcms18-random-dog').each(function(i, widget){
			$.post(
				get_random_dog.ajax_url,
				{
					action: 'wcms18_random_dog__get'
				},
				function(random_dog){
					if (random_dog.data.is_image){
						$(widget).find('.content').html( '<img src="' + random_dog.data.src + '">' );
					}else{
						$(widget).find('.content').html('<video  width="320" height="240" controls> <source src="' + random_dog.data.src + '">Your browser does not support the video tag.<video>');
					}
				}
			);
		});

	});

})( jQuery );
