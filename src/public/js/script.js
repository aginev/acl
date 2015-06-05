$('.controller input:checkbox').on('click', function() {
	var wrapper = $(this).parents()[1];
	var methods = $('.methods', wrapper).find('input:checkbox');

	methods.prop('checked', false);
	if ($(this).is(":checked")) {
		methods.prop('checked', true);
	}

	console.log(wrapper, methods);
});

$('.methods input:checkbox').on('click', function() {
	var hash = $(this).data('controller');
	var controller = $('[data-id="' + hash + '"]');
	var all = $('input[data-controller="' + hash + '"]').length;
	var all_checked = $('input[data-controller="' + hash + '"]:checked').length;

	if (all != all_checked) {
		controller.prop('checked', false);
	} else {
		controller.prop('checked', true);
	}
});