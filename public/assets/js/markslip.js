
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
            can_edit = $('#edit-permission').val() == 'true' ? true : false;
            can_print = $('#print-permission').val() == 'true' ? true : false;
            can_delete = $('#delete-permission').val() == 'true' ? true : false;
            visible_action = (can_edit || can_print || can_delete) ? true : false;

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
                    "visible": visible_action,
                    "targets": 6,
                    "render": function (data) {
                        var btn_edit = can_edit ? `<a href="${base_url}/markslip/${data.id}/edit" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a> ` : ``;
                            btn_print = can_print ? ` <a target="_blank" href="${base_url}/markslip/${data.id}/print" class="btn btn-sm btn-warning text-white"><i class="fa fa-print"></i> Print</a> ` : ``;
                            btn_delete = can_delete ? ` <button class="btn btn-sm btn-danger btn-destroy-markslip" data-url="${base_url}/markslip/${data.id}"><i class="fa fa-trash"> Delete</i></button>` : ``;

                        return btn_edit + btn_print + btn_delete;
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

    //---------- ON CLICK GENERATE TABULATION SHEER ----------//
    $(document).on('click', '#btn-generate-tabulation-sheet', function(e) {
        e.preventDefault();
        removeErrorMessages();

        var self = $(this);
            self_html = self.html();
            session_id = $('#session-id').val();
            exam_id = $('#exam-id').val();
            class_id = $('#class-id').val();
            section_id = $('#section-id').val();
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

            var form = $('#get-tabulation-sheet-form');
                url = form.attr('action');
                formData = form.serialize();

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.status == false) {
                        if (response?.errors) {
                            showErrorMessages(response.errors);
                        } else {
                            message = errorMessage(response.message);
                        }
                    } else {
                        $('#tabulation-sheet').html(response.view);
                        $('[data-toggle="tooltip"]').tooltip();
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

    //---------- ON CHANGE MARKS IN TABULATION ----------//
    $(document).on('change', '.marks-wrap', function(e) {
        e.preventDefault();

        var student_id = $(this).attr('student-id');
            exam_schedule_id = $(this).attr('exam-schedule-id');
            total_marks = parseFloat($('th[exam-schedule-id="'+exam_schedule_id+'"]').text());
            obtain_marks = 0;

        if ($(this).val() == '') {
            $(this).val(0);
        }

        // Get sum of obtain marks according to exam schedule id
        $('.marks-wrap[student-id="'+student_id+'"][exam-schedule-id="'+exam_schedule_id+'"]')
            .each(function(){
                obtain_marks += parseFloat($(this).val());
            });

        // Get grade & percentage by obtain & total marks
        var percentage = ((obtain_marks * 100) / total_marks).toFixed(2);
            grade = getGradeByPercentage(percentage);
            student_is_fail = (grade.is_fail) ? true : false;

        // Update total marks
        $('.total-marks[student-id="'+student_id+'"][exam-schedule-id="'+exam_schedule_id+'"]').text(obtain_marks.toFixed(2).replace(/(\.0*$|0*$)/, '')).attr('is-fail', student_is_fail).parents('td').css('background', grade.color);

        // Update grand result
        setStudentGrandResult(student_id);
    });

    //------------- ON CHANGE GRADE IN TABULATION -------------//
    $(document).on('change', '.grade-wrap', function(e) {
        e.preventDefault();

        if ($(this).attr('failure-check') == 'true') {
            var option = $(this).find('option:selected');
                student_id = $(this).attr('student-id');
                is_fail = option.attr('is-fail') == 'true' ? true : false;

            $(this).attr('is-fail', is_fail);

            if ($(this).val() != '') {
                if (is_fail) {
                    $(this).addClass('border-red');
                } else {
                    $(this).removeClass('border-red');
                }
            }

            setStudentGrandResult(student_id);
        }
    });

    //------------- SET STUDENT GRAND RESULT VALUES -------------//
    function setStudentGrandResult(student_id)
    {
        var grand_total = parseFloat($('.grand-total').text());
            grand_obtain = 0;
            student_is_fail = false;

        // Grand Obtain Marks
        $('.total-marks[student-id="'+student_id+'"]')
            .each(function(){
                grand_obtain += parseFloat($(this).text());

                if (!student_is_fail) {
                    student_is_fail = ($(this).attr('is-fail') == 'true') ? true : false;
                }
            });

        // Check student is fail in grade
        $('.grade-wrap[failure-check="true"][student-id="'+student_id+'"]')
            .each(function(){
                if ($(this).attr('is-fail') == 'true') {
                    student_is_fail = true;
                    return;
                }
            });

        var grand_percentage = ((grand_obtain * 100) / grand_total).toFixed(2);
            grand_grade = (student_is_fail) ? getFailureGrade() : getGradeByPercentage(grand_percentage);
            result = student_is_fail ? 'Fail' : 'Pass';
            color = student_is_fail ? 'red' : 'green';

        $('.grand-obtain[student-id="'+student_id+'"]').text(grand_obtain.toFixed(2).replace(/(\.0*$|0*$)/, ''));
        $('.result[student-id="'+student_id+'"]').css('color', color).text(result);
        $('.grand-grade[student-id="'+student_id+'"]').text(grand_grade?.grade).parents('td').css('background', grand_grade?.color);
        $('.grand-percentage[student-id="'+student_id+'"]').text(grand_percentage.replace(/(\.0*$|0*$)/, '') + ' %');

        // Set ranking
        setStudentsRanking();
    }

    //------------- GET GRADE BY PERCENTAGE ------------//
    function getGradeByPercentage(percentage)
    {
        var grade;

        $.each(gradings, function(key, value) {
            if (percentage >= parseFloat(value.percentage_from) 
                && percentage <= parseFloat(value.percentage_to)) {
                grade = value;
            }
        });

        return grade;
    }

    //------------- GET FAILURE GRADE ------------//
    function getFailureGrade()
    {
        return gradings.reduce((min, current) => {
            if (current.is_fail && current.percentage_from < min.percentage_from) {
                return current;
            }

            return min;
        }, { percentage_from: Infinity });
    }

    //------------- SET STUDENT RANKING ------------//
    function setStudentsRanking()
    {
        var grand_obtain_marks = [];

        $('#tabulation-sheet-table tbody tr').each(function(){
            var student_id = $(this).find('.result').attr('student-id');
            
            if ($(this).find('.result').text() == 'Pass') {
                var obtain_marks = parseFloat($(this).find('.grand-obtain').text());

                grand_obtain_marks.push({
                    student_id: student_id,
                    obtain_marks: obtain_marks
                });
            } else {
                $('.rank[student-id="'+student_id+'"]').text('--');
            }
        });

        if (!grand_obtain_marks.length) {
            return;
        }

        // Sort the array by "obtain_marks" in descending order
        grand_obtain_marks.sort((a, b) => b.obtain_marks - a.obtain_marks);

        let rank = 1;

        grand_obtain_marks[0].rank = addSuffix(1); // The first student has rank 1

        for (let i = 1; i < grand_obtain_marks.length; i++) {
            if (grand_obtain_marks[i].obtain_marks < grand_obtain_marks[i - 1].obtain_marks) {
                rank++;
            }

            grand_obtain_marks[i].rank = addSuffix(rank);
        }

        $.each(grand_obtain_marks, function(key, value) {
            $('.rank[student-id="'+value.student_id+'"]').text(value.rank);
        });
    }

    //------------- ADD SUFFIX IN RANK ------------//
    function addSuffix(rank)
    {
        var lastDigit = rank % 10;
            lastTwoDigits = rank % 100;

        if (lastDigit === 1 && lastTwoDigits !== 11) {
            return rank + "st";
        }

        if (lastDigit === 2 && lastTwoDigits !== 12) {
            return rank + "nd";
        }

        if (lastDigit === 3 && lastTwoDigits !== 13) {
            return rank + "rd";
        }
        
        return rank + "th";
    }
});