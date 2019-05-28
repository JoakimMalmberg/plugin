jQuery(document).ready(function($){
	$('#subscriber-form').submit(function(e){
		e.preventDefault();
		
		//Serialize Form
		var subscriberData = $('#subscriber-form').serialize();

		$.ajax({
			type: 'post',
			url: $('#subscriber-form').attr('action'),
			data: subscriberData
		}).done(function(response){
			$('#form-msg').removeClass('error');
			$('#form-msg').addClass('success');
			
			$('#form-msg').text(response);

			$('#name').val('');
			$('#email').val();

		}).fail(function(data){
			$('#form-msg').removeClass('success');
			$('#form-msg').addClass('error');

			if(data.responseText !== ''){
				$('#form-msg').text(data.responseText);
			}else{
				$('#form-msg').text('Message Was not sent');
			}
		});
	});
});