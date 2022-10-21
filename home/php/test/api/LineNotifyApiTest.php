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

  public function send_log_message(): ResponseStyle
  {
    $api_call_test_option = new ApiCallTestOption(
      'http://localhost/api/v1/line-notify/send-log-message',
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

    $controller_compare_result = compare_controller_response_style(
      $post_api_call_result,
      new ControllerResponseStyle(
        ControllerResponseStatusOption::SUCCESS,
        'Success Send Message.'
      )
    );

    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      $controller_compare_result->get_status() === ResponseStatusOption::SUCCESS ? LogTypeOption::LOG : LogTypeOption::ERROR,
      $controller_compare_result->get_message()
    ));

    return $controller_compare_result;
  }


  public function send_different_host_log_message(): ResponseStyle
  {
    switch (Utils::get_environment()) {
      case EnvConstants::LOCAL:
        $url = 'http://httpd/api/v1/line-notify/send-log-message';
        break;

      case EnvConstants::DEVELOP:
        $url = 'https://dev-tools.ponzu0529.com/api/v1/line-notify/send-log-message';
        break;

      case EnvConstants::MASTER:
        $url = 'https://tools.ponzu0529.com/api/v1/line-notify/send-log-message';
        break;

      default:
        $url = '';
    }

    $api_call_test_option = new ApiCallTestOption(
      $url,
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

    $controller_compare_result = compare_controller_response_style(
      $post_api_call_result,
      new ControllerResponseStyle(
        ControllerResponseStatusOption::FAILURE,
        'This Network is not Accepted.'
      )
    );

    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      $controller_compare_result->get_status() === ResponseStatusOption::SUCCESS ? LogTypeOption::LOG : LogTypeOption::ERROR,
      $controller_compare_result->get_message()
    ));

    return $controller_compare_result;
  }


  public function send_different_version_log_message(): ResponseStyle
  {
    $api_call_test_option = new ApiCallTestOption(
      'http://localhost/api/v0/line-notify/send-log-message',
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

    $controller_compare_result = compare_controller_response_style(
      $post_api_call_result,
      new ControllerResponseStyle(
        ControllerResponseStatusOption::FAILURE,
        'Version v0 is not accepted.'
      )
    );

    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      $controller_compare_result->get_status() === ResponseStatusOption::SUCCESS ? LogTypeOption::LOG : LogTypeOption::ERROR,
      $controller_compare_result->get_message()
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
