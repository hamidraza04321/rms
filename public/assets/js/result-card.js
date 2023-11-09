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

    //---------- ON CLICK SEARCH STUDENT ----------//
    $(document).on('click', '#btn-search-student', function(e) {
        e.preventDefault();
        removeErrorMessages();

        var self = $(this);
            self_html = self.html();
            session_id = $('#session-id').val();
            class_id = $('#class-id').val();
            section_id = $('#section-id').val();
            group_id = $('#group-id').val();
            message = '';
            flag = true;

        if (session_id == '') {
            $("#class-id").siblings('span.select2-container').addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
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

        if (flag) {
            // Button Loading
            self.addClass('disabled').html('<div class="spinner-border"></div>');

            var form = $('#search-student-form');
                url = form.attr('action');
                formData = form.serialize();

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.status == true) {
                        $('#search-students').html(response.view);
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

    //---------- ON CHANGE SELECT ALL STUDENT ----------//
    $(document).on('change', '#select-all-students', function(e) {
        e.preventDefault();
        
        if ($(this).is(':checked')) {
            $('.select-student').prop('checked', true).parents('tr').addClass('bg-selected');
        } else {
            $('.select-student').prop('checked', false).parents('tr').removeClass('bg-selected');
        }
    });

    //---------- ON CHANGE SELECT STUDENT ----------//
    $(document).on('change', '.select-student', function(e) {
        e.preventDefault();
        
        var total_checkboxes = $('.select-student').length;
            checked_checkboxes = $('.select-student:checked').length;

        if ($(this).is(':checked')) {
            $(this).parents('tr').addClass('bg-selected');
        } else {
            $(this).parents('tr').removeClass('bg-selected');
        }

        if (total_checkboxes == checked_checkboxes) {
            $('#select-all-students').prop('checked', true);
        } else {
            $('#select-all-students').prop('checked', false);
        }
    });

    //---------- ON CLICK PRINT RESULT CARD ----------//
    $(document).on('click', '#btn-print-result-card', function(e) {
        e.preventDefault();
        
        var self = $(this);
            self_html = self.html();
    });
});