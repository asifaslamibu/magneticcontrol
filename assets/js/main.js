/**
 * Magnetic Control — front-end interactions.
 */
(function () {
	'use strict';

	var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	/* Floating masthead: scrolled state + back-to-top ---------------------- */
	var header = document.getElementById('mc-masthead');
	var toTop = document.querySelector('.mc-to-top');

	// Heroes leave room for the masthead via --mc-head-h; measure its full (unscrolled) height.
	if (header) {
		var measureHeader = function () {
			var bar = header.querySelector('.mc-topbar');
			var h = (bar ? bar.scrollHeight : 0) + header.querySelector('.mc-header').offsetHeight;
			document.documentElement.style.setProperty('--mc-head-h', h + 'px');
		};
		measureHeader();
		window.addEventListener('resize', measureHeader);
	}

	function onScroll() {
		var y = window.scrollY;
		if (header) header.classList.toggle('is-scrolled', y > 10);
		if (toTop) toTop.classList.toggle('is-visible', y > 600);
	}
	window.addEventListener('scroll', onScroll, { passive: true });
	onScroll();

	if (toTop) {
		toTop.addEventListener('click', function () {
			window.scrollTo({ top: 0, behavior: reduceMotion ? 'auto' : 'smooth' });
		});
	}

	/* Mobile navigation ---------------------------------------------------- */
	var nav = document.getElementById('mc-nav');
	var toggle = document.querySelector('.mc-nav-toggle');

	function setNav(open) {
		nav.classList.toggle('is-open', open);
		document.body.classList.toggle('mc-nav-open', open);
		toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
	}

	if (nav && toggle) {
		toggle.addEventListener('click', function () {
			setNav(!nav.classList.contains('is-open'));
		});
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && nav.classList.contains('is-open')) setNav(false);
		});
		document.addEventListener('click', function (e) {
			if (nav.classList.contains('is-open') && !nav.contains(e.target) && !toggle.contains(e.target)) setNav(false);
		});

		// Tap a parent item on mobile to expand its sub-menu.
		nav.querySelectorAll('.menu-item-has-children > a').forEach(function (link) {
			link.addEventListener('click', function (e) {
				if (window.innerWidth > 991) return;
				var item = link.parentElement;
				if (!item.classList.contains('is-expanded')) {
					e.preventDefault();
					item.classList.add('is-expanded');
				}
			});
		});
	}

	/* Fade slider (homepage hero) ------------------------------------------ */
	function fadeSlider(root, slideSelector, interval) {
		var slides = root.querySelectorAll(slideSelector);
		var dots = root.querySelectorAll('[data-dot]');
		if (slides.length < 2) return;

		var current = 0;
		var timer;

		function go(index) {
			current = (index + slides.length) % slides.length;
			slides.forEach(function (s, i) { s.classList.toggle('is-active', i === current); });
			dots.forEach(function (d, i) { d.classList.toggle('is-active', i === current); });
		}

		function restart() {
			clearInterval(timer);
			if (!reduceMotion && interval) timer = setInterval(function () { go(current + 1); }, interval);
		}

		var prev = root.querySelector('[data-prev]');
		var next = root.querySelector('[data-next]');
		if (prev) prev.addEventListener('click', function () { go(current - 1); restart(); });
		if (next) next.addEventListener('click', function () { go(current + 1); restart(); });
		dots.forEach(function (d) {
			d.addEventListener('click', function () { go(parseInt(d.getAttribute('data-dot'), 10)); restart(); });
		});

		root.addEventListener('mouseenter', function () { clearInterval(timer); });
		root.addEventListener('mouseleave', restart);
		restart();
	}

	var hero = document.querySelector('[data-slider="hero"]');
	if (hero) {
		// Slides 2+ carry their background in data-bg so they don't compete with slide 1.
		window.addEventListener('load', function () {
			hero.querySelectorAll('[data-bg]').forEach(function (slide) {
				slide.setAttribute('style', slide.getAttribute('data-bg'));
				slide.removeAttribute('data-bg');
			});
		});
		fadeSlider(hero, '.mc-hero__slide', 6000);
	}


	/* Partners carousel ---------------------------------------------------- */
	document.querySelectorAll('[data-carousel]').forEach(function (root) {
		var track = root.querySelector('.mc-partners__track');
		var items = track ? track.children : [];
		if (!items.length) return;

		var index = 0;
		var timer;

		function perView() {
			return Math.max(1, Math.round(track.parentElement.offsetWidth / items[0].offsetWidth));
		}

		function go(i) {
			var max = Math.max(0, items.length - perView());
			index = i > max ? 0 : (i < 0 ? max : i);
			track.style.transform = 'translateX(' + (-index * items[0].offsetWidth) + 'px)';
		}

		function restart() {
			clearInterval(timer);
			if (!reduceMotion) timer = setInterval(function () { go(index + 1); }, 3500);
		}

		root.querySelector('[data-prev]').addEventListener('click', function () { go(index - 1); restart(); });
		root.querySelector('[data-next]').addEventListener('click', function () { go(index + 1); restart(); });
		root.addEventListener('mouseenter', function () { clearInterval(timer); });
		root.addEventListener('mouseleave', restart);
		window.addEventListener('resize', function () { go(index); });
		restart();
	});

	/* Header search -------------------------------------------------------- */
	var search = document.querySelector('.mc-search');
	if (search) {
		var searchToggle = search.querySelector('.mc-search__toggle');
		var setSearch = function (open) {
			search.classList.toggle('is-open', open);
			searchToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
			if (open) search.querySelector('input[type="search"]').focus();
		};
		searchToggle.addEventListener('click', function () {
			setSearch(!search.classList.contains('is-open'));
		});
		document.addEventListener('click', function (e) {
			if (!search.contains(e.target)) setSearch(false);
		});
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape') setSearch(false);
		});
	}

	/* Catalog filter drawer (mobile) --------------------------------------- */
	var filters = document.getElementById('mc-filters');
	var filterToggle = document.querySelector('.mc-shop__filter-toggle');
	if (filters && filterToggle) {
		var setFilters = function (open) {
			filters.classList.toggle('is-open', open);
			document.body.classList.toggle('mc-filters-open', open);
			filterToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		};
		filterToggle.addEventListener('click', function (e) {
			e.stopPropagation();
			setFilters(!filters.classList.contains('is-open'));
		});
		document.addEventListener('click', function (e) {
			if (filters.classList.contains('is-open') && !filters.contains(e.target)) setFilters(false);
		});
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape') setFilters(false);
		});
	}

	/* Wishlist hearts (stored per browser) --------------------------------- */
	var WISH_KEY = 'mc_wishlist';
	function readWishlist() {
		try { return JSON.parse(localStorage.getItem(WISH_KEY)) || []; } catch (e) { return []; }
	}
	function writeWishlist(list) {
		try { localStorage.setItem(WISH_KEY, JSON.stringify(list)); } catch (e) { /* storage unavailable */ }
	}
	var wishlist = readWishlist();
	document.querySelectorAll('[data-wishlist]').forEach(function (btn) {
		var id = btn.getAttribute('data-wishlist');
		btn.setAttribute('aria-pressed', wishlist.indexOf(id) > -1 ? 'true' : 'false');
		btn.addEventListener('click', function () {
			wishlist = readWishlist();
			var at = wishlist.indexOf(id);
			if (at > -1) wishlist.splice(at, 1); else wishlist.push(id);
			writeWishlist(wishlist);
			btn.setAttribute('aria-pressed', at > -1 ? 'false' : 'true');
		});
	});

	/* Product hero: dark band ends under the title block ------------------- */
	var productHero = document.querySelector('[data-product-hero]');
	var productIntro = document.querySelector('[data-product-intro]');
	if (productHero && productIntro) {
		var sizeBand = function () {
			var bottom = productIntro.getBoundingClientRect().bottom - productHero.getBoundingClientRect().top;
			productHero.style.setProperty('--band', Math.round(bottom) + 'px');
		};
		sizeBand();
		window.addEventListener('resize', sizeBand);
		window.addEventListener('load', sizeBand);
	}

	/* Product gallery ------------------------------------------------------ */
	document.querySelectorAll('[data-gallery]').forEach(function (root) {
		var slides = root.querySelectorAll('[data-slide]');
		var thumbs = root.querySelectorAll('[data-thumb]');
		if (slides.length < 2) return;

		var current = 0;
		function go(index) {
			current = (index + slides.length) % slides.length;
			slides.forEach(function (s, i) { s.classList.toggle('is-active', i === current); });
			thumbs.forEach(function (t, i) { t.classList.toggle('is-active', i === current); });
		}

		root.querySelector('[data-prev]').addEventListener('click', function () { go(current - 1); });
		root.querySelector('[data-next]').addEventListener('click', function () { go(current + 1); });
		thumbs.forEach(function (t) {
			t.addEventListener('click', function () { go(parseInt(t.getAttribute('data-thumb'), 10)); });
		});

		// Swipe on touch screens.
		var startX = null;
		root.addEventListener('touchstart', function (e) { startX = e.touches[0].clientX; }, { passive: true });
		root.addEventListener('touchend', function (e) {
			if (startX === null) return;
			var dx = e.changedTouches[0].clientX - startX;
			if (Math.abs(dx) > 40) go(current + (dx < 0 ? 1 : -1));
			startX = null;
		});
	});

	/* Product tabs --------------------------------------------------------- */
	var tabsRoot = document.querySelector('[data-tabs]');
	if (tabsRoot) {
		var tabs = tabsRoot.querySelectorAll('[role="tab"]');

		var openTab = function (key, focus) {
			var found = false;
			tabs.forEach(function (tab) {
				var on = tab.getAttribute('data-tab') === key;
				found = found || on;
				tab.classList.toggle('is-active', on);
				tab.setAttribute('aria-selected', on ? 'true' : 'false');
				tab.tabIndex = on ? 0 : -1;
				if (on && focus) tab.focus();
				var panel = document.getElementById(tab.getAttribute('aria-controls'));
				if (panel) {
					panel.hidden = !on;
					panel.classList.toggle('is-active', on);
				}
			});
			return found;
		};

		tabs.forEach(function (tab, i) {
			tab.addEventListener('click', function () { openTab(tab.getAttribute('data-tab')); });
			tab.addEventListener('keydown', function (e) {
				var dir = e.key === 'ArrowRight' ? 1 : (e.key === 'ArrowLeft' ? -1 : 0);
				if (!dir) return;
				e.preventDefault();
				openTab(tabs[(i + dir + tabs.length) % tabs.length].getAttribute('data-tab'), true);
			});
		});

		// Links like the hero rating jump to (and open) their tab.
		document.querySelectorAll('[data-tab-link]').forEach(function (link) {
			link.addEventListener('click', function (e) {
				if (!openTab(link.getAttribute('data-tab-link'))) return;
				e.preventDefault();
				tabsRoot.scrollIntoView({ behavior: reduceMotion ? 'auto' : 'smooth' });
			});
		});

		// Deep links (#tab-reviews, #reviews, #comment-12 after posting a review).
		var hash = window.location.hash;
		if (/^#(tab-)?reviews$|^#comment-/.test(hash)) openTab('reviews');
		else if (/^#tab-/.test(hash)) openTab(hash.replace('#tab-', ''));
	}

	/* Quantity stepper ----------------------------------------------------- */
	document.querySelectorAll('.mc-buy .quantity').forEach(function (wrap) {
		var input = wrap.querySelector('.qty');
		if (!input || input.type === 'hidden') return;

		function button(label, icon, delta) {
			var b = document.createElement('button');
			b.type = 'button';
			b.className = 'mc-qty-btn';
			b.setAttribute('aria-label', label);
			b.innerHTML = '<svg class="mc-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="' + icon + '"/></svg>';
			b.addEventListener('click', function () {
				var step = parseFloat(input.step) || 1;
				var min = input.min !== '' ? parseFloat(input.min) : 1;
				var max = input.max !== '' ? parseFloat(input.max) : Infinity;
				var value = (parseFloat(input.value) || 0) + delta * step;
				input.value = Math.min(max, Math.max(min, value));
				input.dispatchEvent(new Event('change', { bubbles: true }));
			});
			return b;
		}

		wrap.insertBefore(button('Decrease quantity', 'M5 12h14', -1), input);
		wrap.appendChild(button('Increase quantity', 'M12 5v14M5 12h14', 1));
	});

	/* Related products carousel ------------------------------------------- */
	document.querySelectorAll('[data-related]').forEach(function (root) {
		var track = root.querySelector('.mc-related__track');
		if (!track) return;
		function page(dir) {
			var card = track.firstElementChild;
			var gap = parseFloat(getComputedStyle(track).columnGap) || 0;
			var stepW = card ? card.offsetWidth + gap : track.clientWidth;
			var atEnd = track.scrollLeft + track.clientWidth >= track.scrollWidth - 4;
			if (dir > 0 && atEnd) track.scrollTo({ left: 0 });
			else if (dir < 0 && track.scrollLeft <= 4) track.scrollTo({ left: track.scrollWidth });
			else track.scrollBy({ left: dir * stepW });
		}
		root.querySelector('[data-prev]').addEventListener('click', function () { page(-1); });
		root.querySelector('[data-next]').addEventListener('click', function () { page(1); });
	});

	/* Scroll reveal + counters --------------------------------------------- */
	function countUp(el) {
		var target = parseInt(el.getAttribute('data-count'), 10);
		if (reduceMotion || !target) return;
		var start = null;
		var duration = 1600;
		function step(ts) {
			if (!start) start = ts;
			var p = Math.min((ts - start) / duration, 1);
			var eased = 1 - Math.pow(1 - p, 3);
			el.textContent = Math.round(target * eased).toLocaleString('en-GB');
			if (p < 1) requestAnimationFrame(step);
		}
		requestAnimationFrame(step);
	}

	var revealEls = document.querySelectorAll('[data-reveal]');
	var counters = document.querySelectorAll('[data-count]');

	if (!('IntersectionObserver' in window)) {
		revealEls.forEach(function (el) { el.classList.add('is-revealed'); });
		return;
	}

	var io = new IntersectionObserver(function (entries) {
		entries.forEach(function (entry) {
			if (!entry.isIntersecting) return;
			var el = entry.target;
			if (el.hasAttribute('data-count')) {
				countUp(el);
			} else {
				el.classList.add('is-revealed');
			}
			io.unobserve(el);
		});
	}, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

	revealEls.forEach(function (el) { io.observe(el); });
	counters.forEach(function (el) {
		if (!reduceMotion) el.textContent = '0'; // Count up from zero once it scrolls into view.
		io.observe(el);
	});
})();
