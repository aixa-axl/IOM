/**
 * Impact One Million — main theme script
 */
(function () {
	const header = document.querySelector('[data-mobile-nav]');
	if (!header) {
		return;
	}

	const mobileToggle = header.querySelector('[data-mobile-nav-toggle]');
	const mobilePanel = header.querySelector('[data-mobile-nav-panel]');
	const searchWidgets = header.querySelectorAll('[data-inline-search]');

	function setMobileOpen(open) {
		if (!mobileToggle || !mobilePanel) {
			return;
		}
		mobileToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		mobilePanel.hidden = !open;
	}

	function setSearchOpen(widget, open) {
		const toggle = widget.querySelector('[data-search-toggle]');
		const form = widget.querySelector('[data-search-form]');
		const input = widget.querySelector('[data-search-input]');

		if (!toggle || !form) {
			return;
		}

		toggle.hidden = open;
		toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		form.hidden = !open;

		if (open && input) {
			window.requestAnimationFrame(function () {
				input.focus();
				input.select();
			});
		}
	}

	function closeAllSearch(except) {
		searchWidgets.forEach(function (widget) {
			if (widget !== except) {
				setSearchOpen(widget, false);
			}
		});
	}

	if (mobileToggle && mobilePanel) {
		mobileToggle.addEventListener('click', function () {
			const open = mobileToggle.getAttribute('aria-expanded') === 'true';
			setMobileOpen(!open);
			if (!open) {
				closeAllSearch();
			}
		});
	}

	searchWidgets.forEach(function (widget) {
		const toggle = widget.querySelector('[data-search-toggle]');
		const close = widget.querySelector('[data-search-close]');

		if (toggle) {
			toggle.addEventListener('click', function () {
				closeAllSearch(widget);
				setSearchOpen(widget, true);
			});
		}

		if (close) {
			close.addEventListener('click', function () {
				setSearchOpen(widget, false);
				if (toggle) {
					toggle.focus();
				}
			});
		}
	});

	document.addEventListener('keydown', function (event) {
		if (event.key !== 'Escape') {
			return;
		}
		closeAllSearch();
	});

	document.addEventListener('click', function (event) {
		searchWidgets.forEach(function (widget) {
			const form = widget.querySelector('[data-search-form]');
			if (!form || form.hidden) {
				return;
			}
			if (!widget.contains(event.target)) {
				setSearchOpen(widget, false);
			}
		});
	});
})();
