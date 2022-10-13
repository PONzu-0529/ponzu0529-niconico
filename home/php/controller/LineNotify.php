<?php

require_once __DIR__ . '/Base.php';
require_once __DIR__ . '/../model/LineNotifyModel.php';
require_once __DIR__ . '/../model/data/LineNotifyData.php';


class LineNotifyController extends Base
{
  private LineNotifyModel $line_notify_model;


  public function __construct(string $host, string $version, $body)
  {
    parent::__construct($host, $version, $body);

    $this->ALLOW_VERSION_LIST = ['v1'];

    $line_notify_data = new LineNotifyData();
    $line_notify_data->set_all_data();
    $this->line_notify_model = new LineNotifyModel($line_notify_data);
  }


  public function SendSuccessMessage(): ResponseStyle
  {
    // Validate Host
    if (!$this->check_localhost()) {
      return new ResponseStyle(
        'failure',
        "This Network is not Accepted."
      );
    }

    // Validate Version
    if (!$this->check_version()) {
      return new ResponseStyle(
        'failure',
        "Version $this->version is not accepted."
      );
    }

    // Validate Body Message
    if (!$this->check_body_message()) {
      return new ResponseStyle(
        'failure',
        'Parameter \'Message\' is not set.'
      );
    }

    // Send Message
    $result = $this->line_notify_model->send_message(new LineNotifySendMessageOption(
      'success',
      $this->body['message']
    ));

    if ($result->result === 'success') {
      return new ResponseStyle(
        'success',
        $result->response
      );
    } else {
      return new ResponseStyle(
        'failure',
        $result->response
      );
    }
  }


  private function check_body_message(): bool
  {
    return isset($this->body['message']);
  }
}
