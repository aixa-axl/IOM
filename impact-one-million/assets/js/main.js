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
 * Programme pillars / benefits — mobile carousel dots follow scroll position.
 */
(function () {
	function bindSnapCarousel(carousel, selectors) {
		const track = carousel.querySelector(selectors.track);
		const slides = carousel.querySelectorAll(selectors.slide);
		const dots = carousel.querySelectorAll(selectors.dot);

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
	}

	document.querySelectorAll('[data-pillars-carousel]').forEach(function (carousel) {
		bindSnapCarousel(carousel, {
			track: '[data-pillars-track]',
			slide: '[data-pillars-slide]',
			dot: '[data-pillars-dot]',
		});
	});

	document.querySelectorAll('[data-benefits-carousel]').forEach(function (carousel) {
		bindSnapCarousel(carousel, {
			track: '[data-benefits-track]',
			slide: '[data-benefits-slide]',
			dot: '[data-benefits-dot]',
		});
	});

	document.querySelectorAll('[data-why-join-carousel]').forEach(function (carousel) {
		bindSnapCarousel(carousel, {
			track: '[data-why-join-track]',
			slide: '[data-why-join-slide]',
			dot: '[data-why-join-dot]',
		});
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

	setCountry(section.getAttribute('data-active-country') || 'china');
})();

/**
 * Impact timeline — horizontal card carousel with prev/next controls.
 */
(function () {
	const sections = document.querySelectorAll('[data-impact-timeline]');
	if (!sections.length) {
		return;
	}

	sections.forEach(function (section) {
		const track = section.querySelector('[data-timeline-track]');
		const slides = section.querySelectorAll('[data-timeline-slide]');
		const prevBtns = section.querySelectorAll('[data-timeline-prev]');
		const nextBtns = section.querySelectorAll('[data-timeline-next]');

		if (!track || !slides.length) {
			return;
		}

		function slideWidth() {
			const first = slides[0];
			if (!first) {
				return track.clientWidth;
			}
			const styles = window.getComputedStyle(track);
			const gap = parseFloat(styles.columnGap || styles.gap || '0') || 0;
			return first.getBoundingClientRect().width + gap;
		}

		function currentIndex() {
			const w = slideWidth();
			if (w <= 0) {
				return 0;
			}
			return Math.round(track.scrollLeft / w);
		}

		function updateUI() {
			const index = currentIndex();
			const max = slides.length - 1;

			slides.forEach(function (slide, i) {
				slide.setAttribute('data-active', i === index ? 'true' : 'false');
			});

			prevBtns.forEach(function (btn) {
				btn.disabled = index <= 0;
				btn.classList.toggle('text-blue', index > 0);
				btn.classList.toggle('text-accent-blue', index <= 0);
			});

			nextBtns.forEach(function (btn) {
				btn.disabled = index >= max;
				btn.classList.toggle('text-blue', index < max);
				btn.classList.toggle('text-accent-blue', index >= max);
			});
		}

		function goTo(index) {
			const clamped = Math.max(0, Math.min(slides.length - 1, index));
			track.scrollTo({
				left: clamped * slideWidth(),
				behavior: 'smooth',
			});
		}

		prevBtns.forEach(function (btn) {
			btn.addEventListener('click', function () {
				goTo(currentIndex() - 1);
			});
		});

		nextBtns.forEach(function (btn) {
			btn.addEventListener('click', function () {
				goTo(currentIndex() + 1);
			});
		});

		let scrollTick = null;
		track.addEventListener(
			'scroll',
			function () {
				if (scrollTick) {
					return;
				}
				scrollTick = window.requestAnimationFrame(function () {
					scrollTick = null;
					updateUI();
				});
			},
			{ passive: true }
		);

		window.addEventListener('resize', updateUI);
		updateUI();
	});
})();

/**
 * Featured story — play video inline in the media square.
 */
(function () {
	const blocks = document.querySelectorAll('[data-featured-story-media]');
	if (!blocks.length) {
		return;
	}

	blocks.forEach(function (media) {
		const playBtn = media.querySelector('[data-featured-story-play]');
		const poster = media.querySelector('[data-featured-story-poster]');
		const player = media.querySelector('[data-featured-story-player]');
		const type = media.getAttribute('data-video-type');
		const src = media.getAttribute('data-video-src');

		if (!playBtn || !player || !src || !type) {
			return;
		}

		playBtn.addEventListener('click', function () {
			player.innerHTML = '';
			player.classList.remove('hidden');

			if (type === 'video') {
				const video = document.createElement('video');
				video.className = 'absolute inset-0 h-full w-full object-cover';
				video.src = src;
				video.controls = true;
				video.autoplay = true;
				video.playsInline = true;
				player.appendChild(video);
			} else {
				const iframe = document.createElement('iframe');
				iframe.className = 'absolute inset-0 h-full w-full border-0';
				iframe.src = src;
				iframe.title = 'Featured story video';
				iframe.allow =
					'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share';
				iframe.allowFullscreen = true;
				player.appendChild(iframe);
			}

			if (poster) {
				poster.classList.add('hidden');
			}
			playBtn.classList.add('hidden');
		});
	});
})();

/**
 * ROI Calculator — audience tabs + investment slider → live metrics.
 */
(function () {
	const root = document.querySelector('[data-roi-calculator]');
	if (!root) {
		return;
	}

	const jsonEl = root.querySelector('[data-roi-audiences]');
	let audiences = [];
	try {
		audiences = JSON.parse(jsonEl ? jsonEl.textContent : '[]');
	} catch (e) {
		audiences = [];
	}

	if (!audiences.length) {
		return;
	}

	const slider = root.querySelector('[data-roi-slider]');
	const amountMobile = root.querySelector('[data-roi-amount-mobile]');
	const amountDesktop = root.querySelector('[data-roi-amount-desktop]');
	const workersEl = root.querySelector('[data-roi-workers]');
	const familiesEl = root.querySelector('[data-roi-families]');
	const factoriesEl = root.querySelector('[data-roi-factories]');
	const tabs = root.querySelectorAll('[data-roi-tab]');

	const baseline = Number(root.getAttribute('data-baseline')) || 100000;
	const min = Number(root.getAttribute('data-min')) || 0;
	const max = Number(root.getAttribute('data-max')) || 1;

	const tabActive =
		'flex flex-1 cursor-pointer items-center justify-center rounded-card border border-solid px-3 py-4 font-display text-[14px] uppercase tracking-[1px] transition-colors lg:px-8 lg:text-label border-blue bg-blue text-white';
	const tabIdle =
		'flex flex-1 cursor-pointer items-center justify-center rounded-card border border-solid px-3 py-4 font-display text-[14px] uppercase tracking-[1px] transition-colors lg:px-8 lg:text-label border-[#dfe8ff] bg-white text-navy hover:border-blue/40';

	let activeIndex = 0;

	function formatMoney(value) {
		return (
			'$' +
			Math.round(value).toLocaleString(undefined, {
				maximumFractionDigits: 0,
			})
		);
	}

	function formatCount(value) {
		return Math.max(0, Math.round(value)).toLocaleString(undefined, {
			maximumFractionDigits: 0,
		});
	}

	function setSliderFill(value) {
		if (!slider) {
			return;
		}
		const pct = ((value - min) / Math.max(1, max - min)) * 100;
		slider.style.setProperty('--roi-pct', pct + '%');
	}

	function update() {
		const amount = slider ? Number(slider.value) : baseline;
		const audience = audiences[activeIndex] || audiences[0];
		const scale = baseline > 0 ? amount / baseline : 0;

		const money = formatMoney(amount);
		if (amountMobile) {
			amountMobile.textContent = money;
		}
		if (amountDesktop) {
			amountDesktop.textContent = money;
		}

		if (workersEl) {
			workersEl.textContent = formatCount(audience.workers * scale);
		}
		if (familiesEl) {
			familiesEl.textContent = formatCount(audience.families * scale);
		}
		if (factoriesEl) {
			factoriesEl.textContent = formatCount(audience.factories * scale);
		}

		setSliderFill(amount);
	}

	function setActiveTab(index) {
		activeIndex = index;
		tabs.forEach(function (tab) {
			const i = Number(tab.getAttribute('data-roi-tab'));
			const selected = i === activeIndex;
			tab.setAttribute('aria-selected', selected ? 'true' : 'false');
			tab.setAttribute('data-active', selected ? 'true' : 'false');
			tab.className = selected ? tabActive : tabIdle;
		});
		update();
	}

	tabs.forEach(function (tab) {
		tab.addEventListener('click', function () {
			setActiveTab(Number(tab.getAttribute('data-roi-tab')));
		});
	});

	if (slider) {
		slider.addEventListener('input', update);
		slider.addEventListener('change', update);
	}

	update();
})();

/**
 * Ambassadors grid pagination (client-side).
 */
(function () {
	document.querySelectorAll('[data-ambassadors-grid]').forEach(function (section) {
		const perPage = Number(section.getAttribute('data-per-page')) || 0;
		const cards = Array.prototype.slice.call(section.querySelectorAll('[data-ambassadors-card]'));
		const buttons = Array.prototype.slice.call(section.querySelectorAll('[data-ambassadors-page]'));

		if (perPage < 1 || !cards.length || !buttons.length) {
			return;
		}

		function setPage(page) {
			const start = (page - 1) * perPage;
			const end = start + perPage;

			cards.forEach(function (card, index) {
				card.classList.toggle('hidden', index < start || index >= end);
			});

			buttons.forEach(function (btn) {
				const btnPage = Number(btn.getAttribute('data-ambassadors-page'));
				const active = btnPage === page;
				btn.setAttribute('aria-current', active ? 'page' : 'false');
				btn.className = active
					? 'inline-flex items-center justify-center rounded-btn px-3 py-2 font-display text-card-title uppercase tracking-[2px] transition-colors bg-blue text-white'
					: 'inline-flex items-center justify-center rounded-btn px-3 py-2 font-display text-card-title uppercase tracking-[2px] transition-colors border border-solid border-[#dfe8ff] bg-white text-blue';
			});
		}

		buttons.forEach(function (btn) {
			btn.addEventListener('click', function () {
				setPage(Number(btn.getAttribute('data-ambassadors-page')));
			});
		});
	});
})();
