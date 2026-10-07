<?php

$variableUrl = get_query_var('idxparamncollectionproperties');
$has_collection_access = true;
$ib_debug = isset($_GET['ib_debug']);
$ib_debug_info = [];

if (false !== $GLOBALS['flex_idx_lead']) {
    $lead_id = '';
    $lead_email = $GLOBALS['flex_idx_lead']['lead_info']['email_address'] ?? '';
    $ib_debug_info['flex_idx_lead_raw'] = $GLOBALS['flex_idx_lead'];
    $ib_debug_info['lead_email'] = $lead_email;
    $ib_debug_info['variableUrl'] = $variableUrl;

    if (!empty($lead_email)) {
        $api_search_url = FLEX_IDX_BASE_URL . '/get_leads_by_email_rk/' . get_option('idxboost_registration_key') . '/' . urlencode($lead_email);
        $ib_debug_info['lead_lookup_url'] = $api_search_url;
        $lead_lookup_response = wp_remote_get($api_search_url, ['timeout' => 20]);
        if (!is_wp_error($lead_lookup_response)) {
            $lead_lookup_data = json_decode(wp_remote_retrieve_body($lead_lookup_response), true);
            $ib_debug_info['lead_lookup_response'] = wp_remote_retrieve_body($lead_lookup_response);
            if (isset($lead_lookup_data['lead_id']) && !empty($lead_lookup_data['lead_id'])) {
                $lead_id = $lead_lookup_data['lead_id'];
            }
        } else {
            $ib_debug_info['lead_lookup_error'] = $lead_lookup_response->get_error_message();
        }
    }

    $ib_debug_info['resolved_lead_id'] = $lead_id;

    $has_collection_access = false;
    if (!empty($lead_id) && !empty($variableUrl)) {
        $access_check_url = FLEX_IDX_API_COLLECTIONS . '/api/collections/' . $variableUrl . '/access/lead/' . $lead_id;
        $ib_debug_info['access_check_url'] = $access_check_url;
        $access_check_response = wp_remote_get($access_check_url, ['timeout' => 20]);
        if (!is_wp_error($access_check_response)) {
            $access_check_data = json_decode(wp_remote_retrieve_body($access_check_response), true);
            $ib_debug_info['access_check_response'] = wp_remote_retrieve_body($access_check_response);
            $has_collection_access = !empty($access_check_data['data']['hasAccess']);
        } else {
            $ib_debug_info['access_check_error'] = $access_check_response->get_error_message();
        }
    }

    // Strip ?show=<mls> before any output so the globally-enqueued property-modal
    // bundle (which reads location.search on the client) never gets a chance to
    // open a property the lead has no access to.
    if (!$has_collection_access && !empty($_GET['show']) && !$ib_debug) {
        wp_redirect(home_url('/collection/' . $variableUrl));
        exit;
    }
}

if ($ib_debug) {
    $GLOBALS['ib_collection_render_pass'] = ($GLOBALS['ib_collection_render_pass'] ?? 0) + 1;
    echo '<!-- IB_DEBUG pass=' . $GLOBALS['ib_collection_render_pass']
        . ' has_access=' . var_export($has_collection_access, true)
        . ' backtrace=' . esc_html(str_replace("\n", ' | ', (new Exception())->getTraceAsString()))
        . ' -->';
}

get_header();
if (false === $GLOBALS['flex_idx_lead']): ?>
    <style>
        .flex-not-logged-in-msg {
        }

        .flex-not-logged-in-msg p {
            font-size: 50px;
            margin: 50px 0;
            text-align: center;
        }

        .flex-not-logged-in-msg p a {
            background: #0072ac;
            color: #fff;
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
            text-transform: uppercase;
            font-size: 40px;
        }
    </style>
    <main class="page-deployed">
        <div class="wrap-page-deployed align-center-fx">
            <h1 class="title-page-deployed" style="font-size: 4.5rem; margin-bottom: 0">Login Required!</h1>
            <div class="info-deployed">
                <p class="align-center-fx" style="max-width:100%"><?php echo __("Please log in to view this page.", IDXBOOST_DOMAIN_THEME_LANG); ?></p>
            </div>
            <button class="clidxboost-btn-link flex-login-link" aria-label="Log In">
                <span>Log In</span>
            </button>
        </div>
        <div class="layer-mx"></div>
    </main>
    <script>
        function active_modal_js(modal) {
            if (modal.classList.contains('active_modal')) {
                document.querySelectorAll('.overlay_modal').forEach(el => {
                    el.classList.remove('active_modal');
                });
            } else {
                modal.classList.add('active_modal');
                const firstInput = modal.querySelector('form input');
                if (firstInput) {
                    firstInput.focus();
                }
                document.documentElement.classList.add('modal_mobile');
            }
            close_modal_js(modal);
        }

        function close_modal_js(obj) {
            const closeBtn = obj.querySelector('.close');
            if (!closeBtn) return;
            closeBtn.addEventListener('click', function () {
                const modal = closeBtn.closest('.active_modal');
                if (modal) {
                    modal.classList.remove('active_modal');
                }
                document.documentElement.classList.remove('modal_mobile');
            });
        }

        (function () {
            // Define el selector para el campo de email del modal (¡AJUSTA ESTO!)
            const EMAIL_INPUT_SELECTOR = 'input[name="register_email"]';
            const LOGIN_LINK_SELECTOR = '.lg-register'; // Enlace de "login" que aparece en el div

            const urlParams = new URLSearchParams(window.location.search);
            const inviteToken = urlParams.get('invite');

            if (inviteToken) {
                // 1. Lógica de Cookie
                const cookieName = 'invite_token';
                const days = 1;
                const expires = new Date(Date.now() + days * 864e5).toUTCString();
                document.cookie = `${cookieName}=${inviteToken}; expires=${expires}; path=/; SameSite=Lax`;

                // 2. Obtener la URL de AJAX de WordPress
                // Esta URL global 'ajaxurl' SOLO existe si WordPress está correctamente cargado.
                const ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';

                // 3. Función para rellenar y hacer clic
                const retrieveEmailAndClick = () => {
                    // Prepara los datos para la petición AJAX
                    const data = new URLSearchParams();
                    data.append('action', 'flex_get_email_by_token');
                    data.append('invite_token', inviteToken);

                    // Petición AJAX (Fetch API)
                    fetch(ajaxurl, {
                        method: 'POST',
                        body: data,
                    })
                        .then(response => response.json())
                        .then(result => {
                            let prefillEmail = '';
                            if (result.success && result.data && result.data.email) {
                                prefillEmail = result.data.email;
                            }

                            active_modal_js(document.getElementById('modal_login'));
                            document.getElementById("tabRegister").classList.add("active");
                            document.getElementById("tabLogin").classList.remove("active");

                            const emailInput = document.querySelector('[name="register_email"]');
                            emailInput.value = prefillEmail;
                        })
                        .catch(error => {
                            console.error('Error al obtener el email por token:', error);
                            // Si falla la petición, al menos intenta abrir el modal sin rellenar
                            setTimeout(() => {
                                const loginLink = document.querySelector(LOGIN_LINK_SELECTOR);
                                if (loginLink) loginLink.click();
                            }, 500);
                        });
                };

                // Ejecutar la función cuando el DOM esté listo
                window.addEventListener('DOMContentLoaded', retrieveEmailAndClick);
            }
        })();
    </script>
<?php else:

    $idxboost_search_settings = get_option('idxboost_search_settings');
    $idxboost_agent_info = get_option('idxboost_agent_info');
    $api_idx_access_token = flex_idx_get_access_token();

    if (!$has_collection_access):
        ?>
        <main class="page-deployed">
            <div class="wrap-page-deployed align-center-fx">
                <h1 class="title-page-deployed" style="font-size: 4.5rem; margin-bottom: 0">Access Denied</h1>
                <div class="info-deployed">
                    <p class="align-center-fx" style="max-width:100%"><?php echo __("You don't have access to this collection.", IDXBOOST_DOMAIN_THEME_LANG); ?></p>
                </div>
                <?php if ($ib_debug): ?>
                    <pre style="text-align:left; max-width:800px; margin:20px auto; background:#111; color:#0f0; padding:15px; white-space:pre-wrap; word-break:break-all; font-size:12px;"><?php echo esc_html(print_r($ib_debug_info, true)); ?></pre>
                <?php endif; ?>
            </div>
            <div class="layer-mx"></div>
        </main>
        <?php
    else:
        ?>
        <script>
            var __flex_g_settings = {
                propertyDetailPermalink: '<?php echo get_site_url(); ?>/property'
            }

            <?php
            $force_registration = isset($flex_idx_info["agent"]["force_registration"]) ? $flex_idx_info["agent"]["force_registration"] : 0;
            $force_registration_forced = ($force_registration == "1") ? $idxboost_agent_info['force_registration_forced'] : null;
            $signup_left_clicks = ($force_registration == "1" && isset($flex_idx_info["agent"]["signup_left_clicks"]) && !empty($flex_idx_info["agent"]["signup_left_clicks"]) ? (int)$flex_idx_info["agent"]["signup_left_clicks"] : 0);
            ?>


            window.idx_main_settings = {
                force_registration: Boolean(<?php echo $force_registration; ?>),
                force_registration_forced: <?php echo $force_registration == "1" ? json_encode($force_registration_forced) : "undefined"; ?>,
                signup_left_clicks: <?php echo $force_registration == "1" ? $signup_left_clicks : "undefined"; ?>,
                search_settings: <?php echo json_encode($idxboost_search_settings); ?>,
                agent_info: <?php echo json_encode($idxboost_agent_info); ?>,
                access_token: "<?php echo $api_idx_access_token; ?>",
                board_info: <?php echo @json_encode($idxboost_search_settings['board_info']); ?>,
                paths: '<?php echo FLEX_IDX_URI . "react/new_search_filter/"; ?>',
            }
            window.idxtoken = "<?php echo $access_token_service; ?>";

            window.idx_collections_settings = {
                client_type: "lead",
                collections_mode: "edit",
                param_url: '<?php echo $variableUrl; ?>',

                collections_path: "collections",
                detail_path: "collection"
            }
        </script>

        <div id="root-search"></div>
    <?php endif; ?>

<?php endif; ?>
<?php wp_footer(); ?>

