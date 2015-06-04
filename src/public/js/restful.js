(function () {

	var Restful = {
		initialize: function () {
			this.methodLinks = $('a[data-method]');

			this.registerEvents();
		},
		registerEvents: function () {
			this.methodLinks.on('click', this.handleMethod);
		},
		handleMethod: function (e) {
			var link = $(this);
			var httpMethod = link.data('method').toUpperCase();
			var form;

			// If the data-method attribute is not PUT or DELETE,
			// then we don't know what to do. Just ignore.
			if ($.inArray(httpMethod, ['PUT', 'DELETE']) === -1) {
				return;
			}

			// Allow user to optionally provide data-confirm="Are you sure?"
			if (link.data('confirm')) {
				// Set default message
				var message = 'Are you sure?';

				if (link.data('confirm').length > 0) {
					message = link.data('confirm');
				}

				// Set alert message
				$('#modal-confirm .modal-body').html(message);

				// Display alert modal
				$('#modal-confirm').modal();

				// Submit the form only if the Yes button is clicked
				$('#modal-confirm [data-confirm="yes"]').on('click', function() {
					form = Restful.createForm(link);
					form.submit();
				});
			} else {
				form = Restful.createForm(link);
				form.submit();
			}

			e.preventDefault();
		},
		verifyConfirm: function (link) {
			return confirm(link.data('confirm'));
		},
		createForm: function (link) {
			$('.restful-form').remove();

			var form =
				$('<form>', {
					'method': 'POST',
					'action': link.attr('href')
				}).addClass('restful-form');

			var token =
				$('<input>', {
					'type': 'hidden',
					'name': '_token',
					'value': Laravel._token
				});

			var hiddenInput =
				$('<input>', {
					'name': '_method',
					'type': 'hidden',
					'value': link.data('method')
				});

			return form.append(token, hiddenInput)
				.appendTo('body');
		}
	};

	Restful.initialize();

})();