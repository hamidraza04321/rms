
$(document).ready(function() {

	//---------- ON CLICK SAVE GRADE ----------//
	$(document).on('click', '#btn-save-grade', function(e) {
		e.preventDefault();
		removeErrorMessages();

		var self = $(this);
			self_html = self.html();
			class_id = $('#class-id').val();
			grade = $('#grade').val();
			percentage_from = $('#percentage-from').val();
			percentage_to = $('#percentage-to').val();
			color = $('#color').val();
			is_fail = $('#is-fail').val();
			message = '';
			flag = true;

		if (class_id == '') {
			$("#class-id").siblings('span.select2-container').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
		}

		if (grade == '') {
			$("#grade").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
		}

		if (percentage_from == '') {
			$("#percentage-from").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
		}

		if (percentage_to == '') {
			$("#percentage-to").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
		} else {
			if (percentage_to <= percentage_from) {
				$("#percentage-to").addClass('is-invalid').after('<span class="invalid-feedback">The percentage to is must be greater than from percentage !</span>');
	            flag = false;
			}
		}

		if (color == '') {
			$("#color").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
		}

		if (is_fail == '') {
			$("#is-fail").siblings('span.select2-container').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
		}

		if (flag) {
			// Button Loading
			self.addClass('disabled').html('<div class="spinner-border"></div>');

			var form = $('#create-grade-form');
			    url = form.attr('action');
			    formData = form.serialize();

			$.ajax({
				url: url,
				type: 'POST',
				data: formData,
				success: function(response) {
					if (response.status == true) {
				      	form[0].reset();
				      	$('.select2').val('').change();
						toastr.success(response.message);
					} else {
						showErrorMessages(response.errors);
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

	//---------- ON CLICK UPDATE GRADE ----------//
	$(document).on('click', '#btn-update-grade', function(e) {
		e.preventDefault();
		removeErrorMessages();

		var self = $(this);
			self_html = self.html();
			class_id = $('#class-id').val();
			grade = $('#grade').val();
			percentage_from = $('#percentage-from').val();
			percentage_to = $('#percentage-to').val();
			color = $('#color').val();
			is_fail = $('#is-fail').val();
			message = '';
			flag = true;

		if (class_id == '') {
			$("#class-id").siblings('span.select2-container').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
		}

		if (grade == '') {
			$("#grade").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
		}

		if (percentage_from == '') {
			$("#percentage-from").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
		}

		if (percentage_to == '') {
			$("#percentage-to").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
		} else {
			if (percentage_to <= percentage_from) {
				$("#percentage-to").addClass('is-invalid').after('<span class="invalid-feedback">The percentage to is must be greater than from percentage !</span>');
	            flag = false;
			}
		}

		if (color == '') {
			$("#color").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
		}

		if (is_fail == '') {
			$("#is-fail").siblings('span.select2-container').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
		}

		if (flag) {
			// Button Loading
			self.addClass('disabled').html('<div class="spinner-border"></div>');

			var form = $('#update-grade-form');
			    url = form.attr('action');
			    formData = form.serialize();

			$.ajax({
				url: url,
				type: 'PUT',
				data: formData,
				success: function(response) {
					if (response.status == true) {
						toastr.success(response.message);
					} else {
						showErrorMessages(response.errors);
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

	//---------- ON CLICK DESTROY GRADE ----------//
	$(document).on('click', '.btn-destroy-grade', function(e) {
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
		 					var table = $('#grade-table').DataTable();
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

	//---------- ON CLICK DELETE GRADE ----------//
	$(document).on('click', '.btn-delete-grade', function(e) {
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
		 					var table = $('#grade-trash-table').DataTable();
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
	$(document).on('click', '.btn-restore-grade', function(e) {
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
		 					var table = $('#grade-trash-table').DataTable();
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