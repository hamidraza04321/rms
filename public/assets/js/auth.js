
$(document).ready(function() {
	
	//---------- ON CLICK SIGN IN ----------//
	$(document).on('click', '#btn-sign-in', function(e) {
		e.preventDefault();
		removeErrorMessages();

		var self = $(this);
			self_html = self.html();
			message = '';

		$('.input-group').addClass('mb-3');

		var self = $(this);
			login = $('#login').val();
			password = $('#password').val();
			flag = true;

		if (login == '') {
			$('#login').addClass('is-invalid');
			$('#login').parents('.input-group').removeClass('mb-3').after('<span class="invalid-feedback"> The field is required !</span>');
			flag = false;
		}

		if (password == '') {
			$('#password').addClass('is-invalid');
			$('#password').parents('.input-group').removeClass('mb-3').after('<span class="invalid-feedback"> The field is required !</span>');
			flag = false;
		}

		if (flag) {

			// BUTTON LOADING
			self.addClass('disabled').html('<div class="spinner-border"></div>');

			var form = $('#login-form');
				url = form.attr('action');
				formData = form.serialize();

			$.ajax({
				url: url,
				type: 'POST',
				data: formData,
				success: function(response) {
					if (response.status == true) {
						window.location.href = response.redirect;
					} else {
						if (response?.errors) {
							showErrorMessages(response.errors);
						} else {
							message = errorMessage(response.message);
						}
					}
				},
				error: function() {
					message = errorMessage();
				},
				complete: function() {
					if (message != '') $('.error-message').after(message); $('.alert').addClass('text-center');
					self.removeClass('disabled').html(self_html);
				}
			});
		}
	});

});