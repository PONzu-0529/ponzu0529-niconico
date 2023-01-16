<?php

require_once __DIR__ . '/ApiTestBase.php';

require_once __DIR__ . '/../../common/LogOptions.php';
require_once __DIR__ . '/../../common/ResponseStyle.php';
require_once __DIR__ . '/../../common/Utils.php';

require_once __DIR__ . '/../../controller/Base.php';
require_once __DIR__ . '/../../service/ServiceBase.php';


class LineNotifyApiTest extends ApiTestBase
{
  const SERVICE_NAME = 'LineNotifyApiTest';

  private string $host;

  public function __construct()
  {
    parent::__construct();

    switch (Utils::get_environment()) {
      case EnvConstants::LOCAL:
        $this->host = 'http://127.0.0.1';
        break;

      case EnvConstants::DEVELOP:
        $this->host = 'https://dev-tools.ponzu0529.com';
        break;

      case EnvConstants::MASTER:
        $this->host = 'https://tools.ponzu0529.com';
        break;

      default:
        $this->host = '';
    }
  }

  public function send_log_message(): ResponseStyle
  {
    $api_call_test_option = new ApiCallTestOption(
      "$this->host/api/v1/line-notify/send-log-message",
      [
        'message' => 'API TEST: Send Log Message.'
      ]
    );

    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      LogTypeOption::LOG,
      'Start Service.'
    ));

    $post_api_call_result = $this->post_api_call_test($api_call_test_option);

    $controller_compare_result = Utils::compare_response_style(
      $post_api_call_result,
      new ResponseStyle(
        ResponseStatusOption::SUCCESS,
        get_object_vars(
          new ControllerResponseStyle(
            ControllerResponseStatusOption::SUCCESS,
            'Success Send Message.'
          )
        )
      )
    );

    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      $controller_compare_result->get_status() === ResponseStatusOption::SUCCESS ? LogTypeOption::LOG : LogTypeOption::ERROR,
      strval($controller_compare_result->get_data())
    ));

    return $controller_compare_result;
  }


  public function send_different_host_log_message(): ResponseStyle
  {
    $api_call_test_option = new ApiCallTestOption(
      'https://dev-tools.ponzu0529.com/api/v1/line-notify/send-log-message',
      [
        'message' => 'API TEST: Send Log Message.'
      ]
    );

    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      LogTypeOption::LOG,
      'Start Service.'
    ));

    $post_api_call_result = $this->post_api_call_test($api_call_test_option);

    $controller_compare_result = Utils::compare_response_style(
      $post_api_call_result,
      new ResponseStyle(
        ResponseStatusOption::SUCCESS,
        get_object_vars(
          new ControllerResponseStyle(
            ControllerResponseStatusOption::FAILURE,
            'This IP Address is not Accepted.'
          )
        )
      )
    );

    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      $controller_compare_result->get_status() === ResponseStatusOption::SUCCESS ? LogTypeOption::LOG : LogTypeOption::ERROR,
      strval($controller_compare_result->get_data())
    ));

    return $controller_compare_result;
  }


  public function send_different_version_log_message(): ResponseStyle
  {
    $api_call_test_option = new ApiCallTestOption(
      "$this->host/api/v0/line-notify/send-log-message",
      [
        'message' => 'API TEST: Send Log Message.'
      ]
    );

    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      LogTypeOption::LOG,
      'Start Service.'
    ));

    $post_api_call_result = $this->post_api_call_test($api_call_test_option);

    $controller_compare_result = Utils::compare_response_style(
      $post_api_call_result,
      new ResponseStyle(
        ResponseStatusOption::SUCCESS,
        get_object_vars(
          new ControllerResponseStyle(
            ControllerResponseStatusOption::FAILURE,
            'Version v0 is not accepted.'
          )
        )
      )
    );

    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      $controller_compare_result->get_status() === ResponseStatusOption::SUCCESS ? LogTypeOption::LOG : LogTypeOption::ERROR,
      strval($controller_compare_result->get_data())
    ));

    return $controller_compare_result;
  }
}


class CommonTestSettingOption
{
  public string $url;
  public string $send_message;
  public string $result_status;
  public string $result_message;


  public function __construct(string $url, string $send_message, string $result_status, string $result_message)
  {
    $this->url = $url;
    $this->send_message = $send_message;
    $this->result_status = $result_status;
    $this->result_message = $result_message;
  }
}
