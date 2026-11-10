(function () {
	'use strict';

	// Mobile menu.
	var toggle = document.querySelector('.nav-toggle');
	var nav = document.getElementById('site-nav');
	if (toggle && nav) {
		toggle.addEventListener('click', function () {
			var open = nav.classList.toggle('open');
			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		});
		nav.addEventListener('click', function (e) {
			if (e.target.tagName === 'A') {
				nav.classList.remove('open');
				toggle.setAttribute('aria-expanded', 'false');
			}
		});
	}

	// Price estimate.
	var estService = document.getElementById('est-service');
	var estTotal = document.getElementById('est-total');
	var formService = document.getElementById('ff_service');
	var formUrgency = document.getElementById('ff_urgency');
	var touched = false;
	function estimate() {
		if (!estService || !estTotal) { return; }
		var opt = estService.options[estService.selectedIndex];
		var checked = document.querySelector('input[name="est-urgency"]:checked');
		var price = parseFloat(opt.getAttribute('data-price')) || 0;
		var mult = checked ? parseFloat(checked.getAttribute('data-mult')) : 1;
		estTotal.textContent = '$' + Math.round(price * mult);
		if (formService && touched) { formService.value = estService.value; }
		if (formUrgency && checked) { formUrgency.value = checked.value; }
	}
	if (estService) {
		var onChange = function () { touched = true; estimate(); };
		estService.addEventListener('change', onChange);
		document.querySelectorAll('input[name="est-urgency"]').forEach(function (r) {
			r.addEventListener('change', onChange);
		});
		// Preselect a service when coming from a service page (?service=ID).
		var wanted = (new URLSearchParams(window.location.search).get('service') || '').replace(/\D/g, '');
		if (wanted && estService.querySelector('option[value="' + wanted + '"]')) {
			estService.value = wanted;
			touched = true;
		}
		estimate();
		var book = document.getElementById('est-book');
		if (book) { book.addEventListener('click', onChange); }
	}

	// Booking form validation.
	var form = document.querySelector('form.booking');
	if (form) {
		var rules = {
			ff_name: function (v) { return v.trim().length >= 2; },
			ff_phone: function (v) { return v.replace(/\D/g, '').length >= 7; }
		};
		var check = function (input) {
			var ok = rules[input.name](input.value);
			var err = input.parentNode.querySelector('.err');
			input.setAttribute('aria-invalid', ok ? 'false' : 'true');
			if (err) { err.hidden = ok; }
			return ok;
		};
		Object.keys(rules).forEach(function (name) {
			var input = form.elements[name];
			input.addEventListener('blur', function () { check(input); });
		});
		form.addEventListener('submit', function (e) {
			var firstBad = null;
			Object.keys(rules).forEach(function (name) {
				var input = form.elements[name];
				if (!check(input) && !firstBad) { firstBad = input; }
			});
			if (firstBad) {
				e.preventDefault();
				firstBad.focus();
			}
		});
	}

	// Reveal on scroll and animated counters.
	var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	var items = document.querySelectorAll('.reveal');
	if (reduce || !('IntersectionObserver' in window)) {
		items.forEach(function (el) { el.classList.add('in'); });
		return;
	}
	var io = new IntersectionObserver(function (entries) {
		entries.forEach(function (entry) {
			if (entry.isIntersecting) {
				entry.target.classList.add('in');
				io.unobserve(entry.target);
			}
		});
	}, { threshold: 0.12 });
	items.forEach(function (el) { io.observe(el); });

	document.querySelectorAll('[data-count]').forEach(function (el) {
		var target = parseInt(el.getAttribute('data-count'), 10);
		var start = null;
		function step(ts) {
			if (!start) { start = ts; }
			var p = Math.min((ts - start) / 900, 1);
			el.textContent = Math.round(target * p).toLocaleString('en-US');
			if (p < 1) { requestAnimationFrame(step); }
		}
		requestAnimationFrame(step);
	});
})();
