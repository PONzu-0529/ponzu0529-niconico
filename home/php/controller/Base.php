<?php

class Base
{
  public string $version;
  public $body;


  function __construct(string $version, $body)
  {
    $this->version = $version;
    $this->body = $body;
  }
}
