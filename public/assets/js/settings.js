
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

});