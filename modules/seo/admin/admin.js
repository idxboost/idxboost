/* IDXBoost SEO — admin app (vanilla JS). Data comes from the REST API (idxb-seo/v1). */
(function () {
  'use strict';

  const CFG = window.IDXB_SEO || {};
  const app = document.getElementById('idxb-seo-app');
  if (!app || !CFG.boot) return;

  /* ---------------- state ---------------- */
  const clone = (o) => JSON.parse(JSON.stringify(o));
  const fixMaps = (s) => {
    ['postTypes', 'taxonomies'].forEach((k) => { if (Array.isArray(s.sitemap[k])) s.sitemap[k] = {}; });
    return s;
  };
  const S = {
    route: CFG.route || 'sitemap',
    draft: fixMaps(clone(CFG.boot.settings)),
    saved: '',
    meta: CFG.boot.meta,
    status: CFG.boot.status,
    saving: false,
    ui: { file: 'sitemap_index.xml', view: 'xml', tester: { ua: 'Googlebot', path: '/?s=condos' }, idxTest: null, probe: null, importMsg: null, rbView: 'next' },
    pv: { sitemap: null, robots: null, sitemapErr: '', robotsErr: '' },
    live: null, sources: null,
  };
  S.saved = JSON.stringify(S.draft);
  const dirty = () => JSON.stringify(S.draft) !== S.saved;

  /* ---------------- utils ---------------- */
  const h = (s) => String(s == null ? '' : s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
  const fmtDate = (ts) => (ts ? new Date(ts * 1000).toISOString().slice(0, 16).replace('T', ' ') : '—');
  const fmtNum = (n) => Number(n || 0).toLocaleString('en-US');
  const ago = (ts) => {
    if (!ts) return 'never';
    const d = Math.round(Date.now() / 1000 - ts);
    if (d < 90) return d + ' s ago';
    if (d < 5400) return Math.round(d / 60) + ' min ago';
    if (d < 129600) return Math.round(d / 3600) + ' h ago';
    return Math.round(d / 86400) + ' days ago';
  };

  async function api(path, method = 'GET', body) {
    const res = await fetch(CFG.rest + path, {
      method,
      credentials: 'same-origin',
      headers: { 'X-WP-Nonce': CFG.nonce, 'Content-Type': 'application/json' },
      body: body ? JSON.stringify(body) : undefined,
    });
    let data = null;
    try { data = await res.json(); } catch (e) { /* non-JSON */ }
    if (!res.ok) throw new Error((data && data.message) || 'HTTP ' + res.status);
    return data;
  }

  function toast(msg, err) {
    let t = document.getElementById('idxb-toast');
    if (!t) { t = document.createElement('div'); t.id = 'idxb-toast'; t.className = 'idxb-toast'; document.body.appendChild(t); }
    t.textContent = msg; t.classList.toggle('err', !!err); t.classList.add('show');
    clearTimeout(t._t); t._t = setTimeout(() => t.classList.remove('show'), 2400);
  }

  function download(name, text, type) {
    const a = document.createElement('a');
    a.href = URL.createObjectURL(new Blob([text], { type }));
    a.download = name; document.body.appendChild(a); a.click(); a.remove();
    setTimeout(() => URL.revokeObjectURL(a.href), 1000);
  }
  async function copy(text) {
    try { await navigator.clipboard.writeText(text); toast('Copied to clipboard'); } catch (e) { toast('Could not copy', true); }
  }

  /* ---------------- bindings ---------------- */
  function defaultFor(path) {
    let m = path.match(/^sitemap\.postTypes\.(.+)$/);
    if (m) return m[1] !== 'attachment';
    m = path.match(/^sitemap\.taxonomies\.(.+)$/);
    if (m) return m[1] !== 'post_format';
    return undefined;
  }
  function get(path) {
    const v = path.split('.').reduce((o, k) => (o == null ? undefined : o[k]), S.draft);
    return v === undefined ? defaultFor(path) : v;
  }
  function set(path, value) {
    const keys = path.split('.');
    let o = S.draft;
    while (keys.length > 1) {
      const k = keys.shift();
      if (o[k] == null || typeof o[k] !== 'object' || Array.isArray(o[k])) o[k] = {};
      o = o[k];
    }
    o[keys[0]] = value;
    changed();
  }

  /* ---------------- previews ---------------- */
  let tSm = null, tRb = null, seqSm = 0, seqRb = 0;
  function loadSitemap(delay = 400) {
    clearTimeout(tSm);
    tSm = setTimeout(async () => {
      const my = ++seqSm;
      try {
        const d = await api('/preview/sitemap', 'POST', { settings: S.draft, file: S.ui.file });
        if (my !== seqSm) return;
        S.pv.sitemap = d; S.pv.sitemapErr = '';
        if (d.enabled) S.ui.file = d.file;
      } catch (e) { S.pv.sitemapErr = e.message; }
      render();
    }, delay);
  }
  function loadRobots(delay = 300) {
    clearTimeout(tRb);
    tRb = setTimeout(async () => {
      const my = ++seqRb;
      try {
        const d = await api('/preview/robots', 'POST', { settings: S.draft, ua: S.ui.tester.ua, path: S.ui.tester.path });
        if (my !== seqRb) return;
        S.pv.robots = d; S.pv.robotsErr = '';
      } catch (e) { S.pv.robotsErr = e.message; }
      render();
    }, delay);
  }
  function refreshPreview(delay) {
    if (S.route === 'sitemap') loadSitemap(delay);
    if (S.route === 'robots') loadRobots(delay);
  }
  function changed() { render(); refreshPreview(); }

  /* ---------------- save ---------------- */
  async function save() {
    if (S.saving) return;
    S.saving = true; render();
    try {
      const d = await api('/settings', 'POST', { settings: S.draft });
      S.draft = fixMaps(d.settings); S.saved = JSON.stringify(S.draft); S.status = d.status;
      toast('Changes saved');
      if (S.status.robots && S.status.robots.file && S.status.robots.file.foreign && S.route === 'robots' &&
          window.confirm('Your site has its own robots.txt. Update it now with these rules? A copy of the original is kept and nothing is deleted.')) {
        try { const t = await api('/robots/take-control', 'POST'); S.ui.importMsg = { ok: t.ok, msg: t.msg }; S.status = t.status; } catch (e2) { toast(e2.message, true); }
      }
      if (S.route === 'robots') loadLive();
    } catch (e) { toast('Save failed: ' + e.message, true); }
    S.saving = false; render(); refreshPreview(0);
  }
  window.addEventListener('beforeunload', (e) => { if (dirty()) { e.preventDefault(); e.returnValue = ''; } });

  /* ---------------- UI pieces ---------------- */
  function toggle(path, opts = {}) {
    const v = !!get(path);
    return `<label class="idxb-toggle"><input type="checkbox" data-bind="${path}" ${v ? 'checked' : ''} ${opts.disabled ? 'disabled' : ''} aria-label="${h(opts.label || path)}"><span></span></label>`;
  }
  function row(label, help, control) {
    return `<div class="idxb-row"><div class="lbl"><strong>${label}</strong>${help ? `<small>${help}</small>` : ''}</div><div class="ctl">${control}</div></div>`;
  }
  function field(label, help, path, opts = {}) {
    const v = get(path);
    const type = opts.type || 'text';
    const ctl = opts.textarea
      ? `<textarea data-bind="${path}" rows="${opts.rows || 4}" class="${opts.mono ? 'mono' : ''}" spellcheck="false" ${opts.disabled ? 'disabled' : ''} placeholder="${h(opts.ph || '')}">${h(v)}</textarea>`
      : `<input type="${type}" data-bind="${path}" value="${h(v)}" ${type === 'number' ? `min="${opts.min || 0}" max="${opts.max || 99999}"` : ''} placeholder="${h(opts.ph || '')}" ${opts.disabled ? 'disabled' : ''} class="${opts.wide ? 'wide' : ''}">`;
    return `<div class="idxb-row block"><div class="lbl"><strong>${label}</strong>${help ? `<small>${help}</small>` : ''}</div>${ctl}</div>`;
  }
  function card(title, body, extra = '') {
    return `<div class="idxb-card"><h2><span>${title}</span>${extra}</h2><div class="body">${body}</div></div>`;
  }
  function notice(level, html) {
    return `<div class="idxb-notice ${level}"><p>${html}</p></div>`;
  }

  function notPublished() { return S.route === 'robots' && ['foreign', 'external', 'stale', 'edited'].includes(robotsState()); }
  function savebarText() {
    if (S.saving) return 'Saving…';
    if (dirty()) return 'You have unsaved changes. The preview shows them; the live site does not.';
    if (notPublished()) return { foreign: 'Saved in the editor. The site robots.txt has not been updated yet: click “Publish to the site robots.txt”.', stale: 'Saved, but the site still shows an older version (see the notice above).', edited: 'The robots.txt on the server has manual changes that are not in the editor (see the notice above).' }[robotsState()] || 'Saved, but the hosting or CDN is still serving a different robots.txt (see the notice above).';
    return 'All saved. The live site uses these settings.';
  }

  function header(title, subtitle) {
    const d = dirty();
    const tabs = [['sitemap', 'Sitemap'], ['robots', 'Robots'], ['tools', 'Tools']]
      .map(([k, l]) => `<a href="${h(CFG.urls[k])}" class="nav-tab ${S.route === k ? 'nav-tab-active' : ''}">${l}</a>`).join('');
    return `<h1 class="idxb-title">${h(title)} <span class="idxb-badge">v${h(CFG.version)}</span></h1>
      <p class="idxb-sub">${subtitle}</p>
      <nav class="nav-tab-wrapper idxb-tabs">${tabs}</nav>
      <div class="idxb-savebar ${d ? 'dirty' : ''} ${!d && notPublished() ? 'blocked' : ''}">
        <span>${savebarText()}</span>
        <span class="idxb-btns">${d ? '<button class="button" id="idxb-discard">Discard</button>' : ''}<button class="button button-primary" id="idxb-save" ${!d || S.saving ? 'disabled' : ''}>Save changes</button></span>
      </div>`;
  }

  function highlightXml(xml) {
    return h(xml)
      .replace(/(&lt;!--[\s\S]*?--&gt;)/g, '<span class="c">$1</span>')
      .replace(/(&lt;\??\/?)([\w:-]+)/g, '$1<span class="t">$2</span>')
      .replace(/([\w:-]+)=(&quot;.*?&quot;)/g, '<span class="a">$1</span>=<span class="v">$2</span>');
  }
  function highlightRobots(txt) {
    return txt.replace(/\n$/, '').split('\n').map((l) => {
      let s = h(l);
      if (/^\s*#/.test(l)) s = `<span class="${/IDXBOOST/.test(l) ? 'y' : 'c'}">${s}</span>`;
      else s = s.replace(/^([A-Za-z-]+)(\s*:)/, '<span class="k">$1</span>$2');
      return `<span class="ln">${s || ' '}</span>`;
    }).join('');
  }

  /* ---------------- Sitemap screen ---------------- */
  function renderSitemap() {
    const sm = S.draft.sitemap;
    const idx = S.draft.idx;
    const off = !sm.enabled;
    const idxSt = S.status.idx || {};

    const ptRows = S.meta.postTypes.map((pt) => row(
      h(pt.label),
      `<code>${h(pt.key)}-sitemap.xml</code> · ${fmtNum(pt.count)} published`,
      toggle('sitemap.postTypes.' + pt.key, { disabled: off, label: pt.label })
    )).join('');
    const txRows = S.meta.taxonomies.map((tx) => row(
      h(tx.label),
      `<code>${h(tx.key)}-sitemap.xml</code> · ${fmtNum(tx.count)} terms`,
      toggle('sitemap.taxonomies.' + tx.key, { disabled: off, label: tx.label })
    )).join('');

    let idxStatus = '';
    if (idxSt.status === 'running') idxStatus = notice('warn', `Syncing… page ${h(idxSt.page)} · ${fmtNum(idxSt.fetched)} properties read.`);
    else if (idxSt.status === 'error') idxStatus = notice('err', `Last sync failed: ${h(idxSt.last_error)}`);
    const idxInfo = `<div class="idxb-stats small">
        <div class="stat"><b>${fmtNum(idxSt.total)}</b><span>cached properties</span></div>
        <div class="stat"><b>${h(ago(idxSt.last_success))}</b><span>last successful sync</span></div>
        <div class="stat"><b>${idxSt.next ? h(fmtDate(idxSt.next)) : '—'}</b><span>next (UTC)</span></div>
      </div>`;
    const test = S.ui.idxTest;
    const testOut = !test ? '' : test.ok
      ? notice('ok', h(test.msg)) + (test.sample && test.sample.length ? `<div class="idxb-xsl-wrap"><table class="idxb-xsl-table"><thead><tr><th>Generated URL</th><th>Images</th><th>Modified</th></tr></thead><tbody>${test.sample.map((s) => `<tr><td>${h(s.url)}</td><td>${s.images.length}</td><td>${h(fmtDate(s.lastmod))}</td></tr>`).join('')}</tbody></table></div>` : '')
      : notice('err', h(test.msg));
    const ioff = off || !idx.enabled;

    const left = [
      card('XML sitemaps',
        row('Enable XML sitemaps', `Generates <code>${h(S.meta.home)}sitemap_index.xml</code> with one sub-sitemap per content type, taxonomy, authors and IDX properties.`, toggle('sitemap.enabled', { label: 'Enable sitemaps' })) +
        row('Replace other plugins sitemaps', 'Turns off the WordPress, Yoast SEO and Rank Math sitemaps while this is active. <code>/sitemap.xml</code> and <code>/wp-sitemap.xml</code> redirect to the index.', toggle('sitemap.takeOver', { disabled: off }))),
      card('Content types', ptRows + `<p class="idxb-muted">Yoast / Rank Math <code>noindex</code> and canonical settings are respected, as well as the “Exclude from XML sitemaps” box on each post.</p>`),
      card('Taxonomies', txRows + row('Hide empty terms', 'Terms without published content are left out.', toggle('sitemap.excludeEmptyTerms', { disabled: off }))),
      card('Authors',
        row('Author sitemap', 'Includes <code>author-sitemap.xml</code>. Only users who can publish: registered leads are never listed.', toggle('sitemap.authors.enabled', { disabled: off })) +
        row('Exclude authors without posts', 'Only authors with at least one published post.', toggle('sitemap.authors.excludeNoPosts', { disabled: off || !sm.authors.enabled }))),
      card('Properties (IDX service)',
        row('Property detail sitemap', `Generates <code>${h(S.meta.idxKey)}-sitemap.xml</code> with the <code>/property/…</code> URLs that come from the service. They are synced in the background and cached locally.`, toggle('idx.enabled', { disabled: off })) +
        (idx.enabled ? idxStatus + idxInfo : '') +
        `<details class="idxb-details" ${idx.enabled && !idx.endpoint ? 'open' : ''}><summary>Connection and field mapping</summary>` +
        field('JSON endpoint', 'URL of the service that lists active properties. Use <code>{page}</code> and <code>{per_page}</code>; if missing they are added as query parameters. From code you can also use the <code>idxb_seo_idx_fetch_page</code> filter.', 'idx.endpoint', { wide: true, disabled: ioff, ph: 'https://api.example.com/listings?page={page}&limit={per_page}' }) +
        field('Authentication header', 'Optional, format <code>Name: value</code>.', 'idx.authHeader', { wide: true, disabled: ioff, ph: 'Authorization: Bearer …' }) +
        `<div class="idxb-grid2">` +
        field('List path', 'Where the array is in the JSON (dots for nesting). Empty = the root.', 'idx.itemsPath', { disabled: ioff, ph: 'items' }) +
        field('URL field', 'If the service already returns the detail page URL. Takes priority over the template.', 'idx.urlField', { disabled: ioff, ph: 'url' }) +
        field('Slug field', 'Used in the template as <code>{slug}</code>.', 'idx.slugField', { disabled: ioff, ph: 'slug' }) +
        field('URL template', 'Accepts <code>{slug}</code> or any field, e.g. <code>/property/{address}-{mls_num}</code>.', 'idx.urlTemplate', { disabled: ioff }) +
        field('Modified date field', 'ISO, “Y-m-d H:i:s” or timestamp.', 'idx.modifiedField', { disabled: ioff, ph: 'modified' }) +
        field('Images field', 'Array of URLs (or of objects with <code>url</code>).', 'idx.imagesField', { disabled: ioff, ph: 'images' }) +
        field('Properties per request', '', 'idx.perPage', { type: 'number', min: 1, max: 1000, disabled: ioff }) +
        field('Max pages', 'Safety cap per sync.', 'idx.maxPages', { type: 'number', min: 1, max: 10000, disabled: ioff }) +
        field('Images per property', '', 'idx.maxImages', { type: 'number', min: 0, max: 20, disabled: ioff }) +
        `<div class="idxb-row block"><div class="lbl"><strong>Frequency</strong><small>Automatic sync (WP-Cron).</small></div>
          <select data-bind="idx.schedule" ${ioff ? 'disabled' : ''}>${[['hourly', 'Hourly'], ['twicedaily', 'Twice a day'], ['daily', 'Daily']].map(([v, l]) => `<option value="${v}" ${idx.schedule === v ? 'selected' : ''}>${l}</option>`).join('')}</select></div>` +
        `</div></details>` +
        `<div class="idxb-btn-row"><button class="button" id="idxb-idx-test" ${ioff ? 'disabled' : ''}>Test connection</button>
          <button class="button" id="idxb-idx-sync" ${ioff || dirty() ? 'disabled' : ''} title="${dirty() ? 'Save your changes first' : ''}">Sync now</button></div>` + testOut),
      card('Advanced',
        field('Entries per sitemap', 'Max URLs per file. Above it <code>post-sitemap2.xml</code>, etc. is created. Yoast uses 1,000; the protocol limit is 50,000.', 'sitemap.entriesPerPage', { type: 'number', min: 1, max: 50000, disabled: off }) +
        row('Include images', 'Adds <code>&lt;image:image&gt;</code> (featured image / property photos).', toggle('sitemap.includeImages', { disabled: off })) +
        row('XSL stylesheet', 'The sitemap is shown as a table in the browser.', toggle('sitemap.xsl', { disabled: off })) +
        field('Exclude paths', 'One per line. Exact match; end with <code>*</code> to exclude everything that starts the same (e.g. <code>/test-*</code>). <code>/property/</code> excludes only the template page, not the detail pages.', 'sitemap.excludePaths', { textarea: true, rows: 6, mono: true, disabled: off }) +
        field('Exclude posts by ID', 'Comma-separated IDs.', 'sitemap.excludePostIds', { wide: true, disabled: off, ph: 'e.g. 12, 345' }) +
        field('Exclude terms by ID', 'Category, tag, etc. IDs.', 'sitemap.excludeTermIds', { wide: true, disabled: off, ph: 'e.g. 10, 12' })),
    ].join('');

    let right;
    const pv = S.pv.sitemap;
    if (off) {
      right = card('Preview', notice('err', 'XML sitemaps are off. <code>/sitemap_index.xml</code> will return 404 (or another active plugin will serve it).'));
    } else if (S.pv.sitemapErr) {
      right = card('Preview', notice('err', 'Could not build the preview: ' + h(S.pv.sitemapErr)));
    } else if (!pv || !pv.enabled) {
      right = card('Preview', '<p class="idxb-muted">Generating…</p>');
    } else {
      const isIndex = pv.file === 'sitemap_index.xml';
      const r = pv.summary.reasons || {};
      const reasons = [['manual', 'by ID'], ['noindex', 'noindex'], ['canonical', 'external canonical'], ['path', 'by path']]
        .filter(([k]) => r[k]).map(([k, l]) => `${r[k]} ${l}`).join(' · ');
      const table = isIndex
        ? `<div class="idxb-xsl-head">This index contains ${pv.files.length} sitemaps.</div><div class="idxb-xsl-wrap"><table class="idxb-xsl-table"><thead><tr><th>Sitemap</th><th>Last modified</th></tr></thead><tbody>${pv.files.map((f) => `<tr><td><a href="#" data-file="${h(f.name)}">${h(S.meta.home + f.name)}</a></td><td>${h(fmtDate(f.lastmod))}</td></tr>`).join('')}</tbody></table></div>`
        : `<div class="idxb-xsl-head">This sitemap contains ${fmtNum(pv.entriesTotal)} URLs.</div><div class="idxb-xsl-wrap"><table class="idxb-xsl-table"><thead><tr><th>URL</th><th>Images</th><th>Last modified</th></tr></thead><tbody>${pv.entries.map((e) => `<tr><td>${h(e.loc)}</td><td>${e.images}</td><td>${h(fmtDate(e.lastmod))}</td></tr>`).join('')}${pv.entriesTotal > pv.entries.length ? `<tr><td colspan="3" class="idxb-muted">… ${fmtNum(pv.entriesTotal - pv.entries.length)} more URLs (download the XML to see them all)</td></tr>` : ''}</tbody></table></div>`;
      right = card('Summary', `<div class="idxb-stats">
          <div class="stat"><b>${pv.summary.files}</b><span>sub-sitemaps</span></div>
          <div class="stat"><b>${fmtNum(pv.summary.urls)}</b><span>total URLs</span></div>
          <div class="stat"><b>${fmtNum(pv.summary.perPage)}</b><span>URLs per file</span></div>
          <div class="stat"><b>${fmtNum(pv.summary.excluded)}</b><span>excluded items</span></div>
        </div>${reasons ? `<p class="idxb-muted">Excluded: ${h(reasons)}</p>` : ''}`) +
        `<div class="idxb-card"><h2><span>Generated files</span></h2><div class="body flush"><table class="idxb-files"><thead><tr><th>File</th><th class="num">URLs</th><th>Last modified</th></tr></thead><tbody>
          <tr data-file="sitemap_index.xml" class="${isIndex ? 'sel' : ''}"><td><strong>sitemap_index.xml</strong></td><td class="num">${pv.files.length}</td><td>${pv.files.length ? h(fmtDate(Math.max(...pv.files.map((f) => f.lastmod))).slice(0, 10)) : '—'}</td></tr>
          ${pv.files.map((f) => `<tr data-file="${h(f.name)}" class="${pv.file === f.name ? 'sel' : ''}"><td>${h(f.name)}</td><td class="num">${fmtNum(f.count)}</td><td>${h(fmtDate(f.lastmod).slice(0, 10))}</td></tr>`).join('')}
        </tbody></table></div></div>` +
        card('Preview', `<div class="idxb-urlbar"><span>${h(pv.url)}</span>
            <button class="button button-small" id="idxb-copy-xml">Copy</button><button class="button button-small" id="idxb-dl-xml">Download</button>
            <a class="button button-small" href="${h(pv.url)}" target="_blank" rel="noopener">Open ↗</a></div>
          ${dirty() ? '<p class="idxb-muted">“Open” shows the published version; this preview includes your unsaved changes.</p>' : ''}
          ${S.ui.view === 'xml' ? `<pre class="idxb-code">${highlightXml(pv.xml)}</pre>` : table}`,
          `<span class="idxb-seg" role="group" aria-label="Format"><button data-view="xml" class="${S.ui.view === 'xml' ? 'active' : ''}">XML</button><button data-view="table" class="${S.ui.view === 'table' ? 'active' : ''}">Browser (XSL)</button></span>`);
    }

    return header('IDXBoost Sitemap', 'Site XML sitemaps, including property detail pages from the IDX service.') +
      conflictNotices() +
      `<div class="idxb-layout"><div>${left}</div><div class="idxb-sticky">${right}</div></div>`;
  }

  function conflictNotices() {
    const c = (S.status.conflicts || []).filter((x) => x.level !== 'info');
    return c.map((x) => notice(x.level === 'error' ? 'err' : 'warn', h(x.msg))).join('');
  }

  /* ---------------- Robots screen ---------------- */
  /* Live robots.txt (read by the browser, so it is exactly what visitors and bots get) */
  const MARK = '# Managed by IDXBoost SEO', B0 = '# START IDXBOOST BLOCK', B1 = '# END IDXBOOST BLOCK';
  function cleanImport(t) {
    t = String(t || '').replace(/\r\n?/g, '\n');
    const a = t.indexOf(B0), b = t.indexOf(B1);
    if (a !== -1 && b > a) t = t.slice(0, a) + t.slice(b + B1.length);
    t = t.split('\n').filter((l) => !l.startsWith(MARK) && !/^\s*Sitemap\s*:/i.test(l)).join('\n');
    t = t.replace(/\n{3,}/g, '\n\n').trim();
    return t ? t + '\n' : '';
  }
  async function loadLive() {
    S.live = { loading: true }; render();
    const url = S.meta.home + 'robots.txt'; // same URL bots use (a cache-busting query would hide server/CDN caches)
    try {
      const res = await fetch(url, { cache: 'no-store', credentials: 'omit', redirect: 'follow' });
      const text = await res.text();
      S.live = { code: res.status, text: res.ok ? text : '', ours: res.ok && (text.includes(B0) || text.includes(MARK)) };
    } catch (e) { S.live = { err: e.message }; }
    try { S.sources = await api('/robots/sources'); } catch (e) { S.sources = null; }
    render();
  }
  /* One state for the whole screen: who is publishing /robots.txt right now? */
  function robotsState() {
    const st = S.status.robots || {};
    if (st.file && st.file.foreign) return 'foreign';
    if (st.drift) return 'edited';
    const L = S.live;
    if (!L || L.loading) return 'loading';
    if (L.err) return 'unknown';
    if (L.code === 200) {
      const norm = (t) => String(t || '').replace(/\r/g, '').split('\n').filter((l) => !l.startsWith(MARK)).join('\n').trim();
      if (st.expected && norm(L.text) === norm(st.expected)) return 'ok';
      return L.ours ? 'stale' : 'external';
    }
    return 'none';
  }
  function statusStrip() {
    const st = S.status.robots || {};
    const state = st.state || {};
    const rs = robotsState();
    const link = `<a href="${h(st.url)}" target="_blank" rel="noopener">view /robots.txt ↗</a>`;
    let out = '';
    if (rs === 'loading') out = `<div class="idxb-strip"><span>Checking which robots.txt the site is serving…</span></div>`;
    else if (rs === 'ok') out = `<div class="idxb-strip ok"><span><b>✓ Published by IDXBoost.</b> What you see in “How it will look” is what Google and bots get when you save. ${link}</span></div>`;
    else if (rs === 'foreign') out = `<div class="idxb-strip warn"><span><b>Your site has its own robots.txt</b> (<code>${h(st.file.path)}</code>) and it is respected: its content is already loaded in the editor and the file has not been touched.<small>Publishing updates that same file with the editor content plus the IDXBoost block. An untouched copy of the original is saved first (<code>robots.txt.idxb-original</code>). Turning the plugin off deletes nothing.</small></span><button class="button button-primary" id="idxb-take">Publish to the site robots.txt</button></div>`;
    else if (rs === 'external') out = `<div class="idxb-strip warn"><span><b>The hosting or CDN is serving another robots.txt</b> that does not come from WordPress. Your edits here will not show until that server rule is removed or the CDN cache is purged. Compare it in the “Live now” tab. ${link}</span><button class="button" id="idxb-live-reload">Check again</button></div>`;
    else if (rs === 'edited') out = `<div class="idxb-strip warn"><span><b>robots.txt was edited directly on the server.</b> Those changes are live but not in this editor: if you save without pulling them in, they are replaced (a copy <code>robots.txt.idxb-edited-DATE</code> is kept). Compare it in the “Live now” tab.</span><span class="idxb-btns"><button class="button button-primary" id="idxb-pull">Pull changes into the editor</button><button class="button" id="idxb-republish">Discard them</button></span></div>`;
    else if (rs === 'stale') out = `<div class="idxb-strip warn"><span><b>The site still shows an older robots.txt.</b> It was generated by this plugin but does not match what you saved. Usually it is a server, CDN (or browser) cache. Click “Publish again”; if nothing changes, purge the hosting/CDN cache. Compare it in the “Live now” tab. ${link}</span><button class="button button-primary" id="idxb-republish">Publish again</button></div>`;
    else if (rs === 'none') out = `<div class="idxb-strip"><span><b>The site has no robots.txt.</b> Saving publishes the one in this editor.</span></div>`;
    else out = `<div class="idxb-strip"><span>Could not check what the site is serving (${h(S.live.err)}). ${link}</span><button class="button" id="idxb-live-reload">Check again</button></div>`;
    if (state.error && rs !== 'foreign') out += notice('err', h(state.error));
    if (S.ui.importMsg) out += notice(S.ui.importMsg.ok ? 'ok' : 'err', h(S.ui.importMsg.msg));
    return out;
  }
  /** Best "other" robots.txt to re-read into the editor: server file → live external → other plugins. */
  function siteSource() {
    const src = S.sources || {};
    if (src.file && (src.fileManaged === false || (S.status.robots || {}).drift)) return src.fileImport || cleanImport(src.file);
    if (S.live && S.live.code === 200 && !S.live.ours) return cleanImport(S.live.text);
    const others = cleanImport(src.others);
    return others.trim().split('\n').length > 3 ? others : '';
  }

  function seedNotice() {
    const sd = S.status.robots && S.status.robots.seed;
    if (!sd || !sd.source || sd.source === 'kept') return '';
    const txt = {
      file: `Initial content read from the server robots.txt${sd.path ? ` (<code>${h(sd.path)}</code>)` : ''}.`,
      live: 'Initial content read from the robots.txt the site was serving.',
      plugins: 'Initial content taken from the rules WordPress and other plugins (Yoast, Rank Math…) were generating.',
      default: 'The site had no robots.txt: a default one was generated.',
    }[sd.source];
    return txt ? notice(sd.source === 'default' ? 'info' : 'ok', txt + ' ' + h(ago(sd.at))) : '';
  }

  function robotsPreviewBody(pv) {
    if (S.ui.rbView === 'live') {
      const L = S.live;
      const body = !L || L.loading ? '<p class="idxb-muted">Reading…</p>'
        : L.err ? notice('err', 'Could not read it: ' + h(L.err))
        : L.code !== 200 ? notice('warn', `The site returns HTTP ${h(L.code)}: it serves no robots.txt.`)
        : `<pre class="idxb-code lines">${highlightRobots(L.text)}</pre>`;
      return `<div class="idxb-urlbar"><span>${h(S.meta.home)}robots.txt — what bots get today</span><button class="button button-small" id="idxb-live-reload">Reload</button></div>` + body;
    }
    return `<div class="idxb-urlbar"><span>${h(S.meta.home)}robots.txt — with this editor settings</span>
      <button class="button button-small" id="idxb-copy-robots">Copy</button><button class="button button-small" id="idxb-dl-robots">Download</button></div>
      <pre class="idxb-code lines">${highlightRobots(pv.text)}</pre>`;
  }

  function renderRobots() {
    const r = S.draft.robots;
    const sitemapOn = S.draft.sitemap.enabled;
    const pv = S.pv.robots;

    const aiRows = S.meta.aiBots.map((b) => {
      const v = (r.ai || {})[b.ua] || 'default';
      const seg = [['default', 'No rule'], ['allow', 'Allow'], ['block', 'Block']]
        .map(([k, l]) => `<button data-ai="${h(b.ua)}" data-state="${k}" class="${v === k ? 'active ' + k : ''}">${l}</button>`).join('');
      return row(h(b.label), `${h(b.note)} · <code>User-agent: ${h(b.ua)}</code>`, `<span class="idxb-seg">${seg}</span>`);
    }).join('');

    const left = [
      card('robots.txt editor',
        seedNotice() + `<p class="idxb-muted mt0">Your own rules. They go <strong>before</strong> the block managed by IDXBoost.</p>
        <textarea class="mono big" data-bind="robots.customContent" spellcheck="false" aria-label="robots.txt content">${h(r.customContent)}</textarea>
        <div class="idxb-btn-row"><button class="button button-small" id="idxb-reread">Re-read from the site</button><button class="button button-small" id="idxb-robots-default">Restore default rules</button></div>`),
      card('Crawl optimization',
        row('Block WordPress internal search', 'Adds <code>Disallow: /?s=</code> and <code>/*?s=</code>.', toggle('robots.denySearch')) +
        row('Block IDX search parameters', 'Blocks search variations by parameter (<code>/*?keyword=</code>, <code>/*&amp;keyword=</code>…). Check which URLs the search generates before turning it on.', toggle('robots.denyIdxParams')) +
        (r.denyIdxParams ? field('Parameters to block', 'One per line.', 'robots.idxParams', { textarea: true, rows: 3, mono: true }) : '') +
        row('Block the REST API', 'Adds <code>Disallow: /wp-json/</code> and <code>/?rest_route=</code>.', toggle('robots.denyWpJson')) +
        row('Block Google AdsBot', '<code>User-agent: AdsBot-Google</code> + <code>Disallow: /</code>. AdsBot ignores the <code>*</code> group. Only if you do not use Google Ads.', toggle('robots.denyAdsBot')) +
        ((S.status.robots || {}).blogPublic === false ? row('Block everything while “Discourage” is on', `“Discourage search engines” is on in <a href="${h(CFG.urls.reading)}">Settings &gt; Reading</a> (WordPress already marks pages as noindex). Turn this on to publish only <code>Disallow: /</code> and ignore the editor, useful on staging.`, toggle('robots.respectDiscourage')) : '')),
      card('AI bots', `<p class="idxb-muted mt0"><b>Allow</b> creates a group for these bots that repeats your <code>User-agent: *</code> restrictions (a named group does not inherit them). <b>Block</b> adds <code>Disallow: /</code>. <b>No rule</b> writes nothing and the bot follows the <code>*</code> group.</p>` + aiRows),
      card('Sitemap', row('Include Sitemap line', sitemapOn ? `Adds <code>Sitemap: ${h(S.meta.home)}sitemap_index.xml</code> with the site current domain.` : `XML sitemaps are off in <a href="${h(CFG.urls.sitemap)}">Sitemap</a>.`, toggle('robots.includeSitemap', { disabled: !sitemapOn }))),
    ].join('');

    let right;
    if (S.pv.robotsErr) right = notice('err', 'Could not build the preview: ' + h(S.pv.robotsErr));
    else if (!pv) right = card('Preview', '<p class="idxb-muted">Generating…</p>');
    else {
      const w = pv.warnings || [];
      const lvl = w.some((x) => x.level === 'error') ? 'err' : w.some((x) => x.level === 'warn') ? 'warn' : 'info';
      const t = pv.test;
      right = (w.length ? `<div class="idxb-notice ${lvl} mt0"><ul class="idxb-list">${w.map((x) => `<li class="${x.level}">${h(x.msg)}</li>`).join('')}</ul></div>` : notice('ok', 'No issues found.')) +
        card('Preview', robotsPreviewBody(pv),
          `<span class="idxb-seg" role="group" aria-label="View"><button data-rbview="next" class="${S.ui.rbView !== 'live' ? 'active' : ''}">How it will look</button><button data-rbview="live" class="${S.ui.rbView === 'live' ? 'active' : ''}">Live now</button></span>`) +
        card('Test a URL', `<div class="idxb-tester">
            <input type="text" id="idxb-t-path" value="${h(S.ui.tester.path)}" placeholder="/path/?query" aria-label="Path to test">
            <select id="idxb-t-ua" aria-label="User agent">${['Googlebot', 'Bingbot', 'AdsBot-Google', 'GPTBot', 'OAI-SearchBot', 'ClaudeBot', 'PerplexityBot', 'Google-Extended', 'CCBot'].map((u) => `<option ${u === S.ui.tester.ua ? 'selected' : ''}>${u}</option>`).join('')}</select>
          </div>
          <p class="idxb-muted">e.g. ${['/?s=condos', '/wp-admin/', '/wp-login.php', '/property/', '/search?keyword=brickell'].map((p) => `<a href="#" data-path="${h(p)}">${h(p)}</a>`).join(' · ')}</p>
          <div class="idxb-verdict ${t.allowed ? 'allow' : 'block'}">${t.allowed ? '✓ Allowed' : '✕ Blocked'} for ${h(S.ui.tester.ua)}
            <small>Group applied: <code>User-agent: ${h(t.group)}</code> · ${t.rule ? `Winning rule: <code>${h(t.rule)}</code>` : 'No rule matches'}${t.note ? ' · ' + h(t.note) : ''}</small></div>`);
    }

    return header('IDXBoost Robots', 'Edit the site robots.txt. The plugin serves it even if the server does not pass it to WordPress.') +
      statusStrip() + `<div class="idxb-layout"><div>${left}</div><div class="idxb-sticky">${right}</div></div>`;
  }

  /* ---------------- Tools screen ---------------- */
  function deliveryAdvanced() {
    const st = S.status.robots || {};
    const state = st.state || {};
    const eff = { virtual: 'WordPress generates it on the fly.', file: `the plugin writes the file <code>${h((st.file || {}).path)}</code>.`, foreign: 'the site has its own robots.txt, not yet published from the plugin (go to Robots).', error: 'could not be applied.' }[state.effective] || 'not checked yet.';
    return row('How robots.txt is published',
      'If the site already has a <code>robots.txt</code> file, that file is always updated (never deleted). If it has none: <b>Automatic</b> (recommended) lets WordPress generate it and creates the file only if the server does not pass /robots.txt to WordPress; <b>WordPress only</b> never creates files; <b>Always file</b> always creates it.',
      `<select data-bind="robots.mode">${[['auto', 'Automatic'], ['virtual', 'WordPress only'], ['file', 'Always file']].map(([v, l]) => `<option value="${v}" ${S.draft.robots.mode === v ? 'selected' : ''}>${l}</option>`).join('')}</select>`) +
      `<p class="idxb-muted">Right now: ${eff} ${state.checked ? '(checked ' + h(ago(state.checked)) + ')' : ''}</p>`;
  }

  function renderTools() {
    const p = S.ui.probe;
    const conflicts = S.status.conflicts || [];
    const probeOut = !p ? '<p class="idxb-muted">Sends a request to your own site to check that <code>/robots.txt</code> and <code>/sitemap_index.xml</code> are served by this plugin.</p>'
      : (p.loading ? '<p class="idxb-muted">Checking…</p>' :
        notice(p.robots && ['virtual', 'file'].includes(p.robots.effective) ? 'ok' : 'err', `robots.txt: ${h({ virtual: 'served by WordPress (virtual)', file: 'served as a managed physical file', foreign: 'served by the site own file', error: 'error applying it' }[p.robots.effective] || p.robots.effective)}${p.robots.error ? ' — ' + h(p.robots.error) : ''}`) +
        (p.sitemap ? notice(p.sitemap.ok ? 'ok' : 'err', 'sitemap_index.xml: ' + h(p.sitemap.msg)) : ''));

    const left = [
      card('Diagnostics', probeOut + `<div class="idxb-btn-row"><button class="button" id="idxb-probe">Check now</button></div>`),
      card('Compatibility', conflicts.length ? conflicts.map((c) => notice(c.level === 'error' ? 'err' : c.level === 'warn' ? 'warn' : 'info', h(c.msg))).join('') : notice('ok', 'No other SEO plugins or interfering files found.')),
      card('Advanced: robots.txt delivery', deliveryAdvanced()),
      (CFG.moduleOff ? card('IDXBoost SEO module', `<p class="idxb-muted mt0">Turning it off hands sitemaps back to WordPress or other plugins. robots.txt stays exactly as published (not deleted) and settings are kept.</p>${CFG.moduleOff}`) : ''),
      card('Cache', `<p class="idxb-muted mt0">Sitemaps are cached and rebuilt automatically when content is published, edited or deleted. Use this if you changed something directly in the database.</p>
        <div class="idxb-btn-row"><button class="button" id="idxb-flush">Clear cache and rebuild rules</button></div>`),
    ].join('');
    const right = [
      card('Settings (JSON)', `<p class="idxb-muted mt0">Export the settings to copy them to another IDXBoost site (<code>schemaVersion: ${h(S.draft.schemaVersion)}</code>). Importing loads the JSON as unsaved changes.</p>
        <div class="idxb-btn-row">
          <button class="button button-primary" id="idxb-export">Export JSON</button>
          <label class="button">Import JSON<input type="file" id="idxb-import-json" accept="application/json,.json" hidden></label>
          <button class="button idxb-danger" id="idxb-reset">Reset to defaults</button>
        </div>`),
      card('Current JSON', `<pre class="idxb-code">${h(JSON.stringify(Object.assign({}, S.draft, { idx: Object.assign({}, S.draft.idx, { authHeader: S.draft.idx.authHeader ? '••••' : '' }) }), null, 2))}</pre>`),
    ].join('');
    return header('IDXBoost SEO — Tools', 'Diagnostics, compatibility, cache and settings export/import.') +
      `<div class="idxb-layout"><div>${left}</div><div>${right}</div></div>`;
  }

  /* ---------------- render ---------------- */
  function render() {
    const active = document.activeElement;
    const bind = active && active.dataset ? (active.dataset.bind || (active.id && active.id.startsWith('idxb-t-') ? '#' + active.id : '')) : '';
    const caret = bind && 'selectionStart' in active ? [active.selectionStart, active.selectionEnd] : null;
    const scrolls = [...app.querySelectorAll('pre, .idxb-xsl-wrap, textarea')].map((e) => e.scrollTop);

    app.innerHTML = S.route === 'robots' ? renderRobots() : S.route === 'tools' ? renderTools() : renderSitemap();

    [...app.querySelectorAll('pre, .idxb-xsl-wrap, textarea')].forEach((e, i) => { if (scrolls[i] != null) e.scrollTop = scrolls[i]; });
    if (bind) {
      const el = bind.startsWith('#') ? app.querySelector(bind) : app.querySelector(`[data-bind="${bind}"]`);
      if (el) { el.focus(); if (caret && el.setSelectionRange) { try { el.setSelectionRange(caret[0], caret[1]); } catch (e) { /* number inputs */ } } }
    }
  }

  /* ---------------- events ---------------- */
  app.addEventListener('change', (e) => {
    const t = e.target;
    const b = t.dataset && t.dataset.bind;
    if (b && t.type === 'checkbox') return set(b, t.checked);
    if (b && t.type === 'number') {
      let n = parseInt(t.value, 10);
      const min = parseInt(t.min || '0', 10), max = parseInt(t.max || '99999', 10);
      if (!Number.isFinite(n)) n = min; n = Math.max(min, Math.min(max, n));
      return set(b, n);
    }
    if (b && t.tagName === 'SELECT') return set(b, t.value);
    if (t.id === 'idxb-t-ua') { S.ui.tester.ua = t.value; loadRobots(0); }
    if (t.id === 'idxb-import-json') {
      const f = t.files[0]; if (!f) return;
      f.text().then((txt) => {
        try {
          const d = JSON.parse(txt);
          if (typeof d !== 'object' || !d.sitemap || !d.robots) throw new Error();
          const def = clone(S.meta.defaults);
          S.draft = fixMaps(Object.assign(def, d, { sitemap: Object.assign(def.sitemap, d.sitemap), robots: Object.assign(def.robots, d.robots), idx: Object.assign(def.idx, d.idx || {}) }));
          render(); toast('JSON loaded: review and save the changes');
        } catch (err) { toast('The file is not a valid settings JSON', true); }
      });
    }
  });

  app.addEventListener('input', (e) => {
    const t = e.target;
    const b = t.dataset && t.dataset.bind;
    if (b && (t.type === 'text' || t.type === 'url' || t.tagName === 'TEXTAREA')) {
      // Update draft without re-rendering on every keystroke; preview refresh re-renders.
      const keys = b.split('.'); let o = S.draft;
      while (keys.length > 1) { const k = keys.shift(); if (o[k] == null || typeof o[k] !== 'object') o[k] = {}; o = o[k]; }
      o[keys[0]] = t.value;
      updateSavebar(); refreshPreview(500);
    }
    if (t.id === 'idxb-t-path') { S.ui.tester.path = t.value; loadRobots(250); }
  });

  function updateSavebar() {
    const bar = app.querySelector('.idxb-savebar');
    if (!bar) return;
    const d = dirty();
    bar.classList.toggle('dirty', d);
    const btn = bar.querySelector('#idxb-save'); if (btn) btn.disabled = !d || S.saving;
    bar.classList.toggle('blocked', !d && notPublished());
    const span = bar.querySelector('span');
    if (span) span.textContent = savebarText();
    if (d && !bar.querySelector('#idxb-discard')) {
      const x = document.createElement('button'); x.className = 'button'; x.id = 'idxb-discard'; x.textContent = 'Discard';
      bar.querySelector('.idxb-btns').prepend(x);
    }
  }

  app.addEventListener('click', async (e) => {
    const t = e.target;
    const fileEl = t.closest('[data-file]');
    if (fileEl) { e.preventDefault(); S.ui.file = fileEl.dataset.file; return loadSitemap(0); }
    const viewEl = t.closest('[data-view]');
    if (viewEl) { S.ui.view = viewEl.dataset.view; return render(); }
    const pathEl = t.closest('[data-path]');
    if (pathEl) { e.preventDefault(); S.ui.tester.path = pathEl.dataset.path; render(); return loadRobots(0); }
    const aiEl = t.closest('[data-ai]');
    if (aiEl) { S.draft.robots.ai = S.draft.robots.ai || {}; return set('robots.ai.' + aiEl.dataset.ai, aiEl.dataset.state); }

    const id = t.id;
    if (id === 'idxb-save') return save();
    if (id === 'idxb-discard') { S.draft = fixMaps(JSON.parse(S.saved)); render(); return refreshPreview(0); }
    if (id === 'idxb-copy-xml' && S.pv.sitemap) return copy(S.pv.sitemap.xml);
    if (id === 'idxb-dl-xml' && S.pv.sitemap) return download(S.pv.sitemap.file, S.pv.sitemap.xml, 'application/xml');
    if (id === 'idxb-copy-robots' && S.pv.robots) return copy(S.pv.robots.text);
    if (id === 'idxb-dl-robots' && S.pv.robots) return download('robots.txt', S.pv.robots.text, 'text/plain');
    if (id === 'idxb-live-reload') return loadLive();
    if (id === 'idxb-republish') {
      t.disabled = true; t.textContent = 'Publishing…';
      try { const d = await api('/status/probe', 'POST'); S.status = d.status; } catch (err) { toast(err.message, true); }
      return loadLive();
    }
    const rbv = t.closest('[data-rbview]');
    if (rbv) { S.ui.rbView = rbv.dataset.rbview; return render(); }
    if (id === 'idxb-pull') {
      const txt = (S.sources && S.sources.fileImport) || '';
      if (!txt) return toast('Could not read the server file.', true);
      set('robots.customContent', txt);
      return toast('Server changes loaded. Check the preview and save so the plugin manages them.');
    }
    if (id === 'idxb-reread') {
      const txt = siteSource();
      if (!txt) return toast('The site has no other robots.txt besides this plugin one.');
      if (cleanImport(S.draft.robots.customContent) === txt) return toast('The editor already has that content.');
      if (!window.confirm('This replaces the editor content with the robots.txt the site has. Continue?')) return;
      set('robots.customContent', txt);
      return toast('Loaded. Check the preview and save the changes.');
    }
    if (id === 'idxb-robots-default') return set('robots.customContent', S.meta.defaults.robots.customContent);
    if (id === 'idxb-export') return download('idxboost-seo-settings.json', JSON.stringify(Object.assign({}, S.draft, { idx: Object.assign({}, S.draft.idx, { authHeader: '' }) }), null, 2), 'application/json');
    if (id === 'idxb-reset') {
      if (!window.confirm('Reset all Sitemap and Robots settings to defaults? It applies immediately.')) return;
      try { const d = await api('/settings/reset', 'POST'); S.draft = fixMaps(d.settings); S.saved = JSON.stringify(S.draft); S.status = d.status; render(); toast('Defaults restored'); } catch (err) { toast(err.message, true); }
      return;
    }
    if (id === 'idxb-take') {
      if (dirty()) { S.saving = true; try { const d0 = await api('/settings', 'POST', { settings: S.draft }); S.draft = fixMaps(d0.settings); S.saved = JSON.stringify(S.draft); } catch (e0) { S.saving = false; return toast(e0.message, true); } S.saving = false; }
      try {
        const d = await api('/robots/take-control', 'POST');
        S.ui.importMsg = { ok: d.ok, msg: d.msg };
        S.status = d.status; render(); loadLive(); loadRobots(0);
      } catch (err) { toast(err.message, true); }
      return;
    }
    if (id === 'idxb-idx-test') {
      t.disabled = true; t.textContent = 'Testing…';
      try { S.ui.idxTest = await api('/idx/test', 'POST', { settings: S.draft }); } catch (err) { S.ui.idxTest = { ok: false, msg: err.message }; }
      return render();
    }
    if (id === 'idxb-idx-sync') {
      t.disabled = true; t.textContent = 'Syncing…';
      try { S.status.idx = await api('/idx/sync', 'POST'); toast('Sync started'); pollIdx(); } catch (err) { toast(err.message, true); }
      render(); return loadSitemap(0);
    }
    if (id === 'idxb-probe') {
      S.ui.probe = { loading: true }; render();
      try { const d = await api('/status/probe', 'POST'); S.ui.probe = d; S.status = d.status; } catch (err) { S.ui.probe = null; toast(err.message, true); }
      return render();
    }
    if (id === 'idxb-flush') {
      try { await api('/tools/flush', 'POST'); toast('Cache cleared and rules rebuilt'); } catch (err) { toast(err.message, true); }
    }
  });

  let pollT = null;
  function pollIdx() {
    clearTimeout(pollT);
    pollT = setTimeout(async () => {
      try {
        S.status.idx = await api('/idx/status');
        if (S.status.idx.status === 'running') pollIdx(); else { toast(S.status.idx.status === 'error' ? 'Sync failed' : 'Sync finished', S.status.idx.status === 'error'); loadSitemap(0); }
        render();
      } catch (e) { /* ignore */ }
    }, 4000);
  }

  render();
  refreshPreview(0);
  if (S.route === 'robots') loadLive();
  if (S.status.idx && S.status.idx.status === 'running') pollIdx();
})();
