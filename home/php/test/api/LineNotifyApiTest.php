<?php

require_once __DIR__ . '/../../controller/Base.php';


class LineNotifyApiTest
{
  private ResponseStatusOption $response_status_option;


  public function __construct()
  {
    $this->response_status_option = new ResponseStatusOption();
  }


  public function success_send_message()
  {
    echo $this->common_test_setting(new CommonTestSettingOption(
      'http://localhost/api/v1/line-notify/send-success-message',
      'API TEST: Success Message.',
      $this->response_status_option->success,
      'Success Send Message.'
    ));
  }


  public function success_different_host()
  {
    echo $this->common_test_setting(new CommonTestSettingOption(
      'http://httpd/api/v1/line-notify/send-success-message',
      'API TEST: Success Message.',
      $this->response_status_option->failure,
      'This Network is not Accepted.'
    ));
  }


  public function success_different_version()
  {
    echo $this->common_test_setting(new CommonTestSettingOption(
      'http://localhost/api/v0/line-notify/send-success-message',
      'API TEST: Success Message.',
      $this->response_status_option->failure,
      'Version v0 is not accepted.'
    ));
  }


  private function common_test_setting(CommonTestSettingOption $common_test_setting_option)
  {
    $ch = curl_init($common_test_setting_option->url);
    $query = json_encode([
      'message' => $common_test_setting_option->send_message
    ]);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $response_obj = json_decode($response);
    $result = get_object_vars($response_obj);

    curl_close($ch);

    if ($result["status"] !== $common_test_setting_option->result_status) {
      return 'ERROR: ' . $result["status"] . " is not $common_test_setting_option->result_status.\n";
    }

    if ($result["message"] !== $common_test_setting_option->result_message) {
      return 'ERROR: \'' . $result["message"] . "' is not '$common_test_setting_option->result_message'.\n";
    }

    return "SUCCESS.\n";
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


$line_notify_api_test = new LineNotifyApiTest();

# Success
$line_notify_api_test->success_send_message();
$line_notify_api_test->success_different_host();
$line_notify_api_test->success_different_version();
