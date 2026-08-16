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
	const searchToggles = header.querySelectorAll('[data-search-toggle]');
	const searchPanel = header.querySelector('[data-search-panel]');
	const searchClose = header.querySelector('[data-search-close]');
	const searchInput = searchPanel
		? searchPanel.querySelector('[data-search-input]')
		: null;

	function setMobileOpen(open) {
		if (!mobileToggle || !mobilePanel) {
			return;
		}
		mobileToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		mobilePanel.hidden = !open;
	}

	function setSearchOpen(open) {
		if (!searchPanel) {
			return;
		}

		searchPanel.hidden = !open;
		searchToggles.forEach(function (toggle) {
			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		});

		if (open && searchInput) {
			window.requestAnimationFrame(function () {
				searchInput.focus();
			});
		}
	}

	if (mobileToggle && mobilePanel) {
		mobileToggle.addEventListener('click', function () {
			const open = mobileToggle.getAttribute('aria-expanded') === 'true';
			setMobileOpen(!open);
			if (!open) {
				setSearchOpen(false);
			}
		});
	}

	if (searchPanel && searchToggles.length) {
		searchToggles.forEach(function (toggle) {
			toggle.addEventListener('click', function () {
				const open = toggle.getAttribute('aria-expanded') === 'true';
				setSearchOpen(!open);
				if (!open) {
					setMobileOpen(false);
				}
			});
		});

		if (searchClose) {
			searchClose.addEventListener('click', function () {
				setSearchOpen(false);
				if (searchToggles[0]) {
					searchToggles[0].focus();
				}
			});
		}

		document.addEventListener('keydown', function (event) {
			if (event.key === 'Escape' && !searchPanel.hidden) {
				setSearchOpen(false);
			}
		});

		document.addEventListener('click', function (event) {
			if (searchPanel.hidden) {
				return;
			}
			if (header.contains(event.target)) {
				return;
			}
			setSearchOpen(false);
		});
	}
})();
