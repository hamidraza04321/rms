
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

    //---------- ON CLICK SEARCH MARKSLIP IN CREATE BUTTON ----------//
    $(document).on('click', '#btn-get-markslip', function(e) {
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

    //---------- ON CLICK SEARCH MARKSLIP BUTTON ----------//
    $(document).on('click', '#btn-search-markslip', function(e) {
        e.preventDefault();
        removeErrorMessages();

        var self = $(this);
            self_html = self.html();
            form = $('#search-markslip-form');
            url = form.attr('action');
            session_id = $('#session-id').val();
            exam_id = $('#exam-id').val();
            class_id = $('#class-id').val();
            section_id = $('#section-id').val();
            group_id = $('#group-id').val();
            subject_id = $('#subject-id').val();

        // Button Loading
        self.addClass('disabled').html('<div class="spinner-border"></div>');

        $('#markslip-table').DataTable({
            destroy: true,
            ajax: {
                url: url,
                type: 'GET',
                dataSrc: '',
                data: {
                    session_id: session_id,
                    exam_id: exam_id,
                    class_id: class_id,
                    section_id: section_id,
                    group_id: group_id,
                    subject_id: subject_id
                }
            },
            initComplete: function(settings, response){
                if (response.status == false) showErrorMessages(response.errors);
                self.removeClass('disabled').html(self_html);
            },
            columnDefs: [
                {
                    "targets": 3,
                    "render": function (data) {
                        return data.section.name;
                    }
                },
                {
                    "targets": 5,
                    "render": function (data) {
                        return data.subject.name;
                    }
                },
                {
                    "targets": 6,
                    "render": function (data) {
                        var btn_edit = ($('#edit-permission').val() == 'true') ? `<a href="${base_url}/markslip/${data.id}/edit" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a> ` : ``;
                            btn_delete = ($('#delete-permission').val() == 'true') ? ` <button class="btn btn-sm btn-danger btn-destroy-markslip" data-url="${base_url}/markslip/${data.id}"><i class="fa fa-trash"> Delete</i></button>` : ``;

                        return btn_edit + btn_delete;
                    }
                }
            ],
            columns: [
                { data: 'session' },
                { data: 'exam' },
                { data: 'class' },
                { data: null },
                { data: 'group' },
                { data: null },
                { data: null }
            ]
        });
    });

    //---------- ON CHANGE INPUT NUMBER ----------//
    $(document).on('change', 'input[type="number"]', function(e) {
        e.preventDefault();
        var val = parseInt($(this).val());
            min = parseInt($(this).attr('min'));
            max = parseInt($(this).attr('max'));

        // Validate according to min-max value
        if (val != '') {
            if (val > max) {
                $(this).val(max);
            }

            if (val < min) {
                $(this).val(min);
            }
        }
    });

    //---------- ON CHANGE OBTAIN MARKS ----------//
    $(document).on('change', '.obtain-marks', function(e) {
        e.preventDefault();
        var row = $(this).closest('tr');
            total_obtain_marks = 0;

        row.find('.obtain-marks').each(function(){
            var val = $(this).val();
            if (val != '') {
                total_obtain_marks += parseInt($(this).val());
            }
        });

        row.find('.total-obtain-marks').text(total_obtain_marks);
    });

    //---------- ON CLICK SAVE MARKSLIP BUTTON ----------//
    $(document).on('click', '.btn-save-markslip', function(e) {
        e.preventDefault();
        removeErrorMessages();

        var self = $(this);
            self_html = self.html();
            flag = true;
            message = '';

        if (flag) {
            // Button Loading
            $('.btn-save-markslip').addClass('disabled');
            self.html('<div class="spinner-border"></div>');

            var form = $('#save-markslip-form');
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
                            var errors_list = ``;

                            $.each(response.errors, function(key, value) {
                                 errors_list += `<li>${value}</li>`;
                            });

                            message += `<ul class="alert alert-danger">${value}</ul>`;
                        } else {
                            message = errorMessage('Check your input fields and try again !');
                        }
                    }
                },
                error: function() {
                    message = errorMessage();
                },
                complete: function() {
                    if (message != '') showAlertInTop(message);
                    $('.btn-save-markslip').removeClass('disabled');
                    self.html(self_html);
                }
            });
        }
    });

    //---------- ON CLICK DESTROY MARKSLIP ----------//
    $(document).on('click', '.btn-destroy-markslip', function(e) {
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
                            var table = $('#markslip-table').DataTable();
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