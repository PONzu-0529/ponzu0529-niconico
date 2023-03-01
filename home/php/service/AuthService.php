<?php

require_once __DIR__ . '/../common/LogOptions.php';
require_once __DIR__ . '/../common/ResponseStyle.php';

require_once __DIR__ . '/ServiceBase.php';
require_once __DIR__ . '/../model/db/UserAccounts.php';
require_once __DIR__ . '/../model/db/UserAccountAccessToken.php';

require_once __DIR__ . '/../model/data/AuthData.php';

require_once __DIR__ . '/../service/AuthService.php';
require_once __DIR__ . '/../service/LoggingService.php';


class AuthService extends ServiceBase
{
  const SERVICE_NAME = 'AuthService';

  private UserAccounts $user_accounts;
  private UserAccountAccessToken $user_account_access_token;


  public function __construct()
  {
    parent::__construct();
    $this->user_accounts = new UserAccounts();
    $this->user_account_access_token = new UserAccountAccessToken();
  }


  public function get_access_token_by_email(string $email, string $password): ResponseStyle
  {
    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      LogTypeOption::LOG,
      'Start Service "Get Access Token By Email".'
    ));

    $id = $this->user_accounts->get_id_by_email($email);

    if ($id === -1) {
      $this->logging_service->record_log(new LogStyle(
        $this::SERVICE_NAME,
        LogTypeOption::ERROR,
        "\"$email\" is not registered."
      ));

      return new ResponseStyle(
        ResponseStatusOption::FAILURE,
        "ERROR: \"$email\" is not registered."
      );
    }

    $result_check_password = $this->check_password($id, $password);

    if ($result_check_password !== '') {
      $this->logging_service->record_log(new LogStyle(
        $this::SERVICE_NAME,
        LogTypeOption::ERROR,
        $result_check_password
      ));

      return new ResponseStyle(
        ResponseStatusOption::FAILURE,
        $result_check_password
      );
    }

    $access_token = $this->create_access_token($id);

    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      LogTypeOption::LOG,
      'Finish Service "Get Access Token By Email".'
    ));

    return new ResponseStyle(
      ResponseStatusOption::SUCCESS,
      $access_token
    );
  }


  public static function check_access_token(string $access_token): ResponseStyle
  {
    static::record_start();

    $check_access_token_response = AuthData::check_access_token($access_token);

    if ($check_access_token_response->get_status() !== ResponseStatusOption::SUCCESS) {
      return static::return_error(strval($check_access_token_response->get_data()));
    }

    $data = $check_access_token_response->get_data();
    $created_at = $data->get_created_at();

    // Check CreateTime
    $today = new DateTime('now', new DateTimeZone('Asia/Tokyo'));

    if ($today->modify('-1 day') > $created_at) {
      return static::return_error('This AccessToken Timeout.');
    }

    static::record_finish();

    return new ResponseStyle(
      ResponseStatusOption::SUCCESS,
      $check_access_token_response->get_data()
    );
  }


  public function check_access_token_by_email(string $email, string $user_access_token)
  {
    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      LogTypeOption::LOG,
      'Start Service "Check Access Token".'
    ));

    $id = $this->user_accounts->get_id_by_email($email);

    if ($id === -1) {
      $this->logging_service->record_log(new LogStyle(
        $this::SERVICE_NAME,
        LogTypeOption::ERROR,
        "\"$email\" is not registered."
      ));

      return new ResponseStyle(
        ResponseStatusOption::FAILURE,
        "ERROR: \"$email\" is not registered."
      );
    }

    $access_token = $this->user_account_access_token->get_access_token_by_user_account_id($id);

    if ($access_token === '') {
      $this->logging_service->record_log(new LogStyle(
        $this::SERVICE_NAME,
        LogTypeOption::ERROR,
        'The AccessToken is unauthorized.'
      ));

      return new ResponseStyle(
        ResponseStatusOption::FAILURE,
        'ERROR: The AccessToken is unauthorized.'
      );
    }

    if ($user_access_token !== $access_token) {
      $this->logging_service->record_log(new LogStyle(
        $this::SERVICE_NAME,
        LogTypeOption::ERROR,
        'The AccessToken is unauthorized.'
      ));

      return new ResponseStyle(
        ResponseStatusOption::FAILURE,
        'ERROR: The AccessToken is unauthorized.'
      );
    }

    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      LogTypeOption::LOG,
      'Finish Service "Check Access Token".'
    ));

    return new ResponseStyle(
      ResponseStatusOption::SUCCESS,
      'Success Authorized.'
    );
  }


  private function check_password(int $id, string $password): string
  {
    $password_hash = $this->user_accounts->get_password_hash_by_id($id);

    if ($password_hash === '') {
      return 'ERROR: Password is not registered.';
    }

    if ($this->get_password_hash($password) !== $password_hash) {
      return 'ERROR: Password is wrong.';
    }

    return "";
  }


  private function get_password_hash($password): string
  {
    return hash('sha256', $password);
  }


  private function create_access_token(int $id): string
  {
    $today = new DateTime('now', new DateTimeZone('Asia/Tokyo'));

    $access_token = hash('sha256', strval($id * 39) . $today->format('Y-m-d H:i:s'));

    $this->user_account_access_token->insert_access_token(
      $id,
      $access_token
    );

    return $access_token;
  }


  private static function return_error(string $error_message): ResponseStyle
  {
    static::record_error($error_message);

    return new ResponseStyle(
      ResponseStatusOption::FAILURE,
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
    static::record('Start Service.');
  }


  private static function record_finish(): void
  {
    static::record('Finish Service.');
  }
}
