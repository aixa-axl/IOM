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

/**
 * Programme pillars — mobile carousel dots follow scroll position.
 */
(function () {
	const carousels = document.querySelectorAll('[data-pillars-carousel]');
	if (!carousels.length) {
		return;
	}

	carousels.forEach(function (carousel) {
		const track = carousel.querySelector('[data-pillars-track]');
		const slides = carousel.querySelectorAll('[data-pillars-slide]');
		const dots = carousel.querySelectorAll('[data-pillars-dot]');

		if (!track || !slides.length || !dots.length) {
			return;
		}

		function setActive(index) {
			dots.forEach(function (dot, i) {
				if (i === index) {
					dot.setAttribute('data-active', 'true');
				} else {
					dot.removeAttribute('data-active');
				}
			});
		}

		function updateFromScroll() {
			const trackRect = track.getBoundingClientRect();
			const center = trackRect.left + trackRect.width / 2;
			let closest = 0;
			let closestDist = Infinity;

			slides.forEach(function (slide, index) {
				const rect = slide.getBoundingClientRect();
				const slideCenter = rect.left + rect.width / 2;
				const dist = Math.abs(slideCenter - center);
				if (dist < closestDist) {
					closestDist = dist;
					closest = index;
				}
			});

			setActive(closest);
		}

		track.addEventListener('scroll', updateFromScroll, { passive: true });
		window.addEventListener('resize', updateFromScroll);
		updateFromScroll();
	});
})();

/**
 * Where we work — map highlights + country list + detail panel sync.
 * Map clicks use highlight PNG alpha masks (pixel-perfect vs geography art).
 */
(function () {
	const section = document.querySelector('[data-where-we-work]');
	if (!section) {
		return;
	}

	const jsonEl = section.querySelector('[data-countries-json]');
	let countries = {};
	try {
		countries = JSON.parse(jsonEl ? jsonEl.textContent : '{}');
	} catch (e) {
		countries = {};
	}

	const map = section.querySelector('[data-work-map]');
	const baseImg = section.querySelector('[data-map-base]');
	const mapHighlights = section.querySelectorAll('.iom-map-highlight');
	const tabs = section.querySelectorAll('[data-country-tab]');
	const panels = section.querySelectorAll('[data-country-panel], [data-country-panel-mobile]');

	// Smaller / nested regions first so Bangladesh wins over India, etc.
	const hitOrder = [
		'bangladesh',
		'sri-lanka',
		'vietnam',
		'indonesia',
		'india',
		'china',
	];
	const MAP_W = 1024;
	const MAP_H = 546;
	const masks = {};

	function loadMask(img) {
		const slug = img.getAttribute('data-country');
		if (!slug) {
			return;
		}
		const canvas = document.createElement('canvas');
		canvas.width = MAP_W;
		canvas.height = MAP_H;
		const ctx = canvas.getContext('2d', { willReadFrequently: true });
		if (!ctx) {
			return;
		}
		try {
			ctx.clearRect(0, 0, MAP_W, MAP_H);
			ctx.drawImage(img, 0, 0, MAP_W, MAP_H);
			masks[slug] = ctx.getImageData(0, 0, MAP_W, MAP_H);
		} catch (err) {
			// Cross-origin or decode failure — map clicks fall back to tabs only.
		}
	}

	mapHighlights.forEach(function (img) {
		if (img.complete && img.naturalWidth) {
			loadMask(img);
		} else {
			img.addEventListener('load', function () {
				loadMask(img);
			});
		}
	});

	function mapPointFromEvent(event) {
		if (!baseImg) {
			return null;
		}
		const rect = baseImg.getBoundingClientRect();
		const scale = Math.min(rect.width / MAP_W, rect.height / MAP_H);
		const dispW = MAP_W * scale;
		const dispH = MAP_H * scale;
		const offX = rect.left + (rect.width - dispW) / 2;
		const offY = rect.top + (rect.height - dispH) / 2;
		const x = Math.floor((event.clientX - offX) / scale);
		const y = Math.floor((event.clientY - offY) / scale);
		if (x < 0 || y < 0 || x >= MAP_W || y >= MAP_H) {
			return null;
		}
		return { x: x, y: y };
	}

	function countryAtPoint(pt) {
		const i = (pt.y * MAP_W + pt.x) * 4 + 3;
		for (let n = 0; n < hitOrder.length; n++) {
			const slug = hitOrder[n];
			const data = masks[slug];
			if (data && data.data[i] > 10 && countries[slug]) {
				return slug;
			}
		}
		return null;
	}

	function setCountry(slug) {
		if (!countries[slug]) {
			return;
		}

		const data = countries[slug];
		section.setAttribute('data-active-country', slug);

		mapHighlights.forEach(function (img) {
			const active = img.getAttribute('data-country') === slug;
			img.classList.toggle('is-active', active);
			img.classList.toggle('opacity-0', !active);
			img.classList.toggle('opacity-100', active);
		});

		tabs.forEach(function (tab) {
			const active = tab.getAttribute('data-country') === slug;
			tab.setAttribute('aria-pressed', active ? 'true' : 'false');
			tab.classList.toggle('border-navy', active);
			tab.classList.toggle('border-transparent', !active);
		});

		panels.forEach(function (panel) {
			const name = panel.querySelector('[data-panel-name]');
			const workers = panel.querySelector('[data-panel-workers]');
			const factories = panel.querySelector('[data-panel-factories]');
			const description = panel.querySelector('[data-panel-description]');
			const link = panel.querySelector('[data-panel-link]');
			const linkLabel = panel.querySelector('[data-panel-link-label]');

			if (name) {
				name.textContent = data.name || '';
			}
			if (workers) {
				workers.textContent = data.workers_reached || '';
			}
			if (factories) {
				factories.textContent = data.factories || '';
			}
			if (description) {
				description.textContent = data.description || '';
			}
			if (link) {
				link.href = data.link_url || '#';
				if (data.link_target) {
					link.setAttribute('target', data.link_target);
					link.setAttribute('rel', 'noopener noreferrer');
				} else {
					link.removeAttribute('target');
					link.removeAttribute('rel');
				}
			}
			if (linkLabel) {
				linkLabel.textContent =
					data.link_title || 'See programmes in ' + (data.name || '');
			}
		});
	}

	if (map) {
		map.addEventListener('click', function (event) {
			const pt = mapPointFromEvent(event);
			if (!pt) {
				return;
			}
			const slug = countryAtPoint(pt);
			if (slug) {
				setCountry(slug);
			}
		});

		map.addEventListener('mousemove', function (event) {
			const pt = mapPointFromEvent(event);
			const slug = pt ? countryAtPoint(pt) : null;
			map.style.cursor = slug ? 'pointer' : 'default';
		});
	}

	tabs.forEach(function (tab) {
		tab.addEventListener('click', function () {
			setCountry(tab.getAttribute('data-country'));
		});
	});

	setCountry(section.getAttribute('data-active-country') || 'vietnam');
})();
