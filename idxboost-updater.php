<?php

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

    private function get_repository_info()
    {
        if (is_null($this->github_response)) {
            // Intentar obtener de caché primero
            $cache_key = 'github_update_' . md5($this->username . $this->repository);
            $cached = get_transient($cache_key);
            
            if ($cached !== false) {
                $this->github_response = $cached;
                return;
            }

            $request_uri = sprintf(
                'https://api.github.com/repos/%s/%s/releases/latest',
                $this->username,
                $this->repository
            );

            $args = [
                'timeout' => 10,
                'headers' => [
                    'Accept' => 'application/vnd.github.v3+json'
                ]
            ];

            if ($this->authorize_token) {
                $args['headers']['Authorization'] = 'Bearer ' . $this->authorize_token;
            }

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

    public function initialize()
    {
        add_filter('pre_set_site_transient_update_plugins', [$this, 'modify_transient'], 10, 1);
        add_filter('plugins_api', [$this, 'plugin_popup'], 10, 3);
        add_filter('upgrader_post_install', [$this, 'after_install'], 10, 3);
    }

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

    private function parse_changelog($body)
    {
        if (class_exists('Parsedown')) {
            return Parsedown::instance()->parse($body);
        }
        return nl2br(esc_html($body));
    }

    public function after_install($response, $hook_extra, $result)
    {
        global $wp_filesystem;

        $install_directory = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . dirname($this->basename);
        
        // Verificar que el directorio destino no esté vacío
        if (empty($install_directory) || $install_directory === WP_PLUGIN_DIR . DIRECTORY_SEPARATOR) {
            return $response;
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
}


