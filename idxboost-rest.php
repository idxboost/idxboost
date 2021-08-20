<?php

class IDXBoost_REST_API_Endpoints
{
    const API_NAMESPACE = 'idx-boost';
    const API_VERSION = 'v1';
    const API_CREATE_USER_ENDPOINT = '/users';
    const API_ADD_REGISTRATION_KEY = '/reg-key';
    const API_GET_POST = '/posts';
    const API_GET_CATEGORIES = '/categories';
    const API_ADD_PAGES = '/add_page';
    const API_EDIT_PAGES = '/edit_page';
    const API_DELETE_PAGES = '/delete_page';
    const API_REPLACE_FAVICON = '/replace_favicon';
    // const API_SETUP_AGENT_INITIAL_DATA = '/agents/setup/1';
    // const API_SETUP_AGENT_EXTRA_DATA = '/agents/setup/2';

    public static function registerEndpoints()
    {
        $dns_api_rest_name_version = implode('/', [self::API_NAMESPACE, self::API_VERSION]);

        register_rest_route($dns_api_rest_name_version, self::API_CREATE_USER_ENDPOINT, array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => ['IDXBoost_REST_API_Endpoints', 'createUser']
        ));


        register_rest_route($dns_api_rest_name_version, self::API_ADD_REGISTRATION_KEY, array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => ['IDXBoost_REST_API_Endpoints', 'addRegKey']
        ));

        register_rest_route($dns_api_rest_name_version, self::API_GET_POST, array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => ['IDXBoost_REST_API_Endpoints', 'getPost']
        ));
        register_rest_route($dns_api_rest_name_version, self::API_GET_CATEGORIES, array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => ['IDXBoost_REST_API_Endpoints', 'getCategories']
        ));

        register_rest_route($dns_api_rest_name_version, self::API_ADD_PAGES, array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => ['IDXBoost_REST_API_Endpoints', 'addPage']
        ));
        register_rest_route($dns_api_rest_name_version, self::API_EDIT_PAGES, array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => ['IDXBoost_REST_API_Endpoints', 'editPage']
        ));
        register_rest_route($dns_api_rest_name_version, self::API_DELETE_PAGES, array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => ['IDXBoost_REST_API_Endpoints', 'deletePage']
        ));
        register_rest_route($dns_api_rest_name_version, self::API_REPLACE_FAVICON, array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => ['IDXBoost_REST_API_Endpoints', 'replaceFavicon']
        ));

        // register_rest_route($dns_api_rest_name_version, self::API_SETUP_AGENT_INITIAL_DATA, array(
        // 	'methods' => WP_REST_Server::CREATABLE,
        // 	'callback' => ['IDXBoost_REST_API_Endpoints', 'setupInitialData']
        // ));
        //
        // register_rest_route($dns_api_rest_name_version, self::API_SETUP_AGENT_EXTRA_DATA, array(
        // 	'methods' => WP_REST_Server::CREATABLE,
        // 	'callback' => ['IDXBoost_REST_API_Endpoints', 'setupExtraData']
        // ));
    }

    public static function getCategories(WP_REST_Request $request)
    {
        $reg_key = $_POST["reg-key"];
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
        $reg_key = $_POST["reg-key"];
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
                if (isset($_POST["category"])) {
                    $args['category'] = ($_POST["category"]);
                }
                $args['numberposts'] = 10;
                if (isset($_POST["size"])) {
                    $args['numberposts'] = ($_POST["size"]);
                }
                $posts = get_posts($args);
                $response_posts = array();
                foreach ($posts as $post) {
                    $excerpt = get_the_excerpt($post);
                    $excerpt = $excerpt != "" ? $excerpt : mb_strimwidth(wp_trim_excerpt('', $post), 0, 100, '...');
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
        $reg_key = $_POST["reg-key"];
        $install_url = $_POST["install-url"];
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
                if (get_option("idxboost_registration_key") == "") {
                    update_option("idxboost_registration_key", $reg_key);
                    $response = [
                        'status' => '200',
                        'message' => "OK"
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
        $reg_key = $_POST["reg_key"];
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
        $reg_key = $_POST["reg_key"];
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
        $reg_key = $_POST["reg_key"];
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
        $ib_rest_token = filter_input(INPUT_POST, 'ib_rest_token', FILTER_SANITIZE_STRING);
        $email_address = filter_input(INPUT_POST, 'email_address', FILTER_SANITIZE_STRING);

        $ib_blogname = filter_input(INPUT_POST, 'ib_blogname', FILTER_SANITIZE_STRING);
        $ib_blogdescription = filter_input(INPUT_POST, 'ib_blogdescription', FILTER_SANITIZE_STRING);
        $ib_admin_email = $email_address;
        $ib_registration_key = filter_input(INPUT_POST, 'ib_registration_key', FILTER_SANITIZE_STRING);
        $ib_agent_info = isset($_POST["ib_agent_info"]) ? $_POST["ib_agent_info"] : "";
        $ib_pusher_settings = isset($_POST["ib_pusher_settings"]) ? $_POST["ib_pusher_settings"] : "";
        $ib_search_settings = isset($_POST["ib_search_settings"]) ? $_POST["ib_search_settings"] : "";

        if (false === is_email($email_address)) {
            $response = [
                'error' => 'email_not_valid',
                'message' => 'The email parameter has no a valid format.'
            ];

            return new WP_REST_Response($response);
        }

        if (false === username_exists($email_address)) {
            $password = wp_generate_password(20, true, true);
            $user_id = wp_create_user($email_address, $password, $email_address);

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

            update_option("blogname", $ib_blogname);
            update_option("blogdescription", $ib_blogdescription);
            update_option("admin_email", $ib_admin_email);

            update_option("idxboost_registration_key", $ib_registration_key);

            update_option("idxboost_agent_info", $ib_agent_info);
            update_option("idxboost_pusher_settings", $ib_pusher_settings);
            update_option("idxboost_search_settings", $ib_search_settings);

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
        $reg_key = $_POST["reg_key"];

        if ( ! $reg_key ) {
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
            $favicon = $_POST["favicon"];
            $favicon = str_replace('\\', '', $favicon);
            update_option('favicon', basename($favicon));
            file_put_contents(str_replace('/wp-content/themes', '', get_theme_root()) . "/" . basename($favicon), file_get_contents($favicon));
        }

        return new WP_REST_Response($response);
    }

    /*
      public static function setupInitialData(WP_REST_Request $request)
      {
      $ib_rest_token = filter_input(INPUT_POST, 'ib_rest_token', FILTER_SANITIZE_STRING);
      $email_address = filter_input(INPUT_POST, 'email_address', FILTER_SANITIZE_STRING);
      $response = [];

      if (!empty($ib_rest_token)) {
        $url = 'http://api.flexidx.l/rest-json/agents/setup/1';

            $call_request = wp_remote_post($url, [
                'method' => 'POST',
                'timeout' => 60,
                'body' => ['ib_rest_token' => $ib_rest_token]
            ]);

            if (is_wp_error($call_request)) {
                $error_codes = $call_request->get_error_codes();
                $error_messages = $call_request->get_error_messages();
                $response = ['error_codes' => $error_codes, 'error_messages' => $error_messages];
            } else {
                $response = isset($call_request['body']) ? json_decode($call_request['body']) : null;
          $output = [];

          if (isset($response['success']) && (true === $response['success'])) {
             // setting up initial configuration
             if (isset($response['blogname'])) {
               update_option('blogname', $response['blogname']);
             }
             if (isset($response['blogdescription'])) {
               update_option('blogdescription', $response['blogdescription']);
             }
             if (isset($response['admin_email'])) {
               update_option('admin_email', $response['admin_email']);
             }
             if (isset($response['idxboost_registration_key'])) {
               update_option('idxboost_registration_key', $response['idxboost_registration_key']);
             }

              // creating the user as administrator
              if (false === is_email($email_address)) {
                      $response = [
                          'error' => 'email_not_valid',
                          'message' => 'The email parameter has no a valid format.'
                      ];

                      return new WP_REST_Response($response);
                  }

                  if (false === username_exists($email_address)) {
                      $password = wp_generate_password( 20, true, true );
                      $user_id = wp_create_user( $email_address, $password, $email_address );

                      // if ($user_id instanceof WP_Error) {
                      if (is_wp_error($user_id)) {
                          $response =  [
                              'error' => $user_id->get_error_codes(),
                              'message' => $user_id->get_error_messages()
                          ];
                      } else {
                          $user = new WP_User($user_id);
                          $user->set_role('administrator');

                  $output['username_password'] = $password;
                  $response = $output;
                      }

                      return new WP_REST_Response($response);
                  } else {
                      $response = [
                          'error_code' => 'existing_user_login',
                          'error_message' => 'Sorry, that username already exists!'
                      ];

                      return new WP_REST_Response($response);
                  }
          }
            }
      }

          return new WP_REST_Response($response, 200);
      }
      */

    /*
      public static function setupExtraData(WP_REST_Request $request)
      {
          $ib_rest_token = filter_input(INPUT_POST, 'ib_rest_token', FILTER_SANITIZE_STRING);
      $response = [];

      if (!empty($ib_rest_token)) {
        $url = 'http://api.flexidx.l/rest-json/agents/setup/2';

            $call_request = wp_remote_post($url, [
                'method' => 'POST',
                'timeout' => 60,
                'body' => ['ib_rest_token' => $ib_rest_token]
            ]);

            if (is_wp_error($call_request)) {
                $error_codes = $call_request->get_error_codes();
                $error_messages = $call_request->get_error_messages();
                $response = ['error_codes' => $error_codes, 'error_messages' => $error_messages];
            } else {
                $response = isset($call_request['body']) ? json_decode($call_request['body']) : null;

          if (isset($response['success']) && (true === $response['success'])) {

          }
            }
      }

          return new WP_REST_Response($response, 200);
      }
      */
}

# Domain: https://demo.idxboost.com
# REST Base URL: /wp-json
# REST Namespace: /idx-boost/v1

# /users      Creates a new administrator user on wordpress installation.
# /agents/setup/1    Synchronize Initial Data (first name, last name, phone number, email, Address, City, State, Zip Code) [Importing Default (Pages [About,Contact,Building Group  Pages], Menu, IDX Boost Pages, Filter Pages, Building Pages)]
# /agents/setup/2    Synchronize Extra Data (email display, phone display, address, city, state, zip, social networks [6], bio, welcome, agent photo, agent logo [title,headline], broker logo [broker website logo url] )

# 200 (OK)
# 201 (Created)
# 400 (Bad Request)
# 403 (Forbidden)
