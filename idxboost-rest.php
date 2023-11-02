<?php

class IDXBoost_REST_API_Endpoints
{
    const API_NAMESPACE = 'idx-boost';
    const API_VERSION = 'v1';
    const API_ADD_REGISTRATION_KEY = '/reg-key';
    const API_CREATE_USER_ENDPOINT = '/users';
    const API_GET_POST = '/posts';
    const API_GET_CATEGORIES = '/categories';
    const API_ADD_PAGES = '/add_page';
    const API_EDIT_PAGES = '/edit_page';
    const API_DELETE_PAGES = '/delete_page';
    const API_REPLACE_FAVICON = '/replace_favicon';

    public static function registerEndpoints()
    {
        $dns_api_rest_name_version = implode('/', [self::API_NAMESPACE, self::API_VERSION]);

        register_rest_route($dns_api_rest_name_version, self::API_CREATE_USER_ENDPOINT, array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => ['IDXBoost_REST_API_Endpoints', 'createUser'],
            'permission_callback' => ['IDXBoost_REST_API_Endpoints', 'loginJWT']
        ));

        register_rest_route($dns_api_rest_name_version, self::API_ADD_REGISTRATION_KEY, array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => ['IDXBoost_REST_API_Endpoints', 'addRegKey'],
            'permission_callback' => ['IDXBoost_REST_API_Endpoints', 'loginJWT']
        ));

        register_rest_route($dns_api_rest_name_version, self::API_GET_POST, array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => ['IDXBoost_REST_API_Endpoints', 'getPost'],
            'permission_callback' => ['IDXBoost_REST_API_Endpoints', 'loginJWT']
        ));

        register_rest_route($dns_api_rest_name_version, self::API_GET_CATEGORIES, array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => ['IDXBoost_REST_API_Endpoints', 'getCategories'],
            'permission_callback' => ['IDXBoost_REST_API_Endpoints', 'loginJWT']
        ));

        register_rest_route($dns_api_rest_name_version, self::API_ADD_PAGES, array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => ['IDXBoost_REST_API_Endpoints', 'addPage'],
            'permission_callback' => ['IDXBoost_REST_API_Endpoints', 'loginJWT']
        ));

        register_rest_route($dns_api_rest_name_version, self::API_EDIT_PAGES, array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => ['IDXBoost_REST_API_Endpoints', 'editPage'],
            'permission_callback' => ['IDXBoost_REST_API_Endpoints', 'loginJWT']
        ));

        register_rest_route($dns_api_rest_name_version, self::API_DELETE_PAGES, array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => ['IDXBoost_REST_API_Endpoints', 'deletePage'],
            'permission_callback' => ['IDXBoost_REST_API_Endpoints', 'loginJWT']
        ));

        register_rest_route($dns_api_rest_name_version, self::API_REPLACE_FAVICON, array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => ['IDXBoost_REST_API_Endpoints', 'replaceFavicon'],
            'permission_callback' => ['IDXBoost_REST_API_Endpoints', 'loginJWT']
        ));
    }

    public static function loginJWT(WP_REST_Request $request)
    {
        include_once "inc/JWT.php";
        $token = $_POST['token'];
        try {
            $publicKey = <<<EOD
            -----BEGIN PUBLIC KEY-----
            MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAqm51yO1oSyAjOewYALny
            8N/5t+A86o6fStraWZkKHE3BlWIKSz+U4WQzR8lR9H+3P7tbWLcrbvuFhDRwiSzV
            3BNbMTtlaGteKY+u3CEXdUlw+ngrEWwL/jYMNrKm2ehJSRr94bPkBMAJiXUW9+cT
            vRiIy7ruFNn0UNFIukezwweGViySuy8N2aF09ZpXvKAH1VDkg1lOpT4bOJ4IwVjt
            wQ/a3qf0xV2mQKp6k4jVLynKTEMKNYeLDDGtb+WjV2DRstHJofrfACKrsVFhAVRV
            HgWOmCqqXRvB9hkLsf8dPuec15c1BnmLcMuAiDA5nR4yET/TQY+Voi1fI4JKfyhv
            lQIDAQAB
            -----END PUBLIC KEY-----
            EOD;
            $decoded = JWT::decode($token, $publicKey, array('RS512'));
            $decoded_array = (array)$decoded;
            $issuedAt = new DateTimeImmutable();
            if ($decoded_array['exp'] >= $issuedAt->getTimestamp()) {
                return true;
            }
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    public static function getCategories(WP_REST_Request $request)
    {
        $reg_key = $_POST['reg-key'];
        $response = [];

        if (!$reg_key) {
            $response = [
                'status' => '400',
                'message' => 'Bad Request',
                'data' => []
            ];
        } else {
            if (get_option('idxboost_registration_key') != $reg_key) {
                $response = [
                    'status' => '403',
                    'message' => 'Forbidden',
                    'data' => []
                ];
            } else {
                $categories = get_categories(array(
                    'orderby' => 'name',
                    'order' => 'ASC'
                ));

                $response = [
                    'status' => '200',
                    'message' => 'Ok',
                    'data' => $categories
                ];
            }
        }
        return new WP_REST_Response($response);
    }

    public static function getPost(WP_REST_Request $request)
    {
        $reg_key = $_POST['reg-key'];
        $response = [];

        if (!$reg_key) {
            $response = [
                'status' => '400',
                'message' => 'Bad Request',
                'data' => []
            ];
        } else {
            if (get_option('idxboost_registration_key') != $reg_key) {
                $response = [
                    'status' => '403',
                    'message' => 'Forbidden',
                    'data' => []
                ];
            } else {
                $args = array(
                    'post_status' => array('publish'),
                );

                if (isset($_POST['category'])) {
                    $args['category'] = ($_POST['category']);
                }

                $args['numberposts'] = 10;

                if (isset($_POST['size'])) {
                    $args['numberposts'] = ($_POST['size']);
                }

                $posts = get_posts($args);
                $response_posts = array();

                foreach ($posts as $post) {
                    $excerpt = get_the_excerpt($post);
                    $excerpt = $excerpt != '' ? $excerpt : mb_strimwidth(wp_trim_excerpt('', $post), 0, 100, '...');
                    $excerpt = str_replace('[&hellip;]', '...', $excerpt);
                    $response_posts[] = array(
                        'id' => $post->ID,
                        'post_title' => $post->post_title,
                        'post_excerpt' => $excerpt,
                        'post_date' => $post->post_date,
                        'post_content' => $post->post_content,
                        'permalink' => get_permalink($post),
                        'image' => get_the_post_thumbnail_url($post),
                    );
                }

                $response = [
                    'status' => '200',
                    'message' => 'OK',
                    'data' => $response_posts
                ];
            }
        }

        return new WP_REST_Response($response);
    }

    public static function addRegKey(WP_REST_Request $request)
    {
        $reg_key = $_POST['reg-key'];
        $install_url = $_POST['install-url'];

        if (!$reg_key || !$install_url) {
            $response = [
                'status' => '400',
                'message' => 'Bad Request'
            ];
        } else {
            if (get_option('siteurl') != $install_url) {
                $response = [
                    'status' => '404',
                    'message' => 'Website url not found'
                ];
            } else {
                if (get_option('idxboost_registration_key') == '') {
                    update_option('idxboost_registration_key', $reg_key);
                    $response = [
                        'status' => '200',
                        'message' => 'OK'
                    ];
                } else {
                    $response = [
                        'status' => '406',
                        'message' => 'Not Acceptable'
                    ];
                }
            }
        }

        return new WP_REST_Response($response);
    }

    public static function addPage(WP_REST_Request $request)
    {
        $reg_key = $_POST['reg_key'];

        if (!$reg_key) {
            $response = [
                'status' => '400',
                'message' => 'Bad Request'
            ];
        } else {
            if (get_option('idxboost_registration_key') != $reg_key) {
                $response = [
                    'status' => '403',
                    'message' => 'Forbidden',
                    'data' => []
                ];
            } else {
                $my_post = array(
                    'post_title' => $_POST['post_title'],
                    'post_content' => '',
                    'post_status' => 'publish',
                    'post_author' => 1,
                    'post_type' => 'page'
                );

                $postId = wp_insert_post($my_post);
                $post = get_post($postId);

                add_post_meta($postId, 'idx_page_type', $_POST['page_type']);
                add_post_meta($postId, 'idx_page_id', $_POST['page_id']);

                $response = [
                    'status' => '200',
                    'message' => 'OK',
                    'data' => ['post_id' => $postId, 'post_name' => $post->post_name, 'permalink' => get_permalink($post->ID)]
                ];
            }
        }
        return new WP_REST_Response($response);
    }

    public static function editPage(WP_REST_Request $request)
    {
        $reg_key = $_POST['reg_key'];

        if (!$reg_key) {
            $response = [
                'status' => '400',
                'message' => 'Bad Request'
            ];
        } else {
            if (get_option('idxboost_registration_key') != $reg_key) {
                $response = [
                    'status' => '403',
                    'message' => 'Forbidden',
                    'data' => []
                ];
            } else {
                $my_post = array(
                    'ID' => $_POST['post_id'],
                    'post_title' => $_POST['post_title']
                );

                wp_update_post($my_post);

                $post = get_post($_POST['post_id']);

                $response = [
                    'status' => '200',
                    'message' => 'OK',
                    'data' => ['post_id' => $_POST['post_id'], 'post_name' => $post->post_name, 'permalink' => get_permalink($post->ID)]
                ];
            }
        }
        return new WP_REST_Response($response);
    }

    public static function deletePage(WP_REST_Request $request)
    {
        $reg_key = $_POST['reg_key'];

        if (!$reg_key) {
            $response = [
                'status' => '400',
                'message' => 'Bad Request'
            ];
        } else {
            if (get_option('idxboost_registration_key') != $reg_key) {
                $response = [
                    'status' => '403',
                    'message' => 'Forbidden',
                    'data' => []
                ];
            } else {
                wp_delete_post($_POST['post_id'], true);
                $response = [
                    'status' => '200',
                    'message' => 'OK',
                ];
            }
        }
        return new WP_REST_Response($response);
    }

    public static function createUser(WP_REST_Request $request)
    {
        $email_address       = filter_input(INPUT_POST, 'email_address', FILTER_SANITIZE_STRING);
        $ib_blogname         = filter_input(INPUT_POST, 'ib_blogname', FILTER_SANITIZE_STRING);
        $ib_blogdescription  = filter_input(INPUT_POST, 'ib_blogdescription', FILTER_SANITIZE_STRING);
        $ib_registration_key = filter_input(INPUT_POST, 'ib_registration_key', FILTER_SANITIZE_STRING);
        $ib_agent_info       = isset($_POST['ib_agent_info']) ? $_POST['ib_agent_info'] : '';
        $ib_pusher_settings  = isset($_POST['ib_pusher_settings']) ? $_POST['ib_pusher_settings'] : '';
        $ib_search_settings  = isset($_POST['ib_search_settings']) ? $_POST['ib_search_settings'] : '';
        $ib_admin_email      = $email_address;

        if (false === is_email($email_address)) {
            $response = [
                'error' => 'email_not_valid',
                'message' => 'The email parameter has no a valid format.'
            ];

            return new WP_REST_Response($response);
        }

        if (false === username_exists($email_address)) {
            $password = wp_generate_password(20, true, true);
            $user_id  = wp_create_user($email_address, $password, $email_address);

            if (is_wp_error($user_id)) {
                $response = [
                    'error' => $user_id->get_error_codes(),
                    'message' => $user_id->get_error_messages()
                ];
            } else {
                $user = new WP_User($user_id);
                $user->set_role('administrator');

                $response = [
                    'user_id' => $user_id,
                    'username' => $email_address,
                    'password' => $password
                ];
            }

            update_option('blogname', $ib_blogname);
            update_option('blogdescription', $ib_blogdescription);
            update_option('admin_email', $ib_admin_email);
            update_option('idxboost_registration_key', $ib_registration_key);
            update_option('idxboost_agent_info', $ib_agent_info);
            update_option('idxboost_pusher_settings', $ib_pusher_settings);
            update_option('idxboost_search_settings', $ib_search_settings);

            // flush access token
            delete_transient('flex_api_access_token');
            flex_idx_get_access_token();

            return new WP_REST_Response($response);
        } else {
            $response = [
                'error_code' => 'existing_user_login',
                'error_message' => 'Sorry, that username already exists!'
            ];

            return new WP_REST_Response($response);
        }
    }

    public static function replaceFavicon(WP_REST_Request $request)
    {
        $reg_key = $_POST['reg_key'];

        if (!$reg_key) {
            $response = [
                'status' => '400',
                'message' => 'Bad Request',
                'data' => []
            ];
        } else {
            $response = [
                'status' => '200',
                'message' => 'OK',
                'data' => []
            ];

            $favicon = $_POST['favicon'];

            if ($favicon == '') {
                $favicon = get_option('favicon');
                $file = str_replace('/wp-content/themes', '', get_theme_root()) . '/' . $favicon;

                unlink($file);
            } else {
                $favicon_old = get_option('favicon');

                if ($favicon_old && basename($favicon) != $favicon) {
                    $file = str_replace('/wp-content/themes', '', get_theme_root()) . '/' . $favicon_old;
                    unlink($file);
                }

                $favicon = str_replace('\\', '', $favicon);

                update_option('favicon', basename($favicon));
                file_put_contents(str_replace('/wp-content/themes', '', get_theme_root()) . '/' . basename($favicon), file_get_contents($favicon));
            }
        }

        return new WP_REST_Response($response);
    }
}
