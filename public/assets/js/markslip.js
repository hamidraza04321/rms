
$(document).ready(function() {
	
	//---------- APPLICATION BASE URL ----------//
    const base_url = $('#base-url').val();

	//---------- ON CHANGE EXAM ----------//
    $(document).on('change', '#exam-id', function(e) {
        e.preventDefault();
        removeErrorMessages();

        $('#class-id, #group-id, #section-id, #subject-id').prop('disabled', true).html('');

        var self = $(this);
            exam_id = self.val();
            url = `${base_url}/exam/get-exam-classes`;
            message = '';

        if (exam_id != '') {
            $.ajax({
                url: url,
                type: 'GET',
                data: { exam_id: exam_id },
                success: function(response) {
                    if (response.status == true) {
                        var classes = `<option value="">Select</option>`;

                        if (response.classes.length) {
                            $.each(response.classes, function(key, value) {
                                classes += `<option value="${value.id}">${value.name}</option>`;
                            });
                        }

                        $('#class-id').prop('disabled', false).html(classes);
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

    //---------- ON CHANGE CLASS ----------//
    $(document).on('change', '#class-id', function(e) {
        e.preventDefault();
        removeErrorMessages();

        $('#group-id, #section-id, #subject-id').prop('disabled', true).html('');

        var self = $(this);
            class_id = self.val();
            url = `${base_url}/class/get-class-sections-groups-and-subjects`;
            message = '';

        if (class_id != '') {
            $.ajax({
                url: url,
                type: 'GET',
                data: { class_id: class_id },
                success: function(response) {
                    if (response.status == true) {
                        var groups = `<option value="">Select</option>`;
                            sections = `<option value="">Select</option>`;
                        	subjects = `<option value="">Select</option>`;

                        if (response.groups.length) {
                            $.each(response.groups, function(key, value) {
                                groups += `<option value="${value.id}">${value.name}</option>`;
                            });
		                    
		                    $('#group-id').prop('disabled', false).html(groups);
                        }

                        if (response.sections.length) {
                            $.each(response.sections, function(key, value) {
                                sections += `<option value="${value.id}">${value.name}</option>`;
                            });
		                    
		                    $('#section-id').prop('disabled', false).html(sections);
                        }

                        if (response.subjects.length) {
                            $.each(response.subjects, function(key, value) {
                                subjects += `<option value="${value.id}">${value.name}</option>`;
                            });

                            $('#subject-id').prop('disabled', false).html(subjects);
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
    $(document).on('click', '#btn-search-markslip', function(e) {
        e.preventDefault();
        removeErrorMessages();

        var self = $(this);
            self_html = self.html();
            session_id = $('#session-id').val();
            exam_id = $('#exam-id').val();
            class_id = $('#class-id').val();
            group_id = $('#group-id').val();
            section_id = $('#section-id').val();
            subject_id = $('#subject-id').val();
            message = '';
            flag = true;

        if (session_id == '') {
            $("#session-id").siblings('span.select2-container').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
        }

        if (exam_id == '') {
            $("#exam-id").siblings('span.select2-container').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
        }

        if (class_id == '') {
            $("#class-id").siblings('span.select2-container').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
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

        if ($("#group-id option").length > 1) {
            if (group_id == '') {
                $("#group-id").siblings('span.select2-container').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
                flag = false;
            }
        }

        if (flag) {
            // Button Loading
            self.addClass('disabled').html('<div class="spinner-border"></div>');
            
            var form = $('#get-markslip-form');
                url = form.attr('action');
                formData = form.serialize();

            $.ajax({
                url: url,
                type: 'GET',
                data: formData,
                success: function(response) {
                    if (response.status == false) {
                        if (response?.errors) {
                            showErrorMessages(response.errors);
                        } else {
                            message = errorMessage(response.message);
                        }
                    } else {
                        $('#markslips').html(response.view);

                        // Initialize Grades select2
                        $('.grade').select2({
                            width: '100%',
                            placeholder: "Grade",
                            allowClear: true
                        });
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