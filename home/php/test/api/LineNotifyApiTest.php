<?php

class LineNotifyApiTest
{
  public function send_success_message() {
    $ch = curl_init("http://localhost/api/v1/line-notify/send-success-message");
    $query = json_encode([
      'message' => "\nTEST SUCCESS MESSAGE"
    ]);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $response_obj = json_decode($response);
    $result = get_object_vars($response_obj);

    curl_close($ch);

    if ($result["status"] === 'success') {
      echo("Success\n");
    } else {
      echo($result['message'] . "\n");
    }
  }
}

$line_notify_api_test = new LineNotifyApiTest();
$line_notify_api_test->send_success_message();
