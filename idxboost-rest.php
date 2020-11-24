<?php

class IDXBoost_REST_API_Endpoints
{
	const API_NAMESPACE = 'idx-boost';
	const API_VERSION = 'v1';
	const API_CREATE_USER_ENDPOINT = '/users';
	// const API_SETUP_AGENT_INITIAL_DATA = '/agents/setup/1';
	// const API_SETUP_AGENT_EXTRA_DATA = '/agents/setup/2';

	public static function registerEndpoints()
	{
		$dns_api_rest_name_version = implode('/', [self::API_NAMESPACE, self::API_VERSION]);

		register_rest_route($dns_api_rest_name_version, self::API_CREATE_USER_ENDPOINT, array(
			'methods' => WP_REST_Server::CREATABLE,
			'callback' => ['IDXBoost_REST_API_Endpoints', 'createUser']
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
		$ib_search_settings =  isset($_POST["ib_search_settings"]) ? $_POST["ib_search_settings"] : "";

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

			if (is_wp_error($user_id)) {
				$response =  [
					'error' => $user_id->get_error_codes(),
					'message' => $user_id->get_error_messages()
				];
			} else {
				$user = new WP_User($user_id);
				$user->set_role('administrator');

				$response =  [
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
