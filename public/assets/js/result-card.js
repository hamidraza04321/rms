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

    //---------- ON CLICK SEARCH RESULT CARDS ----------//
    $(document).on('click', '#btn-search-result-cards', function(e) {
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

            var form = $('#get-result-cards-form');
                url = form.attr('action');
                formData = form.serialize();

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.status == true) {
                        $('#result-cards').html(response.view);
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

    //---------- ON CLICK PRINT RESULT CARDS ----------//
    $(document).on('click', '#btn-print-result-card', function(e) {
        e.preventDefault();
        var result_body = '';
            result_cards = $('.result-card').length;
            i = 0;

        $('.result-card').each(function(){
            ++i;
            var page_break = (i == result_cards) ? '' : `<div class="page-break"></div>`;
            result_body += $(this)[0].outerHTML + page_break;
        });

        var newWin = window.open();
        newWin.document.write(`
            <!DOCTYPE html>
            <html lang="en">
            <head>
              <meta charset="utf-8">
              <meta name="viewport" content="width=device-width, initial-scale=1">
              <title>Print Result Card</title>
              <link rel="stylesheet" href="${base_url}/assets/dist/css/adminlte.min.css">
              <link rel="stylesheet" href="${base_url}/assets/css/result-card.css">
            </head>
            <body>
                ${result_body}
            </body>
            </html>
        `);
        newWin.document.close();
    });
});