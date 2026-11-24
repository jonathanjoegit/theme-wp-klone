(function () {
	var button = document.getElementById('menu-toggle');
	var nav = document.getElementById('site-nav');
	if (!button || !nav) return;
	button.addEventListener('click', function () {
		var open = nav.classList.toggle('is-open');
		button.setAttribute('aria-expanded', open ? 'true' : 'false');
	});
	nav.querySelectorAll('a').forEach(function (link) {
		link.addEventListener('click', function () {
			nav.classList.remove('is-open');
			button.setAttribute('aria-expanded', 'false');
		});
	});
	document.addEventListener('keydown', function (event) {
		if (event.key === 'Escape') {
			nav.classList.remove('is-open');
			button.setAttribute('aria-expanded', 'false');
		}
	});
})();
