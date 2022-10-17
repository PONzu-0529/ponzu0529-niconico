<?php

require_once __DIR__ . '/BaseServiceTest.php';
require_once __DIR__ . '/../../service/AuthService.php';
require_once __DIR__ . '/../../service/ServiceBase.php';


class AuthServiceTest extends BaseServiceTest
{
  private AuthService $auth_service;


  public function __construct()
  {
    parent::__construct();
    $this->auth_service = new AuthService();
  }


  public function get_access_token_by_email(): void
  {
    $service_response = $this->auth_service->get_access_token_by_email('test@tools.ponzu0529.com', 'test_password');

    if ($service_response->result !== 'success') {
      echo ("ERROR: $service_response->result is not success.\n");
    } else {
      echo ("SUCCESS. AccessToken: $service_response->response\n");
    }
  }


  public function get_access_token_by_dummy_email(): void
  {
    $service_response = $this->auth_service->get_access_token_by_email('dummy@tools.ponzu0529.com', 'test_password');

    echo $this->common_service_response_test(
      $service_response,
      new ServiceResponse(
        $this->service_result_option->failure,
        'ERROR: "dummy@tools.ponzu0529.com" is not registered.'
      )
    );
  }


  public function get_access_token_by_dummy_password(): void
  {
    $service_response = $this->auth_service->get_access_token_by_email('test@tools.ponzu0529.com', 'dummy_password');

    echo $this->common_service_response_test(
      $service_response,
      new ServiceResponse(
        $this->service_result_option->failure,
        'ERROR: Password is wrong.'
      )
    );
  }


  public function check_access_token(): void
  {
    $service_response = $this->auth_service->check_access_token('access_token_test@tools.ponzu0529.com', 'test_access_token');

    echo $this->common_service_response_test(
      $service_response,
      new ServiceResponse(
        $this->service_result_option->success,
        'Success Authorized.'
      )
    );
  }


  public function check_access_token_by_dummy_email(): void
  {
    $service_response = $this->auth_service->check_access_token('dummy@tools.ponzu0529.com', 'test_access_token');

    echo $this->common_service_response_test(
      $service_response,
      new ServiceResponse(
        $this->service_result_option->failure,
        'ERROR: "dummy@tools.ponzu0529.com" is not registered.'
      )
    );
  }


  public function check_dummy_access_token(): void
  {
    $service_response = $this->auth_service->check_access_token('access_token_test@tools.ponzu0529.com', 'dummy_access_token');

    echo $this->common_service_response_test(
      $service_response,
      new ServiceResponse(
        $this->service_result_option->failure,
        'ERROR: The AccessToken is unauthorized.'
      )
    );
  }


  public function check_old_access_token(): void
  {
    $service_response = $this->auth_service->check_access_token('access_token_test@tools.ponzu0529.com', 'old_access_token');

    echo $this->common_service_response_test(
      $service_response,
      new ServiceResponse(
        $this->service_result_option->failure,
        'ERROR: The AccessToken is unauthorized.'
      )
    );
  }
}


$auth_service_test = new AuthServiceTest();

$auth_service_test->get_access_token_by_email();
$auth_service_test->get_access_token_by_dummy_email();
$auth_service_test->get_access_token_by_dummy_password();
$auth_service_test->check_access_token();
$auth_service_test->check_access_token_by_dummy_email();
$auth_service_test->check_dummy_access_token();
$auth_service_test->check_old_access_token();
