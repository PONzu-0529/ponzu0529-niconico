<?php

require_once __DIR__ . '/LineNotifyData.php';

class LineNotifyDataMock extends LineNotifyData
{
  public function __construct()
  {
    parent::__construct();

    $this->access_token_list['log'] = 'LOG_ACCESS_TOKEN';
    $this->access_token_list['alert'] = 'ALERT_ACCESS_TOKEN';
    $this->access_token_list['error'] = 'ERROR_ACCESS_TOKEN';
    $this->access_token_list['success'] = 'SUCCESS_ACCESS_TOKEN';
  }
}
