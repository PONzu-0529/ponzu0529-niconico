<?php

class ModelResponseOption
{
  public string $result;
  public $response;


  public function __construct(string $result, $response)
  {
    $this->result = $result;
    $this->response = $response;
  }
}
