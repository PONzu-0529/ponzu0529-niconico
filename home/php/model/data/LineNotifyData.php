<?php

class LineNotifyData
{
  public array $access_token_list = [];


  function __construct()
  {
    $this->access_token_list = [
      'log' => '',
      'alert' => '',
      'error' => '',
      'success' => ''
    ];
  }
}
