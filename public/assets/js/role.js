
$(document).ready(function() {
	
	//---------- ON CHANGE MODULE CHECKBOX ----------//	
	$(document).on('change', '.module', function(e) {
		e.preventDefault();
		var permissions = $(this).parents('tr').find('.permission');
		
		if ($(this).is(':checked')) {
			permissions.prop('checked', true);
		} else {
			permissions.prop('checked', false);
		}
	});

	//---------- ON CHANGE PERMISSION CHECKBOX ----------//
	$(document).on('change', '.permission', function(e) {
		e.preventDefault();
		var tr = $(this).parents('tr');
			permissions_length = tr.find('.permission').length;
			assign_permissions = tr.find('.permission:checked').length;
		
		if (permissions_length == assign_permissions) {
			tr.find('.module').prop('checked', true);
		} else {
			tr.find('.module').prop('checked', false);
		}
	});

	//---------- ON CLICK SAVE ROLE ----------//
	$(document).on('click', '#btn-save-role', function(e) {
		e.preventDefault();
		removeErrorMessages();

		var self = $(this);
			name = $('#name').val();
			permissions = $('.permission:checked').length;
			message = '';
			flag = true;

		if (name == '') {
			$("#name").addClass('is-invalid').after('<span class="error">The field is required !</span>');
			flag = false;
		}

		if (!permissions) {
			alert('Please Assign atleast one permission to create role!');
		}
		
		if (flag) {
			// Button Loading
			self.addClass('disabled').html('<div class="spinner-border"></div>');
			
			var form = $('#create-role-form');
				url = form.attr('action');
				formData = form.serialize();
			
			$.ajax({
				url: url,
				type: 'POST',
				data: formData,
				success: function (response) {
					if (response.status == true) {
						scrollToTop();
						form[0].reset();
						toastr.success(response.message);
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
					if (message != '') showAlertInTop(message);
					self.removeClass('disabled').html('Save');
				}
			});
		}
	});

	//---------- ON CLICK UPDATE ROLE ----------//
	$(document).on('click', '#btn-update-role', function(e) {
		e.preventDefault();
		removeErrorMessages();

		var self = $(this);
			name = $('#name').val();
			permissions = $('.permission:checked').length;
			message = '';
			flag = true;

		if (name == '') {
			$("#name").addClass('is-invalid').after('<span class="error">The field is required !</span>');
			flag = false;
		}

		if (!permissions) {
			alert('Please Assign atleast one permission to update role!');
		}
		
		if (flag) {
			// Button Loading
			self.addClass('disabled').html('<div class="spinner-border"></div>');
			
			var form = $('#update-role-form');
				url = form.attr('action');
				formData = form.serialize();
			
			$.ajax({
				url: url,
				type: 'PUT',
				data: formData,
				success: function (response) {
					if (response.status == true) {
						scrollToTop();
						toastr.success(response.message);
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
					if (message != '') showAlertInTop(message);
					self.removeClass('disabled').html('Update');
				}
			});
		}
	});
});