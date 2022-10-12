<?php

class ModelResponseOption
{
  private string $result;
  private $response;


  function __construct(string $result, $response)
  {
    $this->result = $result;
    $this->response = $response;
  }
}
