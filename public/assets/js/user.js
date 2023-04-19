
$(document).ready(function() {

	//---------- ON CHECK ALL PERMISSIONS ----------//
	$(document).on('change', '#check-all-permissions', function(e) {
		var permissions = $('#permissions-table').find('input[type="checkbox"]');

		if ($(this).is(':checked')) {
			permissions.prop('checked', true);
		} else {
			permissions.prop('checked', false);
		}
	});

	//---------- ON CHECK CLASS PERMISSION ----------//
	$(document).on('change', '.class-permission', function(e) {
		var permissions = $(this).parents('tr').find('input[type="checkbox"]');

		if ($(this).is(':checked')) {
			permissions.prop('checked', true);
		} else {
			permissions.prop('checked', false);
		}
	});

	//---------- ON CHECK CLASS PERMISSION ----------//
	$(document).on('change', '.permission', function(e) {
		var tr = $(this).parents('tr');
			class_permission = tr.find('.class-permission');
			total_permissions = tr.find('input[type="checkbox"]:not(.class-permission)').length;
			checked_permissions = tr.find('input[type="checkbox"]:checked:not(.class-permission)').length;

		if (total_permissions == checked_permissions) {
			class_permission.prop('checked', true);
		} else {
			class_permission.prop('checked', false);
		}
	});

	//---------- ON CLICK SAVE USER ----------//
	$(document).on('click', '#btn-save-user', function(e) {
		e.preventDefault();
		removeErrorMessages();
		
		var self = $(this);
			self_html = self.html();
			name = $('#name').val();
			email = $('#email').val();
			password = $('#password').val();
			role_id = $('#role-id').val();
			message = '';
			flag = true;

		if (name == '') {
			$("#name").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
			flag = false;
		}

		if (email == '') {
			$("#email").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
			flag = false;
		}

		if (password == '') {
			$("#password").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
			flag = false;
		}

		if (role_id == '') {
			$("#role-id").siblings('span.select2-container').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
			flag = false;
		}

		if (flag) {
			// Button Loading
			self.addClass('disabled').html('<div class="spinner-border"></div>');
			
			var form = $('#create-user-form');
				url = form.attr('action');
				formData = form.serialize();
			
			$.ajax({
				url: url,
				type: 'POST',
				data: formData,
				success: function (response) {
					if (response.status == true) {
						form[0].reset();
				      	$('.select2').val('').change();
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
					self.removeClass('disabled').html(self_html);
				}
			});
		}
	});
});