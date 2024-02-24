
$(document).ready(function() {

	//------------- ON CLICK LOAD ATTENDANCE GRAPH -----------//
	$(document).on('click', '#btn-load-attendance-graph', function(e) {
		e.preventDefault();
		removeErrorMessages();

		var self = $(this);
			self_html = self.html();
			url = self.attr('data-url');
			date_range = $('#attendance-date-range').val().split(' - ');
			from_date = date_range[0];
			to_date = date_range[1];
			message = '';

		// Button Loading
		self.addClass('disabled').html('<div class="spinner-border"></div>');

		$.ajax({
			url: url,
			type: 'POST',
			data: {
				from_date: from_date,
				to_date: to_date
			},
			success: function(response) {
				if (response.status == true) {
					$('#attendance-chart').removeAttr('style').html('');

					var attendances = response.student_attendances;
					var series = [];

				    $.each(attendances.series, function(key, value) {
				      	series.push({
				        	name: key,
				        	data: value
				      	});
				    });

				    var options = {
				     	series: series,
				      	chart: {
				        	type: 'bar',
				        	height: 350
				      	},
				      	plotOptions: {
				        	bar: {
				          		horizontal: false,
						        columnWidth: '55%',
						        endingShape: 'rounded'
				        	},
				      	},
				      	dataLabels: {
				        	enabled: false
				      	},
				      	stroke: {
				        	show: true,
				        	width: 2,
				        	colors: ['transparent']
				      	},
				      	xaxis: {
				        	categories: attendances.categories,
				      	},
				      	yaxis: {
				        	title: {
				          		text: 'Percentage %'
				        	}
				      	},
				      	fill: {
				        	opacity: 1
				      	},
				      	tooltip: {
				        	y: {
				          		formatter: function (val) {
				            		return val + " %"
				          		}
				        	}
				      	}
				    };

				    var chart = new ApexCharts(document.querySelector("#attendance-chart"), options);
				    chart.render();
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
	});

	//------------- ON CLICK UPDATE PROFILE ----------------//
	$(document).on('click', '#btn-update-profile', function(e) {
		e.preventDefault();
		removeErrorMessages();

		var self = $(this);
			self_html = self.html();
			name = $('#name').val();
			email = $('#email').val();
			username = $('#username').val();
			message = '';
			flag = true;

		if (name == '') {
			$("#name").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
			flag = false;
		}

		if (username == '') {
			$("#username").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
			flag = false;
		}

		if (email == '') {
			$("#email").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
			flag = false;
		}

		if (flag) {
			// Button Loading
			self.addClass('disabled').html('<div class="spinner-border"></div>');

			var form = $('#update-profile-form');
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

						// Update text 
						var user = response.user;
						$('.profile-name').text(user.name);
						$('.profile-designation').text(user.designation);
						$('.profile-user-name').text(user.username);
						$('.profile-email').text(user.email);
						$('.profile-phone-no').text(user.phone_no);
						$('.profile-age').text(user.age);
						$('.profile-date-of-birth').text(user.date_of_birth);
						$('.profile-address').text(user.address);
						$('.profile-education').text(user.education);
						$('.profile-location').text(user.location);
						$('.profile-skills').text(user.skills);

						// Update image
						$('.profile-user-img').attr('src', `/uploads/users/${user.image}?${Math.random()}`);

						// Update social media links
						var social_media_links = JSON.parse(user.social_media_links);
						$('.profile-facebook-link').attr('href', social_media_links.facebook);
						$('.profile-twitter-link').attr('href', social_media_links.twitter);
						$('.profile-instagram-link').attr('href', social_media_links.instagram);
						$('.profile-youtube-link').attr('href', social_media_links.youtube);

						$('#edit-profile-modal').modal('hide');
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

	//---------- ON CHANGE USER IMAGE ----------//
    $(document).on('change', '#user-image', function(e) {
        e.preventDefault();
        var preview = $(this).parent('.avatar-edit').siblings('.avatar-preview').find('.image-preview');
        readURL(this, preview); 
    });

    function readURL(input, preview) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.css(`background-image`, `url(${e.target.result})`);
                preview.hide();
                preview.fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
});