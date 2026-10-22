/*!
 * IDX Cookie Consent — head bootstrap (inline, runs before <body>).
 * Reads the consent cookie, resolves geo region, sets Consent Mode v2
 * defaults/updates and flags <html> so the banner never flashes.
 * Expects window.ICC_CFG to be defined right before this script.
 */
(function (w, d) {
	var C = w.ICC_CFG,
		CATS = ['analytics', 'marketing', 'preferences'],
		root = d.documentElement,
		S = { consent: null, implied: false, region: true, country: '' };

	function gc(n) {
		var m = d.cookie.match('(?:^|; )' + n.replace(/[.$?*|{}()[\]\\/+^]/g, '\\$&') + '=([^;]*)');
		return m ? decodeURIComponent(m[1]) : null;
	}

	function gcm(c) {
		var g = function (v) { return v ? 'granted' : 'denied'; };
		return {
			analytics_storage: g(c.analytics),
			ad_storage: g(c.marketing),
			ad_user_data: g(c.marketing),
			ad_personalization: g(c.marketing),
			functionality_storage: g(c.preferences),
			personalization_storage: g(c.preferences)
		};
	}

	// Stored consent: "<revision>.<analytics>.<marketing>.<preferences>".
	var v = gc(C.ck);
	if (v) {
		var p = v.split('.');
		if (p.length === 4 && +p[0] === C.rev) {
			S.consent = {};
			for (var i = 0; i < 3; i++) S.consent[CATS[i]] = p[i + 1] === '1';
		}
	}

	// Global Privacy Control: browser-level "do not sell/share" signal (CCPA and other US states).
	S.gpc = !!(C.gpc && navigator.globalPrivacyControl === true);
	if (S.gpc) root.className += ' icc-gpc-on';

	function gt() { w.dataLayer.push(arguments); }

	function tzName() {
		try { return Intl.DateTimeFormat().resolvedOptions().timeZone || ''; } catch (e) { return ''; }
	}

	// Decide from a known country (+ optional ISO 3166-2 region such as "US-CA", + optional continent).
	function decide(cc, rg, ct) {
		if (cc && !rg && C.geo.tzf) {
			var z = C.geo.tz[tzName()];
			if (z && z.slice(0, 2) === cc) rg = z; // e.g. US + Pacific time → US-CA
		}
		S.country = cc;
		S.subdivision = rg;
		S.continent = ct || '';
		if (ct && C.geo.eur && ct === 'EU') return true; // whole continent of Europe
		for (var l = 0; l < C.geo.list.length; l++) {
			if (C.geo.list[l] === cc || (rg && C.geo.list[l] === rg)) return true;
		}
		return false;
	}

	// Location unknown: browser time zone guess, or a fixed show/hide rule.
	function unknown() {
		if (C.geo.unk !== 'tz') return C.geo.unk !== 'hide';
		var zn = tzName(), zr = C.geo.tz[zn];
		S.tz = zn;
		S.subdivision = zr || '';
		return !zn ||
			(C.geo.eu && (/^(Europe|Arctic)\//.test(zn) || /^Atlantic\/(Reykjavik|Canary|Madeira|Azores|Faroe|Faeroe)$/.test(zn))) ||
			(!!zr && C.geo.list.indexOf(zr) > -1);
	}

	// Outside the consent region and no explicit choice: consent implied, no banner
	// (marketing stays off when the browser sends GPC).
	function implied() {
		S.consent = {};
		for (var j = 0; j < 3; j++) S.consent[CATS[j]] = C.cats.indexOf(CATS[j]) > -1;
		if (S.gpc) S.consent.marketing = false;
		S.implied = true;
		root.className += ' icc-imp icc-ok';
	}

	// Geo API (e.g. a Cloudflare Worker returning {"country":"US","region_code":"CA"}).
	// Only on the first visit: the answer is cached in the location cookie for 24 h.
	function lookup() {
		var done = false;
		function finish(region) {
			if (done) return;
			done = true;
			S.pending = false;
			S.region = region;
			root.classList.remove('icc-wait');
			if (!region && !S.consent) {
				implied();
				if (C.gcm) gt('consent', 'update', gcm(S.consent));
			}
			if (S.onGeo) S.onGeo();
		}
		var timer = setTimeout(function () { finish(unknown()); }, C.geo.ms || 1500);
		try {
			fetch(C.geo.api, { method: C.geo.m || 'GET', credentials: 'omit' }).then(function (r) { return r.json(); }).then(function (j) {
				clearTimeout(timer);
				if (!j || j.status === false) return finish(unknown());
				var cc = String(j.country || j.country_code || '').toUpperCase(),
					rc = String(j.region_code || '').toUpperCase(),
					ct = String(j.continent || '').toUpperCase(),
					rg = rc ? (rc.indexOf(cc + '-') === 0 ? rc : cc + '-' + rc) : '';
				if (!/^[A-Z]{2}$/.test(cc)) return finish(unknown());
				if (!/^[A-Z]{2}-[A-Z0-9]{1,3}$/.test(rg)) rg = '';
				if (!/^[A-Z]{2}$/.test(ct)) ct = '';
				// California = continent NA + country US + region_code CA.
				if (cc === 'US' && ct && ct !== 'NA') rg = '';
				d.cookie = C.geo.ck + '=' + cc + (rg ? '|' + rg : '') + (ct ? '|@' + ct : '') + '; path=/; max-age=86400; SameSite=Lax' +
					(location.protocol === 'https:' ? '; Secure' : '');
				if (!done) finish(decide(cc, rg, ct)); // a late answer only serves the next page view
			})['catch'](function () { clearTimeout(timer); finish(unknown()); });
		} catch (e) {
			clearTimeout(timer);
			finish(unknown());
		}
	}

	w.dataLayer = w.dataLayer || [];
	// Queue gtag() calls made by other code before the (consent-gated) gtag.js loads.
	if (typeof w.gtag !== 'function') w.gtag = gt;

	// Everything runs in the browser (cached HTML is identical for all visitors):
	// location cookie (previous API answer / optional edge rule) → geo API (POST) → time zone. Accepted values: "DE", "US-CA", "US|US-CA", "ES|ES-MD|@EU" (@ = continent).
	if (C.geo) {
		var raw = String(w.ICC_COUNTRY || gc(C.geo.ck) || '').toUpperCase().split(/[|,;\s]+/),
			cc = '', rg = '', ct = '';
		for (var t = 0; t < raw.length; t++) {
			if (/^[A-Z]{2}-[A-Z0-9]{1,3}$/.test(raw[t])) rg = raw[t];
			else if (/^[A-Z]{2}$/.test(raw[t])) cc = raw[t];
			else if (/^@[A-Z]{2}$/.test(raw[t])) ct = raw[t].slice(1);
		}
		if (!cc && rg) cc = rg.slice(0, 2);
		if (cc) S.region = decide(cc, rg, ct);
		else if (C.geo.api && !S.consent) S.pending = true;
		else S.region = unknown();
	}

	if (S.pending) root.className += ' icc-wait';
	else if (!S.region && !S.consent) implied();
	else if (S.consent) root.className += ' icc-ok';

	if (C.gcm) {
		var def = gcm({});
		def.security_storage = 'granted';
		def.wait_for_update = 500;
		gt('consent', 'default', def);
		if (C.gcm.red) gt('set', 'ads_data_redaction', true);
		if (C.gcm.pass) gt('set', 'url_passthrough', true);
		if (S.consent) gt('consent', 'update', gcm(S.consent));
	}

	if (S.pending) lookup();

	S.gc = gc;
	S.gcm = gcm;
	w.ICC = S;
})(window, document);
