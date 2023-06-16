
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
});