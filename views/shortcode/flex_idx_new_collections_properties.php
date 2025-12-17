<?php 
if (false === $GLOBALS['flex_idx_lead']): ?>
<style>
  .flex-not-logged-in-msg {}
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
<div class="gwr flex-not-logged-in-msg">
  <p><?php echo __("You need to", IDXBOOST_DOMAIN_THEME_LANG); ?> <a class="flex-login-link" role="button"><?php echo __("login", IDXBOOST_DOMAIN_THEME_LANG); ?></a> <?php echo __("to view this page.", IDXBOOST_DOMAIN_THEME_LANG); ?></p>
</div>
    <script>
        (function() {
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

                            // Usamos un pequeño retardo para asegurar que el modal
                            // del plugin se haya inicializado ANTES de interactuar con él.
                            setTimeout(() => {
                                // 3a. Click en el enlace de login para abrir el modal
                                const loginLink = document.querySelector(LOGIN_LINK_SELECTOR);
                                if (loginLink) {
                                    loginLink.click();
                                    console.log("Modal de Login disparado.");
                                } else {
                                    console.error("Enlace de login no encontrado.");
                                    return;
                                }

                                // 3b. Rellenar el campo de email (si se encontró uno)
                                if (prefillEmail) {
                                    // Buscamos el campo de email dentro del DOM
                                    const emailInput = document.querySelector(EMAIL_INPUT_SELECTOR);

                                    if (emailInput) {
                                        emailInput.value = prefillEmail;
                                        console.log(`Email rellenado: ${prefillEmail}`);

                                        // Disparar eventos 'input' o 'change' para que el
                                        // plugin sepa que el campo ha sido modificado (importante)
                                        emailInput.dispatchEvent(new Event('input', { bubbles: true }));
                                        emailInput.dispatchEvent(new Event('change', { bubbles: true }));

                                    } else {
                                        console.warn(`Campo de email con selector ${EMAIL_INPUT_SELECTOR} no encontrado.`);
                                    }
                                }
                            }, 500); // Se aumenta el retardo a 500ms para asegurar la carga del modal Y la respuesta AJAX.

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

<?php else: ?>
<script>
	// window.idxtoken = "<?php echo $access_token_service; ?>";
	window.idx_collections_settings = {
		client_type: "lead",
		collections_path: "collections",
		detail_path: "collection"
	}
</script>

<div id="collections" class="<?php echo $flex_idx_lead ?>"></div>

<?php endif; ?>