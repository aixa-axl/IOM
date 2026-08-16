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

	function isSearchOpen(widget) {
		const form = widget.querySelector('[data-search-form]');
		return Boolean(form && !form.classList.contains('hidden'));
	}

	function setSearchOpen(widget, open) {
		const toggle = widget.querySelector('[data-search-toggle]');
		const form = widget.querySelector('[data-search-form]');
		const input = widget.querySelector('[data-search-input]');

		if (!toggle || !form) {
			return;
		}

		toggle.classList.toggle('hidden', open);
		toggle.setAttribute('aria-expanded', open ? 'true' : 'false');

		form.classList.toggle('hidden', !open);
		form.classList.toggle('flex', open);

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
			close.addEventListener('click', function (event) {
				event.preventDefault();
				event.stopPropagation();
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
			if (!isSearchOpen(widget)) {
				return;
			}
			if (!widget.contains(event.target)) {
				setSearchOpen(widget, false);
			}
		});
	});
})();

/**
 * Impact stats — count-up when the section first enters the viewport.
 */
(function () {
	const sections = document.querySelectorAll('[data-impact-stats]');
	if (!sections.length) {
		return;
	}

	const duration = 1400;

	function formatNumber(value) {
		return Math.round(value).toLocaleString('en-US');
	}

	function easeOutCubic(t) {
		return 1 - Math.pow(1 - t, 3);
	}

	function animateCount(el) {
		if (el.dataset.countDone === 'true') {
			return;
		}
		el.dataset.countDone = 'true';

		const target = parseFloat(el.getAttribute('data-count-to') || '0');
		const prefix = el.getAttribute('data-count-prefix') || '';
		const start = performance.now();

		function frame(now) {
			const progress = Math.min((now - start) / duration, 1);
			const current = target * easeOutCubic(progress);
			el.textContent = prefix + formatNumber(current);

			if (progress < 1) {
				window.requestAnimationFrame(frame);
			} else {
				el.textContent = prefix + formatNumber(target);
			}
		}

		window.requestAnimationFrame(frame);
	}

	function runSection(section) {
		section.querySelectorAll('[data-count-up]').forEach(animateCount);
	}

	if (!('IntersectionObserver' in window)) {
		sections.forEach(runSection);
		return;
	}

	const observer = new IntersectionObserver(
		function (entries) {
			entries.forEach(function (entry) {
				if (!entry.isIntersecting) {
					return;
				}
				runSection(entry.target);
				observer.unobserve(entry.target);
			});
		},
		{
			threshold: 0.35,
		}
	);

	sections.forEach(function (section) {
		observer.observe(section);
	});
})();
