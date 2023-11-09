
//---------- CALL AJAX CSRF META ----------//
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

//---------- DATATABLE ----------//
if ($.isFunction($.fn.DataTable)) {
    // $(".datatable").DataTable({
    //  	dom: 'Bfrtip',
    //  	responsive: true,
    //   	lengthChange: false,
    //   	buttons: [
    //   		"copy", "csv", "excel", "pdf", "print", "colvis"
    //   	]
    // });

    $('.datatable').DataTable({
    	responsive: true
    });
}

//---------- SELECT 2 ----------//
if ($.isFunction($.fn.select2)) {
	$('.select2').select2({
		width: '100%',
		placeholder: "Select",
		allowClear: true
	});
}

//---------- DATE PICKER ----------//
if ($.isFunction($.fn.datepicker)) {
	$('.date-picker').datepicker({
		dateFormat: $('#date-format-in-js').val()
	});
}

//---------- DATE PICKER INITIALIZE ----------//
function initializeDatePicker()
{
	$('.date-picker').datepicker({
		dateFormat: $('#date-format-in-js').val()
	});
}

//---------- REMOVE VALIDATION ERROR ALERT MESSAGES ----------//
function removeErrorMessages()
{
	$('.is-invalid').removeClass('is-invalid');
	$('span.invalid-feedback').remove();
	$('.alert').remove();
}

//---------- SUCCESS MESSAGE ----------//
function successMessage(message)
{
	return `<div class="alert alert-success w-100">${message}</div>`;
}

//---------- ERROR MESSAGE ----------//
function errorMessage(message = '')
{
	message = (message == '') ? `Whoops Something went wrong please contact to the administrator.` : message;
	return `<div class="alert alert-danger w-100">${message}</div>`;
}

//---------- WARNING MESSAGE ----------//
function warningMessage(message)
{
	return `<div class="alert alert-warning w-100">${message}</div>`;
}

//---------- SHOW ERROR MESSAGES COME FROM REQUEST ----------//
function showErrorMessages(errors) 
{
	$.each(errors, function(key, value) {
		var input = $(`input[name="${key}"]`);

		// If input exists
		if (input.length) {
			// If input type is checkbox / radio not show errors
			if (!['checkbox', 'radio'].includes(input.attr('type'))) {
				if (input.attr('type') == 'file') {
					var avatar = input.parents('.avatar-upload');
					if (avatar.length) {
						avatar.after(`<span class="invalid-feedback d-block text-center">${value.toString()}</span>`);
					} else {
						input.addClass('is-invalid').parent('.custom-file').after(`<span class="invalid-feedback d-block">${value.toString()}</span>`);
					}
				} else {
					input.addClass('is-invalid').after(`<span class="invalid-feedback">${value.toString()}</span>`);
				}
			}
		} else {
			$(`select[name="${key}"]`).siblings('span.select2-container').addClass('is-invalid').after(`<span class="invalid-feedback">${value.toString()}</span>`);
		}

	});
}

//---------- SHOW ALERT IN TOP ----------//
function showAlertInTop(message)
{
	scrollToTop();
	$('.content-header .container-fluid').append(message);
}

//---------- CHECK EMAIL IS VALID OR NOT ----------//
function isValidEmail(email)
{
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
}

//---------- SCROLL TO TOP ----------//
function scrollToTop()
{
	$("html, body").animate({ scrollTop: 0 }, "slow");
}

//---------- ON CLICK LOGOUT ----------//
$(document).on('click', '#btn-logout', function(e) {
	e.preventDefault();
	var url = $(this).attr('data-url');

	$.ajax({
		url: url,
		type: 'POST',
		success: function(response) {
			window.location.href = response.redirect;
		}
	});
});

//---------- ON CHANGE FILE INPUT ----------//
$(document).on('change', '.custom-file-input', function(e) {
	e.preventDefault();
	var filename = $(this).val().split('\\').pop();
	if (filename != '') {
		$(this).siblings('label').html(filename);
	}
});