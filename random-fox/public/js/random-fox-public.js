(function( $ ) {
	'use strict';

	$(document).ready(function(){
		$('.widget_random-fox').each(function(i, widget){
			$.post(
				get_random_fox.ajax_url,
				{
					action: 'random_fox__get'
				},
				function(random_fox){
					var output = "";
					output += '<img src="' + random_fox.data.image + '"><br>';
					output += '<p> "' + random_fox.data.fact + '" </p>';
					$(widget).find('.content').html(output);
				}
			);
		});
	});
})( jQuery );
