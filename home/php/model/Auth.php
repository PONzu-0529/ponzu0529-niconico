<?php

class Auth
{
  function GetAccessToken(string $user_name, string $user_password)
  {
    require __DIR__ . "/../config/config.php";

    // connect MySQL
    $mysqli = new mysqli($hostname, $username, $password, $database);

    // check name
    $result = $mysqli->query(
      "
        SELECT
          name
        FROM
          user_accounts
        WHERE
          name = '$user_name'
        ;
      "
    );

    $result_array = $result->fetch_all();

    if (count($result_array) === 0) {
      return [
        "status" => "failure",
        "message" => "$user_name is not registered."
      ];
    }

    // set user_account_id
    $result = $mysqli->query(
      "
        SELECT
          id
        FROM
          user_accounts
        WHERE
          name = '$user_name'
        ;
      "
    );

    $user_account_id = $result->fetch_assoc()['id'];

    // check password
    $result = $mysqli->query(
      "
        SELECT
          password_hash
        FROM
          user_accounts
        WHERE
          name = '$user_name'
        ;
      "
    );

    $password_hash = $result->fetch_assoc()['password_hash'];

    if (hash('sha256', $user_password) !== $password_hash) {
      return [
        'status' => 'failure',
        'message' => 'password is wrong.'
      ];
    }

    // create AccessToken
    $today = new DateTime();

    $access_token = hash('sha256', $user_name . $today->format('Y-m-d H:i:s'));

    $result = $mysqli->query(
      "
        INSERT INTO `user_account_access_token` 
          (`user_account_id`, `access_token`, `created_at`, `updated_at`)
        VALUES
          ($user_account_id, '$access_token', now(), now())
        ;
      "
    );

    return [
      'status' => 'success',
      'access_token' => $access_token
    ];
  }


  function CheckAccessToken(string $access_token)
  {
    require __DIR__ . '/../config/config.php';

    // Connect MySQL
    $mysqli = new mysqli($hostname, $username, $password, $database);

    // Check AccessToken
    $result = $mysqli->query(
      "
        SELECT
          access_token
        FROM
          user_account_access_token
        WHERE
          access_token = '$access_token'
        ;
      "
    );

    $result_array = $result->fetch_all();

    if (count($result_array) === 0) {
      return [
        "status" => "failure",
        "message" => "This AccessToken is not registered."
      ];
    }

    // Check Timeout
    $result = $mysqli->query(
      "
        SELECT
          created_at
        FROM
          user_account_access_token
        WHERE
          access_token = '$access_token'
        ;
      "
    );

    $created_at = new DateTime($result->fetch_assoc()["created_at"]);

    $today = new DateTime();

    if ($today < $created_at->modify("+1 day")) {
      return [
        "status" => "success"
      ];
    } else {
      return [
        "status" => "failed",
        "message" => "This AccessToken Timeout."
      ];
    }
  }
}
