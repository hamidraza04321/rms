
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

		// Check All Permissions
		var not_checked = $("#permissions-table").find('input[type="checkbox"]:not(:checked)').length;

		if (not_checked) {
			$('#check-all-permissions').prop('checked', false);
		} else {
			$('#check-all-permissions').prop('checked', true);
		}
	});

	//---------- ON CHECK CLASS PERMISSION ----------//
	$(document).on('change', '.permission', function(e) {
		var tr = $(this).parents('tr');
			class_permission = tr.find('.class-permission');
			assign_permissions = tr.find('.permission:checked').length;
			not_checked = $("#permissions-table").find('input[type="checkbox"]:not(:checked)').length;

		if (assign_permissions) {
			class_permission.prop('checked', true);
		} else {
			class_permission.prop('checked', false);
		}

		// Check All Permissions
		if (!not_checked) {
			$('#check-all-permissions').prop('checked', true);
		} else {
			$('#check-all-permissions').prop('checked', false);
		}
	});

	//---------- ON CLICK SAVE USER ----------//
	$(document).on('click', '#btn-save-user', function(e) {
		e.preventDefault();
		removeErrorMessages();
		
		var self = $(this);
			self_html = self.html();
			name = $('#name').val();
			username = $('#username').val();
			email = $('#email').val();
			password = $('#password').val();
			role_id = $('#role-id').val();
			message = '';
			flag = true;

		if (name == '') {
			$("#name").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
			flag = false;
		}

		if (username == '') {
			$("#username").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
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
				formData = new FormData(form[0]);
			
			$.ajax({
				url: url,
				type: 'POST',
				data: formData,
				enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
				success: function (response) {
					if (response.status == true) {
						form[0].reset();
				      	$('.select2').val('').change();
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
					self.removeClass('disabled').html(self_html);
				}
			});
		}
	});

	//---------- ON CLICK UPDATE USER ----------//
	$(document).on('click', '#btn-update-user', function(e) {
		e.preventDefault();
		removeErrorMessages();
		
		var self = $(this);
			self_html = self.html();
			name = $('#name').val();
			username = $('#username').val();
			email = $('#email').val();
			role_id = $('#role-id').val();
			message = '';
			flag = true;

		if (name == '') {
			$("#name").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
			flag = false;
		}

		if (username == '') {
			$("#username").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
			flag = false;
		}

		if (email == '') {
			$("#email").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
			flag = false;
		}

		if (role_id == '') {
			$("#role-id").siblings('span.select2-container').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
			flag = false;
		}

		if (flag) {
			// Button Loading
			self.addClass('disabled').html('<div class="spinner-border"></div>');
			
			var form = $('#update-user-form');
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
				success: function (response) {
					if (response.status == true) {
						if (password != '') $('#password').val('');
						toastr.success(response.message);
						scrollToTop();
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

	//---------- ON CLICK DESTROY USER ----------//
	$(document).on('click', '.btn-destroy-user', function(e) {
		e.preventDefault();
		removeErrorMessages();

		var self = $(this);
			self_html = self.html();
			url = self.attr('data-url');
			message = '';

		Swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
		 	if (result.isConfirmed) {
		 		// BUTTON LOADING
				self.addClass('disabled').html('<div class="spinner-border-sm"></div>');

		 		$.ajax({
		 			url: url,
		 			type: 'DELETE',
		 			success: function(response) {
		 				if (response.status == true) {
		 					var table = $('#user-table').DataTable();
		 					table.row(self.parents('tr')).remove().draw();
		 					toastr.success(response.message);
		 				} else {
		 					message = errorMessage(response.message);
		 				}
		 			},
		 			error: function() {
		 				message = errorMessage();
		 			},
		 			complete: function() {
		 				if (message != '') {
		 					showAlertInTop(message);
		 					self.removeClass('disabled').html(self_html);
		 				}
		 			}
		 		});
		  	}
		});
	});

	//---------- ON CLICK DELETE USER ----------//
	$(document).on('click', '.btn-delete-user', function(e) {
		e.preventDefault();
		removeErrorMessages();

		var self = $(this);
			self_html = self.html();
			url = self.attr('data-url');
			message = '';

		Swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
		 	if (result.isConfirmed) {
		 		// BUTTON LOADING
				self.addClass('disabled').html('<div class="spinner-border-sm"></div>');

		 		$.ajax({
		 			url: url,
		 			type: 'DELETE',
		 			success: function(response) {
		 				if (response.status == true) {
		 					var table = $('#user-trash-table').DataTable();
		 					table.row(self.parents('tr')).remove().draw();
		 					toastr.success(response.message);
		 				} else {
		 					message = errorMessage(response.message);
		 				}
		 			},
		 			error: function() {
		 				message = errorMessage();
		 			},
		 			complete: function() {
		 				if (message != '') {
		 					showAlertInTop(message);
		 					self.removeClass('disabled').html(self_html);
		 				}
		 			}
		 		});
		  	}
		});
	});

	//---------- ON CLICK STATUS BUTTON ----------//
	$(document).on('click', '.btn-update-status', function(e) {
		e.preventDefault();
		removeErrorMessages();

		var self = $(this);
			self_html = self.html();
			url = self.attr('data-url');
			message = '';

		// BUTTON LOADING
		self.addClass('disabled').html('<div class="spinner-border-sm"></div>');

		$.ajax({
			url: url,
			type: 'PUT',
			success: function(response) {
				if (response.status == true) {
					if (response.is_active == 1) {
						self.removeClass('btn-danger').addClass('btn-success').html('Active');
					} else {
						self.removeClass('btn-success').addClass('btn-danger').html('Dective');
					}
				} else {
					message = errorMessage(response.message);
				}
			},
			error: function() {
				message = errorMessage();
			},
			complete: function() {
				if (message != '') {
					showAlertInTop(message);
					self.html(self_html);	
				}

				self.removeClass('disabled');
			}
		});
	});

	//---------- ON CLICK RESTORE BUTTON ----------//
	$(document).on('click', '.btn-restore-user', function(e) {
		e.preventDefault();
		removeErrorMessages();

		var self = $(this);
			self_html = self.html();
			url = self.attr('data-url');
			message = '';

		Swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, Restore it!'
		}).then((result) => {
		 	if (result.isConfirmed) {
		 		// BUTTON LOADING
				self.addClass('disabled').html('<div class="spinner-border-sm"></div>');

		 		$.ajax({
		 			url: url,
		 			type: 'PUT',
		 			success: function(response) {
		 				if (response.status == true) {
		 					var table = $('#user-trash-table').DataTable();
		 					table.row(self.parents('tr')).remove().draw();
		 					toastr.success(response.message);
		 				} else {
		 					message = errorMessage(response.message);
		 				}
		 			},
		 			error: function() {
		 				message = errorMessage();
		 			},
		 			complete: function() {
		 				if (message != '') {
		 					showAlertInTop(message);
		 					self.removeClass('disabled').html(self_html);
		 				}
		 			}
		 		});
		 	}
		 });
	});
});