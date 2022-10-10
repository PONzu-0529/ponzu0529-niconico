<?php

require __DIR__ . "/Base.php";
require __DIR__ . "/../model/Auth.php";

class AuthController extends Base
{
  function GetAccessToken()
  {
    // validate version
    if (!in_array($this->version, ["v1"])) {
      return [
        "status" => "failure",
        "message" => "Version $this->version is not accepted."
      ];
    }

    // validate body
    if (!isset($this->body["name"])) {
      return [
        "status" => "failure",
        "message" => "Parameter 'name' is not set."
      ];
    } else if (!isset($this->body["password"])) {
      return [
        "status" => "failure",
        "message" => "Parameter 'password' is not set."
      ];
    }

    // define
    $user_name = $this->body["name"];
    $user_password = $this->body["password"];
    $auth = new Auth();

    // get AccessToken
    $result = $auth->GetAccessToken($user_name, $user_password);

    return $result;
  }


  function CheckAccessToken()
  {
    // validate version
    if (!in_array($this->version, ["v1"])) {
      return [
        "status" => "failure",
        "message" => "Version $this->version is not accepted."
      ];
    }

    // validate body
    if (!isset($this->body["accessToken"])) {
      return [
        "status" => "failure",
        "message" => "Parameter 'accessToken' is not set."
      ];
    }

    // define
    $access_token = $this->body["accessToken"];
    $auth = new Auth();

    // check AccessToken
    $result = $auth->CheckAccessToken($access_token);

    return $result;
  }
}
