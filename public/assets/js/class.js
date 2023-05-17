
$(document).ready(function() {

	//---------- ON CLICK SAVE CLASS ----------//
	$(document).on('click', '#btn-save-class', function(e) {
		e.preventDefault();
		removeErrorMessages();

		var self = $(this);
			self_html = self.html();
			name = $('#name').val();
			section_id = $('#section-id').val();
			subject_id = $('#subject-id').val();
			message = '';
			flag = true;

		if (name == '') {
			$("#name").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
			flag = false;
		}

		if (!section_id.length) {
			$("#section-id").siblings('span.select2-container').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
			flag = false;
		}

		if (!subject_id.length) {
			$("#subject-id").siblings('span.select2-container').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
			flag = false;
		}

		if (flag) {
			// Button Loading
			self.addClass('disabled').html('<div class="spinner-border"></div>');

			var form = $('#create-class-form');
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

	//---------- ON CLICK UPDATE CLASS ----------//
	$(document).on('click', '#btn-update-class', function(e) {
		e.preventDefault();
		removeErrorMessages();

		var self = $(this);
			self_html = self.html();
			name = $('#name').val();
			section_id = $('#section-id').val();
			subject_id = $('#subject-id').val();
			message = '';
			flag = true;

		if (name == '') {
			$("#name").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
			flag = false;
		}

		if (!section_id.length) {
			$("#section-id").siblings('span.select2-container').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
			flag = false;
		}

		if (!subject_id.length) {
			$("#subject-id").siblings('span.select2-container').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
			flag = false;
		}

		if (flag) {
			// Button Loading
			self.addClass('disabled').html('<div class="spinner-border"></div>');

			var form = $('#update-class-form');
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

	//---------- ON CLICK DESTROY CLASS ----------//
	$(document).on('click', '.btn-destroy-class', function(e) {
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
		 					var table = $('#class-table').DataTable();
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

	//---------- ON CLICK DELETE CLASS ----------//
	$(document).on('click', '.btn-delete-class', function(e) {
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
		 					var table = $('#class-trash-table').DataTable();
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

	//---------- ON CLICK RESTORE BUTTON ----------//
	$(document).on('click', '.btn-restore-class', function(e) {
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
		 					var table = $('#class-trash-table').DataTable();
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
});