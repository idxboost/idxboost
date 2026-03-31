import {
  r as e,
  z as t,
  u as n,
  a as r,
  b as o,
  c as a,
  R as l,
  F as s,
  d as i,
  C as c,
  e as m,
  f as d,
  A as u,
  g as p,
  h as _,
  i as f,
} from './vendor-484c7feb.js';
import { U as h } from './phone-input-e0238ad8.js';
const y = '_form-wizard_19yly_2',
  g = {
    user: {},
    api: { idxboost: 'https://api.idxboost.dev' },
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
var b = Object.defineProperty;
class E {
  constructor() {
    var e, t, n;
    (e = this),
      (t = 'baseUrl'),
      (n = `${g.api.idxboost}/idxforms`),
      ((e, t, n) => {
        t in e ? b(e, t, { enumerable: !0, configurable: !0, writable: !0, value: n }) : (e[t] = n);
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
    const r = await fetch(`${this.baseUrl}/slug-rk/${e}`, { method: 'POST', body: n });
    if (!r.ok) throw new Error('Error fetching idxform by slug');
    return r.json();
  }
  async getIpLead() {
    try {
      const e = await fetch(`${g.api.idxboost}/get/ip_lead`, {
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
  async sendIdxForm({
    client_ip: e,
    origin: t,
    referer: n,
    agent: r,
    access_token: o,
    lead_token: a,
    form_data: l,
    autologinForms: s,
  }) {
    if (!e) {
      const t = await this.getIpLead();
      (e = t?.ip || ''), (l.country_code = t?.country || '');
    }
    const i = {
        client_ip: e,
        origin: t,
        referer: n,
        agent: r,
        access_token: o,
        lead_token: a,
        form_data: JSON.stringify(l),
        autologinForms: s,
      },
      c = new FormData();
    Object.entries(i).forEach(([e, t]) => {
      c.append(e, String(t));
    });
    const m = await fetch(`${this.baseUrl}/handle`, { method: 'POST', body: c });
    if (!m.ok) {
      const e = await m.text();
      throw new Error(`Error sending idxform: ${e}`);
    }
    return m.json();
  }
}
var w = (e => (
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
))(w || {});
function v({ title: e, type: t, showConfirmButton: n = !1, text: r, timer: o, button: a }) {
  return new Promise(l => {
    const s = {
        title: e,
        text: r,
        icon: t,
        ...(void 0 !== o && { timer: o }),
        button: a ?? (!!n && 'OK'),
      },
      i = swal(s);
    i && 'function' == typeof i.then
      ? i.then(() => l(!0)).catch(() => l(!0))
      : swal(s, () => l(!0));
  });
}
const k = ['gad_source', 'gad_campaignid', 'gbraid', 'gclid'],
  C = t.object({
    first_name: t.string().min(1, 'First name is required'),
    last_name: t.string().min(1, 'Last name is required'),
    email: t.string().min(1, 'Email is required').email('Invalid email'),
    phone: g.form.phoneNumberRequired
      ? t
          .string()
          .min(1, 'Phone is required')
          .regex(/^\+\d{7,15}$/, 'Invalid phone number')
      : t
          .string()
          .optional()
          .refine(e => !e || /^\+\d{7,15}$/.test(e), 'Invalid phone number'),
    comments: t.string().optional(),
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
  N = ({ mode: t = 'fullpage', formSlug: i, onClose: c, preview: m = !1, formData: d } = {}) => {
    const u = e.useMemo(() => new E(), []),
      [p, _] = e.useState(null),
      [f, h] = e.useState('us'),
      b = i || g.form.type,
      { accessToken: N, leadToken: x, firstName: q, lastName: S, email: $, phone: O } = g.form,
      I = n({ resolver: r(C), defaultValues: { questions: [] } }),
      {
        handleSubmit: j,
        control: B,
        reset: F,
        trigger: z,
        formState: { errors: R },
      } = I,
      { fields: Y } = o({ control: B, name: 'questions' }),
      [W, Z] = e.useState(0),
      [K, V] = e.useState(null),
      Q = Y[W],
      H = W === (Y?.length && Y.length - 1),
      X = 0 === W,
      G = 'modal' === t,
      ee = p?.background_image,
      te = G ? `${y} _form-wizard--modal_19yly_104` : y,
      ne = a({ control: B, name: `questions.${W}.answer` });
    return (
      e.useEffect(() => {
        d
          ? _(d)
          : b &&
            u
              .getBySlug({ slug: b, accessToken: N })
              .then(e => _(e))
              .catch(e => console.error('Error loading form:', e));
      }, [b, N, d]),
      e.useEffect(() => {
        m ||
          u
            .getIpLead()
            .then(e => {
              e?.country && h(e.country.toLowerCase());
            })
            .catch(e => console.error('Error fetching IP lead:', e));
      }, [m]),
      e.useEffect(() => {
        p?.steps &&
          F({
            questions: p.steps.map(e => ({ ...e, answer: '', lat: void 0, lng: void 0 })),
            first_name: q ?? '',
            last_name: S ?? '',
            email: $ ?? '',
            phone: O ?? '',
            comments: '',
          });
      }, [p?.steps]),
      p && Q
        ? l.createElement(
            s,
            { ...I },
            l.createElement(
              'form',
              { className: te, onSubmit: e => e.preventDefault() },
              !G &&
                l.createElement('div', {
                  className: '_form-background_19yly_9',
                  style: { backgroundImage: `url(${ee})` },
                }),
              l.createElement(
                'div',
                { className: '_form-content_19yly_33' },
                l.createElement(
                  'div',
                  { className: '_step-container_19yly_42' },
                  l.createElement(
                    'div',
                    { className: '_back-button-container_19yly_81' },
                    !X && l.createElement(J, { onClick: () => Z(e => e - 1), iconOnly: G })
                  ),
                  ' ',
                  l.createElement(
                    'div',
                    { className: '_step-content_19yly_51' },
                    l.createElement(
                      'div',
                      { className: '_step-header_19yly_67' },
                      l.createElement(M, { question: Q.question, subtitle: Q.subtitle })
                    ),
                    (Q.questionType === w.SelectSingle ||
                      Q.questionType === w.Beds ||
                      Q.questionType === w.Baths ||
                      Q.questionType === w.Price ||
                      Q.questionType === w.PropertyType) &&
                      l.createElement(D, {
                        name: `questions.${W}.answer`,
                        options: Q.options ?? [],
                        compact: Q.questionType === w.Beds || Q.questionType === w.Baths,
                      }),
                    Q.questionType === w.Address &&
                      l.createElement(U, { name: `questions.${W}.answer` }),
                    Q.questionType === w.Text &&
                      l.createElement(T, {
                        name: `questions.${W}.answer`,
                        placeholder: Q.placeholder,
                      }),
                    Q.questionType === w.MultiSelect &&
                      l.createElement(L, {
                        name: `questions.${W}.answer`,
                        options: Q.options ?? [],
                      }),
                    Q.questionType === w.Contact && l.createElement(P, { defaultCountry: f }),
                    l.createElement(
                      'div',
                      { className: '_navigation-buttons_19yly_73' },
                      m && H
                        ? l.createElement(A, { disabled: !0 }, 'Submit')
                        : l.createElement(
                            A,
                            {
                              disabled: !(m || H || (ne && '' !== ne.trim())),
                              onClick: H
                                ? j(
                                    async e => {
                                      const t = e.questions.filter(
                                          e => e.questionType !== w.Contact
                                        ),
                                        n = {
                                          formType: b,
                                          steps: t.map(e => ({
                                            question: e.question,
                                            answer: e.answer,
                                            ...(e.questionType === w.Address && e.lat && e.lng
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
                                      V(n),
                                        (e.steps = e.questions
                                          .filter(e => 'contact' !== e.questionType)
                                          .map(e => ({ question: e.question, answer: e.answer }))),
                                        delete e.questions,
                                        (e.name = `${e.first_name} ${e.last_name}`),
                                        delete e.first_name,
                                        delete e.last_name,
                                        (e.form_type = p?.form_type || b),
                                        (e.ib_tags =
                                          (function () {
                                            const e = new URLSearchParams(window.location.search),
                                              t = [];
                                            for (const n of k) {
                                              const r = e.get(n);
                                              r && t.push(`${n}=${r}`);
                                            }
                                            return t.join(',');
                                          })() || 'inquiry_buy_sell_rent');
                                      try {
                                        const n = await u.sendIdxForm({
                                          agent: window.navigator.userAgent,
                                          form_data: e,
                                          origin: window.origin,
                                          referer: document.referrer,
                                          access_token: N,
                                          lead_token: x,
                                          autologinForms: !1,
                                        });
                                        if (n.success) {
                                          const e = p?.redirect_on_submit ?? !0,
                                            n = p?.redirect_url ?? '/search';
                                          if (
                                            (F(),
                                            Z(0),
                                            await v({
                                              title: 'Thank You!',
                                              text:
                                                p?.redirect_message ??
                                                "Your information has been submitted successfully. We'll be in touch with you shortly.",
                                              type: 'success',
                                              showConfirmButton: !0,
                                            }),
                                            G && c && c(),
                                            e)
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
                                                    case w.Beds:
                                                      n.set(
                                                        'beds',
                                                        e.answer
                                                          .replace(/_/g, '-')
                                                          .replace(/-$/, '')
                                                      );
                                                      break;
                                                    case w.Baths:
                                                      n.set(
                                                        'baths',
                                                        e.answer
                                                          .replace(/_/g, '-')
                                                          .replace(/-$/, '')
                                                      );
                                                      break;
                                                    case w.Price:
                                                      n.set('price', e.answer);
                                                      break;
                                                    case w.PropertyType:
                                                      n.set('property_type', e.answer);
                                                      break;
                                                    case w.Address:
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
                                            })(t, p?.form_type);
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
                                      } catch (r) {
                                        console.error('[FormWizard] Submit error:', r),
                                          v({
                                            title: 'Error',
                                            text:
                                              r instanceof Error
                                                ? r.message
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
                                    (m || (await z(`questions.${W}.answer`))) && Z(e => e + 1);
                                  },
                            },
                            H ? 'Submit' : 'Continue'
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
  x = {
    'contact-form': '_contact-form_4vjht_2',
    'form-row': '_form-row_4vjht_8',
    full: '_full_4vjht_14',
    link: '_link_4vjht_18',
    'text-disclaimer': '_text-disclaimer_4vjht_22',
    'form-check': '_form-check_4vjht_28',
    'form-flex': '_form-flex_4vjht_44',
  },
  q = '_field-phone_63hip_15',
  S = ({ name: e, label: t, placeholder: n, defaultCountry: r = 'us', required: o = !0 }) => {
    const { control: a } = i();
    return l.createElement(
      'div',
      { className: '_field-group_63hip_2' },
      t && l.createElement('label', { className: '_field-label_63hip_6' }, t),
      l.createElement(c, {
        name: e,
        control: a,
        rules: { required: !!o && 'Phone is required' },
        render: ({ field: e, fieldState: t }) =>
          l.createElement(
            l.Fragment,
            null,
            l.createElement(h, {
              defaultCountry: r,
              placeholder: n,
              value: e.value || '',
              onChange: e.onChange,
              inputClassName: `${q} _field-phone__input_63hip_29`,
              countrySelectorStyleProps: { buttonClassName: `${q} _field-phone__country_63hip_26` },
            }),
            t.error &&
              l.createElement('div', { className: '_field-error_63hip_47' }, t.error.message)
          ),
      })
    );
  },
  $ = {
    'field-label': '_field-label_1p0yg_2',
    'field-input': '_field-input_1p0yg_11',
    'field-error': '_field-error_1p0yg_33',
    'contact-textarea': '_contact-textarea_1p0yg_39',
  },
  T = ({ name: e, label: t, placeholder: n }) => {
    const { control: r } = i(),
      {
        field: o,
        fieldState: { error: a },
      } = m({ name: e, control: r });
    return l.createElement(
      'div',
      { className: $['field-group'] },
      t && l.createElement('label', { className: $['field-label'] }, t),
      l.createElement('input', { type: 'text', className: $['field-input'], placeholder: n, ...o }),
      a && l.createElement('div', { className: $['field-error'] }, a.message)
    );
  },
  O = ({ name: e, label: t, placeholder: n }) => {
    const { control: r } = i(),
      {
        field: o,
        fieldState: { error: a },
      } = m({ name: e, control: r });
    return l.createElement(
      'div',
      { className: $['field-group'] },
      t && l.createElement('label', { className: $['field-label'] }, t),
      l.createElement('textarea', {
        className: `${$['field-input']} ${$['contact-textarea']}`,
        placeholder: n,
        ...o,
      }),
      a && l.createElement('div', { className: $['field-error'] }, a.message)
    );
  },
  I = ({
    checked: e,
    id: t,
    label: n,
    name: r,
    onChange: o,
    required: a = !1,
    onlyCheck: s = !1,
  }) =>
    l.createElement(
      'div',
      { className: x['form-check'] },
      l.createElement('input', {
        checked: e,
        className: x['form-check-input'],
        id: t,
        name: r,
        type: 'checkbox',
        onChange: o,
        required: a,
      })
    ),
  P = ({ defaultCountry: t }) => {
    const [n, r] = e.useState('1' === g.form?.disclaimerChecked);
    return l.createElement(
      'div',
      { className: x['contact-form'] },
      l.createElement(
        'div',
        { className: x['form-row'] },
        l.createElement(T, { name: 'first_name', placeholder: 'First Name *' }),
        l.createElement(T, { name: 'last_name', placeholder: 'Last Name *' })
      ),
      l.createElement(
        'div',
        { className: x['form-row'] },
        l.createElement(S, {
          name: 'phone',
          placeholder: 'Phone',
          defaultCountry: t,
          required: !!g.form.phoneNumberRequired,
        }),
        l.createElement(T, { name: 'email', placeholder: 'Email *' })
      ),
      l.createElement(
        'div',
        { className: `${x['form-row']} ${x.full}` },
        l.createElement(O, { name: 'comments', placeholder: 'Comments' })
      ),
      g.form.showOptInMessage &&
        g.form.disclaimerFub &&
        l.createElement(
          'div',
          { className: x['form-flex'] },
          l.createElement(I, {
            id: 'follow_up_boss_valid',
            label: 'Follow Up Boss',
            onlyCheck: !0,
            name: 'follow_up_boss_valid',
            onChange: () => r(e => !e),
            checked: n,
            required: !0,
          }),
          l.createElement(
            'div',
            { className: x['text-disclaimer'] },
            l.createElement('p', { dangerouslySetInnerHTML: { __html: g.form.disclaimerFub } })
          )
        )
    );
  },
  j = '_options-grid_kz97k_2',
  B = '_option-button_kz97k_9',
  F = '_selected_kz97k_30',
  D = ({ name: e, options: t, compact: n }) => {
    const { control: r } = i(),
      o = e => ('string' == typeof e ? e : e.value);
    return l.createElement(c, {
      name: e,
      control: r,
      render: ({ field: e }) =>
        l.createElement(
          'div',
          { className: n ? '_options-grid--compact_kz97k_40' : j },
          t.map(t =>
            l.createElement(
              'button',
              {
                key: o(t),
                type: 'button',
                className: `${B} ${e.value === o(t) ? F : ''}`,
                onClick: () => e.onChange(o(t)),
              },
              (e => ('string' == typeof e ? e : e.label))(t)
            )
          )
        ),
    });
  },
  L = ({ name: e, options: t }) => {
    const { control: n } = i(),
      r = e => ('string' == typeof e ? e : e.value);
    return l.createElement(c, {
      name: e,
      control: n,
      render: ({ field: e }) => {
        const n = e.value ? e.value.split(',').filter(Boolean) : [];
        return l.createElement(
          'div',
          { className: j },
          t.map(t =>
            l.createElement(
              'button',
              {
                key: r(t),
                type: 'button',
                className: `${B} ${n.includes(r(t)) ? F : ''}`,
                onClick: () =>
                  (t => {
                    const r = n.includes(t) ? n.filter(e => e !== t) : [...n, t];
                    e.onChange(r.join(','));
                  })(r(t)),
              },
              (e => ('string' == typeof e ? e : e.label))(t)
            )
          )
        );
      },
    });
  },
  M = ({ question: e, subtitle: t }) =>
    l.createElement(
      l.Fragment,
      null,
      l.createElement('h1', { className: '_step-question_1bter_1' }, e),
      t && l.createElement('p', { className: '_step-subtitle_1bter_8' }, t)
    ),
  A = ({ onClick: e = () => {}, disabled: t, children: n }) =>
    l.createElement(
      'button',
      { className: '_form-button_1qdj5_2', onClick: e, disabled: t, type: 'button' },
      n
    ),
  z = ['places'],
  R = e.createContext({ isLoaded: !1 }),
  Y = ({ children: e }) => {
    const { isLoaded: t } = d({ googleMapsApiKey: g.apiKey.googleMaps, libraries: z });
    return l.createElement(R.Provider, { value: { isLoaded: t } }, e);
  },
  U = ({ name: t }) => {
    const { setValue: n } = i(),
      { isLoaded: r } = e.useContext(R),
      [o, a] = e.useState(null);
    return r
      ? l.createElement(
          u,
          {
            onLoad: e => {
              a(e);
            },
            onPlaceChanged: () => {
              if (null !== o) {
                const e = o.getPlace();
                if (!e.geometry || !e.geometry.location) return;
                const r = e.formatted_address || '',
                  a = e.geometry.location.lat(),
                  l = e.geometry.location.lng();
                n(t, r, { shouldDirty: !0 }),
                  n(t.replace('.answer', '.lat'), a, { shouldDirty: !0 }),
                  n(t.replace('.answer', '.lng'), l, { shouldDirty: !0 });
              }
            },
            options: { types: ['address'] },
          },
          l.createElement(T, {
            name: t,
            label: 'Property Address *',
            placeholder: 'Enter your address here',
          })
        )
      : l.createElement(T, {
          name: t,
          label: 'Property Address *',
          placeholder: 'Enter your address here',
        });
  },
  W = '_nav-button_19cu6_1',
  Z = '_back_19cu6_16',
  J = ({ onClick: e = () => {}, iconOnly: t = !1 }) => {
    const n = t ? `${W} ${Z} _icon-only_19cu6_25` : `${W} ${Z}`;
    return l.createElement(
      'button',
      { className: n, type: 'button', onClick: e },
      l.createElement(p, null),
      !t && l.createElement('span', null, 'Back')
    );
  },
  K = ({ children: t, containerId: n = 'idx-modal-root' }) => {
    const [r, o] = e.useState(null);
    return (
      e.useEffect(() => {
        let e = document.getElementById(n);
        return (
          e || ((e = document.createElement('div')), (e.id = n), document.body.appendChild(e)),
          o(e),
          () => {
            e && e.parentNode && !e.hasChildNodes() && e.parentNode.removeChild(e);
          }
        );
      }, [n]),
      r ? _.createPortal(t, r) : null
    );
  },
  V = ({
    isOpen: t,
    onClose: n,
    children: r,
    closeOnOverlayClick: o = !0,
    closeOnEsc: a = !0,
    className: s = '',
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
          o && e.target === e.currentTarget && n();
        },
        [o, n]
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
        ? l.createElement(
            K,
            null,
            l.createElement(
              'div',
              {
                className: '_modal-overlay_hf8iw_1',
                onClick: d,
                role: 'dialog',
                'aria-modal': 'true',
              },
              l.createElement(
                'div',
                { ref: i, className: `_modal-container_hf8iw_27 ${s}`, tabIndex: -1 },
                l.createElement(
                  'button',
                  { className: '_modal-close_hf8iw_51', onClick: n, 'aria-label': 'Close modal' },
                  l.createElement(
                    'svg',
                    {
                      width: '24',
                      height: '24',
                      viewBox: '0 0 24 24',
                      fill: 'none',
                      stroke: 'currentColor',
                      strokeWidth: '2',
                    },
                    l.createElement('line', { x1: '18', y1: '6', x2: '6', y2: '18' }),
                    l.createElement('line', { x1: '6', y1: '6', x2: '18', y2: '18' })
                  )
                ),
                r
              )
            )
          )
        : null
    );
  },
  Q = ({ isOpen: e, onClose: t, formSlug: n }) =>
    e
      ? l.createElement(
          V,
          { isOpen: e, onClose: t },
          l.createElement(Y, null, l.createElement(N, { mode: 'modal', formSlug: n, onClose: t }))
        )
      : null,
  H = ({ isOpen: e, onClose: t, formData: n }) =>
    e
      ? l.createElement(
          V,
          { isOpen: e, onClose: t },
          l.createElement(
            Y,
            null,
            l.createElement(N, { mode: 'modal', preview: !0, formData: n, onClose: t })
          )
        )
      : null;
let X = null,
  G = { isOpen: !1, formSlug: '' };
function ee() {
  X && X.render(l.createElement(Q, { isOpen: G.isOpen, formSlug: G.formSlug, onClose: re }));
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
function re() {
  (G = { ...G, isOpen: !1 }), ee();
}
function oe() {
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
  le = { isOpen: !1, formData: null };
function se() {
  ae &&
    le.formData &&
    ae.render(l.createElement(H, { isOpen: le.isOpen, formData: le.formData, onClose: ie }));
}
function ie() {
  (le = { ...le, isOpen: !1 }), se();
}
const ce = {
    init: te,
    openModal: ne,
    closeModal: re,
    setupListeners: oe,
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
        (le = { isOpen: !0, formData: e }),
        se();
    },
    closePreview: ie,
  },
  me = document.getElementById('root-dinamic-forms');
me &&
  f(me).render(
    l.createElement(l.StrictMode, null, l.createElement(Y, null, l.createElement(N, null)))
  ),
  te(),
  oe(),
  (window.IDXForms = ce);
