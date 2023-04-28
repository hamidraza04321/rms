$(document).ready(function() {

    //---------- APPLICATION BASE URL ----------//
    const base_url = $('#base-url').val();

    //---------- ON CLICK SEARCH STUDENT ----------//
    $(document).on('click', '#btn-search-student', function(e) {
        e.preventDefault();
        removeErrorMessages();

        var self = $(this);
            self_html = self.html();
            form = $('#search-student-form');
            url = form.attr('action');
            class_id = $('#class-id').val();
            section_id = $('#section-id').val();
            group_id = $('#group-id').val();
            gender = $('#gender').val();
            status = $('#status').val();

        // Button Loading
        self.addClass('disabled').html('<div class="spinner-border"></div>');

        $('#student-table').DataTable({
            destroy: true,
            searchable: false,
            responsive: true,
            ajax: {
                url: url,
                type: 'POST',
                dataSrc: function (response) {
                    return (response?.students) ? response.students : '';
                },
                data: {
                    class_id: class_id,
                    section_id: section_id,
                    group_id: group_id,
                    gender: gender,
                    status: status
                }
            },
            initComplete: function(settings, response){
                if (response.status == false) showErrorMessages(response.errors);
                self.removeClass('disabled').html(self_html);
            },
            rowCallback: function (nRow, aData, iDisplayIndex) {
                 var oSettings = this.fnSettings ();
                 $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
                 return nRow;
            },
            columnDefs: [
                {
                    "targets": 5,
                    "render": function (data) {
                        return data.class.name + ' ( ' + data.section.name + ' ) ';
                    }
                },
                {
                    "targets": 6,
                    "render": function (data) {
                        if (data.group?.name) {
                            return data.group.name;
                        }
                        
                        return '';
                    }
                },
                {
                    "targets": 7,
                    "render": function (data) {
                        var status_url = base_url + `/student/update-status/` + data.id;
                        
                        if (data.is_active) {
                            return `<button data-url="`+status_url+`" class="btn btn-sm btn-success btn-update-status">Active</button>`;
                        } else {
                            return `<button data-url="`+status_url+`" class="btn btn-sm btn-danger btn-update-status">Deactive</button>`;
                        }
                    }
                },
                {
                    "targets": 8,
                    "render": function (data) {
                        return `<a href="`+ base_url + '/student/' + data.id + '/edit' +`" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>
                                <button class="btn btn-sm btn-danger btn-destroy-student" data-url="`+ base_url + '/student/' + data.id +`"><i class="fa fa-trash"> Delete</i></button>`;
                    }
                }
            ],
            columns: [
                { data: null },
                { data: 'admission_no' },
                { data: 'roll_no' },
                { data: 'full_name' },
                { data: 'father_name' },
                { data: null },
                { data: null },
                { data: null },
                { data: null }
            ],
        });
    });

    //---------- ON CLICK SAVE STUDENT ----------//
    $(document).on('click', '#btn-save-student', function(e) {
        e.preventDefault();
        removeErrorMessages();

        var self = $(this);
            self_html = self.html();
            admission_no = $('#admission-no').val();
            roll_no = $('#roll-no').val();
            class_id = $('#class-id').val();
            section_id = $('#section-id').val();
            group_id = $('#group-id').val();
            first_name = $('#first-name').val();
            gender = $('#gender').val();
            date_of_birth = $('#date-of-birth').val();
            guardian_name = $('#guardian-name').val();
            guardian_phone = $('#guardian-phone').val();
            message = '';
            flag = true;

        if (admission_no == '') {
            $("#admission-no").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
        }

        if (roll_no == '') {
            $("#roll-no").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
        }

        if (class_id == '') {
            $("#class-id").siblings('span.select2-container').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
        }

        if (section_id == '') {
            $("#section-id:not(:disabled)").siblings('span.select2-container').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
        }

        if ($("#group-id option").length > 1) {
            if (group_id == '') {
                $("#group-id").siblings('span.select2-container').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
                flag = false;
            }
        }

        if (first_name == '') {
            $("#first-name").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
        }

        if (gender == '') {
            $("#gender").siblings('span.select2-container').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
        }

        if (date_of_birth == '') {
            $("#date-of-birth").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
        }

        if (guardian_name == '') {
            $("#guardian-name").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
        }

        if (guardian_phone == '') {
            $("#guardian-phone").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
        }

        if (flag) {
            // Button Loading
            self.addClass('disabled').html('<div class="spinner-border"></div>');

            var form = $('#create-student-form');
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
                success: function(response) {
                    if (response.status == true) {
                        form[0].reset();
                        $('.select2').val('').change();
                        $('.image-preview').css('background-image', 'url('+ $('#image-preview').attr('data-src') +')');
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

    //---------- ON CLICK UPDATE STUDENT ----------//
    $(document).on('click', '#btn-update-student', function(e) {
        e.preventDefault();
        removeErrorMessages();

        var self = $(this);
            self_html = self.html();
            admission_no = $('#admission-no').val();
            roll_no = $('#roll-no').val();
            class_id = $('#class-id').val();
            section_id = $('#section-id').val();
            group_id = $('#group-id').val();
            first_name = $('#first-name').val();
            gender = $('#gender').val();
            date_of_birth = $('#date-of-birth').val();
            guardian_name = $('#guardian-name').val();
            guardian_phone = $('#guardian-phone').val();
            message = '';
            flag = true;

        if (admission_no == '') {
            $("#admission-no").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
        }

        if (roll_no == '') {
            $("#roll-no").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
        }

        if (class_id == '') {
            $("#class-id").siblings('span.select2-container').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
        }

        if (section_id == '') {
            $("#section-id:not(:disabled)").siblings('span.select2-container').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
        }

        if ($("#group-id option").length > 1) {
            if (group_id == '') {
                $("#group-id").siblings('span.select2-container').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
                flag = false;
            }
        }

        if (first_name == '') {
            $("#first-name").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
        }

        if (gender == '') {
            $("#gender").siblings('span.select2-container').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
        }

        if (date_of_birth == '') {
            $("#date-of-birth").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
        }

        if (guardian_name == '') {
            $("#guardian-name").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
        }

        if (guardian_phone == '') {
            $("#guardian-phone").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
            flag = false;
        }

        if (flag) {
            // Button Loading
            self.addClass('disabled').html('<div class="spinner-border"></div>');

            var form = $('#update-student-form');
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
    
    //---------- ON CLICK DESTROY STUDENT ----------//
    $(document).on('click', '.btn-destroy-student', function(e) {
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
                            var table = $('#student-table').DataTable();
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
    
    //---------- ON CHANGE CLASS ----------//
    $(document).on('change', '#class-id', function(e) {
        e.preventDefault();
        removeErrorMessages();

        $('#section-id, #group-id').prop('disabled', true).html('');

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
                        var sections = '<option value="">Select</option>';
                            groups = '<option value="">Select</option>';

                        if (response.sections.length) {
                            $.each(response.sections, function(key, value) {
                                sections += '<option value="'+value.id+'">'+value.name+'</option>';
                            });

                            $('#section-id').prop('disabled', false).html(sections);
                        }

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

    //---------- ON CHANGE IMAGE ----------//
    $(document).on('change', '#student-image, #father-image, #mother-image, #guardian-image', function(e) {
        e.preventDefault();
        var preview = $(this).parent('.avatar-edit').siblings('.avatar-preview').find('.image-preview');
        readURL(this, preview); 
    });

    function readURL(input, preview) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.css('background-image', 'url('+e.target.result +')');
                preview.hide();
                preview.fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
});