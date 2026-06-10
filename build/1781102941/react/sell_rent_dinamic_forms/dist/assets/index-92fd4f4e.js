import {
  r as e,
  z as t,
  u as n,
  a as o,
  b as r,
  c as a,
  R as s,
  F as l,
  d as i,
  C as c,
  e as m,
  f as d,
  A as u,
  g as _,
  h as p,
  i as f,
} from './vendor-484c7feb.js';
import { U as g } from './phone-input-e0238ad8.js';
const y = '_form-wizard_outyw_2',
  h = {
    user: {},
    api: { idxboost: window.__flex_g_settings?.domain_service || 'https://api.idxboost.dev' },
    apiKey: { googleMaps: 'AIzaSyBU6VY2oHfII-RPAcZZu9qq843bpE3pLNo' },
    form: {
      type: window.idx_buy_sell_rent_forms?.form_type || 'sell',
      accessToken:
        window.idx_buy_sell_rent_forms?.access_token ||
        'YjJjYTFhMmJkYTAwYjE5NTNlZTY5NmRmOGI3ZmQyZDlkYWY3Nzg2MjIzOTkxNmY3NmQ2ODRkMmFlZDRjMjJjOA',
      leadToken: window.idx_buy_sell_rent_forms?.lead_token || '',
      firstName: window.idx_buy_sell_rent_forms?.lead.name || '',
      lastName: window.idx_buy_sell_rent_forms?.lead.lastname || '',
      email: window.idx_buy_sell_rent_forms?.lead.email || '',
      phone: window.idx_buy_sell_rent_forms?.lead.new_phone || '',
      phoneNumberRequired:
        '1' == window.idx_main_settings?.agent_info?.phone_number_required ||
        !0 === window.idx_main_settings?.agent_info?.phone_number_required,
      showOptInMessage: window.idx_main_settings?.agent_info?.show_opt_in_message ?? !1,
      disclaimerFub: window.idx_main_settings?.agent_info?.disclaimer_fub ?? '',
      disclaimerChecked: window.idx_main_settings?.agent_info?.disclaimer_checked ?? '0',
    },
  };
var w = Object.defineProperty;
class b {
  constructor() {
    var e, t, n;
    (e = this),
      (t = 'baseUrl'),
      (n = `${h.api.idxboost}/idxforms`),
      ((e, t, n) => {
        t in e ? w(e, t, { enumerable: !0, configurable: !0, writable: !0, value: n }) : (e[t] = n);
      })(e, 'symbol' != typeof t ? t + '' : t, n);
  }
  buildQuery(e) {
    const t = new URLSearchParams();
    return (
      Object.entries(e).forEach(([e, n]) => {
        null != n && t.append(e, String(n));
      }),
      t.toString()
    );
  }
  async getById({ id: e }) {
    const t = await fetch(`${this.baseUrl}/${e}`);
    if (!t.ok) throw new Error('Error fetching idxform by ID');
    return t.json();
  }
  async getBySlug({ slug: e, accessToken: t }) {
    const n = new FormData();
    n.append('access_token', t);
    const o = await fetch(`${this.baseUrl}/slug-rk/${e}`, { method: 'POST', body: n });
    if (!o.ok) throw new Error('Error fetching idxform by slug');
    return o.json();
  }
  async getIpLead() {
    try {
      const e = await fetch(`${h.api.idxboost}/get/ip_lead`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({}),
      });
      if (!e.ok) throw new Error(`Error fetching IP lead: ${e.status}`);
      return e.json();
    } catch (e) {
      return console.error('Error fetching IP lead:', e), null;
    }
  }
  async getAnonToken({
    client_ip: e,
    origin: t,
    referer: n,
    agent: o,
    registration_key: r,
    form_type: a,
    form_title: s,
    form_address: l,
  }) {
    if (!e) {
      const t = await this.getIpLead();
      e = t?.ip || '';
    }
    const i = new FormData();
    i.append('client_ip', e ?? ''),
      i.append('origin', t),
      i.append('referer', n),
      i.append('agent', o),
      i.append('registration_key', r),
      i.append('form_data', JSON.stringify({ form_type: a, form_title: s, form_address: l }));
    const c = await fetch(`${this.baseUrl}/anon`, { method: 'POST', body: i });
    if (!c.ok) {
      const e = await c.text();
      throw new Error(`Error fetching anon token: ${e}`);
    }
    return c.json();
  }
  async sendIdxForm({
    client_ip: e,
    origin: t,
    referer: n,
    agent: o,
    access_token: r,
    lead_token: a,
    form_data: s,
    autologinForms: l,
    anonToken: i,
  }) {
    if (!e) {
      const t = await this.getIpLead();
      (e = t?.ip || ''), (s.country_code = t?.country || '');
    }
    const c = {
        client_ip: e,
        origin: t,
        referer: n,
        agent: o,
        access_token: r,
        lead_token: a,
        form_data: JSON.stringify(s),
        autologinForms: l,
        anonToken: i,
      },
      m = new FormData();
    Object.entries(c).forEach(([e, t]) => {
      m.append(e, String(t));
    });
    const d = await fetch(`${this.baseUrl}/handle`, { method: 'POST', body: m });
    if (!d.ok) {
      const e = await d.text();
      throw new Error(`Error sending idxform: ${e}`);
    }
    const u = await d.json();
    return (
      u.hasOwnProperty('success') &&
        u.success &&
        u.hasOwnProperty('logged_lead') &&
        u.logged_lead?.hasOwnProperty('encode_token') &&
        '' != u.logged_lead.encode_token &&
        window.idx_setSessionForced?.(u.logged_lead.lead_info, u.logged_lead.encode_token || ''),
      u
    );
  }
}
var E = (e => (
    (e.SelectSingle = 'select_single'),
    (e.MultiSelect = 'multi_select'),
    (e.Contact = 'contact'),
    (e.Text = 'text'),
    (e.Address = 'address'),
    (e.Beds = 'beds'),
    (e.Baths = 'baths'),
    (e.Price = 'price'),
    (e.PropertyType = 'property_type'),
    e
  ))(E || {}),
  k = (e => ((e.Buy = 'buy'), (e.Sell = 'sell'), (e.Rent = 'rent'), e))(k || {});
function v({ title: e, type: t, showConfirmButton: n = !1, text: o, timer: r, button: a }) {
  return new Promise(s => {
    const l = {
        title: e,
        text: o,
        icon: t,
        ...(void 0 !== r && { timer: r }),
        button: a ?? (!!n && 'OK'),
      },
      i = swal(l);
    i && 'function' == typeof i.then
      ? i.then(() => s(!0)).catch(() => s(!0))
      : swal(l, () => s(!0));
  });
}
const x = t.object({
    first_name: t.string().min(1, 'First name is required'),
    last_name: t.string().min(1, 'Last name is required'),
    email: t.string().min(1, 'Email is required').email('Invalid email'),
    phone: h.form.phoneNumberRequired
      ? t
          .string()
          .min(1, 'Phone is required')
          .regex(/^\+\d{7,15}$/, 'Invalid phone number')
      : t
          .string()
          .optional()
          .refine(e => !e || /^\+\d{7,15}$/.test(e), 'Invalid phone number'),
    comments: t.string().optional(),
    ib_tags: t.string().optional(),
    questions: t.array(
      t
        .object({
          question: t.string(),
          questionType: t.enum([
            'address',
            'select_single',
            'multi_select',
            'text',
            'contact',
            'beds',
            'baths',
            'price',
            'property_type',
          ]),
          answer: t.string().optional(),
          options: t
            .array(t.union([t.string(), t.object({ label: t.string(), value: t.string() })]))
            .optional()
            .default([]),
          placeholder: t.string().optional(),
          subtitle: t.string().optional(),
          lat: t.number().optional(),
          lng: t.number().optional(),
        })
        .refine(
          e => 'contact' === e.questionType || (null != e.answer && e.answer.trim().length > 0),
          { message: 'This field is required', path: ['answer'] }
        )
    ),
  }),
  C = ({ mode: t = 'fullpage', formSlug: i, onClose: c, preview: m = !1, formData: d } = {}) => {
    const u = e.useMemo(() => new b(), []),
      [_, p] = e.useState(null),
      [f, g] = e.useState('us'),
      w = i || h.form.type,
      { accessToken: C, leadToken: N, firstName: q, lastName: S, email: T, phone: O } = h.form,
      I = n({ resolver: o(x), defaultValues: { questions: [] } }),
      {
        handleSubmit: j,
        control: B,
        reset: F,
        trigger: z,
        getValues: R,
        register: Y,
        formState: { errors: J },
      } = I,
      { fields: W } = r({ control: B, name: 'questions' }),
      [V, K] = e.useState(0),
      [Q, H] = e.useState(null),
      X = W[V],
      G = V === (W?.length && W.length - 1),
      ee = 0 === V,
      te = 'modal' === t,
      ne = 'section' === t,
      oe = _?.background_image,
      re = te
        ? `${y} _form-wizard--modal_outyw_136`
        : ne
        ? `${y} _form-wizard--section_outyw_105`
        : y,
      ae = a({ control: B, name: `questions.${V}.answer` });
    return (
      e.useEffect(() => {
        d
          ? p(d)
          : w &&
            u
              .getBySlug({ slug: w, accessToken: C })
              .then(e => p(e))
              .catch(e => console.error('Error loading form:', e));
      }, [w, C, d]),
      e.useEffect(() => {
        m ||
          u
            .getIpLead()
            .then(e => {
              e?.country && g(e.country.toLowerCase());
            })
            .catch(e => console.error('Error fetching IP lead:', e));
      }, [m]),
      e.useEffect(() => {
        _?.steps &&
          F({
            questions: _.steps.map(e => ({ ...e, answer: '', lat: void 0, lng: void 0 })),
            first_name: q ?? '',
            last_name: S ?? '',
            email: T ?? '',
            phone: O ?? '',
            comments: '',
            ib_tags: _.name ?? '',
          });
      }, [_?.steps]),
      _ && X
        ? s.createElement(
            l,
            { ...I },
            s.createElement(
              'form',
              { className: re, onSubmit: e => e.preventDefault() },
              s.createElement('input', { type: 'hidden', ...Y('ib_tags') }),
              !te &&
                s.createElement('div', {
                  className: ne
                    ? '_form-background--section_outyw_111'
                    : '_form-background_outyw_9',
                  style: { backgroundImage: `url(${oe})` },
                }),
              s.createElement(
                'div',
                { className: '_form-content_outyw_33' },
                s.createElement(
                  'div',
                  { className: '_step-container_outyw_42' },
                  s.createElement(
                    'div',
                    { className: '_back-button-container_outyw_81' },
                    !ee && s.createElement(Z, { onClick: () => K(e => e - 1), iconOnly: te })
                  ),
                  ' ',
                  s.createElement(
                    'div',
                    { className: '_step-content_outyw_51' },
                    s.createElement(
                      'div',
                      { className: '_step-header_outyw_67' },
                      s.createElement(A, { question: X.question, subtitle: X.subtitle })
                    ),
                    (X.questionType === E.SelectSingle ||
                      X.questionType === E.Beds ||
                      X.questionType === E.Baths ||
                      X.questionType === E.Price ||
                      X.questionType === E.PropertyType) &&
                      s.createElement(D, {
                        name: `questions.${V}.answer`,
                        options: X.options ?? [],
                        compact: X.questionType === E.Beds || X.questionType === E.Baths,
                      }),
                    X.questionType === E.Address &&
                      s.createElement(U, { name: `questions.${V}.answer` }),
                    X.questionType === E.Text &&
                      s.createElement($, {
                        name: `questions.${V}.answer`,
                        placeholder: X.placeholder,
                      }),
                    X.questionType === E.MultiSelect &&
                      s.createElement(L, {
                        name: `questions.${V}.answer`,
                        options: X.options ?? [],
                      }),
                    X.questionType === E.Contact && s.createElement(P, { defaultCountry: f }),
                    s.createElement(
                      'div',
                      { className: '_navigation-buttons_outyw_73' },
                      m && G
                        ? s.createElement(M, { disabled: !0 }, 'Submit')
                        : s.createElement(
                            M,
                            {
                              disabled: !(m || G || (ae && '' !== ae.trim())),
                              onClick: G
                                ? j(
                                    async e => {
                                      const t = e.questions.filter(
                                          e => e.questionType !== E.Contact
                                        ),
                                        n = {
                                          formType: w,
                                          steps: t.map(e => ({
                                            question: e.question,
                                            answer: e.answer,
                                            ...(e.questionType === E.Address && e.lat && e.lng
                                              ? { lat: e.lat, lng: e.lng }
                                              : {}),
                                          })),
                                          contact: {
                                            name: `${e.first_name} ${e.last_name}`,
                                            email: e.email,
                                            phone: e.phone,
                                            comments: e.comments,
                                          },
                                        };
                                      H(n),
                                        (e.steps = e.questions
                                          .filter(e => 'contact' !== e.questionType)
                                          .map(e => ({ question: e.question, answer: e.answer }))),
                                        delete e.questions,
                                        (e.name = `${e.first_name} ${e.last_name}`),
                                        delete e.first_name,
                                        delete e.last_name,
                                        (e.form_type = _?.form_type || w);
                                      try {
                                        const n = await u.sendIdxForm({
                                          agent: window.navigator.userAgent,
                                          form_data: e,
                                          origin: window.origin,
                                          referer: document.referrer,
                                          access_token: C,
                                          lead_token: N,
                                          autologinForms: !1,
                                          anonToken:
                                            localStorage.getItem('idx_anon_token') ?? void 0,
                                        });
                                        if (n.success) {
                                          const e = '1' === _?.redirect_on_submit,
                                            n = _?.redirect_url ?? '/search';
                                          if (
                                            (F(),
                                            K(0),
                                            te && c && c(),
                                            await v({
                                              title: 'Thank You!',
                                              text:
                                                _?.redirect_message ??
                                                "Your information has been submitted successfully. We'll be in touch with you shortly.",
                                              type: 'success',
                                              showConfirmButton: !0,
                                            }),
                                            !te && e)
                                          ) {
                                            const e = ((e, t) => {
                                              const n = new URLSearchParams();
                                              return (
                                                t &&
                                                  ('buy' === t
                                                    ? n.set('for', 'sale')
                                                    : 'sell' === t
                                                    ? (n.set('for', 'sold'),
                                                      n.set('lookup_previous_sold', 'month-6'))
                                                    : n.set('for', t)),
                                                e.forEach(e => {
                                                  switch (e.questionType) {
                                                    case E.Beds:
                                                      n.set(
                                                        'beds',
                                                        e.answer
                                                          .replace(/_/g, '-')
                                                          .replace(/-$/, '')
                                                      );
                                                      break;
                                                    case E.Baths:
                                                      n.set(
                                                        'baths',
                                                        e.answer
                                                          .replace(/_/g, '-')
                                                          .replace(/-$/, '')
                                                      );
                                                      break;
                                                    case E.Price:
                                                      n.set('price', e.answer);
                                                      break;
                                                    case E.PropertyType:
                                                      n.set('property_type', e.answer);
                                                      break;
                                                    case E.Address:
                                                      e.lat &&
                                                        e.lng &&
                                                        n.set(
                                                          'radius_location',
                                                          `${e.lat},${e.lng},1`
                                                        );
                                                  }
                                                }),
                                                n
                                              );
                                            })(t, _?.form_type);
                                            window.location.href = `${n}?${e.toString()}`;
                                          }
                                        } else
                                          console.error(
                                            '[FormWizard] API returned success=false:',
                                            n
                                          ),
                                            v({
                                              title: 'Error',
                                              text: n.message || 'Something went wrong',
                                              type: 'error',
                                              showConfirmButton: !0,
                                            });
                                      } catch (o) {
                                        console.error('[FormWizard] Submit error:', o),
                                          v({
                                            title: 'Error',
                                            text:
                                              o instanceof Error
                                                ? o.message
                                                : 'Something went wrong',
                                            type: 'error',
                                            showConfirmButton: !0,
                                          });
                                      }
                                    },
                                    e => {
                                      console.error('[FormWizard] Validation errors:', e);
                                    }
                                  )
                                : async () => {
                                    if (m) K(e => e + 1);
                                    else if (await z(`questions.${V}.answer`)) {
                                      if (ee && _?.form_type === k.Sell && _?.registration_key) {
                                        const t = R(`questions.${V}.answer`) ?? '';
                                        try {
                                          const e = await u.getAnonToken({
                                            agent: window.navigator.userAgent,
                                            origin: window.origin,
                                            referer: document.referrer,
                                            registration_key: _.registration_key,
                                            form_type: _.form_type,
                                            form_title: _.name,
                                            form_address: t,
                                          });
                                          e.data.anonToken &&
                                            localStorage.setItem(
                                              'idx_anon_token',
                                              e.data.anonToken
                                            );
                                        } catch (e) {
                                          console.error('Error fetching anon token:', e);
                                        }
                                      }
                                      K(e => e + 1);
                                    }
                                  },
                            },
                            G ? 'Submit' : 'Continue'
                          )
                    )
                  )
                )
              )
            )
          )
        : null
    );
  },
  N = {
    'contact-form': '_contact-form_4vjht_2',
    'form-row': '_form-row_4vjht_8',
    full: '_full_4vjht_14',
    link: '_link_4vjht_18',
    'text-disclaimer': '_text-disclaimer_4vjht_22',
    'form-check': '_form-check_4vjht_28',
    'form-flex': '_form-flex_4vjht_44',
  },
  q = '_field-phone_63hip_15',
  S = ({ name: e, label: t, placeholder: n, defaultCountry: o = 'us', required: r = !0 }) => {
    const { control: a } = i();
    return s.createElement(
      'div',
      { className: '_field-group_63hip_2' },
      t && s.createElement('label', { className: '_field-label_63hip_6' }, t),
      s.createElement(c, {
        name: e,
        control: a,
        rules: { required: !!r && 'Phone is required' },
        render: ({ field: e, fieldState: t }) =>
          s.createElement(
            s.Fragment,
            null,
            s.createElement(g, {
              defaultCountry: o,
              placeholder: n,
              value: e.value || '',
              onChange: e.onChange,
              inputClassName: `${q} _field-phone__input_63hip_29`,
              countrySelectorStyleProps: { buttonClassName: `${q} _field-phone__country_63hip_26` },
            }),
            t.error &&
              s.createElement('div', { className: '_field-error_63hip_47' }, t.error.message)
          ),
      })
    );
  },
  T = {
    'field-label': '_field-label_1p0yg_2',
    'field-input': '_field-input_1p0yg_11',
    'field-error': '_field-error_1p0yg_33',
    'contact-textarea': '_contact-textarea_1p0yg_39',
  },
  $ = ({ name: e, label: t, placeholder: n }) => {
    const { control: o } = i(),
      {
        field: r,
        fieldState: { error: a },
      } = m({ name: e, control: o });
    return s.createElement(
      'div',
      { className: T['field-group'] },
      t && s.createElement('label', { className: T['field-label'] }, t),
      s.createElement('input', { type: 'text', className: T['field-input'], placeholder: n, ...r }),
      a && s.createElement('div', { className: T['field-error'] }, a.message)
    );
  },
  O = ({ name: e, label: t, placeholder: n }) => {
    const { control: o } = i(),
      {
        field: r,
        fieldState: { error: a },
      } = m({ name: e, control: o });
    return s.createElement(
      'div',
      { className: T['field-group'] },
      t && s.createElement('label', { className: T['field-label'] }, t),
      s.createElement('textarea', {
        className: `${T['field-input']} ${T['contact-textarea']}`,
        placeholder: n,
        ...r,
      }),
      a && s.createElement('div', { className: T['field-error'] }, a.message)
    );
  },
  I = ({
    checked: e,
    id: t,
    label: n,
    name: o,
    onChange: r,
    required: a = !1,
    onlyCheck: l = !1,
  }) =>
    s.createElement(
      'div',
      { className: N['form-check'] },
      s.createElement('input', {
        checked: e,
        className: N['form-check-input'],
        id: t,
        name: o,
        type: 'checkbox',
        onChange: r,
        required: a,
      })
    ),
  P = ({ defaultCountry: t }) => {
    const [n, o] = e.useState('1' === h.form?.disclaimerChecked);
    return s.createElement(
      'div',
      { className: N['contact-form'] },
      s.createElement(
        'div',
        { className: N['form-row'] },
        s.createElement($, { name: 'first_name', placeholder: 'First Name *' }),
        s.createElement($, { name: 'last_name', placeholder: 'Last Name *' })
      ),
      s.createElement(
        'div',
        { className: N['form-row'] },
        s.createElement(S, {
          name: 'phone',
          placeholder: 'Phone',
          defaultCountry: t,
          required: !!h.form.phoneNumberRequired,
        }),
        s.createElement($, { name: 'email', placeholder: 'Email *' })
      ),
      s.createElement(
        'div',
        { className: `${N['form-row']} ${N.full}` },
        s.createElement(O, { name: 'comments', placeholder: 'Comments' })
      ),
      h.form.showOptInMessage &&
        h.form.disclaimerFub &&
        s.createElement(
          'div',
          { className: N['form-flex'] },
          s.createElement(I, {
            id: 'follow_up_boss_valid',
            label: 'Follow Up Boss',
            onlyCheck: !0,
            name: 'follow_up_boss_valid',
            onChange: () => o(e => !e),
            checked: n,
            required: !0,
          }),
          s.createElement(
            'div',
            { className: N['text-disclaimer'] },
            s.createElement('p', { dangerouslySetInnerHTML: { __html: h.form.disclaimerFub } })
          )
        )
    );
  },
  j = '_options-grid_kz97k_2',
  B = '_option-button_kz97k_9',
  F = '_selected_kz97k_30',
  D = ({ name: e, options: t, compact: n }) => {
    const { control: o } = i(),
      r = e => ('string' == typeof e ? e : e.value);
    return s.createElement(c, {
      name: e,
      control: o,
      render: ({ field: e }) =>
        s.createElement(
          'div',
          { className: n ? '_options-grid--compact_kz97k_40' : j },
          t.map(t =>
            s.createElement(
              'button',
              {
                key: r(t),
                type: 'button',
                className: `${B} ${e.value === r(t) ? F : ''}`,
                onClick: () => e.onChange(r(t)),
              },
              (e => ('string' == typeof e ? e : e.label))(t)
            )
          )
        ),
    });
  },
  L = ({ name: e, options: t }) => {
    const { control: n } = i(),
      o = e => ('string' == typeof e ? e : e.value);
    return s.createElement(c, {
      name: e,
      control: n,
      render: ({ field: e }) => {
        const n = e.value ? e.value.split(',').filter(Boolean) : [];
        return s.createElement(
          'div',
          { className: j },
          t.map(t =>
            s.createElement(
              'button',
              {
                key: o(t),
                type: 'button',
                className: `${B} ${n.includes(o(t)) ? F : ''}`,
                onClick: () =>
                  (t => {
                    const o = n.includes(t) ? n.filter(e => e !== t) : [...n, t];
                    e.onChange(o.join(','));
                  })(o(t)),
              },
              (e => ('string' == typeof e ? e : e.label))(t)
            )
          )
        );
      },
    });
  },
  A = ({ question: e, subtitle: t }) =>
    s.createElement(
      s.Fragment,
      null,
      s.createElement('h1', { className: '_step-question_1bter_1' }, e),
      t && s.createElement('p', { className: '_step-subtitle_1bter_8' }, t)
    ),
  M = ({ onClick: e = () => {}, disabled: t, children: n }) =>
    s.createElement(
      'button',
      { className: '_form-button_1qdj5_2', onClick: e, disabled: t, type: 'button' },
      n
    ),
  z = ['places'],
  R = e.createContext({ isLoaded: !1 }),
  Y = ({ children: e }) => {
    const { isLoaded: t } = d({ googleMapsApiKey: h.apiKey.googleMaps, libraries: z });
    return s.createElement(R.Provider, { value: { isLoaded: t } }, e);
  },
  U = ({ name: t }) => {
    const { setValue: n } = i(),
      { isLoaded: o } = e.useContext(R),
      [r, a] = e.useState(null);
    return o
      ? s.createElement(
          u,
          {
            onLoad: e => {
              a(e);
            },
            onPlaceChanged: () => {
              if (null !== r) {
                const e = r.getPlace();
                if (!e.geometry || !e.geometry.location) return;
                const o = e.formatted_address || '',
                  a = e.geometry.location.lat(),
                  s = e.geometry.location.lng();
                n(t, o, { shouldDirty: !0 }),
                  n(t.replace('.answer', '.lat'), a, { shouldDirty: !0 }),
                  n(t.replace('.answer', '.lng'), s, { shouldDirty: !0 });
              }
            },
            options: { types: ['address'] },
          },
          s.createElement($, {
            name: t,
            label: 'Property Address *',
            placeholder: 'Enter your address here',
          })
        )
      : s.createElement($, {
          name: t,
          label: 'Property Address *',
          placeholder: 'Enter your address here',
        });
  },
  J = '_nav-button_19cu6_1',
  W = '_back_19cu6_16',
  Z = ({ onClick: e = () => {}, iconOnly: t = !1 }) => {
    const n = t ? `${J} ${W} _icon-only_19cu6_25` : `${J} ${W}`;
    return s.createElement(
      'button',
      { className: n, type: 'button', onClick: e },
      s.createElement(_, null),
      !t && s.createElement('span', null, 'Back')
    );
  },
  V = ({ children: t, containerId: n = 'idx-modal-root' }) => {
    const [o, r] = e.useState(null);
    return (
      e.useEffect(() => {
        let e = document.getElementById(n);
        return (
          e || ((e = document.createElement('div')), (e.id = n), document.body.appendChild(e)),
          r(e),
          () => {
            e && e.parentNode && !e.hasChildNodes() && e.parentNode.removeChild(e);
          }
        );
      }, [n]),
      o ? p.createPortal(t, o) : null
    );
  },
  K = ({
    isOpen: t,
    onClose: n,
    children: o,
    closeOnOverlayClick: r = !0,
    closeOnEsc: a = !0,
    className: l = '',
  }) => {
    const i = e.useRef(null),
      c = e.useRef(null),
      m = e.useCallback(
        e => {
          a && 'Escape' === e.key && n();
        },
        [a, n]
      ),
      d = e.useCallback(
        e => {
          r && e.target === e.currentTarget && n();
        },
        [r, n]
      );
    return (
      e.useEffect(
        () => (
          t &&
            ((c.current = document.activeElement),
            document.addEventListener('keydown', m),
            (document.body.style.overflow = 'hidden'),
            i.current?.focus()),
          () => {
            document.removeEventListener('keydown', m),
              (document.body.style.overflow = ''),
              c.current?.focus();
          }
        ),
        [t, m]
      ),
      t
        ? s.createElement(
            V,
            null,
            s.createElement(
              'div',
              {
                className: '_modal-overlay_hf8iw_1',
                onClick: d,
                role: 'dialog',
                'aria-modal': 'true',
              },
              s.createElement(
                'div',
                { ref: i, className: `_modal-container_hf8iw_27 ${l}`, tabIndex: -1 },
                s.createElement(
                  'button',
                  { className: '_modal-close_hf8iw_51', onClick: n, 'aria-label': 'Close modal' },
                  s.createElement(
                    'svg',
                    {
                      width: '24',
                      height: '24',
                      viewBox: '0 0 24 24',
                      fill: 'none',
                      stroke: 'currentColor',
                      strokeWidth: '2',
                    },
                    s.createElement('line', { x1: '18', y1: '6', x2: '6', y2: '18' }),
                    s.createElement('line', { x1: '6', y1: '6', x2: '18', y2: '18' })
                  )
                ),
                o
              )
            )
          )
        : null
    );
  },
  Q = ({ isOpen: e, onClose: t, formSlug: n }) =>
    e
      ? s.createElement(
          K,
          { isOpen: e, onClose: t },
          s.createElement(Y, null, s.createElement(C, { mode: 'modal', formSlug: n, onClose: t }))
        )
      : null,
  H = ({ isOpen: e, onClose: t, formData: n, preview: o = !0 }) =>
    e
      ? s.createElement(
          K,
          { isOpen: e, onClose: t },
          s.createElement(
            Y,
            null,
            s.createElement(C, { mode: 'modal', preview: o, formData: n, onClose: t })
          )
        )
      : null;
let X = null,
  G = { isOpen: !1, formSlug: '' };
function ee() {
  X && X.render(s.createElement(Q, { isOpen: G.isOpen, formSlug: G.formSlug, onClose: oe }));
}
function te() {
  if (X) return;
  let e = document.getElementById('idx-modal-provider-root');
  e ||
    ((e = document.createElement('div')),
    (e.id = 'idx-modal-provider-root'),
    document.body.appendChild(e)),
    (X = f(e)),
    ee();
}
function ne(e) {
  X ||
    (console.error('[IDX Forms] Modal system not initialized. Call initModalSystem() first.'),
    te()),
    (G = { isOpen: !0, formSlug: e }),
    ee();
}
function oe() {
  (G = { ...G, isOpen: !1 }), ee();
}
function re() {
  const e = e => {
    const t = e.target.closest('[data-idx-modal]');
    if (!t) return;
    const n = t.getAttribute('data-idx-modal');
    n && (e.preventDefault(), ne(n));
  };
  return (
    document.addEventListener('click', e, !0), () => document.removeEventListener('click', e, !0)
  );
}
let ae = null,
  se = { isOpen: !1, formData: null };
function le() {
  ae &&
    se.formData &&
    ae.render(s.createElement(H, { isOpen: se.isOpen, formData: se.formData, onClose: ie }));
}
function ie() {
  (se = { ...se, isOpen: !1 }), le();
}
const ce = {
    init: te,
    openModal: ne,
    closeModal: oe,
    setupListeners: re,
    openPreview: function (e) {
      ae ||
        (function () {
          if (ae) return;
          let e = document.getElementById('idx-preview-root');
          e ||
            ((e = document.createElement('div')),
            (e.id = 'idx-preview-root'),
            document.body.appendChild(e)),
            (ae = f(e));
        })(),
        (se = { isOpen: !0, formData: e }),
        le();
    },
    closePreview: ie,
  },
  me = document.getElementById('root-dinamic-forms');
me &&
  f(me).render(
    s.createElement(s.StrictMode, null, s.createElement(Y, null, s.createElement(C, null)))
  ),
  te(),
  re(),
  (window.IDXForms = ce);
