
$(document).ready(function() {
	
	//---------- ON CLICK UPDATE LOGO ----------//	
	$(document).on('click', '#btn-update-logo', function(e) {
		e.preventDefault();
		removeErrorMessages();

		var self = $(this);
			self_html = self.html();
			app_logo = $('#app-logo').val();
			message = '';
			flag = true;

		if (app_logo == '') {
			$('#app-logo').addClass('is-invalid').parent('.custom-file').after('<span class="invalid-feedback d-block">Please choose file to update logo.</span>');
			flag = false;
		}

		if (flag) {
			// Button Loading
			self.addClass('disabled').html('<div class="spinner-border"></div>');

			var form = $('#update-logo-form');
			    url = form.attr('action');
			    formData = new FormData(form[0]);

			$.ajax({
	            url: url,
	            type: 'POST',
	            data: formData,
	            enctype: 'multipart/form-data',
	            processData: false,
	            contentType: false,
	            cache: false,
	            success: function(response){
	            	if (response.status == true) {
	            		form[0].reset();
	            		$('#app-logo').siblings('label').text('Choose file');
	            		$('#edit-logo-modal').modal('hide');
	            		$('.logo-image-preview').removeAttr('style').css(`background-image`, `url(${response.image_src}?${Math.random()})`);
	            		$('.brand-image').attr(`src`, `${response.image_src}?${Math.random()}`);
	            		toastr.success(response.message);
	            	} else {
	            		showErrorMessages(response.errors);
	            	}
	            },
	            error: function(){
	            	message = errorMessage();
	            },
	            complete: function(){
	            	if (message != '') form.prepend(message);
	            	self.removeClass('disabled').html(self_html);
	            }
	        });
		}
	});

	//---------- ON CLICK UPDATE SETTINGS ----------//	
	$(document).on('click', '#btn-update-settings', function(e) {
		e.preventDefault();
		removeErrorMessages();

		var self = $(this);
			self_html = self.html();
			school_name = $('#school-name').val();
			school_name_in_short = $('#school-name-in-short').val();
			email = $('#email').val();
			phone_no = $('#phone-no').val();
			current_session_id = $('#current-session-id').val();
			date_format = $('#date-format').val();
			date_format_in_js = $('#date-format-in-js').val();
			school_address = $('#school-address').val();
			message = '';
			flag = true;

		if (school_name == '') {
			$('#school-name').addClass('is-invalid').after('<span class="invalid-feedback d-block">The field is required !</span>');
			flag = false;
		}

		if (school_name_in_short == '') {
			$('#school-name-in-short').addClass('is-invalid').after('<span class="invalid-feedback d-block">The field is required !</span>');
			flag = false;
		}

		if (email == '') {
			$('#email').addClass('is-invalid').after('<span class="invalid-feedback d-block">The field is required !</span>');
			flag = false;
		}

		if (phone_no == '') {
			$('#phone-no').addClass('is-invalid').after('<span class="invalid-feedback d-block">The field is required !</span>');
			flag = false;
		}

		if (current_session_id == '') {
			$("#current-session-id").siblings('span.select2-container').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
			flag = false;
		}

		if (date_format == '') {
			$('#date-format').addClass('is-invalid').after('<span class="invalid-feedback d-block">The field is required !</span>');
			flag = false;
		}

		if (date_format_in_js == '') {
			$('#date-format-in-js').addClass('is-invalid').after('<span class="invalid-feedback d-block">The field is required !</span>');
			flag = false;
		}

		if (school_address == '') {
			$('#school-address').addClass('is-invalid').after('<span class="invalid-feedback d-block">The field is required !</span>');
			flag = false;
		}

		if (flag) {
			// Button Loading
			self.addClass('disabled').html('<div class="spinner-border"></div>');

			var form = $('#update-settings-form');
			    url = form.attr('action');
			    formData = form.serialize();

			$.ajax({
	            url: url,
	            type: 'PUT',
	            data: formData,
	            success: function(response){
	            	if (response.status == true) {
	            		$('#edit-settings-modal').modal('hide');
	            		toastr.success(response.message);

	            		// Update Text
	            		$('.school-name').text(school_name);
	            		$('.school-name-in-short').text(school_name_in_short);
	            		$('.email').text(email);
	            		$('.phone-no').text(phone_no);
	            		$('.current-session').text($('#current-session-id option:selected').text());
	            		$('.date-format').text(date_format);
	            		$('.date-format-in-js').text(date_format_in_js);
	            		$('.school-address').text(school_address);
	            	} else {
	            		showErrorMessages(response.errors);
	            	}
	            },
	            error: function(){
	            	message = errorMessage();
	            },
	            complete: function(){
	            	if (message != '') form.prepend(message);
	            	self.removeClass('disabled').html(self_html);
	            }
	        });
		}
	});
});