
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
            url = `${base_url}/exam/get-exams-by-session`;
            message = '';

        if (session_id != '') {
            $.ajax({
                url: url,
                type: 'GET',
                data: { session_id: session_id },
                success: function(response) {
                    if (response.status == true) {
                        var exams = `<option value="">Select</option>`;

                        if (response.exams.length) {
                            $.each(response.exams, function(key, value) {
                                exams += `<option value="${value.id}">${value.name}</option>`;
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

        $('#group-id').prop('disabled', true).html('');

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
                        var groups = `<option value="">Select</option>`;

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
                type: 'GET',
                data: formData,
                success: function(response) {
                    if (response.status == true) {
                        $('#exam-schedule').html(response.view);
                        ApplyTooltip();

                        // Initialize date picker
                        initializeDatePicker();
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
            row.find('.categories').find('input[type="checkbox"]').prop('checked', false);
            row.find('.marks, .categories').find('input').val('');
            row.find('.categories .category-row:not(:first-child)').remove();
        }

        if (type == 'marks') {
            row.find('.categories').addClass('bg-disabled');
            row.find('.categories .category-row:not(:first-child)').remove();
            row.find('.categories').find('input, select, button').prop('disabled', true);
            row.find('.categories').find('input[type="checkbox"]').prop('checked', false);
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
            length = td.find('.category-row').length;
            subject_id = $(this).attr('data-id');

        td.append(`
            <div class="row category-row">
                <div class="category-col-5 col-5 pr-0">
                    <input type="text" name="exam_schedule[${subject_id}][categories][${length}][name]" class="form-control mr-1 mt-1 category-name" placeholder="Enter Name">
                </div>
                <div class="category-col-5 col-5 pr-0">
                    <input type="number" name="exam_schedule[${subject_id}][categories][${length}][marks]" class="form-control mr-1 mt-1 category-marks" placeholder="Enter Marks">
                </div>
                <div class="category-col-1 col-1 pr-0">
                    <div class="chk-box mt-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Apply Gradings">
                        <input type="checkbox" name="exam_schedule[${subject_id}][categories][${length}][is_grade]" class="grade-category">
                    </div>
                </div>
                <div class="category-col-1 col-1 pr-0">
                    <button class="btn btn-danger btn-remove-category mt-1" data-id="${subject_id}"><i class="fa fa-minus"></i></button>
                </div>
            </div>
        `);

        ApplyTooltip();
    });

    //---------- ON CLICK REMOVE CATEGORY ----------//
    $(document).on('click', '.btn-remove-category', function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
            categories = $(this).parents('.categories');
        
        // Remove Row
        $(this).closest('.category-row').remove();

        // Update Name Attribute
        categories.find('.category-row').each(function(key) {
            var length = key;
                category_id = $(this).find('.category-id');
                category_name = $(this).find('.category-name');
                marks = $(this).find('.category-marks');
                grade = $(this).find('.grade-category');

            if (category_id != undefined) category_id.attr(`name`, `exam_schedule[${id}][categories][${length}][category_id]`);
            category_name.attr(`name`, `exam_schedule[${id}][categories][${length}][name]`);
            marks.attr(`name`, `exam_schedule[${id}][categories][${length}][marks]`);
            grade.attr(`name`, `exam_schedule[${id}][categories][${length}][is_grade]`);
        });
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
                var category_names = [];

                row.find('.category-row').each(function(){
                    var name = $(this).find('.category-name').val();
                        marks = $(this).find('.category-marks').val();
                        grade = $(this).find('.grade-category').is(':checked') ? true : false;

                    if (name == '') {
                        $(this).find('.category-name').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
                        flag = false;
                    } else {
                        if (category_names.includes(name)) {
                            $(this).find('.category-name').addClass('is-invalid').after('<span class="invalid-feedback">The name is duplicate!</span>');
                            flag = false;
                        } else {
                            category_names.push(name);
                        }
                    }

                    if (!grade && marks == '') {
                        $(this).find('.category-marks').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
                        flag = false;
                    }
                });
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
                        // Add hidden input of category id after create category
                        if (response.creating_categories.length) {
                            $.each(response.creating_categories, function(key, value) {
                                 var subject_id = value.subject_id;
                                     category_key = value.key;
                                     category_id = value.category_id;
                                     input_name = $(`input[name="exam_schedule[${subject_id}][categories][${category_key}][name]"]`);

                                input_name.before(`<input type="hidden" name="exam_schedule[${subject_id}][categories][${category_key}][category_id]" value="${category_id}" class="category-id">`);
                            });
                        }
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

    //---------- ON CLICK SAVE EXAM SCHEDULE ----------//
    $(document).on('change', '.grade-category', function(e) {
        e.preventDefault();
        var row = $(this).parents('.category-row');
            marks_input = row.find('.category-marks');

        marks_input.removeClass('is-invalid').siblings('span.error').remove();

        if ($(this).is(':checked')) {
            marks_input.val('').prop('disabled', true);
        } else {
            marks_input.prop('disabled', false);
        }
    });

    //---------- ON CLICK DESTROY EXAM SCHEDULE ----------//
    $(document).on('click', '.btn-destroy-exam-schedule', function(e) {
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
                            var table = $('#prepared-exam-schedule-table').DataTable();
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

    //---------- ON CLICK EDIT EXAM SCHEDULE ----------//
    $(document).on('click', '.btn-edit-exam-schedule', function(e) {
        e.preventDefault();
        removeErrorMessages();

        var self = $(this);
            self_html = self.html();
            session_id = self.attr('session-id');
            exam_id = self.attr('exam-id');
            class_id = self.attr('class-id');
            group_id = self.attr('group-id');
            modal = $('#edit-exam-schedule');
            row = $(this).closest('tr');
            exam_name = row.find('.exam-name').text();
            class_name = row.find('.class-name').text();
            message = '';
            url = `${base_url}/exam-schedule/get-exam-schedule-table`;
            formData = {
                session_id: session_id,
                exam_id: exam_id,
                class_id: class_id,
                group_id: (group_id == undefined ? '' : group_id)
            };

        // Button Loading
        self.addClass('disabled').html('<div class="spinner-border-sm"></div>');

        $.ajax({
            url: url,
            type: 'GET',
            data: formData,
            success: function(response){
                if (response.status == false) {
                    if (response?.errors) {
                        var errors_list = ``;

                        $.each(response.errors, function(key, value) {
                             errors_list += `<li>${value.toString()}</li>`;
                        });

                        message = `<ul class="alert alert-danger">${errors_list}</ul>`;
                    } else {
                        message = errorMessage(response.errorMessage);
                    }
                } else {
                    // Remove table from card
                    modal.find('.modal-body').html(response.view);
                    var table = modal.find('.card-body').html();
                    modal.find('.modal-body').html(table);
                    modal.modal('show');

                    // Show Names
                    modal.find('.exam-name').text(exam_name);
                    modal.find('.class-name').text(class_name);

                    // Initialize date picker
                    initializeDatePicker();
                }
            },
            error: function(){
                message = errorMessage();
            },
            complete: function(){
                if (message != '') {
                    showAlertInTop(message);
                }

                self.removeClass('disabled').html(self_html);
            }
        });
    });

    //---------- Apply Tooltip after change element ----------//
    function ApplyTooltip()
    {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    }
});