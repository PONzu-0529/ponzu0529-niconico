<?php

require_once __DIR__ . '/../common/LogOptions.php';

require_once __DIR__ . '/ServiceBase.php';
require_once __DIR__ . '/../model/db/UserAccounts.php';
require_once __DIR__ . '/../model/db/UserAccountAccessToken.php';


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


  public function get_access_token_by_email(string $email, string $password): ServiceResponse
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

      return new ServiceResponse(
        ServiceResultOption::FAILURE,
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

      return new ServiceResponse(
        ServiceResultOption::FAILURE,
        $result_check_password
      );
    }

    $access_token = $this->create_access_token($id);

    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      LogTypeOption::LOG,
      'Finish Service "Get Access Token By Email".'
    ));

    return new ServiceResponse(
      ServiceResultOption::SUCCESS,
      $access_token
    );
  }


  public function check_access_token(string $email, string $user_access_token)
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

      return new ServiceResponse(
        ServiceResultOption::FAILURE,
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

      return new ServiceResponse(
        ServiceResultOption::FAILURE,
        'ERROR: The AccessToken is unauthorized.'
      );
    }

    if ($user_access_token !== $access_token) {
      $this->logging_service->record_log(new LogStyle(
        $this::SERVICE_NAME,
        LogTypeOption::ERROR,
        'The AccessToken is unauthorized.'
      ));

      return new ServiceResponse(
        ServiceResultOption::FAILURE,
        'ERROR: The AccessToken is unauthorized.'
      );
    }

    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      LogTypeOption::LOG,
      'Finish Service "Check Access Token".'
    ));

    return new ServiceResponse(
      ServiceResultOption::SUCCESS,
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
    $today = new DateTime();

    $access_token = hash('sha256', strval($id * 39) . $today->format('Y-m-d H:i:s'));

    $this->user_account_access_token->insert_access_token(
      $id,
      $access_token
    );

    return $access_token;
  }
}
