$(document).ready(function() {
	
	//---------- APPLICATION BASE URL ----------//
    const base_url = $('#base-url').val();

	//---------- ON CHANGE CLASS ----------//
    $(document).on('change', '#class-id', function(e) {
        e.preventDefault();
        removeErrorMessages();

        $('#section-id, #group-id').prop('disabled', true).html('');

        var self = $(this);
            class_id = self.val();
            url = `${base_url}/class/get-class-sections-and-groups`;
            message = '';

        if (class_id != '') {
            $.ajax({
                url: url,
                type: 'GET',
                data: { class_id: class_id },
                success: function(response) {
                    if (response.status == true) {
                        var sections = `<option value="">Select</option>`;
                            groups = `<option value="">Select</option>`;

                        if (response.sections.length) {
                            $.each(response.sections, function(key, value) {
                                sections += `<option value="${value.id}">${value.name}</option>`;
                            });
                        }

                        $('#section-id').prop('disabled', false).html(sections);

                        if (response.groups.length) {
                            $.each(response.groups, function(key, value) {
                                groups += `<option value="${value.id}">${value.name}</option>`;
                            });

                            $('#group-id').prop('disabled', false).html(groups);
                        }
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
                }
            });
        }
    });

    //---------- ON CLICK SEARCH BUTTON ----------//
    $(document).on('click', '#btn-search-students', function(e) {
    	e.preventDefault();
    	removeErrorMessages();

    	var self = $(this);
    		self_html = self.html();
            session_id = $('#session-id').val();
    		class_id = $('#class-id').val();
    		section_id = $('#section-id').val();
    		group_id = $('#group-id').val();
    		attendance_date = $('#attendance-date').val();
    		message = '';
    		flag = true;

        if (session_id == '') {
            $("#session-id").siblings('span.select2-container').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
        }

    	if (class_id == '') {
            $("#class-id").siblings('span.select2-container').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
        }

        if (section_id == '') {
            $("#section-id").siblings('span.select2-container').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
        }

        if ($("#group-id option").length > 1) {
            if (group_id == '') {
                $("#group-id").siblings('span.select2-container').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
                flag = false;
            }
        }

        if (attendance_date == '') {
        	$("#attendance-date").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
        }

        if (flag) {
        	// Button Loading
			self.addClass('disabled').html('<div class="spinner-border"></div>');
			
			var form = $('#get-students-attendane-form');
				url = form.attr('action');
				formData = form.serialize();

			$.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.status == true) {
                    	$('#students-attendance').html(response.view);
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

    //---------- ON CHANGE ALL ATTENDANCE ----------//
    $(document).on('change', '.check-all-attendance', function(e) {
    	e.preventDefault();
    	var id = $(this).attr('data-id');
        $('.check-all-attendance').prop('checked', false);
        $(this).prop('checked', true);

    	if ($(this).is(':checked')) {
    		$(`.attendance[data-id="${id}"]`).prop('checked', true);
    	} else {
    		$(`.attendance[data-id="${id}"]`).prop('checked', false);
    	}
    });

    //---------- ON CHANGE ATTENDANCE ----------//
    $(document).on('change', '.attendance', function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
            total_checkboxes = $(`.attendance[value="${id}"]`).length;
            total_checked = $(`.attendance[value="${id}"]:checked`).length;

        $('.check-all-attendance').prop('checked', false);
        if (total_checkboxes == total_checked) {
            $(`.check-all-attendance[data-id="${id}"]`).prop('checked', true);
        }
    });

    //---------- ON CLICK SAVE ATTENDANCE ----------//
    $(document).on('click', '.btn-save-attendance', function(e) {
        e.preventDefault();
        removeErrorMessages();

        var self = $(this);
            self_html = self.html();
            attendances = $('.attendance:checked').length;
            flag = true;
            message = '';

        if (!attendances) {
            alert('Please mark attendance to save records!');
            flag = false;
        }

        if (flag) {
            // Button Loading
            $('.btn-save-attendance').addClass('disabled');
            self.html('<div class="spinner-border"></div>');

            var form = $('#save-attendance-form');
                url = form.attr('action');
                formData = form.serialize();

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.status == true) {
                        toastr.success(response.message);
                    } else {
                        if (response?.errors) {
                            message = errorMessage('Check your input fields and try again !');
                        }
                    }
                },
                error: function() {
                    message = errorMessage();
                },
                complete: function() {
                    if (message != '') showAlertInTop(message);
                    $('.btn-save-attendance').removeClass('disabled');
                    self.html(self_html);
                }
            });
        }
    });
});
