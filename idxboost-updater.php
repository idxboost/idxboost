<?php
/**
 * IDXBoost GitHub Updater
 * 
 * Handles automatic updates from GitHub releases
 */

class IDXBoostUpdater
{
    protected $file;
    protected $plugin;
    protected $basename;
    protected $active;
    private $username;
    private $repository;
    private $authorize_token;
    private $github_response;

    public function __construct($file)
    {
        $this->file = $file;
        $this->basename = plugin_basename($this->file);
        
        add_action('admin_init', [$this, 'set_plugin_properties']);
    }

    public function set_plugin_properties()
    {
        $this->plugin = get_plugin_data($this->file);
        $this->active = is_plugin_active($this->basename);
    }

    public function set_username($username)
    {
        $this->username = sanitize_text_field($username);
    }

    public function set_repository($repository)
    {
        $this->repository = sanitize_text_field($repository);
    }

    public function authorize($token)
    {
        $this->authorize_token = base64_decode($token);
    }

    /**
     * Determina si debemos usar caché o forzar una verificación nueva
     */
    private function should_use_cache()
    {
        // No usar caché si es WP-CLI
        if (defined('WP_CLI') && WP_CLI) {
            return false;
        }
        
        // No usar caché si es un force check del dashboard
        if (isset($_GET['force-check'])) {
            return false;
        }
        
        // No usar caché si estamos en la página de updates y se limpió el transient
        global $pagenow;
        if ($pagenow === 'update-core.php' && !get_site_transient('update_plugins')) {
            return false;
        }
        
        return true;
    }

    /**
     * Obtiene información del repositorio desde GitHub
     */
    private function get_repository_info()
    {
        if (is_null($this->github_response)) {
            $cache_key = 'github_update_' . md5($this->username . $this->repository);
            
            // Intentar obtener de caché si corresponde
            if ($this->should_use_cache()) {
                $cached = get_transient($cache_key);
                if ($cached !== false) {
                    $this->github_response = $cached;
                    return;
                }
            } else {
                // Si no debemos usar caché, limpiarlo
                delete_transient($cache_key);
            }

            // Construir URL de la API de GitHub
            $request_uri = sprintf(
                'https://api.github.com/repos/%s/%s/releases/latest',
                $this->username,
                $this->repository
            );

            // Configurar argumentos del request
            $args = [
                'timeout' => 10,
                'headers' => [
                    'Accept' => 'application/vnd.github.v3+json'
                ]
            ];

            // Agregar autorización si existe token
            if ($this->authorize_token) {
                $args['headers']['Authorization'] = 'Bearer ' . $this->authorize_token;
            }

            // Hacer request a GitHub
            $response = wp_remote_get($request_uri, $args);

            // Validar respuesta
            if (is_wp_error($response)) {
                error_log('IDXBoost Updater - GitHub API Error: ' . $response->get_error_message());
                return;
            }

            $response_code = wp_remote_retrieve_response_code($response);
            if ($response_code !== 200) {
                error_log("IDXBoost Updater - GitHub API returned code: {$response_code}");
                return;
            }

            $body = wp_remote_retrieve_body($response);
            $data = json_decode($body, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                error_log('IDXBoost Updater - JSON decode error: ' . json_last_error_msg());
                return;
            }

            // Validar que tenemos los datos necesarios
            if (!isset($data['tag_name']) || !isset($data['zipball_url'])) {
                error_log('IDXBoost Updater - Invalid response structure from GitHub');
                return;
            }

            // Guardar en caché por 12 horas
            set_transient($cache_key, $data, 12 * HOUR_IN_SECONDS);
            $this->github_response = $data;
        }
    }

    /**
     * Inicializa los hooks del updater
     */
    public function initialize()
    {
        add_filter('pre_set_site_transient_update_plugins', [$this, 'modify_transient'], 10, 1);
        add_filter('plugins_api', [$this, 'plugin_popup'], 10, 3);
        add_filter('upgrader_post_install', [$this, 'after_install'], 10, 3);
        
        // Limpiar caché cuando se fuerza el chequeo desde el dashboard
        add_action('load-update-core.php', [$this, 'clear_cache']);
    }

    /**
     * Limpia el caché cuando se fuerza verificación de updates
     */
    public function clear_cache()
    {
        if (isset($_GET['force-check']) || !get_site_transient('update_plugins')) {
            $cache_key = 'github_update_' . md5($this->username . $this->repository);
            delete_transient($cache_key);
        }
    }

    /**
     * Modifica el transient de WordPress para agregar nuestro plugin si hay actualización
     */
    public function modify_transient($transient)
    {
        // Validaciones tempranas
        if (!is_object($transient)) {
            return $transient;
        }

        if (!property_exists($transient, 'checked') || !is_array($transient->checked)) {
            return $transient;
        }

        if (empty($transient->checked)) {
            return $transient;
        }

        // Verificar que basename existe
        if (empty($this->basename)) {
            return $transient;
        }

        // Verificar que el plugin está en la lista de plugins chequeados
        if (!isset($transient->checked[$this->basename])) {
            return $transient;
        }

        $this->get_repository_info();

        // Verificar que obtuvimos respuesta válida de GitHub
        if (!is_array($this->github_response) || 
            !isset($this->github_response['tag_name']) || 
            !isset($this->github_response['zipball_url'])) {
            return $transient;
        }

        $current_version = $transient->checked[$this->basename];
        $remote_version = ltrim($this->github_response['tag_name'], 'v');

        // Validar que las versiones no estén vacías
        if (empty($current_version) || empty($remote_version)) {
            return $transient;
        }

        // Comparar versiones
        if (version_compare($remote_version, $current_version, '>')) {
            $slug = dirname($this->basename);
            
            // Validar que el slug no esté vacío
            if (empty($slug) || $slug === '.') {
                $slug = basename(dirname($this->file));
            }

            // Asegurar que tenemos la información del plugin
            if (empty($this->plugin)) {
                $this->plugin = get_plugin_data($this->file);
            }

            $plugin = [
                'url' => $this->plugin['PluginURI'] ?? '',
                'slug' => $slug,
                'package' => $this->github_response['zipball_url'],
                'new_version' => $remote_version,
                'tested' => get_bloginfo('version'),
                'requires_php' => '7.4'
            ];

            $transient->response[$this->basename] = (object) $plugin;
        }

        return $transient;
    }

    /**
     * Muestra el popup con información del plugin cuando se hace clic en "View details"
     */
    public function plugin_popup($result, $action, $args)
    {
        if (!isset($args->slug) || $args->slug != dirname($this->basename)) {
            return $result;
        }

        $this->get_repository_info();

        // Verificar que tenemos respuesta válida
        if (!is_array($this->github_response)) {
            return $result;
        }

        // Asegurar que tenemos la información del plugin
        if (empty($this->plugin)) {
            $this->plugin = get_plugin_data($this->file);
        }

        $plugin = [
            'name' => $this->plugin['Name'] ?? 'IDXBoost',
            'slug' => $this->basename,
            'version' => ltrim($this->github_response['tag_name'] ?? '1.0.0', 'v'),
            'author' => $this->plugin['AuthorName'] ?? $this->plugin['Author'] ?? '',
            'author_profile' => $this->plugin['AuthorURI'] ?? '',
            'last_updated' => $this->github_response['published_at'] ?? '',
            'homepage' => $this->plugin['PluginURI'] ?? '',
            'short_description' => $this->plugin['Description'] ?? '',
            'sections' => [
                'Description' => $this->plugin['Description'] ?? '',
                'Updates' => $this->parse_changelog($this->github_response['body'] ?? '')
            ],
            'download_link' => $this->github_response['zipball_url'] ?? ''
        ];

        return (object) $plugin;
    }

    /**
     * Parsea el changelog desde markdown a HTML
     */
    private function parse_changelog($body)
    {
        if (class_exists('Parsedown')) {
            return Parsedown::instance()->parse($body);
        }
        return nl2br(esc_html($body));
    }

    /**
     * Se ejecuta después de instalar la actualización
     */
    public function after_install($response, $hook_extra, $result)
    {
        global $wp_filesystem;

        $install_directory = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . dirname($this->basename);
        
        // Verificar que el directorio destino no esté vacío
        if (empty($install_directory) || $install_directory === WP_PLUGIN_DIR . DIRECTORY_SEPARATOR) {
            return $response;
        }

        // Limpiar memoria antes de mover archivos
        if (function_exists('gc_collect_cycles')) {
            gc_collect_cycles();
        }

        $wp_filesystem->move($result['destination'], $install_directory);
        $result['destination'] = $install_directory;

        // Limpiar caché
        $cache_key = 'github_update_' . md5($this->username . $this->repository);
        delete_transient($cache_key);

        if ($this->active) {
            activate_plugin($this->basename);
        }

        return $result;
    }

    /**
     * Método para verificar actualizaciones desde WP-CLI
     */
    public function cli_check_update()
    {
        // Limpiar cachés
        $cache_key = 'github_update_' . md5($this->username . $this->repository);
        delete_transient($cache_key);
        delete_site_transient('update_plugins');
        
        // Forzar verificación
        $this->get_repository_info();
        
        if (!is_array($this->github_response)) {
            return ['error' => 'Could not fetch update information from GitHub'];
        }
        
        $current_version = get_plugin_data($this->file)['Version'];
        $remote_version = ltrim($this->github_response['tag_name'] ?? '', 'v');
        
        return [
            'current' => $current_version,
            'latest' => $remote_version,
            'update_available' => version_compare($remote_version, $current_version, '>'),
            'release_url' => $this->github_response['html_url'] ?? '',
            'published_at' => $this->github_response['published_at'] ?? ''
        ];
    }
}

// Inicializar el updater (solo en admin y WP-CLI)
if (is_admin() || (defined('WP_CLI') && WP_CLI)) {
    $IDXBoostUpdater = new IDXBoostUpdater(__FILE__);
    $IDXBoostUpdater->set_username('idxboost');
    $IDXBoostUpdater->set_repository('idxboost');
    // Solo si es repositorio privado:
    // $IDXBoostUpdater->authorize('TU_TOKEN_BASE64');
    $IDXBoostUpdater->initialize();
}

// Comando WP-CLI personalizado
if (defined('WP_CLI') && WP_CLI) {
    WP_CLI::add_command('idxboost check-update', function() use ($IDXBoostUpdater) {
        WP_CLI::log('Checking for IDXBoost updates...');
        
        $result = $IDXBoostUpdater->cli_check_update();
        
        if (isset($result['error'])) {
            WP_CLI::error($result['error']);
            return;
        }
        
        WP_CLI::log('');
        WP_CLI::log('Current version: ' . $result['current']);
        WP_CLI::log('Latest version:  ' . $result['latest']);
        
        if ($result['update_available']) {
            WP_CLI::success('Update available!');
            WP_CLI::log('');
            WP_CLI::log('To update, run:');
            WP_CLI::log('  wp plugin update idxboost');
            
            if (!empty($result['release_url'])) {
                WP_CLI::log('');
                WP_CLI::log('Release notes: ' . $result['release_url']);
            }
        } else {
            WP_CLI::success('Plugin is up to date!');
        }
    });
}
