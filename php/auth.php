<?php

function get_access_token($name, $user_password)
{
  require_once __DIR__ . '/config/config.php';

  // Connect MySQL
  $mysqli = new mysqli($hostname, $username, $password, $database);

  // Check name
  $result = $mysqli->query(
    "SELECT name FROM user_accounts;"
  );

  $result_array = $result->fetch_all(MYSQLI_NUM);

  if (!in_array([$name], $result_array)) {
    return json_encode([
      'status' => 'failed',
      'message' => $name . ' is not registered.'
    ]);
  }

  // Set id
  $result = $mysqli->query(
    "SELECT id FROM user_accounts WHERE name = '" . $name . "';"
  );

  $user_account_id = $result->fetch_assoc()['id'];

  // Check password
  $result = $mysqli->query(
    "SELECT password_hash FROM user_accounts WHERE name = '" . $name . "';"
  );

  $password_hash = $result->fetch_assoc()['password_hash'];

  if (hash('sha256', $user_password) !== $password_hash) {
    return json_encode([
      'status' => 'failed',
      'message' => 'password is wrong.'
    ]);
  }

  // Create AccessToken
  $today = new DateTime();

  $access_token = hash('sha256', $name . $today->format('Y-m-d H:i:s'));

  $result = $mysqli->query(
    "INSERT INTO `user_account_access_token` (`user_account_id`, `access_token`, `created_at`, `updated_at`) VALUES (" . $user_account_id . ", '" . $access_token . "', now(), now());"
  );

  return json_encode([
    'status' => 'success',
    'access_token' => $access_token
  ]);
}

function check_access_token($access_token)
{
  require __DIR__ . '/config/config.php';

  // Connect MySQL
  $mysqli = new mysqli($hostname, $username, $password, $database);

  // Check AccessToken
  $result = $mysqli->query(
    "SELECT access_token FROM user_account_access_token;"
  );

  $result_array = $result->fetch_all(MYSQLI_NUM);

  if (!in_array([$access_token], $result_array)) {
    return json_encode([
      'status' => 'failed',
      'message' => 'This AccessToken is not registered.'
    ]);
  }

  // Check Timeout
  $result = $mysqli->query(
    "SELECT created_at FROM user_account_access_token WHERE access_token = '" . $access_token . "';"
  );

  $created_at = new DateTime($result->fetch_assoc()['created_at']);

  $today = new DateTime();

  if ($today < $created_at->modify('+1 day')) {
    return json_encode([
      'status' => 'success'
    ]);
  } else {
    return json_encode([
      'status' => 'failed',
      'message' => 'This AccessToken Timeout.'
    ]);
  }
}
