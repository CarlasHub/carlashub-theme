(function ($) {
	let frame;

	$(document).on('click', '.carlashub-media-select', function (event) {
		event.preventDefault();

		const button = $(this);
		const control = button.closest('.carlashub-media-control');
		const input = control.find('.carlashub-media-id');
		const preview = control.find('.carlashub-media-preview');

		frame = wp.media({
			title: 'Select hero mark image',
			button: {
				text: 'Use image'
			},
			multiple: false
		});

		frame.on('select', function () {
			const attachment = frame.state().get('selection').first().toJSON();
			input.val(attachment.id).trigger('change');
			preview
				.html('<img class="carlashub-media-preview__image" src="' + attachment.url + '" alt="">')
				.removeAttr('hidden');
		});

		frame.open();
	});

	$(document).on('click', '.carlashub-media-remove', function (event) {
		event.preventDefault();

		const button = $(this);
		const control = button.closest('.carlashub-media-control');
		const input = control.find('.carlashub-media-id');
		const preview = control.find('.carlashub-media-preview');

		input.val('').trigger('change');
		preview.empty().attr('hidden', true);
	});
})(jQuery);
