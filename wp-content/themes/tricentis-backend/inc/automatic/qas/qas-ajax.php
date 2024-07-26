<?php
add_action('wp_ajax_nopriv_qas_get_option', 'qas_get_option');
add_action('wp_ajax_qas_get_option', 'qas_get_option');
function qas_get_option()
{
	global $_GET;
	$response = new stdClass();
	$action = \QAS\Utils::getArray('action', $_GET, '');
	$option = \QAS\Utils::getArray('option', $_GET, '');

	$value = get_option($option);
	if ($value != false) {
		$response->success = true;
		$response->option_name = $option;
		$response->option_value = $value;
	}
	else {
		$response->success = false;
	}
	die(wp_json_encode_cors_header($response));
}

add_action('wp_ajax_nopriv_qas_form_validate_user', 'qas_form_validate_user');
add_action('wp_ajax_qas_form_validate_user', 'qas_form_validate_user');

/**
 * This request callout to qTest to validate user email
 */
function qas_form_validate_user()
{
	global $_GET;
	$response = new stdClass();
	$errors = array();
	$valid = false;
	$message  = '';

	$action = \QAS\Utils::getArray('action', $_GET, '');
	check_ajax_referer( $action, 'security' );

	$field = \QAS\Utils::getArray('field', $_GET);
	$value = \QAS\Utils::getArray('value', $_GET);

	if (isset($field) && isset($value)) {
		$data[$field] = $value;

		$leadData['username'] = (isset($data['email'])) ? $data['email'] : '';
		$isFreeEmail = \QAS\Utils::isFreeEmail($leadData['username']);

		if ($isFreeEmail) {
			$valid = false;
			$message = 'Enter your valid business email address.';
		}
		else {
			$q = new \QAS\qTestConnector();
			$result = $q->validateUser($leadData);

			$httpCode = $result['http_code'];
			$decoded  = $result['decoded'];
			$valid    = ($httpCode == 200 || $decoded[0]['code'] == 1000);

			if (! $valid) {
				$message = $decoded[0]['message'];
			}
		}
	}

	$response = array(
		'value'     => $value,
		'valid'     => $valid,
		'message'   => $message
	);

	die(wp_json_encode_cors_header($response));
}

add_action('wp_ajax_nopriv_qas_form_validate_domain', 'qas_form_validate_domain');
add_action('wp_ajax_qas_form_validate_domain', 'qas_form_validate_domain');

/**
 * This request callout to qTest to validate user email
 */
function qas_form_validate_domain()
{
	global $_GET;
	$response = new stdClass();
	$errors = array();
	$valid = false;
	$code = 400;
	$message  = '';


	$field = \QAS\Utils::getArray('field', $_GET);
	$value = \QAS\Utils::getArray('value', $_GET);

	$field = sanitize_text_field( $field );
	$value = sanitize_text_field( $value );

	if (isset($field) && isset($value)) {
		$data[$field] = $value;

		$leadData['subdomain'] = (isset($data['subdomain'])) ? $data['subdomain'] : '';

		$q = new \QAS\qTestConnector();
		$result = $q->validateClient($leadData);

		if ( $result instanceof WP_Error ) {
			$message = $result->get_error_message();
			$code = 500;
		} else {
			$httpCode = $result['http_code'];
			$decoded = $result['decoded'];
			$valid = ( $httpCode == 200 || $decoded[0]['code'] == 1000 );

			$code = $decoded[0]['code'];

			if ( ! $valid ) {
				$message = $decoded[0]['message'];
			}
		}
	}

	$response = array(
		'value'     => $value,
		'valid'     => $valid,
		'message'   => $message,
		'code'   => $code
	);

	die(wp_json_encode_cors_header($response));
}

add_action('wp_ajax_nopriv_qas_form_signup_trial', 'qas_form_signup_trial');
add_action('wp_ajax_qas_form_signup_trial', 'qas_form_signup_trial');

/**
 * This request should be called if user submit form to download qTest eXplorer Standalone
 */
function qas_form_signup_trial()
{
	global $_POST;
	$response = new stdClass();
	$errors = array();

	if ('POST' != $_SERVER['REQUEST_METHOD']) {
		header('Allow: POST');
		header('HTTP/1.1 405 Method Not Allowed');
		header('Content-Type: text/plain');
		exit();
	}

	$leadData = \QAS\Utils::getArray('lead', $_POST, array());
	$leadData["demo"] = false;
	if (! isset($leadData["phone"])) {
		$leadData["phone"] = "";
	}
	if (! isset($leadData["campaignId"])) {
		$leadData["campaignId"] = "";
	}
	if (! isset($leadData["clusterId"])) {
		$leadData["clusterId"] = "1";
	}

	$qbeo = new \QAS\qbeoConnector();
	$qbeo->mktClientTrialInfo($leadData);

	$q = new \QAS\qTestConnector();
	$res = $q->clientTrial($leadData);

	$response = wp_json_encode_cors_header($res);

	die($response);
}

function generate_sso_url($name, $email)
{
	$zd_api_host = 'qas-help.zendesk.com';
	$sFullName = $name;
	$sEmail = $email;
	$sExternalID = "";
	$sOrganization = "";

	/* Insert the Autentication Token here */
	$sToken = "qN4RNm9E3YzelJlnqXtFWZPz7E4kG9ncYc95uYx0lkPrQPMM";
	// $sToken = 'DKXpeY6sTOJqlr26Dw2V7fTx70lgBQE7vEjI3Qi9OJPJBeWw';

	/* Insert your account prefix here. If your account is yoursite.zendesk.com: */
	$sUrlPrefix = "qas-help";

	/* Build the message */
	$sTimestamp = isset($_GET['timestamp']) ? $_GET['timestamp'] : time();

	$payload = array(
		"jti" => md5($sTimestamp . rand()),
		"iat" => $sTimestamp,
		"name" => $sFullName,
		"email" => $sEmail
	);

	$jwt = JWT::encode($payload, $sToken);
	$jwtDecoded = JWT::decode($jwt, $sToken);
	$sso_url = "{$zd_api_host}/access/jwt?jwt=" . $jwt;
	return $sso_url;
}

add_action('wp_ajax_nopriv_qas_sp_get_gravatar', 'qas_sp_get_gravatar');
add_action('wp_ajax_qas_sp_get_gravatar', 'qas_sp_get_gravatar');

function qas_sp_get_gravatar() {
	global $wpdb;
	$response = new stdClass();
	$errors = array();

	if ('GET' != $_SERVER['REQUEST_METHOD']) {
		header('Allow: POST');
		header('HTTP/1.1 405 Method Not Allowed');
		header('Content-Type: text/plain');
		exit();
	}

	$zdUserId = sanitize_text_field( \QAS\Utils::getArray('user_id', $_GET, '') );
	$query = "SELECT * FROM qas_zd_users WHERE qas_zd_id = '{$zdUserId}' LIMIT 0,5";
	$userQas = $wpdb->get_row($query, ARRAY_A);

	$resultObj = new stdClass();
	if (! is_null($userQas)) {
		$zdUserEmail = $userQas['email'];

		$resultObj->user_id = $zdUserId;
		$resultObj->user_hash = md5($zdUserEmail);;
	}
	else {
		$zd = new \QAS\zdConnector();
		$zdResult = $zd->showUser($zdUserId);
		if ( isset($zdResult->error) ) {
			$errors[] = array(
				'code' => $zdResult->error,
				'message' => $zdResult->description
			);
		}
		else {
			$zdUser = $zdResult->user;
			$zdUserEmail = $zdUser->email;
			$resultObj->user_id = $zdUserId;
			$resultObj->user_hash = md5($zdUserEmail);;
		}
	}

	if (empty($errors)) {
		$response->success = true;
		$response->user = $resultObj;
	} else {
		$response->success = false;
		$response->errors = $errors;
	}
	die(wp_json_encode_cors_header($response));
}

add_action('wp_ajax_nopriv_qas_sp_forgot_password', 'qas_sp_forgot_password');
add_action('wp_ajax_qas_sp_forgot_password', 'qas_sp_forgot_password');

function qas_sp_forgot_password()
{
	global $wpdb;
	$response = new stdClass();
	$errors = array();

	if ('POST' != $_SERVER['REQUEST_METHOD']) {
		header('Allow: POST');
		header('HTTP/1.1 405 Method Not Allowed');
		header('Content-Type: text/plain');
		exit();
	}

	$email = \QAS\Utils::getArray('email', $_POST, '');
	try {
		$zd = new \QAS\zdConnector();
		$user = $zd->listUserByEmail($email);
		$resultObj = null;
		if (! empty($user)) {
			$user_id = \QAS\Utils::getArray('id', $user);
			$user_name = \QAS\Utils::getArray('name', $user);
			$verified = \QAS\Utils::getArray('verified', $user);
			$last_login_at = \QAS\Utils::getArray('last_login_at', $user);

			$resultObj->id = $user_id;
			$resultObj->verified = $verified;
			$resultObj->last_login_at = $last_login_at;
			$resultObj->name = $user_name;
			$first_time_login = false;
			if ($verified == false || is_null($last_login_at)) {
				$first_time_login = true;
			}

			$user_qas_id = null;
			$query = "SELECT * FROM qas_zd_users WHERE email = '{$email}'";
			$userQas = $wpdb->get_row($query, ARRAY_A);

			if (is_null($userQas)) {
				$data = array(
					'name' => $user_name,
					'password' => wp_hash_password(wp_generate_password()),
					'email' => $email,
					'date_created' => \QAS\Utils::now(),
					'qas_zd_id' => $user_id
				);

				$num_inserted = $wpdb->insert('qas_zd_users', $data);
				if ($num_inserted > 0) {
					$user_qas_id = $wpdb->insert_id;
				} else {
					// @TODO Cannot insert into qas_zd_users
				}
			} else {
				$user_qas_id = $userQas['id'];
			}

			$reset_password_token = null;
			if ($user_qas_id) {
				$reset_password_token = wp_generate_password(32);

				$queryToken = "SELECT
									    id, zd_user_id, meta_key, meta_value
									FROM
									    qas_zd_usermeta
									WHERE
									    zd_user_id = '{$user_qas_id}'
									        AND meta_key = 'reset_password_token'";
				$userMeta = $wpdb->get_row($queryToken, ARRAY_A);

				if (is_null($userMeta)) {
					$dataUserMeta = array(
						'zd_user_id' => $user_qas_id,
						'meta_key' => 'reset_password_token',
						'meta_value' => $reset_password_token,
						'date_created' => \QAS\Utils::now()
					);
					$num_inserted = $wpdb->insert('qas_zd_usermeta', $dataUserMeta);
					if ($num_inserted > 0) {
						$resultObj->token = $reset_password_token;
					} else {
						// @TODO Cannot insert into qas_zd_usermeta
						$reset_password_token = null;
					}
				} else {
					$dataUserMeta = array(
						'meta_key' => 'reset_password_token',
						'meta_value' => $reset_password_token,
						'date_created' => \QAS\Utils::now()
					);
					$num_updated = $wpdb->update('qas_zd_usermeta', $dataUserMeta, array(
						'zd_user_id' => $user_qas_id
					));
					if ($num_updated > 0) {
						$resultObj->token = $reset_password_token;
					} else { // @TODO Cannot insert into qas_zd_usermeta
						$reset_password_token = null;
					}
				}

				if ($reset_password_token) {
					$reset_password_link = site_url('/new-password/');
					$reset_password_link = add_query_arg('external_id', $user_id, $reset_password_link);
					$reset_password_link = add_query_arg('token', urlencode($reset_password_token), $reset_password_link);
					$resultObj->link = $reset_password_link;

					$send_to = $email;
					$send_subject = "You want to reset password of your QASymphony account!";
					$send_body = '
<div>Dear ' . $user_name . ',</div>
<div><br>You recently requested to reset your account password.</div>
<div>Please set a new password by following the link below:</div>
<div><br></div><div><a href="' . $reset_password_link . '">' . $reset_password_link . '</a></div>
<div><br></div><div>If you have any problem, please contact us through our support forum or email us at<span style="font-size:12px">&nbsp;</span><a href="mailto:support@qasymphony.com" style="font-size:12px" target="_blank" rel="noopener">support@qasymphony.com</a></div>
<div><br></font></div><div>Cheers,</div><div>QASymphony</div>';

					$send_headers = array();
					$send_headers .= 'X-MC-Tags: support_reset_pass' . "\r\n";

					add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));

					try {
						$sent = @wp_mail($send_to, $send_subject, $send_body, $send_headers);
						$resultObj->sent = $sent;
					} catch (Exception $e) {
						$response->errors = array(
							'Your request cannot be sent now. Please try again later!'
						);
					}
				} else {
					$errors[] = array(
						'code' => 'CANNOT_GENERATE_TOKEN',
						'message' => 'Cannot generate token.'
					);
				}
			}
		} else {
			$errors[] = array(
				'code' => 'NOT_EXISTING_EMAIL',
				'message' => 'You email does not exist. Please register an Account to submit ticket to QASymphony.'
			);
		}
	} catch (Exception $e) {
		$errors[] = array(
			'code' => $e->getCode(),
			'message' => $e->getMessage()
		);
	}

	if (empty($errors)) {
		$response->success = true;
		$response->user = $resultObj;
	} else {
		$response->success = false;
		$response->errors = $errors;
	}
	die(wp_json_encode_cors_header($response));
}

add_action('wp_ajax_nopriv_qas_sp_sign_up', 'qas_sp_sign_up');
add_action('wp_ajax_qas_sp_sign_up', 'qas_sp_sign_up');

function qas_sp_sign_up()
{
	global $wpdb;
	$response = new stdClass();
	$errors = array();

	if ('POST' != $_SERVER['REQUEST_METHOD']) {
		header('Allow: POST');
		header('HTTP/1.1 405 Method Not Allowed');
		header('Content-Type: text/plain');
		exit();
	}

	$name = \QAS\Utils::getArray('name', $_POST, '');
	$email = \QAS\Utils::getArray('email', $_POST, '');
	$password = \QAS\Utils::getArray('password', $_POST, '');

	$query = "SELECT * FROM qas_zd_users WHERE email = '{$email}'";
	$userQas = $wpdb->get_row($query, ARRAY_A);

	$resultObj = new stdClass();
	if (is_null($userQas)) {
		$zd = new \QAS\zdConnector();

		$result = $zd->createUser($name, $email, $password);
		if (isset($zd->curUser) )
			$user = $zd->curUser;
		elseif ( is_array($result) && isset($result['user']) )
			$user = $result['user'];
		elseif ( $result->user )
			$user = $result->user;
		else
			$user = null;

		if (! empty($user)) {
			$user_id = $user->id;
			$result = $zd->setUserPassword($user_id, $password);

			if (! empty($result)) {
				$data = array(
					'name' => $name,
					'password' => wp_hash_password($password),
					'email' => $email,
					'date_created' => \QAS\Utils::now(),
					'qas_zd_id' => $user_id
				);

				$num_inserted = $wpdb->insert('qas_zd_users', $data);
				if (!empty($num_inserted) && $num_inserted > 0) {
					$resultObj->id = $wpdb->insert_id;
				}
				$resultObj->sso_url = generate_sso_url($name, $email);
			}
		} else {
			if ( !empty($result) && is_array($result) && isset($result['error']) && isset($result['details'])) {
				$details = $result['details'];
				foreach ($details as $key => $detail) {
					$errors[] = array(
						'code' => 'INVALID_' . strtoupper($key),
						'message' => $detail[0]["description"]
					);
				}
			} else if ( !empty($result) && is_object($result) && isset($result->error) && isset($result->details)) {
				$details = $result->details;
				foreach ($details as $key => $detail) {
					$errors[] = array(
						'code' => 'INVALID_' . strtoupper($key),
						'message' => $detail[0]->description
					);
				}
			} else  {
				// @TODO not defined error
			}
		}
	} else {
		$errors[] = array(
			'code' => 'EXISITNG_EMAIL',
			'message' => 'This is an existing account. Please login to submit a ticket.'
		);
	}

	if (empty($errors)) {
		$response->success = true;
		$response->user = $resultObj;
	} else {
		$response->success = false;
		$response->errors = $errors;
	}
	die(wp_json_encode_cors_header($response));
}
add_action('wp_ajax_nopriv_qas_sp_set_password', 'qas_sp_set_password');
add_action('wp_ajax_qas_sp_set_password', 'qas_sp_set_password');

function qas_sp_set_password()
{
	global $wpdb;
	$response = new stdClass();
	$errors = array();

	if ('POST' != $_SERVER['REQUEST_METHOD']) {
		header('Allow: POST');
		header('HTTP/1.1 405 Method Not Allowed');
		header('Content-Type: text/plain');
		exit();
	}

	$user_id = \QAS\Utils::getArray('user_id', $_POST, '');
	$email = \QAS\Utils::getArray('email', $_POST, '');
	$password = \QAS\Utils::getArray('password', $_POST, '');

	$resultObj = new stdClass();
	try {
		$zd = new \QAS\zdConnector();
		if (! empty($email)) {
			if (empty($user_id)) {
				$user = $zd->listUserByEmail($email);
				if (! empty($user)) {
					$user_id = \QAS\Utils::getArray('id', $user);
					$verified = \QAS\Utils::getArray('verified', $user);
					$last_login_at = \QAS\Utils::getArray('last_login_at', $user);
				} else {
					// @TODO cannot get user from zendesk
				}
			}

			if (! empty($user_id)) {
				$result = $zd->setUserPassword($user_id, $password);
				if (! empty($result)) {
					$name = empty($name) ? preg_replace('/(@).*/', '', $email) : $name;
					$data = array(
						'name' => $name,
						'password' => wp_hash_password($password),
						'email' => $email,
						'date_created' => \QAS\Utils::now(),
						'qas_zd_id' => $user_id
					);

					$query = "SELECT * FROM qas_zd_users WHERE email = '{$email}'";
					$userQas = $wpdb->get_row($query, ARRAY_A);

					if (is_null($userQas)) {
						$num_inserted = $wpdb->insert('qas_zd_users', $data);
						if ($num_inserted > 0) {
							$resultObj->id = $wpdb->insert_id;
						}
					} else {
						$name = $userQas['name'];
						$num_updated = $wpdb->update('qas_zd_users', $data, array(
							'email' => $email
						));
						if ($num_updated > 0) {
							$resultObj->id = $userQas['id'];
						}
					}
					$resultObj->sso_url = generate_sso_url($name, $email);
				} else {
					// @TODO cannot get user id from zendesk
				}
			}
		} else {
			// @TODO the email is required
		}
	} catch (Exception $e) {
		$errors[] = array(
			'code' => $e->getCode(),
			'message' => $e->getMessage()
		);
	}

	if (empty($errors)) {
		$response->success = true;
		$response->user = $resultObj;
	} else {
		$response->success = false;
		$response->errors = $errors;
	}
	die(wp_json_encode_cors_header($response));
}
add_action('wp_ajax_nopriv_qas_check_support_account', 'qas_check_support_account');
add_action('wp_ajax_qas_check_support_account', 'qas_check_support_account');

function qas_check_support_account()
{
	global $wpdb;
	$response = new stdClass();

	if ('POST' != $_SERVER['REQUEST_METHOD']) {
		header('Allow: POST');
		header('HTTP/1.1 405 Method Not Allowed');
		header('Content-Type: text/plain');
		exit();
	}

	$email = \QAS\Utils::getArray('email', $_POST, '');
	$name = \QAS\Utils::getArray('name', $_POST, '');

	try {
		$zd = new \QAS\zdConnector();
		$user = $zd->listUserByEmail($email);

		$resultObj = new stdClass();
		if (! empty($user)) {
			$user_id = \QAS\Utils::getArray('id', $user);
			$verified = \QAS\Utils::getArray('verified', $user);
			$last_login_at = \QAS\Utils::getArray('last_login_at', $user);

			$resultObj->id = $user_id;
			$resultObj->verified = $verified;
			$resultObj->last_login_at = $last_login_at;

			$first_time_login = false;
			if ($verified == false || is_null($last_login_at)) {
				$first_time_login = true;
			}

			if ($first_time_login) {
				$resultObj->first_time_login = $first_time_login;
			} else {
				// @TODO: password check
				$password = \QAS\Utils::getArray('password', $_POST, '');
				$query = "SELECT * FROM qas_zd_users WHERE email = '{$email}'";
				$userQas = $wpdb->get_row($query, ARRAY_A);

				if (is_null($userQas)) {
					/*
					 * @TODO call to qTest to authenticate user, if not exist ask for new password
					 */
					$isValidQtestAuthentication = false;
					if ($isValidQtestAuthentication) {} else {
						$errors[] = array(
							'code' => 'NOT_EXISTING_PASSWORD',
							'message' => 'Please enter new password to update your account with our new login gateway.'
						);
					}
				} else {
					$hash = $userQas['password'];
					$result = wp_check_password($password, $hash);
					if ($result) {
						$resultObj->sso_url = generate_sso_url($userQas['name'], $email);
					} else {
						$errors[] = array(
							'code' => 'INCORRECT_PASSWORD',
							'message' => 'Email address / password combination is incorrect, try again.'
						);
					}
				}
			}
		} else {
			$errors[] = array(
				'code' => 'NOT_EXISTING_EMAIL',
				'message' => 'You email does not exist. Please register an Account to submit ticket to QASymphony.'
			);
		}
	} catch (Exception $e) {
		$errors[] = array(
			'code' => $e->getCode(),
			'message' => $e->getMessage()
		);
	}

	if (empty($errors)) {
		$response->success = true;
		$response->user = $resultObj;
	} else {
		$response->success = false;
		$response->errors = $errors;
	}
	die(wp_json_encode_cors_header($response));
}
/**
Validate for trial form
 **/
add_action('wp_ajax_nopriv_qtest_validate_username', 'qtest_validate_username');
add_action('wp_ajax_qtest_validate_username', 'qtest_validate_username');

function qtest_validate_username() {
	$response = new stdClass();
	$errors = array();

	$resultObj = new stdClass();

	$leadData['username'] = \QAS\Utils::getArray('username', $_GET);

	$q = new \QAS\qTestConnector();
	$result = $q->validateUser($leadData);

	switch ($result['http_code']) {
		case 200:
		case 201:
			break;
		default:
			$decoded = $result['decoded'];
			$errors[] = $decoded[0];
			break;
	}

	

	if (empty($errors)) {
		$response->success = true;
		$response->user = $resultObj;
	} else {
		$response->success = false;
		$response->errors = $errors;
	}
	
	die(wp_json_encode_cors_header($response));
}

