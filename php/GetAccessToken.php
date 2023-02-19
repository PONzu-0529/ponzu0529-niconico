<?php

require __DIR__ . '/config/config.php';

// Define
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

$body = file_get_contents("php://input");
$body_array = json_decode($body, true);

// Connect MySQL
$mysqli = new mysqli($hostname, $username, $password, $database);

// Check name
$result = $mysqli->query(
  "SELECT name FROM user_accounts;"
);

$result_array = $result->fetch_all(MYSQLI_NUM);

if (!in_array([$body_array['name']], $result_array)) {
  echo json_encode([
    'status' => 'failed',
    'message' => $body_array['name'] . ' is not registered.'
  ]);

  return;
}

// Set id
$result = $mysqli->query(
  "SELECT id FROM user_accounts WHERE name = '" . $body_array['name'] . "';"
);

$user_account_id = $result->fetch_assoc()['id'];

// Check password
$result = $mysqli->query(
  "SELECT password_hash FROM user_accounts WHERE name = '" . $body_array['name'] . "';"
);

$password_hash = $result->fetch_assoc()['password_hash'];

if (hash('sha256', $body_array['password']) !== $password_hash) {
  echo json_encode([
    'status' => 'failed',
    'message' => 'password is wrong.'
  ]);

  return;
}

// Create AccessToken
$today = new DateTime();

$access_token = hash('sha256', $body_array['name'] . $today->format('Y-m-d H:i:s'));

$result = $mysqli->query(
  "INSERT INTO `user_account_access_token` (`user_account_id`, `access_token`, `created_at`, `updated_at`) VALUES (" . $user_account_id . ", '" . $access_token . "', now(), now());"
);

echo json_encode([
  'status' => 'success',
  'access_token' => $access_token
]);
