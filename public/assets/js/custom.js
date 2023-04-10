
//---------- BASE URL ----------//
var base_url = $("#base-url").val();

//---------- CALL AJAX CSRF META ----------//
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

//---------- DATATABLE ----------//
if (typeof DataTable !== "undefined") { 
    $('.datatable').DataTable();
}

//---------- REMOVE VALIDATION ERROR ALERT MESSAGES ----------//
function removeErrorMessages()
{
	$('.is-invalid').removeClass('is-invalid');
	$('span.error').remove();
	$('.alert').remove();
}

//---------- SUCCESS MESSAGE ----------//
function successMessage(message)
{
	return '<div class="alert alert-success w-100">'+message+'</div>';
}

//---------- ERROR MESSAGE ----------//
function errorMessage(message = '')
{
	message = (message == '') ? 'Whoops Something went wrong please contact to the administrator.' : message;
	return '<div class="alert alert-danger w-100">'+message+'</div>';
}

//---------- WARNING MESSAGE ----------//
function warningMessage(message)
{
	return '<div class="alert alert-warning w-100">'+message+'</div>';
}

//---------- SHOW ERROR MESSAGES COME FROM REQUEST ----------//
function showErrorMessages(errors) 
{
	$.each(errors, function(key, value) {
		if ($('input[name="'+key+'"]').length) { // IF INPUT EXISTS
			$('input[name="'+key+'"]').addClass('is-invalid').after('<span class="error">'+value.toString()+'</span>');
		} else {
			$('select[name="'+key+'"]').addClass('is-invalid').after('<span class="error">'+value.toString()+'</span>');
		}
	});
}

//---------- SHOW ALERT IN TOP ----------//
function showAlertInTop(message)
{
	$('.content-header .container-fluid').append(message);
}

//---------- CHECK EMAIL IS VALID OR NOT ----------//
function isValidEmail(email) {
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
}

//---------- THEME SETTINGS SET IN LOACAL STOREAGE ----------//

// DARK MODE
var $checkbox_dark_mode = $('.checkbox-dark-mode');
	$body = $('body');

$checkbox_dark_mode.on('change', function() {
    if ($(this).is(':checked')) {
    	localStorage.setItem('theme', 'dark');
    } else {
    	localStorage.setItem('theme', 'default');
    }
});

var theme = localStorage.getItem("theme");

if (theme == 'dark') {
	$checkbox_dark_mode.prop('checked', true);
    $body.addClass('dark-mode');
} else {
	$checkbox_dark_mode.prop('checked', false);
    $body.removeClass('dark-mode');
}