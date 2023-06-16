
$(document).ready(function() {

	//---------- ON CLICK SAVE EXAM ----------//
	$(document).on('click', '#btn-save-exam', function(e) {
		e.preventDefault();
		removeErrorMessages();

		var self = $(this);
			self_html = self.html();
			session_id = $('#session-id').val();
			name = $('#name').val();
			class_id = $('#class-id').val();
			message = '';
			flag = true;

		if (session_id == '') {
            $("#session-id").siblings('span.select2-container').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
        }

		if (name == '') {
			$("#name").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
			flag = false;
		}

		if (!class_id.length) {
			$("#class-id").siblings('span.select2-container').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
			flag = false;
		}

		if (flag) {
			// Button Loading
			self.addClass('disabled').html('<div class="spinner-border"></div>');

			var form = $('#create-exam-form');
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

	//---------- ON CLICK UPDATE EXAM ----------//
	$(document).on('click', '#btn-update-exam', function(e) {
		e.preventDefault();
		removeErrorMessages();

		var self = $(this);
			self_html = self.html();
			session_id = $('#session-id').val();
			name = $('#name').val();
			class_id = $('#class-id').val();
			message = '';
			flag = true;

		if (session_id == '') {
            $("#session-id").siblings('span.select2-container').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
        }

		if (name == '') {
			$("#name").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
			flag = false;
		}

		if (!class_id.length) {
			$("#class-id").siblings('span.select2-container').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
			flag = false;
		}

		if (flag) {
			// Button Loading
			self.addClass('disabled').html('<div class="spinner-border"></div>');

			var form = $('#update-exam-form');
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

	//---------- ON CLICK DESTROY EXAM ----------//
	$(document).on('click', '.btn-destroy-exam', function(e) {
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
		 					var table = $('#exam-table').DataTable();
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

	//---------- ON CLICK DELETE EXAM ----------//
	$(document).on('click', '.btn-delete-exam', function(e) {
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
		 					var table = $('#exam-trash-table').DataTable();
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
	$(document).on('click', '.btn-restore-exam', function(e) {
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
		 					var table = $('#exam-trash-table').DataTable();
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