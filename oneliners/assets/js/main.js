(function ($) {
	$(document).ready(function(){
		$('.widget_oneliner-widget').each(function(i, widget){
			console.log("Sending request to widget ",widget);
			$.post(
				ol_settings.ajax_url,
				{
					action: 'get_oneliner'
				},
				function(oneliner){
					console.log("Got response for widget", widget);
					$(widget).find('.content').html(oneliner);
				}
			);
		});
	});
})(jQuery);


