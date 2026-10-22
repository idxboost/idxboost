/*!
 * IDX Cookie Consent — main (inline, end of <body>).
 * Banner/preferences UI, consent storage, deferred script activation,
 * Consent Mode update, Cloudflare Zaraz bridge and cookie cleanup.
 */
(function (w, d) {
	var S = w.ICC, C = w.ICC_CFG,
		CATS = ['analytics', 'marketing', 'preferences'],
		root = d.documentElement,
		queue = [], running = false, lastFocus = null, zzWait = false;

	if (!S || !C) return;

	/* ---------- Script activation ---------- */

	function copyScript(old) {
		var s = d.createElement('script'), a = old.attributes, t = old.getAttribute('data-icc-type');
		for (var i = 0; i < a.length; i++) {
			var n = a[i].name;
			if (n !== 'type' && n !== 'data-icc' && n !== 'data-icc-type') s.setAttribute(n, a[i].value);
		}
		if (t) s.type = t;
		if (!old.src) s.text = old.text;
		return s;
	}

	// Runs scripts one by one so an external library loads before the inline code that uses it.
	function run() {
		if (running) return;
		var old = queue.shift();
		if (!old) return;
		running = true;
		var s = copyScript(old),
			wait = s.src && !s.hasAttribute('async'),
			next = function () { running = false; run(); };
		if (wait) s.onload = s.onerror = next;
		old.parentNode.replaceChild(s, old);
		if (!wait) next();
	}

	function activate(c) {
		var els = d.querySelectorAll('[data-icc]');
		for (var i = 0; i < els.length; i++) {
			var el = els[i], k = el.getAttribute('data-icc');
			if (!c[k] || el._icc) continue;
			el._icc = 1;
			if (el.tagName === 'TEMPLATE') {
				var f = el.content.cloneNode(true), sc = f.querySelectorAll('script');
				for (var j = 0; j < sc.length; j++) {
					var ty = sc[j].getAttribute('type');
					if (ty && !/^(text\/javascript|application\/javascript|module)$/i.test(ty)) continue; // JSON-LD etc.
					if (ty) sc[j].setAttribute('data-icc-type', ty);
					sc[j].type = 'text/plain'; // keep it inert until we recreate it in order
					sc[j].setAttribute('data-icc', k);
					sc[j]._icc = 1;
					queue.push(sc[j]);
				}
				el.parentNode.insertBefore(f, el.nextSibling);
			} else if (el.tagName === 'SCRIPT') {
				queue.push(el);
			} else if (el.hasAttribute('data-icc-src')) {
				el.src = el.getAttribute('data-icc-src');
			}
		}
		run();
	}

	/* ---------- Integrations ---------- */

	function zaraz(c) {
		if (!C.zz) return;
		var z = w.zaraz;
		if (z && z.consent && z.consent.APIReady) {
			var o = {}, has = false;
			for (var k in C.zz) if (C.zz[k]) { o[C.zz[k]] = !!c[k]; has = true; }
			if (has) {
				z.consent.set(o);
				if (z.consent.sendQueuedEvents) z.consent.sendQueuedEvents();
			}
		} else if (!zzWait) {
			zzWait = true;
			d.addEventListener('zarazConsentAPIReady', function () { zzWait = false; zaraz(S.consent); }, { once: true });
		}
	}

	function apply(c, changed) {
		w.dataLayer = w.dataLayer || [];
		if (C.gcm && changed) (function () { w.dataLayer.push(arguments); })('consent', 'update', S.gcm(c));
		zaraz(c);
		w.dataLayer.push({
			event: changed ? 'icc_consent_update' : 'icc_consent_ready',
			icc_analytics: !!c.analytics, icc_marketing: !!c.marketing, icc_preferences: !!c.preferences
		});
		activate(c);
		try { d.dispatchEvent(new CustomEvent('icc:consent', { detail: { consent: c, changed: !!changed } })); } catch (e) {}
	}

	/* ---------- Storage ---------- */

	function expire(name) {
		var h = location.hostname.split('.'), base = '; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/';
		d.cookie = name + '=' + base;
		for (var i = 0; i < h.length - 1; i++) {
			var dom = h.slice(i).join('.');
			d.cookie = name + '=' + base + '; domain=' + dom;
			d.cookie = name + '=' + base + '; domain=.' + dom;
		}
	}

	function clean(prev, c) {
		var names = d.cookie.split(/;\s*/);
		for (var k in C.del) {
			if (!prev[k] || c[k]) continue;
			for (var i = 0; i < names.length; i++) {
				var n = names[i].split('=')[0];
				for (var j = 0; j < C.del[k].length; j++) if (n.indexOf(C.del[k][j]) === 0) expire(n);
			}
		}
	}

	function save(c) {
		var prev = S.consent, val = [C.rev], revoked = false;
		for (var i = 0; i < 3; i++) {
			var k = CATS[i];
			c[k] = !!c[k] && C.cats.indexOf(k) > -1;
			val.push(c[k] ? 1 : 0);
			if (prev && prev[k] && !c[k]) revoked = true;
		}
		d.cookie = C.ck + '=' + val.join('.') + '; path=/; max-age=' + C.days * 86400 + '; SameSite=Lax' +
			(location.protocol === 'https:' ? '; Secure' : '') + (C.dom ? '; domain=' + C.dom : '');
		S.consent = c;
		S.implied = false;
		root.classList.remove('icc-imp');
		root.classList.add('icc-ok');
		close();
		if (revoked) {
			clean(prev, c);
			if (C.reload) {
				// Drop #icc-settings / #icc-do-not-sell so the dialog doesn't reopen after reload.
				if (/^#icc-/.test(location.hash)) history.replaceState(null, '', location.pathname + location.search);
				return location.reload();
			}
		}
		apply(c, true);
	}

	function all(v) {
		var c = {};
		for (var i = 0; i < 3; i++) c[CATS[i]] = v;
		return c;
	}

	/* ---------- Preferences dialog (built on demand from <template>) ---------- */

	function dlg() { return d.getElementById('icc-prefs'); }

	// preset: values forced on open (e.g. {marketing:false} for "Do Not Sell or Share").
	function open(preset) {
		if (dlg()) return;
		var t = d.getElementById('icc-tpl');
		if (!t) return;
		lastFocus = d.activeElement;
		d.body.appendChild(t.content.cloneNode(true));
		var m = dlg(), cur = S.consent && (!S.implied || preset) ? S.consent : null,
			boxes = m.querySelectorAll('input[data-cat]');
		for (var i = 0; i < boxes.length; i++) {
			var k = boxes[i].getAttribute('data-cat');
			boxes[i].checked = preset && k in preset ? !!preset[k] : cur ? !!cur[k] : false;
		}
		root.classList.add('icc-lock');
		var f = m.querySelector('button,input:not([disabled])');
		if (f) f.focus();
	}

	function close() {
		var m = dlg();
		if (!m) return;
		m.parentNode.removeChild(m);
		root.classList.remove('icc-lock');
		if (lastFocus && lastFocus.focus) lastFocus.focus();
	}

	function fromDialog() {
		var c = {}, boxes = dlg().querySelectorAll('input[data-cat]');
		for (var i = 0; i < boxes.length; i++) c[boxes[i].getAttribute('data-cat')] = boxes[i].checked;
		return c;
	}

	/* ---------- Events ---------- */

	d.addEventListener('click', function (e) {
		var t = e.target.closest ? e.target.closest('[data-icc-act],[data-icc-open],a[href$="#icc-settings"],a[href$="#icc-do-not-sell"]') : null;
		if (!t) {
			if (e.target.id === 'icc-prefs') close();
			return;
		}
		var a = t.getAttribute('data-icc-act') || (/#icc-do-not-sell$/.test(t.getAttribute('href') || '') ? 'optout' : 'prefs');
		e.preventDefault();
		if (a === 'accept') save(all(true));
		else if (a === 'reject') save(all(false));
		else if (a === 'save') save(fromDialog());
		else if (a === 'close') close();
		else if (a === 'optout') { close(); open({ marketing: false }); }
		else open();
	});

	d.addEventListener('keydown', function (e) {
		var m = dlg();
		if (!m) return;
		if (e.key === 'Escape') return close();
		if (e.key !== 'Tab') return;
		var f = m.querySelectorAll('button,input:not([disabled]),a[href]'),
			first = f[0], last = f[f.length - 1];
		if (e.shiftKey && d.activeElement === first) { last.focus(); e.preventDefault(); }
		else if (!e.shiftKey && d.activeElement === last) { first.focus(); e.preventDefault(); }
	});

	/* ---------- Public API ---------- */

	S.open = open;
	S.close = close;
	S.save = save;
	S.has = function (k) { return !!(S.consent && S.consent[k]); };

	/* ---------- Init ---------- */

	function ready() {
		if (!S.consent) return;
		apply(S.consent, false);
		// Pick up blocked tags printed after this script (late wp_footer output).
		if (d.readyState === 'loading') d.addEventListener('DOMContentLoaded', function () { activate(S.consent); });
	}
	// Geo API still answering: decide when it does (banner stays hidden meanwhile).
	if (S.pending) S.onGeo = ready;
	else ready();
	if (location.hash === '#icc-settings') open();
	else if (location.hash === '#icc-do-not-sell') open({ marketing: false });
})(window, document);
