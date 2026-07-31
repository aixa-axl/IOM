/**
 * Impact One Million — main theme script
 */
(function () {
	const header = document.querySelector('[data-mobile-nav]');
	if (!header) {
		return;
	}

	const toggle = header.querySelector('[data-mobile-nav-toggle]');
	const panel = header.querySelector('[data-mobile-nav-panel]');
	if (!toggle || !panel) {
		return;
	}

	toggle.addEventListener('click', function () {
		const open = toggle.getAttribute('aria-expanded') === 'true';
		toggle.setAttribute('aria-expanded', open ? 'false' : 'true');
		panel.hidden = open;
	});
})();
