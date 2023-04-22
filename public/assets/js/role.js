
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

		// Check All Permissions
		var not_checked = $("#permissions-table").find('input[type="checkbox"]:not(:checked)').length;

		if (not_checked) {
			$('#check-all-permissions').prop('checked', false);
		} else {
			$('#check-all-permissions').prop('checked', true);
		}
	});

	//---------- ON CHANGE ALL CHECKBOX ----------//	
	$(document).on('change', '#check-all-permissions', function(e) {
		e.preventDefault();
		var permissions = $('#permissions-table').find('input[type="checkbox"]');
		
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
			module_permission = tr.find('.module');
			assign_permissions = tr.find('.permission:checked').length;
			not_checked = $("#permissions-table").find('input[type="checkbox"]:not(:checked)').length;

		if (assign_permissions) {
			module_permission.prop('checked', true);
		} else {
			module_permission.prop('checked', false);
		}

		// Check All Permissions
		if (!not_checked) {
			$('#check-all-permissions').prop('checked', true);
		} else {
			$('#check-all-permissions').prop('checked', false);
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
			$("#name").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
			flag = false;
		}

		if (!permissions) {
			alert('Please Assign atleast one permission to create role!');
			flag = false;
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
			$("#name").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
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