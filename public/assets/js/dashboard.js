
$(document).ready(function() {
	
	//------------- DATE RANGE PICKER -----------//	
	$('#attendance-date-range').daterangepicker({
      startDate: moment().startOf('month'),
      endDate: moment().endOf('month')
    });

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
			message = '';
			flag = true;

		if (name == '') {
			$("#name").addClass('is-invalid').after('<span class="invalid-feedback">The field is required !</span>');
			flag = false;
		}

		if (flag) {
			// Button Loading
			self.addClass('disabled').html('<div class="spinner-border"></div>');

			var form = $('#update-profile-form');
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
});