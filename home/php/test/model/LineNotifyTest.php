<?php

require_once __DIR__ . '/../../model/LineNotifyModel.php';
require_once __DIR__ . '/../../model/data/LineNotifyData.php';
require_once __DIR__ . '/../../model/data/LineNotifyDataMock.php';

class LineNotifyTest
{
  private LineNotifyModel $line_notify_model;

  public function __construct()
  {
    $this->line_notify_model = new LineNotifyModel(new LineNotifyDataMock);
  }
}

$line_notify_test = new LineNotifyTest();
