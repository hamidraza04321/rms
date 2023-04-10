
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
			email = $('#email').val();
			password = $('#password').val();
			flag = true;

		if (email == '') {
			$('#email').addClass('is-invalid');
			$('#email').parents('.input-group').removeClass('mb-3').after('<span class="error"> The field is required !</span>')
			flag = false;
		} else {
			if (!isValidEmail(email)) {
				$('#email').addClass('is-invalid');
				$('#email').parents('.input-group').removeClass('mb-3').after('<span class="error"> The email is not valid !</span>')
				flag = false;
			}
		}

		if (password == '') {
			$('#password').addClass('is-invalid')
			$('#password').parents('.input-group').removeClass('mb-3').after('<span class="error"> The field is required !</span>')
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
						window.location.href = base_url + '/dashboard';
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
					if (message != '') $('.login-logo').after(message);
					self.removeClass('disabled').html(self_html);
				}
			});
		}
	});

});