<?php

require_once __DIR__ . "/Base.php";

require_once __DIR__ . '/../service/AuthService.php';
require_once __DIR__ . '/../service/LoggingService.php';

class AuthController extends ControllerBase
{
  private const SERVICE_NAME = 'AuthController';
  private const ALLOW_VERSION_LIST = ['v2'];


  function GetAccessTokenByEmail()
  {
    return $this->common_response('get_access_token_by_email');
  }


  function CheckAccessToken()
  {
    return $this->common_response('check_access_token');
  }


  private function common_response(string $function_name)
  {
    static::record_start();

    // Validate Version
    if (!$this->check_version(static::ALLOW_VERSION_LIST)) {
      return static::return_error("Version $this->version is not accepted.");
    }

    // Validate Email
    if (in_array($function_name, ['get_access_token_by_email'], true)) {
      if (!$this->check_body('email')) {
        return static::return_error('Parameter "email" is not set.');
      }

      $email = $this->body['email'];
    }

    // Validate Password
    if (in_array($function_name, ['get_access_token_by_email'], true)) {
      if (!$this->check_body('password')) {
        return static::return_error('Parameter "password" is not set.');
      }

      $password = $this->body['password'];
    }

    // Validate AccessToken
    if (in_array($function_name, ['check_access_token'], true)) {
      if (!$this->check_body('accessToken')) {
        return static::return_error('Parameter "accessToken" is not set.');
      }

      $access_token = $this->body['accessToken'];
    }

    // Call Function
    $auth_service = new AuthService();
    switch ($function_name) {
      case 'get_access_token_by_email':
        $get_all_data_response = $auth_service->$function_name($email, $password);
        break;

      case 'check_access_token':
        $get_all_data_response = $auth_service->$function_name($access_token);
        break;

      default:
        $get_all_data_response = $auth_service->$function_name();
        break;
    }

    if ($get_all_data_response->get_status() !== ResponseStatusOption::SUCCESS) {
      return static::return_error(strval($get_all_data_response->get_data()));
    }

    static::record_finish();

    return new ControllerResponseStyle(
      ControllerResponseStatusOption::SUCCESS,
      $get_all_data_response->get_data()
    );
  }


  private static function return_error(string $error_message): ControllerResponseStyle
  {
    static::record_error($error_message);

    return new ControllerResponseStyle(
      ControllerResponseStatusOption::FAILURE,
      $error_message
    );
  }


  private static function record(string $log): void
  {
    LoggingService::record(static::SERVICE_NAME, $log);
  }


  private static function record_error(string $log): void
  {
    LoggingService::record_error(static::SERVICE_NAME, $log);
  }


  private static function record_start(): void
  {
    static::record('Start Controller.');
  }


  private static function record_finish(): void
  {
    static::record('Finish Controller.');
  }
}
