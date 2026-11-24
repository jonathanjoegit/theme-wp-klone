(function ($) {
	'use strict';
	$(document).on('click', '.klone-choose-image', function (event) {
		event.preventDefault();
		var button = $(this);
		var field = button.closest('div').find('.klone-image-input');
		var preview = button.closest('div').next('.klone-image-preview');
		var frame = wp.media({ title: 'Choisir une image', button: { text: 'Utiliser cette image' }, multiple: false });
		frame.on('select', function () {
			var attachment = frame.state().get('selection').first().toJSON();
			field.val(attachment.url);
			preview.attr('src', attachment.url).show();
		});
		frame.open();
	});
	$(document).on('input', '.klone-image-input', function () {
		var preview = $(this).closest('div').next('.klone-image-preview');
		if (this.value) { preview.attr('src', this.value).show(); } else { preview.hide(); }
	});
})(jQuery);
