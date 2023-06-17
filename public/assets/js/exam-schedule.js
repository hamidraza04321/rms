
$(document).ready(function() {
	
	//---------- APPLICATION BASE URL ----------//
    const base_url = $('#base-url').val();

	//---------- ON CHANGE SESSION ----------//
    $(document).on('change', '#session-id', function(e) {
        e.preventDefault();
        removeErrorMessages();

        $('#exam-id, #class-id, #group-id').prop('disabled', true).html('');

        var self = $(this);
            session_id = self.val();
            url = base_url + '/exam/get-exams-by-session';
            message = '';

        if (session_id != '') {
            $.ajax({
                url: url,
                type: 'GET',
                data: { session_id: session_id },
                success: function(response) {
                    if (response.status == true) {
                        var exams = '<option value="">Select</option>';

                        if (response.exams.length) {
                            $.each(response.exams, function(key, value) {
                                exams += '<option value="'+value.id+'">'+value.name+'</option>';
                            });
                        }

                        $('#exam-id').prop('disabled', false).html(exams);
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

    //---------- ON CHANGE EXAM ----------//
    $(document).on('change', '#exam-id', function(e) {
        e.preventDefault();
        removeErrorMessages();

        $('#class-id, #group-id').prop('disabled', true).html('');

        var self = $(this);
            exam_id = self.val();
            url = base_url + '/exam/get-exam-classes';
            message = '';

        if (exam_id != '') {
            $.ajax({
                url: url,
                type: 'GET',
                data: { exam_id: exam_id },
                success: function(response) {
                    if (response.status == true) {
                        var classes = '<option value="">Select</option>';

                        if (response.classes.length) {
                            $.each(response.classes, function(key, value) {
                                classes += '<option value="'+value.id+'">'+value.name+'</option>';
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

        $('#group-id').prop('disabled', true).html('');

        var self = $(this);
            class_id = self.val();
            url = base_url + '/class/get-class-sections-and-groups';
            message = '';

        if (class_id != '') {
            $.ajax({
                url: url,
                type: 'GET',
                data: { class_id: class_id },
                success: function(response) {
                    if (response.status == true) {
                        var groups = '<option value="">Select</option>';

                        if (response.groups.length) {
                            $.each(response.groups, function(key, value) {
                                groups += '<option value="'+value.id+'">'+value.name+'</option>';
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
    $(document).on('click', '#btn-search-exam-schedule', function(e) {
        e.preventDefault();
        removeErrorMessages();

        var self = $(this);
            self_html = self.html();
            session_id = $('#session-id').val();
            exam_id = $('#exam-id').val();
            class_id = $('#class-id').val();
            group_id = $('#group-id').val();
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

        if ($("#group-id option").length > 1) {
            if (group_id == '') {
                $("#group-id").siblings('span.select2-container').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
                flag = false;
            }
        }

        if (flag) {
            // Button Loading
            self.addClass('disabled').html('<div class="spinner-border"></div>');
            
            var form = $('#get-exam-schedule-form');
                url = form.attr('action');
                formData = form.serialize();

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.status == true) {
                        $('#exam-schedule').html(response.view);
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

    //---------- ON CHANGE TYPE ----------//
    $(document).on('change', '.subject-type', function(e) {
        e.preventDefault();
        removeErrorMessages();

        var type = $(this).val();
            row = $(this).closest('tr');

        if (type == 'grade' || type == '') {
            row.find('.marks, .categories').addClass('bg-disabled');
            row.find('.marks, .categories').find('input, button').prop('disabled', true);
            row.find('.marks, .categories').find('input').val('');
            row.find('.categories .d-flex:not(:first-child)').remove();
        }

        if (type == 'marks') {
            row.find('.categories').addClass('bg-disabled');
            row.find('.categories .d-flex:not(:first-child)').remove();
            row.find('.categories').find('input, select, button').prop('disabled', true);
            row.find('.categories').find('input').val('');
            row.find('.marks').removeClass('bg-disabled');
            row.find('.marks').find('input').prop('disabled', false);
        }

        if (type == 'categories') {
            row.find('.marks').addClass('bg-disabled');
            row.find('.marks').find('input, select, button').prop('disabled', true);
            row.find('.categories').removeClass('bg-disabled');
            row.find('.categories').find('input, button').prop('disabled', false);
            row.find('.marks').find('input').val('');
        }
    });

    //---------- ON CLICK ADD MORE CATEGORY ----------//
    $(document).on('click', '.btn-add-more-category', function(e) {
        e.preventDefault();
        var td = $(this).closest('td');
            length = td.find('.d-flex').length + 1;
            subject_id = $(this).attr('data-id');

        td.append(`
            <div class="d-flex">
              <input type="text" name="exam_schedule[${subject_id}][categories][${length}][name]" placeholder="Enter Name" class="form-control mr-1 mt-1">
              <input type="number" name="exam_schedule[${subject_id}][categories][${length}][marks]" class="form-control mr-1 mt-1" placeholder="Enter Marks">
              <button class="btn btn-danger btn-remove-category mt-1"><i class="fa fa-minus"></i></button>
            </div>
        `);
    });

    //---------- ON CLICK REMOVE CATEGORY ----------//
    $(document).on('click', '.btn-remove-category', function(e) {
        e.preventDefault();
        $(this).closest('.d-flex').remove();
    });

    //---------- ON CLICK SAVE EXAM SCHEDULE ----------//
    $(document).on('click', '.btn-save-exam-schedule', function(e) {
        e.preventDefault();
        removeErrorMessages();

        var self = $(this);
            self_html = self.html();
            form = $('#save-exam-schedule-form');
            url = form.attr('action');
            formData = form.serialize();
            message = '';
            flag = true;

        $('#exam-schedule-table tbody tr').each(function() {
            var row = $(this);
                date = row.find('.exam-date').val();
                type = row.find('.subject-type').val();

            if (date == '') {
                row.find('.exam-date').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
                flag = false;
            }

            if (type == '') {
                row.find('.subject-type').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
                flag = false;
            }

            if (!['grade', 'marks', 'categories'].includes(type) && type != '') {
                row.find('.subject-type').addClass('is-invalid').after('<span class="invalid-feedback">The type is invalid !</span>');
                flag = false;
            }

            if (type == 'marks') {
                var marks_input = row.find('.marks input[type="number"]');
                    marks = marks_input.val();

                if (marks == '') {
                    marks_input.addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
                    flag = false;
                }
            }

            if (type == 'categories') {
                
            }

            if (!flag) {
                return false;
            }
        });

        if (flag) {
            // Button Loading
            $('.btn-save-exam-schedule').addClass('disabled');
            self.html('<div class="spinner-border"></div>');

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
                    $('.btn-save-exam-schedule').removeClass('disabled');
                    self.html(self_html);
                }
            });
        }
    });

    //---------- ON KEY UP NUMBER ----------//
    $(document).on('keyup', 'input[type="number"]', function(e) {
        e.preventDefault();
        var val = $(this).val();

        if (val <= 0 && val != '') {
            $(this).val(0);
        }
    });
});