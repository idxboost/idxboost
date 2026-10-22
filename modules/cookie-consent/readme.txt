=== IDX Cookie Consent ===
Requires at least: 5.8
Requires PHP: 7.4
Stable tag: 1.5.2
License: GPL-2.0-or-later

Banner de consentimiento de cookies ligero (GDPR/CCPA). Sin jQuery, sin fuentes, sin AJAX en la carga y compatible con page cache.

== Rendimiento ==

* Toda la lógica de consentimiento y ubicación corre en el navegador: PHP no lee cookies ni cabeceras del visitante, así que el HTML es idéntico para todos y la caché (Cloudflare, WP Rocket, LiteSpeed...) no necesita excluir ninguna cookie.
* ~4 KB gzip en total (CSS + JS), todo inline: 0 peticiones extra.
* El banner se muestra al instante con CSS (sin setTimeout). En visitas con consentimiento, `<html class="icc-ok">` se marca desde el <head> y el banner nunca parpadea.
* El modal de preferencias vive en un <template> inerte y se crea solo al abrirlo.
* Los scripts bloqueados se imprimen inertes (<template> o type="text/plain"): el navegador no descarga nada hasta que hay consentimiento.

== Instalación / migración desde GDPR Cookie Compliance (Moove) ==

1. Copia los scripts de Moove (pestaña "Third Party / Advanced Cookies") a Ajustes → Cookie Consent → "Categories & scripts", en la categoría que corresponda.
2. Desactiva y borra "GDPR Cookie Compliance" y su Premium Add-On.
3. Activa este plugin, revisa los textos y colores, y purga el caché (plugin de caché + Cloudflare).

== Cómo bloquear scripts ==

* Snippets (GA4, GTM, Meta Pixel, Clarity...): pégalos en la categoría. Se ejecutan en orden (una librería externa carga antes del inline que la usa).
* Scripts encolados por el tema u otros plugins: en "Block enqueued scripts" añade `handle:categoria` por línea.
* HTML propio: `<script type="text/plain" data-icc="analytics">...</script>` o `<iframe data-icc="marketing" data-icc-src="https://...">`.
* No se soportan snippets que usan document.write.

== Regiones: Europa + California ==

Por defecto el banner se pide en UE/EEE + Reino Unido + Suiza + California (US-CA).
La lista acepta países (DE) o estados/regiones ISO 3166-2 (US-CA). Fuera de la lista no hay banner y se asume consentimiento.

La ubicación se lee de la cookie `icc_country` puesta en el edge (el HTML cacheado es igual para todos). Opciones:

A) Cloudflare Business/Enterprise (país + estado)
Rules → Transform Rules → Modify Response Header → "Add dynamic" (NO "Set", que borra otras cookies):
  Header: Set-Cookie
  Valor:  concat("icc_country=", ip.src.country, "|", ip.src.subdivision_1_iso_code, "|@", ip.src.continent, "; Path=/; Max-Age=86400; SameSite=Lax; Secure")

B) Cloudflare Free/Pro (solo país)
  Valor:  concat("icc_country=", ip.src.country, "; Path=/; Max-Age=86400; SameSite=Lax; Secure")
California se detecta por zona horaria del navegador (America/Los_Angeles → US-CA). Aproximado: incluye también WA, OR y NV (lado seguro).

C) Cualquier plan, estado exacto: Cloudflare Worker en la ruta del sitio (ej. example.com/*):

  export default {
    async fetch(req) {
      const res = await fetch(req);
      if (!(res.headers.get('content-type') || '').includes('text/html')) return res;
      const cf = req.cf || {};
      const v = (cf.country || '') + (cf.country && cf.regionCode ? '|' + cf.country + '-' + cf.regionCode : '');
      const out = new Response(res.body, res);
      if (v) out.headers.append('Set-Cookie', 'icc_country=' + v + '; Path=/; Max-Age=86400; SameSite=Lax; Secure');
      return out;
    }
  };

Geo API (recomendado para sitios sin regla de Cloudflare):
* Servicio de ubicación interno (no configurable en el admin): https://api.idxboost.com/get/ip_lead por POST, o la constante IDX_BOOST_GET_COUNTRY_LEAD si IDXBoost está activo. Se puede cambiar en código con el filtro `icc_geo_api_url`. Solo se consulta en la primera visita de alguien sin consentimiento guardado; la respuesta se guarda 24 h en la cookie `icc_country` (ej. `ES|ES-MD|@EU`), así que las siguientes páginas no hacen la petición.
* Mientras responde, el banner queda oculto y no corre ningún script; si tarda más de 1.5 s (filtro `icc_geo_api_timeout`) o falla, se usa la zona horaria.
* Campos usados: `country`, `region_code`, `continent` (si `status` es false se usa la zona horaria).
  - Europa: `continent = EU` → banner (opción "All of Europe"), sin listar países.
  - California: `continent = NA` + `country = US` + `region_code = CA`.
* El endpoint debe responder con `Access-Control-Allow-Origin` para los dominios de los clientes (o `*`); sin CORS el navegador bloquea la respuesta y se usa la zona horaria.

Sin Cloudflare:
* Por defecto ("Location unknown" = time zone): si no llega la cookie, se usa la zona horaria del navegador, sin peticiones extra.
  Europe/* (y Canarias, Madeira, Azores, Islandia, Feroe) → banner. America/Los_Angeles → California → banner. Resto → sin banner.
  Es aproximado: alguien con VPN o reloj cambiado puede caer del lado equivocado; incluye algunos países europeos fuera de la UE (lado seguro).
* Si el servidor/CDN tiene GeoIP, lo exacto y compatible con caché es que ponga la misma cookie. Ejemplo nginx con módulo geoip2:
    add_header Set-Cookie "icc_country=$geoip2_data_country_iso_code|$geoip2_data_country_iso_code-$geoip2_data_subdivision_iso_code; Path=/; Max-Age=86400; SameSite=Lax; Secure" always;

== CCPA (California y otros estados de EE. UU.) ==

* Global Privacy Control: si el navegador envía GPC, marketing queda apagado (opt-out de venta/compartir) y se muestra la confirmación en el panel de preferencias (el banner mantiene un solo mensaje). Si el visitante luego pulsa "Aceptar todo", esa elección explícita prevalece.
* Enlace "Do Not Sell or Share My Personal Information": ponlo en el footer con `[icc_do_not_sell]` o un enlace a `#icc-do-not-sell`. Abre las preferencias con marketing apagado; al guardar se recarga la página si marketing ya se estaba ejecutando.

== Cloudflare Zaraz ==

Crea los "purposes" en Zaraz → Consent, desactiva el modal propio de Zaraz, activa "Zaraz bridge" y pega cada purpose ID en su categoría.

== IDXBoost ==

Si el plugin IDXBoost está activo, el ajuste aparece en IDX Boost → Cookie Consent y los trackers que IDXBoost imprime desde la configuración del agente quedan retenidos hasta el consentimiento, sin modificar IDXBoost (se envuelven sus hooks):
* Google Analytics → Analytics. Google Ads → Marketing (si hay GA, el bloque gtag cuenta como Analytics; Consent Mode controla ads).
* Facebook Pixel, Follow Up Boss pixel → Marketing. StatCounter, Matomo → Analytics.
* CRM pixel de IDXBoost + cookie `_ib_attr` y Google Tag Manager → categoría configurable (por defecto Marketing).
* Las llamadas `gtag()` de las vistas de IDXBoost no fallan antes del consentimiento (se encolan en dataLayer).
Versión módulo: carpeta `modules/cookie-consent/` dentro de IDXBoost + 1 línea `require_once` al final de idxboost.php. Viene apagado. Si el plugin suelto también está activo, gana el suelto (sin duplicados).

== Google Consent Mode v2 ==

Por defecto: todo `denied` en el <head> (antes de GTM/gtag). Al elegir se hace `consent update`.
Analytics → analytics_storage. Marketing → ad_storage, ad_user_data, ad_personalization. Preferences → functionality_storage, personalization_storage.
Eventos dataLayer para GTM: `icc_consent_ready` (cada carga con consentimiento) e `icc_consent_update` (al cambiar), con `icc_analytics`, `icc_marketing`, `icc_preferences`.

== API JS ==

* `ICC.open()` abre las preferencias (`ICC.open({marketing:false})` con valores forzados).
* `ICC.region`, `ICC.country`, `ICC.subdivision`, `ICC.gpc`: estado detectado.
* También funciona cualquier enlace a `#icc-settings` o el shortcode `[icc_settings text="Cookie settings"]`.
* `ICC.has('analytics')` → true/false.
* Evento `document.addEventListener('icc:consent', e => e.detail.consent)`.

== Hooks PHP ==

* `icc_options` (filter): modificar opciones en tiempo de ejecución (p. ej. traducciones por idioma).
* `icc_config` (filter): config enviada al navegador.
* `icc_should_run` (filter): desactivar en ciertas páginas.
* `icc_geo_timezones` (filter): mapa zona horaria → región para el fallback (por defecto America/Los_Angeles → US-CA).
* `icc_settings_saved` (action): tras guardar (útil para purgar caché propio).

== Desarrollo ==

Fuentes en assets/src. Tras editarlas: `npm install && npm run build` (genera assets/build).
